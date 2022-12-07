<?php
include('header.php');
include('consultas/funciones_comunes.php');
?>

<script type="text/javascript" src="js/perfil.js"></script>

<!--page content -->
<div class="right_col" role="main">
	<!-- top tiles -->
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Editar Perfil</h2>

					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<form id="form_usuario" data-parsley-validate class="form-horizontal form-label-left">
					
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Nombre</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input type="text" id="usr_nombre" class="form-control" maxlength="100" value="<?php echo $_SESSION['USR_NOMBRE']; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Username (RUT)</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input type="text" id="usr_rut" class="form-control" maxlength="12" value="<?php echo formateo_rut($_SESSION['USR_RUT']); ?>" disabled>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Contraseña</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input type="password" id="usr_clave" class="form-control" maxlength="20" value="<?php echo $_SESSION['USR_CLAVE']; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Repetir Contraseña</label>
							<div class="col-md-3 col-sm-3 col-xs-12">
								<input type="password" id="usr_clave2" class="form-control" maxlength="20" value="<?php echo $_SESSION['USR_CLAVE']; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Email</label>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<input type="text" id="usr_email" class="form-control" maxlength="50" value="<?php echo $_SESSION['USR_EMAIL']; ?>">
							</div>
						</div>

						<div class="ln_solid"></div>

						<div class="form-group">
							<div class="col-md-3 col-sm-3"></div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<button id="btn_upd_supxperfil" type="button" class="btn btn-success">Modificar</button>
								<br>								
								<img src="images/loading.gif" id="loading" style="display:none">
								<span id="error" style="display:none; color:red" />								
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