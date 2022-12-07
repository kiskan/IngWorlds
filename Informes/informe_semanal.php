<?php  

if(empty($_GET['per_agno']) or empty($_GET['per_mes']) or empty($_GET['sem_num'])){
	echo 'Error: Ausencia de período de búsqueda';
	exit;
}
else{

	$per_agno = $_GET['per_agno'];
	$per_mes = $_GET['per_mes'];
	$sem_num = $_GET['sem_num'];

	include('../consultas/coneccion.php');

if(isset($_GET['clave']) ){
	
	if($_GET['clave'] == '6SkLqV4GlSgig4jr9XtF'){
		$sqlfechainf = "SELECT SEM_FECHAINI, SEM_FECHAFIN, 
		DATE_FORMAT(SEM_FECHAINI,'%d/%m/%Y') as SEM_FECHAINI_INF_PRINT, DATE_FORMAT(SEM_FECHAFIN,'%d/%m/%Y') as SEM_FECHAFIN_INF_PRINT 
		FROM SEMANAS WHERE PER_AGNO = $per_agno AND SEM_NUM = $sem_num";
		$resultado = mysqli_query($link, $sqlfechainf) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$SEM_FECHAINI_INF = $fila[0];$SEM_FECHAFIN_INF = $fila[1];$SEM_FECHAINI_INF_PRINT = $fila[2];$SEM_FECHAFIN_INF_PRINT = $fila[3];			
	}else{
		header('Location:../login.php');
	}
	
	
}else{
	
	if($sem_num == -1){
		$ultimo_dia = date('t',mktime(0,0,0,$per_mes,1,$per_agno));
		$SEM_FECHAINI_INF = $per_agno.$per_mes.'01';
		$SEM_FECHAFIN_INF = $per_agno.$per_mes.$ultimo_dia;
		$SEM_FECHAINI_INF_PRINT = '01/'.$per_mes.'/'.$per_agno;
		$SEM_FECHAFIN_INF_PRINT = $ultimo_dia.'/'.$per_mes.'/'.$per_agno;		
	}
	else{
	
		$sqlfechainf = "SELECT SEM_FECHAINI_INF, SEM_FECHAFIN_INF, 
		DATE_FORMAT(SEM_FECHAINI_INF,'%d/%m/%Y') as SEM_FECHAINI_INF_PRINT, DATE_FORMAT(SEM_FECHAFIN_INF,'%d/%m/%Y') as SEM_FECHAFIN_INF_PRINT 
		FROM SEMANAS WHERE PER_AGNO = $per_agno AND SEM_NUM = $sem_num";
		$resultado = mysqli_query($link, $sqlfechainf) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$SEM_FECHAINI_INF = $fila[0];$SEM_FECHAFIN_INF = $fila[1];$SEM_FECHAINI_INF_PRINT = $fila[2];$SEM_FECHAFIN_INF_PRINT = $fila[3];	
	}
}	
	

	$sql_encargado1 = "SELECT CONCAT(O.OPER_NOMBRES,' ',O.OPER_PATERNO) AS OPERADOR, 
	ACTIV.ACTIV_NOMBRE AS ACTIVIDAD,PLANO.PLANO_CANT/PLANO.PLANO_HORASPROD/MET.MET_UNDXHR AS MEDIA		 
	FROM PLANIFICACION AS PLAN 
	JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
	JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
	JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
	JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
	JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
	AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
	WHERE 
	PLAN.PLAN_DIA >= '$SEM_FECHAINI_INF' AND PLAN.PLAN_DIA <= '$SEM_FECHAFIN_INF'
	AND AREA.AREA_ID IN (1,2,3,5,7,8,13)
	AND PLANO.PLANO_CANT <> 0 AND PLANO.PLANO_HORASPROD <> 0 AND MET.MET_UNDXHR <> 0
	";
/*	
	echo '<pre>';
	print_r($sql_encargado1);
	echo '</pre>';
*/
	$data = array();
	$media = array();
	$resultado = mysqli_query($link, $sql_encargado1) or die("database error:". mysqli_error($link));  
	while( $rows = mysqli_fetch_assoc($resultado) ) {
		$data[] = $rows;
		$media[] = $rows[MEDIA];
	}
	/*
	echo '<pre>';
	//print_r($data);
	print_r($media);
	echo '</pre>';
	*/
	$media_enc1= 0;
	if(count($media) <> 0){
		$media_enc1 = 100*(array_sum($media)/count($media));
	}
	
	$sql_encargado2 = "SELECT CONCAT(O.OPER_NOMBRES,' ',O.OPER_PATERNO) AS OPERADOR, 
	ACTIV.ACTIV_NOMBRE AS ACTIVIDAD,PLANO.PLANO_CANT/PLANO.PLANO_HORASPROD/MET.MET_UNDXHR AS MEDIA		 
	FROM PLANIFICACION AS PLAN 
	JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
	JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
	JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
	JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
	JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
	AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
	WHERE 
	PLAN.PLAN_DIA >= '$SEM_FECHAINI_INF' AND PLAN.PLAN_DIA <= '$SEM_FECHAFIN_INF'
	AND AREA.AREA_ID IN (4,6,9,10,11,12)
	AND PLANO.PLANO_CANT <> 0 AND PLANO.PLANO_HORASPROD <> 0 AND MET.MET_UNDXHR <> 0
	";

	$media2 = array();
	$resultado2 = mysqli_query($link, $sql_encargado2) or die("database error:". mysqli_error($link));  
	while( $rows = mysqli_fetch_assoc($resultado2) ) {
		$data[] = $rows;
		$media2[] = $rows[MEDIA];
		$media[] = $rows[MEDIA];
	}

	$media_enc2= 0;
	if(count($media2) <> 0){
		$media_enc2 = 100*(array_sum($media2)/count($media2));
	}
	
	$media_enc= 0;
	if(count($media) <> 0){
		$media_enc = array_sum($media)/count($media);
	}
	
	$promedio = $media_enc*100;
	


	$sql_horasprod = "SELECT ACTIV.ACTIV_ID,
	ACTIV.ACTIV_NOMBRE AS ACTIVIDAD,SUM(PLANO.PLANO_HORASPROD) AS HORAS_PROD		 
	FROM PLANIFICACION AS PLAN 
	JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
	JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
	JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
	JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
	JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
	AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
	WHERE 
	PLAN.PLAN_DIA >= '$SEM_FECHAINI_INF' AND PLAN.PLAN_DIA <= '$SEM_FECHAFIN_INF'
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
	if(count($horas) <> 0 and array_sum($horas) > 0 ){
		$sum_horas = array_sum($horas);
		
		$sql_horasprod2 = "SELECT ACTIV.ACTIV_ID,
		ACTIV.ACTIV_NOMBRE AS ACTIVIDAD,SUM(PLANO.PLANO_HORASPROD) AS HORAS_PROD		 
		FROM PLANIFICACION AS PLAN	
		JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
		JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
		JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
		JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
		JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
		AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
		WHERE 
		PLAN.PLAN_DIA >= '$SEM_FECHAINI_INF' AND PLAN.PLAN_DIA <= '$SEM_FECHAFIN_INF'
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
			JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
			JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
			JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
			JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
			JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
			AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
			WHERE 
			PLAN.PLAN_DIA >= '$SEM_FECHAINI_INF' AND PLAN.PLAN_DIA <= '$SEM_FECHAFIN_INF'
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
			JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
			JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
			JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
			JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
			JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
			AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
			WHERE 
			PLAN.PLAN_DIA >= '$SEM_FECHAINI_INF' AND PLAN.PLAN_DIA <= '$SEM_FECHAFIN_INF'
			AND ACTIV.ACTIV_ID = $activ
			AND PLANO.PLANO_ASIST = 'S' AND PLANO.PLANO_CANT <> 0 AND PLANO.PLANO_HORASPROD <> 0 AND MET.MET_UNDXHR <> 0
			GROUP BY PLANO.OPER_RUT
			HAVING SUM(PLANO.PLANO_HORASPROD) >= 5
			";
			//print_r($sql_horasprod4);
			//echo '<br><br>';
			$resultado = mysqli_query($link, $sql_horasprod4) or die("database error:". mysqli_error($link));			
			$cant_operador[$j] = mysqli_num_rows($resultado);
			
			$cant_operador_inicial[$j] = $cant_operador[$j];
			
			if($cant_operador[$j] > 0){
				/*
				$fila = mysqli_fetch_row($resultado);
				$PLAN_DIA = $fila[0];
				//echo '<br><br><br>PLAN_DIA:'.$PLAN_DIA.'<br><br><br><br>';
				
				$sql_replan = "SELECT COUNT(*) AS CANT_OPER_INICIAL
				FROM PLANIFICACION AS PLAN 
				JOIN REPLANIFICACION AS REPLAN ON PLAN.PLAN_DIA = REPLAN.PLAN_DIA AND PLAN.ACTIV_ID = REPLAN.ACTIV_ID  
				JOIN HREPLANIFICACION_OPER AS HREPLAN ON HREPLAN.RPLAN_ID = REPLAN.RPLAN_ID
				WHERE PLAN.PLAN_DIA = '$PLAN_DIA' AND PLAN.ACTIV_ID = $activ AND REPLAN.RPLAN_ID = (
					SELECT MIN(RPLAN_ID) FROM REPLANIFICACION WHERE PLAN_DIA = '$PLAN_DIA' AND ACTIV_ID = $activ
				)
				";*/
				
				
				$sql_replan = "SELECT COUNT(distinct HRPLANO_OPER) AS CANT_OPER_INICIAL
				FROM PLANIFICACION AS PLAN 
				JOIN REPLANIFICACION AS REPLAN ON PLAN.PLAN_DIA = REPLAN.PLAN_DIA AND PLAN.ACTIV_ID = REPLAN.ACTIV_ID  
				JOIN HREPLANIFICACION_OPER AS HREPLAN ON HREPLAN.RPLAN_ID = REPLAN.RPLAN_ID
				WHERE PLAN.PLAN_DIA >= '$SEM_FECHAINI_INF' AND PLAN.PLAN_DIA <= '$SEM_FECHAFIN_INF'
				AND PLAN.ACTIV_ID = $activ AND REPLAN.RPLAN_ID = (
					SELECT MIN(RPLAN_ID) FROM REPLANIFICACION WHERE PLAN_DIA = PLAN.PLAN_DIA AND ACTIV_ID = $activ
				)
				";				
				$resultado = mysqli_query($link, $sql_replan) or die("database error:". mysqli_error($link));
				$fila = mysqli_fetch_row($resultado);
				$CANT_OPER_INICIAL = $fila[0];
				if($CANT_OPER_INICIAL > 0){
					$cant_operador_inicial[$j] = $CANT_OPER_INICIAL;
				}
				
				//echo '<br>cant_operador_inicial:'.$cant_operador_inicial[$j].'<br>';
				//echo '<br>PLAN_DIA:'.$PLAN_DIA.'<br>';
				//echo '<br>activ:'.$activ.'<br><br><br>';
			}
			
			$resultado = mysqli_query($link, $sql_horasprod4) or die("database error:". mysqli_error($link));
			$esperado = 0;$aceptable = 0;$trabajar = 0;$replantear = 0;
			while( $rows = mysqli_fetch_assoc($resultado) ) {
				/*$res_media = $rows[MEDIA]/$cant_operador[$j];
				
				if($res_media >= 80){
					$esperado++;
				}
				if($res_media >= 70 and $res_media < 80){
					$aceptable++;
				}	
				if($res_media >= 50 and $res_media < 70){
					$trabajar++;
				}	
				if($res_media < 50){
					$replantear++;
				}	*/		
				
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
			
			//$m_esperado[$j] = 100 * ($esperado/$cant_operador[$j]);$m_aceptable[$j] = 100 * ($aceptable/$cant_operador[$j]);
			//$m_trabajar[$j] = 100 * ($trabajar/$cant_operador[$j]);$m_replantear[$j] = 100 * ($replantear/$cant_operador[$j]);

			if($cant_operador[$j] > 0){
				$m_esperado[$j] = 100 * ($esperado/$cant_operador[$j]);$m_aceptable[$j] = 100 * ($aceptable/$cant_operador[$j]);
				$m_trabajar[$j] = 100 * ($trabajar/$cant_operador[$j]);$m_replantear[$j] = 100 * ($replantear/$cant_operador[$j]);
			}else{
				$m_esperado[$j] = 0;$m_aceptable[$j] = 0;
				$m_trabajar[$j] = 0;$m_replantear[$j] = 0;			
			}			
			
			//$m_esperado[$j] = $esperado;$m_aceptable[$j] = $aceptable;$m_trabajar[$j] = $trabajar;$m_replantear[$j] = $replantear;			
			
/*
			$a = $cant_operador[$j].':'.$m_esperado[$j].'-'.$m_aceptable[$j].'-'.$m_trabajar[$j].'-'.$m_replantear[$j];
			print_r($a);
			echo '<br><br>';
*/			


			$sql_horasprod5 = "SELECT PLANO.OPER_RUT AS CANT_OPERADOR,CONCAT(SUBSTRING_INDEX(OPER_NOMBRES, ' ', 1),' ',O.OPER_PATERNO) AS OPERADOR, 
			100*AVG(PLANO.PLANO_CANT/PLANO.PLANO_HORASPROD/MET.MET_UNDXHR) AS MEDIA
			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
			JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
			JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
			JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
			JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
			AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)		
			WHERE 
			PLAN.PLAN_DIA >= '$SEM_FECHAINI_INF' AND PLAN.PLAN_DIA <= '$SEM_FECHAFIN_INF'
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
		
		
	}	
}
?> 


