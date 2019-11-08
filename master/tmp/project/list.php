
<a href="index.php?m=project&sm=add"><button type="button" class="btn btn-primary" style="margin-bottom:10px" >Tambah Project</button></a>

<div class="row">
<?php //for($i=1; $i<=10; $i++) 
$sql ="	SELECT a.ProjectID, a.NamaProject, a.Keterangan 
		FROM ms_project a 
		WHERE 	a.ParentID ='0' AND 
				((SELECT COUNT(z.UserID) FROM ms_project_anggota z WHERE z.ProjectID = a.ProjectID AND z.UserID = '".$_SESSION["userid"]."')>0 OR '".$_SESSION["admin"]."' = '1')";
$data= $sqlLib->select($sql);
foreach($data as $row)
{ ?>

<div class="col-md-4">
	<div class="box box-primary">
		<div class="box-header with-border">
			<?php 
			$sql_inbox = "	SELECT COUNT(a.UserID) as Jml 
							FROM ms_notifikasi a 
							LEFT JOIN ms_tugas b ON b.TugasID = a.TugasID 
							WHERE a.UserID = '".$_SESSION["userid"]."' AND b.ProjectID = '".$row['ProjectID']."'";
			$data_inbox= $sqlLib->select($sql_inbox);
			if($data_inbox[0]["Jml"]>0)
			{
			?>
				<span class="badge bg-red" style="float:right; margin-right:10px"><?php echo $data_inbox[0]["Jml"]?></span>
			<?php }?>
			<a href="index.php?m=project&sm=detail&pid=<?php echo $row['ProjectID']?>">
				<h3 class="box-title"><?php echo strtoupper($row['NamaProject']) ?><br>
				<?php if($row['Keterangan'] != ""){?><div style="color:#666; font-size:14px; padding-top:10px"><?php echo $row['Keterangan']?></div><?php }?></h3>
			</a>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body" style="padding:0px 0px 0px 10px">
			<?php
			$sql1 ="SELECT a.ProjectID, a.NamaProject, a.Keterangan 
					FROM ms_project a 
					WHERE 	a.ParentID = '".$row['ProjectID']."' AND 
							((SELECT COUNT(z.UserID) FROM ms_project_anggota z WHERE z.ProjectID = a.ProjectID AND z.UserID = '".$_SESSION["userid"]."')>0 OR '".$_SESSION["admin"]."' = '1')" ;
			$data1=$sqlLib->select($sql1);
			foreach ($data1 as $row1)
			{?>
			<div class="box-header with-border" style="padding:5px 0px">
				<?php 
				$sql_inbox1 = "	SELECT COUNT(a.UserID) as Jml 
								FROM ms_notifikasi a 
								LEFT JOIN ms_tugas b ON b.TugasID = a.TugasID 
								WHERE a.UserID = '".$_SESSION["userid"]."' AND b.ProjectID = '".$row1['ProjectID']."'";
				$data_inbox1= $sqlLib->select($sql_inbox1);
				if($data_inbox1[0]["Jml"]>0)
				{
				?>
					<span class="badge bg-red" style="float:right; margin-right:10px"><?php echo $data_inbox1[0]["Jml"]?></span>
				<?php }?>
				<a href="index.php?m=project&sm=detail&pid=<?php echo $row1['ProjectID']?>">
					<h5 class="box-title" style="font-size:14px"><?php echo strtoupper($row1['NamaProject']) ?><br>
					<?php if($row1['Keterangan'] != ""){?><div style="color:#666; font-size:14px; padding-top:10px"><?php echo $row1['Keterangan']?></div><?php }?></h5>
				</a>
			</div>
			<div class="box-body" style="padding:0px 0px 0px 10px; border-left:solid 3px #CCC">
				<?php
				$sql2 ="SELECT a.ProjectID, a.NamaProject, a.Keterangan 
						FROM ms_project a 
						WHERE 	a.ParentID = '".$row1['ProjectID']."' AND 
								((SELECT COUNT(z.UserID) FROM ms_project_anggota z WHERE z.ProjectID = a.ProjectID AND z.UserID = '".$_SESSION["userid"]."')>0 OR '".$_SESSION["admin"]."' = '1')" ;
				$data2=$sqlLib->select($sql2);
				foreach ($data2 as $row2)
				{?>
				<div class="box-header with-border" style="padding:5px 0px">
					<?php 
					$sql_inbox2 = "	SELECT COUNT(a.UserID) as Jml 
									FROM ms_notifikasi a 
									LEFT JOIN ms_tugas b ON b.TugasID = a.TugasID 
									WHERE a.UserID = '".$_SESSION["userid"]."' AND b.ProjectID = '".$row2['ProjectID']."'";
					$data_inbox2= $sqlLib->select($sql_inbox2);
					if($data_inbox2[0]["Jml"]>0)
					{
					?>
						<span class="badge bg-red" style="float:right; margin-right:10px"><?php echo $data_inbox2[0]["Jml"]?></span>
					<?php }?>
					<a href="index.php?m=project&sm=detail&pid=<?php echo $row2['ProjectID']?>">
						<h5 class="box-title" style="font-size:14px"><?php echo strtoupper($row2['NamaProject']) ?><br>
						<?php if($row2['Keterangan'] != ""){?><div style="color:#666; font-size:14px; padding-top:10px"><?php echo $row2['Keterangan']?></div><?php }?></h5>
					</a>
				</div>
				<div class="box-body" style="padding:0px 0px 0px 10px; border-left:solid 3px #CCC">
					<?php
					$sql3 ="SELECT a.ProjectID, a.NamaProject, a.Keterangan 
							FROM ms_project a 
							WHERE 	a.ParentID = '".$row2['ProjectID']."' AND 
									((SELECT COUNT(z.UserID) FROM ms_project_anggota z WHERE z.ProjectID = a.ProjectID AND z.UserID = '".$_SESSION["userid"]."')>0 OR '".$_SESSION["admin"]."' = '1')" ;
					$data3=$sqlLib->select($sql3);
					foreach ($data3 as $row3)
					{?>
					<div class="box-header with-border" style="padding:5px 0px">
						<?php 
						$sql_inbox3 = "	SELECT COUNT(a.UserID) as Jml 
										FROM ms_notifikasi a 
										LEFT JOIN ms_tugas b ON b.TugasID = a.TugasID 
										WHERE a.UserID = '".$_SESSION["userid"]."' AND b.ProjectID = '".$row3['ProjectID']."'";
						$data_inbox3= $sqlLib->select($sql_inbox3);
						if($data_inbox3[0]["Jml"]>0)
						{
						?>
							<span class="badge bg-red" style="float:right; margin-right:10px"><?php echo $data_inbox3[0]["Jml"]?></span>
						<?php }?>
						<a href="index.php?m=project&sm=detail&pid=<?php echo $row3['ProjectID']?>">
							<h5 class="box-title" style="font-size:14px"><?php echo strtoupper($row3['NamaProject']) ?><br>
							<?php if($row3['Keterangan'] != ""){?><div style="color:#666; font-size:14px; padding-top:10px"><?php echo $row3['Keterangan']?></div><?php }?></h5>
						</a>
					</div>
					<div class="box-body" style="padding:0px 0px 0px 10px; border-left:solid 3px #CCC">
						<?php
						$sql4 ="SELECT a.ProjectID, a.NamaProject, a.Keterangan 
								FROM ms_project a 
								WHERE 	a.ParentID = '".$row3['ProjectID']."' AND 
										((SELECT COUNT(z.UserID) FROM ms_project_anggota z WHERE z.ProjectID = a.ProjectID AND z.UserID = '".$_SESSION["userid"]."')>0 OR '".$_SESSION["admin"]."' = '1')" ;
						$data4=$sqlLib->select($sql4);
						foreach ($data4 as $row3)
						{?>
						<div class="box-header with-border" style="padding:5px 0px">
							<?php 
							$sql_inbox4 = "	SELECT COUNT(a.UserID) as Jml 
											FROM ms_notifikasi a 
											LEFT JOIN ms_tugas b ON b.TugasID = a.TugasID 
											WHERE a.UserID = '".$_SESSION["userid"]."' AND b.ProjectID = '".$row3['ProjectID']."'";
							$data_inbox4= $sqlLib->select($sql_inbox4);
							if($data_inbox4[0]["Jml"]>0)
							{
							?>
								<span class="badge bg-red" style="float:right; margin-right:10px"><?php echo $data_inbox4[0]["Jml"]?></span>
							<?php }?>
							<a href="index.php?m=project&sm=detail&pid=<?php echo $row3['ProjectID']?>">
								<h5 class="box-title" style="font-size:14px"><?php echo strtoupper($row3['NamaProject']) ?><br>
								<?php if($row3['Keterangan'] != ""){?><div style="color:#666; font-size:14px; padding-top:10px"><?php echo $row3['Keterangan']?></div><?php }?></h5>
							</a>
						</div>
						<?php 
						}?>
					</div>
					<?php
				   }?>
				</div>
				<?php
			   }?>
			</div>
			<?php
		   }?>
		</div>
	</div>
</div>
<?php } ?> 
</div>