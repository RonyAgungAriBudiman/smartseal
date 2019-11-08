<?php
$sql ="SELECT Nama FROM ms_user WHERE UserID ='".$_GET["uid"]."'";
$data= $sqlLib->select($sql);
?>
<div class="tab-content box-body" style="background-color:#FFF; border-left:solid 1px #ddd">
<div style="padding:20px">
<div style="font-size:32px; margin-bottom:0px"><?php echo $data[0]["Nama"]?></div>
<form method="post" autocomplete="off">
<input type="text" name="tgl" class="form-control tgl" placeholder="Semua Tanggal" style="font-size:18px; padding:0px 0px 10px 0px; margin-bottom:10px; border:none; border-bottom:solid 1px #CCC" onchange="submit();" value="<?php echo $_POST["tgl"]?>">
</form>
<?php
$kondisi = "";
if($_POST["tgl"] != "") $kondisi = " AND DATE(AddedTime) = '".date("Y-m-d",strtotime($_POST["tgl"]))."' ";
$sql ="SELECT DISTINCT(DATE(AddedTime)) as Tgl FROM view_log WHERE AddedBy ='".$_GET["uid"]."' ".$kondisi." ORDER BY Tgl DESC LIMIT 7";
$data= $sqlLib->select($sql);
foreach($data as $row)
{
	echo "<div style='font-size:16px;border-bottom:solid 1px #CCC; padding-bottom:5px; margin-bottom:10px; margin-top:20px'><b>".date("l, d F Y",strtotime($row["Tgl"]))."</b></div>";
	$sql_det ="SELECT * FROM view_log WHERE AddedBy ='".$_GET["uid"]."' AND DATE(AddedTime) = '".date("Y-m-d",strtotime($row["Tgl"]))."' ORDER BY AddedTime DESC";
	$data_det = $sqlLib->select($sql_det);
	foreach($data_det as $row_det)
	{
		if($row_det["Kategori"]=="tugas")
		{
			$sql_detail = "SELECT * FROM ms_tugas WHERE TugasID = '".$row_det["ID"]."'";
			$data_detail = $sqlLib->select($sql_detail);
			
			$sql_pro = "SELECT ProjectID, NamaProject FROM ms_project WHERE ProjectID = '".$data_detail[0]["ProjectID"]."'";
			$data_pro = $sqlLib->select($sql_pro);
			
			$sql_tugas = "SELECT TugasID, Subject, Keterangan FROM ms_tugas WHERE TugasID = '".$data_detail[0]["TugasID"]."'";
			$data_tugas = $sqlLib->select($sql_tugas);
			
			$sql_nama = "SELECT UserID, Nama FROM ms_user WHERE UserID = '".$row_det["AddedBy"]."'";
			$data_nama = $sqlLib->select($sql_nama);
			?>
			<div style="padding-bottom:5px">
				<span style="font-size:14px; padding:5px; background-color:#efefef; margin-right:10px"><i class="fa fa-clock-o"></i> <?php echo date("H:i", strtotime($data_detail[0]["AddedTime"]));?></span>
				<a href="index.php?m=project&sm=detail&pid=<?php echo $data_pro[0]["ProjectID"]?>">
				<i class="fa fa-folder"></i> <?php echo ucwords(strtolower($data_pro[0]["NamaProject"]))?></a>  
				Added Tugas : <a href="index.php?m=tugas&sm=detail&tid=<?php echo $data_tugas[0]["TugasID"]?>"><i class="fa fa-book"></i> <?php echo $data_tugas[0]["Subject"]?></a> By <a href="index.php?m=activity&uid=<?php echo $data_nama[0]["UserID"]?>"><?php echo $data_nama[0]["Nama"]?></a>
			</div>
			<?php
			if($data_tugas[0]["Keterangan"] != "")
			{?>
				<div style="padding:10px 0px 30px 30px; color:#666">
				<i><?php echo $data_tugas[0]["Keterangan"]?></i>
				</div>
				<?php
			}
		}
		else if($row_det["Kategori"]=="notes")
		{
			$sql_detail = "SELECT * FROM ms_notes WHERE NotesID = '".$row_det["ID"]."'";
			$data_detail = $sqlLib->select($sql_detail);
			
			$sql_tugas = "SELECT ProjectID, TugasID, Subject, Keterangan FROM ms_tugas WHERE TugasID = '".$data_detail[0]["TugasID"]."'";
			$data_tugas = $sqlLib->select($sql_tugas);
			
			
			$sql_pro = "SELECT ProjectID, NamaProject FROM ms_project WHERE ProjectID = '".$data_tugas[0]["ProjectID"]."'";
			$data_pro = $sqlLib->select($sql_pro);
			
			$sql_nama = "SELECT UserID, Nama FROM ms_user WHERE UserID = '".$data_detail[0]["AddedBy"]."'";
			$data_nama = $sqlLib->select($sql_nama);
			
			if($data_detail[0]["Progress"] == 100) $css = "green";
			else if($data_detail[0]["Progress"] >= 50) $css = "yellow";
			else if($data_detail[0]["Progress"] < 50) $css = "red";
			?>
			<div>
			<span style="font-size:14px; padding:5px; background-color:#efefef; margin-right:10px"><i class="fa fa-clock-o"></i> <?php echo date("H:i", strtotime($data_detail[0]["AddedTime"]));?></span>
			<a href="index.php?m=project&sm=detail&pid=<?php echo $data_pro[0]["ProjectID"]?>">
			<i class="fa fa-folder"></i> <?php echo ucwords(strtolower($data_pro[0]["NamaProject"]))?></a>  Tugas : 
			<a href="index.php?m=tugas&sm=detail&tid=<?php echo $data_tugas[0]["TugasID"]?>">
			<i class="fa fa-book"></i> <?php echo $data_tugas[0]["Subject"]?></a>
			Added Notes By <a href="index.php?m=activity&uid=<?php echo $data_nama[0]["UserID"]?>"><?php echo $data_nama[0]["Nama"]?></a></div>
			<div style="padding:0px 0px 30px 30px; color:#666">
			
			<div style="padding:5px 0px">
			Update Progres <span class="badge bg-<?php echo $css?>"><?php echo $data_detail[0]["Progress"]?>%</span>
			</div>
			
			<i><?php echo str_replace("\n","<br>",$data_detail[0]["Notes"])?></i></div>
			<?php
		}
	}
}
?>
</div>
</div>
</div>