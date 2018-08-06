<?php
require('conexion.php');
require('zona.php');
$objZona= new zona();
$listarMunicipios = $objZona->listarMunicipios($_GET["code"]);
for($i=0;$i<count($listarMunicipios);$i+=2)
{
		echo "<option value=".$listarMunicipios[$i].">".$listarMunicipios[$i+1]."</option>";

}
?>
