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
$permitidos = array(1,2,4,10,11,15,18,23,25);
validaAcceso($permitidos,$dir);


$indBusq = $_POST['indBusq'];

$objReporte = new reportes();
$objLotes 	= new lotes();
$objZona 	= new zona();


$nroCampos = 3;

  $indBusq 	= $_POST['indBusq'];
  $pgActual = $_POST['pagina'];


$listEstados = $objZona->listarEstados();
$nroEdo = count($listEstados)/2;

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


function excel(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id +
	  	   " = window.open('reportes/xlsListarTaxisxEdo.php?numlotveh=<?php echo$numlotveh;?>&numfacori=<?php echo$numfacori;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

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
<fieldset class="form">
  <legend>Listado Resumen Taxis Chery Orinoco</legend>
  <table width="60%" align="center" class="detalles">
    <tr><td colspan="8" align="right">
			        	<a class="vinculo" target="_blank" onClick="excel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="excel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>

			        	</td></tr>
          <tr  class="cabecera">
             <th width="20%" rowspan="2">Estado</th>
             <th width="15%" colspan="6">Lote</th>
             <th width="15%" rowspan="2">Total</th>
          </tr>
           <tr  class="cabecera">
             <th width="10%">25</th>
             <th width="10%">26</th>
             <th width="10%">28</th>
             <th width="10%">29</th>
             <th width="10%">32</th>
             <th width="10%">33</th>
             </tr>
<? for ($i=0;$i<$nroEdo;$i++){
        $color = (!$indC)?'datosimpar':'datospar';
        $indC = !$indC;
?>
	<tr class="<?php echo $color ?>">
	<td align="left"><?

	 echo $listEstados[($i*2)+1];
	 $idEst=$listEstados[$i*2];
	 $listarVehxEstado = $objReporte->matrizTaxisxEstado($idEst);
	 $_SESSION['listarVehxEstado']=$listarVehxEstado;

	?></td>
	<? if ($listEstados){
		for($j=0;$j<count($listarVehxEstado);$j+=7){
	?>
	      <td align="center" title="Lote 25"><?php echo ($listarVehxEstado[($j*6)+1]==0)?"":$listarVehxEstado[($j*6)+1]?></td>
          <td align="center" title="Lote 26"><?php echo ($listarVehxEstado[($j*6)+2]==0)?"":$listarVehxEstado[($j*6)+2]?></td>
          <td align="center" title="Lote 28"><?php echo ($listarVehxEstado[($j*6)+3]==0)?"":$listarVehxEstado[($j*6)+3]?></td>
          <td align="center" title="Lote 29"><?php echo ($listarVehxEstado[($j*6)+4]==0)?"":$listarVehxEstado[($j*6)+4] ?></td>
          <td align="center" title="Lote 32"><?php echo ($listarVehxEstado[($j*6)+5]==0)?"":$listarVehxEstado[($j*6)+5]?></td>
          <td align="center" title="Lote 33"><?php echo ($listarVehxEstado[($j*6)+6]==0)?"":$listarVehxEstado[($j*6)+6]?></td>

    <?php $tbanco=$listarVehxEstado[($j*6)+1]+$listarVehxEstado[($j*6)+2]+$listarVehxEstado[($j*6)+3]+$listarVehxEstado[($j*6)+4]+$listarVehxEstado[($j*6)+5]+$listarVehxEstado[($j*6)+6];?>
			  <td align="center" title="Total Estado"><?php echo $tbanco?></td>
<?php

$lote25=$lote25+$listarVehxEstado[($j*6)+1];
$lote26=$lote26+$listarVehxEstado[($j*6)+2];
$lote28=$lote28+$listarVehxEstado[($j*6)+3];
$lote29=$lote29+$listarVehxEstado[($j*6)+4];
$lote32=$lote32+$listarVehxEstado[($j*6)+5];
$lote33=$lote33+$listarVehxEstado[($j*6)+6];
?>
	<? } } ?>
    </tr>
<? }?>
<tr class="<?php echo $color ?>">
<td align="left">SIN ESTADO</td>
<? //for($k=0;$k<count($listarVehsinEstado);$k+=6){ 

$listarVehsinEstado25 = $objReporte->matrizTaxisSinEstado(25);
$listarVehsinEstado26 = $objReporte->matrizTaxisSinEstado(26);
$listarVehsinEstado28 = $objReporte->matrizTaxisSinEstado(28);
$listarVehsinEstado29 = $objReporte->matrizTaxisSinEstado(29);
$listarVehsinEstado32 = $objReporte->matrizTaxisSinEstado(32);
$listarVehsinEstado33 = $objReporte->matrizTaxisSinEstado(33);


?>
          <td align="center" title="Lote 25"><?php echo ($listarVehsinEstado25[1]==0)?"":$listarVehsinEstado25[1]?></td>
          <td align="center" title="Lote 26"><?php echo ($listarVehsinEstado26[1]==0)?"":$listarVehsinEstado26[1]?></td>
          <td align="center" title="Lote 28"><?php echo ($listarVehsinEstado28[1]==0)?"":$listarVehsinEstado28[1]?></td>
          <td align="center" title="Lote 29"><?php echo ($listarVehsinEstado29[1]==0)?"":$listarVehsinEstado29[1] ?></td>
          <td align="center" title="Lote 32"><?php echo ($listarVehsinEstado32[1]==0)?"":$listarVehsinEstado32[1]?></td>
          <td align="center" title="Lote 33"><?php echo ($listarVehsinEstado33[1]==0)?"":$listarVehsinEstado33[1]?></td>
              <?php $tbancoc=$listarVehsinEstado25[1]+$listarVehsinEstado26[1]+$listarVehsinEstado28[1]+$listarVehsinEstado29[1]+$listarVehsinEstado32[1]+$listarVehsinEstado33[1];?>
			  <td align="center" title="Total Sin Estado"><?php echo $tbancoc?></td>
<?
$lote25c=$lote25c+$listarVehsinEstado25[1];
$lote26c=$lote26c+$listarVehsinEstado26[1];
$lote28c=$lote28c+$listarVehsinEstado28[1];
$lote29c=$lote29c+$listarVehsinEstado29[1];
$lote32c=$lote32c+$listarVehsinEstado32[1];
$lote33c=$lote33c+$listarVehsinEstado33[1];
//}
?></tr>

<tr class="cabecera">
<th width="15%">Total</th>
<td align="center" title="Lote 25"><?php echo $lote25 + $lote25c;   $_SESSION['realLote25']=$lote25 + $lote25c;?></td>
<td align="center" title="Lote 26"><?php echo $lote26 + $lote26c;     $_SESSION['realLote26']=$lote26 + $lote26c;?></td>
<td align="center" title="Lote 28"><?php echo $lote28 + $lote28c;     $_SESSION['realLote28']= $lote28 + $lote28c;?></td>
<td align="center" title="Lote 29"><?php echo $lote29 + $lote29c;   $_SESSION['realLote29']=$lote29 + $lote29c; ?></td>
<td align="center" title="Lote 32"><?php echo $lote32 + $lote32c;    $_SESSION['realLote32']=$lote32 + $lote32c ;?></td>
<td align="center" title="Lote 33"><?php echo $lote33 + $lote33c;    $_SESSION['realLote33']=$lote33 + $lote33c ;?></td>
<?php $total=$lote25+$lote26+$lote28+$lote29+$lote32+$lote33+$lote25c+$lote26c+$lote28c+$lote29c+$lote32c+$lote33c;   $_SESSION['totaltotal']=$total;?>
<td align="center" title="Total General"><?php echo $total?></td>
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