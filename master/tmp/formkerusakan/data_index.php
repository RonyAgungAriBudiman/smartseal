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
    	<label for="produkid">INDEX</label>
            <select class="form-control" id="indexing" name="indexing">
                <option value=""></option>
                    <?php
                        $sql = "SELECT a.Indexing FROM ms_index_maintenance a
                                WHERE a.Indexing != '' AND a.Status ='good'  AND a.KategoriID ='".$_POST['unit']."' AND a.KodeLokasi ='".$_POST['lokasi']."'  ORDER BY a.Indexing asc";
                        $data = $sqlLib->select($sql);
                        foreach($data as $row)
                        {?>
                            <option value="<?php echo $row["Indexing"]?>" 
                            <?php if($_POST["indexing"]==$row["Indexing"]){ echo "selected";}?>><?php echo $row["Indexing"]?></option>
                        <?php }?>
            </select>        
   
        