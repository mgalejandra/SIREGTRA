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
  $numlotveh=$_GET['lote'];
  $color=$_GET['color'];
  $asigna = $_GET['asigna'];
  $placa = $_GET['placa'];


$nroFilas = 25;

if ($asigna=='AS'){
	$nroCampos = 13;
	$nroCampos1 = 13;
}
else{
	$nroCampos = 8;
	$nroCampos1 = 8;
}

$listVehiculos = $objVehiculo->listVehNoPDI($codmar,$modveh,$sercarveh,$numlotveh,$color,$asigna,-1,$placa);

$contArt = count($listVehiculos)/$nroCampos;

echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1000" colspan="'.$nroCampos1.'"><font color="#FFFFFF">LISTADO VEHICULOS PDI NO APROBADO</font></td>
  	</tr>
  	<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="50"><font color="#FFFFFF">Lote</font></td>
	  <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Marca</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Modelo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Serial de Carr.</td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Serial de NIV</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Color</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Placa</font></td>';

if ($asigna=='AS'){
 			echo '<td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">ID. Asig.</font></td>
 				<td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Est. Asig.</font></td>
 				<td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">C.I. Benef.</font></td>
 				<td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Estatus - Fecha</font></td>';
}
echo '<td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Observacion</font></td></tr>';

$j=0;
for($i=0;$i<count($listVehiculos);$i+=$nroCampos){

echo  '<tr>
    <td>'.$listVehiculos[$i].'</td>
    <td>'.$listVehiculos[$i+1].'</td>
    <td>'.$listVehiculos[$i+2].'</td>
    <td>'.$listVehiculos[$i+3].'</td>
    <td>'.$listVehiculos[$i+4].'</td>
    <td>'.$listVehiculos[$i+5].'</td>
    <td>'.$listVehiculos[$i+6].'</td>';


 if ($asigna=='AS'){
 	echo '<td>'.$listVehiculos[$i+7].'</td>
 				<td>'.$listVehiculos[$i+8].'</td>
 				<td>'.$listVehiculos[$i+9].'</td>
 				<td>'.$listVehiculos[$i+10].' - '.$listVehiculos[$i+11].'</td>';
 }

 if ($asigna=='AS'){
 	echo '<td>'.$listVehiculos[$i+12].'</td>';
 }
 else
 {
 	echo '<td>'.$listVehiculos[$i+7].'</td>';
 }

echo '</tr>';
}
echo'<tr>
	<td colspan="'.$nroCampos1.'">Total '.$contArt.' vehiculos - PDI no aprobado</td>
</tr></table>';
?>