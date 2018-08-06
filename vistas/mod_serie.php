<?php
require('../modelos/conexion.php');
require('../modelos/serie.php');

$objSerie = new series();
$opc=$_GET['opr'];
$cod=$_POST['cod'];
$nom=$_POST['des'];

if ($opc)
{
	$modificar=$objSerie->modificarSerie($cod,$nom);

		if ($modificar){
       		echo '<SCRIPT>alert("Serie Modificada");</SCRIPT>';
          	echo "<SCRIPT>window.location.href='cat_serie.php';</SCRIPT>";
         	//$limpiar= $objExpediente->limpiar();
	 	}
		else
			echo '<SCRIPT>alert("Serie No Modificada");</SCRIPT>';
}
?>
<html>
<head>
	<title>Modificar Serie</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="../controlador/ajax.js"></script>
	<script type="text/javascript" src="../controlador/validar.js"></script>
    <link href="../css/classstyles.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
<form action="" method="post" name="form1" >

    <table width="35%" align="center">
      <tr >
        <td colspan="2" ><div align="center" class="Not"><strong>Datos a Modificar</strong></div></td>
      </tr>
      <tr >
        <td width="50%" class="TitNot"><div align="right"><strong>C&oacute;digo:</strong></div></td>
        <?php
     		 $co=$_GET['codi'];
	         $buscarSerie=$objSerie->buscarSerieID($co);
	   ?>
        <td width="50%"><input name="cod" type="text" id="cod" value=" <?php  echo $buscarSerie[0];?>" readonly></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Descripci&oacute;n:</strong></div></td>
        <td><input name="des" type="text" id="des" value=" <?php  echo $buscarSerie[1];?>" onblur="javascript:this.value=this.value.toUpperCase()" ></td>
      </tr>
		<tr class="menu01" >
        <td height="2" colspan="2"><div align="center" class="NotCelda">
            <div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>
      <tr >
        <td colspan="2"><div align="center">
          <input type="button"  name="eliminar" value="Modificar" onClick="link('mod_serie.php?opr=1',document.form1);return false"><input type="button" value="Atras" onClick="javascript:history.back();">
        </div></td>
      </tr>
    </table>
</form>
</body>
</html>