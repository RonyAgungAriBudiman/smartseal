<div class="row" style="padding:20px 0px">
	<?php
	$i=1;
	$sql ="SELECT DISTINCT(a.UserID), b.Nama FROM ms_project_anggota a LEFT JOIN ms_user b ON b.UserID = a.UserID WHERE a.ProjectID = '".$_POST["pid"]."' ";
	$data=$sqlLib->select($sql);
	foreach ($data as $row)
	{
		$checked = "";
		if($_POST["tid"] != "" AND $_GET["subtask"] == "")
		{
			$sql_cek ="SELECT COUNT(UserID) as Jml FROM ms_tugas_pic WHERE UserID = '".$row["UserID"]."' AND TugasID = '".$_POST["tid"]."' " ;
			$data_cek=$sqlLib->select($sql_cek);
			if($data_cek[0]["Jml"]>0) $checked = "checked";
		}
	?>
	<div class="col-md-2">
	<input type="checkbox" name="chklistpic[]" value="<?php echo $row["UserID"]?>" id="chklistpic<?php echo $i?>" <?php echo $checked?>>
	<label for="chklistpic<?php echo $i?>" style="font-weight:normal"><?php echo $row["Nama"]?></label>
	</div>
	<?php $i++;}?>
</div>