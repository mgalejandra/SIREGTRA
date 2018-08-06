<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/certificado.php');
require('../modelos/placas.php');
require('../modelos/factura.php');
require('../modelos/banco.php');

$objFactura = new factura();
$objCertificado = new certificado();
$objPlacas = new placas();
$objBanco = new banco();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,11,18,24);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];
$codproa=$_POST['codproa'];

$ban=0;
$indErr = false;


  $sercarveh=$_POST['sercarveh'];
  $idAsig=$_POST['idAsig'];
  $numcerveh=$_POST['inicerveh'].$_POST['numcerveh'];
  $fec=$_POST['fec'];
  $numfac1veh=$_POST['numfac1veh'];
  $fecfac1veh=$_POST['fecfac1veh'];
  $nomseg=$_POST['nomseg'];
  $numpolseg=$_POST['numpolseg'];
  $fecvenpol=$_POST['fecvenpol'];
  $resdom=$_POST['resdom'];
  $numcedres=$_POST['numcedres'];
  $obspolseg=$_POST['obspolseg'];
  $cert=$_POST['cert'];
  $tipo=$_GET['tip'];
  $num=$_GET['num'];

  $ban=0;

if ($_GET['id_certificado']) {
	$id_certificado=$_GET['id_certificado'];
	$ban=1;
} else $listarcertificado=null;


  if ($num){
  	  $listarFactura=$objFactura->reporteFactura($num);
  	  if ($listarFactura[5]<>'CONTADO') $listarBancos = $objBanco->listarBancos1('','',$listarFactura[23]);
  	  $datos = array($listarFactura[11],$listarFactura[9],$numcerveh,$fec,$numfac1veh,$fecfac1veh,$nomseg,$numpolseg,$fecvenpol,$resdom,$numcedres,$obspolseg,$cert);
  }else
   $datos = array($sercarveh,$idAsig,$numcerveh,$fec,$numfac1veh,$fecfac1veh,$nomseg,$numpolseg,$fecvenpol,$resdom,$numcedres,$obspolseg,$cert);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

if ($id_certificado or $indReg!=2)  {
	$ban=1;
	$i=0;
	//echo 'entro';
	$listarcertificado=$objCertificado->listarCertificados($id_certificado,'','','','','','','','','',-1,$tipo);
	$_SESSION['idcertificado']=$listarcertificado[4];
}

if ($indReg==1){
	$ban=1;
	$i=0;
	//echo 'entro: '.count($datos);}
	$listarcertificado=$objCertificado->listarCertificados('',$numcerveh,'','','','','','','','',-1,$tipo);
    //echo 'aqui:'.$listPlacas[0];
   if ($listarcertificado[0]!=''){
	     echo "<script>alert('el Numero de Certificado: ".$listarcertificado[0]." fue asignado a: ".$listarcertificado[4]."');</script>";
	     echo "<SCRIPT>window.location.href='listado_certificado.php';</SCRIPT>";
   }else
   {
   	     $listarcertificado1=$objCertificado->listarCertificados('','',$sercarveh,'','','','','','','',-1,$tipo);
	   	 if ($listarcertificado1[0]!='' ){
		  echo "<script>alert('al Vehiculo: ".$listarcertificado1[2]." asignado a ".$listarcertificado1[4]." tiene el Certificado: ".$listarcertificado1[0]."');</script>";
		  echo "<SCRIPT>window.location.href='listado_certificado.php';</SCRIPT>";
	    }else
	      $listarPlacas=$objPlacas->listarPlacas($sercarveh,'','');
	      if (count($listarPlacas) == 0 )
	          echo "<script>alert('Este Vehiculo No tiene asignado una placa')</script>";
	      else
      	  $registro = $objCertificado->registrarCertificado($datos,$listarFactura[13],$num);

   }

	if ($registro)  {
		 echo "<script>alert('Certificado Registrado');</script>";
		// echo "<SCRIPT>window.location.href='../vistas/reportes/pdfcertificado.php?numcerveh=".$registro."';</SCRIPT>";
		 echo '<SCRIPT> window.open("../vistas/reportes/pdfcertificado.php?numcerveh='.$registro.' " , "ventana1" , "width=600,height=600,scrollbars=NO") </SCRIPT>';


		 if ($num)
		 echo "<SCRIPT>window.location.href='det_factura_suvinca.php?idfactura=$num';</SCRIPT>";
		 else
		 echo "<SCRIPT>window.location.href='listado_certificado.php';</SCRIPT>";

	}
}

