<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/inventario.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,6,7,11,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23);
	validaAcceso($permitidos,$dir);
	//require ('../modelos/usuarios.php');

  $codmar=$_POST['codmar'];
  $modveh=$_POST['codmodveh'];
  $serveh=$_POST['codserveh'];
  $pgActual = $_POST['pagina'];

$objInv = new inventario();

$nroFilas = 15;
if ($serveh)
	$nroCampos = 9;
else
	$nroCampos = 8;

$contArt = $objInv->contarPreInventario('',$codmar,$modveh,$serveh);

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

$listPreInv=$objInv->listarPreInventario('',$codmar,$modveh,$serveh,$offset);
?>
<!DOCTYPE HTML PUBLIC >
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
    <form action="" method="post" name="inventario">
 <fieldset class="form">
  <legend>Criterios de B&uacute;squeda
  </legend>
     <table  align="center" >
          <tr>
           <td  class="categoria">Marca:</td>
           <td>
			<input name="codmar" type="hidden" id="codmar"  value="<?php if($ban==1)  echo $registro['codmarveh'];?>" />
	        <input name="desmar" type="text" id="desmar"  value="<?php if($ban==1)  echo $objMarca->buscarMarca($registro['codmarveh']);?>"  readonly=""/>
	        <input name="marca" type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
		  </td>
           <td  class="categoria">Modelo :</td>
           <td>
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?php if($ban==1)  echo $registro['codmodveh'];?>" />
             <input name="modveh" type="text" id="modveh" value="<?php if($ban==1)  echo $registro['modveh'];?>" size="20" maxlength="15" readonly=""/>
             <input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." />
          </td>
           <td  class="categoria">Serie:</td>
           <td>
             <input name="codserveh" type="hidden" id="codserveh" value="<?php if($ban==1)  echo $registro['codserveh'];?>" />
             <input name="serveh" type="text" id="serveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $registro['serveh'];?>" readonly=""/>
             <input name="serie" type="button" id="serie" onclick="catalogo('cat_serie.php');" value="..." />
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
  <legend>Listado de Veh&iacute;culos - Preinventario  <?php echo $contArt; ?>
  </legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">N° Inventario - Fecha  - Lote</td>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
              <? if ($serveh){ ?>
              <td class="cabecera">Serie</td>
              <? } ?>
              <td class="cabecera">Cantidad</td>
              <td class="cabecera">Precio (min-max)</td>
             </tr>
<?php
        for($i=0;$i<count($listPreInv);$i+=$nroCampos){
           if($listPreInv[$i]){
              $color = (!$indC)?'datosimpar':'datospar';
              $indC = !$indC;

 	            if ($serveh)
					$lote = $listPreInv[$i+9];
				else
					$lote = $listPreInv[$i+7];
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $listPreInv[$i]." - ".$listPreInv[$i+3]." - ".$lote;  ?></td>
               <td align="center"><?php echo $listPreInv[$i+1];?> </td>
               <td align="center"><?php echo $listPreInv[$i+2]?></td>
               <? if ($serveh){ ?>
               <td align="center"><?php  echo $listPreInv[$i+7]?> </td>
               <? } ?>
               <td align="center"><?php echo $listPreInv[$i+4]?></td>
               <td align="center" ><?php echo $listPreInv[$i+5]." - ".$listPreInv[$i+6]; ?></td>
              </tr>
<?php     }
        }
?>
<tr><td colspan=9> <?php echo 'Total: '.$contArt?></td></tr>
    </table>
 </fieldset>



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