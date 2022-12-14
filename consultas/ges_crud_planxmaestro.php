<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	session_start();
	
	if(isset($_GET['data'])){
	
		$sql = "SELECT DISTINCT AREA.AREA_ID,SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(PLAN.PLANM_DIA,'%d-%m-%Y') as PLAN_DIA, 	
				AREA.AREA_NOMBRE 
				FROM PLAN_MAESTRO AS PLAN 
				JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
                JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
				JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
				WHERE SEM.SEM_NUM =".$_GET['data']." AND SEM.PER_AGNO =".$_GET['per_agno']." 
				ORDER BY PLAN.PLANM_DIA ASC";

		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = 
			Array
			(
				'PER_AGNO' => $rows[PER_AGNO],
				'SEM_NUM' => $rows[SEM_NUM],
				'PLAN_DIA' => $rows[PLAN_DIA],				
				'AREA_NOMBRE' => $rows[AREA_NOMBRE],											
				'AREA_ID' => $rows[AREA_ID]			
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
	
	
	elseif(isset($_POST['activ_comunes'])){
	
		$dia = $_POST['dia'];					
		$dias = explode("," , $dia);
		$dia_meta = $dias[0];
		$id_area = $_POST['area_id'];

		$uno = $dias[0];
		$dos = !empty($dias[1]) ? $dias[1] : '';
		$tres = !empty($dias[2]) ? $dias[2] : '';
		$cuatro = !empty($dias[3]) ? $dias[3] : '';
		$cinco = !empty($dias[4]) ? $dias[4] : '';
		$seis = !empty($dias[5]) ? $dias[5] : '';
		$nro_dias = count($dias);

		
		$sql = "SELECT ACT.ACTIV_NOMBRE, PLAN.DE_INTERES, PLAN.JORNADA, IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),0) AS META,
				/*(PLAN.JORNADA * IFNULL(MET.MET_UNDXHR,0) * 8.25) AS*/ PLAN.PROD_ESPERADA, IFNULL(UND.UND_NOMBRE,'') AS UNIDAD, 					CONCAT(ACT.ACTIV_ID,'---',IFNULL(UND.UND_NOMBRE,0),'---',IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),0),'---',ACT.ACTIV_TIPO) AS ACTIV_ALL_ID, ACT.ACTIV_ID, PLANS.SUP_RUT
				FROM PLAN_MAESTRO AS PLAN 
				JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
				JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
				JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
				JOIN PLAN_MAESTRO_SUP AS PLANS ON PLANS.PLANM_DIA = PLAN.PLANM_DIA AND PLANS.ACTIV_ID = PLAN.ACTIV_ID
				LEFT JOIN UNIDAD AS UND ON UND.UND_ID = ACT.UND_ID 
				LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACT.ACTIV_ID AND '$dia_meta'>= MET.MET_INIVIG 
				AND (MET.MET_FINVIG IS NULL OR '$dia_meta'<= MET.MET_FINVIG)				
				WHERE PLAN.PLANM_DIA IN ('$uno','$dos','$tres','$cuatro','$cinco','$seis') AND AREA.AREA_ID =".$id_area." 
				GROUP BY ACT.ACTIV_NOMBRE, PLAN.DE_INTERES, PLAN.JORNADA, MET.MET_UNDXHR, UND.UND_NOMBRE, PLAN.ACTIV_ID, PLANS.SUP_RUT
				HAVING COUNT(*) = ".$nro_dias;				
		
		
		$resultado = mysqli_query($link,$sql);	
		$rowcount = mysqli_num_rows($resultado);	
		
		$resp = array('rowcount'=>$rowcount);
		salida($resp);
	}		
	

	elseif(isset($_GET['dia_activ_prod'])){
	
		$fecha = $_GET['dia_activ_prod'];		
		$data = array();
		
		if($fecha <> '0'){
		
			$dias = explode("," , $fecha);
			$dia_meta = $dias[0];
	
			$uno = $dias[0];
			$dos = !empty($dias[1]) ? $dias[1] : '';
			$tres = !empty($dias[2]) ? $dias[2] : '';
			$cuatro = !empty($dias[3]) ? $dias[3] : '';
			$cinco = !empty($dias[4]) ? $dias[4] : '';
			$seis = !empty($dias[5]) ? $dias[5] : '';
			$nro_dias = count($dias);

			$sqlx = "drop temporary table if exists t1";
			$resultset = mysqli_query($link, $sqlx) or die("database error:". mysqli_error($link));
			
			$sql = "CREATE TEMPORARY TABLE t1 (SELECT ACT.ACTIV_NOMBRE, PLAN.DE_INTERES, PLAN.JORNADA, IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),0) AS META,
					/*(PLAN.JORNADA * IFNULL(MET.MET_UNDXHR,0) * 8.25) AS*/ PLAN.PROD_ESPERADA, IFNULL(UND.UND_NOMBRE,'') AS UNIDAD, 					CONCAT(ACT.ACTIV_ID,'---',IFNULL(UND.UND_NOMBRE,0),'---',IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),0),'---',ACT.ACTIV_TIPO) AS ACTIV_ALL_ID, ACT.ACTIV_ID, PLANS.SUP_RUT
					FROM PLAN_MAESTRO AS PLAN 
					JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
					JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
					JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
					JOIN PLAN_MAESTRO_SUP AS PLANS ON PLANS.PLANM_DIA = PLAN.PLANM_DIA AND PLANS.ACTIV_ID = PLAN.ACTIV_ID
					LEFT JOIN UNIDAD AS UND ON UND.UND_ID = ACT.UND_ID 
					LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACT.ACTIV_ID AND '$dia_meta'>= MET.MET_INIVIG 
					AND (MET.MET_FINVIG IS NULL OR '$dia_meta'<= MET.MET_FINVIG)				
					WHERE PLAN.PLANM_DIA IN ('$uno','$dos','$tres','$cuatro','$cinco','$seis') AND AREA.AREA_ID =".$_GET['id_area']." AND ACT.ACTIV_TIPO = 'PRODUCTIVA'	
					GROUP BY ACT.ACTIV_NOMBRE, PLAN.DE_INTERES, PLAN.JORNADA, MET.MET_UNDXHR, UND.UND_NOMBRE, PLAN.ACTIV_ID, PLANS.SUP_RUT
					HAVING COUNT(*) = ".$nro_dias."
					ORDER BY PLAN.PLANM_DIA ASC);";				
			
			
			$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			
			$sql2 = "select t1.ACTIV_NOMBRE, t1.DE_INTERES, t1.JORNADA, t1.META, t1.PROD_ESPERADA,t1.UNIDAD, t1.ACTIV_ALL_ID,
			GROUP_CONCAT(DISTINCT t1.SUP_RUT SEPARATOR ',') AS SUP_RUT, GROUP_CONCAT(DISTINCT CONCAT(SUP.SUP_NOMBRES,' ',SUP.SUP_PATERNO,' ',SUP.SUP_MATERNO) SEPARATOR ',') AS SUP_NOMBRE from t1 
			JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = t1.SUP_RUT
			GROUP BY t1.ACTIV_NOMBRE, t1.DE_INTERES, t1.JORNADA, t1.META, t1.PROD_ESPERADA,t1.UNIDAD, t1.ACTIV_ALL_ID
			";
			$resultset = mysqli_query($link, $sql2) or die("database error:". mysqli_error($link));
						
			while( $rows = mysqli_fetch_assoc($resultset) ) {
			
				$jornada = str_replace(',0','',str_replace(".", ",",$rows[JORNADA]));			
				//$prod_esperada = str_replace(',0','',str_replace(".", ",",round($rows[PROD_ESPERADA],1)));		
				//'PROD_ESPERADA' => $prod_esperada ,		
				$data[] = 
				Array
				(
					'ACTIV_NOMBRE' 	=> $rows[ACTIV_NOMBRE],
					'SUPERVISOR' 	=> $rows[SUP_NOMBRE],
					'DE_INTERES' 	=> $rows[DE_INTERES],				
					'JORNADA' 		=> $jornada,											
					'META' 			=> $rows[META],	
					'PROD_ESPERADA' => $rows[PROD_ESPERADA] ,
					'UNIDAD' 		=> $rows[UNIDAD],
					'ACTIV_ID' 		=> $rows[ACTIV_ALL_ID],
					'SUP_RUT' 		=> $rows[SUP_RUT]
				);
			}
		}	
