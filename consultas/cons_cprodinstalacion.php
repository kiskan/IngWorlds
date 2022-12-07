<?php 

	include('coneccion.php');
	
	if(isset($_GET['per_agno'])){

		$per_agno = $_GET['per_agno'];
		$per_mes = $_GET['per_mes'];
		$sem_num = $_GET['sem_num'];	
		$plan_dia = $_GET['plan_dia'];	
		$inst_inv = $_GET['inst_inv'];
		
				
		$sql = "SELECT   
		DATE_FORMAT(PLAN.PLAN_DIA,'%d-%m-%Y') as PLAN_DIA, SEM.PER_AGNO, SEM.PER_MES, SEM.SEM_NUM,
		IO.INST_INV, IO.INST_LINEA,C.CLON_ID, C.CLON_ESPECIE, IO.INST_TIPOESTACA,
		SUM(IFNULL(IO.INST_CANTIDAD,0)) AS INST_CANTIDAD

		FROM PLANIFICACION AS PLAN 
		JOIN PLANIFICACION_OPER AS PLANO ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID= PLANO.ACTIV_ID
		JOIN SEMANAS AS SEM ON SEM.PER_AGNO = PLAN.PER_AGNO AND SEM.SEM_NUM = PLAN.SEM_NUM
		JOIN INSTALACION_OPER AS IO ON IO.PLAN_DIA = PLANO.PLAN_DIA AND IO.ACTIV_ID = PLANO.ACTIV_ID AND IO.OPER_RUT = PLANO.OPER_RUT
		JOIN CLON AS C ON IO.CLON_ID = C.CLON_ID

		WHERE 
		PLAN.ACTIV_ID in (882) AND
		(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
		(SEM.PER_MES = '$per_mes' or '$per_mes' = '') AND
		(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND
		(PLAN.PLAN_DIA = '$plan_dia' or '$plan_dia' = '') AND
		(IO.INST_INV = '$inst_inv' or '$inst_inv' = '') 
		GROUP BY PLAN_DIA,PER_AGNO, PER_MES, SEM_NUM, IO.INST_INV, IO.INST_LINEA,C.CLON_ID, IO.INST_TIPOESTACA	
		ORDER BY PLAN.PLAN_DIA, INST_INV ASC";	

	
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