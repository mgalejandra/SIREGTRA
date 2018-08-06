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
$permitidos = array(2,3,4,5);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];

$ban=0;
$indErr = false;



  $nac=$_POST['nac'];
  $numrif=str_pad($_POST['numrif'],8,'0',STR_PAD_LEFT) ;
  //$digrif=str_pad($_POST['digrif'],1,'0',STR_PAD_LEFT) ;
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
  $tipo=0;
  //$sexo=$_POST['sexo'];
  //$fecnac=$_POST['fecnac'];
  //$ced=$_POST['ced'];

//if ($tipo='') {$tipo=0;}
if ($_GET['idbenefi']) $idbenefi=$_GET['idbenefi'];
else
$idbenefi=$rif;

  $datos = array($rif,$nom1,$nom2,$ape1,$ape2,$nomorg,$nomcom,$calle,$urb,$casa,$piso,$apart,$dist,$tlf1,$tlf2,$obspro,$estado,$municipio,$parroquia,$tipo,'','01/01/0001',$ced);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

if ($idbenefi and $indReg==2)  {
	$ban=1;
	$i=0;
	//echo 'entro';
	$listarBeneficiario=$objBeneficiario->listarBeneficiario($idbenefi,'','','','');
}

if ($indReg==1){
	//echo 'entro: '.count($datos);}
	$listarBeneficiario=$objBeneficiario->listarBeneficiario($idbenefi,'','','','');
   if ($listarBeneficiario[0]=''){
   	     $ban=1;
   	     $i=0;
	     echo "<script>alert('Esta CI/RIF: ".$listarBeneficiario[0]." pertenece a : ".$listarBeneficiario[6]."');</script>";
   }else
   {
   	 $registro = $objBeneficiario->registrarBeneficiario($datos);

  }

	if ($registro)  {
		 echo "<script>alert('Ordenante Registrado');</script>";
		 echo "<SCRIPT>window.location.href='listado_beneficiarios.php';</SCRIPT>";

	}
}

if ($indReg==2){
	//echo 'entro: '.count($datos);
	$modificar = $objBeneficiario->modificarBeneficiario($idbenefi,$datos);
	if ($modificar)   {
	     echo "<script>alert('Ordenante Modificado');</script>";
		 echo "<SCRIPT>window.location.href='listado_beneficiarios.php';</SCRIPT>";
		// echo "<SCRIPT>window.location.href='listado_beneficiariosExp.php';</SCRIPT>";

	}
}

$_SESSION['numben'] = $listarBeneficiario[$i+19].$listarBeneficiario[$i+20].$listarBeneficiario[$i+21];

$objZona= new zona();
$buscarEstados = $objZona->buscarEstados($listarBeneficiario[36]);
$buscarMunicipio = $objZona->buscarMunicipios($listarBeneficiario[37],$listarBeneficiario[36]);
$buscarParroquia = $objZona->buscarParroquias($listarBeneficiario[38],$listarBeneficiario[36],$listarBeneficiario[37]);

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
var txt=" Registro de Cliente del Sistema de Siregtra IMCP ";
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
    alert("Seleccione la Figura");
    document.form1.nac.focus()
    return (false);
    }


 /*   if (document.form1.digrif.value.length==0){
  alert("Debe Ingresar el último Dígito del RIF");
  document.form1.digrif.focus()
  return (false);
  }*/

if (document.form1.nom1.value.length==0){
    alert("Debe Ingresar el  Nombre, Apellido o Razon Social");
    document.form1.nom1.focus()
    return (false);
 }else
 {
   var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   if (!filter.test(document.form1.nom1.value)) {
   alert('Caracteres no validos en el Nombre, Apellido o Razon Social');
   document.form1.nomb1.focus();
   return (false);}
 }


if (document.form1.nomorg.value.length<=19){
    alert("Debe Ingresar 20 digitos en el  Numero de Cuenta");
    document.form1.nomorg.focus()
    return (false);
    }


