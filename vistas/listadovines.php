<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/vines.php');

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,4,5,6,7,15,18);
validaAcceso($permitidos,$dir);

$objVines = new vines();

 $tipo   = $_POST['tipo'];
 $modelo = $_POST['modelo'];
 $marca  = $_POST['marca'];
 $color  = $_POST['color'];
 $pdi    = $_POST['pdi'];
 $fecha  = $_POST['fecha'];
 $Hora   = $_POST['Hora'];
 $nro   = $_POST['nro'];

 $pgActual = $_POST['pagina'];
 $indBusq  = $_POST['indBusq'];

if($indBusq==2){
	 $tipo   = null;
	 $modelo = null;
	 $marca  = null;
	 $color  = null;
	 $pdi    = null;
	 $fecha  = null;
	 $Hora   = null;
	 $nro   = null;
}

$nroCampos = 23;

$nroFilas = 15;

$cantReg=$objVines->listadodevines($tipo,$modelo,$marca,$color,$pdi,$fecha,$Hora,$nro);


$cantReg=count($cantReg)/$nroCampos;

//echo 'cantidadreg: '.$cantReg;

$cantPaginas = ceil($cantReg/($nroFilas));


//echo '$cantPaginas: '.$cantPaginas;

if(!$pgActual){
	$pgActual = 1;
	//echo 'entro1';
}
elseif($pgActual > $cantPaginas){
     $pgActual = $cantPaginas;
    // echo 'emtro2';
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

//echo 'aqui'.$offset;

$listadodevines=$objVines->listadodevines($tipo,$modelo,$marca,$color,$pdi,$fecha,$Hora,$nro,$offset);

$tipo_archivo=$objVines->tipo_archivo();

$modeloArchivo=$objVines->modeloArchivo();

$marcaArchivo=$objVines->marcaArchivo();

$colorArchivo=$objVines->colorArchivo();

$fechaArchivo=$objVines->fechaArchivo();

$horaArchivo=$objVines->horaArchivo();

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

 function imprimir(tipo) {
  dato=tipo;
  day = new Date();
  id = day.getTime();
  eval("page" + id +
  	   " = window.open('reportes/listAsignaciones.php?tip='+dato,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
  }

function enviar(dato){
	if(dato=="2"){
		window.document.registro.numlotveh.value = null;
		window.document.registro.cosercarvehdmar.value = null;
		window.document.registro.codpro.value = null;
		window.document.registro.nombre.value = null;
		window.document.registro.fechAsig.value = null;
	}
	document.registro.pagina.value = 0;
	document.registro.indBusq.value = dato;
}


function exel(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id +
	  	   " = window.open('reportes/xlslistadovines.php?tipo=<?php echo $tipo;?>&modelo=<?php echo $modelo;?>&marca=<?php echo $marca;?>&color=<?php echo $color;?>&pdi=<?php echo $pdi;?>&fecha=<?php echo $fecha;?>&hora=<?php echo $hora;?>&nro=<?php echo $nro;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

}
</script>
  </head>
  <body class="pagina">
   <TABLE class="completo">
    <TR>
     <TD class="banner2"></TD>
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
  <legend>Criterios de B&uacute;squeda </legend>
     <TABLE class="dato" border="0" width="900" align="center">
	<tr>
	       <td  class="categoria">Tipo:</td>
           <td class="dato">
			 <SELECT id="tipo" name="tipo">
			      <option value=""><?php echo "Todos"; ?></option>
			    <?php for($i=0;$i<count($tipo_archivo);$i+=4){  ?>
	               <option value="<?php echo $tipo_archivo[$i]; ?>"><?php echo $tipo_archivo[$i+1]?></option>
	           <?php } ?>
          </select>
		  </td>
		  <td  class="categoria">Nro de Archivo</td>
		  <td align="left"> <input name="nro" type="text" id="nro" maxlength="8" size="9"  /></td>
		   <td  class="categoria">Modelo:</td>
           <td class="dato">
			 <SELECT id="modelo" name="modelo">
			      <option value=""><?php echo "Todos"; ?></option>
			    <?php for($i=0;$i<count($modeloArchivo);$i+=1){  ?>
	               <option value="<?php echo $modeloArchivo[$i]; ?>"><?php echo $modeloArchivo[$i]?></option>
	           <?php } ?>
          </select>
		  </td>
		   <td  class="categoria">Marca:</td>
           <td class="dato">
			 <SELECT id="marca" name="marca">
			      <option value=""><?php echo "Todos"; ?></option>
			    <?php for($i=0;$i<count($marcaArchivo);$i+=1){  ?>
	               <option value="<?php echo $marcaArchivo[$i]; ?>"><?php echo $marcaArchivo[$i]?></option>
	           <?php } ?>
          </select>
		  </td>

	</tr>
	<tr>
	    <td  class="categoria">Color:</td>
           <td class="dato">
			 <SELECT id="color" name="color">
			      <option value=""><?php echo "Todos"; ?></option>
			    <?php for($i=0;$i<count($colorArchivo);$i+=1){  ?>
	               <option value="<?php echo $colorArchivo[$i]; ?>"><?php echo $colorArchivo[$i]?></option>
	           <?php } ?>
          </select>
		  </td>
		   <td  class="categoria">PDI:</td>
           <td class="dato">
			 <SELECT id="pdi" name="pdi">
			      <option value=""><?php echo "Todos"; ?></option>
			      <option value="lla"><?php echo "Llaves"; ?></option>
			      <option value="enc"><?php echo "Encendido"; ?></option>
			      <option value="car"><?php echo "Carroceria"; ?></option>
			      <option value="cau"><?php echo "Caucho"; ?></option>
			      <option value="gat"><?php echo "Gato"; ?></option>
			      <option value="tri"><?php echo "Triangulo"; ?></option>
                  <option value="her"><?php echo "Herramientas"; ?></option>
          </select>
		  </td>
		   <td  class="categoria">Fecha:</td>
           <td class="dato">
			 <SELECT id="fecha" name="fecha">
			      <option value=""><?php echo "Todos"; ?></option>
			    <?php for($i=0;$i<count($fechaArchivo);$i+=1){  ?>
	               <option value="<?php echo $fechaArchivo[$i]; ?>"><?php echo $fechaArchivo[$i]?></option>
	           <?php } ?>
          </select>
		  </td>
		   <td  class="categoria">Hora:</td>
           <td class="dato">
			 <SELECT id="hora" name="hora">
			      <option value=""><?php echo "Todos"; ?></option>
			    <?php for($i=0;$i<count($horaArchivo);$i+=1){  ?>
	               <option value="<?php echo $horaArchivo[$i]; ?>"><?php echo $horaArchivo[$i]?></option>
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
  <legend>Listado </legend>
  <TABLE class="dato" border="0" width="900" align="center">
  			<tr>
  				<td colspan="23" align="right">
			<!--   			<a class="vinculo" target="_blank" onClick="abrir('reportes/pdfCuadroResCitasxBanco.php?tipo=<? echo$tipoBen;?>&fechaD=<? echo$fechaD;?>&fechaH=<? echo$fechaH; ?>&banco=<? echo$banco;?>');" />
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

		   <TR class="cabeceraI">
		   <TH colspan="9"><? echo "Datos del Vehiculo"?></TH>
		   <TH colspan="7"><? echo "Resumen de PDI"?></TH>
		   <TH colspan="4"><? echo "Fechas"?></TH>
     	   </TR>
		   <TR class="cabecera">
		   <TH>Nro</TH>
		    <TH>Tipo</TH>
		    <TH>Nro</TH>
		    <TH>Modelo</TH>
			<TH>Marca</TH>
			<TH>Serial C.</TH>
			<TH>Serial M.</TH>
			<TH>Color</TH>
			<TH>A&ntilde;o F.</TH> 
			<TH>A&ntilde;o M.</TH>
			<TH>Llave</TH>
			<TH>Encendido</TH>
			<TH>Carroceria</TH>
			<TH>Caucho</TH>
			<TH>Gato</TH>
			<TH>Triangulo</TH>
			<TH>Herramienta</TH>
			<TH>Fecha Captura</TH>
			<TH>Hora Captura</TH>

		  </tr>

<?php
	      for($i=0;$i<count($listadodevines);$i+=23)
	      {
          	  $color = (!$indC)?'datosimpar':'datospar';
              $indC = !$indC;
              $contArt ++;
              $nreg = $offset+$i/23+1;
     ?>
      <tr class="<?php echo $color ?>">
            <td align="center"><?echo $nreg?></td>
		    <TD align="left"><?php echo $listadodevines[$i+21]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+2]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+3]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+4]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+5]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+6]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+7]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+8]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+9]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+10]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+11]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+12]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+13]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+14]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+15]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+16]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+17]; ?></TD>
		    <TD align="left"><?php echo $listadodevines[$i+18]; ?></TD>

	  </tr>
	  <?php }  ?>
    </table>
    </fieldset>

<BR>
 <div align="center">
       <?php  if($pgActual>1){?>
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