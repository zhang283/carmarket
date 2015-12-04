<?php
include 'connectDB.php';
echo 'Initializing...<br>';

$file = fopen("dataForMining.txt", "r");
if ($file) {
	$connect=connectDB();
	while (($line = fgets($file)) !== false) {
		$infolist = explode("\t", $line);
		$make = trim($infolist[0]);
		$model = trim($infolist[1]);
		$sp = trim($infolist[2]);
		$year = trim($infolist[3]);
		$mpg = trim($infolist[4]);
		$cartype = trim($infolist[5]);
		$transmission = trim($infolist[6]);
		$warranty = trim($infolist[7]);
		$engine = trim($infolist[8]);
		$cylinders = trim($infolist[10]);
		$driveType = trim($infolist[11]);
		$fuel = trim($infolist[12]);
		$displacement = trim($infolist[13]);
		$power = trim($infolist[14]);
		$torque = trim($infolist[15]);
		$price = trim($infolist[16]);
		if(trim($infolist[17])=="Yes")
			$blueTooth = 1;
		else $blueTooth = 0;
		if(trim($infolist[18])=="Yes")
			$heat = 1;
		else $heat = 0;
		$seats = trim($infolist[9]);
		if($seats=="Not Available"){
			$seats = -1;
		}
		if(trim($infolist[19])=="Yes")
			$nav = 1;
		else $nav = 0;
		//echo $make.' '.$model.' '.$year.' '.$mpg.' '.$cartype.' '.$transmission.' '.$warranty.' '.$blueTooth.' '.$heat.' '.$engine.' '.$seats.' '.$cylinders.' '.$driveType.' '.$nav.'<br>';
		$queryString = "insert into cars (maker,model,specific_model,year,mpg,type,transmission,warranty,engine,seats,cylinders,drivetype,fuel,displacement,power,torque,price,bluetooth,heatseat,navigation)";
		$queryString = $queryString." values ('".$make."','".$model."','".$sp."',".$year.",'".$mpg."','".$cartype."','".$transmission."','".$warranty."','".$engine."',".$seats.",'".$cylinders."','".$driveType."','".$fuel."','".$displacement."','".$power."','".$torque."','".$price."',".$blueTooth.", ".$heat.", ".$nav.")";   
		//$queryString = "insert into cars (maker) values ('".$make."')";
		$result = $connect->query($queryString);
		if($result==TRUE){
			echo 'uploading...<br>';
		}
		else{
			//echo $queryString.'<br>';
			echo "Error: " . $queryString . "<br>" . $result->error.'<br><br>';
		}
	}
	fclose($file);
	$connect->close();
} else {
	echo 'Cannot open the file...';
}
?>