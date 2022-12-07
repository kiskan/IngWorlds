<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="es-ES" lang="es-ES" xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
	<meta content="text/javascript" http-equiv="Content-Script-Type">
	<meta content="text/css" http-equiv="Content-Style-Type">
	<meta http-equiv="X-UA-Compatible" content="IE=100">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ing-Worlds: SISCONVI-PRODUCTION</title>
    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">	
    <!-- Sweetalert -->
    <link href="../vendors/sweetalert/sweetalert.css" rel="stylesheet">		
	<link href="css/login.css" type="text/css" rel="stylesheet">	
	
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>	
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- Sweetalert -->
	<script src="../vendors/sweetalert/sweetalert.min.js"></script>	
	
	<script src="js/rut.js"></script> 
	<script src="js/recuperar_clave.js"></script> 

</head>
<body>

<div id="wrap">
	<div class="container">
		<div class="logo">
			<div class="thumbnail">
			<a href="http://www.ing-worlds.cl" target="_blank"><img title="Ing-Worlds S.A" alt="Ing-Worlds S.A" src="images/logo_sisconvi.png"></a>
			
			</div>
		</div>
		
		<div class="clearfix"></div>
			
		
		<form>
		
			<div class="col-lg-2 col-sm-3"></div>
			
			<div class="col-lg-8 col-sm-6">
				<div class="header_login">
					<span>Para enviar su clave al correo electrónico registrado debes ingresar tu RUT</span>
				</div>
				<div class="cuadro_login">				
					<div class="formulario_login">

							<label class="texto">RUT</label>
							<input autocomplete='off' type="text" class="form-control" id="login_rut" placeholder="Ingresa tu RUT" maxlength="12">						
							<br>
							<input type="button" id="btn_login" style="width:100%" class="btn btn-success" value="Ingresar">

					</div>
					<p class="text-center"><a href="login.php">Volver al login</a></p>
					<br>					
					<center><img src="images/loading.gif" id="loading" style="display:none"></center>					

					<br>					
				</div>
				<br><br>
				<p class="text-center">Ing-Worlds S.A. - Sotrosur <?php echo date('Y'); ?></p>
				
			</div>
			
			<div class="col-lg-2 col-sm-3"></div>
		</form>
	</div>
</div>

</body>
</html>
