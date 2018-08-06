<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/color.php');

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
/*$permitidos = array(1,3,4,5);
validaAcceso($permitidos,$dir);*/

$objColor = new color();

$cod=$_POST['cod'];
$nom=$_POST['nomb'];
$opc=$_GET['opr'];
if ($opc)
{
	$modificar=$objColor->modificarColor($cod,$nom);

		if ($modificar){
       		echo '<SCRIPT>alert("Color Modificado");</SCRIPT>';
          	echo "<SCRIPT>window.location.href='cat_color.php';</SCRIPT>";
         	//$limpiar= $objExpediente->limpiar();
	 	}
		else
			echo '<SCRIPT>alert("Color No Modificado");</SCRIPT>';
}
?>
<!DOCTYPE HTML PUBLIC >
<html>
<head>
	<title>Modificar Clases</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="../controlador/ajax.js"></script>
    <link href="../css/classstyles.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
<form action="" method="post" name="form1" >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td width="50%" background="imagenes/bg.gif"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0"></td>
	<td valign="bottom" background="imagenes/bg_left.gif"><img src="imagenes/bg_left.gif" alt="" width="17" height="16" border="0"></td>
	<td valign="top">
<p>&nbsp;</p>
<table width="50%" align="center">
      <tr ">
        <td colspan="2"><div align="center" class="Not"><strong>Datos a Modificar</strong></div></td>
      </tr>
      <tr >
        <td width="52%" height="23" class="TitNot"><div align="right"><strong>C&oacute;digo:</strong></div></td>
        <?php
			$co=$_GET['codi'];
			$buscarColor = $objColor->buscarColorID($co);
   	    ?>
        <td width="48%"><div align="left">
            <input name="cod" type="text" id="cod" value="<?php  echo $buscarColor[0];?>" readonly="">
          </div>
            <div align="center"> </div></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Descripci&oacute;n:</strong></div></td>
        <td><input name="nomb" type="text" id="nomb" onblur="javascript:this.value=this.value.toUpperCase()" value=" <?php  echo $buscarColor[1];?>"></td>
      </tr>
	  <tr class="menu01" >
				<td height="2" colspan="2"><div align="center" class="NotCelda">
				<div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
				</div></td>
		  </tr>

      <tr >
        <td colspan="2"><div align="center">
            <input type="button"  name="modificar" value="Modificar" onClick="link('mod_color.php?opr=1',document.form1); return false"><input type="button" value="Atras" onClick="javascript:history.back();">
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