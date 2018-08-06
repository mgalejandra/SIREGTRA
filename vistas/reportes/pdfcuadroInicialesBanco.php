<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/reportes.php');
require('../../controlador/funciones.php');
require('../../modelos/banco.php');
require('../../modelos/modelos.php');
require('../../modelos/marca.php');

$objReporte= new reportes();
$objBanco 		= new banco();
$objMarca = new marca();
$objModelo = new modelos();

$codmar= $_GET['marca'];
$fechaD=$_GET['desde'];
$fechaH=$_GET['hasta'];
$codmodveh=$_GET['mod'];
$numlotveh=$_GET['lote'];
$banco=$_GET['banco'];


if ($banco) $nombreB = $objBanco->listarBancos($banco);

//$listarCertEmi = $objReporte->cuadroIniConsignadas();
$listarCertEmi = $objReporte->cuadroIniConsignadas($numlotveh,$fechaD,$fechaH,$codmar,$codmodveh,$banco);//;cuadroIniConsignadas();

$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle("Iniciales Consignadas por Banco");
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$titulo1 = 'Iniciales Consignadas por Banco';

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(5,35);

$pdf->Cell(255,5,utf8_decode($titulo1),0,1,'C',0);
$pdf->SetXY(10,45);


   if (($fechaD) and ($fechaH))
	 	$cabe1 = array('Desde el '.$fechaD.' hasta el '.$fechaH.'');
   elseif (($fechaD) and !($fechaH))
		$cabe1 = array('Desde el '.$fechaD.'');
   elseif (!($fechaD) and ($fechaH))
		$cabe1 = array('Hasta el '.$fechaH.'');

 if ($banco)
 	$cabe3 = array($nombreB[2]);
 else
	$cabe3 = array('TODOS LOS BANCOS');


	     	      if (($codmar) or ($codmodveh)){

	     	      	$nombreMod= $objModelo->buscarModeloID($codmodveh);
	     	      	$nombreMar= $objMarca->buscarMarca($codmar);
	     	      }


	     	      if (($codmar) and ($codmodveh)) $cabe4 = array($nombreMar[1].' '.$nombreMod[1]);
	     	      else if (($codmar) and (!$codmodveh)) $cabe4 = array($nombreMar[1]);
	     	      else if ((!$codmar) and ($codmodveh)) $cabe4 = array($nombreMod[1]);
	     	      else $cabe4 = array('TODAS LAS MARCAS - TODOS LOS MODELOS');


        $cabecera_ = array('Banco','Personas','Monto');
		$anch_ = array(120,40,60);
		$alin_ = array('L','C','C');
		$anch = array(220);
		$anch1 = array(220);

$c ='TOTALES';
$tperson=0;
$tmonto=0;

$pdf->cabecera($cabe3,$anch1);
$pdf->cabecera($cabe4,$anch1);
$pdf->cabecera($cabe1,$anch1);
$pdf->cabecera($cabe2,$anch1);
$pdf->cabecera1($cabecera_,$anch_);
$pdf->SetFont('Arial','',10);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);
$j=0;
for($i=0;$i<count($listarCertEmi);$i+=3) {
	$j++;
    $tperson=$tperson+$listarCertEmi[$i];
    $tmonto=$tmonto+$listarCertEmi[$i+1];
			$pdf->Row(array($listarCertEmi[$i+2]
			                ,$listarCertEmi[$i]
			                ,FormatoNum($listarCertEmi[$i+1])
			                ));

}
$pdf->Row(array($c
			                ,FormatoNum($tperson)
			                ,FormatoNum($tmonto)
			                ));
$pdf->ln();
//$pdf->Cell(48,5,$c,1,0,'R',0);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','',10);
$pdf->SetBorder(true);


    $pdf->ln();

     //$xtit = utf8_decode("Total: ".$j." Marcas");
     $pdf->Cell(90,5,$xtit,0,0,'L',0);

$pdf->Output();
?>