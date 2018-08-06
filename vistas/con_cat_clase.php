<?php
//Configuracion de la conexion a base de datos
require('../modelos/conexion.php');
require('../modelos/clases.php');

 $objClase = new clases();

 $opc=$_GET['opc'];
 $cod=$_POST['cod'];
 $des=$_POST['nomb'];

 $codI=$_POST['codI'];
 $desI=$_POST['nomI'];

 /*if ($codI or $desI) $idI = '1';

 if ($idI=='1'){
	if ($fecI and $desI){
		$objComb->agregarClase($codI,$desI);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
	}else{
		echo '<div class="error_valid">Debe ingresar el Código y la Descripción</div>';
		 }
 }else{*/
 	$listar = $objClase->buscarClase($cod,$des);
 //}

//consulta todos los empleados
//muestra los datos consultados
//haremos uso de tabla para tabular los resultados
  ?>
  <!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <title>Clases</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link href="../css/classstyles.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="../controlador/ajax.js"></script>
  <script language="JavaScript" type="text/JavaScript">
   function aceptar(cod,des)
   {
      //descripci�n es el nombre que tiene el objeto en la vista principal id = "descripcion"

      opener.document.getElementById('codclaveh').value = cod;
      opener.document.getElementById('desclaveh').value = des;
      close();
   }
</script>
<table width="378" border="0" align="center" >
  <tr  >
    <td width="80" height="21" class="Not">
    <div align="center"><strong>C&oacute;digo</strong></div></td>
    <td width="172" class="Not">
    <div align="center"><strong>Clases</strong></div></td>
  </tr>
<?php
  	//$buscarClase = $objClase->buscarClase($cod,$des,$opc);

    for($i=0;$i<count($listar);$i+=2){
          if($listar[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;  }
  ?>

              <tr class="<?php echo $color ?>">
               <td align="center">
                <a class="vinculo" href="javascript: aceptar('<?= $listar[$i]?>','<?= $listar[$i+1]?>')">
                 <?php echo $listar[$i];?>
                </a>
               </td>
               <td><?php echo $listar[$i+1];?></td>
               </tr>
<?php     }

?>
</table>