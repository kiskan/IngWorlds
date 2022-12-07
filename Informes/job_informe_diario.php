<?php


	
	
	
	ob_end_clean();
	require_once('PHPExcel.php');

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Ing Worlds")
								 ->setLastModifiedBy("Ing Worlds")
								 ->setTitle("Informe Diario Sotrosur")
								 ->setSubject("Instalacion Mini, Macro y Pino")
								 ->setDescription("Produccion semanal de Instalacion Mini, Macro y Pino")
								 ->setKeywords("mini macro pino")
								 ->setCategory("Produccion Sotrosur");							 
						 
	//Orientation and Paper Size:ORIENTATION_LANDSCAPE 
	$objPHPExcel->getActiveSheet()
		->getPageSetup()
		->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
	$objPHPExcel->getActiveSheet()
		->getPageSetup()
		->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
	
	//Page margins:
	$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.1);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.1);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.1);
	$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.1);
	
	//LINEAS DE DIVISION
	$objPHPExcel->getActiveSheet()->setShowGridLines(false);
								 
	//NUEVA PESTAÑA
	$objPHPExcel->setActiveSheetIndex(0)->setTitle('Informe Diario Sotrosur');
	$objPHPExcel->createSheet(1);	
	$objPHPExcel->setActiveSheetIndex(1)->setTitle('Datos');
	
	//FIJARLA EN 1ERA PESTAÑA
	$objPHPExcel->setActiveSheetIndex(0);

	//OCULTAR PESTAÑA DATOS
	//$objPHPExcel->getSheetByName('Datos')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_VERYHIDDEN);
	
	//FONT FAMILY
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Tw Cent MT');
	
	//DIMENSION FILAS
	$filas = 1;
	while($filas <  1000){
		$objPHPExcel->getActiveSheet(0)->getRowDimension($filas)->setRowHeight(11);
		$filas++;
	}
	
	$objPHPExcel->getActiveSheet(0)->getRowDimension(16)->setRowHeight(4);
	$objPHPExcel->getActiveSheet(0)->getRowDimension(30)->setRowHeight(4);
	
	//DIMENSION COLUMNAS
	$objPHPExcel->getActiveSheet(0)->getColumnDimension('A')->setWidth(0.5);			
	foreach(range('B','O') as $columnID) {
		if($columnID <> 'F' and $columnID <> 'K' ){
			$objPHPExcel->getActiveSheet(0)->getColumnDimension($columnID)->setWidth(7.5);
		}else{
			$objPHPExcel->getActiveSheet(0)->getColumnDimension($columnID)->setWidth(0.8);
		}	
	}
	
	$objPHPExcel->getActiveSheet(0)->getColumnDimension('P')->setWidth(0.5);
	$objPHPExcel->getActiveSheet(0)->getColumnDimension('Q')->setWidth(0.5);

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
	

//PARAMETROS DE ENTRADA
/*
	$per_agno = $_GET['per_agno'];
	$per_mes = $_GET['per_mes'];
	$sem_num = $_GET['sem_num'];
*/
	$sem_current = date('W');
	//$mes_actual = date('m');
	
	$date = new DateTime;
	$date->setISODate(date('Y'), date('W'));
	$mes_actual = $date->format("m");

	$per_agno = date('Y');
	$per_mes = $mes_actual;
	$sem_num = $sem_current;	
	
	
	$fecha_current = date('Y-m-d');
	
	$nom_mes = buscar_mes($per_mes);
	$mes_temporada = intval($per_mes);
	$temporada = ($mes_temporada > 3) ? $per_agno:$per_agno-1;	
	
	$ini_temporada = $temporada.'0401';
	$temp_sgte = $temporada + 1;
	$fin_temporada = $temp_sgte.'0401';

//BASE DE DATOS
	
	include('../consultas/coneccion.php');	

	$sql = "select meta_mini, meta_pino, meta_macro from METAS_INF where per_agno = $per_agno and per_mes = '$per_mes' limit 1";
	$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
	$fila = mysqli_fetch_row($resultado);
	$meta_mini = $fila[0];$meta_pino = $fila[1];$meta_macro = $fila[2];	
	
	$proy_aceptada = 'N';
	if($per_mes == $mes_actual){
		$proy_aceptada = 'S';
		
		$sql = "
		select COUNT(DISTINCT S.SEM_NUM) SEM_NUM, COUNT(DISTINCT D.DIAS) DIAS
		from SEMANAS S 
		JOIN DIAS_NOPROD D ON S.PER_AGNO=D.PER_AGNO AND S.SEM_NUM=D.SEM_NUM	
		where S.PER_AGNO = $per_agno and S.PER_MES = '$per_mes' 
		";		
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$total_dias_habiles = $fila[0] * 7 - $fila[1];

		
		$sql = "
		select COUNT(DISTINCT S.SEM_NUM) SEM_NUM, COUNT(DISTINCT D.DIAS) DIAS
		from SEMANAS S 
		JOIN DIAS_NOPROD D ON S.PER_AGNO=D.PER_AGNO AND S.SEM_NUM=D.SEM_NUM	
		where S.PER_AGNO = $per_agno and S.PER_MES = '$per_mes' and S.SEM_NUM < $sem_current
		";		
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$dias_habiles_weeks_ant = $fila[0] * 7 - $fila[1];	
		
		
		$sql = "
		select DATEDIFF('$fecha_current',S.SEM_FECHAINI) + 1 - COUNT(DISTINCT D.DIAS) DIAS
		from SEMANAS S 
		JOIN DIAS_NOPROD D ON S.PER_AGNO=D.PER_AGNO AND S.SEM_NUM=D.SEM_NUM	
		where S.PER_AGNO = $per_agno and S.PER_MES = '$per_mes' and S.SEM_NUM = $sem_current AND D.DIAS <= '$fecha_current'
		";		
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$dias_habiles_week_current = $fila[0];		

		$dias_trabajados = $dias_habiles_weeks_ant + $dias_habiles_week_current;
		$dias_x_trabajar = $total_dias_habiles - $dias_trabajados;
		
	}
	
	
	//$meta_mini = 70000;$meta_pino = 80000;$meta_macro = 90000;
/*	
	$sql = "select num_setos from METAS_INF where per_agno = $temporada and cast(per_mes as unsigned)>3 order by per_mes";	
	$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));	
	$setos_mensual = array();
	$i = 0;
	while( $rows = mysqli_fetch_assoc($resultset) ) {
		$setos_mensual[$i] = $rows[num_setos];
		$i++;
	}	

	$sql = "select num_setos from METAS_INF where per_agno = $temp_sgte and cast(per_mes as unsigned)<4 order by per_mes";	
	$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));	
	while( $rows = mysqli_fetch_assoc($resultset) ) {
		$setos_mensual[$i] = $rows[num_setos];
		$i++;
	}	
*/	
	
	
//TITULO - LOGO

	$meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
	$dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");	
	$fecha_actual = $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " de ".date('Y');
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('I2', 'INFORME DE GESTION '.$temporada)
				->setCellValue('I3', $fecha_actual)
				->setCellValue('I5', 'SEMANA '.$sem_num);				
				
	//DIMENSIÓN FILA TITULO
	$objPHPExcel->getActiveSheet(0)->getRowDimension(2)->setRowHeight(12);	
	
	$objPHPExcel->getActiveSheet(0)->getStyle('I2')->applyFromArray($style0);
	$objPHPExcel->getActiveSheet(0)->getStyle('I3')->applyFromArray($style2);
	$objPHPExcel->getActiveSheet(0)->getStyle('I5')->applyFromArray($style1);
	
	//LOGO
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('PHPExcel logo');
	$objDrawing->setDescription('PHPExcel logo');
	$objDrawing->setPath('../images/logosotrosur_excel.png');
	$objDrawing->setHeight(72);
	$objDrawing->setWidth(180);
	$objDrawing->setCoordinates('B2');
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet(0));	
	
	
	
//INSTALACION DIARIA	
	
	$row_current = 6;
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B'.$row_current, '1.-PRODUCCION');	
	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current)->applyFromArray($style3);
	
	$row_current = 7;
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B'.$row_current, '1.1-INSTALACION DIARIA MINI')
				->setCellValue('G'.$row_current, '1.2-INSTALACION DIARIA PINO')
				->setCellValue('L'.$row_current, '1.3-INSTALACION DIARIA MACRO');		

	//DIMENSIÓN FILA SUB-TITULO
	//$objPHPExcel->getActiveSheet(0)->getRowDimension($row_current)->setRowHeight(13);
	
	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current)->applyFromArray($style3);
	$objPHPExcel->getActiveSheet(0)->getStyle('G'.$row_current)->applyFromArray($style3);
	$objPHPExcel->getActiveSheet(0)->getStyle('L'.$row_current)->applyFromArray($style3);

	$row_current++;
	
	//DIMENSIÓN FILA CABECERA
	//$objPHPExcel->getActiveSheet(0)->getRowDimension($row_current)->setRowHeight(13);
	
	for($i = 0; $i<=12; $i++){	
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(++$i,$row_current,'DIA')
					->setCellValueByColumnAndRow(++$i,$row_current,'CANT')
					->setCellValueByColumnAndRow(++$i,$row_current,'META')
					->setCellValueByColumnAndRow(++$i,$row_current,'CUMPL');			
	}	
	
	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current.':E'.$row_current)->applyFromArray($style7);
	$objPHPExcel->getActiveSheet(0)->getStyle('G'.$row_current.':J'.$row_current)->applyFromArray($style7);
	$objPHPExcel->getActiveSheet(0)->getStyle('L'.$row_current.':O'.$row_current)->applyFromArray($style7);	

	$objPHPExcel->getActiveSheet(0)
		->getStyle('A'.$row_current.':O'.$row_current)
		->getAlignment()
		->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

	//DIAS DE SEMANA
	$row_current++;
	
	$col = 1;
	dias_semana($objPHPExcel, $col, $row_current, $per_agno, $sem_num, 0);
	
	$col = 6;
	dias_semana($objPHPExcel, $col, $row_current, $per_agno, $sem_num, 0);
	
	$col = 11;
	dias_semana($objPHPExcel, $col, $row_current, $per_agno, $sem_num, 0);	

	//ESTILO RAYA NARANJA
	$cell_ini = 9; $cell_fin = 14; 
	while($cell_ini<=$cell_fin){
		$objPHPExcel->getActiveSheet(0)->getStyle('B'.$cell_ini.':E'.$cell_ini)->applyFromArray($style5);
		$objPHPExcel->getActiveSheet(0)->getStyle('G'.$cell_ini.':J'.$cell_ini)->applyFromArray($style5);
		$objPHPExcel->getActiveSheet(0)->getStyle('L'.$cell_ini.':O'.$cell_ini)->applyFromArray($style5);
		$cell_ini++;
	}	

	
	$col = 3;
	dias_semana($objPHPExcel, $col, 2, $per_agno, $sem_num, 1);
	


	$sql = "SELECT PLAN.ACTIV_ID,DATE_FORMAT(PLAN.PLAN_DIA,'%Y%m%d') as DIA, 
	sum(PLANO.PLANO_CANT) AS CANTIDAD	
	FROM PLANIFICACION AS PLAN 
	JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
	JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
	WHERE PLAN.SEM_NUM = $sem_num AND PLAN.PER_AGNO = $per_agno AND PLAN.ACTIV_ID IN (59,123,135)
	GROUP BY PLAN.ACTIV_ID,DIA
	ORDER BY PLAN.ACTIV_ID,DIA ASC";
	$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));	
	//$rowcount = mysqli_num_rows($resultado);	
	$dias = array('DOM','LUN','MAR','MIE','JUE','VIE','SAB');
	while( $rows = mysqli_fetch_assoc($resultado) ) {
		
		$dia_sem = $dias[date('N', strtotime($rows[DIA]))];
				
		switch($dia_sem){
			
			case 'LUN':
				$row = 9;
				fill_cumplimiento($rows[ACTIV_ID], $row, $rows[CANTIDAD],$objPHPExcel,$meta_mini,$meta_pino,$meta_macro);
			break;
			case 'MAR':
				$row = 10;
				fill_cumplimiento($rows[ACTIV_ID], $row, $rows[CANTIDAD],$objPHPExcel,$meta_mini,$meta_pino,$meta_macro);
			break;						
			case 'MIE':
				$row = 11;
				fill_cumplimiento($rows[ACTIV_ID], $row, $rows[CANTIDAD],$objPHPExcel,$meta_mini,$meta_pino,$meta_macro);
			break;						
			case 'JUE':
				$row = 12;
				fill_cumplimiento($rows[ACTIV_ID], $row, $rows[CANTIDAD],$objPHPExcel,$meta_mini,$meta_pino,$meta_macro);
			break;						
			case 'VIE':
				$row = 13;
				fill_cumplimiento($rows[ACTIV_ID], $row, $rows[CANTIDAD],$objPHPExcel,$meta_mini,$meta_pino,$meta_macro);
			break;	
			case 'SAB':
				$row = 14;
				fill_cumplimiento($rows[ACTIV_ID], $row, $rows[CANTIDAD],$objPHPExcel,$meta_mini,$meta_pino,$meta_macro);
			break;			
		}
		
	}
	

	//DATOS 2 GRAFICO

	function fill_cumplimiento2($activ_id, $row, $cant,$objPHPExcel){
		if($cant > 0){
			switch($activ_id){
				case 142: //MINI 1ERA
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E'.$row,$cant);
				break;					
				case 143: //PINO 2DA
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F'.$row,$cant);						
				break;
				case 144: //MACRO 3ERA
					$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G'.$row,$cant);							
				break;						
			}
		}		
	}

	$sql = "SELECT PLAN.ACTIV_ID,DATE_FORMAT(PLAN.PLAN_DIA,'%Y%m%d') as DIA, 
	sum(PLANO.PLANO_CANT) AS CANTIDAD	
	FROM PLANIFICACION AS PLAN 
	JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
	JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
	WHERE PLAN.SEM_NUM = $sem_num AND PLAN.PER_AGNO = $per_agno AND PLAN.ACTIV_ID IN (142,143,144)
	GROUP BY PLAN.ACTIV_ID,DIA
	ORDER BY PLAN.ACTIV_ID,DIA ASC";
	$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));

	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('E1','BAND.ARAUCO');	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('F1','BAND.ELLEPOT');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('G1','BAND.ARAUCO 45CAV');

	//separador de miles
	$objPHPExcel->getActiveSheet(1)->getStyle('E2:G7')
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);	
	
	while( $rows = mysqli_fetch_assoc($resultado) ) {	
	
		$dia_sem = $dias[date('N', strtotime($rows[DIA]))];
			
		switch($dia_sem){
			
			case 'LUN':
				$row = 2;
				fill_cumplimiento2($rows[ACTIV_ID], $row, $rows[CANTIDAD],$objPHPExcel);
			break;
			case 'MAR':
				$row = 3;
				fill_cumplimiento2($rows[ACTIV_ID], $row, $rows[CANTIDAD],$objPHPExcel);
			break;						
			case 'MIE':
				$row = 4;
				fill_cumplimiento2($rows[ACTIV_ID], $row, $rows[CANTIDAD],$objPHPExcel);
			break;						
			case 'JUE':
				$row = 5;
				fill_cumplimiento2($rows[ACTIV_ID], $row, $rows[CANTIDAD],$objPHPExcel);
			break;						
			case 'VIE':
				$row = 6;
				fill_cumplimiento2($rows[ACTIV_ID], $row, $rows[CANTIDAD],$objPHPExcel);
			break;	
			case 'SAB':
				$row = 7;
				fill_cumplimiento2($rows[ACTIV_ID], $row, $rows[CANTIDAD],$objPHPExcel);
			break;		
		}
		
	}	
	
	
	//	Fin datos gráfico 2
	
	
	
	$row_current = 15;
	$k = 0;
	$sum_ini = 9; $sum_fin = 14;
	
	
	/*condicionantes*/
	
