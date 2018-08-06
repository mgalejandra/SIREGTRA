<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/asignacion.php');

$id = $_GET['id'];

$sercarveh	= $_POST['sercarveh'];
$codpro		= $_POST['codpro'];
$nombre		= $_POST['nombre'];
$fechAsig	= $_POST['fechAsig'];

$objAsignacion = new asignacion();

/*
 * Contar el número de registros según criterios de búsqueda:
 */

$nroRegs = $objAsignacion->contarAsignacion($sercarveh,$codpro,$nombre,$fechAsig,'',$id,'','','','','','',$_SESSION['numeDepa']);

$nroFilas = 20;
$nroColum = 10;

//******

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

//***********************************************************************************/

/*
 * $id = 1: Listar todos los vehículos asignados
 * $id = 2: Listar todos los asignados que no están en tabla < ventas >
 * $id = 3: Listar todos los asignados que no están en tabla < entrega >
 */

$listarAsignacion = $objAsignacion->listarAsignacion($sercarveh,$codpro,$nombre,$id,$fechAsig,'',$offset,'','','',$_SESSION['numeDepa']);


?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
  <script language="javascript">

function parametro(cod,des,id,codpro){
	//alert('entro1');
  opener.document.getElementById('sercarveh').value = cod;
 // alert('entro2');
  opener.document.getElementById('beneficario').value = des;
 // alert('entro3');
  opener.document.getElementById('idAsig').value = id;
   opener.document.getElementById('codproa').value = codpro;
  self.close();
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

function enviar(valor){
	if(valor==2){
	window.document.form1.sercarveh.value = null;
	window.document.form1.codpro.value = null;
	window.document.form1.nombre.value = null;
	window.document.form1.fechAsig.value = null;
	}
}
   </script>
  </head>
  <body class="pagina">
<!--  Contenido Principal         -->
 <form action="" method="post" name="form1">
 <fieldset class="form">
  <legend>Criterios de B&uacute;squeda</legend>
     <table  align="center" >
          <tr>
           <td  class="categoria">Serial:</td>
           <td>
			<input name="sercarveh" type="text" id="cosercarvehdmar"  value="<?=$sercarveh?>" onblur="javascript:this.value=this.value.toUpperCase()"/>
		  </td>
           <td  class="categoria">CI/RIF :</td>
           <td>
             <input name="codpro" type="text" id="codpro" value="<?=$codpro?>" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="15" />
          </td>
           <td  class="categoria">Nombre:</td>
           <td>
	         <input name="nombre" type="text" id="nombre" value="<?=$nombre?>" onblur="javascript:this.value=this.value.toUpperCase()" />
           </td>
	        <td class="categoria">Fecha:</td>
	        <td class="dato">
	         <input name="fechAsig" type ="text" id="fechAsig"
	         		value="<?=$fechAsig?>" size="10" maxlength="10" date_format="dd/MM/yy"
	         		onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)"  readonly=""/>
		          <img src="../images/cal.gif" width="16" height="16"
		          		onClick="show_calendar('document.forms[0].fechAsig',document.forms[0].fechAsig.value)" />
	        </td>
          </tr>
          <tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden"  name="indReg" >
		    <INPUT type="hidden" name="idUsu" >
           </td>
          </tr>
  </table>
   </fieldset>

 <fieldset class="form">
  <legend>Lista de Veh&iacute;culos asignados <?php echo$nroRegs;?>
  </legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera" width="5%">N&deg;</td>
              <td class="cabecera" width="20%">Serial de Carrocer&iacute;a</td>
              <td class="cabecera" width="10%">CI/RIF</td>
              <td class="cabecera">Nombre propietario</td>
              <td class="cabecera" width="10%">Fecha asignaci&oaucte;n</td>
             <?if($id!=2){?>
              <td class="cabecera"> B </td>
              <?}?>
             </tr>
<?php
        for($i=0;$i<count($listarAsignacion);$i+=$nroColum){
          if($listarAsignacion[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
?>

              <tr class="<?php echo $color ?>">
               <td align="center"><?=$i/$nroColum+$offset+1?></td>
               <td align="center">
               <a href="javascript: parametro('<?=$listarAsignacion[$i]?>','<?=$listarAsignacion[$i+2]?>','<?=$listarAsignacion[$i+4]?>','<?php echo $listarAsignacion[$i+1];?>')"> <?php echo $listarAsignacion[$i];  ?></a>
               </td>
               <td>&nbsp;<?php echo $listarAsignacion[$i+1];?></td>
               <td>&nbsp;<?php echo $listarAsignacion[$i+2]?></td>
               <td align="center"><?php echo $listarAsignacion[$i+3]?> </td>
               <?if($id!=2){?>
               <td><div align="center">
               <a class="vinculo" href="reg_asignacion.php?idsercarveh=<?= $listarAsignacion[$i]?>">
	              <img src="botones/buscar.png" width="20" height="20">
	          </a></div></td> <?}?>
              </tr>
<?php     }
        }
?>
    </table>
 </fieldset>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////// -->
<BR>
 <div align="center">
       <? if($pgActual>1){?>
         <img src="imagenes/atras.png" width="20" height="15" class="vinculo" onclick="regresaPg()">
       <? }
         for($j=$pgIni;$j<=$pgFin;$j++){
             $claseVinc = ($pgActual==$j)?'vinculoAzul':'vinculo';
       ?>
          <a class="<? echo $claseVinc ?>" onclick="enviaPg(<?php echo $j ?>)"><?php echo $j ?></a>
       <? } if($pgActual<$pgFin) { ?>
         <img src="imagenes/adelante.png" width="20" height="15"  class="vinculo" onclick="avanzaPg()">
       <? } ?>
<BR>
<!-- /////////////////////////////////////////////////////////////////////////////////////////////// -->

       <input type="hidden" name="pagina" value="<? echo $pgActual ?>"/>
       <br/>
     </div>
     <div align="center" >
        <input type="button" onclick="window.close()" value="Cerrar Ventana"/>
     </div>
    </form>
<!--  FIN Contenido Principal         -->
  </body>
</html>