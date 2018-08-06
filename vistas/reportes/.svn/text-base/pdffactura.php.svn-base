<?php
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/factura.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/zona.php');

$objFactura = new factura();

$factura=$_GET['idfactura'];

$listarFactura=$objFactura->reporteFactura($factura);

if ($listarFactura)
$detalleVehiculo=$objFactura->detalleVehiculo($listarFactura[9]);

$objZona= new zona();
$buscarEstados = $objZona->buscarEstados($listarFactura[25]);
$buscarMunicipio = $objZona->buscarMunicipios($listarFactura[26],$listarFactura[25]);
$buscarParroquia = $objZona->buscarParroquias($listarFactura[27],$listarFactura[25],$listarFactura[26]);

$pdf=new PDF('p', 'mm','Letter');
$pdf->SetMargins(10,10,10,10);
//$titulo=utf8_decode('');
//$pdf->SetTitle($titulo);
$pdf->AddPage();


$pdf->SetFont('Arial','B',8);
$pdf->setXY(155,30);
$pdf->Cell(50,5,"NUMERO",1,0,'C');
$pdf->setXY(155,35);
$pdf->SetFont('Arial','',8);
$pdf->Cell(50,5,str_pad($listarFactura[0],5,'0',STR_PAD_LEFT),1,0,'C');

$pdf->setY(40);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,5,"FACTURA PROFORMA",0,0,'C');

