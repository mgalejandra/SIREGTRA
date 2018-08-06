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
$codproa=$_POST['codproa'];

$indErr = false;

$sercarveh	= $_POST['sercarveh'];
$modalidad	= $_POST['modalidad'];
$statusVenta= $_POST['statusVenta'];

$beneficario= $_POST['beneficario'];
$idAsig		= $_POST['idAsig'];

$_SESSION['sercarveh_']	= $_POST['sercarveh'];
$_SESSION['modalidad_']	= $_POST['modalidad'];
$_SESSION['statusVenta_']= $_POST['statusVenta'];

$_SESSION['beneficario_']= $_POST['beneficario'];
$_SESSION['idAsig_']	 = $_POST['idAsig'];

if ($_GET['id_venta']) $idventa=$_GET['id_venta'];

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

if ($idventa or $indReg!=2)  {
	$ban=1;
	$i=0;
	//echo 'entro';
	$listarventa = $objventa->buscarVenta($idventa);
    //echo $ban.'--'.$listarventa[$i+1];
}

if ($indReg==1 or $indReg==2){
	$ban=1;
	$i=0;
/*
   if(!$sercarveh){
     $indErr = true;
     $msj .= '\n 01: Debe seleccionar vehículo (serial de carroceria)';
   }

  if(!$modalidad){
     $indErr = true;
     $msj .= '\n 02: Debe seleccionar modalidad de pago';
   }

  if(!$statusVenta){
     $indErr = true;
     $msj .= '\n 03: Debe indicar el \"status\" de la venta';
   }
*/
  if($indErr)f_alert("Reporte de validación:".$msj);
  else
	switch($indReg){
		case 1:	//	Registro de venta			  $serial,$statusCred, $modalidad, $regExist
		    $registro = $objventa->registrarVenta($sercarveh,$statusVenta, $modalidad, &$regExist,$idAsig);
			if($registro) $msj = "Venta registrada OK";
			else{
				$msj = "Registro de venta ya existe, con ID: ".$regExist[0]." revise lista de ventas";
				$listarventa = $regExist;
				}
			if ($registro){
				f_alert($msj);
				echo "<SCRIPT>window.location.href='listado_ventas.php';</SCRIPT>";
			}else f_alert("No se pudo registrar la venta");
			break;

		case 2:	// Modificación de venta
		    $modificar = $objventa->modificarVenta($sercarveh,$modalidad,$estatus,$statusVenta);

			if ($modificar){
			     f_alert("Venta Modificada");
				 echo "<SCRIPT>window.location.href='listado_ventas.php';</SCRIPT>";
			}else f_alert("No se pudo modificar la venta");
			break;
		}
}

if (!$_GET['id_venta']) { $ban=0; $listarventa=null;}
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
   if(document.form1.sercarveh.value.length==0){
     	alert("Debe seleccionar vehículo (serial de carroceria)");
		document.form1.sercarveh.focus();
	    return (false);
   }

  if(!document.form1.modalidad1.checked && !document.form1.modalidad2.checked &&
     !document.form1.modalidad3.checked && !document.form1.modalidad4.checked){
     	alert("Debe seleccionar modalidad de pago");
		document.form1.modalidad1.focus();
	    return (false);
   }

  if(document.form1.statusVenta.value.length==0){
  		alert("Debe indicar el status de la venta");
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
        <td colspan="10" class="cabecera"><?if(!$idventa)echo "Registrar ";else echo "Modificar "?>Venta</td>
    </tr>
    <tr>
        <td class="categoria">Vehiculo:	</td>
        <td class="dato">
         <input name="sercarveh" type="text" id="sercarveh" maxlength="18"
         		value="<?php  if($ban==1)  echo $listarventa[$i+1]; else echo $_SESSION['sercarveh_']?>" readonly=""/>
         <?php if (!$idventa) { ?>
         <input type="button" onclick="catalogoAncho('cat_asignacion.php?id=2');" value="..."/>
         <?php } ?>
        </td>
         <td class="categoria">Beneficiario: </td>
        <td class="dato">
	        <input name="beneficario" type="text" id="beneficario" size="45"
	        		value="<?php if($ban==1) echo $listarventa[$i+2];else echo $_SESSION['beneficario_']?>" readonly="" />
		</td>
	<tr>
<td colspan="4">
 <table class="formulario" width="822" border="0" align="left" >
       <tr>
        <td class="categoria"WIDTH="30%" ></td>
        <td class="cabecera" width="10%">Parcial</td>
        <td class="cabecera" width="10%">Total</td>
        <td class="cabecera" width="20%">Estatus</td>
        <td class="categoria"WIDTH="30%" ></td>
      </tr>
      <tr>
        <td class="categoria" title="Forma de pago">Crédito</td>
        <td  align="center" title="Modo de pago: Crédito Parcial">
        <input id="modalidad1" type="radio" name="modalidad" value="R" <?php if($ban==1 and  $listarventa[$i+3]=="R") echo "checked= 'true'"; elseif($_SESSION['modalidad']=="R") echo "checked= 'true'"?>></td>
        <td  align="center" title="Modo de pago: Crédito Total">
        <input id="modalidad2" type="radio" name="modalidad" value="RL" <?php if($ban==1 and  $listarventa[$i+3]=="RL")  echo "checked= 'true'"; elseif($_SESSION['modalidad']=="RL") echo "checked= 'true'"?>>
        </td>
        <td  >
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
        <td class="categoria" title="Forma de pago">Contado</td>
        <td align="center" title="Contado con pagos parciales">
        <input id="modalidad3" type="radio" name="modalidad" value="CP" <?php if($ban==1 and  $listarventa[$i+3]=="CP")  echo "checked= 'true'"; elseif($_SESSION['modalidad_']=="CP") echo "checked= 'true'"?>>
        </td>
        <td  align="center" title="Pago total de contado">
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
             <input type="hidden" name="codproa" id="codproa" >
           <?php if (!$idventa) { ?>
            <input  type="button" onclick="validarCaract(1); return false" value="Generar" />
            <?php }
            /*
             * Si hay que editar un registro de venta y el crédito está liquidado
             * no debe aparecer el botón < Modificar >
             */
            if ($idventa and $listarventa[$i+6]!="LIQ")
            { ?>
            <input name="Modificar" type="button" id="Modificar"
            		onclick="validarCaract('2'); return false" value="Modificar venta" />
            <?php } ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_ventas.php'" value="Listar ventas" />
 	        <input type="hidden" name="idAsig" id="idAsig"
	        		value="<?php if($ban==1) echo $listarventa[$i+1];else echo $_SESSION['idAsig_']?>">
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
