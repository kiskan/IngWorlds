<?php

if(date('W') != 1){
	$per_agno = date('Y');	
	$sem_num = date('W')-1;	
	$date = new DateTime;	
	$date->setISODate(date('Y'), date('W'));	
	$per_mes = $date->format("m");	
}else{

	$per_agno = date('Y')-1;	
	$sem_num = getIsoWeeksInYear($per_agno);		
	$per_mes = 12;	
}

	
$url = 'http://ing-worlds.cl/proyecto/sisconvi-production/Informes/informe_semanal.php?per_agno='.$per_agno.'&per_mes='.$per_mes.'&sem_num='.$sem_num.'&clave=6SkLqV4GlSgig4jr9XtF';	

//ENVIO DE EMAIL

	require("class.phpmailer.php");
	$mail = new PHPMailer();
	
	$mail->IsSMTP();	
	$mail->Host = "mail.ing-worlds.cl";
	$mail->SMTPAuth = true;
	$mail->Port = 25; 	
	$mail->Username = "operaciones@ing-worlds.cl";  		
	$mail->Password = "sistemasweb2015";		
	$mail->CharSet  = 'UTF-8';
	
	$mail->From = "mcordero@sotrosur.cl";
	$mail->FromName = 'Planificación y Control Producción';		
	//$mail->AddAddress("cristian.ieci@gmail.com","Cristian Cabrera");
	
	$mail->AddAddress("rramirez1925@gmail.com","Rodrigo Ramírez");
	$mail->AddAddress("mictmict@gmail.com","Rodrigo Ramírez");	
	
	
	$mail->AddAddress("rramirez@sotrosur.cl","Rodrigo Ramírez");
	$mail->AddAddress("mcordero@sotrosur.cl","Marcelo Cordero");
	
	//$mail->AddAddress("jjunemann@sotrosur.cl",""); //solicitado sacarlo de la lista el 03/07/2018
	$mail->AddAddress("nneira@sotrosur.cl","");
	$mail->AddAddress("svergara@sotrosur.cl","");
	//$mail->AddAddress("jhinojosa@sotrosur.cl",""); //solicitado sacarlo de la lista el 03/07/2018	
	
	$mail->AddAddress("alex.aedo@sotrosur.cl","Alex Aedo");
	$mail->AddAddress("cristian.pena@sotrosur.cl","Cristian Pena");
	$mail->AddAddress("esteban.fuentealba@sotrosur.cl","Esteban Fuentealba");
	
	$mail->AddBCC("cristian.ieci@gmail.com","Cristian Cabrera");
	$mail->AddBCC("l.melgarejo.u@gmail.com","Leonardo Melgarejo");
	$mail->AddBCC("operaciones@ing-worlds.cl","Ing-Worlds");
	
	$mensaje = '<br>Informe semanal SOTROSUR de la semana '.$sem_num.' del año '.$per_agno.'<br><br> Haga clic en el siguiente enlace para visualizarlo: <br><br>'.$url.'<br><br>* No contestar este correo<br><br><br>Planificación y Estudio';
	
	$asunto = 'Informe semanal SOTROSUR';	
	$mail->WordWrap = 50;                              
	$mail->IsHTML(true);                               
	$mail->Subject  =  $asunto;
	$mail->Body     =  $mensaje;
	$mail->AltBody  =  $mensaje;


	if(!$mail->Send()) {
		echo 'MENSAJE NO ENVIADO: ' . $mail->ErrorInfo;
	} else {
		echo 'MENSAJE ENVIADO';
	}	
	
	function getIsoWeeksInYear($year) {
		$date = new DateTime;
		$date->setISODate($year, 53);
		return ($date->format("W") === "53" ? 53 : 52);
	}
	
?>