<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/beneficiario.php');
require('../modelos/zona.php');

$objBeneficiario = new beneficiario();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(2,3,4);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];

$ban=0;
$indErr = false;



  $nac=$_POST['nac'];
  $tamaño=strlen($_POST['numrifSS']);
//
  if ($tamaño==7)
  $numrifSS=str_pad($_POST['numrifSS'],7,'0',STR_PAD_LEFT) ;
  else
  $numrifSS=str_pad($_POST['numrifSS'],8,'0',STR_PAD_LEFT) ;

  if($_POST['numrifSS']=='') $numrifSS='';

  $numrif=str_pad($_POST['numrif'],8,'0',STR_PAD_LEFT) ;
  $digrif=str_pad($_POST['digrif'],1,'0',STR_PAD_LEFT) ;
  $ced=$numrif;
  $rif=$nac.$numrif.$digrif;
  $nom1=$_POST['nom1'];
  $nom2=$_POST['nom2'];
  $ape1=$_POST['ape1'];
  $ape2=$_POST['ape2'];
  $nomorg=$_POST['nomorg'];
  $nomcom=$nom1." ".$nom2." ".$ape1." ".$ape2;
  if (strlen($nomorg)>15){ $nomcom=$nomorg;}
  $calle=$_POST['calle'];
  $urb=$_POST['urb'];
  $casa=$_POST['casa'];
  $piso=$_POST['piso'];
  $apart=$_POST['apart'];
  $dist=$_POST['dist'];
  $estado=$_POST['pais'];
  $municipio=$_POST['estado'];
  $parroquia=$_POST['ciudad'];
  $tlf1=$_POST['codtlf1'].$_POST['tlf1'];
  $tlf2=$_POST['codtlf2'].$_POST['tlf2'];
  $obspro=$_POST['obspro'];
  $tipo=$_POST['tipo'];
  $sexo=$_POST['sexo'];
  $fecnac=$_POST['fecnac'];
  $correo=$_POST['correo'];
  $riflab=$_POST['riflab'];
  $deslab=$_POST['deslab'];
//echo $correo;
  //$ced=$_POST['ced'];


if ($_GET['idbenefi']) $idbenefi=$_GET['idbenefi'];
else
$idbenefi=$rif;

  $datos = array($rif,$nom1,$nom2,$ape1,$ape2,$nomorg,$nomcom,$calle,$urb,$casa,$piso,$apart,$dist,$tlf1,$tlf2,$obspro,$estado,
                 $municipio,$parroquia,$tipo,$sexo,$fecnac,$ced,'',$correo,$riflab,$deslab);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

if ($idbenefi and $indReg!=2 and $indReg!='S' and $indReg!=4)  {
	$ban=1;
	$i=0;
	//echo 'entro';
	$listarBeneficiario=$objBeneficiario->listarBeneficiario($idbenefi,'','','','');
}

if ($indReg){
	//echo 'entro: '.count($datos);}
	$listarBeneficiario=$objBeneficiario->listarBeneficiario($idbenefi,'','','','');
   if ($listarBeneficiario[0]!=''){
   	     $ban=1;
   	     $i=0;
	     echo "<script>alert('Esta CI/RIF: ".$listarBeneficiario[0]." pertenece a : ".$listarBeneficiario[6]."');</script>";
   }else
   {
   	 $registro = $objBeneficiario->registrarBeneficiario($datos);

  }

	if ($registro)  {
		 echo "<script>alert('Beneficiario Registrado, Registre la Documentación');</script>";
	//	 echo "<SCRIPT>window.location.href='listado_beneficiarios.php';</SCRIPT>";
	  // $listarBeneficiario=$objBeneficiario->listarBeneficiario($idbenefi,'','','','');
	     $listarBeneficiario=$objBeneficiario->listarBeneficiario($idbenefi,'','','','','','1');
	}
}

