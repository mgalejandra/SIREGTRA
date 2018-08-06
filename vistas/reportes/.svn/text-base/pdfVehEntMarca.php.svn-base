<?php
session_start();
require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/reportes.php');
require('../../modelos/banco.php');

$pdf=new PDF('P', 'mm','Letter');

$obj       = new reportes();
$objBanco  = new banco();

$acto=$_GET['act'];
$marca = $_GET['mar'];
$modelo=$_GET['mod'];
$banco=$_GET['ban'];
$numlotveh=$_GET['lote'];

$total=$_SESSION['tot'];
$montoinic=$_SESSION['montin'];
$montofin=$_SESSION['montfin'];

$data = $obj->reporteEntGral($acto,$modelo,$marca,$banco,$numlotveh);


/*if ($acto)
	$nroCol = 10;
else
	$nroCol = 8;*/


if (($acto) and !($numlotveh))
	$nroCol = 10;
elseif (!($acto) and ($numlotveh))
	$nroCol = 9;
elseif (($acto) and ($numlotveh))
	$nroCol = 11;
else
	$nroCol = 8;


  if ($acto) $cadena = $acto;
  else $cadena = "TODOS LOS ACTOS";

  if ($numlotveh) $cadena = $cadena." - Lote: ".$numlotveh;

  if ($banco) $nombreB = $objBanco->listarBancos($banco);

  if ($nombreB) $cadena.= ' - '.$nombreB[2];

  if ($marca) $cadena.=', MARCA: '.$marca;

  if ($modelo) $cadena.=', MODELO : '.$modelo;


$pdf=new PDF('P', 'mm','Letter');


$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(10,35);
$pdf->Cell(200,5,'Listado de Vehiculos entregados filtrados por '.$cadena,0,0,'C',0);

$pdf->SetXY(10,45);


$cabecera = array('Marca','Modelo','Cantidad','Precio','Total','Monto Ini.','Monto Fin.','% Tasa');
$anchos = array(30,30,18,25,25,25,25,15);
$alineaciones = array('L','L','C','R','R','R','R','C');


$pdf->cabecera($cabecera,$anchos);
$pdf->SetFont('Arial','',8);
$pdf->SetWidths($anchos);
$pdf->SetAligns($alineaciones);
$pdf->SetBorder(true);
$j=1;

    for($i=0;$i<count($data);$i+=$nroCol){
      $pdf->Row(array($data[$i],$data[$i+1],$data[$i+2],formatomonto($data[$i+3]),formatomonto($data[$i+4]),formatomonto($data[$i+7]),formatomonto($data[$i+5]),formatomonto($data[$i+6]/$data[$i+2])));

      if ($pdf->getY()>225){
    	$pdf->addpage();
    	$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10,35);
		$pdf->Cell(200,5,'Lista de Certificados Filtrados por '.$cadena,0,0,'C',0);
		$pdf->SetXY(10,45);
    	$pdf->cabecera($cabecera,$anchos);
    	$pdf->SetFont('Arial','',8);
      }

    $j++;
  }

     //totales
     $pdf->SetFont('Arial','',8);
     $anchos1 = array(100,25,25,25);
     $alineaciones1 = array('R','R','R','R');
     $pdf->SetFont('Arial','',8);
	 $pdf->SetWidths($anchos1);
	 $pdf->SetAligns($alineaciones1);
     $pdf->Row(array('Totales',formatomonto($total),formatomonto($montoinic),formatomonto($montofin)));

    /* $pdf->ln();
     $pdf->Cell(200,5,'Total de Marcas: '.abs($j-1),0,0,'L',0);
     $pdf->SetWidths(array(200));
	 $pdf->SetAligns(array('R'));
	 $pdf->SetFont('Arial','B',12);
	 $pdf->Row(array("Total de Marcas: ".abs($j-1)));*/

$pdf->Output();
?>