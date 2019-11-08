<?php
if($_POST["tgl"]=="") $_POST["tgl"]=date("d-M-Y");
?>
<ul class="nav nav-tabs nav-pills">
  <li <?php if($_GET["sm"]==""){ echo 'class="active"';}?>><a href="index.php?m=perawatan">PERAWATAN</a></li>
  <li <?php if($_GET["sm"]=="part"){ echo 'class="active"';}?> ><a href="#">PART</a></li>
  <li <?php if($_GET["sm"]=="petugas"){ echo 'class="active"';}?>><a href="#">PETUGAS</a></li>
</ul>

<?php
if($_GET["sm"]=="part") include "master/perawatan/part.php";
else if($_GET["sm"]=="petugas") include "master/perawatan/petugas.php";
else include "master/perawatan/indexing.php";
?>