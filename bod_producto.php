<?php
include('header.php');
$categoria = 'carga inicial';
include('consultas/bod_crud_catproducto.php');
?>
<script type="text/javascript">
	var data_categorias = <?php echo $load_categorias; ?>;
</script>
<script type="text/javascript" src="js/bod_producto.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2> Creación Materiales Bodega </h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_prod" data-parsley-validate class="form-horizontal form-label-left">
						<input type="hidden" id="h_prod_cod" value="" />

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Cód SAP</label>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<input type="text" id="prod_cod" class="form-control" maxlength="50">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Material SAP</label>
							<div class="col-md-5 col-sm-5 col-xs-12">
								<input type="text" id="prod_nombre" class="form-control" maxlength="100">
							</div>
						</div>
						<div class="form-group" style="display:none">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Categoría Material</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="catprod_id">
								<option value="">SELECCIONE UNA CATEGORÍA</option>
							  </select>
							</div>
						</div>
									
						<div class="form-group" style="display:none">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Unidad Medida</label>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<input type="text" id="prod_unidad" class="form-control" maxlength="10">
							</div>
						</div>									
									
						<div class="form-group" style="display:none">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Stock Mínimo</label>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<input type="text" id="prod_stockmin" class="form-control" maxlength="10">
							</div>
						</div>
						

						
						<div class="form-group" style="display:none">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Valor $</label>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<input type="text" id="prod_valor" class="form-control" maxlength="10">
							</div>
						</div>						

						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_prod" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_prod" type="button" class="btn btn-success" style="display:none">Modificar</button>
								<button id="btn_del_prod" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_prod" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Listado de Materiales</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">

									<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>	
												<th>Cód Categoría</th>
												<th>Cód Material</th>
												<th>Nombre</th>
												<th>Categoría</th>
												<th>Unidad</th>
												<th>Stock Mínimo</th>												
												<th>Valor $</th>
												<th>Cód SAP</th>
												<th>Nombre SAP</th>												
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