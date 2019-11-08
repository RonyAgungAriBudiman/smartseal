<?php
if($_GET["sm"]=="add") include "master/project/add.php";
else if($_GET["sm"]=="member") include "master/project/member.php";
else if($_GET["sm"]=="detail") include "master/project/detail.php";
else include "master/project/list.php";
?>