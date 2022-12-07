<?php
include('header.php');
$operador = 'carga inicial';
include('consultas/ges_crud_operadores.php');
$area = 'carga inicial';
include('consultas/ges_crud_areas.php');
?>

<script type="text/javascript">
	var data_operadores = <?php echo $load_operadores; ?>;
	var data_areas = <?php echo $load_areas; ?>;
</script>

<script type="text/javascript" src="js/ges_competencias.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Gestión Competencias del Operador</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_competencias" data-parsley-validate class="form-horizontal form-label-left">				
						<input type="hidden" id="h_oper_rut" value="" />
						<input type="hidden" id="h_activ_id" value="" />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Operador*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="oper_rut">	
							  <option value="">SELECCIONE UN OPERADOR</option>
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
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Actividad(es) Competente*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <select multiple class="form-control" tabindex="-1" id="activ_id">							
							  </select>
							</div>
						</div>
						
						
						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_competencias" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_competencias" type="button" class="btn btn-success" style="display:none">Modificar</button>
								<button id="btn_del_competencias" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_competencias" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>
							<div class="x_panel">
								<div class="x_title">
									<h2>Listado de Competencias</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">

									<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>Operador</th>
												<th>Area</th>
												<th>Actividad(es) Competente</th>
												<th>Cód Actividad</th>
												<th>Rut Operador</th>
												<th>Cód Area</th>											
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