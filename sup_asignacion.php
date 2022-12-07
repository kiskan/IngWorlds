<?php
include('header.php');

$plan_periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
if(!$error){
$activ_extra = 'carga inicial';
include('consultas/ges_crud_areas.php');

?>

<script type="text/javascript">
	var data_areas = <?php echo $load_areas; ?>;
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	var corresponding_week = <?php echo $corresponding_week; ?>;
	var corresponding_agno = <?php echo $corresponding_agno; ?>;
</script>

<script type="text/javascript" src="js/sup_asignacion.js"></script>
<?php } ?>
<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Asignación Actividades extras</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
				<?php if(!$error){ ?>	
				
				
					<div class="form-group" <?php if ($_SESSION['USR_TIPO'] == 'ADMINISTRADOR'){ ?> style="display:none2" <?php } ?>  >
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
			
					<form id="form_supxasignacion" data-parsley-validate class="form-horizontal">	
						
						<input type="hidden" id="h_activ_id" value="" />
						<input type="hidden" id="h_plan_dia" value="" />
						<input type="hidden" id="h_rut_jgrupo" value="" />
						<input type="hidden" id="h_rut_oper" value="" />

						
						<div class="form-group">
							<label class="col-sm-12">DIA DE ASIGNACIÓN (<span id="sem_txt"></span>)</label>
							<div class="col-sm-5">
								<select multiple class="form-control" tabindex="-1" id="plan_dia"></select>								
								<div class="help">Día(s)</div>
							</div>							

							<div class="col-sm-3">
								<select class="select2_single form-control" tabindex="-1" id="tipo_jorn">	
									<option value="">SELECCIONE TIPO JORNADA</option>
									<option value="MAÑANA">MAÑANA</option>
									<option value="TARDE">TARDE</option>
									<option value="MAÑANA Y TARDE">MAÑANA Y TARDE</option>
									<option value="TURNO">TURNO</option>
								</select>								
								<div class="help">Tipo Jornada</div>
							</div>								
							
							
						</div>							
						
						<div class="ln_solid"></div>
						<div class="clearfix"></div> 

						<div class="form-group">
							<label class="col-sm-12">DATOS ASIGNACION</label>
							<div class="col-sm-3">
								<select class="select2_single form-control" tabindex="-1" id="area_id">	
									<option value="">SELECCIONE AREA</option>
								</select>								
								<div class="help">Area</div>
							</div>
							
							<div class="col-sm-5">
								<select class="select2_single form-control" tabindex="-1" id="activ_id">	
									<option value="">SELECCIONE ACTIVIDAD</option>
								</select>								
								<div class="help">Actividad</div>
							</div>	
							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="hora_activ">	<option value="">SELECCIONE JORNADA</option>
									<option value="8.5">8,5 HORAS</option><option value="8">8,0 HORAS</option>
									<option value="7.5">7,5 HORAS</option><option value="7">7,0 HORAS</option><option value="6.5">6,5 HORAS</option>
									<option value="6">6,0 HORAS</option><option value="5.5">5,5 HORAS</option><option value="5">5,0 HORAS</option>
									<option value="4.5">4,5 HORAS</option><option value="4">4,0 HORAS</option><option value="3.5">3,5 HORAS</option>
									<option value="3">3,0 HORAS</option><option value="2.5">2,5 HORAS</option><option value="2">2,0 HORAS</option>
									<option value="1.5">1,5 HORAS</option><option value="1">1,0 HORAS</option><option value="0.5">0,5 HORAS</option>
								</select>							
								<div class="help">Jornada</div>
							</div>	
                              							
						</div>	
						
					    <div class="form-group">
							<label class="col-sm-12">DATOS ENCARGADO</label>
							<div class="col-sm-3">
								<select class="select2_single form-control" tabindex="-1" id="tj_grupo">	
									<option value="">SELECCIONE TIPO</option>
									<option value="SUPERVISOR">SUPERVISOR</option>
									<option value="OPERADOR">OPERADOR</option>
								</select>								
								<div class="help">Tipo Jefe de Grupo</div>
							</div>
							
							<div class="col-sm-5">
								<select class="select2_single form-control" tabindex="-1" id="j_grupo">	
									<option value="">SELECCIONE JEFE GRUPO</option>
								</select>								
								<div class="help">Jefe de Grupo</div>
							</div>	
							
							
                              						
						</div>					
						
					
						
						<div class="ln_solid"></div>
						<div class="clearfix"></div>	

						<div class="form-group">
							
								<button id="btn_reg_supxasignacion" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_supxasignacion" type="button" class="btn btn-success" style="display:none">Modificar</button>
								<button id="btn_del_supxasignacion" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_supxasignacion" type="button" class="btn btn-success" style="display:none">Cancelar</button>
							
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							
						</div>	
	
									
						
															
						
						<div class="clearfix"></div>
						<div class="ln_solid"></div>	
						
						
						
						
						
						<div class="clearfix"></div>
						<div class="ln_solid"></div>						

						<div class="col-xs-6">
							<h2 class="sub-header">Listado de Operadores</h2>
							<div class="table-responsive">
								<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th colspan="2"></th>
											<th colspan="7" class="text-center">ASIGNACIÓN JORNADA EXTRA</th>
										</tr>			  
										<tr>
											<th class="col-md-1"></th>
											<th class="col-md-3">Operador</th>
											<th class="col-md-1" style="text-align:center">L</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">J</th>
											<th class="col-md-1" style="text-align:center">V</th>
											<th class="col-md-1" style="text-align:center">S</th>
											<th class="col-md-1" style="text-align:center">D</th>											
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
											<th colspan="7" class="text-center">ASIGNACIÓN JORNADA EXTRA</th>
										</tr>			  
										<tr>
											<th class="col-md-1"></th>
											<th class="col-md-3">Operador</th>
											<th class="col-md-1" style="text-align:center">L</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">M</th>
											<th class="col-md-1" style="text-align:center">J</th>
											<th class="col-md-1" style="text-align:center">V</th>
											<th class="col-md-1" style="text-align:center">S</th>
											<th class="col-md-1" style="text-align:center">D</th>
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

					<div class="x_panel">
						<div class="x_title">
							<h2>Listado de Actividades Extras</h2>

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
										<th>Tipo Jefe Grupo</th>												
										<th>Jefe Grupo</th>
										<th>Asignador</th>
										<th>Fecha último registro</th>
										<th>Cód Area</th>
										<th>Rut Jefe Grupo</th>
										<th>Cód Actividad</th>
										<th>Rut Operadores</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				
				<?php }else{ echo "Solicitar a un Administrador registra período siguiente. (Año: $next_year)";} ?>	
					
				</div>
			</div>
		</div>
	</div>

</div>
<!-- /page content -->

<?php
include('footer.php');
?>