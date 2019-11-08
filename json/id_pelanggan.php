<?php
$term = $_GET['term'];
$areaid = $_GET['areaid'];

$return_arr = array();	
$query = "SELECT DISTINCT IDPelanggan, IDMeter FROM ms_pemasangan WHERE IDPelanggan LIKE '%$term%' AND Status ='aktif' AND AreaID='$areaid'  LIMIT 5";
$link = mysqli_connect('localhost', 'root', '', 'db_smartseal');
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_array($result))
{
  		$row_array["value"] 		= $row["IDPelanggan"];
		$row_array["id_pelanggan"] 	= $row['IDPelanggan'];
		$row_array["id_meter"] 		= $row['IDMeter'];
		
		array_push($return_arr, $row_array);
}
echo json_encode($return_arr);
?>