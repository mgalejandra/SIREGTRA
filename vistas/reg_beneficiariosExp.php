<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/beneficiario.php');
require('../modelos/zona.php');
require('../modelos/pago.php');

$objBeneficiario = new beneficiario();
$objPago    = new pago();
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(2,3,4);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];
$numrifS=$_POST['numrifS'];


$ban=0;
//echo $ban;

if ($ban==0){
    $_SESSION['nac']=null;
      $_SESSION['numrif']=null;
      $_SESSION['digrif']=null;
      $_SESSION['banco']=null;
}
$indErr = false;

  $listarBancos=$objPago->listarBancos(3);

  $nac=$_POST['nac'];
  $tamaño=strlen($_POST['numrifSS']);
 // echo $tamaño.'aqui';
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
  $banco=$_POST['banco'];
  $riflab=$_POST['riflab'];
  $deslab=$_POST['deslab'];
  $correo=$_POST['correo'];
  //$ced=$_POST['ced'];



if ($_GET['idbenefi']) $idbenefi=$_GET['idbenefi'];
else
$idbenefi=$rif;

  $datos = array($rif,$nom1,$nom2,$ape1,$ape2,$nomorg,$nomcom,$calle,$urb,$casa,$piso,$apart,$dist,$tlf1,$tlf2,$obspro,$estado,
                 $municipio,$parroquia,$tipo,$sexo,$fecnac,$ced,$banco,$correo,$riflab,$deslab);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

if ($idbenefi and $indReg!=2 and $indReg!=4 and $indReg!='S')  {
  $ban=1;
  $i=0;

  //echo 'entro1'.$indReg;
  $listarBeneficiario=$objBeneficiario->listarBeneficiario($idbenefi,$nomcom,$banco,'','','','1');

}

if ($indReg==1){
  //echo 'entro: '.count($datos);}
  $listarBeneficiario=$objBeneficiario->listarBeneficiario($idbenefi,$nomcom,$banco,'','','','1');

   if ($listarBeneficiario[0]=''){
         $ban=1;
         $i=0;
       echo "<script>alert('Esta CI/RIF: ".$listarBeneficiario[0]." pertenece a : ".$listarBeneficiario[6]."');</script>";
   }else
   {
     $registro = $objBeneficiario->registrarBeneficiario($datos);
     //echo '<SCRIPT> window.open("../vistas/reportes/pdf_beneficiariosExp.php?rif='.$rif.' " , "ventana1" , "width=600,height=600,scrollbars=NO") </SCRIPT>';
  }

  if ($registro)  {
     echo "<script>alert('Transferencia  Registrada, Registre el estatus Devolucion en caso de ser necesario');</script>";
  //   echo "<SCRIPT>window.location.href='listado_beneficiarios.php';</SCRIPT>";
    //  $listarBeneficiario=$objBeneficiario->listarBeneficiario($idbenefi,$nomcom,$banco,'','');
      $listarBeneficiario=$objBeneficiario->listarBeneficiario($idbenefi,$nomcom,$banco,'','','','1');
  }
}

if ($indReg==2){
  //echo 'entro: '.count($datos);
  $modificar = $objBeneficiario->modificarBeneficiario($idbenefi,$datos);
  if ($modificar)   {
       echo "<script>alert('Datos del Ordenante Modificado');</script>";
     echo "<SCRIPT>window.location.href='listado_beneficiariosExp.php';</SCRIPT>";

    $_SESSION['nac']=null;
      $_SESSION['numrif']=null;
      $_SESSION['digrif']=null;
      $_SESSION['banco']=null;
  }
}

if($indReg == 4){
  //echo 'entro2';
  $ban=1;
  $i=0;
  $_SESSION['nac']=$_POST['nac'];
    $_SESSION['numrif'] =str_pad($_POST['numrif'],8,'0',STR_PAD_LEFT) ;
    $_SESSION['digrif']=str_pad($_POST['digrif'],1,'0',STR_PAD_LEFT) ;
    $_SESSION['banco']=$_POST['banco'];
    $rif=$_SESSION['nac'].$_SESSION['numrif'].$_SESSION['digrif'];
  $listarBeneficiario=$objBeneficiario->listarBeneficiario($rif,'','');
  if ($listarBeneficiario)   {
       echo "<script>alert('El Beneficiario ya se encuentra Registrado');</script>";
  }

}

