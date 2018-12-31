<?php 
$db = array(
"host" => "localhost",
"user" => "root",
"pass" => "",
"db" => ""
);
 
if(isset($_POST['username'])){
 
mysql_connect($db["host"], $db["user"], $db["pass"]) or die();
mysql_select_db($db["db"]) or die();  
 
$blockedNicks = array('fuck', 'cock', 'c0ck', 'whore', 'wh0re', 'wh0r3', 'bitch', 'b!tch','fuk', 'slut', 's!ut', 'shit', 'sh!t', 'fatass', 'fatty', 'gay', 'homosexual', 'bisexual', 'sex', 's3x');
$usercheck = $_POST['username'];
$check = mysql_query("SELECT username FROM users WHERE username = '$usercheck'") or die();
$check2 = mysql_num_rows($check);
 
if($usercheck == "") {
die("You need a username");
}
elseif(strlen($usercheck) < 4) {
die("status=SHORT");
}
elseif($check2 !== 0){
die("status=TAKEN");
}
elseif(in_array($usercheck, $blockedNicks)){
die("status=BAD_NAME"); //Innap name
} else {
//$insert = "INSERT INTO users (username, password,color) VALUES ('".$_POST['username']."', '".$_POST['password']."','".$_POST['color']."')";
//$add_member = mysql_query($insert);
die("status=OKAY");
}
} else {
die("status=BAD_NAME");
}
?>