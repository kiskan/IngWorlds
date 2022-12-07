<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['data'])){
	
		$sql = "SELECT PARAMFER_ID, DATE_FORMAT(PARAMFER_INIVIG,'%d-%m-%Y')PARAMFER_INIVIG, DATE_FORMAT(PARAMFER_FINVIG,'%d-%m-%Y')PARAMFER_FINVIG, 
		REPLACE(REPLACE(PARAMFER_IPH,'.',','),',0','')PARAMFER_IPH, PARAMFER_ICE, PARAMFER_ICAUDAL,
		REPLACE(REPLACE(PARAMFER_FPH,'.',','),',0','')PARAMFER_FPH, PARAMFER_FCE, PARAMFER_FCAUDAL
		FROM PARAM_FER ";	
	 	
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
	
	}else{
	

		$operacion = $_POST['operacion'];

		if($operacion == 'INSERT'){
		
			$paramfer_iph = str_replace(",", ".",$_POST['paramfer_iph']);
			$paramfer_fph = str_replace(",", ".",$_POST['paramfer_fph']);
			
			$paramfer_ice = $_POST['paramfer_ice'];
			$paramfer_fce = $_POST['paramfer_fce'];
			$paramfer_icaudal = $_POST['paramfer_icaudal'];
			$paramfer_fcaudal = $_POST['paramfer_fcaudal'];
			
			$paramfer_inivig = $_POST['paramfer_inivig'];
			$paramfer_finvig = $_POST['paramfer_finvig'];
			
			$eparamfer_inivig = explode("-" ,$paramfer_inivig);
			$inivig = $eparamfer_inivig[2].'-'.$eparamfer_inivig[1].'-'.$eparamfer_inivig[0];
			$dia_semana = date('N', strtotime($inivig));			

			if($paramfer_iph == "" or $paramfer_fph == "" or $paramfer_ice == "" or $paramfer_fce == "" or $paramfer_icaudal == "" or $paramfer_fcaudal == "" or $paramfer_inivig == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}			

			if(!is_numeric($paramfer_iph)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en PH mínimo');
				salida($resp);
			}
			
			if(!is_numeric($paramfer_fph)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en PH máximo');
				salida($resp);
			}	
			
			if(!is_numeric($paramfer_ice)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en CE mínimo');
				salida($resp);
			}			
			
			if(!is_numeric($paramfer_fce)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en CE máximo');
				salida($resp);
			}
			
			if(!is_numeric($paramfer_icaudal)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en Caudal mínimo');
				salida($resp);
			}	
			
			if(!is_numeric($paramfer_fcaudal)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en Caudal máximo');
				salida($resp);
			}				
			
			if($dia_semana <> '1'){
				$resp = array('cod'=>'error','desc'=>'Error: Debe iniciar un día LUNES');
				salida($resp);
			}			
			
			//checkdate($mes.$dia,$año)
			if (!checkdate ($eparamfer_inivig[1],$eparamfer_inivig[0],$eparamfer_inivig[2])){
				$resp = array('cod'=>'error','desc'=>'Error: formato de fecha (inicio vigencia) no válido');
				salida($resp);			
			}
			
			if(!empty($paramfer_finvig)){
				$eparamfer_finvig = explode("-" ,$paramfer_finvig);
				$finvig = $eparamfer_finvig[2].'-'.$eparamfer_finvig[1].'-'.$eparamfer_finvig[0];	
				
				if (!checkdate ($eparamfer_finvig[1],$eparamfer_finvig[0],$eparamfer_finvig[2])){
					$resp = array('cod'=>'error','desc'=>'Error: formato de fecha (fin vigencia) no válido');
					salida($resp);			
				}		

				$sql = " SELECT 1 FROM PARAM_FER WHERE PARAMFER_FINVIG is null AND PARAMFER_INIVIG <= '$finvig'";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}		
				
				$sql = " SELECT 1 FROM PARAM_FER WHERE 
					('$inivig' BETWEEN PARAMFER_INIVIG AND PARAMFER_FINVIG) OR
					('$finvig' BETWEEN PARAMFER_INIVIG AND PARAMFER_FINVIG) OR
					(PARAMFER_INIVIG BETWEEN '$inivig' AND '$finvig')";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}				
				
				$sql = "INSERT INTO PARAM_FER(PARAMFER_INIVIG, PARAMFER_FINVIG, PARAMFER_IPH, PARAMFER_ICE, PARAMFER_ICAUDAL, PARAMFER_FPH, PARAMFER_FCE, PARAMFER_FCAUDAL) VALUES ('$inivig', '$finvig', $paramfer_iph, $paramfer_ice, $paramfer_icaudal, $paramfer_fph, $paramfer_fce, $paramfer_fcaudal)";
			}
			else{		
			
				$sql = " SELECT 1 FROM PARAM_FER WHERE PARAMFER_FINVIG is null";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Ya existe una fecha sin fin de vigencia');
					salida($resp);			
				}			

				$sql = " SELECT 1 FROM PARAM_FER WHERE 
					('$inivig' BETWEEN PARAMFER_INIVIG AND PARAMFER_FINVIG) OR
					('$inivig' <= PARAMFER_FINVIG)";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}				
				
				$sql = "INSERT INTO PARAM_FER(PARAMFER_INIVIG, PARAMFER_FINVIG, PARAMFER_IPH, PARAMFER_ICE, PARAMFER_ICAUDAL, PARAMFER_FPH, PARAMFER_FCE, PARAMFER_FCAUDAL) VALUES ('$inivig', NULL, $paramfer_iph, $paramfer_ice, $paramfer_icaudal, $paramfer_fph, $paramfer_fce, $paramfer_fcaudal)";
			}		


		}
		
		elseif($operacion == 'UPDATE'){
			
			$h_paramfer_id = $_POST['h_paramfer_id'];
			
			$paramfer_iph = str_replace(",", ".",$_POST['paramfer_iph']);
			$paramfer_fph = str_replace(",", ".",$_POST['paramfer_fph']);
			
			$paramfer_ice = $_POST['paramfer_ice'];
			$paramfer_fce = $_POST['paramfer_fce'];
			$paramfer_icaudal = $_POST['paramfer_icaudal'];
			$paramfer_fcaudal = $_POST['paramfer_fcaudal'];
			
			$paramfer_inivig = $_POST['paramfer_inivig'];
			$paramfer_finvig = $_POST['paramfer_finvig'];
			
			$eparamfer_inivig = explode("-" ,$paramfer_inivig);
			$inivig = $eparamfer_inivig[2].'-'.$eparamfer_inivig[1].'-'.$eparamfer_inivig[0];
			$dia_semana = date('N', strtotime($inivig));

			if($h_paramfer_id == "" or $paramfer_iph == "" or $paramfer_fph == "" or $paramfer_ice == "" or $paramfer_fce == "" or $paramfer_icaudal == "" or $paramfer_fcaudal == "" or $paramfer_inivig == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}			

			if(!is_numeric($paramfer_iph)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en PH mínimo');
				salida($resp);
			}
			
			if(!is_numeric($paramfer_fph)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en PH máximo');
				salida($resp);
			}	
			
			if(!is_numeric($paramfer_ice)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en CE mínimo');
				salida($resp);
			}			
			
			if(!is_numeric($paramfer_fce)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en CE máximo');
				salida($resp);
			}
			
			if(!is_numeric($paramfer_icaudal)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en Caudal mínimo');
				salida($resp);
			}	
			
			if(!is_numeric($paramfer_fcaudal)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en Caudal máximo');
				salida($resp);
			}				
			
			if($dia_semana <> '1'){
				$resp = array('cod'=>'error','desc'=>'Error: Debe iniciar un día LUNES');
				salida($resp);
			}			
			
			//checkdate($mes.$dia,$año)
			if (!checkdate ($eparamfer_inivig[1],$eparamfer_inivig[0],$eparamfer_inivig[2])){
				$resp = array('cod'=>'error','desc'=>'Error: formato de fecha (inicio vigencia) no válido');
				salida($resp);			
			}			
			
			if(!empty($paramfer_finvig)){
				$eparamfer_finvig = explode("-" ,$paramfer_finvig);
				$finvig = $eparamfer_finvig[2].'-'.$eparamfer_finvig[1].'-'.$eparamfer_finvig[0];	
				
				if (!checkdate ($eparamfer_finvig[1],$eparamfer_finvig[0],$eparamfer_finvig[2])){
					$resp = array('cod'=>'error','desc'=>'Error: formato de fecha (fin vigencia) no válido');
					salida($resp);			
				}	

				$sql = " SELECT 1 FROM PARAM_FER WHERE PARAMFER_ID <> $h_paramfer_id AND PARAMFER_FINVIG is null AND PARAMFER_INIVIG <= '$finvig'";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}		
					
				$sql = " SELECT 1 FROM PARAM_FER WHERE PARAMFER_ID <> $h_paramfer_id AND (
					('$inivig' BETWEEN PARAMFER_INIVIG AND PARAMFER_FINVIG) OR
					('$finvig' BETWEEN PARAMFER_INIVIG AND PARAMFER_FINVIG) OR
					(PARAMFER_INIVIG BETWEEN '$inivig' AND '$finvig'))";						
					
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}
				
				$sql = "UPDATE PARAM_FER SET PARAMFER_INIVIG = '$inivig', PARAMFER_FINVIG = '$finvig', PARAMFER_IPH=$paramfer_iph, PARAMFER_ICE=$paramfer_ice, PARAMFER_ICAUDAL=$paramfer_icaudal, PARAMFER_FPH=$paramfer_fph, PARAMFER_FCE=$paramfer_fce, PARAMFER_FCAUDAL=$paramfer_fcaudal WHERE PARAMFER_ID = $h_paramfer_id";
			}else{
			
				$sql = "SELECT 1 FROM PARAM_FER WHERE PARAMFER_ID <> $h_paramfer_id AND PARAMFER_FINVIG is null";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Ya existe una fecha sin fin de vigencia');
					salida($resp);			
				}			
					
				$sql = " SELECT 1 FROM PARAM_FER WHERE PARAMFER_ID <> $h_paramfer_id AND (
					('$inivig' BETWEEN PARAMFER_INIVIG AND PARAMFER_FINVIG) OR
					('$inivig' <= PARAMFER_FINVIG))";						
					
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}			
						
				$sql = "UPDATE PARAM_FER SET PARAMFER_INIVIG = '$inivig', PARAMFER_FINVIG = NULL, PARAMFER_IPH=$paramfer_iph, PARAMFER_ICE=$paramfer_ice, PARAMFER_ICAUDAL=$paramfer_icaudal, PARAMFER_FPH=$paramfer_fph, PARAMFER_FCE=$paramfer_fce, PARAMFER_FCAUDAL=$paramfer_fcaudal WHERE PARAMFER_ID = $h_paramfer_id";
			}

		}	
		
		elseif($operacion == 'DELETE'){
			
			$h_paramfer_id = $_POST['h_paramfer_id'];
			
			if($h_paramfer_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "DELETE FROM PARAM_FER WHERE PARAMFER_ID=$h_paramfer_id";

		}		

		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	//Retorna respuesta
	echo json_encode($resp);	

?>