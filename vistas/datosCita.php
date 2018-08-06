<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/beneficiario.php');
require('../modelos/zona.php');
require('../modelos/pago.php');
require('../modelos/citas.php');

$objBeneficiario = new beneficiario();
$objPago 		= new pago();
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,11,13,14,17,22);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];
$cedula=$_GET['id'];
$cita=$_GET['cita'];
$rif=$_GET['rif'];

$rif2=$_POST['rif2'];

//echo 'hola1'.$rif2;
//echo '<br>holaaaaa'.$cedula;

$objCita = new citas();

if ($indReg==1){

	$buscar = $objCita->buscarValidar($rif2);

	if ($buscar) {

		$confCita = $objCita->modconfirmarCita($rif,$cedula,$cita);

	}else{

	    $confCita = $objCita->confirmarCita($cedula,$cita);

	}

	if ($confCita)   {
	     echo "<script>alert('Cita Confirmada');</script>";
		 echo "<SCRIPT>window.location.href='listado_citas.php';</SCRIPT>";

		$_SESSION['nac']=null;
  		$_SESSION['numrif']=null;
  		$_SESSION['digrif']=null;
  		$_SESSION['banco']=null;
	}

}

$verificar=$objCita->verificar($rif);

//echo $verificar[0];

if ($verificar[0]){

	echo "<script>alert('Esta Persona ya tiene un vehiculo Asignado');</script>";
}

$datosCitas=$objCita->datosCitasUsuario($cedula,$cita);

$listarBancos=$objPago->listarBancos(3);

//echo $datosCitas[35];

