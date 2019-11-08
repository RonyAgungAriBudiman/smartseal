<?php
if($_POST["pid"]=="" AND $_GET["pid"] != "") $_POST["pid"] = $_GET["pid"];
if(isset($_POST["delete"]))
{
	$projectid = $_POST["pid"];
	$sql_delete ="DELETE FROM ms_project WHERE ProjectID = '".$projectid."'";
	$run_delete=$sqlLib->update($sql_delete);
	
	$sql_delete ="DELETE FROM ms_project_anggota WHERE ProjectID = '".$projectid."'";
	$run_delete=$sqlLib->update($sql_delete);
	
	$sql_tid ="SELECT TugasID FROM ms_tugas WHERE ProjectID = '".$tugasid."'";
	$data_tid =$sqlLib->select($sql_tid);
	foreach($data_tid as $row_tid)
	{
		$sql_delete ="DELETE FROM ms_tugas WHERE ProjectID = '".$row_tid["TugasID"]."' OR ParentID = '".$row_tid["TugasID"]."'";
		$run_delete=$sqlLib->update($sql_delete);
		
		$sql_delete ="DELETE FROM ms_tugas_pic WHERE TugasID = '".$row_tid["TugasID"]."'";
		$run_delete=$sqlLib->update($sql_delete);
		
		$sql_delete ="DELETE FROM ms_notes WHERE TugasID = '".$row_tid["TugasID"]."'";
		$run_delete=$sqlLib->update($sql_delete);
		
		$sql_file ="SELECT `File` FROM ms_notes_files WHERE TugasID = '".$row_tid["TugasID"]."'";
		$data_file =$sqlLib->select($sql_file);
		foreach($data_file as $row_file)
		{
			if($row_file["File"] != "")
			{
				if(file_exists("upload/".$row_file["File"])) unlink("upload/".$row_file["File"]); 
			}
		}
	}
	echo '<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h4><i class="icon fa fa-check"></i> Berhasil di Delete!</h4>
		  </div>';
}
if(isset($_POST["update"]))
{
	$nama = $_POST["namaproject"];
	$keterangan = $_POST["keterangan"];
	$indukproject = $_POST["indukproject"];
	$chkanggota = $_POST["chkanggota"];
	$projectid = $_POST["pid"];
	
	if($nama != "")
	{
		$sql_update ="	UPDATE ms_project SET 	NamaProject = '".$nama."', 
													Keterangan = '".$keterangan."', 
													ParentID = '".$indukproject."', 
													AnggotaInduk = '".$chkanggota."'
						WHERE ProjectID = '".$projectid."'";
		$run_update=$sqlLib->update($sql_update);
		
		if($run_update)
		{
			$sql_delete ="DELETE FROM ms_project_anggota WHERE ProjectID = '".$projectid."' " ;
			$data_delete =$sqlLib->select($sql_delete);
				
			if($indukproject > 0 AND $chkanggota == "1")
			{			
				$sql ="SELECT UserID FROM ms_project_anggota WHERE ProjectID = '".$indukproject."' " ;
				$data=$sqlLib->select($sql);
				foreach ($data as $row)
				{
					$sql_save ="INSERT INTO ms_project_anggota(UserID, ProjectID) VALUES('".$row["UserID"]."','".$projectid."')";
					$run_save =$sqlLib->insert($sql_save);
				}
			}
			else
			{
				foreach ($_POST["chklistanggota"] as $userid)
				{
					$sql_save ="INSERT INTO ms_project_anggota(UserID, ProjectID) VALUES('".$userid."','".$projectid."')";
					$run_save =$sqlLib->insert($sql_save);
				}
			}
			
			echo '<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil di Simpan!</h4>
				  </div>';
		}
		else{
			echo '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-ban"></i> Gagal di Simpan!</h4>
				  </div>';
		}
		
		unset($_POST);
	}
}
if(isset($_POST["simpan"]))
{
	$nama = $_POST["namaproject"];
	$keterangan = $_POST["keterangan"];
	$indukproject = $_POST["indukproject"];
	$chkanggota = $_POST["chkanggota"];
	$projectid = date("YmdHis");
	
	if($nama != "")
	{
		$sql_save ="INSERT INTO ms_project(ProjectID, NamaProject, Keterangan, ParentID, AnggotaInduk, AddedBy, AddedTime) 
					VALUES('".$projectid."','".$nama."','".$keterangan."','".$indukproject."','".$chkanggota."','".$_SESSION["userid"]."','".date("Y-m-d H:i:s")."')";
		$run_save=$sqlLib->insert($sql_save);
		
		if($run_save)
		{
			if($indukproject > 0 AND $chkanggota == "1")
			{
				$sql ="SELECT UserID FROM ms_project_anggota WHERE ProjectID = '".$indukproject."' " ;
				$data=$sqlLib->select($sql);
				foreach ($data as $row)
				{
					$sql_save ="INSERT INTO ms_project_anggota(UserID, ProjectID) VALUES('".$row["UserID"]."','".$projectid."')";
					$run_save =$sqlLib->insert($sql_save);
				}
			}
			else
			{
				foreach ($_POST["chklistanggota"] as $userid)
				{
					$sql_save ="INSERT INTO ms_project_anggota(UserID, ProjectID) VALUES('".$userid."','".$projectid."')";
					$run_save =$sqlLib->insert($sql_save);
				}
			}
			
			echo '<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil di Simpan!</h4>
				  </div>';
		}
		else{
			echo '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-ban"></i> Gagal di Simpan!</h4>
				  </div>';
		}
		
		unset($_POST);
	}
}

