<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/crearPDFMin.php');
require('../../controlador/funciones.php');
require('../../modelos/citas.php');
require('../../modelos/beneficiario.php');
require('../../modelos/pago.php');
require('../../modelos/banco.php');

$objCitas= new citas();
$objBeneficiario=new beneficiario();
$objPago = new pago();
$objBanco = new banco();

 $tipoBen = $_GET['tipo'];
 $desde  = $_GET['fechaD'];
 $hasta = $_GET['fechaH'];
 $banco   = $_GET['banco'];

$fecha=date('d/m/Y');
$dia=date("d");
$mes=date("m");
$ano=date("Y");

$nroCampos = 6;
$listarCitasBanco = $objCitas->cuadroResumenCitasxBanco($tipoBen,$desde,$hasta,$banco);


$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle("Cuadro Resumen de Citas por Banco");
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->SetXY(10,30);



   if (($desde) and ($hasta))
	 	$titulo1 = 'Sistema de Citas desde el '.$desde.' hasta el '.$hasta;
   elseif (($desde) and !($hasta))
   {
		$dia=substr($desde,0,2);
		$mes=substr($desde,3,2);
		$ano=substr($desde,6,10);
		$titulo1 = 'Sistema de Citas desde el '.$dia.' de '.ObtenerMesenLetras($mes).' de '.$ano;
   }
   elseif (!($desde) and ($hasta)){
        $dia=substr($hasta,0,2);
		$mes=substr($hasta,3,2);
		$ano=substr($hasta,6,10);
   		$titulo1 = 'Sistema de Citas hasta el '.$dia.' de '.ObtenerMesenLetras($mes).' de '.$ano;
   }
   else $titulo1 = 'Sistema de Citas al '.$dia.' de '.ObtenerMesenLetras($mes).' de '.$ano;


$anch_ = array(70,28,35,35,28,28,30);
$alin_ = array('L','R','R','R','R','R','R');
$c ='TOTALES';

   $pdf->Cell(255,5,$titulo1,0,0,'L');
$pdf->Ln(10);
   $pdf->SetFillColor(252,223,172);
   $pdf->SetTextColor(0);
   $pdf->Cell(70,5,'BANCO',1,0,'C',1);
   $pdf->Cell(154,5,'Beneficiarios',1,0,'C',1);
   $pdf->Cell(30,5,'Total',1,0,'C',1);
$pdf->Ln();
   $pdf->SetFillColor(255,244,212);
   $pdf->Cell(70,5,'',1,0,'C',1);
   $pdf->Cell(28,5,'Asistieron',1,0,'C',1);
   $pdf->Cell(35,5,'No asistieron',1,0,'C',1);
   $pdf->Cell(35,5,'Pendientes',1,0,'C',1);
   $pdf->Cell(28,5,'Total Citas',1,0,'C',1);
   $pdf->Cell(28,5,'Sin cita',1,0,'C',1);
   $pdf->Cell(30,5,'',1,0,'C',1);
$pdf->Ln();

$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);

$j=0;
for($i=0;$i<count($listarCitasBanco);$i+=$nroCampos) {
	$j++;

	$banco = $listarCitasBanco[$i+1];


	$totalF=$listarCitasBanco[$i+2];
	$totalF+=$listarCitasBanco[$i+3];
	$totalF+=$listarCitasBanco[$i+4];

	$cita1=$listarCitasBanco[$i+5];
	$asistieron=$listarCitasBanco[$i+2];
	$vencidas=$listarCitasBanco[$i+3];
	$pendiente=$listarCitasBanco[$i+4];
	$sincita=$listarCitasBanco[$i+5];



			$reales = $totalF + $cita1;

            $pdf->setjump(10);
            $pdf->SetFont('Arial','B',15);
			$pdf->Row(array($banco
			                ,($asistieron==0)?"":$asistieron
			                ,($vencidas==0)?"":$vencidas
			                ,($pendiente==0)?"":$pendiente
			                ,FormatoMonto($totalF,0)
			                ,($sincita==0)?"":$sincita
			                ,FormatoMonto($reales,0)));

            $pdf->setjump(10);

    if ($pdf->getY()>170){
    	$pdf->addpage();

			$pdf->SetFont('Arial','B',15);
			$pdf->SetXY(10,30);
			$pdf->Cell(0,7,utf8_decode($titulo1),0,1,'C',0);
			$pdf->SetFont('Arial','',12);

			$pdf->cabecera($cabecera_,$anch_);
			$pdf->SetFont('Arial','',12);
			$pdf->SetWidths($anch_);
			$pdf->SetAligns($alin_);
			$pdf->SetBorder(true);
	    }




}
$pdf->Ln();
$pdf->SetFillColor(252,223,172);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',16);
$pdf->SetBorder(true);

	$pdf->Cell(70,5,$c,1,0,'L',1);
	$pdf->Cell(28,5,($_SESSION['realasis']==0)?"":FormatoMonto($_SESSION['realasis'],0),1,0,'R',1);
	$pdf->Cell(35,5,($_SESSION['realven']==0)?"":FormatoMonto($_SESSION['realven'],0),1,0,'R',1);
	$pdf->Cell(35,5,($_SESSION['realpen']==0)?"":FormatoMonto($_SESSION['realpen'],0),1,0,'R',1);
	$pdf->Cell(28,5,($_SESSION['totalS']==0)?"":FormatoMonto($_SESSION['totalS'],0),1,0,'R',1);
	$pdf->Cell(28,5,($_SESSION['realsinc']==0)?"":FormatoMonto($_SESSION['realsinc'],0),1,0,'R',1);
	$pdf->Cell(30,5,($_SESSION['totaltotal']==0)?"":FormatoMonto($_SESSION['totaltotal'],0),1,0,'R',1);

$pdf->Output();
?>