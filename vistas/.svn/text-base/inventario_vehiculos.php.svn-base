<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/vehiculos.php');

function format_monto ($monto,$dec=2) {
	return ($monto==0)?'':formatomonto($monto,$dec);
}
  $objVehiculo = new vehiculos();

$nroFilas = 15;
$nroCampos = 9;
for($j=2;$j<7;$j++) $_SESSION['total'.$j]=0;

$tablaInv=$objVehiculo->listarVehiculosInv('I');

?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script>

function abrir(campo)
{
pagina=campo;
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=500,resizable=yes,left=50,top=50");
}

</script>
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
<form action="" method="post" name="registro">

 <fieldset class="form">
  <legend>Inventario de Vehiculos

  <!--  <input  type="button" id="impVeh" onClick="abrir('reportes/pdfInventario_Vehiculos.php');" value="PDF" />-->
    <table width="90%" align="center" class="detalles">
        <tr><td colspan="9" align="right"><a class="vinculo" target="_blank" onClick="abrir('reportes/pdfInventario_Vehiculos.php');" />
  <IMG title="PDF" src="botones/pdf.png" height="15" ></a>
 </td></tr>
             <tr>
              <td colspan="2" class="cabecera">Veh&iacute;culo</td>
              <td rowspan="2" width="8%" class="cabecera">Unidades adquiridas</td>
              <td rowspan="2" width="8%" class="cabecera">Unidades entregadas</td>
              <td rowspan="2" width="8%" class="cabecera">Unidades en almac&eacute;n</td>
              <td rowspan="2" width="8%" class="cabecera">Unidades vendidas sin entregar</td>
              <td rowspan="2" width="8%" class="cabecera">En espera de pago (*)</td>
              <td rowspan="2" width="10%"class="cabecera">Costo unitario promedio</td>
              <td rowspan="2" width="10%"class="cabecera">Precio m&aacute;x. venta</td>
             </tr>
             <tr>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
             </tr>
		<?for($i=0;$i<count($tablaInv);$i+=$nroCampos){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
 			?>
              <tr class="<?=$color?>">
               <td align="center"><?=$tablaInv[$i]?></td>
               <td align="center"><?=$tablaInv[$i+1]?></td>

  			<?for($k=2;$k<7;$k++){
  				$_SESSION['total'.$k] = $_SESSION['total'.$k] + $tablaInv[$i+$k];?>
               <td align="center"><?=format_monto($tablaInv[$i+$k],0)?></td>
  			<?}?>
               <td align="center"><?=format_monto($tablaInv[$i+7])?></td>
               <td align="center"><?=format_monto($tablaInv[$i+8])?></td>
               </tr>
		<?}?>
			<tr>
			<td align="center" colspan="2" class="categoria">Total:</td>
  			<p>
  			<?for($k=2;$k<7;$k++){?>
               <td align="center"><b><?=format_monto($_SESSION['total'.$k],0)?></b></td>
  			<?}?>
  			</p>
  			</tr>
    <td colspan="9"><p><font size="2">
	(*) Estas cifras no son definitivas porque aún no se ha actualizado
	 la data por consignación de cheques, por aprobación ó por liquidación del crédito por parte del banco.
	</font></p></td>
    </table>
 </fieldset>
  </legend>
<br>
     <div align="center" >
        <input type="button" onclick="window.close()" value="Cerrar Ventana"/>
     </div>
    </form>
<!--  FIN Contenido Principal         -->
       </DIV>
      </DIV>
     </TD>
    </TR>
    <TR><TD class="piedepagina"><?include("piedepagina.php")?></TD></TR>
   </TABLE>
  </body>
</html>