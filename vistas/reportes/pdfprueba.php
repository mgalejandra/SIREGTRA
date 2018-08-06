<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/beneficiario.php');

$objBeneficiarioCit = new beneficiario();



$listarCitaBenef= $objBeneficiarioCit->listarPrueba2();
//echo ($listarCitaBenef[0]).'aqui';


$pdf=new PDF('L', 'mm','Letter');

		$anch_ = array(10,20,50,35,40,10,20,25,20,15,20);
		$alin_ = array('L','L','L','L','L','C','C','C','C','C','C');

$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);
//$pdf->cell(5,5,$listarCitaBenef[0]);


for($i=0;$i<count($listarCitaBenef);$i+=7) {



  			$pdf->Row(array(0
  			                ,$listarCitaBenef[$i+0]
			                ,$listarCitaBenef[$i+1]
			                ,$listarCitaBenef[$i+2]
			                ,$listarCitaBenef[$i+3]
			                ,$listarCitaBenef[$i+4]
			                ,$listarCitaBenef[$i+5]
			                ,$listarCitaBenef[$i+6]
			                ));





}

$pdf->Output();
?>