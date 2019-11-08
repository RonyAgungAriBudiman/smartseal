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

$tanggal   = date("Y-m-d",strtotime($_POST['tgl']));
$kerusakanid  = $_POST['kerusakanid'];
$perbaikan = $_POST['perbaikan'];
$analisa   = $_POST['analisa'];
$kategori  = $_POST['kategori'];
$status    = 'good';
$petugas1   = $_POST['petugas1'];
$petugas2   = $_POST['petugas2'];
$petugas3   = $_POST['petugas3'];

$sukses = false;
$sql ="UPDATE MTN_KERUSAKAN SET TanggalSelesai ='".$tanggal."',
								Perbaikan ='".$perbaikan."',
								Analisa   ='".$analisa."',
								Kategori  ='".$kategori."',
								Petugas1  ='".$petugas1."',
								Petugas2  ='".$petugas2."',
								Petugas3  ='".$petugas3."',
								Status    ='".$status."'	
		WHERE KerusakanID = '".$kerusakanid."'	  ";
$run =$sqlLib->update($sql);
$sukses=true;

if($sukses)
{	
	$sql_cek ="SELECT TOP(1) Indexing FROM MTN_KERUSAKAN WHERE KerusakanID ='".$kerusakanid."' ";
	$data=$sqlLib->select($sql_cek);



	$sql_up="UPDATE ms_index_maintenance SET Status ='".$status."'
					WHERE Indexing = '".$data[0]['Indexing']."' ";
	$run_up=$sqlLib->update($sql_up);				
}

?>


<div class="table-responsive" style="height:<?php echo $height?>px; background-color:#e3e8ee">
<table class="table table-striped fonttable">
<thead>
  <tr>
    <th>DESKRIPSI</th>
  </tr>
</thead>
<tbody>	
	<?php

	$sql_data ="SELECT COUNT(KerusakanID) as jmldata FROM MTN_KERUSAKAN
				WHERE  Tanggal = '".$tanggal."' AND Penerima = '".$_SESSION["userid"]."'  ";
	$jml_data =$sqlLib->select($sql_data);
	$no 	  = $jml_data[0]["jmldata"];		

	$sql = "SELECT TOP(1) * FROM MTN_KERUSAKAN
			WHERE  KerusakanID ='".$kerusakanid."'	ORDER BY Tanggal DESC";
	$data = $sqlLib->select($sql);		
	foreach($data as $row)
	{
		$sql_1 ="SELECT TOP(1) Nama FROM ms_karyawan WHERE NIK ='".$row["Petugas1"]."' " ;
		$data_1=$sqlLib->select($sql_1);

		$sql_2 ="SELECT TOP(1) Nama FROM ms_karyawan WHERE NIK ='".$row["Petugas2"]."' " ;
		$data_2=$sqlLib->select($sql_2);

		$sql_3 ="SELECT TOP(1) Nama FROM ms_karyawan WHERE NIK ='".$row["Petugas3"]."' " ;
		$data_3=$sqlLib->select($sql_3);
		?>
		<tr>
	        <td>
	        	INDEX : <br> 
	        	<?php echo $row["Indexing"]?><br>

	        	PERBAIKAN :<br> 
	        	<?php echo $row["Perbaikan"]?><br>

	        	ANALISA :<br> 
	        	<?php echo $row["Analisa"]?><br>

	        	HASIL :<br>	        	
	        	<?php echo $row["Status"]?><br>

	        	PETUGAS :<br>	        	
	        	<?php echo $data_1[0]["Nama"]?>, <?php echo $data_2[0]["Nama"]?>, <?php echo $data_2[0]["Nama"]?>  <br>







	        </td>
	    </tr>
	
	<?php $no--;} ?>


</tbody>
</table>
</div>	
