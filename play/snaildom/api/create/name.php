<?php
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/util.php";

// TODO: Rewrite using CodeIgniter

$mysql = new mysqli($host, $user, $pass, $db);

if(isset($_POST['username'])) {
  $res = validateName($_POST['username'], $mysql);

  if($res === TRUE)
    die('status=OKAY');
  else
    die('status=' . strtoupper($res));
} else
  die('status=BAD_NAME');

?>