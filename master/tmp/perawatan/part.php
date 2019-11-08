<?php 
$tanggal   = date("Y-m-d",strtotime($_POST['tgl']));
$indexing  = $_POST['indexing'];
$perawatan = $_POST['perawatan'];
$unit      = $_POST['unit'];
$lokasi      = $_POST['lokasi'];
$klasifikasi  = $_POST['klasifikasi'];

//echo $tanggal.'-'.$indexing.'-'.$perawatan;
?>

<style type="text/css">

.produksi{
    font-size:18px;
}
.produksi select{
    font-size:18px;
    height:30px;
    font-weight:bolder;
}
.produksi input{
    font-size:18px;
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
if($_POST["dari"]=="") $_POST["dari"]=date("01-01-Y");
?>



<script>
 $(document).ready(function(){
  $("#sparepart1").select2({
   templateResult: formatState
  });
 });
 
 function formatState (state) {
  if (!state.id) { return state.text; }
  var $state = $(
   '<span><img sytle="display: inline-block;" src="../images/sparepart/' + state.element.value.toLowerCase() + '.jpg" width=50 hight=50 /> ' + state.text + '</span>'
  );
  return $state;
 }



 $(document).ready(function(){
  $("#sparepart2").select2({
   templateResult: formatState1
  });
 });
 
 function formatState1 (state1) {
  if (!state1.id) { return state1.text; }
  var $state1 = $(
   '<span><img sytle="display: inline-block;" src="../images/sparepart/' + state1.element.value.toLowerCase() + '.jpg" width=50 hight=50 /> ' + state1.text + '</span>'
  );
  return $state1;
 }


 $(document).ready(function(){
  $("#sparepart3").select2({
   templateResult: formatState2
  });
 });
 
 function formatState2 (state2) {
  if (!state2.id) { return state2.text; }
  var $state2 = $(
   '<span><img sytle="display: inline-block;" src="../images/sparepart/' + state2.element.value.toLowerCase() + '.jpg" width=50 hight=50 /> ' + state2.text + '</span>'
  );
  return $state2;
 }

</script>

<form method="post" id="form-transaksi"  name="form"  action="index.php?m=perawatan&sm=petugas" > 
<div class="row produksi">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header"></div>
            <div class="box-body">
                               

                <div form-group">
                    
                    <div class="col-md-2">
                    <label for="produkid">PART 1</label>
                    <select class="form-control" id="sparepart1" name="sparepart1" >
                    <option value=""></option>
                    <?php
                        $sql = "SELECT a.SparepartID, a.Sparepart, a.Gambar,
                                (SELECT COALESCE(SUM(x.Qty),null,0) FROM ms_stock_sparepart x WHERE x.SparepartID = a.SparepartID AND x.Tanggal >='".$_POST['dari']."' AND x.Tanggal <='".$_POST['tgl']."' AND x.Jenis ='opname' )+
                                (SELECT COALESCE(SUM(y.Qty),null,0) FROM ms_stock_sparepart y WHERE y.SparepartID = a.SparepartID AND y.Tanggal >='".$_POST['dari']."' AND y.Tanggal <='".$_POST['tgl']."' AND y.Jenis ='masuk' ) -
                                (SELECT COALESCE(SUM(Z.Qty),null,0) FROM ms_stock_sparepart Z WHERE z.SparepartID = a.SparepartID AND z.Tanggal >='".$_POST['dari']."' AND z.Tanggal <='".$_POST['tgl']."' AND z.Jenis ='keluar' ) as Stock
                                FROM ms_sparepart a
                                WHERE a.SparepartID != '' AND a.klasifikasi ='".$klasifikasi."'   ORDER BY a.Sparepart asc";
                        $data = $sqlLib->select($sql);
                        foreach($data as $row)
                        {?>
                            <option value="<?php echo trim($row["SparepartID"])?>"  <?php if($row["Stock"]==0){ echo "disabled";} ?> 
                            <?php if($_POST["sparepart1"]==trim($row["SparepartID"])){ echo "selected";}?>><?php echo $row["Sparepart"]?></option>
                            
                    <?php 
                    }?>                  
                    </select>
                    </div>

                    <div class="col-md-2">
                        <label for="produkid">Qty</label>
                        <input type="text" name="qty1" id="qty1" class="form-control">
                        
                    </div> 

                    <div class="col-md-2">
                    <label for="produkid">PART 2</label>
                    <select class="form-control" id="sparepart2" name="sparepart2" >
                    <option value=""></option>
                    <?php
                        $sql = "SELECT a.SparepartID, a.Sparepart, a.Gambar,
                                (SELECT COALESCE(SUM(x.Qty),null,0) FROM ms_stock_sparepart x WHERE x.SparepartID = a.SparepartID AND x.Tanggal >='".$_POST['dari']."' AND x.Tanggal <='".$_POST['tgl']."' AND x.Jenis ='opname' )+
                                (SELECT COALESCE(SUM(y.Qty),null,0) FROM ms_stock_sparepart y WHERE y.SparepartID = a.SparepartID AND y.Tanggal >='".$_POST['dari']."' AND y.Tanggal <='".$_POST['tgl']."' AND y.Jenis ='masuk' ) -
                                (SELECT COALESCE(SUM(Z.Qty),null,0) FROM ms_stock_sparepart Z WHERE z.SparepartID = a.SparepartID AND z.Tanggal >='".$_POST['dari']."' AND z.Tanggal <='".$_POST['tgl']."' AND z.Jenis ='keluar' ) as Stock
                                FROM ms_sparepart a
                                WHERE a.SparepartID != '' AND a.klasifikasi ='".$klasifikasi."'    ORDER BY a.Sparepart asc";
                        $data = $sqlLib->select($sql);
                        foreach($data as $row)
                        {?>
                            <option value="<?php echo trim($row["SparepartID"])?>" <?php if($row["Stock"]==0){ echo "disabled";} ?> 
                            <?php if($_POST["sparepart2"]==trim($row["SparepartID"])){ echo "selected";}?>><?php echo $row["Sparepart"]?></option>
                    <?php }?>                  
                    </select>
                    </div>

                    <div class="col-md-2">
                        <label for="produkid">Qty</label>
                        <input type="text" name="qty2" id="qty2" class="form-control">
                        
                    </div> 

					<div class="col-md-2">
                    <label for="produkid">PART 3</label>
                    <select class="form-control" id="sparepart3" name="sparepart3" >
                    <option value=""></option>
                    <?php
                       $sql = "SELECT a.SparepartID, a.Sparepart, a.Gambar,
                                (SELECT COALESCE(SUM(x.Qty),null,0) FROM ms_stock_sparepart x WHERE x.SparepartID = a.SparepartID AND x.Tanggal >='".$_POST['dari']."' AND x.Tanggal <='".$_POST['tgl']."' AND x.Jenis ='opname' )+
                                (SELECT COALESCE(SUM(y.Qty),null,0) FROM ms_stock_sparepart y WHERE y.SparepartID = a.SparepartID AND y.Tanggal >='".$_POST['dari']."' AND y.Tanggal <='".$_POST['tgl']."' AND y.Jenis ='masuk' ) -
                                (SELECT COALESCE(SUM(Z.Qty),null,0) FROM ms_stock_sparepart Z WHERE z.SparepartID = a.SparepartID AND z.Tanggal >='".$_POST['dari']."' AND z.Tanggal <='".$_POST['tgl']."' AND z.Jenis ='keluar' ) as Stock
                                FROM ms_sparepart a
                                WHERE a.SparepartID != '' AND a.klasifikasi ='".$klasifikasi."'   ORDER BY a.Sparepart asc";
                        $data = $sqlLib->select($sql);
                        foreach($data as $row)
                        {?>
                            <option value="<?php echo trim($row["SparepartID"])?>" <?php if($row["Stock"]==0){ echo "disabled";} ?>
                            <?php if($_POST["sparepart3"]==trim($row["SparepartID"])){ echo "selected";}?>><?php echo $row["Sparepart"]?></option>
                    <?php }?>                  
                    </select>
                    </div>

                    <div class="col-md-2">
                        <label for="produkid">Qty</label>
                        <input type="text" name="qty3" id="qty3" class="form-control">
                        
                    </div> 


                     
                    <div class="col-md-2">
                    <label for="produkid">&nbsp;</label>
                        <a href="index.php?m=perawatan&sm=indexing&tgl=<?php echo $tanggal?>&unit=<?php echo $unit?>&lokasi=<?php echo $lokasi?>&indexing=<?php echo $indexing?>&perawatan=<?php echo $perawatan?>&klasifikasi=<?php echo $klasifikasi?>"><input type="button" class="form-control btn-danger" name="back" id="next" value="Back" ></a>

                    </div>
                    

                    <div class="col-md-2">
                    <label for="produkid">&nbsp;</label>
                        <input type="submit" class="form-control btn-primary" name="next" id="next" value="Next" >
                        <input type="hidden" name="tanggal" value="<?php echo $tanggal?>">
                        <input type="hidden" name="indexing" value="<?php echo $indexing?>">
                        <input type="hidden" name="perawatan" value="<?php echo $perawatan?>">

                    </div>



                   
                </div>
                
            </div>
            
            
       </div>
   </div>
   
</div>
</form>
