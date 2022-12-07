<?php
include('header.php');
$lineas = 'carga inicial';
include('consultas/time_crud_linea.php');
?>

<script type="text/javascript">
	var data_lineas = <?php echo $load_lineas; ?>;
</script>

<script type="text/javascript" src="js/timedead_metas.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Metas Líneas Productivas</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_metas_linea" data-parsley-validate class="form-horizontal form-label-left">				
						<input type="hidden" id="metli_id" value="" />

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Línea Productiva*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="lin_id">	
							  <option value="">SELECCIONE UNA LÍNEA</option>
							  </select>
							</div>
						</div>	
						
					
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Meta x Jornada</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input type="text" id="metli_unid" class="form-control" maxlength="12">
							</div>
						</div>
						
						<div class="form-group has-feedback">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Inicio Vigencia*</label>
							<div class="col-md-3 col-sm-3 col-xs-12 inner-addon left-addon">
								<input type="text" id="metli_inivig" class="form-control" value="" style="cursor:pointer" >
								<i class="glyphicon glyphicon-calendar form-control-feedback  fa fa-calendar"></i>
							</div>
						</div>											

						<div class="form-group has-feedback">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Fin Vigencia</label>
							<div class="col-md-3 col-sm-3 col-xs-12 inner-addon left-addon">
								<input type="text" id="metli_finvig" class="form-control" value="" style="cursor:pointer" >
								<i class="glyphicon glyphicon-calendar form-control-feedback  fa fa-calendar"></i>
							</div>					
						</div>
						
						
						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_metas_linea" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_metas_linea" type="button" class="btn btn-success" style="display:none">Modificar</button>
								<button id="btn_del_metas_linea" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_metas_linea" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>
							<div class="x_panel">
								<div class="x_title">
									<h2>Listado de Metas</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">

									<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>	
												<th>Línea Productiva</th>	
												<th>Meta</th>
												<th>Ini Vig</th>																						
												<th>Fin Vig</th>
												<th>Cód Línea</th>
												<th>Cód Meta</th>
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