<?php
@session_start();
//Configuracion de la conexion a base de datos
include("../modelos/conexion.php");
include("../modelos/estatus.php");
require('../controlador/funciones.php');

$objEstatus = new estatus();

$indErr=true;

$id_estatus=$_POST['id_estatus'];
$descripcion=$_POST['descripcion'];
$orden=$_POST['orden'];

$opc=$_GET['opc'];
 $env=$_POST['env'];

 if ($env=='1'){
	if ( $descripcion AND $orden ){
		$objEstatus->agregarEstatus($descripcion,$orden);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
	}else{
		echo '<div class="error_valid">Debe ingresar todos los datos</div>';
		 }
 }else{
 	$listar = $objEstatus->listarEstatus($id_estatus,$descripcion,$orden); //,$opc);
 }
?>
<script language="JavaScript" type="text/JavaScript">
</script>
<table width="500" border="0" align="center" >
  <tr  >
    <td width="60" height="21" class="Not">
    <div align="center"><strong>C&oacute;digo</strong></div></td>
    <td width="400" class="Not">
    <div align="center"><strong>Descripci&oacute;n</strong></div></td>
        <td width="200" class="Not">
     <div align="center"><strong>&Oacute;rden</strong></div></td>
    <td width="50" class="Not">
    <div align="center"><strong>M</strong></div></td>
  </tr>
<?php
  for($i=0;$i<count($listar);$i+=3){
     // if($listar[$i])
    //  {
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
    //  }
?>
   <tr class="<?php echo $color ?>">
                <td><div align="center">
              <?php echo $listar[$i]?>
             </div></td>
            <TD  align="center"><?php echo $listar[$i+1]?></TD>
            <TD  align="center"><?php echo $listar[$i+2]?></TD>
            <td><a href='mod_estatus.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/edit_f2.png' width='20' height='20'></a></td>
   </tr>
<?php }
if (count($listar)==0) {
	$count=count($listar);
?>
 <TR>
   <TD colspan='2' align='center'><input name="Nuevo" type="button" id="Nuevo" onclick="enviarDatosEstatus(); return false" value="Nuevo" /></TD>
</TR>
<?php } ?>
</table>