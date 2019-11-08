<?php
if($_POST["tgl"]=="") $_POST["tgl"]=date("d-M-Y");
?>
<ul class="nav nav-tabs nav-pills">
  <li <?php if($_GET["sm"]==""){ echo 'class="active"';}?>><a href="index.php?m=formkerusakan">KERUSAKAN</a></li>
 <!-- <li <?php if($_GET["sm"]=="perbaikan"){ echo 'class="active"';}?>><a href="index.php?m=formkerusakan&sm=perbaikan">PERBAIKAN DAN ANALISA</a></li>-->
  <li <?php if($_GET["sm"]=="delete"){ echo 'class="active"';}?>><a href="index.php?m=formkerusakan&sm=delete">DELETE</a></li>
</ul>

<?php
if($_GET["sm"]=="delete") include "master/formkerusakan/delete.php";
else include "master/formkerusakan/kerusakan.php";
?>