/*	
	$objConditional3 = new PHPExcel_Style_Conditional();
	$objConditional3->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
					->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
					->addCondition('80%');
	//$objConditional3->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
	//$objConditional3->getStyle()->getFont()->setBold(true);
	$objConditional3->getStyle()->applyFromArray(
		array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'FF7514')
			)
		)
	);	
	

	$objConditional4 = new PHPExcel_Style_Conditional();
	$objConditional4->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
					->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHANOREQUAL)
					->addCondition('95%');
	//$objConditional4->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
	//$objConditional4->getStyle()->getFont()->setBold(true);					
	$objConditional4->getStyle()->applyFromArray(
		array(
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '4C9141')
			)
		)
	);					
*/					

/*
		'fill' => array(
			'type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb' => 'F79646')
		)	
$objConditional1->getStyle()->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 		
$sheet->getStyle('A1')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'FF0000')
        )
    )
);		
*/	
/*
	$conditionalStyles2 = $objPHPExcel->getActiveSheet(0)->getStyle('E'.$sum_ini)->getConditionalStyles();
	array_push($conditionalStyles2, $objConditional3);
	array_push($conditionalStyles2, $objConditional4);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$sum_ini)->setConditionalStyles($conditionalStyles2);
*/	
	
	//$objPHPExcel->setActiveSheetIndex(0)->getRowDimension($row_current)->setRowHeight(15);
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet(0)->getStyle('C'.$sum_ini.':E'.$sum_fin)->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current)->applyFromArray($style8);
	$objPHPExcel->getActiveSheet(0)->getStyle('C'.$row_current.':E'.$row_current)->applyFromArray($style8);
	
	fondo_condicional($objPHPExcel,'E',$sum_ini,$sum_fin,$style12,$style13,$style14);
	
	
/*	
	$cell1 = $sum_ini;
	while( $cell1 <= $sum_fin ){
		
		$celda_rend = $objPHPExcel->getActiveSheet()->getCell('E'.$cell1)->getValue();	
	
		if($celda_rend <> ''){
			
			if($celda_rend >= 0.95){
				$objPHPExcel->getActiveSheet(0)->getStyle('E'.$cell1)->applyFromArray($style12); //VERDE
			}elseif($celda_rend < 0.8){
				$objPHPExcel->getActiveSheet(0)->getStyle('E'.$cell1)->applyFromArray($style13); //ROJO
			}else{
				$objPHPExcel->getActiveSheet(0)->getStyle('E'.$cell1)->applyFromArray($style14); //AMARILLO
			}
			
		}
		
		$cell1++;
	}
*/
	//separador de miles
	$objPHPExcel->getActiveSheet(0)->getStyle('C'.$sum_ini.':D'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);	
	
	//formato porcentaje
	
	$objPHPExcel->getActiveSheet(0)->getStyle('E'.$sum_ini.':E'.$sum_fin)
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '0%'
		)
	);
	
	//$objPHPExcel->getActiveSheet(0)->getStyle('E'.$sum_ini.':E'.$sum_fin)->getNumberFormat()->setFormatCode('[Green][>=0.95]0%;[Red][<0.80]0%;[Blue]0%');
	

	
	
	$objPHPExcel->getActiveSheet(0)->getStyle('E'.$sum_ini.':E'.($sum_fin+1))->getFont()->setBold(true);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'AVANCE');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(C'.$sum_ini.':C'.$sum_fin.')');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(D'.$sum_ini.':D'.$sum_fin.')');
	
	$k = $k + 2;

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'AVANCE');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(H'.$sum_ini.':H'.$sum_fin.')');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(I'.$sum_ini.':I'.$sum_fin.')');
	
	$objPHPExcel->getActiveSheet(0)->getStyle('H'.$sum_ini.':J'.$sum_fin)->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('G'.$row_current)->applyFromArray($style8);
	$objPHPExcel->getActiveSheet(0)->getStyle('H'.$row_current.':J'.$row_current)->applyFromArray($style8);	

	fondo_condicional($objPHPExcel,'J',$sum_ini,$sum_fin,$style12,$style13,$style14);	
	
	//separador de miles
	$objPHPExcel->getActiveSheet(0)->getStyle('H'.$sum_ini.':I'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);	
	
	//formato porcentaje
	$objPHPExcel->getActiveSheet(0)->getStyle('J'.$sum_ini.':J'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '0%'
		)
	);	
	$objPHPExcel->getActiveSheet(0)->getStyle('J'.$sum_ini.':J'.($sum_fin+1))->getFont()->setBold(true);
	
	$k = $k + 2;
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'AVANCE');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(M'.$sum_ini.':M'.$sum_fin.')');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(N'.$sum_ini.':N'.$sum_fin.')');
	
	$objPHPExcel->getActiveSheet(0)->getStyle('M'.$sum_ini.':O'.$sum_fin)->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('L'.$row_current)->applyFromArray($style8);	
	$objPHPExcel->getActiveSheet(0)->getStyle('M'.$row_current.':O'.$row_current)->applyFromArray($style8);
	
	fondo_condicional($objPHPExcel,'O',$sum_ini,$sum_fin,$style12,$style13,$style14);
	
	//separador de miles
	$objPHPExcel->getActiveSheet(0)->getStyle('M'.$sum_ini.':N'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);		
	
	//formato porcentaje
	$objPHPExcel->getActiveSheet(0)->getStyle('O'.$sum_ini.':O'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '0%'
		)
	);
	$objPHPExcel->getActiveSheet(0)->getStyle('O'.$sum_ini.':O'.($sum_fin+1))->getFont()->setBold(true);
	
	$row_current = $row_current + 2;
	

	
//GRAFICO INSTALACION DIARIA

	$sql = "
	select COUNT(DISTINCT S.SEM_NUM) SEM_NUM, COUNT(DISTINCT D.DIAS) DIAS
	from SEMANAS S 
	JOIN DIAS_NOPROD D ON S.PER_AGNO=D.PER_AGNO AND S.SEM_NUM=D.SEM_NUM	
	where S.PER_AGNO = $per_agno and S.PER_MES = '$per_mes' 
	";		
	$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
	//$rowcount = mysqli_num_rows($resultado) * 7;
	$fila = mysqli_fetch_row($resultado);
	$rowcount = $fila[0] * 7 - $fila[1];
	$objWorksheet_Diaria = $objPHPExcel->getActiveSheet(0);	
	

	$dataSeriesLabels_Diaria = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$K$1', NULL, 1),	
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$L$1', NULL, 1),	
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$M$1', NULL, 1),	
	);
	
	$xAxisTickValues_Diaria = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$J$2:$J$'.($rowcount+1), NULL, $rowcount),	//	Q1 to Q4 for 2010 to 2012	
	);

	$dataSeriesValues_Diaria = array(
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$K$2:$K$'.($rowcount+1), NULL, $rowcount),
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$L$2:$L$'.($rowcount+1), NULL, $rowcount),
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$M$2:$M$'.($rowcount+1), NULL, $rowcount),
	);/*
PHPExcel_Chart_DataSeries::TYPE_LINECHART,
		*/
	$series_Diaria = new PHPExcel_Chart_DataSeries(
		PHPExcel_Chart_DataSeries::TYPE_LINECHART,		// plotType
		PHPExcel_Chart_DataSeries::GROUPING_STANDARD,	// plotGrouping
		range(0, count($dataSeriesValues_Diaria)-1),			// plotOrder
		$dataSeriesLabels_Diaria,								// plotLabel
		$xAxisTickValues_Diaria,								// plotCategory
		$dataSeriesValues_Diaria,								// plotValues
		NULL,
		PHPExcel_Chart_DataSeries::STYLE_SMOOTHMARKER
	);
		
	//$series_Diaria->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
	//$plotArea_Diaria = new PHPExcel_Chart_PlotArea(NULL, array($series_Diaria));
	$legend_Diaria = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

	$title_Diaria = new PHPExcel_Chart_Title('INSTALACIÓN DIARIA MES DE '.$nom_mes.'/'.$per_agno);
	//$yAxisLabel_Diaria = new PHPExcel_Chart_Title('');
//$title_Diaria->getFont()->setItalic(true)->setStrikethrough(true)->getColor()->setRgb('ff0000');



    $layout1 = new PHPExcel_Chart_Layout();    // Create object of chart layout to set data label 
    $layout1->setShowLeaderLines(FALSE);                 
  
    $plotArea_Diaria = new PHPExcel_Chart_PlotArea($layout1, array($series_Diaria));


//	Create the chart
	$chart_Diaria = new PHPExcel_Chart(
		'chart_Diaria',		// name
		$title_Diaria,			// title
		$legend_Diaria,		// legend
		$plotArea_Diaria,		// plotArea
		true,       // plotVisibleOnly
		0,          // displayBlanksAs
		NULL,       // xAxisLabel
		NULL,       // yAxisLabel
		$axis
	);	
	


/*


$chart = new PHPExcel_Chart(
    'chart1',       // name
    $title,         // title
    $legend,        // legend
    $plotarea,      // plotArea
    true,           // plotVisibleOnly
    0,              // displayBlanksAs
    NULL,           // xAxisLabel
    $yAxisLabel     // yAxisLabel
        ,$axis
);
*/



	
	//	Set the position where the chart should appear in the worksheet
	$chart_Diaria->setTopLeftPosition('C'.$row_current);
	$chart_Diaria->setBottomRightPosition('N'.($row_current+12));

	//	Add the chart to the worksheet
	$objWorksheet_Diaria->addChart($chart_Diaria);	
	
	$row_current = $row_current + 12;
	//Printer page breaks:
	//$objPHPExcel->getActiveSheet(0)->setBreak('A'.$row_current , PHPExcel_Worksheet::BREAK_ROW );
	
		
	

