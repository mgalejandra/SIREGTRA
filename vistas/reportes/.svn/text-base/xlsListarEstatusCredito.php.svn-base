<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_EstatusCredito_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_EstatusCredito_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/factura.php');
require('../../controlador/funciones.php');
require('../../modelos/pago.php');
require('../../modelos/zona.php');
require('../../modelos/usuarios.php');
require('../../modelos/acto.php');
require('../../modelos/entrega.php');
require('../../modelos/beneficiario.php');
require('../../modelos/reportes.php');
require('../../modelos/banco.php');
require('../../modelos/estatus.php');

$objFactura = new factura();
$objPago = new pago();
$objZona= new zona();
$objUsuario= new usuario();
$objActo= new acto();
$objBeneficiario=new beneficiario();
$objEnt=new entrega();
$objReporte= new reportes();
$objBanco = new banco();
$objEstatus = new estatus();

  $banco=$_GET['banco'];
  $estatus=$_GET['estatus'];
  $codpro=$_GET['codpro'];
  $fechaD=$_GET['fechaD'];
  $fechaH=$_GET['fechaH'];
  $tipo=$_GET['tipo'];

$listarEstados = $objZona->listarEstados();
$listarBancos=$objPago->listarBancos();
$listarEstatus=$objFactura->listarEstatus();

if ($tipo=='A') $nroCampos = 17;
 else
$nroCampos = 10;

$nroFilas = 15;

$combino = $nroCampos ;

$listarCredito=$objBeneficiario->listarEstatusCredito($banco,$estatus,$codpro,$fechaD,$fechaH,-1,$tipo);

echo ' <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="'.$combino.'"><font color="#FFFFFF">ESTATUS CREDITOS</font></td>
  	  </tr>
  	  <tr>
             <td class="cabeceraI" width="30" bgcolor="8C0000"><font color="#FFFFFF">N&deg;</font></td>
             <td class="cabeceraI"  width="80" bgcolor="8C0000" ><font color="#FFFFFF">RIF</font></td>
              <td class="cabeceraI" width="250" bgcolor="8C0000"><font color="#FFFFFF">Nombre Completo</font></td>
              <td class="cabeceraI" width="250" bgcolor="8C0000"><font color="#FFFFFF">Banco</font></td>
              <td class="cabeceraI" width="150" bgcolor="8C0000"><font color="#FFFFFF">Estatus</font></td>
              <td class="cabeceraI" width="80" bgcolor="8C0000"><font color="#FFFFFF">Usuario Creaci&oacute;n</font></td>
              <td class="cabeceraI" width="80" bgcolor="8C0000"><font color="#FFFFFF">Fecha Creaci&oacute;n</font></td>
              <td class="cabeceraI" width="80" bgcolor="8C0000"><font color="#FFFFFF">Usuario Modificaci&oacute;n</font></td>
              <td class="cabeceraI" width="80" bgcolor="8C0000"><font color="#FFFFFF">Fecha Modificaci&oacute;n</font></td>
              <td class="cabeceraI" width="100" bgcolor="8C0000"><font color="#FFFFFF">Monto</font></td>';

if ($tipo=='A') {
echo        '<td class="cabeceraI"  width="150" bgcolor="8C0000"><font color="#FFFFFF">Serial</font></td>
             <td class="cabeceraI"  width="80" bgcolor="8C0000" ><font color="#FFFFFF">Marca</font></td>
              <td class="cabeceraI" width="150" bgcolor="8C0000"><font color="#FFFFFF">Modelo</font></td>
              <td class="cabeceraI" width="300" bgcolor="8C0000"><font color="#FFFFFF">Banco</font></td>
              <td class="cabeceraI"  width="300" bgcolor="8C0000"><font color="#FFFFFF">Estatus</font></td>
              <td class="cabeceraI" width="50"   bgcolor="8C0000"><font color="#FFFFFF">Lote</font></td>
              <td class="cabeceraI"  width="80" bgcolor="8C0000"><font color="#FFFFFF">Placa</font></td>';
}
echo '</tr>';
/*	echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="'.$combino.'"><font color="#FFFFFF">ESTATUS CREDITOS</font></td>
  	</tr>
  	<tr>
  	<td ALIGN="center" bgcolor="8C0000" width="25"><font color="#FFFFFF">N&deg</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="120"><font color="#FFFFFF">RIF</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="240"><font color="#FFFFFF">Nombre Completo</td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Banco</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Estatus</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Usuario estatus</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fecha estatus</font></td>
  </tr>';*/

$j=0;
for($i=0;$i<count($listarCredito);$i+=$nroCampos){
	$j++;

              /* 	$nombBeneficiario=$objBeneficiario->listarBeneficiario($listarCredito[$i+1]);
               	$nombBanco=$objBanco->listarBancos($listarCredito[$i+2]);
               	$nombEstatus=$objEstatus->listarEstatus($listarCredito[$i+3]);*/

echo  '<tr>
    <td>'.$j.'</td>
    <td>'.$listarCredito[$i+1].'</td>
    <td>'.$listarCredito[$i+8].'</td>
    <td>'.$listarCredito[$i+2].'</td>
    <td>'.$listarCredito[$i+3].'</td>
    <td>'.$listarCredito[$i+4].'</td>
    <td>'.$listarCredito[$i+5].'</td>
    <td>'.$listarCredito[$i+7].'</td>
    <td>'.$listarCredito[$i+9].'</td>
    <td>'.$listarCredito[$i+6].'</td>';
if ($tipo=='A') {
echo '<td>'.$listarCredito[$i+10].'</td>
    <td>'.$listarCredito[$i+11].'</td>
    <td>'.$listarCredito[$i+12].'</td>
    <td>'.$listarCredito[$i+13].'</td>
    <td>'.$listarCredito[$i+14].'</td>
    <td>'.$listarCredito[$i+15].'</td>
    <td>'.$listarCredito[$i+16].'</td>';
}
 echo '</tr>';
}

echo'<tr>
	<td colspan="12">Total '.$j.' Creditos</td>
</tr></table>';
?>