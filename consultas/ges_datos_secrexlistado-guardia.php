<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['num_sem'])){
		
		$plan_dia = $_GET['fecha'];
		
		if($plan_dia == ''){
			$data = array();			
		}else{
	
			$sql = "SELECT distinct
			SUBSTR(O.OPER_RUT,1,LENGTH(O.OPER_RUT)-2) AS RUT,
			right(O.OPER_RUT,1) AS DV, 
			SUBSTR(O.OPER_RUT,1,LENGTH(O.OPER_RUT)-2) AS COD_PERSONA,
			O.OPER_NOMBRES AS NOMBRES,
			CONCAT(O.OPER_PATERNO,' ',O.OPER_MATERNO) AS APELLIDOS,
			O.OPER_FONO AS TELEFONO,
			'' AS CELULAR,
			'' AS ANEXO,
			O.OPER_EMAIL AS EMAIL,
			'SOTROSUR' AS COD_EMPRESA,
			'' AS COD_AREA,
			'VIVERO_HORCONES' AS COD_PLANTA,
			0 AS EXTRANJERO,
			'' AS TARJETA,
			1 AS PERSONAL_PLANTA,
			'ZONA_VIVEROS' AS COD_ZONA_TRABAJO,
			0 AS PERSONAL_PROVEEDOR,
			'' AS COD_PROVEEDOR,
			0 AS VISITA,
			0 AS PERSONAL_CONTRATISTA
	FROM PLANIFICACION_EXTRA_OPER AS PLANO 
	JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
	JOIN PLANIFICACION_EXTRA AS PLAN ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
	JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
	WHERE SEM.SEM_NUM =".$_GET['num_sem']." AND SEM.PER_AGNO =".$_GET['per_agno']." AND PLAN.PLAN_DIA = '$plan_dia'
	ORDER BY PLAN.PLAN_DIA ASC";	

			$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$data = array();

			while( $rows = mysqli_fetch_assoc($resultset) ) {
			
				$data[] = 
				Array
				(
					'RUT' => $rows[RUT],
					'DV' => $rows[DV],
					'COD_PERSONA' => $rows[COD_PERSONA],				
					'NOMBRES' => $rows[NOMBRES],
					'APELLIDOS' => $rows[APELLIDOS],
					'TELEFONO' => $rows[TELEFONO],
					'CELULAR' => $rows[CELULAR],
					'ANEXO' => $rows[ANEXO],
					'EMAIL' => $rows[EMAIL],
					'COD_EMPRESA' => $rows[COD_EMPRESA],
					'COD_AREA' => $rows[COD_AREA],
					'COD_PLANTA' => $rows[COD_PLANTA],
					'EXTRANJERO' => $rows[EXTRANJERO],
					'TARJETA' => $rows[TARJETA],
					'PERSONAL_PLANTA' => $rows[PERSONAL_PLANTA],
					'COD_ZONA_TRABAJO' => $rows[COD_ZONA_TRABAJO],
					'PERSONAL_PROVEEDOR' => $rows[PERSONAL_PROVEEDOR],
					'COD_PROVEEDOR' => $rows[COD_PROVEEDOR],
					'VISITA' => $rows[VISITA],
					'PERSONAL_CONTRATISTA' => $rows[PERSONAL_CONTRATISTA]
				);	
							
			}
		
		}

		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);	
	
	}
	

	
	//Retorna respuesta
	echo json_encode($resp);
	exit();	

?>