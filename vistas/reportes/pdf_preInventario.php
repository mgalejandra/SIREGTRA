<?php
session_start();
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/inventario.php');
require('../../modelos/asignacion.php');
require('../../modelos/vehiculos.php');

  $codmar=$_SESSION['codmar_'];
  $modveh=$_SESSION['codmodveh_'];
  $serveh=$_SESSION['codserveh_'];
  $codpro=$_SESSION['codpro_'];

$objInventario = new inventario();
$objVehiculo = new vehiculos();

$nro_colum = 7;

//$listar=$objInventario->reportePreinventario();
$listVehAsigPreInv=$_SESSION['listVehAsigPreInv'];
$listVehAsigPreInv1=$_SESSION['listVehAsigPreInv1'];
$listVehAsigPreInv2=$_SESSION['listVehAsigPreInv2'];
//$listVehAsigPreInv3=$_SESSION['listVehAsigPreInv3'];

//$listar=$_POST['listar'];
$pdf=new PDF('P', 'mm','Letter');

$pdf->SetTitle("Lista de Pre-Inventario");
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$titulo1 = 'Lista de Pre-Inventario';

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(5,35);
$titulo2 = utf8_decode($titulo2);

$pdf->Cell(255,5,$titulo1,0,1,'C',0);
$pdf->Cell(265,5,$titulo2,0,1,'C',0);
//$pdf->Ln();

$pdf->SetXY(10,45);

$cabecera_ = array('Lote','Modelo','Existencia Inicial','Pre-Inventario','Proforma','PDI N/A','Existencia Inicial - (Pre-prof. + Prof.) - PDI');

$anch_ = array(15,30,30,25,20,17,60);

$alin_ = array('C','C','C','C','C','C','C');

$pdf->cabecera1($cabecera_,$anch_);
$pdf->SetFont('Arial','',8);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);

$j=0;

for($i=0;$i<count($listVehAsigPreInv);$i+=$nro_colum){
             if($listVehAsigPreInv[$i]){
             	$listVehAsigPreInvInicial=$objInventario->reportePreinventarioInicial($desde,$hasta,14,$listVehAsigPreInv[$i]);
             	$listVehNoPDI=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv[$i],'',14,'','',-1);
                $cuenta = count($listVehNoPDI)/$nro_colum;

              /*   if ($listVehAsigPreInv[$i]=='QQ3')
                      	$imprimoQ = $cuenta;
                 elseif ($listVehAsigPreInv[$i]=='X1')
                       	$imprimoX = $cuenta;
                 elseif ($listVehAsigPreInv[$i]=='TIG')
                      	$imprimoTIG = $cuenta;
                 elseif ($listVehAsigPreInv[$i]=='TG4')
                 		$imprimoTG4 = $cuenta;
                 elseif ($listVehAsigPreInv[$i]=='T44')
                      	$imprimoT44 = $cuenta;*/


				 $pdf->Row(array($listVehAsigPreInv[$i+6]
				    				,$listVehAsigPreInv[$i+1]
				    				,$listVehAsigPreInv[$i+2]
				    				,$listVehAsigPreInvInicial[0]
				    				,$listVehAsigPreInv[$i+3]
				    				,FormatoNum($cuenta)
				    				,$listVehAsigPreInv[$i+5]));

           /*  if ($listVehAsigPreInv[$i+1]=="QQ3") echo $imprimoQ;
             if ($listVehAsigPreInv[$i+1]=="X1")  echo $imprimoX;
             if ($listVehAsigPreInv[$i+1]=="TIGGO")echo $imprimoTIG;
             if ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X2") echo $imprimoTG4;
             if ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X4") echo $imprimoT44;*/

  		    }
  }

$pdf->Ln(2);

