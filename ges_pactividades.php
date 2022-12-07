<?php
include('header.php');
$famysubactividades = 'carga inicial';
include('consultas/ges_crud_famactividades.php');
?>
<script type="text/javascript">
	var data_sfamactividades = <?php echo $load_famysubactividades; ?>;
</script>
<script type="text/javascript" src="js/ges_pactividades.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Actividad Padre</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_pactiv" data-parsley-validate class="form-horizontal form-label-left">

						<input type="hidden" id="pactiv_id" value="" />
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">SubFamilia*</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="sfactiv_id">
								<option value="">SELECCIONE SUBFAMILIA ACTIVIDAD</option>	
							  </select>
							</div>
						</div>						
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Actividad Padre*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="pactiv_nombre" class="form-control">
							</div>
						</div>

						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_pactiv" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_pactiv" type="button" class="btn btn-success"style="display:none" >Modificar</button>
								<button id="btn_del_pactiv" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_pactiv" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-10 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Listado de Actividades Padre</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">

									<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>ID SubFamilia</th>
												<th>ID Actividad Padre</th>
												<th>Familia Actividad</th>
												<th>SubFamilia Actividad</th>
												<th>Actividad Padre</th>
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