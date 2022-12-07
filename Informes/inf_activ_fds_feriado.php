<?php

require('../../vendors/fpdf181/fpdf.php');

class PDF extends FPDF
{
var $widths;
var $aligns;

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}

	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,5,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}
	
	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger){
			$this->AddPage($this->CurOrientation);
		}
	}

	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}


var $B;
var $I;
var $U;
var $HREF;

	function PDF($orientation='P', $unit='mm', $size='Letter')
	{
		$this->__construct($orientation,$unit,$size);
		// Llama al constructor de la clase padre
		//$this->FPDF($orientation,$unit,$size);
		// Iniciaci󮠤e variables
		$this->B = 0;
		$this->I = 0;
		$this->U = 0;
		$this->HREF = '';
	}

	// Cabecera de p⨩na
	function Header()
	{
		// Logo
		$this->Image('../images/logosotrosur_pdf.png');

		// Movernos a la derecha
		//$this->Cell(50);
		
		//Fecha
		$this->SetFont('Arial','',11);	
		
		$meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");	
		$fecha_actual = 'Sotrosur, '.date('d')." de ".$meses[date('n')-1]. " de ".date('Y');
		
		$this->Cell(0,0,$fecha_actual,0,0,'R');

		// Salto de la
		$this->Ln(18);
	}

	// Pie de p⨩na
	function Footer()
	{
		// Posici󮺠a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',9);
		// Número de pagina
		$this->Cell(0,10,'Pag'.$this->PageNo().'/{nb}',0,0,'C');
	}	

	function WriteHTML($html)
	{
		// Intérprete de HTML
		$html = str_replace("\n",' ',$html);
		$a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
		foreach($a as $i=>$e)
		{
			if($i%2==0)
			{
				// Text
				if($this->HREF)
					$this->PutLink($this->HREF,$e);
				else
					$this->Write(5,$e);
			}
			else
			{
				// Etiqueta
				if($e[0]=='/')
					$this->CloseTag(strtoupper(substr($e,1)));
				else
				{
					// Extraer atributos
					$a2 = explode(' ',$e);
					$tag = strtoupper(array_shift($a2));
					$attr = array();
					foreach($a2 as $v)
					{
						if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
							$attr[strtoupper($a3[1])] = $a3[2];
					}
					$this->OpenTag($tag,$attr);
				}
			}
		}
	}

	function OpenTag($tag, $attr)
	{
		// Etiqueta de apertura
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,true);
		if($tag=='A')
			$this->HREF = $attr['HREF'];
		if($tag=='BR')
			$this->Ln(5);
	}

	function CloseTag($tag)
	{
		// Etiqueta de cierre
		if($tag=='B' || $tag=='I' || $tag=='U')
			$this->SetStyle($tag,false);
		if($tag=='A')
			$this->HREF = '';
	}

	function SetStyle($tag, $enable)
	{
		// Modificar estilo y escoger la fuente correspondiente
		$this->$tag += ($enable ? 1 : -1);
		$style = '';
		foreach(array('B', 'I', 'U') as $s)
		{
			if($this->$s>0)
				$style .= $s;
		}
		$this->SetFont('',$style);
	}

	function PutLink($URL, $txt)
	{
		// Escribir un hiper-enlace
		$this->SetTextColor(0,0,255);
		$this->SetStyle('U',true);
		$this->Write(5,$txt,$URL);
		$this->SetStyle('U',false);
		$this->SetTextColor(0);
	}
	
}

//Conección BD
include('../consultas/coneccion.php');

//Variables
$per_agno = $_GET['per_agno'];
$per_mes = $_GET['per_mes'];
$sem_num = $_GET['sem_num'];
$sem_txt = $_GET['sem_txt'];

$lunes  = date('Ymd', strtotime($per_agno . 'W' . str_pad($sem_num , 2, '0', STR_PAD_LEFT)));
$sabado = 'SAB '.date('d', strtotime($lunes.' 5 day'));
$domingo = 'DOM '.date('d', strtotime($lunes.' 6 day'));

// Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,0,'ACTIVIDADES FIN DE SEMANA Y FERIADOS',0,0,'C');
$pdf->Ln(7);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,0,$sem_txt,0,0,'C');

$pdf->Ln(15);


