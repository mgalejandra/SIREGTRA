<?php
session_start();
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/inventario.php');
require('../../modelos/asignacion.php');
require('../../modelos/vehiculos.php');
require('../../modelos/entrega.php');

$numlotveh=$_GET['numlotveh'];

$objInventario = new inventario();
$objVehiculo = new vehiculos();
$objEntrega = new entrega();

$nro_colum = 12;
$nro_colum1 = 12;
$reporteMincoSuvinca=$objVehiculo->reporteMincoSuvinca($numlotveh);

$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle("Reporte Vehiculos Chery - Suvinca");
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$titulo1 = 'Reporte Vehiculos Chery - Suvinca';

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->SetXY(5,25);
$titulo2 = utf8_decode($titulo2);

$pdf->Cell(230,5,$titulo1,0,1,'C',0);
$pdf->Cell(265,5,$titulo2,0,1,'C',0);
$pdf->Ln();

$pdf->SetXY(10,35);
$cabecera_ = array('Lote','Modelo','Exist. Inicial','Entregados','Asignados','Asig/No PDI','PDI No Aprob.','Inventario','Veh.S/P','Veh.S/F','En Campo');
$anch_ = array(10,35,25,25,20,25,25,25,20,20,20);

$alin_ = array('C','C','C','C','C','C','C','C','C','C','C');
$pdf->SetFont('Arial','B',14);
$pdf->cabecera3($cabecera_,$anch_);
$pdf->SetFont('Arial','',10);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);

$j=0;
        $numlot='';
        $pri=true;
        $numcampo=13;
      	for($i=0;$i<count($reporteMincoSuvinca);$i+=$numcampo){
      		if($reporteMincoSuvinca){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
        	 $asignacion= ($reporteMincoSuvinca[$i+4]-$reporteMincoSuvinca[$i+7])+$reporteMincoSuvinca[$i+10]+$reporteMincoSuvinca[$i+11];

        	 $inventario=($reporteMincoSuvinca[$i+2]-$reporteMincoSuvinca[$i+3]-$asignacion-$reporteMincoSuvinca[$i+7])-($reporteMincoSuvinca[$i+5]-$reporteMincoSuvinca[$i+7]);

        	 $campo= $reporteMincoSuvinca[$i+2]-$reporteMincoSuvinca[$i+3];
        	 $totalExistencia+=$reporteMincoSuvinca[$i+2];
        	 $totalEntregados+=$reporteMincoSuvinca[$i+3];
        	 $totalAsignados+=$asignacion;
        	 $totalAsignadosNoPdi+=$reporteMincoSuvinca[$i+7];
        	 $totalSinPlacas+=$reporteMincoSuvinca[$i+8];
        	 $totalSinFact+=$reporteMincoSuvinca[$i+10];
        	 $totalNoPdi+=($reporteMincoSuvinca[$i+5]-$reporteMincoSuvinca[$i+7]);
        	 $totalInventario+=$inventario;
        	 $totalCampo+=$campo;
        	// echo 'lote:'.$numlot;
        	// echo 'loteBD:'.$reporteMincoSuvinca[$i];
$anch_ = array(10,35,25,25,20,25,25,25,20,20,20);

$alin_ = array('C','C','C','C','C','C','C','C','C','C','C');
$pdf->SetFont('Arial','',10);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);
  $pdf->setjump(7);
 							 $pdf->Row(array($reporteMincoSuvinca[$i]
						    				,$reporteMincoSuvinca[$i+1]
						    				,$reporteMincoSuvinca[$i+2]
						    				,$reporteMincoSuvinca[$i+3]
						    				,FormatoNum($asignacion)
						    				,$reporteMincoSuvinca[$i+7]
						    				,FormatoNum($reporteMincoSuvinca[$i+5]-$reporteMincoSuvinca[$i+7])
						    				,FormatoNum($inventario)
						    				,FormatoNum($reporteMincoSuvinca[$i+8])
						    				,FormatoNum($reporteMincoSuvinca[$i+10])
						    				,FormatoNum($campo)));


               if($pri) $numlot=$reporteMincoSuvinca[$i];else $numlot=$reporteMincoSuvinca[$i+$numcampo];
        	   $pri=false;

$anch_ = array(10,35,25,25,20,25,25,25,20,20,20);

$alin_ = array('C','C','C','C','C','C','C','C','C','C','C');
$pdf->SetFont('Arial','',10);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);


      	 if($numlot!=$reporteMincoSuvinca[$i]){  ;

$anch_ = array(45,25,25,20,25,25,25,20,20,20,20);
$alin_ = array('C','C','C','C','C','C','C','C','C','C');
$pdf->SetFont('Arial','B',12);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);
 $pdf->setjump(7);
      	 	 $pdf->Row(array('Total Lote: '.$reporteMincoSuvinca[$i]
      	 	 								,FormatoNum($totalExistencia)
						    				,FormatoNum($totalEntregados)
						    				,FormatoNum($totalAsignados)
						    				,FormatoNum($totalAsignadosNoPdi)
						    				,FormatoNum($totalNoPdi)
						    				,FormatoNum($totalInventario)
						    				,FormatoNum($totalSinPlacas)
						    				,FormatoNum($totalSinFact)
						    				,FormatoNum($totalCampo)));

$pdf->SetBorder(false);
					 $pdf->Row(array(''	,'','','','','','','','',''));

             $totalExistencia=0;
        	 $totalEntregados=0;
        	 $totalAsignados=0;
        	 $totalAsignadosNoPdi=0;
        	 $totalNoPdi=0;
        	 $totalInventario=0;
        	 $totalCampo=0;
        	 $totalSinPlacas=0;
        	 $totalSinFact=0;

   	 };//fin del print del total
$numlot=$reporteMincoSuvinca[$i];
      		}//fin de la condicion si hay datos
  }//fin for

$pdf->SetFont('Arial','B',8);

$pdf->Output();
?>