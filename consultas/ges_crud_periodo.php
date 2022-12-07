<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($periodo)){

		$current_year = date('Y');
		//$current_year = 2020;
		$last_week = getIsoWeeksInYear($current_year);	
		$current_week = date("W");
		
		if($last_week == $current_week){
			$dia_actual = date('Ymd');
			$sql = "SELECT PER_AGNO FROM SEMANAS WHERE '$dia_actual' BETWEEN SEM_FECHAINI AND SEM_FECHAFIN";
			$resultado = mysqli_query($link,$sql);
			$fila = mysqli_fetch_row($resultado);
			$current_year = $fila[0];			
		}
		
		$next_year = $current_year + 1;
		
		$corresponding_agno = $current_year;
		//$corresponding_agno = 2020;
		$corresponding_week = $current_week;	
	
		$sql = "select PER_AGNO, PER_AGNO from PERIODO ORDER BY PER_AGNO DESC";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));	
		$data_agno = array();
		
		while( $rows_agno = mysqli_fetch_assoc($resultset) ) {
			$data_agno[] = $rows_agno;
		}		

		$sql = "select SEM_NUM, CONCAT('SEMANA ',CAST(SEM_NUM AS CHAR),' : ',CAST(DATE_FORMAT(SEM_FECHAINI,'%d-%m-%Y') AS CHAR),' al ',CAST(DATE_FORMAT(SEM_FECHAFIN,'%d-%m-%Y') AS CHAR)) AS SEMANAS 
		from SEMANAS where PER_AGNO = $current_year order by SEM_NUM";	
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data_sem = array();
		
		while( $rows_sem = mysqli_fetch_assoc($resultset) ) {
			$data_sem[] = $rows_sem;
		}

		$load_periodos = json_encode($data_agno);
		$load_semanas = json_encode($data_sem);
		

	}
	
	elseif(isset($plan_periodo)){

		$current_year = date('Y');
		//$current_year = 2020;
		$last_week = getIsoWeeksInYear($current_year);	
		$current_week = date("W");
		
		if($last_week == $current_week){
			$dia_actual = date('Ymd');
			$sql = "SELECT PER_AGNO FROM SEMANAS WHERE '$dia_actual' BETWEEN SEM_FECHAINI AND SEM_FECHAFIN";
			$resultado = mysqli_query($link,$sql);
			$fila = mysqli_fetch_row($resultado);
			$current_year = $fila[0];			
		}		
		
		$next_year = $current_year + 1;
		
		$corresponding_agno = $current_year;
		//$corresponding_agno = 2020;
		$corresponding_week = $current_week;
		if($_SESSION['USR_TIPO'] == 'PLANIFICADOR'){
			$corresponding_week = $current_week + 1;
		}				
		
		$error = FALSE;
		if($current_week == $last_week and $_SESSION['USR_TIPO'] == 'PLANIFICADOR'){
			$sql = "select PER_AGNO from PERIODO WHERE PER_AGNO = $next_year";
			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount == 0){		
				$error = TRUE;
			}else{
				$corresponding_agno = $next_year;
				$corresponding_week = 1;
			}			
		}			
	
		$sql = "select PER_AGNO, PER_AGNO from PERIODO ORDER BY PER_AGNO DESC";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));	
		$data_agno = array();

		while( $rows_agno = mysqli_fetch_assoc($resultset) ) {
			$data_agno[] = $rows_agno;
		}				
	
	//$sql = "select SEM_NUM, CONCAT('SEMANA ',CAST(SEM_NUM AS CHAR),' : ',CAST(DATE_FORMAT(SEM_FECHAINI,'%d-%m-%Y') AS CHAR),' al ',CAST(DATE_FORMAT(SEM_FECHAFIN,'%d-%m-%Y') AS CHAR)) AS SEMANAS from SEMANAS where PER_AGNO = (select PER_AGNO from PERIODO ORDER BY PER_AGNO DESC LIMIT 1)";	
		
		$sql = "select SEM_NUM, CONCAT('SEMANA ',CAST(SEM_NUM AS CHAR),' : ',CAST(DATE_FORMAT(SEM_FECHAINI,'%d-%m-%Y') AS CHAR),' al ',CAST(DATE_FORMAT(SEM_FECHAFIN,'%d-%m-%Y') AS CHAR)) AS SEMANAS 
		from SEMANAS where PER_AGNO = $corresponding_agno order by SEM_NUM";			
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data_sem = array();
		
		while( $rows_sem = mysqli_fetch_assoc($resultset) ) {
			$data_sem[] = $rows_sem;
		}

		$load_periodos = json_encode($data_agno);
		$load_semanas = json_encode($data_sem);


	}	
	
	
	elseif(isset($_POST['per_agno'])){
		$per_agno = $_POST['per_agno'];
		//$sql = "select SEM_NUM, CONCAT('#',CAST(SEM_NUM AS CHAR),' : ',CAST(DATE_FORMAT(SEM_FECHAINI,'%d-%m-%Y') AS CHAR),' al ',CAST(DATE_FORMAT(SEM_FECHAFIN,'%d-%m-%Y') AS CHAR)) AS SEMANAS from SEMANAS where PER_AGNO = $per_agno";	
		
		$sql = "select SEM_NUM, CONCAT('SEMANA ',CAST(SEM_NUM AS CHAR),' : ',CAST(DATE_FORMAT(SEM_FECHAINI,'%d-%m-%Y') AS CHAR),' al ',CAST(DATE_FORMAT(SEM_FECHAFIN,'%d-%m-%Y') AS CHAR)) AS SEMANAS
		from SEMANAS where PER_AGNO = $per_agno order by SEM_NUM";			
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}	
	
	
	elseif(isset($_POST['cons_periodo'])){
		
		$per_agno = $_POST['agno'];
		$per_mes = $_POST['mes'];

		$sql = "select SEM_NUM, CONCAT('SEMANA ',CAST(SEM_NUM AS CHAR),' : ',CAST(DATE_FORMAT(SEM_FECHAINI,'%d-%m-%Y') AS CHAR),' al ',CAST(DATE_FORMAT(SEM_FECHAFIN,'%d-%m-%Y') AS CHAR)) AS SEMANAS 
		from SEMANAS where PER_AGNO = $per_agno and (PER_MES = '$per_mes' or PER_MES = '') order by SEM_NUM";			
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}	
	

	
	elseif(isset($_POST['cons_periodo_inf'])){
		
		$per_agno = $_POST['agno'];
		$per_mes = $_POST['mes'];

		$sql = "select SEM_NUM, CONCAT('SEMANA ',CAST(SEM_NUM AS CHAR),' : ',CAST(DATE_FORMAT(SEM_FECHAINI_INF,'%d-%m-%Y') AS CHAR),' al ',CAST(DATE_FORMAT(SEM_FECHAFIN_INF,'%d-%m-%Y') AS CHAR)) AS SEMANAS 
		from SEMANAS where PER_AGNO = $per_agno and (PER_MES = '$per_mes' or PER_MES = '') order by SEM_NUM";			
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}	
	
	
	elseif(isset($_POST['sem_num'])){
		$sem_num = $_POST['sem_num'];
		$agno = $_POST['agno'];
		
		$lunes  = date('Ymd', strtotime($agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));	
		$martes = date('Ymd', strtotime($lunes.' 1 day'));
		$miercoles = date('Ymd', strtotime($lunes.' 2 day'));
		$jueves = date('Ymd', strtotime($lunes.' 3 day'));
		$viernes = date('Ymd', strtotime($lunes.' 4 day'));
		$sabado = date('Ymd', strtotime($lunes.' 5 day'));
		$domingo = date('Ymd', strtotime($lunes.' 6 day')); //CCO 20200325

		$lunes_text = 'LUN '.date("d", strtotime($lunes));
		$martes_text = ' MAR '.date("d", strtotime($martes));
		$miercoles_text = ' MIE '.date("d", strtotime($miercoles));
		$jueves_text = ' JUE '.date("d", strtotime($jueves));
		$viernes_text = ' VIE '.date("d", strtotime($viernes));
		$sabado_text = ' SAB '.date("d", strtotime($sabado));
		$domingo_text = ' DOM '.date("d", strtotime($domingo)); //CCO 20200325
		
		$data = array();
		
		$data[] = Array('DIA' => $lunes,'DIA_TEXT' => $lunes_text);
		$data[] = Array('DIA' => $martes,'DIA_TEXT' => $martes_text);
		$data[] = Array('DIA' => $miercoles,'DIA_TEXT' => $miercoles_text);
		$data[] = Array('DIA' => $jueves,'DIA_TEXT' => $jueves_text);
		$data[] = Array('DIA' => $viernes,'DIA_TEXT' => $viernes_text);
		$data[] = Array('DIA' => $sabado,'DIA_TEXT' => $sabado_text);
		$data[] = Array('DIA' => $domingo,'DIA_TEXT' => $domingo_text); //CCO 20200325

		salida($data);
	}
	
	
