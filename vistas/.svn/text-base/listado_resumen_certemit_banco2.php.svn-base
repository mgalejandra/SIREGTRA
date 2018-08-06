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
$permitidos = array(1,2,4,10,15,18);
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

if ($_POST['numlotveh'])
  $numlotveh= $_POST['numlotveh'];
else
  $numlotveh= 14;

  //$codmar	= $_POST['codmar'];
  //$codmodveh= $_POST['codmodveh'];
  $condicion = $_POST['cond'];
  $fechaD = $_POST['fechaD'];
  $fechaH = $_POST['fechaH'];
  $status = $_POST['estatus'];
  //$banco = $_POST['banco'];

if($indBusq==2){

  	//$numlotveh 	= null;
  	//$codmarveh	= null;
  	//$codmodveh	= null;
  	//$fechaF = null;
  	$fechaD = null;
  	$fechaH = null;
  	$condicion=null;
  	//$banco = null;
}
$listarEstatus=$objFactura->listarEstatus();
$listarCertEmi2 = $objReporte->resumenCertEmit2($fechaD,$fechaH,'CREDITO',$status,$numlotveh);
$listarCertEmi3 = $objReporte->resumenCertEmit2($fechaD,$fechaH,'CONTADO',$status,$numlotveh);
//($numlotveh,$fechaD,$fechaH,$condicion,$codmar,$codmodveh,$banco);


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
<tr>

<td  class="categoria">Estatus:</td>
	        <td class="dato" colspan="6" >
               <SELECT id="estatus" name="estatus">
				 <option value=""></option>
			    <?php for($i=0;$i<count($listarEstatus);$i+=4){  ?>
	               <option value="<?php echo $listarEstatus[$i+1]; ?>"><?php echo $listarEstatus[$i+1]?></option>
	           <?php } ?>
			 </SELECT>
	        </td>
<tr>
<tr>
          <td  class="categoria">N° Lote:</td>
          <td align="left">
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
         </td>
</tr>
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
  <legend>Listado Resumen Marca CHERY -<?php echo " Lote ".$numlotveh; if($fechaD and !$fechaH) echo " Fecha: ".$fechaD;?><?php if($fechaD and $fechaH) echo " Fecha: ".$fechaD."-".$fechaH;?><?php if($status) echo " Estatus: ".$status;?><?php if($condicion=='COMPLETO') echo " 100% CREDITO"; elseif(($condicion<>'COMPLETO') and ($condicion)) echo " Condición: ".$condicion;?></legend>
  <table width="60%" align="center" class="detalles">
  <tr><td colspan="7" align="right">
			  			<a class="vinculo" target="_blank" onClick="abrir('reportes/pdflistResumenCertEmitBanco.php?cond=<?php echo$condicion;?>&fechaD=<?php echo$fechaD;?>&fechaH=<?php echo$fechaH;?>&lote=<?php echo$numlotveh;?>&estatus=<?php echo$status;?>');" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a></td></tr>
          <tr  class="cabecera">
             <th width="30%" rowspan="2">Banco</th>
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
<?php
//echo 'aqui'.count($listarCertEmi2);
		for($i=0;$i<count($listarCertEmi2);$i+=7){
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
              <td align="center"  ><?php echo $listarCertEmi2[$i+1]?></td>
              <td align="center" title="QQ3"><?php echo $listarCertEmi2[$i+2]?></td>
              <td align="center" title="x1"><?php echo $listarCertEmi2[$i+3]?></td>
              <td align="center" title="tiggo"><?php echo $listarCertEmi2[$i+4]?></td>
              <td align="center" title="tiger 4*2"><?php echo $listarCertEmi2[$i+5]?></td>
              <td align="center" title="tiger 4*4"><?php echo $listarCertEmi2[$i+6]?></td>
			  <td align="center" title="tiger 4*4"><?php echo $tbanco?></td>
<?php }?>
</tr>
 <tr class="<?php echo $color ?>">
              <td align="center"  ><?php echo $listarCertEmi3[$i+1]?></td>
              <td align="center" title="QQ3"><?php echo $listarCertEmi3[$i+2]?></td>
              <td align="center" title="x1"><?php echo $listarCertEmi3[$i+3]?></td>
              <td align="center" title="tiggo"><?php echo $listarCertEmi3[$i+4]?></td>
              <td align="center" title="tiger 4*2"><?php echo $listarCertEmi3[$i+5]?></td>
              <td align="center" title="tiger 4*4"><?php echo $listarCertEmi3[$i+6]?></td>
			  <td align="center" title="tiger 4*4"><?php echo $tbanco?></td>
</tr>

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