<?php
include 'connectDB.php';
echo 'Initializing...<br>';

$file = fopen("output.csv", "r");
if ($file) {
	$connect=connectDB();
	while (($line = fgets($file)) !== false) {
		$infolist = explode(",", $line);
		$sp = trim($infolist[3]);
		$label = trim(end($infolist));
		echo "for sp = ".$sp." and label = ".$label."<br>";
		$queryString = "update cars set label = '$label' where specific_model = '$sp'";
		$result = $connect->query($queryString);
		if($result==TRUE){
			echo "uploading...'$label' and '$sp'<br>";
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