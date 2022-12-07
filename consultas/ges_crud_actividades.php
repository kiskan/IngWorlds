<?php 

	include('coneccion.php');

	if(isset($_GET['data'])){
	
		$sql = "SELECT ACTIV.ACTIV_ID, ACTIV.AREA_ID, ACTIV.UND_ID, AREA.AREA_NOMBRE, ACTIV.ACTIV_NOMBRE, UND.UND_NOMBRE, ACTIV.ACTIV_STANDAR, ACTIV.ACTIV_TIPO
				FROM ACTIVIDAD AS ACTIV 
				JOIN AREA ON ACTIV.AREA_ID = AREA.AREA_ID 
				LEFT JOIN UNIDAD AS UND ON ACTIV.UND_ID = UND.UND_ID
				ORDER BY ACTIV.ACTIV_FECHACT DESC, ACTIV.AREA_ID ASC";	
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
	/*
		echo('<pre>');
		print_r(json_encode($data));
		echo('</pre>');
	*/	
	}
	elseif(isset($_POST['met_area'])){
		$met_area = $_POST['met_area'];
		$sql = "SELECT ACTIV.ACTIV_ID, CONCAT(ACTIV.ACTIV_NOMBRE,' (UNIDAD:', UND.UND_NOMBRE,')') AS ACTIV_NOMBRE
				FROM ACTIVIDAD AS ACTIV 
				JOIN AREA ON ACTIV.AREA_ID = AREA.AREA_ID 
				JOIN UNIDAD AS UND ON ACTIV.UND_ID = UND.UND_ID
				WHERE ACTIV.AREA_ID = $met_area
				ORDER BY ACTIV.ACTIV_NOMBRE ASC";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}
	elseif(isset($_POST['activ_comp'])){
		$area_id = $_POST['area_id'];
		$sql = "SELECT ACTIV.ACTIV_ID, CONCAT(ACTIV.ACTIV_NOMBRE,' (UNIDAD:', UND.UND_NOMBRE,')') AS ACTIV_NOMBRE
				FROM ACTIVIDAD AS ACTIV 
				JOIN AREA ON ACTIV.AREA_ID = AREA.AREA_ID 
				JOIN UNIDAD AS UND ON ACTIV.UND_ID = UND.UND_ID
				WHERE ACTIV.AREA_ID = $area_id AND ACTIV.ACTIV_STANDAR = 'N'
				ORDER BY ACTIV.ACTIV_NOMBRE ASC";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}

	elseif(isset($_POST['sup_replanificacion'])){
		$activ_id = $_POST['activ_id'];
		$sql = "SELECT ACTIV.ACTIV_ID, ACTIV.ACTIV_NOMBRE, ACTIV.ACTIV_STANDAR
				FROM ACTIVIDAD AS ACTIV 
				WHERE ACTIV.ACTIV_ID = $activ_id";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}	
	
	elseif(isset($_POST['sol_activ'])){
		$sactiv_dia = $_POST['sactiv_dia'];
		$sactiv_opcion = $_POST['sactiv_opcion'];
		$area_id = $_POST['area_id'];
		$rut_supervisor = $_POST['rut_supervisor'];
		
		if($sactiv_opcion == 'INGRESAR NUEVA ACTIVIDAD'){
			$sql = "SELECT ACTIV.ACTIV_ID,ACTIV.ACTIV_NOMBRE 
					FROM ACTIVIDAD AS ACTIV 
					JOIN AREA ON ACTIV.AREA_ID = AREA.AREA_ID 
					WHERE ACTIV.AREA_ID = $area_id AND ACTIV.ACTIV_ID NOT IN (
						SELECT PLAN.ACTIV_ID FROM PLANIFICACION AS PLAN WHERE PLAN.PLAN_DIA = '$sactiv_dia' AND (PLAN.SUP_RUT = '$rut_supervisor' OR '$rut_supervisor' = '' )
					)
					ORDER BY ACTIV.ACTIV_NOMBRE ASC";				
		}else{
			$sql = "SELECT ACTIV.ACTIV_ID,ACTIV.ACTIV_NOMBRE 
					FROM ACTIVIDAD AS ACTIV 
					JOIN AREA ON ACTIV.AREA_ID = AREA.AREA_ID 
					JOIN PLANIFICACION AS PLAN ON PLAN.PLAN_DIA = '$sactiv_dia' AND PLAN.ACTIV_ID = ACTIV.ACTIV_ID
					WHERE ACTIV.AREA_ID = $area_id AND (PLAN.SUP_RUT = '$rut_supervisor' OR '$rut_supervisor' = '' )
					ORDER BY ACTIV.ACTIV_NOMBRE ASC";		
		}		
	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}	
	
	elseif(isset($_POST['plan_area'])){
		$plan_area = $_POST['plan_area'];
		$fecha_dia = $_POST['fecha_dia'];
		
		$sql = "SELECT CONCAT(ACTIV.ACTIV_ID,'---',IFNULL(UND.UND_NOMBRE,0),'---',IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),0),'---',ACTIV.ACTIV_STANDAR) AS ACTIV_ID, ACTIV.ACTIV_NOMBRE AS ACTIV_NOMBRE
				FROM ACTIVIDAD AS ACTIV 
				JOIN AREA ON ACTIV.AREA_ID = AREA.AREA_ID 
				LEFT JOIN UNIDAD AS UND ON ACTIV.UND_ID = UND.UND_ID
				LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND '$fecha_dia'>= MET.MET_INIVIG AND (MET.MET_FINVIG IS NULL OR '$fecha_dia'<= MET.MET_FINVIG)
				WHERE ACTIV.AREA_ID = $plan_area
				ORDER BY ACTIV.ACTIV_NOMBRE ASC";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}	

	elseif(isset($_POST['plan_area_extra'])){
		$plan_area = $_POST['plan_area_extra'];
		
		$sql = "SELECT CONCAT(ACTIV.ACTIV_ID,'---',ACTIV.ACTIV_STANDAR) AS ACTIV_ID, ACTIV.ACTIV_NOMBRE AS ACTIV_NOMBRE
				FROM ACTIVIDAD AS ACTIV 
				JOIN AREA ON ACTIV.AREA_ID = AREA.AREA_ID 
				WHERE ACTIV.AREA_ID = $plan_area
				ORDER BY ACTIV.ACTIV_NOMBRE ASC";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}
	
	elseif(isset($_POST['plan_maestro'])){
		$plan_area = $_POST['plan_maestro'];
		$fecha_dia = $_POST['fecha_dia'];
		
		$sql = "SELECT CONCAT(ACTIV.ACTIV_ID,'---',IFNULL(UND.UND_NOMBRE,0),'---',IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),0),'---',ACTIV.ACTIV_TIPO) AS ACTIV_ID, ACTIV.ACTIV_NOMBRE AS ACTIV_NOMBRE
				FROM ACTIVIDAD AS ACTIV 
				JOIN AREA ON ACTIV.AREA_ID = AREA.AREA_ID 
				LEFT JOIN UNIDAD AS UND ON ACTIV.UND_ID = UND.UND_ID
				LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND '$fecha_dia'>= MET.MET_INIVIG AND (MET.MET_FINVIG IS NULL OR '$fecha_dia'<= MET.MET_FINVIG)
				WHERE ACTIV.AREA_ID = $plan_area AND ACTIV.ACTIV_ID NOT IN (240, 241, 227, 228)
				ORDER BY ACTIV.ACTIV_TIPO desc, ACTIV.ACTIV_NOMBRE asc";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}		
	
	
	else{
	

		$operacion = $_POST['operacion'];

		if($operacion == 'INSERT'){
		
			$activ_area = $_POST['activ_area'];
			$activ_nombre = $_POST['activ_nombre'];
			$activ_unidad = $_POST['activ_unidad'];			
			$activ_unidad = !empty($activ_unidad) ? "$activ_unidad" : "NULL";
			$activ_standar = $_POST['activ_standar'];
			$activ_tipo = $_POST['activ_tipo'];
			
			if($activ_area == "" or $activ_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "INSERT INTO ACTIVIDAD(AREA_ID, UND_ID, ACTIV_NOMBRE, ACTIV_STANDAR, ACTIV_TIPO) VALUES ($activ_area,$activ_unidad,'$activ_nombre','$activ_standar', '$activ_tipo')";
		}
		
		elseif($operacion == 'UPDATE'){
			
			$activ_id = $_POST['activ_id'];
			$activ_area = $_POST['activ_area'];
			$activ_nombre = $_POST['activ_nombre'];
			$activ_unidad = $_POST['activ_unidad'];			
			$activ_unidad = !empty($activ_unidad) ? "$activ_unidad" : "NULL";
			$activ_standar = $_POST['activ_standar'];
			$activ_tipo = $_POST['activ_tipo'];
			
			if($activ_id == "" or $activ_area == "" or $activ_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "update ACTIVIDAD set AREA_ID = $activ_area, UND_ID = $activ_unidad, ACTIV_NOMBRE = '$activ_nombre', ACTIV_STANDAR = '$activ_standar', ACTIV_TIPO = '$activ_tipo' where ACTIV_ID = $activ_id";
		}	
		
		elseif($operacion == 'DELETE'){
			
			$activ_id = $_POST['activ_id'];
			
			if($activ_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from ACTIVIDAD where ACTIV_ID = $activ_id";
		}	
	
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	//Retorna respuesta
	echo json_encode($resp);	
	
	//Salida Forzosa
	function salida($resp){	
		echo json_encode($resp);
		exit();
	}
?>