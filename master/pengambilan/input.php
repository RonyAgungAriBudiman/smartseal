<?php 

if(isset($_POST["Simpan"]))
  {  
    $tahun              = substr(date("Y"), 2);
    $areaid             = $_POST["areaid"];
    $bidang             = $_POST["bidang"];
    $stock               = $_POST["stock"];
    $qty                = $_POST["qty"];
    $pengambilanid      = "20".date("YmdHis"); 


    //jika stock ada
  if($stock >= $qty)
    {  
        $sql_data = "SELECT NoSegel, AreaID, Bidang, Urut, Status FROM ms_penerimaan WHERE AreaID = '".$areaid."' AND Bidang ='".$bidang."' AND Status = 'ready' Order by Year(Tanggal) Asc, Urut Asc LIMIT ".$qty."  ";
        $data     = $sqlLib->select($sql_data);
        foreach ($data as $row) 
        {
          $sql_save = "INSERT INTO ms_pengambilan (PengambilanID, Tanggal, NoSegel, AreaID, Bidang, Urut, Status, PemasanganID)
                        VALUES ('".$pengambilanid."', '".date("Y-m-d")."', '".$row['NoSegel']."', '".$row['AreaID']."', '".$row['Bidang']."' , '".$row['Urut']."', 'ready', ''  )" ;
          $run      = $sqlLib->insert($sql_save);      
          
          if($run) //jika berhasil insert maka update ms_penerimaan
            {
              $sql_up = "UPDATE ms_penerimaan 
                          SET Status ='get', 
                              PengambilanID = '".$pengambilanid."'
                              WHERE NoSegel = '".$row['NoSegel']."' ";
              $run_up = $sqlLib->update($sql_up);
            }     
        }
        echo '<div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-check"></i> Berhasil di Simpan!</h4>
          </div>';
    }
  else{
      echo '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-ban"></i> Stock Tidak Cukup!</h4>
          </div>';
    }  


}

  ?>

  <section class="content-header">
      <h1>
        Pengambilan Segel
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"></h3> 

              <form method="post" id="form-transaksi">
                <div class="form-group" style="padding-bottom: 2px;">
                    <label for="Description">Area</label>
                     <select class="form-control" id="areaid" name="areaid" onchange="submit();">
                      <option value="" <?php if($_POST["areaid"]=="") { echo "selected";}  ?>>Pilih Area</option>  
                      <?php
                      $sql ="SELECT AreaID, Area FROM ms_area  ";
                      $data=$sqlLib->select($sql);
                      foreach ($data as $row)
                        {?>
                          <option value="<?php echo $row['AreaID']; ?>" <?php if($_POST["areaid"]==$row['AreaID']) { echo "selected";}  ?>><?php echo $row['Area']; ?></option>  
                        <?php } ?>
                     </select>
                </div> 

                <div class="form-group" style="padding-bottom: 2px;">
                    <label for="Description">Bidang </label>
                     <select class="form-control" id="bidang" name="bidang" onchange="submit();">
                      <option value="">Pilih Bidang</option>  
                      <option value="PBPD" <?php if($_POST["bidang"]=="PBPD") { echo "selected";}  ?>>PBPD</option>  
                      <option value="P2TL" <?php if($_POST["bidang"]=="P2TL") { echo "selected";}  ?>>P2TL</option>                    
                      <option value="TSBG" <?php if($_POST["bidang"]=="TSBG") { echo "selected";}  ?>>TSBG</option>                              
                      <option value="GGAN" <?php if($_POST["bidang"]=="GGAN") { echo "selected";}  ?>>GGAN</option>                              
                      <option value="PHAR" <?php if($_POST["bidang"]=="PHAR") { echo "selected";}  ?>>PHAR</option>                              
                      <option value="PESTA" <?php if($_POST["bidang"]=="PESTA") { echo "selected";}  ?>>PESTA</option>                            
                      <option value="KHSS" <?php if($_POST["bidang"]=="KHSS") { echo "selected";}  ?>>KHSS</option>  
                    </select>
                </div>    

                <div class="form-group" style="padding-bottom: 2px;" id="data-stock">
                  <?php 
                    $sql =" SELECT COUNT(NoSegel) as stock FROM ms_penerimaan WHERE Bidang = '".$_POST['bidang']."' AND  AreaID = '".$_POST['areaid']."' AND Status ='ready' ";
                    $data=$sqlLib->select($sql); ?>

                    <label for="Description">Stock</label>
                        <input name="stock" id="stock"  class="form-control"  value="<?php echo $data[0]['stock']  ?>" />
                 
                </div>           
                  
                <div class="form-group" style="padding-bottom: 2px;">
                    <label for="Description">Qty</label>
                     <input name="qty"  class="form-control" value="<?php echo $_POST['qty']?>" required="required" />
                </div> 


                <div class="form-group">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <input type="submit" name="Simpan" value="Simpan" class="btn btn-primary">
                </div>
              </form>

            </div>
          </div>

        </div>
      </div>
    </section>     


