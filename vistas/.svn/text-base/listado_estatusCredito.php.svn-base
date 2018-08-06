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
require('../modelos/banco.php');
require('../modelos/estatus.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(1,2,3,4,5,6,7,11,15,16,17,18,22,25,26);
	validaAcceso($permitidos,$dir);

  $banco=$_POST['banco'];
  $estatus=$_POST['estatus'];
  $codpro=$_POST['codpro'];
  $pgActual = $_POST['pagina'];
  $indBusq =  $_POST['indBusq'];
  $fechaD=$_POST['fechad'];
  $fechaH=$_POST['fechah'];
  $tipo=$_POST['tipo'];

//echo "Cond: ".$cond;

$objFactura = new factura();
$objPago = new pago();
$objZona= new zona();
$objUsuario= new usuario();
$objActo= new acto();
$objBeneficiario=new beneficiario();
$objEnt=new entrega();
$objReporte= new reportes();
$objBanco = new banco();
$objEstatus = new estatus();

$listarEstados = $objZona->listarEstados();

$listarBancos=$objPago->listarBancos(3);

$listarEstatus=$objFactura->listarEstatus();

if ($tipo=='A') $nroCampos = 17;
 else
$nroCampos = 10;

$nroFilas = 15;

  if ($indBusq=='2'){
	$banco=null;
  	$estatus=null;
  	$codpro=null;
  	$fechaD=null;
    $fechaH=null;
  }

$contCredito=$objBeneficiario->listarEstatusCredito($banco,$estatus,$codpro,$fechaD,$fechaH,-1,$tipo);
//echo "Cuento: ".$contFactura[0];

$contArt = count($contCredito)/$nroCampos;

//echo "Divido: ".$contArt;

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

$listarCredito=$objBeneficiario->listarEstatusCredito($banco,$estatus,$codpro,$fechaD,$fechaH,$offset,$tipo,null);

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

function abrir1(campo)
{
pagina=campo;
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=no,width=350,height=200,resizable=no,left=200,top=200");
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
	  	   " = window.open('reportes/xlsListarEstatusCredito.php?banco=<?php echo$banco;?>&estatus=<?php echo$estatus;?>&codpro=<?php echo$codpro;?>&fechaD=<?php echo$fechaD;?>&fechaH=<?php echo $fechaH;?>&tipo=<?php echo $tipo;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

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
           <td  class="categoria">cod Beneficiario:</td>
              <td class="dato">
			<input name="codpro" type="text" id="codpro" value=""   />
		  </td> </tr>
	 <tr>
          <td rowspan="2" class="categoria">Fecha Estatus:</td>
          <td align="left"><font size="1">Desde: (dd/mm/aaaa)</font></td>
		  <td align="left" colspan="2"><font size="1">Hasta: (dd/mm/aaaa)</font></td>
		  </tr>
		  <tr>
          <td  class="dato" >
	      <input name="fechad" type="text" id="fechad"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php echo $fechaD;?>" size="10" maxlength="10" readonly="" />
	      <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fechad',document.forms[0].fechad.value)" />
          </td>
          <td class="dato" colspan="2" >
          <input name="fechah" type="text" id="fechah"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php echo $fechaH;?>" size="10" maxlength="10" readonly="" />
          <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fechah',document.forms[0].fechah.value)" />
          </td></tr>
     <tr>
     	<td  class="categoria">Banco:</td>
           <td  class="dato" colspan="3">
             <SELECT id="banco" name="banco">
				      <option value=""></option>
			        <?php for($i=0;$i<count($listarBancos);$i+=2){  ?>
	                   <option value="<?php echo $listarBancos[$i]; ?>"><?php echo $listarBancos[$i+1]?></option>
	                <?php } ?>
	                <option value="">TODOS</option>
			 </SELECT>
          </td>
</tr>
          <tr>
           <td  class="categoria">Estatus:</td>
	        <td class="dato" colspan="3" >
          <select name="estatus"  id="estatus">
                <option value="<?php if ($cond) echo $cond ?>"><?php if ($cond) echo $cond ?></option>
                <option value="3">A LA ESPERA DE DOCUMENTOS</option>
                <option value="2">CREDITO EN ANALISIS BANCARIO</option>
                <option value="4">CREDITO APROBADO</option>
                <option value="17">CREDITO DIFERIDO</option>
                <option value="16">CREDITO NEGADO</option>
                <option value="30">DEVUELTO POR DOCUMENTACION INCOMPLETA</option>
                <option value="31">IMPOSIBLE VERIFICAR CONSTANCIA</option>
                <option value="32">DEVUELTO POR CAMBIO DE GARANTIA</option>
          </select>
        </td>
        <td >   Todos
		        <input type="radio" name="tipo" id="tipo"  value="T" <?php if ($tipo=='T' or $tipo=='')echo "checked= 'true'"; ?> />
		        Asignados
		        <input type="radio" name="tipo" id="tipo"  value="A" <?php if ($tipo=='A')echo "checked= 'true'"; ?>/>
		        Sin ejecutar
		        <input type="radio" name="tipo" id="tipo"  value="S" <?php if ($tipo=='S')echo "checked= 'true'"; ?>/>
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
  			<!--	<td colspan="22" align="right">Imprimir todos los resultados de la consulta
			  			<a class="vinculo" target="_blank" onClick="abrir('reportes/ciclopdffacturapreinv.php');" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			             	</a>-->
				    	<a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
			      </td>
             </tr>
             <tr>
             <td  class="cabecera" colspan="5">Datos del Credito</td>
             <td  class="cabecera" colspan="2">Creación</td>
             <td  class="cabecera" colspan="2">Modificación</td>
             <td  class="cabecera">Monto</td>
              <?php if ($tipo=='A'){ ?>
             <td  class="cabecera" colspan="7">Datos de Asignación de Vehiculo</td>
               <?php } ?>
             <!-- <td  class="cabecera" colspan="2">Modificar</td>-->
             </tr>
             <tr>
             <td class="cabecera"  width="1%">N°</td>
             <td class="cabecera" width="8%">RIF</td>
              <td class="cabecera" width="20%">Nombre Completo</td>
              <td class="cabecera" width="8%">Banco</td>
              <td class="cabecera" width="8%">Estatus</td>
              <td class="cabecera" width="10%">Usuario</td>
              <td class="cabecera" width="5%">Fecha</td>
              <td class="cabecera" width="10%">Usuario</td>
              <td class="cabecera" width="5%">Fecha</td>
              <td class="cabecera" width="5%">Monto</td>

                <?php if ($tipo=='A'){ ?>
                <td class="cabecera" width="3%">Serial</td>
                <td class="cabecera" width="3%">Marca</td>
				<td class="cabecera" width="3%">Modelo</td>
				<td class="cabecera" width="3%">Banco</td>
				<td class="cabecera" width="3%">estatus</td>
				<td class="cabecera" width="3%">lote</td>
				<td class="cabecera" width="3%">placa</td>
                <?php } ?>
              <!-- <td class="cabecera" width="3%">Mod. Estatus</td>
              <td class="cabecera" width="3%">Mod. Monto</td>-->
             </tr>
<?php

     $k = $nroFilas*($pgActual-1)+1;
     $iaux1 = $nroFilas*$nroCampos;
     $iaux2 = count($listarCredito);

     $imax = ($iaux1<$iaux2)?$iaux1:$iaux2;

    	for($i=0;$i<$imax;$i+=$nroCampos){
               	$color = (!$indC)?'datospar':'datosimpar1';
               	$indC = !$indC;
               	$p = $i/$nroCampos + $k;


             /*  	$nombBeneficiario=$objBeneficiario->listarBeneficiario($listarCredito[$i+1]);
               	$nombBanco=$objBanco->listarBancos($listarCredito[$i+2]);
               	$nombEstatus=$objEstatus->listarEstatus($listarCredito[$i+3]);*/


?>

               <tr class="<?php echo $color ?>">
               <td align="center"><?php  echo $p;?></font></td>
               <td align="center" ><?php echo $listarCredito[$i+1]?></td>
               <td><?php  echo $listarCredito[$i+8];?> </td>
               <td align="right" ><?php echo $listarCredito[$i+2]; ?></td>
               <td align="center" ><?php echo $listarCredito[$i+3]?></td>
               <td align="center" ><?php echo $listarCredito[$i+4]?></td>
               <td align="center" ><?php echo $listarCredito[$i+5]?></td>
               <td align="center" ><?php echo $listarCredito[$i+7]?></td>
               <td align="center" ><?php echo $listarCredito[$i+9]?></td>
               <td align="center" ><?php echo $listarCredito[$i+6]?></td>
                               <?php if ($tipo=='A'){ ?>
               <td align="center" ><?php echo $listarCredito[$i+10]?></td>
               <td align="center" ><?php echo $listarCredito[$i+11]?></td>
               <td align="center" ><?php echo $listarCredito[$i+12]?></td>
               <td align="center" ><?php echo $listarCredito[$i+13]?></td>
               <td align="center" ><?php echo $listarCredito[$i+14]?></td>
               <td align="center" ><?php echo $listarCredito[$i+15]?></td>
               <td align="center" ><?php echo $listarCredito[$i+16]?></td>
                <?php } ?>
			 <!--   <td><div align="center"><img src="imagenes/refresh.png" width="30" height="30" onclick="abrir1('mod_estatus_credito.php?rif=<? echo $listarCredito[$i+1]; ?>')"></div></td>
			   <td><div align="center"><img src="imagenes/bsf.png" width="30" height="30" onclick="abrir1('mod_monto_credito.php?rif=<? echo $listarCredito[$i+1]; ?>')"></div></td>
			</tr>-->


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
       <input type="hidden" name="idInv" id="idInv"/>
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