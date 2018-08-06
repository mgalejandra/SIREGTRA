<script language="Javascript">
	//window.location = "listado_beneficiariosExp.php";
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
    <TR>
     <TD class="cuerpo">
      <DIV class="nivel1">
       <DIV class="nivel2">
<!--  Contenido Principal         -->
<form id="form1" name="form1" method="post" action="">
<table class="formulario" width="822" border="0" align="center" >
<?php
$con=new conexion();
$con->conexion();
$estaCon=$con->conectar();

$row = 1;
//$handle = fopen("/var/www/html/sirecov/vistas/archivos/bene.csv", "r"); //Coloca el nombre de tu archivo .csv que contiene los datos
$handle = fopen("/var/www/suvinca/sirecov/vistas/archivos/bene.csv", "r");

while (($data = fgetcsv($handle,50000,";"))!== FALSE) {
	$num=count($data)/35;

	for ($c=0;$c<$num;$c++){
		   $sql=" INSERT INTO  propietarios(codpro, prinompro, segnompro, priapepro, segapepro, nomorgpro,
            nomcomp, calavepro, urbbarpro, edicaspro, numpispro, numapapro,dismunpro, ciudadpro, tlfcelpro, tlfcel2pro, obspro, tipmovpro,
            nummod,fecha_reg, status, codest, codmun, codpar,sexo,tipo,  fecnac, ced, id_banco, usuario_pro, correo, riflab,
            deslab, fecha, hora) values";
		   $sql.="('".$data[$c*35]."','".$data[$c*35+1]."','".$data[$c*35+2]."','".$data[$c*35+3]."','".$data[$c*35+4]."','".$data[$c*35+5]."','".$data[$c*35+6]."','".$data[$c*35+7]."',
           '".$data[$c*35+8]."','".$data[$c*35+9]."','".$data[$c*35+10]."','".$data[$c*35+11]."','".$data[$c*35+12]."','".$data[$c*35+13]."','".$data[$c*35+14]."','".$data[$c*35+15]."',
           '".$data[$c*35+16]."','".$data[$c*35+17]."','".$data[$c*35+18]."','".$data[$c*35+19]."','".$data[$c*35+20]."','".$data[$c*35+21]."','".$data[$c*35+22]."',
           '".$data[$c*35+23]."','".$data[$c*35+24]."','".$data[$c*35+25]."','".$data[$c*35+26]."','".$data[$c*35+27]."','".$data[$c*35+28]."','".$data[$c*35+29]."','".$data[$c*35+30]."',
           '".$data[$c*35+31]."','".$data[$c*35+32]."','".$data[$c*35+33]."','".$data[$c*35+34]."');";
						
			//echo $sql."<br>";
			$result = pg_query($sql);
			$con->consultar($estaCon,$sql);
			
			//if ($result) $con->auditar($_SESSION['usuario'],'INSERCION','REGISTRO BENEFICIARIO '.$data[$c*35]);
			
	}
}

if ($con)
{
	$mensaje = "Beneficiarios cargados satisfactoriamente...";
	print "<script>alert('$mensaje')</script>";
	echo '<script>window.close();</script>';
	echo "<script>window.location.href='listado_beneficiariosExp.php';</script>";
}

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
