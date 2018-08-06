<?php
session_start();
require('../modelos/conexion.php');
require('../modelos/citas.php');
require('../controlador/funciones.php');
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++) $uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
/*$permitidos = array(3);
validaAcceso($permitidos,$dir);*/

$objIP = new citas();

$cod=$_POST['cod'];
$nom=$_POST['nomb'];
$opc=$_GET['opr'];

if ($opc)
{
	$eliminar=$objIP->borrarIP($nom);

		if ($eliminar){
       		echo '<SCRIPT>alert("IP desbloqueada");</SCRIPT>';
          	echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
       		echo "<SCRIPT>window.close();</SCRIPT>";
	 	}
		else
		{
			echo '<SCRIPT>alert("No se pudo desbloquear la IP");</SCRIPT>';
			echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
       		echo "<SCRIPT>window.close();</SCRIPT>";
		}

}
?>
<!DOCTYPE HTML PUBLIC >
<html>
<head>
<title>Eliminar IP</title>
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
			$buscarIP = $objIP->listarIP($co,-1);
		   ?>
        <td width="50%"><input name="cod" type="text" id="cod" value=" <?php  echo $buscarIP[0];?>" readonly></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right" >IP:</div></td>
        <td><input name="nomb" type="text" id="nomb" value="<?php  echo $buscarIP[1];?>" readonly></td>
      </tr>
	  <tr class="menu01" >
				<td height="2" colspan="2"><div align="center" class="NotCelda">
				<div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
				</div></td>
		  </tr>

      <tr >
        <td colspan="2"><div align="center">
            <input type="button"  name="eliminar" value="Desbloquear" onClick="link('elim_ip.php?opr=1',document.form1); return false">
        </div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    </td>
	</tr>
</table>
</form>
</body>
</html>