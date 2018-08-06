<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/certificado.php');
require('../modelos/beneficiario.php');
require('../modelos/pago.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(9,10);
	validaAcceso($permitidos,$dir);

$objPago = new pago();
$objCertificado = new certificado();
$objBeneficiario = new beneficiario();

$listarBancos=$objPago->listarBancos(3);
//$dimBanco = sizeof($tab_banco);

  $id_memo 	= $_POST['memo'];
  $rif 	= $_POST['rif'];
  $desde	= $_POST['fec'];
  $hasta	= $_POST['fec2'];
  $banco = $_POST['banco'];
  $indBusq = $_POST['indBusq'];
  $pgActual=$_POST['pagina'];

$nroFilas = 10;
$nroCampos = 7;

if ($indBusq=='2')
{
  $id_memo 	= null;
  $rif 	= null;
  $desde = null;
  $hasta = null;
  $banco = null;
}

$contRemision = $objBeneficiario->contarMemo($id_memo,$desde,$hasta,$rif,$_SESSION['idBanco']);

$cantidad = $contRemision[0];


$cantPaginas = ceil($cantidad/($nroFilas));

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

$listarRemision=$objBeneficiario->listarMemo1($id_memo,$desde,$hasta,$rif,$_SESSION['idBanco'],$offset);


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

function popup(URL) {
  day = new Date();
  id = day.getTime();
  eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=600,height=600');");
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
  <legend>Criterios de B&uacute;squeda
  </legend>
     <table id="tabla1" name="tabla1" align="center" >
          <tr>
		   <td class="categoria">&nbsp;&nbsp;&nbsp;&nbsp;N&deg; de Memo:&nbsp;</td>
           <td>
			<input name="memo" type="text" id="memo" value=""/>
		  </td>
		   <td class="categoria">&nbsp;&nbsp;&nbsp;&nbsp;Rif / Ci :&nbsp;</td>
		   <td>
			<input name="rif" type="text" id="rif" value=""/>
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
  <legend>Lista de Remisiones de Expedientes
  </legend>
    <table id="tabla2" name="tabla2" width="70%" align="center" class="detalles">
  <!--  <tr><td colspan="8" align="right"><a class="vinculo" target="_blank" onClick="imprimir()" />
  <IMG title="PDF" src="botones/pdf.png" height="15" ></a>
 </td></tr>-->
            <!--<tr>
              <td class="cabecera">Memo</td>
              <td class="cabecera">Fecha</td>
              <td class="cabecera">Observaci&oacute;n</td>
              <td class="cabecera">Banco</td>
              <td class="cabecera">Cantidad</td>
              <td class="cabecera">I</td>
              <td class="cabecera">E</td>
            <tr>-->



             <tr>
              <td class="cabecera" rowspan="2">Memo</td>
              <!--<td class="cabecera">Fecha</td>-->
              <td class="cabecera" rowspan="2">Observaci&oacute;n</td>
              <td class="cabecera" rowspan="2">Banco</td>
              <td class="cabecera" rowspan="2">Cantidad</td>
              <td  class="cabecera" colspan="2">Creación</td>
              <td class="cabecera" rowspan="2">I</td>
              <td class="cabecera" rowspan="2">E</td>
            </tr>
             <tr><td class="cabeceraI" width="5%">Fecha</td>
              <td class="cabeceraI" width="10%">Usuario</td></tr>

<?php
		$montoTotal= 0;
		$contRemision=count($listarRemision)/$nroCampos;

		for($i=0;$i<count($listarRemision);$i+=$nroCampos){
?>
              <tr id="dep<?=$i?>" class="datosimpar">
               <td align="center"><?= $listarRemision[$i+0]; ?></td>
			  <!-- <td align="center"><?= $listarRemision[$i+2]?></td>-->
               <td align="center"><?= $listarRemision[$i+4]?></td>
               <? $nombreB = $objPago->listarBancos(4,$listarRemision[$i+3]); ?>
               <td align="center"><?= $nombreB[1]; ?></td>
                <td align="center"><?= $listarRemision[$i+5]?></td>
               <td align="center"><?= $listarRemision[$i+2]?></td>
               <td align="center"><?= $listarRemision[$i+6]?></td>
		       <td>
	               <div align="center">
                      <a class="vinculo" href="" target="_blank" onClick="popup('reportes/pdfMemorif.php?id=<?php echo $listarRemision[$i]?>');return false;">
	                   <img src="botones/printer_48.png" width="20" height="20">
	                  </a>
	              </div>
	          </td>
		        <td>
	               <div align="center">
                      <a class="vinculo" href="" target="_blank" onClick="popup('reportes/xlsListarExpediente.php?id=<?php echo $listarRemision[$i+0]?>');return false;">
	                   <img src="botones/table_48.png" width="20" height="20">
	                  </a>
	              </div>
	          </td>
		       </tr>
		<?}?>
   <tr>
   <td colspan="3"> <?= 'Total: '.$cantidad.' remisiones'?></td>
   </tr>
    </table>
</fieldset>

<!-- //////////////////////////////////////////////////////////////////////////////////////////////-->

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
       <input type="hidden" name="idInv" id="idInv"/>


       <input type="hidden" name="pagina" value="<?php echo $pgActual ?>"/>

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