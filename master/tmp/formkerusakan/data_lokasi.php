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
    }
    else header("Location:../../signin.php");
} ?>
    	<label for="produkid">LOKASI</label>
            <select class="form-control" id="lokasi" name="lokasi">
                <option value=""></option>
                    <?php
                        $sql = "SELECT DISTINCT a.KodeLokasi, b.Lokasi FROM ms_index_maintenance a
                                LEFT JOIN ms_lokasi_index b on b.Kode = a.KodeLokasi
                                WHERE a.KodeLokasi != '' AND a.Status ='good'  AND a.KategoriID ='".$_POST['unit']."'  ORDER BY b.Lokasi asc";
                        $data = $sqlLib->select($sql);
                        foreach($data as $row)
                        {?>
                            <option value="<?php echo $row["KodeLokasi"]?>" 
                            <?php if($_POST["lokasi"]==$row["KodeLokasi"]){ echo "selected";}?>><?php echo $row["Lokasi"]?></option>
                        <?php }?>
            </select>        
   
        