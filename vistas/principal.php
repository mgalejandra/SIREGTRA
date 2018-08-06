<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(2,3,4,5);
validaAcceso($permitidos,$dir);
?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>

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
<table class="completo3">
  <tbody>
    <tr>
      <td class="titulo2">
      Sistema de Registro de Transferencias 
      </td>
    </tr>
  </tbody>
</table>
<table class="completo3">
  <tbody>
    <tr>
      <td colspan="2" valign="top" class="detallesB"> <div align="justify">
        <p> <li> Consiste en llevar un registro de todas las Transferencia ya sean Internas o BCV</p>
       
       
      </div></td>
    </tr>
    </tbody>
</table>
	   <table width="75%"  border="2"  class="completo2">
       <p class="titulo2"></p>
           <span style="text-align:center ">	
      
            <div align="center"><img src="imagenes/tesoreria.jpg"  border="2" />
      <br>
      <br>
      	     	  </tr>
      </table>
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