if($_POST["pid"] != "")
{
	$sql ="SELECT * FROM ms_project WHERE ProjectID = '".$_POST["pid"]."' " ;
	$data=$sqlLib->select($sql);
	
	$_POST["addedby"] = $data[0]["AddedBy"];
	$_POST["namaproject"] = $data[0]["NamaProject"];
	$_POST["keterangan"] = $data[0]["Keterangan"];
	$_POST["indukproject"] = $data[0]["ParentID"];
	$_POST["chkanggota"] = $data[0]["AnggotaInduk"];
}
?>
<form method="post" action="index.php?m=project&sm=add">
<input type="hidden" name="pid" value="<?php echo $_POST["pid"]?>">
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#info">INFO</a></li>
    <li><a data-toggle="tab" href="#anggota">ANGGOTA</a></li>
  </ul>

  <div class="tab-content box-body" style="background-color:#FFF; border-left:solid 1px #ddd">
    <div id="info" class="tab-pane fade in active">
		<?php include "master/project/add_info.php";?>
    </div>
    <div id="anggota" class="tab-pane fade">
      <?php include "master/project/add_anggota.php";?>
    </div>
  </div>
  <?php
  if($_POST["pid"]=="")
  {?>
	<button type="submit" name="simpan" class="btn btn-primary" style="margin-top:10px" >Simpan Project</button>
  <?php }else if($_POST["addedby"] == $_SESSION["userid"] OR $_SESSION["admin"]=="1"){?>
	<button type="submit" name="update" class="btn btn-primary" style="margin-top:10px" >Update Project</button>
	<?php
	$sql_sub ="SELECT COUNT(ProjectID) as Jml FROM ms_project WHERE ParentID = '".$_POST["pid"]."' " ;
	$data_sub =$sqlLib->select($sql_sub);
	if($data_sub[0]["Jml"]==0 AND ($_POST["addedby"] == $_SESSION["userid"] OR $_SESSION["admin"]=="1"))
	{?>
		<button type="submit" name="delete" class="btn btn-danger" style="margin-top:10px" onclick="return confirm('anda yakin?')" >Delete</button>
  <?php }
  }?>
</form>