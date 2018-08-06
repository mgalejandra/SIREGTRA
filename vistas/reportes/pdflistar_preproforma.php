<?php
session_start();
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/inventario.php');
require('../../modelos/asignacion.php');

  $codmar=$_SESSION['codmar_'];
  $modveh=$_SESSION['codmodveh_'];
  $serveh=$_SESSION['codserveh_'];
  $codpro=$_SESSION['codpro_'];

 // $pgActual = $_POST['pagina'];

$objAsignacion = new asignacion();

//$nroFilas = 15;

if ($serveh)
	$nro_colum = 14;
else
	$nro_colum = 13;

$contArt = $objAsignacion->contarVehAsigPreInv($codpro,$codmar,$modveh,$serveh);
$listar=$objAsignacion->listarVehAsigPreInv($codpro,$codmar,$modveh,$serveh,-1);

//$listar=$_POST['listar'];
$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle("Lista de Entregas");
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$titulo1 = 'Listado de Vehículos Asignados';

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(5,35);
$titulo2 = utf8_decode($titulo2);

$pdf->Cell(255,5,$titulo1,0,1,'C',0);
$pdf->Cell(265,5,$titulo2,0,1,'C',0);
//$pdf->Ln();

$pdf->SetXY(10,45);

$cabecera_ = array('Nro','CI/RIF','Beneficiario','Marca','Modelo','Fecha Asignacion','Precio (min-max)');

$anch_ = array(10,30,65,35,30,35,40);
$alin_ = array('C','C','C','C','C','C','C','C');

$pdf->cabecera($cabecera_,$anch_);
$pdf->SetFont('Arial','',8);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);

$j=0;
for($i=0;$i<count($listar);$i+=$nro_colum){
	$j++;
/*
0 a.id_entrega,
1 a.ci_ben,
2 b.nombre_ben,
3 b.apellido_ben,
4 a.total,
5 to_char(a.fecha,'dd/mm/yyyy')||' / '||a.hora,
6 a.id_proforma,
7 a.usuario,
8 c.razon_social
 */
if ($serveh){
    $pdf->Row(array(''.$j.''
    				,$listar[$i]
    				,$listar[$i+1].' '.$listar[$i+2].' '.$listar[$i+3].' '.$listar[$i+4]
    				,$listar[$i+6]
    				,$listar[$i+7]
    				,$listar[$i+10]
					,$listar[$i+5]
   					,$listar[$i+8].' - '.$listar[$i+9]));
}else{
	    $pdf->Row(array(''.$j.''
    				,$listar[$i]
    				,$listar[$i+1].' '.$listar[$i+2].' '.$listar[$i+3].' '.$listar[$i+4]
    				,$listar[$i+6]
    				,$listar[$i+7]
					,$listar[$i+5]
   					,$listar[$i+8].' - '.$listar[$i+9]));
}

    if ($pdf->getY()>170){
    	$pdf->addpage();
 /*
    	$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(5,35);
		$pdf->Cell(260,5,$titulo,0,0,'C',0);
		$pdf->SetXY(10,45);
    	$pdf->cabecera($cabecera ,$anch );
    	$pdf->cabecera($cabecera_,$anch_);
    	$pdf->SetFont('Arial','',8);
*/
    				// Reescritura de titulos

			$pdf->SetFont('Arial','B',12);
			$pdf->SetXY(10,30);
			$pdf->Cell(0,7,$titulo,0,1,'C',0);
			$pdf->SetFont('Arial','',12);

			$pdf->Cell(0,7,$titulo1,0,1,'C',0);
			$pdf->Cell(260,5,$titulo2,0,1,'C',0);

			$pdf->cabecera($cabecera,$anch);
			$pdf->SetFont('Arial','',8);
			$pdf->SetWidths($anch);
			$pdf->SetAligns($alin);
			$pdf->SetBorder(true);

			$pdf->cabecera($cabecera_,$anch_);
			$pdf->SetFont('Arial','',8);
			$pdf->SetWidths($anch_);
			$pdf->SetAligns($alin_);
			$pdf->SetBorder(true);
	    }
}

//	totales
//  $pdf->ln();

     $xtit = utf8_decode("Total: ".$j);
     $pdf->Cell(90,5,$xtit,0,0,'L',0);

$pdf->Output();
?>