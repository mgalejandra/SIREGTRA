<?php
//Configuracion de la conexion a base de datos
require('../modelos/conexion.php');
require('../modelos/uso.php');

 $objUso = new usos();
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
 	$listar = $objUso->buscarUso($cod,$des);
 //}

//consulta todos los empleados
//muestra los datos consultados
//haremos uso de tabla para tabular los resultados
  ?>
  <script language="JavaScript" type="text/JavaScript">
   function aceptar(cod,des)
   {
      //descripci�n es el nombre que tiene el objeto en la vista principal id = "descripcion"

      opener.document.getElementById('codusoveh').value = cod;
      opener.document.getElementById('desusoveh').value = des;
      close();
   }
</script>
<table width="378" border="0" align="center" >
  <tr  >
    <td width="89" height="21" class="Not">
    <div align="center"><strong>C&oacute;digo</strong></div></td>
    <td width="163" class="Not">
    <div align="center"><strong>Uso</strong></div></td>
  </tr>
<?php
  	for($i=0;$i<count($listar);$i+=2){
          if($listar[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC; }
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