<?php
session_start();
require('../modelos/conexion.php');
require('../modelos/factura.php');
require('../controlador/funciones.php');
/*
validaSesion();
$permitidos = array('TIPO_002','TIPO_003','TIPO_004');
validaAcceso($permitidos);*/


$id= $_GET['id'];
//$codpro= $_GET['codProv'];

$nom= $_GET['nom'];
$acc=$_GET['acc'];
$id_numfac=$_GET['id_numfac'];




 //$id_numfac=$_POST['id_numfac'];

//$id_numfac=$_POST['id_numfac'];
  //$id_numfac=$_GET['id_numfac'];
 // $sercarveh=$_POST['sercarveh'];


//echo "Accion: ".$acc;
$objFactura = new factura();

$comentario = $_POST['comentario'];
$indReg='1';
if($indReg == 1){

  if($comentario){
  	if(validarString($comentario)){
  	$reg= $objFactura->regComentarioFac($id,$cabecera."".$comentario,$_SESSION['usuario']);
 echo '<SCRIPT>';
 echo 'window.close();';
   echo '</SCRIPT>';
  }

}else $msj = 'Debe agregar un comentario';

  echo '<SCRIPT>';
  echo 'alert("'.$msj.'");';
  echo '</SCRIPT>';
}
?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
	<script>



	  function enviar(dato){
          document.registro.indReg.value = dato;
     }

  /*   function parametro(acc)
	 {
	   	  window.opener.document.getElementById('indReg').value=acc;
	   	  window.opener.document.getElementById('bandera').value=1;
          window.close();
	      window.opener.document.registro();
//alert (aqui);
   } */

	</script>
  </head>
 <body class="pagina">
    <TR>
     <TD class="cuerpo">
      <DIV class="nivel1">
       <DIV class="nivel2">
<!--  Contenido Principal         -->
    <form action="" method="post" name="registro">

 <fieldset >
  <tr><td class="categoria"> </td></tr>
    </table>
 </fieldset>
  </legend>
<fieldset >
<legend>&nbsp;Agrega un Comentario
<table width="550" align="center" >
	<tr>
	  <td class="dato"  align="center">
	  <textarea name="comentario"  id="comentario" cols="70" rows="4" ></textarea>
	 </td>
	 </tr>
	<tr>
		<td align="center" >
		<? if ($acc)
			$funcion = "parametro($acc)";
		   else
		   	$funcion = "enviar(1)";
	    ?>
		<input type="submit"  value="Guardar Comentario" onclick="enviar(1)">
		</td>
	</tr>
</table>
</fieldset>
</legend>
<BR>
     <input type="hidden" name="indReg">
    </form>
<!--  FIN Contenido Principal         -->
       </DIV>
      </DIV>
     </TD>
    </TR>
   </TABLE>
  </body>
</html>