<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_Citas_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_Citas_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../controlador/funciones.php');
require('../../modelos/beneficiario.php');
require('../../modelos/citas.php');
require('../../modelos/pago.php');

$objCita = new citas();

  $rif=$_GET['rif'];
  $nombre=$_GET['nombre'];
  $cita=$_GET['cita'];
  $fec=$_GET['fec'];
  $fec2=$_GET['fec2'];
  $ipcli=$_GET['ipcli'];

  if ($_SESSION['tipoUsuario']==17)
  {
  	$a = 1;
  	$combino=8;
  }
  else
{
	$a = 0;
	$combino=9;
}

  $nroFilas = 20;
  $nroCampos = 25;

  //echo 'hola'.$a;

  $listarCitas=$objCita->listarCitasUsuario($nombre,$rif,$fec,$fec2,$cita,$ipcli,-1,$a);



	echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1000" colspan="'.$combino.'"><font color="#FFFFFF">LISTADO DE CITAS</font></td>
  	</tr>
  		<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="20"><font color="#FFFFFF">N&deg</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="90"><font color="#FFFFFF">RIF</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="300"><font color="#FFFFFF">Nombre completo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fecha Solicitud</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fecha Cita</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Turno</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Asisti&oacute;</font></td>';

if ($_SESSION['tipoUsuario']<>'17') echo  '<td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">IP</font></td>';

echo '<td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Usuario</font></td></tr>';

$j=0;
for($i=0;$i<count($listarCitas);$i+=$nroCampos){
	$j++;
	$turno=$objCita->descrTurno($listarCitas[$i+4]);

	if ($listarCitas[$i+6]=='A') $asistencia="Pendiente";
	elseif ($listarCitas[$i+6]=='S') $asistencia="Asistio";
	elseif ($listarCitas[$i+6]=='V') $asistencia="Vencida";

echo  '<tr>
    <td>'.$j.'</td>
    <td>'.$listarCitas[$i+10].$listarCitas[$i+9].$listarCitas[$i+7].'</td>
    <td>'.$listarCitas[$i+8].'</td>
    <td>'.$listarCitas[$i+1].'</td>
    <td>'.$listarCitas[$i+5].'</td>
    <td>'.utf8_decode($turno[1]).'</td>
    <td>'.$asistencia.'</td>';

if ($_SESSION['tipoUsuario']<>'17') echo  '<td>'.utf8_decode($listarCitas[$i+23]).'</td>';

echo '<td>'.$listarCitas[$i+24].'</td></tr>';
}
echo'<tr>
	<td colspan="12">Total '.$j.' Beneficiarios</td>
</tr></table>';
?>