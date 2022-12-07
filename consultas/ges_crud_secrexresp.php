<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['per_agno'])){
		
		$sql = "SELECT 
		PER_AGNO,
		SEM_NUM, 				
		RESP_PROD, RESP_PRODXFONO,
		BRIGAD_SAB, BRIGAD_SABXFONO,
		BRIGAD_DOM, BRIGAD_DOMXFONO,
		RESP_MAN1, RESP_MANXFONO1,
		RESP_MAN2, RESP_MANXFONO2
		FROM RESP_FDS 
		WHERE PER_AGNO =".$_GET['per_agno']."
		ORDER BY SEM_NUM ASC";	

		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();

		while( $rows = mysqli_fetch_assoc($resultset) ) {
		
			$data[] = 
			Array
			(
				'PER_AGNO' => $rows[PER_AGNO],
				'SEM_NUM' => $rows[SEM_NUM],
				'RESP_PROD' => $rows[RESP_PROD],
				'RESP_PRODXFONO' => $rows[RESP_PRODXFONO],
				'BRIGAD_SAB' => $rows[BRIGAD_SAB],
				'BRIGAD_SABXFONO' => $rows[BRIGAD_SABXFONO],
				'BRIGAD_DOM' => $rows[BRIGAD_DOM],
				'BRIGAD_DOMXFONO' => $rows[BRIGAD_DOMXFONO],
				'RESP_MAN1' => $rows[RESP_MAN1],
				'RESP_MANXFONO1' => $rows[RESP_MANXFONO1],
				'RESP_MAN2' => $rows[RESP_MAN2],
				'RESP_MANXFONO2' => $rows[RESP_MANXFONO2]				
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

			$RESP_PROD = $_POST['RESP_PROD'];
			$RESP_PRODXFONO = $_POST['RESP_PRODXFONO'];
			$BRIGAD_SAB = $_POST['BRIGAD_SAB'];
			$BRIGAD_SABXFONO = $_POST['BRIGAD_SABXFONO'];							
			$BRIGAD_DOM = $_POST['BRIGAD_DOM'];
			$BRIGAD_DOMXFONO = $_POST['BRIGAD_DOMXFONO'];
			$RESP_MAN1 = $_POST['RESP_MAN1'];
			$RESP_MANXFONO1 = $_POST['RESP_MANXFONO1'];							
			$RESP_MAN2 = $_POST['RESP_MAN2'];
			$RESP_MANXFONO2 = $_POST['RESP_MANXFONO2'];		
			
			$chk_tope = $_POST['chk_tope'];
			
						
			if($per_agno == "" or $sem_num == ""){ //falta ingresar los demas datos obligatorios que los cubre JS
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			if($chk_tope == "N"){
				$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
				$sql = "insert into RESP_FDS values ($per_agno,$sem_num,'$RESP_PROD','$RESP_PRODXFONO','$BRIGAD_SAB','$BRIGAD_SABXFONO','$BRIGAD_DOM','$BRIGAD_DOMXFONO','$RESP_MAN1','$RESP_MANXFONO1','$RESP_MAN2','$RESP_MANXFONO2')";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
			}
			
			elseif($chk_tope == "S"){

				mysqli_autocommit($link, FALSE);
				
				$total_sem = getIsoWeeksInYear($per_agno);
				$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos.');

				while($total_sem >= $sem_num){
					
					$sql = "select 1 from RESP_FDS where PER_AGNO = $per_agno AND SEM_NUM = $sem_num";
					$resultado = mysqli_query($link,$sql);
					
					if(mysqli_num_rows($resultado) > 0){
						$sql = "update RESP_FDS set RESP_PROD = '$RESP_PROD', RESP_PRODXFONO = '$RESP_PRODXFONO', BRIGAD_SAB = '$BRIGAD_SAB', BRIGAD_SABXFONO = '$BRIGAD_SABXFONO', BRIGAD_DOM = '$BRIGAD_DOM', BRIGAD_DOMXFONO = '$BRIGAD_DOMXFONO', RESP_MAN1 = '$RESP_MAN1', RESP_MANXFONO1 = '$RESP_MANXFONO1', RESP_MAN2 = '$RESP_MAN2', RESP_MANXFONO2 = '$RESP_MANXFONO2' where PER_AGNO = $per_agno AND SEM_NUM = $sem_num";
					}else{
						$sql = "insert into RESP_FDS values ($per_agno,$sem_num,'$RESP_PROD','$RESP_PRODXFONO','$BRIGAD_SAB','$BRIGAD_SABXFONO','$BRIGAD_DOM','$BRIGAD_DOMXFONO','$RESP_MAN1','$RESP_MANXFONO1','$RESP_MAN2','$RESP_MANXFONO2')";
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
			$RESP_PROD = $_POST['RESP_PROD'];
			$RESP_PRODXFONO = $_POST['RESP_PRODXFONO'];
			$BRIGAD_SAB = $_POST['BRIGAD_SAB'];
			$BRIGAD_SABXFONO = $_POST['BRIGAD_SABXFONO'];							
			$BRIGAD_DOM = $_POST['BRIGAD_DOM'];
			$BRIGAD_DOMXFONO = $_POST['BRIGAD_DOMXFONO'];
			$RESP_MAN1 = $_POST['RESP_MAN1'];
			$RESP_MANXFONO1 = $_POST['RESP_MANXFONO1'];							
			$RESP_MAN2 = $_POST['RESP_MAN2'];
			$RESP_MANXFONO2 = $_POST['RESP_MANXFONO2'];	
			$chk_tope = $_POST['chk_tope'];
			
			if($per_agno == "" or $sem_num == ""){ //falta ingresar los demas datos obligatorios que los cubre JS
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			if($chk_tope == "N"){
				$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
				$sql = "update RESP_FDS set RESP_PROD = '$RESP_PROD', RESP_PRODXFONO = '$RESP_PRODXFONO', BRIGAD_SAB = '$BRIGAD_SAB', BRIGAD_SABXFONO = '$BRIGAD_SABXFONO', BRIGAD_DOM = '$BRIGAD_DOM', BRIGAD_DOMXFONO = '$BRIGAD_DOMXFONO', RESP_MAN1 = '$RESP_MAN1', RESP_MANXFONO1 = '$RESP_MANXFONO1', RESP_MAN2 = '$RESP_MAN2', RESP_MANXFONO2 = '$RESP_MANXFONO2' where PER_AGNO = $per_agno AND SEM_NUM = $sem_num";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
			}
			
			elseif($chk_tope == "S"){

				mysqli_autocommit($link, FALSE);
				
				$total_sem = getIsoWeeksInYear($per_agno);
				$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos.');

				while($total_sem >= $sem_num){
					
					$sql = "select 1 from RESP_FDS where PER_AGNO = $per_agno AND SEM_NUM = $sem_num";
					$resultado = mysqli_query($link,$sql);
					
					if(mysqli_num_rows($resultado) > 0){
						$sql = "update RESP_FDS set RESP_PROD = '$RESP_PROD', RESP_PRODXFONO = '$RESP_PRODXFONO', BRIGAD_SAB = '$BRIGAD_SAB', BRIGAD_SABXFONO = '$BRIGAD_SABXFONO', BRIGAD_DOM = '$BRIGAD_DOM', BRIGAD_DOMXFONO = '$BRIGAD_DOMXFONO', RESP_MAN1 = '$RESP_MAN1', RESP_MANXFONO1 = '$RESP_MANXFONO1', RESP_MAN2 = '$RESP_MAN2', RESP_MANXFONO2 = '$RESP_MANXFONO2' where PER_AGNO = $per_agno AND SEM_NUM = $sem_num";
					}else{
						$sql = "insert into RESP_FDS values ($per_agno,$sem_num,'$RESP_PROD','$RESP_PRODXFONO','$BRIGAD_SAB','$BRIGAD_SABXFONO','$BRIGAD_DOM','$BRIGAD_DOMXFONO','$RESP_MAN1','$RESP_MANXFONO1','$RESP_MAN2','$RESP_MANXFONO2')";
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

			$chk_tope = $_POST['chk_tope'];
			
			if($per_agno == "" or $sem_num == ""){ 
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
	
			if($chk_tope == "N"){
				$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
				$sql = "delete from RESP_FDS where PER_AGNO = $per_agno AND SEM_NUM = $sem_num";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
			}
			
			elseif($chk_tope == "S"){

				mysqli_autocommit($link, FALSE);
				
				$total_sem = getIsoWeeksInYear($per_agno);
				$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos.');

				while($total_sem >= $sem_num){
					
					$sql = "delete from RESP_FDS where PER_AGNO = $per_agno AND SEM_NUM = $sem_num";
					
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