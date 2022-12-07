<?php

include('header.php');

$famysubactividades = 'carga inicial';
include('consultas/ges_crud_famactividades.php');

$areasyactividades = 'carga inicial';
include('consultas/ges_crud_areas.php');

$tipoactividades = 'carga inicial';
include('consultas/ges_crud_tipoactividades.php');

?>

<script type="text/javascript">
	var data_sfamactividades = <?php echo $load_famysubactividades; ?>;
	var data_areasyactividades = <?php echo $load_areasyactividades; ?>;
	var data_tipoactividades = <?php echo $load_tipoactividades; ?>;
</script>

<script type="text/javascript" src="js/ges_clasactividades.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Clasificación Actividad</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_cactiv" data-parsley-validate class="form-horizontal form-label-left">

						<input type="hidden" id="h_pactiv_id" value="" />
						<input type="hidden" id="h_tactiv_id" value="" />
						<input type="hidden" id="h_activ_id" value="" />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">SubFamilia*</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="sfactiv_id">
								<option value="">SELECCIONE SUBFAMILIA ACTIVIDAD</option>	
							  </select>
							</div>
						</div>						
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Actividad Padre*</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="pactiv_id">
								<option value="">SELECCIONE ACTIVIDAD PADRE</option>	
							  </select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo Actividad*</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="tactiv_id">
								<option value="">SELECCIONE TIPO ACTIVIDAD</option>	
							  </select>
							</div>
						</div>							
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Actividad(es)*</label>
							<div class="col-md-8 col-sm-8 col-xs-12">
							  <select multiple class="form-control" tabindex="-1" id="activ_id">
							  </select>
							</div>
						</div>	

					

						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_cactiv" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_cactiv" type="button" class="btn btn-success"style="display:none" >Modificar</button>
								<button id="btn_del_cactiv" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_cactiv" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Listado Clasificación de Actividades</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">

									<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive compact" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>ID SubFamilia</th>
												<th>ID Actividad Padre</th>
												<th>ID Actividad</th>
												<th>ID Tipo Actividad</th>
												<th>Familia Actividad</th>
												<th>SubFamilia Actividad</th>
												<th>Actividad Padre</th>
												<th>Tipo Actividad</th>
												<th>Actividad</th>												
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