<?php 

if($_POST["dari"]=="") $_POST["dari"] = date("01-M-Y");
if($_POST["sampai"]=="") $_POST["sampai"] = date("d-M-Y");

?>

      <div class="row">
        <div class="col-xs-12">
          
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"></h3> 

              <form method="post"  action="index.php?m=stock&sm=bidang"  autocomplete="off">
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
                    <a href="index.php?m=pengambilan&sm=input"><button type="button" class="btn btn-success" >Input Pengambilan</button></a>
                </div> 
              </form>

            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="dtHorizontalVerticalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>Pengambilan ID</th>
                  <th>Tanggal</th>
                  <th>Area</th>
                  <th>Bidang</th>
                  <th>Qty</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                 <?php 
                  $sql ="SELECT DISTINCT a.PengambilanID, a.Tanggal, a.Bidang, b.Area, (SELECT COUNT(z.NoSegel)  FROM ms_pengambilan z WHERE z.PengambilanID = a.PengambilanID) AS Qty 
                          FROM ms_pengambilan a 
                          LEFT JOIN ms_area b on b.AreaID = a.AreaID
                          WHERE a.Tanggal >='".date("Y-m-d",strtotime($_POST['dari']))."' AND a.Tanggal <= '".date("Y-m-d",strtotime($_POST['sampai']))."' 
                          ORDER BY a.PengambilanID DESC ";
                  $data= $sqlLib->select($sql);
                  foreach($data as $row)
                  {  ?>   
                    <tr>
                      <td><?php echo $row["PengambilanID"]?></td>
                      <td><?php echo date("d-M-Y",strtotime($row['Tanggal']))?></td>
                      <td><?php echo $row["Area"]?></td>
                      <td><?php echo $row["Bidang"]?></td>
                      <td><?php echo $row["Qty"]?></td>
                     
                      <td>

                        <form method="post" autocomplete="off">
                        <input type="submit" name="Hapus" value="Hapus" class="btn btn-danger">
                        <input type="hidden" name="pengambilanid" value="<?php echo $row["PengambilanID"]?>">
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