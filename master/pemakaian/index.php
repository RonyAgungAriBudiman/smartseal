<?php
if($_GET["sm"]=="pb") include "master/pemakaian/pb.php";
else if($_GET["sm"]=="rd") include "master/pemakaian/rd.php";
else if($_GET["sm"]=="p2tl") include "master/pemakaian/p2tl.php";
else if($_GET["sm"]=="phar") include "master/pemakaian/phar.php";
else if($_GET["sm"]=="ggan") include "master/pemakaian/ggan.php";
else if($_GET["sm"]=="tsbg") include "master/pemakaian/tsbg.php";
else if($_GET["sm"]=="pesta") include "master/pemakaian/pesta.php";
else include "master/pemakaian/list.php";
?>