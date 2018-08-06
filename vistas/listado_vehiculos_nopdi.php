<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/vehiculos.php');


  $sercarveh=$_POST['serial'];
  $codmar=$_POST['codmar'];
  $modveh=$_POST['codmodveh'];
  $numlotveh=$_POST['numlotveh'];
  $color=$_POST['col1veh'];
  $numplaveh=$_POST['numplaveh'];
  $pgActual = $_POST['pagina'];
  $indBusq = $_POST['indBusq'];
  $asigna = $_POST['asigna'];
  $nivel = $_POST['nivel'];

  $objVehiculo = new vehiculos();
  $listarNivel = $objVehiculo->comboNoPDI();

if ($indBusq==2){
  $sercarveh=null;
  $codmar=null;
  $modveh=null;
  $serveh=null;
  $numlotveh=null;
  $color=null;
  $numplaveh=null;
  $pgActual =null;
  $indBusq = null;
  $asigna= null;
}

$nroFilas = 25;

if ($asigna=='AS')
	$nroCampos = 14;
else
	$nroCampos = 9;

$cuenta = $objVehiculo->listVehNoPDI2($codmar,$modveh,$sercarveh,$numlotveh,$color,$asigna,-1,$numplaveh,$nivel);
$contArt = count($cuenta)/$nroCampos;
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

$listVehiculos = $objVehiculo->listVehNoPDI2($codmar,$modveh,$sercarveh,$numlotveh,$color,$asigna,$offset,$numplaveh,$nivel);

$idMod = $_POST['indMod'];
$valor = $_POST['valor'];

/*if($idMod == 3){
   $cambioPDI = $objVehiculo->activarVehiculo($valor);

   if($cambioPDI)$msj = 'Vehiculo '.$valor.' desmarcado como PDI No aprobado';
   else $msj = 'Error al desmarcar vehiculo NO PDI';
   echo '<SCRIPT>alert("'.$msj.'");</SCRIPT>';
   echo '<SCRIPT>window.location.href="listado_vehiculos_nopdi.php";</SCRIPT>';

   $usuario = $valor;
}*/
?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script>

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
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=500,resizable=yes,left=50,top=50");
}
function abrir1(campo)
{
pagina=campo;
window.open(pagina,"Asignacion","menubar=no,toolbar=no,scrollbars=yes,width=1000,height=250,resizable=yes,left=50,top=50");
}
function enviar(dato){
 document.registro.indBusq.value = dato;
}

function exel(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id +
	  	   " = window.open('reportes/xlsListarVehNoPDI.php?sercarveh=<?php echo $sercarveh; ?>&codmar=<?php echo $codmar; ?>&modveh=<?php echo $modveh; ?>&lote=<?php echo $numlotveh; ?>&color=<?php echo $color; ?>&placa=<? echo $numplaveh;?>&asigna=<?php echo $asigna; ?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
}

function envia(dato,valor){
 document.registro.indMod.value = dato;
 document.registro.valor.value = valor;
 document.registro.submit();
}

function abrir2(campo)
{
pagina=campo;
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=no,width=540,height=150,resizable=no,left=100,top=100");
}
</script>
  </head>
  <body class="pagina">
   <TABLE class="completo">
    <TR>
     <TD class="banner"></TD>
    </TR>
    <TR>
     <TD >
      <DIV class="menu">
       <?php include("menu.php") ?>
      </DIV>
     </TD>
    </TR>
    <TR>
     <TD class="cuerpo">
      <DIV class="nivel1">
       <DIV class="nivel2">
