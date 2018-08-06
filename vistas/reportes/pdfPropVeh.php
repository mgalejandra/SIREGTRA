<?php
session_start();
require('../../modelos/conexion.php');
require ('../../modelos/fpdf/creaPDFSuv.php');
require('../../controlador/funciones.php');
require('../../modelos/factura.php');

$pdf=new PDF('P', 'mm','Letter');

$objFactura = new factura();
$idfactura = $_GET['idfactura'];
$tipo= $_GET['tipo'];/*
$director = "Lic. Eddie Betancourt Romero";
$gaceta = "Decreto N° 8057, publicado en la Gaceta Oficial de la";
$gaceta1= " República Bolivariana de Venezuela";
$gaceta2= " N° 39.616 de fecha 15 de Febrero de 2011";*/

$director = "Cddno. Vinicio Micotti Lanz";
$gaceta = "Resolución N° 010-14, publicada en la Gaceta Oficial de la";
$gaceta1= " República Bolivariana de Venezuela";
$gaceta2= " N° 40.345 de fecha 30 de enero de 2014";


$listarFactura=$objFactura->reporteFactura($idfactura,$tipo);
$detalleVehiculo=$objFactura->detalleVehiculo($listarFactura[9]);

$nroCol = 14;
$numPagos = ceil(count($data)/$nroCol);

$fecha=date("d/m/Y");

$dd = date("j");
$mm = date("m");
$aa = date("Y");

//$dia = f_numletras($dd);

$xdia = ($dd>1)?(" $dia días"):"el 1°";
$mes = ObtenerMesenLetras($mm);
$ano = f_numletras($aa);

$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->SetXY(155,25);
$pdf->SetFont('Arial','',10);
$pdf->Cell(50,5,utf8_decode('Caracas, '.$dd.' de '.$mes.' de '.$aa),0,0,'R',0);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(10,35);
$pdf->Cell(100,5,utf8_decode('Señores'),0,0,'L',0);
$pdf->ln(5);
$pdf->Cell(100,5,utf8_decode('Instituto Nacional de Transporte Terrestre'),0,0,'L',0);
$pdf->ln(5);
$pdf->Cell(100,5,utf8_decode('Su despacho.-'),0,0,'L',0);

$pdf->SetFont('Arial','',10);
$pdf->SetXY(10,60);
/*$pdf->MultiCell(190,5,utf8_decode('     Tengo el agrado de dirigirme a usted, en la oportunidad de manifestarle un saludo Revolucionario y Bolivariano y a su vez sirva ' .
		'la presente para informar que Suvinca ha estado suministrando a la población venezolana vehículos, a precios justos por lo que agradecemos' .
		' sirva la presente para prestarle el apoyo para el registro del vehículo y demás actos administrativos. A continuación se detallan los datos ' .
		'del beneficiario y el vehículo asignado.'), 0,'J');*/
$pdf->MultiCell(190,5,utf8_decode('     Tengo el agrado de dirigirme a ustedes, en la oportunidad de manifestarles un saludo Revolucionario y Bolivariano y a su ' .
		' vez informarles que Suvinca ha estado suministrando a la población venezolana vehículos a precios justos, siendo el(la) ciudadano(a) que menciono a continuación' .
		' uno(a) de los beneficiados. Aprovecho la ocasión para solicitar sus buenos oficios y le sea prestado el apoyo necesario para que realice el registro del vehículo' .
		' y los demás actos administrativos que implica la adquisición de un vehículo.'), 0,'J');
$pdf->ln(3);
$pdf->MultiCell(190,5,utf8_decode('     A continuación se detallan los datos del beneficiario y el vehículo ' .
		' asignado: '), 0,'J');

$pdf->ln(8);
$pdf->SetFont('Arial','',10);
$pdf->SetX(15);
$pdf->Cell(10,5,'Beneficiario: ',0,0,'L',0);
$pdf->ln(5);
$pdf->SetX(25);
$pdf->Cell(10,5,'Nombre: ',0,0,'L',0);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(40);
$pdf->Cell(150,5,utf8_decode($listarFactura[12]),0,0,'L',0);
$pdf->ln(5);
$pdf->SetFont('Arial','',10);
$pdf->SetX(25);
$pdf->Cell(10,5,utf8_decode('Cédula de Identidad: '),0,0,'L',0);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(60);
$pdf->Cell(150,5,$listarFactura[13],0,0,'L',0);


$pdf->ln(9);
$pdf->SetFont('Arial','',10);
$pdf->SetX(15);
$pdf->Cell(10,5,utf8_decode('Datos del Vehículo: '),0,0,'L',0);
$pdf->ln(5);
$pdf->SetX(25);
$pdf->Cell(10,5,'Placas: ',0,0,'L',0);
$pdf->SetX(60);
$pdf->Cell(150,5,utf8_decode($detalleVehiculo[1]),0,0,'L',0);
$pdf->ln(5);
$pdf->SetX(25);
$pdf->Cell(10,5,utf8_decode('Serial de Carrocería: '),0,0,'L',0);
$pdf->SetX(60);
$pdf->Cell(150,5,utf8_decode($detalleVehiculo[2]),0,0,'L',0);
$pdf->ln(5);
$pdf->SetX(25);
$pdf->Cell(10,5,utf8_decode('Marca: '),0,0,'L',0);
$pdf->SetX(60);
$pdf->Cell(150,5,utf8_decode($detalleVehiculo[5]),0,0,'L',0);
$pdf->ln(5);
$pdf->SetX(25);
$pdf->Cell(10,5,utf8_decode('Modelo: '),0,0,'L',0);
$pdf->SetX(60);
$pdf->Cell(150,5,utf8_decode($detalleVehiculo[6]),0,0,'L',0);
$pdf->ln(5);
$pdf->SetX(25);
$pdf->Cell(10,5,utf8_decode('Año: '),0,0,'L',0);
$pdf->SetX(60);
$pdf->Cell(150,5,$detalleVehiculo[9],0,0,'L',0);


$pdf->SetX(10);

$pdf->ln(10);
$detalle2 = utf8_decode('     Agradeciendo la atención prestada y quedando a sus órdenes para cualquier información que pueda requerir, se suscribe');

$pdf->SetFont('Arial','',10);
$pdf->SetX(20);
$pdf->ln(20);
$pdf->write(5,$detalle2);


/////////////////////////////////////////////////////////////////////////////////////////////

$pdf->ln(36);
$pdf->SetX(70);
$pdf->write(5,"_____________________________________");
$yy = $pdf->GetY();
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(80,$pdf->GetY()+5);
$pdf->write(5,utf8_decode($director));
$pdf->SetXY(80,$pdf->GetY()+5);
$pdf->SetFont('Arial','',6);
$pdf->write(5,utf8_decode($gaceta));
$pdf->SetFont('Arial','B',6);
$pdf->SetXY(85,$pdf->GetY()+5);
$pdf->write(5,utf8_decode($gaceta1));
$pdf->SetXY(83,$pdf->GetY()+5);
$pdf->write(5,utf8_decode($gaceta2));



/////////////////////////////////////////////////////////////////////////////////////////////

$fechahoy = $aa.$mm.$dd;
$pdf->Output("carta_prop_veh_$fechahoy",'I');
?>