//INSTALACION SEMANAL

	$row_current = $row_current + 2;

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row_current, 'MES DE '.$nom_mes.' '.$per_agno);
	$objPHPExcel->getActiveSheet(0)->getStyle('I'.$row_current)->applyFromArray($style1);	
	
	$row_current = $row_current + 2;
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B'.$row_current, '1.1.1.-INSTALACION SEMANAL MINI')
				->setCellValue('G'.$row_current, '1.2.1.-INSTALACION SEMANAL PINO')
				->setCellValue('L'.$row_current, '1.3.1.-INSTALACION SEMANAL MACRO');		

	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current)->applyFromArray($style3);
	$objPHPExcel->getActiveSheet(0)->getStyle('G'.$row_current)->applyFromArray($style3);
	$objPHPExcel->getActiveSheet(0)->getStyle('L'.$row_current)->applyFromArray($style3);				
				
	$row_current++;
	for($i = 0; $i<=12; $i++){	
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(++$i,$row_current,'SEMANA')
					->setCellValueByColumnAndRow(++$i,$row_current,'CANT')
					->setCellValueByColumnAndRow(++$i,$row_current,'META')
					->setCellValueByColumnAndRow(++$i,$row_current,'CUMPL');			
	}	
	

	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current.':E'.$row_current)->applyFromArray($style7);
	$objPHPExcel->getActiveSheet(0)->getStyle('G'.$row_current.':J'.$row_current)->applyFromArray($style7);
	$objPHPExcel->getActiveSheet(0)->getStyle('L'.$row_current.':O'.$row_current)->applyFromArray($style7);
	
	$objPHPExcel->getActiveSheet(0)
		->getStyle('A'.$row_current.':O'.$row_current)
		->getAlignment()
		->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
	
	$sql = "select SEM_NUM from SEMANAS where PER_AGNO = $per_agno and PER_MES = '$per_mes' order by SEM_NUM";		
	$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
	$rowcount = mysqli_num_rows($resultado);
	
	
	$cell_fin = $row_current + $rowcount + 1; 
	
	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current.':E'.$cell_fin)->applyFromArray($style5);
	$objPHPExcel->getActiveSheet(0)->getStyle('G'.$row_current.':J'.$cell_fin)->applyFromArray($style5);
	$objPHPExcel->getActiveSheet(0)->getStyle('L'.$row_current.':O'.$cell_fin)->applyFromArray($style5);
	
	$row_current++;
	
	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current.':B'.$cell_fin)->applyFromArray($style2);
	$objPHPExcel->getActiveSheet(0)->getStyle('G'.$row_current.':G'.$cell_fin)->applyFromArray($style2);
	$objPHPExcel->getActiveSheet(0)->getStyle('L'.$row_current.':L'.$cell_fin)->applyFromArray($style2);
	
	$objPHPExcel->getActiveSheet(0)->getStyle('C'.$row_current.':E'.$cell_fin)->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('H'.$row_current.':J'.$cell_fin)->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('M'.$row_current.':O'.$cell_fin)->applyFromArray($style6);	
	
	//DATOS PARA PESTAÑA DATOS
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('K1','INSTALACION MINI');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('L1','INSTALACION PINO');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValue('M1','INSTALACION MACRO');

	//separador de miles
	$objPHPExcel->getActiveSheet(1)->getStyle('K2:M31')
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);		
	
	$fil = 2;$col = 9;
	$sum_ini = $row_current;
	while( $rows2 = mysqli_fetch_assoc($resultado) ) {
		
		$num_sem = $rows2[SEM_NUM];
		
		//DATOS PARA PESTAÑA DATOS DEL GRAFICO 1 INSTALACION DIARIA
		
		$sql_diasnoprod = "SELECT DATE_FORMAT(DIAS,'%Y%m%d') as DIAS FROM DIAS_NOPROD WHERE PER_AGNO = $per_agno AND SEM_NUM = $num_sem";
		$result_diasnoprod = mysqli_query($link, $sql_diasnoprod) or die("database error:". mysqli_error($link));	
		$count_diasnoprod = mysqli_num_rows($result_diasnoprod);
		$diasnoprod = array();
		$i = 0;
		while( $rows_diasnoprod = mysqli_fetch_assoc($result_diasnoprod) ) {
			$diasnoprod[$i] = $rows_diasnoprod[DIAS];
			$i++;
		}
		
		//$days_show_week = 7 - $count_diasnoprod;
		
		$nom_sem = 'SEMANA '.$num_sem;
		$objPHPExcel->setActiveSheetIndex(1)->setCellValue('I'.$fil,$nom_sem);
		dias_semana_grafico($objPHPExcel, $col, $fil, $per_agno, $num_sem, 1, $diasnoprod);
		
		$sql_datos = "SELECT PLAN.ACTIV_ID,DATE_FORMAT(PLAN.PLAN_DIA,'%Y%m%d') as DIA, 
		sum(PLANO.PLANO_CANT) AS CANTIDAD	
		FROM PLANIFICACION AS PLAN 
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		WHERE PLAN.SEM_NUM = $num_sem AND PLAN.PER_AGNO = $per_agno AND PLAN.ACTIV_ID IN (59,123,135) AND PLAN.PLAN_DIA NOT IN(
        SELECT DIAS FROM DIAS_NOPROD WHERE PER_AGNO = $per_agno AND SEM_NUM = $num_sem
        )
		GROUP BY PLAN.ACTIV_ID,DIA
		ORDER BY DIA, PLAN.ACTIV_ID ASC";
		$resultado_datos = mysqli_query($link, $sql_datos) or die("database error:". mysqli_error($link));		

/*
SEMANA 23
---------
123	20170605	39864.00
123	20170606	56848.00
59	20170607	84928.00
123	20170607	47144.00
123	20170608	36172.00
59	20170608	61192.00
59	20170609	86244.00
123	20170609	40094.00
*/		
		$num_fechas = 0;
		$x = $fil;
		while( $rows3 = mysqli_fetch_assoc($resultado_datos) ) {
		
			if($num_fechas == 0){
				$fecha_habil = $rows3[DIA];
			}else{
			
				if($fecha_habil <> $rows3[DIA]){
					$x++;
					$fecha_habil = $rows3[DIA];
				}
			}
		
			fill_cumplimiento_datos($rows3[ACTIV_ID], $x, $rows3[CANTIDAD],$objPHPExcel);
			$num_fechas++;
		}		

		//$fil++;
		
		$sql_diash = "
		select 7 - COUNT(DISTINCT D.DIAS) DIAS
		from SEMANAS S 
		JOIN DIAS_NOPROD D ON S.PER_AGNO=D.PER_AGNO AND S.SEM_NUM=D.SEM_NUM	
		where S.PER_AGNO = $per_agno and S.SEM_NUM = $num_sem
		";		
		$resultado_diash = mysqli_query($link, $sql_diash) or die("database error:". mysqli_error($link));
		$fila_diash = mysqli_fetch_row($resultado_diash);
		$fil = $fil + $fila_diash[0];		
		
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,$row_current,$num_sem);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$row_current,$num_sem);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11,$row_current,$num_sem);
		
		
//123	MINI	
		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD
		from SEMANAS as S
		join PLANIFICACION as PLAN on S.PER_AGNO = PLAN.PER_AGNO and S.SEM_NUM = PLAN.SEM_NUM 
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		where S.PER_AGNO = $per_agno and S.SEM_NUM = $num_sem AND PLAN.ACTIV_ID = 123
		";
		$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado2);
		$cant_123 = $fila[0];
		
		
		if($cant_123 > 0){
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,$row_current,$cant_123);
			
			$sql = "SELECT COUNT(DISTINCT PLAN.PLAN_DIA) AS CANT_DIAS_PROD	
			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.SEM_NUM = $num_sem AND PLAN.PER_AGNO = $per_agno AND PLAN.ACTIV_ID = 123 AND PLANO.PLANO_CANT > 0";			
			$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$fila = mysqli_fetch_row($resultado2);
			$count_123 = $fila[0];		
			
			$meta = $meta_mini * $count_123;			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,$row_current,$meta);			
	
			if($meta == 0){
				$cumplimiento = '';
			}else{
				$cumplimiento =$cant_123/$meta;	
			}
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$row_current,$cumplimiento);
			
		}
		
//59	PINO	
		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD
		from SEMANAS as S
		join PLANIFICACION as PLAN on S.PER_AGNO = PLAN.PER_AGNO and S.SEM_NUM = PLAN.SEM_NUM 
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		where S.PER_AGNO = $per_agno and S.SEM_NUM = $num_sem AND PLAN.ACTIV_ID = 59
		";
		$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado2);
		$cant_59 = $fila[0];
		
		
		if($cant_59 > 0){
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$row_current,$cant_59);
			
			$sql = "SELECT COUNT(DISTINCT PLAN.PLAN_DIA) AS CANT_DIAS_PROD	
			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.SEM_NUM = $num_sem AND PLAN.PER_AGNO = $per_agno AND PLAN.ACTIV_ID = 59 AND PLANO.PLANO_CANT > 0";			
			$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$fila = mysqli_fetch_row($resultado2);
			$count_59 = $fila[0];		
			
			$meta = $meta_pino * $count_59;			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8,$row_current,$meta);			
			//$cumplimiento =$cant_59/$meta;	
			if($meta == 0){
				$cumplimiento = '';
			}else{
				$cumplimiento =$cant_59/$meta;	
			}			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9,$row_current,$cumplimiento);
			
		}		
		
//135	MACRO	
		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD
		from SEMANAS as S
		join PLANIFICACION as PLAN on S.PER_AGNO = PLAN.PER_AGNO and S.SEM_NUM = PLAN.SEM_NUM 
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		where S.PER_AGNO = $per_agno and S.SEM_NUM = $num_sem AND PLAN.ACTIV_ID = 135
		";
		$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado2);
		$cant_135 = $fila[0];
		
		
		if($cant_135 > 0){
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12,$row_current,$cant_135);
			
			$sql = "SELECT COUNT(DISTINCT PLAN.PLAN_DIA) AS CANT_DIAS_PROD	
			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.SEM_NUM = $num_sem AND PLAN.PER_AGNO = $per_agno AND PLAN.ACTIV_ID = 135 AND PLANO.PLANO_CANT > 0";			
			$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$fila = mysqli_fetch_row($resultado2);
			$count_135 = $fila[0];		
			
			$meta = $meta_macro * $count_135;			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13,$row_current,$meta);			
			//$cumplimiento =$cant_135/$meta;		
			if($meta == 0){
				$cumplimiento = '';
			}else{
				$cumplimiento =$cant_135/$meta;	
			}				
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14,$row_current,$cumplimiento);
			
		}		
		
		$row_current++;
	}
	

	$k = 0;
	//$sum_ini = 20; 
	$sum_fin = $sum_ini + $rowcount - 1;
	//$objPHPExcel->getActiveSheet(0)->getRowDimension($row_current)->setRowHeight(13);
	
	//ESTILO RAYA NARANJA
	$cell_ini = $sum_ini; $cell_fin = $sum_fin; 
	while($cell_ini<=$cell_fin){
		$objPHPExcel->getActiveSheet(0)->getStyle('B'.$cell_ini.':E'.$cell_ini)->applyFromArray($style5);
		$objPHPExcel->getActiveSheet(0)->getStyle('G'.$cell_ini.':J'.$cell_ini)->applyFromArray($style5);
		$objPHPExcel->getActiveSheet(0)->getStyle('L'.$cell_ini.':O'.$cell_ini)->applyFromArray($style5);
		$cell_ini++;
	}		
	
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'AVANCE');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(C'.$sum_ini.':C'.$sum_fin.')');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(D'.$sum_ini.':D'.$sum_fin.')');
	$objPHPExcel->getActiveSheet(0)->getStyle('C'.$sum_ini.':E'.$sum_fin)->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current)->applyFromArray($style8);
	$objPHPExcel->getActiveSheet(0)->getStyle('C'.$row_current.':E'.$row_current)->applyFromArray($style15);

	
	$mini_cant_mes = $objPHPExcel->getActiveSheet(0)->getCell('C'.$row_current)->getCalculatedValue();
	$mini_meta_mes = $objPHPExcel->getActiveSheet(0)->getCell('D'.$row_current)->getCalculatedValue();

	fondo_condicional($objPHPExcel,'E',$sum_ini,$sum_fin,$style12,$style13,$style14);
	
	//separador de miles
	$objPHPExcel->getActiveSheet(0)->getStyle('C'.$sum_ini.':D'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);	

	//formato porcentaje
	$objPHPExcel->getActiveSheet(0)->getStyle('E'.$sum_ini.':E'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '0%'
		)
	);
	$objPHPExcel->getActiveSheet(0)->getStyle('E'.$sum_ini.':E'.($sum_fin+1))->getFont()->setBold(true);

	$k = $k + 2;

	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'AVANCE');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(H'.$sum_ini.':H'.$sum_fin.')');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(I'.$sum_ini.':I'.$sum_fin.')');
	$objPHPExcel->getActiveSheet(0)->getStyle('H'.$sum_ini.':J'.$sum_fin)->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('G'.$row_current)->applyFromArray($style8);
	$objPHPExcel->getActiveSheet(0)->getStyle('H'.$row_current.':J'.$row_current)->applyFromArray($style15);	

	$pino_cant_mes = $objPHPExcel->getActiveSheet(0)->getCell('H'.$row_current)->getCalculatedValue();
	$pino_meta_mes = $objPHPExcel->getActiveSheet(0)->getCell('I'.$row_current)->getCalculatedValue();	
	
	fondo_condicional($objPHPExcel,'J',$sum_ini,$sum_fin,$style12,$style13,$style14);
	
	//separador de miles
	$objPHPExcel->getActiveSheet(0)->getStyle('H'.$sum_ini.':I'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);		
	
	//formato porcentaje
	$objPHPExcel->getActiveSheet(0)->getStyle('J'.$sum_ini.':J'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '0%'
		)
	);
	$objPHPExcel->getActiveSheet(0)->getStyle('J'.$sum_ini.':J'.($sum_fin+1))->getFont()->setBold(true);
	
	$k = $k + 2;
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'AVANCE');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(M'.$sum_ini.':M'.$sum_fin.')');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(N'.$sum_ini.':N'.$sum_fin.')');
	$objPHPExcel->getActiveSheet(0)->getStyle('M'.$sum_ini.':O'.$sum_fin)->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('L'.$row_current)->applyFromArray($style8);
	$objPHPExcel->getActiveSheet(0)->getStyle('M'.$row_current.':O'.$row_current)->applyFromArray($style15);		
	
	$macro_cant_mes = $objPHPExcel->getActiveSheet(0)->getCell('M'.$row_current)->getCalculatedValue();
	$macro_meta_mes = $objPHPExcel->getActiveSheet(0)->getCell('N'.$row_current)->getCalculatedValue();	
	
	fondo_condicional($objPHPExcel,'O',$sum_ini,$sum_fin,$style12,$style13,$style14);
	
	//separador de miles
	$objPHPExcel->getActiveSheet(0)->getStyle('M'.$sum_ini.':N'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);	

	//formato porcentaje
	$objPHPExcel->getActiveSheet(0)->getStyle('O'.$sum_ini.':O'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '0%'
		)
	);
	$objPHPExcel->getActiveSheet(0)->getStyle('O'.$sum_ini.':O'.($sum_fin+1))->getFont()->setBold(true);
	
	$row_current++;
	$objPHPExcel->getActiveSheet(0)->getRowDimension($row_current)->setRowHeight(3);
	$row_current++;
	
	
	
