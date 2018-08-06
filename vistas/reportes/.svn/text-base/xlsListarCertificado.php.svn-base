<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_Expedientes_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_Expedientes_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/certificado.php');
require('../../modelos/pago.php');

$objPago = new pago();

$objCertificado = new certificado();

$memo = $objCertificado->listarMemo($_GET['id']);

$data = $objCertificado->listarDetMemo($_GET['id']);

$listarBancos2=$objPago->listarBancos(4,$memo[4]);

	echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1000" colspan="7"><font color="#FFFFFF">LISTADO DETALLE MEMO CERTIFICADO REF. '.str_pad($_GET['id'],6,'0',STR_PAD_LEFT).'</font></td>
  	</tr>
  		<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="10"><font color="#FFFFFF">N#</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">Certificado</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Serial</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Rif</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Nombre</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="300"><font color="#FFFFFF">N# Factura</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fecha Factura</font></td>
  </tr>';

$j=0;
for($i=0;$i<count($data);$i+=19){
	$j++;

echo  '<tr>
    <td>'.$j.'</td>
    <td>'.$data[$i].'</td>
    <td>'.$data[$i+2].'</td>
    <td>'.$data[$i+3].'</td>
    <td>'.$data[$i+4].'</td>
    <td>'.$data[$i+6].'</td>
	<td>'.$data[$i+7].'</td>
  </tr>';
}
echo'<tr>
	<td colspan="12">Total '.$j.' Beneficiarios</td>
</tr></table>';
?>