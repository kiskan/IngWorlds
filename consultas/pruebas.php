<?php 
	
	include('coneccion.php');
	
	$periodo = 2017;	
	
	mysqli_autocommit($link, FALSE);
	$resp = array('cod'=>'error','desc'=>'Error de Base de Datos.');	

	$semanas_per = getIsoWeeksInYear($periodo);	
	$sem_num = 1;
	
	while($sem_num <= $semanas_per){
	
		$sem_fechaini  = date('Ymd', strtotime($periodo . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));
			
		$domingo = date('Ymd', strtotime($sem_fechaini.' 6 day'));
		
		$sql_ins_diasferiados = "insert into DIAS_FERIADOS(dias,per_agno,sem_num)";				
		$sql_ins_diasferiados .= "select $domingo,$periodo,$sem_num";
		$resultado = mysqli_query($link,$sql_ins_diasferiados)or die(salida_con_rollback($resp,$link));				
		
		$sem_num++;
	}
	

	//Días Feriado: días 1 de enero, 1 de mayo, 18 y 19 de septiembre y 25 de diciembre
	$per_sgte = $periodo + 1;
	$enero1 = $periodo.'0101';$mayo1 = $periodo.'0501';$sept18 = $periodo.'0918';$sept19 = $periodo.'0919';$dic25 = $periodo.'1225';$enero1_sgte = $per_sgte.'0101';	
	
	//Ver si el 1ero de enero está dentro de las semanas del año
	$sql = "select sem_num from SEMANAS where per_agno = $periodo and '$enero1' between sem_fechaini and sem_fechafin";
	$resultado = mysqli_query($link,$sql)or die(salida($resp));
	$rowcount = mysqli_num_rows($resultado);

	if($rowcount > 0){	
	
		$semana = mysqli_fetch_row($resultado);
		$num_sem = $semana[0];			
		
		$sql = "select dias from DIAS_FERIADOS where dias = '$enero1'";
		$resultado = mysqli_query($link,$sql)or die(salida($resp));
		$rowcount = mysqli_num_rows($resultado);

		if($rowcount == 0){		
			$sql = "insert into DIAS_FERIADOS(dias,per_agno,sem_num) values ('$enero1',$periodo,$num_sem)";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
		}				
		
	}		

	//Ver si el 1ero de enero del sgte año está dentro de las semanas del año
	$sql = "select sem_num from SEMANAS where per_agno = $periodo and '$enero1_sgte' between sem_fechaini and sem_fechafin";
	$resultado = mysqli_query($link,$sql)or die(salida($resp));
	$rowcount = mysqli_num_rows($resultado);

	if($rowcount > 0){	
	
		$semana = mysqli_fetch_row($resultado);
		$num_sem = $semana[0];			

		if($rowcount == 0){		
			$sql = "insert into DIAS_FERIADOS(dias,per_agno,sem_num) values ('$enero1_sgte',$periodo,$num_sem)";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
		}				
		
	}		

	//1ero de mayo
	$sql = "select sem_num from SEMANAS where per_agno = $periodo and '$mayo1' between sem_fechaini and sem_fechafin";
	$resultado = mysqli_query($link,$sql)or die(salida($resp));
	$rowcount = mysqli_num_rows($resultado);

	if($rowcount > 0){	
	
		$semana = mysqli_fetch_row($resultado);
		$num_sem = $semana[0];			
		
		$sql = "select dias from DIAS_FERIADOS where dias = '$mayo1'";
		$resultado = mysqli_query($link,$sql)or die(salida($resp));
		$rowcount = mysqli_num_rows($resultado);

		if($rowcount == 0){		
			$sql = "insert into DIAS_FERIADOS(dias,per_agno,sem_num) values ('$mayo1',$periodo,$num_sem)";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
		}					
		
	}

	//18 de sept
	$sql = "select sem_num from SEMANAS where per_agno = $periodo and '$sept18' between sem_fechaini and sem_fechafin";
	$resultado = mysqli_query($link,$sql)or die(salida($resp));
	$rowcount = mysqli_num_rows($resultado);

	if($rowcount > 0){	
	
		$semana = mysqli_fetch_row($resultado);
		$num_sem = $semana[0];			
		
		$sql = "select dias from DIAS_FERIADOS where dias = '$sept18'";
		$resultado = mysqli_query($link,$sql)or die(salida($resp));
		$rowcount = mysqli_num_rows($resultado);

		if($rowcount == 0){		
			$sql = "insert into DIAS_FERIADOS(dias,per_agno,sem_num) values ('$sept18',$periodo,$num_sem)";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
		}				
		
	}		
	
	//19 de sept
	$sql = "select sem_num from SEMANAS where per_agno = $periodo and '$sept19' between sem_fechaini and sem_fechafin";
	$resultado = mysqli_query($link,$sql)or die(salida($resp));
	$rowcount = mysqli_num_rows($resultado);

	if($rowcount > 0){	
	
		$semana = mysqli_fetch_row($resultado);
		$num_sem = $semana[0];			
		
		$sql = "select dias from DIAS_FERIADOS where dias = '$sept19'";
		$resultado = mysqli_query($link,$sql)or die(salida($resp));
		$rowcount = mysqli_num_rows($resultado);

		if($rowcount == 0){		
			$sql = "insert into DIAS_FERIADOS(dias,per_agno,sem_num) values ('$sept19',$periodo,$num_sem)";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
		}				
		
	}			

	//25 de dic
	$sql = "select sem_num from SEMANAS where per_agno = $periodo and '$dic25' between sem_fechaini and sem_fechafin";
	$resultado = mysqli_query($link,$sql)or die(salida($resp));
	$rowcount = mysqli_num_rows($resultado);

	if($rowcount > 0){	
	
		$semana = mysqli_fetch_row($resultado);
		$num_sem = $semana[0];			
		
		$sql = "select dias from DIAS_FERIADOS where dias = '$dic25'";
		$resultado = mysqli_query($link,$sql)or die(salida($resp));
		$rowcount = mysqli_num_rows($resultado);

		if($rowcount == 0){		
			$sql = "insert into DIAS_FERIADOS(dias,per_agno,sem_num) values ('$dic25',$periodo,$num_sem)";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
		}				
		
	}		
	
	mysqli_commit($link);	
		
		
	function getIsoWeeksInYear($year) {
		$date = new DateTime;
		$date->setISODate($year, 53);
		return ($date->format("W") === "53" ? 53 : 52);
	}	
	
	function getIsoMonthInWeek($year,$numberWeek) {
		$date = new DateTime;
		$date->setISODate($year, $numberWeek);
		return $date->format("m");
		//echo (new DateTime())->setISODate(2017, 5)->format('m');
	}		
?> 