/*
		echo '<pre>';
		print_r($sql);
		echo '</pre>';				
*/		
		
		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);
/*		
		echo '<pre>';
		print_r($resp);
		echo '</pre>';		
*/
	}		
	
	

	elseif(isset($_GET['dia_activ_apoyo'])){
	
		$fecha = $_GET['dia_activ_apoyo'];		
		$data = array();
		
		if($fecha <> '0'){
		
			$dias = explode("," , $fecha);
			$dia_meta = $dias[0];
	
			$uno = $dias[0];$dos = $dias[1];
			$tres = !empty($dias[2]) ? $dias[2] : '';
			$cuatro = !empty($dias[3]) ? $dias[3] : '';
			$cinco = !empty($dias[4]) ? $dias[4] : '';
			$seis = !empty($dias[5]) ? $dias[5] : '';
			$nro_dias = count($dias);

			$sqlx = "drop temporary table if exists t1";
			$resultset = mysqli_query($link, $sqlx) or die("database error:". mysqli_error($link));
			
			$sql = "CREATE TEMPORARY TABLE t1 (SELECT ACT.ACTIV_NOMBRE, PLANS.SUP_RUT, PLAN.JORNADA, ACT.ACTIV_ID
					FROM PLAN_MAESTRO AS PLAN 
					JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
					JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
					JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
					JOIN PLAN_MAESTRO_SUP AS PLANS ON PLANS.PLANM_DIA = PLAN.PLANM_DIA AND PLANS.ACTIV_ID = PLAN.ACTIV_ID			
					WHERE PLAN.PLANM_DIA IN ('$uno','$dos','$tres','$cuatro','$cinco','$seis') AND AREA.AREA_ID =".$_GET['id_area']." AND ACT.ACTIV_TIPO = 'APOYO'	
					GROUP BY ACT.ACTIV_NOMBRE, PLANS.SUP_RUT, PLAN.JORNADA, ACT.ACTIV_ID
					HAVING COUNT(*) = ".$nro_dias."
					ORDER BY PLAN.PLANM_DIA ASC);";				
			
			
			$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			
			$sql2 = "select t1.ACTIV_NOMBRE, t1.JORNADA, t1.ACTIV_ID, 
			GROUP_CONCAT(DISTINCT t1.SUP_RUT SEPARATOR ',') AS SUP_RUT, GROUP_CONCAT(DISTINCT CONCAT(SUP.SUP_NOMBRES,' ',SUP.SUP_PATERNO,' ',SUP.SUP_MATERNO) SEPARATOR ',') AS SUP_NOMBRE from t1 
			JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = t1.SUP_RUT
			GROUP BY t1.ACTIV_NOMBRE, t1.JORNADA,  t1.ACTIV_ID
			";
			$resultset = mysqli_query($link, $sql2) or die("database error:". mysqli_error($link));
						
			while( $rows = mysqli_fetch_assoc($resultset) ) {
			
				$jornada = str_replace(',0','',str_replace(".", ",",$rows[JORNADA]));			
						
				$data[] = 
				Array
				(
					'ACTIV_NOMBRE' 	=> $rows[ACTIV_NOMBRE],
					'SUPERVISOR' 	=> $rows[SUP_NOMBRE],				
					'JORNADA' 		=> $jornada,											
					'ACTIV_ID' 		=> $rows[ACTIV_ID],
					'SUP_RUT' 		=> $rows[SUP_RUT]
				);
			}
		}	
		
