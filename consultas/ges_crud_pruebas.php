<?php 

	include('coneccion.php');

	if(isset($_GET['data']) or isset($area)){
	
		$sql = "select area_id,area_nombre from AREA";	
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
			$load_areas = json_encode($data);
		}
		

	}else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$area_nombre = $_POST['area_nombre'];
			
			if($area_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "insert into AREA(area_nombre) values ('$area_nombre')";
		}
		
		elseif($operacion == 'UPDATE'){
			
			$area_id = $_POST['area_id'];
			$area_nombre = $_POST['area_nombre'];
			
			if($area_id == "" or $area_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "update AREA set area_nombre = '$area_nombre' where area_id = $area_id";
		}	
		
		elseif($operacion == 'DELETE'){
			
			$area_id = $_POST['area_id'];
			
			if($area_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from AREA where area_id = $area_id";
		}	
		
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	if(!isset($area)){
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