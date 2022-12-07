<?php 

	include('coneccion.php');
	include('funciones_comunes.php');
	
	if(isset($_GET['data'])){
	
		$sql = "
		SELECT
			 CTRLTD_ID            			              
			,PER_AGNO
			,SEM_NUM
			,CTRLTD_DIA
			,CT.SUP_RUT
			,CONCAT(SUP_NOMBRES,' ',SUP_PATERNO,' ',SUP_MATERNO) AS SUPERVISOR			
			,CT.OPER_RUT             
			,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO			              
			,CT.LIN_ID               
			,LIN.LIN_NOMBRE
			,CTRLTD_HRINI         
			,CTRLTD_HRFIN    
			
			,REPLACE(CTRLTD_SACOTURBA,'.00','') CTRLTD_SACOTURBA     
			,REPLACE(CTRLTD_SACOPERLITA,'.00','') CTRLTD_SACOPERLITA  
			,REPLACE(CTRLTD_BASACOTE,'.00','')CTRLTD_BASACOTE      
			,REPLACE(CTRLTD_OSMOCOTE,'.00','') CTRLTD_OSMOCOTE     
			,REPLACE(CTRLTD_VERMICULITA,'.00','')CTRLTD_VERMICULITA
			
			,REPLACE(CTRLTD_FRCAMBOQ,'.00','') CTRLTD_FRCAMBOQ     
			,REPLACE(CTRLTD_CANTCAMBOQ,'.00','') CTRLTD_CANTCAMBOQ   
			,REPLACE(CTRLTD_FRLAVBOQ,'.00','')CTRLTD_FRLAVBOQ      
			,REPLACE(CTRLTD_CANTLAVBOQ,'.00','')CTRLTD_CANTLAVBOQ    
			
			,REPLACE(CTRLTD_88BUENCORTEZA,'.00','') CTRLTD_88BUENCORTEZA
			,REPLACE(CTRLTD_88DEFCORTEZA,'.00','')CTRLTD_88DEFCORTEZA
			,REPLACE((CTRLTD_88BUENCORTEZA-CTRLTD_88DEFCORTEZA),'.00','') CTRLTD_88TOTALCORTEZA			
			,REPLACE(CTRLTD_45BUENCORTEZA,'.00','') CTRLTD_45BUENCORTEZA
			,REPLACE(CTRLTD_45DEFCORTEZA,'.00','')CTRLTD_45DEFCORTEZA
			,REPLACE((CTRLTD_45BUENCORTEZA-CTRLTD_45DEFCORTEZA),'.00','') CTRLTD_45TOTALCORTEZA
			,REPLACE((CTRLTD_88BUENCORTEZA-CTRLTD_88DEFCORTEZA) + (CTRLTD_45BUENCORTEZA-CTRLTD_45DEFCORTEZA),'.00','') CTRLTD_88_45TOTALCORTEZA
			
			,REPLACE(CTRLTD_88BUENTURBA,'.00','')  CTRLTD_88BUENTURBA 
			,REPLACE(CTRLTD_88DEFTURBA,'.00','')CTRLTD_88DEFTURBA
			,REPLACE((CTRLTD_88BUENTURBA-CTRLTD_88DEFTURBA),'.00','') CTRLTD_88TOTALTURBA
			,REPLACE(CTRLTD_45BUENTURBA,'.00','') CTRLTD_45BUENTURBA 
			,REPLACE(CTRLTD_45DEFTURBA,'.00','')CTRLTD_45DEFTURBA
			,REPLACE((CTRLTD_45BUENTURBA-CTRLTD_45DEFTURBA),'.00','') CTRLTD_45TOTALTURBA			
			,REPLACE((CTRLTD_88BUENTURBA-CTRLTD_88DEFTURBA) + (CTRLTD_45BUENTURBA-CTRLTD_45DEFTURBA),'.00','') CTRLTD_88_45TOTALTURBA
			
			,REPLACE(CTRLTD_88BUENSANITIZADO,'.00','') CTRLTD_88BUENSANITIZADO
			,REPLACE(CTRLTD_88DEFSANITIZADO,'.00','')CTRLTD_88DEFSANITIZADO
			,REPLACE((CTRLTD_88BUENSANITIZADO-CTRLTD_88DEFSANITIZADO),'.00','') CTRLTD_88TOTALSANITIZADO
			,REPLACE(CTRLTD_45BUENSANITIZADO,'.00','')CTRLTD_45BUENSANITIZADO 
			,REPLACE(CTRLTD_45DEFSANITIZADO,'.00','')CTRLTD_45DEFSANITIZADO
			,REPLACE((CTRLTD_45BUENSANITIZADO-CTRLTD_45DEFSANITIZADO),'.00','') CTRLTD_45TOTALSANITIZADO
			,REPLACE((CTRLTD_88BUENSANITIZADO-CTRLTD_88DEFSANITIZADO) + (CTRLTD_45BUENSANITIZADO-CTRLTD_45DEFSANITIZADO),'.00','') CTRLTD_88_45TOTALSANITIZADO
			
		FROM CONTROL_TIMEDEAD CT
		JOIN SUPERVISOR SUP ON SUP.SUP_RUT = CT.SUP_RUT
		JOIN OPERADOR OPER ON OPER.OPER_RUT = CT.OPER_RUT
		JOIN LINEA LIN ON LIN.LIN_ID = CT.LIN_ID
		";
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
	
	
	elseif(isset($_GET['ctrltd_id'])){
		
		$ctrltd_id = $_GET['ctrltd_id'];
	
		$sql = "
		SELECT
			 CT.CTRLTD_ID            			              
			,PER_AGNO
			,SEM_NUM
			,CTRLTD_DIA
			,CT.SUP_RUT
			,CONCAT(SUP_NOMBRES,' ',SUP_PATERNO,' ',SUP_MATERNO) AS SUPERVISOR			
			,CT.OPER_RUT             
			,CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) AS OPERARIO			              
			,CT.LIN_ID               
			,LIN.LIN_NOMBRE
			,CTRLTD_HRINI         
			,CTRLTD_HRFIN     
 
			,REPLACE(CTRLTD_SACOTURBA,'.00','') CTRLTD_SACOTURBA     
			,REPLACE(CTRLTD_SACOPERLITA,'.00','') CTRLTD_SACOPERLITA  
			,REPLACE(CTRLTD_BASACOTE,'.00','')CTRLTD_BASACOTE      
			,REPLACE(CTRLTD_OSMOCOTE,'.00','') CTRLTD_OSMOCOTE     
			,REPLACE(CTRLTD_VERMICULITA,'.00','')CTRLTD_VERMICULITA
			
			,REPLACE(CTRLTD_FRCAMBOQ,'.00','') CTRLTD_FRCAMBOQ     
			,REPLACE(CTRLTD_CANTCAMBOQ,'.00','') CTRLTD_CANTCAMBOQ   
			,REPLACE(CTRLTD_FRLAVBOQ,'.00','')CTRLTD_FRLAVBOQ      
			,REPLACE(CTRLTD_CANTLAVBOQ,'.00','')CTRLTD_CANTLAVBOQ 			

			
			,REPLACE(CTRLTD_88BUENCORTEZA,'.00','') CTRLTD_88BUENCORTEZA
			,REPLACE(CTRLTD_88DEFCORTEZA,'.00','')CTRLTD_88DEFCORTEZA
			,REPLACE((CTRLTD_88BUENCORTEZA-CTRLTD_88DEFCORTEZA),'.00','') CTRLTD_88TOTALCORTEZA			
			,REPLACE(CTRLTD_45BUENCORTEZA,'.00','') CTRLTD_45BUENCORTEZA
			,REPLACE(CTRLTD_45DEFCORTEZA,'.00','')CTRLTD_45DEFCORTEZA
			,REPLACE((CTRLTD_45BUENCORTEZA-CTRLTD_45DEFCORTEZA),'.00','') CTRLTD_45TOTALCORTEZA
			,REPLACE((CTRLTD_88BUENCORTEZA-CTRLTD_88DEFCORTEZA) + (CTRLTD_45BUENCORTEZA-CTRLTD_45DEFCORTEZA),'.00','') CTRLTD_88_45TOTALCORTEZA			
						
			
			,REPLACE(CTRLTD_88BUENTURBA,'.00','')  CTRLTD_88BUENTURBA 
			,REPLACE(CTRLTD_88DEFTURBA,'.00','')CTRLTD_88DEFTURBA
			,REPLACE((CTRLTD_88BUENTURBA-CTRLTD_88DEFTURBA),'.00','') CTRLTD_88TOTALTURBA
			,REPLACE(CTRLTD_45BUENTURBA,'.00','') CTRLTD_45BUENTURBA 
			,REPLACE(CTRLTD_45DEFTURBA,'.00','')CTRLTD_45DEFTURBA
			,REPLACE((CTRLTD_45BUENTURBA-CTRLTD_45DEFTURBA),'.00','') CTRLTD_45TOTALTURBA			
			,REPLACE((CTRLTD_88BUENTURBA-CTRLTD_88DEFTURBA) + (CTRLTD_45BUENTURBA-CTRLTD_45DEFTURBA),'.00','') CTRLTD_88_45TOTALTURBA			
			
			
			,REPLACE(CTRLTD_88BUENSANITIZADO,'.00','') CTRLTD_88BUENSANITIZADO
			,REPLACE(CTRLTD_88DEFSANITIZADO,'.00','')CTRLTD_88DEFSANITIZADO
			,REPLACE((CTRLTD_88BUENSANITIZADO-CTRLTD_88DEFSANITIZADO),'.00','') CTRLTD_88TOTALSANITIZADO
			,REPLACE(CTRLTD_45BUENSANITIZADO,'.00','')CTRLTD_45BUENSANITIZADO 
			,REPLACE(CTRLTD_45DEFSANITIZADO,'.00','')CTRLTD_45DEFSANITIZADO
			,REPLACE((CTRLTD_45BUENSANITIZADO-CTRLTD_45DEFSANITIZADO),'.00','') CTRLTD_45TOTALSANITIZADO
			,REPLACE((CTRLTD_88BUENSANITIZADO-CTRLTD_88DEFSANITIZADO) + (CTRLTD_45BUENSANITIZADO-CTRLTD_45DEFSANITIZADO),'.00','') CTRLTD_88_45TOTALSANITIZADO			
			
			
			,DCTRLTD_ID
			,DCTRLTD_HRINI
			,DCTRLTD_HRFIN	

			/*,LEFT(TIMEDIFF(DCTRLTD_HRFIN, DCTRLTD_HRINI),8) DURACION*/
			
			,REPLACE(TIME_TO_SEC(TIMEDIFF(DCTRLTD_HRFIN, DCTRLTD_HRINI))/60,'.0000','') DURACION
			
			,CAT.UNDVIV_ID
			,UNDVIV_NOMBRE			
			,DCT.CTIEMPO_COD
			,CTIEMPO_CAUSA			
			,DCTRLTD_OBS
			
		FROM CONTROL_TIMEDEAD CT
		JOIN DCONTROL_TIMEDEAD DCT ON DCT.CTRLTD_ID = CT.CTRLTD_ID
		JOIN SUPERVISOR SUP ON SUP.SUP_RUT = CT.SUP_RUT
		JOIN OPERADOR OPER ON OPER.OPER_RUT = CT.OPER_RUT
		JOIN LINEA LIN ON LIN.LIN_ID = CT.LIN_ID
		JOIN CAUSA_TIEMPOS CAT ON CAT.CTIEMPO_COD = DCT.CTIEMPO_COD
		JOIN UNIDAD_VIVEROS UNDVIV ON UNDVIV.UNDVIV_ID = CAT.UNDVIV_ID
		WHERE CT.CTRLTD_ID = '$ctrltd_id'
		";
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
	
	elseif(isset($_POST['tiempo_acumulado'])){
		
		$ctrltd_id = $_POST['ctrltd_id'];
		
		$sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(DCTRLTD_HRFIN, DCTRLTD_HRINI)))) TIEMPO_ACUM FROM DCONTROL_TIMEDEAD WHERE CTRLTD_ID = $ctrltd_id";
		$resultado = mysqli_query($link,$sql)or die(salida($resp));
		$fila = mysqli_fetch_row($resultado);
		$tiempo_acumulado = $fila[0];
		
		$resp = array('tiempo_acumulado'=>$tiempo_acumulado);
		salida($resp);
	}
		
	else{

//ENCABEZADO TIEMPO MUERTO

		$operacion = $_POST['operacion'];
		$resp = array('cod'=>'error','desc'=>'Error en Base de Datos. Inténtelo más tarde');
					
		if($operacion == 'INSERT'){
			
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$ctrltd_dia = $_POST['ctrltd_dia'];
			$ctrltd_hrini = $_POST['ctrltd_hrini'].':'.$_POST['ctrltd_minini'];
			
			$ctrltd_hrfin = '';
			if($_POST['ctrltd_hrfin'] <> ''){
				$ctrltd_hrfin = $_POST['ctrltd_hrfin'].':'.$_POST['ctrltd_minfin'];
			}
			$lin_id = $_POST['lin_id'];
			$sup_rut = $_POST['sup_rut'];
			$oper_rut = $_POST['oper_rut'];			
			
			if($per_agno == "" or $sem_num == "" or $ctrltd_dia == "" or $_POST['ctrltd_hrini'] == "" or $_POST['ctrltd_minini'] == "" or $_POST['ctrltd_hrfin'] == "" or $_POST['ctrltd_minfin'] == "" or $lin_id == "" or $sup_rut == "" or $oper_rut == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}			
			/*
			if($_POST['ctrltd_hrfin'] <> '' and $_POST['ctrltd_minfin'] == ''){
				$resp = array('cod'=>'error','desc'=>'Error: Si selecciona hora de término debe indicar los minutos');
				salida($resp);
			}	

			if($_POST['ctrltd_hrfin'] == '' and $_POST['ctrltd_minfin'] <> ''){
				$resp = array('cod'=>'error','desc'=>'Error: Si selecciona min de término debe indicar la hora');
				salida($resp);
			}			
			*/
			//if($_POST['ctrltd_hrfin'] <> ''){
			
				$hrini = (int)$_POST['ctrltd_hrini'];
				$minini = (int)$_POST['ctrltd_minini'];
				$hrfin = (int)$_POST['ctrltd_hrfin'];
				$minfin = (int)$_POST['ctrltd_minfin'];
				
				if($hrini > $hrfin){
					$resp = array('cod'=>'error','desc'=>'Error: Hora de inicio no puede ser mayor a la hora de término');
					salida($resp);			
				}
				
				if($hrini == $hrfin and $minini > $minfin){
					$resp = array('cod'=>'error','desc'=>'Error: Hora de inicio no puede ser mayor a la hora de término');
					salida($resp);			
				}
					
			//}
				
			$sql = "SELECT 1 FROM CONTROL_TIMEDEAD where ctrltd_dia = '$ctrltd_dia' and lin_id = '$lin_id'";
			$resultado = mysqli_query($link,$sql);
			$rowcount = mysqli_num_rows($resultado);
			
			if($rowcount > 0){
				$resp = array('cod'=>'error','desc'=>'Error: Línea ya registrada para el día seleccionado');
				salida($resp);				
			}
				
			
			$sql = "INSERT INTO CONTROL_TIMEDEAD(SEM_NUM,PER_AGNO,OPER_RUT,SUP_RUT,LIN_ID,CTRLTD_DIA,CTRLTD_HRINI,CTRLTD_HRFIN) 
			values ('$sem_num','$per_agno','$oper_rut','$sup_rut','$lin_id','$ctrltd_dia','$ctrltd_hrini','$ctrltd_hrfin')";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
		}
		
		elseif($operacion == 'UPDATE'){
			
			$ctrltd_id = $_POST['ctrltd_id'];
			$per_agno = $_POST['per_agno'];
			$sem_num = $_POST['sem_num'];
			$ctrltd_dia = $_POST['ctrltd_dia'];
			$ctrltd_hrini = $_POST['ctrltd_hrini'].':'.$_POST['ctrltd_minini'];
			
			$ctrltd_hrfin = '';
			if($_POST['ctrltd_hrfin'] <> ''){
				$ctrltd_hrfin = $_POST['ctrltd_hrfin'].':'.$_POST['ctrltd_minfin'];
			}
			$lin_id = $_POST['lin_id'];
			$sup_rut = $_POST['sup_rut'];
			$oper_rut = $_POST['oper_rut'];			
			
			if($ctrltd_id == "" or $per_agno == "" or $sem_num == "" or $ctrltd_dia == "" or $_POST['ctrltd_hrini'] == "" or $_POST['ctrltd_minini'] == "" or $_POST['ctrltd_hrfin'] == "" or $_POST['ctrltd_minfin'] == "" or $lin_id == "" or $sup_rut == "" or $oper_rut == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}			
			/*
			if($_POST['ctrltd_hrfin'] <> '' and $_POST['ctrltd_minfin'] == ''){
				$resp = array('cod'=>'error','desc'=>'Error: Si selecciona hora de término debe indicar los minutos');
				salida($resp);
			}	

			if($_POST['ctrltd_hrfin'] == '' and $_POST['ctrltd_minfin'] <> ''){
				$resp = array('cod'=>'error','desc'=>'Error: Si selecciona min de término debe indicar la hora');
				salida($resp);
			}			
			*/
			//if($_POST['ctrltd_hrfin'] <> ''){
			
				$hrini = (int)$_POST['ctrltd_hrini'];
				$minini = (int)$_POST['ctrltd_minini'];
				$hrfin = (int)$_POST['ctrltd_hrfin'];
				$minfin = (int)$_POST['ctrltd_minfin'];
				
				if($hrini > $hrfin){
					$resp = array('cod'=>'error','desc'=>'Error: Hora de inicio no puede ser mayor a la hora de término');
					salida($resp);			
				}
				
				if($hrini == $hrfin and $minini > $minfin){
					$resp = array('cod'=>'error','desc'=>'Error: Hora de inicio no puede ser mayor a la hora de término');
					salida($resp);			
				}
					
			//}
			
			$sql = "SELECT DATE_FORMAT(ctrltd_dia,'%Y%m%d'), lin_id,ctrltd_hrini,ctrltd_hrfin FROM CONTROL_TIMEDEAD where ctrltd_id = $ctrltd_id";
			$resultado = mysqli_query($link,$sql);
			$fila = mysqli_fetch_row($resultado);
			$ctrltd_dia_bd = $fila[0];
			$lin_id_bd = $fila[1];
			
			$ctrltd_hrini_bd = $fila[2];
			$ctrltd_hrfin_bd = $fila[3];
			
			if($ctrltd_dia_bd <> $ctrltd_dia or $lin_id <> $lin_id_bd){
				$sql = "SELECT 1 FROM CONTROL_TIMEDEAD where ctrltd_dia = '$ctrltd_dia' and lin_id = '$lin_id'";
				$resultado = mysqli_query($link,$sql);
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Línea ya registrada para el día seleccionado');
					//$resp = array('cod'=>'error','desc'=>$ctrltd_dia_bd.' - '.$ctrltd_dia.' - '.$lin_id.' - '.$lin_id_bd);
					salida($resp);				
				}				
			}
		
			if($ctrltd_hrini_bd <> $ctrltd_hrini or $ctrltd_hrfin_bd <> $ctrltd_hrfin){
				$sql = "SELECT min(dctrltd_hrini),max(dctrltd_hrfin) FROM DCONTROL_TIMEDEAD where ctrltd_id = $ctrltd_id ";
				$resultado = mysqli_query($link,$sql);
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					
//VALIDACION HORA ENCABEZADO VS DETALLE

					$resultado = mysqli_query($link,$sql);
					$fila = mysqli_fetch_row($resultado);
					$dctrltd_hrini = $fila[0];
					$dctrltd_hrfin = $fila[1];

					$hrini1 = explode(":",$dctrltd_hrini);
					$hrini_detalle= (int)$hrini1[0];
					$minini_detalle = (int)$hrini1[1];

					//$resp = array('cod'=>'error','desc'=>$hrini.' - '.$minini.' - '.$hrini_detalle.' - '.$minini_detalle);
					//salida($resp);
					
					if($hrini > $hrini_detalle){				
						$resp = array('cod'=>'error','desc'=>'Error: Hora de inicio no puede ser mayor a una hora de tiempo muerto ya registrada');
						salida($resp);					
					}
					
					if($hrini_detalle == $hrini and $minini > $minini_detalle){				
						$resp = array('cod'=>'error','desc'=>'Error: Hora de inicio no puede ser mayor a una hora de tiempo muerto ya registrada');
						salida($resp);					
					}
					
					$hrfin1 = explode(":",$dctrltd_hrfin);
					$hrfin_detalle = (int)$hrfin1[0];
					$minfin_detalle = (int)$hrfin1[1];
					
					//$resp = array('cod'=>'error','desc'=>$hrfin.' - '.$minfin.' - '.$hrfin_detalle.' - '.$minfin_detalle);
					//salida($resp);					
					
					if($hrfin < $hrfin_detalle){				
						$resp = array('cod'=>'error','desc'=>'Error: Hora de término no puede ser menor a una hora de tiempo muerto ya registrada');
						salida($resp);					
					}
					
					if($hrfin_detalle == $hrfin and $minfin < $minfin_detalle){
						$resp = array('cod'=>'error','desc'=>'Error: Hora de término no puede ser menor a una hora de tiempo muerto ya registrada');
						salida($resp);					
					}
				}				
			}			
					
			$sql = "UPDATE CONTROL_TIMEDEAD SET per_agno = '$per_agno', sem_num = '$sem_num', ctrltd_dia = '$ctrltd_dia', ctrltd_hrini = '$ctrltd_hrini', 
			ctrltd_hrfin = '$ctrltd_hrfin', lin_id = '$lin_id', sup_rut = '$sup_rut', oper_rut = '$oper_rut' 			
			where ctrltd_id = $ctrltd_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
		}	
		
		elseif($operacion == 'DELETE'){
			
			$ctrltd_id = $_POST['ctrltd_id'];
			
			if($ctrltd_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			mysqli_autocommit($link, FALSE);		
			
			$sql = "DELETE FROM DCONTROL_TIMEDEAD where ctrltd_id = $ctrltd_id";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));			
			
			$sql = "DELETE FROM CONTROL_TIMEDEAD where ctrltd_id = $ctrltd_id";
			$resultado = mysqli_query($link,$sql)or die(salida_con_rollback($resp,$link));
			
			mysqli_commit($link);
		}	


