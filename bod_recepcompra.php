<?php
include('header.php');

$plan_periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');

$viveros = 'carga inicial';
include('consultas/ges_crud_viveros.php');

$solicitantes = 'carga inicial';
include('consultas/ges_crud_usuarios.php');

$cc = 'carga inicial';
include('consultas/bod_crud_catproducto.php');

?>
<style>

#datatable-compra thead tr th{
	text-align: center;	
}

.linkc { color: #33B2FF; } 
.linkc:hover { color: #1F5B1C; }

.linkc2 { color: #F15410; } 
.linkc2:hover { color: #1F5B1C; }
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
/*
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
*/
</style>
<script type="text/javascript">
	var data_viveros = <?php echo $load_viveros; ?>;
	var data_cc = <?php echo $load_cc; ?>;
	var data_solicitantes = <?php echo $load_solicitantes; ?>;
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	var corresponding_week = <?php echo $corresponding_week; ?>;
	var corresponding_agno = <?php echo $corresponding_agno; ?>;
	
</script>
<script>

function bs_input_file() {
	$(".input-file1").before(
		function() {
			if ( ! $(this).prev().hasClass('input-ghost') ) {
				var element = $("<input type='file' id='file1' name='file1' class='input-ghost' style='visibility:hidden; height:0'>");/*
				element.attr("name",$(this).attr("name"));*/
				element.change(function(){
					element.next(element).find('input').val((element.val()).split('\\').pop());
				});
				$(this).find("button.btn-choose").click(function(){
					element.click();
				});
				$(this).find("button.btn-reset").click(function(){
					element.val(null);
					$(this).parents(".input-file1").find('input').val('');
				});
				$(this).find('input').css("cursor","pointer");
				$(this).find('input').mousedown(function() {
					$(this).parents('.input-file1').prev().click();
					return false;
				});
				return element;
			}
		}
	);
	
	$(".input-file2").before(
		function() {
			if ( ! $(this).prev().hasClass('input-ghost') ) {
				var element = $("<input type='file' id='file2' name='file2' class='input-ghost' style='visibility:hidden; height:0'>");/*
				element.attr("name",$(this).attr("name"));*/
				element.change(function(){
					element.next(element).find('input').val((element.val()).split('\\').pop());
				});
				$(this).find("button.btn-choose").click(function(){
					element.click();
				});
				$(this).find("button.btn-reset").click(function(){
					element.val(null);
					$(this).parents(".input-file2").find('input').val('');
				});
				$(this).find('input').css("cursor","pointer");
				$(this).find('input').mousedown(function() {
					$(this).parents('.input-file2').prev().click();
					return false;
				});
				return element;
			}
		}
	);	
	
	$(".input-file3").before(
		function() {
			if ( ! $(this).prev().hasClass('input-ghost') ) {
				var element = $("<input type='file' id='file3' name='file3' class='input-ghost' style='visibility:hidden; height:0'>");/*
				element.attr("name",$(this).attr("name"));*/
				element.change(function(){
					element.next(element).find('input').val((element.val()).split('\\').pop());
				});
				$(this).find("button.btn-choose").click(function(){
					element.click();
				});
				$(this).find("button.btn-reset").click(function(){
					element.val(null);
					$(this).parents(".input-file3").find('input').val('');
				});
				$(this).find('input').css("cursor","pointer");
				$(this).find('input').mousedown(function() {
					$(this).parents('.input-file3').prev().click();
					return false;
				});
				return element;
			}
		}
	);		
	
	
	
	
}
$(function() {
	bs_input_file();
});

</script>		
<script type="text/javascript" src="js/bod_recepcompra.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-xs-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Gestión Solicitudes de Compra</h2>
					<div class="clearfix"></div>
				</div>
				
				
				
				<!-- Modal Cotización -->
				<div id="WModal_Cotizacion" class="modal fade">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
						<center>
							<div class="modal-header">
								<h4 id="title_cotizacion" class="modal-title">Cotizaciones (Seleccione 1)</h4>
								<h5 id="title_cotcant" class="modal-title" style="font-weight: bold;">Cantidad</h5>
							</div>
							
							<div class="modal-body">
							
								<form name="form_cotiz" id="form_cotiz" method="post" enctype="multipart/form-data" action="">
								
									<input id="operacion" name="operacion" type="hidden" />
									<input id="sprodd_id" name="sprodd_id" type="hidden" />
									<input id="provsel" name="provsel" type="hidden" />
									<input id="h_num" name="h_num" type="hidden" />
									<input id="h_cot_id" name="cotcom_id" type="hidden" />
								
									<div id="cot_form2">	
										<div class="form-group">										
											
											<div class="col-sm-10">
												<input type="text" class="form-control" name="cotcom_proveedor" id="cotcom_proveedor">								
												<div class="help">Proveedor</div>
											</div>
											
											<div class="col-sm-2">
												<input type="checkbox" class="form-control" name="cotcom_provsel" id="cotcom_provsel" style="-webkit-box-shadow: none !important; height: 28px !important" />
												<div class="help">Seleccionado</div>
											</div>																		

										</div>
										<div class="clearfix"></div><br>
									</div>		
										<div class="form-group">										
										
										<div id="cot_form3">
											<div class="col-sm-2">
												<input type="text" class="form-control" name="cotcom_precio" id="cotcom_precio">								
												<div class="help">Precio</div>
											</div>
											
											<div class="col-sm-2">
												<input type="text" class="form-control" name="cotcom_cantidad" id="cotcom_cantidad">								
												<div id="cot_cant_plazo" class="help">Cantidad/Plazo</div>
											</div>
											
											<div class="col-sm-2" id="cot_total" style="display:none">
												<input type="text" class="form-control" id="cotcom_total" disabled>								
												<div class="help">Total Precio</div>
											</div>
											
										</div>
									
											<div class="col-sm-2" id="cot1" style="display:none">
												<img src="images/cotizacion.png" class="img-responsive" alt="Cotización" style="width:30%;height: auto;"/>
												<div class="help">Cotización<br>
													<a id="acot1" target="_blank" href="#" class="linkc">Abrir</a>&nbsp;&nbsp;<a id="bcot1" href="#" class="linkc2">Borrar</a>
												</div>											
											</div>	

											<div class="col-sm-2" id="cot2" style="display:none">
												<img src="images/cotizacion.png" class="img-responsive" alt="Cotización" style="width:30%;height: auto;"/>
												<div class="help">Cotización<br>
													<a id="acot2" target="_blank" href="#" class="linkc">Abrir</a>&nbsp;&nbsp;<a id="bcot2" href="#" class="linkc2">Borrar</a>
												</div>											
											</div>	

											<div class="col-sm-2" id="cot3" style="display:none">
												<img src="images/cotizacion.png" class="img-responsive" alt="Cotización" style="width:30%;height: auto;"/>
												<div class="help">Cotización<br>
													<a id="acot3" target="_blank" href="#" class="linkc">Abrir</a>&nbsp;&nbsp;<a id="bcot3" href="#" class="linkc2">Borrar</a>
												</div>
											</div>											
											
										</div>	

										<div class="clearfix"></div><br>
										
											
									<div id="cot_form">		
										<div class="form-group">										
											
											<div class="col-sm-4" id="cotiz1">										
												<div class="input-group input-file1" name="Fichier1">
													<span class="input-group-btn">
														<button class="btn btn-default btn-choose" type="button">Cotiz</button>
													</span>
													<input type="text" class="form-control" placeholder='Choose a file...' />
													<span class="input-group-btn">
														 <button id="reset_file1" class="btn btn-warning btn-reset" type="button">Reset</button>
													</span>
												</div>
											</div>
											
			  
											<div class="col-sm-4" id="cotiz2">	
												<div class="input-group input-file2" name="Fichier2">
													<span class="input-group-btn">
														<button class="btn btn-default btn-choose" type="button">Cotiz</button>
													</span>
													<input type="text" class="form-control" placeholder='Choose a file...' />
													<span class="input-group-btn">
														 <button id="reset_file2" class="btn btn-warning btn-reset" type="button">Reset</button>
													</span>
												</div>
   
											</div>

											<div class="col-sm-4" id="cotiz3">	
												<div class="input-group input-file3" name="Fichier3">
													<span class="input-group-btn">
																						  
														<button class="btn btn-default btn-choose" type="button">Cotiz</button>
													</span>
													<input type="text" class="form-control" placeholder='Choose a file...' />
													<span class="input-group-btn">
														 <button id="reset_file3" class="btn btn-warning btn-reset" type="button">Reset</button>
													</span>
												</div>	
											</div>
											
										</div>										
									
										<div class="clearfix"></div><br>										
										
																		
										<button id="btn_reg_cot" type="button" class="btn btn-success">Registrar</button>
										
										<!--<input id="btn_reg_cot" type="submit" class="btn btn-success" value="Registrar" />-->
										
										<button id="btn_upd_cot" type="button" class="btn btn-success" style="display:none">Modificar</button>
										<button id="btn_del_cot" type="button" class="btn btn-success" style="display:none">Eliminar</button>
										<button id="btn_can_cot" type="button" class="btn btn-success" style="display:none">Cancelar</button>
										<br>								
										<img src="images/loading.gif" id="cloading" style="display:none">											
										<div id="img_loading_gif"></div>								
										
									</div>		
								</form>
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
														<th>Cantidad/Plazo</th>
														<th>Total</th>
														<th>Total Acordado</th>
														<th>Archivo1</th>
														<th>Archivo2</th>
														<th>Archivo3</th>
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
								<h5 id="title_cant" class="modal-title" style="font-weight: bold;">Cantidad</h4>
							</div>
							<div class="modal-body">
								<div id="com_form">
									<div class="form-group">										
										
										<input id="h_com_proveedor" type="hidden" />
										<input id="h_com_precio" type="hidden" />
										
										<div class="col-sm-8">
											<input type="text" class="form-control" id="com_proveedor">								
											<div class="help">Proveedor</div>
										</div>							
										
										<div class="form-group col-sm-2">
											<div class="inner-addon left-addon">
												<i class="glyphicon glyphicon-calendar form-control-feedback  fa fa-calendar"></i>
												<input type="text" id="com_dentrega" class="form-control" value="" style="cursor:pointer" readonly >								
												<div class="help">Fecha entrega</div>
											</div>	
										</div>																		

										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="com_hentrega">	
											<option value="08:00">08:00</option><option value="08:30">08:30</option><option value="09:00">09:00</option><option value="09:30">09:30</option>
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
									<div class="clearfix"></div>
									<div class="form-group">										
										
										<div class="col-sm-2">
											<input type="text" class="form-control" id="com_precio">								
											<div class="help">Precio</div>
										</div>
										
										<div class="col-sm-2">
											<input type="text" class="form-control" id="com_cantidad">								
											<div id="com_cant_plazo" class="help">Cantidad/Plazo</div>
										</div>
										
										<div class="col-sm-2" id="div_com_total" style="display:none">
											<input type="text" class="form-control" id="com_total" disabled>								
											<div class="help">Total Contratado</div>
										</div>
										
										<div class="col-sm-2" id="div_com_avance" style="display:none">
											<select class="select2_single form-control" tabindex="-1" id="com_avance">	<option value="">AVANCE</option>
											<option value="0">0%</option><option value="10">10%</option><option value="20">20%</option><option value="30">30%</option>
											<option value="40">40%</option><option value="50">50%</option><option value="60">60%</option><option value="70">70%</option>
											<option value="80">80%</option><option value="90">90%</option><option value="100">100%</option></select>
											<div class="help">%Avance</div>
										</div>									
										
										<div class="col-sm-2">
											<input type="text" class="form-control" id="com_acordado" disabled>								
											<div class="help">Precio Avanzado</div>
										</div>		
										
										<div class="col-sm-2">
											<input type="text" class="form-control" id="com_hes">								
											<div class="help">Código HES</div>
										</div>		
									<!--
										<div class="col-sm-2">
											<input type="text" id="com_codigosap" class="form-control">
											<div class="help">Código SAP</div>
										</div>										
									-->
									</div>								
								
									<div class="clearfix"></div><br>										
									
																			
									<button id="btn_reg_com" type="button" class="btn btn-success">Registrar</button>
									<button id="btn_upd_com" type="button" class="btn btn-success" style="display:none">Modificar</button>
									<button id="btn_del_com" type="button" class="btn btn-success" style="display:none">Eliminar</button>
									<button id="btn_can_com" type="button" class="btn btn-success" style="display:none">Cancelar</button>
									<button id="btn_datos_cot" type="button" class="btn btn-success">Datos Cotiz</button>
									<br>								
									<img src="images/loading.gif" id="comloading" style="display:none">											
																
								</div>
											
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
														<!--<th>Cód SAP</th>-->
														<th>Cód HES</th>
														<th>Proveedor<br>(Acortado)</th>
														<th>Proveedor</th>														
														<th>Fecha/Hora<br>Entrega</th>
														<th>Precio</th>
														<th>Cantidad<br> / Plazo</th>
														<th>Total<br>Contratado</th>														
														<th>Precio<br>Avanzado</th>
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
							<li class="active"><a href="#tab1primary" data-toggle="tab">PENDIENTES</a></li>										
							<li><a href="#tab2primary" data-toggle="tab">EN PROCESO</a></li>
							<li><a href="#tab3primary" data-toggle="tab">TERMINADO</a></li>
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
										<label class="col-xs-12">DATOS SOLICITUD</label>
																				
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="UNDVIV_ID" disabled>
												<option value=""></option>
											</select>								
											<div class="help">Unidad</div>
										</div>

										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="sprod_tipocompra" disabled>	
												<option value=""></option>
												<option value="COMPRA MATERIAL">COMPRA MATERIAL</option>
												<option value="PRESTACIÓN SERVICIO">PRESTACIÓN SERVICIO</option>
											</select>								
											<div class="help">Tipo Compra</div>
										</div>
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="sprod_prioridad" disabled>	
												<option value=""></option>
												<option value="NORMAL">NORMAL</option>
												<option value="URGENTE">URGENTE</option>
											</select>								
											<div class="help">Prioridad Trabajo</div>
										</div>	
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="sprod_tipomant" disabled>	
												<option value=""></option>
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
											<textarea class="form-control" rows="3" id="sprod_motivo" disabled></textarea>
										</div>									
									</div>											
									
									
									<div class="clearfix"></div>	
									<div class="ln_solid"></div>
									<div class="clearfix"></div>									
									

									
									<div class="form-group">
										<label class="col-xs-12">COMENTARIO COTIZACIÓN</label>									
										<div class="col-md-8 col-sm-8 col-xs-12">
											<textarea class="form-control" rows="3" id="sprod_comencotiz" ></textarea>
										</div>									
									</div>
									
									<div class="form-group">
										<div class="col-xs-12">
											<br>
											<button id="btn_reg_comencotiz" type="button" class="btn btn-success">Registrar Comentario</button>
											<button id="btn_fin_cotizacion" type="button" class="btn btn-danger">Terminar Cotización</button>
											<br>								
											<img src="images/loading.gif" id="loading" style="display:none">		
										</div>
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
										<input type="hidden" id="h_cotcom_id" value="" />
										<input type="hidden" id="h_pestagna" value="" />
										<input type="hidden" id="h_sprod_id" value="" />
										
										<input type="hidden" id="h_sprod_tipocompra" value="" />
										<input type="hidden" id="h_sprod_prioridad" value="" />
										<input type="hidden" id="h_sprod_tipomant" value="" />
										<input type="hidden" id="h_sprod_motivo" value="" />
										
										<div class="form-group">
											<div class="col-md-2 col-md-offset-10">
												<center>
												<input type="text" id="sprod_total" class="form-control text-center" style="font-weight:bold; font-size:20px;" disabled>
												<div class="help">TOTAL COTIZACIÓN</div>
												</center>
											</div>							
										</div>												
										
										<div class="clearfix"></div>	
									
										<div class="panel with-nav-tabs panel-primary">
											<div class="panel-heading">
													<ul class="nav nav-tabs">
														<li class="active"><a href="#tab1primary" data-toggle="tab">MATERIALES/SERVICIOS SOLICITADOS</a></li>
													</ul>
											</div>
											
											
											
											<div class="panel-body" id="productos_solicitar">
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab1primary">
													<button id="btn_reg_ctacble" type="button" class="btn btn-info">Registrar Cuenta Contable</button>
													<button id="btn_reg_elimselpend" type="button" class="btn btn-warning">Eliminar Selección</button>
														<div class="table-responsive">
															<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
																<thead>
																	<tr>	
																		<th style="text-align:center; width:70px">
																		Cot
																		</th>																	
																		<th style="text-align:center; width:70px">
																		SAP
																		</th>						
																		<th style="text-align:center; width:70px">
																		Elim
																		</th>
																		<th>Material/Servicio</th>
																		<th style="text-align:center; width:90px">Cant Solic</th>
																		<th style="text-align:center; width:250px">Cuenta Contable</th>
																		<th style="text-align:center;">Cotizaciones (Aceptada)</th>
																		<th style="text-align:center; width:120px">Total</th>
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
													<th>Tipo Compra</th>
													<th>Prioridad Trabajo</th>
													<th>Tipo Mantenimiento</th>
													<th>Motivo Compra</th>
													<th>Comentario Cotización</th>
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
									<input type="hidden" id="h_psprod_id" value="" />
									<input type="hidden" id="h_psprod_tipocompra" value="" />

									<div class="form-group">
										<label class="col-sm-12">NRO DE SOLICITUD</label>
										
										<div class="col-sm-2">
											<input type="text" id="psprod_id" class="form-control">							
										</div>
										
										<div class="col-sm-4">
											<select class="select2_single form-control" tabindex="-1" id="pusr_solic">	
											<option value="">TODOS</option>
											</select>								
											<div class="help">Solicitante</div>
										</div>												
										
										
										<button id="btn_cons_enproceso" type="button" class="btn btn-success">Consultar</button>
										<img src="images/loading.gif" id="ploading" style="display:none">
																						
																									
									</div>									
							
									<div class="form-group">
										<label class="col-sm-12">DIA DE SOLICITUD</label>
										
										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="pper_agno">	
											</select>								
											<div class="help">Año</div>
										</div>
										<div class="col-sm-4">
											<select class="select2_single form-control" tabindex="-1" id="psem_num">
											<option value="">TODOS</option>
											</select>								
											<div class="help">Semana</div>
										</div>		
										<div class="col-sm-2">
											<select class="select2_single form-control" tabindex="-1" id="psprod_dia">
												<option value="">TODOS</option>
											</select>
											<div class="help">Día</div>
										</div>	
									</div>
									
									<div class="clearfix"></div>
									
									<div class="form-group">
										<label class="col-xs-12">DATOS SOLICITUD</label>
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="pUNDVIV_ID">	
												<option value="">TODOS</option>
											</select>								
											<div class="help">Unidad</div>
										</div>
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="psprod_tipocompra">	
												<option value="">TODOS</option>
												<option value="COMPRA MATERIAL">COMPRA MATERIAL</option>
												<option value="PRESTACIÓN SERVICIO">PRESTACIÓN SERVICIO</option>
											</select>								
											<div class="help">Tipo Compra</div>
										</div>
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="psprod_prioridad">	
												<option value="">TODOS</option>
												<option value="NORMAL">NORMAL</option>
												<option value="URGENTE">URGENTE</option>
											</select>								
											<div class="help">Prioridad Trabajo</div>
										</div>	
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="psprod_tipomant">	
												<option value="">TODOS</option>
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
									
									<div>
									
										<div class="panel with-nav-tabs panel-primary">
											<div class="panel-heading">
													<ul class="nav nav-tabs">
														<li class="active"><a href="#tab2primary" data-toggle="tab">COMPRA MATERIALES/SERVICIOS</a></li>
													</ul>
											</div>
											<div class="panel-body" id="productos_solictar">
												<div class="tab-content">
													<div class="tab-pane fade in active" id="tab2primary">
									
														
														<div class="form-group">									
															<div class="col-md-6 col-sm-6 col-xs-12">
																<textarea class="form-control" rows="3" id="psprod_motivo" readonly></textarea>
																<div class="help">Motivo Compra</div>
															</div>			
															<div class="col-md-6 col-sm-6 col-xs-12">
																<textarea class="form-control" rows="3" id="psprod_comencotiz" readonly></textarea>
																<div class="help">Comentario Cotización</div>
															</div>																
														</div>	
														
														<div class="form-group">
															<label class="col-xs-12">COMPRA</label>	
															<div class="col-md-12 col-sm-12 col-xs-12">
																<textarea class="form-control" rows="3" id="psprod_comencompra"></textarea>
																<div class="help">Comentario Compra</div>
															</div>									
														</div>															
														
														<div class="form-group">
															<div class="col-xs-12">
																<br>
																<button id="btn_reg_sap" type="button" class="btn btn-success">Registrar Comentario</button>
																<!--<button id="btn_change_pendiente" type="button" class="btn btn-secondary">Cambiar a -> Pendiente</button>-->
																<button id="btn_fin_compra" type="button" class="btn btn-danger">Terminar Compra</button>
																<br>								
																<img src="images/loading.gif" id="pploading" style="display:none">	
															</div>
														</div>															
														
														<div class="clearfix"></div>

														<div class="form-group">
															<div class="col-md-2 col-md-offset-10">
																<center>
																<input type="text" id="psprod_total" class="form-control text-center" style="font-weight:bold; font-size:20px;" disabled>
																<div class="help">TOTAL COMPRA</div>
																</center>
															</div>							
														</div>															
														<div class="clearfix"></div>	<br>
														<div class="panel with-nav-tabs panel-primary">
															<div class="panel-heading">
																	<ul class="nav nav-tabs">
																		<li class="active"><a href="#tab2primary" data-toggle="tab">MATERIALES SOLICITADOS</a></li>
																	</ul>
															</div>														
															<div class="panel-body">
																<div class="tab-content">
																	<div class="tab-pane fade in active" id="tab2primary">
																	<button id="btn_reg_compra" type="button" class="btn btn-info">Actualizar Estado-Cuenta Contable-Cód SAP</button>	
																	<button id="btn_reg_elimselproc" type="button" class="btn btn-warning">Eliminar Selección</button>																	
																		<div class="table-responsive">
																			<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
																				<thead>
																					<tr>
																						<th style="text-align:center; width:70px">
																						Cot
																						</th>																	
																						<th style="text-align:center; width:70px">
																						SAP
																						</th>																					
																						<th style="text-align:center; width:70px">
																						Elim
																						</th>																					
																						<th style="text-align:center; width:120px">Estado</th>	
																						<th>Material/Servicio</th>
																						<th style="text-align:center; width:120px">Cant Solicitada <br>o Días Plazo</th>
																						<th style="text-align:center; width:120px">Cód SAP</th>							
																						<th style="text-align:center; width:200px">Cuenta Contable</th>
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
										</div>										
											
										<div class="clearfix"></div>	
										<div class="ln_solid"></div>
										<div class="clearfix"></div>	
									</div>

									<div class="x_panel">
										<div class="x_title">
											<h2>Listado de Compras En Proceso</h2>

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
												<option value="">TODOS</option>
												<option value="COMPRA MATERIAL">COMPRA MATERIAL</option>
												<option value="PRESTACIÓN SERVICIO">PRESTACIÓN SERVICIO</option>
											</select>								
											<div class="help">Tipo Compra</div>
										</div>
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="tsprod_prioridad">	
												<option value="">TODOS</option>
												<option value="NORMAL">NORMAL</option>
												<option value="URGENTE">URGENTE</option>
											</select>								
											<div class="help">Prioridad Trabajo</div>
										</div>	
										
										<div class="col-sm-3">
											<select class="select2_single form-control" tabindex="-1" id="tsprod_tipomant">	
												<option value="">TODOS</option>
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
																						<th style="text-align:center; width:120px">Cód SAP</th>	
																						<th style="text-align:center; width:200px">Cuenta Contable</th>
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
														
														
														
														
														
														<div class="clearfix"></div><br>
														<button id="btn_cambiar_enproceso" type="button" class="btn btn-success">Cambiar a  -> En Proceso</button>
														<img src="images/loading.gif" id="ttloading" style="display:none">	
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
											<h2>Listado de Compras Entregadas</h2>

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