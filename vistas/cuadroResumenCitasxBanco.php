<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/citas.php');
require('../modelos/beneficiario.php');
require('../modelos/pago.php');
require('../modelos/banco.php');

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,4,5,6,7,11,15,18,25);
validaAcceso($permitidos,$dir);

$objCitas= new citas();
$objBeneficiario=new beneficiario();
$objPago = new pago();
$objBanco = new banco();


$nroCampos = 6;

 $indBusq = $_POST['indBusq'];
 $tipoBen = $_POST['tipoben'];
 $fechaD  = $_POST['fecE'];
 $fechaH  = $_POST['fecE2'];
 $banco   = $_POST['banco'];

if($indBusq==2){
    $tipoBen = null;
    $fechaD  = null;
    $fechaH  = null;
    $banco   = null;
}


$listarBeneficiario=$objBeneficiario->listarTipo_benef();
$listarBancos=$objPago->listarBancos(4);

$listarCitasBanco = $objCitas->cuadroResumenCitasxBanco($tipoBen,$fechaD,$fechaH,$banco);
$_SESSION['listarCitasBanco']=$listarCitasBanco;

if ($banco) $nombreB = $objBanco->listarBancos($banco);
$_SESSION['nomban']=$nombreB[2];
?>
<!DOCTYPE HTML PUBLIC>
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
	  	   " = window.open('reportes/xlsResumenCitasxBanco.php?tipo=<? echo$tipoBen;?>&fechaD=<? echo$fechaD;?>&fechaH=<? echo$fechaH; ?>&banco=<? echo$banco;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
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
  <legend>Criterios de B&uacute;squeda </legend>
     <table  align="center" >
	<tr>
	<td  class="categoria">Tipo beneficiario:</td>
           <td class="dato">
			 <SELECT id="tipoben" name="tipoben">
			  <option value="<?php if ($tipoben) echo $tipoben?>"><?php if ($tipoben) echo $listarFactura[30];?></option>
			    <?php for($i=0;$i<count($listarBeneficiario);$i+=2){  ?>
	               <option value="<?php echo $listarBeneficiario[$i]; ?>"><?php echo $listarBeneficiario[$i+1]?></option>
	           <?php } ?>
          </select>
		  </td>
    </tr>
     <tr>
		  <td rowspan="2" class="categoria">Fecha cita:</td>
		  <td align="left"><font size="1">Desde: (dd/mm/aaaa)</font></td>
		  <td align="left" colspan="2"><font size="1">Hasta: (dd/mm/aaaa)</font></td>
		  </tr>
		  <tr>
		  <td  class="dato" >
	      <input name="fecE" type="text" id="fecE"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fecE?>" size="10" maxlength="10" readonly="" />
	      <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecE',document.forms[0].fecE.value)" />
          </td>
     	  <td class="dato" colspan="2" >
          <input name="fecE2" type="text" id="fecE2"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fecE2?>" size="10" maxlength="10" readonly="" />
          <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecE2',document.forms[0].fecE2.value)" />
	</tr>
	 <!-- <tr>
           <td  class="categoria">Banco :</td>
           <td  class="dato" colspan="3">
             <SELECT id="banco" name="banco"  <?php if ($_SESSION['banco']) echo "disabled";?> >
				      <option value="<?php if ($_SESSION['banco']) echo $banco?>"><?php if ($_SESSION['banco']) echo $listarBancos2[1];?></option>
			        <?php for($i=0;$i<count($listarBancos);$i+=3){  ?>
	                   <option value="<?php echo $listarBancos[$i]; ?>"><?php echo $listarBancos[$i+1]?></option>
	                <?php } ?>
			 </SELECT>
          </td>
