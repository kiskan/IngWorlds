<?php
include('header.php');

$plan_periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');

$viveros = 'carga inicial';
include('consultas/ges_crud_viveros.php');

$solicitantes = 'carga inicial';
$destinatarios = 'carga inicial';
include('consultas/ges_crud_usuarios.php');
/*
$categoria = 'carga inicial';
include('consultas/bod_crud_catproducto.php');
*/
$load_prod = 'carga inicial';
include('consultas/bod_crud_productos.php');

$viveros = 'carga inicial';
include('consultas/ges_crud_viveros.php');
?>
<style>


.panel.with-nav-tabs .panel-heading{
    padding: 5px 5px 0 5px;
}
.panel.with-nav-tabs .nav-tabs{
	border-bottom: none;
}
.panel.with-nav-tabs .nav-justified{
	margin-bottom: -1px;
}
/*** PANEL PRIMARY ***/


.with-nav-tabs.panel-primary .nav-tabs > li > a,
.with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
    color: #fff;
}
.with-nav-tabs.panel-primary .nav-tabs > .open > a,
.with-nav-tabs.panel-primary .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
	color: #fff;
	background-color: #26b99a;
	border-color: transparent;
}
.with-nav-tabs.panel-primary .nav-tabs > li.active > a,
.with-nav-tabs.panel-primary .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.active > a:focus {
	color: #26b99a;
	background-color: #fff;
	border-color: #26b99a;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #26b99a;
    border-color: #26b99a;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #fff;   
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #26b99a;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    background-color: #26b99a;
}

.form-group input[type="checkbox"] {
    display: none;
}

.form-group input[type="checkbox"] + .btn-group > label span {
    width: 20px;
}

.form-group input[type="checkbox"] + .btn-group > label span:first-child {
    display: none;
}
.form-group input[type="checkbox"] + .btn-group > label span:last-child {
    display: inline-block;   
}

.form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
    display: inline-block;
}
.form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
    display: none;   
}
</style>
<script type="text/javascript">
	var data_viveros = <?php echo $load_viveros; ?>;
	var data_destinatarios = <?php echo $load_destinatarios; ?>;
	//var data_categorias = <?php echo $load_categorias; ?>;
	var data_solicitantes = <?php echo $load_solicitantes; ?>;
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	var corresponding_week = <?php echo $corresponding_week; ?>;
	var corresponding_agno = <?php echo $corresponding_agno; ?>;
	var data_productos = <?php echo $load_productos; ?>;
	var data_sap = <?php echo $load_sap; ?>;	
</script>

