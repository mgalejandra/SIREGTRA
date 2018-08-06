<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/reportes.php');
require('../modelos/pago.php');
require('../modelos/banco.php');


$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,4,5,6,7,15,18,25);
validaAcceso($permitidos,$dir);


$indBusq = $_POST['indBusq'];
$objReporte= new reportes();
$objPago 		= new pago();
$objBanco 		= new banco();
/*$objBancos= new bancos();
$objDistribuidor = new beneficiario();*/

  $indBusq 	= $_POST['indBusq'];
  $pgActual = $_POST['pagina'];

  $numlotveh= $_POST['numlotveh'];
  $codmar	= $_POST['codmar'];
  $codmodveh= $_POST['codmodveh'];
  $fechaF = $_POST['fechaF'];
  $fechaD = $_POST['fechaD'];
  $fechaH = $_POST['fechaH'];
  $banco = $_POST['banco'];


if($indBusq==2){

    $numlotveh 	= null;
  	$codmarveh	= null;
  	$codmodveh	= null;
  	$fechaF = null;
  	$fechaD = null;
  	$fechaH = null;
}



$listarStatVeh = $objReporte->resumenBancoliqui($codmar,$fechaF,$fechaD,$fechaH,$codmodveh,$numlotveh,$banco);
$_SESSION['listarStatVeh']=$listarStatVeh;

$listarBancos=$objPago->listarBancos(3);

if ($banco) $nombreB = $objBanco->listarBancos($banco);
$_SESSION['nomban']=$nombreB[2];
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
	<td class="categoria">N° Lote:</td>
	<td><input name="numlotveh" type="text" id="numlotveh" value="<?php if($numlotveh) echo $numlotveh;?>" size="3" maxlength="3"/></td>
	<td><input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." /></td>
</tr>
<tr>
<td rowspan="2" class="categoria">Fecha Proforma:</td>
<td rowspan="2" align="left"><input name="fechaF" type="text" id="fechaF" value="" size="10"  maxlength="10" date_format="dd/MM/yy" onkeyup="javascript: mascara(this,'/',Array(2,2,4),true)" readonly=""/>
        <img src="../images/cal.gif" width="16" height="16" onclick="show_calendar('document.forms[0].fechaF',document.forms[0].fechaF.value)" />
</td>
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
        <td class="dato" colspan="3">
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

<fieldset>
  <legend>Listado Resumen Movimientos Proformas</legend>

		<TABLE border="0" cellspacin="0" cellpadding="0" align="center">
		<TR>
		<TD valign="top">
		  <TABLE class="dato" border="0" width="900" align="center">
		   <TR class="cabeceraI">
		   <TH colspan="25"><? echo "Proformas de Vehículos por Estatus"?></TH>
     	   </TR>
     	   <?

     	      if ($banco)  echo "<TR class='cabeceraI'><TH colspan='25'>".$nombreB[2]."</TH></tr>";

		      if (($fechaD) and ($fechaH))
		   	  {

		   	  	echo "<TR class='cabeceraI'><TH colspan='25'>Desde el ".$fechaD.' hasta el '.$fechaH."</TH></tr>";
		   	  }
		   	  elseif (($fechaD) and !($fechaH))
		   	  {
		   	  		echo "<TR class='cabeceraI'><TH colspan='25'>Desde el ".$fechaD."</TH></tr>";
		   	  }
		   	  elseif (!($fechaD) and ($fechaH))
			  {
			  		echo "<TR class='cabeceraI'><TH colspan='25'>Hasta el ".$fechaH."</TH></tr>";
			  }
		   ?>
		   <TR class="cabeceraI">
		    <TH width="5%">Marca</TH>
		    <TH width="40%">Modelo</TH>
		    <!--<TH width="30%">Existencia</TH>-->
			<TH width="40%" title="Crédito Liquidado"><font size="1">Liquidado</font></TH>
			<TH width="40%" title="Vehículo Entregado"><font size="1">Veh. Entregado</font></TH>
	   </TR>
<?php

			$liquidado=0;
			$porentregact=0;//NUEVO
			$entregado=0;


          $contArt = 0;
	      for($i=0;$i<count($listarStatVeh);$i++)
	      {
          	  $color = (!$indC)?'datosimpar':'datospar';
              $indC = !$indC;
              $contArt ++;
     ?>
      <tr class="<?php echo $color ?>">
		    <TD align="left"><?php echo $listarStatVeh[$i][0];    ?></TD>
		    <TD align="left" title="<?php echo $listarStatVeh[$i][1] ?>"><?php
		       if(strlen($listarStatVeh[$i][1])>25)echo  substr($listarStatVeh[$i][1],0,25).'...';
		       else echo $listarStatVeh[$i][1];
		      ?>
		    </TD>
		  <!-- <TD align="center"  class="cabeceraI"><?php echo  ($listarStatVeh[$i][2]==0)?"":$listarStatVeh[$i][2] ?></TD>-->

			<TD align="center"><?php echo  ($listarStatVeh[$i][17]==0)?"":$listarStatVeh[$i][17]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][18]==0)?"":$listarStatVeh[$i][18]?></TD>

		    <?   //$totalF1=$listarStatVeh[$i][2];  //Existentes

				 $totalF+=$listarStatVeh[$i][17];
				 $totalF+=$listarStatVeh[$i][18];


		    ?>

		   </TR>
<?php

			$liquidado+=$listarStatVeh[$i][17];
			$entregado+=$listarStatVeh[$i][18];
	        $reales = $vencidas + $emitidas + $analisis + $esperadoc + $aprobado + $esperacons + $inicialcons + $factuemi + $certifemi + $reservadomsuv + $firmaresdomsuv +	$recepresdomsuv + $polizacons + $docnot + $incompliquid + $liquidado + $porentregact + $entregado +	$rechazado + $reconsideracion +	$reconaprob + $reconrecha;
            //$totaltotal1 = $existentes - $reales;



 }
?>
      <tr class="cabeceraI">

		    <TH width="60%" colspan="2" align="right">TOTALES&nbsp;</TH>
			<TH width="40%" title="Crédito Liquidado"><font size="1"><? echo $liquidado; $_SESSION['liq']=$liquidado; ?></font></TH>
			<TH width="40%" title="Vehículo Entregado"><font size="1"><? echo $entregado; $_SESSION['ent']=$entregado; ?></font></TH>
		    </TR>
		  </TABLE>
		</TD>
		</TR>
		</TABLE>
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