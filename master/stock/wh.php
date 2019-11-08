<?php 

if($_POST["dari"]=="") $_POST["dari"] = date("01-M-Y");
if($_POST["sampai"]=="") $_POST["sampai"] = date("d-M-Y");
?>

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
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"></h3> 

              <form method="post" action="index.php?m=stock" autocomplete="off">
                <div class="col-md-1">
                  <div class="input-group">
                    
                      
                      <select class="form-control" name="areaid">
                        <option value="">Pilih Area</option>
                        <?php
                          $sql_area = "SELECT AreaID, Area FROM ms_area";
                          $data_area= $sqlLib->select($sql_area);
                          foreach ($data_area as $row) 
                          { ?>
                           <option  value="<?php echo $row["AreaID"] ?>" <?php if($row["AreaID"]==$_POST["areaid"]) { echo "selected";} ?>><?php echo $row["Area"] ?></option>
                          <?php }
                        ?>
                      </select>
                  </div>    
                </div>  

                <div class="col-md-1">
                  <div class="input-group">
                      <select class="form-control" name="bidang">
                        <option value="">Pilih Bidang</option>
                        <?php
                          $sql_area = "SELECT DISTINCT Bidang FROM ms_penerimaan";
                          $data_area= $sqlLib->select($sql_area);
                          foreach ($data_area as $row) 
                          { ?>
                           <option  value="<?php echo $row["Bidang"] ?>" <?php if($row["Bidang"]==$_POST["bidang"]) { echo "selected";} ?>><?php echo $row["Bidang"] ?></option>
                          <?php }
                        ?>
                      </select>  
                  </div>                 
                </div>     

                 <div class="col-md-1">
                    <input type="submit" name="Search" value="Search" class="btn btn-primary">
                </div> 
              </form>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="dtHorizontalVerticalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>Area</th>
                  <th>Bidang</th>
                  <th>WH</th>
                  <th>Petugas</th>
                  <th>Terpasang</th>
                  <th>Non Aktif</th>
                  <th>Total</th>
                </tr>
                </thead>
                <tbody>
                 <?php 
                 $kondisi ="";
                 if($_POST["areaid"]!="") $kondisi .= " AND a.AreaID = '".$_POST["areaid"]."' ";
                  $sql ="SELECT DISTINCT a.Bidang, a.AreaID, b.Area, (SELECT COUNT(z.NoSegel)  FROM ms_penerimaan z WHERE z.Bidang = a.Bidang AND z.AreaID = a.AreaID AND z.Status ='ready') AS Wh,
                   (SELECT COUNT(x.NoSegel)  FROM ms_pengambilan x WHERE x.Bidang = a.Bidang AND x.AreaID = a.AreaID AND x.Status ='ready') AS Petugas,
                   (SELECT COUNT(y.NoSegel)  FROM ms_pemasangan y WHERE y.Bidang = a.Bidang AND y.AreaID = a.AreaID AND y.Status ='aktif') AS Terpasang,
                   (SELECT COUNT(y.NoSegel)  FROM ms_pemasangan y WHERE y.Bidang = a.Bidang AND y.AreaID = a.AreaID AND y.Status ='nonaktif') AS Nonaktif

                          FROM ms_penerimaan a 
                          LEFT JOIN ms_area b on b.AreaID = a.AreaID
                          WHERE a.Bidang !='' ";
                  if($kondisi!="") $sql .= $kondisi;        
                  $data= $sqlLib->select($sql);
                  foreach($data as $row)
                  { 
                    $total = $row["Wh"] + $row["Petugas"] + $row["Terpasang"] + $row["Nonaktif"]; 
                    ?>   
                    <tr>

                      <td><?php echo $row["Area"]?></td>
                      <td><?php echo $row["Bidang"]?></td>
                      <td><?php echo $row["Wh"]?></td>
                      <td><?php echo $row["Petugas"]?></td>
                      <td><?php echo $row["Terpasang"]?></td>
                      <td><?php echo $row["Nonaktif"]?></td>
                      <td><?php echo $total?></td>
                     
                     
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