$objZona= new zona();
if ($datosCitas[35]) $datoslistarBancos=$objPago->listarBancos(4,$datosCitas[35]);
$buscarEstados = $objZona->buscarEstados($datosCitas[18]);
$buscarMunicipio = $objZona->buscarMunicipios($datosCitas[19],$datosCitas[18]);
$buscarParroquia = $objZona->buscarParroquias($datosCitas[20],$datosCitas[18],$datosCitas[19]);
//echo 'hola'.$datosCitas[6];
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

    function enviarS(dato){

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
        <td colspan="4" class="cabecera">Datos de Cita </td>
      </tr>
      <!--<tr>
        <td class="categoria">Numero Cita:</td>
		  <td colspan="2" class="dato">
				<?PHP //echo$datosCitas[0];?>
		        </td>
      </tr>-->
      <tr>
        <td class="categoria">Fecha:</td>
		  <td class="dato">
				<?PHP echo $datosCitas[5];?>
		        </td>
		      <td class="categoria">Turno:</td>
		  <td class="dato">

				<?PHP if ($datosCitas[4]==1) echo 'Mañana';?>
				<?PHP if ($datosCitas[4]==2) echo 'Tarde';?>
		        </td>
           </tr>
      <tr>

      <tr>
        <td colspan="4" class="cabecera">Datos del Beneficiario </td>
      </tr>

            <tr>
        <td class="categoria">Banco:</td>
		  <td colspan="2" class="dato">
				<?PHP echo $datoslistarBancos[1];?>
		        </td>
           </tr>
      <tr>

        <td class="categoria">RIF / CI:</td>
        <td class="dato" >
        <?PHP echo $datosCitas[9].$datosCitas[7].$datosCitas[8] ?>
		</td>
           </tr>
    <td class="categoria">Fecha de Nacimiento:</td>
        <td class="dato">
	       <?PHP echo $datosCitas[23]?>
        </td>
 </td>
        <td class="categoria">Sexo:</td>
        <td class="dato">
        <?PHP if ($datosCitas[21]=='F') echo 'Femenino';
        elseif ($datosCitas[21]=='M') echo 'Masculino'; ?>
        </td>

      </tr>
      <tr>
        <td class="categoria">Nombre: </td>
        <td class="dato">
         <?PHP echo $datosCitas[10]?>
        </td>
  </tr>
  </tr>
      <tr>
        <td class="categoria">Correo: </td>
        <td class="dato">
         <?PHP echo $datosCitas[24]?>
        </td>
  </tr>
  <tr>
        <td colspan="4" class="cabecera">Datos Laborales</td>
      </tr>
            <tr>
        <td class="categoria">RIF:</td>
        <td class="dato" colspan="3">
         <?PHP echo $datosCitas[36]?>
        </td>
      </tr>
      <tr>
        <td class="categoria">Descripción:</td>
        <td class="dato" colspan="3">
         <?PHP echo $datosCitas[37]?>
        </td>
      </tr>
  <tr>
        <td colspan="4" class="cabecera">Direcci&oacute;n</td>
      </tr>
      <tr>
        <td class="categoria">Calle/avenida:</td>
        <td class="dato">
         <?PHP echo $datosCitas[11]?>
        </td>
        <td class="categoria">Urb. o Barrio:</td>
        <td class="dato">
         <?PHP echo $datosCitas[12]?>
        </td>
      </tr>
      <tr>
        <td class="categoria">Edificio/casa/quinta:</td>
        <td class="dato" >
          <?PHP echo $datosCitas[13]?>
       </td>
        <td class="categoria">N&uacute;mero de piso:</td>
        <td class="dato" >
          <?PHP echo $datosCitas[14]?>
       </td>
      </tr>
        <tr>
        <td class="categoria">N° de Apartamento:</td>
        <td class="dato" >
          <?PHP echo $datosCitas[25]?>
      </tr>
      <TR>
    <TD width="175" class="categoria"><strong>Estado:<?php echo $listarBeneficiario[$i+38];?></strong></TD>
    <TD colspan="3" class="dato">
    	<?PHP echo $buscarEstados[1]?>
    </TD>
  </TR>
    <TR>
    <TD width="175" class="categoria"><strong>Municipio:</strong></TD>
    <TD colspan="3" class="dato">
        <?PHP echo $buscarMunicipio[1]?></TD>
  </TR>
    <TR>
    <TD width="175" class="categoria"><strong>Parroquia:</strong></TD>
    <TD colspan="3" class="dato">
        <?PHP echo $buscarParroquia[1]?></TD>
  </TR>
      <tr>
        <td class="categoria"> Tlf/Celular 1:</td>
        <td class="dato" >
          <?PHP echo $datosCitas[26].' / '.$datosCitas[27]?></TD>
       </td>
        <td class="categoria">Tlf/celular 2:</td>
        <td class="dato" >
          <?PHP echo $datosCitas[28].' / '.$datosCitas[29]?></TD>
       </td>
      </tr>
        <tr>
        <td class="categoria">Tipo de Beneficiario</td>

        <td class="dato">
        <?PHP if ($datosCitas[22]==1) echo 'Discapacidad';?>
        <?PHP if ($datosCitas[22]==2) echo 'Victima de Estafa';?>
        <?PHP if ($datosCitas[22]==3) echo 'Medicos y Enfermeras';?>
        <?PHP if ($datosCitas[22]==4) echo 'Educadores';?>
        <?PHP if ($datosCitas[22]==5) echo 'Personal Militar';?>
        <?PHP if ($datosCitas[22]==6) echo 'Funcionarios publicos';?>
        <?PHP if ($datosCitas[22]==7) echo 'Otros';?>
       </td>
      </tr>
      <?php if ($datosCitas[38]<>1) { ?>
      <tr>
      	<td class="categoria">N° de Carnet:</td>
      	<td class="dato">
      		<?PHP echo $datosCitas[38];?>
      	</td>
      </tr>
      <?php } ?>
       <tr>
        <td class="categoria">Observaciones:</td>
        <td class="dato" colspan='3'>
          <?PHP echo $datosCitas[30]?></TD>
       </td>
      </tr>
       <tr>
        <td height="22" colspan="4">
            <div align="center">  </div>
         </td>
       </tr>
       <?php $fecha = date('d/m/Y');
       	$cant = strlen($datosCitas[7]);
       	//echo 'cant'.$cant;
       	//echo 'cedula'.$datosCitas[7];
		if ($cant==8){ $cedula=$datosCitas[7]; }
		if ($cant==7){ $cedula='0'.$datosCitas[7]; }
		if ($cant==6){ $cedula='00'.$datosCitas[7]; }
		//echo 'cedula2'.$cedula;
       $rif2=$datosCitas[9].$cedula.$datosCitas[8];
      // echo $rif;
       ?>
       <INPUT type="hidden" name="rif2" value='<?php echo $rif2 ?>'>
      <tr>
        <td height="22" colspan="4">
          <div align="center">
           <input type="hidden" name="indReg" >
           <?php if ((!$verificar[0]) and ($_SESSION['usuario']<>'tleal')) { ?>
           	<?php if ($datosCitas[6]=='A') { ?>
           		<?php if ($datosCitas[5]==$fecha) { ?>
            <input name="Confirmar" type="button" id="Confirmar" onclick="enviarS(1)" value="Confirmar Cita" />
            <input name="Modificar" type="button" id="Modificar" onclick="window.location.href='reg_beneficiariosPre.php?preidbenefi=<?php echo $datosCitas[7]?>&cita=<?php echo $datosCitas[0]?>&rif=<?php echo $rif?>'" value="Modificar" />
           		<?php } ?>
           <?php } ?>
           <?php } ?>

           <?php if ($_SESSION['usuario']=='tleal') { ?>
            <input name="Confirmar" type="button" id="Confirmar" onclick="enviarS(1)" value="Confirmar Cita" />
            <input name="Modificar" type="button" id="Modificar" onclick="window.location.href='reg_beneficiariosPre.php?preidbenefi=<?php echo $datosCitas[7]?>&cita=<?php echo $datosCitas[0]?>&rif=<?php echo $rif?>'" value="Modificar" />
           <?php } ?>

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