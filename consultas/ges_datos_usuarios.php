<?php 

include("coneccion.php");

	$sql = "SELECT USR_RUT, USR_CLAVE, USR_ESTADO, USR_EMAIL, USR_TIPO, USR_NOMBRE FROM USUARIOS";	
	$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
	$data = array();

	while( $rows = mysqli_fetch_assoc($resultset) ) {
		$data[] = $rows;
	}

	$resultado = array(
	"sEcho" => 1,
	"iTotalRecords" => count($data),
	"iTotalDisplayRecords" => count($data),
	"aaData"=>$data);

	echo json_encode($resultado);	

?>