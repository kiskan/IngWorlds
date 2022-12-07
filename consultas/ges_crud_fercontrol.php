<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['ctrlagua_id'])){
		
		session_start();
	
/*	
		$sql = "SELECT FER.CTRLAGUA_ID, CTRL.SEM_NUM, CTRL.PER_AGNO, DATE_FORMAT(CTRLAGUA_DIA,'%d-%m-%Y') as CTRLAGUA_DIA, CTRL.CTRLAGUA_HORA, 
		PIS_ID, PIS_PM, REPLACE(REPLACE(FER_PH,'.',','),',0','') FER_PH, FER_CE, FER_CAUDAL, FER_COMENTARIO
		FROM FERTILIZACION FER JOIN CONTROL_AGUA CTRL ON FER.CTRLAGUA_ID = CTRL.CTRLAGUA_ID
		WHERE SEM_NUM =".$_GET['num_sem']." AND PER_AGNO =".$_GET['per_agno']." AND CTRLAGUA_DIA ='".$_GET['dia']."' AND CTRLAGUA_HORA ='".$_GET['hora']."' AND
		( USR_ID = ".$_SESSION['USR_ID']." OR '".$_SESSION['USR_TIPO']."' = 'ADMINISTRADOR' ) 
		ORDER BY CTRLAGUA_HORA, PIS_PM, PIS_ID";
*/		
		$sql = "SELECT FER.CTRLAGUA_ID, CTRL.SEM_NUM, CTRL.PER_AGNO, DATE_FORMAT(CTRLAGUA_DIA,'%d-%m-%Y') as CTRLAGUA_DIA, CTRL.CTRLAGUA_HORA, 
		PIS_ID, PIS_PM, REPLACE(REPLACE(FER_PH,'.',','),',0','') FER_PH, FER_CE, FER_CAUDAL, FER_COMENTARIO
		FROM FERTILIZACION FER JOIN CONTROL_AGUA CTRL ON FER.CTRLAGUA_ID = CTRL.CTRLAGUA_ID
		WHERE CTRL.CTRLAGUA_ID =".$_GET['ctrlagua_id']." AND
		( FER.USR_ID = ".$_SESSION['USR_ID']." OR '".$_SESSION['USR_TIPO']."' = 'ADMINISTRADOR' ) 
		ORDER BY CTRLAGUA_HORA, PIS_PM, PIS_ID";		
		
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
/*
				{ data:'CTRLAGUA_ID'},
				{ data:'SEM_NUM'},
				{ data:'PER_AGNO'},				
				{ data:'CTRLAGUA_DIA'},
				{ data:'CTRLAGUA_HORA'},
				{ data:'PIS_PM'},
				{ data:'PIS_ID'},		
				{ data:'FER_PH'},
				{ data:'FER_CE'},				
				{ data:'FER_CAUDAL'},			
				{ data:'FER_COMENTARIO'}	
	*/		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		
		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);	

	}
	
	//CARGA LAS HORAS DEL DIA SEGUN CONTROL AGUA
	elseif(isset($_POST['ctrlagua_dia'])){
	
		$per_agno = $_POST['per_agno'];
		$sem_num = $_POST['sem_num'];	
		$ctrlagua_dia = $_POST['ctrlagua_dia'];	
	
		$sql = "SELECT CTRLAGUA_ID,CTRLAGUA_HORA FROM CONTROL_AGUA WHERE PER_AGNO = $per_agno AND SEM_NUM = $sem_num AND CTRLAGUA_DIA = '$ctrlagua_dia' ORDER BY CTRLAGUA_HORA";
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);		
	}

	else{
		session_start();
		$operacion = $_POST['operacion'];

		if($operacion == 'INSERT'){
				
			$h_ctrlagua_id = $_POST['h_ctrlagua_id'];
			$pis_pm = $_POST['pis_pm'];
			$pis_id = $_POST['pis_id'];
			$fer_ph = str_replace(",", ".",$_POST['fer_ph']);
			$fer_ce = $_POST['fer_ce'];
			$fer_caudal = $_POST['fer_caudal'];
			$fer_caudal = !empty($fer_caudal) ? "$fer_caudal" : "NULL";
			$fer_comentario = $_POST['fer_comentario'];	
			
			$asignante = $_SESSION['USR_ID'];
							
			if($h_ctrlagua_id == "" or  $pis_pm == "" or  $pis_id == "" or  $fer_ph == "" or  $fer_ce == "" or  $asignante == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}

			$sql= "INSERT INTO FERTILIZACION(CTRLAGUA_ID,PIS_PM,PIS_ID,USR_ID,FER_PH,FER_CE,FER_CAUDAL,FER_COMENTARIO) VALUES ($h_ctrlagua_id, '$pis_pm', $pis_id,  $asignante, $fer_ph, $fer_ce, $fer_caudal, '$fer_comentario')";
			//$resp = array('cod'=>'error','desc'=>$sql);
			//salida($resp);
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			
	
		}
		
		elseif($operacion == 'UPDATE'){
		
			$h_ctrlagua_id_orig = $_POST['h_ctrlagua_id_orig'];
			$h_ctrlagua_id = $_POST['h_ctrlagua_id'];
			$h_pis_pm = $_POST['h_pis_pm'];
			$h_pis_id = $_POST['h_pis_id'];			
			$pis_pm = $_POST['pis_pm'];
			$pis_id = $_POST['pis_id'];
			$fer_ph = str_replace(",", ".",$_POST['fer_ph']);
			$fer_ce = $_POST['fer_ce'];
			$fer_caudal = $_POST['fer_caudal'];
			$fer_caudal = !empty($fer_caudal) ? "$fer_caudal" : "NULL";
			$fer_comentario = $_POST['fer_comentario'];			
							
			if($h_ctrlagua_id_orig == "" or  $h_ctrlagua_id == "" or  $pis_pm == "" or  $pis_id == "" or  $h_pis_pm == "" or  $h_pis_id == "" or  $fer_ph == "" or  $fer_ce == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}

			$sql = "UPDATE FERTILIZACION SET CTRLAGUA_ID = $h_ctrlagua_id,PIS_ID = $pis_id,PIS_PM = '$pis_pm',FER_PH = $fer_ph,FER_CE = $fer_ce,FER_CAUDAL = $fer_caudal,FER_COMENTARIO = '$fer_comentario' WHERE CTRLAGUA_ID = $h_ctrlagua_id_orig AND PIS_PM = '$h_pis_pm' AND PIS_ID = $h_pis_id ";
			//$resp = array('cod'=>'error','desc'=>$sql);
			//salida($resp);
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
			$resultado = mysqli_query($link,$sql)or die(salida($resp));		
		}
		
		elseif($operacion == 'DELETE'){
			
			$h_ctrlagua_id_orig = $_POST['h_ctrlagua_id_orig'];
			$h_pis_pm = $_POST['h_pis_pm'];
			$h_pis_id = $_POST['h_pis_id'];	
			
			if($h_ctrlagua_id_orig == "" or $h_pis_pm == "" or  $h_pis_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
			
			$sql = "DELETE FROM FERTILIZACION WHERE CTRLAGUA_ID = $h_ctrlagua_id_orig AND PIS_PM = '$h_pis_pm' AND PIS_ID = $h_pis_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
		}		

		$resp = array('cod'=>'ok','operacion'=>$operacion);		
			
	}
	
	
	//Retorna respuesta
	echo json_encode($resp);
	exit();		
	
	
?>