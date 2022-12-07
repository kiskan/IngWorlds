<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['data'])){
	
		$sql = "SELECT LINEA.LIN_NOMBRE, METLI_UNID, DATE_FORMAT(METLI_INIVIG,'%d-%m-%Y') as METLI_INIVIG, 
		DATE_FORMAT(METLI_FINVIG,'%d-%m-%Y') as METLI_FINVIG, LINEA.LIN_ID, MET.METLI_ID 
		FROM METAS_LINEA MET 
		JOIN LINEA ON LINEA.LIN_ID = MET.LIN_ID 
		ORDER BY LINEA.LIN_NOMBRE,DATE_FORMAT(METLI_INIVIG,'%Y-%m-%d')";	
	 	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();

		while( $rows = mysqli_fetch_assoc($resultset) ) {
		
			$data[] = 
			Array
			(
				'LIN_NOMBRE' => $rows[LIN_NOMBRE],
				'METLI_UNID' => str_replace(',00','',str_replace(".", ",",$rows[METLI_UNID])),
				'METLI_INIVIG' => $rows[METLI_INIVIG],
				'METLI_FINVIG' => $rows[METLI_FINVIG],
				'LIN_ID' => $rows[LIN_ID],
				'METLI_ID' => $rows[METLI_ID]
			);			
		}
	
		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);	
	
	}else{
	

		$operacion = $_POST['operacion'];

		if($operacion == 'INSERT'){

			$lin_id = $_POST['lin_id'];
			$metli_unid = str_replace(",", ".",$_POST['metli_unid']);			
			$inivig = explode("-" , $_POST['metli_inivig']);
			$metli_inivig = $inivig[2].'-'.$inivig[1].'-'.$inivig[0];	

			if($lin_id == "" or $metli_unid == "" or $_POST['metli_inivig']== ""){
				$resp = array('cod'=>'error','desc'=>'ingresar datos obligatorios');
				salida($resp);
			}			

			if(!is_numeric($metli_unid)){
				$resp = array('cod'=>'error','desc'=>'error: dato no numérico en meta');
				salida($resp);
			}
			
			//checkdate($mes.$dia,$año)
			if (!checkdate ($inivig[1],$inivig[0],$inivig[2])){
				$resp = array('cod'=>'error','desc'=>'error: formato de fecha (inicio vigencia) no válido');
				salida($resp);			
			}
			
			if(!empty($_POST['metli_finvig'])){
				$finvig = explode("-" ,$_POST['metli_finvig']);
				$metli_finvig = $finvig[2].'-'.$finvig[1].'-'.$finvig[0];	
				
				if (!checkdate ($finvig[1],$finvig[0],$finvig[2])){
					$resp = array('cod'=>'error','desc'=>'error: formato de fecha (fin vigencia) no válido');
					salida($resp);			
				}		

				$sql = " SELECT METLI_ID FROM METAS_LINEA WHERE LIN_ID = $lin_id AND METLI_FINVIG is null AND METLI_INIVIG <= '$metli_finvig'";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}		
				
				$sql = " SELECT METLI_ID FROM METAS_LINEA WHERE LIN_ID = $lin_id AND(
					('$metli_inivig' BETWEEN METLI_INIVIG AND METLI_FINVIG) OR
					('$metli_finvig' BETWEEN METLI_INIVIG AND METLI_FINVIG) OR
					(METLI_INIVIG BETWEEN '$metli_inivig' AND '$metli_finvig'))";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}				
				
				$sql = "INSERT INTO METAS_LINEA(LIN_ID, METLI_UNID, METLI_INIVIG, METLI_FINVIG) VALUES ($lin_id,$metli_unid,'$metli_inivig','$metli_finvig')";
			}
			else{
			
				$sql = " SELECT METLI_ID FROM METAS_LINEA WHERE LIN_ID = $lin_id AND METLI_FINVIG is null";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Ya existe una fecha sin fin de vigencia');
					salida($resp);			
				}			

				$sql = " SELECT METLI_ID FROM METAS_LINEA WHERE LIN_ID = $lin_id AND(
					('$metli_inivig' BETWEEN METLI_INIVIG AND METLI_FINVIG) OR
					('$metli_inivig' <= METLI_FINVIG))";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}				
				
				$sql = "INSERT INTO METAS_LINEA(LIN_ID, METLI_UNID, METLI_INIVIG, METLI_FINVIG) VALUES ($lin_id,$metli_unid,'$metli_inivig',NULL)";
			}		


		}
		
		elseif($operacion == 'UPDATE'){
			
			$metli_id = $_POST['metli_id'];
			$lin_id = $_POST['lin_id'];
			$metli_unid = str_replace(",", ".",$_POST['metli_unid']);			
			$inivig = explode("-" , $_POST['metli_inivig']);
			$metli_inivig = $inivig[2].'-'.$inivig[1].'-'.$inivig[0];


			if($metli_id == "" or $lin_id == "" or $metli_unid == "" or $_POST['metli_inivig']== ""){
				$resp = array('cod'=>'error','desc'=>'ingresar datos obligatorios');
				salida($resp);
			}	
			
			if(!is_numeric($metli_unid)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en Meta');
				salida($resp);
			}
			
			//checkdate($mes.$dia,$año)
			if (!checkdate ($inivig[1],$inivig[0],$inivig[2])){
				$resp = array('cod'=>'error','desc'=>'Error: formato de fecha (inicio vigencia) no válido');
				salida($resp);			
			}			
			
			if(!empty($_POST['metli_finvig'])){
				$finvig = explode("-" ,$_POST['metli_finvig']);
				$metli_finvig = $finvig[2].'-'.$finvig[1].'-'.$finvig[0];	
				
				if (!checkdate ($finvig[1],$finvig[0],$finvig[2])){
					$resp = array('cod'=>'error','desc'=>'Error: formato de fecha (fin vigencia) no válido');
					salida($resp);			
				}		

				$sql = " SELECT METLI_ID FROM METAS_LINEA WHERE METLI_ID <> $metli_id AND LIN_ID = $lin_id AND METLI_FINVIG is null AND METLI_INIVIG <= '$metli_finvig'";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}		
				
				$sql = " SELECT METLI_ID FROM METAS_LINEA WHERE METLI_ID <> $metli_id AND LIN_ID = $lin_id AND(
					('$metli_inivig' BETWEEN METLI_INIVIG AND METLI_FINVIG) OR
					('$metli_finvig' BETWEEN METLI_INIVIG AND METLI_FINVIG) OR
					(METLI_INIVIG BETWEEN '$metli_inivig' AND '$metli_finvig'))";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}
				
				$sql = "UPDATE METAS_LINEA SET LIN_ID = $lin_id, METLI_UNID = $metli_unid, METLI_INIVIG = '$metli_inivig', METLI_FINVIG = '$metli_finvig' WHERE METLI_ID = $metli_id";
			}else{
			
				$sql = " SELECT METLI_ID FROM METAS_LINEA WHERE METLI_ID <> $metli_id AND LIN_ID = $lin_id AND METLI_FINVIG is null";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Ya existe una fecha sin fin de vigencia');
					salida($resp);			
				}			

				$sql = " SELECT METLI_ID FROM METAS_LINEA WHERE METLI_ID <> $metli_id AND LIN_ID = $lin_id AND(
					('$metli_inivig' BETWEEN METLI_INIVIG AND METLI_FINVIG) OR
					('$metli_inivig' <= METLI_FINVIG))";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}			
						
				$sql = "UPDATE METAS_LINEA SET LIN_ID = $lin_id, METLI_UNID = $metli_unid, METLI_INIVIG = '$metli_inivig', METLI_FINVIG = NULL WHERE METLI_ID = $metli_id";
			}

		}	
		
		elseif($operacion == 'DELETE'){
			
			$metli_id = $_POST['metli_id'];
			
			if($metli_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "DELETE FROM METAS_LINEA WHERE METLI_ID=$metli_id";

		}		

		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	//Retorna respuesta
	echo json_encode($resp);	

?>