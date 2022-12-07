<?php
include('header.php');

$plan_periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');

$operador = 'carga inicial';
include('consultas/ges_crud_operadores.php');

$lineas = 'carga inicial';
include('consultas/time_crud_linea.php');

$unidviv = 'carga inicial';
include('consultas/ges_crud_viveros.php');
/*
$causas = 'carga inicial';
include('consultas/time_crud_causas.php');*/
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
	background-color: #26b99a; /*verde*/
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

	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	var corresponding_week = <?php echo $corresponding_week; ?>;
	var corresponding_agno = <?php echo $corresponding_agno; ?>;
	var data_operadores = <?php echo $load_operadores; ?>;
	var data_lineas = <?php echo $load_lineas; ?>;
	var data_unidviv = <?php echo $load_unidviv; ?>;
	//var data_causas = <?php echo $load_causas; ?>;
	
</script>

<script type="text/javascript" src="js/timedead_gestion.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Gestión Tiempos Muertos</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
	
						<div class="form-group">
						
							<label class="col-sm-12">ENCABEZADO LÍNEA PRODUCCIÓN</label>
							
							<div class="clearfix"></div><br />
							
							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="per_agno"></select>															
								<div class="help">Año</div>
							</div>
							<div class="col-sm-4">
								<select class="select2_single form-control" tabindex="-1" id="sem_num"></select>															
								<div class="help">Semana</div>
							</div>																	

							<div class="col-sm-2">
								<select class="select2_single form-control" tabindex="-1" id="ctrltd_dia"></select>								
								<div class="help">Día</div>
							</div>
							
							<div class="col-sm-1">
								<select class="select2_single form-control" tabindex="-1" id="ctrltd_hrini">	
									<option value="">-</option>
									<?php
										for($i=0;$i<10;$i++){
											if($i==8){
												echo '<option value="0'.$i.'" selected>0'.$i.'</option>';
											}else{
												echo '<option value="0'.$i.'">0'.$i.'</option>';
											}
										}
										for($i=10;$i<24;$i++){
											echo '<option value="'.$i.'">'.$i.'</option>';
										}										
									?>									
								</select>
								<div class="help">Hr Inicio</div>
							</div>							
							
							<div class="col-sm-1">
								<select class="select2_single form-control" tabindex="-1" id="ctrltd_minini">	
									<option value="">-</option>
									<?php
										for($i=0;$i<10;$i++){
											echo '<option value="0'.$i.'">0'.$i.'</option>';
										}
										for($i=10;$i<60;$i++){
											if($i==15){
												echo '<option value="'.$i.'" selected>'.$i.'</option>';
											}else{
												echo '<option value="'.$i.'">'.$i.'</option>';
											}
										}										
									?>
								</select>							
								<div class="help">Min Inicio</div>
							</div>
							
							
							<div class="col-sm-1">
								<select class="select2_single form-control" tabindex="-1" id="ctrltd_hrfin">	
									<option value="">-</option>
									<?php
										for($i=0;$i<10;$i++){
											echo '<option value="0'.$i.'">0'.$i.'</option>';
										}
										for($i=10;$i<24;$i++){
											if($i==17){
												echo '<option value="'.$i.'" selected>'.$i.'</option>';
											}else{											
												echo '<option value="'.$i.'">'.$i.'</option>';
											}
										}										
									?>									
								</select>
								<div class="help">Hr Fin</div>
							</div>							
							
							<div class="col-sm-1">
								<select class="select2_single form-control" tabindex="-1" id="ctrltd_minfin">	
									<option value="">-</option>
									<?php
										for($i=0;$i<10;$i++){
											echo '<option value="0'.$i.'">0'.$i.'</option>';
										}
										for($i=10;$i<60;$i++){
											if($i==30){
												echo '<option value="'.$i.'" selected>'.$i.'</option>';
											}else{
												echo '<option value="'.$i.'">'.$i.'</option>';
											}											
										}										
									?>
								</select>							
								<div class="help">Min Fin</div>
							</div>							
							
						</div>
					
						<div class="clearfix"></div>	
						
						<br>					
					
						<div class="form-group">
						
							<div class="col-sm-4">
								<select class="select2_single form-control" tabindex="-1" id="lin_id" >	
									<option value="" selected>SELECCIONE LÍNEA</option>
								</select>								
								<div class="help">Línea Producción</div>
							</div>							

							<div class="col-sm-4">
								<select class="select2_single form-control" tabindex="-1" id="sup_rut" >
									<option value="" selected>SELECCIONE SUPERVISOR</option>
								</select>								
								<div class="help">Supervisor</div>
							</div>	
							
							<div class="col-sm-4">
								<select class="select2_single form-control" tabindex="-1" id="oper_rut" >	
									<option value="" selected>SELECCIONE OPERADOR</option>
								</select>								
								<div class="help">Operador</div>
							</div>
