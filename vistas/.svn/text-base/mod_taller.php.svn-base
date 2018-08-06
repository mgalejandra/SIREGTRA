<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/taller.php');

$objTaller = new taller();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5);
validaAcceso($permitidos,$dir);


$opc=$_GET['opr'];

$cod=$_POST['cod'];
 $rif=$_POST['rif'];
 $nom=$_POST['nomb'];
 $dir=$_POST['dir'];
 $contacto=$_POST['contac'];
 $telf=$_POST['telf'];

if ($opc)
{
	$modificar=$objTaller->modificarTaller($nom,$rif,$dir,$contacto,$telf,$cod);

		if ($modificar){
       		echo '<SCRIPT>alert("Taller Modificado");</SCRIPT>';
          	echo "<SCRIPT>window.location.href='cat_taller.php';</SCRIPT>";
	 	}
		else
			echo '<SCRIPT>alert("Taller No Modificado");</SCRIPT>';
}
?>
<!DOCTYPE HTML PUBLIC >
<html>
<head>
  <title>Modificar Taller</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <script type="text/javascript" src="../controlador/ajax.js"></script>
  <link href="../css/classstyles.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
<form action="" method="post" name="form1" >

    <table width="50%" height="147" align="center">
      <tr>
        <td colspan="2" ><div align="center" class="Not"><strong>Datos a Modificar </strong></div></td>
      </tr>
      <tr >
        <td width="50%" class="TitNot"><div align="right"><strong>N&uacute;mero:</strong></div></td>
        <?php
  	    $co=$_GET['codi'];
  	   	$buscarTaller = $objTaller->buscarTallerID($co);
	   ?>
        <td width="50%"><input name="cod" type="text" id="cod" value="<?php  echo $buscarTaller[0];?>" readonly></td>
      </tr>
    <tr >
        <td class="TitNot"><div align="right"><strong>RIF:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="rif" type="text" id="rif" maxlength="12" value="<?php  echo $buscarTaller[4];?>" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosTaller('con_cat_taller.php'); return false" />
        </font></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Nombre:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="nomb" type="text" id="nomb" maxlength="30" value="<?php  echo $buscarTaller[1];?>" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosTaller('con_cat_taller.php'); return false" />
        </font></td>
      </tr>
       <tr >
        <td class="TitNot"><div align="right"><strong>Direcci&oacute;n:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="dir" type="text" id="dir" maxlength="30" value="<?php  echo $buscarTaller[2];?>" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosTaller('con_cat_taller.php'); return false" />
        </font></td>
      </tr>
         <tr >
        <td class="TitNot"><div align="right"><strong>Tel&eacute;fono:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="telf" type="text" id="telf" maxlength="12"  value="<?php  echo $buscarTaller[3];?>" onkeypress="return acessoNumerico(event)" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosTaller('con_cat_taller.php'); return false" />
        </font></td>
      </tr>
       <tr >
        <td class="TitNot"><div align="right"><strong>Contacto:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="contac" type="text" id="contac" maxlength="30" value="<?php  echo $buscarTaller[5];?>" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosTaller('con_cat_taller.php'); return false" />
        </font></td>
      </tr>
         <tr >
        <td height="12" colspan="2"><div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1"></div></td>
      </tr>
      <tr >
        <td colspan="2"><div align="center">
            <input type="button"  name="modificar" value="Modificar" onClick="link('mod_taller.php?opr=1',document.form1); return false"><input type="button" value="Atras" onClick="javascript:history.back();">
        </div></td>
      </tr>
    </table>
</form>
</body>
</html>