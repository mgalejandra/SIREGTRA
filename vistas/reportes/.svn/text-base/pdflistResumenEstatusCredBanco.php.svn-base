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

  $banco = $_GET['banco'];
  $fechaD = $_GET['fechaD'];
  $fechaH = $_GET['fechaH'];
  $status = $_GET['estatus'];
  //$numlotveh = $_GET['lote'];

$listarEstatusBanco=$_SESSION['listarEstatusBanco'];

$realAprob=$_SESSION['aprobado'];
$realNeg = $_SESSION['negado'];
$realAnal = $_SESSION['analisis'];
$realDif= $_SESSION['diferido'];
$realED = $_SESSION['esperadoc'];
$realDI=$_SESSION['docincomp'];
$realIVC= $_SESSION['impvercons'];
$realDCG=$_SESSION['devcamgar'];
$realCGP= $_SESSION['cangarproc'];
$total= $_SESSION['totaltotal'];


$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle("Listado Resumen Estatus Credito por Banco");
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$titulo1 = 'Cuadro Resumen Resumen Estatus Credito por Banco';

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

   $valores = ""; //"Lote ".$numlotveh." ";
   if ($condicion=="COMPLETO") $valores .= '100% CREDITO';
   else $valores .= $condicion;

   if (($status) and ($condicion)) $valores .=  ' - '.$status;
   else $valores .= $status;

   $cabe2 = array($valores);

        $cabecera_ = array('Banco','Estatus','Total');
		$anch_ = array(50,180,25);
		$alin_ = array('L','R','R');


		$cabecera1_ = array(' ','CAB','CApr','CRech','CDif','AED','DDI','IVC','DCG','CGP','');
		$anch1_ = array(50,20,20,20,20,20,20,20,20,20,25);
		$alin1_ = array('L','R','R','R','R','R','R','R','R','R','R');


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

for($i=0;$i<count($listarEstatusBanco);$i++) {
	$j++;

    $bancoN = $banco[$i];
    $analisis=$listarEstatusBanco[$i][8];
	$aprobado=$listarEstatusBanco[$i][0];
	$negado=$listarEstatusBanco[$i][1];
	$diferido=$listarEstatusBanco[$i][2];
	$esperadoc=$listarEstatusBanco[$i][3];
	$docincomp=$listarEstatusBanco[$i][4];
	$impvercons=$listarEstatusBanco[$i][5];
	$devcamgar=$listarEstatusBanco[$i][6];
	$cangarproc=$listarEstatusBanco[$i][7];

			$reales1 = $analisis + $aprobado + $negado + $diferido + $esperadoc + $docincomp + $impvercons + $devcamgar + $cangarproc;
			//$totaltotal1 = $existentes - $reales1;

			$pdf->Row(array($bancoN
			                ,($analisis==0)?"":$analisis,($aprobado==0)?"":$aprobado,($negado==0)?"":$negado
			                ,($diferido==0)?"":$diferido,($esperadoc==0)?"":$esperadoc
			                ,($docincomp==0)?"":$docincomp,($impvercons==0)?"":$impvercons
			                ,($devcamgar==0)?"":$devcamgar,($cangarproc==0)?"":$cangarproc
			                ,FormatoNum($reales1)));
}


$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','',6);
$pdf->SetBorder(true);

$c='Total';

	$pdf->Cell(50,5,$c,1,0,'R',0);
	$pdf->Cell(20,5,($realAnal==0)?"":$realAnal,1,0,'R',0);
	$pdf->Cell(20,5,($realAprob==0)?"":$realAprob,1,0,'R',0);
	$pdf->Cell(20,5,($realNeg==0)?"":$realNeg,1,0,'R',0);
	$pdf->Cell(20,5,($realDif==0)?"":$realDif,1,0,'R',0);
	$pdf->Cell(20,5,($realED==0)?"":$realED,1,0,'R',0);
	$pdf->Cell(20,5,($realDI==0)?"":$realDI,1,0,'R',0);
	$pdf->Cell(20,5,($realIVC==0)?"":$realIVC,1,0,'R',0);
	$pdf->Cell(20,5,($realDCG==0)?"":$realDCG,1,0,'R',0);
	$pdf->Cell(20,5,($realCGP==0)?"":$realCGP,1,0,'R',0);
	$pdf->Cell(25,5,$total,1,0,'R',0);

    $pdf->ln();

/*$cabecera1_ = array(' ','CAB','CApr','CRech','CDif','AED','DDI','IVC','DCG','CGP','');
$cabecera1_ = array(' ','Crédito en Análisis Bancario','Crédito Aprobado','Crédito Rechazado','Crédito Diferido','A la Espera de Documentos',
'Devuelto por Documentación Incompleta','Imposible verificar constancia','Devuelto por cambio de Garantía','Cambio de Garantía Procesada','');*/

$pdf->Output();
?>