<?php
function validateName($username, $mysql) {
  $blockedNicks = array('fuck', 'cock', 'c0ck', 'whore', 'wh0re', 'wh0r3', 'bitch', 'b!tch','fuk', 'slut', 's!ut', 'shit', 'sh!t', 'fatass', 'fatty', 'gay', 'homosexual', 'bisexual', 'sex', 's3x');
  $username = $_POST['username'];

  if(empty($username))
    return '';
  elseif(strlen($username) < 4)
    return 'short';
  elseif(in_array($username, $blockedNicks))
    return 'bad_name';
  elseif(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username))
    return 'bad_name';
  elseif(preg_match('/\s/', $username))
    return 'bad_name';

  // ^ I have no clue how regex works. Someone who knows please combine those two into one and make a PR.

  $stmt = $mysql->prepare('SELECT ID FROM users WHERE Username = ?');
  $stmt->bind_param('s', $username);
  $stmt->execute();
  $stmt->store_result();

  $stmt->bind_result($user_id);
  $stmt->fetch();

  if($stmt->num_rows == 1)
    return 'taken';
  else
    return true;
}

function validateEmail($email) {
  if(filter_var($email, FILTER_VALIDATE_EMAIL) !== FALSE) {
    /*$domain = substr($email, strpos($email, '@') + 1);
    $domains = array('gmail.com', 'yahoo.com', 'hotmail.com', 'hotmail.co.uk', 'hotmail.fr', 'msn.com', 'yahoo.fr', 'live.com');

    return in_array($domain, $domains);*/

    return true; // Might as well allow any domain since you don't need to provide one
  } else
    return false;
}

function getIP() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function validateCaptcha($res, $secretKey) {
  $ch = curl_init();
  $data = array(
    'secret' => $secretKey,
    'response' => $res,
    'remoteip' => getIP()
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
?>