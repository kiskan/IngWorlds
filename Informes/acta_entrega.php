<?php

if(empty($_GET['sprod_id'])) die(header ("Location:../bod_retprod.php"));
	

function formateo_rut($rut){
	
	$srut = explode("-",$rut);
	$irut = $srut[0];
	$frut = $srut[1];
	
	return number_format($irut,0,",",".")."-".$frut; 	
}

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
		// Iniciaci??e variables
		$this->B = 0;
		$this->I = 0;
		$this->U = 0;
		$this->HREF = '';
	}

	// Cabecera de p?na
	function Header()
	{
		// Logo
		$this->Image('../images/arauco.png');

		// Movernos a la derecha
		//$this->Cell(50);
		
		//Fecha
		$this->SetFont('Arial','',11);	
		
		$meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");	
		$fecha_actual = 'Arauco, '.date('d')." de ".$meses[date('n')-1]. " de ".date('Y');
		
		$this->Cell(0,0,$fecha_actual,0,0,'R');

		// Salto de l?a
		$this->Ln(18);
	}

	// Pie de página
	function Footer()
	{
		// Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Número de página
		//$this->Cell(0,10,'Pág '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	// Pie de página personalizado
	function Footerv2($pie)
	{
		// Posición: a 1,5 cm del final
		$this->SetY(245);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Número de página
		//$this->Cell(0,10,$pie,0,0,'C');
		$this->Cell(0,0,$pie,0,0,'R');
		//$pdf->Cell(90,0,'',0,0,'R');
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

$sprod_id = $_GET['sprod_id'];

$sql = "SELECT DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as SPROD_DIA, US1.USR_RUT AS RUT_SOLICITANTE, US1.USR_NOMBRE AS SOLICITANTE,
		(CASE WHEN SPROD_TIPORETIRA = 'U' THEN US.USR_RUT WHEN SPROD_TIPORETIRA = 'O' THEN OP.OPER_RUT END) as RUT_QUIEN_RETIRA,
		(CASE WHEN SPROD_TIPORETIRA = 'U' THEN US.USR_NOMBRE WHEN SPROD_TIPORETIRA = 'O' THEN CONCAT(OPER_NOMBRES,' ',OPER_PATERNO,' ',OPER_MATERNO) ELSE '' END) as QUIEN_RETIRA,
		IFNULL(SPROD_FOLIO,0)SPROD_FOLIO
		FROM SOLICITUD_PRODUCTOS AS SPROD 
		JOIN USUARIOS AS US1 ON US1.USR_ID = SPROD.USR_ID_SOLIC
		LEFT JOIN USUARIOS AS US ON US.USR_ID = SPROD.USR_ID_RETIRA		
		LEFT JOIN OPERADOR AS OP ON OP.OPER_RUT = SPROD.OPER_RUT_RETIRA
		WHERE SPROD.SPROD_ID = $sprod_id";	
$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));

$row_sol = mysqli_num_rows($resultado);

$encabezado = mysqli_fetch_row($resultado);
$dia_solicitud = $encabezado[0];	
$rut_solicitante = $encabezado[1];
$solicitante = utf8_decode($encabezado[2]);
$rut_quien_retira = $encabezado[3];
$quien_retira = utf8_decode($encabezado[4]);
$sprod_folio = $encabezado[5];

if($sprod_folio == 0){
	$sql = "select case when IFNULL(MAX(SPROD_FOLIO),0) = 0 THEN 1 else MAX(SPROD_FOLIO) + 1 END AS MAX_SPROD_FOLIO   
	from SOLICITUD_PRODUCTOS";
	$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));	

	$MAX_SPROD_FOLIO = mysqli_fetch_row($resultado);
	$sprod_folio = $MAX_SPROD_FOLIO[0];
	
	$sql = "UPDATE SOLICITUD_PRODUCTOS SET SPROD_FOLIO = $sprod_folio WHERE SPROD_ID = $sprod_id";
	$resultado = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));		
}

$sql = "select p.SAP_COD, p.SAP_NOMBRE, p.PROD_NOMBRE, sd.SPRODR_CANT from PRODUCTOS p
join SPROD_DETALLE sd on sd.prod_cod = p.prod_cod
where sd.sprod_id = $sprod_id";		
$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));

$row_prod = mysqli_num_rows($resultset);