<!--
							<div class="col-sm-3">
								<select multiple class="form-control" tabindex="-1" id="time_dead" >
									<option value="charla">Charla</option>
									<option value="b1">Break1</option>
									<option value="b2">Break2</option>
									<option value="col">Colación</option>									
								</select>								
								<div class="help">Tiempo Muerto Gnral</div>
							</div>							
-->					
						</div>		

						<div class="clearfix"></div>	
						<div class="ln_solid"></div>
						<div class="clearfix"></div>
						
						<div class="form-group">
								<button id="btn_reg_ctrltd" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_can_ctrltd" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<button id="btn_del_ctrltd" type="button" class="btn btn-success" style="display:none">Eliminar Gestión</button>
								<button id="btn_upd_ctrltd" type="button" class="btn btn-success" style="display:none">Modificar Encabezado</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">															
						</div>						

						<div class="clearfix"></div>	
						<div class="ln_solid"></div>
						<div class="clearfix"></div>				

						<form id="form_ctrltd" data-parsley-validate class="form-horizontal">
						
							<input type="hidden" id="ctrltd_id" value="" />
							<input type="hidden" id="dctrltd_id" value="" />

<input type="hidden" id="h_sem_num" value="" />
<input type="hidden" id="h_ctrltd_dia" value="" />
<input type="hidden" id="h_ctiempo_cod" value="" />
						
							<div class="panel with-nav-tabs panel-primary">

								<div class="panel-heading">
										<ul class="nav nav-tabs">
											<li id="li1" class="active"><a href="#tab1primary" data-toggle="tab" role="tab">TIEMPOS MUERTOS</a></li>
											<li id="li2"><a href="#tab2primary" data-toggle="tab" role="tab">MANT SANITIZADO</a></li>
											<li id="li3"><a href="#tab3primary" data-toggle="tab" role="tab">BAND 88 CAV</a></li>
											<li id="li4"><a href="#tab4primary" data-toggle="tab" role="tab">BAND 45 CAV</a></li>
											<li id="li5"><a href="#tab5primary" data-toggle="tab" role="tab">CONSUMOS</a></li>
										</ul>
								</div>
								
								<div class="panel-body">
									<div class="tab-content">

