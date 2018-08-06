<?php
session_start();
require('../../modelos/fpdf/crearPDFMin.php');
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/inventario.php');

$objInventario = new inventario();
$pdf=new PDF('L', 'mm','Letter');
$nro_colum = 6;
$fecha=date('d/m/Y');

if ($_GET['numlotveh'])
	$xxx=$_GET['numlotveh'];
else
	$xxx=14;


if ($_GET['numlotveh']){
	if ($xxx==14) $nombreL = "PRIMER LOTE";
elseif ($xxx==15) $nombreL = "SEGUNDO LOTE";
elseif ($xxx==16) $nombreL = "TERCER LOTE";
//elseif ($xxx==17) $nombreL = "CUARTO LOTE";

$listVehAsigPreInv14=$objInventario->reportePreinventarioC1($xxx);
$titulo1 = 'RELACION DE VEHICULOS POR MODELOS DEL '.$nombreL.'  AL '.$fecha;
//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->SetXY(5,35);
$titulo2 = utf8_decode($titulo2);
$pdf->Cell(255,5,$titulo1,0,1,'C',0);
$pdf->Cell(265,5,$titulo2,0,1,'C',0);
//$pdf->Ln();
$pdf->SetXY(10,45);
$cabecera_ = array('CONDICION','QQ3','X1','TIGGO','GRAND TIGER 4X2','GRAND TIGER 4X4','TOTAL');
$anch_ = array(63,20,20,20,52,52,25);
$alin_ = array('C','C','C','C','C','C','C');
$pdf->cabeceraMINCO($cabecera_,$anch_);
$pdf->SetFont('Arial','',16);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);

$j=0;

for($i=0;$i<count($listVehAsigPreInv14);$i+=$nro_colum){
$total=$listVehAsigPreInv14[$i+1]+$listVehAsigPreInv14[$i+2]+$listVehAsigPreInv14[$i+3]+$listVehAsigPreInv14[$i+4]+$listVehAsigPreInv14[$i+5];
	if (($listVehAsigPreInv14[$i]=='INVENTARIO INICIAL') or ($listVehAsigPreInv14[$i]=='ENTREGADOS')){
	             $pdf->setjump(10);
				 $pdf->Row(array("\n".$listVehAsigPreInv14[$i]
				    			,"\n".$listVehAsigPreInv14[$i+1]
				    			,"\n".$listVehAsigPreInv14[$i+2]
				    			,"\n".$listVehAsigPreInv14[$i+3]
				    			,"\n".$listVehAsigPreInv14[$i+4]
				    			,"\n".$listVehAsigPreInv14[$i+5]
				    			,"\n".FormatoMonto($total,0)));
    }
    if (($listVehAsigPreInv14[$i]=='PRE')){
			$qq3=$listVehAsigPreInv14[$i+1];$x1=$listVehAsigPreInv14[$i+2];$tig=$listVehAsigPreInv14[$i+3];$tg4=$listVehAsigPreInv14[$i+4];$t44=$listVehAsigPreInv14[$i+5];
	}
    if (($listVehAsigPreInv14[$i]=='ENTREGADOS')){
			$qq3E=$listVehAsigPreInv14[$i+1];$x1E=$listVehAsigPreInv14[$i+2];$tigE=$listVehAsigPreInv14[$i+3];$tg4E=$listVehAsigPreInv14[$i+4];$t44E=$listVehAsigPreInv14[$i+5];
    }
	if ($listVehAsigPreInv14[$i]=='ASIGNADOS'){
		$asigqq3=($listVehAsigPreInv14[$i+1]-$qq3E)+$qq3;$asigx1=($listVehAsigPreInv14[$i+2]-$x1E)+$x1;$asigtig=($listVehAsigPreInv14[$i+3]-$tigE)+$tig;
		$asigtg4=($listVehAsigPreInv14[$i+4]-$tg4E)+$tg4;$asigt44=($listVehAsigPreInv14[$i+5]-$t44E)+$t44;$total2=$asigqq3+$asigx1+$asigtig+$asigtg4+$asigt44;
				 $pdf->Row(array("\n".$listVehAsigPreInv14[$i]
				    			,"\n".FormatoMonto($asigqq3,0)
				    			,"\n".FormatoMonto($asigx1,0)
				    			,"\n".FormatoMonto($asigtig,0)
				    			,"\n".FormatoMonto($asigtg4,0)
				    			,"\n".FormatoMonto($asigt44,0)
				    			,"\n".FormatoMonto($total2,0)));
     }

     if (($listVehAsigPreInv14[$i]=='INVENTARIO INICIAL')){
			$qq3I=$listVehAsigPreInv14[$i+1];$x1I=$listVehAsigPreInv14[$i+2];$tigI=$listVehAsigPreInv14[$i+3];$tg4I=$listVehAsigPreInv14[$i+4];$t44I=$listVehAsigPreInv14[$i+5];
     }
  }
			$qq3I=$qq3I-($qq3E+$asigqq3);
			$x1I=$x1I-($x1E+$asigx1);
			$tigI=$tigI-($tigE+$asigtig);
			$tg4I=$tg4I-($tg4E+$asigtg4);
			$t44I=$t44I-($t44E+$asigt44);
			$total3=$qq3I+$x1I+$tigI+$tg4I+$t44I;
  $pdf->Ln(2);
  					$pdf->Row(array("\nDIFERENCIA"
				    			,"\n".FormatoMonto($qq3I,0)
				    			,"\n".FormatoMonto($x1I,0)
				    			,"\n".FormatoMonto($tigI,0)
				    			,"\n".FormatoMonto($tg4I,0)
				    			,"\n".FormatoMonto($t44I,0)
				    			,"\n".FormatoMonto($total3,0)));
  $pdf->Ln(2);