if (document.form1.calle.value.length<=19){
    alert("Debe Ingresar 20 digitos en el  Numero de Cuenta Beneficiario");
    document.form1.calle.focus()
    return (false);
    }

if (document.form1.urb.value.length==0){
  alert("Debe Ingresar el  Nombre, Apellido o Razon Social Beneficiario");
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
      alert('Caracteres no validos en el Nombre, Apellido o Razon Social Beneficiario');
      document.form1.urb.focus();
      return (false);
    }
   // return ind;
 }
if (document.form1.casa.value.length==0){
    alert("Debe Ingresar un N° RIF ó CI");
    document.form1.casa.focus()
    return (false);
    }



if (document.form1.apart.value.length==0){
    alert("Seleccione Tipo de Transferencia");
    document.form1.apart.focus()
    return (false);
    }


if (document.form1.piso.value.length==0){
    alert("Seleccione Tipo de Cuenta");
    document.form1.piso.focus()
    return (false);
    }


    if (document.form1.piso.value.length==0){
    alert("Seleccione Tipo de Cuenta");
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


 if (document.form1.tlf1.value.length==0){
 alert("Debe Ingresar un Monto");
 document.form1.tlf1.focus()
return (false);
 }


/*opciones = document.getElementsByName("tipo");
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
  }*/

if (document.form1.obspro.value.length==0){
  alert("Debe Ingresar Numero de referencia");
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
      <!--   <tr>
        <td colspan="4" class="cabecera">Tipo de Beneficiario</td>
      </tr>
        <tr>
        <td class="categoria">
             <label>Discapacidad</label>
        </td>
        <td class="dato" >
        <input type="radio" name="tipo" id="tipo" value="1" <?php if($ban==1 and  $listarBeneficiario[$i+35]==1)  echo "checked= 'true'"; ?> />
       </td>
       <td class="categoria">
             <label>Victima de Estafa</label>
        </td>
        <td class="dato" >
        <input type="radio" name="tipo" id="tipo"  value="2" <?php if($ban==1 and  $listarBeneficiario[$i+35]==2)  echo "checked= 'true'"; ?> />
       </td>
      </tr>
              <tr>
        <td class="categoria">
             <label>Medicos y Enfermeras</label>
        </td>
        <td class="dato" >
        <input type="radio" name="tipo" id="tipo"  value="3" <?php if($ban==1 and  $listarBeneficiario[$i+35]==3)  echo "checked= 'true'"; ?> />
       </td>
       <td class="categoria">
             <label>Educadores</label>
        </td>
        <td class="dato" >
        <input type="radio" name="tipo" id="tipo"  value="4" <?php if($ban==1 and  $listarBeneficiario[$i+35]==4)  echo "checked= 'true'"; ?> />
       </td>
      </tr>
              <tr>
        <td class="categoria">
             <label>Personal Militar</label>
        </td>
        <td class="dato" >
        <input type="radio" name="tipo" id="tipo"  value="5" <?php if($ban==1 and  $listarBeneficiario[$i+35]==5)  echo "checked= 'true'"; ?> />
       </td>
       <td class="categoria">
             <label>Funcionarios publicos</label>
        </td>
        <td class="dato" >
        <input type="radio" name="tipo" id="tipo"  value="6" <?php if($ban==1 and  $listarBeneficiario[$i+35]==6)  echo "checked= 'true'"; ?> />
       </td>
      </tr>
       <tr>
        <td class="categoria">
             <label>Otros</label>
        </td>
        <td class="dato" >
        <input type="radio" name="tipo" id="tipo"  value="7" <?php if($ban==1 and  $listarBeneficiario[$i+35]==7)  echo "checked= 'true'"; ?> />
       </td>
       <td class="categoria">
        <label></label>
        </td>
        <td class="dato" >
       </td>
      </tr> -->
      
          <td class="categoria">Campos con (*) son obligatorios</td>
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
            <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Modificar" />
            <?php } ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_beneficiarios.php'" value="Listar" />
           <!-- <input name="listar" type="button" id="listar" onclick="window.location.href='listado_beneficiariosExp.php'" value="Listar" />-->
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
