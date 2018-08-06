<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/mc_table1.php');
require('../../controlador/funciones.php');
require('../../modelos/reportes.php');
define('FPDF_FONTPATH', 'font/');

 $numlotveh = $_GET['lote'];

 $fecha=date('d/m/Y');

//$nroCampos = 2;

$objreportes = new reportes();

$diagnosticoCreditos=$objreportes->diagnosticoCreditos2($numlotveh);

// Encabezado del pdf
$pdf = new PDF_Mc_Table('L', 'mm','letter');
$pdf->AddPage();

$pdf->SetFont('Arial','B',14);
$pdf->SetXY(10,25);

$titulo1='Diagnostico Creditos';
$titulo2='Lapso: Enero al ';
$pdf->Ln();
$pdf->Cell(263,5,$titulo1,0,0,'C',0);
$pdf->Ln(5);
$pdf->SetFillColor(252,223,172);
$pdf->SetTextColor(0);

$pdf->SetFont('Arial','B',16);
$pdf->SetXY(180,25);

$pdf->Cell(255,5,$titulo2.' '.$fecha,0,0,'L');
$pdf->SetFont('Arial','B',11);
$pdf->Ln(9);
$pdf->SetFillColor(252,223,172);
$pdf->SetTextColor(0);

$pdf->SetWidths(array(54,40,83,63,24));
$pdf->SetAligns(array('C','C','C','C'));

$pdf->Row1(array(utf8_decode(""),utf8_decode("Carpetas Recibidas"),utf8_decode("Expedientes Procesados"),utf8_decode("Liquidación Créditos"),utf8_decode("") ));

$pdf->SetWidths(array(54,20,20,20,20,20,23,20,23,20,24));
$pdf->SetAligns(array('L','C','C','C','C','C','C','C','C','C','C'));

$pdf->Row1(array(utf8_decode("          Entidad Financiera           ")
,utf8_decode("Total Carpetas"),utf8_decode("Sin procesar"),utf8_decode("En Análisis"),utf8_decode("Créditos Negados")
,utf8_decode("Créditos Diferidos"),utf8_decode("Créditos Aprobados"),utf8_decode("Sin Ejecutar ")
,utf8_decode(" Liquidados"),utf8_decode("Por Liquidar "),utf8_decode("Vehículos Entregados")));

$acum1=0;
$acum2=0;
$acum3=0;
$acum4=0;
$acum5=0;
$acum6=0;
$acum7=0;
$acum8=0;
$acum9=0;
$j=0;


