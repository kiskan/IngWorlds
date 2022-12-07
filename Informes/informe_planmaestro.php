<?php

if(empty($_GET['per_agno']) or empty($_GET['per_mes']) or empty($_GET['sem_num'])){
	echo 'Error: Ausencia de período de búsqueda';
	exit;
}
else{
	ob_end_clean();
	require_once('PHPExcel.php');

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	$style0 = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 11
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		)	
	);
	
	$style1 = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 9
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		)	
	);	

	$style2 = array(
		'font'  => array(
			'size'  => 8
		),	
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		)	
	);	

	$style3 = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 9,
		)
	);	

	$style4 = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 8,
		),
	    'borders' => array(
		  'bottom' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN,
			  'color' => array('rgb' => 'F79646')
		  )
		 )
	);	
	
	$style5 = array(
		'font'  => array(
			'size'  => 8
		),	
	    'borders' => array(
		  'bottom' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN,
			  'color' => array('rgb' => 'FDE9D9')
		  )
		 )
	);	
	
	$style6 = array(
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		)	
	);	

	$style7 = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 8,
			'color' => array('rgb' => 'FFFFFF'),
		),	

		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'F79646')
		)		
	);	

	$style8 = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 9
		),	
		'fill' => array(
			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
			'rotation'   => 90,
			'startcolor' => array(
				'argb' => 'DAEEF3'
			),
			'endcolor'   => array(
				'argb' => 'FFFFFF'
			)
		),	
	    'borders' => array(
		  'outline' => array(
			  'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
			  'color' => array('rgb' => 'F79646')
		  )
		 )		
	);		
	
	$style9 = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => '0000FF'),
			'size'  => 9
		),	

		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'CCFFFF')
		),
	    'borders' => array(
		  'outline' => array(
			  'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
			  'color' => array('rgb' => 'F79646')
		  )
		 )		 		
	);		

	$style10 = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 11
		),	/*
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		),*/
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'CCFFFF')
		),	
	    'borders' => array(
		  'outline' => array(
			  'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
			  'color' => array('rgb' => 'F79646')
		  )
		 )	  
	);

	$style11 = array(
		'font'  => array(
			'bold'  => true,
			'color' => array('rgb' => 'FF0000')
		)	  
	);
	//VERDE
	$style12 = array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => '00B050')
		)	  
	);	
	//ROJO
	$style13 = array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'FF2301')
		)	  
	);
	//AMARILLO
	$style14 = array(
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'EDFF21')
		)	  
	);	

	
	$style15 = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 8
		),	
		'fill' => array(
			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
			'rotation'   => 90,
			'startcolor' => array(
				'argb' => 'DAEEF3'
			),
			'endcolor'   => array(
				'argb' => 'FFFFFF'
			)
		),	
	    'borders' => array(
		  'outline' => array(
			  'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
			  'color' => array('rgb' => 'F79646')
		  )
		 )		
	);	
	
	$style16 = array(
		'font'  => array(
			'size'  => 8
		)
	);	

	$style17 = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 8,
		)
	);
	
	//FONT SIZE 8
	$objPHPExcel->getActiveSheet()->getStyle('A1:P1000')->applyFromArray($style16);		
	
	

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Ing Worlds")
								 ->setLastModifiedBy("Ing Worlds")
								 ->setTitle("Informe Plan Maestro Sotrosur")
								 ->setSubject("Instalacion Mini, Macro y Pino")
								 ->setDescription("Produccion semanal")
								 ->setKeywords("planificacion plan maestro")
								 ->setCategory("Produccion Sotrosur");							 
						 
	//Orientation and Paper Size:ORIENTATION_LANDSCAPE 
	//->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	$objPHPExcel->getActiveSheet()
		->getPageSetup()
		->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	$objPHPExcel->getActiveSheet()
		->getPageSetup()
		->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		
	
	//$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
	
	//Page margins:
	/*
	$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.1);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.1);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.1);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.1);
	*/
	
	$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0);	
	
	$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
	
	
	//LINEAS DE DIVISION
	$objPHPExcel->getActiveSheet()->setShowGridLines(false);
								 
	//NUEVA PESTAÑA
	$objPHPExcel->setActiveSheetIndex(0)->setTitle('RESUMEN');
	$objPHPExcel->createSheet(1);	
	$objPHPExcel->setActiveSheetIndex(1)->setTitle('PLAN MAESTRO');
	
	//FIJARLA EN 1ERA PESTAÑA
	$objPHPExcel->setActiveSheetIndex(0);

	//OCULTAR PESTAÑA DATOS
	//$objPHPExcel->getSheetByName('Datos')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_VERYHIDDEN);
	
	//FONT FAMILY
	//$objPHPExcel->getDefaultStyle()->getFont()->setName('Tw Cent MT');
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	
	
	//DIMENSION FILAS
	$filas = 1;
	while($filas <  1000){
		$objPHPExcel->getActiveSheet(0)->getRowDimension($filas)->setRowHeight(11);
		$filas++;
	}
	
	//Autofit
	foreach (range('C', 'J') as $colD) {
		$objPHPExcel->getActiveSheet(0)->getColumnDimension($colD)->setAutoSize(TRUE);
	}	
	
	
	//$objPHPExcel->getActiveSheet(0)->getRowDimension(16)->setRowHeight(4);
	//$objPHPExcel->getActiveSheet(0)->getRowDimension(30)->setRowHeight(4);
	
	//DIMENSION COLUMNAS
	$objPHPExcel->getActiveSheet(0)->getColumnDimension('A')->setWidth(0.1);	
	$objPHPExcel->getActiveSheet(0)->getColumnDimension('B')->setWidth(20);	