<!DOCTYPE html>
<html lang="en">
  <head>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">	
	
    <title>Ings-Sisconvi-Production | Ings-Worlds</title>
	<script type="text/javascript" src="fusioncharts.js"></script>
	
	<script type="text/javascript" src="fusioncharts.charts.js"></script>
	
	<script type="text/javascript" src="fusioncharts.theme.fint.js"></script>

	
	<script type="text/javascript">
	FusionCharts.ready(function(){
		var fusioncharts = new FusionCharts({
		type: 'angulargauge',
		renderAt: 'chart-container',
		width: '400',
		height: '250',	
		dataFormat: 'json',
		dataSource: {
			"chart": {
				"caption": "PRODUCCION",
				"subcaption": "Sotrosur",
				//"plotToolText": "Current Score: $value",
				"theme": "fint",
				//"chartBottomMargin": "50",
				"showValue": "1",
                "valueBelowPivot": "1",
				"numberSuffix": "%",
                //"tickValueDecimals": "1",
                //"forceTickValueDecimals": "1",
                //"gaugeFillMix": "{dark-40},{light-40},{dark-20}" 				

                "gaugeFillMix": "{dark-30},{light-60},{dark-10}",
                "gaugeFillRatio": "15",
                "chartBottomMargin": "25",
                "valueFontSize": "12",
                //"valueFontColor": "#ffffff"				
				
				
				
			},
			"colorRange": {
				"color": [{
					"minValue": "0",
					"maxValue": "50",
					"code": "#e44a00"
				},{
					"minValue": "50",
					"maxValue": "70",
					"code": "#FFA500"
				},{
					"minValue": "70",
					"maxValue": "80",
					"code": "#FFFF00"
				}, 		
				{
					"minValue": "80",
					"maxValue": "100",
					"code": "#6baa01"
				}]
			},
			"dials": {
				"dial": [{
					"value": <?php echo $promedio; ?>
					//"value": "80.9" //VALOR ACTUALIZABLE
				}]
			}
		}
		});
		fusioncharts.render();
	});
	
	FusionCharts.ready(function(){
		var fusioncharts = new FusionCharts({
		type: 'angulargauge',
		renderAt: 'chart-container2',
		width: '400',
		height: '250',	
		dataFormat: 'json',
		dataSource: {
			"chart": {
				"caption": "ENCARGADO",
				"subcaption": "Crecimiento, Plantas Madres, Enraizamiento, Confección, Instalación, Edificio Producción y Crecimiento Evalfor",
				//"plotToolText": "Current Score: $value",
				"theme": "fint",
				//"chartBottomMargin": "50",
				"showValue": "1",
                "valueBelowPivot": "1",
				"numberSuffix": "%",
                //"tickValueDecimals": "1",
                //"forceTickValueDecimals": "1",
                //"gaugeFillMix": "{dark-40},{light-40},{dark-20}" 
                "gaugeFillMix": "{dark-30},{light-60},{dark-10}",
                "gaugeFillRatio": "15",
                "chartBottomMargin": "25",
                "valueFontSize": "12",
                //"valueFontColor": "#ffffff"					
			},
			"colorRange": {
				"color": [{
					"minValue": "0",
					"maxValue": "50",
					"code": "#e44a00"
				},{
					"minValue": "50",
					"maxValue": "70",
					"code": "#FFA500"
				},{
					"minValue": "70",
					"maxValue": "80",
					"code": "#FFFF00"
				}, 		
				{
					"minValue": "80",
					"maxValue": "100",
					"code": "#6baa01"
				}]
			},
			"dials": {
				"dial": [{
					"value": <?php echo $media_enc1; ?>
				}]
			}
		}
		});
		fusioncharts.render();
	});	
	
	
	
	FusionCharts.ready(function(){
		var fusioncharts = new FusionCharts({
		type: 'angulargauge',
		renderAt: 'chart-container3',
		width: '400',
		height: '250',	
		dataFormat: 'json',
		dataSource: {
			"chart": {
				//"placeTicksInside":"1",
				"caption": "ENCARGADO",
				"subcaption": "Interperie, Interperie Evalfor, Sombreadero-Despacho (EUCA, EUCA Evalfor, PINO, PINO Evalfor)",
				//"plotToolText": "Current Score: $value",
				"theme": "fint",
				//"chartBottomMargin": "50",
				"showValue": "1",
                "valueBelowPivot": "1",
				"numberSuffix": "%",
                //"tickValueDecimals": "1",
                //"forceTickValueDecimals": "1",
                //"gaugeFillMix": "{dark-40},{light-40},{dark-20}" 
                "gaugeFillMix": "{dark-30},{light-60},{dark-10}",
                "gaugeFillRatio": "15",
                "chartBottomMargin": "25",
                "valueFontSize": "12",
                //"valueFontColor": "#ffffff"			
			},
			"colorRange": {
				"color": [{
					"minValue": "0",
					"maxValue": "50",
					"code": "#e44a00"
				},{
					"minValue": "50",
					"maxValue": "70",
					"code": "#FFA500"
				},{
					"minValue": "70",
					"maxValue": "80",
					"code": "#FFFF00"
				}, 		
				{
					"minValue": "80",
					"maxValue": "100",
					"code": "#6baa01"
				}]
			},
			"dials": {
				"dial": [{
					"value": <?php echo $media_enc2; ?>
				}]
			}
		}
		});
		fusioncharts.render();
	});	
	
	
	<?php $i = 0; while($i < $rowcount){ ?>
	
	FusionCharts.ready(function(){
		var fusioncharts = new FusionCharts({
		type: 'angulargauge',
		renderAt: 'chart-container<?php echo $i+4; ?>',
		width: '220',
		height: '250',
		dataFormat: 'json',
		dataSource: {
			"chart": {
				"caption": "<?php echo $rend_prom[$i][0]; ?>",
				"subcaption": "<?php echo round($rend_prom[$i][1],2).'%'; ?>",
				//"plotToolText": "Current Score: $value",
				"theme": "fint",
				//"chartBottomMargin": "50",
				"showValue": "1",
                "valueBelowPivot": "1",
				"numberSuffix": "%",
                "gaugeFillMix": "{dark-30},{light-60},{dark-10}",
                "gaugeFillRatio": "15",
                "chartBottomMargin": "25",
                "valueFontSize": "12",
			},
			"colorRange": {
				"color": [{
					"minValue": "0",
					"maxValue": "50",
					"code": "#e44a00"
				},{
					"minValue": "50",
					"maxValue": "70",
					"code": "#FFA500"
				},{
					"minValue": "70",
					"maxValue": "80",
					"code": "#FFFF00"
				}, 		
				{
					"minValue": "80",
					"maxValue": "100",
					"code": "#6baa01"
				}]
			},
			"dials": {
				"dial": [{
					"value": '<?php echo $media_actividad_array[$i]; ?>'
				}]
			},	
		}
		});
		fusioncharts.render();
	});		
	
	<?php $i++; } ?>


	
	<?php $i = 0; while($i < $rowcount){ ?>
	FusionCharts.ready(function () {
    var ageGroupChart = new FusionCharts({
        type: 'pie3d',
        renderAt: 'chart-container<?php echo $i+10; ?>',
		width: '220',
		height: '250',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "numberPrefix": "%",
                "paletteColors": "#6baa01,#FFFF00,#FFA500,#e44a00",
                "bgColor": "#ffffff",
                "showBorder": "0",
                //"use3DLighting": "0",
                //"showShadow": "0",
                //"enableSmartLabels": "0",
                //"startingAngle": "310",
                "showLabels": "0",
                "showPercentValues": "1",
                "showLegend": "1",
                "legendShadow": "0",
                "legendBorderAlpha": "0",
                "showTooltip": "0",
                "decimals": "0",
                "subcaptionFontBold": "0",
				//"paletteColors": "#e44a00,#FFA500,#FFFF00,#6baa01"
            },
            "data": [
                {
                    "label": "Esperado",
                    "value": '<?php echo $m_esperado[$i]; ?>'
                }, 
                {
                    "label": "Aceptable",
                    "value": '<?php echo $m_aceptable[$i]; ?>'
                }, 
                {
                    "label": "Trabajar",
                    "value": '<?php echo $m_trabajar[$i]; ?>'
                }, 
                {
                    "label": "Replantear",
                    "value": '<?php echo $m_replantear[$i]; ?>'
                }
            ]
        }
		})
		ageGroupChart.render();
	});	
	
	<?php $i++; } ?>
