<?php
session_start();

require('../modelos/conexion.php');

require('../controlador/funciones.php');
require('../modelos/citas.php');
require('../modelos/beneficiario.php');
require('../modelos/pago.php');
require('../modelos/banco.php');

$objCitas= new citas();
$objBeneficiario=new beneficiario();
$objPago = new pago();
$objBanco = new banco();

 //$tipoBen = $_GET['tipo'];
 $desde  = $_GET['fechaD'];
 $hasta = $_GET['fechaH'];

 //echo "Desde: ".$desde." hasta".$hasta;

 //$banco   = $_GET['banco'];



$fecha=date('d/m/Y');
$dia=date("d");
$mes=date("m");
$ano=date("Y");

$nroCampos = 6;
$listarCitas = $objCitas->cuadroResumenCitasMin($tipoBen,$desde,$hasta,$banco);
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

 <!--  <legend>Criterios de B&uacute;squeda
  </legend>
<table align="center">
<tbody>
<tr>
<td rowspan="2"  class="categoria">Fecha Estatus:</td>
<td colspan="2" align="left"><font size="1">Desde: (dd/mm/aaaa)</font></td>
<td></td>
<td colspan="3" align="left"><font size="1">Hasta: (dd/mm/aaaa)</font></td>
</tr>
<tr>
<td colspan="2" align="left"><input id="fechaD" name="fechaD" type="text" size="10" maxlength="10" value="<?php echo $fechaD;?>" onKeyUp="javascript: mascara(this,'/',rray(2,2,4),true)" date_format="dd/MM/yy" readonly="" />
        <img src="../images/cal.gif" width="16" height="16" onclick="show_calendar('document.forms[0].fechaD',document.forms[0].fechaD.value)" /></td>
<td></td>
<td colspan="3" align="left"><input id="fechaH" name="fechaH" type="text" size="10" maxlength="10" value="<?php echo $fechaH;?>" onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)" date_format="dd/MM/yyyy" readonly="" />
        <img src="../images/cal.gif" width="16" height="16" onclick="show_calendar('document.forms[0].fechaH',document.forms[0].fechaH.value)" /></td>
</tr>

<td colspan="7" align="center">  <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden"  name="indReg" >
		    <INPUT type="hidden" name="idUsu" ></td>
</tr>
</tbody>
</table>
   </fieldset> -->

<fieldset class="form">
  <legend> Cuadro Resumen Citas Minco  </legend>
  <TABLE class="dato" border="0" width="900" align="center">

   <td colspan="23" align="right">
        	<a class="vinculo" target="_blank" onClick="abrir('reportes/pdfCuadroResCitasMin.php?fec=<?php echo $fec?>&fec2=<?php echo $fec2?>&a=<?php echo '1'?>');" />
			<IMG title="PDF" src="botones/pdf.png" height="15" ></a>
        </td>
		   <TR class="cabecera">
		    <TH colspan="1">CITAS OTORGADAS POR SISTEMA</TH>
		    <TH colspan="1">EXPEDIENTES RECIBIDOS POR CITAS OTORGADAS</TH>
		    <TH colspan="1">SOLICITANTES PENDIENTES POR ASISTIR</TH>
		    <TH colspan="2">DIFERENCIA</TH>
     	   </TR>
           <TR class="cabecera">
		    <TH width="10%"></TH>
		    <TH width="10%"></TH>
		    <TH width="10%"></TH>
		    <TH width="5%">NO ASISTIERON</TH>
		    <TH width="5%">OBSERVACION</TH>
          </tr>

<?php

$totalC = $listarCitas[1]+$listarCitas[2]+$listarCitas[3];
$obs='Personas no asistieron en la fecha y hora asignada en la hoja de cita';

 ?>

           <tr><td colspan="27" align="right"> </td></tr>
           <tr class="datospar">
    	   <th align="center" width="5%" ><?php echo FormatoMonto($totalC,0)?> </th>
    	   <th align="center" width="5%" ><?php echo ($listarCitas[1]==0)?"":FormatoMonto($listarCitas[1],0)?> </th>
    	   <th align="center" width="5%" ><?php echo ($listarCitas[2]==0)?"":FormatoMonto($listarCitas[2],0)?> </th>
    	   <th align="center" width="5%" ><?php echo ($listarCitas[3]==0)?"":FormatoMonto($listarCitas[3],0)?> </th>
    	   <th align="center" width="5%" ><?php echo $obs ?> </th>

           <TR>
		    <TH width="10%">       </TH>
		    <TH width="10%"> </TH>
		    <TH width="10%"> </TH>
		    <TH width="5%"> </TH>
		    <TH width="5%"> </TH>
          </tr>

 <TR  </TR>
</table>
<TABLE class="dato" border="0" width="900" align="center">
		   <TR class="cabecera">
		   <TH colspan="3"><? echo "RESUMEN POBLACIÓN ATENDIDA"?></TH>
     	   </TR>
           <TR class="cabecera">
		    <TH width="5%">CITAS OTORGADAS</TH>
		    <TH width="5%">SOLICITANTES PENDIENTES POR CITA</TH>
		    <TH width="5%">TOTAL POBLACION ATENDIDA</TH>
          </tr>

           <tr><td colspan="27" align="right"> </td></tr>
           <tr class="datospar">
    	   <th align="center" width="5%" ><?php echo FormatoMonto($totalC,0);?> </th>
    	   <th align="center" width="5%" ><?php echo ($listarCitas[4]==0)?"":FormatoMonto($listarCitas[4],0) + 0.001;?> </th>
    	   <th align="center" width="5%" ><?php echo ($listarCitas[4]==0)?"":FormatoMonto($listarCitas[4],0) + FormatoMonto($totalC,0) + 0.001;?> </th>
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