for($i=0;$i<count($diagnosticoCreditos);$i+=17) {
	$j++;
//$acum2+=$diagnosticoCreditos[$i+2];
$acum3+=$diagnosticoCreditos[$i+3];
$acum4+=$diagnosticoCreditos[$i+5];
$acum5+=$diagnosticoCreditos[$i+6]+($diagnosticoCreditos[$i+7]+$diagnosticoCreditos[$i+8]+$diagnosticoCreditos[$i+9]);
//este era el que tenia digna antes $acum6+=$diagnosticoCreditos[$i+16]+($diagnosticoCreditos[$i+10]+$diagnosticoCreditos[$i+11])+($diagnosticoCreditos[$i+12]+$diagnosticoCreditos[$i+13]+$diagnosticoCreditos[$i+14]+$diagnosticoCreditos[$i+15]);
//$acum6+=$diagnosticoCreditos[$i+4]+($diagnosticoCreditos[$i+10]+$diagnosticoCreditos[$i+11])+($diagnosticoCreditos[$i+12]+$diagnosticoCreditos[$i+13]+$diagnosticoCreditos[$i+14]);
$acum7+=$diagnosticoCreditos[$i+16];
$acum8+=$diagnosticoCreditos[$i+10]+$diagnosticoCreditos[$i+11];
$acum9+=($diagnosticoCreditos[$i+12]+$diagnosticoCreditos[$i+13]+$diagnosticoCreditos[$i+14]+$diagnosticoCreditos[$i+15]);
$acum10+=$diagnosticoCreditos[$i+10];

                                        if($diagnosticoCreditos[$i]=='0003') { $indu=642+$diagnosticoCreditos[$i+2]; $diagnosticoCreditos[$i+2]=$indu; }
                                        if($diagnosticoCreditos[$i]=='0102') { $vzla=1831+$diagnosticoCreditos[$i+2]; $diagnosticoCreditos[$i+2]=$vzla; }
                                        if($diagnosticoCreditos[$i]=='0149') { $puebl=172+$diagnosticoCreditos[$i+2]; $diagnosticoCreditos[$i+2]=$puebl; }
                                        if($diagnosticoCreditos[$i]=='0163') { $teso=3000+$diagnosticoCreditos[$i+2]; $diagnosticoCreditos[$i+2]=$teso; }
                                        if($diagnosticoCreditos[$i]=='0175') { $bice=2534+$diagnosticoCreditos[$i+2]; $diagnosticoCreditos[$i+2]=$bice; }
                                        if($diagnosticoCreditos[$i]=='0602') { $bandes=26+$diagnosticoCreditos[$i+2]; $diagnosticoCreditos[$i+2]=$bandes; }

$acum2=$indu+$vzla+$puebl+$teso+$bice+$bandes;


//Lo de los recibidos sin procesar
$col1=$diagnosticoCreditos[$i+3];
$col2=$diagnosticoCreditos[$i+5];
$col3=$diagnosticoCreditos[$i+6]+($diagnosticoCreditos[$i+7]+$diagnosticoCreditos[$i+8]+$diagnosticoCreditos[$i+9]);
//$col4=$diagnosticoCreditos[$i+16]+($diagnosticoCreditos[$i+10]+$diagnosticoCreditos[$i+11])+
 //                            ($diagnosticoCreditos[$i+12]+$diagnosticoCreditos[$i+13]+$diagnosticoCreditos[$i+14]+$diagnosticoCreditos[$i+15]);
$col5=$diagnosticoCreditos[$i+16];
$col6=$diagnosticoCreditos[$i+10]+$diagnosticoCreditos[$i+11];
$col7=($diagnosticoCreditos[$i+12]+$diagnosticoCreditos[$i+13]+$diagnosticoCreditos[$i+14]+$diagnosticoCreditos[$i+15]);
$col8=$diagnosticoCreditos[$i+10];

$col4=$col5+$col6+$col7;

$acum6=$acum7+$acum8+$acum9;

  if($diagnosticoCreditos[$i]=='0003') { $indu1=$indu-($col1+$col2+$col3+$col4); $sinproc=$indu1;}
  if($diagnosticoCreditos[$i]=='0102') { $vzla1=$vzla-($col1+$col2+$col3+$col4); $sinproc= $vzla1; }
  if($diagnosticoCreditos[$i]=='0149') { $puebl1=$puebl-($col1+$col2+$col3+$col4); $sinproc=$puebl1;}
  if($diagnosticoCreditos[$i]=='0163') { $teso1=$teso-($col1+$col2+$col3+$col4); $sinproc=$teso1;}
  if($diagnosticoCreditos[$i]=='0175') { $bice1=$bice-($col1+$col2+$col3+$col4); $sinproc=$bice1; }
  if($diagnosticoCreditos[$i]=='0602') { $bandes1=$bandes-($col1+$col2+$col3+$col4); $sinproc= $bandes1;}
  $acum22=$indu1+$vzla1+$puebl1+$teso1+$bice1+$bandes1;

//Hasta aqui



            $pdf->setjump(15);
            $pdf->SetFont('Arial','B',14);
            $pdf->SetFillColor(255,244,212);
			$pdf->Row(array("\n".$diagnosticoCreditos[$i+1]
			                ,"\n".$diagnosticoCreditos[$i+2]
			                ,"\n".$sinproc
			                ,"\n".$diagnosticoCreditos[$i+3]
			                ,"\n".$diagnosticoCreditos[$i+5]
			                ,"\n".($diagnosticoCreditos[$i+6]+($diagnosticoCreditos[$i+7]+$diagnosticoCreditos[$i+8]+$diagnosticoCreditos[$i+9]))
			                ,"\n".($diagnosticoCreditos[$i+16]+($diagnosticoCreditos[$i+10]+$diagnosticoCreditos[$i+11])+($diagnosticoCreditos[$i+12]+$diagnosticoCreditos[$i+13]+$diagnosticoCreditos[$i+14]+$diagnosticoCreditos[$i+15]))
			                ,"\n".$diagnosticoCreditos[$i+16]
			                ,"\n".($diagnosticoCreditos[$i+10]+$diagnosticoCreditos[$i+11])
			                ,"\n".($diagnosticoCreditos[$i+12]+$diagnosticoCreditos[$i+13]+$diagnosticoCreditos[$i+14]+$diagnosticoCreditos[$i+15])
			                ,"\n".$diagnosticoCreditos[$i+10]));
}

$pdf->SetWidths(array(54,20,20,20,20,20,23,20,23,20,24));
$pdf->SetAligns(array('C','C','C','C','C','C','C','C','C','C','C'));
$pdf->setjump(30);
$pdf->Row1(array(utf8_decode("Totales")
,FormatoMonto($acum2,0),FormatoMonto($acum22,0),FormatoMonto($acum3,0),FormatoMonto($acum4,0)
,FormatoMonto($acum5,0),FormatoMonto($acum6,0),FormatoMonto($acum7,0)
,FormatoMonto($acum8,0),FormatoMonto($acum9,0),FormatoMonto($acum10,0)));
$pdf->line(10,$pdf->gety(),274,$pdf->gety());
$pdf->ln();

$pdf->SetFillColor(252,223,172);
$pdf->SetTextColor(0);

