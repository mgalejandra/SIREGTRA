<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/taller.php');

$objTaller = new taller();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,3,4,5);
validaAcceso($permitidos,$dir);

$ban=0;
$indReg=$_POST['indReg'];
$indErr = false;


$fec_ingreso = $_POST['fecIngreso'];

$fec_egreso = $_POST['fecEgreso'];
if (!$fec_egreso)
	$fec_egreso='01/01/1900';

$pagina = $_GET['pag'];
$lugar		 = $_POST['lugar'];
$falla = $_POST['falla'];
$taller = $_POST['codtal'];

$desacto= $_POST['destaller'];

if ($_GET['idsercarveh']){
	$serial = $_GET['idsercarveh'];
	$buscarVT = $objTaller->buscarVehTallerID($serial);

	if ($buscarVT){
	$num = 1;
	$nombreT=  $objTaller->buscarTallerID($buscarVT[1]);

	$_SESSION['taller_']=$nombreT[1];
	$_SESSION['fecha_']=$buscarVT[2];
	$_SESSION['falla_']=$buscarVT[3];
	//$taller=$buscarVT[1];

	if ($buscarVT[4]=='01/01/1900')
		$_SESSION['fechae_']="";
	else
		$_SESSION['fechae_']=$buscarVT[4];

    $_SESSION['serial_']=$buscarVT[5];

   }

}

$datos=array($taller,$fec_ingreso,$falla,$fec_egreso,$serial);

if ($indReg==1 or $indReg==2){
	$ban=1;

  if($indErr)f_alert("Lista de errores:".$msj);
  else
	switch($indReg){

		case 1:	//	Registrar asignacion Taller
		    $registro = $objTaller->asignarVehTaller($datos); //$serial,
		    $nombre = $objTaller->buscarTallerID($taller);
			$msj = ($registro)?"Vehiculo asignado al taller: ".$nombre[1]:"Asignacion a taller no pudo registrarse";
			if ($registro)
				echo "<script>window.close()</script>";
			break;

		case 2:	// Modificar asignacion Taller
		    $registro = $objTaller->modificarVehTaller($datos);
			$msj = ($registro)?"Asignacion a taller ha sido modificada":"Asignacion a taller no pudo modificarse";

			if ($registro)
				echo "<script>window.close()</script>";

			break;
		}
	f_alert($msj);
	//f_limpiar_SESSION();
		if ($registro)  {
		  if ($pagina==1)
		   	echo "<SCRIPT>window.location.href='listado_vehiculos_nac.php';</SCRIPT>";
		  else
		  	echo "<SCRIPT>window.location.href='listado_vehiculos_imp.php';</SCRIPT>";
	    }
}

/*if (!$_GET['id']) {
	$ban = 0;
	$listarEntrega = null;
	f_limpiar_SESSION();
	}*/

?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>

function validarCampos(dato){

if (document.form1.falla.value.length==0){
    alert("Debe indicar el tipo de falla");
    document.form1.falla.focus();
    return (false);
    }

if (document.form1.fecIngreso.value.length==0){
    alert("Debe indicar fecha de ingreso");
    document.form1.fecIngreso.focus();
    return (false);
    }

if (document.form1.destaller.value.length==0){
    alert("Debe seleccionar el taller");
    document.form1.destaller.focus();
    return (false);
    }


 document.form1.indReg.value = dato;
 document.form1.submit();
}

function popup(URL) {
    day = new Date();
    id = day.getTime();
    eval("page" + id + " = window.open(URL,'URL','toolbar=0,scrollbars=yes,location=0,menubar=0,resizable=0,width=800,height=400');");
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
        <td colspan="11" class="cabecera">Asignar vehículo <? echo $serial; ?> a taller</td>
      </tr>
      <tr>
      <td class="categoria">Taller:</td>
        <td class="dato" colspan="2">
         <input name="destaller" type="text" id="destaller" maxlength="18" value="<?php if ($num==1) echo $_SESSION['taller_']; ?>" readonly=""/>
        <input type="button" onclick="popup('cat_taller.php');" value="..."/>
        </td>
       <td class="categoria">Fecha&nbsp;ingreso:&nbsp;</td>
        <td class="dato" colspan="2">
         <input name="fecIngreso" type ="text" id="fecIngreso"
         		value="<?php  if ($num==1) echo $_SESSION['fecha_']; ?>"
         		size="8" maxlength="10" date_format="dd/MM/yy"
         		onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)"  readonly=""/>
        </td>
<td class="dato"> <img src="../images/cal.gif" width="16" height="16"
          		onClick="show_calendar('document.forms[0].fecIngreso',document.forms[0].fecIngreso.value)"/></td>
       </tr>
       <tr> <td class="categoria" colspan="2">Falla:</td>
			 <td class="dato">
			 <textarea rows="2" cols="60" name="falla"><?php  if ($num==1) echo $_SESSION['falla_']; ?></textarea>
		     </td>
		<td class="categoria">Fecha&nbsp;egreso:&nbsp;</td>
        <td class="dato" colspan="2">
         <input name="fecEgreso" type ="text" id="fecEgreso"
         		value="<?php if ($num==1) echo $_SESSION['fechae_']; ?>"
         		size="8" maxlength="10" date_format="dd/MM/yy"
         		onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)"  readonly=""/>
        </td><td class="dato"> <img src="../images/cal.gif" width="16" height="16"
          		onClick="show_calendar('document.forms[0].fecEgreso',document.forms[0].fecEgreso.value)"/></td>
		</tr>


 <!--//////////////////////////////////////////////////////////////////////////////////-->

      <tr>
        <td colspan="11 align="center">
            <input type="hidden" name="indReg"/>
            <input type="hidden" name="codtal" id="codtal" value="<? if ($buscarVT) echo $buscarVT[1];?>">
            <?  if ($num<>1) { ?>
            <input type="button" onclick="validarCampos(1); return false" value="Registrar"/>
            <? } if ($num==1){ ?>
            <input type="button" name="Modificar" id="Modificar" onclick="validarCampos(2); return false" value="Modificar"/>
            <? } ?>
</td>
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