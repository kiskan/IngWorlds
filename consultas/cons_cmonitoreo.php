<?php 

	include('coneccion.php');
	
	if(isset($_GET['per_agno'])){

		$per_agno = $_GET['per_agno'];
		$per_mes = $_GET['per_mes'];
		$sem_num = $_GET['sem_num'];	
		$plan_dia = $_GET['plan_dia'];	
		$sup_rut = $_GET['sup_rut'];
		$activ_id = $_GET['activ_id'];
	
		$sql = "SELECT O.OPER_NOMBRES, O.OPER_PATERNO, O.OPER_MATERNO, IFNULL(PLANO.PLANO_ASIST,'N') AS ASIST, IFNULL(PLANO.PLANO_CANT,0) AS CANT, 
		PLANO.PLANO_HORAS AS HR_PLAN, IFNULL(PLANO.PLANO_HORASPROD,0) AS HR_PROD, SEM.PER_AGNO, SEM.PER_MES, SEM.SEM_NUM, DATE_FORMAT(PLAN.PLAN_DIA,'%d-%m-%Y') as PLAN_DIA, 
		AREA.AREA_NOMBRE AS AREA,CONCAT(SUP_NOMBRES,' ',SUP_PATERNO,' ',SUP_MATERNO) AS SUPERVISOR, ACTIV.ACTIV_NOMBRE AS ACTIVIDAD, PLANO.PLANO_OBS AS OPER_OBS,
		IFNULL(MET.MET_UNDXHR,0) AS META, IFNULL(UND.UND_NOMBRE,'') AS UNIDAD, PLANO.PLANO_FECHACTPROD AS ULT_REG
		,IFNULL(ACF.FACTIV_NOMBRE,'') AS FACTIV_NOMBRE, IFNULL(ACS.SFACTIV_NOMBRE,'') AS SFACTIV_NOMBRE, 
		IFNULL(ACP.PACTIV_NOMBRE,'') AS PACTIV_NOMBRE, IFNULL(ACT.TACTIV_NOMBRE,'') AS TACTIV_NOMBRE,
		ROUND(CAST(IFNULL(PLANO.PLANO_HRDSCTO,0) AS UNSIGNED) + (CAST(IFNULL(PLANO.PLANO_MINDSCTO,0) AS UNSIGNED)/60),2) AS HR_DSCTO
		FROM PLANIFICACION AS PLAN 
		JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
		JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
		JOIN AREA AS AREA ON AREA.AREA_ID = ACTIV.AREA_ID
		JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = PLAN.SUP_RUT
		JOIN SEMANAS AS SEM ON SEM.PER_AGNO = PLAN.PER_AGNO AND SEM.SEM_NUM = PLAN.SEM_NUM
		JOIN OPERADOR AS O ON PLANO.OPER_RUT = O.OPER_RUT
		LEFT JOIN UNIDAD AS UND ON UND.UND_ID = ACTIV.UND_ID 
		LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND PLANO.PLAN_DIA>= MET.MET_INIVIG 
		AND (MET.MET_FINVIG IS NULL OR PLANO.PLAN_DIA<= MET.MET_FINVIG)	
		LEFT JOIN ACTIVIDAD_CLASIFICACION AS ACC ON ACC.ACTIV_ID = ACTIV.ACTIV_ID
		LEFT JOIN ACTIVIDAD_TIPO AS ACT ON ACT.TACTIV_ID = ACC.TACTIV_ID
		LEFT JOIN ACTIVIDAD_PADRE AS ACP ON ACP.PACTIV_ID = ACC.PACTIV_ID
		LEFT JOIN ACTIVIDAD_SUBFAMILIA AS ACS ON ACP.SFACTIV_ID = ACS.SFACTIV_ID
		LEFT JOIN ACTIVIDAD_FAMILIA AS ACF ON ACS.FACTIV_ID = ACF.FACTIV_ID
		WHERE 
		(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
		(SEM.PER_MES = '$per_mes' or '$per_mes' = '') AND
		(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND
		(PLAN.PLAN_DIA = '$plan_dia' or '$plan_dia' = '') AND
		(SUP.SUP_RUT = '$sup_rut' or '$sup_rut' = '') AND
		(ACTIV.ACTIV_ID = '$activ_id' or '$activ_id' = '') 
		ORDER BY PLAN.PLAN_DIA, AREA, ACTIVIDAD, OPER_PATERNO, OPER_MATERNO ASC";	
		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {

			$rendimiento = '-';
			$cumplimiento = '-';
			if($rows[HR_PROD] <> '0' and $rows[HR_PROD] <> ''){
				$rendimiento = round($rows[CANT]/$rows[HR_PROD],2);
				$rendimiento = str_replace('.00','',$rendimiento);
				//$rendimiento = number_format($rendimiento,0,",",".");
			}
			if($rows[HR_PROD] <> '0' and $rows[HR_PROD] <> '' and $rows[META] <> '0' and $rows[META] <> ''){
				$cumplimiento = round((($rows[CANT]/$rows[HR_PROD])*100)/$rows[META],2);
				$cumplimiento = str_replace('.00','',$cumplimiento).'%';				
				
			}
			
			$cantidad = str_replace('.00','',$rows[CANT]);
			
			//if($rows[UND_NOMBRE] <> '' and $rows[META] <> '0' and $rows[META] <> ''){ $cantidad = $cantidad.' '.$rows[UND_NOMBRE]; }
			
			$meta = str_replace('.00','',$rows[META]);
			
			//$cantidad = number_format($cantidad,0,",",".");			
			//$meta = number_format($meta,0,",",".");
			
			if($rows[ULT_REG] == '0000-00-00 00:00:00') $rows[ULT_REG] = '';
			
			$data[] = 
			Array
			(
				'PRODXMETA' => $cumplimiento,
				'PRODXHR' => $rendimiento,
				'HR_DSCTO' => $rows[HR_DSCTO],
				'METAXHR' => $meta,
				'OPER_NOMBRES' => $rows[OPER_NOMBRES],
				'OPER_PATERNO' => $rows[OPER_PATERNO],
				'OPER_MATERNO' => $rows[OPER_MATERNO],
				'ASIST' => $rows[ASIST],
				'CANT' => $cantidad,
				'UNIDAD' => $rows[UNIDAD],
				'HR_PLAN' => $rows[HR_PLAN],
				'HR_PROD' => $rows[HR_PROD],
				'PER_AGNO' => $rows[PER_AGNO],
				'PER_MES' => $rows[PER_MES],
				'SEM_NUM' => $rows[SEM_NUM],
				'PLAN_DIA' => $rows[PLAN_DIA],
				'AREA' => $rows[AREA],
				'SUPERVISOR' => $rows[SUPERVISOR],
				'ACTIVIDAD' => $rows[ACTIVIDAD],
				'OPER_OBS' => $rows[OPER_OBS],
				'ULT_REG' => $rows[ULT_REG],
'FACTIV_NOMBRE' => $rows[FACTIV_NOMBRE],
'SFACTIV_NOMBRE' => $rows[SFACTIV_NOMBRE],
'PACTIV_NOMBRE' => $rows[PACTIV_NOMBRE],
'TACTIV_NOMBRE' => $rows[TACTIV_NOMBRE]				
			);			
		
		}					

		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);
		
		echo json_encode($resp);
			
	}
		

?>