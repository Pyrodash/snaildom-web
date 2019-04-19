<?php
	class MySQLIExtension {
		private $mysqli;
		
		function __construct() {
			$h = "127.0.0.1";
			$u = "root";
			$p = "";
			$d = "snaildom2";
			
			$this->mysqli = new mysqli($h, $u, $p, $d);
			
			if(mysqli_connect_errno()) {
				die("Error in database.".mysqli_connect_errno());
			}
		}
		function query($q) {
			return $this->mysqli->query($q);
		}
		function assoc($q) {
			if(!$q){
				return false;
			}
			return $q->fetch_assoc();
		}
		function num_rows($q) {
			if(!$q){
				return false;
			}
			return $q->num_rows;
		}
		function escape($str) {
			return $this->mysqli->real_escape_string($str);
		}
	}
	
	$MYSQL = new MySQLIExtension();
?>