for($i=0;$i<count($listVehAsigPreInv1);$i+=$nro_colum){
             if($listVehAsigPreInv1[$i]){
             	$listVehAsigPreInvInicial1=$objInventario->reportePreinventarioInicial($desde,$hasta,15,$listVehAsigPreInv1[$i]);
             	$listVehNoPDI1=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv1[$i],'',15,'','',-1);
                $cuenta1 = count($listVehNoPDI1)/$nro_colum;


                 /* if ($listVehAsigPreInv1[$i]=='QQ3')
                  		$imprimoQ1 = $cuenta1;
                  elseif ($listVehAsigPreInv1[$i]=='X1')
              			$imprimoX1 = $cuenta1;
                  elseif ($listVehAsigPreInv1[$i]=='TIG')
						$imprimoTIG1 = $cuenta1;
                  elseif ($listVehAsigPreInv1[$i]=='TG4')
                 		$imprimoTG41 = $cuenta1;
                  elseif ($listVehAsigPreInv1[$i]=='T44')
                 		$imprimoT441 = $cuenta1;*/

				 $pdf->Row(array($listVehAsigPreInv1[$i+6]
				    				,$listVehAsigPreInv1[$i+1]
				    				,$listVehAsigPreInv1[$i+2]
				    				,$listVehAsigPreInvInicial1[0]
				    				,$listVehAsigPreInv1[$i+3]
				    				,FormatoNum($cuenta1)
				    				,$listVehAsigPreInv1[$i+5]));

           /*  if ($listVehAsigPreInv1[$i+1]=="QQ3") echo $imprimoQ1;
             if ($listVehAsigPreInv1[$i+1]=="X1")  echo $imprimoX1;
             if ($listVehAsigPreInv1[$i+1]=="TIGGO")echo $imprimoTIG1;
             if ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X2") echo $imprimoTG41;
             if ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X4") echo $imprimoT441;*/

  		    }
  }


$pdf->Ln(2);

for($i=0;$i<count($listVehAsigPreInv2);$i+=$nro_colum){
             if($listVehAsigPreInv2[$i]){
             	$listVehAsigPreInvInicial2=$objInventario->reportePreinventarioInicial($desde,$hasta,16,$listVehAsigPreInv2[$i]);
             	$listVehNoPDI2=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv2[$i],'',16,'','',-1);
                $cuenta2 = count($listVehNoPDI2)/$nro_colum;


				 $pdf->Row(array($listVehAsigPreInv2[$i+6]
				    				,$listVehAsigPreInv2[$i+1]
				    				,$listVehAsigPreInv2[$i+2]
				    				,$listVehAsigPreInvInicial2[0]
				    				,$listVehAsigPreInv2[$i+3]
				    				,FormatoNum($cuenta2)
				    				,$listVehAsigPreInv2[$i+5]));

  		    }
  }

/*$pdf->Ln(2);

for($i=0;$i<count($listVehAsigPreInv3);$i+=$nro_colum){
             if($listVehAsigPreInv3[$i]){
             	$listVehAsigPreInvInicial3=$objInventario->reportePreinventarioInicial($desde,$hasta,17,$listVehAsigPreInv3[$i]);
             	$listVehNoPDI3=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv3[$i],'',17,'','',-1);
                $cuenta3 = count($listVehNoPDI3)/$nro_colum;


				 $pdf->Row(array($listVehAsigPreInv3[$i+6]
				    				,$listVehAsigPreInv3[$i+1]
				    				,$listVehAsigPreInv3[$i+2]
				    				,$listVehAsigPreInvInicial3[0]
				    				,$listVehAsigPreInv3[$i+3]
				    				,FormatoNum($cuenta3)
				    				,$listVehAsigPreInv3[$i+5]));

  		    }
  }*/

$pdf->Output();


//LO QUE ESTABA ANTES
//for($i=0;$i<count($listar);$i+=$nro_colum){
//	$j++;
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
/*if (($listar[$i+1]=="X1") or ($listar[$i+1]=="TIGGO")) {
	if($listar[$i+1]=="X1") $pdi=11;
	if ($listar[$i+1]=="TIGGO") $pdi=19;
}elseif(($listar[$i+1]<>"TIGGO") or ($listar[$i+1]<>"X1")) $pdi=0;

    $pdf->Row(array($listar[$i+1]
    				,$listar[$i+2]
    				,$listar[$i+4]
    				,$listar[$i+3]
    				,FormatoNum($pdi)
    				,$listar[$i+5]
   					));

    if ($pdf->getY()>170){
    	$pdf->addpage();*/
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

		/*	$pdf->SetFont('Arial','B',12);
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
	    }*/
//}

//	totales
//  $pdf->ln();
?>