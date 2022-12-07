<?php 

	include('coneccion.php');
	include('funciones_comunes.php');

	$operacion = $_POST['operacion'];		
	$plan_dia = $_POST['plan_dia'];
	$activ_id = $_POST['activ_id'];
	
	if($operacion == 'UPDATE OBS' or $operacion == 'DELETE OBS'){
		$oper_rut = $_POST['oper_rut'];
		$plano_obs = $_POST["plano_obs"];
		$plano_obs = !empty($_POST["plano_obs"]) ? "'$plano_obs'" : "NULL";
		
		if($plan_dia == "" or $activ_id == "" or $oper_rut == ''){
			$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
			salida($resp);
		}					
		
		$sql_ins_prod = "UPDATE PLANIFICACION_OPER SET PLANO_OBS=$plano_obs,PLANO_FECHACTPROD='$fecha_reg'  WHERE PLAN_DIA = '$plan_dia' 
		AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";
	
		$resultado = mysqli_query($link,$sql_ins_prod)or die(salida($resp));		
		
	}
	
	elseif($operacion == 'UPDATE CANT'){
		$oper_rut = $_POST['oper_rut'];

		$plano_cant1 = str_replace(",", ".",$_POST['plano_cant1']);
		$plano_cant2 = str_replace(",", ".",$_POST['plano_cant2']);
		$plano_cant3 = str_replace(",", ".",$_POST['plano_cant3']);
		$plano_cant4 = str_replace(",", ".",$_POST['plano_cant4']);
		
		$suma_cant = $plano_cant1 + $plano_cant2 + $plano_cant3 + $plano_cant4;

		$prod_hrini = $_POST["prod_hrini"];
		$prod_minini = $_POST["prod_minini"];	
		$prod_hrfin = $_POST["prod_hrfin"];	
		$prod_minfin = $_POST["prod_minfin"];	
		$prod_hrdscto = $_POST["prod_hrdscto"];	
		$prod_mindscto = $_POST["prod_mindscto"];	
		$prod_b1 = $_POST["prod_b1"];
		$prod_b2 = $_POST["prod_b2"];
		$prod_col = $_POST["prod_col"];		
		
		if($plano_cant1 == "" or $plano_cant2 == "" or $plano_cant3 == '' or $plano_cant4 == ''){
			$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
			salida($resp);
		}

		$ini=((($prod_hrini*60)*60)+($prod_minini*60));
		$fin=((($prod_hrfin*60)*60)+($prod_minfin*60));

		$dif=$fin-$ini;

		$difh=floor($dif/3600);
		$difm=round(floor(($dif-($difh*3600))/60)/60,2);
		
		$hr_trab = $difh + $difm;

		//hora de descuento			
		$hr_dscto = (int)$prod_hrdscto + round( (int)$prod_mindscto/60,2 );
		
		//hora break 1
		$hr_b1 = ($prod_b1 == 'S') ? 0.25 : 0;

		//hora break 2
		$hr_b2 = ($prod_b2 == 'S') ? 0.25 : 0;

		//hora break 2
		$hr_col = ($prod_col == 'S') ? 0.5 : 0;
		
		//horas de producción
		$horas_prod = $hr_trab - $hr_dscto  - $hr_b1 - $hr_b2 - $hr_col;

		if($horas_prod < 0){
			$resp = array('cod'=>'error','desc'=>'Las horas de producción con el tiempo registrado quedarían en negativo');
			salida($resp);
		}		
		
		$sql_ins_prod = "UPDATE PLANIFICACION_OPER SET PLANO_ASIST ='S',PLANO_CANT=$suma_cant,PLANO_CANT1=$plano_cant1,PLANO_CANT2=$plano_cant2,
		PLANO_CANT3=$plano_cant3,PLANO_CANT4=$plano_cant4,PLANO_HRINI='$prod_hrini',PLANO_MININI='$prod_minini',PLANO_HRFIN='$prod_hrfin',
		PLANO_MINFIN='$prod_minfin',PLANO_HRDSCTO='$prod_hrdscto',PLANO_MINDSCTO='$prod_mindscto',PLANO_B1='$prod_b1',PLANO_B2='$prod_b2',
		PLANO_COL='$prod_col',PLANO_HORASPROD=$horas_prod,PLANO_FECHACTPROD='$fecha_reg'  
		WHERE PLAN_DIA = '$plan_dia' AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";
	
		$resultado = mysqli_query($link,$sql_ins_prod)or die(salida($resp));		
		
	}	
	
	
	elseif($operacion == 'REGISTRAR CANT COSECHA'){

		$oper_rut = $_POST['oper_rut'];	
		$pm_plantas = $_POST['pm_plantas'];
		$pm_piscinas = $_POST['pm_piscinas'];
		$pisop_cant = $_POST['pm_cantidad'];
		
		if($plan_dia == "" or $activ_id == "" or $oper_rut == ''or $pm_plantas == "" or $pm_piscinas == "" or $pisop_cant == ""){
			$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
			salida($resp);
		}
		

		$sql = "select SUM(pisop_cant) AS sum_pisop_cant from PISCINA_OPER where oper_rut = '$oper_rut' and activ_id = $activ_id and plan_dia = '$plan_dia'";		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$sum_pisop_cant = mysqli_fetch_row($resultset);
		$suma_cant = $sum_pisop_cant[0] + $pisop_cant;
		
		mysqli_autocommit($link, FALSE);
		
		$sql = "insert into PISCINA_OPER (pis_pm, pis_id, oper_rut, plan_dia, activ_id, pisop_cant) values ('$pm_plantas',$pm_piscinas,'$oper_rut','$plan_dia',$activ_id,$pisop_cant)";
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));		
		
		
		$prod_hrini = $_POST["prod_hrini"];
		$prod_minini = $_POST["prod_minini"];	
		$prod_hrfin = $_POST["prod_hrfin"];	
		$prod_minfin = $_POST["prod_minfin"];	
		$prod_hrdscto = $_POST["prod_hrdscto"];	
		$prod_mindscto = $_POST["prod_mindscto"];	
		$prod_b1 = $_POST["prod_b1"];
		$prod_b2 = $_POST["prod_b2"];
		$prod_col = $_POST["prod_col"];		

		$ini=((($prod_hrini*60)*60)+($prod_minini*60));
		$fin=((($prod_hrfin*60)*60)+($prod_minfin*60));

		$dif=$fin-$ini;

		$difh=floor($dif/3600);
		$difm=round(floor(($dif-($difh*3600))/60)/60,2);
		
		$hr_trab = $difh + $difm;

		//hora de descuento			
		$hr_dscto = (int)$prod_hrdscto + round( (int)$prod_mindscto/60,2 );
		
		//hora break 1
		$hr_b1 = ($prod_b1 == 'S') ? 0.25 : 0;

		//hora break 2
		$hr_b2 = ($prod_b2 == 'S') ? 0.25 : 0;

		//hora break 2
		$hr_col = ($prod_col == 'S') ? 0.5 : 0;
		
		//horas de producción
		$horas_prod = $hr_trab - $hr_dscto  - $hr_b1 - $hr_b2 - $hr_col;

		if($horas_prod < 0){
			$resp = array('cod'=>'error','desc'=>'Las horas de producción con el tiempo registrado quedarían en negativo');
			salida($resp);
		}		
		
		$sql_ins_prod = "UPDATE PLANIFICACION_OPER SET PLANO_ASIST ='S',PLANO_CANT=$suma_cant,PLANO_CANT1=$suma_cant,PLANO_CANT2=0,
		PLANO_CANT3=0,PLANO_CANT4=0,PLANO_HRINI='$prod_hrini',PLANO_MININI='$prod_minini',PLANO_HRFIN='$prod_hrfin',
		PLANO_MINFIN='$prod_minfin',PLANO_HRDSCTO='$prod_hrdscto',PLANO_MINDSCTO='$prod_mindscto',PLANO_B1='$prod_b1',PLANO_B2='$prod_b2',
		PLANO_COL='$prod_col',PLANO_HORASPROD=$horas_prod,PLANO_FECHACTPROD='$fecha_reg'  
		WHERE PLAN_DIA = '$plan_dia' AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";
	
		$resultado = mysqli_query($link,$sql_ins_prod)or die(salida_con_rollback($resp,$link));
		
		
		mysqli_commit($link);
	}	
	
	
	elseif($operacion == 'MODIFICAR CANT COSECHA'){

		$oper_rut = $_POST['oper_rut'];	
		$hpm_plantas = $_POST['hpm_plantas'];
		$hpm_piscinas = $_POST['hpm_piscinas'];
		$pm_plantas = $_POST['pm_plantas'];
		$pm_piscinas = $_POST['pm_piscinas'];		
		$pisop_cant = $_POST['pm_cantidad'];
		
		if($plan_dia == "" or $activ_id == "" or $oper_rut == '' or $hpm_plantas == "" or $hpm_piscinas == "" or $pisop_cant == "" or $pm_plantas == "" or $pm_piscinas == "" ){
			$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
			salida($resp);
		}	
		
		mysqli_autocommit($link, FALSE);
		
		$sql = "update PISCINA_OPER set pis_pm = '$pm_plantas',pis_id = $pm_piscinas,pisop_cant = $pisop_cant where pis_pm = '$hpm_plantas' and pis_id = $hpm_piscinas and oper_rut = '$oper_rut' and activ_id = $activ_id and plan_dia = '$plan_dia' ";
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
		
		$sql = "select SUM(pisop_cant) AS sum_pisop_cant from PISCINA_OPER where oper_rut = '$oper_rut' and activ_id = $activ_id and plan_dia = '$plan_dia'";		
		$resultset = mysqli_query($link, $sql) or die(salida_con_rollback($resp,$link));	
		$sum_pisop_cant = mysqli_fetch_row($resultset);
		$suma_cant = $sum_pisop_cant[0];
			
		$prod_hrini = $_POST["prod_hrini"];
		$prod_minini = $_POST["prod_minini"];	
		$prod_hrfin = $_POST["prod_hrfin"];	
		$prod_minfin = $_POST["prod_minfin"];	
		$prod_hrdscto = $_POST["prod_hrdscto"];	
		$prod_mindscto = $_POST["prod_mindscto"];	
		$prod_b1 = $_POST["prod_b1"];
		$prod_b2 = $_POST["prod_b2"];
		$prod_col = $_POST["prod_col"];		

		$ini=((($prod_hrini*60)*60)+($prod_minini*60));
		$fin=((($prod_hrfin*60)*60)+($prod_minfin*60));

		$dif=$fin-$ini;

		$difh=floor($dif/3600);
		$difm=round(floor(($dif-($difh*3600))/60)/60,2);
		
		$hr_trab = $difh + $difm;

		//hora de descuento			
		$hr_dscto = (int)$prod_hrdscto + round( (int)$prod_mindscto/60,2 );
		
		//hora break 1
		$hr_b1 = ($prod_b1 == 'S') ? 0.25 : 0;

		//hora break 2
		$hr_b2 = ($prod_b2 == 'S') ? 0.25 : 0;

		//hora break 2
		$hr_col = ($prod_col == 'S') ? 0.5 : 0;
		
		//horas de producción
		$horas_prod = $hr_trab - $hr_dscto  - $hr_b1 - $hr_b2 - $hr_col;

		if($horas_prod < 0){
			$resp = array('cod'=>'error','desc'=>'Las horas de producción con el tiempo registrado quedarían en negativo');
			salida($resp);
		}		
		
		$sql_ins_prod = "UPDATE PLANIFICACION_OPER SET PLANO_ASIST ='S',PLANO_CANT=$suma_cant,PLANO_CANT1=$suma_cant,PLANO_CANT2=0,
		PLANO_CANT3=0,PLANO_CANT4=0,PLANO_HRINI='$prod_hrini',PLANO_MININI='$prod_minini',PLANO_HRFIN='$prod_hrfin',
		PLANO_MINFIN='$prod_minfin',PLANO_HRDSCTO='$prod_hrdscto',PLANO_MINDSCTO='$prod_mindscto',PLANO_B1='$prod_b1',PLANO_B2='$prod_b2',
		PLANO_COL='$prod_col',PLANO_HORASPROD=$horas_prod,PLANO_FECHACTPROD='$fecha_reg'  
		WHERE PLAN_DIA = '$plan_dia' AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";
	
		$resultado = mysqli_query($link,$sql_ins_prod)or die(salida_con_rollback($resp,$link));		
		
		mysqli_commit($link);
		
	}	
	
	elseif($operacion == 'ELIMINAR CANT COSECHA'){
		$oper_rut = $_POST['oper_rut'];
	
		$hpm_plantas = $_POST['hpm_plantas'];
		$hpm_piscinas = $_POST['hpm_piscinas'];
		
		if($plan_dia == "" or $activ_id == "" or $oper_rut == '' or $hpm_plantas == "" or $hpm_piscinas == "" ){
			$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
			salida($resp);
		}
		
		mysqli_autocommit($link, FALSE);
		
		$sql = "delete from PISCINA_OPER where pis_pm = '$hpm_plantas' and pis_id = $hpm_piscinas and oper_rut = '$oper_rut' and activ_id = $activ_id and plan_dia = '$plan_dia'";
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql) or die(salida_con_rollback($resp,$link));		
		
		
		$sql = "select IFNULL(SUM(pisop_cant),0) AS sum_pisop_cant from PISCINA_OPER where oper_rut = '$oper_rut' and activ_id = $activ_id and plan_dia = '$plan_dia'";		
		$resultset = mysqli_query($link, $sql) or die(salida_con_rollback($resp,$link));	
		$sum_pisop_cant = mysqli_fetch_row($resultset);
		$suma_cant = $sum_pisop_cant[0];
			
		$prod_hrini = $_POST["prod_hrini"];
		$prod_minini = $_POST["prod_minini"];	
		$prod_hrfin = $_POST["prod_hrfin"];	
		$prod_minfin = $_POST["prod_minfin"];	
		$prod_hrdscto = $_POST["prod_hrdscto"];	
		$prod_mindscto = $_POST["prod_mindscto"];	
		$prod_b1 = $_POST["prod_b1"];
		$prod_b2 = $_POST["prod_b2"];
		$prod_col = $_POST["prod_col"];		

		$ini=((($prod_hrini*60)*60)+($prod_minini*60));
		$fin=((($prod_hrfin*60)*60)+($prod_minfin*60));

		$dif=$fin-$ini;

		$difh=floor($dif/3600);
		$difm=round(floor(($dif-($difh*3600))/60)/60,2);
		
		$hr_trab = $difh + $difm;

		//hora de descuento			
		$hr_dscto = (int)$prod_hrdscto + round( (int)$prod_mindscto/60,2 );
		
		//hora break 1
		$hr_b1 = ($prod_b1 == 'S') ? 0.25 : 0;

		//hora break 2
		$hr_b2 = ($prod_b2 == 'S') ? 0.25 : 0;

		//hora break 2
		$hr_col = ($prod_col == 'S') ? 0.5 : 0;
		
		//horas de producción
		$horas_prod = $hr_trab - $hr_dscto  - $hr_b1 - $hr_b2 - $hr_col;

		if($horas_prod < 0){
			$resp = array('cod'=>'error','desc'=>'Las horas de producción con el tiempo registrado quedarían en negativo');
			salida($resp);
		}		
		
		$sql_ins_prod = "UPDATE PLANIFICACION_OPER SET PLANO_ASIST ='S',PLANO_CANT=$suma_cant,PLANO_CANT1=$suma_cant,PLANO_CANT2=0,
		PLANO_CANT3=0,PLANO_CANT4=0,PLANO_HRINI='$prod_hrini',PLANO_MININI='$prod_minini',PLANO_HRFIN='$prod_hrfin',
		PLANO_MINFIN='$prod_minfin',PLANO_HRDSCTO='$prod_hrdscto',PLANO_MINDSCTO='$prod_mindscto',PLANO_B1='$prod_b1',PLANO_B2='$prod_b2',
		PLANO_COL='$prod_col',PLANO_HORASPROD=$horas_prod,PLANO_FECHACTPROD='$fecha_reg'  
		WHERE PLAN_DIA = '$plan_dia' AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";
	
		$resultado = mysqli_query($link,$sql_ins_prod)or die(salida_con_rollback($resp,$link));		
		
		mysqli_commit($link);		
		
		
	}	
	
