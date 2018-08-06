<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_reclamos_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_reclamos_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require ('../../modelos/fpdf/crearPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/reclamos.php');
require('../../modelos/beneficiario.php');
require('../../modelos/pago.php');
require('../../modelos/concesionario.php');


$objBeneficiario=new beneficiario();
$objReclamo= new reclamos();
$objPago = new pago();
$objConcesionario= new concesionario();



  $id_reclamo=$_GET['idreclamo'];
  $sercarveh=$_GET['idsercarveh'];
  $fec=$_GET['fec'];
  $fec2=$_GET['fec2'];
  $codpro=$_GET['codpro'];
  $nombre=$_GET['nombre'];
  $sexo=$_GET['sexo'];
  $descripcion=$_GET['descr'];
  $respuesta=$_GET['resp'];

  $fecha=date('d/m/Y');

$nroFilas = 15;
$nroCampos = 18;

$listarReclamos = $objConcesionario->listarReclamosConc($_SESSION['id_concesionario'],$fec,$codpro,-1,$id_reclamo,$sercarveh,$fec2,$nombre,$sexo,$descripcion,$codmar,$codmodveh,$codserveh,$respuesta);

$contArt = count($listarReclamos)/$nroCampos;

echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1000" colspan="10"><font color="#FFFFFF">LISTADO RECLAMOS DEL '.$fecha.'</font></td>
  	</tr>
  	<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">N&deg; Reclamo</font></td>
	  <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Fecha</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Cod. Ben</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Beneficiario</td>
      <td ALIGN="center" bgcolor="8C0000" width="250"><font color="#FFFFFF">Tel&eacute;fonos</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">Tipo Reclamo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="90"><font color="#FFFFFF">Serial Carr.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="90"><font color="#FFFFFF">Descripci&oacute;n</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="90"><font color="#FFFFFF">Respuesta</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="90"><font color="#FFFFFF">Fecha mod.</font></td>
  </tr>';

$j=0;

for($i=0;$i<count($listarReclamos);$i+=$nroCampos){

$telefonos = $listarReclamos[$i+11]." ".$listarReclamos[$i+12];
$tipoR = $objConcesionario->listarTipoRC($listarReclamos[$i+7]);

echo  '<tr>
    <td>'.str_pad($listarReclamos[$i],5,'0',STR_PAD_LEFT).'</td>
    <td>'.$listarReclamos[$i+6].'</td>
    <td>'.$listarReclamos[$i+1].'</td>
    <td>'.$listarReclamos[$i+14].'</td>
    <td>'.$telefonos.'</td>
    <td>'.$tipoR[1].'</td>
    <td>'.$listarReclamos[$i+8].'</td>
    <td>'.$listarReclamos[$i+9].'</td>
    <td>'.$listarReclamos[$i+10].'</td>
    <td>'.$listarReclamos[$i+16].'</td>
</tr>';
}
echo'<tr>
	<td colspan="8">Total '.$contArt.' reclamos</td>
</tr></table>';
?>