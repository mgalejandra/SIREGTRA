<?php
session_start();
require('../../modelos/conexion.php');
require ('../../modelos/fpdf/creaPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/factura.php');

$objFactura = new factura();

  $cadena='';
  $id_numfac=$_GET['id_numfac'];
  $sercarveh=$_GET['sercarveh'];
  $fec=$_GET['fec'];
  $fec2=$_GET['fec2'];
  $codpro = $_GET['codpro'];
  $nombre = $_GET['nombre'];
  $pgActual = $_GET['pagina'];
  $tipo= $_GET['tipo'];
  $estatus = $_GET['estatus'];
  $banco = $_GET['banco'];
  $usuario = $_GET['usuario'];
  $cond = $_GET['cond'];
  $sig = $_GET['sig'];
  $dia = $_GET['dia'];
  $diat = $_GET['diat'];
  $edad = $_GET['edad'];
  $estado = $_GET['estado'];
  $sexo = $_GET['sexo'];
  $codmar	= $_GET['codmar'];
  $desmarveh= $_GET['desmar'];
  $codmodveh= $_GET['codmodveh'];
  $desmod= $_GET['desmod'];
  $codserveh=$_GET['codserveh'];
  $desserveh= $_GET['desserveh'];
  $numlotveh= $_GET['numlotveh'];
  $numplaveh= $_GET['numplaveh'];
  $descdep= $_GET['descdep'];
  $taller=$_GET['taller'];
  $tt=$_GET['tt'];
  $fecE=$_GET['fecE'];
  $fecE2=$_GET['fecE2'];
  $tipoE=$_GET['tipoE'];
  $tipoben=$_GET['tipoben'];
  $fecfacori1=$_GET['fecfacori1'];
  $fecfacori2=$_GET['fecfacori2'];
  $numfacori=$_GET['numfacori'];
  $acto=$_GET['acto'];
  $desacto=$_GET['desacto'];
  $todoact=$_GET['todoacto'];


  if ($numlotveh) $cadena.=' Lote Numero : '.$numlotveh;
  $codmar	= $_GET['codmar'];
  $codmodveh= $_GET['codmodveh'];
  $codserveh= $_GET['codserveh'];

  $desmarveh= $_GET['desmarveh'];
  if ($desmarveh) $cadena.=' Marca : '.$desmarveh;
  $desmodveh= $_GET['desmodveh'];
  if ($desmodveh) $cadena.=' Modelo : '.$desmodveh;
  $desserveh= $_GET['desserveh'];
  if ($desserveh) $cadena.=' Serie : '.$desserveh;
  $tipo= $_GET['tip'];
  if ($tipo=='E') $cadena.=' Anulado'; else $cadena.=' Activos';


/*if ($taller or $tt)
	$nroFilas = 32;
else
    $nroFilas = 30;*/


if (($taller or $tt) and ($tipoentrega))
	$nroFilas = 48;
elseif ($taller or $tt or $tipoentrega)
	$nroFilas = 48;
elseif ($acto or $tt or $todoact)
	$nroFilas = 47;
else
    $nroFilas = 46;


 // $listarcertificado=$objcertificado->listarCertificadosRep('',$numcerveh,$idsercarveh,$codpro,$nomcomp,$numfac1veh,$numlotveh,$codmar,$codmodveh,$codserveh);
    $listarFactura=$objFactura->listarFacturas($id_numfac,$sercarveh,$fec,$fec2,-1,$codpro,$nombre,$tipo,$estatus, $banco ,$usuario,$cond, $sig, $dia ,$edad ,
    $estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori,'',
    '','','',$acto,$todoact);

//$data;
$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(10,35);
$pdf->Cell(200,5,'Listado de Facturas Filtradas por '.$cadena,0,0,'C',0);

if ($acto){
$pdf->SetXY(10,45);
$pdf->Cell(200,5,'ACTO: '.$desacto,0,0,'C',0);
}
$pdf->SetFont('Arial','',7);
$pdf->SetXY(10,50);