$_SESSION['numben'] = $listarBeneficiario[$i+19].$listarBeneficiario[$i+20].$listarBeneficiario[$i+21];

$objZona= new zona();
$buscarEstados = $objZona->buscarEstados($listarBeneficiario[36]);
$buscarMunicipio = $objZona->buscarMunicipios($listarBeneficiario[37],$listarBeneficiario[36]);
$buscarParroquia = $objZona->buscarParroquias($listarBeneficiario[38],$listarBeneficiario[36],$listarBeneficiario[37]);

//$listarBeneficiario[$i+40]
if ($listarBeneficiario[$i+40]) $datoslistarBancos=$objPago->listarBancos(4,$listarBeneficiario[$i+40]);
if ($_SESSION['banco'] and !$listarBeneficiario[$i+40]) $datoslistarBancos=$objPago->listarBancos(4,$_SESSION['banco']);



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
      alert("Error: Seleccione un Banco");
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
        alert("Error: Seleccione un Estatus");
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
      alert("Error: Seleccione una Sucursal");
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
//function validarCaract(dato,tiene){ if ((document.form1.banco.value.length==0) && (tiene==1)){
function validarCaract(dato){
var letras_mayusculas="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ ";

    

    if (document.form1.nac.value.length==0){
    alert("Seleccione Nacionalidad o Figura");
    document.form1.nac.focus()
    return (false);
    }


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
    

if (document.form1.fecnac.value.length==0){
  alert("Debe Ingresar la fecha del Oficio");
  document.form1.fecnac.focus()
  return (false);
    }

 if (document.form1.correo.value.length==0){
  alert("Debe Ingresar el Nro del Oficio");
  document.form1.correo.focus()
  return (false);
  }


if (document.form1.sexo.value.length==0){
  alert("Debe seleccionar Tipo de Cuenta");
  document.form1.sexo.focus()
  return (false);
  }

if (document.form1.nom1.value.length==0){
    alert("Debe Ingresar el  Nombre, Apellido o Razon Social");
    document.form1.nom1.focus()
    return (false);
 }else
 {
   var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   if (!filter.test(document.form1.nom1.value)) {
   alert('Carácteres no válidos en elDebe Ingresar el  Nombre, Apellido o Razon Social');
   document.form1.nomb1.focus();
   return (false);}
 }

/*
if (document.form1.nom2.value.length==0){
  alert("Debe Ingresar el Nro de la Nota de Debito");
  document.form1.nom2.focus()
  return (false);
  }

if (document.form1.ape1.value.length<=19){
    alert("Debe Ingresar 20 digitos en el  Numero de Cuenta");
    document.form1.ape1.focus()
    return (false);
    }*/


opciones = document.getElementsByName("tipo");
var seleccionado = false;
for(var i=0; i<opciones.length; i++) {
  if(opciones[i].checked)
  {
    seleccionado = true;break;
  }
}

if (seleccionado==false){
  alert("Debe seleccionar el tipo de Ordenante");
  return (false);
  }



if (document.form1.riflab.value.length ==0){
    alert("Debe Ingresar un N° RIF ó CI");
    document.form1.riflab.focus()
    return (false);
    }

   // if (document.form1.riflab.value.substring(0,1)!='J' && document.form1.riflab.value.substring(0,1)!='G'){
   // alert("Debe Ingresar un numero de rif Laboral: Juridico ó gubernamental");
   // document.form1.riflab.focus()
   // return (false);
   // }
/*
    if (document.form1.riflab.value.substring(1,10)==(document.form1.numrif.value+document.form1.digrif.value)){
    alert("Debe Ingresar un N° RIF ó CI DIFERNTE AL DEL ORDENANTE");
    document.form1.riflab.focus()
    return (false);
    }*/


if (document.form1.deslab.value.length==0){
    alert("Debe Ingresar el  Nombre, Apellido o Razon Social Beneficiario");
    document.form1.deslab.focus()
    return (false);
    }

    if (document.form1.calle.value.length<=19){
    alert("Debe Ingresar 20 digitos en el  Numero de Cuenta Beneficiario");
    document.form1.calle.focus()
    return (false);
    }





if (document.form1.urb.value.length==0){
  alert("Debe Ingresar el Monto de la Transferencia");
  document.form1.urb.focus()
  return (false);
  }



if (document.form1.casa.value.length==0){
    alert("Debe Ingresar el Nro Doc/Referencia");
    document.form1.casa.focus()
    return (false);
    }


if (document.form1.piso.value.length==0){
    alert("Debe Ingresar la Fecha de la Ejecucion");
    document.form1.piso.focus()
    return (false);
    }

if (document.form1.pais.value.length==0){
 alert("Debe seleccionar un Banco");
 document.form1.pais.focus()
return (false);
 }

 if (document.form1.estado.value.length==0){
 alert("Debe seleccionar un Estatus");
 document.form1.estado.focus()
return (false);
 }

 if (document.form1.ciudad.value.length==0){
 alert("Debe seleccionar una Sucursal");
 document.form1.cuidad.focus()
return (false);
 }


/*

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
*/






if (document.form1.obspro.value.length>100){
  alert("Supero la cantidad maxima de 100 carácteres en el campo Motivo de Transferencia");
  document.form1.obspro.focus()
  return (false);
  }


if (document.form1.obspro.value.length<5){
  alert("la cantidad de caracteres minimo para el  Motivo de Transferencia es 5");
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

  function enviarS(dato){
    //alert('entro');
    document.form1.indReg.value = dato;
    document.form1.submit();
    }

  function enviarDatos(dato){
  //  alert('entro');
  //  document.form1.numrif.value='';
    document.form1.indReg.value = dato;
    document.form1.submit();
    }
    // La función devuelve el numero formateado

function MASK(form, n, mask, format) {
  if (format == "undefined") format = false;
  if (format || NUM(n)) {
    dec = 0, point = 0;
    x = mask.indexOf(".")+1;
    if (x) { dec = mask.length - x; }

    if (dec) {
      n = NUM(n, dec)+"";
      x = n.indexOf(".")+1;
      if (x) { point = n.length - x; } else { n += "."; }
    } else {
      n = NUM(n, 0)+"";
    } 
    for (var x = point; x < dec ; x++) {
      n += "0";
    }
    x = n.length, y = mask.length, XMASK = "";
    while ( x || y ) {
      if ( x ) {
        while ( y && "#0.".indexOf(mask.charAt(y-1)) == -1 ) {
          if ( n.charAt(x-1) != "-")
            XMASK = mask.charAt(y-1) + XMASK;
          y--;
        }
        XMASK = n.charAt(x-1) + XMASK, x--;
      } else if ( y && "Bsf0".indexOf(mask.charAt(y-1))+1 ) {
        XMASK = mask.charAt(y-1) + XMASK;
      }
      if ( y ) { y-- }
    }
  } else {
     XMASK="";
  }
  if (form) { 
    form.value = XMASK;
    if (NUM(n)<0) {
      form.style.color="#FF0000";
    } else {
      form.style.color="#000000";
    }
  }
  return XMASK;
}

// Convierte una cadena alfanumérica a numérica (incluyendo formulas aritméticas)
//
// s   = cadena a ser convertida a numérica
// dec = numero de decimales a redondear
//
// La función devuelve el numero redondeado

function NUM(s, dec) {
  for (var s = s+"", num = "", x = 0 ; x < s.length ; x++) {
    c = s.charAt(x);
    if (".-+/*".indexOf(c)+1 || c != " " && !isNaN(c)) { num+=c; }
  }
  if (isNaN(num)) { num = eval(num); }
  if (num == "")  { num=0; } else { num = parseFloat(num); }
  if (dec != undefined) {
    r=.5; if (num<0) r=-r;
    e=Math.pow(10, (dec>0) ? dec : 0 );
    return parseInt(num*e+r) / e;
  } else {
    return num;
  }
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
  <?php  if(count($listarBeneficiario)==0){?>
     <!-- <tr>
        <td colspan="4" class="cabecera">Consultar Cedula con el Seniat </td>
      </tr>
      <tr>
        <td class="categoria"> Cédula:</td>
        <td class="dato">
              <input name="numrifS" type="text" id="numrifS" onkeypress="return acessoNumerico(event)" value="" size="12" maxlength="8" />
              <input name="buscar" type="button" id="buscar" onclick="enviarDatos('S')" value="Buscar" />
        </td>
      </tr>-->
        <?php } ?>
      <tr>
        <td colspan="4" class="cabecera">Registrar  Datos del Ordenante </td>
      </tr>
        <tr>
        <td class="categoria">*RIF / CI:</td>
        <td class="dato" >
        <select name="nac" size="1" id="nac">
    <?php if($ban==1)  echo " <option value=".$listarBeneficiario[$i+19].">".$listarBeneficiario[$i+19]."</option>";?>
          <option value="V">V</option>
          <option value="J">J</option>
          <option value="G">G</option>
          <option value="P">P</option>
          <option value="C">C</option>
          

          </select>
          -
          <input name="numrif" type="text" id="numrif" onkeypress="return acessoNumerico(event)" value="<?php  if($ban==1) echo $listarBeneficiario[$i+20];?>" size="12" maxlength="8" />
          -
          <input name="digrif" type="text" class="Estilo1" id="digrif" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarBeneficiario[$i+21];?>"" size="6" maxlength="1" acessonumerico(event)="acessoNumerico(event)" />

           </tr>
      

    <td class="categoria">*Fecha del Oficio:</td>
        <td class="dato">

         <input name="fecnac" type="text" id="fecnac" size="10"  maxlength="10" date_format="dd/MM/yy"
         onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)"value="<?php if($ban==1) echo $listarBeneficiario[$i+39]; if($datosSaime[6]) echo $datosSaime[6];?>"/>
           <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecnac',document.forms[0].fecnac.value)" />
        </td>


 </td>
      <tr>
        <td class="categoria">*Nro del Oficio:</td>
        <td class="dato" colspan='3'>
          <input name="correo" type="text" id="correo" value="<?php if($ban==1)  echo $listarBeneficiario[$i+41];?>" size="30" maxlength="50"/>
       </td>
      </tr>
          <td class="categoria">*Tipo de Cuenta:</td>
        <td class="dato">
          <select name="sexo" size="1" id="sexo">
          <?php if($ban==1)  echo " <option value=".$listarBeneficiario[$i+33].">".$listarBeneficiario[$i+34]."</option>";?>
          <option value="A">CORRIENTE</option>
          <option value="C">AHORROS</option>
          </select>
        </td>



      </tr>
      <tr>
        <td class="categoria">*Nombre y Apellido/ Raz&oacute;n Social:</td>
        <td class="dato">
         <input name="nom1" type="text" id="nom1" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarBeneficiario[$i+1]; if($nom1_) if($seni)  echo $nom1_;?>" size="30" maxlength="30" />
        </td>
         <td class="categoria">Nro de Nota de Debito:</td>
        <td class="dato">
         <input name="nom2" type="text" id="nom2" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarBeneficiario[$i+2]; if($nom2_)  if($seni)  echo $nom2_;?>" size="30" maxlength="30"/>
        </td>



        </td>
      </tr>
      <tr>
        <td class="categoria">*Numero de Cuenta Ordenante :</td>
        <td class="dato" >
          <input name="ape1" type="text" id="ape1" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listarBeneficiario[$i+3]; if($ape1_)  if($seni)  echo $ape1_;?>" size="20" maxlength="20"/>
       </td>
        <td class="categoria">Persona Contacto :</td>
        <td class="dato" >
          <input name="ape2" type="text" id="ape2"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarBeneficiario[$i+4]; if($ape2_)  if($seni) echo $ape2_;?>" size="30" maxlength="30"/>
       </td>
      </tr>

      <tr>

      <td colspan="4" class="cabecera">Tipo de Ordenante</td>
      </tr>
        <tr>
        <td class="categoria">
             <label>CLIENTE</label>
        </td>
        <td class="dato" >
        <input type="radio" name="tipo" id="tipo" value="1" <?php if($ban==1 and  $listarBeneficiario[$i+35]==1)  echo "checked= 'true'"; ?> />
       </td>
       <td class="categoria">
             <label>NO CLIENTE</label>
        </td>
        <td class="dato" >
        <input type="radio" name="tipo" id="tipo"  value="2" <?php if($ban==1 and  $listarBeneficiario[$i+35]==2)  echo "checked= 'true'"; ?> />
       </td>
      </tr>
              <tr>
        <td class="categoria">
             <label>EMPLEADO</label>
        </td>
        <td class="dato" >
        <input type="radio" name="tipo" id="tipo"  value="3" <?php if($ban==1 and  $listarBeneficiario[$i+35]==3)  echo "checked= 'true'"; ?> />
       </td>
       
      </tr>
       
       <tr>
        <td class="categoria">
             <label>OTROS</label>
        </td>
        <td class="dato" >
        <input type="radio" name="tipo" id="tipo"  value="7" <?php if($ban==1 and  $listarBeneficiario[$i+35]==7)  echo "checked= 'true'"; ?> />
       </td>
       <td class="categoria">
        <label></label>      <tr>
        <td colspan="4" class="cabecera">Datos de la Transferencia del Beneficiario</td>
      </tr>
            <tr>
        <td class="categoria">*RIF / CI:</td>
        <td class="dato" colspan="3">
         <input name="riflab" type ="text" id="riflab" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarBeneficiario[$i+42];?>" size="12" maxlength="10" />
        </td>
      </tr>
      <tr>
        <td class="categoria">*Nombre y Apellido/ Raz&oacute;n Social Beneficiario:</td>
        <td class="dato" colspan="3">
          <input name="deslab" type="text" id="deslab" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarBeneficiario[$i+43]; if($deslab) if($seni)  echo $deslab;?>" size="30" maxlength="30" />
          
         
      </tr>

  <tr>
       
      </tr>
      <tr>
        <td class="categoria">*Numero de Cuenta Beneficiario:</td>
        <td class="dato">
            <input name="calle" type="text" id="calle" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listarBeneficiario[$i+3]; if($ape1_)  if($seni)  echo $calle;?>" size="20" maxlength="20"/>
        
        </td>



        <td class="categoria">*Monto:</td>
        <td class="dato">
          <input name="urb" type ="text" id="urb" onchange="MASK(this,this.value,'-Bsf ##,###,##0.00',1)"value="<?php if($ban==1)  echo $listarBeneficiario[$i+8];?>" size="30" maxlength="30" />
        </td>
      </tr>
      <tr>
        <td class="categoria">*Nro Doc/Referencia:</td>
        <td class="dato" >
          <input name="casa" type ="text" id="casa" value="<?php if($ban==1)  echo $listarBeneficiario[$i+9];?>"   onkeypress="return acessoNumerico(event)" size="20" maxlength="20" />
       </td>
        <td class="categoria">*Fecha de Ejecucion:</td>
        <td class="dato" >
             <input type="date" name="piso"
         onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)"value="<?php if($ban==1) echo $listarBeneficiario[$i+10]; if($datosSaime[6]) echo $datosSaime[6];?>"/>
             
       </td>
      </tr>
   
      <TR>
    <TD width="175" class="categoria"><strong>*Banco:<?php echo $listarBeneficiario[$i+38];?></strong></TD>
    <TD colspan="3" class="categoria"><div align="left"><span class="dato">
     <select id="pais" name="pais">
            <option value="<?php echo $listarBeneficiario[$i+36]; ?>"><?php echo $buscarEstados[1]; ?></option>
            <option value="0">Selecciona Uno...</option>
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
      <tr>
        <td class="categoria"> Tlf/Celular 1:</td>
        <td class="dato" >

          <input name="codtlf1" type="text" id="codtlf1" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listarBeneficiario[$i+22];?>" size="6" maxlength="4" />
          <input name="tlf1" type ="text" id="tlf1" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listarBeneficiario[$i+23];?>" size="15" maxlength="20" />
       </td>
        <td class="categoria">Tlf/celular 2:</td>
        <td class="dato" >
          <input name="codtlf2" type="text" id="codtlf2"  onkeypress="return acessoNumerico(event)" value="<?php if($ban==1 )  echo $listarBeneficiario[$i+24];?>" size="6" maxlength="4" />
          <input name="tlf2" type ="text" id="tlf2" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo $listarBeneficiario[$i+25];?>" size="15" maxlength="20" />
       </td>
      </tr>



        <tr>
       
       <td class="categoria">
        <label></label>
        </td>
        <td class="dato" >
       </td>
      </tr>
       <tr>
        <td class="categoria">*Motivo de la Transferencia:</td>
        <td class="dato" colspan='3'>
          <textarea name="obspro" cols="60" rows="2" id="obspro"  onblur="javascript:this.value=this.value.toUpperCase()" ><?php if($ban==1)  echo $listarBeneficiario[$i+16];?> </textarea>
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
            <INPUT type="button" id="regDoc" value="Reg. Devolucion" onclick="popup('regDocumentos.php?ci=<?php echo $listarBeneficiario[$i]; ?>&tip=<?php echo $listarBeneficiario[$i+35]; ?>')">
          
            <!--  <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Modificar" />
            <?php } ?>-->
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