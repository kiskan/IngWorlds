<?php 

	include('coneccion.php');
	//include('funciones_comunes.php');
	
	if(isset($_GET['data']) or isset($famactividades) ){
	
		$sql = "select distinct factiv_id, factiv_nombre from ACTIVIDAD_FAMILIA order by factiv_nombre";
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
			$load_famactividades = json_encode($data);
		}		
	}


	//TODAS LAS FAMILIAS DE ACTIVIDADES Y SUS SUBFAMILIAS RELACIONADAS
	elseif(isset($famysubactividades)){
	
		$sql = "select distinct af.factiv_id, factiv_nombre
		from ACTIVIDAD_FAMILIA af 
		join ACTIVIDAD_SUBFAMILIA asf on af.factiv_id = asf.factiv_id
		order by factiv_nombre";		
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		$subfam = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			
			$sql_subfam = "select distinct asf.sfactiv_id, asf.sfactiv_nombre
			from ACTIVIDAD_FAMILIA af 
			join ACTIVIDAD_SUBFAMILIA asf on af.factiv_id = asf.factiv_id
			where af.factiv_id = $rows[factiv_id]
			order by asf.sfactiv_nombre";
			$resultado = mysqli_query($link, $sql_subfam) or die("database error:". mysqli_error($link));
			
			unset($subfam);
			
			while( $rows_subfam = mysqli_fetch_assoc($resultado) ) {
				$subfam[] = $rows_subfam;
			}			
			
			$data[] = 
			Array
			(
				'factiv_id' => $rows[factiv_id],
				'factiv_nombre' => $rows[factiv_nombre],
				'subfam' => $subfam
			);						
		}
		$load_famysubactividades = json_encode($data);
	}

	
	
	else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$factiv_nombre = $_POST['factiv_nombre'];
			
			if($factiv_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "insert into ACTIVIDAD_FAMILIA(factiv_nombre) values ('$factiv_nombre')";
		}
		
		elseif($operacion == 'UPDATE'){
			
			$factiv_id = $_POST['factiv_id'];
			$factiv_nombre = $_POST['factiv_nombre'];
			
			if($factiv_id == "" or $factiv_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "update ACTIVIDAD_FAMILIA set factiv_nombre = '$factiv_nombre' where factiv_id = $factiv_id";
		}	
		
		elseif($operacion == 'DELETE'){
			
			$factiv_id = $_POST['factiv_id'];
			
			if($factiv_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from ACTIVIDAD_FAMILIA where factiv_id = $factiv_id";
		}	
		
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	if(!isset($famactividades) and !isset($famysubactividades)){
		include('funciones_comunes.php');
		//Retorna respuesta
		echo json_encode($resp);	
	}


?>