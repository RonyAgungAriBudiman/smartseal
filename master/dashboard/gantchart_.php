<?php
if($_POST["dari"] == "") $_POST["dari"] = date("01-M-Y");
if($_POST["sampai"] == "") $_POST["sampai"] = date("t-M-Y", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "+2 month" ) );
?>
<div class="row" style="min-height:90px; margin-bottom:10px">
	<form method="post">
	<div class="col-md-12">
		<div class="col-md-2"><label>Periode</label></div>
		<div class="col-md-4">
			<div class="form-group">
				<div class="input-group date">
					  <div class="input-group-addon"><i class="fa fa-calendar"></i>
					  </div>
					  <input type="text" class="form-control pull-right tgl" id="dari" name="dari" value="<?php echo $_POST["dari"]?>"  style="text-align:center">
				</div>
			</div>
		</div>
		<div class="col-md-2"><label>sampai</label></div>
		<div class="col-md-4">
			<div class="form-group">
				<div class="input-group date">
					  <div class="input-group-addon"><i class="fa fa-calendar"></i>
					  </div>
					  <input type="text" class="form-control pull-right tgl" id="sampai" name="sampai" value="<?php echo $_POST["sampai"]?>"  style="text-align:center">
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<button type="submit"><i class="fa fa-search" aria-hidden="true"></i> search</button>
			<button type="button" onclick="zoomIn()"><i class="fa fa-search-plus" aria-hidden="true"></i> zoom in</button>
			<button type="button" onclick="zoomOut();"><i class="fa fa-search-minus" aria-hidden="true"></i> zoom out</button>
		</div>
	</div>
	</form>
</div>

<?php
$tugas2 = "";
$sql = "SELECT DISTINCT(a.TugasID) as TugasID, a.ProjectID, a.ParentID, a.Subject, a.Keterangan, a.Dari, a.Sampai, a.Progress 
		FROM ms_tugas a 
		LEFT JOIN ms_project_anggota b ON b.ProjectID = a.ProjectID 
		WHERE Closed = '0' AND (b.UserID = '".$_SESSION["userid"]."' OR '".$_SESSION["admin"]."' = '1' ) ORDER BY a.Dari ASC";
$data =$sqlLib->select($sql);
foreach($data as $row)
{	
	$sql_pers ="SELECT COUNT(TugasID) as Jml, SUM(Progress) as Progress FROM ms_tugas WHERE ParentID = '".$row["ProjectID"]."' AND Closed = '0'" ;
	$data_pers =$sqlLib->select($sql_pers);		
	if($data_pers[0]["Jml"] > 0) $row["Progress"] = ($data_pers[0]["Progress"]/$data_pers[0]["Jml"]);
	
	$tugas2 .= "{
					id  			: '".$row["TugasID"]."', ";
	if($row["ParentID"] > 0) $tugas2 .="parent		: '".$row["ParentID"]."',";
	$tugas2 .=" 	name          	: '".$row["Subject"]."',
					actualStart   	: '".$row["Dari"]."',
					actualEnd     	: '".$row["Sampai"]."',
					progressValue	: '".$row["Progress"]."%', ";
	if(count($data_sub)>0) $tugas2 .= "]";
    $tugas2 .= "},";
}

?>
<link href="https://playground.anychart.com/docs/samples/GANTT_Quick_Start_Project/iframe" rel="canonical">
  <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
  <link href="https://cdn.anychart.com/releases/8.7.0/css/anychart-ui.min.css?hcode=a0c21fc77e1449cc86299c5faa067dc4" rel="stylesheet" type="text/css">
  <style>#container {
    width: 100%;
    height: 560px;
    margin: 0;
    padding: 0;
}
.anychart-credits{
	display:none;
}
</style>

  <div id="container"></div>
  <script src="https://cdn.anychart.com/releases/8.7.0/js/anychart-base.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
  <script src="https://cdn.anychart.com/releases/8.7.0/js/anychart-gantt.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
  <script src="https://cdn.anychart.com/releases/8.7.0/js/anychart-exports.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
  <script src="https://cdn.anychart.com/releases/8.7.0/js/anychart-ui.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
  <script type="text/javascript">
  var chart;

	function zoomIn() {

		// Set zoom for the chart.
		chart.zoomIn(1.5);
	}

	function zoomOut() {

		// Set zoom out for the chart.
		chart.zoomOut(4);
	}
  
	anychart.onDocumentReady(function () {
		var data = getData();
		chart = anychart.ganttProject();
		chart.data(data, 'as-table');
		chart.splitterPosition(223);
		chart.container('container');
		chart.getTimeline().scale().minimum(<?php echo "'".date("Y-m-d",strtotime($_POST["dari"]))."'";?>);
		chart.getTimeline().scale().maximum(<?php echo "'".date("Y-m-d",strtotime($_POST["sampai"]))."'";?>);
		chart.draw();
		chart.fitAll();
	});
	
	function getData() {
    return [<?php echo $tugas2?>];
}
  
 </script>