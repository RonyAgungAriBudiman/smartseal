<?php
$sql_read="DELETE FROM ms_notifikasi WHERE TugasID = '".$_GET["tid"]."' AND UserID = '".$_SESSION["userid"]."'";
$run_read=$sqlLib->update($sql_read);

$sql ="SELECT * FROM ms_tugas WHERE TugasID = '".$_GET["tid"]."' " ;
$data=$sqlLib->select($sql);

$sql_project ="SELECT ProjectID, NamaProject FROM ms_project WHERE ProjectID = '".$data[0]["ProjectID"]."' " ;
$data_project =$sqlLib->select($sql_project);

$sql_tugas ="SELECT TugasID, Subject FROM ms_tugas WHERE TugasID = '".$data[0]["ParentID"]."' " ;
$data_tugas =$sqlLib->select($sql_tugas);

if(isset($_POST["closed"]))
{
	$sql ="UPDATE ms_tugas SET Closed = '1' WHERE TugasID = '".$_GET["tid"]."'" ;
	$run=$sqlLib->update($sql);
}
if(isset($_POST["open"]))
{
	$sql ="UPDATE ms_tugas SET Closed = '0' WHERE TugasID = '".$_GET["tid"]."'" ;
	$run=$sqlLib->update($sql);
	if($data[0]["ParentID"]>0)
	{
		$sql_progress = " SELECT (SUM(Progress)/COUNT(TugasID)) as Progress FROM ms_tugas WHERE ParentID = '".$data[0]["ParentID"]."' AND Closed = '0'" ;
		$data_progress = $sqlLib->select($sql_progress);
		
		$sql ="UPDATE ms_tugas SET Progress = '".$data_progress[0]["Progress"]."' WHERE TugasID = '".$data[0]["ParentID"]."'" ;
		$run=$sqlLib->update($sql);
	}
}
if(isset($_POST["simpan_notes"]))
{
	$progress = $_POST["progress"];
	$notes = $_POST["notes"];
	$notesid = date("YmdHis");
	
	if($notes != "")
	{
		$sql ="	INSERT INTO ms_notes(NotesID, Notes, Progress, AddedBy, AddedTime, TugasID) 
				VALUES('".$notesid."','".$notes."','".$progress."','".$_SESSION["userid"]."','".date("Y-m-d H:i:s")."','".$_GET["tid"]."')" ;
		$run=$sqlLib->insert($sql);
		
		if($run)
		{
			$sql ="UPDATE ms_tugas SET Progress = '".$progress."' WHERE TugasID = '".$_GET["tid"]."'" ;
			$run=$sqlLib->update($sql);
			if($run)
			{
				$sql_notif = "SELECT UserID FROM ms_project_anggota WHERE ProjectID = '".$data_project[0]["ProjectID"]."' AND UserID != '".$_SESSION["userid"]."'" ;
				$data_notif = $sqlLib->select($sql_notif);
				foreach ($data_notif as $row_notif)
				{
					$sql_save_notif ="INSERT INTO ms_notifikasi(UserID, TugasID) VALUES('".$row_notif["UserID"]."','".$_GET["tid"]."')";
					$run_save_notif =$sqlLib->insert($sql_save_notif);
				}
			}
			
			$total = count($_FILES['files']['name']);
			for( $i=0 ; $i < $total ; $i++ ) 
			{	
				$ext = end(explode(".",$_FILES['files']['name'][$i]));
				$tmpFilePath = $_FILES['files']['tmp_name'][$i];
				if ($tmpFilePath != "")
				{
					$filename = $notesid."_".$i.".".$ext;
					$newFilePath = "./upload/" . $filename;
					if(move_uploaded_file($tmpFilePath, $newFilePath))
					{
						$sql_file ="INSERT INTO ms_notes_files(File, NotesID) VALUES('".$filename."','".$notesid."')";
						$run_file =$sqlLib->insert($sql_file);
					}
				}
			}
		}
	}
}

$sql ="SELECT * FROM ms_tugas WHERE TugasID = '".$_GET["tid"]."' " ;
$data=$sqlLib->select($sql);

