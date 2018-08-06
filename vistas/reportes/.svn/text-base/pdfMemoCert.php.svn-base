<?php
session_start();
require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/certificado.php');
require('../../modelos/pago.php');
/////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////

$pdf=new PDF('P', 'mm','Letter');

$objPago = new pago();

$objCertificado = new certificado();

$memo = $objCertificado->listarMemo($_GET['id']);

$data = $objCertificado->listarDetMemo($_GET['id']);

$listarBancos2=$objPago->listarBancos(4,$memo[4]);

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
$pdf->SetFont('Arial','B',8);
$pdf->setY(30);
$pdf->setX(20);
$pdf->MultiCell($XC,$YC,'Ref:'.str_pad($_GET['id'],6,'0',STR_PAD_LEFT),0,'L');
$pdf->SetFont('Arial','B',12);

$pdf->setY(40);
$pdf->SetFont('Arial','B',12);
$fecha=date("d/m/Y");
$dia=date("d");
$mes=date("m");
$ano=date("Y");
$pdf->cell(185,5,"Caracas, ".$dia." de ".ObtenerMesenLetras($mes)." del ".$ano,0,0,'R');

$pdf->setXY(20,60);
$pdf->SetFont('Arial','',12);
$pdf->cell(185,5,utf8_decode("Señores: "),0,0,'L');
$pdf->setXY(20,70);
$pdf->SetFont('Arial','B',12);
$pdf->cell(185,5,utf8_decode($listarBancos2[1]),0,0,'L');
$pdf->setY(80);
$pdf->setX(20);
$pdf->SetFont('Arial','',12);
$pdf->cell(185,5,utf8_decode("Presente.- "),0,0,'L');
$pdf->setY(90);
$pdf->SetFont('Arial','',12);
$pdf->cell(185,5,utf8_decode("Atención: "),0,0,'R');
$pdf->ln();
$pdf->cell(185,5,utf8_decode($memo[6]),0,0,'R');

$pdf->ln();
$pdf->ln(12);
$pdf->SetFont('Arial','',12);
//$pdf->SetXY(10,35);
/* */
/*if($numPagos>1) $s = 's';
$xnumpagos = f_numletras($numPagos);
$nombre = $data[8];
$cant=count($data)/19;
$RIF = substr($data[9],0,1).'-'.substr($data[9],1,strlen($data[9])-2).'-'.substr($data[9],strlen($data[9])-1);*/
$cant=count($data)/19;

$detalle1 = utf8_decode("		Tengo el agrado de dirigirme a usted, en la oportunidad de expresarle un cordial saludo Bolivariano y Revolucionario," .
		                " la presente es con el fin de informarle que se realiza la entrega de ".montoLetras($cant).' '."(".$cant.") Facturas y Certificados definitivos," .
		                " pertenecientes al Operativo del Plan Socialista de Vehículo para iniciar el proceso de liquidación de créditos, a continuación detalles de estas: ");

$pdf->SetX(20);
//$pdf->write(5,$detalle1);
$pdf->multicell(175,7,$detalle1);

if($memo[5]){
$pdf->ln();
$pdf->setX(20);
$pdf->SetFont('Arial','',12);
$pdf->Multicell(175,5,utf8_decode("Nota:  ").utf8_decode($memo[5]));
$pdf->ln();
}

/////////////////////////////////////////////////////////////////////////////////////////////
$pdf->ln(20);
$pdf->SetFont('Arial','',12);
$detalle1 = utf8_decode(" Sin otro particular al cual hacer referencia queda de usted. ");

$pdf->SetX(20);
//$pdf->write(5,$detalle1);
$pdf->multicell(175,5,$detalle1);

/////////////////////////////////////////////////////////////////////////////////////////////
$pdf->ln(20);
$detalle1 = utf8_decode("Atentamente,");
$pdf->SetX(20);
//$pdf->write(5,$detalle1);
$pdf->multicell(175,5,$detalle1);
/*
$pdf->setY(243);
$pdf->SetFont('Arial','B',10);
//$pdf->MultiCell($XC,$YC,utf8_decode('LCDA. EDDIE BETANCOURT ROMERO'),0,'C');
$pdf->MultiCell($XC,$YC,utf8_decode('VINICIO MICOTTI LANZ'),0,'C');
$pdf->ln(5);
//$pdf->MultiCell($XC,$YC,utf8_decode('PRESIDENTA'),0,'C');
$pdf->MultiCell($XC,$YC,utf8_decode('PRESIDENTE'),0,'C');
$pdf->SetFont('Arial','',10);
$pdf->ln(3.5);
$pdf->MultiCell($XC,$YC,utf8_decode('Decreto N° 8.057, publicado en Gaceta Oficial'),0,'C');
$pdf->ln(3.5);
$pdf->MultiCell($XC,$YC,utf8_decode('De la República Bolivariana de Venezuela'),0,'C');
$pdf->ln(3.5);
$pdf->MultiCell($XC,$YC,utf8_decode('N° 39.616, de fecha 15 de febrero de 2011'),0,'C');
$pdf->AddPage();*/


