<?php
session_start();
require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');

$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,35);
$pdf->Cell(250,5,'LISTADO DE BENEFICIARIOS',0,0,'C',0);

$pdf->SetXY(10,45);
$cabecera = array('CI / RIF','Nombre','Direccion','Telefono','Observaciones', 'Fecha Registro');

$anchos = array(30,50,50,40,50,30);
$alineaciones = array('C','C','C','C','C','C');
$pdf->cabecera($cabecera,$anchos);

$pdf->Output();
?>
