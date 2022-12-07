<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['data'])){
	
		session_start();
	
		$sql = "SELECT CTRLAGUA_ID,SEM_NUM,PER_AGNO,DATE_FORMAT(CTRLAGUA_DIA,'%d-%m-%Y') as CTRLAGUA_DIA, CTRLAGUA_HORA, CTRLAGUA_TK2,CTRLAGUA_TK3,CTRLAGUA_TK4,
		REPLACE(REPLACE(CTRLAGUA_PH,'.',','),',0','') CTRLAGUA_PH
		,CTRLAGUA_CE,CTRLAGUA_CAUDAL,CTRLAGUA_COMENTARIO
		FROM CONTROL_AGUA
		WHERE SEM_NUM =".$_GET['data']." AND PER_AGNO =".$_GET['per_agno']." AND CTRLAGUA_DIA ='".$_GET['dia']."' AND
		( USR_ID = ".$_SESSION['USR_ID']." OR '".$_SESSION['USR_TIPO']."' = 'ADMINISTRADOR' ) 
		ORDER BY CTRLAGUA_HORA";	
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

	else{
		session_start();
		$operacion = $_POST['operacion'];

		if($operacion == 'INSERT'){
				
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$CTRLAGUA_dia = $_POST['ctrlagua_dia'];
			$CTRLAGUA_hora = $_POST['ctrlagua_hora'];
			$CTRLAGUA_TK2 = $_POST['ctrlagua_tk2'];
			$CTRLAGUA_TK3 = $_POST['ctrlagua_tk3'];
			$CTRLAGUA_TK4 = $_POST['ctrlagua_tk4'];
			$CTRLAGUA_ph = str_replace(",", ".",$_POST['ctrlagua_ph']);
			$CTRLAGUA_ce = $_POST['ctrlagua_ce'];
			$CTRLAGUA_caudal = $_POST['ctrlagua_caudal'];
			$CTRLAGUA_caudal = !empty($CTRLAGUA_caudal) ? "$CTRLAGUA_caudal" : "NULL";
			$CTRLAGUA_comentario = $_POST['ctrlagua_comentario'];
			
			$asignante = $_SESSION['USR_ID'];
		
			if($per_agno == "" or $sem_num == "" or $CTRLAGUA_dia == "" or $CTRLAGUA_hora == "" or $CTRLAGUA_TK2 == "" or $CTRLAGUA_TK3 == "" or $CTRLAGUA_TK4 == "" or $CTRLAGUA_ph == "" or $CTRLAGUA_ce == "" or  $asignante == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			$sql = "select USR_NOMBRE from CONTROL_AGUA CTRLAGUA JOIN USUARIOS USR ON USR.USR_ID = CTRLAGUA.USR_ID where CTRLAGUA_DIA = '$CTRLAGUA_dia' AND CTRLAGUA_HORA = '$CTRLAGUA_hora'";
			$resultado = mysqli_query($link,$sql);
			
			if(mysqli_num_rows($resultado) > 0){
				$fila = mysqli_fetch_row($resultado);
				$USR_NOMBRE = $fila[0];				
				$resp = array('cod'=>'existe_registro','desc'=>'Día/Hora ya registrada por '.$USR_NOMBRE);
				salida($resp);
			}			

			$sql= "INSERT INTO CONTROL_AGUA(SEM_NUM,PER_AGNO,CTRLAGUA_DIA,CTRLAGUA_HORA,CTRLAGUA_PH,CTRLAGUA_CE,CTRLAGUA_CAUDAL,CTRLAGUA_COMENTARIO,CTRLAGUA_TK2,CTRLAGUA_TK3,CTRLAGUA_TK4, USR_ID) VALUES ($sem_num, $per_agno, '$CTRLAGUA_dia', '$CTRLAGUA_hora', $CTRLAGUA_ph, $CTRLAGUA_ce, $CTRLAGUA_caudal, '$CTRLAGUA_comentario', $CTRLAGUA_TK2, $CTRLAGUA_TK3, $CTRLAGUA_TK4, $asignante)";
			//$resp = array('cod'=>'error','desc'=>$sql);
			//salida($resp);
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			
	
		}
		
		elseif($operacion == 'UPDATE'){
		
			$h_CTRLAGUA_id = $_POST['h_ctrlagua_id'];
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$CTRLAGUA_dia = $_POST['ctrlagua_dia'];
			$CTRLAGUA_hora = $_POST['ctrlagua_hora'];
			$CTRLAGUA_TK2 = $_POST['ctrlagua_tk2'];
			$CTRLAGUA_TK3 = $_POST['ctrlagua_tk3'];
			$CTRLAGUA_TK4 = $_POST['ctrlagua_tk4'];
			$CTRLAGUA_ph = str_replace(",", ".",$_POST['ctrlagua_ph']);
			$CTRLAGUA_ce = $_POST['ctrlagua_ce'];
			$CTRLAGUA_caudal = $_POST['ctrlagua_caudal'];
			$CTRLAGUA_caudal = !empty($CTRLAGUA_caudal) ? "$CTRLAGUA_caudal" : "NULL";
			$CTRLAGUA_comentario = $_POST['ctrlagua_comentario'];	
							
			if($h_CTRLAGUA_id == "" or $per_agno == "" or $sem_num == "" or $CTRLAGUA_dia == "" or $CTRLAGUA_hora == "" or $CTRLAGUA_TK2 == "" or $CTRLAGUA_TK3 == "" or $CTRLAGUA_TK4 == "" or $CTRLAGUA_ph == "" or $CTRLAGUA_ce == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}

			$sql = "UPDATE CONTROL_AGUA SET SEM_NUM = $sem_num,PER_AGNO = $per_agno,CTRLAGUA_DIA = '$CTRLAGUA_dia',CTRLAGUA_HORA = '$CTRLAGUA_hora',CTRLAGUA_PH = $CTRLAGUA_ph,CTRLAGUA_CE = $CTRLAGUA_ce,CTRLAGUA_CAUDAL = $CTRLAGUA_caudal,CTRLAGUA_COMENTARIO = '$CTRLAGUA_comentario',CTRLAGUA_TK2 = $CTRLAGUA_TK2,CTRLAGUA_TK3 = $CTRLAGUA_TK3,CTRLAGUA_TK4 = $CTRLAGUA_TK4 WHERE CTRLAGUA_ID = $h_CTRLAGUA_id";
			//$resp = array('cod'=>'error','desc'=>$sql);
			//salida($resp);
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
			$resultado = mysqli_query($link,$sql)or die(salida($resp));		
		}
		
		elseif($operacion == 'DELETE'){
			
			$h_CTRLAGUA_id = $_POST['h_ctrlagua_id'];
			
			if($h_CTRLAGUA_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
			
			$sql = "DELETE FROM CONTROL_AGUA WHERE CTRLAGUA_ID = $h_CTRLAGUA_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
		}		

		$resp = array('cod'=>'ok','operacion'=>$operacion);		
			
	}
	
	
	//Retorna respuesta
	echo json_encode($resp);
	exit();		
	
	
?>