/*	foreach(range('B','O') as $columnID) {
		if($columnID <> 'F' and $columnID <> 'K' ){
			$objPHPExcel->getActiveSheet(0)->getColumnDimension($columnID)->setWidth(7.5);
		}else{
			$objPHPExcel->getActiveSheet(0)->getColumnDimension($columnID)->setWidth(0.8);
		}	
	}
	
	$objPHPExcel->getActiveSheet(0)->getColumnDimension('P')->setWidth(0.5);
	$objPHPExcel->getActiveSheet(0)->getColumnDimension('Q')->setWidth(0.5);
*/

	
	
	/*
SELECT AREA.AREA_NOMBRE, PLAN.PLANM_DIA, SUM(PLAN.JORNADA) AS JORNADA   
			FROM AREA
            JOIN ACTIVIDAD AS ACT ON AREA.AREA_ID = ACT.AREA_ID
            LEFT JOIN PLAN_MAESTRO AS PLAN ON ACT.ACTIV_ID = PLAN.ACTIV_ID 
			JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
            WHERE PLAN.SEM_NUM = 32
            GROUP BY AREA.AREA_NOMBRE, PLAN.PLANM_DIA	
	
	*/
	
	
//PARAMETROS DE ENTRADA

	$per_agno = $_GET['per_agno'];
	$per_mes = $_GET['per_mes'];
	$sem_num = $_GET['sem_num'];
	
	$date = new DateTime;
	$date->setISODate(date('Y'), date('W'));
	$mes_actual = $date->format("m");

	$fecha_current = date('Y-m-d');
	

//BASE DE DATOS
	
	include('../consultas/coneccion.php');	

	
//TITULO - LOGO

	$meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
	$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");	
	$fecha_actual = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " de ".date('Y');
	
	$objPHPExcel->getActiveSheet(0)->mergeCells('C6:K6');	
	$objPHPExcel->getActiveSheet(0)->mergeCells('C7:K7');	
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C6', 'RESUMEN PROGRAMA DE PRODUCCIÓN SEMANA '.$sem_num)
				->setCellValue('C7', buscar_mes($per_mes).' '.$per_agno);				
		
		
	
		
	//DIMENSIÓN FILA TITULO
	$objPHPExcel->getActiveSheet(0)->getRowDimension(6)->setRowHeight(12);	
	
	$objPHPExcel->getActiveSheet(0)->getStyle('C6')->applyFromArray($style1);
	$objPHPExcel->getActiveSheet(0)->getStyle('C7')->applyFromArray($style2);
	
	//LOGO

	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('PHPExcel logo');
	$objDrawing->setDescription('PHPExcel logo');
	//$objDrawing->setPath('../images/logosotrosur_excel.png');
	$objDrawing->setPath('logosotrosur_informe.png');
	$objDrawing->setHeight(72);
	$objDrawing->setWidth(180);
	$objDrawing->setCoordinates('B2');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet(0));	

	
	//JORNADAS PLANIFICADAS POR AREA
	
	$objPHPExcel->getActiveSheet(0)->getStyle('B9')->applyFromArray($style3);
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B9', '1. Jornadas planificadas por área');
			
	$lunes  = date('Ymd', strtotime($per_agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));	
	$martes = date('Ymd', strtotime($lunes.' 1 day'));
	$miercoles = date('Ymd', strtotime($lunes.' 2 day'));
	$jueves = date('Ymd', strtotime($lunes.' 3 day'));
	$viernes = date('Ymd', strtotime($lunes.' 4 day'));
	$sabado = date('Ymd', strtotime($lunes.' 5 day'));
	
	$existe_sab = 0;
	$sql = "SELECT 1 FROM PLAN_MAESTRO WHERE PLANM_DIA = '$sabado'";
	$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
	$rowcount = mysqli_num_rows($resultado);
	
	if($rowcount > 0) $existe_sab = 1;
	
	if($existe_sab){
		$objPHPExcel->getActiveSheet(0)->getStyle('C11:J11')->applyFromArray($style1);/*
		$objPHPExcel->getActiveSheet(0)->getStyle('C11:H11')->applyFromArray($style3);		
		$objPHPExcel->getActiveSheet(0)->getStyle('I11')->applyFromArray($style3);	
		$objPHPExcel->getActiveSheet(0)->getStyle('J11')->applyFromArray($style3);	*/	
	}else{
		$objPHPExcel->getActiveSheet(0)->getStyle('C11:I11')->applyFromArray($style1);/*
		$objPHPExcel->getActiveSheet(0)->getStyle('C11:G11')->applyFromArray($style3);		
		$objPHPExcel->getActiveSheet(0)->getStyle('H11')->applyFromArray($style3);	
		$objPHPExcel->getActiveSheet(0)->getStyle('I11')->applyFromArray($style3);	*/	
	}
	
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueByColumnAndRow(2,11,'Lun')
				->setCellValueByColumnAndRow(3,11,'Mar')
				->setCellValueByColumnAndRow(4,11,'Mie')
				->setCellValueByColumnAndRow(5,11,'Jue')
				->setCellValueByColumnAndRow(6,11,'Vie');
	
	$col_current = 7;
	if($existe_sab){
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValueByColumnAndRow(7,11,'Sáb');
		$col_current = 8;
	}
				
	$objPHPExcel->setActiveSheetIndex(0)			
				->setCellValueByColumnAndRow($col_current,11,'Total')
				->setCellValueByColumnAndRow(++$col_current,11,'HH');		
	

	$sql = "
	select AREA_ID, AREA_NOMBRE,
	'$lunes' as LUN, 
	IFNULL(
	(SELECT SUM(PLAN.JORNADA)   
	FROM ACTIVIDAD AS ACT
	JOIN PLAN_MAESTRO AS PLAN ON ACT.ACTIV_ID = PLAN.ACTIV_ID 
	WHERE PLAN.PLANM_DIA = '$lunes' AND AREA.AREA_ID = ACT.AREA_ID),0)	as CANT1, 
	'$martes' as MAR, 
	IFNULL(
	(SELECT SUM(PLAN.JORNADA)   
	FROM ACTIVIDAD AS ACT
	JOIN PLAN_MAESTRO AS PLAN ON ACT.ACTIV_ID = PLAN.ACTIV_ID 
	WHERE PLAN.PLANM_DIA = '$martes' AND AREA.AREA_ID = ACT.AREA_ID),0) as CANT2, 
	'$miercoles' as MIE,
	IFNULL(
	(SELECT SUM(PLAN.JORNADA)   
	FROM ACTIVIDAD AS ACT
	JOIN PLAN_MAESTRO AS PLAN ON ACT.ACTIV_ID = PLAN.ACTIV_ID 
	WHERE PLAN.PLANM_DIA = '$miercoles' AND AREA.AREA_ID = ACT.AREA_ID),0) as CANT3, 	
	'$jueves' as JUE, 
	IFNULL(
	(SELECT SUM(PLAN.JORNADA)   
	FROM ACTIVIDAD AS ACT
	JOIN PLAN_MAESTRO AS PLAN ON ACT.ACTIV_ID = PLAN.ACTIV_ID 
	WHERE PLAN.PLANM_DIA = '$jueves' AND AREA.AREA_ID = ACT.AREA_ID),0) as CANT4, 
	'$viernes' as VIE, 
	IFNULL(
	(SELECT SUM(PLAN.JORNADA)   
	FROM ACTIVIDAD AS ACT
	JOIN PLAN_MAESTRO AS PLAN ON ACT.ACTIV_ID = PLAN.ACTIV_ID 
	WHERE PLAN.PLANM_DIA = '$viernes' AND AREA.AREA_ID = ACT.AREA_ID),0) as CANT5, 	
	'$sabado' as SAB, 
	IFNULL(
	(SELECT SUM(PLAN.JORNADA)   
	FROM ACTIVIDAD AS ACT
	JOIN PLAN_MAESTRO AS PLAN ON ACT.ACTIV_ID = PLAN.ACTIV_ID 
	WHERE PLAN.PLANM_DIA = '$sabado' AND AREA.AREA_ID = ACT.AREA_ID),0) as CANT6 	
	from AREA AS AREA";	
	$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));

	//$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current.':E'.$row_current)->applyFromArray($style7);
	//$objPHPExcel->getActiveSheet(0)->getStyle()->applyFromArray($style16);
	$row_current = 12;
	while( $rows = mysqli_fetch_assoc($resultado) ) {
	
		//$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current)->applyFromArray($style16);
	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,$row_current,$rows[AREA_NOMBRE]);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,$row_current,$rows[CANT1]);	
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,$row_current,$rows[CANT2]);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$row_current,$rows[CANT3]);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,$row_current,$rows[CANT4]);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$row_current,$rows[CANT5]);

		if($existe_sab){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$row_current,$rows[CANT6]);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8,$row_current,'=SUM(C'.$row_current.':H'.$row_current.')');
			$total = $objPHPExcel->getActiveSheet(0)->getCell('I'.$row_current)->getCalculatedValue();
			$hh = $total * 8.25;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9,$row_current,$hh);
		}else{
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$row_current,'=SUM(C'.$row_current.':G'.$row_current.')');
			$total = $objPHPExcel->getActiveSheet(0)->getCell('H'.$row_current)->getCalculatedValue();
			$hh = $total * 8.25;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8,$row_current,$hh);			
		}		
		
		//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($col_current,$row_current,'=SUM(C'.$sum_ini.':C'.$sum_fin.')');
		
		$row_current++;
	}
	
	$fila_suma = $row_current - 1;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,$row_current,'TOTAL');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,$row_current,'=SUM(C12:C'.$fila_suma.')');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,$row_current,'=SUM(D12:D'.$fila_suma.')');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$row_current,'=SUM(E12:E'.$fila_suma.')');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,$row_current,'=SUM(F12:F'.$fila_suma.')');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$row_current,'=SUM(G12:G'.$fila_suma.')');
	
	if($existe_sab){
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$row_current,'=SUM(H12:H'.$fila_suma.')');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8,$row_current,'=SUM(I12:I'.$fila_suma.')');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9,$row_current,'=SUM(J12:J'.$fila_suma.')');
		$objPHPExcel->getActiveSheet(0)->getStyle('B12:J'.$row_current)->applyFromArray($style16);
		$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current.':J'.$row_current)->applyFromArray($style17);
	}else{
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$row_current,'=SUM(H12:H'.$fila_suma.')');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8,$row_current,'=SUM(I12:I'.$fila_suma.')');
		$objPHPExcel->getActiveSheet(0)->getStyle('B12:I'.$row_current)->applyFromArray($style16);
		$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current.':I'.$row_current)->applyFromArray($style17);
	}
	
	$total_grupo_datos = $row_current - 12;
	//$total_grupo_datos = 13;
	//$fila_suma = 24;
	
	
	
