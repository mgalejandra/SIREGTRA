<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/asignacion.php');
require('../modelos/inventario.php');
require('../modelos/factura.php');

$objInv = new inventario();
$objAsignacion = new asignacion();
$objFactura = new factura();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,11,13,17,18);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];
$tipo=$_GET['tipo'];


$objExcepcion = new asignacion();

$ban=0;
$indErr = false;

  $rif=$_POST['codpro'];
  $nombre=$_POST['nombre'];
  $caja = $_POST['caja'];

$data=array($rif,$nombre,$caja);

if ($indReg==1){


	$buscarExcepcion = $objExcepcion->f_excepciones1($rif,1,-1,$nombre);

	if ($buscarExcepcion){

        echo "<br>Estatus: ".$buscarExcepcion[2];

		if ($buscarExcepcion[2]=='L'){
            $activa=$objExcepcion->desbloqExcepcion($rif);
			if ($activa){
				echo '<SCRIPT>alert("Excepcion activada nuevamente");</SCRIPT>';
		      	echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
		        echo "<SCRIPT>window.close();</SCRIPT>";
			}

		}

	}
	else
	{
		 //echo "<br>Voy a registrar";
		 $registro=$objExcepcion->regExcepcion($data);

			if ($registro){
		       		echo '<SCRIPT>alert("Excepción agregada");</SCRIPT>';
		       		echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
		       		echo "<SCRIPT>window.close();</SCRIPT>";
		  	}
			else
			{
		       		echo '<SCRIPT>alert("Excepción no agregada");</SCRIPT>';
		       		echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
		       		echo "<SCRIPT>window.close();</SCRIPT>";
		  	}
	}

}

?>
<!DOCTYPE HTML PUBLIC>
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
     <TD class="cuerpo">
      <DIV class="nivel1">
       <DIV class="nivel2">
<!--  Contenido Principal         -->
  <form id="form1" name="form1" method="post" action="">
  <table class="formulario" width="822" border="0" align="center" >
      <tr>
        <td colspan="5" class="cabecera">Registro de Excepciones</td>
      </tr>
      <tr>
        <td class="categoria">C.I/RIF:</td>
        <td class="dato">
         <input name="codpro" type="text" id="codpro" maxlength="18" value="<?php if($ban==1) echo $listarAsignacion[$i+1];?>" readonly/>
         <input type="button" onclick="catalogoAncho('cat_beneficiario.php');" value="..."/>
        </td>
         <td class="categoria">Nombre:</td>
        <td class="dato">
	        <input name="nombre" type="text" id="nombre"  value="<?php if($ban==1) echo $listarAsignacion[$i+2];?>"  readonly />
        </td>
        <td><input type="radio" name="caja" id="caja"  value="S"/>Caja de Ahorro</td>
      </tr>
      <tr>
        <td height="22" colspan="5">
          <div align="center">
           <input type="hidden" name="indReg" >
           <input  type="button" onclick="validarCaract(1); return false" value="Agregar" />
  </div>
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
