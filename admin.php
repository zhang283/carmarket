<?php
session_start();
if ($_SESSION['username']==null){
	header('Location: /index.php');
}
elseif($_SESSION['username']!=="admin"){
	header('Location: /main.php');
}
include 'connectDB.php';
function query($queryString){
	$connect=connectDB();
	$result = $connect->query($queryString);
	$action = explode(" ", $queryString)[0];
	if($result==TRUE){
		if(strtolower($action)=="update"){
			echo 'update successfully!<br>'.$queryString.'<br>';
		}
		elseif(strtolower($action)=="insert"){
			echo 'insert successfully!<br>'.$queryString.'<br>';
		}
		elseif(strtolower($action)=="delete"){
			echo 'delete successfully!<br>'.$queryString.'<br>';
		}
		else{
			$numrows = $result->num_rows;
			$boo = True;
			if($numrows>0){
				echo "<table stype='width: 100%'>";
				while($row = $result->fetch_assoc()){
					$keys = array_keys($row);
					if($boo){
						echo "<tr>";
						for($x=0; $x<sizeof($keys); $x++){
							print_r ('<th>'.$keys[$x].'</th>');
						}
						echo "</tr>";
					}
					$boo = False;
					echo "<tr>";
					for($x=0; $x<sizeof($keys); $x++){
						print_r ('<th>'.$row[$keys[$x]].'</th>');
					}
					echo "</tr>";
				}
				echo "</table>";
			}
			else{
				echo 'NO RESULT>_< <br>'.$queryString.'<br>';
			}
			echo 'Query Success!<br>'.$queryString.'<br>';
		}
	}
	else{
		echo 'Query Fail...<br>'.$queryString.'<br>';
	}
	$connect->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Admin Page</title>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
}
</style>
</head>
<body>
<h1> Administrator Page!!!! </h1>
<form action="" method="get">
<textarea name="sqlquery" rows="4" cols="50"></textarea><br>
<input type="submit"> 
</form>

<a href = logout.php>Log out</a><br><br>

<?php
$queryString = $_GET['sqlquery'];
if(strlen($queryString)>0){
	query($queryString);
}
?>
</body>
</html>