//PIE CHART

	//  Set the Labels for each data series we want to plot
	//    Datatype
	//    Cell reference for data
	//    Format Code
	//    Number of datapoints in series
	//    Data values
	//    Data Marker
	/*
	$dataseriesLabels1 = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'RESUMEN!$B$12:$B$'.$fila_suma, NULL, $total_grupo_datos),
	  
	);*/

	$dataSeriesLabels1 = array();
	
	//  Set the X-Axis Labels
	//    Datatype
	//    Cell reference for data
	//    Format Code
	//    Number of datapoints in series
	//    Data values
	//    Data Marker

	$xAxisTickValues1 = array(
	  new PHPExcel_Chart_DataSeriesValues('String', 'RESUMEN!$B$12:$B$'.$fila_suma, NULL, $total_grupo_datos),  
	);
	

	
	//  Set the Data values for each data series we want to plot
	//    Datatype
	//    Cell reference for data
	//    Format Code
	//    Number of datapoints in series
	//    Data values
	//    Data Marker

	$dataSeriesValues1 = array(
	  new PHPExcel_Chart_DataSeriesValues('Number', 'RESUMEN!$H$12:$H$'.$fila_suma, NULL, $total_grupo_datos),
	);
//PHPExcel_Chart_DataSeries::GROUPING_STANDARD,     // plotGrouping
	//  Build the dataseries
	$series1 = new PHPExcel_Chart_DataSeries(
		PHPExcel_Chart_DataSeries::TYPE_PIECHART_3D,       // plotType
		null,     // plotGrouping
		range(0, count($dataSeriesValues1)-1),          // plotOrder
		$dataseriesLabels1,                   // plotLabel
		$xAxisTickValues1,                    // plotCategory
		$dataSeriesValues1,                    // plotValues
		null,
		null,
		true	  
	);

	

	//  Set up a layout object for the Pie chart
	$layout1 = new PHPExcel_Chart_Layout();
	$layout1->setShowVal(false);
	$layout1->setShowPercent(true);
	$layout1->setShowCatName(true); 
	

	
	$series1->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
	//  Set the series in the plot area
	$plotarea1 = new PHPExcel_Chart_PlotArea($layout1, array($series1));
	//$plotArea1 = new PHPExcel_Chart_PlotArea(NULL, array($series1));
	
	
	$layout2 = new PHPExcel_Chart_Layout();
	$layout2->setWidth(60);
	$layout2->setHeight(60);
	$layout2->setYPosition(0);
	
	//  Set the chart legend
	$legend1 = new PHPExcel_Chart_Legend('');
	//POSITION_RIGHT
	//$legend1 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, $layout2, false);
	//$legend1 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

	//$title1 = new PHPExcel_Chart_Title('Distribución semanal jornadas por área');
	$title1 = new PHPExcel_Chart_Title('');