//GRAFICO INSTALACION SEMANAL

	$sql_gis = "SELECT SEM_NUM,PER_AGNO FROM SEMANAS WHERE SEM_FECHAINI >= '$ini_temporada' and SEM_FECHAINI <'$fin_temporada' 
	and SEM_FECHAINI<= CURRENT_DATE ORDER BY SEM_FECHAINI ASC";		
	$resultado_gis = mysqli_query($link, $sql_gis) or die("database error:". mysqli_error($link));
	$rowcount = mysqli_num_rows($resultado_gis);	
	
	$fil_ini = 1;
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(16,$fil_ini,'INST.MINI');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(17,$fil_ini,'INST.PINO');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(18,$fil_ini,'INST.MACRO');
	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(19,$fil_ini,'MINI ACUM');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(20,$fil_ini,'META MINI ACUM');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(21,$fil_ini,'PINO ACUM');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(22,$fil_ini,'META PINO ACUM');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(23,$fil_ini,'MACRO ACUM');
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(24,$fil_ini,'META MACRO ACUM');	

	//separador de miles
	$objPHPExcel->getActiveSheet(1)->getStyle('Q2:Y13')
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);	
	
	
	$fil_ini++;
	$sum_mini = 0;$sum_pino = 0;$sum_macro = 0;
	$sum_meta_mini = 0;$sum_meta_pino = 0;$sum_meta_macro = 0;
	while( $rows_gis = mysqli_fetch_assoc($resultado_gis) ) {
		
		$sem_gis = $rows_gis[SEM_NUM];
		$ano_gis = $rows_gis[PER_AGNO];
		
		$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(15,$fil_ini,'SEM '.$sem_gis);
		
//123	MINI	
		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD
		from SEMANAS as S
		join PLANIFICACION as PLAN on S.PER_AGNO = PLAN.PER_AGNO and S.SEM_NUM = PLAN.SEM_NUM 
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		where S.PER_AGNO = $ano_gis and S.SEM_NUM = $sem_gis AND PLAN.ACTIV_ID = 123
		";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$cant_123 = $fila[0];
				
		if($cant_123 > 0){			
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(16,$fil_ini,$cant_123);

			$sum_mini = $sum_mini + $cant_123;
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(19,$fil_ini,$sum_mini);
			
			$sql = "SELECT COUNT(DISTINCT PLAN.PLAN_DIA) AS CANT_DIAS_PROD	
			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.SEM_NUM = $sem_gis AND PLAN.PER_AGNO = $ano_gis AND PLAN.ACTIV_ID = 123 AND PLANO.PLANO_CANT > 0";			
			$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$fila = mysqli_fetch_row($resultado2);
			$count_123 = $fila[0];				
			$meta = $meta_mini * $count_123;			
			$sum_meta_mini = $sum_meta_mini + $meta;			
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(20,$fil_ini,$sum_meta_mini);	
		}
		
//59	PINO		
		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD
		from SEMANAS as S
		join PLANIFICACION as PLAN on S.PER_AGNO = PLAN.PER_AGNO and S.SEM_NUM = PLAN.SEM_NUM 
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		where S.PER_AGNO = $ano_gis and S.SEM_NUM = $sem_gis AND PLAN.ACTIV_ID = 59
		";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$cant_59 = $fila[0];
				
		if($cant_59 > 0){			
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(17,$fil_ini,$cant_59);

			$sum_pino = $sum_pino + $cant_59;
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(21,$fil_ini,$sum_pino);
			
			$sql = "SELECT COUNT(DISTINCT PLAN.PLAN_DIA) AS CANT_DIAS_PROD	
			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.SEM_NUM = $sem_gis AND PLAN.PER_AGNO = $ano_gis AND PLAN.ACTIV_ID = 59 AND PLANO.PLANO_CANT > 0";			
			$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$fila = mysqli_fetch_row($resultado2);
			$count_59 = $fila[0];				
			$meta = $meta_pino * $count_59;			
			$sum_meta_pino = $sum_meta_pino + $meta;			
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(22,$fil_ini,$sum_meta_pino);
			
		}		
		
//135	MACRO		
		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD
		from SEMANAS as S
		join PLANIFICACION as PLAN on S.PER_AGNO = PLAN.PER_AGNO and S.SEM_NUM = PLAN.SEM_NUM 
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		where S.PER_AGNO = $ano_gis and S.SEM_NUM = $sem_gis AND PLAN.ACTIV_ID = 135
		";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$cant_135 = $fila[0];
				
		if($cant_135 > 0){			
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(18,$fil_ini,$cant_135);

			$sum_macro = $sum_macro + $cant_135;
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(23,$fil_ini,$sum_macro);
			
			$sql = "SELECT COUNT(DISTINCT PLAN.PLAN_DIA) AS CANT_DIAS_PROD	
			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.SEM_NUM = $sem_gis AND PLAN.PER_AGNO = $ano_gis AND PLAN.ACTIV_ID = 135 AND PLANO.PLANO_CANT > 0";			
			$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$fila = mysqli_fetch_row($resultado2);
			$count_135 = $fila[0];				
			$meta = $meta_macro * $count_135;			
			$sum_meta_macro = $sum_meta_macro + $meta;			
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(24,$fil_ini,$sum_meta_macro);
			
		}		
		
		$fil_ini++;
	}

	$ini_row_gis = 2;
	if($rowcount > 12){
		$ini_row_gis = $rowcount - 12 + 2;
	}
	

	$objWorksheet_GIS = $objPHPExcel->setActiveSheetIndex(0);	
	
	$dataSeriesLabels_GIS = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$Q$1', NULL, 1),	
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$R$1', NULL, 1),	
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$S$1', NULL, 1),	
	);
	
	$xAxisTickValues_GIS = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$P$'.$ini_row_gis.':$P$'.($rowcount+1), NULL, $rowcount),	//	Q1 to Q4 for 2010 to 2012	
	);

	$dataSeriesValues_GIS = array(
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$Q$'.$ini_row_gis.':$Q$'.($rowcount+1), NULL, $rowcount),
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$R$'.$ini_row_gis.':$R$'.($rowcount+1), NULL, $rowcount),
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$S$'.$ini_row_gis.':$S$'.($rowcount+1), NULL, $rowcount),
	);
	
	$series_GIS = new PHPExcel_Chart_DataSeries(
		PHPExcel_Chart_DataSeries::TYPE_LINECHART,		// plotType
		PHPExcel_Chart_DataSeries::GROUPING_STANDARD,	// plotGrouping
		range(0, count($dataSeriesValues_GIS)-1),			// plotOrder
		$dataSeriesLabels_GIS,								// plotLabel
		$xAxisTickValues_GIS,								// plotCategory
		$dataSeriesValues_GIS,								// plotValues
		true,
		PHPExcel_Chart_DataSeries::STYLE_SMOOTHMARKER
	);
		

	$plotArea_GIS = new PHPExcel_Chart_PlotArea(NULL, array($series_GIS));
	$legend_GIS = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);
	$title_GIS = new PHPExcel_Chart_Title('INSTALACIÓN SEMANAL');

	//	Create the chart
	$chart_GIS = new PHPExcel_Chart(
		'chart_GIS',		// name
		$title_GIS,			// title
		$legend_GIS,		// legend
		$plotArea_GIS,		// plotArea
		true,			// plotVisibleOnly
		0,				// displayBlanksAs
		NULL,			// xAxisLabel
		NULL		// yAxisLabel
	);	
	
	
	//	Set the position where the chart should appear in the worksheet
	$chart_GIS->setTopLeftPosition('B'.$row_current);
	$chart_GIS->setBottomRightPosition('I'.($row_current+13));

	//	Add the chart to the worksheet
	$objWorksheet_GIS->addChart($chart_GIS);	
	
	//$row_current = $row_current + 12;
	//Printer page breaks:
	//$objPHPExcel->getActiveSheet(0)->setBreak('A'.$row_current , PHPExcel_Worksheet::BREAK_ROW );	
	
	//$row_current = $row_current + 2;

	
	//GRAFICO 2 INSTALACION SEMANAL ACUMULADO MINI

	$dataSeriesLabels_GIS = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$T$1', NULL, 1),	
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$U$1', NULL, 1),	
	);
	
	$xAxisTickValues_GIS = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$P$'.$ini_row_gis.':$P$'.($rowcount+1), NULL, $rowcount),	//	Q1 to Q4 for 2010 to 2012	
	);

	$dataSeriesValues_GIS = array(
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$T$'.$ini_row_gis.':$T$'.($rowcount+1), NULL, $rowcount),
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$U$'.$ini_row_gis.':$U$'.($rowcount+1), NULL, $rowcount),
	);
	
	$series_GIS = new PHPExcel_Chart_DataSeries(
		PHPExcel_Chart_DataSeries::TYPE_LINECHART,		// plotType
		PHPExcel_Chart_DataSeries::GROUPING_STANDARD,	// plotGrouping
		range(0, count($dataSeriesValues_GIS)-1),			// plotOrder
		$dataSeriesLabels_GIS,								// plotLabel
		$xAxisTickValues_GIS,								// plotCategory
		$dataSeriesValues_GIS,								// plotValues
		true,
		PHPExcel_Chart_DataSeries::STYLE_SMOOTHMARKER
	);
		

	$plotArea_GIS = new PHPExcel_Chart_PlotArea(NULL, array($series_GIS));
	$legend_GIS = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);
	$title_GIS = new PHPExcel_Chart_Title('ACUMULADA MINI');

	//	Create the chart
	$chart_GIS = new PHPExcel_Chart(
		'chart_GIS',		// name
		$title_GIS,			// title
		$legend_GIS,		// legend
		$plotArea_GIS,		// plotArea
		true,			// plotVisibleOnly
		0,				// displayBlanksAs
		NULL,			// xAxisLabel
		NULL		// yAxisLabel
	);	
	
	
	//	Set the position where the chart should appear in the worksheet
	$chart_GIS->setTopLeftPosition('I'.$row_current);
	$chart_GIS->setBottomRightPosition('P'.($row_current+13));

	//	Add the chart to the worksheet
	$objWorksheet_GIS->addChart($chart_GIS);	
	
	$row_current = $row_current + 14;
	
	
	//GRAFICO 2 INSTALACION SEMANAL ACUMULADO PINO

	$dataSeriesLabels_GIS = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$V$1', NULL, 1),	
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$W$1', NULL, 1),	
	);
	
	$xAxisTickValues_GIS = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$P$'.$ini_row_gis.':$P$'.($rowcount+1), NULL, $rowcount),	//	Q1 to Q4 for 2010 to 2012	
	);

	$dataSeriesValues_GIS = array(
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$V$'.$ini_row_gis.':$V$'.($rowcount+1), NULL, $rowcount),
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$W$'.$ini_row_gis.':$W$'.($rowcount+1), NULL, $rowcount),
	);
	
	$series_GIS = new PHPExcel_Chart_DataSeries(
		PHPExcel_Chart_DataSeries::TYPE_LINECHART,		// plotType
		PHPExcel_Chart_DataSeries::GROUPING_STANDARD,	// plotGrouping
		range(0, count($dataSeriesValues_GIS)-1),			// plotOrder
		$dataSeriesLabels_GIS,								// plotLabel
		$xAxisTickValues_GIS,								// plotCategory
		$dataSeriesValues_GIS,								// plotValues
		true,
		PHPExcel_Chart_DataSeries::STYLE_SMOOTHMARKER
	);
		

	$plotArea_GIS = new PHPExcel_Chart_PlotArea(NULL, array($series_GIS));
	$legend_GIS = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);
	$title_GIS = new PHPExcel_Chart_Title('ACUMULADA PINO');

	//	Create the chart
	$chart_GIS = new PHPExcel_Chart(
		'chart_GIS',		// name
		$title_GIS,			// title
		$legend_GIS,		// legend
		$plotArea_GIS,		// plotArea
		true,			// plotVisibleOnly
		0,				// displayBlanksAs
		NULL,			// xAxisLabel
		NULL		// yAxisLabel
	);	
	
	
	//	Set the position where the chart should appear in the worksheet
	$chart_GIS->setTopLeftPosition('B'.$row_current);
	$chart_GIS->setBottomRightPosition('I'.($row_current+13));

	//	Add the chart to the worksheet
	$objWorksheet_GIS->addChart($chart_GIS);	
	
	//$row_current = $row_current + 18;
	
	
	//GRAFICO 2 INSTALACION SEMANAL ACUMULADO MACRO

	$dataSeriesLabels_GIS = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$X$1', NULL, 1),	
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$Y$1', NULL, 1),	
	);
	
	$xAxisTickValues_GIS = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$P$'.$ini_row_gis.':$P$'.($rowcount+1), NULL, $rowcount),	//	Q1 to Q4 for 2010 to 2012	
	);

	$dataSeriesValues_GIS = array(
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$X$'.$ini_row_gis.':$X$'.($rowcount+1), NULL, $rowcount),
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$Y$'.$ini_row_gis.':$Y$'.($rowcount+1), NULL, $rowcount),
	);
	
	$series_GIS = new PHPExcel_Chart_DataSeries(
		PHPExcel_Chart_DataSeries::TYPE_LINECHART,		// plotType
		PHPExcel_Chart_DataSeries::GROUPING_STANDARD,	// plotGrouping
		range(0, count($dataSeriesValues_GIS)-1),			// plotOrder
		$dataSeriesLabels_GIS,								// plotLabel
		$xAxisTickValues_GIS,								// plotCategory
		$dataSeriesValues_GIS,								// plotValues
		true,
		PHPExcel_Chart_DataSeries::STYLE_SMOOTHMARKER
	);
		

	$plotArea_GIS = new PHPExcel_Chart_PlotArea(NULL, array($series_GIS));
	$legend_GIS = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);
	$title_GIS = new PHPExcel_Chart_Title('ACUMULADA MACRO');

	//	Create the chart
	$chart_GIS = new PHPExcel_Chart(
		'chart_GIS',		// name
		$title_GIS,			// title
		$legend_GIS,		// legend
		$plotArea_GIS,		// plotArea
		true,			// plotVisibleOnly
		0,				// displayBlanksAs
		NULL,			// xAxisLabel
		NULL		// yAxisLabel
	);	
	
	
	//	Set the position where the chart should appear in the worksheet
	$chart_GIS->setTopLeftPosition('I'.$row_current);
	$chart_GIS->setBottomRightPosition('P'.($row_current+13));

	//	Add the chart to the worksheet
	$objWorksheet_GIS->addChart($chart_GIS);	
	
	$row_current = $row_current + 15;	
	
	
	
	//$row_current = $row_current + 2;
	
	$objPHPExcel->getActiveSheet(0)->mergeCells('B'.$row_current.':D'.$row_current);
	$objPHPExcel->getActiveSheet(0)->mergeCells('G'.$row_current.':I'.$row_current);
	$objPHPExcel->getActiveSheet(0)->mergeCells('L'.$row_current.':N'.$row_current);
	
	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current.':E'.($row_current+2))->applyFromArray($style9);
	$objPHPExcel->getActiveSheet(0)->getStyle('G'.$row_current.':J'.($row_current+2))->applyFromArray($style9);
	$objPHPExcel->getActiveSheet(0)->getStyle('L'.$row_current.':O'.($row_current+2))->applyFromArray($style9);

	$objPHPExcel->getActiveSheet(0)->getStyle('E'.$row_current.':E'.($row_current+2))->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('J'.$row_current.':J'.($row_current+2))->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('O'.$row_current.':O'.($row_current+2))->applyFromArray($style6);	


	$filas = $row_current;/*
	$total_filas = $filas + 3;
	while($filas <=  $total_filas){
		$objPHPExcel->getActiveSheet(0)->getRowDimension($filas)->setRowHeight(13);
		$filas++;
	}*/
	
	$cumplimiento_acum = $row_current;	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,$row_current,'CUMPLIMIENTO ACUMULADO');		
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$row_current,'CUMPLIMIENTO ACUMULADO');	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11,$row_current,'CUMPLIMIENTO ACUMULADO');
	
	$row_current++;
	
	$objPHPExcel->getActiveSheet(0)->mergeCells('B'.$row_current.':D'.$row_current);
	$objPHPExcel->getActiveSheet(0)->mergeCells('G'.$row_current.':I'.$row_current);
	$objPHPExcel->getActiveSheet(0)->mergeCells('L'.$row_current.':N'.$row_current);	
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,$row_current,'AVANCE MES');
	$cumplimiento = 0;
	if($mini_meta_mes <> 0){
		$cumplimiento =$mini_cant_mes/$mini_meta_mes;	
	}
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$row_current,$cumplimiento);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$row_current,'AVANCE MES');
	$cumplimiento = 0;
	if($pino_meta_mes <> 0){
		$cumplimiento =$pino_cant_mes/$pino_meta_mes;	
	}
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9,$row_current,$cumplimiento);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11,$row_current,'AVANCE MES');
	$cumplimiento = 0;
	if($macro_meta_mes <> 0){
		$cumplimiento =$macro_cant_mes/$macro_meta_mes;	
	}
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14,$row_current,$cumplimiento);	
	
	$row_current++;
	
	$objPHPExcel->getActiveSheet(0)->mergeCells('B'.$row_current.':D'.$row_current);
	$objPHPExcel->getActiveSheet(0)->mergeCells('G'.$row_current.':I'.$row_current);
	$objPHPExcel->getActiveSheet(0)->mergeCells('L'.$row_current.':N'.$row_current);	
	
	$proy_mes = $row_current;
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,$row_current,'PROYECCIÓN MES');
	//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$row_current,'12345');	
	//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$row_current,'0');	
	//dias_trab_xtrab()
	//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$proy_mes,'0');	
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$row_current,'PROYECCIÓN MES');
	//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9,$row_current,'0');
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11,$row_current,'PROYECCIÓN MES');
	//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14,$row_current,'0');	

	//formato porcentaje
	$objPHPExcel->getActiveSheet(0)->getStyle('E'.$cumplimiento_acum.':E'.($row_current-1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '0%'
		)
	);	
	$objPHPExcel->getActiveSheet(0)->getStyle('E'.$sum_ini.':E'.($sum_fin+1))->getFont()->setBold(true);
	
	//separador de miles
	$objPHPExcel->getActiveSheet(0)->getStyle('E'.$row_current)
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);		
	
	
	//formato porcentaje
	$objPHPExcel->getActiveSheet(0)->getStyle('J'.$cumplimiento_acum.':J'.($row_current-1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '0%'
		)
	);
	$objPHPExcel->getActiveSheet(0)->getStyle('J'.$sum_ini.':J'.($sum_fin+1))->getFont()->setBold(true);
	
	//separador de miles
	$objPHPExcel->getActiveSheet(0)->getStyle('J'.$row_current)
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);		
	

	//formato porcentaje
	$objPHPExcel->getActiveSheet(0)->getStyle('O'.$cumplimiento_acum.':O'.($row_current-1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '0%'
		)
	);
	$objPHPExcel->getActiveSheet(0)->getStyle('O'.$sum_ini.':O'.($sum_fin+1))->getFont()->setBold(true);
	
	//separador de miles
	$objPHPExcel->getActiveSheet(0)->getStyle('O'.$row_current)
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);		
	

	//Printer page breaks:
	$objPHPExcel->getActiveSheet(0)->setBreak('A'.$row_current , PHPExcel_Worksheet::BREAK_ROW );	
	
	

