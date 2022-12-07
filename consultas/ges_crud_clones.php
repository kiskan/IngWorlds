<?php 

	include('coneccion.php');
	
	if(!isset($ini_clon)){
		include('funciones_comunes.php');	
	}	
	
	if(isset($_GET['data'])){
	
		$sql = "select clon_id, clon_especie, clon_estado from CLON";
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
					
		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);
	}
	
	elseif(isset($ini_clon)){
	
		$sql = "select clon_id, CONCAT(clon_id,' (Especie:', clon_especie,')') AS clon from CLON where clon_estado = 'ACTIVO'";
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
					
		$load_clones = json_encode($data);
	}	
	
	else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$clon_id = $_POST['clon_id'];
			$clon_especie = $_POST['clon_especie'];
			$clon_estado = $_POST['clon_estado'];
			
			if($clon_id == "" or $clon_especie == "" or $clon_estado == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "insert into CLON values ('$clon_id','$clon_especie','$clon_estado')";
		}
		
		elseif($operacion == 'UPDATE'){
			
			$clon_id = $_POST['clon_id'];
			$hclon_id = $_POST['hclon_id'];
			$clon_especie = $_POST['clon_especie'];
			$clon_estado = $_POST['clon_estado'];
			
			if($clon_id == "" or $clon_especie == "" or $clon_estado == "" or $hclon_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			if($clon_estado == 'INACTIVO'){
				$sql = "SELECT 1 FROM PISCINA WHERE CLON_ID = '$clon_id'";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);
			
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Clon registrado en piscina, no puede quedar Inactivo');
					salida($resp);						
				}		
			}
			
			$sql = "update CLON set clon_id = '$clon_id',clon_especie = '$clon_especie',clon_estado = '$clon_estado' where clon_id = '$hclon_id'";
		}	
		
		elseif($operacion == 'DELETE'){
			
			$hclon_id = $_POST['hclon_id'];
			
			if($hclon_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from CLON where clon_id = '$hclon_id'";
		}	
		
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}

	if(!isset($ini_clon)){
		//include('funciones_comunes.php');
		echo json_encode($resp);	
	}	
/*
	//Salida Forzosa
	function salida($resp){	
		echo json_encode($resp);
		exit();
	}
*/
?>