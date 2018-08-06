<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/citas.php');

$objIP = new citas();

$listaIP=$objIP->listarIPRep($ip,-1);
$nroCampos = 2;

$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle("IP's repetidas'");
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$titulo1 = 'Listado de IPs repetidas';

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',11);
$pdf->SetXY(5,35);

$pdf->Cell(255,5,utf8_decode($titulo1),0,1,'C',0);
$pdf->SetXY(10,45);

        $cabecera_ = array('N°','IP','Cant. Solicitudes','Estatus');
		$anch_ = array(10,50,50,45);
		$alin_ = array('C','L','C','L');
		$anch = array(260);
		$anch1 = array(260);

$c ='TOTALES';


$pdf->cabecera1($cabecera_,$anch_);
$pdf->SetFont('Arial','',6);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);
$j=0;
for($i=0;$i<count($listaIP);$i+=$nroCampos) {
	$j++;

	$listaIP1=$objIP->listarIP($listaIP[$i+1],-1);
                         if ($listaIP1[2]=="B") $estatus= "Bloqueada";
                         else $estatus= "Desbloqueada";

  			$pdf->Row(array(FormatoNum($j)
 			                ,$listaIP[$i+1]
			                ,$listaIP[$i]
			                ,$estatus));

    if ($pdf->getY()>170){
    	$pdf->addpage();

			$pdf->SetFont('Arial','B',6);
			$pdf->SetXY(10,30);
			$pdf->Cell(0,7,utf8_decode($titulo1),0,1,'C',0);
			$pdf->SetFont('Arial','',6);

			$pdf->cabecera1($cabecera_,$anch_);
			$pdf->SetFont('Arial','',6);
			$pdf->SetWidths($anch_);
			$pdf->SetAligns($alin_);
			$pdf->SetBorder(true);
	    }
}
$pdf->ln();
//$pdf->Cell(48,5,$c,1,0,'R',0);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$pdf->SetBorder(true);

     $pdf->ln();

     $xtit = utf8_decode("Total: ".$j." Ip's repetidas");
     $pdf->Cell(90,5,$xtit,0,0,'L',0);

$pdf->Output();
?>