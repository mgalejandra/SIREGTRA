<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/reportes.php');
/*require('../../modelos/banco.php');

$objBancos= new bancos();
$objDistribuidor = new beneficiario();

$codBanco=$_SESSION['id_banco'];
$dist=$_GET['dist'];*/

$marca= $_GET['marca'];
$desde=$_GET['desde'];
$hasta=$_GET['hasta'];
$modelo=$_GET['mod'];
$fechaF=$_GET['fecfac'];
$lote=$_GET['lote'];

$listarStatVeh=$_SESSION['listarStatVeh'];
$banco=$_SESSION['nomban'];




$reales=$_SESSION['reales'];
$total= $_SESSION['totaltotal'];


/*$tab_banco = $objBancos->listarBanco();
$dimBancos = sizeof($tab_banco);

if ($codBanco)
	$tab_banco1 = $objBancos->listarBanco($codBanco);
else
	$tab_banco1[1] = "TODOS LOS BANCOS";

if ($dist)
	$tab_dist1 = $objDistribuidor->listmin('',$dist);
else
	$tab_dist1[0] = "TODOS LOS DISTRIBUIDORES";*/


$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle("Listado Resumen de Proformas de Vehículos por Estatus");
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$titulo1 = 'Cuadro Resumen de Proformas de Vehículos por Estatus';

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(5,35);

$pdf->Cell(255,5,utf8_decode($titulo1),0,1,'C',0);
$pdf->SetXY(10,45);


//$cabe = array($tab_banco1[1].' - '.$tab_dist1[0]);

   if (($desde) and ($hasta))
	 	$cabe1 = array('Desde el '.$desde.' hasta el '.$hasta.'');
   elseif (($desde) and !($hasta))
		$cabe1 = array('Desde el '.$desde.'');
   elseif (!($desde) and ($hasta))
		$cabe1 = array('Hasta el '.$hasta.'');

     if ($_SESSION['nomban'])
		$cabe2 = array(''.$banco.'');


        $cabecera_ = array('Marca','Modelo','Exist.','Venc.','Emit.','Anal.','Esp. Doc.','Aprob.','Esp. Inic.','Inic. Cons.','Fact. Em.','Cert. Em.','Res.Dom.Suv.','Firma R.D.','Recep. Dom.','Pol. Cons.','Doc. Not.','Liq.','Veh. Ent.','Rech.','Total Real','Total Gral.');
		$anch_ = array(25,25,10,10,10,10,10,10,10,12,10,12,15,10,15,10,10,10,10,10,10,10);
		$alin_ = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R');
		$anch = array(264);
		$anch1 = array(264);

$c ='TOTALES';


