<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['oper_rut'])){
	
		$oper_rut = $_GET['oper_rut'];
		$plan_dia = $_GET['plan_dia'];	
		$activ_id = $_GET['activ_id'];		
/*		
		$oper_rut = '12767957-6';
		$plan_dia = '20190219';	
		$activ_id = '135';			
*/		
		$sql = "select inst_id, inst_inv, clon_id, inst_linea, inst_tipoestaca, inst_cantidad
		from INSTALACION_OPER
		WHERE
		OPER_RUT = '$oper_rut' AND
		PLAN_DIA = '$plan_dia' AND
		ACTIV_ID = '$activ_id'
		order by INST_INV, INST_LINEA";
		
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
	
	/*
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
*/
	//Retorna respuesta
	echo json_encode($resp);
	exit();		

?>