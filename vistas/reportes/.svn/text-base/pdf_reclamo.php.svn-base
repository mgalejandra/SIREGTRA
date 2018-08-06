<?php
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/reclamos.php');
require('../../modelos/beneficiario.php');
require('../../modelos/pago.php');

$objBeneficiario=new beneficiario();
$objReclamo= new reclamos();
$objPago = new pago();

  $idreclamo=$_GET['idreclamo'];

  $listarTipoR=$objReclamo->listarReclamos('','',-1,$idreclamo);

$pdf=new PDF('P','mm','Letter');
$pdf->SetMargins(10,10,10,10);
$nombre='reclamo_'.$listarTipoR[0].'.pdf';
$pdf->AddPage();

$pdf->setY(25);
$pdf->SetFont('Arial','',12);
$pdf->setY(35);
$pdf->SetFont('Arial','',12);
$pdf->Cell(190,5,"Caracas, ".$listarTipoR[6],0,0,'R');

$pdf->setY(45);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(0,5,utf8_decode("Atención al Público"),0,0,'C');

$pdf->setXY(30,65);
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(204,204,204);
$pdf->SetTextColor(0);
$pdf->Cell(160,5,'DATOS PERSONALES',1,0,'C',true);
$pdf->ln(5);
$pdf->setX(30);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"NOMBRE COMPLETO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarTipoR[14],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->setX(30);
$pdf->Cell(40,5,"C.I.:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarTipoR[1],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,utf8_decode("Teléfono Princ.:"),1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,5,$listarTipoR[11],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,utf8_decode("Teléfono Sec.:"),1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,5,$listarTipoR[12],1,0,'L');

$pdf->setXY(30,90);
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(204,204,204);
$pdf->SetTextColor(0);
$pdf->Cell(160,5,'SOLICITUD',1,1,'C',true);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"Tipo de Solicitud:",1,0,'R');

$tipoR = $objReclamo->listarTipoR($listarTipoR[7]);

$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$tipoR[1],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"Serial:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarTipoR[8],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(160,5,'OBSERVACION:',1,1,'L',true);
$pdf->setX(30);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(160,5,$listarTipoR[9],1,'J',0);
$pdf->SetFont('Arial','B',8);
$pdf->setX(30);
$pdf->Cell(160,5,'RESPUESTA:',1,1,'L',true);
$pdf->setX(30);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(160,5,$listarTipoR[10],1,'J',0);
$pdf->setX(30);


$pdf->Output($nombre,'I');
@pg_close($conexion);
?>