<?php

if ($_SESSION['tipoUsuario'] == 2 )require('menuAdministrador.php'); //listo
if ($_SESSION['tipoUsuario'] == 3 )require('menuAnalista.php');//listo
if ($_SESSION['tipoUsuario'] == 4 )require('menuCoordinador.php');//listo
if ($_SESSION['tipoUsuario'] == 5 )require('menuDirector.php');//listo

?>
<link rel="stylesheet" href="../css/stilos.css" type="text/css">
<table align="right">
<tr>
	<td class="categoria"><?php echo 'Usuario: '; ?></td>
	<td class="dato"><?php echo $_SESSION['usuario']; ?></td>
</tr>
</table>
