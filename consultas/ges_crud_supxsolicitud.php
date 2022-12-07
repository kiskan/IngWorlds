<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['data'])){
	
		$sup_rut = $_GET['sup_rut'];
	
		$sql = "SELECT SACTIV_ID, DATE_FORMAT(SACTIV_DIA,'%d-%m-%Y') as SACTIV_DIA, SACTIV.ACTIV_ID, ACTIV.ACTIV_NOMBRE, AREA.AREA_ID, AREA.AREA_NOMBRE, SACTIV_OPCION, SACTIV_MOTIVO, SACTIV_ESTADO, SACTIV_COMENTARIO, 
		CONCAT(SUP.SUP_NOMBRES,' ',SUP.SUP_PATERNO,' ',SUP.SUP_MATERNO) AS SUPERVISOR, USR.USR_NOMBRE
		FROM SOLIC_ACTIVIDAD AS SACTIV
		JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = SACTIV.ACTIV_ID
		JOIN AREA ON AREA.AREA_ID = ACTIV.AREA_ID
		JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = SACTIV.SUP_RUT 
		LEFT JOIN USUARIOS AS USR ON USR.USR_ID = SACTIV.USR_ID_RESP
		WHERE SACTIV.SEM_NUM =".$_GET['data']." AND SACTIV.PER_AGNO =".$_GET['per_agno']."  AND (SACTIV.SUP_RUT = '$sup_rut' OR '$sup_rut' = '')
		ORDER BY SACTIV_DIA ASC";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		
		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);	

	}

	else{
		
		$operacion = $_POST['operacion'];

		if($operacion == 'INSERT'){
				
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$sactiv_dia = $_POST['sactiv_dia'];			
			$sactiv_opcion = $_POST['sactiv_opcion'];
			$activ_id = $_POST['activ_id'];
			$sactiv_motivo = $_POST['sactiv_motivo'];
			$sup_rut = $_POST['sup_rut'];
							
			if($per_agno == "" or $sem_num == "" or $sactiv_dia == "" or $sactiv_opcion == "" or $activ_id == "" or $sactiv_motivo == "" or $sup_rut == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}

			$sql_ins_sol = "INSERT INTO SOLIC_ACTIVIDAD(SACTIV_DIA, SEM_NUM, PER_AGNO, ACTIV_ID, SUP_RUT, SACTIV_OPCION, SACTIV_MOTIVO, SACTIV_ESTADO) VALUES ('$sactiv_dia',$sem_num,$per_agno, $activ_id,'$sup_rut','$sactiv_opcion','$sactiv_motivo','PENDIENTE')";

			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
			$resultado = mysqli_query($link,$sql_ins_sol)or die(salida($resp));			
	
		}
		
		elseif($operacion == 'UPDATE'){
		
			$sactiv_id = $_POST['sactiv_id'];
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$sactiv_dia = $_POST['sactiv_dia'];			
			$sactiv_opcion = $_POST['sactiv_opcion'];
			$activ_id = $_POST['activ_id'];
			$sactiv_motivo = $_POST['sactiv_motivo'];
			$sup_rut = $_POST['sup_rut'];
							
			if($sactiv_id == "" or $per_agno == "" or $sem_num == "" or $sactiv_dia == "" or $sactiv_opcion == "" or $activ_id == "" or $sactiv_motivo == "" or $sup_rut == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}

			$sql_upd_sol = "UPDATE SOLIC_ACTIVIDAD SET SACTIV_DIA='$sactiv_dia', SEM_NUM=$sem_num, PER_AGNO=$per_agno, ACTIV_ID=$activ_id, SUP_RUT='$sup_rut', SACTIV_OPCION='$sactiv_opcion', SACTIV_MOTIVO='$sactiv_motivo' WHERE SACTIV_ID = $sactiv_id";

			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
			$resultado = mysqli_query($link,$sql_upd_sol)or die(salida($resp));			
		}
		
		elseif($operacion == 'DELETE'){
			
			$sactiv_id = $_POST['sactiv_id'];
			
			if($sactiv_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
			
			$sql_del_oper = "DELETE FROM SOLIC_ACTIVIDAD WHERE SACTIV_ID = $sactiv_id";
			$resultado = mysqli_query($link,$sql_del_oper)or die(salida($resp));
		}		

		$resp = array('cod'=>'ok','operacion'=>$operacion);		
			
	}
	
	
	//Retorna respuesta
	echo json_encode($resp);
	exit();		
	
	
?>