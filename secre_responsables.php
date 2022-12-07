<?php
include('header.php');
$plan_periodo = 'carga inicial';
include('consultas/ges_crud_periodo.php');
?>

<script type="text/javascript">
	var data_periodos = <?php echo $load_periodos; ?>;
	var data_semanas = <?php echo $load_semanas; ?>;
	var corresponding_week = <?php echo $corresponding_week; ?>;
	var corresponding_agno = <?php echo $corresponding_agno; ?>;
</script>

<script type="text/javascript" src="js/secre_responsables.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Responsables Fin de Semana</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					
					<form data-parsley-validate class="form-horizontal form-label-left">			
				
					<div class="form-group">
					
						<div class="col-sm-2">
							<select class="select2_single form-control" tabindex="-1" id="per_agno"></select>															
							<div class="help">Año</div>
						</div>
						<div class="col-sm-4">
							<select class="select2_single form-control" tabindex="-1" id="sem_num"></select>															
							<div class="help">Semana</div>
						</div>																	
	
					</div>
					
					<div class="ln_solid"></div>
					<div class="clearfix"></div>
					
					<div class="form-group">
						<label class="col-sm-12 col-xs-12">RESPONSABLE PRODUCCIÓN</label>
						<div class="col-sm-4 col-xs-8">
							<input type="text" id="RESP_PROD" class="form-control">								
							<div class="help">Nombre</div>
						</div>
						<div class="col-sm-2 col-xs-4">
							<input type="text" id="RESP_PRODXFONO" class="form-control" maxlength="8">							
							<div class="help">Celular</div>
						</div>							
					</div>							
	
				<div class="clearfix"></div>
					
					<div class="form-group">
						<label class="col-sm-12 col-xs-12">BRIGADISTA TURNO SÁBADO Y DOMINGO</label>
						<div class="col-sm-4 col-xs-8">
							<input type="text" id="BRIGAD_SAB" class="form-control">								
							<div class="help">Nombre - Sábado</div>
						</div>
						<div class="col-sm-2 col-xs-4">
							<input type="text" id="BRIGAD_SABXFONO" class="form-control" maxlength="8">							
							<div class="help">Celular - Sábado</div>
						</div>		
						
						<div class="col-sm-4 col-xs-8">
							<input type="text" id="BRIGAD_DOM" class="form-control">								
							<div class="help">Nombre - Domingo</div>
						</div>
						<div class="col-sm-2 col-xs-4">
							<input type="text" id="BRIGAD_DOMXFONO" class="form-control" maxlength="8">							
							<div class="help">Celular - Domingo</div>
						</div>							
						
					</div>						

					<div class="clearfix"></div>
						
					<div class="form-group">
						<label class="col-sm-12 col-xs-12">RESPONSABLE MANTENIMIENTO</label>
						<div class="col-sm-4 col-xs-8">
							<input type="text" id="RESP_MAN1" class="form-control">								
							<div class="help">Nombre</div>
						</div>
						<div class="col-sm-2 col-xs-4">
							<input type="text" id="RESP_MANXFONO1" class="form-control" maxlength="8">							
							<div class="help">Celular</div>
						</div>	
						
						<div class="col-sm-4 col-xs-8">
							<input type="text" id="RESP_MAN2" class="form-control">								
							<div class="help">Nombre</div>
						</div>
						<div class="col-sm-2 col-xs-4">
							<input type="text" id="RESP_MANXFONO2" class="form-control" maxlength="8">							
							<div class="help">Celular</div>
						</div>						
						
					</div>					
									
					
					<div class="clearfix"></div><br>
					
					<div class="col-sm-12">	
						<p style="display:block;text-align:justify;">
							<input type="checkbox" id="chk_tope">&nbsp;Replicar acción de aquí en adelante para esta semana en este año
						</p>
					</div>					
				
				
					</form>

					<div class="clearfix"></div><br>	

					<div class="form-group">
						
							<button id="btn_reg_resp" type="button" class="btn btn-success">Registrar</button>
							<button id="btn_upd_resp" type="button" class="btn btn-success" style="display:none">Modificar</button>
							<button id="btn_del_resp" type="button" class="btn btn-success" style="display:none">Eliminar</button>
							<button id="btn_can_resp" type="button" class="btn btn-success" style="display:none">Cancelar</button>
						
							<br>								
							<img src="images/loading.gif" id="loading" style="display:none">
							<span id="error" style="display:none; color:red" />								
						
					</div>								
				
		

					<div class="ln_solid"></div>
					<div class="clearfix"></div>	

	
	
	
					<div class="clearfix"></div>					


					<div class="col-md-12 col-sm-12 col-xs-12">					
					
						<div class="x_panel">
							<div class="x_title">
								<h2>Responsables</h2>

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
											<th>Responsable Producción</th>
											<th>Celular</th>
											<th>Brigadista Sábado</th>
											<th>Celular</th>
											<th>Brigadista Domingo</th>
											<th>Celular</th>
											<th>Responsable Mantenimiento 1</th>
											<th>Celular</th>
											<th>Responsable Mantenimiento 2</th>
											<th>Celular</th>											
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