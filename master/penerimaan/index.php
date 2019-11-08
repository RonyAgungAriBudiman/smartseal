
<?php 

if($_POST["dari"]=="") $_POST["dari"] = date("01-M-Y");
if($_POST["sampai"]=="") $_POST["sampai"] = date("d-M-Y");

if(isset($_POST['Simpan']))
{  
  $tahun = substr(date("Y"), 2);
  $areaid=$_POST["areaid"];
  $bidang=$_POST["bidang"];
  $penerimaanid = "10".date("YmdHis");

  //cek urutan 
  $sql_cek  = "SELECT Urut FROM ms_penerimaan WHERE AreaID = '".$_POST['areaid']."' AND Bidang = '".$_POST['bidang']."' AND YEAR(Tanggal) = '".date("Y")."' Order By Urut Desc  LIMIT 1 ";
  $data_cek = $sqlLib->select($sql_cek);

  $next_urut    = $data_cek[0]["Urut"] +1;
  $jmldata        = $data_cek[0]["Urut"] + $_POST["qty"] ;

  for($i=$next_urut; $i<=$jmldata; $i++)
    {
      if (strlen($i)=="1")
        {
          $nomor  = "00000".$i;
        }
      if (strlen($i)=="2")
        {
          $nomor  = "0000".$i;
        }
      if (strlen($i)=="3")
        {
          $nomor  = "000".$i;
        }
      if (strlen($i)=="4")
        {
          $nomor  = "00".$i;
        }
      if (strlen($i)=="5")
        {
          $nomor  = "0".$i;
        }
      if (strlen($i)=="6")
        {
          $nomor  = $i;
        }         
      
      $no_segel = $areaid.'-'.$bidang.'-'.$nomor.'-'.$tahun ; 

      

      //proses simpan
      $sql = "INSERT INTO ms_penerimaan (PenerimaanID, Tanggal, NoSegel, AreaID, Bidang, Urut, Status, PengambilanID )
          VALUES ('".$penerimaanid."', '".date("Y-m-d")."', '".$no_segel."', '".$areaid."', '".$bidang."',  '".$i."', 'ready', '')";
      $run = $sqlLib->insert($sql); 
  

    } 
}



if(isset($_POST['Hapus']))
{
  $sql_delete = "DELETE FROM ms_penerimaan WHERE PenerimaanID = '".$_POST['penerimaanid']."' ";
  $run_delete = $sqlLib->delete($sql_delete);
}  


if($warning=="1")
{
  ?>
    <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i> PERINGATAN !</h4>
    <?php echo $note?>
    </div>
    <?php 
} ?>     

