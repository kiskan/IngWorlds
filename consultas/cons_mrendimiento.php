<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
/*	
	$_POST['per_agno'] = 2017;
	$_POST['per_mes'] = 5;
	$_POST['sem_num'] = 30;
*/	
	if(isset($_POST['per_agno'])){

		$per_agno = $_POST['per_agno'];
		$per_mes = $_POST['per_mes'];
		$sem_num = $_POST['sem_num'];
		
		//$rows[CANT]/$rows[HR_PROD]
		/*$sql = "SELECT PLANO.OPER_RUT AS CANT_OPERADOR,CONCAT(SUBSTRING_INDEX(OPER_NOMBRES, ' ', 1),' ',O.OPER_PATERNO) AS OPERADOR, 
		100*AVG(PLANO.PLANO_CANT/PLANO.PLANO_HORASPROD) AS MEDIA, ACTIV.ACTIV_NOMBRE
		FROM PLANIFICACION AS PLAN 
		JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
		JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
		JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
		JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
		JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
		WHERE SEM.SEM_NUM =".$sem_num." AND SEM.PER_AGNO =".$per_agno." 
		AND PLANO.PLANO_CANT <> 0 AND PLANO.PLANO_HORASPROD <> 0
		GROUP BY PLANO.OPER_RUT, OPERADOR, ACTIV.ACTIV_NOMBRE
		ORDER BY MEDIA DESC"		
		*/
		
		
		
		
		
		
		
	
		$sql_horasprod = "SELECT ACTIV.ACTIV_ID,
		ACTIV.ACTIV_NOMBRE AS ACTIVIDAD,SUM(PLANO.PLANO_HORASPROD) AS HORAS_PROD		 
		FROM PLANIFICACION AS PLAN 
		JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
		JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
		JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
		JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
		JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
		JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
		AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
		WHERE SEM.SEM_NUM =".$sem_num." AND SEM.PER_AGNO =".$per_agno." 
		GROUP BY ACTIV.ACTIV_NOMBRE
		ORDER BY HORAS_PROD DESC
		LIMIT 6
		";

		$ids_actividad = '';$k = 0;
		$horas = array();
		$ids_actividad_array = array();
		$resultado = mysqli_query($link, $sql_horasprod) or die("database error:". mysqli_error($link));  
		while( $rows = mysqli_fetch_assoc($resultado) ) {
			$horas[] = $rows[HORAS_PROD];
			if($k == 0) {
				$ids_actividad = $rows[ACTIV_ID];
			}else{
				$ids_actividad = $ids_actividad.','.$rows[ACTIV_ID];
			}
			$ids_actividad_array[$k] = $rows[ACTIV_ID];
			$k++;
		}

		$sum_horas = 0;
		$rowcount = 0;
		$resp = array('cod'=>'error','desc'=>'No existen horas de producción');
		if(count($horas) <> 0 and array_sum($horas) > 0 ){
			$sum_horas = array_sum($horas);
			
			$sql_horasprod2 = "SELECT ACTIV.ACTIV_ID,
			ACTIV.ACTIV_NOMBRE AS ACTIVIDAD,SUM(PLANO.PLANO_HORASPROD) AS HORAS_PROD		 
			FROM PLANIFICACION AS PLAN	
			JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
			JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
			JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
			JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
			JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
			JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
			AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
			WHERE SEM.SEM_NUM =".$sem_num." AND SEM.PER_AGNO =".$per_agno." 
			AND ACTIV.ACTIV_ID IN ($ids_actividad)
			GROUP BY ACTIV.ACTIV_NOMBRE
			ORDER BY HORAS_PROD DESC
			";		
				
			$resultado = mysqli_query($link, $sql_horasprod2) or die("database error:". mysqli_error($link));
			$rowcount = mysqli_num_rows($resultado);
			$i = 0;
			while( $rows = mysqli_fetch_assoc($resultado) ) {

				$rend_prom[$i][0] = $rows[ACTIVIDAD];
				$rend_prom[$i][1] = 100 * ($rows[HORAS_PROD]/$sum_horas);
				$i++;
			}
			
			$j = 0;
			while(count($ids_actividad_array) > $j){
				$activ = $ids_actividad_array[$j];
				$sql_horasprod3 = "SELECT PLANO.PLANO_CANT/PLANO.PLANO_HORASPROD/MET.MET_UNDXHR AS MEDIA		 
				FROM PLANIFICACION AS PLAN 
				JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
				JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
				JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
				JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
				JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
				JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
				AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
				WHERE SEM.SEM_NUM =".$sem_num." AND SEM.PER_AGNO =".$per_agno." 
				AND ACTIV.ACTIV_ID = $activ
				AND PLANO.PLANO_CANT <> 0 AND PLANO.PLANO_HORASPROD <> 0 AND MET.MET_UNDXHR <> 0
				";	
				//print_r($sql_horasprod3);
				//echo '<br><br>';
				
			
				$media_activ = array();
				$resultado = mysqli_query($link, $sql_horasprod3) or die("database error:". mysqli_error($link));  
				while( $rows = mysqli_fetch_assoc($resultado) ) {
					$media_activ[] = $rows[MEDIA];
				}	
				
				//$cant_operador[$j] = count($media_activ);
				
				//print_r($media_activ);
				//echo '<br><br>';			
				$media_= 0;
				if(count($media_activ) <> 0){
					$media_ = 100*(array_sum($media_activ)/count($media_activ));
				}			
				$media_actividad_array[$j] = $media_;
				unset($media_activ);
				
				//print_r($media_);
				//echo '<br><br>';	
				//SUM(100*(PLANO.PLANO_CANT/PLANO.PLANO_HORASPROD/MET.MET_UNDXHR)) AS MEDIA
				$sql_horasprod4 = "SELECT PLANO.OPER_RUT AS CANT_OPERADOR, 100*AVG(PLANO.PLANO_CANT/PLANO.PLANO_HORASPROD/MET.MET_UNDXHR) AS MEDIA	 
				FROM PLANIFICACION AS PLAN 
				JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
				JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
				JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
				JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
				JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
				JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
				AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
				WHERE SEM.SEM_NUM =".$sem_num." AND SEM.PER_AGNO =".$per_agno." 
				AND ACTIV.ACTIV_ID = $activ
				AND PLANO.PLANO_CANT <> 0 AND PLANO.PLANO_HORASPROD <> 0 AND MET.MET_UNDXHR <> 0
				GROUP BY PLANO.OPER_RUT
				HAVING SUM(PLANO.PLANO_HORASPROD) >= 5
				";
				//print_r($sql_horasprod4);
				//echo '<br><br>';
				$resultado = mysqli_query($link, $sql_horasprod4) or die("database error:". mysqli_error($link));			
				$cant_operador[$j] = mysqli_num_rows($resultado);

				$esperado = 0;$aceptable = 0;$trabajar = 0;$replantear = 0;
				while( $rows = mysqli_fetch_assoc($resultado) ) {	
					
					if($rows[MEDIA] >= 80){
						$esperado++;
					}
					if($rows[MEDIA] >= 70 and $rows[MEDIA] < 80){
						$aceptable++;
					}	
					if($rows[MEDIA] >= 50 and $rows[MEDIA] < 70){
						$trabajar++;
					}	
					if($rows[MEDIA] < 50){
						$replantear++;
					}				
				}
				
				$m_esperado[$j] = 100 * ($esperado/$cant_operador[$j]);$m_aceptable[$j] = 100 * ($aceptable/$cant_operador[$j]);
				$m_trabajar[$j] = 100 * ($trabajar/$cant_operador[$j]);$m_replantear[$j] = 100 * ($replantear/$cant_operador[$j]);

	/*
				$a = $cant_operador[$j].':'.$m_esperado[$j].'-'.$m_aceptable[$j].'-'.$m_trabajar[$j].'-'.$m_replantear[$j];
				print_r($a);
				echo '<br><br>';
	*/			


				$sql_horasprod5 = "SELECT PLANO.OPER_RUT AS CANT_OPERADOR,CONCAT(SUBSTRING_INDEX(OPER_NOMBRES, ' ', 1),' ',O.OPER_PATERNO) AS OPERADOR, 
				100*AVG(PLANO.PLANO_CANT/PLANO.PLANO_HORASPROD/MET.MET_UNDXHR) AS MEDIA
				FROM PLANIFICACION AS PLAN 
				JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
				JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
				JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
				JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
				JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
				JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
				AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
				WHERE SEM.SEM_NUM =".$sem_num." AND SEM.PER_AGNO =".$per_agno." 
				AND ACTIV.ACTIV_ID = $activ
				AND PLANO.PLANO_CANT <> 0 AND PLANO.PLANO_HORASPROD <> 0 AND MET.MET_UNDXHR <> 0
				GROUP BY PLANO.OPER_RUT, OPERADOR
				ORDER BY MEDIA DESC
				";
				$resultado = mysqli_query($link, $sql_horasprod5) or die("database error:". mysqli_error($link));			
				$total_operadores = mysqli_num_rows($resultado);
				
				$i = 0;
				$res_oper = $total_operadores - 5;
				$k = 0;$m = 0;$n = 0;
				while( $rows = mysqli_fetch_assoc($resultado) ) {
					
					if($rows[MEDIA] > 80){
						$m++;
					}
					
					if($rows[MEDIA] < 50){
						$n++;
					}	
					
					if($res_oper <= 0 ) {
						$operadores_top[$j][$i] = $rows[OPERADOR].'->'.$rows[MEDIA];
						$i++;
					}elseif($res_oper <= 5 ) {
						if($i < 5){
							$operadores_top[$j][$i] = $rows[OPERADOR].'->'.$rows[MEDIA];
						}else{
							$operadores_bottom[$j][$k] = $rows[OPERADOR].'->'.$rows[MEDIA];
							$k++;
						}
						$i++;					
					}elseif($res_oper > 5 ) {
						if($i < 5){
							$operadores_top[$j][$i] = $rows[OPERADOR].'->'.$rows[MEDIA];
						}elseif($i >= $res_oper){
							$operadores_bottom[$j][$k] = $rows[OPERADOR].'->'.$rows[MEDIA];
							$k++;
						}
						$i++;					
					}
				}
				
				$operadores_80[$j] = $m;$operadores_50[$j] = $n;

				/*
				print_r($sql_horasprod5);
				echo '<br><br>';			
				*/
	/*
				print_r($operadores_top[$j]);
				echo '<br><br>';
				print_r($operadores_bottom[$j]);
				echo '<br><br>';
	*/


				$j++;
			}
			
			$resp = array('cod'=>'ok','operadores_top'=>$operadores_top,'operadores_bottom'=>$operadores_bottom
			,'operadores_80'=>$operadores_80,'operadores_50'=>$operadores_50,'rowcount'=>$rowcount,'actividad'=>$rend_prom);
		}	

		
			
	salida($resp);
			
	}
		

?>