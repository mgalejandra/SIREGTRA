<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
 require('../modelos/estatus.php');


 $objEstatus = new estatus();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5);
validaAcceso($permitidos,$dir);



 $opc=$_GET['opr'];
$id_estatus=$_POST['id_estatus'];
$descripcion=$_POST['descripcion'];
$orden=$_POST['orden'];
$env=$_POST['env'];


if ($opc)
{

	$modificar=$objEstatus->modificarEstatus($id_estatus,$descripcion,$orden);

		if ($modificar){
       		echo '<SCRIPT>alert("Estatus Modificado");</SCRIPT>';
          	echo "<SCRIPT>window.location.href='cat_estatus.php';</SCRIPT>";
	 	}
		else
			echo '<SCRIPT>alert("Estatus No Modificado");</SCRIPT>';
}
        if ($_GET['codi'])
  	    $co=$_GET['codi'];
  	    else
  	    $co=$_POST['id_estatus'];
  	   	$buscarEstatus = $objEstatus->listarEstatus($co);

?>
<!DOCTYPE HTML PUBLIC >
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
        <td width="50%" class="TitNot"><div align="right"><strong>C&uacute;digo:</strong></div></td>

        <td width="50%"><input name="id_estatus" type="text" id="id_estatus" value="<?php  echo $buscarEstatus[0];?>" readonly></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Descripci&oacute;n:</strong></div></td>
        <td><input name="descripcion" type="text" id="descripcion" value="<?php  echo $buscarEstatus[1];?> " onblur="javascript:this.value=this.value.toUpperCase()" ></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>&Oacute;rden:</strong></div></td>
        <td><input name="orden" type="text" id="orden" value="<?php  echo $buscarEstatus[2];?>" onblur="javascript:this.value=this.value.toUpperCase()"></td>
      </tr>

         <tr >
        <td height="12" colspan="2"><div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1"></div></td>
      </tr>
      <tr >
        <td colspan="2"><div align="center">
            <input type="button"  name="modificar" value="Modificar" onClick="link('mod_estatus.php?opr=1',document.form1); return false"><input type="button" value="Atras" onClick="javascript:history.back();">
        </div></td>
      </tr>
    </table>
</form>
</body>
</html>