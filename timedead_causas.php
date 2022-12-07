<?php
include('header.php');

$unidviv = 'carga inicial';
include('consultas/ges_crud_viveros.php');
?>

<script type="text/javascript">

	var data_unidviv = <?php echo $load_unidviv; ?>;
	
</script>

<script type="text/javascript" src="js/timedead_causas.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Causas Tiempos Muertos y Detenciones</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_ctiempo" data-parsley-validate class="form-horizontal form-label-left">

						<input type="hidden" id="h_ctiempo_cod" value="" />

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Código Causa*</label>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<input type="text" id="ctiempo_cod" class="form-control" maxlength="10">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Unidad Vivero*</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<select class="select2_single form-control" tabindex="-1" id="undviv_id">	
									<option value="">SELECCIONE UNIDAD VIVERO</option>
								</select>	
							</div>
						</div>						
	
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Causa*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="ctiempo_causa" class="form-control">
							</div>
						</div>

						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_ctiempo" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_ctiempo" type="button" class="btn btn-success"style="display:none" >Modificar</button>
								<button id="btn_del_ctiempo" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_ctiempo" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-10 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Listado de Causas</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">

									<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>Cód Causa</th>
												<th>Cód UnidViv</th>
												<th>Unidad Vivero</th>
												<th>Causa</th>
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