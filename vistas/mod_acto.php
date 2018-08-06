<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/acto.php');

 $objActo = new acto();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5);
validaAcceso($permitidos,$dir);


$opc=$_GET['opr'];

$cod=$_POST['cod'];
$fec=$_POST['fec'];
$nom=$_POST['nomb'];

if ($opc)
{
	$modificar=$objActo->modificarActo($cod,$fec,$nom);

		if ($modificar){
       		echo '<SCRIPT>alert("Acto Modificado");</SCRIPT>';
          	echo "<SCRIPT>window.location.href='cat_acto.php';</SCRIPT>";
         	//$limpiar= $objExpediente->limpiar();
	 	}
		else
			echo '<SCRIPT>alert("Acto No Modificado");</SCRIPT>';
}
?>
<!DOCTYPE HTML PUBLIC>
<html>
<head>
  <title>Modificar Acto</title>
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
  	   	$buscarActos = $objActo->buscarActoID($co);
	   ?>
        <td width="50%"><input name="cod" type="text" id="cod" value="<?php  echo $buscarActos[0];?>" readonly></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Fecha:</strong></div></td>
        <td><input name="fec" type="text" id="fec" value="<?php  echo $buscarActos[1];?>" size="15" ></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Descripci&oacute;n:</strong></div></td>
        <td><input name="nomb" type="text" id="nomb" value="<?php  echo $buscarActos[2];?>" onblur="javascript:this.value=this.value.toUpperCase()"></td>
      </tr>
         <tr >
        <td height="12" colspan="2"><div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1"></div></td>
      </tr>
      <tr >
        <td colspan="2"><div align="center">
            <input type="button"  name="eliminar" value="Modificar" onClick="link('mod_acto.php?opr=1',document.form1); return false"><input type="button" value="Atras" onClick="javascript:history.back();">
        </div></td>
      </tr>
    </table>
</form>
</body>
</html>