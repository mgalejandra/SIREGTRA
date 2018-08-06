<?php
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/factura.php');
require('../../modelos/fpdf/fpdf.php');
require('../../modelos/zona.php');


//$pdf = new FPDF();
$pdf = new FPDF('P','mm','A4');

$objFactura = new factura();

$factura=$_GET['num'];

$listarFactura=$objFactura->reporteFactura($factura);

if ($listarFactura)
$detalleVehiculo=$objFactura->detalleVehiculo($listarFactura[9]);


//$this=new FPDF('p', 'mm','Letter');
$pdf->SetMargins(10,10,10,10);
//$titulo=utf8_decode('');
//$pdf->SetTitle($titulo);
$pdf->AddPage();


  $pdf->setY(84);
  $pdf->SetFont('ARIAL','',8);
  $pdf->SetBorder(0);
  $pdf->SetWidths(array(10,5,67,65,50,8));
  $pdf->SetAligns(array("C","R","L","L","R","R"));
  $sig=' ';
  $pdf->setjump(5);
  $pdf->Row(array("",$sig,"DESCRIPCION DEL VEHICULO",'','',''));
  $pdf->Row(array("",$sig,"MARCA:",$detalleVehiculo[5],'',''));
  $pdf->Row(array("",$sig,"MODELO:",$detalleVehiculo[6],'',''));
  $pdf->Row(array("",$sig,"SERIAL DE MOTOR:",$detalleVehiculo[10],'',''));
  $pdf->Row(array("",$sig,"SERIAL DE CARROCERIA:",$detalleVehiculo[2],'',''));
  $pdf->Row(array("",$sig,utf8_decode("AÑO DE FABRICACION:"),$detalleVehiculo[8],'',''));
  $pdf->Row(array("",$sig,utf8_decode("AÑO DE MODELO:"),$detalleVehiculo[9],'',''));
  $pdf->Row(array("",$sig,"COLOR(ES):",$detalleVehiculo[12].' '.$detalleVehiculo[13],'',''));
  $pdf->Row(array("",$sig,"PLACA:",$detalleVehiculo[1],'',''));
  $pdf->Row(array("",$sig,"CLASE:",$detalleVehiculo[14],'',''));
  $pdf->Row(array("",$sig,"TIPO:",$detalleVehiculo[15],'',''));
  $pdf->Row(array("",$sig,"USO:",$detalleVehiculo[16],'',''));
  $pdf->Row(array("",$sig,"SERIAL DE NIV:",$detalleVehiculo[3],'',''));
  $pdf->Row(array("",$sig,"SERIE/VERSION:",$detalleVehiculo[7],'',''));
  $pdf->Row(array("",$sig,"TIPO DE COMBUSTIBLE:",$detalleVehiculo[11],'',''));
  $pdf->Row(array("",$sig,utf8_decode("N° DE PUESTOS:"),$detalleVehiculo[17],'',''));
  $pdf->Row(array("",$sig,utf8_decode("N° DE EJES:"),$detalleVehiculo[18],'',''));
  $pdf->Row(array("",$sig,"PESO (TARA):",$detalleVehiculo[19],'',''));
  $pdf->Row(array("",$sig,"CAPACIDAD DE CARGA:",$detalleVehiculo[20],'',''));


$pdf->Output();
 @pg_close($conexion);

?>
