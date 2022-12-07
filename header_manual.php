<?php
	session_start();
	if(!isset($_SESSION['USR_NOMBRE'])) header('Location:login.php');
	$rut_supervisor = ($_SESSION['USR_TIPO'] == 'SUPERVISOR') ? $_SESSION['USR_RUT'] : "" ;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ings-Sisconvi-Production | Ings-Worlds</title>

<!-- CSS -->

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
	
    <!-- Select2-->	
    <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet"> 
	
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">	

    <!-- Sweetalert -->
    <link href="../vendors/sweetalert/sweetalert.css" rel="stylesheet">	
	
	
    <!-- iCheck
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet"> -->

    <!-- css personalizado -->
    <link href="../vendors/personalizado/personalizado.css" rel="stylesheet">

<!-- JAVASCRIPT -->

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
	
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Sweetalert -->
	<script src="../vendors/sweetalert/sweetalert.min.js"></script>
	
 <!--	 
	<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
 	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />	
-->
	<!-- DateRangepicker -->
	<script src="js/moment/moment.min.js"></script>
    <script src="js/datepicker/daterangepicker.js"></script>
	
    <!-- Select2 -->
    <script src="../vendors/select2/dist/js/select2.full.min.js"></script>  
  
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
	
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
	
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
	<script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
	<!-- Apertura Periodo -->
	<script src="js/ges_periodo.js"></script>
 <!--	
    <script src="../vendors/datatables.net-fixedcolumn/dataTables.fixedColumns.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>  -->
	
  <!-- iCheck 
    <script src="../vendors/iCheck/icheck.min.js"></script> 
-->

<script type="text/javascript">

	var rut_supervisor = "<?php echo $rut_supervisor; ?>";
	var tipo_usuario = "<?php echo $_SESSION['USR_TIPO']; ?>";
	var year_current = "<?php echo date('Y'); ?>";
	var month_current = "<?php echo date('m'); ?>";
	var week_current = "<?php echo date('W'); ?>";
	var date_current = "<?php echo date('Ymd'); ?>";
	
	jQuery.extend( jQuery.fn.dataTableExt.oSort, {
		"numeric-comma-pre": function ( a ) {
			var x = (a == "-") ? 0 : a.replace( /,/, "." );
			return parseFloat( x );
		},

		"numeric-comma-asc": function ( a, b ) {
			return ((a < b) ? -1 : ((a > b) ? 1 : 0));
		},

		"numeric-comma-desc": function ( a, b ) {
			return ((a < b) ? 1 : ((a > b) ? -1 : 0));
		},

		"date-br-pre": function ( a ) {
			if (a == null || a == "") {
			return 0;
			}
			var brDatea = a.split('-');
			return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
		},

		"date-br-asc": function ( a, b ) {
			return ((a < b) ? -1 : ((a > b) ? 1 : 0));
		},

		"date-br-desc": function ( a, b ) {
			return ((a < b) ? 1 : ((a > b) ? -1 : 0));
		}
	} );

</script>

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
		  <!--
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php" class="site_title"><i class="fa fa-bar-chart-o"></i> <span>Sotrosur</span></a>
            </div>
	-->
            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="images/logosotrosur.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenid@,</span>
                <h2><?php echo $_SESSION['USR_TIPO']; ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
				<div class="clearfix"></div>
                <br>
                <ul class="nav side-menu">
				
				<?php if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'SUPERVISOR' OR $_SESSION['USR_TIPO'] == 'PLANIFICADOR'){ ?>
				
                  <li><a><i class="fa fa-video-camera"></i>ULTIMOS TUTORIALES<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="eliminacion_liberacion.php">Eliminación y Liberación de Operadores</a></li>
					  <li><a href="nuevos_requerimientos.php">Nuevos Requerimientos</a></li>
					  	
                    </ul>
                  </li>
				<?php } ?>  
                
                </ul>
              </div>
			  
      
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">

              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php if ($_SESSION['USR_SEXO'] == 'F'){ ?>
						<img src="images/mujer.png" alt="">
					<?php } else { ?>
						<img src="images/hombre.png" alt="">
					<?php } echo $_SESSION['USR_NOMBRE']; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
				    <li><a href="index.php"><i class="fa fa-book pull-right"></i> Volver a SISCONVI</a></li>
					<li><a href="perfil.php"><i class="fa fa-book pull-right"></i> Editar perfil</a></li>
					<li><a href="cerrar_sesion.php"><i class="fa fa-sign-out pull-right"></i> Cerrar sesión</a></li>
                  </ul>
                </li>

              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->