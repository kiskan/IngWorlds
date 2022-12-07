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
		$this->Image('../images/arauco.png');

		// Movernos a la derecha
		//$this->Cell(50);
		
		//Fecha
		$this->SetFont('Arial','',11);	
		
		$meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");	
		$fecha_actual = 'Arauco, '.date('d')." de ".$meses[date('n')-1]. " de ".date('Y');
		
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
$sprod_id = $_GET['sprod_id'];


// Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,0,utf8_decode('APROBACIÓN DE SOLICITUD'),0,0,'C');
$pdf->Ln(7);
$pdf->SetFont('Arial','B',11);
$subtexto= "Nro de Solicitud: $sprod_id";
$pdf->Cell(0,0,$subtexto,0,0,'C');

$pdf->Ln(10);
$pdf->SetFont('Arial','',10);
$sql = "SELECT U.USR_NOMBRE, U.USR_RUT, SPROD_TIPOCOMPRA, UNDVIV_NOMBRE, DATE_FORMAT(SPROD_DIA,'%d-%m-%Y') as FECHA_SOLICITUD, IFNULL(SPROD_MOTIVO,'') SPROD_MOTIVO
FROM SOLICITUD_PRODUCTOS AS SPROD 
JOIN UNIDAD_VIVEROS UV ON UV.UNDVIV_ID = SPROD.UNDVIV_ID
JOIN USUARIOS AS U ON U.USR_ID = SPROD.USR_ID_SOLIC
WHERE SPROD_ESTADO = 'PENDIENTE' AND SPROD_TIPOSOL = 'SC'
AND sprod_id = $sprod_id";
$resultcomment = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
$solicitud = mysqli_fetch_row($resultcomment);

$solicitante = $solicitud[0];
$rut_solicitante = $solicitud[1];
$tipo_compra = $solicitud[2];
$unidad = $solicitud[3];
$fecha_solicitud = $solicitud[4];
$comentario = $solicitud[5];

$texto_cabecera = "<p align='justify'>Sr/Sra $solicitante, Rut: $rut_solicitante, solicita aprobación para realizar compra de material o servicio para la unidad $unidad, con el siguiente detalle:</p>";

$pdf->WriteHTML(utf8_decode($texto_cabecera));

$pdf->Ln(10);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,0,'Motivo Compra',0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Write(5,utf8_decode($comentario));

$pdf->Ln(10);
//65+65+40+25 = 195
$pdf->SetFont('Arial','B',9);
//$pdf->SetAligns(array('L','L','L','L'));
if($tipo_compra == 'COMPRA MATERIAL'){
	
	$pdf->SetAligns(array('L','L','C','C','C','C'));
	$pdf->SetWidths(array(35,70,20,20,20,30));
	$pdf->Row(array("CATEGORIA", "MATERIAL", "CANT", "$ REF", "TOTAL", utf8_decode("APROBACIÓN")));

	$pdf->SetAligns(array('L','L','C','C','C','C'));
	$pdf->SetFont('Arial','',8);

	$sql = "select catprod_nombre, p.prod_nombre,sd.SPRODD_CANT, prod_valor, (SPRODD_CANT *prod_valor) total
	from SPROD_DETALLE sd
	JOIN SOLICITUD_PRODUCTOS s on s.sprod_id = sd.sprod_id
	join PRODUCTOS p on sd.prod_cod = p.prod_cod
	join CATEGORIA_PRODUCTO c on p.catprod_id = c.catprod_id 
	where SPROD_TIPOSOL = 'SC' AND sd.sprod_id = $sprod_id";	
	$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));

	$total = 0;
	while( $rows = mysqli_fetch_assoc($resultset) ) {
		$pdf->Row(array(utf8_decode($rows[catprod_nombre]),utf8_decode($rows[prod_nombre]),$rows[SPRODD_CANT],$rows[prod_valor],$rows[total],''));
		$total+=$rows[total];
	}
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',10);
	$texto_total = 'Costo Total de la compra: $'.$total;
	$pdf->Write(5,utf8_decode($texto_total));
	
}

elseif($tipo_compra == 'PRESTACIÓN SERVICIO'){
	
	$pdf->SetAligns(array('L','C'));
	$pdf->SetWidths(array(170,25));
	$pdf->Row(array("SERVICIO", "PLAZO"));

	//$pdf->SetAligns(array('L','C'));
	$pdf->SetFont('Arial','',8);

	$sql = "select SPRODD_SERVICIO,sd.SPRODD_CANT
	from SPROD_DETALLE sd
	JOIN SOLICITUD_PRODUCTOS s on s.sprod_id = sd.sprod_id
	where SPROD_TIPOSOL = 'SC' AND sd.sprod_id = $sprod_id";	
	$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));

	$total = 0;
	while( $rows = mysqli_fetch_assoc($resultset) ) {
		$pdf->Row(array(utf8_decode($rows[SPRODD_SERVICIO]),$rows[SPRODD_CANT]));
	}

	
}

$pdf->SetFont('Arial','',10);
// Firma
$jefe = utf8_decode('Jorge Andrés Bustos Tarbes');
$pdf->Ln(50);
$pdf->Cell(72,0,'',0,0,'L');
$pdf->Cell(50,0,'','B',0,'R');
//$pdf->Cell(70,0,'',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(0,0,'Aprueba '.$jefe,0,0,'C');
$pdf->Ln(5);
$pdf->Cell(0,0,'17.344.882-1',0,0,'C');




	
$pdf->Output('D','Solicitud de Compra.pdf');
//$pdf->Output();
?>