<script language="Javascript">
	window.location = "listado_placas.php";
</script>

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
<td align= "left"><input name="listar" type="button" id="listar" onclick="window.location.href='listado_placas.php'" value= "Ver Placas Insertadas" /></td>
    <TR>
     <TD class="cuerpo">
      <DIV class="nivel1">
       <DIV class="nivel2">

<!--  pruebaaaaaaa        -->

<!--  Contenido Principal         -->
<form id="form1" name="form1" method="post" action="">
<table class="formulario" width="822" border="0" align="center" >
<?php
$con=new conexion();
$con->conexion();
$estaCon=$con->conectar();

$row = 1;
$handle = fopen("/var/www/refeciv1.1/archivo/datos.csv", "r"); //Coloca el nombre de tu archivo .csv que contiene los datos
while (($data = fgetcsv($handle,50000,";"))!== FALSE) { //Lee toda una linea completa, e ingresa los datos en el array 'data'

    $num=count($data)/8; //Cuenta cuantos campos contiene la linea (el array 'data')
    $row++;
    $sql="  insert into  placas ( sercarveh, numplaveh, codestveh, numrafveh, fecrafveh,
            numsecveh, fecha_reg, fecha_mod) values"; //Cambia los valores 'CampoX' por el nombre de tus campos de tu tabla y colócales los necesarios
    for ($c=0;$c<$num-1;$c++) { //Aquí va colocando los campos en la cadena, si aun no es el último campo, le agrega la coma (,) para separar los datos
     $sql.="('".$data[$c*8]."','".$data[$c*8+1]."','".$data[$c*8+2]."','".$data[$c*8+3]."','".$data[$c*8+4]."','".$data[$c*8+5]."','".$data[$c*8+6]."','".$data[$c*8+7]."'),";
   }
     $sql.="('".$data[$c*8]."','".$data[$c*8+1]."','".$data[$c*8+2]."','".$data[$c*8+3]."','".$data[$c*8+4]."','".$data[$c*8+5]."','".$data[$c*8+6]."','".$data[$c*8+7]."');";

    $result = pg_query($sql);
  //  echo $sql."<br>";
	$con->consultar($estaCon,$sql);
}

$mensaje = "Datos Insertados en la Base de Datos";
print "<script>alert('$mensaje')</script>";
$econ->desconectar($estaCon);
fclose($handle);
var_dump($data);
?>
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
