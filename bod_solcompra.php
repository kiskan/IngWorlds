<?php
include('header.php');

$plan_periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');

$viveros = 'carga inicial';
include('consultas/ges_crud_viveros.php');

$solicitantes = 'carga inicial';
include('consultas/ges_crud_usuarios.php');

$categoria = 'carga inicial';
include('consultas/bod_crud_catproducto.php');

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
	var data_categorias = <?php echo $load_categorias; ?>;
	var data_solicitantes = <?php echo $load_solicitantes; ?>;
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	var corresponding_week = <?php echo $corresponding_week; ?>;
	var corresponding_agno = <?php echo $corresponding_agno; ?>;
	
</script>

<script type="text/javascript" src="js/bod_solcompra.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-xs-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Solicitud Compra</h2>
					<div class="clearfix"></div>
				</div>
				
				
				<!-- Modal Cotización -->
				<div id="WModal_Cotizacion" class="modal fade">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
						<center>
							<div class="modal-header">
								<h4 id="title_cotizacion" class="modal-title">Cotizaciones (Seleccione 1)</h4>
								<h5 id="title_cotcant" class="modal-title">Cantidad</h4>
							</div>
							<div class="modal-body">		
								<div class="clearfix"></div><br>
								
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="x_panel">
										<div class="x_title">
											<h2>Cotizaciones</h2>
											<ul class="nav navbar-right panel_toolbox">
												<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											</ul>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">

											<table id="datatable-cotizaciones" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>ID Cotización</th>
														<th>Selec</th>
														<th>Proveedor</th>
														<th>Proveedor (Acortado)</th>
														<th>Precio</th>
														<th>Cantidad</th>
														<th>Total</th>
														<th>Total Acordado</th>
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
				
				
				
				
				
				<!-- Modal Compra -->
				<div id="WModal_Compra" class="modal fade">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
						<center>
							<div class="modal-header">
								<h4 id="title_compra" class="modal-title">Compra</h4>
								<h5 id="title_cant" class="modal-title">Cantidad</h4>
							</div>
							<div class="modal-body">
											
								<div class="clearfix"></div><br>
								
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="x_panel">
										<div class="x_title">
											<h2>Compra</h2>
											<ul class="nav navbar-right panel_toolbox">
												<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											</ul>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">

											<table id="datatable-compra" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>ID Compra</th>
														<th>Cód HES</th>
														<th>Proveedor<br>(Acortado)</th>
														<th>Proveedor</th>														
														<th>Fecha Entrega</th>
														<th>Precio</th>
														<th>Cantidad</th>
														<th>Total</th>														
														<th>Total<br>Acordado</th>
														<th>% Avance<br>Servicio</th>
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
				
				
				
				
				
				
				
				
				
				
				
					
				<div class="panel with-nav-tabs panel-primary">
					<div class="panel-heading">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab1primary" data-toggle="tab">SOLICITUDES</a></li>										
								<li><a href="#tab2primary" data-toggle="tab">EN PROCESO</a></li>
								<li><a href="#tab3primary" data-toggle="tab">TERMINADAS</a></li>
							</ul>
					</div>
					<div class="panel-body">
						<div class="tab-content">
						
							<div class="tab-pane fade in active" id="tab1primary">
							
								<div class="x_content">
									<br />	
									
									<div class="form-group" id="nro_solicitud" style="display:none">
										<label class="col-sm-12">NRO DE SOLICITUD</label>										
											<div class="col-sm-2">
												<input type="text" id="sprod_id" class="form-control" disabled>							
											</div>
											<button id="btn_pdf_solcompra" type="button" class="btn btn-success" style="display:none">Documento Solicitud Compra</button>
									</div>									
							
									<div class="form-group">
										<label class="col-sm-12">DIA DE SOLICITUD</label>
										
										<div class="col-sm-2"<?php if ($_SESSION['USR_TIPO'] <> 'ADMINISTRADOR' AND $_SESSION['USR_TIPO'] <> 'JEFE BODEGA'){ ?> style="display:none" <?php } ?>>
											<select class="select2_single form-control" tabindex="-1" id="per_agno">	
											</select>								
											<div class="help">Año</div>
										</div>
										<div class="col-sm-4"<?php if ($_SESSION['USR_TIPO'] <> 'ADMINISTRADOR' AND $_SESSION['USR_TIPO'] <> 'JEFE BODEGA'){ ?> style="display:none" <?php } ?>>
											<select class="select2_single form-control" tabindex="-1" id="sem_num">	
											</select>								
											<div class="help">Semana</div>
										</div>		
										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="sprod_dia"<?php if ($_SESSION['USR_TIPO'] <> 'ADMINISTRADOR' AND $_SESSION['USR_TIPO'] <> 'JEFE BODEGA'){ ?> disabled <?php } ?>></select>
											<div class="help">Día</div>
										</div>	
										
										<button id="btn_updhead_sprod" type="button" class="btn btn-success" style="display:none">Modificar</button>
										<button id="btn_canupdhead_sprod" type="button" class="btn btn-success" style="display:none">Cancelar Modificación</button>										
										
									</div>
									
									<div class="clearfix"></div>
									
									<div class="form-group">
										<label class="col-xs-12">DATOS SOLICITUD (<span id="sem_txt"></span>)</label>
										
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="UNDVIV_ID">	
												<option value="">SELECCIONE UNIDAD</option>
											</select>								
											<div class="help">Unidad</div>
										</div>		
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="sprod_tipocompra">	
												<option value="">SELEC. TIPO COMPRA</option>
												<option value="COMPRA MATERIAL">COMPRA MATERIAL</option>
												<option value="PRESTACIÓN SERVICIO">PRESTACIÓN SERVICIO</option>
											</select>								
											<div class="help">Tipo Compra</div>
										</div>
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="sprod_prioridad">	
												<option value="">SELEC. PRIORIDAD</option>
												<option value="NORMAL">NORMAL</option>
												<option value="URGENTE">URGENTE</option>
											</select>								
											<div class="help">Prioridad Trabajo</div>
										</div>	
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="sprod_tipomant">	
												<option value="">SELEC. TIPO MANT</option>
												<option value="PREVENTIVO">PREVENTIVO</option>
												<option value="CORRECTIVO">CORRECTIVO</option>
												<option value="PRODUCTIVO">PRODUCTIVO</option>
											</select>								
											<div class="help">Tipo Mantenimiento</div>
										</div>										

									</div>
									
									<div class="form-group">
										<label class="col-xs-12">MOTIVO COMPRA</label>									
										<div class="col-md-8 col-sm-8 col-xs-12">
											<textarea class="form-control" rows="3" id="sprod_motivo" ></textarea>
										</div>	
										
										<button id="btn_pdf_solcompra" type="button" class="btn btn-success" style="display:none">Documento Solicitud Compra</button>
										
									</div>										
									
									<div class="clearfix"></div>	
									<div class="ln_solid"></div>
									<div class="clearfix"></div>				

									<form id="form_sprod" data-parsley-validate class="form-horizontal">	

										<input type="hidden" id="h_prod_cod" value="" />
										<input type="hidden" id="h_sprodd_servicio" value="" />
										<input type="hidden" id="h_flag_rowprod" value="" />										
										<input type="hidden" id="h_UNDVIV_ID" value="" />
										<input type="hidden" id="h_sprodd_id" value="" />
										
										<input type="hidden" id="h_sprod_tipocompra" value="" />
										<input type="hidden" id="h_sprod_prioridad" value="" />
										<input type="hidden" id="h_sprod_tipomant" value="" />
										<input type="hidden" id="h_sprod_motivo" value="" />
									
										<div class="panel with-nav-tabs panel-primary">
											<div class="panel-heading">
													<ul class="nav nav-tabs">
														<li class="active"><a href="#tab1primary" data-toggle="tab">MATERIALES/SERVICIOS A SOLICITAR</a></li>
													</ul>
											</div>
											<div class="panel-body" id="productos_solictar">
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab1primary">
														<div class="form-group">
														
															<div id="div_materiales">
																<div class="col-sm-3">
																	<select class="select2_single form-control" tabindex="-1" id="catprod_id">	
																		<option value="">SELECCIONE CATEGORIA</option>
																	</select>								
																	<div class="help">Categoría</div>
																</div>
																
																<div class="col-sm-4">
																	<select class="select2_single form-control" tabindex="-1" id="prod_cod">
																	<option value="">SELECCIONE MATERIAL</option>
																	</select>																	
																	<div class="help">Material</div>
																</div>											
																											
																<div class="col-sm-1">
																	<input type="text" id="sprodd_cant" class="form-control" maxlength="10">							
																	<div class="help">Cantidad</div>
																</div>		
															</div>	
															<div id="div_servicios" style="display:none">
																
																<div class="col-sm-6">
																	<!--<input type="text" id="sprodd_servicio" class="form-control" maxlength="100">	-->
																	<textarea class="form-control" rows="3" id="sprodd_servicio" ></textarea>														
																	<div class="help">Servicio</div>
																</div>										
																											
																<div class="col-sm-1"><br /><br />
																	<input type="text" id="sprodd_plazo" class="form-control" maxlength="10"> 
																	<div class="help">Plazo</div>
																</div><br /><br />	<label style="position:absolute;margin-top:15px">días</label>	
																															
																<div class="clearfix"></div><br />
															</div>																	
																															
															<div class="clearfix"></div><br />
															
															<button id="btn_reg_prod" type="button" class="btn btn-success">Registrar</button>
															<button id="btn_upd_prod" type="button" class="btn btn-success" style="display:none">Modificar</button>
															<button id="btn_del_prod" type="button" class="btn btn-success" style="display:none">Eliminar</button>
															<button id="btn_can_prod" type="button" class="btn btn-success" style="display:none">Cancelar</button>

															<br>								
															<img src="images/loading.gif" id="loading" style="display:none">												
															
														</div>															
														
														<div class="x_panel">
														<div class="x_title">
															<h2>Listado de Materiales Solicitados</h2>

															<ul class="nav navbar-right panel_toolbox">
																<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
															</ul>
															<div class="clearfix"></div>
														</div>
															<div class="x_content">
																<table id="tabla_productos" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
																	<thead>
																		<tr>
																		<th>Cód Detalle</th>
																		<th>Cód Categoría</th>
																		<th>Cód Material</th>																		
																		<th>Categoría</th>
																		<th>Material / Servicio</th>
																		<th>Material / Servicio (Acortado)</th>
																		<th>Cantidad/Plazo</th>	
																		<th>Precio Ref.</th>
																		<th>Total</th>																		
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
												<button id="btn_can_sprod" type="button" class="btn btn-success" style="display:none">Cancelar</button>
												<button id="btn_del_sprod" type="button" class="btn btn-success" style="display:none">Eliminar</button>
												<button id="btn_upd_sprod" type="button" class="btn btn-success" style="display:none">Modificar Datos Solicitud</button>
												<br>								
												<img src="images/loading.gif" id="loading2" style="display:none">
												<span id="error2" style="display:none; color:red" />								
											
										</div>
									</form>	
																		
								</div>
								
								<div class="clearfix"></div>


								<div class="x_panel">
									<div class="x_title">
										<h2>Listado Solicitudes de Compra</h2>

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
													<th>Tipo Compra</th>
													<th>Prioridad Trabajo</th>
													<th>Tipo Mantenimiento</th>
													<th>Motivo Compra</th>
													<th>Cód Unidad</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>						
							
							
							
							
							
