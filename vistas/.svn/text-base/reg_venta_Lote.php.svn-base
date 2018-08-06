<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/venta.php');

$objventa = new venta();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5);
validaAcceso($permitidos,$dir);

$ban=0;
$indReg=$_POST['indReg'];

$indErr = false;

$numlotveh	= $_POST['numlotveh'];
$deslotveh	= $_POST['deslotveh'];
$modalidad	= $_POST['modalidad'];
$statusVenta= $_POST['statusVenta'];

$_SESSION['numlotveh_']	= $_POST['numlotveh'];
$_SESSION['modalidad_']	= $_POST['modalidad'];
$_SESSION['statusVenta_']= $_POST['statusVenta'];

if ($indReg==1 or $indReg==2){
	$ban=1;
	$i=0;

  if(!$modalidad){
     $indErr = true;
     $msj .= 'Debe seleccionar modalidad de pago';
   }

  if($indErr)f_alert($msj);
  else {
    $registro = $objventa->migrarVenta($numlotveh,$statusVenta,$modalidad);
	if($registro){
		f_alert("Venta en lotes registrada OK");
		echo "<SCRIPT>window.location.href='listado_ventas.php';</SCRIPT>";
	}
  }
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

if (document.form1.numlotveh.value.length==0){
    alert("Debe seleccionar el número de Lote");
    document.form1.numlotveh.focus();
    return (false);
    }

if (document.form1.statusVenta.value.length==0){
    alert("Debe seleccionar el status de la compra");
    document.form1.statusVenta.focus();
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
  <table class="formulario" width="822" border="0" align="center" >
      <tr>
        <td colspan="10" class="cabecera">Ventas por Lotes</td>
      </tr>
     <tr>
        <td class="categoria">N° Lote:</td>
        <td class="dato" colspan="4">
         <input name="numlotveh" type="text" id="numlotveh" value="<?=$numlotveh?>" align="center" size="3" readonly="true" maxlength="3"/>
         <input name="deslotveh" type="text" id="deslotveh" value="<?=$deslotveh?>" size="20" readonly="true"/>
         <input name="lote" type="button" id="lote" onclick="catalogo('../cat_lot.php');" value="..." />
        </td>
      </tr>
<tr>
<td colspan="5">
 <table class="formulario" width="822" border="0" align="left" >
       <tr>
        <td class="categoria" ></td>
        <td class="cabecera">Parcial</td>
        <td class="cabecera" >Total</td>
        <td class="cabecera" >Estatus</td>
      </tr>
      <tr>
        <td class="categoria">Credito</td>
        <td  align="center">
        <input id="modalidad1" type="radio" name="modalidad" value="R" <?if($ban==1 and  $listarventa[$i+3]=="R") echo "checked= 'true'"; elseif($_SESSION['modalidad']=="R") echo "checked='true'"?>></td>
        <td  align="center">
        <input id="modalidad2" type="radio" name="modalidad" value="RL"<?if($ban==1 and  $listarventa[$i+3]=="RL") echo "checked= 'true'"; elseif($_SESSION['modalidad']=="RL") echo "checked='true'"?>>
        </td>
        <td>
           <SELECT name="statusVenta" id="statusVenta">
			    <OPTION value=""></OPTION>
			    <OPTION value="ANA" <?php if($ban==1 and $listarventa[$i+6]=="ANA")echo"selected='true'";elseif($_SESSION['statusVenta_']=="ANA")echo"selected='true'"?>>ANÁLISIS</OPTION>
			    <OPTION value="DOC" <?php if($ban==1 and $listarventa[$i+6]=="DOC")echo"selected='true'";elseif($_SESSION['statusVenta_']=="DOC")echo"selected='true'"?>>DOCUMENTACIÓN</OPTION>
			    <OPTION value="AUT" <?php if($ban==1 and $listarventa[$i+6]=="AUT")echo"selected='true'";elseif($_SESSION['statusVenta_']=="AUT")echo"selected='true'"?>>AUTENTICACIÓN</OPTION>
			    <OPTION value="APR" <?php if($ban==1 and $listarventa[$i+6]=="APR")echo"selected='true'";elseif($_SESSION['statusVenta_']=="APR")echo"selected='true'"?>>APROBADO</OPTION>
			    <OPTION value="LIQ" <?php if($ban==1 and $listarventa[$i+6]=="LIQ")echo"selected='true'";elseif($_SESSION['statusVenta_']=="LIQ")echo"selected='true'"?>>LIQUIDADO</OPTION>
			    <OPTION value="RCH" <?php if($ban==1 and $listarventa[$i+6]=="RCH")echo"selected='true'";elseif($_SESSION['statusVenta_']=="RCH")echo"selected='true'"?>>RECHAZADO</OPTION>
			    <OPTION value="PEN" <?php if($ban==1 and $listarventa[$i+6]=="PEN")echo"selected='true'";elseif($_SESSION['statusVenta_']=="PEN")echo"selected='true'"?>>PENDIENTE</OPTION>
			</SELECT>
		</td>
      </tr>
       <tr>
        <td class="categoria" >Contado</td>
        <td align="center" >
        <input id="modalidad3" type="radio" name="modalidad" value="CP" <?php if($ban==1 and  $listarventa[$i+3]=="CP")  echo "checked= 'true'"; elseif($_SESSION['modalidad_']=="CP") echo "checked= 'true'"?>>
        </td>
        <td  align="center">
        <input id="modalidad4" type="radio" name="modalidad" value="C" <?php if($ban==1 and  $listarventa[$i+3]=="C")  echo "checked= 'true'"; elseif($_SESSION['modalidad_']=="C") echo "checked= 'true'"?>></td>
         <td >
        </td>
      </tr>
 </table>
</td >
</tr>


      <!--- aqui digna-->


 <!--//////////////////////////////////////////////////////////////////////////////////-->

      <tr>
        <td height="22" colspan="5">
          <div align="center">
           <input type="hidden" name="indReg" >
           <?php if (!$idventa) { ?>
            <input  type="button" onclick="validarCaract(1); return false" value="Registrar ventas" />
            <?php } if ($idventa and $listarventa[$i+6]!="LIQ") { ?>
            <input name="Modificar" type="button" id="Modificar"
            		onclick="validarCaract('2'); return false" value="Modificar venta" />
            <?php } ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_ventas.php'" value="Listar ventas" />
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
