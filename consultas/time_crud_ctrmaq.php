<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['data'])){
	
		$sql = "SELECT LINEA.LIN_NOMBRE, CTRMAQ_NOMBRE, CTRMAQ_DISPHR, 
		CTRMAQ_REND, LINEA.LIN_ID, CTRMAQ.CTRMAQ_ID 
		FROM CONTROL_MAQUINA CTRMAQ 
		JOIN LINEA ON LINEA.LIN_ID = CTRMAQ.LIN_ID 
		ORDER BY LINEA.LIN_NOMBRE,CTRMAQ_NOMBRE";
	 	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();

		while( $rows = mysqli_fetch_assoc($resultset) ) {
		
			$data[] = 
			Array
			(
				'LIN_NOMBRE' => $rows[LIN_NOMBRE],
				'CTRMAQ_NOMBRE' => $rows[CTRMAQ_NOMBRE],
				'CTRMAQ_DISPHR' => $rows[CTRMAQ_DISPHR],
				'CTRMAQ_REND' => str_replace(',00','',str_replace(".", ",",$rows[CTRMAQ_REND])),
				'LIN_ID' => $rows[LIN_ID],
				'CTRMAQ_ID' => $rows[CTRMAQ_ID]
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

			$lin_id = $_POST['lin_id'];
			$ctrmaq_nombre = $_POST['ctrmaq_nombre'];
			$ctrmaq_disphr = $_POST['ctrmaq_disphr'];
			$ctrmaq_rend = str_replace(",", ".",$_POST['ctrmaq_rend']);

			if($lin_id == "" or $ctrmaq_nombre == "" or $ctrmaq_disphr == "" or $ctrmaq_rend == ""){
				$resp = array('cod'=>'error','desc'=>'ingresar datos obligatorios');
				salida($resp);
			}			

			if(!is_numeric($ctrmaq_rend)){
				$resp = array('cod'=>'error','desc'=>'error: dato no numérico en rendmiento');
				salida($resp);
			}
							
			$sql = "INSERT INTO CONTROL_MAQUINA(LIN_ID, CTRMAQ_NOMBRE, CTRMAQ_DISPHR, CTRMAQ_REND) VALUES ($lin_id,'$ctrmaq_nombre',$ctrmaq_disphr,$ctrmaq_rend)";
					
		}
		
		elseif($operacion == 'UPDATE'){
			
			$ctrmaq_id = $_POST['ctrmaq_id'];
			$lin_id = $_POST['lin_id'];
			$ctrmaq_nombre = $_POST['ctrmaq_nombre'];
			$ctrmaq_disphr = $_POST['ctrmaq_disphr'];
			$ctrmaq_rend = str_replace(",", ".",$_POST['ctrmaq_rend']);

			if($ctrmaq_id == "" or $lin_id == "" or $ctrmaq_nombre == "" or $ctrmaq_disphr == "" or $ctrmaq_rend == ""){
				$resp = array('cod'=>'error','desc'=>'ingresar datos obligatorios');
				salida($resp);
			}	
			
			if(!is_numeric($ctrmaq_rend)){
				$resp = array('cod'=>'error','desc'=>'Error: dato no numérico en Meta');
				salida($resp);
			}
							
			$sql = "UPDATE CONTROL_MAQUINA SET LIN_ID = $lin_id, CTRMAQ_NOMBRE = '$ctrmaq_nombre', CTRMAQ_DISPHR = $ctrmaq_disphr, CTRMAQ_REND = $ctrmaq_rend  WHERE CTRMAQ_ID = $ctrmaq_id";
			
		}	
		
		elseif($operacion == 'DELETE'){
			
			$ctrmaq_id = $_POST['ctrmaq_id'];
			
			if($ctrmaq_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "DELETE FROM CONTROL_MAQUINA WHERE CTRMAQ_ID=$ctrmaq_id";

		}		

		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	//Retorna respuesta
	echo json_encode($resp);	

?>