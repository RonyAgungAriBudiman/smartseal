<style type="text/css">

.produksi{
    font-size:18px;
}
.produksi select{
    font-size:40px;
    height:60px;
    font-weight:bolder;
}
.produksi input{
    font-size:40px;
    height:60px;
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
?>
<form class="form" id="form-transaksi">
<div class="row produksi">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header"></div>
            <div class="box-body">
                               

                <div form-group">
                    
               

                    <div class="col-sm-3">   
                    <label for="tgl">TANGGAL</label>
                    <div class="input-group date">
                          <div class="input-group-addon"><i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right tgl" name="tgl" value="<?php echo $_POST["tgl"]?>" readonly="readonly"  style="text-align:center; font-size:40px; height:60px; font-weight:bolder; cursor:not-allowed; outline:none ">
                    </div>                    
                    </div>

                    <div class="col-md-3">
                    <label for="produkid">UNIT</label>
                    <select class="form-control" id="unit" name="unit" onchange="data_lokasi();">
                    <option value=""></option>
                        <?php
                        $sql = "SELECT a.KategoriID, a.Kategori FROM ms_kategori_index a
                                WHERE a.KategoriID != ''    ORDER BY a.Kategori asc";
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
                    <select class="form-control" id="data-lokasi" name="lokasi" onchange="data_index();" >
                  
                    </select>
                    </div>

                    <div class="col-md-3">
                    <label for="produkid">INDEX</label>
                    <select class="form-control" id="data-index" name="indexing" >
                   <!--  <option value=""></option>
                        <?php
                        $sql = "SELECT a.Indexing FROM ms_index_maintenance a
                                WHERE a.Indexing != '' AND a.Status ='good'   ORDER BY a.Indexing asc";
                        $data = $sqlLib->select($sql);
                        foreach($data as $row)
                        {?>
                            <option value="<?php echo $row["Indexing"]?>" 
                            <?php if($_POST["indexing"]==$row["Indexing"]){ echo "selected";}?>><?php echo $row["Indexing"]?></option>
                        <?php }?> -->
                    </select>
                    </div>

                    <div class="col-md-3">
                        <label for="produkid">KERUSAKAN</label>
                        <input type="text" name="kerusakan" id="kerusakan" class="form-control">
                        
                    </div> 

                    <div class="col-md-3">
                        <label for="produkid">PEMBERI</label>
                        <input type="text" name="pemberi" id="pemberi" class="form-control">                        
                    </div>  

                    <div class="col-md-2">
                    <label for="produkid">&nbsp;</label>
                        <input type="button" class="form-control btn-primary" name="save" id="save" value="SIMPAN" onclick="simpan();">
                    </div>



                   
                </div>
                
            </div>
            
            
       </div>
   </div>
   
   <div class="col-md-12" id="data-transaksi"></div>
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