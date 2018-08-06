<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/vehiculos.php');
require('../modelos/inventario.php');

  $codmar=$_POST['codmar'];
  $serveh=$_POST['codserveh'];
  $sercarveh=$_POST['sercarveh'];
  $pgActual = $_POST['pagina'];
  $ti = $_GET['ti'];
  $color=$_POST['col1veh'];
  $indBusq=$_POST['indBusq'];
  $placa = $_POST['placa'];
  $caract = $_POST['numcat'];

  if ($_GET['modveh'])
 	$modveh=$_GET['modveh'];
  else
	$modveh=$_POST['codmodveh'];

 if ($_GET['lote'])
 	$lote=$_GET['lote'];
  else
	$lote=$_POST['numlotveh'];

	/*echo "Lote: ".$lote;
	echo "modelo: ".$modveh;
*/
if ($indBusq=='2'){
  $codmar=null;
  $serveh=null;
  $sercarveh=null;
  $color=null;
  $modveh=null;
    $lote=null;
  $placa=null;

}

$objVehiculo = new vehiculos();
$objInv = new inventario();


$nroFilas = 25;
$nroCampos = 5;

$contArt = $objVehiculo->ContVehiculos($sercarveh,$codmar,$modveh,$serveh,'T',$lote,'',$ti,'','',$_SESSION['numeDepa'],$color,$placa,$caract);

$cantPaginas = ceil($contArt/($nroFilas));
if(!$pgActual){
	$pgActual = 1;
}
elseif($pgActual > $cantPaginas){
     $pgActual = $cantPaginas;
}

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

$listVehiculos=$objVehiculo->listadeVehiculos($sercarveh,$codmar,$modveh,$serveh,'T',$lote,'',$ti,$offset,'','',$_SESSION['numeDepa'],$color,$placa,$caract);



?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
     <script language="javascript">

   function parametro(cod)
   {
   	  opener.document.getElementById('sercarveh').value = cod;
      self.close();

   }

function avanzaPg(){
	pg = parseInt(window.document.registro.pagina.value);
	window.document.registro.pagina.value = pg+1;
	window.document.registro.submit();
}

function enviaPg(pag){
	window.document.registro.pagina.value = pag;
	window.document.registro.submit();
}


function regresaPg(){
	pg = parseInt(window.document.registro.pagina.value);
	window.document.registro.pagina.value = pg-1;
	window.document.registro.submit();
}

  		   function abrir(campo)
			{
			pagina=campo;
			window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=400,heigth=300,resizable=yes,left=50,top=50");
			}

  		   function abrir1(campo)
			{
			pagina=campo;
			window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=800,heigth=300,resizable=yes,left=50,top=50");
			}

function enviar(campo){
	window.document.registro.indBusq.value = campo;
	window.document.registro.submit();
}
   </script>
  </head>
  <body class="pagina">

<!--  Contenido Principal         -->
 <form action="" method="post" name="registro">
 <fieldset class="form">
  <legend>Criterios de B&uacute;squeda</legend>
     <table  align="center" >
          <tr>
          <td  class="categoria">Serial C.:</td>
           <td  class="dato">
             <input name="sercarveh" type="text" id="sercarveh" value="" />
           </td>
           <td  class="categoria">Marca:</td>
           <td>
			<input name="codmar" type="hidden" id="codmar"  value="<?php if($ban==1)  echo $registro['codmarveh']; else echo $codmar; ?>" />
	        <input name="desmar" type="text" id="desmar"  value="<?php if($ban==1)  echo $objMarca->buscarMarca($registro['codmarveh']);?>"  readonly=""/>
	        <input name="marca" type="button" id="marca" onclick="abrir('marca2.php');" value="..." />
		  </td>
		   </tr>
		   <tr>
           <td  class="categoria">Modelo:</td>
           <td>
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?php if($ban==1)  echo $registro['codmodveh']; else echo $modveh;?>" />
             <input name="modveh" type="text" id="modveh" value="<?php if($ban==1)  echo $registro['modveh'];?>" size="20" maxlength="15" readonly=""/>
             <input name="modelo" type="button" id="modelo" onclick="abrir('cat_modelo.php');" value="..." />
          </td>
           <td  class="categoria">Serie:</td>
           <td>
             <input name="codserveh" type="hidden" id="codserveh" value="<?php if($ban==1)  echo $registro['codserveh']; else echo $serveh; ?>" />
             <input name="serveh" type="text" id="serveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $registro['serveh'];?>" readonly=""/>
             <input name="serie" type="button" id="serie" onclick="abrir('cat_serie.php');" value="..." />
           </td>
          </tr>
          <tr><td class="categoria">Color:</td>
        <td class="dato">
         <input name="col1veh" type="hidden" id="col1veh"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $registro['color']; else echo $color;?>"  readonly=""/>
         <input name="des1veh" type="text" id="des1veh"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $registro['color'];?>"  readonly="" size="10" maxlength="10"/>
         <input name="color1" type="button" id="color1" onclick="abrir('cat_color.php?colop=1&col1=<? echo $_SESSION['tipoUsuario']; ?>');" value="..." />
        </td>
          <td  class="categoria">N° Lote :</td>
           <td>
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $lote ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="abrir('cat_lot.php');" value="..." />
           </td>
        </tr>
        <tr>
                  <td  class="categoria">Caracteristica:</td>
           <td>
             <input name="numcat" type="text" id="numcat" value="<?php echo $caract ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="abrir1('cat_caract.php');" value="..." />
           </td>
        <td  class="categoria">Placa:</td>
           <td  class="dato">
             <input name="placa" type="text" id="placa" value="" />
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
  <legend>Listado de  Veh&iacute;culos <?php echo $contArt;?></legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">Serial de Carr.</td>
              <td class="cabecera">Serial de Motor</td>
              <td class="cabecera">Color</td>
              <td class="cabecera">Serial de NIV</td>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
              <!--<td class="cabecera"> B </td>-->
             </tr>
