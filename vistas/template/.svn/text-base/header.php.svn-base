<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(1,2,3,4,5,6,7,11,13,17,18,21);
	validaAcceso($permitidos,$dir);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
   <script type="text/javascript" src="../controlador/funciones.js"></script>
   <script type="text/javascript" src="../controlador/calendario.js"></script>
  </head>
  <body class="pagina">
	 <table class="completo3" align="center" cellpadding="0" cellspacing="0">
		<tr>
     		<td class="banner2" align="center"></td>
    	</tr>
    	<tr>
     		<td>
      			<div class="menu2">
       				<?php include("menu.php") ?>
      			</div>
     		</td>
    	</tr>
		<tr>
			<td class="cuerpo">
				 <div class="nivel1">
       				<div class="nivel2">
       				<br/>