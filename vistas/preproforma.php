<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/inventario.php');
require('../modelos/factura.php');
require('../modelos/asignacion.php');

$objInv = new inventario();
$objFact = new factura();
$objAsignacion = new asignacion();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,11,13,17);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];
$tipo=$_GET['tipo'];
$modif=$_GET['mod'];
$liber=$_GET['lib'];
$asig=$_GET['asig'];

$_SESSION['idasig']=$asig;
$asig1=$_SESSION['idasig'];

$ban=0;
$indErr = false;


  $preinv=$_POST['idInv'];
  $sercarveh= $_POST['sercarveh'];

$codpro = ($_GET['codpro']) ? $_GET['codpro'] : $_POST['codpro'];
$idsercarveh = ($_GET['idsercarveh']) ? $_GET['idsercarveh'] : $_POST['sercarveh'];

$datos = array($sercarveh,$codpro);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

if ((($modif) or ($liber)) and $indReg!=2)  {
	$ban=1;
	$i=0;
	$listarAsignacion=$objAsignacion->listarAsignacion('',$codpro,'','','','',0,$tipo,'','','',$asig);
	$listarAsignacion1=$objAsignacion->listarVehAsigPreInv($codpro,'','','',-1);
	$_SESSION['idAsignacion']=$listarAsignacion[4];
}

if ($indReg==1){
	$ban=1;
	$i=0;

        $listarAsignacion1=$objAsignacion->listarAsignacion('',$codpro,'','','','',0,$tipo);

  	   //if ($listarAsignacion1){ //$listarAsignacion1[0]!='' and ''
	  	if (($listarAsignacion1[7]!='G') and (!$objAsignacion->f_excepciones($listarAsignacion1[1]))){
	  		//echo "entre";
	  			echo "<script>alert('La Persona: ".$listarAsignacion1[2]." tiene asignado el Vehiculo: ".$listarAsignacion1[0]."');</script>";
		  		echo "<SCRIPT>window.location.href='listado_asignacion.php';</SCRIPT>";
	  		//}

	    }
	    else
	    {
	    	if (($preinv>=1) and ($preinv<=5)) $num = 0;
	    	elseif (($preinv>=6) and ($preinv<=10)) $num = 1;
	    	elseif (($preinv>=11) and ($preinv<=15)) $num = 2;
	    	elseif (($preinv>=16) and ($preinv<=20)) $num = 3;

	    	$datos=array($num,$codpro,'',$preinv);

	    	$registro = $objAsignacion->registrarAsignacion1($datos);
	    }

      	 if ($registro){
			 $descuento = $objInv->restarExistencia($preinv);
		 	 echo "<script>alert('Vehiculo asignado');</script>";
		 	 echo "<SCRIPT>window.location.href='listado_preproforma.php';</SCRIPT>";
		}
}

if ($indReg==2){
  if ($datos[0]=='0')
  {
  		 echo "<script>alert('Selecccione el serial del vehiculo que desea asignar');</script>";
  		 $listarAsignacion1=$objAsignacion->listarVehAsigPreInv($codpro,'','','',-1);
  		 echo "<SCRIPT>window.location.href='preproforma.php?codpro=$listarAsignacion1[0]&mod=1&asig=$asig1';</SCRIPT>";
  }
  else
  {
  	    $buscarserial=$objAsignacion->contarAsignacion($datos[0],'','','','','','','','','','');

	  	if($buscarserial==0){
	  		$modificar = $objAsignacion->modificarAsignacion2($_SESSION['idAsignacion'],$datos);
	  	}
	  	else
	  	{
	  		echo "<script>alert('El serial que tomo para asignar fue asignado previamente');</script>";
		    echo "<SCRIPT>window.location.href='listado_preproforma.php';</SCRIPT>";
	  	}
  }

	if ($modificar)   {
	     echo "<script>alert('Vehiculo Modificado, fue asignado el serial');</script>";
		 echo "<SCRIPT>window.location.href='listado_preproforma.php';</SCRIPT>";
	}
}


