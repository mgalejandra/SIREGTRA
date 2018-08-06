<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/reportes.php');
require('../../modelos/pago.php');
require('../../modelos/banco.php');
require('../../modelos/lotes.php');
require('../../modelos/factura.php');

  $condicion = $_GET['cond'];
  $fechaD = $_GET['fechaD'];
  $fechaH = $_GET['fechaH'];
  $status = $_GET['estatus'];
  $numlotveh = $_GET['lote'];

$listarCertEmi=$_SESSION['listarCertEmi'];
$listarCertEmiC=$_SESSION['listarCertEmiC'];

$realQQ=$_SESSION['realqq'];
$realX1 = $_SESSION['realx1'];
$realTig =     $_SESSION['realtig'];
$realT42 = $_SESSION['realt42'];
$realT44 = $_SESSION['realt44'];
$total= $_SESSION['totaltotal'];

$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle("Listado Resumen Marca Chery por Banco");
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$titulo1 = 'Cuadro Resumen de Proformas de Vehículos Chery';

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(5,35);

$pdf->Cell(255,5,utf8_decode($titulo1),0,1,'C',0);
$pdf->SetXY(10,45);


   if (($fechaD) and ($fechaH))
	 	$cabe1 = array('Desde el '.$fechaD.' hasta el '.$fechaH.'');
   elseif (($fechaD) and !($fechaH))
		$cabe1 = array('Desde el '.$fechaD.'');
   elseif (!($fechaD) and ($fechaH))
		$cabe1 = array('Hasta el '.$fechaH.'');

   $valores = "Lote ".$numlotveh." ";
   if ($condicion=="COMPLETO") $valores .= '100% CREDITO';
   else $valores .= $condicion;

   if (($status) and ($condicion)) $valores .=  ' - '.$status;
   else $valores .= $status;

   $cabe2 = array($valores);

        $cabecera_ = array('Banco','Modelo','Total');
		$anch_ = array(50,170,35);
		$alin_ = array('L','R','R');

		$cabecera1_ = array(' ','QQ3','X1','Tiggo','Tigger 4*2','Tigger 4*4','');
		$anch1_ = array(50,34,34,34,34,34,35);
		$alin1_ = array('L','R','R','R','R','R','R');


		$anch = array(255);
		$anch1 = array(255);

$pdf->cabecera($cabe1,$anch1);
$pdf->cabecera($cabe2,$anch1);
$pdf->cabecera1($cabecera_,$anch_);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetFont('Arial','',6);
$pdf->cabecera1($cabecera1_,$anch1_);
$pdf->SetWidths($anch1_);
$pdf->SetAligns($alin1_);
$pdf->SetBorder(true);
$j=0;

	$banco[0] = "BANCO INDUSTRIAL DE VENEZUELA, C.A";
    $banco[1] = "BANCO DE VENEZUELA S.A.C.A";
    $banco[2] = "BANCO DEL TESORO";
    $banco[3] = "BANCO BICENTENARIO BANCO UNIVERSAL, C.A.";
    $banco[4] = "BANCO DE DESARROLLO ECONOMICO Y SOCIAL DE VENEZUELA";
    $banco[5] = "BANCO DEL PUEBLO";

for($i=0;$i<count($listarCertEmi);$i++) {
	$j++;

    $bancoN = $banco[$i];
	$qq = $listarCertEmi[$i][0];
	$x1 = $listarCertEmi[$i][1];
    $tiggo=$listarCertEmi[$i][2];
    $t42 = $listarCertEmi[$i][3];
    $t44 = $listarCertEmi[$i][4];


			$reales1 = $qq + $x1 + $tiggo + $t42 + $t44;
			//$totaltotal1 = $existentes - $reales1;

			$pdf->Row(array($bancoN
			                ,($qq==0)?"":$qq,($x1==0)?"":$x1,($tiggo==0)?"":$tiggo
			                ,($t42==0)?"":$t42,($t44==0)?"":$t44
			                ,FormatoNum($reales1)));
}

for($k=0;$k<count($listarCertEmiC);$k+=6) {
	$l++;

    $condicion = "CONTADO";
	$qqC = $listarCertEmiC[$k][0];
	$x1C = $listarCertEmiC[$k][1];
    $tiggoC=$listarCertEmiC[$k][2];
    $t42C = $listarCertEmiC[$k][3];
    $t44C = $listarCertEmiC[$k][4];


			$reales1C = $qqC + $x1C + $tiggoC + $t42C + $t44C;
			//$totaltotal1 = $existentes - $reales1;

			$pdf->Row(array($condicion
			                ,($qqC==0)?"":$qqC,($x1C==0)?"":$x1C,($tiggoC==0)?"":$tiggoC
			                ,($t42C==0)?"":$t42C,($t44C==0)?"":$t44C
			                ,FormatoNum($reales1C)));

}


$pdf->ln();

$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','',6);
$pdf->SetBorder(true);

$c='Total';

	$pdf->Cell(50,5,$c,1,0,'R',0);
	$pdf->Cell(34,5,($realQQ==0)?"":$realQQ,1,0,'R',0);
	$pdf->Cell(34,5,($realX1==0)?"":$realX1,1,0,'R',0);
	$pdf->Cell(34,5,($realTig==0)?"":$realTig,1,0,'R',0);
	$pdf->Cell(34,5,($realT42==0)?"":$realT42,1,0,'R',0);
	$pdf->Cell(34,5,($realT44==0)?"":$realT44,1,0,'R',0);
	$pdf->Cell(35,5,$total,1,0,'R',0);

    $pdf->ln();

$pdf->Output();
?>