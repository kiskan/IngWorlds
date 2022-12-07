<?php 

	include('coneccion.php');
	
	
	if(isset($_GET['data']) or isset($area)){
		session_start();
		//$sql = "select area_id,area_nombre from AREA";	
		$rut_supervisor = ($_SESSION['USR_TIPO'] == 'SUPERVISOR') ? $_SESSION['USR_RUT'] : "" ;
		$sql = "select distinct AREA.area_id, AREA.area_nombre from AREA 
		left join SUPERVISIONES as SUP ON SUP.area_id = AREA.area_id where (SUP.sup_rut = '$rut_supervisor' or '$rut_supervisor' = '' )";
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
					
		if(isset($_GET['data'])){
			$resp = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData"=>$data);
		}else{
			$load_areas = json_encode($data);
		}
		

	}
	
	
	
	
	//TODAS LAS AREAS Y SUS ACTIVIDADES RELACIONADAS
	elseif(isset($areasyactividades)){
	
		$sql = "select distinct a.area_id, area_nombre
		from AREA a 
		join ACTIVIDAD act on act.area_id = a.area_id
		order by area_nombre";		
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		$activ = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			
			$sql_subfam = "select distinct activ_id, activ_nombre
			from AREA a 
			join ACTIVIDAD act on act.area_id = a.area_id
			where a.area_id = $rows[area_id]
			order by activ_nombre";
			$resultado = mysqli_query($link, $sql_subfam) or die("database error:". mysqli_error($link));
			
			unset($activ);
			
			while( $rows_activ = mysqli_fetch_assoc($resultado) ) {
				$activ[] = $rows_activ;
			}			
			
			$data[] = 
			Array
			(
				'area_id' => $rows[area_id],
				'area_nombre' => $rows[area_nombre],
				'activ' => $activ
			);						
		}
		$load_areasyactividades = json_encode($data);
	}	
	
	
	
	
	
	
	
	
	elseif(isset($activ_extra)){
	
		$sql = "select area_id,area_nombre from AREA";	
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}

		$load_areas = json_encode($data);
	}	
	
	else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$area_nombre = $_POST['area_nombre'];
			
			if($area_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "insert into AREA(area_nombre) values ('$area_nombre')";
		}
		
		elseif($operacion == 'UPDATE'){
			
			$area_id = $_POST['area_id'];
			$area_nombre = $_POST['area_nombre'];
			
			if($area_id == "" or $area_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "update AREA set area_nombre = '$area_nombre' where area_id = $area_id";
		}	
		
		elseif($operacion == 'DELETE'){
			
			$area_id = $_POST['area_id'];
			
			if($area_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from AREA where area_id = $area_id";
		}	
		
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	if(!isset($area) and !isset($activ_extra) and !isset($areasyactividades)){
		include('funciones_comunes.php');
		//Retorna respuesta
		echo json_encode($resp);	
	}
	
	
/*	
	//Salida Forzosa
	function salida($resp){	
		echo json_encode($resp);
		exit();
	}*/
?>