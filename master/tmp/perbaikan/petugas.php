<?php 
$tanggal   = date("Y-m-d H:i:s",strtotime($_POST['tgl']));
$kerusakanid  = $_POST['kerusakanid'];
$analisa    = $_POST['analisa'];
$perbaikan  = $_POST['perbaikan'];
$kategori   = $_POST['kategori'];
$part1      = $_POST['sparepart1'];
$qty1       = $_POST['qty1'];
$part2      = $_POST['sparepart2'];
$qty2       = $_POST['qty2'];
$part3      = $_POST['sparepart3'];
$qty3       = $_POST['qty3'];
$petugas1   = $_POST['petugas1'];
$petugas2   = $_POST['petugas2'];
$petugas3   = $_POST['petugas3'];



if(isset($_POST['simpan']))
{  

    if($part1 !='' AND $qty1 !='')
        {
            //cek stock dulu gan!!
            $sql_stock = "SELECT TOP(1) a.SparepartID,
                        (SELECT COALESCE(SUM(x.Qty),null,0) FROM ms_stock_sparepart x WHERE x.SparepartID = a.SparepartID AND x.Tanggal >='".date("Y-01-01")."' AND x.Tanggal <='".date("Y-m-d",strtotime($_POST['tgl']))."' AND x.Jenis ='opname' )+
                        (SELECT COALESCE(SUM(y.Qty),null,0) FROM ms_stock_sparepart y WHERE y.SparepartID = a.SparepartID AND y.Tanggal >='".date("Y-01-01")."' AND y.Tanggal <='".date("Y-m-d",strtotime($_POST['tgl']))."' AND y.Jenis ='masuk' ) -
                        (SELECT COALESCE(SUM(Z.Qty),null,0) FROM ms_stock_sparepart Z WHERE z.SparepartID = a.SparepartID AND z.Tanggal >='".date("Y-01-01")."' AND z.Tanggal <='".date("Y-m-d",strtotime($_POST['tgl']))."' AND z.Jenis ='keluar' ) as Stock
                        FROM ms_sparepart a
                        WHERE a.SparepartID != '' AND a.SparepartID ='".$part1."' ";
            $data_stock = $sqlLib->select($sql_stock);  

            //jika stock tersedia
            if($qty1 <= $data_stock[0]['Stock'])
            {
                $stockid1 = $kerusakanid.'/1';
                $sql2 ="INSERT INTO ms_stock_sparepart (StockID, Tanggal, SparepartID, Qty, Jenis, Urut)
                        VALUES ('".$stockid1."', '".$tanggal."', '".$part1."', '".$qty1."',  'keluar' , '1')";
                $run2 =$sqlLib->insert($sql2);
            }
            else
            {
                
                ?>
                <SCRIPT LANGUAGE="JavaScript">alert('Part 1 stock tidak mencukupi !!!!'); document.location = 'index.php?m=perbaikan' </SCRIPT>
                <?php
                exit();
            } 

        }

    if($part2 !='' AND $qty2 !='')
        {
            //cek stock dulu gan!!
            $sql_stock2 = "SELECT TOP(1) a.SparepartID,
                        (SELECT COALESCE(SUM(x.Qty),null,0) FROM ms_stock_sparepart x WHERE x.SparepartID = a.SparepartID AND x.Tanggal >='".date("Y-01-01")."' AND x.Tanggal <='".date("Y-m-d",strtotime($_POST['tgl']))."' AND x.Jenis ='opname' )+
                        (SELECT COALESCE(SUM(y.Qty),null,0) FROM ms_stock_sparepart y WHERE y.SparepartID = a.SparepartID AND y.Tanggal >='".date("Y-01-01")."' AND y.Tanggal <='".date("Y-m-d",strtotime($_POST['tgl']))."' AND y.Jenis ='masuk' ) -
                        (SELECT COALESCE(SUM(Z.Qty),null,0) FROM ms_stock_sparepart Z WHERE z.SparepartID = a.SparepartID AND z.Tanggal >='".date("Y-01-01")."' AND z.Tanggal <='".date("Y-m-d",strtotime($_POST['tgl']))."' AND z.Jenis ='keluar' ) as Stock
                        FROM ms_sparepart a
                        WHERE a.SparepartID != '' AND a.SparepartID ='".$part2."' ";
            $data_stock2 = $sqlLib->select($sql_stock2);  

            //jika stock tersedia
            if($qty2 <= $data_stock2[0]['Stock'])
            {
                $stockid2 = $kerusakanid.'/2';
                $sql3 ="INSERT INTO ms_stock_sparepart (StockID, Tanggal, SparepartID, Qty, Jenis, Urut)
                        VALUES ('".$stockid2."', '".$tanggal."', '".$part2."', '".$qty2."',  'keluar' , '2')";
                $run3 =$sqlLib->insert($sql3);
            }
            else
            {
                $sql_del2="DELETE FROM ms_stock_sparepart WHERE StockID LIKE '".$kerusakanid."%'";
                $run_del2=$sqlLib->delete($sql_del2);        
                ?>
                <SCRIPT LANGUAGE="JavaScript">alert('Part 2 stock tidak mencukupi !!!!'); document.location = 'index.php?m=perbaikan' </SCRIPT>
                <?php
                exit();
            } 
        }

    if($part3 !='' AND $qty3 !='')
        {
            //cek stock dulu gan!!
            $sql_stock3 = "SELECT TOP(1) a.SparepartID,
                        (SELECT COALESCE(SUM(x.Qty),null,0) FROM ms_stock_sparepart x WHERE x.SparepartID = a.SparepartID AND x.Tanggal >='".date("Y-01-01")."' AND x.Tanggal <='".date("Y-m-d",strtotime($_POST['tgl']))."' AND x.Jenis ='opname' )+
                        (SELECT COALESCE(SUM(y.Qty),null,0) FROM ms_stock_sparepart y WHERE y.SparepartID = a.SparepartID AND y.Tanggal >='".date("Y-01-01")."' AND y.Tanggal <='".date("Y-m-d",strtotime($_POST['tgl']))."' AND y.Jenis ='masuk' ) -
                        (SELECT COALESCE(SUM(Z.Qty),null,0) FROM ms_stock_sparepart Z WHERE z.SparepartID = a.SparepartID AND z.Tanggal >='".date("Y-01-01")."' AND z.Tanggal <='".date("Y-m-d",strtotime($_POST['tgl']))."' AND z.Jenis ='keluar' ) as Stock
                        FROM ms_sparepart a
                        WHERE a.SparepartID != '' AND a.SparepartID ='".$part3."' ";
            $data_stock3 = $sqlLib->select($sql_stock3);  

            //jika stock tersedia
            if($qty3 <= $data_stock3[0]['Stock'])
            {
                $stockid3 = $kerusakanid.'/3';
                $sql4 ="INSERT INTO ms_stock_sparepart (StockID, Tanggal, SparepartID, Qty, Jenis, Urut)
                        VALUES ('".$stockid3."', '".$tanggal."', '".$part3."', '".$qty3."',  'keluar' , '3')";
                $run4 =$sqlLib->insert($sql4);
            }
            else
            {
                $sql_del3="DELETE FROM ms_stock_sparepart WHERE StockID LIKE '".$kerusakanid."%'";
                $run_del3=$sqlLib->delete($sql_del3);        
                ?>
                <SCRIPT LANGUAGE="JavaScript">alert('Part 3 stock tidak mencukupi !!!!'); document.location = 'index.php?m=perbaikan' </SCRIPT>
                <?php
                exit();
            } 
        }


    $sukses = false;
    $sql ="UPDATE MTN_KERUSAKAN SET TanggalSelesai ='".$tanggal."',
                                    Perbaikan ='".$perbaikan."',
                                    Analisa   ='".$analisa."',
                                    Kategori  ='".$kategori."',
                                    Petugas1  ='".$petugas1."',
                                    Petugas2  ='".$petugas2."',
                                    Petugas3  ='".$petugas3."',
                                    Status    ='good'    
            WHERE KerusakanID = '".$kerusakanid."'    ";
    $run =$sqlLib->update($sql);
    $sukses=true;

    if($sukses)
    {   
        $sql_cek ="SELECT TOP(1) Indexing FROM MTN_KERUSAKAN WHERE KerusakanID ='".$kerusakanid."' ";
        $data=$sqlLib->select($sql_cek);



        $sql_up="UPDATE ms_index_maintenance SET Status ='".$status."'
                        WHERE Indexing = '".$data[0]['Indexing']."' ";
        $run_up=$sqlLib->update($sql_up);  
                
    }
        
}    
?>


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
?>

