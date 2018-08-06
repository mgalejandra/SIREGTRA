<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_FacturasOrig_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_FacturasOrig_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/reportes.php');
require('../../modelos/pago.php');
require('../../modelos/usuarios.php');
require('../../modelos/vehiculos.php');

 $objFactura = new reportes();
 $objPago = new pago();
 $objUsuario= new usuario();
 $objVehiculo = new vehiculos();

 $listarBancos=$objPago->listarBancos(3);
 $listarUsuario=$objUsuario->buscarUsuario();

  $codpro	= $_GET['codpro'];
 $nombre	= $_GET['nombre'];
 $codmodveh = $_GET['codmodveh'];
 $marca = $_GET['codmar'];
 $estado=$_GET['estado'];
 $numfacori=$_GET['numfacori'];
 $fecD=$_GET['fecfacori1'];
 $fecH=$_GET['fecfacori2'];
 $numplaveh=$_GET['numplaveh'];
 $numlotveh=$_GET['numlotveh'];
 $usuario=$_GET['usuario'];
 $banco= $_GET['banco'];


$nroFilas = 20;
$nroCampos = 16;

$listarFacturas=$objFactura->resumenFacturasOriginales($codpro,$nombre,$marca,$fecD,$fecH,$codmodveh,$numlotveh,$banco,$numfacori,$usuario,-1);


$contArt = count($listarFacturas)/$nroCampos;

echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1000" colspan="12"><font color="#FFFFFF">LISTADO FACTURAS ORIGINALES</font></td>
  	</tr>
  	<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="40"><font color="#FFFFFF">N&deg;</font></td>
	  <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">CI/RIF Benef.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Beneficiario</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Telefonos</td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Marca</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Modelo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Lote</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Serial</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Nro. Fact</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Usuario Fact.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Fecha Fact.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Monto</font></td>
  </tr>';

$j=0;
for($i=0;$i<count($listarFacturas);$i+=$nroCampos){
	$precio = $objVehiculo->precioVehiculo($listarFacturas[$i+12]);
    $nreg=($i/$nroCampos)+1;

echo  '<tr>
    <td>'.$nreg.'</td>
    <td>'.$listarFacturas[$i+5].'</td>
    <td>'.$listarFacturas[$i+6].'</td>
    <td>'.$listarFacturas[$i+7]." ".$listarFacturas[$i+8].'</td>
    <td>'.$listarFacturas[$i+10].'</td>
    <td>'.$listarFacturas[$i+11].'</td>
    <td>'.$listarFacturas[$i+9].'</td>
    <td>'.$listarFacturas[$i+12].'</td>
    <td>'.$listarFacturas[$i+3].'</td>
    <td>'.$listarFacturas[$i+13]." ".$listarFacturas[$i+14]." (".$listarFacturas[$i+1].")".'</td>
    <td>'.$listarFacturas[$i+4].'</td>
    <td>'.$precio.'</td>
</tr>';
}
echo'<tr>
	<td colspan="8">Total '.$contArt.' facturas originales</td>
</tr></table>';
?>