<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_Beneficiarios_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_Beneficiarios_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/beneficiario.php');
require('../../controlador/funciones.php');
require('../../modelos/pago.php');
require('../../modelos/zona.php');
require('../../modelos/citas.php');
$objBeneficiario = new beneficiario();
$objPago 		= new pago();

$objCita = new citas();
$objZona= new zona();
$buscarEstados = $objZona->buscarEstados($listaBen[36]);
$buscarMunicipio = $objZona->buscarMunicipios($listaBen[37],$listaBen[36]);
$buscarParroquia = $objZona->buscarParroquias($listaBen[38],$listaBen[36],$listaBen[37]);
$listarBancos=$objPago->listarBancos(3);
$listarBeneficiario=$objBeneficiario->listarTipo_benef();

  $rif=$_GET['rif'];
  $nombre=$_GET['nombre'];
  $banco=$_GET['banco'];
  $fec=$_GET['fec'];
  $fec2=$_GET['fec2'];
  $a=$_GET['a'];
  $tipoben=$_GET['tipoben'];
  //echo 'hola'.$a;
//$listaBen=$objBeneficiario->listarBeneficiarios($rif,$nombre,-1,$banco,$fec,$fec2);
if($a==1) {
	$cedula=$objCita->listarCitasCedula($fec,$fec2);
	$a=0;
}

//$listaBen=$objBeneficiario->listarBeneficiarioExp($rif,$nombre,-1,$banco,'','','',$cedula);
$listaBen=$objBeneficiario->listarBeneficiarioExp2($rif,$nombre,-1,$banco,$fec,$fec2,$usuario,$cedula,$tipoben);
if ($listaBen[$i+40]) $datoslistarBancos=$objPago->listarBancos(4,$listaBen[$i+40]);
	$nroFilas = 44;
	if ($listaBen[35]=='7'){$tipo= "OTROS " ; }
   if ($listaBen[35]=='6'){$tipo= "FUNCIONARIO PUBLICO" ; }
   if ($listaBen[35]=='5'){$tipo= "PERSONAL MILITAR" ; }
   if ($listaBen[35]=='4'){$tipo= "EDUCADORES" ; }
   if ($listaBen[35]=='3'){$tipo= "MEDICOS Y ENFERMERAS" ; }
   if ($listaBen[35]=='2'){$tipo= "VICTIMA DE ESTAFA" ; }
   if ($listaBen[35]=='1'){$tipo= "DISCAPACIDAD" ; }

	echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1000" colspan="12"><font color="#FFFFFF">LISTADO DE BENEFICIARIOS</font></td>
  	</tr>
  		<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="10"><font color="#FFFFFF">N&deg</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">CI/RIF</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Nombre completo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Sexo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fecha_Nac</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="300"><font color="#FFFFFF">Domicilio Fiscal</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Nro Telefono 1</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Nro Telefono 2</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Banco</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Usuario</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Tipo Beneficiario</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fecha Registro</font></td>
  </tr>';

$j=0;
for($i=0;$i<count($listaBen);$i+=$nroFilas){
	$j++;

echo  '<tr>
    <td>'.$j.'</td>
    <td>'.$listaBen[$i].'</td>
    <td>'.$listaBen[$i+6].'</td>
    <td>'.$listaBen[$i+34].'</td>
    <td>'.$listaBen[$i+39].'</td>
    <td>'.$listaBen[$i+7].' '.$listaBen[$i+8].' '.$listaBen[$i+9].' Piso '.$listaBen[$i+10].' Apto. '.$listaBen[$i+11].'</td>
    <td>'.$listaBen[$i+14].'</td>
    <td>'.$listaBen[$i+15].'</td>
    <td>'.$listaBen[$i+41].'</td>
	<td>'.$listaBen[$i+42].'</td>
    <td>'.$listaBen[$i+43].'</td><td>'.$listaBen[$i+18].'</td>
  </tr>';
}
echo'<tr>
	<td colspan="12">Total '.$j.' Beneficiarios</td>
</tr></table>';
?>