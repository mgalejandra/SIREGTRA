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
require('../../modelos/beneficiario.php');

$objPago = new pago();

$objBeneficiario = new beneficiario();

$memo = $objBeneficiario->listarMemo($_GET['id']);

$data = $objBeneficiario->listarDetMemo($_GET['id']);

$listarBancos2=$objPago->listarBancos(4,$memo[4]);


	echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1000" colspan="11"><font color="#FFFFFF">LISTADO DETALLE MEMO REF. '.str_pad($_GET['id'],6,'0',STR_PAD_LEFT).'</font></td>
  	</tr>
  		<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="10"><font color="#FFFFFF">N#</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">CI/RIF</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Primer Nombre</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Segundo Nombre</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Primer Apellido</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="300"><font color="#FFFFFF">Segundo Apellido</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Calle</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Urb</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Edif</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Tlf1</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Tlf2</font></td>
  </tr>';

$j=0;
for($i=0;$i<count($data);$i+=41){
	$j++;

echo  '<tr>
    <td>'.$j.'</td>
    <td>'.$data[$i].'</td>
    <td>'.$data[$i+1].'</td>
    <td>'.$data[$i+2].'</td>
    <td>'.$data[$i+3].'</td>
    <td>'.$data[$i+4].'</td>
	<td>'.$data[$i+7].'</td>
    <td>'.$data[$i+8].'</td>
    <td>'.$data[$i+9].'</td>
    <td>'.$data[$i+14].'</td>
	<td>'.$data[$i+15].'</td>
  </tr>';
}
echo'<tr>
	<td colspan="12">Total '.$j.' Beneficiarios</td>
</tr></table>';
?>