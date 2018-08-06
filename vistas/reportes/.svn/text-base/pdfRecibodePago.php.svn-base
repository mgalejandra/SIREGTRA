<?php
session_start();
require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/pago.php');
/////////////////////////////////////////////////////////////////////////////////////////////////////

function f_montoletras ($monto) {
	$k = strpos($monto,",");
	$x1 = substr($monto,0,$k-1);
	$x2 = substr($monto,$k+1);
	return f_numletras($x1)." con $x2/100 céntimos.";
}
/////////////////////////////////////////////////////////////////////////////////////////////////////

$pdf=new PDF('P', 'mm','Letter');

$obj = new pago();

$data = $obj->printPagos($_GET['idpago']);
$nroCol = 14;
$numPagos = ceil(count($data)/$nroCol);

$fecha=date("d/m/Y");

$dd = date("j");
$mm = date("m");
$aa = date("Y");

$dia = f_numletras($dd);
//f_alert($dd.' - '.$dia);

$xdia = ($dd>1)?("a los $dia días"):"el 1°";
$mes = ObtenerMesenLetras($mm);
$ano = f_numletras($aa);

$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,35);
$pdf->Cell(200,5,'RECIBO DE PAGO',0,0,'C',0);
$pdf->ln(12);
$pdf->SetXY(165,50);
$pdf->Cell(190,0,'Pago Nro:'.$data[0],'R');
$pdf->ln(12);
$pdf->SetFont('Arial','',12);
//$pdf->SetXY(10,35);
/* */
if($numPagos>1) $s = 's';
$xnumpagos = f_numletras($numPagos);
$nombre = $data[8];

$RIF = substr($data[9],0,1).'-'.substr($data[9],1,strlen($data[9])-2).'-'.substr($data[9],strlen($data[9])-1);
$detalle1 = utf8_decode("SUMINISTROS VENEZOLANOS INDUSTRIALES (SUVINCA) ".
						"hace constar que ha recibido ".
						"de $nombre, con N° de RIF: $RIF, ".
						"por concepto de adquisición de un vehículo marca $data[10], modelo $data[11] ".
						"la cantidad de $xnumpagos ($numPagos) pagos ".
						"cuyos datos se muestran a continuación:");

$pdf->SetX(20);
$pdf->write(5,$detalle1);

$pdf->ln(12);
$pdf->SetX($pdf->GetX()+5);

$cabecera = array('ID','N° Pago','Monto','Fecha','Banco','N° Cuenta del pago','Tipo');

$anchos = array(12,22,20,20,40,45,30);
$alinea = array('C','C','R','C','C','C','C');
$pdf->cabecera($cabecera,$anchos);

//$pdf->ln();

	$pdf->SetX($pdf->GetX()+5);
	$pdf->SetWidths($anchos);
	$pdf->SetAligns($alinea);
	$pdf->SetBorder(1);

	$pdf->SetFont('Arial','',10);

/////////////////////////////////////////////////////////////////////////////////////////////
  $montoTotal = 0;
  for($i=0;$i<$numPagos*$nroCol;$i+=$nroCol){
/*
	 	0   a.id_pago".
	 	1 , a.nro_pago".
	 	2 , a.monto".
	 	3 , to_char(a.fec_pago,'dd/mm/yyyy')".
	 	4 , a.status_pago".
	 	5 , a.id_banco".
	 	6 , d.nom_banco".
	 	7 , a.nro_cuenta".
	 	8 , c.nomcomp".
	 	9 , c.codpro".
	 	10, e.desmar".
	 	11, f.desmod".
*/
	$montoTotal += $data[$i+2];
	$pdf->row(array(formatomonto($data[$i],0)
				   ,$data[$i+1]
				   ,formatomonto($data[$i+2])
				   ,$data[$i+3]
				   ,$data[$i+6]
				   ,$data[$i+5].'-'.$data[$i+7]
				   ,$data[$i+13]));
	$pdf->SetX($pdf->GetX()+5);

}
/////////////////////////////////////////////////////////////////////////////////////////////

$x_montoTotal = formatomonto($montoTotal);

$detalle2 = utf8_decode("El monto total recibido es de Bs $x_montoTotal.");
$detalle3 = utf8_decode("Constancia que se expide en Caracas $xdia del mes de $mes de $ano.");

$pdf->SetFont('Arial','',12);
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
$pdf->write(5,utf8_decode($nombre));
$pdf->SetXY(20,$pdf->GetY()+5);
$pdf->write(5,utf8_decode("N° RIF:".$RIF));


$pdf->SetXY(140,$yy);
$pdf->write(5,"_____________________________________");
$pdf->SetFont('Arial','B',8);
$pdf->SetXY(140,$pdf->GetY()+5);
$pdf->write(5,"Nombre y apellido:");
$pdf->SetXY(140,$pdf->GetY()+5);
$pdf->write(5,utf8_decode("N° C.I:________________"));

/////////////////////////////////////////////////////////////////////////////////////////////

$fechahoy = $aa.$mm.$dd;
$pdf->Output("$fechahoy NOTA ENTREGA",'I');
?>
