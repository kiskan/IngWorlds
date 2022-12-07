<?php
include('header.php');
$area = 'carga inicial';
include('consultas/ges_crud_areas.php');
$periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
?>

<script type="text/javascript">
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	var numeroSemana = <?php echo date("W"); ?>; 	
	var data_areas = <?php echo $load_areas; ?>;
</script>

<script type="text/javascript" src="js/sup_solicitud.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Solicitud Actividad</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_sactiv" data-parsley-validate class="form-horizontal form-label-left" action="sup_replanificacion.php" method="post">				
						<input type="hidden" id="sactiv_id" name="sactiv_id" value="" />				
						<input type="hidden" id="h_sactiv_dia" name="h_sactiv_dia" value="" />
						<input type="hidden" id="h_area_id" name="h_area_id" value="" />
						<input type="hidden" id="h_activ_id" name="h_activ_id" value="" />	
						<input type="hidden" id="h_sem_num" name="h_sem_num" value="" />
						<input type="hidden" id="h_per_agno" name="h_per_agno" value="" />
						<input type="hidden" id="h_sem_txt" name="h_sem_txt" value="" />
						<input type="hidden" id="h_sup_rut" name="h_sup_rut" value="" />
						
						<label class="col-sm-12">PLANIFICACION <span id="sem_txt"></span></label>
						<label class="col-sm-12">1 Solicitud x día</label>
						<label class="col-sm-12" id="supervisor_solicitante"></label>
						<div class="clearfix"></div><br />					
						
						<div class="form-group">							
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Día planificado*</label>
							<div class="col-xs-3 col-sm-2">
							  <select class="select2_single form-control" tabindex="-1" id="sactiv_dia"></select>
							</div>
						</div>			

						<div class="form-group">							
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Solicitud*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<select class="select2_single form-control" tabindex="-1" id="sactiv_opcion">
									<option value="INGRESAR NUEVA ACTIVIDAD" selected>INGRESAR NUEVA ACTIVIDAD</option>
									<option value="ELIMINAR ACTIVIDAD PLANIFICADA">ELIMINAR ACTIVIDAD PLANIFICADA</option>
								</select>
							</div>
						</div>							
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Area*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="area_id">	
							  <option value="">SELECCIONE UNA AREA</option>
							  </select>
							</div>
						</div>	

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Actividad*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="activ_id">	
							  <option value="">SELECCIONE UNA ACTIVIDAD</option>
							  </select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Motivo*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea class="form-control" rows="3" placeholder="Ingresar motivo" id="sactiv_motivo"></textarea>
							</div>
						</div>

						<div class="form-group" id="autorizador" style="display:none">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Autorizador</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="usr_resp" class="form-control" disabled>
							</div>
						</div>						
						
						<div class="form-group" id="comentario" style="display:none">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Comentario</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<textarea class="form-control" rows="3" id="sactiv_comentario" disabled></textarea>
							</div>
						</div>						
						
						
						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_sactiv" type="button" class="btn btn-success" <?php if ($_SESSION['USR_TIPO'] <> 'SUPERVISOR'){ ?>  style="display:none" <?php } ?> >Registrar</button>
								<button id="btn_upd_sactiv" type="button" class="btn btn-success" style="display:none">Modificar</button>
								<button id="btn_del_sactiv" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_sactiv" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<button id="btn_oper_sactiv" type="button" class="btn btn-success" style="display:none">Agregar Operadores</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>
						
					</form>
						
						
						
					<div class="clearfix"></div>
					<br><br>
					<div class="form-group" <?php if($_SESSION['USR_TIPO'] == 'SUPERVISOR'){ ?> style="display:none" <?php } ?>>
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
						
						<div class="col-sm-5">
							<select class="select2_single form-control" tabindex="-1" id="sup_rut"   >
								<option value="" selected>TODOS LOS SUPERVISORES</option>
							</select>								
							<div class="help">Supervisor</div>
						</div>							
						
					</div>		
	
					<div class="x_panel">
						<div class="x_title">
							<h2>Listado de Solicitudes</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
						
						
							<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Día</th>
										<th>Área</th>
										<th>Actividad</th>
										<th>Solicitud</th>
										<th>Estado</th>
										<th>Motivo</th>
										<th>Supervisor</th>
										<th>Autorizador</th>
										<th>Comentario</th>
										<th>Cód Solicitud</th>
										<th>Cód Area</th>
										<th>Cód Actividad</th>									
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
<!-- /page content -->

<?php
include('footer.php');
?>