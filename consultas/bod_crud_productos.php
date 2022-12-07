<?php 

	include('coneccion.php');
	//include('funciones_comunes.php');
	
	if(!isset($load_prod)){
		include('funciones_comunes.php');	
	}	

	if(isset($_GET['data'])){
	
		$sql = "select p.CATPROD_ID, PROD_COD, PROD_NOMBRE, c.CATPROD_NOMBRE, PROD_UNIDAD, PROD_STOCKMIN, PROD_VALOR, SAP_COD, SAP_NOMBRE from PRODUCTOS p
		left join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id";	
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
	
	elseif(isset($_POST['catprod_id']) and !isset($_POST['operacion'])){
		$catprod_id = $_POST['catprod_id'];
		
		$sql = "SELECT PROD_COD, PROD_NOMBRE
		FROM PRODUCTOS WHERE catprod_id = $catprod_id
				ORDER BY PROD_NOMBRE ASC";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}
	
	
	elseif(isset($_POST['carga_prod_id'])){
		$prod_id = $_POST['prod_cod'];
		
		$sql = "SELECT SAP_COD FROM PRODUCTOS WHERE prod_cod = '$prod_id' limit 1";	
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$sap_cod = '';
		$rowcount = mysqli_num_rows($resultado);

		if($rowcount > 0){		
			$fila = mysqli_fetch_row($resultado);
			$sap_cod = $fila[0];
		}
		$resp = array('sap_cod'=>$sap_cod);
		salida($resp);
	}	
	
	elseif(isset($_POST['carga_sap_id'])){
		$sap_cod = $_POST['sap_cod'];
		
		$sql = "SELECT PROD_COD FROM PRODUCTOS WHERE sap_cod = '$sap_cod' limit 1";	
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$prod_cod = '';
		$rowcount = mysqli_num_rows($resultado);

		if($rowcount > 0){		
			$fila = mysqli_fetch_row($resultado);
			$prod_cod = $fila[0];
		}
		$resp = array('prod_cod'=>$prod_cod);
		salida($resp);
	}	
	
	
	
	elseif(isset($load_prod)){
	
		$sql = "select prod_cod, prod_nombre from PRODUCTOS /*where sap_cod <> '' and sap_cod is not null*/";			
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}

		$load_productos = json_encode($data);
		
		$sql = "select sap_cod, sap_nombre from PRODUCTOS where sap_cod <> '' and sap_cod is not null";			
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data2 = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data2[] = $rows;
		}

		$load_sap = json_encode($data2);		
	}	
	
	
	
	

	elseif(isset($_POST['id_cat_stock']) and !isset($_POST['operacion'])){
		$catprod_id = $_POST['id_cat_stock'];
		
		$sql = "SELECT PROD_COD, CONCAT(PROD_NOMBRE,' (STOCK: ', IFNULL(PROD_STOCK,' SIN ASIGNAR'), ')') PROD_NOMBRE
				FROM PRODUCTOS WHERE catprod_id = $catprod_id
				ORDER BY PROD_NOMBRE ASC";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}	
	
	elseif(isset($_POST['cotizacion'])){
		$sprod_id = $_POST['sprod_id'];
		$sprod_tipocompra = $_POST['tipo_compra'];
//SUBSTRING(p.prod_nombre,1,40)
		if($sprod_tipocompra == 'COMPRA MATERIAL'){
			$sql = "SELECT  sd.SPRODD_ID, p.PROD_COD, SUBSTRING(p.PROD_NOMBRE,1,40) PROD_NOMBRE, sd.SPRODD_CANT, sd.CC_ID, 
			(CASE WHEN c.COTCOM_PROVEEDOR is NULL THEN '' ELSE SUBSTRING(c.COTCOM_PROVEEDOR,1,40) END )COTCOM_PROVEEDOR, IFNULL(c.COTCOM_ACORDADO,'')COTCOM_ACORDADO,
			(CASE WHEN sd.SPRODD_DFINCOTIZ is NULL THEN 0 ELSE 1 END) CHECK_COT,
			(CASE WHEN sd.SPRODD_DSOLICSAP is NULL THEN 0 ELSE 1 END) CHECK_SAP
			from PRODUCTOS p
			join SPROD_DETALLE sd on sd.prod_cod = p.prod_cod
			left join COTIZ_COMPRA c on sd.sprodd_id = c.sprodd_id and c.cotcom_provsel = 'S'
			WHERE sd.sprod_id = $sprod_id
			ORDER BY p.PROD_NOMBRE ASC";	
		}
		if($sprod_tipocompra == 'PRESTACIÓN SERVICIO'){
			$sql = "SELECT  sd.SPRODD_ID, sd.SPRODD_CANT, sd.CC_ID, (CASE WHEN SPRODD_SERVICIO is NULL THEN '' ELSE SUBSTRING(SPRODD_SERVICIO,1,40) END )SPRODD_SERVICIO,
			(CASE WHEN c.COTCOM_PROVEEDOR is NULL THEN '' ELSE SUBSTRING(c.COTCOM_PROVEEDOR,1,40) END )COTCOM_PROVEEDOR, IFNULL(c.COTCOM_ACORDADO,'')COTCOM_ACORDADO,
			(CASE WHEN sd.SPRODD_DFINCOTIZ is NULL THEN 0 ELSE 1 END) CHECK_COT,
			(CASE WHEN sd.SPRODD_DSOLICSAP is NULL THEN 0 ELSE 1 END) CHECK_SAP			
			from SPROD_DETALLE sd
			left join COTIZ_COMPRA c on sd.sprodd_id = c.sprodd_id and c.cotcom_provsel = 'S'
			WHERE sd.sprod_id = $sprod_id
			ORDER BY SPRODD_SERVICIO ASC";	
		}		

		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}		
	
	
	
	
	elseif(isset($_POST['compra'])){
		$sprod_id = $_POST['sprod_id'];
		$sprod_tipocompra = $_POST['tipo_compra'];
		
//SUBSTRING(p.prod_nombre,1,40)
		if($sprod_tipocompra == 'COMPRA MATERIAL'){
			$sql = "SELECT  sd.SPRODD_ID,IFNULL(sd.SPRODR_ESTADO,'') SPRODR_ESTADO, p.PROD_COD, SUBSTRING(p.PROD_NOMBRE,1,40) PROD_NOMBRE, PROD_NOMBRE PROD_NOMBRE_FILL, sd.SPRODD_CANT, sd.CC_ID, 
			(CASE WHEN c.COTCOM_PROVEEDOR is NULL THEN '' ELSE SUBSTRING(c.COTCOM_PROVEEDOR,1,40) END )COTCOM_PROVEEDOR, IFNULL(c.COTCOM_PROVEEDOR,'') COTCOM_PROVEEDOR_FILL,
			c.COTCOM_PRECIO, c.COTCOM_CANTIDAD COTCOM_CANTIDAD_PROV, (c.COTCOM_PRECIO * c.COTCOM_CANTIDAD) COTCOM_TOTAL, c.COTCOM_ACORDADO COTCOM_ACORDADO_PROV, IFNULL(cc.CC_NOMBRE,'') CC_NOMBRE,
			IFNULL(sd.SPRODD_CODIGOSAP,'')SPRODD_CODIGOSAP,
			(CASE WHEN sd.SPRODD_DFINCOTIZ is NULL THEN 0 ELSE 1 END) CHECK_COT,
			(CASE WHEN sd.SPRODD_DSOLICSAP is NULL THEN 0 ELSE 1 END) CHECK_SAP			
			from PRODUCTOS p
			join SPROD_DETALLE sd on sd.prod_cod = p.prod_cod
			left join COTIZ_COMPRA c on sd.sprodd_id = c.sprodd_id and c.cotcom_provsel = 'S'
			left join CUENTA_CONTABLE cc on cc.CC_ID = sd.CC_ID
			WHERE sd.sprod_id = $sprod_id
			ORDER BY p.PROD_NOMBRE ASC";	
			
			$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$data = array();
			
			while( $rows = mysqli_fetch_assoc($resultset) ) {
			
				$sql = "SELECT IFNULL(SUM(COTCOM_ACORDADO),0)COTCOM_ACORDADO,IFNULL(SUM(COTCOM_CANTIDAD),0)COTCOM_CANTIDAD FROM COTIZ_COMPRA WHERE SPRODD_ID = '$rows[SPRODD_ID]' AND COTCOM_TIPO='COMPRA'";
				$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
				
				$COTCOM_ACORDADO = 0 ;$COTCOM_CANTIDAD = 0 ;
				while( $rows2 = mysqli_fetch_assoc($resultado) ) {
					$COTCOM_ACORDADO = $rows2[COTCOM_ACORDADO];
					$COTCOM_CANTIDAD = $rows2[COTCOM_CANTIDAD];
				}
			
				$data[] = 
				Array
				(
					'COTCOM_ACORDADO' => $COTCOM_ACORDADO,
					'COTCOM_CANTIDAD' => $COTCOM_CANTIDAD,
					'SPRODD_ID' => $rows[SPRODD_ID],
					'SPRODR_ESTADO' => $rows[SPRODR_ESTADO],
					'PROD_COD' => $rows[PROD_COD],
					'PROD_NOMBRE' => $rows[PROD_NOMBRE],
					'PROD_NOMBRE_FILL' => $rows[PROD_NOMBRE_FILL],
					'SPRODD_CANT' => $rows[SPRODD_CANT],
					'SPRODD_CODIGOSAP' => $rows[SPRODD_CODIGOSAP],
					'CC_ID' => $rows[CC_ID],
					'COTCOM_PROVEEDOR_FILL' => $rows[COTCOM_PROVEEDOR_FILL],
					'COTCOM_PRECIO' => $rows[COTCOM_PRECIO],
					'COTCOM_CANTIDAD_PROV' => $rows[COTCOM_CANTIDAD_PROV],
					'COTCOM_TOTAL' => $rows[COTCOM_TOTAL],
					'COTCOM_ACORDADO_PROV' => $rows[COTCOM_ACORDADO_PROV],					
					'COTCOM_PROVEEDOR' => $rows[COTCOM_PROVEEDOR],
					'CC_NOMBRE' => $rows[CC_NOMBRE],
					'CHECK_COT' => $rows[CHECK_COT],
					'CHECK_SAP' => $rows[CHECK_SAP]					
				);					
			}			
			
		}
		if($sprod_tipocompra == 'PRESTACIÓN SERVICIO'){
			$sql = "SELECT  sd.SPRODD_ID,IFNULL(sd.SPRODR_ESTADO,'') SPRODR_ESTADO, sd.SPRODD_CANT, sd.CC_ID, (CASE WHEN SPRODD_SERVICIO is NULL THEN '' ELSE SUBSTRING(SPRODD_SERVICIO,1,40) END )SPRODD_SERVICIO,
			SPRODD_SERVICIO SPRODD_SERVICIO_FILL, (CASE WHEN c.COTCOM_PROVEEDOR is NULL THEN '' ELSE SUBSTRING(c.COTCOM_PROVEEDOR,1,40) END )COTCOM_PROVEEDOR, IFNULL(c.COTCOM_PROVEEDOR,'') COTCOM_PROVEEDOR_FILL,
			c.COTCOM_PRECIO, c.COTCOM_CANTIDAD COTCOM_CANTIDAD_PROV, c.COTCOM_AVANCE, c.COTCOM_ACORDADO COTCOM_ACORDADO_PROV, IFNULL(cc.CC_NOMBRE,'') CC_NOMBRE,IFNULL(sd.SPRODD_CODIGOSAP,'')SPRODD_CODIGOSAP,
			(CASE WHEN sd.SPRODD_DFINCOTIZ is NULL THEN 0 ELSE 1 END) CHECK_COT,
			(CASE WHEN sd.SPRODD_DSOLICSAP is NULL THEN 0 ELSE 1 END) CHECK_SAP				
			from SPROD_DETALLE sd
			left join COTIZ_COMPRA c on sd.sprodd_id = c.sprodd_id and c.cotcom_provsel = 'S'
			left join CUENTA_CONTABLE cc on cc.CC_ID = sd.CC_ID
			WHERE sd.sprod_id = $sprod_id
			ORDER BY SPRODD_SERVICIO ASC";	
			
			$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$data = array();
			
			while( $rows = mysqli_fetch_assoc($resultset) ) {
			
				$sql = "SELECT IFNULL(SUM(COTCOM_ACORDADO),0)COTCOM_ACORDADO,IFNULL(SUM(COTCOM_CANTIDAD),0)COTCOM_CANTIDAD FROM COTIZ_COMPRA WHERE SPRODD_ID = '$rows[SPRODD_ID]' AND COTCOM_TIPO='COMPRA'";
				$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
				
				$COTCOM_ACORDADO = 0 ;$COTCOM_CANTIDAD = 0 ;
				while( $rows2 = mysqli_fetch_assoc($resultado) ) {
					$COTCOM_ACORDADO = $rows2[COTCOM_ACORDADO];
					$COTCOM_CANTIDAD = $rows2[COTCOM_CANTIDAD];
				}
			
				$data[] = 
				Array
				(
					'COTCOM_ACORDADO' => $COTCOM_ACORDADO,
					'COTCOM_CANTIDAD' => $COTCOM_CANTIDAD,
					'SPRODD_ID' => $rows[SPRODD_ID],
					'SPRODR_ESTADO' => $rows[SPRODR_ESTADO],
					'SPRODD_SERVICIO' => $rows[SPRODD_SERVICIO],
					'SPRODD_SERVICIO_FILL' => $rows[SPRODD_SERVICIO_FILL],
					'SPRODD_CANT' => $rows[SPRODD_CANT],
					'SPRODD_CODIGOSAP' => $rows[SPRODD_CODIGOSAP],
					'CC_ID' => $rows[CC_ID],					
					'COTCOM_PROVEEDOR_FILL' => $rows[COTCOM_PROVEEDOR_FILL],
					'COTCOM_PRECIO' => $rows[COTCOM_PRECIO],
					'COTCOM_CANTIDAD_PROV' => $rows[COTCOM_CANTIDAD_PROV],
					'COTCOM_AVANCE' => $rows[COTCOM_AVANCE],
					'COTCOM_ACORDADO_PROV' => $rows[COTCOM_ACORDADO_PROV],					
					'COTCOM_PROVEEDOR' => $rows[COTCOM_PROVEEDOR],
					'CC_NOMBRE' => $rows[CC_NOMBRE],
					'CHECK_COT' => $rows[CHECK_COT],
					'CHECK_SAP' => $rows[CHECK_SAP]
				);					
			}			
			
		}		

		salida($data);
	}	


	
	elseif(isset($_POST['sprod_id']) and !isset($_POST['operacion'])){
		$sprod_id = $_POST['sprod_id'];
		
		$sql = "SELECT c.CATPROD_NOMBRE, p.PROD_COD, p.PROD_NOMBRE, IFNULL(p.PROD_STOCK,'SIN ASIGNAR') PROD_STOCK,/*  p.PROD_NOMBRE,*/ sd.SPRODD_CANT
		from PRODUCTOS p
		LEFT join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id 
		join SPROD_DETALLE sd on sd.prod_cod = p.prod_cod
		WHERE sd.sprod_id = $sprod_id
		ORDER BY c.catprod_nombre,p.PROD_NOMBRE ASC";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}	
	
	
	elseif(isset($_POST['asprod_id']) and !isset($_POST['operacion'])){
		$sprod_id = $_POST['asprod_id'];
		
		$sql = "SELECT c.CATPROD_NOMBRE, p.PROD_COD, p.PROD_NOMBRE, IFNULL(p.PROD_STOCK,'SIN ASIGNAR') PROD_STOCK, /* p.PROD_NOMBRE, */sd.SPRODD_CANT, sd.SPRODR_ESTADO, sd.SPRODR_CANT
		from PRODUCTOS p
		LEFT join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id 
		join SPROD_DETALLE sd on sd.prod_cod = p.prod_cod
		WHERE sd.sprod_id = $sprod_id
		ORDER BY c.catprod_nombre,p.PROD_NOMBRE ASC";	
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		while( $rows = mysqli_fetch_assoc($resultset) ) {
			$data[] = $rows;
		}
		salida($data);
	}		
	
	
	else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$prod_cod = $_POST['prod_cod'];
			$prod_nombre = $_POST['prod_nombre'];
			$catprod_id = $_POST['catprod_id'];
			$prod_stockmin = $_POST['prod_stockmin'];
			$prod_unidad = $_POST['prod_unidad'];
			$prod_valor = $_POST['prod_valor'];
		
			if($prod_cod == "" or $prod_nombre == "" /*or $catprod_id == "" or $prod_valor == ""*/ ){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			//if($prod_stockmin == '') $prod_stockmin = 0;
			
			$sql = "SELECT prod_nombre FROM PRODUCTOS where prod_cod = '$prod_cod'";			

			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){
			
				$fila = mysqli_fetch_row($resultado);
				$producto = $fila[0];		
				$resp = array('cod'=>'error','desc'=>'Este código ya está registrado para el producto '.$producto);
				salida($resp);
			}		

			$sql = "SELECT sap_nombre FROM PRODUCTOS where sap_cod = '$prod_cod'";			

			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			if($rowcount > 0){
			
				$fila = mysqli_fetch_row($resultado);
				$producto = $fila[0];		
				$resp = array('cod'=>'error','desc'=>'Este código ya está registrado para el producto '.$producto);
				salida($resp);
			}
			
			
			/*
			$sql = "insert into PRODUCTOS(prod_cod, catprod_id, prod_nombre, prod_stockmin, prod_unidad, prod_valor, prod_stock, sap_cod, sap_nombre) 
			values ('$prod_cod',$catprod_id,'$prod_nombre',$prod_stockmin,'$prod_unidad',$prod_valor, 0, '$prod_cod', '$prod_nombre')";*/
			
			$sql = "insert into PRODUCTOS(prod_cod, prod_nombre, sap_cod, sap_nombre) 
			values ('$prod_cod','$prod_nombre','$prod_cod','$prod_nombre')";		
		}
		
		elseif($operacion == 'UPDATE'){
			
			$prod_cod = $_POST['prod_cod'];
			$h_prod_cod = $_POST['h_prod_cod'];
			$prod_nombre = $_POST['prod_nombre'];
			$catprod_id = $_POST['catprod_id'];
			$prod_stockmin = $_POST['prod_stockmin'];
			$prod_unidad = $_POST['prod_unidad'];
			$prod_valor = $_POST['prod_valor'];
			
			if($prod_cod == "" or $prod_nombre == "" or /*$catprod_id == "" or */$h_prod_cod == "" /*or $prod_valor == ""*/ ){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			if($prod_cod <> $h_prod_cod){
				$sql = "SELECT prod_nombre FROM PRODUCTOS where prod_cod = '$prod_cod'";		

				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount > 0){
				
					$fila = mysqli_fetch_row($resultado);
					$producto = $fila[0];		
					$resp = array('cod'=>'error','desc'=>'Este código ya está registrado para el producto '.$producto);
					salida($resp);
				}

				$sql = "SELECT sap_nombre FROM PRODUCTOS where sap_cod = '$prod_cod'";			

				$resultado = mysqli_query($link,$sql);	
				$rowcount = mysqli_num_rows($resultado);

				if($rowcount > 0){
				
					$fila = mysqli_fetch_row($resultado);
					$producto = $fila[0];		
					$resp = array('cod'=>'error','desc'=>'Este código ya está registrado para el producto '.$producto);
					salida($resp);
				}
				
			}
			/*
			$sql = "update PRODUCTOS set prod_cod = '$prod_cod',catprod_id = $catprod_id,prod_nombre = '$prod_nombre',prod_stockmin = $prod_stockmin,prod_unidad = '$prod_unidad',prod_valor = $prod_valor,sap_cod = '$prod_cod',sap_nombre = '$prod_nombre'
			where prod_cod = '$h_prod_cod'";
			*/
			$sql = "update PRODUCTOS set sap_cod = '$prod_cod',sap_nombre = '$prod_nombre'
			where prod_cod = '$h_prod_cod'";			
		}	
		
		elseif($operacion == 'DELETE'){
			
			$h_prod_cod = $_POST['h_prod_cod'];
			
			if($h_prod_cod == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from PRODUCTOS where prod_cod = '$h_prod_cod'";
		}	

		
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida($resp));	

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}

	if(!isset($load_prod)){
		//include('funciones_comunes.php');
		//Retorna respuesta
		echo json_encode($resp);	
	}
	
	//Retorna respuesta
	//echo json_encode($resp);	

?>