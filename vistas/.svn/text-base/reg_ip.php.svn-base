<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/citas.php');

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
/*$permitidos = array(1,3,4,5);
validaAcceso($permitidos,$dir);*/

$objIP = new citas();

$ip =$_POST['ip'];
$reg = $_POST['indReg'];

$fecha = date('d/m/Y');

$data=array($ip,$fecha);



if ($reg==1){

	$buscarIP = $objIP->listarIP($ip,-1);

	if ($buscarIP){

		$bloquearN=$objIP->bloquearIP($ip);

		if ($bloquearN){
		       		echo '<SCRIPT>alert("IP registrada. Fue bloqueada nuevamente");</SCRIPT>';
		       		echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
		       		echo "<SCRIPT>window.close();</SCRIPT>";
		}

	}
	else
	{
		$registro=$objIP->regIP($data);

			if ($registro){
		       		echo '<SCRIPT>alert("IP agregada");</SCRIPT>';
		       		echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
		       		echo "<SCRIPT>window.close();</SCRIPT>";
		  	}
			else
			{
		       		echo '<SCRIPT>alert("IP no agregada");</SCRIPT>';
		       		echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
		       		echo "<SCRIPT>window.close();</SCRIPT>";
		  	}
	}





}

?>
<!DOCTYPE HTML PUBLIC >
<html>
<head>
	<title>Agregar IP</title>
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
        <td colspan="2"><div align="center" class="Not"><strong>Agregar IP</strong></div></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>IP:</strong></div></td>
        <td><input name="ip" type="text" id="ip" value=""></td>
      </tr>
	  <tr class="menu01" >
				<td height="2" colspan="2"><div align="center" class="NotCelda">
				<div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
				</div></td>
		  </tr>

      <tr >
        <td colspan="2"><div align="center">
            <input type="button"  name="agregar" value="Agregar" onClick="validar();">
            <input type="hidden" name="indReg" id="indReg">
        </div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    </td>
</form>
</body>
</html>