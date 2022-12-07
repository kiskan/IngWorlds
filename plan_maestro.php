<?php
include('header.php');

$plan_periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
if(!$error){
$area = 'carga inicial';
include('consultas/ges_crud_areas.php');

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
	var data_areas = <?php echo $load_areas; ?>;
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	//var corresponding_week = <?php echo date("W"); ?>;
	var corresponding_week = <?php echo $corresponding_week; ?>;
	var corresponding_agno = <?php echo $corresponding_agno; ?>;
</script>

<script type="text/javascript" src="js/plan_maestro.js"></script>
<?php } ?>
<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-xs-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Plan Maestro</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
				<?php if(!$error){ ?>	
				
				
					<div class="form-group" <?php if ($_SESSION['USR_TIPO'] <> 'ADMINISTRADOR'){ ?> style="display:none" <?php } ?>  >
						<label class="col-xs-12">SEMANA DE PLANIFICACION</label>
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
				<div class="clearfix"></div>
					<div class="form-group">
						<label class="col-xs-12">DIA DE PLANIFICACION (<span id="sem_txt"></span>)</label>
						<div class="col-sm-3">
							<select multiple class="form-control" tabindex="-1" id="plan_dia"></select>								
							<div class="help">Día(s)</div>
						</div>	
						
						<div class="col-sm-3">
							<select class="select2_single form-control" tabindex="-1" id="area_id">	
								<option value="">SELECCIONE AREA</option>
							</select>								
							<div class="help">Area</div>
						</div>
						
						<button id="btn_comun_planxmaestro" type="button" class="btn btn-success">Buscar Actividades en Común</button>
		
						<div id="pos_activ_comun" style="display:none">
							<div class="col-sm-2">							
								<select class="multiple form-control" tabindex="-1" id="plan_dia_rep">	
									
								</select>		
								<div class="help">Día(s) a replicar</div>
							</div>							
							<div class="col-sm-1">
								<button id="btn_rep_dia" type="button" class="btn btn-success">Replicar</button>
							</div>									

							<div class="col-sm-2">							
								<select class="multiple form-control" tabindex="-1" id="plan_dia_elim">
								</select>							
								<div class="help">Día(s) a eliminar</div>
							</div>							
							<div class="col-sm-1">
								<button id="btn_elim_dia" type="button" class="btn btn-success">Eliminar</button>
							</div>							
						</div>
					</div>							
						
					<div class="clearfix"></div>	
					<div class="ln_solid"></div>
					<div class="clearfix"></div>				

					<form id="form_planxmaestro" data-parsley-validate class="form-horizontal">	

						<input type="hidden" id="h_activ_id" value="" />
					
						<div class="panel with-nav-tabs panel-primary">
							<div class="panel-heading">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#tab1primary" data-toggle="tab">ACTIVIDADES PRODUCTIVAS</a></li>
										<li><a href="#tab2primary" data-toggle="tab">ACTIVIDADES APOYO</a></li>
										
									</ul>
							</div>
							<div class="panel-body">
								<div class="tab-content">
									<div class="tab-pane fade in active" id="tab1primary">
										<div class="form-group">
											
											<div class="col-sm-6">
												<select class="select2_single form-control" tabindex="-1" id="activ_prod_id">	
													<option value="">SELECCIONE ACTIVIDAD</option>
												</select>								
												<div class="help">Actividad Productiva</div>
											</div>
											
											<div class="col-sm-5">
												<select multiple class="form-control" tabindex="-1" id="sup_rut_prod"></select>								
												<div class="help">Supervisor</div>
											</div>											
																						
											<div class="col-sm-1">
												<select class="select2_single form-control" tabindex="-1" id="activ_prod_interes">	
													<option value="SI">SI</option>
													<option value="NO">NO</option>	
												</select>								
												<div class="help">De interés?</div>
											</div>								
											
										</div>	
									
										<div class="form-group">
											<label class="col-xs-12">Producción (jornada x meta = producción esperada)</label>	
											
											<div class="col-sm-2">
												<input type="text" class="form-control" id="activ_prod_jornada">
												<div class="help">Jornada</div>
											</div>								
											
											<div class="col-sm-2">
												<input type="text" class="form-control" id="activ_prod_meta" disabled>
												<div class="help">Meta</div>
											</div>						
											
											<div class="col-sm-2">
												<input type="text" class="form-control" id="activ_prod_esperada">
												<div class="help">Producción esperada</div>
											</div>	
											
											<div class="col-sm-2">
												<input type="text" class="form-control" id="activ_prod_unidad" disabled>
												<div class="help">Unidad</div>
											</div>												
											
											<button id="btn_reg_activ_prod" type="button" class="btn btn-success">Registrar</button>
											<button id="btn_upd_activ_prod" type="button" class="btn btn-success" style="display:none">Modificar</button>
											<button id="btn_del_activ_prod" type="button" class="btn btn-success" style="display:none">Eliminar</button>
											<button id="btn_can_activ_prod" type="button" class="btn btn-success" style="display:none">Cancelar</button>
											<br>								
											<img src="images/loading.gif" id="loading" style="display:none">
											<span id="error" style="display:none; color:red" />													
																				
										</div>	
									

										
										
										<div class="x_panel">
										<div class="x_title">
											<h2>Listado Actividades Productivas</h2>

											<ul class="nav navbar-right panel_toolbox">
												<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											</ul>
											<div class="clearfix"></div>
										</div>
											<div class="x_content">

												<table id="tabla_activ_prod" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
													<thead>
														<tr>
														<th>Actividad</th>
														<th>Supervisor(es)</th>
														<th>De interés?</th>	
														<th>Jornada</th>
														<th>Meta</th>	
														<th>Prod. esperada</th>
														<th>Unidad</th>
														<th>Cód Actividad</th>
														<th>Rut Supervisor(es)</th>
														</tr>
													</thead>								
													
												</table>
											</div>
										</div>
									
									
									</div>
									
									<div class="tab-pane fade" id="tab2primary">
									
										<div class="form-group">
									
											<div class="col-sm-6">
												<select class="select2_single form-control" tabindex="-1" id="activ_apoyo_id">	
													<option value="">SELECCIONE ACTIVIDAD</option>
												</select>								
												<div class="help">Actividad Apoyo</div>
											</div>
											
											<div class="col-sm-6">
												<select multiple class="form-control" tabindex="-1" id="sup_rut_apoyo"></select>								
												<div class="help">Supervisor</div>
											</div>												
																							
																			
										</div>	
										
										<div class="form-group">
										
												<div class="col-sm-2">
													<input type="text" class="form-control" id="activ_apoyo_jornada">
													<div class="help">Jornada</div>
												</div>											
										
												<button id="btn_reg_activ_apoyo" type="button" class="btn btn-success">Registrar</button>
												<button id="btn_upd_activ_apoyo" type="button" class="btn btn-success" style="display:none">Modificar</button>
												<button id="btn_del_activ_apoyo" type="button" class="btn btn-success" style="display:none">Eliminar</button>
												<button id="btn_can_activ_apoyo" type="button" class="btn btn-success" style="display:none">Cancelar</button>
												<br>								
												<img src="images/loading.gif" id="loading_apoyo" style="display:none">
												<span id="error2" style="display:none; color:red" />											
										</div>
										
										
									<div class="x_panel">
										<div class="x_title">
											<h2>Listado Actividades Apoyo</h2>

											<ul class="nav navbar-right panel_toolbox">
												<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
											</ul>
											<div class="clearfix"></div>
										</div>
										<div class="x_content">

											<table id="tabla_activ_apoyo" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
												<thead>
													<tr>
													<th>Actividad</th>	
													<th>Supervisor(es)</th>
													<th>Jornada</th>
													<th>Cód Actividad</th>
													<th>Rut Supervisor(es)</th>													
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
								<button id="btn_can_planxmaestro" type="button" class="btn btn-success" style="display:none" >Cancelar</button>
								<button id="btn_del_planxmaestro" type="button" class="btn btn-success" style="display:none" >Eliminar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							
						</div>	
					</form>												
				</div>
			</div>	

	
					<div class="clearfix"></div>


					<div class="x_panel">
						<div class="x_title">
							<h2>Detalle Plan Maestro</h2>

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
										<th>Cód Area</th>
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