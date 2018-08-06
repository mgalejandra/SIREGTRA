<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/citas.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,6,7,8,11,12,13,14,15,17,18);
	validaAcceso($permitidos,$dir);

  $ip=$_POST['ip'];
  $pgActual = $_POST['pagina'];
  $indBusq = $_POST['indBusq'];

$objIP = new citas();


$nroFilas = 15;
$nroCampos = 5;

$contIP = $objIP->listarIP($ip,-1);
$contIP = count($contIP)/$nroCampos;

$cantPaginas = ceil($contIP/($nroFilas));
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

$listaIP=$objIP->listarIP($ip,$offset);

$valor = $_POST['valor'];

if ($indBusq==4){
	$bloquearN=$objIP->bloquearIP($valor);

	if ($bloquearN){
	   		echo '<SCRIPT>alert("IP bloqueada nuevamente");</SCRIPT>';
			echo '<SCRIPT>window.location.href="listado_ips.php";</SCRIPT>';
	}
}

if ($indBusq==5){
	$eliminar=$objIP->borrarIP($valor);

		if ($eliminar){
       		echo '<SCRIPT>alert("IP desbloqueada");</SCRIPT>';
            echo '<SCRIPT>window.location.href="listado_ips.php";</SCRIPT>';
	 	}
		else
		{
			echo '<SCRIPT>alert("No se pudo desbloquear la IP");</SCRIPT>';
			echo '<SCRIPT>window.location.href="listado_ips.php";</SCRIPT>';
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
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=no,width=400,heigth=100,resizable=no,left=50,top=50");
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
  <legend>Criterios de Búsqueda
  </legend>
     <table  align="center" >
          <tr>
           <td  class="categoria">IP:</td>
           <td>
			<input name="ip" type="text" id="ip" value="" />
		  </td>
          </tr>
          <tr>
            <td align="center" colspan="2" >
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
  <legend>Lista de IP's bloqueadas
  </legend>
    <table width="90%" align="center" class="detalles">
    <tr>
        <td colspan="5" align="right"><a class="vinculo" target="_blank" onClick="abrir('reg_ip.php');" />
  		<IMG title="Agregar" src="botones/add_48.png" height="20" ></a>
 		<a class="vinculo" target="_blank" onClick="abrir('reportes/vehImportados.php?sercarveh=<?php echo $sercarveh; ?>&codmar=<?php echo $codmar; ?>&modveh=<?php echo $modveh; ?>&serveh=<?php echo $serveh; ?>&lote=<?php echo $numlotveh; ?>&factura=<?php echo $factura; ?>&taller=<?php echo $taller; ?>&tt=<?php echo $tt; ?>');" />
  		<IMG title="PDF" src="botones/pdf.png" height="15" ></a>
 		</td>
 	</tr>
             <tr>
              <td class="cabecera">N°</td>
              <td class="cabecera">IP</td>
              <td class="cabecera">Status</td>
              <td class="cabecera">Bloq./Desbloq.</td>
 			 <!-- <td class="cabecera">Bloq.</td>
              <td class="cabecera">Desbloq.</td>-->
             </tr>
<?php
        for($i=0;$i<count($listaIP);$i+=$nroCampos){
          if($listaIP[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
     ?>



              <tr class="<?php echo $color ?>">
               <td align="center"><?echo $i/$nroCampos+$offset+1?></td>
               <td align="center"><?php echo $listaIP[$i+1];?></td>
               <td align="center"><?php if ($listaIP[$i+2]=='B')  echo "Bloqueada"; else echo "Desbloqueada";?> </td>
               <TD align="center">
			   <?php if($listaIP[$i+2]=='B'){?>
			       <IMG onclick="envia(5,'<?php echo $listaIP[$i+1]?>')" src="imagenes/notice-alert.png" width="20" title="Desbloquear IP">
			    <?php }else{ ?>
			       <IMG onclick="envia(4,'<?php echo $listaIP[$i+1]?>')" src="imagenes/correcto.png" width="20" title="Bloquear IP">
			    <?php } ?>
			   </TD>
               <!--<td align="center"><img src="imagenes/correcto.png" width="20" height="20" onClick="envia(4,'<?php echo $listaIP[$i+1]?>')">
               <td align="center">
	             <img src="botones/delete.png" width="20" height="20" onClick="abrir('elim_ip.php?codi=<? echo $listaIP[$i+1]; ?>')">
	          </td>-->

<?php    }
      } ?>
  <tr><td colspan=9> <?php echo 'Total: '.$contIP?></td></tr>
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