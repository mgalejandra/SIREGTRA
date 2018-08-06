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
require('../../modelos/banco.php');

$objCita = new citas();
$objBanco = new banco();

  $rif=$_GET['rif'];
  $nombre=$_GET['nombre'];
  $cita=$_GET['cita'];
  $fec=$_GET['fec'];
  $fec2=$_GET['fec2'];

  if ($_SESSION['tipoUsuario']==17)
  	$a = 1;
  else
	$a = 0;

  $nroFilas = 20;
  $nroCampos = 23;

  //echo 'hola'.$a;

$listarCitas=$objCita->listarCitasUsuario($nombre,$rif,$fec,$fec2,$cita,-1,$a);
if ($_SESSION['tipoUsuario']==17) $fecha = date('d/m/Y');
else $fecha= $fec;


	echo '<table border="1">
	 <tr>
  	  <td ALIGN="center" width="1000" colspan="9"><strong>'.utf8_decode("ATENCIÓN AL USUARIO/DIRECCIÓN DE VEHÍCULOS").'</strong></td>
  	</tr>
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1000" colspan="9"><font color="#FFFFFF">LISTADO DE CARPETAS RECIBIDAS EN FECHA '.$fecha.'</font></td>
  	</tr>
  		<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="20"><font color="#FFFFFF">N&deg</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="90"><font color="#FFFFFF">RIF</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="300"><font color="#FFFFFF">Nombre completo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Sexo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fecha Nac.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="300"><font color="#FFFFFF">Domicilio</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Nro. Telf. 1</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Nro. Telf. 2</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="300"><font color="#FFFFFF">Banco</font></td>
      </tr>';

$j=0;
for($i=0;$i<count($listarCitas);$i+=$nroCampos){
	$j++;
	$turno=$objCita->descrTurno($listarCitas[$i+4]);
	$nombreB= $objBanco->listarBancos($listarCitas[$i+22]);


	/*if ($listarCitas[$i+6]=='A') $asistencia="Pendiente";
	elseif ($listarCitas[$i+6]=='S') $asistencia="Asistio";
	elseif ($listarCitas[$i+6]=='V') $asistencia="Vencida";*/
	$domicilio = $listarCitas[$i+13]."".$listarCitas[$i+14]."".$listarCitas[$i+15]."".$listarCitas[$i+16]."".$listarCitas[$i+17]."".$listarCitas[$i+18]."".$listarCitas[$i+19];

echo  '<tr>
    <td>'.$j.'</td>
    <td>'.$listarCitas[$i+10].$listarCitas[$i+9].$listarCitas[$i+7].'</td>
    <td>'.$listarCitas[$i+8].'</td>
    <td>'.$listarCitas[$i+11].'</td>
    <td>'.$listarCitas[$i+12].'</td>
    <td>'.$domicilio.'</td>
    <td>'.$listarCitas[$i+20].'</td>
    <td>'.$listarCitas[$i+21].'</td>
    <td>'.$nombreB[2].'</td>
    </tr>';
}
echo'<tr>
	<td colspan="12">Total '.$j.' Beneficiarios</td>
</tr></table>';
?>