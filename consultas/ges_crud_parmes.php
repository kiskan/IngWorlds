<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	session_start();
	
	
	if(isset($_GET['per_agno'])){

		$sql = "select per_agno, per_mes, meta_mini, meta_pino, meta_macro, num_setos from METAS_INF where per_agno =".$_GET['per_agno']." order by per_mes asc";
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$data = array();
		
		$meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		while( $rows = mysqli_fetch_assoc($resultset) ) {

			$idmes = intval($rows[per_mes]);
			
			$meta_mini = number_format($rows[meta_mini], 2, ',', '.');
			$meta_mini = str_replace(',00','',$meta_mini);
			
			$meta_pino = number_format($rows[meta_pino], 2, ',', '.');
			$meta_pino = str_replace(',00','',$meta_pino);
			
			$meta_macro = number_format($rows[meta_macro], 2, ',', '.');
			$meta_macro = str_replace(',00','',$meta_macro);

			$num_setos = number_format($rows[num_setos], 2, ',', '.');
			$num_setos = str_replace(',00','',$num_setos);			
			
			$data[] = 
			Array
			(
				'per_mes' => $rows[per_mes],
				'per_agno' => $rows[per_agno],
				'nom_mes' => $meses[$idmes],				
				'meta_mini' => $meta_mini,
				'meta_pino' => $meta_pino,
				'meta_macro' => $meta_macro,
				'num_setos' => $num_setos
			);		
		
		}
					
		$resp = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData"=>$data);

	}else{
	
		$per_agno = $_POST['per_agno'];
		$per_mes = $_POST['per_mes'];
		$meta_mini = $_POST['meta_mini'];
		$meta_pino = $_POST['meta_pino'];
		$meta_macro = $_POST['meta_macro'];
		$num_setos = $_POST['num_setos'];
		$chk_mini = $_POST['chk_mini'];
		$chk_pino = $_POST['chk_pino'];
		$chk_macro = $_POST['chk_macro'];
		$chk_setos = $_POST['chk_setos'];
	
		if($meta_mini == '' or $meta_pino == '' or $meta_macro == '' or $num_setos == ''){
			$resp = array('cod'=>'error','desc'=>'Ingresar todas las metas y núm de setos');
			salida($resp);
		}
		//3003*190 NUMERO SETOS
		$per_mes_int = intval($per_mes);
		
		if($chk_mini == 'S' and $chk_pino == 'S' and $chk_macro == 'S' and $chk_setos == 'S'){
			$sql = "update METAS_INF set meta_mini = $meta_mini, meta_pino = $meta_pino, meta_macro = $meta_macro, num_setos = $num_setos where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}

		elseif($chk_mini == 'S' and $chk_pino == 'S' and $chk_macro == 'S'){
			$sql = "update METAS_INF set meta_mini = $meta_mini, meta_pino = $meta_pino, meta_macro = $meta_macro where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}

		elseif($chk_mini == 'S' and $chk_pino == 'S' and $chk_setos == 'S'){
			$sql = "update METAS_INF set meta_mini = $meta_mini, meta_pino = $meta_pino, num_setos = $num_setos where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}	
		
		elseif($chk_mini == 'S' and $chk_macro == 'S' and $chk_setos == 'S'){
			$sql = "update METAS_INF set meta_mini = $meta_mini, meta_macro = $meta_macro, num_setos = $num_setos where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}
		
		elseif($chk_pino == 'S' and $chk_macro == 'S' and $chk_setos == 'S'){
			$sql = "update METAS_INF set meta_pino = $meta_pino, meta_macro = $meta_macro, num_setos = $num_setos where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}		

		elseif($chk_mini == 'S' and $chk_pino == 'S'){
			$sql = "update METAS_INF set meta_mini = $meta_mini, meta_pino = $meta_pino where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}		
		
		elseif($chk_mini == 'S' and $chk_macro == 'S'){
			$sql = "update METAS_INF set meta_mini = $meta_mini, meta_macro = $meta_macro where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}	
		
		elseif($chk_mini == 'S' and $chk_setos == 'S'){
			$sql = "update METAS_INF set meta_mini = $meta_mini, num_setos = $num_setos where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}		
		
		elseif($chk_pino == 'S' and $chk_macro == 'S'){
			$sql = "update METAS_INF set meta_pino = $meta_pino, meta_macro = $meta_macro where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}
		
		elseif($chk_pino == 'S' and $chk_setos == 'S'){
			$sql = "update METAS_INF set meta_pino = $meta_pino, num_setos = $num_setos where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}	
		
		elseif($chk_macro == 'S' and $chk_setos == 'S'){
			$sql = "update METAS_INF set meta_macro = $meta_macro, num_setos = $num_setos where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}			
		
		elseif($chk_mini == 'S'){
			$sql = "update METAS_INF set meta_mini = $meta_mini where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}
			
		elseif($chk_pino == 'S'){
			$sql = "update METAS_INF set meta_pino = $meta_pino where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}		
	
		elseif($chk_macro == 'S'){
			$sql = "update METAS_INF set meta_macro = $meta_macro where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}
		
		elseif($chk_setos == 'S'){
			$sql = "update METAS_INF set num_setos = $num_setos where per_agno = $per_agno and CAST(PER_MES AS UNSIGNED)>$per_mes_int";
		}		
		
		else{
			$sql = "";
		}
		
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
		if($sql <> ""){
			$resultado = mysqli_query($link,$sql)or die(salida($resp));	
		}	

		$sql = "update METAS_INF set meta_mini = $meta_mini, meta_pino = $meta_pino, meta_macro = $meta_macro, num_setos = $num_setos where per_agno = $per_agno and per_mes = '$per_mes'";
		$resultado = mysqli_query($link,$sql)or die(salida($resp));
		
		$resp = array('cod'=>'ok');
	}

	echo json_encode($resp);	

	
?>