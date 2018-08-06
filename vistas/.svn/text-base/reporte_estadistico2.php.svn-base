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
	$permitidos = array(1,2,3,4,5,11,15,18);
	validaAcceso($permitidos,$dir);

	$banco= $_POST['banco'];
	$indBusq= $_POST['indBusq'];


    $objReportes=new reportes();
    $objPago = new pago();
    $objBanco = new banco();



    $listarBancos=$objPago->listarBancos(3);

    $nombreBancos=$objBanco->listarBancos($banco);

	$estadisticas_agrupadas=$objReportes->estadisticas_prom_1();
	$estadisticas_agrupadas2=$objReportes->estadisticas_prom_2();
	$estadisticas_agrupadas3=$objReportes->estadisticas_prom_3();
	$estadisticas_agrupadas4=$objReportes->estadisticas_prom_4();
	$estadisticas_agrupadas5=$objReportes->estadisticas_prom_5();

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
    <BR>
<BR>
 <fieldset class="form">
  <legend align="left">DESDE QUE EL PROMEDIO DE TIEMPO DESDE QUE SE ENVÍA EL EXPEDIENTE AL BANCO HASTA QUE SE ENTREGA EL VEHÍCULO  </legend>
    <table width="90%" align="center" class="detalles" border='0'>
              <td class="cabecera" >Banco</td>
                 <td class="cabecera">Minimo</td>
                <td class="cabecera">Promedio</td>
                <td class="cabecera" >Maximo</td>
             </tr>

<?php
      	for($i=0;$i<count($estadisticas_agrupadas);$i+=4){
      		if($estadisticas_agrupadas){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
			<td><?php echo $estadisticas_agrupadas[$i];?> </td>

              <td align="center"><?php echo $estadisticas_agrupadas[$i+1].' Días';?> </td>
              <td align="center"><?php echo $estadisticas_agrupadas[$i+2].' Dias';?> </td>
     		  <td align="center"><?php echo $estadisticas_agrupadas[$i+3].' Dias';?> </td>
              </tr>

<?php
      		}
      	}
?>
</table>
</fieldset>
<fieldset class="form">
 <legend align="left"> DESDE QUE SE ENVÍA EL EXPEDIENTE AL BANCO HASTA QUE SE ACTUALIZA EL CRÉDITO (APRUEBA, NEGADO) </legend>
  <table width="90%" align="center" class="detalles" border='0'>

<tr>
              <td class="cabecera" >Banco</td>
                 <td class="cabecera">Minimo</td>
                <td class="cabecera">Promedio</td>
                <td class="cabecera" >Maximo</td>
             </tr>

          <?php
      	for($i=0;$i<count($estadisticas_agrupadas2);$i+=4){
      		if($estadisticas_agrupadas2){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
			<td><?php echo $estadisticas_agrupadas2[$i];?> </td>

              <td align="center"><?php echo $estadisticas_agrupadas2[$i+1].' Dias';?> </td>
              <td align="center"><?php echo $estadisticas_agrupadas2[$i+2].' Dias';?> </td>
     		  <td align="center"><?php echo $estadisticas_agrupadas2[$i+3].' Dias';?> </td>
              </tr>

<?php
      		}
      	}
?>


</table>
</fieldset>

<fieldset class="form">
 <legend align="left"> DESDE QUE SE APRUEBA EL CRÉDITO HASTA QUE SE EMITE EL CERTIFICADO </legend>
  <table width="90%" align="center" class="detalles" border='0'>
<tr>
              <td class="cabecera" >Banco</td>
                 <td class="cabecera">Minimo</td>
                <td class="cabecera">Promedio</td>
                <td class="cabecera" >Maximo</td>
             </tr>

          <?php
      	for($i=0;$i<count($estadisticas_agrupadas3);$i+=4){
      		if($estadisticas_agrupadas3){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
			<td><?php echo $estadisticas_agrupadas3[$i];?> </td>

              <td align="center"><?php echo $estadisticas_agrupadas3[$i+1].' Dias';?> </td>
              <td align="center"><?php echo $estadisticas_agrupadas3[$i+2].' Dias';?> </td>
     		  <td align="center"><?php echo $estadisticas_agrupadas3[$i+3].' Dias';?> </td>
              </tr>

<?php
      		}
      	}
?>
</table>
</fieldset>
<fieldset class="form">
<legend align="left"> DESDE QUE SE ENVÍA EL CERTIFICADO AL BANCO HASTA QUE SE LIQUIDA EL CRÉDITO </legend>
 <table width="90%" align="center" class="detalles" border='0'>
<tr>
<tr>
              <td class="cabecera" >Banco</td>
                 <td class="cabecera">Minimo</td>
                <td class="cabecera">Promedio</td>
                <td class="cabecera" >Maximo</td>
             </tr>

          <?php
      	for($i=0;$i<count($estadisticas_agrupadas4);$i+=4){
      		if($estadisticas_agrupadas4){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
			<td><?php echo $estadisticas_agrupadas4[$i];?> </td>

              <td align="center"><?php echo $estadisticas_agrupadas4[$i+1].' Dias';?> </td>
              <td align="center"><?php echo $estadisticas_agrupadas4[$i+2].' Dias';?> </td>
     		  <td align="center"><?php echo $estadisticas_agrupadas4[$i+3].' Dias';?> </td>
              </tr>

<?php
      		}
      	}
?>
</table>
</fieldset>
<fieldset class="form">
<legend align="left"> DESDE QUE SE ENVÍA EL CERTIFICADO AL BANCO HASTA QUE SE LIQUIDA EL CRÉDITO </legend>
 <table width="90%" align="center" class="detalles" border='0'>
<tr>

              <td class="cabecera" >Banco</td>
                 <td class="cabecera">Minimo</td>
                <td class="cabecera">Promedio</td>
                <td class="cabecera" >Maximo</td>
             </tr>

          <?php
      	for($i=0;$i<count($estadisticas_agrupadas5);$i+=4){
      		if($estadisticas_agrupadas5){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
			<td><?php echo $estadisticas_agrupadas5[$i];?> </td>

              <td align="center"><?php echo $estadisticas_agrupadas5[$i+1].' Dias';?> </td>
              <td align="center"><?php echo $estadisticas_agrupadas5[$i+2].' Dias';?> </td>
     		  <td align="center"><?php echo $estadisticas_agrupadas5[$i+3].' Dias';?> </td>
              </tr>

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