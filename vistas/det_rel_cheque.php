<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/relacionC.php');

$objCheque = new relacionC();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';

for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,6,7);
validaAcceso($permitidos,$dir);

$ban=0;
$codi=$_GET['codi'];

$indReg=$_POST['indReg'];

$codproc=$_POST['codproc'];
$sercarveh=$_POST['sercarveh'];
$indErr = false;

	$numCheque	= $_POST['numCheque'];
  	$id_banco	= $_POST['id_banco'];
	$fecCheque	= $_POST['fecCheque'];
	$monto		= $_POST['monto'];
  	$beneficario= $_POST['beneficario'];
  	$idAsig		= $_POST['idAsig'];

////  Prepara tabla de bancos a partir de DB para ser usado en <select>

$tabBanco = $objCheque->listarBancos();
$dimBanco = sizeof($tabBanco);

if ($_GET['id'])
{
	$id_remision = $_GET['id'];
	$_SESSION['remi']=$id_remision;
}
elseif($codi)
	$id_remision = $_SESSION['remi'];
else $listarCheques=null;

if ($codi)
{
	$ban = 1;
	$buscarC = $objCheque->buscarCheque($codi);
	$idBanco=$objCheque->buscarBanco($buscarC[4]);
}

$datos = array($numCheque,$fecCheque,$monto,$id_banco,$idAsig,$id_remision);

if ($id_remision or $indReg!=2)  {
	$i=0;
	$listarCheques = $objCheque->listarChequeRem($id_remision);
}

if ($indReg==1 or $indReg==2){
	$i=0;

	if($indErr)	f_alert("Reporte de validación:".$msj);
	elseif($indReg==1){
		    $registro = $objCheque->registrarCheque(&$datos);
			$msj = ($registro)?"Cheque Registrado":"Cheque NO Registrado";
			f_alert($msj);

			if ($registro){
				$listarCheques = $objCheque->listarChequeRem($id_remision);
				echo "<SCRIPT>window.document.form1.submit();</SCRIPT>";
}

	}
	elseif($indReg==2){
			$modificar = $objCheque->modificarCheque($codi,$datos);

			if ($modificar){
			     f_alert("Registro modificado");
			     $listarCheques = $objCheque->listarChequeRem($id_remision);
				 echo "<SCRIPT>window.document.form1.submit();</SCRIPT>";
			}else f_alert("No se pudo registrar modificación");
	}
}

if ($indReg==3)  {
  	$beneficario=null;
  	$id_banco	= null;
	//$listarCheques	= null;
	$numCheque	= null;
	$fecCheque	= null;
	$monto		= null;
  	$idAsig		= null;
}

if (!$id_remision) {$listarCheques=null; $ban=0;}

$nroFilas = 15;
$nroCampos = 14;

$contRemision = $objCheque->contarChexRem($id_remision);

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

?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>

function validarCaract(dato){

if (dato==3)  {
  	document.form1.sercarveh.value	= null;
  	document.form1.beneficario.value=null;
  	document.form1.id_banco.value	= null;
	document.form1.numCheque.value	= null;
	document.form1.fecCheque.value	= null;
	document.form1.monto.value		= null;
  	document.form1.idAsig.value		= null;
}
else
{
	if (document.form1.sercarveh.value.length==0){
	    alert("Debe seleccionar serial de carrocería \ndel vehículo");
	    document.form1.sercarveh.focus();
	    return (false);
	}

   if (document.form1.id_banco.value.length==0){
	    alert("Debe seleccionar banco origen del cheque");
	    document.form1.id_banco.focus();
	    return (false);
	}

	if (document.form1.numCheque.value.length<8){
	    alert("Debe indicar número del cheque\n (debe ser menor o igual a 8 dígitos)");
	    document.form1.numCheque.focus();
	    return (false);
	    }

	if (document.form1.fecCheque.value.length==0){
	    alert("Debe indicar fecha del cheque");
	    document.form1.fecCheque.focus();
	    return (false);
	    }

	if (document.form1.monto.value.length==0){
	    alert("Debe indicar monto del cheque");
	    document.form1.monto.focus();
	    return (false);

	}
}
document.form1.indReg.value = dato;
document.form1.submit();
}

