<?php
if($_POST["pid"]=="" AND $_GET["pid"] != "") $_POST["pid"] = $_GET["pid"];
if($_POST["tid"]=="" AND $_GET["tid"] != "") $_POST["tid"] = $_GET["tid"];
if(isset($_POST["delete"]))
{
	$parentid = $_POST["parentid"];
	$tugasid = $_POST["tid"];
	
	$sql ="SELECT ParentID FROM ms_project WHERE ProjectID = '".$tugasid."' " ;
	$data=$sqlLib->select($sql);
	$parentid = $data[0]["ParentID"];

	$sql_delete ="DELETE FROM ms_tugas WHERE TugasID = '".$tugasid."' OR ParentID = '".$tugasid."'";
	$run_delete=$sqlLib->delete($sql_delete);
	
	$sql_delete ="DELETE FROM ms_tugas_pic WHERE TugasID = '".$tugasid."'";
	$run_delete=$sqlLib->delete($sql_delete);
	
	$sql_delete ="DELETE FROM ms_notes WHERE TugasID = '".$tugasid."'";
	$run_delete=$sqlLib->delete($sql_delete);
	
	$sql_delete ="DELETE FROM ms_notifikasi WHERE TugasID = '".$tugasid."'";
	$run_delete=$sqlLib->delete($sql_delete);
	
	$sql_file ="SELECT `File` FROM ms_notes_files WHERE TugasID = '".$tugasid."'";
	$data_file =$sqlLib->select($sql_file);
	foreach($data_file as $row_file)
	{
		if($row_file["File"] != "")
		{
			if(file_exists("upload/".$row_file["File"])) unlink("upload/".$row_file["File"]); 
		}
	}
	echo '<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><i class="icon fa fa-check"></i> Berhasil di Delete!</h4>
	  </div>';
}

