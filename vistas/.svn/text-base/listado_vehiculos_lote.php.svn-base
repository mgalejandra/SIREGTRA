<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/reportes.php');
require('../modelos/pago.php');
require('../modelos/banco.php');
require('../modelos/lotes.php');



$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,4,10,15,18,23);
validaAcceso($permitidos,$dir);


$indBusq = $_POST['indBusq'];
$objReporte= new reportes();
$objPago = new pago();
$objBanco 		= new banco();
$objLotes 		= new lotes();

  $indBusq 	= $_POST['indBusq'];
  $pgActual = $_POST['pagina'];

  $numlotveh= $_POST['numlotveh'];
  $codmar	= $_POST['codmar'];
  $codmodveh= $_POST['codmodveh'];
  $fechaF = $_POST['fechaF'];
  $fechaD = $_POST['fechaD'];
  $fechaH = $_POST['fechaH'];
  $banco = $_POST['banco'];

 // echo "Banco: ".$banco;

if($indBusq==2){

    $numlotveh 	= null;
  	$codmarveh	= null;
  	$codmodveh	= null;
  	$fechaF = null;
  	$fechaD = null;
  	$fechaH = null;
  	$banco = null;
}

$listarStatVeh = $objReporte->resumenCarros($codmar,$fechaF,$fechaD,$fechaH,$codmodveh,$numlotveh,$banco);

$_SESSION['listarStatVehLot']=$listarStatVeh;

$listarBancos=$objPago->listarBancos(3);

if ($banco) $nombreB = $objBanco->listarBancos($banco);
$_SESSION['nombanlot']=$nombreB[2];
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
	  	   " = window.open('reportes/xlscuadroListadoVehLote.php?marca=<?php echo$marca;?>&desde=<?php echo$fechaD;?>&hasta=<?php echo$fechaH;?>&mod=<?php echo$modelo;?>&fecfac=<?php echo$fechaF;?>&lote=<?php echo$numlotveh;?>&banco=<?php echo$banco;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");


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
	<td><input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/></td>
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

