<?php
session_start();
require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/certificado.php');

$objcertificado = new certificado();

  $cadena='';
  $idsercarveh=$_GET['idsercarveh'];
  $numcerveh= $_GET['numcerveh'];
  $sercarveh= $_GET['sercarveh'];
  $codpro	= $_GET['codpro'];
  $nomcomp	= $_GET['nomcomp'];
  $numfac1veh=$_GET['numfac1veh'];
  $numlotveh= $_GET['numlotveh'];
  if ($numlotveh) $cadena.=' Lote Numero : '.$numlotveh;
  $codmar	= $_GET['codmar'];
  $codmodveh= $_GET['codmodveh'];
  $codserveh= $_GET['codserveh'];
  $taller = $_GET['taller'];
  $tt = $_GET['tt'];

  $desmarveh= $_GET['desmarveh'];
  if ($desmarveh) $cadena.=' Marca : '.$desmarveh;
  $desmodveh= $_GET['desmodveh'];
  if ($desmodveh) $cadena.=' Modelo : '.$desmodveh;
  $desserveh= $_GET['desserveh'];
  if ($desserveh) $cadena.=' Serie : '.$desserveh;
  $tipo= $_GET['tip'];
  if ($tipo=='E') $cadena.=' Anulado'; else $cadena.=' Activos';
  if ($taller)  $cadena.= 'Taller: '.$taller;
  if ($tt)	$cadena.= ', Todos los talleres';


 // $listarcertificado=$objcertificado->listarCertificadosRep('',$numcerveh,$idsercarveh,$codpro,$nomcomp,$numfac1veh,$numlotveh,$codmar,$codmodveh,$codserveh);
    $listarcertificado=$objcertificado->listarCertificados('',$numcerveh,$idsercarveh,$codpro,$nomcomp,$numfac1veh,$numlotveh,$codmar,$codmodveh,$codserveh,-1,$tipo,$taller,$tt);

if ($taller or $tt)
	$nroCampos = 20;
else
	$nroCampos = 18;

if ($taller or $tt)
	$pdf=new PDF('L', 'mm','Letter');
else
	$pdf=new PDF('P', 'mm','Letter');

$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,35);
$pdf->Cell(200,5,'Listado de Certificados Filtrados por '.$cadena,0,0,'C',0);

$pdf->SetXY(10,45);

if ($taller or $tt){
$cabecera = array('N°','Certificado','Serial','R.I.F','Beneficiario','N° Placa','Marca','Taller - Falla');
$anchos = array(10,20,35,20,65,20,30,60);
$alineaciones = array('C','L','L','L','L','C','L');
}
else
{
$cabecera = array('N°','Certificado','Serial','R.I.F','Beneficiario','N° Factura','Fecha');
$anchos = array(10,20,35,20,60,20,30);
$alineaciones = array('C','L','L','L','L','C','L');
}



$pdf->cabecera($cabecera,$anchos);
$pdf->SetFont('Arial','',8);
$pdf->SetWidths($anchos);
$pdf->SetAligns($alineaciones);
$pdf->SetBorder(true);
$j=1;

    for($i=0;$i<count($listarcertificado);$i+=$nroCampos){

    if ($taller or $tt){
      $pdf->Row(array($j."",$listarcertificado[$i],$listarcertificado[$i+2],$listarcertificado[$i+3],$listarcertificado[$i+4], $listarcertificado[$i+6],$listarcertificado[$i+7],$listarcertificado[$i+18]." - ".$listarcertificado[$i+19]));

      if ($pdf->getY()>160){
    	$pdf->addpage();
    	$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10,35);
		$pdf->Cell(200,5,'Lista de Certificados Filtrados por '.$cadena,0,0,'C',0);
		$pdf->SetXY(10,45);
    	$pdf->cabecera($cabecera,$anchos);
    	$pdf->SetFont('Arial','',8);
      }


    }
    else{
      $pdf->Row(array($j."",$listarcertificado[$i],$listarcertificado[$i+2],$listarcertificado[$i+3],$listarcertificado[$i+4], $listarcertificado[$i+6],$listarcertificado[$i+7]));

      if ($pdf->getY()>235){
    	$pdf->addpage();
    	$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10,35);
		$pdf->Cell(200,5,'Lista de Certificados Filtrados por '.$cadena,0,0,'C',0);
		$pdf->SetXY(10,45);
    	$pdf->cabecera($cabecera,$anchos);
    	$pdf->SetFont('Arial','',8);
       }
    }
    $j++;
  }

     //totales
     $pdf->ln();
     	$pdf->Cell(200,5,'Total de Certificados: '.abs($j-1),0,0,'L',0);
     $pdf->SetWidths(array(200));
	 $pdf->SetAligns(array('R'));
	 $pdf->SetFont('Arial','B',12);
	 $pdf->Row(array("Total de Certificados: ".abs($j-1)));

$pdf->Output();
?>