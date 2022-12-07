<?php	
//header('Access-Control-Allow-Origin: *');
//header("Access-Control-Allow-Methods: GET, OPTIONS");	
/*
	$servidor = 'localhost';		
	$username = 'ingworld_sis2';		
	$password = 'sistemasweb2015';				
	$bd = 'ingworld_sisconvi_production2';	
	$link = mysqli_connect($servidor,$username,$password,$bd) or die(header ("Location:http://www.google.cl"));
	mysqli_set_charset($link, "utf8");
*/
/*
	$servidor = 'localhost';		
	$username = 'ingworld_sisprod';		
	$password = 'sistemasweb2015';				
	$bd = 'ingworld_sisconvi_production';	
	//$link = mysqli_connect($servidor,$username,$password,$bd) or die(header ("Location:https://www.google.cl"); exit;);
	$link = mysqli_connect($servidor,$username,$password,$bd) or die(header('Access-Control-Allow-Origin: https://www.google.cl', false););
	
	//Set Access-Control-Allow-Origin with PHP

	mysqli_set_charset($link, "utf8");
*/	

	$servidor = 'mysql1005.mochahost.com';		
	$username = 'ing2018_sisprod';		
	$password = 'sistemasweb2015';				
	$bd = 'ing2018_sisconvi_production';	
	//$link = mysqli_connect($servidor,$username,$password,$bd) or die(header ("Location:https://www.google.cl"); exit;);
	$enlace = mysqli_connect($servidor,$username,$password,$bd) or die(header('Access-Control-Allow-Origin: https://www.google.cl', false));
	
	//Set Access-Control-Allow-Origin with PHP

	mysqli_set_charset($link, "utf8");

if (!$enlace) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo "Éxito: Se realizó una conexión apropiada a MySQL! La base de datos mi_bd es genial." . PHP_EOL;
echo "Información del host: " . mysqli_get_host_info($enlace) . PHP_EOL;

mysqli_close($enlace);

?>