if($row_sol == 0 or $row_prod == 0 or $dia_solicitud == ''  or $rut_solicitante == ''  or $solicitante == ''  or $rut_quien_retira == '' or $quien_retira == '' )
	die(header ("Location:../bod_retprod.php"));



// Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();


/*
	
En el presente documento se formaliza la entrega de elementos de bodega al Sr/Sra  XXXXXXXXXXXX  Rut: XX.XXX.XXX-X solicitados por el Supervisor /Jefe de área XXXXXXXXXX  Rut: XX.XXX.XXX-X el día  dd/mm/aa , numero de solicitud Nº xx	
*/	
/*
$encabezado = mysqli_fetch_row($resultado);
$dia_solicitud = $encabezado[0];	
$rut_solicitante = $encabezado[1];
$solicitante = $encabezado[2];
$rut_quien_retira = $encabezado[3];
$quien_retira = $encabezado[4];
*/
$pdf->SetFont('Arial','',15);
$html = "<b>FOLIO</b>: ".$sprod_folio;
$pdf->WriteHTML($html);
$pdf->Ln(7);
$pdf->SetFont('Arial','',11);

$html1 = "<p style='text-align:Justify;'>En el presente documento se formaliza la entrega de elementos de bodega al Sr/Sra <b>";
$html2 = "</b>, Rut: ";
$html3 = ", solicitados por el Supervisor / Jefe de área <b>";
$html4 = "</b>, Rut: ";
$html5 = " el día <b>";
//$html6 = "</b>, solicitud Nº: <b>";
$html7 = "</b> </p>";

$html = $html1.$quien_retira.$html2.formateo_rut($rut_quien_retira).$html3.$solicitante.$html4.formateo_rut($rut_solicitante).$html5.$dia_solicitud./*$html6.$sprod_id.*/$html7;

$pdf->WriteHTML($html);

$pdf->Ln(15);
$pdf->WriteHTML('Descripción de ítems:');
$pdf->Ln(7);

$pdf->SetFont('Arial','B',10);

$pdf->SetAligns(array('C','C','C','C','C'));

$pdf->SetWidths(array(10,25,65,65,25));
//max195
$pdf->Row(array("N°", "COD. MATERIAL", "MATERIAL SAP", "MATERIAL SISCONVI", "CANTIDAD"));

$pdf->SetFont('Arial','',8);
$pdf->SetAligns(array('C','C','L','L','C'));

$k  = 1;

while( $rows = mysqli_fetch_assoc($resultset) ) {
	$pdf->Row(array($k,$rows[SAP_COD],utf8_decode($rows[SAP_NOMBRE]),utf8_decode($rows[PROD_NOMBRE]),$rows[SPRODR_CANT]));
	$k++;
}

$pdf->Ln(15);
$pdf->SetFont('Arial','',11);

$html = "<p style='text-align:Justify;'>Dejamos constancia que la bodega de Vivero Horcones ha entregado los materiales de la solicitud realizada, han sido verificados y están conforme a las especificaciones y recibidos de conformidad.<br /><br />Al firmar el comprobante declaro haber recibido conforme el material.</p>";	
$pdf->WriteHTML($html);

$html = "<br /><br /><p style='text-align:Justify;'><b>NOTA</b>: Si usted solicitó un material para ser utilizado en un cargo específico, en caso de desvinculación de la empresa usted deberá devolver el material a la empresa mandante, esto bajo el dictamen de la inspección del trabajo 2780/130 de 23.07.01.</p>";	
$pdf->WriteHTML($html);


// Firma

$pdf->Ln(50);
$pdf->Cell(72,0,'',0,0,'L');
$pdf->Cell(50,0,'','B',0,'R');
//$pdf->Cell(70,0,'',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(0,0,'Firma Quien Retira',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(0,0,formateo_rut($rut_quien_retira),0,0,'C');
$pdf->Ln(5);
$pdf->Cell(0,0,$quien_retira,0,0,'C');

/*
$pdf->Cell(50,0,'','B',0,'L');
$pdf->Cell(90,0,'',0,0,'R');
$pdf->Cell(50,0,'','B',0,'L');
$pdf->Ln(5);
$pdf->Cell(50,0,'Firma Bodega',0,0,'C');
$pdf->Cell(90,0,'',0,0,'R');
$pdf->Cell(50,0,'Firma Solicitante',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(50,0,'Rut: 3.796.372-8',0,0,'C');
$pdf->Cell(90,0,'',0,0,'R');
$pdf->Cell(50,0,'Rut: 3.796.372-8',0,0,'C');
*/

