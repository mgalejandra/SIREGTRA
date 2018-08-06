<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/factura.php');
require('../modelos/pago.php');
require('../modelos/zona.php');
require('../modelos/usuarios.php');
require('../modelos/acto.php');
require('../modelos/entrega.php');
require('../modelos/beneficiario.php');
require('../modelos/reportes.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(9,10,26);
	validaAcceso($permitidos,$dir);

$objFactura = new factura();
$objPago = new pago();
$objZona= new zona();
$objUsuario= new usuario();
$objActo= new acto();
$objBeneficiario=new beneficiario();
$objEnt=new entrega();
$objReporte= new reportes();

$listarEstados = $objZona->listarEstados();
$listarBancos=$objPago->listarBancos(3);
$listarUsuario=$objUsuario->buscarUsuario();
$listarEntrega=$objEnt->buscarEntrega();
$listarEstatus=$objFactura->listarEstatus();
$listarBeneficiario=$objBeneficiario->listarTipo_benef();

$nroCampos = 6; //9
$nroFilas = 38;

  $indBusq = $_POST['indBusq'];
  $pgActual = $_POST['pagina'];

  $fecP=$_POST['fecP'];
  $fec2P=$_POST['fec2P'];
  $banco=$_POST['banco'];
  $codpro=$_POST['codpro'];
  $nombre=$_POST['nombre'];

  if ($indBusq=='2'){
	  $fecP=null;
	  $fec2P=null;
	  $banco=null;
	  $codpro=null;
	  $nombre=null;
  }


$contFactura=$objReporte->listaPagospersonas(-1,$_SESSION['idBanco'],$codpro,$nombre,$fecP,$fec2P);
$contArt = count($contFactura)/$nroCampos;
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

$listarFactura=$objReporte->listaPagospersonas($offset,$_SESSION['idBanco'],$codpro,$nombre,$fecP,$fec2P);


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

function enviar(campo){
	window.document.registro.indBusq.value = campo;
	window.document.registro.submit();
}

function abrir(campo)
{
pagina=campo;
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=500,resizable=yes,left=50,top=50");
}

function popup(URL) {
  day = new Date();
  id = day.getTime();
  eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=600,height=600');");
}
function exel(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id +
	  	   " = window.open('reportes/xlsListarPagospersonas.php?banco=<?php echo $_SESSION['idBanco'];?>&codpro=<?php echo $codpro;?>&nombre=<?php echo $nombre;?>&fecP=<?php echo $fecP;?>&fec2P=<?php echo $fec2P;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
}

</script>
  </head>
  <body class="pagina">
   <TABLE class="completo3" align="center">
    <TR>
     <TD class="banner2" align="center"></TD>
    </TR>
    <TR>
     <TD >
      <DIV class="menu2">
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
           <td  class="categoria">Cod Beneficiario:</td>
              <td class="dato"  >
			<input name="codpro" type="text" id="codpro"  value="" />
		  </td>
           <td  class="categoria">Nombre:</td>
           <td  class="dato">
             <input name="nombre" type="text" id="nombre" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="18" />
          </td>
          </tr>
          <tr>
          	   <td valign="top" class="categoria" >Fecha de Registro Desde: </td>
               <td  class="dato" >
	               <input name="fecP" type="text" id="fecP"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fecP?>" size="10" maxlength="10" readonly="" />
	               <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecP',document.forms[0].fecP.value)" />
               </td>
               <td class="categoria">Hasta: </td>
               <td class="dato" >
                   <input name="fec2P" type="text" id="fec2P"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fec2P?>" size="10" maxlength="10" readonly="" />
                   <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec2P',document.forms[0].fec2P.value)" />
               </td>
          </tr>
          <tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden"  name="indBusq">
		    <INPUT type="hidden"  name="indReg" >
		    <INPUT type="hidden"  name="idUsu" >
           </td>
          </tr>
  </table>
   </fieldset>

 <fieldset class="form">
  <legend>Listado de Factura &nbsp; <?php if ($tipo=='E') echo 'Anulados'; ?> &nbsp; <?php echo 'Total: '.$contArt?>
  </legend>
    <table width="90%" align="center" class="detalles">
  			<tr>
  				<td colspan="22" align="right">Imprimir todos los resultados de la consulta
			  	<!--		<a class="vinculo" target="_blank" onClick="abrir('reportes/ciclopdffacturapreinv.php');" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			             	</a> -->
				    	<a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
			      </td>
             </tr>

        <?php
        if (($fecP) or ($fec2P)){
        ?>
             <TR>
             <td class="cabeceraI"  width="1%" colspan=6>
             <?php  if (($fecP) and !($fec2P)){echo 'Desde: '.$fecP;}?>
             <?php  if (($fecP) and ($fec2P)){echo 'Desde: '.$fecP.' Hasta:'.$fec2P;}?>
             <?php  if (!($fecP) and !($fec2P)){echo 'Hasta: '.$fec2P;}?>
             </td>
             </TR>
        <?php
        }
        ?>
             <tr>
             <td class="cabecera"  width="1%">N°</td>
              <td class="cabecera" width="20%">Nombre Completo</td>
              <td class="cabecera" width="5%">Cedula</td>
              <td class="cabecera" width="2%">Monto</td>
              <td class="cabecera" width="9%">Modelo</td>
              <td class="cabecera" width="15%">Banco</td>
             </tr>
<?php

     $k = $nroFilas*($pgActual-1)+1;
     $iaux1 = $nroFilas*$nroCampos;
     $iaux2 = count($listarFactura);

     $imax = ($iaux1<$iaux2)?$iaux1:$iaux2;

    	for($i=0;$i<$imax;$i+=$nroCampos){
               	$color = (!$indC)?'datospar':'datosimpar1';
               	$indC = !$indC;
               	$p = $i/$nroCampos + $k;


?>

              <tr class="<?php echo $color ?>">
              <td align="center"><font size="1"><?php  echo $p;?></font></td>
               <td><?php  echo $listarFactura[$i+1];?> </td>
               <td align="center" ><?php echo $listarFactura[$i+2]?></td>
               <td align="right" ><?php echo $listarFactura[$i+3]?></td>
               <td align="center" ><?php echo $listarFactura[$i+4]?></td>
               <td align="center" ><?php echo $listarFactura[$i+5]?></td>

			</tr>


<?php
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