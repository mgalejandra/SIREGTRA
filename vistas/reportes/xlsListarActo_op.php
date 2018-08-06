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
require('../../modelos/inventario.php');

$objFactura = new factura();
$objInv = new inventario();
$objPago = new pago();

  $id_numfac=$_GET['id_numfac'];
  $sercarveh=$_GET['sercarveh'];
  $fec=$_GET['fec'];
  $fec2=$_GET['fec2'];
  $codpro = $_GET['codpro'];
  $nombre = $_GET['nombre'];
  $pgActual = $_GET['pagina'];
  $tipo= $_GET['tipo'];
  $estatus = $_GET['estatus'];
  $banco = $_GET['banco'];
  $usuario = $_GET['usuario'];
  $cond = $_GET['cond'];
  $sig = $_GET['sig'];
  $dia = $_GET['dia'];
  $diat = $_GET['diat'];
  $edad = $_GET['edad'];
  $estado = $_GET['estado'];
  $sexo = $_GET['sexo'];
  $codmar	= $_GET['codmar'];
  $desmarveh= $_GET['desmar'];
  $codmodveh= $_GET['codmodveh'];
  $desmod= $_GET['desmod'];
  $codserveh=$_GET['codserveh'];
  $desserveh= $_GET['desserveh'];
  $numlotveh= $_GET['numlotveh'];
  $numplaveh= $_GET['numplaveh'];
  $descdep= $_GET['descdep'];
  $taller=$_GET['taller'];
  $tt=$_GET['tt'];
  $fecE=$_GET['fecE'];
  $fecE2=$_GET['fecE2'];
  $tipoE=$_GET['tipoe'];
  $tipoben=$_GET['tipoben'];
  $fecfacori1=$_GET['fecfacori1'];
  $fecfacori2=$_GET['fecfacori2'];
  $numfacori=$_GET['numfacori'];
  $obsv=$_GET['observ'];

    $nroFilas = 24;



if ($_SESSION['idBanco']) {
$listarFactura=$objFactura->listarFacturas_consuelo($id_numfac,$sercarveh,$fec,$fec2,-1,$codpro,$nombre,$tipo,$estatus, $_SESSION['idBanco'] ,$usuario,$cond, $sig, $dia ,$edad ,$estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori,'','','1','',$riflab,$deslab,$obsv); //,'','','1');
}
else
$listarFactura=$objFactura->listarFacturas_consuelo($id_numfac,$sercarveh,$fec,$fec2,-1,$codpro,$nombre,$tipo,$estatus, $banco ,$usuario,$cond, $sig, $dia ,$edad ,$estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori,'','','1','',$riflab,$deslab,$obsv);//,'','','1');


