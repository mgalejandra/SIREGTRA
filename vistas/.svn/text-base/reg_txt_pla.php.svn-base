<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/envios.php');

$objenvios = new envios();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,21,18,22);
validaAcceso($permitidos,$dir);
$ban=0;

$indReg=$_POST['indReg'];

 $_SESSION['numlotveh']=$_POST['numlotveh'];
 $_SESSION['numenv']=$_POST['numenv'];
 $_SESSION['gen']=$_POST['gen'];
 $_SESSION['precioj']=$_POST['precioj'];
 

$indErr = false;

  $buscarEnvioVeh = $objenvios->buscarEnvioVeh('1');

  $buscarLotes = $objenvios->buscarLotesDep(1);

  if ($indReg == 1){
  	if ($_SESSION['gen'] == 'S'){
  	$cambiar=$objenvios->cambiarEstatusPla($_SESSION['numlotveh'],$_SESSION['tipo'],$_SESSION['numenv'],$_SESSION['precioj']);
  	if ($cambiar){
  		 echo "<SCRIPT> alert('Estatus Txt Placa Cambiado ');</SCRIPT>";
  		 echo "<SCRIPT>window.location.href='reportes/pdfpla.php';</SCRIPT>";

  	}
  		 else echo "<SCRIPT> alert('No hay Vehiculos Para Generar TXT');</SCRIPT>";
  	              }else {
  	              	 $buscar=$objenvios->buscarEstatus($_SESSION['numlotveh'],$_SESSION['tipo'],'','estatuspla','tipmov_pla',$_SESSION['precioj']);
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

function validarCaract(dato){

 document.form1.indReg.value = dato;
 document.form1.submit();
 //  document.form1.action='reportes/pdftxt.php';
 //  document.form1.submit();

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
        <td colspan="4" class="cabecera">Archivo Txt Placas</td>
      </tr>
     <tr>
        <td class="categoria">Numero de envio  :</td>
        <td class="dato">
          <input name="numenv" type="text" id="numenv"  onkeypress="return acessoNumerico(event)" size="20" maxlength="7"  value="<?php echo $buscarEnvioVeh+1;?>" />
        </td>
         <td class="categoria">Ultimo Numero de envio  :</td>
        <td class="dato">
	        <input name="ultnumenv" type="text" id="ultnumenv"   size="20" maxlength="7" readonly="readonly"  value="<?php echo $buscarEnvioVeh;?>" />
        </td>
      </tr>
          <tr>
        <td class="categoria"> Ley Precio Justo :</td>
        <td class="dato">
           <select name="precioj" id="precioj">
            <option value="0">No</option>
             <option value="1">Si</option>
           </select>
        </td>
        <tr>
        <td class="categoria">Numero de Lote  :</td>
        <td class="dato">
           <select name="numlotveh" id="numlotveh">
            <option value="0">Todos</option>
            <?php for($i=0;$i<count($buscarLotes);$i+=2){?>
            <option value="<?php echo $buscarLotes[$i]?>"><?php echo $buscarLotes[$i]." - ".$buscarLotes[$i+1]?></option>
            <?php } ?>
           </select>
        </td>
         <td class="categoria">Desea Generar Txt:</td>
        <td class="dato">
	        <select name="gen" id="gen">
            <option value="N">NO</option>
            <option value="S">SI</option>
           </select>
        </td>
      </tr>
      <tr>
      <tr>
        <td colspan="4" >
         Nota: Si selecciona la Opcion Si desea generar txt el estatus de los vehículo sera cambiando y no Podra volver a generar el Txt de esos Vehiculos.
        </td>
      </tr>
        <td height="22" colspan="4">
          <div align="center">
           <input type="hidden" name="indReg" >
           <?php if (!$idventa) { ?>
            <input  type="button" onclick="validarCaract(1); return false" value="Generar" />
            <?php } if ($idventa) { ?>
            <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Modificar" />
            <?php } ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_ventas.php'" value="Listar" />
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
