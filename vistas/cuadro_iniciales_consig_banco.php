<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/reportes.php');
require('../modelos/pago.php');
require('../modelos/banco.php');
require('../modelos/lotes.php');
require('../modelos/factura.php');
require('../modelos/modelos.php');
require('../modelos/marca.php');


$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,4,10,15,18,22,23,25);
validaAcceso($permitidos,$dir);


$indBusq = $_POST['indBusq'];

$objFactura = new factura();
$objReporte= new reportes();
$objPago = new pago();
$objBanco 		= new banco();
$objLotes 		= new lotes();
$objMarca = new marca();
$objModelo = new modelos();
$nroFilas = 5;
  $indBusq 	= $_POST['indBusq'];
  $pgActual = $_POST['pagina'];

  $numlotveh= $_POST['numlotveh'];
  $codmar	= $_POST['codmar'];
  $codmodveh= $_POST['codmodveh'];
  $condicion = $_POST['cond'];
  $fechaD = $_POST['fechaD'];
  $fechaH = $_POST['fechaH'];
  $status = $_POST['estatus'];
  $banco = $_POST['banco'];

if($indBusq=='2'){
	$fechaD = NULL;
	$fechaH = NULL;
  	$numlotveh 	= null;
  	$codmarveh	= null;
  	$codmodveh	= null;
  	$condicion=null;
  	$banco = null;
}

$listarEstatus=$objFactura->listarEstatus();
$listarCertEmi = $objReporte->cuadroIniConsignadas($numlotveh,$fechaD,$fechaH,$codmar,$codmodveh,$banco);//;cuadroIniConsignadas();

$listarBancos=$objPago->listarBancos(3);

if ($banco) $nombreB = $objBanco->listarBancos($banco);

?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>
function enviar(campo){
	window.document.registro.indBusq.value = campo;
	window.document.registro.submit();
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
	  	   " = window.open('reportes/xlscuadroiniciales.php?numlotveh=<?php echo$numlotveh;?>&fechaD=<?php echo$fechaD;?>&fechaH=<?php echo$fechaH;?>&codmar=<?php echo$codmar;?>&codmodveh=<?php echo$codmodveh;?>&banco=<?php echo$banco;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
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
     <table  align="center" >
	<tr>
    <td  class="categoria">Marca:</td>
	<td align="left" ><input name="codmar" type="hidden" id="codmar"  value="<?echo $_SESSION['codmarveh_']?>" />
	    <input name="desmar" type="text" id="desmar"  value="<?echo $_SESSION['desmarveh_']?>"  readonly=""/></td>
	<td align="left"><input name="marca"  type="button" id="marca" onclick="catalogo('marca2.php');" value="..." /></td>
	<td></td>
	<td  class="categoria">Modelo:</td>
	<td><input name="codmodveh" type="hidden" id="codmodveh" value="<?echo $_SESSION['codmodveh_']?>" />
        <input name="desmodveh" type="text" id="modveh" value="<?echo$_SESSION['desmodveh_']?>" size="20" maxlength="15" readonly=""/></td>
    <td><input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." /><br /></td>
	<td></td>
</tr>
<tr>
<td rowspan="2" class="categoria">N° Lote:</td>
<td rowspan="2" align="left"><input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/></td>
<td rowspan="2"><input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." /></td>
<td rowspan="2"></td>
<td></td>
<td rowspan="2" class="categoria">Fecha Estatus:</td>
<td colspan="2" align="left"><font size="1">Desde: (dd/mm/aaaa)</font></td>
<td colspan="4" align="left"><font size="1">Hasta: (dd/mm/aaaa)</font></td>
</tr>
<tr>
<td></td>
<td colspan="2" align="left"><input id="fechaD" name="fechaD" type="text" size="10" maxlength="10" value="<?php echo $fechaD;?>" onKeyUp="javascript: mascara(this,'/',rray(2,2,4),true)" date_format="dd/MM/yy" readonly="" />
        <img src="../images/cal.gif" width="16" height="16" onclick="show_calendar('document.forms[0].fechaD',document.forms[0].fechaD.value)" /></td>
<td colspan="4" align="left"><input id="fechaH" name="fechaH" type="text" size="10" maxlength="10" value="<?php echo $fechaH;?>" onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)" date_format="dd/MM/yyyy" readonly="" />
        <img src="../images/cal.gif" width="16" height="16" onclick="show_calendar('document.forms[0].fechaH',document.forms[0].fechaH.value)" /></td>
