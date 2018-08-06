<?php
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
if(!$_SESSION['usuario']){
  echo '<SCRIPT>alert("Debe iniciar sesión para acceder a esta opción");window.location.href="index.php"</SCRIPT>';
}
if($_SESSION['tipoUsuario'] != 3){
  session_unset();
  session_destroy();
  echo '<SCRIPT>alert("Opción no valida para este usuario");window.location.href="index.php"</SCRIPT>';
}
   $host = $_SERVER["HTTP_HOST"];
   $aux = explode('/',$_SERVER["REQUEST_URI"]);
   $uri='';
   for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
   $dir='http://'.$host.$uri;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
  <?php include("det_usuario.php"); ?>
<!--  FIN Contenido Principal         -->
       </DIV>
      </DIV>
     </TD>
    </TR>
    <TR>
     <TD class="piedepagina">
      <?php  include("piedepagina.php");
      ?>
     </TD>
    </TR>
   </TABLE>
  </body>
</html>
