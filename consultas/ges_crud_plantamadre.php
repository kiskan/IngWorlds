<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['planta_madre'])){
	
		$planta_madre = $_GET['planta_madre'];
		$sql = "select pis_pm, pis_id, c.clon_id, c.clon_especie, pis_estado, pis_numseto, DATE_FORMAT(pis_finstal,'%d-%m-%Y') as pis_finstal from PISCINA p join CLON c on p.clon_id = c.clon_id where pis_pm = '$planta_madre' order by pis_pm, pis_id";
		
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
	
	elseif(isset($_GET['pm_filtro'])){
		
		$per_agno = $_GET['per_agno'];
		$per_mes = ($_GET['per_mes'] == '') ? '' : intval($_GET['per_mes']);
		$sem_num = $_GET['sem_num'];	
		$pm_filtro = $_GET['pm_filtro'];		
		
		$sql = "select Year(pis_fcambio) agno, Month(pis_fcambio) mes, Week(pis_fcambio) semana, pis_pm, pis_id, c.clon_id, c.clon_especie, pis_estado, pis_numseto, DATE_FORMAT(pis_finstal,'%d-%m-%Y') as pis_finstal, DATE_FORMAT(pis_fcambio,'%d-%m-%Y') as pis_fcambio from HPISCINA p join CLON c on p.clon_id = c.clon_id 
		WHERE
		(Year(pis_fcambio) = '$per_agno' or '$per_agno' = '') AND
		(Month(pis_fcambio) = '$per_mes' or '$per_mes' = '') AND
		(Week(pis_fcambio) = '$sem_num' or '$sem_num' = '') AND
		(pis_pm = '$pm_filtro' or '$pm_filtro' = '')		
		order by pis_pm, pis_id";
		
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
	
	
	elseif(isset($_GET['oper_rut'])){
		
		$oper_rut = $_GET['oper_rut'];
		$plan_dia = $_GET['plan_dia'];	
		$activ_id = $_GET['activ_id'];		
		
		$sql = "select p.pis_pm, p.pis_id, 
			(
SELECT CLON_ID
  FROM (
select DISTINCT CLON_ID, PIS_FINSTAL,PIS_PM,PIS_ID from HPISCINA 
UNION
select CLON_ID, PIS_FINSTAL,PIS_PM,PIS_ID  from PISCINA 
       ) AS U
WHERE U.PIS_PM = p.PIS_PM AND U.PIS_ID = p.PIS_ID
AND U.PIS_FINSTAL <= '$plan_dia'
ORDER BY U.PIS_FINSTAL DESC
LIMIT 1			
			) AS clon_id		
		, po.pisop_cant from PISCINA_OPER po join PISCINA p on po.pis_pm = p.pis_pm and po.pis_id = p.pis_id join CLON c on p.clon_id = c.clon_id join PLANIFICACION_OPER plano on po.oper_rut = plano.oper_rut and po.plan_dia = plano.plan_dia and po.activ_id = plano.activ_id 
		WHERE
		po.oper_rut = '$oper_rut'AND
		po.plan_dia = '$plan_dia'AND
		po.activ_id = '$activ_id'
		order by p.pis_pm, p.pis_id";
		
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
	
	
	
	elseif(isset($_POST['cons_clon'])){
	
		$pm_plantas = $_POST['pm_plantas'];
		$pm_piscinas = $_POST['pm_piscinas'];
		$fecha = $_POST['fecha'];
		
		//$sql = "select clon_id from PISCINA where pis_pm = '$pm_plantas' and pis_id = $pm_piscinas";	
		$sql = "
SELECT CLON_ID
  FROM (
select DISTINCT CLON_ID, PIS_FINSTAL,PIS_PM,PIS_ID from HPISCINA 
UNION
select CLON_ID, PIS_FINSTAL,PIS_PM,PIS_ID  from PISCINA 
       ) AS U
WHERE U.PIS_PM = '$pm_plantas' AND U.PIS_ID = $pm_piscinas
AND U.PIS_FINSTAL <= '$fecha'
ORDER BY U.PIS_FINSTAL DESC
LIMIT 1			
		";

		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$clon = mysqli_fetch_row($resultset);
		$resp = array('cod'=>'ok','clon_id'=>$clon[0]);

	}	
	
	
	else{

		$operacion = $_POST['operacion'];
					
		if($operacion == 'INSERT'){
			
			$pm_plantas = $_POST['pm_plantas'];
			$pm_piscinas = $_POST['pm_piscinas'];
			$clon_id = $_POST['clon_id'];
			$pm_estado = $_POST['pm_estado'];
			$pm_setos = $_POST['pm_setos'];
			$finstal = explode("-" ,$_POST['pm_finstal']);
			$pm_finstal = $finstal[2].'-'.$finstal[1].'-'.$finstal[0];			
			
			if($pm_plantas == "" or $pm_piscinas == "" or $clon_id == "" or $pm_estado == "" or $pm_setos == "" or $pm_finstal == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "insert into PISCINA (pis_pm, pis_id, clon_id, pis_estado, pis_finstal, pis_numseto) values ('$pm_plantas',$pm_piscinas,'$clon_id','$pm_estado','$pm_finstal',$pm_setos)";
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
			$resultado = mysqli_query($link,$sql)or die(salida($resp));					
		}
		
		elseif($operacion == 'UPDATE'){
		
			$hpm_plantas = $_POST['hpm_plantas'];
			$hpm_piscinas = $_POST['hpm_piscinas'];			
			$pm_plantas = $_POST['pm_plantas'];
			$pm_piscinas = $_POST['pm_piscinas'];
			$clon_id = $_POST['clon_id'];
			$pm_estado = $_POST['pm_estado'];
			$pm_setos = $_POST['pm_setos'];
			$finstal = explode("-" ,$_POST['pm_finstal']);
			$pm_finstal = $finstal[2].'-'.$finstal[1].'-'.$finstal[0];			
			
			if($hpm_plantas == "" or $hpm_piscinas == "" or $pm_plantas == "" or $pm_piscinas == "" or $clon_id == "" or $pm_estado == "" or $pm_setos == "" or $pm_finstal == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "update PISCINA set pis_pm = '$pm_plantas',pis_id = $pm_piscinas,clon_id = '$clon_id',pis_estado = '$pm_estado',pis_finstal = '$pm_finstal',pis_numseto = $pm_setos where pis_pm = '$hpm_plantas' and pis_id = $hpm_piscinas";
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
			$resultado = mysqli_query($link,$sql)or die(salida($resp));					
		}	
		
		elseif($operacion == 'DELETE'){
			
			$hpm_plantas = $_POST['hpm_plantas'];
			$hpm_piscinas = $_POST['hpm_piscinas'];
			
			if($hpm_plantas == "" or $hpm_piscinas == "" ){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$sql = "delete from PISCINA where pis_pm = '$hpm_plantas' and pis_id = $hpm_piscinas";
			$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
			$resultado = mysqli_query($link,$sql)or die(salida($resp));				
		}	
		
		elseif($operacion == 'INSERT_CAMBIO'){
			
			$pm_plantas = $_POST['pm_plantas'];
			$hpm_piscinas = $_POST['hpm_piscinas'];
			$xclon_id = $_POST['xclon_id'];
			$xpm_estado = $_POST['xpm_estado'];
			$xpm_setos = $_POST['xpm_setos'];
			$fcambio = explode("-" ,$_POST['xpm_fcambio']);
			$xpm_fcambio = $fcambio[2].'-'.$fcambio[1].'-'.$fcambio[0];			
			$xfinstal = explode("-" ,$_POST['xpm_finstal']);
			$xpm_finstal = $xfinstal[2].'-'.$xfinstal[1].'-'.$xfinstal[0];	
			
			$clon_id = $_POST['clon_id'];
			$pm_estado = $_POST['pm_estado'];
			$pm_setos = $_POST['pm_setos'];
			$finstal = explode("-" ,$_POST['pm_finstal']);
			$pm_finstal = $finstal[2].'-'.$finstal[1].'-'.$finstal[0];			
			
			if($pm_plantas == "" or $hpm_piscinas == "" or $xclon_id == "" or $xpm_estado == "" or $xpm_setos == "" or $xpm_finstal == "" or $xpm_fcambio == "" or $clon_id == "" or $pm_estado == "" or $pm_setos == "" or $pm_finstal == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			mysqli_autocommit($link, FALSE);
			$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos.');
			
			$sql = "insert into HPISCINA (pis_pm, pis_id, clon_id, pis_estado, pis_finstal, pis_fcambio, pis_numseto) values ('$pm_plantas',$hpm_piscinas,'$clon_id','$pm_estado','$pm_finstal','$xpm_fcambio',$pm_setos)";		
			$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos1.');
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
			
			$sql = "update PISCINA set clon_id = '$xclon_id',pis_estado = '$xpm_estado',pis_finstal = '$xpm_finstal',pis_numseto = $xpm_setos where pis_pm = '$pm_plantas' and pis_id = $hpm_piscinas";	
			$resp = array('cod'=>'error','desc'=>'Error en la integridad de la Base de Datos2.');
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
			
			mysqli_commit($link);
			
		}		

		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}

	//Retorna respuesta
	echo json_encode($resp);
	exit();		
/*
	//Salida Forzosa
	function salida($resp){	
		echo json_encode($resp);
		exit();
	}
*/
?>