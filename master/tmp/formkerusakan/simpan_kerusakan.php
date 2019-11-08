<?php
session_start();
include_once "../../../sqlLib.php"; $sqlLib = new sqlLib();
if(!isset($_SESSION["userid"]) OR  !isset($_SESSION["nama"])) 
{
	if($_COOKIE["userid"]!="" AND $_COOKIE["nama"]!="")
	{
		$_SESSION["userid"] = $_COOKIE["userid"];
		$_SESSION["nama"] = $_COOKIE["nama"];
		$_SESSION["nik"] = $_COOKIE["nik"];
		$_SESSION["shift"] = $_COOKIE["shift"];
	}
	else header("Location:../../signin.php");
}

$tanggal   = date("Y-m-d H:i:s",strtotime($_POST['tgl']));
$indexing  = $_POST['indexing'];
$kerusakan = $_POST['kerusakan'];
$kategori  = $_POST['kategori'];
$pemberi   = $_POST['pemberi'];


$kerusakanid = date("YmdHis");
if($indexing!='')
{
	$sql ="INSERT INTO MTN_KERUSAKAN (KerusakanID, Tanggal, Indexing, Kerusakan, Pemberi, Status, Penerima)
			VALUES ('".$kerusakanid."', '".$tanggal."', '".$indexing."', '".$kerusakan."',  '".$pemberi."','perbaikan' , '".$_SESSION["userid"]."')";
	$run =$sqlLib->insert($sql);
	if($run=="1")
	{
		$sql_up="UPDATE ms_index_maintenance SET Status ='perbaikan'
						WHERE Indexing = '".$indexing."' ";
		$run_up=$sqlLib->update($sql_up);				
	}
}
else
{
               
    $warning = '1';
	$note .= "Index Harus di isi.";
}


if($warning=="") $height = "480";
else $height = "370";

if($warning=="0")
{
	?>
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-check"></i> BERHASIL DISIMPAN !</h4>
    Sudah berhasil disimpan ke database.
    </div>
    <?php 
}
else if($warning=="1")
{
	?>
    <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i> PERINGATAN !</h4>
    <?php echo $note?>
    </div>
    <?php 
} 
?>




<div class="table-responsive" style="height:<?php echo $height?>px; background-color:#e3e8ee">
<table class="table table-striped fonttable">
<thead>
  <tr>
    <th>NO</th>
    <th>INDEX</th>
    <th>KERUSAKAN</th> 
  </tr>
</thead>
<tbody>	
	<?php

	$sql_data ="SELECT COUNT(KerusakanID) as jmldata FROM MTN_KERUSAKAN
				WHERE  Tanggal = '".$tanggal."' AND Penerima = '".$_SESSION["userid"]."'  ";
	$jml_data =$sqlLib->select($sql_data);
	$no 	  = $jml_data[0]["jmldata"];		

	$sql = "SELECT TOP(10) * FROM MTN_KERUSAKAN
			WHERE Tanggal = '".$tanggal."' AND Penerima = '".$_SESSION["userid"]."' 	ORDER BY Tanggal DESC";
	$data = $sqlLib->select($sql);		
	foreach($data as $row)
	{?>
		<tr>
	        <td><?php echo $no?></td>
	        <td class="fokus"><?php echo $row["Indexing"]?></td>
	        <td><?php echo  $row["Kerusakan"]?></sup></td>
	    </tr>
	
	<?php $no--;} ?>


</tbody>
</table>
</div>	
