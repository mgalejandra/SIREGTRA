<?php
session_start();
require('../../modelos/conexion.php');
require ('../../modelos/fpdf/creaPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/beneficiario.php');

$objBeneficiario = new beneficiario();


  $rif=$_GET['rif'];
  $nombre=$_GET['nombre'];
  $banco=$_GET['banco'];
  $fec=$_GET['fec'];
  $fec2=$_GET['fec2'];
  $tipoben=$_GET['tipoben'];
//$listaBen=$objBeneficiario->listarBeneficiarioExp($rif,$nombre,-1,$banco,$fec,$fec2);
  $listaBen=$objBeneficiario->listarBeneficiarioExp2($rif,$nombre,-1,$banco,$fec,$fec2,$usuario,$cedula,$tipoben);
$nroFilas = 44;

$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->setY(30);
$pdf->SetFont('Arial','B',12);
$fecha=date("d/m/Y");
$dia=date("d");
$mes=date("m");
$ano=date("Y");
$pdf->cell(250,5,"Caracas, ".$dia." de ".ObtenerMesenLetras($mes)." del ".$ano,0,0,'R');
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,35);
$pdf->Cell(200,5,'Listado de Beneficiarios ',0,0,'C',0);


$pdf->SetFont('Arial','',7);
$pdf->SetXY(10,50);

    $cabecera = array('N°','CI/RIF','Beneficiario','Sexo','Fecha_Nac','Domicilio Fiscal','Telefono 1','Observacion','Banco','Usuario','Tipo');
	$anchos = array(5,15,45,12,13,80,15,20,20,15,20);
	$alineaciones = array('C','C','L','C','C','L','C','C','L','C','C');


$pdf->cabecera1($cabecera,$anchos);
$pdf->SetFont('Arial','',5);
$pdf->SetWidths($anchos);
$pdf->SetAligns($alineaciones);
$pdf->SetBorder(true);
$j=1;

    for($i=0;$i<count($listaBen);$i+=$nroFilas){
       $pdf->Row(array($j."",$listaBen[$i],$listaBen[$i+6],$listaBen[$i+34],$listaBen[$i+39],$listaBen[$i+7].' '.$listaBen[$i+8].' '.$listaBen[$i+9].' Piso- '.$listaBen[$i+10].' Apto- '.$listaBen[$i+11],$listaBen[$i+14], $listaBen[$i+16],$listaBen[$i+41],$listaBen[$i+42],$listaBen[$i+43]));




    if ($pdf->getY()>175){
    	$pdf->AddPage();
$pdf->setY(30);
$pdf->SetFont('Arial','B',12);
$fecha=date("d/m/Y");
$dia=date("d");
$mes=date("m");
$ano=date("Y");
$pdf->cell(250,5,"Caracas, ".$dia." de ".ObtenerMesenLetras($mes)." del ".$ano,0,0,'R');
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,35);
$pdf->Cell(200,5,'Listado de Beneficiarios ',0,0,'C',0);
$pdf->SetFont('Arial','',7);
        $pdf->SetXY(10,45);
    	/*$pdf->addpage();
    	$pdf->SetFont('Arial','B',8);
		$pdf->SetXY(10,35);
		$pdf->Cell(200,5,'Listado de Facturas Filtradas por '.$cadena,0,0,'C',0);
		$pdf->SetXY(10,45);
    	$pdf->cabecera($cabecera,$anchos);
    	$pdf->SetFont('Arial','',6);*/



    $cabecera = array('N°','CI/RIF','Beneficiario','Sexo','Fecha_Nac','Domicilio Fiscal','Telefono 1','Observacion','Banco','Usuario','Tipo');
	$anchos = array(5,15,45,12,13,80,15,20,20,15,20);
	$alineaciones = array('C','C','L','C','C','L','C','C','L','C','C');


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
     	$pdf->Cell(200,5,'Total de Beneficiarios: '.abs($j-1),0,0,'L',0);
     $pdf->SetWidths(array(200));
	 $pdf->SetAligns(array('R'));
	 $pdf->SetFont('Arial','B',8);
	 $pdf->Row(array("Total de Beneficiarios: ".abs($j-1)));

$pdf->Output();
?>