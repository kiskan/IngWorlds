<?php  

if(empty($_GET['per_agno']) or empty($_GET['per_mes']) or empty($_GET['sem_num'])){
	echo 'Error: Ausencia de período de búsqueda';
	exit;
}
else{

	$per_agno = $_GET['per_agno'];
	$per_mes = $_GET['per_mes'];
	$sem_num = $_GET['sem_num'];

	include('../consultas/coneccion.php');	
	
/*	
	if($sem_num == -1){
		$ultimo_dia = date('t',mktime(0,0,0,$per_mes,1,$per_agno));
		$SEM_FECHAINI_INF = $per_agno.$per_mes.'01';
		$SEM_FECHAFIN_INF = $per_agno.$per_mes.$ultimo_dia;
		$SEM_FECHAINI_INF_PRINT = '01/'.$per_mes.'/'.$per_agno;
		$SEM_FECHAFIN_INF_PRINT = $ultimo_dia.'/'.$per_mes.'/'.$per_agno;
	}
	else{
	
		$sqlfechainf = "SELECT SEM_FECHAINI_INF, SEM_FECHAFIN_INF, 
		DATE_FORMAT(SEM_FECHAINI_INF,'%d/%m/%Y') as SEM_FECHAINI_INF_PRINT, DATE_FORMAT(SEM_FECHAFIN_INF,'%d/%m/%Y') as SEM_FECHAFIN_INF_PRINT 
		FROM SEMANAS WHERE PER_AGNO = $per_agno AND SEM_NUM = $sem_num";
		$resultado = mysqli_query($link, $sqlfechainf) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$SEM_FECHAINI_INF = $fila[0];$SEM_FECHAFIN_INF = $fila[1];$SEM_FECHAINI_INF_PRINT = $fila[2];$SEM_FECHAFIN_INF_PRINT = $fila[3];	
	}	
*/	
	
	
	
	$sqlfechainf = "SELECT DATE_FORMAT(SEM_FECHAINI,'%d/%m/%Y') as SEM_FECHAINI, DATE_FORMAT(SEM_FECHAFIN,'%d/%m/%Y') as SEM_FECHAFIN	
	FROM SEMANAS WHERE PER_AGNO = $per_agno AND SEM_NUM = $sem_num";
	$resultado = mysqli_query($link, $sqlfechainf) or die("database error:". mysqli_error($link));
	$fila = mysqli_fetch_row($resultado);	
	$SEM_FECHAINI = $fila[0];$SEM_FECHAFIN = $fila[1];
	
		
	$lunes  = date('Ymd', strtotime($per_agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));	
	$martes = date('Ymd', strtotime($lunes.' 1 day'));
	$miercoles = date('Ymd', strtotime($lunes.' 2 day'));
	$jueves = date('Ymd', strtotime($lunes.' 3 day'));
	$viernes = date('Ymd', strtotime($lunes.' 4 day'));
	$sabado = date('Ymd', strtotime($lunes.' 5 day'));	

	//Lunes
	$sql_lunes_asistentes = "
	SELECT COUNT(DISTINCT OPER_RUT)
	FROM PLANIFICACION_OPER 
	WHERE PLAN_DIA = '$lunes' 
	AND PLANO_ASIST = 'S'
	";

	$resultado = mysqli_query($link, $sql_lunes_asistentes) or die("database error:". mysqli_error($link));  
	$asist_lunes = mysqli_fetch_row($resultado);
	$count_lunes_asistentes = $asist_lunes[0];

	$sql_lunes_total = "
	SELECT COUNT(DISTINCT OPER_RUT)
	FROM PLANIFICACION_OPER 
	WHERE PLAN_DIA = '$lunes' 
	";

	$resultado = mysqli_query($link, $sql_lunes_total) or die("database error:". mysqli_error($link));  
	$asist_total_lunes = mysqli_fetch_row($resultado);
	$count_lunes_no_asistentes = $asist_total_lunes[0] - $count_lunes_asistentes;

	
	//Martes
	$sql_martes_asistentes = "
	SELECT COUNT(DISTINCT OPER_RUT)
	FROM PLANIFICACION_OPER 
	WHERE PLAN_DIA = '$martes' 
	AND PLANO_ASIST = 'S'
	";

	$resultado = mysqli_query($link, $sql_martes_asistentes) or die("database error:". mysqli_error($link));  
	$asist_martes = mysqli_fetch_row($resultado);
	$count_martes_asistentes = $asist_martes[0];

	$sql_martes_total = "
	SELECT COUNT(DISTINCT OPER_RUT)
	FROM PLANIFICACION_OPER 
	WHERE PLAN_DIA = '$martes' 
	";

	$resultado = mysqli_query($link, $sql_martes_total) or die("database error:". mysqli_error($link));  
	$asist_total_martes = mysqli_fetch_row($resultado);
	$count_martes_no_asistentes = $asist_total_martes[0] - $count_martes_asistentes;	
	
	
	//Miercoles
	$sql_miercoles_asistentes = "
	SELECT COUNT(DISTINCT OPER_RUT)
	FROM PLANIFICACION_OPER 
	WHERE PLAN_DIA = '$miercoles' 
	AND PLANO_ASIST = 'S'
	";

	$resultado = mysqli_query($link, $sql_miercoles_asistentes) or die("database error:". mysqli_error($link));  
	$asist_miercoles = mysqli_fetch_row($resultado);
	$count_miercoles_asistentes = $asist_miercoles[0];

	$sql_miercoles_total = "
	SELECT COUNT(DISTINCT OPER_RUT)
	FROM PLANIFICACION_OPER 
	WHERE PLAN_DIA = '$miercoles' 
	";

	$resultado = mysqli_query($link, $sql_miercoles_total) or die("database error:". mysqli_error($link));  
	$asist_total_miercoles = mysqli_fetch_row($resultado);
	$count_miercoles_no_asistentes = $asist_total_miercoles[0] - $count_miercoles_asistentes;	
	
	
	//Jueves
	$sql_jueves_asistentes = "
	SELECT COUNT(DISTINCT OPER_RUT)
	FROM PLANIFICACION_OPER 
	WHERE PLAN_DIA = '$jueves' 
	AND PLANO_ASIST = 'S'
	";

	$resultado = mysqli_query($link, $sql_jueves_asistentes) or die("database error:". mysqli_error($link));  
	$asist_jueves = mysqli_fetch_row($resultado);
	$count_jueves_asistentes = $asist_jueves[0];

	$sql_jueves_total = "
	SELECT COUNT(DISTINCT OPER_RUT)
	FROM PLANIFICACION_OPER 
	WHERE PLAN_DIA = '$jueves' 
	";

	$resultado = mysqli_query($link, $sql_jueves_total) or die("database error:". mysqli_error($link));  
	$asist_total_jueves = mysqli_fetch_row($resultado);
	$count_jueves_no_asistentes = $asist_total_jueves[0] - $count_jueves_asistentes;	
	

	
	//Viernes
	$sql_viernes_asistentes = "
	SELECT COUNT(DISTINCT OPER_RUT)
	FROM PLANIFICACION_OPER 
	WHERE PLAN_DIA = '$viernes' 
	AND PLANO_ASIST = 'S'
	";

	$resultado = mysqli_query($link, $sql_viernes_asistentes) or die("database error:". mysqli_error($link));  
	$asist_viernes = mysqli_fetch_row($resultado);
	$count_viernes_asistentes = $asist_viernes[0];

	$sql_viernes_total = "
	SELECT COUNT(DISTINCT OPER_RUT)
	FROM PLANIFICACION_OPER 
	WHERE PLAN_DIA = '$viernes' 
	";

	$resultado = mysqli_query($link, $sql_viernes_total) or die("database error:". mysqli_error($link));  
	$asist_total_viernes = mysqli_fetch_row($resultado);
	$count_viernes_no_asistentes = $asist_total_viernes[0] - $count_viernes_asistentes;	
	
	
	//Sabado
	$sql_sabado_asistentes = "
	SELECT COUNT(DISTINCT OPER_RUT)
	FROM PLANIFICACION_OPER 
	WHERE PLAN_DIA = '$sabado' 
	AND PLANO_ASIST = 'S'
	";

	$resultado = mysqli_query($link, $sql_sabado_asistentes) or die("database error:". mysqli_error($link));  
	$asist_sabado = mysqli_fetch_row($resultado);
	$count_sabado_asistentes = $asist_sabado[0];

	$sql_sabado_total = "
	SELECT COUNT(DISTINCT OPER_RUT)
	FROM PLANIFICACION_OPER 
	WHERE PLAN_DIA = '$sabado' 
	";

	$resultado = mysqli_query($link, $sql_sabado_total) or die("database error:". mysqli_error($link));  
	$asist_total_sabado = mysqli_fetch_row($resultado);
	$count_sabado_no_asistentes = $asist_total_sabado[0] - $count_sabado_asistentes;	
	
	
}
?> 


