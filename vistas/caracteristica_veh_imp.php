<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/caracteristicas.php');
require('../modelos/marca.php');

$objCaract = new caracteristicas();
$objMarca = new marca();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];
$idcaract=$_GET['idcaract'];
$ban=0;

  $numlotveh=($_POST['numlotveh']);
  $codmar=$_POST['codmar'];
  $modveh=$_POST['codmodveh'];
  $serveh=$_POST['codserveh'];
  $anomodveh=($_POST['anomodveh']);
  $pesveh=($_POST['pesveh']);
  $tipcapveh=($_POST['tipcapveh']);
  $capcarveh=($_POST['capcarveh']);
  $numejeveh=($_POST['numejeveh']);
  $diarueveh=($_POST['diarueveh']);
  $anofabveh=($_POST['anofabveh']);
  $numpueveh=($_POST['numpueveh']);
  $codconveh=($_POST['codconveh']);//tipo de combustible
  $preveh=($_POST['preveh']);
  $codptoveh=$_POST['codptoveh'];
  $numliqveh=$_POST['numliqveh'];
  $fecplaveh=($_POST['fecplaveh']);
  $numfacveh=$_POST['numfacveh'];
  $fecfacveh=($_POST['fecfacveh']);
  $origen='I';
  $codclaveh=$_POST['codclaveh'];
  $codtipveh=$_POST['codtipveh'];
  $codserveh=$_POST['codservehi'];
  $codusoveh=$_POST['codusoveh'];

$datos = array($numlotveh,$codmar,$modveh,$serveh,$anomodveh,$pesveh,$tipcapveh,$capcarveh,$numejeveh,$diarueveh,$anofabveh,
$numpueveh,$codconveh,$preveh,$codptoveh,$numliqveh,$fecplaveh,$numfacveh,$fecfacveh,$origen,$codclaveh,$codtipveh,$codserveh,$codusoveh);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

if ($idcaract and $indReg!=2)  {
	$ban=1;
	$i=0;
	//echo 'entro';
	$listCarac=$objCaract->listarCaracteristicasImp($idcaract,"","","","","","");
}

if ($indReg==1){
	//echo 'entro: '.count($datos);
	$registro = $objCaract->registrarCaracteristicasImp($datos);
	if ($registro)   {
	echo "<script>alert('Caracteristica Registrada');</script>";
	echo "<SCRIPT>window.location.href='listado_caracte_imp.php';</SCRIPT>";
	}
}

if ($indReg==2){
	//echo 'entro: '.count($datos);
	$modificar = $objCaract->modificarCaracteristicasImp($idcaract,$datos);
	if ($modificar)   {
	echo "<script>alert('Caracteristica Modificada');</script>";
	echo "<SCRIPT>window.location.href='listado_caracte_imp.php';</SCRIPT>";
	}
}

if ($indReg==3){
  $numlotveh=null;
  $codmar=null;
  $modveh=null;
  $serveh=null;
  $anomodveh=null;
  $pesveh=null;
  $tipcapveh=null;
  $capcarveh=null;
  $numejeveh=null;
  $diarueveh=null;
  $anofabveh=null;
  $numpueveh=null;
  $codconveh=null;
  $preveh=null;
  $codptoveh=null;
  $numliqveh=null;
  $fecplaveh=null;
  $numfacveh=null;
  $fecfacveh=null;
  $origen='I';
  $codclaveh=null;
  $codtipveh=null;
  $codserveh=null;
  $codusoveh=null;
}


?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
    <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>