$pdf->setY(243);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell($XC,$YC,utf8_decode('VINICIO MICOTTI LANZ'),0,'C');
$pdf->ln(5);
$pdf->MultiCell($XC,$YC,utf8_decode('PRESIDENTE'),0,'C');
$pdf->SetFont('Arial','',10);
$pdf->ln(3.5);
$pdf->MultiCell($XC,$YC,utf8_decode('Resolución N° 001-15, publicada en Gaceta Oficial'),0,'C');
$pdf->ln(3.5);
$pdf->MultiCell($XC,$YC,utf8_decode('de la República Bolivariana de Venezuela'),0,'C');
$pdf->ln(3.5);
$pdf->MultiCell($XC,$YC,utf8_decode('N° 40.712, de fecha 29 de Julio de 2015'),0,'C');
$pdf->AddPage();

    $pdf->SetFont('Arial','B',8);
	$pdf->setY(30);
	$pdf->setX(20);
	$pdf->MultiCell($XC,$YC,'Ref:'.str_pad($_GET['id'],6,'0',STR_PAD_LEFT),0,'L');
	$pdf->SetFont('Arial','B',12);

$pdf->setY(35);
$pdf->SetX($pdf->GetX()+5);
$pdf->SetFont('Arial','',8);
$cabecera = array('Expedientes');

$anchos = array(182);
$alinea = array('C');
$pdf->cabecera($cabecera,$anchos);
$pdf->SetX($pdf->GetX()+5);
$pdf->SetFont('Arial','',8);
	$cabecera = array('N#','Certificado','Serial','Rif','Nombre','N°Fact.','Fec/Factura');

	$anchos = array(5,20,30,17,75,15,20);
$alinea = array('C','C','R','C','L','C','C');
$pdf->cabecera($cabecera,$anchos);

//$pdf->ln();

	$pdf->SetX($pdf->GetX()+5);
	$pdf->SetWidths($anchos);
	$pdf->SetAligns($alinea);
	$pdf->SetBorder(1);

	$pdf->SetFont('Arial','',7);

/////////////////////////////////////////////////////////////////////////////////////////////
  $montoTotal = 0;
  $cont=0;
  $cont2=0;
  $ban=true;
  $contro=20;
  for($i=0;$i<count($data);$i+=19){
    $cont++;
    $cont2++;
		$pdf->row(array($cont.''
	               ,$data[$i]
				   ,$data[$i+2]
				   ,$data[$i+3]
				   ,$data[$i+4]
				   ,$data[$i+6]
				   ,$data[$i+7]
				   ));
	$pdf->SetX($pdf->GetX()+5);

	if($cont2>$contro){
	$pdf->AddPage();
	$cont2=0;
	$pdf->SetFont('Arial','B',8);
	$pdf->setY(30);
	$pdf->setX(20);
	$pdf->MultiCell($XC,$YC,'Ref:'.str_pad($_GET['id'],6,'0',STR_PAD_LEFT),0,'L');
	$pdf->SetFont('Arial','B',12);

	$pdf->setY(30);
	$pdf->SetFont('Arial','B',12);
	$pdf->cell(185,5,utf8_decode("Continuación: "),0,0,'R');
	$pdf->ln(10);
	$pdf->SetX($pdf->GetX()+5);
	$pdf->SetWidths($anchos);
	$pdf->SetAligns($alinea);
	$pdf->SetBorder(1);

	$pdf->ln(5);
	$pdf->SetX($pdf->GetX()+5);
	$pdf->SetFont('Arial','',8);
	$cabecera = array('Expedientes');

	$anchos = array(182);
	$alinea = array('C');
	$pdf->cabecera($cabecera,$anchos);
	$pdf->SetX($pdf->GetX()+5);
	$pdf->SetFont('Arial','',8);
	$cabecera = array('N#','Certificado','Serial','Rif','Nombre','N°Fact.','Fec/Factura');

	$anchos = array(5,20,30,17,75,15,20);
	$alinea = array('C','C','R','C','L','C','C');
	$pdf->cabecera($cabecera,$anchos);
	$pdf->SetX($pdf->GetX()+5);
	$pdf->SetFont('Arial','',7);
     $ban=false;
}

  }





/////////////////////////////////////////////////////////////////////////////////////////////

$fechahoy = $aa.$mm.$dd;
$pdf->Output("$fechahoy Memo Certificados",'I');
?>