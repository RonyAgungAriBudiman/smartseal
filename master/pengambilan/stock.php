<?php
session_start();
include_once "../../sqlLib.php"; $sqlLib = new sqlLib();
$sql =" SELECT COUNT(NoSegel) as stock FROM ms_penerimaan WHERE Bidang = '".$_POST['bidang']."' AND  AreaID = '".$_POST['areaid']."' AND Status ='ready' ";
$data=$sqlLib->select($sql);

?>


<label for="Description">Stock</label>
    <input name="stock" id="stock"  class="form-control"  value="<?php echo $sql  ?>" />