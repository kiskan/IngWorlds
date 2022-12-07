<?php 

	include('coneccion.php');
	
	if(isset($_GET['per_agno'])){

		$per_agno = $_GET['per_agno'];		
		$sem_num = $_GET['sem_num'];	
		$sprod_dia = $_GET['sprod_dia'];	
//select FORMAT(TIMESTAMPDIFF(SECOND,'2020-05-03 05:30:10', '2020-05-03 05:30:11')/86400,5) AS TIEMPO_EN_SEG

		$sql = "SELECT DISTINCT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD.SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD.SPROD_ID, US1.USR_NOMBRE AS SOLICITANTE,	
				CP.CATPROD_NOMBRE, (CASE WHEN SPROD.SPROD_TIPOCOMPRA = 'COMPRA MATERIAL' THEN PROD.PROD_NOMBRE WHEN SPROD.SPROD_TIPOCOMPRA = 'PRESTACIÓN SERVICIO' THEN SD.SPRODD_SERVICIO ELSE '' END) PROD_SERV, 
				c.COTCOM_CANTIDAD, c.COTCOM_PRECIO, IFNULL(c.COTCOM_PROVEEDOR,'') COTCOM_PROVEEDOR, IFNULL(SPROD.SPROD_MOTIVO,'') SPROD_MOTIVO,		

				DATE_FORMAT(SPROD.SPROD_DIASYSTEM,'%d-%m-%Y %H:%i:%S') SPROD_DIASYSTEM,
				DATE_FORMAT(SD.SPRODD_DFINCOTIZ,'%d-%m-%Y %H:%i:%S') SPRODD_DFINCOTIZ,	

CONCAT( 
    TIMESTAMPDIFF(DAY, SPROD.SPROD_DIASYSTEM, SD.SPRODD_DFINCOTIZ), ' DIAS, ', 
    MOD(TIMESTAMPDIFF(HOUR, SPROD.SPROD_DIASYSTEM, SD.SPRODD_DFINCOTIZ), 24), ' HORAS y ', 
    MOD(TIMESTAMPDIFF(MINUTE, SPROD.SPROD_DIASYSTEM, SD.SPRODD_DFINCOTIZ), 60), ' MINUTOS' 
)SPRODD_TCOTIZACION,
/*				
CONCAT(
FLOOR(HOUR(TIMEDIFF(SD.SPRODD_DFINCOTIZ,SPROD.SPROD_DIASYSTEM)) / 24), ' DIAS ',
MOD(HOUR(TIMEDIFF(SD.SPRODD_DFINCOTIZ,SPROD.SPROD_DIASYSTEM)), 24), ' HORAS ',
MINUTE(TIMEDIFF(SD.SPRODD_DFINCOTIZ,SPROD.SPROD_DIASYSTEM)), ' MINUTOS') SPRODD_TCOTIZACION,
*/
				FORMAT(TIMESTAMPDIFF(SECOND,SPROD.SPROD_DIASYSTEM,SD.SPRODD_DFINCOTIZ)/86400,5) AS SPRODD_TCOTDIAS,
				
				DATE_FORMAT(SD.SPRODD_DSOLICSAP,'%d-%m-%Y %H:%i:%S') SPRODD_DSOLICSAP,	
CONCAT( 
    TIMESTAMPDIFF(DAY, SD.SPRODD_DFINCOTIZ, SD.SPRODD_DSOLICSAP), ' DIAS, ', 
    MOD(TIMESTAMPDIFF(HOUR, SD.SPRODD_DFINCOTIZ, SD.SPRODD_DSOLICSAP), 24), ' HORAS y ', 
    MOD(TIMESTAMPDIFF(MINUTE, SD.SPRODD_DFINCOTIZ, SD.SPRODD_DSOLICSAP), 60), ' MINUTOS' 
)SPRODD_TSAP,
/*				
CONCAT(
FLOOR(HOUR(TIMEDIFF(SD.SPRODD_DSOLICSAP,SD.SPRODD_DFINCOTIZ)) / 24), ' DIAS ',
MOD(HOUR(TIMEDIFF(SD.SPRODD_DSOLICSAP,SD.SPRODD_DFINCOTIZ)), 24), ' HORAS ',
MINUTE(TIMEDIFF(SD.SPRODD_DSOLICSAP,SD.SPRODD_DFINCOTIZ)), ' MINUTOS') SPRODD_TSAP,
*/
				FORMAT(TIMESTAMPDIFF(SECOND,SD.SPRODD_DFINCOTIZ,SD.SPRODD_DSOLICSAP)/86400,5) AS SPRODD_TSAPDIAS,
				
				DATE_FORMAT(SD.SPRODD_DREGSAP,'%d-%m-%Y %H:%i:%S') SPRODD_DREGSAP,
CONCAT( 
    TIMESTAMPDIFF(DAY, SD.SPRODD_DSOLICSAP, SD.SPRODD_DREGSAP), ' DIAS, ', 
    MOD(TIMESTAMPDIFF(HOUR, SD.SPRODD_DSOLICSAP, SD.SPRODD_DREGSAP), 24), ' HORAS y ', 
    MOD(TIMESTAMPDIFF(MINUTE, SD.SPRODD_DSOLICSAP, SD.SPRODD_DREGSAP), 60), ' MINUTOS' 
)SPRODD_TLIBERACION,				
/*				
CONCAT(
FLOOR(HOUR(TIMEDIFF(SD.SPRODD_DREGSAP,SD.SPRODD_DSOLICSAP)) / 24), ' DIAS ',
MOD(HOUR(TIMEDIFF(SD.SPRODD_DREGSAP,SD.SPRODD_DSOLICSAP)), 24), ' HORAS ',
MINUTE(TIMEDIFF(SD.SPRODD_DREGSAP,SD.SPRODD_DSOLICSAP)), ' MINUTOS') SPRODD_TLIBERACION,
*/
				FORMAT(TIMESTAMPDIFF(SECOND,SD.SPRODD_DSOLICSAP,SD.SPRODD_DREGSAP)/86400,5) AS SPRODD_TLIBDIAS,
				
				DATE_FORMAT(SD.SPRODD_DREGHES,'%d-%m-%Y %H:%i:%S') SPRODD_DREGHES,
CONCAT( 
    TIMESTAMPDIFF(DAY, SD.SPRODD_DREGSAP, SD.SPRODD_DREGHES), ' DIAS, ', 
    MOD(TIMESTAMPDIFF(HOUR, SD.SPRODD_DREGSAP, SD.SPRODD_DREGHES), 24), ' HORAS y ', 
    MOD(TIMESTAMPDIFF(MINUTE, SD.SPRODD_DREGSAP, SD.SPRODD_DREGHES), 60), ' MINUTOS' 
)SPRODD_TLLEGADA,					
/*				
CONCAT(
FLOOR(HOUR(TIMEDIFF(SD.SPRODD_DREGHES,SD.SPRODD_DREGSAP)) / 24), ' DIAS ',
MOD(HOUR(TIMEDIFF(SD.SPRODD_DREGHES,SD.SPRODD_DREGSAP)), 24), ' HORAS ',
MINUTE(TIMEDIFF(SD.SPRODD_DREGHES,SD.SPRODD_DREGSAP)), ' MINUTOS') SPRODD_TLLEGADA,
*/
			FORMAT(TIMESTAMPDIFF(SECOND,SD.SPRODD_DREGSAP,SD.SPRODD_DREGHES)/86400,5) AS SPRODD_THESDIAS,

(
CASE WHEN SD.SPRODD_DFINCOTIZ IS NOT NULL THEN
	(
	CASE WHEN SD.SPRODD_DREGHES IS NOT NULL THEN
		/*
		CONCAT(
		FLOOR(HOUR(TIMEDIFF(SD.SPRODD_DREGHES,SPROD.SPROD_DIASYSTEM)) / 24), ' DIAS ',
		MOD(HOUR(TIMEDIFF(SD.SPRODD_DREGHES,SPROD.SPROD_DIASYSTEM)), 24), ' HORAS ',
		MINUTE(TIMEDIFF(SD.SPRODD_DREGHES,SPROD.SPROD_DIASYSTEM)), ' MINUTOS')
		*/
		CONCAT( 
			TIMESTAMPDIFF(DAY,SPROD.SPROD_DIASYSTEM, SD.SPRODD_DREGHES), ' DIAS, ', 
			MOD(TIMESTAMPDIFF(HOUR,SPROD.SPROD_DIASYSTEM, SD.SPRODD_DREGHES), 24), ' HORAS y ', 
			MOD(TIMESTAMPDIFF(MINUTE,SPROD.SPROD_DIASYSTEM, SD.SPRODD_DREGHES), 60), ' MINUTOS' 
		)				
	ELSE
		(
		CASE WHEN SD.SPRODD_DREGSAP IS NOT NULL THEN
			/*
			CONCAT(
			FLOOR(HOUR(TIMEDIFF(SD.SPRODD_DREGSAP,SPROD.SPROD_DIASYSTEM)) / 24), ' DIAS ',
			MOD(HOUR(TIMEDIFF(SD.SPRODD_DREGSAP,SPROD.SPROD_DIASYSTEM)), 24), ' HORAS ',
			MINUTE(TIMEDIFF(SD.SPRODD_DREGSAP,SPROD.SPROD_DIASYSTEM)), ' MINUTOS')
			*/
			CONCAT( 
				TIMESTAMPDIFF(DAY,SPROD.SPROD_DIASYSTEM, SD.SPRODD_DREGSAP), ' DIAS, ', 
				MOD(TIMESTAMPDIFF(HOUR,SPROD.SPROD_DIASYSTEM, SD.SPRODD_DREGSAP), 24), ' HORAS y ', 
				MOD(TIMESTAMPDIFF(MINUTE,SPROD.SPROD_DIASYSTEM, SD.SPRODD_DREGSAP), 60), ' MINUTOS' 
			)			
		ELSE
		(
			CASE WHEN SD.SPRODD_DSOLICSAP IS NOT NULL THEN
				/*
				CONCAT(
				FLOOR(HOUR(TIMEDIFF(SD.SPRODD_DSOLICSAP,SPROD.SPROD_DIASYSTEM)) / 24), ' DIAS ',
				MOD(HOUR(TIMEDIFF(SD.SPRODD_DSOLICSAP,SPROD.SPROD_DIASYSTEM)), 24), ' HORAS ',
				MINUTE(TIMEDIFF(SD.SPRODD_DSOLICSAP,SPROD.SPROD_DIASYSTEM)), ' MINUTOS')
				*/
				CONCAT( 
					TIMESTAMPDIFF(DAY,SPROD.SPROD_DIASYSTEM, SD.SPRODD_DSOLICSAP), ' DIAS, ', 
					MOD(TIMESTAMPDIFF(HOUR,SPROD.SPROD_DIASYSTEM, SD.SPRODD_DSOLICSAP), 24), ' HORAS y ', 
					MOD(TIMESTAMPDIFF(MINUTE,SPROD.SPROD_DIASYSTEM, SD.SPRODD_DSOLICSAP), 60), ' MINUTOS' 
				)			
			ELSE
				/*
				CONCAT(
				FLOOR(HOUR(TIMEDIFF(SD.SPRODD_DFINCOTIZ,SPROD.SPROD_DIASYSTEM)) / 24), ' DIAS ',
				MOD(HOUR(TIMEDIFF(SD.SPRODD_DFINCOTIZ,SPROD.SPROD_DIASYSTEM)), 24), ' HORAS ',
				MINUTE(TIMEDIFF(SD.SPRODD_DFINCOTIZ,SPROD.SPROD_DIASYSTEM)), ' MINUTOS')	
				*/
				CONCAT( 
					TIMESTAMPDIFF(DAY, SPROD.SPROD_DIASYSTEM, SD.SPRODD_DFINCOTIZ), ' DIAS, ', 
					MOD(TIMESTAMPDIFF(HOUR, SPROD.SPROD_DIASYSTEM, SD.SPRODD_DFINCOTIZ), 24), ' HORAS y ', 
					MOD(TIMESTAMPDIFF(MINUTE, SPROD.SPROD_DIASYSTEM, SD.SPRODD_DFINCOTIZ), 60), ' MINUTOS' 
				)				
			END
		)
		END
		)
	END
	)
ELSE '' END
)SPRODD_TIEMPOTOTAL,



(
CASE WHEN SD.SPRODD_DFINCOTIZ IS NOT NULL THEN
	(
	CASE WHEN SD.SPRODD_DREGHES IS NOT NULL THEN
		FORMAT(TIMESTAMPDIFF(SECOND,SPROD.SPROD_DIASYSTEM,SD.SPRODD_DREGHES)/86400,5)
	ELSE
		(
		CASE WHEN SD.SPRODD_DREGSAP IS NOT NULL THEN
			FORMAT(TIMESTAMPDIFF(SECOND,SPROD.SPROD_DIASYSTEM,SD.SPRODD_DREGSAP)/86400,5)
		ELSE
		(
			CASE WHEN SD.SPRODD_DSOLICSAP IS NOT NULL THEN
				FORMAT(TIMESTAMPDIFF(SECOND,SPROD.SPROD_DIASYSTEM,SD.SPRODD_DSOLICSAP)/86400,5)
			ELSE
				FORMAT(TIMESTAMPDIFF(SECOND,SPROD.SPROD_DIASYSTEM,SD.SPRODD_DFINCOTIZ)/86400,5)		
			END
		)
		END
		)
	END
	)
ELSE '' END
)SPRODD_TTOTDIAS


				
				FROM SOLICITUD_PRODUCTOS AS SPROD 
				JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
				JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
				JOIN SPROD_DETALLE SD ON SD.SPROD_ID = SPROD.SPROD_ID 
				LEFT JOIN PRODUCTOS PROD ON PROD.PROD_COD = SD.PROD_COD
				LEFT JOIN CATEGORIA_PRODUCTO CP ON CP.CATPROD_ID = PROD.CATPROD_ID
				left join COTIZ_COMPRA c on SD.sprodd_id = c.sprodd_id and c.cotcom_provsel = 'S'
				WHERE				
				(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
				(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND	
				(SPROD.SPROD_DIA = '$sprod_dia' or '$sprod_dia' = '') AND
				SPROD.SPROD_TIPOSOL = 'SC'
				ORDER BY SPROD.SPROD_DIA ASC";						
		
				
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
		
		mysqli_close($link);
		echo json_encode($resp);
			
	}
		
	
?>