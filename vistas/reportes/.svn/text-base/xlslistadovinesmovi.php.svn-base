<?php
session_start();
$id=$_GET['id'];

if ($id==1){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=Lista_Expedientes_".date('d/m/Y').".xls");
}
if ($id==2){
	header("Content-type: application/vnd.oasis.opendocument.spreadsheet; charset=utf-8");
	header("Content-Disposition: attachment; Lista_Expedientes_".date('d/m/Y').".ods");
}

require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/vines.php');

$objVines = new vines();
$tipo     = $_GET['tipo'];
$modelo   = $_GET['modelo'];
$marca    = $_GET['marca'];
$color    = $_GET['color'];
$pdi      = $_GET['pdi'];
$fecha    = $_GET['fecha'];
$Hora     = $_GET['Hora'];
$nro      = $_GET['nro'];
$listadodevines=$objVines->listadodevinesmovi($tipo,$modelo,$marca,$color,$pdi,$fecha,$Hora,$nro,-1);

// Ecabezado
echo "<table>
		<tr>
		    <th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Nro</font></th>
		    <th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Tipo</font></th>
		    <th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Nro</font></th>
		    <th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Modelo</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Marca</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Serial C.</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Serial M.</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Color</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Año F.</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Año M.</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Llave</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Encendido</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Carroceria</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Caucho</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Gato</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Triangulo</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Herramienta</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Fecha Captura</font></th>
			<th bgcolor='8C0000' width='80'><font color='#FFFFFF'>Hora Captura</font></th>
		 </tr>";
$j = 0;
for($i=0;$i<count($listadodevines);$i+=23){
	$j++;
	echo "<tr>
            <td align='center'>".$j."</td>
		    <TD align='left'>".$listadodevines[$i+21]."</TD>
		    <TD align='left'>".$listadodevines[$i+2]."</TD>
		    <TD align='left'>".$listadodevines[$i+3]."</TD>
		    <TD align='left'>".$listadodevines[$i+4]."</TD>
		    <TD align='left'>".$listadodevines[$i+5]."</TD>
		    <TD align='left'>".$listadodevines[$i+6]."</TD>
		    <TD align='left'>".$listadodevines[$i+7]."</TD>
		    <TD align='left'>".$listadodevines[$i+8]."</TD>
		    <TD align='left'>".$listadodevines[$i+9]."</TD>
		    <TD align='left'>".$listadodevines[$i+10]."</TD>
		    <TD align='left'>".$listadodevines[$i+11]."</TD>
		    <TD align='left'>".$listadodevines[$i+12]."</TD>
		    <TD align='left'>".$listadodevines[$i+13]."</TD>
		    <TD align='left'>".$listadodevines[$i+14]."</TD>
		    <TD align='left'>".$listadodevines[$i+15]."</TD>
		    <TD align='left'>".$listadodevines[$i+16]."</TD>
		    <TD align='left'>".$listadodevines[$i+17]."</TD>
		    <TD align='left'>".$listadodevines[$i+18]."</TD>
	  </tr>";
}
echo "<tr>
	<th bgcolor='8C0000' colspan='19' align='left'><font color='#FFFFFF'>Total ".$j."</font></th>
</tr></table>";
