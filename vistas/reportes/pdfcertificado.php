<?php
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/certificado.php');
require('../../modelos/fpdf/fpdf.php');
require('../../modelos/zona.php');

$objCertificado = new certificado();
$numcerveh=$_GET['numcerveh'];
$reserva=$_GET['reserva'];
$seguro=$_GET['seguro'];

if ($_GET['reserva']) $numcerveh=$_GET['reserva'];
if ($_GET['seguro']) $numcerveh=$_GET['seguro'];

$buscarOrigen=$objCertificado->buscarOrigen($numcerveh);

if ($buscarOrigen=='I')
$listarcertificado=$objCertificado->reporteCertificadoImp($numcerveh);
else
$listarcertificado=$objCertificado->reporteCertificadoNac($numcerveh);

$objZona= new zona();
$buscarEstados = $objZona->buscarEstados($listarcertificado[52]);
$buscarMunicipio = $objZona->buscarMunicipios($listarcertificado[53],$listarcertificado[52]);
$buscarParroquia = $objZona->buscarParroquias($listarcertificado[54],$listarcertificado[52],$listarcertificado[53]);

$pdf=new FPDF('p', 'mm','Letter');

$pdf->AddPage();

//print '<pre>'; print $sql;
$pdf->SetFont('Arial','',10);
$a=12;
if (!$reserva and !$seguro){

if ($buscarOrigen=='I'){

$pdf->setY(25+$a);
$pdf->setX(48);
$pdf->Cell(100,6,'SUMINISTROS VENEZOLANOS INDUSTRIALES  C.A',0,0,"L");
$pdf->setY(30.5+$a);//fecha
$pdf->setX(38);
$pdf->Cell(30,6,$listarcertificado[0],0,0,"L");
$pdf->setX(105);
$pdf->Cell(30,6,$listarcertificado[1]." / ".$listarcertificado[2],0,0,"L");
$pdf->setY(36+$a);//placa
$pdf->setX(27);
$pdf->Cell(30,6,$listarcertificado[3],0,0,"L");
$pdf->setX(62);
$pdf->Cell(30,6,$listarcertificado[4],0,0,"L");
$pdf->setX(140);
$pdf->Cell(30,6,$listarcertificado[5],0,0,"L");
$pdf->setY(41+$a);//año fabricacion
$pdf->setX(43);
$pdf->Cell(30,6,$listarcertificado[6],0,0,"L");
$pdf->setX(105);
$pdf->Cell(30,6,$listarcertificado[7],0,0,"L");
$pdf->setY(47.5+$a);//año modelo
$pdf->setX(35);
$pdf->Cell(30,6,$listarcertificado[8],0,0,"L");
$pdf->setX(105);
$pdf->Cell(30,6,$listarcertificado[9],0,0,"L");
$pdf->setY(53+$a);//serial motor
$pdf->setX(33);
$pdf->Cell(30,6,$listarcertificado[10],0,0,"L");
$pdf->setX(109);
$pdf->Cell(30,6,$listarcertificado[11],0,0,"L");
$pdf->setY(58.5+$a);//clase
$pdf->setX(26);
$pdf->Cell(30,6,$listarcertificado[12],0,0,"L");
$pdf->setX(89);
$pdf->Cell(30,6,$listarcertificado[13],0,0,"L");
$pdf->setX(146);
$pdf->Cell(30,6,$listarcertificado[14],0,0,"L");
$pdf->setY(64.5+$a);//servicio
$pdf->setX(28);
$pdf->Cell(30,6,$listarcertificado[15],0,0,"L");
$pdf->setX(104);
$pdf->Cell(30,6,$listarcertificado[16],0,0,"L");
$pdf->setX(145+2);
$pdf->Cell(30,6,$listarcertificado[17],0,0,"L");
$pdf->setY(70+$a);//peso
$pdf->setX(36);
$pdf->Cell(30,6,$listarcertificado[18],0,0,"L");
$pdf->setX(75);
$pdf->Cell(30,6,$listarcertificado[19],0,0,"L");
$pdf->setX(110);
$pdf->Cell(30,6,$listarcertificado[20],0,0,"L");
$pdf->setX(165);
$pdf->Cell(30,6,$listarcertificado[21],0,0,"L");
$pdf->setY(75.5+$a);//pto
$pdf->setX(41);
$pdf->Cell(30,6,$listarcertificado[22],0,0,"L");
$pdf->setX(121);
$pdf->Cell(30,6,$listarcertificado[23]." / ".$listarcertificado[24],0,0,"L");
$pdf->setY(81+$a);
$pdf->setX(60);
$pdf->Cell(30,6,$listarcertificado[25]." / ".$listarcertificado[26],0,0,"L");
$pdf->setX(142);
$pdf->Cell(30,6,$listarcertificado[27],0,0,"L");
$pdf->setY(86+$a);
$pdf->setX(51);
$pdf->Cell(30,6,$listarcertificado[28]."  ".$listarcertificado[29],0,0,"L");
$pdf->setX(146);
$pdf->Cell(30,6,$listarcertificado[30],0,0,"L");

$b=10;
$pdf->setY(147+$b);
$pdf->setX(21);
$pdf->Cell(100,6,'SUMINISTROS VENEZOLANOS INDUSTRIALES  C.A',0,0,"L");
$pdf->setX(113);
$pdf->Cell(20,6,'G-20007984-3',0,0,"L");
}// hasta aqui imprime si son importados
////////////////////////////////////DATOS DISTRIBUIDOR CONCESIONARIO
if ($listarcertificado[51] == 'C') {
//$b=7;
$b=8;
$c=5;
$pdf->setY(165+$b);
$pdf->setX(15+$c);//cedula
$pdf->Cell(30,6,$listarcertificado[31],0,0,"L");


$pdf->setX(105+$c);//factura3
$pdf->Cell(200,6,$listarcertificado[32],0,0,"L");
$pdf->setX(147);//fecha factura 3
$pdf->Cell(200,6,$listarcertificado[33],0,0,"L");


$pdf->setY(175+$b);//nombre
$pdf->setX(15+$c);
$pdf->Cell(200,6,$listarcertificado[34],0,0,"L");

$pdf->setY(185+$b);//casa
$pdf->setX(15+$c);
$pdf->Cell(200,6,$listarcertificado[35],0,0,"L");
$pdf->setX(105+$c);
$pdf->Cell(200,6,$listarcertificado[36],0,0,"L");
$pdf->setY(194+$b);//urb
$pdf->setX(15+$c);
$pdf->Cell(200,6,$listarcertificado[37],0,0,"L");
$pdf->setX(143);
$pdf->Cell(200,6,$buscarEstados[1],0,0,"L");
$pdf->setY(203+$b);
//$pdf->setX(105+$c);
$pdf->setX(15+$c-1);
//.$buscarEstados[1].'-'.$buscarMunicipio[1].'-'.$buscarParroquia[1]
$pdf->Cell(200,6,$buscarMunicipio[1].' / '.$buscarParroquia[1],0,0,"L");

$pdf->setY(213+$b);
$pdf->setX(15+$c);
$pdf->Cell(200,6,$listarcertificado[40],0,0,"L");
$pdf->setX(53);
$pdf->Cell(200,6,$listarcertificado[41],0,0,"L");
$pdf->setX(105+$c);
$pdf->Cell(200,6,$listarcertificado[42],0,0,"L");
$pdf->setX(143);
$pdf->Cell(200,6,$listarcertificado[43],0,0,"L");
}//fin de si no son completos
}//fin de la condicion del seguro/reserva
//////////////////////////////////////////DATOS DEL SEGURO
$b=11.5;
$c=5;
if (!$reserva){
$pdf->setY(220+$b);
$pdf->setX(15+$c);
$pdf->Cell(200,6,$listarcertificado[44],0,0,"L");
$pdf->setX(105+$c);
$pdf->Cell(200,6,$listarcertificado[45],0,0,"L");
$pdf->setX(155+$c);
if ($listarcertificado[46]!='01/01/1999')
$pdf->Cell(200,6,$listarcertificado[46],0,0,"L");
}
//////////////////////////////////////////DATOS DEL Reserva

if (!$seguro){
$b=8;
$pdf->setY(232+$b);
$pdf->setX(15+$c);
$pdf->Cell(200,6,$listarcertificado[47],0,0,"L");
$pdf->setY(241+$b);
$pdf->setX(15+$c);
$pdf->Cell(200,6,$listarcertificado[48],0,0,"L");
$pdf->setY(231+$b-3);
$pdf->setX(108);
$pdf->MultiCell(80,6,$listarcertificado[49]);
}
$pdf->Output();
?>