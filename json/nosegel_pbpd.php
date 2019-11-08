<?php
$term = $_GET['term'];
$areaid = $_GET['areaid'];
$query = "SELECT NoSegel FROM ms_pengambilan WHERE NoSegel LIKE '%$term%' AND Status ='ready' AND AreaID='$areaid' AND Bidang ='PBPD'  LIMIT 5";
$link = mysqli_connect('localhost', 'root', '', 'db_smartseal');
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_array($result))
{
    $data[] = array('id'=>$row['NoSegel'],'label'=>$row['NoSegel'],'value'=>$row['NoSegel']);
}
echo json_encode($data);
?>