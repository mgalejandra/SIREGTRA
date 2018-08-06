<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/crearPDF.php');
require('../../modelos/vehiculos.php');

function f_alert ($msj) {
	echo '<script>alert("'.$msj.'");</script>';
	return;
}

function Format_Monto($value,$dec='2'){
  	//H::FormatoMonto($monto)
  	$for='VE';
  	    if ($for=='VE')$valor = number_format($value,$dec,',','.');
  	elseif ($for=='IN')$valor = number_format($value,$dec,'.',',');
  	else $valor = number_format($value,0);
  	return ($valor==0)?'':$valor;
  }

function fechaHoy($forma){
	$today = mktime(0,0,0,date("Y"),date("m"),date("d"));
	return date($forma);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////

$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle($title);
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(10,35);
$pdf->Cell(256,5,'INVENTARIO DE VEHICULOS AL '.fechahoy("d/m/Y"),0,0,'C',0);

$pdf->SetXY(10,45);
$cabeza1 = array('Especificaciones del vehículo','Cantidad de unidades','Vendidas','En espera','Costo','Precio (máx.)');
$anchos1 = array(85,75,25,25,25,25);

$cabeza2 = array('Marca','Modelo','Adquiridas','Entregadas','En almacén','sin entregar','de pago (*)','unitario','de venta');
$anchos2 = array(40,45,25,25,25,25,25,25,25);

$alinea2 = array('C','C','C','C','C','C','C','R','R');
$pdf->cabecera($cabeza1,$anchos1);
$pdf->cabecera($cabeza2,$anchos2);

$objVehiculo = new vehiculos();
$nroCol = 9;
$tablaInv = $objVehiculo->listarVehiculosInv('I');

$pdf->SetWidths($anchos2);
$pdf->SetAligns($alinea2);
$pdf->SetBorder(true);

$pdf->SetFont('Arial','',10);
for($j=2;$j<7;$j++){
	$totalVeh[$j] = 0;
	for($i=0;$i<count($tablaInv);$i+=$nroCol)
		$totalVeh[$j] = $totalVeh[$j] + $tablaInv[$i+$j];
}
//f_alert($totalVeh[2].' '.$totalVeh[3].' '.$totalVeh[4].' '.$totalVeh[5].' '.$totalVeh[6]);

for($i=0;$i<count($tablaInv);$i+=$nroCol){
	 $pdf->row(array($tablaInv[$i]
	 				,$tablaInv[$i+1]
	 				,format_monto($tablaInv[$i+2],0)
					,format_monto($tablaInv[$i+3],0)
					,format_monto($tablaInv[$i+4],0)
					,format_monto($tablaInv[$i+5],0)
					,format_monto($tablaInv[$i+6],0)
					,format_monto($tablaInv[$i+7])
					,format_monto($tablaInv[$i+8])));
}
$pdf->SetWidths(array(85,25,25,25,25,25));
$pdf->SetAligns(array('R','C','C','C','C','C'));
$pdf->SetBorder(true);

$pdf->SetFont('Arial','B',10);
$pdf->row(array('Total:',format_monto($totalVeh[2],0)
						,format_monto($totalVeh[3],0)
						,format_monto($totalVeh[4],0)
						,format_monto($totalVeh[5],0)
						,format_monto($totalVeh[6],0)));

$pdf->SetFont('Arial','',6);
$pdf->ln();

$pdf->Write(5,utf8_decode("(*) Estas cifras no son definitivas porque puede estar realizándose una actualización de la data por consignación de cheques, aprobación ó liquidación del crédito por parte del banco."));

$pdf->Output(fechahoy("Ymd").'_Inventario_vehiculos.pdf','I');
?>
