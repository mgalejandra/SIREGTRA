<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/vehiculos.php');


	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,11,15,18,20);
	validaAcceso($permitidos,$dir);

    $objVehiculo = new vehiculos();

    $numlotveh=$_POST['numlotveh'];

	$reporteMincoSuvinca=$objVehiculo->reporteMincoSuvinca($numlotveh);



?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
    <SCRIPT>
  function imprimir() {
	day = new Date();
	id = day.getTime();
	eval("page" + id +
	     " = window.open('reportes/pdfCuadroPersonasTipo.php?lote=<? echo $numlotveh; ?>','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
	}

  function enviar(campo){
	window.document.inventario.indBusq.value = campo;
	window.document.inventario.submit();
  }
  </SCRIPT>
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
    <form action="" method="post" name="inventario">

 <fieldset class="form">
  <legend>Listado de Veh&iacute;culos Entregados y En Campo</legend>
    <table width="90%" align="center" class="detalles" border=0>
    <tr><!--
  				<td colspan="23" align="right">
			  			<a class="vinculo" target="_blank" onClick="imprimir()" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a>
			      </td>-->
             </tr>
             <tr>
              <td class="cabecera">Lote</td>
              <td class="cabecera">Modelo</td>
			  <td class="cabecera">Existencia Inicial</td>
			  <td class="cabecera">Entregados</td>
			  <td class="cabecera">Asignados</td>
			  <td class="cabecera">Asignados/No PDI</td>
			  <td class="cabecera">PDI No Aprobado</td>
			  <td class="cabecera">Inventario</td>
			  <td class="cabecera">En Campo</td>
             </tr>
<?php
        $numlot='';
        $pri=true;
        $numcampo=13;
      	for($i=0;$i<count($reporteMincoSuvinca);$i+=$numcampo){
      		if($reporteMincoSuvinca){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
        	 $asignacion= ($reporteMincoSuvinca[$i+4]-$reporteMincoSuvinca[$i+7])+$reporteMincoSuvinca[$i+10]+$reporteMincoSuvinca[$i+11];

        	 $inventario=$reporteMincoSuvinca[$i+2]-$reporteMincoSuvinca[$i+3]-
        	             $asignacion-$reporteMincoSuvinca[$i+7]-($reporteMincoSuvinca[$i+5]-$reporteMincoSuvinca[$i+7]);



        	 $campo= $reporteMincoSuvinca[$i+2]-$reporteMincoSuvinca[$i+3];
        	 $totalExistencia+=$reporteMincoSuvinca[$i+2];
        	 $totalEntregados+=$reporteMincoSuvinca[$i+3];
        	 $totalAsignados+=$asignacion;
        	 $totalAsignadosNoPdi+=$reporteMincoSuvinca[$i+7];
        	 $totalSinPlacas+=$reporteMincoSuvinca[$i+8];
        	 $totalSinFact+=$reporteMincoSuvinca[$i+10];
        	 $totalNoPdi+=($reporteMincoSuvinca[$i+5]-$reporteMincoSuvinca[$i+7]);
        	 $totalInventario+=$inventario;
        	 $totalCampo+=$campo;
        	// echo 'lote:'.$numlot;
        	// echo 'loteBD:'.$reporteMincoSuvinca[$i];

?>
              <tr class="<?php echo $color ?>">
              <td ><?php echo $reporteMincoSuvinca[$i];?> </td>
              <td align="center"><?php echo $reporteMincoSuvinca[$i+1];?> </td>
              <td align="center"><?php echo $reporteMincoSuvinca[$i+2];?> </td>
     		  <td align="center"><?php echo $reporteMincoSuvinca[$i+3];?> </td>
              <td align="center"><?php echo $asignacion;?> </td>
              <td align="center"><?php echo $reporteMincoSuvinca[$i+7];?> </td>
              <td align="center"><?php echo $reporteMincoSuvinca[$i+5]-$reporteMincoSuvinca[$i+7];?> </td>
              <td align="center"><?php echo $inventario;?> </td>

              <td align="center"><?php echo $campo;?> </td>
              <tr>
        <?php
               if($pri) $numlot=$reporteMincoSuvinca[$i];else $numlot=$reporteMincoSuvinca[$i+$numcampo];
        	   $pri=false;

        	 if($numlot!=$reporteMincoSuvinca[$i]){  ;?>
              <tr>
              <td colspan="2" align="right" class="cabecera" >Total Lote: <?php echo $reporteMincoSuvinca[$i] ?> </td>
              <td align="center"><?php echo $totalExistencia;?> </td>
              <td align="center"><?php echo $totalEntregados;?> </td>
     		  <td align="center"><?php echo $totalAsignados;?> </td>
              <td align="center"><?php echo $totalAsignadosNoPdi;?> </td>
              <td align="center"><?php echo $totalNoPdi;?> </td>
              <td align="center"><?php echo $totalInventario;?> </td>

              <td align="center"><?php echo $totalCampo;?> </td>
              <tr>
              <tr><td><p><p><p><p></td></tr>
<?php
             $totalExistencia=0;
        	 $totalEntregados=0;
        	 $totalAsignados=0;
        	 $totalAsignadosNoPdi=0;
        	 $totalNoPdi=0;
        	 $totalInventario=0;
        	 $totalCampo=0;
        	 $totalSinPlacas=0;
        	 $totalSinFact=0;

   	 };//fin del print del total
$numlot=$reporteMincoSuvinca[$i];
      		}//fin de la condicion si hay datos
  }//fin for
?>


</table>
</fieldset>
<BR>
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