<html>
<head>
<link rel="stylesheet" href="../css/stilos.css" type="text/css">
<script type="text/javascript" src="../controlador/funciones.js"></script>
</head>
<?php
//Configuracion de la conexion a base de datos
 require('../modelos/conexion.php');
 require('../modelos/acto.php');
 include('../controlador/funciones.php');

 $objActo = new acto();

 $invento = $_SESSION['llamo'];
 $tipoU = $_SESSION['llamotipoU'];

 if ($invento==1)
 	$aceptar="aceptar1";
 else
 	$aceptar="aceptar";

 $opc=$_GET['opc'];
 $fec=$_POST['fec'];
 $nom=$_POST['nomb'];

 $fecI=$_POST['fecI'];
 $nomI=$_POST['nombI'];


$nroFilas = 15;
$nroColum = 3;

$listar1 = $objActo->buscarActo($fec,$nom,-1);
$nroRegs = count($listar1)/$nroColum;

$cantPaginas = ceil($nroRegs/($nroFilas));


$pgActual = $_POST['pagina'];


if(!$pgActual) $pgActual = 1;
elseif($pgActual > $cantPaginas) $pgActual = $cantPaginas;

if($cantPaginas <= 10){
	$pgIni = 1;
	$pgFin = $cantPaginas;
}
elseif($cantPaginas > 10 AND $pgActual< 5 ){
	$pgIni = 1;
	$pgFin = 10;
}
elseif($cantPaginas > ($pgActual+5) AND $pgActual >= 5 ){
	$pgIni = $pgActual - 4;
	$pgFin = $pgActual + 5;
}
else{
	$pgIni = $pgActual - 4;
	$pgFin = $cantPaginas;
}

$offset =  ($pgActual-1) * $nroFilas;

 //if ($fecI or $nomI) $idI = '1';
 if ($fecI or $nomI) $idI = '1';

 if ($idI=='1'){
	if ($fecI and $nomI){ //){
		$objActo->agregarActo($fecI,$nomI);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
	}else{
		echo '<div class="error_valid">Debe ingresar la Fecha y la Descripción</div>';
		 }
 }else{
 	$listar = $objActo->buscarActo($fec,$nom,$offset);
 }
?>
  <script language="JavaScript" type="text/JavaScript">

   function aceptar(cod,des)
   {
      //alert ('Entre en ' + 0);
      //descripción es el nombre que tiene el objeto en la vista principal id = "descripcion"
      opener.document.getElementById('actveh').value = cod;
      opener.document.getElementById('desacto').value = des;
      window.close();
   }

   function aceptar1(cod,des)
   {
   	  //alert ('Entre en ' + 1);
      //descripción es el nombre que tiene el objeto en la vista principal id = "descripcion"
      opener.document.getElementById('indReg').value = 22;
      opener.document.getElementById('actveh').value = cod;
      //opener.document.getElementById('desactveh').value = des;
      window.close();
      window.opener.document.form1.submit();
   }

   function avanzaPg(){
	pg = parseInt(window.document.form1.pagina.value);
	window.document.form1.pagina.value = pg+1;
	window.document.form1.submit();
}

function enviaPg(pag){
	window.document.form1.pagina.value = pag;
	window.document.form1.submit();
}

function regresaPg(){
	pg = parseInt(window.document.form1.pagina.value);
	window.document.form1.pagina.value = pg-1;
	window.document.form1.submit();
}
</script>
</head>
<body>
<table width="378" border="0" align="center" >
  <tr  >
    <td width="63" height="21" class="Not">
    <div align="center"><strong>N&deg;</strong></div></td>
    <td width="111" class="Not">
    <div align="center"><strong>Fecha</strong></div></td>
    <td width="190" class="Not"><div align="center"><strong>Descripci&oacute;n</strong></div></td>
    <? if ($tipoU=='4'){?>
    <td width="25" class="Not"><strong>M</strong></div></td>
    <td width="25" class="Not"><strong>E</strong></div></td>
    <? } ?>
  </tr>
 <?php
    for($i=0;$i<count($listar);$i+=3){
    	 if($listar[$i])
    	 {
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
         }
?>
               <tr class="<?php echo $color ?>">
                <td><div align="center"><a href="javascript:<? echo $aceptar; ?>('<?= str_pad($listar[$i],3,'0',STR_PAD_LEFT)?>','<?= $listar[$i+2]?>')">
                  <?= str_pad($listar[$i],3,'0',STR_PAD_LEFT); ?>
                </a></div></td>
               <td><?php echo $listar[$i+1];?></td>
               <td><?php echo $listar[$i+2];?></td>
                <? if ($tipoU=='4'){?>
   		       <td><a href='mod_acto.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/edit_f2.png' width='20' height='20'></a></td>
   			   <td><a href='elim_acto.php?codi=<? echo $listar[$i]; ?>'> <img src='imagenes/cancel_f2.png' width='20' height='20'></a></td>
   			    <? } ?>
              </tr>
<?php }
if (count($listar)==0) {
	$count=count($listar);
?>
 <TR>
   <TD colspan='6' align='center'><input name="Nuevo" type="button" id="Nuevo" onclick="enviarDatosActo(); return false" value="Nuevo" /></TD>
</TR>
<?php } ?>
</table>
<BR>
 <div align="center">
       <? if($pgActual>1){?>
         <img src="imagenes/atras.png" width="20" height="15" class="vinculo" onclick="regresaPg()">
       <? }
         for($j=$pgIni;$j<=$pgFin;$j++){
             $claseVinc = ($pgActual==$j)?'vinculoAzul':'vinculo';
       ?>
          <a class="<? echo $claseVinc ?>" onclick="enviaPg(<?php echo $j ?>)"><?php echo $j ?></a>
       <? } if($pgActual<$pgFin) {  ?>
         <img src="imagenes/adelante.png" width="20" height="15"  class="vinculo" onclick="avanzaPg()">
       <? } ?>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////// -->
      <input type="hidden" name="pagina" value="<? echo $pgActual ?>"/>
</div>
</BR>
</body>
</html>