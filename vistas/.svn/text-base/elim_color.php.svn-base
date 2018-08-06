<?php
session_start();
require('../modelos/conexion.php');
require('../modelos/color.php');
require('../controlador/funciones.php');
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++) $uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
/*$permitidos = array(3);
validaAcceso($permitidos,$dir);*/

$objColor = new color();

$cod=$_POST['cod'];
$nom=$_POST['nomb'];
$opc=$_GET['opr'];

if ($opc)
{
	$eliminar=$objColor->eliminarColor($cod);

		if ($eliminar){
       		echo '<SCRIPT>alert("Color eliminado");</SCRIPT>';
          	echo "<SCRIPT>window.location.href='cat_color.php';</SCRIPT>";
         	//$limpiar= $objExpediente->limpiar();
	 	}
		else
		{
			echo '<SCRIPT>alert("Color eliminado");</SCRIPT>';
			echo "<SCRIPT>window.location.href='cat_color.php';</SCRIPT>";
		}

}
?>
<!DOCTYPE HTML PUBLIC>
<html>
<head>
<title>Eliminar Color</title>
<link rel="stylesheet" type="text/css" href="../css/style.css">
<script type="text/javascript" src="../controlador/ajax.js"></script>
<link href="../css/classstyles.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
<form action="" method="post" name="form1" >
<table border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
  <tr>
	<td width="50%"  background="imagenes/bg.gif"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0"></td>
	<td valign="bottom" background="imagenes/bg_left.gif"><img src="imagenes/bg_left.gif" alt="" width="17" height="16" border="0"></td>
	<td valign="top">
<p>&nbsp;</p>
<table width="50%" align="center">
      <tr class="Not">
        <td colspan="2" ><div align="center" ><strong>Datos a Eliminar</strong></div></td>
      </tr>
      <tr >
        <td width="50%" class="TitNot"><div align="right" >C&oacute;digo:</div></td>
        <?php
      		$co=$_GET['codi'];
			$buscarColor = $objColor->buscarColorID($co);
		   ?>
        <td width="50%"><input name="cod" type="text" id="cod" value=" <?php  echo $buscarColor[0];?>" readonly></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right" >Nombre:</div></td>
        <td><input name="nomb" type="text" id="nomb" value=" <?php  echo $buscarColor[1];?>" readonly></td>
      </tr>
	  <tr class="menu01" >
				<td height="2" colspan="2"><div align="center" class="NotCelda">
				<div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
				</div></td>
		  </tr>

      <tr >
        <td colspan="2"><div align="center">
            <input type="button"  name="eliminar" value="Eliminar" onClick="link('elim_color.php?opr=1',document.form1); return false"><input type="button" value="Atras" onClick="javascript:history.back();">
        </div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    </td>
	<td valign="bottom" background="imagenes/bg_right.gif"><img src="imagenes/bg_right.gif" alt="" width="17" height="16" border="0"></td>
	<td width="50%" background="imagenes/bg.gif"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0"></td>
</tr>
</table>
</form>
</body>
</html>