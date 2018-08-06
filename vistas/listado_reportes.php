<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/reportes.php');
require('../modelos/marca.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5);
	validaAcceso($permitidos,$dir);

$obj = new reportes();

  $indBusq 	 = $_POST['indBusq'];
  $sel_Lista = $_POST['sel_Lista'];

  $sercarveh = $_POST['sercarveh'];
  $beneficia = $_POST['beneficia'];
  $numlotveh = $_POST['numlotveh'];
  $codmarveh = $_POST['codmar'];
  $desmarveh = $_POST['desmar'];
  $codmodveh = $_POST['codmodveh'];
  $desmodveh = $_POST['desmodveh'];
  $codserveh = $_POST['codserveh'];
  $desserveh = $_POST['desserveh'];

//$pgActual = $_POST['pagina'];

$nroFilas = 15;

if($indBusq==2){

	$sel_Lista  = null;
	$sercarveh	= null;
	$beneficia  = null;
	$numlotveh 	= null;
  	$codmarveh	= null;
  	$desmarveh  = null;
  	$codmodveh	= null;
  	$desmodveh	= null;
  	$codserveh	= null;
  	$desserveh	= null;

  	$titulo 	= null;
	$titulo1 	= null;
	$nroCampos 	= null;
	$nroItems 	= null;
	$listado_todo = null;
}

  $_SESSION['beneficia_'] = $beneficia;
  $_SESSION['sercarveh_'] = $sercarveh;
  $_SESSION['numlotveh_'] = $numlotveh;
  $_SESSION['codmarveh_'] = $codmarveh;
  $_SESSION['desmarveh_'] = $desmarveh;
  $_SESSION['codmodveh_'] = $codmodveh;
  $_SESSION['desmodveh_'] = $desmodveh;
  $_SESSION['codserveh_'] = $codserveh;
  $_SESSION['desserveh_'] = $desserveh;

$data = array($sercarveh,$beneficia,$numlotveh,$codmarveh,$codmodveh,$codserveh);

//$cantVeh = $obj->contarVehiculos($data);

    if($_POST['pagina']==0) $pgActual = 1;
elseif($_POST['pagina'] >0) $pgActual = $_POST['pagina'];

switch ($sel_Lista){
	case 1:	$nroItems = $obj->vehiculos_con_certificado($data,null,&$listado_todo);
			$titulo = "Vehículos con Certificado";
			$nroCampos = 26;
			break;

	case 2:	$nroItems = $obj->vehiculos_sin_certificado($data,null,&$listado_todo);
			$titulo = "Vehículos sin Certificado";
			$nroCampos = 26;
			break;

	case 3:	$nroItems = $obj->vehiculos_sin_asignar($data,null,&$listado_todo);
			$titulo = "Vehículos sin asignar";
			$nroCampos = 9;
			break;

	case 4:	$nroItems = $obj->carros_sin_placas($data,null,&$listado_todo);
			$titulo = "Vehículos sin placas";
			$nroCampos = 8;
			break;
}

$titulo1  = ($beneficia)?" Beneficiarios: ".$beneficia:null;
$titulo1 .= ($numlotveh)?" N° de Lote: ".$numlotveh:null;
$titulo1 .= ($desmarveh)?" Marca: ".$desmarveh:null;
$titulo1 .= ($desmodveh)?" Modelo: ".$desmodveh:null;
$titulo1 .= ($desserveh)?" Serie: ".$desserveh:null;

// Variables para efectos del reporte impreso

$_SESSION['titulo'] 	= $titulo;
$_SESSION['titulo1'] 	= $titulo1;
$_SESSION['nroCampos'] 	= $nroCampos;
$_SESSION['listado_todo'] = $listado_todo;

if($nroCampos>0){
	$nroRegs = $nroItems / $nroCampos;
	$_SESSION['nroRegs'] = $nroRegs;
	$_SESSION['offset'] = $offset;
}

$cantPaginas = ceil($nroRegs/$nroFilas);

    if(!$pgActual)$pgActual = 1;
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

//echo '<pre>'."Regs:".$nroRegs;
//echo '<pre>'."pags:".$cantPaginas;
//echo '<pre>'."offset:".$offset;
//echo '<pre>'.$pgIni.' '.$pgFin;

switch ($sel_Lista){
	case 1:	$listado = $obj->vehiculos_con_certificado($data,$offset,null,2); break;
	case 2:	$listado = $obj->vehiculos_sin_certificado($data,$offset,null,2); break;
	case 3:	$listado = $obj->vehiculos_sin_asignar($data,$offset,null,2); break;
	case 4: $listado = $obj->carros_sin_placas($data,$offset,null,2); break;
}
$dimListado = sizeof($listado);
//echo '<br>'."dimListado: ".$dimListado;

?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
    <script>

function enviar(dato){
 document.registro.pagina.value = 0;
 document.registro.indBusq.value = dato;
}

function imprimir() {
  day = new Date();
  id = day.getTime();
  eval("page" + id +
  	   " = window.open('reportes/listReportes.php?sel_Lista=<?= $sel_Lista?>','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
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
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=500,resizable=yes,left=50,top=50");
}

function selector(dato){
 document.registro.sel_Lista.value = dato;
 document.registro.submit()
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
  <legend>Criterios de Busqueda
  </legend>
     <table  align="center" >
        <tr>

          <td  class="categoria">N°&nbsp;Lote:</td>
          <td align="left">
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
          </td>

          <td  class="categoria">Serial&nbsp;carrocería:</td>
          <td align="left">
			<input name="sercarveh" type="text" id="sercarveh"  value="" />
		  </td>

          <td  class="categoria">&nbsp;&nbsp;Beneficiario:</td>
          <td align="left">
			<input name="beneficia" type="text" id="beneficia" value="<?=$beneficia?>" onblur="javascript:this.value=this.value.toUpperCase()"/>
		  </td>

		</tr>

		<tr>
           <td  class="categoria">Marca:</td>
           <td colspan="1">
			<input name="codmar" type="hidden" id="codmar"  value="<?= $_SESSION['codmarveh_']?>" />
	        <input name="desmar" type="text" id="desmar"  value="<?= $_SESSION['desmarveh_']?>"  readonly=""/>
	        <input name="marca"  type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
		  </td>
           <td  class="categoria">Modelo:</td>
           <td colspan="1" align="left">
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?= $_SESSION['codmodveh_']?>" />
             <input name="desmodveh" type="text" id="modveh" value="<?=$_SESSION['desmodveh_']?>" size="20" maxlength="15" readonly=""/>
             <input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." />
          </td>
           <td  class="categoria">Serie:</td>
           <td colspan="1">
             <input name="codserveh" type="hidden" id="codserveh" value="<?=$_SESSION['codserveh_']?>" />
             <input name="desserveh" type="text" id="serveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?= $_SESSION['desserveh_'];?>" readonly=""/>
             <input name="serie" type="button" id="serie" onclick="catalogo('cat_serie.php');" value="..." />
           </td>
         </tr>

	<tr>
		<td class="categoria" colspan="3">Listado:</td>
		<td align="left">
			 <SELECT name="sel_Lista">
			 <OPTION id="lista_0" value="" onclick="selector('0')"
			 	<? if($sel_Lista==0) echo 'selected="true"'?>/></OPTION>
			 <OPTION id="lista_1" value="1" onclick="selector('1')"
			 	<? if($sel_Lista==1) echo 'selected="true"'?>/>Vehículos con Certificado</OPTION>
			 <OPTION id="lista_2" value="2" onclick="selector('2')"
			 	<? if($sel_Lista==2) echo 'selected="true"'?>/>Vehículos sin Certificado</OPTION>
			 <OPTION id="lista_3" value="3" onclick="selector('3')"
			 	<? if($sel_Lista==3) echo 'selected="true"'?>/>Vehículos sin asignar</OPTION>
			 <OPTION id="lista_4" value="4" onclick="selector('4')"
			 	<? if($sel_Lista==4) echo 'selected="true"'?>/>Vehículos sin placas</OPTION>
			 </SELECT>
		</td>

       	<td align="center" colspan="4">
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" value="Limpiar" onclick="enviar(2)"/>
            <input type="submit" value="Imprimir" onclick="imprimir()"/>
       	</td>
	</tr>

          <tr><td><INPUT type="hidden" name="indBusq"></td></tr>
  </table>
   </fieldset>

 <fieldset class="form">
  <legend><?= $titulo?>
  </legend>

       <DIV class="nivel2">
    <table width="90%" align="center" class="detalles">

  <tr><td colspan=9> <?php echo 'Total vehículos: '.$nroRegs?></td></tr>

<?if($sel_Lista==1 or $sel_Lista==2){ ?>
            <tr>
              <td class="cabecera"rowspan="2">N°</td>
              <td class="cabecera"rowspan="2">Serial Carrocería</td>
              <td class="cabecera"rowspan="1"colspan="2">Beneficiario</td>
		<?if($sel_Lista==1){ ?>
              <td class="cabecera"rowspan="1"colspan="2">Certificado</td>
        <? } ?>
			</tr>
			<tr>
              <td class="cabecera">CI/RIF</td>
              <td class="cabecera"align="left">Nombres/Apellidos</td>
		<?if($sel_Lista==1){ ?>
              <td class="cabecera">N° Cert.</td>
              <td class="cabecera">N° Envío</td>
        <? } ?>
			</tr>
<?php }else{ ?>
            <tr>
              <td class="cabecera"rowspan="2">N°</td>
              <td class="cabecera"rowspan="2">Marca</td>
              <td class="cabecera"rowspan="2">Modelo</td>
              <td class="cabecera"rowspan="1"colspan="2">Serial</td>
              <td class="cabecera"rowspan="1"colspan="2">Año</td>
              <td class="cabecera"rowspan="2">Color</td>
          <?if($sel_Lista==3){?>
              <td class="cabecera"rowspan="2">N° Placa</td>
              <? } ?>
			</tr>
			<tr>
              <td class="cabecera">Motor</td>
              <td class="cabecera">Carrocería</td>
              <td class="cabecera">Fabricación</td>
              <td class="cabecera">Modelo</td>
			</tr>
<?}    for($i=0;$i<$dimListado;$i+=$nroCampos){
          if($listado[$i+3]){
             $color = (!$indC)?"datosimpar":"datospar";
             $indC = !$indC;
             $n = $offset+$i/$nroCampos + 1;
		if($sel_Lista==1 or $sel_Lista==2){
?>
             <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $n?></td>
               <td align="center"><?php echo $listado[$i+3]?></td>
               <td align="center"><?php echo $listado[$i+8]?></td>
               <td align="left">&nbsp;<?php echo $listado[$i+9].' '.$listado[$i+10]?></td>
			<?if($sel_Lista==1){?>
               <td align="center"><?php echo $listado[$i+13]?></td>
               <td align="center"><?php echo $listado[$i+18]?></td>
			<? } ?>
             </tr>
<?php     }else{ ?>
             <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $n?></td>
               <td align="center"><?php echo $listado[$i]?></td>
               <td align="center"><?php echo $listado[$i+1]?></td>
               <td align="center"><code><?php echo $listado[$i+2]?></code></td>
               <td align="center"><code><?php echo $listado[$i+3]?></code></td>
               <td align="center"><?php echo $listado[$i+4]?></td>
               <td align="center"><?php echo $listado[$i+5]?></td>
               <td align="center"><?php echo $listado[$i+6]?></td>
<?	if($sel_Lista==3){?>
               <td align="center"><code><?php echo $listado[$i+7]?></code></td>
              <? } ?>
             </tr>

	<?
        }
        }
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
             $claseVinc = ($pgActual==$j)?"vinculoAzul":"vinculo";
       ?>
          <a class="<?php echo $claseVinc ?>" onclick="enviaPg(<?php echo $j ?>)"><?php echo $j ?></a>
       <?php }
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