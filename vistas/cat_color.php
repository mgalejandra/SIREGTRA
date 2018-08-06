<? session_start(); ?><!DOCTYPE html PUBLIC>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cat&aacute;logo Color</title>
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
        <td height="21" colspan="2"><div align="center" class="headline"><font ><strong> Color </strong></font></div></td>
      </tr>
      <tr class="menu01" >
        <td height="2" colspan="2"><div align="center" class="NotCelda">
            <div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>
      <tr >
        <td width="46%" class="TitNot"><p align="right"><strong>C&oacute;digo:</strong></p></td>
        <td width="54%"><font color="#FFFFFF">
          <input name="cod" type="text" id="cod" maxlength="3"  onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosColor('con_cat_color.php'); return false" />
        </font></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Descripci&oacute;n:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="nomb" type="text" id="nomb" maxlength="30" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosColor('con_cat_color.php'); return false" />
        </font></td>
      </tr>

      <tr class="menu01" >
        <td height="2" colspan="2"><div align="center" class="NotCelda">
            <div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>
      <tr >
        <td height="26" colspan="2"><div align="center">
          <font color="#FFFFFF">
		  <?php
		  $colop=$_GET['colop'];
		  ?>
          <input type="hidden" name="colop"  value="<? echo $colop;?>"/>
          </font>
          <input type="button" name="buscar" value="Buscar" onclick="buscarDatosColor('con_cat_color.php?colop=<? echo $colop;?>'); return false" />
        <!--  <input name="Nuevo" type="button" id="Nuevo" onclick="enviar_funciones('agre_lote.php?opr=alot'); return false" value="Nuevo" /> -->
        </div></td>
      </tr>
      <tr >
        <td height="26" colspan="2"><div id="resultado">
            <?php
			 $colop=$_GET['colop'];
			 $_SESSION['colortipoU']= $_GET['col1'];
			 include('con_cat_color.php');?>
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
 </form>
</body>
</html>