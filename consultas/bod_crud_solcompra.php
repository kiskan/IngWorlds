<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	$upload = '/home/ing2018/public_html/ingworlds/proyecto/sisconvi-production/cotizaciones/';					 

	if(isset($_GET['data'])){
	
	session_start();
				
		$sql = "SELECT DISTINCT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD_ID, US1.USR_NOMBRE AS SOLICITANTE,	
				UNIDAD_VIVEROS.UNDVIV_NOMBRE, SPROD_TIPOCOMPRA, SPROD_PRIORIDAD, SPROD_TIPOMANT, SPROD_MOTIVO, UNIDAD_VIVEROS.UNDVIV_ID
				FROM SOLICITUD_PRODUCTOS AS SPROD 
				JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
				JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
				JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
				WHERE SPROD_ESTADO = 'PENDIENTE' AND SPROD_TIPOSOL = 'SC' AND
			  ( SPROD.USR_ID_SOLIC = ".$_SESSION['USR_ID']." OR '".$_SESSION['USR_TIPO']."' = 'ADMINISTRADOR' OR '".$_SESSION['USR_TIPO']."' = 'JEFE BODEGA' ) 				
				ORDER BY SPROD_DIA, SPROD_ID DESC";				
											
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

	elseif(isset($_GET['cotiz'])){
				
		$sql = "SELECT DISTINCT SEM.PER_AGNO, SEM.SEM_NUM, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, SPROD_ID, US1.USR_NOMBRE AS SOLICITANTE,	
		UNIDAD_VIVEROS.UNDVIV_NOMBRE, SPROD_TIPOCOMPRA, SPROD_PRIORIDAD, SPROD_TIPOMANT, SPROD_MOTIVO, SPROD_COMENCOTIZ, UNIDAD_VIVEROS.UNDVIV_ID
		FROM SOLICITUD_PRODUCTOS AS SPROD 
		JOIN SEMANAS AS SEM ON SPROD.PER_AGNO = SEM.PER_AGNO AND SPROD.SEM_NUM = SEM.SEM_NUM
		JOIN UNIDAD_VIVEROS ON UNIDAD_VIVEROS.UNDVIV_ID = SPROD.UNDVIV_ID
		JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
		WHERE SPROD_ESTADO = 'PENDIENTE' AND SPROD_TIPOSOL = 'SC'
		ORDER BY SPROD_DIA, SPROD_ID DESC";				
											
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
	
	
	elseif(isset($_GET['sprodd_id'])){
	
		$sprodd_id = $_GET['sprodd_id'];
		$cotcom_tipo = $_GET['cotcom_tipo'];
		$tipo_compra = $_GET['tipo_compra'];
		
		if($cotcom_tipo == 'COTIZACION')
		{
			if($tipo_compra == 'COMPRA MATERIAL'){
				$sql = "SELECT DISTINCT COTCOM_ID,COTCOM_PROVSEL,SUBSTRING(COTCOM_PROVEEDOR,1,40) COTCOM_PROVEEDOR_ACORTADO, COTCOM_PROVEEDOR,COTCOM_PRECIO,COTCOM_CANTIDAD,(COTCOM_PRECIO*COTCOM_CANTIDAD) COTCOM_TOTAL,COTCOM_ACORDADO,ifnull(COTCOM_ARCHIVO1,'') COTCOM_ARCHIVO1, ifnull(COTCOM_ARCHIVO2,'') COTCOM_ARCHIVO2,ifnull(COTCOM_ARCHIVO3,'') COTCOM_ARCHIVO3
				FROM COTIZ_COMPRA
				WHERE SPRODD_ID = $sprodd_id and COTCOM_TIPO = 'COTIZACION'
				ORDER BY COTCOM_PROVSEL DESC";				
			}

			if($tipo_compra == 'PRESTACIÓN SERVICIO'){
				$sql = "SELECT DISTINCT COTCOM_ID,COTCOM_PROVSEL,SUBSTRING(COTCOM_PROVEEDOR,1,40) COTCOM_PROVEEDOR_ACORTADO, COTCOM_PROVEEDOR,COTCOM_PRECIO,COTCOM_CANTIDAD, '' COTCOM_TOTAL,COTCOM_ACORDADO,ifnull(COTCOM_ARCHIVO1,'') COTCOM_ARCHIVO1, ifnull(COTCOM_ARCHIVO2,'') COTCOM_ARCHIVO2,ifnull(COTCOM_ARCHIVO3,'') COTCOM_ARCHIVO3
				FROM COTIZ_COMPRA
				WHERE SPRODD_ID = $sprodd_id and COTCOM_TIPO = 'COTIZACION'
				ORDER BY COTCOM_PROVSEL DESC";				
			}					
		}
		
		if($cotcom_tipo == 'COMPRA')
		{
			if($tipo_compra == 'COMPRA MATERIAL'){
				$sql = "SELECT DISTINCT COTCOM_ID,SUBSTRING(COTCOM_PROVEEDOR,1,40) COTCOM_PROVEEDOR_ACORTADO, COTCOM_PROVEEDOR,IFNULL(CONCAT(DATE_FORMAT(COTCOM_DENTREGA,'%d-%m-%Y'), ' ', COTCOM_HENTREGA),'') as FECHA_ENTREGA,COTCOM_PRECIO,COTCOM_CANTIDAD,/*(COTCOM_PRECIO*COTCOM_CANTIDAD) COTCOM_TOTAL,*/IFNULL(COTCOM_AVANCE,'')COTCOM_AVANCE, COTCOM_ACORDADO, IFNULL(COTCOM_HES,'')COTCOM_HES,/*IFNULL(COTCOM_CODIGOSAP,'')COTCOM_CODIGOSAP,*/
				(select c.COTCOM_PRECIO*c.COTCOM_CANTIDAD from COTIZ_COMPRA c where c.sprodd_id = $sprodd_id and c.cotcom_provsel = 'S') COTCOM_TOTAL
				FROM COTIZ_COMPRA
				WHERE SPRODD_ID = $sprodd_id and COTCOM_TIPO = 'COMPRA'
				ORDER BY COTCOM_ID DESC";				
			}

			if($tipo_compra == 'PRESTACIÓN SERVICIO'){
				$sql = "SELECT DISTINCT COTCOM_ID,SUBSTRING(COTCOM_PROVEEDOR,1,40) COTCOM_PROVEEDOR_ACORTADO, COTCOM_PROVEEDOR,IFNULL(CONCAT(DATE_FORMAT(COTCOM_DENTREGA,'%d-%m-%Y'), ' ', COTCOM_HENTREGA),'') as FECHA_ENTREGA,COTCOM_PRECIO,COTCOM_CANTIDAD,COTCOM_PRECIO COTCOM_TOTAL,IFNULL(COTCOM_AVANCE,'')COTCOM_AVANCE, COTCOM_ACORDADO,/*IFNULL(COTCOM_CODIGOSAP,'')COTCOM_CODIGOSAP,*/ IFNULL(COTCOM_HES,'')COTCOM_HES
				FROM COTIZ_COMPRA
				WHERE SPRODD_ID = $sprodd_id and COTCOM_TIPO = 'COMPRA'
				ORDER BY COTCOM_ID DESC";				
			}				
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
	}		
	
	
	
	elseif(isset($_GET['nro_solicitud'])){

		$sql = "select SPRODD_ID, p.CATPROD_ID, p.PROD_COD, c.CATPROD_NOMBRE, 
		(
		CASE 
		   WHEN s.sprod_tipocompra = 'COMPRA MATERIAL' then p.prod_nombre
		   WHEN s.sprod_tipocompra = 'PRESTACIÓN SERVICIO' then sd.sprodd_servicio
		END
		) PROD_NOMBRE
		,
		(
		CASE 
		   WHEN s.sprod_tipocompra = 'COMPRA MATERIAL' then SUBSTRING(p.prod_nombre,1,40)
		   WHEN s.sprod_tipocompra = 'PRESTACIÓN SERVICIO' then SUBSTRING(sd.sprodd_servicio,1,40)
		END
		) PROD_NOMBRE_ACORTADO		
		,sd.SPRODD_CANT, 
		(
		CASE 
		   WHEN s.sprod_tipocompra = 'COMPRA MATERIAL' then p.PROD_VALOR
		   WHEN s.sprod_tipocompra = 'PRESTACIÓN SERVICIO' then ''
		END
		) PROD_VALOR,
		(
		CASE 
		   WHEN s.sprod_tipocompra = 'COMPRA MATERIAL' then (sd.SPRODD_CANT * p.PROD_VALOR)
		   WHEN s.sprod_tipocompra = 'PRESTACIÓN SERVICIO' then ''
		END
		) PROT_TOTAL		
			
		from SPROD_DETALLE sd
		JOIN SOLICITUD_PRODUCTOS s on s.sprod_id = sd.sprod_id
		left join PRODUCTOS p on sd.prod_cod = p.prod_cod
		left join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id 
		where SPROD_TIPOSOL = 'SC' AND sd.sprod_id = ".$_GET['nro_solicitud']." ";	
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
		
		$resp = array('cod'=>'error','desc'=>'Error de Base de Datos');
					
		if($operacion == 'INSERT'){
		
			session_start();
			$sprod_id = $_POST['sprod_id'];
			$usr_id_solic = $_SESSION['USR_ID'];
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$sprod_dia = $_POST['sprod_dia'];
			$UNDVIV_ID = $_POST['UNDVIV_ID'];
			
			$sprod_tipocompra = $_POST['sprod_tipocompra'];
			$sprod_prioridad = $_POST['sprod_prioridad'];
			$sprod_tipomant = $_POST['sprod_tipomant'];
			$sprod_motivo = $_POST['sprod_motivo'];

			$prod_cod = $_POST['prod_cod'];
			$sprodd_cant = $_POST['sprodd_cant'];
			
			$sprodd_servicio = $_POST['sprodd_servicio'];
			$sprodd_plazo = $_POST['sprodd_plazo'];

			
			if($usr_id_solic == "" or $per_agno == "" or $sem_num == "" or $sprod_dia == "" or $UNDVIV_ID == "" or $sprod_tipocompra == "" or $sprod_prioridad == "" or $sprod_tipomant == "" or $sprod_motivo == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}
			
			$flag = 0;
			if($sprod_tipocompra == 'COMPRA MATERIAL'){
				if($prod_cod == "" or $sprodd_cant == ""){
					$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios1');
					salida($resp);					
				}	
				$flag = 1;
			}
			if($sprod_tipocompra == 'PRESTACIÓN SERVICIO'){
				if($sprodd_servicio == "" or $sprodd_plazo == ""){
					$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios2');
					salida($resp);					
				}
				$flag = 1;
			}
			
			if($flag == 0){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios3');
				salida($resp);					
			}	
			
			
			if($sprod_id == ''){ //INSERT SOLICITUD + DETALLE PRODUCTOS
				
				mysqli_autocommit($link, FALSE);								
			
				$sql = "insert into SOLICITUD_PRODUCTOS(usr_id_solic, per_agno, sem_num, sprod_dia, sprod_diasystem, undviv_id, sprod_tipocompra, sprod_prioridad, sprod_tipomant, sprod_estado, sprod_tiposol, sprod_motivo) 
				values ($usr_id_solic, $per_agno, $sem_num,'$sprod_dia', '$fecha_reg', $UNDVIV_ID,'$sprod_tipocompra','$sprod_prioridad','$sprod_tipomant','PENDIENTE', 'SC', '$sprod_motivo')";		
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));	
				
				$sprod_id = mysqli_insert_id($link);
			
				if($sprod_tipocompra == 'COMPRA MATERIAL'){
					$sqldet = "insert into SPROD_DETALLE(sprod_id, prod_cod, sprodd_cant) 
					values ($sprod_id,'$prod_cod',$sprodd_cant)";			
				}
				if($sprod_tipocompra == 'PRESTACIÓN SERVICIO'){
					$sqldet = "insert into SPROD_DETALLE(sprod_id, sprodd_servicio, sprodd_cant) 
					values ($sprod_id,'$sprodd_servicio',$sprodd_plazo)";			
				}				
		
				$resultado = mysqli_query($link,$sqldet)or die(salida_con_rollback($resp,$link));
				
				mysqli_commit($link);
			
			}
			else{ //INSERT DETALLE PRODUCTOS
				
				if($sprod_tipocompra == 'COMPRA MATERIAL'){
					$sql = "SELECT 1 FROM SPROD_DETALLE where prod_cod = '$prod_cod' and sprod_id = $sprod_id";				
				}
				if($sprod_tipocompra == 'PRESTACIÓN SERVICIO'){
					$sql = "SELECT 1 FROM SPROD_DETALLE where sprodd_servicio = '$sprodd_servicio' and sprod_id = $sprod_id";			
				}								

				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount > 0){				
					$resp = array('cod'=>'error','desc'=>'Este Producto/Servicio ya está registrado para esta Solicitud');
					salida($resp);
				}				
				
				if($sprod_tipocompra == 'COMPRA MATERIAL'){
					$sql = "insert into SPROD_DETALLE(sprod_id, prod_cod, sprodd_cant) 
					values ($sprod_id,'$prod_cod',$sprodd_cant)";			
				}
				if($sprod_tipocompra == 'PRESTACIÓN SERVICIO'){
					$sql = "insert into SPROD_DETALLE(sprod_id, sprodd_servicio, sprodd_cant) 
					values ($sprod_id,'$sprodd_servicio',$sprodd_plazo)";			
				}
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
			}
			
			//ENVIAR EMAIL
			enviar_email_solproducto($sprod_id);				
			
		}
		
		elseif($operacion == 'UPDATE'){
			
			$sprod_tipocompra = $_POST['sprod_tipocompra'];
			$sprodd_id = $_POST['sprodd_id'];
			$sprod_id = $_POST['sprod_id'];
			
			if($sprod_tipocompra == 'COMPRA MATERIAL'){
				
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
			else{
				
				$sprodd_servicio = $_POST['sprodd_servicio'];
				$h_sprodd_servicio = $_POST['h_sprodd_servicio'];
				$sprodd_plazo = $_POST['sprodd_plazo'];		
				
				if($sprodd_servicio == "" or $sprod_id == "" or $sprodd_plazo == "" or $h_sprodd_servicio == "" ){
					$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
					salida($resp);
				}
				
				if($sprodd_servicio <> $h_sprodd_servicio){
					$sql = "SELECT 1 FROM SPROD_DETALLE where sprodd_servicio = '$sprodd_servicio' and sprod_id = $sprod_id";		

					$resultado = mysqli_query($link,$sql);	
					$rowcount = mysqli_num_rows($resultado);

					if($rowcount > 0){	
						$resp = array('cod'=>'error','desc'=>'Este Servicio ya está registrado para esta Solicitud');
						salida($resp);
					}					
				}
				
				$sql = "update SPROD_DETALLE set sprodd_servicio = '$sprodd_servicio',sprodd_cant = $sprodd_plazo where sprodd_id = $sprodd_id";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));				
			}
			
		}	
		
		elseif($operacion == 'UPDATE_HEAD'){
			
			$sprod_id = $_POST['sprod_id'];
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$sprod_dia = $_POST['sprod_dia'];
			$UNDVIV_ID = $_POST['UNDVIV_ID'];
			
			$sprod_tipocompra = $_POST['sprod_tipocompra'];
			$sprod_prioridad = $_POST['sprod_prioridad'];
			$sprod_tipomant = $_POST['sprod_tipomant'];
			$sprod_motivo = $_POST['sprod_motivo'];	
			
			if($sprod_id == "" or $per_agno == "" or $sem_num == "" or $sprod_dia == "" or $UNDVIV_ID == "" or $sprod_tipocompra == "" or $sprod_prioridad == "" or $sprod_tipomant == "" or $sprod_motivo == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
				salida($resp);
			}			
			
			$sql = "UPDATE SOLICITUD_PRODUCTOS SET per_agno = $per_agno,sem_num = $sem_num,sprod_dia = $sprod_dia,UNDVIV_ID = $UNDVIV_ID, sprod_tipocompra = '$sprod_tipocompra', sprod_prioridad = '$sprod_prioridad', sprod_tipomant = '$sprod_tipomant', sprod_motivo = '$sprod_motivo' WHERE sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
		}			
		
		elseif($operacion == 'DELETE'){
			
			$sprod_id = $_POST['sprod_id'];
			//$h_prod_cod = $_POST['h_prod_cod'];
			$sprodd_id = $_POST['sprodd_id'];
			
			if($sprodd_id == "" or $sprod_id == ""){
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
				$sql = "delete from SPROD_DETALLE where sprodd_id = $sprodd_id";
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
		
	

		elseif($operacion == 'ACEPTAR SOLIC'){

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
				}
				elseif($sprodr_estado == 'RECHAZADA'){
					$sql = "update SPROD_DETALLE set sprodr_estado = '$sprodr_estado' where prod_cod = '$prod_cod' and sprod_id = $sprod_id";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));			
				}	
				
				$i++;
			}
			
			$sql = "UPDATE SOLICITUD_PRODUCTOS SET sprod_dentrega = '$sprod_dentrega',sprod_hentrega = '$sprod_hentrega',sprod_estado = '$sprod_estado',sprod_comentario = '$sprod_comentario',sprod_dresolucion = '$fecha_reg' WHERE sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			
			
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
				}
				elseif($sprodr_estado == 'RECHAZADA'){
					$sql = "update SPROD_DETALLE set sprodr_estado = '$sprodr_estado',sprodr_cant = NULL where prod_cod = '$prod_cod' and sprod_id = $sprod_id";
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
			
			$sql = "UPDATE SOLICITUD_PRODUCTOS SET sprod_estado = 'RECHAZADA',sprod_comentario = '$sprod_comentario' WHERE sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
			
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
			
			
			$sql = "UPDATE SOLICITUD_PRODUCTOS SET sprod_estado = 'ENTREGADA',sprod_drentrega = '$sprod_drentrega',sprod_hrentrega = '$sprod_hrentrega',sprod_tiporetira = '$sprod_tiporetira',usr_id_retira = $usr_id_retira,oper_rut_retira = $oper_rut_retira,sprod_entregasystem = '$fecha_reg' WHERE sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
			
			//ENVIAR EMAIL
			enviar_email($operacion,$sprod_id);				
		}	
		
		elseif($operacion == 'ACTA ENTREGA'){
			$sprod_id = $_POST['sprod_id'];
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
		
	
	
//COTIZACIONES	
	
		
		elseif($operacion == 'REGISTRAR COTIZACION'){
			
			$sprodd_id = $_POST['sprodd_id'];
			$cotcom_proveedor = $_POST['cotcom_proveedor'];
			$cotcom_precio = $_POST['cotcom_precio'];
			$cotcom_cantidad = $_POST['cotcom_cantidad'];
			//$cotcom_acordado = $_POST['cotcom_acordado'];
			//$cotcom_provsel = $_POST['cotcom_provsel'];		
			$cotcom_provsel = $_POST['provsel'];	
			
			
			if($sprodd_id == "" or $cotcom_proveedor == "" or $cotcom_precio == "" or $cotcom_cantidad == "" /*or $cotcom_acordado == ""*/ or $cotcom_provsel == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$cotcom_acordado = $cotcom_precio * $cotcom_cantidad;
/*			
			if($cotcom_provsel == 'S'){
				$sql = "update COTIZ_COMPRA set cotcom_provsel = 'N' where sprodd_id = $sprodd_id";	
				$resultado = mysqli_query($link,$sql)or die(salida($resp));	
			}			
			
			$sql = "insert into COTIZ_COMPRA(sprodd_id, cotcom_proveedor, cotcom_precio, cotcom_cantidad, cotcom_acordado, cotcom_tipo, cotcom_provsel) values ($sprodd_id, '$cotcom_proveedor', $cotcom_precio, $cotcom_cantidad, $cotcom_acordado, 'COTIZACION', '$cotcom_provsel')";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));	

			$cotcom_id = mysqli_insert_id($link);
*/			
			//RUTA
			//$upload = "/cotizaciones";
			//$upload = 'http://ing-worlds.cl/proyecto/sisconvi-production/cotizaciones/';
			//$upload = '/home/ing2018/public_html/ingworlds/proyecto/sisconvi-production/cotizaciones/';

			//ARCHIVOS PERMITIDOS			
			$archivos_permitidos = 'image/gif,image/jpeg,image/jpg,image/pjpeg,image/png,application/msword,application/vnd.ms-excel,application/rtf,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';						
			
			$file1='';$file2='';$file3='';

//COTIZACION 1			
			if($_FILES['file1']['name'] <> "") {
			
				$name_file1 = $_FILES['file1']['name'];
				$type_file1 = $_FILES['file1']['type'];
				$size_file1 = $_FILES['file1']['size'];
				$archivo1 	= $_FILES['file1']['tmp_name'];

				//TIPO ARCHIVO
				$busqueda = strpos($archivos_permitidos, $type_file1);
				if ($busqueda === false){
					$resp = array('cod'=>'error','desc'=>$name_file1.' (Tipo archivo no permitido)');
					salida($resp);		
				}

				//TAMAÑO DEL ARCHIVO	
				$max_file = 3 * 1024 * 1024; // 3MB
				if($size_file1 > $max_file){
					$resp = array('cod'=>'error','desc'=>$name_file1.' (Tamaño no permitido)');
					salida($resp);		
				}	

				$extension = '.'.end(explode(".", $name_file1));
				$file1 = basename($name_file1, $extension); 

				//NOMBRE + FECHA + HORA + EXTENSIÓN
				$file1 = $file1.'_'.date('dmyhis').$extension;	
			}
				
//COTIZACION 2			
			if($_FILES['file2']['name'] <> "") {
			
				$name_file2 = $_FILES['file2']['name'];
				$type_file2 = $_FILES['file2']['type'];
				$size_file2 = $_FILES['file2']['size'];
				$archivo2 	= $_FILES['file2']['tmp_name'];

				//TIPO ARCHIVO
				$busqueda = strpos($archivos_permitidos, $type_file2);
				if ($busqueda === false){
					$resp = array('cod'=>'error','desc'=>$name_file2.' (Tipo archivo no permitido)');
					salida($resp);		
				}

				//TAMAÑO DEL ARCHIVO	
				$max_file = 3 * 1024 * 1024; // 3MB
				if($size_file2 > $max_file){
					$resp = array('cod'=>'error','desc'=>$name_file2.' (Tamaño no permitido)');
					salida($resp);		
				}	

				$extension = '.'.end(explode(".", $name_file2));
				$file2 = basename($name_file2, $extension); 

				//NOMBRE + FECHA + HORA + EXTENSIÓN
				$file2 = $file2.'_'.date('dmyhis').$extension;	
			}
			
//COTIZACION 3			
			if($_FILES['file3']['name'] <> "") {
			
				$name_file3 = $_FILES['file3']['name'];
				$type_file3 = $_FILES['file3']['type'];
				$size_file3 = $_FILES['file3']['size'];
				$archivo3 	= $_FILES['file3']['tmp_name'];

				//TIPO ARCHIVO
				$busqueda = strpos($archivos_permitidos, $type_file3);
				if ($busqueda === false){
					$resp = array('cod'=>'error','desc'=>$name_file3.' (Tipo archivo no permitido)');
					salida($resp);		
				}

				//TAMAÑO DEL ARCHIVO	
				$max_file = 3 * 1024 * 1024; // 3MB
				if($size_file3 > $max_file){
					$resp = array('cod'=>'error','desc'=>$name_file3.' (Tamaño no permitido)');
					salida($resp);		
				}	

				$extension = '.'.end(explode(".", $name_file3));
				$file3 = basename($name_file3, $extension); 

				//NOMBRE + FECHA + HORA + EXTENSIÓN
				$file3 = $file3.'_'.date('dmyhis').$extension;	
			}			
			
			
//GUARDAR COTIZACION 1			
			if($_FILES['file1']['name'] <> "") {
				if (!move_uploaded_file($archivo1,$upload.$file1)){
					$resp = array('cod'=>'error','desc'=>'Documento(s) no guardado(s)');
					salida($resp);			
				}				
			}			
			
//GUARDAR COTIZACION 2			
			if($_FILES['file2']['name'] <> "") {
				if (!move_uploaded_file($archivo2,$upload.$file2)){
					$resp = array('cod'=>'error','desc'=>'Documento(s) no guardado(s)');
					salida($resp);			
				}				
			}				

//GUARDAR COTIZACION 3			
			if($_FILES['file3']['name'] <> "") {
				if (!move_uploaded_file($archivo3,$upload.$file3)){
					$resp = array('cod'=>'error','desc'=>'Documento(s) no guardado(s)');
					salida($resp);			
				}				
			}
			
			$file1 = !empty($file1) ? "'$file1'" : "NULL";
			$file2 = !empty($file2) ? "'$file2'" : "NULL";
			$file3 = !empty($file3) ? "'$file3'" : "NULL";

			if($cotcom_provsel == 'S'){
				$sql = "update COTIZ_COMPRA set cotcom_provsel = 'N' where sprodd_id = $sprodd_id";	
				$resultado = mysqli_query($link,$sql)or die(salida($resp));	
			}			
			
			$sql = "insert into COTIZ_COMPRA(sprodd_id, cotcom_proveedor, cotcom_precio, cotcom_cantidad, cotcom_acordado, cotcom_tipo, cotcom_provsel) values ($sprodd_id, '$cotcom_proveedor', $cotcom_precio, $cotcom_cantidad, $cotcom_acordado, 'COTIZACION', '$cotcom_provsel')";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));	

			$cotcom_id = mysqli_insert_id($link);	
	
	
			//UPDATE
			$sql = "update COTIZ_COMPRA set cotcom_archivo1 = $file1 , cotcom_archivo2 = $file2 , cotcom_archivo3 = $file3 where cotcom_id = $cotcom_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
	
		}			
		
		
		elseif($operacion == 'MODIFICAR COTIZACION'){
			
			$cotcom_id = $_POST['cotcom_id'];
			$sprodd_id = $_POST['sprodd_id'];
			$cotcom_proveedor = $_POST['cotcom_proveedor'];
			$cotcom_precio = $_POST['cotcom_precio'];
			$cotcom_cantidad = $_POST['cotcom_cantidad'];
												  
			$cotcom_provsel = $_POST['provsel'];			
			
			if($sprodd_id == "" or $cotcom_id == "" or $cotcom_proveedor == "" or $cotcom_precio == "" or $cotcom_cantidad == "" /*or $cotcom_acordado == "" */or $cotcom_provsel == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$cotcom_acordado = $cotcom_precio * $cotcom_cantidad;
			
			//$resp = array('cotcom_id'=>$cotcom_id,'sprodd_id'=>$sprodd_id,'cotcom_proveedor'=>$cotcom_proveedor,'cotcom_precio'=>$cotcom_precio,'cotcom_cantidad'=>$cotcom_cantidad,'cotcom_provsel'=>$cotcom_provsel);
			
			if($cotcom_provsel == 'S'){
				$sql = "update COTIZ_COMPRA set cotcom_provsel = 'N' where sprodd_id = $sprodd_id";	
				$resultado = mysqli_query($link,$sql)or die(salida($resp));	
			}		
			



			//RUTA
			//$upload = '/home/ing2018/public_html/ingworlds/proyecto/sisconvi-production/cotizaciones/';

			//ARCHIVOS PERMITIDOS			
			$archivos_permitidos = 'image/gif,image/jpeg,image/jpg,image/pjpeg,image/png,application/msword,application/vnd.ms-excel,application/rtf,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';						
			
			$file1='';$file2='';$file3='';

//COTIZACION 1			
			if($_FILES['file1']['name'] <> "") {
			
				$name_file1 = $_FILES['file1']['name'];
				$type_file1 = $_FILES['file1']['type'];
				$size_file1 = $_FILES['file1']['size'];
				$archivo1 	= $_FILES['file1']['tmp_name'];

				//TIPO ARCHIVO
				$busqueda = strpos($archivos_permitidos, $type_file1);
				if ($busqueda === false){
					$resp = array('cod'=>'error','desc'=>$name_file1.' (Tipo archivo no permitido)');
					salida($resp);		
				}

				//TAMAÑO DEL ARCHIVO	
				$max_file = 3 * 1024 * 1024; // 3MB
				if($size_file1 > $max_file){
					$resp = array('cod'=>'error','desc'=>$name_file1.' (Tamaño no permitido)');
					salida($resp);		
				}	

				$extension = '.'.end(explode(".", $name_file1));
				$file1 = basename($name_file1, $extension); 

				//NOMBRE + FECHA + HORA + EXTENSIÓN
				$file1 = $file1.'_'.date('dmyhis').$extension;	
			}
				
//COTIZACION 2			
			if($_FILES['file2']['name'] <> "") {
			
				$name_file2 = $_FILES['file2']['name'];
				$type_file2 = $_FILES['file2']['type'];
				$size_file2 = $_FILES['file2']['size'];
				$archivo2 	= $_FILES['file2']['tmp_name'];

				//TIPO ARCHIVO
				$busqueda = strpos($archivos_permitidos, $type_file2);
				if ($busqueda === false){
					$resp = array('cod'=>'error','desc'=>$name_file2.' (Tipo archivo no permitido)');
					salida($resp);		
				}

				//TAMAÑO DEL ARCHIVO	
				$max_file = 3 * 1024 * 1024; // 3MB
				if($size_file2 > $max_file){
					$resp = array('cod'=>'error','desc'=>$name_file2.' (Tamaño no permitido)');
					salida($resp);		
				}	

				$extension = '.'.end(explode(".", $name_file2));
				$file2 = basename($name_file2, $extension); 

				//NOMBRE + FECHA + HORA + EXTENSIÓN
				$file2 = $file2.'_'.date('dmyhis').$extension;	
			}
			
//COTIZACION 3			
			if($_FILES['file3']['name'] <> "") {
			
				$name_file3 = $_FILES['file3']['name'];
				$type_file3 = $_FILES['file3']['type'];
				$size_file3 = $_FILES['file3']['size'];
				$archivo3 	= $_FILES['file3']['tmp_name'];

				//TIPO ARCHIVO
				$busqueda = strpos($archivos_permitidos, $type_file3);
				if ($busqueda === false){
					$resp = array('cod'=>'error','desc'=>$name_file3.' (Tipo archivo no permitido)');
					salida($resp);		
				}

				//TAMAÑO DEL ARCHIVO	
				$max_file = 3 * 1024 * 1024; // 3MB
				if($size_file3 > $max_file){
					$resp = array('cod'=>'error','desc'=>$name_file3.' (Tamaño no permitido)');
					salida($resp);		
				}	

				$extension = '.'.end(explode(".", $name_file3));
				$file3 = basename($name_file3, $extension); 

				//NOMBRE + FECHA + HORA + EXTENSIÓN
				$file3 = $file3.'_'.date('dmyhis').$extension;	
			}			
			
			
//GUARDAR COTIZACION 1			
			if($_FILES['file1']['name'] <> "") {
				if (!move_uploaded_file($archivo1,$upload.$file1)){
					$resp = array('cod'=>'error','desc'=>'Documento(s) no guardado(s)');
					salida($resp);			
				}						
			}			
			
//GUARDAR COTIZACION 2			
			if($_FILES['file2']['name'] <> "") {
				if (!move_uploaded_file($archivo2,$upload.$file2)){
					$resp = array('cod'=>'error','desc'=>'Documento(s) no guardado(s)');
					salida($resp);			
				}				
			}				

//GUARDAR COTIZACION 3			
			if($_FILES['file3']['name'] <> "") {
				if (!move_uploaded_file($archivo3,$upload.$file3)){
					$resp = array('cod'=>'error','desc'=>'Documento(s) no guardado(s)');
					salida($resp);			
				}				
			}
			/*
			$file1 = !empty($file1) ? "'$file1'" : "NULL";
			$file2 = !empty($file2) ? "'$file2'" : "NULL";
			$file3 = !empty($file3) ? "'$file3'" : "NULL";
			*/
			$sql = "update COTIZ_COMPRA set cotcom_proveedor = '$cotcom_proveedor' , cotcom_precio =$cotcom_precio , cotcom_cantidad = $cotcom_cantidad, cotcom_acordado = $cotcom_acordado, cotcom_provsel = '$cotcom_provsel' where cotcom_id = $cotcom_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));	
			
//UPDATEAR COTIZACION 1			
			if($_FILES['file1']['name'] <> "") {			
				//UPDATE
				$sql = "update COTIZ_COMPRA set cotcom_archivo1 = '$file1' where cotcom_id = $cotcom_id";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
			}
//UPDATEAR COTIZACION 2			
			if($_FILES['file2']['name'] <> "") {			
				//UPDATE
				$sql = "update COTIZ_COMPRA set cotcom_archivo2 = '$file2' where cotcom_id = $cotcom_id";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
			}
//UPDATEAR COTIZACION 3			
			if($_FILES['file3']['name'] <> "") {			
				//UPDATE
				$sql = "update COTIZ_COMPRA set cotcom_archivo3 = '$file3' where cotcom_id = $cotcom_id";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));
			}			
		}	
		
		elseif($operacion == 'ELIMINAR COTIZACION'){
			
			$cotcom_id = $_POST['cotcom_id'];	
			
			if($cotcom_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}	

			$sql = "select ifnull(cotcom_archivo1,''),ifnull(cotcom_archivo2,''),ifnull(cotcom_archivo3,'') from COTIZ_COMPRA where cotcom_id = $cotcom_id";
			$resultado = mysqli_query($link,$sql);				
	
			$fila = mysqli_fetch_row($resultado);
			$archivo1 = $fila[0];
			$archivo2 = $fila[1];
			$archivo3 = $fila[2];
			
			if($archivo1<>''){
				$ruta_archivo = '../cotizaciones/'.$archivo1;
				if(file_exists($ruta_archivo)) unlink($ruta_archivo);			
			}
			if($archivo2<>''){
				$ruta_archivo = '../cotizaciones/'.$archivo2;
				if(file_exists($ruta_archivo)) unlink($ruta_archivo);			
			}			
			if($archivo3<>''){
				$ruta_archivo = '../cotizaciones/'.$archivo3;
				if(file_exists($ruta_archivo)) unlink($ruta_archivo);			
			}
			
			$sql = "delete from COTIZ_COMPRA where cotcom_id = $cotcom_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			
		}

		
		elseif($operacion == 'UPDATE CC'){
			
			$cc_sprodd_id = $_POST['cc_sprodd_id'];
			$cc_iden = $_POST['cc_id'];
			$total_cc = count($_POST["cc_id"]);	
			
			if($total_cc == 0){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			mysqli_autocommit($link, FALSE);
			
			$i = 0;
			while($total_cc > $i){	
			
				$sprodd_id = $cc_sprodd_id[$i];
				$cc_id = $cc_iden[$i];
			
				$sql = "update SPROD_DETALLE set cc_id = '$cc_id' where sprodd_id = $sprodd_id";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				
				$i++;
			}
			
			mysqli_commit($link);
		}		
		
		
		elseif($operacion == 'COMENTARIO COTIZACION'){
			
			$sprod_comencotiz = $_POST['sprod_comencotiz'];
			$sprod_id = $_POST['sprod_id'];	
			
			if($sprod_id == "" or $sprod_comencotiz == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}

			
			$sql = "update SOLICITUD_PRODUCTOS set sprod_comencotiz = '$sprod_comencotiz' where sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			
		}			
		
		
		elseif($operacion == 'COTIZACION TERMINADA'){
			
			$sprod_id = $_POST['sprod_id'];	
			
			if($sprod_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "SELECT 1 FROM SPROD_DETALLE where sprod_id = $sprod_id and cc_id is null";	
			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){				
				$resp = array('cod'=>'error','desc'=>'Error: Hay cuentas contables sin asignar');
				salida($resp);
			}	
			
		//VALIDACION DE QUE ESTE LA COTIZACION
		/*	
			$sql = "SELECT sprodd_id FROM SPROD_DETALLE where sprod_id = $sprod_id";	
			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);			
			
			$sql = "select COTCOM_ID from COTIZ_COMPRA join SPROD_DETALLE on COTIZ_COMPRA.sprodd_id = SPROD_DETALLE.sprodd_id 
			where SPROD_DETALLE.sprod_id = $sprod_id and COTIZ_COMPRA.cotcom_provsel = 'S'";	
			$resultado = mysqli_query($link,$sql);	
			$rowcount_cotiz = mysqli_num_rows($resultado);		
			
			$faltante_cotiz = $rowcount - $rowcount_cotiz;
			
			if($faltante_cotiz > 0){
				if($faltante_cotiz == 1) $resp = array('cod'=>'error','desc'=>'Error: Existe un material/servicio sin cotización seleccionada');
				if($faltante_cotiz > 1) $resp = array('cod'=>'error','desc'=>'Error: Existen '.$faltante_cotiz.' materiales/servicios sin cotización seleccionada');
				salida($resp);				
			}
		*/	
			$sql = "update SOLICITUD_PRODUCTOS set sprod_estado = 'EN PROCESO' where sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			
		}				
		
		elseif($operacion == 'ELIMINACION ARCHIVO COTIZ'){
			
			$cotcom_id = $_POST['cotcom_id'];	
			$archivo = $_POST['archivo'];
			
			if($cotcom_id == "" or $archivo == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}	
			$ruta_archivo = '../cotizaciones/'.$archivo;
			if(file_exists($ruta_archivo)) unlink($ruta_archivo);
			
			$sql = "update COTIZ_COMPRA set
			COTCOM_ARCHIVO1 = case when COTCOM_ARCHIVO1 = '$archivo' then NULL else COTCOM_ARCHIVO1 end,
			COTCOM_ARCHIVO2 = case when COTCOM_ARCHIVO2 = '$archivo' then NULL else COTCOM_ARCHIVO2 end,
			COTCOM_ARCHIVO3 = case when COTCOM_ARCHIVO3 = '$archivo' then NULL else COTCOM_ARCHIVO3 end
			where cotcom_id = $cotcom_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			
		}			
		
		
//COMPRA	
	
		
		elseif($operacion == 'REGISTRAR COMPRA'){
			
			$sprodd_id = $_POST['sprodd_id'];
			$cotcom_proveedor = $_POST['cotcom_proveedor'];
			$cotcom_precio = $_POST['cotcom_precio'];
			$cotcom_cantidad = $_POST['cotcom_cantidad'];
			$cotcom_acordado = $_POST['cotcom_acordado'];
			$cotcom_hes = $_POST['cotcom_hes'];	
			//$cotcom_codigosap = $_POST['cotcom_codigosap'];
			$cotcom_dentrega = $_POST['cotcom_dentrega'];	
			$cotcom_hentrega = $_POST['cotcom_hentrega'];	
			$cotcom_avance = $_POST['cotcom_avance'];	
			$cotcom_tipo = $_POST['cotcom_tipo'];	
			$tipo_compra = $_POST['tipo_compra'];				
						
			if($sprodd_id == "" or $cotcom_proveedor == "" or $cotcom_precio == "" or $cotcom_cantidad == "" or $cotcom_acordado == "" or $cotcom_hes == "" /*or $cotcom_codigosap == ""*/ or $cotcom_dentrega == "" or $cotcom_hentrega == "" or $cotcom_tipo == "" or $tipo_compra == "" or ($tipo_compra == 'PRESTACIÓN SERVICIO' and $cotcom_avance == "")){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$dentrega = explode("-" , $cotcom_dentrega);
			$cotcom_dentrega = $dentrega[2].'-'.$dentrega[1].'-'.$dentrega[0];						
			$cotcom_avance = ($tipo_compra == 'PRESTACIÓN SERVICIO') ? "'$cotcom_avance'" : "NULL";
			
			
			$sql = "SELECT 1 FROM SPROD_DETALLE where sprodd_id = $sprodd_id and SPRODD_DREGSAP is null";
			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){				
				$resp = array('cod'=>'error','desc'=>'Error: Favor registrar código SAP antes de esta operación');
				salida_con_rollback($resp,$link);
			}				
			
			
			if($tipo_compra == 'COMPRA MATERIAL'){
				mysqli_autocommit($link, FALSE);
				$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos');
			//}

				$sql = "insert into COTIZ_COMPRA(sprodd_id, cotcom_proveedor, cotcom_precio, cotcom_cantidad, cotcom_acordado, cotcom_dentrega, cotcom_hentrega, cotcom_tipo, cotcom_hes, /*cotcom_codigosap,*/ cotcom_avance) values ($sprodd_id, '$cotcom_proveedor', $cotcom_precio, $cotcom_cantidad, $cotcom_acordado, '$cotcom_dentrega', '$cotcom_hentrega', '$cotcom_tipo', '$cotcom_hes',/*'$cotcom_codigosap',*/ $cotcom_avance)";				
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));	
				
				$cotcom_id = mysqli_insert_id($link);
				
				$sql = "SELECT sprod_id,prod_cod FROM SPROD_DETALLE where sprodd_id = $sprodd_id";	
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));		
				$fila = mysqli_fetch_row($resultado);
				$sprod_id = $fila[0];
				$prod_cod = $fila[1];
				//PRECIO PROMEDIO PRODUCTO
				$sql = "SELECT ROUND(AVG(C.cotcom_precio) ,0) 
				FROM COTIZ_COMPRA C
				join SPROD_DETALLE SD on C.sprodd_id = SD.sprodd_id 				
				where SD.prod_cod = '$prod_cod' AND C.COTCOM_TIPO = 'COMPRA'"  ;	
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));		
				$fila = mysqli_fetch_row($resultado);
				$cotcom_precio = $fila[0];				
				
				$sql = "UPDATE PRODUCTOS SET prod_stock = prod_stock + $cotcom_cantidad, prod_valor = $cotcom_precio WHERE prod_cod = '$prod_cod'";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				
				$sql = "update SPROD_DETALLE set SPRODD_DREGHES = '$fecha_reg' where sprodd_id = $sprodd_id";				
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
				
				mysqli_commit($link);	
				
				enviar_email_producto($sprod_id, $cotcom_id);	

			}
			else{
				mysqli_autocommit($link, FALSE);
				
				$sql = "insert into COTIZ_COMPRA(sprodd_id, cotcom_proveedor, cotcom_precio, cotcom_cantidad, cotcom_acordado, cotcom_dentrega, cotcom_hentrega, cotcom_tipo, cotcom_hes,/*cotcom_codigosap,*/ cotcom_avance) values ($sprodd_id, '$cotcom_proveedor', $cotcom_precio, $cotcom_cantidad, $cotcom_acordado, '$cotcom_dentrega', '$cotcom_hentrega', '$cotcom_tipo', '$cotcom_hes',/*'$cotcom_codigosap',*/ $cotcom_avance)";				
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));		
				
				$sql = "update SPROD_DETALLE set SPRODD_DREGHES = '$fecha_reg' where sprodd_id = $sprodd_id";				
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));

				mysqli_commit($link);
			}
			
		}			
		

		elseif($operacion == 'MODIFICAR COMPRA'){
			
			$cotcom_id = $_POST['cotcom_id'];
			$sprodd_id = $_POST['sprodd_id'];
			$cotcom_proveedor = $_POST['cotcom_proveedor'];
			$cotcom_precio = $_POST['cotcom_precio'];
			$cotcom_cantidad = $_POST['cotcom_cantidad'];
			$cotcom_acordado = $_POST['cotcom_acordado'];
			$cotcom_hes = $_POST['cotcom_hes'];		
			//$cotcom_codigosap = $_POST['cotcom_codigosap'];
			$cotcom_dentrega = $_POST['cotcom_dentrega'];	
			$cotcom_hentrega = $_POST['cotcom_hentrega'];	
			$cotcom_avance = $_POST['cotcom_avance'];	
			$cotcom_tipo = $_POST['cotcom_tipo'];	
			$tipo_compra = $_POST['tipo_compra'];		
			
			if($cotcom_id == "" or $cotcom_proveedor == "" or $cotcom_precio == "" or $cotcom_cantidad == "" or $cotcom_acordado == "" or $cotcom_hes == "" /*or $cotcom_codigosap == ""*/ or $cotcom_dentrega == "" or $cotcom_hentrega == "" or $cotcom_tipo == "" or $tipo_compra == "" or ($tipo_compra == 'PRESTACIÓN SERVICIO' and $cotcom_avance == "")){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}	
			
			$dentrega = explode("-" , $cotcom_dentrega);
			$cotcom_dentrega = $dentrega[2].'-'.$dentrega[1].'-'.$dentrega[0];			
			$cotcom_avance = ($tipo_compra == 'PRESTACIÓN SERVICIO') ? "'$cotcom_avance'" : "NULL";
			
			$cantidad_reg = 0;
			if($tipo_compra == 'COMPRA MATERIAL'){
				mysqli_autocommit($link, FALSE);
				$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos');			
				$sql = "select cotcom_cantidad from COTIZ_COMPRA where cotcom_id = $cotcom_id";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));	
				$fila = mysqli_fetch_row($resultado);
				$cantidad_reg = $fila[0];					
			//}
			
				$sql = "update COTIZ_COMPRA set cotcom_proveedor = '$cotcom_proveedor' , cotcom_precio =$cotcom_precio , cotcom_cantidad = $cotcom_cantidad, cotcom_acordado = $cotcom_acordado, cotcom_hes = '$cotcom_hes',/*cotcom_codigosap = '$cotcom_codigosap',*/cotcom_dentrega = '$cotcom_dentrega',cotcom_hentrega = '$cotcom_hentrega',cotcom_avance = '$cotcom_avance' where cotcom_id = $cotcom_id";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));	
				
				$sql = "SELECT prod_cod FROM SPROD_DETALLE where sprodd_id = $sprodd_id";	
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));		
				$fila = mysqli_fetch_row($resultado);
				$prod_cod = $fila[0];
				//PRECIO PROMEDIO PRODUCTO
				$sql = "SELECT ROUND(AVG(C.cotcom_precio) ,0) 
				FROM COTIZ_COMPRA C
				join SPROD_DETALLE SD on C.sprodd_id = SD.sprodd_id 				
				where SD.prod_cod = '$prod_cod' AND C.COTCOM_TIPO = 'COMPRA'";	
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));		
				$fila = mysqli_fetch_row($resultado);
				$cotcom_precio = $fila[0];								   
				$sql = "UPDATE PRODUCTOS SET prod_stock = prod_stock + $cotcom_cantidad - $cantidad_reg, prod_valor = $cotcom_precio WHERE prod_cod = '$prod_cod'";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				mysqli_commit($link);				
			
			
			/*
			if($tipo_compra == 'COMPRA MATERIAL'){
				$sql = "UPDATE PRODUCTOS join SPROD_DETALLE on PRODUCTOS.prod_cod = SPROD_DETALLE.prod_cod join COTIZ_COMPRA on COTIZ_COMPRA.sprodd_id = SPROD_DETALLE.sprodd_id 
				SET 
					prod_stock = prod_stock + cotcom_cantidad - $cantidad_reg, prod_valor = cotcom_precio
				WHERE
					COTIZ_COMPRA.cotcom_id = $cotcom_id";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				mysqli_commit($link);	*/			
			}
			else{
				$sql = "update COTIZ_COMPRA set cotcom_proveedor = '$cotcom_proveedor' , cotcom_precio =$cotcom_precio , cotcom_cantidad = $cotcom_cantidad, cotcom_acordado = $cotcom_acordado, cotcom_hes = '$cotcom_hes',/*cotcom_codigosap = '$cotcom_codigosap',*/cotcom_dentrega = '$cotcom_dentrega',cotcom_hentrega = '$cotcom_hentrega',cotcom_avance = '$cotcom_avance' where cotcom_id = $cotcom_id";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));					
			}
			
		}	
		
		elseif($operacion == 'ELIMINAR COMPRA'){
			
			$cotcom_id = $_POST['cotcom_id'];	
			$tipo_compra = $_POST['tipo_compra'];
			
			if($cotcom_id == "" or $tipo_compra == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}	
			
			$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos');
			
			$cantidad_reg = 0;
			if($tipo_compra == 'COMPRA MATERIAL'){
				mysqli_autocommit($link, FALSE);		
				$sql = "select cotcom_cantidad, prod_cod from COTIZ_COMPRA join SPROD_DETALLE on COTIZ_COMPRA.sprodd_id = SPROD_DETALLE.sprodd_id where cotcom_id = $cotcom_id";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));	
				$fila = mysqli_fetch_row($resultado);
				$cantidad_reg = $fila[0];
				$prod_cod = $fila[1];

				//PRECIO PROMEDIO PRODUCTO
				$sql = "SELECT ROUND(AVG(C.cotcom_precio) ,0) 
				FROM COTIZ_COMPRA C
				join SPROD_DETALLE SD on C.sprodd_id = SD.sprodd_id 				
				where SD.prod_cod = '$prod_cod' AND C.COTCOM_TIPO = 'COMPRA'";	
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));		
				$fila = mysqli_fetch_row($resultado);
				$cotcom_precio = $fila[0];									   
				$sql = "UPDATE PRODUCTOS 
				SET 
					prod_stock = prod_stock - $cantidad_reg, prod_valor = $cotcom_precio
				WHERE
					prod_cod = '$prod_cod'";

				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
			}
			
			$sql = "SELECT sprodd_id 
			from COTIZ_COMPRA where cotcom_id = $cotcom_id";	
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));		
			$fila1 = mysqli_fetch_row($resultado);
			$sprodd_id = $fila1[0];					
			
			$sql = "delete from COTIZ_COMPRA where cotcom_id = $cotcom_id";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
			
			$sql = "update SPROD_DETALLE set sprodd_dreghes = NULL where sprodd_id = $sprodd_id";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				

			mysqli_commit($link);	
			
		}
		
		
		elseif($operacion == 'UPDATE ESTADO Y CC'){
			
			$psprodr_estado = $_POST['sprodr_estado'];
			$cc_sprodd_id = $_POST['cc_sprodd_id'];
			$pprodd_codigosap = $_POST['sprodd_codigosap'];
			$cc_iden = $_POST['cc_id'];
			$total_cc = count($_POST["cc_id"]);	
			
			if($total_cc == 0){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			mysqli_autocommit($link, FALSE);
			
			$i = 0;
			while($total_cc > $i){	
			
				$sprodd_id = $cc_sprodd_id[$i];
				$sprodr_estado = $psprodr_estado[$i];
				$sprodd_codigosap = $pprodd_codigosap[$i];
				$cc_id = $cc_iden[$i];
				
				if($sprodd_codigosap <> ''){
					$sql = "SELECT 1 FROM SPROD_DETALLE where sprodd_id = $sprodd_id and SPRODD_DSOLICSAP is null";
					$resultado = mysqli_query($link,$sql);	
					$rowcount = mysqli_num_rows($resultado);

					if($rowcount > 0){				
						$resp = array('cod'=>'error','desc'=>'Error: No existe check SAP donde se desea registrar código SAP');
						salida_con_rollback($resp,$link);
					}		
					
					//Si el código sap es distinto al que está registrado y no posee registro de fecha liberación 
					
					//$sql = "SELECT 1 FROM SPROD_DETALLE where sprodd_id = $sprodd_id and sprodd_codigosap <> '$sprodd_codigosap' and sprodd_dregsap is null";
					
					$sql = "SELECT 1 FROM SPROD_DETALLE where sprodd_id = $sprodd_id and sprodd_dregsap is null";
					$resultado = mysqli_query($link,$sql);	
					$rowcount = mysqli_num_rows($resultado);
					if($rowcount > 0){
						$sql = "update SPROD_DETALLE set sprodd_dregsap = '$fecha_reg' where sprodd_id = $sprodd_id";
						$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));					
					}				
					
				}else{
					$sql = "update SPROD_DETALLE set sprodd_dregsap = NULL where sprodd_id = $sprodd_id";
					$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));					
				}
			
				$sql = "update SPROD_DETALLE set cc_id = '$cc_id', sprodr_estado = '$sprodr_estado', sprodd_codigosap = '$sprodd_codigosap' where sprodd_id = $sprodd_id";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				
				$i++;
			}
			
			mysqli_commit($link);
		}		
		
		
		elseif($operacion == 'COMENTARIO COMPRA'){
			
			//$psprod_codigosap = $_POST['sprod_codigosap'];
			$psprod_comencompra = $_POST['sprod_comencompra'];
			$sprod_id = $_POST['sprod_id'];	
			
			if($sprod_id == "" /*or $psprod_codigosap == ""*/ or $psprod_comencompra == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}

			
			$sql = "update SOLICITUD_PRODUCTOS set sprod_comencompra = '$psprod_comencompra' where sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			
		}			
		
		
		elseif($operacion == 'COMPRA TERMINADA'){
			
			$sprod_id = $_POST['sprod_id'];	
			$tipo_compra = $_POST['tipo_compra'];
			
			if($sprod_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "SELECT 1 FROM SOLICITUD_PRODUCTOS where sprod_id = $sprod_id and (sprod_comencompra is null or sprod_comencompra = '')";	
			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){				
				$resp = array('cod'=>'error','desc'=>'Error: Registrar Comentario de compra');
				salida($resp);
			}				
			
			$sql = "SELECT 1 FROM SPROD_DETALLE where sprod_id = $sprod_id and (cc_id is null or sprodr_estado is null) ";	
			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){				
				$resp = array('cod'=>'error','desc'=>'Error: Seleccionar estado y cuenta contable por cada Material/Servicio');
				salida($resp);
			}	
			
			if($tipo_compra == 'COMPRA MATERIAL'){
			
				mysqli_autocommit($link, FALSE);			
				$resp = array('cod'=>'error','desc'=>'Error de Base de Datos');		
				
				$sql = "update SOLICITUD_PRODUCTOS set sprod_estado = 'COMPRA TERMINADA' where sprod_id = $sprod_id";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));		
				
				//INSERTAR COMO SOLICITUD DE MATERIAL				
				$per_agno = date('Y');
				$sem_num = date('W');
				$sprod_dia = date('Ymd'); 
				$sprod_tipodest = 'U';				

				$sql = "SELECT usr_id_solic,UNDVIV_ID FROM SOLICITUD_PRODUCTOS where sprod_id = $sprod_id";	
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));		
				$fila = mysqli_fetch_row($resultado);
				$usr_id_solic = $fila[0];
				$UNDVIV_ID = $fila[1];
				$usr_id_dest = $usr_id_solic;
			
				$sql = "insert into SOLICITUD_PRODUCTOS(usr_id_solic, per_agno, sem_num, sprod_dia, sprod_diasystem, UNDVIV_ID, sprod_tipodest, usr_id_dest, oper_rut_dest, sprod_estado, sprod_tiposol, sprod_motivo) 
				values ($usr_id_solic, $per_agno, $sem_num,'$sprod_dia', '$fecha_reg', $UNDVIV_ID,'$sprod_tipodest',$usr_id_dest,NULL,'PENDIENTE', 'SM', 'GENERADO POR SOLICITUD DE COMPRA')";		
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));	
				
				$sprod_id_new = mysqli_insert_id($link);
				
				$sql = "insert into SPROD_DETALLE (sprod_id,prod_cod,sprodd_cant) SELECT $sprod_id_new,prod_cod,sprodd_cant FROM SPROD_DETALLE where sprod_id = $sprod_id";			
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				
				
				
			/*
				$sql = "insert into SPROD_DETALLE(sprod_id, prod_cod, sprodd_cant) 
				values ($sprod_id_new,'$prod_cod',$sprodd_cant)";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
			*/	
			//ENVIAR EMAIL
				enviar_email_compra_terminada($sprod_id,$sprod_id_new);
				
				$sprod_id = $sprod_id_new;
			
				mysqli_commit($link);
			}else{
				$sql = "update SOLICITUD_PRODUCTOS set sprod_estado = 'COMPRA TERMINADA' where sprod_id = $sprod_id";
				$resultado = mysqli_query($link,$sql)or die(salida($resp));				
			}
			
							
		}			
		
		
	
