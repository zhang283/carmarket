<?php
include 'connectDB.php'; 
function getInfo($str){
	$qStr = "select * from cars where specific_model = '$str'";
	$connect=connectDB();
	$result = $connect->query($qStr);
	$numrows = $result->num_rows;
	if($numrows>0){
		$row = $result->fetch_assoc();
			// echo "<li class='active'><a href='specific_model.php?str=".$row['specific_model']."&sub=price'>Price</a></li>";
			echo "<li class='active'><a href='specific_model.php?str=".$row['specific_model']."&sub=feature'>Features and Specs</a></li>";
			//echo "<li class='active'><a href='reviews.php?str=".$row['specific_model']."'>Reviews</a></li>";
			echo "<li class='active'><a href='specific_model.php?str=".$row['specific_model']."&sub=dealer'>Dealers</a></li>";
	}
	$connect->close();
}
function getPric($str){
	$qStr = "select * from cars where specific_model = '$str'";
	$connect=connectDB();
	$result = $connect->query($qStr);
	$numrows = $result->num_rows;
	if($numrows>0){
		$row = $result->fetch_assoc();
		echo "<h1><b>".$row['specific_model']."</b></h1>";
		echo "<h2><b>".$row['price']."</b></h2>";
	}
	$connect->close();
}
function getFeature($str){
	$qStr = "select * from cars where specific_model = '$str'";
	$connect=connectDB();
	$result = $connect->query($qStr);
	$numrows = $result->num_rows;
	if($numrows>0){
		$row = $result->fetch_assoc();
		// echo "<h1><b>".$row['specific_model']."</b></h1>";
		echo "<h4><b>Engine: ".$row['engine']."</b></h4>";
		echo "<h4><b>Torque: ".$row['torque']."</b></h4>";
		echo "<h4><b>Type: ".$row['type']."</b></h4>";
		echo "<h4><b>Displacement: ".$row['displacement']."</b></h4>";
		echo "<h4><b>Transmission: ".$row['transmission']."</b></h4>";
		echo "<h4><b>MPG: ".$row['mpg']."</b></h4>";
		echo "<h4><b>Drivetype: ".$row['drivetype']."</b></h4>";
		echo "<h4><b>Seats: ".$row['seats']."</b></h4>";
		echo "<h4><b>Bluetooth: ".($row['bluetooth'] == 1 ? 'Yes' : 'Not Available')."</b></h4>";
		echo "<h4><b>Heatseat: ".($row['heatseat'] == 1 ? 'Yes' : 'Not Available')."</b></h4>";
		echo "<h4><b>Navigation: ".($row['navigation'] == 1 ? 'Yes' : 'Not Available')."</b></h4>";

	}
	$connect->close();
}

function getDeal($str){
	$qStr = "select * from cars where specific_model = '$str'";
	$connect=connectDB();
	$result = $connect->query($qStr);
	$numrows = $result->num_rows;

	$inventoryQstr = "select car from inventory where specific_model = '$str'";
	$inventoryResult = $connect->query($inventoryQstr);
	$inventoryNumRows = $inventoryResult->num_rows;
	
	if($numrows>0){
		$row = $result->fetch_assoc();
		echo "<div class = 'container'>";
		echo "<h1><b>".$row['specific_model']."</b></h1>";
		if($inventoryNumRows>0){

			echo "<h2></h2>";
			echo "<div class='row'><div class='form-group col-lg-2'><form action='' method='post'>";
			echo "<select name='car' class='form-control'>";
			echo "<option value=''>Select a style</option>";

			$duplicate = array();
			while($inventoryRow = $inventoryResult->fetch_assoc()) {
				if(!in_array($inventoryRow['car'], $duplicate)){
					$duplicate[]=$inventoryRow['car'];
					echo "<option value='".$inventoryRow['car']."''>".$inventoryRow['car']."</option>";
				}
			}

			echo "</select></div></div>";

			
	    	echo "<div class='row'><div class='form-group col-lg-2'><select name='sortType' class='form-control'>";
	    	echo "<option value='D'>Sort by distance</option>";
	    	echo "<option value='P'>Sort by price</option>";
	    	echo "</select></div></div>";

			
			echo "<div class='row'><div class='form-group col-lg-2'>
    			<input type='text' name='zip' class='form-control' placeholder='Zipcode'>
 				</div></div>";
			echo "<button type='submit' class='btn btn-default'>Search for Dealers</button>";
			echo '</form>';
			echo "<br>";
		}
		else{
			echo "<h5>There are no dealers in our network.</h5>";
		}
		echo "</div>";
	}
	$connect->close();
}

