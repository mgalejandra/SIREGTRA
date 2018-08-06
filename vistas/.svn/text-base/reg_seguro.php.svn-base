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
  $nomseg=$_POST['nomseg'];
  $numpolseg=$_POST['numpolseg'];
  $fecvenpol=$_POST['fecvenpol'];


if ($_GET['id_certificado']) $id_certificado=$_GET['id_certificado']; else $listarcertificado=null;

$datos = array($idAsig,$nomseg,$numpolseg,$fecvenpol);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

//echo 'aqui'.$numcerveh;
if ($indReg==1){
	$ban=1;
	$i=0;

    $registro = $objCertificado->registrarSeguro($numcerveh,$datos,$codproc,$sercarveh);

	if ($registro)  {
		 echo "<script>alert('Seguro Registrado');</script>";
		 echo "<SCRIPT>window.location.href='../vistas/reportes/pdfcertificado.php?seguro=".$registro."';</SCRIPT>";
	}else echo "<script>alert('Seguro NO Registrado');</script>";
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

		if (document.form1.nomseg.value.length==0){
	    alert("Debe Ingresar el nombre del seguro");
	    document.form1.nomseg.focus();
	    return (false);
	    }

	    if (document.form1.numpolseg.value.length==0){
	    alert("Debe ingresar el numero de la poliza");
	    document.form1.numpolseg.focus();
	    return (false);
	    }

	    if (document.form1.fecvenpol.value.length==0){
	    alert("Debe ingresar la fecha de vencimiento de la poliza");
	    document.form1.fecvenpol.focus();
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
         <input name="numcerveh" type ="text" id="numcerveh"  value="<?php if($ban==1)  echo $listarcertificado[$i+17];?>" size="15" maxlength="6"   onkeypress="return acessoNumerico(event)" readonly=""/>
        </td>
     </tr>
        <td colspan="4" class="cabecera">Datos del Seguro </td>
      </tr>
      <tr>
        <td class="categoria"> Empresa Aseguradora:</td>
        <td class="dato">
         <input name="nomseg" type ="text" id="nomseg"  value="<?php if($ban==1)  echo $listarcertificado[$i+8];?>" size="20" maxlength="50"   onblur="javascript:this.value=this.value.toUpperCase()" />
        </td>
         <td class="categoria">N° Poliza : </td>
        <td class="dato">
	       <input name="numpolseg" type ="text" id="numpolseg" value="<?php if($ban==1)  echo $listarcertificado[$i+9];?>" size="20" maxlength="20"   onblur="javascript:this.value=this.value.toUpperCase()" />
        </td>
      </tr>
       <tr>
        <td class="categoria">Fecha de Vencimiento :</td>
        <td class="dato" colspan='3'>
         <input name="fecvenpol" type ="text" id="fecvenpol"  value="<?php if($ban==1 and $listarcertificado[$i+10]!='01/01/1999')  echo $listarcertificado[$i+10];?>" size="20" maxlength="10"   date_format="dd/MM/yy" onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)"  readonly=""/>
          <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecvenpol',document.forms[0].fecvenpol.value)" />
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