<!--  Contenido Principal         -->
    <form action="" method="post" name="registro">
 <fieldset class="form">
  <legend>Criterios de B&uacute;squeda</legend>
     <table  align="center" >
          <tr>
           <td  class="categoria">Serial:</td>
           <td class="dato">
			<input name="serial" type="text" id="serial"  value="<?php echo $sercarveh;?>" />
		  </td>
           <td  class="categoria">Marca:</td>
           <td>
			<input name="codmar" type="hidden" id="codmar"  value="<?php  echo $codmar;?>" />
	        <input name="desmar" type="text" id="desmar"  value="<?php if($ban==1)  echo $objMarca->buscarMarca($registro['codmarveh']);?>"  readonly=""/>
	        <input name="marca" type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
		  </td>
		  <td  class="categoria">Modelo :</td>
           <td>
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?php echo $modveh;?>" />
             <input name="modveh" type="text" id="modveh" value="<?php if($ban==1)  echo $modveh;?>" size="20" maxlength="15" readonly=""/>
             <input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." />
          </td>
          </tr>
          <tr>
          <td  class="categoria">N° Lote :</td>
           <td>
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
           </td>
           <td class="categoria">Color:</td>
        <td class="dato">
         <input name="col1veh" type="hidden" id="col1veh"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php echo $color;?>"  readonly=""/>
         <input name="des1veh" type="text" id="des1veh"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $registro['color'];?>"  readonly="" size="10" maxlength="10"/>
         <input name="color1" type="button" id="color1" onclick="abrir('cat_color.php?colop=1&col1=<? echo $_SESSION['tipoUsuario']; ?>');" value="..." />
        </td>
        <td align="left">Asignados<input type="radio" name="asigna" id="asigna"  value="AS" /></td>
        </tr>
        <tr><td  class="categoria">Placa :</td>
	        <td class="dato"  >
               <input name="numplaveh" type="text" id="numplaveh" value="<?php echo $numplaveh?>" size="7" maxlength="8" />
	        </td>
	        <td>
	        Nivel de PDI
	        </td>
	        <td>
	        <SELECT id="nivel" name="nivel">
				 <option value="<?php if ($nivel1) echo $numeroN?>"><?php if ($nivel1) echo $nivel1;?></option>
			    <?php for($i=0;$i<count($listarNivel);$i+=3){  ?>
	               <option value="<?php echo $listarNivel[$i]; ?>"><?php echo $listarNivel[$i+1]?></option>
	           <?php } ?>
			 </SELECT>
	        </td>

	        </tr>

          <tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden"  name="indReg" >
		    <INPUT type="hidden" name="idUsu" >
		    <INPUT type="hidden" name="indMod">
            <INPUT type="hidden" name="valor">
           </td>
          </tr>
  </table>
   </fieldset>
 <fieldset class="form">
  <legend>Listado de  Veh&iacute;culos - No aprobaron PDI:  <?php echo $contArt; ?></legend>
     <table width="90%" align="center" class="detalles">
    <tr><td colspan="<? echo $nroCampos;?>" align="right"><a class="vinculo" target="_blank" onClick="abrir('reportes/vehNoPDI.php?sercarveh=<?php echo $sercarveh; ?>&codmar=<?php echo $codmar; ?>&modveh=<?php echo $modveh; ?>&lote=<?php echo $numlotveh; ?>&placa=<? echo $numplaveh;?>&color=<?php echo $color; ?>&asigna=<?php echo $asigna; ?>');" />
  <IMG title="PDF" src="botones/pdf.png" height="15" ></a>
  <a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
 </td></tr>
             <tr>
              <td class="cabecera">Lote.</td>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
              <td class="cabecera">Serial de Carr.</td>
              <td class="cabecera">Serial de NIV</td>
              <td class="cabecera">Color</td>
              <td class="cabecera">Placa</td>
              <? if ($asigna=='AS'){?>
 				<td class="cabecera">ID. Asig.</td>
 				<td class="cabecera">Est. Asig.</td>
 				<td class="cabecera">C.I. Benef.</td>
 				<td class="cabecera">Estatus - Fecha</td>

              <?}?>
              <td class="cabecera">Observacion</td>
              <td class="cabecera">Nivel de PDI</td>
              <? if (($_SESSION['tipoUsuario']<>'19') or ($_SESSION['tipoUsuario']<>'20')){?>
                    <td class="cabecera">Mod. Tipo</td>
                    <td class="cabecera">PDI Apto</td>
              <?}?>
             </tr>
