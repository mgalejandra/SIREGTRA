<?php
//Configuracion de la conexion a base de datos
 require('../modelos/conexion.php');
 require('../modelos/departamento.php');
 include('../controlador/funciones.php');

 $objDepartamento = new departamento();

 $opc=$_GET['opc'];
$numdep=$_POST['numdep'];
 $descdep=$_POST['descdep'];
 $env=$_POST['env'];


 if ($env=='1'){
	if ($descdep){ //){
		$objDepartamento->agregarDpto($descdep);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
	}else{
		echo '<div class="error_valid">Debe ingresar todos los datos</div>';
		 }
 }else{
 	$listar = $objDepartamento->listarDepartamento($numdep,$descdep);
 }
?>
<script language="JavaScript" type="text/JavaScript">
</script>
<table width="378" border="0" align="center" >
  <tr  >
    <td width="111" class="Not">
    <div align="center"><strong>Nº</strong></div></td>
    <td width="190" class="Not"><div align="center"><strong>Descripci&oacute;n</strong></div></td>
    <td width="25" class="Not"><strong>M</strong></div></td>
  </tr>
 <?php
    for($i=0;$i<count($listar);$i+=2){
    	 if($listar[$i])
    	 {
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
         }
?>
               <tr class="<?php echo $color ?>">
                <td><div align="center">
                 <?php echo $listar[$i]?>
               <td><?php echo $listar[$i+1];?></td>
   		       <td><a href='mod_dep.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/edit_f2.png' width='20' height='20'></a></td>
              </tr>
<?php }
if (count($listar)==0) {
	$count=count($listar);
?>
 <TR>
   <TD colspan='6' align='center'><input name="Nuevo" type="button" id="Nuevo" onclick="enviarDatosDpto(); return false" value="Nuevo" /></TD>
</TR>
<?php } ?>
</table>