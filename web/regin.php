<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$email = $_POST['email'];
include 'connectDB.php';
if($username && $password){
    	$connect=connectDB();
    	$sql = "SELECT * FROM users WHERE username = '$username'";
    	$sql2 = "INSERT INTO users (username,password,email) VALUES ('$username','$password','$email')";
    	$result = $connect->query($sql);
    	$numrows = $result->num_rows;
    	if($numrows>0){
    			$_SESSION['login'] = 1;
    			header('Location: /register.php');
    	}
    	else{
    		if($password==$password2){
    			if (preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email)) {
    				$_SESSION['username'] = $username;
    				$_SESSION['password'] = $password;
    				$_SESSION['email'] = $email;
    				$_SESSION['login'] = 0;
    				$_SESSION['login'] = 0;
					$connect->query($sql2);
    				header('Location: /regmain.php');}
    			else{
    				$_SESSION['login'] = 4;
    				header('Location: /register.php');
    				}
    		}
    		else{
    			$_SESSION['login'] = 2;
    			header('Location: /register.php');
    		}
    	$connect->close();
    	}
}
else{
	$_SESSION['login'] = 3;
	header('Location: /register.php');
}
?>