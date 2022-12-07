<?php 

	include('coneccion.php');
	include('funciones_comunes.php');

	if(isset($_GET['data'])){
	
		$sql = "select p.CATPROD_ID, PROD_COD, PROD_NOMBRE, c.CATPROD_NOMBRE, PROD_STOCK, PROD_STOCKMIN, PROD_UNIDAD, PROD_VALOR from PRODUCTOS p
		join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id where prod_stock is not null";	
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
			
			$prod_cod = $_POST['prod_cod'];
			$prod_stock = $_POST['prod_stock'];
		
			if($prod_cod == "" or $prod_stock == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}		
			
			$sql = "update PRODUCTOS set prod_stock = '$prod_stock'	where prod_cod = '$prod_cod'";
		}
		
		elseif($operacion == 'UPDATE'){
			
			$h_prod_cod = $_POST['h_prod_cod'];
			$prod_cod = $_POST['prod_cod'];
			$prod_stock = $_POST['prod_stock'];
		
			if($prod_cod == "" or $prod_stock == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}		
			
			$sql = "update PRODUCTOS set prod_stock = '$prod_stock'	where prod_cod = '$h_prod_cod'";
			
		}	
	/*	
		elseif($operacion == 'DELETE'){
			
			$h_prod_cod = $_POST['h_prod_cod'];
			
			if($h_prod_cod == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from PRODUCTOS where prod_cod = '$h_prod_cod'";
		}	
	*/	
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}

	
	//Retorna respuesta
	echo json_encode($resp);	

?>