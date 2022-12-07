<?php 

	include('coneccion.php');
	
	if(isset($_GET['per_agno'])){

		$per_agno = $_GET['per_agno'];
		$per_mes = $_GET['per_mes'];
		$sem_num = $_GET['sem_num'];	
		$plan_dia = $_GET['plan_dia'];	
		$pis_pm = $_GET['pis_pm'];
		$activ_id = $_GET['activ_id'];
		
		if($activ_id == ''){
	
			$sql = "SELECT   
			DATE_FORMAT(PLAN.PLAN_DIA,'%d-%m-%Y') as PLAN_DIA, SEM.PER_AGNO, SEM.PER_MES, SEM.SEM_NUM,
			P.PIS_PM, P.PIS_ID, 
			/*C.CLON_ID, */
			(
SELECT CLON_ID
  FROM (
select DISTINCT CLON_ID, PIS_FINSTAL,PIS_PM,PIS_ID from HPISCINA 
UNION
select CLON_ID, PIS_FINSTAL,PIS_PM,PIS_ID  from PISCINA 
       ) AS U
WHERE U.PIS_PM = P.PIS_PM AND U.PIS_ID = P.PIS_ID
AND U.PIS_FINSTAL <= PLAN.PLAN_DIA
ORDER BY U.PIS_FINSTAL DESC
LIMIT 1			
			) AS CLON_ID,
			SUM(IFNULL(PO.PISOP_CANT,0)) AS CANT,
			(
SELECT PIS_ESTADO
  FROM (
select DISTINCT PIS_ESTADO, PIS_FINSTAL,PIS_PM,PIS_ID from HPISCINA 
UNION
select PIS_ESTADO, PIS_FINSTAL,PIS_PM,PIS_ID  from PISCINA 
       ) AS U
WHERE U.PIS_PM = P.PIS_PM AND U.PIS_ID = P.PIS_ID
AND U.PIS_FINSTAL <= PLAN.PLAN_DIA
ORDER BY U.PIS_FINSTAL DESC
LIMIT 1			
			) AS PIS_ESTADO,			
			/*P.PIS_ESTADO,*/
			
			'GLOBULUS + GLONI + RAMAS' AS TIPO_COSECHA

			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
			JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
			JOIN SEMANAS AS SEM ON SEM.PER_AGNO = PLAN.PER_AGNO AND SEM.SEM_NUM = PLAN.SEM_NUM
			JOIN PISCINA_OPER AS PO ON PO.PLAN_DIA = PLANO.PLAN_DIA AND PO.ACTIV_ID = PLANO.ACTIV_ID AND PO.OPER_RUT = PLANO.OPER_RUT
			JOIN PISCINA AS P ON PO.PIS_PM = P.PIS_PM AND PO.PIS_ID = P.PIS_ID
			JOIN CLON AS C ON P.CLON_ID = C.CLON_ID

			WHERE 
			ACTIV.ACTIV_ID IN (62, 240, 241) AND 
			(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
			(SEM.PER_MES = '$per_mes' or '$per_mes' = '') AND
			(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND
			(PLAN.PLAN_DIA = '$plan_dia' or '$plan_dia' = '') AND
			(P.PIS_PM = '$pis_pm' or '$pis_pm' = '') 
			GROUP BY PLAN_DIA,PER_AGNO, PER_MES, SEM_NUM, PIS_PM, P.PIS_ID		
			ORDER BY PLAN.PLAN_DIA, PIS_PM, P.PIS_ID ASC";	
		}
		else{
			$sql = "SELECT   
			DATE_FORMAT(PLAN.PLAN_DIA,'%d-%m-%Y') as PLAN_DIA, SEM.PER_AGNO, SEM.PER_MES, SEM.SEM_NUM,
			P.PIS_PM, P.PIS_ID, 
			(
SELECT CLON_ID
FROM (
select DISTINCT CLON_ID, PIS_FINSTAL,PIS_PM,PIS_ID from HPISCINA 
UNION
select CLON_ID, PIS_FINSTAL,PIS_PM,PIS_ID  from PISCINA 
       ) AS U
WHERE U.PIS_PM = P.PIS_PM AND U.PIS_ID = P.PIS_ID
AND U.PIS_FINSTAL <= PLAN.PLAN_DIA
ORDER BY U.PIS_FINSTAL DESC
LIMIT 1			
			) AS CLON_ID,			
			SUM(IFNULL(PO.PISOP_CANT,0)) AS CANT, 
			
			(
SELECT PIS_ESTADO
  FROM (
select DISTINCT PIS_ESTADO, PIS_FINSTAL,PIS_PM,PIS_ID from HPISCINA 
UNION
select PIS_ESTADO, PIS_FINSTAL,PIS_PM,PIS_ID  from PISCINA 
       ) AS U
WHERE U.PIS_PM = P.PIS_PM AND U.PIS_ID = P.PIS_ID
AND U.PIS_FINSTAL <= PLAN.PLAN_DIA
ORDER BY U.PIS_FINSTAL DESC
LIMIT 1			
			) AS PIS_ESTADO,			
			/*P.PIS_ESTADO,*/
			
			ACTIV.ACTIV_NOMBRE AS TIPO_COSECHA 

			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID  
			JOIN ACTIVIDAD AS ACTIV ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID
			JOIN SEMANAS AS SEM ON SEM.PER_AGNO = PLAN.PER_AGNO AND SEM.SEM_NUM = PLAN.SEM_NUM
			JOIN PISCINA_OPER AS PO ON PO.PLAN_DIA = PLANO.PLAN_DIA AND PO.ACTIV_ID = PLANO.ACTIV_ID AND PO.OPER_RUT = PLANO.OPER_RUT
			JOIN PISCINA AS P ON PO.PIS_PM = P.PIS_PM AND PO.PIS_ID = P.PIS_ID
			JOIN CLON AS C ON P.CLON_ID = C.CLON_ID

			WHERE 
			(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
			(SEM.PER_MES = '$per_mes' or '$per_mes' = '') AND
			(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND
			(PLAN.PLAN_DIA = '$plan_dia' or '$plan_dia' = '') AND
			(P.PIS_PM = '$pis_pm' or '$pis_pm' = '') AND
			(PO.ACTIV_ID = '$activ_id')
			GROUP BY PER_AGNO, PER_MES, SEM_NUM, PLAN_DIA, PIS_PM, ACTIV_NOMBRE, P.PIS_ID		
			ORDER BY PLAN.PLAN_DIA, PIS_PM, P.PIS_ID ASC";			
		}
		
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
			
	}
		

?>