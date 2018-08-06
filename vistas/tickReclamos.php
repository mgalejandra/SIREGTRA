<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/beneficiario.php');
require('../modelos/zona.php');
require('../modelos/factura.php');
require('../modelos/reclamos.php');
require('../modelos/correo.php');
$objFactura = new factura();
$objBeneficiario = new beneficiario();
$objReclamos = new reclamos();
$objCorreo = new correo();
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,11,13,14,17,22);
validaAcceso($permitidos,$dir);
//echo $_SESSION['correo'];
$regReclamo=$_GET['id'];
$cedula=$_GET['cedula'];
$tramite=$_GET['tramite'];

$indReg=$_POST['indReg'];
$idReclamo=$_POST['idReclamo'];
$observ=$_POST['observ'];
$usuario=$_POST['asignar'];
$diferido=$_POST['diferido'];
$correousu=$_POST['correousu'];
$usuarioEnc=$_POST['usuarioEnc'];

//echo 'hola';

if($cedula){
	$listarFactura=$objFactura->reporteFactura('','',$cedula);
}

if ($listarFactura){
	$detalleVehiculo=$objFactura->detalleVehiculo($listarFactura[9]);
}

$reclamo=$objReclamos->buscarReclamo($regReclamo);

$reclamodet=$objReclamos->buscarReclamoDet($regReclamo);
$listarPersonas = $objReclamos->listarpersonas();


$objZona= new zona();
$buscarEstados = $objZona->buscarEstados($listarFactura[25]);
$buscarMunicipio = $objZona->buscarMunicipios($listarFactura[26],$listarFactura[25]);
$buscarParroquia = $objZona->buscarParroquias($listarFactura[27],$listarFactura[25],$listarFactura[26]);
//echo 'hola'.$datosCitas[6];