if ($taller or $tt)
{
    $cabecera = array('N°','Fact','Fecha','Serial','CI Benef','Beneficiario','Cond.P','Banco','Estatus','Estado','Marca','Modelo','N° Placa','Fecha_E','Taller-Falla');
	$anchos = array(5,8,11,20,15,25,12,20,15,15,20,20,15,15,25);
	$alineaciones = array('C','C','C','C','C','L','C','C','L','L','L','L','C','L','L');
}
else
{
	$cabecera = array('N°','Fact','Fecha','Serial','CI Benef','Beneficiario','Cond.P','Banco','Estatus','Estado','Marca','Modelo','N° Placa','Fecha_E','Tipo Ben.');
	$anchos = array(5,8,11,20,15,25,12,30,30,15,20,20,15,15,15,20);
	$alineaciones = array('C','C','C','C','C','L','C','C','L','L','L','L','C','C','L');
}

$pdf->cabecera1($cabecera,$anchos);
$pdf->SetFont('Arial','',5);
$pdf->SetWidths($anchos);
$pdf->SetAligns($alineaciones);
$pdf->SetBorder(true);
$j=1;

    for($i=0;$i<count($listarFactura);$i+=$nroFilas){
   	 if ($taller or $tt)
       $pdf->Row(array($j."",$listarFactura[$i],$listarFactura[$i+4],$listarFactura[$i+2],$listarFactura[$i+8],$listarFactura[$i+9],$listarFactura[$i+6], $listarFactura[$i+16],$listarFactura[$i+17],$listarFactura[$i+18],$listarFactura[$i+24],$listarFactura[$i+25],$listarFactura[$i+28],$listarFactura[$i+29],$listarFactura[$i+44]." - ".$listarFactura[$i+45]));
	 else
       $pdf->Row(array($j."",$listarFactura[$i],$listarFactura[$i+4],$listarFactura[$i+2],$listarFactura[$i+8],$listarFactura[$i+9],$listarFactura[$i+6], $listarFactura[$i+16],$listarFactura[$i+17],$listarFactura[$i+18],$listarFactura[$i+24],$listarFactura[$i+25],$listarFactura[$i+28],$listarFactura[$i+29],$listarFactura[$i+30]));

    if ($pdf->getY()>175){
    	$pdf->AddPage();
        $pdf->SetFont('Arial','B',8);
        $pdf->SetXY(10,35);
        $pdf->Cell(200,5,'Listado de Facturas Filtradas por '.$cadena,0,0,'C',0);
        $pdf->SetFont('Arial','',7);
        $pdf->SetXY(10,45);
    	/*$pdf->addpage();
    	$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(10,35);
		$pdf->Cell(200,5,'Listado de Facturas Filtradas por '.$cadena,0,0,'C',0);
		$pdf->SetXY(10,45);
    	$pdf->cabecera($cabecera,$anchos);
    	$pdf->SetFont('Arial','',6);*/

    	if ($taller or $tt)
{
    $cabecera = array('N°','Fact','Fecha','Serial','CI Benef','Beneficiario','Cond.P','Banco','Estatus','Estado','Marca','Modelo','N° Placa','Fecha_E','Taller-Falla');
	$anchos = array(5,8,11,20,15,25,12,20,15,15,20,20,15,15,25);
	$alineaciones = array('C','C','C','C','C','L','C','C','L','L','L','L','C','L','L');
}
else
{
	$cabecera = array('N°','Fact','Fecha','Serial','CI Benef','Beneficiario','Cond.P','Banco','Estatus','Estado','Marca','Modelo','N° Placa','Fecha_E','Tipo Ben.');
	$anchos = array(5,8,11,20,15,25,12,30,30,15,20,20,15,15,15,20);
	$alineaciones = array('C','C','C','C','C','L','C','C','L','L','L','L','C','C','L');
}

$pdf->cabecera1($cabecera,$anchos);
$pdf->SetFont('Arial','',5);
$pdf->SetWidths($anchos);
$pdf->SetAligns($alineaciones);
$pdf->SetBorder(true);
    }
    $j++;
  }

     //totales
     $pdf->ln();
     	$pdf->Cell(200,5,'Total de Facturas: '.abs($j-1),0,0,'L',0);
     $pdf->SetWidths(array(200));
	 $pdf->SetAligns(array('R'));
	 $pdf->SetFont('Arial','B',8);
	 $pdf->Row(array("Total de Certificados: ".abs($j-1)));

$pdf->Output();
?>