<?php 
	date_default_timezone_set("Chile/Continental");
	$fecha_reg = date("Y-m-d H:i:s",time());	

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

	}
	
	//Envío de email STOCK MINIMO
	function enviar_email_stockmin(){

	}
	
	//Envío de email producto
	function enviar_email_producto($sprod_id,$cotcom_id){			
	
	}
	
	//Envío de email compra terminada
	function enviar_email_compra_terminada($sprod_id,$sprod_id_new){				
	
	}	
	
	//Envío de email producto(SOLICITUD DE COMPRA)
	function enviar_email_solproducto($sprod_id){				
	
	}

	//Envío de email producto (SOLICITUD DE MATERIAL)
	function enviar_email_solproducto_materiales($sprod_id){
				
	
	}		

?>