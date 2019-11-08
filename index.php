<?php
session_start();

include_once "sqlLib.php"; $sqlLib = new sqlLib();
if(!isset($_SESSION["userid"]) OR  !isset($_SESSION["nama"])) 
{
	if($_COOKIE["userid"]!="" AND $_COOKIE["nama"]!="")
	{
		$_SESSION["userid"] = $_COOKIE["userid"];
		$_SESSION["nama"] = $_COOKIE["nama"];
		$_SESSION["nik"] = $_COOKIE["nik"];
		$_SESSION["shift"] = $_COOKIE["shift"];
		$_SESSION["posisi"] = $_COOKIE["posisi"];
		$_SESSION["admin"] = $_COOKIE["admin"];
    $_SESSION["areaid"] = $_COOKIE["areaid"];
	}
	else header("Location:signin.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SMI</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

   <!-- Datatables --> 
    <link href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">-->
  
  	<!-- jQuery 3 -->
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="bower_components/select2/dist/js/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/input-mask/jquery.inputmask.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="bower_components/moment/min/moment.min.js"></script>
    <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap datepicker -->
    <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- bootstrap color picker -->
    <script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- SlimScroll -->
    <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
	
</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SMI</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b></b> SMARTSEAL</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="dist/img/avatar.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION["nama"]?> </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/avatar.png" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION["nama"]?>
                </p>
                
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="index.php?m=cp" class="btn btn-default btn-flat">Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="signout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li <?php if($_GET["m"]==""){ echo 'class="active"';}?>>
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li <?php if($_GET["m"]=="segel"){ echo 'class="active"';}?>>
            <a href="index.php?m=segel">
              <i class="fa fa-folder"></i><span>Data Segel</span>
            </a>
        </li>

        <li <?php if($_GET["m"]=="area"){ echo 'class="active"';}?>>
            <a href="index.php?m=area">
              <i class="fa fa-folder"></i><span>Data area</span>
            </a>
        </li>

        <li <?php if($_GET["m"]=="penerimaan"){ echo 'class="active"';}?>>
            <a href="index.php?m=penerimaan">
              <i class="fa fa-folder"></i><span>Penerimaan Segel</span>
            </a>
        </li>

        <li <?php if($_GET["m"]=="pengambilan"){ echo 'class="active"';}?>>
            <a href="index.php?m=pengambilan">
              <i class="fa fa-folder"></i><span>Pengambilan Segel</span>
            </a>
        </li>

        <li <?php if($_GET["m"]=="pemakaian"){ echo 'class="active"';}?>>
            <a href="index.php?m=pemakaian">
              <i class="fa fa-folder"></i><span>Pemakaian Segel</span>
            </a>
        </li>

        <li <?php if($_GET["m"]=="transaksi"){ echo 'class="active"';}?>>
            <a href="index.php?m=transaksi">
              <i class="fa fa-folder"></i><span>Data Transaksi</span>
            </a>
        </li>

        <li <?php if($_GET["m"]=="stock"){ echo 'class="active"';}?>>
            <a href="index.php?m=stock">
              <i class="fa fa-folder"></i><span>Stock</span>
            </a>
        </li>
        
       <!--  <li <?php if($_GET["m"]=="project"){ echo 'class="active"';}?>>
            <a href="index.php?m=project">
              <i class="fa fa-folder"></i><span>Project</span>
            </a>
        </li>
		
    		<li <?php if($_GET["m"]=="listtugas"){ echo 'class="active"';}?>>
                <a href="index.php?m=listtugas">
                  <i class="fa fa-book"></i><span>Tugas</span>
                </a>
            </li>
    		
    		<li <?php if($_GET["m"]=="gant"){ echo 'class="active"';}?>>
                <a href="index.php?m=gant">
                  <i class="fa fa-bar-chart"></i><span>GanttChart</span>
                </a>
            </li>
    		
    		<li <?php if($_GET["m"]=="calendar"){ echo 'class="active"';}?>>
            <a href="index.php?m=calendar">
              <i class="fa fa-calendar"></i><span>Calendar</span>
            </a>
        </li> -->
        
        <?php
         if($_SESSION["admin"]=="1")
          {?>
                  <li <?php if($_GET["m"]=="user"){ echo 'class="active"';}?>>
                    <a href="index.php?m=user">
                    <i class="fa fa-user"></i><span>User</span>
                    </a>
                  </li>

                  
          <?php }?>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
	
	<div class="content-wrapper">
		<!-- Main content -->
		<section class="content">
		<div class="box-body">
		<?php 
		if($_GET["m"]=="")// $_GET["m"]="dashboard";
			include "master/dashboard/index.php";
			else if ($_GET["m"]!=="")
			include "master/".$_GET["m"]."/index.php";
		?>
		</div>
		</section>
	</div>
</div>
<!-- ./wrapper -->
<script type="text/javascript">
$(function () {
//Date picker
	$('.tgl').datepicker({
		format: 'dd-M-yyyy',
		autoclose: true
	})
})</script>
</body>
</html>
