<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/relacionC.php');

$obj = new relacionC();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,13,17);

//validaAcceso($permitidos,$dir);

$indReg = $_POST['indReg'];

$contRemision= 'A'; //$_POST['contenido'];
$fecRemision= $_POST['fecRemision'];

$datos = array($fecRemision,$contRemision);


if ($indReg==1){
    $registro = $obj->regRemision($fecRemision,$contRemision,&$nFallas,&$msj);
	$msj = ($registro)?"Remisión Registrada, proceda a asociar los cheques".$msj:"Mensaje de error:".$msj;
	f_alert($msj);

	$indReg = 4;

	if($indReg==4) echo "<script>window.location.href='det_rel_cheque.php?id=".$_SESSION['remision_s']."';</script>";

}

/*if ($indReg==1 and $_GET['id']){
    $registro = $obj->modificarDeposito($id_deposito,$datos,&$msj);
	$msj = ($registro)?"Depósito Modificado".$msj:"Mensaje de error:".$msj;
	f_alert($msj);
	$indReg = 4;
}*/

if ($indReg>=3){	// Ejecutar si y sólo sí (indReg = 3 : Limpiar) ó (indReg = 4 : Se modifica el depósito)
	f_limpiar();
	if($indReg==4) echo "<script>window.location.href='listado_relacion_cheques.php';</script>";
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

function disable(nBoton){
  document.getElementById("boton"+nBoton).disabled=true;
}

function enable(nBoton){
  document.getElementById("boton"+nBoton).disabled=false;
  }

function validarCaract(dato){

if(dato==3){
	 document.registro.fecRemision.value = null;
	 disable(1);
	 disable(2);
}else {
    if (document.registro.fecRemision.value.length==0){
	   alert("Debe indicar fecha de la remisión");
	   document.registro.fecRemision.focus()
	   disable(2);
	   return (false);
	   }
	enable(2);
	}
	 document.registro.indReg.value = dato;
	 document.registro.submit();
}
///////////////////////////////////////////////////////////////////////////////

    function popup(URL) {
      day = new Date();
      id = day.getTime();
      eval("page"+id+"=window.open(URL,'URL','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=950,height=650');");
	}

	function fcodBanco(){
	var nroCtaBanco = document.registro.id_banco.value;
	document.registro.codBanco.value = nroCtaBanco.substr(0,4);
	document.registro.ctaBanco.value = nroCtaBanco.substr(4);
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
  <form id="registro" name="registro" method="post" action="">
  <table class="formulario" width="900" border="0" align="center" id="tabla1">
    <td colspan="12" class="cabecera">Relaci&oacute;n de Cheques</td>
   <!--  <tr><td class="categoria" colspan="3">Contenido memo:</td>
        <td align="left"><textarea rows="2" cols="60" name="contenido">
AAAAAAAAA.
</textarea>
        </td></tr>-->
        <tr><td class="categoria" colspan="3">Fecha:</td>
        <td class="dato">
         <input name="fecRemision" type ="text" id="fecRemision"
         		value="<?=($fecRemision!='01/01/1999')?$fecRemision:''?>"
         		size="8" maxlength="10"
         		date_format="dd/MM/yy"
         		onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)" readonly=""/>
	          <img src="../images/cal.gif" width="16" height="16"
	          		onClick="show_calendar('document.forms[0].fecRemision',document.forms[0].fecRemision.value);enable(1);enable(2)" />
         </td>
    </tr>
    <tr>
     <td height="22" colspan="11">
     <div align="center">
      <?if(!$_GET['id']){?>
      	<br/>
        <input type="button" value="Limpiar" onclick="validarCaract(3); return false"/>
      <?}?>
        <input type="button" value="Guardar" id="boton2" name="boton2"
        		onclick="validarCaract(1); 	return false" />
        <input type="button" value="Listar" onclick="window.location.href='listado_relacion_cheques.php'"/>
        <input type="hidden" id="indReg" name="indReg" size="2">
	 </div>
     </td>
     </tr>
 </table>
 <!-- //////////////////////////////////////////////////////////////////// -->
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