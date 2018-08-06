<?php

session_start();

header("Content-Description: File Transfer");
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename=listado.csv");

$id=$_GET['id'];

require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/factura.php');
require('../../controlador/funciones.php');
require('../../modelos/pago.php');
require('../../modelos/inventario.php');

$objFactura = new factura();
$objInv = new inventario();
$objPago = new pago();

  $id_numfac=$_GET['id_numfac'];
  $sercarveh=$_GET['sercarveh'];
  $fec=$_GET['fec'];
  $fec2=$_GET['fec2'];
  $codpro = $_GET['codpro'];
  $nombre = $_GET['nombre'];
  $pgActual = $_GET['pagina'];
  $tipo= $_GET['tipo'];
  $estatus = $_GET['estatus'];
  $banco = $_GET['banco'];
  $usuario = $_GET['usuario'];
  $cond = $_GET['cond'];
  $sig = $_GET['sig'];
  $dia = $_GET['dia'];
  $diat = $_GET['diat'];
  $edad = $_GET['edad'];
  $estado = $_GET['estado'];
  $sexo = $_GET['sexo'];
  $codmar	= $_GET['codmar'];
  $desmarveh= $_GET['desmar'];
  $codmodveh= $_GET['codmodveh'];
  $desmod= $_GET['desmod'];
  $codserveh=$_GET['codserveh'];
  $desserveh= $_GET['desserveh'];
  $numlotveh= $_GET['numlotveh'];
  $numplaveh= $_GET['numplaveh'];
  $descdep= $_GET['descdep'];
  $taller=$_GET['taller'];
  $tt=$_GET['tt'];
  $fecE=$_GET['fecE'];
  $fecE2=$_GET['fecE2'];
  $tipoE=$_GET['tipoe'];
  $tipoben=$_GET['tipoben'];
  $fecfacori1=$_GET['fecfacori1'];
  $fecfacori2=$_GET['fecfacori2'];
  $numfacori=$_GET['numfacori'];
  $obsv=$_GET['observ'];

$nroFilas = 24;


if ($_SESSION['idBanco']) {
$listarFactura=$objFactura->listarFacturas_consuelo($id_numfac,$sercarveh,$fec,$fec2,-1,$codpro,$nombre,$tipo,$estatus, $_SESSION['idBanco'] ,$usuario,$cond, $sig, $dia ,$edad ,$estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori,'','','1','',$riflab,$deslab,$obsv); //,'','','1');
}
else
$listarFactura=$objFactura->listarFacturas_consuelo($id_numfac,$sercarveh,$fec,$fec2,-1,$codpro,$nombre,$tipo,$estatus, $banco ,$usuario,$cond, $sig, $dia ,$edad ,$estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori,'','','1','',$riflab,$deslab,$obsv);//,'','','1');


$separador = ";";
$blanco =' ';
$j=0;
$total=$listarFactura;
//echo $total;

for ($i = 0; $i < count($listarFactura); $i+=$nroFilas) {
    $j++;

    $linea= $listarFactura[$i] . $separador . $listarFactura[$i+1] . $separador . $listarFactura[$i+2] . $separador . $blanco . $separador. $listarFactura[$i+3] . $separador . $listarFactura[$i+4] . $separador . $listarFactura[$i+5];
    echo $linea . chr(0x0D) . chr(0x0A);

}

?>