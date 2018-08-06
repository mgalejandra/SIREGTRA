<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/envios.php');


 $iniemp=$_POST['iniemp'];
 $numlotveh=$_POST['numlotveh'];
 $numenv=$_POST['numenv'];
 $nomemp=$_POST['nomemp'];
 $numregemp=$_POST['numregemp'];
 $fecfincon=$_POST['fecfincon'];
 $origen=$_POST['origen'];
 $fecdes=$_POST['fecdes'];
 $fechas=$_POST['fechas'];
 $gen=$_POST['gen'];
 $tipo=$_POST['tipo'];
 $filtro=$_POST['filtro'];

$objenvios = new envios();

$listarenvios=$objenvios->listarVehTxt();
?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
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
    <form action="" method="post" name="beneficiario">
 <fieldset class="form">
  <legend>Criterios de Busqueda
  </legend>
     <table  align="center" >
          <tr>

           <td  class="categoria">Serial:</td>
           <td>
             <input name="sercarveh" type="text" id="sercarveh" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="18" />
          </td>
          <td  class="categoria">Cod. Ben:</td>
            <td>
             <input name="codpro" type="text" id="codpro" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="10" />
          </td>
          </tr>
          <tr>
           <td  class="categoria">Beneficiario:</td>
           <td>
             <input name="nomcomp" type="text" id="nomcomp" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="20" />
          </td>
           <td  class="categoria">Factura:</td>
           <td>
             <input name="numfac1veh" type="text" id="numfac1veh" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="15" />
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
  <legend>Listado de Vehiculos para el Envio N
  </legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">N° </td>
              <td class="cabecera">Vehiculo</td>
              <td class="cabecera">cod. Beneficiario</td>
              <td class="cabecera">Beneficiario</td>
              <td class="cabecera">N° de Factura</td>
              <td class="cabecera">Fecha de Factura</td>
              <td class="cabecera">Fecha Registro</td>
              <td class="cabecera">Seguro</td>
              <td class="cabecera">Reserva de Dominio </td>
             </tr>
<?php
       $j=1; for($i=0;$i<count($listarenvios);$i+=18){
          if($listarenvios[$i]){
             if(!$indC){
                 $color ='datosimpar';
                 $indC = true;
             }
             else{
                 $color ='datospar';
                 $indC = false;
             }
?>

              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $j;?></td>
               <td><?php echo $listarenvios[$i+2];?> </td>
               <td><?php echo $listarenvios[$i+3];?></td>
               <td><?php echo $listarenvios[$i+4];?></td>
               <td><?php echo $listarenvios[$i+6];?> </td>
               <td><?php echo $listarenvios[$i+7];?> </td>
               <td><?php echo $listarenvios[$i+14];?></td>
               <td><?php echo $listarenvios[$i+8]?></td>
               <td><?php echo $listarenvios[$i+11]?></td>
              </tr>
<?php     }
         $j++; }
?>
    </table>
 </fieldset>

<BR>
     <div align="center">
       <?php if($pgActual>1){?>
         <img src="botones/atras.png" width="20" height="15" class="vinculo" onclick="regresaPg()">
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
         <img src="botones/adelante.png" width="20" height="15"  class="vinculo" onclick="avanzaPg()">
       <?php } ?>
       <BR>
       <input type="hidden" name="articulo" />
       <input type="hidden" name="pagina" value="<?php echo $pgActual ?>"/>
       <br />
     </div>
     <div align="center" >
        <input type="button" onclick="window.close()" value="Cerrar Ventana"/>
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
