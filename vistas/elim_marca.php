<?php
session_start();
require('../modelos/conexion.php');
require('../modelos/marca.php');
require('../controlador/funciones.php');
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(3,2);
validaAcceso($permitidos,$dir);

$objMarca = new marca();

$opc=$_GET['opr'];
$cod=$_POST['cod'];
$nom=$_POST['nomb'];


if ($opc)
{
	$eliminar=$objMarca->eliminarMarca($cod,$nom);

		if ($eliminar){
       		echo '<SCRIPT>alert("Marca eliminada");</SCRIPT>';
          	echo "<SCRIPT>window.location.href='marca2.php';</SCRIPT>";
         	//$limpiar= $objExpediente->limpiar();
	 	}
		else
		{
			echo '<SCRIPT>alert("Marca No eliminada");</SCRIPT>';
			echo "<SCRIPT>window.location.href='marca2.php';</SCRIPT>";
		}

}


?>
<!DOCTYPE HTML PUBLIC>
<html>
<head>
	<title>Eliminar Marcas</title>
    <script type="text/javascript" src="../controlador/ajax.js"></script>

    <link href="../css/classstyles.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
<form action="" method="post" name="form1" >
<table border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
  <tr>
	<td width="50%"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0"></td>
	<td valign="bottom" background="imagenes/bg_left.gif"><img src="imagenes/bg_left.gif" alt="" width="17" height="16" border="0"></td>
	<td valign="top">
<table  width="48%" height="171" align="center">
      <tr  class="Not">
        <td colspan="2"><div align="center"><strong>Datos a Eliminar</strong></div></td>
      </tr>
      <tr >
        <td width="52%" height="23" class="TitNot"><div align="right"><strong>C&oacute;digo:</strong></div></td>
        <?php
		$co=$_GET['codi'];
		$buscarMarca = $objMarca->buscarMarca($co);
		?>
        <td width="48%"><div align="left">
            <input name="cod" type="text" id="cod" value="<?php  echo $buscarMarca[0];?>" size="30" maxlength="3" readonly="" >
          </div>
            <div align="center"> </div></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Descripci&oacute;n:</strong></div></td>
        <td><input name="nomb" type="text" id="nomb" onBlur="javascript:this.value=this.value.toUpperCase()" value=" <?php  echo $buscarMarca[1];?>" size="30" maxlength="30"></td>
      </tr>
      <tr >
        <td height="12" colspan="2"><div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1"></div></td>
      </tr>
      <tr >
        <td colspan="2"><div align="center">
          <input type="button"  name="eliminar" value="Eliminar" onClick="link('elim_marca.php?opr=1',document.form1); return false"><input type="button" value="Atras" onClick="javascript:history.back();">

        </div></td>
      </tr>
    </table>
    </td>
	<td valign="bottom" background="imagenes/bg_right.gif"><img src="imagenes/bg_right.gif" alt="" width="17" height="16" border="0"></td>
	<td width="50%" background="imagenes/bg.gif"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0"></td>
</tr>
</table>
</form>
</body>
</html>