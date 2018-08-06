<?php
//Configuracion de la conexion a base de datos
require('../modelos/conexion.php');
require('../modelos/tipos.php');

 $objTipo = new tipos();
 $opc=$_GET['opc'];
 $cod=$_POST['cod'];
 $des=$_POST['nomb'];

 $codI=$_POST['codI'];
 $desI=$_POST['nombI'];

 /*if ($codI or $desI) $idI = '1';

 if ($idI=='1'){
	if ($fecI and $desI){
		$objComb->agregarTipoComb($codI,$desI);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
	}else{
		echo '<div class="error_valid">Debe ingresar la Fecha y la Descripción</div>';
		 }
 }else{*/
 	$listar = $objTipo->buscarTipo($cod,$des);
 //}




//consulta todos los empleados
//muestra los datos consultados
//haremos uso de tabla para tabular los resultados
  ?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <title>Tipos</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link href="../css/classstyles.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="../controlador/ajax.js"></script>
  <script language="JavaScript" type="text/JavaScript">
   function aceptar(cod,des)
   {
      //descripci�n es el nombre que tiene el objeto en la vista principal id = "descripcion"

      opener.document.getElementById('codtipveh').value = cod;
      opener.document.getElementById('destipveh').value = des;
      close();
   }
</script>


<table width="378" border="0" align="center" >
  <tr  >
    <td width="50" height="21" class="Not">
    <div align="center"><strong>C&oacute;digo</strong></div></td>
    <td width="162" class="Not">
    <div align="center"><strong>Tipos</strong></div></td>

  </tr>
<?php
  //	$buscarTipo= $objTipo->buscarTipo($cod,$des,$opc);

    for($i=0;$i<count($listar);$i+=2){
          if($listar[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
  ?>

              <tr class="<?php echo $color ?>">
               <td align="center">
                <a class="vinculo" href="javascript: aceptar('<?= $listar[$i]?>','<?= $listar[$i+1]?>')">
                 <?php echo $listar[$i];?>
                </a>
                </a>
               </td>
               <td><?php echo $listar[$i+1];?></td>
               </tr>
<?php     }
        }
?>
</table>