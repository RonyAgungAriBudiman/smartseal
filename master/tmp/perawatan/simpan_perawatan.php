<?php
session_start();
include_once "../../../sqlLib.php"; $sqlLib = new sqlLib();
if(!isset($_SESSION["userid"]) OR  !isset($_SESSION["nama"])) 
{
	if($_COOKIE["userid"]!="" AND $_COOKIE["nama"]!="")
	{
		$_SESSION["userid"] = $_COOKIE["userid"];
		$_SESSION["nama"] = $_COOKIE["nama"];
		$_SESSION["nik"] = $_COOKIE["nik"];
		$_SESSION["shift"] = $_COOKIE["shift"];
	}
	else header("Location:../../signin.php");
}


$tanggal   = date("Y-m-d",strtotime($_POST['tgl']));
$indexing  = $_POST['indexing'];
$perawatan = $_POST['perawatan'];
$part1     = $_POST['part1'];
$part2     = $_POST['part2'];
$part3     = $_POST['part3'];
$qty1      = $_POST['qty1'];
$qty2      = $_POST['qty2'];
$qty3      = $_POST['qty3'];
$petugas1  = $_POST['petugas1'];
$petugas2  = $_POST['petugas2'];
$petugas3  = $_POST['petugas3'];


/*$id =date("YmdHis");
$sql1 ="INSERT INTO MTN_PERAWATAN (PerawatanID ,Tanggal ,Indexing, Perawatan , Part1 ,Qty1 , Part2 , Qty2 , Part3, Qty3 , Petugas1 , Petugas2 ,Petugas3)
		VALUES ('".$id."','".$tanggal."','".$indexing."','".$perawatan."','".$part1."','".$qty1."','".$part2."','".$qty2."','".$part3."','".$qty3."','".$petugas1."','".$petugas2."', '".$petugas3."')"; 
$run1 =$sqlLib->insert($sql1);		
*/
/*
if($part1!='' AND $qty1!='')
{	
$stockid = $id.'/1';
$sql2 ="INSERT INTO ms_stock_sparepart (StockID, Tanggal, SparepartID, Qty, Jenis, Urut)
		VALUES ('".$stockid."', '".$tanggal."', '".$part1."', '".$qty1."',  'keluar' , '1')";
$run2 =$sqlLib->insert($sql2);
}

if($part2!='' AND $qty2!='')
{	
$stockid = $id.'/2';
$sql3 ="INSERT INTO ms_stock_sparepart (StockID, Tanggal, SparepartID, Qty, Jenis, Urut)
		VALUES ('".$stockid."', '".$tanggal."', '".$part2."', '".$qty2."',  'keluar' , '2')";
$run3 =$sqlLib->insert($sql3);
}

if($part3!='' AND $qty2!='')
{	
$stockid = $id.'/3';
$sql4 ="INSERT INTO ms_stock_sparepart (StockID, Tanggal, SparepartID, Qty, Jenis, Urut)
		VALUES ('".$stockid."', '".$tanggal."', '".$part4."', '".$qty4."',  'keluar' , '3')";
$run4 =$sqlLib->insert($sql4);
}
*/
echo "SUKSES";
?>