<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/relacionC.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(1,2,3,4,5,6,7,8,13,17);
	validaAcceso($permitidos,$dir);

$objRelacionC = new relacionC();

/*$tab_banco = $objRelacionC->listarBancos(1);
$dimBanco = sizeof($tab_banco);*/

  $id_remision 	= $_POST['id_remision'];
  $cheque 	= $_POST['cheque'];
  $desde	= $_POST['fec'];
  $hasta	= $_POST['fec2'];

$nroFilas = 15;
if ($cheque)
	$nroCampos = 3;
else
	$nroCampos = 2;

$contRemision = $objRelacionC->contarRC($id_remision,$desde,$hasta,$cheque);

$cantPaginas = ceil($contRemision/($nroFilas));
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

$listarRemision=$objRelacionC->listarRC($id_remision,$desde,$hasta,$cheque,$offset);

/*
  $indBusq  = $_POST['indBusq'];

  $pago		= $_POST['pago'];
  $desde	= $_POST['fec'];
  $hasta	= $_POST['fec2'];
  $codpro 	= $_POST['codpro'];
  $pgActual = $_POST['pagina'];

  $id_deposito 	= $_POST['id_deposito'];
  $id_banco 	= $_POST['id_banco'];

  $_SESSION['idBanco'] 	= $id_banco;
  $_SESSION['desde_'] 	= $desde;
  $_SESSION['hasta_']	= $hasta;



////  Prepara tabla de Categorías a partir de DB para ser usado en <select>



if($indBusq==2){
	$_SESSION['idBanco']= null;
	$_SESSION['desde_'] = null;
	$_SESSION['hasta_']	= null;
}*/

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

function enviarDeposito(dato1,dato2,dato3,dato4,dato5,dato6){
 document.form1.id_pago.value = dato1;
 document.form1.nro_pago.value = dato2;
 document.form1.monto.value 		= dato3;
 document.form1.fecha_cheque.value 	= dato4;
 document.form1.status_pago.value 	= dato5;
 document.form1.banco_descrip.value = dato6;
 document.form1.submit();
}

 function imprimir() {
  day = new Date();
  id = day.getTime();
  eval("page" + id +
  	   " = window.open('reportes/listDepositos.php','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
  }

function strlen(strVar)
{
return(strVar.length)
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
//////////////////////////////////////////////////////////////////////////////////////////////////
function eliminar(dato,iDep,ind){
	var tabla = document.getElementById('tabla2');
    var prue=dato;
    iRow = parseInt(dato);

    var cont = parseInt(document.getElementById('contiTem').value);
	cont = cont - 1;
//    alert(dato+' '+iDep+' '+ind);
    tabla.deleteRow(iRow);
	document.registro.contiTem.value = cont;
	document.registro.indBusq.value = ind;
	document.registro.id_deposito.value = iDep;
	window.document.registro.submit();
}
//////////////////////////////////////////////////////////////////////////////////////////////////

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
  <legend>Criterios de B&uacute;squeda</legend>
     <table id="tabla1" name="tabla1" align="center" >
          <tr>
		   <td class="categoria">&nbsp;&nbsp;&nbsp;&nbsp;N&deg; Remisi&oacute;n:&nbsp;</td>
           <td>
			<input name="id_remision" type="text" id="id_remision" value=""/>
		  </td>
		   <td class="categoria">&nbsp;&nbsp;&nbsp;&nbsp;N&deg; Cheque:&nbsp;</td>
		   <td>
			<input name="cheque" type="text" id="cheque" value=""/>
		  </td>
           <td valign="center" class="categoria" >&nbsp;&nbsp;&nbsp;&nbsp;Desde:&nbsp;</td>
               <td  class="dato" >
	               <input name="fec" type="text" id="fec"  onblur="javascript:this.value=this.value.toUpperCase()" value="" size="10" maxlength="10" readonly="" />
	               <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec',document.forms[0].fec.value)" />
               </td>
               <td  valign="center" class="categoria" >&nbsp;&nbsp;&nbsp;&nbsp;Hasta:&nbsp;</td>
               <td class="dato" >
                   <input name="fec2" type="text" id="fec2"  onblur="javascript:this.value=this.value.toUpperCase()" value="" size="10" maxlength="10" readonly="" />
                   <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec2',document.forms[0].fec2.value)" />
               </td>
          </tr>
          <tr>
            <td align="center" colspan="10">
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" value="Limpiar" onclick="enviar(2)"/>
           <!-- <input type="submit" value="Imprimir" onclick="imprimir()"/>-->
			</td>
			</tr>
			<tr><td>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden" name="indReg">
		    <INPUT type="hidden" name="contiTem" id="contiTem">
           </td></tr>
  </table>
  </fieldset>

 <fieldset class="form">
  <legend>Lista de Remisiones de Cheques</legend>
    <table id="tabla2" name="tabla2" width="70%" align="center" class="detalles">
  <!--  <tr><td colspan="8" align="right"><a class="vinculo" target="_blank" onClick="imprimir()" />
  <IMG title="PDF" src="botones/pdf.png" height="15" ></a>
 </td></tr>-->
            <tr>
              <td class="cabecera">ID</td>
              <td class="cabecera">Fecha</td>
              <? if ($cheque){?>
              <td class="cabecera">Cheque</td>
              <? }?>
              <td class="cabecera">Detalle</td>
             <!-- <td class="cabecera">Eliminar</td>-->
            <tr>
<?php
		$montoTotal= 0;
		$contRemision=count($listarRemision)/$nroCampos;

		for($i=0;$i<count($listarRemision);$i+=$nroCampos){
?>
              <tr id="dep<?=$i?>" class="datosimpar">
               <td align="center"><?= str_pad($listarRemision[$i],strlen($listarRemision[$i])+1,"0",STR_PAD_LEFT)?></td>
			   <td align="center"><?= $listarRemision[$i+1]?></td>
			   <? if ($cheque){?>
               <td align="center"><?= $listarRemision[$i+2]?></td>
               <? }?>
               <td align="center" width="2%"><div title="Asociar Cheques">
	              	<a class="vinculo" href="det_rel_cheque.php?id=<?= $listarRemision[$i]?>">
		            <img src="botones/buscar.png" width="24" height="24"></a></div></td>
		       </tr>
		<?}?>
   <tr>
   <td colspan=3> <?= 'Total: '.$contRemision.' remisiones'?></td>
   </tr>
    </table>
</fieldset>

<!-- //////////////////////////////////////////////////////////////////////////////////////////////-->

<BR>
 <div align="center">
       <?php if($pgActual>1){?>
         <img src="imagenes/atras.png" width="20" height="15" class="vinculo" onclick="regresaPg()">
       <? }
         for($j=$pgIni;$j<=$pgFin;$j++){
             $claseVinc = ($pgActual==$j)?'vinculoAzul':'vinculo';
             ?>
          <a class="<?= $claseVinc ?>" onclick="enviaPg(<?= $j ?>)"><?= $j ?></a>
       <?php
         }
         if($pgActual<$pgFin){
       ?>
        <img src="imagenes/adelante.png" width="20" height="15"  class="vinculo" onclick="avanzaPg()">
       <?php } ?>
       <BR>
       <input type="hidden" name="id_remision" id="id_remision"/>
       <input type="hidden" name="pagina" value="<?= $pgActual ?>"/>

       <br />
     </div>
<!-- //////////////////////////////////////////////////////////////////////////////////////////////-->

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