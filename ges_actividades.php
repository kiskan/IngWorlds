<?php
include('header.php');
$area = 'carga inicial';
include('consultas/ges_crud_areas.php');

$unidad = 'carga inicial';
include('consultas/ges_crud_unidades.php');
?>
<script type="text/javascript">
	var data_areas = <?php echo $load_areas; ?>;
	var data_unidades = <?php echo $load_unidades; ?>;
</script>
<script type="text/javascript" src="js/ges_actividades.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Gestión Actividades</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_actividad" data-parsley-validate class="form-horizontal form-label-left">

						<input type="hidden" id="activ_id" value="" />
				
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Area*</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="activ_area">
								<option value="">SELECCIONE UNA AREA</option>	
							  </select>
							</div>
						</div>						
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Actividad*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="activ_nombre" class="form-control" maxlength="250">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Unidad</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="activ_unidad">
								<option value="">SELECCIONE UNA UNIDAD</option>							
							  </select>
							</div>
						</div>	
						
						<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Competencia Estándar?*</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
									  <select class="select2_single form-control" tabindex="-1" id="activ_standar">
										<option value="S">SI</option>
										<option value="N">NO</option>										
									  </select>
									</div>
						</div>		
						
						<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo Actividad*</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
									  <select class="select2_single form-control" tabindex="-1" id="activ_tipo">
										<option value="APOYO">APOYO</option>
										<option value="PRODUCTIVA">PRODUCTIVA</option>										
									  </select>
									</div>
						</div>						
						
						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_actividad" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_actividad" type="button" class="btn btn-success" style="display:none">Modificar</button>
								<button id="btn_del_actividad" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_actividad" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-10 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Listado de Actividades</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">

									<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>	
												<th>ID_Actividad</th>
												<th>ID_Area</th>												
												<th>ID_Unidad</th>											
												<th>Area</th>
												<th>Actividad</th>
												<th>Unidad</th>
												<th>Estándar</th>
												<th>Tipo</th>
											</tr>
										</thead>

									</table>

								</div>
							</div>
						</div>						  
						<div class="col-md-1"></div>
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