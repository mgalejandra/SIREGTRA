<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/citas.php');
require('../modelos/consulta.php');

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
/*$permitidos = array(1,3,4,5);
validaAcceso($permitidos,$dir);*/

$objConsulta = new consulta();

$rif=$_GET['rif'];
$estatus =$_POST['estatus'];
$reg = $_POST['indReg'];

$buscarC = $objConsulta->consultaCredito2($rif);

if ($reg==1){
	$modificar=$objConsulta->cambioEstatus($rif,$estatus);

	if ($modificar){
       		echo '<SCRIPT>alert("Estatus Modificado");</SCRIPT>';
       		echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
       		echo "<SCRIPT>window.close();</SCRIPT>";
  	}
	else
	{
       		echo '<SCRIPT>alert("Estatus no Modificado");</SCRIPT>';
       		echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
       		echo "<SCRIPT>window.close();</SCRIPT>";
  	}

}

?>
<!DOCTYPE HTML PUBLIC >
<html>
<head>
	<title>Modificar Correo</title>
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
        <td colspan="2"><div align="center" class="Not"><strong>Modificar Estatus</strong></div></td>
      </tr>
      <tr >
        <td width="52%" height="23" class="TitNot"><div align="right"><strong>Rif:</strong></div></td>
        <td width="48%"><? echo $rif; ?></td>
      </tr>
      <tr >
        <td width="52%" height="23" class="TitNot"><div align="right"><strong>Estatus Actual:</strong></div></td>
        <td width="48%"><? echo $buscarC[0]; ?></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Estatus Nuevo:</strong></div></td>
        <td class="dato" colspan="3" >
          <select name="estatus"  id="estatus">
                <option value="<?php if ($buscarC) echo $buscarC[1] ?>"><?php if ($buscarC) echo $buscarC[0] ?></option>
                <option value="3">A LA ESPERA DE DOCUMENTOS</option>
                <option value="2">CREDITO EN ANALISIS BANCARIO</option>
                 <option value="4">CREDITO APROBADO</option>
                 <option value="17">CREDITO DIFERIDO</option>
                <option value="16">CREDITO RECHAZADO</option>
                <option value="30">DEVUELTO POR DOCUMENTACION INCOMPLETA</option>
			    <option value="31">IMPOSIBLE VERIFICAR CONSTANCIA</option>
				<option value="32">DEVUELTO POR CAMBIO DE GARANTIA</option>
          </select>
        </td>
      </tr>
	  <tr class="menu01" >
				<td height="2" colspan="2"><div align="center" class="NotCelda">
				<div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
				</div></td>
		  </tr>

      <tr >
        <td colspan="2"><div align="center">
            <input type="button"  name="modificar" value="Modificar" onClick="validar();">
            <input type="hidden" name="indReg" id="indReg">
        </div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    </td>
</form>
</body>
</html>