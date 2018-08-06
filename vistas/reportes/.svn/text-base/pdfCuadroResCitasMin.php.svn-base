<?php
session_start();

require('../../modelos/conexion.php');
require('../../modelos/fpdf/mc_table.php');
require('../../controlador/funciones.php');
require('../../modelos/citas.php');
require('../../modelos/beneficiario.php');
require('../../modelos/pago.php');
require('../../modelos/banco.php');
define('FPDF_FONTPATH', 'font/');


$objCitas= new citas();
$objBeneficiario=new beneficiario();
$objPago = new pago();
$objBanco = new banco();

 //$tipoBen = $_GET['tipo'];
 $desde  = $_GET['fechaD'];
 $hasta = $_GET['fechaH'];

 //echo "Desde: ".$desde." hasta".$hasta;

 //$banco   = $_GET['banco'];


$fecha=date('d/m/Y');
$dia=date("d");
$mes=date("m");
$ano=date("Y");

$nroCampos = 6;
$listarCitas = $objCitas->cuadroResumenCitasMin($tipoBen,$desde,$hasta,$banco);

// Encabezado del pdf
$pdf = new PDF_Mc_Table('L', 'mm','Letter');
$pdf->AddPage();

$pdf->SetFont('Arial','B',15);
$pdf->SetXY(10,30);

   if (($desde) and ($hasta))
	 	$titulo1 = 'Citas Otorgadas desde el '.$desde.' hasta el '.$hasta;
   elseif (($desde) and !($hasta))
   {
		$dia=substr($desde,0,2);
		$mes=substr($desde,3,2);
		$ano=substr($desde,6,10);
		$titulo1 = 'Citas Otorgadas desde el '.$dia.' de '.ObtenerMesenLetras($mes).' de '.$ano;
   }
   elseif (!($desde) and ($hasta)){
        $dia=substr($hasta,0,2);
		$mes=substr($hasta,3,2);
		$ano=substr($hasta,6,10);
   		$titulo1 = 'Citas Otorgadas hasta el '.$dia.' de '.ObtenerMesenLetras($mes).' de '.$ano;
   }
   else $titulo1 = 'Citas Otorgadas al '.$dia.' de '.ObtenerMesenLetras($mes).' de '.$ano;

   $pdf->Cell(255,5,'Lapso: Enero al '.$fecha,0,0,'R');
   $pdf->Ln(10);
   $pdf->Cell(255,5,'CITAS OTORGADAS',0,1,'C');

   $pdf->Ln(10);
   $pdf->SetFillColor(252,223,172);
   $pdf->SetTextColor(0);

$pdf->SetBorder(false);
$pdf->SetWidths(array(55,61,61,70));
$pdf->SetAligns(array('C','C','C','C'));

$x=$pdf->getX();
$y=$pdf->getY();
$pdf->setXY($x,$y);
$pdf->Cell(177,25,'',0,0,'C',1);
$pdf->setXY($x,$y);
$pdf->SetFont('Arial','B',15);
$pdf->setjump(15);
$pdf->Row(array(utf8_decode(" \n Citas Otorgadas  \n por Sistema \n "),utf8_decode("\n Expedientes reecibidos por Citas Otorgadas\n "),
                utf8_decode(" \n Solicitantes Pendientes  \n por Asistir \n")));


$pdf->setXY(187,$y);
$pdf->Cell(76,6,'Diferencia',1,0,'C',1);
$pdf->setXY(187,$y+6);
$pdf->SetFont('Arial','B',12);
$pdf->multiCell(35,6.3,"Personas que no asistieron a  la cita",1,'C',1);
$pdf->setXY(221,$y+6);
$pdf->multiCell(42,19,"Observaciones",1,'C',1);
$pdf->SetFont('Arial','B',12);
$pdf->setXY($x,$y+25);
$anch_ = array(55,61,61,34,42);
$alin_ = array('C','C','C','C','C');
$c ='TOTALES';



$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);

$pdf->setjump(10);

$totalC = $listarCitas[1]+$listarCitas[2]+$listarCitas[3];

$pdf->SetFont('Arial','B',13);
$pdf->setjump(15);
$pdf->Row(array(" \n \n  ".FormatoMonto($totalC,0)
                ,($listarCitas[1]==0)?"":" \n \n  ".FormatoMonto($listarCitas[1],0)
                ,($listarCitas[2]==0)?"":" \n \n  ".FormatoMonto($listarCitas[2],0)
                ,($listarCitas[3]==0)?"":" \n \n  ".FormatoMonto($listarCitas[3],0)
                ," \n Personas no asistieron en la fecha y hora asignada en la hoja de cita \n "
               ));
$pdf->setjump(10);

$anch1_ = array(70,110,73);
$alin1_ = array('C','C','C');
$pdf->SetWidths($anch1_);
$pdf->SetAligns($alin1_);
$pdf->SetBorder(true);
$pdf->setjump(10);
$pdf->Ln(15);
 $pdf->SetFillColor(252,223,172);
   $pdf->SetTextColor(0);
   $pdf->Cell(253,10,utf8_decode('Resumen Población Atendida'),1,0,'C',1);
$pdf->Ln();
   $pdf->SetFillColor(255,244,212);
   $pdf->Cell(70,10,'Citas Otorgadas por Sistema ',1,0,'C',1);
   $pdf->Cell(110,10,"Solicitantes Registrados pendientes por cita",1,0,'C',1);
   $pdf->Cell(73,10,'Total Poblacion Atendida',1,0,'C',1);
$pdf->Ln();
$pdf->setjump(15);
$pdf->Row(array( " \n \n  ".FormatoMonto($totalC,0)." \n \n  "
                ,($listarCitas[4]==0)?"":" \n \n  ".FormatoMonto($listarCitas[4],0) + 0.001 ." \n \n  "
                ,($listarCitas[4]==0)?"":" \n \n  ".FormatoMonto($listarCitas[4],0) + FormatoMonto($totalC,0) + 0.001 ." \n \n  " ));

$pdf->setjump(10);
$pdf->Output();
?>