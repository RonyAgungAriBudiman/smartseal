<?php
# Pengaturan tanggal komputer
date_default_timezone_set("Asia/Jakarta");



# Fungsi untuk membuat kode automatis
function buatKode($tabel, $inisial){
	$struktur	= mssql_query("SELECT * FROM $tabel");
	$field		= mssql_field_name($struktur,0);
	//$panjang	= mssql_field_lenght($struktur,0);

 	$qry	= mssql_query("SELECT MAX(".$field.") FROM ".$tabel);
 	$row	= mssql_fetch_array($qry); 
 	if ($row[0]=="") {
 		$angka=0;
	}
 	else {
 		$angka		= substr($row[0], strlen($inisial));
 	}
	
 	$angka++;
 	$angka	=strval($angka); 
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
 	return $inisial.$tmp.$angka;
}

# Fungsi Jam
function Jam($time){
	$time=date('H:i',strtotime($time));
	return $time;
}

# Fungsi Hari
function Hari($hari){
$array_hari = array(1=>"Senin","Selasa","Rabu","Kamis","Jumat", "Sabtu","Minggu");
$hari = $array_hari[$hari("N")];
	return $hari;
}


# Fungsi untuk membalik tanggal dari format Indo (d-m-Y) -> English (Y-m-d)
function InggrisTgl($tanggal){
	$tgl=substr($tanggal,0,2);
	$bln=substr($tanggal,3,2);
	$thn=substr($tanggal,6,4);
	$tanggal="$thn-$bln-$tgl";
	return $tanggal;
}


function SimpleDate($date)
{
  $date= date("Y-m-d",strtotime($date));
  return "$date";
}

# Fungsi untuk membalik tanggal dari format English (Y-m-d) -> Indo (d-m-Y)
function Inggris2Tgl($tanggal){
	$namaBln = array("01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", 
					 "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December");
					 
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$tanggal ="$tgl ".$namaBln[$bln]." $thn";
	return $tanggal;
}

# Fungsi untuk membalik tanggal dari format English (Y-m-d) -> Indo (d-m-Y)
function bulannow($tanggal){
  $namaBln = array("01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", 
           "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December");
           
  $tgl=substr($tanggal,8,2);
  $bln=substr($tanggal,5,2);
  $thn=substr($tanggal,0,4);
  $bulan =$namaBln[$bln];
  return $bulan;
}

# Fungsi untuk membalik tanggal dari format English (Y-m-d) -> Indo (d-m-Y)
function IndonesiaTgl($tanggal){
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$tanggal="$tgl/$bln/$thn";
	return $tanggal;
}

function IndonesiaTgl1($tanggal){
  $tgl=substr($tanggal,8,2);
  $bln=substr($tanggal,5,2);
  $thn=substr($tanggal,0,4);
  $tanggal="$tgl-$bln-$thn";
  return $tanggal;
}

# Fungsi untuk membalik tanggal dari format English (Y-m-d) -> Indo (d-m-Y)
function Indonesia2Tgl($tanggal){
	$namaBln = array("01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni", 
					 "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember");
					 
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$tanggal ="$tgl ".$namaBln[$bln]." $thn";
	return $tanggal;
}


# Fungsi untuk membalik tanggal dari format bulan abjad
function Bln_Code($tanggal){
	$namaBln = array("01" => "A", "02" => "B", "03" => "C", "04" => "D", "05" => "E", "06" => "F", 
					 "07" => "G", "08" => "H", "09" => "I", "10" => "J", "11" => "K", "12" => "L");
					 
	$tgl=substr($tanggal,8,2);
	$bln=substr($tanggal,5,2);
	$thn=substr($tanggal,0,4);
	$tanggal =$namaBln[$bln];
	return $tanggal;
}

# Fungsi untuk membalik tanggal dari format bulan
function Thn_Code($tanggal){
	$thn=substr($tanggal,2,2);
	$tanggal =$thn;
	return $tanggal;
}

# Fungsi untuk membalik tanggal dari format bulan
function tahunnow($tanggal){
  $thn=substr($tanggal,0,4);
  $tanggal =$thn;
  return $tanggal;
}

function hitungHari($myDate1, $myDate2){
        $myDate1 = strtotime($myDate1);
        $myDate2 = strtotime($myDate2);
 
        return ($myDate2 - $myDate1)/ (24 *3600);
}

# Fungsi untuk membuat format rupiah pada angka (uang)
function format_angka($angka) {
	$hasil =  number_format($angka,0, ".",",");
	return $hasil;
}

function FAngka0($angka) {
	$hasil =  number_format($angka,0, ".",",");
	return $hasil;
}

function FAngka2($angka) {
	$hasil =  number_format($angka,2, ".",",");
	return $hasil;
}
# Fungsi untuk format tanggal, dipakai plugins Callendar
function form_tanggal($nama,$value=''){
	echo" <input type='text' name='$nama' id='$nama' size='11' maxlength='20' value='$value'/>&nbsp;
	<img src='images/calendar-add-icon.png' align='top' style='cursor:pointer; margin-top:7px;' alt='kalender'onclick=\"displayCalendar(document.getElementById('$nama'),'dd-mm-yyyy',this)\"/>			
	";
}

