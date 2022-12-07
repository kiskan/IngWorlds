<?php
include('header.php');
?>
<script type="text/javascript" src="js/rut.js"></script>
<script type="text/javascript" src="js/ges_usuarios.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Gestión Usuarios</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_usuario" data-parsley-validate class="form-horizontal form-label-left">
						<input type="hidden" id="usr_id" value="" />
						<input type="hidden" id="usr_clave_h" value="" />
						<input type="hidden" id="usr_tipo_h" value="" />
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input type="text" id="usr_nombre" class="form-control" maxlength="100">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Username (RUT)</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input type="text" id="usr_rut" class="form-control" maxlength="12">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Contraseña</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input type="password" id="usr_clave" class="form-control" maxlength="20">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Repetir Contraseña</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input type="password" id="usr_clave2" class="form-control" maxlength="20">
							</div>
						</div>
						<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Sexo</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
									  <select class="select2_single form-control" tabindex="-1" id="usr_sexo">
										<option value="F">FEMENINO</option>
										<option value="M">MASCULINO</option>										
									  </select>
									</div>
						</div>					
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<input type="text" id="usr_email" class="form-control" maxlength="50">
							</div>
						</div>
						<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo Usuario</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
									  <select class="select2_single form-control" tabindex="-1" id="usr_tipo">
										<option value="SUPERVISOR"> SUPERVISOR </option>
										<option value="ADMINISTRADOR">ADMINISTRADOR</option>
										<option value="PLANIFICADOR">PLANIFICADOR</option>	
										<option value="SECRETARIA">SECRETARIA</option>	
										<option value="JEFE UNIDAD">JEFE UNIDAD</option>
										<option value="ENCARGADO RIEGO">ENCARGADO RIEGO</option>
										<option value="CONTROL AGUA">CONTROL AGUA</option>
										<option value="ENCARGADO PRODUCCION">ENCARGADO PRODUCCION</option>
										<option value="ENCARGADO BODEGA">ENCARGADO BODEGA</option>
										<option value="JEFE BODEGA">JEFE BODEGA</option>
									  </select>
									</div>
						</div>
						<div class="form-group">
									<label class="control-label col-md-3 col-sm-3 col-xs-12">Estado Usuario</label>
									<div class="col-md-3 col-sm-3 col-xs-12">
									  <select class="select2_single form-control" tabindex="-1" id="usr_estado">
										<option value="ACTIVO">ACTIVO</option>
										<option value="INACTIVO">INACTIVO</option>										
									  </select>
									</div>
						</div>

						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_reg_usuario" type="button" class="btn btn-success">Registrar</button>
								<button id="btn_upd_usuario" type="button" class="btn btn-success" style="display:none">Modificar</button>
								<button id="btn_del_usuario" type="button" class="btn btn-success" style="display:none">Eliminar</button>
								<button id="btn_can_usuario" type="button" class="btn btn-success" style="display:none">Cancelar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
							</div>
						</div>
						<div class="col-md-2"></div>
						<div class="col-md-8 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Listado de Usuarios</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">

									<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>	
												<th>Código</th>
												<th>Nombre</th>
												<th>Rut</th>
												<th>Contraseña</th>
												<th>Sexo</th>
												<th>Email</th>
												<th>Tipo</th>
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