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
  $asigna = $_GET['asigna'];
  $placa = $_GET['placa'];


$nroFilas = 25;

if ($asigna=='AS')
	$nroCampos = 13;
else
	$nroCampos = 8;


$listVehiculos = $objVehiculo->listVehNoPDI($codmar,$modveh,$sercarveh,$numlotveh,$color,$asigna,-1,$placa);
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

if ($asigna=='AS'){
	$pdf->Cell(250,5,'LISTADO DE VEHICULOS PDI NO APROBADO - ASIGNADOS',0,0,'C',0);
	$cabecera = array('Lote','Marca', 'Modelo','Serial Carroceria','Serial NIT','Color','Placa','ID. Asig.','Est. Asig.','C.I. Benef.','Estatus - Fecha');
	$anchos = array(10,20,35,35,35,15,15,20,20,20,35);
    $alineaciones = array('C','C','C','C','C','C','C','C','C','C','C');
}
else{
    $pdf->Cell(250,5,'LISTADO DE VEHICULOS PDI NO APROBADO',0,0,'C',0);
	$cabecera = array('Lote','Marca', 'Modelo','Serial Carroceria','Serial NIT','Color','Placa');
    $anchos = array(10,45,45,50,50,30,30);
    $alineaciones = array('C','C','C','C','C','C','C');
}


$pdf->SetXY(10,45);

$pdf->cabecera($cabecera,$anchos);
$pdf->SetWidths($anchos);
$pdf->SetAligns($alineaciones);
$pdf->SetBorder(true);
$j=1;

  for($i=0;$i<count($listVehiculos);$i+=$nroCampos){

   if ($asigna=='AS'){
   	$pdf->SetFont('Arial','',6);
   	$pdf->Row(array($listVehiculos[$i],$listVehiculos[$i+1],$listVehiculos[$i+2],$listVehiculos[$i+3],$listVehiculos[$i+4],$listVehiculos[$i+5],$listVehiculos[$i+6],$listVehiculos[$i+7],$listVehiculos[$i+8],$listVehiculos[$i+9],$listVehiculos[$i+10].'-'.$listVehiculos[$i+11]));

   }
   else
   {
   	  $pdf->SetFont('Arial','',8);
   	  $pdf->Row(array($listVehiculos[$i],$listVehiculos[$i+1],$listVehiculos[$i+2],$listVehiculos[$i+3],$listVehiculos[$i+4],$listVehiculos[$i+5],$listVehiculos[$i+6]));
   }

    if ($pdf->getY()>190){
    	$pdf->addpage();
    	$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10,35);
		if ($asigna=='AS') $pdf->Cell(250,5,'LISTADO DE VEHICULOS PDI NO APROBADO - ASIGNADOS',0,0,'C',0);
	    else $pdf->Cell(250,5,'LISTADO DE VEHICULOS PDI NO APROBADO',0,0,'C',0);
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