<!--
		TAB SOLICITUDES EN PROCESO
-->
							
							
							
							
							<div class="tab-pane fade" id="tab2primary">
						
								<div class="x_content">
									<br />
									<input type="hidden" id="h_esprod_id" value="" />
									<input type="hidden" id="h_esprod_tipocompra" value="" />
									<div class="form-group">
										<label class="col-sm-12">NRO DE SOLICITUD</label>
										
										<div class="col-sm-2">
											<input type="text" id="esprod_id" class="form-control">							
										</div>
										<!--
										<div class="col-sm-2">
											<input type="text" id="esprod_codigosap" class="form-control">	
											<div class="help">Código SAP</div>
										</div>			
										-->
										<div class="col-sm-4">
											<select class="select2_single form-control" tabindex="-1" id="eusr_solic">	
											<option value="">TODOS</option>
											</select>								
											<div class="help">Solicitante</div>
										</div>												
										
										
										<button id="btn_cons_enproceso" type="button" class="btn btn-success">Consultar</button>
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
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="esprod_tipocompra">	
												<option value="">SELEC. TIPO COMPRA</option>
												<option value="COMPRA MATERIAL">COMPRA MATERIAL</option>
												<option value="PRESTACIÓN SERVICIO">PRESTACIÓN SERVICIO</option>
											</select>								
											<div class="help">Tipo Compra</div>
										</div>
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="esprod_prioridad">	
												<option value="">SELEC. PRIORIDAD</option>
												<option value="NORMAL">NORMAL</option>
												<option value="URGENTE">URGENTE</option>
											</select>								
											<div class="help">Prioridad Trabajo</div>
										</div>	
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="esprod_tipomant">	
												<option value="">SELEC. TIPO MANT</option>
												<option value="PREVENTIVO">PREVENTIVO</option>
												<option value="CORRECTIVO">CORRECTIVO</option>
												<option value="PRODUCTIVO">PRODUCTIVO</option>
											</select>								
											<div class="help">Tipo Mantenimiento</div>
										</div>

									</div>									
									
									<div class="clearfix"></div>	
									<div class="ln_solid"></div>
									<div class="clearfix"></div>									
									
									<div id="resolucion" style="display:none2">
									
										<div class="panel with-nav-tabs panel-primary">
											<div class="panel-heading">
													<ul class="nav nav-tabs">
														<li class="active"><a href="#tab2primary" data-toggle="tab">COMPRA</a></li>
													</ul>
											</div>
											<div class="panel-body">
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab2primary">
								
														
														<div class="form-group">									
															<div class="col-md-4 col-sm-4 col-xs-12">
																<textarea class="form-control" rows="3" id="esprod_motivo" readonly></textarea>
																<div class="help">Motivo Compra</div>
															</div>			
															<div class="col-md-4 col-sm-4 col-xs-12">
																<textarea class="form-control" rows="3" id="esprod_comencotiz" readonly></textarea>
																<div class="help">Comentario Cotización</div>
															</div>	
															<div class="col-md-4 col-sm-4 col-xs-12">
																<textarea class="form-control" rows="3" id="esprod_comencompra" readonly></textarea>
																<div class="help">Comentario Compra</div>
															</div>																
														</div>			
														
														<div class="clearfix"></div>

														<div class="form-group">
															<div class="col-md-2 col-md-offset-10">
																<center>
																<input type="text" id="esprod_total" class="form-control text-center" style="font-weight:bold; font-size:20px;" disabled>
																<div class="help">TOTAL COMPRA</div>
																</center>
															</div>							
														</div>															
														
														<div class="clearfix"></div>	<br>
														
														
															<div class="panel-body">
																<div class="tab-content">
																	<div class="tab-pane fade in active" id="tab2primary">
																	
																		<div class="table-responsive">
																			<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
																				<thead>
																					<tr>
																						<th style="text-align:center; width:120px">Estado</th>	
																						<th>Material/Servicio</th>
																						<th style="text-align:center; width:120px">Cant Solicitada <br>o Días Plazo</th>	
																						<th style="text-align:center; width:250px">Cuenta Contable</th>
																						<th style="text-align:center;">Cotizaciones <br>(Aceptada)</th>
																						<th style="text-align:center; width:120px">Cant Entregada<br>o Días Plazo</th>	
																						<th style="text-align:center; width:120px">TOTAL</th>
																					</tr>
																				</thead>
																				
																				<tbody id="productos_enproceso">

																				</tbody>
																			</table>
																		</div>														
																	
																												
																	</div>
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
											<h2>Listado de Solicitudes en Proceso</h2>

											<ul class="nav navbar-right panel_toolbox">
												<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											</ul>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">

											<table id="tabla_solicitudes_enproceso" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
												<thead>
													<tr>	
													<th>Año</th>		
													<th>Semana</th>		
													<th>Día</th>
													<th>Nro Solicitud</th>
													<th>Solicitante</th>
													<th>Unidad</th>
													<th>Tipo Compra</th>
													<th>Prioridad Trabajo</th>
													<th>Tipo Mantenimiento</th>
													<th>Motivo Compra</th>
													<th>Comentario Cotización</th>
													<!--<th>Código SAP</th>-->
													<th>Comentario Compra</th>
													<th>Cód Unidad</th>
													<th>Cód Solicitante</th>
													</tr>
												</thead>
											</table>
										</div>
									</div>									
									

								</div>
								
								
							</div>	
							
							

							
							
							
							
							
							
							