<fieldset class="form">
  <legend>Listado Resumen de Proformas de Vehículos por Estatus - Agrupados por Lote</legend>
  <table align="right">
  <tr>
      <!--  <td colspan="23" align="right">
        	<a class="vinculo" target="_blank" onClick="popupPDF('reportes/pdfcuadroListadoVehLote.php?marca=<? echo $marca;?>&desde=<? echo $fechaD;?>&hasta=<? echo $fechaH;?>&mod=<? echo $modelo;?>&fecfac=<? echo $fechaF;?>&lote=<? echo $lote;?>&banco=<? echo $banco;?>');return false;">
        	<IMG title="PDF" src="botones/pdf.png" height="15"></a>
        </td>-->
    	<td align="center">
    		<a class="vinculo" target="_blank" onClick="exel(2)">
    			<IMG title="CALC" src="botones/calc.png" height="15">
    		</a>
    	</td>
    	<td align="center">
    	    <a class="vinculo" target="_blank" onClick="exel(1)">
    		<IMG title="EXCEL" src="botones/excel.png" height="15">
    	</td>
        </tr>
  </table>
		<TABLE border="0" cellspacin="0" cellpadding="0" align="center">
		<TR>
		<TD valign="top">
		  <TABLE class="dato" border="0" width="900" align="center">
		   <TR class="cabecera">
		   <TH colspan="27"><? echo "Proformas de Vehículos por Estatus"?></TH>
     	   </TR>
     	   <?

     	      if ($banco)  echo "<TR class='cabecera'><TH colspan='27'>".$nombreB[2]."</TH></tr>";

		      if (($fechaD) and ($fechaH))
		   	  {

		   	  	echo "<TR class='cabecera'><TH colspan='27'>Desde el ".$fechaD.' hasta el '.$fechaH."</TH></tr>";
		   	  }
		   	  elseif (($fechaD) and !($fechaH))
		   	  {
		   	  		echo "<TR class='cabecera'><TH colspan='27'>Desde el ".$fechaD."</TH></tr>";
		   	  }
		   	  elseif (!($fechaD) and ($fechaH))
			  {
			  		echo "<TR class='cabecera'><TH colspan='27'>Hasta el ".$fechaH."</TH></tr>";
			  }
		   ?>
		   <TR class="cabecera">
		    <TH width="5%">Lote N°</TH>
		    <TH width="5%">Cantidad Lote</TH>
		    <TH width="5%">Marca</TH>
		    <TH width="40%">Cantidad x Marca</TH>
		    <TH width="40%" colspan="2">Modelo/Cant.</TH>
            <TH width="20%" title="Vencidas"><font size="1">Venc.</font></TH>
			<TH width="40%" title="Emitidas"><font size="1">Emit.</font></TH>
			<TH width="40%" title="Análisis"><font size="1">Anál.</font></TH>
			<TH width="40%" title="A la espera de Documentos"><font size="1">ED</font></TH>
			<TH width="40%" title="Crédito Aprobado"><font size="1">Apro.</font></TH>
			<TH width="40%" title="A la espera de consignar inicial"><font size="1">ECI</font></TH>
			<TH width="40%" title="Inicial Consignada"><font size="1">IC</font></TH>
			<TH width="40%" title="Factura Emitida"><font size="1">FE</font></TH>
			<TH width="40%" title="Certificado emitido"><font size="1">CE</font></TH>
			<TH width="40%" title="Reserva de Dominio Enviada a Suvinca"><font size="1">RDS</font></TH>
			<TH width="40%" title="Firma de Reserva de Dominio"><font size="1">FRD</font></TH>
			<TH width="40%" title="Recepción de Reserva de Dominio"><font size="1">RRD</font></TH>
			<TH width="40%" title="Póliza consignada"><font size="1">PC</font></TH>
			<TH width="40%" title="Documento Notariado"><font size="1">DN</font></TH>
			<TH width="40%" title="Crédito Liquidado"><font size="1">Liq.</font></TH>
			<TH width="40%" title="Por entregar en acto"><font size="1">PEA</font></TH>
			<TH width="40%" title="Vehículo Entregado"><font size="1">VE</font></TH>
			<TH width="40%" title="Crédito Negado"><font size="1">Neg.</font></TH>
			<TH width="40%" title="PDI No Apto"><font size="1">NO PDI</font></TH>
			<TH width="40%" title="Total Real"><font size="1">Total Real</font></TH>
			<TH width="40%" title="Total Disponible"><font size="1">Total Disp.</font></TH>
	   </TR>
 	<!--   <tr class="<?php echo $_SESSION['color']; ?>"><td rowspan="<?  echo count($listarStatVeh)+1;?>" align="center"><? echo $_SESSION['inventolote'];?></td>
 	   <td rowspan="<?  echo count($listarStatVeh)+1;?>" align="center"><? echo $_SESSION['suma'];?></td>-->
