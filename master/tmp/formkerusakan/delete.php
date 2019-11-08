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

if(isset($_POST['delete']))
{
    $sukses=false;
    $sql_del ="DELETE FROM MTN_KERUSAKAN WHERE KerusakanID ='".$_POST["kerusakanid"]."' ";
    $run_del =$sqlLib->delete($sql_del);    
    $sukses=true;

    if($sukses)
    {
        $sql_up="UPDATE ms_index_maintenance SET Status ='good' ";
        $run_up=$sqlLib->update($sql_up);
    }  

    
}
?>
<!--<form class="form" id="form-transaksi">-->

<form method="post" id="form"  name="form"  action="<?php $_SERVER['PHP_SELF']; ?>" target="_self"> 
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
                          <input type="text" class="form-control pull-right tgl" name="tgl" value="<?php echo $_POST["tgl"]?>" onchange="submit();"   style="text-align:center; font-size:40px; height:60px; font-weight:bolder; cursor:not-allowed; outline:none ">
                    </div>                    
                    </div>
                   
                </div>
                
            </div>
            
            
       </div>
   </div>

</form>


   <div class="col-md-12" >
        <div class="box box-primary">
        <div class="box-header">DATA INDEX</div>
            <div class="box-body">
                <div class="table-responsive" style="height:<?php echo $height?>px; background-color:#e3e8ee">
                <table class="table table-striped fonttable">
                <thead>
                  <tr>
                    <th>INDEX</th>
                    <th>KERUSAKAN</th>
                  </tr>
                </thead>
                <tbody>
                     <?php
                            $tanggal = date("Y-m-d", strtotime($_POST['tgl']));
                            $sql ="SELECT KerusakanID, Indexing, Kerusakan FROM MTN_KERUSAKAN WHERE Tanggal ='".$tanggal."' AND Penerima ='".$_SESSION["userid"]."' AND Status !='good' ";
                            $data=$sqlLib->select($sql);
                            foreach($data as $list)
                            {  
                                ?>
                            <tr>
                                <td><?php echo $list["Indexing"] ?> </td>
                                <td><?php echo $list["Kerusakan"]  ?> </td>

                                <form method="post" id="form"  name="form"  action="<?php $_SERVER['PHP_SELF']; ?>" target="_self"> 
                                <td><input type="submit" name="delete" value="Delete" class="btn btn-danger" /> 
                                    <input type="hidden" name="kerusakanid" value="<?php echo $list["KerusakanID"] ?>">
                                   
                                </td>
                                </form> 
                            </tr>                    

                           
                            <?php } 
                        ?> 
                </tbody>
                </table>    
                
            </div>
        </div>
        </div>
   </div>
   
</div>
<script type="text/javascript">


    $(function () {
    //Date picker
    $('.tgl').datepicker({
        format: 'dd-M-yyyy',
        autoclose: true
    })
    
    
    })
</script>