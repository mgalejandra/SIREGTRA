<?php
//Configuracion de la conexion a base de datos
require('../modelos/conexion.php');
require('../modelos/serie.php');
 include('../controlador/funciones.php');
// $opc=$_GET['opc'];
 $cod=$_POST['cod'];
 $desc=$_POST['des'];

 $codI=$_POST['codI'];
 $desI=$_POST['desI'];

$objSerie = new series();

if ($codI or $desI) $idI = '1';

 if ($idI=='1'){
	if ($codI and $desI){
		$objSerie->agregarSerie($codI,$desI);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
	}else{
		echo '<div class="error_valid">Debe ingresar la Fecha y la Descripción</div>';
		 }
 }else{
 	$listar = $objSerie->buscarSerie($cod,$desc);
 }

  $tipoU = $_SESSION['serietipoU'];

//consulta todos los empleados
//muestra los datos consultados
//haremos uso de tabla para tabular los resultados
?>
  <script language="JavaScript" type="text/JavaScript">
   function aceptar(des,cod)
   {
      //descripcion es el nombre que tiene el objeto en la vista principal id = "descripcion"
      opener.document.getElementById('serveh').value = des;
       opener.document.getElementById('codserveh').value = cod;
      close();
   }
</script>
<table width="378" border="0" align="center" >
  <tr  >
    <td width="79" height="21" class="Not">
    <div align="center"><strong>C&oacute;digo</strong></div></td>
    <td width="173" class="Not">
    <div align="center"><strong>Serie</strong></div></td>
    <? if ($tipoU=='4'){?>
    <td width="25" class="Not"><strong>M</strong></div></td>
    <td width="25" class="Not"><strong>E</strong></div></td>
    <? } ?>
  </tr>
 <?php
  //	$buscarSeries = $objSerie->buscarSerie($cod,$des,$opc);

    for($i=0;$i<count($listar);$i+=2){
          if($listar[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
          }
  ?>

              <tr class="<?php echo $color ?>">
                <td><a class="vinculo" href="javascript: aceptar('<?= $listar[$i+1]?>','<?= $listar[$i]?>')">
                 <?php //<?= str_pad($listar[$i+1],3,'0',STR_PAD_LEFT) cerraba php
                 			//echo str_pad($listar[$i],3,'0',STR_PAD_LEFT);
                        echo $listar[$i];?>
                </a></td>
               <td><?php echo $listar[$i+1];?></td>
               <? if ($tipoU=='4'){?>
                <td><a href='mod_serie.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/edit_f2.png' width='20' height='20'></a></td>
   			   <td><a href='elim_serie.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/cancel_f2.png' width='20' height='20'></a></td>
  			   <? } ?>
               </tr>
<?php   }
if (count($listar)==0) {
	$count=count($listar);
?>
 <TR>
   <TD colspan='3' align='center'><input name="Nuevo" type="button" id="Nuevo" onclick="enviarDatosSerie(); return false" value="Nuevo" /></TD>
</TR>
<?php } ?>
</table>