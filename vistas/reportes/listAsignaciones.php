<?php
session_start();
require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/certificado.php');
require('../../modelos/asignacion.php');

$objcertificado = new certificado();
$objAsignacion = new asignacion();

/*$numlotveh= $_SESSION['numlotveh'];
$sercarveh= $_SESSION['sercarveh'];
$codpro	= $_SESSION['codpro'];
$nombre	= $_SESSION['nombre'];
$taller = $_SESSION['taller'];
$tipo	= $_GET['tip'];
$taller1 = $_GET['tall'];
$tt = $_GET['tt'];*/


$numlotveh= $_GET['numlotveh'];
$sercarveh= $_GET['sercarveh'];
$codpro= $_GET['codpro'];
$nombre= $_GET['nombre'];
$fechAsig=$_GET['fechAsig'];
$tipo=$_GET['tipo'];
$taller1=$_GET['codtal'];
$tt=$_GET['todo_taller'];
$codmodveh=$_GET['modelo'];

if($numlotveh) $subtitulo.='Lote: '.$numlotveh;
if($sercarveh) $subtitulo.='Serial Carrocería: '.$sercarveh;
if($codpro) $subtitulo.='CI/RIF: '.$codpro;
if($nombre) $subtitulo.='Beneficiario: '.$nombre;

//$lista = $objAsignacion->listarAsignaciones($sercarveh,$codpro,$nombre,'',$numlotveh);
//$lista = $objAsignacion->listarAsignacion1($sercarveh,$codpro,$nombre,'','',$numlotveh,-1,$tipo,$taller,$tt);
//$lista = $objAsignacion->listarAsignacion1($sercarveh,$codpro,$nombre,'',$fechAsig,$numlotveh,-1,$tipo,$taller,$tt);
$lista=$objAsignacion->listarAsignacion1($sercarveh,$codpro,$nombre,$id,$fechAsig,$numlotveh,-1,$tipo,$taller,$tt,$_SESSION['numeDepa'],'',$codmodveh);



$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,35);
if ($tipo!='L')
$pdf->Cell(200,5,utf8_decode('Lista de Vehículos Asignados'),0,0,'C',0);
else
$pdf->Cell(200,5,utf8_decode('Lista de Vehículos Liberados'),0,0,'C',0);
$pdf->Cell(200,5,utf8_decode($subtitulo),0,0,'C',0);

$pdf->SetXY(10,45);

if ($taller or $tt)
{
$cabecera = array('N°','Modelo','Serial Carrocería','Color','Placa','CIF/RIF','Beneficiario','Fech. Asig.','Taller-Falla');
$anchos = array(10,30,40,25,15,20,80,20,45);
$alineaciones = array('C','L','C','L','L','C','L','C','L');
}
else
{
  $cabecera = array('N°','Modelo','Serial Carrocería','Color','Placa','CIF/RIF','Beneficiario','Fech. Asig.');
  $anchos = array(10,30,40,25,15,20,80,20);
  $alineaciones = array('C','L','C','L','L','C','L','C');
}

$pdf->cabecera($cabecera,$anchos);
$pdf->SetFont('Arial','',8);
$pdf->SetWidths($anchos);
$pdf->SetAligns($alineaciones);
$pdf->SetBorder(true);
$j=0;

if ($taller or $tt)
	$nroCampos = 15;
else
	$nroCampos = 13;

$nroLineas = 50;
$cantPaginas = ceil(count($lista)/$nroCampos/$nroLineas);

    for($i=0;$i<count($lista);$i+=$nroCampos){
    $j++;
    if ($taller or $tt)
    {
    	$modelo= $lista[$i+12];
    	$pdf->Row(array($j."",$modelo,$lista[$i],$lista[$i+11],$lista[$i+12],$lista[$i+1],utf8_decode($lista[$i+2]),$lista[$i+3],utf8_decode($lista[$i+10]." - ".$lista[$i+11])));
    }

    else
    {
    	$modelo= $lista[$i+10];
    	$pdf->Row(array($j."",$modelo,$lista[$i],$lista[$i+11],$lista[$i+12],$lista[$i+1],utf8_decode($lista[$i+2]),$lista[$i+3]));

    }


    if ($pdf->getY()>=247){
    	$paginacion = utf8_decode('Pág. ').$pdf->PageNo().'/'.$cantPaginas;
		$pdf->SetY(252);
		$pdf->Cell(200,5,$paginacion,0,0,'R',0);
		$pdf->addpage();
    	$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10,35);
		$pdf->Cell(200,5,utf8_decode('Lista de Vehículos Asignados'),0,0,'C',0);
		$pdf->SetXY(10,45);
    	$pdf->cabecera($cabecera,$anchos);
    	$pdf->SetFont('Arial','',8);
    }
  }

     //totales
     $pdf->ln();
     $titulo_total = utf8_decode("Total de vehículos asignados: ").$j;
     $pdf->Cell(200,5,$titulo_total,0,0,'L',0);
     $pdf->SetWidths(array(200));
	 $pdf->SetAligns(array('R'));
	 $pdf->SetFont('Arial','B',12);
	 $pdf->Row(array($titulo_total));

	$paginacion = utf8_decode('Pág. ').$pdf->PageNo().'/'.$cantPaginas;
	$pdf->SetY(252,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(200,5,$paginacion,0,0,'R',0);

$pdf->Output("Lista vehículos asignados","I");
?>