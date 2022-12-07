<?php 
	date_default_timezone_set("Chile/Continental");
	$fecha_reg = date("Y-m-d H:i:s",time());	
	$hoy = date("Ymd");

	//Salida Forzosa
	function salida($resp){	
		//mysqli_close($link);
		echo json_encode($resp);
		exit();
	}
	
	//Salida Forzosa con rollback
	function salida_con_rollback($resp,$link){	
		mysqli_rollback($link);
		mysqli_close($link);
		echo json_encode($resp);
		exit();
	}	
	
	//Formateo RUT	
	function formateo_rut( $rut ) {
		
		if(trim($rut) == '') return '';
		$rut = trim($rut);
		$rut= strtoupper($rut);
		$rut = str_replace(".", "",$rut);
		$rut = str_replace("-", "",$rut);	

		return number_format( substr ( $rut, 0 , -1 ) , 0, "", ".") . '-' . substr ( $rut, strlen($rut) -1 , 1 );
	}	
	
	
	function random_color_part() {
		return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
	}

	function random_color() {
		return random_color_part() . random_color_part() . random_color_part();
	}
	
	function random_email(){
		
		$email = array("operaciones@ing-worlds.cl","operaciones1@ing-worlds.cl","operaciones2@ing-worlds.cl","operaciones3@ing-worlds.cl"
      ,"operaciones4@ing-worlds.cl","operaciones5@ing-worlds.cl","operaciones6@ing-worlds.cl","operaciones7@ing-worlds.cl"
	  ,"operaciones8@ing-worlds.cl","operaciones9@ing-worlds.cl","operaciones10@ing-worlds.cl","operaciones11@ing-worlds.cl"
	  ,"operaciones12@ing-worlds.cl","operaciones13@ing-worlds.cl","operaciones14@ing-worlds.cl","operaciones15@ing-worlds.cl"
	  ,"operaciones16@ing-worlds.cl","operaciones17@ing-worlds.cl","operaciones18@ing-worlds.cl","operaciones19@ing-worlds.cl"
	  ,"operaciones20@ing-worlds.cl","operaciones21@ing-worlds.cl","operaciones22@ing-worlds.cl","operaciones23@ing-worlds.cl"
	  ,"operaciones24@ing-worlds.cl","operaciones25@ing-worlds.cl","operaciones26@ing-worlds.cl","operaciones27@ing-worlds.cl"
	  ,"operaciones28@ing-worlds.cl","operaciones29@ing-worlds.cl","operaciones30@ing-worlds.cl","operaciones31@ing-worlds.cl"
	  ,"operaciones32@ing-worlds.cl","operaciones33@ing-worlds.cl","operaciones34@ing-worlds.cl","operaciones35@ing-worlds.cl"
	  ,"operaciones36@ing-worlds.cl","operaciones37@ing-worlds.cl","operaciones38@ing-worlds.cl","operaciones39@ing-worlds.cl"
	  ,"operaciones40@ing-worlds.cl","operaciones41@ing-worlds.cl","operaciones42@ing-worlds.cl","operaciones43@ing-worlds.cl"
	  ,"operaciones44@ing-worlds.cl","operaciones45@ing-worlds.cl","operaciones46@ing-worlds.cl","operaciones47@ing-worlds.cl"
	  ,"operaciones48@ing-worlds.cl","operaciones49@ing-worlds.cl","operaciones50@ing-worlds.cl");
		$email_aleatorio = array_rand($email);
		return $email[$email_aleatorio];
	}	
	

	//Envío de email
	function enviar_email($asunto,$sprod_id){
		require("../Informes/class.phpmailer.php");
		include('coneccion.php');
		
		$sql = "SELECT SPROD_COMENTARIO, U.USR_NOMBRE,DATE_FORMAT(SPROD_DENTREGA,'%d-%m-%Y') as SPROD_DENTREGA, SPROD_HENTREGA,DATE_FORMAT(SPROD_DRENTREGA,'%d-%m-%Y') as SPROD_DRENTREGA, SPROD_HRENTREGA,		
		(CASE WHEN SPROD_TIPORETIRA = 'U' THEN US2.USR_NOMBRE WHEN SPROD_TIPORETIRA = 'O' THEN CONCAT(OP2.OPER_NOMBRES,' ',OP2.OPER_PATERNO,' ',OP2.OPER_MATERNO) ELSE '' END) as QUIEN_RETIRA,
		(CASE WHEN SPROD_TIPODEST = 'U' THEN US.USR_NOMBRE WHEN SPROD_TIPODEST = 'O' THEN CONCAT(OP.OPER_NOMBRES,' ',OP.OPER_PATERNO,' ',OP.OPER_MATERNO) ELSE '' END) as DESTINATARIO,
		U.USR_EMAIL
		from SOLICITUD_PRODUCTOS SPROD JOIN USUARIOS U ON USR_ID_SOLIC = U.USR_ID
		LEFT JOIN USUARIOS AS US2 ON US2.USR_ID = SPROD.USR_ID_RETIRA
		LEFT JOIN OPERADOR AS OP2 ON OP2.OPER_RUT = SPROD.OPER_RUT_RETIRA
		LEFT JOIN USUARIOS AS US ON US.USR_ID = SPROD.USR_ID_DEST
		LEFT JOIN OPERADOR AS OP ON OP.OPER_RUT = SPROD.OPER_RUT_DEST
		WHERE sprod_id = $sprod_id";
		$resultcomment = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$solicitud = mysqli_fetch_row($resultcomment);
		$comentario = $solicitud[0];
		$solicitante = $solicitud[1];
		$dia_entrega = $solicitud[2];
		$hora_entrega = $solicitud[3];
		
		$dia_rentrega = $solicitud[4];
		$hora_rentrega = $solicitud[5];	
		$quien_retira = $solicitud[6];
		$destinatario = $solicitud[7];
		$email_solicitante = $solicitud[8];
		
		$email_produccion= random_email();
		
		$mail = new PHPMailer();
		
		$mail->IsSMTP();	
		$mail->Host = "mail.ing-worlds.cl";
		$mail->SMTPAuth = true;
		$mail->Port = 25; 	
		//$mail->Username = "operaciones@ing-worlds.cl";  
		$mail->Username = $email_produccion; 
		$mail->Password = "sistemasweb2015";		
		$mail->CharSet  = 'UTF-8';	
		
		//$mail->From = "mcordero@sotrosur.cl";
		//$mail->From = "operaciones@ing-worlds.cl";
		$mail->From = $email_produccion;
		$mail->FromName = 'Planificacion y Control Produccion';		
		$mail->AddAddress($email_solicitante,$solicitante);	
		//$mail->AddAddress("cristian.ieci@gmail.com","Cristian Cabrera");
		//$mail->AddAddress("l.melgarejo.u@gmail.com","Leonardo Melgarejo");
		
		$mail->AddCC("l.melgarejo.u@gmail.com","Leonardo Melgarejo");		
		//$mail->AddBCC("cristian.ieci@gmail.com","Cristian Cabrera");
		
		
		
		$sql = "SELECT c.CATPROD_NOMBRE as CATEGORIA, p.PROD_NOMBRE as PRODUCTO, sd.SPRODD_CANT as CANT_SOLICITADA, sd.SPRODR_CANT as CANT_ACEPTADA, sd.SPRODR_ESTADO as ESTADO
		from PRODUCTOS p
		join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id 
		join SPROD_DETALLE sd on sd.prod_cod = p.prod_cod
		WHERE sd.sprod_id = $sprod_id
		ORDER BY c.catprod_nombre,p.PROD_NOMBRE ASC";					
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));		
		
		switch($asunto){
					
			case 'RECHAZAR SOLIC':

				$html = '<html><body>';
				$html .= '<img src="http://ing-worlds.cl/proyecto/sisconvi-production/images/arauco.png" width="130" height="50" border="0" style="display:block; border:none;" ><br />';
				$tabla .= '<table width="760" border="1" cellpadding="0" cellspacing="0" style="border:none; border-collapse:collapse;">';
				$tabla .= '<tr><th>CATEGORIA</th><th>PRODUCTO</th><th>CANT_SOLICITADA</th></tr>';
				while( $rows = mysqli_fetch_assoc($resultset) ) {					
					$tabla .= '<tr>';
					$tabla .= '<td>'.$rows[CATEGORIA].'</td>';
					$tabla .= '<td>'.$rows[PRODUCTO].'</td>';
					$tabla .= '<td align="center">'.$rows[CANT_SOLICITADA].'</td>';					
					$tabla .= '</tr>';	
				}				
				$tabla .= '</table>';
				$html_fin = '</body></html>';
	
				$mensaje = $html.'Sr/Sra <b>'.$solicitante.'</b> ha sido rechazada su solicitud Nº '.$sprod_id.', destinada para '.$destinatario.'. <br /><br />Detalle de lo solicitado: <br /><br />'.$tabla.'<br /><b>Motivo:</b><br />'.$comentario.$html_fin;
				$asunto = 'Solicitud Rechazada';
				
			break;
			
			
			case 'ACEPTAR SOLIC':

				$html = '<html><body>';
				$html .= '<img src="http://ing-worlds.cl/proyecto/sisconvi-production/images/arauco.png" width="130" height="50" border="0" style="display:block; border:none;" ><br />';
				$tabla .= '<table width="760" border="1" cellpadding="0" cellspacing="0" style="border:none; border-collapse:collapse;">';
				$tabla .= '<tr><th>RESOLUCIÓN</th><th>CATEGORIA</th><th>PRODUCTO</th><th>CANT_SOLICITADA</th><th>CANT_ACEPTADA</th></tr>';
				while( $rows = mysqli_fetch_assoc($resultset) ) {					
					$tabla .= '<tr>';
					$tabla .= '<td align="center">'.$rows[ESTADO].'</td>';
					$tabla .= '<td>'.$rows[CATEGORIA].'</td>';
					$tabla .= '<td>'.$rows[PRODUCTO].'</td>';
					$tabla .= '<td align="center">'.$rows[CANT_SOLICITADA].'</td>';
					$tabla .= '<td align="center">'.$rows[CANT_ACEPTADA].'</td>';
					$tabla .= '</tr>';	
				}				
				$tabla .= '</table>';
				$html_fin = '</body></html>';
				
				$mensaje = $html.'Sr/Sra <b>'.$solicitante.'</b> ha sido aceptada su solicitud Nº '.$sprod_id.' destinada para '.$destinatario.'. Debe ser retirada el día <b>'.$dia_entrega.'</b> a las <b>'.$hora_entrega.' hrs</b>. <br /><br />Detalle de lo solicitado y resuelto: <br /><br />'.$tabla.'<br /><b>Motivo:</b><br />'.$comentario.$html_fin;
				$asunto = 'Solicitud Aceptada';
				
			break;			
			
			case 'UPDATE SOLIC ACEPTADA':

				$html = '<html><body>';
				$html .= '<img src="http://ing-worlds.cl/proyecto/sisconvi-production/images/arauco.png" width="130" height="50" border="0" style="display:block; border:none;" ><br />';
				$tabla .= '<table width="760" border="1" cellpadding="0" cellspacing="0" style="border:none; border-collapse:collapse;">';
				$tabla .= '<tr><th>RESOLUCIÓN</th><th>CATEGORIA</th><th>PRODUCTO</th><th>CANT_SOLICITADA</th><th>CANT_ACEPTADA</th></tr>';
				while( $rows = mysqli_fetch_assoc($resultset) ) {					
					$tabla .= '<tr>';
					$tabla .= '<td align="center">'.$rows[ESTADO].'</td>';
					$tabla .= '<td>'.$rows[CATEGORIA].'</td>';
					$tabla .= '<td>'.$rows[PRODUCTO].'</td>';
					$tabla .= '<td align="center">'.$rows[CANT_SOLICITADA].'</td>';
					$tabla .= '<td align="center">'.$rows[CANT_ACEPTADA].'</td>';
					$tabla .= '</tr>';	
				}				
				$tabla .= '</table>';
				$html_fin = '</body></html>';
				
				$mensaje = $html.'Sr/Sra <b>'.$solicitante.'</b> ha sido actualizada su solicitud Nº '.$sprod_id.' destinada para '.$destinatario.'. Debe ser retirada el día <b>'.$dia_entrega.'</b> a las <b>'.$hora_entrega.' hrs</b>. <br /><br />Detalle de lo solicitado y resuelto: <br /><br />'.$tabla.'<br /><b>Motivo:</b><br />'.$comentario.$html_fin;
				$asunto = 'Actualizacion Solicitud Aceptada';
				
			break;			
			
			case 'RECHAZAR SOLIC ACEPTADA':

				$html = '<html><body>';
				$html .= '<img src="http://ing-worlds.cl/proyecto/sisconvi-production/images/arauco.png" width="130" height="50" border="0" style="display:block; border:none;" ><br />';
				$tabla .= '<table width="760" border="1" cellpadding="0" cellspacing="0" style="border:none; border-collapse:collapse;">';
				$tabla .= '<tr><th>CATEGORIA</th><th>PRODUCTO</th><th>CANT_SOLICITADA</th></tr>';
				while( $rows = mysqli_fetch_assoc($resultset) ) {					
					$tabla .= '<tr>';
					$tabla .= '<td>'.$rows[CATEGORIA].'</td>';
					$tabla .= '<td>'.$rows[PRODUCTO].'</td>';
					$tabla .= '<td align="center">'.$rows[CANT_SOLICITADA].'</td>';					
					$tabla .= '</tr>';	
				}				
				$tabla .= '</table>';
				$html_fin = '</body></html>';
				
				$mensaje = $html.'Sr/Sra <b>'.$solicitante.'</b> ha sido rechazada su solicitud (anteriormente Aceptada) Nº '.$sprod_id.' destinada para '.$destinatario.'.<br /> <br />Detalle de lo solicitado: <br /><br />'.$tabla.'<br /><b>Motivo:</b><br />'.$comentario.$html_fin;
				$asunto = 'Rechazo a Solicitud previamente Aceptada';
				
			break;	
	
	
			case 'ACTA ENTREGA Y REBAJA STOCK':

				$html = '<html><body>';
				$html .= '<img src="http://ing-worlds.cl/proyecto/sisconvi-production/images/arauco.png" width="130" height="50" border="0" style="display:block; border:none;" ><br />';
				$tabla .= '<table width="760" border="1" cellpadding="0" cellspacing="0" style="border:none; border-collapse:collapse;">';
				$tabla .= '<tr><th>CATEGORIA</th><th>PRODUCTO</th><th>CANT_SOLICITADA</th><th>CANT_ACEPTADA</th></tr>';
				while( $rows = mysqli_fetch_assoc($resultset) ) {					
					$tabla .= '<tr>';
					$tabla .= '<td>'.$rows[CATEGORIA].'</td>';
					$tabla .= '<td>'.$rows[PRODUCTO].'</td>';
					$tabla .= '<td align="center">'.$rows[CANT_SOLICITADA].'</td>';
					$tabla .= '<td align="center">'.$rows[CANT_ACEPTADA].'</td>';
					$tabla .= '</tr>';	
				}				
				$tabla .= '</table>';
				$html_fin = '</body></html>';
				
				$mensaje = $html.'Sr/Sra <b>'.$solicitante.'</b> ha sido generado un acta de entrega de su solicitud Nº '.$sprod_id.' (destinada para '.$destinatario.') el día <b>'.$dia_rentrega.'</b> a las <b>'.$hora_rentrega.' hrs</b>, por el Sr/Sra <b>'.$quien_retira.'</b>.<br /><br />Detalle de lo solicitado y resuelto: <br /><br />'.$tabla.'<br /><br />'.$html_fin;
				$asunto = 'Solicitud Entregada';
				
			break;		
	
			
			case 'ENTREGAR PRODUCTOS' or 'ACTA ENTREGA':

				$html = '<html><body>';
				$html .= '<img src="http://ing-worlds.cl/proyecto/sisconvi-production/images/arauco.png" width="130" height="50" border="0" style="display:block; border:none;" ><br />';
				$tabla .= '<table width="760" border="1" cellpadding="0" cellspacing="0" style="border:none; border-collapse:collapse;">';
				$tabla .= '<tr><th>RESOLUCIÓN</th><th>CATEGORIA</th><th>PRODUCTO</th><th>CANT_SOLICITADA</th><th>CANT_ACEPTADA</th></tr>';
				while( $rows = mysqli_fetch_assoc($resultset) ) {					
					$tabla .= '<tr>';
					$tabla .= '<td align="center">'.$rows[ESTADO].'</td>';
					$tabla .= '<td>'.$rows[CATEGORIA].'</td>';
					$tabla .= '<td>'.$rows[PRODUCTO].'</td>';
					$tabla .= '<td align="center">'.$rows[CANT_SOLICITADA].'</td>';
					$tabla .= '<td align="center">'.$rows[CANT_ACEPTADA].'</td>';
					$tabla .= '</tr>';	
				}				
				$tabla .= '</table>';
				$html_fin = '</body></html>';
				
				$mensaje = $html.'Sr/Sra <b>'.$solicitante.'</b> ha sido generado un acta de entrega de su solicitud Nº '.$sprod_id.' (destinada para '.$destinatario.') el día <b>'.$dia_rentrega.'</b> a las <b>'.$hora_rentrega.' hrs</b>, por el Sr/Sra <b>'.$quien_retira.'</b>.<br /><br />Detalle de lo solicitado y resuelto: <br /><br />'.$tabla.'<br /><b>Motivo:</b><br />'.$comentario.$html_fin;
				$asunto = 'Solicitud Entregada';
				
			break;	
			
			
			
			case 'CAMBIAR SOLIC RECHAZADA A PENDIENTE':

				$html = '<html><body>';
				$html .= '<img src="http://ing-worlds.cl/proyecto/sisconvi-production/images/arauco.png" width="130" height="50" border="0" style="display:block; border:none;" ><br />';
				$tabla .= '<table width="760" border="1" cellpadding="0" cellspacing="0" style="border:none; border-collapse:collapse;">';
				$tabla .= '<tr><th>CATEGORIA</th><th>PRODUCTO</th><th>CANT_SOLICITADA</th></tr>';
				while( $rows = mysqli_fetch_assoc($resultset) ) {					
					$tabla .= '<tr>';
					$tabla .= '<td>'.$rows[CATEGORIA].'</td>';
					$tabla .= '<td>'.$rows[PRODUCTO].'</td>';
					$tabla .= '<td align="center">'.$rows[CANT_SOLICITADA].'</td>';					
					$tabla .= '</tr>';	
				}				
				$tabla .= '</table>';
				$html_fin = '</body></html>';
				
				$mensaje = $html.'Sr/Sra <b>'.$solicitante.'</b> ha sido cambiada la resolución de su solicitud Nº '.$sprod_id.' destinada para '.$destinatario.'.<br /> al estado <b>Pendiente de Resolución</b> <br /><br />Detalle de lo solicitado: <br /><br />'.$tabla.$html_fin;
				$asunto = 'Cambio Resolucion de Rechazada a Pendiente de Resolucion';
				
			break;		
			
					
			
		}
		

		
		$mail->WordWrap = 50;                              
		$mail->IsHTML(true);                               
		$mail->Subject  =  $asunto;
		$mail->Body     =  $mensaje;
		$mail->AltBody  =  $mensaje;
		$mail->Send();		
	/*	
		if($asunto == 'ENTREGAR PRODUCTOS'){
		
			$sql = "SELECT c.CATPROD_NOMBRE as CATEGORIA, p.PROD_NOMBRE as PRODUCTO, p.PROD_STOCK, p.PROD_STOCKMIN
			from PRODUCTOS p join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id 
			WHERE p.PROD_STOCK < (SELECT x.PROD_STOCKMIN FROM PRODUCTOS x WHERE x.PROD_COD = p.PROD_COD)
			ORDER BY c.catprod_nombre,p.PROD_NOMBRE ASC";					
			$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));	
			$rowcount = mysqli_num_rows($resultset);
			
			if($rowcount > 0){
				
				$mail2 = new PHPMailer();
				
				$mail2->IsSMTP();	
				$mail2->Host = "mail.ing-worlds.cl";
				$mail2->SMTPAuth = true;
				$mail2->Port = 25; 	
				$mail2->Username = "operaciones@ing-worlds.cl";  		
				$mail2->Password = "sistemasweb2015";		
				$mail2->CharSet  = 'UTF-8';	
				
				//$mail->From = "mcordero@sotrosur.cl";
				$mail2->From = "operaciones@ing-worlds.cl";
				$mail2->FromName = 'Planificación y Control Producción';		
				//$mail->AddAddress($email_solicitante,$solicitante);	
				$mail2->AddAddress("cristian.ieci@gmail.com","Cristian Cabrera");
				//$mail->AddBCC("cristian.ieci@gmail.com","Cristian Cabrera");
				//$mail->AddBCC("l.melgarejo.u@gmail.com","Leonardo Melgarejo");		
		
				$html = '<html><body>';
				$html .= '<img src="http://ing-worlds.cl/proyecto/sisconvi-production/images/arauco.png" width="130" height="50" border="0" style="display:block; border:none;" ><br />';
				$tabla .= '<table width="760" border="1" cellpadding="0" cellspacing="0" style="border:none; border-collapse:collapse;">';
				$tabla .= '<tr><th>CATEGORIA</th><th>PRODUCTO</th><th>STOCK</th><th>STOCK MINIMO</th></tr>';
				while( $rows = mysqli_fetch_assoc($resultset) ) {					
					$tabla .= '<tr>';
					$tabla .= '<td>'.$rows[CATEGORIA].'</td>';
					$tabla .= '<td>'.$rows[PRODUCTO].'</td>';
					$tabla .= '<td align="center">'.$rows[PROD_STOCK].'</td>';		
					$tabla .= '<td align="center">'.$rows[PROD_STOCKMIN].'</td>';
					$tabla .= '</tr>';	
				}				
				$tabla .= '</table>';
				$html_fin = '</body></html>';

				$mensaje = $html.'Estimad@, favor dar gestión al siguente listado de falta de stock mínimo <br /><br />Detalle de productos con falta de stock: <br /><br />'.$tabla.'<br />'.$html_fin;
				$asunto = 'Listado Falta de Stock';	
				
				$mail2->WordWrap = 50;                              
				$mail2->IsHTML(true);                               
				$mail2->Subject  =  $asunto;
				$mail2->Body     =  $mensaje;
				$mail2->AltBody  =  $mensaje;
				$mail2->Send();				
			}		
		}
	*/	
		
		
		
		
		
		
	}
	
	
	
	
	
	
	//Envío de email STOCK MINIMO
	function enviar_email_stockmin(){
		require("../Informes/class.phpmailer.php");
		include('coneccion.php');
		
		$sql = "SELECT c.CATPROD_NOMBRE as CATEGORIA, p.PROD_NOMBRE as PRODUCTO, p.PROD_STOCK, p.PROD_STOCKMIN
		from PRODUCTOS p join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id 
		WHERE p.PROD_STOCK < (SELECT x.PROD_STOCKMIN FROM PRODUCTOS x WHERE x.PROD_COD = p.PROD_COD)
		ORDER BY c.catprod_nombre,p.PROD_NOMBRE ASC";					
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));	
		$rowcount = mysqli_num_rows($resultset);
		
		if($rowcount > 0){
		
			$sql = "SELECT USR_NOMBRE,USR_EMAIL
			from USUARIOS 		
			WHERE USR_TIPO = 'JEFE BODEGA'";		
			//WHERE  USR_NOMBRE LIKE  '%CABRERA%'";
			$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));		
		
			$email_produccion= random_email();

			$mail = new PHPMailer();
			
			$mail->IsSMTP();	
			$mail->Host = "mail.ing-worlds.cl";
			$mail->SMTPAuth = true;
			$mail->Port = 25; 	
			//$mail->Username = "operaciones@ing-worlds.cl";  
			$mail->Username = $email_produccion; 		
			$mail->Password = "sistemasweb2015";		
			$mail->CharSet  = 'UTF-8';	
			
			//$mail->From = "operaciones@ing-worlds.cl";
			$mail->From = $email_produccion;
			$mail->FromName = 'Planificacion y Control Produccion';		
			//$mail->AddAddress($email_solicitante,$solicitante);	
			//$mail->AddAddress("cristian.ieci@gmail.com","Cristian Cabrera");
			//$mail->AddAddress("l.melgarejo.u@gmail.com","Leonardo Melgarejo");
			
			while( $boss = mysqli_fetch_assoc($resultado) ) {
				$mail->AddAddress($boss[USR_EMAIL],$boss[USR_NOMBRE]);	
			}			
			
			$mail->AddCC("l.melgarejo.u@gmail.com","Leonardo Melgarejo");		
			//$mail->AddBCC("cristian.ieci@gmail.com","Cristian Cabrera");
	
			$html = '<html><body>';
			$html .= '<img src="http://ing-worlds.cl/proyecto/sisconvi-production/images/arauco.png" width="130" height="50" border="0" style="display:block; border:none;" ><br />';
			$tabla .= '<table width="760" border="1" cellpadding="0" cellspacing="0" style="border:none; border-collapse:collapse;">';
			$tabla .= '<tr><th>CATEGORIA</th><th>PRODUCTO</th><th>STOCK</th><th>STOCK MINIMO</th></tr>';
			while( $rows = mysqli_fetch_assoc($resultset) ) {					
				$tabla .= '<tr>';
				$tabla .= '<td>'.$rows[CATEGORIA].'</td>';
				$tabla .= '<td>'.$rows[PRODUCTO].'</td>';
				$tabla .= '<td align="center">'.$rows[PROD_STOCK].'</td>';		
				$tabla .= '<td align="center">'.$rows[PROD_STOCKMIN].'</td>';
				$tabla .= '</tr>';	
			}				
			$tabla .= '</table>';
			$html_fin = '</body></html>';

			$mensaje = $html.'Estimad@, favor dar gestión al siguente listado de falta de stock mínimo <br /><br />Detalle de productos con falta de stock: <br /><br />'.$tabla.'<br />'.$html_fin;
			$asunto = 'Listado Falta de Stock';	
			
			$mail->WordWrap = 50;                              
			$mail->IsHTML(true);                               
			$mail->Subject  =  $asunto;
			$mail->Body     =  $mensaje;
			$mail->AltBody  =  $mensaje;
			$mail->Send();				
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	//Envío de email producto
	function enviar_email_producto($sprod_id,$cotcom_id){
		require("../Informes/class.phpmailer.php");
		include('coneccion.php');
		
		$sql = "SELECT U.USR_NOMBRE,U.USR_EMAIL
		from SOLICITUD_PRODUCTOS SPROD JOIN USUARIOS U ON USR_ID_SOLIC = U.USR_ID
		WHERE sprod_id = $sprod_id";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$solicitud = mysqli_fetch_row($resultado);
		$solicitante = $solicitud[0];
		$email_solicitante = $solicitud[1];
		
		$email_produccion= random_email();

		$mail = new PHPMailer();
		
		$mail->IsSMTP();	
		$mail->Host = "mail.ing-worlds.cl";
		$mail->SMTPAuth = true;
		$mail->Port = 25; 	
		//$mail->Username = "operaciones@ing-worlds.cl";  
		$mail->Username = $email_produccion; 				
		$mail->Password = "sistemasweb2015";		
		$mail->CharSet  = 'UTF-8';	
		
		//$mail->From = "operaciones@ing-worlds.cl";
		$mail->From = $email_produccion;	
		$mail->FromName = 'Planificacion y Control Produccion';		
		$mail->AddAddress($email_solicitante,$solicitante);	
		//$mail->AddAddress("cristian.ieci@gmail.com","Cristian Cabrera");
		//$mail->AddAddress("l.melgarejo.u@gmail.com","Leonardo Melgarejo");
		
		$mail->AddCC("l.melgarejo.u@gmail.com","Leonardo Melgarejo");		
		//$mail->AddBCC("cristian.ieci@gmail.com","Cristian Cabrera");
		
		
		$sql = "SELECT p.PROD_NOMBRE as PRODUCTO, sd.SPRODD_CANT as CANT_SOLICITADA, COM.cotcom_cantidad as CANT_COMPRADA
		from PRODUCTOS p
		join SPROD_DETALLE sd on sd.prod_cod = p.prod_cod
		JOIN COTIZ_COMPRA COM ON COM.SPRODD_ID = sd.SPRODD_ID AND COTCOM_TIPO = 'COMPRA'
		WHERE COM.cotcom_id = $cotcom_id";					
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));		
		

		$html = '<html><body>';
		$html .= '<img src="http://ing-worlds.cl/proyecto/sisconvi-production/images/arauco.png" width="130" height="50" border="0" style="display:block; border:none;" ><br />';
		$tabla .= '<table width="760" border="1" cellpadding="0" cellspacing="0" style="border:none; border-collapse:collapse;">';
		$tabla .= '<tr><th>PRODUCTO</th><th>CANT_SOLICITADA</th><th>CANT_COMPRADA</th></tr>';
		while( $rows = mysqli_fetch_assoc($resultset) ) {					
			$tabla .= '<tr>';
			$tabla .= '<td>'.$rows[PRODUCTO].'</td>';
			$tabla .= '<td align="center">'.$rows[CANT_SOLICITADA].'</td>';		
			$tabla .= '<td align="center">'.$rows[CANT_COMPRADA].'</td>';
			$tabla .= '</tr>';	
		}				
		$tabla .= '</table>';
		$html_fin = '</body></html>';

		$mensaje = $html.'Sr/Sra <b>'.$solicitante.'</b> el producto solicitado ha llegado a bodega, para su solicitud Nº '.$sprod_id.'.<br /><br />Detalle de lo solicitado: <br /><br />'.$tabla.$html_fin;

		$asunto = 'Compra de producto llegado a bodega';	
		
		$mail->WordWrap = 50;                              
		$mail->IsHTML(true);                               
		$mail->Subject  =  $asunto;
		$mail->Body     =  $mensaje;
		$mail->AltBody  =  $mensaje;
		$mail->Send();					
	
	}
	

	
	
	//Envío de email compra terminada
	function enviar_email_compra_terminada($sprod_id,$sprod_id_new){
		require("../Informes/class.phpmailer.php");
		include('coneccion.php');
		
		$sql = "SELECT U.USR_NOMBRE,U.USR_EMAIL
		from SOLICITUD_PRODUCTOS SPROD JOIN USUARIOS U ON USR_ID_SOLIC = U.USR_ID
		WHERE sprod_id = $sprod_id";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$solicitud = mysqli_fetch_row($resultado);
		$solicitante = $solicitud[0];
		$email_solicitante = $solicitud[1];
		
		$email_produccion= random_email();

		$mail = new PHPMailer();
		
		$mail->IsSMTP();	
		$mail->Host = "mail.ing-worlds.cl";
		$mail->SMTPAuth = true;
		$mail->Port = 25; 	
		//$mail->Username = "operaciones@ing-worlds.cl";  
		$mail->Username = $email_produccion; 		
		$mail->Password = "sistemasweb2015";		
		$mail->CharSet  = 'UTF-8';	
		
		//$mail->From = "operaciones@ing-worlds.cl";
		$mail->From = $email_produccion;
		$mail->FromName = 'Planificacion y Control Produccion';		
		$mail->AddAddress($email_solicitante,$solicitante);	
		//$mail->AddAddress("cristian.ieci@gmail.com","Cristian Cabrera");
		//$mail->AddAddress("l.melgarejo.u@gmail.com","Leonardo Melgarejo");
		
		$mail->AddCC("l.melgarejo.u@gmail.com","Leonardo Melgarejo");		
		//$mail->AddBCC("cristian.ieci@gmail.com","Cristian Cabrera");
		
		
		$sql = "SELECT p.PROD_NOMBRE as PRODUCTO, sd.SPRODD_CANT as CANT_SOLICITADA, COM.cotcom_cantidad as CANT_COMPRADA
		from PRODUCTOS p
		join SPROD_DETALLE sd on sd.prod_cod = p.prod_cod
		JOIN COTIZ_COMPRA COM ON COM.SPRODD_ID = sd.SPRODD_ID AND COTCOM_TIPO = 'COMPRA'
		WHERE sprod_id = $sprod_id";				
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));		
		

		$html = '<html><body>';
		$html .= '<img src="http://ing-worlds.cl/proyecto/sisconvi-production/images/arauco.png" width="130" height="50" border="0" style="display:block; border:none;" ><br />';
		$tabla .= '<table width="760" border="1" cellpadding="0" cellspacing="0" style="border:none; border-collapse:collapse;">';
		$tabla .= '<tr><th>PRODUCTO</th><th>CANT_SOLICITADA</th><th>CANT_COMPRADA</th></tr>';
		while( $rows = mysqli_fetch_assoc($resultset) ) {					
			$tabla .= '<tr>';
			$tabla .= '<td>'.$rows[PRODUCTO].'</td>';
			$tabla .= '<td align="center">'.$rows[CANT_SOLICITADA].'</td>';		
			$tabla .= '<td align="center">'.$rows[CANT_COMPRADA].'</td>';
			$tabla .= '</tr>';	
		}				
		$tabla .= '</table>';
		$html_fin = '</body></html>';

		$mensaje = $html.'Sr/Sra <b>'.$solicitante.'</b> su solicitud de compra ha llegado a bodega, para su solicitud Nº '.$sprod_id.'. Y se ha generado automáticamente una solicitud de materiales con el número '.$sprod_id_new.'. <br /><br />Detalle de lo solicitado: <br /><br />'.$tabla.$html_fin;

		$asunto = 'Solicitud de Compra llegada a bodega';	
		
		$mail->WordWrap = 50;                              
		$mail->IsHTML(true);                               
		$mail->Subject  =  $asunto;
		$mail->Body     =  $mensaje;
		$mail->AltBody  =  $mensaje;
		$mail->Send();					
	
	}	
	

	
	//Envío de email producto(SOLICITUD DE COMPRA)
	function enviar_email_solproducto($sprod_id){
		require("../Informes/class.phpmailer.php");
		include('coneccion.php');
		
		$sql = "SELECT U.USR_NOMBRE,U.USR_EMAIL, sprod_tipocompra, UNDVIV_NOMBRE, SPROD_PRIORIDAD, SPROD_TIPOMANT, SPROD_MOTIVO
		from SOLICITUD_PRODUCTOS SPROD JOIN USUARIOS U ON USR_ID_SOLIC = U.USR_ID
		JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
		WHERE sprod_id = $sprod_id";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$solicitud = mysqli_fetch_row($resultado);
		$solicitante = $solicitud[0];
		$email_solicitante = $solicitud[1];
		$tipo_compra = $solicitud[2];
		$UNIDAD_VIVEROS = /*ucwords(strtolower(*/$solicitud[3]/*))*/;
		$prioridad = ucfirst(strtolower($solicitud[4]));
		$tipo_mant = ucfirst(strtolower($solicitud[5]));
		$motivo = $solicitud[6];
		
		$sql = "SELECT USR_NOMBRE,USR_EMAIL
		from USUARIOS 		
		WHERE USR_TIPO = 'JEFE BODEGA'";		
		//WHERE  USR_NOMBRE LIKE  '%CABRERA%'";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));

		$email_produccion= random_email();

		$mail = new PHPMailer();
		
		$mail->IsSMTP();	
		$mail->Host = "mail.ing-worlds.cl";
		$mail->SMTPAuth = true;
		$mail->Port = 25; 	
		//$mail->Username = "operaciones@ing-worlds.cl";  
		$mail->Username = $email_produccion; 	 		
		$mail->Password = "sistemasweb2015";		
		$mail->CharSet  = 'UTF-8';	
		//$mail->AddAddress("cristian.cabrera@nuevamasvida.cl","Cristian Cabrera");
		//$mail->From = "operaciones@ing-worlds.cl";
		$mail->From = $email_produccion;
		$mail->FromName = 'Planificacion y Control Produccion';		
		$mail->AddAddress($email_solicitante,$solicitante);	
		//$mail->AddAddress("cristian.ieci@gmail.com","Cristian Cabrera");
		//$mail->AddAddress("l.melgarejo.u@gmail.com","Leonardo Melgarejo");
		
		$mail->AddCC("l.melgarejo.u@gmail.com","Leonardo Melgarejo");		

		while( $boss = mysqli_fetch_assoc($resultado) ) {
			$mail->AddCC($boss[USR_EMAIL],$boss[USR_NOMBRE]);	
		}		
	
		//$mail->AddBCC("cristian.ieci@gmail.com","Cristian Cabrera");
		
		$html = '<html><body>';
		$html .= '<img src="http://ing-worlds.cl/proyecto/sisconvi-production/images/arauco.png" width="130" height="50" border="0" style="display:block; border:none;" ><br />';
		$tabla .= '<table width="760" border="1" cellpadding="0" cellspacing="0" style="border:none; border-collapse:collapse;">';		
		
		if($tipo_compra == 'COMPRA MATERIAL' ){
			$sql = "select catprod_nombre, p.prod_nombre,sd.SPRODD_CANT, prod_valor, (SPRODD_CANT *prod_valor) total
			from SPROD_DETALLE sd
			JOIN SOLICITUD_PRODUCTOS s on s.sprod_id = sd.sprod_id
			join PRODUCTOS p on sd.prod_cod = p.prod_cod
			join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id 
			where SPROD_TIPOSOL = 'SC' AND sd.sprod_id = $sprod_id";					
			$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$tabla .= '<tr><th>CATEGORIA</th><th>MATERIAL</th><th>CANT SOLICITADA</th><th>PRECIO REF</th><th>TOTAL</th></tr>';
			
			$total = 0;
			while( $rows = mysqli_fetch_assoc($resultset) ) {					
				$tabla .= '<tr>';
				$tabla .= '<td>'.$rows[catprod_nombre].'</td>';
				$tabla .= '<td align="center">'.$rows[prod_nombre].'</td>';		
				$tabla .= '<td align="center">'.$rows[SPRODD_CANT].'</td>';
				$tabla .= '<td align="center">'.number_format($rows[prod_valor],0,",",".").'</td>';
				$tabla .= '<td align="center">'.number_format($rows[total],0,",",".").'</td>';
				$tabla .= '</tr>';	
				
				$total+=$rows[total];
			}	
			
			
			
				$tabla .= '<tr>';
				$tabla .= '<td></td>';
				$tabla .= '<td></td>';
				$tabla .= '<td></td>';
				$tabla .= '<td></td>';
				$tabla .= '<td align="center"><b>$'.number_format($total,0,",",".").'</b></td>';
				$tabla .= '</tr>';				
			
		}
		
		elseif($tipo_compra == 'PRESTACIÓN SERVICIO'){
		
			$sql = "select sprodd_servicio,sd.SPRODD_CANT
			from SPROD_DETALLE sd
			JOIN SOLICITUD_PRODUCTOS s on s.sprod_id = sd.sprod_id
			where SPROD_TIPOSOL = 'SC' AND sd.sprod_id = $sprod_id";					
			$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$tabla .= '<tr><th>SERVICIO</th><th>PLAZO</th></tr>';
			
			while( $rows = mysqli_fetch_assoc($resultset) ) {					
				$tabla .= '<tr>';
				$tabla .= '<td>'.$rows[sprodd_servicio].'</td>';
				$tabla .= '<td align="center">'.$rows[SPRODD_CANT].'</td>';		
				$tabla .= '</tr>';	
			}				
		}
		

		$tabla .= '</table>';
		$html_fin = '</body></html>';

		$mensaje = $html.'Estimad@ <br><br> Se ha registrado una Solicitud de Compra, Nº de solicitud <b>'.$sprod_id.'</b>, para la unidad <b>'.$UNIDAD_VIVEROS.'</b> cuya prioridad es <b>'.$prioridad.'</b> y de tipo mantenimiento <b>'.$tipo_mant.'</b>.<br /><br /><b>Motivo:</b><br />'.$motivo.'<br /><br />Detalle de lo solicitado: <br /><br />'.$tabla.$html_fin;

		$asunto = 'Solicitud de Compra';	
		
		$mail->WordWrap = 50;                              
		$mail->IsHTML(true);                               
		$mail->Subject  =  $asunto;
		$mail->Body     =  $mensaje;
		$mail->AltBody  =  $mensaje;
		$mail->Send();					
	
	}



	//Envío de email producto (SOLICITUD DE MATERIAL)
	function enviar_email_solproducto_materiales($sprod_id){
		require("../Informes/class.phpmailer.php");
		include('coneccion.php');
		
		$sql = "SELECT U.USR_NOMBRE,U.USR_EMAIL, UNDVIV_NOMBRE, SPROD_MOTIVO,
		(CASE WHEN SPROD_TIPODEST = 'U' THEN US.USR_NOMBRE WHEN SPROD_TIPODEST = 'O' THEN CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) ELSE '' END) as DESTINATARIO
		from SOLICITUD_PRODUCTOS SPROD 
		JOIN USUARIOS U ON USR_ID_SOLIC = U.USR_ID
		JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
		LEFT JOIN USUARIOS AS US ON US.USR_ID = SPROD.USR_ID_DEST
		LEFT JOIN OPERADOR AS OP ON OP.OPER_RUT = SPROD.OPER_RUT_DEST		
		WHERE sprod_id = $sprod_id";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$solicitud = mysqli_fetch_row($resultado);
		$solicitante = $solicitud[0];
		$email_solicitante = $solicitud[1];
		//$tipo_compra = $solicitud[2];
		$UNIDAD_VIVEROS = /*ucwords(strtolower(*/$solicitud[2]/*))*/;
		//$prioridad = ucfirst(strtolower($solicitud[4]));
		//$tipo_mant = ucfirst(strtolower($solicitud[5]));
		$motivo = $solicitud[3];
		$destinatario = $solicitud[4];
		
		$sql = "SELECT USR_NOMBRE,USR_EMAIL
		from USUARIOS 		
		WHERE USR_TIPO = 'ENCARGADO BODEGA'";		
		//WHERE  USR_NOMBRE LIKE  '%CABRERA%'";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));

		$email_produccion= random_email();

		$mail = new PHPMailer();
		
		$mail->IsSMTP();	
		$mail->Host = "mail.ing-worlds.cl";
		$mail->SMTPAuth = true;
		$mail->Port = 25; 	
		//$mail->Username = "operaciones@ing-worlds.cl";  
		$mail->Username = $email_produccion; 			
		$mail->Password = "sistemasweb2015";		
		$mail->CharSet  = 'UTF-8';	
		//$mail->AddAddress("cristian.cabrera@nuevamasvida.cl","Cristian Cabrera");
		//$mail->From = "operaciones@ing-worlds.cl";
		$mail->From = $email_produccion;
		$mail->FromName = 'Planificacion y Control Produccion';		
		$mail->AddAddress($email_solicitante,$solicitante);	
		//$mail->AddAddress("cristian.ieci@gmail.com","Cristian Cabrera");
		//$mail->AddAddress("l.melgarejo.u@gmail.com","Leonardo Melgarejo");
		
		$mail->AddCC("l.melgarejo.u@gmail.com","Leonardo Melgarejo");		
		//$mail->AddBCC("cristian.ieci@gmail.com","Cristian Cabrera");	

		while( $boss = mysqli_fetch_assoc($resultado) ) {
			$mail->AddCC($boss[USR_EMAIL],$boss[USR_NOMBRE]);	
		}		
		
		$html = '<html><body>';
		$html .= '<img src="http://ing-worlds.cl/proyecto/sisconvi-production/images/arauco.png" width="130" height="50" border="0" style="display:block; border:none;" ><br />';
		$tabla .= '<table width="760" border="1" cellpadding="0" cellspacing="0" style="border:none; border-collapse:collapse;">';		
		
	
		$sql = "select catprod_nombre, p.prod_nombre,sd.SPRODD_CANT, prod_valor, (SPRODD_CANT *prod_valor) total
		from SPROD_DETALLE sd
		JOIN SOLICITUD_PRODUCTOS s on s.sprod_id = sd.sprod_id
		join PRODUCTOS p on sd.prod_cod = p.prod_cod
		join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id 
		where SPROD_TIPOSOL = 'SM' AND sd.sprod_id = $sprod_id";					
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$tabla .= '<tr><th>CATEGORIA</th><th>MATERIAL</th><th>CANT SOLICITADA</th><th>PRECIO REF</th><th>TOTAL</th></tr>';
		
		$total = 0;
		while( $rows = mysqli_fetch_assoc($resultset) ) {					
			$tabla .= '<tr>';
			$tabla .= '<td>'.$rows[catprod_nombre].'</td>';
			$tabla .= '<td align="center">'.$rows[prod_nombre].'</td>';		
			$tabla .= '<td align="center">'.$rows[SPRODD_CANT].'</td>';
			$tabla .= '<td align="center">'.number_format($rows[prod_valor],0,",",".").'</td>';
			$tabla .= '<td align="center">'.number_format($rows[total],0,",",".").'</td>';
			$tabla .= '</tr>';	
			
			$total+=$rows[total];
		}	
		
		$tabla .= '<tr>';
		$tabla .= '<td></td>';
		$tabla .= '<td></td>';
		$tabla .= '<td></td>';
		$tabla .= '<td></td>';
		$tabla .= '<td align="center"><b>$'.number_format($total,0,",",".").'</b></td>';
		$tabla .= '</tr>';				
			

		

		$tabla .= '</table>';
		$html_fin = '</body></html>';

		$mensaje = $html.'Estimad@ <br><br> Se ha registrado una Solicitud de Material de '.$solicitante.' para '.$destinatario.', Nº de solicitud <b>'.$sprod_id.'</b>, unidad <b>'.$UNIDAD_VIVEROS.'</b>.<br /><br /><b>Motivo:</b><br />'.$motivo.'<br /><br />Detalle de lo solicitado: <br /><br />'.$tabla.$html_fin;

		$asunto = 'Solicitud de Material';	
		
		$mail->WordWrap = 50;                              
		$mail->IsHTML(true);                               
		$mail->Subject  =  $asunto;
		$mail->Body     =  $mensaje;
		$mail->AltBody  =  $mensaje;
		$mail->Send();					
	
	}		





	
	
?>