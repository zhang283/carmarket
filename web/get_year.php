<?php
require_once("connectDB.php");
$connect=connectDB();
$q = $_REQUEST["model"]
?>
<option value="">Select Year</option>
<?php
if(strlen($q)>0) {
	$query = "select distinct year from cars where model = '$q' order by year DESC";
	$results = $connect->query($query);

	foreach($results as $row) {
?>
	<option value="<?php echo $row["year"]; ?>"><?php echo $row["year"]; ?></option>
<?php
	}
}
$connect->close();
?>