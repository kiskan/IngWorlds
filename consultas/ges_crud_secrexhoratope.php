<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['per_agno'])){
		
		$sql = "SELECT 
		PER_AGNO,
		SEM_NUM, 
		DATE_FORMAT(DIA,'%d-%m-%Y') as DIA_PK,
		(ELT(WEEKDAY(DIA) + 1, 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO')) AS DIA_SEMANA,				
		HORA_TOPE
		FROM HORAS_TOPES 
		WHERE PER_AGNO =".$_GET['per_agno']."
		ORDER BY DIA ASC";	

		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();

		while( $rows = mysqli_fetch_assoc($resultset) ) {
		
			$data[] = 
			Array
			(
				'PER_AGNO' => $rows[PER_AGNO],
				'SEM_NUM' => $rows[SEM_NUM],
				'DIA' => $rows[DIA_PK],
				'DIA_SEMANA' => $rows[DIA_SEMANA],
				'HORA_TOPE' => $rows[HORA_TOPE]
			);	
						
		}

		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);	
		
		
		//Retorna respuesta
		echo json_encode($resp);
		exit();		
	}
	

	
	else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$dia = $_POST['dia'];
			$hora_tope = $_POST['hora_tope'];
			$chk_tope = $_POST['chk_tope'];
			
			$fecha_hora = date("Y-m-d",strtotime($dia)).' '.$hora_tope.':00';
						
			if($per_agno == "" or $sem_num == "" or $dia == "" or $hora_tope == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			$sql = "select 1 from HORAS_TOPES where DIA = '$dia'";
			$resultado = mysqli_query($link,$sql);
			
			if(mysqli_num_rows($resultado) > 0){
				$resp = array('cod'=>'error','desc'=>'Ya existe hora tope para este día');
				salida($resp);
			}
			
			if($chk_tope == "N"){
				$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
				$sql = "insert into HORAS_TOPES(PER_AGNO, SEM_NUM, DIA, HORA_TOPE, FECHA_HORA) values ($per_agno,$sem_num,'$dia','$hora_tope','$fecha_hora')";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
			}
			
			elseif($chk_tope == "S"){

				mysqli_autocommit($link, FALSE);
				
				$total_sem = getIsoWeeksInYear($per_agno);
				$diaSemana = date('N', strtotime($dia)) - 1; //1:Lunes, 2:Martes ....
				$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos.');

				while($total_sem >= $sem_num){
					
					$fechaReg  = date('Ymd', strtotime($per_agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT))); //1er día de la semana (lunes)
					
					if($diaSemana <> 0){
						$fechaReg = date('Ymd', strtotime($fechaReg.' '.$diaSemana.' day'));
					}
					
					$sql = "select 1 from HORAS_TOPES where DIA = '$fechaReg'";
					$resultado = mysqli_query($link,$sql);
					
					$fecha_hora = date("Y-m-d",strtotime($fechaReg)).' '.$hora_tope.':00';
					
					if(mysqli_num_rows($resultado) > 0){
						$sql = "update HORAS_TOPES set HORA_TOPE = '$hora_tope', FECHA_HORA = '$fecha_hora' where DIA = '$fechaReg'";
					}else{
						$sql = "insert into HORAS_TOPES(PER_AGNO, SEM_NUM, DIA, HORA_TOPE, FECHA_HORA) values ($per_agno,$sem_num,'$fechaReg','$hora_tope','$fecha_hora')";
					}
					
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
					$sem_num++;
				}
				
				mysqli_commit($link);
			}

			
		}
		
		elseif($operacion == 'UPDATE'){
			
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$dia = $_POST['dia'];
			$hora_tope = $_POST['hora_tope'];
			$chk_tope = $_POST['chk_tope'];
			
			$fecha_hora = date("Y-m-d",strtotime($dia)).' '.$hora_tope.':00';
						
			if($per_agno == "" or $sem_num == "" or $dia == "" or $hora_tope == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			if($chk_tope == "N"){
				$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
		
				//$sql = "update HORAS_TOPES set HORA_TOPE = '$hora_tope', FECHA_HORA = '$fecha_hora' where DIA = '$fechaReg'";
				$sql = "update HORAS_TOPES set HORA_TOPE = '$hora_tope', FECHA_HORA = '$fecha_hora' where DIA = '$solo_fecha'";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
			}
			
			elseif($chk_tope == "S"){

				mysqli_autocommit($link, FALSE);
				
				$total_sem = getIsoWeeksInYear($per_agno);
				$diaSemana = date('N', strtotime($dia)) - 1; //1:Lunes, 2:Martes ....
				$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos.');

				while($total_sem >= $sem_num){
					
					$fechaReg  = date('Ymd', strtotime($per_agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT))); //1er día de la semana (lunes)
					
					if($diaSemana <> 0){
						$fechaReg = date('Ymd', strtotime($fechaReg.' '.$diaSemana.' day'));
					}
					
					$sql = "select 1 from HORAS_TOPES where DIA = '$fechaReg'";
					$resultado = mysqli_query($link,$sql);
					
					$fecha_hora = date("Y-m-d",strtotime($fechaReg)).' '.$hora_tope.':00';
					
					if(mysqli_num_rows($resultado) > 0){
						$sql = "update HORAS_TOPES set HORA_TOPE = '$hora_tope', FECHA_HORA = '$fecha_hora' where DIA = '$fechaReg'";
					}else{
						$sql = "insert into HORAS_TOPES(PER_AGNO, SEM_NUM, DIA, HORA_TOPE, FECHA_HORA) values ($per_agno,$sem_num,'$fechaReg','$hora_tope','$fecha_hora')";
					}
					
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
					$sem_num++;
				}
				
				mysqli_commit($link);
			}			
			
			
		}	
		
		elseif($operacion == 'DELETE'){
			
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$dia = $_POST['dia'];
			$chk_tope = $_POST['chk_tope'];
			
			if($dia == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			
			
			
			if($chk_tope == "N"){
				$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
				$sql = "delete from HORAS_TOPES where dia = '$dia'";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
			}
			
			elseif($chk_tope == "S"){

				mysqli_autocommit($link, FALSE);
				
				$total_sem = getIsoWeeksInYear($per_agno);
				$diaSemana = date('N', strtotime($dia)) - 1; //1:Lunes, 2:Martes ....
				$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos.');

				while($total_sem >= $sem_num){
					
					$fechaReg  = date('Ymd', strtotime($per_agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT))); //1er día de la semana (lunes)
					
					if($diaSemana <> 0){
						$fechaReg = date('Ymd', strtotime($fechaReg.' '.$diaSemana.' day'));
					}
					
					$sql = "delete from HORAS_TOPES where dia = '$fechaReg'";
					
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
					$sem_num++;
				}
				
				mysqli_commit($link);
			}				
			
			
			
			
			
			
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

?>