<script type="text/javascript" src="js/bod_retprod.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-xs-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Gestión Solicitudes Materiales a Bodega</h2>
					<div class="clearfix"></div>
				</div>
					
				<div class="panel with-nav-tabs panel-primary">
					<div class="panel-heading">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab1primary" data-toggle="tab">PENDIENTES</a></li>										
								<li><a href="#tab2primary" data-toggle="tab">ACEPTADAS</a></li>
								<li><a href="#tab3primary" data-toggle="tab">RECHAZADAS</a></li>
								<li><a href="#tab4primary" data-toggle="tab">ENTREGADAS</a></li>
								<li><a href="#tab5primary" data-toggle="tab">SALIDA DE EMERGENCIA J.U</a></li>
							</ul>
					</div>
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1primary">
							
								<div class="x_content">
									<br />	
									
									<div class="form-group">
										<label class="col-sm-12">SOLICITUD</label>										
										<div class="col-sm-2">
											<input type="text" id="sprod_id" class="form-control" disabled>	
											<div class="help">Nro Solicitud</div>
										</div>
										<div class="col-sm-6">
											<input type="text" id="usr_solic" class="form-control" disabled>	
											<div class="help">Solicitante</div>
										</div>										
									</div>									
							
									<div class="form-group">
										<label class="col-sm-12">DIA DE SOLICITUD</label>										
										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="per_agno" disabled></select>								
											<div class="help">Año</div>
										</div>
										<div class="col-sm-4">
											<select class="select2_single form-control" tabindex="-1" id="sem_num" disabled></select>								
											<div class="help">Semana</div>
										</div>		
										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="sprod_dia" disabled></select>
											<div class="help">Día</div>
										</div>	
									</div>
									
									<div class="clearfix"></div>
									
									<div class="form-group">
										<label class="col-xs-12">DESTINATARIO</label>
																				
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="UNDVIV_ID" disabled>	
												<option value=""></option>
											</select>								
											<div class="help">Unidad</div>
										</div>	
										<div class="col-sm-5">
											<select class="select2_single form-control" tabindex="-1" id="sprod_id_dest" disabled>
												<option value=""></option>
											</select>								
											<div class="help">Destinatario: Operador/Administrativo</div>
										</div>

									</div>
									
									
									<div class="clearfix"></div>	
									<div class="ln_solid"></div>
									<div class="clearfix"></div>									
									
									<div class="form-group">
										<label class="col-xs-12">RESOLUCIÓN</label>
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="sprod_estado">
												<option value="">SELECCIONE RESOLUCIÓN</option>
												<option value="ACEPTADA">ACEPTADA</option>
												<option value="RECHAZADA">RECHAZADA</option>
											</select>								
											<div class="help">Resolución</div>
										</div>
										<div class="form-group col-sm-2" id="fecha_entrega" style="display:none">
											<div class="inner-addon left-addon">
												<i class="glyphicon glyphicon-calendar form-control-feedback  fa fa-calendar"></i>
												<input type="text" id="sprod_dentrega" class="form-control" value="" style="cursor:pointer" readonly >								
												<div class="help">Fecha entrega</div>
											</div>	
										</div>	
										<div class="col-sm-2" id="hora_entrega" style="display:none">
										<select class="select2_single form-control" tabindex="-1" id="sprod_hentrega">
											<option value="08:00" selected>08:00</option><option value="08:30">08:30</option><option value="09:00">09:00</option><option value="09:30">09:30</option>
											<option value="10:00">10:00</option><option value="10:30">10:30</option><option value="11:00">11:00</option><option value="11:30">11:30</option>
											
											<option value="12:00">12:00</option><option value="12:30">12:30</option><option value="13:00">13:00</option><option value="13:30">13:30</option>
											<option value="14:00">14:00</option><option value="14:30">14:30</option><option value="15:00">15:00</option><option value="15:30">15:30</option>
											<option value="16:00">16:00</option><option value="16:30">16:30</option><option value="17:00">17:00</option><option value="17:30">17:30</option>
											<option value="18:00">18:00</option><option value="18:30">18:30</option><option value="19:00">19:00</option><option value="19:30">19:30</option>
											<option value="20:00">20:00</option><option value="20:30">20:30</option><option value="21:00">21:00</option><option value="21:30">21:30</option>
											<option value="22:00">22:00</option><option value="22:30">22:30</option><option value="23:00">23:00</option><option value="23:30">23:30</option>

										</select>
											<div class="help">Hora entrega</div>
										</div>	
							
									</div>	
									
									<div class="form-group">
										<label class="col-xs-12">COMENTARIO RESOLUCIÓN</label>									
										<div class="col-md-8 col-sm-8 col-xs-12">
											<textarea class="form-control" rows="3" id="sprod_comentario" ></textarea>
										</div>									
									</div>
									
									<div class="form-group">
										<div class="col-xs-12">
											<br>
											<button id="btn_reg_resolucion" type="button" class="btn btn-success">Registrar Resolución</button>
											<br>								
											<img src="images/loading.gif" id="loading" style="display:none">
											<span id="error" style="display:none; color:red" />			
										</div>
									</div>									
									
									<div class="clearfix"></div>	
									<div class="ln_solid"></div>
									<div class="clearfix"></div>				

									<form id="form_sprod" data-parsley-validate class="form-horizontal">	

										<input type="hidden" id="h_prod_cod" value="" />
										<input type="hidden" id="h_flag_rowprod" value="" />
									
										<div class="panel with-nav-tabs panel-primary">
											<div class="panel-heading">
													<ul class="nav nav-tabs">
														<li class="active"><a href="#tab1primary" data-toggle="tab">MATERIALES SOLICITADOS</a></li>
													</ul>
											</div>
											<div class="panel-body" id="productos_solicitar">
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab1primary">
													
													
														<div class="table-responsive">
															<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
																<thead>
																	<tr>	
																		<th style="text-align:center; width:70px">Aceptado</th>
																		<th style="display:none">Categoría</th>
																		<th>Material</th>
																		<th style="text-align:center; width:120px">Stock</th>	
																		<th style="text-align:center; width:120px">Cant Solicitada</th>		
																		<th style="text-align:center; width:120px">Cant Aceptada</th>	
																	</tr>
																</thead>
																
																<tbody id="productos_solicitados">

																</tbody>
															</table>
														</div>														
													
																								
													</div>
												</div>
											</div>
										</div>
																

									</form>	
																		
								</div>
								
								<div class="clearfix"></div>


								<div class="x_panel">
									<div class="x_title">
										<h2>Listado de Solicitudes Pendientes</h2>

										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">

										<table id="tabla_solicitudes" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>	
													<th>Año</th>		
													<th>Semana</th>		
													<th>Día</th>
													<th>Nro Solicitud</th>
													<th>Solicitante</th>
													<th>Unidad</th>
													<th>Destinatario</th>
													<th>Cód Unidad</th>
													<th>Cód Destinatario</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
							
							
							
							
							
<!--
		TAB SOLICITUDES ACEPTADAS