<?php

          	$vencidas=0;
			$emitidas=0;
		    $analisis=0;
			$esperadoc=0;
			$aprobado=0;
			$esperacons=0;
			$inicialcons=0;
			$factuemi=0;
			$certifemi=0;
			$reservadomsuv=0;
			$firmaresdomsuv=0;
			$recepresdomsuv=0;
			$polizacons=0;
			$docnot=0;
			$liquidado=0;
			$entregado=0;
			$porentregaract=0;
			$rechazado = 0;
			$nopdi=0;

          $contArt = 0;

          for($i=0;$i<count($listarStatVeh);$i++)
	      {
          	  $color = (!$indC)?'datosimpar':'datospar';
          	  $_SESSION['color'] = $color;
              $indC = !$indC;
              $contArt ++;

             // echo "Marca: ".$listarStatVeh[$i][24];
     ?>
     <tr class="<?php echo $color ?>">
           <TD align="left"><?php if ($listarStatVeh[$i][0]<>$listarStatVeh[$i-1][0]){  echo $listarStatVeh[$i][0]; $cuenta=1; $totalot=$listarStatVeh[$i][4]; }?></TD>

           <?php
               	//$totalot = $listarStatVeh[$i][4];

              /*  if ($listarStatVeh[$i][0]<>$listarStatVeh[-1][0])
                {
                	$cuento++;
                	$totalot = $listarStatVeh[$i][4];  echo "a";
                }
                elseif ($listarStatVeh[$i][0]==$listarStatVeh[$i-1][0])
                {
                	$totalot =$totalot + $listarStatVeh[$i][4];
                }
                elseif ($listarStatVeh[$i+1][0]==$listarStatVeh[$i][0])
				{
					$totalot = 0;
					$total1 =0;
				}

	                  $total1 = $total1+$totalot;*/

           ?><TD align="left"><? $cantidadLote = $objLotes->cantidadVehLote($listarStatVeh[$i][0]);
           if ($listarStatVeh[$i][0]<>$listarStatVeh[$i-1][0]) echo $cantidadLote[0]; ?></TD>
     	   <TD align="left" title="<?php echo $listarStatVeh[$i][2] ?>"><?php
		        if ($listarStatVeh[$i][2]<>$listarStatVeh[$i-1][2]){
		        	if(strlen($listarStatVeh[$i][2])>25)echo  substr($listarStatVeh[$i][2],0,25).'...';
		       		else echo $listarStatVeh[$i][2];
		        }
		      ?>
		    </TD>
		    <td><? $cantidadLoteMarca = $objLotes->cantidadVehLotexMarca($listarStatVeh[$i][0],$listarStatVeh[$i][24]);

                   if ($listarStatVeh[$i][2]<>$listarStatVeh[$i-1][2]) echo $cantidadLoteMarca[0];
                   if (($listarStatVeh[$i][0]<>$listarStatVeh[$i-1][0]) and ($listarStatVeh[$i][2]==$listarStatVeh[$i-1][2])) echo $cantidadLoteMarca[0];

                ?></td>
		    <td><?php echo $listarStatVeh[$i][3];?></td><td><? echo $listarStatVeh[$i][4]; $_SESSION['suma']=$listarStatVeh[$i][4] + $_SESSION['suma'];?></td>

		    <?/*$listarCuentaVeh= $objReporte->resumenCarros($listarStatVeh[$i][0],$fechaF,$fechaD,$fechaH,$listarStatVeh[$i][1],$numlotveh,$banco);
				echo $listarCuentaVeh[4];
				$_SESSION['suma']=$listarCuentaVeh[4] + $_SESSION['suma'];*/
            ?></td>
		    <TD align="center"><?php echo  ($listarStatVeh[$i][5]==0)?"":$listarStatVeh[$i][5] ?></TD>
		    <TD align="center"><?php echo  ($listarStatVeh[$i][6]==0)?"":$listarStatVeh[$i][6]?></TD>
		    <TD align="center"><?php echo  ($listarStatVeh[$i][7]==0)?"":$listarStatVeh[$i][7]?></TD>
		    <TD align="center"><?php echo  ($listarStatVeh[$i][8]==0)?"":$listarStatVeh[$i][8]?></TD>
		    <TD align="center"><?php echo  ($listarStatVeh[$i][9]==0)?"":$listarStatVeh[$i][9]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][10]==0)?"":$listarStatVeh[$i][10]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][11]==0)?"":$listarStatVeh[$i][11]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][12]==0)?"":$listarStatVeh[$i][12]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][13]==0)?"":$listarStatVeh[$i][13]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][14]==0)?"":$listarStatVeh[$i][14]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][15]==0)?"":$listarStatVeh[$i][15]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][16]==0)?"":$listarStatVeh[$i][16]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][17]==0)?"":$listarStatVeh[$i][17]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][18]==0)?"":$listarStatVeh[$i][18]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][19]==0)?"":$listarStatVeh[$i][19]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][22]==0)?"":$listarStatVeh[$i][22]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][20]==0)?"":$listarStatVeh[$i][20]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][21]==0)?"":$listarStatVeh[$i][21]?></TD>
			<TD align="center"><?php echo  ($listarStatVeh[$i][23]==0)?"":$listarStatVeh[$i][23]?></TD>
		    <?   $totalF1=$listarStatVeh[$i][4];  //Existentes


		         $totalF=$listarStatVeh[$i][5];
		         $totalF+=$listarStatVeh[$i][6];
		         $totalF+=$listarStatVeh[$i][7];
		         $totalF+=$listarStatVeh[$i][8];
		         $totalF+=$listarStatVeh[$i][9];
		         $totalF+=$listarStatVeh[$i][10];
		         $totalF+=$listarStatVeh[$i][11];
		         $totalF+=$listarStatVeh[$i][12];
		         $totalF+=$listarStatVeh[$i][13];
		         $totalF+=$listarStatVeh[$i][14];
		         $totalF+=$listarStatVeh[$i][15];
		         $totalF+=$listarStatVeh[$i][16];
		         $totalF+=$listarStatVeh[$i][17];
		         $totalF+=$listarStatVeh[$i][18];
		         $totalF+=$listarStatVeh[$i][19];
		         $totalF+=$listarStatVeh[$i][20];
		         $totalF+=$listarStatVeh[$i][22];
		         $totalF+=$listarStatVeh[$i][23];

				$totalR = $totalF1 - $totalF;

		    ?>
            <TD align="center" class="cabeceraI"><?php echo  $totalF ?></TD>
            <TD align="center" class="cabeceraI"><?php echo  $totalR ?></TD>

		   </TR>
