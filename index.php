<?php
session_start();
include 'phpAlert.php';
if ($_SESSION['username'] !== null){
	header('Location: /main.php');
}
if ($_SESSION['login']==1){
	phpAlert ("Your password is incorrect!!");
} elseif($_SESSION['login']==2){
	phpAlert("That user does not exists!");
} elseif($_SESSION['login']==3){
	phpAlert("Please enter a username and password!");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Car Market Login</title>
</head>
<body>
    <h1>Login Please.</h1>
    <form action="login.php" method="post">
    	Username:	<input type="text" name="username"><p>
    	Password: 	<input type="password" name="password"><p>
    				<input type="submit" value="Login!"> 
    </form>
</body>
</html>