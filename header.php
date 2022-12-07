<?php
	session_start();
	if(!isset($_SESSION['USR_NOMBRE'])) include('cerrar_sesion.php'); //header('Location:login.php');
	$rut_supervisor = ($_SESSION['USR_TIPO'] == 'SUPERVISOR') ? $_SESSION['USR_RUT'] : "" ;
	
	$date = new DateTime;
	$date->setISODate(date('Y'), date('W'));
	$mes_actual = $date->format("m");	
	
	?>

<!DOCTYPE html>
<html lang="en">
  <head>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	  <meta name="google" content="notranslate" />
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" sizes="192x192" href="logo1_trans.ico">
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
	
    <!-- Datatables 
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">	
--><link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
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
	<script src="js/moment/es.js"></script>
	<script src="js/datepicker/daterangepicker.js"></script>

	
    <!-- Select2 -->
    <script src="../vendors/select2/dist/js/select2.full.min.js"></script>  
  
    <!-- Datatables 
	
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
	-->
	

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/fh-3.1.3/r-2.2.1/sc-1.4.3/datatables.min.css"/>
<!--
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
-->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/fh-3.1.3/r-2.2.1/sc-1.4.3/datatables.min.js"></script>	
	
	
	
	
	
	
	
	
	
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
	var month_current = "<?php echo $mes_actual; ?>";
	
	//var year_current = "2020";
	//var month_current = "01";	
	
	var week_current = "<?php echo date('W'); ?>";
	var date_current = "<?php echo date('Ymd'); ?>";
	
	var fecha_actual_picker = "<?php echo date('d-m-Y'); ?>";
	
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
				
				<?php if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR'){ ?>
				
                  <li><a><i class="fa fa-line-chart"></i>Gestión Producción<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					    <!-- Meta, title, CSS, favicons, etc. -->
                      <li><a href="#" id="ges_periodo">Apertura Periodo</a></li>
					  <li><a href="ges_viveros.php">Ingresar Unidad Viveros</a></li>
					  <li><a href="ges_jefevivero.php">Ingresar Jefe Unidad Vivero</a></li>					  
					  <li><a href="ges_areas.php">Ingresar Areas</a></li>
					  <li><a href="ges_unidades.php">Ingresar Unidad Medidas</a></li>
                      <li><a href="ges_actividades.php">Ingresar Actividades</a></li>
                      <li><a href="ges_metasxhora.php">Ingresar Metas x Hora</a></li>
                      <li><a href="ges_usuarios.php">Ingresar Usuarios</a></li>
                      <li><a href="ges_operadores.php">Ingresar Operadores</a></li>
					  <li><a href="ges_competencias.php">Ingresar Competencias</a></li>
					  <li><a href="ges_supervisores.php">Ingresar Supervisores</a></li>	
					  <li><a href="ges_parmes.php">Parámetros Mensuales</a></li>
					  <li><a href="ges_diasnoprod.php">Días No Productivos</a></li>
					  <li><a href="ges_diasferiados.php">Días Feriados</a></li>

                    </ul>
                  </li>
				  
				<?php } if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR'){ ?>
				
                  <li><a><i class="fa fa-briefcase"></i>Gestión Actividades<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					  <li><a href="ges_famactividades.php">Ingresar Familia Actividad</a></li>
					  <li><a href="ges_sfamactividades.php">Ingresar SubFamilia Actividad</a></li>
					  <li><a href="ges_pactividades.php">Ingresar Actividad Padre</a></li>
					  <li><a href="ges_tipoactividades.php">Ingresar Tipo Actividad</a></li>
					  <li><a href="ges_clasactividades.php">Ingresar Clasificación Actividad</a></li>

                    </ul>
                  </li>				  
				  
				  
				<?php } 
					if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'PLANIFICADOR'){
				?>  
                  <li><a><i class="fa fa-calendar"></i>Planificación Semanal<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
						<li><a href="plan_maestro.php">Ingresar Plan Maestro</a></li>
						<li><a href="plan_semana.php">Ingresar Planificación</a></li>
						<li><a href="plan_orden.php">Orden Planificaciones</a></li>
                        <li><a href="plan_visor.php">Ver Planificaciones</a></li>
						<li><a href="plan_solicitud.php">Solicitudes</a></li>
						<li><a href="rplan_semana.php">Ingresar RE-Planificación</a></li>						
                    </ul>					
                  </li>						  
				<?php } 
					if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' /*OR $_SESSION['USR_TIPO'] == 'SUPERVISOR'*/){
				?>  			
 
                  <li><a><i class="fa fa-leaf"></i>Plantas Madres<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
						<li><a href="planta_clones.php">Ingresar Clones</a></li>
						<li><a href="planta_gestion.php">Gestión Plantas Madres</a></li>
						<li><a href="planta_plano.php">Plano Plantas Madres</a></li>
                    </ul>					
                  </li>		
				<?php } 
					if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'ENCARGADO PRODUCCION' OR $_SESSION['USR_TIPO'] == 'ENCARGADO RIEGO' OR $_SESSION['USR_TIPO'] == 'CONTROL AGUA'){
				?>  
                  <li><a><i class="fa fa-pagelines"></i>Módulo Fertilización<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">	
				<?php if ($_SESSION['USR_TIPO'] != 'ENCARGADO RIEGO'){ ?> 
					  <li><a href="fer_aguas.php">Control Aguas</a></li>	
				<?php } ?> 
				<?php //if ($_SESSION['USR_TIPO'] != 'CONTROL AGUA'){ ?> 
                      <li><a href="fer_control.php">Control Fertilización</a></li>
				<?php //} ?> 				
				<?php if ($_SESSION['USR_TIPO'] != 'CONTROL AGUA' AND $_SESSION['USR_TIPO'] != 'ENCARGADO RIEGO'){ ?> 
					  <li><a href="cmfertilizacion.php">Monitoreo Fertilización</a></li>
					  <li><a href="fer_informe.php">Informe Fertilización</a></li>
					  <li><a href="fer_parametros.php">Parámetros Fertilización</a></li>
				<?php } ?> 
                    </ul>					
                  </li>				  
				  
				<?php } 
					if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'SUPERVISOR'){
				?>  				

                  <li><a><i class="fa fa-clock-o"></i>Módulo Supervisor<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="sup_actividades.php">Control Actividades</a></li>
					  <li><a href="plan_visor.php">Ver Planificaciones</a></li>
					  <li><a href="sup_solicitud.php">Solicitud Actividad</a></li>
					  <li><a href="sup_asignacion.php">Asignación Actividades Extra</a></li>
                    </ul>					
                  </li>
				<?php } 
					if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'PLANIFICADOR'){
				?>  			  
                  <li><a><i class="fa fa-print"></i>Informes<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					<!--
                      <li><a href="irend_planif.php">Rendimiento Planificación</a></li>
                      <li><a href="irend_activ.php">Rendimiento Actividad</a></li>
					-->
						<li><a href="inf_diario.php">Informe Diario</a></li>
						<li><a href="inf_semanal.php">Informe Semanal</a></li>
						<li><a href="inf_planmaestro.php">Informe Plan Maestro</a></li>
						<li><a href="inf_timedead.php">Informe Tiempos Muertos</a></li>
                    </ul>
                  </li>

                  <li><a><i class="fa fa-search"></i>Consultas<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
						<li><a href="cmonitoreo.php">Monitoreo Producción</a></li>
						<li><a href="cprodxactiv.php">Producción x Actividad</a></li>
						<li><a href="casistencia.php">Monitoreo Asistencia</a></li>
						<li><a href="cmrendimiento.php">Monitoreo Rendimiento</a></li>
						<li><a href="cplanmaestro.php">Monitoreo Plan Maestro</a></li>
						<li><a href="cprodcosecha.php">Monitoreo Cosecha</a></li>
						<li><a href="cprodinstalacion.php">Monitoreo Instalación</a></li>
						<!--
						<li><a href="cplanif_ejec.php">Planificado vs Ejecutado</a></li>
						<li><a href="cind_cambios.php">Indices Cambios</a></li>
						<li><a href="cjorn_hrstrab.php">Jornadas vs Hrs Trabajadas</a></li>
						<li><a href="cdif_prod.php">Diferencial Producción</a></li>
						<li><a href="crend_pers.php">Rendimiento Persona</a></li>
						<li><a href="crend_activ.php">Rendimiento Actividad</a></li>
						<li><a href="crank_trab.php">Ranking Trabajadores</a></li>
						<li><a href="ccosto_serv.php">Costos Servicios</a></li>
						-->
                    </ul>
                  </li>
	
				
				<?php } 
					if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'SECRETARIA'){
				?>  				
                  <li><a><i class="fa fa-print"></i>Módulo Secretaria<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
						<li><a href="secre_listado.php">Listado operadores</a></li>
						<li><a href="secre_horatope.php">Hora tope</a></li>
						<li><a href="secre_responsables.php">Responsables FDS</a></li>
						<li><a href="secre_informe.php">Informe Actividades Extras</a></li>
                    </ul>
                  </li>				
				<?php } 
				if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'SUPERVISOR' OR $_SESSION['USR_TIPO'] == 'JEFE UNIDAD' OR $_SESSION['USR_TIPO'] == 'ENCARGADO BODEGA' OR $_SESSION['USR_TIPO'] == 'JEFE BODEGA' OR $_SESSION['USR_TIPO'] == 'SECRETARIA'){
				?> 					
								
				   <li><a><i class="fa fa-cubes"></i>Módulo Bodega<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					<?php if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'JEFE BODEGA'){ ?> 	
						<li><a href="bod_catproducto.php">Categoría Materiales</a></li>						
						<li><a href="bod_producto.php">Crear Materiales</a></li>
					<?php } ?> 
					<?php if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'JEFE BODEGA' OR $_SESSION['USR_TIPO'] == 'ENCARGADO BODEGA' OR $_SESSION['USR_TIPO'] == 'JEFE UNIDAD'){ ?> 
						<li><a href="bod_stock.php">Control Stock</a></li>		
					<?php } ?> 
					<?php if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'JEFE BODEGA' OR $_SESSION['USR_TIPO'] == 'SUPERVISOR' OR $_SESSION['USR_TIPO'] == 'JEFE UNIDAD' OR $_SESSION['USR_TIPO'] == 'SECRETARIA'){ ?> 
						<li><a href="bod_solprod.php">Solicitud Materiales</a></li>
					<?php } ?> 
					<?php if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'JEFE BODEGA' OR $_SESSION['USR_TIPO'] == 'ENCARGADO BODEGA'){ ?> 
						<li><a href="bod_retprod.php">Retiro Materiales</a></li>
					<?php } ?> 
					<?php if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'JEFE BODEGA' OR $_SESSION['USR_TIPO'] == 'JEFE UNIDAD'){ ?> 
						<li><a href="bod_solcompra.php">Solicitud Compra</a></li>
					<?php } ?> 
					<?php if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'JEFE BODEGA'){ ?> 
						<li><a href="bod_recepcompra.php">Recepción Compra</a></li>
					<?php } ?> 
					<?php if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'JEFE BODEGA' OR $_SESSION['USR_TIPO'] == 'JEFE UNIDAD'){ ?>
						<li><a href="bod_cons_solic.php">Monitoreo Solicitudes</a></li>
						<li><a href="bod_cons_compra.php">Monitoreo Compras</a></li>
						<li><a href="bod_cons_gastos.php">Control de Gastos</a></li>
						<li><a href="bod_cons_tcompra.php">Tiempos Compras</a></li>
					<?php } ?> 
                    </ul>
                  </li>	
				<?php } 
					if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR' OR $_SESSION['USR_TIPO'] == 'OPERADOR MAQUINA'){
				?>  				
                  <li><a><i class="fa fa-battery-quarter"></i>Tiempos Muertos<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
						<li><a href="timedead_linea.php">Líneas Productivas</a></li>
						<li><a href="timedead_metas.php">Líneas Metas</a></li>
						<li><a href="timedead_ctrmaq.php">Líneas Control Maquinaria</a></li>
						<li><a href="timedead_causas.php">Causas Tiempos Muertos</a></li>
						<li><a href="timedead_gestion.php">Gestión Tiempos Muertos</a></li>
                    </ul>
                  </li>				
				<?php } 			
				?> 
				
                </ul>
              </div>
			  
      
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">

              <a href="cerrar_sesion.php" data-toggle="tooltip" data-placement="top" title="Logout">
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
					<li><a href="perfil.php"><i class="fa fa-book pull-right"></i> Editar perfil</a></li>
                    <li><a href="index_manual.php"><i class="fa fa-book pull-right"></i> Manual usuario</a></li>
                    <li><a href="cerrar_sesion.php"><i class="fa fa-sign-out pull-right"></i> Cerrar sesión</a></li>
                  </ul>
                </li>

              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->