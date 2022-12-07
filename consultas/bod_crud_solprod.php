<?php 

	include('coneccion.php');
	include('funciones_comunes.php');

	if(isset($_GET['data'])){
	
		session_start();
				
		$sql = "SELECT DISTINCT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD_ID, US1.USR_NOMBRE AS SOLICITANTE,	
				UNIDAD_VIVEROS.UNDVIV_NOMBRE,
				(CASE WHEN SPROD_TIPODEST = 'U' THEN US.USR_NOMBRE WHEN SPROD_TIPODEST = 'O' THEN CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) ELSE '' END) as DESTINATARIO,
				SPROD.SPROD_MOTIVO as COMENTARIO,UNIDAD_VIVEROS.UNDVIV_ID,
				(CASE WHEN SPROD_TIPODEST = 'U' THEN CONCAT(SPROD.USR_ID_DEST,'**U') WHEN SPROD_TIPODEST = 'O' THEN CONCAT(SPROD.OPER_RUT_DEST,'**O') ELSE '' END) as DESTINATARIO_ID
				FROM SOLICITUD_PRODUCTOS AS SPROD 
				JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
				JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
				LEFT JOIN USUARIOS AS US ON US.USR_ID = SPROD.USR_ID_DEST
				JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
				LEFT JOIN OPERADOR AS OP ON OP.OPER_RUT = SPROD.OPER_RUT_DEST
				WHERE SPROD_ESTADO = 'PENDIENTE' AND SPROD_TIPOSOL = 'SM' AND
				( SPROD.USR_ID_SOLIC = ".$_SESSION['USR_ID']." OR '".$_SESSION['USR_TIPO']."' = 'ADMINISTRADOR' OR '".$_SESSION['USR_TIPO']."' = 'JEFE BODEGA' OR '".$_SESSION['USR_TIPO']."' = 'ENCARGADO BODEGA' ) 
				ORDER BY SPROD_DIA DESC, SPROD_ID";				
							
				
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
	}
	
	elseif(isset($_GET['nro_solicitud'])){
/*
		$sql = "select p.CATPROD_ID, p.PROD_COD, c.CATPROD_NOMBRE, p.PROD_NOMBRE, sd.SPRODD_CANT 
		from PRODUCTOS p
		join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id 
		join SPROD_DETALLE sd on sd.prod_cod = p.prod_cod
		where sd.sprod_id = ".$_GET['nro_solicitud']." ";	
*/
		$sql = "SELECT DISTINCT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD.SPROD_ID, US1.USR_NOMBRE AS SOLICITANTE,	
				UNIDAD_VIVEROS.UNDVIV_NOMBRE,
				(CASE WHEN SPROD_TIPODEST = 'U' THEN US.USR_NOMBRE WHEN SPROD_TIPODEST = 'O' THEN CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) ELSE '' END) as DESTINATARIO,
				SPROD.SPROD_MOTIVO as COMENTARIO,
				p.CATPROD_ID, p.PROD_COD, c.CATPROD_NOMBRE, p.PROD_NOMBRE, sd.SPRODD_CANT, p.PROD_VALOR, (sd.SPRODD_CANT * p.PROD_VALOR) AS PROT_TOTAL, p.SAP_COD, p.SAP_NOMBRE
				FROM SOLICITUD_PRODUCTOS AS SPROD 
				JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
				JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
				LEFT JOIN USUARIOS AS US ON US.USR_ID = SPROD.USR_ID_DEST
				JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
				LEFT JOIN OPERADOR AS OP ON OP.OPER_RUT = SPROD.OPER_RUT_DEST
				join SPROD_DETALLE sd on sd.SPROD_ID = SPROD.SPROD_ID
				join PRODUCTOS p on sd.prod_cod = p.prod_cod
				LEFT join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id 								
				where sd.sprod_id = ".$_GET['nro_solicitud']." ";

		
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
	}
	
	
	elseif(isset($_GET['salidabod'])){
		
		$sql = "SELECT DISTINCT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD_ID, US1.USR_NOMBRE AS SOLICITANTE,	
				UNIDAD_VIVEROS.UNDVIV_NOMBRE,
				(CASE WHEN SPROD_TIPODEST = 'U' THEN US.USR_NOMBRE WHEN SPROD_TIPODEST = 'O' THEN CONCAT(OP.OPER_NOMBRES,' ',OP.OPER_PATERNO,' ',OP.OPER_MATERNO) ELSE '' END) as DESTINATARIO,				
				(CASE WHEN SPROD_TIPORETIRA = 'U' THEN US2.USR_NOMBRE WHEN SPROD_TIPORETIRA = 'O' THEN CONCAT(OP2.OPER_NOMBRES,' ',OP2.OPER_PATERNO,' ',OP2.OPER_MATERNO) ELSE '' END) as QUIEN_RETIRA,	CONCAT(DATE_FORMAT(SPROD_DRENTREGA,'%d-%m-%Y'), ' ', SPROD_HRENTREGA) as FECHA_RENTREGA, UNIDAD_VIVEROS.UNDVIV_ID,
				SPROD.USR_ID_SOLIC AS SOLICITANTE_ID, 
				(CASE WHEN SPROD_TIPODEST = 'U' THEN CONCAT(SPROD.USR_ID_DEST,'**U') WHEN SPROD_TIPODEST = 'O' THEN CONCAT(SPROD.OPER_RUT_DEST,'**O') ELSE '' END) as DESTINATARIO_ID, 
				(CASE WHEN SPROD_TIPORETIRA = 'U' THEN CONCAT(SPROD.USR_ID_RETIRA,'**U') WHEN SPROD_TIPORETIRA = 'O' THEN CONCAT(SPROD.OPER_RUT_RETIRA,'**O') ELSE '' END) as QUIENRETIRA_ID
				FROM SOLICITUD_PRODUCTOS AS SPROD 
				JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
				JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
				LEFT JOIN USUARIOS AS US ON US.USR_ID = SPROD.USR_ID_DEST
				JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
				LEFT JOIN USUARIOS AS US2 ON US2.USR_ID = SPROD.USR_ID_RETIRA
				LEFT JOIN OPERADOR AS OP ON OP.OPER_RUT = SPROD.OPER_RUT_DEST
				LEFT JOIN OPERADOR AS OP2 ON OP2.OPER_RUT = SPROD.OPER_RUT_RETIRA
				WHERE
				SPROD.SPROD_SALIDABOD = 'S'
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
	}	
	
	
	else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
		
			session_start();
			$sprod_id = $_POST['sprod_id'];
			$usr_id_solic = $_SESSION['USR_ID'];
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$sprod_dia = $_POST['sprod_dia'];
			$UNDVIV_ID = $_POST['UNDVIV_ID'];
			$sprod_motivo = $_POST['sprod_motivo'];
			
			$destinatario = explode("**" , $_POST['destinatario']);
			$sprod_tipodest = $destinatario[1];		
			$usr_id_dest = '';
			$oper_rut_dest = '';			
			switch($sprod_tipodest){				
				case 'U':
					$usr_id_dest = $destinatario[0];
					$oper_rut_dest = "NULL";
				break;
				case 'O':
					$usr_id_dest = "NULL";
					$oper_rut_dest = "'$destinatario[0]'";	
				break;
			}
			
			$prod_cod = $_POST['prod_cod'];
			$sprodd_cant = $_POST['sprodd_cant'];
			//$sap_cod = $_POST['sap_cod'];
			
			
			if($usr_id_solic == "" or $per_agno == "" or $sem_num == "" or $sprod_dia == "" or $UNDVIV_ID == "" or $sprod_tipodest == "" or $usr_id_dest == "" or $oper_rut_dest == "" or $prod_cod == "" or $sprodd_cant == ""/* or $sap_cod == "" */){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			if($sprod_id == ''){ //INSERT SOLICITUD + DETALLE PRODUCTOS
				
				mysqli_autocommit($link, FALSE);			
				$resp = array('cod'=>'error','desc'=>'Error de Base de Datos');			
			
				$sql = "insert into SOLICITUD_PRODUCTOS(usr_id_solic, per_agno, sem_num, sprod_dia, sprod_diasystem, UNDVIV_ID, sprod_tipodest, usr_id_dest, oper_rut_dest, sprod_estado, sprod_tiposol, sprod_motivo) 
				values ($usr_id_solic, $per_agno, $sem_num,'$sprod_dia', '$fecha_reg', $UNDVIV_ID,'$sprod_tipodest',$usr_id_dest,$oper_rut_dest,'PENDIENTE', 'SM', '$sprod_motivo')";		
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));	
				
				$sprod_id = mysqli_insert_id($link);
			
				$sql = "insert into SPROD_DETALLE(sprod_id, prod_cod, sprodd_cant) 
				values ($sprod_id,'$prod_cod',$sprodd_cant)";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				
				mysqli_commit($link);
			
			}
			else{ //INSERT DETALLE PRODUCTOS
				
				$sql = "SELECT 1 FROM SPROD_DETALLE where prod_cod = '$prod_cod' and sprod_id = $sprod_id";		

				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount > 0){
				
					$resp = array('cod'=>'error','desc'=>'Este Producto ya está registrado para esta Solicitud');
					salida($resp);
				}				
				
				$sql = "insert into SPROD_DETALLE(sprod_id, prod_cod, sprodd_cant) 
				values ($sprod_id,'$prod_cod',$sprodd_cant)";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
			}
			
			//ENVIAR EMAIL
			enviar_email_solproducto_materiales($sprod_id);				
			
		}
		
		elseif($operacion == 'UPDATE'){
			
			$sprod_id = $_POST['sprod_id'];
			$prod_cod = $_POST['prod_cod'];
			$h_prod_cod = $_POST['h_prod_cod'];
			$sprodd_cant = $_POST['sprodd_cant'];		
			
			if($prod_cod == "" or $sprod_id == "" or $sprodd_cant == "" or $h_prod_cod == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			if($prod_cod <> $h_prod_cod){
				$sql = "SELECT 1 FROM SPROD_DETALLE where prod_cod = '$prod_cod' and sprod_id = $sprod_id";		

				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount > 0){	
					$resp = array('cod'=>'error','desc'=>'Este Producto ya está registrado para esta Solicitud');
					salida($resp);
				}					
			}
			
			$sql = "update SPROD_DETALLE set prod_cod = '$prod_cod',sprodd_cant = $sprodd_cant where prod_cod = '$h_prod_cod' and sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
		}	
		
		elseif($operacion == 'UPDATE_HEAD'){
			
			$sprod_id = $_POST['sprod_id'];
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$sprod_dia = $_POST['sprod_dia'];
			$UNDVIV_ID = $_POST['UNDVIV_ID'];
			$sprod_motivo = $_POST['sprod_motivo'];
			$destinatario = explode("**" , $_POST['destinatario']);
			$sprod_tipodest = $destinatario[1];		
			$usr_id_dest = '';
			$oper_rut_dest = '';			
			switch($sprod_tipodest){				
				case 'U':
					$usr_id_dest = $destinatario[0];
					$oper_rut_dest = "NULL";
				break;
				case 'O':
					$usr_id_dest = "NULL";
					$oper_rut_dest = "'$destinatario[0]'";	
				break;
			}	
			
			if($sprod_id == "" or $per_agno == "" or $sem_num == "" or $sprod_dia == "" or $UNDVIV_ID == "" or $sprod_tipodest == "" or $usr_id_dest == "" or $oper_rut_dest == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}			
			
			$sql = "UPDATE SOLICITUD_PRODUCTOS SET per_agno = $per_agno,sem_num = $sem_num,sprod_dia = $sprod_dia,UNDVIV_ID = $UNDVIV_ID, sprod_tipodest = '$sprod_tipodest', usr_id_dest = $usr_id_dest, oper_rut_dest = $oper_rut_dest, sprod_motivo = '$sprod_motivo' WHERE sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
		}			
		
		elseif($operacion == 'DELETE'){
			
			$sprod_id = $_POST['sprod_id'];
			$h_prod_cod = $_POST['h_prod_cod'];
			
			if($sprod_id == "" or $h_prod_cod == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}

			$sql = "SELECT * FROM SPROD_DETALLE where sprod_id = $sprod_id";		

			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount == 1){	
				mysqli_autocommit($link, FALSE);			
				$resp = array('cod'=>'error','desc'=>'Error de Base de Datos');		
				
				$sql = "delete from SPROD_DETALLE where sprod_id = $sprod_id";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				
				$sql = "delete from SOLICITUD_PRODUCTOS where sprod_id = $sprod_id";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				
				mysqli_commit($link);
				$operacion = 'DELETE ALL';
			}			
			else{			
				$sql = "delete from SPROD_DETALLE where prod_cod = '$h_prod_cod' and sprod_id = $sprod_id";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));			
			}
			
		}	
		
		elseif($operacion == 'DELETE ALL'){
			
			$sprod_id = $_POST['sprod_id'];
			
			if($sprod_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			mysqli_autocommit($link, FALSE);			
			$resp = array('cod'=>'error','desc'=>'Error de Base de Datos');		
			
			$sql = "delete from SPROD_DETALLE where sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
			
			$sql = "delete from SOLICITUD_PRODUCTOS where sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
			
			mysqli_commit($link);		
			
		}			
		
		elseif($operacion == 'REPLICAR_SOLICITUD'){
			
			session_start();
			$sprod_id = $_POST['sprod_id'];
			$usr_id_solic = $_SESSION['USR_ID'];
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$sprod_dia = $_POST['sprod_dia'];
			$UNDVIV_ID = $_POST['UNDVIV_ID'];			
			$destinatarios = $_POST['destinatarios'];
			$sprod_motivo = $_POST['sprod_motivo'];
			if($usr_id_solic == "" or $sprod_id == "" or $per_agno == "" or $sem_num == "" or $sprod_dia == "" or $UNDVIV_ID == "" or $destinatarios == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}	
			
			$destinatarios_array = explode("," , $destinatarios);
			
			mysqli_autocommit($link, FALSE);			
			$resp = array('cod'=>'error','desc'=>'Error de Base de Datos');	
			//$sql = '';
			foreach ($destinatarios_array as $destinatario_unico){ 
			
				$destinatario = explode("**" , $destinatario_unico);
				$sprod_tipodest = $destinatario[1];		
				$usr_id_dest = '';
				$oper_rut_dest = '';			
				switch($sprod_tipodest){				
					case 'U':
						$usr_id_dest = $destinatario[0];
						$oper_rut_dest = "NULL";
					break;
					case 'O':
						$usr_id_dest = "NULL";
						$oper_rut_dest = "'$destinatario[0]'";	
					break;
				}	

				
				$sql= "insert into SOLICITUD_PRODUCTOS(usr_id_solic, per_agno, sem_num, sprod_dia, sprod_diasystem, UNDVIV_ID, sprod_tipodest, usr_id_dest, oper_rut_dest, sprod_estado, sprod_tiposol, sprod_motivo) 
				values ($usr_id_solic, $per_agno, $sem_num,'$sprod_dia', '$fecha_reg', $UNDVIV_ID,'$sprod_tipodest',$usr_id_dest,$oper_rut_dest,'PENDIENTE', 'SM','$sprod_motivo')";	
				
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));	
				
				$sprod_id_new = mysqli_insert_id($link);
				
				$sql = "insert into SPROD_DETALLE(sprod_id, prod_cod, sprodd_cant) SELECT $sprod_id_new,prod_cod,sprodd_cant FROM SPROD_DETALLE where sprod_id = $sprod_id";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
					
			}
				//$resp = array('cod'=>'error','desc'=>$sql);
				//salida($resp);				
			mysqli_commit($link);		
			
		}		

		elseif($operacion == 'ACEPTAR SOLIC'){
////////////////////			
			session_start();
			$USR_ID = $_SESSION['USR_ID'];	
			$USR_TIPO  = $_SESSION['USR_TIPO'];		
////////////////////			

			$sprod_id = $_POST['sprod_id'];
			//$sprod_dentrega = $_POST['sprod_dentrega'];
			
			$dentrega = explode("-" , $_POST['sprod_dentrega']);
			$sprod_dentrega = $dentrega[2].'-'.$dentrega[1].'-'.$dentrega[0];			
			
			$sprod_hentrega = $_POST['sprod_hentrega'];
			$sprod_comentario = $_POST['sprod_comentario'];
			$sprod_estado = $_POST['sprod_estado'];

			
			if($sprod_id == "" or $sprod_dentrega == "" or $sprod_hentrega == "" or $sprod_estado == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}

			mysqli_autocommit($link, FALSE);
			$total_prod= count($_POST["prod_cod"]);
			$i = 0;
			while($total_prod > $i){
				
				$prod_cod = $_POST['prod_cod'][$i];	
				$sprodr_cant = $_POST['sprodr_cant'][$i];	
				$sprodr_estado = $_POST['sprodr_estado'][$i];
				
				if($sprodr_estado == 'ACEPTADA'){
					$sql = "update SPROD_DETALLE set sprodr_estado = '$sprodr_estado',sprodr_cant = $sprodr_cant where prod_cod = '$prod_cod' and sprod_id = $sprod_id";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));			
					
////////////////////
/*
					$sql = "SELECT prod_stock FROM PRODUCTOS WHERE prod_cod = '$prod_cod'";
					$resultado = mysqli_query($link,$sql);
					$fila = mysqli_fetch_row($resultado);
					$STOCKX = $fila[0];
$fecha_reg2 = date("Y-m-d H:i:s",time());
					$sql = "insert into AUDITORIA_STOCK(FECHA,SPROD_ID,PROD_COD,STOCK_ACTUAL,CANT_SOLIC,USR_ID,USR_TIPO,FECHA_INS) VALUES ('$fecha_reg',$sprod_id,'$prod_cod',$STOCKX,$sprodr_cant,$USR_ID,'$USR_TIPO','$fecha_reg2')";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));						
////////////////////					
					//REBAJA STOCK POR SOLICITUD PRODUCTO
					$sql = "UPDATE PRODUCTOS SET prod_stock = prod_stock - $sprodr_cant WHERE prod_cod = '$prod_cod'";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));						

////////////////////
					$sql = "SELECT prod_stock FROM PRODUCTOS WHERE prod_cod = '$prod_cod'";
					$resultado = mysqli_query($link,$sql);
					$fila = mysqli_fetch_row($resultado);
					$STOCKX = $fila[0];
$fecha_reg2 = date("Y-m-d H:i:s",time());
					$sql = "insert into AUDITORIA_STOCK(FECHA,SPROD_ID,PROD_COD,STOCK_ACTUAL,CANT_SOLIC,USR_ID,USR_TIPO,FECHA_INS) VALUES ('$fecha_reg',$sprod_id,'$prod_cod',$STOCKX,$sprodr_cant,$USR_ID,'$USR_TIPO','$fecha_reg2')";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));						
////////////////////	
*/								
				}
				elseif($sprodr_estado == 'RECHAZADA'){
					$sql = "update SPROD_DETALLE set sprodr_estado = '$sprodr_estado' where prod_cod = '$prod_cod' and sprod_id = $sprod_id";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));			
				}	

				$i++;
			}
			
			$sql = "UPDATE SOLICITUD_PRODUCTOS SET sprod_dentrega = '$sprod_dentrega',sprod_hentrega = '$sprod_hentrega',sprod_estado = '$sprod_estado',sprod_comentario = '$sprod_comentario',sprod_dresolucion = '$fecha_reg' WHERE sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));		
			
			mysqli_commit($link);
			
			//ENVIAR EMAIL
			enviar_email($operacion,$sprod_id);			

		}				
		
		elseif($operacion == 'RECHAZAR SOLIC'){

			$sprod_id = $_POST['sprod_id'];
			$sprod_comentario = $_POST['sprod_comentario'];
			$sprod_estado = $_POST['sprod_estado'];
			
			if($sprod_id == "" or $sprod_comentario == "" or $sprod_estado == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "UPDATE SOLICITUD_PRODUCTOS SET sprod_estado = '$sprod_estado',sprod_comentario = '$sprod_comentario',sprod_dresolucion = '$fecha_reg' WHERE sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
			
			//ENVIAR EMAIL
			enviar_email($operacion,$sprod_id);
		}		
		

		elseif($operacion == 'UPDATE SOLIC ACEPTADA'){

			$sprod_id = $_POST['sprod_id'];
			$dentrega = explode("-" , $_POST['sprod_dentrega']);
			$sprod_dentrega = $dentrega[2].'-'.$dentrega[1].'-'.$dentrega[0];			
			
			$sprod_hentrega = $_POST['sprod_hentrega'];
			$sprod_comentario = $_POST['sprod_comentario'];
			
			if($sprod_id == "" or $sprod_dentrega == "" or $sprod_hentrega == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}

			mysqli_autocommit($link, FALSE);
			$total_prod= count($_POST["prod_cod"]);
			$i = 0;
			while($total_prod > $i){
				
				$prod_cod = $_POST['prod_cod'][$i];	
				$sprodr_cant = $_POST['sprodr_cant'][$i];	
				$sprodr_estado = $_POST['sprodr_estado'][$i];
				
				if($sprodr_estado == 'ACEPTADA'){
					$sql = "update SPROD_DETALLE set sprodr_estado = '$sprodr_estado',sprodr_cant = $sprodr_cant where prod_cod = '$prod_cod' and sprod_id = $sprod_id";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));		

					$sql = "UPDATE PRODUCTOS join SPROD_DETALLE sd on PRODUCTOS.prod_cod = SPROD_DETALLE.prod_cod
					SET 
						prod_stock = 
							case 
								when sprodr_estado = 'ACEPTADA' and sprodr_cant <> $sprodr_cant then prod_stock + sprodr_cant - $sprodr_cant
								when sprodr_estado = 'ACEPTADA' and sprodr_cant = $sprodr_cant then prod_stock
								when sprodr_estado = 'RECHAZADA' then prod_stock - $sprodr_cant
							end
					WHERE
						sprod_id = $sprod_id and PRODUCTOS.prod_cod = '$prod_cod'";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));	
				
				}
				elseif($sprodr_estado == 'RECHAZADA'){
					$sql = "update SPROD_DETALLE set sprodr_estado = '$sprodr_estado',sprodr_cant = NULL where prod_cod = '$prod_cod' and sprod_id = $sprod_id";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));	

					$sql = "UPDATE PRODUCTOS join SPROD_DETALLE sd on PRODUCTOS.prod_cod = SPROD_DETALLE.prod_cod
					SET 
						prod_stock = prod_stock + sprodr_cant
					WHERE
						sprod_id = $sprod_id and PRODUCTOS.prod_cod = '$prod_cod' and sprodr_estado = 'ACEPTADA'";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
					
				}	
				
				$i++;
			}
			
			$sql = "UPDATE SOLICITUD_PRODUCTOS SET sprod_dentrega = '$sprod_dentrega',sprod_hentrega = '$sprod_hentrega',sprod_comentario = '$sprod_comentario' WHERE sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			
			
			mysqli_commit($link);
			
			//ENVIAR EMAIL
			enviar_email($operacion,$sprod_id);
		}		
		
		elseif($operacion == 'RECHAZAR SOLIC ACEPTADA'){

			$sprod_id = $_POST['sprod_id'];
			$sprod_comentario = $_POST['sprod_comentario'];
			
			if($sprod_id == "" or $sprod_comentario == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			mysqli_autocommit($link, FALSE);
			
			$sql = "UPDATE SOLICITUD_PRODUCTOS SET sprod_estado = 'RECHAZADA',sprod_comentario = '$sprod_comentario' WHERE sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));

			$sql = "UPDATE PRODUCTOS join SPROD_DETALLE on PRODUCTOS.prod_cod = SPROD_DETALLE.prod_cod
			SET 
				prod_stock = prod_stock + sprodr_cant
			WHERE
				sprod_id = $sprod_id and sprodr_estado = 'ACEPTADA'";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));

			mysqli_commit($link);

			//ENVIAR EMAIL
			enviar_email($operacion,$sprod_id);			
		}			
		
		
		elseif($operacion == 'ENTREGAR PRODUCTOS'){

			$sprod_id = $_POST['sprod_id'];
			$sprod_id_retira = $_POST['sprod_id_retira'];
			$sprod_drentrega = $_POST['sprod_drentrega'];
			$sprod_hrentrega = $_POST['sprod_hrentrega'];		
			
			if($sprod_id == "" or $sprod_id_retira == "" or $sprod_drentrega == "" or $sprod_hrentrega == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$drentrega = explode("-" , $_POST['sprod_drentrega']);
			$sprod_drentrega = $drentrega[2].'-'.$drentrega[1].'-'.$drentrega[0];			
			
			$quien_retira = explode("**" , $_POST['sprod_id_retira']);
			$sprod_tiporetira = $quien_retira[1];		
			$usr_id_retira = '';
			$oper_rut_retira = '';			
			switch($sprod_tiporetira){				
				case 'U':
					$usr_id_retira = $quien_retira[0];
					$oper_rut_retira = "NULL";
				break;
				case 'O':
					$usr_id_retira = "NULL";
					$oper_rut_retira = "'$quien_retira[0]'";	
				break;
			}			
			
			//mysqli_autocommit($link, FALSE);
				$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos.');
				
				$sql = "UPDATE SOLICITUD_PRODUCTOS SET sprod_estado = 'ENTREGADA',sprod_drentrega = '$sprod_drentrega',sprod_hrentrega = '$sprod_hrentrega',sprod_tiporetira = '$sprod_tiporetira',usr_id_retira = $usr_id_retira,oper_rut_retira = $oper_rut_retira,sprod_entregasystem = '$fecha_reg' WHERE sprod_id = $sprod_id";
				//$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
				/*
				//REBAJA STOCK
				$sql = "UPDATE PRODUCTOS join SPROD_DETALLE on PRODUCTOS.prod_cod = SPROD_DETALLE.prod_cod
				SET 
					prod_stock = prod_stock - sprodr_cant
				WHERE
					sprod_id = $sprod_id";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				*/
			
			
			//mysqli_commit($link);
			
			//ENVIAR EMAIL
			enviar_email($operacion,$sprod_id);	
			
			//ENVIAR EMAIL BAJA STOCK MINIMO (ya no va mas)
			//enviar_email_stockmin();				
		}
		
		elseif($operacion == 'EMAIL_FALTA_STOCK'){
			enviar_email_stockmin();
		}
		
		elseif($operacion == 'ACTA ENTREGA'){
			$sprod_id = $_POST['sprod_id'];
			//ENVIAR EMAIL
			enviar_email($operacion,$sprod_id);				
		}
		
		elseif($operacion == 'ACTA ENTREGA Y REBAJA STOCK'){
			$sprod_id = $_POST['sprod_id'];

			mysqli_autocommit($link, FALSE);			
			$resp = array('cod'=>'error','desc'=>'Error de Base de Datos');	

			$sql = "UPDATE PRODUCTOS join SPROD_DETALLE on PRODUCTOS.prod_cod = SPROD_DETALLE.prod_cod
			SET 
				prod_stock = prod_stock - sprodr_cant
			WHERE
				sprod_id = $sprod_id";

			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
			
			$sql = "SELECT 1 from PRODUCTOS join SPROD_DETALLE on PRODUCTOS.prod_cod = SPROD_DETALLE.prod_cod where sprod_id = $sprod_id and prod_stock < 0";		

			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){		
				$resp = array('cod'=>'error','desc'=>'No existe stock suficiente en alguno de los productos');	
				salida_con_rollback($resp,$link);
			}

			mysqli_commit($link);
			
			//ENVIAR EMAIL
			enviar_email($operacion,$sprod_id);	
			
		}		
		
		
		
		elseif($operacion == 'CAMBIAR SOLIC RECHAZADA A PENDIENTE'){

			$sprod_id = $_POST['sprod_id'];
			
			if($sprod_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "UPDATE SOLICITUD_PRODUCTOS SET sprod_estado = 'PENDIENTE' WHERE sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
			
			//ENVIAR EMAIL
			enviar_email($operacion,$sprod_id);				
		}			
		
		
		else if($operacion == 'INSERT SB'){
		
			$sprod_id = $_POST['sprod_id'];
			$usr_id_solic = $_POST['usr_solic'];
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$sprod_dia = $_POST['sprod_dia'];
			$UNDVIV_ID = $_POST['UNDVIV_ID'];
			
			$destinatario = explode("**" , $_POST['destinatario']);
			$sprod_tipodest = $destinatario[1];		
			$usr_id_dest = '';
			$oper_rut_dest = '';			
			switch($sprod_tipodest){				
				case 'U':
					$usr_id_dest = $destinatario[0];
					$oper_rut_dest = "NULL";
				break;
				case 'O':
					$usr_id_dest = "NULL";
					$oper_rut_dest = "'$destinatario[0]'";	
				break;
			}
			
			$sprod_id_retira = $_POST['sprod_id_retira'];
			$sprod_drentrega = $_POST['sprod_drentrega'];
			$sprod_hrentrega = $_POST['sprod_hrentrega'];
			$drentrega = explode("-" , $_POST['sprod_drentrega']);
			$sprod_drentrega = $drentrega[2].'-'.$drentrega[1].'-'.$drentrega[0];			
			
			$quien_retira = explode("**" , $_POST['sprod_id_retira']);
			$sprod_tiporetira = $quien_retira[1];		
			$usr_id_retira = '';
			$oper_rut_retira = '';			
			switch($sprod_tiporetira){				
				case 'U':
					$usr_id_retira = $quien_retira[0];
					$oper_rut_retira = "NULL";
				break;
				case 'O':
					$usr_id_retira = "NULL";
					$oper_rut_retira = "'$quien_retira[0]'";	
				break;
			}				
			
			$prod_cod = $_POST['prod_cod'];
			$sprodd_cant = $_POST['sprodd_cant'];	
			
			
			
			
			if($usr_id_solic == "" or $per_agno == "" or $sem_num == "" or $sprod_dia == "" or $UNDVIV_ID == "" or $sprod_id_retira == "" or $sprod_drentrega == "" or $sprod_hrentrega == "" or $sprod_tipodest == "" or $usr_id_dest == "" or $oper_rut_dest == "" or $usr_id_retira == "" or $oper_rut_retira == "" or $prod_cod == "" or $sprodd_cant == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			if($sprod_id == ''){ //INSERT SOLICITUD + DETALLE PRODUCTOS
			
				mysqli_autocommit($link, FALSE);			
				$resp = array('cod'=>'error','desc'=>'Error de Base de Datos');			
			
				$sql = "insert into SOLICITUD_PRODUCTOS(usr_id_solic, per_agno, sem_num, sprod_dia, sprod_diasystem, UNDVIV_ID, sprod_tipodest, usr_id_dest, oper_rut_dest, sprod_estado, sprod_tiporetira, usr_id_retira, oper_rut_retira, sprod_salidabod, sprod_drentrega, sprod_hrentrega) 
				values ($usr_id_solic, $per_agno, $sem_num,'$sprod_dia', '$fecha_reg', $UNDVIV_ID,'$sprod_tipodest',$usr_id_dest,$oper_rut_dest,'ENTREGADA','$sprod_tiporetira', $usr_id_retira,$oper_rut_retira,'S', '$sprod_drentrega', '$sprod_hrentrega')";		
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));	
				
				$sprod_id = mysqli_insert_id($link);
			
				$sql = "insert into SPROD_DETALLE(sprod_id, prod_cod, sprodd_cant, sprodr_cant) 
				values ($sprod_id,'$prod_cod',$sprodd_cant,$sprodd_cant)";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				
				mysqli_commit($link);
			
			}
			else{ //INSERT DETALLE PRODUCTOS
				
				$sql = "SELECT 1 FROM SPROD_DETALLE where prod_cod = '$prod_cod' and sprod_id = $sprod_id";		

				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount > 0){
				
					$resp = array('cod'=>'error','desc'=>'Este Producto ya está registrado para esta Solicitud');
					salida($resp);
				}				
				
				$sql = "insert into SPROD_DETALLE(sprod_id, prod_cod, sprodd_cant, sprodr_cant) 
				values ($sprod_id,'$prod_cod',$sprodd_cant,$sprodd_cant)";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
			}
		}		
		
		
		elseif($operacion == 'REPLICAR_SOLICITUD SB'){
			
			$sprod_id = $_POST['sprod_id'];
			$usr_id_solic = $_POST['usr_solic'];
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$sprod_dia = $_POST['sprod_dia'];
			$UNDVIV_ID = $_POST['UNDVIV_ID'];			
			$destinatarios = $_POST['destinatarios'];
			
			$sprod_id_retira = $_POST['sprod_id_retira'];
			$sprod_drentrega = $_POST['sprod_drentrega'];
			$sprod_hrentrega = $_POST['sprod_hrentrega'];
			
			
			if($usr_id_solic == "" or $sprod_id == "" or $per_agno == "" or $sem_num == "" or $sprod_dia == "" or $UNDVIV_ID == "" or $sprod_id_retira == "" or $sprod_drentrega == "" or $sprod_hrentrega == "" or $destinatarios == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}	
			
			$drentrega = explode("-" , $_POST['sprod_drentrega']);
			$sprod_drentrega = $drentrega[2].'-'.$drentrega[1].'-'.$drentrega[0];			
			
			$quien_retira = explode("**" , $_POST['sprod_id_retira']);
			$sprod_tiporetira = $quien_retira[1];		
			$usr_id_retira = '';
			$oper_rut_retira = '';			
			switch($sprod_tiporetira){				
				case 'U':
					$usr_id_retira = $quien_retira[0];
					$oper_rut_retira = "NULL";
				break;
				case 'O':
					$usr_id_retira = "NULL";
					$oper_rut_retira = "'$quien_retira[0]'";	
				break;
			}				
			

			$destinatarios_array = explode("," , $destinatarios);
			
			mysqli_autocommit($link, FALSE);			
			$resp = array('cod'=>'error','desc'=>'Error de Base de Datos');	

			foreach ($destinatarios_array as $destinatario_unico){ 
			
				$destinatario = explode("**" , $destinatario_unico);
				$sprod_tipodest = $destinatario[1];		
				$usr_id_dest = '';
				$oper_rut_dest = '';			
				switch($sprod_tipodest){				
					case 'U':
						$usr_id_dest = $destinatario[0];
						$oper_rut_dest = "NULL";
					break;
					case 'O':
						$usr_id_dest = "NULL";
						$oper_rut_dest = "'$destinatario[0]'";	
					break;
				}	

				/*
				$sql= "insert into SOLICITUD_PRODUCTOS(usr_id_solic, per_agno, sem_num, sprod_dia, sprod_diasystem, UNDVIV_ID, sprod_tipodest, usr_id_dest, oper_rut_dest, sprod_estado) 
				values ($usr_id_solic, $per_agno, $sem_num,'$sprod_dia', '$fecha_reg', $UNDVIV_ID,'$sprod_tipodest',$usr_id_dest,$oper_rut_dest,'PENDIENTE')";	
				*/
				$sql = "insert into SOLICITUD_PRODUCTOS(usr_id_solic, per_agno, sem_num, sprod_dia, sprod_diasystem, UNDVIV_ID, sprod_tipodest, usr_id_dest, oper_rut_dest, sprod_estado, sprod_tiporetira, usr_id_retira, oper_rut_retira, sprod_salidabod, sprod_drentrega, sprod_hrentrega) 
				values ($usr_id_solic, $per_agno, $sem_num,'$sprod_dia', '$fecha_reg', $UNDVIV_ID,'$sprod_tipodest',$usr_id_dest,$oper_rut_dest,'ENTREGADA','$sprod_tiporetira', $usr_id_retira,$oper_rut_retira,'S', '$sprod_drentrega', '$sprod_hrentrega')";	
				
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));	

				$sprod_id_new = mysqli_insert_id($link);
				
				$sql = "insert into SPROD_DETALLE (sprod_id,prod_cod,sprodd_cant,sprodr_cant) SELECT $sprod_id_new,prod_cod,sprodd_cant,sprodd_cant FROM SPROD_DETALLE where sprod_id = $sprod_id";
				//$resp = array('cod'=>'error','desc'=>$sql);	
				//salida_con_rollback($resp,$link);					
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
				

					
			}
				//$resp = array('cod'=>'error','desc'=>$sql);
				//salida($resp);				
			mysqli_commit($link);		
			
		}			
		
		elseif($operacion == 'UPDATE_HEAD SB'){
		
			$sprod_id = $_POST['sprod_id'];
			$usr_id_solic = $_POST['usr_solic'];
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$sprod_dia = $_POST['sprod_dia'];
			$UNDVIV_ID = $_POST['UNDVIV_ID'];
			
			$destinatario = explode("**" , $_POST['destinatario']);
			$sprod_tipodest = $destinatario[1];		
			$usr_id_dest = '';
			$oper_rut_dest = '';			
			switch($sprod_tipodest){				
				case 'U':
					$usr_id_dest = $destinatario[0];
					$oper_rut_dest = "NULL";
				break;
				case 'O':
					$usr_id_dest = "NULL";
					$oper_rut_dest = "'$destinatario[0]'";	
				break;
			}
			
			$sprod_id_retira = $_POST['sprod_id_retira'];
			$sprod_drentrega = $_POST['sprod_drentrega'];
			$sprod_hrentrega = $_POST['sprod_hrentrega'];
			$drentrega = explode("-" , $_POST['sprod_drentrega']);
			$sprod_drentrega = $drentrega[2].'-'.$drentrega[1].'-'.$drentrega[0];			
			
			$quien_retira = explode("**" , $_POST['sprod_id_retira']);
			$sprod_tiporetira = $quien_retira[1];		
			$usr_id_retira = '';
			$oper_rut_retira = '';			
			switch($sprod_tiporetira){				
				case 'U':
					$usr_id_retira = $quien_retira[0];
					$oper_rut_retira = "NULL";
				break;
				case 'O':
					$usr_id_retira = "NULL";
					$oper_rut_retira = "'$quien_retira[0]'";	
				break;
			}
			
			if($usr_id_solic == "" or $per_agno == "" or $sem_num == "" or $sprod_dia == "" or $UNDVIV_ID == "" or $sprod_id_retira == "" or $sprod_drentrega == "" or $sprod_hrentrega == "" or $sprod_tipodest == "" or $usr_id_dest == "" or $oper_rut_dest == "" or $usr_id_retira == "" or $oper_rut_retira == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}		
			
			
			
			$sql = "UPDATE SOLICITUD_PRODUCTOS SET per_agno = $per_agno,sem_num = $sem_num,sprod_dia = $sprod_dia,UNDVIV_ID = $UNDVIV_ID, sprod_tipodest = '$sprod_tipodest', usr_id_dest = $usr_id_dest, oper_rut_dest = $oper_rut_dest, sprod_tiporetira = '$sprod_tiporetira', usr_id_retira = $usr_id_retira, oper_rut_retira = $oper_rut_retira, sprod_drentrega = '$sprod_drentrega', sprod_hrentrega = '$sprod_hrentrega' WHERE sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
		}			
		
		
		

		$resp = array('cod'=>'ok','operacion'=>$operacion,'sprod_id'=>$sprod_id);
	}
	
	
	
	
	
	
	
	
	
	

	
	//Retorna respuesta
	echo json_encode($resp);	

?>