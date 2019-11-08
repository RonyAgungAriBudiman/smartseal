<div class="row" style="padding:20px 0px">
	<div class="col-md-4">
		<div class="form-group">
			<label for="project">Induk Project</label>
			<select name="indukproject" id="indukproject" class="form-control" onchange="submit();">
			<option value="0"></option>
			<?php
			$sql ="	SELECT a.ProjectID, a.NamaProject 
					FROM ms_project a 
					WHERE 	a.ParentID = '0' AND 
							((SELECT COUNT(z.UserID) FROM ms_project_anggota z WHERE z.ProjectID = a.ProjectID AND z.UserID = '".$_SESSION["userid"]."')>0 OR '".$_SESSION["admin"]."' = '1')" ;
			$data=$sqlLib->select($sql);
			foreach ($data as $row)
			{
				?><option value="<?php echo $row["ProjectID"]?>" <?php if($_POST["indukproject"]==$row["ProjectID"]){ echo "selected";}?> style="background-color:#EFEFEF"><?php echo $row["NamaProject"]?></option><?php
				$sql1 ="SELECT a.ProjectID, a.NamaProject 
						FROM ms_project a 
						WHERE 	a.ParentID = '".$row["ProjectID"]."' AND 
								((SELECT COUNT(z.UserID) FROM ms_project_anggota z WHERE z.ProjectID = a.ProjectID AND z.UserID = '".$_SESSION["userid"]."')>0 OR '".$_SESSION["admin"]."' = '1')";
				$data1=$sqlLib->select($sql1);
				foreach ($data1 as $row1)
				{
					?><option value="<?php echo $row1["ProjectID"]?>" <?php if($_POST["indukproject"]==$row1["ProjectID"]){ echo "selected";}?>>- <?php echo $row1["NamaProject"]?></option><?php
					$sql2 ="SELECT a.ProjectID, a.NamaProject 
							FROM ms_project a 
							WHERE 	a.ParentID = '".$row1["ProjectID"]."' AND
									((SELECT COUNT(z.UserID) FROM ms_project_anggota z WHERE z.ProjectID = a.ProjectID AND z.UserID = '".$_SESSION["userid"]."')>0 OR '".$_SESSION["admin"]."' = '1')";
					$data2=$sqlLib->select($sql2);
					foreach ($data2 as $row2)
					{
						?><option value="<?php echo $row2["ProjectID"]?>" <?php if($_POST["indukproject"]==$row2["ProjectID"]){ echo "selected";}?>>--- <?php echo $row2["NamaProject"]?></option><?php
						$sql3 ="SELECT a.ProjectID, a.NamaProject 
								FROM ms_project a 
								WHERE 	a.ParentID = '".$row2["ProjectID"]."' AND
										((SELECT COUNT(z.UserID) FROM ms_project_anggota z WHERE z.ProjectID = a.ProjectID AND z.UserID = '".$_SESSION["userid"]."')>0 OR '".$_SESSION["admin"]."' = '1')";
						$data3=$sqlLib->select($sql3);
						foreach ($data3 as $row3)
						{
							?><option value="<?php echo $row3["ProjectID"]?>" <?php if($_POST["indukproject"]==$row3["ProjectID"]){ echo "selected";}?>>----- <?php echo $row3["NamaProject"]?></option><?php
							$sql4 ="SELECT a.ProjectID, a.NamaProject 
									FROM ms_project a 
									WHERE 	a.ParentID = '".$row3["ProjectID"]."' AND
											((SELECT COUNT(z.UserID) FROM ms_project_anggota z WHERE z.ProjectID = a.ProjectID AND z.UserID = '".$_SESSION["userid"]."')>0 OR '".$_SESSION["admin"]."' = '1')";
							$data4=$sqlLib->select($sql4);
							foreach ($data4 as $row4)
							{
								?><option value="<?php echo $row4["ProjectID"]?>" <?php if($_POST["indukproject"]==$row4["ProjectID"]){ echo "selected";}?>>------- <?php echo $row4["NamaProject"]?></option><?php
							}
						}
					}
				}
			}
			?>
			</select>
		</div>
	</div>
	<div class="row"></div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="project">Nama Project</label>
			<input type="text" name="namaproject" id="namaproject" value="<?php echo $_POST["namaproject"]?>" class="form-control">
		</div>
	</div>
	<div class="row"></div>
	<div class="col-md-8">
		<div class="form-group">
			<label for="project">Keterangan</label>
			<textarea name="keterangan" id="keterangan" value="<?php echo $_POST["keterangan"]?>" style="height:80px" class="form-control"><?php echo $_POST["keterangan"]?></textarea>
		</div> 
	</div>
	
</div>