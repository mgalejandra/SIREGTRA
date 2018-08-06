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
	$permitidos = array(1,2,3,4,5,11,15,18,22,20,25);
	validaAcceso($permitidos,$dir);

    $objVehiculo = new vehiculos();
    $pgActual = $_POST['pagina'];
  	$indBusq=$_POST['indBusq'];


	$reporteMincoSuvinca=$objVehiculo->reporteMincoSuvinca3();

if ($indBusq=='2'){
	$numlotveh=null;
 }

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
	      " = window.open('reportes/pdf_reportemincoSuvinca3.php?numlotveh=<? echo $numlotveh; ?>','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
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
  <legend>Listado de Veh&iacute;culos Chery Entregados y En Campo TAXIS</legend>
    <table width="90%" align="center" class="detalles" border=0>
    <tr>
  				<td colspan="23" align="right">
			  			<a class="vinculo" target="_blank" onClick="imprimir()" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >

			      </td>
             </tr>
             <tr>
              <td class="cabecera">Modelo</td>
			  <td class="cabecera">Existencia Inicial</td>
			  <td class="cabecera">Entregados</td>

			  <td class="cabecera">Asignados</td>
			  <td class="cabecera">Comprometidos</td>

			  <td class="cabecera">Disponible en Campo</td>


			  <td class="cabecera">Asignados/No PDI</td>
			  <td class="cabecera">PDI Negativo</td>
			  <td class="cabecera">Disponible para asignar</td>
			  <td class="cabecera">Vehiculos Sin Placas</td>
			  <td class="cabecera">Vehiculos Sin Placas/No PDI</td>
			  <td class="cabecera">Vehiculos Sin Facturas</td>

             </tr>
<?php
        $numlot='';
        $pri=true;
        $numcampo=11;
      	for($i=0;$i<count($reporteMincoSuvinca);$i+=$numcampo){
      		if($reporteMincoSuvinca){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;

        	 $asignacion= ($reporteMincoSuvinca[$i+3]-$reporteMincoSuvinca[$i+6])+$reporteMincoSuvinca[$i+9]+$reporteMincoSuvinca[$i+10];

        	 $inventario=$reporteMincoSuvinca[$i+1]-$reporteMincoSuvinca[$i+2]-
        	             $asignacion-$reporteMincoSuvinca[$i+6]-($reporteMincoSuvinca[$i+4]-$reporteMincoSuvinca[$i+6]);

             $nopdi = $reporteMincoSuvinca[$i+4]-$reporteMincoSuvinca[$i+6];

        	 //$campo = $reporteMincoSuvinca[$i+1]-$reporteMincoSuvinca[$i+2];
        	 $campo = $reporteMincoSuvinca[$i+1]-$reporteMincoSuvinca[$i+2]-$asignacion-$reporteMincoSuvinca[$i+10];
			 $totalExistencia+=$reporteMincoSuvinca[$i+1];
			 $totalEntregados+=$reporteMincoSuvinca[$i+2];
			 //$totalAsignados+=$reporteMincoSuvinca[$i+3];
			 $totalAsignados+=$asignacion;
			 $totalComprometidos+=$reporteMincoSuvinca[$i+10];
			 $totalAsignadosNoPdi+=$reporteMincoSuvinca[$i+6];
			 //$totalNoPdi+=$reporteMincoSuvinca[$i+4];
			 $totalNoPdi+=$nopdi;
			 //$totalInventario+=$reporteMincoSuvinca[$i+5];
			 $totalInventario+=$inventario;
			 $totalSinPlacas+=$reporteMincoSuvinca[$i+7];
			 $totalSinPlacasNOPDI+=$reporteMincoSuvinca[$i+8];
			 $totalSinFact+=$reporteMincoSuvinca[$i+9];
        	 $totalCampo+=$campo;
?>
              <tr class="<?php echo $color ?>">
 			  <td ><?php echo $reporteMincoSuvinca[$i];?> </td>
 			  <td align="center"><?php echo $reporteMincoSuvinca[$i+1];?></td>
 			  <td align="center"><?php echo $reporteMincoSuvinca[$i+2];?></td>
 			  <td align="center"><?php echo $asignacion;?></td>
 			  <td align="center"><?php echo $reporteMincoSuvinca[$i+10];?></td>
 			  <td align="center"><?php echo $campo;?> </td>
 			  <td align="center"><?php echo $reporteMincoSuvinca[$i+6];?></td>
 			  <td align="center"><?php echo $nopdi;?></td>
 			  <td align="center"><?php echo $inventario;?></td>
 			  <td align="center"><?php echo $reporteMincoSuvinca[$i+7];?></td>
 			  <td align="center"><?php echo $reporteMincoSuvinca[$i+8];?></td>
 			  <td align="center"><?php echo $reporteMincoSuvinca[$i+9];?></td>

              <tr>
<?php
   	 };//fin del print del total
  }//fin for
?>
<tr  class="cabecera">
              <td align="right" >Total Vehiculos:</td>
              <td align="center"><?php echo $totalExistencia;?> </td>
              <td align="center"><?php echo $totalEntregados;?> </td>
     		  <td align="center"><?php echo $totalAsignados;?> </td>
     		  <td align="center"><?php echo $totalComprometidos;?> </td>
     		  <td align="center"><?php echo $totalCampo;?> </td>
              <td align="center"><?php echo $totalAsignadosNoPdi;?> </td>
              <td align="center"><?php echo $totalNoPdi;?> </td>
              <td align="center"><?php echo $totalInventario;?> </td>
              <td align="center"><?php echo $totalSinPlacas;?> </td>
              <td align="center"><?php echo $totalSinPlacasNOPDI;?> </td>
              <td align="center"><?php echo $totalSinFact;?> </td>

<tr>
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