<?php
include('header.php');
$categoria = 'carga inicial';
include('consultas/bod_crud_catproducto.php');
?>

<script type="text/javascript">
	var data_categorias = <?php echo $load_categorias; ?>;
</script>

<script type="text/javascript" src="js/bod_stock.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Gestión Stock</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_stock" data-parsley-validate class="form-horizontal form-label-left">
					
						<input type="hidden" id="h_prod_cod" value="" />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Categoría Material</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="catprod_id">	
							  <option value="">SELECCIONE CATEGORÍA</option>
							  </select>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Material</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="prod_cod">	
							  <option value="">SELECCIONE MATERIAL</option>
							  </select>
							</div>
						</div>						
					
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Stock</label>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<input type="text" id="prod_stock" class="form-control" maxlength="12">
							</div>
						</div>
						
						
						<div class="ln_solid"></div>

					<?php if ($_SESSION['USR_TIPO'] <> 'JEFE UNIDAD' AND $_SESSION['USR_TIPO'] <> 'ENCARGADO BODEGA'){ ?>
						
						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_stock" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_stock" type="button" class="btn btn-success" style="display:none">Modificar</button>
								<!--<button id="btn_del_stock" type="button" class="btn btn-success" style="display:none">Eliminar</button>-->
								<button id="btn_can_stock" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>
						
						<?php } ?> 
						
					
							<div class="x_panel">
								<div class="x_title">
									<h2>Gestión Stock</h2>
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
												<th>Categoría</th>
												<th>Cód Material</th>												
												<th>Material</th>
												<th>Stock</th>	
												<th>Stock Mínimo</th>
												<th>Unidad</th>
												<th>Precio Ref</th>
											</tr>
										</thead>

									</table>

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