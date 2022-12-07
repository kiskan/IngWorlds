<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['data'])){
	
		$sql = "SELECT SUP_RUT, CONCAT(SUP_NOMBRES,' ',SUP_PATERNO,' ',SUP_MATERNO) AS SUPERVISOR, SUP_ESTADO, CMN_CODIGO, SUP_NOMBRES, SUP_PATERNO, SUP_MATERNO, SUP_SEXO, DATE_FORMAT(SUP_FECHANAC,'%d-%m-%Y') as SUP_FECHANAC, SUP_DIRECCION, SUP_FONO, SUP_EMAIL, SUP_CIVIL FROM SUPERVISOR ORDER BY SUP_FECHACT DESC";	
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();

		while( $rows = mysqli_fetch_assoc($resultset) ) {
		
			$sql_supervisiones = "SELECT S.AREA_ID, A.AREA_NOMBRE FROM SUPERVISIONES AS S JOIN SUPERVISOR AS SU ON S.SUP_RUT = SU.SUP_RUT JOIN AREA AS A ON A.AREA_ID = S.AREA_ID WHERE S.SUP_RUT = '$rows[SUP_RUT]'";
			$resultado = mysqli_query($link, $sql_supervisiones) or die("database error:". mysqli_error($link));
			$supervisiones = '';
			$id_supervisiones = '';
			$i = 0;
			while( $rows_supervisiones = mysqli_fetch_assoc($resultado) ) {
				if($i == 0){
					$supervisiones = $rows_supervisiones[AREA_NOMBRE];
					$id_supervisiones = $rows_supervisiones[AREA_ID];
				}
				else{
					$supervisiones = $supervisiones.','.$rows_supervisiones[AREA_NOMBRE];
					$id_supervisiones = $id_supervisiones.','.$rows_supervisiones[AREA_ID];
				}
				$i++;
			}
		
			$data[] = 
			Array
			(
				'SUP_RUT' => formateo_rut($rows[SUP_RUT]),
				'SUPERVISOR' => $rows[SUPERVISOR],								
				'SUP_ESTADO' => $rows[SUP_ESTADO],
				'AREAS_A_SUPERVISAR' => $supervisiones,
				'ID_AREAS_A_SUPERVISAR' => $id_supervisiones,
				'CMN_CODIGO' => $rows[CMN_CODIGO],
				'SUP_NOMBRES' => $rows[SUP_NOMBRES],
				'SUP_PATERNO' => $rows[SUP_PATERNO],
				'SUP_MATERNO' => $rows[SUP_MATERNO],
				'SUP_SEXO' => $rows[SUP_SEXO],
				'SUP_FECHANAC' => $rows[SUP_FECHANAC],
				'SUP_DIRECCION' => $rows[SUP_DIRECCION],
				'SUP_FONO' => $rows[SUP_FONO],
				'SUP_EMAIL' => $rows[SUP_EMAIL],
				'SUP_CIVIL' => $rows[SUP_CIVIL]
			);			
			
		}		
		
		
	
		
		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);	
	
	}
	
	elseif(isset($_POST['plan_area'])){
		$plan_area = $_POST['plan_area'];
		$sql = "SELECT SUP.SUP_RUT, CONCAT(SUP_NOMBRES,' ',SUP_PATERNO,' ',SUP_MATERNO) AS SUPERVISOR FROM SUPERVISOR SUP JOIN SUPERVISIONES SUPER ON SUP.SUP_RUT = SUPER.SUP_RUT WHERE SUPER.AREA_ID = $plan_area ";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}	
	
	elseif(isset($_POST['sup_replanificacion'])){
		$sup_rut = $_POST['sup_rut'];
		$sql = "SELECT SUP.SUP_RUT, CONCAT(SUP_NOMBRES,' ',SUP_PATERNO,' ',SUP_MATERNO) AS SUPERVISOR
				FROM SUPERVISOR AS SUP 
				WHERE SUP.SUP_RUT = '$sup_rut'";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}		

	elseif(isset($_POST['load'])){
		
		$sql = "SELECT SUP.SUP_RUT, CONCAT(SUP_NOMBRES,' ',SUP_PATERNO,' ',SUP_MATERNO) AS SUPERVISOR FROM SUPERVISOR SUP ";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}

	elseif(isset($_POST['planif_activ'])){
		
		$rut_supervisor = $_POST['rut_supervisor'];
		$plan_dia = $_POST['plan_dia'];

		$background_colors = array('00c0ef', '00a65a', 'dd4b39', 'FF3838', 'f39c12', '208187', '9c6635', 'e0d02a', 'dd1ac6', 'b2b555', '208187', '696781', 'e372e2', '4e569e', 'a96a7d', 'e60551', '444b50', 'a67825', 'a6226f', 'f7a01f','800080','FF00FF','000080','0000FF','008080','00FFFF','008000','00FF00','808000','800000','FF0000','808080','800008');
		
		$sql = "SELECT COUNT(PLANO.OPER_RUT) AS NUM_OPERADOR,ACTIV.ACTIV_ID,ACTIV.ACTIV_NOMBRE ,AREA.AREA_ID,AREA.AREA_NOMBRE,IFNULL(UND.UND_NOMBRE,'') AS UNIDAD,ACTIV.ACTIV_STANDAR,
		(
			SELECT IFNULL(MET.MET_UNDXHR,0) * SUM(PLANO.PLANO_HORAS) FROM PLANIFICACION_OPER AS PLANO WHERE PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID=PLAN.ACTIV_ID GROUP BY PLANO.PLAN_DIA
		)AS PRODUCCION
		FROM PLANIFICACION AS PLAN 
		JOIN PLANIFICACION_OPER AS PLANO 
		ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
		JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
		JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
		LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLAN.PLAN_DIA>= MET.MET_INIVIG AND (MET.MET_FINVIG IS NULL OR PLAN.PLAN_DIA<= MET.MET_FINVIG)
		LEFT JOIN UNIDAD AS UND ON UND.UND_ID = ACTIV.UND_ID		
		WHERE PLAN.SUP_RUT = '$rut_supervisor' AND PLAN.PLAN_DIA = '$plan_dia'
		GROUP BY ACTIV.ACTIV_ID,ACTIV.ACTIV_NOMBRE,AREA.AREA_ID,AREA.AREA_NOMBRE,ACTIV.ACTIV_STANDAR";	

		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		$i = 0;
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			
			$sql_prod = "SELECT PLANO.PLAN_DIA
			FROM PLANIFICACION_OPER AS PLANO 
			JOIN PLANIFICACION AS PLAN 
			ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID 
			WHERE PLANO.PLAN_DIA = '$plan_dia' AND PLANO.ACTIV_ID = $rows[ACTIV_ID] AND PLAN.SUP_RUT = '$rut_supervisor' AND PLANO.PLANO_ASIST IS NOT NULL";
			$resultado = mysqli_query($link, $sql_prod) or die("database error:". mysqli_error($link));
			$rowcount = mysqli_num_rows($resultado);
			
			$PROD_EXISTE = 'FINALIZADO';
			if($rowcount == 0){
				$PROD_EXISTE = 'SIN REGISTRAR';
			}

			$PLAN_PRODUCCION = '_';
			if($rows[PRODUCCION] > 0) {
				//$valor[$k] = number_format($datos[$k][Copago],0,",",".");
				//$PLAN_PRODUCCION = str_replace(',00','',str_replace(".", ",",round($rows[PRODUCCION],2)));
				$PLAN_PRODUCCION = str_replace(',00','',number_format($rows[PRODUCCION],2,",","."));
				if($rows[UNIDAD] <> ''){ $PLAN_PRODUCCION = $PLAN_PRODUCCION.' '.$rows[UNIDAD]; }
			}			
			
			$data[] = 
			Array
			(
				'NUM_OPERADOR' => $rows[NUM_OPERADOR],	
				'ACTIV_ID' => $rows[ACTIV_ID],
				'ACTIV_NOMBRE' => $rows[ACTIV_NOMBRE],
				'AREA_ID' => $rows[AREA_ID],
				'AREA_NOMBRE' => $rows[AREA_NOMBRE],
				'ACTIV_STANDAR' => $rows[ACTIV_STANDAR],
				'PRODUCCION' => $PLAN_PRODUCCION,
				'PROD_EXISTE' => $PROD_EXISTE,
				'COLOR' => $background_colors[$i]//random_color()
			);			
			
			$i++;
		}
		salida($data);
	}		

	elseif(isset($_POST['cons_prod'])){
	
		$per_agno = $_POST['per_agno'];
		$per_mes = $_POST['per_mes'];
		$sem_num = $_POST['sem_num'];	
		$plan_dia = $_POST['plan_dia'];	
		$sup_rut = $_POST['sup_rut'];
		
		
		$sql = "SELECT DISTINCT ACTIV.ACTIV_ID, CONCAT(AREA.AREA_NOMBRE,': ',ACTIV.ACTIV_NOMBRE) AS ACTIV_NOMBRE
		FROM PLANIFICACION AS PLAN 
		JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
		JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
		JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = PLAN.SUP_RUT
		JOIN SEMANAS AS SEM ON SEM.PER_AGNO = PLAN.PER_AGNO AND SEM.SEM_NUM = PLAN.SEM_NUM	
		WHERE SUP.SUP_RUT = '$sup_rut' AND
		(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
		(SEM.PER_MES = '$per_mes' or '$per_mes' = '') AND
		(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND
		(PLAN.PLAN_DIA = '$plan_dia' or '$plan_dia' = '')  
		ORDER BY ACTIV_NOMBRE ASC";	
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
		
			$sup_rut = str_replace(".", "",$_POST['sup_rut']);
			$cmn_codigo = $_POST['cmn_codigo'];
			$sup_nombres = $_POST['sup_nombres'];
			$sup_paterno = $_POST['sup_paterno'];
			$sup_materno = $_POST['sup_materno'];
			$sup_sexo = $_POST['sup_sexo'];
			$fechanac = explode("-" , $_POST['sup_fechanac']);
			$sup_fechanac = $fechanac[2].'-'.$fechanac[1].'-'.$fechanac[0];
			$sup_direccion = $_POST['sup_direccion'];
			$sup_fono = $_POST['sup_fono'];
			$sup_email = $_POST['sup_email'];
			$sup_civil = $_POST['sup_civil'];
			$sup_estado = $_POST['sup_estado'];
			$sup_area = $_POST['sup_area'];
			
			if($sup_rut == "" or $cmn_codigo == "" or $sup_nombres == "" or $sup_paterno == "" or $sup_materno == "" or $sup_sexo == "" or $sup_fechanac == "" or $sup_civil == "" or $sup_estado == "" or $sup_area == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			$sql_ins_sup = "INSERT INTO SUPERVISOR(SUP_RUT, CMN_CODIGO, SUP_NOMBRES, SUP_PATERNO, SUP_MATERNO, SUP_SEXO, SUP_FECHANAC, SUP_DIRECCION, SUP_FONO, SUP_EMAIL, SUP_CIVIL, SUP_ESTADO) VALUES  ('$sup_rut',$cmn_codigo,'$sup_nombres','$sup_paterno','$sup_materno','$sup_sexo','$sup_fechanac','$sup_direccion','$sup_fono','$sup_email','$sup_civil','$sup_estado')";
		
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
			$resultado = mysqli_query($link,$sql_ins_sup)or die(salida($resp));				

			$area = explode("," , $sup_area);
			
			foreach ($area as $area_id) {
				$sql_ins_super = "INSERT INTO SUPERVISIONES(SUP_RUT, AREA_ID) VALUES ('$sup_rut',$area_id)";	
				$resultado = mysqli_query($link,$sql_ins_super)or die(salida($resp));				
			}			

		}
		
		elseif($operacion == 'UPDATE'){
			
			$sup_rut = str_replace(".", "",$_POST['sup_rut']);
			$cmn_codigo = $_POST['cmn_codigo'];
			$sup_nombres = $_POST['sup_nombres'];
			$sup_paterno = $_POST['sup_paterno'];
			$sup_materno = $_POST['sup_materno'];
			$sup_sexo = $_POST['sup_sexo'];
			$fechanac = explode("-" , $_POST['sup_fechanac']);
			$sup_fechanac = $fechanac[2].'-'.$fechanac[1].'-'.$fechanac[0];
			$sup_direccion = $_POST['sup_direccion'];
			$sup_fono = $_POST['sup_fono'];
			$sup_email = $_POST['sup_email'];
			$sup_civil = $_POST['sup_civil'];
			$sup_estado = $_POST['sup_estado'];
			$sup_area = $_POST['sup_area'];
			
			if($sup_rut == "" or $cmn_codigo == "" or $sup_nombres == "" or $sup_paterno == "" or $sup_materno == "" or $sup_sexo == "" or $sup_fechanac == "" or $sup_civil == "" or $sup_estado == "" or $sup_area == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			$sql_upd_sup = "UPDATE SUPERVISOR SET CMN_CODIGO=$cmn_codigo,SUP_NOMBRES='$sup_nombres',SUP_PATERNO='$sup_paterno',SUP_MATERNO='$sup_materno',SUP_SEXO='$sup_sexo',SUP_FECHANAC='$sup_fechanac',SUP_DIRECCION='$sup_direccion',SUP_FONO='$sup_fono',SUP_EMAIL='$sup_email',SUP_CIVIL='$sup_civil',SUP_ESTADO='$sup_estado' WHERE SUP_RUT='$sup_rut'";

			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
			$resultado = mysqli_query($link,$sql_upd_sup)or die(salida($resp));			
			
			$sql_del_comp = "DELETE FROM SUPERVISIONES WHERE SUP_RUT='$sup_rut'";
			$resultado = mysqli_query($link,$sql_del_comp)or die(salida($resp));
			
			$area = explode("," , $sup_area);
			
			foreach ($area as $area_id) {
				$sql_ins_comp = "INSERT INTO SUPERVISIONES(SUP_RUT, AREA_ID) VALUES ('$sup_rut',$area_id)";	
				$resultado = mysqli_query($link,$sql_ins_comp)or die(salida($resp));				
			}			
			

		}	
		
		elseif($operacion == 'DELETE'){
			
			$sup_rut = str_replace(".", "",$_POST['sup_rut']);
			
			if($sup_rut == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
			
			$sql_del_super = "DELETE FROM SUPERVISIONES WHERE SUP_RUT='$sup_rut'";
			$resultado = mysqli_query($link,$sql_del_super)or die(salida($resp));
			
			$sql_del_sup = "DELETE FROM SUPERVISOR WHERE SUP_RUT='$sup_rut'";
			$resultado = mysqli_query($link,$sql_del_sup)or die(salida($resp));			
			
		}		
/*
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	
*/
		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	
	//Retorna respuesta
	echo json_encode($resp);	

?>