-->
							
							
							
							
							<div class="tab-pane fade" id="tab2primary">
						
								<div class="x_content">
									<br />
									<input type="hidden" id="h_asprod_id" value="" />

									<div class="form-group">
										<label class="col-sm-12">NRO DE SOLICITUD</label>
										
										<div class="col-sm-2">
											<input type="text" id="asprod_id" class="form-control">							
										</div>
										
										<div class="col-sm-4">
											<select class="select2_single form-control" tabindex="-1" id="ausr_solic">	
											<option value="">TODOS</option>
											</select>								
											<div class="help">Solicitante</div>
										</div>												
										
										
										<button id="btn_cons_aceptadas" type="button" class="btn btn-success">Consultar</button>
										<img src="images/loading.gif" id="aloading" style="display:none">
																						
																									
									</div>									
							
									<div class="form-group">
										<label class="col-sm-12">DIA DE SOLICITUD</label>
										
										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="aper_agno">	
											</select>								
											<div class="help">Año</div>
										</div>
										<div class="col-sm-4">
											<select class="select2_single form-control" tabindex="-1" id="asem_num">
											<option value="">TODOS</option>
											</select>								
											<div class="help">Semana</div>
										</div>		
										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="asprod_dia">
												<option value="">TODOS</option>
											</select>
											<div class="help">Día</div>
										</div>	
									</div>
									
									<div class="clearfix"></div>
									
									<div class="form-group">
										<label class="col-xs-12">DATOS SOLICITUD</label>
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="aUNDVIV_ID">	
												<option value="">TODOS</option>
											</select>								
											<div class="help">Unidad</div>
										</div>
										<div class="col-sm-5">
											<select class="select2_single form-control" tabindex="-1" id="asprod_id_dest">	
												<option value="">TODOS</option>
											</select>								
											<div class="help">Destinatario: Operador/Administrativo</div>
										</div>

									</div>									
									
									<div class="clearfix"></div>	
									<div class="ln_solid"></div>
									<div class="clearfix"></div>									
									
									<div id="resolucion" style="display:none2">
									
										<div class="panel with-nav-tabs panel-primary">
											<div class="panel-heading">
													<ul class="nav nav-tabs">
														<li class="active"><a href="#tab2primary" data-toggle="tab">RESOLUCIÓN SOLICITUD</a></li>
													</ul>
											</div>
											<div class="panel-body" id="productos_solictar">
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab2primary">
														<div class="form-group">
										
															<label class="col-xs-12">DATOS INFORMADO DE ENTREGA</label>

															<div class="form-group col-sm-2">
																<div class="inner-addon left-addon">
																	<i class="glyphicon glyphicon-calendar form-control-feedback  fa fa-calendar"></i>
																	<input type="text" id="asprod_dentrega" class="form-control" value="" style="cursor:pointer">								
																	<div class="help">Fecha entrega</div>
																</div>	
															</div>	
															<div class="col-sm-2">
															<select class="select2_single form-control" tabindex="-1" id="asprod_hentrega">
																<option value="08:00" selected>08:00</option><option value="08:30">08:30</option><option value="09:00">09:00</option><option value="09:30">09:30</option>
																<option value="10:00">10:00</option><option value="10:30">10:30</option><option value="11:00">11:00</option><option value="11:30">11:30</option>
																
																<option value="12:00">12:00</option><option value="12:30">12:30</option><option value="13:00">13:00</option><option value="13:30">13:30</option>
																<option value="14:00">14:00</option><option value="14:30">14:30</option><option value="15:00">15:00</option><option value="15:30">15:30</option>
																<option value="16:00">16:00</option><option value="16:30">16:30</option><option value="17:00">17:00</option><option value="17:30">17:30</option>
																<option value="18:00">18:00</option><option value="18:30">18:30</option><option value="19:00">19:00</option><option value="19:30">19:30</option>
																<option value="20:00">20:00</option><option value="20:30">20:30</option><option value="21:00">21:00</option><option value="21:30">21:30</option>
																<option value="22:00">22:00</option><option value="22:30">22:30</option><option value="23:00">23:00</option><option value="23:30">23:30</option>

															</select>
																<div class="help">Hora entrega</div>
															</div>	

														</div>										
														
														<div class="form-group">
															<label class="col-xs-12">COMENTARIO RESOLUCIÓN</label>									
															<div class="col-md-8 col-sm-8 col-xs-12">
																<textarea class="form-control" rows="3" id="asprod_comentario"></textarea>
															</div>									
														</div>		
														
														<div class="form-group">
															<div class="col-xs-12">
																<br>
																<button id="btn_mod_solicitud" type="button" class="btn btn-success">Modificar Solicitud</button>
																<button id="btn_rech_solicitud" type="button" class="btn btn-success">Rechazar Solicitud</button>
																<br>								
																<img src="images/loading.gif" id="aaloading" style="display:none">	
															</div>
														</div>															
														
														<div class="clearfix"></div>	<br>

														<div class="panel with-nav-tabs panel-primary">
															<div class="panel-heading">
																	<ul class="nav nav-tabs">
																		<li class="active"><a href="#tab2primary" data-toggle="tab">MATERIALES SOLICITADOS</a></li>
																	</ul>
															</div>														
															<div class="panel-body" id="productos_aceptar">
																<div class="tab-content">
																	<div class="tab-pane fade in active" id="tab2primary">
																	
																	
																		<div class="table-responsive">
																			<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
																				<thead>
																					<tr>	
																						<th style="text-align:center; width:70px">Aceptado</th>
																						<th style="display:none">Categoría</th>
																						<th>Material</th>
																						<th style="text-align:center; width:120px">Stock</th>	
																						<th style="text-align:center; width:120px">Cant Solicitada</th>		
																						<th style="text-align:center; width:120px">Cant Aceptada</th>	
																					</tr>
																				</thead>
																				
																				<tbody id="productos_aceptados">

																				</tbody>
																			</table>
																		</div>														
																	
																												
																	</div>
																</div>
															</div>														
														</div>		
														
		
														<div class="form-group">
															<label class="col-xs-12">ENTREGAR SOLICITUD</label>
															
															<div class="col-sm-5">
																<select class="select2_single form-control" tabindex="-1" id="asprod_id_retira">	
																	<option value="">SELECCIONE QUIEN RETIRA</option>
																</select>								
																<div class="help">Quien Retira</div>
															</div>
															
															<div class="form-group col-sm-2">
																<div class="inner-addon left-addon">
																	<i class="glyphicon glyphicon-calendar form-control-feedback  fa fa-calendar"></i>
																	<input type="text" id="asprod_drentrega" class="form-control" value="" style="cursor:pointer">								
																	<div class="help">Fecha real entrega</div>
																</div>	
															</div>	
															<div class="col-sm-2">
															<select class="select2_single form-control" tabindex="-1" id="asprod_hrentrega">	
																<option value="08:00" selected>08:00</option><option value="08:30">08:30</option><option value="09:00">09:00</option><option value="09:30">09:30</option>
																<option value="10:00">10:00</option><option value="10:30">10:30</option><option value="11:00">11:00</option><option value="11:30">11:30</option>
																
																<option value="12:00">12:00</option><option value="12:30">12:30</option><option value="13:00">13:00</option><option value="13:30">13:30</option>
																<option value="14:00">14:00</option><option value="14:30">14:30</option><option value="15:00">15:00</option><option value="15:30">15:30</option>
																<option value="16:00">16:00</option><option value="16:30">16:30</option><option value="17:00">17:00</option><option value="17:30">17:30</option>
																<option value="18:00">18:00</option><option value="18:30">18:30</option><option value="19:00">19:00</option><option value="19:30">19:30</option>
																<option value="20:00">20:00</option><option value="20:30">20:30</option><option value="21:00">21:00</option><option value="21:30">21:30</option>
																<option value="22:00">22:00</option><option value="22:30">22:30</option><option value="23:00">23:00</option><option value="23:30">23:30</option>

															</select>
																<div class="help">Hora real entrega</div>
															</div>											
															
															<div class="col-sm-2">
																<button id="btn_entrega_prod" type="button" class="btn btn-success">Entregar Materiales</button>
															</div>
														</div>	
		
		
														
													</div>
												</div>
											</div>
										</div>										
											
										<div class="clearfix"></div>	
										<div class="ln_solid"></div>
										<div class="clearfix"></div>	
									</div>

									<div class="x_panel">
										<div class="x_title">
											<h2>Listado de Solicitudes Aceptadas</h2>

											<ul class="nav navbar-right panel_toolbox">
												<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											</ul>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">

											<table id="tabla_solicitudes_aceptadas" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
												<thead>
													<tr>	
														<th>Año</th>		
														<th>Semana</th>		
														<th>Día</th>
														<th>Nro Solicitud</th>
														<th>Solicitante</th>
														<th>Unidad</th>
														<th>Destinatario</th>
														<th>Día/Hora Entrega</th>
														<th>Día/Hora Entrega Real</th>
														<th>Quien Retira</th>
														<th>Comentario</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>									
								</div>								
							</div>	
							

							
							
							
							
