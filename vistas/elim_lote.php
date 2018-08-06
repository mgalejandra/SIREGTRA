<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/lotes.php');
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(3,2);
validaAcceso($permitidos,$dir);

$objLote = new lotes();

$opc=$_GET['opr'];
$cod=$_GET['codi'];
$codi=$_POST['cod'];

if ($opc)
{
   $eliminar=$objLote->eliminarLote($codi);

   if ($eliminar){
       		echo '<SCRIPT>alert("Lote eliminado");</SCRIPT>';
          	echo "<SCRIPT>window.location.href='cat_lot.php';</SCRIPT>";
         	//$limpiar= $objExpediente->limpiar();
   }
   else
   {
				echo '<SCRIPT>alert("Lote no eliminado");</SCRIPT>';
				echo "<SCRIPT>window.location.href='cat_lot.php';</SCRIPT>";
   }
}
?>
<!DOCTYPE HTML PUBLIC >
<html>
<head>
<title>Eliminar Lote</title>
<script type="text/javascript" src="../controlador/ajax.js"></script>
<link href="../css/classstyles.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
<form action="" method="post" name="form1" >
<table width="50%" align="center">
<tr >
<td colspan="2" ><div align="center" class="Not"><strong>Datos a Eliminar</strong></div></td>
</tr>
<tr >
<td width="50%" class="TitNot"><div align="right"><strong>N&uacute;mero:</strong></div></td>
<?php
    $co=$_GET['codi'];
	$buscarLotes = $objLote->buscarLoteID($co);
?>
<td width="50%"><input name="cod" type="text" id="cod" value=" <?php  echo $buscarLotes[0];?>" readonly></td>
</tr>
<tr >
<td class="TitNot"><div align="right" >Fecha:</div></td>
<td><input name="fec" type="text" id="fec" value=" <?php  echo $buscarLotes[1];?>" readonly></td>
</tr>
<tr >
<td class="TitNot"><div align="right" >Descripci&oacute;n:</div></td>
<td><input name="reg" type="text" id="reg" value=" <?php  echo $buscarLotes[2];?>" readonly></td>
</tr>
<tr >
<td height="12" colspan="2"><div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1"></div></td>
</tr>
<tr >
<td colspan="2"><div align="center">
<input type="button"  name="eliminar" value="Eliminar" onClick="link('elim_lote.php?opr=1',document.form1); return false"><input type="button" value="Atras" onClick="javascript:history.back();">
</div></td>
</tr>
</table>
</form>
</body>
</html>