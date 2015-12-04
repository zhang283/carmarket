<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
include 'connectDB.php';
if($username && $password){
    	$connect=connectDB();
    	$sql = "SELECT * FROM users WHERE username = '$username'";
    	$result = $connect->query($sql);
    	$numrows = $result->num_rows;
    	if($numrows>0){
    		while($row = $result->fetch_assoc()){
    			$dbusername = $row['username'];
    			$dbpassword = $row['password'];
    		}
    		if($username==$dbusername && $password==$dbpassword){
    			$_SESSION['username'] = $username;
    			$_SESSION['login'] = 0;
    			header('Location: /main.php');
    		}
    		else{
    			$_SESSION['login'] = 1;
    			header('Location: /index.php');
    		}
    	}
    	else{
    		$_SESSION['login'] = 2;
    		header('Location: /index.php');
    	}
    	$connect->close();
}
else{
	$_SESSION['login'] = 3;
	header('Location: /index.php');
}
?>