<!-- REGISTRO TIEMPOS MUERTOS -->
									
										<div class="tab-pane fade in active" id="tab1primary">
											<div class="form-group">

												<div class="row">
												
													<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
													
														<div class="form-group">
															<div class="col-sm-6">
																<select class="select2_single form-control" tabindex="-1" id="undviv_id">	
																	<option value="">SELECCIONE UNID VIVERO</option>
																</select>								
																<div class="help">Unidad Vivero</div>
															</div>
															
															<div class="col-sm-6">
																<select class="select2_single form-control" tabindex="-1" id="ctiempo_cod">
																<option value="">SELECCIONE CAUSA</option>
																</select>																		
																<div class="help">Causa</div>
															</div>	
														</div>
														
														<div class="form-group">								
															<div class="col-sm-3">
																<select class="select2_single form-control" tabindex="-1" id="dctrltd_hrini">	
																	<option value="">-</option>
																	<?php
																		for($i=0;$i<10;$i++){
																			echo '<option value="0'.$i.'">0'.$i.'</option>';
																		}
																		for($i=10;$i<24;$i++){
																			echo '<option value="'.$i.'">'.$i.'</option>';
																		}										
																	?>									
																</select>
																<div class="help">Hr Ini</div>
															</div>							
															
															<div class="col-sm-3">
																<select class="select2_single form-control" tabindex="-1" id="dctrltd_minini">	
																	<option value="">-</option>
																	<?php
																		for($i=0;$i<10;$i++){
																			echo '<option value="0'.$i.'">0'.$i.'</option>';
																		}
																		for($i=10;$i<60;$i++){
																			echo '<option value="'.$i.'">'.$i.'</option>';
																		}										
																	?>
																</select>							
																<div class="help">Min Ini</div>
															</div>
															
															<div class="col-sm-3">
																<select class="select2_single form-control" tabindex="-1" id="dctrltd_hrfin">	
																	<option value="">-</option>
																	<?php
																		for($i=0;$i<10;$i++){
																			echo '<option value="0'.$i.'">0'.$i.'</option>';
																		}
																		for($i=10;$i<24;$i++){
																			echo '<option value="'.$i.'">'.$i.'</option>';
																		}										
																	?>									
																</select>
																<div class="help">Hr Fin</div>
															</div>							
															
															<div class="col-sm-3">
																<select class="select2_single form-control" tabindex="-1" id="dctrltd_minfin">	
																	<option value="">-</option>
																	<?php
																		for($i=0;$i<10;$i++){
																			echo '<option value="0'.$i.'">0'.$i.'</option>';
																		}
																		for($i=10;$i<60;$i++){
																			echo '<option value="'.$i.'">'.$i.'</option>';
																		}										
																	?>
																</select>							
																<div class="help">Min Fin</div>
															</div>							
															
														</div>
														
													</div>
													
													<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 d-flex flex-column">
														<div class="form-group flex-grow-1 d-flex flex-column">
															<textarea class="form-control flex-grow-1" id="dctrltd_obs" rows="5"></textarea>
															<div class="help">Observación</div>
														</div>
													</div>   
													
												</div>											

												
												<div class="row">
														
													<div class="col-sm-8">
														<button id="btn_reg_dctrltd" type="button" class="btn btn-success" disabled>Registrar</button>
														<button id="btn_upd_dctrltd" type="button" class="btn btn-success" style="display:none">Modificar</button>
														<button id="btn_del_dctrltd" type="button" class="btn btn-success" style="display:none">Eliminar</button>
														<button id="btn_can_dctrltd" type="button" class="btn btn-success" style="display:none">Cancelar</button>
														<br>								
														<img src="images/loading.gif" id="dloading" style="display:none">
													</div>
													<div class="col-sm-4 text-right">												
														<div class="form-inline">
															Tiempo Acumulado&nbsp;&nbsp;<input type="text" id="ctrltd_acum" class="form-control" disabled>
														</div>
													</div>
												</div>					
												
											</div>															
											
											<div class="x_panel">
												<div class="x_title">
													<h2>Registro de Tiempos Muertos</h2>

													<ul class="nav navbar-right panel_toolbox">
														<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
													</ul>
													<div class="clearfix"></div>
												</div>
												<div class="x_content">
												<!--
													<table id="tabla_regtimedead" class="table-striped table-bordered nowrap" style="width:100%">
												-->
													<table id="tabla_regtimedead" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
														<thead>
															<tr>
															<th>Cód Timedead</th>
															<th>Año</th>		
															<th>Semana</th>		
															<th>Día</th>
															<th>Rut Supervisor</th>
															<th>Supervisor</th>
															<th>Rut Operador</th>
															<th>Operador</th>
															<th>Cód Línea</th>			
															<th>Línea Productiva</th>
															<th>Hora Ini Total</th>																		
															<th>Hora Fin Total</th>															
															<th>Saco Turba</th>																		
															<th>Saco Perlita</th>	
															<th>Kg Basacote</th>
															<th>Kg Osmocote</th>
															<th>Kg Vermiculita</th>															
															<th>Fr Cambio Boquilla</th>
															<th>Cant Cambio Boquilla</th>
															<th>Fr Lavado Boquilla</th>
															<th>Cant Lavado Boquilla</th>															
															<th>Band 88 Cav C/Corteza Buenas</th>
															<th>Band 88 Cav C/Corteza Def</th>
															<th>Band 88 Cav C/Corteza Total</th>
															<th>Band 45 Cav C/Corteza Buenas</th>
															<th>Band 45 Cav C/Corteza Def</th>
															<th>Band 45 Cav C/Corteza Total</th>															
															<th>Band 88_45 Cav C/Corteza Total</th>															
															<th>Band 88 Cav C/Turba Buenas</th>
															<th>Band 88 Cav C/Turba Def</th>
															<th>Band 88 Cav C/Turba Total</th>
															<th>Band 45 Cav C/Turba Buenas</th>
															<th>Band 45 Cav C/Turba Def</th>
															<th>Band 45 Cav C/Turba Total</th>
															<th>Band 88_45 Cav C/Turba Total</th>															
															<th>Band 88 Cav Sanitizado Buenas</th>
															<th>Band 88 Cav Sanitizado Def</th>
															<th>Band 88 Cav Sanitizado Total</th>
															<th>Band 45 Cav Sanitizado Buenas</th>
															<th>Band 45 Cav Sanitizado Def</th>
															<th>Band 45 Cav Sanitizado Total</th>
															<th>Band 88_45 Cav Sanitizado Total</th>
															<th>Cód Reg Timedead</th>
															<th>Hora Ini</th>
															<th>Hora Fin</th>
															<th>Duración Min</th>
															<th>Cód UnidViv</th>
															<th>Unidad Vivero</th>
															<th>Cód Causa</th>
															<th>Causa</th>
															<th>Observación</th>															
															</tr>
														</thead>																									
													</table>
												</div>
											</div>																										
										</div>
										
										
