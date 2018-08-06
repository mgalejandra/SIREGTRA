<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/envios.php');

$objenvios = new envios();
$objenvios = new envios();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,11,18,21,22,24);
validaAcceso($permitidos,$dir);
$ban=0;

$indReg=$_POST['indReg'];

 $_SESSION['numlotveh']=$_POST['numlotveh'];
 $_SESSION['numenv']=$_POST['numenv'];
 $_SESSION['gen']=$_POST['gen'];

$indErr = false;

//  $buscarEnvioVeh = $objenvios->buscarEnvioVeh('');

 // $buscarLotes = $objenvios->buscarLotes();

  $comboEnvio = $objenvios->listarEnvioVeh('A');


  if ($indReg == 1){
  	if ($_SESSION['gen'] == 'S'){
  	$cambiar=$objenvios->cambiarEstatusPla($_SESSION['numlotveh'],$_SESSION['tipo'],$_SESSION['numenv']);
  	if ($cambiar){
  		 echo "<SCRIPT> alert('Estatus Txt Placa Cambiado ');</SCRIPT>";
  		 echo "<SCRIPT>window.location.href='reportes/pdfpla.php';</SCRIPT>";

  	}
  		 else echo "<SCRIPT> alert('No hay Vehiculos Para Generar TXT');</SCRIPT>";
  	              }else {
  	              	 $buscar=$objenvios->buscarEstatus($_SESSION['numlotveh'],$_SESSION['tipo'],'','estatuspla');
  	              	 if ($buscar){
  	              	 echo "<SCRIPT> alert('Listado de Placas Para Generar TXT');</SCRIPT>";
  		             echo "<SCRIPT>window.location.href='reportes/pdfpla.php';</SCRIPT>";
  	              	 }else echo "<SCRIPT> alert('No hay Placas Para Listar');</SCRIPT>";
  	              }
  }

?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <title>TXT PLACAS </title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
   <script type="text/javascript" src="../controlador/funciones.js"></script>
   <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>


function campos_autorizacion(){


 if (document.form1.nombre.value.length==0){
    alert("Debe Ingresar El nombre Completo");
    document.form1.nombre.focus()
    return (false);
                                      }

if (document.form1.cedula.value.length==0){
    alert("Debe Ingresar La Cédula");
    document.form1.cedula.focus()
    return (false);
                                      }

var url = "reportes/pdfautorizacion.php";
document.form1.action=url;
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
        <td colspan="2" class="cabecera">Autorizaci&oacute;n</td>
      </tr>
     <tr>
        <td class="categoria">Nombre :</td>
        <td class="dato">
          <input name="nombre" title="Nombre Completo de la Persona Autorizada a entregar Medios Magneticos"
           type="text" id="nombre"  onblur="javascript:this.value=this.value.toUpperCase()" size="40" maxlength="40"/>
        </td>
      </tr>
       <tr>
        <td class="categoria">C&eacute;dula :</td>
        <td class="dato">
          <input name="cedula"  title="CI de  la Persona Autorizada a entregar Medios Magneticos"
          type="text" id="cedula"  onblur="javascript:this.value=this.value.toUpperCase()" size="40" maxlength="10" />
        </td>
      </tr>
       <tr>
        <td class="categoria">Presidente(a) :</td>
        <td class="dato">
        <input name="dir" type="text"  title="Nombre Completo del Presidente(a) que Autoriza"
        id="dir"  onblur="javascript:this.value=this.value.toUpperCase()" size="40" maxlength="40"  value="WILSON DAVID HERRERA BERMUDEZ" />
        
        </td>
      </tr>
       <tr>
        <td class="categoria">Departamento:</td>
        <td class="dato">
          <input name="departamento" type="text"  title="Departamento del Director(a) que Autoriza"
          id="departamento"  onblur="javascript:this.value=this.value.toUpperCase()" size="40" maxlength="40"  value="Presidente de Suministros Venezolanos Industriales C.A (SUVINCA)" />
        </td>
      </tr>
   <tr>
        <td class="categoria">Numero de Envio:</td>
        <td class="dato">
          <select name="envio" size="1" id="envio">
		           <option value="<?php echo $_SESSION['numenv']; ?>"><?php echo $_SESSION['numenv'] ?></option>
			   <?php for($i=0;$i<count($comboEnvio);$i++){  ?>
	               <option value="<?php echo $comboEnvio[$i]; ?>"><?php echo 'Envio Nro. ('.$comboEnvio[$i].') '; ?></option>
	           <?php } ?>
          </select>
        </td>
      </tr>

      <tr>
        <td colspan="4" >
         Nota: Adjuntar Fotocopia de Carnet y C&eacute;dula de Identidad de la persona a la cual se le esta generando la autorizacion.
        </td>
      </tr>
     <tr>
        <td height="22" colspan="2">
          <div align="center">
           <input type="hidden" name="indReg" >
            <input name="generar" type="button" id="generar" onClick="campos_autorizacion(); return false" value="Generar" />
            <input name="Button" type="button" class="form_button01" value="   Salir    " onClick="cerrar()" />
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
