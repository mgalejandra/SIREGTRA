<?php
require('conexion.php');
require('zona.php');
$objZona= new zona();
$listarEstados = $objZona->listarEstados();

  for($i=0;$i<count($listarEstados);$i+=2)
{
  echo "<option value=".$listarEstados[$i].">".$listarEstados[$i+1]."</option>";
}

?>