/*
	//  Create the chart
	$chart1 = new PHPExcel_Chart(
	  'chart1',   // name
	  $title1,    // title
	  $legend1,   // legend
	  $plotarea1,   // plotArea
	  true,     // plotVisibleOnly
	  0,        // displayBlanksAs
	  NULL,     // xAxisLabel
	  NULL      // yAxisLabel   - Pie charts don't have a Y-Axis
	);
*/


	//  Create the chart
	$chart1 = new PHPExcel_Chart(
	  'chart1',   // name
	  $title1,    // title
	   NULL, // legend $legend1,
	  $plotarea1,   // plotArea
	  true,     // plotVisibleOnly
	  0,        // displayBlanksAs
	  NULL,     // xAxisLabel
	  NULL      // yAxisLabel   - Pie charts don't have a Y-Axis
	);


	//	Set the position where the chart should appear in the worksheet
	$chart1->setTopLeftPosition('K12');
	//$chart1->setBottomRightPosition('P28');
	$chart1->setBottomRightPosition('Q'.($row_current-1));

	//	Add the chart to the worksheet
	$objWorksheet = $objPHPExcel->getActiveSheet(0);
	$objWorksheet->addChart($chart1);
	//$objPHPExcel->getActiveSheet(0)->addChart($chart1);
//////////////////////////////////////////////////////////////////////////	
	
	
	
	
	
	
	
	//FIJARLA EN 2DA PESTAÑA
	$objPHPExcel->setActiveSheetIndex(1);
	
	//Orientation and Paper Size:ORIENTATION_LANDSCAPE 
	$objPHPExcel->getActiveSheet()
		->getPageSetup()
		->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$objPHPExcel->getActiveSheet()
		->getPageSetup()
		->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
	
	$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
	
	//Page margins:
	$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.1);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.1);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.1);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.1);
	
	//LINEAS DE DIVISION
	$objPHPExcel->getActiveSheet()->setShowGridLines(false);	
	
	//LOGO
	/*
	$objDrawing2 = new PHPExcel_Worksheet_Drawing();
	$objDrawing2->setName('PHPExcel logo');
	$objDrawing2->setDescription('PHPExcel logo');
	$objDrawing2->setPath('logosotrosur_informe.png');
	$objDrawing2->setHeight(72);
	$objDrawing2->setWidth(180);
	$objDrawing2->setCoordinates('B2');
	$objDrawing2->setWorksheet($objPHPExcel->getActiveSheet());		
	*/
	//DIMENSION FILAS
	$filas = 1;
	while($filas <  1000){
		$objPHPExcel->getActiveSheet()->getRowDimension($filas)->setRowHeight(11);
		$filas++;
	}
	
	//DIMENSION COLUMNAS
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(0.5);	
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(22);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(19);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(27);
	
	
	//FONT SIZE 8
	$objPHPExcel->getActiveSheet()->getStyle('A1:P1000')->applyFromArray($style16);

	//DIMENSIÓN FILA TITULO
	$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(12);	
	
	$objPHPExcel->getActiveSheet()->getStyle('E6')->applyFromArray($style0);
	
	
	$objPHPExcel->setActiveSheetIndex(1)
				->setCellValue('E6', 'PLANIFICACIÓN DE LA PRODUCCIÓN SEMANA '.$sem_num);	
				
	
	$objPHPExcel->setActiveSheetIndex(1)
				->setCellValueByColumnAndRow(1,8,'Área')
				->setCellValueByColumnAndRow(2,8,'Subárea')
				->setCellValueByColumnAndRow(3,8,'Actividad/Tarea')
				->setCellValueByColumnAndRow(4,8,'Rend')
				->setCellValueByColumnAndRow(5,8,'Lun')
				->setCellValueByColumnAndRow(6,8,'Mar')
				->setCellValueByColumnAndRow(7,8,'Mie')
				->setCellValueByColumnAndRow(8,8,'Jue')
				->setCellValueByColumnAndRow(9,8,'Vie');
				
	if($existe_sab)	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(10,8,'Sáb');		
			
	$objPHPExcel->getActiveSheet(1)->getStyle('B8:D8')->applyFromArray($style17);
	$objPHPExcel->getActiveSheet(1)->getStyle('E8:K8')->applyFromArray($style1);
	
