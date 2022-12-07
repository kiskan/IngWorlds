<?php 

	include('coneccion.php');
	//session_start();
	
	if(isset($cc)){
	
		$sql = "select cc_id,cc_nombre from CUENTA_CONTABLE";	
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}

		$load_cc = json_encode($data);
	}	
	
	if(isset($_GET['data']) or isset($categoria)){

		$sql = "select distinct catprod_id, catprod_nombre from CATEGORIA_PRODUCTO ";
		
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
			$load_categorias = json_encode($data);
		}		
	}	
/*	
	elseif(isset($cc)){
	
		$sql = "select cc_id,cc_nombre from CUENTA_CONTABLE";	
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}

		$load_cc = json_encode($data);
	}		
*/	
	else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$catprod_nombre = $_POST['catprod_nombre'];
			
			if($catprod_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "insert into CATEGORIA_PRODUCTO(catprod_nombre) values ('$catprod_nombre')";
		}
		
		elseif($operacion == 'UPDATE'){
			
			$catprod_id = $_POST['catprod_id'];
			$catprod_nombre = $_POST['catprod_nombre'];
			
			if($catprod_id == "" or $catprod_nombre == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "update CATEGORIA_PRODUCTO set catprod_nombre = '$catprod_nombre' where catprod_id = $catprod_id";
		}	
		
		elseif($operacion == 'DELETE'){
			
			$catprod_id = $_POST['catprod_id'];
			
			if($catprod_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from CATEGORIA_PRODUCTO where catprod_id = $catprod_id";
		}	
		
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	if(!isset($categoria) and !isset($cc)){
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