<!-- MANTENCIONES SANITIZADO -->										
										<div class="tab-pane fade" id="tab2primary">								
											<div class="x_content">
												<br />

												<div class="form-group">
													<label class="col-sm-12">CAMBIO BOQUILLAS</label>
													
													<div class="col-sm-2">
														<input type="text" id="ctrltd_frcamboq" class="form-control">
														<div class="help">Frecuencia</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_cantcamboq" class="form-control">
														<div class="help">Cantidad</div>
													</div>													

													<button id="btn_mant_sanitizado" type="button" class="btn btn-success" disabled>Registrar</button>
													<img src="images/loading.gif" id="manloading" style="display:none">													
												</div>	

												<div class="form-group">
													<label class="col-sm-12">LAVADO BOQUILLAS</label>
													
													<div class="col-sm-2">
														<input type="text" id="ctrltd_frlavboq" class="form-control">
														<div class="help">Frecuencia</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_cantlavboq" class="form-control">
														<div class="help">Cantidad</div>
													</div>													
												</div>												

											</div>
										</div>	


<!-- BANDEJA 88 CAV -->										
										<div class="tab-pane fade" id="tab3primary">								
											<div class="x_content">
												<br />

												<div class="form-group">
													<label class="col-sm-12">C/CORTEZA</label>
													
													<div class="col-sm-2">
														<input type="text" id="ctrltd_88buencorteza" class="form-control">
														<div class="help">Producidas</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_88defcorteza" class="form-control">
														<div class="help">Deficientes</div>
													</div>
