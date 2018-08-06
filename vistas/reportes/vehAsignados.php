<?php
session_start();
require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');

$pdf=new PDF('P', 'mm','Letter');

$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,35);
$pdf->Cell(200,5,'VEHICULOS ASIGNADOS',0,0,'C',0);

$pdf->SetXY(10,45);
$cabecera = array('Serial Carroceria','CI/RIF','Nombre','Fecha Asignacion');

$anchos = array(40,30,95,35);
$alineaciones = array('C','C','C','C');
$pdf->cabecera($cabecera,$anchos);

$pdf->Output();
?>