//DETALLE TIEMPO MUERTO


		elseif($operacion == 'INSERT_DET'){
			
			$ctrltd_id = $_POST['ctrltd_id'];
			$undviv_id = $_POST['undviv_id'];
			$ctiempo_cod = $_POST['ctiempo_cod'];
			$dctrltd_hrini = $_POST['dctrltd_hrini'].':'.$_POST['dctrltd_minini'];
			$dctrltd_hrfin = $_POST['dctrltd_hrfin'].':'.$_POST['dctrltd_minfin'];
			$dctrltd_obs = $_POST['dctrltd_obs'];	
			
			if($ctrltd_id == "" or $undviv_id == "" or $ctiempo_cod == "" or $_POST['dctrltd_hrini'] == "" or $_POST['dctrltd_minini'] == "" or $_POST['dctrltd_hrfin'] == "" or $_POST['dctrltd_minfin'] == "" /*or $dctrltd_obs == ""*/){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$hrini = (int)$_POST['dctrltd_hrini'];
			$minini = (int)$_POST['dctrltd_minini'];
			$hrfin = (int)$_POST['dctrltd_hrfin'];
			$minfin = (int)$_POST['dctrltd_minfin'];
			
			if($hrini > $hrfin){
				$resp = array('cod'=>'error','desc'=>'Error: Hora de inicio no puede ser mayor a la hora de término');
				salida($resp);			
			}
			
			if($hrini == $hrfin and $minini > $minfin){
				$resp = array('cod'=>'error','desc'=>'Error: Hora de inicio no puede ser mayor a la hora de término');
				salida($resp);			
			}

			$sql = "SELECT ctrltd_hrini, ctrltd_hrfin FROM CONTROL_TIMEDEAD where ctrltd_id = $ctrltd_id";
			$resultado = mysqli_query($link,$sql);
			$fila = mysqli_fetch_row($resultado);
			$ctrltd_hrini = $fila[0];
			$ctrltd_hrfin = $fila[1];

			$hrini1 = explode(":",$ctrltd_hrini);
			$hrini_encabezado = (int)$hrini1[0];
			$minini_encabezado = (int)$hrini1[1];		

			if($hrini_encabezado > $hrini){				
				$resp = array('cod'=>'error','desc'=>'Error: Hora de inicio no puede ser menor a la hora del Encabezado');
				salida($resp);					
			}
			
			if($hrini_encabezado == $hrini and $minini_encabezado > $minini){				
				$resp = array('cod'=>'error','desc'=>'Error: Hora de inicio no puede ser menor a la hora del Encabezado');
				salida($resp);					
			}			
			
			//if($ctrltd_hrfin <> ''){
				$hrfin1 = explode(":",$ctrltd_hrfin);
				$hrfin_encabezado = (int)$hrfin1[0];
				$minfin_encabezado = (int)$hrfin1[1];
				
				if($hrfin_encabezado < $hrfin){				
					$resp = array('cod'=>'error','desc'=>'Error: Hora de término no puede ser mayor a la hora del Encabezado');
					salida($resp);					
				}
				
				if($hrfin_encabezado == $hrfin and $minfin_encabezado < $minfin){				
					$resp = array('cod'=>'error','desc'=>'Error: Hora de término no puede ser mayor a la hora del Encabezado');
					salida($resp);					
				}				
			//}			
			
			
			$sql = "SELECT 1 
			FROM DCONTROL_TIMEDEAD 
			WHERE CTRLTD_ID = $ctrltd_id
			AND (('$dctrltd_hrini' BETWEEN DCTRLTD_HRINI AND DCTRLTD_HRFIN) OR
			('$dctrltd_hrfin' BETWEEN DCTRLTD_HRINI AND DCTRLTD_HRFIN))";		
			$resultado = mysqli_query($link,$sql);
			$rowcount = mysqli_num_rows($resultado);
			
			if($rowcount > 0){
				$resp = array('cod'=>'error','desc'=>'Error: Horas solapadas!');
				salida($resp);				
			}			
			
			
			$sql = "INSERT INTO DCONTROL_TIMEDEAD(CTRLTD_ID,CTIEMPO_COD,DCTRLTD_HRINI,DCTRLTD_HRFIN,DCTRLTD_OBS) 
			values ('$ctrltd_id','$ctiempo_cod','$dctrltd_hrini','$dctrltd_hrfin','$dctrltd_obs')";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
		}
		
		elseif($operacion == 'UPDATE_DET'){
			
			$dctrltd_id = $_POST['dctrltd_id'];
			$ctrltd_id = $_POST['ctrltd_id'];
			$undviv_id = $_POST['undviv_id'];
			$ctiempo_cod = $_POST['ctiempo_cod'];
			$dctrltd_hrini = $_POST['dctrltd_hrini'].':'.$_POST['dctrltd_minini'];
			$dctrltd_hrfin = $_POST['dctrltd_hrfin'].':'.$_POST['dctrltd_minfin'];
			$dctrltd_obs = $_POST['dctrltd_obs'];	
			
			if($dctrltd_id == "" or $ctrltd_id == "" or $undviv_id == "" or $ctiempo_cod == "" or $_POST['dctrltd_hrini'] == "" or $_POST['dctrltd_minini'] == "" or $_POST['dctrltd_hrfin'] == "" or $_POST['dctrltd_minfin'] == "" /*or $dctrltd_obs == ""*/){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}
			
			$hrini = (int)$_POST['dctrltd_hrini'];
			$minini = (int)$_POST['dctrltd_minini'];
			$hrfin = (int)$_POST['dctrltd_hrfin'];
			$minfin = (int)$_POST['dctrltd_minfin'];
			
			if($hrini > $hrfin){
				$resp = array('cod'=>'error','desc'=>'Error: Hora de inicio no puede ser mayor a la hora de término');
				salida($resp);			
			}
			
			if($hrini == $hrfin and $minini > $minfin){
				$resp = array('cod'=>'error','desc'=>'Error: Hora de inicio no puede ser mayor a la hora de término');
				salida($resp);			
			}
			
			$sql = "SELECT ctrltd_hrini, ctrltd_hrfin FROM CONTROL_TIMEDEAD where ctrltd_id = $ctrltd_id";
			$resultado = mysqli_query($link,$sql);
			$fila = mysqli_fetch_row($resultado);
			$ctrltd_hrini = $fila[0];
			$ctrltd_hrfin = $fila[1];

			$hrini1 = explode(":",$ctrltd_hrini);
			$hrini_encabezado = (int)$hrini1[0];
			$minini_encabezado = (int)$hrini1[1];		

			if($hrini_encabezado > $hrini){				
				$resp = array('cod'=>'error','desc'=>'Error: Hora de inicio no puede ser menor a la hora del Encabezado');
				salida($resp);					
			}
			
			if($hrini_encabezado == $hrini and $minini_encabezado > $minini){				
				$resp = array('cod'=>'error','desc'=>'Error: Hora de inicio no puede ser menor a la hora del Encabezado');
				salida($resp);					
			}			
			
			//if($ctrltd_hrfin <> ''){
				$hrfin1 = explode(":",$ctrltd_hrfin);
				$hrfin_encabezado = (int)$hrfin1[0];
				$minfin_encabezado = (int)$hrfin1[1];
				
				if($hrfin_encabezado < $hrfin){				
					$resp = array('cod'=>'error','desc'=>'Error: Hora de término no puede ser mayor a la hora del Encabezado');
					salida($resp);					
				}
				
				if($hrfin_encabezado == $hrfin and $minfin_encabezado < $minfin){				
					$resp = array('cod'=>'error','desc'=>'Error: Hora de término no puede ser mayor a la hora del Encabezado');
					salida($resp);					
				}				
			//}		

			$sql = "SELECT dctrltd_hrini, dctrltd_hrfin FROM DCONTROL_TIMEDEAD where dctrltd_id = $dctrltd_id";
			$resultado = mysqli_query($link,$sql);
			$fila = mysqli_fetch_row($resultado);
			$dctrltd_hrini_bd = $fila[0];
			$dctrltd_hrfin_bd = $fila[1];

			if($dctrltd_hrini_bd <> $dctrltd_hrini or $dctrltd_hrfin_bd <> $dctrltd_hrfin){

				$sql = "SELECT 1 
				FROM DCONTROL_TIMEDEAD 
				WHERE CTRLTD_ID = $ctrltd_id
				AND (('$dctrltd_hrini' BETWEEN DCTRLTD_HRINI AND DCTRLTD_HRFIN) OR
				('$dctrltd_hrfin' BETWEEN DCTRLTD_HRINI AND DCTRLTD_HRFIN))";		
				$resultado = mysqli_query($link,$sql);
				$rowcount = mysqli_num_rows($resultado);
				
				if($rowcount > 0){
					$resp = array('cod'=>'error','desc'=>'Error: Horas solapadas!');
					salida($resp);				
				}
			}
			
			
			$sql = "UPDATE DCONTROL_TIMEDEAD SET ctiempo_cod = '$ctiempo_cod', dctrltd_hrini = '$dctrltd_hrini', 
			dctrltd_hrfin = '$dctrltd_hrfin', dctrltd_obs = '$dctrltd_obs'			
			where dctrltd_id = $dctrltd_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));
		}	
		
		elseif($operacion == 'DELETE_DET'){
			
			$dctrltd_id = $_POST['dctrltd_id'];
			
			if($dctrltd_id == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}	
			
			$sql = "DELETE FROM DCONTROL_TIMEDEAD where dctrltd_id = $dctrltd_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			

		}	

		elseif($operacion == 'UPDATE_MAN'){
			
			$ctrltd_id = $_POST['ctrltd_id'];
			$ctrltd_frcamboq = str_replace(",", ".",$_POST['ctrltd_frcamboq']);
			$ctrltd_cantcamboq = str_replace(",", ".",$_POST['ctrltd_cantcamboq']);
			$ctrltd_frlavboq = str_replace(",", ".",$_POST['ctrltd_frlavboq']);
			$ctrltd_cantlavboq = str_replace(",", ".",$_POST['ctrltd_cantlavboq']);
			
			if($ctrltd_id == "" or $ctrltd_frcamboq == "" or $ctrltd_cantcamboq == "" or $ctrltd_frlavboq == "" or $ctrltd_cantlavboq == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}	
			
			if($ctrltd_frcamboq > 0 and $ctrltd_cantcamboq == 0){
				$resp = array('cod'=>'error','desc'=>'Error: Si registras Frecuencia de cambio de boquillas debes indicar Cantidad mayor a 0');
				salida($resp);
			}

			if($ctrltd_frcamboq == 0 and $ctrltd_cantcamboq > 0){
				$resp = array('cod'=>'error','desc'=>'Error: Si registras Cantidad de cambio de boquillas debes indicar Frecuencia mayor a 0');
				salida($resp);
			}			
			
			if($ctrltd_frlavboq > 0 and $ctrltd_cantlavboq == 0){
				$resp = array('cod'=>'error','desc'=>'Error: Si registras Frecuencia de lavado debes indicar Cantidad mayor a 0');
				salida($resp);
			}

			if($ctrltd_frlavboq == 0 and $ctrltd_cantlavboq > 0){
				$resp = array('cod'=>'error','desc'=>'Error: Si registras Cantidad de lavado debes indicar Frecuencia mayor a 0');
				salida($resp);
			}	
			
			if($ctrltd_frcamboq > $ctrltd_cantcamboq){
				$resp = array('cod'=>'error','desc'=>'Error: Frecuencia de cambio de boquillas no puede ser mayor a la Cantidad');
				salida($resp);
			}			
			
			if($ctrltd_frlavboq > $ctrltd_cantlavboq){
				$resp = array('cod'=>'error','desc'=>'Error: Frecuencia de lavado de boquillas no puede ser mayor a la Cantidad');
				salida($resp);
			}			
		

			$sql = "UPDATE CONTROL_TIMEDEAD SET ctrltd_frcamboq = '$ctrltd_frcamboq', ctrltd_cantcamboq = '$ctrltd_cantcamboq', 
			ctrltd_frlavboq = '$ctrltd_frlavboq', ctrltd_cantlavboq = '$ctrltd_cantlavboq' 			
			where ctrltd_id = $ctrltd_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			

		}
		
		elseif($operacion == 'UPDATE_BAN88'){
			
			$ctrltd_id = $_POST['ctrltd_id'];
			$ctrltd_88buencorteza = str_replace(",", ".",$_POST['ctrltd_88buencorteza']);
			$ctrltd_88defcorteza = str_replace(",", ".",$_POST['ctrltd_88defcorteza']);
			$ctrltd_88buenturba = str_replace(",", ".",$_POST['ctrltd_88buenturba']);
			$ctrltd_88defturba = str_replace(",", ".",$_POST['ctrltd_88defturba']);
			$ctrltd_88buensanitizado = str_replace(",", ".",$_POST['ctrltd_88buensanitizado']);
			$ctrltd_88defsanitizado = str_replace(",", ".",$_POST['ctrltd_88defsanitizado']);
			
			if($ctrltd_id == "" or $ctrltd_88buencorteza == "" or $ctrltd_88defcorteza == "" or $ctrltd_88buenturba == "" or $ctrltd_88defturba == "" or $ctrltd_88buensanitizado == "" or $ctrltd_88defsanitizado == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}	
			
			$sql = "UPDATE CONTROL_TIMEDEAD SET ctrltd_88buencorteza = '$ctrltd_88buencorteza', ctrltd_88defcorteza = '$ctrltd_88defcorteza', 
			ctrltd_88buenturba = '$ctrltd_88buenturba', ctrltd_88defturba = '$ctrltd_88defturba',ctrltd_88buensanitizado = '$ctrltd_88buensanitizado', 
			ctrltd_88defsanitizado = '$ctrltd_88defsanitizado' 			
			where ctrltd_id = $ctrltd_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			

		}		
		
		elseif($operacion == 'UPDATE_BAN45'){
			
			$ctrltd_id = $_POST['ctrltd_id'];
			$ctrltd_45buencorteza = str_replace(",", ".",$_POST['ctrltd_45buencorteza']);
			$ctrltd_45defcorteza = str_replace(",", ".",$_POST['ctrltd_45defcorteza']);
			$ctrltd_45buenturba = str_replace(",", ".",$_POST['ctrltd_45buenturba']);
			$ctrltd_45defturba = str_replace(",", ".",$_POST['ctrltd_45defturba']);
			$ctrltd_45buensanitizado = str_replace(",", ".",$_POST['ctrltd_45buensanitizado']);
			$ctrltd_45defsanitizado = str_replace(",", ".",$_POST['ctrltd_45defsanitizado']);
			
			if($ctrltd_id == "" or $ctrltd_45buencorteza == "" or $ctrltd_45defcorteza == "" or $ctrltd_45buenturba == "" or $ctrltd_45defturba == "" or $ctrltd_45buensanitizado == "" or $ctrltd_45defsanitizado == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}	
			
			$sql = "UPDATE CONTROL_TIMEDEAD SET ctrltd_45buencorteza = '$ctrltd_45buencorteza', ctrltd_45defcorteza = '$ctrltd_45defcorteza', 
			ctrltd_45buenturba = '$ctrltd_45buenturba', ctrltd_45defturba = '$ctrltd_45defturba',ctrltd_45buensanitizado = '$ctrltd_45buensanitizado', 
			ctrltd_45defsanitizado = '$ctrltd_45defsanitizado' 			
			where ctrltd_id = $ctrltd_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			

		}		

		elseif($operacion == 'UPDATE_CONSUMO'){
			
			$ctrltd_id = $_POST['ctrltd_id'];
			$ctrltd_sacoturba = str_replace(",", ".",$_POST['ctrltd_sacoturba']);
			$ctrltd_sacoperlita = str_replace(",", ".",$_POST['ctrltd_sacoperlita']);
			$ctrltd_basacote = str_replace(",", ".",$_POST['ctrltd_basacote']);
			$ctrltd_osmocote = str_replace(",", ".",$_POST['ctrltd_osmocote']);
			$ctrltd_vermiculita = str_replace(",", ".",$_POST['ctrltd_vermiculita']);			
			
			if($ctrltd_id == "" or $ctrltd_sacoturba == "" or $ctrltd_sacoperlita == "" or $ctrltd_basacote == "" or $ctrltd_osmocote == "" or $ctrltd_vermiculita == ""){
				$resp = array('cod'=>'error','desc'=>'Ingresar dato obligatorio');
				salida($resp);
			}	
			
			$sql = "UPDATE CONTROL_TIMEDEAD SET ctrltd_sacoturba = '$ctrltd_sacoturba', ctrltd_sacoperlita = '$ctrltd_sacoperlita', 
			ctrltd_basacote = '$ctrltd_basacote', ctrltd_osmocote = '$ctrltd_osmocote',ctrltd_vermiculita = '$ctrltd_vermiculita'			
			where ctrltd_id = $ctrltd_id";
			$resultado = mysqli_query($link,$sql)or die(salida($resp));			

		}


		$resp = array('cod'=>'ok','operacion'=>$operacion);
	}
	

	echo json_encode($resp);



?>