//Resumen Jefes de Grupos
$sql = "
SELECT 
 CASE WHEN TIPO_JEFEGRUPO = 'SUPERVISOR' THEN CONCAT(SUP.SUP_NOMBRES,' ',SUP.SUP_PATERNO,' ',SUP.SUP_MATERNO) WHEN TIPO_JEFEGRUPO = 'OPERADOR' THEN CONCAT(OPER.OPER_NOMBRES,' ',OPER.OPER_PATERNO,' ',OPER.OPER_MATERNO) ELSE '' END AS JEFE_GRUPO, AREA.AREA_NOMBRE AS AREA,
GROUP_CONCAT((ELT(WEEKDAY(PLAN.PLAN_DIA) + 1, 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO', 'DOMINGO'))
 ORDER BY WEEKDAY(PLAN.PLAN_DIA)ASC SEPARATOR ', ')AS DIA,
CASE WHEN TIPO_JEFEGRUPO = 'SUPERVISOR' THEN SUP.SUP_FONO WHEN TIPO_JEFEGRUPO = 'OPERADOR' THEN OPER.OPER_FONO ELSE '' END AS FONO_JEFEGRUPO
FROM PLANIFICACION_EXTRA AS PLAN 
JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
LEFT JOIN SUPERVISOR AS SUP ON SUP.SUP_RUT = PLAN.SUP_RUT
LEFT JOIN OPERADOR AS OPER ON OPER.OPER_RUT = PLAN.OPER_RUT
JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
WHERE SEM.SEM_NUM = $sem_num AND SEM.PER_AGNO = $per_agno
AND (WEEKDAY(PLAN.PLAN_DIA) IN (5,6) OR PLAN.PLAN_DIA IN (
SELECT DF.DIAS FROM DIAS_FERIADOS AS DF WHERE DF.SEM_NUM = $sem_num AND DF.PER_AGNO = $per_agno))
GROUP BY JEFE_GRUPO, AREA, FONO_JEFEGRUPO
ORDER BY AREA, DIA ASC";

$result1 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,0,'JEFES DE GRUPO',0,0,'L');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',9);
$pdf->SetWidths(array(65,65,40,25));
$pdf->Row(array("JEFE GRUPO", "AREA", "DIAS", "FONO"));
$pdf->SetAligns(array('L','L','L','L'));
$pdf->SetFont('Arial','',9);
while( $rows = mysqli_fetch_assoc($result1) ) {
	$pdf->Row(array(utf8_decode($rows[JEFE_GRUPO]),$rows[AREA],$rows[DIA],$rows[FONO_JEFEGRUPO]));
}
$pdf->Ln(15);



//Resumen Cantidad de Personas por AREA

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,0,'CANTIDAD PERSONAS POR AREA',0,0,'L');
$pdf->Ln(4);

$sql = "
SELECT 
AREA.AREA_NOMBRE AS AREA,
SUM(CASE WHEN WEEKDAY(PLAN.PLAN_DIA) = 0 THEN 1 ELSE 0 END) AS LUN,
SUM(CASE WHEN WEEKDAY(PLAN.PLAN_DIA) = 1 THEN 1 ELSE 0 END) AS MAR,
SUM(CASE WHEN WEEKDAY(PLAN.PLAN_DIA) = 2 THEN 1 ELSE 0 END) AS MIE,
SUM(CASE WHEN WEEKDAY(PLAN.PLAN_DIA) = 3 THEN 1 ELSE 0 END) AS JUE,
SUM(CASE WHEN WEEKDAY(PLAN.PLAN_DIA) = 4 THEN 1 ELSE 0 END) AS VIE,
SUM(CASE WHEN WEEKDAY(PLAN.PLAN_DIA) = 5 THEN 1 ELSE 0 END) AS SAB,
SUM(CASE WHEN WEEKDAY(PLAN.PLAN_DIA) = 6 THEN 1 ELSE 0 END) AS DOM
FROM 
PLANIFICACION_EXTRA_OPER AS PLANO
JOIN PLANIFICACION_EXTRA AS PLAN ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID
JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
JOIN AREA AS AREA ON AREA.AREA_ID = ACT.AREA_ID
WHERE SEM.SEM_NUM = $sem_num AND SEM.PER_AGNO = $per_agno
AND (WEEKDAY(PLAN.PLAN_DIA) IN (5,6) OR PLAN.PLAN_DIA IN (
SELECT DF.DIAS FROM DIAS_FERIADOS AS DF WHERE DF.SEM_NUM = $sem_num AND DF.PER_AGNO = $per_agno))
GROUP BY AREA
";
$result2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));

