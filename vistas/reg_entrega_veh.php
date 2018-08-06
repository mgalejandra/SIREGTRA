<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/entrega.php');
require('../modelos/factura.php');
require('../modelos/acto.php');

function f_limpiar_SESSION () {
	$_SESSION['idAsig_']		= null;
	$_SESSION['beneficiario_'] 	= null;
	$_SESSION['sercarveh_']	= null;
	$_SESSION['PDI_']		= null;
	$_SESSION['gas_']		= null;
	$_SESSION['fecEntrega_']= null;
	$_SESSION['lugar_']		= null;
	$_SESSION['montoCredito_']	= null;
}

$obj = new entrega();
$objFactura = new factura();
$objActo = new acto();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,6,7,11,18,23);
validaAcceso($permitidos,$dir);

$ban=0;
$indReg=$_POST['indReg'];
$indReg1=$_POST['indReg1'];
$codproa=$_POST['codproa'];
$num=$_GET['num'];

$indErr = false;

$idAsig		 = $_POST['idAsig'];
$beneficario = $_POST['beneficario'];
$sercarveh	 = $_POST['sercarveh'];
$fec_entrega = $_POST['fecEntrega'];
$lugar		 = $_POST['lugar'];
$acto = $_POST['actveh'];
$desacto= $_POST['desacto'];

//f_alert($acto."".$desacto);

$_SESSION['idAsig_']	  = $_POST['idAsig'];
$_SESSION['beneficario_'] = $_POST['beneficario'];
$_SESSION['sercarveh_']	= $_POST['sercarveh'];
$_SESSION['fecEntrega_']= $_POST['fecEntrega'];
$_SESSION['lugar_']		= $_POST['lugar'];
$_SESSION['desacto_']=$_POST['desacto'];


if ($_GET['id']) $id_entrega = $_GET['id'];
if ($_GET['asig']) $id_asignacion = $_GET['asig'];
if ($_GET['va']) $va = $_GET['va'];

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

if ($id_entrega or $indReg!=2 or $id_asignacion)  {
	$ban=1;
	//echo 'entro';
	$listarEntrega = $obj->buscarEntrega($id_entrega,'','','','','',$id_asignacion);
	if ($listarEntrega)
    	$desActo = $objActo->buscarActoID($listarEntrega[10]);

    if ($desActo) $ban2=1;
}

if ($num){
  	  $listarFactura=$objFactura->reporteFactura($num);
  	  $listarEntrega = $obj->buscarEntrega('','','','','','',$id_asignacion);

  	  if (($ban==1) and ($listarEntrega))
  	   $acto1 = $listarEntrega[10];
  	  else
  	   $acto1 = $acto;

  	  //f_alert("Ahora tengo: ".$acto1);

      $data = array($listarEntrega[0],$listarFactura[11],$listarFactura[9],$fec_entrega,$lugar,$acto1,'V');
  	  $codproa=$listarFactura[13];
  	  $_SESSION['lugar_']=$listarEntrega[4];
 }else
      $data = array($id_entrega,$sercarveh,$idAsig,$fec_entrega,$lugar,$acto,'N');

if ($indReg==1 or $indReg==2){
	$ban=1;

  if($indErr)f_alert("Lista de errores:".$msj);
  else
	switch($indReg){
		case 1:	//	Registrar entrega
		    $registro = $obj->registrarEntrega($data, $id_entrega,'',$codproa,$num);
			$msj = ($registro)?"Entrega registrada con el N°: ".$id_entrega:"Entrega no pudo registrarse";
			break;

		case 2:	// Modificar entrega
		    $modificar = $obj->modificarEntrega($data,$num);
			$msj = ($modificar)?"Registro de entrega ha sido modificado":"Registro no pudo modificarse";
			break;
		}
	f_alert($msj);
	f_limpiar_SESSION();

	if ($registro or $modificar){
		 $ban1=1;

		if ($num or $id_asignacion)
		{
		 	if ($va=='N')
		 		echo "<SCRIPT>window.location.href='det_factura_suvinca.php?idfactura=$num&indReg=$indReg1&ban1=$ban1';</SCRIPT>";
		 	else
		 		echo "<SCRIPT>window.location.href='det_factura_suvincaC.php?idfactura=$num&indReg=$indReg1&ban1=$ban1';</SCRIPT>";
		 }
		 else
		   echo "<SCRIPT>window.location.href='listado_entregas.php';</SCRIPT>";
	}
}

