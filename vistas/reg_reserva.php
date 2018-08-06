<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/certificado.php');

$objCertificado = new certificado();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,11,18,23);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];
$codproc=$_POST['codproc'];
$sercarveh=$_POST['sercarveh'];
$ban=0;
$indErr = false;

  $numcerveh=$_POST['numcerveh'];
  $idAsig=$_POST['idAsig'];
  $resdom=$_POST['resdom'];
  $numcedres=$_POST['numcedres'];
  $obspolseg=$_POST['obspolseg'];


if ($_GET['id_certificado']) $id_certificado=$_GET['id_certificado']; else $listarcertificado=null;

$datos = array($idAsig,$resdom,$numcedres,$obspolseg);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');


if ($indReg==1){
	$ban=1;
	$i=0;

    $registro = $objCertificado->registrarReserva($numcerveh,$datos,$codproc,$sercarveh);

	if ($registro)  {
		 echo "<script>alert('Reserva de Dominio Registrada');</script>";
		 echo "<SCRIPT>window.location.href='../vistas/reportes/pdfcertificado.php?reserva=".$registro."';</SCRIPT>";
	}
}



if ($indReg==3)  {
	$listarcertificado=null;

}
if (!$_GET['id_certificado']) {
	$listarcertificado=null;
	$ban=0;
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

	    if (document.form1.resdom.value.length==0){
	    alert("Debe Ingresar el nombre de la reserva de dominio");
	    document.form1.resdom.focus();
	    return (false);
	    }

	    if (document.form1.numcedres.value.length==0){
	    alert("Debe ingresar el numero de ci o Rif de la reverva de dominio");
	    document.form1.numcedres.focus();
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
        <td colspan="4" class="cabecera">Datos para Completar el Certificado con los Datos del Seguro </td>
      </tr>
      <tr>
        <td class="categoria">Vehiculo:	</td>
        <td class="dato">
         <input name="sercarveh" type="text" id="sercarveh" maxlength="18" value="<?php if($ban==1)  echo $listarcertificado[$i+2];?>" readonly=""/>
         <input type="button" onclick="catalogoAncho('cat_certificado.php');" value="..."/>
        </td>
         <td class="categoria">Beneficiario: </td>
        <td class="dato">
	        <input name="beneficario" type="text" id="beneficario" value="<?php if($ban==1)  echo $listarcertificado[$i+4];?>" size="20" maxlength="10" readonly="" />
	        <input type="hidden" name="idAsig" id="idAsig" value="<?php if($ban==1)  echo $listarcertificado[$i+15];?>">
        </td>
      </tr>
       <tr>
        <td class="categoria" >N° de Certificado de Origen (Preimpreso):</td>
        <td class="dato" colspan='3'>
         <input name="numcerveh" type ="text" id="numcerveh"  value="<?php if($ban==1)  echo $listarcertificado[$i+17];?>" size="15" maxlength="6"   onkeypress="return acessoNumerico(event)" readonly="" />
        </td>

      </tr>
      <tr>
        <td colspan="4" class="cabecera">Reserva de Dominio </td>
      </tr>
      <tr>
        <td class="categoria">A Favor de: </td>
        <td class="dato">
         <input name="resdom" type ="text" id="resdom"  value="<?php if($ban==1)  echo $listarcertificado[$i+11];?>" size="20" maxlength="120"   onblur="javascript:this.value=this.value.toUpperCase()" />
        </td>
         <td class="categoria">N° C.I o RIF: </td>
        <td class="dato">
	       <input name="numcedres" type ="text" id="numcedres" value="<?php if($ban==1)  echo $listarcertificado[$i+12];?>" size="20" maxlength="10"   onblur="javascript:this.value=this.value.toUpperCase()" />
        </td>
      </tr>
       <tr>
        <td class="categoria">Observaciones</td>
        <td class="dato" colspan='3'>
     <textarea name="obspolseg" cols="60" rows="2" id="obspolseg"  onblur="javascript:this.value=this.value.toUpperCase()" ><?php if($ban==1)  echo $listarcertificado[$i+13];?></textarea>
        </td>
      </tr>

      <tr>
        <td height="22" colspan="4">
          <div align="center">
           <input type="hidden" name="indReg" >
               <input type="hidden" name="codproc" id="codproc" >
            <input  type="button" onclick="validarCaract(1); return false" value="Registrar" />
             <input  type="button"  onclick="validarCaract('3'); return false" value="Limpiar" />
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