$sql = "
SELECT ELT(WEEKDAY(DIAS) + 1, 'LUN', 'MAR', 'MIE', 'JUE', 'VIE') DIAS_FERIADOS FROM DIAS_FERIADOS  WHERE SEM_NUM = $sem_num AND PER_AGNO = $per_agno and WEEKDAY(DIAS) NOT IN (5,6) order by WEEKDAY(DIAS) asc";
$resp_dias_feriados = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
$rowcount = mysqli_num_rows($resp_dias_feriados);

$SetWidths = array(65,18,18);
$SetAligns = array('L','C','C');
$Row = array("AREA", $sabado, $domingo);

while( $rows_dinamic = mysqli_fetch_assoc($resp_dias_feriados) ) {
	array_push($Row, $rows_dinamic[DIAS_FERIADOS]);
	array_push($SetWidths, 18);
	array_push($SetAligns, 'C');
}	

$pdf->SetFont('Arial','B',9);
$pdf->SetWidths($SetWidths);
$pdf->SetAligns($SetAligns);
$pdf->Row($Row);

$pdf->SetFont('Arial','',9);

while( $rows_val = mysqli_fetch_assoc($result2) ) {
	
	$campo = array(utf8_decode($rows_val[AREA]),$rows_val[SAB],$rows_val[DOM]);	
	if(in_array("LUN", $Row)){ array_push($campo, $rows_val[LUN]); }
	if(in_array("MAR", $Row)){ array_push($campo, $rows_val[MAR]); }
	if(in_array("MIE", $Row)){ array_push($campo, $rows_val[MIE]); }
	if(in_array("JUE", $Row)){ array_push($campo, $rows_val[JUE]); }
	if(in_array("VIE", $Row)){ array_push($campo, $rows_val[VIE]); }	
	$pdf->Row($campo);
}

$pdf->Ln(15);




//Resumen Cantidad de Personas por Localidad
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,0,'CANTIDAD PERSONAS POR LOCALIDAD',0,0,'L');
$pdf->Ln(4);

$sql = "
SELECT 
CMN.CMN_NOMBRE AS LOCALIDAD, 
SUM(CASE WHEN WEEKDAY(PLAN.PLAN_DIA) = 0 THEN 1 ELSE 0 END) AS LUN,
SUM(CASE WHEN WEEKDAY(PLAN.PLAN_DIA) = 1 THEN 1 ELSE 0 END) AS MAR,
SUM(CASE WHEN WEEKDAY(PLAN.PLAN_DIA) = 2 THEN 1 ELSE 0 END) AS MIE,
SUM(CASE WHEN WEEKDAY(PLAN.PLAN_DIA) = 3 THEN 1 ELSE 0 END) AS JUE,
SUM(CASE WHEN WEEKDAY(PLAN.PLAN_DIA) = 4 THEN 1 ELSE 0 END) AS VIE,
SUM(CASE WHEN WEEKDAY(PLAN.PLAN_DIA) = 5 THEN 1 ELSE 0 END) AS SAB,
SUM(CASE WHEN WEEKDAY(PLAN.PLAN_DIA) = 6 THEN 1 ELSE 0 END) AS DOM
FROM 
PLANIFICACION_EXTRA_OPER AS PLANO
JOIN PLANIFICACION_EXTRA AS PLAN ON PLAN.PLAN_DIA = PLANO.PLAN_DIA AND PLAN.ACTIV_ID = PLANO.ACTIV_ID
JOIN SEMANAS AS SEM ON PLAN.PER_AGNO = SEM.PER_AGNO AND PLAN.SEM_NUM = SEM.SEM_NUM
JOIN ACTIVIDAD AS ACT ON ACT.ACTIV_ID = PLAN.ACTIV_ID
JOIN OPERADOR AS OPER_EXTRA ON OPER_EXTRA.OPER_RUT = PLANO.OPER_RUT
JOIN COMUNA AS CMN ON OPER_EXTRA.CMN_CODIGO = CMN.CMN_CODIGO
WHERE SEM.SEM_NUM = $sem_num AND SEM.PER_AGNO = $per_agno
AND (WEEKDAY(PLAN.PLAN_DIA) IN (5,6) OR PLAN.PLAN_DIA IN (
SELECT DF.DIAS FROM DIAS_FERIADOS AS DF WHERE DF.SEM_NUM = $sem_num AND DF.PER_AGNO = $per_agno))
GROUP BY LOCALIDAD
";
$result2 = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));

