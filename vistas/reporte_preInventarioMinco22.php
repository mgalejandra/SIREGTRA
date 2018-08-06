<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/inventario.php');
require('../modelos/asignacion.php');
require('../modelos/vehiculos.php');
require('../modelos/entrega.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,11,15,18,20);
	validaAcceso($permitidos,$dir);
	//require ('../modelos/usuarios.php');

  $nroCampos= 9;

  /*$codmar=$_POST['codmar'];
  $modveh=$_POST['codmodveh'];
  $serveh=$_POST['codserveh'];
  $codpro=$_POST['codpro'];*/
  $pgActual = $_POST['pagina'];
  $indBusq=$_POST['indBusq'];

//echo "indice: ".$indBusq;

  $numlotveh=$_POST['numlotveh'];

$objInventario = new inventario();
$objVehiculo = new vehiculos();
$objEntrega = new entrega();

 if ($indBusq=='2'){
	$numlotveh=null;
 }

if ($numlotveh)
{
	$listVehAsigPreInvL=$objInventario->reportePreinventarioC($numlotveh);
	$_SESSION['listVehAsigPreInvL']=$listVehAsigPreInvL;
}
else
{
	$listVehAsigPreInv=$objInventario->reportePreinventarioC(14);
	$_SESSION['listVehAsigPreInv']=$listVehAsigPreInv;
	$listVehAsigPreInv1=$objInventario->reportePreinventarioC(15);
	$_SESSION['listVehAsigPreInv1']=$listVehAsigPreInv1;
	$listVehAsigPreInv2=$objInventario->reportePreinventarioC(16);
	$_SESSION['listVehAsigPreInv2']=$listVehAsigPreInv2;
	/*$listVehAsigPreInv3=$objInventario->reportePreinventarioC(17);
	$_SESSION['listVehAsigPreInv3']=$listVehAsigPreInv3;*/
}

?>
<!DOCTYPE HTML PUBLIC>
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
	     " = window.open('reportes/pdf_preInventarioMINCO.php?numlotveh=<? echo $numlotveh; ?>','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
	}

  function imprimir1() {
	day = new Date();
	id = day.getTime();
	eval("page" + id +
	     " = window.open('reportes/pdf_preInventario_minco.php?numlotveh=<? echo $numlotveh; ?>','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
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
  <legend>Criterios de B&uacute;squeda</legend>
     <table  align="center" >
 <tr>
          <td  class="categoria">N° Lote:</td>
          <td align="left">
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
         </td></tr>
         <tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden"  name="indBusq">
           </td>
          </tr>
  </table>
   </fieldset>

 <fieldset class="form">
  <legend>Listado de Veh&iacute;culos Entregados y En Campo</legend>
    <table width="90%" align="center" class="detalles">
    <tr><td colspan="23" align="right">
  			<? if ($_SESSION['tipoUsuario']<>'20'){?>
			  			<a class="vinculo" target="_blank" onClick="imprimir()" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a>

		 	<?	} ?>
			        <a class="vinculo" target="_blank" onClick="imprimir1()" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a>
			      </td>
             </tr>
             <tr>
              <td class="cabecera">Lote</td>
              <td class="cabecera">Modelo</td>
			  <td class="cabecera">Existencia Inicial</td>
			  <td class="cabecera">Entregados</td>
			  <td class="cabecera">Total PDI No Aprobado</td>
			  <td class="cabecera">PDI No Aprobado/Asignados </td>
			  <td class="cabecera">Asignados</td>
			  <td class="cabecera">Inventario</td>
			  <td class="cabecera">En Campo</td>
             </tr>
<?php
      if($numlotveh)
      {
      	//echo "Buscar solo el lote";
        for($i=0;$i<count($listVehAsigPreInvL);$i+=$nroCampos){
             if($listVehAsigPreInvL[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $listVehAsigPreInvL[$i+7];?> </td>
               <td align="center"><?php echo $listVehAsigPreInvL[$i+1];?> </td>
               <td align="center"><?php echo $listVehAsigPreInvL[$i+2];  $existenciaL= $listVehAsigPreInvL[$i+2];  ?></td>
               <?
   				  $listVehEntL=$objEntrega->contarEntregasChery($numlotveh,$listVehAsigPreInvL[$i]);
				  $_SESSION['listVehEntL']=$listVehEntL;

				  $totalExL+=$existenciaL;
                  $totalEnL+=$listVehEntL;

                  if ($listVehAsigPreInvL[$i]=='QQ3')
                  		$imprimoQeL = $listVehEntL;
                  elseif ($listVehAsigPreInvL[$i]=='X1')
              			$imprimoXeL = $listVehEntL;
                  elseif ($listVehAsigPreInvL[$i]=='TIG')
						$imprimoTIGeL = $listVehEntL;
                  elseif ($listVehAsigPreInvL[$i]=='TG4')
                 		$imprimoTG4eL = $listVehEntL;
                  elseif ($listVehAsigPreInvL[$i]=='T44')
                 		$imprimoT44eL = $listVehEntL;

                 		$campoL= $existenciaL - $listVehEntL;

                 		$totalCampL+=$campoL;
                  ?>
		       <?php if (($listVehAsigPreInvL[$i+1]=="X1") or ($listVehAsigPreInvL[$i+1]=="TIGGO") or ($listVehAsigPreInvL[$i+1]=="QQ3")  or ($listVehAsigPreInvL[$i+1]=="GRAND TIGER 4X2")  or ($listVehAsigPreInvL[$i+1]=="GRAND TIGER 4X4")) { ?>
		       <?php if ($listVehAsigPreInvL[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQeL; ?></td><?php } ?>
               <?php if ($listVehAsigPreInvL[$i+1]=="X1") { ?><td align="center"><? echo  $imprimoXeL; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInvL[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIGeL; ?></td><?php } ?>
               <?php if ($listVehAsigPreInvL[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG4eL; ?></td><?php } ?>
               <?php if ($listVehAsigPreInvL[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT44eL; ?></td><?php } ?>

        <?php }  ?>

               <td align="center">
               <?php
               $asignadosL= ($listVehAsigPreInvL[$i+4] + $listVehAsigPreInvL[$i+5])-$listVehAsigPreInvL[$i+6];
			   echo $asignadosL;

			   $totalAsL+=$asignadosL;
               ?></td>
               <?
                  $listVehNoPDIL=$objVehiculo->listVehNoPDI('',$listVehAsigPreInvL[$i],'',$numlotveh,'','',-1);
                  $cuentaL = count($listVehNoPDIL)/$nroCampos;

                   $totalCuentaL+=$cuentaL;
                  if ($listVehAsigPreInvL[$i]=='QQ3')
                  		$imprimoQL = $cuentaL;
                  elseif ($listVehAsigPreInvL[$i]=='X1')
              			$imprimoXL = $cuentaL;
                  elseif ($listVehAsigPreInvL[$i]=='TIG')
						$imprimoTIGL = $cuentaL;
                  elseif ($listVehAsigPreInvL[$i]=='TG4')
                 		$imprimoTG4L = $cuentaL;
                  elseif ($listVehAsigPreInvL[$i]=='T44')
                 		$imprimoT44L= $cuentaL;
                  ?>
		       <?php if (($listVehAsigPreInvL[$i+1]=="X1") or ($listVehAsigPreInvL[$i+1]=="TIGGO") or ($listVehAsigPreInvL[$i+1]=="QQ3")  or ($listVehAsigPreInvL[$i+1]=="GRAND TIGER 4X2")  or ($listVehAsigPreInvL[$i+1]=="GRAND TIGER 4X4")) { ?>
		       <?php if ($listVehAsigPreInvL[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQL; ?></td><?php } ?>
               <?php if ($listVehAsigPreInvL[$i+1]=="X1") { ?><td align="center"><? echo $imprimoXL; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInvL[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIGL; ?></td><?php } ?>
               <?php if ($listVehAsigPreInvL[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG4L; ?></td><?php } ?>
               <?php if ($listVehAsigPreInvL[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT44L; ?></td><?php } ?>
        <?php }

        		//$sumoB1 = $sumoA1 + $cuenta1;
        ?>
               <td align="center"><?php echo $listVehAsigPreInvL[$i+3];  $totalInvL+=$listVehAsigPreInvL[$i+3]; ?></td>

               <td align="center"><?php echo $campoL; ?></td>
              </tr>
<?php     }
        }
?>
<tr><td colspan="2" align="right" class="cabecera">Total Lote: <? echo $numlotveh; ?></td>
<td align="center"><? echo $totalExL; $_SESSION['exL']=$totalExL; ?></td>
<td align="center"><? echo $totalEnL; $_SESSION['enL']=$totalEnL; ?></td>
<td align="center"><? echo  $totalAsL; $_SESSION['asL']=$totalAsL;?></td>
<td align="center"><font color="red"><? echo  $totalCuentaL; $_SESSION['ctaL']=$totalCuentaL;?></font></td>
<td align="center"><? echo $totalInvL; $_SESSION['invL']=$totalInvL; ?></td>
<td align="center"><? echo $totalCampL; $_SESSION['campL']=$totalCampL;?></td>
</tr>
<?
      }
      else
      {

        for($i=0;$i<count($listVehAsigPreInv1);$i+=$nroCampos){
             if($listVehAsigPreInv1[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $listVehAsigPreInv1[$i+7];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv1[$i+1];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv1[$i+2];  $existencia1= $listVehAsigPreInv1[$i+2];?> </td>
               <?
   				  $listVehEnt15=$objEntrega->contarEntregasChery(15,$listVehAsigPreInv1[$i]);
				  $_SESSION['listVehEnt15']=$listVehEnt15;

				  $totalEx1+=$existencia1;
                  $totalEn1+=$listVehEnt15;

                  if ($listVehAsigPreInv1[$i]=='QQ3')
                  		$imprimoQe1 = $listVehEnt15;
                  elseif ($listVehAsigPreInv1[$i]=='X1')
              			$imprimoXe1 = $listVehEnt15;
                  elseif ($listVehAsigPreInv1[$i]=='TIG')
						$imprimoTIGe1 = $listVehEnt15;
                  elseif ($listVehAsigPreInv1[$i]=='TG4')
                 		$imprimoTG4e1 = $listVehEnt15;
                  elseif ($listVehAsigPreInv1[$i]=='T44')
                 		$imprimoT44e1 = $listVehEnt15;

                 		$campo1= $existencia1 - $listVehEnt15;

                 		$totalCamp1+=$campo1;
                  ?>
		       <?php if (($listVehAsigPreInv1[$i+1]=="X1") or
		                 ($listVehAsigPreInv1[$i+1]=="TIGGO") or
		                 ($listVehAsigPreInv1[$i+1]=="QQ3")  or
		                 ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X2")  or
		                 ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X4")) { ?>

		       <?php if ($listVehAsigPreInv1[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQe1; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="X1") { ?><td align="center"><? echo  $imprimoXe1; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIGe1; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG4e1; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT44e1; ?></td><?php } ?>

        <?php }  ?>

               <!--<td align="center">-->
               <?php
               $asignados1= ($listVehAsigPreInv1[$i+4] + $listVehAsigPreInv1[$i+5])-$listVehAsigPreInv1[$i+6];
			  // echo $asignados1.'asig';
			   $totalAs1+=$asignados1;
               ?>
                <!--</td>-->
               <? //$listVehNoPDI1=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv1[$i+1],'','','','',-1);
                  $listVehNoPDI1=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv1[$i],'',15,'','',-1);
                  $cuenta1 = count($listVehNoPDI1)/8;

                   $totalCuenta1+=$cuenta1;
                  if ($listVehAsigPreInv1[$i]=='QQ3')
                  		$imprimoQ1 = $cuenta1;
                  elseif ($listVehAsigPreInv1[$i]=='X1')
              			$imprimoX1 = $cuenta1;
                  elseif ($listVehAsigPreInv1[$i]=='TIG')
						$imprimoTIG1 = $cuenta1;
                  elseif ($listVehAsigPreInv1[$i]=='TG4')
                 		$imprimoTG41 = $cuenta1;
                  elseif ($listVehAsigPreInv1[$i]=='T44')
                 		$imprimoT441= $cuenta1;
                  ?>
                                 <? //$listVehNoPDI1=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv1[$i+1],'','','','',-1);
                  $listVehNoPDI2=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv[$i],'',15,'','AS',-1);
                  $cuenta2 = count($listVehNoPDI2)/13;
				  $totalCuenta2+=$cuenta2;

                  if ($listVehAsigPreInv[$i]=='QQ3')
                  		$imprimoQ2 = $cuenta2;
                  elseif ($listVehAsigPreInv[$i]=='X1')
              			$imprimoX2 = $cuenta2;
                  elseif ($listVehAsigPreInv[$i]=='TIG')
						$imprimoTIG2 = $cuenta2;
                  elseif ($listVehAsigPreInv[$i]=='TG4')
                 		$imprimoTG42 = $cuenta2;
                  elseif ($listVehAsigPreInv[$i]=='T44')
                 		$imprimoT442 = $cuenta2;
                  ?>
		       <?php if (($listVehAsigPreInv1[$i+1]=="X1") or
		       ($listVehAsigPreInv1[$i+1]=="TIGGO") or
		       ($listVehAsigPreInv1[$i+1]=="QQ3")  or
		       ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X2")  or
		       ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X4")) { ?>
		       <?php if ($listVehAsigPreInv1[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQ1-$imprimoQ2; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="X1") { ?><td align="center"><? echo $imprimoX1-$imprimoX2; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIG1-$imprimoTIG2; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG41-$imprimoTG42; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT441-$imprimoT442; ?></td><?php } ?>
        <?php }

        		//$sumoB1 = $sumoA1 + $cuenta1;
        ?>

        		       <?php if (($listVehAsigPreInv[$i+1]=="X1") or ($listVehAsigPreInv[$i+1]=="TIGGO") or ($listVehAsigPreInv[$i+1]=="QQ3")  or ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X2")  or ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X4")) { ?>
		       <?php if ($listVehAsigPreInv[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQ2; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="X1") { ?><td align="center"><? echo $imprimoX2; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIG2; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG42; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT442; ?></td><?php } ?>
               <?php } ?>
                <?php   if (($listVehAsigPreInv[$i+1]=="X1") or
			                ($listVehAsigPreInv[$i+1]=="TIGGO") or
			                ($listVehAsigPreInv[$i+1]=="QQ3")  or
			                ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X2")  or
			                ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X4")) { ?>

		       <?php if ($listVehAsigPreInv[$i+1]=="QQ3") { ?><td align="center"><? echo $asignados1-$imprimoQ2; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="X1") { ?><td align="center"><? echo $asignados1-$imprimoX2; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="TIGGO") { ?><td align="center"><? echo $asignados1-$imprimoTIG2; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $asignados1-$imprimoTG42; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $asignados1-$imprimoT442; ?></td><?php } ?>
               <?php } ?>
               <?php    //inventario
                         if (($listVehAsigPreInv[$i+1]=="X1") or
			                ($listVehAsigPreInv[$i+1]=="TIGGO") or
			                ($listVehAsigPreInv[$i+1]=="QQ3")  or
			                ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X2")  or
			                ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X4")) { ?>

<?php if ($listVehAsigPreInv[$i+1]=="QQ3") { ?><td align="center">
<? echo $listVehAsigPreInv1[$i+2]-$imprimoQe1-($imprimoQ1-$imprimoQ2)-$imprimoQ2-($asignados1-$imprimoQ2); ?></td><?php } ?>
<?php if ($listVehAsigPreInv[$i+1]=="X1") { ?><td align="center">
<? echo $listVehAsigPreInv1[$i+2]-$imprimoXe1-($imprimoX1-$imprimoX2)-$imprimoX2-($asignados1-$imprimoX2);  ?></td> <?php } ?>
<?php if ($listVehAsigPreInv[$i+1]=="TIGGO") { ?>
<td align="center">
<? echo $listVehAsigPreInv1[$i+2]-$imprimoTIGe1-($imprimoTIG1-$imprimoTIG2)-$imprimoTIG2-($asignados1-$imprimoTIG2);  ?></td><?php } ?>
<?php if ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X2") {?><td align="center">
<? echo $listVehAsigPreInv1[$i+2]-$imprimoTG4e1-($imprimoTG41-$imprimoTG42)-$imprimoTG42-($asignados1-$imprimoTG42);  ?></td> 	<?php } ?>
<?php if ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X4") {?><td align="center">
<? echo $listVehAsigPreInv1[$i+2]-$imprimoT44e1-($imprimoT441-$imprimoT442)-$imprimoT442-($asignados1-$imprimoT442);  ?></td><?php } ?>
<?php } ?>

               <td align="center"><?php echo $campo1; ?></td>
              </tr>
<?php     }
        }
?>
<tr><td colspan="2" align="right" class="cabecera">Total Lote: 15</td>
<td align="center"><? echo $totalEx1; $_SESSION['ex1']=$totalEx1; ?></td>
<td align="center"><? echo $totalEn1; $_SESSION['en1']=$totalEn1; ?></td>
<!--<td align="center"><? echo  $totalAs1; $_SESSION['as1']=$totalAs1;?></td>-->
<td align="center"><font color="red"><? echo  $totalCuenta1-$totalCuenta2; $_SESSION['cta1']=$totalCuenta1-$totalCuenta2;?></font></td>
<td align="center"><? echo $totalCuenta2; $_SESSION['inv1']=$totalCuenta2; ?></td>
<td align="center"><? echo $totalAs1-$totalCuenta2; $_SESSION['camp1']=$totalAs1-$totalCuenta2;?></td>
</tr>

<tr><td><p><p><p><p></td></tr>


<?  } //cierro el else de numlotveh?>
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