;
	</script>
</head>
<body style = "padding:10px; margin:0;">
<div style="padding:10px 10px 30px 10px">
<img src="logosotrosur_informe.png" />
<br><br>
<span style="font-size:18px; font-weight:bold;">Informe del <?php echo $SEM_FECHAINI_INF_PRINT; ?> al <?php echo $SEM_FECHAFIN_INF_PRINT; ?>
&nbsp; - TABLERO RENDIMIENTOS AREA PRODUCCION
</span>
</div>
		<div class="row">
		  <div class="col-md-4"></div>
		  <div class="col-md-4"><div id="chart-container"></div> </div>
		  <div class="col-md-4"></div>
		</div>
		
		<div class="row">
		  <div class="col-md-2"></div>
		  <div class="col-md-4"><div id="chart-container2"></div></div>
		  <div class="col-md-4"><div id="chart-container3"></div></div>
		  <div class="col-md-2"></div>
		</div>
		
<hr>
<center><span style="font-size:18px; font-weight:bold;">PROCESOS CON MAYOR CANTIDAD DE PERSONAS ASIGNADAS</span></center>		
<hr>		
		
		
		<div class="row">
		  <center><div class="col-md-2"><div id="chart-container4"></div></div></center>
		  <center><div class="col-md-2"><div id="chart-container5"></div></div></center>
		  <center><div class="col-md-2"><div id="chart-container6"></div></div></center>
		  <center><div class="col-md-2"><div id="chart-container7"></div></div></center>
		  <center><div class="col-md-2"><div id="chart-container8"></div></div></center>
		  <center><div class="col-md-2"><div id="chart-container9"></div></div></center>
		</div>	

		<div class="row">
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">Dotación Inicial:</span> <?php echo $cant_operador_inicial[0]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">Dotación Inicial:</span> <?php echo $cant_operador_inicial[1]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">Dotación Inicial:</span> <?php echo $cant_operador_inicial[2]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">Dotación Inicial:</span> <?php echo $cant_operador_inicial[3]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">Dotación Inicial:</span> <?php echo $cant_operador_inicial[4]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">Dotación Inicial:</span> <?php echo $cant_operador_inicial[5]; ?></div></center>
		</div>		

		<div class="row">
			<center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">Dotación Final:</span> <?php echo $cant_operador[0]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">Dotación Final:</span> <?php echo $cant_operador[1]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">Dotación Final:</span> <?php echo $cant_operador[2]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">Dotación Final:</span> <?php echo $cant_operador[3]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">Dotación Final:</span> <?php echo $cant_operador[4]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">Dotación Final:</span> <?php echo $cant_operador[5]; ?></div></center>
		</div>			
		
		<div class="row">
		  <center><div class="col-md-2"><div id="chart-container10"></div></div></center>
		  <center><div class="col-md-2"><div id="chart-container11"></div></div></center>
		  <center><div class="col-md-2"><div id="chart-container12"></div></div></center>
		  <center><div class="col-md-2"><div id="chart-container13"></div></div></center>
		  <center><div class="col-md-2"><div id="chart-container14"></div></div></center>
		  <center><div class="col-md-2"><div id="chart-container15"></div></div></center>
		</div>			
