<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/reclamos.php');
require('../modelos/beneficiario.php');
require('../modelos/pago.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(1,2,3,4,5,6,7,13,17,18,22);
	validaAcceso($permitidos,$dir);

  $id_reclamo=$_POST['id_reclamo'];
  $sercarveh=$_POST['sercarveh'];
  $fec=$_POST['fec'];
  $fec2=$_POST['fec2'];
  $codpro=$_POST['codpro'];
  $nombre=$_POST['nombre'];
  $sexo=$_POST['sexo'];
  $descripcion=$_POST['descripcion'];
  $respuesta=$_POST['respuesta'];
 /* $codmar=$_POST['codmar'];
  $desmarveh=$_POST['desmar'];
  $codmodveh=$_POST['codmodveh'];
  $desmod=$_POST['desmod'];
  $codserveh=$_POST['codserveh'];
  $desserveh=$_POST['desserveh'];*/
  $banco= $_POST['banco'];

  $pgActual=$_POST['pagina'];
  $indBusq=$_POST['indBusq'];

 if ($indBusq=='2'){
  $id_reclamo  = null;
  $fec       = null;
  $fec2      = null;
  $codpro    = null;
  $nombre    = null;
}

$objBeneficiario=new beneficiario();
$objReclamo= new reclamos();
$objPago = new pago();

$listarBeneficiario=$objBeneficiario->listarTipo_benef();
$listarBancos=$objPago->listarBancos(3);


if (($_SESSION['tipoUsuario']==4 or $_SESSION['tipoUsuario']==22)){
	$contarReclamos = $objReclamo->listarReclamos($fec,$codpro,-1,$id_reclamo,'',$fec2,$nombre);
}else{
	$contarReclamos = $objReclamo->listarReclamos($fec,$codpro,-1,$id_reclamo,'',$fec2,$nombre,'','','','','','','',$_SESSION['usuario']);
	$contarReclamosAsg = $objReclamo->listarReclamos($fec,$codpro,-1,$id_reclamo,'',$fec2,$nombre,'','','','','','','',$_SESSION['usuario'],1);
}



$nroCampos = 10;
$nroFilas=20;

$contArt =count($contarReclamos)/$nroCampos;

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

if (($_SESSION['tipoUsuario']==4 or $_SESSION['tipoUsuario']==22)){
	$listarReclamos = $objReclamo->listarReclamos($fec,$codpro,$offset,$id_reclamo,'',$fec2,$nombre);
}else{
	$listarReclamos = $objReclamo->listarReclamos($fec,$codpro,$offset,$id_reclamo,'',$fec2,$nombre,'','','','','','','',$_SESSION['usuario']);
}



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
	  	   " = window.open('reportes/xlsListarReclamos.php?idreclamo=<?php echo$id_reclamo;?>&sercarveh=<?php echo$sercarveh;?>&fec=<?php echo$fec;?>&fec2=<?php echo$fec2;?>&codpro=<?php echo$codpro;?>&nombre=<?php echo$nombre;?>&sexo=<?php echo$sexo;?>&descr=<?php echo$descripcion;?>&resp=<?php echo$respuesta;?>&banco=<?php echo$banco;?>
	  	   &id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

}
</script>
  </head>
  <body class="pagina">
   <TABLE class="completo" align="center">
    <TR>
     <TD class="banner" align="center"></TD>
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
           <td  class="categoria">N° Reclamo:</td>
    		<td class="dato"  >
				<input name="id_reclamo" type="text" id="id_reclamo"  value="<?echo $id_reclamo?>" onkeypress="return acessoNumerico(event)"  />
			</td>
          </tr>
          <tr>
          <td valign="top" class="categoria" > Desde: </td>
               <td  class="dato" >
	               <input name="fec" type="text" id="fec"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fec?>" size="10" maxlength="10" readonly="" />
	               <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec',document.forms[0].fec.value)" />
               </td>
               <td class="categoria" > Hasta: </td>
               <td class="dato" >
                   <input name="fec2" type="text" id="fec2"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fec2?>" size="10" maxlength="10" readonly="" />
                   <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec2',document.forms[0].fec2.value)" />
               </td>
          </tr>
           <tr>
           <td  class="categoria">Cod Beneficiario:</td>
              <td class="dato"  >
			<input name="codpro" type="text" id="codpro" value=""   />
		  </td>
           <td  class="categoria">Nombre :</td>
           <td  class="dato">
             <input name="nombre" type="text" id="nombre" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="18" />
          </td>

          </tr>

	<!--	   <tr>

       <td class="categoria">Modelo:</td>
           <td align="left">
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?echo $codmodveh?>" />
             <input name="desmod" type="text" id="modveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $desmod?>" size="15" readonly=""/>

             <input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." />
			</td>

 <td  class="categoria">Marca:</td>
           <td align="left"  class="dato"  >
			<input name="codmar" type="hidden" id="codmar"  value="<?echo $codmar?>" />
	        <input name="desmar" type="text" id="desmar" onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $desmarveh?>" size="15" readonly=""/>
	        <input name="marca"  type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
		  </td>

 <td  class="categoria">Serie:</td>
           <td >
             <input name="codserveh" type="hidden" id="codserveh" value="<?echo$codserveh_?>" />
             <input name="desserveh" type="text" id="serveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $desserveh;?>" readonly=""/>
	         <td align="left">
             <input name="serie" type="button" id="serie" onclick="catalogo('cat_serie.php');" value="..." />
           </td>
	        </tr>
 		  <tr>
           <td  class="categoria">Banco :</td>
           <td  class="dato" colspan="3">
             <SELECT id="banco" name="banco">
				      <option value="<?php if ($banco) echo $banco?>"><?php if ($banco) echo $listarReclamos[14];?></option>
			        <?php for($i=0;$i<count($listarBancos);$i+=2){  ?>
	                   <option value="<?php echo $listarBancos[$i]; ?>"><?php echo $listarBancos[$i+1]?></option>
	                <?php } ?>
	                <option value="">TODOS</option>
			 </SELECT>
          </td>
 	 </tr>-->
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
  <legend>Listado de Reclamos &nbsp; <?php if ($tipo=='E') echo 'Anulados'; ?> &nbsp; <?php echo 'Total Casos: '.$contArt.'- Casos Asignados: '.count($contarReclamosAsg)/$nroCampos?>
  </legend>
    <table width="90%" align="center" class="detalles">
  			<!--<tr>
  				<td colspan="23" align="right">
				    	<a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
			      </td>
             </tr> -->
             <tr>
              <td class="cabecera">N° Reclamo</td>
              <td class="cabecera">Fecha</td>
              <td class="cabecera">Cod. Ben</td>
              <td class="cabecera">Beneficiario</td>
              <td class="cabecera">Tel&eacute;fonos</td>
              <td class="cabecera">Tipo Reclamo</td>
              <td class="cabecera">Fecha Estatus</td>
              <td class="cabecera">Estatus Reclamo</td>
              <td class="cabecera">Usuario Asignado</td>
              <td class="cabecera">B</td>
              <td class="cabecera">I</td>
             </tr>
