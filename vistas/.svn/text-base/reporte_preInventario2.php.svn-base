<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/inventario.php');
require('../modelos/asignacion.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,11);
	validaAcceso($permitidos,$dir);
	//require ('../modelos/usuarios.php');

  $codmar=$_POST['codmar'];
  $modveh=$_POST['codmodveh'];
  $serveh=$_POST['codserveh'];
  $codpro=$_POST['codpro'];
  $pgActual = $_POST['pagina'];

$objInventario = new inventario();


$listVehAsigPreInv=$objInventario->reportePreinventario();

$listVehAsigPreInvInicial=$objInventario->reportePreinventarioInicial($desde,$hasta);

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
	     " = window.open('reportes/pdf_preInventario.php','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
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
  <legend>Listado de Veh&iacute;culos Asignados - Preinventario  <?php echo $contArt; ?>
  </legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">Modelo</td>
			  <td class="cabecera">Cantidad</td>
			  <td class="cabecera">Prepr. Bicent</td>
			  <td class="cabecera">Prepr. Venezu</td>
			  <td class="cabecera">Prepr. Tesoro</td>
			  <td class="cabecera">Prepr. Indust</td>
              <td class="cabecera">Total Asignados</td>
              <td class="cabecera">Existencia</td>
              <td class="cabecera">Precio Min</td>
              <td class="cabecera">Precio Max</td>
             </tr>
<?php
        for($i=0;$i<count($listVehAsigPreInv);$i+=10){
          if($listVehAsigPreInv[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $listVehAsigPreInv[$i+1];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv[$i+2];?></td>
                       <td align="center"><?php echo $listVehAsigPreInv[$i+6];?></td>
                       <td align="center"><?php echo $listVehAsigPreInv[$i+7];?></td>
                       <td align="center"><?php echo $listVehAsigPreInv[$i+8];?></td>
                       <td align="center"><?php echo $listVehAsigPreInv[$i+9];?></td>
               <td align="center"><?php echo $listVehAsigPreInv[$i];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv[$i+3]?></td>
               <td align="center"><?php echo FormatoMonto($listVehAsigPreInv[$i+4])?></td>
               <td align="center" ><?php echo FormatoMonto($listVehAsigPreInv[$i+5]); ?></td>
              </tr>
<?php     }
        }
?>

    </table>
 </fieldset>
   <fieldset class="form">
  <legend>Listado de Veh&iacute;culos Asignados - Preinventario  - Inicial <?php echo $contArt; ?>
  </legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">Cantidad</td>
			  <td class="cabecera">Modelo</td>
			  <td class="cabecera">Total</td>
             </tr>
<?php
$total=0;
$total1=0;
        for($i=0;$i<count($listVehAsigPreInvInicial);$i+=4){
          if($listVehAsigPreInvInicial[$i]){
             $total+=$listVehAsigPreInvInicial[$i+0];
             $total1+=$listVehAsigPreInvInicial[$i+2];
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $listVehAsigPreInvInicial[$i+0];?> </td>
               <td align="center"><?php echo $listVehAsigPreInvInicial[$i+1];?></td>
               <td align="center"><?php echo FormatoMonto($listVehAsigPreInvInicial[$i+2]);?></td>

              </tr>
<?php     }

        }
?>
             <tr >
               <td align="center" class="cabecera"><?php echo $total; ?> </td>
               <td align="center" class="cabecera"><?php echo "TOTAL";?></td>
               <td align="center" class="cabecera"><?php echo FormatoMonto($total1);?></td>
             </tr>

    </table>
 </fieldset>
<BR>
<input name="Botn" type="button" onclick="imprimir()" value="Imprimir" class="btn btnprint">
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