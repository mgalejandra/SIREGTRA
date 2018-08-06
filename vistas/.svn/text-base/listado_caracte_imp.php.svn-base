<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/caracteristicas.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,11,18,22,23,24);
	validaAcceso($permitidos,$dir);

  $codmar	= $_POST['codmar'];
  $modveh	= $_POST['codmodveh'];
  $serveh	= $_POST['codserveh'];
  $pgActual = $_POST['pagina'];
  $lote		= $_POST['numlotveh'];
  $factura	= $_POST['factura'];
  $planilla	= $_POST['planilla'];
  $numCaract = $_POST['numCaract'];

$objCaract = new caracteristicas();

$nroFilas = 15;
$nroCampos = 37;
$cantReg = $objCaract->ContCaracteristicasImpo($numCaract,$codmar,$modveh,$serveh,$lote,$factura,$planilla,$_SESSION['numeDepa']);

$cantPaginas = ceil($cantReg/($nroFilas));
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

$listCarac=$objCaract->listarCaracteristicasImpo($numCaract,$codmar,$modveh,$serveh,$lote,$factura,$planilla,$offset,$_SESSION['numeDepa']);
?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
   <script>

function enviar(dato){
 if(dato==2){
	window.document.registro.codmar.value = null;
	window.document.registro.desmar.value = null;
	window.document.registro.codmodveh.value = null;
	window.document.registro.modveh.value = null;
	window.document.registro.codserveh.value = null;
	window.document.registro.serveh.value = null;
	window.document.registro.numlotveh.value = null;
	window.document.registro.factura.value = null;
	window.document.registro.planilla.value = null;
	window.document.registro.numCaract.value = null;
 }
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
  <legend>Criterios de Busqueda</legend>
     <table  align="center" border="0">
          <tr>
           <td  class="categoria">Marca:</td>
           <td>
			<input name="codmar" type="hidden" id="codmar"  value="<?php if($ban==1)  echo $registro['codmarveh'];?>" />
	        <input name="desmar" type="text" id="desmar"  value="<?php if($ban==1)  echo $objMarca->buscarMarca($registro['codmarveh']);?>"  readonly=""/>
	        <input name="marca" type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
		  </td>
           <td  class="categoria">Modelo:</td>
           <td>
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?php if($ban==1)  echo $registro['codmodveh'];?>" />
             <input name="modveh" type="text" id="modveh" value="<?php if($ban==1)  echo $registro['modveh'];?>" size="20" maxlength="15" readonly=""/>
             <input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." />
          </td>
           <td  class="categoria">Serie:</td>
           <td>
             <input name="codserveh" type="hidden" id="codserveh" value="<?php if($ban==1)  echo $registro['codserveh'];?>" />
             <input name="serveh" type="text" id="serveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $registro['serveh'];?>" readonly=""/>
             <input name="serie" type="button" id="serie" onclick="catalogo('cat_serie.php');" value="..." />
           </td>
          </tr>
        <tr>
          <td class="categoria">N°&nbsp;Lote:</td>
        <td class="dato">
           <input name="numlotveh" type="text" id="numlotveh" value="<?=$lote?>" size="8" maxlength="3"/>
           <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
        </td>
           <td  class="categoria">Factura:</td>
           <td  class="dato">
            <input name="factura" type="text" id="factura"  value="<?=$factura?>" />
          </td>
           <td  class="categoria">Planilla:</td>
           <td  class="dato">
           <input name="planilla" type="text" id="planilla"  value="<?=$planilla?>" />
           </td>
          </tr>
        <tr>
           <td  class="categoria" >N°&nbsp;Caract.:</td>
           <td  class="dato" colspan='5'>
           <input size="8" name="numCaract" type="text" id="numCaract" value="<?=$numCaract?>" />
           </td>
          </tr>
          <tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden" name="indReg" >
		    <INPUT type="hidden" name="idUsu" >
           </td>
          </tr>
  </table>
   </fieldset>
<br/>
 <fieldset class="form">
  <legend>Lista de Caracter&iacute;sticas Veh&iacute;culos Importados:  <?php echo $cantReg; ?></legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">N° Caracter&iacute;stica</td>
              <td class="cabecera">Lote</td>
               <td class="cabecera">Factura</td>
              <td class="cabecera">Planilla</td>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
              <td class="cabecera">tipo</td>
              <td class="cabecera">Serie</td>
              <td class="cabecera">Precio</td>
              <td class="cabecera">A&ntilde;o Modelo</td>
              <td class="cabecera"> B </td>
             </tr>
<?php
        for($i=0;$i<count($listCarac);$i+=37){
          if($listCarac[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !indC;
?>

              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo str_pad($listCarac[$i],3,'0',STR_PAD_LEFT)  ?></td>
               <td><?php echo $listCarac[$i+1];?> </td>
               <td align="center"> <?php echo $listCarac[$i+34]?></td>
               <td align="center"><?php echo $listCarac[$i+36]?></td>
               <td align="center"><?php echo $listCarac[$i+2]?></td>
               <td align="center"><?php echo $listCarac[$i+3]?></td>
               <td align="center"><?php echo $listCarac[$i+28]?> </td>
               <td><?php echo $listCarac[$i+4]?></td>
               <td align="right"><?php echo FormatoMonto($listCarac[$i+15])?>&nbsp;</td>
               <td align="center" ><?php echo $listCarac[$i+5]?></td>
               <td><div align="center">
               <a class="vinculo" href="caracteristica_veh_imp.php?idcaract=<?php echo $listCarac[$i]?>">
	              <img src="botones/buscar.png" width="20" height="20">
	          </a></div></td>
              </tr>
<?php     }
        }
?>
  <tr><td class="categoria"> <?php echo 'Total: '.$cantReg?></td></tr>
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