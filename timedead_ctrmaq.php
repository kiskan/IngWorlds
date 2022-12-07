<?php
include('header.php');
$lineas = 'carga inicial';
include('consultas/time_crud_linea.php');
?>

<script type="text/javascript">
	var data_lineas = <?php echo $load_lineas; ?>;
</script>

<script type="text/javascript" src="js/timedead_ctrmaq.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Control Maquinaria</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_ctrmaq" data-parsley-validate class="form-horizontal form-label-left">				
						<input type="hidden" id="ctrmaq_id" value="" />

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Línea Productiva*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="lin_id">	
							  <option value="">SELECCIONE UNA LÍNEA</option>
							  </select>
							</div>
						</div>	

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre Máquina*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="ctrmaq_nombre" class="form-control">
							</div>
						</div>	

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Disponibilidad Hora*</label>
							<div class="col-md-2 col-sm-2 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="ctrmaq_disphr">
								<?php for($i=1;$i<=24;$i++){ 
									echo '<option value="'.$i.'">'.$i.'</option>';
								} ?>	
							  </select>
							</div>
						</div>							
					
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Rendimiento*</label>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<input type="text" id="ctrmaq_rend" class="form-control" maxlength="12">
							</div>
						</div>
						
						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_ctrmaq" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_ctrmaq" type="button" class="btn btn-success" style="display:none">Modificar</button>
								<button id="btn_del_ctrmaq" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_ctrmaq" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>
							<div class="x_panel">
								<div class="x_title">
									<h2>Listado de Máquinas</h2>
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
												<th>Máquina</th>
												<th>Disp. Hora</th>																						
												<th>Rendimiento</th>
												<th>Cód Línea</th>
												<th>Cód Máquina</th>
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