$sql_user ="SELECT Nama FROM ms_user WHERE UserID = '".$data[0]["AddedBy"]."' " ;
$data_user =$sqlLib->select($sql_user);
?>
<div class="tab-content box-body" style="background-color:#FFF; border-left:solid 1px #ddd">	
	<div style="padding:20px 0px">
		<div class="col-md-7">
			<h3 style="margin:0px"><?php echo $data[0]["Subject"]?></h3>
		<div style="color:#666; margin-bottom:10px"><i><?php echo $data[0]["Keterangan"]?></i></div>
		<div>Added By <a href="index.php?m=activity&uid=<?php echo $data[0]["AddedBy"]?>"><?php echo $data_user[0]["Nama"]?></a> at date <?php echo date("d F Y",strtotime($data[0]["AddedTime"]))?></div>			
		</div>
		<div class="col-md-5 row">
			<div class="form-group">
				<div class="col-md-2"><b>Project</b></div>
				<div class="col-md-10"><a href="index.php?m=project&sm=detail&pid=<?php echo $data_project[0]["ProjectID"]?>"><?php echo strtoupper($data_project[0]["NamaProject"])?></a></div>
			</div>
			<?php
			if($data_tugas[0]["Subject"]!="")
			{?>
			<div class="row"></div>
			<div class="form-group">
				<div class="col-md-2"><b>Parent</b></div>
				<div class="col-md-10"><a href="index.php?m=tugas&sm=detail&tid=<?php echo $data_tugas[0]["TugasID"]?>"><?php echo strtoupper($data_tugas[0]["Subject"])?></a></div>
			</div>
			<?php }?>
			<div class="row"></div>
			<div class="form-group">
				<div class="col-md-2"><b>Start Date</b></div>
				<div class="col-md-10"><?php echo date("d-M-Y",strtotime($data[0]["Dari"]))?></div>
			</div>
			<div class="row"></div>
			<div class="form-group">
				<div class="col-md-2"><b>End Date</b></div>
				<div class="col-md-10"><?php echo date("d-M-Y",strtotime($data[0]["Sampai"]))?></div>
			</div>
			<div class="row"></div>
			<div class="form-group">
				<div class="col-md-2"><b>PIC</b></div>
				<div class="col-md-10">
				<?php
				$sql_ang ="SELECT a.UserID, b.Nama FROM ms_tugas_pic a LEFT JOIN ms_user b ON b.UserID = a.UserID WHERE a.TugasID ='".$_GET["tid"]."'";
				$data_ang= $sqlLib->select($sql_ang);
				foreach($data_ang as $row_ang)
				{?>
					<a href="index.php?m=activity&uid=<?php echo $row_ang["UserID"]?>"><?php echo $row_ang["Nama"]?></a>, 
				<?php }?>
				</div>
			</div>
			<div class="row"></div>
			<div class="form-group">
				<div class="col-md-2"><b>Progress</b></div>
				<div class="col-md-10 row">
					<div class="col-md-11">
						<?php						
						$sql_pers ="SELECT COUNT(TugasID) as Jml, SUM(Progress) as Progress FROM ms_tugas WHERE ParentID = '".$data[0]["ProjectID"]."' AND Closed = '0'" ;
						$data_pers =$sqlLib->select($sql_pers);		
						if($data_pers[0]["Jml"] > 0) $data[0]["Progress"] = ($data_pers[0]["Progress"]/$data_pers[0]["Jml"]);
				
						$time_dari = strtotime($data[0]["Dari"]);
						$time_sampai = strtotime($data[0]["Sampai"]);
						$time_sekarang = strtotime(date("Y-m-d"));
						
						$lama_tugas = (($time_sampai-$time_dari)/(60*60*24));
						$lama_lewat = (($time_sekarang-$time_dari)/(60*60*24));
						$lama_pers = (($lama_lewat/$lama_tugas)*100);	
						
						if($lama_pers<=$data[0]["Progress"]) $css = "green";
						else if($lama_pers>$data[0]["Progress"] AND $data[0]["Progress"] < "100") $css = "red";
						else if($lama_pers>$lama_tugas AND $data[0]["Progress"] < "100") $css = "red";
						else if($data[0]["Progress"]=="100") $css = "green";
						?>
						<div class="progress progress-xs" style="margin-top:10px">
						  <div class="progress-bar progress-bar-<?php echo $css?>" style="width: <?php echo $data[0]["Progress"]?>%"></div>
						</div>
					</div>
					<div class="col-md-1">
					<span class="badge bg-<?php echo $css?>"><?php echo $data[0]["Progress"]?>%</span>
					</div>					
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12" style="margin-bottom:10px">
		<?php
		if($data[0]["AddedBy"] == $_SESSION["userid"] OR $_SESSION["admin"]=="1")
		{?>
			<a href="index.php?m=tugas&sm=add&pid=<?php echo $data[0]["ProjectID"]?>&tid=<?php echo $_GET["tid"]?>"><button type="button" name="simpan" class="btn btn-primary" >Edit Tugas</button></a>		
		<?php
		}
		if($data[0]["Progress"]=="100" AND $data[0]["Closed"]=="0")
		{
			?>
			<form method="post" style="display:inline">
			<button type="submit" name="closed" class="btn btn-danger" onclick="return confirm('anda yakin?');" >Closed</button>
			</form>
			<?php
		}
		else if($data[0]["Closed"]=="1")
		{
			?>
			<form method="post" style="display:inline">
			<button type="submit" name="open" class="btn btn-danger" onclick="return confirm('anda yakin?');" >Un Closed</button>
			</form>
			<?php
		}
		if($data[0]["ParentID"]=="0")
		{?>
			<a href="index.php?m=tugas&sm=add&pid=<?php echo $data[0]["ProjectID"]?>&prnid=<?php echo $_GET["tid"]?>"><button type="button" name="simpan" class="btn btn-primary" >Tambah Sub Tugas</button></a>
		<?php }?>
	</div>
	<?php
	$sql_tugas ="SELECT * FROM ms_tugas WHERE ParentID = '".$_GET["tid"]."'" ;
	$data_tugas =$sqlLib->select($sql_tugas);
	if(count($data_tugas)>0)
	{?>
	<div class="box-body">
	  <table class="table table-bordered">
		<tr>
		  <th style="width: 10px">#</th>
		  <th>Sub Tugas</th>
		  <!--<th>PIC</th>-->
		  <th>Progress</th>
		  <th style="width: 40px">Label</th>
		</tr>
		<?php
		$i=1;
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
			  <td><a href="index.php?m=tugas&sm=detail&tid=<?php echo $row_tugas["TugasID"]?>"><?php echo $row_tugas["Subject"]?></td>
			  <!--
			  <td>
			  <?php
			  /*
				$sql_ang ="SELECT a.UserID, b.Nama FROM ms_tugas_pic a LEFT JOIN ms_user b ON b.UserID = a.UserID WHERE a.TugasID ='".$row_tugas["TugasID"]."'";
				$data_ang= $sqlLib->select($sql_ang);
				foreach($data_ang as $row_ang)
				{?>
					<a href="#"><?php echo $row_ang["Nama"]?></a>, 
				<?php }*/?>
			  </td>
			  -->
			  <td>
				<div class="progress progress-xs">
				  <div class="progress-bar progress-bar-<?php echo $css?>" style="width: <?php echo $row_tugas["Progress"]?>%"></div>
				</div>
			  </td>
			  <td><span class="badge bg-<?php echo $css?>"><?php echo $row_tugas["Progress"]?>%</span></td>
			</tr>
		<?php $i++;}?>
	  </table>
	</div>
	<!-- /.box-body -->
	<?php }?>
	<form method="post" enctype="multipart/form-data">
	<div class="col-md-12" style="margin-top:20px">
		
		<div class="row">
			<?php
			if(count($data_tugas)==0)
			{?>
			<div class="form-group col-md-6">
				<label for="project">Progress</label>
				<select name="progress" id="progress" class="form-control">
					<?php
					for($i=0; $i<=100; $i+=10)
					{?>
						<option value="<?php echo $i?>" <?php if($data[0]["Progress"]==$i){ echo "selected";}?>><?php echo $i?>%</option>
					<?php }?>
				</select>
			</div>
			<?php }else{?>
				<input type="hidden" name="progress" value="<?php echo $data[0]["Progress"]?>">
			<?php }?>
			<div class="form-group col-md-6">
				<label for="project">Files</label>
				<input type="file" name="files[]" class="form-control" multiple>
			</div>
		</div>
		<div class="row"></div>
		<div class="form-group">
			<label for="project">Notes</label>
			<textarea name="notes" class="form-control" style="height:80px"></textarea>
		</div>
		<button type="submit" name="simpan_notes" class="btn btn-primary" >Simpan Notes</button>
		
	</div>
	</form>
  </div>
  <div class="col-md-12" style="margin-top:10px">
  <?php
	$sql_notes ="	SELECT a.*, b.Nama 
					FROM ms_notes a
					LEFT JOIN ms_user b ON b.UserID = a.AddedBy
					WHERE a.TugasID = '".$_GET["tid"]."' ORDER BY AddedTime DESC";
	$data_notes = $sqlLib->select($sql_notes);
	foreach($data_notes as $row_notes)
	{
		if($row_notes["Progress"] == 100) $css = "green";
		else if($row_notes["Progress"] >= 50) $css = "yellow";
		else if($row_notes["Progress"] < 50) $css = "red";
		?>
		<div>
			<div style="border-bottom:solid 1px #CCC; padding: 10px 0px 5px 0px">
			Added notes by <a href="#"><?php echo $row_notes["Nama"]?></a> at <a href="#"><?php echo date("d M Y H:i", strtotime($row_notes["AddedTime"]))?></a>
			</div>
			<div style="padding:5px 0px">
			Update Progres <span class="badge bg-<?php echo $css?>"><?php echo $row_notes["Progress"]?>%</span>
			<div style="padding:5px 0px">
			<i><?php echo str_replace("\n","<br>",$row_notes["Notes"])?><br>
			<?php
			$sql_file ="SELECT `File` FROM ms_notes_files WHERE NotesID = '".$row_notes["NotesID"]."' ORDER BY `File` ASC";
			$data_file =$sqlLib->select($sql_file);
			if(count($data_file)>0)
			{
				echo "<div style='padding-top:10px'>Attach :</div>";
				foreach($data_file as $row_file)
				{
					?><a href="upload/<?php echo $row_file["File"]?>"><?php echo $row_file["File"]?></a>, <?php
				}
			}
			?>
			</i>
			</div>
			</div>
		</div>
	<?php }?>
	</div>
</div>
