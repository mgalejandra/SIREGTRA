<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/asignacion.php');
require('../modelos/inventario.php');
require('../modelos/factura.php');
require('../modelos/pago.php');

$objInv = new inventario();
$objAsignacion = new asignacion();
$objFactura = new factura();
$objPago = new pago();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,11,13,17,18,25);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];
$tipo=$_GET['tipo'];

$ban=0;
$indErr = false;


  $sercarveh=$_POST['sercarveh'];
  $codpro=$_POST['codpro'];
  $obspro=$_POST['obspro'];


$idsercarveh = ($_GET['idsercarveh']) ? $_GET['idsercarveh'] : $_POST['sercarveh'];

$datos = array($sercarveh,$codpro,$obspro);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');
//echo $tipo;
if ($idsercarveh and $indReg!=2)  {
	$ban=1;
	$i=0;
	//echo 'entro';
	$listarAsignacion=$objAsignacion->listarAsignacion($idsercarveh,'','','','','',0,$tipo);
	$_SESSION['idAsignacion']=$listarAsignacion[4];

	$listarFactura=$objFactura->listarFactura('',$idsercarveh,'','');
	//echo "Estatus: ".$listarFactura[10];
}

if ($indReg==1){
	$ban=1;
	$i=0;
	//echo 'entro: '.count($datos);}
	$listarAsignacion=$objAsignacion->listarAsignacion($idsercarveh,'','','','','',0,$tipo);
    //echo 'aqui:'.$listPlacas[0];
   if ($listarAsignacion[0]!=''){
	     echo "<script>alert('el vehiculo: ".$listarAsignacion[0]." fue asignado a: ".$listarAsignacion[2]."');</script>";
	     echo "<SCRIPT>window.location.href='listado_asignacion.php';</SCRIPT>";
   }else
   {
   	     $listarAsignacion1=$objAsignacion->listarAsignacion('',$codpro,'','','','',0,$tipo);
	   	 if ($listarAsignacion1[0]!='' and $listarAsignacion1[7]!='G' and !$objAsignacion->f_excepciones($listarAsignacion1[1])){
		  echo "<script>alert('la Persona: ".$listarAsignacion1[2]." tiene asignado el Vehiculo: ".$listarAsignacion1[0]."');</script>";
		  echo "<SCRIPT>window.location.href='listado_asignacion.php';</SCRIPT>";
	    }else
      	  $registro = $objAsignacion->registrarAsignacion($datos);

   }

	if ($registro){
		 $buscaPreinv = $objInv->buscarPreInv($sercarveh);
		// echo "El id es: ".$buscaPreinv[0];
		 if ($buscaPreinv) $descuento = $objInv->restarExistencia($buscaPreinv[0]);
		 echo "<script>alert('Vehiculo Asignado');</script>";
		 echo "<SCRIPT>window.location.href='listado_asignacion.php';</SCRIPT>";
	}else  {
		echo "<script>alert('Error Vuelva a intentarlo');</script>";
		echo "<SCRIPT>window.location.href='reg_asignacion.php';</SCRIPT>";
	}
}

if ($indReg==2){
    $cont_pag=$objPago->Cuenta_pago($_SESSION['idAsignacion']);
    $modificar = $objAsignacion->liberarAsignacion($_SESSION['idAsignacion'],$codpro,$sercarveh,$obspro);


	if ($modificar)   {
	     echo "<script>alert('Vehiculo Liberado, Certificado y Factura Anuladas y tiene :".$cont_pag." pago(s) asociado(s)');</script>";
		 echo "<SCRIPT>window.location.href='listado_asignacion.php';</SCRIPT>";
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
    alert("Debe Ingresar un N° de serial de Carroceria");
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
        <td colspan="4" class="cabecera">Asignacion de Vehiculos</td>
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
        <td class="categoria">Vehiculos:</td>
        <td class="dato" colspan="3">
         <input name="sercarveh" type="text" id="sercarveh" maxlength="18" value="<?php if( $ban==1 )  echo $listarAsignacion[$i];?>" readonly=""/>
         <input type="button" onclick="catalogoAncho('cat_vehiculos.php?ti=asignacion');" value="..." />
        </td>
      </tr>
      <tr>
      <tr>
        <td class="categoria">Observaciones:</td>
        <td class="dato" colspan="3">
         <textarea name="obspro" cols="60" rows="2" id="obspro"  onblur="javascript:this.value=this.value.toUpperCase()" ><?php if($ban==1)  echo $listarAsignacion[$i+9];?> </textarea>
        </td>
      </tr>
      <tr>
        <td height="22" colspan="4">
          <div align="center">
           <input type="hidden" name="indReg" >
           <?php if (!$idsercarveh) { ?>
            <input  type="button" onclick="validarCaract(1); return false" value="Asignar" />
            <?php }

            if ($_SESSION['usuario']=='tleal')
            {
	            if (($idsercarveh and ($_SESSION['tipoUsuario'] == 1 or  $_SESSION['tipoUsuario']== 2 or $_SESSION['tipoUsuario'] == 4  or  $_SESSION['tipoUsuario'] == 11 or  $_SESSION['tipoUsuario'] == 13 or  $_SESSION['tipoUsuario'] == 17 or  $_SESSION['tipoUsuario'] == 18)) and $tipo<>'L' ) {
            ?>
            <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Liberar" />
            <?php }
	            }
            else
            {
            	if (($idsercarveh and ($_SESSION['tipoUsuario'] == 1 or  $_SESSION['tipoUsuario']== 2 or $_SESSION['tipoUsuario'] == 4  or  $_SESSION['tipoUsuario'] == 11 or  $_SESSION['tipoUsuario'] == 13 or  $_SESSION['tipoUsuario'] == 17 or  $_SESSION['tipoUsuario'] == 18)) and $tipo<>'L' and ($listarFactura[10]<>'15')) {
           ?>
           <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Liberar" />
            <? }
            	} ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_asignacion.php'" value="Listar" />

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
