<?php 

	include('coneccion.php');
	
	if(isset($_GET['per_agno'])){

		$per_agno = $_GET['per_agno'];
		$per_mes = $_GET['per_mes'];
		$sem_num = $_GET['sem_num'];	
		$fer_dia = $_GET['fer_dia'];	
		$pis_pm = $_GET['pis_pm'];
			
		$sql = "SELECT   
		SEM.PER_AGNO, SEM.PER_MES, SEM.SEM_NUM, DATE_FORMAT(CTRLAGUA_DIA,'%d-%m-%Y') as CTRLAGUA_DIA, CTRLAGUA_HORA,
		P.PIS_PM, P.PIS_ID, C.CLON_ID, REPLACE(REPLACE(FER_PH,'.',','),',0','') FER_PH,FER_CE,FER_CAUDAL
		FROM SEMANAS AS SEM 
		JOIN CONTROL_AGUA CTRL ON SEM.PER_AGNO = CTRL.PER_AGNO AND SEM.SEM_NUM = CTRL.SEM_NUM
		JOIN FERTILIZACION AS F ON F.CTRLAGUA_ID = CTRL.CTRLAGUA_ID		
		JOIN PISCINA AS P ON F.PIS_PM = P.PIS_PM AND F.PIS_ID = P.PIS_ID
		JOIN CLON AS C ON P.CLON_ID = C.CLON_ID

		WHERE 
		(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
		(SEM.PER_MES = '$per_mes' or '$per_mes' = '') AND
		(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND
		(CTRL.CTRLAGUA_DIA = '$fer_dia' or '$fer_dia' = '') AND
		(P.PIS_PM = '$pis_pm' or '$pis_pm' = '') 	
		ORDER BY SEM.SEM_NUM,CTRLAGUA_DIA, CTRLAGUA_HORA, F.PIS_PM, F.PIS_ID";	
				
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