<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/crearPDFMin.php');
require('../../controlador/funciones.php');
require('../../modelos/beneficiario.php');

 $objBeneficiario=new beneficiario();

 $numlotveh = $_GET['lote'];

 $fecha=date('d/m/Y');

	$listar_Bene_Tipo_benef=$objBeneficiario->listar_Bene_Tipo_benef($numlotveh);
    $totalG1+=$listar_Bene_Tipo_benef[$i+1];
    $totalG2+=$listar_Bene_Tipo_benef[$i+2];
    $totalG3+=$listar_Bene_Tipo_benef[$i+3];
    $totalG4+=$listar_Bene_Tipo_benef[$i+4];
    $totalG5+=$listar_Bene_Tipo_benef[$i+5];

$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle("Personas Registradas en sistema por tipo");
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$titulo1 = 'Personas Registradas en sistema por tipo';
$cabe1 = 'al '.$fecha;
//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->SetXY(5,35);
$pdf->Cell(255,5,utf8_decode($titulo1.' '.$cabe1),0,1,'C',0);
$pdf->SetXY(10,45);

	$anch_ = array(100,30,30,30,30,30);
	$alin_ = array('L','C','C','C','C','C');
	$pdf->SetWidths($anch_);
    $pdf->SetAligns($alin_);

$pdf->Ln();
$pdf->SetFillColor(252,223,172);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',15);
$pdf->SetTextColor(0);
$pdf->Rect(10,47,250,10,FD); /*
    D o una cadena vacia: draw. Este es el valor por defecto. (Borde sin relleno)
    F: fill sin borde con relleno
    DF o FD: draw and fill con borde con relleno */
			$pdf->Row(array('Tipo de Persona'
			                ,'Venezolano'
			                ,'Extranjero'
			                ,'Gobierno'
			                ,'Juridico'
			                ,'Total'
			                ));

	//$alin_ = array('L','R','R','R','R','R');
   // $pdf->SetAligns($alin_);
$pdf->Ln();
$pdf->SetBorder(false);

$color=true;

for($i=0;$i<count($listar_Bene_Tipo_benef);$i+=6) {

            $pdf->SetFont('Arial','B',15);
            $pdf->SetFillColor(255,244,212);

            if($color){
            	 $pdf->Rect($pdf->getX(),$pdf->getY(),250,10,F);
                 $color=false;
            }else $color=true;


            $pdf->setjump(10);
			$pdf->Row(array($listar_Bene_Tipo_benef[$i]
			                ,$listar_Bene_Tipo_benef[$i+1]
			                ,$listar_Bene_Tipo_benef[$i+2]
			                ,$listar_Bene_Tipo_benef[$i+3]
			                ,$listar_Bene_Tipo_benef[$i+4]
			                ,$listar_Bene_Tipo_benef[$i+5]
			                ));
            $pdf->Line(10,$pdf->GetY()-10,260,$pdf->GetY()-10);//LINEA HORIZONTAL
			$pdf->Line(10,$pdf->GetY(),260,$pdf->GetY());//LINEA HORIZONTAL
}
$pdf->Output();
?>