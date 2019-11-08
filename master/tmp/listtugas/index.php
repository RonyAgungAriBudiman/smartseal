<!-- /.box-header -->
<?php
if($_POST["closed"]=="") $_POST["closed"] = "0";
?>
<div class="box box-primary">
  <div class="col-md-12" style="margin:10px 0px">
	<form method="post">
	<select name="closed" id="closed" class="form-control col-md-3" onchange="submit();">
		<option value="all">All Status</option>
		<option value="1" <?php if($_POST["closed"]=="1"){ echo "selected";}?>>Closed</option>
		<option value="0" <?php if($_POST["closed"]=="0"){ echo "selected";}?>>Un Closed</option>
	</select>
	</form>
  </div>
  <div style="padding:0px 15px">
  <table id="dtHorizontalVerticalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
	<thead>
	<tr>
	  <th style="width:10px">No.</th>
	  <th>Tugas</th>
	  <th>Project</th>
	  <th>PIC</th>
	  <th>Progress</th>
	  <th style="width: 40px">Label</th>
	</tr>
	<thead>
	<tbody>
	<?php
	$i=1;
	$kondisi = "";
	if($_POST["closed"] != "all") $kondisi .= " AND Closed = '".$_POST["closed"]."' ";
	$sql_tugas ="	SELECT DISTINCT(a.TugasID), a.ProjectID, a.Subject, a.Dari, a.Sampai, a.Keterangan, a.Progress, c.NamaProject  
					FROM ms_tugas a 
					LEFT JOIN ms_project_anggota b ON b.ProjectID = a.ProjectID
					LEFT JOIN ms_project c ON c.ProjectID = a.ProjectID
					WHERE a.ParentID = '0' AND (b.UserID = '".$_SESSION["userid"]."' OR '".$_SESSION["admin"]."' = '1') ".$kondisi." 
					ORDER BY a.AddedTime DESC" ;
	$data_tugas =$sqlLib->select($sql_tugas);
	foreach($data_tugas as $row_tugas)
	{
		$sql_pers ="SELECT COUNT(TugasID) as Jml, SUM(Progress) as Progress FROM ms_tugas WHERE ParentID = '".$row_tugas["ProjectID"]."' AND Closed = '0'" ;
		$data_pers =$sqlLib->select($sql_pers);		
		if($data_pers[0]["Jml"] > 0) $row_tugas["Progress"] = ($data_pers[0]["Progress"]/$data_pers[0]["Jml"]);
		
		$time_dari = strtotime($row_tugas["Dari"]);
		$time_sampai = strtotime($row_tugas["Sampai"]);
		$time_sekarang = strtotime(date("Y-m-d"));
		
		$lama_tugas = (($time_sampai-$time_dari)/(60*60*24));
		$lama_lewat = (($time_sekarang-$time_dari)/(60*60*24));
		$lama_pers = (($lama_lewat/$lama_tugas)*100);	
				
		if($lama_pers<=$row_tugas["Progress"]) $css = "green";
		else if($lama_pers>$row_tugas["Progress"] AND $row_tugas["Progress"] < "100") $css = "red";
		else if($lama_pers>$lama_tugas AND $row_tugas["Progress"] < "100") $css = "red";
		else if($row_tugas["Progress"]=="100") $css = "green";
		?>
		<tr>
		  <td><?php echo $i?>.</td>
		  <td><a href="index.php?m=tugas&sm=detail&tid=<?php echo $row_tugas["TugasID"]?>" style="white-space: nowrap;"><?php echo $row_tugas["Subject"]?></td>
		  <td><a href="index.php?m=project&sm=detail&tid=<?php echo $row_tugas["ProjectID"]?>" style="white-space: nowrap;"><?php echo ucwords(strtolower($row_tugas["NamaProject"]))?></td>
		  <td style="white-space: nowrap;">
		  <?php
			$sql_ang ="SELECT a.UserID, b.Nama FROM ms_tugas_pic a LEFT JOIN ms_user b ON b.UserID = a.UserID WHERE a.TugasID ='".$row_tugas["TugasID"]."'";
			$data_ang= $sqlLib->select($sql_ang);
			foreach($data_ang as $row_ang)
			{?>
				<a href="index.php?m=activity&uid=<?php echo $row_ang["UserID"]?>"><?php echo $row_ang["Nama"]?></a>, 
			<?php }?>
		  </td>
		  <td>
			<div class="progress progress-xs">
			  <div class="progress-bar progress-bar-<?php echo $css?>" style="width: <?php echo $row_tugas["Progress"]?>%"></div>
			</div>
		  </td>
		  <td><span class="badge bg-<?php echo $css?>"><?php echo $row_tugas["Progress"]?>%</span></td>
		</tr>
		<?php
		$sql_subtugas ="SELECT a.*, b.NamaProject
						FROM ms_tugas a
						LEFT JOIN ms_project b ON b.ProjectID = a.ProjectID
						WHERE a.ParentID = '".$row_tugas["TugasID"]."'".$kondisi." ORDER BY a.AddedTime DESC" ;
		$data_subtugas =$sqlLib->select($sql_subtugas);
		foreach($data_subtugas as $row_subtugas)
		{
			$i++;
			$time_dari = strtotime($row_subtugas["Dari"]);
			$time_sampai = strtotime($row_subtugas["Sampai"]);
			$time_sekarang = strtotime(date("Y-m-d"));
			
			$lama_tugas = (($time_sampai-$time_dari)/(60*60*24));
			$lama_lewat = (($time_sekarang-$time_dari)/(60*60*24));
			$lama_pers = (($lama_lewat/$lama_tugas)*100);	
			
			if($lama_pers<=$row_subtugas["Progress"]) $css = "green";
			else if($lama_pers>$row_subtugas["Progress"] AND $row_subtugas["Progress"] < "100") $css = "red";
			else if($lama_pers>$lama_tugas AND $row_subtugas["Progress"] < "100") $css = "red";
			else if($row_subtugas["Progress"]=="100") $css = "green";
			?>
			<tr>
			  <td><?php echo $i?>.</td>
			  <td style="padding-left:30px">
			  <?php 
					$sql_inbox = "	SELECT COUNT(a.UserID) as Jml FROM ms_notifikasi a 
									WHERE a.UserID = '".$_SESSION["userid"]."' AND a.TugasID = '".$row_subtugas["TugasID"]."'";
					$data_inbox= $sqlLib->select($sql_inbox);
					if($data_inbox[0]["Jml"]>0)
					{
					?>
						<span class="badge bg-red" style="float:right; margin-right:10px"><?php echo $data_inbox[0]["Jml"]?></span>
					<?php }?>
					<a href="index.php?m=tugas&sm=detail&tid=<?php echo $row_subtugas["TugasID"]?>"><?php echo $row_subtugas["Subject"]?>
			  </td>
			  <td><a href="index.php?m=project&sm=detail&tid=<?php echo $row_subtugas["ProjectID"]?>"><?php echo ucwords(strtolower($row_subtugas["NamaProject"]))?></td>
			  <td>
				<?php
				$sql_ang ="SELECT a.UserID, b.Nama FROM ms_tugas_pic a LEFT JOIN ms_user b ON b.UserID = a.UserID WHERE a.TugasID ='".$row_subtugas["TugasID"]."'";
				$data_ang= $sqlLib->select($sql_ang);
				foreach($data_ang as $row_ang)
				{?>
					<a href="index.php?m=activity&uid=<?php echo $row_ang["UserID"]?>"><?php echo $row_ang["Nama"]?></a>, 
				<?php }?>
			  </td>
			  <td>
				<div class="progress progress-xs">
				  <div class="progress-bar progress-bar-<?php echo $css?>" style="width: <?php echo $row_subtugas["Progress"]?>%"></div>
				</div>
			  </td>
			  <td><span class="badge bg-<?php echo $css?>"><?php echo $row_subtugas["Progress"]?>%</span></td>
			</tr>
			<?php 
		}
		?>
	<?php $i++;}?>
	</tbody>
  </table>
  </div>
</div>

<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


<script type="text/javascript">
$(document).ready(function () {
$('#dtHorizontalVerticalExample').DataTable({
"scrollX": true,
"scrollY": false,
"paging" : false,
"searching" : true,
"info"   : false,
});
$('.dataTables_length').addClass('bs-select');
});
</script>