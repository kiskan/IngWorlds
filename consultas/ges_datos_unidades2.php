<?php 
	include('coneccion.php');
	
	$sql = "select und_id,und_nombre from UNIDAD";
	$resultado = mysqli_query($link,$sql)or die(mysqli_error($link));	
while($fetch = mysqli_fetch_array($resultado))
{
$output[] = array ($fetch[0],$fetch[1]);
}
//echo json_encode($output);
	$resp = array('data'=>$output);
	echo json_encode($resp);
	/*print_r($a);
	
	echo '<pre>';
	print_r($a);
	echo '</pre>'	*/
	
	
/*
	include('coneccion.php');
	
	$sql = "select und_id,und_nombre from UNIDAD";
	$resultado = mysqli_query($link,$sql)or die(mysqli_error($link));
	$rows = mysqli_num_rows($resultado);


	
    $rawdata = array(); //creamos un array

    //guardamos en un array multidimensional todos los datos de la consulta
    $i=0;

    while($row = mysqli_fetch_assoc($resultado))
    {
        $rawdata[$i] = $row;
        $i++;	
    }	
	
	
	$resp = array('data'=>$rawdata);	
	echo json_encode($resp);
	*/
	/*
	$a = json_encode($resp);
	echo '<pre>';
	print_r($a);
	echo '</pre>';*/

?>