// COMPRA FINALIZADA

		elseif($operacion == 'CAMBIAR A EN PROCESO'){
			
			$sprod_id = $_POST['sprod_id'];	
			
			if($sprod_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "update SOLICITUD_PRODUCTOS set sprod_estado = 'EN PROCESO' where sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			
		}


		elseif($operacion == 'ELIM SOL_MATERIALoSERVICIO_ALL'){
		
			$sprod_id = $_POST['sprod_id'];
		
			mysqli_autocommit($link, FALSE);			
			$resp = array('cod'=>'error','desc'=>'Error de Base de Datos');		
			
			$sql = "delete C
			from COTIZ_COMPRA C
			join SPROD_DETALLE SD on C.sprodd_id = SD.sprodd_id				
			where SD.sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
			
			$sql = "delete from SPROD_DETALLE where sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
			
			$sql = "delete from SOLICITUD_PRODUCTOS where sprod_id = $sprod_id";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
			
			mysqli_commit($link);	
		
		}
		
		
		elseif($operacion == 'ELIM SOL_MATERIALoSERVICIO'){
		
		
		
			mysqli_autocommit($link, FALSE);
			$total_prod= count($_POST["sprodd_id"]);
			$i = 0;
			while($total_prod > $i){
				
				$sprodd_id = $_POST['sprodd_id'][$i];	

				$sql = "delete from COTIZ_COMPRA where sprodd_id = $sprodd_id";	
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				
				$sql = "delete from SPROD_DETALLE where sprodd_id = $sprodd_id";
				$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
				
				$i++;
			}		
			mysqli_commit($link);
		}
		
		
		
		
		elseif($operacion == 'REGISTRAR FECHA FIN COTIZ'){

			$sprodd_id= $_POST["sprodd_id"];
			
			if($sprodd_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}

			$sql = "SELECT 1 FROM COTIZ_COMPRA where sprodd_id = $sprodd_id and cotcom_provsel = 'S'";
			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount == 0){				
				$resp = array('cod'=>'error','desc'=>'No se puede chequear sin cotización seleccionada','sprodd_id'=>$sprodd_id,'cot'=>'');
				salida($resp);
			}				

			$sql = "update SPROD_DETALLE set SPRODD_DFINCOTIZ = '$fecha_reg' where sprodd_id = $sprodd_id";				
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			
		}		
		
		
		elseif($operacion == 'BORRAR FECHA FIN COTIZ'){

			$sprodd_id= $_POST["sprodd_id"];
			
			if($sprodd_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}		

			$sql = "SELECT 1 FROM SPROD_DETALLE where sprodd_id = $sprodd_id and SPRODD_DSOLICSAP is not NULL";
			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){				
				$resp = array('cod'=>'error','desc'=>'No se puede deschequear si existe check en SAP','sprodd_id'=>$sprodd_id,'cotysap'=>'');
				salida($resp);
			}			

			$sql = "update SPROD_DETALLE set SPRODD_DFINCOTIZ = NULL, SPRODD_DSOLICSAP = NULL where sprodd_id = $sprodd_id";				
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
		}		
		
		
		
		elseif($operacion == 'REGISTRAR FECHA SOLIC SAP'){

			$sprodd_id= $_POST["sprodd_id"];
			
			if($sprodd_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}		

			$sql = "SELECT 1 FROM SPROD_DETALLE where sprodd_id = $sprodd_id and SPRODD_DFINCOTIZ is null";
			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){				
				$resp = array('cod'=>'error','desc'=>'No se puede chequear sin check a fecha cotización','sprodd_id'=>$sprodd_id,'sap'=>'');
				salida($resp);
			}			

			$sql = "update SPROD_DETALLE set SPRODD_DSOLICSAP = '$fecha_reg' where sprodd_id = $sprodd_id";				
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			
		}		
		
		
		elseif($operacion == 'BORRAR FECHA SOLIC SAP'){

			$sprodd_id= $_POST["sprodd_id"];
			
			if($sprodd_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}	

			$sql = "SELECT 1 FROM SPROD_DETALLE where sprodd_id = $sprodd_id and SPRODD_DREGSAP is not NULL";
			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){				
				$resp = array('cod'=>'error','desc'=>'No se puede deschequear si existe registro SAP','sprodd_id'=>$sprodd_id,'sapreg'=>'');
				salida($resp);
			}		

			$sql = "update SPROD_DETALLE set SPRODD_DSOLICSAP = NULL where sprodd_id = $sprodd_id";				
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
		}		

		$resp = array('cod'=>'ok','operacion'=>$operacion,'sprod_id'=>$sprod_id);
	}
	
	
	
	
	
	
	
	
	
	

	
	//Retorna respuesta
	echo json_encode($resp);	

?>