<?php
session_start();
require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/vehiculos.php');

$objVehiculo = new vehiculos();

  $sercarveh=$_GET['sercarveh'];
  $codmar=$_GET['codmar'];
  $modveh=$_GET['modveh'];
  $serveh=$_GET['serveh'];
  $taller=$_GET['taller'];
  $tt=$_GET['tt'];

$listVehiculos=$objVehiculo->listarVehiculos($sercarveh,$codmar,$modveh,$serveh,'N','','',$taller,$tt);
	//										 $sercarveh,$codmar,$modveh,$serveh,$origen,$lote,$factura,$taller=null,$tt=null

$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,35);
$pdf->Cell(250,5,'LISTADO DE VEHICULOS NACIONALES',0,0,'C',0);

$pdf->SetXY(10,45);
$cabecera = array('N°','Serial Carroceria','Serial Motor','Color','Serial NIT','Marca', 'Modelo','Serie');

$anchos = array(10,45,35,30,45,30,30,30);
$alineaciones = array('C','C','C','C','C','C','C');
$pdf->cabecera($cabecera,$anchos);
$pdf->SetFont('Arial','',8);
$pdf->SetWidths($anchos);
$pdf->SetAligns($alineaciones);
$pdf->SetBorder(true);
$j=1;
  for($i=0;$i<count($listVehiculos);$i+=17){
    $pdf->Row(array($j."",$listVehiculos[$i],$listVehiculos[$i+1],$listVehiculos[$i+2],$listVehiculos[$i+3],$listVehiculos[$i+14],$listVehiculos[$i+15],$listVehiculos[$i+16]));
    if ($pdf->getY()>190){
    	$pdf->addpage();
    	$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10,35);
		$pdf->Cell(250,5,'LISTADO DE VEHICULOS NACIONALES',0,0,'C',0);
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
	 $pdf->Row(array("Total de Vehiculos: ".FormatoMonto($j-1)));

$pdf->Output();
?>