</tr>-->
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
  <legend>Listado Resumen Citas por Banco</legend>
  <TABLE class="dato" border="0" width="900" align="center">
  <tr>
  				<td colspan="23" align="right">
			  			<a class="vinculo" target="_blank" onClick="abrir('reportes/pdfCuadroResCitasxBanco.php?tipo=<? echo$tipoBen;?>&fechaD=<? echo$fechaD;?>&fechaH=<? echo$fechaH; ?>&banco=<? echo$banco;?>');" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
						</a>
				    	<a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
			      </td>
             </tr>

		   <TR class="cabeceraI">
		   <TH colspan="7"><? echo "Citas por Banco"?></TH>
     	   </TR>
     	   <?
         	  //if ($tipoBen)  echo "<TR class='cabeceraI'><TH colspan='6'>".$tipoBen."</TH></tr>";

		      if (($fechaD) and ($fechaH))
		   	  {

		   	  	echo "<TR class='cabeceraI'><TH colspan='7'>Desde el ".$fechaD.' hasta el '.$fechaH."</TH></tr>";
		   	  }
		   	  elseif (($fechaD) and !($fechaH))
		   	  {
		   	  		echo "<TR class='cabeceraI'><TH colspan='7'>Desde el ".$fechaD."</TH></tr>";
		   	  }
		   	  elseif (!($fechaD) and ($fechaH))
			  {
			  		echo "<TR class='cabeceraI'><TH colspan='7'>Hasta el ".$fechaH."</TH></tr>";
			  }
		   ?>
		   <TR class="cabeceraI">
		    <TH rowspan="2">Banco</TH>
		    <TH colspan="5">Beneficiarios</TH>
		    <TH rowspan="2">Total</TH>
		  </tr>
		  <tr class="cabeceraI">
		    <TH title="Asistieron">Asistieron</TH>
		    <TH title="No asistieron"><font size="1">No asistieron</font></TH>
			<TH title="Pendientes"><font size="1">Pendientes por asistir</font></TH>
			<TH title="Pendientes"><font size="1">Total Citas</font></TH>
			<TH title="Sin Cita"><font size="1">Sin cita</font></TH>
	   </TR>
<?php
          	$asistieron=0;
			$vencidas=0;
		    $pendiente=0;
			$sincita=0;

          $contArt = 0;
	      for($i=0;$i<count($listarCitasBanco);$i+=$nroCampos)
	      {
          	  $color = (!$indC)?'datosimpar':'datospar';
              $indC = !$indC;
              $contArt ++;
     ?>
      <tr class="<?php echo $color ?>">
		    <TD align="left"><?php echo $listarCitasBanco[$i+1];    ?></TD>
		    <TD align="center"><?php echo  ($listarCitasBanco[$i+2]==0)?"":$listarCitasBanco[$i+2]?></TD>
		    <TD align="center"><?php echo  ($listarCitasBanco[$i+3]==0)?"":$listarCitasBanco[$i+3]?></TD>
		    <TD align="center"><?php echo  ($listarCitasBanco[$i+4]==0)?"":$listarCitasBanco[$i+4]?></TD>
		    <?   $totalF=$listarCitasBanco[$i+2];
		         $totalF+=$listarCitasBanco[$i+3];
		         $totalF+=$listarCitasBanco[$i+4];
		    ?>
            <TD align="center" class="cabeceraI"><?php echo $totalF; ?></TD>
            <TD align="center"><?php echo  ($listarCitasBanco[$i+5]==0)?"":$listarCitasBanco[$i+5]; $cita1=$listarCitasBanco[$i+5]; ?></TD>
<?php

            $asistieron+=$listarCitasBanco[$i+2];
			$vencidas+=$listarCitasBanco[$i+3];
		    $pendiente+=$listarCitasBanco[$i+4];
			$sincita+=$listarCitasBanco[$i+5];

			$reales = $totalF + $cita1;

			echo '<TD align="center" class="cabeceraI">'.$reales.'</TD>';
			echo '</TR>';
 }
?>
<tr class="cabecera">
<TH width="60%" align="right">TOTALES&nbsp;</TH>
<td align="center" title="Asistentes"><?php echo $asistieron;   $_SESSION['realasis']=$asistieron;?></td>
<td align="center" title="Vencidas"><?php echo $vencidas;     $_SESSION['realven']=$vencidas;?></td>
<td align="center" title="Pendientes"><?php echo $pendiente;     $_SESSION['realpen']= $pendiente;?></td>
<?php $totalS = $asistieron + $vencidas + $pendiente;?>
<td align="center" title="Total citas"><?php echo $totalS;     $_SESSION['totalS']= $totalS;?></td>
<td align="center" title="Sin cita"><?php echo $sincita;   $_SESSION['realsinc']=$sincita + $sincitac; ?></td>
<?php $total=$asistieron + $vencidas + $pendiente + $sincita;   $_SESSION['totaltotal']=$total;?>
<td align="center" title="Total Citas"><?php echo $total?></td>
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