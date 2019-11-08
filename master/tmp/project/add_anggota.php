<div class="row" style="padding:20px 0px">
	<?php
	if($_POST["indukproject"] > "0")
	{?>
	<div class="col-md-12" style="padding-bottom:10px">
		<input type="checkbox" name="chkanggota" value="1" id="chkanggota" <?php if($_POST["chkanggota"]=="1"){ echo "checked";}?>>
		<label for="chkanggota">Anggota mengikuti induknya</label>
	</div>
	<?php
	}
	
	$i=1;
	$kondisi = "";
	if($_POST["indukproject"] != "0" AND $_POST["indukproject"] != "")
	{
		$sql ="	SELECT b.Nama, a.UserID 
				FROM ms_project_anggota a 
				LEFT JOIN ms_user b ON b.UserID = a.UserID 
				WHERE a.ProjectID = '".$_POST["indukproject"]."' ORDER BY b.Nama ASC" ;
	}else $sql ="SELECT Nama, UserID FROM ms_user ORDER BY Nama ASC" ;
	
	$data=$sqlLib->select($sql);
	foreach ($data as $row)
	{
		$checked = "";
		if($_POST["pid"] != "")
		{
			$sql_cek ="SELECT COUNT(UserID) as Jml FROM ms_project_anggota WHERE UserID = '".$row["UserID"]."' AND ProjectID = '".$_POST["pid"]."' " ;
			$data_cek=$sqlLib->select($sql_cek);
			if($data_cek[0]["Jml"]>0) $checked = "checked";
		}
	?>
	<div class="col-md-2">
	<input type="checkbox" name="chklistanggota[]" value="<?php echo $row["UserID"]?>" id="chklistanggota<?php echo $i?>" <?php echo $checked?>>
	<label for="chklistanggota<?php echo $i?>" style="font-weight:normal"><?php echo $row["Nama"]?></label>
	</div>
	<?php $i++;}?>
</div>