//TEMPORADA	
	
	$row_current = $row_current + 2;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row_current, 'TEMPORADA '.$temporada);
	$objPHPExcel->getActiveSheet(0)->getStyle('I'.$row_current)->applyFromArray($style1);	
	
	$row_current = $row_current + 2;
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B'.$row_current, '1.1.2.-INSTALACION MENSUAL MINI')
				->setCellValue('G'.$row_current, '1.2.2.-INSTALACION MENSUAL PINO')
				->setCellValue('L'.$row_current, '1.3.2.-INSTALACION MENSUAL MACRO');
				
	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current)->applyFromArray($style3);
	$objPHPExcel->getActiveSheet(0)->getStyle('G'.$row_current)->applyFromArray($style3);
	$objPHPExcel->getActiveSheet(0)->getStyle('L'.$row_current)->applyFromArray($style3);				
	
	$row_current++;
	for($i = 0; $i<=12; $i++){	
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValueByColumnAndRow(++$i,$row_current,'MES')
					->setCellValueByColumnAndRow(++$i,$row_current,'CANT')
					->setCellValueByColumnAndRow(++$i,$row_current,'META')
					->setCellValueByColumnAndRow(++$i,$row_current,'CUMPL');			
	}	
	

	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current.':E'.$row_current)->applyFromArray($style7);
	$objPHPExcel->getActiveSheet(0)->getStyle('G'.$row_current.':J'.$row_current)->applyFromArray($style7);
	$objPHPExcel->getActiveSheet(0)->getStyle('L'.$row_current.':O'.$row_current)->applyFromArray($style7);
	
	$objPHPExcel->getActiveSheet(0)
		->getStyle('A'.$row_current.':O'.$row_current)
		->getAlignment()
		->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		
		
	$cell_fin = $row_current + 13; 
	
	//ESTILO RAYA NARANJA
	$cell_ini = $row_current;  
	while($cell_ini<=$cell_fin){
		$objPHPExcel->getActiveSheet(0)->getStyle('B'.$cell_ini.':E'.$cell_ini)->applyFromArray($style5);
		$objPHPExcel->getActiveSheet(0)->getStyle('G'.$cell_ini.':J'.$cell_ini)->applyFromArray($style5);
		$objPHPExcel->getActiveSheet(0)->getStyle('L'.$cell_ini.':O'.$cell_ini)->applyFromArray($style5);
		$cell_ini++;
	}
	
	$row_current++;
	
	$objPHPExcel->getActiveSheet(0)->getStyle('C'.$row_current.':E'.$cell_fin)->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('H'.$row_current.':J'.$cell_fin)->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('M'.$row_current.':O'.$cell_fin)->applyFromArray($style6);		
		
	$sum_ini = $row_current; $sum_fin = $sum_ini + 11;	
	$mes_current = 4;
	$cont = 0;
	
	$prod_euca = array();
	$agno = $temporada;
	
	//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$proy_mes,'0');
	//$proy_aceptada = 'S';
	
	
	while($cont < 12){
		
		$mes = $mes_current;
		if($mes_current < 10 ){			
			$mes = '0'.$mes_current;
		}
		
		
		if($mes_current > 12 ){
			$mes_current = 1;
			$mes = '0'.$mes_current;
			$agno = $temporada + 1;
		}
		

		$nom_mes = buscar_mes($mes);
		/*
		if($cont == 12){
			$mes_temporada = $temporada + 1;
			$nom_mes = $nom_mes.' '.$mes_temporada;
		}*/
		
		
		
		$ultimo_dia = date('t',mktime(0,0,0,$mes,1,$agno));
		$FECHAINI_INF = $agno.$mes.'01';
		$FECHAFIN_INF = $agno.$mes.$ultimo_dia;		
		

		$sql = "select meta_mini, meta_pino, meta_macro from METAS_INF where per_agno = $agno and per_mes = '$mes' limit 1";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$meta_mini_mes = $fila[0];$meta_pino_mes = $fila[1];$meta_macro_mes = $fila[2];		
		
		
		
		
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,$row_current,$nom_mes);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$row_current,$nom_mes);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11,$row_current,$nom_mes);			
		
