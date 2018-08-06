<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/entrega.php');
require('../modelos/marca.php');
require('../modelos/acto.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(1,2,3,4,5,6,7,8,11,15,18,23,25);
	validaAcceso($permitidos,$dir);

$obj = new entrega();
$objActo = new acto();

  $indBusq 	 = $_POST['indBusq'];
  $id_entrega= $_POST['id_entrega'];

  $sercarveh = $_POST['sercarveh'];

  $beneficia = $_POST['beneficiario'];
  $numlotveh = $_POST['numlotveh'];
  $codmarveh = $_POST['codmar'];
  $desmarveh = $_POST['desmar'];
  $codmodveh = $_POST['codmodveh'];
  $desmodveh = $_POST['desmodveh'];
  $codserveh = $_POST['codserveh'];
  $desserveh = $_POST['desserveh'];
  $acto      = $_POST['actveh'];

$PDI	 	= $_POST['PDI'];
$gas	 	= $_POST['gas'];
$fecEntrega	= $_POST['fecEntrega'];
$xlugar	 	= $_POST['xlugar'];

$pgActual = $_POST['pagina'];

$nroFilas = 20;
$nroCampos = 10;

if($indBusq==2){
	$beneficia  = null;
	$numlotveh 	= null;
  	$codmarveh	= null;
  	$desmarveh  = null;
  	$codmodveh	= null;
  	$desmodveh	= null;
  	$codserveh	= null;
  	$desserveh	= null;
  	$lugar		= null;
}

if($indBusq==3){
	$ctrl=$obj->anularEntrega($id_entrega,&$msj);
//	f_alert($msj);
}

$data = array($id_entrega,$sercarveh,$beneficia,$PDI,$gas,$fecEntrega,$numlotveh,$codmarveh,$codmodveh,$xlugar,$acto);

$contiTem = $obj->contarEntregas($data);

$cantPaginas = ceil($contiTem/$nroFilas);
if(!$pgActual)$pgActual = 1;
elseif($pgActual > $cantPaginas)$pgActual = $cantPaginas;

if($cantPaginas <= 10){
	$pgIni = 1;
	$pgFin = $cantPaginas;
}
elseif($cantPaginas > 10 AND $pgActual< 5 ){
	$pgIni = 1;
	$pgFin = 10;
}
elseif($cantPaginas > ($pgActual+5) AND $pgActual>=5){
	$pgIni = $pgActual - 4;
	$pgFin = $pgActual + 5;
}
else{
	$pgIni = $pgActual - 4;
	$pgFin = $cantPaginas;
}

$offset =  ($pgActual-1) * $nroFilas;

$listaEntrega = $obj->listarEntregas($data,$offset,$nroFilas);

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

//////////////////////////////////////////////////////////////////////////////////////////////////

function eliminar(iRow,iEnt,ind){
	if (confirm("¿Desea eliminar ésta entrega?")){
		var tabla = document.getElementById("tabla2");
		var cont = parseInt(document.getElementById("contiTem").value);

	    tabla.deleteRow(iRow);
		cont = cont - 1;

//	    alert(iRow+' '+iEnt+' '+ind+' '+cont);

		document.registro.contiTem.value = cont;
		document.registro.indBusq.value = ind;
		document.registro.id_entrega.value = iEnt;
		window.document.registro.submit();
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////

function f_lugar(){
	document.registro.xlugar.value = document.registro.lugar.value;
	window.document.registro.submit();
}
//////////////////////////////////////////////////////////////////////////////////////////////////

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
     <table  align="center" id="tabla1" name="tabla1">
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
			<input name="beneficiario" type="text" id="beneficiario" value="" onblur="javascript:this.value=this.value.toUpperCase()"/>
		  </td>
		</tr>
		<tr>
           <td  class="categoria">Marca:</td>
           <td colspan="1">
			<input name="codmar" type="hidden" id="codmar" value="<?echo $codmarveh?>" />
	        <input name="desmar" type="text" id="desmar"  value="<?echo $desmarveh?>" readonly=""/>
	        <input name="marca"  type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
		  </td>
           <td class="categoria">Modelo:</td>
           <td align="left">
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?echo $codmodveh?>" />
             <input name="desmodveh" type="text" id="modveh" value="<?echo$desmodveh?>" size="20" maxlength="15" readonly=""/>
             <input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." />
          </td>
		<td class="categoria">Lugar:</td>
		<td align="left">
			 <SELECT name="lugar" id="lugar" onchange="f_lugar()" onkeydown="f_lugar()" onkeyup="f_lugar()" >
			    <OPTION value=""></OPTION>
			    <OPTION value="CARACAS" <? if($xlugar=="Caracas") echo"selected='true'"?>>Caracas</OPTION>
			    <OPTION value="MARACAY" <? if($xlugar=="Maracay") echo"selected='true'"?>>Maracay</OPTION>
			    <OPTION value="VALENCIA"<? if($xlugar=="Valencia")echo"selected='true'"?>>Valencia</OPTION>
			 </SELECT>
		</td>
         </tr>
         <td  class="categoria">Acto:</td>
          <td align="left">
             <input name="desacto" type="text" id="desacto" value="<?php echo $acto ?>" size="20" maxlength="3" readonly=""/>
             <input type="button" onclick="catalogo('cat_acto.php');" value="..." />
          </td></tr>

          <tr>
            <td align="center" colspan="7">
            <input id="boton1" name="boton1" type="submit" value="Buscar" onclick="enviar(1)"/>
            <input id="boton2" name="boton2" type="submit" value="Limpiar" onclick="enviar(2)"/>
            </td>
         </tr>
          <tr><td>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden" name="indReg" >
		    <input type="hidden" name="actveh" id="actveh"/>
		    <INPUT type="hidden" name="xlugar" id="xlugar">
           </td></tr>
  </table>
   </fieldset>
 <fieldset class="form">
  <legend>Lista de veh&iacute;culos entregados</legend>

       <DIV class="nivel2">
    <table width="90%" align="center" class="detalles" id="tabla2" name="tabla2">
            <tr>
              <td class="cabecera">&nbsp;ID&nbsp;</td>
              <td class="cabecera">Lote</td>
              <td class="cabecera">Serial de Carrocer&iacute;a</td>
              <td class="cabecera">Beneficiario</td>
              <td class="cabecera">Lugar</td>
              <td class="cabecera">Fecha Entrega</td>
              <td class="cabecera">Fecha Registro</td>
              <td class="cabecera">Acto</td>
              <td class="cabecera"colspan="2"></td>
            </tr>
<? 	for($i=0;$i<count($listaEntrega);$i+=$nroCampos){
	  $datosActo = "";
	  if ($listaEntrega[$i+9])
	  {
	  	$buscarActo = $objActo->buscarActoID($listaEntrega[$i+9]);

        if ($buscarActo)
	  	{
	  		$datosActo = $buscarActo[1]." - ".$buscarActo[2];
	  	}
	  }
?>
             <tr id="fila<?=$i?>" class="datosimpar">
               <td align="center"><?php echo $listaEntrega[$i]?></td>
               <td align="center"><?php echo str_pad($listaEntrega[$i+1],3,"0",STR_PAD_LEFT)?></td>
               <td align="center"><?= $listaEntrega[$i+2]?></td>
               <td >&nbsp;<?= $listaEntrega[$i+3]?></td>
               <td align="center"><?= $listaEntrega[$i+6]?></td>
               <td align="center"><?= $listaEntrega[$i+7]?></td>
               <td align="center"><?= $listaEntrega[$i+8]?></td>
               <td align="center"><?= $datosActo ?></td>
                <? if ($_SESSION['tipoUsuario']<>'18'){?>
               <td><div align="center">
               <a class="vinculo" href="reg_entrega_veh.php?id=<?= $listaEntrega[$i]?>">
	              <img src="botones/buscar.png" width="20" height="20">
	          </a></div></td>
		       <td align="center" width="2%"><div title="Anular entrega"></div>
	     			<img src="imagenes/notice-alert.png" onclick="eliminar(<?=$i/$nroCampos+2?>,<?=$listaEntrega[$i]?>,3); return false" width="24" height="24"/>
	    	   </td><?php } ?>
             </tr>
<?}?>
  <tr><td colspan=9> <?= 'Total vehículos entregados: '.$contiTem?></td></tr>
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
          <a class="<?= $claseVinc ?>" onclick="enviaPg(<?= $j ?>)"><?= $j ?></a>
       <?php
         }
         if($pgActual<$pgFin){
       ?>
         <img src="imagenes/adelante.png" width="20" height="15"  class="vinculo" onclick="avanzaPg()">
       <?php } ?>
       <BR>
		<input type="hidden" name="contiTem" id="contiTem" value="<?=$contiTem?>"/>
       	<input type="hidden" name="id_entrega" id="id_entrega"/>
       	<input type="hidden" name="pagina" value="<?= $pgActual ?>"/>

       <br />
     </div>
     <div align="center" >
        <input type="button" onclick="window.location.href='reg_entrega_veh.php'" value="Registrar otra entrega..."/>
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