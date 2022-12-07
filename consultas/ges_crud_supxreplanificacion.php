<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_POST['oper_disponibles'])){

		$plan_dia = $_POST['plan_dia'];
		$activ_id = $_POST['activ_id'];
		$activ_standar = $_POST['activ_standar'];	
	
		//TRABAJADORES NO DISPONIBLES 
		/*
		$sql = "SELECT DISTINCT OPER.OPER_RUT
		FROM PLANIFICACION_OPER AS PLANO
		JOIN OPERADOR AS OPER
		ON PLANO.OPER_RUT = OPER.OPER_RUT
		WHERE PLAN_DIA = '$plan_dia'
		GROUP BY OPER.OPER_RUT
		HAVING SUM(PLANO.PLANO_HORAS) = 8.50";  
		*/	

		if($activ_standar == 'S'){
			$sql = "
			SELECT OPER.OPER_RUT,CONCAT(OPER.OPER_NOMBRES,' ',OPER.OPER_PATERNO,' ',OPER.OPER_MATERNO) AS OPERARIO 
			FROM OPERADOR AS OPER 
			WHERE OPER.OPER_ESTADO = 'VIGENTE' 
			AND OPER.OPER_RUT NOT IN (
				SELECT DISTINCT PLANO.OPER_RUT
				FROM PLANIFICACION_OPER AS PLANO
				WHERE PLANO.PLAN_DIA = '$plan_dia'
				GROUP BY PLANO.OPER_RUT
				HAVING SUM(PLANO.PLANO_HORAS) = 8.50			
			)
			ORDER BY OPERARIO";		
			
		}else{
			$sql = "
			SELECT OPER.OPER_RUT,CONCAT(OPER.OPER_NOMBRES,' ',OPER.OPER_PATERNO,' ',OPER.OPER_MATERNO) AS OPERARIO  
			FROM COMPETENCIA AS C JOIN OPERADOR AS OPER ON C.OPER_RUT = OPER.OPER_RUT 
			WHERE C.ACTIV_ID = $activ_id AND OPER.OPER_ESTADO = 'VIGENTE' 
			AND OPER.OPER_RUT NOT IN (
				SELECT DISTINCT PLANO.OPER_RUT
				FROM PLANIFICACION_OPER AS PLANO
				WHERE PLANO.PLAN_DIA = '$plan_dia'
				GROUP BY PLANO.OPER_RUT
				HAVING SUM(PLANO.PLANO_HORAS) = 8.50			
			)			
			ORDER BY OPERARIO";		
		}
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();		
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
		
			$sql_dia_oper = "SELECT AREA.AREA_NOMBRE, ACT.ACTIV_NOMBRE, DATE_FORMAT(PLAN.PLAN_DIA,'%Y%m%d') as PLAN_DIA, 
			PLANO.PLANO_HORAS, ACT.ACTIV_ID, DATE_FORMAT(PLAN.PLAN_DIA,'%d-%m-%Y') as PLAN_DIA_H 
			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
			JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
			WHERE PLAN.PLAN_DIA = '$plan_dia' AND PLANO.OPER_RUT = '$rows[OPER_RUT]'
			ORDER BY PLANO.PLANO_FECHACT ASC";
			$resultado = mysqli_query($link, $sql_dia_oper) or die("database error:". mysqli_error($link));	
			
			$DIA[0] = 0;$DIA[1] = 0;
			$i = 0;
			while( $rows_dia_sem = mysqli_fetch_assoc($resultado) ) {
			
				$PLANO_HORAS = str_replace(',00','',str_replace(".", ",",$rows_dia_sem[PLANO_HORAS]));
				$DIA[$i] = $rows_dia_sem[AREA_NOMBRE].'---'.$rows_dia_sem[ACTIV_NOMBRE].'---'.$PLANO_HORAS;
				$i++;			
			}
			
			$data[] = 
			Array
			(
				'OPER_RUT' => $rows[OPER_RUT],
				'OPERARIO' => $rows[OPERARIO],								
				'DIA' => $DIA
			);		
		}
		salida($data);
	}
	
	
	
	else{
	
		session_start();
		$operacion = $_POST['operacion'];
		$usr_rut = $_SESSION['USR_RUT'];
		$usr_nombre = $_SESSION['USR_NOMBRE'];

		if($operacion == 'INSERT'){
				
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$plan_dia = $_POST['plan_dia'];			
			$sup_rut = $_POST['sup_rut'];
			$sactiv_id = $_POST['sactiv_id'];
			$activ_id = $_POST['activ_id'];
			$total_check = count($_POST["oper_chequeados"]);
			$hr_chequeados = $_POST['hr_chequeados'];
			
			$oper_replanificacion = "INGRESO";
				
			if($per_agno == "" or $sem_num == "" or $plan_dia == "" or $sup_rut == "" or $activ_id == "" or $total_check == 0 or $sactiv_id == ''){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}

			mysqli_autocommit($link, FALSE);
			$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos.');
							
			$sql = "SELECT PLAN_DIA FROM PLANIFICACION WHERE PLAN_DIA = '$plan_dia' AND ACTIV_ID = $activ_id";				
			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);	
			
			if($rowcount == 0){
				$sql_ins_dia = "INSERT INTO PLANIFICACION(PLAN_DIA, ACTIV_ID, PER_AGNO, SEM_NUM, SUP_RUT) VALUES ('$plan_dia',$activ_id,$per_agno,$sem_num,'$sup_rut')";
				$resultado = mysqli_query($link,$sql_ins_dia)or die(salida_con_rollback($resp,$link));
				
			}else{
				//$sql_ins_dia = "UPDATE PLANIFICACION SET SUP_RUT = '$sup_rut' WHERE PLAN_DIA = '$dia' AND ACTIV_ID = $activ_id ";
				$resp = array('cod'=>'error','desc'=>'Error: Esta actividad ya se encuentra planificada para este día.');
				salida_con_rollback($resp,$link);
			}			
			
			$sql_ins_rdia = "INSERT INTO REPLANIFICACION(RPLAN_DIA, RACTIV_ID, PER_AGNO, SEM_NUM, RSUP_RUT, RPLAN_OPERACION, RPLAN_USR_RUT, RPLAN_USR_NOMBRE, SACTIV_ID) 
			VALUES ('$plan_dia',$activ_id,$per_agno,$sem_num,'$sup_rut','$oper_replanificacion','$usr_rut','$usr_nombre',$sactiv_id)";
			$resultado = mysqli_query($link,$sql_ins_rdia)or die(salida_con_rollback($resp,$link));			
			$rplan_id = mysqli_insert_id($link);			

			$i = 0;
			while($total_check > $i){
				$oper_rut = $_POST["oper_chequeados"][$i];					
				$plano_horas = $hr_chequeados[$i];
				$plano_horas = str_replace(",", ".",$plano_horas);
				if($plano_horas > 0){
					
					$sql_ins_roper = "INSERT INTO REPLANIFICACION_OPER(RPLAN_ID, RPLANO_OPER, RPLANO_HORAS) VALUES ($rplan_id,'$oper_rut',$plano_horas)";
					$resultado = mysqli_query($link,$sql_ins_roper)or die(salida_con_rollback($resp,$link));
											
					$sql_ins_oper = "INSERT INTO PLANIFICACION_OPER(OPER_RUT, PLAN_DIA, ACTIV_ID,PLANO_HORAS) VALUES ('$oper_rut','$plan_dia',$activ_id,$plano_horas)";
					$resultado = mysqli_query($link,$sql_ins_oper)or die(salida_con_rollback($resp,$link));
				}
				$i++;
			}
			
			mysqli_commit($link);
		}
	
		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	//Retorna respuesta
	echo json_encode($resp);
	exit();	

?>