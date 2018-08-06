<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/certificado.php');
require('../modelos/envios.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,11,18,21,22,24);
	validaAcceso($permitidos,$dir);

$objCertificado = new certificado();
$objenvios = new envios();

$indReg=$_POST['indReg'];
$nroenvio=$_POST['nroenvio'];
$tipo=$_POST['tipo'];
$estatus=$_POST['estatus'];
$pgActual = $_POST['pagina'];

if ($indReg=='1'){
	$enviar=$objenvios->cambiarEstatusEnvio($nroenvio,$tipo,$estatus);
}


$nroFilas = 24;
$nroCampos = 10;

$contArt = $objenvios->contarcomboEnvio('2');

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

$comboEnvio = $objenvios->comboEnvio('2',$offset);
?>
<!DOCTYPE HTML PUBLIC ">
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
   <script>

function enviar(dato){

 var conf = confirm ('Esta Seguro que Desea Cambiar el estatus de este envio');
	        if(conf){
	         document.registro.indReg.value = dato;
             document.registro.submit();
	        }
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
  <legend>Listado de Envios al INTT</legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">Numero de Envio </td>
              <td class="cabecera"> Fec. Envio </td>
              <td class="cabecera"> Agregados </td>
              <td class="cabecera"> Modificado</td>
              <td class="cabecera"> Eliminado </td>
              <td class="cabecera"> Tipo </td>
              <td class="cabecera">Status</td>
             </tr>
   <?php for($i=0;$i<count($comboEnvio);$i+=10)
   {
          if($comboEnvio[$i]){
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
               <td align="center"><?php echo $comboEnvio[$i];?> </td>
               <td align="center"><?php echo $comboEnvio[$i+1];?></td>
               <td align="right"><?php echo $comboEnvio[$i+2];?></td>
               <td align="right"><?php echo $comboEnvio[$i+3];?> </td>
               <td align="right"><?php echo $comboEnvio[$i+4];?> </td>
               <td><?php echo $comboEnvio[$i+5];?>
               <input type="hidden" name="nroenvio[<?php echo $i/10?>]"  value="<?php echo $comboEnvio[$i];?>" />
               <input type="hidden" name="tipo[<?php echo $i/10?>]"   value="<?php echo $comboEnvio[$i+6];?>" />
               </td>
               <td align="left"><?php echo $comboEnvio[$i+9];?></td>

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
		   <input type="hidden" name="indReg" />
		   <input type="hidden" name="codProv" />
		   <input type="hidden" name="pagina" value="<?php echo $pgActual ?>"/>
       <BR/>
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
