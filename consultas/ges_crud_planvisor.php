<?php 

	include('coneccion.php');
	
	if(isset($_GET['activ_id'])){
	
		$activ_id = $_GET['activ_id'];
		$plan_dia = $_GET['plan_dia'];
	
		$sql = "select DATE_FORMAT(PLANO.PLAN_DIA,'%d-%m-%Y') as PLAN_DIA,
		AREA.AREA_NOMBRE, 
		ACTIV.ACTIV_NOMBRE,
		CONCAT(SUP.SUP_NOMBRES,' ',SUP.SUP_PATERNO,' ',SUP.SUP_MATERNO) AS SUPERVISOR, 
		CONCAT(OPER.OPER_NOMBRES,' ',OPER.OPER_PATERNO,' ',OPER.OPER_MATERNO) AS OPERARIO, 
		REPLACE(PLANO.PLANO_HORAS,'.',',') as PLANO_HORAS
		,IFNULL(PLANO_ASIST,'N') AS PLANO_ASIST,IFNULL(PLANO_CANT,0) AS PLANO_CANT, IFNULL(REPLACE(PLANO.PLANO_HORASPROD,'.',','),0) AS PLANO_HORASPROD,IFNULL(PLANO_OBS,'') AS PLANO_OBS		
		from OPERADOR AS OPER 
		JOIN PLANIFICACION_OPER AS PLANO ON OPER.OPER_RUT = PLANO.OPER_RUT 
		JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLANO.ACTIV_ID 
		JOIN AREA ON AREA.AREA_ID = ACTIV.AREA_ID 
		JOIN PLANIFICACION AS PLAN ON PLAN.ACTIV_ID = PLANO.ACTIV_ID AND PLAN.PLAN_DIA = PLANO.PLAN_DIA 
		JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = PLAN.SUP_RUT 
		WHERE PLANO.PLAN_DIA = '$plan_dia' AND PLANO.ACTIV_ID = $activ_id";	
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
		
		echo json_encode($resp);
			
	}else{	
	
		$per_agno = $_POST['per_agno'];
		$per_mes = $_POST['per_mes'];
		$sup_rut = $_POST['sup_rut'];
			
		$sql = "SELECT ACTIV.activ_id, ACTIV.activ_nombre, PLAN.plan_dia, CONCAT(SUP.SUP_NOMBRES,' ',SUP.SUP_PATERNO,' ',SUP.SUP_MATERNO) AS SUPERVISOR, AREA.AREA_NOMBRE,ACTIV.ACTIV_STANDAR,IFNULL(UND.UND_NOMBRE,'') AS UNIDAD, IFNULL(REPLACE(REPLACE(MET.MET_UNDXHR,'.',','),',00',''),'') AS META, (
			SELECT IFNULL(MET.MET_UNDXHR,0) * SUM(PLANO.PLANO_HORAS) FROM PLANIFICACION_OPER AS PLANO WHERE PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID=PLAN.ACTIV_ID GROUP BY PLANO.PLAN_DIA
			)AS PRODUCCION
			FROM PLANIFICACION AS PLAN 
			JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
			JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = PLAN.SUP_RUT
			JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
			JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
			LEFT JOIN UNIDAD AS UND ON UND.UND_ID = ACTIV.UND_ID 
			LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLAN.PLAN_DIA>= MET.MET_INIVIG AND (MET.MET_FINVIG IS NULL OR PLAN.PLAN_DIA<= MET.MET_FINVIG)
			WHERE PLAN.SEM_NUM IN (SELECT DISTINCT SEM_NUM FROM PLANIFICACION WHERE Date_format(PLAN_DIA,'%m') = $per_mes AND PER_AGNO = $per_agno)
			AND (PLAN.SUP_RUT = '$sup_rut' OR '$sup_rut' = '')
			ORDER BY PLAN.PLAN_DIA ASC";
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		$colores = array('#0000FF','0000FF','0000FF','0000FF','0000FF','0000FF');
		$i = 0;
	
		$nom_area = '';
		while( $rows = mysqli_fetch_assoc($resultset) ) {
		/*
			if($nom_area <> $rows[AREA_NOMBRE]){
				$color = $colores[$i];
				$nom_area = $rows[AREA_NOMBRE];
			}
			$i++;
		
			$activ_nombre = $rows[activ_nombre];
			if(strlen($activ_nombre)>23){
				$activ_nombre = substr($activ_nombre,0,23).'...';
			}
		*/
			$tipo_activ = 'ESTANDAR';
			if($rows[ACTIV_STANDAR] <> 'S'){
				$tipo_activ = 'NO ESTANDAR';
			}

			$PLAN_PRODUCCION = '';
			if($rows[PRODUCCION] > 0) {
				$PLAN_PRODUCCION = str_replace(',00','',str_replace(".", ",",round($rows[PRODUCCION],2)));
				//if($rows[UNIDAD] <> ''){ $PLAN_PRODUCCION = $PLAN_PRODUCCION.' '.$rows[UNIDAD]; }
			}			
		
			$data[] = 
			Array
			(
				'id' => $rows[activ_id].'---'.$rows[SUPERVISOR].'---'.$rows[AREA_NOMBRE].'---'.$rows[activ_nombre].'---'.$tipo_activ.'---'.$rows[UNIDAD].'---'.$rows[META].'---'.$PLAN_PRODUCCION,
				'title' => $rows[activ_nombre],
				'start' => $rows[plan_dia]
				//'color' => $color
			);			
		}
		echo json_encode($data);
	}
		

?>