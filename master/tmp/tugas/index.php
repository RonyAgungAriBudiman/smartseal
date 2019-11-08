<?php
if($_GET["sm"]=="add") include "master/tugas/add.php";
else if($_GET["sm"]=="member") include "master/tugas/member.php";
else if($_GET["sm"]=="detail") include "master/tugas/detail.php";
else include "master/tugas/list.php";
?>