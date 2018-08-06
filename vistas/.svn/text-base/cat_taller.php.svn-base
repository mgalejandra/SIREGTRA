<!DOCTYPE html PUBLIC >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cat&aacute;logo Talleres</title>
<script type="text/javascript" src="../controlador/ajax.js"></script>
<script type="text/javascript" src="../controlador/validar.js"></script>
<link href="../css/classstyles.css" rel="stylesheet" type="text/css" />
</head>
<body>
 <form action="" method="post" name="form1" >
   <table width="200" border="0" align="center" background="imagenes/fondo.jpg"  >
  <tr >
    <td><table  width="44%" height="197" align="center" background="imagenes/fon.jpg">
      <tr class="menu01" >
        <td height="21" colspan="2"><div align="center" class="headline"><font ><strong>Taller</strong></font></div></td>
      </tr>
      <tr class="menu01" >
        <td height="2" colspan="2"><div align="center" class="NotCelda">
            <div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>RIF:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="rif" type="text" id="rif" maxlength="12" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosTaller('con_cat_taller.php'); return false" />
        </font></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Nombre:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="nomb" type="text" id="nomb" maxlength="30" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosTaller('con_cat_taller.php'); return false" />
        </font></td>
      </tr>
       <tr >
        <td class="TitNot"><div align="right"><strong>Direcci&oacute;n:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="dir" type="text" id="dir" maxlength="30" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosTaller('con_cat_taller.php'); return false" />
        </font></td>
      </tr>
         <tr >
        <td class="TitNot"><div align="right"><strong>Tel&eacute;fono:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="telf" type="text" id="telf" maxlength="12" onkeypress="return acessoNumerico(event)" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosTaller('con_cat_taller.php'); return false" />
        </font></td>
      </tr>
       <tr >
        <td class="TitNot"><div align="right"><strong>Contacto:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="contac" type="text" id="contac" maxlength="30" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosTaller('con_cat_taller.php'); return false" />
        </font></td>
      </tr>
      <tr class="menu01" >
        <td height="2" colspan="2"><div align="center" class="NotCelda">
            <div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>
      <tr >
        <td height="26" colspan="2"><div align="center">
            <input type="button" name="buscar" value="Buscar" onclick="buscarDatosTaller('con_cat_taller.php'); return false" />
        </div></td>
      </tr>
      <tr >
        <td height="26" colspan="2"><div id="resultado">
            <?php  include('con_cat_taller.php');?>
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
 </form>
</body>
</html>