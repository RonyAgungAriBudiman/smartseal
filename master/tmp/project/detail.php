<?php
if($_POST["closed"]=="") $_POST["closed"] = "0";
$sql ="SELECT * FROM ms_project WHERE ProjectID = '".$_GET["pid"]."' " ;
$data=$sqlLib->select($sql);
?>
<div class="row">
	<div class="col-md-12" style="margin-bottom:10px">
		<?php
		if($data[0]["AddedBy"]==$_SESSION["userid"] OR $_SESSION["admin"] == "1")
		{?>
			<a href="index.php?m=project&sm=add&pid=<?php echo $_GET["pid"]?>"><button type="button" name="simpan" class="btn btn-primary" >Edit Project</button></a>
		<?php }?>
		<a href="index.php?m=tugas&sm=add&pid=<?php echo $_GET["pid"]?>"><button type="button" name="simpan" class="btn btn-primary" >Tambah Tugas</button></a>
	</div>
	<div class="col-md-8">
	  <div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"><?php echo strtoupper($data[0]["NamaProject"])?></h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
		  <table class="table table-bordered">
			<tr>
				<td colspan="4">
				<form method="post">
				<select name="closed" id="closed" class="form-control col-md-3" onchange="submit();">
					<option value="all">All Status</option>
					<option value="1" <?php if($_POST["closed"]=="1"){ echo "selected";}?>>Closed</option>
					<option value="0" <?php if($_POST["closed"]=="0"){ echo "selected";}?>>Un Closed</option>
				</select>
				</form>
				</td>
			</tr>
			<tr>
			  <th style="width: 10px">#</th>
			  <th>Tugas</th>
			  <th>Progress</th>
			  <th style="width: 40px">Label</th>
			</tr>
			<?php
			$i=1;
			$kondisi = "";
			if($_POST["closed"] != "all") $kondisi .= " AND Closed = '".$_POST["closed"]."' ";
			$sql_tugas ="SELECT * FROM ms_tugas WHERE ProjectID = '".$_GET["pid"]."' AND ParentID = '0' ".$kondisi." ORDER BY AddedTime DESC" ;
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
				  <td><a href="index.php?m=tugas&sm=detail&tid=<?php echo $row_tugas["TugasID"]?>"><?php echo $row_tugas["Subject"]?></td>
				  <td>
					<div class="progress progress-xs">
					  <div class="progress-bar progress-bar-<?php echo $css?>" style="width: <?php echo $row_tugas["Progress"]?>%"></div>
					</div>
				  </td>
				  <td><span class="badge bg-<?php echo $css?>"><?php echo $row_tugas["Progress"]?>%</span></td>
				</tr>
				<?php
				$sql_subtugas ="SELECT * FROM ms_tugas WHERE ProjectID = '".$_GET["pid"]."' AND ParentID = '".$row_tugas["TugasID"]."'".$kondisi." ORDER BY AddedTime DESC" ;
				$data_subtugas =$sqlLib->select($sql_subtugas);
				foreach($data_subtugas as $row_subtugas)
				{
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
					  <td></td>
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
		  </table>
		</div>
		
	  </div>
	</div>
	
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Detail Project</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			<div class="form-group" style="margin-top:10px">
				<label for="project">Anggota</label><br>
				<?php
				$sql_ang ="SELECT a.UserID, a.ProjectID, b.Nama FROM ms_project_anggota a LEFT JOIN ms_user b ON b.UserID = a.UserID WHERE a.ProjectID ='".$_GET["pid"]."'";
				$data_ang= $sqlLib->select($sql_ang);
				foreach($data_ang as $row_ang)
				{?>
					<a href="index.php?m=activity&uid=<?php echo $row_ang["UserID"]?>"><?php echo $row_ang["Nama"]?></a>, 
				<?php }?>
			</div>
			<?php
			$sql_sub ="SELECT ProjectID, NamaProject FROM ms_project WHERE ProjectID ='".$data[0]["ParentID"]."'";
			$data_sub = $sqlLib->select($sql_sub);
			if(count($data_sub)>0)
			{?>
			<div class="form-group" style="margin-top:10px">
				<label for="project">Parent Project</label><br>
				<?php
				foreach($data_sub as $row_sub)
				{?>
					<a href="index.php?m=project&sm=detail&pid=<?php echo $row_sub["ProjectID"]?>"><?php echo $row_sub["NamaProject"]?></a>, 
				<?php }?>
			</div>
			<?php }
			$sql_sub ="SELECT ProjectID, NamaProject FROM ms_project WHERE ParentID ='".$data[0]["ProjectID"]."'";
			$data_sub = $sqlLib->select($sql_sub);
			if(count($data_sub)>0)
			{?>
			<div class="form-group" style="margin-top:10px">
				<label for="project">Sub Project</label><br>
				<?php
				foreach($data_sub as $row_sub)
				{?>
					<a href="index.php?m=project&sm=detail&pid=<?php echo $row_sub["ProjectID"]?>"><?php echo $row_sub["NamaProject"]?></a>, 
				<?php }?>
			</div>
			<?php }?>
			</div>
		</div>
	</div>
</div>