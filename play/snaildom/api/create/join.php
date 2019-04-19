<?php
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/util.php";

$mysql = new mysqli($host, $user, $pass, $db);

$registrationCooldown = 3;
$maxRegistrations = 3;

function response($res) {
  die('status=' . strtoupper($res));
}

function retrieveData($key, $strict = true) {
  if(isset($_POST[$key]) && !empty($_POST[$key]))
    return $_POST[$key];

  if($strict !== FALSE)
    response('error');

  return NULL;
}

$ip = getIP();

$stmt = $mysql->prepare('SELECT ID FROM registrations WHERE IP = ? AND Date > DATE_SUB(NOW(), INTERVAL ? hour);');
$stmt->bind_param('si', $ip, $registrationCooldown);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows >= $maxRegistrations)
  response('overreg');

$recaptcha = retrieveData('captcha');
$username  = retrieveData('username');
$password  = retrieveData('password');
$email     = retrieveData('email', false);
$color     = strval(retrieveData('color'));

$nameRes  = validateName($username, $mysql);

if($nameRes !== true)
  response($nameRes);
if(!empty($email)) {
  if(!validateEmail($email))
    response('email');
}

if(!validateCaptcha($recaptcha, $RECAPTCHA_SECRET_KEY))
  response('captcha');

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

$stmt = $mysql->prepare('INSERT INTO `users` (`Username`, `Password`, `Email`,  `Shell`) VALUES (?, ?, ?, ?);');
$stmt->bind_param("ssss", $username, $password, $email, $shell);
$stmt->execute();

$stmt = $mysql->prepare('INSERT into `registrations` (`IP`) VALUES (?);');
$stmt->bind_param('s', $ip);
$stmt->execute();

response('okay');
?>