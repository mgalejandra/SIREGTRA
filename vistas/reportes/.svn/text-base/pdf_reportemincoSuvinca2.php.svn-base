<?php
session_start();
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/vehiculos.php');

$objVehiculo = new vehiculos();

$nro_colum = 11;
$nro_colum1 = 11;
$reporteMincoSuvinca=$objVehiculo->reporteMincoSuvinca2();

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

$cabecera_ = array('Modelo','Exist. In','Entregados','Asignados','Comprom.','Disp.','Asig. Neg','No PDI','Inventario','Veh.S/P','Veh.S/P/Neg','Veh.S/F');
$anch_ = array(35,20,20,20,20,20,20,20,20,20,20,20);

$alin_ = array('C','C','C','C','C','C','C','C','C','C','C','C');
$pdf->SetFont('Arial','B',14);
$pdf->cabecera3($cabecera_,$anch_);
$pdf->SetFont('Arial','',10);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);

$j=0;
        $numlot='';
        $pri=true;
        $numcampo=11;
      	for($i=0;$i<count($reporteMincoSuvinca);$i+=$numcampo){
      		if($reporteMincoSuvinca){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;


        	 $asignacion= ($reporteMincoSuvinca[$i+3]-$reporteMincoSuvinca[$i+6])+$reporteMincoSuvinca[$i+9]+$reporteMincoSuvinca[$i+10];

        	 $inventario=$reporteMincoSuvinca[$i+1]-$reporteMincoSuvinca[$i+2]-
        	             $asignacion-$reporteMincoSuvinca[$i+6]-($reporteMincoSuvinca[$i+4]-$reporteMincoSuvinca[$i+6]);

             $nopdi = $reporteMincoSuvinca[$i+4]-$reporteMincoSuvinca[$i+6];
        	 $campo = $reporteMincoSuvinca[$i+1]-$reporteMincoSuvinca[$i+2]-$asignacion-$reporteMincoSuvinca[$i+10];
			 $totalExistencia+=$reporteMincoSuvinca[$i+1];
			 $totalEntregados+=$reporteMincoSuvinca[$i+2];
			 $totalAsignados+=$asignacion;
			 $totalComprometidos+=$reporteMincoSuvinca[$i+10];
			 $totalAsignadosNoPdi+=$reporteMincoSuvinca[$i+6];
			 $totalNoPdi+=$nopdi;
			 $totalInventario+=$inventario;
			 $totalSinPlacas+=$reporteMincoSuvinca[$i+7];
			 $totalSinPlacasNOPDI+=$reporteMincoSuvinca[$i+8];
			 $totalSinFact+=$reporteMincoSuvinca[$i+9];
        	 $totalCampo+=$campo;

$anch_ = array(35,20,20,20,20,20,20,20,20,20,20,20);

$alin_ = array('C','C','C','C','C','C','C','C','C','C','C','C');
$pdf->SetFont('Arial','',10);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);
  $pdf->setjump(7);
 							 $pdf->Row(array($reporteMincoSuvinca[$i]
						    				,FormatoMonto($reporteMincoSuvinca[$i+1],0)
						    				,FormatoMonto($reporteMincoSuvinca[$i+2],0)
						    				,FormatoMonto($asignacion,0)
						    				,FormatoMonto($reporteMincoSuvinca[$i+10],0)
						    				,FormatoMonto($campo,0)
						    				,FormatoMonto($reporteMincoSuvinca[$i+6],0)
						    				,FormatoMonto($nopdi,0)
						    				,FormatoMonto($inventario,0)
						    				,FormatoMonto($reporteMincoSuvinca[$i+7],0)
						    				,FormatoMonto($reporteMincoSuvinca[$i+8],0)
						    				,FormatoMonto($reporteMincoSuvinca[$i+9],0)
						    				));
   	 }//fin del print del total

  }//fin for

$anch_ = array(35,20,20,20,20,20,20,20,20,20,20,20);
$alin_ = array('C','C','C','C','C','C','C','C','C','C','C','C');
$pdf->SetFont('Arial','',10);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);
 $pdf->setjump(7);
      	 	 $pdf->Row(array('Total Vehiculos: '.$reporteMincoSuvinca[$i]
      	 	 								,FormatoMonto($totalExistencia,0)
						    				,FormatoMonto($totalEntregados,0)
						    				,FormatoMonto($totalAsignados,0)
						    				,FormatoMonto($totalComprometidos,0)
						    				,FormatoMonto($totalCampo,0)
						    				,FormatoMonto($totalAsignadosNoPdi,0)
						    				,FormatoMonto($totalNoPdi,0)
						    				,FormatoMonto($totalInventario,0)
						    				,FormatoMonto($totalSinPlacas,0)
						    				,FormatoMonto($totalSinPlacasNOPDI,0)
						    				,FormatoMonto($totalSinFact,0)
						    				));

$pdf->SetBorder(false);
$pdf->Row(array(''	,'','','','','','','','','',''));
$pdf->SetFont('Arial','B',8);

$pdf->Output();
?>