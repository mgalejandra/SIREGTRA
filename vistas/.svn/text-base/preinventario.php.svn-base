<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/inventario.php');

$objInv = new inventario();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(2,3,4,5);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];
$idpre=$_GET['idpre'];
$ban=0;

  $codmar=$_POST['codmar'];
  $modveh=$_POST['codmodveh'];
  $serveh=$_POST['codserveh'];
  $cantidad=$_POST['cantidad'];
  $preciomin=$_POST['prevehmin'];
  $preciomax=$_POST['prevehmax'];

  $datos = array($codmar,$modveh,$serveh,$cantidad,$preciomin,$preciomax);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

if ($idpre and $indReg!=2)  {
	$ban=1;
	$i=0;
	//echo 'entro';
	$listCarac=$objInv->listarPreInventario($idpre,"","","");
}

if ($indReg==1){
	$registro = $objInv->regPreInventario($datos);
	if ($registro)  {
		 echo "<script>alert('Preinventario Registrado');</script>";
		 echo "<SCRIPT>window.location.href='preinventario.php';</SCRIPT>";
	}else  echo "<script>alert('Preinventario No Registrado');</script>";
}

/*if ($indReg==2){
	//echo 'entro: '.count($datos);
	$modificar = $objInv->modificarCaracteristicasNac($idpre,$datos);
	if ($modificar)   {
	echo "<script>alert('Caracteristica Modificada');</script>";
	echo "<SCRIPT>window.location.href='listado_caracte_nac.php';</SCRIPT>";
	}
}*/


?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
   <script>


function validarCaract(dato){

 	if (document.form1.codmar.value.length==0){
  		alert("Debe Ingresar un codigo de marca ");
  		document.form1.codmar.focus()
  		return (false);
  	}

	if (document.form1.modveh.value.length==0){
 		alert("Debe Ingresar un Modelo");
  		document.form1.modveh.focus()
  		return (false);
	}
    else
    {
   		var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   		if (!filter.test(document.form1.modveh.value)) {
   			alert('No puedes ingresar Caracteres especiales!');
   			document.form1.modveh.focus()
  			return (false);
  		}
    }


 	if (document.form1.cantidad.value.length==0){
 		 alert("Debe Ingresar la cantidad de vehiculos");
 		 document.form1.pesveh.focus()
  		 return (false);
    }

 	if (document.form1.prevehmin.value.length==0){
		 alert("Debe Ingresar el Precio minimo del Vehiculo utiliza . como separador de decimales ");
  		 document.form1.prevehmin.focus()
  		 return (false);
    }
    else
    {
   		var filter = /^([0-9])*[.]?[0-9]*$/i;
		if (!filter.test(document.form1.prevehmin.value)){
   			alert('No puedes ingresar Caracteres solo Numero y punto (.) como separador de decimales!');
   			document.form1.preveh.focus()
  			return (false);
  		}
    }

	if (document.form1.prevehmax.value.length==0){
		 alert("Debe Ingresar el Precio maximo del Vehiculo utiliza . como separador de decimales ");
  		 document.form1.prevehmax.focus()
  		 return (false);
    }
    else
    {
   		var filter = /^([0-9])*[.]?[0-9]*$/i;
		if (!filter.test(document.form1.prevehmax.value)){
   			alert('No puedes ingresar Caracteres solo Numero y punto (.) como separador de decimales!');
   			document.form1.prevehmax.focus()
  			return (false);
  		}
    }

 //alert('entro2');
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
        <td colspan="4" class="cabecera">Registrar Pre-Inventario de Veh&iacute;culos Nacionales e Importados</td>
      </tr>
      <tr>
        <td class="categoria">Marca:</td>
        <td class="dato">
	        <input name="codmar" type="hidden" id="codmar"  value="<?php if($ban==1)  echo $listCarac[$i+22];?>" />
	        <input name="desmar" type="text" id="desmar"  value="<?php if($ban==1)  echo $listCarac[$i+2];?>" size="20" maxlength="3" readonly=""/>
	        <input name="marca" type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
        </td>
        <td class="categoria">Modelo :</td>
        <td>
          <input name="codmodveh" type="hidden" id="codmodveh" value="<?php if($ban==1)  echo $listCarac[$i+23];?>" size="20" maxlength="15"/>
          <input name="modveh" type="text" id="modveh" value="<?php if($ban==1)  echo $listCarac[$i+3];?>" size="20" maxlength="15" readonly=""/>
          <input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php?mod=<? echo $_SESSION['tipoUsuario']; ?>');" value="..." />
        </td>
      </tr>
      <tr>
        <td class="categoria">Serie:</td>
        <td class="dato">
          <input name="codserveh" type="hidden" id="codserveh" value="<?php if($ban==1)  echo $listCarac[$i+24];?>" size="20" maxlength="15"/>
          <input name="serveh" type="text" id="serveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listCarac[$i+4];?>" size="20" maxlength="15" readonly=""/>
          <input name="serie" type="button" id="serie" onclick="catalogo('cat_serie.php?tip=<? echo $_SESSION['tipoUsuario']; ?>');" value="..." />
        </td>
       <td class="categoria">Cantidad:</td>
        <td class="dato"><input name="cantidad" type="text" id="cantidad" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listCarac[$i+7];?>" size="20" maxlength="5"/></td>
       </tr>
       <tr>
        <td class="categoria">Precio m&iacute;nimo: </td>
        <td class="dato">
          <input name="prevehmin" type="text" id="prevehmin" value="<?php if($ban==1)  echo ($listCarac[$i+15]);?>" size="10"  maxlength="10" onkeypress="return acessoDecimal(event)" />
       </td>
        <td class="categoria">Precio m&aacute;ximo: </td>
        <td class="dato">
          <input name="prevehmax" type="text" id="prevehmax" value="<?php if($ban==1)  echo ($listCarac[$i+15]);?>" size="10"  maxlength="10" onkeypress="return acessoDecimal(event)" />
       </td>
     </tr>
     <tr>
       <td height="17" colspan="4"><div align="center" class="NotCelda"><img src="../plantilla/HTML/images/px1.gif" width="1" height="1" alt="" border="0"></div></td>
      </tr>
     <input type="hidden" name="indReg" >
      <tr>
        <td height="22" colspan="4">
          <div align="center">
           <?php if (!$idpre) { ?>
            <input name="agregar" type="button" id="agregar" onclick="validarCaract(1); return false" value="Agregar" />
            <?php } if ($idpre and $_SESSION['usuario']== 'migonzalez') { ?>
            <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Modificar" />
            <?php } ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_preinventario.php'" value="Listar" />
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