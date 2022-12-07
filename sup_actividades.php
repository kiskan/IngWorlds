<?php
include('header.php');
$periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
$ini_clon = 'carga inicial';
include('consultas/ges_crud_clones.php');
?>

<script type="text/javascript">
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	//var numeroSemana = <?php echo date("W"); ?>; 
	var numeroSemana = <?php echo $corresponding_week; ?>;	
	//var corresponding_week = <?php echo $corresponding_week; ?>;
	var corresponding_agno = <?php echo $corresponding_agno; ?>;
	var data_clones = <?php echo $load_clones; ?>;
</script>

<script type="text/javascript" src="js/sup_actividades.js"></script>

<style>

.color_rojo{
	font-size:14px;
	color:red;
	font-weight:bold;
}

.color_negro{
	font-size:15px;
	color:black;
	font-weight:bold;
}

.txt_sin {
    padding: 10px;
	font-weight:600;
	font-size:14px;
}

.inner {
    padding: 10px;color: #fff !important;
}
.small-box h3, .small-box p {
    z-index: 5;
}

.small-box h3 {
    font-size: 38px;
    font-weight: bold;
    margin: 0 0 10px 0;
    white-space: nowrap;
    padding: 0;
}

.small-box .icon {
    -webkit-transition: all .3s linear;
    -o-transition: all .3s linear;
    transition: all .3s linear;
    position: absolute;
    top: -10px;
    right: 10px;
    z-index: 0;
    font-size: 90px;
    color: rgba(0,0,0,0.15);
}

.small-box-footer {
	/*position:relative;*/
    text-align: center;
    padding: 3px 0;
    color: #fff;
    color: rgba(255,255,255,0.8);
    display: block;
    /*z-index: 10;*/
    background: rgba(0,0,0,0.1);
    text-decoration: none;
	
}
a:hover {
    color:black;
	font-weight:bold;
}

.footer-div {
	position:absolute;
	bottom:30px;
	right:10px; 
	padding:0 10px; 
	width:95%;
}

.sin_registrar{
	text-align:right; 
	padding-right:5px; 
	font-weight:600;/*bold;*/
	color:black
}