/*
select 1 AS ID, AREA.AREA_NOMBRE, ACTIV.ACTIV_NOMBRE, MET.MET_UNDXHR * 8.25 AS REND,
	'20180806' as LUN, 
	IFNULL((SELECT PLANM.JORNADA * 8.25 * MET.MET_UNDXHR  
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180806' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA1, 
	'20180807' as MAR, 
	IFNULL((SELECT PLANM.JORNADA * 8.25 * MET.MET_UNDXHR  
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180807' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA2, 
	'20180808' as MIE,
	IFNULL((SELECT PLANM.JORNADA * 8.25 * MET.MET_UNDXHR  
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180808' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA3, 	
	'20180809' as JUE, 
	IFNULL((SELECT PLANM.JORNADA * 8.25 * MET.MET_UNDXHR  
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180809' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA4, 
	'20180810' as VIE, 
	IFNULL((SELECT PLANM.JORNADA * 8.25 * MET.MET_UNDXHR  
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180810' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA5, 	
	'20180811' as SAB, 
	IFNULL((SELECT PLANM.JORNADA * 8.25 * MET.MET_UNDXHR  
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180811' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA6 	
	FROM AREA
	JOIN ACTIVIDAD AS ACTIV ON AREA.AREA_ID = ACTIV.AREA_ID
	JOIN PLAN_MAESTRO AS PLAN ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID 
	JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
	JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND '20180806'>= MET.MET_INIVIG AND (MET.MET_FINVIG IS NULL OR '20180806'<= MET.MET_FINVIG)
	WHERE PLAN.SEM_NUM = 32	
   UNION
select 2 AS ID, AREA.AREA_NOMBRE, ACTIV.ACTIV_NOMBRE, IFNULL(MET.MET_UNDXHR,0) * 8.25 AS REND,
	'20180806' as LUN, 
	IFNULL((SELECT PLANM.JORNADA  
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180806' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA1, 
	'20180807' as MAR, 
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180807' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA2, 
	'20180808' as MIE,
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180808' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA3, 	
	'20180809' as JUE, 
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180809' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA4, 
	'20180810' as VIE, 
	IFNULL((SELECT PLANM.JORNADA  
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180810' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA5, 	
	'20180811' as SAB, 
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180811' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA6 	
	FROM AREA
	JOIN ACTIVIDAD AS ACTIV ON AREA.AREA_ID = ACTIV.AREA_ID
	JOIN PLAN_MAESTRO AS PLAN ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID 
	JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
	LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND '20180806'>= MET.MET_INIVIG AND (MET.MET_FINVIG IS NULL OR '20180806'<= MET.MET_FINVIG)
	WHERE PLAN.SEM_NUM = 32	AND ACTIV.ACTIV_TIPO = 'PRODUCTIVA'  
    UNION
select 3 AS ID, AREA.AREA_NOMBRE, ACTIV.ACTIV_NOMBRE, IFNULL(MET.MET_UNDXHR,0) * 8.25 AS REND,
	'20180806' as LUN, 
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180806' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA1, 
	'20180807' as MAR, 
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180807' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA2, 
	'20180808' as MIE,
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180808' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA3, 	
	'20180809' as JUE, 
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180809' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA4, 
	'20180810' as VIE, 
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180810' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA5, 	
	'20180811' as SAB, 
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '20180811' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA6 	
	FROM AREA
	JOIN ACTIVIDAD AS ACTIV ON AREA.AREA_ID = ACTIV.AREA_ID
	JOIN PLAN_MAESTRO AS PLAN ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID 
	JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
	LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND '20180806'>= MET.MET_INIVIG AND (MET.MET_FINVIG IS NULL OR '20180806'<= MET.MET_FINVIG)
	WHERE PLAN.SEM_NUM = 32	AND ACTIV.ACTIV_TIPO = 'APOYO'   
  order by ID, AREA_NOMBRE, ACTIV_NOMBRE
*/	
	$sql = "
	select AREA.AREA_NOMBRE, 1 AS ID, ACTIV.ACTIV_NOMBRE, '' AS RENDIMIENTO, 
	IFNULL((SELECT PLANM.PROD_ESPERADA /*PLANM.JORNADA * 8.25 * MET.MET_UNDXHR */ 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$lunes' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA1, 
	IFNULL((SELECT PLANM.PROD_ESPERADA /*PLANM.JORNADA * 8.25 * MET.MET_UNDXHR */   
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$martes' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA2, 
	IFNULL((SELECT PLANM.PROD_ESPERADA /*PLANM.JORNADA * 8.25 * MET.MET_UNDXHR */   
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$miercoles' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA3, 	
	IFNULL((SELECT PLANM.PROD_ESPERADA /*PLANM.JORNADA * 8.25 * MET.MET_UNDXHR */  
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$jueves' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA4, 
	IFNULL((SELECT PLANM.PROD_ESPERADA /*PLANM.JORNADA * 8.25 * MET.MET_UNDXHR */   
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$viernes' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA5, 	
	IFNULL((SELECT PLANM.PROD_ESPERADA /*PLANM.JORNADA * 8.25 * MET.MET_UNDXHR */   
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$sabado' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA6 	
	FROM AREA
	JOIN ACTIVIDAD AS ACTIV ON AREA.AREA_ID = ACTIV.AREA_ID
	JOIN PLAN_MAESTRO AS PLAN ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID 
	JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
	JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND '$lunes'>= MET.MET_INIVIG AND (MET.MET_FINVIG IS NULL OR '$lunes'<= MET.MET_FINVIG)
	WHERE PLAN.SEM_NUM = $sem_num AND ACTIV.ACTIV_TIPO = 'PRODUCTIVA'	
	
	UNION
	
	select AREA.AREA_NOMBRE, 2 AS ID, ACTIV.ACTIV_NOMBRE, IFNULL(MET.MET_UNDXHR,0) * 8.25 AS RENDIMIENTO, 
	IFNULL((SELECT PLANM.JORNADA  
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$lunes' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA1, 
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$martes' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA2, 
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$miercoles' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA3, 	
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$jueves' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA4, 
	IFNULL((SELECT PLANM.JORNADA  
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$viernes' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA5, 	
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$sabado' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA6 	
	FROM AREA
	JOIN ACTIVIDAD AS ACTIV ON AREA.AREA_ID = ACTIV.AREA_ID
	JOIN PLAN_MAESTRO AS PLAN ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID 
	JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
	LEFT JOIN METAS AS MET ON MET.ACTIV_ID = ACTIV.ACTIV_ID AND '$lunes'>= MET.MET_INIVIG AND (MET.MET_FINVIG IS NULL OR '$lunes'<= MET.MET_FINVIG)
	WHERE PLAN.SEM_NUM = $sem_num AND ACTIV.ACTIV_TIPO = 'PRODUCTIVA'	
	
	UNION
	
	select AREA.AREA_NOMBRE, 3 AS ID, ACTIV.ACTIV_NOMBRE, '' AS RENDIMIENTO, 
	IFNULL((SELECT PLANM.JORNADA  
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$lunes' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA1, 
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$martes' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA2, 
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$miercoles' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA3, 	
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$jueves' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA4, 
	IFNULL((SELECT PLANM.JORNADA  
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$viernes' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA5, 	
	IFNULL((SELECT PLANM.JORNADA 
	FROM PLAN_MAESTRO AS PLANM 
	WHERE PLANM.PLANM_DIA = '$sabado' AND PLANM.ACTIV_ID = ACTIV.ACTIV_ID),0) as PROD_ESPERADA6 	
	FROM AREA
	JOIN ACTIVIDAD AS ACTIV ON AREA.AREA_ID = ACTIV.AREA_ID
	JOIN PLAN_MAESTRO AS PLAN ON ACTIV.ACTIV_ID = PLAN.ACTIV_ID 
	JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
	WHERE PLAN.SEM_NUM = $sem_num AND ACTIV.ACTIV_TIPO = 'APOYO'		
	
	ORDER BY AREA_NOMBRE, ID, ACTIV_NOMBRE
	";	
	$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
	
	$row_current = 9;
	
	$fila = mysqli_fetch_row($resultado);
	$area_target = $fila[0];
	
	$cel_ini_suma = '';
	
	$sum_lunes = 0;$sum_martes = 0;$sum_miercoles = 0;$sum_jueves = 0;$sum_viernes = 0;$sum_sabado = 0;
	//$objPHPExcel->getActiveSheet()->mergeCells('A18:E22');
	while( $rows = mysqli_fetch_assoc($resultado) ) {
	
		$area = $rows[AREA_NOMBRE];
		
		if($area_target <> $area){ 
			$area_target = $area;
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(3,$row_current,'SUBTOTAL REQUERIMIENTO JORNADAS');
			
			$cel_fin_suma = $row_current - 1;
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(5,$row_current,'=SUM(F'.$cel_ini_suma.':F'.$cel_fin_suma.')');	
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(6,$row_current,'=SUM(G'.$cel_ini_suma.':G'.$cel_fin_suma.')');	
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(7,$row_current,'=SUM(H'.$cel_ini_suma.':H'.$cel_fin_suma.')');	
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(8,$row_current,'=SUM(I'.$cel_ini_suma.':I'.$cel_fin_suma.')');	
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(9,$row_current,'=SUM(J'.$cel_ini_suma.':J'.$cel_fin_suma.')');	
			if($existe_sab) $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(10,$row_current,'=SUM(K'.$cel_ini_suma.':K'.$cel_fin_suma.')');
			
			$sum_lunes += $objPHPExcel->getActiveSheet(0)->getCell('F'.$row_current)->getCalculatedValue();
			$sum_martes += $objPHPExcel->getActiveSheet(0)->getCell('G'.$row_current)->getCalculatedValue();
			$sum_miercoles += $objPHPExcel->getActiveSheet(0)->getCell('H'.$row_current)->getCalculatedValue();
			$sum_jueves += $objPHPExcel->getActiveSheet(0)->getCell('I'.$row_current)->getCalculatedValue();
			$sum_viernes += $objPHPExcel->getActiveSheet(0)->getCell('J'.$row_current)->getCalculatedValue();
			if($existe_sab) $sum_sabado += $objPHPExcel->getActiveSheet(0)->getCell('K'.$row_current)->getCalculatedValue();
			
			$objPHPExcel->getActiveSheet(0)->getStyle('D'.$row_current.':K'.$row_current)->applyFromArray($style17);
			
			$cel_ini_suma = '';
			$row_current++;
		}	
		
		$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(1,$row_current,$rows[AREA_NOMBRE]);
		
		if($rows[ID] == 1) $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(2,$row_current,'PRODUCCIÓN ESPERADA');
		if($rows[ID] == 2){
			if($cel_ini_suma == '') $cel_ini_suma = $row_current;
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(2,$row_current,'ACTIVIDADES PRODUCTIVAS');
		} 
		if($rows[ID] == 3){
			if($cel_ini_suma == '') $cel_ini_suma = $row_current;
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(2,$row_current,'ACTIVIDADES DE APOYO');
		} 
		

		$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(3,$row_current,$rows[ACTIV_NOMBRE]);
		$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(4,$row_current,$rows[RENDIMIENTO]);
		$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(5,$row_current,$rows[PROD_ESPERADA1]);
		$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(6,$row_current,$rows[PROD_ESPERADA2]);
		$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(7,$row_current,$rows[PROD_ESPERADA3]);
		$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(8,$row_current,$rows[PROD_ESPERADA4]);
		$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(9,$row_current,$rows[PROD_ESPERADA5]);
		if($existe_sab) $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(10,$row_current,$rows[PROD_ESPERADA6]);
		
		
		$row_current++;
	}	
	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(3,$row_current,'SUBTOTAL REQUERIMIENTO JORNADAS');
	
	$cel_fin_suma = $row_current - 1;
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(5,$row_current,'=SUM(F'.$cel_ini_suma.':F'.$cel_fin_suma.')');	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(6,$row_current,'=SUM(G'.$cel_ini_suma.':G'.$cel_fin_suma.')');	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(7,$row_current,'=SUM(H'.$cel_ini_suma.':H'.$cel_fin_suma.')');	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(8,$row_current,'=SUM(I'.$cel_ini_suma.':I'.$cel_fin_suma.')');	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(9,$row_current,'=SUM(J'.$cel_ini_suma.':J'.$cel_fin_suma.')');	
	if($existe_sab) $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(10,$row_current,'=SUM(K'.$cel_ini_suma.':K'.$cel_fin_suma.')');	

	$sum_lunes += $objPHPExcel->getActiveSheet(0)->getCell('F'.$row_current)->getCalculatedValue();
	$sum_martes += $objPHPExcel->getActiveSheet(0)->getCell('G'.$row_current)->getCalculatedValue();
	$sum_miercoles += $objPHPExcel->getActiveSheet(0)->getCell('H'.$row_current)->getCalculatedValue();
	$sum_jueves += $objPHPExcel->getActiveSheet(0)->getCell('I'.$row_current)->getCalculatedValue();
	$sum_viernes += $objPHPExcel->getActiveSheet(0)->getCell('J'.$row_current)->getCalculatedValue();
	if($existe_sab) $sum_sabado += $objPHPExcel->getActiveSheet(0)->getCell('K'.$row_current)->getCalculatedValue();	
	
	$objPHPExcel->getActiveSheet(0)->getStyle('D'.$row_current.':K'.$row_current)->applyFromArray($style17);	
	
	$row_current = $row_current + 3;
	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(2,$row_current,'GLOBAL');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(3,$row_current,'DEMANDA JORNADAS');
	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(5,$row_current,$sum_lunes);
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(6,$row_current,$sum_martes);
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(7,$row_current,$sum_miercoles);
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(8,$row_current,$sum_jueves);
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(9,$row_current,$sum_viernes);
	if($existe_sab) $objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(10,$row_current,$sum_sabado);
	
	$row_global = $row_current+3;
	$objPHPExcel->getActiveSheet(0)->getStyle('C'.$row_current.':K'.$row_global)->applyFromArray($style17);
	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(3,$row_current+1,'JORNADAS DISPONIBLES');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(3,$row_current+2,'AUSENCIAS DECLARADAS');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(3,$row_current+3,'DÉFICIT/SUPERÁVIT (JORNADAS)');
	
	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="informe_planmaestro.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->setIncludeCharts(TRUE);
	
	$objWriter->save('php://output');
	exit;
	
	
	
}

	

function buscar_mes($per_mes){
	$nom_mes = '';
	switch($per_mes){
		case '01':
			$nom_mes = 'ENERO';
		break;
		case '02':
			$nom_mes = 'FEBRERO';
		break;	
		case '03':
			$nom_mes = 'MARZO';
		break;
		case '04':
			$nom_mes = 'ABRIL';
		break;	
		case '05':
			$nom_mes = 'MAYO';
		break;
		case '06':
			$nom_mes = 'JUNIO';
		break;	
		case '07':
			$nom_mes = 'JULIO';
		break;
		case '08':
			$nom_mes = 'AGOSTO';
		break;
		case '09':
			$nom_mes = 'SEPTIEMBRE';
		break;
		case '10':
			$nom_mes = 'OCTUBRE';
		break;	
		case '11':
			$nom_mes = 'NOVIEMBRE';
		break;
		case '12':
			$nom_mes = 'DICIEMBRE';
		break;		
	}
	
	return $nom_mes;
} 


function dias_semana($objPHPExcel, $col, $fil, $per_agno, $sem_num, $hoja){
	
	$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
	
	//DIAS DE SEMANA
	$lunes  = date('Ymd', strtotime($per_agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));	
	$martes = date('Ymd', strtotime($lunes.' 1 day'));
	$miercoles = date('Ymd', strtotime($lunes.' 2 day'));
	$jueves = date('Ymd', strtotime($lunes.' 3 day'));
	$viernes = date('Ymd', strtotime($lunes.' 4 day'));
	$sabado = date('Ymd', strtotime($lunes.' 5 day'));

	$lunes_text = date("d", strtotime($lunes)).'/'.$meses[date("n", strtotime($lunes))-1];
	$martes_text = date("d", strtotime($martes)).'/'.$meses[date("n", strtotime($martes))-1];
	$miercoles_text = date("d", strtotime($miercoles)).'/'.$meses[date("n", strtotime($miercoles))-1];
	$jueves_text = date("d", strtotime($jueves)).'/'.$meses[date("n", strtotime($jueves))-1];
	$viernes_text = date("d", strtotime($viernes)).'/'.$meses[date("n", strtotime($viernes))-1];
	$sabado_text = date("d", strtotime($sabado)).'/'.$meses[date("n", strtotime($sabado))-1];
	

	$objPHPExcel->setActiveSheetIndex($hoja)
				->setCellValueByColumnAndRow($col,$fil,$lunes_text)
				->setCellValueByColumnAndRow($col,$fil+1,$martes_text)
				->setCellValueByColumnAndRow($col,$fil+2,$miercoles_text)
				->setCellValueByColumnAndRow($col,$fil+3,$jueves_text)
				->setCellValueByColumnAndRow($col,$fil+4,$viernes_text)
				->setCellValueByColumnAndRow($col,$fil+5,$sabado_text);
}


function dias_semana_grafico($objPHPExcel, $col, $fil, $per_agno, $sem_num, $hoja, $diasnoprod){

	$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

	$lunes  = date('Ymd', strtotime($per_agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));	
	if(!in_array($lunes, $diasnoprod)) {
		//$lunes_text = date("d/M", strtotime($lunes));
		$lunes_text = date("d", strtotime($lunes)).'/'.$meses[date("n", strtotime($lunes))-1];
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$lunes_text);
		$fil++;
	}
	
	$martes = date('Ymd', strtotime($lunes.' 1 day'));
	if(!in_array($martes, $diasnoprod)) {
		//$martes_text = date("d/M", strtotime($martes));		
		$martes_text = date("d", strtotime($martes)).'/'.$meses[date("n", strtotime($martes))-1];		
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$martes_text);
		$fil++;
	}	

	$miercoles = date('Ymd', strtotime($lunes.' 2 day'));
	if(!in_array($miercoles, $diasnoprod)) {
		//$miercoles_text = date("d/M", strtotime($miercoles));
		$miercoles_text = date("d", strtotime($miercoles)).'/'.$meses[date("n", strtotime($miercoles))-1];
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$miercoles_text);
		$fil++;
	}	
	
	$jueves = date('Ymd', strtotime($lunes.' 3 day'));
	if(!in_array($jueves, $diasnoprod)) {
		//$jueves_text = date("d/M", strtotime($jueves));
		$jueves_text = date("d", strtotime($jueves)).'/'.$meses[date("n", strtotime($jueves))-1];
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$jueves_text);
		$fil++;
	}
	
	$viernes = date('Ymd', strtotime($lunes.' 4 day'));
	if(!in_array($viernes, $diasnoprod)) {
		//$viernes_text = date("d/M", strtotime($viernes));
		$viernes_text = date("d", strtotime($viernes)).'/'.$meses[date("n", strtotime($viernes))-1];
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$viernes_text);
		$fil++;
	}	
	
	$sabado = date('Ymd', strtotime($lunes.' 5 day'));
	if(!in_array($sabado, $diasnoprod)) {
		//$sabado_text = date("d/M", strtotime($sabado));	
		$sabado_text = date("d", strtotime($sabado)).'/'.$meses[date("n", strtotime($sabado))-1];
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$sabado_text);
		$fil++;
	}		

}


function fill_cumplimiento($activ_id, $row, $cant,$objPHPExcel,$meta_mini,$meta_pino,$meta_macro){
	if($cant > 0){
		//$meta_mini = 70000;$meta_pino = 80000;$meta_macro = 90000;
		switch($activ_id){
			case 123: //MINI 1ERA
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,$row,$cant);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,$row,$meta_mini);
				//$cumplimiento =round( ($cant*100)/$meta_mini, 0);
				if($meta_mini == 0){
					$cumplimiento = '';
				}else{
					$cumplimiento =$cant/$meta_mini;
				}
				
				
				//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$row,$cumplimiento.'%');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$row,$cumplimiento);	
			break;					
			case 59: //PINO 2DA
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$row,$cant);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8,$row,$meta_pino);
				
				if($meta_pino == 0){
					$cumplimiento = '';
					}else{
					$cumplimiento =$cant/$meta_pino;
				}				
				
				
				//$cumplimiento = $cant/$meta_pino;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9,$row,$cumplimiento);						
			break;
			case 135: //MACRO 3ERA
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12,$row,$cant);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13,$row,$meta_macro);
			
				if($meta_macro == 0){
					$cumplimiento = '';
					}else{
					$cumplimiento =$cant/$meta_macro;
				}			
				
				//$cumplimiento = $cant/$meta_macro;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14,$row,$cumplimiento);						
			break;						
		}
	}		
}


function fill_cumplimiento_datos($activ_id, $row, $cant,$objPHPExcel){
	if($cant > 0){

		switch($activ_id){
			case 123: //MINI 1ERA
				$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(10,$row,$cant);
			break;					
			case 59: //PINO 2DA
				$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(11,$row,$cant);					
			break;
			case 135: //MACRO 3ERA
				$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(12,$row,$cant);						
			break;						
		}
	}		
}	

//Referencia Excel Mes de Mayo, ajustado a 21 días
function dias_trab_xtrab(){

	$day_current = date('j');
	$retorno = '';
	switch($day_current){
		
		case 1:
		case 2:
			$retorno = '1-20';			
		break;

		case 3:
			$retorno = '2-19';			
		break;

		case 4:
			$retorno = '3-18';			
		break;
		
		case 5:
		case 6:
		case 7:
			$retorno = '4-17';			
		break;

		case 8:
			$retorno = '5-16';			
		break;

		case 9:
			$retorno = '6-15';			
		break;

		case 10:
			$retorno = '7-14';			
		break;	

		case 11:
			$retorno = '8-13';			
		break;	

		case 12:
		case 13:
		case 14:
			$retorno = '9-12';			
		break;

		case 15:
			$retorno = '10-11';			
		break;			
		
		case 16:
			$retorno = '11-10';			
		break;

		case 17:
			$retorno = '12-9';			
		break;

		case 18:
			$retorno = '13-8';			
		break;			
		
		case 19:
		case 20:
		case 21:
			$retorno = '14-7';			
		break;			
		
		case 22:
			$retorno = '15-6';			
		break;

		case 23:
			$retorno = '16-5';			
		break;

		case 24:
			$retorno = '17-4';			
		break;

		case 25:
			$retorno = '18-3';			
		break;

		case 26:
		case 27:
		case 28:
			$retorno = '19-2';			
		break;

		case 29:
			$retorno = '20-1';			
		break;			

		case 30:
			$retorno = '21-0';			
		break;

		case 31:
			$retorno = '22-0';			
		break;
		
		default:
			$retorno = '1-0';
		break;
		
	}

	return $retorno;
}

function fondo_condicional($objPHPExcel,$letra,$cell,$fin,$style12,$style13,$style14){
	//$objPHPExcel->setActiveSheetIndex(0);
	while( $cell <= $fin ){
		
		$celda_rend = $objPHPExcel->setActiveSheetIndex(0)->getCell($letra.$cell)->getValue();	
	
		if($celda_rend <> ''){
			
			if($celda_rend >= 0.95){
				$objPHPExcel->setActiveSheetIndex(0)->getStyle($letra.$cell)->applyFromArray($style12); //VERDE
			}elseif($celda_rend < 0.8){
				$objPHPExcel->setActiveSheetIndex(0)->getStyle($letra.$cell)->applyFromArray($style13); //ROJO
			}else{
				$objPHPExcel->setActiveSheetIndex(0)->getStyle($letra.$cell)->applyFromArray($style14); //AMARILLO
			}
			
		}
		
		$cell++;
	}		
}
	
?>