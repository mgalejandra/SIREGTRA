<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/citas.php');
require('../../modelos/usuarios.php');
require('../../modelos/beneficiario.php');

$objBeneficiarioCit = new beneficiario();

//$objBeneficiarioCit = new citas();
$objUsuario = new usuario();

  $rif=$_GET['rif'];
  $nombre=$_GET['nombre'];
  $fec=$_GET['fec'];
  $usuario=$_GET['usuario'];
  $usuario1 = $_GET['usu'];

//$listarCitaBenef=$_SESSION['listarCitaBenef'];


$listarCitaBenef= $objBeneficiarioCit->listarPrueba2();
$nroCampos = 7;

$pdf=new PDF('P', 'mm','Letter');

$pdf->SetTitle("Datos Beneficiario");
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$titulo1 = 'Resumen Solicitud del Beneficiario';

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',11);
$pdf->SetXY(5,35);

$pdf->Cell(255,5,utf8_decode($titulo1),0,1,'C',0);
$pdf->SetXY(10,45);


		$anch_ = array(10,20,20,20,20,20,20,20);
		$alin_ = array('C','L','L','L','L','L','C','C');
		$anch = array(260);
		$anch1 = array(260);




$pdf->SetFont('Arial','',6);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);
$j=0;
for($i=0;$i<count($listarCitaBenef);$i+=7) {
	$j++;



  			$pdf->Row(array(FormatoNum($j)
			                ,$listarCitaBenef[$i+0]
			                ,$listarCitaBenef[$i+1]
			                ,$listarCitaBenef[$i+2]
			                ,$listarCitaBenef[$i+3]
			                ,$listarCitaBenef[$i+4]
			                ,$listarCitaBenef[$i+5]
			                     ,$listarCitaBenef[$i+6]
			                ));





}


$pdf->Output();
?>