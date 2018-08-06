<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/citas.php');
require('../modelos/usuarios.php');
require('../modelos/correo.php');

$objCorreo = new correo();

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,4,11,16,22,25);
	validaAcceso($permitidos,$dir);

  $rif=$_POST['rif'];
  $nombre=$_POST['nombre'];
  $fec=$_POST['fec'];
  $fec2=$_POST['fec2'];
  $usuario=$_POST['usuario'];
  $usuario1 = $_POST['usu'];
 // echo "Usuario 1: ".$usuario1;
  $pgActual = $_POST['pagina'];
  $indBusq=$_POST['indBusq'];
  $inicio = $_POST['reg'];
  $correo = $_POST['correo'];
  $tipo = $_POST['tipo'];



//echo "<br>Inicio: ".$inicio;

if ($indBusq=='2'){
  $rif=NULL;
  $nombre=NULL;
  $banco=NULL;
  $fec=NULL;
  $fec2 =NULL;
  $indBusq=NULL;
  $usuario=null;
  $usuario1=null;
  $inicio=null;
  $correo=null;
}
$objBeneficiarioCit = new citas();
$objUsuario = new usuario();


$nroFilas = 20;
$nroCampos = 14;

$contArt = $objBeneficiarioCit->buscarBenefCitas($rif,$nombre,$fec,$usuario,-1,$correo,$fec2,$tipo);
//$_SESSION['listarCitaBenef']=$contArt;

$cuentaP = count($contArt)/$nroCampos;
//echo "Filas: ".$nroFilas;

$cantPaginas = ceil($cuentaP/($nroFilas));

//echo "<br>Paginas".$cantPaginas;

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

//echo "<br>Off: ".$offset;

$listaBen=$objBeneficiarioCit->buscarBenefCitas($rif,$nombre,$fec,$usuario,$offset,$correo,$fec2,$tipo);


//Recuperar clave

if($inicio==2){
    //echo "<br>Usuario aaaaa: ".$usuario1;
	$claves = array_flip(array_merge(range('a','z'),range('A','Z'),range(0,9)));
	$password = implode("",array_rand($claves, 6));
	$dclaveUsu = $objUsuario->clave($usuario1,$password);
	if ($dclaveUsu){
		$datosBen = $objUsuario->buscarUsuarioP($usuario1);
		$correo = $datosBen[6];
      	$dcorreoUsu = $objCorreo->correoClave($usuario1,$password,$correo);
	}
	echo '<SCRIPT>alert("La clave fue cambiada y enviada al correo del beneficiario");</SCRIPT>';
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
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=1000,height=500,resizable=yes,left=50,top=50");
}

function abrir1(campo)
{
pagina=campo;
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=no,width=300,height=150,resizable=no,left=100,top=100");
}

function popup(URL) {
  day = new Date();
  id = day.getTime();
  eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=600,height=600');");
}

function popup_c(URL) {
  day = new Date();
  id = day.getTime();
  eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=850,height=400');");
}

function exel(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id +
	  	   " = window.open('reportes/xlsListarBeneficiariosCitasSol.php?rif=<?php echo$rif;?>&nombre=<?php echo$nombre;?>&fec=<?php echo$fec;?>&usuario=<? echo$usuario;?>&correo=<? echo$correo; ?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

}

