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
	$permitidos = array(1,2,3,4,5,6,7,8,11,12,13,14,15,17,18);
	validaAcceso($permitidos,$dir);

  $rif=$_POST['rif'];
  $nombre=$_POST['nombre'];
  $pgActual = $_POST['pagina'];
  $indBusq = $_POST['indBusq'];

$objExcepcion = new asignacion();


$nroFilas = 15;
$nroCampos = 3;

$contExcep = $objExcepcion->f_excepciones1($rif,1,-1,$nombre);
$contExcep = count($contExcep)/$nroCampos;

$cantPaginas = ceil($contExcep/($nroFilas));
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

$listaExcep = $objExcepcion->f_excepciones1($rif,1,$offset,$nombre);

$valor = $_POST['valor'];

if ($indBusq==4){
	$bloquearN=$objExcepcion->bloqExcepcion($valor);


	if ($bloquearN){
	   		echo '<SCRIPT>alert("Excepción desactivada");</SCRIPT>';
			echo '<SCRIPT>window.location.href="listado_excepciones.php";</SCRIPT>';
	}
}

if ($indBusq==5){
	$desbloquearN=$objExcepcion->desbloqExcepcion($valor);

		if ($desbloquearN){
       		echo '<SCRIPT>alert("Excepción activada");</SCRIPT>';
            echo '<SCRIPT>window.location.href="listado_excepciones.php";</SCRIPT>';
	 	}
		else
		{
			echo '<SCRIPT>alert("No se pudo activar la Excepción");</SCRIPT>';
			echo '<SCRIPT>window.location.href="listado_excepciones.php";</SCRIPT>';
		}

}

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
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=no,width=850,height=250,resizable=no,left=50,top=50");
}

function enviar(dato){
 document.registro.indBusq.value = dato;
}

function envia(dato,valor){
 document.registro.indBusq.value = dato;
 document.registro.valor.value = valor;
 document.registro.submit();
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
           <td  class="categoria">Rif:</td>
           <td>
			<input name="rif" type="text" id="rif" value="" />
		  </td>
		   <td  class="categoria">Nombre: </td>
           <td>
			<input name="nombre" type="text" id="nombre" value="" onblur="javascript:this.value=this.value.toUpperCase()"  />
		  </td>
          </tr>
          <tr>
            <td align="center" colspan="4" >
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden"  name="indReg" >
		    <INPUT type="hidden" name="valor">
		    <INPUT type="hidden" name="idUsu" >
           </td>
          </tr>
  </table>
   </fieldset>

 <fieldset class="form">
  <legend>Listado Excepciones
  </legend>
    <table width="90%" align="center" class="detalles">
    <tr>
        <td colspan="5" align="right"><a class="vinculo" target="_blank" onClick="abrir('reg_excepcion.php');" />
  		<IMG title="Agregar" src="botones/add_48.png" height="20" ></a>
 		<a class="vinculo" target="_blank" onClick="abrir('reportes/vehImportados.php?sercarveh=<?php echo $sercarveh; ?>&codmar=<?php echo $codmar; ?>&modveh=<?php echo $modveh; ?>&serveh=<?php echo $serveh; ?>&lote=<?php echo $numlotveh; ?>&factura=<?php echo $factura; ?>&taller=<?php echo $taller; ?>&tt=<?php echo $tt; ?>');" />
  		<IMG title="PDF" src="botones/pdf.png" height="15" ></a>
 		</td>
 	</tr>
             <tr>
              <td class="cabecera">N°</td>
              <td class="cabecera">Nombre</td>
              <td class="cabecera">RIF</td>
              <td class="cabecera">Bloq./Desbloq.</td>
             </tr>
<?php
        for($i=0;$i<count($listaExcep);$i+=$nroCampos){
          if($listaExcep[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
     ?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?echo $i/$nroCampos+$offset+1?></td>
               <td align="left"><?php echo $listaExcep[$i+1];?></td>
               <td align="left"><?php echo $listaExcep[$i];?> </td>
               <TD align="center">
			   <?php if($listaExcep[$i+2]=='L'){?>
			       <IMG onclick="envia(5,'<?php echo $listaExcep[$i]?>')" src="imagenes/notice-alert.png" width="20" title="Activar Excepcion">
			    <?php }else{ ?>
			       <IMG onclick="envia(4,'<?php echo $listaExcep[$i]?>')" src="imagenes/correcto.png" width="20" title="Desactivar Excepcion">
			    <?php } ?>
			   </TD>
               <!--<td align="center"><img src="imagenes/correcto.png" width="20" height="20" onClick="envia(4,'<?php echo $listaIP[$i+1]?>')">
               <td align="center">
	             <img src="botones/delete.png" width="20" height="20" onClick="abrir('elim_ip.php?codi=<? echo $listaIP[$i+1]; ?>')">
	          </td>-->

<?php    }
      } ?>
  <tr><td colspan=9> <?php echo 'Total: '.$contExcep?></td></tr>
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