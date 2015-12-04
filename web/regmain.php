<?php
session_start();
if ($_SESSION['username']==null){
	header('Location: /register.php');
}
else{
	header('Location: /index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Car Market Registration Success</title>
</head>
<body>
<?php 
echo $_SESSION['username']; 
?>
<h1>Registration Success!</h1>
<a href = index.php>Go login</a>
</body>
</html>