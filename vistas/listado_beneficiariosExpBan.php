<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/beneficiario.php');
require('../modelos/pago.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(8,9,10);
	validaAcceso($permitidos,$dir);

  $rif=$_POST['rif'];
  $nombre=$_POST['nombre'];
  $banco=$_POST['banco'];
  $fec=$_POST['fec'];
  $fec2=$_POST['fec2'];
   $pgActual = $_POST['pagina'];
  $indBusq=$_POST['indBusq'];
  $usuario=$_POST['usuario'];
  $tipoben=$_POST['tipoben'];


if ($indBusq=='2'){
  $rif=NULL;
  $nombre=NULL;
  $banco=NULL;
  $fec=NULL;
  $fec2 =NULL;
  $indBusq=NULL;
  $tipoben=NULL;

}
$objBeneficiario = new beneficiario();
$objPago = new pago();
$listarBancos=$objPago->listarBancos(3);
$listarBeneficiario=$objBeneficiario->listarTipo_benef();


$nroFilas = 15;
$nroCampos = 44;

$contArt = $objBeneficiario->contarBeneficiarios2($rif,$nombre,$_SESSION['idBanco'],$fec,$fec2,$usuario,$tipoben);

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

$listaBen=$objBeneficiario->listarBeneficiarioExp2($rif,$nombre,$offset,$_SESSION['idBanco'],$fec,$fec2,$usuario,'',$tipoben);
if ($listaBen[$i+40]) $datoslistarBancos=$objPago->listarBancos(4,$listaBen[$i+40]);
$usuarios=$objBeneficiario->usuario();

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
	  	   " = window.open('reportes/xlsListarBeneficiariosExp.php?rif=<?php echo$rif;?>&nombre=<?php echo$nombre;?>&banco=<?php echo$banco;?>&fec=<?php echo$fec;?>&fec2=<?php echo$fec2;?>&a=<?php echo '0';?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

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

                <td class="categoria">Usuario:</td>
             <td align="left" >
		         	 <SELECT id="usuario" name="usuario">
		         	 <OPTION value=""></OPTION>
						<?php for($j=0;$j<count($usuarios);$j++){  ?>
			               <option value="<?php echo $usuarios[$j]; ?>"><?php echo $usuarios[$j]?></option>
			           <?php } ?>
					 </SELECT>
		        </td>
			</tr>
			 <tr><td  class="categoria">Tipo beneficiario:</td>
           <td class="dato">
			 <select id="tipoben" name="tipoben">
			  <option value="<?php if ($tipoben) echo $tipoben?>"><?php if ($tipoben) echo $listarFactura[30];?></option>
			    <?php for($i=0;$i<count($listarBeneficiario);$i+=2){  ?>
	               <option value="<?php echo $listarBeneficiario[$i]; ?>"><?php echo $listarBeneficiario[$i+1]?></option>
	           <?php } ?>
          </select>
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
  <legend>Listado de Beneficiarios &nbsp; <?php echo 'Total: '.$contArt?>
  </legend>
    <table width="90%" align="center" class="detalles">
  			<tr>
  				<td colspan="22" align="right">
			  			<a class="vinculo" target="_blank" onClick="abrir('reportes/listBeneficiariosExp.php?rif=<?php echo $rif?>&nombre=<?php echo $nombre?>&banco=<?php echo $banco?>&fec=<?php echo $fec?>&fec2=<?php echo $fec2?>');" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a>
				    	<a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
			      </td>
             </tr>
    <table width="90%" align="center" class="detalles">


             <tr>
              <td class="cabecera">N°</td>
              <td class="cabecera">CI/RIF</td>
              <td class="cabecera">Nombre</td>
              <td class="cabecera">Direcci&oacute;n</td>
              <td class="cabecera" width="5%">Tel&eacute;fonos</td>
              <td class="cabecera">Observaciones</td>
              <td class="cabecera">Fecha Registro</td>
                <td class="cabecera">Banco</td>
                <td class="cabecera">Usuario</td>
                <td class="cabecera">Tipo Benef.</td>
                <? if ($_SESSION['tipoUsuario']<>'18'){?>
              <td class="cabecera"> B </td> <?php } ?>
              <td class="cabecera"> I </td>
             </tr>
<?php
        for($i=0;$i<count($listaBen);$i+=$nroCampos){
          if($listaBen[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
             $direccion = $listaBen[$i+26];
             if($listaBen[$i+27]) $direccion.= ' '.$listaBen[$i+27];
			 if($listaBen[$i+28]) $direccion.= ' '.$listaBen[$i+28];
             if($listaBen[$i+29]) $direccion.= ' '.$listaBen[$i+29];
			 if($listaBen[$i+30]) $direccion.= ' '.$listaBen[$i+30];
             if($listaBen[$i+31]) $direccion.= ' '.$listaBen[$i+31];
			 if($listaBen[$i+32]) $direccion.= ' '.$listaBen[$i+32];
             ?>

              <tr class="<?php echo $color ?>">
               <td align="center"><?echo $i/$nroCampos+$offset+1?></td>
               <td align="center">&nbsp;<?php echo $listaBen[$i];?></td>
               <td><?php  echo $listaBen[$i+6];?> </td>
               <td><?php echo $direccion?></td>
               <td align="center"><?php echo $listaBen[$i+14].'  '.$listaBen[$i+15]?> </td>
               <td align="center"><?php echo $listaBen[$i+16]?></td>
               <td align="center"><?php echo $listaBen[$i+18]?></td>
                <td align="center"><?php echo$listaBen[$i+41]?></td>
                <td align="center"><?php echo$listaBen[$i+42]?></td>
                <td align="center"><?php echo$listaBen[$i+43]?></td>
                 <? if ($_SESSION['tipoUsuario']<>'18'){?>
               <td><div align="center">
               <a class="vinculo" href="reg_beneficiariosExpBan.php?idbenefi=<?php echo $listaBen[$i]?>">
	              <img src="botones/buscar.png" width="20" height="20">
	          </a></div></td><?php } ?>
	           <td><div align="center">
               <a class="vinculo" href="" target="_blank" onClick="popup('reportes/pdf_beneficiariosExp.php?rif=<?php echo $listaBen[$i]?>');return false;">
	              <img src="botones/printer_48.png" width="20" height="20">
	          </a>
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
