
<?php 

if(isset($_POST['Simpan']))
{	 
  $sql_cek ="SELECT AreaID FROM ms_area WHERE AreaID = '".$_POST['areaid']."' ";
  $data_cek=$sqlLib->select($sql_cek);
  
  if(Count($data_cek)>'0')
  {
    $warning ='1';
    $note .= "AreaID Sudah Digunakan";
  }
  else
  {  
    $sql ="INSERT INTO ms_area (AreaID, Area) VALUES ('".$_POST['areaid']."', '".$_POST['area']."')";
    $run =$sqlLib->insert($sql);
    
  }  
}


if(isset($_POST['Update']))
{
  $sql_upd ="UPDATE ms_area SET Area ='".$_POST['area']."'
                WHERE AreaID = '".$_POST['areaid']."'     ";
  $run_upd = $sqlLib->update($sql_upd);  
       
}

if(isset($_POST['Hapus']))
{
  $sql_delete = "DELETE FROM ms_area WHERE AreaID = '".$_POST['areaid']."' ";
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
        Data Area
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"></h3>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Tambah</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="dtHorizontalVerticalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>Area ID</th>
                  <th>Area</th>
                  <th></th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                 <?php 
					$sql ="SELECT * FROM ms_area ";
					$data= $sqlLib->select($sql);
					foreach($data as $row)
					{  ?>		
						<tr>
							<td><?php echo $row["AreaID"]?></td>
							<td><?php echo $row["Area"]?></a></td>
							<td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModaledit<?php echo $row['AreaID']; ?>">Edit</button></td>
							<td>

								<form method="post">
								<input type="submit" name="Hapus" value="Hapus" class="btn btn-danger">
								<input type="hidden" name="areaid" value="<?php echo $row["AreaID"]?>">
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
	        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Area</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form method="post">
	          <div class="form-group">
	            <label for="areaid" class="col-form-label">Area ID</label>
	            <input type="text" class="form-control" id="areaid" name="areaid">
	          </div>
	          <div class="form-group">
	            <label for="area" class="col-form-label">Area</label>
	            <input type="text" class="form-control" id="area" name="area">
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