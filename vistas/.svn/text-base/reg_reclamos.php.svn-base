<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/reclamos.php');
require('../modelos/beneficiario.php');

$objReclamo = new reclamos();
$objBeneficiario = new beneficiario();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,11,13,14,15,17,11,14,22);
validaAcceso($permitidos,$dir);
$ban=0;

$listarTipoRec=$objReclamo->listarTipoR('',1);
$nroR = 5;

if ($_GET['idreclamo']) $idreclamo = $_GET['idreclamo'];

$datos = array($ced,$nom1,$nom2,$ape1,$ape2,$tipo,$sercarveh,$descr,$resp,$tlf1,$tlf2,$banco,$nomcom,$sexo);
$ban=0;
$indErr = false;

  $ced=$_POST['ced'];
  $nom1=$_POST['nom1'];
  $nom2=$_POST['nom2'];
  $ape1=$_POST['ape1'];
  $ape2=$_POST['ape2'];
  $tipo=$_POST['tipo'];
  $idtipo=$_POST['tipoR'];


  if ($_POST['tipo'])
 	 $_SESSION['tipo']=$_POST['tipo'];

 // echo "Tipo: ".$_SESSION['tipo'];

  $sercarveh=$_POST['sercarveh'];
  $descr=$_POST['descr'];
  $resp=$_POST['resp'];
  $tlf1=$_POST['codtlf1'].$_POST['tlf1'];
  $tlf2=$_POST['codtlf2'].$_POST['tlf2'];
  $banco=$_POST['banco'];
  $nomcom=$nom1." ".$nom2." ".$ape1." ".$ape2;
  $sexo=$_POST['sexo'];

  $nuevoTipo = $_POST['nuevotipo'];
 // echo "Nuevo Tipo: ".$nuevoTipo;

//if ($tipo='') {$tipo=0;}

$indReg=$_POST['indReg'];

//echo "Mande: ".$indReg;

if ($idreclamo and $indReg!=2)  {
	$ban=1;
	$i=0;
	//echo 'entro';
	$listarTipoR=$objReclamo->listarReclamos('','',-1,$idreclamo);


}

if ($indReg==1){



   $datos = array($ced,$nom1,$nom2,$ape1,$ape2,$idtipo,$sercarveh,$descr,$resp,$tlf1,$tlf2,$banco,$nomcom,$sexo);

   if($indErr)echo '<SCRIPT>alert("'.$msj.'")</SCRIPT>';
   else  $registro = $objReclamo->registrarReclamo($datos);

	if ($registro)  {
		 echo "<script>alert('Reclamo Registrado');</script>";
		 echo "<SCRIPT>window.location.href='listado_reclamos.php';</SCRIPT>";
		  $_SESSION['tipo']=NULL;
		  $_SESSION['ced']=null;
	}
}

if ($indReg==2){
	//echo 'entro: '.count($datos);
	$datos = array($ced,$nom1,$nom2,$ape1,$ape2,$_SESSION['tipo'],$sercarveh,$descr,$resp,$tlf1,$tlf2,$banco,$nomcom,$sexo);

	$modificar = $objReclamo->modificarReclamo($idreclamo,$datos);
	if ($modificar){
	     echo "<script>alert('Reclamo Modificado');</script>";
		 echo "<SCRIPT>window.location.href='listado_reclamos.php';</SCRIPT>";
		 $_SESSION['tipo']=NULL;
		 $_SESSION['ced']=null;

	}
}

if ($indReg==4){
	$ban=2;
	$_SESSION['ced']=$_POST['ced'];
//	echo "Cedula: ".$_SESSION['ced'];

	 $datoBen = $objBeneficiario->listarBeneficiario($_SESSION['ced']);

	 if ($datoBen){
		  $_SESSION['nom1']=$datoBen[1];
		  $_SESSION['nom2']=$datoBen[2];
		  $_SESSION['ape1']=$datoBen[3];
		  $_SESSION['ape2']=$datoBen[4];
		  $_SESSION['tel1']=$datoBen[14];
		  $_SESSION['tel2']=$datoBen[15];
		  $_SESSION['nombre']=$datoBen[6];
		  $_SESSION['sexo']=$datoBen[32];
	 }

 if(!$_SESSION['tipo']){
       $indErr = true;
       $msj = 'Debe indicar el tipo de reclamo';
   }
   elseif($_SESSION['tipo'] == 'otro_tipo'){
   	   if(!$nuevoTipo){
          $indErr == true;
          $msj = 'Debe indicar el nuevo tipo';
       }
       elseif(!validarString($nuevoTipo)){
          $indErr == true;
          $msj = 'El nuevo tipo no es valido';
       }
       else{
          $nuevoTipo = corrigeString($nuevoTipo);
          $indTipo = $objReclamo->registrarTipoR($nuevoTipo);
          if($indTipo){
             $_SESSION['tipo'] = count($objReclamo->listarTipoR('',1))/$nroR;
            }
          else{
             $indErr == true;
             $msj = 'Error al registrar Tipo Reclamo';
          }
       }
   }
$listarTipoRec=$objReclamo->listarTipoR();
}

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
var txt=" Registro de Reclamo del Sistema de Vehiculos SUVINCA ";
var espera=100;
var refresco=null;
function rotulo_title()
{
	document.title=txt;
	txt=txt.substring(1,txt.length)+txt.charAt(0);
	refresco=setTimeout("rotulo_title( )",espera);
}
</SCRIPT>
<script language="JavaScript">
function popup(URL) {
	 day = new Date();
	 id = day.getTime();
	 eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=400,height=400');");
}

