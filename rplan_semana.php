<?php
include('header.php');

$periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');

$area = 'carga inicial';
include('consultas/ges_crud_areas.php');
?>

<script type="text/javascript">
	var data_areas = <?php echo $load_areas; ?>;
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	var numeroSemana = <?php echo date("W"); ?>;
	var agno_actual = <?php echo date("Y"); ?>;
</script>

<script type="text/javascript" src="js/rplan_semana.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>RE-Planificación Semanal</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_planxsemana" data-parsley-validate class="form-horizontal">	
						
						<input type="hidden" id="h_activ_id" value="" />
						<input type="hidden" id="h_plan_dia" value="" />
						<input type="hidden" id="h_sup_rut" value="" />
						<input type="hidden" id="h_rut_oper" value="" />
						
						<div class="form-group">
							<label class="col-sm-12">DIA DE PLANIFICACION (<span id="sem_txt"></span>)</label>
							<div class="col-sm-5">
								<select multiple class="form-control" tabindex="-1" id="plan_dia"></select>								
								<div class="help">Día(s)</div>
							</div>	
	
							<div class="col-sm-7">
								<textarea class="form-control" rows="3" placeholder="Ingresar motivo replanificación" id="sactiv_motivo"></textarea>
								<div class="help">Motivo Replanificación</div>
							</div>
													
							
						</div>							
						
						<div class="ln_solid"></div>
						<div class="clearfix"></div>

						<div class="form-group">
							<label class="col-sm-12">ACTIVIDAD DE PLANIFICACION</label>
							<div class="col-sm-3">
								<select class="select2_single form-control" tabindex="-1" id="area_id">	
									<option value="">SELECCIONE AREA</option>
								</select>								
								<div class="help">Area</div>
							</div>
							<div class="col-sm-4">
								<select class="select2_single form-control" tabindex="-1" id="sup_rut">	
									<option value="">SELECCIONE SUPERVISOR</option>
								</select>								
								<div class="help">Supervisor</div>
							</div>
							<div class="col-sm-5">
								<select class="select2_single form-control" tabindex="-1" id="activ_id">	
									<option value="">SELECCIONE ACTIVIDAD</option>
								</select>								
								<div class="help">Actividad</div>
							</div>							
						</div>	
						
						<div class="ln_solid"></div>
						<div class="clearfix"></div>						
						
						<div class="form-group">
							<label class="col-sm-12">PRODUCCIÓN ( jornada x meta = producción )</label>
							
							<div class="col-sm-2"><input type="text" class="form-control" id="plan_prod_esperada"><div class="help">Producción esperada</div></div>
							<div class="col-sm-1"><button id="btn_prod_esperada" type="button" class="btn btn-success">Selec.</button></div>							
							
							<div class="col-sm-1"><input type="text" class="form-control" id="plan_operadores"><div class="help">Operadores</div></div>
							<div class="col-sm-1"><button id="btn_operadores" type="button" class="btn btn-success">Selec.</button></div>
							
							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="hora_activ">	
								<!--
									<option value="0">TODA DISP.</option><option value="8.5">8,5 HORAS</option><option value="8">8,0 HORAS</option>
									<option value="7.5">7,5 HORAS</option><option value="7">7,0 HORAS</option><option value="6.5">6,5 HORAS</option>
									<option value="6">6,0 HORAS</option><option value="5.5">5,5 HORAS</option><option value="5">5,0 HORAS</option>
									<option value="4.5">4,5 HORAS</option><option value="4">4,0 HORAS</option><option value="3.5">3,5 HORAS</option>
									<option value="3">3,0 HORAS</option><option value="2.5">2,5 HORAS</option><option value="2">2,0 HORAS</option>
									<option value="1.5">1,5 HORAS</option><option value="1">1,0 HORAS</option><option value="0.5">0,5 HORAS</option>
								-->
								
									<option value="0">TODA DISP.</option><option value="8.5">8,5 HORAS</option><option value="8.25">8,25 HORAS</option>
									<option value="8">8,0 HORAS</option><option value="7.5">7,5 HORAS</option><option value="7">7,0 HORAS</option>
									<option value="6.5">6,5 HORAS</option><option value="6">6,0 HORAS</option><option value="5.5">5,5 HORAS</option>
									<option value="5">5,0 HORAS</option><option value="4.5">4,5 HORAS</option><option value="4">4,0 HORAS</option>
									<option value="3.5">3,5 HORAS</option><option value="3">3,0 HORAS</option><option value="2.5">2,5 HORAS</option>
									<option value="2">2,0 HORAS</option><option value="1.5">1,5 HORAS</option><option value="1">1,0 HORAS</option>
									<option value="0.5">0,5 HORAS</option><option value="0.08">0,08 HORAS</option>									
								
								</select>							
								<div class="help">Hora Máx. Actividad</div>
							</div>								
							
							<div class="col-sm-2"><input type="text" class="form-control" id="plan_meta" disabled><div class="help">Meta</div></div>
							<div class="col-sm-3"><input type="text" class="form-control" id="plan_unidad" disabled><div class="help">Unidad</div></div> 					
							
						</div>	
						
						<div class="ln_solid"></div>
						<div class="clearfix"></div>	

						<div class="form-group">
							
								<button id="btn_reg_planxsemana" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_planxsemana" type="button" class="btn btn-success" style="display:none">Modificar</button>
								<button id="btn_del_planxsemana" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_planxsemana" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							
						</div>	
	
						<div class="ln_solid"></div>	
						
						<div class="col-xs-6">
							<h2 class="sub-header">Resumen Semana</h2>
							<div class="table-responsive">
								<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th colspan="6" class="text-center">OPERADORES DISPONIBLES</th>
										</tr>			  
										<tr>
											<th class="col-md-1" style="text-align:center">L</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">J</th>
											<th class="col-md-1" style="text-align:center">V</th>
											<th class="col-md-1" style="text-align:center">S</th>											
										</tr>
									</thead>
									<tbody id="lista1_disp_operadores">			  

									</tbody>
								</table>
							</div>
						</div>
						
						<div class="col-xs-6">
							<h2 class="sub-header">Resumen Semana</h2>
							<div class="table-responsive">
								<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th colspan="6" class="text-center">JORNADAS DISPONIBLES</th>
										</tr>			  
										<tr>
											<th class="col-md-1" style="text-align:center">L</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">J</th>
											<th class="col-md-1" style="text-align:center">V</th>
											<th class="col-md-1" style="text-align:center">S</th>
										</tr>
									</thead>
									<tbody id="lista2_disp_jornada">			  

									</tbody>
								</table>
							</div>
						</div>					
						
						<div class="clearfix"></div>
						<div class="ln_solid"></div>	
						
						<div class="col-xs-4">
							<h2 class="sub-header">Operación Actual</h2>
							<div class="table-responsive">
								<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th colspan="6" class="text-center">JORNADA SELECCIONADA</th>
										</tr>			  
										<tr>
											<th class="col-md-1" style="text-align:center">L</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">J</th>
											<th class="col-md-1" style="text-align:center">V</th>		
											<th class="col-md-1" style="text-align:center">S</th>
										</tr>
									</thead>
									<tbody id="lista1_selec_jornada">			  

									</tbody>
								</table>
							</div>
						</div>
						
						<div class="col-xs-4">
							<h2 class="sub-header">Operación Actual</h2>
							<div class="table-responsive">
								<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th colspan="6" class="text-center">OPERADORES SELECCIONADOS</th>
										</tr>			  
										<tr>
											<th class="col-md-1" style="text-align:center">L</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">J</th>
											<th class="col-md-1" style="text-align:center">V</th>	
											<th class="col-md-1" style="text-align:center">S</th>
										</tr>
									</thead>
									<tbody id="lista3_selec_operadores">			  

									</tbody>
								</table>
							</div>
						</div>						
						
						<div class="col-xs-4">
							<h2 class="sub-header">Operación Actual</h2>
							<div class="table-responsive">
								<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th colspan="6" class="text-center">PRODUCCIÓN ESPERADA</th>
										</tr>			  
										<tr>
											<th class="col-md-1" style="text-align:center">L</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">J</th>
											<th class="col-md-1" style="text-align:center">V</th>
											<th class="col-md-1" style="text-align:center">S</th>
										</tr>
									</thead>
									<tbody id="lista2_selec_produccion">			  

									</tbody>
								</table>
							</div>
						</div>	
						
						<div class="clearfix"></div>
						<div class="ln_solid"></div>						

						<div class="col-xs-6">
							<h2 class="sub-header">Listado de Operadores</h2>
							<div class="table-responsive">
								<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th colspan="2"></th>
											<th colspan="6" class="text-center">DIAS CON CARGA DE TRABAJO</th>
										</tr>			  
										<tr>
											<th class="col-md-1"></th>
											<th class="col-md-5">Operador</th>
											<th class="col-md-1" style="text-align:center">L</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">J</th>
											<th class="col-md-1" style="text-align:center">V</th>
											<th class="col-md-1" style="text-align:center">S</th>
										</tr>
									</thead>
									<tbody id="lista1_operadores">			  

									</tbody>
								</table>
							</div>
						</div>
						
						<div class="col-xs-6">
							<h2 class="sub-header">Listado de Operadores</h2>
							<div class="table-responsive">
								<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th colspan="2"></th>
											<th colspan="6" class="text-center">DIAS CON CARGA DE TRABAJO</th>
										</tr>			  
										<tr>
											<th class="col-md-1"></th>
											<th class="col-md-5">Operador</th>
											<th class="col-md-1" style="text-align:center">L</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">J</th>
											<th class="col-md-1" style="text-align:center">V</th>
											<th class="col-md-1" style="text-align:center">S</th>
										</tr>
									</thead>
									<tbody id="lista2_operadores">			  

									</tbody>
								</table>
							</div>
						</div>
	

					</form>
	
					<div class="clearfix"></div>
					<br><br>
					<div class="form-group" <?php if ($_SESSION['USR_TIPO'] <> 'ADMINISTRADOR'){ ?> style="display:none" <?php } ?>  >
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
							<h2>Listado de Planificaciones</h2>

							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">

							<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
								<thead>
									<tr>	
										<th>Año</th>
										<th>Semana</th>		
										<th>Día</th>
										<th>Area</th>
										<th>Actividad</th>																						
										<th>Producción esperada</th>												
										<th>Supervisor</th>
										<th>Cód Area</th>
										<th>Rut Supervisor</th>
										<th>Cód Actividad</th>
										<th>Rut Operadores</th>
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