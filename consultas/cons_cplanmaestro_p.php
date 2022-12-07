<?php 

	include('coneccion.php');
	
	if(isset($_GET['per_agno'])){
	
		$per_agno = $_GET['per_agno'];
		$per_mes = $_GET['per_mes'];
		$sem_num = $_GET['sem_num'];	
		$plan_dia = $_GET['plan_dia'];
		$area_id = $_GET['area_id'];
		$sup_rut = $_GET['sup_rut'];		
/*
		$per_agno = '';
		$per_mes = '';
		$sem_num = '';	
		$plan_dia = '20180827';
		$area_id = '';
		$sup_rut = '';		
*/			
//(CASE WHEN PLANO.ACTIV_ID IS NULL THEN 'S' ELSE 'N' END) AS ACTIVIDAD_PLANIFICADA		
	$sql = "SELECT ACT.ACTIV_ID,PLAN.PLANM_DIA,
			DATE_FORMAT(PLAN.PLANM_DIA,'%d-%m-%Y') as PLAN_DIA, SEM.PER_AGNO, SEM.PER_MES, SEM.SEM_NUM, AREA.AREA_NOMBRE AS AREA, 
			GROUP_CONCAT(DISTINCT CONCAT(SUP.SUP_NOMBRES,' ',SUP.SUP_PATERNO,' ',SUP.SUP_MATERNO) SEPARATOR ',') AS SUPERVISOR,
			
			ACT.ACTIV_NOMBRE AS ACTIVIDAD, ACT.ACTIV_TIPO AS TIPO_ACTIVIDAD,
			
			/*(PLAN.JORNADA * IFNULL(MET.MET_UNDXHR,0) * 8.25) AS*/ PLAN.PROD_ESPERADA,
			
			SUM(PLANO.PLANO_CANT) AS PROD_REAL, 
			
			IFNULL(UND.UND_NOMBRE,'') AS UNIDAD,
			
			IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),0) AS METAXHR,
			
			PLAN.JORNADA AS JORN_PLANIFICADAS,
			
			SUM(CASE WHEN PLANO.PLANO_ASIST = 'S' THEN PLANO.PLANO_HORASPROD ELSE 0 END) AS HRS_PRODUCTIVAS, 
			
			SUM(CASE WHEN PLANO.PLANO_ASIST = 'S' THEN 1 ELSE 0 END) AS OPERADORES, 

			/*'S' AS ACTIVIDAD_PLANIFICADA*/	
			(CASE WHEN PLANO.ACTIV_ID IS NULL THEN 'S' ELSE 'N' END) AS ACTIVIDAD_PLANIFICADA
			
			FROM PLAN_MAESTRO AS PLAN 
			JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
			JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
			JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
			LEFT JOIN UNIDAD AS UND ON UND.UND_ID = ACT.UND_ID 
			LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACT.ACTIV_ID AND PLAN.PLANM_DIA >= MET.MET_INIVIG 
			AND (MET.MET_FINVIG IS NULL OR PLAN.PLANM_DIA<= MET.MET_FINVIG)	
			JOIN PLAN_MAESTRO_SUP AS PLANS ON PLANS.PLANM_DIA = PLAN.PLANM_DIA AND PLANS.ACTIV_ID = PLAN.ACTIV_ID
			JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = PLANS.SUP_RUT
			/*LEFT JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLANM_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID*/
			LEFT JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLANM_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		WHERE 
		(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
		(SEM.PER_MES = '$per_mes' or '$per_mes' = '') AND
		(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND
		(PLAN.PLANM_DIA = '$plan_dia' or '$plan_dia' = '') AND
		(AREA.AREA_ID = '$area_id' or '$area_id' = '') AND
		(SUP.SUP_RUT = '$sup_rut' or '$sup_rut' = '')
		GROUP BY ACT.ACTIV_ID, PLAN.PLANM_DIA, SEM.PER_AGNO, SEM.PER_MES, SEM.SEM_NUM, AREA.AREA_NOMBRE, ACT.ACTIV_NOMBRE, ACT.ACTIV_TIPO, PLAN.JORNADA, MET.MET_UNDXHR, UND.UND_NOMBRE
		ORDER BY PLAN.PLANM_DIA
";			
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		

		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			
			$existe_activ_instalacion = 0;
			$existe_activ_cosecha = 0;
			$existe_activ_confeccion = 0;			

			$prod_esperada = '-';
			$jorn_planificadas = '-';
			$prod_real = '-';
			$horas_prod = '-';
	
			if($rows[PROD_ESPERADA] <> '0' and $rows[PROD_ESPERADA] <> ''){
				$prod_esperada = round($rows[PROD_ESPERADA]);			
			}

			if($rows[JORN_PLANIFICADAS] <> '0' and $rows[JORN_PLANIFICADAS] <> ''){
				$jorn_planificadas = str_replace('.0','',$rows[JORN_PLANIFICADAS]);
			}

			if($rows[PROD_REAL] <> '0' and $rows[PROD_REAL] <> ''){
				$prod_real = str_replace('.00','',$rows[PROD_REAL]);
			}	
			
			if($rows[HRS_PRODUCTIVAS] <> '0' and $rows[HRS_PRODUCTIVAS] <> ''){
				$horas_prod = str_replace('.00','',$rows[HRS_PRODUCTIVAS]);
			}
			
			//CONFECCION : 128 / CONFECCION MACRO-ESTACAS cambiado a 121 / CONFECCION MINI-ESTACAS 21/11/2018
			//CONFECCION GLOBULUS: 228
			//CONFECCION GLONI: 227
			
			//INSTALACION : 123
			//INSTALACION GLOBULUS: 432
			//INSTALACION GLONI: 433			
			
			
			if($rows[ACTIV_ID] == 62){ //COSECHA RAMAS PM
			
				$existe_activ_cosecha = 1;
				$cosecha = 0;
				$jornada = 0;

				if($prod_esperada <> '-'){					
					$cosecha = $rows[PROD_ESPERADA];
				}

				if($jorn_planificadas <> '-'){					
					$jornada = $rows[JORN_PLANIFICADAS];
				}

				//SELECT IFNULL(SUM(PLANO.PLANO_HORASPROD),0) * IFNULL(MET.MET_UNDXHR,0) AS PROD_ESPERADA, 
				$sql = "SELECT IFNULL(SUM(PLANO.PLANO_CANT),0) AS PROD_ESPERADA, 
				IFNULL(SUM(PLANO.PLANO_HORASPROD),0) AS HORAS_PLANIF, ACT.ACTIV_NOMBRE AS ACTIVIDAD, IFNULL(MET.MET_UNDXHR,0) AS META,
				IFNULL(SUM(PLANO.PLANO_HORASPROD),0) AS HORASPROD, SUM(CASE WHEN PLANO.PLANO_ASIST = 'S' THEN 1 ELSE 0 END) AS OPERADORES,
				SUM(IFNULL(PLANO.PLANO_CANT,0)) AS PROD_REAL
				FROM PLANIFICACION_OPER PLANO
				LEFT JOIN METAS AS MET ON MET.ACTIV_ID = PLANO.ACTIV_ID AND PLANO.PLAN_DIA >= MET.MET_INIVIG 
				AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)
				JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLANO.ACTIV_ID
				WHERE PLANO.PLAN_DIA = '$rows[PLANM_DIA]' AND PLANO.ACTIV_ID = 240";				

				$resultset2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
				$fila_cosecha_globulus = mysqli_fetch_row($resultset2);
				$rowcount_cosecha_globulus = mysqli_num_rows($resultset2);	
				
				$cosecha_globulus = $fila_cosecha_globulus[0];

				$jorn_cosecha_globulus = $fila_cosecha_globulus[1];
				$activ_cosecha_globulus = $fila_cosecha_globulus[2];
				$meta_cosecha_globulus = $fila_cosecha_globulus[3];
				$hrs_cosecha_globulus = $fila_cosecha_globulus[4];
				$oper_cosecha_globulus = $fila_cosecha_globulus[5];
				$prodreal_cosecha_globulus = $fila_cosecha_globulus[6];
		
				$prodreal_cosecha_globulus = str_replace('.0000','',$prodreal_cosecha_globulus);
				$prodreal_cosecha_globulus = str_replace('.00','',$prodreal_cosecha_globulus);	
				$hrs_cosecha_globulus = str_replace('.00','',$hrs_cosecha_globulus);

				//SELECT IFNULL(SUM(PLANO.PLANO_HORASPROD),0) * IFNULL(MET.MET_UNDXHR,0) AS PROD_ESPERADA,
				$sql = "SELECT IFNULL(SUM(PLANO.PLANO_CANT),0) AS PROD_ESPERADA, 
				IFNULL(SUM(PLANO.PLANO_HORASPROD),0) AS HORAS_PLANIF, ACT.ACTIV_NOMBRE AS ACTIVIDAD, IFNULL(MET.MET_UNDXHR,0) AS META,
				IFNULL(SUM(PLANO.PLANO_HORASPROD),0) AS HORASPROD, SUM(CASE WHEN PLANO.PLANO_ASIST = 'S' THEN 1 ELSE 0 END) AS OPERADORES,
				SUM(IFNULL(PLANO.PLANO_CANT,0)) AS PROD_REAL
				FROM PLANIFICACION_OPER PLANO
				LEFT JOIN METAS AS MET ON MET.ACTIV_ID = PLANO.ACTIV_ID AND PLANO.PLAN_DIA >= MET.MET_INIVIG 
				AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
				JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLANO.ACTIV_ID
				WHERE PLANO.PLAN_DIA = '$rows[PLANM_DIA]' AND PLANO.ACTIV_ID = 241";
				
				$resultset3 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
				$fila_cosecha_gloni = mysqli_fetch_row($resultset3);
				$rowcount_cosecha_gloni = mysqli_num_rows($resultset3);
				
				$cosecha_gloni = $fila_cosecha_gloni[0];
				$jorn_cosecha_gloni = $fila_cosecha_gloni[1];	
				$activ_cosecha_gloni = $fila_cosecha_gloni[2];
				$meta_cosecha_gloni = $fila_cosecha_gloni[3];
				$hrs_cosecha_gloni = $fila_cosecha_gloni[4];
				$oper_cosecha_gloni = $fila_cosecha_gloni[5];
				$prodreal_cosecha_gloni = $fila_cosecha_gloni[6];
		
				
				$prodreal_cosecha_gloni = str_replace('.0000','',$prodreal_cosecha_gloni);
				$prodreal_cosecha_gloni = str_replace('.00','',$prodreal_cosecha_gloni);
	
				$hrs_cosecha_gloni = str_replace('.00','',$hrs_cosecha_gloni);
				
				$sql = "SELECT IFNULL(SUM(PLANO.PLANO_CANT),0) AS PROD_ESPERADA, 
				IFNULL(SUM(PLANO.PLANO_HORASPROD),0) AS HORAS_PLANIF, ACT.ACTIV_NOMBRE AS ACTIVIDAD, IFNULL(MET.MET_UNDXHR,0) AS META,
				IFNULL(SUM(PLANO.PLANO_HORASPROD),0) AS HORASPROD, SUM(CASE WHEN PLANO.PLANO_ASIST = 'S' THEN 1 ELSE 0 END) AS OPERADORES,
				SUM(IFNULL(PLANO.PLANO_CANT,0)) AS PROD_REAL
				FROM PLANIFICACION_OPER PLANO
				LEFT JOIN METAS AS MET ON MET.ACTIV_ID = PLANO.ACTIV_ID AND PLANO.PLAN_DIA >= MET.MET_INIVIG 
				AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
				JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLANO.ACTIV_ID
				WHERE PLANO.PLAN_DIA = '$rows[PLANM_DIA]' AND PLANO.ACTIV_ID = 62";
				
				$resultset4 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
				$fila_cosecha_ramas = mysqli_fetch_row($resultset4);
				$rowcount_cosecha_ramas = mysqli_num_rows($resultset4);
				
				$cosecha_ramas = $fila_cosecha_ramas[0];
				$jorn_cosecha_ramas = $fila_cosecha_ramas[1];	
				$activ_cosecha_ramas = $fila_cosecha_ramas[2];
				$meta_cosecha_ramas = $fila_cosecha_ramas[3];
				$hrs_cosecha_ramas = $fila_cosecha_ramas[4];
				$oper_cosecha_ramas = $fila_cosecha_ramas[5];
				$prodreal_cosecha_ramas = $fila_cosecha_ramas[6];

				$prodreal_cosecha_ramas = str_replace('.0000','',$prodreal_cosecha_ramas);
				$prodreal_cosecha_ramas = str_replace('.00','',$prodreal_cosecha_ramas);
				//--$prodreal_cosecha_ramas = str_replace('.',',',$prodreal_cosecha_ramas);
		
				$hrs_cosecha_ramas = str_replace('.00','',$hrs_cosecha_ramas);
				//--$hrs_cosecha_ramas = str_replace('.',',',$hrs_cosecha_ramas);				

				
				$total_cosecha = $cosecha_globulus + $cosecha_gloni + $cosecha_ramas;	
				$total_prod_cosecha_globulus = ($total_cosecha == 0) ? 0 : round(($cosecha_globulus / $total_cosecha) * $cosecha);
				$total_prod_cosecha_gloni = ($total_cosecha == 0) ? 0 : round(($cosecha_gloni / $total_cosecha) * $cosecha);
				$total_prod_cosecha_ramas = ($total_cosecha == 0) ? 0 : round(($cosecha_ramas / $total_cosecha) * $cosecha);
				
				$total_jornada = $jorn_cosecha_globulus + $jorn_cosecha_gloni + $jorn_cosecha_ramas;				
				$total_jorn_cosecha_globulus = ($total_jornada == 0) ? 0 : round((($jorn_cosecha_globulus / $total_jornada) * $jornada),2);	
				$total_jorn_cosecha_gloni = ($total_jornada == 0) ? 0 : round((($jorn_cosecha_gloni / $total_jornada) * $jornada),2);
				$total_jorn_cosecha_ramas = ($total_jornada == 0) ? 0 : round((($jorn_cosecha_ramas / $total_jornada) * $jornada),2);
			
				if($rowcount_cosecha_globulus == 1)
				{
					$data[] = 
					Array
					(
						'PLAN_DIA' => $rows[PLAN_DIA],
						'PER_AGNO' => $rows[PER_AGNO],
						'PER_MES' => $rows[PER_MES],
						'SEM_NUM' => $rows[SEM_NUM],
						'AREA' => $rows[AREA],
						'SUPERVISOR' => $rows[SUPERVISOR],
						'ACTIVIDAD' => $activ_cosecha_globulus,
						'TIPO_ACTIVIDAD' => $rows[TIPO_ACTIVIDAD],						
						'PROD_ESPERADA' => $total_prod_cosecha_globulus,
						'PROD_REAL' => $prodreal_cosecha_globulus,						
						'UNIDAD' => $rows[UNIDAD],						
						'METAXHR' => $meta_cosecha_globulus,
						'JORN_PLANIFICADAS' => $total_jorn_cosecha_globulus,
						'HRS_PRODUCTIVAS' => $hrs_cosecha_globulus,
						'OPERADORES' => $oper_cosecha_globulus,
						'ACTIVIDAD_PLANIFICADA' => $rows[ACTIVIDAD_PLANIFICADA]
					);				
				}
			
				if($rowcount_cosecha_gloni == 1)
				{
					$data[] = 
					Array
					(
						'PLAN_DIA' => $rows[PLAN_DIA],
						'PER_AGNO' => $rows[PER_AGNO],
						'PER_MES' => $rows[PER_MES],
						'SEM_NUM' => $rows[SEM_NUM],
						'AREA' => $rows[AREA],
						'SUPERVISOR' => $rows[SUPERVISOR],
						'ACTIVIDAD' => $activ_cosecha_gloni,
						'TIPO_ACTIVIDAD' => $rows[TIPO_ACTIVIDAD],						
						'PROD_ESPERADA' => $total_prod_cosecha_gloni,
						'PROD_REAL' => $prodreal_cosecha_gloni,						
						'UNIDAD' => $rows[UNIDAD],						
						'METAXHR' => $meta_cosecha_gloni,
						'JORN_PLANIFICADAS' => $total_jorn_cosecha_gloni,
						'HRS_PRODUCTIVAS' => $hrs_cosecha_gloni,
						'OPERADORES' => $oper_cosecha_gloni,
						'ACTIVIDAD_PLANIFICADA' => $rows[ACTIVIDAD_PLANIFICADA]
					);				
				}
				
				
				if($rowcount_cosecha_ramas == 1)
				{
					$data[] = 
					Array
					(
						'PLAN_DIA' => $rows[PLAN_DIA],
						'PER_AGNO' => $rows[PER_AGNO],
						'PER_MES' => $rows[PER_MES],
						'SEM_NUM' => $rows[SEM_NUM],
						'AREA' => $rows[AREA],
						'SUPERVISOR' => $rows[SUPERVISOR],
						'ACTIVIDAD' => $activ_cosecha_ramas,
						'TIPO_ACTIVIDAD' => $rows[TIPO_ACTIVIDAD],						
						'PROD_ESPERADA' => $total_prod_cosecha_ramas,
						'PROD_REAL' => $prodreal_cosecha_ramas,						
						'UNIDAD' => $rows[UNIDAD],						
						'METAXHR' => $meta_cosecha_ramas,
						'JORN_PLANIFICADAS' => $total_jorn_cosecha_ramas,
						'HRS_PRODUCTIVAS' => $hrs_cosecha_ramas,
						'OPERADORES' => $oper_cosecha_ramas,
						'ACTIVIDAD_PLANIFICADA' => $rows[ACTIVIDAD_PLANIFICADA]
					);				
				}				
				
				
				
				if($rowcount_cosecha_globulus == 0 and $rowcount_cosecha_gloni == 0 and $rowcount_cosecha_ramas == 0)
				{
					$data[] = 
					Array
					(
						'PLAN_DIA' => $rows[PLAN_DIA],
						'PER_AGNO' => $rows[PER_AGNO],
						'PER_MES' => $rows[PER_MES],
						'SEM_NUM' => $rows[SEM_NUM],
						'AREA' => $rows[AREA],
						'SUPERVISOR' => $rows[SUPERVISOR],
						'ACTIVIDAD' => $rows[ACTIVIDAD],
						'TIPO_ACTIVIDAD' => $rows[TIPO_ACTIVIDAD],
						'PROD_ESPERADA' => $prod_esperada,
						'PROD_REAL' => 0,
						'UNIDAD' => $rows[UNIDAD],
						'METAXHR' => $rows[METAXHR],
						'JORN_PLANIFICADAS' => $jorn_planificadas,
						'HRS_PRODUCTIVAS' => $horas_prod,
						'OPERADORES' => $rows[OPERADORES],
						'ACTIVIDAD_PLANIFICADA' => $rows[ACTIVIDAD_PLANIFICADA]
					);				
				}	
				
			}
		

		
		
//////////////////////////////////////////		

			//CONFECCION : 128 / CONFECCION MACRO-ESTACAS cambiado a 121 / CONFECCION MINI-ESTACAS 21/11/2018
			//CONFECCION GLOBULUS: 228
			//CONFECCION GLONI: 227
			
			//INSTALACION : 123
			//INSTALACION GLOBULUS: 432
			//INSTALACION GLONI: 433
		
			
			//elseif($rows[ACTIV_ID] == 128){ //confeccion
			elseif($rows[ACTIV_ID] == 121){ //confeccion
				$existe_activ_confeccion = 1;
				$confeccion = 0;
				$jornada = 0;

				if($prod_esperada <> '-'){					
					$confeccion = $rows[PROD_ESPERADA];
				}

				if($jorn_planificadas <> '-'){					
					$jornada = $rows[JORN_PLANIFICADAS];
				}

				$sql = "SELECT IFNULL(SUM(PLANO.PLANO_CANT),0) AS PROD_ESPERADA, 
				IFNULL(SUM(PLANO.PLANO_HORASPROD),0) AS HORAS_PLANIF, ACT.ACTIV_NOMBRE AS ACTIVIDAD, IFNULL(MET.MET_UNDXHR,0) AS META,
				IFNULL(SUM(PLANO.PLANO_HORASPROD),0) AS HORASPROD, SUM(CASE WHEN PLANO.PLANO_ASIST = 'S' THEN 1 ELSE 0 END) AS OPERADORES,
				SUM(IFNULL(PLANO.PLANO_CANT,0)) AS PROD_REAL
				FROM PLANIFICACION_OPER PLANO
				LEFT JOIN METAS AS MET ON MET.ACTIV_ID = PLANO.ACTIV_ID AND PLANO.PLAN_DIA >= MET.MET_INIVIG 
				AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)
				JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLANO.ACTIV_ID
				WHERE PLANO.PLAN_DIA = '$rows[PLANM_DIA]' AND PLANO.ACTIV_ID = 228";				
				$resultset2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
				$fila_confeccion_globulus = mysqli_fetch_row($resultset2);
				$rowcount_confeccion_globulus = mysqli_num_rows($resultset2);	
				
				$confeccion_globulus = $fila_confeccion_globulus[0];

				$jorn_confeccion_globulus = $fila_confeccion_globulus[1];
				$activ_confeccion_globulus = $fila_confeccion_globulus[2];
				$meta_confeccion_globulus = $fila_confeccion_globulus[3];
				$hrs_confeccion_globulus = $fila_confeccion_globulus[4];
				$oper_confeccion_globulus = $fila_confeccion_globulus[5];
				$prodreal_confeccion_globulus = $fila_confeccion_globulus[6];
			
				$prodreal_confeccion_globulus = str_replace('.0000','',$prodreal_confeccion_globulus);
				$prodreal_confeccion_globulus = str_replace('.00','',$prodreal_confeccion_globulus);
				//--$prodreal_confeccion_globulus = str_replace('.',',',$prodreal_confeccion_globulus);		
				$hrs_confeccion_globulus = str_replace('.00','',$hrs_confeccion_globulus);
				//--$hrs_confeccion_globulus = str_replace('.',',',$hrs_confeccion_globulus);	

				$sql = "SELECT IFNULL(SUM(PLANO.PLANO_CANT),0) AS PROD_ESPERADA, 
				IFNULL(SUM(PLANO.PLANO_HORASPROD),0) AS HORAS_PLANIF, ACT.ACTIV_NOMBRE AS ACTIVIDAD, IFNULL(MET.MET_UNDXHR,0) AS META,
				IFNULL(SUM(PLANO.PLANO_HORASPROD),0) AS HORASPROD, SUM(CASE WHEN PLANO.PLANO_ASIST = 'S' THEN 1 ELSE 0 END) AS OPERADORES,
				SUM(IFNULL(PLANO.PLANO_CANT,0)) AS PROD_REAL
				FROM PLANIFICACION_OPER PLANO
				LEFT JOIN METAS AS MET ON MET.ACTIV_ID = PLANO.ACTIV_ID AND PLANO.PLAN_DIA >= MET.MET_INIVIG 
				AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
				JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLANO.ACTIV_ID
				WHERE PLANO.PLAN_DIA = '$rows[PLANM_DIA]' AND PLANO.ACTIV_ID = 227";
				
				$resultset3 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
				$fila_confeccion_gloni = mysqli_fetch_row($resultset3);
				$rowcount_confeccion_gloni = mysqli_num_rows($resultset3);
				
				$confeccion_gloni = $fila_confeccion_gloni[0];
				$jorn_confeccion_gloni = $fila_confeccion_gloni[1];	
				$activ_confeccion_gloni = $fila_confeccion_gloni[2];
				$meta_confeccion_gloni = $fila_confeccion_gloni[3];
				$hrs_confeccion_gloni = $fila_confeccion_gloni[4];
				$oper_confeccion_gloni = $fila_confeccion_gloni[5];
				$prodreal_confeccion_gloni = $fila_confeccion_gloni[6];

				$prodreal_confeccion_gloni = str_replace('.0000','',$prodreal_confeccion_gloni);
				$prodreal_confeccion_gloni = str_replace('.00','',$prodreal_confeccion_gloni);
				//--$prodreal_confeccion_gloni = str_replace('.',',',$prodreal_confeccion_gloni);
		
				$hrs_confeccion_gloni = str_replace('.00','',$hrs_confeccion_gloni);
				//--$hrs_confeccion_gloni = str_replace('.',',',$hrs_confeccion_gloni);					
				
				$total_confeccion = $confeccion_globulus + $confeccion_gloni;	
				$total_prod_confeccion_globulus = ($total_confeccion == 0) ? 0 : round(($confeccion_globulus / $total_confeccion) * $confeccion);
				$total_prod_confeccion_gloni = ($total_confeccion == 0) ? 0 : round(($confeccion_gloni / $total_confeccion) * $confeccion);
				
				$total_jornada = $jorn_confeccion_globulus + $jorn_confeccion_gloni;				
				$total_jorn_confeccion_globulus = ($total_jornada == 0) ? 0 : round((($jorn_confeccion_globulus / $total_jornada) * $jornada),2);	
				$total_jorn_confeccion_gloni = ($total_jornada == 0) ? 0 : round((($jorn_confeccion_gloni / $total_jornada) * $jornada),2);
			
				if($rowcount_confeccion_globulus == 1)
				{
					$data[] = 
					Array
					(
						'PLAN_DIA' => $rows[PLAN_DIA],
						'PER_AGNO' => $rows[PER_AGNO],
						'PER_MES' => $rows[PER_MES],
						'SEM_NUM' => $rows[SEM_NUM],
						'AREA' => $rows[AREA],
						'SUPERVISOR' => $rows[SUPERVISOR],
						'ACTIVIDAD' => $activ_confeccion_globulus,
						'TIPO_ACTIVIDAD' => $rows[TIPO_ACTIVIDAD],						
						'PROD_ESPERADA' => $total_prod_confeccion_globulus,
						'PROD_REAL' => $prodreal_confeccion_globulus,						
						'UNIDAD' => $rows[UNIDAD],						
						'METAXHR' => $meta_confeccion_globulus,
						'JORN_PLANIFICADAS' => $total_jorn_confeccion_globulus,
						'HRS_PRODUCTIVAS' => $hrs_confeccion_globulus,
						'OPERADORES' => $oper_confeccion_globulus,
						'ACTIVIDAD_PLANIFICADA' => $rows[ACTIVIDAD_PLANIFICADA]
					);				
				}
			
				if($rowcount_confeccion_gloni == 1)
				{
					$data[] = 
					Array
					(
						'PLAN_DIA' => $rows[PLAN_DIA],
						'PER_AGNO' => $rows[PER_AGNO],
						'PER_MES' => $rows[PER_MES],
						'SEM_NUM' => $rows[SEM_NUM],
						'AREA' => $rows[AREA],
						'SUPERVISOR' => $rows[SUPERVISOR],
						'ACTIVIDAD' => $activ_confeccion_gloni,
						'TIPO_ACTIVIDAD' => $rows[TIPO_ACTIVIDAD],						
						'PROD_ESPERADA' => $total_prod_confeccion_gloni,
						'PROD_REAL' => $prodreal_confeccion_gloni,						
						'UNIDAD' => $rows[UNIDAD],						
						'METAXHR' => $meta_confeccion_gloni,
						'JORN_PLANIFICADAS' => $total_jorn_confeccion_gloni,
						'HRS_PRODUCTIVAS' => $hrs_confeccion_gloni,
						'OPERADORES' => $oper_confeccion_gloni,
						'ACTIVIDAD_PLANIFICADA' => $rows[ACTIVIDAD_PLANIFICADA]
					);				
				}
				
				
				if($rowcount_confeccion_globulus == 0 and $rowcount_confeccion_gloni == 0)
				{
					$data[] = 
					Array
					(
						'PLAN_DIA' => $rows[PLAN_DIA],
						'PER_AGNO' => $rows[PER_AGNO],
						'PER_MES' => $rows[PER_MES],
						'SEM_NUM' => $rows[SEM_NUM],
						'AREA' => $rows[AREA],
						'SUPERVISOR' => $rows[SUPERVISOR],
						'ACTIVIDAD' => $rows[ACTIVIDAD],
						'TIPO_ACTIVIDAD' => $rows[TIPO_ACTIVIDAD],
						'PROD_ESPERADA' => $prod_esperada,
						'PROD_REAL' => 0,
						'UNIDAD' => $rows[UNIDAD],
						'METAXHR' => $rows[METAXHR],
						'JORN_PLANIFICADAS' => $jorn_planificadas,
						'HRS_PRODUCTIVAS' => $horas_prod,
						'OPERADORES' => $rows[OPERADORES],
						'ACTIVIDAD_PLANIFICADA' => $rows[ACTIVIDAD_PLANIFICADA]
					);				
				}	
				
			}		
		
		
		
