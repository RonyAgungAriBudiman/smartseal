
<?php 

if(isset($_POST['Simpan']))
{	 
  $sql_cek ="SELECT NamaProject FROM ms_project WHERE NamaProject = '".$_POST['namaproject']."' ";
  $data_cek=$sqlLib->select($sql_cek);
  
  if(Count($data_cek)>'0')
  {
    $warning ='1';
    $note .= "Nama Project Sudah Digunakan";
  }
  else
  {  
    $sql ="INSERT INTO ms_project (NamaProject , Keterangan, ParentID) VALUES ('".$_POST['namaproject']."', '".$_POST['keterangan']."', '0')";
    $run =$sqlLib->insert($sql);
    
  }  
}


if(isset($_POST['SubProject']))
{	 
  $sql_cek ="SELECT NamaProject FROM ms_project WHERE NamaProject = '".$_POST['namaproject']."' ";
  $data_cek=$sqlLib->select($sql_cek);
  
  if(Count($data_cek)>'0')
  {
    $warning ='1';
    $note .= "Nama Project Sudah Digunakan";
  }
  else
  {  
    $sql ="INSERT INTO ms_project (NamaProject , Keterangan, ParentID) VALUES ('".$_POST['namaproject']."', '".$_POST['keterangan']."', '".$_POST['parent']."')";
    $run =$sqlLib->insert($sql);
    
  }  
}


if(isset($_POST['Update']))
{
  $sql_upd ="UPDATE ms_project SET NamaProject ='".$_POST['namaproject']."', 
                                Keterangan='".$_POST['keterangan']."', 
                                ParentID='".$_POST['parent']."'
                WHERE ProjectID = '".$_POST['projectid']."'     ";
  $run_upd = $sqlLib->update($sql_upd);  
       
}

if(isset($_POST['Hapus']))
{
  $sql_delete = "DELETE FROM ms_project WHERE UserID = '".$_POST['userid']."' ";
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
        Data Project
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Tambah</button>
                  <button type="button" class="btn btn-primary  bg-purple" data-toggle="modal" data-target="#exampleModal1">SubProject</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="dtHorizontalVerticalExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama Project</th>
                  <th>Keterangan</th>
                  <th>Parent</th>
                  <th></th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                 <?php 
                            $sql ="SELECT * FROM ms_project ";
                            $data= $sqlLib->select($sql);
                            foreach($data as $row)
                            {  ?>		
				                <tr>
				                    <td><?php echo $row["ProjectID"]?></td>
	                                <td><?php echo $row["NamaProject"]?></td>
	                                <td><?php echo $row["Keterangan"]?></td>
	                                <td><?php echo $row["ParentID"]?></td>
	                                <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModaledit<?php echo $row['ProjectID']; ?>">Edit</button></td>
	                                <td>

								        <form method="post">
	                                	<input type="submit" name="Hapus" value="Hapus" class="btn btn-danger">
	                                    <input type="hidden" name="projectid" value="<?php echo $row["ProjectID"]?>">
	                                	</form>
	                                </td>
				                </tr>

				                <div class="modal fade" id="exampleModaledit<?php echo $row['ProjectID']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog" role="document">
								    <div class="modal-content">
								      <div class="modal-header">
								        <h5 class="modal-title" id="exampleModalLabel">Data Project</h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
								      </div>
								      <?php
								      $sql="SELECT * FROM ms_project WHERE ProjectID ='".$row['ProjectID']."'" ;
								      $data= $sqlLib->select($sql);
								      $_POST['parent'] = $data[0]['ParentID'];
								      ?>
								      <div class="modal-body">
								        <form method="post">
								          <div class="form-group">
								            <label for="username" class="col-form-label">Nama Project</label>
								            <input type="text" class="form-control" id="namaproject" name="namaproject"  value="<?php echo $data[0]['NamaProject'] ?>" >
								          </div>
								          <div class="form-group">
								            <label for="nama" class="col-form-label">Keterangan</label>
								            <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $data[0]['Keterangan'] ?>">
								          </div>
								          

								          <div class="form-group">
								            <label for="nama" class="col-form-label">Project</label>
								                <div >
								                    <select name="parent" class="form-control">
									            	<option value=""></option>
									            	<?php
									            		$sql = "SELECT ProjectID, NamaProject FROM ms_project
									            				WHERE NamaProject !='' ";
									            		$data=$sqlLib->select($sql);
									            		foreach ($data as $row)
									            		{?>
									            			<option value="<?php echo $row['ProjectID']?>" <?php if ($_POST['parent'] == $row['ProjectID']) { echo "selected"; } ?>><?php echo $row['NamaProject'] ?></option>
									            		<?php }			
									            	?>
									                </select>
																                
								                </div>
								          </div>
								      
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
								        <input type="submit" name="Update" value="Update" class="btn btn-primary">
								        <input type="hidden" name="projectid" value="<?php echo $data[0]['ProjectID']?>">
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
	        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Project</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form method="post">
	          <div class="form-group">
	            <label for="namaproject" class="col-form-label">Nama Project</label>
	            <input type="text" class="form-control" id="namaproject" name="namaproject">
	          </div>
	          <div class="form-group">
	            <label for="password" class="col-form-label">Keterangan</label>
	            <input type="text" class="form-control" id="keterangan" name="keterangan">
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

	<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Tambah Sub Project</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form method="post">
	          <div class="form-group">
	            <label for="namaproject" class="col-form-label">Nama Project</label>
	            <input type="text" class="form-control" id="namaproject" name="namaproject">
	          </div>
	          <div class="form-group">
	            <label for="password" class="col-form-label">Keterangan</label>
	            <input type="text" class="form-control" id="keterangan" name="keterangan">
	          </div>
	           <div class="form-group">
	            <label for="password" class="col-form-label">Project</label>
	            <select name="parent" class="form-control">
	            	<option value=""></option>
	            	<?php
	            		$sql = "SELECT ProjectID, NamaProject FROM ms_project
	            				WHERE NamaProject !='' ";
	            		$data=$sqlLib->select($sql);
	            		foreach ($data as $row)
	            		{?>
	            			<option value="<?php echo $row['ProjectID']?>"><?php echo $row['NamaProject'] ?></option>
	            		<?php }			
	            	?>
	            </select>
	            
	          </div>
	          
	      
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
	        <input type="submit" name="SubProject" value="Simpan" class="btn btn-primary">
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