function getDealer($car,$zip,$sortType){

	$connect=connectDB();
	$dealerQstr = "select name, address, zipcode, price, phonenumber,vin from inventory,dealer where inventory.dealer = dealer.name and car = '$car'";
	$dealerResult = $connect->query($dealerQstr);
	$dealerNumRow=$dealerResult->num_rows;
	if($dealerNumRow>0){
		$dealerDict = array(); 
		$reverseDealerDict = array(); 
		$i = 0;
		while($dealerRow=$dealerResult->fetch_assoc()){
			$dist = calcDist($zip, $dealerRow['zipcode']);
			if($sortType == 'D'){
				$key = $dist+ $i*0.0001;
				$i++;
				$key = "$key";
			}
			else if($sortType == 'P'){
				$price = explode('$', $dealerRow['price']);
				if(sizeof($price) < 2){
					$price = 10000000;
				}
				else{

					$price = intval(explode(',', $price[1])[0].explode(',', $price[1])[1]);
				}
				$key = $price + $i*0.0001;
				$i++;
				$key = "$key";
			}
			if($dist>0.0001 and $dist<200){
				$dealerDict[] = $key;
				$reverseDealerDict[$key] = array($dealerRow['name'],$dealerRow['price'],$dealerRow['address'],$dealerRow['phonenumber'],$dist,$dealerRow['vin']);
			}
		}
		sort($dealerDict);
		if($sortType == 'D'){
		echo "<div class='container'>";
		echo "<h3>Available dealers sorted by distance </h3><br>";
		}
		if($sortType == 'P'){
		echo "<div class='container'>";
		echo "<h3>Available dealers sorted by price </h3><br>";
		}
		foreach ($dealerDict as $key => $value) {

			echo '<h4><b>'.$reverseDealerDict[$value][0].'</b></h4>';
			echo '<h5><b>Price:</b> '.$reverseDealerDict[$value][1].'   <b>Address:</b> '.$reverseDealerDict[$value][2].'   <b>Phone#:</b> '.$reverseDealerDict[$value][3].'   &#9<b>Dist(miles):</b> '.intval($reverseDealerDict[$value][4]).'</h5>';
			echo '<h5><b>VIN Number:</b> '.$reverseDealerDict[$value][5].'<br><br><br>';
		}
		echo "</div>";
	}
	else{
		echo "<div class='container'>";
		echo "<h5>No dealership found</h5>";
		echo "</div>";
	}
	$connect->close();
}

function calcDist($point1, $point2)
{

	$point1=getLatLong($point1);
	$point2=getLatLong($point2);

    $radius      = 3958;      // Earth's radius (miles)
    $deg_per_rad = 57.29578;  // Number of degrees/radian (for conversion)

    $distance = (3958 * 3.1415926 * sqrt(
    		($point1['lat'] - $point2['lat'])
    		* ($point1['lat'] - $point2['lat'])
    		+ cos($point1['lat'] / 57.29578)
    		* cos($point2['lat'] / 57.29578)
    		* ($point1['long'] - $point2['long'])
    		* ($point1['long'] - $point2['long'])
    	) / 180);

    return $distance;  // Returned using the units used for $radius.
}

function getLatLong($zipcode){
    $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&sensor=false";
    $details=file_get_contents($url);
    $result = json_decode($details,true);

    $lat=$result['results'][0]['geometry']['location']['lat'];
    $lng=$result['results'][0]['geometry']['location']['lng'];
    $point = array('lat' => $lat, 'long' => $lng);
    return $point;
}
function getRecommendation($str){
	$qStr = "select label from cars where specific_model = '$str'";
	$connect=connectDB();
	$result = $connect->query($qStr);
	$row = $result->fetch_assoc();
	$label = $row['label'];
	if($row){
		echo "<div class = 'rec'>";
		// echo "(Debug)Cluster label: ".$label;
		echo "</div>";
	}

	
	

	$curPriceQstr = "select price from cars where specific_model = '$str'";
	$curPriceQstrResult = $connect->query($curPriceQstr);
	$curPriceRow = $curPriceQstrResult->fetch_assoc();
	$curPriceTmp = $curPriceRow['price'];
	$curPriceTmp1 = explode('$', $curPriceTmp)[1];
	$curPrice = intval(explode(',', $curPriceTmp1)[0].explode(',', $curPriceTmp1)[1]);

	$SimCarDist = array();
	$reverseSimCarDist = array();

	$recStr = "select * from cars where label = '$label'";
	$similarresults = $connect->query($recStr);

	$cars = array();
	while($car = $similarresults->fetch_assoc()){
		if($car['specific_model']!=$str){
			$cars[] = $car;
		}
	}

	$times = min(sizeof($cars),5);

	echo "<div class='special'>You might like:<br>";

	for ($i=0; $i < $times; $i++) { 
		$rand = rand(0,sizeof($cars)-1);
		echo "<h4><b><a href='specific_model.php?str=".$cars[$rand]['specific_model']."&sub=feature'>".$cars[$rand]['specific_model']."</a></b></h4><br>";
		unset($cars[$rand]);
		$cars = array_values($cars);
	}
	echo "</div>";
	$connect->close();
}
?>
<!DOCTYPE html>
<html>
	<head>
		<style>
		.special {
		    border: 3px solid black;
		    margin-top: 1cm;
		    margin-left: 20cm;
		    margin-right: 2cm;
		}
		</style>
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
					<li class="active"><a><?php echo $_SESSION['username']; ?><span class="sr-only">(current)</span></a></li>
					<?php echo "";
					$str = $_GET['str'];
					getInfo($str);
					?>
					<li class="active"><a class="btn" href="logout.php">LOGOUT</a></li>
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
	<div class="container ">
		<div class="span6">
		<?php echo "";
            $str = $_GET['str'];
            $sub = $_GET['sub'];


            if($sub == 'feature'){
            	getPric($str);
            	getFeature($str);
            }
            if($sub == 'dealer'){
            	getDeal($str);
				$car = $_POST['car'];
				$zip = $_POST['zip'];
				$sortType = $_POST['sortType'];
				getDealer($car,$zip,$sortType);
            }

           
			
		?>
		</div>
		<div class="span4">
		<?php $str = $_GET['str'];
		getRecommendation($str)
		;?>
		</div>
	</div>
	</body>
</html>




