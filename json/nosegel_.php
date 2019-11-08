<?php
//include "../koneksi_sql.php";

include_once "../sqlLib.php";  $sqlLib = new sqlLib();

// escape your parameters to prevent sql injection
$term = trim(strip_tags($_GET['term']));
//$jenis = $_GET["jenis"];
// fetch a title for a better user experience maybe..

$tgl = date("Y-d-m");
$dari= date("Y-01-01");
$sql = "SELECT a.NoSegel
		FROM ms_pengambilan a
		WHERE a.NoSegel != '' AND a.Status ='ready'  
		AND ( a.NoSegel LIKE '%".$term."%'	 OR a.NoSegel LIKE '".$term."%' )";
$sql .= " ORDER BY a.NoSegel ASC LIMIT 10 ";
$run  = $sqlLib->select($sql);
foreach ($run as $data) /*{
	# code...
}
$run = sqlsrv_query( $conn, $sql);
while($data = sqlsrv_fetch_array($run))*/
{

    $row['id']		=$data[0]['NoSegel'];
	$row['value']	=$data[0]['NoSegel'];
	$row['nosegel']	=$data[0]['NoSegel'];
	
	//buat array yang nantinya akan di konversi ke json
    $row_set[] = $row;
}
echo json_encode($row_set);
?>