<?php
session_start();
$usuario = null;
//if($_SESSION['usuario'])echo '<SCRIPT>window.location.href="alertas_factura.php"</SCRIPT>';
?>
<!DOCTYPE HTML PUBLIC >
<html>
<head>
<?php
include("../modelos/conexion.php");
include("../modelos/usuarios.php");
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri	 = '';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$fecha=date('d/m/Y H:m:s');
$objUsuario = new usuario();
$objConexion = new conexion();
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];
$inicio = $_POST['reg'];
if($inicio){
   if($usuario && $clave){
    $indAcceso = $objUsuario->validarUsuario($usuario,md5($clave));

    if($indAcceso){
       $datosUsuario = $objUsuario->buscarUsuario($usuario);
    //   echo $datosUsuario[6];
       $_SESSION['usuario'] = $datosUsuario[0];
       $_SESSION['tipoUsuario'] = $datosUsuario[6];
       $_SESSION['nombre'] = $datosUsuario[1];
       $_SESSION['apellido'] = $datosUsuario[3];
       $_SESSION['idBanco'] = $datosUsuario[9];
       $_SESSION['numeDepa'] = $datosUsuario[10];
       $_SESSION['nivelUsu'] = $datosUsuario[13];
       $_SESSION['nombBanco'] = $datosUsuario[11];
       $_SESSION['nombDepa'] = $datosUsuario[12];
       $_SESSION['correo'] = $datosUsuario[14];
       $_SESSION['status'] = $datosUsuario[15];

       if($datosUsuario[7] == 'ACTIVO'){
          $conexion = $objConexion->conectar();
          $sql = "INSERT INTO auditoria (usuario,fecha,accion,sentencia,formulario)
                  VALUES ('".$_SESSION['usuario']."','".$fecha."','Inicia Sesión','".$_SESSION['usuario']." entra al sistema','".$dir."')";
          $consulta = $objConexion->consultar($conexion,$sql);
          $objConexion->desconectar($conexion);
          echo '<SCRIPT>alert("BIENVENIDO '.$datosUsuario[1].' '.$datosUsuario[3].'");window.location.href="principal.php"</SCRIPT>';
       }
       if($datosUsuario[7] == 'PENDIENTE'){
          $conexion = $objConexion->conectar();
          $sql = "INSERT INTO auditoria (usuario,fecha,accion,sentencia,formulario)
                  VALUES ('".$_SESSION['usuario']."','".$fecha."','Inicia Sesión','".$_SESSION['usuario']." entra al sistema','".$dir."')";
          $consulta = $objConexion->consultar($conexion,$sql);
          $objConexion->desconectar($conexion);
          echo '<SCRIPT>alert("BIENVENIDO '.$datosUsuario[1].' '.$datosUsuario[3].'");window.location.href="nueva_clave.php"</SCRIPT>';
       }
       if($datosUsuario[16] == 'BLOQUEADO')
       $conexion = $objConexion->conectar();
          $sql = "INSERT INTO auditoria (usuario,fecha,accion,sentencia,formulario)
                  VALUES ('".$_SESSION['usuario']."','".$fecha."','Inicia Sesión','".$_SESSION['usuario']." entra al sistema','".$dir."')";
          $consulta = $objConexion->consultar($conexion,$sql);
          $objConexion->desconectar($conexion);
      // echo '<SCRIPT>alert("Usuario Bloqueado, comuniquese con el administrador del sistema")</SCRIPT>';
    }
    else
    {
    	    $conexion = $objConexion->conectar();
    	    echo '<SCRIPT>alert("Acceso Negado, Usuario o Clave Errados");</SCRIPT>';
    	    $sql = "INSERT INTO auditoria (usuario,fecha,accion,sentencia,formulario)
                     VALUES ('".$usuario."','".$fecha."','FALLALOG','".$usuario." Falla al iniciar Sesión','".$dir."')";
                 // echo $sql;
            $consulta = $objConexion->consultar($conexion,$sql);
            //echo 'aqui'.$objConexion;
        	$intentos = $objUsuario->verificaError($usuario);
        	if($intentos >= 3){
        	   $objUsuario->bloquearUsuario($usuario);
        	   echo '<SCRIPT>alert("USUARIO BLOQUEADO POR SEGURIDAD");</SCRIPT>';
        	}

        }
   }
   elseif($usuario && !$clave)echo '<SCRIPT>alert("Debe ingresar la clave");</SCRIPT>';
   elseif(!$usuario && $clave)echo '<SCRIPT>alert("Debe ingresar el usuario");</SCRIPT>';
   elseif(!$usuario && !$clave)echo '<SCRIPT>alert("Debe ingresar el usuario y la clave");</SCRIPT>';
}
?>
<SCRIPT>
    function iniciar(){
      document.registro.reg.value = 1;
    }
</SCRIPT>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
  <title>IMCP-TESORERIA</title>
  </head>
  <body class="pagina">
   <TABLE class="completo">
    <TR>
     <TD class="banner"></TD>
    </TR>
        <TR>
     <TD >
      <DIV class="menu">

      </DIV>
     </TD>
    </TR>
    <TR>
     <TD class="cuerpo">
      <DIV class="nivel1">
       <DIV class="nivel2">
<!--  Contenido Principal         -->
<link href="../css/classstyles.css" rel="stylesheet" type="text/css" />
<FORM action="" method="POST" name="registro">
 <TABLE width="308" align="center" background="imagenes/fon.jpg">
  <tr >
   <TD height=30" colspan="2"   align="center" class="cabecera2">Iniciar Sesion</TD>
  </TR>
  <TR>
   <TD  class="categoria"><div align="right">Usuario:&nbsp;</div></TD>
   <TD  class="dato"><INPUT type="text" name="usuario" value=""></TD>
  </TR>
  <TR>
   <TD  class="categoria"><div align="right">Clave:&nbsp;</div></TD>
   <TD  class="dato"><INPUT type="password" name="clave" value="" autocomplete='off'></TD>
  </TR>
  <TR>
   <TD align="center" colspan="2" height="30" >
    <INPUT type="reset" value="Limpiar">
    <INPUT type="submit" value="Entrar" onclick="iniciar()">
    <INPUT type="hidden" name="reg">   </TD>
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
