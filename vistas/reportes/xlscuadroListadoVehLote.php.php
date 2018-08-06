<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_Vehiculos_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_Vehiculos_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/reportes.php');
require('../../modelos/pago.php');
require('../../modelos/banco.php');
require('../../modelos/lotes.php');

$indBusq = $_POST['indBusq'];
$objReporte= new reportes();
$objPago = new pago();
$objBanco 		= new banco();
$objLotes 		= new lotes();

  $indBusq 	= $_POST['indBusq'];
  $pgActual = $_POST['pagina'];

  $numlotveh= $_GET['lote'];
  $codmar	= $_GET['marca'];
  $codmodveh= $_GET['mod'];
  $fechaF = $_GET['fecfac'];
  $fechaD = $_GET['desde'];
  $fechaH = $_GET['hasta'];
  $banco = $_GET['banco'];

$reales=$_SESSION['reales'];
$total= $_SESSION['totaltotal'];

if($indBusq==2){

    $numlotveh 	= null;
  	$codmarveh	= null;
  	$codmodveh	= null;
  	$fechaF = null;
  	$fechaD = null;
  	$fechaH = null;
  	$banco = null;
}

$listarStatVeh = $objReporte->resumenCarros($codmar,$fechaF,$fechaD,$fechaH,$codmodveh,$numlotveh,$banco);

$_SESSION['listarStatVehLot']=$listarStatVeh;

$listarBancos=$objPago->listarBancos(3);

if ($banco) $nombreB = $objBanco->listarBancos($banco);
$_SESSION['nombanlot']=$nombreB[2];


//$nroFilas = 22;

	echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="25"><font color="#FFFFFF">Cuadro Resumen de Proformas de Vehículos por Estatus - Agrupados por Lote</font></td>
  	</tr>
  		<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="30"><font color="#FFFFFF">Lote</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Cantidad</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="250"><font color="#FFFFFF">Marca</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Cantidad</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="250"><font color="#FFFFFF">Modelo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Exist</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Venc</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Emit</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Anal</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Esp. Doc.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Aprobado</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Esp. Inic.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Inic. Cons.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fact. Em.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Cert. Em</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Res.DS.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Firma R.D.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">R. Dom</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Pol. Cons</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Doc. Not</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Liquidado</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Veh. Ent</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Rechazado</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="40"><font color="#FFFFFF">NO PDI</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Total Real</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Disponibles</font></td>


  </tr>';
$j=0;

