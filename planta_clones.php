<?php
include('header.php');
?>

<script type="text/javascript" src="js/planta_clones.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Gestión Clones</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_clon" data-parsley-validate class="form-horizontal form-label-left">
						<input type="hidden" id="hclon_id" value="" />
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Clon*</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input type="text" id="clon_id" class="form-control" maxlength="10">
							</div>
						</div>
						
						<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Especie</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
									  <select class="select2_single form-control" tabindex="-1" id="clon_especie">
										<option value="GLOBULUS">GLOBULUS</option>
										<option value="HIBRIDO">HIBRIDO</option>										
									  </select>
									</div>
						</div>
						
						<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Estado</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
									  <select class="select2_single form-control" tabindex="-1" id="clon_estado">
										<option value="ACTIVO">ACTIVO</option>
										<option value="INACTIVO">INACTIVO</option>										
									  </select>
									</div>
						</div>						

						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_clon" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_clon" type="button" class="btn btn-success" style="display:none">Modificar</button>
								<button id="btn_del_clon" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_clon" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>
						<div class="col-md-2"></div>
						<div class="col-md-8 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Listado de Clones</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">

									<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>Clon</th>
												<th>Especie</th>
												<th>Estado</th>
											</tr>
										</thead>

									</table>

								</div>
							</div>
						</div>						  
						<div class="col-md-2"></div>
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