<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/concesionario.php');

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,11,13,14,15,17);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];

$ban=0;
$indErr = false;


$objConcesionario = new concesionario();

$idconce=$_GET['idconce'];

  $numrif=$_POST['rif'];
  $nombre=$_POST['nombre'];
  $direccion=$_POST['direccion'];
  $tlf1=$_POST['codtlf1'].$_POST['tlf1'];
  $tlf2=$_POST['codtlf2'].$_POST['tlf2'];

  $datos = array($numrif,$nombre,$direccion,$tlf1,$tlf2);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

$accion = "Registrar";

  if ($idconce){
  	$accion = "Modificar";
  	$ban=1;
  	$listarConcesionario=$objConcesionario->listarConcesionarioID($idconce);
  }

/*if ($idbenefi and $indReg!=2)  {
	$ban=1;
	$i=0;
	//echo 'entro';
	$listarBeneficiario=$objBeneficiario->listarBeneficiario($idbenefi,'','','','');
}*/

if ($indReg==1){
    $registro = $objConcesionario->regConcesionario($datos);

	if ($registro)  {
       		echo '<SCRIPT>alert("Concesionario Registrado");</SCRIPT>';
			echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
		    echo "<SCRIPT>window.close();</SCRIPT>";
	}
	else
	{
	  		echo '<SCRIPT>alert("Concesionario no Registrado");</SCRIPT>';
		   	echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
		   	echo "<SCRIPT>window.close();</SCRIPT>";
	}
}

if ($indReg==2){
	//echo 'entro: '.count($datos);
	$modificar = $objConcesionario->modConcesionario($idconce,$datos);

	if ($modificar)  {
       		echo '<SCRIPT>alert("Concesionario Modificado");</SCRIPT>';
			echo "<SCRIPT>window.location.href='listado_concesionarios.php';</SCRIPT>";
	}
	else
	{
	  		echo '<SCRIPT>alert("Concesionario no Modificado");</SCRIPT>';
            echo "<SCRIPT>window.location.href='listado_concesionarios.php';</SCRIPT>";
	}
}

/*$objZona= new zona();
$buscarEstados = $objZona->buscarEstados($listarBeneficiario[36]);
$buscarMunicipio = $objZona->buscarMunicipios($listarBeneficiario[37],$listarBeneficiario[36]);
$buscarParroquia = $objZona->buscarParroquias($listarBeneficiario[38],$listarBeneficiario[36],$listarBeneficiario[37]);*/

?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
      <script type="text/javascript" src="../controlador/jquery.js"></script>
    <script type="text/javascript" src="../controlador/jquery-ui.js"></script>
    <script type="text/javascript" src="../controlador/jquery.idle-timer.js"></script>
<SCRIPT LANGUAGE='JavaScript'>
var txt=" Registro de Beneficiario del Sistema de Vehiculos SUVINCA ";
var espera=100;
var refresco=null;
function rotulo_title( ) {
document.title=txt;
txt=txt.substring(1,txt.length
)+txt.charAt(0);
refresco=setTimeout("rotulo_title( )",espera);}
//rotulo_title( );
</SCRIPT>

<script type="text/javascript">
$(document.form1).ready(function(){
	cargar_paises();
	$("#pais").change(function(){dependencia_estado();});
	$("#estado").change(function(){dependencia_ciudad();});
	$("#estado").attr("disabled",true);
	$("#ciudad").attr("disabled",true);
});

function cargar_paises()
{

	$.get("../modelos/cargar-paises.php", function(resultado){
		if(resultado == false)
		{
			alert("Error: Seleccione un estado");
		}
		else
		{
			$('#pais').append(resultado);
		}
	});
}
function dependencia_estado()
{
	var code = $("#pais").val();
	$.get("../modelos/dependencia-estado.php", { code: code },
		function(resultado)
		{
			if(resultado == false)
			{
				alert("Error: Seleccione un municipio");
			}
			else
			{
				$("#estado").attr("disabled",false);
				document.getElementById("estado").options.length=1;
				$('#estado').append(resultado);
			}
		}

	);
}

function dependencia_ciudad()
{
	var code1 = $("#pais").val();
	var code = $("#estado").val();
	$.get("../modelos/dependencia-ciudades.php?", { code: code , code1: code1 },function(resultado){
		if(resultado == false)
		{
			alert("Error: Seleccione una parroquia");
		}
		else
		{
			$("#ciudad").attr("disabled",false);
			document.getElementById("ciudad").options.length=1;
			$('#ciudad').append(resultado);
		}
	});

}

