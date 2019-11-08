<?php
if(isset($_POST["Reset"]))	
	unset($_POST);
?>

<section class="content-header">
       <h1>
        PESTA
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