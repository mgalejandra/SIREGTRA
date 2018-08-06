<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/placas.php');

$objPlacas = new placas();


$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(2,3,4,5,11,17,18,23,24);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];

$ban=0;
$indErr = false;

if ($_GET['idsercarveh']) $idsercarveh=$_GET['idsercarveh'];
else
$idsercarveh=$_POST['sercarveh'];

  $sercarveh=$_POST['sercarveh'];
  $plaveh=$_POST['plaveh'];
  $codestveh=$_POST['codestveh'];
  $numrafveh=$_POST['numrafveh'];
  $fecrafveh=$_POST['fecrafveh'];
  $numsecveh=$_POST['numsecveh'];

$datos = array($sercarveh,$plaveh,$codestveh,$numrafveh,$fecrafveh,$numsecveh);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

if ($idsercarveh and $indReg!=2)  {
	$ban=1;
	$i=0;
	//echo 'entro';
	$listPlacas=$objPlacas->listarPlacas($idsercarveh,'','');
}

if ($indReg==1){
	//echo 'entro: '.count($datos);}
	$listPlacas=$objPlacas->listarPlacas($idsercarveh,'','');
    //echo 'aqui:'.$listPlacas[0];
   if ($listPlacas[0]!=''){
   	     $indErr = true;
	     $msj = 'Este serial ya tiene placa asignada';
	     $campo='sercarvehs';
	     echo "<script>alert('El serial: ".$listPlacas[0]." tiene asignada la placa: ".$listPlacas[1]."');</script>";
   }else
   {
   	$buscarPlacas=$objPlacas->listarPlacas('',$plaveh,'');
	   	if ($buscarPlacas[1]!=''){
	   	     $indErr = true;
		     $msj = 'Esta Placa fue Asignada ';
		     $campo='sercarvehs';
		     $listPlacas=$objPlacas->listarPlacas('',$plaveh,'');
		     echo "<script>alert('la placa : ".$buscarPlacas[1]." fue asignada al vehiculo ".$buscarPlacas[0]."');</script>";
	   }else $registro = $objPlacas->registrarPlacas($datos);

   }

	if ($registro)  {
		 echo "<script>alert('Placa Registrada');</script>";
		 echo "<SCRIPT>window.location.href='listado_placas.php';</SCRIPT>";
	}
}

if ($indReg==2){
	//echo 'entro: '.count($datos);
	$modificar = $objPlacas->modificarPlacas($idsercarveh,$datos);
	if ($modificar)   {
	     echo "<script>alert('Registro de Placa Modificada');</script>";
		 echo "<SCRIPT>window.location.href='listado_placas.php';</SCRIPT>";
	}
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


function validarCaract(dato){

if (document.form1.sercarveh.value.length!=17){
  alert("Debe Ingresar un serial de carroceria de 17 Caracteres");
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



 if (document.form1.plaveh.value.length!=7){
    alert("Debe Ingresar un numero de placa de 7 Caracteres");
    document.form1.plaveh.focus()
    return (false);
                                      }else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.plaveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.plaveh.focus()
  return (false);}
                     }
//fecrafveh



 if (document.form1.codestveh.value.length==0){
    alert("Debe Ingresar el codigo del estado ");
    document.form1.codestveh.focus()
    return (false);
                                      }


 if (document.form1.numrafveh.value.length==0){
    alert("Debe Ingresar el numero de la Rafaga ");
    document.form1.numrafveh.focus()
    return (false);
                                      }

 if (document.form1.fecrafveh.value.length==0){
    alert("Debe Ingresar la fecha de la Rafaga ");
    document.form1.fecrafveh.focus()
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
  <table class="formulario" width="822" border="0" align="center" >
      <tr>
        <td colspan="4" class="cabecera">Registro de Placas</td>
      </tr>
      <tr>
        <td class="categoria">Veh&iacute;culos:</td>
        <td class="dato">
         <input name="sercarveh" type="text" id="sercarveh" maxlength="18" value="<?php if($ban==1)  echo $listPlacas[$i];?>" readonly=""/>
         <input type="button" onclick="catalogoAncho('cat_vehiculos.php?ti=placas');" value="..." />
        </td>
         <td class="categoria">Placa:</td>
        <td class="dato">
	        <input name="plaveh" type="text" id="plaveh" onBlur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listPlacas[$i+1];?>"  maxlength="7" />
        </td>
      </tr>
      <tr>
        <td class="categoria">Estado</td>
        <td class="dato">
         <input name="codestveh" type="hidden" id="codestveh" size="20"  maxlength="2" value="<?php if($ban==1)  echo $listPlacas[$i+2];?>"  readonly=""/>
         <input name="desestveh" type="text" id="desestveh" size="20"  maxlength="2"  value="<?php if($ban==1)  echo $listPlacas[$i+3];?>"  readonly=""/>
         <input name="estado" type="button" id="estado" onClick="catalogo('cat_estado.php');" value="..." />
        </td>
        <td class="categoria">N° R&acute;faga/Placa (REFECIV):</td>
        <td class="dato">
         <input name="numrafveh" type ="text" id="numrafveh" onBlur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listPlacas[$i+4]; else echo 'DCMD9093';?>" size="20" maxlength="8" />
        </td>
      </tr>
      <tr>
        <td class="categoria">Fecha Ráfaga:</td>
        <td class="dato" >
          <input name="fecrafveh" type="text" id="fecrafveh" onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)" value="<?php if($ban==1)  echo $listPlacas[$i+5]; else echo '15/03/2010';?>" size="10"  maxlength="10" date_format="dd/MM/yy" readonly=""/>
          <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecrafveh',document.forms[0].fecrafveh.value)" />
       </td>
        <td class="categoria">N° Secuencia R&acute;faga:</td>
        <td class="dato" >
          <input name="numsecveh" type="text" id="numsecveh" value="<?php if($ban==1)  echo $listPlacas[$i+6]; else echo '1';?>" size="20"  maxlength="2" onKeyPress="return acessoNumerico(event)" readonly=""/>
       </td>
      </tr>

       <tr>
        <td height="22" colspan="4">
            <div align="center"> <?php //if($indErr) MensajeReg($msj,$registro); ?> </div>
         </td>
       </tr>
      <tr>
        <td height="22" colspan="4">
          <div align="center">
           <input type="hidden" name="indReg" >
           <?php if (!$idsercarveh) { ?>
            <input name="agregar" type="button" id="agregar" onclick="validarCaract(1); return false" value="Agregar" />
            <?php } if ($idsercarveh and ($_SESSION['tipoUsuario'] == 1 or $_SESSION['tipoUsuario'] == 4 or $_SESSION['tipoUsuario'] == 11)) { ?>
           <!-- <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Modificar" />-->
            <?php } ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_placas.php'" value="Listar" />
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