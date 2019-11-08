<?php
header("Refresh:25; url=mi.php");
session_start();
if(!isset($_SESSION["userid"]) OR  !isset($_SESSION["nama"])) 
{
	if($_COOKIE["userid"]!="" AND $_COOKIE["nama"]!="")
	{
		$_SESSION["userid"] = $_COOKIE["userid"];
		$_SESSION["nama"] = $_COOKIE["nama"];
		$_SESSION["nik"] = $_COOKIE["nik"];
		$_SESSION["shift"] = $_COOKIE["shift"];
	}
	else header("Location:signin.php");
}
include_once "../../sqlLib.php"; $sqlLib = new sqlLib();
function counter_produksi_monitoring($produkid, $prosesid, $tgl, $shift, $sqlLib)
{
	$sql_qty = "SELECT coalesce(jumlah,NULL,0) as jumlah, prosesid FROM PRO_MONITOR_PRODUKSI 
				WHERE prosesid = '".$prosesid."' AND CONVERT(DATE,Tanggal) = '".$tgl."' AND type = '".$produkid."' AND shift = '".$_SESSION["shift"]."'";
	$data_qty = $sqlLib->select($sql_qty);
	
	if($data_qty[0]["prosesid"] != "")
	{
		$sql = "UPDATE PRO_MONITOR_PRODUKSI SET jumlah = (".$data_qty[0]["jumlah"]."+1) 
				WHERE prosesid = '".$prosesid."' AND CONVERT(DATE,Tanggal) = '".$tgl."' AND type = '".$produkid."' AND shift = '".$_SESSION["shift"]."'";
		$run = $sqlLib->update($sql);
	}
	else if($data_qty[0]["prosesid"] == "")
	{
		$sql = "INSERT INTO PRO_MONITOR_PRODUKSI(prosesid, tanggal, type, jumlah, shift)
				VALUES('".$prosesid."','".$tgl."','".$produkid."','1', '".$_SESSION["shift"]."')";
		$run = $sqlLib->insert($sql);
	}
}

counter_produksi_monitoring('810V2', '6', date("Y-m-d"), $_SESSION["shift"], $sqlLib);
?>