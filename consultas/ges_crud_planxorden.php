<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['per_agno'])){
		
		$per_agno = $_GET['per_agno'];
		$num_sem = $_GET['num_sem'];		

/*		$sql = "SELECT PLANO.PLAN_DIA, PLANO.OPER_RUT
		from PLANIFICACION_OPER AS PLANO 
		JOIN PLANIFICACION AS PLAN ON PLAN.ACTIV_ID = PLANO.ACTIV_ID AND PLAN.PLAN_DIA = PLANO.PLAN_DIA 
		WHERE PLAN.SEM_NUM IN (SELECT DISTINCT SEM_NUM FROM PLANIFICACION WHERE Date_format(PLAN_DIA,'%m') = $per_mes AND PER_AGNO = $per_agno) 
		GROUP BY PLANO.PLAN_DIA, PLANO.OPER_RUT
		HAVING COUNT(*) = 2";	
*/		
		$sql = "SELECT PLANO.PLAN_DIA, PLANO.OPER_RUT
		from PLANIFICACION_OPER AS PLANO 
		JOIN PLANIFICACION AS PLAN ON PLAN.ACTIV_ID = PLANO.ACTIV_ID AND PLAN.PLAN_DIA = PLANO.PLAN_DIA 
		WHERE PLAN.SEM_NUM = $num_sem AND PLAN.PER_AGNO = $per_agno 
		GROUP BY PLANO.PLAN_DIA, PLANO.OPER_RUT
		HAVING COUNT(*) = 2";		
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
	
		while( $rows = mysqli_fetch_assoc($resultset) ) {

			$sql = "SELECT AREA.AREA_NOMBRE, ACTIV.ACTIV_ID, CONCAT(SUP_NOMBRES,' ',SUP_PATERNO,' ',SUP_MATERNO) AS SUP_NOMBRE, REPLACE(PLANO.PLANO_HORAS,'.',',') as PLANO_HORAS,
			CONCAT(OPER.OPER_NOMBRES,' ',OPER.OPER_PATERNO,' ',OPER.OPER_MATERNO) AS OPERARIO, ACTIV.ACTIV_NOMBRE
            from PLANIFICACION_OPER AS PLANO 
            JOIN PLANIFICACION AS PLAN ON PLAN.ACTIV_ID = PLANO.ACTIV_ID AND PLAN.PLAN_DIA = PLANO.PLAN_DIA 
			JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = PLAN.SUP_RUT
			JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
			JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
			JOIN OPERADOR AS OPER ON OPER.OPER_RUT = PLANO.OPER_RUT
			WHERE PLANO.PLAN_DIA = '$rows[PLAN_DIA]' AND PLANO.OPER_RUT = '$rows[OPER_RUT]'
			ORDER BY PLANO.PLANO_FECHACT ASC";
					
			$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			
			$filas = mysqli_fetch_assoc($resultado);				
			$AREA1 = $filas[AREA_NOMBRE];
			$ACTIV1 = $filas[ACTIV_ID];
			$SUP1 = $filas[SUP_NOMBRE];
			$HORAS1 = $filas[PLANO_HORAS];
			$ACTIVIDADES = $filas[ACTIV_NOMBRE];
			$OPERADOR = $filas[OPERARIO];
	
			$filas = mysqli_fetch_assoc($resultado);
			$AREA2 = $filas[AREA_NOMBRE];
			$ACTIV2 = $filas[ACTIV_ID];
			$SUP2 = $filas[SUP_NOMBRE];
			$HORAS2 = $filas[PLANO_HORAS];
			$ACTIVIDADES = $ACTIVIDADES.' , '.$filas[ACTIV_NOMBRE];
			
			$data[] = 
			Array
			(
				'AREA1' => $AREA1,
				'ACTIV1' => $ACTIV1,								
				'SUP1' => $SUP1,
				'HORAS1' => $HORAS1,
				'AREA2' => $AREA2,
				'ACTIV2' => $ACTIV2,								
				'SUP2' => $SUP2,
				'HORAS2' => $HORAS2,
				'OPER_RUT' => $rows[OPER_RUT],				
				'PLAN_DIA' => $rows[PLAN_DIA],
				'OPERADOR' => $OPERADOR,	
				'ACTIVIDADES' => $ACTIVIDADES
			);			
		}		

		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);	
		
	}
	else{
		
		$oper_rut = $_POST['oper_rut'];			
		$plan_dia = $_POST['plan_dia'];
		$activ_id = $_POST['activ_id'];

		$sql = "UPDATE PLANIFICACION_OPER SET PLANO_FECHACT = CURRENT_TIMESTAMP WHERE PLAN_DIA = '$plan_dia' AND OPER_RUT = '$oper_rut' AND ACTIV_ID =$activ_id";
		$resultado = mysqli_query($link,$sql)or die(salida($resp));
		
		$resp = array('cod'=>'ok');
	}
	
	echo json_encode($resp);
	exit();		
		

?>