$pdf->SetFont('Arial','B',8);
$pdf->setXY(135,45);
$pdf->Cell(40,5,"FECHA DE EMISION",1,0,'C');
$pdf->Cell(10,5,"DIA",1,0,'C');
$pdf->Cell(10,5,"MES",1,0,'C');
$pdf->Cell(10,5,utf8_decode("AÑO"),1,0,'C');
$pdf->setXY(135,50);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,5,"CARACAS",1,0,'C');
$pdf->Cell(10,5,$listarFactura[2],1,0,'C');
$pdf->Cell(10,5,$listarFactura[3],1,0,'C');
$pdf->Cell(10,5,$listarFactura[4],1,0,'C');
$pdf->SetFont('Arial','B',8);
if(($listarFactura[5]=='CREDITO') OR ($listarFactura[5]=='COMPLETO') ){
$pdf->setY(55);
$pdf->Cell(15,5,"BANCO:",1,0,'C');
$pdf->Cell(100,5,$listarFactura[23],1,0,'L');
}
$pdf->setXY(135,55);
$pdf->Cell(40,5,"FECHA DE VENCIMIENTO",1,0,'C');
$vencimiento=suma_fechas($listarFactura[1],30);
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
$pdf->Cell(100,5,utf8_decode($listarFactura[12]),1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,"C.I./R.I.F :",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,5,$listarFactura[13],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->ln();
$pdf->Cell(195,5,"DOMICILIO FISCAL",1,0,'C');
$pdf->ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,5,"CALLE:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(45,5,$listarFactura[14],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,5,"URB/BARRIO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(45,5,$listarFactura[15],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,5,"EDIFICIO/CASA:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(35,5,$listarFactura[16],1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,5,"PISO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(45,5,$listarFactura[17],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,5,utf8_decode("N° APARTAMENTO:"),1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(45,5,$listarFactura[18],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,5,"MUNICIPIO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(35,5,$listarFactura[19],1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,5,"TLF:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(75,5,$listarFactura[21].' '.$listarFactura[22],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(45,5,"CONDICION DE PAGO:",1,0,'R');
$pdf->SetFont('Arial','',8);

if ($listarFactura[5]=='COMPLETO')
	$condicion= "100% CREDITO" ;
else
	$condicion= $listarFactura[5];
$pdf->Cell(60,5,$condicion,1,0,'C');
$pdf->ln(10);
//$pdf->Cell(60,5,"aqui ".$pdf->gety(),1,0,'L');
//DETALLE  DE LA FACTURA
  $pdf->Rect(10,95,195,112,'');
  $pdf->line(30,95,30,207);
  $pdf->line(125,95,125,207);
  $pdf->line(165,95,165,207);

  $pdf->SetFont('Arial','B',8);
  $pdf->SetWidths(array(20,95,40,40));
  $pdf->SetAligns(array("C","C","C","C","C"));
  $pdf->SetBorder(1);
  $pdf->Row(array("CANT.","DESCRIPCION","PRECIO UNITARIO","TOTAL"));
  $pdf->SetBorder(0);
  $pdf->SetAligns(array("C","L","R","R"));
  $pdf->SetFont('Arial','',8);
  $pdf->Row(array("1","VEHICULO",FormatoMonto($listarFactura[7]),FormatoMonto($listarFactura[7])));
  $pdf->SetWidths(array(20,5,42,38,40,40));
  $pdf->SetAligns(array("C","R","L","L","R","R"));
  $sig=' ';
  $pdf->Row(array("",$sig,"N CERTIFICADO DE ORIGEN:",$detalleVehiculo[0],'',''));
  $pdf->Row(array("",$sig,"PLACA:",$detalleVehiculo[1],'',''));
  $pdf->Row(array("",$sig,"SERIAL DE CARROCERIA:",$detalleVehiculo[2],'',''));
  $pdf->Row(array("",$sig,"SERIAL DE NIV:",$detalleVehiculo[3],'',''));
  $pdf->Row(array("",$sig,"SERIAL DE CHASIS:",$detalleVehiculo[4],'',''));
  $pdf->Row(array("",$sig,"SERIAL DE CARROZADO:",'','',''));
  $pdf->Row(array("",$sig,"MARCA:",$detalleVehiculo[5],'',''));
  $pdf->Row(array("",$sig,"MODELO:",$detalleVehiculo[6],'',''));
  $pdf->Row(array("",$sig,"SERIE/VERSION:",$detalleVehiculo[7],'',''));
  $pdf->Row(array("",$sig,utf8_decode("AÑO DE FABRICACION:"),$detalleVehiculo[8],'',''));
  $pdf->Row(array("",$sig,utf8_decode("AÑO DE MODELO:"),$detalleVehiculo[9],'',''));
  $pdf->Row(array("",$sig,"SERIAL DE MOTOR:",$detalleVehiculo[10],'',''));
  $pdf->Row(array("",$sig,"TIPO DE COMBUSTIBLE:",$detalleVehiculo[11],'',''));
  $pdf->Row(array("",$sig,"CODIGO GNV:",'','',''));
  $pdf->Row(array("",$sig,"COLOR(ES):",$detalleVehiculo[12].' '.$detalleVehiculo[13],'',''));
  $pdf->Row(array("",$sig,"CLASE:",$detalleVehiculo[14],'',''));
  $pdf->Row(array("",$sig,"TIPO:",$detalleVehiculo[15],'',''));
  $pdf->Row(array("",$sig,"USO:",$detalleVehiculo[16],'',''));
  //$pdf->Row(array("",$sig,"SERVICIO:",$row['servicio'],'',''));
  $pdf->Row(array("",$sig,utf8_decode("N° DE PUESTOS:"),$detalleVehiculo[17],'',''));
  $pdf->Row(array("",$sig,utf8_decode("N° DE EJES:"),$detalleVehiculo[18],'',''));
  $pdf->Row(array("",$sig,"PESO (TARA):",$detalleVehiculo[19],'',''));
  $pdf->Row(array("",$sig,"CAPACIDAD DE CARGA:",$detalleVehiculo[20],'',''));
  $pdf->Row(array("",$sig,"CGARANTIA (TIEMPO/KM RECORRIDOS):",'','',''));
  $pdf->SetWidths(array(20,95,40,40));
  $pdf->SetAligns(array("C","R","R","R"));
  $pdf->Row(array("","PLACAS( E )",FormatoMonto($listarFactura[6]),FormatoMonto($listarFactura[6])));
  $pdf->SetAligns(array("C","R","R","R"));
  $pdf->SetFont('Arial','B',8);
  $subtotal=$listarFactura[7]+$listarFactura[6];
  $pdf->Row(array("","","SUB TOTAL",FormatoMonto($subtotal)));
  $pdf->Row(array("","","MONTO EXENTO",FormatoMonto($listarFactura[6])));
  $pdf->Row(array("","","MONTO GRAVADO",FormatoMonto($listarFactura[7])));
  $iva=$listarFactura[7]*$listarFactura[8]/100;
  $pdf->Row(array("","","IVA".$listarFactura[8].'%',FormatoMonto($iva)));
  $total=$listarFactura[7]+$iva+$listarFactura[6];
  $pdf->Row(array("","","TOTAL",FormatoMonto($total)));
  $pdf->ln(15);
  $pdf->line(60,$pdf->gety(),155,$pdf->gety());
  $pdf->Cell(0,5,"RECIBE CONFORME",0,0,'C');




$pdf->Output();
 @pg_close($conexion);
?>
