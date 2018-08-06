<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/venta.php');
require('../../modelos/fpdf/creaPDF.php');

///%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%///
function fechaHoy(){
	$today = mktime(0,0,0,date("Y"),date("m"),date("d"));
	return date("Y-m-d");
}

function fx_tipo ($tipo) {
    if($tipo=="CP") return "CP";
elseif($tipo=="C") return "CT"	;
elseif($tipo=="R") return "RP"	;
else return "RT";
}
///////////////////////////////// Crear PDF //////////////////////////////////////

$pdf = new PDF('P', 'mm','Letter');
$obj = new venta();

$title=utf8_decode("Reporte de Ventas");
$pdf->SetTitle($title);
$pdf->AddPage();
$subTitulo = "";

$pdf->setY(30);
$pdf->SetFont('Arial','B',12);
$pdf->write(5,$title);
$pdf->ln();

$cabeza = array('N°','ID','Lote','Serial Carrocería','Beneficiario','Tipo','Status','Fecha modif.');
$anchos = array(10,10,10,35,80,10,20,20);
$alinea = array('C','C','C','C','L','C','C','C');
$nroCol = count($alinea);

$compra = $_SESSION['compras_'];
$estatus = $_SESSION['estatus_'];
$status_credito = $_SESSION['statCred_'];

$numlotveh = $_SESSION['numlotveh_'];
$codmarveh = $_SESSION['codmarveh_'];
$desmarveh = $_SESSION['desmarveh_'];
$codmodveh = $_SESSION['codmodveh_'];
$desmodveh = $_SESSION['desmodveh_'];
$codserveh = $_SESSION['codserveh_'];
$desserveh = $_SESSION['desserveh_'];

$ventas = $obj->listarVenta2($id_numfac,$sercarveh,$beneficiario,$compra,$estatus,$status_credito,$numlotveh,$codmarveh,$codmodveh,$codserveh,-1);
$nroReg = count($ventas);

$pdf->cabecera($cabeza,$anchos);

//////////////////////////////////////////////////////////////////////////

$pdf->SetWidths($anchos);
$pdf->SetAligns($alinea);
$pdf->SetBorder(true);

$pdf->SetFont('Arial','',8);

for($i=0;$i<$nroReg;$i+=$nroCol){
	$j = $i / $nroCol + 1;
	$pdf->row(array(' '.$j.' '
					,$ventas[$i]
					,str_pad($ventas[$i+7],3,"0",STR_PAD_LEFT)
					,$ventas[$i+1]
					,utf8_decode($ventas[$i+2])
					,fx_tipo($ventas[$i+3])
					,utf8_decode($ventas[$i+4])
					,$ventas[$i+6]));
    	if ($pdf->getY()>245){
    		$pdf->SetFont('Arial','',6);
    		$pdf->Write(5,utf8_decode("CP:Contado Parcial,  CT:Contado Total,  RP:Crédito Parcial,  RT:Crédito Total"));
			$pdf->addpage();

			$pdf->setY(30);
			$pdf->SetFont('Arial','B',12);
			$pdf->write(5,$title);
			$pdf->ln();

			$pdf->SetFont('Arial','B',8);
		    $pdf->cabecera($cabeza,$anchos);
	        $pdf->SetFont('Arial','',8);
		}
}
$pdf->SetFont('Arial','',6);
$pdf->Write(5,utf8_decode("CP:Contado Parcial,  CT:Contado Total,  RP:Crédito Parcial,  RT:Crédito Total"));

$pdf->Output(fechahoy().' - '.$title.'.pdf','I');

?>