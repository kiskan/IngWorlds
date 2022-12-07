<?php
/*
date_default_timezone_set("Chile/Continental");
echo "La hora en Chile es: " . date ("d/m/Y H:i",time()) . "<br />";
$fecha_ultreg = date("Ymd H:i:s",time());
echo $fecha_ultreg;*/
$agno = 2018;
$lunes  = date('Ymd', strtotime($agno . 'W' . str_pad(52 , 2, '0', STR_PAD_LEFT)));

$fecha = '20180206';
$x = date('N', strtotime($fecha));

$diax = 1;
$martes = date('Ymd', strtotime($lunes.' '.$diax.' day'));

echo $martes;
?>

