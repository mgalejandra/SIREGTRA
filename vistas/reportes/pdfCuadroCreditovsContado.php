<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/crearPDFMin.php');
require('../../controlador/funciones.php');
require('../../modelos/vehiculos.php');

 $objVehiculo = new vehiculos();

 $numlotveh = $_GET['lote'];

 $fecha=date('d/m/Y');

$nroCampos = 2;

$reporteCreditominco=$objVehiculo->reporteCreditominco($numlotveh);

$reporteContadoMinco=$objVehiculo->reporteContadoMinco($numlotveh);

for($i=0;$i<count($reporteCreditominco);$i+=$nroCampos){
               $total= $total+$reporteCreditominco[$i+1];
};
for($i=0;$i<count($reporteContadoMinco);$i+=$nroCampos){
               $total2= $total2+$reporteContadoMinco[$i+1];
}

$totalF=$total+$total2;

$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle("DISTRIBUCION ENTREGA DE VEHICULOS POR ENTIDAD FINANCIERA Y DE CONTADO");
//$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$titulo1 = 'DISTRIBUCION ENTREGA DE VEHICULOS POR ENTIDAD FINANCIERA Y DE CONTADO';
$cabe1 = 'al '.$fecha;
//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->SetXY(5,35);
$pdf->Cell(255,5,utf8_decode($titulo1.' '.$cabe1),0,1,'C',0);
$pdf->SetXY(10,45);

$c ='TOTALES';

//$pdf->cabecera($cabe1,$anch1);
//$pdf->cabecera1($cabecera1_,$anch1_);
/*$pdf->cabecera1($cabecera_,$anch_);*/


	$anch_ = array(200,50);
	$alin_ = array('L','R');

$pdf->Ln();
//$pdf->SetFillColor(252,223,172);
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(0);
$pdf->Cell(200,5,'Entidad Financiera',0,0,'L',0);
$pdf->Cell(50,5,$total,0,0,'R',0);
$pdf->Ln();
$pdf->SetLineWidth(1);
$pdf->line(10,$pdf->getY(),260,$pdf->getY());
$pdf->SetFont('Arial','B',16);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(false);
$pdf->Ln();

$color=true;
$j=0;
for($i=0;$i<count($reporteCreditominco);$i+=$nroCampos) {
	$j++;
    if($color){
            	 $pdf->Rect($pdf->getX(),$pdf->getY(),250,10,F);
                 $color=false;
            }else $color=true;
            $pdf->setjump(10);
            $pdf->SetFont('Arial','',15);
            $pdf->SetFillColor(212);
			$pdf->Row(array($j.'. '.$reporteCreditominco[$i]
			                ,$reporteCreditominco[$i+1]));
}

$anch_ = array(200,50);
$alin_ = array('L','R');

$pdf->Ln();
//$pdf->SetLineWidth(1);
$pdf->SetFont('Arial','',16);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(false);


	$anch_ = array(200,50);
	$alin_ = array('L','R');


//$pdf->SetFillColor(252,223,172);
//$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(200,5,'De Contado',0,0,'L',0);
$pdf->Cell(50,5,$total2,0,0,'R',0);
$pdf->Ln();
$pdf->SetLineWidth(1);
$pdf->line(10,$pdf->getY(),260,$pdf->getY());
$pdf->SetFont('Arial','B',16);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(false);
$pdf->Ln();


for($i=0;$i<count($reporteContadoMinco);$i+=$nroCampos) {
	$j++;
	    if($color){
            	 $pdf->Rect($pdf->getX(),$pdf->getY(),250,10,F);
                 $color=false;
            }else $color=true;
            $pdf->setjump(10);
            $pdf->SetFont('Arial','',15);
            $pdf->SetFillColor(212);
			$pdf->Row(array($reporteContadoMinco[$i]
			                ,$reporteContadoMinco[$i+1]));
}

$pdf->Ln();
//$pdf->SetFillColor(252,223,172);
$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(0);
$pdf->Rect(10,$pdf->getY()-3,250,11,D);
/*
    D o una cadena vacia: draw. Este es el valor por defecto. (Borde sin relleno)
    F: fill sin borde con relleno
    DF o FD: draw and fill con borde con relleno */
$pdf->Cell(200,5,utf8_decode('Total Vehículos Entregados'),0,0,'L',0);
$pdf->Cell(50,5,$totalF,0,0,'R',0);

    // $xtit = utf8_decode("Total: ".$j." bancos");
     //$pdf->Cell(90,5,$xtit,0,0,'L',0);
$pdf->Output();
?>