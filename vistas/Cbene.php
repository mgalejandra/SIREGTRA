<?php

session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');

$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(2,18,23);
	validaAcceso($permitidos,$dir);

?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
   <script>
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
    <?php  ?>
    <TR>
     <TD class="cuerpo">
      <DIV class="nivel1">
       <DIV class="nivel2">
<!--  Contenido Principal         -->

<table class="formulario" width="822" border="0" align="center" >
<html>
<head>
<title>Subir archivos al server</title>
<style>
.estilo_formulario{width:700px; margin:auto;} /*estilos css */
.estilo_divs{margin:auto; padding:9px;}clase de estilos css /*estilos css*/
</style>
</head>
<body>
<?php
if (isset($_POST['boton_enviar'])){ //aca validamos si se ha enviado un archivo desde el formulario
$archivo_nombre= $_FILES["archivo"]["name"]; //aca se obtiene el nombre del archivo
$archivo_tamaño = $_FILES["archivo"]["size"]; //tamaño del archivo
$archivo_temporal = $_FILES["archivo"]["tmp_name"]; //direccion temporal en la que el servidor guarda el archivo antes de copiarlo



echo "<div><b>Nombre del archivo: </b>".$archivo_nombre."</div>";
echo "<div><b>Tamaño: </b>".$archivo_tamaño." bytes </div>";
echo "<div><b>Direcci&oacute;n temporal: </b>".$archivo_temporal."</div>";

//$destino = '/var/www/html/sirecov/vistas/archivos' ; //aca se define la direccion en la que quieres que se guarden los archivos cuando los subes al servidor
$destino = '/var/www/suvinca/sirecov/vistas/archivos';
copy($_FILES['archivo']['tmp_name'],$destino.'/'. $_FILES['archivo']['name']); //esta instruccion es la que copia el archivo de la carpeta temporal a su destino en el servidor
}
?>
<div class="estilo_formulario">
<fieldset><legend>Subir archivos</legend> <!-- los tag <fieldset> y <legend> son con fines decorativos hacen un recuadro con titulo alrededor del form-->
<form method="POST" action="" enctype="multipart/form-data">
<div class="estilo_divs">Archivo: <input type="file" name="archivo" size=50></div>
<div class="estilo_divs"><input type="submit" value="Subir" name="boton_enviar"></div>

</form>
</fieldset>
</div>
<br><br>
 <?php
/*$num_lineas = 0;

$fp = fopen ( "/var/www/html/sirecov/archivo/bene.csv" , "r" );


while (( $data = fgetcsv ( $fp , 500000 , ";" )) !== FALSE ) { // Mientras hay líneas que leer...

     //acumulo una en la variable número de líneas
		$num_lineas++;

       echo "<br>Lineas: $num_lineas ";
     foreach($data as $row) {

			echo "$row"; // Muestra todos los campos de la fila actual
     }

}
		$a=$num_lineas;
    	echo"<br><br> Numeros totales Lineas: $a<br>";*/

?>

<br>
<form action="Carga_beneficiarios.php" method="POST" onsubmit="return checkCheckBox(this)">
<Input Type="submit" value="Insertar en La Base de Datos">
<Input Type="button" value=" Cerrar Ventana " onclick="document.location.href='principal.php';">
</form>
</body>
</body>
</html>
</div>
     </tr>
 </table>
    </form>
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
