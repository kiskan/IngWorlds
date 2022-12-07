<?php
	
	$date = new DateTime;
	$date->setISODate(date('Y'), date('W'));
	$mes_actual = $date->format("m");	
	$agno_actual = $date->format("Y");
	
	echo $mes_actual;
	echo '<br>';
	echo $agno_actual;
?>