<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_Bitacora_Auditoria_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_Bitacora_Auditoria_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/auditoria.php');
require('../../modelos/usuarios.php');
require('../../controlador/funciones.php');

$objBitacora = new auditoria();
$objUsuario= new usuario();

$listarUsuario=$objUsuario->buscarUsuario();

  $sercarveh = $_GET['sercarveh'];
  $codpro	 = $_GET['codpro'];
  $usuario	 = $_GET['usuario'];
  $fecE      = $_GET['fecE'];
  $fecE2     = $_GET['fecE2'];
  $accion = $_GET['accion'];
  $sentencia = $_GET['sentencia'];

$nroCampos = 9;

$listarAuditoria=$objBitacora->listarAuditoriaBeneficiario($codpro,$sercarveh,$accion,$sentencia,$usuario,$fecE,$fecE2,-1);


echo '<table border="1">
 	 <tr><td ALIGN="center" bgcolor="8C0000" width="1300" colspan="7"><font color="#FFFFFF">LISTADO BITACORA AUDITORIA</font></td></tr>
     <tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="25"><font color="#FFFFFF">N&deg</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="120"><font color="#FFFFFF">Usuario</font></td>
       <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Nombre</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Fecha/Hora</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Accion</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="350"><font color="#FFFFFF">Sentencia</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Formulario</font></td></tr>';



$j=0;
for($i=0;$i<count($listarAuditoria);$i+=$nroCampos){
$j++;
	if ($listarAuditoria[$i]){

		$nombreC=$listarAuditoria[$i+1]." ".$listarAuditoria[$i+2]." ".$listarAuditoria[$i+3]." ".$listarAuditoria[$i+4];
		$fechahora=$listarAuditoria[$i+8]." ".$listarAuditoria[$i+9];

		echo  '<tr>
		    <td>'.$j.'</td>
		    <td>'.$listarAuditoria[$i].'</td>
		    <td>'.$nombreC.'</td>
		    <td>'.$listarAuditoria[$i+5].'</td>
		    <td>'.$listarAuditoria[$i+6].'</td>
		    <td>'.$listarAuditoria[$i+7].'</td>
		    <td>'.$fechahora.'</td>
		  </tr>';
	}

}
echo'<tr>
	<td colspan="7">Total '.$j.' bitacoras</td>
</tr></table>';
?>