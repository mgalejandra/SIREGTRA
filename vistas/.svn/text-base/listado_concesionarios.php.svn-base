<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/concesionario.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,6,7,8,11,12,13,14,15,17,18,20);
	validaAcceso($permitidos,$dir);

  $rif=$_POST['rif'];
  $nombre=$_POST['nombre'];
  $pgActual = $_POST['pagina'];
  $indBusq = $_POST['indBusq'];

$objConcesionario = new concesionario();


$nroFilas = 15;
$nroCampos = 6;

$contConce = $objConcesionario->listarConcesionario($rif,$nombre,-1);
$contConce = count($contConce)/$nroCampos;

$cantPaginas = ceil($contConce/($nroFilas));
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

$listaConc = $objConcesionario->listarConcesionario($rif,$nombre,$offset);



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
  <legend>Listado Concesionarios
  </legend>
    <table width="90%" align="center" class="detalles">
    <tr>
        <td colspan="5" align="right"><a class="vinculo" target="_blank" onClick="abrir('reg_concesionarios.php');" />
  		<IMG title="Agregar" src="botones/add_48.png" height="20" ></a>
 		<a class="vinculo" target="_blank" onClick="abrir('reportes/vehImportados.php?sercarveh=<?php echo $sercarveh; ?>&codmar=<?php echo $codmar; ?>&modveh=<?php echo $modveh; ?>&serveh=<?php echo $serveh; ?>&lote=<?php echo $numlotveh; ?>&factura=<?php echo $factura; ?>&taller=<?php echo $taller; ?>&tt=<?php echo $tt; ?>');" />
  		<IMG title="PDF" src="botones/pdf.png" height="15" ></a>
 		</td>
 	</tr>
             <tr>
              <td class="cabecera">N°</td>
              <td class="cabecera">RIF</td>
              <td class="cabecera">Nombre</td>
              <td class="cabecera">Direcci&oacute;n</td>
              <td class="cabecera">Tel&eacute;fonos</td>
              <td class="cabecera">B</td>
             </tr>
<?php
        for($i=0;$i<count($listaConc);$i+=$nroCampos){
          if($listaConc[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
     ?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?echo $i/$nroCampos+$offset+1?></td>
               <td align="left"><?php echo $listaConc[$i+1];?></td>
               <td align="left"><?php echo $listaConc[$i+2];?> </td>
               <td align="left"><?php echo $listaConc[$i+3];?> </td>
               <td align="left"><?php echo $listaConc[$i+4]."".$listaConc[$i+5];?></td>
               <td><div align="center"><a class="vinculo" href="reg_concesionarios.php?idconce=<?php echo $listaConc[$i]?>">
	           <img src="botones/buscar.png" width="20" height="20">
	           </a></div></td>


<?php    }
      } ?>
  <tr><td colspan=9> <?php echo 'Total: '.$contConce?></td></tr>
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