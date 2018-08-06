<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/pago.php');

$obj = new pago();

  $cadena='';

  $id_banco = $_SESSION['idBanco'];
  $desde 	= $_SESSION['desde_'];
  $hasta 	= $_SESSION['hasta_'];
  $nomcomp 	= $_SESSION['benefic'];
  $nro_pago = $_SESSION['nroCheque'];
  $statusPago = $_SESSION['statusPago_'];

  $listarPago = $obj->listarPagos($nro_pago,$id_banco,$desde,$hasta,$nomcomp,$codpro,null,null,$statusPago);
  $nro_colum = 12;

$pdf = new PDF('P','mm','Letter');
$titulo = "Lista de Pagos";
if($id_banco) $subtitulo = $_SESSION['nom_Banco_'];
if($desde) $subtitulo .= "Desde: ".$desde;
if($hasta) $subtitulo .= "Desde: ".$hasta;
if($statusPago) $subtitulo .= "Status pago: ".$statusPago;
if($nomcomp) $subtitulo .= "Propietario: ".$nomcomp;

$pdf->SetTitle($titulo);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);
$pdf->AddPage();

if($subtitulo) {
	$pdf->SetFont('Arial','',8);
	$pdf->setY(45);
	$pdf->Write(5,$subTitulo);
	$pdf->ln();
}

$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,35);
$pdf->Cell(200,5,$titulo,0,0,'C',0);

$pdf->SetXY(10,45);
$cabecera = array('ID','N° Pago','Monto','Fecha','Status','Banco','Beneficiario');

$nPixel = 60;
$lFont = 2;

$anch = array(10,20,20,20,20,50,$nPixel);
$alin = array('C','C','R','C','C','C','L');
$pdf->cabecera($cabecera,$anch);
$pdf->SetFont('Arial','',8);
$pdf->SetWidths($anch);
$pdf->SetAligns($alin);
$pdf->SetBorder(true);
$j=0;

    for($i=0;$i<count($listarPago);$i+=$nro_colum){
/*
		    $pdf->Row(array($listarPago[$i],$listarPago[$i+1]
	    				,formatomonto($listarPago[$i+2])
	    				,$listarPago[$i+3],$listarPago[$i+4]
	    				,$listarPago[$i+6],$listarPago[$i+10]
	    				));
*/
  	  	$pdf->Cell($anch[0],4,$listarPago[$i],  'LRB', 0,'C');
  	  	$pdf->Cell($anch[1],4,$listarPago[$i+1],'RB',  0,'R');
  	  	$pdf->Cell($anch[2],4,formatomonto($listarPago[$i+2]),'RB',0,'R');
  		$pdf->Cell($anch[3],4,$listarPago[$i+3], 'RB', 0,'C');
  		$xt1 = $listarPago[$i+4];
  		$xt2 = ($xt1=="E")?"EFECTIVO":(($xt1=="V")?"DEVUELTO":(($xt1=="A")?"ANULADO":($xt1=="D")?"DEPOSITADO":""));
  		$pdf->Cell($anch[4],4,$xt2,'RB', 0,'C');
  		$pdf->Cell($anch[5],4,$listarPago[$i+6],'RB', 0,'L');
  		$largo = strlen($listarPago[$i+10]);
  		$benef = strlen($largo/$nPixel<=1)?$listarPago[$i+10]:substr($listarPago[$i+10],0,ceil($nPixel/$lFont))."...";
  		$pdf->Cell($anch[6],4,$benef,'RB', 0,'L');
		$pdf->ln();

	    if ($pdf->getY()>235){
	    	$pdf->addpage();
	    	$pdf->SetFont('Arial','B',12);
			$pdf->SetXY(10,35);
			$pdf->Cell(200,5,'Lista de Pagos',0,0,'C',0);
			$pdf->SetXY(10,45);
	    	$pdf->cabecera($cabecera,$anch);
	    	$pdf->SetFont('Arial','',8);
	    }
    	$j++;
  }

     //totales
     $pdf->ln();
     $xtit = "Total de Pagos: ".$j;
     $pdf->Cell(200,5,$xtit,0,0,'L',0);
     $pdf->SetWidths(array(200));
	 $pdf->SetAligns(array('R'));
	 $pdf->SetFont('Arial','B',12);
	 $pdf->Row(array($xtit));

$pdf->Output(fechahoy().' - '.$titulo.'.pdf','I');
?>