<form method="post" id="form-transaksi"  name="form"  action="<?php $_SERVER['PHP_SELF']; ?>" target="_self"> 
<div class="row produksi">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header"></div>
            <div class="box-body">
                               

                <div form-group">
                    
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
                        <input type="submit" class="form-control btn-primary" name="simpan" id="simpan" value="Simpan">
                        <input type="hidden" name="tanggal" value="<?php echo $tanggal?>">
                        <input type="hidden" name="kerusakanid" value="<?php echo $kerusakanid?>">
                        <input type="hidden" name="analisa" value="<?php echo $analisa?>">
                        <input type="hidden" name="kategori" value="<?php echo $kategori?>">
                        <input type="hidden" name="perbaikan" value="<?php echo $perbaikan?>">
                        <input type="hidden" name="sparepart1" value="<?php echo $part1?>">
                        <input type="hidden" name="sparepart2" value="<?php echo $part2?>">
                        <input type="hidden" name="sparepart3" value="<?php echo $part3?>">
                        <input type="hidden" name="qty1" value="<?php echo $qty1?>">
                        <input type="hidden" name="qty2" value="<?php echo $qty2?>">
                        <input type="hidden" name="qty3" value="<?php echo $qty3?>">

                    </div>



                   
                </div>
                
            </div>
            
            
       </div>
   </div>
   
