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
                    <label for="tgl">TANGGAL SELESAI</label>
                    <div class="input-group date">
                          <div class="input-group-addon"><i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right tgl" name="tgl" value="<?php echo $_POST["tgl"]?>" readonly="readonly"  style="text-align:center; font-size:40px; height:60px; font-weight:bolder; cursor:not-allowed; outline:none ">
                    </div>                    
                    </div>

                    <div class="col-md-3">
                    <label for="produkid">INDEX</label>
                    <select class="form-control" id="kerusakanid" name="kerusakanid" >
                    <option value=""></option>
                        <?php
                        $sql = "SELECT a.KerusakanID, a.Indexing FROM MTN_KERUSAKAN a
                                WHERE a.KerusakanID != '' AND a.Status !='good'   ORDER BY a.Indexing asc";
                        $data = $sqlLib->select($sql);
                        foreach($data as $row)
                        {?>
                            <option value="<?php echo $row["KerusakanID"]?>" 
                            <?php if($_POST["kerusakanid"]==$row["KerusakanID"]){ echo "selected";}?>><?php echo $row["Indexing"]?></option>
                        <?php }?>
                    </select>
                    </div>

                    <div class="col-md-3">
                        <label for="produkid">ANALISA</label>
                        <input type="text" name="analisa" id="analisa" class="form-control">
                        
                    </div> 

                    <div class="col-md-3">
                        <label for="produkid">PERBAIKAN</label>
                        <input type="text" name="perbaikan" id="perbaikan" class="form-control">
                        
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
                        <label for="produkid">PETUGAS 1</label> 
                        <select class="form-control" id="petugas1" name="petugas1" >
                            <option value=""></option>
                            <?php
                            $sql = "SELECT a.NIK, a.Nama FROM ms_karyawan a
                                    WHERE a.PosisiID = '17' AND a.Status ='1' AND a.JabatanID !='2'   ORDER BY a.Nama asc";
                            $data = $sqlLib->select($sql);
                            foreach($data as $row)
                            {?>
                                <option value="<?php echo $row["NIK"]?>" 
                                <?php if($_POST["petugas1"]==$row["NIK"]){ echo "selected";}?>><?php echo $row["Nama"]?></option>
                            <?php }?>
                        </select>                      
                    </div>

                    <div class="col-md-3">
                        <label for="produkid">PETUGAS 2</label> 
                        <select class="form-control" id="petugas2" name="petugas2" >
                            <option value=""></option>
                            <?php
                            $sql = "SELECT a.NIK, a.Nama FROM ms_karyawan a
                                    WHERE a.PosisiID = '17' AND a.Status ='1' AND a.JabatanID !='2'   ORDER BY a.Nama asc";
                            $data = $sqlLib->select($sql);
                            foreach($data as $row)
                            {?>
                                <option value="<?php echo $row["NIK"]?>" 
                                <?php if($_POST["petugas2"]==$row["NIK"]){ echo "selected";}?>><?php echo $row["Nama"]?></option>
                            <?php }?>
                        </select>                      
                    </div> 

                    <div class="col-md-3">
                        <label for="produkid">PETUGAS 3</label> 
                        <select class="form-control" id="petugas3" name="petugas3" >
                            <option value=""></option>
                            <?php
                            $sql = "SELECT a.NIK, a.Nama FROM ms_karyawan a
                                    WHERE a.PosisiID = '17' AND a.Status ='1' AND a.JabatanID !='2'   ORDER BY a.Nama asc";
                            $data = $sqlLib->select($sql);
                            foreach($data as $row)
                            {?>
                                <option value="<?php echo $row["NIK"]?>" 
                                <?php if($_POST["petugas3"]==$row["NIK"]){ echo "selected";}?>><?php echo $row["Nama"]?></option>
                            <?php }?>
                        </select>                      
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


function simpan (){
    var formData = new FormData(document.getElementById("form-transaksi")); 
    $.ajax(
    {
        url:'master/formkerusakan/simpan_perbaikan.php',
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
                document.getElementById("kerusakanid").value = "";
                document.getElementById("perbaikan").value = "";
                document.getElementById("analisa").value = "";
                document.getElementById("kategori").value = "";
                document.getElementById("hasil").value = "";
                document.getElementById("petugas1").value = "";
                document.getElementById("petugas2").value = "";
                document.getElementById("petugas3").value = "";
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