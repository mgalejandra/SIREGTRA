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
	$permitidos = array(1,2,3,4,5,11,13,17,18,23);
	validaAcceso($permitidos,$dir);
	//require ('../modelos/usuarios.php');

  $codmar=$_POST['codmar'];
  $modveh=$_POST['codmodveh'];
  $serveh=$_POST['codserveh'];
  $codpro=$_POST['codpro'];
  $numlotveh=$_POST['numlotveh'];
  $pgActual = $_POST['pagina'];
  $indBusq=$_POST['indBusq'];


$objAsignacion = new asignacion();

$nroFilas = 15;

/*if ($serveh)
	$nroCampos = 15;
else
	$nroCampos = 14;*/

if ((($serveh) and !($lote)) or (!($serveh) and ($lote)))
	$nroCampos = 15;
elseif (($serveh) and ($lote))
	$nroCampos = 16;
else
	$nroCampos = 14;

if($indBusq == 2){
  $codmar=null;
  $modveh=null;
  $serveh=null;
  $codpro=null;
  $numlotveh=null;
}

$contArt = $objAsignacion->contarVehAsigPreInv($codpro,$codmar,$modveh,$serveh,$numlotveh);

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

$listVehAsigPreInv=$objAsignacion->listarVehAsigPreInv($codpro,$codmar,$modveh,$serveh,$offset,$numlotveh);

  $_SESSION['codmar_']=$codmar;
  $_SESSION['codmodveh_']=$modveh;
  $_SESSION['codserveh_']=$serveh;
  $_SESSION['codpro_']=$codpro;
  $_SESSION['numlotveh_']=$numlotveh;
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
	     " = window.open('reportes/pdflistar_preproforma.php?codmar=<?php echo $codmar?>&modveh=<?php echo $modveh?>&serveh=<?php echo $serveh?>&codpro=<?php echo $codpro?>&listar=<?php echo $listVehAsigPreInv?>','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
	}

	function enviar(dato){
		window.document.inventario.indBusq.value = dato;
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
           <td  class="categoria">N° Lote:</td>
           <td align="left">
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
           </td>
           <td  class="categoria">CI/RIF:</td>
           <td>
             <input name="codpro" type="text" id="codpro" value="<?php if($ban==1)  echo $registro['codpro'];?>" />
           </td>
          </tr>
          <tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <input name="Botn" type="button" onclick="imprimir()" value="Imprimir" class="btn btnprint">
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden"  name="indReg" >
		    <INPUT type="hidden" name="idUsu" >
           </td>
          </tr>
  </table>
   </fieldset>

 <fieldset class="form">
  <legend>Listado de Veh&iacute;culos Asignados - Preinventario  <?php echo $contArt; ?>
  </legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">ID</td>
              <td class="cabecera">CI/RIF</td>
			  <td class="cabecera">Beneficiario</td>
			  <td class="cabecera">Lote</td>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
              <? if ($serveh){ ?>
              <td class="cabecera">Serie</td>
              <? } ?>
              <td class="cabecera">Fecha Asignacion</td>
              <td class="cabecera">Precio (min-max)</td>
              <? if ($_SESSION['tipoUsuario']<>'18'){?>
              <td class="cabecera"> B </td>
              <td class="cabecera"> L </td><? }?>
             </tr>
<?php
        for($i=0;$i<count($listVehAsigPreInv);$i+=$nroCampos){
          if($listVehAsigPreInv[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
                <td align="center"><?php echo $listVehAsigPreInv[$i+10];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv[$i];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv[$i+1]." ".$listVehAsigPreInv[$i+2]." ".$listVehAsigPreInv[$i+3]." ".$listVehAsigPreInv[$i+4]; ?></td>
               <td align="center"><?php

					if ((($serveh) and !($lote)) or (!($serveh) and ($lote)))
						echo $listVehAsigPreInv[$i+14];
					elseif (($serveh) and ($lote))
						echo $listVehAsigPreInv[$i+15];
					else
						echo $listVehAsigPreInv[$i+13];
			   ?> </td>
               <td align="center"><?php echo $listVehAsigPreInv[$i+6];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv[$i+7]?></td>
               <? if ($serveh){ ?>
               	<td align="center"><?php  echo $listVehAsigPreInv[$i+10]?> </td>
               <? } ?>
               <td align="center"><?php echo $listVehAsigPreInv[$i+5]?></td>
               <td align="center" ><?php echo $listVehAsigPreInv[$i+8]." - ".$listVehAsigPreInv[$i+9]; ?></td>
               <? if ($_SESSION['tipoUsuario']<>'18'){?>
               <td><div align="center">
               <a class="vinculo" href="preproforma.php?codpro=<?php echo $listVehAsigPreInv[$i]?>&mod=1&asig=<?php echo $listVehAsigPreInv[$i+10]?>">
	              <img src="botones/buscar.png" width="35" height="35">
	          </a></div></td>
	          <td><div align="center">
               <a class="vinculo" href="preproforma.php?codpro=<?php echo $listVehAsigPreInv[$i]?>&lib=2">
	              <img src="botones/refresh_48.png" width="35" height="35">
	          </a></div></td><? } ?>
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