<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_placas_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_placas_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/placas.php');

$objPlacas = new placas();

  $sercarveh=$_GET['idsercarveh'];
  $codmar=$_GET['marca'];
  $modveh=$_GET['modelo'];
  $lote=$_GET['lote'];
  $placa=$_GET['placa'];
  $estado=$_GET['estado'];

$nroFilas = 15;
$nroCampos = 12;

//$listVehiculos = $objVehiculo->listVehsinplaca($codmar,$modveh,$sercarveh,$lote,$color,-1);
$listPlacas=$objPlacas->listadoPlacasColor($sercarveh,$placa,$estado,-1,$_SESSION['numeDepa'],$lote,$codmar,$modveh);

$contArt = count($listPlacas)/$nroCampos;

echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1000" colspan="8"><font color="#FFFFFF">LISTADO PLACAS</font></td>
  	</tr>
  	<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Marca</font></td>
	  <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Modelo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Serial de Carr.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Placa</td>
      <td ALIGN="center" bgcolor="8C0000" width="250"><font color="#FFFFFF">Estado</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">N&uacute;mero de R&aacute;faga</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="90"><font color="#FFFFFF">Fecha de R&aacute;faga</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="90"><font color="#FFFFFF">Color</font></td>
  </tr>';

$j=0;
for($i=0;$i<count($listPlacas);$i+=$nroCampos){

echo  '<tr>
    <td>'.$listPlacas[$i+9].'</td>
    <td>'.$listPlacas[$i+10].'</td>
    <td>'.str_pad($listPlacas[$i],3,'0',STR_PAD_LEFT).'</td>
    <td>'.$listPlacas[$i+1].'</td>
    <td>'.$listPlacas[$i+3].'</td>
    <td>'.$listPlacas[$i+4].'</td>
    <td>'.$listPlacas[$i+5].'</td>
    <td>'.$listPlacas[$i+11].'</td>
</tr>';
}
echo'<tr>
	<td colspan="8">Total '.$contArt.' placas</td>
</tr></table>';
?>