//123	MINI	1066557.00 S.PER_AGNO = $agno and S.PER_MES = '$mes'
		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD,M.NUM_SETOS
		from PLANIFICACION as PLAN 
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		JOIN METAS_INF AS M ON M.PER_AGNO = $agno AND M.PER_MES='$mes'
		where 
		PLAN.PLAN_DIA >= '$FECHAINI_INF' AND PLAN.PLAN_DIA <= '$FECHAFIN_INF' 
		AND PLAN.ACTIV_ID = 123
		";
		$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado2);
		$cant_123 = $fila[0];
		$numero_setos = $fila[1];
		
		$fil = $cont + 1;
		$objPHPExcel->setActiveSheetIndex(1)->setCellValue('A'.$fil,$nom_mes);
		
		
		if($mes == $per_mes and $proy_aceptada == 'N'){	
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$proy_mes,$cant_123);	
		}		
		
		if($cant_123 > 0 and $numero_setos > 0){
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,$row_current,$cant_123);
			//$cant_euca = $cant_123 / (3003*190);			
			$cant_euca = $cant_123 / $numero_setos;
			$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$fil,$cant_euca);
			//S.PER_MES = '$mes' AND PLAN.PER_AGNO = $agno 
			$sql = "SELECT COUNT(DISTINCT PLAN.PLAN_DIA) AS CANT_DIAS_PROD	
			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.PLAN_DIA >= '$FECHAINI_INF' AND PLAN.PLAN_DIA <= '$FECHAFIN_INF'
			AND PLAN.ACTIV_ID = 123 AND PLANO.PLANO_CANT > 0";			
			$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$fila = mysqli_fetch_row($resultado2);
			$count_123 = $fila[0];		
			
			$meta = $meta_mini_mes * $count_123;			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,$row_current,$meta);			
			if($meta == 0){
				$cumplimiento = '';	
			}
			else{
				$cumplimiento =$cant_123/$meta;		
			}		
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$row_current,$cumplimiento);	
			//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,138,12345);
			//Proyección Mes
			if($mes == $per_mes and $proy_aceptada == 'S'){			
			/*
				$dias_proy = dias_trab_xtrab();//dias_trabajados - dias_x_trabajar
				$dias_proy = explode("-", $dias_proy);
				$proyeccion = $cant_123 / $dias_proy[0] * $dias_proy[1] + $cant_123;	
			*/	
				$proyeccion = $cant_123 / $dias_trabajados * $dias_x_trabajar + $cant_123;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$proy_mes,$proyeccion);							
			}
			
		}else{		
			$objPHPExcel->setActiveSheetIndex(1)->setCellValue('B'.$fil,'');
		}


		
		
//59	PINO	
		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD
		from PLANIFICACION as PLAN
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		where PLAN.PLAN_DIA >= '$FECHAINI_INF' AND PLAN.PLAN_DIA <= '$FECHAFIN_INF'
		AND PLAN.ACTIV_ID = 59
		";
		$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado2);
		$cant_59 = $fila[0];
		
		if($mes == $per_mes and $proy_aceptada == 'N'){	
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9,$proy_mes,$cant_59);	
		}	
		
		if($cant_59 > 0){
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$row_current,$cant_59);
			
			$sql = "SELECT COUNT(DISTINCT PLAN.PLAN_DIA) AS CANT_DIAS_PROD	
			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.PLAN_DIA >= '$FECHAINI_INF' AND PLAN.PLAN_DIA <= '$FECHAFIN_INF' 
			AND PLAN.ACTIV_ID = 59 AND PLANO.PLANO_CANT > 0";			
			$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$fila = mysqli_fetch_row($resultado2);
			$count_59 = $fila[0];		
			
			$meta = $meta_pino_mes * $count_59;			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8,$row_current,$meta);			
			if($meta == 0){
				$cumplimiento = '';	
			}
			else{
				$cumplimiento = $cant_59/$meta;	
			}		
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9,$row_current,$cumplimiento);
			
			//Proyección Mes
			if($mes == $per_mes and $proy_aceptada == 'S'){	
				/*$dias_proy = dias_trab_xtrab();
				$dias_proy = explode("-", $dias_proy);
				$proyeccion = $cant_59 / $dias_proy[0] * $dias_proy[1] + $cant_59;	
				*/
				$proyeccion = $cant_59 / $dias_trabajados * $dias_x_trabajar + $cant_59;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9,$proy_mes,$proyeccion);	
			}			
			
			
		}		
		
		
//135	MACRO	
		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD
		from PLANIFICACION as PLAN
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		where PLAN.PLAN_DIA >= '$FECHAINI_INF' AND PLAN.PLAN_DIA <= '$FECHAFIN_INF'
		AND PLAN.ACTIV_ID = 135
		";
		$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado2);
		$cant_135 = $fila[0];
		
		if($mes == $per_mes and $proy_aceptada == 'N'){	
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14,$proy_mes,$cant_135);	
		}	
		
		if($cant_135 > 0){
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12,$row_current,$cant_135);
			
			$sql = "SELECT COUNT(DISTINCT PLAN.PLAN_DIA) AS CANT_DIAS_PROD	
			FROM PLANIFICACION AS PLAN 
			JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
			JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
			WHERE PLAN.PLAN_DIA >= '$FECHAINI_INF' AND PLAN.PLAN_DIA <= '$FECHAFIN_INF'
			AND PLAN.ACTIV_ID = 135 AND PLANO.PLANO_CANT > 0";			
			$resultado2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
			$fila = mysqli_fetch_row($resultado2);
			$count_135 = $fila[0];		
			
			$meta = $meta_macro_mes * $count_135;			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13,$row_current,$meta);			
			if($meta == 0){
				$cumplimiento = '';	
			}
			else{
				$cumplimiento =$cant_135/$meta;	
			}	
			$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14,$row_current,$cumplimiento);
			
			//Proyección Mes
			if($mes == $per_mes and $proy_aceptada == 'S'){	
				/*$dias_proy = dias_trab_xtrab(); 
				$dias_proy = explode("-", $dias_proy);
				$proyeccion = $cant_135 / $dias_proy[0] * $dias_proy[1] + $cant_135;*/
				$proyeccion = $cant_135 / $dias_trabajados * $dias_x_trabajar + $cant_135;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14,$proy_mes,$proyeccion);				
			}				
			
		}		
		
		$row_current++;
		$mes_current++;
		$cont++;
	}
	
	$k = 0;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'AVANCE');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(C'.$sum_ini.':C'.$sum_fin.')');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(D'.$sum_ini.':D'.$sum_fin.')');
	$objPHPExcel->getActiveSheet(0)->getStyle('C'.$sum_ini.':E'.$sum_fin)->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current)->applyFromArray($style8);
	$objPHPExcel->getActiveSheet(0)->getStyle('C'.$row_current.':E'.$row_current)->applyFromArray($style15);		
	
	$mini_cant_mes = $objPHPExcel->getActiveSheet(0)->getCell('C'.$row_current)->getCalculatedValue();
	$mini_meta_mes = $objPHPExcel->getActiveSheet(0)->getCell('D'.$row_current)->getCalculatedValue();
	$cumplimiento = 0;
	if($mini_meta_mes > 1){
		$cumplimiento =$mini_cant_mes/$mini_meta_mes;	
		//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=AVERAGE(E'.$sum_ini.':E'.$sum_fin.')');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,$cumplimiento);
	}else{
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,0);
	}
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$cumplimiento_acum,$cumplimiento);
	//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$row_current,$cumplimiento.'%');	
	
	fondo_condicional($objPHPExcel,'E',$sum_ini,$sum_fin,$style12,$style13,$style14);
	
	$celda_rend = $objPHPExcel->setActiveSheetIndex(0)->getCell('E'.($sum_fin+1))->getCalculatedValue();	

	if($celda_rend <> ''){		
		if($celda_rend >= 0.95){
			$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.($sum_fin+1))->applyFromArray($style12); //VERDE
		}elseif($celda_rend < 0.8){
			$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.($sum_fin+1))->applyFromArray($style13); //ROJO
		}else{
			$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.($sum_fin+1))->applyFromArray($style14); //AMARILLO
		}	
	}	
	
	
	//separador de miles
	$objPHPExcel->getActiveSheet(0)->getStyle('C'.$sum_ini.':D'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);	

	//formato porcentaje
	$objPHPExcel->getActiveSheet(0)->getStyle('E'.$sum_ini.':E'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '0%'
		)
	);
	$objPHPExcel->getActiveSheet(0)->getStyle('E'.$sum_ini.':E'.($sum_fin+1))->getFont()->setBold(true);
	
	$k = $k + 1;	
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'AVANCE');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(H'.$sum_ini.':H'.$sum_fin.')');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(I'.$sum_ini.':I'.$sum_fin.')');
	$objPHPExcel->getActiveSheet(0)->getStyle('H'.$sum_ini.':J'.$sum_fin)->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('G'.$row_current)->applyFromArray($style8);
	$objPHPExcel->getActiveSheet(0)->getStyle('H'.$row_current.':J'.$row_current)->applyFromArray($style15);	

	$pino_cant_mes = $objPHPExcel->getActiveSheet(0)->getCell('H'.$row_current)->getCalculatedValue();
	$pino_meta_mes = $objPHPExcel->getActiveSheet(0)->getCell('I'.$row_current)->getCalculatedValue();
	$cumplimiento = 0;
	if($pino_meta_mes > 1){
		$cumplimiento =$pino_cant_mes/$pino_meta_mes;
		//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=AVERAGE(J'.$sum_ini.':J'.$sum_fin.')');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,$cumplimiento);
	}else{
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,0);
	}
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9,$cumplimiento_acum,$cumplimiento);
	
	fondo_condicional($objPHPExcel,'J',$sum_ini,$sum_fin,$style12,$style13,$style14);
	
	$celda_rend = $objPHPExcel->setActiveSheetIndex(0)->getCell('J'.($sum_fin+1))->getCalculatedValue();	

	if($celda_rend <> ''){		
		if($celda_rend >= 0.95){
			$objPHPExcel->setActiveSheetIndex(0)->getStyle('J'.($sum_fin+1))->applyFromArray($style12); //VERDE
		}elseif($celda_rend < 0.8){
			$objPHPExcel->setActiveSheetIndex(0)->getStyle('J'.($sum_fin+1))->applyFromArray($style13); //ROJO
		}else{
			$objPHPExcel->setActiveSheetIndex(0)->getStyle('J'.($sum_fin+1))->applyFromArray($style14); //AMARILLO
		}	
	}	
	
	//separador de miles
	$objPHPExcel->getActiveSheet(0)->getStyle('H'.$sum_ini.':I'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);	
	
	//formato porcentaje
	$objPHPExcel->getActiveSheet(0)->getStyle('J'.$sum_ini.':J'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '0%'
		)
	);	
	$objPHPExcel->getActiveSheet(0)->getStyle('J'.$sum_ini.':J'.($sum_fin+1))->getFont()->setBold(true);
	
	$k = $k + 1;
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'AVANCE');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(M'.$sum_ini.':M'.$sum_fin.')');
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=SUM(N'.$sum_ini.':N'.$sum_fin.')');
	$objPHPExcel->getActiveSheet(0)->getStyle('M'.$sum_ini.':O'.$sum_fin)->applyFromArray($style6);
	$objPHPExcel->getActiveSheet(0)->getStyle('L'.$row_current)->applyFromArray($style8);
	$objPHPExcel->getActiveSheet(0)->getStyle('M'.$row_current.':O'.$row_current)->applyFromArray($style15);
	
	
	$macro_cant_mes = $objPHPExcel->getActiveSheet(0)->getCell('M'.$row_current)->getCalculatedValue();
	$macro_meta_mes = $objPHPExcel->getActiveSheet(0)->getCell('N'.$row_current)->getCalculatedValue();
	$cumplimiento = 0;
	if($macro_meta_mes > 1){
		$cumplimiento =$macro_cant_mes/$macro_meta_mes;
		//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,'=AVERAGE(O'.$sum_ini.':O'.$sum_fin.')');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,$cumplimiento);
	}else{
		$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(++$k,$row_current,0);
	}
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14,$cumplimiento_acum,$cumplimiento);	
	
	fondo_condicional($objPHPExcel,'O',$sum_ini,$sum_fin,$style12,$style13,$style14);
	
	$celda_rend = $objPHPExcel->setActiveSheetIndex(0)->getCell('O'.($sum_fin+1))->getCalculatedValue();	

	if($celda_rend <> ''){		
		if($celda_rend >= 0.95){
			$objPHPExcel->setActiveSheetIndex(0)->getStyle('O'.($sum_fin+1))->applyFromArray($style12); //VERDE
		}elseif($celda_rend < 0.8){
			$objPHPExcel->setActiveSheetIndex(0)->getStyle('O'.($sum_fin+1))->applyFromArray($style13); //ROJO
		}else{
			$objPHPExcel->setActiveSheetIndex(0)->getStyle('O'.($sum_fin+1))->applyFromArray($style14); //AMARILLO
		}	
	}	
	
	//separador de miles
	$objPHPExcel->getActiveSheet(0)->getStyle('M'.$sum_ini.':N'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);	

	//formato porcentaje
	$objPHPExcel->getActiveSheet(0)->getStyle('O'.$sum_ini.':O'.($sum_fin+1))
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '0%'
		)
	);	
	$objPHPExcel->getActiveSheet(0)->getStyle('O'.$sum_ini.':O'.($sum_fin+1))->getFont()->setBold(true);
	
	$row_current++;
	$objPHPExcel->getActiveSheet(0)->getRowDimension($row_current)->setRowHeight(3);
	$row_current++;
	
