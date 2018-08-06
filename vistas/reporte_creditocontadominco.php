<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/vehiculos.php');


	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,11,15,18,20,25);
	validaAcceso($permitidos,$dir);
	//require ('../modelos/usuarios.php');

  $nroCampos= 2;

  /*$codmar=$_POST['codmar'];
  $modveh=$_POST['codmodveh'];
  $serveh=$_POST['codserveh'];
  $codpro=$_POST['codpro'];*/
  $pgActual = $_POST['pagina'];
  $indBusq=$_POST['indBusq'];

//echo "indice: ".$indBusq;

  	$numlotveh=$_POST['numlotveh'];

	$objVehiculo = new vehiculos();

	$reporteCreditominco=$objVehiculo->reporteCreditominco($numlotveh);

	$reporteContadoMinco=$objVehiculo->reporteContadoMinco($numlotveh);

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
	     " = window.open('reportes/pdfCuadroCreditovsContado.php?lote=<? echo $numlotveh; ?>','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
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
  <legend>Criterios de B&uacute;squeda</legend>
     <table  align="center" >
 <tr>
          <td  class="categoria">N° Lote:</td>
          <td align="left">
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
         </td></tr>
         <tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden"  name="indBusq">
           </td>
          </tr>
  </table>
   </fieldset>

 <fieldset class="form">
  <legend>Creditos vs Contado <?php if ($numlotveh) echo "Lote: ".$numlotveh?></legend>
<?php for($i=0;$i<count($reporteCreditominco);$i+=$nroCampos){
               $total= $total+$reporteCreditominco[$i+1];
        }?>
    <table width="90%" align="center" class="detalles" border=0>
    <tr>
  				<td colspan="23" align="right">
			  			<a class="vinculo" target="_blank" onClick="imprimir()" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a>
			      </td>
             </tr>
             <tr>
              <td class="cabecera" width="70%">Entidad Financiera</td>
              <td align="center"><font color="red"><?php echo $total;?></font></td>
             </tr>
<?php
      	for($i=0;$i<count($reporteCreditominco);$i+=$nroCampos){
      		if($reporteContadoMinco){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td><?php echo $reporteCreditominco[$i];?> </td>
               <td align="center"><?php echo $reporteCreditominco[$i+1];?> </td>
              <tr>
<?php
      		}
      	}
?>
<?php for($i=0;$i<count($reporteContadoMinco);$i+=$nroCampos){
               $total2= $total2+$reporteContadoMinco[$i+1];
        }?>
             <tr>
              <td class="cabecera">De Contado</td>
              <td align="center"><font color="red"><?php echo $total2;?></font></td>
             </tr>
<?php
      	for($i=0;$i<count($reporteContadoMinco);$i+=$nroCampos){
      		if($reporteContadoMinco[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td ><?php echo $reporteContadoMinco[$i];?> </td>
               <td align="center"><?php echo $reporteContadoMinco[$i+1];?> </td>
              <tr>
<?php
      		}
      		}
      		$totalG=$total+$total2;
?>

             <tr>
              <td class="cabecera">Total Vehículos Entregados</td>
              <td align="center"><font color="red"><?php echo $totalG;?></font></td>
             </tr>

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