//////////////////////////////////////////		

			//CONFECCION : 128
			//CONFECCION GLOBULUS: 228
			//CONFECCION GLONI: 227
			
			//INSTALACION : 123
			//INSTALACION GLOBULUS: 432
			//INSTALACION GLONI: 433
		
			
			elseif($rows[ACTIV_ID] == 123){ //instalacion
			
				$existe_activ_instalacion = 1;
				$instalacion = 0;
				$jornada = 0;

				if($prod_esperada <> '-'){					
					$instalacion = $rows[PROD_ESPERADA];
				}

				if($jorn_planificadas <> '-'){					
					$jornada = $rows[JORN_PLANIFICADAS];
				}

				$sql = "SELECT IFNULL(SUM(PLANO.PLANO_CANT),0) AS PROD_ESPERADA, 
				IFNULL(SUM(PLANO.PLANO_HORASPROD),0) AS HORAS_PLANIF, ACT.ACTIV_NOMBRE AS ACTIVIDAD, IFNULL(MET.MET_UNDXHR,0) AS META,
				IFNULL(SUM(PLANO.PLANO_HORASPROD),0) AS HORASPROD, SUM(CASE WHEN PLANO.PLANO_ASIST = 'S' THEN 1 ELSE 0 END) AS OPERADORES,
				SUM(IFNULL(PLANO.PLANO_CANT,0)) AS PROD_REAL
				FROM PLANIFICACION_OPER PLANO
				LEFT JOIN METAS AS MET ON MET.ACTIV_ID = PLANO.ACTIV_ID AND PLANO.PLAN_DIA >= MET.MET_INIVIG 
				AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)
				JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLANO.ACTIV_ID
				WHERE PLANO.PLAN_DIA = '$rows[PLANM_DIA]' AND PLANO.ACTIV_ID = 432";				
				$resultset2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
				$fila_instalacion_globulus = mysqli_fetch_row($resultset2);
				$rowcount_instalacion_globulus = mysqli_num_rows($resultset2);	
				
				$instalacion_globulus = $fila_instalacion_globulus[0];

				$jorn_instalacion_globulus = $fila_instalacion_globulus[1];
				$activ_instalacion_globulus = $fila_instalacion_globulus[2];
				$meta_instalacion_globulus = $fila_instalacion_globulus[3];
				$hrs_instalacion_globulus = $fila_instalacion_globulus[4];
				$oper_instalacion_globulus = $fila_instalacion_globulus[5];
				$prodreal_instalacion_globulus = $fila_instalacion_globulus[6];
			
				$prodreal_instalacion_globulus = str_replace('.0000','',$prodreal_instalacion_globulus);
				$prodreal_instalacion_globulus = str_replace('.00','',$prodreal_instalacion_globulus);
				//--$prodreal_instalacion_globulus = str_replace('.',',',$prodreal_instalacion_globulus);		
				$hrs_instalacion_globulus = str_replace('.00','',$hrs_instalacion_globulus);
				//--$hrs_instalacion_globulus = str_replace('.',',',$hrs_instalacion_globulus);	

				$sql = "SELECT IFNULL(SUM(PLANO.PLANO_CANT),0) AS PROD_ESPERADA, 
				IFNULL(SUM(PLANO.PLANO_HORASPROD),0) AS HORAS_PLANIF, ACT.ACTIV_NOMBRE AS ACTIVIDAD, IFNULL(MET.MET_UNDXHR,0) AS META,
				IFNULL(SUM(PLANO.PLANO_HORASPROD),0) AS HORASPROD, SUM(CASE WHEN PLANO.PLANO_ASIST = 'S' THEN 1 ELSE 0 END) AS OPERADORES,
				SUM(IFNULL(PLANO.PLANO_CANT,0)) AS PROD_REAL
				FROM PLANIFICACION_OPER PLANO
				LEFT JOIN METAS AS MET ON MET.ACTIV_ID = PLANO.ACTIV_ID AND PLANO.PLAN_DIA >= MET.MET_INIVIG 
				AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
				JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLANO.ACTIV_ID
				WHERE PLANO.PLAN_DIA = '$rows[PLANM_DIA]' AND PLANO.ACTIV_ID = 433";
				
				$resultset3 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
				$fila_instalacion_gloni = mysqli_fetch_row($resultset3);
				$rowcount_instalacion_gloni = mysqli_num_rows($resultset3);
				
				$instalacion_gloni = $fila_instalacion_gloni[0];
				$jorn_instalacion_gloni = $fila_instalacion_gloni[1];	
				$activ_instalacion_gloni = $fila_instalacion_gloni[2];
				$meta_instalacion_gloni = $fila_instalacion_gloni[3];
				$hrs_instalacion_gloni = $fila_instalacion_gloni[4];
				$oper_instalacion_gloni = $fila_instalacion_gloni[5];
				$prodreal_instalacion_gloni = $fila_instalacion_gloni[6];

				$prodreal_instalacion_gloni = str_replace('.0000','',$prodreal_instalacion_gloni);
				$prodreal_instalacion_gloni = str_replace('.00','',$prodreal_instalacion_gloni);
				//--$prodreal_instalacion_gloni = str_replace('.',',',$prodreal_instalacion_gloni);
		
				$hrs_instalacion_gloni = str_replace('.00','',$hrs_instalacion_gloni);
				//--$hrs_instalacion_gloni = str_replace('.',',',$hrs_instalacion_gloni);					
				
				$total_instalacion = $instalacion_globulus + $instalacion_gloni;	
				$total_prod_instalacion_globulus = ($total_instalacion == 0) ? 0 : round(($instalacion_globulus / $total_instalacion) * $instalacion);
				$total_prod_instalacion_gloni = ($total_instalacion == 0) ? 0 : round(($instalacion_gloni / $total_instalacion) * $instalacion);
				
				$total_jornada = $jorn_instalacion_globulus + $jorn_instalacion_gloni;	
			/*	
				$total_jorn_instalacion_globulus = ($total_jornada == 0) ? 0 : ($jorn_instalacion_globulus / $total_jornada) * $jornada;	
				$total_jorn_instalacion_gloni = ($total_jornada == 0) ? 0 : ($jorn_instalacion_gloni / $total_jornada) * $jornada;				
			*/	
				
				$total_jorn_instalacion_globulus = ($total_jornada == 0) ? 0 : round((($jorn_instalacion_globulus / $total_jornada) * $jornada),2);	
				$total_jorn_instalacion_gloni = ($total_jornada == 0) ? 0 : round((($jorn_instalacion_gloni / $total_jornada) * $jornada),2);
			
				if($rowcount_instalacion_globulus == 1)
				{
					$data[] = 
					Array
					(
						'PLAN_DIA' => $rows[PLAN_DIA],
						'PER_AGNO' => $rows[PER_AGNO],
						'PER_MES' => $rows[PER_MES],
						'SEM_NUM' => $rows[SEM_NUM],
						'AREA' => $rows[AREA],
						'SUPERVISOR' => $rows[SUPERVISOR],
						'ACTIVIDAD' => $activ_instalacion_globulus,
						'TIPO_ACTIVIDAD' => $rows[TIPO_ACTIVIDAD],						
						'PROD_ESPERADA' => $total_prod_instalacion_globulus,
						'PROD_REAL' => $prodreal_instalacion_globulus,						
						'UNIDAD' => $rows[UNIDAD],						
						'METAXHR' => $meta_instalacion_globulus,
						'JORN_PLANIFICADAS' => $total_jorn_instalacion_globulus,
						'HRS_PRODUCTIVAS' => $hrs_instalacion_globulus,
						'OPERADORES' => $oper_instalacion_globulus,
						'ACTIVIDAD_PLANIFICADA' => $rows[ACTIVIDAD_PLANIFICADA]
					);				
				}
			
				if($rowcount_instalacion_gloni == 1)
				{
					$data[] = 
					Array
					(
						'PLAN_DIA' => $rows[PLAN_DIA],
						'PER_AGNO' => $rows[PER_AGNO],
						'PER_MES' => $rows[PER_MES],
						'SEM_NUM' => $rows[SEM_NUM],
						'AREA' => $rows[AREA],
						'SUPERVISOR' => $rows[SUPERVISOR],
						'ACTIVIDAD' => $activ_instalacion_gloni,
						'TIPO_ACTIVIDAD' => $rows[TIPO_ACTIVIDAD],						
						'PROD_ESPERADA' => $total_prod_instalacion_gloni,
						'PROD_REAL' => $prodreal_instalacion_gloni,						
						'UNIDAD' => $rows[UNIDAD],						
						'METAXHR' => $meta_instalacion_gloni,
						'JORN_PLANIFICADAS' => $total_jorn_instalacion_gloni,
						'HRS_PRODUCTIVAS' => $hrs_instalacion_gloni,
						'OPERADORES' => $oper_instalacion_gloni,
						'ACTIVIDAD_PLANIFICADA' => $rows[ACTIVIDAD_PLANIFICADA]
					);				
				}
				
				
				if($rowcount_instalacion_globulus == 0 and $rowcount_instalacion_gloni == 0)
				{
					$data[] = 
					Array
					(
						'PLAN_DIA' => $rows[PLAN_DIA],
						'PER_AGNO' => $rows[PER_AGNO],
						'PER_MES' => $rows[PER_MES],
						'SEM_NUM' => $rows[SEM_NUM],
						'AREA' => $rows[AREA],
						'SUPERVISOR' => $rows[SUPERVISOR],
						'ACTIVIDAD' => $rows[ACTIVIDAD],
						'TIPO_ACTIVIDAD' => $rows[TIPO_ACTIVIDAD],
						'PROD_ESPERADA' => $prod_esperada,
						'PROD_REAL' => 0,
						'UNIDAD' => $rows[UNIDAD],
						'METAXHR' => $rows[METAXHR],
						'JORN_PLANIFICADAS' => $jorn_planificadas,
						'HRS_PRODUCTIVAS' => $horas_prod,
						'OPERADORES' => $rows[OPERADORES],
						'ACTIVIDAD_PLANIFICADA' => $rows[ACTIVIDAD_PLANIFICADA]
					);				
				}	
				
			}		
		
		

			
			else{
				$data[] = 
				Array
				(
					'PLAN_DIA' => $rows[PLAN_DIA],
					'PER_AGNO' => $rows[PER_AGNO],
					'PER_MES' => $rows[PER_MES],
					'SEM_NUM' => $rows[SEM_NUM],
					'AREA' => $rows[AREA],
					'SUPERVISOR' => $rows[SUPERVISOR],
					'ACTIVIDAD' => $rows[ACTIVIDAD],
					'TIPO_ACTIVIDAD' => $rows[TIPO_ACTIVIDAD],
					'PROD_ESPERADA' => $prod_esperada,
					'PROD_REAL' => $prod_real,
					'UNIDAD' => $rows[UNIDAD],
					'METAXHR' => $rows[METAXHR],
					'JORN_PLANIFICADAS' => $jorn_planificadas,
					'HRS_PRODUCTIVAS' => $horas_prod,
					'OPERADORES' => $rows[OPERADORES],
					'ACTIVIDAD_PLANIFICADA' => $rows[ACTIVIDAD_PLANIFICADA]
				);					
			}
			

			//COSECHA: 62
			//COSECHA GLOBULUS: 240
			//COSECHA GLONI: 241
			
			//CONFECCION : 128
			//CONFECCION GLOBULUS: 228
			//CONFECCION GLONI: 227
			
			//INSTALACION : 123
			//INSTALACION GLOBULUS: 432
			//INSTALACION GLONI: 433
				

			if($existe_activ_cosecha == 1 and $existe_activ_confeccion == 1 and $existe_activ_instalacion == 1){
				//$id_actividades = "62, 240, 241, 128, 228, 227, 123, 432, 433";
				$id_actividades = "62, 240, 241, 121, 228, 227, 123, 432, 433";
			}
			elseif($existe_activ_cosecha == 1 and $existe_activ_confeccion == 0 and $existe_activ_instalacion == 1){
				$id_actividades = "62, 240, 241, 123, 432, 433";
			}	
			elseif($existe_activ_cosecha == 0 and $existe_activ_confeccion == 1 and $existe_activ_instalacion == 1){
				//$id_actividades = "128, 228, 227, 123, 432, 433";
				$id_actividades = "121, 228, 227, 123, 432, 433";
			}		
			elseif($existe_activ_cosecha == 0 and $existe_activ_confeccion == 0 and $existe_activ_instalacion == 1){
				$id_actividades = "123, 432, 433";
			}		
			elseif($existe_activ_cosecha == 0 and $existe_activ_confeccion == 1 and $existe_activ_instalacion == 0){
				//$id_actividades = "128, 228, 227";
				$id_actividades = "121, 228, 227";
			}	
			elseif($existe_activ_cosecha == 1 and $existe_activ_confeccion == 0 and $existe_activ_instalacion == 0){
				$id_actividades = "62, 240, 241";
			}		
			elseif($existe_activ_cosecha == 1 and $existe_activ_confeccion == 1 and $existe_activ_instalacion == 0){
				//$id_actividades = "62, 240, 241, 128, 228, 227";
				$id_actividades = "62, 240, 241, 121, 228, 227";
			}			
			else{ //0,0,0
				$id_actividades = "";
			}				
			
			if($id_actividades == ""){
				
				$sql2="
				select 
						DATE_FORMAT(PLAN.PLAN_DIA,'%d-%m-%Y') as PLAN_DIA, SEM.PER_AGNO, SEM.PER_MES, SEM.SEM_NUM, AREA.AREA_NOMBRE AS AREA, 
						CONCAT(SUP.SUP_NOMBRES,' ',SUP.SUP_PATERNO,' ',SUP.SUP_MATERNO) AS SUPERVISOR,			
						ACTIV.ACTIV_NOMBRE AS ACTIVIDAD, ACTIV.ACTIV_TIPO AS TIPO_ACTIVIDAD,
						
						'' AS PROD_ESPERADA,	
						
						SUM(PLANO.PLANO_CANT) AS PROD_REAL, 
						
						IFNULL(UND.UND_NOMBRE,'') AS UNIDAD,			
						IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),0) AS METAXHR,			
						'' AS JORN_PLANIFICADAS,			
						
						SUM(CASE WHEN PLANO.PLANO_ASIST = 'S' THEN PLANO.PLANO_HORASPROD ELSE 0 END) AS HRS_PRODUCTIVAS, 
						
						SUM(CASE WHEN PLANO.PLANO_ASIST = 'S' THEN 1 ELSE 0 END) AS OPERADORES, 			
						'N' AS ACTIVIDAD_PLANIFICADA	
							
						FROM PLANIFICACION AS PLAN 
						JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
						JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
						JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
						JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = PLAN.SUP_RUT
						JOIN SEMANAS AS SEM ON SEM.PER_AGNO = PLAN.PER_AGNO AND SEM.SEM_NUM = PLAN.SEM_NUM
						LEFT JOIN UNIDAD AS UND ON UND.UND_ID = ACTIV.UND_ID 
						LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
						AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
						LEFT JOIN PLAN_MAESTRO PLANM ON PLANO.PLAN_DIA = PLANM.PLANM_DIA AND PLANO.ACTIV_ID = PLANM.ACTIV_ID
						WHERE PLANM.ACTIV_ID IS NULL AND 
						/*(SEM.PER_AGNO = $rows[PER_AGNO]) AND
						(SEM.PER_MES = $rows[PER_MES]) AND
						(SEM.SEM_NUM = $rows[SEM_NUM]) AND*/
						(PLAN.PLAN_DIA = '$rows[PLAN_DIA]')/* AND
						(AREA.AREA_ID = $rows[AREA]) AND
						(SUP.SUP_RUT = '$rows[SUPERVISOR]')*/
						GROUP BY PLAN.PLAN_DIA, SEM.PER_AGNO, SEM.PER_MES, SEM.SEM_NUM, AREA.AREA_NOMBRE, ACTIV.ACTIV_NOMBRE, ACTIV.ACTIV_TIPO, MET.MET_UNDXHR,UND.UND_NOMBRE	       
				";		

				
								
			}else{
				$sql2="
				select 
						DATE_FORMAT(PLAN.PLAN_DIA,'%d-%m-%Y') as PLAN_DIA, SEM.PER_AGNO, SEM.PER_MES, SEM.SEM_NUM, AREA.AREA_NOMBRE AS AREA, 
						CONCAT(SUP.SUP_NOMBRES,' ',SUP.SUP_PATERNO,' ',SUP.SUP_MATERNO) AS SUPERVISOR,			
						ACTIV.ACTIV_NOMBRE AS ACTIVIDAD, ACTIV.ACTIV_TIPO AS TIPO_ACTIVIDAD,
						
						'' AS PROD_ESPERADA,	
						
						SUM(PLANO.PLANO_CANT) AS PROD_REAL, 
						
						IFNULL(UND.UND_NOMBRE,'') AS UNIDAD,			
						IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),0) AS METAXHR,			
						'' AS JORN_PLANIFICADAS,			
						
						SUM(CASE WHEN PLANO.PLANO_ASIST = 'S' THEN PLANO.PLANO_HORASPROD ELSE 0 END) AS HRS_PRODUCTIVAS, 
						
						SUM(CASE WHEN PLANO.PLANO_ASIST = 'S' THEN 1 ELSE 0 END) AS OPERADORES, 			
						'N' AS ACTIVIDAD_PLANIFICADA	
							
						FROM PLANIFICACION AS PLAN 
						JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
						JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
						JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
						JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = PLAN.SUP_RUT
						JOIN SEMANAS AS SEM ON SEM.PER_AGNO = PLAN.PER_AGNO AND SEM.SEM_NUM = PLAN.SEM_NUM
						LEFT JOIN UNIDAD AS UND ON UND.UND_ID = ACTIV.UND_ID 
						LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
						AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
						LEFT JOIN PLAN_MAESTRO PLANM ON PLANO.PLAN_DIA = PLANM.PLANM_DIA AND PLANO.ACTIV_ID = PLANM.ACTIV_ID
						WHERE PLANM.ACTIV_ID IS NULL AND ACTIV.ACTIV_ID NOT IN (".$id_actividades.") AND
						/*(SEM.PER_AGNO = $rows[PER_AGNO]) AND
						(SEM.PER_MES = $rows[PER_MES]) AND
						(SEM.SEM_NUM = $rows[SEM_NUM]) AND*/
						(PLAN.PLAN_DIA = '$rows[PLAN_DIA]')/* AND
						(AREA.AREA_ID = $rows[AREA]) AND
						(SUP.SUP_RUT = '$rows[SUPERVISOR]')*/
						GROUP BY PLAN.PLAN_DIA, SEM.PER_AGNO, SEM.PER_MES, SEM.SEM_NUM, AREA.AREA_NOMBRE, ACTIV.ACTIV_NOMBRE, ACTIV.ACTIV_TIPO, MET.MET_UNDXHR,UND.UND_NOMBRE	       
				";			
								
			}	

		
			$resultado = mysqli_query($link, $sql2) or die("database error:". mysqli_error($link));
			
			while( $rows = mysqli_fetch_assoc($resultado) ) {

				$prod_esperada = '-';
				$jorn_planificadas = '-';
				$prod_real = '-';
				$horas_prod = '-';
			
				if($rows[PROD_ESPERADA] <> '0' and $rows[PROD_ESPERADA] <> ''){
					$prod_esperada = round($rows[PROD_ESPERADA]);
				}

				if($rows[PROD_REAL] <> '0' and $rows[PROD_REAL] <> ''){
					$prod_real = str_replace('.00','',$rows[PROD_REAL]);
				}	
				
				if($rows[HRS_PRODUCTIVAS] <> '0' and $rows[HRS_PRODUCTIVAS] <> ''){
					$horas_prod = str_replace('.00','',$rows[HRS_PRODUCTIVAS]);
				}			
				
				$data[] = 
				Array
				(
					'PLAN_DIA' => $rows[PLAN_DIA],
					'PER_AGNO' => $rows[PER_AGNO],
					'PER_MES' => $rows[PER_MES],
					'SEM_NUM' => $rows[SEM_NUM],
					'AREA' => $rows[AREA],
					'SUPERVISOR' => $rows[SUPERVISOR],
					'ACTIVIDAD' => $rows[ACTIVIDAD],
					'TIPO_ACTIVIDAD' => $rows[TIPO_ACTIVIDAD],
					'PROD_ESPERADA' => $prod_esperada,
					'PROD_REAL' => $prod_real,
					'UNIDAD' => $rows[UNIDAD],
					'METAXHR' => $rows[METAXHR],
					'JORN_PLANIFICADAS' => $jorn_planificadas,
					'HRS_PRODUCTIVAS' => $horas_prod,
					'OPERADORES' => $rows[OPERADORES],
					'ACTIVIDAD_PLANIFICADA' => $rows[ACTIVIDAD_PLANIFICADA]
				);					
				
			}			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		}	



		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);
		
		echo json_encode($resp);
			
	}
		

?>