function popup(URL) {
   day = new Date();
   id = day.getTime();
   eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1000,height=800');");
}

function avanzaPg(){
	pg = parseInt(window.document.registro.pagina.value);
	window.document.registro.pagina.value = pg+1;
	window.document.form1.submit();
}

function enviaPg(pag){
	window.document.form1.pagina.value = pag;
	window.document.form1.submit();
}

function regresaPg(){
	pg = parseInt(window.document.form1.pagina.value);
	window.document.form1.pagina.value = pg-1;
	window.document.form1.submit();
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

<!--  Contenido Principal  -->

  <form id="form1" name="form1" method="post" action="">
  <table class="formulario" width="900" border="1" align="center" >
  <tr><td colspan="8" class="cabecera">Datos del Veh&iacute;culo / Beneficiario</td></tr>
  <tr><td class="categoria">Serial&nbsp;Veh&iacute;culo:</td>
      <td class="dato" colspan="2"> <input name="sercarveh" type="text" id="sercarveh" size="18" maxlength="18"
         		value="<? if ($ban==1) echo $buscarC[$i+7];?>" readonly=""/>
         <input type="button" onclick="popup('cat_asignacion.php');" value="..."/></td>
      <td class="categoria">Beneficiario:&nbsp;</td>
      <td class="dato" colspan="2">
	        <input name="beneficario" type="text" id="beneficario"
	        		value="<? if ($ban==1) echo $buscarC[$i+9]." ".$buscarC[$i+10]." ".$buscarC[$i+11]." ".$buscarC[$i+12]; ?>"
	        		size="40" maxlength="20" readonly="" />
	        <input type="hidden" name="idAsig" id="idAsig"
	        		value="<? if ($ban==1) echo $buscarC[$i+5]; ?>">
	        <input type="hidden" name="codproa" id="codproa">
        </td>
        </tr>
  <tr> <td colspan="8" class="cabecera"><?=($codi)?"Modificar Cheques":"Registrar Cheques"?></td></tr>
  <tr><td class="categoria"> Banco:&nbsp;</td>
       <td align="left" colspan="2">
			 <SELECT name="id_banco">
				<OPTION value=""></OPTION>
			    <?for($k=0;$k<$dimBanco;$k+=2) { ?>
					<OPTION value="<? echo $tabBanco[$k]?>"
					<?=($tabBanco[$k]==$idBanco[0])?"selected='true'":"";?>><?=$tabBanco[$k+1]?>
					</OPTION>
			    <? } ?>
			 </SELECT></td>
	   <td class="categoria" title="N° del cheque">N° Cheque:&nbsp;</td>
	   <td class="dato" colspan="2">
	       <input name="numCheque" type ="text" id="numCheque"
	       value="<? if ($ban==1) echo $buscarC[$i+2];?>" size="8" maxlength="8"
	       onkeypress="return acessoNumerico(event)"/>
      </td></tr>


<tr>
         <td class="categoria"colspan="1">Fecha Cheque:&nbsp;</td>
        <td class="dato" colspan="2">
         <input name="fecCheque" type ="text" id="fecCheque"
         		value="<? if ($ban==1) echo $buscarC[$i+1];?>"
         		size="8" maxlength="8" date_format="dd/MM/yy"
         		onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)"  readonly=""/>
          <img src="../images/cal.gif" width="16" height="18"
          		onClick="show_calendar('document.forms[0].fecCheque',document.forms[0].fecCheque.value)" />
        </td>
        <td class="categoria"colspan="1">Monto&nbsp;pago:&nbsp;</td>
        <td class="dato" colspan="2">
	       <input name="monto" type ="text" id="monto" onkeypress="return acessoDecimal(event)"
	       		  value="<? if ($ban==1) echo $buscarC[$i+3];?>" size="10"
	       		  maxlength="10"   onblur="javascript:this.value=this.value.toUpperCase()" />
       </td>
