<?php
	session_start();
	require('../../modelos/conexion.php');
	require('../../modelos/fpdf/creaPDF.php');
	require('../../modelos/estados.php');
	require('../../controlador/funciones.php');
	
	$pdf = new PDF('L', 'mm','Letter');
	$pdf->SetMargins(10,10,10,10);	
	$pdf->AddPage();
	$pdf->SetXY(10,30);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(256,5,'Lapso: Enero al '.date('d/m/Y'),0,0,'R',0);
	$pdf->SetXY(10,35);
	$pdf->Cell(256,5,'POBLACION ATENDIDA POR REGIONES',0,0,'C',0);
	$pdf->SetXY(10,45);
	
	$pdf->SetWidths(array(45,35,35,35,35,35,35));
	$pdf->SetFont('Arial', 'B', 7);
	$pdf->SetBorder(1);
	$pdf->SetAligns(array('C','C','C','C','C','C','C'));
	
	$pdf->SetFillColor(204,204,204);
	$pdf->Rect(10,45,255,8,FD);
	
	$pdf->Row(
			array(
				"Regiones / Estados",
				"1. Citas Otorgadas por Sistema",
				"2. Solicitudes Atendidas para Entregar Documentos",
				"3. Solicitudes Pendientes por Asistir",
				"4. Diferencia Persona que No Asistieron a la Cita",
				"5. Solicitudes Registradas Pendientes por Cita",
				"6. Total Poblacion Atendida ( 1 + 5 )"));
	
		// Region		
	$estados = new Estados();
	$pdf->SetFillColor(204,204,204);
	for($i = 0; $i<count($regiones = $estados->Regiones()); $i++):
		$pdf->SetFont('Arial', 'B', 7);	
		$reg = explode('-',$regiones[$i]);
		$pdf->Cell(45,3.5,$reg[1],1,0,'L', true);		
		// Cantidades x region
		for($j=0; $j<count($cantidadreg = $estados->CantidadSolicitudesBeneficiariosWeb($reg[0])); $j++):
			$pdf->Cell(35,3.5,$cantidadreg[$j],1,0,'C', true);
			$cantidad = $cantidadreg[0] + $cantidadreg[4];			
		endfor;
		
		$cantidad_atendida     += $cantidadreg[0];
		$cantidad_documento    += $cantidadreg[1];
		$cantidad_pendiente    += $cantidadreg[2];
		$cantidad_noasistieron += $cantidadreg[3];
		$cantidad_pendientes   += $cantidadreg[4];
		
		$pdf->Cell(17.5,3.5, $cantidad,1,0,'C', true);
		$total = $estados->TotalCitas();
		$por   = ($cantidad/$total[0]) * 100;
		$acm  += $por;
		$pdf->Cell(17.5,3.5, FormatoMonto($por)." %",1,0,'C', true);
		$pdf->SetFont('Arial', NULL, 7);
		
		// Estados
		for($k = 0; $k<count($estado = $estados->EstadosRegiones($reg[0])); $k++):
			$pdf->Ln();			
			$est = explode('-',$estado[$k]);
			//$pdf->Cell(45,4,"          ".$est[1],1,0,'L');
			for($l=0; $l<count($cantidadest = $estados->CantSolicitudesBeneficiariosWebEstados($est[0])); $l++):
				if($l != 0){					
					$pdf->Cell(35,3.5,$cantidadest[$l],0,0,'C');					
				}else{	
					$pdf->Cell(45,3.5,"    ".$cantidadest[$l],0,0,'L');					
				}
			endfor;				
			// Totales
			$pdf->Cell(17.5,3.5,$cantidadest[1]+$cantidadest[5],0,0,'C');
		endfor;
		$pdf->Ln();
	endfor;
	
	$pdf->SetFont('Arial','B',7);	
	$pdf->Cell(45,3.5,"TOTALES",1,0,'L', true);
	$pdf->Cell(35,3.5,$cantidad_atendida,1,0,'C', true);
	$pdf->Cell(35,3.5,$cantidad_documento,1,0,'C', true);
	$pdf->Cell(35,3.5,$cantidad_pendiente,1,0,'C', true);
	$pdf->Cell(35,3.5,$cantidad_noasistieron,1,0,'C', true);
	$pdf->Cell(35,3.5,$cantidad_pendientes,1,0,'C', true);
	$pdf->Cell(17.5,3.5,$total[0],1,0,'C', true);
	$pdf->Cell(17.5,3.5,$acm." %",1,0,'C', true);
	$pdf->Output();