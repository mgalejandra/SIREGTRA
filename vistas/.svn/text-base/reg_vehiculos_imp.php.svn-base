<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/vehiculos.php');

$objVehiculo = new vehiculos();


$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,6,7,11,18,23,24);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];

$ban=0;
$indErr = false;
  $sercarveh=$_POST['sercarveh'];
  $sermotveh=$_POST['sermotveh'];
  $col1veh=$_POST['col1veh'];
  $col2veh=$_POST['col2veh'];
  $sernivveh=$_POST['sernivveh'];
  $serchaveh=$_POST['serchaveh'];
  $numhomveh=$_POST['numhomveh'];
  $fechomveh=$_POST['fechomveh'];
  $idCaract=$_POST['idCaract'];

if ($_GET['idsercarveh']) $idsercarveh=$_GET['idsercarveh'];
else
$idsercarveh=$_POST['sercarveh'];


$datos = array($sercarveh,$sermotveh,$col1veh,$col2veh,$sernivveh,$serchaveh,$numhomveh,$fechomveh,$idCaract);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

if ($idsercarveh and $indReg!=2)  {
	$ban=1;
	$i=0;
	//echo 'entro';
	$listVehic=$objVehiculo->listarVehiculos($idsercarveh,'','','','I','','');
}

if ($indReg==1){
	//echo 'entro: '.count($datos);}
	$listVehic=$objVehiculo->listarVehiculos($idsercarveh,'','','','I','','');
    //echo 'aqui:'.$listVehic[0];
    if ($listVehic[0]!=''){
	   	$ban=1;
		$i=0;
	     echo "<script>alert('El serial: ".$listVehic[0]." ya se encuentra registrado');</script>";
   }else
	$registro = $objVehiculo->registrarVehiculos($datos);
	if ($registro)  {
		 echo "<script>alert('Vehiculo Registrado');</script>";
		 echo "<SCRIPT>window.location.href='listado_vehiculos_imp.php';</SCRIPT>";
	}
}

if ($indReg==2){
	//echo 'entro: '.count($datos);
	$modificar = $objVehiculo->modificarVehiculos($idsercarveh,$datos);
	if ($modificar)   {
	     echo "<script>alert('Vehiculo Modificado');</script>";
		 echo "<SCRIPT>window.location.href='listado_vehiculos_imp.php';</SCRIPT>";
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


 if (document.form1.col1veh.value.length==0){
  alert("Debe Ingresar un Codigo de Color 1");
  document.form1.col1veh.focus()
  return (false);
                                         }

if (document.form1.sernivveh.value.length!=17){
  alert("Debe Ingresar el N° de serial del N.I.V de 17 caracteres");
  document.form1.sernivveh.focus()
  return (false);
                                     } else
                     {
   var filter = /^[a-z0-9_\-\.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.sernivveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.sernivveh.focus()
  return (false);}
                     }

 if (document.form1.idCaract.value.length==0){
  alert("Debe Ingresar el id de la caracteristica del vehiculo");
  document.form1.idCaract.focus()
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
        <td colspan="4" class="cabecera">Registrar Datos de Vehiculos Importados</td>
      </tr>
      <tr>
      <?php if ($idsercarveh) $parch='readonly=""';?>
        <td class="categoria">Serial de Carroceria:</td>
        <td class="dato">
         <input name="sercarveh" type="text" id="sercarveh"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listVehic[$i];?>" size="25" maxlength="17" <?php echo $parch ?>/>
        </td>
         <td class="categoria">Serial de Motor:</td>
        <td class="dato">
	        <input name="sermotveh" type="text" id="sermotveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listVehic[$i+1];?>" size="25" maxlength="17"/>
        </td>
      </tr>
      <tr>
        <td class="categoria">Color 1:</td>
        <td class="dato">
         <input name="col1veh" type="hidden" id="col1veh"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listVehic[$i+11];?>"  readonly=""/>
         <input name="des1veh" type="text" id="des1veh"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listVehic[$i+2];?>"  readonly=""/>
         <input name="color1" type="button" id="color1" onclick="catalogo('cat_color.php?colop=1&col1=<? echo $_SESSION['tipoUsuario']; ?>');" value="..." />
        </td>
        <td class="categoria">Color 2  :</td>
        <td class="dato">
         <input name="col2veh" type="hidden" id="col2veh"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listVehic[$i+12];?>"  readonly=""/>
         <input name="des2veh" type="text" id="des2veh"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listVehic[$i+13];?>"  readonly=""/>
         <input name="color2" type="button" id="color2" onclick="catalogo('cat_color.php?colop=2&col1=<? echo $_SESSION['tipoUsuario']; ?>');" value="..." />
        </td>
      </tr>
      <tr>
        <td class="categoria">Serial N.I.V  : </td>
        <td class="dato" >
          <input name="sernivveh" type="text" id="sernivveh" value="<?php if($ban==1)  echo $listVehic[$i+3];?>" size="20"  maxlength="17" onblur="javascript:this.value=this.value.toUpperCase()">
       </td>
        <td class="categoria">Serial del Chasis: </td>
        <td class="dato" >
          <input name="serchaveh" type ="text" id="serchaveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listVehic[$i+4];?>" size="20" maxlength="17" />
       </td>
      </tr>
      <tr>
        <td class="categoria">N° Homologaci&oacute;n Innt:</td>
        <td class="dato"><input name="numhomveh" type="text" id="numhomveh" value="<?php if($ban==1)  echo $listVehic[$i+5];?>" size="20"  maxlength="15" onblur="javascript:this.value=this.value.toUpperCase()" /></td>
        <td class="categoria">Fecha de Homologaci&oacute;n:</td>
        <td class="dato">
        <input name="fechomveh" type="text" id="fechomveh" value="<?php if($ban==1)  echo $listVehic[$i+6];?>" size="10"  maxlength="10" date_format="dd/MM/yy" onkeyup="javascript: mascara(this,'/',Array(2,2,4),true)" readonly=""/>
         <img src="../images/cal.gif" width="16" height="16" onclick="show_calendar('document.forms[0].fechomveh',document.forms[0].fechomveh.value)" />
        </td>
      </tr>
      <input type="hidden" name="indReg" >
       <tr>
        <td class="categoria">Id Caracteristica Vehiculo</td>
        <td class="dato" colspan='3' >
         <input name="idCaract" type="hidden" id="idCaract" value="<?php if($ban==1)  echo $listVehic[$i+8];?>" size="20"  maxlength="15" onblur="javascript:this.value=this.value.toUpperCase()" />
         <input name="desidCaract" type="text" id="desidCaract"   value="<?php if($ban==1)  echo $listVehic[$i+7];?>"  size="70"  readonly=""/>
         <input type="button" onclick="catalogoAncho('cat_caracte_imp.php');" value="..." />
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
           <?php if (!$idsercarveh) { ?>
            <input name="agregar" type="button" id="agregar" onclick="validarCaract(1); return false" value="Agregar" />
            <?php } if ($idsercarveh  and ($_SESSION['tipoUsuario'] == 2 or $_SESSION['tipoUsuario'] == 4 or $_SESSION['tipoUsuario'] == 11)) { ?>
            <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Modificar" />
            <?php } ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_vehiculos_imp.php'" value="Listar" />
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
