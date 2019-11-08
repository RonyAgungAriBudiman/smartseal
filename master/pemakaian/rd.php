<?php 
include_once "function/library.php"; 
?>
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script>
$(document).ready(function(){
        var config = {
                        source: "json/id_pelanggan.php?areaid=<?php echo $_SESSION["areaid"]?>",				        
                        select: function(event, ui){
							$("#id_pelanggan").val(ui.item.id_pelanggan); 
							$("#id_meter").val(ui.item.id_meter); 
                        },
                        minLength: 1
                    };                    
        //auto complete
        $("#id_pelanggan").autocomplete(config);
		 });
</script>



<script type="text/javascript"> 

$(document).ready(function(){
        var config = {
                        source: "json/segel_lama.php?id_meter=<?php echo $_POST["id_meter"]?>",				        
                        select: function(event, ui){
							$("#no_segel_lama").val(ui.item.no_segel_lama); 
                        },
                        minLength: 1
                    };                    
        //auto complete
        $("#no_segel_lama").autocomplete(config);
		 });



  /*  $(function () {
        $("#id_pelanggan").autocomplete({
            source: "json/id_pelanggan.php?areaid=<?php echo $_SESSION["areaid"]?>",
             select: function(event, ui){
							$("#id_pelanggan").val(ui.item.id_pelanggan); 
							$("#id_meter").val(ui.item.id_meter); 
                        },
            minLength: 1
            });
         });*/
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
	unset($_POST);
?>


<section class="content-header">
       <h1>
        Rubah Daya
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
						   <input type="text" name="id_pelanggan" id="id_pelanggan" class="form-control"
						    value="<?php echo  $id_pelanggan;?>" required/>
						</div>

						<div class="form-group" style="padding-bottom: 2px;">
						  <label for="Description">Id Meter</label>
						   <input type="text" name="id_meter" id="id_meter" class="form-control" 
						   value="<?php echo  $id_meter; ?>" required/>		  
						</div>
						
						<div class="form-group" style="padding-bottom: 2px;">
						  <label for="Description">No Segel Lama</label>
						   <input type="text" name="no_segel_lama" id="no_segel_lama" class="form-control" 
						   	value="<?php echo $no_segel_lama;?>" required/>		  
						</div>						
						
						<div class="form-group" style="padding-bottom: 2px;">
						  <label for="Description">No Segel Baru</label>
						  <input type="text" name="no_segel" id="no_segel" class="form-control" 
						  value="<?php echo  $no_segel; ?>" required/>
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
						
						
						<div class="box-foot">
	         		  		<a href="main.php?page=PBPD" class="btn btn-danger">Cancel<a>
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
