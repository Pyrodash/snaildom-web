<?php
require_once __DIR__ . "/config.php";

function generateLoginKey() {
	$characterSet = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789";
	
	$keyLength = mt_rand(7, 10);
	$randomKey = "";

	foreach(range(0, $keyLength) as $currentLength) {
		$randomKey .= substr($characterSet, mt_rand(0, strlen($characterSet)), 1);
	}

	return $randomKey;
}

function str_insert($insertstring, $intostring, $offset) {
   $part1 = substr($intostring, 0, $offset);
   $part2 = substr($intostring, $offset);
  
   $part1 = $part1 . $insertstring;
   $whole = $part1 . $part2;
   return $whole;
}

$response = 0;

$requestType = $_SERVER['REQUEST_METHOD'];

switch($requestType) {
	case "POST":
		$username = $_POST['username'];
		$password = $_POST['password'];
		break;
	case "GET":
		if(!empty($_GET['username']) && !empty($_GET['password'])) {
			$username = $_GET['username'];
			$password = $_GET['password'];
		} else {
			echo 'login=' . $response;
			die();
		}
}

if(!empty($username) && !empty($password)) {
	$mysql = new mysqli($host, $user, $pass, $db);
	
	$stmt = $mysql->prepare('SELECT id, username, password, banned, banDate FROM users WHERE username = ?');
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->store_result();
	
	$stmt->bind_result($user_id, $user_name, $user_password, $banned, $banDate);
	$stmt->fetch();
	if ($stmt->num_rows == 1) {
		$isBanned = false;

		if($banned > 0) {
			$isBanned = true;
			
			$banTime = strtotime($banDate);
			$currentTime = strtotime("now");
			
			$durationInSeconds = $banned * 60 * 60;

			if(($currentTime - $banTime) >= $durationInSeconds) {
				$isBanned = false;

				mysqli_query($mysql, "UPDATE users SET `banned` = '0' WHERE `id` = '$user_id'");
			}
		}
		
		if($isBanned == false) {
			if(password_verify($password, $user_password)) {
				$response = 1;
				$loginKey = generateLoginKey();
				
				mysqli_query($mysql, "UPDATE users SET `loginKey` = '$loginKey' WHERE `id` = '$user_id'");
				
				$loginToken = str_insert($user_id, $loginKey, strlen($loginKey) / 2);
				$loginToken = str_insert($user_name, $loginToken, strlen($loginToken));
				$loginToken = md5($loginToken);
				
				$stmt->close();
			} else {				
				$response = 2;
				$stmt->close();
			}
		} else {
			$response = 3;
			$stmt->close();
		}
	} else {
		$response = 2;
		$stmt->close();
	}
	
} else {
	$response = 2;
}

if($response == 1) {
	echo 'login=' . $response . '&playerkey=' . $loginKey . '&playerid=' . $user_id . '&playerkey2=' . $loginToken;
} else {
	if($response == 2) {
		echo 'login=' . $response;
	} elseif($response == 3) {
		echo 'login=' . $response . '&hours=' . $banned;
	}
}

die();
?>