$sql = "
SELECT ELT(WEEKDAY(DIAS) + 1, 'LUN', 'MAR', 'MIE', 'JUE', 'VIE') DIAS_FERIADOS FROM DIAS_FERIADOS  WHERE SEM_NUM = $sem_num AND PER_AGNO = $per_agno and WEEKDAY(DIAS) NOT IN (5,6) order by WEEKDAY(DIAS) asc";
$resp_dias_feriados = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
$rowcount = mysqli_num_rows($resp_dias_feriados);

$SetWidths = array(65,18,18);
$SetAligns = array('L','C','C');
$Row = array("LOCALIDAD", $sabado, $domingo);

while( $rows_dinamic = mysqli_fetch_assoc($resp_dias_feriados) ) {
	array_push($Row, $rows_dinamic[DIAS_FERIADOS]);
	array_push($SetWidths, 18);
	array_push($SetAligns, 'C');
}	

$pdf->SetFont('Arial','B',9);
$pdf->SetWidths($SetWidths);
$pdf->SetAligns($SetAligns);
$pdf->Row($Row);

$pdf->SetFont('Arial','',9);

while( $rows_val = mysqli_fetch_assoc($result2) ) {
	
	$campo = array(utf8_decode($rows_val[LOCALIDAD]),$rows_val[SAB],$rows_val[DOM]);	
	if(in_array("LUN", $Row)){ array_push($campo, $rows_val[LUN]); }
	if(in_array("MAR", $Row)){ array_push($campo, $rows_val[MAR]); }
	if(in_array("MIE", $Row)){ array_push($campo, $rows_val[MIE]); }
	if(in_array("JUE", $Row)){ array_push($campo, $rows_val[JUE]); }
	if(in_array("VIE", $Row)){ array_push($campo, $rows_val[VIE]); }	
	$pdf->Row($campo);
}


$pdf->Ln(15);




//RESPONSABLES FIN DE SEMANA

$sql = "SELECT * FROM RESP_FDS WHERE SEM_NUM = $sem_num AND PER_AGNO = $per_agno";

$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,0,'RESPONSABLES FIN DE SEMANA',0,0,'L');
$pdf->Ln(4);
$pdf->SetFont('Arial','B',9);

$pdf->SetAligns(array('L','L','L'));

$pdf->SetWidths(array(55,80,30));
$pdf->Row(array("RESPONSABILIDAD","NOMBRE", "CELULAR"));
$fila = mysqli_fetch_row($resultado);
$RESP_PROD = $fila[2];
$RESP_PRODXFONO = $fila[3];
$BRIGAD_SAB = $fila[4];
$BRIGAD_SABXFONO = $fila[5];
$BRIGAD_DOM = $fila[6];
$BRIGAD_DOMXFONO = $fila[7];
$RESP_MAN1 = $fila[8];
$RESP_MANXFONO1 = $fila[9];
$RESP_MAN2 = $fila[10];
$RESP_MANXFONO2 = $fila[11];

$RESP1 = "PRODUCCION";	
$RESP2 = "BRIGADISTA TURNO ".$sabado;
$RESP3 = "BRIGADISTA TURNO ".$domingo;
$RESP4 = "MANTENIMIENTO";	
$pdf->SetFont('Arial','',9);

$pdf->Row(array($RESP1,utf8_decode($RESP_PROD),$RESP_PRODXFONO));
$pdf->Row(array($RESP2,utf8_decode($BRIGAD_SAB),$BRIGAD_SABXFONO));
$pdf->Row(array($RESP3,utf8_decode($BRIGAD_DOM),$BRIGAD_DOMXFONO));
$pdf->Row(array($RESP4,utf8_decode($RESP_MAN1),$RESP_MANXFONO1));
$pdf->Row(array($RESP4,utf8_decode($RESP_MAN2),$RESP_MANXFONO2));
$pdf->Ln(15);


	
$pdf->Output('D','Informe Actividades FDS y Feriados.pdf');
//$pdf->Output();
?>