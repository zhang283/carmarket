<?php

session_start();
if ($_SESSION['username']==null){
	header('Location: /index.php');
}
elseif($_SESSION['username']=="admin"){
	header('Location: /admin.php');
}

include 'connectDB.php'; 

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Car Market by Group ZCSX</title>

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
							<li class="active"><a><?php echo $_SESSION['username']; ?><span class="sr-only">(current)</span></a></li>
							<li class="active"><a class="btn" href="logout.php">LOGOUT</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</header>

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
			<form action="" method="get">
				
				<h1></h1>
				<!-- 1st dropdown menu: maker -->
				<label><font size="4" color="DimGray">Maker:</font>
				<select name="maker" onchange="getModel(this.value);" class="form-control">
					<option value="">Select Make</option>

					<?php

					$connect=connectDB();
					$results = $connect->query("select distinct maker from cars order by maker ASC");
	 				foreach($results as $row) {
					?>
	 				<option value="<?php echo $row["maker"]; ?>"><?php echo $row["maker"]; ?></option>
					<?php
					}
					$connect->close();
					?>
				</select></label>

				<!-- 2nd dropdown menu: model -->
				<label><font size="4" color="DimGray">Model:</font>
				<select name="model" id="model-list" onchange="getYear(this.value);" class="form-control">
					<option value="">Select Model</option>
				</select></label>

				<!-- 3rd dropdown menu: year -->
				<label><font size="4" color="DimGray">Year:</font>
				<select name="year" id="year-list" class="form-control">
					<option value="">Select Year</option>
				</select></label><br>

				<!-- This div is the list of checkboxes, you may want to keep it this way or as you wish -->
	 			<div><p><font size="4" color="DimGray">Engine</font>:
					<h4></h4>
		        	<label><input type="checkbox" name = "Gas" value = "Gas" /> Gas</label>
		        	<label><input type="checkbox" name = "Diesel" value = "Diesel" /> Diesel</label>
		        	<label><input type="checkbox" name = "Hybrid" value = "Hybrid" /> Hybrid</label>
		        	<label><input type="checkbox" name = "Flex-fuel (ffv)" value = "Flex-fuel (ffv)" /> Flex-fuel (ffv)</label>
		        	<label><input type="checkbox" name = "Electric" value = "Electric" /> Electric</label>
		        	<label><input type="checkbox" name = "Natural" value = "Natural" /> Natural Gas</label>
					<h6></h6>
		    	</div>

				<div><p><font size="4" color="DimGray">Type</font>:
		        	<h4></h4>
					<label><input type="checkbox" name = "Sedan" value = "Sedan" /> Sedan</label>
		        	<label><input type="checkbox" name = "Coupe" value = "Coupe" /> Coupe</label>
		        	<label><input type="checkbox" name = "Convertible" value = "Convertible" /> Convertible</label>
		        	<label><input type="checkbox" name = "Minivan" value = "Minivan" /> Minivan</label>
		        	<label><input type="checkbox" name = "Hatchback" value = "Hatchback" /> Hatchback</label>
		      		<label><input type="checkbox" name = "Wagon" value = "Wagon" /> Wagon</label>
		      		<label><input type="checkbox" name = "Truck" value = "Truck" /> Truck</label>
					<h6></h6>
				</div>


		     	<div><p><font size="4" color="DimGray">DriveType</font>:
					<h4></h4>
					<label><input type="checkbox" name = "rwd" value = "Rear Wheel Drive" /> rwd</label>
		        	<label><input type="checkbox" name = "fwd" value = "Front Wheel Drive" /> fwd</label>
		        	<label><input type="checkbox" name = "awd" value = "All Wheel Drive" /> awd</label>
					<h6></h6>
				</div>

		     	<div><p><font size="4" color="DimGray">Transmission</font>:
		     		<h4></h4>
					<label><input type="checkbox" name = "a1ssd" value = "1-speed Direct Drive" /> 1-speed Direct Drive</label>
		        	<label><input type="checkbox" name = "a4ssa" value = "4-speed Shiftable Automatic" /> 4-speed Shiftable Automatic</label>
		        	<label><input type="checkbox" name = "a4sa" value = "4-speed Automatic" /> 4-speed Automatic</label>
		        	<label><input type="checkbox" name = "a5ssa" value = "5-speed Shiftable Automatic" /> 5-speed Shiftable Automatic</label>
		        	<label><input type="checkbox" name = "a5sa" value = "5-speed Automatic" /> 5-speed Automatic</label>
		        	<label><input type="checkbox" name = "a5sm" value = "5-speed Manual" /> 5-speed Manual</label>
		        	<label><input type="checkbox" name = "a6sam" value = "6-speed Automated Manual" /> 6-speed Automated Manual</label>
		        	<label><input type="checkbox" name = "a6ssa" value = "6-speed Shiftable Automatic" /> 6-speed Shiftable Automatic</label>
		        	<label><input type="checkbox" name = "a6sa" value = "6-speed Automatic" /> 6-speed Automatic</label>
		        	<label><input type="checkbox" name = "a6sm" value = "6-speed Manual" /> 6-speed Manual</label>
		        	<label><input type="checkbox" name = "a7sam" value = "7-speed Automated Manual" /> 7-speed Automated Manual</label>
		        	<label><input type="checkbox" name = "a7ssa" value = "7-speed Shiftable Automatic" /> 7-speed Shiftable Automatic</label>
		        	<label><input type="checkbox" name = "a7sa" value = "7-speed Automatic" /> 7-speed Automatic</label>
		      		<label><input type="checkbox" name = "a7sm" value = "7-speed Manual" /> 7-speed Manual</label>
		      		<label><input type="checkbox" name = "a8sam" value = "8-speed Automated Manual" /> 8-speed Automated Manual</label>
		        	<label><input type="checkbox" name = "a8ssa" value = "8-speed Shiftable Automatic" /> 8-speed Shiftable Automatic</label>
		        	<label><input type="checkbox" name = "a8sa" value = "8-speed Automatic" /> 8-speed Automatic</label>
		        	<label><input type="checkbox" name = "a9ssa" value = "9-speed Shiftable Automatic" /> 9-speed Shiftable Automatic</label>
		      		<label><input type="checkbox" name = "a9sm" value = "9-speed Automatic" /> 9-speed Automatic</label>
		      		<label><input type="checkbox" name = "acvsa" value = "Continuously Variable-speed Automatic" /> Continuously Variable-speed Automatic</label>
					<h6></h6>
				</div>

		    	<div><p><font size="4" color="DimGray">Cylinders</font>:
		     		<h4></h4>
					<label><input type="checkbox" name = "V6" value = "V6" /> V6</label>
		        	<label><input type="checkbox" name = "V8" value = "V8" /> V8</label>
		        	<label><input type="checkbox" name = "V10" value = "V10" /> V10</label>
		        	<label><input type="checkbox" name = "V12" value = "V12" /> V12</label>
		        	<label><input type="checkbox" name = "Inline3" value = "Inline 3" /> Inline3</label>
		        	<label><input type="checkbox" name = "Inline4" value = "Inline 4" /> Inline4</label>
		        	<label><input type="checkbox" name = "Inline5" value = "Inline 5" /> Inline5</label>
		        	<label><input type="checkbox" name = "Inline6" value = "Inline 6" /> Inline6</label>
		        	<label><input type="checkbox" name = "Flat4" value = "Flat 4" /> Flat 4</label>
		        	<label><input type="checkbox" name = "Flat6" value = "Flat 6" /> Flat 6</label>
					<h6></h6>
				</div>

		    	<div><p><font size="4" color="DimGray">Fuel</font>:
		     		<h4></h4>
					<label><input type="checkbox" name = "RU" value = "Regular unleaded" /> Regular unleaded</label>
		        	<label><input type="checkbox" name = "PUR" value = "Premium unleaded (required)" /> Premium unleaded (required)</label>
		        	<label><input type="checkbox" name = "PURR" value = "Premium unleaded (recommended)" /> Premium unleaded (recommended)</label>
		        	<label><input type="checkbox" name = "NG" value = "Natural gas (CNG)" /> Natural gas (CNG)</label>
		        	<label><input type="checkbox" name = "H" value = "Hydrogen" /> Hydrogen</label>
		        	<label><input type="checkbox" name = "FFF" value = "Flex-fuel (FFV)" /> Flex-fuel (FFV)</label>
		        	<label><input type="checkbox" name = "D" value = "Diesel" /> Diesel</label>
					<h6></h6>
				</div>

				<button type='submit' class='btn btn-default'>Search</button>
				<h1></h1>
			</form>

		</div>


		<script>
		// function to select options for 2nd dropdown menu
		function getModel(str) {
		    if (str.length == 0) { 
		        document.getElementById("model-list").innerHTML = "";
		        return;
		    } else {
		        var xmlhttp = new XMLHttpRequest();
		        xmlhttp.onreadystatechange = function() {
		            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		                document.getElementById("model-list").innerHTML = xmlhttp.responseText;
		            }
		        }
		        xmlhttp.open("GET", "get_model.php?maker=" + str, true);
		        xmlhttp.send();
		    }
		}
		// function to select options for 3rd dropdown menu
		function getYear(str) {
		    if (str.length == 0) { 
		        document.getElementById("year-list").innerHTML = "";
		        return;
		    } else {
		        var xmlhttp = new XMLHttpRequest();
		        xmlhttp.onreadystatechange = function() {
		            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		                document.getElementById("year-list").innerHTML = xmlhttp.responseText;
		            }
		        }
		        xmlhttp.open("GET", "get_year.php?model=" + str, true);
		        xmlhttp.send();
		    }
		}
		</script>

		<?php

			// Get values from user input 
			
			$maker = $_GET['maker'];
			$model = $_GET['model'];
			$year = $_GET['year'];

			$Gas=$_GET['Gas'];
			$Diesel=$_GET['Diesel'];
			$Hybrid=$_GET['Hybrid'];
			$Ffv=$_GET['Flex-fuel (ffv)'];
			$Electric=$_GET['Electric'];
			$Cng=$_GET['Natural'];

			$engines = array($Gas, $Diesel, $Ffv, $Hybrid, $Ffv, $Electric, $Cng);//engine preferences array

			$Sedan=$_GET['Sedan'];
			$Coupe=$_GET['Coupe'];
			$Minivan=$_GET['Minivan'];
			$Convertible=$_GET['Convertible'];
			$Hatchback=$_GET['Hatchback'];
			$Wagon=$_GET['Wagon'];
			$Van=$_GET['Van'];
			$Truck=$_GET['Truck'];

			$types = array($Sedan, $SUV, $Coupe, $Convertible, $Minivan, $Hatchback, $Van, $Wagon, $Truck);


			$rwd=$_GET['rwd'];
			$fwd=$_GET['fwd'];
			$awd=$_GET['awd'];

			$drivetypes=array($rwd,$fwd,$awd);

			$a1ssd=$_GET['a1ssd'];
			$a4ssa=$_GET['a4ssa'];
			$a4sa=$_GET['a4sa'];
			$a5ssa=$_GET['a5ssa'];
			$a5sa=$_GET['a5sa'];
			$a5sm=$_GET['a5sm'];
			$a6sam=$_GET['a6sam'];
			$a6ssa=$_GET['a6ssa'];
			$a6sa=$_GET['a6sa'];
			$a6sm=$_GET['a6sm'];
			$a7sam=$_GET['a7sam'];
			$a7ssa=$_GET['a7ssa'];
			$a7sa=$_GET['a7sa'];
			$a7sm=$_GET['a7sm'];
			$a8sam=$_GET['a8sam'];
			$a8ssa=$_GET['a8ssa'];
			$a8sa=$_GET['a8sa'];
			$a9ssa=$_GET['a9ssa'];
			$a9sm=$_GET['a9sm'];
			$acvsa=$_GET['acvsa'];


			$transmission=array($a1ssd, $a4ssa, $a4sa, $a5ssa, $a5sa, $a5sm, $a6sam, $a6ssa, $a6sa, $a6sm, $a7sam, $a7ssa, $a7sa, $a7sm,  $a8sam, $a8ssa, $a8sa, $a9ssa, $a9sm, $acvsa);

			$V6=$_GET['V6'];
			$V8=$_GET['V8'];
			$V10=$_GET['V10'];
			$V12=$_GET['V12'];
			$Inline3=$_GET['Inline3'];
			$Inline4=$_GET['Inline4'];
			$Inline5=$_GET['Inline5'];
			$Inline6=$_GET['Inline6'];
			$Flat4=$_GET['Flat4'];
			$Flat6=$_GET['Flat6'];

			$cylinders = array($V6, $V8, $V10, $V12, $Inline3, $Inline4, $Inline5, $Inline6, $Flat4, $Flat6);

			$RU=$_GET['RU'];
			$PUR=$_GET['PUR'];
			$PURR=$_GET['PURR'];
			$NG=$_GET['NG'];
			$H=$_GET['H'];
			$FFF=$_GET['FFF'];
			$D=$_GET['D'];

			$fuel = array($RU, $PUR, $PURR, $NG, $H, $FFF, $D);			

			$Qstr = "select * from cars"; // initial query string

			$sum = $maker.$model.$year;
			$flag = false;

			//extend the query string by 3 dropdown menus 
			if (strlen($sum) > 0){
				$Qstr = $Qstr." where";
				if (strlen($maker)>0){
					$Qstr = $Qstr." maker = '$maker'";
					$flag = true;
				}
				if(strlen($model)>0){
					if($flag){
						$Qstr = $Qstr." and";
					}
					$Qstr = $Qstr." model = '$model'";
					$flag = true;
				}
				if(strlen($year)>0){
					if($flag){
						$Qstr = $Qstr." and";
					}
					$Qstr = $Qstr." year = '$year'";
					$flag = true;
				}
				$count = 0;
				foreach ($engines as $value) {
			    	if (strlen($value) > 0  and $count == 0){
			    		$Qstr = $Qstr." and ( engine = '$value'";
				    	$count = $count + 1;
				    }
				    elseif (strlen($value) > 0){
				    	$Qstr = $Qstr." or engine = '$value'";
			    		$count = $count + 1;
				    }

				}
				if($count > 0){
					$Qstr = $Qstr." )";	
				}
						
				$count1 = 0;
				foreach ($types as $value) {
			    	if (strlen($value) > 0  and $count1 == 0){
			    		$Qstr = $Qstr." and ( type = '$value'";
				    	$count1 = $count1 + 1;
				    }
				    elseif (strlen($value) > 0){
				    	$Qstr = $Qstr." or type = '$value'";
				    	$count1 = $count1 + 1;
				    }

				}
			
				if($count1 > 0){
					$Qstr = $Qstr." )";	
				}

				$count2 = 0;
				foreach ($drivetypes as $value) {
				    if (strlen($value) > 0  and $count2 == 0){
				    	$Qstr = $Qstr." and ( drivetype = '$value'";
				    	$count2 = $count2 + 1;
				    }
				    elseif (strlen($value) > 0){
				    	$Qstr = $Qstr." or drivetype = '$value'";
				    	$count2 = $count2 + 1;
				    }

				}
				if($count2 > 0){
					$Qstr = $Qstr." )";	
				}
			

			$count3 = 0;
				foreach ($transmission as $value) {
			    	if (strlen($value) > 0  and $count3 == 0){
			    		$Qstr = $Qstr." and ( transmission = '$value'";
				    	$count3 = $count3 + 1;
				    }
				    elseif (strlen($value) > 0){
				    	$Qstr = $Qstr." or transmission = '$value'";
				    	$count3 = $count3 + 1;
				    }

				}
			
				if($count3 > 0){
					$Qstr = $Qstr." )";	
				}

			$count4 = 0;
				foreach ($cylinders as $value) {
			    	if (strlen($value) > 0  and $count4 == 0){
			    		$Qstr = $Qstr." and ( cylinders = '$value'";
				    	$count4 = $count4 + 1;
				    }
				    elseif (strlen($value) > 0){
				    	$Qstr = $Qstr." or type = '$value'";
				    	$count4 = $count4 + 1;
				    }

				}
			
				if($count4 > 0){
					$Qstr = $Qstr." )";	
				}

			$count5 = 0;
				foreach ($fuel as $value) {
			    	if (strlen($value) > 0  and $count5 == 0){
			    		$Qstr = $Qstr." and ( fuel = '$value'";
				    	$count5 = $count5 + 1;
				    }
				    elseif (strlen($value) > 0){
				    	$Qstr = $Qstr." or fuel = '$value'";
				    	$count5 = $count5 + 1;
				    }

				}
			
				if($count5 > 0){
					$Qstr = $Qstr." )";	
				}
			}

