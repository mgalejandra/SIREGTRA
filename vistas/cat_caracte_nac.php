<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/caracteristicas.php');

  $codmar=$_POST['codmar'];
  $modveh=$_POST['codmodveh'];
  $serveh=$_POST['codserveh'];

$objCaract = new caracteristicas();

$listCarac=$objCaract->listarCaracteristicasNac('',$codmar,$modveh,$serveh);
?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
     <script language="javascript">

		   function parametro(cod,des)
		   {
		   	  opener.document.getElementById('idCaract').value = cod;
		   	  opener.document.getElementById('desidCaract').value = des;
		      self.close();

		   }

		   		   function abrir(campo)
			{
			pagina=campo;
			window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=400,heigth=300,resizable=yes,left=50,top=50");
			}

   </script>
  </head>
  <body class="pagina">

<!--  Contenido Principal         -->
    <form action="" method="post" name="caracteristicas">
 <fieldset class="form">
  <legend>Criterios de B&uacute;squeda</legend>
     <table  align="center" >
          <tr>
           <td  class="categoria">Marca:</td>
           <td>
			<input name="codmar" type="hidden" id="codmar"  value="<?php if($ban==1)  echo $registro['codmarveh'];?>" />
	        <input name="desmar" type="text" id="desmar"  value="<?php if($ban==1)  echo $objMarca->buscarMarca($registro['codmarveh']);?>"  readonly=""/>
	        <input name="marca" type="button" id="marca" onclick="abrir('marca2.php');" value="..." />
		  </td>
           <td  class="categoria">Modelo:</td>
           <td>
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?php if($ban==1)  echo $registro['codmodveh'];?>" />
             <input name="modveh" type="text" id="modveh" value="<?php if($ban==1)  echo $registro['modveh'];?>" size="20" maxlength="15" readonly=""/>
             <input name="modelo" type="button" id="modelo" onclick="abrir('cat_modelo.php');" value="..." />
          </td>
           <td  class="categoria">Serie:</td>
           <td>
             <input name="codserveh" type="hidden" id="codserveh" value="<?php if($ban==1)  echo $registro['codserveh'];?>" />
             <input name="serveh" type="text" id="serveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $registro['serveh'];?>" readonly=""/>
             <input name="serie" type="button" id="serie" onclick="abrir('cat_serie.php');" value="..." />
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
  <legend>Listado de Caracter&iacute;sticas de Veh&iacute;culos Nacionales / Exportados y Programa Venezuela M&oacute;vil</legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">N&deg; de Caracter&iacute;stica</td>
              <td class="cabecera">Lote</td>
               <td class="cabecera">Factura</td>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
              <td class="cabecera">Serie</td>
              <td class="cabecera">A&ntilde;o Modelo</td>
              <td class="cabecera">Origen</td>
             </tr>
<?php
        for($i=0;$i<count($listCarac);$i+=31){
          if($listCarac[$i]){
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
               <td align="center">
               <a href="javascript: parametro('<?=$listCarac[$i]?>','<? echo $listCarac[$i+2].' / '.$listCarac[$i+3].' / '.$listCarac[$i+4].' / '.$listCarac[$i+5].' / '.$listCarac[$i+28].' / '.FormatoMonto($listCarac[$i+15]).' / FACT '.$listCarac[$i+34];?>')"><?php echo str_pad($listCarac[$i],3,'0',STR_PAD_LEFT)  ?></a>
               </td>
               <td><?php  echo $listCarac[$i+1];?> </td>
                  <td><?php echo $listCarac[$i+34]?></td>
               <td><?php echo $listCarac[$i+2]?></td>
               <td><?php echo $listCarac[$i+3]?> </td>
               <td><?php echo $listCarac[$i+4]?></td>
               <td align="center" ><?php echo $listCarac[$i+5]?></td>
               <td align="center" ><?php echo $listCarac[$i+6]?></td>
              </tr>
<?php     }
        }
?>
    </table>
 </fieldset>
  </legend>

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
  </body>
</html>