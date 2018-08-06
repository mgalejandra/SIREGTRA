<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/reportes.php');
require('../modelos/pago.php');
require('../modelos/banco.php');
require('../modelos/lotes.php');
require('../modelos/factura.php');

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,4,10,11,15,18,22,25);
validaAcceso($permitidos,$dir);


$indBusq = $_POST['indBusq'];

$objFactura = new factura();
$objReporte= new reportes();
$objPago = new pago();
$objBanco 		= new banco();
$objLotes 		= new lotes();
$nroFilas = 5;

  $indBusq 	= $_POST['indBusq'];
  $pgActual = $_POST['pagina'];

/*if ($_POST['numlotveh'])
  $numlotveh= $_POST['numlotveh'];
else
  $numlotveh= 15;*/

  $fechaD = $_POST['fechaD'];
  $fechaH = $_POST['fechaH'];
  $status = $_POST['estatus'];
  $banco = $_POST['banco'];

if($indBusq==2){

  	//$numlotveh 	= null;
  	$fechaD = null;
  	$fechaH = null;
  	$condicion=null;
  	$banco = null;
  	$status = null;
}
$listarEstatus=$objFactura->listarEstatus();
$listarEstatusBanco = $objReporte->resumenEstatusCred($fechaD,$fechaH,$banco,$status); //,$numlotveh);

$_SESSION['listarEstatusBanco']=$listarEstatusBanco;

$listarBancos=$objPago->listarBancos(4);

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
  <legend>Criterios de B&uacute;squeda
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
<!--<tr>
<td  class="categoria">Banco:</td>
      <td align="left" colspan="2">
      <SELECT id="banco" name="banco"  <?php if ($_SESSION['banco']) echo "disabled";?> >
	   <option value="<?php if ($_SESSION['banco']) echo $banco?>"><?php if ($_SESSION['banco']) echo $listarBancos2[1];?></option>
	        <?php for($i=0;$i<count($listarBancos);$i+=3){  ?>
	              <option value="<?php echo $listarBancos[$i]; ?>"><?php echo $listarBancos[$i+1]?></option>
	        <?php } ?>
	  </SELECT>
      </td>
<td></td>
<tr>-->
  <!-- <tr>
           <td  class="categoria">Estatus:</td>
           <td align="left" colspan="2">
             <SELECT id="estatus" name="estatus"  <?php if ($_SESSION['estatus']) echo "disabled";?> >
                      <option value="<?php if ($_SESSION['estatus']) echo $banco?>">
                      <?php
                      if ($_SESSION['estatus']=='4') echo 'Aprobado';
                      if ($_SESSION['estatus']=='16') echo 'Negado';
                      if ($_SESSION['estatus']=='17') echo 'Diferido';
                      if ($_SESSION['estatus']=='3') echo 'A la Espera de Documentos';
                      if ($_SESSION['estatus']=='30') echo 'Devuelto por Documentacion Incompleta';
                      if ($_SESSION['estatus']=='31') echo 'Imposible verificar constancia';
                      if ($_SESSION['estatus']=='32') echo 'Devuelto por cambio de Garantia';
                      if ($_SESSION['estatus']=='33') echo 'Cambio de Garantia Procesada';
                      ?>
                      </option>
				      <option value="4">Aprobado</option>
				      <option value="16">Negado</option>
				      <option value="17">Diferido</option>
				      <option value="2">Credito en analisis Bancario</option>
				      <option value="3">A la Espera de Documentos</option>
				      <option value="30">Devuelto por Documentacion Incompleta</option>
				      <option value="31">Imposible verificar constancia</option>
				      <option value="32">Devuelto por cambio de Garantia</option>
				      <option value="33">Cambio de Garantia Procesada</option>
			 </SELECT>

          </td>
		   </tr>-->
<!--<tr>
          <td  class="categoria">N° Lote:</td>
          <td align="left">
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
         </td>
</tr>-->
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
  <legend>Listado Resumen Estatus Crédito por Banco
  </legend>
  <table width="60%" align="center" class="detalles">
  <tr><td colspan="11" align="right">
			  			<a class="vinculo" target="_blank" onClick="abrir('reportes/pdflistResumenEstatusCredBanco.php?banco=<?php echo$banco;?>&fechaD=<?php echo$fechaD;?>&fechaH=<?php echo$fechaH;?>&lote=<?php echo$numlotveh;?>&status=<?php echo$status;?>');" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a></td></tr>
          <tr  class="cabecera">
             <th width="30%" rowspan="2">Banco</th>
             <th width="15%" colspan="9">Estatus</th>
             <th width="15%" rowspan="2">Total</th>
          </tr>
            <tr  class="cabecera">
             <th width="10%">Crédito en Análisis Bancario</th>
             <th width="10%">Crédito Aprobado</th>
             <th width="10%">Crédito Rechazado</th>
             <th width="10%">Crédito Diferido</th>
             <th width="10%">A la Espera de Documentos</th>
             <th width="10%">Devuelto por Documentación Incompleta</th>
             <th width="10%">Imposible verificar constancia</th>
             <th width="10%">Devuelto por cambio de Garantía</th>
             <th width="10%">Cambio de Garantía Procesada</th>

             </tr>
