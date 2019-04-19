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
			die('login=' . $response);
		}
}

if(!empty($username) && !empty($password)) {
	$mysql = new mysqli($host, $user, $pass, $db);

	$stmt = $mysql->prepare('SELECT ID, Username, Password, Friends FROM users WHERE Username = ?');
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->store_result();

	$stmt->bind_result($user_id, $user_name, $user_password, $buddies);
	$stmt->fetch();

	if ($stmt->num_rows == 1) {
		if(password_verify($password, $user_password)) {
			$bans = $mysql->query("SELECT * FROM bans WHERE User = '$user_id' AND Active = 1 LIMIT 1");
			$isBanned = false;

			if($bans->num_rows > 0) {
				$isBanned = true;

				$ban = $bans->fetch_assoc();

				$ban_id = $ban['ID'];
				$banLength = $ban['Length'];

				$banTime = strtotime($ban['Date']);
				$currentTime = strtotime("now");

				$durationInSeconds = $banLength * 60 * 60;

				if((isset($banLength) && $banLength != 999) && (($currentTime - $banTime) >= $durationInSeconds)) {
					$isBanned = false;

					mysqli_query($mysql, "UPDATE bans SET `Active` = '0' WHERE `ID` = '$ban_id'");
				}
			}

			if($isBanned == false) {
				$response = 1;
				$loginKey = generateLoginKey();

				$sessionKey = str_insert($user_id, $loginKey, strlen($loginKey) / 2);
				$sessionKey = str_insert($user_name, $sessionKey, strlen($sessionKey));
				$sessionKey = md5($sessionKey);

				mysqli_query($mysql, "UPDATE users SET `LoginKey` = '$loginKey', `SessionKey` = '$sessionKey' WHERE `ID` = '$user_id'");

				$stmt->close();
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
		$stmt->close();
	}

} else {
	$response = 2;
}

function respond($arr) {
	echo http_build_query($arr);
}

$redisHost = isset($redis_host) ? $redis_host : '127.0.0.1';
$redisPort = isset($redis_port) ? $redis_port : '6379';

if($response == 1) {
	$redis = new Redis();
	$redis->connect($redisHost, $redisPort);

	$servers = $redis->get('servers');
	$servers = json_decode($servers);
	$buddies = explode(',', $buddies);

	foreach($servers as &$server) {
		$server->users = $redis->get($server->id . '.population');

		$players = $redis->get($server->id . '.players');
		$players = json_decode($players);

		$server->buddies = 0;

		foreach($buddies as $buddy) {
			if(in_array($buddy, $players))
				$server->buddies++;
		}
	}

	respond([
		'login' => $response,
		'playerkey' => $loginKey,
		'playerid' => $user_id,
		'playerkey2' => $sessionKey,
		'username' => $user_name,
		'servers' => json_encode($servers)
	]);
} else {
	if($response == 2) {
		echo 'login=' . $response;
	} elseif($response == 3) {
		echo 'login=' . $response . '&hours=' . $banLength;
	}
}

die();
?>