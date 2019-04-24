<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Create extends CI_Controller {
  public function __construct() {
    parent::__construct();

    $this->load->database();
    $this->load->model('user_model');

    $this->cooldown = $this->config->item('registration_cooldown');
    $this->maxRegistrations = $this->config->item('max_registrations');
  }

  private function respond($res) {
    die('status=' . strtoupper($res));
  }

  private function retrieveData($key, $strict = true) {
    $data = $this->input->post($key);

    if(!empty($data))
      return $data;

    if($strict !== FALSE)
      response('error');

    return NULL;
  }

  private function validateName($name) {
    $blockedNicks = array('fuck', 'cock', 'c0ck', 'whore', 'wh0re', 'wh0r3', 'bitch', 'b!tch','fuk', 'slut', 's!ut', 'shit', 'sh!t', 'fatass', 'fatty', 'gay', 'homosexual', 'bisexual', 'sex', 's3x');

    if(empty($name))
      return '';
    elseif(strlen($name) < 4)
      return 'short';
    elseif(in_array($name, $blockedNicks))
      return 'bad_name';
    elseif(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $name))
      return 'bad_name';
    elseif(preg_match('/\s/', $name))
      return 'bad_name';

    // ^ I have no clue how regex works. Someone who knows please combine those two into one and make a PR.

    $user = $this->user_model->fetch_user_by('Username', $name, 'ID');

    if(!empty($user))
      return 'taken';
    else
      return true;
  }

  private function validateEmail($email) {
    if(filter_var($email, FILTER_VALIDATE_EMAIL) !== FALSE) {
      /*$domain = substr($email, strpos($email, '@') + 1);
      $domains = array('gmail.com', 'yahoo.com', 'hotmail.com', 'hotmail.co.uk', 'hotmail.fr', 'msn.com', 'yahoo.fr', 'live.com');

      return in_array($domain, $domains);*/

      return true; // Might as well allow any domain since you don't need to provide one
    } else
      return false;
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

  public function name() {
    $username = $this->input->post('username');
    $nameValid = $this->validateName($username);

    if($nameValid !== TRUE)
      $this->respond($nameValid);
    else
      $this->respond('okay');
  }

  public function join() {
    $ip = $this->input->ip_address();

    $regs = $this->db->select('ID')
      ->from('registrations')
      ->where([
        'IP' => $this->db->escape($ip),
        'Date >' => 'DATE_SUB(NOW(), INTERVAL ' . $this->cooldown . ' hour)'
      ], NULL, FALSE)
      ->get()
      ->result_array();

    if(count($regs) >= $this->maxRegistrations)
      $this->respond('overreg');

    $recaptcha = $this->retrieveData('captcha');
    $username  = $this->retrieveData('username');
    $password  = $this->retrieveData('password');
    $email     = $this->retrieveData('email', false);
    $color     = strval($this->retrieveData('color'));

    $nameRes  = $this->validateName($username);

    if($nameRes !== true)
      $this->respond($nameRes);
    if(!empty($email)) {
      if(!$this->validateEmail($email))
        $this->respond('email');
    }

    if(!$this->validateCaptcha($recaptcha))
      $this->respond('captcha');

    $colors = array(
      '1' => 'yellow',
      '2' => 'orange',
      '3' => 'blue',
      '4' => 'red',
      '5' => 'pink',
      '6' => 'purple',
      '7' => 'brown',
      '8' => 'green'
    );

    if(!array_key_exists($color, $colors))
      $color = '1';

    $password = password_hash($password, PASSWORD_DEFAULT);
    $shell = $colors[$color];

    $this->user_model->insert([
      'Username' => $username,
      'Password' => $password,
      'Email' => $email,
      'Shell' => $shell
    ]);
    $this->db->insert('registrations', ['IP' => $ip]);

    $this->respond('okay');
  }
}