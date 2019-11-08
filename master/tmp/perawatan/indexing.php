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
if($_GET["tgl"]!="") $_POST["tgl"]=date("d-M-Y", strtotime($_GET["tgl"])); 
if($_GET["unit"]!="") $_POST["unit"]= $_GET["unit"]; 
if($_GET["lokasi"]!="") $_POST["lokasi"]= $_GET["lokasi"]; 
if($_GET["indexing"]!="") $_POST["indexing"]= $_GET["indexing"]; 
if($_GET["perawatan"]!="") $_POST["perawatan"]= $_GET["perawatan"]; 
if($_GET["klasifikasi"]!="") $_POST["klasifikasi"]= $_GET["klasifikasi"]; 

?>

<form method="post" id="form-transaksi"  name="form"  action="index.php?m=perawatan&sm=part" > 
<div class="row produksi">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header"></div>
            <div class="box-body">
                               

                <div form-group">                    
               

                    <div class="col-sm-3">   
                    <label for="produksi">TANGGAL</label>
                    <div class="input-group date">
                          <div class="input-group-addon"><i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right tgl" name="tgl" value="<?php echo $_POST["tgl"]?>" readonly="readonly"  style="text-align:center; font-size:16px; height:30px; font-weight:bolder; cursor:not-allowed; outline:none ">
                    </div>                    
                    </div>

                    <div class="col-md-3">
                    <label for="produkid">UNIT</label>
                    <select class="form-control" id="unit" name="unit" onchange="data_lokasi();">
                    <option value=""></option>
                        <?php
                        $sql = "SELECT a.KategoriID, a.Kategori FROM ms_kategori_index a
                                WHERE a.KategoriID != '' ORDER BY a.Kategori asc  ";
                        $data = $sqlLib->select($sql);
                        foreach($data as $row)
                        {?>
                            <option value="<?php echo trim($row["KategoriID"])?>" 
                            <?php if($_POST["unit"]==trim($row["KategoriID"])){ echo "selected";}?>><?php echo $row["Kategori"]?></option>
                        <?php }?>
                    </select>
                    </div>

                    <div class="col-md-3">
                    <label for="produkid">LOKASI</label>

                    <?php
                    if($_GET["lokasi"]!="") { ?>
                        <select class="form-control" id="data-lokasi" name="lokasi" onchange="data_index();" >
                            <option value=""></option>
                            <?php
                            $sql = "SELECT DISTINCT a.KodeLokasi, b.Lokasi FROM ms_index_maintenance a
                                    LEFT JOIN ms_lokasi_index b on b.Kode = a.KodeLokasi
                                    WHERE a.KodeLokasi != '' AND a.Status ='good'  AND a.KategoriID ='".$_POST['unit']."'  ORDER BY b.Lokasi asc";
                            $data = $sqlLib->select($sql);
                            foreach($data as $row)
                            {?>
                                <option value="<?php echo $row["KodeLokasi"]?>" 
                                <?php if($_POST["lokasi"]==$row["KodeLokasi"]){ echo "selected";}?>><?php echo $row["Lokasi"]?></option>
                            <?php }?>
                        </select>  
                        <?php } else {?>


                        <select class="form-control" id="data-lokasi" name="lokasi" onchange="data_index();" >                      
                        </select>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                    <label for="produkid">INDEX</label>
                    <?php
                    if($_GET["indexing"]!="") { ?>

                        <select class="form-control" id="indexing" name="indexing">
                            <option value=""></option>
                                <?php
                                    $sql = "SELECT a.Indexing FROM ms_index_maintenance a
                                            WHERE a.Indexing != '' AND a.Status ='good'  AND a.KategoriID ='".$_POST['unit']."' AND a.KodeLokasi ='".$_POST['lokasi']."'  ORDER BY a.Indexing asc";
                                    $data = $sqlLib->select($sql);
                                    foreach($data as $row)
                                    {?>
                                        <option value="<?php echo $row["Indexing"]?>" 
                                        <?php if($_POST["indexing"]==$row["Indexing"]){ echo "selected";}?>><?php echo $row["Indexing"]?></option>
                                    <?php }?>
                        </select>    
                        <?php } else {?>
                        <select class="form-control" id="data-index" name="indexing" >
                        </select>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <label for="produkid">TINDAKAN PERAWATAN</label>
                        <input type="text" name="perawatan" id="perawatan" class="form-control" value="<?php echo $_POST['perawatan']?>">                        
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

<script type="text/javascript">

 function data_lokasi()
  {
  var formData = new FormData(document.getElementById("form-transaksi"));
  $.ajax(
  {
    url:'master/formkerusakan/data_lokasi.php',
    type: 'POST',
    data: formData,
    contentType: false,
    enctype: 'multipart/form-data',
    processData: false,
    beforeSend:function()
    {
      document.getElementById("data-lokasi").innerHTML = "<div style='padding:20px; text-align:center'>Loading...</div>";
    },
    complete:function()
    {
      //document.getElementById("loading"+id).style.display = "none";
    },
    success:function(result)
    {
      document.getElementById("data-lokasi").innerHTML = result;

   // data_mesin();
    }
  });
  }

  function data_index()
  {
  var formData = new FormData(document.getElementById("form-transaksi"));
  $.ajax(
  {
    url:'master/formkerusakan/data_index.php',
    type: 'POST',
    data: formData,
    contentType: false,
    enctype: 'multipart/form-data',
    processData: false,
    beforeSend:function()
    {
      document.getElementById("data-index").innerHTML = "<div style='padding:20px; text-align:center'>Loading...</div>";
    },
    complete:function()
    {
      //document.getElementById("loading"+id).style.display = "none";
    },
    success:function(result)
    {
      document.getElementById("data-index").innerHTML = result;

   // data_mesin();
    }
  });
  }

function simpan (){
    var formData = new FormData(document.getElementById("form-transaksi")); 
    $.ajax(
    {
        url:'master/formkerusakan/simpan_kerusakan.php',
        type: 'POST',
        data: formData,
        contentType: false,
        enctype: 'multipart/form-data',
        processData: false,
        beforeSend:function()
        {
            //document.getElementById("meterid").disabled = true;
        },
        complete:function()
        {
            //document.getElementById("loading"+id).style.display = "none";
        },
        success:function(result)
        {
            document.getElementById("data-transaksi").innerHTML = result;
                document.getElementById("unit").value = "";
                document.getElementById("data-lokasi").value = "";
                document.getElementById("data-index").value = "";
                document.getElementById("kerusakan").value = "";
                document.getElementById("pemberi").value = "";
             //   document.getElementById("materialid").focus();
           
            
        }
    });

}  

    $(function () {
    //Date picker
    $('.tgl').datepicker({
        format: 'dd-M-yyyy',
        autoclose: true
    })
    
    
    })
</script>