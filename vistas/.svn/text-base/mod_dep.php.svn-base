<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
 require('../modelos/departamento.php');


 $objDepartamento = new departamento();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5);
validaAcceso($permitidos,$dir);



 $opc=$_GET['opr'];
$numdep=$_POST['numdep'];
$descdep=$_POST['descdep'];
$opr=$_GET['opr'];
$env=$_POST['env'];


if ($opc)
{

	$modificar=$objDepartamento->modificarDpto($numdep,$descdep);

		if ($modificar){
       		echo '<SCRIPT>alert("Estatus Modificado");</SCRIPT>';
          	echo "<SCRIPT>window.location.href='cat_dep.php';</SCRIPT>";
         	//$limpiar= $objExpediente->limpiar();
	 	}
		else
			echo '<SCRIPT>alert("Estatus No Modificado");</SCRIPT>';
}
        if ($_GET['codi'])
  	    $co=$_GET['codi'];
  	    else
  	    $co=$_POST['numdep'];
  	   	$buscarDpto = $objDepartamento->listarDepartamento($co);

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
        <td width="50%" class="TitNot"><div align="right"><strong>N&uacute;mero:</strong></div></td>

        <td width="50%"><input name="numdep" type="text" id="numdep" value="<?php  echo $buscarDpto[0];?>" readonly></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Nombre:</strong></div></td>
        <td><input name="descdep" type="text" id="descdep" value="<?php  echo $buscarDpto[1];?>" onblur="javascript:this.value=this.value.toUpperCase()"></td>
      </tr>
         <tr >
        <td height="12" colspan="2"><div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1"></div></td>
      </tr>
      <tr >
        <td colspan="2"><div align="center">
            <input type="button"  name="modificar" value="Modificar"  onClick="link('mod_dep.php?opr=1',document.form1); return false") >
            <input type="button" value="Atras" onClick="javascript:history.back();">
        </div></td>
      </tr>
    </table>
</form>
</body>
</html>