//GRAFICO TEMPORADA

	$temp_anterior = $temporada - 1;
	
	$fil_ini = 1;
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(27,$fil_ini,'MINI TEMP '.$temp_anterior);
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(28,$fil_ini,'MINI TEMP '.$temporada);
	
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(29,$fil_ini,'PINO TEMP '.$temp_anterior);
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(30,$fil_ini,'INST. PINO TEMP '.$temporada);

	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(31,$fil_ini,'MACRO TEMP '.$temp_anterior);
	$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(32,$fil_ini,'MACRO TEMP '.$temporada);	
	
	
	//separador de miles
	$objPHPExcel->getActiveSheet(1)->getStyle('AB2:AG13')
	->getNumberFormat()->applyFromArray( 
		array( 
			'code' => '#,##0'
		)
	);	
	
	
	$fil_ini++;


	$mes_current = 4;
	$cont = 0;
	while($cont < 12){
		
		$mes_TEMP = $mes_current;
		if($mes_current < 10 ){			
			$mes_TEMP = '0'.$mes_current;
		}
		
		
		if($mes_current > 12 ){
			$mes_current = 1;
			$mes_TEMP = '0'.$mes_current;
		}
	
		//$mes_TEMP = $rows_TEMP[PER_MES];
		
		$nom_mes_TEMP = buscar_mes($mes_TEMP);		
		$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(26,$fil_ini,$nom_mes_TEMP);
		
//123	MINI	
		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD
		from SEMANAS as S
		join PLANIFICACION as PLAN on S.PER_AGNO = PLAN.PER_AGNO and S.SEM_NUM = PLAN.SEM_NUM 
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		where S.PER_AGNO = $temp_anterior and S.PER_MES = '$mes_TEMP' AND PLAN.ACTIV_ID = 123
		";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$cant_123 = $fila[0];
				
		if($cant_123 > 0){			
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(27,$fil_ini,$cant_123);		
		}
		
		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD
		from SEMANAS as S
		join PLANIFICACION as PLAN on S.PER_AGNO = PLAN.PER_AGNO and S.SEM_NUM = PLAN.SEM_NUM 
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		where S.PER_AGNO = $temporada and S.PER_MES = '$mes_TEMP' AND PLAN.ACTIV_ID = 123
		";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$cant_123 = $fila[0];
				
		if($cant_123 > 0){			
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(28,$fil_ini,$cant_123);		
		}		
		
		
//59	PINO		
		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD
		from SEMANAS as S
		join PLANIFICACION as PLAN on S.PER_AGNO = PLAN.PER_AGNO and S.SEM_NUM = PLAN.SEM_NUM 
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		where S.PER_AGNO = $temp_anterior and S.PER_MES = '$mes_TEMP' AND PLAN.ACTIV_ID = 59
		";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$cant_59 = $fila[0];
				
		if($cant_59 > 0){			
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(29,$fil_ini,$cant_59);		
		}		

		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD
		from SEMANAS as S
		join PLANIFICACION as PLAN on S.PER_AGNO = PLAN.PER_AGNO and S.SEM_NUM = PLAN.SEM_NUM 
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		where S.PER_AGNO = $temporada and S.PER_MES = '$mes_TEMP' AND PLAN.ACTIV_ID = 59
		";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$cant_59 = $fila[0];
				
		if($cant_59 > 0){			
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(30,$fil_ini,$cant_59);		
		}

		
//135	MACRO		
		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD
		from SEMANAS as S
		join PLANIFICACION as PLAN on S.PER_AGNO = PLAN.PER_AGNO and S.SEM_NUM = PLAN.SEM_NUM 
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		where S.PER_AGNO = $temp_anterior and S.PER_MES = '$mes_TEMP' AND PLAN.ACTIV_ID = 135
		";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$cant_135 = $fila[0];
				
		if($cant_135 > 0){			
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(31,$fil_ini,$cant_135);		
		}		
		
		$sql = "select IFNULL(sum(PLANO.PLANO_CANT),0) AS CANTIDAD
		from SEMANAS as S
		join PLANIFICACION as PLAN on S.PER_AGNO = PLAN.PER_AGNO and S.SEM_NUM = PLAN.SEM_NUM 
		JOIN PLANIFICACION_OPER AS PLANO ON PLANO.PLAN_DIA = PLAN.PLAN_DIA AND PLANO.ACTIV_ID = PLAN.ACTIV_ID
		JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
		where S.PER_AGNO = $temporada and S.PER_MES = '$mes_TEMP' AND PLAN.ACTIV_ID = 135
		";
		$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
		$fila = mysqli_fetch_row($resultado);
		$cant_135 = $fila[0];
				
		if($cant_135 > 0){			
			$objPHPExcel->setActiveSheetIndex(1)->setCellValueByColumnAndRow(32,$fil_ini,$cant_135);		
		}		
		
		
		$fil_ini++;
		$mes_current++;
		$cont++;		
		
		
	}

	$objWorksheet_TEMP = $objPHPExcel->setActiveSheetIndex(0);	
	

//TEMPORADA MINI
	
	$dataSeriesLabels_TEMP = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$AB$1', NULL, 1),	
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$AC$1', NULL, 1),		
	);
	
	$xAxisTickValues_TEMP = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$AA$2:$AA$13', NULL, 12),	//	Q1 to Q4 for 2010 to 2012	
	);

	$dataSeriesValues_TEMP = array(
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$AB$2:$AB$13', NULL, 12),
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$AC$2:$AC$13', NULL, 12),
	);
	
	$series_TEMP = new PHPExcel_Chart_DataSeries(
		PHPExcel_Chart_DataSeries::TYPE_LINECHART,		// plotType
		PHPExcel_Chart_DataSeries::GROUPING_STANDARD,	// plotGrouping
		range(0, count($dataSeriesValues_TEMP)-1),			// plotOrder
		$dataSeriesLabels_TEMP,								// plotLabel
		$xAxisTickValues_TEMP,								// plotCategory
		$dataSeriesValues_TEMP,								// plotValues
		true,
		PHPExcel_Chart_DataSeries::STYLE_SMOOTHMARKER
	);

	$plotArea_TEMP = new PHPExcel_Chart_PlotArea(NULL, array($series_TEMP));
	$legend_TEMP = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

	$title_TEMP = new PHPExcel_Chart_Title('MINI TEMP '.$temp_anterior.'-'.$temporada);

	//	Create the chart
	$chart_TEMP = new PHPExcel_Chart(
		'chart_TEMP',		// name
		$title_TEMP,			// title
		$legend_TEMP,		// legend
		$plotArea_TEMP,		// plotArea
		true,			// plotVisibleOnly
		0,				// displayBlanksAs
		NULL,			// xAxisLabel
		NULL		// yAxisLabel
	);	
		
	//	Set the position where the chart should appear in the worksheet
	$chart_TEMP->setTopLeftPosition('B'.$row_current);
	$chart_TEMP->setBottomRightPosition('I'.($row_current+14));

	//	Add the chart to the worksheet
	$objWorksheet_TEMP->addChart($chart_TEMP);
	
	//$row_current = $row_current + 16;
	
	//Printer page breaks:
	//$objPHPExcel->getActiveSheet(0)->setBreak('A'.$row_current , PHPExcel_Worksheet::BREAK_ROW );
	
		
	//$row_current = $row_current + 1;

//TEMPORADA PINO
	
	$dataSeriesLabels_TEMP = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$AD$1', NULL, 1),	
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$AE$1', NULL, 1),		
	);
	
	$xAxisTickValues_TEMP = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$AA$2:$AA$13', NULL, 12),	//	Q1 to Q4 for 2010 to 2012	
	);

	$dataSeriesValues_TEMP = array(
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$AD$2:$AD$13', NULL, 12),
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$AE$2:$AE$13', NULL, 12),
	);
	
	$series_TEMP = new PHPExcel_Chart_DataSeries(
		PHPExcel_Chart_DataSeries::TYPE_LINECHART,		// plotType
		PHPExcel_Chart_DataSeries::GROUPING_STANDARD,	// plotGrouping
		range(0, count($dataSeriesValues_TEMP)-1),			// plotOrder
		$dataSeriesLabels_TEMP,								// plotLabel
		$xAxisTickValues_TEMP,								// plotCategory
		$dataSeriesValues_TEMP,								// plotValues
		true,
		PHPExcel_Chart_DataSeries::STYLE_SMOOTHMARKER
	);

	$plotArea_TEMP = new PHPExcel_Chart_PlotArea(NULL, array($series_TEMP));
	$legend_TEMP = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

	$title_TEMP = new PHPExcel_Chart_Title('PINO TEMP '.$temp_anterior.'-'.$temporada);

	//	Create the chart
	$chart_TEMP = new PHPExcel_Chart(
		'chart_TEMP',		// name
		$title_TEMP,			// title
		$legend_TEMP,		// legend
		$plotArea_TEMP,		// plotArea
		true,			// plotVisibleOnly
		0,				// displayBlanksAs
		NULL,			// xAxisLabel
		NULL		// yAxisLabel
	);	
		
	//	Set the position where the chart should appear in the worksheet
	$chart_TEMP->setTopLeftPosition('I'.$row_current);
	$chart_TEMP->setBottomRightPosition('P'.($row_current+14));

	//	Add the chart to the worksheet
	$objWorksheet_TEMP->addChart($chart_TEMP);
	

	
	$row_current = $row_current + 15;
	//Printer page breaks:
	//$objPHPExcel->getActiveSheet(0)->setBreak('A'.$row_current , PHPExcel_Worksheet::BREAK_ROW );
	//$row_current = $row_current + 2;
	
	
//TEMPORADA MACRO
	
	$dataSeriesLabels_TEMP = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$AF$1', NULL, 1),	
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$AG$1', NULL, 1),		
	);
	
	$xAxisTickValues_TEMP = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$AA$2:$AA$13', NULL, 12),	//	Q1 to Q4 for 2010 to 2012	
	);

	$dataSeriesValues_TEMP = array(
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$AF$2:$AF$13', NULL, 12),
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$AG$2:$AG$13', NULL, 12),
	);
	
	$series_TEMP = new PHPExcel_Chart_DataSeries(
		PHPExcel_Chart_DataSeries::TYPE_LINECHART,		// plotType
		PHPExcel_Chart_DataSeries::GROUPING_STANDARD,	// plotGrouping
		range(0, count($dataSeriesValues_TEMP)-1),			// plotOrder
		$dataSeriesLabels_TEMP,								// plotLabel
		$xAxisTickValues_TEMP,								// plotCategory
		$dataSeriesValues_TEMP,								// plotValues
		true,
		PHPExcel_Chart_DataSeries::STYLE_SMOOTHMARKER
	);

	$plotArea_TEMP = new PHPExcel_Chart_PlotArea(NULL, array($series_TEMP));
	$legend_TEMP = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

	$title_TEMP = new PHPExcel_Chart_Title('MACRO TEMP '.$temp_anterior.'-'.$temporada);

	//	Create the chart
	$chart_TEMP = new PHPExcel_Chart(
		'chart_TEMP',		// name
		$title_TEMP,			// title
		$legend_TEMP,		// legend
		$plotArea_TEMP,		// plotArea
		true,			// plotVisibleOnly
		0,				// displayBlanksAs
		NULL,			// xAxisLabel
		NULL		// yAxisLabel
	);	
		
	//	Set the position where the chart should appear in the worksheet
	$chart_TEMP->setTopLeftPosition('E'.$row_current);
	$chart_TEMP->setBottomRightPosition('M'.($row_current+14));

	//	Add the chart to the worksheet
	$objWorksheet_TEMP->addChart($chart_TEMP);	

	$row_current = $row_current + 16;

	
///////////////////////	


		
	
	
	$objPHPExcel->setActiveSheetIndex(0)->getRowDimension($row_current)->setRowHeight(13);
	
	//$objPHPExcel->getActiveSheet(0)->mergeCells('B'.$row_current.':O'.$row_current);
	$avance_acum = round($mini_cant_mes + $pino_cant_mes + $macro_cant_mes,0);
	$avance_acum_f = number_format($avance_acum,0,",",".");
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,$row_current,'AVANCE ACUMULADO: ');	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9,$row_current,$avance_acum_f);
	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current.':O'.($row_current+1))->applyFromArray($style10);
		
	$row_current++;	
	$objPHPExcel->setActiveSheetIndex(0)->getRowDimension($row_current)->setRowHeight(13);
	
	//$objPHPExcel->getActiveSheet(0)->mergeCells('B'.$row_current.':O'.$row_current);	
	$total_meta = round($mini_meta_mes + $pino_meta_mes + $macro_meta_mes,0);
	$deficit_acum = $avance_acum - $total_meta;
	$deficit_acum_f = number_format($deficit_acum,0,",",".");
	//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,$row_current,'DÉFICIT ACUMULADO: '.$deficit_acum_f);
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,$row_current,'DÉFICIT ACUMULADO: ');	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9,$row_current,$deficit_acum_f);	
	
	//$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current.':O'.$row_current)->applyFromArray($style10);
	
	$objConditional = new PHPExcel_Style_Conditional();
	$objConditional->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
					->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
					->addCondition('0');
	$objConditional->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
	$objConditional->getStyle()->getFont()->setBold(true);

	$objConditional2 = new PHPExcel_Style_Conditional();
	$objConditional2->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
					->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHANOREQUAL)
					->addCondition('0');
	$objConditional2->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
	$objConditional2->getStyle()->getFont()->setBold(true);


	$conditionalStyles = $objPHPExcel->getActiveSheet(0)->getStyle('J'.$row_current)->getConditionalStyles();
	array_push($conditionalStyles, $objConditional);
	array_push($conditionalStyles, $objConditional2);
	$objPHPExcel->getActiveSheet()->getStyle('J'.$row_current)->setConditionalStyles($conditionalStyles);

