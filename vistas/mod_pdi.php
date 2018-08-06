<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/vehiculos.php');

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
/*$permitidos = array(1,3,4,5);
validaAcceso($permitidos,$dir);*/

$objVehiculo = new vehiculos();

$sercarveh=$_GET['sercarveh'];
$comentario =$_POST['obspro'];
$reg = $_POST['indReg'];

if ($reg==1){
   $cambioPDI = $objVehiculo->activarVehiculo($sercarveh,$comentario);

	if ($cambioPDI){
       		echo '<SCRIPT>alert("Vehiculo '.$sercarveh.' desmarcado como PDI No aprobado");</SCRIPT>';
       		echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
       		echo "<SCRIPT>window.close();</SCRIPT>";
  	}
	else
	{
       		echo '<SCRIPT>alert("Error al desmarcar vehiculo NO PDI");</SCRIPT>';
       		echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
       		echo "<SCRIPT>window.close();</SCRIPT>";
  	}

}

?>
<!DOCTYPE HTML PUBLIC >
<html>
<head>
	<title>Marcar Vehiculo como No PDI</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
    <link href="../css/classstyles.css" rel="stylesheet" type="text/css">

     <SCRIPT language="JavaScript">
    function validar(){
      document.form1.indReg.value = 1;
      document.form1.submit();
    }
   </SCRIPT>
</head>
<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
<form action="" method="post" name="form1" >
<table width="50%" align="center">
      <tr ">
        <td colspan="2"><div align="center" class="Not"><strong>Marcar Vehiculo como PDI apto</strong></div></td>
      </tr>
      <tr >
        <td width="60%" height="23" class="TitNot"><div align="right"><strong>Serial a marcar como Apto:</strong></div></td>
        <td width="40%"><? echo $sercarveh; ?></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Observacion:</strong></div></td>
        <td><textarea name="obspro" cols="60" rows="2" id="obspro"  onblur="javascript:this.value=this.value.toUpperCase()" ></textarea>
      </tr>
	  <tr class="menu01" >
				<td height="2" colspan="2"><div align="center" class="NotCelda">
				<div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
				</div></td>
		  </tr>

      <tr >
        <td colspan="2"><div align="center">
            <input type="button"  name="marcar" value="Marcar como Apto" onClick="validar();">
            <input type="hidden" name="indReg" id="indReg">
        </div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    </td>
</form>
</body>
</html>