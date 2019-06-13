<?php
class Api extends CI_Controller {
  public function __construct() {
    parent::__construct();

    $this->load->model('user_model');
    $this->load->model('ban_model');

    $this->load->helper('string');
  }

  public function login() {
    $methods = array('get', 'post');
    $method = $this->input->method();

    $this->response = 0;

    if(!in_array($method, $methods))
      $this->respond();

    $username = $this->input->$method('username');
    $password = $this->input->$method('password');
    $captcha  = $this->input->$method('captcha');

    if(empty($username) || empty($password) || empty($captcha))
      $this->respond();

    $User = $this->user_model->fetch_user_by('Username', $username, 'ID, Username, Password, Rank, Friends');

    if(empty($User))
      $this->respond(2);

    if(!password_verify($password, $User->Password))
      $this->respond(2);

    $isBanned = false;
    $banDuration = null;

    $Bans = $this->ban_model->fetch_bans_by('User', $User->ID);

    foreach($Bans as $Ban) {
      $ban_id = $Ban->ID;
      $banLength = $Ban->Length;

      $banTime = strtotime($Ban->Date);
      $currentTime = strtotime("now");

      $durationInSeconds = $banLength * 60 * 60;

      if((isset($banLength) && $banLength != 999) && (($currentTime - $banTime) >= $durationInSeconds))
        $this->ban_model->deactivate($ban_id);
      else {
        $isBanned = TRUE;
        $banDuration = $banLength;

        break;
      }
    }

    if($isBanned === TRUE)
      $this->respond(['login' => 3, 'hours' => $banDuration]);

    if(!$this->validateCaptcha($captcha))
      $this->respond();

    $this->response = 1;

    $loginKey = $this->generateLoginKey();
    $sessionKey = str_insert($User->ID, $loginKey, strlen($loginKey) / 2);
    $sessionKey = str_insert($User->Username, $sessionKey, strlen($sessionKey));
    $sessionKey = md5($sessionKey);

    $this->user_model->update(['LoginKey' => $loginKey, 'SessionKey' => $sessionKey], ['ID' => $User->ID]);

    $redisHost = $this->config->item('redis_host');
    $redisPort = $this->config->item('redis_port');
    $redisPass = $this->config->item('redis_pass');

    $redis = new Redis();
    $redis->connect($redisHost, $redisPort);

    if(!empty($redisPass)) {
      if($redis->auth($redisPass) !== TRUE)
        return $this->respond();
    }

    $servers = $redis->get('servers');
    $servers = json_decode($servers);
    $buddies = explode(',', $User->Friends);

    foreach($servers as $key => &$server) {
      if(isset($server->rank)) {
        $serverRank = $server->rank;

        if(!empty($serverRank) && $serverRank != '*') {
          if($User->Rank < $serverRank) {
            unset($servers->$key);

            continue;
          }
        }
      }

      $server->users = $redis->get($server->id . '.population');

      $players = $redis->get($server->id . '.players');
      $players = json_decode($players);

      $server->buddies = 0;

      foreach($buddies as $buddy) {
        if(in_array($buddy, $players))
          $server->buddies++;
      }
    }

    $this->respond([
      'login' => 1,
      'playerkey' => $loginKey,
      'playerid' => $User->ID,
      'playerkey2' => $sessionKey,
      'username' => $User->Username,
      'servers' => json_encode($servers)
    ]);
  }

  private function respond($myData = 0) {
    $data = array();

    if(is_numeric($myData))
      $data['login'] = $myData;
    elseif(is_array($myData))
      $data = array_merge($data, $myData);

    if(isset($this->response) && !empty($this->response) && !array_key_exists('login', $data))
      $data['login'] = $this->response;

    die(http_build_query($data));
  }

  private function generateLoginKey() {
    $keyLength = mt_rand(7, 10);

    return random_string('alnum', $keyLength);
  }

  private function validateCaptcha($res) {
    $secretKey = $this->config->item('recaptcha_secret_key');

    $ch = curl_init();
    $data = array(
      'secret' => $secretKey,
      'response' => $res,
      'remoteip' => $this->input->ip_address()
    );

    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $response = json_decode($response);

    if($response === false)
      throw new Exception(curl_error($ch), curl_errno($ch));

    return $response->success;
  }
}