if ((!$_GET['id']) and (!$_GET['asig'])) {
	$ban = 0;
	$listarEntrega = null;
	f_limpiar_SESSION();
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

function validarCampos(dato){

if (document.form1.sercarveh.value.length==0){
    alert("Debe seleccionar serial de carrocería \ndel vehículo a entregar");
    document.form1.sercarveh.focus();
    return (false);
    }

//if (document.form1.PDI.value==false){
//    alert(" Debe verificar si está lista la garantía de alistamiento \n del vehículo para la entrega");
//    document.form1.PDI.focus();
 //   return (false);
 //   }
//if (document.form1.gas.value==false){
//   alert(" Verificar si el vehículo tiene instalado \n sistema de combustión a gas para la entrega");
//    document.form1.gas.focus();
//    return (false);
 //   }

if (document.form1.fecEntrega.value.length==0){
    alert("Debe indicar fecha de entrega");
    document.form1.fecEntrega.focus();
    return (false);
    }
if (document.form1.lugar.value.length==0){
    alert("Debe seleccionar lugar de entrega");
    document.form1.lugar.focus();
    return (false);
    }
//if (document.form1.montoCredito.value.length==0){
//    alert ("Debe indicar el monto del crédito");
//    	document.form1.montoCredito.focus();
//	    return (false);
//    }

 document.form1.indReg.value = dato;

 if (dato==2)
 	document.form1.indReg1.value = 15;

 document.form1.submit();
}

function activarSW(sw)
{
	document.getElementById(sw).value=document.getElementById(sw).value = true;
//	alert(sw+" Activado")
}
function desactivarSW(sw)
{
	document.getElementById(sw).value=document.getElementById(sw).value = false;
//	alert(sw+" Desactivado")
}

function popup(URL) {
    day = new Date();
    id = day.getTime();
    eval("page" + id + " = window.open(URL,'URL','toolbar=0,scrollbars=yes,location=0,menubar=0,resizable=0,width=400,height=400');");
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
  <form id="form1" name="form1" method="post" action="">
  <table class="formulario" width="822" border="0" align="center" >
      <tr>
        <td colspan="11" class="cabecera"><?echo ($idsercarveh or $_GET['asig'])?"Modificar":"Registrar"?>&nbsp;Entrega  <?php if ($num) echo ' de la Factura Proforma N#'.$num;  ?></td>
      </tr>
     <tr>
        <td class="categoria">Serial&nbsp;carrocería:</td>
        <td class="dato" colspan="3">
         <input name="sercarveh" type="text" id="sercarveh" maxlength="18"
         		value="<?php if ($num) echo $listarFactura[11];?><?php  if($ban==1)  echo $listarEntrega[1]; else echo $_SESSION['sercarveh_']?>" readonly=""/>
         <?php if (!$num) if (!$idsercarveh) { ?>
         <td class="categoria"><input type="button" onclick="popup('cat_asignacion.php?id=3');" value="..."/></td>
         <?php } ?>
        </td>

         <td class="categoria">Beneficiario:</td>
         <td class="dato" colspan="5">
	        <input name="beneficario" type="text" id="beneficario"
	        		value="<?php if ($num) echo $listarFactura[12];?><?php if($ban==1) echo $listarEntrega[8];else echo $_SESSION['beneficiario_']?>" readonly="" maxlength="120" size="50"/>
	        <input type="hidden" name="idAsig" id="idAsig"
	        		value="<?php if($ban==1) echo $listarEntrega[2];else echo $_SESSION['idAsig_']?>">
         </td>
      </tr>
      <tr>

        <!--<td class="categoria" rowspan"2" colspan="3">Status&nbsp;entrega:</td>
        <td class="dato">
                <input id="PDI" type="checkbox" name="PDI" title="Chequeo de alistamiento de garantía"
                		value="<?if($ban==1)echo $listarEntrega[$i+5];else echo $_SESSION['PDI_']?>"
                			   <?if($_SESSION['PDI_'] or $ban==1 and $listarEntrega[$i+5])echo 'checked="checked"'?>
                				onclick="if(this.checked)activarSW('PDI')">PDI
                <br>
                <input id="gas" type="checkbox" name="gas" title="Sistema de combustión a gas natural (GNV)"
                		value="<?if($ban==1)echo $listarEntrega[$i+6];else echo $_SESSION['gas_']?>"
                			   <?if($_SESSION['gas_'] or $ban==1 and $listarEntrega[$i+6])echo 'checked="checked"'?>
                				onclick="if(this.checked)activarSW('gas')">GAS
        </td>
      <td class="categoria"></td>-->
       <td class="categoria">Fecha&nbsp;entrega:&nbsp;</td>
        <td class="dato" colspan="2">
         <input name="fecEntrega" type ="text" id="fecEntrega"
         		value="<?php if($ban==1 and $listarEntrega[3]!='01/01/1999') echo $listarEntrega[3];else echo $_SESSION['fecEntrega_']?>"
         		size="8" maxlength="10" date_format="dd/MM/yy"
         		onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)"  readonly=""/>
        </td>
<td class="dato"> <img src="../images/cal.gif" width="16" height="16"
          		onClick="show_calendar('document.forms[0].fecEntrega',document.forms[0].fecEntrega.value)"/></td>
        <td class="categoria" colspan="2">Lugar&nbsp;de&nbsp;entrega:</td>
			 <td class="dato">
			 <SELECT name="lugar" id="lugar">
			    <OPTION value=""></OPTION>
			    <OPTION value="Caracas" <?php if($ban==1 and $listarEntrega[4]=="Caracas"  /*xor $_SESSION['lugar_']=="Caracas"*/)echo"selected='true'";?>>Caracas</OPTION>
			    <OPTION value="Maracay" <?php if($ban==1 and $listarEntrega[4]=="Maracay"  /*xor $_SESSION['lugar_']=="Maracay"*/)echo"selected='true'"?>>Maracay</OPTION>
			    <OPTION value="Valencia"<?php if($ban==1 and $listarEntrega[4]=="Valencia" /*xor $_SESSION['lugar_']=="valencia"*/)echo"selected='true'"?>>Valencia</OPTION>
			    <OPTION value="Paraguana"<?php if($ban==1 and $listarEntrega[4]=="Paraguana" /*xor $_SESSION['lugar_']=="valencia"*/)echo"selected='true'"?>>Paraguana - Amuay</OPTION>
			 </SELECT>
		     </td>


		<td class="categoria">Acto:</td>
        <td class="dato" colspan="2">
         <input name="desacto" type="text" id="desacto" maxlength="18"
         		value="<?php  if (($num) and ($ban==0)) echo $listarEntrega[10]; if (($ban==1) and ($ban2==1)) echo $desActo[2]; /*else echo $_SESSION['desacto_']*/?>" readonly=""/>
        <input type="button" onclick="popup('cat_acto.php');" value="..."/>

        </td></tr>
	 <!--	<tr>
		<td class="categoria"colspan="3">Monto&nbsp;del&nbsp;crédito:</td>
		  <td  align="left"><input type="text" name="montoCredito" id="montoCredito" value="<?=($ban==1)?$listarEntrega[$i+5]:$_SESSION['montoCredito_'];?>"
		  		onkeypress="return acessoDecimal(event)" size="10" maxlength="10"/></td>
		</tr>-->


 <!--//////////////////////////////////////////////////////////////////////////////////-->

      <tr>
        <td colspan="11 align="center">
            <input type="hidden" name="indReg"/>
            <input type="hidden" name="indReg1" id="indReg1"/>
            <input type="hidden" name="codproa" id="codproa" >
            <input type="hidden" name="actveh" id="actveh"/>
            <?  if ((!$_GET['id']) and ($_GET['asig']) and ($ban2<>'1')) { ?>
            <input type="button" onclick="validarCampos(1); return false" value="Registrar"/>
            <? } if (($_GET['id'] or $_GET['asig'])  and ($ban2=='1') and ($_SESSION['tipoUsuario'] == 1 or $_SESSION['tipoUsuario'] == 4 or $_SESSION['tipoUsuario'] == 11 or $_SESSION['tipoUsuario'] == 23 or $_SESSION['tipoUsuario'] == 18)) { ?>
            <input  type="button" name="Modificar" id="Modificar" onclick="validarCampos(2); return false" value="Modificar"/>
            <? } ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_entregas.php'" value="Listar"/>
</td>
     </tr>
 </table>
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