if($indReg){

	$reclamoCambStatus=$objReclamos->cambiarStatus($indReg,$regReclamo,$observ,$usuario,$diferido,$_SESSION['observB'],$_SESSION['usuario']);

	if ($indReg==1) {
		$correoEnc=$_SESSION['correo'];
		$listarPersonas = $objReclamos->listarpersonas($usuario);
		$correoAsg=$listarPersonas[3];
	}
	if($indReg==5){
		$listarPersonas = $objReclamos->listarpersonas($usuarioEnc);
		$correoEnc=$listarPersonas[3];
		$correoAsg=$_SESSION['correo'];
		}

	if($indReg==2 or $indReg==3){
		$correoAsg=$_SESSION['correo'];
		$listarPersonas = $objReclamos->listarpersonas($usuarioEnc);
		$correoEnc=$listarPersonas[3];
		$correoUsu=$correousu;
 	}

		$regCorreo=$objCorreo->enviarCorreoStatus($regReclamo,$correoAsg,$correoEnc,$nombre,$indReg,$usuario,$correoUsu,$diferido,$observ);


	if ($reclamoCambStatus){
		 echo "<script>alert('Estatus Modificado');</script>";
		 //echo "<SCRIPT>window.location.href='listado_beneficiarios.php';</SCRIPT>";
		 echo "<SCRIPT>window.location.href='listado_reclamos.php';</SCRIPT>";
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
      <script type="text/javascript" src="../controlador/jquery.js"></script>
    <script type="text/javascript" src="../controlador/jquery-ui.js"></script>
    <script type="text/javascript" src="../controlador/jquery.idle-timer.js"></script>
<SCRIPT LANGUAGE='JavaScript'>

var txt=" Registro de Beneficiario del Sistema de Vehiculos SUVINCA ";
var espera=100;
var refresco=null;
function rotulo_title( ) {
document.title=txt;
txt=txt.substring(1,txt.length
)+txt.charAt(0);
refresco=setTimeout("rotulo_title( )",espera);}
//rotulo_title( );

	function popup(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=400,height=400');");
	}

	function popupPDF(URL) {
 		day = new Date();
 		id = day.getTime();
 		eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=450,height=600');");
	}

    function enviarS(dato){

 		document.form1.indReg.value = dato;
 		document.form1.submit();
    }

    function cambiarStatus(dato,dato2){
	alert('dato2');

	if ((dato==3) || (dato==2)){
		if (document.form1.observ.value.length==0){
    		alert("Debe Ingresar una Observacion");
    		document.form1.observ.focus()
    		return (false);
    	}
	}

		document.form1.diferido.value = dato2;
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
  <input type="hidden" id="num_campos" name="num_campos" value="0" />
  <input type="hidden" id="cant_campos" name="cant_campos" value="0"/>
  <input type="hidden" id="idReclamo" name="idReclamo" value="<?php echo $reclamo[0] ?>"/>
  <input type="hidden" name="indReg"/>
  <input type="hidden" name="diferido"/>
  <input type="hidden" id="usuarioEnc" name="usuarioEnc" value="<?php echo $reclamo[7] ?>"/>
  <table class="formulario" width="822" border="0" align="center" >
     <tr>
     	<td colspan="2" class="categoria">Estatus</td>
     	<td colspan="1" class="dato"><?php echo $reclamo[3] ?></td>
		<td colspan="2" class="categoria">Numero de Ticke</td>
     	<td colspan="1" class="dato"><?php echo str_pad($reclamo[0],5,'0',STR_PAD_LEFT) ?></td>
     </tr>
      <tr>
        <td colspan="6" class="cabecera">Datos del Beneficiario </td>
      </tr>
      <tr>
        <td class="categoria">RIF / CI:</td>
        <td  class="dato" >
        <?PHP echo $listarFactura[13] ?>
        <input type="hidden" id="cedula" name="cedula" value="<?php echo $listarFactura[13] ?>"/>
		</td>
		<td class="categoria">Nombre:</td>
        <td colspan="6" class="dato">
         <?PHP echo $listarFactura[12]?>
        </td>
      </tr>
      <tr>
        <td colspan="6" class="cabecera">Direccion </td>
      </tr>
      <tr>
        <td class="categoria">Calle/avenida:</td>
        <td colspan="3" class="dato">
         <?PHP echo $listarFactura[14]?>
        </td>
        <td class="categoria">Urb. o Barrio:</td>
        <td colspan="2" class="dato">
         <?PHP echo $listarFactura[15]?>
        </td>
      </tr>
      <tr>
		<td class="categoria">Edificio/casa/quinta:</td>
        <td class="dato" >
          <?PHP echo $listarFactura[16]?>
       </td>
        <td class="categoria">N&uacute;mero de piso:</td>
        <td class="dato" >
          <?PHP echo $listarFactura[17]?>
       </td>
       <td class="categoria">N° de Apartamento:</td>
        <td class="dato" >
          <?PHP echo $listarFactura[18]?>
      </td>
      </tr>
      <TR>
    <TD width="175" class="categoria"><strong>Estado:<?php echo $listarBeneficiario[$i+38];?></strong></TD>
    <TD class="dato">
    	<?PHP echo $buscarEstados[1]?>
    </TD>
        <TD width="175" class="categoria"><strong>Municipio:</strong></TD>
    <TD  class="dato">
        <?PHP echo $buscarMunicipio[1]?></TD>
        <TD width="175" class="categoria"><strong>Parroquia:</strong></TD>
    <TD  class="dato">
        <?PHP echo $buscarParroquia[1]?></TD>
  </TR>
      <tr>
        <td class="categoria"> Tlf/Celular 1:</td>
        <td class="dato" >
          <?PHP echo $listarFactura[21]?></TD>
        <td class="categoria">Tlf/celular 2:</td>
        <td class="dato" >
          <?PHP echo $listarFactura[22]?></TD>
        <td class="categoria">Correo:</td>
        <td class="dato" >
          <?PHP echo $listarFactura[56]?></TD>
		<input type="hidden" id="correousu" name="correousu" value="<?php echo $listarFactura[56] ?>"/>
      </tr>
  <tr>
        <td colspan="6" class="cabecera">Datos del Vehiculo</td>
      </tr>

      <tr>
      	<td class="categoria">MARCA:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[5]?>
        </td>
        <td class="categoria">MODELO:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[6]?>
        </td>
        <td class="categoria">PLACA:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[1]?>
        </td>
      </tr>

      <tr>
      	<td class="categoria">SERIE/VERSION:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[7]?>
        </td>
        <td class="categoria">AÑO DE FABRICACION:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[8]?>
        </td>
        <td class="categoria">AÑO DE MODELO:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[9]?>
        </td>
      </tr>

      <tr>
        <td class="categoria">SERIAL DE CARROCERIA:</td>
        <td class="dato" colspan="3">
         <?PHP echo $detalleVehiculo[2]?>
        </td>
        <td class="categoria">SERIAL DE MOTOR:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[10]?>
        </td>
      </tr>

      <tr>
      	<td class="categoria">COLOR(ES):</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[12].' '.$detalleVehiculo[13];?>
        </td>
        <td class="categoria">CLASE:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[14]?>
        </td>
        <td class="categoria">TIPO:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[15]?>
        </td>
      </tr>

      <tr>
      	<td class="categoria">USO:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[16]?>
        </td>
        <td class="categoria">N° DE PUESTOS:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[17]?>
        </td>
        <td class="categoria">N° DE EJES:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[18]?>
        </td>
      </tr>

      <tr>
      	<td class="categoria">PESO (TARA):</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[19]?>
        </td>
        <td class="categoria">CAPACIDAD DE CARGA:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[20]?>
        </td>
        <td class="categoria">TIPO DE COMBUSTIBLE:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[11]?>
        </td>
      </tr>

      <tr>
      	<td colspan="6" class="cabecera">Datos del Reclamo</td>
      </tr>
      <tr>
		<td colspan="2" class="categoria">Tipo de Tramite: </td>
		<td colspan="4" class="dato"><?php echo $reclamo[2] ?></td>
	</tr>

   <?php if ($tramite==1){
   	$cant=count($reclamodet)/4;
   	if ($cant==2){?>
    <tr>
        <td colspan="2" class="categoria"><?php echo 'Copia de: '?></td>
		<td colspan="2" class="dato"><?php echo $reclamodet[3] ?></td>
		<td colspan="2" class="dato"><?php echo $reclamodet[7] ?></td>
	</tr>
   	<?php }else{?>

     <tr>
     	<td colspan="2" class="categoria"><?php echo 'Copia de: '?></td>
		<td colspan="3" class="dato"><?php echo $reclamodet[3] ?></td>
	</tr>

    <?php } ?>


	<?php } ?>

	<?php if ($tramite==2){ ?>
	<tr>
		<td class="cabecera" colspan="3">Campo</td>
		<td class="cabecera" colspan="3">Descripcion</td>
	</tr>
	<?php
	$cant=count($reclamodet)/4;
	for ($i = 0; $i < $cant; $i++) {?>
	<tr>
		<td class="dato" colspan="3"><?php echo $reclamodet[$i*4+3] ?></td>
		<td class="dato" colspan="3"><?php echo $reclamodet[$i*4+2] ?></td>
	</tr>
    <?php   }?>
	<?php } ?>

    <tr>

	<?php if ($tramite==3){ $envio=$objFactura->envio($listarFactura[9]);?>
	<tr>
		<td class="categoria" colspan="2" >Estatus de Envio</td>
		<?php if ($envio) {?>
		<td colspan="4" class="dato"> <?php echo "DATOS ENVIADOS AL INTT N° DE ENVIO ". $envio[1] ." EN FECHA ".$envio[0] ?></td>
		<?php }?>
	</tr>
	<tr>
	<td class="categoria" colspan="2">Problemas Registro de Vehiculo</td>
	<td class="dato" colspan="4"><?php echo $reclamodet[2] ?></td>
	</tr>
	<?php } ?>



	<?php if ($tramite==4){ $entrega=$objFactura->entrega($listarFactura[9]);?>
	<tr>
	<td colspan="6">

			<table class="formulario" width="822" border="0" align="center">
		<tr>
			<td class="categoria">Fecha de Factura:</td>
			<td class="dato"><?php echo $entrega[3]?></td>
			<td class="categoria">Fecha de Entrega:</td>
			<td class="dato"><?php echo $entrega[0]?></td>
		</tr>
		<tr>
			<td class="categoria">Lugar:</td>
			<td class="dato"><?php echo $entrega[1]?></td>
			<td class="categoria">Acto:</td>
			<td class="dato"><?php echo $entrega[2]?></td>
		</tr>
		<tr>
			<td class="categoria">Kilometraje</td>
			<td class="dato" ><?php echo $reclamodet[1] ?></td>
		</tr>
		<tr>
			<td class="cabecera" colspan="2">Tipo de Falla</td>
			<td class="cabecera" colspan="2">Observaciones</td>
		</tr>
		<?php
		$cant=count($reclamodet)/4;
		for ($i = 0; $i < $cant; $i++) { ?>
		<tr>
			<td class="dato" colspan="2"><?php echo $reclamodet[$i*4+3] ?></td>
			<td class="dato" colspan="2"><?php echo $reclamodet[$i*4+2] ?></td>
		</tr>
    	<?php   }?>
		<?php } ?>
      <tr>
      	<td colspan="6" class="cabecera">Datos del Caso</td>
      </tr>

	<?php if(($reclamo[4]==2) or ($reclamo[4]==3) ) { ?>
		<tr>
		<td class="categoria" colspan="2">Observacion</td>
		<td colspan="4" class="dato">
  			<textarea name="observ" id="observ" rows="3" cols="80" wrap="off"></textarea>
  		</td>
		</tr>
	<?php } ?>
	<?php  if((($_SESSION['tipoUsuario']==4) and ($_SESSION['numeDepa']==1)) and (!$reclamo[6]) and ($reclamo[4]==1)) {?>
	<tr>
	<td colspan="2" class="categoria">Asignar Caso</td>
	<td colspan="4" class="dato">
	<select name="asignar" size="1" id="asignar">
		  <?php for($i=0;$i<(count($listarPersonas));$i+=4){  ?>
	      <option value="<?php  echo $listarPersonas[$i]; ?>"><?php echo $listarPersonas[$i+1]." ".$listarPersonas[$i+2]?></option>
	      <?php } ?>
    </select>
	</td>
	<tr>
	<?php }elseif ($reclamo[6]) {?>
		<tr>
		<td colspan="2" class="categoria">Caso Asignado</td>
		<td colspan="4" class="dato"><?php echo $reclamo[6] ?></td>
	<tr>
	<?php }?>
	<?php  if ($reclamo[5]) {?>
		<tr>
		<td class="categoria" colspan="2">Observacion</td>
		<td colspan="4" class="dato"><?php echo $reclamo[5]; $_SESSION['observB']=$reclamo[5];?>

  		</td>
		</tr>
	<?php } ?>
 </table>

<table width="822" border="0" align="center" >
	<tr>

	<td>
		<input type="button" id="imprimir" name="imprimir" value="Imprimir"  onclick="popupPDF('reportes/pdf_reclamo_int.php?id=<?php echo $reclamo[0]?>&cedula=<?php echo $listarFactura[13]?>&tramite=<?php echo $tramite?>');return false;"/>
	</td>

<?php  if(($reclamo[4]==1) and ($_SESSION['tipoUsuario']==4)) {//usuario_asignado?>
	<td>
		<input type="button" id="asignar" name="asignar" value="Asignar Caso"  onclick="cambiarStatus(<?php echo $reclamo[4] ?>,0)"/>
	</td>
<?php } ?>

<?php  if(($reclamo[4]==5) and ($_SESSION['usuario']==$reclamo[6])) {?>
	<td>
		<input type="button" id="procesar" name="procesar" value="Procesar Caso"  onclick="cambiarStatus(<?php echo $reclamo[4] ?>,0)"/>
	</td>
<?php } ?>

<?php  if(($reclamo[4]==2) and ($_SESSION['usuario']==$reclamo[6])) {?>
	<td>
		<input type="button" id="diferir" name="diferir" value="Diferir Caso"  onclick="cambiarStatus(<?php echo $reclamo[4] ?>,1)"/>
	</td>
	<td>
		<input type="button" id="cerrar" name="cerrar" value="Cerrar Caso"  onclick="cambiarStatus(<?php echo $reclamo[4] ?>,0)"/>
	</td>
<?php } ?>

<?php  if(($reclamo[4]==3) and ($_SESSION['usuario']==$reclamo[6])) {?>
	<td>
		<input type="button" id="cerrar" name="cerrar" value="Cerrar Caso"  onclick="cambiarStatus(<?php echo $reclamo[4] ?>,0)"/>
	</td>
<?php } ?>

	<td>
		<input name="listar" type="button" id="listar" onclick="window.location.href='listado_reclamos.php'" value="Listar" />
	</td>
	</tr>
</table>

    </form>
<!--  FIN Contenido Principal         -->
       </DIV>
      </DIV>
     </TD>
    </TR>
    <TR>
     <TD class="piedepagina" colspan="6">
      <?php include("piedepagina.php") ?>
     </TD>
    </TR>
   </TABLE>
  </body>
</html>