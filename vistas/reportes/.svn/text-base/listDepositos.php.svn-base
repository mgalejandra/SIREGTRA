<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/deposito.php');

$obj = new deposito();

  $id_banco	= $_GET['id_banco'];
  $desde	= $_GET['desde'];
  $hasta	= $_GET['hasta'];

  $id_banco = $_SESSION['idBanco'];
  $desde 	= $_SESSION['desde_'];
  $hasta 	= $_SESSION['hasta_'];

  $listar = $obj->listarDepositos(null,$desde,$hasta,$id_banco);
  $nro_colum = 7;

$dd = date("d");
$mm = date("m");
$aa = date("Y");

$pdf=new PDF('P', 'mm','Letter');

$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,35);
$titulo = utf8_decode("Lista de Depósitos al $dd/$mm/$aa");
$pdf->Cell(200,5,$titulo,0,0,'C',0);

$pdf->SetXY(10,45);
$cabecera = array('ID','Banco','N° Cuenta','N° Planilla','Monto','Fecha','Fec.Reg.');

$nPixel = 60;
$lFont = 2;

$anch = array(10,40,40,40,20,20,20);
$alin = array('C','C','C','C','R','C','C');
$pdf->SetFont('Arial','B',10);
$pdf->cabecera($cabecera,$anch);
$pdf->SetFont('Arial','',8);
$pdf->SetWidths($anch);
$pdf->SetAligns($alin);
$pdf->SetBorder(true);
$j=0;

	$totalMonto = 0;
    for($i=0;$i<count($listar);$i+=$nro_colum){

		    $pdf->Row(array($listar[$i]
		    			,$listar[$i+4]
	    				,$listar[$i+5]
	    				,$listar[$i+1]
	    				,formatomonto($listar[$i+2])
	    				,$listar[$i+3]
	    				,$listar[$i+6]
	    				));

	    if ($pdf->getY()>235){
	    	$pdf->addpage();
	    	$pdf->SetFont('Arial','B',12);
			$pdf->SetXY(10,35);
			$pdf->Cell(200,5,$titulo,0,0,'C',0);
			$pdf->SetXY(10,45);
	    	$pdf->cabecera($cabecera,$anch);
	    	$pdf->SetFont('Arial','',8);
	    }
    	$j++;
    	$totalMonto += $listar[$i+2];
  }

     //totales
//     $pdf->ln();
     $xtit = utf8_decode("Total: ".$j." depósitos");
     $pdf->Cell(90,5,$xtit,0,0,'L',0);
/*     $pdf->SetWidths(array(90));
	 $pdf->SetAligns(array('R'));
	 $pdf->SetFont('Arial','B',12);
	 $pdf->Row(array($xtit));
*/
	 $pdf->Cell(40,5,"Monto Total: ",0,0,'R',0);
	 $pdf->Cell(20,5,formatomonto($totalMonto),0,0,'R',0);
/*     $pdf->SetWidths(array(60));
	 $pdf->SetAligns(array('R'));
	 $pdf->SetFont('Arial','B',12);
	 $pdf->Row(array($xtit));
*/


$fechahoy = $aa.$mm.$dd;
$pdf->Output("$fechahoy LISTA DEPÓSITOS",'I');
?>