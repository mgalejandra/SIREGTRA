<?php
@session_start();
//Configuracion de la conexion a base de datos
include("../modelos/conexion.php");
include("../modelos/modelos.php");
require('../controlador/funciones.php');

$objModelo = new modelos();

$tipoU = $_SESSION['modelotipoU'];


/*validaSesion();
$permitidos = array(2,3,10,11);
validaAcceso($permitidos);*/

$indErr=true;

$cod=$_POST['cod'];
$des=$_POST['des'];
$opr=$_GET['opc'];

 $codI=$_POST['codI'];
 $desI=$_POST['desI'];

 if ($codI or $desI) $idI = '1';

 if ($idI=='1'){
	if ($codI and $desI){
		//$agregar=$objModelo->agregarModelo($codI,$desI);
		$objModelo->agregarModelo($codI,$desI);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
	}else{
		echo '<div class="error_valid">Debe ingresar el Código y la Descripción</div>';
		 }
 }else{
 	$listar = $objModelo->buscarModelo($cod,$des); //,$opc);
 }
?>
<script language="JavaScript" type="text/JavaScript">
  function aceptar(modcod,cod)
  {
      //descripción es el nombre que tiene el objeto en la vista principal id = "descripcion"
      opener.document.getElementById('modveh').value = modcod;
      opener.document.getElementById('codmodveh').value = cod;
      close();
  }
</script>
<table width="378" border="0" align="center" >
  <tr  >
    <td width="94" height="21" class="Not">
    <div align="center"><strong>C&oacute;digo</strong></div></td>
    <td width="274" class="Not">
    <div align="center"><strong>Modelo</strong></div></td>
    <? if ($tipoU=='4'){?>
    <td width="25" class="Not"><strong>M</strong></div></td>
    <td width="25" class="Not"><strong>E</strong></div></td>
    <? } ?>
  </tr>
<?php
  for($i=0;$i<count($listar);$i+=3){
      if($listar[$i])
      {
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
      }
?>
  <TR class="<?php echo $color?>">
   <td><a href="javascript: aceptar('<?= $listar[$i+1]?>','<?= $listar[$i]; ?>')"><?php echo $listar[$i]?></a></td>
   <TD ><?php echo $listar[$i+1]?></TD>
   </TD>
   <? if ($tipoU=='4'){?>
   <td><a href='mod_modelo.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/edit_f2.png' width='20' height='20'></a></td>
   <td><a href='elim_modelo.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/cancel_f2.png' width='20' height='20'></a></td>
   <? } ?>
  </TR>
<?php }
if (count($listar)==0) {
	$count=count($listar);
?>
 <TR>
   <TD colspan='2' align='center'><input name="Nuevo" type="button" id="Nuevo" onclick="enviarDatosModelo(); return false" value="Nuevo" /></TD>
</TR>
<?php } ?>
</table>