/*	
	elseif(isset($_POST['sem_num_especial'])){
		$sem_num = $_POST['sem_num_especial'];
		$agno = $_POST['agno'];
		
		$lunes  = date('Ymd', strtotime($agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));	
		$martes = date('Ymd', strtotime($lunes.' 1 day'));
		$miercoles = date('Ymd', strtotime($lunes.' 2 day'));
		$jueves = date('Ymd', strtotime($lunes.' 3 day'));
		$viernes = date('Ymd', strtotime($lunes.' 4 day'));
		$sabado = date('Ymd', strtotime($lunes.' 5 day'));

		$lunes_text = ' LUN '.date("d", strtotime($lunes));
		$martes_text = ' MAR '.date("d", strtotime($martes));
		$miercoles_text = ' MIE '.date("d", strtotime($miercoles));
		$jueves_text = ' JUE '.date("d", strtotime($jueves));
		$viernes_text = ' VIE '.date("d", strtotime($viernes));
		$sabado_text = ' SAB '.date("d", strtotime($sabado));
		
		$sabado_pasado = date('Ymd', strtotime($lunes.' -2 day'));
		$sabado_pasado_text = ' SAB '.date("d", strtotime($sabado_pasado));			
		$viernes_pasado = date('Ymd', strtotime($lunes.' -3 day'));
		$viernes_pasado_text = ' VIE '.date("d", strtotime($viernes_pasado));	
		$jueves_pasado = date('Ymd', strtotime($lunes.' -4 day'));
		$jueves_pasado_text = ' JUE '.date("d", strtotime($jueves_pasado));
		$miercoles_pasado = date('Ymd', strtotime($lunes.' -5 day'));
		$miercoles_pasado_text = ' MIE '.date("d", strtotime($miercoles_pasado));
		$martes_pasado = date('Ymd', strtotime($lunes.' -6 day'));
		$martes_pasado_text = ' MAR '.date("d", strtotime($martes_pasado));
		$lunes_pasado = date('Ymd', strtotime($lunes.' -7 day'));
		$lunes_pasado_text = 'LUN '.date("d", strtotime($lunes_pasado));		

		$data = array();
		
		$data[] = Array('DIA' => $lunes_pasado,'DIA_TEXT' => $lunes_pasado_text);
		$data[] = Array('DIA' => $martes_pasado,'DIA_TEXT' => $martes_pasado_text);
		$data[] = Array('DIA' => $miercoles_pasado,'DIA_TEXT' => $miercoles_pasado_text);
		$data[] = Array('DIA' => $jueves_pasado,'DIA_TEXT' => $jueves_pasado_text);
		$data[] = Array('DIA' => $viernes_pasado,'DIA_TEXT' => $viernes_pasado_text);
		$data[] = Array('DIA' => $sabado_pasado,'DIA_TEXT' => $sabado_pasado_text);		
		
		$data[] = Array('DIA' => $lunes,'DIA_TEXT' => $lunes_text);
		$data[] = Array('DIA' => $martes,'DIA_TEXT' => $martes_text);
		$data[] = Array('DIA' => $miercoles,'DIA_TEXT' => $miercoles_text);
		$data[] = Array('DIA' => $jueves,'DIA_TEXT' => $jueves_text);
		$data[] = Array('DIA' => $viernes,'DIA_TEXT' => $viernes_text);
		$data[] = Array('DIA' => $sabado,'DIA_TEXT' => $sabado_text);

		salida($data);
	}	
*/	
	
	
	
	


	elseif(isset($_POST['sem_num_especial'])){
		$sem_num = $_POST['sem_num_especial'];
		$agno = $_POST['agno'];
	
		$lunes  = date('Ymd', strtotime($agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));	
		$martes = date('Ymd', strtotime($lunes.' 1 day'));
		$miercoles = date('Ymd', strtotime($lunes.' 2 day'));
		$jueves = date('Ymd', strtotime($lunes.' 3 day'));
		$viernes = date('Ymd', strtotime($lunes.' 4 day'));
		$sabado = date('Ymd', strtotime($lunes.' 5 day'));
		
		$domingo = date('Ymd', strtotime($lunes.' 6 day'));

		$lunes_text = 'LUN '.date("d", strtotime($lunes));
		$martes_text = ' MAR '.date("d", strtotime($martes));
		$miercoles_text = ' MIE '.date("d", strtotime($miercoles));
		$jueves_text = ' JUE '.date("d", strtotime($jueves));
		$viernes_text = ' VIE '.date("d", strtotime($viernes));
		$sabado_text = ' SAB '.date("d", strtotime($sabado));		
		$domingo_text = ' DOM '.date("d", strtotime($domingo));
		

		$domingo_pasado = date('Ymd', strtotime($lunes.' -1 day'));
		$domingo_pasado_text = ' DOM '.date("d", strtotime($domingo_pasado));
		$sabado_pasado = date('Ymd', strtotime($lunes.' -2 day'));
		$sabado_pasado_text = ' SAB '.date("d", strtotime($sabado_pasado));		
		
		$viernes_pasado = date('Ymd', strtotime($lunes.' -3 day'));
		$viernes_pasado_text = ' VIE '.date("d", strtotime($viernes_pasado));	
		$jueves_pasado = date('Ymd', strtotime($lunes.' -4 day'));
		$jueves_pasado_text = ' JUE '.date("d", strtotime($jueves_pasado));
		$miercoles_pasado = date('Ymd', strtotime($lunes.' -5 day'));
		$miercoles_pasado_text = ' MIE '.date("d", strtotime($miercoles_pasado));
		$martes_pasado = date('Ymd', strtotime($lunes.' -6 day'));
		$martes_pasado_text = ' MAR '.date("d", strtotime($martes_pasado));
		$lunes_pasado = date('Ymd', strtotime($lunes.' -7 day'));
		$lunes_pasado_text = ' LUN '.date("d", strtotime($lunes_pasado));	

		//semana anterior
		if($sem_num == 1){
			$agno_sem_anterior = $agno - 1;
			$sem_anterior = getIsoWeeksInYear($agno_sem_anterior);
		}else{
			$agno_sem_anterior = $agno;
			$sem_anterior = $sem_num - 1;
		}	
		
		//SELECT '20190504' as num union select '20190505' as num union select '20190506' as num order by num desc limit 1
		//SELECT (CASE WHEN '20190615' NOT IN (SELECT DIAS FROM `DIAS_NOPROD` WHERE `PER_AGNO`=2019 and `SEM_NUM`=24) THEN '20190615' ELSE '' END) AS NUM
	
		//primer día hábil de la semana 
		$agno_superior = $agno + 2;
		$fecha_superior = $agno_superior.'0101';
		$sql = "
		SELECT (CASE WHEN '$lunes' NOT IN (SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO=$agno and SEM_NUM=$sem_num) THEN '$lunes' ELSE '$fecha_superior' END) AS NUM UNION
		SELECT (CASE WHEN '$martes' NOT IN (SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO=$agno and SEM_NUM=$sem_num) THEN '$martes' ELSE '$fecha_superior' END) AS NUM UNION
		SELECT (CASE WHEN '$miercoles' NOT IN (SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO=$agno and SEM_NUM=$sem_num) THEN '$miercoles' ELSE '$fecha_superior' END) AS NUM UNION
		SELECT (CASE WHEN '$jueves' NOT IN (SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO=$agno and SEM_NUM=$sem_num) THEN '$jueves' ELSE '$fecha_superior' END) AS NUM UNION
		SELECT (CASE WHEN '$viernes' NOT IN (SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO=$agno and SEM_NUM=$sem_num) THEN '$viernes' ELSE '$fecha_superior' END) AS NUM UNION 
		SELECT (CASE WHEN '$sabado' NOT IN (SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO=$agno and SEM_NUM=$sem_num) THEN '$sabado' ELSE '$fecha_superior' END) AS NUM UNION 
		SELECT (CASE WHEN '$domingo' NOT IN (SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO=$agno and SEM_NUM=$sem_num) THEN '$domingo' ELSE '$fecha_superior' END) AS NUM 
		order by NUM asc limit 1
		";	
		$resultado = mysqli_query($link,$sql);
		$fila = mysqli_fetch_row($resultado);
		$primer_dia_habil_sem_actual = $fila[0];
		
		//último día hábil de semana anterior
		$sql = "
		SELECT (CASE WHEN '$lunes_pasado' NOT IN (SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO=$agno_sem_anterior and SEM_NUM=$sem_anterior) THEN '$lunes_pasado' ELSE '' END) AS NUM UNION
		SELECT (CASE WHEN '$martes_pasado' NOT IN (SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO=$agno_sem_anterior and SEM_NUM=$sem_anterior) THEN '$martes_pasado' ELSE '' END) AS NUM UNION
		SELECT (CASE WHEN '$miercoles_pasado' NOT IN (SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO=$agno_sem_anterior and SEM_NUM=$sem_anterior) THEN '$miercoles_pasado' ELSE '' END) AS NUM UNION
		SELECT (CASE WHEN '$jueves_pasado' NOT IN (SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO=$agno_sem_anterior and SEM_NUM=$sem_anterior) THEN '$jueves_pasado' ELSE '' END) AS NUM UNION
		SELECT (CASE WHEN '$viernes_pasado' NOT IN (SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO=$agno_sem_anterior and SEM_NUM=$sem_anterior) THEN '$viernes_pasado' ELSE '' END) AS NUM UNION 
		SELECT (CASE WHEN '$sabado_pasado' NOT IN (SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO=$agno_sem_anterior and SEM_NUM=$sem_anterior) THEN '$sabado_pasado' ELSE '' END) AS NUM UNION 
		SELECT (CASE WHEN '$domingo_pasado' NOT IN (SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO=$agno_sem_anterior and SEM_NUM=$sem_anterior) THEN '$domingo_pasado' ELSE '' END) AS NUM 
		order by NUM desc limit 1
		";		
		$resultado = mysqli_query($link,$sql);
		$fila = mysqli_fetch_row($resultado);
		$ultimo_dia_habil_sem_anterior = $fila[0];
		
		$data = array();
		//$hoy = "20190612";
		
		if($hoy == $primer_dia_habil_sem_actual and $ultimo_dia_habil_sem_anterior <> ''){
			switch($ultimo_dia_habil_sem_anterior){
				
				case $domingo_pasado:
					$dia_sem_ant = $domingo_pasado;
					$dia_sem_ant_text = $domingo_pasado_text;
				break;				
				case $sabado_pasado:
					$dia_sem_ant = $sabado_pasado;
					$dia_sem_ant_text = $sabado_pasado_text;
				break;				
				
				case $viernes_pasado:
					$dia_sem_ant = $viernes_pasado;
					$dia_sem_ant_text = $viernes_pasado_text;
				break;
				case $jueves_pasado:
					$dia_sem_ant = $jueves_pasado;
					$dia_sem_ant_text = $jueves_pasado_text;
				break;
				case $miercoles_pasado:
					$dia_sem_ant = $miercoles_pasado;
					$dia_sem_ant_text = $miercoles_pasado_text;
				break;
				case $martes_pasado:
					$dia_sem_ant = $martes_pasado;
					$dia_sem_ant_text = $martes_pasado_text;
				break;
				case $lunes_pasado:
					$dia_sem_ant = $lunes_pasado;
					$dia_sem_ant_text = $lunes_pasado_text;
				break;				
			}			
			$data[] = Array('DIA' => $dia_sem_ant,'DIA_TEXT' => $dia_sem_ant_text);
		}
		
		//$data = array();
		//$data[] = Array('DIA' => $viernes_pasado,'DIA_TEXT' => $viernes_pasado_text);
		$data[] = Array('DIA' => $lunes,'DIA_TEXT' => $lunes_text,'primer_dia_habil_sem_actual' => $primer_dia_habil_sem_actual,'ultimo_dia_habil_sem_anterior' => $ultimo_dia_habil_sem_anterior);
		$data[] = Array('DIA' => $martes,'DIA_TEXT' => $martes_text);
		$data[] = Array('DIA' => $miercoles,'DIA_TEXT' => $miercoles_text);
		$data[] = Array('DIA' => $jueves,'DIA_TEXT' => $jueves_text);
		$data[] = Array('DIA' => $viernes,'DIA_TEXT' => $viernes_text);
		$data[] = Array('DIA' => $sabado,'DIA_TEXT' => $sabado_text);
		
		$data[] = Array('DIA' => $domingo,'DIA_TEXT' => $domingo_text);

		salida($data);
	}	
	
	
	elseif(isset($_POST['sem_num_extra'])){
		$sem_num = $_POST['sem_num_extra'];
		$agno = $_POST['agno'];
		
		$lunes  = date('Ymd', strtotime($agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));	
		$martes = date('Ymd', strtotime($lunes.' 1 day'));
		$miercoles = date('Ymd', strtotime($lunes.' 2 day'));
		$jueves = date('Ymd', strtotime($lunes.' 3 day'));
		$viernes = date('Ymd', strtotime($lunes.' 4 day'));
		$sabado = date('Ymd', strtotime($lunes.' 5 day'));
		$domingo = date('Ymd', strtotime($lunes.' 6 day'));	

		$lunes_text = 'LUN '.date("d", strtotime($lunes));
		$martes_text = ' MAR '.date("d", strtotime($martes));
		$miercoles_text = ' MIE '.date("d", strtotime($miercoles));
		$jueves_text = ' JUE '.date("d", strtotime($jueves));
		$viernes_text = ' VIE '.date("d", strtotime($viernes));
		$sabado_text = ' SAB '.date("d", strtotime($sabado));
		$domingo_text = ' DOM '.date("d", strtotime($domingo));
		
		$data = array();
		
		$data[] = Array('DIA' => $lunes,'DIA_TEXT' => $lunes_text);
		$data[] = Array('DIA' => $martes,'DIA_TEXT' => $martes_text);
		$data[] = Array('DIA' => $miercoles,'DIA_TEXT' => $miercoles_text);
		$data[] = Array('DIA' => $jueves,'DIA_TEXT' => $jueves_text);
		$data[] = Array('DIA' => $viernes,'DIA_TEXT' => $viernes_text);
		$data[] = Array('DIA' => $sabado,'DIA_TEXT' => $sabado_text);
		$data[] = Array('DIA' => $domingo,'DIA_TEXT' => $domingo_text);

			
		salida($data);
	}			
	
	
	else{
	
	
		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$periodo = $_POST['periodo'];
			$periodo_ant = $periodo - 1;
			if($periodo == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			mysqli_autocommit($link, FALSE);
			$resp = array('cod'=>'error','desc'=>'Error de Base de Datos.');
			/**/
			$sql_ins_per = "insert into PERIODO(per_agno) values ($periodo)";
			$resultado = mysqli_query($link,$sql_ins_per)or die(salida_con_rollback($resp,$link));	
			
			$num_mes = 1;
			while($num_mes <= 12){

				if($num_mes < 10 ){			
					$mes = '0'.$num_mes;
				}else{
					$mes = $num_mes;
				}			
			
				//$sql = "select meta_mini, meta_pino, meta_macro, num_setos from METAS_INF order by per_agno, per_mes asc limit 1";
				$sql = "select meta_mini, meta_pino, meta_macro, num_setos from METAS_INF where per_agno = $periodo_ant and per_mes = '12' ";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount == 0){		
					$meta_mini = 70000;$meta_pino = 80000;$meta_macro = 90000;$num_setos = 570570; //num_setos=(3003*190)
				}else{
				
					$metas = mysqli_fetch_row($resultado);
					$meta_mini = $metas[0];	$meta_pino = $metas[1]; $meta_macro = $metas[2]; $num_setos = $metas[3];				
				}
				
				$sql = "insert into METAS_INF(per_agno,per_mes,meta_mini,meta_pino,meta_macro,num_setos) values ($periodo,'$mes',$meta_mini,$meta_pino,$meta_macro,$num_setos)";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
				
				$num_mes++;
			}

			$semanas_per = getIsoWeeksInYear($periodo);
			
			$sem_num = 1;
			
			while($sem_num <= $semanas_per){
			
				$sem_fechaini  = date('Ymd', strtotime($periodo . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));
				$sem_fechafin = date('Ymd', strtotime($sem_fechaini.' 6 day'));
				
				//fechas informe
				$lunes  = date('Ymd', strtotime($periodo . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));			
				$viernes = date('Ymd', strtotime($lunes.' -3 day'));
				$jueves = date('Ymd', strtotime($lunes.' 3 day'));				
				
				$mes = getIsoMonthInWeek($periodo,$sem_num);
			/**/
				$sql_ins_sem = "insert into SEMANAS(per_agno, sem_num, per_mes, sem_fechaini, sem_fechafin, sem_fechaini_inf, sem_fechafin_inf) values ($periodo,$sem_num,'$mes','$sem_fechaini','$sem_fechafin','$viernes','$jueves')";	
				$resultado = mysqli_query($link,$sql_ins_sem)or die(salida_con_rollback($resp,$link));	
				
				//Días Inhábiles Weekend
				$sabado = date('Ymd', strtotime($sem_fechaini.' 5 day'));				
				$domingo = date('Ymd', strtotime($sem_fechaini.' 6 day'));
				
				$sql_ins_diasnoprod = "insert into DIAS_NOPROD(dias,per_agno,sem_num)";
				$sql_ins_diasnoprod .= "select $sabado,$periodo,$sem_num UNION ";				
				$sql_ins_diasnoprod .= "select $domingo,$periodo,$sem_num";
				$resultado = mysqli_query($link,$sql_ins_diasnoprod)or die(salida_con_rollback($resp,$link));	
				
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
			
				$sql = "select dias from DIAS_NOPROD where dias = '$enero1'";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount == 0){		
					$sql = "insert into DIAS_NOPROD(dias,per_agno,sem_num) values ('$enero1',$periodo,$num_sem)";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				}	
				
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
			
				$sql = "select dias from DIAS_NOPROD where dias = '$enero1_sgte'";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount == 0){		
					$sql = "insert into DIAS_NOPROD(dias,per_agno,sem_num) values ('$enero1_sgte',$periodo,$num_sem)";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				}	
				
				$sql = "select dias from DIAS_FERIADOS where dias = '$enero1_sgte'";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
				$rowcount = mysqli_num_rows($resultado);

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
			
				$sql = "select dias from DIAS_NOPROD where dias = '$mayo1'";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount == 0){		
					$sql = "insert into DIAS_NOPROD(dias,per_agno,sem_num) values ('$mayo1',$periodo,$num_sem)";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				}	
				
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
			
				$sql = "select dias from DIAS_NOPROD where dias = '$sept18'";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount == 0){		
					$sql = "insert into DIAS_NOPROD(dias,per_agno,sem_num) values ('$sept18',$periodo,$num_sem)";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				}	
				
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
			
				$sql = "select dias from DIAS_NOPROD where dias = '$sept19'";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount == 0){		
					$sql = "insert into DIAS_NOPROD(dias,per_agno,sem_num) values ('$sept19',$periodo,$num_sem)";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				}	
				
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
			
				$sql = "select dias from DIAS_NOPROD where dias = '$dic25'";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount == 0){		
					$sql = "insert into DIAS_NOPROD(dias,per_agno,sem_num) values ('$dic25',$periodo,$num_sem)";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				}	
				
				$sql = "select dias from DIAS_FERIADOS where dias = '$dic25'";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount == 0){		
					$sql = "insert into DIAS_FERIADOS(dias,per_agno,sem_num) values ('$dic25',$periodo,$num_sem)";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				}				
				
			}		
			
			mysqli_commit($link);
			
		}

		$resp = array('cod'=>'ok','operacion'=>$operacion);
		echo json_encode($resp);
		exit();

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
		//echo (new DateTime())->setISODate(2017, 5)->format('m');
	}

?>