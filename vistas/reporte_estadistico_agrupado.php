<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/reportes.php');
require('../modelos/pago.php');
require('../modelos/banco.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,11,15,18,25);
	validaAcceso($permitidos,$dir);

	$banco= $_POST['banco'];
	$indBusq= $_POST['indBusq'];


    $objReportes=new reportes();
    $objPago = new pago();
    $objBanco = new banco();



    $listarBancos=$objPago->listarBancos(3);

    $nombreBancos=$objBanco->listarBancos($banco);

	$estadisticas_agrupadas=$objReportes->estadisticas_agrupadas($banco);

	  if ($indBusq==2) {
	  	  $estadisticas_agrupadas=$objReportes->estadisticas_agrupadas('');
	  	  $nombreBancos=$objPago->listarBancos(3);
	  	  $banco=null;
	  }


?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
    <SCRIPT>
  function imprimir() {
	day = new Date();
	id = day.getTime();
	eval("page" + id +
	     " = window.open('reportes/pdfCuadroPersonasTipo.php?lote=<? echo $numlotveh; ?>','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
	}

  function enviar(campo){

	window.document.inventario.indBusq.value = campo;
	window.document.inventario.submit();
  }
  </SCRIPT>
  </head>
  <body class="pagina">
   <TABLE class="completo">
    <TR>
     <TD class="banner"></TD>
    </TR>
    <TR>
     <TD >
      <DIV class="menu">
       <?php include("menu.php") ?>
      </DIV>
     </TD>
    </TR>
    <TR>
     <TD class="cuerpo">
      <DIV class="nivel1">
       <DIV class="nivel2">
<!--  Contenido Principal         -->
    <form action="" method="post" name="inventario">
<fieldset class="form">
  <legend>Criterios de B&uacute;squeda </legend>
     <table  align="center" >
	<tr>
	<td  class="categoria">Banco:</td>
           <td class="dato">
			 <SELECT id="banco" name="banco">
				      <option value="<?php if ($banco) echo $banco?>"><?php if ($banco) echo $nombreBancos[2];?></option>
			        <?php for($i=0;$i<count($listarBancos);$i+=2){  ?>
	                   <option value="<?php echo $listarBancos[$i]; ?>"><?php echo $listarBancos[$i+1]?></option>
	                <?php } ?>
			 </SELECT>
		  </td>
    </tr>

		<tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden"  name="indReg" >
		    <INPUT type="hidden" name="idUsu" >
           </td>
          </tr>
  </table>
   </fieldset>
 <fieldset class="form">
  <legend>ESTADISTICAS  <?php if($banco)echo 'DEL '.$nombreBancos[2]; ?></legend>
    <table width="90%" align="center" class="detalles" border=0>
    <tr>

             </tr>
             <tr>
              <td class="cabecera" width="70%">Descripción</td>
                  <td class="cabecera" >Minimo</td>
                  <td class="cabecera" >Promedio</td>
                  <td class="cabecera" >Maximo</td>
             </tr>
<?php
      	for($i=0;$i<count($estadisticas_agrupadas);$i+=5){
      		if($estadisticas_agrupadas){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
              <td><?php echo $estadisticas_agrupadas[$i];?> </td>
              <td align="center"><?php echo $estadisticas_agrupadas[$i+2].' Dias';?> </td>
              <td align="center"><?php echo $estadisticas_agrupadas[$i+3].' Dias';?> </td>
     		  <td align="center"><?php echo $estadisticas_agrupadas[$i+4].' Dias';?> </td>

              <tr>
<?php
      		}
      	}
?>


</table>
</fieldset>
<BR>
<BR>
    <div align="center">
       <?php if($pgActual>1){?>
         <img src="imagenes/atras.png" width="20" height="15" class="vinculo" onclick="regresaPg()">
       <?php }
         for($j=$pgIni;$j<=$pgFin;$j++){
             if($pgActual == $j) $claseVinc = 'vinculoAzul';
             else $claseVinc = 'vinculo';
       ?>
          <a class="<?php echo $claseVinc ?>" onclick="enviaPg(<?php echo $j ?>)"><?php echo $j ?></a>
       <?php
         }
         if($pgActual<$pgFin){
       ?>
         <img src="imagenes/adelante.png" width="20" height="15"  class="vinculo" onclick="avanzaPg()">
       <?php } ?>
       <BR>
       <input type="hidden" name="orden" />
       <input type="hidden" name="codProv" />
       <input type="hidden" name="pagina" value="<?php echo $pgActual ?>"/>

       <br />
     </div>

    </form>
<!--  FIN Contenido Principal         -->
       </DIV>
      </DIV>
     </TD>
    </TR>
    <TR>
     <TD class="piedepagina">
      <?php include("piedepagina.php") ?>
     </TD>
    </TR>
   </TABLE>
  </body>
</html>