/*if ($taller or $tt)
{
	echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="18"><font color="#FFFFFF">LISTADO DE VEHICULOS PARA EL ACTO</font></td>'.'
  	</tr>
  		<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">N#</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Etiqueta</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Nombre</font></td>
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
      <td ALIGN="center" bgcolor="8C0000"  width="250"><font color="#FFFFFF">Observacion</font></td>
      <td ALIGN="center" bgcolor="8C0000"  width="150"><font color="#FFFFFF">Ubicacion</font></td>
      <td ALIGN="center" bgcolor="8C0000"  width="150"><font color="#FFFFFF">Inicial Consignada</font></td>
      <td ALIGN="center" bgcolor="8C0000"  width="150"><font color="#FFFFFF">Monto financiado</font></td>
  </tr>';

$j=0;
for($i=0;$i<count($listarFactura);$i+=$nroFilas){
	$j++;
if ($listarFactura[$i+2]=='0'){
	$listarFactura[$i+25]=$listarFactura[$i+45];
}
if ((($listarFactura[$i+2]=='QQ3') OR ($listarFactura[$i+2]=='X1')  OR ($listarFactura[$i+2]=='TIGGO')) AND ($listarFactura[$i+10]=='14'))
		                      	$ubicacion= "Base Sucre";

if ((($listarFactura[$i+2]=='QQ3') OR ($listarFactura[$i+2]=='X1')  OR ($listarFactura[$i+2]=='TIGGO')) AND ($listarFactura[$i+10]=='15'))
		                      	$ubicacion= "Base Libertador";

if (($listarFactura[$i+2]=='GRAND TIGER 4X2') OR ($listarFactura[$i+2]=='GRAND TIGER 4X4'))
		             	    	$ubicacion= "Base Sucre";

             $inicialConsignada=$objPago->inicialConsignada($listarFactura[$i+1]);
             $idPreinv=$objInv->buscarPreInv($listarFactura[$i+5]);
             $costo = $objInv->listarPreInventario($idPreinv[0],'','','',-1);


             $rif = substr($listarFactura[$i+1],0,1);

             if (($rif=='G') or ($rif=='J')){
             	$inicialConsignada = $costo[5];
             	$montoFin=0;
             }
             else $montoFin = intval((int)($costo[5]))-intval((int)($inicialConsignada)) ;



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
    <td>'.$listarFactura[$i+10].'</td>
    <td>'.$listarFactura[$i+11].'</td>
    <td>'.$listarFactura[$i+12].'</td>
    <td>'.$listarFactura[$i+13].'</td><td>'.$listarFactura[$i+15].'</td>
    <td>'.FormatoMonto($inicialConsignada).'</td>
    <td>'.FormatoMonto($montoFin).'</td>
  </tr>';
}
}
else
{*/
	echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="12"><font color="#FFFFFF">LISTADO DE VEHICULOS PARA EL ACTO</font></td>'.'
  	</tr>
  		<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">N#</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Etiqueta</font></td>
      <td ALIGN="center" bgcolor="8C0000"  width="250"><font color="#FFFFFF">Modelo</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Color</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Placa</td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Serial</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Lote</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Almacen</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Ubicaci&oacute</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Nivel_PDI</font></td>
      <td ALIGN="center" bgcolor="8C0000" ><font color="#FFFFFF">Estatus</font></td>
      <td ALIGN="center" bgcolor="8C0000"  width="250"><font color="#FFFFFF">Observaci&oacute;n</font></td>

  </tr>';



$j=0;
for($i=0;$i<count($listarFactura);$i+=$nroFilas){
	$j++;
if ($listarFactura[$i+2]=='0'){
	$listarFactura[$i+25]=$listarFactura[$i+45];
}

if ((($listarFactura[$i+2]=='QQ3') OR ($listarFactura[$i+2]=='X1')  OR ($listarFactura[$i+2]=='TIGGO')) AND ($listarFactura[$i+10]=='14'))
		                      	$ubicacion= "Base Sucre";

if ((($listarFactura[$i+2]=='QQ3') OR ($listarFactura[$i+2]=='X1')  OR ($listarFactura[$i+2]=='TIGGO')) AND ($listarFactura[$i+10]=='15'))
		                      	$ubicacion= "Base Libertador";

if (($listarFactura[$i+2]=='GRAND TIGER 4X2') OR ($listarFactura[$i+2]=='GRAND TIGER 4X4'))
		             	    	$ubicacion= "Base Sucre";


             $inicialConsignada=$objPago->inicialConsignada($listarFactura[$i+1]);
             $idPreinv=$objInv->buscarPreInv($listarFactura[$i+5]);
             $costo = $objInv->listarPreInventario($idPreinv[0],'','','',-1);

             $rif = substr($listarFactura[$i+1],0,1);

             if (($rif=='G') or ($rif=='J')){
             	$inicialConsignada = $costo[5];
             	$montoFin=0;
             }
             else $montoFin = intval((int)($costo[5]))-intval((int)($inicialConsignada)) ;
if ($listarFactura[$i+22]=='E')  $listarFactura[$i+22]='No PDI'; else  $listarFactura[$i+22]=' ' ;

echo  '<tr>
   <td>'.$j.'</td>
    <td>'.$listarFactura[$i+14].'</td>
    <td>'.$listarFactura[$i+2].'</td>
    <td>'.$listarFactura[$i+3].'</td>
    <td>'.$listarFactura[$i+4].'</td>
    <td>'.$listarFactura[$i+5].'</td>
    <td>'.$listarFactura[$i+10].'</td>
    <td>'.$listarFactura[$i+19].'</td>
    <td>'.$listarFactura[$i+17].'</td>
    <td>'.$listarFactura[$i+20].'</td>
    <td>'. $listarFactura[$i+22].'</td>
    <td>'.$listarFactura[$i+21].'</td>

   	</tr>';
}
//}
echo'<tr>
	<td colspan="12">Total '.$j.' Facturas</td>
</tr></table>';
?>