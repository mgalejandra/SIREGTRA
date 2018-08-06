<?php
session_start();
require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/placas.php');

$objPlacas = new placas();

  $placa=$_GET['placa'];
  $estado=$_GET['estado'];
  $idsercarveh=$_GET['idsercarveh'];
  $marca=$_GET['marca'];
  $modelo=$_GET['modelo'];
  $numlotveh=$_GET['lote'];
//$listPlacas=$objPlacas->listarPlacas($idsercarveh,$placa,$estado,$marca,$modelo);
$listPlacas=$objPlacas->listadoPlacasColor($idsercarveh,$placa,$estado,-1,$_SESSION['numeDepa'],$numlotveh,$marca,$modelo);


$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,35);
$pdf->Cell(240,5,'LISTADO DE PLACAS ASIGNADAS',0,0,'C',0);

$pdf->SetXY(10,45);
$cabecera = array('N#','Marca','Modelo','Serial Carroceria','Placa','Color','Estado','Nro. Rafaga','Fecha Rafaga');

$anchos = array(10,40,40,40,20,30,25,25,25);
$alineaciones = array('C','L','L','C','C','C','C','C');
$pdf->cabecera($cabecera,$anchos);
$pdf->SetFont('Arial','',8);
$pdf->SetWidths($anchos);
$pdf->SetAligns($alineaciones);
$pdf->SetBorder(true);
$j=1;
  for($i=0;$i<count($listPlacas);$i+=12){
    $pdf->Row(array($j."",$listPlacas[$i+9],$listPlacas[$i+10],$listPlacas[$i],$listPlacas[$i+1],$listPlacas[$i+11],$listPlacas[$i+3],$listPlacas[$i+4],$listPlacas[$i+5]));
    if ($pdf->getY()>235){
    	$pdf->addpage();
    	$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10,35);
		$pdf->Cell(200,5,'LISTADO DE PLACAS ASIGNADAS',0,0,'C',0);
		$pdf->SetXY(10,45);
    	$pdf->cabecera($cabecera,$anchos);
    	$pdf->SetFont('Arial','',8);
    }
    $j++;
  }

     //totales
     $pdf->ln();
     $pdf->SetWidths(array(200));
	 $pdf->SetAligns(array('R'));
	 $pdf->SetFont('Arial','B',12);
	 $pdf->Row(array("Total de Placas: ".FormatoMonto($j-1)));
$pdf->Output();
?>
