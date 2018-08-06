<?php
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/factura.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/inventario.php');
require('../../modelos/beneficiario.php');

$objFactura = new factura();
$objInv     = new inventario();
$objBenef= new beneficiario();

$listarFactura=$_SESSION['listarFactura'];

$pdf=new PDF('p', 'mm','Letter');
$pdf->SetMargins(10,10,10,10);
//$titulo=utf8_decode('');
//$pdf->SetTitle($titulo);

$contar = count($listarFactura)/38;
for ($i=0;$i<$contar;$i++)
{
	$j = $i*38;

/*echo "id_numfac: ".$listarFactura[$j];
echo "\nid_asignacion: ".$listarFactura[$j+1];
echo "\nsercarveh: ".$listarFactura[$j+2];
echo "\nexento: ".$listarFactura[$j+3];
echo "\nfecha: ".$listarFactura[$j+4];
echo "\niva: ".$listarFactura[$j+5];
echo "\ncondpago: ".$listarFactura[$j+6];
echo "\nestatus: ".$listarFactura[$j+7];
echo "\ncodpro: ".$listarFactura[$j+8];
echo "\nnomcomp: ".$listarFactura[$j+9];
echo "\nid_estatus: ".$listarFactura[$j+10];
echo "\nusuario_estatus: ".$listarFactura[$j+11];
echo "\nfecha_estatus: ".$listarFactura[$j+12];
echo "\nfecha: ".$listarFactura[$j+13];
echo "\nid_banco: ".$listarFactura[$j+14];
echo "\n id_concesionario: ".$listarFactura[$j+15];
echo "\n banco_descrip: ".$listarFactura[$j+16];
echo "\n descripcion: ".$listarFactura[$j+17];
echo "\n nomest: ".$listarFactura[$j+18];
echo "\n dessexo: ".$listarFactura[$j+19];
echo "\n edad: ".$listarFactura[$j+20];
echo "\n fecven: ".$listarFactura[$j+21];
echo "\n diastrans: ".$listarFactura[$j+22];
echo "\n diasrestantes: ".$listarFactura[$j+23];
echo "\n fecha_estatus: ".$listarFactura[$j+24];
echo "\n tipo_benef: ".$listarFactura[$j+25];
echo "\n montosol: ".$listarFactura[$j+26];
echo "\n monto: ".$listarFactura[$j+27];
echo "\n plazo: ".$listarFactura[$j+28];
echo "\n tasa: ".$listarFactura[$j+29];
echo "\n tipagomens: ".$listarFactura[$j+30];
echo "\n tipagoanual: ".$listarFactura[$j+31];
echo "\n gastos: ".$listarFactura[$j+32];
echo "\n gastosadmin: ".$listarFactura[$j+33];
echo "\n gastostimbre: ".$listarFactura[$j+34];
echo "\n exonerado: ".$listarFactura[$j+35];
echo "\n id_preinv: ".$listarFactura[$j+37];*/


$pdf->AddPage();
$datosVeh = $objInv->listarPreInventario($listarFactura[$j+37],'','','',-1);
$dirBenef = $objBenef->listarBeneficiario($listarFactura[$j+8],'','','','');


$pdf->SetFont('Arial','B',8);
$pdf->setXY(155,30);
$pdf->Cell(50,5,"NUMERO",1,0,'C');
$pdf->setXY(155,35);
$pdf->SetFont('Arial','',8);
$pdf->Cell(50,5,str_pad($listarFactura[$j],5,'0',STR_PAD_LEFT),1,0,'C');

$pdf->setY(40);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,5,"FACTURA PRE-PROFORMA",0,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->setXY(135,45);
$pdf->Cell(40,5,"FECHA DE EMISION",1,0,'C');
$pdf->Cell(10,5,"DIA",1,0,'C');
$pdf->Cell(10,5,"MES",1,0,'C');
$pdf->Cell(10,5,utf8_decode("AÑO"),1,0,'C');
$pdf->setXY(135,50);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,5,"CARACAS",1,0,'C');
$fecha=$listarFactura[$j+4];
$diaf=substr($fecha,0,2);
$mesf=substr($fecha,3,2);
$anof=substr($fecha,6,4);
$pdf->Cell(10,5,$diaf,1,0,'C');
$pdf->Cell(10,5,$mesf,1,0,'C');
$pdf->Cell(10,5,$anof,1,0,'C');
$pdf->SetFont('Arial','B',8);
if($listarFactura[$j+6]=='CREDITO'){
$pdf->setY(55);
$pdf->Cell(15,5,"BANCO:",1,0,'C');
$pdf->Cell(100,5,$listarFactura[$j+16],1,0,'L');
}
$pdf->setXY(135,55);
$pdf->Cell(40,5,"FECHA DE VENCIMIENTO",1,0,'C');
$vencimiento=$listarFactura[$j+21];
$dia=substr($vencimiento,0,2);
$mes=substr($vencimiento,3,2);
$ano=substr($vencimiento,6,4);
$pdf->Cell(10,5,$dia,1,0,'C');
$pdf->Cell(10,5,$mes,1,0,'C');
$pdf->Cell(10,5,$ano,1,0,'C');

