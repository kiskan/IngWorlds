<?php
	
//Envío de email

	require("class.phpmailer.php");	

	$para  = $email;

	// título
	$título = 'Envío de clave';

	// mensaje
	$mensaje = '
	<html>
	<head>
	  <title>Recuperación de clave</title>
	</head>
	<body>
		<center>
		<p>Su clave para ingresar al sistema web SISCONVI-PRODUCTION es: </p>
		<h2>'.$clave.'</h2>
		</center>
	</body>
	</html>
	';

	// Para enviar un correo HTML, debe establecerse la cabecera Content-type
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";

	// Cabeceras adicionales
	//$cabeceras .= 'To: '.$nombre.' <'.$email.'>' . "\r\n";
	$cabeceras .= 'From: Recuperación clave web<operaciones@ing-worlds.cl>' . "\r\n".
    'X-Mailer: PHP/'.phpversion();
	//$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
	//$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";

	// Enviarlo
	mail($para, $título, $mensaje, $cabeceras);	


?>