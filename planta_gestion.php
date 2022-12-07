<?php
include('header.php');
$periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
$ini_clon = 'carga inicial';
include('consultas/ges_crud_clones.php');
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
</style>

<script type="text/javascript">
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_clones = <?php echo $load_clones; ?>;
</script>

<script type="text/javascript" src="js/planta_gestion.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Gestión Plantas Madres</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_plantamadre" data-parsley-validate class="form-horizontal form-label-left">	

						<input type="hidden" id="hpm_plantas" value="" />
						<input type="hidden" id="hpm_piscinas" value="" />
						
						<input type="hidden" id="hclon_id" value="" />
						<input type="hidden" id="hpm_estado" value="" />
						<input type="hidden" id="hpm_finstal" value="" />
						<input type="hidden" id="hpm_setos" value="" />
					
						<div class="panel with-nav-tabs panel-primary">
							<div class="panel-heading">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#tab1primary" data-toggle="tab">INFORMACIÓN ACTUAL</a></li>
										<li><a href="#tab2primary" data-toggle="tab">INFORMACIÓN HISTÓRICA</a></li>										
									</ul>
							</div>
							<div class="panel-body">
								<div class="tab-content">
									<div class="tab-pane fade in active" id="tab1primary">										
					
										<div class="form-group">
											
											<div class="col-sm-2">
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
										</div>		
										
										<div class="clearfix"></div>
										
										<div class="form-group">
											<div class="col-xs-12">
											<label>Gestión Piscinas</label>
											</div>
											<div class="col-sm-2">
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
												<select class="select2_single form-control" tabindex="-1" id="clon_id">	
													<option value="">SELECCIONE CLON</option>
												</select>								
												<div class="help">Clon</div>
											</div>
											<!--
											<div class="col-sm-2">
												<input type="text" class="form-control" id="clon_estado" disabled>								
												<div class="help">Especie</div>
											</div>	
											-->
											<div class="col-sm-2">
												<select class="select2_single form-control" tabindex="-1" id="pm_estado">
												<option value="PRODUCCION">PRODUCCION</option>
												<option value="GENETICA">GENETICA</option>
												<option value="NO COSECHABLE">NO COSECHABLE</option>
												<option value="VACIO">VACIO</option>
												<option value="EN INSTALACION">EN INSTALACION</option>
												</select>						
												<div class="help">Estado</div>
											</div>	
											<div class="col-sm-1">
												<input type="text" class="form-control" id="pm_setos">								
												<div class="help">Núm setos</div>
											</div>
											<div class="form-group col-sm-2">
												<div class="inner-addon left-addon">
													<i class="glyphicon glyphicon-calendar form-control-feedback  fa fa-calendar"></i>
													<input type="text" id="pm_finstal" class="form-control" value="" style="cursor:pointer" readonly >								
													<div class="help">Fecha instalación</div>
												</div>	
											</div>	
											<div class="clearfix"></div>
											<br />							
											<button id="btn_reg_pm" type="button" class="btn btn-success">Registrar</button>
											<button id="btn_upd_pm" type="button" class="btn btn-success" style="display:none">Modificar</button>
											<!--<button id="btn_del_pm" type="button" class="btn btn-success" style="display:none">Eliminar</button>-->
											<button id="btn_can_pm" type="button" class="btn btn-success" style="display:none">Cancelar</button>
											<button id="btn_cam_pm" type="button" class="btn btn-success" style="display:none">Cambiar</button>
										</div>
										
										<!-- CAMBIO DE PISCINA -->
										
										<div id="cambio_piscina" class="form-group" style="display:none">
										
											<div class="col-xs-12">
												<label>Cambiado a..</label>
											</div>										
										
											<div class="col-xs-12">
												<div class="form-group col-sm-2">
													<div class="inner-addon left-addon">
														<i class="glyphicon glyphicon-calendar form-control-feedback  fa fa-calendar"></i>
														<input type="text" id="xpm_fcambio" class="form-control" value="" style="cursor:pointer" readonly >								
														<div class="help">Fecha Cambio</div>
													</div>	
												</div>													
											</div>
											
											<div class="clearfix"></div>
											<br />											
											
											<div class="col-sm-2">
												<select class="select2_single form-control" tabindex="-1" id="xpm_piscinas" disabled>
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
												<select class="select2_single form-control" tabindex="-1" id="xclon_id">	
													<option value="">SELECCIONE CLON</option>
												</select>								
												<div class="help">Clon</div>
											</div>
											<div class="col-sm-2">
												<select class="select2_single form-control" tabindex="-1" id="xpm_estado">
												<option value="PRODUCCION">PRODUCCION</option>
												<option value="GENETICA">GENETICA</option>
												<option value="NO COSECHABLE">NO COSECHABLE</option>
												<option value="VACIO">VACIO</option>
												<option value="EN INSTALACION">EN INSTALACION</option>
												</select>						
												<div class="help">Estado</div>
											</div>	
											<div class="col-sm-1">
												<input type="text" class="form-control" id="xpm_setos">								
												<div class="help">Núm setos</div>
											</div>
											<div class="form-group col-sm-2">
												<div class="inner-addon left-addon">
													<i class="glyphicon glyphicon-calendar form-control-feedback  fa fa-calendar"></i>
													<input type="text" id="xpm_finstal" class="form-control" value="" style="cursor:pointer" readonly >								
													<div class="help">Fecha instalación</div>
												</div>	
											</div>	
											<div class="clearfix"></div>
											<br />							
											<button id="xbtn_can_pm" type="button" class="btn btn-success">Cancelar</button>
											<button id="xbtn_reg_pm" type="button" class="btn btn-success">Registrar Cambio</button>
																
										</div>										
										
										<br>								
										<img src="images/loading.gif" id="loading" style="display:none">										
													
										<div class="clearfix"></div><br />
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="x_panel">
												<div class="x_title">
													<h2>Listado de Piscinas</h2>
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
																<th>Especie</th>
																<th>Estado</th>
																<th>Núm Setos</th>
																<th>Fecha Instalación</th>
															</tr>
														</thead>

													</table>

												</div>
											</div>
										</div>										
									
									</div>
									
									<div class="tab-pane fade" id="tab2primary">							
							
										<div class="clearfix"></div><br />
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="x_panel">
												<div class="x_title">
													<h2>Histórico Fecha de cambio en Piscinas</h2>
													<ul class="nav navbar-right panel_toolbox">
														<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
													</ul>
													<div class="clearfix"></div>
												</div>
												<div class="x_content">
													<br />
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
															<select class="select2_single form-control" tabindex="-1" id="pm_filtro">
															<option value="" selected>TODAS</option>
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

														<div class="col-sm-2"><button id="btn_monitoreo" type="button" class="btn btn-success">Consultar</button></div>							
													
													</div>												
													<div class="clearfix"></div> <br/>
													<table id="tabla_historia" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
														<thead>
															<tr>
																<th>Año</th>
																<th>Mes</th>
																<th>Semana</th>
																<th>Planta Madre</th>
																<th>Piscina</th>
																<th>Clon</th>
																<th>Especie</th>
																<th>Estado</th>
																<th>Núm Setos</th>
																<th>Fecha Instalación</th>
																<th>Fecha Cambio</th>
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
					</form>	
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