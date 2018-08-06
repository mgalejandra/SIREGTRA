<?php
session_start();
require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/reportes.php');

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

$pdf=new PDF('L', 'mm','Letter');

$pdf->SetTitle("Listado Resumen Movimientos Proformas");
$pdf->SetLineWidth(.3);
$pdf->SetFillColor(221,221,221);
$pdf->SetTextColor(0);

$titulo1 = 'Cuadro Resumen Movimientos Proformas';

//página 1
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(5,35);

$pdf->Cell(261,5,utf8_decode($titulo1),0,1,'C',0);
$pdf->SetXY(10,45);


   if (($desde) and ($hasta))
	 	$cabe1 = array('Desde el '.$desde.' hasta el '.$hasta.'');
   elseif (($desde) and !($hasta))
		$cabe1 = array('Desde el '.$desde.'');
   elseif (!($desde) and ($hasta))
		$cabe1 = array('Hasta el '.$hasta.'');

     if ($_SESSION['nomban'])
		$cabe2 = array(''.$banco.'');

        $leyenda=' IPL = Incompleto para liquidar;' .
        		 ' PC = Póliza consignada; ' .
        		 ' PEA = Por Entregar en Acto;' .
        		 ' RRD = Recepción de Reserva de Dominio; ' .
                 ' RDS = Reserva de Dominio Enviada a Suvinca; ' .
         		 ' RA = Reconsideración Aprobada;' .
        		 ' RR = Reconsideración Rechazada;';
        $cabecera_ = array('Marca','Modelo','Venc.','Emit.','Anal.','Esp. Doc.','Aprob.','Esp. Inic.','Inic. Cons.','Fact. Em.','Cert. Em.','RDS','Firma R.D.','RRD','PC','Doc. Not.','IPL','Liq.','PEA','Veh. Ent.','Rech.','Recons.','RA','RR','Total Gral.');
		$anch_ = array(25,25,8,8,8,10,8,10,12,10,12,8,10,8,8,10,8,8,8,10,8,8,8,8,15);
		$alin_ = array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R');
		$anch = array(261);
		$anch1 = array(261);

$c ='TOTALES';

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
			$incompliquid=$listarStatVeh[$i][20];//NUEVO
			$liquidado=$listarStatVeh[$i][17];
			$porentregact=$listarStatVeh[$i][21];//NUEVO
			$entregado=$listarStatVeh[$i][18];
			$rechazado=$listarStatVeh[$i][19];
			$reconsideracion=$listarStatVeh[$i][22];//NUEVO
			$reconaprob=$listarStatVeh[$i][23];//NUEVO
			$reconrecha=$listarStatVeh[$i][24];//NUEVO


	        $reales1 = $vencidas + $emitidas + $analisis + $esperadoc + $aprobado + $esperacons + $inicialcons + $factuemi + $certifemi + $reservadomsuv + $firmaresdomsuv +	$recepresdomsuv + $polizacons + $docnot + $incompliquid + $liquidado + $porentregact + $entregado +	$rechazado + $reconsideracion +	$reconaprob + $reconrecha;

			$pdf->Row(array($marca, $modelo
			                ,($vencidas==0)?"":$vencidas,($emitidas==0)?"":$emitidas
			                ,($analisis==0)?"":$analisis,($esperadoc==0)?"":$esperadoc
			                ,($aprobado==0)?"":$aprobado,($esperacons==0)?"":$esperacons
			                ,($inicialcons==0)?"":$inicialcons,($factuemi==0)?"":$factuemi
			                ,($certifemi==0)?"":$certifemi,($reservadomsuv==0)?"":$reservadomsuv
			                ,($firmaresdomsuv==0)?"":$firmaresdomsuv,($recepresdomsuv==0)?"":$recepresdomsuv
			                ,($polizacons==0)?"":$polizacons,($docnot==0)?"":$docnot
			                ,($incompliquid==0)?"":$incompliquid,($liquidado==0)?"":$liquidado
			                ,($porentregact==0)?"":$porentregact,($entregado==0)?"":$entregado
			                ,($rechazado==0)?"":$rechazado,($reconsideracion==0)?"":$reconsideracion
			                ,($reconaprob==0)?"":$reconaprob,($reconrecha==0)?"":$reconrecha
			                ,FormatoNum($reales1)));

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
	$pdf->Cell(8,5,($_SESSION['venc']==0)?"":$_SESSION['venc'],1,0,'R',0);
	$pdf->Cell(8,5,($_SESSION['emit']==0)?"":$_SESSION['emit'],1,0,'R',0);
	$pdf->Cell(8,5,($_SESSION['anal']==0)?"":$_SESSION['anal'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['espera']==0)?"":$_SESSION['espera'],1,0,'R',0);
	$pdf->Cell(8,5,($_SESSION['aprob']==0)?"":$_SESSION['aprob'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['esperac']==0)?"":$_SESSION['esperac'],1,0,'R',0);
	$pdf->Cell(12,5,($_SESSION['inicial']==0)?"":$_SESSION['inicial'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['factu']==0)?"":$_SESSION['factu'],1,0,'R',0);
	$pdf->Cell(12,5,($_SESSION['certif']==0)?"":$_SESSION['certif'],1,0,'R',0);
	$pdf->Cell(8,5,($_SESSION['reser']==0)?"":$_SESSION['reser'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['firma']==0)?"":$_SESSION['firma'],1,0,'R',0);
	$pdf->Cell(8,5,($_SESSION['recep']==0)?"":$_SESSION['recep'],1,0,'R',0);
	$pdf->Cell(8,5,($_SESSION['poliz']==0)?"":$_SESSION['poliz'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['docn']==0)?"":$_SESSION['docn'],1,0,'R',0);
	$pdf->Cell(8,5,($_SESSION['incompliq']==0)?"":$_SESSION['incompliq'],1,0,'R',0);
	$pdf->Cell(8,5,($_SESSION['liq']==0)?"":$_SESSION['liq'],1,0,'R',0);
	$pdf->Cell(8,5,($_SESSION['porent']==0)?"":$_SESSION['porent'],1,0,'R',0);
	$pdf->Cell(10,5,($_SESSION['ent']==0)?"":$_SESSION['ent'],1,0,'R',0);
	$pdf->Cell(8,5,($_SESSION['rech']==0)?"":$_SESSION['rech'],1,0,'R',0);
	$pdf->Cell(8,5,($_SESSION['recons']==0)?"":$_SESSION['recons'],1,0,'R',0);
	$pdf->Cell(8,5,($_SESSION['reconsap']==0)?"":$_SESSION['reconsap'],1,0,'R',0);
	$pdf->Cell(8,5,($_SESSION['reconsrec']==0)?"":$_SESSION['reconsrec'],1,0,'R',0);
	$pdf->Cell(15,5,$reales,1,0,'R',0);

    $pdf->ln();

     $xtit = utf8_decode("Total: ".$j." Marcas");
     $pdf->Cell(90,5,$xtit,0,0,'L',0);
     $pdf->ln();
     $pdf->Cell(90,5,utf8_decode($leyenda),0,0,'L',0);

$pdf->Output();
?>