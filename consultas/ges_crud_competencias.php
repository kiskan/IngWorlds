<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['data'])){
	
		$sql = "SELECT DISTINCT CONCAT(OPER.OPER_NOMBRES,' ',OPER.OPER_PATERNO,' ',OPER.OPER_MATERNO) AS OPER_NOMBRE, AREA.AREA_NOMBRE, OPER.OPER_RUT, AREA.AREA_ID FROM ACTIVIDAD ACT JOIN AREA ON AREA.AREA_ID = ACT.AREA_ID JOIN COMPETENCIA AS COMP ON ACT.ACTIV_ID = COMP.ACTIV_ID JOIN OPERADOR AS OPER ON COMP.OPER_RUT = OPER.OPER_RUT WHERE ACT.ACTIV_STANDAR = 'N' ORDER BY COMP_FECHACT DESC";	
	 	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
	
		while( $rows = mysqli_fetch_assoc($resultset) ) {

			$sql_activ = "SELECT ACT.ACTIV_NOMBRE,ACT.ACTIV_ID FROM ACTIVIDAD ACT JOIN COMPETENCIA AS COMP ON ACT.ACTIV_ID = COMP.ACTIV_ID WHERE ACT.AREA_ID = $rows[AREA_ID] AND COMP.OPER_RUT = '$rows[OPER_RUT]' AND ACT.ACTIV_STANDAR = 'N'";
			$resultado = mysqli_query($link, $sql_activ) or die("database error:". mysqli_error($link));
			$activ = '';
			$id_activ = '';
			$i = 0;
			while( $rows_activ = mysqli_fetch_assoc($resultado) ) {
				if($i == 0){
					$activ = $rows_activ[ACTIV_NOMBRE];
					$id_activ = $rows_activ[ACTIV_ID];
				}
				else{
					$activ = $activ.','.$rows_activ[ACTIV_NOMBRE];
					$id_activ = $id_activ.','.$rows_activ[ACTIV_ID];
				}
				$i++;
			}
		
			$data[] = 
			Array
			(
				'OPER_NOMBRE' => $rows[OPER_NOMBRE],
				'AREA_NOMBRE' => $rows[AREA_NOMBRE],
				'ACTIV_COMPETENTES' => $activ,
				'ID_ACTIV_COMPETENTES' => $id_activ,
				'OPER_RUT' => $rows[OPER_RUT],
				'AREA_ID' => $rows[AREA_ID]
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

			$oper_rut = $_POST['oper_rut'];
			$activ_id = $_POST['activ_id'];

			if($oper_rut == "" or $activ_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}			
						
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');	
			$competencias = explode("," , $activ_id);
			mysqli_autocommit($link, FALSE);
			foreach ($competencias as $activ) {
				$sql = "INSERT INTO COMPETENCIA(OPER_RUT,ACTIV_ID) VALUES ('$oper_rut',$activ)";	
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
			}			
			mysqli_commit($link);
		}
		
		elseif($operacion == 'UPDATE'){
			
			$oper_rut = $_POST['oper_rut'];
			$activ_id = $_POST['activ_id'];
			
			$h_oper_rut = $_POST['h_oper_rut'];
			$h_activ_id = $_POST['h_activ_id'];			
			
			if($oper_rut == "" or $activ_id == "" or $h_oper_rut == "" or $h_activ_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}	
			
			$competencias = explode("," , $h_activ_id);
			$new_competencias = explode("," , $activ_id);
			
			
			$data = array();//Almacena elementos que sólo existen en competencias y no en new_competencias
			foreach ($competencias as $value1) {
				$encontrado=false;
				foreach ($new_competencias as $value2) {
					if ($value1 == $value2){
						$encontrado=true;
						$break;
					}
				}
				if ($encontrado == false){
					   $data[] = $value1;
				}
			}					
			
			foreach ($data as $activ) {
				$sql_sel_comp = "SELECT PLAN_DIA FROM PLANIFICACION_OPER WHERE OPER_RUT = '$h_oper_rut' AND ACTIV_ID = $activ";
				$resultado = mysqli_query($link,$sql_sel_comp);	
				$rowcount = mysqli_num_rows($resultado);
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Operador ingresado en planificación con competencia registrada.');
					salida($resp);			
				}
			}	
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');
			
			mysqli_autocommit($link, FALSE);

			foreach ($competencias as $activ) {
				$sql_del_comp = "DELETE FROM COMPETENCIA WHERE OPER_RUT = '$h_oper_rut' AND ACTIV_ID = $activ";
				$resultado = mysqli_query($link,$sql_del_comp)or die(salida_con_rollback($resp,$link));				
			}
			
			$competencias = explode("," , $activ_id);
			foreach ($competencias as $activ) {
				$sql = "INSERT INTO COMPETENCIA(OPER_RUT,ACTIV_ID) VALUES ('$oper_rut',$activ)";	
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
			}			
			mysqli_commit($link);

		}	
		
		elseif($operacion == 'DELETE'){
			
			$h_oper_rut = $_POST['h_oper_rut'];
			$h_activ_id = $_POST['h_activ_id'];	
			
			if($h_oper_rut == "" or $h_activ_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			
			$competencias = explode("," , $h_activ_id);
			
			foreach ($competencias as $activ) {
				$sql_sel_comp = "SELECT PLAN_DIA FROM PLANIFICACION_OPER WHERE OPER_RUT = '$h_oper_rut' AND ACTIV_ID = $activ";
				$resultado = mysqli_query($link,$sql_sel_comp);	
				$rowcount = mysqli_num_rows($resultado);
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Operador ingresado en planificación con competencia registrada.');
					salida($resp);			
				}
			}	
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');
			
			mysqli_autocommit($link, FALSE);

			foreach ($competencias as $activ) {
				$sql_del_comp = "DELETE FROM COMPETENCIA WHERE OPER_RUT = '$h_oper_rut' AND ACTIV_ID = $activ";
				$resultado = mysqli_query($link,$sql_del_comp)or die(salida_con_rollback($resp,$link));				
			}
					
			mysqli_commit($link);

		}		

		//$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');	
		//$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	//Retorna respuesta
	echo json_encode($resp);
	//exit();

?>