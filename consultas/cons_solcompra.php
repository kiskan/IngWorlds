<?php 

	include('coneccion.php');
	
	if(isset($_GET['enproceso'])){

		$sprod_id = $_GET['sprod_id'];
		$solicitante = $_GET['solicitante'];
		$per_agno = $_GET['per_agno'];		
		$sem_num = $_GET['sem_num'];	
		$sprod_dia = $_GET['sprod_dia'];	
		$UNDVIV_ID = $_GET['UNDVIV_ID'];
		$psprod_tipocompra = $_GET['psprod_tipocompra'];
		$psprod_prioridad = $_GET['psprod_prioridad'];
		$psprod_tipomant = $_GET['psprod_tipomant'];
		//$psprod_codigosap = $_GET['psprod_codigosap'];
		
		/*if(!isset($_GET['psprod_codigosap'])){
		
			$sql = "SELECT DISTINCT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD_ID, US1.USR_NOMBRE AS SOLICITANTE,	
					UNIDAD_VIVEROS.UNDVIV_NOMBRE, SPROD_TIPOCOMPRA, SPROD_PRIORIDAD, SPROD_TIPOMANT, SPROD_MOTIVO, SPROD_COMENCOTIZ,  SPROD_COMENCOMPRA, 
					UNIDAD_VIVEROS.UNDVIV_ID, SPROD.USR_ID_SOLIC
					FROM SOLICITUD_PRODUCTOS AS SPROD 
					JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
					JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
					JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
					WHERE				
					(SPROD.SPROD_ID = '$sprod_id' or '$sprod_id' = '') AND
					(SPROD.USR_ID_SOLIC = '$solicitante' or '$solicitante' = '') AND
					(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
					(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND	
					(SPROD.SPROD_DIA = '$sprod_dia' or '$sprod_dia' = '') AND
					(SPROD.UNDVIV_ID = '$UNDVIV_ID' or '$UNDVIV_ID' = '') AND
					(SPROD.SPROD_TIPOCOMPRA = '$psprod_tipocompra' or '$psprod_tipocompra' = '') AND
					(SPROD.SPROD_PRIORIDAD = '$psprod_prioridad' or '$psprod_prioridad' = '') AND
					(SPROD.SPROD_TIPOMANT = '$psprod_tipomant' or '$psprod_tipomant' = '') AND
					SPROD.SPROD_ESTADO = 'EN PROCESO' AND SPROD_TIPOSOL = 'SC'
					ORDER BY SPROD.SPROD_DIA ASC";		
		}			
		else{		
			$psprod_codigosap = $_GET['psprod_codigosap'];*/
			$sql = "SELECT DISTINCT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD_ID, US1.USR_NOMBRE AS SOLICITANTE,	
					UNIDAD_VIVEROS.UNDVIV_NOMBRE, SPROD_TIPOCOMPRA, SPROD_PRIORIDAD, SPROD_TIPOMANT, SPROD_MOTIVO, SPROD_COMENCOTIZ, /*SPROD_CODIGOSAP,*/ SPROD_COMENCOMPRA, 
					UNIDAD_VIVEROS.UNDVIV_ID, SPROD.USR_ID_SOLIC
					FROM SOLICITUD_PRODUCTOS AS SPROD 
					JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
					JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
					JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
					WHERE				
					(SPROD.SPROD_ID = '$sprod_id' or '$sprod_id' = '') AND
					(SPROD.USR_ID_SOLIC = '$solicitante' or '$solicitante' = '') AND
					(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
					(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND	
					(SPROD.SPROD_DIA = '$sprod_dia' or '$sprod_dia' = '') AND
					(SPROD.UNDVIV_ID = '$UNDVIV_ID' or '$UNDVIV_ID' = '') AND
					(SPROD.SPROD_TIPOCOMPRA = '$psprod_tipocompra' or '$psprod_tipocompra' = '') AND
					(SPROD.SPROD_PRIORIDAD = '$psprod_prioridad' or '$psprod_prioridad' = '') AND
					(SPROD.SPROD_TIPOMANT = '$psprod_tipomant' or '$psprod_tipomant' = '') AND
					/*(SPROD.SPROD_CODIGOSAP = '$psprod_codigosap' or '$psprod_codigosap' = '') AND*/
					SPROD.SPROD_ESTADO = 'EN PROCESO' AND SPROD_TIPOSOL = 'SC'
					ORDER BY SPROD.SPROD_DIA ASC";						
		//}		
				
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
		

	
	if(isset($_GET['terminados'])){

		$sprod_id = $_GET['sprod_id'];
		$solicitante = $_GET['solicitante'];
		$per_agno = $_GET['per_agno'];		
		$sem_num = $_GET['sem_num'];	
		$sprod_dia = $_GET['sprod_dia'];	
		$UNDVIV_ID = $_GET['UNDVIV_ID'];
		$tsprod_tipocompra = $_GET['tsprod_tipocompra'];
		$tsprod_prioridad = $_GET['tsprod_prioridad'];
		$tsprod_tipomant = $_GET['tsprod_tipomant'];
		//$tsprod_codigosap = $_GET['tsprod_codigosap'];
		
		$sql = "SELECT DISTINCT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD_ID, US1.USR_NOMBRE AS SOLICITANTE,	
				UNIDAD_VIVEROS.UNDVIV_NOMBRE, SPROD_TIPOCOMPRA, SPROD_PRIORIDAD, SPROD_TIPOMANT, SPROD_MOTIVO, SPROD_COMENCOTIZ, /*SPROD_CODIGOSAP,*/ SPROD_COMENCOMPRA, 
				UNIDAD_VIVEROS.UNDVIV_ID, SPROD.USR_ID_SOLIC
				FROM SOLICITUD_PRODUCTOS AS SPROD 
				JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
				JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
				JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
				WHERE				
				(SPROD.SPROD_ID = '$sprod_id' or '$sprod_id' = '') AND
				(SPROD.USR_ID_SOLIC = '$solicitante' or '$solicitante' = '') AND
				(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
				(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND	
				(SPROD.SPROD_DIA = '$sprod_dia' or '$sprod_dia' = '') AND
				(SPROD.UNDVIV_ID = '$UNDVIV_ID' or '$UNDVIV_ID' = '') AND
				(SPROD.SPROD_TIPOCOMPRA = '$tsprod_tipocompra' or '$tsprod_tipocompra' = '') AND
				(SPROD.SPROD_PRIORIDAD = '$tsprod_prioridad' or '$tsprod_prioridad' = '') AND
				(SPROD.SPROD_TIPOMANT = '$tsprod_tipomant' or '$tsprod_tipomant' = '') AND
				/*(SPROD.SPROD_CODIGOSAP = '$tsprod_codigosap' or '$tsprod_codigosap' = '') AND*/
				SPROD.SPROD_ESTADO = 'COMPRA TERMINADA' AND SPROD_TIPOSOL = 'SC'
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
	
	elseif(isset($_GET['totales'])){

		$sprod_id = $_GET['sprod_id'];
		$sprod_codigosap = $_GET['sprod_codigosap'];
		$cotcom_hes = $_GET['cotcom_hes'];
		//$cotcom_codigosap = $_GET['cotcom_codigosap'];
		$sprod_estado = $_GET['sprod_estado'];
		$solicitante = $_GET['solicitante'];
		$per_agno = $_GET['per_agno'];		
		$sem_num = $_GET['sem_num'];	
		$sprod_dia = $_GET['sprod_dia'];	
		
		$UNDVIV_ID = $_GET['UNDVIV_ID'];
		$sprod_tipocompra = $_GET['sprod_tipocompra'];
		$sprod_prioridad = $_GET['sprod_prioridad'];		
		$sprod_tipomant = $_GET['sprod_tipomant'];
		$catprod_id = $_GET['catprod_id'];	
		$prod_cod = $_GET['prod_cod'];
		$cc_id = $_GET['cc_id'];
		
		
		$sql = "SELECT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD.SPROD_ID, /*SPROD.SPROD_CODIGOSAP,*/ SPROD.SPROD_ESTADO,US1.USR_NOMBRE AS SOLICITANTE, CP.CATPROD_NOMBRE, (CASE WHEN SPROD.SPROD_TIPOCOMPRA = 'COMPRA MATERIAL' THEN PROD.PROD_NOMBRE WHEN SPROD.SPROD_TIPOCOMPRA = 'PRESTACIÓN SERVICIO' THEN SD.SPRODD_SERVICIO ELSE '' END) PROD_SERV, CC.CC_NOMBRE, SD.SPRODR_ESTADO, SD.SPRODD_CANT, COM.COTCOM_CANTIDAD, COT.COTCOM_PROVEEDOR, IFNULL(CONCAT(DATE_FORMAT(COM.COTCOM_DENTREGA,'%d-%m-%Y'), ' ', COM.COTCOM_HENTREGA),'') as COTCOM_FECHAENTREGA, COM.COTCOM_PRECIO,
		
		(CASE 
			WHEN SPROD.SPROD_TIPOCOMPRA = 'COMPRA MATERIAL' THEN COT.COTCOM_PRECIO*COT.COTCOM_CANTIDAD
		/*	(select c.COTCOM_PRECIO*c.COTCOM_CANTIDAD from COTIZ_COMPRA c where c.sprodd_id = COM.SPRODD_ID and c.cotcom_provsel = 'S')
		(COM.COTCOM_PRECIO * COM.COTCOM_CANTIDAD)*/		
			WHEN SPROD.SPROD_TIPOCOMPRA = 'PRESTACIÓN SERVICIO' THEN COM.COTCOM_PRECIO ELSE '' END) AS TOTAL_COSTO, 
		
		(CASE WHEN COM.COTCOM_TIPO = 'COMPRA' THEN COT.COTCOM_ACORDADO ELSE 0 END)
		AS COTCOM_ACORDADO, 
		
		(CASE WHEN SPROD.SPROD_TIPOCOMPRA = 'COMPRA MATERIAL' THEN COM.COTCOM_PRECIO * COM.COTCOM_CANTIDAD
		/*(select c.COTCOM_PRECIO*c.COTCOM_CANTIDAD from COTIZ_COMPRA c where c.sprodd_id = COM.SPRODD_ID and c.cotcom_provsel = 'S')
		(COM.COTCOM_PRECIO * COM.COTCOM_CANTIDAD)*/		
		WHEN SPROD.SPROD_TIPOCOMPRA = 'PRESTACIÓN SERVICIO' THEN COM.COTCOM_PRECIO ELSE 0 END) - /*COTCOM_ACORDADO*/
		(CASE WHEN COM.COTCOM_TIPO = 'COMPRA' THEN COM.COTCOM_ACORDADO ELSE 0 END)
		AS COTCOM_PENDIENTE, 
		
		COM.COTCOM_AVANCE, COM.COTCOM_HES, COM.COTCOM_CODIGOSAP, UNIDAD_VIVEROS.UNDVIV_NOMBRE, SPROD.SPROD_TIPOCOMPRA, SPROD.SPROD_PRIORIDAD, SPROD.SPROD_TIPOMANT, SPROD.SPROD_MOTIVO, SPROD.SPROD_COMENCOTIZ, SPROD.SPROD_COMENCOMPRA, IFNULL(SD.SPRODD_CODIGOSAP,'')SPRODD_CODIGOSAP

				FROM SOLICITUD_PRODUCTOS AS SPROD 
				JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
				JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
				JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
				JOIN SPROD_DETALLE SD ON SD.SPROD_ID = SPROD.SPROD_ID 
				LEFT JOIN PRODUCTOS PROD ON PROD.PROD_COD = SD.PROD_COD
				LEFT JOIN CATEGORIA_PRODUCTO CP ON CP.CATPROD_ID = PROD.CATPROD_ID
				LEFT JOIN COTIZ_COMPRA COT ON COT.SPRODD_ID = SD.SPRODD_ID AND COT.COTCOM_PROVSEL = 'S'
				LEFT JOIN COTIZ_COMPRA COM ON COM.SPRODD_ID = SD.SPRODD_ID AND COM.COTCOM_TIPO = 'COMPRA'
				LEFT JOIN CUENTA_CONTABLE CC ON CC.CC_ID = SD.CC_ID
				WHERE
				 SPROD_TIPOSOL = 'SC' AND
				(SPROD.SPROD_ID = '$sprod_id' or '$sprod_id' = '') AND
				(SD.SPRODD_CODIGOSAP = '$sprod_codigosap' or '$sprod_codigosap' = '') AND
				(COM.COTCOM_HES = '$cotcom_hes' or '$cotcom_hes' = '') AND
				/*(COM.COTCOM_CODIGOSAP = '$cotcom_codigosap' or '$cotcom_codigosap' = '') AND*/
				(SPROD.SPROD_ESTADO = '$sprod_estado' or '$sprod_estado' = '') AND
				(SPROD.USR_ID_SOLIC = '$solicitante' or '$solicitante' = '') AND
				(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
				(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND	
				(SPROD.SPROD_DIA = '$sprod_dia' or '$sprod_dia' = '') AND
				
				(SPROD.UNDVIV_ID = '$UNDVIV_ID' or '$UNDVIV_ID' = '') AND
				(SPROD.SPROD_TIPOCOMPRA = '$sprod_tipocompra' or '$sprod_tipocompra' = '') AND
				(SPROD.SPROD_PRIORIDAD = '$sprod_prioridad' or '$sprod_prioridad' = '') AND
				(SPROD.SPROD_TIPOMANT = '$sprod_tipomant' or '$sprod_tipomant' = '') AND
				(CP.CATPROD_ID = '$catprod_id' or '$catprod_id' = '') AND				
				(PROD.PROD_COD = '$prod_cod' or '$prod_cod' = '') AND
				(SD.CC_ID = '$cc_id' or '$cc_id' = '') 
				ORDER BY SPROD.SPROD_DIA DESC, SPROD.SPROD_ID";			
				
/*
//SPROD_ID, SPROD_CODIGOSAP, COTCOM_HES, SPROD_ESTADO, SOLICITANTE, PER_AGNO, SEM_NUM, SPROD_DIA, 
//UNDVIV_ID, SPROD_TIPOCOMPRA, SPROD_PRIORIDAD, SPROD_TIPOMANT, CATPROD_ID, PROD_COD, CC_ID		
*/
				
				
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