<?php
        for($i=0;$i<count($listVehiculos);$i+=$nroCampos){
          if($listVehiculos[$i]){
             if(!$indC){
                 $color ='datosimpar';
                 $indC = true;
             }
             else{
                 $color ='datospar';
                 $indC = false;
             }
?>

              <tr class="<?php echo $color ?>">
               <td align="center" ><?php echo $listVehiculos[$i]?></td>
               <td><?php echo $listVehiculos[$i+1]?></td>
               <td align="center"><?php echo $listVehiculos[$i+2]?></td>
               <td><?php  echo $listVehiculos[$i+3];?> </td>
               <td><?php echo $listVehiculos[$i+4]?></td>
               <td><?php echo $listVehiculos[$i+5]?> </td>
               <td><?php echo $listVehiculos[$i+6]?></td>
               <? if ($asigna=='AS'){?>
 				<td><?php  echo $listVehiculos[$i+7];?></td>
 				<td><?php  echo $listVehiculos[$i+8];?></td>
 				<td><?php  echo $listVehiculos[$i+9];?></td>
 				<td><?php  echo $listVehiculos[$i+10]." - ".$listVehiculos[$i+11];?></td>
              <?}?>
              <? if ($asigna=='AS'){?>
              	<td><?php echo $listVehiculos[$i+12]?></td>
              <? } else { ?>
              	<td><?php echo $listVehiculos[$i+7]?></td>
              <? }?>
              <td><?php echo $listVehiculos[$i+8]?></td>
              <? if (($_SESSION['tipoUsuario']<>'19') or ($_SESSION['tipoUsuario']<>'20')){?>
              <td align="center"><IMG onclick="abrir2('mod_nopdi.php?mod=1&sercarveh=<? echo $listVehiculos[$i+3]; ?>')" src="botones/modificar.png" width="20" title="Modificar Nivel No PDI."></td>
              <td align="center"><IMG onclick="abrir2('mod_pdi.php?sercarveh=<? echo $listVehiculos[$i+3]; ?>')" src="imagenes/correcto.png" width="20" title="PDI Aprob."></td>
              <?}?>
              </tr>
<?php     }
        }
?>
  <tr><td colspan=9> <?php echo 'Total: '.$contArt?></td></tr>
    </table>
 </fieldset>
<BR>
    <div align="center">
       <?php if($pgActual>1){?>
         <img src="imagenes/atras.png" width="20" height="15" class="vinculo" onclick="regresaPg()">
       <?php }
         for($j=$pgIni;$j<=$pgFin;$j++){
             if($pgActual == $j) $claseVinc = 'vinculoAzul';
             else $claseVinc = 'vinculo';
       ?>
          <a class="<?php echo $claseVinc ?>" onclick="enviaPg(<?php echo $j ?>)"><?php echo $j ?></a>
       <?php
         }
         if($pgActual<$pgFin){
       ?>
         <img src="imagenes/adelante.png" width="20" height="15"  class="vinculo" onclick="avanzaPg()">
       <?php } ?>
       <BR>
       <input type="hidden" name="orden" />
       <input type="hidden" name="codProv" />
       <input type="hidden" name="pagina" value="<?php echo $pgActual ?>"/>

       <br />
     </div>
     <div align="center" >
        <input type="button" onclick="window.close()" value="Cerrar Ventana"/>
     </div>
    </form>
<!--  FIN Contenido Principal         -->
       </DIV>
      </DIV>
     </TD>
    </TR>
    <TR>
     <TD class="piedepagina">
      <?php include("piedepagina.php") ?>
     </TD>
    </TR>
   </TABLE>
  </body>
</html>