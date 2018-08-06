<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_CitasxEdo_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_CitasxEdo_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/factura.php');
require('../../controlador/funciones.php');
require('../../modelos/citas.php');
require('../../modelos/beneficiario.php');
require('../../modelos/pago.php');
require('../../modelos/banco.php');

$objCitas= new citas();
$objBeneficiario=new beneficiario();
$objPago = new pago();
$objBanco = new banco();

 $tipoBen = $_GET['tipo'];
 $fechaD  = $_GET['fechaD'];
 $fechaH  = $_GET['fechaH'];
 $banco   = $_GET['banco'];

$nroCampos = 6;

$listarBeneficiario=$objBeneficiario->listarTipo_benef();
$listarBancos=$objPago->listarBancos(4);

$listarCitasEdo = $objCitas->cuadroResumenCitasxEdo($tipoBen,$fechaD,$fechaH,$banco);
$listarCitasSinEdo = $objCitas->cuadroResumenCitasSinEdo($tipoBen,$fechaD,$fechaH,$banco);

if ($banco) $nombreB = $objBanco->listarBancos($banco);
$_SESSION['nomban']=$nombreB[2];

echo '<table border="1">
 	 <tr>
  	  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="7"><font color="#FFFFFF">CITAS POR ESTADO</font></td>
  	</tr>
  	<tr>';

     	      if ($banco)  echo "<TR bgcolor='8C0000'><TH colspan='7'>".$nombreB[2]."</TH></tr>";
     	     // if ($tipoBen)  echo "<TR bgcolor='8C0000'><TH colspan='6'>".$tipoBen."</TH></tr>";

		      if (($fechaD) and ($fechaH))
		   	  {

		   	  	echo "<TR  bgcolor='8C0000'><TH colspan='7'>Desde el ".$fechaD.' hasta el '.$fechaH."</TH></tr>";
		   	  }
		   	  elseif (($fechaD) and !($fechaH))
		   	  {
		   	  		echo "<TR bgcolor='8C0000'><TH colspan='7'>Desde el ".$fechaD."</TH></tr>";
		   	  }
		   	  elseif (!($fechaD) and ($fechaH))
			  {
			  		echo "<TR bgcolor='8C0000'><TH colspan='7'>Hasta el ".$fechaH."</TH></tr>";
			  }

echo '<td ALIGN="center" bgcolor="8C0000" width="320" rowspan="2"><font color="#FFFFFF">Estado</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="100" colspan="4"><font color="#FFFFFF">Beneficiarios</font></td>
      <td ALIGN="center" bgcolor="8C0000" width="80" rowspan="2"><font color="#FFFFFF">Total</td>
  </tr>';

echo '<TR class="cabeceraI">
		    <TH title="Asistieron" bgcolor="8C0000"><font color="#FFFFFF">Asistieron</TH>
		    <TH title="No asistieron" bgcolor="8C0000"><font color="#FFFFFF">No asistieron</font></TH>
			<TH title="Pendientes" bgcolor="8C0000"><font color="#FFFFFF">Pendientes por asistir</font></TH>
			<TH title="Total citas" bgcolor="8C0000"><font color="#FFFFFF">Total Citas</font></TH>
			<TH title="Sin Cita" bgcolor="8C0000"><font color="#FFFFFF">Sin cita</font></TH>
	   </TR>';

$asistieron=0;
$vencidas=0;
$pendiente=0;
$sincita=0;

$contArt = 0;
for($i=0;$i<count($listarCitasEdo);$i+=$nroCampos){
          	  $color = (!$indC)?'datosimpar':'datospar';
              $indC = !$indC;
              $contArt ++;

            echo '<tr>
		    <TD align="left">'.$listarCitasEdo[$i+1].'</TD>
		    <TD align="center">'.$listarCitasEdo[$i+2].'</TD>
		    <TD align="center">'.$listarCitasEdo[$i+3].'</TD>
		    <TD align="center">'.$listarCitasEdo[$i+4].'</TD>';


		         $totalF=$listarCitasEdo[$i+2];
		         $totalF+=$listarCitasEdo[$i+3];
		         $totalF+=$listarCitasEdo[$i+4];
		        // $totalF+=$listarCitasEdo[$i+5];

           echo '<TD align="center" class="cabeceraI" bgcolor="8C0000"><font color="#FFFFFF">'.$totalF.'</font></TD>
           		 <TD align="center">'.$listarCitasEdo[$i+5].'</TD>';

			$cita1=$listarCitasEdo[$i+5];
		    $asistieron+=$listarCitasEdo[$i+2];
			$vencidas+=$listarCitasEdo[$i+3];
		    $pendiente+=$listarCitasEdo[$i+4];
			$sincita+=$listarCitasEdo[$i+5];

			//$reales = $asistieron + $vencidas + $pendiente + $sincita;
			$reales = $totalF + $cita1;

			echo '<TD align="center" bgcolor="8C0000"><font color="#FFFFFF">'.$reales.'</font></TD>';
			echo '</TR>';
 }

  echo '<tr><TD align="left">SIN ESTADO</TD>';

 for($k=0;$k<=1;$k+=6){
 	 $tbancoc=$listarCitasSinEdo[($k*6)+2]+$listarCitasSinEdo[($k*6)+3]+$listarCitasSinEdo[($k*6)+4]; //+$listarCitasSinEdo[($k*6)+5];

     echo '<td align="center">'.$listarCitasSinEdo[($k*6)+2].'</td>
          <td align="center">'.$listarCitasSinEdo[($k*6)+3].'</td>
          <td align="center">'.$listarCitasSinEdo[($k*6)+4].'</td>
          <td align="center" bgcolor="8C0000" title="Total Sin Estado"><font color="#FFFFFF">'.$tbancoc.'</font></td>
          <td align="center">'.$listarCitasSinEdo[($k*6)+5].'</td>';

$asistieronc=$asistieronc+$listarCitasSinEdo[($k*6)+2];
$vencidasc=$vencidasc+$listarCitasSinEdo[($k*6)+3];
$pendientec=$pendientec+$listarCitasSinEdo[($k*6)+4];
$sincitac=$sincitac+$listarCitasSinEdo[($k*6)+5];

$cita1c=$listarCitasSinEdo[($k*6)+5];

//$realesc = $asistieronc + $vencidasc + $pendientec + $sincitac;
$realesc = $tbancoc + $cita1c;
echo '<TD align="center" bgcolor="8C0000"><font color="#FFFFFF">'.$realesc.'</font></TD>';
}
echo '</tr>';

echo '<tr class="cabecera">
<td width="60%" align="right" bgcolor="8C0000"><font color="#FFFFFF">TOTALES</font></TH>
<td align="center" title="Asistentes" bgcolor="8C0000"><font color="#FFFFFF">'.$_SESSION['realasis'].'</font></td>
<td align="center" title="Vencidas" bgcolor="8C0000"><font color="#FFFFFF">'.$_SESSION['realven'].'</font></td>
<td align="center" title="Pendientes" bgcolor="8C0000"><font color="#FFFFFF">'.$_SESSION['realpen'].'</font></td>
<td align="center" title="Total Citas" bgcolor="8C0000"><font color="#FFFFFF">'.$_SESSION['totalS'].'</font></td>
<td align="center" title="Sin cita" bgcolor="8C0000"><font color="#FFFFFF">'.$_SESSION['realsinc'].'</font></td>
<td align="center" title="Total Citas" bgcolor="8C0000"><font color="#FFFFFF">'.$_SESSION['totaltotal'].'</font></td>
/tr>';

echo'</table>';
?>