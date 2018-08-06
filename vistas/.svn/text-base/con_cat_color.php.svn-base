<?php
@session_start();
//Configuracion de la conexion a base de datos
include("../modelos/conexion.php");
include("../modelos/color.php");
require('../controlador/funciones.php');

$objColor = new color();
/*validaSesion();
$permitidos = array(2,3,10,11);
validaAcceso($permitidos);*/

$indErr=true;

$opr=$_GET['opc'];
$colop=$_GET['colop'];
$tipoU = $_SESSION['colortipoU'];

//echo "num: ".$colop;
if ($colop=='1')
	$_SESSION['num']='1';
if ($colop=='2')
	$_SESSION['num']='2';

	$colop = $_SESSION['num'];

//echo "num1: ".$colop;

$cod=$_POST['cod'];
$des=$_POST['nomb'];

 $codI=$_POST['codI'];
 $desI=$_POST['nombI'];

 if ($codI or $desI) $idI = '1';

 if ($idI=='1'){
	if ($codI and $desI){
		$objColor->agregarColor($codI,$desI);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
	}else{
		echo '<div class="error_valid">Debe ingresar el Código y la Descripción</div>';
		 }
 }else{
 	$listar = $objColor->buscarColor($cod,$des);
 }
?>
<script language="JavaScript" type="text/JavaScript">
   function aceptar(cod,colop,des)
   {

   //	alert('Cod: '+cod + ', desc:' + des);
      //descripcion es el nombre que tiene el objeto en la vista principal id = "descripcion"
    if (colop=='1'){
      opener.document.getElementById('col1veh').value = cod;
      opener.document.getElementById('des1veh').value = des;
    }

    else  if (colop=='2')
    {
     opener.document.getElementById('col2veh').value = cod;
     opener.document.getElementById('des2veh').value = des;
    }

    close();

   }
</script>
<table width="378" border="0" align="center" >
  <tr  >
    <td width="94" height="21" class="Not">
    <div align="center"><strong>C&oacute;digo</strong></div></td>
    <td width="274" class="Not">
    <div align="center"><strong>Color</strong></div></td>
    <? if ($tipoU=='4'){?>
    <td width="25" class="Not"><strong>M</strong></div></td>
    <td width="25" class="Not"><strong>E</strong></div></td>
    <? } ?>
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
   <td><div align="center"><a href="javascript: aceptar('<?= $listar[$i];?>','<?= $colop?>','<?= $listar[$i+1];?>')"><?= $listar[$i];  ?>
   </a></div></td>
   <td><?php echo $listar[$i+1]?></td>
   <? if ($tipoU=='4'){?>
   <td><a href='mod_color.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/edit_f2.png' width='20' height='20'></a></td>
   <td><a href='elim_color.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/cancel_f2.png' width='20' height='20'></a></td>
    <? } ?>
  </TR>
<?php }
if (count($listar)==0) {
	$count=count($listar);
?>
 <TR>
   <TD colspan='2' align='center'><input name="Nuevo" type="button" id="Nuevo" onclick="enviarDatosColor(); return false" value="Nuevo" /></TD>
</TR>
<?php } ?>
</table>