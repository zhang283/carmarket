<?php
	function connectDB(){
		$servername = "localhost";
		$username = "carmarke_kuTeam";
		$password = "womenzuiniubi!";
		$dbname = "carmarke_great_database";
		$connect=new mysqli($servername,$username,$password,$dbname);
		if ($connect->connect_error) {
			die("Connection failed: " . $connect->connect_error);
		}
		return $connect;
	}
?>