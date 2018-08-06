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
  $color=$_GET['color'];
  $tipoB=$_GET['tipoB'];
  $riflab=$_GET['riflab'];
  $deslab=$_GET['deslab'];
  $acto=$_GET['acto'];





/*if ($taller or $tt)
	$nroFilas = 48;
else
    $nroFilas = 46;*/


/*if (($taller or $tt) and ($tipoE))
	$nroFilas = 48;
elseif ($taller or $tt or $tipoE)
	$nroFilas = 48;
else
    $nroFilas = 46;*/


if (($taller or $tt) and ($tipoE))
	$nroFilas = 55;
elseif ($taller or $tt or $tipoE)
	$nroFilas = 55;
elseif ($acto or $ta)
	$nroFilas = 54;
else
	$nroFilas = 53;



if ($_SESSION['idBanco']) {
//$listarFactura=$objFactura->listarFacturas($id_numfac,$sercarveh,$fec,$fec2,-1,$codpro,$nombre,$tipo,$estatus, $_SESSION['idBanco'] ,$usuario,$cond, $sig, $dia ,$edad ,$estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori); //,'','','1');
$listarFactura=$objFactura->listarFacturas($id_numfac,$sercarveh,$fec,$fec2,-1,$codpro,$nombre,$tipo,$estatus,$_SESSION['idBanco'],$usuario,$cond,$sig,$dia,$edad,
$estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori,
$preinv,$color,'1','',$acto,$tam,'a',$tipoB,$riflab,$deslab);
}
else
//$listarFactura=$objFactura->listarFacturas($id_numfac,$sercarveh,$fec,$fec2,-1,$codpro,$nombre,$tipo,$estatus, $banco ,$usuario,$cond, $sig, $dia ,$edad ,$estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori) ;//,'','','1');
$listarFactura=$objFactura->listarFacturas($id_numfac,$sercarveh,$fec,$fec2,-1,$codpro,$nombre,$tipo,$estatus,$banco,$usuario,$cond,$sig,$dia,$edad,
$estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori,
$preinv,$color,'1','',$acto,$ta,'a',$tipoB,$riflab,$deslab);


