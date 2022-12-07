<?php 

	include('coneccion.php');

	if(isset($_GET['data']) or isset($unidad)){
	
		$sql = "select und_id,und_nombre from UNIDAD";	
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
			$load_unidades = json_encode($data);
		}

	}else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$und_nombre = $_POST['und_nombre'];
			
			if($und_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "insert into UNIDAD(und_nombre) values ('$und_nombre')";
		}
		
		elseif($operacion == 'UPDATE'){
			
			$und_id = $_POST['und_id'];
			$und_nombre = $_POST['und_nombre'];
			
			if($und_id == "" or $und_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "update UNIDAD set und_nombre = '$und_nombre' where und_id = $und_id";
		}	
		
		elseif($operacion == 'DELETE'){
			
			$und_id = $_POST['und_id'];
			
			if($und_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from UNIDAD where und_id = $und_id";
		}	
		
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	if(!isset($unidad)){
		include('funciones_comunes.php');
		//Retorna respuesta
		echo json_encode($resp);	
	}	
	/*
	//Salida Forzosa
	function salida($resp){	
		echo json_encode($resp);
		exit();
	}*/
?>