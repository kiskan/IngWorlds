<?php 

	include('coneccion.php');
	//include('funciones_comunes.php');
	
	if(isset($_GET['data']) or isset($tipoactividades) ){
	
		$sql = "select distinct tactiv_id, tactiv_nombre from ACTIVIDAD_TIPO order by tactiv_nombre";
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
			$load_tipoactividades = json_encode($data);
		}		
	}

	
	
	else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$tactiv_nombre = $_POST['tactiv_nombre'];
			
			if($tactiv_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "insert into ACTIVIDAD_TIPO(tactiv_nombre) values ('$tactiv_nombre')";
		}
		
		elseif($operacion == 'UPDATE'){
			
			$tactiv_id = $_POST['tactiv_id'];
			$tactiv_nombre = $_POST['tactiv_nombre'];
			
			if($tactiv_id == "" or $tactiv_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "update ACTIVIDAD_TIPO set tactiv_nombre = '$tactiv_nombre' where tactiv_id = $tactiv_id";
		}	
		
		elseif($operacion == 'DELETE'){
			
			$tactiv_id = $_POST['tactiv_id'];
			
			if($tactiv_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from ACTIVIDAD_TIPO where tactiv_id = $tactiv_id";
		}	
		
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	if(!isset($tipoactividades)){
		include('funciones_comunes.php');
		//Retorna respuesta
		echo json_encode($resp);	
	}


?>