<?php

if(empty($_GET['per_agno']) or empty($_GET['per_mes']) or empty($_GET['sem_num']) or empty($_GET['plan_dia'])){
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
			'size'  => 14
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
			'size'  => 10
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
	
///////////////////////////////////////////////////	
	
	$style18 = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 9,
		),
	    'borders' => array(
		  'bottom' => array( //allborders
			  'style' => PHPExcel_Style_Border::BORDER_THIN
		  )
		 ),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'EDFF21')
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		)		 		 
	);		
	
	$style19 = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 9,
		),
	    'borders' => array(
		  'allborders' => array( //allborders
			  'style' => PHPExcel_Style_Border::BORDER_THIN
		  )
		 ),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => '24E711')
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		)		 		 
	);	
	
	$style20 = array(
		'font'  => array(
			'bold'  => true,
			'size'  => 9,
		),
	    'borders' => array(
		  'bottom' => array( //allborders
			  'style' => PHPExcel_Style_Border::BORDER_THIN
		  ),
		  'right' => array( //allborders
			  'style' => PHPExcel_Style_Border::BORDER_THIN
		  )		  
		 ),
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'EDFF21')
		),
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		)		 		 
	);	
	
	
	
	$style21 = array(
	    'borders' => array(
		  'allborders' => array( //allborders
			  'style' => PHPExcel_Style_Border::BORDER_THIN
		  )
		 )		 		 
	);		
	
	

	
	
	
	//FONT SIZE 8
	$objPHPExcel->getActiveSheet()->getStyle('A1:P1000')->applyFromArray($style16);		
	
	

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Ing Worlds")
								 ->setLastModifiedBy("Ing Worlds")
								 ->setTitle("Informe Fertilizacion Sotrosur")
								 ->setCategory("Produccion Sotrosur");							 
						 
	//Orientation and Paper Size:ORIENTATION_LANDSCAPE 
	//->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);

	

	
	
//PARAMETROS DE ENTRADA

	$per_agno = $_GET['per_agno'];
	$per_mes = $_GET['per_mes'];
	$sem_num = $_GET['sem_num'];
	$plan_dia = $_GET['plan_dia'];
	

	
$dia_formateado = date_create($plan_dia);

$dia_formateado = date_format($dia_formateado, 'd-m-Y');	
	
	$date = new DateTime;
	$date->setISODate(date('Y'), date('W'));
	$mes_actual = $date->format("m");

	$fecha_current = date('Y-m-d');
	

