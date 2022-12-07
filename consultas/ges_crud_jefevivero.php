<?php 

	include('coneccion.php');
	include('funciones_comunes.php');

	if(isset($_GET['data'])){

		$sql = "select j.UNDVIV_ID,j.USR_ID,UNDVIV_NOMBRE,USR_NOMBRE
		from JEFE_UNIDAD j join UNIDAD_VIVEROS u on j.UNDVIV_ID = u.UNDVIV_ID
		join USUARIOS us on us.usr_id = j.usr_id";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();

		while( $rows = mysqli_fetch_assoc($resultset) ) {
			//$data[] = $rows;
			
			$sql_areas = "SELECT a.AREA_ID,AREA_NOMBRE FROM AREAS_UNIDAD au JOIN AREA a ON a.AREA_ID = au.AREA_ID WHERE UNDVIV_ID = $rows[UNDVIV_ID] ORDER BY AREA_NOMBRE";
			$resultado = mysqli_query($link, $sql_areas) or die("database error:". mysqli_error($link));
			$area = '';
			$id_area = '';
			$i = 0;
			while( $rows_area = mysqli_fetch_assoc($resultado) ) {
				if($i == 0){
					$area = $rows_area[AREA_NOMBRE];
					$id_area = $rows_area[AREA_ID];
				}
				else{
					$area = $area.','.$rows_area[AREA_NOMBRE];
					$id_area = $id_area.','.$rows_area[AREA_ID];
				}
				$i++;
			}
		
			$data[] = 
			Array
			(
				'UNDVIV_ID' => $rows[UNDVIV_ID],
				'USR_ID' => $rows[USR_ID],
				'UNDVIV_NOMBRE' => $rows[UNDVIV_NOMBRE],
				'USR_NOMBRE' => $rows[USR_NOMBRE],					
				'AREAS' => $area,
				'AREAS_ID' => $id_area
			);				
	
		}
		
		
		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);
		

	}else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
	
			$undviv_id = $_POST['undviv_id'];
			$usr_id = $_POST['usr_id'];
			$area_id = $_POST['area_id'];
	
			if($undviv_id == "" or $usr_id == "" or $area_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			

			
				$sql = "select USR_NOMBRE
				from JEFE_UNIDAD j join UNIDAD_VIVEROS u on j.UNDVIV_ID = u.UNDVIV_ID
				join USUARIOS us on us.usr_id = j.usr_id
				where j.UNDVIV_ID = $undviv_id";		

				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount > 0){
				
					$fila = mysqli_fetch_row($resultado);
					$jefe = $fila[0];		
					$resp = array('cod'=>'error','desc'=>'Para esta unidad vivero ya se encuentra asignado jefe: '.$jefe);
					salida($resp);
				}	
			
			
			$areas_a_cargo = explode("," , $area_id);
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
			mysqli_autocommit($link, FALSE);
			foreach ($areas_a_cargo as $area) {
				$sql = "INSERT INTO AREAS_UNIDAD(undviv_id,area_id) VALUES ($undviv_id,$area)";	
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
			}	
			
			$sql = "insert into JEFE_UNIDAD(UNDVIV_ID, usr_id) 
			values ($undviv_id,$usr_id)";				
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
			
			mysqli_commit($link);						
		}
		
		elseif($operacion == 'UPDATE'){
			
			$h_undviv_id = $_POST['h_undviv_id'];
			$h_usr_id = $_POST['h_usr_id'];
			//$h_jefund_estado = $_POST['h_jefund_estado'];
			$undviv_id = $_POST['undviv_id'];
			$usr_id = $_POST['usr_id'];
			$area_id = $_POST['area_id'];
			
			if($undviv_id == "" or $usr_id == "" or $h_undviv_id == "" or $h_usr_id == "" or $area_id == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			if( $undviv_id <> $h_undviv_id ){
				$sql = "select USR_NOMBRE
				from JEFE_UNIDAD j join UNIDAD_VIVEROS u on j.UNDVIV_ID = u.UNDVIV_ID
				join USUARIOS us on us.usr_id = j.usr_id
				where j.UNDVIV_ID = $undviv_id";		

				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount > 0){
				
					$fila = mysqli_fetch_row($resultado);
					$jefe = $fila[0];		
					$resp = array('cod'=>'error','desc'=>'Para esta unidad vivero ya se encuentra asignado jefe: '.$jefe);
					salida($resp);
				}				
			}
			
			$areas_a_cargo = explode("," , $area_id);
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
			mysqli_autocommit($link, FALSE);

			//foreach ($competencias as $activ) {
				$sql = "DELETE FROM AREAS_UNIDAD WHERE undviv_id = $h_undviv_id";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));			
			//}
			
			foreach ($areas_a_cargo as $area) {
				$sql = "INSERT INTO AREAS_UNIDAD(undviv_id,area_id) VALUES ($undviv_id,$area)";	
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
			}			
			
			$sql = "update JEFE_UNIDAD set undviv_id = $undviv_id,usr_id = $usr_id
			where undviv_id = $h_undviv_id and usr_id = $h_usr_id";				
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
			
			mysqli_commit($link);			
	
		}	
		
		elseif($operacion == 'DELETE'){
			
			$h_undviv_id = $_POST['h_undviv_id'];
			//$h_usr_id = $_POST['h_usr_id'];
			
			if(/*$h_usr_id == "" or*/$h_undviv_id == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
			mysqli_autocommit($link, FALSE);
			
			$sql = "DELETE FROM AREAS_UNIDAD WHERE undviv_id = $h_undviv_id";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
			
			$sql = "delete from JEFE_UNIDAD where undviv_id = $h_undviv_id /*and usr_id = $h_usr_id*/";				
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));	
			
			mysqli_commit($link);
		}	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}

	
	//Retorna respuesta
	echo json_encode($resp);	

?>