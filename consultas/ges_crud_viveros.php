<?php 

	include('coneccion.php');
	//include('funciones_comunes.php');
	
	if(isset($_GET['data']) or isset($viveros) ){
		session_start();
		if (isset($viveros) and $_SESSION['USR_TIPO'] == 'JEFE UNIDAD'){
			$usuario = $_SESSION['USR_ID'];
			$sql = "SELECT distinct u.undviv_id, u.undviv_nombre from JEFE_UNIDAD j join UNIDAD_VIVEROS u on j.UNDVIV_ID = u.UNDVIV_ID  WHERE j.USR_ID = $usuario";
		}else{		
			$sql = "select distinct undviv_id, undviv_nombre from UNIDAD_VIVEROS ";
		}

		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		
		
		if(isset($_GET['data'])){
			$resp = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData"=>$data);
		}else{
			$load_viveros = json_encode($data);
		}
				
	}	
	
	
	elseif(isset($unidviv)){
	
		$sql = "select distinct undviv_id, undviv_nombre from UNIDAD_VIVEROS order by 2";
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
					
		$load_unidviv = json_encode($data);
	}	
	
	
	else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$UNDVIV_NOMBRE = $_POST['undviv_nombre'];
			
			if($UNDVIV_NOMBRE == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "insert into UNIDAD_VIVEROS(UNDVIV_NOMBRE) values ('$UNDVIV_NOMBRE')";
		}
		
		elseif($operacion == 'UPDATE'){
			
			$UNDVIV_ID = $_POST['undviv_id'];
			$UNDVIV_NOMBRE = $_POST['undviv_nombre'];
			
			if($UNDVIV_ID == "" or $UNDVIV_NOMBRE == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "update UNIDAD_VIVEROS set UNDVIV_NOMBRE = '$UNDVIV_NOMBRE' where UNDVIV_ID = $UNDVIV_ID";
		}	
		
		elseif($operacion == 'DELETE'){
			
			$UNDVIV_ID = $_POST['undviv_id'];
			
			if($UNDVIV_ID == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from UNIDAD_VIVEROS where UNDVIV_ID = $UNDVIV_ID";
		}	
		
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	if(!isset($viveros) and !isset($unidviv)){
		include('funciones_comunes.php');
		//Retorna respuesta
		echo json_encode($resp);	
	}	

?>