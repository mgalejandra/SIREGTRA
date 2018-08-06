<?php
require('conexion.php');
require('zona.php');
$objZona= new zona();

$listarParroquias = $objZona->listarParroquias($_GET["code1"],$_GET["code"]);
for($i=0;$i<count($listarParroquias);$i+=2)
{
		echo "<option value=".$listarParroquias[$i].">".$listarParroquias[$i+1]."</option>";

}
?>
