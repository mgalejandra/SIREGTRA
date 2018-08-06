<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/concesionario.php');
require('../modelos/zona.php');
require('../modelos/lotes.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,19,20);
	validaAcceso($permitidos,$dir);

 $indBusq  = $_POST['indBusq'];
 $pgActual = $_POST['pagina'];

 $sercarveh = $_POST['sercarveh'];
 $codpro	= $_POST['codpro'];
 $nombre	= $_POST['nombre'];
 $codmodveh = $_POST['codmodveh'];
 $estado=$_POST['estado'];
 $fecE=$_POST['fecE'];
 $fec2=$_POST['fecE2'];
 $numplaveh=$_POST['numplaveh'];
 $numlotveh=$_POST['numlotveh'];

 $_SESSION['sercarveh'] = $sercarveh;
 $_SESSION['codpro'] = $codpro;
 $_SESSION['nombre'] = $nombre;
 $_SESSION['modelo'] = $codmodveh;
 $_SESSION['estado'] = $estado;
 $_SESSION['fecE'] = $fecE;

$objConcesionario = new concesionario();
$objZona= new zona();
$objLote= new lotes();

if($indBusq==2){
	 $sercarveh = null;
	 $codpro	= null;
	 $nombre	= null;
	 $codmodveh = null;
	 $estado    = null;
	 $fecE      = null;
	 $numplaveh = null;
	 $fec2 = null;
	 $numlotveh = null;
}

$nroFilas = 15;
$combino = 14;
$nroCampos = 21;

$listarEstados = $objZona->listarEstados();

$cantReg=$objConcesionario->listarVehChery($sercarveh,$codpro,$nombre,-1,$codmodveh,$estado,$fecE,$numplaveh,$fec2,$numlotveh);

$cantReg=count($cantReg)/$nroCampos;
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

$listarVehChery=$objConcesionario->listarVehChery($sercarveh,$codpro,$nombre,$offset,$codmodveh,$estado,$fecE,$numplaveh,$fec2,$numlotveh);

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
	  	   " = window.open('reportes/xlsListadoConcesionario.php?sercarveh=<? echo $sercarveh; ?>&numplaveh=<? echo $numplaveh;?>&codpro=<? echo $codpro; ?>&nombre=<? echo $nombre; ?>&modelo=<? echo $codmodveh; ?>&estado=<? echo $estado; ?>&fecE=<? echo$fecE;?>&fecH=<? echo$fec2;?>
&lote=<? echo$numlotveh;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

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
           <td class="categoria">Nombre:</td>
           <td>
              <input name="nombre" type="text" id="nombre" value="<?php echo $nombre?>" onblur="javascript:this.value=this.value.toUpperCase()" size="20" width="60" maxlength="120"/>
           </td>
          <tr> <td  class="categoria">&nbsp;Serial:</td>
           <td>
			<input name="sercarveh" type="text" id="cosercarvehdmar"  value="<?php echo $sercarveh?>" />&nbsp;&nbsp;
		  </td>
           <td class="categoria">Modelo:</td>
           <td align="left">
             <select name="codmodveh"  id="codmodveh">
                <option value="<?php /*if ($sexo) echo $sexo*/ ?>"><?php /*if ($sexo) echo  $listarFactura[19] */?></option>
                <option value="QQ3">QQ3</option>
                <option value="X1">X1</option>
                <option value="TG4">Tiger 4x2</option>
                <option value="TIG">Tiggo</option>
                <option value="T44">Tiger 4x4</option>
          </select>
			</td></tr>
			 <tr>
           <td  class="categoria">Estado:</td>
           <td class="dato">
			 <SELECT id="estado" name="estado">
			 <option value="<?php if ($estado) echo $estado?>"><?php if ($estado) echo $listarFactura[18];?></option>
			 <option value="">TODOS</option>
			    <?php for($i=0;$i<count($listarEstados);$i+=2){  ?>
	               <option value="<?php echo $listarEstados[$i]; ?>"><?php echo $listarEstados[$i+1]?></option>
	           <?php } ?>

			 </SELECT>
		  </td>
		  </tr>
           <tr>
		  <td rowspan="2" class="categoria">Fecha entrega:</td>
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
          </tr>
          <tr><td  class="categoria">Placa :</td>
	        <td class="dato"  >
               <input name="numplaveh" type="text" id="numplaveh" value="<?php echo $numplaveh?>" size="7" maxlength="8" />
	        </td>
	        <td class="categoria">Lote:</td>
           <td align="left">
             <select name="numlotveh"  id="numlotveh">
                <option value="">SELECCIONE</option>
                <option value="14">CHERY 1</option>
                <option value="15">CHERY 2</option>
                <option value="16">CHERY 3</option>
                <!--<option value="15">CHERY 2</option>-->
          </select>
			</td>
	        </tr>
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
  <legend>&nbsp;Lista de Veh&iacute;culos <?php echo ' Total: '.$cantReg?>
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
 <?
 	if ($fecE and $fec2)
 		echo "<tr><td colspan='$combino' class='cabecera'>Fecha de entrega desde el ".$fecE." al ".$fec2."</td></tr>";

    if ($numlotveh){
    /*	$lote=$objLote->buscarLoteID($numlotveh);
echo "<tr><td colspan='13' class='cabecera'>Lote ".$lote[2]."</td></tr>";*/
      if ($numlotveh=='14')
    	echo "<tr><td colspan='$combino' class='cabecera'>Lote Chery 1</td></tr>";

      if ($numlotveh=='15')
    	echo "<tr><td colspan='$combino' class='cabecera'>Lote Chery 2</td></tr>";

 	  if ($numlotveh=='16')
    	echo "<tr><td colspan='$combino' class='cabecera'>Lote Chery 3</td></tr>";

      /*if ($numlotveh=='17')
    	echo "<tr><td colspan='$combino' class='cabecera'>Lote Chery 4</td></tr>";	    */

    }

 ?>

             <tr>
              <td class="cabecera">N°</td>
              <td class="cabecera">Lote</td>
              <td class="cabecera">Modelo</td>
              <td class="cabecera">Serial de Carrocería</td>
              <td class="cabecera">Serial de Motor</td>
              <!--<td class="cabecera">NIV</td>-->
              <td class="cabecera">Color</td>
              <td class="cabecera">Placa</td>
              <td class="cabecera">CI/RIF</td>
              <td class="cabecera">Nombre</td>
              <td class="cabecera">Direcci&oacute;n</td>
              <td class="cabecera">Estado</td>
              <td class="cabecera">Tel&eacute;fonos</td>
              <td class="cabecera">Fecha Fact. Orig.</td>
              <td class="cabecera">Fecha Entrega</td>
              <!-- <? if ($_SESSION['tipoUsuario']<>'18'){?><td class="cabecera"> B </td><? }?> -->
             </tr>
<?php
        for($i=0;$i<count($listarVehChery);$i+=$nroCampos){
          if($listarVehChery[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
             $nreg = $offset+$i/$nroCampos+1;


             $direccion = $listarVehChery[$i+11];
             if($listarVehChery[$i+12]) $direccion.= ' '.$listarVehChery[$i+12];
			 if($listarVehChery[$i+13]) $direccion.= ' '.$listarVehChery[$i+13];
             if($listarVehChery[$i+14]) $direccion.= ' '.$listarVehChery[$i+14];
			 if($listarVehChery[$i+15]) $direccion.= ' '.$listarVehChery[$i+15];
             if($listarVehChery[$i+16]) $direccion.= ', MUNICIPIO '.$listarVehChery[$i+16];

             $estadoN = $objZona->buscarEstados($listarVehChery[$i+18]);

?>

              <tr class="<?php echo $color ?>">
               <td align="center"><?echo $nreg?></td>
               <td><?php echo $listarVehChery[$i+20]; ?></td>
               <td><?php echo $listarVehChery[$i+3]; ?></td>
               <td><?php echo $listarVehChery[$i];?></td>
               <td><?php echo $listarVehChery[$i+6];?></td>
               <!--<td><?php echo $listarVehChery[$i+7];?></td>-->
               <td><?php echo $listarVehChery[$i+4];?></td>
               <td><?php echo $listarVehChery[$i+5];?></td>
               <td><?php echo $listarVehChery[$i+1];?></td>
               <td><?php echo $listarVehChery[$i+2];?></td>
               <td><?php echo $direccion;?></td>
               <td><?php echo $estadoN[1];?></td>
               <? $telefono = $listarVehChery[$i+9];
                  if ($listarVehChery[$i+10]<>'0') $telefono = $telefono." ".$listarVehChery[$i+10];
               ?>
               <td><?php echo $telefono; ?></td>
               <td><?php echo $listarVehChery[$i+17];?></td>
               <td><?php echo $listarVehChery[$i+19];?></td>
             <!-- <? if ($_SESSION['tipoUsuario']<>'18'){?> <td><div align="center">
               <a class="vinculo" href="reg_asignacion.php?idsercarveh=<?php echo $listarVehChery[$i]?>&tipo=<?php echo $tipo?>">
	              <img src="botones/buscar.png" width="20" height="20">
	          </a></div></td><? }?>-->
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