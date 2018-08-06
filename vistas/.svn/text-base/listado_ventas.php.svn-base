<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/venta.php');
require('../modelos/marca.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,11,22);
	validaAcceso($permitidos,$dir);

$objMarca = new marca();

  $sercarveh= $_POST['sercarveh'];
  $compra	= $_POST['compra'];
  $estatus	= $_POST['estatus'];

  $status_credito = $_POST['statusCred'];
  $beneficiario = $_POST['beneficiario'];
  $numlotveh	= $_POST['numlotveh'];
  $codmarveh	= $_POST['codmar'];
  $desmarveh	= $_POST['desmar'];
  $codmodveh	= $_POST['codmodveh'];
  $desmodveh	= $_POST['desmodveh'];
  $codserveh	= $_POST['codserveh'];
  $desserveh	= $_POST['desserveh'];

$pgActual = $_POST['pagina'];

$objVenta = new venta();

$nroFilas = 15;
$nroCampos = 8;

$_SESSION['compras_']  = $compra;
$_SESSION['estatus_']  = $estatus;
$_SESSION['statCred_'] = $status_credito;

$_SESSION['sercarveh_']	= $sercarveh;
$_SESSION['numlotveh_']	= $numlotveh;
$_SESSION['codmarveh_']	= $codmarveh;
$_SESSION['desmarveh_']	= $desmarveh;
$_SESSION['codmodveh_']	= $codmodveh;
$_SESSION['desmodveh_']	= $desmodveh;
$_SESSION['codserveh_']	= $codserveh;
$_SESSION['desserveh_']	= $desserveh;
$_SESSION['beneficia_']	= $beneficiario;

$contArt = $objVenta->contarVentas($id_numfac,$sercarveh,$beneficiario,$compra,$estatus,$status_credito,$numlotveh,$codmarveh,$codmodveh,$codserveh);

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

$listVenta = $objVenta->listarVenta2($id_numfac,$sercarveh,$beneficiario,$compra,$estatus,$status_credito,$numlotveh,$codmarveh,$codmodveh,$codserveh,$offset);

?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
    <script>

function enviar(dato){
if(dato==1){
	document.registro.pagina.value = 0;
}
if(dato==2){
		document.registro.sercarveh.value = null;
		document.registro.numlotveh.value = null;
  		document.registro.codmar.value = null;
  		document.registro.desmar.value = null;
  		document.registro.serveh.value = null;
	  	document.registro.codmodveh.value = null;
	  	document.registro.modveh.value = null;
	  	document.registro.compra.value = null;
 	 	document.registro.codserveh.value = null;
	  	document.registro.statusCred.value = null;
	  	document.registro.beneficiario.value = null;
}
}

function avanzaPg(){
	pg = parseInt(document.registro.pagina.value);
	document.registro.pagina.value = pg+1;
	document.registro.submit();
}

function enviaPg(pag){
	document.registro.pagina.value = pag;
	document.registro.submit();
}

function regresaPg(){
	pg = parseInt(document.registro.pagina.value);
	document.registro.pagina.value = pg-1;
	document.registro.submit();
}

function imprimir() {
  day = new Date();
  id = day.getTime();
  eval("page" + id +
  	   " = window.open('reportes/pdfReportesVentas.php','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
  }

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
     <TD>
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
  <legend>Criterios de Busqueda
  </legend>
     <table  align="center">
        <tr>
          <td class="categoria">N° Lote:</td>
          <td align="left">
             <input name="numlotveh" type="text" id="numlotveh" value="<?=$numlotveh?>" size="3" maxlength="3" readonly=""/>
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
          </td>

          <td  class="categoria">Serial&nbsp;carrocería:</td>
          <td align="left">
			<input name="sercarveh" type="text" id="sercarveh" value="<?=$sercarveh?>" onblur="javascript:this.value=this.value.toUpperCase()"/>
		  </td>

          <td  class="categoria">&nbsp;&nbsp;Beneficiario:</td>
          <td align="left">
			<input name="beneficiario" type="text" id="beneficiario" value="<?=$beneficiario?>" onblur="javascript:this.value=this.value.toUpperCase()"/>
		  </td>
		</tr>

		<tr>
           <td  class="categoria">&nbsp;&nbsp;Modo&nbsp;de&nbsp;compra:</td>
           <td align="left">
              <select name="compra" size="1" id="compra">
               <option value=""  <?if($_SESSION['compras_']=="")  echo 'selected="true"'?>></option>
               <option value="C" <?if($_SESSION['compras_']=="C") echo 'selected="true"'?>>Contado Total</option>
               <option value="CP"<?if($_SESSION['compras_']=="RL")echo 'selected="true"'?>>Contado Parcial</option>
               <option value="R" <?if($_SESSION['compras_']=="R") echo 'selected="true"'?>>Crédito Parcial</option>
               <option value="RL"<?if($_SESSION['compras_']=="RL")echo 'selected="true"'?>>Crédito Total</option>
              </select>
          </td>

       <td class="categoria">&nbsp;&nbsp;Estado del crédito:</td>
			 <td align="left">
			 <SELECT name="statusCred" id="statusCred">
			    <OPTION value=""    <?if($_SESSION['statCred_']=="") echo 'selected="true"'?>></OPTION>
			    <OPTION value="ANA" <?if($_SESSION['statCred_']=="ANA") echo 'selected="true"'?>>ANÁLISIS</OPTION>
			    <OPTION value="DOC" <?if($_SESSION['statCred_']=="DOC") echo 'selected="true"'?>>DOCUMENTACIÓN</OPTION>
			    <OPTION value="AUT" <?if($_SESSION['statCred_']=="AUT") echo 'selected="true"'?>>AUTENTICACIÓN</OPTION>
			    <OPTION value="APR" <?if($_SESSION['statCred_']=="APR") echo 'selected="true"'?>>APROBADO</OPTION>
			    <OPTION value="LIQ" <?if($_SESSION['statCred_']=="LIQ") echo 'selected="true"'?>>LIQUIDADO</OPTION>
			    <OPTION value="RCH" <?if($_SESSION['statCred_']=="RCH") echo 'selected="true"'?>>RECHAZADO</OPTION>
			    <OPTION value="PEN" <?if($_SESSION['statCred_']=="PEN") echo 'selected="true"'?>>PENDIENTE</OPTION>
			 </SELECT>
		     </td>

           <td  class="categoria">Marca:</td>
           <td colspan="3">
			<input name="codmar" type="hidden" id="codmar" value="<?=$codmarveh?>" />
	        <input name="desmar" type="text"   id="desmar" value="<?=$desmarveh?>" readonly=""/>
	        <input name="marca"  type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
		  </td>
		   </tr>
		   <tr>
           <td  class="categoria">Modelo:</td>
           <td colspan="3" align="left">
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?=$codmodveh?>"/>
             <input name="desmodveh" type="text"   id="modveh"    value="<?=$desmodveh?>" size="20" maxlength="15" readonly=""/>
             <input name="modelo"    type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." />
          </td>
           <td  class="categoria">Serie:</td>
           <td colspan="3">
             <input name="codserveh" type="hidden" id="codserveh" value="<?=$codserveh?>"/>
             <input name="desserveh" type="text" id="serveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?=$_SESSION['desserveh_']?>" readonly=""/>
             <input name="serie" type="button" id="serie" onclick="catalogo('cat_serie.php');" value="..." />
           </td>
         </tr>

          <tr>
            <td align="center" colspan="7">
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" value="Limpiar" onclick="enviar(2)"/>
            <input type="submit" value="Imprimir" onclick="imprimir()"/>
            </td>
         </tr>
  </table>
   </fieldset>

 <fieldset class="form">
  <legend>Lista de vehículos vendidos
  </legend>

       <DIV class="nivel2">
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera"rowspan="3">ID</td>
              <td class="cabecera"rowspan="3">Lote</td>
              <td class="cabecera"rowspan="3">Serial de Carroceria</td>
              <td class="cabecera"rowspan="3">Beneficiario</td>
              <td class="cabecera"rowspan="1" colspan="4">Modalidad de venta</td>
              <td class="cabecera"rowspan="3" width="10%">Estado de la Venta</td>
              <td class="cabecera"rowspan="3"width="8%" title="Fecha de última actualización">Fecha modif.</td>
              <td class="cabecera"rowspan="3"></td>
             </tr>
             <tr>
              <td class="cabecera" colspan="2">Contado</td>
              <td class="cabecera" colspan="2">Crédito</td>

 			 </tr>
 			 <tr>
              <td class="cabecera">Parcial</td>
              <td class="cabecera">Total</td>
              <td class="cabecera">Parcial</td>
              <td class="cabecera">Total</td>
 			 </tr>
		<? for($i=0;$i<count($listVenta);$i+=$nroCampos){
             $color = (!$indC)?"datosimpar":"datospar";
             $indC = !$indC; ?>
             <tr class="<?= $color ?>">
               <td align="center"><?= $listVenta[$i]?></td>
               <td align="center"><?= str_pad($listVenta[$i+7],3,"0",STR_PAD_LEFT)?></td>
               <td align="center"><?= $listVenta[$i+1]?></td>
               <td >&nbsp;<?= $listVenta[$i+2]?></td>
               <td align="center"><? if($listVenta[$i+3]=="CP")echo'<a><img src="botones/correcto.png" width="20" height="20"></a>'?></td>
               <td align="center"><? if($listVenta[$i+3]=="C") echo'<a><img src="botones/correcto.png" width="20" height="20"></a>'?></td>
               <td align="center"><? if($listVenta[$i+3]=="R") echo'<a><img src="botones/correcto.png" width="20" height="20"></a>'?></td>
               <td align="center"><? if($listVenta[$i+3]=="RL")echo'<a><img src="botones/correcto.png" width="20" height="20"></a>'?></td>
               <td align="center"><?= $listVenta[$i+4]?></td>
               <td align="center"><?= $listVenta[$i+6]?></td>
               <td><div align="center">
            	<?if($listVenta[$i+4]!="LIQUIDADO"){?>
               <a class="vinculo" href="reg_venta.php?id_venta=<?= $listVenta[$i]?>">
	              <img src="botones/buscar.png" width="20" height="20"></a>
	          <?}?>
	          </div></td>
             </tr>
<?}?>
  <tr><td colspan="2" class="categoria"> <?= 'Total registros: '.$contArt?></td></tr>
    </table>
 </fieldset>
<BR>
 <div align="center">
       <? if($pgActual>1){?>
         <img src="imagenes/atras.png" width="20" height="15" class="vinculo" onclick="regresaPg()">
       <? }
         for($j=$pgIni;$j<=$pgFin;$j++){
             $claseVinc = ($pgActual==$j)?"vinculoAzul":"vinculo";
       ?>
          <a class="<?= $claseVinc ?>" onclick="enviaPg(<?= $j ?>)"><?= $j ?></a>
       <?
         }
         if($pgActual<$pgFin){
       ?>
         <img src="imagenes/adelante.png" width="20" height="15"  class="vinculo" onclick="avanzaPg()">
       <? } ?>
       <BR>
       <input type="hidden" name="pagina" value="<?= $pgActual ?>"/>

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
      <? include("piedepagina.php") ?>
     </TD>
    </TR>
   </TABLE>
  </body>
</html>