if ($taller or $tt)
{
	echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="29"><font color="#FFFFFF">LISTA DE PROFORMAS</font></td>'.'<td ALIGN="center" bgcolor="8C0000" width="1300" colspan="8"><font color="#FFFFFF">DATOS DE CREDITO</font></td>
  	</tr>
  		<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="25"><font color="#FFFFFF">N&deg</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="120"><font color="#FFFFFF">N&deg factura</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="120"><font color="#FFFFFF">Fecha</td>	<td ALIGN="center" bgcolor="8C0000" width="140"><font color="#FFFFFF">Serial</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">CI/RIF</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Beneficiario</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Telefono</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Certificado</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Cond.Pago</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Banco</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Estatus</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Usuario</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Estado</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Sexo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Edad</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">D.T</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">D.R</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Marca</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Modelo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Serie</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Lote</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">N&deg Placa</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Color</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Fec_Status</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Taller</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Falla</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Tipo_Benef</font></td>
       <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">N&deg.Fact.orig</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Fec.Factura orig.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Monto Solicitado</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Monto Aprobado</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Plazo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Tasa</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Tipo_Pago(M/S/A)</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Gastos Adm</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Gastos Timbres</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Exonerado(S/N)</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Rif Lab.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Desc. Lab</font></td>

  </tr>';

$j=0;
for($i=0;$i<count($listarFactura);$i+=$nroFilas){
	$j++;
if ($listarFactura[$i+2]=='0'){
	$listarFactura[$i+25]=$listarFactura[$i+45];
}

if (($taller or $tt) and ($tipoE)){
               		$telefono = $listarFactura[$i+49];
               		if ($listarFactura[$i+50]<>'0')
               			$telefono = $telefono." - ".$listarFactura[$i+50];
               	 }
                 elseif ($taller or $tt or $tipoE){
               		$telefono = $listarFactura[$i+49];
               		if ($listarFactura[$i+50]<>'0')
               			$telefono = $telefono." - ".$listarFactura[$i+50];
               	 }
				 elseif ($acto or $ta)
				 {
               		$telefono = $listarFactura[$i+48];
               		if ($listarFactura[$i+49]<>'0')
               			$telefono = $telefono." - ".$listarFactura[$i+49];
               	 }
               	 else
				 {
               		$telefono = $listarFactura[$i+48];
               		if ($listarFactura[$i+49]<>'0')
               			$telefono = $telefono." - ".$listarFactura[$i+49];
               	 }

               	 if ($listarFactura[$i+6]=='COMPLETO') $condPago="100% CREDITO"; else $condPago=$listarFactura[$i+6];
echo  '<tr>
    <td>'.$j.'</td>
    <td>'.$listarFactura[$i].'</td>
    <td>'.$listarFactura[$i+4].'</td>
    <td>'.$listarFactura[$i+2].'</td>
    <td>'.$listarFactura[$i+8].'</td>
    <td>'.$listarFactura[$i+9].'</td>
    <td>'.$telefono.'</td>
    <td>'.$listarFactura[$i+49].'</td>
    <td>'.$condPago.'</td>
    <td>'.$listarFactura[$i+16].'</td>
    <td>'.$listarFactura[$i+17].'</td>
    <td>'.$listarFactura[$i+11].'</td>
    <td>'.$listarFactura[$i+18].'</td>
    <td>'.$listarFactura[$i+19].'</td>
    <td>'.$listarFactura[$i+20].'</td>
    <td>'.$listarFactura[$i+22].'</td>
    <td>'.$listarFactura[$i+23].'</td>
    <td>'.$listarFactura[$i+24].'</td>
    <td>'.$listarFactura[$i+25].'</td>
    <td>'.$listarFactura[$i+26].'</td>
    <td>'.$listarFactura[$i+27].'</td>
    <td>'.$listarFactura[$i+28].'</td>
    <td>'.$listarFactura[$i+45].'</td>
    <td>'.$listarFactura[$i+29].'</td>
    <td>'.$listarFactura[$i+44].'</td>
    <td>'.$listarFactura[$i+45].'</td>
    <td>'.$listarFactura[$i+30].'</td>
    <td>'.$listarFactura[$i+31].'</td>
    <td>'.$listarFactura[$i+32].'</td>
    <td>'.$listarFactura[$i+33].' Bs'.'</td>
    <td>'.$listarFactura[$i+34].' Bs'.'</td>
    <td>'.$listarFactura[$i+35].' meses'.'</td>
    <td>'.$listarFactura[$i+36].'%'.'</td>
    <td>'.$listarFactura[$i+37].'-'.$listarFactura[$i+38].'-'.$listarFactura[$i+39].'</td>
    <td>'.$listarFactura[$i+40].'%'.$listarFactura[$i+41].' Bs'.'</td>
    <td>'.$listarFactura[$i+42].' Bs'.'</td>
    <td>'.$listarFactura[$i+43].'</td>
    <td>'.$listarFactura[$i+44].'</td>
    <td>'.$listarFactura[$i+45].'</td>
  </tr>';
}
}
else
{
	echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="29"><font color="#FFFFFF">LISTA DE PROFORMAS</font></td>'.'<td ALIGN="center" bgcolor="8C0000" width="1300" colspan="8"><font color="#FFFFFF">DATOS DE CREDITO</font></td>
  	</tr>
  		<tr>';
echo '<td ALIGN="center" bgcolor="8C0000" width="25"><font color="#FFFFFF">N&deg</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="120"><font color="#FFFFFF">N&deg factura</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="120"><font color="#FFFFFF">Fecha</td>
      <td ALIGN="center" bgcolor="8C0000" width="140"><font color="#FFFFFF">Serial</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">CI/RIF</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Beneficiario</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Telefono</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Certificado</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Cond.Pago</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Banco</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Estatus</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Usuario</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Estado</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Sexo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Edad</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">D.T</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">D.R</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Marca</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Modelo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Serie</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Lote</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">N&deg Placa</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Color</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Fec_Status</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Tipo_Benef</font></td>
       <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Fec.Factura orig.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">N&deg.Fact.orig</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Monto Solicitado</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Monto Aprobado</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Plazo</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Tasa</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Tipo_Pago(M/S/A)</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Gastos Adm</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Gastos Timbres</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Exonerado(S/N)</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Rif Lab.</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Desc. Lab</font></td>
  </tr>';

$j=0;
for($i=0;$i<count($listarFactura);$i+=$nroFilas){
	$j++;
if ($listarFactura[$i+2]=='0'){
	$listarFactura[$i+25]=$listarFactura[$i+45];
}

if (($taller or $tt) and ($tipoE)){
               		$telefono = $listarFactura[$i+49];
               		if ($listarFactura[$i+50]<>'0')
               			$telefono = $telefono." - ".$listarFactura[$i+50];
               	 }
                 elseif ($taller or $tt or $tipoE){
               		$telefono = $listarFactura[$i+49];
               		if ($listarFactura[$i+50]<>'0')
               			$telefono = $telefono." - ".$listarFactura[$i+50];
               	 }
				 elseif ($acto or $ta)
				 {
               		$telefono = $listarFactura[$i+50];
               		if ($listarFactura[$i+51]<>'0')
               			$telefono = $telefono." - ".$listarFactura[$i+51];
               	 }
               	 else
				 {
               		$telefono = $listarFactura[$i+49];
               		if ($listarFactura[$i+50]<>'0')
               			$telefono = $telefono." - ".$listarFactura[$i+50];
               	 }
               	 if ($listarFactura[$i+6]=='COMPLETO') $condPago="100% CREDITO"; else $condPago=$listarFactura[$i+6];

echo  '<tr>
    <td>'.$j.'</td>
    <td>'.$listarFactura[$i].'</td>
    <td>'.$listarFactura[$i+4].'</td>
    <td>'.$listarFactura[$i+2].'</td>
    <td>'.$listarFactura[$i+8].'</td>
    <td>'.$listarFactura[$i+9].'</td>
    <td>'.$telefono.'</td>
    <td>'.$listarFactura[$i+52].'</td>
    <td>'.$condPago.'</td>
    <td>'.$listarFactura[$i+16].'</td>
    <td>'.$listarFactura[$i+17].'</td>
    <td>'.$listarFactura[$i+11].'</td>
    <td>'.$listarFactura[$i+18].'</td>
    <td>'.$listarFactura[$i+19].'</td>
    <td>'.$listarFactura[$i+20].'</td>
    <td>'.$listarFactura[$i+22].'</td>
    <td>'.$listarFactura[$i+23].'</td>
    <td>'.$listarFactura[$i+24].'</td>
    <td>'.$listarFactura[$i+25].'</td>
    <td>'.$listarFactura[$i+26].'</td>
    <td>'.$listarFactura[$i+27].'</td>
    <td>'.$listarFactura[$i+28].'</td>
    <td>'.$listarFactura[$i+47].'</td>
    <td>'.$listarFactura[$i+29].'</td>
    <td>'.$listarFactura[$i+30].'</td>
    <td>'.$listarFactura[$i+31].'</td>
    <td>'.$listarFactura[$i+32].'</td>
    <td>'.$listarFactura[$i+33].' Bs'.'</td>
    <td>'.$listarFactura[$i+34].' Bs'.'</td>
    <td>'.$listarFactura[$i+35].' meses'.'</td>
    <td>'.$listarFactura[$i+36].'%'.'</td>
    <td>'.$listarFactura[$i+37].'-'.$listarFactura[$i+38].'-'.$listarFactura[$i+39].'</td>
    <td>'.$listarFactura[$i+40].'%'.$listarFactura[$i+41].' Bs'.'</td>
    <td>'.$listarFactura[$i+42].' Bs'.'</td>
    <td>'.$listarFactura[$i+43].'</td>
    <td>'.$listarFactura[$i+44].'</td>
    <td>'.$listarFactura[$i+45].'</td>
  </tr>';
}
}
echo'<tr>
	<td colspan="12">Total '.$j.' Facturas</td>
</tr></table>';
?>