<?php
            $existentes+=$listarStatVeh[$i][4];
            $vencidas+=$listarStatVeh[$i][5];
			$emitidas+=$listarStatVeh[$i][6];
		    $analisis+=$listarStatVeh[$i][7];
			$esperadoc+=$listarStatVeh[$i][8];
			$aprobado+=$listarStatVeh[$i][9];
			$esperacons+=$listarStatVeh[$i][10];
			$inicialcons+=$listarStatVeh[$i][11];
			$factuemi+=$listarStatVeh[$i][12];
			$certifemi+=$listarStatVeh[$i][13];
			$reservadomsuv+=$listarStatVeh[$i][14];
			$firmaresdomsuv+=$listarStatVeh[$i][15];
			$recepresdomsuv+=$listarStatVeh[$i][16];
			$polizacons+=$listarStatVeh[$i][17];
			$docnot+=$listarStatVeh[$i][18];
			$liquidado+=$listarStatVeh[$i][19];
			$entregado+=$listarStatVeh[$i][20];
			$rechazado+=$listarStatVeh[$i][21];
			$porentregaract+=$listarStatVeh[$i][22];
			$nopdi+=$listarStatVeh[$i][23];

          	$reales =  $nopdi + $emitidas + $analisis + $esperadoc + $aprobado + $esperacons + $inicialcons + $factuemi + $certifemi + $reservadomsuv + $firmaresdomsuv + $recepresdomsuv + $polizacons + $docnot + $liquidado + $porentregaract + $entregado;
            $totaltotal1 = $existentes - $reales ;
 }