//Printer page breaks:
//$objPHPExcel->getActiveSheet(0)->setBreak('A'.$row_current , PHPExcel_Worksheet::BREAK_ROW );
	
	
	

	
//PRODUCCIONES
	
	
//GRAFICO 1 - PRODUCCION EUCA

	$row_current = $row_current + 2;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row_current, 'PRODUCCIÓN '.$temporada);
	$objPHPExcel->getActiveSheet(0)->getStyle('I'.$row_current)->applyFromArray($style1);	
	$row_current = $row_current + 2;
	
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row_current, '2.-PRODUCCIÓN EUCA MINI');
	$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current)->applyFromArray($style3);

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row_current, '3.-PROD. SUSTRATOS GNRAL');
	$objPHPExcel->getActiveSheet(0)->getStyle('I'.$row_current)->applyFromArray($style3);	
	
	$row_current = $row_current + 1;
	
	$objWorksheet = $objPHPExcel->getActiveSheet(0);	
	//$objWorksheet->fromArray($prod_euca);
	
	$dataSeriesLabels = array();/*
		new PHPExcel_Chart_DataSeriesValues('String', '', NULL, 1),	//	2010
	);*/
	//	Set the X-Axis Labels
	//		Datatype
	//		Cell reference for data
	//		Format Code
	//		Number of datapoints in series
	//		Data values
	//		Data Marker
	$xAxisTickValues = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$A$1:$A$12', NULL, 12),	//	Q1 to Q4
		
	);
	//	Set the Data values for each data series we want to plot
	//		Datatype
	//		Cell reference for data
	//		Format Code
	//		Number of datapoints in series
	//		Data values
	//		Data Marker
	$dataSeriesValues = array(
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$B$1:$B$12', NULL, 12),
	);

	//	Build the dataseries   PHPExcel_Chart_DataSeries::GROUPING_STANDARD,	// plotGrouping
	$series = new PHPExcel_Chart_DataSeries(
		PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
		PHPExcel_Chart_DataSeries::GROUPING_STANDARD,	// plotGrouping
		range(0, count($dataSeriesValues)-1),			// plotOrder
		$dataSeriesLabels,								// plotLabel
		$xAxisTickValues,								// plotCategory
		$dataSeriesValues								// plotValues
	);
		
	//	Set additional dataseries parameters
	//		Make it a vertical column rather than a horizontal bar graph
	$series->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);

	//	Set the series in the plot area
	$plotArea = new PHPExcel_Chart_PlotArea(NULL, array($series));
	//	Set the chart legend
	$legend = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);

	$title = new PHPExcel_Chart_Title('REND.(ESTACAS/SETOS)');
	$yAxisLabel = new PHPExcel_Chart_Title('');


	//	Create the chart
	$chart = new PHPExcel_Chart(
		'chart1',		// name
		$title,			// title
		null,		// legend
		$plotArea,		// plotArea
		true,			// plotVisibleOnly
		0,				// displayBlanksAs
		NULL,			// xAxisLabel
		$yAxisLabel		// yAxisLabel
	);	
	
	
	
	//	Set the position where the chart should appear in the worksheet
	$chart->setTopLeftPosition('B'.$row_current);
	$chart->setBottomRightPosition('I'.($row_current+14));

	//	Add the chart to the worksheet
	$objWorksheet->addChart($chart);	
	
	

	
//GRAFICO 2 - PRODUCCION BANDEJAS DIARIO
	
	//$row_current = $row_current + 16;
	
	//$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row_current, 'PROD. SUSTRATOS GNRAL');
	//$objPHPExcel->getActiveSheet(0)->getStyle('B'.$row_current)->applyFromArray($style3);	
	
	//$row_current = $row_current + 1;
	
	$objWorksheet2 = $objPHPExcel->getActiveSheet(0);	
	

	$dataSeriesLabels2 = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$E$1', NULL, 1),	//	2010
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$F$1', NULL, 1),	//	2011
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$G$1', NULL, 1),	//	2012
	);
	
	$xAxisTickValues2 = array(
		new PHPExcel_Chart_DataSeriesValues('String', 'Datos!$D$2:$D$7', NULL, 6),	//	Q1 to Q4
		
	);

	$dataSeriesValues2 = array(
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$E$2:$E$7', NULL, 6),
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$F$2:$F$7', NULL, 6),
		new PHPExcel_Chart_DataSeriesValues('Number', 'Datos!$G$2:$G$7', NULL, 6),
	);

	$series2 = new PHPExcel_Chart_DataSeries(
		PHPExcel_Chart_DataSeries::TYPE_BARCHART,		// plotType
		PHPExcel_Chart_DataSeries::GROUPING_STANDARD,	// plotGrouping
		range(0, count($dataSeriesValues2)-1),			// plotOrder
		$dataSeriesLabels2,								// plotLabel
		$xAxisTickValues2,								// plotCategory
		$dataSeriesValues2								// plotValues
	);
		
	$series2->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_COL);
	$plotArea2 = new PHPExcel_Chart_PlotArea(NULL, array($series2));
	//$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
	$legend2 = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);
	$title2 = new PHPExcel_Chart_Title('PROD. BANDEJAS DIARIO');
	$yAxisLabel2 = new PHPExcel_Chart_Title('');


	//	Create the chart
	$chart2 = new PHPExcel_Chart(
		'chart2',		// name
		$title2,			// title
		$legend2,		// legend
		$plotArea2,		// plotArea
		true,			// plotVisibleOnly
		0,				// displayBlanksAs
		NULL,			// xAxisLabel
		$yAxisLabel2		// yAxisLabel
	);	
	
	
	
	//	Set the position where the chart should appear in the worksheet
	$chart2->setTopLeftPosition('I'.$row_current);
	$chart2->setBottomRightPosition('P'.($row_current+14));

	//	Add the chart to the worksheet
	$objWorksheet2->addChart($chart2);



	

	// Redirect output to a client’s web browser (Excel2007)
	/*
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="informe_diario.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');
	*/
	
	/*
	//Descomentar si se desea que se bloquee el archivo excel y no se pueda editar
	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	*/
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->setIncludeCharts(TRUE);
	$nombre_archivo = 'InformeDiario_'.$fecha_current.'.xlsx';
	$rutaArchivo = '/home/ingworlds/public_html/proyecto/sisconvi-production/Informes/'.$nombre_archivo;
	//CREAR ACHIVO
	$objWriter->save($nombre_archivo);
	

//ENVIO DE EMAIL

	//require("PHPMailer/PHPMailerAutoload.php");
	require("class.phpmailer.php");
	$mail = new PHPMailer();
	
	$mail->IsSMTP();	
	//$mail->Host = "localhost";
	$mail->Host = "mail.ing-worlds.cl";
	$mail->SMTPAuth = true;
	$mail->Port = 25; 	
	$mail->Username = "operaciones@ing-worlds.cl";  		
	$mail->Password = "sistemasweb2015";		
	$mail->CharSet  = 'UTF-8';
	//$mail->From = "planificacionycontrolproduccion@sotrosur.cl";
	
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
	$mail->AddAddress("luis.cifuentes@sotrosur.cl","Luis Cifuentes");
	
	$mail->AddBCC("cristian.ieci@gmail.com","Cristian Cabrera");
	$mail->AddBCC("l.melgarejo.u@gmail.com","Leonardo Melgarejo");
	$mail->AddBCC("operaciones@ing-worlds.cl","Ing-Worlds");
	

	
	
	$fecha_actual = date('d-m-Y');
	$nom_mes_actual = buscar_mes($mes_actual);
	$mensaje = '<br>Informe diario SOTROSUR día '.$fecha_actual.' de la semana '.$sem_current.' del mes de '.$nom_mes_actual.'<br><br>* No contestar este correo<br><br><br>Planificación y Estudio';
	$asunto = 'Informe diario SOTROSUR día '.$fecha_actual.' de la semana '.$sem_current.' del mes de '.$nom_mes_actual;	
	$mail->WordWrap = 50;                              
	$mail->IsHTML(true);                               
	$mail->Subject  =  $asunto;
	$mail->Body     =  $mensaje;
	$mail->AddAttachment($rutaArchivo, $nombre_archivo);	
	$mail->AltBody  =  $mensaje;
	//$mail->Send();

	if(!$mail->Send()) {
		echo 'MENSAJE NO ENVIADO: ' . $mail->ErrorInfo;
	} else {
		echo 'MENSAJE ENVIADO';
	}	
	
//BORRAR ARCHIVO

	unlink($rutaArchivo);
	
	exit;
	

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
/*
	$lunes_text = 'Lun '.date("d-M", strtotime($lunes));	
	$martes_text = 'Mar '.date("d-M", strtotime($martes));
	$miercoles_text = 'Mié '.date("d-M", strtotime($miercoles));
	$jueves_text = 'Jue '.date("d-M", strtotime($jueves));
	$viernes_text = 'Vie '.date("d-M", strtotime($viernes));
	$sabado_text = 'Sáb '.date("d-M", strtotime($sabado));
*/	
/*
	$lunes_text = date("d/M", strtotime($lunes));	
	$martes_text = date("d/M", strtotime($martes));
	$miercoles_text = date("d/M", strtotime($miercoles));
	$jueves_text = date("d/M", strtotime($jueves));
	$viernes_text = date("d/M", strtotime($viernes));
	$sabado_text = date("d/M", strtotime($sabado));	
*/	
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

/*
function dias_semana_grafico($objPHPExcel, $col, $fil, $per_agno, $sem_num, $hoja, $diasnoprod){

	$lunes  = date('Ymd', strtotime($per_agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));	
	if(!in_array($lunes, $diasnoprod)) {
		$lunes_text = date("d/M", strtotime($lunes));
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$lunes_text);
		$fil++;
	}
	
	$martes = date('Ymd', strtotime($lunes.' 1 day'));
	if(!in_array($martes, $diasnoprod)) {
		$martes_text = date("d/M", strtotime($martes));
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$martes_text);
		$fil++;
	}	

	$miercoles = date('Ymd', strtotime($lunes.' 2 day'));
	if(!in_array($miercoles, $diasnoprod)) {
		$miercoles_text = date("d/M", strtotime($miercoles));
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$miercoles_text);
		$fil++;
	}	
	
	$jueves = date('Ymd', strtotime($lunes.' 3 day'));
	if(!in_array($jueves, $diasnoprod)) {
		$jueves_text = date("d/M", strtotime($jueves));
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$jueves_text);
		$fil++;
	}
	
	$viernes = date('Ymd', strtotime($lunes.' 4 day'));
	if(!in_array($viernes, $diasnoprod)) {
		$viernes_text = date("d/M", strtotime($viernes));
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$viernes_text);
		$fil++;
	}	
	
	$sabado = date('Ymd', strtotime($lunes.' 5 day'));
	if(!in_array($sabado, $diasnoprod)) {
		$sabado_text = date("d/M", strtotime($sabado));	
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$sabado_text);
		$fil++;
	}		

}
*/

function dias_semana_grafico($objPHPExcel, $col, $fil, $per_agno, $sem_num, $hoja, $diasnoprod){

	$meses = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

	$lunes  = date('Ymd', strtotime($per_agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));	
	if(!in_array($lunes, $diasnoprod)) {
		$lunes_text = date("d", strtotime($lunes)).'/'.$meses[date("n", strtotime($lunes))-1];
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$lunes_text);
		$fil++;
	}
	
	$martes = date('Ymd', strtotime($lunes.' 1 day'));
	if(!in_array($martes, $diasnoprod)) {	
		$martes_text = date("d", strtotime($martes)).'/'.$meses[date("n", strtotime($martes))-1];		
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$martes_text);
		$fil++;
	}	

	$miercoles = date('Ymd', strtotime($lunes.' 2 day'));
	if(!in_array($miercoles, $diasnoprod)) {
		$miercoles_text = date("d", strtotime($miercoles)).'/'.$meses[date("n", strtotime($miercoles))-1];
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$miercoles_text);
		$fil++;
	}	
	
	$jueves = date('Ymd', strtotime($lunes.' 3 day'));
	if(!in_array($jueves, $diasnoprod)) {
		$jueves_text = date("d", strtotime($jueves)).'/'.$meses[date("n", strtotime($jueves))-1];
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$jueves_text);
		$fil++;
	}
	
	$viernes = date('Ymd', strtotime($lunes.' 4 day'));
	if(!in_array($viernes, $diasnoprod)) {
		$viernes_text = date("d", strtotime($viernes)).'/'.$meses[date("n", strtotime($viernes))-1];
		$objPHPExcel->setActiveSheetIndex($hoja)->setCellValueByColumnAndRow($col,$fil,$viernes_text);
		$fil++;
	}	
	
	$sabado = date('Ymd', strtotime($lunes.' 5 day'));
	if(!in_array($sabado, $diasnoprod)) {
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
				$cumplimiento =$cant/$meta_mini;
				//$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$row,$cumplimiento.'%');
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$row,$cumplimiento);	
			break;					
			case 59: //PINO 2DA
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$row,$cant);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8,$row,$meta_pino);
				$cumplimiento = $cant/$meta_pino;
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9,$row,$cumplimiento);						
			break;
			case 135: //MACRO 3ERA
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12,$row,$cant);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13,$row,$meta_macro);
				$cumplimiento = $cant/$meta_macro;
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