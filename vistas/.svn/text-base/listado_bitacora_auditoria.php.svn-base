<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/auditoria.php');
require('../modelos/usuarios.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,19);
	validaAcceso($permitidos,$dir);

$objBitacora = new auditoria();
$objUsuario= new usuario();

$listarUsuario=$objUsuario->buscarUsuario();

 $indBusq  = $_POST['indBusq'];
 $pgActual = $_POST['pagina'];

 $sercarveh = $_POST['sercarveh'];
 $codpro	= $_POST['codpro'];
 $accion	= $_POST['accion'];
 $sentencia	= $_POST['sentencia'];
 $usuario = $_POST['usuario'];
 $fecE = $_POST['fecE'];
 $fecE2 = $_POST['fecE2'];
 $formulario= $_POST['formulario'];

/* if ($_POST['fecE']) $fecE = $_POST['fecE'];
 else $fecE=date('d/m/Y');

 if ($_POST['fecE2']) $fecE2 = $_POST['fecE2'];
 else $fecE2=date('d/m/Y');*/

if($indBusq==2){
 $sercarveh = null;
 $codpro	= null;
 $accion	= null;
 $sentencia	= null;
 $usuario = null;
 $fecE = null;
 $fecE2 = null;
 /*$fecE = date('d/m/Y');
 $fecE2 = date('d/m/Y');*/
}

$nroFilas = 40;
$nroCampos = 9;

$cantReg=$objBitacora->contarAuditoriaBeneficiario($codpro,$sercarveh,$accion,$sentencia,$usuario,$fecE,$fecE2,$formulario);
//$cantReg=$cantReg[0]/$nroCampos;
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

$listarAuditoria=$objBitacora->listarAuditoriaBeneficiario($codpro,$sercarveh,$accion,$sentencia,$usuario,$fecE,$fecE2,$formulario,$offset);

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

function abrir(campo)
{
pagina=campo;
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=500,resizable=yes,left=50,top=50");
}

function enviar(dato){
	document.registro.pagina.value = 0;
	document.registro.indBusq.value = dato;
}


function exel(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id +
	  	   " = window.open('reportes/xlsListadoBitacAudit.php?sercarveh=<? echo $sercarveh; ?>&usuario=<? echo $usuario;?>&codpro=<? echo $codpro; ?>&fecE=<? echo$fecE;?>&fecE2=<? echo$fecE2;?>&accion=<? echo$accion;?>&sentencia=<? echo$sentencia;?>
&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

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
     <table  align="center" >
        <tr>
		   <td  class="categoria">CI/RIF:</td>
           <td align="left">
             <input name="codpro" type="text" id="codpro" value="<?php echo $codpro?>" onblur="javascript:this.value=this.value.toUpperCase()" size="10" maxlength="10" />&nbsp;&nbsp;
          </td>
           <td class="categoria">Sentencia:</td>
           <td>
              <input name="sentencia" type="text" id="sentencia" value="<?php echo $sentencia?>" size="20" width="60" maxlength="120"/>
           </td></tr>
           <tr><td class="categoria">Acci&oacute;n:</td>
           <td>
           <input name="accion" type="text" id="accion" value="<?php echo $accion?>" onblur="javascript:this.value=this.value.toUpperCase()" size="20" width="60" maxlength="120"/>
           </td>
           <td valign="top" class="categoria" >Fecha: </td>
               <td  class="dato" >
	               <input name="fecE" type="text" id="fecE"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fecE?>" size="10" maxlength="10" readonly="" />
	               <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecE',document.forms[0].fecE.value)" />
               </td>
           </tr>
          <tr> <td  class="categoria">&nbsp;Serial:</td>
           <td>
			<input name="sercarveh" type="text" id="sercarveh"  value="<?php echo $sercarveh?>" />&nbsp;&nbsp;
		  </td>
           <td  class="categoria">Usuario:
	        </td>
	         <td class="dato">
		        <SELECT id="usuario" name="usuario">
				<option value="<?php if ($usuario) echo $usuario?>"><?php if ($usuario) echo $listarAuditoria[3]." ".$listarAuditoria[1];?></option>
			    <?php for($i=0;$i<count($listarUsuario);$i+=15){  ?>
	               <option value="<?php echo $listarUsuario[$i]; ?>"><?php echo $listarUsuario[$i+3].' '.$listarUsuario[$i+1]; ?></option>
	           <?php } ?>
	           <option value="">TODAS</option>
			 </SELECT>
	        </td>
	       </tr>
	       <tr> <tr> <td  class="categoria">Formulario:</td>
           <td>
			<input name="formulario" type="text" id="formulario"  value="<?php echo $formulario?>" />&nbsp;&nbsp;
		  </td></tr>
		  <!-- <tr>
		  <td rowspan="2" class="categoria">Fecha:</td>
		  <td align="left"><font size="1">Desde: (dd/mm/aaaa)</font></td>
		  <td align="left" colspan="2"><font size="1">Hasta: (dd/mm/aaaa)</font></td>
		  </tr>
		  <tr>
		  <td  class="dato" >
	      <input name="fecE" type="text" id="fecE"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fecE?>" size="10" maxlength="10" readonly="" />
	      <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecE',document.forms[0].fecE.value)" />
          </td>
     	  <td class="dato" colspan="2" >
          <input name="fecE2" type="text" id="fecE2"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fecE2?>" size="10" maxlength="10" readonly="" />
          <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecE2',document.forms[0].fecE2.value)" />
            </tr>-->
            <td align="center" colspan="8">
            <input type="submit" value="Buscar" onclick="enviar('1')"/>
            <input type="submit" value="Limpiar" onclick="enviar('2')"/>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden" name="indReg" >
		    <INPUT type="hidden" name="idUsu" >
           </td>
          </tr>
  </table>
   </fieldset>

 <fieldset class="form">
  <legend>&nbsp;Bitacora <?php echo ' Total: '.$cantReg?>
  </legend>
    <table width="90%" align="center" class="detalles">
      <tr>
      <td colspan="13" align="right">
      <a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
 </td></tr>
           <tr>
              <td class="cabecera">N°</td>
              <td class="cabecera">Usuario</td>
              <td class="cabecera">Nombre</td>
              <td class="cabecera">Fecha/Hora</td>
              <td class="cabecera">Accion</td>
              <td class="cabecera">Sentencia</td>
              <td class="cabecera">Formulario</td>
             </tr>

<?php
       for($i=0;$i<count($listarAuditoria);$i+=$nroCampos){
          if($listarAuditoria[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
             $nreg = $offset+$i/$nroCampos+1;

             $nombreC1=$listarAuditoria[$i+1]." ".$listarAuditoria[$i+2]." ".$listarAuditoria[$i+3]." ".$listarAuditoria[$i+4];
?>

              <tr class="<?php echo $color ?>">
               <td align="center"><?echo $nreg?></td>
               <td><?php echo $listarAuditoria[$i]; ?></td>
               <td><?php echo $nombreC1?></td>
               <td><?php echo $listarAuditoria[$i+5];?></td>
               <td><?php echo $listarAuditoria[$i+6];?></td>
               <td><?php echo $listarAuditoria[$i+7];?></td>
               <td><?php echo $listarAuditoria[$i+8]." ".$listarAuditoria[$i+9];?></td>
              </tr>
<?php     }
        }
?>
  <tr><td class="categoria"> </td></tr>
    </table>
 </fieldset>

<BR>
 <div align="center">
       <?php if($pgActual>1){?>
         <img src="imagenes/atras.png" width="20" height="15" class="vinculo" onclick="regresaPg()">
       <?php }
         for($j=$pgIni;$j<=$pgFin;$j++){
             $claseVinc = ($pgActual==$j)?'vinculoAzul':'vinculo';
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

       <br/>
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