<style type="text/css">
.dtHorizontalVerticalExampleWrapper {
max-width: 600px;
margin: 0 auto;
}
#dtHorizontalVerticalExample th, td {
white-space: nowrap;
}
table.dataTable thead .sorting:after,
table.dataTable thead .sorting:before,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_asc_disabled:after,
table.dataTable thead .sorting_asc_disabled:before,
table.dataTable thead .sorting_desc:after,
table.dataTable thead .sorting_desc:before,
table.dataTable thead .sorting_desc_disabled:after,
table.dataTable thead .sorting_desc_disabled:before {
bottom: .5em;
}
</style>

    <section class="content-header">
      <h1>
        Penerimaan Segel
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"></h3> 

              <form method="post" autocomplete="off">
                <div class="col-md-2">
                  <div class="input-group date">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right tgl" id="dari" name="dari" value="<?php echo $_POST["dari"]?>"  style="text-align:center">
                  </div>    
                </div>  

                <div class="col-md-2">
                  <div class="input-group date">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right tgl" id="sampai" name="sampai" value="<?php echo $_POST["sampai"]?>"  style="text-align:center">
                  </div>    
                </div>  

                 <div class="col-md-2">
                    <input type="submit" name="Search" value="Search" class="btn btn-primary">
                </div> 


                 <div class="col-md-2" style="float: right;">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Input Penerimaan</button>
                </div> 
              </form>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="dtHorizontalVerticalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>Penerimaan ID</th>
                  <th>Tanggal</th>
                  <th>Area</th>
                  <th>Bidang</th>
                  <th>Qty</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                 <?php 
                  $sql ="SELECT DISTINCT a.PenerimaanID, a.Tanggal, a.Bidang, b.Area, (SELECT COUNT(z.NoSegel)  FROM ms_penerimaan z WHERE z.PenerimaanID = a.PenerimaanID) AS Qty 
                          FROM ms_penerimaan a 
                          LEFT JOIN ms_area b on b.AreaID = a.AreaID
                          WHERE a.Tanggal >='".date("Y-m-d",strtotime($_POST['dari']))."' AND a.Tanggal <= '".date("Y-m-d",strtotime($_POST['sampai']))."' ";
                  $data= $sqlLib->select($sql);
                  foreach($data as $row)
                  {  ?>   
                    <tr>
                      <td><?php echo $row["PenerimaanID"]?></td>
                      <td><?php echo date("d-M-Y",strtotime($row['Tanggal']))?></td>
                      <td><?php echo $row["Area"]?></td>
                      <td><?php echo $row["Bidang"]?></td>
                      <td><?php echo $row["Qty"]?></td>
                     
                      <td>

                        <form method="post" autocomplete="off">
                        <input type="submit" name="Hapus" value="Hapus" class="btn btn-danger">
                        <input type="hidden" name="penerimaanid" value="<?php echo $row["PenerimaanID"]?>">
                        </form>
                      </td>
                    </tr>

                    <div class="modal fade" id="exampleModaledit<?php echo $row['AreaID']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Data Area</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <?php
                        $sql="SELECT * FROM ms_area WHERE AreaID ='".$row['AreaID']."'" ;
                        $data= $sqlLib->select($sql);
                        ?>
                        <div class="modal-body">
                        <form method="post">
                          <div class="form-group">
                          <label for="areaid" class="col-form-label">Area ID</label>
                          <input type="text" class="form-control" id="areaid" name="areaid" readonly="readonly" value="<?php echo $data[0]['AreaID'] ?>" >
                          </div>
                          <div class="form-group">
                          <label for="area" class="col-form-label">Area</label>
                          <input type="text" class="form-control" id="area" name="areaid" value="<?php echo $data[0]['Area'] ?>">
                          </div>
                          
                        
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <input type="submit" name="Update" value="Update" class="btn btn-primary">
                        </div>
                        </form>
                      </div>
                      </div>
                    </div> 

                  <?php } ?>    
                
                </tbody>
                <tfoot>
                
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Penerimaan Segel</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post">

            <div class="form-group" style="padding-bottom: 2px;">
                <label for="Description">Area</label>
                 <select class="form-control" id="areaid" name="areaid">
                  <option value="">Pilih Area</option>  
                  <?php
                  $sql ="SELECT * FROM ms_area WHERE AreaID !='' ";
                  $data=$sqlLib->select($sql);
                  foreach ($data as $row)
                    {?>
                      <option value="<?php echo $row['AreaID']; ?>"><?php echo $row['Area']; ?></option>  
                    <?php } ?>
                 </select>
            </div> 

            <div class="form-group" style="padding-bottom: 2px;">
                <label for="Description">Bidang </label>
                 <select class="form-control" id="bidang" name="bidang" >
                  <option value="">Pilih Bidang</option>  
                  <option value="PBPD">PBPD</option>  
                    <option value="P2TL">P2TL</option>                    
                    <option value="TSBG">TSBG</option>                              
                    <option value="GGAN">GGAN</option>                              
                    <option value="PHAR">PHAR</option>                              
                    <option value="PESTA">PESTA</option>                            
                    <option value="KHSS">KHSS</option>  
                </select>
            </div>              
              
            <div class="form-group" style="padding-bottom: 2px;">
                <label for="Description">Qty</label>
                 <input name="qty"  class="form-control" required="required" />
            </div> 

            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <input type="submit" name="Simpan" value="Simpan" class="btn btn-primary">
        </div>
          </form>
      </div>
    </div>
  </div>

  

<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

<script type="text/javascript">
$(document).ready(function () {
$('#dtHorizontalVerticalExample').DataTable({
"scrollX": true,
"scrollY": 200,
});
$('.dataTables_length').addClass('bs-select');
});
</script>