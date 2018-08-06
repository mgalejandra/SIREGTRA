<!DOCTYPE html PUBLIC >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cat&aacute;logo Departamentos</title>
<script type="text/javascript" src="../controlador/ajax.js"></script>
<script type="text/javascript" src="../controlador/validar.js"></script>
<link href="../css/classstyles.css" rel="stylesheet" type="text/css" />

<script>

function validarCaract(dato){
var letras_mayusculas="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ ";
if (document.form1.descdep.value.length==0){
    alert("Debe Ingresar la Descripcion");
    document.form1.descdep.focus()
    return (false);
 }else
 {
   var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   if (!filter.test(document.form1.descdep.value)) {
   alert('Carácteres no válidos en la Descripcion');
   document.form1.descdep.focus();
   return (false);}
 }
document.form1.indReg.value = dato;
 document.form1.submit();
  }
</script>

</head>

<body>
 <form action="" method="post" name="form1" >
   <table width="200" border="0" align="center" background="imagenes/fondo.jpg"  >
  <tr >
    <td><table  width="44%" height="197" align="center" background="imagenes/fon.jpg">
      <tr class="menu01" >
        <td height="21" colspan="2"><div align="center" class="headline"><font ><strong>Departamentos</strong></font></div></td>
      </tr>
      <tr class="menu01" >
        <td height="2" colspan="2"><div align="center" class="NotCelda">
            <div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Descripcion:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="descdep" type="text" id="descdep" maxlength="30"  onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosDpto('con_cat_dep.php'); return false" />
        </font></td>
      </tr>

      <tr class="menu01" >
        <td height="2" colspan="2"><div align="center" class="NotCelda">
            <div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>
      <tr >
        <td height="26" colspan="2"><div align="center">
             <input type="button" name="buscar" value="Buscar" onclick="validarCaract();buscarDatosDpto('con_cat_dep.php?opr=1'); return false" />
         </div></td>
      </tr>
      <tr >
        <td height="26" colspan="2"><div id="resultado">
            <?php  include('con_cat_dep.php');?>
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
 </form>
</body>
</html>