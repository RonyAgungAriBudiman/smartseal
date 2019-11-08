<!-- 
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script> -->
<?php 
include_once "function/library.php"; 
?>
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script>
    $(function () {
        $("#nosegel").autocomplete({
            source: "json/nosegel_pbpd.php?areaid=<?php echo $_SESSION["areaid"]?>",
            minLength: 1
            });
         });
</script>
<style>
           
            .ui-autocomplete {
                position: absolute;
                z-index: 1000;
                cursor: default;
                padding: 0;
                margin-top: 2px;
                list-style: none;
                background-color: #ffffff;
                border: 1px solid #ccc;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
                -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            }
            .ui-autocomplete > li {
                padding: 3px 10px;
            }
            .ui-autocomplete > li.ui-state-focus {
                background-color: #3399FF;
                color:#ffffff;
            }
            .ui-helper-hidden-accessible {
                display: none;
            }
</style>

<?php
if(isset($_POST["Reset"]))  
{    
    unset($_POST);
}

if(isset($_POST["Simpan"]))
{
    $pemasanganid      = "30".date("YmdHis"); 
    $photo="";
    $file=$_FILES['photo']['name'];
    if(!empty($file))
        {
            $direktori="images/pbpd/"; //tempat upload foto
            $name='photo'; //name pada input type file
            $namaBaru=$_POST['nosegel']; //name pada input type file
            $quality=200; //konversi kualitas photo dalam satuan %
            //jalankan fungsi
            if(UploadCompress($namaBaru,$name,$direktori,$quality)){
            }
             $photo = $_POST['nosegel'].'.jpg';
        }

    $sql = "INSERT INTO ms_pemasangan (PemasanganID, Tanggal, IDPelanggan, IDMeter, NoSegel, Petugas, Bidang, AreaID, PosisiSegel, Gambar, Status, NoSegelBaru )
            VALUES ('".$pemasanganid."','".date("Y-m-d")."', '".$_POST['id_pelanggan']."', '".$_POST['id_meter']."', '".$_POST['nosegel']."', '".$_SESSION['userid']."', 'PBPD', '".$_SESSION["areaid"]."', '".$_POST["posisi_segel"]."', '".$photo."', 'aktif', '')        ";
    $run = $sqlLib->insert($sql);  

    $sql_up ="UPDATE ms_pengambilan SET PemasanganID = '".$pemasanganid."',
                                        Status       = 'get'
                WHERE NoSegel ='".$_POST['nosegel']."'  ";
    $run_up =$sqlLib->update($sql_up); 

    if($run)
    {
        echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-check"></i> Berhasil di Simpan!</h4>
              </div>'; 
    }
    else
    {
        echo '<div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-ban"></i> Proses Simpan Gagal</h4>
              </div>';
    }                          

}
?>

<section>
<h1>
    Pasang Baru
    <small></small>
</h1>
</section>

     <!-- Main content -->
  <section class="content">  
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">

			<form method="post" name="form" enctype="multipart/form-data">	
              <div class="col-md-5">	
				  	<div class="box-body">
						<div class="form-group" style="padding-bottom: 2px;">
						   <label for="Description">Id Pelanggan</label>
						   <input type="text" name="id_pelanggan" class="form-control" value="<?php echo  $r['id_pelanggan'];?>" required />						  
						</div>

						<div class="form-group" style="padding-bottom: 2px;">
						   <label for="Description">Id Meter</label>
						   <input name="id_meter"  class="form-control" value="<?php echo $r['id_meter'];?>" required/>
						</div>

				  		<div class="form-group" style="padding-bottom: 2px;">
						   <label for="Description">No Segel</label>
						   <input type="text" name="nosegel" id="nosegel" class="form-control" value="<?php echo  $r['nosegel'];?>"  required/>
						</div>

						<div class="form-group" style="padding-bottom: 2px;">
						   <label for="Description">Posisi Segel</label>
						   <input name="posisi_segel"  class="form-control" value="<?php echo $r['posisi_segel'];?>" required/>
						</div>

						<div class="form-group" style="padding-bottom: 2px;">
						  <label for="Description">Gambar</label><br>
						  	<input name="photo" type="file" value="<?php echo $photo; ?>" accept="image/jpeg" class="input-medium" />
							<input type="hidden" min="1" max="100" value="10" name="quality"/>
							<input name="photo_tmp" type="hidden" value="<?php echo $photo; ?>" class="input-medium"/>
						</div>

						 <input type="hidden" name="seq" value="<?php echo  $r['seq'];?>"/>

						<div class="box-foot">
	         		  		<input type="submit" name="Reset" value="Batal" class="btn btn-danger">	
							<input type="submit" class="btn btn-primary" <?php if ($Edit) { echo "value=Update name=Update";}
		  														   else { echo "value=Simpan name=Simpan";} ?> />		
				  		</div>
				  	</div>				   		  
   			  </div>  		 
   			</form>

  		  </div>
        </div>   
      </div>
 </section>