//BASE DE DATOS
	
	include('../consultas/coneccion.php');	

	

	
	

	
	$sql = "select CTRLAGUA_ID,CTRLAGUA_HORA,CTRLAGUA_TK2,CTRLAGUA_TK3,CTRLAGUA_TK4,CTRLAGUA_CE,CTRLAGUA_PH from CONTROL_AGUA where ctrlagua_dia ='$plan_dia' ORDER BY CTRLAGUA_HORA";
	$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
	
	$pestagna = 0;
	while( $rows = mysqli_fetch_assoc($resultado) ) {
	
		if($pestagna > 0){
			$objPHPExcel->createSheet();
		}
		$CTRLAGUA_ID = $rows[CTRLAGUA_ID];
		$CTRLAGUA_HORA = str_replace(":",".",$rows[CTRLAGUA_HORA]);		
		$objPHPExcel->setActiveSheetIndex($pestagna)->setTitle($CTRLAGUA_HORA);
	
		$objPHPExcel->getActiveSheet($pestagna)
			->getPageSetup()
			->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
		$objPHPExcel->getActiveSheet($pestagna)
			->getPageSetup()
			->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
		
		$objPHPExcel->getActiveSheet($pestagna)->getPageMargins()->setTop(0);
		$objPHPExcel->getActiveSheet($pestagna)->getPageMargins()->setRight(0);
		$objPHPExcel->getActiveSheet($pestagna)->getPageMargins()->setLeft(0);
		$objPHPExcel->getActiveSheet($pestagna)->getPageMargins()->setBottom(0);	
		
		$objPHPExcel->getActiveSheet($pestagna)->getPageSetup()->setFitToPage(true);
		$objPHPExcel->getActiveSheet($pestagna)->getPageSetup()->setFitToWidth(1);
		$objPHPExcel->getActiveSheet($pestagna)->getPageSetup()->setFitToHeight(0);
		
		//BORDERS C15:Q44
		$objPHPExcel->getActiveSheet($pestagna)->getStyle('C15:Q44')->applyFromArray($style21);	
		
		
		//LINEAS DE DIVISION
		$objPHPExcel->getActiveSheet($pestagna)->setShowGridLines(false);
		
		//FONT FAMILY
		$objPHPExcel->getDefaultStyle($pestagna)->getFont()->setName('Calibri');	
		
		//DIMENSION FILAS
		$filas = 1;
		while($filas <  1000){
			$objPHPExcel->getActiveSheet($pestagna)->getRowDimension($filas)->setRowHeight(12);
			$filas++;
		}


		//DIMENSION COLUMNAS
		$objPHPExcel->getActiveSheet($pestagna)->getColumnDimension('A')->setWidth(0.5);		
	
	
	
	
	
	
	

	

		//$objPHPExcel->setActiveSheetIndex($pestagna);

		
	//TITULO - LOGO
		
		$objPHPExcel->getActiveSheet($pestagna)->mergeCells('C5:Q5');	
		$objPHPExcel->getActiveSheet($pestagna)->mergeCells('C6:Q6');	
		
		$objPHPExcel->setActiveSheetIndex($pestagna)
					->setCellValue('C5', 'RESUMEN CE Y PH DE PLANTAS MADRES '.$rows[CTRLAGUA_HORA].' HRS')
					->setCellValue('C6', $dia_formateado);				
			
			
		
			
		//DIMENSIÓN FILA TITULO

		$objPHPExcel->getActiveSheet($pestagna)->getRowDimension(5)->setRowHeight(16);	
		
		$objPHPExcel->getActiveSheet($pestagna)->getStyle('C5')->applyFromArray($style0);
		$objPHPExcel->getActiveSheet($pestagna)->getStyle('C6')->applyFromArray($style2);
		
		//LOGO

		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('PHPExcel logo');
		$objDrawing->setDescription('PHPExcel logo');
		//$objDrawing->setPath('../images/logosotrosur_excel.png');
		$objDrawing->setPath('logosotrosur_informe.png');
		$objDrawing->setHeight(72);
		$objDrawing->setWidth(180);
		$objDrawing->setCoordinates('B2');
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet($pestagna));			
		
		
		
		
	
	//INYECCION
		$objPHPExcel->getActiveSheet($pestagna)->mergeCells('C8:D8');		
		$objPHPExcel->setActiveSheetIndex($pestagna)->setCellValue('C8', 'INYECCION');
		$objPHPExcel->getActiveSheet($pestagna)->getStyle('C8:D8')->applyFromArray($style18);			
		
		$objPHPExcel->setActiveSheetIndex($pestagna)
					->setCellValue('C9', 'TK2')
					->setCellValue('C10', 'TK3')
					->setCellValue('C11', 'TK4');
					
		$objPHPExcel->getActiveSheet($pestagna)->getStyle('C9:C11')->applyFromArray($style3);			

		$objPHPExcel->setActiveSheetIndex($pestagna)
					->setCellValue('D9', $rows[CTRLAGUA_TK2])
					->setCellValue('D10', $rows[CTRLAGUA_TK3])
					->setCellValue('D11', $rows[CTRLAGUA_TK4]);
					
		$objPHPExcel->getActiveSheet($pestagna)->getStyle('C9:D11')->applyFromArray($style2);

	//AGUA
		$objPHPExcel->getActiveSheet($pestagna)->mergeCells('F8:G8');		
		$objPHPExcel->setActiveSheetIndex($pestagna)->setCellValue('F8', 'AGUA');
		$objPHPExcel->getActiveSheet($pestagna)->getStyle('F8:G8')->applyFromArray($style18);
		
		$objPHPExcel->setActiveSheetIndex($pestagna)
					->setCellValue('F9', 'CE')
					->setCellValue('G9', 'PH');	
		$objPHPExcel->getActiveSheet($pestagna)->getStyle('F9:G9')->applyFromArray($style3);

		$objPHPExcel->setActiveSheetIndex($pestagna)
					->setCellValue('F10', $rows[CTRLAGUA_CE])
					->setCellValue('G10', $rows[CTRLAGUA_PH]);

		$objPHPExcel->getActiveSheet(0)->getStyle('F9:G10')->applyFromArray($style2);	
		
	//PLANTAS MADRES

		$objPHPExcel->setActiveSheetIndex($pestagna)->setCellValue('C14', 'PISCINA');
		$objPHPExcel->getActiveSheet($pestagna)->getStyle('C14')->applyFromArray($style19);
		
		$pis=1;
		$fila=15;
		while($pis <= 30){
			$objPHPExcel->setActiveSheetIndex($pestagna)->setCellValueByColumnAndRow(2,$fila,$pis);
			$pis++;
			$fila++;
		}
		$objPHPExcel->getActiveSheet($pestagna)->getStyle('C13:Q44')->applyFromArray($style2);
		
		
	//PM-3 .. PM-9
		$pm = 3;
		$col = 3;
		$letra_col = ord('D');

		while($pm <= 9){	
		
			$objPHPExcel->getActiveSheet($pestagna)->mergeCells(cellsToMergeByColsRow($col,$col+1,13));	
			$objPHPExcel->setActiveSheetIndex($pestagna)->setCellValueByColumnAndRow($col,13,'PM - '.$pm);			
			$objPHPExcel->setActiveSheetIndex($pestagna)->setCellValueByColumnAndRow($col,14,'CE');
			$objPHPExcel->setActiveSheetIndex($pestagna)->setCellValueByColumnAndRow($col+1,14,'PH');
			
			$objPHPExcel->getActiveSheet($pestagna)->getStyle(chr($letra_col).'13:'.chr($letra_col+1).'13')->applyFromArray($style19);

			$objPHPExcel->getActiveSheet($pestagna)->getStyle(chr($letra_col).'14')->applyFromArray($style20);
			$objPHPExcel->getActiveSheet($pestagna)->getStyle(chr($letra_col+1).'14')->applyFromArray($style20);
			
			$pis=1;
			$sql = "";
			$planta_madre = 'PM'.$pm;
			$fila=15;
			
		//PISCINAS
			while($pis <= 30){
				$sql = "select IFNULL(fer.FER_CE,'') as CE, IFNULL(fer.FER_PH,'') as PH 
				from PISCINA pis 
				JOIN FERTILIZACION fer on pis.PIS_PM = fer.PIS_PM and pis.PIS_ID = fer.PIS_ID 
				where pis.PIS_PM = '$planta_madre' and pis.PIS_ID = $pis and fer.CTRLAGUA_ID = $CTRLAGUA_ID
				";		
				
				$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
				while( $rows2 = mysqli_fetch_assoc($resultado2) ) {
					
					$objPHPExcel->setActiveSheetIndex($pestagna)->setCellValueByColumnAndRow($col,$fila,$rows2[CE]);
					$objPHPExcel->setActiveSheetIndex($pestagna)->setCellValueByColumnAndRow($col + 1,$fila,$rows2[PH]);
					
				}				
				$fila++;
				$pis++;
			}
/*
			while($pis <= 30){
				$sql = "select IFNULL(fer.FER_CE,'') as CE, IFNULL(fer.FER_PH,'') as PH 
				from PISCINA pis 
				JOIN FERTILIZACION fer on pis.PIS_PM = fer.PIS_PM and pis.PIS_ID = fer.PIS_ID 
				where pis.PIS_PM = '$planta_madre' and pis.PIS_ID = $pis and fer.CTRLAGUA_ID = $CTRLAGUA_ID
				";		
				$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
				$row2 = mysqli_fetch_row($resultado);

				$objPHPExcel->setActiveSheetIndex()->setCellValueByColumnAndRow($col,$fila,$rows2[0]);
				$objPHPExcel->setActiveSheetIndex()->setCellValueByColumnAndRow($col + 1,$fila,$rows2[1]);					
								
				$fila++;
				$pis++;
			}	
*/			
			
			
			
			
			
			
			

			$pm++;
			$col = $col + 2;
			$letra_col = $letra_col + 2;
		}
		
		$pestagna++;
	}
	
	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="informe_fertilizacion.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	//$objWriter->setIncludeCharts(TRUE);
	
	$objWriter->save('php://output');
	exit;
	
	
	
}


function cellsToMergeByColsRow($start = -1, $end = -1, $row = -1){
    $merge = 'A1:A1';
    if($start>=0 && $end>=0 && $row>=0){
        $start = PHPExcel_Cell::stringFromColumnIndex($start);
        $end = PHPExcel_Cell::stringFromColumnIndex($end);
        $merge = "$start{$row}:$end{$row}";
    }
    return $merge;
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