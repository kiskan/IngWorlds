<?php 

	include('coneccion.php');
	//include('funciones_comunes.php');
	
	if(isset($_GET['data']) or isset($lineas) ){
	
		$sql = "select distinct lin_id, lin_nombre from LINEA order by lin_nombre";
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
			$load_lineas = json_encode($data);
		}		
	}

	
	else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$lin_nombre = $_POST['lin_nombre'];
			
			if($lin_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "insert into LINEA(lin_nombre) values ('$lin_nombre')";
		}
		
		elseif($operacion == 'UPDATE'){
			
			$lin_id = $_POST['lin_id'];
			$lin_nombre = $_POST['lin_nombre'];
			
			if($lin_id == "" or $lin_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "update LINEA set lin_nombre = '$lin_nombre' where lin_id = $lin_id";
		}	
		
		elseif($operacion == 'DELETE'){
			
			$lin_id = $_POST['lin_id'];
			
			if($lin_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from LINEA where lin_id = $lin_id";
		}	
		
		
		if (mysqli_query($link,$sql)) {
			$resp = array('cod'=>'ok','operacion'=>$operacion);
		}
		else{
			//$resp = array('cod'=>'error','desc'=>mysqli_error($link));			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
		}	
				
/*		
		try{
		$resultado = mysqli_query($link,$sql);
		}
		catch(){
			$resp = array('cod'=>'error','desc'=>$resultado->errno);
		}
*/		
/*
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
*/		
	}
	
	if(!isset($lineas)){
		include('funciones_comunes.php');
		//Retorna respuesta
		echo json_encode($resp);
	}


?>