function validarCaract(dato){

   if (document.form1.numlotveh.value.length==0){
    alert("Debe Ingresar un N°  de Lote");
    document.form1.numlotveh.focus()
    return (false);
                                           }

 if (document.form1.codmar.value.length==0){
  alert("Debe Ingresar un codigo de marca ");
  document.form1.codmar.focus()
  return (false);
                                         }

if (document.form1.modveh.value.length==0){
  alert("Debe Ingresar un Modelo");
  document.form1.modveh.focus()
  return (false);                         }
                     else
                     {
     var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   if (!filter.test(document.form1.modveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.modveh.focus()
  return (false);}
                     }


 if (document.form1.pesveh.value.length==0){
  alert("Debe Ingresar el peso del vehiculo");
  document.form1.pesveh.focus()
  return (false);
                                         }

 if (document.form1.tipcapveh.value.length==0){
  alert("Debe Ingresar el tipo de capacidad del vehiculo");
  document.form1.tipcapveh.focus()
  return (false);
                                         }

 if (document.form1.capcarveh.value.length==0){
  alert("Debe Ingresar la capacidad de carga del vehiculo");
  document.form1.capcarveh.focus()
  return (false);
                                         }

 if (document.form1.numejeveh.value.length==0){
  alert("Debe Ingresar el numero de ejes del vehiculo");
  document.form1.numejeveh.focus()
  return (false);
                                         }

 if (document.form1.diarueveh.value.length==0){
  alert("Debe Ingresar el diametro de la rueda del vehiculo");
  document.form1.diarueveh.focus()
  return (false);
                                         }


 if (document.form1.codptoveh.value.length!=2){
  alert("Debe Ingresar el codigo del Puerto de Entrada");
  document.form1.codptoveh.focus()
  return (false);
                                         }

 if (document.form1.numliqveh.value.length==0){
  alert("Debe Ingresar el N° de Planilla de liquidacion de gravamenes ");
  document.form1.numliqveh.focus()
  return (false);
                                              } else
                     {
   var filter = /^[a-z0-9_\-\ \.\[\]\(\)]+$/i;
   if (!filter.test(document.form1.numliqveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.numliqveh.focus()
  return (false);}
                     }

 if (document.form1.fecplaveh.value.length==0){
    alert("Debe Ingresar la fecha de la planilla de liquidación de gravámenes");
    document.form1.fecplaveh.focus()
    return (false);
                                      }

if (document.form1.numfacveh.value.length==0){
  alert("Debe Ingresar el N° de factura de adquisicion ");
  document.form1.numfacveh.focus()
  return (false);
                                              } else
                     {
     var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   if (!filter.test(document.form1.numfacveh.value)) {
   alert('No puedes ingresar Caracates especiales!');
   document.form1.numfacveh.focus()
  return (false);}
                     }

 if (document.form1.fecfacveh.value.length==0){
  alert("Debe Ingresar la fecha de factura de adquisición");
  document.form1.fecfacveh.focus()
  return (false);
                                         }


 if (document.form1.numpueveh.value.length==0){
    alert("Debe Ingresar el N° de puesto del vehiculo");
    document.form1.numpueveh.focus()
    return (false);
                                            }


   if (document.form1.codconveh.value.length==0){
  alert("Debe Ingresar el tipo de combustible");
  document.form1.codconveh.focus()
  return (false);
                                          }

   if (document.form1.preveh.value.length==0){
  alert("Debe Ingresar el Precio del Vehiculo  utiliza . como separador de decimales ");
  document.form1.preveh.focus()
  return (false);
                                          }else
                     {
   var filter = /^([0-9])*[.]?[0-9]*$/i;
   if (!filter.test(document.form1.preveh.value)) {
   alert('No puedes ingresar Caracates Solo Numero y punto (.) como separador de decimales!');
   document.form1.preveh.focus()
  return (false);}
                     }

 if (document.form1.codservehi.value.length==0){
  alert("Debe seleccionar el servicio  de la clasificacion del intt");
  document.form1.codservehi.focus()
  return (false);
                                         }

 if (document.form1.codclaveh.value.length==0){
  alert("Debe seleccionar la clase de la clasificacion del intt");
  document.form1.codclaveh.focus()
  return (false);
                                         }

 if (document.form1.codtipveh.value.length==0){
  alert("Debe seleccionar el tipo  de la clasificacion del intt");
  document.form1.codtipveh.focus()
  return (false);
                                         }
 if (document.form1.codusoveh.value.length==0){
  alert("Debe seleccionar el uso  de la clasificacion del intt");
  document.form1.codusoveh.focus()
  return (false);
                                         }

                                                                                                                            if (document.form1.codservehi.value.length==0){
  alert("Debe seleccionar el servicio");
  document.form1.codservehi.focus()
  return (false);
                                         }

 document.form1.indReg.value = dato;
 document.form1.submit();

}

function limpiar(dato){
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
        <td colspan="4" class="cabecera">Registrar Caracter&iacute;sticas de Veh&iacute;culos Importados </td>
      </tr>
      <tr>
        <td class="categoria">N° Lote :</td>
        <td colspan="3" class="dato">

           <input name="numlotveh" type="text" id="numlotveh" value="<?php if($ban==1)  echo $listCarac[$i+25] ; ?>" size="20" maxlength="3"/>
           <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php?lot=<? echo $_SESSION['tipoUsuario']; ?>');" value="..." />
        </td>
      </tr>
      <tr>
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
        <td class="categoria">A&ntilde;o Modelo: <?php echo $listCarac[$i+5]; ?> </td>
        <td class="dato" >
          <select name="anomodveh" size="1" id="anomodveh">
          <?php $j=2009; //date('yyyy')
            if($ban==1)  echo " <option value=".$listCarac[$i+5].">".$listCarac[$i+5]."</option>"; else
            echo " <option value=".'seleccione'.">"."</option>";
            while($j<=date('Y')+1){
            echo " <option value=".$j.">".$j."</option>"; $j++;}?>
        </select>
       </td>
      </tr>
      <tr>
        <td class="categoria">Peso</td>
        <td class="dato"><input name="pesveh" type="text" id="pesveh" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listCarac[$i+7];?>" size="20" maxlength="5"/></td>
        <td class="categoria">Tipo de capacidad  :</td>
        <td class="dato"><input name="tipcapveh" type="text" id="tipcapveh"  onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listCarac[$i+8]; else echo '2';?>" size="20" maxlength="1" readonly=""/></td>
      </tr>
      <tr>
        <td class="categoria">Capacidad de Carga: </td>
        <td class="dato"><input name="capcarveh" type="text" id="capcarveh" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listCarac[$i+9];?>" size="20" maxlength="5"/>Kgs</td>
        <td class="categoria"><div align="right">N° de Ejes  :</div></td>
        <td class="dato"><input name="numejeveh" type="text" id="numejeveh"  onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listCarac[$i+10];?>" size="20" maxlength="1"/></td>
      </tr>
      <tr>
        <td class="categoria">Di&aacute;metro de la Rueda: </td>
        <td class="dato"><input name="diarueveh" type="text" id="diarueveh" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listCarac[$i+11];?>" size="20" maxlength="3"/>Ptos.</td>
        <td class="categoria"  >A&ntilde;o de Fabricaci&oacute;n:</td>
        <td class="dato">
         <select name="anofabveh" size="1" id="anofabveh">
            <?php $j=2009; //date('yyyy')
            if($ban==1)  echo " <option value=".$listCarac[$i+12].">".$listCarac[$i+12]."</option>"; else
            echo " <option value=".'seleccione'.">"."</option>";
            while($j<=date('Y')+1){
            echo " <option value=".$j.">".$j."</option>"; $j++;}?>
          </select>
      </td>
      </tr>
      <tr>
        <td  class="categoria">N° de Puestos:</td>
        <td class="dato">
          <input name="numpueveh" type="text" id="numpueveh" value="<?php if($ban==1)  echo $listCarac[$i+13];?>" size="20"  maxlength="3" onkeypress="return acessoNumerico(event)" />
       </td>
        <td  class="categoria">Tipo de Combustible :</td>
        <td class="dato">
          <input name="desconveh" type="text" id="desconveh" value="<?php if($ban==1)  echo $listCarac[$i+26];?>" size="20"  maxlength="3" readonly=""/>
          <input name="codconveh" type="hidden" id="codconveh" value="<?php if($ban==1)  echo $listCarac[$i+14];?>" size="20"  maxlength="3"/>
          <input name="combustible" type="button" id="combustible" onclick="catalogo('cat_combustible.php');" value="..." readonly="" />
       </td>
      </tr>
      <tr>
        <td class="categoria">Precio: </td>
        <td class="dato">
          <input name="preveh" type="text" id="preveh" value="<?php if($ban==1)  echo ($listCarac[$i+15]);?>" size="10"  maxlength="10" onkeypress="return acessoDecimal(event)"  />
       </td>
        <td class="categoria"></td>
        <td >
        </td>
      </tr>
      <tr>
        <td  colspan="4" class="cabecera">Datos para Veh&iacute;culos Importados</td>
      </tr>
      <tr>
        <td class="categoria">Puerto de Entrada:</td>
        <td class="dato">
          <input name="codptoveh" type ="hidden" id="codptoveh" value="<?php if($ban==1)  echo $listCarac[$i+31];?>"   readonly="" />
          <input name="desptoveh" type ="text" id="desptoveh" value="<?php if($ban==1)  echo $listCarac[$i+32];?>"   readonly="" />
          <input name="puerto" type="button" id="puerto" onclick="catalogo('cat_pto.php');" value="..." readonly="" />
        </td>
        <td class="categoria">N° de Planilla Liquidaci&oacute;n:</td>
        <td class="dato">
          <input name="numliqveh" type="text" id="numliqveh" value="<?php if($ban==1)  echo $listCarac[$i+36];?>" size="15"  maxlength="12" />
       </td>
      </tr>
     <tr>
        <td class="categoria">Fecha de Planilla Liquidaci&oacute;n:</td>
        <td class="dato">
          <input name="fecplaveh" type="text" id="fecplaveh" value="<?php if($ban==1)  echo $listCarac[$i+33];?>" size="10"  maxlength="10"  date_format="dd/MM/yy" onkeyup="javascript: mascara(this,'/',Array(2,2,4),true)" readonly=""/>
          <img src="../images/cal.gif" width="16" height="16" onclick="show_calendar('document.forms[0].fecplaveh',document.forms[0].fecplaveh.value)" /></td>
        <td class="categoria">N°  factura de Adquisici&oacute;n:  </td>
        <td class="dato"><input name="numfacveh" type ="text" id="numfacveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listCarac[$i+34];?>" size="20" maxlength="17" /></td>
      </tr>
      <tr>
        <td class="categoria">Fecha de la Factura :</td>
        <td class="dato"  colspan="3">
          <input name="fecfacveh" type="text" id="fecfacveh" value="<?php if($ban==1)  echo $listCarac[$i+35];?>" size="10"  maxlength="10"  date_format="dd/MM/yy" onkeyup="javascript: mascara(this,'/',Array(2,2,4),true)" readonly=""/>
          <img src="../images/cal.gif" width="16" height="16" onclick="show_calendar('document.forms[0].fecfacveh',document.forms[0].fecfacveh.value)" /></td>
      </tr>
      <tr>
        <td  colspan="4" class="cabecera">Clasificaci&oacute;n del INTTT</td>
      </tr>
        <tr>
        <td class="categoria">Servicio: </td>
        <td class="dato">
          <input name="codservehi" type="hidden" id="codservehi" value="<?php if($ban==1)  echo $listCarac[$i+17];?>" size="20" maxlength="4"/>
          <input name="desservehi" type="text" id="desservehi" value="<?php if($ban==1)  echo $listCarac[$i+30];?>" size="20" maxlength="4" readonly=""/>
          <input name="servicio" type="button" id="servicio" onclick="catalogo('cat_servicios.php');" value="..." />
       </td>
        <td class="categoria"  align="right">Clase: </td>
        <td class="dato">
          <input name="codclaveh" type="hidden" id="codclaveh"   value="<?php if($ban==1)  echo $listCarac[$i+18];?>" size="20" maxlength="2"/>
          <input name="desclaveh" type="text" id="desclaveh"   value="<?php if($ban==1)  echo $listCarac[$i+27];?>" size="20" maxlength="2" readonly=""/>
          <input name="clase" type="button" id="clase" onclick="catalogo('cat_clase.php');" value="..." />
        </td>
      </tr>
     <tr>
     <tr>
        <td class="categoria">Tipo:</td>
        <td class="dato">
          <input name="codtipveh" type="hidden" id="codtipveh"   value="<?php if($ban==1)  echo $listCarac[$i+19];?>" size="20" maxlength="2"/>
          <input name="destipveh" type="text" id="destipveh"   value="<?php if($ban==1)  echo $listCarac[$i+28];?>" size="20" maxlength="2" readonly=""/>
          <input name="tipo" type="button" id="tipo" onclick="catalogo('cat_tipos.php');" value="..." />
         </td>
        <td class="categoria"  align="right">Uso: </td>
        <td class="dato">
        <input name="codusoveh" type="hidden" id="codusoveh" value="<?php if($ban==1)  echo $listCarac[$i+20];?>" size="20" maxlength="2"/>
        <input name="desusoveh" type="text" id="desusoveh" value="<?php if($ban==1)  echo $listCarac[$i+29];?>" size="20" maxlength="2" readonly=""/>
        <input name="uso" type="button" id="uso" onclick="catalogo('cat_uso.php');" value="..." />
        </td>
      </tr>
     <input type="hidden" name="indReg" >
     <td height="22" colspan="4">
          <div align="center">
           <?php if (!$idcaract) { ?>
            <input name="agregar" type="button" id="agregar" onclick="validarCaract(1); return false" value="Agregar" />
            <?php } if ($idcaract and ($_SESSION['usuario']== 'migonzalez'  or $_SESSION['usuario']== 'jfigueroa'  or $_SESSION['usuario']== 'asuvinca' or  $_SESSION['usuario']== 'jmata' or $_SESSION['usuario']== 'avelasquez' or $_SESSION['usuario']== 'acomercializacion'  )) { ?>
            <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Modificar" />
            <?php } ?>
             <input  type="button" onclick="limpiar('3');" value="Limpiar" />
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_caracte_imp.php'" value="Listar" />
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