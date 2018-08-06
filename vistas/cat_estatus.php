<!DOCTYPE html PUBLIC >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cat&aacute;logo Estatus</title>
<script type="text/javascript" src="../controlador/ajax.js"></script>
<script type="text/javascript" src="../controlador/validar.js"></script>
<link href="../css/classstyles.css" rel="stylesheet" type="text/css" />


<script>

function validarCaract(dato){
var letras_mayusculas="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ ";
if (document.form1.descripcion.value.length==0){
    alert("Debe Ingresar la Descripcion");
    document.form1.descripcion.focus()
    return (false);
 }else
 {
   var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   if (!filter.test(document.form1.descripcion.value)) {
   alert('Carácteres no válidos en  la Descripcion');
   document.form1.descripcion.focus();
   return (false);}
 }

 if (document.form1.orden.value.length==0){
    alert("Debe Ingresar el Orden");
    document.form1.orden.focus()
    return (false);
 }else
 {
   var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   if (!filter.test(document.form1.orden.value)) {
   alert('Carácteres no válidos en  el orden');
   document.form1.orden.focus();
   return (false);}
    }

document.form1.indReg.value = dato;
 document.form1.submit();
  }
</script>


<!--
body {
	background-color: #FFFFFF;
}
-->
</head>

<body>
 <form action="" method="post" name="form1" >
   <table width="200" border="0" align="center" background="imagenes/fondo.jpg"  >
  <tr >
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td><table  width="44%" height="197" align="center" background="imagenes/fon.jpg">
      <tr class="menu01" >
        <td height="21" colspan="2"><div align="center" class="headline"><font ><strong> Estatus </strong></font></div></td>
      </tr>
      <tr class="menu01" >
        <td height="2" colspan="2"><div align="center" class="NotCelda">
            <div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      <tr >
        <td class="TitNot"><div align="right"><strong>Descripci&oacute;n:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="descripcion" type="text" id="descripcion" maxlength="30" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosEstatus('con_cat_estatus.php'); return false"  />
        </font></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>&Oacute;rden:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="orden" type="text" id="orden" maxlength="5" onkeypress="return acessoNumerico(event)" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosEstatus('con_cat_estatus.php'); return false" />
        </font></td>
      </tr>
      <tr class="menu01" >
        <td height="2" colspan="2"><div align="center" class="NotCelda">
            <div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>
      <tr >
        <td height="26" colspan="2"><div align="center">
          <input type="button" name="buscar" value="Buscar" onclick=" validarCaract(); buscarDatosEstatus('con_cat_estatus.php?opr=1'); return false"  />
        <!--  <input name="Nuevo" type="button" id="Nuevo" onclick="enviar_funciones('agre_estado.php?opr=aest'); return false" value="Nuevo" />-->
        </div></td>
      </tr>
      <tr >
        <td height="26" colspan="2"><div id="resultado">
            <?php  include('con_cat_estatus.php');?>
        </div></td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
 </form>
</body>
</html>