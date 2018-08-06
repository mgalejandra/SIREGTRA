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
require('../../modelos/banco.php');

$objReporte= new reportes();
$objBanco = new banco();

  $num_pag=$_GET['num_pag'];
  $num_cuen=$_GET['num_cuen'];
  $fecP=$_GET['fecP'];
  $fec2P=$_GET['fec2P'];
  $fecR=$_GET['fecR'];
  $fec2R=$_GET['fec2R'];
  $banco=$_GET['banco'];
  $codpro=$_GET['codpro'];
  $nombre=$_GET['nombre'];
  $tipo=$_GET['tipo'];
  $numlotveh=$_GET['lote'];
  $bancoC=$_GET['bancoC'];
  $cond=$_GET['cond'];

  $pgActual = $_POST['pagina'];

    if ($bancoC)
  		$listarBancosC=$objBanco->listarBancos('','',$bancoC);

$nroCampos = 15;
$nroFilas = 38;

if ($tipo=='E') $tipoP = "ANULADOS";

//$listarFactura=$objReporte->listaPago(-1,$num_pag,$num_cuen,$fecP,$fec2P,$fecR,$fec2R,$banco,$codpro,$nombre,$tipo,$lote);
$listarFactura=$objReporte->listaPago(-1,$num_pag,$fnum_cuen,$fecP,$fec2P,$fecR,$fec2R,$banco,$codpro,$nombre,$tipo,$numlotveh,$listarBancosC[0],$cond);


if ($_SESSION['tipoUsuario']==17) $combino=12;
else $combino=14;

echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="'.$combino.'"><font color="#FFFFFF">LISTAR PAGOS '.$tipoP.'</font></td>
  	</tr>
  	<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="25"><font color="#FFFFFF">N</font></td>
	  <td ALIGN="center" bgcolor="8C0000" width="50"><font color="#FFFFFF">ID Pago</font></td>
	  <td ALIGN="center" bgcolor="8C0000" width="320"><font color="#FFFFFF">Nombre Completo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Cedula</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">Monto</td>';

if ($_SESSION['tipoUsuario']<>17)
	echo '<td ALIGN="center" bgcolor="8C0000" width="140"><font color="#FFFFFF">Modelo</font></td>';

echo '<td ALIGN="center" bgcolor="8C0000" width="320"><font color="#FFFFFF">Banco Credito</font></td>';

if ($_SESSION['tipoUsuario']<>17)
	echo'<td ALIGN="center" bgcolor="8C0000" width="140"><font color="#FFFFFF">Estatus Veh</font></td>';

echo '
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Numero de Pago</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Numero Cuenta</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="320"><font color="#FFFFFF">Banco Pago</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fecha de Pago</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fecha de Registro</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Cond. Pago</font></td>
  </tr>';



$j=0;
for($i=0;$i<count($listarFactura);$i+=$nroCampos){
	$j++;

echo  '<tr>
    <td>'.$j.'</td>
    <td>'.$listarFactura[$i+14].'</td>
    <td>'.$listarFactura[$i+1].'</td>
    <td>'.$listarFactura[$i+9].'</td>
    <td>'.$listarFactura[$i+2].'</td>';

if ($_SESSION['tipoUsuario']<>17) echo '<td>'.$listarFactura[$i+3].'</td>';

echo '<td>'.$listarFactura[$i+12].'</td>';

if ($_SESSION['tipoUsuario']<>17) echo '<td>'.$listarFactura[$i+11].'</td>';

echo '<td>'.$listarFactura[$i+5].'</td>
    <td>'.$listarFactura[$i+6].'</td>
    <td>'.$listarFactura[$i+7].'</td>
    <td>'.$listarFactura[$i+8].'</td>
    <td>'.$listarFactura[$i+4].'</td>
    <td>'.$listarFactura[$i+13].'</td>
</tr>';
}
echo'<tr>
	<td colspan="12">Total '.$j.' Facturas</td>
</tr></table>';
?>