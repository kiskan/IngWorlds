<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['data'])){
	
		$sql = "select distinct asf.sfactiv_id, pactiv_id, factiv_nombre, sfactiv_nombre, pactiv_nombre 
		from ACTIVIDAD_FAMILIA af 
		join ACTIVIDAD_SUBFAMILIA asf on af.factiv_id = asf.factiv_id
		join ACTIVIDAD_PADRE ap on asf.sfactiv_id = ap.sfactiv_id
		";
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
	
	elseif(isset($_POST['subactiv_id'])){
		$sfactiv_id = $_POST['subactiv_id'];
		$sql = "select distinct pactiv_id, pactiv_nombre 
		from ACTIVIDAD_FAMILIA af 
		join ACTIVIDAD_SUBFAMILIA asf on af.factiv_id = asf.factiv_id
		join ACTIVIDAD_PADRE ap on asf.sfactiv_id = ap.sfactiv_id
		where ap.sfactiv_id = $sfactiv_id
		order by pactiv_nombre
		";
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
			
			$sfactiv_id = $_POST['sfactiv_id'];
			$pactiv_nombre = $_POST['pactiv_nombre'];
			
			if($sfactiv_id == "" or $pactiv_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "insert into ACTIVIDAD_PADRE(sfactiv_id,pactiv_nombre) values ($sfactiv_id,'$pactiv_nombre')";

		}
		
		elseif($operacion == 'UPDATE'){
			
			$pactiv_id = $_POST['pactiv_id'];
			$sfactiv_id = $_POST['sfactiv_id'];
			$pactiv_nombre = $_POST['pactiv_nombre'];
			
			if($sfactiv_id == "" or $pactiv_id == "" or $pactiv_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "update ACTIVIDAD_PADRE set sfactiv_id = $sfactiv_id,pactiv_nombre = '$pactiv_nombre' where pactiv_id = $pactiv_id";
		}	
		
		elseif($operacion == 'DELETE'){
			
			$pactiv_id = $_POST['pactiv_id'];
			
			if($pactiv_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from ACTIVIDAD_PADRE where pactiv_id = $pactiv_id";
		}	
		
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	//if(!isset($famactividades)){
		//include('funciones_comunes.php');
		//Retorna respuesta
		echo json_encode($resp);	
	//}


?>