$pdf->SetFont('Arial','B',13);
$pdf->SetXY(10,155);
$pdf->Cell(263,5,utf8_decode('Resumen'),1,0,'C',1);
//primera linea
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(10,162);
$pdf->MultiCell(35,5,utf8_decode('Solicitudes Recibidas'),1,0,'C');

$pdf->SetFont('Arial','',13);
$pdf->SetXY(45,162);
$pdf->Cell(20,10,FormatoMonto($acum2,0),1,0,'C');

$pdf->SetXY(65,162);
$pdf->Cell(20,10,'100%',1,0,'C');

$pdf->SetFont('Arial','B',13);
$pdf->SetXY(105,162);
$pdf->MultiCell(35,5,utf8_decode('Créditos Aprobados'),1,0,'J');

$pdf->SetFont('Arial','',13);
$pdf->SetXY(140,162);
$pdf->Cell(20,10,FormatoMonto($acum6,0),1,0,'C');

$pdf->SetXY(160,162);
$pdf->Cell(20,10,'100%',1,0,'C');

$pdf->SetFont('Arial','B',13);
$pdf->SetXY(200,162);
$pdf->MultiCell(35,5,utf8_decode('Creditos Liquidados'),1,0,'J');

$pdf->SetFont('Arial','',13);
$pdf->SetXY(235,162);
$pdf->Cell(19,10,FormatoMonto($acum8,0),1,0,'C');

$pdf->SetXY(254,162);
$pdf->Cell(19,10,'100%',1,0,'C');

//segunda linea
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(10,173);
$pdf->MultiCell(35,5,utf8_decode('Créditos Aprobados'),1,0,'C');

$pdf->SetFont('Arial','',13);
$pdf->SetXY(45,173);
$pdf->Cell(20,10,FormatoMonto($acum6,0),1,0,'C');

$pdf->SetXY(65,173);
$pdf->Cell(20,10,FormatoMonto(($acum6*100)/$acum2,2).'%',1,0,'C');

$pdf->SetFont('Arial','B',13);
$pdf->SetXY(105,173);
$pdf->MultiCell(35,5,utf8_decode('Créditos Liquidados'),1,0,'J');

$pdf->SetFont('Arial','',13);
$pdf->SetXY(140,173);
$pdf->Cell(20,10,FormatoMonto($acum8,0),1,0,'C');

$pdf->SetXY(160,173);
$pdf->Cell(20,10,FormatoMonto(($acum8*100)/$acum6,2).'%',1,0,'C');

$pdf->SetFont('Arial','B',13);
$pdf->SetXY(200,173);
$pdf->MultiCell(35,5,utf8_decode('Vehiculos Entregados'),1,0,'J');

$pdf->SetFont('Arial','',13);
$pdf->SetXY(235,173);
$pdf->Cell(19,10,FormatoMonto($acum10,0),1,0,'C');

$resta0=($acum10*100)/$acum8;
$pdf->SetXY(254,173);
$pdf->Cell(19,10,FormatoMonto($resta0,2).'%',1,0,'C');

//Tercera linea
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(10,184);
$pdf->MultiCell(35,10,utf8_decode('Diferencia'),1,0,'C');

$resta1=$acum2-$acum6;
$pdf->SetFont('Arial','',13);
$pdf->SetXY(45,184);
$pdf->Cell(20,10,FormatoMonto($resta1,0),1,0,'C');

$resta2=100-($acum6*100)/$acum2;
$pdf->SetXY(65,184);
$pdf->Cell(20,10,FormatoMonto($resta2,2).'%',1,0,'C');

$pdf->SetFont('Arial','B',13);
$pdf->SetXY(105,184);
$pdf->MultiCell(35,10,utf8_decode('Diferencia'),1,0,'J');

$pdf->SetFont('Arial','',13);
$pdf->SetXY(140,184);
$pdf->Cell(20,10,FormatoMonto($acum6-$acum8,0),1,0,'C');

$pdf->SetXY(160,184);
$pdf->Cell(20,10,FormatoMonto(100-($acum8*100)/$acum6,2).'%',1,0,'C');

$pdf->SetFont('Arial','B',13);
$pdf->SetXY(200,184);
$pdf->MultiCell(35,10,utf8_decode('Diferencia'),1,0,'J');

$resta5=$acum8-$acum10;
$pdf->SetFont('Arial','',13);
$pdf->SetXY(235,184);
$pdf->Cell(19,10,FormatoMonto($resta5,0),1,0,'C');

$resta6=(100-($acum10*100)/$acum8);
$pdf->SetXY(254,184);
$pdf->Cell(19,10,FormatoMonto($resta6,2).'%',1,0,'C');






   // $xtit = utf8_decode("Total: ".$j." bancos");
     //$pdf->Cell(90,5,$xtit,0,0,'L',0);
$pdf->Output();
?>