////////////////////	
	
	
	
	
	elseif($operacion == 'REGISTRAR CANT INSTALACION'){

		$oper_rut = $_POST['oper_rut'];	
		$inst_inv = $_POST['inst_inv'];
		$inst_clon = $_POST['inst_clon'];
		$inst_linea = $_POST['inst_linea'];
		$inst_tipoestaca = $_POST['inst_tipoestaca'];
		$inst_cantidad = $_POST['inst_cantidad'];
		
		if($plan_dia == "" or $activ_id == "" or $oper_rut == ''or $inst_inv == "" or $inst_clon == "" or $inst_linea == "" or $inst_tipoestaca == "" or $inst_cantidad == ""){
			$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
			salida($resp);
		}		

		$sql = "select SUM(inst_cantidad) AS sum_inst_cant from INSTALACION_OPER where oper_rut = '$oper_rut' and activ_id = $activ_id and plan_dia = '$plan_dia'";		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$sum_inst_cant = mysqli_fetch_row($resultset);
		$suma_cant = $sum_inst_cant[0] + $inst_cantidad;
		
		mysqli_autocommit($link, FALSE);
		
		$sql = "insert into INSTALACION_OPER (clon_id, oper_rut, plan_dia, activ_id, inst_inv, inst_linea, inst_tipoestaca, inst_cantidad) values ('$inst_clon','$oper_rut','$plan_dia',$activ_id,$inst_inv,$inst_linea,'$inst_tipoestaca',$inst_cantidad)";
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));		
		
		
		$prod_hrini = $_POST["prod_hrini"];
		$prod_minini = $_POST["prod_minini"];	
		$prod_hrfin = $_POST["prod_hrfin"];	
		$prod_minfin = $_POST["prod_minfin"];	
		$prod_hrdscto = $_POST["prod_hrdscto"];	
		$prod_mindscto = $_POST["prod_mindscto"];	
		$prod_b1 = $_POST["prod_b1"];
		$prod_b2 = $_POST["prod_b2"];
		$prod_col = $_POST["prod_col"];		

		$ini=((($prod_hrini*60)*60)+($prod_minini*60));
		$fin=((($prod_hrfin*60)*60)+($prod_minfin*60));

		$dif=$fin-$ini;

		$difh=floor($dif/3600);
		$difm=round(floor(($dif-($difh*3600))/60)/60,2);
		
		$hr_trab = $difh + $difm;

		//hora de descuento			
		$hr_dscto = (int)$prod_hrdscto + round( (int)$prod_mindscto/60,2 );
		
		//hora break 1
		$hr_b1 = ($prod_b1 == 'S') ? 0.25 : 0;

		//hora break 2
		$hr_b2 = ($prod_b2 == 'S') ? 0.25 : 0;

		//hora break 2
		$hr_col = ($prod_col == 'S') ? 0.5 : 0;
		
		//horas de producción
		$horas_prod = $hr_trab - $hr_dscto  - $hr_b1 - $hr_b2 - $hr_col;

		if($horas_prod < 0){
			$resp = array('cod'=>'error','desc'=>'Las horas de producción con el tiempo registrado quedarían en negativo');
			salida($resp);
		}		
		
		$sql_ins_prod = "UPDATE PLANIFICACION_OPER SET PLANO_ASIST ='S',PLANO_CANT=$suma_cant,PLANO_CANT1=$suma_cant,PLANO_CANT2=0,
		PLANO_CANT3=0,PLANO_CANT4=0,PLANO_HRINI='$prod_hrini',PLANO_MININI='$prod_minini',PLANO_HRFIN='$prod_hrfin',
		PLANO_MINFIN='$prod_minfin',PLANO_HRDSCTO='$prod_hrdscto',PLANO_MINDSCTO='$prod_mindscto',PLANO_B1='$prod_b1',PLANO_B2='$prod_b2',
		PLANO_COL='$prod_col',PLANO_HORASPROD=$horas_prod,PLANO_FECHACTPROD='$fecha_reg'  
		WHERE PLAN_DIA = '$plan_dia' AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";
	
		$resultado = mysqli_query($link,$sql_ins_prod)or die(salida_con_rollback($resp,$link));
		
		
		mysqli_commit($link);
	}	
	
	
	elseif($operacion == 'MODIFICAR CANT INSTALACION'){

		$inst_id = $_POST['inst_id'];	
		$oper_rut = $_POST['oper_rut'];	
		$inst_inv = $_POST['inst_inv'];
		$inst_clon = $_POST['inst_clon'];
		$inst_linea = $_POST['inst_linea'];
		$inst_tipoestaca = $_POST['inst_tipoestaca'];
		$inst_cantidad = $_POST['inst_cantidad'];
		
		if($inst_id == "" or $plan_dia == "" or $activ_id == "" or $oper_rut == ''or $inst_inv == "" or $inst_clon == "" or $inst_linea == "" or $inst_tipoestaca == "" or $inst_cantidad == ""){
			$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
			salida($resp);
		}
		
		mysqli_autocommit($link, FALSE);
		
		$sql = "update INSTALACION_OPER set inst_inv = $inst_inv,clon_id = '$inst_clon',inst_linea = $inst_linea,inst_tipoestaca = '$inst_tipoestaca',inst_cantidad = $inst_cantidad where inst_id = $inst_id";
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));				
		
		$sql = "select SUM(inst_cantidad) AS sum_inst_cant from INSTALACION_OPER where oper_rut = '$oper_rut' and activ_id = $activ_id and plan_dia = '$plan_dia'";		
		$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$sum_inst_cant = mysqli_fetch_row($resultset);
		$suma_cant = $sum_inst_cant[0];		
		
			
		$prod_hrini = $_POST["prod_hrini"];
		$prod_minini = $_POST["prod_minini"];	
		$prod_hrfin = $_POST["prod_hrfin"];	
		$prod_minfin = $_POST["prod_minfin"];	
		$prod_hrdscto = $_POST["prod_hrdscto"];	
		$prod_mindscto = $_POST["prod_mindscto"];	
		$prod_b1 = $_POST["prod_b1"];
		$prod_b2 = $_POST["prod_b2"];
		$prod_col = $_POST["prod_col"];		

		$ini=((($prod_hrini*60)*60)+($prod_minini*60));
		$fin=((($prod_hrfin*60)*60)+($prod_minfin*60));

		$dif=$fin-$ini;

		$difh=floor($dif/3600);
		$difm=round(floor(($dif-($difh*3600))/60)/60,2);
		
		$hr_trab = $difh + $difm;

		//hora de descuento			
		$hr_dscto = (int)$prod_hrdscto + round( (int)$prod_mindscto/60,2 );
		
		//hora break 1
		$hr_b1 = ($prod_b1 == 'S') ? 0.25 : 0;

		//hora break 2
		$hr_b2 = ($prod_b2 == 'S') ? 0.25 : 0;

		//hora break 2
		$hr_col = ($prod_col == 'S') ? 0.5 : 0;
		
		//horas de producción
		$horas_prod = $hr_trab - $hr_dscto  - $hr_b1 - $hr_b2 - $hr_col;

		if($horas_prod < 0){
			$resp = array('cod'=>'error','desc'=>'Las horas de producción con el tiempo registrado quedarían en negativo');
			salida($resp);
		}		
		
		$sql_ins_prod = "UPDATE PLANIFICACION_OPER SET PLANO_ASIST ='S',PLANO_CANT=$suma_cant,PLANO_CANT1=$suma_cant,PLANO_CANT2=0,
		PLANO_CANT3=0,PLANO_CANT4=0,PLANO_HRINI='$prod_hrini',PLANO_MININI='$prod_minini',PLANO_HRFIN='$prod_hrfin',
		PLANO_MINFIN='$prod_minfin',PLANO_HRDSCTO='$prod_hrdscto',PLANO_MINDSCTO='$prod_mindscto',PLANO_B1='$prod_b1',PLANO_B2='$prod_b2',
		PLANO_COL='$prod_col',PLANO_HORASPROD=$horas_prod,PLANO_FECHACTPROD='$fecha_reg'  
		WHERE PLAN_DIA = '$plan_dia' AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";
	
		$resultado = mysqli_query($link,$sql_ins_prod)or die(salida_con_rollback($resp,$link));		
		
		mysqli_commit($link);
		
	}	
	
	elseif($operacion == 'ELIMINAR CANT INSTALACION'){
		
		$inst_id = $_POST['inst_id'];
		$oper_rut = $_POST['oper_rut'];
		
		if($inst_id == "" or $plan_dia == "" or $activ_id == "" or $oper_rut == ''){
			$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
			salida($resp);
		}
		
		mysqli_autocommit($link, FALSE);
		
		$sql = "delete from INSTALACION_OPER where inst_id = $inst_id";
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');	
		$resultado = mysqli_query($link,$sql) or die(salida_con_rollback($resp,$link));		
		
		
		$sql = "select IFNULL(SUM(inst_cantidad),0) AS sum_inst_cant from INSTALACION_OPER where oper_rut = '$oper_rut' and activ_id = $activ_id and plan_dia = '$plan_dia'";
		$resultset = mysqli_query($link, $sql) or die(salida_con_rollback($resp,$link));
		$sum_inst_cant = mysqli_fetch_row($resultset);
		$suma_cant = $sum_inst_cant[0];			
		
			
		$prod_hrini = $_POST["prod_hrini"];
		$prod_minini = $_POST["prod_minini"];	
		$prod_hrfin = $_POST["prod_hrfin"];	
		$prod_minfin = $_POST["prod_minfin"];	
		$prod_hrdscto = $_POST["prod_hrdscto"];	
		$prod_mindscto = $_POST["prod_mindscto"];	
		$prod_b1 = $_POST["prod_b1"];
		$prod_b2 = $_POST["prod_b2"];
		$prod_col = $_POST["prod_col"];		

		$ini=((($prod_hrini*60)*60)+($prod_minini*60));
		$fin=((($prod_hrfin*60)*60)+($prod_minfin*60));

		$dif=$fin-$ini;

		$difh=floor($dif/3600);
		$difm=round(floor(($dif-($difh*3600))/60)/60,2);
		
		$hr_trab = $difh + $difm;

		//hora de descuento			
		$hr_dscto = (int)$prod_hrdscto + round( (int)$prod_mindscto/60,2 );
		
		//hora break 1
		$hr_b1 = ($prod_b1 == 'S') ? 0.25 : 0;

		//hora break 2
		$hr_b2 = ($prod_b2 == 'S') ? 0.25 : 0;

		//hora break 2
		$hr_col = ($prod_col == 'S') ? 0.5 : 0;
		
		//horas de producción
		$horas_prod = $hr_trab - $hr_dscto  - $hr_b1 - $hr_b2 - $hr_col;

		if($horas_prod < 0){
			$resp = array('cod'=>'error','desc'=>'Las horas de producción con el tiempo registrado quedarían en negativo');
			salida($resp);
		}		
		
		$sql_ins_prod = "UPDATE PLANIFICACION_OPER SET PLANO_ASIST ='S',PLANO_CANT=$suma_cant,PLANO_CANT1=$suma_cant,PLANO_CANT2=0,
		PLANO_CANT3=0,PLANO_CANT4=0,PLANO_HRINI='$prod_hrini',PLANO_MININI='$prod_minini',PLANO_HRFIN='$prod_hrfin',
		PLANO_MINFIN='$prod_minfin',PLANO_HRDSCTO='$prod_hrdscto',PLANO_MINDSCTO='$prod_mindscto',PLANO_B1='$prod_b1',PLANO_B2='$prod_b2',
		PLANO_COL='$prod_col',PLANO_HORASPROD=$horas_prod,PLANO_FECHACTPROD='$fecha_reg'  
		WHERE PLAN_DIA = '$plan_dia' AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";
	
		$resultado = mysqli_query($link,$sql_ins_prod)or die(salida_con_rollback($resp,$link));		
		
		mysqli_commit($link);		
		
		
	}		
	
	
	
	
	
	
	
	
	
