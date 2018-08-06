<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_Beneficiarios_Citas_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_Beneficiarios_Citas_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/citas.php');
require('../../modelos/usuarios.php');

$objBeneficiarioCit = new citas();
$objUsuario = new usuario();

  $rif=$_GET['rif'];
  $nombre=$_GET['nombre'];
  $fec=$_GET['fec'];
  $usuario=$_GET['usuario'];
  $correo=$_GET['correo'];

  $nroFilas = 20;
  $nroCampos = 14;
  $combino= 12;

  $listaBen=$objBeneficiarioCit->buscarBenefCitas($rif,$nombre,$fec,$usuario,-1,$correo);

	echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1000" colspan="'.$combino.'"><font color="#FFFFFF">LISTADO DE CITAS</font></td>
  	</tr>
  		<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="20"><font color="#FFFFFF">N&deg</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="90"><font color="#FFFFFF">RIF</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="300"><font color="#FFFFFF">Nombre</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Tel&eacute;fonos</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Correo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Sexo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fecha Reg. Benef.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Usuario</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fecha Cita</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Turno</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fecha Reg. Cita</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Tipo</font></td>';

$j=0;
for($i=0;$i<count($listaBen);$i+=$nroCampos){
	$j++;

    $rif = $listaBen[$i+2].''.$listaBen[$i+1].''.$listaBen[$i];
    $telefonos = $listaBen[$i+4].'  '.$listaBen[$i+5];

      if ($listaBen[$i+13]<>'1') $tipo= "Persona con Discapacidad";
      else $tipo = "No discapacitado";

      if ($listaBen[$i+7]=='F') $sexo = "Femenino";
      else $sexo = "Masculino";

echo  '<tr>
    <td>'.$j.'</td>
    <td>'.$rif.'</td>
    <td>'.$listaBen[$i+3].'</td>
    <td>'.$telefonos.'</td>
    <td>'.$listaBen[$i+6].'</td>
    <td>'.$sexo.'</td>
    <td>'.$listaBen[$i+12].'</td>
    <td>'.$listaBen[$i+8].'</td>
    <td>'.$listaBen[$i+9].'</td>
    <td>'.utf8_decode($listaBen[$i+10]).'</td>
    <td>'.$listaBen[$i+11].'</td>
    <td>'.$tipo.'</td></tr>';

}
echo'<tr>
	<td colspan="12">Total '.$j.' Beneficiarios</td>
</tr></table>';
?>