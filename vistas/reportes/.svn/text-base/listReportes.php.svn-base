<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/crearPDF.php');
require('../../modelos/reportes.php');
require('../../controlador/funciones.php');

$sel_Lista = $_GET['sel_Lista'];

$pdf = new PDF('P','mm','Letter');
$obj = new reportes();

$pdf->SetTitle(utf8_decode($_SESSION['titulo'].' '.$_SESSION['titulo1']));
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$titulo  = utf8_decode($_SESSION['titulo']);
$titulo1 = utf8_decode($_SESSION['titulo1']);

	//página 1

	$pdf->AddPage();
	$pdf->SetXY(10,30);

 	// Imprime número de página

   	++$k;
   	$xPag = utf8_decode("Pág.".$k);
   	$pdf->SetFont('Arial','',8);
   	$pdf->Cell(190,5,$xPag,0,0,'R',0);

	// Reescritura de titulos

	$pdf->SetFont('Arial','B',12);
	$pdf->SetXY(10,30);
	$pdf->Cell(0,7,$titulo,0,1,'C',0);
	$pdf->SetFont('Arial','',12);
	if($titulo1)$pdf->Cell(0,7,$titulo1,0,1,'C',0);
	$pdf->Ln();

	if($sel_Lista==3 or $sel_Lista==4)$pdf->cabecera($cabecera_,$anch_);
   	$pdf->cabecera($cabecera,$anch);
   	$pdf->SetFont('Arial','',8);

$reg = $_SESSION['listado_todo'];
$nroCampos = $_SESSION['nroCampos'];

switch ($sel_Lista){
	case 1:
			$cabecera = array('N°','Serial Carr.','CI/RIF','Beneficiario','N°Certif.','N° envío');
			$anch = array(10,35,20,105,18,15);
			$alin = array('C','C','C','L','C','C');
			break;
	case 2:	$cabecera = array('N°','Serial Carr.','CI/RIF','Beneficiario');
			$anch = array(10,40,30,105);
			$alin = array('C','C','C','L');
			break;
	case 3:
			$cabecera_ = array(' ','Serial','Año',' ');
			$cabecera  = array('N°','Marca','Modelo','Motor','Carrocería','Fabric.','Modelo','Color','N° Placa');
			$anch_ = array(60,60,30,40);
			$anch  = array(10,30,20,20,40,15,15,20,20);
			$alin_ = array('C','C','C','C');
			$alin  = array('C','C','C','C','C','C','C','C','C');
			break;
	case 4:
			$cabecera_ = array(' ','Serial','Año',' ');
			$cabecera  = array('N°','Marca','Modelo','Motor','Carrocería','Fabric.','Modelo','Color');
			$anch_ = array(60,60,30,20);
			$anch  = array(10,30,20,20,40,15,15,20);
			$alin_ = array('C','C','C','C');
			$alin = array('C','C','C','C','C','C','C','C');
			break;
}

if($sel_Lista==3 or $sel_Lista==4){
$pdf->cabecera($cabecera_,$anch_);
$pdf->SetFont('Arial','',8);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);
}

$pdf->cabecera($cabecera,$anch);
$pdf->SetFont('Arial','',8);
$pdf->SetWidths($anch);
$pdf->SetAligns($alin);
$pdf->SetBorder(true);

$j=0;
$nroItems = sizeof($_SESSION['listado_todo']);

    for($i=0;$i<$nroItems;$i+=$nroCampos){
		++$j;
		$jx = ''.$j.'';
		    if($sel_Lista==1)
		   	$pdf->Row(array($jx,$reg[$i+3],$reg[$i+8],$reg[$i+9].' '.$reg[$i+10],$reg[$i+13],$reg[$i+18]));
		elseif($sel_Lista==2)
		   	$pdf->Row(array($jx,$reg[$i+3],$reg[$i+8],$reg[$i+9].' '.$reg[$i+10]));
		elseif($sel_Lista==3)
			$pdf->Row(array($jx,$reg[$i],$reg[$i+1],$reg[$i+2],$reg[$i+3],$reg[$i+4],$reg[$i+5],$reg[$i+6],$reg[$i+7]));
		elseif($sel_Lista==4)
			$pdf->Row(array($jx,$reg[$i],$reg[$i+1],$reg[$i+2],$reg[$i+3],$reg[$i+4],$reg[$i+5],$reg[$i+6]));

	    if ($pdf->getY()>250){

			$pdf->AddPage();
			$pdf->SetXY(10,30);

	    	// Imprime número de página
	    	++$k;
	    	$xPag = utf8_decode("Pág.".$k);
	    	$pdf->SetFont('Arial','',8);
	    	$pdf->Cell(190,5,$xPag,0,0,'R',0);

			// Reescritura de titulos

			$pdf->SetFont('Arial','B',12);
			$pdf->SetXY(10,30);
			$pdf->Cell(0,7,$titulo,0,1,'C',0);
			$pdf->SetFont('Arial','',12);
			if($titulo1)$pdf->Cell(0,7,$titulo1,0,1,'C',0);
			$pdf->Ln();

			if($sel_Lista==3 or $sel_Lista==4)$pdf->cabecera($cabecera_,$anch_);
	    	$pdf->cabecera($cabecera,$anch);
	    	$pdf->SetFont('Arial','',8);
			}
  	}

     //totales
     $pdf->ln();
     $xtit = utf8_decode("Total de vehículos: ".$j);
     $pdf->Cell(200,5,$xtit,0,0,'L',0);
     $pdf->SetWidths(array(170));
	 $pdf->SetAligns(array('R'));
	 $pdf->SetFont('Arial','B',12);
	 $pdf->Row(array($xtit));

$pdf->Output();

?>