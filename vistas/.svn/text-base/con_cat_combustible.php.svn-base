<?php
//Configuracion de la conexion a base de datos
require('../modelos/conexion.php');
require('../modelos/combustible.php');
 include('../controlador/funciones.php');

 $objComb = new combustible();

 $opc=$_GET['opc'];
 $cod=$_POST['cod'];
 $des=$_POST['nom'];

 $codI=$_POST['codI'];
 $desI=$_POST['nomI'];

 /*if ($codI or $desI) $idI = '1';

 if ($idI=='1'){
	if ($fecI and $desI){
		$objComb->agregarTipoComb($codI,$desI);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
	}else{
		echo '<div class="error_valid">Debe ingresar la Fecha y la Descripción</div>';
		 }
 }else{*/
 	$listar = $objComb->buscarTipoComb($cod,$des);
 //}
//consulta todos los empleados
//muestra los datos consultados
//haremos uso de tabla para tabular los resultados
?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <title>Combustible</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link href="../css/classstyles.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="../controlador/ajax.js"></script>
<script language="JavaScript" type="text/JavaScript">
   function aceptar(cod,des)
   {
      //descripci�n es el nombre que tiene el objeto en la vista principal id = "descripcion"

      opener.document.getElementById('codconveh').value = cod;
      opener.document.getElementById('desconveh').value = des;
      close();
   }
</script>
<table width="378" border="0" align="center" >
  <tr  >
    <td width="121" height="21" class="Not">
    <div align="center"><strong>C&oacute;digo</strong></div></td>
    <td width="247" class="Not">
    <div align="center"><strong>Tipo de Combustible </strong></div></td>
</tr>
<?php
    for($i=0;$i<count($listar);$i+=2){
          if($listar[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;}
  ?>

              <tr class="<?php echo $color ?>">
               <td align="center">
                <a class="vinculo" href="javascript: aceptar('<?= str_pad($listar[$i],3,'0',STR_PAD_LEFT)?>','<?= $listar[$i+1]?>')">
                 <?php echo str_pad($listar[$i],3,'0',STR_PAD_LEFT);?>
                </a>
               </td>
               <td><?php echo $listar[$i+1];?></td>
               </tr>
<?php     }
       // }
?>
</table>