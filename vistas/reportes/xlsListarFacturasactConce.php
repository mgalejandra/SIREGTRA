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

$objFactura = new factura();

  $id_numfac=$_GET['id_numfac'];
  $sercarveh=$_GET['sercarveh'];
  $fec=$_GET['fec'];
  $fec2=$_GET['fec2'];
  $codpro = $_GET['codpro'];
  $nombre = $_GET['nombre'];
  $pgActual = $_GET['pagina'];
  $estatus = $_GET['estatus'];
  $banco = $_GET['banco'];
  $cond = $_GET['cond'];
  $sig = $_GET['sig'];
  $estado = $_GET['estado'];
  $sexo = $_GET['sexo'];
  $codmar	= $_GET['codmar'];
  $desmarveh= $_GET['desmar'];
  $codmodveh= $_GET['codmodveh'];
  $desmod= $_GET['desmod'];
  $numlotveh= $_GET['numlotveh'];
  $numplaveh= $_GET['numplaveh'];
  $descdep= $_GET['descdep'];
  $fecE=$_GET['fecE'];
  $fecE2=$_GET['fecE2'];
  $tipoben=$_GET['tipoben'];
  $fecfacori1=$_GET['fecfacori1'];
  $fecfacori2=$_GET['fecfacori2'];
  $numfacori=$_GET['numfacori'];
  $obsv=$_GET['observ'];

    $nroFilas = 16;



if ($_SESSION['idBanco']) {
$listarFactura=$objFactura->listarFacturas_conce($id_numfac,$sercarveh,$fec,$fec2,-1,$codpro,$nombre,$tipo,$estatus,$_SESSION['idBanco'],$cond, $sig,$estado,$sexo,$codmar,$codmodveh,$numlotveh,$numplaveh,$fecE,$fecE2,$tipoben,$fecfacori1,$fecfacori2,$numfacori,'','','1','',$obsv);
}
else
$listarFactura=$objFactura->listarFacturas_conce($id_numfac,$sercarveh,$fec,$fec2,-1,$codpro,$nombre,$tipo,$estatus,$banco,$cond, $sig,$estado,$sexo,$codmar,$codmodveh,$numlotveh,$numplaveh,$fecE,$fecE2,$tipoben,$fecfacori1,$fecfacori2,$numfacori,'','','1','',$obsv);



	echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="18"><font color="#FFFFFF">LISTADO DE VEHICULOS PARA EL ACTO</font></td>'.'
  	</tr>
  		<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">N#</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Etiqueta</font></td>
      <td ALIGN="center" bgcolor="8C0000"  width="250"><font color="#FFFFFF">Nombre</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Rif</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Modelo</td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Color</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Placa</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Serial</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Banco</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Tlf1</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Tlf2</font></td>
      <td ALIGN="center" bgcolor="8C0000"  width="250"><font color="#FFFFFF">Estatus</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Lote</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Tipo de Beneficiario</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Fecha de Estatus</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Hora Estatus</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Observacion</font></td>
      <td ALIGN="center" bgcolor="8C0000"  width="150"><font color="#FFFFFF">Ubicacion</font></td>
  </tr>';

$j=0;
for($i=0;$i<count($listarFactura);$i+=$nroFilas){
	$j++;


    if ($listarFactura[$i+10]=='14') $lote = "Chery 1";
	elseif ($listarFactura[$i+10]=='15') $lote = "Chery 2";
	elseif ($listarFactura[$i+10]=='16') $lote = "Chery 3";
	else $lote = "Chery 4";

if ($listarFactura[$i+2]=='0'){
	$listarFactura[$i+25]=$listarFactura[$i+45];
}

if ((($listarFactura[$i+2]=='QQ3') OR ($listarFactura[$i+2]=='X1')  OR ($listarFactura[$i+2]=='TIGGO')) AND ($listarFactura[$i+10]=='14'))
		                      	$ubicacion= "Base Sucre";

if ((($listarFactura[$i+2]=='QQ3') OR ($listarFactura[$i+2]=='X1')  OR ($listarFactura[$i+2]=='TIGGO')) AND ($listarFactura[$i+10]=='15'))
		                      	$ubicacion= "Base Libertador";

if (($listarFactura[$i+2]=='GRAND TIGER 4X2') OR ($listarFactura[$i+2]=='GRAND TIGER 4X4'))
		             	    	$ubicacion= "Base Sucre";



echo  '<tr>
   <td>'.$j.'</td>
    <td>'.$listarFactura[$i+14].'</td>
    <td>'.$listarFactura[$i].'</td>
    <td>'.$listarFactura[$i+1].'</td>
    <td>'.$listarFactura[$i+2].'</td>
    <td>'.$listarFactura[$i+3].'</td>
    <td>'.$listarFactura[$i+4].'</td>
    <td>'.$listarFactura[$i+5].'</td>
    <td>'.$listarFactura[$i+6].'</td>
    <td>'.$listarFactura[$i+7].'</td>
    <td>'.$listarFactura[$i+8].'</td>
    <td>'.$listarFactura[$i+9].'</td>
    <td>'.$lote.'</td>
    <td>'.$listarFactura[$i+11].'</td>
    <td>'.$listarFactura[$i+12].'</td>
    <td>'.$listarFactura[$i+13].'</td>
    <td>'.$listarFactura[$i+15].'</td>
    <td>'.$ubicacion.'</td>
   	</tr>';
}
echo'<tr>
	<td colspan="12">Total '.$j.' Facturas</td>
</tr></table>';
?>