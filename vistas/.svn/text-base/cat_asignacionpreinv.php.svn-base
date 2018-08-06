<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/asignacion.php');

$id = $_GET['id'];

$objAsignacion = new asignacion();

  $codmar=$_POST['codmar'];
  $modveh=$_POST['codmodveh'];
  $serveh=$_POST['codserveh'];
  $codpro=$_POST['codpro'];

if ($serveh)
	$nroCampos = 15;
else
	$nroCampos = 14;


/*
 * Contar el número de registros según criterios de búsqueda:
 */

$nroRegs = $objAsignacion->contarVehAsigPreInv($codpro,$codmar,$modveh,$serveh);

$nroFilas = 20;
$nroColum = 10;

//***********************************************************************************/

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

$listVehAsigPreInv = $objAsignacion->listarVehAsigPreInv($codpro,$codmar,$modveh,$serveh,$offset);


?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
  <script language="javascript">

  	function abrir(campo)
	{
		pagina=campo;
		window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=400,heigth=300,resizable=yes,left=50,top=50");
	}

function parametro(cod,des,id,idP){
  opener.document.getElementById('sercarveh').value = cod;
  opener.document.getElementById('codproa').value = des;
  opener.document.getElementById('idAsig').value = id;
  opener.document.getElementById('idPreInv').value = idP;
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
            <tr>
           <td  class="categoria">Marca:</td>
           <td>
			<input name="codmar" type="hidden" id="codmar"  value="<?php if($ban==1)  echo $registro['codmarveh'];?>" />
	        <input name="desmar" type="text" id="desmar"  value="<?php if($ban==1)  echo $objMarca->buscarMarca($registro['codmarveh']);?>"  readonly=""/>
	        <input name="marca" type="button" id="marca" onclick="abrir('marca2.php');" value="..." />
		  </td>
           <td  class="categoria">Modelo :</td>
           <td>
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?php if($ban==1)  echo $registro['codmodveh'];?>" />
             <input name="modveh" type="text" id="modveh" value="<?php if($ban==1)  echo $registro['modveh'];?>" size="20" maxlength="15" readonly=""/>
             <input name="modelo" type="button" id="modelo" onclick="abrir('cat_modelo.php');" value="..." />
          </td>
           <td  class="categoria">Serie:</td>
           <td>
             <input name="codserveh" type="hidden" id="codserveh" value="<?php if($ban==1)  echo $registro['codserveh'];?>" />
             <input name="serveh" type="text" id="serveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $registro['serveh'];?>" readonly=""/>
             <input name="serie" type="button" id="serie" onclick="abrir('cat_serie.php');" value="..." />
           </td>
           </tr>
           <tr>
           <td  class="categoria">CI/RIF:</td>
           <td>
             <input name="codpro" type="text" id="codpro" value="<?php if($ban==1)  echo $registro['codpro'];?>" />
           </td>
          </tr>
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
  <legend>Lista de Veh&iacute;culos asignados - Preinventario <?php echo$nroRegs;?></legend>
    <table width="90%" align="center" class="detalles">
          <tr>
              <td class="cabecera">N&deg; Asig.</td>
              <td class="cabecera">CI/RIF</td>
			  <td class="cabecera">Beneficiario</td>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
              <? if ($serveh){ ?>
              <td class="cabecera">Serie</td>
              <? } ?>
              <td class="cabecera">Fecha Asignacion</td>
              <td class="cabecera">Precio (min-max)</td>
             <!-- <td class="cabecera"> B </td>-->
             </tr>
<?php
        for($i=0;$i<count($listVehAsigPreInv);$i+=$nroCampos){
          if($listVehAsigPreInv[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
        	 /*
        	  0  a.codpro
        	  1. f.prinompro
        	  2.f.segnompro
			  3. f.priapepro
 			  4. f.segapepro
		      5. a.fecha_asig
		      6. b.desmar
		      7. c.desmod
		      8. e.precio_min
		      9. e.precio_max
		      10. a.id_asignacion
		      11. a.sercarveh
		      12. a.id_preinv
		      13. a.id_serie*/



?>
              <tr class="<?php echo $color ?>">
                <td align="center">
               <a href="javascript: parametro('<?=$listVehAsigPreInv[$i+11]?>','<?=$listVehAsigPreInv[$i]?>','<?=$listVehAsigPreInv[$i+10]?>','<?php echo $listVehAsigPreInv[$i+12];?>')"> <?php echo $listVehAsigPreInv[$i+10];  ?></a>
               </td>
               <td align="center"><?php echo $listVehAsigPreInv[$i];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv[$i+1]." ".$listVehAsigPreInv[$i+2]." ".$listVehAsigPreInv[$i+3]." ".$listVehAsigPreInv[$i+4]; ?></td>
               <td align="center"><?php echo $listVehAsigPreInv[$i+6];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv[$i+7]?></td>
               <? if ($serveh){ ?>
               	<td align="center"><?php  echo $listVehAsigPreInv[$i+10]?> </td>
               <? } ?>
               <td align="center"><?php echo $listVehAsigPreInv[$i+5]?></td>
               <td align="center" ><?php echo $listVehAsigPreInv[$i+8]." - ".$listVehAsigPreInv[$i+9]; ?></td>
              <!-- <td><div align="center">
               <a class="vinculo" href="caracteristica_veh_nac.php?idcaract=<?php echo $listPreInv[$i]?>">
	              <img src="botones/buscar.png" width="35" height="35">
	          </a></div></td>-->
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