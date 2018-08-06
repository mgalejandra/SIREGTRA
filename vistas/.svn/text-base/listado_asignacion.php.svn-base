<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/asignacion.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,6,7,8,11,13,17,18,22,23,25);
	validaAcceso($permitidos,$dir);

 $indBusq  = $_POST['indBusq'];
 $pgActual = $_POST['pagina'];

 $numlotveh = $_POST['numlotveh'];
 $sercarveh = $_POST['sercarveh'];
 $codpro	= $_POST['codpro'];
 $nombre	= $_POST['nombre'];
 $fechAsig	= $_POST['fechAsig'];
 $tipo	= $_POST['tipo'];
 $taller = $_POST['codtal'];
 $tt = $_POST['todo_taller'];
 $codmodveh=$_POST['codmodveh'];

 $_SESSION['numlotveh'] = $numlotveh;
 $_SESSION['sercarveh'] = $sercarveh;
 $_SESSION['codpro'] = $codpro;
 $_SESSION['nombre'] = $nombre;
 $_SESSION['fechAsig'] = $fechaAsig;
 $_SESSION['taller'] = $taller;


$objAsignacion = new asignacion();

if($indBusq==2){
 $numlotveh = null;
 $sercarveh = null;
 $codpro	= null;
 $nombre	= null;
 $fechAsig	= null;
 $tipo	= null;
 $taller = null;
 $tt = null;
 $codmodveh= null;
}




$nroFilas = 15;

if ($taller or $tt)
	$nroCampos = 15;
else
	$nroCampos = 13;


//$cantReg = $objAsignacion->contarAsignacion($sercarveh,$codpro,$nombre,$fechAsig,$numlotveh,$tipo,'',$taller,$tt,$_SESSION['numeDepa']);
$cantReg=$objAsignacion->listarAsignacion1($sercarveh,$codpro,$nombre,$id,$fechAsig,$numlotveh,-1,$tipo,$taller,$tt,$_SESSION['numeDepa'],'',$codmodveh);

$cantReg=count($cantReg)/$nroCampos;
$cantPaginas = ceil($cantReg/($nroFilas));

