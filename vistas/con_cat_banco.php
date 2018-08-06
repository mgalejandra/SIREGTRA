<?php
//Configuracion de la conexion a base de datos
 require('../modelos/conexion.php');
 require('../modelos/banco.php');
 include('../controlador/funciones.php');
 
 $host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,6,7,11,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23);
 
 
 

 $objBanco = new banco();

 $opc=$_GET['opc'];
 $nume=$_POST['nume'];
 $nomb=$_POST['nomb'];
 $des=$_POST['des'];
 $env=$_POST['env'];




 if ($env=='1'){
	if ($nume and $nomb and $des){ //){
		$objBanco->agregarBanco($nume,$nomb,$des);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
	}else{
		echo '<div class="error_valid">Debe ingresar todos los datos</div>';
		 }
 }else{
 	$listar = $objBanco->listarBancos($nume,$nomb,$des);
 }
?>
<script language="JavaScript" type="text/JavaScript">
</script>
<table width="378" border="0" align="center" >
  <tr  >
    <td width="63" height="21" class="Not">
    <div align="center"><strong>N&deg;</strong></div></td>
    <td width="111" class="Not">
    <div align="center"><strong>Nombre</strong></div></td>
    <td width="190" class="Not"><div align="center"><strong>Descripci&oacute;n</strong></div></td>
    <td width="25" class="Not"><strong>M</strong></div></td>
  </tr>
 <?php
    for($i=0;$i<count($listar);$i+=5){
    	 if($listar[$i])
    	 {
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
         }
?>
               <tr class="<?php echo $color ?>">
                <td><div align="center">
                  <?=$listar[$i]; ?>
                 </div></td>
               <td><?php echo $listar[$i+1];?></td>
               <td><?php echo $listar[$i+2];?></td>
   		       <td><a href='mod_banco.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/edit_f2.png' width='20' height='20'></a></td>
              </tr>
<?php }
if (count($listar)==0) {
	$count=count($listar);
?>
 <TR>
   <TD colspan='6' align='center'><input name="Nuevo" type="button" id="Nuevo" onclick="enviarDatosBanco(); return false" value="Nuevo" /></TD>
</TR>
<?php } ?>
</table>