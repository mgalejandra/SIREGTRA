<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/deposito.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(1,2,3,4,5,6,7,8);
	validaAcceso($permitidos,$dir);

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

$objDeposito = new deposito();

////  Prepara tabla de Categorías a partir de DB para ser usado en <select>

$tab_banco = $objDeposito->listarBancos(1);
$dimBanco = sizeof($tab_banco);

$nroFilas = 15;
$nroCampos = 7;

$contDeposito = $objDeposito->contarDepositos($id_deposito,$desde,$hasta,$id_banco); //$pago,$sercarveh,$fec,$fec2,$codpro,$nombre

$cantPaginas = ceil($contDeposito/($nroFilas));
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
								//$id_pago,$sercarveh,$desde,$hasta,$codpro,$nombre,$offset
$listarDeposito=$objDeposito->listarDepositos($id_deposito,$desde,$hasta,$id_banco,$offset);

if($indBusq==2){
	$_SESSION['idBanco']= null;
	$_SESSION['desde_'] = null;
	$_SESSION['hasta_']	= null;
}

if($indBusq==3){
	$ctrl=$objDeposito->anularDeposito($id_deposito,&$msj);
	f_alert($msj);
}

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
  <legend>Criterios de Busqueda
  </legend>
     <table id="tabla1" name="tabla1" align="center" >
          <tr>
			 <td class="categoria">Banco :</td>
			 <td align="left">
			 <SELECT name="id_banco" id="id_banco">
			    <OPTION value=""></OPTION>
			    <?for($i=0;$i<$dimBanco;$i+=3) { ?>
					<OPTION value="<?echo $tab_banco[$i]?>"
					<? if($tab_banco[$i]==$_SESSION['idBanco']) echo 'selected="true"'?>>
						<?echo $tab_banco[$i+1];?></OPTION>
			    <? } ?>
			 </SELECT>
		     </td>

           <td class="categoria">&nbsp;&nbsp;&nbsp;&nbsp;N° Planilla:&nbsp;</td>
           <td>
			<input name="pago" type="text" id="pago" value="" onkeypress="return acessoNumerico(event)"/>
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
            <input type="submit" value="Imprimir" onclick="imprimir()"/>
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
  <legend>Lista de Depositos
  </legend>
    <table id="tabla2" name="tabla2" width="90%" align="center" class="detalles">
            <tr>
              <td class="cabecera" rowspan="2">ID</td>
              <td class="cabecera" colspan="2">Banco</td>
              <td class="cabecera" colspan="3">Depósito</td>
              <td class="cabecera" rowspan="2" align="center">Fecha Reg.</td>
              <td class="cabecera" colspan="2" rowspan="2"></td>
            </tr>
            <tr>
              <td class="cabecera" align="center">Nombre</td>
              <td class="cabecera" align="center">N° Cuenta</td>
              <td class="cabecera" align="left">N° Planilla</td>
              <td class="cabecera">Monto</td>
              <td class="cabecera" align="center">Fecha</td>
            </tr>
<?php
		$montoTotal= 0;
		for($i=0;$i<count($listarDeposito);$i+=$nroCampos){
?>
              <tr id="dep<?=$i?>" class="datosimpar">
               <td align="center"><?= str_pad($listarDeposito[$i],strlen($listarDeposito[$i])+1,"0",STR_PAD_LEFT)?></td>
               <td align="center"><?= $listarDeposito[$i+4]?></td>
               <td align="center"><?= $listarDeposito[$i+5]?></td>
               <td align="center"><?= str_pad($listarDeposito[$i+1],strlen($listarDeposito[$i+1])+1,"0",STR_PAD_LEFT)?></td>
               <td align="right"  width="10%"><?= formatomonto($listarDeposito[$i+2])?>&nbsp;</td>
               <td align="center" width="8%"><?= $listarDeposito[$i+3]?></td>
               <td align="center" width="8%"><?= $listarDeposito[$i+6]?></td>
               <td align="center" width="2%"><div title="Editar depósito">
	              	<a class="vinculo" href="reg_deposito.php?id=<?= $listarDeposito[$i]?>">
		            <img src="botones/buscar.png" width="24" height="24"></a></div></td>
		       <td align="center" width="2%"><div title="Eliminar depósito"></div>
	     			<img src="imagenes/notice-alert.png" onclick="eliminar('<?=$i/$nroCampos+2?>','<?=$listarDeposito[$i]?>',3)" width="24" height="24"/>
	    	   </td>
              </tr>
		<?}?>
   <tr>
   <td colspan=3> <?= 'Total: '.$contDeposito.' depósitos'?></td>
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
       <input type="hidden" name="id_deposito" id="id_deposito"/>
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