<!--
		TAB SOLICITUDES RECHAZADAS
-->
							
							
							
							
							<div class="tab-pane fade" id="tab3primary">
								<input type="hidden" id="h_rsprod_id" value="" />
								<div class="x_content">
									<br />

									<div class="form-group">
										<label class="col-sm-12">NRO DE SOLICITUD</label>
										
										<div class="col-sm-2">
											<input type="text" id="rsprod_id" class="form-control">							
										</div>
										
										<div class="col-sm-4">
											<select class="select2_single form-control" tabindex="-1" id="rusr_solic">	
											<option value="">TODOS</option>
											</select>								
											<div class="help">Solicitante</div>
										</div>												
										
										
										<button id="btn_cons_rechazadas" type="button" class="btn btn-success">Consultar</button>
										<img src="images/loading.gif" id="rloading" style="display:none">
																						
																									
									</div>									
							
									<div class="form-group">
										<label class="col-sm-12">DIA DE SOLICITUD</label>
										
										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="rper_agno">	
											</select>								
											<div class="help">Año</div>
										</div>
										<div class="col-sm-4">
											<select class="select2_single form-control" tabindex="-1" id="rsem_num">
											<option value="">TODOS</option>
											</select>								
											<div class="help">Semana</div>
										</div>		
										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="rsprod_dia">
												<option value="">TODOS</option>
											</select>
											<div class="help">Día</div>
										</div>	
									</div>
									
									<div class="clearfix"></div>
									
									<div class="form-group">
										<label class="col-xs-12">DATOS SOLICITUD</label>
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="rUNDVIV_ID">	
												<option value="">TODOS</option>
											</select>								
											<div class="help">Unidad</div>
										</div>
										<div class="col-sm-5">
											<select class="select2_single form-control" tabindex="-1" id="rsprod_id_dest">	
												<option value="">TODOS</option>
											</select>								
											<div class="help">Destinatario: Operador/Administrativo</div>
										</div>

									</div>									
									
									<div class="clearfix"></div>	
									<div class="ln_solid"></div>
									<div class="clearfix"></div>									
									
									<div id="resolucion" style="display:none2">
									
										<div class="panel with-nav-tabs panel-primary">
											<div class="panel-heading">
													<ul class="nav nav-tabs">
														<li class="active"><a href="#tab3primary" data-toggle="tab">RESOLUCIÓN SOLICITUD</a></li>
													</ul>
											</div>
											<div class="panel-body" id="productos_rechazar">
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab3primary">
								
														
														<div class="form-group">
															<label class="col-xs-12">COMENTARIO RESOLUCIÓN</label>									
															<div class="col-md-8 col-sm-8 col-xs-12">
																<textarea class="form-control" rows="3" id="rsprod_comentario" disabled></textarea>
															</div>									
														</div>		
														
														<div class="clearfix"></div>	<br>
														
														<div class="x_panel">
															<div class="x_title">
																<h2>Detalle Materiales Solicitados</h2>

																<ul class="nav navbar-right panel_toolbox">
																	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
																</ul>
																<div class="clearfix"></div>
															</div>
															<div class="x_content">

																<table id="productos_solicitados_rechazados" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
																	<thead>
																		<tr>	
																			<th>Categoría</th>
																			<th>Material</th>
																			<th>Cant Solicitada</th>		
																		</tr>
																	</thead>
																</table>
															</div>
														</div>	
														
														<div class="clearfix"></div><br>
														<button id="btn_cambiar_resol" type="button" class="btn btn-success">Cambiar Resolución -> Pendiente</button>
														<img src="images/loading.gif" id="rrloading" style="display:none">	
													</div>
												</div>
											</div>
										</div>										
											
										<div class="clearfix"></div>	
										<div class="ln_solid"></div>
										<div class="clearfix"></div>	
									</div>

									<div class="x_panel">
										<div class="x_title">
											<h2>Listado de Solicitudes Rechazadas</h2>

											<ul class="nav navbar-right panel_toolbox">
												<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											</ul>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">

											<table id="tabla_solicitudes_rechazadas" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
												<thead>
													<tr>	
														<th>Año</th>		
														<th>Semana</th>		
														<th>Día</th>
														<th>Nro Solicitud</th>
														<th>Solicitante</th>
														<th>Unidad</th>
														<th>Destinatario</th>
														<th>Comentario</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>									
								</div>
							</div>								
							
							
		
		
		
							