if ($indReg){
	//echo 'entro: '.count($datos);
	$modificar = $objBeneficiario->modificarBeneficiario($idbenefi,$datos);
	if ($modificar)   {
	     echo "<script>alert('Beneficiario Modificado');</script>";
		 //echo "<SCRIPT>window.location.href='listado_beneficiarios.php';</SCRIPT>";
		 echo "<SCRIPT>window.location.href='listado_beneficiariosExp.php';</SCRIPT>";
	}
}

$_SESSION['numben'] = $listarBeneficiario[$i+19].$listarBeneficiario[$i+20].$listarBeneficiario[$i+21];

$objZona= new zona();
$buscarEstados = $objZona->buscarEstados($listarBeneficiario[36]);
$buscarMunicipio = $objZona->buscarMunicipios($listarBeneficiario[37],$listarBeneficiario[36]);
$buscarParroquia = $objZona->buscarParroquias($listarBeneficiario[38],$listarBeneficiario[36],$listarBeneficiario[37]);


///////////////buscar en seniat

if($indReg=='S' ){

                    $datosSaime=$objBeneficiario->consultarSaime($numrifSS);
					$contenido=file_get_contents("http://contribuyente.seniat.gob.ve/BuscaRif/BuscaRif.jsp?p_cedula=$numrifSS");
					$contenido1=  explode("<!-- VISUALIZAR RIF -->", $contenido);
					$contenido2=  explode('<b><font face="Verdana" size="2">', $contenido1[1]);
					$contenido3=  explode('&nbsp;', $contenido2[1]);
					$contenido4=  explode('</b></font>', $contenido3[1]);

					$cedula=$contenido3[0]; //cedula
					if($cedula) $seni=true; else $seni=false;
					$nombrecompleto= $contenido4[0]; //nombre

					$nombreSeparado=  explode(' ',$nombrecompleto);


					$nacs=substr($cedula,0,1);
					$cedu=substr($cedula,1,8);
					$dig=substr($cedula,9,1);

					$nom1_=$nombreSeparado[0];
					$nom2_=$nombreSeparado[1];
					$ape1_=$nombreSeparado[2];
					$ape2_=$nombreSeparado[3];

					if(count($nombreSeparado)==2)
					{
						$nom1_=$nombreSeparado[0];
						$ape1_=$nombreSeparado[1];
						$nom2_='';
						$ape2_='';
					}

}else  $seni=false;
//////////////////fin de buscar seniat
?>
<!DOCTYPE HTML PUBLIC >
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


if (document.form1.numrif.value.length==0){
    alert("Debe Ingresar un N° RIF ó CI");
    document.form1.numrif.focus()
    return (false);
    }

if (document.form1.numrif.value.length<=6){
    alert("Debe Ingresar mínimo 7 dígitos");
    document.form1.numrif.focus()
    return (false);
    }


    if (document.form1.nac.value.length==0){
    alert("Seleccione Nacionalidad o Figura");
    document.form1.nac.focus()
    return (false);
    }


    if (document.form1.digrif.value.length==0){
  alert("Debe Ingresar el último Dígito del RIF");
  document.form1.digrif.focus()
  return (false);
  }

 if (document.form1.fecnac.value.length==0){
  alert("Debe Ingresar la fecha de Nacimiento");
  document.form1.fecnac.focus()
  return (false);
                                         }



if (document.form1.sexo.value.length==0){
  alert("Debe seleccionar el Sexo");
  document.form1.sexo.focus()
  return (false);
  }

if (document.form1.nom1.value.length==0){
    alert("Debe Ingresar el Primer Nombre del Propietario");
    document.form1.nom1.focus()
    return (false);
 }else
 {
   var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   if (!filter.test(document.form1.nom1.value)) {
   alert('Carácteres no válidos en el Primer nombre');
   document.form1.nomb1.focus();
   return (false);}
 }

if (document.form1.nom2.value.length > 0){
   var texto = document.form1.nom2.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Carácteres no válidos en el segundo nombre');
      document.form1.nomb2.focus();
      return (false);
    }
   // return ind;
 }

