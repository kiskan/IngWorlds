<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['data'])){
	
		$sql = "SELECT AREA.AREA_NOMBRE, ACT.ACTIV_NOMBRE, MET_UNDXHR, UND.UND_NOMBRE, DATE_FORMAT(MET_INIVIG,'%d-%m-%Y') as MET_INIVIG, DATE_FORMAT(MET_FINVIG,'%d-%m-%Y') as MET_FINVIG, AREA.AREA_ID, ACT.ACTIV_ID, MET.MET_ID FROM METAS MET JOIN ACTIVIDAD ACT ON MET.ACTIV_ID = ACT.ACTIV_ID JOIN AREA ON AREA.AREA_ID = ACT.AREA_ID JOIN UNIDAD AS UND ON ACT.UND_ID = UND.UND_ID ORDER BY AREA.AREA_ID, ACT.ACTIV_ID,DATE_FORMAT(MET_INIVIG,'%Y-%m-%d')";	
	 	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
	
		while( $rows = mysqli_fetch_assoc($resultset) ) {
		
			$data[] = 
			Array
			(
				'AREA_NOMBRE' => $rows[AREA_NOMBRE],
				'ACTIV_NOMBRE' => $rows[ACTIV_NOMBRE],
				//'MET_UNDXHR' => rtrim(number_format($rows[MET_UNDXHR],2,',','.'), ',0'),	
				'MET_UNDXHR' => str_replace(',00','',str_replace(".", ",",$rows[MET_UNDXHR])),
				'UND_NOMBRE' => $rows[UND_NOMBRE],
				'MET_INIVIG' => $rows[MET_INIVIG],
				'MET_FINVIG' => $rows[MET_FINVIG],
				'AREA_ID' => $rows[AREA_ID],
				'ACTIV_ID' => $rows[ACTIV_ID],
				'MET_ID' => $rows[MET_ID]
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

			$met_activ = $_POST['met_activ'];
			$met_undxhr = str_replace(",", ".",$_POST['met_undxhr']);
			
			$inivig = explode("-" , $_POST['met_inivig']);
			$met_inivig = $inivig[2].'-'.$inivig[1].'-'.$inivig[0];
			$dia_semana = date('N', strtotime($met_inivig));			

			if($met_activ == "" or $met_undxhr == "" or $_POST['met_inivig']== ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}			

			if(!is_numeric($met_undxhr)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en Meta');
				salida($resp);
			}
			
			if($dia_semana <> '1'){
				$resp = array('cod'=>'error','desc'=>'Error: Debe iniciar un día LUNES');
				salida($resp);
			}			
			
			//checkdate($mes.$dia,$año)
			if (!checkdate ($inivig[1],$inivig[0],$inivig[2])){
				$resp = array('cod'=>'error','desc'=>'Error: formato de fecha (inicio vigencia) no válido');
				salida($resp);			
			}
			
			if(!empty($_POST['met_finvig'])){
				$finvig = explode("-" ,$_POST['met_finvig']);
				$met_finvig = $finvig[2].'-'.$finvig[1].'-'.$finvig[0];	
				
				if (!checkdate ($finvig[1],$finvig[0],$finvig[2])){
					$resp = array('cod'=>'error','desc'=>'Error: formato de fecha (fin vigencia) no válido');
					salida($resp);			
				}		

				$sql = " SELECT MET_ID FROM METAS WHERE ACTIV_ID = $met_activ AND MET_FINVIG is null AND MET_INIVIG <= '$met_finvig'";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}		
				
				$sql = " SELECT MET_ID FROM METAS WHERE ACTIV_ID = $met_activ AND(
					('$met_inivig' BETWEEN MET_INIVIG AND MET_FINVIG) OR
					('$met_finvig' BETWEEN MET_INIVIG AND MET_FINVIG) OR
					(MET_INIVIG BETWEEN '$met_inivig' AND '$met_finvig'))";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}				
				
				$sql = "INSERT INTO METAS(ACTIV_ID, MET_UNDXHR, MET_INIVIG, MET_FINVIG) VALUES ($met_activ,$met_undxhr,'$met_inivig','$met_finvig')";
			}
			else{
			
				$sql = " SELECT MET_ID FROM METAS WHERE ACTIV_ID = $met_activ AND MET_FINVIG is null";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Ya existe una fecha sin fin de vigencia');
					salida($resp);			
				}			

				$sql = " SELECT MET_ID FROM METAS WHERE ACTIV_ID = $met_activ AND(
					('$met_inivig' BETWEEN MET_INIVIG AND MET_FINVIG) OR
					('$met_inivig' <= MET_FINVIG))";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}				
				
				$sql = "INSERT INTO METAS(ACTIV_ID, MET_UNDXHR, MET_INIVIG, MET_FINVIG) VALUES ($met_activ,$met_undxhr,'$met_inivig',NULL)";
			}		


		}
		
		elseif($operacion == 'UPDATE'){
			
			$met_id = $_POST['met_id'];
			$met_activ = $_POST['met_activ'];
			$met_undxhr = str_replace(",", ".",$_POST['met_undxhr']);
			
			$inivig = explode("-" , $_POST['met_inivig']);
			$met_inivig = $inivig[2].'-'.$inivig[1].'-'.$inivig[0];	

			if($met_id == "" or $met_activ == "" or $met_undxhr == "" or $_POST['met_inivig']== ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}	
			
			if(!is_numeric($met_undxhr)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en Meta');
				salida($resp);
			}
			
			//checkdate($mes.$dia,$año)
			if (!checkdate ($inivig[1],$inivig[0],$inivig[2])){
				$resp = array('cod'=>'error','desc'=>'Error: formato de fecha (inicio vigencia) no válido');
				salida($resp);			
			}			
			
			if(!empty($_POST['met_finvig'])){
				$finvig = explode("-" ,$_POST['met_finvig']);
				$met_finvig = $finvig[2].'-'.$finvig[1].'-'.$finvig[0];	
				
				if (!checkdate ($finvig[1],$finvig[0],$finvig[2])){
					$resp = array('cod'=>'error','desc'=>'Error: formato de fecha (fin vigencia) no válido');
					salida($resp);			
				}		

				$sql = " SELECT MET_ID FROM METAS WHERE MET_ID <> $met_id AND ACTIV_ID = $met_activ AND MET_FINVIG is null AND MET_INIVIG <= '$met_finvig'";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}		
				
				$sql = " SELECT MET_ID FROM METAS WHERE MET_ID <> $met_id AND ACTIV_ID = $met_activ AND(
					('$met_inivig' BETWEEN MET_INIVIG AND MET_FINVIG) OR
					('$met_finvig' BETWEEN MET_INIVIG AND MET_FINVIG) OR
					(MET_INIVIG BETWEEN '$met_inivig' AND '$met_finvig'))";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}
				
				$sql = "UPDATE METAS SET ACTIV_ID = $met_activ, MET_UNDXHR = $met_undxhr, MET_INIVIG = '$met_inivig', MET_FINVIG = '$met_finvig' WHERE MET_ID = $met_id";
			}else{
			
				$sql = " SELECT MET_ID FROM METAS WHERE MET_ID <> $met_id AND ACTIV_ID = $met_activ AND MET_FINVIG is null";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Ya existe una fecha sin fin de vigencia');
					salida($resp);			
				}			

				$sql = " SELECT MET_ID FROM METAS WHERE MET_ID <> $met_id AND ACTIV_ID = $met_activ AND(
					('$met_inivig' BETWEEN MET_INIVIG AND MET_FINVIG) OR
					('$met_inivig' <= MET_FINVIG))";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Solapamiento de fechas');
					salida($resp);			
				}			
						
				$sql = "UPDATE METAS SET ACTIV_ID = $met_activ, MET_UNDXHR = $met_undxhr, MET_INIVIG = '$met_inivig', MET_FINVIG = NULL WHERE MET_ID = $met_id";
			}

		}	
		
		elseif($operacion == 'DELETE'){
			
			$met_id = $_POST['met_id'];
			
			if($met_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "DELETE FROM METAS WHERE MET_ID=$met_id";

		}		

		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	//Retorna respuesta
	echo json_encode($resp);	

?>