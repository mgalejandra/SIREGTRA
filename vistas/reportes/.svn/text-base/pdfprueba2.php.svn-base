<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/crearPDFMin.php');
require('../../controlador/funciones.php');
require('../../modelos/estados.php');
$estado = new Estados();

$cantidades = $estado->CantidadesCitasxEstado();
$totalx 	= $estado->TotalCitasxEstado();
$total 		= $estado->TotalCitas();
$aux     	= '';
$total   	= 0;
$c_total 	= 0;
$s_total 	= 0;
$a_total 	= 0;
$d_total 	= 0;
$x_total 	= 0;
$total 		= $estado->TotalCitas();
$count 		= 0;
  							
$pdf = new PDF('L', 'mm','Letter');
$pdf->SetTitle("Población Atendida por Regiones");

$titulo1 = 'Población Atendida por Regiones';

$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(5,25);
$pdf->Cell(255,5,utf8_decode($titulo1.' al '.date('d/m/Y')),0,1,'C',0);
$pdf->SetXY(5,26);


$anch_ = array(45,35,35,35,40,35,35);
$alin_ = array('C','C','C','C','C','C','C');

$pdf->Ln();
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);
$pdf->SetFont('Arial', 'B', 9);	
$pdf->Row(
	array(
		'Regiones / Estados',
		'1. Citas Otorgadas por Sistema',
		'2. Sol. Atendidas para Entregar Documentos',
		'3. Sol. Pendientes por Asistir',
		'4. Diferencia Persona No Asistieron a la Cita',
		'5. Sol. Registradas Pendientes por Cita',
		'6. Tot. Pob. Atendida (1 + 5)'));	


for($i=0;$i<count($cantidades);$i+=8):	
$count++;
			$anch_ = array(45,35,35,35,40,35,17.5,17.5);
			$alin_ = array('C','C','C','C','C','C','C','C');
			$pdf->SetWidths($anch_);
			$pdf->SetAligns($alin_);
			
			$pdf->SetBorder(true);
			if($count == 20): 
				$pdf->AddPage();	
				$pdf->SetFont('Arial','B',12);
				$pdf->SetXY(5,25);
				$pdf->Cell(255,5,utf8_decode($titulo1.' al '.date('d/m/Y')),0,1,'C',0);
				$pdf->SetXY(10,30);		
				$pdf->SetFont('Arial', 'B', 9);					
				$anch_ = array(45,35,35,35,40,35,35);
				$alin_ = array('C','C','C','C','C','C','C');
				$pdf->SetWidths($anch_);
				$pdf->SetAligns($alin_);
				$pdf->SetBorder(true);
				$pdf->Row(
						array(
							'Regiones / Estados',
							'1. Citas Otorgadas por Sistema',
							'2. Sol. Atendidas para Entregar Documentos',
							'3. Sol. Pendientes por Asistir',
							'4. Diferencia Persona No Asistieron a la Cita',
							'5. Sol. Registradas Pendientes por Cita',
							'6. Tot. Pob. Atendida (1 + 5)'));
												
				$anch_ = array(45,35,35,35,40,35,17.5,17.5);
				$alin_ = array('C','C','C','C','C','C','C','C');
				$pdf->SetWidths($anch_);
				$pdf->SetAligns($alin_);
			endif;				
			if($aux != $cantidades[$i+0]) $aux = '';
			if($aux == ''):
				for($j=0; $j < count($totalx); $j+=7):
					if ($cantidades[$i+7]==$totalx[$j+0]):
						$col1=$totalx[$j+2];
						$col2=$totalx[$j+3];
						$col3=$totalx[$j+4];
						$col4=$totalx[$j+5];
						$col5=$totalx[$j+6];	
						break;
					endif;
				endfor;		
				$pdf->SetBorder(true);	  	
				$pdf->SetFont('Arial', 'B', 9);									
				$pdf->Row(array(
			                 $cantidades[$i+0],
			                 $col1,
			                 $col2,
			                 $col3,
			                 $col4,
			                 $col5,
			                 $col1 + $col5.' ',
			                 FormatoMonto((($col1 + $col5)/$total[0])*100)."%"));
			
			    $aux = $cantidades[$i+0];
			endif;			
			
			$pdf->SetFont('Arial', null, 9);
			$c_total += $cantidades[$i+2];
			$s_total += $cantidades[$i+3];
			$a_total += $cantidades[$i+4];
			$d_total += $cantidades[$i+5];
			$x_total += $cantidades[$i+6];
			$pdf->SetBorder(false);
			$pdf->Row(array(
			                 $cantidades[$i+1],
			                 $cantidades[$i+2],
			                 $cantidades[$i+3],
			                 $cantidades[$i+4],
			                 $cantidades[$i+5],
			                 $cantidades[$i+6]));
endfor;

$pdf->SetFont('Arial', 'B', 9);	
$anch_ = array(45,35,35,35,40,35,17.5,17.5);
$alin_ = array('C','C','C','C','C','C','C','C');
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);
$pdf->Row(array('TOTALES',
			    $c_total.' ',
			    $s_total.' ',
			    $a_total.' ',
			    $d_total.' ',
			    $x_total.' ',
			    $c_total + $x_total.' ',
			    '100%'));
			    
$pdf->Output();
?>