<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(3);
validaAcceso($permitidos,$dir);
require ('../modelos/usuarios.php');
$indBusq = $_POST['busqueda'];
$usuario = $_POST['usuario'];
$cedula = $_POST['cedula'];
$tipo = $_POST['cargo'];

$objUsuario = new usuario();
$_SESSION['ciUsuario'] = null;
$_SESSION['criterio'] = null;
$_SESSION['datoBusq'] = null;

if($indBusq){
   if(!$usuario && !$cedula && !$tipo){
      echo '<SCRIPT>alert("Debe suministrar un dato para la búsqueda")</SCRIPT>';
   }
   else{
     if($usuario){
        if(!validarString($usuario)){
           echo '<SCRIPT>alert("Hay caracteres inválidos en el usuario")</SCRIPT>';
        }
        else{
            $datUsuario = $objUsuario->buscarUsuario($usuario,1);
            if(count($datUsuario)>1){
               $_SESSION['ciUsuario'] = $datUsuario[5];
               echo '<SCRIPT>window.location.href="detalle_usuario.php?cod=2"</SCRIPT>';
            }
            else echo '<SCRIPT>alert("No se encontraron usuarios")</SCRIPT>';
        }
     }
     elseif($cedula){
        if(!validarCedula($cedula)){
           echo '<SCRIPT>alert("Hay caracteres inválidos en la cedula")</SCRIPT>';
        }
        else{
            $datUsuario = $objUsuario->buscarUsuario($cedula,2);
            if(count($datUsuario)>1){
               $_SESSION['ciUsuario'] = $datUsuario[5];
               echo '<SCRIPT>window.location.href="detalle_usuario.php?cod=2"</SCRIPT>';
            }
            else echo '<SCRIPT>alert("No se encontraron usuarios")</SCRIPT>';
        }
     }
     else{
            $datUsuario = $objUsuario->buscarUsuario($tipo,3);
            if(count($datUsuario)>1){
               $_SESSION['criterio'] = 3;
               $_SESSION['datoBusq'] = $tipo;
               echo '<SCRIPT>window.location.href="detalle_usuario.php?cod=2"</SCRIPT>';
            }
            else echo '<SCRIPT>alert("No se encontraron usuarios")</SCRIPT>';
     }
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
<SCRIPT>
function buscar(){
  document.busq.busqueda.value = 1;
}
</SCRIPT>
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
<FORM action="" method="POST" name="busq">
<TABLE border="0" align="center">
 <TR>
    <TD class="cabecera" colspan="2" >Buscar Usuario</TD>
   </TR>
 <TR>
   <TD class="categoria">Usuario:</TD>
   <TD class="dato"><INPUT type="text" name="usuario"></TD>
 </TR>
 <TR>
   <TD class="categoria">Cédula:</TD>
   <TD class="dato" ><INPUT type="text" name="cedula"></TD>
 </TR>
 <TR>
   <TD class="categoria">Tipo usuario:</TD>
   <TD class="dato">
       <select name="cargo" >
         <?php
        $tipoUsuario = $objUsuario->retTipo();
        for($i=0;$i<count($tipoUsuario);$i+=3){
          echo '<option value="'.$tipoUsuario[$i].'">'.$tipoUsuario[$i+1].'</option>';
        }
     ?>
       </select>
    </TD>
 </TR>
 <TR>
   <TD height="50" colspan="2" align="right" valign="middle" class="TitNot"><div align="center">
     <INPUT type="reset" value="Limpiar">
     <INPUT type="hidden" name="busqueda">
     <INPUT type="submit" value="Buscar" onClick="buscar()">
   </div></TD>
   </TR>
</TABLE>

</FORM>
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