<?php
        $cont=0;
        for($i=0;$i<count($listarReclamos);$i+=$nroCampos){ $cont++;
          if($listarReclamos[$i]){
             if(!$indC){
                 $color ='datosimpar1';
                 $indC = true;
             }
             else{
                 $color ='datospar1';
                 $indC = false;
             }
?>
          <tr class="<?php echo $color ?>">
          <td align="center"><?php echo str_pad($listarReclamos[$i],5,'0',STR_PAD_LEFT)  ?></td>
          <td><?php  echo $listarReclamos[$i+1]?> </td>
          <td><?php  echo $listarReclamos[$i+2]?> </td>
          <td><?php  echo $listarReclamos[$i+3]?> </td>
          <td><?php  echo $listarReclamos[$i+4]?> </td>
          <td><?php  echo $listarReclamos[$i+5]?> </td>
          <td><?php  echo $listarReclamos[$i+6]?> </td>
          <td><?php  echo $listarReclamos[$i+9]?> </td>
          <td><?php  echo $listarReclamos[$i+8]?> </td>
          <td><div align="center">
               <a class="vinculo" href="tickReclamos.php?id=<?php echo $listarReclamos[$i]?>&cedula=<?php echo $listarReclamos[$i+2]?>&tramite=<?php echo $listarReclamos[$i+7]?>">
	              <img src="botones/buscar.png" width="25" height="25"></a></div></td>
          <td> <a class="vinculo" href="" target="_blank" onClick="popup('reportes/pdf_reclamo_int.php?id=<?php echo $listarReclamos[$i]?>&cedula=<?php echo $listarReclamos[$i+2]?>&tramite=<?php echo $listarReclamos[$i+7]?>');return false;">
	              <img src="botones/printer_48.png" width="20" height="20">
	          </a></td>
          </tr>
<? }
   }?>
   <tr><td colspan=9> <?php echo 'Total: '.$contArt.' Casos Asignados '.count($contarReclamosAsg)/$nroCampos?></td></tr>
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