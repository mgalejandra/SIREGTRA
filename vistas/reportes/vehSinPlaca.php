<?php
session_start();
require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/vehiculos.php');

$objVehiculo = new vehiculos();

  $sercarveh=$_GET['sercarveh'];
  $codmar=$_GET['marca'];
  $modveh=$_GET['modelo'];
  $lote=$_GET['lote'];
  $color=$_GET['color'];


$nroFilas = 25;
$nroCampos = 17;

$listVehiculos = $objVehiculo->listVehsinplaca($codmar,$modveh,$sercarveh,$lote,$color,-1);
$contArt = count($listVehiculos)/$nroCampos;


$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,35);
$pdf->Cell(250,5,'LISTADO DE VEHICULOS SIN PLACA',0,0,'C',0);

$pdf->SetXY(10,45);
$cabecera = array('Lote','Factura','Serial Carroceria','Serial Motor','Color','Serial NIT','Marca', 'Modelo');

$anchos = array(10,20,45,35,30,45,30,30,30);
$alineaciones = array('C','C','C','C','C','C','C','C');
$pdf->cabecera($cabecera,$anchos);
$pdf->SetFont('Arial','',8);
$pdf->SetWidths($anchos);
$pdf->SetAligns($alineaciones);
$pdf->SetBorder(true);
$j=1;

  for($i=0;$i<count($listVehiculos);$i+=17){
    $pdf->Row(array($listVehiculos[$i+16],$listVehiculos[$i+12],$listVehiculos[$i],$listVehiculos[$i+1],$listVehiculos[$i+2],$listVehiculos[$i+3],$listVehiculos[$i+14],$listVehiculos[$i+15]));
    if ($pdf->getY()>190){
    	$pdf->addpage();
    	$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10,35);
		$pdf->Cell(250,5,'LISTADO DE VEHICULOS SIN PLACA',0,0,'C',0);
		$pdf->SetXY(10,45);
    	$pdf->cabecera($cabecera,$anchos);
    	$pdf->SetFont('Arial','',8);
    }
    $j++;
  }

     //totales
     $pdf->ln();
     $pdf->SetWidths(array(255));
	 $pdf->SetAligns(array('R'));
	 $pdf->SetFont('Arial','B',12);
	 $pdf->Row(array("Total de Vehiculos: ".$contArt));

$pdf->Output();
?>