function angkaTerbilang($x){
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return angkaTerbilang($x - 10) . " belas";
  elseif ($x < 100)
    return angkaTerbilang($x / 10) . " puluh" . angkaTerbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . angkaTerbilang($x - 100);
  elseif ($x < 1000)
    return angkaTerbilang($x / 100) . " ratus" . angkaTerbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . angkaTerbilang($x - 1000);
  elseif ($x < 1000000)
    return angkaTerbilang($x / 1000) . " ribu" . angkaTerbilang($x % 1000);
  elseif ($x < 1000000000)
    return angkaTerbilang($x / 1000000) . " juta" . angkaTerbilang($x % 1000000);
}


function getday($tgl,$sep){
        $sepparator = $sep; //separator. contoh: '-', '/'
        $parts = explode($sepparator, $tgl);
        $d = date("l", mktime(0, 0, 0, $parts[1], $parts[2], $parts[0]));
 
        if ($d=='Monday'){
            return 'SENIN';
        }elseif($d=='Tuesday'){
            return 'SELASA';
        }elseif($d=='Wednesday'){
            return 'RABU';
        }elseif($d=='Thursday'){
            return 'KAMIS';
        }elseif($d=='Friday'){
            return 'JUMAT';
        }elseif($d=='Saturday'){
            return 'SABTU';
        }elseif($d=='Sunday'){
            return 'MINGGU';
        }else{
            return 'ERROR!';
        }
    }
	
function Romawi($n){
$hasil = "";
$iromawi = array("","I","II","III","IV","V","VI","VII","VIII","IX","X",20=>"XX",30=>"XXX",40=>"XL",50=>"L",
60=>"LX",70=>"LXX",80=>"LXXX",90=>"XC",100=>"C",200=>"CC",300=>"CCC",400=>"CD",500=>"D",600=>"DC",700=>"DCC",
800=>"DCCC",900=>"CM",1000=>"M",2000=>"MM",3000=>"MMM");
if(array_key_exists($n,$iromawi)){
$hasil = $iromawi[$n];
}elseif($n >= 11 && $n <= 99){
$i = $n % 10;
$hasil = $iromawi[$n-$i] . Romawi($n % 10);
}elseif($n >= 101 && $n <= 999){
$i = $n % 100;
$hasil = $iromawi[$n-$i] . Romawi($n % 100);
}else{
$i = $n % 1000;
$hasil = $iromawi[$n-$i] . Romawi($n % 1000);
}
return $hasil;
}

function UploadCompress($new_name,$file,$dir,$quality){
  //direktori gambar
  $vdir_upload = $dir;
  $vfile_upload = $vdir_upload . $_FILES[''.$file.'']["name"];
 
  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES[''.$file.'']["tmp_name"], $dir.$_FILES[''.$file.'']["name"]);
  $source_url=$dir.$_FILES[''.$file.'']["name"];
  $info = getimagesize($source_url);
 
    if ($info['mime'] == 'image/jpeg'){ 
        $image = imagecreatefromjpeg($source_url); 
        $ext='.jpg';
    }
    elseif($info['mime'] == 'image/gif'){ 
        $image = imagecreatefromgif($source_url); 
        $ext='.gif';
    }elseif($info['mime'] == 'image/png'){ 
        $image = imagecreatefrompng($source_url); 
        $ext='.png';
    }
   
    if(imagejpeg($image, $dir.$new_name.$ext, $quality)){
        unlink($source_url);
        return true;
    }else{
        unlink($source_url);
        return false;
    }
   
}

function UploadCompressMultiple($new_name,$file,$dir,$quality,$f)
{
  //direktori gambar
  $vdir_upload = $dir;
  $vfile_upload = $vdir_upload . $_FILES[''.$file.'']["name"];
 
  //Simpan gambar dalam ukuran sebenarnya
  move_uploaded_file($_FILES[''.$file.'']["tmp_name"][$f], $dir.$_FILES[''.$file.'']["name"]);
  $source_url=$dir.$_FILES[''.$file.'']["name"];
  $info = getimagesize($source_url);
 
    if ($info['mime'] == 'image/jpeg'){ 
        $image = imagecreatefromjpeg($source_url); 
        $ext='.jpg';
    }
    elseif($info['mime'] == 'image/gif'){ 
        $image = imagecreatefromgif($source_url); 
        $ext='.gif';
    }elseif($info['mime'] == 'image/png'){ 
        $image = imagecreatefrompng($source_url); 
        $ext='.png';
    }
   
    if(imagejpeg($image, $dir.$new_name.$ext, $quality)){
        unlink($source_url);
        return true;
    }else{
        unlink($source_url);
        return false;
    }
	  
}





?>