for($i=0;$i<count($listarStatVeh);$i++) {
	$j++;

	$cantidadLote = $objLotes->cantidadVehLote($listarStatVeh[$i][0]);


    if ($listarStatVeh[$i][0]<>$listarStatVeh[$i-1][0]){
    	$lote= $listarStatVeh[$i][0];
    	//$totalot=$listarStatVeh[$i][4];
    	$cantidalot = $cantidadLote[0];
    }
    else
 	{
 		$lote= "";
 		$cantidalot ="";
 	}

//    $lote = $listarStatVeh[$i][0];



	$cantidadLoteMarca = $objLotes->cantidadVehLotexMarca($listarStatVeh[$i][0],$listarStatVeh[$i][22]);

        if ($listarStatVeh[$i][2]<>$listarStatVeh[$i-1][2]){
        	$marca = $listarStatVeh[$i][2];
        	$cantidadmarca = $cantidadLoteMarca[0];
        }
        else
        {
        	$marca = "";
        	$cantidadmarca = "";
        }
        if (($listarStatVeh[$i][0]<>$listarStatVeh[$i-1][0]) and ($listarStatVeh[$i][2]==$listarStatVeh[$i-1][2]))
        {
        	$marca = $listarStatVeh[$i][2];
        	$cantidadmarca = $cantidadLoteMarca[0];
        }

	$modelo = $listarStatVeh[$i][3];


            $existentes= $listarStatVeh[$i][4];
            $vencidas=$listarStatVeh[$i][5];
			$emitidas=$listarStatVeh[$i][6];
		    $analisis=$listarStatVeh[$i][7];
			$esperadoc=$listarStatVeh[$i][8];
			$aprobado=$listarStatVeh[$i][9];
			$esperacons=$listarStatVeh[$i][10];
			$inicialcons=$listarStatVeh[$i][11];
			$factuemi=$listarStatVeh[$i][12];
			$certifemi=$listarStatVeh[$i][13];
			$reservadomsuv=$listarStatVeh[$i][14];
			$firmaresdomsuv=$listarStatVeh[$i][15];
			$recepresdomsuv=$listarStatVeh[$i][16];
			$polizacons=$listarStatVeh[$i][17];
			$docnot=$listarStatVeh[$i][18];
			$liquidado=$listarStatVeh[$i][19];
			$entregado=$listarStatVeh[$i][20];
			$rechazado=$listarStatVeh[$i][21];
			$nopdi=$listarStatVeh[$i][23];


			$reales1 = $nopdi + $emitidas + $analisis + $esperadoc + $aprobado + $esperacons + $inicialcons + $factuemi + $certifemi + $reservadomsuv + $firmaresdomsuv + $recepresdomsuv + $polizacons + $docnot + $liquidado + $entregado;
			$totaltotal1 = $existentes - $reales1;

     echo  '<tr>
    <td>'.$lote.'</td>
    <td>'.$cantidalot.'</td>
    <td>'.$marca.'</td>
    <td>'.$cantidadmarca.'</td>
    <td>'.$modelo.'</td>
    <td>'.$existentes.'</td>
    <td>'.$vencidas.'</td>
    <td>'.$emitidas.'</td>
    <td>'.$analisis.'</td>
    <td>'.$esperadoc.'</td>
    <td>'.$aprobado.'</td>
    <td>'.$esperacons.'</td>
    <td>'.$inicialcons.'</td>
    <td>'.$factuemi.'</td>
    <td>'.$certifemi.'</td>
    <td>'.$reservadomsuv.'</td>
    <td>'.$firmaresdomsuv.'</td>
    <td>'.$recepresdomsuv.'</td>
    <td>'.$polizacons.'</td>
    <td>'.$docnot.'</td>
    <td>'.$liquidado.'</td>
    <td>'.$entregado.'</td>
    <td>'.$rechazado.'</td>
    <td>'.$nopdi.'</td>
    <td>'.FormatoNum($reales1).'</td>
    <td>'.FormatoNum($totaltotal1).'</td>
 </tr>';
}
echo '<tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="500" colspan="5"><font color="#FFFFFF">TOTALES</font></td>.
     <td>'.$_SESSION['exis'].'</td>
	<td>'.$_SESSION['venc'].'</td>
    <td>'.$_SESSION['emit'].'</td>
    <td>'.$_SESSION['anal'].'</td>
    <td>'.$_SESSION['espera'].'</td>
    <td>'.$_SESSION['aprob'].'</td>
    <td>'.$_SESSION['esperac'].'</td>
    <td>'.$_SESSION['inicial'].'</td>
    <td>'.$_SESSION['factu'].'</td>
    <td>'.$_SESSION['certif'].'</td>
    <td>'.$_SESSION['reser'].'</td>
    <td>'.$_SESSION['firma'].'</td>
    <td>'.$_SESSION['recep'].'</td>
    <td>'.$_SESSION['poliz'].'</td>
    <td>'.$_SESSION['docn'].'</td>
    <td>'.$_SESSION['liq'].'</td>
    <td>'.$_SESSION['ent'].'</td>
    <td>'.$_SESSION['rech'].'</td>
    <td>'.$_SESSION['nopdi'].'</td>
    <td>'.$reales.'</td>
    <td>'.$_SESSION['disponible'].'</td>
  	</tr>';
?>