<!--
													<div class="col-sm-2">
														<input type="text" id="ctrltd_88totalcorteza" class="form-control" disabled>
														<div class="help text-center">Total</div>
													</div>														
-->
													<button id="btn_ban88cav" type="button" class="btn btn-success" disabled>Registrar</button>
													<img src="images/loading.gif" id="ban88loading" style="display:none">													
												</div>	

												<div class="form-group">
													<label class="col-sm-12">C/TURBA</label>
													
													<div class="col-sm-2">
														<input type="text" id="ctrltd_88buenturba" class="form-control">
														<div class="help">Producidas</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_88defturba" class="form-control">
														<div class="help">Deficientes</div>
													</div>
<!--
													<div class="col-sm-2">
														<input type="text" id="ctrltd_88totalturba" class="form-control" disabled>
														<div class="help text-center">Total</div>
													</div>	
-->													
												</div>	

												<div class="form-group">
													<label class="col-sm-12">SANITIZADO</label>
													
													<div class="col-sm-2">
														<input type="text" id="ctrltd_88buensanitizado" class="form-control">
														<div class="help">Producidas</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_88defsanitizado" class="form-control">
														<div class="help">Deficientes</div>
													</div>
<!--
													<div class="col-sm-2">
														<input type="text" id="ctrltd_88totalsanitizado" class="form-control" disabled>
														<div class="help text-center">Total</div>
													</div>	
-->													
												</div>
												
<!--
												<div class="form-group">
													<label class="col-sm-12">SANITIZADO EUCALIPTO</label>
													
													<div class="col-sm-2">
														<input type="text" id="ctrltd_" class="form-control">
														<div class="help">Buenas</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_" class="form-control">
														<div class="help">Def</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_" class="form-control" disabled>
														<div class="help text-center">Total</div>
													</div>														
												</div>												
-->
											</div>
										</div>



<!-- BANDEJA 45 CAV -->										
										<div class="tab-pane fade" id="tab4primary">								
											<div class="x_content">
												<br />

												<div class="form-group">
													<label class="col-sm-12">C/CORTEZA</label>
													
													<div class="col-sm-2">
														<input type="text" id="ctrltd_45buencorteza" class="form-control">
														<div class="help">Producidas</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_45defcorteza" class="form-control">
														<div class="help">Deficientes</div>
													</div>
<!--
													<div class="col-sm-2">
														<input type="text" id="ctrltd_45totalcorteza" class="form-control" disabled>
														<div class="help text-center">Total</div>
													</div>														
-->
													<button id="btn_ban45cav" type="button" class="btn btn-success" disabled>Registrar</button>
													<img src="images/loading.gif" id="ban45loading" style="display:none">													
												</div>	

												<div class="form-group">
													<label class="col-sm-12">C/TURBA</label>
													
													<div class="col-sm-2">
														<input type="text" id="ctrltd_45buenturba" class="form-control">
														<div class="help">Producidas</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_45defturba" class="form-control">
														<div class="help">Deficientes</div>
													</div>
<!--
													<div class="col-sm-2">
														<input type="text" id="ctrltd_45totalturba" class="form-control" disabled>
														<div class="help text-center">Total</div>
													</div>			
-->													
												</div>	

												<div class="form-group">
													<label class="col-sm-12">SANITIZADO</label>
													
													<div class="col-sm-2">
														<input type="text" id="ctrltd_45buensanitizado" class="form-control">
														<div class="help">Producidas</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_45defsanitizado" class="form-control">
														<div class="help">Deficientes</div>
													</div>
<!--
													<div class="col-sm-2">
														<input type="text" id="ctrltd_45totalsanitizado" class="form-control" disabled>
														<div class="help text-center">Total</div>
													</div>	
-->														
												</div>
											
												
												
<!--
												<div class="form-group">
													<label class="col-sm-12">SANITIZADO EUCALIPTO</label>
													
													<div class="col-sm-2">
														<input type="text" id="ctrltd_" class="form-control">
														<div class="help">Buenas</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_" class="form-control">
														<div class="help">Def</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_" class="form-control" disabled>
														<div class="help text-center">Total</div>
													</div>														
												</div>												