if ($indReg==2){
	//echo 'entro: '.count($datos);

	$modificar = $objCertificado->modificarCertificado($id_certificado,$datos,$codproa);
	if ($modificar)   {
	     echo "<script>alert('Certificado Modificado');</script>";
		 echo "<SCRIPT>window.location.href='listado_certificado.php';</SCRIPT>";
	}else
	 echo "<script>alert('Certificado No pudo ser Modificado el serial o n# certificado ya se encuentran registrados');</script>";
 }

if ($indReg==3)  {
	$listarcertificado=null;


}
if (!$_GET['id_certificado']) {
	$listarcertificado=null;
	$ban=0;
}

$_SESSION['numcert']=$listarcertificado[$i+16].$listarcertificado[$i+17];
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

 if (document.form1.sercarveh.value.length==0){
  alert("Debe Ingresar el serial del vehiculo");
  document.form1.sercarveh.focus()
  return (false);
                                         }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.sercarveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.sercarveh.focus()
  return (false);}
                     }


 if (document.form1.inicerveh.value.length!=2){
  alert("Debe Ingresar Las dos iniciales del numero de certificado");
  document.form1.inicerveh.focus()
  return (false);
                                         }


if (document.form1.numcerveh.value.length!=6){
  alert("Debe Ingresar el numero de certificado de origen preimpreso de 6 caracteres");
  document.form1.numcerveh.focus()
  return (false);
                                         }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.numcerveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.numcerveh.focus()
  return (false);}
                     }

 if (document.form1.numfac1veh.value.length==0){
  alert("Debe Ingresar el numero de factura");
  document.form1.numfac1veh.focus()
  return (false);
                                         }

 if (document.form1.fecfac1veh.value.length==0){
  alert("Debe Ingresar La fecha de la factura");
  document.form1.fecfac1veh.focus()
  return (false);
                                         }

 document.form1.indReg.value = dato;
 document.form1.submit();

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
  <table class="formulario" width="900" border="0" align="center" >
      <tr>
        <td colspan="4" class="cabecera">    <?php if ($tipo!='E') { ?> Datos para Generar el Certificado de origen  <?php if ($num) echo ' de la Factura Proforma N#'.$num;  ?>    <?php } else echo 'CERTIFICADO ANULADO'; ?> </td>
      </tr>
      <tr>
        <td class="categoria">Vehiculo:	</td>
        <td class="dato">
         <input name="sercarveh" type="text" id="sercarveh" maxlength="18" value="<?php if ($num) echo $listarFactura[11]; if($ban==1)  echo $listarcertificado[$i+2];?>" readonly="" size="30" />
         <?php if (!$num){ ?><input type="button" onclick="catalogoAncho('cat_asignacion.php');" value="..."/> <?php } ?>
        </td>
         <td class="categoria">Beneficiario: </td>
        <td class="dato">
	        <input name="beneficario" type="text" id="beneficario" value="<?php  if ($num) echo $listarFactura[12]; if($ban==1)  echo $listarcertificado[$i+4];?>" size="40"  readonly="" />
	        <input type="hidden" name="idAsig" id="idAsig" value="<?php if($ban==1)  echo $listarcertificado[$i+15];?>">
        </td>
      </tr>
       <tr>
        <td class="categoria">N° de Certificado de Origen (Preimpreso):</td>
        <td class="dato">
         <input name="inicerveh" type ="text" id="inicerveh"  value="<?php if($ban==1)  echo $listarcertificado[$i+16];?>" size="2" maxlength="2"   onblur="javascript:this.value=this.value.toUpperCase()" />
         <input name="numcerveh" type ="text" id="numcerveh"  value="<?php if($ban==1)  echo $listarcertificado[$i+17];?>" size="15" maxlength="6"   onkeypress="return acessoNumerico(event)" />
        </td>
         <td class="categoria">Fecha Fin Convenido: </td>
        <td class="dato">
	        <input name="fec" type="text" id="fec"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarcertificado[$i+5]; else echo '31/12/2010'?>" size="10" maxlength="10" readonly="" />
            <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecfincon',document.forms[0].fecfincon.value)" />
        </td>
      </tr>
      <tr>
        <td class="categoria">N° de Factura 1:</td>
        <td class="dato" >
           <input name="numfac1veh" type="text" id="numfac1veh" size="20"  maxlength="15" onBlur="javascript:this.value=this.value.toUpperCase()" value="<?php if ($num) echo $listarFactura[39]; if($ban==1)  echo $listarcertificado[$i+6];?>" <?php if ($num) echo 'readonly=""'; ?> />
        </td>
        <td class="categoria">Fecha de la Factura 1:</td>
        <td class="dato">
	       <input name="fecfac1veh" type="text" id="fecfac1veh" size="10"  maxlength="10" date_format="dd/MM/yy" onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)" readonly="" value="<?php if ($num) echo $listarFactura[40]; if($ban==1)  echo $listarcertificado[$i+7];?>" />
           <?php if (!$num) {?>
           <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecfac1veh',document.forms[0].fecfac1veh.value)" />
           <?php }?>
        </td>
      </tr>
      <tr>
        <td colspan="4" class="cabecera">Datos del Seguro </td>
      </tr>
      <tr>
        <td class="categoria"> Empresa Aseguradora:</td>
        <td class="dato">
         <input name="nomseg" type ="text" id="nomseg"  value="<?php if($ban==1)  echo $listarcertificado[$i+8];?>" size="20" maxlength="50"   onblur="javascript:this.value=this.value.toUpperCase()" />
        </td>
         <td class="categoria">N° Poliza : </td>
        <td class="dato">
	       <input name="numpolseg" type ="text" id="numpolseg" value="<?php if($ban==1)  echo $listarcertificado[$i+9];?>" size="20" maxlength="20"   onblur="javascript:this.value=this.value.toUpperCase()" />
        </td>
      </tr>
       <tr>
        <td class="categoria">Fecha de Vencimiento :</td>
        <td class="dato" colspan='3'>
         <input name="fecvenpol" type ="text" id="fecvenpol"  value="<?php if($ban==1 and $listarcertificado[$i+10]!='01/01/1999')  echo $listarcertificado[$i+10];?>" size="20" maxlength="10"   date_format="dd/MM/yy" onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)"  readonly=""/>
          <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecvenpol',document.forms[0].fecvenpol.value)" />
        </td>
      </tr>
       <tr>
        <td colspan="4" class="cabecera">Reserva de Dominio </td>
      </tr>
      <tr>
        <td class="categoria">A Favor de: </td>
        <td class="dato">
         <input name="resdom" type ="text" id="resdom"  value="<?php  if (($num) and ($listarFactura[5]<>'CONTADO')) echo $listarBancos[1]; if($ban==1)  echo $listarcertificado[$i+11];?>" size="20" maxlength="120"   onblur="javascript:this.value=this.value.toUpperCase()" <? if (($num) and ($listarFactura[5]<>'CONTADO')) echo "readonly=''" ?>/>
        </td>
         <td class="categoria">N° C.I o RIF: </td>
        <td class="dato">
	       <input name="numcedres" type ="text" id="numcedres" value="<?php  if (($num) and ($listarFactura[5]<>'CONTADO')) echo $listarBancos[6]; if($ban==1)  echo $listarcertificado[$i+12];?>" size="20" maxlength="10"   onblur="javascript:this.value=this.value.toUpperCase()" <? if (($num) and ($listarFactura[5]<>'CONTADO')) echo "readonly=''" ?>/>
        </td>
      </tr>
       <tr>
        <td class="categoria">Observaciones</td>
        <td class="dato" colspan='3'>
     <textarea name="obspolseg" cols="60" rows="2" id="obspolseg"  onblur="javascript:this.value=this.value.toUpperCase()" ><?php if($ban==1)  echo $listarcertificado[$i+13];?></textarea>
        </td>
      </tr>
       <tr>
        <td class="categoria">Certificado</td>
        <td class="dato" colspan='3'>

           <input type="radio" name="cert" value="C"  <?php if($ban==1 and  $listarcertificado[$i+18]=="C")  echo "checked= 'true'";else echo "checked= 'true'" ?> />
            <label>Completo</label>
           <input type="radio" name="cert" value="S"  <?php if($ban==1 and  $listarcertificado[$i+18]=="S")  echo "checked= 'true'"; ?>/>
           <label>Solo Parte Superior</label>

        </td>
      </tr>
      <tr>
        <td height="22" colspan="4">
          <div align="center">
           <input type="hidden" name="indReg" >
           <input type="hidden" name="codproa" id="codproa" value="<?php if($ban==1) echo  $listarcertificado[$i+3]; ?>">
           <?php if ($tipo!='E') { ?>
           <?php if (!$id_certificado) { ?>
            <input  type="button" onclick="validarCaract(1); return false" value="Registrar" />
            <?php } if ($id_certificado and ($_SESSION['tipoUsuario'] == 1 or $_SESSION['tipoUsuario'] == 4 or $_SESSION['tipoUsuario'] == 11 or $_SESSION['tipoUsuario'] == 2 or  $_SESSION['tipoUsuario'] == 18)) { ?>
            <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Modificar" />
            <?php } ?>
             <input  type="button"  onclick="validarCaract('3'); return false" value="Limpiar" />
              <?php } ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_certificado.php'" value="Listar" />
         </div>
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