$pdf->setXY(10,65);


$pdf->SetFont('Arial','B',8);
$pdf->Cell(45,5,"NOMBRE O RAZON SOCIAL:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(100,5,$listarFactura[$j+9],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,"C.I./R.I.F :",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,5,$listarFactura[$j+8],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->ln();
$pdf->Cell(195,5,"DOMICILIO FISCAL",1,0,'C');
$pdf->ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,5,"CALLE:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(45,5,$dirBenef[7],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,5,"URB/BARRIO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(45,5,$dirBenef[8],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,5,"EDIFICIO/CASA:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(35,5,$dirBenef[9],1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,5,"PISO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(45,5,$dirBenef[10],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,5,utf8_decode("N° APARTAMENTO:"),1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(45,5,$dirBenef[11],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,5,"MUNICIPIO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(35,5,$dirBenef[12],1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,5,"TLF:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(75,5,$dirBenef[22].''.$dirBenef[23].' '.$dirBenef[24].''.$dirBenef[25],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(45,5,"CONDICION DE PAGO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(60,5,$listarFactura[$j+6],1,0,'C');
$pdf->ln(10);

//DETALLE  DE LA FACTURA
  $pdf->Rect(10,95,195,55,'');
  $pdf->line(30,95,30,150);
  $pdf->line(125,95,125,150);
  $pdf->line(165,95,165,150);

  $pdf->SetFont('Arial','B',8);
  $pdf->SetWidths(array(20,95,40,40));
  $pdf->SetAligns(array("C","C","C","C","C"));
  $pdf->SetBorder(1);
  $pdf->Row(array("CANT.","DESCRIPCION","PRECIO MINIMO","PRECIO MAXIMO"));
  $pdf->SetBorder(0);
  $pdf->SetAligns(array("C","L","R","R"));
  $pdf->SetFont('Arial','',8);
  $pdf->Row(array("1","VEHICULO",FormatoMonto($datosVeh[5]),FormatoMonto($datosVeh[6])));
  $pdf->SetWidths(array(20,5,42,38,40,40));
  $pdf->SetAligns(array("C","R","L","L","R","R"));
  $sig=' ';
  $pdf->Row(array("",$sig,"MARCA:",$datosVeh[1],'',''));
  $pdf->Row(array("",$sig,"MODELO:",$datosVeh[2],'',''));
  $pdf->Row(array("",$sig,"SERIE/VERSION:",$datosVeh[7],'',''));

  $pdf->ln(60);
  $pdf->line(60,$pdf->gety(),155,$pdf->gety());
  $pdf->Cell(0,5,"RECIBE CONFORME",0,0,'C');

}


$pdf->Output();
 @pg_close($conexion);
?>