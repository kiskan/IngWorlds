<?php 
	include('coneccion.php');
	include('funciones_comunes.php');

//LOGIN	
	if(isset($_POST['login'])){

		$login_rut = str_replace(".", "",$_POST['login_rut']);
		$login_pass = $_POST['login_pass'];	
	
		$sql = "SELECT USR_NOMBRE, USR_TIPO, USR_EMAIL, USR_RUT, USR_CLAVE, USR_SEXO, USR_ID FROM USUARIOS WHERE USR_RUT = '$login_rut' AND USR_CLAVE = '$login_pass' AND USR_ESTADO = 'ACTIVO'";
		$resultado = mysqli_query($link,$sql);	
		$rowcount = mysqli_num_rows($resultado);

		if($rowcount > 0){
		
			$fila = mysqli_fetch_row($resultado);
			$USR_NOMBRE = $fila[0];
			$USR_TIPO = $fila[1];
			$USR_EMAIL = $fila[2];
			$USR_RUT = $fila[3];
			$USR_CLAVE = $fila[4];
			$USR_SEXO = $fila[5];
			$USR_ID = $fila[6];
			session_start();
			$_SESSION['USR_RUT'] = $USR_RUT;
			$_SESSION['USR_CLAVE'] = $USR_CLAVE;			
			$_SESSION['USR_NOMBRE'] = $USR_NOMBRE;
			$_SESSION['USR_EMAIL'] = $USR_EMAIL;
			$_SESSION['USR_TIPO'] = $USR_TIPO;
			$_SESSION['USR_SEXO'] = $USR_SEXO;
			$_SESSION['USR_ID'] = $USR_ID;
			$resp = array('cod'=>'ok');					
		}else{
			$resp = array('cod'=>'error','desc'=>'Error: RUT y/o clave errónea');	
		}
		salida($resp);
	}

//RECUPERAR CLAVE	
	elseif(isset($_POST['recuperar_clave'])){

		$login_rut = str_replace(".", "",$_POST['login_rut']);	
	
		$sql = "SELECT USR_NOMBRE, USR_EMAIL, USR_CLAVE FROM USUARIOS WHERE USR_RUT = '$login_rut' AND USR_ESTADO = 'ACTIVO'";
		$resultado = mysqli_query($link,$sql);	
		$rowcount = mysqli_num_rows($resultado);

		if($rowcount > 0){
			$fila = mysqli_fetch_row($resultado);
			$nombre = $fila[0];$email = $fila[1];$clave = $fila[2];
			include('enviar_email.php');
			//$resp = ($status_envioEmail == 'S') ? array('cod'=>'ok') : array('cod'=>'error','desc'=>'Error: Favor intentarlo más tarde');
			$resp = array('cod'=>'ok');
		}else{
			$resp = array('cod'=>'error','desc'=>'Error: RUT no registrado');	
		}
		salida($resp);
	}
?>