.finalizado{
	text-align:right; 
	padding-right:5px; 
	font-weight:600; 
	color:white
}
</style>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Control Actividades</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
				
					<form id="form_control" data-parsley-validate class="form-horizontal form-label-left" action="sup_actoperadores.php" method="post">
				
						<input type="hidden" id="h_inst_id" name="h_inst_id" value="" />
				
						<input type="hidden" id="h_sactiv_dia" name="h_sactiv_dia" value="" />
						<input type="hidden" id="h_area_id" name="h_area_id" value="" />
						<input type="hidden" id="h_activ_id" name="h_activ_id" value="" />	
						<input type="hidden" id="h_sem_num" name="h_sem_num" value="" />
						<input type="hidden" id="h_per_agno" name="h_per_agno" value="" />
						<input type="hidden" id="h_sem_txt" name="h_sem_txt" value="" />					
						<input type="hidden" id="h_sup_rut" name="h_sup_rut" value="" />	

						<input type="hidden" id="h_pm_dia" name="h_pm_dia" value="" />
					
						<input type="hidden" id="h_oper_clic" name="h_oper_clic" value="" />
					
						<input type="hidden" id="hpm_plantas" value="" />
						<input type="hidden" id="hpm_piscinas" value="" />
					
						<div class="form-group">
							
							<div class="col-lg-2 col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="per_agno" <?php if($_SESSION['USR_TIPO'] == 'SUPERVISOR'){ ?> disabled <?php } ?>>	
								</select>								
								<div class="help">Año</div>
							</div>
							<div class="col-lg-4 col-sm-4">
								<select class="select2_single form-control" tabindex="-1" id="sem_num"<?php if($_SESSION['USR_TIPO'] == 'SUPERVISOR'){ ?> disabled <?php } ?>>	
								</select>								
								<div class="help">Semana</div>
							</div>
							
							<div class="col-lg-2 col-sm-2"><button id="btn_atras" type="button" class="btn btn-success" style="display:none">Volver atrás</button></div>
						</div>
						<div class="clearfix"></div>
						
						<div class="form-group">
							
							<div class="col-lg-2 col-sm-2">							
								<select class="select2_single form-control" tabindex="-1" id="plan_dia"></select>								
								<div class="help">Día</div>
							</div>	
							
							<div id="div_supervisor" class="col-lg-4 col-sm-4"<?php if($_SESSION['USR_TIPO'] == 'SUPERVISOR'){ ?> style="display:none" <?php } ?>>
								<select class="select2_single form-control" tabindex="-1" id="sup_rut">
									<option value="">SELECCIONE SUPERVISOR</option>
								</select>								
								<div class="help">Supervisor</div>
							</div>		

							<div class="col-lg-2 col-sm-2"><button id="btn_actividades" type="button" class="btn btn-success">Seleccionar</button></div>
							
							<img src="images/loading.gif" id="loading3" style="display:none">
							
						</div>	
						
						<div id="area_activ" style="display:none">
							<div class="clearfix"></div>
	
							<div class="col-sm-12">							
								<span id="area_nombre" style="font-weight:bold; font-size:20px"></span>						
								<div class="help">Area</div>
							</div>	
							
							<div class="col-sm-12">
								<span id="activ_nombre" style="font-weight:bold; font-size:20px"></span>								
								<div class="help">Actividad</div>
							</div>									
							
							<div class="form-group">
							
								<div class="col-lg-3 col-sm-3">								
									<span id="produccion_esperada" style="font-weight:bold; font-size:20px"></span>						
									<div class="help">Producción esperada</div>
								</div>		
								
								<div class="col-lg-2 col-sm-2">							
									<select class="select2_single form-control" tabindex="-1" id="plan_dia_new"></select>								
									<div class="help">Nuevo Día</div>
								</div>	
								
								<div class="col-lg-5 col-sm-5">
									<select class="select2_single form-control" tabindex="-1" id="id_activ_new">
										<option value="">SELECCIONE ACTIVIDAD</option>
									</select>								
									<div class="help">Nueva Actividad</div>
								</div>	

								<div class="col-lg-2 col-sm-2">
									<button id="btn_new_activ" type="button" class="btn btn-dark">Cambiar</button>
								</div>
							
							</div>
				
						</div>
		
						<div class="clearfix"></div>
						<div class="ln_solid"></div>
						
						
						<span id="sin_actividades" class="txt_sin" style="display:none"><br>No se han planificado actividades en este día bajo su supervisión.</span>
						
						<div id="listado_activ" class="row" style="min-height:400px">
							
						</div>					


						<!-- MODAL CONSULTA OPERADOR  -->
						<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
						  <div class="modal-dialog modal-lg" role="document">
							<div class="modal-content" style="padding:20px;">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title" style="font-weight:bold;font-size:19px !important">Consulta planificación del operador</h4>
								</div>
								<div class="modal-body">
								<div class="clearfix"></div>
									<table>
										<tr>
											<td style="font-weight:bold;">Nombre Operador</td><td>: <span id="nom_oper"></span></td>
										</tr>
										<tr>
											<td style="font-weight:bold;">Día Planificación</td><td>: <span id="dia_planif"></span></td>
										</tr>											
									</table>
									<br>
																
									<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>	
												<th>Area</th>		
												<th>Supervisor</th>
												<th>Actividad</th>
												<th>Hr Asig</th>
												<th>Hr Prod</th>												
											</tr>
										</thead>
										
										<tbody id="table_operador">

										</tbody>
										
									</table>
								</div>
							</div>
						  </div>
						</div>	
	
	
						<!-- MODAL CONSULTA PRODUCCION X HORA  -->
						<div class="modal fade produccionxhora">
						  <div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Detalle Producción x Operador</h4>
								</div>							
							
								<div class="modal-body">
									<div class="form-group">
										<div class="col-md-4 col-sm-4 col-xs-12">						
											<select class="select2_single form-control" tabindex="-1" id="sel_hrxtrab">
												<option value="2" selected>2 HR   - 08:00 a 10:00</option>
												<option value="5">5 HR   - 08:00 a 13:00</option>
												<option value="6">6 HR   - 08:00 a 15:00 (-1 HR)</option>
												<option value="8.5">8,5 HR - 08:00 a 17:30 (-1 HR)</option>
												<option value="9">9 HR   - por horas extras</option>
												<option value="10">10 HR   - por horas extras</option>
											</select>								
											<div class="help">Horas trabajadas</div>
										</div>								
									
										<div class="col-md-3 col-sm-3 col-xs-12">						
											<select class="select2_single form-control" tabindex="-1" id="sel_hrxdesc">
												<option value="0" selected>Sin descuentos</option><option value="0.25">15 MIN</option><option value="0.5">30 MIN</option><option value="0.75">45 MIN</option>
												<option value="1">1,0 HR</option><option value="1.25">1 HR y 15 MIN</option><option value="1.5">1 HR y 30 MIN</option><option value="1.75">1 HR y 45 MIN</option>
												<option value="2">2,0 HR</option><option value="2.25">2 HR y 15 MIN</option><option value="2.5">2 HR y 30 MIN</option><option value="2.75">2 HR y 45 MIN</option>
												<option value="3">3,0 HR</option><option value="3.25">3 HR y 15 MIN</option><option value="3.5">3 HR y 30 MIN</option><option value="3.75">3 HR y 45 MIN</option>
												<option value="4">4,0 HR</option><option value="4.25">4 HR y 15 MIN</option><option value="4.5">4 HR y 30 MIN</option><option value="4.75">4 HR y 45 MIN</option>
												<option value="5">5,0 HR</option><option value="5.25">5 HR y 15 MIN</option><option value="5.5">5 HR y 30 MIN</option><option value="5.75">5 HR y 45 MIN</option>
												<option value="6">6,0 HR</option><option value="6.25">6 HR y 15 MIN</option><option value="6.5">6 HR y 30 MIN</option><option value="6.75">6 HR y 45 MIN</option>
												<option value="7">7,0 HR</option><option value="7.25">7 HR y 15 MIN</option><option value="7.5">7 HR y 30 MIN</option><option value="7.75">7 HR y 45 MIN</option>
												<option value="8">8,0 HR</option>
											</select>								
											<div class="help">Horas descuentos</div>
										</div>									
									
										<div class="col-md-3 col-sm-3 col-xs-12">						
											<button type="button" id="btn_filtro" class="btn btn-info">Aplicar Filtro Gnral</button>
										</div>	
									</div>
									<div class="clearfix"></div><br>
									
									<div class="form-group">
										<label class="col-sm-12">Consulta totales producción</label>									
										<div class="col-sm-2"><input type="text" class="form-control" id="dprod_cant" disabled><div class="help">Cantidad</div></div>	
										<div class="col-sm-2"><input type="text" class="form-control" id="dprod_hr" disabled><div class="help">Producción x Hr</div></div>									
										<div class="col-sm-2"><button id="btn_calc_prod" type="button" class="btn btn-info">Calcular Prod x Hr</button></div>
									</div>	
									<div class="table-responsive">
									<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th style="display:none">Rut Operador</th>
												<th>Operador</th>		
												<th>Cantidad</th>
												<th>Hr Trab</th>
												<th>Descuento</th>	
												<th>Prod x Hr</th>
											</tr>
										</thead>
										
										<tbody id="table_detprod">

										</tbody>
										
									</table>
									</div>
								
								</div>
								<div class="modal-footer">
								
								</div>
							</div>
						  </div>
						</div>		
	
	

						<!-- Modal Observaciones HTML -->
						<div id="WModal_Obs" class="modal fade">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
										<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
										<h4 id="title_obs"class="modal-title">Observación</h4>
									</div>
									<div class="modal-body">
										<form role="form">
										
											<div class="radio">
												<label><input type="radio" id="permiso" name="obs_oper" value="PERMISO">PERMISO</label>
											</div>	
											<div class="radio">
												<label><input type="radio" id="vacaciones" name="obs_oper" value="VACACIONES">VACACIONES</label>
											</div>
											<div class="radio">
												<label><input type="radio" id="licencia" name="obs_oper" value="LICENCIA">LICENCIA</label>
											</div>
											<div class="radio">
												<label><input type="radio" id="otro" name="obs_oper" value="OTRO">OTRO</label>
											</div>
											<div class="form-group">
												<label for="message-text" class="control-label">Observación:</label>
												<textarea id="modal_obs" class="form-control" id="message-text" disabled maxlength="500"></textarea>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<button type="button" id="btn_reg_obs" class="btn btn-primary">Registrar</button>
										<button type="button" id="btn_del_obs" class="btn btn-default">Borrar</button>
									</div>
								</div>
							</div>
						</div>


						<!-- Modal Cantidad HTML -->
						<div id="WModal_Cant" class="modal fade">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
								<center>
									<div class="modal-header">
										<!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
										<h4 id="title_cant" class="modal-title">Cantidad</h4>
									</div>
									<div class="modal-body">
										<form role="form">
										
											<div class="form-group">
											  <label for="usr">Cantidad 10:00 AM</label>
											  <input type="text" class="form-control" id="cant_10am" style="width:120px;" maxlength="12">
											</div>
											<div class="form-group">
											  <label for="pwd">Cantidad Colación</label>
											  <input type="text" class="form-control" id="cant_col" style="width:120px;" maxlength="12">
											</div>
											<div class="form-group">
											  <label for="pwd">Cantidad 15:00 PM</label>
											  <input type="text" class="form-control" id="cant_15pm" style="width:120px;" maxlength="12">
											</div>
											<div class="form-group">
											  <label for="pwd">Cantidad Cierre</label>
											  <input type="text" class="form-control" id="cant_cierre" style="width:120px;" maxlength="12">
											</div>	
											
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
										<button type="button" id="btn_reg_cant" class="btn btn-primary">Registrar</button>
									</div>
								</center>
								</div>
							</div>
						</div>
						
						
						
						
						<!-- Modal Cantidad COSECHA	HTML -->
						<div id="WModal_Cant_Cosecha" class="modal fade">
							<div class="modal-dialog modal-md">
								<div class="modal-content">
								<center>
									<div class="modal-header">
										<h4 id="title_cosecha" class="modal-title">Cantidad</h4>
									</div>
									<div class="modal-body">
									
										<div class="form-group">
										
											<div class="col-sm-3">
												<select class="select2_single form-control" tabindex="-1" id="pm_plantas">
												<!--<option value="PM1">PM1</option>
												<option value="PM2">PM2</option>-->
												<option value="PM3">PM3</option>
												<option value="PM4">PM4</option>
												<option value="PM5">PM5</option>
												<option value="PM6">PM6</option>
												<option value="PM7">PM7</option>
												<option value="PM8">PM8</option>
												<option value="PM9">PM9</option>
												</select>								
												<div class="help">Planta Madre</div>
											</div>												
																		

											<div class="col-sm-3">
												<select class="select2_single form-control" tabindex="-1" id="pm_piscinas">
												<?php
													$i=1;
													while($i <= 30){
														echo '<option value="'.$i.'">'.$i.'</option>';
														$i++;
													}
												?>
												</select>								
												<div class="help">Piscina</div>
											</div>
											
											<div class="col-sm-3">
												<input type="text" class="form-control" id="pm_clon" disabled>								
												<div class="help">Clon</div>
											</div>
											
											<div class="col-sm-3">
												<input type="text" class="form-control" id="pm_cantidad">								
												<div class="help">Cantidad</div>
											</div>

										</div>

										<div class="clearfix"></div><br>										
										
																				
										<button id="btn_reg_pm" type="button" class="btn btn-success">Registrar</button>
										<button id="btn_upd_pm" type="button" class="btn btn-success" style="display:none">Modificar</button>
										<button id="btn_del_pm" type="button" class="btn btn-success" style="display:none">Eliminar</button>
										<button id="btn_can_pm" type="button" class="btn btn-success" style="display:none">Cancelar</button>
										<br>								
										<img src="images/loading.gif" id="loading2" style="display:none">											
																		
										
													
										<div class="clearfix"></div><br>
										
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="x_panel">
												<div class="x_title">
													<h2>Registro de Cantidad</h2>
													<ul class="nav navbar-right panel_toolbox">
														<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
													</ul>
													<div class="clearfix"></div>
												</div>
												<div class="x_content">

													<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Planta Madre</th>
																<th>Piscina</th>
																<th>Clon</th>
																<th>Cantidad</th>
															</tr>
														</thead>

													</table>

												</div>
											</div>
										</div>											
									
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
									</div>
								</center>
								</div>
							</div>
						</div>						
						
						
						
						
						<!-- Modal Cantidad INSTALACION	HTML -->
						<div id="WModal_Cant_Instalacion" class="modal fade">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
								<center>
									<div class="modal-header">
										<h4 id="title_instalacion" class="modal-title">Cantidad</h4>
									</div>
									<div class="modal-body">
									
										<div class="form-group">
										
											<div class="col-sm-2">
												<select class="select2_single form-control" tabindex="-1" id="inst_inv">
												<?php
													$i=1;
													while($i <= 9){
														echo '<option value="'.$i.'">'.$i.'</option>';
														$i++;
													}
												?>
												</select>								
												<div class="help">Invernadero</div>
											</div>												
																		
											
											<div class="col-sm-4">
												<select class="select2_single form-control" id="inst_clon">	
													<option value="">SELECCIONE CLON</option>
												</select>								
												<div class="help">Clon</div>
											</div>
											
											<div class="col-sm-2">
												<select class="select2_single form-control" tabindex="-1" id="inst_linea">
												<?php
													$i=1;
													while($i <= 9){
														echo '<option value="'.$i.'">'.$i.'</option>';
														$i++;
													}
												?>
												</select>								
												<div class="help">Línea</div>
											</div>			

											<div class="col-sm-2">
												<select class="select2_single form-control" tabindex="-1" id="inst_tipoestaca">
													<option value="MACRO">MACRO</option>
													<option value="MINI">MINI</option>
												</select>								
												<div class="help">Tipo Estaca</div>
											</div>											
											
											<div class="col-sm-2">
												<input type="text" class="form-control" id="inst_cantidad">								
												<div class="help">Cantidad</div>
											</div>

										</div>

										<div class="clearfix"></div><br>										
										
																				
										<button id="btn_reg_inst" type="button" class="btn btn-success">Registrar</button>
										<button id="btn_upd_inst" type="button" class="btn btn-success" style="display:none">Modificar</button>
										<button id="btn_del_inst" type="button" class="btn btn-success" style="display:none">Eliminar</button>
										<button id="btn_can_inst" type="button" class="btn btn-success" style="display:none">Cancelar</button>
										<br>								
										<img src="images/loading.gif" id="loading_ins" style="display:none">											
																		
										
													
										<div class="clearfix"></div><br>
										
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="x_panel">
												<div class="x_title">
													<h2>Registro de Cantidad</h2>
													<ul class="nav navbar-right panel_toolbox">
														<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
													</ul>
													<div class="clearfix"></div>
												</div>
												<div class="x_content">

													<table id="datatable-responsiveinst" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>ID Instalacion</th>
																<th>Invernadero</th>
																<th>Clon</th>
																<th>Línea</th>
																<th>Tipo Estaca</th>
																<th>Cantidad</th>
															</tr>
														</thead>

													</table>

												</div>
											</div>
										</div>											
									
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
									</div>
								</center>
								</div>
							</div>
						</div>								
						
						
	
