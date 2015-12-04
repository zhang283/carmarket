<?php
require_once("connectDB.php");
$connect=connectDB();
$q = $_REQUEST["maker"]
?>
<option value="">Select Model</option>
<?php
if(strlen($q)>0) {
	$query = "select distinct model from cars where maker = '$q' order by model ASC";
	$results = $connect->query($query);

	foreach($results as $row) {
?>
	<option value="<?php echo $row["model"]; ?>"><?php echo $row["model"]; ?></option>
<?php
	}
}
$connect->close();
?>