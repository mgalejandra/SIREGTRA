<?php
session_start();
$id=$_GET['id'];

if ($id==1){
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Lista_VehEnt_Conc".date('d/m/Y').".xls");
}
if ($id==2){
header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
header("Content-Disposition: attachment; Lista_VehEnt_Conc".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/concesionario.php');
require('../../modelos/zona.php');
require('../../modelos/lotes.php');

$objConcesionario = new concesionario();
$objZona= new zona();
$objLote= new lotes();


 $sercarveh = $_GET['sercarveh'];
 $codpro	= $_GET['codpro'];
 $nombre	= $_GET['nombre'];
 $codmodveh = $_GET['modelo'];
 $estado = $_GET['estado'];
 $fecE=$_GET['fecE'];
 $fecH=$_GET['fecH'];
 $placa=$_GET['numplaveh'];
 $lote=$_GET['lote'];

 $nroFilas = 15;
 $nroCampos = 21;
 $combino = 14;


$listarVehChery=$objConcesionario->listarVehChery($sercarveh,$codpro,$nombre,-1,$codmodveh,$estado,$fecE,$placa,$fecH,$lote);

if ($fecE and $fecH) echo "<tr><td colspan='.$combino.' class='cabecera' bgcolor='8C0000'>Fecha de entrega desde el ".$fecE." al ".$fecH."</td></tr>";

if ($lote){
    	/*$lote1=$objLote->buscarLoteID($numlotveh);
    	echo "<tr><td colspan='13' class='cabecera' bgcolor='8C0000'>Lote ".$lote1[2]."</td></tr>";*/

     if ($lote=='14')
    	echo "<tr><td colspan='$combino' class='cabecera' bgcolor='8C0000'><font color='#FFFFFF'>Lote Chery 1</font></td></tr>";

      if ($lote=='15')
    	echo "<tr><td colspan='$combino' class='cabecera' bgcolor='8C0000'><font color='#FFFFFF'>Lote Chery 2</font></td></tr>";

      if ($lote=='16')
    	echo "<tr><td colspan='$combino' class='cabecera' bgcolor='8C0000'><font color='#FFFFFF'>Lote Chery 3</font></td></tr>";

      /*if ($lote=='17')
    	echo "<tr><td colspan='$combino' class='cabecera' bgcolor='8C0000'><font color='#FFFFFF'>Lote Chery 4</font></td></tr>";		*/
}


echo '<table width="60%" align="center" class="detalles">
          <tr>
              <td class="cabecera" bgcolor="8C0000"  width="40" align="center"><font color="#FFFFFF">N&deg;</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="40" align="center"><font color="#FFFFFF">Lote</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="150" align="center"><font color="#FFFFFF">Modelo</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="200" align="center"><font color="#FFFFFF">Serial de Carrocer&iacute;a</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="200" align="center"><font color="#FFFFFF">Serial de Motor</font></td>';
              //<td class="cabecera" bgcolor="8C0000"  width="200"><font color="#FFFFFF">NIV</font></td>
              echo '<td class="cabecera" bgcolor="8C0000"  width="100" align="center"><font color="#FFFFFF">Color</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="80" align="center"><font color="#FFFFFF">Placa</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="100" align="center"><font color="#FFFFFF">CI/RIF</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="300" align="center"><font color="#FFFFFF">Nombre</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="400" align="center"><font color="#FFFFFF">Direcci&oacute;n</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="100" align="center"><font color="#FFFFFF">Estado</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="200" align="center"><font color="#FFFFFF">Tel&eacute;fonos</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="100" align="center"><font color="#FFFFFF">Fecha Fact. Orig.</font></td>
              <td class="cabecera" bgcolor="8C0000"  width="100" align="center"><font color="#FFFFFF">Fecha Entrega</font></td>';

              echo '</tr>';

for($i=0;$i<count($listarVehChery);$i+=$nroCampos){
          if($listarVehChery[$i]){
             $indC = !$indC;
             $nreg = $i/$nroCampos+1;

             $direccion = $listarVehChery[$i+11];
             if($listarVehChery[$i+12]) $direccion.= ' '.$listarVehChery[$i+12];
			 if($listarVehChery[$i+13]) $direccion.= ' '.$listarVehChery[$i+13];
             if($listarVehChery[$i+14]) $direccion.= ' '.$listarVehChery[$i+14];
			 if($listarVehChery[$i+15]) $direccion.= ' '.$listarVehChery[$i+15];
             if($listarVehChery[$i+16]) $direccion.= ', MUNICIPIO '.$listarVehChery[$i+16];

             $estadoN = $objZona->buscarEstados($listarVehChery[$i+18]);

             echo '<tr >
               <td align="center">'.$nreg.'</td>
               <td align="center">'.$listarVehChery[$i+20].'</td>
               <td align="center">'.$listarVehChery[$i+3].'</td>
               <td align="center">'.$listarVehChery[$i].'</td>
               <td align="center">'.$listarVehChery[$i+6].'</td>';
               //<td align="center">'.$listarVehChery[$i+7].'</td>
            echo '<td align="center">'.$listarVehChery[$i+4].'</td>
               <td align="center">'.$listarVehChery[$i+5].'</td>
               <td align="center">'.$listarVehChery[$i+1].'</td>
               <td>'.$listarVehChery[$i+2].'</td>
               <td>'.$direccion.'</td>
               <td align="center">'.$estadoN[1].'</td>
               <td align="center">'.$listarVehChery[$i+9]." ".$listarVehChery[$i+10].'</td>
               <td align="center">'.$listarVehChery[$i+17].'</td>
               <td align="center">'.$listarVehChery[$i+19].'</td>
               </tr>';
          }
      }

	echo '</table>';
?>