function validarCaract(dato){
	var letras_mayusculas="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ ";

    if (document.reclamos.ced.value.length==0){
    alert("Debe Ingresar la CI");
    document.reclamos.ced.focus()
    return (false);
    }

    if (document.reclamos.nom1.value.length==0){
    alert("Debe Ingresar el Primer Nombre del Propietario");
    document.reclamos.nom1.focus()
    return (false);
	}
	else
	{
	   var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
	   if (!filter.test(document.reclamos.nom1.value)) {
	   alert('Carácteres no válidos en el Primer nombre');
	   document.reclamos.nom1.focus();
	   return (false);}
	}


	if (document.reclamos.nom2.value.length > 0){
	     var texto = document.reclamos.nom2.value;
	     var ind = 1;
	     for(i=0; i<texto.length; i++){
	      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
	         ind = 0;
	         break;
	      }
	    }
	    if(!ind){
	      alert('Carácteres no válidos en el segundo nombre');
	      document.reclamos.nom2.focus();
	      return (false);
	    }
	   // return ind;
 	}

    if (document.reclamos.ape1.value.length==0){
	    alert("Debe Ingresar el Primer Apellido del Propietario");
	    document.reclamos.ape1.focus()
	    return (false);
	 }else
	 {
	   var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
	   if (!filter.test(document.reclamos.ape1.value)) {
	   alert('Carácteres no válidos en el Primer apellido');
	   document.reclamos.ape1.focus();
	   return (false);}
	 }

     if (document.reclamos.ape2.value.length > 0){
	    var texto = document.reclamos.ape2.value;
	    var ind = 1;
	    for(i=0; i<texto.length; i++){
	      if (letras_mayusculas.indexOf(texto.charAt(i))==-1){
	         ind = 0;
	         break;
	      }
	    }
	    if(!ind){
	      alert('Caracteres no válidos en el segundo Apellido');
	      document.reclamos.ape2.focus();
	      return (false);
	 }
	}

	if (document.reclamos.sexo.value.length==0){
	  alert("Debe seleccionar el Sexo");
	  document.reclamos.sexo.focus()
	  return (false);
	  }

	if (document.reclamos.codtlf1.value.length!=4){
	  alert("Debe Ingresar un codigo de area de 4 digitos");
	  document.reclamos.codtlf1.focus()
	  return (false);
	  }

	if (document.reclamos.tlf1.value.length!=7){
	  alert("Debe Ingresar un Numero de Télefono de 7 digitos");
	  document.reclamos.tlf1.focus()
	  return (false);
	  }


	if (document.reclamos.tipo.value.length==0){
	  alert("Debe seleccionar el Tipo de Reclamo");
	  document.reclamos.tipo.focus()
	  return (false);
	  }

 document.reclamos.indReg.value = dato;
 document.reclamos.submit();
}

function enviar(campo){
	window.document.reclamos.indReg.value = campo;
	window.document.reclamos.submit();
}

