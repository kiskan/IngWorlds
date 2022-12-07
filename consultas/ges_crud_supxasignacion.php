<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['data'])){
	
		session_start();

		$sql = "SELECT AREA.AREA_ID, SUP.SUP_RUT, CONCAT(ACT.ACTIV_ID,'---',ACT.ACTIV_STANDAR) AS ACTIV_ID,ACT.ACTIV_ID AS ACTIV_ID2,PLAN.PLAN_DIA AS PLAN_DIA2,
SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(PLAN.PLAN_DIA,'%d-%m-%Y') as PLAN_DIA, PLAN.TIPO_JEFEGRUPO, 
CASE WHEN TIPO_JEFEGRUPO = 'SUPERVISOR' THEN CONCAT(SUP.SUP_NOMBRES,' ',SUP.SUP_PATERNO,' ',SUP.SUP_MATERNO) WHEN TIPO_JEFEGRUPO = 'OPERADOR' THEN CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) ELSE '' END AS JEFE_GRUPO,
CASE WHEN TIPO_JEFEGRUPO = 'SUPERVISOR' THEN SUP.SUP_RUT WHEN TIPO_JEFEGRUPO = 'OPERADOR' THEN OPER.OPER_RUT ELSE '' END AS RUT_JEFEGRUPO,
AREA.AREA_NOMBRE, ACT.ACTIV_NOMBRE, ASIG.USR_NOMBRE AS ASIGNADOR,
DATE_FORMAT(PLAN.FECHA_ULTREG,'%d-%m-%Y %H:%i') as FECHA_ULTREG
FROM PLANIFICACION_EXTRA AS PLAN 
JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
LEFT JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = PLAN.SUP_RUT
LEFT JOIN OPERADOR AS OPER ON OPER.OPER_RUT = PLAN.OPER_RUT
JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
JOIN USUARIOS AS ASIG ON ASIG.USR_ID = PLAN.USR_ID
WHERE SEM.SEM_NUM =".$_GET['data']." AND SEM.PER_AGNO =".$_GET['per_agno']." AND 
( ASIG.USR_ID = ".$_SESSION['USR_ID']." OR '".$_SESSION['USR_TIPO']."' = 'ADMINISTRADOR' ) 
ORDER BY PLAN.PLAN_DIA ASC";	
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();

		while( $rows = mysqli_fetch_assoc($resultset) ) {
		
			$sql_operadores_rut = "SELECT OPER_RUT FROM PLANIFICACION_EXTRA_OPER WHERE PLAN_DIA = '$rows[PLAN_DIA2]' AND ACTIV_ID = $rows[ACTIV_ID2]";
			$resultado = mysqli_query($link, $sql_operadores_rut) or die("database error:". mysqli_error($link));

			$operadores_rut = '';
			$i = 0;
			while( $rows_operadores_rut = mysqli_fetch_assoc($resultado) ) {
				if($i == 0){
					$operadores_rut = $rows_operadores_rut[OPER_RUT];
				}
				else{
					$operadores_rut = $operadores_rut.','.$rows_operadores_rut[OPER_RUT];
				}
				$i++;
			}
		
			$data[] = 
			Array
			(
				'PER_AGNO' => $rows[PER_AGNO],
				'SEM_NUM' => $rows[SEM_NUM],
				'PLAN_DIA' => $rows[PLAN_DIA],				
				'AREA_NOMBRE' => $rows[AREA_NOMBRE],
				'ACTIV_NOMBRE' => $rows[ACTIV_NOMBRE],
				'TIPO_JEFEGRUPO' => $rows[TIPO_JEFEGRUPO],
				'JEFE_GRUPO' => $rows[JEFE_GRUPO],
				'ASIGNADOR' => $rows[ASIGNADOR],
				'FECHA_ULTREG' => $rows[FECHA_ULTREG],
				'AREA_ID' => $rows[AREA_ID],
				'RUT_JEFEGRUPO' => $rows[RUT_JEFEGRUPO],
				'ACTIV_ID' => $rows[ACTIV_ID],
				'RUT_OPERADORES' => $operadores_rut			
			);	
						
		}
	/*	
	echo '<pre>';
	print_r($data);
	echo '</pre>';		
	*/		
		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);	
	
	}
	

	else{
	
		$operacion = $_POST['operacion'];

		if($operacion == 'INSERT'){		
			
			session_start();		
				
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$plan_dia = $_POST['plan_dia'];			
			$activ_id = $_POST['activ_id'];
			
			$tj_grupo = $_POST['tj_grupo'];
			$j_grupo = $_POST['j_grupo'];

			if($tj_grupo == 'SUPERVISOR'){
				$sup_rut = "'$j_grupo'";
				$oper_rut2 = 'NULL';
			}elseif($tj_grupo == 'OPERADOR'){
				$oper_rut2 = "'$j_grupo'";
				$sup_rut = 'NULL';
			}
			
			$asignante = $_SESSION['USR_ID'];		
			
			$total_check = count($_POST["oper_chequeados"]);
			$hr_chequeados = $_POST['hr_chequeados'];
			$tipo_jorn = $_POST['tipo_jorn'];
				
			if($per_agno == "" or $sem_num == "" or $plan_dia == "" or $tj_grupo == "" or $activ_id == "" or $j_grupo == "" or $asignante == "" or $tipo_jorn == "" or $total_check == 0){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			//mysqli_begin_transaction($link);
			mysqli_autocommit($link, FALSE);
			$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos1.');

			$dias = explode("," , $plan_dia);
			
			$j = 0;
			foreach ($dias as $dia) {
			
				$sql = "SELECT 1 FROM HORAS_TOPES WHERE DIA = '$dia' AND FECHA_HORA < '$fecha_reg' ";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);			
			
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Se ha agotado el tiempo para asignar operarios en el día seleccionado');
					salida_con_rollback($resp,$link);
				}
								
				$sql = "SELECT PLAN_DIA FROM PLANIFICACION_EXTRA WHERE PLAN_DIA = '$dia' AND ACTIV_ID = $activ_id";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount == 0){
					$sql_ins_dia = "INSERT INTO PLANIFICACION_EXTRA(PLAN_DIA, ACTIV_ID, PER_AGNO, SEM_NUM, TIPO_JEFEGRUPO, OPER_RUT, SUP_RUT, USR_ID, FECHA_ULTREG) VALUES ('$dia',$activ_id,$per_agno,$sem_num,'$tj_grupo',$oper_rut2,$sup_rut,$asignante,'$fecha_reg')";
					
				}
				else{
					$sql_ins_dia = "UPDATE PLANIFICACION_EXTRA SET TIPO_JEFEGRUPO = '$tj_grupo', OPER_RUT = $oper_rut2, SUP_RUT = $sup_rut, USR_ID = $asignante, FECHA_ULTREG = '$fecha_reg' WHERE PLAN_DIA = '$dia' AND ACTIV_ID = $activ_id ";
				}
				
				$resultado = mysqli_query($link,$sql_ins_dia)or die(salida_con_rollback($resp,$link));

				$i = 0;
				while($total_check > $i){
					$oper_rut = $_POST["oper_chequeados"][$i];					
					$plano_horas = $hr_chequeados[$j][$i];
					$plano_horas = str_replace(",", ".",$plano_horas);
					if($plano_horas > 0){
						$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos2.');
						$sql = "SELECT TIPO_JORNADA FROM PLANIFICACION_EXTRA_OPER WHERE PLAN_DIA = '$dia' AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";					
						$resultado = mysqli_query($link,$sql);	
						$rowcount = mysqli_num_rows($resultado);	
						
						if($rowcount > 0){

							$fila = mysqli_fetch_row($resultado);
							$TIPO_JORNADA = $fila[0];							
							
							if($TIPO_JORNADA == $tipo_jorn){
								$sql_ins_oper = "UPDATE PLANIFICACION_EXTRA_OPER SET PLANO_HORAS = $plano_horas WHERE PLAN_DIA = '$dia' AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";									
							}else{
								$sql_ins_oper = "UPDATE PLANIFICACION_EXTRA_OPER SET PLANO_HORAS = $plano_horas, TIPO_JORNADA = 'MAÑANA Y TARDE'  WHERE PLAN_DIA = '$dia' AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";								
							}						
						}						
						else{												
							$sql_ins_oper = "INSERT INTO PLANIFICACION_EXTRA_OPER(OPER_RUT, PLAN_DIA, ACTIV_ID, TIPO_JORNADA, PLANO_HORAS) VALUES ('$oper_rut','$dia',$activ_id, '$tipo_jorn', $plano_horas)";											
						}	
						$resultado = mysqli_query($link,$sql_ins_oper)or die(salida_con_rollback($resp,$link));
					}
					$i++;
				}
				$j++;
			}
			mysqli_commit($link);
		}
	
		elseif($operacion == 'UPDATE'){
			
			session_start();		
				
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$plan_dia = $_POST['plan_dia'];			
			$activ_id = $_POST['activ_id'];
			
			$tj_grupo = $_POST['tj_grupo'];
			$j_grupo = $_POST['j_grupo'];

			if($tj_grupo == 'SUPERVISOR'){
				$sup_rut = "'$j_grupo'";
				$oper_rut2 = 'NULL';
			}elseif($tj_grupo == 'OPERADOR'){
				$oper_rut2 = "'$j_grupo'";
				$sup_rut = 'NULL';
			}
			
			$asignante = $_SESSION['USR_ID'];
			//$fecha_reg = date("Ymd H:i",time());			
			
			$total_check = count($_POST["oper_chequeados"]);
			$hr_chequeados = $_POST['hr_chequeados'];			
			$tipo_jorn = $_POST['tipo_jorn'];
						
			$h_activ_id = $_POST['h_activ_id'];		
			$h_plan_dia = explode("-" , $_POST['h_plan_dia']);
			$h_plan_dia = $h_plan_dia[2].'-'.$h_plan_dia[1].'-'.$h_plan_dia[0];
			
			if($per_agno == "" or $sem_num == "" or $plan_dia == "" or $tj_grupo == "" or $activ_id == "" or $_POST['j_grupo'] == "" or $asignante == "" or $tipo_jorn == "" or $total_check == 0){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}					
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');
			
			mysqli_autocommit($link, FALSE);

			$sql_del_oper = "DELETE FROM PLANIFICACION_EXTRA_OPER WHERE PLAN_DIA = '$h_plan_dia' AND ACTIV_ID = $h_activ_id";
			$resultado = mysqli_query($link,$sql_del_oper)or die(salida_con_rollback($resp,$link));

			$sql_del_plan = "DELETE FROM PLANIFICACION_EXTRA WHERE PLAN_DIA = '$h_plan_dia' AND ACTIV_ID = $h_activ_id";
			$resultado = mysqli_query($link,$sql_del_plan)or die(salida_con_rollback($resp,$link));			
			
			$dias = explode("," , $plan_dia);
			
			$j = 0;
			foreach ($dias as $dia) {

				$sql = "SELECT 1 FROM HORAS_TOPES WHERE DIA = '$dia' AND FECHA_HORA < '$fecha_reg' ";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);			
			
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Se ha agotado el tiempo para actualizar actividades extras en el día seleccionado');
					salida_con_rollback($resp,$link);
				}			
			
			
				$sql = " SELECT PLAN_DIA FROM PLANIFICACION_EXTRA WHERE PLAN_DIA = '$dia' AND ACTIV_ID = $activ_id";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount == 0){
				
					$sql_ins_dia = "INSERT INTO PLANIFICACION_EXTRA(PLAN_DIA, ACTIV_ID, PER_AGNO, SEM_NUM, TIPO_JEFEGRUPO, OPER_RUT, SUP_RUT, USR_ID, FECHA_ULTREG) VALUES ('$dia',$activ_id,$per_agno,$sem_num,'$tj_grupo',$oper_rut2,$sup_rut,$asignante,'$fecha_reg')";					
					$resultado = mysqli_query($link,$sql_ins_dia)or die(salida_con_rollback($resp,$link));
				}
				$i = 0;
				while($total_check > $i){
					$oper_rut = $_POST["oper_chequeados"][$i];					
					$plano_horas = $hr_chequeados[$j][$i];
					$plano_horas = str_replace(",", ".",$plano_horas);
					if($plano_horas > 0){
						$sql_ins_oper = "INSERT INTO PLANIFICACION_EXTRA_OPER(OPER_RUT, PLAN_DIA, ACTIV_ID, TIPO_JORNADA, PLANO_HORAS) VALUES ('$oper_rut','$dia',$activ_id,'$tipo_jorn',$plano_horas)";				
						$resultado = mysqli_query($link,$sql_ins_oper)or die(salida_con_rollback($resp,$link));
					}
					$i++;
				}
				$j++;
			}
			mysqli_commit($link);
			

		}	
		
		elseif($operacion == 'DELETE'){
			
			$h_activ_id = $_POST['h_activ_id'];		
			$h_plan_dia = explode("-" , $_POST['h_plan_dia']);
			$h_plan_dia = $h_plan_dia[2].'-'.$h_plan_dia[1].'-'.$h_plan_dia[0];
			
			if($h_activ_id == "" or $h_plan_dia == "" ){
				$resp = array('cod'=>'error','desc'=>'Datos obligatorios ausentes');
				salida($resp);
			}
			
			mysqli_autocommit($link, FALSE);
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');
			
			$sql_del_oper = "DELETE FROM PLANIFICACION_EXTRA_OPER WHERE PLAN_DIA = '$h_plan_dia' AND ACTIV_ID = $h_activ_id";
			$resultado = mysqli_query($link,$sql_del_oper)or die(salida_con_rollback($resp,$link));		

			$sql_del_plan = "DELETE FROM PLANIFICACION_EXTRA WHERE PLAN_DIA = '$h_plan_dia' AND ACTIV_ID = $h_activ_id";
			$resultado = mysqli_query($link,$sql_del_plan)or die(salida_con_rollback($resp,$link));	
					
			
			mysqli_commit($link);
		}	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	//Retorna respuesta
	echo json_encode($resp);
	exit();	

?>