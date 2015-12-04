<?php
include 'connectDB.php'; 
function querySQL($queryString){
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
			if($numrows>0){
				echo "<table stype='width: 100%'>";
				print_r ('<th>'.'Specific Model'.'</th>');
				while($row = $result->fetch_assoc()){
					echo "<tr>";
					print_r ("<td><a href='specific_model.php?str=".$row['specific_model']."&sub=feature'>".$row['maker'].' '.$row['specific_model'].'</a></td>');
					
				}
				echo "</table>";
			}
			else{
				// echo 'NO RESULT>_< <br>'.$queryString.'<br>';
			}
			// echo 'Query Success!<br>'.$queryString.'<br>';
		}
	}
	else{
		// echo 'Query Fail...<br>'.$queryString.'<br>';
	}
	$connect->close();
}
?>
<!DOCTYPE html>
<html>
	<head>

		<title>Search Result</title>

		<link rel="shortcut icon" href="assets/images/gt_favicon.png">
		
		<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">

		<!-- Custom styles for our template -->
		<link rel="stylesheet" href="assets/css/bootstrap-theme.css" media="screen" >
		<link rel="stylesheet" href="assets/css/main.css">
	</head>


<body class="home">
	<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="main.php"><img src="assets/images/logo.png" alt="Progressus HTML5 template"></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li><a><?php echo $_SESSION['username']; ?><span class="sr-only">(current)</span></a></li>
					<li><a class="btn" href="logout.php">LOGOUT</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
	
	<header id="head">
		<div class="container">
			<div class="row">
				<h1 class="lead"><b>Search cars for sale</b></h1>
				<p class="tagline"><b>A demo product of Group ZCSX</b></p>
				<p class="tagline"><b>Project for CS411 UIUC</b></p>
			</div>
		</div>
	</header>
	<div class="container">
		<?php echo "";
            $str = $_GET['str'];
			querySQL($str);
		?>
	</div>
	</body>
</html>