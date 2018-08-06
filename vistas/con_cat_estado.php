<?php
@session_start();
//Configuracion de la conexion a base de datos
include("../modelos/conexion.php");
include("../modelos/estados.php");
require('../controlador/funciones.php');

$objEdo = new estados();
/*validaSesion();
$permitidos = array(2,3,10,11);
validaAcceso($permitidos);*/

$indErr=true;

$cod=$_POST['cod'];
$des=$_POST['nomb'];
$opr=$_GET['opc'];

 $codI=$_POST['codI'];
 $desI=$_POST['nombI'];

 if ($codI or $desI) $idI = '1';

 if ($idI=='1'){
	if ($codI and $desI){
		//$agregar=$objModelo->agregarModelo($codI,$desI);
		$objModelo->agregarEdo($codI,$desI);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
	}else{
		echo '<div class="error_valid">Debe ingresar el Código y la Descripción</div>';
		 }
 }else{
 	$listar = $objEdo->buscarEdo($cod,$des); //,$opc);
 }
?>

  <script language="JavaScript" type="text/JavaScript">
   function aceptar(cod,des)
   {
      //descripci�n es el nombre que tiene el objeto en la vista principal id = "descripcion"

      opener.document.getElementById('codestveh').value = cod;
       opener.document.getElementById('desestveh').value = des;
      close();
   }
</script>
<table width="378" border="0" align="center" >
  <tr  >
    <td width="81" height="21" class="Not">
    <div align="center"><strong>C&oacute;digo</strong></div></td>
    <td width="287" class="Not">
    <div align="center"><strong>Estado</strong></div></td>
  </tr>
<?php
  for($i=0;$i<count($listar);$i+=2){
      if($listar[$i])
      {
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
      }
?>
  <TR class="<?php echo $color?>">
   <td><a href="javascript: aceptar('<?= $listar[$i]?>','<?= $listar[$i+1]; ?>')"><?php echo $listar[$i]?></a></td>
   <TD ><?php echo $listar[$i+1]?></TD>
   </TD>
  <!-- <td><a href='mod_estado.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/edit_f2.png' width='20' height='20'></a></td>
   <td><a href='elim_estadolo.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/cancel_f2.png' width='20' height='20'></a></td>
-->
  </TR>
<?php }
if (count($listar)==0) {
	$count=count($listar);
?>
 <TR>
   <TD colspan='2' align='center'><input name="Nuevo" type="button" id="Nuevo" onclick="enviarDatosEstado(); return false" value="Nuevo" /></TD>
</TR>
<?php } ?>
</table>