<?php
include 'connectDB.php';
echo 'Initializing...<br>';

$file = fopen("allAvailable.txt", "r");
if ($file) {
	$connect=connectDB();
	$dealerArray = array();
	$i=1;
	
	while (($line = fgets($file)) !== false) {
		$info = explode("\t", $line);
		$dealerName = trim($info[4]);
		if(in_array($dealerName, $dealerArray)==false){
			array_push($dealerArray, $dealerName);
			$address = trim($info[5]);
			$zip = trim($info[6]);
			$phone = trim($info[7]);
			
			$queryString = "insert into dealer (id,name,address,zipcode,phonenumber)";
			$queryString = $queryString." values (".$i.",\"".$dealerName."\",\"".$address."\",'".$zip."','".$phone."')";
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
	}
	
	echo sizeof($dealerArray);
	fclose($file);
	$connect->close();
	echo '<br>Finish!';
} else {
	echo 'Cannot open the file...';
}
?>