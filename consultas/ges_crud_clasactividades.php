<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['data'])){
	
		$sql = "select distinct asf.sfactiv_id, ac.pactiv_id, ac.tactiv_id, factiv_nombre, sfactiv_nombre, pactiv_nombre, tactiv_nombre 
		from ACTIVIDAD_FAMILIA af 
		join ACTIVIDAD_SUBFAMILIA asf on af.factiv_id = asf.factiv_id
		join ACTIVIDAD_PADRE ap on asf.sfactiv_id = ap.sfactiv_id
		join ACTIVIDAD_CLASIFICACION ac on ac.pactiv_id = ap.pactiv_id
		join ACTIVIDAD_TIPO at on ac.tactiv_id = at.tactiv_id
		order by factiv_nombre
		";
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
/*	
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}		
*/

		while( $rows = mysqli_fetch_assoc($resultset) ) {

			$sql = "select distinct act.activ_id, act.activ_nombre 
			from ACTIVIDAD_CLASIFICACION ac 
			join ACTIVIDAD act on ac.activ_id = act.activ_id
			where ac.pactiv_id = $rows[pactiv_id] and ac.tactiv_id = $rows[tactiv_id]
			order by act.activ_nombre
			";
			$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$activ = '';
			$id_activ = '';
			$i = 0;
			while( $rows_activ = mysqli_fetch_assoc($resultado) ) {
				if($i == 0){
					$activ = $rows_activ[activ_nombre];
					$id_activ = $rows_activ[activ_id];
				}
				else{
					$activ = $activ.','.$rows_activ[activ_nombre];
					$id_activ = $id_activ.','.$rows_activ[activ_id];
				}
				$i++;
			}
		
			$data[] = 
			Array
			(
				'sfactiv_id' => $rows[sfactiv_id],
				'pactiv_id' => $rows[pactiv_id],
				'activ_id' => $id_activ,
				'tactiv_id' => $rows[tactiv_id],
				'factiv_nombre' => $rows[factiv_nombre],
				'sfactiv_nombre' => $rows[sfactiv_nombre],
				'pactiv_nombre' => $rows[pactiv_nombre],
				'tactiv_nombre' => $rows[tactiv_nombre],
				'activ_nombre' => $activ
			);			
		}				

		//if(isset($_GET['data'])){		
			$resp = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData"=>$data);	/*
		}else{
			$load_famactividades = json_encode($data);
		}		*/
	}	
	
	else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$pactiv_id = $_POST['pactiv_id'];
			$activ_id = $_POST['activ_id']; //id de actividades separados por coma
			$tactiv_id = $_POST['tactiv_id'];
			
			if($pactiv_id == "" or $activ_id == "" or $tactiv_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			/*
			$sql = "SELECT 1 FROM ACTIVIDAD_CLASIFICACION where pactiv_id = $pactiv_id AND activ_id = $activ_id AND tactiv_id = $tactiv_id ";
			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){
				
				$resp = array('cod'=>'error','desc'=>'Ya existe esta clasificación de actividad');
				salida($resp);
			}			
			
			$sql = "insert into ACTIVIDAD_CLASIFICACION(pactiv_id,activ_id,tactiv_id) values ($pactiv_id,$activ_id,$tactiv_id)";
*/		
						
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');	
			$clasificaciones = explode("," , $activ_id);
			mysqli_autocommit($link, FALSE);
			foreach ($clasificaciones as $activ) {
				
				//$sql = "SELECT 1 FROM ACTIVIDAD_CLASIFICACION where pactiv_id = $pactiv_id AND activ_id = $activ AND tactiv_id = $tactiv_id ";
				$sql = "SELECT 1 FROM ACTIVIDAD_CLASIFICACION where activ_id = $activ";
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount > 0){					
					$resp = array('cod'=>'error','desc'=>'La(s) actividad(es) a ingresar ya posee(n) registrada(s) una Clasificación');
					salida_con_rollback($resp,$link);
					break;
				}				
				
				$sql = "insert into ACTIVIDAD_CLASIFICACION(pactiv_id,activ_id,tactiv_id) values ($pactiv_id,$activ,$tactiv_id)";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
			}			
			mysqli_commit($link);



		}
		
		elseif($operacion == 'UPDATE'){
			
			$pactiv_id = $_POST['pactiv_id'];
			$activ_id = $_POST['activ_id'];
			$tactiv_id = $_POST['tactiv_id'];
			
			$h_pactiv_id = $_POST['h_pactiv_id'];
			$h_tactiv_id = $_POST['h_tactiv_id'];
			$h_activ_id = $_POST['h_activ_id'];			

			if($pactiv_id == "" or $activ_id == "" or $tactiv_id == "" or $h_pactiv_id == "" or $h_tactiv_id == "" or $h_activ_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
		
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');
			
			mysqli_autocommit($link, FALSE);
			
			$clasificaciones = explode("," , $h_activ_id);
			foreach ($clasificaciones as $activ) {
				$sql = "DELETE FROM ACTIVIDAD_CLASIFICACION WHERE pactiv_id = $h_pactiv_id and activ_id = $activ and tactiv_id = $h_tactiv_id";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
			}
			
			$new_clasificaciones = explode("," , $activ_id);
			foreach ($new_clasificaciones as $activ) {
				
				$sql = "SELECT 1 FROM ACTIVIDAD_CLASIFICACION where activ_id = $activ";
				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount > 0){					
					$resp = array('cod'=>'error','desc'=>'La(s) actividad(es) a modificar ya posee(n) registrada(s) una Clasificación');
					salida_con_rollback($resp,$link);
					break;
				}				
				
				$sql = "insert into ACTIVIDAD_CLASIFICACION(pactiv_id,activ_id,tactiv_id) values ($pactiv_id,$activ,$tactiv_id)";	
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
			}			
			mysqli_commit($link);			

		}	
		
		elseif($operacion == 'DELETE'){

			$h_pactiv_id = $_POST['h_pactiv_id'];
			$h_tactiv_id = $_POST['h_tactiv_id'];
			$h_activ_id = $_POST['h_activ_id'];	

			if($h_pactiv_id == "" or $h_tactiv_id == "" or $h_activ_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}			
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos.');
			
			mysqli_autocommit($link, FALSE);

			$clasificaciones = explode("," , $h_activ_id);
			foreach ($clasificaciones as $activ) {
				$sql = "DELETE FROM ACTIVIDAD_CLASIFICACION WHERE pactiv_id = $h_pactiv_id and activ_id = $activ and tactiv_id = $h_tactiv_id";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
			}
					
			mysqli_commit($link);			
			
			
		}	
		
		//$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		//$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	//if(!isset($famactividades)){
		//include('funciones_comunes.php');
		//Retorna respuesta
		echo json_encode($resp);	
	//}


?>