<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/estatus.php');

$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(1,2);
	validaAcceso($permitidos,$dir);

$objFactura = new estatus();

$indBusq = $_POST['indBusq'];
$descripcion=$_POST['descripcion'];
$orden=$_POST['orden'];
$pgActual = $_POST['pagina'];

$nroFilas = 11;
$nroCampos = 4;

if($indBusq==2){
	$descripcion=null;


}
$contiTem = $objFactura->ContarStatus($descripcion,$orden);
$cantPaginas = ceil($contiTem/$nroFilas);
if(!$pgActual)$pgActual = 1;
elseif($pgActual > $cantPaginas)$pgActual = $cantPaginas;

if($cantPaginas <= 11){
	$pgIni = 1;
	$pgFin = $cantPaginas;
}
elseif($cantPaginas > 11 AND $pgActual< 5 ){
	$pgIni = 1;
	$pgFin = 11;
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

$listaStatus = $objFactura->listarStatus('',$descripcion,$orden,$offset);

?>
<script type="text/javascript">
document.oncontextmenu = function(){return false;}
</script>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
  <script type="text/javascript" src="../controlador/ajax.js"></script>
  <script type="text/javascript" src="../controlador/validar.js"></script>
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
  <legend width="20" >  Criterios de B&uacute;squeda </legend>
     <table  align="center" id="tabla1" name="tabla1">
        <tr>

<td  class="categoria">  Descripción:</td>
<td>
 <input name="descripcion" type="text" id="descripcion" maxlength="30"  size="20" onblur="javascript:this.value=this.value.toUpperCase()" />
</td>

<td  class="categoria">  Orden:</td>
<td>
 <input name="orden" type="text" id="orden" maxlength="5" size="10" onblur="javascript:this.value=this.value.toUpperCase()" />
</td>
      </tr>
       <tr>
           </td></tr>
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
  <legend> Lista de Estatus  </legend>

       <DIV class="nivel2">
      <table width="90%" align="center" class="detalles2" id="tabla2" name="tabla2">
              <tr>
              <td class="cabecera">&nbsp;ID&nbsp;</td>
              <td class="cabecera">Descripcion</td>
              <td class="cabecera">Orden</td>
              <td class="cabecera">M</td>
            </tr>

<? 	for($i=0;$i<count($listaStatus);$i+=$nroCampos){

?>
             	<tr id="fila<?=$i?>" class="datosimpar">
             	<td align="center"><?= $listaStatus[$i]?></td>
              	 <td align="left"><?= $listaStatus [$i+1]?></td>
               	<td align="center"><?= $listaStatus[$i+2]?></td>


               <td><div align="center">
          <a class="vinculo" href="modStatus.php?id=<?=$listaStatus[$i]?>&indReg=1">
	              <img src="imagenes/edit_f2.png" width="30" height="30">
	          </a></div></td>

	    	   </td>
             </tr>
<?}?>
  <tr><td colspan=9> <?= 'Total Estatus: '.$contiTem?></td></tr>
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
       	<input type="hidden" name="hidden" id="id_disp"/>
       	<input type="hidden" name="pagina" value="<?= $pgActual ?>"/>


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