</tr>
<tr>  <td class="categoria">Banco:</td>
        <td class="dato" colspan="5">
         	 <SELECT id="banco" name="banco">
			 <OPTION value=""></OPTION>
			    <?php for($i=0;$i<count($listarBancos);$i+=2){  ?>
	               <option value="<?php echo $listarBancos[$i]; ?>"><?php echo $listarBancos[$i+1]?></option>
	           <?php } ?>
			 </SELECT>
        </td></tr>
		<tr>
            <td align="center" colspan="9" >
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
  <legend>Iniciales Consignadas por Banco</legend>

  <table width="60%" align="center" class="detalles">
  <tr>
        <td colspan="7" align="right">
        <a class="vinculo" target="_blank" onClick="popupPDF('reportes/pdfcuadroInicialesBanco.php?marca=<?php echo$codmar;?>&desde=<?php echo$fechaD;?>&hasta=<?php echo$fechaH;?>&mod=<?php echo$codmodveh;?>&banco=<?php echo$banco;?>&lote=<?php echo$numlotveh;?>');return false;">
  	    <IMG title="PDF" src="botones/pdf.png" height="15"></a>
        	    	<a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				    </a>
				    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			        </a>
        </td>
        </tr>

            <?
	       	      if ($banco)  $nombreBanco = $nombreB[2];
	     	      else $nombreBanco="TODOS LOS BANCOS";

         	      echo "<TR class='cabeceraI'><TH colspan='7'>".$nombreBanco."</TH></tr>";

	     	      if (($codmar) or ($codmodveh)){

	     	      	$nombreMod= $objModelo->buscarModeloID($codmodveh);
	     	      	$nombreMar= $objMarca->buscarMarca($codmar);
	     	      }


	     	      if (($codmar) and ($codmodveh)) $detalles = $nombreMar[1]." ".$nombreMod[1];
	     	      else if (($codmar) and (!$codmodveh)) $detalles = $nombreMar[1];
	     	      else if ((!$codmar) and ($codmodveh)) $detalles = $nombreMod[1];
	     	      else $detalles = "TODAS LAS MARCAS - TODOS LOS MODELOS";


				  echo "<TR class='cabeceraI'><TH colspan='7'>".$detalles."</TH></tr>";

				  if($fechaD AND !$fechaH) $fechas = " DESDE EL ".$fechaD;
					else if (!$fechaD AND  $fechaH) $fechas =  " DESDE EL ".$fechaH;
					else if ($fechaD  AND  $fechaH)	$fechas = " DESDE EL ".$fechaD." HASTA EL ".$fechaH;

 				echo "<TR class='cabeceraI'><TH colspan='7'>".$fechas."</TH></tr>";

     	     ?>
          <tr  class="cabecera">
             <th width="30%" >Banco</th>
             <th width="15%" >Personas</th>
             <th width="15%" >Monto</th>
          </tr>

<?php

       for($j=0;$j<count($listarCertEmi);$j+=3){
//echo $i;
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
              <td align="center" title="Banco"><?php echo $listarCertEmi[$j+2]?></td>
              <td align="center" title="Personas"><?php echo $listarCertEmi[$j]?></td>
              <td align="center" title="Monto"><?php echo FormatoMonto($listarCertEmi[$j+1])?></td>

<?php

$pers=$pers+$listarCertEmi[$j];
$monto=$monto+$listarCertEmi[$j+1];

?>

<?php }
$colorc ='datospar'; ?>
</tr>

<tr class="cabecera">
<th width="15%">Total</th>
<td align="center" title="Personas"><?php echo $pers;?></td>
<td align="center" title="Monto"><?php echo FormatoMonto($monto); ?></td>

</tr>
    </table>
</fieldset>
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