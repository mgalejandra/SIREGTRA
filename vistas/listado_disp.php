<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/disponibilidad.php');

/*	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(1,3,4,5,6,7,8);
	validaAcceso($permitidos,$dir);*/

$obj = new disponibilidad();
$permitidos = array(1,2,3,4,5,11,13,17);
validaAcceso($permitidos,$dir);
  $indBusq 	 = $_POST['indBusq'];
  $id_disp=$_POST['id_disp'];
  $fecha=$_POST['fecha'];
  $laboral=$_POST['laboral'];
  $tarde=$_POST['tarde'];
  $manana=$_POST['manana'];
  $rest_manana=$_POST['rest_manana'];
  $rest_tarde=$_POST['rest_tarde'];


$pgActual = $_POST['pagina'];

$nroFilas = 10;
$nroCampos = 7;

if($indBusq==2){
	$fecha=null;
  	$laboral= null;
	$tarde= null;
	$manana	= null;
	$rest_manana= null;
	$rest_tarde	= null;
}

/*if($indBusq==3){
	$ctrl=$obj->anularEntrega($id_entrega,&$msj);
//	f_alert($msj);
}
*/

$data = array($id_disp,$fecha,$laboral,$manana,$tarde,$manana,$tarde);

//$contiTem = $obj->ContarDispFechas();
$contiTem = $obj->listarDisponibilidad($id_disp,$fecha,$laboral,-1);
$contiTem1 = count($contiTem)/$nroCampos;

$cantPaginas = ceil($contiTem1/$nroFilas);
if(!$pgActual) $pgActual = 1;
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

$listaDisp = $obj->listarDisponibilidad($id_disp,$fecha,$laboral,$offset);

?>
<script type="text/javascript">
document.oncontextmenu = function(){return false;}
</script>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
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
  <legend>Criterios de B&uacute;squeda
  </legend>
     <table  align="center" id="tabla1" name="tabla1">
        <tr>
          <td class="categoria">Fecha:</td>
        <td class="dato" >
          <input name="fecha" type="text" id="fecha" onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)" value="" size="10"  maxlength="10" date_format="dd/MM/yy" readonly="" onBlur="javascript:this.value=this.value.toUpperCase()"/>
          <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecha',document.forms[0].fecha.value)" />
 <td  </td>
<td  class="categoria">Día Laborable:</td>
	        <td >Si
		        <input type="radio" name="laboral" id="laboral"  value="S" <?php "checked= 'true'"?>/>
		         No
		        <input type="radio" name="laboral" id="laboral"  value="N" <?php  "checked= 'true'"?>/>
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
   <br/>
 <fieldset class="form">
  <legend>Lista de Fechas Registradas
  </legend>

       <DIV class="nivel2">
    <table width="90%" align="center" class="detalles" id="tabla2" name="tabla2">
            <tr>
              <td class="cabecera">&nbsp;ID&nbsp;</td>
              <td class="cabecera">Fecha</td>
              <td class="cabecera">Laborable</td>
              <td class="cabecera">Cupos Mañana</td>
              <td class="cabecera">Cupos Tarde </td>
              <td class="cabecera">Cupos Rest.Mañana</td>
              <td class="cabecera">Cupos Rest.Tarde</td>
                <td class="cabecera">B</td>

            </tr>
<? 	for($i=0;$i<count($listaDisp);$i+=$nroCampos){

?>
             <tr id="fila<?=$i?>" class="datosimpar">
               <td align="center"><?= $listaDisp[$i]?></td>
               <td align="center"><?= $listaDisp [$i+1]?></td>
               <td align="center"><?= $listaDisp[$i+2]?></td>
               <td align="center"><?= $listaDisp[$i+3]?></td>
               <td align="center"><?= $listaDisp[$i+4]?></td>
               <td align="center"><?= $listaDisp[$i+5]?></td>
               <td align="center"><?= $listaDisp[$i+6]?></td>
               <td><div align="center">
               <a class="vinculo" href="mod_fechas.php?id_disp=<?= $listaDisp[$i]?>&indReg=1">
	              <img src="botones/modificar.png" width="20" height="20">
	          </a></div></td>

	    	   </td>
             </tr>
<?}?>
    </table>
 </fieldset>
<BR>
 <div align="center">
       <?php
         if($pgActual>1){ ?>
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