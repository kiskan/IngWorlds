<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	//session_start();
	
	if(isset($_POST['load_calendario'])){
		
		$per_agno = $_POST['per_agno'];
		//$per_agno = 2018;
		
		$meses = array("","ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");	
		//$semana = date('W',  mktime(0,0,0,$mes,$dia,$anio));        
					
		//1ero de enero año solicitado
		$enero1_numsem = date('W',mktime(0,0,0,1,1,$per_agno));//devuelve el número de semana
		$enero1_diasem = date('w',mktime(0,0,0,1,1,$per_agno));//devuelve el número de día dentro de la semana (0=domingo, #6=sabado)
		
		//31 de diciembre año solicitado
		$dic31_numsem = date('W',mktime(0,0,0,12,31,$per_agno));//devuelve el número de semana
		$dic31_diasem = date('w',mktime(0,0,0,12,31,$per_agno));//devuelve el número de día dentro de la semana (0=domingo, #6=sabado)		
		
		$total_sem = getIsoWeeksInYear($per_agno); //Total semanas en el año (52 ó 53)
				
		//días inhábiles
		$sql = "SELECT DATE_FORMAT(DIAS,'%Y%m%d') as FECHA FROM DIAS_FERIADOS WHERE per_agno = $per_agno";		
		$resultset = mysqli_query($link,$sql);	
		
		$k  = 0;
		//$fechas_inhabiles = '';
		$fechas_inhabiles = array();
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$fechas_inhabiles[$k] = $rows['FECHA'];
			$k++;		
		}		
		
		$sem_num = 0;
		$mes = 1;		
		while($mes <= 12){
			$num_semana = 0;
			if($mes < 10 ){			
				$month = '0'.$mes;
			}else{
				$month = $mes;
			}		
		
			$calendar.= '<div class="tabla_calendario col-sm-4">';
			$calendar.= '<div class="medium-12 text-center elmes"><span class="linkmes">'.$meses[$mes].'</span></div>';
			
			$calendar.= '<table>';
			$headings = array('SM','LU','MA','MI','JU','VI','SA','DO');
			
			$calendar.= '<tr class="calendar-row"><th>'.implode('</th><th>',$headings).'</th></tr>';
		 
			$dia_semana = date('w',mktime(0,0,0,$month,1,$per_agno));//(0=domingo,6=sabado)
			$dia_semana = ($dia_semana > 0) ? $dia_semana-1 : 6;//(0=lunes,6=domingo)
	
			$days_in_month = date('t',mktime(0,0,0,$month,1,$per_agno)); //Número de días del mes dado
			$days_in_this_week = 1;
			$day_counter = 0;
			
			$calendar.= '<tr>';
			$num_semana++;
			
			if($mes == 1){ //Enero
				$calendar.= '<td class="semana">'.intval($enero1_numsem).'</td>';
				if($enero1_numsem == 1){
					$sem_num++;
				}				
			}else{			 
				//Solo si es Lunes aumenta el día de semana
				if($dia_semana == 0){$sem_num++;}				
				$calendar.= '<td class="semana">'.$sem_num.'</td>';
			}
			
			if($mes == 1 and $enero1_numsem == 1){ //Enero - Semana 1
				$aux = 31 - $dia_semana + 1;
				for($x = 0; $x < $dia_semana; $x++){
					$calendar.= '<td>'.$aux.'</td>';
					$days_in_this_week++;$aux++;
				}			
			}else{
				for($x = 0; $x < $dia_semana; $x++){
					$calendar.= '<td> </td>';
					$days_in_this_week++;
				}			
			}
			
	
			for($list_day = 1; $list_day <= $days_in_month; $list_day++){
						
				if( ($mes == 1 and $sem_num == 0) or 	//Enero - Núm Semana 0 es 52,53 
					($mes == 12 and $sem_num == 1)	 	//Dic   - Núm Semana 1  
				){ 
					$calendar.= "<td><div class='tachado'>".$list_day."</div></td>";
				}else{
				
					$day_bd = ($list_day < 10)? '0'.$list_day:$list_day;	
					$id_celda = $per_agno.$month.$day_bd;	
					$addclase = '';
					if(in_array($id_celda, $fechas_inhabiles)) {
						$addclase = 'cell_select';
					}
				
					$calendar.= "<td class='calendar-day {$addclase}' id='{$id_celda}' onclick='clic_celda(this)'><div>".$list_day."</div></td>";
				}
				
				if($dia_semana == 6){
				
					$calendar.= '</tr>';
					if(($day_counter+1) != $days_in_month):
						$calendar.= '<tr>';
						
						$num_semana++;
						
						if($mes == 12 and $total_sem == $sem_num){
							$sem_num = 1;
						}else{
							$sem_num++;
						}
						
						$calendar.= '<td class="semana">'.$sem_num.'</td>';
					endif;
					$dia_semana = -1;
					$days_in_this_week = 0;
				}
				
				$days_in_this_week++; $dia_semana++; $day_counter++;
			}

			if($days_in_this_week < 8 && $days_in_this_week != 1){
			
				if($mes == 12 and $total_sem == $sem_num){ //Dic - última semana
					for($x = 1; $x <= (8 - $days_in_this_week); $x++):
						
						$day_bd = ($x < 10)? '0'.$x:$x;
						$per_agno_sgte = $per_agno + 1;
						$id_celda = $per_agno_sgte.'01'.$day_bd;	
						$addclase = '';
						if(in_array($id_celda, $fechas_inhabiles)) {
							$addclase = 'cell_select';
						}						
						
						$calendar.= "<td class='calendar-day {$addclase}' id='{$id_celda}' onclick='clic_celda(this)'><div>".$x."</div></td>";
					endfor;								
				}else{
					for($x = 1; $x <= (8 - $days_in_this_week); $x++):
						$calendar.= '<td> </td>';
					endfor;				
				}
					
			}

			$calendar.= '</tr>';
			
			while($num_semana < 6){
				$num_semana++;
				$calendar.= '<tr><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
				
			}
			
			$calendar.= '</table>';	
			$calendar.= '</div>';
			
			$mes++;
		}
		
		$resp = array('tabla'=>$calendar);		
		echo json_encode($resp);
	}
	elseif(isset($_POST['update_diasferiados'])){
	
		$per_agno = $_POST['per_agno'];
		$fechas_inhabiles = $_POST['fechas_inhabiles']; //añomesdia -> 20210109
		
		mysqli_autocommit($link, FALSE);
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');
		
		//Delete per_agno
		$sql_del = "DELETE FROM DIAS_FERIADOS WHERE PER_AGNO = $per_agno";
		$resultado = mysqli_query($link,$sql_del)or die(salida_con_rollback($resp,$link));			
		
		$dias = explode("," , $fechas_inhabiles);
		
		foreach ($dias as $dia) {
		/*
			string substr ( string $string , int $start [, int $length ] )
			Devuelve una parte del string definida por los parámetros start y length.				
			$rest = substr("abcdef", -3, 1); // devuelve "d"
		*/
		
			$mes = substr($dia, 4, 2);
			$dia_sem = substr($dia, 6, 2);
			$anio = substr($dia, 0, 4);
		
			$sem_num = date('W',  mktime(0,0,0,$mes,$dia_sem,$anio));//devuelve el número de semana
			
			$sql = "INSERT INTO DIAS_FERIADOS(DIAS, PER_AGNO, SEM_NUM) VALUES ('$dia',$per_agno,$sem_num)";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
		}	
	
		mysqli_commit($link);
	
		$resp = array('cod'=>'ok');
		echo json_encode($resp);
		exit();			
	}
	
	
	
	
	function getIsoWeeksInYear($year) {
		$date = new DateTime;
		$date->setISODate($year, 53);
		return ($date->format("W") === "53" ? 53 : 52);
	}	
	

?>