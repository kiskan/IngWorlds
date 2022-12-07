<?php
include('header.php');

$periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');

$area = 'carga inicial';
include('consultas/ges_crud_areas.php');
?>

<script type="text/javascript">
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	var numeroSemana = <?php echo date("W"); ?>;
</script>

<script type="text/javascript" src="js/plan_orden.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Gestión Orden Planificaciones</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_planxorden" data-parsley-validate class="form-horizontal form-label-left">					
					
						<input type="hidden" id="activ_id" value="" />

						<div class="form-group">
							<label class="col-sm-12">PLANIFICACION (<span id="sem_txt"></span>)</label>
							<div class="col-sm-2">
								<select multiple class="form-control" tabindex="-1" id="plan_dia" disabled></select>								
								<div class="help">Día</div>
							</div>		

							<div class="col-sm-2">							
								<input type="text" id="oper_rut" class="form-control" disabled>							
								<div class="help">Rut Operador</div>
							</div>	
							
							<div class="col-sm-6">							
								<input type="text" id="oper_nombre" class="form-control" disabled>							
								<div class="help">Operador</div>
							</div>								
						</div>			
						
						<div class="ln_solid"></div>
						<div class="clearfix"></div>
						
						<div class="form-group">
							<label class="col-sm-12">ACTIVIDAD DE PLANIFICACION</label>
							<div class="col-sm-3">
								<input type="text" id="area1" class="form-control" disabled>								
								<div class="help">Area</div>
							</div>
							<div class="col-sm-4">
								<input type="text" id="sup1" class="form-control" disabled>							
								<div class="help">Supervisor</div>
							</div>
							<div class="col-sm-5">
								<input type="text" id="activ1" class="form-control" disabled>								
								<div class="help">Actividad</div>
							</div>							
						</div>						

						<div class="form-group">

							<div class="col-sm-2">
								<input type="text" id="horas1" class="form-control" disabled>								
								<div class="help">Hrs. Asignadas</div>
							</div>
							<div class="col-sm-2">
								<input type="text" id="orden1" class="form-control" value="1era Actividad" disabled>	
								<div class="help">Orden Asignación</div>
							</div>
							
							<div class="col-sm-2">
								<input type="text" id="hr_ini1" class="form-control" value ="" disabled>								
								<div class="help">Hr. Inicio</div>
							</div>		
							
							<div class="col-sm-2">
								<input type="text" id="hr_fin1" class="form-control" value ="" disabled>								
								<div class="help">Hr. Término</div>
							</div>							
							
						</div>							
						
						
						<div class="ln_solid"></div>
						<div class="clearfix"></div>
						


						<div class="form-group">
							<label class="col-sm-12">ACTIVIDAD DE PLANIFICACION</label>
							<div class="col-sm-3">
								<input type="text" id="area2" class="form-control" disabled>								
								<div class="help">Area</div>
							</div>
							<div class="col-sm-4">
								<input type="text" id="sup2" class="form-control" disabled>							
								<div class="help">Supervisor</div>
							</div>
							<div class="col-sm-5">
								<input type="text" id="activ2" class="form-control" disabled>								
								<div class="help">Actividad</div>
							</div>							
						</div>						

						<div class="form-group">

							<div class="col-sm-2">
								<input type="text" id="horas2" class="form-control" disabled>								
								<div class="help">Hrs. Asignadas</div>
							</div>
							<div class="col-sm-2">
								<input type="text" id="orden2" class="form-control" value="2da Actividad" disabled>	
								<div class="help">Orden Asignación</div>
							</div>
							
							<div class="col-sm-2">
								<input type="text" id="hr_ini2" class="form-control" value ="" disabled>								
								<div class="help">Hr. Inicio</div>
							</div>		
							
							<div class="col-sm-2">
								<input type="text" id="hr_fin2" class="form-control" value ="" disabled>								
								<div class="help">Hr. Término</div>
							</div>							
							
						</div>
												
						<div class="ln_solid"></div>

						<div class="form-group">
							
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_cambiar_orden" type="button" class="btn btn-success" disabled>Cambiar Orden</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>
					</form>	
						
						<div class="clearfix"></div>
						<br><br>
					<div class="form-group">
						<label class="col-sm-12">SEMANA DE PLANIFICACION</label>
						<div class="col-sm-2">
							<select class="select2_single form-control" tabindex="-1" id="per_agno">	
							</select>								
							<div class="help">Año</div>
						</div>
						<div class="col-sm-4">
							<select class="select2_single form-control" tabindex="-1" id="sem_num">	
							</select>								
							<div class="help">Semana</div>
						</div>							
					</div>							
						

							<div class="x_panel">
								<div class="x_title">
									<h2>Operadores con 2 actividades en el mismo día</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">

									<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>Area1</th>
												<th>Activ1</th>
												<th>Sup1</th>
												<th>Horas1</th>
												<th>Area2</th>
												<th>Activ2</th>
												<th>Sup2</th>
												<th>Horas2</th>
												<th>RUT Oper</th>
												<th>Día</th>
												<th>Operador</th>
												<th>Actividades</th>
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