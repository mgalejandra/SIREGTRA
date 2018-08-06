<?php
require('../../modelos/conexion.php');
require ('../../controlador/funciones.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/envios.php');

$pdf=new PDF('p','mm','Letter');
$pdf->SetMargins(10,10,10,10);
//$titulo=utf8_decode('');
//$pdf->SetTitle($titulo);
$pdf->AddPage();
$nombre=$_POST['nombre'];
$cedula=$_POST['cedula'];
$dir=$_POST['dir'];
$dep=$_POST['departamento'];
$envio=$_POST['envio'];

//$envio='19';
$objEnvios= new envios();

$listarEnvios=$objEnvios->autorizacion($envio);

$fecha=date("d/m/Y");
$dia=date("d");
$mes=date("m");
$ano=date("Y");

$pdf->setY(40);
$pdf->SetFont('Arial','B',12);
//$pdf->cell(0,5,"Caracas, ".$dia." de ".ObtenerMesenLetras($mes)." del ".$ano.'-'.$listarEnvios[1],0,0,'R');
$pdf->cell(0,5,"Caracas, ".$dia." de ".ObtenerMesenLetras($mes)." del ".$ano,0,0,'R');
$pdf->setY(65);
$pdf->SetFont('Arial','',12);
$pdf->cell(0,5,utf8_decode("Señores: "),0,0,'L');
$pdf->setY(70);
$pdf->SetFont('Arial','B',12);
$pdf->cell(0,5,utf8_decode("INSTITUTO NACIONAL DE TRANSPORTE TERRESTRE "),0,0,'L');
$pdf->setY(85);
$pdf->SetFont('Arial','BIU',12);
$pdf->cell(0,5,utf8_decode("AUTORIZACIÓN"),0,0,'C');

$pdf->setXY(10,100);
$pdf->SetFont('Arial','',12);
$pdf->multicell(195,10,utf8_decode("Suministros Venezolanos Industriales C.A (SUVINCA), empresa debidamente registrada con el N# G20007984-3, mediante la presente autoriza  al ciudadano(a) ".$nombre.", Titular de la Cédula de Identidad N° ".$cedula.", para hacer entrega formal de dos (2) CD´S, contentivos de dos (2) informes que describen el detalle de los archivos de: vehículos importados, propietarios  y placas. Tal como se señala a continuación:"));

$y=$pdf->gety();

  $pdf->setXY(10,$y+5);
  $pdf->cell(0,5,utf8_decode("Detalle del envío:"),0,0,'L');
  $pdf->setXY(10,$y+15);
  $pdf->SetWidths(array(55,50,30,30,30));
  $pdf->SetAligns(array("L","L","C","C","C"));
  $pdf->SetBorder(1);
  $pdf->Row(array("Tipo de Archivo","Nombre del Archivo","Cantidad MA","Cantidad MM","Cantidad ME"));
  $pdf->ln();
  $ejecutar=@pg_query($conexion,$sql);
  $pdf->SetAligns(array("L","L","C","C","C"));
  $tipo='';
  //$listarEnvios
    for($i=0;$i<count($listarEnvios);$i+=8){

	 		$pdf->Row(array($listarEnvios[$i+6],$listarEnvios[$i+7]."-".str_pad($listarEnvios[$i],4,0,STR_PAD_LEFT).".txt",$listarEnvios[$i+3],$listarEnvios[$i+4],$listarEnvios[$i+5]));

			$numero=$listarEnvios[$i];

			$yy=$pdf->gety();
		}

$pdf->setXY(10,$y);
$pdf->cell(0,5,utf8_decode("Según Número de Envío: ".str_pad($numero,4,0,STR_PAD_LEFT)),0,0,'L');

$pdf->setXY(10,$yy+15);
$pdf->cell(0,5,utf8_decode("Sin más a que hacer referencia, me despido "),0,0,'C');



$pdf->setXY(10,$yy+45);
$pdf->cell(0,5,utf8_decode($dir),0,0,'C');
$pdf->line(50,$pdf->gety(),150,$pdf->gety());


$pdf->setXY(10,$yy+45);
$pdf->cell(0,15,utf8_decode("CORONEL"),0,0,'C');

$pdf->setXY(10,$yy+49);
$pdf->cell(0,15,utf8_decode($dep),0,0,'C');



$pdf->setXY(50,$yy+60);
$pdf->SetFont('Arial','',8);
$pdf->multicell(109,3,utf8_decode("Resolución DM N°3.096de fecha 05 de Octubre de 2017, publicado en Gaceta Oficial de la República Bolivariana de Venezuela N°41.251 de fecha 05 de Octubre de 2017"));
$pdf->addpage();

	$pdf->Rect(40,75,120,120);
	$pdf->Image('../imagenes/banner.jpg',41,76,118);
	$pdf->setXY(41,100);
    $pdf->cell(100,5,utf8_decode('Fecha: '.$fecha),0,0,'L');
	$pdf->setXY(41,105);
    $pdf->cell(100,5,utf8_decode('N# de Registro REFECIV: DCMD9093'),0,0,'L');
    $pdf->setXY(41,110);
    $pdf->cell(100,5,utf8_decode('Iniciales: S4'),0,0,'L');
    $pdf->setXY(41,115);
    $pdf->cell(100,5,utf8_decode('Número de Envío: '.str_pad($numero,4,0,STR_PAD_LEFT)),0,0,'L');

  $pdf->setXY(41,120);
  $pdf->cell(0,5,utf8_decode("Detalle del envío:"),0,0,'L');
  $pdf->setXY(41,130);
  $pdf->SetWidths(array(40,25,25,25));
  $pdf->SetAligns(array("L","C","C","C"));
  $pdf->SetBorder(1);
  $pdf->Row(array("Nombre del Archivo","MA","MM","ME"));
  $pdf->ln();
  $pdf->setX(41);
  $ejecutar=@pg_query($conexion,$sql);
  $pdf->SetAligns(array("L","C","C","C"));
  $tipo='';
		for($i=0;$i<count($listarEnvios);$i+=8){
             $pdf->setX(41);
	 		 $pdf->Row(array($listarEnvios[$i+7]."-".str_pad($listarEnvios[$i],4,0,STR_PAD_LEFT).".txt",$listarEnvios[$i+3],$listarEnvios[$i+4],$listarEnvios[$i+5]));
		}
   $pdf->SetFont('Arial','B',18);
  $pdf->setXY(10,215);
  $pdf->cell(0,5,utf8_decode("Imprimir 2 Copias y Adjuntar con los CD's "),0,0,'C');
$pdf->Output();
 @pg_close($conexion);
?>
