<div class="row" style="padding:20px 0px">
	<?php
	if($_GET["prnid"] != "")
	{?>
	<div class="col-md-8">
		<div class="form-group">
			<?php
			$sql_sub ="SELECT Subject, TugasID FROM ms_tugas WHERE TugasID = '".$_GET["prnid"]."' " ;
			$data_sub=$sqlLib->select($sql_sub);
			?> 
			<label for="project">Sub Tugas</label>
			<input type="text" name="subtask" id="subtask" value="<?php echo $data_sub[0]["Subject"]?>" class="form-control" disabled>
			<input type="hidden" name="parentid" value="<?php echo $data_sub[0]["TugasID"]?>">
		</div>
	</div>
	<?php }?>
	<div class="col-md-8">
		<div class="form-group">
			<label for="project">Subject</label>
			<input type="text" name="subject" id="subject" value="<?php echo $_POST["subject"]?>" class="form-control">
		</div>
	</div>
	<div class="row"></div>
	<div class="col-md-8">
		<div class="form-group">
			<label for="project">Keterangan</label>
			<textarea name="keterangan" id="keterangan" value="<?php echo $_POST["keterangan"]?>" style="height:80px" class="form-control"><?php echo $_POST["keterangan"]?></textarea>
		</div> 
	</div>
	
	<div class="row"></div>
	<div class="col-md-2">
		<div class="form-group">
			<label for="dari">Dari Tanggal</label>
			<div class="input-group date">
				  <div class="input-group-addon"><i class="fa fa-calendar"></i>
				  </div>
				  <input type="text" class="form-control pull-right tgl" id="dari" name="dari" value="<?php echo $_POST["dari"]?>"  style="text-align:center">
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<label for="sampai">Sampai Tanggal</label>
			<div class="input-group date">
				  <div class="input-group-addon"><i class="fa fa-calendar"></i>
				  </div>
				  <input type="text" class="form-control pull-right tgl" id="sampai" name="sampai" value="<?php echo $_POST["sampai"]?>"  style="text-align:center">
			</div>
		</div>
	</div>
</div>