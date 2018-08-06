<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_Facturas_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_Facturas_".date('d/m/Y').".ods");
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

$objReporte= new reportes();

  $numlotveh= $_POST['numlotveh'];
  $codmar	= $_POST['codmar'];
  $codmodveh= $_POST['codmodveh'];
  $condicion = $_POST['cond'];
  $fechaD = $_POST['fechaD'];
  $fechaH = $_POST['fechaH'];
  $status = $_POST['estatus'];
  $banco = $_POST['banco'];

$nroFilas = 5;

$listarCertEmi = $objReporte->cuadroIniConsignadas($numlotveh,$fechaD,$fechaH,$codmar,$codmodveh,$banco);//;cuadroIniConsignadas();

echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="3"><font color="#FFFFFF">LISTAR PAGOS</font></td>
  	</tr>
  	<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="320"><font color="#FFFFFF">Banco</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Personas</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">Monto</td>
  </tr>';

$j=0;
for($j=0;$j<count($listarCertEmi);$j+=3){

echo  '<tr>
    <td>'.$listarCertEmi[$j+2].'</td>
    <td>'.$listarCertEmi[$j].'</td>
    <td>'.FormatoMonto($listarCertEmi[$j+1]).'</td>
</tr>';

$pers=$pers+$listarCertEmi[$j];
$monto=$monto+$listarCertEmi[$j+1];

}
echo'
	<tr class="cabecera">
<th width="15%">Total</th>
<td align="center" title="Personas">'.$pers.'</td>
<td align="center" title="Monto">'.FormatoMonto($monto).'</td>
</tr></table>';
?>