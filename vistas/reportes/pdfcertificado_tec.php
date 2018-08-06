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
$pdf->setX(20);
$pdf->Cell(100,6,'SUMINISTROS VENEZOLANOS INDUSTRIALES  C.A',0,0,"L");
$pdf->setX(113);
$pdf->Cell(20,6,'G-20007984-3',0,0,"L");
}// hasta aqui imprime si son importados
////////////////////////////////////DATOS DISTRIBUIDOR CONCESIONARIO
if ($listarcertificado[51] == 'C') {
$b=8;
$c=5;
$pdf->setY(165+$b);
$pdf->setX(15+$c);
$pdf->Cell(30,6,$listarcertificado[31],0,0,"L");


$pdf->setX(104+$c);
$pdf->Cell(200,6,$listarcertificado[32],0,0,"L");
$pdf->setX(143);
$pdf->Cell(200,6,$listarcertificado[33],0,0,"L");


$pdf->setY(174+$b);
$pdf->setX(15+$c);
$pdf->Cell(200,6,$listarcertificado[34],0,0,"L");

$pdf->setY(183+$b);
$pdf->setX(15+$c);
$pdf->Cell(200,6,$listarcertificado[35],0,0,"L");
$pdf->setX(105+$c);
$pdf->Cell(200,6,$listarcertificado[36],0,0,"L");
$pdf->setY(193+$b);
$pdf->setX(15+$c);
$pdf->Cell(200,6,$listarcertificado[37],0,0,"L");
$pdf->setX(143);
$pdf->Cell(200,6,$listarcertificado[38],0,0,"L");
$pdf->setY(203+$b);
//$pdf->setX(105+$c);
$pdf->setX(15+$c-1);
$pdf->Cell(200,6,$listarcertificado[39],0,0,"L");

$pdf->setY(211+$b);
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
$b=9;
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
$b=6;
$pdf->setY(232+$b);
$pdf->setX(15+$c);
$pdf->Cell(200,6,$listarcertificado[47],0,0,"L");
$pdf->setY(242+$b);
$pdf->setX(15+$c);
$pdf->Cell(200,6,$listarcertificado[48],0,0,"L");
$pdf->setY(236+$b-3);
$pdf->setX(108);
$pdf->MultiCell(80,6,$listarcertificado[49]);
}
$pdf->Output();

?>
