<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/serie.php');
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(3,2);
validaAcceso($permitidos,$dir);

$opc=$_GET['opr'];
$cod=$_GET['codi'];
$codi=$_POST['cod'];

$objSerie = new series();

if ($opc)
{
   $eliminar=$objSerie->eliminarSerie($codi);

   if ($eliminar){
       		echo '<SCRIPT>alert("Serie eliminada");</SCRIPT>';
          	echo "<SCRIPT>window.location.href='cat_serie.php';</SCRIPT>";
         	//$limpiar= $objExpediente->limpiar();
   }
   else
   {
				echo '<SCRIPT>alert("Serie no eliminada");</SCRIPT>';
				echo "<SCRIPT>window.location.href='cat_serie.php';</SCRIPT>";
   }
}
?>
<!DOCTYPE HTML PUBLIC>
<html>
<head>
	<title>Eliminar Serie</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="../controlador/ajax.js"></script>
    <link href="../css/classstyles.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
<form action="" method="post" name="form1" >

    <table width="35%" align="center">
      <tr >
        <td colspan="2" ><div align="center" class="Not"><strong>Datos a Eliminar </strong></div></td>
      </tr>
      <tr >
        <td width="50%" class="TitNot"><div align="right"><strong>C&oacute;digo:</strong></div></td>
         <?php
     		 $co=$_GET['codi'];
	         $buscarSerie=$objSerie->buscarSerieID($co);
	   	 ?>
        <td width="50%"><input name="cod" type="text" id="cod" value=" <?php  echo  $buscarSerie[0];?>" readonly></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Descripci&oacute;n:</strong></div></td>
        <td><input name="des" type="text" id="des" value=" <?php  echo  $buscarSerie[1];?>" ></td>
      </tr>
      <tr class="menu01" >
        <td height="2" colspan="2"><div align="center" class="NotCelda">
            <div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>
      <tr >
        <td colspan="2"><div align="center">
            <input type="button"  name="eliminar" value="Eliminar" onClick="link('elim_serie.php?opr=1',document.form1); return false"><input type="button" value="Atras" onClick="javascript:history.back();">

        </div></td>
      </tr>
    </table>
</form>
</body>
</html>