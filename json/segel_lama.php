<?php
$term = $_GET['term'];
$id_meter = $_GET['id_meter'];

$return_arr = array();	
$query = "SELECT DISTINCT NoSegel FROM ms_pemasangan WHERE IDMeter LIKE '%$term%' AND Status ='aktif'   LIMIT 5";
$link = mysqli_connect('localhost', 'root', '', 'db_smartseal');
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_array($result))
{
  		$row_array["value"] 		= $row["NoSegel"];
		$row_array["no_segel_lama"] = $row['NoSegel'];
		
		array_push($return_arr, $row_array);
}
echo json_encode($return_arr);
?>