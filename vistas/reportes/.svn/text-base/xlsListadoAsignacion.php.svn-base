<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_VehxEdo_".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_VehxEdo_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/asignacion.php');

$objAsignacion = new asignacion();

 $numlotveh = $_GET['numlotveh'];
 $sercarveh = $_GET['sercarveh'];
 $codpro	= $_GET['codpro'];
 $nombre	= $_GET['nombre'];
 $fechAsig	= $_GET['fechAsig'];
 $tipo	= $_GET['tipo'];
 $taller = $_GET['codtal'];
 $tt = $_GET['todo_taller'];
 $modelo = $_GET['modelo'];

 $nroFilas = 15;

if ($taller or $tt)
	$nroCampos = 15;
else
	$nroCampos = 13;

//$listarAsignacion=$objAsignacion->listarAsignacion1($sercarveh,$codpro,$nombre,$id,$fechAsig,$numlotveh,-1,$tipo,$taller,$tt,$_SESSION['numeDepa']);

$listarAsignacion=$objAsignacion->listarAsignacion1($sercarveh,$codpro,$nombre,$id,$fechAsig,$numlotveh,-1,$tipo,$taller,$tt,$_SESSION['numeDepa'],'',$modelo);

echo '<table width="60%" align="center" class="detalles">

          <tr>
              <td class="cabecera" bgcolor="8C0000"  width="40"><font color="#FFFFFF">N&deg;</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="150"><font color="#FFFFFF">Modelo</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="200"><font color="#FFFFFF">Serial de Carrocer&iacute;a</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="100"><font color="#FFFFFF">Color</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="80"><font color="#FFFFFF">Placa</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="100"><font color="#FFFFFF">CI/RIF</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="250"><font color="#FFFFFF">Nombre</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="80"><font color="#FFFFFF">Fecha Asignaci&oacute;n</font></td>';
              if ($tipo=='L') {
              echo '<td class="cabecera" bgcolor="8C0000" width="80"><font color="#FFFFFF">Fecha de Lib.</font></td>
              <td class="cabecera" bgcolor="8C0000" width="80"><font color="#FFFFFF">Usuario</font></td>
              <td class="cabecera" bgcolor="8C0000" width="300"><font color="#FFFFFF">Observaci&oacute;n </font></td>';
              }
              if ($taller or $tt) {
              echo '<td class="cabecera" bgcolor="8C0000" width="100"><font color="#FFFFFF">Taller - Falla</font></td>';
               }
              echo '</tr>';

for($i=0;$i<count($listarAsignacion);$i+=$nroCampos){
          if($listarAsignacion[$i]){
             $indC = !$indC;

             echo '<tr >
               <td align="center">'.$nreg.'</td>';
               if ($taller or $tt)
               			$modelo= $listarAsignacion[$i+12];
               		 else
               		 	$modelo= $listarAsignacion[$i+10];


               echo '<td>'.$modelo.'</td>
               <td align="center">'.$listarAsignacion[$i].'</td>
               <td align="center">'.$listarAsignacion[$i+11].'</td>
               <td align="center">'.$listarAsignacion[$i+12].'</td>
               <td align="center">'.$listarAsignacion[$i+1].'</td>
               <td>&nbsp;'.$listarAsignacion[$i+2].'</td>
               <td align="center">'.$listarAsignacion[$i+3].'</td>';
                   if ($tipo=='L') {
                   echo'<td align="center">'.$listarAsignacion[$i+6].'</td>
                   	  <td align="center">'.$listarAsignacion[$i+8].'</td>
                   	  <td align="center">'.$listarAsignacion[$i+9].'</td>';
                   	}
			  if ($taller or $tt) {
              echo '<td>'.$listarAsignacion[$i+10].' - '.$listarAsignacion[$i+11].'</td>';
              }
              echo '</tr>';
          }
      }


	echo '</table>';
?>