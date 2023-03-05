<?php
require '../../fpdf185/fpdf.php';
require 'Conexion.php';

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    $this->SetFont('Times','',16);
    $this->Image('tephe.png',10,8,32);
    $this->SetXY(80,15);
    $this->Cell(55,8,'Reporte de Salida de Transporte Publico',0,0,'C',0);
    $this->Ln(45);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(20,10,utf8_decode('Pagina ').$this->PageNo().'/{nb}',0,0,'C'); 
}
//----------------------------METODO PARA ADAPTAR LAS CELDAS-----------------------------------
protected $widths;
    protected $aligns;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data,$setX)
    {
        // Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++)
            $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h = 5*$nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x,$y,$w,$h);
            // Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            // Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        // Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if(!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',(string)$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
//-----------------------------------------------------------
}
//------------------OBTENES LOS DATOS DE LA BASE DE DATOS-------------------------
    $data=new Conexion();
	$conexion=$data->conect();
	$strquery ="SELECT * FROM hora_sal_tb";
	$result = $conexion->prepare($strquery);
	$result->execute();
	$data = $result->fetchall(PDO::FETCH_ASSOC);

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage(); //añade la pagina en blanco
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(true,30); //salto de pagina en automatico
// -----------ENCABEZADO------------------
$pdf->SetX(11);
$pdf->SetFont('Helvetica','B',9.1);
$pdf->Cell(30,8,'Id de transporte',0,0,'C',0);
$pdf->Cell(80,8,'Ruta',0,0,'C',0);
$pdf->Cell(30,8,'Hora de Entrada',0,0,'C',0);
$pdf->Cell(40,8,'Fecha',0,1,'C',0);

$pdf->Ln(0.5);
// -------TERMINA----ENCABEZADO------------------
$pdf->SetFont('Arial','',10);
//ancho de las celdas
$pdf->SetWidths(array(30, 80, 30, 40));
for($i=1;$i<count($data);$i++)
$pdf->Ln(0.5);



for ($i = 0; $i < count($data); $i++) {
    $pdf->SetX(11);
    $pdf->Row(array($data[$i]['id_trans'], ucwords(strtolower(utf8_decode($data[$i]['ruta']))), 
    $data[$i]['hr_sal'], $data[$i]['fecha']), 15);
}



$pdf->Output();

?>