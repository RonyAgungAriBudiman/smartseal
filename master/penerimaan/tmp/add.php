<?php 

if(isset($_POST['Simpan']))
{	 

	$tahun = substr(date("Y"), 2);
	$areaid=$_POST["areaid"];
	$bidang=$_POST["bidang"];
	//cek urutan 
	$sql_cek 	= "SELECT Urut FROM ms_penerimaan WHERE AreaID = '".$_POST['areaid']."' AND Bidang = '".$_POST['bidang']."' AND YEAR(Tanggal) = '".date("Y")."' Order By Urut Desc  LIMIT 1 ";
	$data_cek	= $sqlLib->select($sql_cek);

	$next_urut		= $data_cek[0]["Urut"] +1;
	$jmldata        = $data_cek[0]["Urut"] + $_POST["qty"] ;

	for($i=$next_urut; $i<=$jmldata; $i++)
		{
			if (strlen($i)=="1")
				{
					$nomor	= "00000".$i;
				}
			if (strlen($i)=="2")
				{
					$nomor	= "0000".$i;
				}
			if (strlen($i)=="3")
				{
					$nomor	= "000".$i;
				}
			if (strlen($i)=="4")
				{
					$nomor	= "00".$i;
				}
			if (strlen($i)=="5")
				{
					$nomor	= "0".$i;
				}
			if (strlen($i)=="6")
				{
					$nomor	= $i;
				}					
			
			$no_segel = $areaid.'-'.$bidang.'-'.$nomor.'-'.$tahun ;	

			

			//proses simpan
			$sql = "INSERT INTO ms_penerimaan (Tanggal, NoSegel, AreaID, Bidang, Urut, Status, PengambilanID )
					VALUES ('".date("Y-m-d")."', '".$no_segel."', '".$areaid."', '".$bidang."',  '".$i."', 'ready', '')";
			$run = $sqlLib->insert($sql);	
	

		}	



}
?>	

<section class="content-header">
       <h1>
       Penerimaan Segel
        <small></small>
      </h1>
  </section>

     <!-- Main content -->
  <section class="content">  
      <div class="row">
        <div class="col-xs-12" >
          <div class="box box-primary">
            <div class="box-header">

			
			<form method="post" id="form" >	
              <div class="col-md-5" >	
				  	<div class="box-body" >
				  
				  			<div class="form-group" style="padding-bottom: 2px;">
							  <label for="Description">Area</label>
							   <select class="form-control" id="areaid" name="areaid">
							   	<option value="">Pilih Area</option>	
					 				<?php
					 				$sql ="SELECT * FROM ms_area WHERE AreaID !='' ";
					 				$data=$sqlLib->select($sql);
					 				foreach ($data as $row)
					  				{?>
					  					<option value="<?php echo $row['AreaID']; ?>"><?php echo $row['Area']; ?></option>	
					  				<?php }	?>
							   </select>
							</div>	

				  			<div class="form-group" style="padding-bottom: 2px;">
							  <label for="Description">Bidang </label>
							   <select class="form-control" id="bidang" name="bidang" >
					 				<option value="">Pilih Bidang</option>	
					 				<option value="PBPD">PBPD</option>	
								  	<option value="P2TL">P2TL</option>								  	
								  	<option value="TSBG">TSBG</option>													  	
								  	<option value="GGAN">GGAN</option>													  	
								  	<option value="PHAR">PHAR</option>													  	
								  	<option value="PESTA">PESTA</option>												  	
								  	<option value="KHSS">KHSS</option>	
								</select>
							</div>							
							
							<div class="form-group" style="padding-bottom: 2px;">
							  <label for="Description">Qty</label>
							   <input name="qty"  class="form-control" required="required" />
							</div>	
							
						<div class="box-foot">
							<input type="submit" class="btn btn-primary" value="Simpan" name="Simpan"  />

						   	
				  		</div>
				  	</div>				   		  
   			  </div>  		 
   			</form>
   			
  		  </div>
        </div>   
      </div>

 </section>




<!-- jQuery 2.2.3 -->
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
   <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
 <script type="text/javascript" src="assets/boostrap/js/bootstrap.js"></script>