<!--
		TAB SOLICITUDES ENTREGADAS
-->
							
							
							
							
							<div class="tab-pane fade" id="tab4primary">
							
								<input type="hidden" id="h_esprod_id" value="" />
								
								<div class="x_content">
									<br />

									<div class="form-group">
										<label class="col-sm-12">NRO DE SOLICITUD</label>
										
										<div class="col-sm-2">
											<input type="text" id="esprod_id" class="form-control">							
										</div>
										
										<div class="col-sm-4">
											<select class="select2_single form-control" tabindex="-1" id="eusr_solic">	
											<option value="">TODOS</option>
											</select>								
											<div class="help">Solicitante</div>
										</div>												
										
										
										<button id="btn_cons_entregadas" type="button" class="btn btn-success">Consultar</button>
										<img src="images/loading.gif" id="eloading" style="display:none">
																						
																									
									</div>									
							
									<div class="form-group">
										<label class="col-sm-12">DIA DE SOLICITUD</label>
										
										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="eper_agno">	
											</select>								
											<div class="help">Año</div>
										</div>
										<div class="col-sm-4">
											<select class="select2_single form-control" tabindex="-1" id="esem_num">
											<option value="">TODOS</option>
											</select>								
											<div class="help">Semana</div>
										</div>		
										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="esprod_dia">
												<option value="">TODOS</option>
											</select>
											<div class="help">Día</div>
										</div>	
									</div>
									
									<div class="clearfix"></div>
									
									<div class="form-group">
										<label class="col-xs-12">DATOS SOLICITUD</label>
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="eUNDVIV_ID">	
												<option value="">TODOS</option>
											</select>								
											<div class="help">Unidad</div>
										</div>
										<div class="col-sm-5">
											<select class="select2_single form-control" tabindex="-1" id="esprod_id_dest">	
												<option value="">TODOS</option>
											</select>								
											<div class="help">Destinatario: Operador/Administrativo</div>
										</div>

									</div>			
									
									<div class="form-group" style="display:none">
										<label class="col-xs-12">DATOS MATERIALES</label>
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="catprod_id">	
												<option value="" selected>TODOS</option>
											</select>								
											<div class="help">Categoría</div>
										</div>
										<div class="col-sm-5">
											<select class="select2_single form-control" tabindex="-1" id="prod_cod">	
												<option value="" selected>TODOS</option>
											</select>								
											<div class="help">Material</div>
										</div>

									</div>											
									
									<div class="clearfix"></div>	
									<div class="ln_solid"></div>
									<div class="clearfix"></div>									
									
									<div id="resolucion" style="display:none2">
									
										<div class="panel with-nav-tabs panel-primary">
											<div class="panel-heading">
													<ul class="nav nav-tabs">
														<li class="active"><a href="#tab4primary" data-toggle="tab">SOLICITUD ENTREGADA</a></li>
													</ul>
											</div>
											<div class="panel-body" id="productos_rechazar">
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab4primary">

														<div class="form-group">
															<label class="col-xs-12">COMENTARIO RESOLUCIÓN</label>									
															<div class="col-md-8 col-sm-8 col-xs-12">
																<textarea class="form-control" rows="3" id="esprod_comentario" disabled></textarea>
															</div>									
														</div>	

														<div class="clearfix"></div>	<br>
														
														<div class="x_panel">
															<div class="x_title">
																<h2>Detalle Materiales Entregados</h2>

																<ul class="nav navbar-right panel_toolbox">
																	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
																</ul>
																<div class="clearfix"></div>
															</div>
															<div class="x_content">

																<table id="productos_solicitados_entregados" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
																	<thead>
																		<tr>	
																		<th>Resolución</th>
																		<th>Categoría</th>
																		<th>Material</th>
																		<th>Cant Solicitada</th>		
																		<th>Cant Aceptada</th>
																		</tr>
																	</thead>
																</table>
															</div>
														</div>	
														<button id="ebtn_acta_entrega" type="button" class="btn btn-success" style="display:none">Acta Entrega</button>
													</div>
												</div>
											</div>
										</div>										
											
										<div class="clearfix"></div>	
										<div class="ln_solid"></div>
										<div class="clearfix"></div>	
									</div>

									<div class="x_panel">
										<div class="x_title">
											<h2>Listado de Solicitudes Entregadas</h2>

											<ul class="nav navbar-right panel_toolbox">
												<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											</ul>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">

											<table id="tabla_solicitudes_entregadas" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
												<thead>
													<tr>	
														<th>Año</th>		
														<th>Semana</th>		
														<th>Día</th>
														<th>Nro Solicitud</th>
														<th>Solicitante</th>
														<th>Unidad</th>
														<th>Destinatario</th>
														<th>Día/Hora Entrega</th>
														<th>Día/Hora Real Entrega</th>
														<th>Quien Retiró</th>
														<th>Comentario</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>									
								</div>
							</div>					
									

									
									
									
									
									
									
							
