<?php 

	include('coneccion.php');
/*
	if(!isset($causas)){
		include('funciones_comunes.php');	
	}
*/	
	if(isset($_GET['data'])){
	
		$sql = "select distinct ct.ctiempo_cod, uv.undviv_id, uv.undviv_nombre, ct.ctiempo_causa 
		from CAUSA_TIEMPOS ct
		join UNIDAD_VIVEROS uv on ct.undviv_id = uv.undviv_id
		order by ct.ctiempo_cod";
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


	//elseif(isset($causas) ){
	elseif(isset($_POST['causas'])){	
	
		$undviv_id = $_POST['undviv_id'];
		
		$sql = "select distinct ctiempo_cod, concat(ctiempo_cod,' - ',ctiempo_causa) causa from CAUSA_TIEMPOS where undviv_id= $undviv_id order by ctiempo_cod";
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}		

		//$load_causas = json_encode($data);
		salida($data);
	}
	
	
	else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$ctiempo_cod = $_POST['ctiempo_cod'];
			$undviv_id = $_POST['undviv_id'];
			$ctiempo_causa = $_POST['ctiempo_causa'];
			
			if($ctiempo_cod == "" or $undviv_id == "" or $ctiempo_causa == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}

			$sql = "SELECT 1 FROM CAUSA_TIEMPOS where ctiempo_cod = $ctiempo_cod";
			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){
				
				$resp = array('cod'=>'error','desc'=>'ERROR: Ya existe este código de causa');
				salida($resp);
			}
			
			$sql = "insert into CAUSA_TIEMPOS(ctiempo_cod,undviv_id,ctiempo_causa) values ($ctiempo_cod,$undviv_id,'$ctiempo_causa')";
		}
		
		elseif($operacion == 'UPDATE'){
			
			$h_ctiempo_cod = $_POST['h_ctiempo_cod'];
			$ctiempo_cod = $_POST['ctiempo_cod'];
			$undviv_id = $_POST['undviv_id'];
			$ctiempo_causa = $_POST['ctiempo_causa'];
			
			if($h_ctiempo_cod == "" or $ctiempo_cod == "" or $undviv_id == "" or $ctiempo_causa == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			if($h_ctiempo_cod <> $ctiempo_cod){
				
				$sql = "SELECT 1 FROM CAUSA_TIEMPOS where ctiempo_cod = $ctiempo_cod";
				$resultado = mysqli_query($link,$sql);
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount > 0){
					
					$resp = array('cod'=>'error','desc'=>'ERROR: Ya existe este código de causa');
					salida($resp);
				}			
			}			
			
			$sql = "update CAUSA_TIEMPOS set ctiempo_cod = $ctiempo_cod,undviv_id = '$undviv_id',ctiempo_causa = '$ctiempo_causa' where ctiempo_cod = $h_ctiempo_cod";
		}	
		
		elseif($operacion == 'DELETE'){
			
			$h_ctiempo_cod = $_POST['h_ctiempo_cod'];
			
			if($h_ctiempo_cod == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from CAUSA_TIEMPOS where ctiempo_cod = $h_ctiempo_cod";
		}	
		
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
/*	
	if(!isset($causas)){
		echo json_encode($resp);	
	}
	
*/	
	//Retorna respuesta
	echo json_encode($resp);	
	
	//Salida Forzosa
	function salida($resp){	
		echo json_encode($resp);
		exit();
	}

?>