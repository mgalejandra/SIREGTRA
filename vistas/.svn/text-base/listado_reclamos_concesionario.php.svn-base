<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/reclamos.php');
require('../modelos/beneficiario.php');
require('../modelos/pago.php');
require('../modelos/concesionario.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(1,2,3,4,5,19);
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

  $pgActual=$_POST['pagina'];
  $indBusq=$_POST['indBusq'];

 if ($indBusq=='2'){
  $id_reclamo  = null;
  $sercarveh = null;
  $fec       = null;
  $fec2      = null;
  $codpro    = null;
  $nombre    = null;
  $sexo      = null;
  $descripcion=null;
  $respuesta = null;
  $codmar    = null;
  $desmarveh = null;
  $codmodveh = null;
  $desmod    = null;
  $codserveh = null;
  $desserveh = null;
  $banco     = null;
}

$objBeneficiario=new beneficiario();
$objReclamo= new reclamos();
$objPago = new pago();
$objConcesionario= new concesionario();

$listarBeneficiario=$objBeneficiario->listarTipo_benef();
$listarBancos=$objPago->listarBancos(3);
$buscarUsuarioConc=$objConcesionario->buscarUsuarioConc('',$_SESSION['usuario']);
$_SESSION['id_concesionario']=$buscarUsuarioConc[9];

$contarReclamos = $objConcesionario->listarReclamosConc($_SESSION['id_concesionario'],$fec,$codpro,-1,$id_reclamo,$sercarveh,$fec2,$nombre,$sexo,$descripcion,$codmar,$codmodveh,$codserveh,$respuesta);

$nroCampos = 18;
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

$listarReclamos = $objConcesionario->listarReclamosConc($_SESSION['id_concesionario'],$fec,$codpro,$offset,$id_reclamo,$sercarveh,$fec2,$nombre,$sexo,$descripcion,$codmar,$codmodveh,$codserveh,$respuesta);

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
	  	   " = window.open('reportes/xlsListarReclamosConce.php?idreclamo=<?php echo$id_reclamo;?>&sercarveh=<?php echo$sercarveh;?>&fec=<?php echo$fec;?>&fec2=<?php echo$fec2;?>&codpro=<?php echo$codpro;?>&nombre=<?php echo$nombre;?>&sexo=<?php echo$sexo;?>&descr=<?php echo$descripcion;?>&resp=<?php echo$respuesta;?>&banco=<?php echo$banco;?>
	  	   &id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

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
           <td  class="categoria">N° Reclamo:</td>
    <td class="dato"  >
			<input name="id_reclamo" type="text" id="id_reclamo"  value="<?echo $id_reclamo?>" onkeypress="return acessoNumerico(event)"  />

           <td  class="categoria">serial C. :</td>
              <td class="dato"  >
             <input name="sercarveh" type="text" id="sercarveh" value="<?echo $sercarveh?>" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="18" />
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
          <td  class="categoria">Sexo:</td>
	        <td class="dato">
	        <select name="sexo"  id="sexo">
                <option value="<?php if ($sexo) echo $sexo ?>"><?php if ($sexo) echo  $listarFactura[19] ?></option>
                <option value="F">Femenino</option>
                <option value="M">Masculino</option>
          </select>
	        </td>
          </tr>
          <tr>
           <td  class="categoria">Descripci&oacute;n:</td>
           <td class="dato" colspan="3"><input name="descripcion" type="text" id="descripcion" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php echo $descripcion?>" size="50" maxlength="40" /></td>
          </tr>
          <tr>
           <td  class="categoria">Respuesta:</td>
           <td class="dato" colspan="3"><input name="respuesta" type="text" id="respuesta" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php echo $respuesta?>" size="50" maxlength="40" /></td>
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
  <legend>Listado de Reclamos &nbsp; <?php if ($tipo=='E') echo 'Anulados'; ?> &nbsp; <?php echo 'Total: '.$contArt?>
  </legend>
    <table width="90%" align="center" class="detalles">
  			<tr>
  				<td colspan="23" align="right">
				    	<a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
			      </td>
             </tr>
             <tr>
              <td class="cabecera">N° Reclamo</td>
              <td class="cabecera">Fecha</td>
              <td class="cabecera">Cod. Ben</td>
              <td class="cabecera">Beneficiario</td>
              <td class="cabecera">Tel&eacute;fonos</td>
              <td class="cabecera">Tipo Reclamo</td>
              <td class="cabecera">Serial Carr.</td>
              <td class="cabecera">Descripci&oacute;n</td>
              <td class="cabecera">Respuesta</td>
              <td class="cabecera">Fecha mod.</td>
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
          <td><?php  echo $listarReclamos[$i+6]?> </td>
          <td><?php  echo $listarReclamos[$i+1]?> </td>
          <td><?php  echo $listarReclamos[$i+14]?> </td>
          <td><?php  echo $listarReclamos[$i+11]." ".$listarReclamos[$i+12]?> </td>
          <td><?php  $tipoR = $objConcesionario->listarTipoRC($listarReclamos[$i+7]); echo $tipoR[1]; ?> </td>
          <td><?php  echo $listarReclamos[$i+8]?> </td>
          <td><?php if(strlen($listarReclamos[$i+9])>50)echo  substr($listarReclamos[$i+9],0,50).'...';
		       		else echo $listarReclamos[$i+9]; ?> </td>
          <td><?php if(strlen($listarReclamos[$i+10])>30)echo  substr($listarReclamos[$i+10],0,30).'...';
		       		else echo $listarReclamos[$i+10]; ?> </td>
          <td><?php  echo $listarReclamos[$i+16]?> </td>
          <td><div align="center">
               <a class="vinculo" href="reg_reclamosC.php?idreclamo=<?php echo $listarReclamos[$i]?>">
	              <img src="botones/buscar.png" width="25" height="25"></a></div></td>
          <td> <a class="vinculo" href="" target="_blank" onClick="popup('reportes/pdf_reclamoC.php?idreclamo=<?php echo $listarReclamos[$i]?>');return false;">
	              <img src="botones/printer_48.png" width="20" height="20">
	          </a></td>
          </tr>
<? }
   }?>
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