?>
      <tr class="cabeceraI">

		    <TH width="60%" colspan="6" align="right">TOTALES&nbsp;</TH>

			<TH width="40%" title="Vencidas"><font size="1"><? echo $vencidas; $_SESSION['venc']=$vencidas;?></font></TH>
			<TH width="40%" title="Emitidas"><font size="1"><? echo $emitidas; $_SESSION['emit']=$emitidas; ?></font></TH>
			<TH width="40%" title="Análisis"><font size="1"><? echo $analisis; $_SESSION['anal']=$analisis;?></font></TH>
			<TH width="40%" title="A la espera de Documentos"><font size="1"><? echo $esperadoc; $_SESSION['espera']=$esperadoc;?></font></TH>
			<TH width="40%" title="Crédito Aprobado"><font size="1"><? echo $aprobado; $_SESSION['aprob']=$aprobado; ?></font></TH>
			<TH width="40%" title="A la espera de consignar inicial"><font size="1"><? echo $esperacons; $_SESSION['esperac']=$esperacons; ?></font></TH>
			<TH width="40%" title="Inicial Consignada"><font size="1"><? echo $inicialcons; $_SESSION['inicial']=$inicialcons; ?></font></TH>
			<TH width="40%" title="Factura Emitida"><font size="1"><? echo $factuemi; $_SESSION['factu']=$factuemi; ?></font></TH>
			<TH width="40%" title="Certificado emitido"><font size="1"><? echo $certifemi; $_SESSION['certif']=$certifemi; ?></font></TH>
			<TH width="40%" title="Reserva de Dominio Enviada a Suvinca"><font size="1"><? echo $reservadomsuv; $_SESSION['reser']=$reservadomsuv; ?></font></TH>
			<TH width="40%" title="Firma de Reserva de Dominio"><font size="1"><? echo $firmaresdomsuv; $_SESSION['firma']=$firmaresdomsuv; ?></font></TH>
			<TH width="40%" title="Recepción de Reserva de Dominio"><font size="1"><? echo $recepresdomsuv; $_SESSION['recep']=$recepresdomsuv; ?></font></TH>
			<TH width="40%" title="Póliza consignada"><font size="1"><? echo $polizacons; $_SESSION['poliz']=$polizacons; ?></font></TH>
			<TH width="40%" title="Documento Notariado"><font size="1"><? echo  $docnot; $_SESSION['docn']=$docnot;?></font></TH>
			<TH width="40%" title="Crédito Liquidado"><font size="1"><? echo $liquidado; $_SESSION['liq']=$liquidado; ?></font></TH>
			<TH width="40%" title="Por entregar en Acto"><font size="1"><? echo $porentregaract; $_SESSION['pea']=$porentregaract; ?></font></TH>
			<TH width="40%" title="Vehículo Entregado"><font size="1"><? echo $entregado; $_SESSION['ent']=$entregado; ?></font></TH>
			<TH width="40%" title="Crédito Negado"><font size="1"><? echo $rechazado; $_SESSION['rech']=$rechazado; ?></font></TH>
			<TH width="40%" title="NO PDI"><font size="1"><? echo $nopdi; $_SESSION['nopdi']=$nopdi; ?></font></TH>
			<TH width="40%" title="Total Real (Sumatoria Emitidas hasta Veh. Entregados + Veh. No PDI)"><font size="1"><?  echo $reales;   $_SESSION['reales']=$reales; ?></font></TH>
			<TH width="40%" title="Total Disponible"><font size="1"><?  echo $totaltotal1;   $_SESSION['disponible']=$totaltotal1; ?></font></TH>
		    </TR>
		    <!--td colspan="21"-->
		    <tr>

		    <td colspan="3"><font size="1"><table>
		    <tr><td>Leyenda:</td></tr>
		    <tr><td>Emit.=</td><td align="left">Emitidas</td></tr>
		    <tr><td>Anál.=</td><td align="left"> Análisis</td></tr>
		    <tr><td>ED=</td><td align="left"> A la espera de Documentos</td></tr>
		    <tr><td>Apro.=</td><td align="left"> Aprobado</td></tr>
		    <tr><td>ECI=</td><td align="left">A la espera de consignar inicial</td></table></font></td>

		    <td colspan="3"><font size="1"><table>
		    <tr><td></td></tr>
		    <tr><td>IC=</td><td align="left">Inicial Consignada</td></tr>
		    <tr><td>FE=</td><td align="left">Factura Emitida</td></tr>
		    <tr><td>CE=</td><td align="left">Certificado emitido</td></tr>
		    <tr><td>RDS= </td><td align="left">Reserva de Dominio Enviada a Suvinca</td></tr>
		    <tr><td>FRD=</td><td align="left">Firma de Reserva de Dominio</td></tr>
		    <tr><td>RRD=</td><td align="left">Recepción de Reserva de Dominio</td>
		    </table></font></td>

			<td colspan="8"><font size="1"><table><tr><td></td></tr>
		    <tr><td>PC=</td><td align="left">Póliza consignada</td></tr>
		    <tr><td>DN=</td><td align="left">Documento Notariado</td></tr>
		    <tr><td>Liq.=</td><td align="left">Crédito Liquidado</td></tr>
		    <tr><td>PEA=</td><td align="left">Por Entregar en Acto</td></tr>
		    <tr><td>VE=</td><td align="left">Vehículo Entregado</td></tr>
		    <tr><td>Neg.=</td><td align="left">Crédito Negado</td></tr>
		    </table></font></td>

		    </tr>
		    </table>
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