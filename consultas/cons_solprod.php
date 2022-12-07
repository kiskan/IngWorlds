<?php 

	include('coneccion.php');
	
	if(isset($_GET['aceptadas'])){

		$sprod_id = $_GET['sprod_id'];
		$solicitante = $_GET['solicitante'];
		$per_agno = $_GET['per_agno'];		
		$sem_num = $_GET['sem_num'];	
		$sprod_dia = $_GET['sprod_dia'];	
		$UNDVIV_ID = $_GET['UNDVIV_ID'];
		//$destinatario = $_GET['destinatario'];	
		
		$destinatariox = explode("**" , $_GET['destinatario']);
		$destinatario = $destinatariox[0];	
		$sprod_tipodest = $destinatariox[1];
	
		$destinatario_usuario = '';	
		$destinatario_operador = '';
		switch($sprod_tipodest){				
			case 'U':
				$destinatario_usuario = $destinatario;
				break;
			case 'O':
				$destinatario_operador = $destinatario;		
				break;
		}	
		
		$sql = "SELECT DISTINCT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD_ID, US1.USR_NOMBRE AS SOLICITANTE,	
				UNIDAD_VIVEROS.UNDVIV_NOMBRE,
				(CASE WHEN SPROD_TIPODEST = 'U' THEN US.USR_NOMBRE WHEN SPROD_TIPODEST = 'O' THEN CONCAT(OP.OPER_NOMBRES,' ',OP.OPER_PATERNO,' ',OP.OPER_MATERNO) ELSE '' END) as DESTINATARIO,
				CONCAT(DATE_FORMAT(SPROD_DENTREGA,'%d-%m-%Y'), ' ', SPROD_HENTREGA) as FECHA_ENTREGA, DATE_FORMAT(SPROD_DRENTREGA,'%d-%m-%Y %H:%i') FECHA_RENTREGA, 
				(CASE WHEN SPROD_TIPORETIRA = 'U' THEN US2.USR_NOMBRE WHEN SPROD_TIPORETIRA = 'O' THEN CONCAT(OP2.OPER_NOMBRES,' ',OP2.OPER_PATERNO,' ',OP2.OPER_MATERNO) ELSE '' END) as QUIEN_RETIRA, SPROD.SPROD_COMENTARIO COMENTARIO
				FROM SOLICITUD_PRODUCTOS AS SPROD 
				JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
				JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
				LEFT JOIN USUARIOS AS US ON US.USR_ID = SPROD.USR_ID_DEST
				JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
				LEFT JOIN USUARIOS AS US2 ON US2.USR_ID = SPROD.USR_ID_RETIRA
				LEFT JOIN OPERADOR AS OP ON OP.OPER_RUT = SPROD.OPER_RUT_DEST
				LEFT JOIN OPERADOR AS OP2 ON OP2.OPER_RUT = SPROD.OPER_RUT_RETIRA
				WHERE				
				(SPROD.SPROD_ID = '$sprod_id' or '$sprod_id' = '') AND
				(SPROD.USR_ID_SOLIC = '$solicitante' or '$solicitante' = '') AND
				(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
				(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND	
				(SPROD.SPROD_DIA = '$sprod_dia' or '$sprod_dia' = '') AND
				(SPROD.UNDVIV_ID = '$UNDVIV_ID' or '$UNDVIV_ID' = '') AND
				(SPROD.USR_ID_DEST = '$destinatario_usuario' or '$destinatario_usuario' = '') AND
				(SPROD.OPER_RUT_DEST = '$destinatario_operador' or '$destinatario_operador' = '') AND
				 SPROD_TIPOSOL = 'SM' AND (SPROD.SPROD_ESTADO = 'ACEPTADA' /*OR SPROD.SPROD_ESTADO = 'ENTREGADA'*/)
				ORDER BY SPROD.SPROD_DIA DESC, SPROD.SPROD_ID";			
				
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
	
	elseif(isset($_GET['solaceptadas'])){

		$sprod_id = $_GET['sprod_id'];
		$solicitante = $_GET['solicitante'];
		$per_agno = $_GET['per_agno'];		
		$sem_num = $_GET['sem_num'];	
		$sprod_dia = $_GET['sprod_dia'];	
		$UNDVIV_ID = $_GET['UNDVIV_ID'];
		//$destinatario = $_GET['destinatario'];	
		
		$destinatariox = explode("**" , $_GET['destinatario']);
		$destinatario = $destinatariox[0];	
		$sprod_tipodest = $destinatariox[1];
	
		$destinatario_usuario = '';	
		$destinatario_operador = '';
		switch($sprod_tipodest){				
			case 'U':
				$destinatario_usuario = $destinatario;
				break;
			case 'O':
				$destinatario_operador = $destinatario;		
				break;
		}	
		
		$sql = "SELECT DISTINCT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD_ID, US1.USR_NOMBRE AS SOLICITANTE,	
				UNIDAD_VIVEROS.UNDVIV_NOMBRE,
				(CASE WHEN SPROD_TIPODEST = 'U' THEN US.USR_NOMBRE WHEN SPROD_TIPODEST = 'O' THEN CONCAT(OP.OPER_NOMBRES,' ',OP.OPER_PATERNO,' ',OP.OPER_MATERNO) ELSE '' END) as DESTINATARIO,
				CONCAT(DATE_FORMAT(SPROD_DENTREGA,'%d-%m-%Y'), ' ', SPROD_HENTREGA) as FECHA_ENTREGA, DATE_FORMAT(SPROD_DRENTREGA,'%d-%m-%Y %H:%i') FECHA_RENTREGA, 
				(CASE WHEN SPROD_TIPORETIRA = 'U' THEN US2.USR_NOMBRE WHEN SPROD_TIPORETIRA = 'O' THEN CONCAT(OP2.OPER_NOMBRES,' ',OP2.OPER_PATERNO,' ',OP2.OPER_MATERNO) ELSE '' END) as QUIEN_RETIRA, SPROD.SPROD_COMENTARIO COMENTARIO
				FROM SOLICITUD_PRODUCTOS AS SPROD 
				JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
				JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
				LEFT JOIN USUARIOS AS US ON US.USR_ID = SPROD.USR_ID_DEST
				JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
				LEFT JOIN USUARIOS AS US2 ON US2.USR_ID = SPROD.USR_ID_RETIRA
				LEFT JOIN OPERADOR AS OP ON OP.OPER_RUT = SPROD.OPER_RUT_DEST
				LEFT JOIN OPERADOR AS OP2 ON OP2.OPER_RUT = SPROD.OPER_RUT_RETIRA
				WHERE				
				(SPROD.SPROD_ID = '$sprod_id' or '$sprod_id' = '') AND
				(SPROD.USR_ID_SOLIC = '$solicitante' or '$solicitante' = '') AND
				(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
				(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND	
				(SPROD.SPROD_DIA = '$sprod_dia' or '$sprod_dia' = '') AND
				(SPROD.UNDVIV_ID = '$UNDVIV_ID' or '$UNDVIV_ID' = '') AND
				(SPROD.USR_ID_DEST = '$destinatario_usuario' or '$destinatario_usuario' = '') AND
				(SPROD.OPER_RUT_DEST = '$destinatario_operador' or '$destinatario_operador' = '') AND
				 SPROD_TIPOSOL = 'SM' AND (SPROD.SPROD_ESTADO = 'ACEPTADA' OR SPROD.SPROD_ESTADO = 'ENTREGADA')
				ORDER BY SPROD.SPROD_DIA DESC, SPROD.SPROD_ID";			
				
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
	
	
		
	elseif(isset($_GET['prod_aceptados'])){

		$sprod_id = $_GET['sprod_id'];
		
		$sql = "SELECT sd.SPRODR_ESTADO as RESOLUCION, c.CATPROD_NOMBRE as CATEGORIA, p.PROD_NOMBRE as PRODUCTO, sd.SPRODD_CANT as CANT_SOLICITADA, sd.SPRODR_CANT as CANT_ACEPTADA
		from PRODUCTOS p
		left join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id 
		join SPROD_DETALLE sd on sd.prod_cod = p.prod_cod
		WHERE sd.sprod_id = $sprod_id
		ORDER BY c.catprod_nombre,p.PROD_NOMBRE ASC";			
		
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
	
	elseif(isset($_GET['rechazadas'])){
		
		$sprod_id = $_GET['sprod_id'];
		$solicitante = $_GET['solicitante'];
		$per_agno = $_GET['per_agno'];		
		$sem_num = $_GET['sem_num'];	
		$sprod_dia = $_GET['sprod_dia'];	
		$UNDVIV_ID = $_GET['UNDVIV_ID'];
		//$destinatario = $_GET['destinatario'];	
		
		$destinatariox = explode("**" , $_GET['destinatario']);
		$destinatario = $destinatariox[0];	
		$sprod_tipodest = $destinatariox[1];
	
		$destinatario_usuario = '';	
		$destinatario_operador = '';
		switch($sprod_tipodest){				
			case 'U':
				$destinatario_usuario = $destinatario;
				break;
			case 'O':
				$destinatario_operador = $destinatario;		
				break;
		}		
		
		$sql = "SELECT DISTINCT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD_ID, US1.USR_NOMBRE AS SOLICITANTE,	
				UNIDAD_VIVEROS.UNDVIV_NOMBRE,
				(CASE WHEN SPROD_TIPODEST = 'U' THEN US.USR_NOMBRE WHEN SPROD_TIPODEST = 'O' THEN CONCAT(OP.OPER_NOMBRES,' ',OP.OPER_PATERNO,' ',OP.OPER_MATERNO) ELSE '' END) as DESTINATARIO,
				SPROD.SPROD_COMENTARIO COMENTARIO
				FROM SOLICITUD_PRODUCTOS AS SPROD 
				JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
				JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
				LEFT JOIN USUARIOS AS US ON US.USR_ID = SPROD.USR_ID_DEST
				JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
				LEFT JOIN USUARIOS AS US2 ON US2.USR_ID = SPROD.USR_ID_RETIRA
				LEFT JOIN OPERADOR AS OP ON OP.OPER_RUT = SPROD.OPER_RUT_DEST
				LEFT JOIN OPERADOR AS OP2 ON OP2.OPER_RUT = SPROD.OPER_RUT_RETIRA
				WHERE
				(SPROD.SPROD_ID = '$sprod_id' or '$sprod_id' = '') AND
				(SPROD.USR_ID_SOLIC = '$solicitante' or '$solicitante' = '') AND
				(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
				(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND	
				(SPROD.SPROD_DIA = '$sprod_dia' or '$sprod_dia' = '') AND
				(SPROD.UNDVIV_ID = '$UNDVIV_ID' or '$UNDVIV_ID' = '') AND
				(SPROD.USR_ID_DEST = '$destinatario_usuario' or '$destinatario_usuario' = '') AND
				(SPROD.OPER_RUT_DEST = '$destinatario_operador' or '$destinatario_operador' = '') AND
				SPROD.SPROD_ESTADO = 'RECHAZADA' AND SPROD_TIPOSOL = 'SM'
				ORDER BY SPROD.SPROD_DIA DESC, SPROD.SPROD_ID";			
				
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
	elseif(isset($_GET['prod_rechazados'])){

		$sprod_id = $_GET['sprod_id'];
		
		$sql = "SELECT c.CATPROD_NOMBRE as CATEGORIA, p.PROD_NOMBRE as PRODUCTO, sd.SPRODD_CANT as CANT_SOLICITADA
		from PRODUCTOS p
		left join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id 
		join SPROD_DETALLE sd on sd.prod_cod = p.prod_cod
		WHERE sd.sprod_id = $sprod_id
		ORDER BY c.catprod_nombre,p.PROD_NOMBRE ASC";			
		
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
	
	if(isset($_GET['entregadas'])){

		$sprod_id = $_GET['sprod_id'];
		$solicitante = $_GET['solicitante'];
		$per_agno = $_GET['per_agno'];		
		$sem_num = $_GET['sem_num'];	
		$sprod_dia = $_GET['sprod_dia'];	
		$UNDVIV_ID = $_GET['UNDVIV_ID'];
		//$destinatario = $_GET['destinatario'];	
		
		$destinatariox = explode("**" , $_GET['destinatario']);
		$destinatario = $destinatariox[0];	
		$sprod_tipodest = $destinatariox[1];
	
		$destinatario_usuario = '';	
		$destinatario_operador = '';
		switch($sprod_tipodest){				
			case 'U':
				$destinatario_usuario = $destinatario;
				break;
			case 'O':
				$destinatario_operador = $destinatario;		
				break;
		}		
		
		$catprod_id = $_GET['catprod_id'];
		$prod_cod = $_GET['prod_cod'];	
		
		$sql = "SELECT DISTINCT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD.SPROD_ID, US1.USR_NOMBRE AS SOLICITANTE,	
				UNIDAD_VIVEROS.UNDVIV_NOMBRE,
				(CASE WHEN SPROD_TIPODEST = 'U' THEN US.USR_NOMBRE WHEN SPROD_TIPODEST = 'O' THEN CONCAT(OP.OPER_NOMBRES,' ',OP.OPER_PATERNO,' ',OP.OPER_MATERNO) ELSE '' END) as DESTINATARIO,
				CONCAT(DATE_FORMAT(SPROD_DENTREGA,'%d-%m-%Y'), ' ', SPROD_HENTREGA) as FECHA_ENTREGA, CONCAT(DATE_FORMAT(SPROD_DRENTREGA,'%d-%m-%Y'), ' ', SPROD_HRENTREGA) FECHA_RENTREGA, 
				(CASE WHEN SPROD_TIPORETIRA = 'U' THEN US2.USR_NOMBRE WHEN SPROD_TIPORETIRA = 'O' THEN CONCAT(OP2.OPER_NOMBRES,' ',OP2.OPER_PATERNO,' ',OP2.OPER_MATERNO) ELSE '' END) as QUIEN_RETIRA, SPROD.SPROD_COMENTARIO COMENTARIO
				FROM SOLICITUD_PRODUCTOS AS SPROD 
				JOIN SPROD_DETALLE SD ON SD.SPROD_ID = SPROD.SPROD_ID 
				JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
				JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
				LEFT JOIN USUARIOS AS US ON US.USR_ID = SPROD.USR_ID_DEST
				JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
				LEFT JOIN USUARIOS AS US2 ON US2.USR_ID = SPROD.USR_ID_RETIRA
				LEFT JOIN OPERADOR AS OP ON OP.OPER_RUT = SPROD.OPER_RUT_DEST
				LEFT JOIN OPERADOR AS OP2 ON OP2.OPER_RUT = SPROD.OPER_RUT_RETIRA
				JOIN PRODUCTOS PROD ON PROD.PROD_COD = SD.PROD_COD
				left JOIN CATEGORIA_PRODUCTO CP ON CP.CATPROD_ID = PROD.CATPROD_ID				
				WHERE
				(SPROD.SPROD_ID = '$sprod_id' or '$sprod_id' = '') AND
				(SPROD.USR_ID_SOLIC = '$solicitante' or '$solicitante' = '') AND
				(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
				(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND	
				(SPROD.SPROD_DIA = '$sprod_dia' or '$sprod_dia' = '') AND
				(SPROD.UNDVIV_ID = '$UNDVIV_ID' or '$UNDVIV_ID' = '') AND
				(SPROD.USR_ID_DEST = '$destinatario_usuario' or '$destinatario_usuario' = '') AND
				(SPROD.OPER_RUT_DEST = '$destinatario_operador' or '$destinatario_operador' = '') AND
				(CP.CATPROD_ID = '$catprod_id' or '$catprod_id' = '') AND
				(PROD.PROD_COD = '$prod_cod' or '$prod_cod' = '') AND				
				SPROD.SPROD_ESTADO = 'ENTREGADA' AND IFNULL(SPROD_SALIDABOD,'N') <> 'S' AND SPROD_TIPOSOL = 'SM'
				ORDER BY SPROD.SPROD_DIA DESC, SPROD.SPROD_ID";		
	
				
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
	
	elseif(isset($_GET['prod_entregados'])){

		$sprod_id = $_GET['sprod_id'];
		
		$sql = "SELECT sd.SPRODR_ESTADO as RESOLUCION, c.CATPROD_NOMBRE as CATEGORIA, p.PROD_NOMBRE as PRODUCTO, sd.SPRODD_CANT as CANT_SOLICITADA, sd.SPRODR_CANT as CANT_ACEPTADA
		from PRODUCTOS p
		left join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id 
		join SPROD_DETALLE sd on sd.prod_cod = p.prod_cod
		WHERE sd.sprod_id = $sprod_id
		ORDER BY c.catprod_nombre,p.PROD_NOMBRE ASC";			
		
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
	
	
	//MONITOREO ORDENES SOLICITUDES

	elseif(isset($_GET['totales'])){

		$sprod_id = $_GET['sprod_id'];
		$solicitante = $_GET['solicitante'];
		$per_agno = $_GET['per_agno'];		
		$sem_num = $_GET['sem_num'];	
		$sprod_dia = $_GET['sprod_dia'];	
		$UNDVIV_ID = $_GET['UNDVIV_ID'];
		$destinatario = $_GET['destinatario'];
		$sprod_estado = $_GET['sprod_estado'];

		$destinatario_usuario = '';	
		$destinatario_operador = '';		

		if($destinatario <> ''){
			$destinatariox = explode("**" ,$destinatario);
			$destinatario = $destinatariox[0];	
			$sprod_tipodest = $destinatariox[1];		
		

			switch($sprod_tipodest){				
				case 'U':
					$destinatario_usuario = $destinatario;
					break;
				case 'O':
					$destinatario_operador = $destinatario;		
					break;
			}			
		}
		
		//$catprod_id = $_GET['catprod_id'];
		$prod_cod = $_GET['prod_cod'];		
		
		$sql = "SELECT DISTINCT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD.SPROD_ID, SPROD.SPROD_ESTADO, UV.UNDVIV_NOMBRE,	
				 US1.USR_NOMBRE AS SOLICITANTE, SD.SPRODR_ESTADO, PROD.PROD_NOMBRE, PROD.SAP_NOMBRE, SD.SPRODD_CANT, SD.SPRODR_CANT, PROD.PROD_VALOR, PROD.PROD_VALOR * IFNULL(SD.SPRODR_CANT,0) AS COSTO_TOTAL,
				(CASE WHEN SPROD_TIPODEST = 'U' THEN US.USR_NOMBRE WHEN SPROD_TIPODEST = 'O' THEN CONCAT(OP.OPER_NOMBRES,' ',OP.OPER_PATERNO,' ',OP.OPER_MATERNO) ELSE '' END) as DESTINATARIO,
				CONCAT(DATE_FORMAT(SPROD_DENTREGA,'%d-%m-%Y'), ' ', SPROD_HENTREGA) as FECHA_ENTREGA, DATE_FORMAT(SPROD_DRENTREGA,'%d-%m-%Y %H:%i') FECHA_RENTREGA, 
				(CASE WHEN SPROD_TIPORETIRA = 'U' THEN US2.USR_NOMBRE WHEN SPROD_TIPORETIRA = 'O' THEN CONCAT(OP2.OPER_NOMBRES,' ',OP2.OPER_PATERNO,' ',OP2.OPER_MATERNO) ELSE '' END) as QUIEN_RETIRA, SPROD.SPROD_COMENTARIO COMENTARIO
				FROM SOLICITUD_PRODUCTOS AS SPROD 
				JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
				JOIN UNIDAD_VIVEROS UV ON UV.UNDVIV_ID = SPROD.UNDVIV_ID
				LEFT JOIN USUARIOS AS US ON US.USR_ID = SPROD.USR_ID_DEST
				JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
				LEFT JOIN USUARIOS AS US2 ON US2.USR_ID = SPROD.USR_ID_RETIRA
				LEFT JOIN OPERADOR AS OP ON OP.OPER_RUT = SPROD.OPER_RUT_DEST
				LEFT JOIN OPERADOR AS OP2 ON OP2.OPER_RUT = SPROD.OPER_RUT_RETIRA
				JOIN SPROD_DETALLE SD ON SD.SPROD_ID = SPROD.SPROD_ID 
				JOIN PRODUCTOS PROD ON PROD.PROD_COD = SD.PROD_COD
				left JOIN CATEGORIA_PRODUCTO CP ON CP.CATPROD_ID = PROD.CATPROD_ID
				WHERE
				 SPROD_TIPOSOL = 'SM' AND
				(SPROD.SPROD_ID = '$sprod_id' or '$sprod_id' = '') AND
				(SPROD.USR_ID_SOLIC = '$solicitante' or '$solicitante' = '') AND
				(SEM.PER_AGNO = '$per_agno' or '$per_agno' = '') AND
				(SEM.SEM_NUM = '$sem_num' or '$sem_num' = '') AND	
				(SPROD.SPROD_DIA = '$sprod_dia' or '$sprod_dia' = '') AND
				(SPROD.UNDVIV_ID = '$UNDVIV_ID' or '$UNDVIV_ID' = '') AND
				(SPROD.USR_ID_DEST = '$destinatario_usuario' or '$destinatario_usuario' = '') AND
				(SPROD.OPER_RUT_DEST = '$destinatario_operador' or '$destinatario_operador' = '') AND
				/*(CP.CATPROD_ID = '$catprod_id' or '$catprod_id' = '') AND*/
				(SPROD.SPROD_ESTADO = '$sprod_estado' or '$sprod_estado' = '') AND
				(PROD.PROD_COD = '$prod_cod' or '$prod_cod' = '') 
				ORDER BY SPROD.SPROD_DIA DESC, SPROD.SPROD_ID";			
				
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