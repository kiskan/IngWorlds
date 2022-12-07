<?php
include('header.php');
$periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
?>

<script type="text/javascript">
	var data_periodos = <?php echo $load_periodos; ?>;
</script>


<script type="text/javascript" src="js/cmonitoreo.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Monitoreo Producción</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_planvisor" data-parsley-validate class="form-horizontal">	
						<div class="form-group">

							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="per_agno"></select>								
								<div class="help">Año</div>
							</div>
							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="per_mes">
								<option value="">TODOS</option>
								<option value="01">Enero</option>
								<option value="02">Febrero</option>
								<option value="03">Marzo</option>
								<option value="04">Abril</option>
								<option value="05">Mayo</option>
								<option value="06">Junio</option>
								<option value="07">Julio</option>
								<option value="08">Agosto</option>
								<option value="09">Septiembre</option>
								<option value="10">Octubre</option>
								<option value="11">Noviembre</option>
								<option value="12">Diciembre</option>
								</select>								
								<div class="help">Mes</div>
							</div>
							
							<div class="col-sm-4">
								<select class="select2_single form-control" tabindex="-1" id="sem_num">	
									<option value="" selected>TODAS</option>
								</select>								
								<div class="help">Semana</div>
							</div>							

							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="per_dia">
									<option value="" selected>TODOS</option>
								</select>								
								<div class="help">Día</div>
							</div>	

							<div class="col-sm-2"><button id="btn_monitoreo" type="button" class="btn btn-success">Consultar</button></div>							
						
						</div>
						
						<div class="form-group">
						<!--
							<div class="col-sm-3">
								<select class="select2_single form-control" tabindex="-1" id="area_id" disabled >	
									<option value="" selected>TODAS</option>
								</select>								
								<div class="help">Area</div>
							</div>
						-->
							<div class="col-sm-4">
								<select class="select2_single form-control" tabindex="-1" id="sup_rut" >
									<option value="" selected>TODOS</option>
								</select>								
								<div class="help">Supervisor</div>
							</div>	
							<div class="col-sm-8">
								<select class="select2_single form-control" tabindex="-1" id="activ_id" >	
									<option value="" selected>TODAS</option>
								</select>								
								<div class="help">Actividad Planificada</div>
							</div>
						
						</div>	
						<!--
						<div class="form-group">
						
							<div class="col-sm-3">
								<select class="select2_single form-control" tabindex="-1" id="prod_oper" disabled >
									<option value="" selected>TODOS</option>
									<option value="" >ProdxHr > MetaxHr</option>
									<option value="" >ProdxHr < MetaxHr</option>
									<option value="" >ProdxHr = MetaxHr</option>
								</select>								
								<div class="help">Rendimiento Operador</div>
							</div>
							
							<div class="col-sm-4">
								<select class="select2_single form-control" tabindex="-1" id="oper_rut" disabled  >
									<option value="" selected>TODOS</option>
								</select>								
								<div class="help">Operador</div>
							</div>							
							
						</div>	
						-->

					</form>

					<div class="clearfix"></div>
					<br><br>
					
					<div class="x_panel">
						<div class="x_title">
							<h2>Resultado Consulta</h2>

							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">

							<!--<table id="datatable-scroll" class="table-striped table-bordered nowrap order-column" style="width:100%">
							<table id="datatable-scroll" class="stripe row-border order-column nowrap" style="width:100%">-->
							<table id="datatable-scroll" class="table-striped table-bordered nowrap" style="width:100%">
								<thead>
									<tr>	
										<th>Fecha</th>
										<th>Año</th>											
										<th>Mes</th>
										<th>Semana</th>
										<th>Último Registro</th>											
										<th>Nombre</th>
										<th>Apellido Paterno</th>
										<th>Apellido Materno</th>
										<th>Actividad</th>
										<th>Producción</th>
										<th>Unidad</th>
										<th>Hr Asignadas</th>
										<th>Hr Productivas</th>										
										<th>Productividad</th>
										<th>Hr Descto</th>										
										<th>Meta</th>
										<th>Cumplimiento</th>
										<th>Area</th>
										<th>Supervisor</th>
										<th>Asistencia</th>
										<th>Observación</th>
										<th>Familia</th>
										<th>SubFamilia</th>
										<th>Actividad Padre</th>
										<th>Tipo Actividad</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>	
					
				</div>
			</div>
		</div>
	</div>	
</div>
<!-- /page content -->

<?php
include('footer.php');
?>