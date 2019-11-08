<?php
session_start();
include "../../koneksi_sql.php";
include_once "../../sqlLib.php";  $sqlLib = new sqlLib();
if($_POST["tgl"]=="") $_POST["tgl"] = date("Y-m-d");
?>
<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<form method="post">
<table style="font-size:12px; font-family:Tahoma, Geneva, sans-serif">
	<tr>
    	<td>Tanggal</td>
        <td><input type="date" name="tgl" value="<?php echo $_POST["tgl"]?>" style="padding:3px; font-size:12px;" /></td>
    	<td style="padding-left:20px">Shift</td>
        <td>
        <select name="shift" style="padding:3px; font-size:12px;">
            <option value=""></option>
            <?php
            for($i=1; $i<=3; $i++)
            {?>
                <option value="<?php echo $i?>" 
                <?php if($_POST["shift"]==$i){ echo "selected";}?>><?php echo $i?></option>
            <?php }?>
        </select>
        </td>
        <td>
        <input type="submit" name="run" value="start" style="padding:3px 8px; font-size:12px;" />
        </td>
    </tr>
</table>
</form>

<table style="font-size:12px; font-family:Tahoma, Geneva, sans-serif; width:100%">
<?php
$sql =" SELECT 	c.Proses, a.type, c.prosesid, a.tanggal, a.shift, a.target, CONCAT(b.Nama,' ',b.Spesifikasi) as produk
		FROM PRO_TARGET a
		LEFT JOIN ms_material b ON b.MaterialID = a.type
		LEFT JOIN PRO_PROSES c ON c.ProsesID = a.prosesid
		WHERE CONVERT(DATE,a.tanggal) = '".$_POST["tgl"]."' AND a.shift = '".$_POST["shift"]."'";
$data = $sqlLib->select($sql);
if(count($data)>0)
{?>
    <tr>
        <td style="border-bottom:solid 1px #333">PROSES</td>
        <td style="border-bottom:solid 1px #333; width:10px">TYPE</td>
        <td style="border-bottom:solid 1px #333; text-align:center; width:10px">RUN</td>
        <td style="border-bottom:solid 1px #333; text-align:center; width:10px">TIME</td>
        <td style="border-bottom:solid 1px #333; text-align:right; width:10px">TARGET</td>
        <td style="border-bottom:solid 1px #333; text-align:right; width:10px">HASIL</td>
    </tr>
<?php
}
$i=1;
foreach($data as $row)
{?>
	<form method="post" id="form<?php echo $i?>">
    <input type="hidden" name="tgl" value="<?php echo $_POST["tgl"]?>" />
    <input type="hidden" name="shift" value="<?php echo $_POST["shift"]?>" />
    <input type="hidden" name="prosesid" value="<?php echo $row["prosesid"]?>" />
    <input type="hidden" name="type" value="<?php echo $row["type"]?>" />
	<tr>
    	<td><?php echo $row["Proses"]?></td>
        <td><?php echo $row["type"]?></td>
    	<td style="text-align:center"><input type="checkbox" onclick="settime<?php echo $i?>();" name="chk<?php echo $i?>" id="chk<?php echo $i?>" /></td>
        <td style="text-align:center"><input type="number" onchange="settime<?php echo $i?>();" name="time<?php echo $i?>" id="time<?php echo $i?>" value="10" style="width:40px" /></td>
        <td style="text-align:right"><?php echo number_format($row["target"])?></td>
        <td style="text-align:right"><div id="hasil<?php echo $i?>"></div></td>
        <td></td>
    </tr>
    </form>
	<script>
	var timer<?php echo $i?>;
	function settime<?php echo $i?>()
	{	
		var time = document.getElementById("time<?php echo $i?>").value;
		var chk = document.getElementById("chk<?php echo $i?>").checked;
		if(chk)
		{
			clearInterval(timer<?php echo $i?>);
			timer<?php echo $i?> = setInterval(function(){runing<?php echo $i?>();}, (time*1000));
		}
		else
		{
			clearInterval(timer<?php echo $i?>);
		}
	}
    function runing<?php echo $i?>()
    {
		var formData = new FormData(document.getElementById("form<?php echo $i?>"));
		$.ajax(
		{
			url:'runing.php',
			type: 'POST',
			data: formData,
			contentType: false,
			enctype: 'multipart/form-data',
			processData: false,
			beforeSend:function()
			{
				//document.getElementById("hasil<?php echo $i?>").innerHTML = "loading...";
			},
			complete:function()
			{
				//document.getElementById("loading"+id).style.display = "none";
			},
			success:function(result)
			{
				document.getElementById("hasil<?php echo $i?>").innerHTML = result;
			}
		});
    }
	</script>
<?php $i++;}?>
</table>
