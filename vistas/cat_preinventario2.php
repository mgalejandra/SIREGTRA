<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/inventario.php');

  $codmar=$_POST['codmar'];
  $modveh=$_POST['codmodveh'];
  $serveh=$_POST['codserveh'];
  $numlotveh=$_POST['numlotveh'];

$objInv = new inventario();

$nroFilas = 15;
if (($serveh) and !($lote))
	$nroCampos = 9;
elseif (($serveh) and ($lote))
	$nroCampos = 10;
else
	$nroCampos = 8;

$contArt = $objInv->contarPreInventario('',$codmar,$modveh,$serveh,$numlotveh);

$cantPaginas = ceil($contArt/($nroFilas));
if(!$pgActual){
	$pgActual = 1;
}
elseif($pgActual > $cantPaginas){
     $pgActual = $cantPaginas;
}

if($cantPaginas <= 10){
	$pgIni = 1;
	$pgFin = $cantPaginas;
}
elseif($cantPaginas > 10 AND $pgActual< 5 ){
	$pgIni = 1;
	$pgFin = 10;
}
elseif($cantPaginas > ($pgActual+5) AND $pgActual >= 5 ){
	$pgIni = $pgActual - 4;
	$pgFin = $pgActual + 5;
}
else{
	$pgIni = $pgActual - 4;
	$pgFin = $cantPaginas;
}

$offset =  ($pgActual-1) * $nroFilas;

$listPreInv=$objInv->listarPreInventario('',$codmar,$modveh,$serveh,$offset,$numlotveh);
?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
     <script language="javascript">

		   function parametro(cod,des)
		   {
		   	  opener.document.getElementById('idInv').value = cod;
		   	  opener.document.getElementById('preinv').value = des;
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
              <td  class="categoria">N° Lote:</td>
          <td align="left">
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="abrir('cat_lot.php');" value="..." />
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
  <legend>Listado de Vehiculos - PreInventario</legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">Lote</td>
              <td class="cabecera">N° Inventario</td>
              <td class="cabecera">Fecha</td>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
              <? if ($serveh){ ?>
              <td class="cabecera">Serie</td>
              <? } ?>
              <td class="cabecera">Existencia/Cantidad</td>
              <td class="cabecera">Precio (min-max)</td>
             </tr>
<?php
        for($i=0;$i<count($listPreInv);$i+=$nroCampos){
          if($listPreInv[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;

	        if (($serveh) and !($lote))
				 $numlot= $listPreInv[$i+8];
			elseif (($serveh) and ($lote))
				 $numlot= $listPreInv[$i+8];
			else
				 $numlot= $listPreInv[$i+7];


        	 $listExist=$objInv->buscarExistencia($listPreInv[$i]);
?>

              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $numlot;  ?></td>
               <td align="center">
               <? //if ($listExist[0]>=1) {?><a href="javascript: parametro('<?=$listPreInv[$i]?>','<?=$listPreInv[$i+1]." ".$listPreInv[$i+2]?>')"><?php echo str_pad($listPreInv[$i],3,'0',STR_PAD_LEFT)  ?></a>
               <? /*}
               	  else echo $listPreInv[$i]; */?>
               </td>
               <td align="center"><?php echo $listPreInv[$i+3]  ?></td>
               <td align="center"><?php echo $listPreInv[$i+1];?> </td>
               <td align="center"><?php echo $listPreInv[$i+2]?></td>
               <? if ($serveh){ ?>
               <td align="center"><?php  echo $listPreInv[$i+7]?> </td>
               <? }
               ?>
               <td align="center"><?php echo $listExist[0]."/".$listPreInv[$i+4]; //?></td>
               <td align="center" ><?php echo $listPreInv[$i+5]." - ".$listPreInv[$i+6]; ?></td>
              </tr>
<?php     }
        }
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
  </body>
</html>