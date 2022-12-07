<?php	
error_reporting(0);
/*
	$servidor = 'mysql1005.mochahost.com';		
	$username = 'ing2018_ing_rec';		
	$password = 'sistemasweb2015';				
	$bd = 'ing2018__sisconvi_production_rec';	
	$link = mysqli_connect($servidor,$username,$password,$bd) or die(header ("Location:http://www.google.cl"));
	mysqli_set_charset($link, "utf8");
*/	

	$servidor = 'mysql1005.mochahost.com';		
	$username = 'ing2018_sisprod';		
	$password = 'sistemasweb2015';				
	$bd = 'ing2018_sisconvi_production';	
	$link = mysqli_connect($servidor,$username,$password,$bd) or die(header ("Location:http://www.google.cl"));
	mysqli_set_charset($link, "utf8");
	
?>