</script>

<script>

function validarCaract(dato){
var letras_mayusculas="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ ";

if (document.form1.nombre.value.length==0){
    alert("Debe Ingresar el Nombre del Concesionario");
    document.form1.nombre.focus()
    return (false);
 }else
 {
   var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   if (!filter.test(document.form1.nombre.value)) {
   alert('Carácteres no válidos en el Nombre del Concesionario');
   document.form1.nombre.focus();
   return (false);}
 }

if (document.form1.direccion.value.length==0){
    alert("Debe ingresar la direccion");
    document.form1.direccion.focus()
    return (false);
}else
 {
   var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   if (!filter.test(document.form1.direccion.value)) {
   alert('Carácteres no válidos en la Dirección');
   document.form1.direccion.focus();
   return (false);}
 }

if (document.form1.codtlf1.value.length!=4){
  alert("Debe Ingresar un codigo de area de 4 digitos");
  document.form1.codtlf1.focus()
  return (false);
  }

if (document.form1.tlf1.value.length!=7){
  alert("Debe Ingresar un Numero de Télefono de 7 digitos");
  document.form1.tlf1.focus()
  return (false);
  }

if (document.form1.direccion.value.length>500){
  alert("Supero la cantidad maxima de 500 carácteres en el campo Dirección");
  document.form1.deslab.focus()
  return (false);
  }

 document.form1.indReg.value = dato;
 document.form1.submit();

}

	function popup(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=400,height=400');");
	}
    </script>
  </head>
  <body class="pagina">
   <TABLE class="completo">
    <TR>
     <TD class="cuerpo">
      <DIV class="nivel1">
       <DIV class="nivel2">
<!--  Contenido Principal         -->
  <form id="form1" name="form1" method="post" action="">
  <table class="formulario" width="822" border="0" align="center" >
      <tr>
        <td colspan="4" class="cabecera"><? echo $accion; ?>  Datos del Concesionario </td>
      </tr>
      <tr>
        <td class="categoria">RIF:</td>
        <td class="dato" colspan="3">
         <input name="rif" type ="text" id="rif" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarConcesionario[1];?>" size="12" maxlength="10" />
        </td>
      </tr>
      <tr>
        <td class="categoria">Nombre:</td>
        <td class="dato">
         <input name="nombre" type ="text" id="nombre" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarConcesionario[2];?>" size="30" maxlength="30" />
        </td>
      </tr>
      <tr>
        <td class="categoria">Dirección:</td>
        <td class="dato" colspan="3">
         <textarea name="direccion" cols="60" rows="2" id="direccion"  onblur="javascript:this.value=this.value.toUpperCase()" ><?php if($ban==1)  echo $listarConcesionario[3];?></textarea>
        </td>
      </tr>
      <tr>
        <td class="categoria"> Tel&eacute;fono 1:</td>
        <td class="dato" >
          <input name="codtlf1" type="text" id="codtlf1" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo substr($listarConcesionario[4],0,4);?>" size="4" maxlength="4" />
          <input name="tlf1" type ="text" id="tlf1" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo substr($listarConcesionario[4],4,8);?>" size="7" maxlength="7" />
       </td>
        <td class="categoria"> Tel&eacute;fono 2:</td>
        <td class="dato" >
          <input name="codtlf2" type="text" id="codtlf2"  onkeypress="return acessoNumerico(event)" value="<?php if($ban==1 )  echo substr($listarConcesionario[5],0,4);?>" size="4" maxlength="4" />
          <input name="tlf2" type ="text" id="tlf2" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo substr($listarConcesionario[5],4,8);?>" size="7" maxlength="7" />
       </td>

       <tr>
        <td height="22" colspan="4">
            <div align="center">  </div>
         </td>
       </tr>
      <tr>
        <td height="22" colspan="4">
          <div align="center">
           <input type="hidden" name="indReg" >
           <?php if (!$listarConcesionario[$i]) { ?>
            <input name="agregar" type="button" id="agregar" onclick="validarCaract(1); return false" value="Agregar" />
            <?php } if ($listarConcesionario[$i]) { ?>
               <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Modificar" />
               <input name="listar" type="button" id="listar" onclick="window.location.href='listado_concesionarios.php'" value="Listar" />
            <?php } ?>
         </div>
     </tr>
 </table>
    </form>
<!--  FIN Contenido Principal         -->
       </DIV>
      </DIV>
     </TD>
    </TR>
   </TABLE>
  </body>
</html>