<!-- LISTADO DE OPERADORES  -->						
						<div id="faena" style="display:none">
														
							<div class="form-group">
								<label class="col-sm-6">Consulta planificación del operador</label>
								<label class="col-sm-6">Consulta totales producción</label>
								<div class="col-sm-4">
									<select class="select2_single form-control" tabindex="-1" id="oper_faltante"></select>								
								</div>	
								<div class="col-sm-2">
									<button id="btn_consoper" type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg">Consultar</button>
								</div>	
								
								<div class="col-sm-2"><input type="text" class="form-control" id="cant_total" disabled><div class="help">Cantidad</div></div>	
								<div class="col-sm-2"><input type="text" class="form-control" id="prom_total" disabled><div class="help">Producción x Hr</div></div>
							
								<div class="col-sm-2">
									<button id="btn_consprod" type="button" class="btn btn-success">Consultar</button>
								</div>								
							
							</div>							
							
							<div class="clearfix"></div><br>
							<button id="btn_reg_faena" type="button" class="btn btn-success">Guardar Actividad</button>
							
							<button id="btn_upd_faena" type="button" class="btn btn-warning">Validar y Registrar</button>
							<button id="btn_consprodxhr" type="button" class="btn btn-success" data-toggle="modal" data-target=".produccionxhora">Producción x Hora</button>
							<!--<button id="btn_del_faena" type="button" class="btn btn-success">Eliminar Faena</button>-->
							<button id="btn_oper_faena" type="button" class="btn btn-success"<?php if($_SESSION['USR_TIPO'] <> 'SUPERVISOR'){ ?> style="display:none" <?php } ?>>Actualizar Operadores</button>
							<img src="images/loading.gif" id="loading" style="display:none">
	
							<div class="clearfix"></div><br>
							
							<div class="row">
									
								<div class="col-sm-4">
									<label style = "font-size:22px">Listado de Operadores</label>
								</div>
								<div class="col-sm-8 text-right">
									<div class="form-inline">	
										<label>Hr - Min Ini:</label>
										<select id="hr_ini_all" style="width:65px" class="select2_single form-control" tabindex="-1"></select>&nbsp;-&nbsp;
										<select id="min_ini_all" style="width:65px" class="select2_single form-control" tabindex="-1"></select>	
										&nbsp;&nbsp;&nbsp;
										<label>Hr - Min Fin:</label>
										<select id="hr_fin_all" style="width:65px" class="select2_single form-control" tabindex="-1"></select>&nbsp;-&nbsp;
										<select id="min_fin_all" style="width:65px" class="select2_single form-control" tabindex="-1"></select>	
										<button id="btn_hora_all" type="button" class="btn btn-success" style="margin-bottom:0 !important">Replicar Hora</button>
									</div>
								</div>
							</div>
							<!--
							<div class="form-inline">							
								<label style = "font-size:22px">Listado de Operadores</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<label>Hr - Min Ini:</label>
								<select id="hr_ini_all" style="width:65px" class="select2_single form-control" tabindex="-1"></select>&nbsp;-&nbsp;
								<select id="min_ini_all" style="width:65px" class="select2_single form-control" tabindex="-1"></select>	
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<label>Hr - Min Fin:</label>
								<select id="hr_fin_all" style="width:65px" class="select2_single form-control" tabindex="-1"></select>&nbsp;-&nbsp;
								<select id="min_fin_all" style="width:65px" class="select2_single form-control" tabindex="-1"></select>	
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<button id="btn_hora_all" type="button" class="btn btn-success" style="margin-bottom:0 !important">Replicar Hora</button>
							</div>							
							-->
							
							<br>
							<div class="table-responsive">
								<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead>
										<tr>	
											<th style="text-align:center">Asist<br><input type="checkbox" id='asist_all' /></th>
											<th>Operador</th>
											<th style="text-align:center">Cant</th>		
											<th style="text-align:center">Hr Ini</th>
											<th style="text-align:center">Hr Fin</th>
											<th style="text-align:center">Hr Dscto</th>
											<th style="text-align:center">Hr Asig</th>
											<th style="text-align:center">Hr Prod</th>											
											<th style="text-align:center">B1<br><input type="checkbox" id='b1_all' /></th>
											<th style="text-align:center">B2<br><input type="checkbox" id='b2_all' /></th>
											<th style="text-align:center">Col<br><input type="checkbox" id='col_all' /></th>
											<th>Observación</th>	
										</tr>
									</thead>
									
									<tbody id="oper_actividad">

									</tbody>
								</table>
							</div>	

						</div>
				
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- /page content -->

<?php
include('footer.php');
?>