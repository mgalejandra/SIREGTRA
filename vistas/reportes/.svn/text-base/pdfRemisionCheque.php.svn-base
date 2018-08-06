<?php
session_start();
require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/relacionC.php');
/////////////////////////////////////////////////////////////////////////////////////////////////////

function f_montoletras ($monto) {
	$k = strpos($monto,",");
	$x1 = substr($monto,0,$k-1);
	$x2 = substr($monto,$k+1);
	return f_numletras($x1)." con $x2/100 céntimos.";
}
/////////////////////////////////////////////////////////////////////////////////////////////////////

$pdf=new PDF('P', 'mm','Letter');

$obj = new relacionC();
$nombreUsu = $_SESSION['nombre']." ".$_SESSION['apellido'];

$data = $obj->listarChequeRemPDF($_GET['rem']);
$nroCol = 14;
$numPagos = ceil(count($data)/$nroCol);

$fecha=date("d/m/Y");

$dd = date("j");
$mm = date("m");
$aa = date("Y");

$dia = f_numletras($dd);

$xdia = ($dd>1)?(" $dia días"):"el 1°";
$mes = ObtenerMesenLetras($mm);
$ano = f_numletras($aa);

$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(10,35);
$pdf->Cell(100,5,utf8_decode('DE:       Departamento de Vehículos'),0,0,'L',0);
$pdf->ln(5);
$pdf->Cell(100,5,utf8_decode('PARA:  Dirección de Administración y Servicios'),0,0,'L',0);




$pdf->SetXY(10,60);
$pdf->Cell(200,5,'REMISION DE CHEQUES',0,0,'C',0);
$pdf->ln(12);

$pdf->SetFont('Arial','',10);

if($numPagos>1) $s = 's';
$xnumpagos = f_numletras($numPagos);

$detalle1 = utf8_decode("Se remite la cantidad de $xnumpagos ($numPagos) cheque$s de gerencia ".
						"cuyos datos se muestran a continuación:");

$pdf->SetX(20);
$pdf->write(5,$detalle1);

$pdf->ln(12);
$pdf->SetX(10);


$cabecera = array('ID','Cheque','Beneficiario','Serial Vehículo');
$anchos = array(5,95,65,35);
$alinea = array('C','C','C','C');

$pdf->SetX(10);
$cabecera_ = array('','N°','Monto','Fecha','Banco','Cédula','Nombre','');
$anchos_ = array(5,18,22,20,35,20,45,35);
$alinea_ = array('C','C','R','C','C','C');


$pdf->cabecera($cabecera,$anchos);
$pdf->cabecera($cabecera_,$anchos_);

	$pdf->SetX(10);
	$pdf->SetWidths($anchos_);
	$pdf->SetAligns($alinea_);
	$pdf->SetBorder(1);

	$pdf->SetFont('Arial','',7);

/////////////////////////////////////////////////////////////////////////////////////////////
  $montoTotal = 0;
  $j=0;
  for($i=0;$i<$numPagos*$nroCol;$i+=$nroCol){
  	$j=$j+1;
/*
	 	0   e.reldesc".
	 	1 , e.fecha".
	 	2 , b.numcheque".
	 	3 , b.monto".
	 	4 , a.banco_descrip".
	 	5 , c.id_asignacion".
	 	6 , c.fecha_asig".
	 	7 , c.sercarveh".
	 	8 , d.codpro".
	 	9 , d.prinompro".
	 	10, d.segnompro".
	 	11, d.priapepro".
	 	12, d.segapepro".
	 	13, b.idcheque".
*/
	$montoTotal += $data[$i+3];

	$nombre=$data[$i+9]." ".$data[$i+10]." ".$data[$i+11]." ".$data[$i+12];
	$pdf->row(array(formatonum($j),$data[$i+2],formatomonto($data[$i+3]),$data[$i+1],$data[$i+4],$data[$i+8],$nombre,$data[$i+7]));
	$pdf->SetX(10);

}
/////////////////////////////////////////////////////////////////////////////////////////////

$x_montoTotal = formatomonto($montoTotal);

$detalle2 = utf8_decode("El monto total de los cheques enviados es de Bs.F. $x_montoTotal.");
$detalle3 = utf8_decode("Remisión que se expide en Caracas a los $xdia del mes de $mes de $ano.");

$pdf->SetFont('Arial','',10);
$pdf->SetX(20);
$pdf->ln();
$pdf->write(5,$detalle2);
$pdf->ln(12);
$pdf->write(5,$detalle3);

/////////////////////////////////////////////////////////////////////////////////////////////

$pdf->SetFont('Arial','',8);
$pdf->SetXY(20,$pdf->GetY()+24);
$pdf->write(5,"Firma:");
$pdf->SetXY(140,$pdf->GetY()+5);
$pdf->write(5,"Recibe:");


$pdf->ln(24);
$pdf->SetX(20);
$pdf->write(5,"_____________________________________");
$yy = $pdf->GetY();
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(20,$pdf->GetY()+5);
$pdf->write(5,utf8_decode($nombreUsu));
$pdf->SetXY(20,$pdf->GetY()+5);
$pdf->write(5,utf8_decode("Usuario: ".$_SESSION['usuario']));


$pdf->SetXY(140,$yy);
$pdf->write(5,"_____________________________________");
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(140,$pdf->GetY()+5);
$pdf->write(5,"Nombre y apellido:");
$pdf->SetXY(140,$pdf->GetY()+5);
$pdf->write(5,utf8_decode("N° C.I:________________"));

/////////////////////////////////////////////////////////////////////////////////////////////

$fechahoy = $aa.$mm.$dd;
$pdf->Output("remision_cheque_$fechahoy",'I');
?>