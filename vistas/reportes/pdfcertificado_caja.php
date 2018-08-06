<?php
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/certificado.php');
require('../../modelos/fpdf/fpdf.php');

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

$pdf=new FPDF('p', 'mm','Letter');

$pdf->AddPage();

//print '<pre>'; print $sql;
$pdf->SetFont('Arial','',10);
$a=11;
//$a=9;
if (!$reserva and !$seguro){

if ($buscarOrigen=='I'){

$pdf->setY(25+$a);
$pdf->setX(46);
$pdf->Cell(100,6,'SUMINISTROS VENEZOLANOS INDUSTRIALES  C.A',0,0,"L");
$pdf->setY(30+$a);//fecha
$pdf->setX(36);
$pdf->Cell(30,6,$listarcertificado[0],0,0,"L");
$pdf->setX(105);
$pdf->Cell(30,6,$listarcertificado[1]." / ".$listarcertificado[2],0,0,"L");
$pdf->setY(35+$a);//placa
$pdf->setX(26);
$pdf->Cell(30,6,$listarcertificado[3],0,0,"L");
$pdf->setX(60);
$pdf->Cell(30,6,$listarcertificado[4],0,0,"L");
$pdf->setX(140);
$pdf->Cell(30,6,$listarcertificado[5],0,0,"L");
$pdf->setY(41+$a);//año fabricacion
$pdf->setX(40);
$pdf->Cell(30,6,$listarcertificado[6],0,0,"L");
$pdf->setX(105);
$pdf->Cell(30,6,$listarcertificado[7],0,0,"L");
$pdf->setY(47+$a);//año modelo
$pdf->setX(33);
$pdf->Cell(30,6,$listarcertificado[8],0,0,"L");
$pdf->setX(105);
$pdf->Cell(30,6,$listarcertificado[9],0,0,"L");
$pdf->setY(52+$a);//serial motor
$pdf->setX(30);
$pdf->Cell(30,6,$listarcertificado[10],0,0,"L");
$pdf->setX(105);
$pdf->Cell(30,6,$listarcertificado[11],0,0,"L");
$pdf->setY(57+$a);//clase
$pdf->setX(25);
$pdf->Cell(30,6,$listarcertificado[12],0,0,"L");
$pdf->setX(88);
$pdf->Cell(30,6,$listarcertificado[13],0,0,"L");
$pdf->setX(145);
$pdf->Cell(30,6,$listarcertificado[14],0,0,"L");
$pdf->setY(63+$a);//servicio
$pdf->setX(27);
$pdf->Cell(30,6,$listarcertificado[15],0,0,"L");
$pdf->setX(103);
$pdf->Cell(30,6,$listarcertificado[16],0,0,"L");
$pdf->setX(145+1);
$pdf->Cell(30,6,$listarcertificado[17],0,0,"L");
$pdf->setY(69+$a);//peso
$pdf->setX(35);
$pdf->Cell(30,6,$listarcertificado[18],0,0,"L");
$pdf->setX(75);
$pdf->Cell(30,6,$listarcertificado[19],0,0,"L");
$pdf->setX(110);
$pdf->Cell(30,6,$listarcertificado[20],0,0,"L");
$pdf->setX(165);
$pdf->Cell(30,6,$listarcertificado[21],0,0,"L");
$pdf->setY(74+$a);//pto
$pdf->setX(37);
$pdf->Cell(30,6,$listarcertificado[22],0,0,"L");
$pdf->setX(120);
$pdf->Cell(30,6,$listarcertificado[23]." / ".$listarcertificado[24],0,0,"L");
$pdf->setY(80+$a);
$pdf->setX(60);
$pdf->Cell(30,6,$listarcertificado[25]." / ".$listarcertificado[26],0,0,"L");
$pdf->setX(140);
$pdf->Cell(30,6,$listarcertificado[27],0,0,"L");
$pdf->setY(88+$a);
$pdf->setX(50);
$pdf->Cell(30,6,$listarcertificado[28]."  ".$listarcertificado[29],0,0,"L");
$pdf->setX(145);
$pdf->Cell(30,6,$listarcertificado[30],0,0,"L");

//$b=11;
//$b=7;
$b=9;
$pdf->setY(147+$b);
$pdf->setX(18);

if(strlen($listarcertificado[34])>42) $nombreC = substr($listarcertificado[34],0,42);
else $nombreC =$listarcertificado[34];


$pdf->Cell(100,6,$nombreC,0,0,"L");
$pdf->setX(115);
$pdf->Cell(20,6,$listarcertificado[31],0,0,"L");
}// hasta aqui imprime si son importados
}
$pdf->Output();

?>