if (document.form1.nac.value=='V'){
if (document.form1.ape1.value.length==0){
    alert("Debe Ingresar el Primer Apellido del Propietario");
    document.form1.ape1.focus()
    return (false);
 }else
 {
   var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   if (!filter.test(document.form1.ape1.value)) {
   alert('Carácteres no válidos en el Primer apellido');
   document.form1.ape1.focus();
   return (false);}
 }
}

if (document.form1.ape2.value.length > 0){
    var texto = document.form1.ape2.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Caracteres no válidos en el segundo Apellido');
      document.form1.ape2.focus();
      return (false);
    }
   // return ind;
 }
if (document.form1.riflab.value.length < 10){
    alert("Debe Ingresar un numero de rif Laboral valido de 10 caracteres");
    document.form1.riflab.focus()
    return (false);
    }

    if (document.form1.riflab.value.substring(0,1)!='J' && document.form1.riflab.value.substring(0,1)!='G'){
    alert("Debe Ingresar un numero de rif Laboral: Juridico ó gubernamental");
    document.form1.riflab.focus()
    return (false);
    }

    if (document.form1.riflab.value.substring(1,10)==(document.form1.numrif.value+document.form1.digrif.value)){
    alert("Debe Ingresar un numero de rif Laboral valido, no es el rif del beneficiario");
    document.form1.riflab.focus()
    return (false);
    }


if (document.form1.deslab.value.length==0){
    alert("Debe Ingresar el nombre de la institucion o empresa donde labora");
    document.form1.deslab.focus()
    return (false);
    }

if (document.form1.calle.value.length==0){
    alert("Debe Ingresar la Calle/avenida/plaza/esquina de la dirección del propietario");
    document.form1.calle.focus()
    return (false);
    }
if (document.form1.calle.value.length > 0){
    var texto = document.form1.calle.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Caracteres no válidos en el campo calle');
      document.form1.calle.focus();
      return (false);
    }
   // return ind;
 }


if (document.form1.urb.value.length==0){
  alert("Debe Ingresar la Urbanización o Barrio de la dirección del propietario");
  document.form1.urb.focus()
  return (false);
  }

if (document.form1.urb.value.length > 0){
    var texto = document.form1.urb.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
   }
 if(!ind){
      alert('Caracteres no validos en el campo Urbanizacion');
      document.form1.urb.focus();
      return (false);
    }
   // return ind;
 }


if (document.form1.casa.value.length==0){
    alert("Debe Ingresar el Nombre del Edificio/casa/quinta de la dirección del propietario");
    document.form1.casa.focus()
    return (false);
    }

if (document.form1.casa.value.length > 0){
    var texto = document.form1.casa.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Caracteres no válidos en el campo Casa');
      document.form1.casa.focus();
      return (false);
    }
   // return ind;
 }

if (document.form1.apart.value.length > 0){
    var texto = document.form1.apart.value;
    var ind = 1;
    for(i=0; i<texto.length; i++){
      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
         ind = 0;
         break;
      }
    }
    if(!ind){
      alert('Carácteres no válidos en el campo Número de Apartamento');
      document.form1.apart.focus();
      return (false);
    }
   // return ind;
 }


//if (document.form1.ciudad.value.length==0){
//  alert("Debe seleccionar la parroquia");
 // document.form1.pais.focus()
//  return (false);
 // }

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

opciones = document.getElementsByName("tipo");
var seleccionado = false;
for(var i=0; i<opciones.length; i++) {
	if(opciones[i].checked)
	{
		seleccionado = true;break;
	}
}

if (seleccionado==false){
  alert("Debe seleccionar el tipo de Beneficiario");
  return (false);
  }

  if (document.form1.obspro.value.length<15){
  alert("la cantidad de caracteres minimo para la observaciob es 15");
  document.form1.obspro.focus()
  return (false);
  }

if (document.form1.obspro.value.length>100){
  alert("Supero la cantidad maxima de 100 carácteres");
  document.form1.obspro.focus()
  return (false);
  }

  if (document.form1.obspro.value.length>100){
  alert("Supero la cantidad maxima de 100 carácteres en el campo Observacion");
  document.form1.obspro.focus()
  return (false);
  }


