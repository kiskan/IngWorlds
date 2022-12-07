<?php
include('header.php');
$area = 'carga inicial';
include('consultas/ges_crud_areas.php');

include('consultas/comunas.php');
?>
<script type="text/javascript">
	var data_areas = <?php echo $load_areas; ?>;
	var data_comunas = <?php echo $load_comunas; ?>;
	var fecha_actual = <?php echo date('Y-m-d'); ?>;
</script>
<script type="text/javascript" src="js/rut.js"></script>
<script type="text/javascript" src="js/ges_operadores.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Gestión Operadores</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_operador" data-parsley-validate class="form-horizontal form-label-left">				
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">R.U.T*</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input type="text" id="oper_rut" class="form-control" maxlength="12">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombres*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="oper_nombres" class="form-control" maxlength="100">
							</div>
						</div>						

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Apellido Paterno*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="oper_paterno" class="form-control" maxlength="100">
							</div>
						</div>						

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Apellido Materno*</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="oper_materno" class="form-control" maxlength="100">
							</div>
						</div>			
						
						<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Sexo*</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
									  <select class="select2_single form-control" tabindex="-1" id="oper_sexo">
										<option value="F">FEMENINO</option>
										<option value="M">MASCULINO</option>										
									  </select>
									</div>
						</div>						

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Estado Civil*</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
									  <select class="select2_single form-control" tabindex="-1" id="oper_civil">
										<option value="SOLTERO">SOLTERO</option>
										<option value="CASADO">CASADO</option>	
										<option value="SEPARADO">SEPARADO</option>
										<option value="DIVORCIADO">DIVORCIADO</option>
										<option value="VIUDO">VIUDO</option>
									  </select>
									</div>
						</div>						
<!-- -->
						<div class="form-group has-feedback">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Fecha Nacimiento*</label>
							<div class="col-md-3 col-sm-3 col-xs-12 inner-addon left-addon">
								<input type="text" id="oper_fechanac" class="form-control" value="01-01-<?php echo date('Y') - 20; ?>" style="cursor:pointer" >
								<i class="glyphicon glyphicon-calendar form-control-feedback  fa fa-calendar"></i>
							</div>	<label id="oper_edad" class="control-label"></label>					
						</div>											
						
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Dirección</label>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<input type="text" id="oper_direccion" class="form-control" maxlength="250">
							</div>
						</div>						

						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12">Comuna*</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
							  <select class="select2_single form-control" tabindex="-1" id="oper_comuna">
								<option value="">SELECCIONE UNA COMUNA</option>	
							  </select>
							</div>
						</div>							
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Fono</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input type="text" id="oper_fono" class="form-control" maxlength="100">
							</div>
						</div>	
						
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input type="text" id="oper_email" class="form-control" maxlength="100">
							</div>
						</div>							
												

						<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Estado Operador*</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
									  <select class="select2_single form-control" tabindex="-1" id="oper_estado">
										<option value="VIGENTE">VIGENTE</option>
										<option value="NO VIGENTE">NO VIGENTE</option>										
									  </select>
									</div>
						</div>													
						
						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_operador" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_operador" type="button" class="btn btn-success" style="display:none">Modificar</button>
								<button id="btn_del_operador" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_operador" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div><!--
						<div class="col-md-2"></div>
						<div class="col-md-8 col-sm-12 col-xs-12">-->
							<div class="x_panel">
								<div class="x_title">
									<h2>Listado de Operadores</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">

									<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>	
												<th>RUT</th>
												<th>Nombre</th>		
												<th>Estado</th>												
												<th>Cód Comuna</th>
												<th>Nombres</th>
												<th>Paterno</th>
												<th>Materno</th>
												<th>Sexo</th>
												<th>Facha Nac.</th>
												<th>Dirección</th>
												<th>Fono</th>
												<th>Email</th>
												<th>Estado Civil</th>
											</tr>
										</thead>
									</table>

								</div>
							</div>
						</div>						  
						<!--<div class="col-md-2"></div>-->
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