<?php
        for($i=0;$i<count($listVehiculos);$i+=17){
          if($listVehiculos[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;

             $buscaPreinv = $objInv->buscarPreInv($listVehiculos[$i]);
			 $listExist=$objInv->buscarExistencia($buscaPreinv[0]);

			 if ($listExist) $ban=1;
			 else $ban = 0;

             //echo "<br>Nro preinv: ".$buscaPreinv[0];
		     //echo "<br>Existencia: ".$listExist[0];

?>
              <tr class="<?php echo $color ?>">
               <td align="left">
               <? if (($ban==1) and ($listExist[0]>=1)) {?>
               <a href="javascript: parametro('<?=$listVehiculos[$i]?>')"><?php echo str_pad($listVehiculos[$i],3,'0',STR_PAD_LEFT)  ?></a>
               <? }
               	  elseif ($ban==0) {?> <a href="javascript: parametro('<?=$listVehiculos[$i]?>')"><?php echo str_pad($listVehiculos[$i],3,'0',STR_PAD_LEFT)  ?></a>
               	  <? } elseif (($ban==1) and ($listExist[0]<=0))echo str_pad($listVehiculos[$i],3,'0',STR_PAD_LEFT); ?>
               </td>
               <td align="left"><?php echo $listVehiculos[$i+1];?> </td>
               <td align="left"><?php echo $listVehiculos[$i+2]?></td>
               <td align="left"><?php echo $listVehiculos[$i+3]?> </td>
               <td align="left"><?php echo $listVehiculos[$i+14]?></td>
               <td align="left"><?php echo $listVehiculos[$i+15]?></td>
              <!-- <td><div align="center">
               <a class="vinculo" href="reg_vehiculos_imp.php?idsercarveh=<?php echo $listVehiculos[$i]?>">
	              <img src="botones/buscar.png" width="20" height="20">
	          </a></div></td>-->
              </tr>
<?php     }
        }
?>
    </table>
 </fieldset>
<BR>
   <div align="center">
       <?php if($pgActual>1){?>
         <img src="imagenes/atras.png" width="20" height="15" class="vinculo" onclick="regresaPg()">
       <?php }
         for($j=$pgIni;$j<=$pgFin;$j++){
             $claseVinc = ($pgActual == $j)?'vinculoAzul':'vinculo';
       ?>
          <a class="<?php echo $claseVinc ?>" onclick="enviaPg(<?php echo $j ?>)"><?php echo $j ?></a>
       <?php
         }
         if($pgActual<$pgFin){
       ?>
         <img src="imagenes/adelante.png" width="20" height="15"  class="vinculo" onclick="avanzaPg()">
       <?php } ?>
       <BR>
       <input type="hidden" name="pagina" value="<?php echo $pgActual ?>"/>

       <br />
     </div>
     <div align="center" >
        <input type="button" onclick="window.close()" value="Cerrar Ventana"/>
     </div>
    </form>
<!--  FIN Contenido Principal         -->
  </body>
</html>