if (document.form1.obspro.value.length<15){
  alert("la cantidad de caracteres minimo para la observaciob es 15");
  document.form1.obspro.focus()
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
		function enviarDatos(dato){
	//	alert('entro');
	//  document.form1.numrif.value='';
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
        <td colspan="4" class="cabecera"> Datos del Ordenante </td>
      </tr>
      <tr>
        <td class="categoria">RIF / CI:</td>
        <td class="dato" >
      <select name="nac" size="1" id="nac">
    <?php if($seni)   echo " <option value=".$nacs.">".$nacs."</option>"; ?>
    <?php if($seni=='0' and $ban!=1)   echo " <option value=".$nac.">".$nac."</option>"; ?>
    <?php if($ban==1)  {?>
    <?php if($_SESSION['nac']){?>
    <?php echo " <option value=".$_SESSION['nac'].">".$_SESSION['nac']."</option>";
    }else {?>
    <?php echo " <option value=".$listarBeneficiario[$i+19].">".$listarBeneficiario[$i+19]."</option>";
    }
    }?>
          <option value="V">V</option>
          <option value="V">J</option>
          <option value="E">E</option>
          </select>
          -
                 <input name="numrifSS" type="text" id="numrifSS" onkeypress="return acessoNumerico(event)"
          value="<?php  if($ban==1) {
          			if ($_SESSION['numrifSS'])echo $_SESSION['numrifSS'];
          			else echo $listarBeneficiario[$i+20]; } if($seni) echo $cedu;   else if(!$seni) echo $numrifSS;?>" size="12" maxlength="8"   <?php if($seni)  echo "disabled='true'"; if(!$seni)  {echo 'onblur="enviarDatos('."'S'".')"';  }?>/>
          -
              <input type="hidden" name="numrif"  value="<?php  if($ban==1) {
          			if ($_SESSION['numrif'])echo $_SESSION['numrif'];
          			else echo $listarBeneficiario[$i+20]; } if($seni) echo $cedu;   else if(!$seni) echo $numrifSS; ?>">

          <input  name="digrif" type="text" class="Estilo1" id="digrif" onblur="javascript:this.value=this.value.toUpperCase()"
          value="<?php if($ban==1) {
          if ($_SESSION['digrif']<>'')echo $_SESSION['digrif'];
          else echo $listarBeneficiario[$i+21];} if($seni)  echo $dig; ?>"" size="6" maxlength="1" acessonumerico(event)="acessoNumerico(event)" />

           </tr>
  


 </td>
          



      </tr>
     <tr>
        <td class="categoria">*Nombre y Apellido/ Raz&oacute;n Social:</td>
        <td class="dato">
         <input name="nom1" type="text" id="nom1" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarBeneficiario[$i+1];?>" size="30" maxlength="30" />
        </td>

      </tr>
      <tr>
        <td class="categoria">*Numero de Cuenta Ordenante :</td>
        <td class="dato" colspan='3'>
          <input name="nomorg" type="text" id="nomorg"  value="<?php if($ban==1)  echo $listarBeneficiario[$i+5];?>" size="20" maxlength="20"/>
      
       </td>
      </tr>


  <tr>
        <td colspan="4" class="cabecera">Datos de la Transferencia del Beneficiario</td>
      </tr>
    <tr>
        <td class="categoria">*Numero de Cuenta Beneficiario:</td>
        <td class="dato">
         <input name="calle" type ="text" id="calle" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listarBeneficiario[$i+7];?>" size="20" maxlength="20" />
        </td>
        <td class="categoria">*Nombre y Apellido/ Raz&oacute;n Social Beneficiario:</td>
        <td class="dato">
         <input name="urb" type ="text" id="urb" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarBeneficiario[$i+8];?>" size="30" maxlength="30" />
        </td>
      </tr>
      <tr>
        <td class="categoria">*RIF / CI:</td>
        <td class="dato" >

          <input name="casa" type ="text" id="casa" value="<?php if($ban==1)  echo $listarBeneficiario[$i+9];?>"  onblur="javascript:this.value=this.value.toUpperCase()" size="10" maxlength="10" />
       </td>
        <td class="categoria">*Tipo de Cuenta:</td>
        <td class="dato" >
             <select name="piso" size="1" id="piso">
    <?php if($ban==1)  echo " <option value=".$listarBeneficiario[$i+10].">".$listarBeneficiario[$i+10]."</option>";?>
          <option value="Cuenta Corriente">Cuenta Corriente</option>
          <option value="Cuenta de Ahorros">Cuenta de Ahorros</option>
          <option value="Cuenta de Nomina">Cuenta de Nomina</option>


          </select>
          
       </td>
      </tr>
        <tr>
        <td class="categoria">*Tipo de Transferencia:</td>
        <td class="dato" >
             <select name="apart" size="1" id="apart">
    <?php if($ban==1)  echo " <option value=".$listarBeneficiario[$i+11].">".$listarBeneficiario[$i+11]."</option>";?>
          <option value="Cliente">Cliente</option>
          <option value="No Cliente">No Cliente</option>
          <option value="Empleado">Empleado</option>


          </select>
          

      </tr>
      <TR>
    <TD width="175" class="categoria"><strong>*Banco:<?php echo $listarBeneficiario[$i+38];?></strong></TD>
    <TD colspan="3" class="categoria"><div align="left"><span class="dato">
     <select id="pais" name="pais">
            <option value="<?php echo $listarBeneficiario[$i+36]; ?>"><?php echo $buscarEstados[1]; ?></option>
      
        </select>
    </span> </div></TD>   

  </TR>
    
   <TR>
    <TD width="175" class="categoria"><strong>*Estatus de la Transferencia:</strong></TD>
    <TD colspan="3" class="categoria"><div align="left"><span class="dato">
        <select id="estado" name="estado">
            <option value="<?php echo $listarBeneficiario[$i+37]; ?>"><?php echo $buscarMunicipio[1]; ?></option>
            <option value="0">Selecciona Uno...</option>
        </select>
    </span></div></TD>
  </TR>
    <TR>
    <TD width="175" class="categoria"><strong>*Sucursal:</strong></TD>
    <TD colspan="3" class="categoria"><div align="left"><span class="dato">
        <select id="ciudad" name="ciudad">
            <option value="<?php echo $listarBeneficiario[$i+38]; ?>"><?php echo $buscarParroquia[1]; ?></option>
            <option value="0">Selecciona Uno...</option>
        </select>
    </span></div></TD>
  </TR>
      <t

      <tr>
        <td class="categoria">* Monto:</td>
        <td class="dato" >
      
          <input name="tlf1" type ="text" id="tlf1" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listarBeneficiario[$i+22].$listarBeneficiario[$i+23];?>" size="20" maxlength="20" />
       </td>
        <tr>
        <td class="categoria">*Nro Doc:</td>
        <td class="dato">
         <input name="obspro" type ="text" id="obspro" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listarBeneficiario[$i+16];?>" size="20" maxlength="20" />
        
       </td>
      </tr>
        <td class="categoria">Tlf/celular:</td>
        <td class="dato" >
          <input name="codtlf2" type="text" id="codtlf2"  onkeypress="return acessoNumerico(event)" value="<?php if($ban==1 )  echo $listarBeneficiario[$i+24];?>" size="6" maxlength="4" />
          <input name="tlf2" type ="text" id="tlf2" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listarBeneficiario[$i+25];?>" size="15" maxlength="7" />
       </td>
      </tr>
       <tr>
        <td height="22" colspan="4">
            <div align="center">  </div>
         </td>
       </tr>
      <tr>
        <td height="22" colspan="4">
          <div align="center">
           <input type="hidden" name="indReg" >
           <?php if (!$listarBeneficiario[$i]) { ?>
            <input name="agregar" type="button" id="agregar" onclick="validarCaract(1); return false" value="Agregar" />
            <?php } if ($listarBeneficiario[$i]) { ?>
         
            <?php } ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_beneficiariosExp.php'" value="Listar" />
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
