<?php 

	include('coneccion.php');
	//include('funciones_comunes.php');
	
	if(isset($_GET['data']) or isset($famactividades) ){
	
		$sql = "select distinct af.factiv_id, sfactiv_id, factiv_nombre, sfactiv_nombre 
		from ACTIVIDAD_FAMILIA af 
		join ACTIVIDAD_SUBFAMILIA asf on af.factiv_id = asf.factiv_id
		";
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
	
	else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$factiv_id = $_POST['factiv_id'];
			$sfactiv_nombre = $_POST['sfactiv_nombre'];
			
			if($factiv_id == "" or $sfactiv_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "insert into ACTIVIDAD_SUBFAMILIA(factiv_id,sfactiv_nombre) values ($factiv_id,'$sfactiv_nombre')";
			/*
			$resp = array('cod'=>'error','desc'=>$sql);
			echo json_encode($resp);
			exit();*/
		}
		
		elseif($operacion == 'UPDATE'){
			
			$sfactiv_id = $_POST['sfactiv_id'];
			$factiv_id = $_POST['factiv_id'];
			$sfactiv_nombre = $_POST['sfactiv_nombre'];
			
			if($sfactiv_id == "" or $factiv_id == "" or $sfactiv_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "update ACTIVIDAD_SUBFAMILIA set factiv_id = $factiv_id,sfactiv_nombre = '$sfactiv_nombre' where sfactiv_id = $sfactiv_id";
		}	
		
		elseif($operacion == 'DELETE'){
			
			$sfactiv_id = $_POST['sfactiv_id'];
			
			if($sfactiv_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from ACTIVIDAD_SUBFAMILIA where sfactiv_id = $sfactiv_id";
		}	
		
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	if(!isset($famactividades)){
		include('funciones_comunes.php');
		//Retorna respuesta
		echo json_encode($resp);	
	}


?>