<?php

	$banco[0] = "BANCO INDUSTRIAL DE VENEZUELA, C.A";
    $banco[1] = "BANCO DE VENEZUELA S.A.C.A";
    $banco[2] = "BANCO DEL TESORO";
    $banco[3] = "BANCO BICENTENARIO BANCO UNIVERSAL, C.A.";
    $banco[4] = "BANCO DE DESARROLLO ECONOMICO Y SOCIAL DE VENEZUELA";
    $banco[5] = "BANCO DEL PUEBLO";

		for($i=0;$i<count($banco);$i+=1){
        	for($j=0;$j<count($listarEstatusBanco);$j+=9){
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
              <td align="center"  ><?php echo $banco[$i]?></td>
              <td align="center" title="Análisis Bancario"><?php echo ($listarEstatusBanco[$i][$j+8]==0)?"":$listarEstatusBanco[$i][$j+8]?></td>
              <td align="center" title="Aprobado"><?php echo ($listarEstatusBanco[$i][$j]==0)?"":$listarEstatusBanco[$i][$j]?></td>
              <td align="center" title="Negado"><?php echo ($listarEstatusBanco[$i][$j+1]==0)?"":$listarEstatusBanco[$i][$j+1]?></td>
              <td align="center" title="Diferido"><?php echo ($listarEstatusBanco[$i][$j+2]==0)?"":$listarEstatusBanco[$i][$j+2]?></td>
              <td align="center" title="A la Espera de Documentos"><?php echo ($listarEstatusBanco[$i][$j+3]==0)?"":$listarEstatusBanco[$i][$j+3]?></td>
              <td align="center" title="Devuelto por Documentacion Incompleta"><?php echo ($listarEstatusBanco[$i][$j+4]==0)?"":$listarEstatusBanco[$i][$j+4]?></td>
              <td align="center" title="Imposible verificar constancia"><?php echo ($listarEstatusBanco[$i][$j+5]==0)?"":$listarEstatusBanco[$i][$j+5]?></td>
              <td align="center" title="Devuelto por cambio de Garantia"><?php echo ($listarEstatusBanco[$i][$j+6]==0)?"":$listarEstatusBanco[$i][$j+6]?></td>
              <td align="center" title="Cambio de Garantia Procesada"><?php echo ($listarEstatusBanco[$i][$j+7]==0)?"":$listarEstatusBanco[$i][$j+7]?></td>

<?php $tbanco=$listarEstatusBanco[$i][$j+8]+$listarEstatusBanco[$i][$j]+$listarEstatusBanco[$i][$j+1]+$listarEstatusBanco[$i][$j+2]+ $listarEstatusBanco[$i][$j+3]+$listarEstatusBanco[$i][$j+4]+$listarEstatusBanco[$i][$j+5]+ $listarEstatusBanco[$i][$j+6]+$listarEstatusBanco[$i][$j+7];?>
			  <td align="center" title="Total"><?php echo $tbanco?></td>
<?php

$analisis=$analisis+$listarEstatusBanco[$i][$j+8];
$aprobado=$aprobado+$listarEstatusBanco[$i][$j];
$negado=$negado+$listarEstatusBanco[$i][$j+1];
$diferido=$diferido+$listarEstatusBanco[$i][$j+2];
$esperadoc=$esperadoc+$listarEstatusBanco[$i][$j+3];
$docincomp=$docincomp+$listarEstatusBanco[$i][$j+4];
$impvercons=$impvercons+$listarEstatusBanco[$i][$j+5];
$devcamgar=$devcamgar+$listarEstatusBanco[$i][$j+6];
$cangarproc=$cangarproc+$listarEstatusBanco[$i][$j+7];


?>

<?php }
		}
		 $colorc ='datospar';

		 ?>
</tr>

<tr class="cabecera">
<th width="15%">Total</th>
<td align="center" title="Análisis Bancario"><?php echo $analisis;    $_SESSION['analisis']=$analisis;?></td>
<td align="center" title="Aprobado"><?php echo $aprobado;    $_SESSION['aprobado']=$aprobado;?></td>
<td align="center" title="Rechazado"><?php echo $negado;     $_SESSION['negado']=$negado;?></td>
<td align="center" title="Diferido"><?php echo $diferido;     $_SESSION['diferido']= $diferido;?></td>
<td align="center" title="A la Espera de Documentos"><?php echo $esperadoc;    $_SESSION['esperadoc']=$esperadoc; ?></td>
<td align="center" title="Devuelto por Documentacion Incompleta"><?php echo $docincomp;    $_SESSION['docincomp']=$docincomp;?></td>
<td align="center" title="Imposible verificar constancia"><?php echo $impvercons;     $_SESSION['impvercons']= $impvercons;?></td>
<td align="center" title="Devuelto por cambio de Garantia"><?php echo $devcamgar;    $_SESSION['devcamgar']=$devcamgar; ?></td>
<td align="center" title="Cambio de Garantia Procesad"><?php echo $cangarproc;    $_SESSION['cangarproc']=$cangarproc;?></td>
<?php $total=$analisis+$aprobado+$negado+$diferido+$esperadoc+$docincomp+$impvercons+$devcamgar+$cangarproc;   $_SESSION['totaltotal']=$total;?>
<td align="center" title="Total Exp. Estatus Crédito"><?php echo $total?></td>
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