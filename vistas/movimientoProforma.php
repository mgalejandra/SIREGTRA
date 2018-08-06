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
$nom= $_GET['nom'];
$objFactura = new factura();
$comentario = $_POST['comentario'];

  if($comentario){
  	$reg= $objOferta->regComentario($idOferta,$comentario,$_SESSION['usuario']);

  }

$datos = $objFactura->listarMovimientos($id);


?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
	<script>
     function enviar(dato){
         document.regOferta.indReg.value = dato;
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
  <legend>&nbsp;Movimientos de estatus de la factura Proforma N#: <?php echo $id;?>   </legend>

    <table width="550" align="center" >
             <tr>
              <td  width="69%" class="cabecera">Movimiento</td>
              <td width="7%" class="cabecera">Fecha</td>
              <td width="7%" class="cabecera">Hora</td>
              <td width="10%" class="cabecera">Usuario</td>
             </tr>
<?php
        for($i=0;$i<count($datos);$i+=4){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
             $nreg = $offset+$i/count($datos)+1;
?>

              <tr class="<?php echo $color ?>">
               <td align="left">&nbsp;<?php echo $datos[$i]?></td>
               <td align="center"><?php echo $datos[$i+1]?> </td>
               <td align="center"><?php echo $datos[$i+2]?> </td>
               <td align="center"><?php echo $datos[$i+3]?> </td>
              </tr>
<?php  }  ?>
  <tr><td class="categoria"> </td></tr>
    </table>
 </fieldset>

<BR>
     <div align="center" >
        <input type="button" onclick="window.close()" value="Cerrar Ventana"/>
     </div>
    </form>
<!--  FIN Contenido Principal         -->
       </DIV>
      </DIV>
     </TD>
    </TR>
   </TABLE>
  </body>
</html>