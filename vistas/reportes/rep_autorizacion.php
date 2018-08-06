<?php
session_start();
require('../../modelos/conexion.php');
require ('../../controlador/funciones.php');
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(2,3);
validaAcceso($permitidos,$dir);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<?php
 /* include("conexion.php");
  include("funciones_.php");*/
?>
<html>
<head>
  <title>Autorizacion</title>
  <link rel="stylesheet" type="text/css" href="plantilla/HTML/style.css">
    <script type="text/javascript" src="ajax.js"></script>
  <script type="text/javascript" src="validar.js"></script>
    <style type="text/css">
<!--
.Estilo1 {font-size: 16px; font-weight: bold; letter-spacing: 0em; text-align: center; vertical-align: middle; word-spacing: 0em; filter: DropShadow(Color=gray, OffX=1, OffY=2, Positive=3); font-family: Verdana, Arial, Helvetica, sans-serif;}
-->
    </style>
    <link href="css/classstyles.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
 <form action="" method="post" name="form1" >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td width="50%" background="plantilla/HTML/images/bg.gif"><img src="plantilla/HTML/images/px1.gif" width="1" height="1" alt="" border="0"></td>
  <td valign="bottom" background="plantilla/HTML/images/bg_left.gif"><img src="plantilla/HTML/images/bg_left.gif" alt="" width="17" height="16" border="0"></td>
  <td valign="top"> <?php // include("top.php"); ?>
<p>&nbsp;</p>
<table width="822" border="0" align="center" background="imagenes/fondo.jpg"  >
  <tr >
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td><table  width="800" align="center" background="imagenes/fon.jpg">
      <tr class="menu01" >
        <td height="21" colspan="4"><div align="center" class="Estilo1">
          <p class="headline"><font size="4">Autorizaci&oacute;n</font></p>
          </div></td>
      </tr>
      <tr class="menu01" >
        <td height="12" colspan="4"><div align="center" class="NotCelda">
          <div align="center" class="NotCelda"><img src="plantilla/HTML/images/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>


            <tr >
        <td width="311" bordercolor="#6699CC" class="TitNot"><div align="right"><strong>Nombre :</strong></div></td>
        <td width="477" bordercolor="#6699CC" class="grid_line01_tl"><div align="left"><font >

          <input name="nombre" type="text" id="nombre"  onblur="javascript:this.value=this.value.toUpperCase()" size="40" maxlength="40"/>
        </font></div></td>
        </tr>
		<tr >
        <td colspan="2" bordercolor="#6699CC" >       <div align="center">* Nombre Completo de la Persona Autorizada a entregar Medios Magneticos </div></td>
        </tr>
		  <tr >
        <td width="311" bordercolor="#6699CC" class="TitNot"><div align="right"><strong>C&eacute;dula :</strong></div></td>
        <td width="477" bordercolor="#6699CC" class="grid_line01_tl"><div align="left"><font >

          <input name="cedula" type="text" id="cedula"  onblur="javascript:this.value=this.value.toUpperCase()" size="40" maxlength="10" />
        </font></div></td>
        </tr>
		   <tr >
        <td colspan="2" bordercolor="#6699CC"><div align="center">* CI de  la Persona Autorizada a entregar Medios Magneticos </div></td>
        </tr>
		   <tr >
        <td width="311" bordercolor="#6699CC" class="TitNot"><div align="right"><strong>Director(a) :</strong></div></td>
        <td width="477" bordercolor="#6699CC" class="grid_line01_tl"><div align="left"><font >

          <input name="dir" type="text" id="dir"  onblur="javascript:this.value=this.value.toUpperCase()" size="40" maxlength="40"  value="JOSE BENITO GARCIA" />
        </font></div></td>
        </tr>
		 <tr >
        <td colspan="2" bordercolor="#6699CC" ><div align="center">* Nombre Completo del Director(a) que Autoriza
          </div>
        </td>
        </tr>
 <tr >
        <td width="311" bordercolor="#6699CC" class="TitNot"><div align="right"><strong>Departamento:</strong></div></td>
        <td width="477" bordercolor="#6699CC" class="grid_line01_tl"><div align="left"><font >

          <input name="departamento" type="text" id="departamento"  onblur="javascript:this.value=this.value.toUpperCase()" size="40" maxlength="40"  value="Administraci&oacute;n y Servicios Generales" />
        </font></div></td>
        </tr>
		 <tr >
        <td colspan="2" bordercolor="#6699CC" ><div align="center">* Departamento del Director(a) que Autoriza
          </div>
          </td>
        </tr>
      <tr class="menu01" >
        <td height="2" colspan="4"><div align="center" class="NotCelda">
          <div align="center" class="NotCelda"><img src="plantilla/HTML/images/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>
      <tr >
        <td height="26" colspan="4"><div align="center">
          <p>
            <input name="generar" type="button" id="generar" onClick="campos_autorizacion(); return false" value="Generar" />
            <input name="Button" type="button" class="form_button01" value="   Salir    " onClick="cerrar()" />
          </p>
          <p align="left">Nota: Adjuntar Fotocopia de Carnet y C&eacute;dula de Identidad de la persona a la cual se le esta generando la autorizacion.   </p>
        </div></td>
      </tr>
      <tr >
        <td height="26" colspan="4">
          <label></label>      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<?php //include("pie.html"); ?></td>
  <td valign="bottom" background="plantilla/HTML/images/bg_right.gif"><img src="plantilla/HTML/images/bg_right.gif" alt="" width="17" height="16" border="0"></td>
  <td width="50%" background="plantilla/HTML/images/bg.gif"><img src="plantilla/HTML/images/px1.gif" width="1" height="1" alt="" border="0"></td>
</tr>
</table>
</form>
</body>
</html>