if ($indReg==3){
 $liberar = $objAsignacion->liberarVehPreInv($_SESSION['idAsignacion'],$codpro,$idsercarveh);

  if ($liberar){
	     echo "<script>alert('El vehiculo del beneficiario con RIF '.$codpro.' fue liberado');</script>";
		 echo "<SCRIPT>window.location.href='listado_preproforma.php';</SCRIPT>";
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

if (document.form1.codpro.value.length==0){
    alert("Debe Ingresar un N° de CI/RIF");
    document.form1.codpro.focus()
    return (false);
                                      }

if (document.form1.sercarveh.value.length==0){
    alert("Debe Ingresar un Vehículo del Preinventario");
    document.form1.sercarveh.focus()
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
        <td colspan="4" class="cabecera"><? if ($modif) echo "Modificar "; else "Asignar "; ?>Vehículo de Preinventario</td>
      </tr>
      <tr>
        <td class="categoria">C.I/RIF:</td>
        <td class="dato">
         <input name="codpro" type="text" id="codpro" maxlength="18" value="<?php if($ban==1)  echo $listarAsignacion[$i+1];?>" readonly=""/>
         <input type="button" onclick="catalogoAncho('cat_beneficiario.php');" value="..."/>
        </td>
         <td class="categoria">Nombre:</td>
        <td class="dato">
	        <input name="nombre" type="text" id="nombre"  value="<?php if($ban==1)  echo $listarAsignacion[$i+2];?>"  readonly="" />
        </td>
      </tr>
      <tr>
        <td class="categoria"><? if ($modif) echo "Veh&iacute;culo:"; else echo "Veh&iacute;culo de PreInventario:" ?></td>
        <td class="dato" colspan="3">
         <input name="sercarveh" type="text" id="sercarveh" maxlength="18" value="<?php if ($ban==1)  echo $listarAsignacion[$i];?>" readonly=""/>
         <input type="button" onclick="catalogoAncho('<? if ($modif) echo "cat_vehiculos.php?ti=asignacion&modveh=".$listarAsignacion1[$i+7]."&lote=".$listarAsignacion1[$i+13].""; else echo "cat_preinventario.php"?>');" value="..." />
        </td>
         <td class="dato">
	        <input name="idInv" type="hidden" id="idInv"  value="<?php if($ban==1)  echo $listarAsignacion[$i+2];?>"  readonly="" />
        </td>
      </tr>
      <tr>
      <!--<tr>
        <td class="categoria">Observaciones:</td>
        <td class="dato" colspan="3">
         <textarea name="obspro" cols="60" rows="2" id="obspro"  onblur="javascript:this.value=this.value.toUpperCase()" ><?php if($ban==1)  echo $listarAsignacion[$i+9];?></textarea>
        </td>
      </tr>-->
      <tr>
        <td height="22" colspan="4">
          <div align="center">
           <input type="hidden" name="indReg" >
           <?php if ((!$idsercarveh) and (!$modif) and (!$liber)){ ?>
            <input  type="button" onclick="validarCaract(1); return false" value="Crear" />
            <?php } if ((!$idsercarveh) and ($modif)){ if (($_SESSION['tipoUsuario'] == 1 or $_SESSION['tipoUsuario'] == 4  or  $_SESSION['tipoUsuario'] == 11 or  $_SESSION['tipoUsuario'] == 13 or  $_SESSION['tipoUsuario'] == 17 or  $_SESSION['tipoUsuario'] == 2))  {  ?>
             <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Modificar" />
            <?php } } if ((!$idsercarveh) and ($liber)){  ?>
             <input name="Liberar" type="button" id="Liberar" onclick="validarCaract('3'); return false" value="Liberar" />
            <?php } ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_preproforma.php'" value="Listar" />
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