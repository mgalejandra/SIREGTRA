<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/beneficiario.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(2,3,4,5);
	validaAcceso($permitidos,$dir);

  $rif=$_POST['rif'];
  $nombre=$_POST['nombre'];
  $pgActual = $_POST['pagina'];

$objBeneficiario = new beneficiario();


$nroFilas = 15;
$nroCampos = 33;

$contArt = $objBeneficiario->contarBeneficiarios($rif,$nombre,'','','');

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

$listaBen=$objBeneficiario->listarBeneficiarios($rif,$nombre,$offset,'','','');
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
  <legend>Criterios de Busqueda</legend>
     <table  align="center" >
          <tr>
           <td  class="categoria">CI/RIF:</td>
           <td>
			<input name="rif" type="text" id="rif"  onblur="javascript:this.value=this.value.toUpperCase()" value="" />
		  </td>
           <td  class="categoria">Cuenta Ordenante :</td>
           <td>
             <input name="nombre" type="text" id="nombre" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="15" />
          </td>
          </tr>
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
  <legend>Listado de Ordenantes</legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">N°</td>
              <td class="cabecera">CI/RIF</td>
              <td class="cabecera">Numero de Cuenta Ordenante</td>
              <td class="cabecera">Datos del beneficiario</td>
              <td class="cabecera" width="5%">Monto</td>
              <td class="cabecera">Motivo de la Transferencia</td>
              <td class="cabecera">Fecha Registro</td>
 <? if ($_SESSION['tipoUsuario']<>'18'){?>
              
              <?php } ?>
             </tr>
<?php
        for($i=0;$i<count($listaBen);$i+=$nroCampos){
          if($listaBen[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
             $direccion = $listaBen[$i+26];
              $direccion.= ' ';
              $direccion.= 'FECHA DE EJECUCION ';
             $direccion.= ' '.$listaBen[$i+29];
           


             ?>

              <tr class="<?php echo $color ?>">
               <td align="center"><?echo $i/$nroCampos+$offset+1?></td>
               <td align="center">&nbsp;<?php echo $listaBen[$i];?></td>
               <td><?php  echo $listaBen[$i+6];?> </td>
               <td><?php echo $direccion?></td>
               <td align="center"><?php echo $listaBen[$i+27]?> </td>
               <td align="center"><?php echo $listaBen[$i+16]?></td>
               <td align="center"><?php echo $listaBen[$i+18]?></td>
            <?php  if( $_SESSION['tipoUsuario']==11 ) {?>
               <td><div align="center">
               <a class="vinculo" href="reg_beneficiarios_c.php?idbenefi=<?php echo $listaBen[$i]?>">
	              <img src="botones/buscar.png" width="20" height="20">
	          </a></div></td>
              </tr>
                 <?php } else {  if ($_SESSION['tipoUsuario']<>'18'){ ?>
              
              </tr>
<?php    } }}
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
       <input type="hidden" name="codProv" />
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