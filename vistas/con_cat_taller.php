<?php
//Configuracion de la conexion a base de datos
 require('../modelos/conexion.php');
 require('../modelos/taller.php');
 include('../controlador/funciones.php');

 $objTaller = new taller();

 $opc=$_GET['opc'];
 $rif=$_POST['rif'];
 $nom=$_POST['nomb'];
 $dir=$_POST['dir'];
 $contacto=$_POST['con'];
 $telf=$_POST['telf'];


 $rifI=$_POST['rifI'];
 $nomI=$_POST['nombI'];
 $dirI=$_POST['dirI'];
 $contactoI=$_POST['conI'];
 $telfI=$_POST['telfI'];


 if ($rifI or $nomI or $dirI or $contactoI)  $idI = '1';

 if ($idI=='1'){
	if ($rifI and $nomI and $dirI){ //){
		$objTaller->agregarTaller($nomI,$rifI,$dirI,$contactoI,$telfI);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
		$idI=0;
	}else{
		echo '<div class="error_valid">Debe ingresar el Rif, Nombre y Dirección</div>';
		 }
 }else{
 	$listar = $objTaller->buscarTaller($nom,$rif,$dir,$contacto,$telf);
 }
?>
  <script language="JavaScript" type="text/JavaScript">
   function aceptar(cod,des)
   {
      //descripción es el nombre que tiene el objeto en la vista principal id = "descripcion"
      opener.document.getElementById('codtal').value = cod;
      opener.document.getElementById('destaller').value = des;
      window.close();
   }
</script>
<table width="378" border="0" align="center" >
  <tr  >
    <td width="63" height="21" class="Not">
    <div align="center"><strong>N&deg;</strong></div></td>
    <td width="70" class="Not"><div align="center"><strong>RIF</strong></div></td>
    <td width="100" class="Not"><div align="center"><strong>Nombre</strong></div></td>
    <td width="100" class="Not"><div align="center"><strong>Direcci&oacute;n</strong></div></td>
    <td width="40" class="Not"><strong>Tel&eacute;fono</strong></div></td>
    <td width="40" class="Not"><strong>Contacto</strong></div></td>
    <td width="25" class="Not"><strong>M</strong></div></td>
    <td width="25" class="Not"><strong>E</strong></div></td>
  </tr>
 <?php
    for($i=0;$i<count($listar);$i+=6){
    	//0. numtaller
    	//1. nombre
    	//2. direccion
    	//3. telefono
    	//4. rif
    	//5. contacto
    	 if($listar[$i])
    	 {
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
         }
?>
               <tr class="<?php echo $color ?>">
                <td><div align="center"><a href="javascript: aceptar('<?= str_pad($listar[$i],3,'0',STR_PAD_LEFT)?>','<?= $listar[$i+1]?>')">
                  <?= str_pad($listar[$i],3,'0',STR_PAD_LEFT); ?>
                </a></div></td>
 			   <td><?php echo $listar[$i+4];?></td>
               <td><?php echo $listar[$i+1];?></td>
               <td><?php echo $listar[$i+2];?></td>
               <td><?php echo $listar[$i+3];?></td>
               <td><?php echo $listar[$i+5];?></td>
   		       <td><a href='mod_taller.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/edit_f2.png' width='20' height='20'></a></td>
   			   <td><a href='elim_taller.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/cancel_f2.png' width='20' height='20'></a></td>
              </tr>
<?php }
if (count($listar)==0) {
	$count=count($listar);
?>
 <TR>
   <TD colspan='6' align='center'><input name="Nuevo" type="button" id="Nuevo" onclick="enviarDatosTaller(); return false" value="Nuevo" /></TD>
</TR>
<?php } ?>
</table>