<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/placas.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,11,17,18,22,23,24,25);
	validaAcceso($permitidos,$dir);

  $placa=$_POST['placa'];
  $estado=$_POST['codestveh'];
  $idsercarveh=$_POST['sercarveh'];
  $numlotveh=$_POST['numlotveh'];
  $codmar=$_POST['codmar'];
  $codmodveh=$_POST['codmodveh'];
  $indBusq=$_POST['indBusq'];
  $sta=$_POST['sta'];

  //echo $codmodveh;

  $pgActual = $_POST['pagina'];

$objPlacas = new placas();

$nroFilas = 15;
$nroCampos = 12;

$contArt = $objPlacas->contarPlacas($idsercarveh,$placa,$estado,$_SESSION['numeDepa'],$numlotveh,$codmar,$codmodveh,$sta);

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

$listPlacas=$objPlacas->listadoPlacasColor($idsercarveh,$placa,$estado,$offset,$_SESSION['numeDepa'],$numlotveh,$codmar,$codmodveh,$sta);


  if ($indBusq=='2'){
  	$placa=null;
    $estado=null;
    $idsercarveh=null;
    $numlotveh=null;
    $codmar=null;
    $codmodveh=null;
  }
?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
    <script>
function enviar(campo){
	window.document.registro.indBusq.value = campo;
	window.document.registro.submit();
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

function exel(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id +
	  	   " = window.open('reportes/xlsListarPlacas.php?idsercarveh=<?php echo $idsercarveh; ?>&marca=<?php echo $codmar; ?>&modelo=<?php echo $codmodveh; ?>&lote=<?php echo $numlotveh; ?>&placa=<?php echo $placa; ?>&estado=<?php echo $estado; ?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

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
           <td  class="categoria">Serial:</td>
           <td>
			<input name="sercarveh" type="text" id="cosercarvehdmar"  value="" />
		  </td>
           <td  class="categoria">Placa :</td>
           <td>
             <input name="placa" type="text" id="placa" value="<?php if($ban==1)  echo $registro['modveh'];?>" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="15" />
          </td>
           <td  class="categoria">Estado:</td>
           <td>
              <input name="codestveh" type="hidden" id="codestveh" size="20"  maxlength="2" value="<?php if($ban==1)  echo $listPlacas[$i+2];?>"  readonly=""/>
         <input name="desestveh" type="text" id="desestveh" size="20"  maxlength="2"  value="<?php if($ban==1)  echo $listPlacas[$i+3];?>"  readonly=""/>
         <input name="estado" type="button" id="estado" onClick="catalogo('cat_estado.php');" value="..." />
           </td>
          </tr>
          <tr> <td  class="categoria">N° Lote :</td>
           <td>
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
           </td></tr>
           <tr>
           <td  class="categoria">Marca:</td>
           <td align="left"  class="dato"  >
			<input name="codmar" type="hidden" id="codmar"  value="<?echo $codmar?>" />
	        <input name="desmar" type="text" id="desmar" onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $desmarveh?>" size="15" readonly=""/>
	        <input name="marca"  type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
		  </td>
            <td class="categoria">Modelo:</td>
           <td align="left">
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?echo $codmodveh?>" />
             <input name="desmod" type="text" id="modveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $desmod?>" size="15" readonly=""/>
             <input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." />
			</td>
		   <td>
			 Todos
		   <input name="sta" id="sta" value=""  <?php if ($sta=='') echo "checked= 'true'"?> type="radio">
		     Activos
		   <input name="sta" id="sta" value="A" type="radio"  <?php if ($sta=='A') echo "checked= 'true'"?> >
		     No PDI
		   <input name="sta" id="sta" value="E" type="radio"  <?php if ($sta=='E') echo "checked= 'true'"?> >
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
  <legend>Listado de  Placas Asignadas:<?php echo $contArt; ?></legend>
  <table width="90%" align="center" class="detalles">

   <tr><td colspan="9" align="right"><a class="vinculo" target="_blank" onClick="abrir('reportes/listPlacas.php?idsercarveh=<?php echo $idsercarveh; ?>&marca=<?php echo $codmar; ?>&modelo=<?php echo $codmodveh; ?>&lote=<?php echo $numlotveh; ?>&placa=<?php echo $placa; ?>&estado=<?php echo $estado; ?>');" />
  <IMG title="PDF" src="botones/pdf.png" height="15" ></a>
  	<a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
 </td></tr>
             <tr>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
              <td class="cabecera">Serial de Carroceria</td>
              <td class="cabecera">Placa</td>
              <td class="cabecera">Color</td>
              <td class="cabecera">Estado</td>
              <td class="cabecera">N&uacute;mero de R&aacute;faga</td>
              <td class="cabecera">Fecha de R&aacute;faga</td>
              <td class="cabecera">N&deg; Secuencia R&aacute;faga:  	 </td>
              <td class="cabecera"> B </td>
             </tr>
<?php
        for($i=0;$i<count($listPlacas);$i+=$nroCampos){
          if($listPlacas[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
?>

              <tr class="<?php echo $color ?>">
               <td><?php  echo $listPlacas[$i+9];?> </td>
               <td><?php echo $listPlacas[$i+10];?></td>
               <td align="center"><?php echo str_pad($listPlacas[$i],3,'0',STR_PAD_LEFT)  ?></td>
               <td><?php  echo $listPlacas[$i+1];?> </td>
                <td><?php echo $listPlacas[$i+11]?></td>
               <td><?php echo $listPlacas[$i+3]?></td>
               <td><?php echo $listPlacas[$i+4]?> </td>
               <td><?php echo $listPlacas[$i+5]?></td>
               <td align="center" ><?php echo $listPlacas[$i+6]?></td>
               <td><div align="center">
               <a class="vinculo" href="reg_placas.php?idsercarveh=<?php echo $listPlacas[$i]?>">
	              <img src="botones/buscar.png" width="25" height="25">
	          </a></div></td>
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