<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['data'])){
	
		$fecha = $_GET['fecha'];
		
		$sql = "SELECT AREA.AREA_ID, SUP.SUP_RUT, CONCAT(ACT.ACTIV_ID,'---',IFNULL(UND.UND_NOMBRE,0),'---',IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),0),'---',ACT.ACTIV_STANDAR) AS ACTIV_ID,ACT.ACTIV_ID AS ACTIV_ID2,PLAN.PLAN_DIA AS PLAN_DIA2,
SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(PLAN.PLAN_DIA,'%d-%m-%Y') as PLAN_DIA, IFNULL(UND.UND_NOMBRE,0) AS UND_NOMBRE,		
AREA.AREA_NOMBRE, ACT.ACTIV_NOMBRE, CONCAT(SUP.SUP_NOMBRES,' ',SUP.SUP_PATERNO,' ',SUP.SUP_MATERNO) AS SUPERVISOR, 
(
SELECT  IFNULL(MET.MET_UNDXHR,0) * SUM(PLANO.PLANO_HORAS) FROM PLANIFICACION_OPER AS PLANO WHERE PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID=PLAN.ACTIV_ID GROUP BY PLANO.PLAN_DIA
)AS PLAN_PRODUCCION
FROM PLANIFICACION AS PLAN 
JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = PLAN.SUP_RUT
JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
LEFT JOIN UNIDAD AS UND ON UND.UND_ID = ACT.UND_ID 
LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACT.ACTIV_ID AND '$fecha'>= MET.MET_INIVIG AND (MET.MET_FINVIG IS NULL OR '$fecha'<= MET.MET_FINVIG)
WHERE SEM.SEM_NUM =".$_GET['data']." AND SEM.PER_AGNO =".$_GET['per_agno']." 
ORDER BY PLAN.PLAN_DIA ASC";	
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();

		while( $rows = mysqli_fetch_assoc($resultset) ) {
		
			$sql_operadores_rut = "SELECT OPER_RUT FROM PLANIFICACION_OPER WHERE PLAN_DIA = '$rows[PLAN_DIA2]' AND ACTIV_ID = $rows[ACTIV_ID2]";
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
			
			$PLAN_PRODUCCION = '';
			if($rows[PLAN_PRODUCCION] > 0) {
				$PLAN_PRODUCCION = str_replace(',00','',str_replace(".", ",",round($rows[PLAN_PRODUCCION],2)));
				if($rows[UND_NOMBRE] <> '0'){ $PLAN_PRODUCCION = $PLAN_PRODUCCION.' '.$rows[UND_NOMBRE]; }
			}
			
		
			$data[] = 
			Array
			(
				'PER_AGNO' => $rows[PER_AGNO],
				'SEM_NUM' => $rows[SEM_NUM],
				'PLAN_DIA' => $rows[PLAN_DIA],				
				'AREA_NOMBRE' => $rows[AREA_NOMBRE],
				'ACTIV_NOMBRE' => $rows[ACTIV_NOMBRE],
				'PLAN_PRODUCCION' => $PLAN_PRODUCCION ,
				'SUPERVISOR' => $rows[SUPERVISOR],											
				'AREA_ID' => $rows[AREA_ID],
				'SUP_RUT' => $rows[SUP_RUT],
				'ACTIV_ID' => $rows[ACTIV_ID],
				'RUT_OPERADORES' => $operadores_rut			
			);			
			
		}
		
		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);	
	
	}
	
	elseif(isset($_POST['change_activ'])){
		$activ_id = $_POST['activ_id'];
		$sql = "SELECT O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO FROM COMPETENCIA AS C JOIN OPERADOR AS O ON C.OPER_RUT = O.OPER_RUT WHERE C.ACTIV_ID = $activ_id AND O.OPER_ESTADO = 'VIGENTE'";	
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
		$usr_rut = $_SESSION['USR_RUT'];
		$usr_nombre = $_SESSION['USR_NOMBRE'];
		
		if($operacion == 'INSERT'){
				
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$plan_dia = $_POST['plan_dia'];			
			$sup_rut = $_POST['sup_rut'];
			$sactiv_motivo = $_POST['sactiv_motivo'];
			$activ_id = $_POST['activ_id'];
			$total_check = count($_POST["oper_chequeados"]);
			$hr_chequeados = $_POST['hr_chequeados'];
			
			$oper_replanificacion = "INGRESO";
				
			if($per_agno == "" or $sem_num == "" or $plan_dia == "" or $sup_rut == "" or $activ_id == "" or $total_check == 0 or $sactiv_motivo == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}

			mysqli_autocommit($link, FALSE);
			$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos.');

			$dias = explode("," , $plan_dia);
			
			$j = 0;
			foreach ($dias as $dia) {
		
				$sql_ins_rdia = "INSERT INTO REPLANIFICACION(RPLAN_DIA, RACTIV_ID, PER_AGNO, SEM_NUM, RSUP_RUT, RPLAN_MOTIVO, RPLAN_OPERACION, RPLAN_USR_RUT, RPLAN_USR_NOMBRE) 
				VALUES ('$dia',$activ_id,$per_agno,$sem_num,'$sup_rut','$sactiv_motivo','$oper_replanificacion','$usr_rut','$usr_nombre')";
				$resultado = mysqli_query($link,$sql_ins_rdia)or die(salida_con_rollback($resp,$link));
				
				$rplan_id = mysqli_insert_id($link);
								
				$sql = "SELECT PLAN_DIA FROM PLANIFICACION WHERE PLAN_DIA = '$dia' AND ACTIV_ID = $activ_id";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount == 0){
					$sql_ins_dia = "INSERT INTO PLANIFICACION(PLAN_DIA, ACTIV_ID, PER_AGNO, SEM_NUM, SUP_RUT) VALUES ('$dia',$activ_id,$per_agno,$sem_num,'$sup_rut')";
					
				}else{
					$sql_ins_dia = "UPDATE PLANIFICACION SET SUP_RUT = '$sup_rut' WHERE PLAN_DIA = '$dia' AND ACTIV_ID = $activ_id ";
				}
					
				$resultado = mysqli_query($link,$sql_ins_dia)or die(salida_con_rollback($resp,$link));

				$i = 0;
				while($total_check > $i){
					$oper_rut = $_POST["oper_chequeados"][$i];					
					$plano_horas = $hr_chequeados[$j][$i];
					$plano_horas = str_replace(",", ".",$plano_horas);
					if($plano_horas > 0){
						$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos.');
						$sql = "SELECT OPER_RUT FROM PLANIFICACION_OPER WHERE PLAN_DIA = '$dia' AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";					
						$resultado = mysqli_query($link,$sql);	
						$rowcount = mysqli_num_rows($resultado);	
						
						$sql_ins_roper = "INSERT INTO REPLANIFICACION_OPER(RPLAN_ID, RPLANO_OPER, RPLANO_HORAS) VALUES ($rplan_id,'$oper_rut',$plano_horas)";
						$resultado = mysqli_query($link,$sql_ins_roper)or die(salida_con_rollback($resp,$link));
						/*
						if($rowcount > 0){
							$sql_ins_oper = "UPDATE PLANIFICACION_OPER SET PLANO_HORAS = PLANO_HORAS + $plano_horas , PLANO_FECHACT = CURRENT_TIMESTAMP WHERE PLAN_DIA = '$dia' AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";
						}						
						else{												
							$sql_ins_oper = "INSERT INTO PLANIFICACION_OPER(OPER_RUT, PLAN_DIA, ACTIV_ID,PLANO_HORAS) VALUES ('$oper_rut','$dia',$activ_id,$plano_horas)";											
						}	
						*/
						if($rowcount > 0){
							$sql_ins_oper = "UPDATE PLANIFICACION_OPER SET PLANO_HORAS = PLANO_HORAS + $plano_horas , PLANO_FECHACT = '$fecha_reg' WHERE PLAN_DIA = '$dia' AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";
							}						
						else{												
							$sql_ins_oper = "INSERT INTO PLANIFICACION_OPER(OPER_RUT, PLAN_DIA, ACTIV_ID,PLANO_HORAS, PLANO_FECHACT) VALUES ('$oper_rut','$dia',$activ_id,$plano_horas,'$fecha_reg')";											
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
			
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$plan_dia = $_POST['plan_dia'];			
			$sup_rut = $_POST['sup_rut'];
			$sactiv_motivo = $_POST['sactiv_motivo'];
			$activ_id = $_POST['activ_id'];
			$total_check = count($_POST["oper_chequeados"]);
			$hr_chequeados = $_POST['hr_chequeados'];
			$oper_replanificacion = "MODIFICACION";
						
			$h_activ_id = $_POST['h_activ_id'];		
			$h_plan_dia = explode("-" , $_POST['h_plan_dia']);
			$h_plan_dia = $h_plan_dia[2].'-'.$h_plan_dia[1].'-'.$h_plan_dia[0];
			$h_sup_rut = $_POST['h_sup_rut'];
			
			if($per_agno == "" or $sem_num == "" or $plan_dia == "" or $sup_rut == "" or $activ_id == "" or $total_check == 0){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');
			
			mysqli_autocommit($link, FALSE);			
			
			$sql_ins_rdia = "INSERT INTO REPLANIFICACION(PLAN_DIA,ACTIV_ID,SUP_RUT, RPLAN_DIA, RACTIV_ID, PER_AGNO, SEM_NUM, RSUP_RUT, RPLAN_MOTIVO, RPLAN_OPERACION, RPLAN_USR_RUT, RPLAN_USR_NOMBRE) 
			VALUES ('$h_plan_dia',$h_activ_id,'$h_sup_rut','$plan_dia',$activ_id,$per_agno,$sem_num,'$sup_rut','$sactiv_motivo','$oper_replanificacion','$usr_rut','$usr_nombre')";
			$resultado = mysqli_query($link,$sql_ins_rdia)or die(salida_con_rollback($resp,$link));
			
			$rplan_id = mysqli_insert_id($link);
			
			$sql_sel_oper = "SELECT OPER_RUT, PLANO_HORAS FROM PLANIFICACION_OPER WHERE PLAN_DIA = '$h_plan_dia' AND ACTIV_ID = $h_activ_id";
			$resultado = mysqli_query($link,$sql_sel_oper);
			while( $rows = mysqli_fetch_assoc($resultado) ) {
			
				$sql_ins_oper = "INSERT INTO HREPLANIFICACION_OPER(RPLAN_ID, HRPLANO_OPER, HRPLANO_HORAS) VALUES ($rplan_id,'$rows[OPER_RUT]',$rows[PLANO_HORAS])";				
				$resultado2 = mysqli_query($link,$sql_ins_oper)or die(salida_con_rollback($resp,$link));				
			
			}

			$sql_del_oper = "DELETE FROM PLANIFICACION_OPER WHERE PLAN_DIA = '$h_plan_dia' AND ACTIV_ID = $h_activ_id";
			$resultado = mysqli_query($link,$sql_del_oper)or die(salida_con_rollback($resp,$link));
			
			$sql_del_plan = "DELETE FROM PLANIFICACION WHERE PLAN_DIA = '$h_plan_dia' AND ACTIV_ID = $h_activ_id";
			$resultado = mysqli_query($link,$sql_del_plan)or die(salida_con_rollback($resp,$link));	
			
			$dias = explode("," , $plan_dia);
			
			$j = 0;
			foreach ($dias as $dia) {

				$sql = " SELECT PLAN_DIA FROM PLANIFICACION WHERE PLAN_DIA = '$dia' AND ACTIV_ID = $activ_id";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount == 0){
					$sql_ins_dia = "INSERT INTO PLANIFICACION(PLAN_DIA, ACTIV_ID, PER_AGNO, SEM_NUM, SUP_RUT) VALUES ('$dia',$activ_id,$per_agno,$sem_num,'$sup_rut')";
					$resultado = mysqli_query($link,$sql_ins_dia)or die(salida_con_rollback($resp,$link));
				}
				$i = 0;
				while($total_check > $i){
					$oper_rut = $_POST["oper_chequeados"][$i];					
					$plano_horas = $hr_chequeados[$j][$i];
					$plano_horas = str_replace(",", ".",$plano_horas);
					
					if($plano_horas > 0){
					
						$sql_ins_roper = "INSERT INTO REPLANIFICACION_OPER(RPLAN_ID, RPLANO_OPER, RPLANO_HORAS) VALUES ($rplan_id,'$oper_rut',$plano_horas)";
						$resultado = mysqli_query($link,$sql_ins_roper)or die(salida_con_rollback($resp,$link));					
					
						//$sql_ins_oper = "INSERT INTO PLANIFICACION_OPER(OPER_RUT, PLAN_DIA, ACTIV_ID,PLANO_HORAS) VALUES ('$oper_rut','$dia',$activ_id,$plano_horas)";
						$sql_ins_oper = "INSERT INTO PLANIFICACION_OPER(OPER_RUT, PLAN_DIA, ACTIV_ID,PLANO_HORAS, PLANO_FECHACT) VALUES ('$oper_rut','$dia',$activ_id,$plano_horas,'$fecha_reg')";
						$resultado = mysqli_query($link,$sql_ins_oper)or die(salida_con_rollback($resp,$link));
					}
					$i++;
				}
				$j++;
			}
			mysqli_commit($link);
			

		}	
		
		elseif($operacion == 'DELETE'){
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];			
			$h_activ_id = $_POST['h_activ_id'];		
			$h_plan_dia = explode("-" , $_POST['h_plan_dia']);
			$h_plan_dia = $h_plan_dia[2].'-'.$h_plan_dia[1].'-'.$h_plan_dia[0];
			$h_sup_rut = $_POST['h_sup_rut'];
			$sactiv_motivo = $_POST['sactiv_motivo'];
			$oper_replanificacion = "ELIMINACION";
			
			if($h_activ_id == "" or $h_plan_dia == "" ){
				$resp = array('cod'=>'error','desc'=>'Datos obligatorios ausentes');
				salida($resp);
			}
			
			mysqli_autocommit($link, FALSE);
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');
			
			$sql_ins_rdia = "INSERT INTO REPLANIFICACION(PLAN_DIA,ACTIV_ID,SUP_RUT,PER_AGNO, SEM_NUM, RPLAN_MOTIVO, RPLAN_OPERACION, RPLAN_USR_RUT, RPLAN_USR_NOMBRE) 
			VALUES ('$h_plan_dia',$h_activ_id,'$h_sup_rut',$per_agno,$sem_num,'$sactiv_motivo','$oper_replanificacion','$usr_rut','$usr_nombre')";
			$resultado = mysqli_query($link,$sql_ins_rdia)or die(salida_con_rollback($resp,$link));			

			$rplan_id = mysqli_insert_id($link);
			
			$sql_sel_oper = "SELECT OPER_RUT, PLANO_HORAS FROM PLANIFICACION_OPER WHERE PLAN_DIA = '$h_plan_dia' AND ACTIV_ID = $h_activ_id";
			$resultado = mysqli_query($link,$sql_sel_oper);
			while( $rows = mysqli_fetch_assoc($resultado) ) {
			
				$sql_ins_oper = "INSERT INTO REPLANIFICACION_OPER(RPLAN_ID, RPLANO_OPER, RPLANO_HORAS) VALUES ($rplan_id,'$rows[OPER_RUT]',$rows[PLANO_HORAS])";				
				$resultado2 = mysqli_query($link,$sql_ins_oper)or die(salida_con_rollback($resp,$link));				
			
			}			
			
			$sql_del_oper = "DELETE FROM PLANIFICACION_OPER WHERE PLAN_DIA = '$h_plan_dia' AND ACTIV_ID = $h_activ_id";
			$resultado = mysqli_query($link,$sql_del_oper)or die(salida_con_rollback($resp,$link));		

			$sql_del_plan = "DELETE FROM PLANIFICACION WHERE PLAN_DIA = '$h_plan_dia' AND ACTIV_ID = $h_activ_id";
			$resultado = mysqli_query($link,$sql_del_plan)or die(salida_con_rollback($resp,$link));	
	
			mysqli_commit($link);
		}	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	//Retorna respuesta
	echo json_encode($resp);
	exit();	

?>