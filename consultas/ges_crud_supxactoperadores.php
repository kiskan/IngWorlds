<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_POST['oper_disponibles'])){

		$plan_dia = $_POST['plan_dia'];
		$activ_id = $_POST['activ_id'];
		$activ_standar = $_POST['activ_standar'];	
		
		$sql = "			
			SELECT OPER.OPER_RUT,CONCAT(OPER.OPER_NOMBRES,' ',OPER.OPER_PATERNO,' ',OPER.OPER_MATERNO) AS OPERARIO 
			FROM PLANIFICACION_OPER AS PLANO
			JOIN OPERADOR AS OPER 
			ON PLANO.OPER_RUT = OPER.OPER_RUT
			WHERE PLANO.PLAN_DIA = '$plan_dia' AND PLANO.ACTIV_ID = $activ_id
			ORDER BY OPERARIO";			
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();		
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
		
			$sql_dia_oper = "SELECT AREA.AREA_NOMBRE, ACT.ACTIV_NOMBRE, DATE_FORMAT(PLAN.PLAN_DIA,'%Y%m%d') as PLAN_DIA, 
			PLANO.PLANO_HORAS, ACT.ACTIV_ID, DATE_FORMAT(PLAN.PLAN_DIA,'%d-%m-%Y') as PLAN_DIA_H 
			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
			JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
			WHERE PLAN.PLAN_DIA = '$plan_dia' AND PLANO.OPER_RUT = '$rows[OPER_RUT]' AND PLAN.ACTIV_ID <> $activ_id
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
				'DIA' => $DIA,
				'PLANIFICADO' => 'S'
			);		
		}		
				

		if($activ_standar == 'S'){
			$sql = "
			SELECT OPER.OPER_RUT,CONCAT(OPER.OPER_NOMBRES,' ',OPER.OPER_PATERNO,' ',OPER.OPER_MATERNO) AS OPERARIO 
			FROM OPERADOR AS OPER 
			WHERE OPER.OPER_ESTADO = 'VIGENTE' 
			AND OPER.OPER_RUT NOT IN (			
				SELECT OPER.OPER_RUT
				FROM PLANIFICACION_OPER AS PLANO
				JOIN OPERADOR AS OPER 
				ON PLANO.OPER_RUT = OPER.OPER_RUT
				WHERE PLANO.PLAN_DIA = '$plan_dia' AND PLANO.ACTIV_ID = $activ_id			
				UNION
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
				SELECT OPER.OPER_RUT
				FROM PLANIFICACION_OPER AS PLANO
				JOIN OPERADOR AS OPER 
				ON PLANO.OPER_RUT = OPER.OPER_RUT
				WHERE PLANO.PLAN_DIA = '$plan_dia' AND PLANO.ACTIV_ID = $activ_id			
				UNION			
				SELECT DISTINCT PLANO.OPER_RUT
				FROM PLANIFICACION_OPER AS PLANO
				WHERE PLANO.PLAN_DIA = '$plan_dia'
				GROUP BY PLANO.OPER_RUT
				HAVING SUM(PLANO.PLANO_HORAS) = 8.50			
			)			
			ORDER BY OPERARIO";		
		}
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		//$data = array();		
		
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
				'DIA' => $DIA,
				'PLANIFICADO' => 'N'
			);		
		}
		salida($data);
	}
	
	
	
	else{
	
		session_start();
		$operacion = $_POST['operacion'];
		$usr_rut = $_SESSION['USR_RUT'];
		$usr_nombre = $_SESSION['USR_NOMBRE'];

		if($operacion == 'UPDATE'){
			
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$plan_dia = $_POST['plan_dia'];			
			$sup_rut = $_POST['sup_rut'];
			$rplan_motivo = $_POST['rplan_motivo'];
			$activ_id = $_POST['activ_id'];
			$total_check = count($_POST["oper_chequeados"]);
			$hr_chequeados = $_POST['hr_chequeados'];
			$oper_replanificacion = "MODIFICACION";
			
			if($per_agno == "" or $sem_num == "" or $plan_dia == "" or $sup_rut == "" or $activ_id == "" or $rplan_motivo == "" or $total_check == 0){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');
			
			mysqli_autocommit($link, FALSE);			
			
			$sql_ins_rdia = "INSERT INTO REPLANIFICACION(PLAN_DIA,ACTIV_ID,SUP_RUT, RPLAN_DIA, RACTIV_ID, PER_AGNO, SEM_NUM, RSUP_RUT, RPLAN_MOTIVO, RPLAN_OPERACION, RPLAN_USR_RUT, RPLAN_USR_NOMBRE) 
			VALUES ('$plan_dia',$activ_id,'$sup_rut','$plan_dia',$activ_id,$per_agno,$sem_num,'$sup_rut','$rplan_motivo','$oper_replanificacion','$usr_rut','$usr_nombre')";
			$resultado = mysqli_query($link,$sql_ins_rdia)or die(salida_con_rollback($resp,$link));
			
			$rplan_id = mysqli_insert_id($link);
			
			$sql_sel_oper = "SELECT OPER_RUT, PLANO_HORAS FROM PLANIFICACION_OPER WHERE PLAN_DIA = '$plan_dia' AND ACTIV_ID = $activ_id";
			$resultado = mysqli_query($link,$sql_sel_oper);
			$rut_oper_existentes = array();
			while( $rows = mysqli_fetch_assoc($resultado) ) {
				$rut_oper_existentes[] = $rows[OPER_RUT];
				$sql_ins_oper = "INSERT INTO HREPLANIFICACION_OPER(RPLAN_ID, HRPLANO_OPER, HRPLANO_HORAS) VALUES ($rplan_id,'$rows[OPER_RUT]',$rows[PLANO_HORAS])";				
				$resultado2 = mysqli_query($link,$sql_ins_oper)or die(salida_con_rollback($resp,$link));				
			}

			//$sql_del_oper = "DELETE FROM PLANIFICACION_OPER WHERE PLAN_DIA = '$plan_dia' AND ACTIV_ID = $activ_id";
			//$resultado = mysqli_query($link,$sql_del_oper)or die(salida_con_rollback($resp,$link));

			$rut_oper_chequeados = array();
			$i = 0;
			while($total_check > $i){
				$oper_rut = $_POST["oper_chequeados"][$i];	
				$rut_oper_chequeados[] = $oper_rut;
				$plano_horas = $hr_chequeados[$i];
				$plano_horas = str_replace(",", ".",$plano_horas);
				
				if (in_array($oper_rut, $rut_oper_existentes)) {

					if($plano_horas > 0){
					
						$sql_ins_roper = "INSERT INTO REPLANIFICACION_OPER(RPLAN_ID, RPLANO_OPER, RPLANO_HORAS) VALUES ($rplan_id,'$oper_rut',$plano_horas)";
						$resultado = mysqli_query($link,$sql_ins_roper)or die(salida_con_rollback($resp,$link));					
					
						$sql_ins_oper = "UPDATE PLANIFICACION_OPER SET PLANO_HORAS = $plano_horas WHERE PLAN_DIA = '$plan_dia' AND ACTIV_ID = $activ_id AND OPER_RUT = '$oper_rut'";				
						$resultado = mysqli_query($link,$sql_ins_oper)or die(salida_con_rollback($resp,$link));
					}			
				}				
				else{
				
					if($plano_horas > 0){
					
						$sql_ins_roper = "INSERT INTO REPLANIFICACION_OPER(RPLAN_ID, RPLANO_OPER, RPLANO_HORAS) VALUES ($rplan_id,'$oper_rut',$plano_horas)";
						$resultado = mysqli_query($link,$sql_ins_roper)or die(salida_con_rollback($resp,$link));					
					
						$sql_ins_oper = "INSERT INTO PLANIFICACION_OPER(OPER_RUT, PLAN_DIA, ACTIV_ID,PLANO_HORAS) VALUES ('$oper_rut','$plan_dia',$activ_id,$plano_horas)";				
						$resultado = mysqli_query($link,$sql_ins_oper)or die(salida_con_rollback($resp,$link));
					}
				}
				$i++;
			}
			
			$rut_existentes_no_chequeados = array_diff($rut_oper_existentes, $rut_oper_chequeados);
			
			foreach($rut_existentes_no_chequeados as $rut_oper){
				$sql_del_oper = "DELETE FROM PLANIFICACION_OPER WHERE PLAN_DIA = '$plan_dia' AND ACTIV_ID = $activ_id AND OPER_RUT = '$rut_oper'";
				$resultado = mysqli_query($link,$sql_del_oper)or die(salida_con_rollback($resp,$link));				
			}
			
			mysqli_commit($link);
			

		}	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	//Retorna respuesta
	echo json_encode($resp);
	exit();	

?>