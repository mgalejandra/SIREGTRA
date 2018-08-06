<?php
session_start();
require ('../modelos/conexion.php');
?>
<HTML>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
$fecha=date('m/d/Y H:m:s');
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$objConexion = new conexion();
$conexion = $objConexion->conectar();
$sql = "INSERT INTO auditoria (usuario,fecha,accion,sentencia,formulario)
VALUES ('".$_SESSION['usuario']."','".$fecha."','Cerrar Sesión','".$_SESSION['usuario']." sale del sistema','".$dir."')";
$consulta = $objConexion->consultar($conexion,$sql);
if($consulta){
   session_unset();
   session_destroy();
   echo '<SCRIPT>alert ("SESION FINALIZADA");window.location.href="index.php";</SCRIPT>';
}
$objConexion->desconectar($conexion);

?>

</HTML>
