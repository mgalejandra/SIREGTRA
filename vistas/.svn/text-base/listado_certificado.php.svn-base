<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/certificado.php');
require('../modelos/asignacion.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,6,7,8,11,18,22,23,24,25);
	validaAcceso($permitidos,$dir);

  $indBusq 	= $_POST['indBusq'];
  $fec=$_POST['fec'];
  $fec2=$_POST['fec2'];

  $numcerveh= $_POST['numcerveh'];
  $sercarveh= $_POST['sercarveh'];
  $codpro	= $_POST['codpro'];
  $nomcomp	= $_POST['nomcomp'];
  $numfac1veh=$_POST['numfac1veh'];
  $pgActual = $_POST['pagina'];

  $numlotveh= $_POST['numlotveh'];
  $codmar	= $_POST['codmar'];
  $desmarveh= $_POST['desmar'];
  $codmodveh= $_POST['codmodveh'];
  $desmodveh= $_POST['desmodveh'];
  $codserveh= $_POST['codserveh'];
  $desserveh= $_POST['desserveh'];
  $tipo= $_POST['tipo'];

$objCertificado = new certificado();
$objAsignacion = new asignacion();

if($indBusq==2){

  	$numcerveh	= null;
  	$sercarveh	= null;
  	$codpro		= null;
  	$nomcomp	= null;
  	$numfac1veh	= null;
  	$fec=NULL;
  	$fec2 =NULL;

	$numlotveh 	= null;
  	$codmarveh	= null;
  	$desmarveh  = null;
  	$codmodveh	= null;
  	$desmodveh	= null;
  	$codserveh	= null;
  	$desserveh	= null;
}

$_SESSION['numcerveh_'] = $numcerveh;
$_SESSION['sercarveh_'] = $sercarveh;
$_SESSION['codpro_']	= $codpro;
$_SESSION['nomcomp_']   = $nomcomp;
$_SESSION['numfac1veh_']= $numfac1veh;

$_SESSION['numlotveh_']	= $numlotveh;
$_SESSION['codmarveh_']	= $codmarveh;
$_SESSION['desmarveh_']	= $desmarveh;
$_SESSION['codmodveh_']	= $codmodveh;
$_SESSION['desmodveh_']	= $desmodveh;
$_SESSION['codserveh_']	= $codserveh;
$_SESSION['desserveh_']	= $desserveh;

$nroFilas = 15;
$nroColum = 18;
$nroCampos = 5;

//echo $tipo;
$contArt = $objCertificado->contarCertificado('',$numcerveh,$sercarveh,$codpro,$nomcomp,$numfac1veh,$numlotveh,$codmar,$codmodveh,$codserveh,$tipo,'','',$_SESSION['numeDepa'],$fec,$fec2);

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


$listarcertificado=$objCertificado->listarCertificados('',$numcerveh,$sercarveh,$codpro,$nomcomp,$numfac1veh,$numlotveh,$codmar,$codmodveh,$codserveh,$offset,$tipo,'','',$_SESSION['numeDepa'],$fec,$fec2);
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
function popup(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=600,height=600');");
	}

	function exel(URL) {
		  day = new Date();
		  id = day.getTime();
		  eval("page" + id +
		  	   " = window.open('reportes/xlsListarBeneficiariosExp.php?rif=<?php echo$rif;?>&tipoben=<?php echo$tipoben;?>&nombre=<?php echo$nombre;?>&banco=<?php echo$banco;?>&fec=<?php echo$fec;?>&fec2=<?php echo$fec2;?>&a=<?php echo '0';?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

	}


</script>
  </head>
  <body class="pagina">
   <TABLE class="completo">
    <TR>
     <TD class="banner"></TD>
    </TR>
    <TR>
     <TD >
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
     <table  align="center" >
          <tr>
           <td  class="categoria">N° de Certificado:</td>
           <td align="left" colspan="2">
			<input name="numcerveh" type="text" id="numcerveh"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $_SESSION['numcerveh_']?>" maxlength="8" />
		   </td>
           <td  class="categoria" title="Serial de carrocería">Serial:</td>
           <td align="left" colspan="2">
             <input name="sercarveh" type="text" id="sercarveh" value="<?echo $_SESSION['sercarveh_']?>" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="18" />
          </td>
          <td  class="categoria" title="Código del Beneficiario (N° RIF/Pasaporte)">Cod. Ben:</td>
            <td align="left" colspan="2">
             <input name="codpro" type="text" id="codpro" value="<?echo $_SESSION['codpro_']?>" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="10" />
          </td>
          </tr>
          <tr>
           <td  class="categoria">Beneficiario:</td>
           <td align="left" colspan="2">
             <input name="nomcomp" type="text" id="nomcomp" value="<?echo $_SESSION['nomcomp_']?>" onblur="javascript:this.value=this.value.toUpperCase()" size="20" />
          </td>
           <td  class="categoria" >Factura:</td>
           <td align="left" colspan="2">
             <input name="numfac1veh" type="text" id="numfac1veh" value="<?echo $_SESSION['numfac1veh_']?>" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="15" />
          </td>
          
          

<!--/////////////////////////////////////////////////////////////////////////////////////////////////////-->

           <td  class="categoria">Marca:</td>
           <td align="left">
			<input name="codmar" type="hidden" id="codmar"  value="<?echo $_SESSION['codmarveh_']?>" />
	        <input name="desmar" type="text" id="desmar"  value="<?echo $_SESSION['desmarveh_']?>"  readonly=""/>
	         </td>
	         <td align="left">
	        <input name="marca"  type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
		  </td>
		   </tr>
		   <tr>
           <td  class="categoria">Modelo:</td>
           <td align="left">
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?echo $_SESSION['codmodveh_']?>" />
             <input name="desmodveh" type="text" id="modveh" value="<?echo$_SESSION['desmodveh_']?>" size="20" maxlength="15" readonly=""/>
             </td>
	         <td align="left">
             <input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." />
          </td>
           <td  class="categoria">Serie:</td>
           <td >
             <input name="codserveh" type="hidden" id="codserveh" value="<?echo$_SESSION['codserveh_']?>" />
             <input name="desserveh" type="text" id="serveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $_SESSION['desserveh_'];?>" readonly=""/>
             </td>
	         <td align="left">
             <input name="serie" type="button" id="serie" onclick="catalogo('cat_serie.php');" value="..." />
           </td>

          <td  class="categoria">N° Lote:</td>
          <td align="left">
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/>
             </td>
	         <td align="left">
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
          </td>
              <tr>
           <td valign="top" class="categoria" > Desde: </td>
               <td  class="dato" >
	               <input name="fec" type="text" id="fec"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fec?>" size="10" maxlength="10" readonly="" />
	               <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec',document.forms[0].fec.value)" />
               </td>
               <td class="categoria" > Hasta: </td>
               <td class="dato" >
                   <input name="fec2" type="text" id="fec2"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fec2?>" size="10" maxlength="10" readonly="" />
                   <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec2',document.forms[0].fec2.value)" />
               </td>

          </tr>

<!--/////////////////////////////////////////////////////////////////////////////////////////////////////-->

          </tr>
           <tr>
          	<td  class="categoria">Tipo:</td>
	        <td >Activos
		        <input type="radio" name="tipo" id="tipo"  value="A" <?php if ($tipo!='E') echo "checked= 'true'"?>/>
		        Anulados
		        <input type="radio" name="tipo" id="tipo"  value="E" <?php if ($tipo=='E') echo "checked= 'true'"?>/>
	        </td>
          </tr>
          <tr>
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
  <legend>Lista de Certificados &nbsp; <?php if ($tipo=='E') echo 'Anulados'; ?> &nbsp; <?php echo 'Total: '.$contArt?>
  </legend>
 <!-- <input  type="button" id="articulo" onClick="abrir('reportes/listCertificados.php?idsercarveh=<?php echo$sercarveh;?>&numcerveh=<?php echo$numcerveh;?>&codpro=<?php echo$codpro;?>&nomcomp=<?php echo$nomcomp;?>&numfac1veh=<?php echo$numfac1veh;?>&numlotveh=<?php echo$numlotveh;?>&codmar=<?php echo$codmar;?>&codmodveh=<?php echo$codmodveh;?>&codserveh=<?php echo$codserveh;?>&desserveh=<?php echo$desserveh;?>&desmodveh=<?php echo$desmodveh;?>&desmarveh=<?php echo$desmarveh;?>&tip=<?php echo $tipo;?>');" value="PDF" />-->
    <table width="90%" align="center" class="detalles">
    <tr><td colspan="12" align="right"><a class="vinculo" target="_blank" onClick="abrir('reportes/listCertificados.php?idsercarveh=<?php echo$sercarveh;?>&numcerveh=<?php echo$numcerveh;?>&codpro=<?php echo$codpro;?>&nomcomp=<?php echo$nomcomp;?>&numfac1veh=<?php echo$numfac1veh;?>&numlotveh=<?php echo$numlotveh;?>&codmar=<?php echo$codmar;?>&codmodveh=<?php echo$codmodveh;?>&codserveh=<?php echo$codserveh;?>&desserveh=<?php echo$desserveh;?>&desmodveh=<?php echo$desmodveh;?>&desmarveh=<?php echo$desmarveh;?>&tip=<?php echo $tipo;?>');" />
    <IMG title="PDF" src="botones/pdf.png" height="15" ></a>
    </td></tr>
             <tr>
              <td class="cabecera">N°</td>
              <td class="cabecera">N° Certificado</td>
              <td class="cabecera">Serial Carrocería Vehiculo</td>
              <td class="cabecera">Cód. Beneficiario</td>
              <td class="cabecera">Beneficiario</td>
              <td class="cabecera">N° de Factura</td>
              <td class="cabecera">Fecha de Factura</td>
              <td class="cabecera">Fecha Registro</td>
              <td class="cabecera">Seguro</td>
              <td class="cabecera">Reserva de Dominio </td>
              <td class="cabecera"> B </td>
              <td class="cabecera"> I </td>
              <td class="cabecera"> I2 </td>
              <td class="cabecera"> I3 </td>
             </tr>
<?php
        for($i=0;$i<count($listarcertificado);$i+=$nroColum){
          if($listarcertificado[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
             }
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?echo $i/$nroColum+$offset+1?></td>
               <td align="center"><?php echo $listarcertificado[$i];?></td>
               <td><?php echo $listarcertificado[$i+2];?> </td>
               <td><?php echo $listarcertificado[$i+3];?></td>
               <td><?php echo $listarcertificado[$i+4];?></td>
               <td align="center"><?php echo $listarcertificado[$i+6];?> </td>
               <td align="center"><?php echo $listarcertificado[$i+7];?> </td>
               <td align="center"><?php echo $listarcertificado[$i+14];?></td>
               <td align="center"><?php echo $listarcertificado[$i+8]?></td>
               <td><?php echo $listarcertificado[$i+11]?></td>
          <td><div align="center">
               <a class="vinculo" href="reg_certificado.php?id_certificado=<?php echo $listarcertificado[$i+1]?>&tip=<?php echo $tipo; ?>">
	              <img src="botones/buscar.png" width="25" height="25">
	          </a></div></td>
	           <td><div align="center">
               <a class="vinculo" href="reportes/pdfcertificado.php?numcerveh=<?php echo $listarcertificado[$i]?>&tip=<?php echo $tipo; ?>">
	              <img src="botones/printer_48.png" width="25" height="25">
	          </a></div></td>
	          <? $buscoTipo = $objAsignacion->f_excepciones2($listarcertificado[$i+3],'',-1);

	             if ($buscoTipo){
	          ?>
	            <td><div align="center">
               <a class="vinculo" href="reportes/pdfcertificado_caja.php?numcerveh=<?php echo $listarcertificado[$i]?>&tip=<?php echo $tipo; ?>">
	              <img src="botones/printer_48.png" width="25" height="25">
	          </a></div></td>
	          <? } else {?>
	           <td><div align="center">
               <a class="vinculo" href="reportes/pdfcertificado_tec.php?numcerveh=<?php echo $listarcertificado[$i]?>&tip=<?php echo $tipo; ?>">
	              <img src="botones/printer_48.png" width="25" height="25">
	          </a></div></td>        
	          
			<? }?>
		
	           <td><div align="center">
               <a class="vinculo" href="reportes/pdfcertificado_tec2.php?numcerveh=<?php echo $listarcertificado[$i]?>&tip=<?php echo $tipo; ?>">
	              <img src="botones/printer_48.png" width="25" height="25">
	          </a></div></td>        
	          
			<? }?>

              </tr>
<?php      ?>
  <tr><td colspan=9> </td></tr>
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
     <div align="center" >
        <input type="button" onclick="window.close()" value="Cerrar Ventana"/>
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