$pdf->Footerv2('Copia Bodega');



//----------------------------------------------------------------------------------------------------------------



$pdf->AddPage();

$pdf->SetFont('Arial','',15);
$html = "<b>FOLIO</b>: ".$sprod_folio;
$pdf->WriteHTML($html);
$pdf->Ln(7);
$pdf->SetFont('Arial','',11);

$html1 = "<p style='text-align:Justify;'>En el presente documento se formaliza la entrega de elementos de bodega al Sr/Sra <b>";
$html2 = "</b>, Rut: ";
$html3 = ", solicitados por el Supervisor / Jefe de área <b>";
$html4 = "</b>, Rut: ";
$html5 = " el día <b>";
//$html6 = "</b>, solicitud Nº: <b>";
$html7 = "</b> </p>";

$html = $html1.$quien_retira.$html2.formateo_rut($rut_quien_retira).$html3.$solicitante.$html4.formateo_rut($rut_solicitante).$html5.$dia_solicitud./*$html6.$sprod_id.*/$html7;

$pdf->WriteHTML($html);

$pdf->Ln(15);
$pdf->WriteHTML('Descripción de ítems:');
$pdf->Ln(7);

$pdf->SetFont('Arial','B',10);

$pdf->SetAligns(array('C','C','C','C','C'));

$pdf->SetWidths(array(10,25,65,65,25));
//max195
$pdf->Row(array("N°", "COD. MATERIAL", "MATERIAL SAP", "MATERIAL SISCONVI", "CANTIDAD"));

$pdf->SetFont('Arial','',8);
$pdf->SetAligns(array('C','C','L','L','C'));

$sql = "select p.SAP_COD, p.SAP_NOMBRE, p.PROD_NOMBRE, sd.SPRODR_CANT from PRODUCTOS p
join SPROD_DETALLE sd on sd.prod_cod = p.prod_cod
where sd.sprod_id = $sprod_id";	

$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));


$k  = 1;

while( $rows2 = mysqli_fetch_assoc($resultset) ) {
	$pdf->Row(array($k,$rows2[SAP_COD],utf8_decode($rows2[SAP_NOMBRE]),utf8_decode($rows2[PROD_NOMBRE]),$rows2[SPRODR_CANT]));
	$k++;
}

$pdf->Ln(15);
$pdf->SetFont('Arial','',11);

$html = "<p style='text-align:Justify;'>Dejamos constancia que la bodega de Vivero Horcones ha entregado los materiales de la solicitud realizada, han sido verificados y están conforme a las especificaciones y recibidos de conformidad.<br /><br />Al firmar el comprobante declaro haber recibido conforme el material.</p>";	
$pdf->WriteHTML($html);

$html = "<br /><br /><p style='text-align:Justify;'><b>NOTA</b>: Si usted solicitó un material para ser utilizado en un cargo específico, en caso de desvinculación de la empresa usted deberá devolver el material a la empresa mandante, esto bajo el dictamen de la inspección del trabajo 2780/130 de 23.07.01.</p>";	
$pdf->WriteHTML($html);


// Firma

$pdf->Ln(50);
$pdf->Cell(72,0,'',0,0,'L');
$pdf->Cell(50,0,'','B',0,'R');
//$pdf->Cell(70,0,'',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(0,0,'Firma Quien Retira',0,0,'C');
$pdf->Ln(5);
$pdf->Cell(0,0,formateo_rut($rut_quien_retira),0,0,'C');
$pdf->Ln(5);
$pdf->Cell(0,0,$quien_retira,0,0,'C');
/*
$pdf->SetY(-30);
$copia = "<p style='text-align:Center;font-style: italic;font-size:8px'>Copia Solicitante</p>";
$pdf->WriteHTML($copia);
*/

$pdf->Footerv2('Copia Quien Retira');
/*
$pdf->SetY(-30);
$pdf->SetFont('Times','BIU',8);
$pdf->Text(70,'','Copia Solicitante');
*/
$nombre_archivo = 'Acta_Entrega_Solic_'.$sprod_id.'.pdf';

//$pdf->Output();
$pdf->Output($nombre_archivo,'D');




?>