if(!$pgActual){
	$pgActual = 1;
		//echo 'entro1';
}
elseif($pgActual > $cantPaginas){
     $pgActual = $cantPaginas;
     	//echo 'entro2';
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
	//echo '$offset'.$offset;

$listarAsignacion=$objAsignacion->listarAsignacion1($sercarveh,$codpro,$nombre,$id,$fechAsig,$numlotveh,$offset,$tipo,$taller,$tt,$_SESSION['numeDepa'],'',$codmodveh);

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

function abrir(campo)
{
pagina=campo;
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=500,resizable=yes,left=50,top=50");
}

 function imprimir(tipo) {
  dato=tipo;
  day = new Date();
  id = day.getTime();
  eval("page" + id +
  	   " = window.open('reportes/listAsignaciones.php?tip='+dato,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
  }

function enviar(dato){
	if(dato=="2"){
		window.document.registro.numlotveh.value = null;
		window.document.registro.cosercarvehdmar.value = null;
		window.document.registro.codpro.value = null;
		window.document.registro.nombre.value = null;
		window.document.registro.fechAsig.value = null;
	}
	document.registro.pagina.value = 0;
	document.registro.indBusq.value = dato;
}


function exel(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id +
	  	   " = window.open('reportes/xlsListadoAsignacion.php?numlotveh=<? echo$numlotveh?>&modelo=<? echo$codmodveh?>&sercarveh=<? echo$sercarveh?>&codpro=<? echo$codpro?>&nombre=<? echo $nombre ?>&fechAsig=<? echo $fechAsig?>&tipo=<? echo$tipo?>&codtal=<? echo$taller?>&todo_taller=<? echo$tt?>
&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

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
  <legend>Criterios de B&uacute;squeda
  </legend>
     <table  align="center" >
          <tr>
          <td  class="categoria">N° Lote:</td>
          <td align="left">
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
          </td>

		  <td  class="categoria">&nbsp;Serial:</td>
           <td>
			<input name="sercarveh" type="text" id="cosercarvehdmar"  value="<?php echo $sercarveh?>" />&nbsp;&nbsp;
		  </td>
           <td  class="categoria">CI/RIF:</td>
           <td>
             <input name="codpro" type="text" id="codpro" value="<?php echo $codpro?>" onblur="javascript:this.value=this.value.toUpperCase()" size="10" maxlength="10" />&nbsp;&nbsp;
          </td>
           <td class="categoria">Nombre:</td>
           <td>
              <input name="nombre" type="text" id="nombre" value="<?php echo $nombre?>" onblur="javascript:this.value=this.value.toUpperCase()" size="20" width="60" maxlength="120"/>
           </td>
            </tr>
	          <tr>
	           <td  class="categoria">Fecha:</td>
	        <td class="dato">
	         <input name="fechAsig" type ="text" id="fechAsig"
	         		value="<?=$fechAsig?>" size="8" maxlength="10" date_format="dd/MM/yy"
	         		onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)" readonly=""/>
		          <img src="../images/cal.gif" width="16" height="16"
		          		onClick="show_calendar('document.forms[0].fechAsig',document.forms[0].fechAsig.value)" />
	        </td>
	         <td  class="categoria">Tipo:</td>
	        <td >Asignados
		        <input type="radio" name="tipo" id="tipo"  value="A" <?php if ($tipo!='L') echo "checked= 'true'"?>/>
		        Liberados
		        <input type="radio" name="tipo" id="tipo"  value="L" <?php if ($tipo=='L') echo "checked= 'true'"?>/>
	        </td>
          </tr>
            <tr> <td class="categoria">Taller:</td>
          <td class="dato" colspan="2">
             <input name="codtal" type="hidden" id="codtal" value="<?php if($ban==1)  echo $registro['codtal'];?>" />
             <input name="destaller" type="text" id="destaller" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $registro['destaller'];?>" readonly=""/>
             <input name="taller" type="button" id="taller" onclick="catalogo('cat_taller.php');" value="..." />
             </td><td >Todos los talleres <input type="radio" name="todo_taller" id="todo_taller"  value="T" /></td></tr>
          <tr>
          <tr> <td class="categoria">Modelo:</td>
           <td align="left">
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?echo $codmodveh?>" />
             <input name="desmod" type="text" id="modveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $desmod?>" size="15" readonly=""/>

             <input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." />
			</td></tr>
            <td align="center" colspan="8">
            <input type="submit" value="Buscar" onclick="enviar('1')"/>
            <input type="submit" value="Limpiar" onclick="enviar('2')"/>
            <!--<input type="submit" value="Imprimir" onclick="imprimir('<?php echo $tipo?>')"/>-->
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden" name="indReg" >
		    <INPUT type="hidden" name="idUsu" >
           </td>
          </tr>
  </table>
   </fieldset>

 <fieldset class="form">
  <legend>&nbsp;Lista de Veh&iacute;culos <?php if ($tipo=='L') echo 'Liberados'; else echo 'Asignados'; ?> &nbsp;<?if($numlotveh)echo " - Lote N°: ".$numlotveh?> <?php echo ' Total: '.$cantReg?>
  </legend>
    <table width="90%" align="center" class="detalles">
      <tr><td colspan="9" align="right"><a class="vinculo" target="_blank" onClick="abrir('reportes/listAsignaciones.php?numlotveh=<? echo$numlotveh?>&modelo=<? echo$codmodveh?>&sercarveh=<? echo$sercarveh?>&codpro=<? echo$codpro?>&nombre=<? echo $nombre ?>&fechAsig=<? echo $fechAsig?>&tipo=<? echo$tipo?>&codtal=<? echo$taller?>&todo_taller=<? echo$tt?>
');" />
  <IMG title="PDF" src="botones/pdf.png" height="15" ></a>
  <a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
 </td></tr>

             <tr>
              <td class="cabecera">N°</td>
              <td class="cabecera">Modelo</td>
              <td class="cabecera">Serial de Carrocería</td>
              <td class="cabecera">Color</td>
              <td class="cabecera">Placa</td>
              <td class="cabecera">CI/RIF</td>
              <td class="cabecera">Nombre</td>
              <td class="cabecera" width="10%">Fecha Asignación</td>
              <?php if ($tipo=='L') {?>
              <td class="cabecera">Fecha de Lib.</td>
              <td class="cabecera" >Usuario</td>
              <td class="cabecera"> Observación </td>
               <?php } ?>
              <?php if ($taller or $tt) {?>
              <td class="cabecera">Taller - Falla</td>
              <?php } ?>
              <? //if ($_SESSION['tipoUsuario']<>'18'){?> <td class="cabecera"> B </td><? //}?>
             </tr>
<?php
        for($i=0;$i<count($listarAsignacion);$i+=$nroCampos){
          if($listarAsignacion[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
             $nreg = $offset+$i/$nroCampos+1;
?>

              <tr class="<?php echo $color ?>">
               <td align="center"><?echo $nreg?></td>
               <?php if ($taller or $tt)
               			$modelo= $listarAsignacion[$i+12];
               		 else
               		 	$modelo= $listarAsignacion[$i+10];
               ?>

               <td><?php echo $modelo; ?> </td>
               <td align="center"><?php echo $listarAsignacion[$i];  ?></td>
               <td align="center"><?php echo $listarAsignacion[$i+11];?></td>
               <td align="center"><?php echo $listarAsignacion[$i+12];?></td>
               <td align="center"><?php echo $listarAsignacion[$i+1];?></td>
               <td>&nbsp;<?php echo $listarAsignacion[$i+2]?></td>
               <td align="center"><?php echo $listarAsignacion[$i+3]?> </td>
                   <?php if ($tipo=='L') {?>
                   	  <td align="center"><?php echo $listarAsignacion[$i+6]?> </td>
                   	  <td align="center"><?php echo $listarAsignacion[$i+8]?> </td>
                   	  <td align="center"><?php echo $listarAsignacion[$i+9]?> </td>
                   	<?php   } ?>
			  <?php if ($taller or $tt) {?>
              <td><?php echo $listarAsignacion[$i+10]." - ".$listarAsignacion[$i+11]; ?></td>
              <?php } ?>
              <? //if ($_SESSION['tipoUsuario']<>'18'){?> <td><div align="center">
               <a class="vinculo" href="reg_asignacion.php?idsercarveh=<?php echo $listarAsignacion[$i]?>&tipo=<?php echo $tipo?>">
	              <img src="botones/buscar.png" width="20" height="20">
	          </a></div></td><?// }?>
              </tr>
<?php     }
        }
?>
  <tr><td class="categoria"> </td></tr>
    </table>
 </fieldset>

<BR>
 <div align="center">
       <?php if($pgActual>1){?>
         <img src="imagenes/atras.png" width="20" height="15" class="vinculo" onclick="regresaPg()">
       <?php }
         for($j=$pgIni;$j<=$pgFin;$j++){
             $claseVinc = ($pgActual==$j)?'vinculoAzul':'vinculo';
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

       <br/>
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