<!DOCTYPE html>
<html lang="en">
  <head>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="../../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">	
	
    <title>Ings-Sisconvi-Production | Ings-Worlds</title>
	<script type="text/javascript" src="fusioncharts.js"></script>
	
	<script type="text/javascript" src="fusioncharts.charts.js"></script>
	
	<script type="text/javascript" src="fusioncharts.theme.fint.js"></script>

	
	<script type="text/javascript">
	FusionCharts.ready(function () {
    var revenueChart = new FusionCharts({
        type: 'msbar3d',
        renderAt: 'chart-container',
        width: '800',
        height: '600',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Asistencia Semanal de lo Planificado",
                //"subCaption": "In top 5 stores last month",
                "yAxisname": "Del total planificado",
                //"numberPrefix": "$",
                "paletteColors": "#0075c2,#1aaf5d",
                "bgColor": "#ffffff",
                "legendBorderAlpha": "0",
                "legendBgAlpha": "0",
                "legendShadow": "0",
                "placevaluesInside": "1",
                "valueFontColor": "#ffffff",                
                "alignCaptionWithCanvas": "1",
                "showHoverEffect":"1",
                "canvasBgColor": "#ffffff",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "divlineColor": "#999999",
                "divLineIsDashed": "1",
                "divLineDashLen": "1",
                "divLineGapLen": "1",
                "showAlternateHGridColor": "0",
                "toolTipColor": "#ffffff",
                "toolTipBorderThickness": "0",
                "toolTipBgColor": "#000000",
                "toolTipBgAlpha": "80",
                "toolTipBorderRadius": "2",
                "toolTipPadding": "5"
            },            
            "categories": [
                {
                    "category": [
                        {
                            "label": "Lunes"
                        }, 
                        {
                            "label": "Martes"
                        }, 
                        {
                            "label": "Miércoles"
                        }, 
                        {
                            "label": "Jueves"
                        }, 
                        {
                            "label": "Viernes"
                        }, 
                        {
                            "label": "Sábado"
                        }
                    ]
                }
            ],           
            "dataset": [
                {
                    "seriesname": "Asistencias",
                    "data": [
                        {
                            "value":<?php echo $count_lunes_asistentes; ?>
                        }, 
                        {
                            "value":<?php echo $count_martes_asistentes; ?>
                        }, 
                        {
                            "value":<?php echo $count_miercoles_asistentes; ?>
                        }, 
                        {
                            "value":<?php echo $count_jueves_asistentes; ?>
                        }, 
                        {
                            "value":<?php echo $count_viernes_asistentes; ?>
                        }, 
                        {
                            "value":<?php echo $count_sabado_asistentes; ?>
                        }
                    ]
                }, 
                {
                    "seriesname": "Ausencias",
                    "data": [
                        {
                            "value":<?php echo $count_lunes_no_asistentes; ?>
                        }, 
                        {
                            "value":<?php echo $count_martes_no_asistentes; ?>
                        }, 
                        {
                            "value":<?php echo $count_miercoles_no_asistentes; ?>
                        }, 
                        {
                            "value":<?php echo $count_jueves_no_asistentes; ?>
                        }, 
                        {
                            "value":<?php echo $count_viernes_no_asistentes; ?>
                        }, 
                        {
                            "value":<?php echo $count_sabado_no_asistentes; ?>
                        }
                    ]
                }
            ]
        }
    })
    .render();
});
	
;
	</script>
</head>
<body style = "padding:10px; margin:0;">
<div style="padding:10px">
<img src="logosotrosur_informe.png" />
<br><br>
<span style="font-size:18px; font-weight:bold">Informe Asistencia <?php echo $SEM_FECHAINI; ?> al <?php echo $SEM_FECHAFIN; ?>
</span><br>
</div>
		<div class="row">
		  <div class="col-md-1"></div>
		  <div class="col-md-10"><div id="chart-container"></div> </div>
		  <div class="col-md-1"></div>
		</div>
<br>
</body>
</html>