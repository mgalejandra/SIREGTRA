<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_Vehiculos_sin_placa_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_Vehiculos_sin_placa_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/vehiculos.php');

$objVehiculo = new vehiculos();

  $sercarveh=$_GET['sercarveh'];
  $codmar=$_GET['marca'];
  $modveh=$_GET['modelo'];
  $lote=$_GET['lote'];
  $color=$_GET['color'];

$nroFilas = 25;
$nroCampos = 17;

$listVehiculos = $objVehiculo->listVehsinplaca($codmar,$modveh,$sercarveh,$lote,$color,-1);
$contArt = count($listVehiculos)/$nroCampos;

echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1000" colspan="8"><font color="#FFFFFF">LISTADO VEHICULOS SIN PLACA</font></td>
  	</tr>
  	<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="50"><font color="#FFFFFF">Lote</font></td>
	  <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Factura</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Serial de Carr.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Serial de Motor</td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Color</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Serial de NIV</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Marca</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Modelo</font></td>
  </tr>';

$j=0;
for($i=0;$i<count($listVehiculos);$i+=$nroCampos){

echo  '<tr>
    <td>'.$listVehiculos[$i+16].'</td>
    <td>'.$listVehiculos[$i+12].'</td>
    <td>'.$listVehiculos[$i].'</td>
    <td>'.$listVehiculos[$i+1].'</td>
    <td>'.$listVehiculos[$i+2].'</td>
    <td>'.$listVehiculos[$i+3].'</td>
    <td>'.$listVehiculos[$i+14].'</td>
    <td>'.$listVehiculos[$i+15].'</td>
</tr>';
}
echo'<tr>
	<td colspan="8">Total '.$contArt.' vehiculos sin placa</td>
</tr></table>';
?>