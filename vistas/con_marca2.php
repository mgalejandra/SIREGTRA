<?php
//Configuracion de la conexion a base de datos
require('../modelos/conexion.php');
require('../modelos/marca.php');

 $opc=$_GET['opc'];
 $cod=$_POST['cod'];
 $nom=$_POST['nomb'];

 $codI=$_POST['codI'];
 $nomI=$_POST['nomI'];

 $objMarca = new marca();
/* if ($codI or $nomI) $idI = '1';

 if ($idI=='1'){
	if ($codI and $nomI){
		$objMarca->agregarMarca($codI,$nomI);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
	}else{
		echo '<div class="error_valid">Debe ingresar el Código y la Descripción</div>';
		 }
 }else{*/
 	$listar = $objMarca->buscarMarca1($cod,$nom); //,$opc);
 //}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
   <title><? echo "Marcas";?></title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link href="../css/classstyles.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="../controlador/ajax.js"></script>
<script language="JavaScript" type="text/JavaScript">
function aceptar(codmar,des)
{
     //descripci�n es el nombre que tiene el objeto en la vista principal id = "descripcion"
     //alert(codmar);
     opener.document.getElementById('codmar').value = codmar;
     opener.document.getElementById('desmar').value = des;
     close();
}
</script>
</head>
<table width="378" border="0" align="center" >
  <tr  >
    <td width="139" height="21" class="Not">
    <div align="center"><strong>C&oacute;digo</strong></div></td>
    <td width="229" class="Not">
    <div align="center"><strong>Descripci&oacute;n</strong></div></td>
  <!--  <td width="25" class="Not"><strong>M</strong></div></td>
    <td width="25" class="Not"><strong>E</strong></div></td> -->
  </tr>
  <?php
    for($i=0;$i<count($listar);$i+=2){
          if($listar[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;}
  ?>

              <tr class="<?php echo $color ?>">
                <td><a class="vinculo" href="javascript: aceptar('<?= $listar[$i]?>','<?= $listar[$i+1]?>')">
                 <?php //echo str_pad($listar[$i],3,'0',STR_PAD_LEFT);
                 echo $listar[$i];?>
                </a></td>
               <td><?php echo $listar[$i+1];?></td>
              <!-- <td><a href='mod_marca.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/edit_f2.png' width='20' height='20'></a></td>
               <td><a href='elim_marca.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/cancel_f2.png' width='20' height='20'></a></td>-->
               </tr>
<?php }
/*if (count($listar)==0) {
	$count=count($listar);*/
?>
<!-- <TR>
   <TD colspan='2' align='center'><input name="Nuevo" type="button" id="Nuevo" onclick="enviarDatosMarca(); return false" value="Nuevo" /></TD>
</TR>-->
<?php //} ?>
</table>