<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/departamento.php');
require('../modelos/estatus.php');
require('../modelos/banco.php');



$objBanco = new banco();
$objDepartamento = new departamento();
$objEstatus = new estatus();


$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5);
validaAcceso($permitidos,$dir);

$nume=($_POST['id_banco']);
$numdep=($_POST['numdep']);
$id_estatus=($_POST['id_estatus']);



?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
    <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>
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
<table class="formulario" width="250" height="140 " border="0" align="center" >
      <tr>
        <td colspan="6" class="cabecera">Registro Maestro </td>
      </tr>
      <tr>
        <td align="right" class="categoria"> ESTATUS:</td>
        <td colspan="3" class="dato">
           <input name="id_estatus" type="button" id="id_estatus" onclick="catalogo('cat_estatus.php');" value="...     " />
       </td>
        </tr>
         <tr>
        <td class="categoria">DEPARTAMENTOS:</td>
        <td colspan="3" class="dato">
          <input name="numdep" type="button" id="numdep" onclick="catalogo('cat_dep.php');" value="...     " />
       </td>
        </tr>
       <tr>
        <td class="categoria">BANCOS:</td>
        <td colspan="3" class="dato">
          <input name="id_banco" type="button" id="id_banco" onclick="catalogo('cat_banco.php');"value="...     " />
        </td>
      </tr>

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