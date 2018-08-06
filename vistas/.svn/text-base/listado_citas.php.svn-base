<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/beneficiario.php');
require('../modelos/pago.php');
require('../modelos/citas.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,6,7,8,11,12,13,14,17,22,25);
	validaAcceso($permitidos,$dir);


$objCita = new citas();

$nombre=$_POST['nombre'];
$rif=$_POST['rif'];
$fec=$_POST['fec'];
$fec2=$_POST['fec2'];
$cita=$_POST['cita'];
$ipcli=$_POST['ipcli'];

$indBusq=$_POST['indBusq'];
$pgActual = $_POST['pagina'];

$nroFilas = 20;
$nroCampos = 25;


if($indBusq==2){
	$nombre = null;
	$rif    = null;
	$fec    = null;
	$fec2   = null;
	$cita   = null;
	$ipcli= null;
}

$contcit = $objCita->listarCitasUsuario($nombre,$rif,$fec,$fec2,$cita,$ipcli,-1);

$contArt =count($contcit)/$nroCampos;

//echo "<br>conArt: ".$contArt;

$cantPaginas = ceil($contArt/($nroFilas));

//echo "<br>Paginas: ".$cantPaginas;


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

/*echo "<br>Offset: ".$offset;

echo "<br>Pagina Actual: ".$pgActual;*/

$listarCitas=$objCita->listarCitasUsuario($nombre,$rif,$fec,$fec2,$cita,$ipcli,$offset);
?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
    <script type="text/javascript" src="../controlador/calendario.js"></script>
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

function enviar(campo){
	window.document.registro.indBusq.value = campo;
	window.document.registro.submit();
}

function abrir(campo)

{
pagina=campo;
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=500,resizable=yes,left=50,top=50");
}

function popup(URL) {
  day = new Date();
  id = day.getTime();
  eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=600,height=600');");
}

function exel(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id +
	  	   " = window.open('reportes/xlsListarCitas.php?rif=<?php echo$rif;?>&ipclio=<?php echo$ipcli;?>&nombre=<?php echo$nombre;?>&banco=<?php echo$banco;?>&fec=<?php echo$fec;?>&fec2=<?php echo$fec2;?>&cita=<?php echo$cita;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

}

function exel1(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id +
	  	   " = window.open('reportes/xlsListarCitasD.php?rif=<?php echo$rif;?>&nombre=<?php echo$nombre;?>&banco=<?php echo$banco;?>&fec=<?php echo$fec;?>&fec2=<?php echo$fec2;?>&cita=<?php echo$cita;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

}
</script>
  </head>

  <body class="pagina" onload = "document.registro.rif.focus()">
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
     <table  align="center" border='0'>
     		    <tr>
           <td  class="categoria">Cita:</td>
           <td align="left">
			<input name="cita" type="text"  id="cita" value="" maxlength="9" onkeypress="return acessoNumerico(event)"/>
		  </td>
         <!-- <? if ($_SESSION['tipoUsuario']<>17){?>
          <td  class="categoria">IP:</td>
           <td align="left">
			<input name="ipcli" type="text"  id="ipcli" value="" maxlength="15" />
		  </td>
		  <? } ?>-->
             </tr>
		    <tr>
           <td  class="categoria">CI:</td>
           <td align="left">
			<input name="rif" type="text"  id="rif"  onkeypress="return acessoNumerico(event)" value="" maxlength="9" />
		  </td>
           <td  class="categoria">Nombre :</td>
           <td>
             <input name="nombre" type="text" id="nombre" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="15" />
          </td>
             </tr>
            <? if ($_SESSION['tipoUsuario']==1 or $_SESSION['tipoUsuario']==2){//if (($_SESSION['usuario']=='afloridob') or ($_SESSION['usuario']=='ymatab') or ($_SESSION['usuario']=='cmazzaglia')){?>
           <tr>
           <td valign="top" class="categoria">Desde: </td>
               <td  class="dato" >
	               <input name="fec" type="text" id="fec"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fec?>" size="10" maxlength="10" readonly="" />
	               <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec',document.forms[0].fec.value)" />
               </td>
               <td class="categoria">Hasta: </td>
               <td class="dato" >
                   <input name="fec2" type="text" id="fec2"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fec2?>" size="10" maxlength="10" readonly="" />
                   <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec2',document.forms[0].fec2.value)" />
               </td>
          </tr>
          <? }?>
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
  <legend>Listado de Beneficiarios &nbsp; <?php echo 'Total: '.$contArt?>
  </legend>
    <table width="90%" align="center" class="detalles">
  		<? if ($_SESSION['tipoUsuario'] == 2 or $_SESSION['tipoUsuario'] == 1){?>
  			<tr>
  				<td colspan="22" align="right">
  				        A <a class="vinculo" target="_blank" onClick="abrir('reportes/pdfCuadroCreditovsContado.php');" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a>
			  			B <a class="vinculo" target="_blank" onClick="abrir('reportes/pdfCuadroResCitasMin.php?fec=<?php echo $fec?>&fec2=<?php echo $fec2?>&a=<?php echo '1'?>');" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a>
				    	<a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
			    		<a class="vinculo" target="_blank" onClick="exel1(1)">
				    		<IMG title="CALC DETALLADO" src="botones/calcdet.png" height="15">
				        </a>
				         <?php } ?>
			      </td>
             </tr>
    <table width="90%" align="center" class="detalles">
           <tr>
          <!-- <td class="cabecera">Cita</td> -->
           	<td class="cabecera">Rif</td>
           	<td class="cabecera">Nombre</td>
              <td class="cabecera">Fecha Solicitud</td>
              <td class="cabecera">Fecha Cita</td>
              <td class="cabecera">Turno</td>
              <td class="cabecera" align="center">Asisti&oacute;</td>
              <? if ($_SESSION['tipoUsuario']<>'17'){?>
              <td class="cabecera" align="center">IP</td>
              <? } ?>
              <td class="cabecera" align="center">Usuario</td>
            </tr>
<?php
		for($i=0;$i<count($listarCitas);$i+=$nroCampos){
			$RIF=$listarCitas[$i+10].$listarCitas[$i+9].$listarCitas[$i+7];
?>
<tr id="dep<?=$i?>" class="datosimpar">
			<!--<td width="5%"><?= $listarCitas[$i+0]?></td>-->
			   <td align="center" width="15%">  <? if ($listarCitas[$i+6]!='E'){ ?>
			   <a class="vinculo" href="datosCita.php?id=<?php echo $listarCitas[$i+9] ?>&cita=<?php echo $listarCitas[$i+0] ?>&rif=<?php echo $RIF ?>">
			   <?= $listarCitas[$i+10].$listarCitas[$i+9].$listarCitas[$i+7]?></a>
			   <? }else echo $RIF  ?>
			   </td>
			   <td width="40%"><?= $listarCitas[$i+8]?></td>
               <td align="center" width="10%"><?= $listarCitas[$i+1]?></td>
               <td align="center" width="10%"><?= $listarCitas[$i+5]?></td>
               <? $turno=$objCita->descrTurno($listarCitas[$i+4]);?>
               <td align="center" width="8%"><?= $turno[1];?></td>
               <? if ($listarCitas[$i+6]=='A') { ?> <td align="center" width="8%">Pendiente</td><? } ?>
               <? if ($listarCitas[$i+6]=='S'){ ?><td align="center" width="8%">Asistio</td><? } ?>
               <? if ($listarCitas[$i+6]=='V'){ ?><td align="center" width="8%">Vencida</td><? } ?>
               <? if ($listarCitas[$i+6]=='E'){ ?><td align="center" width="8%"  class="error_valid" >Cita Bloqueada</td><? } ?>
               <? if ($_SESSION['tipoUsuario']<>'17'){?> <td align="center" width="10%"><? echo $listarCitas[$i+23]; ?></td><? } ?>
               <td align="center" width="10%"><? echo $listarCitas[$i+24]; ?></td>
              </tr>
		<?}

		$total=count($listarCitas)/$nroCampos; ?>
  <tr><td colspan=9> <?php echo 'Total: '.$total?></td></tr>
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