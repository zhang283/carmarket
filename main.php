<?php
session_start();
if ($_SESSION['username']==null){
	header('Location: /index.php');
}
elseif($_SESSION['username']=="admin"){
	header('Location: /admin.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Car Market Main</title>
</head>
<body>
<?php 
echo $_SESSION['username']; 
?>
<h1>hello world!</h1>
<a href = logout.php>Log out</a>
</body>
</html>