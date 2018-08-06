<?php
session_start();
/*require('../controlador/funciones.php');
require('../modelos/conexion.php');
require('../modelos/departamentos.php');

$objDpto = new departamentos();
$listDpto = $objDpto->listarDpto();*/
?>
<!DOCTYPE html PUBLIC >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cat&aacute;logo Lote</title>
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
        <td height="21" colspan="2"><div align="center" class="headline"><font ><strong>Lote</strong></font></div></td>
      </tr>
      <tr class="menu01" >
        <td height="2" colspan="2"><div align="center" class="NotCelda">
            <div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>
      <tr >
        <td width="46%" class="TitNot"><p align="right"><strong>Fecha:</strong></p></td>
        <td width="54%"><font color="#FFFFFF">
          <input name="fec" type="text" id="fec"  onblur="javascript:this.value=this.value.toUpperCase()" size="15" maxlength="10" />
          <img src="../images/cal.gif" width="16" height="16" onclick="show_calendar('document.forms[0].fec',document.forms[0].fec.value)" onkeyup="buscarDatosLote('con_cat_lot.php'); return false" /></font></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Descripci&oacute;n:</strong></div></td>
        <td><font color="#FFFFFF">
          <input name="nomb" type="text" id="nomb" maxlength="30" onblur="javascript:this.value=this.value.toUpperCase()" onkeyup="buscarDatosLote('con_cat_lot.php'); return false" />
        </font></td>
      </tr>
       <tr ><td class="TitNot"><div align="right"><strong>Departamento:</strong></div></td>
           <!-- <td>
              <select name="dep">
               <option value="0">Departamento</option>
               <?php for($i=0;$i<count($listDpto);$i+=2){?>
    	        <option value="<?php echo $listDpto[$i]?>">
    	         <?php echo utf8_decode($listDpto[$i+1]);?>
    	        </option>
               <?php }?>
              </select>
             </td>-->

				 <td  width="15%"align="left" colspan='2'>
				 <SELECT name="dep" id="dep">
        			<OPTION value="0">Departamento</OPTION>
        			<OPTION value="1">VEHICULOS</OPTION>
        			<OPTION value="2">COMERCIALIZACION</OPTION>
				 </SELECT>
			     </td>
      </tr>
      <tr class="menu01" >
        <td height="2" colspan="2"><div align="center" class="NotCelda">
            <div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
        </div></td>
      </tr>
      <tr >
        <td height="26" colspan="2"><div align="center">
            <input type="button" name="buscar" value="Buscar" onclick="buscarDatosLote('con_cat_lot.php'); return false" />
          <!--  <input name="Nuevo" type="button" id="Nuevo" onclick="enviar_funciones('agre_lote.php?opr=alot'); return false" value="Nuevo" /> -->
        </div></td>
      </tr>
      <tr >
        <td height="26" colspan="2"><div id="resultado">
            <?php   $_SESSION['lotetipoU']= $_GET['lot'];
                    include('con_cat_lot.php');?>
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
 </form>
</body>
</html>