<?php if ($_POST['simpan']!='') {?>
   <div class="col-md-12" id="data-transaksi">
           
        <div class="table-responsive" style="height:<?php echo $height?>px; background-color:#e3e8ee">
        <table class="table table-striped fonttable">
        <thead>
          <tr>
            <th>DESKRIPSI</th>
          </tr>
        </thead>
        <tbody> 
            <?php

            $sql_data ="SELECT COUNT(KerusakanID) as jmldata FROM MTN_KERUSAKAN
                        WHERE  Tanggal = '".$tanggal."' AND Penerima = '".$_SESSION["userid"]."'  ";
            $jml_data =$sqlLib->select($sql_data);
            $no       = $jml_data[0]["jmldata"];        

            $sql = "SELECT TOP(1) * FROM MTN_KERUSAKAN
                    WHERE  KerusakanID ='".$kerusakanid."'  ORDER BY Tanggal DESC";
            $data = $sqlLib->select($sql);      
            foreach($data as $row)
            {
                $sql_1 ="SELECT TOP(1) Nama FROM ms_karyawan WHERE NIK ='".$row["Petugas1"]."' " ;
                $data_1=$sqlLib->select($sql_1);

                $sql_2 ="SELECT TOP(1) Nama FROM ms_karyawan WHERE NIK ='".$row["Petugas2"]."' " ;
                $data_2=$sqlLib->select($sql_2);

                $sql_3 ="SELECT TOP(1) Nama FROM ms_karyawan WHERE NIK ='".$row["Petugas3"]."' " ;
                $data_3=$sqlLib->select($sql_3);
                ?>
                <tr>
                    <td>
                        INDEX : <br> 
                        <?php echo $row["Indexing"]?><br>

                        PERBAIKAN :<br> 
                        <?php echo $row["Perbaikan"]?><br>

                        ANALISA :<br> 
                        <?php echo $row["Analisa"]?><br>

                        HASIL :<br>             
                        <?php echo $row["Status"]?><br>

                        PETUGAS :<br>               
                        <?php echo $data_1[0]["Nama"]?>, <?php echo $data_2[0]["Nama"]?>, <?php echo $data_2[0]["Nama"]?>  <br>

                    </td>
                </tr>
            
            <?php $no--;} ?>


        </tbody>
        </table>
        </div>  
       </div>
<?php  } ?>
 
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