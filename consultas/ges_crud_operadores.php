<?php 

	include('coneccion.php');
	if(!isset($operador)){
		include('funciones_comunes.php');	
	}
	
	if(isset($_GET['data'])){
	
		$sql = "SELECT OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO, OPER_ESTADO, CMN_CODIGO, OPER_NOMBRES, OPER_PATERNO, OPER_MATERNO, OPER_SEXO, DATE_FORMAT(OPER_FECHANAC,'%d-%m-%Y') as OPER_FECHANAC, OPER_DIRECCION, OPER_FONO, OPER_EMAIL, OPER_CIVIL FROM OPERADOR ORDER BY OPER_FECHACT DESC";	
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
	
		while( $rows = mysqli_fetch_assoc($resultset) ) {
		
			$data[] = 
			Array
			(
				'OPER_RUT' => formateo_rut($rows[OPER_RUT]),
				'OPERARIO' => $rows[OPERARIO],								
				'OPER_ESTADO' => $rows[OPER_ESTADO],
				'CMN_CODIGO' => $rows[CMN_CODIGO],
				'OPER_NOMBRES' => $rows[OPER_NOMBRES],
				'OPER_PATERNO' => $rows[OPER_PATERNO],
				'OPER_MATERNO' => $rows[OPER_MATERNO],
				'OPER_SEXO' => $rows[OPER_SEXO],
				'OPER_FECHANAC' => $rows[OPER_FECHANAC],
				'OPER_DIRECCION' => $rows[OPER_DIRECCION],
				'OPER_FONO' => $rows[OPER_FONO],
				'OPER_EMAIL' => $rows[OPER_EMAIL],
				'OPER_CIVIL' => $rows[OPER_CIVIL]				
			);			
			
		}
	/*	
		echo('<pre>');
		print_r($data);
		echo('</pre>');		
	
		echo('<pre>');
		print_r(json_encode($data));
		echo('</pre>');
	*/
		
		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);
		


	}
	
	elseif(isset($operador)){
	
		$sql = "select OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO from OPERADOR";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}	
		
		$load_operadores = json_encode($data);
	}
	
	elseif(isset($_POST['oper_combo'])){
		
		$activ_id = $_POST['activ_id'];
		$activ_standar = $_POST['activ_standar'];

		if($activ_standar == 'S'){
			$sql = "
			SELECT O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO 
			FROM OPERADOR AS O WHERE O.OPER_ESTADO = 'VIGENTE' ORDER BY OPERARIO";		
			
		}else{
			$sql = "
			SELECT O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO 
			FROM COMPETENCIA AS C JOIN OPERADOR AS O ON C.OPER_RUT = O.OPER_RUT WHERE C.ACTIV_ID = $activ_id AND O.OPER_ESTADO = 'VIGENTE' ORDER BY OPERARIO";		
		}	
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}		
		
		salida($data);
	}
	
	
	elseif(isset($_POST['oper_combo2'])){
		
		$activ_id = $_POST['activ_id'];
		$activ_standar = $_POST['activ_standar'];

		$sql = "
		SELECT O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO 
		FROM OPERADOR AS O WHERE O.OPER_ESTADO = 'VIGENTE' ORDER BY OPERARIO";		

		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}		
		
		salida($data);
	}	
	
	
	elseif(isset($_POST['oper_table'])){
		
		$activ_id = $_POST['activ_id'];
		$plan_dia = $_POST['plan_dia'];
		//$estado = $_POST['estado'];
		
		$sql = "
			SELECT O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO, PLANO_HORAS, PLANO_ASIST, IFNULL(PLANO_CANT,0) AS PLANO_CANT, 
			PLANO_CANT1,PLANO_CANT2,PLANO_CANT3,PLANO_CANT4,PLANO_HRINI, PLANO_MININI, PLANO_HRFIN, PLANO_MINFIN, PLANO_HRDSCTO, PLANO_MINDSCTO, PLANO_B1, PLANO_B2, PLANO_COL, 
			IFNULL(PLANO_OBS,'') AS PLANO_OBS, IFNULL(PLANO_HORASPROD,0) AS PLANO_HORASPROD	
			FROM PLANIFICACION_OPER AS PLANO 
			JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
			JOIN PLANIFICACION AS PLAN ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.PLAN_DIA = $plan_dia AND PLAN.ACTIV_ID = $activ_id 
			ORDER BY OPERARIO,PLANO.PLANO_FECHACT ASC
		";	

		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$PLANO_CANT = str_replace(',00','',str_replace(".", ",",$rows[PLANO_CANT]));
			$PLANO_CANT1 = str_replace(',00','',str_replace(".", ",",$rows[PLANO_CANT1]));
			$PLANO_CANT2 = str_replace(',00','',str_replace(".", ",",$rows[PLANO_CANT2]));
			$PLANO_CANT3 = str_replace(',00','',str_replace(".", ",",$rows[PLANO_CANT3]));
			$PLANO_CANT4 = str_replace(',00','',str_replace(".", ",",$rows[PLANO_CANT4]));
		
			$data[] = 
			Array
			(
				'OPER_RUT' => $rows[OPER_RUT],
				'OPERARIO' => $rows[OPERARIO],
				'PLANO_HORAS' => $rows[PLANO_HORAS],
				'PLANO_ASIST' => $rows[PLANO_ASIST],
				'PLANO_CANT' => $PLANO_CANT,
				'PLANO_CANT1' => $PLANO_CANT1,
				'PLANO_CANT2' => $PLANO_CANT2,
				'PLANO_CANT3' => $PLANO_CANT3,
				'PLANO_CANT4' => $PLANO_CANT4,
				'PLANO_HRINI' => $rows[PLANO_HRINI],
				'PLANO_MININI' => $rows[PLANO_MININI],
				'PLANO_HRFIN' => $rows[PLANO_HRFIN],
				'PLANO_MINFIN' => $rows[PLANO_MINFIN],
				'PLANO_HRDSCTO' => $rows[PLANO_HRDSCTO],
				'PLANO_MINDSCTO' => $rows[PLANO_MINDSCTO],					
				'PLANO_B1' => $rows[PLANO_B1],
				'PLANO_B2' => $rows[PLANO_B2],
				'PLANO_COL' => $rows[PLANO_COL],
				'PLANO_OBS' => $rows[PLANO_OBS],
				'PLANO_HORASPROD' => $rows[PLANO_HORASPROD]
			);
		}	
			
		salida($data);
	}	

	
	
	elseif(isset($_POST['det_prodxhr'])){
		
		$activ_id = $_POST['activ_id'];
		$plan_dia = $_POST['plan_dia'];
		
		$sql = "
			SELECT O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO, IFNULL(PLANO_CANT,0) AS PLANO_CANT
			FROM PLANIFICACION_OPER AS PLANO 
			JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
			JOIN PLANIFICACION AS PLAN ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.PLAN_DIA = $plan_dia AND PLAN.ACTIV_ID = $activ_id and PLANO_ASIST = 'S' and PLANO_CANT > 0
			ORDER BY OPERARIO,PLANO.PLANO_FECHACT ASC
		";	

		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$PLANO_CANT = str_replace(',00','',str_replace(".", ",",$rows[PLANO_CANT]));
		
			$data[] = 
			Array
			(
				'OPER_RUT' => $rows[OPER_RUT],
				'OPERARIO' => $rows[OPERARIO],
				'PLANO_CANT' => $PLANO_CANT
			);
		}	
			
		salida($data);
	}	
	
	
	elseif(isset($_POST['oper_faltante'])){

		$oper_rut = $_POST['oper_rut'];
		$plan_dia = $_POST['plan_dia'];	
	
		$sql = "select AREA_NOMBRE, CONCAT(SUP_NOMBRES,' ',SUP_PATERNO,' ',SUP_MATERNO) AS SUPERVISOR, ACTIV_NOMBRE, PLANO_HORAS,
O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO, IFNULL(PLANO_HORASPROD,0) AS PLANO_HORASPROD		
		FROM PLANIFICACION AS PLAN 
		JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID 
		JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
		JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
		JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
		JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = PLAN.SUP_RUT
		WHERE PLANO.PLAN_DIA = '$plan_dia' AND PLANO.OPER_RUT = '$oper_rut'
		ORDER BY PLANO.PLANO_FECHACT ASC";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
		
			$PLANO_HORAS = str_replace(',00','',str_replace(".", ",",$rows[PLANO_HORAS]));
			$PLANO_HORASPROD = str_replace(',00','',str_replace(".", ",",$rows[PLANO_HORASPROD]));
		
			$data[] = 
			Array
			(
				'OPERARIO' => $rows[OPERARIO],
				'AREA_NOMBRE' => $rows[AREA_NOMBRE],
				'SUPERVISOR' => $rows[SUPERVISOR],
				'ACTIV_NOMBRE' => $rows[ACTIV_NOMBRE],
				'PLANO_HORAS' => $PLANO_HORAS,
				'PLANO_HORASPROD' => $PLANO_HORASPROD
			);
		}	
		
		salida($data);
	}	
	
	
	
	elseif(isset($_POST['change_activ'])){
		$plan_area = $_POST['plan_area'];
		//$plan_dia_id = !empty($_POST['plan_dia_id']) ? $_POST['plan_dia_id'] : "NULL";
		$sem_num = $_POST['sem_num'];
		$activ_id = $_POST['activ_id'];
		$plan_dia = !empty($_POST['h_plan_dia']) ? $_POST['h_plan_dia'] : "NULL";
		
		//$per_agno = $_POST['per_agno'];
		$per_agno = !empty($_POST['per_agno']) ? $_POST['per_agno'] : 0;
		
		$rut_oper = $_POST['rut_oper'];
		$activ_standar = $_POST['activ_standar'];
		$h_activ_id = $_POST['h_activ_id'];
		$disp = $_POST['disp'];
		
		if($activ_standar == 'S'){
			$sql = "
			SELECT O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO 
			FROM PLANIFICACION_OPER AS PLANO JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
			JOIN PLANIFICACION AS PLAN ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.PLAN_DIA = $plan_dia AND PLAN.ACTIV_ID = $activ_id AND O.OPER_ESTADO = 'NO VIGENTE'
			UNION
			SELECT O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO 
			FROM OPERADOR AS O WHERE O.OPER_ESTADO = 'VIGENTE' ORDER BY OPERARIO";		
			
		}else{
			$sql = "
			SELECT O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO 
			FROM PLANIFICACION_OPER AS PLANO JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
			JOIN PLANIFICACION AS PLAN ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.PLAN_DIA = $plan_dia AND PLAN.ACTIV_ID = $activ_id AND O.OPER_ESTADO = 'NO VIGENTE'
			UNION
			SELECT O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO 
			FROM COMPETENCIA AS C JOIN OPERADOR AS O ON C.OPER_RUT = O.OPER_RUT WHERE C.ACTIV_ID = $activ_id AND O.OPER_ESTADO = 'VIGENTE' ORDER BY OPERARIO";		
		}
	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();

		while( $rows = mysqli_fetch_assoc($resultset) ) {
		
			$sql_sem_oper = "SELECT AREA.AREA_NOMBRE, ACT.ACTIV_NOMBRE, DATE_FORMAT(PLAN.PLAN_DIA,'%Y%m%d') as PLAN_DIA, PLANO.PLANO_HORAS, ACT.ACTIV_ID, DATE_FORMAT(PLAN.PLAN_DIA,'%d-%m-%Y') as PLAN_DIA_H 
			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
			JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
			WHERE PLAN.SEM_NUM = $sem_num AND PLANO.OPER_RUT = '$rows[OPER_RUT]' AND PLAN.PER_AGNO = $per_agno
			ORDER BY PLANO.PLANO_FECHACT ASC";
			$resultado = mysqli_query($link, $sql_sem_oper) or die("database error:". mysqli_error($link));
			
			$operadores = explode("," , $rut_oper);
			
			$MARCACHECK = '';
			foreach ($operadores as $oper_rut) {
				if($oper_rut == $rows[OPER_RUT]){ $MARCACHECK = 'checked';}				
			}						
			
			$LUN[0] = 0;$MAR[0] = 0;$MIE[0] = 0;$JUE[0] = 0;$VIE[0] = 0;$SAB[0] = 0;$DOM[0] = 0;
			$LUN[1] = 0;$MAR[1] = 0;$MIE[1] = 0;$JUE[1] = 0;$VIE[1] = 0;$SAB[1] = 0;$DOM[1] = 0;
			$dias = array('DOM','LUN','MAR','MIE','JUE','VIE','SAB','DOM');
			//$DISPONIBILIDAD = '';
			$a = 0;$b = 0;$c = 0;$d = 0;$e = 0;$f = 0;$g = 0;$suma_disp = 0;
			while( $rows_dia_sem = mysqli_fetch_assoc($resultado) ) {			
			
				$dia_sem = $dias[date('N', strtotime($rows_dia_sem[PLAN_DIA]))];	
				//ARREGLAR
				
				if(!empty($_POST['h_plan_dia']) and $rows_dia_sem[ACTIV_ID] == $h_activ_id and $rows_dia_sem[PLAN_DIA_H] == $_POST['h_plan_dia'] and $rows_dia_sem[PLANO_HORAS] == 8.5 and $dia_sem <> 'DOM'){
				
				}else{
					
					$suma_disp = $suma_disp + $rows_dia_sem[PLANO_HORAS];
					
					$PLANO_HORAS = str_replace(',00','',str_replace(".", ",",$rows_dia_sem[PLANO_HORAS]));
	
					switch($dia_sem){
						
						case 'LUN':
							$LUN[$a] = $rows_dia_sem[AREA_NOMBRE].'---'.$rows_dia_sem[ACTIV_NOMBRE].'---'.$PLANO_HORAS;
							$a++;
						break;
						case 'MAR':
							$MAR[$b] = $rows_dia_sem[AREA_NOMBRE].'---'.$rows_dia_sem[ACTIV_NOMBRE].'---'.$PLANO_HORAS;
							$b++;
						break;						
						case 'MIE':
							$MIE[$c] = $rows_dia_sem[AREA_NOMBRE].'---'.$rows_dia_sem[ACTIV_NOMBRE].'---'.$PLANO_HORAS;
							$c++;
						break;						
						case 'JUE':
							$JUE[$d] = $rows_dia_sem[AREA_NOMBRE].'---'.$rows_dia_sem[ACTIV_NOMBRE].'---'.$PLANO_HORAS;
							$d++;
						break;						
						case 'VIE':
							$VIE[$e] = $rows_dia_sem[AREA_NOMBRE].'---'.$rows_dia_sem[ACTIV_NOMBRE].'---'.$PLANO_HORAS;
							$e++;
						break;	
						case 'SAB':
							$SAB[$f] = $rows_dia_sem[AREA_NOMBRE].'---'.$rows_dia_sem[ACTIV_NOMBRE].'---'.$PLANO_HORAS;
							$f++;
						break;		
						case 'DOM':
							$DOM[$g] = $rows_dia_sem[AREA_NOMBRE].'---'.$rows_dia_sem[ACTIV_NOMBRE].'---'.$PLANO_HORAS;
							$g++;
						break;							
					}
				}
			}
		
			if($disp == 'D' and $suma_disp == 42.5){
				
			}else{
		
				$data[] = 
				Array
				(
					'OPER_RUT' => $rows[OPER_RUT],
					'OPERARIO' => $rows[OPERARIO],								
					'LUN' => $LUN,
					'MAR' => $MAR,
					'MIE' => $MIE,
					'JUE' => $JUE,
					'VIE' => $VIE,
					'SAB' => $SAB,
					'DOM' => $DOM,
					'MARCACHECK' => $MARCACHECK/*,
					'DISPONIBILIDAD' => $DISPONIBILIDAD*/
				);
			}
		}		
		salida($data);	
	}	
	
	elseif(isset($_POST['change_activ_extra'])){
		$plan_area = $_POST['plan_area'];
		//$plan_dia_id = !empty($_POST['plan_dia_id']) ? $_POST['plan_dia_id'] : "NULL";
		$sem_num = $_POST['sem_num'];
		$activ_id = $_POST['activ_id'];
		$plan_dia = !empty($_POST['h_plan_dia']) ? $_POST['h_plan_dia'] : "NULL";
		$rut_oper = $_POST['rut_oper'];
		$activ_standar = $_POST['activ_standar'];
		$h_activ_id = $_POST['h_activ_id'];
		$per_agno = !empty($_POST['per_agno']) ? $_POST['per_agno'] : 0;
		
		if($activ_standar == 'S'){
			$sql = "
			SELECT O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO 
			FROM PLANIFICACION_EXTRA_OPER AS PLANO JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
			JOIN PLANIFICACION_EXTRA AS PLAN ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.PLAN_DIA = $plan_dia AND PLAN.ACTIV_ID = $activ_id AND O.OPER_ESTADO = 'NO VIGENTE'
			UNION
			SELECT O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO 
			FROM OPERADOR AS O WHERE O.OPER_ESTADO = 'VIGENTE' ORDER BY OPERARIO";		
			
		}else{
			$sql = "
			SELECT O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO 
			FROM PLANIFICACION_EXTRA_OPER AS PLANO JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
			JOIN PLANIFICACION_EXTRA AS PLAN ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.PLAN_DIA = $plan_dia AND PLAN.ACTIV_ID = $activ_id AND O.OPER_ESTADO = 'NO VIGENTE'
			UNION
			SELECT O.OPER_RUT,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO 
			FROM COMPETENCIA AS C JOIN OPERADOR AS O ON C.OPER_RUT = O.OPER_RUT WHERE C.ACTIV_ID = $activ_id AND O.OPER_ESTADO = 'VIGENTE' ORDER BY OPERARIO";		
		}
	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();

		while( $rows = mysqli_fetch_assoc($resultset) ) {
		
			$sql_sem_oper = "SELECT AREA.AREA_NOMBRE, ACT.ACTIV_NOMBRE, DATE_FORMAT(PLAN.PLAN_DIA,'%Y%m%d') as PLAN_DIA, PLANO.PLANO_HORAS, ACT.ACTIV_ID, DATE_FORMAT(PLAN.PLAN_DIA,'%d-%m-%Y') as PLAN_DIA_H, PLANO.TIPO_JORNADA 
			FROM PLANIFICACION_EXTRA AS PLAN 
			JOIN PLANIFICACION_EXTRA_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
			JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
			WHERE PLAN.SEM_NUM = $sem_num AND PLANO.OPER_RUT = '$rows[OPER_RUT]' AND PLAN.PER_AGNO = $per_agno
			";
			$resultado = mysqli_query($link, $sql_sem_oper) or die("database error:". mysqli_error($link));
			
			$operadores = explode("," , $rut_oper);
			
			$MARCACHECK = '';
			foreach ($operadores as $oper_rut) {
				if($oper_rut == $rows[OPER_RUT]){ $MARCACHECK = 'checked';}				
			}						
			
			$LUN[0] = 0;$MAR[0] = 0;$MIE[0] = 0;$JUE[0] = 0;$VIE[0] = 0;$SAB[0] = 0;$DOM[0] = 0;
			$LUN[1] = 0;$MAR[1] = 0;$MIE[1] = 0;$JUE[1] = 0;$VIE[1] = 0;$SAB[1] = 0;$DOM[1] = 0;
			$dias = array('DOM','LUN','MAR','MIE','JUE','VIE','SAB','DOM');
			

			$a = 0;$b = 0;$c = 0;$d = 0;$e = 0;$f = 0;$g = 0;//$suma_disp = 0;
			while( $rows_dia_sem = mysqli_fetch_assoc($resultado) ) {			
			/*		
				//ARREGLAR
				if(!empty($_POST['h_plan_dia']) and $rows_dia_sem[ACTIV_ID] == $h_activ_id and $rows_dia_sem[PLAN_DIA_H] == $_POST['h_plan_dia'] and $rows_dia_sem[PLANO_HORAS] == 8.5 ){
				
				}else{
			*/		
					//$suma_disp = $suma_disp + $rows_dia_sem[PLANO_HORAS];
					
					$PLANO_HORAS = str_replace(',00','',str_replace(".", ",",$rows_dia_sem[PLANO_HORAS]));
			
					$dia_sem = $dias[date('N', strtotime($rows_dia_sem[PLAN_DIA]))];
					
					$detalle_actividad = $rows_dia_sem[AREA_NOMBRE].'---'.$rows_dia_sem[ACTIV_NOMBRE].'---'.$PLANO_HORAS.'---'.$rows_dia_sem[TIPO_JORNADA];
					
					
					switch($dia_sem){
						
						case 'LUN':
							$LUN[$a] = $detalle_actividad;
							$a++;
						break;
						case 'MAR':
							$MAR[$b] = $detalle_actividad;
							$b++;
						break;						
						case 'MIE':
							$MIE[$c] = $detalle_actividad;
							$c++;
						break;						
						case 'JUE':
							$JUE[$d] = $detalle_actividad;
							$d++;
						break;						
						case 'VIE':
							$VIE[$e] = $detalle_actividad;
							$e++;
						break;	
						case 'SAB':
							$SAB[$f] = $detalle_actividad;
							$f++;
						break;	
						case 'DOM':
							$DOM[$g] = $detalle_actividad;
							$g++;
						break;							
					}
				//}
			}
		

		
			$data[] = 
			Array
			(
				'OPER_RUT' => $rows[OPER_RUT],
				'OPERARIO' => $rows[OPERARIO],								
				'LUN' => $LUN,
				'MAR' => $MAR,
				'MIE' => $MIE,
				'JUE' => $JUE,
				'VIE' => $VIE,
				'SAB' => $SAB,
				'DOM' => $DOM,
				'MARCACHECK' => $MARCACHECK
			);

		}		
		salida($data);	
	}	
	
	
	
	
	else{
	

		$operacion = $_POST['operacion'];

		if($operacion == 'INSERT'){
		
			$oper_rut = str_replace(".", "",$_POST['oper_rut']);
			$cmn_codigo = $_POST['cmn_codigo'];
			$oper_nombres = $_POST['oper_nombres'];
			$oper_paterno = $_POST['oper_paterno'];
			$oper_materno = $_POST['oper_materno'];
			$oper_sexo = $_POST['oper_sexo'];
			$fechanac = explode("-" , $_POST['oper_fechanac']);
			$oper_fechanac = $fechanac[2].'-'.$fechanac[1].'-'.$fechanac[0];
			$oper_direccion = $_POST['oper_direccion'];
			$oper_fono = $_POST['oper_fono'];
			$oper_email = $_POST['oper_email'];
			$oper_civil = $_POST['oper_civil'];
			$oper_estado = $_POST['oper_estado'];
			
			if($oper_rut == "" or $cmn_codigo == "" or $oper_nombres == "" or $oper_paterno == "" or $oper_materno == "" or $oper_sexo == "" or $oper_fechanac == "" or $oper_civil == "" or $oper_estado == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			$sql_ins_oper = "INSERT INTO OPERADOR(OPER_RUT, CMN_CODIGO, OPER_NOMBRES, OPER_PATERNO, OPER_MATERNO, OPER_SEXO, OPER_FECHANAC, OPER_DIRECCION, OPER_FONO, OPER_EMAIL, OPER_CIVIL, OPER_ESTADO) VALUES ('$oper_rut',$cmn_codigo,'$oper_nombres','$oper_paterno','$oper_materno','$oper_sexo','$oper_fechanac','$oper_direccion','$oper_fono','$oper_email','$oper_civil','$oper_estado')";

			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
			$resultado = mysqli_query($link,$sql_ins_oper)or die(salida($resp));		

		}
		
		elseif($operacion == 'UPDATE'){
			
			$oper_rut = str_replace(".", "",$_POST['oper_rut']);
			$cmn_codigo = $_POST['cmn_codigo'];
			$oper_nombres = $_POST['oper_nombres'];
			$oper_paterno = $_POST['oper_paterno'];
			$oper_materno = $_POST['oper_materno'];
			$oper_sexo = $_POST['oper_sexo'];
			$fechanac = explode("-" , $_POST['oper_fechanac']);
			$oper_fechanac = $fechanac[2].'-'.$fechanac[1].'-'.$fechanac[0];
			$oper_direccion = $_POST['oper_direccion'];
			$oper_fono = $_POST['oper_fono'];
			$oper_email = $_POST['oper_email'];
			$oper_civil = $_POST['oper_civil'];
			$oper_estado = $_POST['oper_estado'];
			
			if($oper_rut == "" or $cmn_codigo == "" or $oper_nombres == "" or $oper_paterno == "" or $oper_materno == "" or $oper_sexo == "" or $oper_fechanac == "" or $oper_civil == "" or $oper_estado == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			$sql_upd_oper = "UPDATE OPERADOR SET CMN_CODIGO=$cmn_codigo,OPER_NOMBRES='$oper_nombres',OPER_PATERNO='$oper_paterno',OPER_MATERNO='$oper_materno',OPER_SEXO='$oper_sexo',OPER_FECHANAC='$oper_fechanac',OPER_DIRECCION='$oper_direccion',OPER_FONO='$oper_fono',OPER_EMAIL='$oper_email',OPER_CIVIL='$oper_civil',OPER_ESTADO='$oper_estado',OPER_FECHACT=CURRENT_TIMESTAMP WHERE OPER_RUT='$oper_rut'";

			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
			$resultado = mysqli_query($link,$sql_upd_oper)or die(salida($resp));			
		}	
		
		elseif($operacion == 'DELETE'){
			
			$oper_rut = str_replace(".", "",$_POST['oper_rut']);
			
			if($oper_rut == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
			
			$sql_del_oper = "DELETE FROM OPERADOR WHERE OPER_RUT='$oper_rut'";
			$resultado = mysqli_query($link,$sql_del_oper)or die(salida($resp));
		}		

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	if(!isset($operador)){
		echo json_encode($resp);	
	}	

?>