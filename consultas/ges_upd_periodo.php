<?php

	include('coneccion.php');
	$semanas_per = getIsoWeeksInYear(2017);
	
	$sem_num = 1;
	
	while($sem_num <= $semanas_per){
		
		$mes = getIsoMonthInWeek($periodo,$sem_num);
	
		$sql_ins_sem = "update SEMANAS set per_mes = '$mes' where per_agno = 2017 and sem_num = $sem_num";	
		$resultado = mysqli_query($link,$sql_ins_sem);		
		$sem_num++;
	}


	function getIsoWeeksInYear($year) {
		$date = new DateTime;
		$date->setISODate($year, 53);
		return ($date->format("W") === "53" ? 53 : 52);
	}	
	
	function getIsoMonthInWeek($year,$numberWeek) {
		$date = new DateTime;
		$date->setISODate($year, $numberWeek);
		return $date->format("m");
	}

?>