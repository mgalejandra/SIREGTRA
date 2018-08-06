<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/reportes.php');
require('../modelos/lotes.php');
require('../modelos/zona.php');


$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,4,10,15,18,23,25);
validaAcceso($permitidos,$dir);


$indBusq = $_POST['indBusq'];

$objReporte = new reportes();
$objLotes 	= new lotes();
$objZona 	= new zona();


$nroCampos = 3;

  $indBusq 	= $_POST['indBusq'];
  $pgActual = $_POST['pagina'];

  if ($_POST['numlotveh'])
  	$numlotveh = $_POST['numlotveh'];
  else
  	$numlotveh = '14';


if($indBusq==2){
  	$numlotveh = null;
}

$listEstados = $objZona->listarEstados();
$nroEdo = count($listEstados)/2;


//$listarVehsinEstado = $objReporte->matrizVehsinEstado(14);
$listarVehsinEstado = $objReporte->matrizVehsinEstado($numlotveh);
$_SESSION['listarVehxEstado']=$listEstados;

$_SESSION['listarVehsinEstado']=$listarVehsinEstado;

?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>

function enviar(dato){
 document.registro.pagina.value = 0;
 document.registro.indBusq.value = dato;
}

function avanzaPg(){
	pg = parseInt(window.document.registro.pagina.value);
	window.document.registro.pagina.value = pg+1;
	window.document.registro.submit();
}

function enviaPg(pag){
	window.document.registro.pagina.value = pag;
	window.document.registro.submit();
}


function regresaPg(){
	pg = parseInt(window.document.registro.pagina.value);
	window.document.registro.pagina.value = pg-1;
	window.document.registro.submit();
}

function abrir(campo)
{
pagina=campo;
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=500,resizable=yes,left=50,top=50");
}

function popupPDF(URL) {
 day = new Date();
 id = day.getTime();
 eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=450,height=600');");
}


function exel(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id +
	  	   " = window.open('reportes/xlsListarVehxEdo.php?numlotveh=<?php echo$numlotveh;?>&numfacori=<?php echo$numfacori;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

}
</script>
  </head>
  <body class="pagina">
   <TABLE class="completo">
    <TR>
     <TD class="banner2"></TD>
    </TR>
    <TR>
     <TD >
      <DIV class="menu2">
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
  <legend>Criterios de B&uacute;squeda</legend>
<table align="center">
<tbody>
<tr>	  <td  class="categoria">N° Lote:</td>
          <td align="left">
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." /></td>
</tr>

<tr>
<td colspan="7" align="center">  <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden"  name="indReg" >
		    <INPUT type="hidden" name="idUsu" ></td>
</tr>
</tbody>
</table>
   </fieldset>

<fieldset class="form">
  <legend>Listado Resumen Marca CHERY</legend>
  <table width="60%" align="center" class="detalles">
  <tr><td colspan="7" align="right">
			  			<!--<a class="vinculo" target="_blank" onClick="abrir('reportes/pdflistResumenVehxEdo.php?lote=<?php echo$numlotveh;?>');" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a>-->
			        	<a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>

			        	</td></tr>
          <tr  class="cabecera">
             <th width="20%" rowspan="2">Estado</th>
             <th width="15%" colspan="5">Modelo</th>
             <th width="15%" rowspan="2">Total</th>
          </tr>
           <tr  class="cabecera">
             <th width="10%">QQ3</th>
             <th width="10%">X1</th>
             <th width="10%">Tiggo</th>
             <th width="10%">Tigger 4*2</th>
             <th width="10%">Tigger 4*4</th>
             </tr>
