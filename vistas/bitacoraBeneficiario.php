<?php
session_start();
require('../modelos/conexion.php');
require('../modelos/beneficiario.php');
require('../controlador/funciones.php');
/*
validaSesion();
$permitidos = array('TIPO_002','TIPO_003','TIPO_004');
validaAcceso($permitidos);*/


$id= $_GET['id'];
$nom= $_GET['nom'];
$acc=$_GET['acc'];

//echo "Accion: ".$acc;
$objBeneficiario = new beneficiario();


if ($acc=='16')
	$cabecera = "Credito negado - ";

if ($acc=='17')
	$cabecera = "Credito diferido - ";

$comentario = $_POST['comentario'];


  if($comentario){
  	$reg= $objBeneficiario->regComentario($id,$cabecera."".$comentario,$_SESSION['usuario']);
    $datos = $objBeneficiario->listarBitacora($id);

  }

$datos = $objBeneficiario->listarBitacora($id);


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

     function parametro(acc)
	 {
	   	  window.opener.document.getElementById('indReg').value=acc;
	   	  window.opener.document.getElementById('bandera').value=1;
          window.close();
	      window.opener.document.form1.submit();

     }
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
  <legend>&nbsp;Bitacora de: <?php echo $nom;?>  </legend>
    <table width="550" align="center" >
             <tr>
              <td  width="69%" class="cabecera">Movimiento</td>
              <td width="7%" class="cabecera">Fecha</td>
              <td width="7%" class="cabecera">Hora</td>
              <td width="10%" class="cabecera">Usuario</td>
             </tr>
<?php
        for($i=0;$i<count($datos);$i+=6){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
             $nreg = $offset+$i/count($datos)+1;
?>

              <tr class="<?php echo $color ?>">
               <td align="left">&nbsp;<?php echo $datos[$i+2]?></td>
               <td align="center"><?php echo $datos[$i+3]?> </td>
               <td align="center"><?php echo $datos[$i+4]?> </td>
               <td align="center"><?php echo $datos[$i+5]?> </td>
              </tr>
<?php  }  ?>
  <tr><td class="categoria"> </td></tr>
    </table>
 </fieldset>

<fieldset >
<legend>&nbsp;Agrega un Comentario  </legend>
<table width="550" align="center" >
	<tr>
	  <td class="dato"  align="center">
	  <textarea name="comentario" cols="70" rows="4" ></textarea>
	 </td>
	 </tr>
	<tr>
		<td align="center" >
		<? if ($acc)
			$funcion = "parametro($acc)";
		   else
		   	$funcion = "enviar(1)";
	    ?>
		<input type="submit"  value="Guardar Comentario" onclick="<? echo $funcion; ?>">
		</td>
	</tr>
</table>
</fieldset>

<BR>
     <div align="center" >
        <input type="button" onclick="window.close()" value="Cerrar Ventana"/>
     </div>
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