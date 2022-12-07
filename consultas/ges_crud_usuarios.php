<?php 

	include('coneccion.php');
	if(!isset($destinatarios) && !isset($solicitantes)){
		include('funciones_comunes.php');	
	}
	
	if(isset($solicitantes)){
		
		$sql = "SELECT USR_ID, USR_NOMBRE FROM USUARIOS WHERE USR_ESTADO='ACTIVO' /*AND USR_RUT NOT IN('13796372-8','16863650-4')*/ 
		ORDER BY USR_NOMBRE";		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();	
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		$load_solicitantes = json_encode($data);
	}		

	if(isset($_GET['data'])){
	
		//$sql = "SELECT USR_ID, USR_RUT, USR_CLAVE, USR_ESTADO, USR_SEXO, USR_EMAIL, USR_TIPO, USR_NOMBRE FROM USUARIOS WHERE USR_TIPO IN ('SUPERVISOR','PLANIFICADOR','SECRETARIA')";	
		$sql = "SELECT USR_ID, USR_RUT, USR_CLAVE, USR_ESTADO, USR_SEXO, USR_EMAIL, USR_TIPO, USR_NOMBRE FROM USUARIOS WHERE USR_TIPO NOT IN ('ADMINISTRADOR')";		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();

		while( $rows = mysqli_fetch_assoc($resultset) ) {
			//$data[] = $rows;
			$data[] = 
			Array
			(
				'USR_ID' => $rows[USR_ID],
				'USR_RUT' => formateo_rut($rows[USR_RUT]),
				'USR_CLAVE' => $rows[USR_CLAVE],
				'USR_SEXO' => $rows[USR_SEXO],
				'USR_ESTADO' => $rows[USR_ESTADO],
				'USR_EMAIL' => $rows[USR_EMAIL],
				'USR_TIPO' => $rows[USR_TIPO],
				'USR_NOMBRE' => $rows[USR_NOMBRE]
			);			
		}

		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);
	
	}
	elseif(isset($_POST['perfil'])){
		$usr_nombre = trim($_POST['usr_nombre']);
		$usr_clave = trim($_POST['usr_clave']);
		$usr_email = trim($_POST['usr_email']);

		if($usr_nombre == "" or $usr_clave == "" or $usr_email == ""){
			$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
			salida($resp);
		}	
		
		session_start();
		$usr_id = $_SESSION['USR_ID'];
		$usr_rut = $_SESSION['USR_RUT'];
		$usr_clave_session = $_SESSION['USR_CLAVE'];
		
		if($usr_clave <> $usr_clave_session){
		
			$sql = "SELECT USR_TIPO FROM USUARIOS where usr_rut = '$usr_rut' and usr_clave = '$usr_clave'";		

			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){
			
				$fila = mysqli_fetch_row($resultado);
				$USR_TIPO = $fila[0];		
				$resp = array('cod'=>'error','desc'=>'Rut y clave ya está registrado como '.$USR_TIPO);
				salida($resp);
			}
			
		}
		
		$sql = "update USUARIOS set usr_nombre = '$usr_nombre', usr_clave = '$usr_clave', usr_email = '$usr_email' where usr_id = $usr_id";
		
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	
		
		$_SESSION['USR_CLAVE'] = $usr_clave;			
		$_SESSION['USR_NOMBRE'] = $usr_nombre;
		$_SESSION['USR_EMAIL'] = $usr_email;			

		$resp = array('cod'=>'ok');		
	}
	
	elseif(isset($jefeunidad)){
	
		$sql = "SELECT USR_ID, USR_NOMBRE FROM USUARIOS WHERE USR_TIPO= 'JEFE UNIDAD'";		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();	
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		$load_jefeunidad = json_encode($data);
	}
	
	elseif(isset($destinatarios)){
		
		$sql = "SELECT CONCAT(USR_ID,'**U') AS ID_DEST, USR_NOMBRE AS DESTINATARIO FROM USUARIOS WHERE USR_ESTADO='ACTIVO'/* AND USR_RUT NOT IN('13796372-8','16863650-4')*/ 
		AND USR_RUT NOT IN (SELECT OPER_RUT FROM OPERADOR)
		UNION SELECT CONCAT(OPER_RUT,'**O') AS ID_DEST,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS DESTINATARIO from OPERADOR 
		ORDER BY DESTINATARIO";		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();	
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		$load_destinatarios = json_encode($data);
	}	
	
	
	
	else{
	

		$operacion = $_POST['operacion'];

		if($operacion == 'INSERT'){
			
			$usr_nombre = $_POST['usr_nombre'];
			$usr_rut = str_replace(".", "",$_POST['usr_rut']);
			$usr_clave = $_POST['usr_clave'];
			$usr_sexo = $_POST['usr_sexo'];
			$usr_email = $_POST['usr_email'];
			$usr_tipo = $_POST['usr_tipo'];
			$usr_estado = $_POST['usr_estado'];
			
			if($usr_nombre == "" or $usr_rut == "" or $usr_clave == "" or $usr_email == "" or $usr_tipo == "" or $usr_estado == "" or $usr_sexo == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "SELECT USR_TIPO FROM USUARIOS where usr_rut = '$usr_rut' AND usr_tipo = '$usr_tipo'";		

			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){
			
				$fila = mysqli_fetch_row($resultado);
				$USR_TIPO = $fila[0];		
				$resp = array('cod'=>'error','desc'=>'Este usuario ya está registrado como '.$USR_TIPO);
				salida($resp);
			}
			
			$sql = "SELECT USR_TIPO FROM USUARIOS where usr_rut = '$usr_rut' and usr_clave = '$usr_clave'";		

			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){
			
				$fila = mysqli_fetch_row($resultado);
				$USR_TIPO = $fila[0];		
				$resp = array('cod'=>'error','desc'=>'Rut y clave ya está registrado como '.$USR_TIPO);
				salida($resp);
			}
			
			if($usr_tipo == 'SUPERVISOR'){
				$sql = "SELECT SUP_RUT FROM SUPERVISOR where sup_rut = '$usr_rut'";		

				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount == 0){
	
					$resp = array('cod'=>'error','desc'=>'Para este tipo de usuario lo debes registrar antes en el formulario de Supervisores.');
					salida($resp);
				}				
			}
					
			
			$sql = "INSERT INTO USUARIOS(USR_RUT, USR_CLAVE, USR_ESTADO, USR_EMAIL, USR_TIPO, USR_NOMBRE, USR_SEXO) VALUES ('$usr_rut','$usr_clave','$usr_estado','$usr_email','$usr_tipo','$usr_nombre','$usr_sexo')";
		}
		
		elseif($operacion == 'UPDATE'){
			
			$usr_nombre = $_POST['usr_nombre'];
			$usr_rut = str_replace(".", "",$_POST['usr_rut']);
			$usr_clave = $_POST['usr_clave'];
			$usr_clave_h = $_POST['usr_clave_h'];
			$usr_id = $_POST['usr_id'];
			$usr_sexo = $_POST['usr_sexo'];
			$usr_email = $_POST['usr_email'];
			$usr_tipo = $_POST['usr_tipo'];
			$usr_tipo_h = $_POST['usr_tipo_h'];
			$usr_estado = $_POST['usr_estado'];
			
			if($usr_nombre == "" or $usr_rut == "" or $usr_clave == "" or $usr_email == "" or $usr_tipo == "" or $usr_estado == "" or $usr_sexo == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			if($usr_tipo == 'SUPERVISOR'){
				$sql = "SELECT SUP_RUT FROM SUPERVISOR where sup_rut = '$usr_rut'";		

				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount == 0){
	
					$resp = array('cod'=>'error','desc'=>'Para este tipo de usuario lo debes registrar antes en el formulario de Supervisores.');
					salida($resp);
				}				
			}			
			
			if($usr_tipo <> $usr_tipo_h){
			
				$sql = "SELECT USR_TIPO FROM USUARIOS where usr_rut = '$usr_rut' AND usr_tipo = '$usr_tipo'";		

				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount > 0){
				
					$fila = mysqli_fetch_row($resultado);
					$USR_TIPO = $fila[0];		
					$resp = array('cod'=>'error','desc'=>'Este usuario ya está registrado como '.$USR_TIPO);
					salida($resp);
				}
			}
			
			if($usr_clave <> $usr_clave_h){
			
				$sql = "SELECT USR_TIPO FROM USUARIOS where usr_rut = '$usr_rut' and usr_clave = '$usr_clave'";		

				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount > 0){
				
					$fila = mysqli_fetch_row($resultado);
					$USR_TIPO = $fila[0];		
					$resp = array('cod'=>'error','desc'=>'Rut y clave ya está registrado como '.$USR_TIPO);
					salida($resp);
				}
				
			}

			$sql = "update USUARIOS set usr_nombre = '$usr_nombre', usr_clave = '$usr_clave', usr_email = '$usr_email', usr_tipo = '$usr_tipo', usr_estado = '$usr_estado', usr_sexo = '$usr_sexo' where usr_id = $usr_id";
		}	
		
		elseif($operacion == 'DELETE'){
			
			//$usr_rut = str_replace(".", "",$_POST['usr_rut']);
			$usr_id = $_POST['usr_id'];
			
			if($usr_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from USUARIOS where usr_id = $usr_id";
		}	
	
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	if(!isset($jefeunidad)){
		echo json_encode($resp);	
	}	
	
?>