</tr>
<tr>
    <td height="22" colspan="8">
       <div align="center">
          <input type="hidden" name="indReg" >
            <input name="numcerveh" type ="hidden" id="numcerveh"  />
              <input type="hidden" name="codproc" id="codproc" >
           <?php if (!$codi and  ($_SESSION['tipoUsuario'] == 1 or $_SESSION['tipoUsuario'] == 4)) { ?>
           <input  type="button" onclick="validarCaract('1'); return false" value="Registrar" />
            <input  type="button"  onclick="validarCaract('3'); return false" value="Limpiar" />
           <?php } if ($codi and ($_SESSION['tipoUsuario'] == 1 or $_SESSION['tipoUsuario'] == 4)) { ?>
           <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Modificar" />
           <?php } ?>
           <input name="listar" type="button" id="listar" onclick="window.location.href='listado_relacion_cheques.php?id_caso=2'" value="Remisiones" />
       </div>
    </td>
</tr>
</table>
<?include ('ctrl_pagina2.php')?>
    </form>
<!--  FIN Contenido Principal         -->
       </DIV>
      </DIV>
     </TD>
    </TR>

        <tr><td><fieldset class="form">
  <legend>Lista de Cheques asociados a la Remisión N° <? echo $id_remision; ?></legend>

    <table width="90%" align="center" class="detalles">
         <tr><td colspan="9" align="right"><a class="vinculo" target="_blank" onClick="abrir('reportes/pdfRemisionCheque.php?rem=<?php echo $id_remision; ?>');" />
  <IMG title="PDF" src="botones/pdf.png" height="15" ></a>
 </td></tr>
   <tr>
              <td class="cabecera" rowspan="2">ID</td>
              <td class="cabecera" colspan="4">Cheque</td>
              <td class="cabecera" colspan="2">Beneficiario</td>
              <td class="cabecera" rowspan="2">Serial Veh&iacute;culo</td>
              <td class="cabecera" rowspan="2">M</td>
<?if($id_caso==2)echo '<td class="cabecera" colspan="2" rowspan="2"></td>'?>
            </tr>
            <tr>
              <td class="cabecera">N°</td>
              <td class="cabecera">Monto</td>
              <td class="cabecera">Fecha</td>
              <td class="cabecera" title="Banco del cheque">Banco</td>
              <td class="cabecera">C&eacute;dula</td>
              <td class="cabecera">Nombre</td>
            </tr>
<?
		$totalC=0;
		$j=0;
        for($i=0;$i<count($listarCheques);$i+=$nroCampos){
        	$j=$j+1;
        	$k = $i / $nroCampos + $offset;
        	$totalC=$totalC+$listarCheques[$i+3];
          if($listarCheques[$i]){
                 $color = (!$indC)?'datosimpar':'datospar';
                 $indC = !$indC;
?>
              <tr class="<?=$color ?>">

               <td align="center"><? echo $j; ?></td>
               <td align="center" id="nroPago<?=$k?>" name="nroPago[<?=$k?>]"><?=$listarCheques[$i+2]?>
               </td>
               <td align="right">&nbsp;<?=formatomonto($listarCheques[$i+3]); ?>&nbsp;</td>
               <td align="center"><?=$listarCheques[$i+1]?></td>
               <td align="center"><?=$listarCheques[$i+4]?></td>
               <td align="center"><?=$listarCheques[$i+8]?></td>
               <td align="center"><?=$listarCheques[$i+9]." ".$listarCheques[$i+10]." ".$listarCheques[$i+11]." ".$listarCheques[$i+12]?></td>
               <td align="center"><?=$listarCheques[$i+7]?></td>
               <td><a href='det_rel_cheque.php?codi=<? echo $listarCheques[$i+13]; ?>'> <img src='imagenes/edit_f2.png' width='20' height='20'></a></td>
              </tr>
<?  }
    }
?>
   <tr><td colspan="3" class="categoria"> <?='Total: '.formatomonto($totalC)?></td></tr>
    </table>
</fieldset></td></tr>
    <TR>
     <TD class="piedepagina">
      <?php include("piedepagina.php") ?>
     </TD>
    </TR>
   </TABLE>
  </body>
</html>