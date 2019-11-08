
<?php
if($_POST["dari"]=="") $_POST["dari"] = date("01-M-Y");
if($_POST["sampai"]=="") $_POST["sampai"] = date("d-M-Y");
?>
<ul class="nav nav-tabs nav-pills">
  <li <?php if($_GET["sm"]==""){ echo 'class="active"';}?>><a href="index.php?m=stock">WH</a></li>
  <li <?php if($_GET["sm"]=="bidang"){ echo 'class="active"';}?>><a href="index.php?m=stock&sm=bidang">BIDANG</a></li>
</ul>

<?php
if($_GET["sm"]=="bidang") include "master/stock/bidang.php";
else include "master/stock/wh.php";
?>