/*
		echo '<pre>';
		print_r($sql);
		echo '</pre>';				
*/		
		
		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);
/*		
		echo '<pre>';
		print_r($resp);
		echo '</pre>';		
*/
	}		
	
	
	
	else{
	
		$operacion = $_POST['operacion'];
		
		if($operacion == 'INSERT'){

			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$plan_dia = $_POST['plan_dia'];	
			$activ_id = $_POST['activ_id'];
			$sup_rut = $_POST['sup_rut'];
			$jornada = $_POST['jornada'];
			$prod_esperada = $_POST['prod_esperada'];
			$jornada = str_replace(",", ".",$jornada);
			$de_interes = $_POST['de_interes'];
			$tipo = $_POST['tipo'];
				
			if($per_agno == "" or $sem_num == "" or $plan_dia == "" or $activ_id == "" or $sup_rut == "" or $jornada == "" or $prod_esperada == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}

			mysqli_autocommit($link, FALSE);
			$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos1.');

			$dias = explode("," , $plan_dia);
			$supervisores = explode("," , $sup_rut);

			foreach ($dias as $dia) {
								
				$sql = "SELECT PLANM_DIA FROM PLAN_MAESTRO WHERE PLANM_DIA = '$dia' AND ACTIV_ID = $activ_id";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount == 0){
					
					$sql_ins_dia = "INSERT INTO PLAN_MAESTRO(PLANM_DIA, ACTIV_ID, PER_AGNO, SEM_NUM, JORNADA, DE_INTERES, PROD_ESPERADA) VALUES ('$dia',$activ_id,$per_agno,$sem_num,$jornada,'$de_interes',$prod_esperada)";						
					$resultado = mysqli_query($link,$sql_ins_dia)or die(salida_con_rollback($resp,$link));
				
					foreach ($supervisores as $supervisor) {
						$sql_ins_sup = "INSERT INTO PLAN_MAESTRO_SUP VALUES ('$dia',$activ_id,'$supervisor')";	
						$resultado = mysqli_query($link,$sql_ins_sup)or die(salida_con_rollback($resp,$link));						
					}
				}else{
					$resp = array('cod'=>'error','desc'=>'Actividad ya registrada en d??a seleccionado');
					salida_con_rollback($resp,$link);				
				}
			}
			mysqli_commit($link);
		}
	
	
		//elseif(isset($_GET['operacion'])){
		elseif($operacion == 'INSERT-REPLICA'){

			$plan_dia = $_POST['plan_dia'];		
			//$plan_dia = $_GET['plan_dia'];
			$dias = explode("," , $plan_dia);
			
			$plan_dia_rep = $_POST['plan_dia_rep'];	
			//$plan_dia_rep = $_GET['plan_dia_rep'];
			$dias_rep = explode("," , $plan_dia_rep);			
			
			$dia_meta = $dias[0];
			$id_area = $_POST['area_id'];
			//$id_area = $_GET['area_id'];

			$uno = $dias[0];
			$dos = !empty($dias[1]) ? $dias[1] : '';
			$tres = !empty($dias[2]) ? $dias[2] : '';
			$cuatro = !empty($dias[3]) ? $dias[3] : '';
			$cinco = !empty($dias[4]) ? $dias[4] : '';
			$seis = !empty($dias[5]) ? $dias[5] : '';
			
			$tipo  = "x";
			$nro_dias = count($dias);
			
			if($plan_dia == "" or $plan_dia_rep == "" or $id_area == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}						

			$sqlx = "drop temporary table if exists t1";
			$resultset = mysqli_query($link, $sqlx) or die("database error:". mysqli_error($link));			
			
			$sql = "CREATE TEMPORARY TABLE t1 (SELECT ACT.ACTIV_NOMBRE, PLAN.DE_INTERES, PLAN.JORNADA, IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),0) AS META,
					/*(PLAN.JORNADA * IFNULL(MET.MET_UNDXHR,0) * 8.25) AS*/ PLAN.PROD_ESPERADA, IFNULL(UND.UND_NOMBRE,'') AS UNIDAD, 					CONCAT(ACT.ACTIV_ID,'---',IFNULL(UND.UND_NOMBRE,0),'---',IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),0),'---',ACT.ACTIV_TIPO) AS ACTIV_ALL_ID, ACT.ACTIV_ID, PLANS.SUP_RUT, PLAN.PER_AGNO, PLAN.SEM_NUM
					FROM PLAN_MAESTRO AS PLAN 
					JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
					JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
					JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
					JOIN PLAN_MAESTRO_SUP AS PLANS ON PLANS.PLANM_DIA = PLAN.PLANM_DIA AND PLANS.ACTIV_ID = PLAN.ACTIV_ID
					LEFT JOIN UNIDAD AS UND ON UND.UND_ID = ACT.UND_ID 
					LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACT.ACTIV_ID AND '$dia_meta'>= MET.MET_INIVIG 
					AND (MET.MET_FINVIG IS NULL OR '$dia_meta'<= MET.MET_FINVIG)				
					WHERE PLAN.PLANM_DIA IN ('$uno','$dos','$tres','$cuatro','$cinco','$seis') AND AREA.AREA_ID =".$id_area." 
					GROUP BY ACT.ACTIV_NOMBRE, PLAN.DE_INTERES, PLAN.JORNADA, MET.MET_UNDXHR, UND.UND_NOMBRE, PLAN.ACTIV_ID, PLANS.SUP_RUT, PLAN.PER_AGNO, PLAN.SEM_NUM
					HAVING COUNT(*) = ".$nro_dias.")";				
			