-->
											</div>
										</div>


<!-- CONSUMOS -->										
										<div class="tab-pane fade" id="tab5primary">								
											<div class="x_content">
												<br />

												<div class="form-group">
													<label class="col-sm-12">CONSUMO SACOS SUSTRATO</label>
													
													<div class="col-sm-2">
														<input type="text" id="ctrltd_sacoturba" class="form-control">
														<div class="help">Sacos Turba</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_sacoperlita" class="form-control">
														<div class="help">Sacos Perlita</div>
													</div>														

													<button id="btn_consumos" type="button" class="btn btn-success" disabled>Registrar</button>
													<img src="images/loading.gif" id="sacoloading" style="display:none">													
												</div>	

												<div class="form-group">
													<label class="col-sm-12">CONSUMO FERTILIZANTES</label>
													
													<div class="col-sm-2">
														<input type="text" id="ctrltd_basacote" class="form-control">
														<div class="help">Kg Basacote</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_osmocote" class="form-control">
														<div class="help">Kg Osmocote</div>
													</div>

													<div class="col-sm-2">
														<input type="text" id="ctrltd_vermiculita" class="form-control">
														<div class="help">Kg Vermiculita</div>
													</div>														
												</div>												

											</div>
										</div>



										
										
										
									</div>
								</div>
							</div>
													

						</form>


						<div class="clearfix"></div>	
						<div class="ln_solid"></div>
						<div class="clearfix"></div>

						
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Listado Gestión Tiempos Muertos</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">

									<table id="datatable-responsive" class="table-striped table-bordered nowrap" style="width:100%">
										<thead>
											<tr>
												<th>Cód Timedead</th>
												<th>Año</th>		
												<th>Semana</th>		
												<th>Día</th>
												<th>Rut Supervisor</th>
												<th>Supervisor</th>
												<th>Rut Operador</th>
												<th>Operador</th>
												<th>Cód Línea</th>			
												<th>Línea Productiva</th>
												<th>Hora Ini Total</th>																		
												<th>Hora Fin Total</th>
												<th>Saco Turba</th>																		
												<th>Saco Perlita</th>	
												<th>Kg Basacote</th>
												<th>Kg Osmocote</th>
												<th>Kg Vermiculita</th>
												<th>Fr Cambio Boquilla</th>
												<th>Cant Cambio Boquilla</th>
												<th>Fr Lavado Boquilla</th>
												<th>Cant Lavado Boquilla</th>
												<th>Band 88 Cav C/Corteza Prod</th>
												<th>Band 88 Cav C/Corteza Def</th>
												<th>Band 88 Cav C/Corteza Total</th>
												<th>Band 45 Cav C/Corteza Prod</th>
												<th>Band 45 Cav C/Corteza Def</th>
												<th>Band 45 Cav C/Corteza Total</th>
												<th>Band 88_45 Cav C/Corteza Total</th>
												<th>Band 88 Cav C/Turba Prod</th>
												<th>Band 88 Cav C/Turba Def</th>
												<th>Band 88 Cav C/Turba Total</th>
												<th>Band 45 Cav C/Turba Prod</th>
												<th>Band 45 Cav C/Turba Def</th>
												<th>Band 45 Cav C/Turba Total</th>
												<th>Band 88_45 Cav C/Turba Total</th>
												<th>Band 88 Cav Sanitizado Prod</th>
												<th>Band 88 Cav Sanitizado Def</th>
												<th>Band 88 Cav Sanitizado Total</th>
												<th>Band 45 Cav Sanitizado Prod</th>
												<th>Band 45 Cav Sanitizado Def</th>
												<th>Band 45 Cav Sanitizado Total</th>
												<th>Band 88_45 Cav Sanitizado Total</th>
											</tr>
										</thead>

									</table>

								</div>
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