</SCRIPT>
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
  <form id="reclamos" name="reclamos" method="post" action="">
  <table class="formulario" width="822" border="0" align="center" >
      <tr>
        <td colspan="4" class="cabecera">Registrar Datos del Reclamo</td>
      </tr>
          <tr>
      <td  class="categoria">Tipo Reclamo: </td>
		  <TD class="dato">
              <SELECT name="tipo" onchange="this.form.submit()">

                <OPTION value="<?php if ($listarTipoR[7]) echo $listarTipoR[7];else echo '0'; $listarTipoR[7]=null; ?>"><?php if ($listarTipoR[17]) echo $listarTipoR[17]; else echo 'Tipo'; $listarTipoR[17]=null; ?></OPTION>
               <?php for($i=0;$i<count($listarTipoRec);$i+=$nroR){	?>
               <OPTION value="<?php echo $listarTipoRec[$i]?>" <?php if($_SESSION['tipo'] == $listarTipoRec[$i]) echo 'selected="true"'?>>
                <?php echo $listarTipoRec[$i+1]?>
               </OPTION>
               <?php }?>
               <OPTION value="otro_tipo" <?php if($_SESSION['tipo'] == 'otro_tipo') echo 'selected="true"'?>>
                Otro tipo
               </OPTION>
              </SELECT>
              <?php if($_SESSION['tipo'] == 'otro_tipo' ){ ?>
               <input type="text" name="nuevotipo" value="<?php echo $nuevoTipo; ?>" size="15"  onblur="javascript:this.value=this.value.toUpperCase()"/>
              <?php } ?>
             </TD>
	  </tr>
      <tr>
        <td class="categoria">CI: </td>
        <td class="dato" >
        <input name="ced" type="text" id="ced" onkeypress="return acessoNumerico(event)" value="<?php  if($ban==1) echo $listarTipoR[1]; else echo $_SESSION['ced']; ?>" <? if ($ban==1) echo "readonly";?> size="12" maxlength="8"  onblur="enviar(4)" />
     </tr>
      <tr>
        <td class="categoria">1er Nombre:</td>
        <td class="dato">
         <input name="nom1" type="text" id="nom1" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1) echo $listarTipoR[2]; elseif ($ban==2) echo $_SESSION['nom1'];  ?>" size="30" maxlength="30" />
        </td>
        <td class="categoria">2do Nombre:</td>
        <td class="dato">
         <input name="nom2" type="text" id="nom2" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarTipoR[3]; elseif ($ban==2) echo $_SESSION['nom2'];?>" size="30" maxlength="30"/>
        </td>
      </tr>
      <tr>
        <td class="categoria">1er Apellido :</td>
        <td class="dato" >
          <input name="ape1" type="text" id="ape1" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarTipoR[4]; elseif ($ban==2) echo $_SESSION['ape1'];?>" size="30" maxlength="30"/>
       </td>
        <td class="categoria">2do Apellido :</td>
        <td class="dato" >
          <input name="ape2" type="text" id="ape2"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarTipoR[5]; elseif ($ban==2) echo $_SESSION['ape2'];?>" size="30" maxlength="30"/>
       </td>
      </tr>
      <tr>
        <td class="categoria">Sexo:</td>
        <td class="dato">
          <select name="sexo" size="1" id="sexo">
          <?php if ($listarTipoR[15]=='F') $sexo1= "Femenino"; else $sexo1= "Masculino";  if($ban==1)  echo " <option value=".$listarTipoR[15].">".$sexo1."</option>";?>
          <option value="F">Femenino</option>
          <option value="M">Masculino</option>
          </select>
        </td>
      </tr>
      <tr>
        <td class="categoria"> Tlf/Celular 1:</td>
        <td class="dato" >
          <input name="codtlf1" type="text" id="codtlf1" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1) echo substr($listarTipoR[11],0,4); elseif ($ban==2) echo substr($_SESSION['tel1'],0,4);?>" size="6" maxlength="4" />
          <input name="tlf1" type ="text" id="tlf1" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo substr($listarTipoR[11],4,11); elseif ($ban==2) echo substr($_SESSION['tel1'],4,7);?>" size="15" maxlength="7" />
       </td>
        <td class="categoria">Tlf/celular 2:</td>
        <td class="dato" >
          <input name="codtlf2" type="text" id="codtlf2"  onkeypress="return acessoNumerico(event)" value="<?php if($ban==1 )  echo substr($listarTipoR[12],0,4);elseif ($ban==2) echo substr($_SESSION['tel2'],0,4);?>" size="6" maxlength="4" />
          <input name="tlf2" type ="text" id="tlf2" onkeypress="return acessoNumerico(event)" value="<?php if($ban==1)  echo substr($listarTipoR[12],4,11);elseif ($ban==2) echo substr($_SESSION['tel2'],4,7);?>" size="15" maxlength="7" />
       </td>
      </tr>
        <tr>
        <td class="categoria">Serial Carrocer&iacute;a:</td>
        <td class="dato" >
          <input name="sercarveh" type="text" id="sercarveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarTipoR[8];?>" size="25" maxlength="18"/>
       </td>

      </tr>
      <tr>
        <td class="categoria">Descripción:</td>
        <td class="dato" colspan='3'><textarea name="descr" cols="60" rows="2" id="descr" onblur="javascript:this.value=this.value.toUpperCase()" ><?php if($ban==1)  echo $listarTipoR[9];?></textarea>
       </td>
      </tr>
       <tr>
        <td class="categoria">Respuesta:</td>
        <td class="dato" colspan='3'><textarea name="resp" cols="60" rows="2" id="resp" onblur="javascript:this.value=this.value.toUpperCase()" ><?php if($ban==1)  echo $listarTipoR[10];?></textarea>
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
           <input type="hidden" name="tipoR" value='<?php echo $_SESSION['tipo']; ?>'>
           <?php if ($ban<>1) { ?>
            <input name="agregar" type="button" id="agregar" onclick="validarCaract(1); return false" value="Agregar" />
            <?php } if ($ban==1) { ?>
             <input name="Modificar" type="button" id="Modificar" onclick="validarCaract(2); return false" value="Modificar" />
            <?php } ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_reclamos.php'" value="Listar" />
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