/*
		echo '<pre>';
		print_r($sql);
		echo '</pre>';			
*/			
			
			$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));		
		
			$sqlx = "select distinct ACTIV_ID,PER_AGNO,SEM_NUM,JORNADA,DE_INTERES, PROD_ESPERADA from t1";
			$resultset = mysqli_query($link, $sqlx) or die("database error:". mysqli_error($link));
			
			mysqli_autocommit($link, FALSE);			
			$resp = array('cod'=>'error','desc'=>'Error de Base de Datos (posible causa: Actividad ya registrada en d??a a replicar)');
		
			while( $rows = mysqli_fetch_assoc($resultset) ) {			
			
				foreach ($dias_rep as $dia) {
								
					$sql_ins_dia = "INSERT INTO PLAN_MAESTRO(PLANM_DIA, ACTIV_ID, PER_AGNO, SEM_NUM, JORNADA, DE_INTERES, PROD_ESPERADA) VALUES ('$dia',$rows[ACTIV_ID],$rows[PER_AGNO],$rows[SEM_NUM],$rows[JORNADA],'$rows[DE_INTERES]',$rows[PROD_ESPERADA])";		
/*					
		echo '<pre>';
		print_r($sql_ins_dia);
		echo '</pre>';					
*/					
					
					$resultado = mysqli_query($link,$sql_ins_dia)or die(salida_con_rollback($resp,$link));				
				}
			}
			
			$sqlx = "select distinct ACTIV_ID,SUP_RUT from t1";
			$resultset = mysqli_query($link, $sqlx) or die("database error:". mysqli_error($link));
		
			while( $rows = mysqli_fetch_assoc($resultset) ) {			
			
				foreach ($dias_rep as $dia) {
								
					$sql_ins_sup = "INSERT INTO PLAN_MAESTRO_SUP VALUES ('$dia',$rows[ACTIV_ID],'$rows[SUP_RUT]')";	
/*					
		echo '<pre>';
		print_r($sql_ins_sup);
		echo '</pre>';						
*/					
					$resultado = mysqli_query($link,$sql_ins_sup)or die(salida_con_rollback($resp,$link));				
				}
			}			
			mysqli_commit($link);
		}	
	
	
	
		elseif($operacion == 'UPDATE'){
			
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$plan_dia = $_POST['plan_dia'];	
			$activ_id = $_POST['activ_id'];
			$sup_rut = $_POST['sup_rut'];
			$jornada = $_POST['jornada'];
			$prod_esperada = $_POST['prod_esperada'];
			$jornada = str_replace(",", ".",$jornada);
			$de_interes = $_POST['de_interes'];
			$tipo = $_POST['tipo'];
			$h_activ_id = $_POST['h_activ_id'];		
			
			if($per_agno == "" or $sem_num == "" or $plan_dia == "" or $activ_id == "" or $sup_rut == "" or $jornada == "" or $prod_esperada == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			mysqli_autocommit($link, FALSE);
			$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos1.');

			$dias = explode("," , $plan_dia);
			$supervisores = explode("," , $sup_rut);			

			foreach ($dias as $dia) {
			
				$sql_del_sup = "DELETE FROM PLAN_MAESTRO_SUP WHERE PLANM_DIA = '$dia' AND ACTIV_ID = $h_activ_id";
				$resultado = mysqli_query($link,$sql_del_sup)or die(salida_con_rollback($resp,$link));			

				$sql_del_activ = "DELETE FROM PLAN_MAESTRO WHERE PLANM_DIA = '$dia' AND ACTIV_ID = $h_activ_id";
				$resultado = mysqli_query($link,$sql_del_activ)or die(salida_con_rollback($resp,$link));					
				
				$sql = "SELECT PLANM_DIA FROM PLAN_MAESTRO WHERE PLANM_DIA = '$dia' AND ACTIV_ID = $activ_id";				
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);	
				
				if($rowcount == 0){
					
					$sql_ins_dia = "INSERT INTO PLAN_MAESTRO(PLANM_DIA, ACTIV_ID, PER_AGNO, SEM_NUM, JORNADA, DE_INTERES, PROD_ESPERADA) VALUES ('$dia',$activ_id,$per_agno,$sem_num,$jornada,'$de_interes',$prod_esperada)";						
					$resultado = mysqli_query($link,$sql_ins_dia)or die(salida_con_rollback($resp,$link));
				
					foreach ($supervisores as $supervisor) {
						$sql_ins_sup = "INSERT INTO PLAN_MAESTRO_SUP VALUES ('$dia',$activ_id,'$supervisor')";	
						$resultado = mysqli_query($link,$sql_ins_sup)or die(salida_con_rollback($resp,$link));						
					}
				}else{
					$resp = array('cod'=>'error','desc'=>'Actividad ya registrada en d??a seleccionado');
					salida_con_rollback($resp,$link);				
				}
			}
			mysqli_commit($link);
			

		}	
		
		elseif($operacion == 'DELETE'){
			
			$plan_dia = $_POST['plan_dia'];		
			$h_activ_id = $_POST['h_activ_id'];
			$tipo = $_POST['tipo'];
			
			if($plan_dia == "" or $h_activ_id == "" ){
				$resp = array('cod'=>'error','desc'=>'Datos obligatorios ausentes');
				salida($resp);
			}
			
			mysqli_autocommit($link, FALSE);
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');
			$dias = explode("," , $plan_dia);
			foreach ($dias as $dia) {
			
				$sql_del_sup = "DELETE FROM PLAN_MAESTRO_SUP WHERE PLANM_DIA = '$dia' AND ACTIV_ID = $h_activ_id";
				$resultado = mysqli_query($link,$sql_del_sup)or die(salida_con_rollback($resp,$link));			

				$sql_del_activ = "DELETE FROM PLAN_MAESTRO WHERE PLANM_DIA = '$dia' AND ACTIV_ID = $h_activ_id";
				$resultado = mysqli_query($link,$sql_del_activ)or die(salida_con_rollback($resp,$link));					
	
			}		
			
			mysqli_commit($link);
		}	
		
		
		
		elseif($operacion == 'DELETE ALL'){
			
			$plan_dia = $_POST['dia'];		
			$area_id = $_POST['area_id'];
			
			if($plan_dia == "" or $area_id == "" ){
				$resp = array('cod'=>'error','desc'=>'Datos obligatorios ausentes');
				salida($resp);
			}
			
			mysqli_autocommit($link, FALSE);
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');
			$tipo  = "x";
			$dias = explode("," , $plan_dia);
			
			foreach ($dias as $dia) {
			
				$sql_del_sup = "DELETE PLANS FROM PLAN_MAESTRO_SUP AS PLANS JOIN ACTIVIDAD ACT ON ACT.ACTIV_ID = PLANS.ACTIV_ID WHERE PLANS.PLANM_DIA = '$dia' AND ACT.AREA_ID = $area_id";
				$resultado = mysqli_query($link,$sql_del_sup)or die(salida_con_rollback($resp,$link));		
			
				$sql_del_plan = "DELETE PLAN FROM PLAN_MAESTRO AS PLAN JOIN ACTIVIDAD ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID WHERE PLAN.PLANM_DIA = '$dia' AND ACT.AREA_ID = $area_id";
				$resultado = mysqli_query($link,$sql_del_plan)or die(salida_con_rollback($resp,$link));			
			}
			mysqli_commit($link);
		}		
		
		/*
		elseif(isset($_GET['operacion'])){	
			$plan_dia = $_GET['plan_dia'];
			$plan_dia_elim = $_GET['plan_dia_elim'];
			$id_area = $_GET['area_id'];*/		
		elseif($operacion == 'DELETE-DIACOMUN'){

			$plan_dia = $_POST['plan_dia'];		
			$dias = explode("," , $plan_dia);
			
			$plan_dia_elim = $_POST['plan_dia_elim'];	
			$dias_elim = explode("," , $plan_dia_elim);			
			
			$dia_meta = $dias[0];
			$id_area = $_POST['area_id'];

			$uno = $dias[0];
			$dos = !empty($dias[1]) ? $dias[1] : '';
			$tres = !empty($dias[2]) ? $dias[2] : '';
			$cuatro = !empty($dias[3]) ? $dias[3] : '';
			$cinco = !empty($dias[4]) ? $dias[4] : '';
			$seis = !empty($dias[5]) ? $dias[5] : '';
			
			$tipo  = "x";
			$nro_dias = count($dias);
			
			if($plan_dia == "" or $plan_dia_elim == "" or $id_area == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}						

			$sqlx = "drop temporary table if exists t1";
			$resultset = mysqli_query($link, $sqlx) or die("database error:". mysqli_error($link));			
			
			$sql = "CREATE TEMPORARY TABLE t1 (SELECT ACT.ACTIV_NOMBRE, PLAN.DE_INTERES, PLAN.JORNADA, IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),0) AS META,
					/*(PLAN.JORNADA * IFNULL(MET.MET_UNDXHR,0) * 8.25) AS*/ PLAN.PROD_ESPERADA, IFNULL(UND.UND_NOMBRE,'') AS UNIDAD, 					CONCAT(ACT.ACTIV_ID,'---',IFNULL(UND.UND_NOMBRE,0),'---',IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),0),'---',ACT.ACTIV_TIPO) AS ACTIV_ALL_ID, ACT.ACTIV_ID, PLANS.SUP_RUT, PLAN.PER_AGNO, PLAN.SEM_NUM
					FROM PLAN_MAESTRO AS PLAN 
					JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
					JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
					JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
					JOIN PLAN_MAESTRO_SUP AS PLANS ON PLANS.PLANM_DIA = PLAN.PLANM_DIA AND PLANS.ACTIV_ID = PLAN.ACTIV_ID
					LEFT JOIN UNIDAD AS UND ON UND.UND_ID = ACT.UND_ID 
					LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACT.ACTIV_ID AND '$dia_meta'>= MET.MET_INIVIG 
					AND (MET.MET_FINVIG IS NULL OR '$dia_meta'<= MET.MET_FINVIG)				
					WHERE PLAN.PLANM_DIA IN ('$uno','$dos','$tres','$cuatro','$cinco','$seis') AND AREA.AREA_ID =".$id_area." 
					GROUP BY ACT.ACTIV_NOMBRE, PLAN.DE_INTERES, PLAN.JORNADA, MET.MET_UNDXHR, UND.UND_NOMBRE, PLAN.ACTIV_ID, PLANS.SUP_RUT, PLAN.PER_AGNO, PLAN.SEM_NUM
					HAVING COUNT(*) = ".$nro_dias.")";				

			$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));		
		
			$sqlx = "select distinct ACTIV_ID from t1";
			$resultset = mysqli_query($link, $sqlx) or die("database error:". mysqli_error($link));
			
			mysqli_autocommit($link, FALSE);			
			$resp = array('cod'=>'error','desc'=>'Error de Base de Datos');

			while( $rows = mysqli_fetch_assoc($resultset) ) {			
			
				foreach ($dias_elim as $dia) {
								
					$sql_del_sup = "DELETE FROM PLAN_MAESTRO_SUP WHERE PLANM_DIA = '$dia' AND ACTIV_ID = $rows[ACTIV_ID]";
					$resultado = mysqli_query($link,$sql_del_sup)or die(salida_con_rollback($resp,$link));		
/*
		echo '<pre>';
		print_r($sql_del_sup);
		echo '</pre>';						
*/					
					$sql_del_plan = "DELETE FROM PLAN_MAESTRO WHERE PLANM_DIA = '$dia' AND ACTIV_ID = $rows[ACTIV_ID]";
					$resultado = mysqli_query($link,$sql_del_plan)or die(salida_con_rollback($resp,$link));	
		/*			
		echo '<pre>';
		print_r($sql_del_plan);
		echo '</pre>';	
		*/
				}
			}
			
			mysqli_commit($link);
		}			
		
		
		
		
		
		
		
		
		
		$resp = array('cod'=>'ok','operacion'=>$operacion,'tipo'=>$tipo);
	}
	mysqli_close($link);
	//Retorna respuesta
	echo json_encode($resp);
	exit();	
?>