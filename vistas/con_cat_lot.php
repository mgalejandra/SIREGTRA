<?php
@session_start();
//Configuracion de la conexion a base de datos
 require('../modelos/conexion.php');
 require('../modelos/lotes.php');
 require('../modelos/departamentos.php');
 include('../controlador/funciones.php');

 $objLote = new lotes();
 $objDpto = new departamentos();
 $tipoU = $_SESSION['lotetipoU'];

 $opc=$_GET['opc'];
 $fec=$_POST['fec'];
 $nom=$_POST['nomb'];
 $dep=$_POST['dpto'];


 $fecI=$_POST['fecI'];
 $nomI=$_POST['nombI'];
 $depI=$_POST['dptoI'];

 //if ($fecI or $nomI) $idI = '1';
 if ($fecI or $nomI or $depI) $idI = '1';

 if ($idI=='1'){
	if ($fecI and $nomI and $depI){ //){
		$objLote->agregarLote($fecI,$nomI,$depI);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
	}else{
		echo '<div class="error_valid">Debe ingresar la Fecha y la Descripción</div>';
		 }
 }else{
 	$listar = $objLote->buscarLote($fec,$nom,$dep);
 }

//consulta todos los empleados
//muestra los datos consultados
//haremos uso de tabla para tabular los resultados
?>
  <script language="JavaScript" type="text/JavaScript">
   function aceptar(cod,des)
   {
      //descripción es el nombre que tiene el objeto en la vista principal id = "descripcion"
      opener.document.getElementById('numlotveh').value = cod;
     // opener.document.getElementById('deslotveh').value = des;
      window.close();
   }
</script>
<table width="378" border="0" align="center" >
  <tr  >
    <td width="63" height="21" class="Not">
    <div align="center"><strong>N&deg;</strong></div></td>
    <td width="111" class="Not">
    <div align="center"><strong>Fecha</strong></div></td>
    <td width="190" class="Not"><div align="center"><strong>Descripci&oacute;n</strong></div></td>
    <td width="190" class="Not"><div align="center"><strong>Departamento</strong></div></td>
    <? if ($tipoU=='4'){?>
    <td width="25" class="Not"><strong>M</strong></div></td>
    <td width="25" class="Not"><strong>E</strong></div></td>
    <? } ?>
  </tr>
 <?php
    for($i=0;$i<count($listar);$i+=4){
    	 if($listar[$i])
    	 {
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
         }
?>
               <tr class="<?php echo $color ?>">
                <td><div align="center"><a href="javascript: aceptar('<?= str_pad($listar[$i],3,'0',STR_PAD_LEFT)?>','<?= $listar[$i+2]?>')">
                  <?= str_pad($listar[$i],3,'0',STR_PAD_LEFT); ?>
                </a></div></td>
               <td><?php echo $listar[$i+1];?></td>
               <td><?php echo $listar[$i+2];?></td>
			   <td><?php $busDpto = $objDpto->buscarDptoID($listar[$i+3]);  echo utf8_decode($busDpto[1]);  ?></td>
			   <? if ($tipoU=='4'){?>
   		       <td><a href='mod_lote.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/edit_f2.png' width='20' height='20'></a></td>
   			   <td><a href='elim_lote.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/cancel_f2.png' width='20' height='20'></a></td>
   			   <? } ?>
              </tr>
<?php }
if (count($listar)==0) {
	$count=count($listar);
?>
 <TR>
   <TD colspan='6' align='center'><input name="Nuevo" type="button" id="Nuevo" onclick="enviarDatosLote(); return false" value="Nuevo" /></TD>
</TR>
<?php } ?>
</table>