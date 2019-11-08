<?php 
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
include "../../koneksi_sql.php";
include_once "../../sqlLib.php";  $sqlLib = new sqlLib();

function counter_produksi_monitoring($produkid, $prosesid, $tgl, $shift, $sqlLib)
{
	$sql_qty = "SELECT coalesce(jumlah,NULL,0) as jumlah, prosesid FROM PRO_MONITOR_PRODUKSI 
				WHERE prosesid = '".$prosesid."' AND CONVERT(DATE,Tanggal) = '".$tgl."' AND type = '".$produkid."' AND shift = '".$shift."'";
	$data_qty = $sqlLib->select($sql_qty);
	
	$jumlah = $data_qty[0]["jumlah"]+1;
	
	if($data_qty[0]["prosesid"] != "")
	{
		$sql = "UPDATE PRO_MONITOR_PRODUKSI SET jumlah = '".$jumlah."' 
				WHERE prosesid = '".$prosesid."' AND CONVERT(DATE,Tanggal) = '".$tgl."' AND type = '".$produkid."' AND shift = '".$shift."'";
		$run = $sqlLib->update($sql);
	}
	else if($data_qty[0]["prosesid"] == "")
	{
		$sql = "INSERT INTO PRO_MONITOR_PRODUKSI(prosesid, tanggal, type, jumlah, shift)
				VALUES('".$prosesid."','".$tgl."','".$produkid."','".$jumlah."', '".$shift."')";
		$run = $sqlLib->insert($sql);
	}

	if($run) {
		$sql_qty = "SELECT coalesce(jumlah,NULL,0) as jumlah, prosesid FROM PRO_MONITOR_PRODUKSI 
					WHERE prosesid = '".$prosesid."' AND CONVERT(DATE,Tanggal) = '".$tgl."' AND type = '".$produkid."' AND shift = '".$shift."'";
		$data_qty = $sqlLib->select($sql_qty);
		return number_format($data_qty[0]["jumlah"]);
	}else{
		return "error";
	}
}

echo counter_produksi_monitoring($_POST["type"], $_POST["prosesid"], date("Y-m-d",strtotime($_POST["tgl"])), $_POST["shift"], $sqlLib);
?>