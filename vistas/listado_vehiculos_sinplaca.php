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
  $pgActual = $_POST['pagina'];
  $indBusq = $_POST['indBusq'];
  $sta=$_POST['sta'];

  $objVehiculo = new vehiculos();

if ($indBusq==2){
  $sercarveh=null;
  $codmar=null;
  $modveh=null;
  $serveh=null;
  $numlotveh=null;
  $color=null;
  $pgActual =null;
  $indBusq = null;
}

$nroFilas = 25;
$nroCampos = 17;

$cuenta = $objVehiculo->listVehsinplaca($codmar,$modveh,$sercarveh,$numlotveh,$color,-1,$sta);
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

$listVehiculos = $objVehiculo->listVehsinplaca($codmar,$modveh,$sercarveh,$numlotveh,$color,$offset,$sta);

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
	  	   " = window.open('reportes/xlsListarVehSinPlaca.php?sercarveh=<?php echo $sercarveh; ?>&codmar=<?php echo $codmar; ?>&modveh=<?php echo $modveh; ?>&lote=<?php echo $numlotveh; ?>&color=<?php echo $color; ?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

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
           <td>
			 Todos
		   <input name="sta" id="sta" value=""  <?php if ($sta=='') echo "checked= 'true'"?> type="radio">
		     Activos
		   <input name="sta" id="sta" value="A" type="radio"  <?php if ($sta=='A') echo "checked= 'true'"?> >
		     No PDI
		   <input name="sta" id="sta" value="E" type="radio"  <?php if ($sta=='E') echo "checked= 'true'"?> >
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
  <legend>Listado de  Veh&iacute;culos sin placa:  <?php echo $contArt; ?></legend>
   <!--  <input  type="button" id="articulo" onClick="abrir('reportes/vehImportados.php?sercarveh=<?php echo $sercarveh; ?>&codmar=<?php echo $codmar; ?>&modveh=<?php echo $modveh; ?>&serveh=<?php echo $serveh; ?>&lote=<?php echo $numlotveh; ?>&factura=<?php echo $factura; ?>');" value="PDF" />-->
    <table width="90%" align="center" class="detalles">
    <tr><td colspan="10" align="right"><a class="vinculo" target="_blank" onClick="abrir('reportes/vehSinPlaca.php?sercarveh=<?php echo $sercarveh; ?>&codmar=<?php echo $codmar; ?>&modveh=<?php echo $modveh; ?>&lote=<?php echo $numlotveh; ?>&color=<?php echo $color; ?>');" />
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
              <td class="cabecera">Factura</td>
              <td class="cabecera">Serial de Carr.</td>
              <td class="cabecera">Serial de Motor</td>
              <td class="cabecera">Color</td>
              <td class="cabecera">Serial de NIV</td>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
            <!--  <td class="cabecera"> B </td>
             <?php if ($_SESSION['tipoUsuario'] != 5 and $_SESSION['tipoUsuario'] != 6 and $_SESSION['tipoUsuario'] != 7 and $_SESSION['tipoUsuario']!= 11) { ?>
              <td class="cabecera"> T </td>
               <?php }?>-->
             </tr>
<?php
        for($i=0;$i<count($listVehiculos);$i+=17){
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
               <td align="center" ><?php echo $listVehiculos[$i+16]?></td>
               <td><?php echo $listVehiculos[$i+12]?></td>
               <td align="center"><?php echo $listVehiculos[$i]?></td>
               <td><?php  echo $listVehiculos[$i+1];?> </td>
               <td><?php echo $listVehiculos[$i+2]?></td>
               <td><?php echo $listVehiculos[$i+3]?> </td>
               <td><?php echo $listVehiculos[$i+14]?></td>
               <td align="center" ><?php echo $listVehiculos[$i+15]?></td>
             <!--  <td><div align="center">
               <a class="vinculo" href="reg_vehiculos_imp.php?idsercarveh=<?php echo $listVehiculos[$i]?>">
	              <img src="botones/buscar.png" width="25" height="25">
	          </a></div></td>
	               <?php if ($_SESSION['tipoUsuario'] != 5 and  $_SESSION['tipoUsuario'] != 6 and $_SESSION['tipoUsuario'] != 7 and $_SESSION['tipoUsuario']!= 11) { ?>
	           <td><div align="center">
	           <a class="vinculo" href="javascript:abrir1('asig_vehiculos_taller.php?idsercarveh=<?php echo $listVehiculos[$i]?>&pag=2')">
	              <img src="botones/taller.png" <? echo 'aquijghjjhjghjhj'?> width="20" height="20" onClick="abrir1('asig_vehiculos_taller.php?idsercarveh=<?php echo $listVehiculos[$i]?>')">
	          </a></div></td>
	          <?php     }  ?>-->
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