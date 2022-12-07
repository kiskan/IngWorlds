<?php
include('header.php');
$viveros = 'carga inicial';
include('consultas/ges_crud_viveros.php');
$jefeunidad = 'carga inicial';
include('consultas/ges_crud_usuarios.php');
$area = 'carga inicial';
include('consultas/ges_crud_areas.php');
?>
<script type="text/javascript">
	var data_viveros = <?php echo $load_viveros; ?>;
	var data_jefeunidad = <?php echo $load_jefeunidad; ?>;
	var data_areas = <?php echo $load_areas; ?>;
</script>
<script type="text/javascript" src="js/ges_jefevivero.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2> Asignación Jefe Unid. Viveros y Áreas a cargo</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_jefund" data-parsley-validate class="form-horizontal form-label-left">
						<input type="hidden" id="h_undviv_id" value="" />
						<input type="hidden" id="h_usr_id" value="" />
						<input type="hidden" id="h_jefund_estado" value="" />
						<input type="hidden" id="h_areas_id" value="" />

						<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Unid. Viveros</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
									  <select class="select2_single form-control" tabindex="-1" id="undviv_id">	
									  <option value="">SELECCIONE UNA UNIDAD VIVEROS</option>	
									  </select>
									</div>
						</div>
										
						<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Jefe Unid. Viveros</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
									  <select class="select2_single form-control" tabindex="-1" id="usr_id">
									  <option value="">SELECCIONE UN JEFE UNID.VIVEROS</option>	
									  </select>
									</div>
						</div>
<!--
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Estado Jefatura</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
									  <select class="select2_single form-control" tabindex="-1" id="jefund_estado">
										<option value="VIGENTE">VIGENTE</option>
										<option value="NO VIGENTE">NO VIGENTE</option>										
									  </select>
									</div>
						</div>				
-->
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Áreas a cargo</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <select multiple class="form-control" tabindex="-1" id="area_id">							
							  </select>
							</div>
						</div>						
						
						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_jefund" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_jefund" type="button" class="btn btn-success" style="display:none" >Modificar</button>
								<button id="btn_del_jefund" type="button" class="btn btn-success" style="display:none" >Eliminar</button>
								<button id="btn_can_jefund" type="button" class="btn btn-success" style="display:none" >Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>
					
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Listado de Jefes Unid. Viveros</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">

									<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>	
												<th>Cód Vivero</th>
												<th>Cód Jefe</th>												
												<th>Unid. Vivero</th>
												<th>Jefe Unid. Vivero</th>
												<!--<th>Estado</th>-->
												<th>Áreas a cargo</th>
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