<!--
<hr>
<center><span style="font-size:18px; font-weight:bold;">RANKING TRABAJADORES POR ACTIVIDAD</span></center>		
<hr>		
		
<br>
<span style="font-size:18px; font-weight:bold; padding:10px">TOP 5</span>		
<br><br>		
		<div class="row">
		  <?php $i = 0; while($i < $rowcount){ ?>	
		  <div class="col-md-2" style="font-size:9px">
		  
			<?php $j = 0; while($j < count($operadores_top[$i])){  
			  $oper = explode("->", $operadores_top[$i][$j]);
			  $nom_oper = $oper[0];
			  $cumpl_oper = round($oper[1],0);			
			?>
			<div class="row">
				<center><div class="col-md-1"><img src="../images/<?php echo $j+1; ?>-verde.png" /></div></center>
				<div class="col-md-10"><span><?php echo $nom_oper; ?></span></div>
				<div class="col-md-1" style="font-size:12px; font-weight:bold"><?php echo $cumpl_oper.'%'; ?></div>
			</div>
			<?php $j++; } ?>
		  </div>
		  <?php $i++; } ?>
		</div>
<br>
		<div class="row">
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">> 80% CUMPLIMIENTO:</span> <?php echo $operadores_80[0]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">> 80% CUMPLIMIENTO:</span> <?php echo $operadores_80[1]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">> 80% CUMPLIMIENTO:</span> <?php echo $operadores_80[2]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">> 80% CUMPLIMIENTO:</span> <?php echo $operadores_80[3]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">> 80% CUMPLIMIENTO:</span> <?php echo $operadores_80[4]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">> 80% CUMPLIMIENTO:</span> <?php echo $operadores_80[5]; ?></div></center>
		</div>
