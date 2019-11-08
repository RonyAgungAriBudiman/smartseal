<style type="text/css">

.produksi{
    font-size:16px;
}
.produksi select{
    font-size:16px;
    height:30px;
    font-weight:bolder;
}
.produksi input{
    font-size:16px;
    height:30px;
    font-weight:bolder;
}


#meterid:focus{
    background-color:#3c8dbc; border:solid 1px #3c8dbc; color:#FFF;
}
#meterid:focus::placeholder{
    color:#81bde0;
}
</style>

<?php
if($_POST["tgl"]=="") $_POST["tgl"]=date("d-M-Y");

if($_GET["kerusakanid"]!="") $_POST["kerusakanid"]= $_GET["kerusakanid"]; 
if($_GET["analisa"]!="") $_POST["analisa"]= $_GET["analisa"]; 
if($_GET["perbaikan"]!="") $_POST["perbaikan"]= $_GET["perbaikan"]; 
if($_GET["kategori"]!="") $_POST["kategori"]= $_GET["kategori"]; 
if($_GET["klasifikasi"]!="") $_POST["klasifikasi"]= $_GET["klasifikasi"]; 
?>

<form method="post" id="form-transaksi"  name="form"  action="index.php?m=perbaikan&sm=part" > 
<div class="row produksi">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header"></div>
            <div class="box-body">
                               

                <div form-group">
                    
               

                    <div class="col-sm-3">   
                    <label for="tgl">TANGGAL SELESAI</label>
                    <div class="input-group date">
                          <div class="input-group-addon"><i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right tgl" name="tgl" value="<?php echo $_POST["tgl"]?>" readonly="readonly"  style="text-align:center; font-size:16px; height:30px; font-weight:bolder; cursor:not-allowed; outline:none ">
                    </div>                    
                    </div>

                    <div class="col-md-3">
                    <label for="produkid">INDEX</label>
                    <select class="form-control" id="kerusakanid" name="kerusakanid" >
                    <option value=""></option>
                        <?php
                        if($_GET['kerusakanid']!='')
                        {
                            $sql = "SELECT a.KerusakanID, a.Indexing FROM MTN_KERUSAKAN a
                                WHERE a.KerusakanID ='".$_GET['kerusakanid']."' AND a.Indexing!='' AND a.Status !='good'   ORDER BY a.Indexing asc";
                            $data = $sqlLib->select($sql);
                            foreach($data as $row)
                                {?>
                                    <option value="<?php echo $row["KerusakanID"]?>" 
                                    <?php if($_POST["kerusakanid"]==$row["KerusakanID"]){ echo "selected";}?>><?php echo $row["Indexing"]?></option>
                                <?php }

                        }    
                        else
                        {     

                        $sql = "SELECT a.KerusakanID, a.Indexing FROM MTN_KERUSAKAN a
                                WHERE a.KerusakanID != '' AND a.Indexing!='' AND a.Status !='good'   ORDER BY a.Indexing asc";
                        $data = $sqlLib->select($sql);
                        foreach($data as $row)
                        {?>
                            <option value="<?php echo $row["KerusakanID"]?>" 
                            <?php if($_POST["kerusakanid"]==$row["KerusakanID"]){ echo "selected";}?>><?php echo $row["Indexing"]?></option>
                        <?php }
                        }?>
                    </select>
                    </div>

                    <div class="col-md-3">
                        <label for="produkid">ANALISA</label>
                        <input type="text" name="analisa" id="analisa" class="form-control" value="<?php echo $_POST['analisa']?>"   >
                        
                    </div> 

                    <div class="col-md-3">
                        <label for="produkid">PERBAIKAN</label>
                        <input type="text" name="perbaikan" id="perbaikan" class="form-control" value="<?php echo $_POST['perbaikan']?>"  >
                        
                    </div> 

                    

                    <div class="col-md-3">
                    <label for="produkid">KATEGORI</label>
                    <select class="form-control" id="kategori" name="kategori">
                    <option value=""></option>
                        <option value="Major" <?php if($_POST["kategori"]=="Major"){ echo "selected";}?>>Major</option>
                        <option value="Minor" <?php if($_POST["kategori"]=="Minor"){ echo "selected";}?>>Minor</option>                  
                    </select>
                    </div>

                    <div class="col-md-3">
                    <label for="produkid">KLASIFIKASI PART</label>
                    <select class="form-control" id="klasifikasi" name="klasifikasi" >
                    <option value=""></option>
                    <option value="SMT" <?php if($_POST["klasifikasi"]=='SMT'){ echo "selected";}?>>SMT</option>
                    <option value="KOMPRESOR" <?php if($_POST["klasifikasi"]=='KOMPRESOR'){ echo "selected";}?>>KOMPRESOR</option>
                    <option value="KONVEYOR" <?php if($_POST["klasifikasi"]=='KONVEYOR'){ echo "selected";}?>>KONVEYOR</option>
                    <option value="DIP" <?php if($_POST["klasifikasi"]=='DIP'){ echo "selected";}?>>DIP</option>
                    <option value="HAIYAN CLOU" <?php if($_POST["klasifikasi"]=='HAIYAN CLOU'){ echo "selected";}?>>HAIYAN CLOU</option>
                    <option value="JIG" <?php if($_POST["klasifikasi"]=='JIG'){ echo "selected";}?>>JIG</option>
                    </select>
                    </div>

                    <div class="col-md-2">
                    <label for="produkid">&nbsp;</label>
                        <input type="submit" class="form-control btn-primary" name="next" id="next" value="Next" >
                    </div>



                   
                </div>
                
            </div>
            
            
       </div>
   </div>
   
</div>
</form>
