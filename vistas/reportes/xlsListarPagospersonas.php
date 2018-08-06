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

  $banco=$_GET['banco'];
  $codpro=$_GET['codpro'];
  $nombre=$_GET['nombre'];
  $pgActual = $_POST['pagina'];
  $fecP=$_GET['fecP'];
  $fec2P=$_GET['fec2R'];

$nroCampos = 6;
$nroFilas = 38;

$listarFactura=$objReporte->listaPagospersonas(-1,$banco,$codpro,$nombre,$fecP,$fec2P);

echo '<table border="1">';

if (($fecP) or ($fec2P)){
  echo' <TR>
          <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="6"><font color="#FFFFFF">';
             if (($fecP) and !($fec2P)){echo 'Desde: '.$fecP;}
             if (($fecP) and ($fec2P)){echo 'Desde: '.$fecP.' Hasta:'.$fec2P;}
             if (!($fecP) and !($fec2P)){echo 'Hasta: '.$fec2P;}
   echo'</font></td>
        </TR>';

}

echo' 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="6"><font color="#FFFFFF">LISTAR PAGOS</font></td>
  	</tr>
  	<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="25"><font color="#FFFFFF">N</font></td>
	  <td ALIGN="center" bgcolor="8C0000" width="320"><font color="#FFFFFF">Nombre Completo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Cedula</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">Monto</td>
      <td ALIGN="center" bgcolor="8C0000" width="140"><font color="#FFFFFF">Modelo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="320"><font color="#FFFFFF">Banco</font></td>
  </tr>';

$j=0;
for($i=0;$i<count($listarFactura);$i+=$nroCampos){
	$j++;

echo  '<tr>
    <td>'.$j.'</td>
    <td>'.$listarFactura[$i+1].'</td>
    <td>'.$listarFactura[$i+2].'</td>
    <td>'.$listarFactura[$i+3].'</td>
    <td>'.$listarFactura[$i+4].'</td>
    <td>'.$listarFactura[$i+5].'</td>

</tr>';
}
echo'<tr>
	<td colspan="12">Total '.$j.' Facturas</td>
</tr></table>';
?>
