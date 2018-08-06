<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/certificado.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,11,24);
	validaAcceso($permitidos,$dir);

  $indBusq 	= $_POST['indBusq'];

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
  $taller = $_POST['codtal'];
  $tt = $_POST['todo_taller'];


$objCertificado = new certificado();

$nroFilas = 15;

if ($taller or $tt)
	$nroCampos = 20;
else
	$nroCampos = 18;

if($indBusq==2){

  	$numcerveh	= null;
  	$sercarveh	= null;
  	$codpro		= null;
  	$nomcomp	= null;
  	$numfac1veh	= null;

	$numlotveh 	= null;
  	$codmarveh	= null;
  	$desmarveh  = null;
  	$codmodveh	= null;
  	$desmodveh	= null;
  	$codserveh	= null;
  	$desserveh	= null;
  	$taller = null;
  	$tt = null;
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
$_SESSION['taller_']	= $taller;

$contArt = $objCertificado->contarCertificado('',$numcerveh,$sercarveh,$codpro,$nomcomp,$numfac1veh,$numlotveh,$codmar,$codmodveh,$codserveh,'',$taller,$tt,$_SESSION['numeDepa']);

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

$listarcertificado=$objCertificado->listarCertificados('',$numcerveh,$sercarveh,$codpro,$nomcomp,$numfac1veh,$numlotveh,$codmar,$codmodveh,$codserveh,$offset,'',$taller,$tt,$_SESSION['numeDepa']);
?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
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
  <legend>Criterios de B&uacute;squeda
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
          </tr>
          <tr> <td class="categoria">Taller:</td>
          <td class="dato" colspan="2">
             <input name="codtal" type="hidden" id="codtal" value="" />
             <input name="destaller" type="text" id="destaller" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $registro['destaller'];?>" readonly=""/>
             <input name="taller" type="button" id="taller" onclick="catalogo('cat_taller.php');" value="..." />
             </td><td colspan="2">Todos los talleres <input type="radio" name="todo_taller" id="todo_taller"  value="T" /></td></tr>
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
  <legend>Lista de Certificados: <?php echo $contArt ?>
  </legend>
  <!--<input  type="button" id="articulo" onClick="abrir('reportes/listCertificados.php?idsercarveh=<?php echo$sercarveh;?>&numcerveh=<?php echo$numcerveh;?>&codpro=<?php echo$codpro;?>&nomcomp=<?php echo$nomcomp;?>&numfac1veh=<?php echo$numfac1veh;?>&numlotveh=<?php echo$numlotveh;?>&codmar=<?php echo$codmar;?>&codmodveh=<?php echo$codmodveh;?>&codserveh=<?php echo$codserveh;?>&desserveh=<?php echo$desserveh;?>&desmodveh=<?php echo$desmodveh;?>&desmarveh=<?php echo$desmarveh;?>');" value="PDF" />-->
    <table width="90%" align="center" class="detalles">
      <tr><td colspan="12" align="right"><a class="vinculo" target="_blank" onClick="abrir('reportes/listCertificados.php?idsercarveh=<?php echo$sercarveh;?>&numcerveh=<?php echo$numcerveh;?>&codpro=<?php echo$codpro;?>&nomcomp=<?php echo$nomcomp;?>&numfac1veh=<?php echo$numfac1veh;?>&numlotveh=<?php echo$numlotveh;?>&codmar=<?php echo$codmar;?>&codmodveh=<?php echo$codmodveh;?>&codserveh=<?php echo$codserveh;?>&desserveh=<?php echo$desserveh;?>&desmodveh=<?php echo$desmodveh;?>&desmarveh=<?php echo$desmarveh;?>&taller=<?php echo $taller;?>&tt=<?php echo $tt;?>');" />
    <IMG title="PDF" src="botones/pdf.png" height="15" ></a>
    </td></tr>

             <tr>
              <td class="cabecera">N° de Certificado</td>
              <td class="cabecera">Serial Carrocería Vehiculo</td>
              <td class="cabecera">Cód. Beneficiario</td>
              <td class="cabecera">Beneficiario</td>
              <td class="cabecera">N° de Factura</td>
              <td class="cabecera">Fecha de Factura</td>
              <td class="cabecera">Fecha Registro</td>
              <td class="cabecera">Seguro</td>
              <td class="cabecera">Reserva de Dominio </td>
              <?php if ($taller or $tt) {?>
              <td class="cabecera">Taller - Falla</td>
              <?php } ?>
              <td class="cabecera"> B </td>
              <td class="cabecera"> I </td>
             </tr>
<?php
        for($i=0;$i<count($listarcertificado);$i+=$nroCampos){
          if($listarcertificado[$i]){
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
               <td align="center"><?php echo $listarcertificado[$i];?></td>
               <td><?php echo $listarcertificado[$i+2];?> </td>
               <td align="center"><?php echo $listarcertificado[$i+3];?></td>
               <td><?php echo $listarcertificado[$i+4];?></td>
               <td align="center"><?php echo $listarcertificado[$i+6];?> </td>
               <td align="center"><?php echo $listarcertificado[$i+7];?> </td>
               <td align="center"><?php echo $listarcertificado[$i+14];?></td>
               <td align="center"><?php echo $listarcertificado[$i+8]?></td>
               <td><?php echo $listarcertificado[$i+11]?></td>
              <?php if ($taller or $tt) {?>
              <td><?php echo $listarcertificado[$i+18]." - ".$listarcertificado[$i+19]; ?></td>
              <?php } ?>
               <td><div align="center">
               <a class="vinculo" href="reg_certificado.php?id_certificado=<?php echo $listarcertificado[$i+1]?>">
	              <img src="botones/buscar.png" width="20" height="20">
	          </a></div></td>
	           <td><div align="center">
               <a class="vinculo" href="reportes/pdfcertificado_tec.php?numcerveh=<?php echo $listarcertificado[$i]?>">
	              <img src="botones/printer_48.png" width="20" height="20">
	          </a></div></td>
              </tr>
<?php     }
        }
?>
  <tr><td colspan=9> <?php echo 'Total: '.$contArt?></td></tr>
    </table>
 </fieldset>
  </legend>

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