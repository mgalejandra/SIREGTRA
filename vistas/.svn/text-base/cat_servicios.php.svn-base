
<?php
session_start();
/*require('../modelos/conexion.php');
require('../modelos/consulta.php');
require('../controlador/funciones.php');


	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,6,7,11,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23);*/

?>

<!DOCTYPE html PUBLIC >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cat&aacute;logo Servicios</title>
<script type="text/javascript" src="../controlador/ajax.js"></script>
<script type="text/javascript" src="../controlador/validar.js"></script>
<link href="../css/classstyles.css" rel="stylesheet" type="text/css" />
</head>
<body>
 <form action="" method="post" name="form1" >
   <table width="200" border="0" align="center" background="imagenes/fondo.jpg"  >
  <tr >
    <td><table width="44%" height="197" align="center" background="imagenes/fon.jpg">
      <tr class="menu01" >
        <td height="21" colspan="2"><div align="center" class="headline"><font ><strong> Servicios </strong></font></div></td>
      </tr>
      <tr class="menu01" >
        <td height="2" colspan="2"><div align="center" class="NotCelda">
            <div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>
      <tr >
        <td width="46%" class="TitNot"><p align="right"><strong>C&oacute;digo:</strong></p></td>
        <td width="54%"><font color="#FFFFFF">
          <input name="cod" type="text" id="cod" maxlength="3"  onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosServicios('con_cat_servicios.php'); return false" />
        </font></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Descripci&oacute;n:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="nomb" type="text" id="nomb" maxlength="30" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosServicios('con_cat_servicios.php'); return false" />
        </font></td>
      </tr>

      <tr class="menu01" >
        <td height="2" colspan="2"><div align="center" class="NotCelda">
            <div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>
      <tr >
        <td height="26" colspan="2"><div align="center">
          <input type="button" name="buscar" value="Buscar" onclick="buscarDatosServicios('con_cat_servicios.php'); return false" />

        </div></td>
      </tr>
      <tr >
        <td height="26" colspan="2"><div id="resultado">
            <?php include('con_cat_servicios.php');?>
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
 </form>
</body>
</html>