<? for ($i=0;$i<$nroEdo;$i++){
        $color = (!$indC)?'datosimpar':'datospar';
        $indC = !$indC;
?>
	<tr class="<?php echo $color ?>">
	<td align="left"><?

	 echo $listEstados[($i*2)+1];
	 $idEst=$listEstados[$i*2];
	 //$listarVehxEstado = $objReporte->matrizVehxEstado(14,$idEst);
	 $listarVehxEstado = $objReporte->matrizVehxEstado($numlotveh,$idEst);
	 $_SESSION['listarVehxEstado']=$listarVehxEstado;

	?></td>
	<? if ($listEstados){
		for($j=0;$j<count($listarVehxEstado);$j+=6){
	?>
	      <td align="center" title="QQ3"><?php echo ($listarVehxEstado[($j*5)+1]==0)?"":$listarVehxEstado[($j*5)+1]?></td>
          <td align="center" title="x1"><?php echo ($listarVehxEstado[($j*5)+2]==0)?"":$listarVehxEstado[($j*5)+2]?></td>
          <td align="center" title="tiggo"><?php echo ($listarVehxEstado[($j*5)+3]==0)?"":$listarVehxEstado[($j*5)+3]?></td>
          <td align="center" title="tiger 4*2"><?php echo ($listarVehxEstado[($j*5)+4]==0)?"":$listarVehxEstado[($j*5)+4] ?></td>
          <td align="center" title="tiger 4*4"><?php echo ($listarVehxEstado[($j*5)+5]==0)?"":$listarVehxEstado[($j*5)+5]?></td>

    <?php $tbanco=$listarVehxEstado[($j*5)+1]+$listarVehxEstado[($j*5)+2]+$listarVehxEstado[($j*5)+3]+$listarVehxEstado[($j*5)+4]+$listarVehxEstado[($j*5)+5];?>
			  <td align="center" title="tiger 4*4"><?php echo $tbanco?></td>
<?php

$tqq=$tqq+$listarVehxEstado[($j*5)+1];
$tx=$tx+$listarVehxEstado[($j*5)+2];
$tg=$tg+$listarVehxEstado[($j*5)+3];
$tg2=$tg2+$listarVehxEstado[($j*5)+4];
$tg4=$tg4+$listarVehxEstado[($j*5)+5];
?>
	<? } } ?>
    </tr>
<? }?>
<tr class="<?php echo $color ?>">
<td align="left">SIN ESTADO</td>
<? for($k=0;$k<count($listarVehsinEstado);$k+=6){ ?>
          <td align="center" title="QQ3"><?php echo ($listarVehsinEstado[($k*5)+1]==0)?"":$listarVehsinEstado[($k*5)+1]?></td>
          <td align="center" title="x1"><?php echo ($listarVehsinEstado[($k*5)+2]==0)?"":$listarVehsinEstado[($k*5)+2]?></td>
          <td align="center" title="tiggo"><?php echo ($listarVehsinEstado[($k*5)+3]==0)?"":$listarVehsinEstado[($k*5)+3]?></td>
          <td align="center" title="tiger 4*2"><?php echo ($listarVehsinEstado[($k*5)+4]==0)?"":$listarVehsinEstado[($k*5)+4] ?></td>
          <td align="center" title="tiger 4*4"><?php echo ($listarVehsinEstado[($k*5)+5]==0)?"":$listarVehsinEstado[($k*5)+5]?></td>

              <?php $tbancoc=$listarVehsinEstado[($k*5)+1]+$listarVehsinEstado[($k*5)+2]+$listarVehsinEstado[($k*5)+3]+$listarVehsinEstado[($k*5)+4]+$listarVehsinEstado[($k*5)+5];?>
			  <td align="center" title="Total Sin Estado"><?php echo $tbancoc?></td>
<?
$tqqc=$tqqc+$listarVehsinEstado[($k*5)+1];
$txc=$txc+$listarVehsinEstado[($k*5)+2];
$tgc=$tgc+$listarVehsinEstado[($k*5)+3];
$tg2c=$tg2c+$listarVehsinEstado[($k*5)+4];
$tg4c=$tg4c+$listarVehsinEstado[($k*5)+5];
}
?></tr>

<tr class="cabecera">
<th width="15%">Total</th>
<td align="center" title="tiger 4*4"><?php echo $tqq + $tqqc;   $_SESSION['realqq']=$tqq + $tqqc;?></td>
<td align="center" title="tiger 4*4"><?php echo $tx + $txc;     $_SESSION['realx1']=$tx + $txc;?></td>
<td align="center" title="tiger 4*4"><?php echo $tg + $tgc;     $_SESSION['realtig']= $tg + $tgc;?></td>
<td align="center" title="tiger 4*4"><?php echo $tg2 + $tg2c;   $_SESSION['realt42']=$tg2 + $tg2c; ?></td>
<td align="center" title="tiger 4*4"><?php echo $tg4 + $tg4c;    $_SESSION['realt44']=$tg4 + $tg4c ;?></td>
<?php $total=$tqq+$tx+$tg+$tg2+$tg4+$tqqc+$txc+$tgc+$tg2c+$tg4c;   $_SESSION['totaltotal']=$total;?>
<td align="center" title="tiger 4*4"><?php echo $total?></td>
</tr>
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