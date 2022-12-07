<?php

if(empty($_GET['per_agno']) or empty($_GET['per_mes']) or empty($_GET['sem_num'])){
	echo 'Error: Ausencia de período de búsqueda';
	exit;
}
else{

//PARAMETROS DE ENTRADA

	$per_agno = $_GET['per_agno'];
	$per_mes = $_GET['per_mes'];
	$sem_num = $_GET['sem_num'];	

//BASE DE DATOS
	
	include('../consultas/coneccion.php');	
	
	$lunes  = date('Ymd', strtotime($per_agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));	
	$martes = date('Ymd', strtotime($lunes.' 1 day'));
	$miercoles = date('Ymd', strtotime($lunes.' 2 day'));
	$jueves = date('Ymd', strtotime($lunes.' 3 day'));
	$viernes = date('Ymd', strtotime($lunes.' 4 day'));
	$sabado = date('Ymd', strtotime($lunes.' 5 day'));
	
	$sql = "
	select AREA_ID, AREA_NOMBRE,
	'$lunes' as LUN, 	
	(SELECT SUM(PLAN.JORNADA)   
	FROM ACTIVIDAD AS ACT
	JOIN PLAN_MAESTRO AS PLAN ON ACT.ACTIV_ID = PLAN.ACTIV_ID 
	WHERE PLAN.PLANM_DIA = '$lunes' AND AREA.AREA_ID = ACT.AREA_ID)	as CANT1, 
	'$martes' as MAR, 
	(SELECT SUM(PLAN.JORNADA)   
	FROM ACTIVIDAD AS ACT
	JOIN PLAN_MAESTRO AS PLAN ON ACT.ACTIV_ID = PLAN.ACTIV_ID 
	WHERE PLAN.PLANM_DIA = '$martes' AND AREA.AREA_ID = ACT.AREA_ID) as CANT2, 
	'$miercoles' as MIE,
	(SELECT SUM(PLAN.JORNADA)   
	FROM ACTIVIDAD AS ACT
	JOIN PLAN_MAESTRO AS PLAN ON ACT.ACTIV_ID = PLAN.ACTIV_ID 
	WHERE PLAN.PLANM_DIA = '$miercoles' AND AREA.AREA_ID = ACT.AREA_ID) as CANT3, 	
	'$jueves' as JUE, 
	(SELECT SUM(PLAN.JORNADA)   
	FROM ACTIVIDAD AS ACT
	JOIN PLAN_MAESTRO AS PLAN ON ACT.ACTIV_ID = PLAN.ACTIV_ID 
	WHERE PLAN.PLANM_DIA = '$jueves' AND AREA.AREA_ID = ACT.AREA_ID) as CANT4, 
	'$viernes' as VIE, 
	(SELECT SUM(PLAN.JORNADA)   
	FROM ACTIVIDAD AS ACT
	JOIN PLAN_MAESTRO AS PLAN ON ACT.ACTIV_ID = PLAN.ACTIV_ID 
	WHERE PLAN.PLANM_DIA = '$viernes' AND AREA.AREA_ID = ACT.AREA_ID) as CANT5, 	
	'$sabado' as SAB, 
	(SELECT SUM(PLAN.JORNADA)   
	FROM ACTIVIDAD AS ACT
	JOIN PLAN_MAESTRO AS PLAN ON ACT.ACTIV_ID = PLAN.ACTIV_ID 
	WHERE PLAN.PLANM_DIA = '$sabado' AND AREA.AREA_ID = ACT.AREA_ID) as CANT6 	
	from AREA AS AREA";	
	$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
	
	while( $rows = mysqli_fetch_assoc($resultado) ) {
		echo '<pre>';
		print_r($rows);
		echo '</pre>';			
	}
	

}


	
?>