for($j=0;$j<count($listVehAsigPreInv14);$j+=$nro_colum){
$total=$listVehAsigPreInv14[$j+1]+$listVehAsigPreInv14[$j+2]+$listVehAsigPreInv14[$j+3]+$listVehAsigPreInv14[$j+4]+$listVehAsigPreInv14[$j+5];
	if (($listVehAsigPreInv14[$j]=='PDI NEGATIVO') OR ($listVehAsigPreInv14[$j]=='DISPONIBLES')){
				 $pdf->Row(array("\n".$listVehAsigPreInv14[$j]
				    			,"\n".$listVehAsigPreInv14[$j+1]
				    			,"\n".$listVehAsigPreInv14[$j+2]
				    			,"\n".$listVehAsigPreInv14[$j+3]
				    			,"\n".$listVehAsigPreInv14[$j+4]
				    			,"\n".$listVehAsigPreInv14[$j+5]
				    			,"\n".FormatoMonto($total,0)));
     }

  }
}
else{

do{

if ($xxx==14) $nombreL = "PRIMER LOTE";
elseif ($xxx==15) $nombreL = "SEGUNDO LOTE";
elseif ($xxx==16) $nombreL = "TERCER LOTE";
//elseif ($xxx==17) $nombreL = "CUARTO LOTE";

$listVehAsigPreInv14=$objInventario->reportePreinventarioC1($xxx);
$titulo1 = 'RELACION DE VEHICULOS POR MODELOS DEL '.$nombreL.'  AL '.$fecha;
//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->SetXY(5,35);
$titulo2 = utf8_decode($titulo2);
$pdf->Cell(255,5,$titulo1,0,1,'C',0);
$pdf->Cell(265,5,$titulo2,0,1,'C',0);
//$pdf->Ln();
$pdf->SetXY(10,45);
$cabecera_ = array('CONDICION','QQ3','X1','TIGGO','GRAND TIGER 4X2','GRAND TIGER 4X4','TOTAL');
$anch_ = array(63,20,20,20,52,52,25);
$alin_ = array('C','C','C','C','C','C','C');
$pdf->cabeceraMINCO($cabecera_,$anch_);
$pdf->SetFont('Arial','',16);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);

$j=0;

for($i=0;$i<count($listVehAsigPreInv14);$i+=$nro_colum){
$total=$listVehAsigPreInv14[$i+1]+$listVehAsigPreInv14[$i+2]+$listVehAsigPreInv14[$i+3]+$listVehAsigPreInv14[$i+4]+$listVehAsigPreInv14[$i+5];
	if (($listVehAsigPreInv14[$i]=='INVENTARIO INICIAL') or ($listVehAsigPreInv14[$i]=='ENTREGADOS')){
	             $pdf->setjump(10);
				 $pdf->Row(array("\n".$listVehAsigPreInv14[$i]
				    			,"\n".$listVehAsigPreInv14[$i+1]
				    			,"\n".$listVehAsigPreInv14[$i+2]
				    			,"\n".$listVehAsigPreInv14[$i+3]
				    			,"\n".$listVehAsigPreInv14[$i+4]
				    			,"\n".$listVehAsigPreInv14[$i+5]
				    			,"\n".FormatoMonto($total,0)));
    }
    if (($listVehAsigPreInv14[$i]=='PRE')){
			$qq3=$listVehAsigPreInv14[$i+1];$x1=$listVehAsigPreInv14[$i+2];$tig=$listVehAsigPreInv14[$i+3];$tg4=$listVehAsigPreInv14[$i+4];$t44=$listVehAsigPreInv14[$i+5];
	}
    if (($listVehAsigPreInv14[$i]=='ENTREGADOS')){
			$qq3E=$listVehAsigPreInv14[$i+1];$x1E=$listVehAsigPreInv14[$i+2];$tigE=$listVehAsigPreInv14[$i+3];$tg4E=$listVehAsigPreInv14[$i+4];$t44E=$listVehAsigPreInv14[$i+5];
    }
	if ($listVehAsigPreInv14[$i]=='ASIGNADOS'){
		$asigqq3=($listVehAsigPreInv14[$i+1]-$qq3E)+$qq3;$asigx1=($listVehAsigPreInv14[$i+2]-$x1E)+$x1;$asigtig=($listVehAsigPreInv14[$i+3]-$tigE)+$tig;
		$asigtg4=($listVehAsigPreInv14[$i+4]-$tg4E)+$tg4;$asigt44=($listVehAsigPreInv14[$i+5]-$t44E)+$t44;$total2=$asigqq3+$asigx1+$asigtig+$asigtg4+$asigt44;
				 $pdf->Row(array("\n".$listVehAsigPreInv14[$i]
				    			,"\n".FormatoMonto($asigqq3,0)
				    			,"\n".FormatoMonto($asigx1,0)
				    			,"\n".FormatoMonto($asigtig,0)
				    			,"\n".FormatoMonto($asigtg4,0)
				    			,"\n".FormatoMonto($asigt44,0)
				    			,"\n".FormatoMonto($total2,0)));
     }

     if (($listVehAsigPreInv14[$i]=='INVENTARIO INICIAL')){
			$qq3I=$listVehAsigPreInv14[$i+1];$x1I=$listVehAsigPreInv14[$i+2];$tigI=$listVehAsigPreInv14[$i+3];$tg4I=$listVehAsigPreInv14[$i+4];$t44I=$listVehAsigPreInv14[$i+5];
     }
  }
			$qq3I=$qq3I-($qq3E+$asigqq3);
			$x1I=$x1I-($x1E+$asigx1);
			$tigI=$tigI-($tigE+$asigtig);
			$tg4I=$tg4I-($tg4E+$asigtg4);
			$t44I=$t44I-($t44E+$asigt44);
			$total3=$qq3I+$x1I+$tigI+$tg4I+$t44I;
  $pdf->Ln(2);
  					$pdf->Row(array("\nDIFERENCIA"
				    			,"\n".FormatoMonto($qq3I,0)
				    			,"\n".FormatoMonto($x1I,0)
				    			,"\n".FormatoMonto($tigI,0)
				    			,"\n".FormatoMonto($tg4I,0)
				    			,"\n".FormatoMonto($t44I,0)
				    			,"\n".FormatoMonto($total3,0)));
  $pdf->Ln(2);
for($j=0;$j<count($listVehAsigPreInv14);$j+=$nro_colum){
$total=$listVehAsigPreInv14[$j+1]+$listVehAsigPreInv14[$j+2]+$listVehAsigPreInv14[$j+3]+$listVehAsigPreInv14[$j+4]+$listVehAsigPreInv14[$j+5];
	if (($listVehAsigPreInv14[$j]=='PDI NEGATIVO') OR ($listVehAsigPreInv14[$j]=='DISPONIBLES')){
				 $pdf->Row(array("\n".$listVehAsigPreInv14[$j]
				    			,"\n".$listVehAsigPreInv14[$j+1]
				    			,"\n".$listVehAsigPreInv14[$j+2]
				    			,"\n".$listVehAsigPreInv14[$j+3]
				    			,"\n".$listVehAsigPreInv14[$j+4]
				    			,"\n".$listVehAsigPreInv14[$j+5]
				    			,"\n".FormatoMonto($total,0)));
     }

  }

$xxx++;
} while ($xxx<=16);
}
$pdf->Output();

?>