if(isset($_POST["update"]))
{
	$projectid = $_POST["pid"];
	$subject = $_POST["subject"];
	$keterangan = $_POST["keterangan"];
	$dari = date("Y-m-d",strtotime($_POST["dari"]));
	$sampai = date("Y-m-d",strtotime($_POST["sampai"]));
	$tugasid = $_POST["tid"];
	$parentid = $_POST["parentid"];
	
	
	if($subject != "" AND $_POST["dari"] != "" AND  $_POST["sampai"] != "")
	{
		$sql_update ="	UPDATE ms_tugas SET 	Subject = '".$subject."', 
													Keterangan = '".$keterangan."', 
													Dari = '".$dari."', 
													Sampai = '".$sampai."'
						WHERE TugasID = '".$tugasid."'";
		$run_update=$sqlLib->update($sql_update);
		
		if($run_update)
		{
			$sql_delete ="DELETE FROM ms_tugas_pic WHERE TugasID = '".$tugasid."' " ;
			$data_delete =$sqlLib->select($sql_delete);
				
			foreach ($_POST["chklistpic"] as $userid)
			{
				$sql_save ="INSERT INTO ms_tugas_pic(UserID, TugasID) VALUES('".$userid."','".$tugasid."')";
				$run_save =$sqlLib->insert($sql_save);
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
	$projectid = $_POST["pid"];
	$parentid = $_POST["parentid"];
	$subject = $_POST["subject"];
	$keterangan = $_POST["keterangan"];
	$dari = date("Y-m-d",strtotime($_POST["dari"]));
	$sampai = date("Y-m-d",strtotime($_POST["sampai"]));
	$tugasid = date("YmdHis");
	
	if($parentid == "") $parentid = 0;
	
	if($subject != "" AND $_POST["dari"] != "" AND  $_POST["sampai"] != "")
	{
		$sql_save ="INSERT INTO ms_tugas(TugasID, ProjectID, Subject, Keterangan, Dari, Sampai, ParentID, AddedBy, AddedTime) 
					VALUES('".$tugasid."','".$projectid."','".$subject."','".$keterangan."','".$dari."','".$sampai."','".$parentid."','".$_SESSION["userid"]."','".date("Y-m-d H:i:s")."')";
		$run_save=$sqlLib->insert($sql_save);
		
		if($_POST["parentid"]!= "")
		{
			$sql_max ="SELECT MIN(Dari) as Dari, MAX(Sampai) as Sampai FROM ms_tugas WHERE ParentID = '".$_POST["parentid"]."'";
			$data_max=$sqlLib->select($sql_max);
			
			$sql_update ="UPDATE ms_tugas SET Dari = '".$data_max[0]["Dari"]."', Sampai = '".$data_max[0]["Sampai"]."' WHERE TugasID = '".$_POST["parentid"]."'";
			$run_update =$sqlLib->update($sql_update);
		}
			
		if($run_save)
		{
			$sql_notif = "SELECT UserID FROM ms_project_anggota WHERE ProjectID = '".$projectid."' AND UserID != '".$_SESSION["userid"]."'" ;
			$data_notif = $sqlLib->select($sql_notif);
			foreach ($data_notif as $row_notif)
			{
				$sql_save_notif ="INSERT INTO ms_notifikasi(UserID, TugasID) VALUES('".$row_notif["UserID"]."','".$tugasid."')";
				$run_save_notif =$sqlLib->insert($sql_save_notif);
			}

			foreach ($_POST["chklistpic"] as $userid)
			{
				$sql_save ="INSERT INTO ms_tugas_pic(UserID, TugasID) VALUES('".$userid."','".$tugasid."')";
				$run_save =$sqlLib->insert($sql_save);
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

if($_POST["tid"] != "")
{
	$sql ="SELECT * FROM ms_tugas WHERE TugasID = '".$_GET["tid"]."' " ;
	$data=$sqlLib->select($sql);
	$_POST["addedby"] = $data[0]["AddedBy"];
	$_POST["subject"] = $data[0]["Subject"];
	$_POST["keterangan"] = $data[0]["Keterangan"];
	$_POST["dari"] = date("d-M-Y",strtotime($data[0]["Dari"]));
	$_POST["sampai"] = date("d-M-Y",strtotime($data[0]["Sampai"]));
	if($_POST["parentid"]=="") $_POST["parentid"] = $_POST["tid"];
}
$sql ="SELECT * FROM ms_project WHERE ProjectID = '".$_POST["pid"]."' " ;
$data=$sqlLib->select($sql);

$_POST["addedby"] = $data[0]["AddedBy"];
$_POST["namaproject"] = $data[0]["NamaProject"];
?>
<a href="index.php?m=project&sm=detail&pid=<?php echo $_POST["pid"]?>"><h2 style="margin-top:0px"><?php echo $_POST["namaproject"]?></h2></a>
<form method="post" action="index.php?m=tugas&sm=add" autocomplete="off">
<input type="hidden" name="pid" value="<?php echo $_POST["pid"]?>">
<input type="hidden" name="tid" value="<?php echo $_POST["tid"]?>">
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#tugas">TUGAS</a></li>
	<li><a data-toggle="tab" href="#pic">PIC</a></li>
  </ul>

  <div class="tab-content box-body" style="background-color:#FFF; border-left:solid 1px #ddd">
    <div id="tugas" class="tab-pane fade in active">
		<?php include "master/tugas/add_info.php";?>
    </div>
    <div id="pic" class="tab-pane fade">
      <?php include "master/tugas/add_pic.php";?>
    </div>
  </div>
  <?php
  if($_POST["tid"]=="" OR $_GET["subtask"]=="1" AND ($_POST["addedby"] == $_SESSION["userid"] OR $_SESSION["admin"]=="1"))
  {?>
	<button type="submit" name="simpan" class="btn btn-primary" style="margin-top:10px" >Simpan Tugas</button>
  <?php }else if($_GET["subtask"]==""){?>
	<button type="submit" name="update" class="btn btn-primary" style="margin-top:10px" >Update Tugas</button>
	<button type="submit" name="delete" class="btn btn-danger" style="margin-top:10px" onclick="return confirm('anda yakin?')" >Delete</button>
  <?php }?>
</form>