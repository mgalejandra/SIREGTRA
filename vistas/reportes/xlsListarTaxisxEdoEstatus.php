<?php
session_start();
$id=$_GET['id'];
$estatus=$_GET['estatus'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_VehxEdo_Estatus".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_VehxEdo_Estatus".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/reportes.php');
require('../../modelos/lotes.php');
require('../../modelos/zona.php');
require('../../modelos/factura.php');

$objReporte = new reportes();
$objLotes 	= new lotes();
$objZona 	= new zona();
$objFactura = new factura();

$listEstados = $objZona->listarEstados();
$nroEdo = count($listEstados)/2;

if ($estatus) $descEstatus=$objFactura->listarEstatus($estatus);

echo '<table width="60%" align="center" class="detalles">
          <tr  class="cabecera">'.$descEstatus[1].'<td></td></tr>
          <tr  class="cabecera">
             <th width="30%" rowspan="2">Estado</th>
             <th width="15%" colspan="6">Lote</th>
             <th width="15%" rowspan="2">Total</th>
          </tr>
           <tr  class="cabecera">
            <th width="10%">25</th>
			<th width="10%">26</th>
			<th width="10%">28</th>
			<th width="10%">29</th>
			<th width="10%">32</th>
			<th width="10%">33</th>
           </tr>';

for ($i=0;$i<$nroEdo;$i++){
	echo '<tr>
	<td align="left" width="20%">';

	echo $listEstados[($i*2)+1];
	$idEst=$listEstados[$i*2];
	$listarVehxEstado = $objReporte->matrizTaxisxEstado1($idEst,$estatus);
	
	echo '</td>';
	if ($listEstados){
		for($j=0;$j<count($listarVehxEstado);$j+=7){
			echo '<td align="center" title="Lote 25">'.$listarVehxEstado[($j*6)+1].'</td>
		          <td align="center" title="Lote 26">'.$listarVehxEstado[($j*6)+2].'</td>
		          <td align="center" title="Lote 28">'.$listarVehxEstado[($j*6)+3].'</td>
		          <td align="center" title="Lote 29">'.$listarVehxEstado[($j*6)+4].'</td>
		          <td align="center" title="Lote 32">'.$listarVehxEstado[($j*6)+5] .'</td>
		          <td align="center" title="Lote 33">'.$listarVehxEstado[($j*6)+6].'</td>';

			$tbanco=$listarVehxEstado[($j*6)+1]+$listarVehxEstado[($j*6)+2]+$listarVehxEstado[($j*6)+3]+$listarVehxEstado[($j*6)+4]+$listarVehxEstado[($j*6)+5]+$listarVehxEstado[($j*6)+6];
			echo'<td align="center" title="Total Estado">'.$tbanco.'</td>';

			$lote25=$lote25+$listarVehxEstado[($j*6)+1];
			$lote26=$lote26+$listarVehxEstado[($j*6)+2];
			$lote28=$lote28+$listarVehxEstado[($j*6)+3];
			$lote29=$lote29+$listarVehxEstado[($j*6)+4];
			$lote32=$lote32+$listarVehxEstado[($j*6)+5];
			$lote33=$lote33+$listarVehxEstado[($j*6)+6];

		}
	}
    echo'</tr>';
}

	echo '<tr>
	<td align="left">SIN ESTADO</td>';
	
	$listarVehsinEstado25 = $objReporte->matrizTaxisSinEstado1(25,$estatus);
	$listarVehsinEstado26 = $objReporte->matrizTaxisSinEstado1(26,$estatus);
	$listarVehsinEstado28 = $objReporte->matrizTaxisSinEstado1(28,$estatus);
	$listarVehsinEstado29 = $objReporte->matrizTaxisSinEstado1(29,$estatus);
	$listarVehsinEstado32 = $objReporte->matrizTaxisSinEstado1(32,$estatus);
	$listarVehsinEstado33 = $objReporte->matrizTaxisSinEstado1(33,$estatus);
	

	echo '<td align="center" title="Lote 25">'.$listarVehsinEstado25[1].'</td>
		          <td align="center" title="Lote 26">'.$listarVehsinEstado26[1].'</td>
		          <td align="center" title="Lote 28">'.$listarVehsinEstado28[1].'</td>
		          <td align="center" title="Lote 29">'.$listarVehsinEstado29[1].'</td>
		          <td align="center" title="Lote 32">'.$listarVehsinEstado32[1].'</td>
		          <td align="center" title="Lote 33">'.$listarVehsinEstado33[1].'</td>';
	
	$lote25c=$lote25c+$listarVehsinEstado25[1];
	$lote26c=$lote26c+$listarVehsinEstado26[1];
	$lote28c=$lote28c+$listarVehsinEstado28[1];
	$lote29c=$lote29c+$listarVehsinEstado29[1];
	$lote32c=$lote32c+$listarVehsinEstado32[1];
	$lote33c=$lote33c+$listarVehsinEstado33[1];
	
	
$totalLote25 = $lote25 + $lote25c;
$totalLote26 =$lote26 + $lote26c;
$totalLote28 =$lote28 + $lote28c;
$totalLote29 =$lote29 + $lote29c;
$totalLote32 =$lote32 + $lote32c;
$totalLote33 =$lote33 + $lote33c;
$totalT=$totalLote25+$totalLote26+$totalLote28+$totalLote29+$totalLote32+$totalLote33;

   echo '</tr>';
    echo '<tr class="cabecera"><td align="right">Total </td>
    	  <td align="center">'.$totalLote25.'</td>
    	  <td align="center">'.$totalLote26.'</td>
    	  <td align="center">'.$totalLote28.'</td>
    	  <td align="center">'.$totalLote29.'</td>
    	  <td align="center">'.$totalLote32.'</td>
    	  <td align="center">'.$totalLote33.'</td>
    	  <td align="center">'.$totalT.'</td>
    	  </tr>';

	echo '</table>';
?>