/*$pdf->cabecera($cabe,$anch);
$pdf->cabecera($estatus,$anch);*/
$pdf->cabecera($cabe1,$anch1);
$pdf->cabecera($cabe2,$anch1);
$pdf->cabecera1($cabecera_,$anch_);
$pdf->SetFont('Arial','',6);
$pdf->SetWidths($anch_);
$pdf->SetAligns($alin_);
$pdf->SetBorder(true);
$j=0;
for($i=0;$i<count($listarStatVeh);$i++) {
	$j++;

	$marca = $listarStatVeh[$i][0];
	$modelo = $listarStatVeh[$i][1];


            $existentes= $listarStatVeh[$i][2];
            $vencidas=$listarStatVeh[$i][3];
			$emitidas=$listarStatVeh[$i][4];
		    $analisis=$listarStatVeh[$i][5];
			$esperadoc=$listarStatVeh[$i][6];
			$aprobado=$listarStatVeh[$i][7];
			$esperacons=$listarStatVeh[$i][8];
			$inicialcons=$listarStatVeh[$i][9];
			$factuemi=$listarStatVeh[$i][10];
			$certifemi=$listarStatVeh[$i][11];
			$reservadomsuv=$listarStatVeh[$i][12];
			$firmaresdomsuv=$listarStatVeh[$i][13];
			$recepresdomsuv=$listarStatVeh[$i][14];
			$polizacons=$listarStatVeh[$i][15];
			$docnot=$listarStatVeh[$i][16];
			$liquidado=$listarStatVeh[$i][17];
			$entregado=$listarStatVeh[$i][18];
			$rechazado=$listarStatVeh[$i][19];

			$reales1 = $emitidas + $analisis + $esperadoc + $aprobado + $esperacons + $inicialcons + $factuemi + $certifemi + $reservadomsuv + $firmaresdomsuv + $recepresdomsuv + $polizacons + $docnot + $liquidado + $entregado;
			$totaltotal1 = $existentes - $reales1;

			$pdf->Row(array($marca, $modelo
			                ,($existentes==0)?"":$existentes,($vencidas==0)?"":$vencidas,($emitidas==0)?"":$emitidas
			                ,($analisis==0)?"":$analisis,($esperadoc==0)?"":$esperadoc,($aprobado==0)?"":$aprobado
			                ,($esperacons==0)?"":$esperacons,($inicialcons==0)?"":$inicialcons,($factuemi==0)?"":$factuemi
			                ,($certifemi==0)?"":$certifemi,($reservadomsuv==0)?"":$reservadomsuv,($firmaresdomsuv==0)?"":$firmaresdomsuv
			                ,($recepresdomsuv==0)?"":$recepresdomsuv,($polizacons==0)?"":$polizacons,($docnot==0)?"":$docnot
			                ,($liquidado==0)?"":$liquidado,($entregado==0)?"":$entregado,($rechazado==0)?"":$rechazado
			                ,FormatoNum($reales1),FormatoNum($totaltotal1)));

    if ($pdf->getY()>170){
    	$pdf->addpage();

			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(10,30);
			$pdf->Cell(0,7,utf8_decode($titulo1),0,1,'C',0);
			$pdf->SetFont('Arial','',7);

			$pdf->cabecera($cabecera_,$anch_);
			$pdf->SetFont('Arial','',6);
			$pdf->SetWidths($anch_);
			$pdf->SetAligns($alin_);
			$pdf->SetBorder(true);
	    }




}
$pdf->ln();
//$pdf->Cell(48,5,$c,1,0,'R',0);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','',6);
$pdf->SetBorder(true);

	$pdf->Cell(50,5,$c,1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['exis']==0)?"":$_SESSION['exis'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['venc']==0)?"":$_SESSION['venc'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['emit']==0)?"":$_SESSION['emit'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['anal']==0)?"":$_SESSION['anal'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['espera']==0)?"":$_SESSION['espera'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['aprob']==0)?"":$_SESSION['aprob'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['esperac']==0)?"":$_SESSION['esperac'],1,0,'R',0);
	$pdf->Cell(12,5,($_SESSION['inicial']==0)?"":$_SESSION['inicial'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['factu']==0)?"":$_SESSION['factu'],1,0,'R',0);
	$pdf->Cell(12,5,($_SESSION['certif']==0)?"":$_SESSION['certif'],1,0,'R',0);
	$pdf->Cell(15,5,($_SESSION['reser']==0)?"":$_SESSION['reser'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['firma']==0)?"":$_SESSION['firma'],1,0,'R',0);
	$pdf->Cell(15,5,($_SESSION['recep']==0)?"":$_SESSION['recep'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['poliz']==0)?"":$_SESSION['poliz'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['docn']==0)?"":$_SESSION['docn'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['liq']==0)?"":$_SESSION['liq'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['ent']==0)?"":$_SESSION['ent'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['rech']==0)?"":$_SESSION['rech'],1,0,'R',0);
	$pdf->Cell(10,5,$reales,1,0,'R',0);
	$pdf->Cell(10,5,$total,1,0,'R',0);

 /*   $pdf->Cell(10,5,$existentes,1,0,'R',0);
	$pdf->Cell(10,5,$emitidas,1,0,'R',0);
	$pdf->Cell(10,5,$emitidas,1,0,'R',0);
	$pdf->Cell(10,5,$analisis,1,0,'R',0);
	$pdf->Cell(10,5,$esperadoc,1,0,'R',0);
	$pdf->Cell(10,5,$aprobado,1,0,'R',0);
	$pdf->Cell(10,5,$esperacons,1,0,'R',0);
	$pdf->Cell(10,5,$inicialcons,1,0,'R',0);
	$pdf->Cell(10,5,$factuemi,1,0,'R',0);
	$pdf->Cell(10,5,$certifemi,1,0,'R',0);
	$pdf->Cell(10,5,$reservadomsuv,1,0,'R',0);
	$pdf->Cell(10,5,$firmaresdomsuv,1,0,'R',0);
	$pdf->Cell(10,5,$recepresdomsuv,1,0,'R',0);
	$pdf->Cell(10,5,$polizacons,1,0,'R',0);
	$pdf->Cell(10,5,$docnot,1,0,'R',0);
	$pdf->Cell(10,5,$liquidado,1,0,'R',0);
	$pdf->Cell(10,5,$entregado,1,0,'R',0);
	$pdf->Cell(10,5,$rechazado,1,0,'R',0);
	$pdf->Cell(10,5,$reales,1,0,'R',0);
	$pdf->Cell(10,5,$total,1,0,'R',0);*/

    $pdf->ln();

     $xtit = utf8_decode("Total: ".$j." Marcas");
     $pdf->Cell(90,5,$xtit,0,0,'L',0);

$pdf->Output();
?>