<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_VehxEdo_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_VehxEdo_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/reportes.php');
require('../../modelos/lotes.php');
require('../../modelos/zona.php');

$objReporte = new reportes();
$objLotes 	= new lotes();
$objZona 	= new zona();

  if ($numlotveh)
  	$numlotveh = $_GET['numlotveh'];
  else
  	$numlotveh = '14';

$listEstados = $objZona->listarEstados();
$nroEdo = count($listEstados)/2;

$listarVehsinEstado = $objReporte->matrizVehsinEstado($numlotveh);

echo '<table width="60%" align="center" class="detalles">

          <tr  class="cabecera">
             <th width="30%" rowspan="2">Estado</th>
             <th width="15%" colspan="5">Modelo</th>
             <th width="15%" rowspan="2">Total</th>
          </tr>
           <tr  class="cabecera">
             <th width="10%">QQ3</th>
             <th width="10%">X1</th>
             <th width="10%">Tiggo</th>
             <th width="15%">Tigger 4*2</th>
             <th width="15%">Tigger 4*4</th>
             </tr>';

for ($i=0;$i<$nroEdo;$i++){
	echo '<tr>
	<td align="left" width="20%">';

	echo $listEstados[($i*2)+1];
	$idEst=$listEstados[$i*2];
	$listarVehxEstado = $objReporte->matrizVehxEstado($numlotveh,$idEst);

	echo '</td>';
	if ($listEstados){
		for($j=0;$j<count($listarVehxEstado);$j+=6){
			echo '<td align="center" title="QQ3">'.$listarVehxEstado[($j*5)+1].'</td>
		          <td align="center" title="x1">'.$listarVehxEstado[($j*5)+2].'</td>
		          <td align="center" title="tiggo">'.$listarVehxEstado[($j*5)+3].'</td>
		          <td align="center" title="tiger 4*2">'.$listarVehxEstado[($j*5)+4] .'</td>
		          <td align="center" title="tiger 4*4">'.$listarVehxEstado[($j*5)+5].'</td>';

			$tbanco=$listarVehxEstado[($j*5)+1]+$listarVehxEstado[($j*5)+2]+$listarVehxEstado[($j*5)+3]+$listarVehxEstado[($j*5)+4]+$listarVehxEstado[($j*5)+5];
			echo'<td align="center" title="tiger 4*4">'.$tbanco.'</td>';

			$tqq=$tqq+$listarVehxEstado[($j*5)+1];
			$tx=$tx+$listarVehxEstado[($j*5)+2];
			$tg=$tg+$listarVehxEstado[($j*5)+3];
			$tg2=$tg2+$listarVehxEstado[($j*5)+4];
			$tg4=$tg4+$listarVehxEstado[($j*5)+5];

		}
	}
    echo'</tr>';
}

	echo '<tr>
	<td align="left">SIN ESTADO</td>';

for($k=0;$k<count($listarVehsinEstado);$k+=6){
    echo '<td align="center" title="QQ3">'.$listarVehsinEstado[($k*5)+1].'</td>
          <td align="center" title="X1">'.$listarVehsinEstado[($k*5)+2].'</td>
          <td align="center" title="tiggo">'.$listarVehsinEstado[($k*5)+3].'</td>
          <td align="center" title="tiger 4*2">'.$listarVehsinEstado[($k*5)+4].'</td>
          <td align="center" title="tiger 4*4">'.$listarVehsinEstado[($k*5)+5].'</td>
	';
          $tbancoc=$listarVehsinEstado[($k*5)+1]+$listarVehsinEstado[($k*5)+2]+$listarVehsinEstado[($k*5)+3]+$listarVehsinEstado[($k*5)+4]+$listarVehsinEstado[($k*5)+5];
	echo '<td align="center" title="Total Sin Estado">'.$tbancoc.'</td>';

$tqqc=$tqqc+$listarVehsinEstado[($k*5)+1];
$txc=$txc+$listarVehsinEstado[($k*5)+2];
$tgc=$tgc+$listarVehsinEstado[($k*5)+3];
$tg2c=$tg2c+$listarVehsinEstado[($k*5)+4];
$tg4c=$tg4c+$listarVehsinEstado[($k*5)+5];
}

$totalQQ = $tqq + $tqqc;
$totalX1 =$tx + $txc;
$totalTig =$tg + $tgc;
$totalT42 =$tg2 + $tg2c;
$totalT44 =$tg4 + $tg4c;
$totalT=$tqq+$tx+$tg+$tg2+$tg4+$tqqc+$txc+$tgc+$tg2c+$tg4c;

   echo '</tr>';
    echo '<tr class="cabecera"><td align="right">Total por modelo</td>
    	  <td align="center">'.$totalQQ.'</td>
    	  <td align="center">'.$totalX1.'</td>
    	  <td align="center">'.$totalTig.'</td>
    	  <td align="center">'.$totalT42.'</td>
    	  <td align="center">'.$totalT44.'</td>
    	  <td align="center">'.$totalT.'</td>
    	  </tr>';

	echo '</table>';
?>