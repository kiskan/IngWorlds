<?php 

	include('coneccion.php');

	$sql = "select cmn_codigo,cmn_nombre from COMUNA where reg_codigo = 8 order by cmn_nombre";	
	$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
	$data = array();
	
	while( $rows = mysqli_fetch_assoc($resultset) ) {
		$data[] = $rows;
	}					

	$load_comunas = json_encode($data);
		
?>