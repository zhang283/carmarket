<?php
include 'connectDB.php';
echo 'Initializing...<br>';

$file = fopen("allAvailable.txt", "r");
if ($file) {
	$connect=connectDB();
	$i=1;
	
	while (($line = fgets($file)) !== false) {
		$info = explode("\t", $line);
		
		$car = trim($info[0]);
		$vin = trim($info[2]);
		$sp = trim($info[1]);
		$p = trim($info[3]);
		$dealerName = trim($info[4]);
		
		$queryString = "insert into inventory (id,car,vin,specific_model,price,dealer)";
		$queryString = $queryString." values (".$i.",'".$car."',\"".$vin."\",'".$sp."','".$p."',\"".$dealerName."\")";
		$result = $connect->query($queryString);
		if($result==TRUE){
			echo 'uploading...';
			echo $i.'<br>';
			$i++;
		}
		else{
			//echo $queryString.'<br>';
			echo "Error: " . $queryString . "<br>" . $result->error.'<br><br>';
		}
	}
	fclose($file);
	$connect->close();
	echo '<br>Finish!';
} else {
	echo 'Cannot open the file...';
}
?>