<!--
		TAB SOLICITUDES TERMINADAS
-->
							
									
							<div class="tab-pane fade" id="tab3primary">
								<input type="hidden" id="h_tsprod_id" value="" />
								<div class="x_content">
									<br />

									<div class="form-group">
										<label class="col-sm-12">NRO DE SOLICITUD</label>
										
										<div class="col-sm-2">
											<input type="text" id="tsprod_id" class="form-control">							
										</div>
										<!--
										<div class="col-sm-2">
											<input type="text" id="tsprod_codigosap" class="form-control">	
											<div class="help">Código SAP</div>
										</div>		
										-->
										<div class="col-sm-4">
											<select class="select2_single form-control" tabindex="-1" id="tusr_solic">	
											<option value="">TODOS</option>
											</select>								
											<div class="help">Solicitante</div>
										</div>												
										
										
										<button id="btn_cons_terminados" type="button" class="btn btn-success">Consultar</button>
										<img src="images/loading.gif" id="tloading" style="display:none">
																						
																									
									</div>									
							
									<div class="form-group">
										<label class="col-sm-12">DIA DE SOLICITUD</label>
										
										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="tper_agno">	
											</select>								
											<div class="help">Año</div>
										</div>
										<div class="col-sm-4">
											<select class="select2_single form-control" tabindex="-1" id="tsem_num">
											<option value="">TODOS</option>
											</select>								
											<div class="help">Semana</div>
										</div>		
										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="tsprod_dia">
												<option value="">TODOS</option>
											</select>
											<div class="help">Día</div>
										</div>	
									</div>
									
									<div class="clearfix"></div>
									
									<div class="form-group">
										<label class="col-xs-12">DATOS SOLICITUD</label>
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="tUNDVIV_ID">	
												<option value="">TODOS</option>
											</select>								
											<div class="help">Unidad</div>
										</div>
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="tsprod_tipocompra">	
												<option value="">SELEC. TIPO COMPRA</option>
												<option value="COMPRA MATERIAL">COMPRA MATERIAL</option>
												<option value="PRESTACIÓN SERVICIO">PRESTACIÓN SERVICIO</option>
											</select>								
											<div class="help">Tipo Compra</div>
										</div>
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="tsprod_prioridad">	
												<option value="">SELEC. PRIORIDAD</option>
												<option value="NORMAL">NORMAL</option>
												<option value="URGENTE">URGENTE</option>
											</select>								
											<div class="help">Prioridad Trabajo</div>
										</div>	
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="tsprod_tipomant">	
												<option value="">SELEC. TIPO MANT</option>
												<option value="PREVENTIVO">PREVENTIVO</option>
												<option value="CORRECTIVO">CORRECTIVO</option>
												<option value="PRODUCTIVO">PRODUCTIVO</option>
											</select>								
											<div class="help">Tipo Mantenimiento</div>
										</div>

									</div>									
									
									<div class="clearfix"></div>	
									<div class="ln_solid"></div>
									<div class="clearfix"></div>									
									
									<div id="resolucion" style="display:none2">
									
										<div class="panel with-nav-tabs panel-primary">
											<div class="panel-heading">
													<ul class="nav nav-tabs">
														<li class="active"><a href="#tab3primary" data-toggle="tab">COMPRA</a></li>
													</ul>
											</div>
											<div class="panel-body">
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab3primary">
								
														
														<div class="form-group">									
															<div class="col-md-4 col-sm-4 col-xs-12">
																<textarea class="form-control" rows="3" id="tsprod_motivo" readonly></textarea>
																<div class="help">Motivo Compra</div>
															</div>			
															<div class="col-md-4 col-sm-4 col-xs-12">
																<textarea class="form-control" rows="3" id="tsprod_comencotiz" readonly></textarea>
																<div class="help">Comentario Cotización</div>
															</div>	
															<div class="col-md-4 col-sm-4 col-xs-12">
																<textarea class="form-control" rows="3" id="tsprod_comencompra" readonly></textarea>
																<div class="help">Comentario Compra</div>
															</div>																
														</div>			
														
														<div class="clearfix"></div>

														<div class="form-group">
															<div class="col-md-2 col-md-offset-10">
																<center>
																<input type="text" id="tsprod_total" class="form-control text-center" style="font-weight:bold; font-size:20px;" disabled>
																<div class="help">TOTAL COMPRA</div>
																</center>
															</div>							
														</div>															
														
														<div class="clearfix"></div>	<br>
														
														
															<div class="panel-body">
																<div class="tab-content">
																	<div class="tab-pane fade in active" id="tab3primary">
																	
																		<div class="table-responsive">
																			<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
																				<thead>
																					<tr>
																						<th style="text-align:center; width:120px">Estado</th>	
																						<th>Material/Servicio</th>
																						<th style="text-align:center; width:120px">Cant Solicitada <br>o Días Plazo</th>	
																						<th style="text-align:center; width:250px">Cuenta Contable</th>
																						<th style="text-align:center;">Cotizaciones <br>(Aceptada)</th>
																						<th style="text-align:center; width:120px">Cant Entregada<br>o Días Plazo</th>	
																						<th style="text-align:center; width:120px">TOTAL</th>
																					</tr>
																				</thead>
																				
																				<tbody id="productos_terminados">

																				</tbody>
																			</table>
																		</div>														
																	
																												
																	</div>
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
											<h2>Listado de Solicitudes Terminadas</h2>

											<ul class="nav navbar-right panel_toolbox">
												<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											</ul>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">

											<table id="tabla_solicitudes_terminados" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
												<thead>
													<tr>	
													<th>Año</th>		
													<th>Semana</th>		
													<th>Día</th>
													<th>Nro Solicitud</th>
													<th>Solicitante</th>
													<th>Unidad</th>
													<th>Tipo Compra</th>
													<th>Prioridad Trabajo</th>
													<th>Tipo Mantenimiento</th>
													<th>Motivo Compra</th>
													<th>Comentario Cotización</th>
													<!--<th>Código SAP</th>-->
													<th>Comentario Compra</th>
													<th>Cód Unidad</th>
													<th>Cód Solicitante</th>
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

</div>
<!-- /page content -->

<?php
include('footer.php');
?>