<br>
<span style="font-size:18px; font-weight:bold; padding:10px">BOTTOM 5</span>		
<br><br>		
		<div class="row">
		  <?php $i = 0; while($i < $rowcount){ ?>	
		  <div class="col-md-2" style="font-size:9px">
		  
			<?php $j = 0; while($j < count($operadores_bottom[$i])){  
			  $oper = explode("->", $operadores_bottom[$i][$j]);
			  $nom_oper = $oper[0];
			  $cumpl_oper = round($oper[1],0);			
			?>
			<div class="row">
				<center><div class="col-md-1"><img src="../images/<?php echo $j+1; ?>-rojo.png" /></div></center>
				<div class="col-md-10"><span><?php echo $nom_oper; ?></span></div>
				<div class="col-md-1" style="font-size:12px; font-weight:bold"><?php echo $cumpl_oper.'%'; ?></div>
			</div>
			<?php $j++; } ?>
		  </div>
		  <?php $i++; } ?>
		</div>
<br>

		<div class="row">
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">< 50% CUMPLIMIENTO:</span> <?php echo $operadores_50[0]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">< 50% CUMPLIMIENTO:</span> <?php echo $operadores_50[1]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">< 50% CUMPLIMIENTO:</span> <?php echo $operadores_50[2]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">< 50% CUMPLIMIENTO:</span> <?php echo $operadores_50[3]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">< 50% CUMPLIMIENTO:</span> <?php echo $operadores_50[4]; ?></div></center>
		  <center><div class="col-md-2"><span style="font-size:11px; font-weight:bold">< 50% CUMPLIMIENTO:</span> <?php echo $operadores_50[5]; ?></div></center>
		</div>
	-->
<br>
</body>
</html>