<!--
		TAB SALIDAS DE BODEGA
-->									
									
									
									
									
									
							<div class="tab-pane fade" id="tab5primary">
							
								<div class="x_content">
									<br />	
									
									<div class="form-group" id="nro_solicitud">
										<label class="col-sm-12">NRO DE SOLICITUD</label>										
										<div class="col-sm-2">
											<input type="text" id="ssprod_id" class="form-control" disabled>							
										</div>
										
										<div class="col-sm-4">
											<select class="select2_single form-control" tabindex="-1" id="susr_solic">	
												<option value="">SELECCIONE SOLICITANTE</option>
											</select>								
											<div class="help">Solicitante</div>
										</div>											
										
									</div>									
							
									<div class="form-group">
										<label class="col-sm-12">DIA DE SOLICITUD</label>
										
										<div class="col-sm-2"<?php if ($_SESSION['USR_TIPO'] <> 'ADMINISTRADOR'){ ?> style="display:none" <?php } ?>>
											<select class="select2_single form-control" tabindex="-1" id="sper_agno">	
											</select>								
											<div class="help">Año</div>
										</div>
										<div class="col-sm-4"<?php if ($_SESSION['USR_TIPO'] <> 'ADMINISTRADOR'){ ?> style="display:none" <?php } ?>>
											<select class="select2_single form-control" tabindex="-1" id="ssem_num">	
											</select>								
											<div class="help">Semana</div>
										</div>		
										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="ssprod_dia"<?php if ($_SESSION['USR_TIPO'] <> 'ADMINISTRADOR'){ ?> disabled <?php } ?>></select>
											<div class="help">Día</div>
										</div>	
									</div>
									
									<div class="clearfix"></div>
									
									<div class="form-group">
										<label class="col-xs-12">DATOS SOLICITUD</label>
																				
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="sUNDVIV_ID">	
												<option value="">SELECCIONE UNIDAD</option>
											</select>								
											<div class="help">Unidad</div>
										</div>
										<div class="col-sm-5" id="destinatario_unico">
											<select class="select2_single form-control" tabindex="-1" id="ssprod_id_dest">	
												<option value="">SELECCIONE DESTINATARIO</option>
											</select>								
											<div class="help">Destinatario: Operador/Administrativo</div>
										</div>

									</div>
									
									<div class="form-group">
										<label class="col-xs-12">ENTREGAR SOLICITUD</label>
										
										<div class="col-sm-4">
											<select class="select2_single form-control" tabindex="-1" id="ssprod_id_retira">	
												<option value="">SELECCIONE QUIEN RETIRA</option>
											</select>								
											<div class="help">Quien Retira</div>
										</div>
										
										<div class="form-group col-sm-2">
											<div class="inner-addon left-addon">
												<i class="glyphicon glyphicon-calendar form-control-feedback  fa fa-calendar"></i>
												<input type="text" id="ssprod_drentrega" class="form-control" value="" style="cursor:pointer">								
												<div class="help">Fecha real entrega</div>
											</div>	
										</div>	
										<div class="col-sm-2">
										<select class="select2_single form-control" tabindex="-1" id="ssprod_hrentrega">
											<option value="08:00" selected>08:00</option><option value="08:30">08:30</option><option value="09:00">09:00</option><option value="09:30">09:30</option>
											<option value="10:00">10:00</option><option value="10:30">10:30</option><option value="11:00">11:00</option><option value="11:30">11:30</option>
											
											<option value="12:00">12:00</option><option value="12:30">12:30</option><option value="13:00">13:00</option><option value="13:30">13:30</option>
											<option value="14:00">14:00</option><option value="14:30">14:30</option><option value="15:00">15:00</option><option value="15:30">15:30</option>
											<option value="16:00">16:00</option><option value="16:30">16:30</option><option value="17:00">17:00</option><option value="17:30">17:30</option>
											<option value="18:00">18:00</option><option value="18:30">18:30</option><option value="19:00">19:00</option><option value="19:30">19:30</option>
											<option value="20:00">20:00</option><option value="20:30">20:30</option><option value="21:00">21:00</option><option value="21:30">21:30</option>
											<option value="22:00">22:00</option><option value="22:30">22:30</option><option value="23:00">23:00</option><option value="23:30">23:30</option>

										</select>
											<div class="help">Hora real entrega</div>
										</div>		
										
										<button id="sbtn_updhead_sprod" type="button" class="btn btn-success" style="display:none">Modificar</button>
										<button id="sbtn_canupdhead_sprod" type="button" class="btn btn-success" style="display:none">Cancelar Modificación</button>										
										
									</div>										
									
									<div class="form-group">
										<div class="col-sm-7" id="destinatario_multiple" style="display:none">

											<select multiple class="form-control" tabindex="-1" id="ssprod_ids_dest">	
											</select>											
											<div class="help">Destinatario(s): Operadores/Administrativos</div>
										</div>	
										
										<div class="col-sm-5">
											<button id="sbtn_regrep_sprod" type="button" class="btn btn-success" style="display:none">Registrar Réplica</button>
											<button id="sbtn_canrep_sprod" type="button" class="btn btn-success" style="display:none">Cancelar Réplica</button>			
										</div>
									
									</div>									
									
									<div class="clearfix"></div>	
									<div class="ln_solid"></div>
									<div class="clearfix"></div>				

									<form id="sform_sprod" data-parsley-validate class="form-horizontal">	

										<input type="hidden" id="sh_susr_solic" value="" />
									
										<input type="hidden" id="sh_prod_cod" value="" />
										<input type="hidden" id="sh_flag_rowprod" value="" />										
										<input type="hidden" id="sh_UNDVIV_ID" value="" />
										<input type="hidden" id="sh_sprod_id_dest" value="" />

										<input type="hidden" id="sh_ssprod_id_retira" value="" />										
										<input type="hidden" id="sh_ssprod_drentrega" value="" />
										<input type="hidden" id="sh_ssprod_hrentrega" value="" />
										
									
										<div class="panel with-nav-tabs panel-primary">
											<div class="panel-heading">
													<ul class="nav nav-tabs">
														<li class="active"><a href="#tab5primary" data-toggle="tab">MATERIALES A SOLICITAR</a></li>
													</ul>
											</div>
											<div class="panel-body" id="sproductos_solicitar">
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab5primary">
														<div class="form-group">
															
															<div class="col-sm-3" style="display:none">
																<select class="select2_single form-control" tabindex="-1" id="scatprod_id">	
																	<option value="">SELECCIONE CATEGORIA</option>
																</select>								
																<div class="help">Categoría</div>
															</div>
															
															<div class="col-sm-4">
																<select class="select2_single form-control" tabindex="-1" id="sap_cod">
																<option value="">-</option>
																</select>
																<div class="help">Material SAP</div>
															</div>

															<div class="col-sm-4">
																<select class="select2_single form-control" tabindex="-1" id="sprod_cod">
																<option value="">-</option>
																</select>
																<div class="help">Material</div>
															</div>															
																										
															<div class="col-sm-1">
																<input type="text" id="ssprodd_cant" class="form-control" maxlength="10">		
																<div class="help">Cantidad</div>
															</div>		
															
															<button id="sbtn_reg_prod" type="button" class="btn btn-success">Registrar</button>
															<button id="sbtn_upd_prod" type="button" class="btn btn-success" style="display:none">Modificar</button>
															<button id="sbtn_del_prod" type="button" class="btn btn-success" style="display:none">Eliminar</button>
															<button id="sbtn_can_prod" type="button" class="btn btn-success" style="display:none">Cancelar</button>
															<br>								
															<img src="images/loading.gif" id="sloading" style="display:none">
															<span id="error" style="display:none; color:red" />																	
															
														</div>															
														
														<div class="x_panel">
														<div class="x_title">
															<h2>Listado de Materiales</h2>

															<ul class="nav navbar-right panel_toolbox">
																<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
															</ul>
															<div class="clearfix"></div>
														</div>
															<div class="x_content">
																<table id="stabla_productos" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
																	<thead>
																		<tr>
																		<th>Cód Categoría</th>
																		<th>Cód Material</th>																		
																		<th>Categoría</th>
																		<th>Material</th>

																		<th>SAP Cód</th>
																		<th>SAP Material</th>
																		
																		<th>Cantidad</th>
																		</tr>
																	</thead>																									
																</table>
															</div>
														</div>																										
													</div>
												</div>
											</div>
										</div>
																
										<div class="form-group">
												<button id="sbtn_can_sprod" type="button" class="btn btn-success" style="display:none">Cancelar</button>
												<button id="sbtn_rep_sprod" type="button" class="btn btn-success" style="display:none">Replicar</button>
												<button id="sbtn_del_sprod" type="button" class="btn btn-success" style="display:none">Eliminar</button>
												<button id="sbtn_upd_sprod" type="button" class="btn btn-success" style="display:none">Modificar Datos Solicitud</button>
												<button id="sbtn_acta_entrega" type="button" class="btn btn-success" style="display:none">Acta Entrega(Stock)</button>
												<button id="sbtn_acta_entregadoc" type="button" class="btn btn-success" style="display:none">Acta Entrega(Solo Doc)</button>
												<br>								
												<img src="images/loading.gif" id="sloading2" style="display:none">
												<span id="error2" style="display:none; color:red" />								
											
										</div>
									</form>	
																		
								</div>
								
								<div class="clearfix"></div>


								<div class="x_panel">
									<div class="x_title">
										<h2>Listado de Solicitudes Entregadas</h2>

										<ul class="nav navbar-right panel_toolbox">
											<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
										</ul>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">

										<table id="stabla_solicitudes" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>	
													<th>Año</th>		
													<th>Semana</th>		
													<th>Día</th>
													<th>Nro Solicitud</th>
													<th>Solicitante</th>
													<th>Unidad</th>
													<th>Destinatario</th>
													<th>Quien Retira</th>
													<th>Fecha Real Entrega</th>
													<th>Cód Unidad</th>
													<th>Cód Solicitante</th>
													<th>Cód Destinatario</th>
													<th>Cód Quien Retira</th>
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
		</div>
	</div>
</div>

</div>
<!-- /page content -->

<?php
include('footer.php');
?>