########////////////////////////////
			if (strlen($sum) == 0){
				$Qstr = $Qstr." where";
               	$sum1=$Gas.$Diesel.$Hybrid.$Ffv.$Electric.$Cng;				
                if ($flag==true and strlen($sum1>0)) {
					$Qstr = $Qstr." and";
				}
                                
				if (strlen($sum1)>0) {
					$count = 0;
					foreach ($engines as $value) {
			    		if (strlen($value) > 0  and $count == 0){
			    			$Qstr = $Qstr." ( engine = '$value'";
				    		$count = $count + 1;
				   	 }
				   	 elseif (strlen($value) > 0){
				    		$Qstr = $Qstr." or engine = '$value'";
			    			$count = $count + 1;
					    }

					}
					if($count > 0){
						$Qstr = $Qstr." )";	
					}
					$flag=true;
				}		
                
                $sum2=$Sedan.$Coupe.$Minivan.$Convertible.$Hatchback.$Wagon.$Van.$Truck;
				if ($flag==true and strlen($sum2)>0) {
					$Qstr = $Qstr." and";
				}
                               
				if (strlen($sum2)>0) {
					$count1 = 0;
					foreach ($types as $value) {
					    if (strlen($value) > 0  and $count1 == 0){
					    	$Qstr = $Qstr." ( type = '$value'";
					    	$count1 = $count1 + 1;
					    }
					    elseif (strlen($value) > 0){
					    	$Qstr = $Qstr." or type = '$value'";
					    	$count1 = $count1 + 1;
					    }

					}
					if($count1 > 0){
						$Qstr = $Qstr." )";	
					}
					$flag=true;
				}
                                
                
                $sum3=$rwd.$fwd.$awd;
				if($flag==true and strlen($sum3)>0){
					$Qstr = $Qstr." and";
				}
                                
				if(strlen($sum3)>0){
					$count2 = 0;
					foreach ($drivetypes as $value) {
				    	if (strlen($value) > 0  and $count2 == 0){
				    		$Qstr = $Qstr." ( drivetype = '$value'";
				    		$count2 = $count2 + 1;
				    	}
				    	elseif (strlen($value) > 0){
				    		$Qstr = $Qstr." or drivetype = '$value'";
				    		$count2 = $count2 + 1;
					    }

					}
					if($count2 > 0){
						$Qstr = $Qstr." )";	
					}
                                        $flag=true;
				}

/////////

				$sum4=$a1ssd.$a4ssa.$a4sa.$a5ssa.$a5sa.$a5sm.$a6sam.$a6ssa.$a6sa.$a6sm.$a7sam.$a7ssa.$a7sa.$a7sm.$a8sam.$a8ssa.$a8sa.$a9sm.$a9ssa.$acvsa;
				if($flag==true and strlen($sum4)>0){
					$Qstr = $Qstr." and";
				}
                                
				if(strlen($sum4)>0){
					$count3 = 0;
					foreach ($transmission as $value) {
				    	if (strlen($value) > 0  and $count3 == 0){
				    		$Qstr = $Qstr." ( transmission = '$value'";
				    		$count3 = $count3 + 1;
				    	}
				    	elseif (strlen($value) > 0){
				    		$Qstr = $Qstr." or transmission = '$value'";
				    		$count3 = $count3 + 1;
					    }

					}
					if($count3 > 0){
						$Qstr = $Qstr." )";	
					}
                                        $flag=true;
				}

////////
				$sum5=$V6.$V8.$V10.$V12.$Inline3.$Inline4.$Inline5.$Inline6.$Flat4.$Flat6d;
				if($flag==true and strlen($sum5)>0){
					$Qstr = $Qstr." and";
				}
                                
				if(strlen($sum5)>0){
					$count4 = 0;
					foreach ($cylinders as $value) {
				    	if (strlen($value) > 0  and $count4 == 0){
				    		$Qstr = $Qstr." ( cylinders = '$value'";
				    		$count4 = $count4 + 1;
				    	}
				    	elseif (strlen($value) > 0){
				    		$Qstr = $Qstr." or cylinders = '$value'";
				    		$count4 = $count4 + 1;
					    }

					}
					if($count4 > 0){
						$Qstr = $Qstr." )";	
					}
                                        $flag=true;
				}
////////
				$sum6=$RU.$PUR.$PURR.$NG.$H.$FFF.$D;
				if($flag==true and strlen($sum6)>0){
					$Qstr = $Qstr." and";
				}
                                
				if(strlen($sum6)>0){
					$count5 = 0;
					foreach ($fuel as $value) {
				    	if (strlen($value) > 0  and $count5 == 0){
				    		$Qstr = $Qstr." ( fuel = '$value'";
				    		$count5 = $count5 + 1;
				    	}
				    	elseif (strlen($value) > 0){
				    		$Qstr = $Qstr." or fuel = '$value'";
				    		$count5 = $count5 + 1;
					    }

					}
					if($count5 > 0){
						$Qstr = $Qstr." )";	
					}
                                        $flag=true;
				}



			}


		
			// extend the query string by checkboxes of engine preference (you must select at least one dropdown menu
		

			
			
			//make the query

			if ($Qstr != "select * from cars" and $Qstr != "select * from cars where"){

				echo '<script type="text/javascript">
				<!--
				window.location = "http://carmarket.web.engr.illinois.edu/queryresult.php?str='.$Qstr.'"
				//-->
				</script>';

			}
		?>



		