function reiniciar(dato){
    document.registro.reg.value = 2;
    document.registro.usu.value = dato;
    window.document.registro.submit();
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
     <table  align="center" border='0'>
		    <tr>
           <td  class="categoria">CI/RIF:</td>
           <td align="left">
			<input name="rif" type="text"  id="rif"  onblur="javascript:this.value=this.value.toUpperCase()" value="" maxlength="9" />
		  </td>
           <td  class="categoria">Nombre :</td>
           <td>
             <input name="nombre" type="text" id="nombre" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="15" />
          </td>
             </tr>
           <tr>
           <td valign="top" class="categoria">Fecha Reg. Cita: </td>
               <td  class="dato" >
	               <input name="fec" type="text" id="fec"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fec?>" size="10" maxlength="10" readonly="" />
	               <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec',document.forms[0].fec.value)" />
               </td>
               <td class="categoria" >Usuario:</td>
               <td class="dato" >
                   <input name="usuario" type="text" id="usuario"  value="" size="10" />
               </td>
               <td class="categoria" >Correo:</td>
               <td class="dato" >
                   <input name="correo" type="text" id="correo"  value="" size="20" />
               </td>
          </tr>
           <tr>
           <td valign="top" class="categoria">Fecha Reg. Benef: </td>
               <td  class="dato" >
	               <input name="fec2" type="text" id="fec2"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fec2 ?>" size="10" maxlength="10" readonly="" />
	               <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec2',document.forms[0].fec2.value)" />
               </td>
               <td class="categoria" >Tipo:</td>
               <td class="dato" >
                       <select name="tipo"  id="tipo">
                            <option value="T">Todos</option>
			                <option value="D">Discapacitado</option>
			                <option value="N">No Discapacitado</option>
                       </select>
               </td>
          </tr>
          <tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden"  name="indReg">
		    <INPUT type="hidden" name="idUsu">
		    <INPUT type="hidden" name="reg">
		    <INPUT type="hidden" name="usu">
           </td>

          </tr>
  </table>
   </fieldset>

 <fieldset class="form">
  <legend>Listado de Beneficiarios/Citas &nbsp; <?php echo $cuentaP; ?>
  </legend>
    <table width="90%" align="center" class="detalles">
    <? if ($_SESSION['tipoUsuario'] == 2 or $_SESSION['tipoUsuario'] == 1){?>
  			<tr>
  				<!--<td colspan="22" align="right">
			  			<a class="vinculo" target="_blank" onClick="abrir('reportes/pdflistado_beneficiariosCitasSol.php?rif=<?php echo$rif?>&nombre=<?php echo$nombre?>&fec=<?php echo$fec?>&usuario=<?php echo$usuario?>');" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >-->
			        	</a>
				 	<a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
			    		  <?php } ?>
			      </td>
             </tr>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">N°</td>
              <td class="cabecera">CI/RIF</td>
              <td class="cabecera">Nombre</td>
              <td class="cabecera" width="5%">Teléfonos</td>
              <td class="cabecera">Correo</td>
              <td class="cabecera">Sexo</td>
              <td class="cabecera">Fecha Reg. Benef.</td>
              <td class="cabecera">Usuario</td>
              <td class="cabecera">Fecha Cita</td>
              <td class="cabecera">Turno</td>
              <td class="cabecera">Fecha Reg. Cita</td>
              <td class="cabecera">Tipo</td>
              <td class="cabecera">Cambiar Clave</td>
              <td class="cabecera">Cambiar Correo</td>
              <td class="cabecera">PDF Cita</td>
              <td class="cabecera">Datos</td>
             </tr>
<?php
        for($i=0;$i<count($listaBen);$i+=$nroCampos){

             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
$RIF=$listaBen[$i+2].''.$listaBen[$i+1].''.$listaBen[$i];
?>

              <tr class="<?php echo $color ?>">
               <td align="center"><?echo $i/$nroCampos+$offset+1?></td>
               <td align="center">&nbsp;<?php echo $listaBen[$i+2].''.$listaBen[$i+1].''.$listaBen[$i];?></td>
               <td><?php  echo $listaBen[$i+3];?> </td>
               <td align="center"><?php echo $listaBen[$i+4].'  '.$listaBen[$i+5]?> </td>
               <td align="center"><?php echo $listaBen[$i+6]?></td>
               <td align="center"><?php echo $listaBen[$i+7]?></td>
               <td align="center"><?php echo $listaBen[$i+12]?></td>
               <td align="center"><?php echo $listaBen[$i+8]?></td>
               <td align="center"><?php echo $listaBen[$i+9]?></td>
               <td align="center"><?php echo $listaBen[$i+10]?></td>
               <td align="center"><?php echo $listaBen[$i+11]?></td>
               <td align="center"><?php
                         if ($listaBen[$i+13]<>'1') echo "Persona con Discapacidad";
                         else echo "No discapacitado";  ?></td>
               <td><div align="center"><img src="imagenes/llave.png" width="30" height="30" onclick="reiniciar('<? echo $listaBen[$i+8] ?>')"></div></td>
               <td><div align="center"><img src="imagenes/email.png" width="20" height="20" onclick="abrir1('mod_correo_benefCita.php?usuario=<? echo $listaBen[$i+8]; ?>')"></div></td>
               <? if ($listaBen[$i+9]){ ?>
               <td><div align="center">
               <a class="vinculo" href="" target="_blank" onClick="popup('reportes/pdf_beneficiario_pre.php?rif=<?php echo $listaBen[$i+1]?>');return false;">
	           <img src="botones/printer_48.png" width="20" height="20">
	          </a></div></td>
               <? }else{ ?>
			   <td></td>
               <? } ?>
               <td><div align="center">
               <a class="vinculo" href="" target="_blank" onClick="popup_c('reg_beneficiariosExpCons.php?id=<? echo $listaBen[$i+1]; ?>');return false;">
	           <img src="botones/paper_content_48.png" width="20" height="20">
	          </a></div></td>
               </tr>
<?php     } ?>
  <tr><td colspan=9> <?php //echo 'Total: '.count($contArt)/$nroCampos;?></td></tr>
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