//////////////////	
	else{
		$total_oper= count($_POST["oper_rut"]);
		$marca = $_POST["marca"];
		if($plan_dia == "" or $activ_id == "" or $total_oper == 0){
			$resp = array('cod'=>'error','desc'=>'Ingresar datos obligatorios');
			salida($resp);
		}					
		$rut_operadores_asist = '';
		mysqli_autocommit($link, FALSE);
		
		$i = 0;
		while($total_oper > $i){
			
			$oper_rut = $_POST["oper_rut"][$i];		
			$prod_asist = $_POST["prod_asist"][$i];
			$prod_cant = $_POST["prod_cant"][$i];	
			$prod_hrini = $_POST["prod_hrini"][$i];	
			$prod_minini = $_POST["prod_minini"][$i];	
			$prod_hrfin = $_POST["prod_hrfin"][$i];	
			$prod_minfin = $_POST["prod_minfin"][$i];	
			$prod_hrdscto = $_POST["prod_hrdscto"][$i];	
			$prod_mindscto = $_POST["prod_mindscto"][$i];	
			$prod_b1 = $_POST["prod_b1"][$i];	
			$prod_b2 = $_POST["prod_b2"][$i];
			$prod_col = $_POST["prod_col"][$i];	
			//$prod_obs = $_POST["prod_obs"][$i];	
			//$prod_obs = !empty($_POST["prod_obs"][$i]) ? "'$prod_obs'" : "NULL";
			
			
			if($prod_asist == 'S'){
				
				
				
				//horas trabajadas
				$ini=((($prod_hrini*60)*60)+($prod_minini*60));
				$fin=((($prod_hrfin*60)*60)+($prod_minfin*60));

				$dif=$fin-$ini;

				$difh=floor($dif/3600);
				$difm=round(floor(($dif-($difh*3600))/60)/60,2);
				
				$hr_trab = $difh + $difm;

				//hora de descuento			
				$hr_dscto = (int)$prod_hrdscto + round( (int)$prod_mindscto/60,2 );
				
				//hora break 1
				$hr_b1 = ($prod_b1 == 'S') ? 0.25 : 0;

				//hora break 2
				$hr_b2 = ($prod_b2 == 'S') ? 0.25 : 0;

				//hora break 2
				$hr_col = ($prod_col == 'S') ? 0.5 : 0;
				
				//horas de producción
				$horas_prod = $hr_trab - $hr_dscto  - $hr_b1 - $hr_b2 - $hr_col;
				
				if($horas_prod < 0){
					$resp = array('cod'=>'error','desc'=>'Las horas de producción con el tiempo registrado quedarían en negativo (para uno o más operadores)');
					salida_con_rollback($resp,$link);
				}			
				
				//$prod_cant = !empty($_POST["prod_cant"][$i]) ? "$prod_cant" : "NULL";	
				$prod_hrini = !empty($_POST["prod_hrini"][$i]) ? "'$prod_hrini'" : "NULL";
				$prod_minini = !empty($_POST["prod_minini"][$i]) ? "'$prod_minini'" : "NULL";	
				$prod_hrfin = !empty($_POST["prod_hrfin"][$i]) ? "'$prod_hrfin'" : "NULL";	
				$prod_minfin = !empty($_POST["prod_minfin"][$i]) ? "'$prod_minfin'" : "NULL";	
				$prod_hrdscto = !empty($_POST["prod_hrdscto"][$i]) ? "'$prod_hrdscto'" : "NULL";	
				$prod_mindscto = !empty($_POST["prod_mindscto"][$i]) ? "'$prod_mindscto'" : "NULL";	
				$prod_b1 = !empty($_POST["prod_b1"][$i]) ? "'$prod_b1'" : "NULL";
				$prod_b2 = !empty($_POST["prod_b2"][$i]) ? "'$prod_b2'" : "NULL";
				$prod_col = !empty($_POST["prod_col"][$i]) ? "'$prod_col'" : "NULL";
				
				$sql_ins_prod = "UPDATE PLANIFICACION_OPER SET PLANO_ASIST='$prod_asist',PLANO_HRINI=$prod_hrini,PLANO_MININI=$prod_minini,
				PLANO_HRFIN=$prod_hrfin, PLANO_MINFIN=$prod_minfin,PLANO_HRDSCTO=$prod_hrdscto,PLANO_MINDSCTO=$prod_mindscto,PLANO_B1=$prod_b1,PLANO_B2=$prod_b2,
				PLANO_COL=$prod_col,PLANO_HORASPROD=$horas_prod,PLANO_FECHACTPROD='$fecha_reg'  WHERE PLAN_DIA = '$plan_dia' 
				AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";
				
			}else{
				$horas_prod = "NULL";				
				$prod_cant = "NULL";	
				$prod_hrini = "NULL";
				$prod_minini = "NULL";	
				$prod_hrfin = "NULL";	
				$prod_minfin = "NULL";	
				$prod_hrdscto = "NULL";	
				$prod_mindscto = "NULL";	
				$prod_b1 = "NULL";
				$prod_b2 = "NULL";
				$prod_col = "NULL";
				$prod_cant1 = 0;
				$prod_cant2 = 0;
				$prod_cant3 = 0;
				$prod_cant4 = 0;
				
				$sql_ins_prod = "UPDATE PLANIFICACION_OPER SET PLANO_ASIST='$prod_asist',PLANO_CANT=$prod_cant,PLANO_CANT1=$prod_cant1,PLANO_CANT2=$prod_cant2,
				PLANO_CANT3=$prod_cant3,PLANO_CANT4=$prod_cant4,PLANO_HRINI=$prod_hrini,PLANO_MININI=$prod_minini,
				PLANO_HRFIN=$prod_hrfin, PLANO_MINFIN=$prod_minfin,PLANO_HRDSCTO=$prod_hrdscto,PLANO_MINDSCTO=$prod_mindscto,PLANO_B1=$prod_b1,PLANO_B2=$prod_b2,
				PLANO_COL=$prod_col,PLANO_HORASPROD=$horas_prod,PLANO_FECHACTPROD='$fecha_reg' WHERE PLAN_DIA = '$plan_dia' 
				AND ACTIV_ID = $activ_id AND OPER_RUT='$oper_rut'";							
			}	
						
			$resp = array('cod'=>'error','desc'=>'Error de inserción en Base de Datos.');
		
			$resultado = mysqli_query($link,$sql_ins_prod)or die(salida_con_rollback($resp,$link));
						
			$i++;	

			if($total_oper > $i){
				$rut_operadores_asist .= "'".$oper_rut."',";
			}
			else{
				$rut_operadores_asist .= "'".$oper_rut."'";
			}
			
		}
		
		if($marca){
			$sql = "select OPER_RUT, sum(PLANO_HORASPROD) from PLANIFICACION_OPER WHERE PLAN_DIA = '$plan_dia' AND PLANO_ASIST ='S' 
			and oper_rut in ($rut_operadores_asist)
			group by OPER_RUT having sum(PLANO_HORASPROD) > 8.25";	
			
			$resultado = mysqli_query($link,$sql);	
			$rowcount = mysqli_num_rows($resultado);

			$data = array();
			if($rowcount > 0){
				
				while( $rows = mysqli_fetch_assoc($resultado) ) {
					$data[] = $rows[OPER_RUT];
				}
			
				//$resp = array('cod'=>'advertencia','desc'=>'Existen Operadores con mas de 8.25 horas productivas en el día','rut_operadores'=>$data);
				$resp = array('cod'=>'advertencia','desc'=>'Operadores con más de 8.25hrs en el día','rut_operadores'=>$data);
				salida_con_rollback($resp,$link);
			}		
		}
		
		mysqli_commit($link);
		
	}	
		
		
	$resp = array('cod'=>'ok','operacion'=>$operacion);
	
	

	echo json_encode($resp);	
	exit();
	

?>