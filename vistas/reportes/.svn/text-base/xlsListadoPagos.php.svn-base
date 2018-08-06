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
require('../../modelos/banco.php');

$objPago = new pago();
$objBanco = new banco();

  $pago=$_GET['num_pag'];
  $banco=$_GET['banco'];
  $fec1=$_GET['fecP'];
  $fec2=$_GET['fec2P'];
  $sercarveh=$_GET['serial'];
  $codpro=$_GET['codpro'];
  $nombre=$_GET['nombre'];
  $codStatus= $_GET['codStatus'];
  $nroFilas =$_GET['fila'];
  $id_caso = $_GET['caso'];
  $tipo=$_GET['tipo'];

$nroCampos = 13;
//$nroFilas = 38;

if ($tipo=='E') $tipoP = "ANULADOS";

$listarPago=$objPago->listarPagos($pago,$banco,$fec1,$fec2,$sercarveh,$codpro,$nombre,$codStatus,-1,$nroFilas,$id_caso,$tipo);

echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="10"><font color="#FFFFFF">LISTAR PAGOS '.$tipoP.'</font></td>
  	</tr>
  	<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">ID Pago</font></td>.
	  <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">N</font></td>
	  <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">Monto</td>
	  <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fecha de Pago</font></td>
	  <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Status</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Banco</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Numero Cuenta</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">RIF</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="250"><font color="#FFFFFF">Nombre</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">Fecha Registro</font></td>
  </tr>';

$j=0;
for($i=0;$i<count($listarPago);$i+=$nroCampos){
	$j++;

        if($listarPago[$i+4]=='E')$statusPago = "EFECTIVO";
                 elseif($listarPago[$i+4]=='A')$statusPago = "ANULADO";
                 elseif($listarPago[$i+4]=='V')$statusPago = "DEVUELTO";
                 elseif($listarPago[$i+4]=='D')$statusPago = "DEPOSITADO";
                 else $statusPago = null;

        $nombreBanco = $objBanco->listarBancos($listarPago[$i+5]);

echo  '<tr>
    <td>'.$listarPago[$i].'</td>
    <td>'.$listarPago[$i+1].'</td>
    <td>'.$listarPago[$i+2].'</td>
    <td>'.$listarPago[$i+3].'</td>
    <td>'.$statusPago.'</td>
    <td>'.$nombreBanco[1].'</td>
    <td>'.$listarPago[$i+6].'</td>
    <td>'.$listarPago[$i+10].'</td>
    <td>'.$listarPago[$i+11].'</td>
    <td>'.$listarPago[$i+12].'</td>
</tr>';
}
echo'<tr>
	<td colspan="9">Total '.$j.' Facturas</td>
</tr></table>';
?>
