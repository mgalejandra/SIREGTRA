<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/inventario.php');
require('../modelos/asignacion.php');
require('../modelos/vehiculos.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,11,15,18,22,23);
	validaAcceso($permitidos,$dir);
	//require ('../modelos/usuarios.php');

  $nroCampos= 7;
  $nroCampos1= 8; //nro de campos de No PDI

  $codmar=$_POST['codmar'];
  $modveh=$_POST['codmodveh'];
  $serveh=$_POST['codserveh'];
  $codpro=$_POST['codpro'];
  $pgActual = $_POST['pagina'];

$objInventario = new inventario();
$objVehiculo = new vehiculos();

$listVehAsigPreInv=$objInventario->reportePreinventario(14);
$_SESSION['listVehAsigPreInv']=$listVehAsigPreInv;
$listVehAsigPreInv1=$objInventario->reportePreinventario(15);
$_SESSION['listVehAsigPreInv1']=$listVehAsigPreInv1;
$listVehAsigPreInv2=$objInventario->reportePreinventario(16);
$_SESSION['listVehAsigPreInv2']=$listVehAsigPreInv2;

/*$listVehAsigPreInv3=$objInventario->reportePreinventario(17);
$_SESSION['listVehAsigPreInv3']=$listVehAsigPreInv3;*/

//$listVehAsigPreInvInicial=$objInventario->reportePreinventarioInicial($desde,$hasta,14);

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
	     " = window.open('reportes/pdf_preInventario.php','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
	}

  function imprimir2() {
	day = new Date();
	id = day.getTime();
	eval("page" + id +
	     " = window.open('reportes/pdf_preInventario_minco.php','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
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
  <legend>Listado de Veh&iacute;culos Asignados - Preinventario -Existencia <?php echo $contArt; ?>
  </legend>
    <table width="90%" align="center" class="detalles" border="0">
    <tr>
  				<td colspan="6" align="right">
			  			<a class="vinculo" target="_blank" onClick="imprimir()" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a>
			      </td>
					<td align="right">Minco
			  			<a class="vinculo" target="_blank" onClick="imprimir2()" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a>
			      </td>

    </tr>
             <tr>
              <td class="cabecera">Lote</td>
              <td class="cabecera">Modelo</td>
			  <td class="cabecera">Existencia Inicial</td>
			  <td class="cabecera">Pre-Inventario</td>
		 <!-- 	  <td class="cabecera">Pre-Prof-Bice</td> -->
		<!--  <td class="cabecera">Pre-Prof-Vzla</td>  -->
		 <!-- 	  <td class="cabecera">Pre-Prof-Indu</td> -->
		 <!-- 	  <td class="cabecera">Pre-Prof-Teso</td> -->
			  <td class="cabecera">Proforma</td>
			  <td class="cabecera">PDI No Aprobado</td>
			  <td class="cabecera">Existencia Inicial - (Pre-proforma + Proforma) - PDI</td>
             </tr>
<?php
        for($i=0;$i<count($listVehAsigPreInv);$i+=$nroCampos){
             if($listVehAsigPreInv[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $listVehAsigPreInv[$i+6];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv[$i+1];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv[$i+2];?></td>
               <td align="center"><?php
               $listVehAsigPreInvInicial=$objInventario->reportePreinventarioInicial($desde,$hasta,14,$listVehAsigPreInv[$i]);
               // echo $listVehAsigPreInv[$i+4];
               echo $listVehAsigPreInvInicial[0];
               ?></td>
              <!--    <td align="center">
               <?php if ($listVehAsigPreInv[$i+1]=="QQ3") echo '5'; if ($listVehAsigPreInv[$i+1]=="X1") echo ''; ?>
               </td> -->
            <!--    <td align="center">
               <?php if ($listVehAsigPreInv[$i+1]=="QQ3") echo ''; if ($listVehAsigPreInv[$i+1]=="X1") echo ''; ?>
               </td> -->
              <!--     <td align="center">
               <?php if ($listVehAsigPreInv[$i+1]=="QQ3") echo '16'; if ($listVehAsigPreInv[$i+1]=="X1") echo ''; ?>
               </td> -->
              <!--    <td align="center">
               <?php if ($listVehAsigPreInv[$i+1]=="QQ3") echo '10-2-5=3'; if ($listVehAsigPreInv[$i+1]=="X1") echo ''; ?>
               </td> -->
               <td align="center"><?php echo $listVehAsigPreInv[$i+3]?></td>
               <? //$listVehNoPDI1=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv1[$i+1],'','','','',-1);
                  $listVehNoPDI=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv[$i],'',14,'','',-1);
                  $cuenta = count($listVehNoPDI)/$nroCampos1;


                  if ($listVehAsigPreInv[$i]=='QQ3')
                  		$imprimoQ = $cuenta;
                  elseif ($listVehAsigPreInv[$i]=='X1')
              			$imprimoX = $cuenta;
                  elseif ($listVehAsigPreInv[$i]=='TIG')
						$imprimoTIG = $cuenta;
                  elseif ($listVehAsigPreInv[$i]=='TG4')
                 		$imprimoTG4 = $cuenta;
                  elseif ($listVehAsigPreInv[$i]=='T44')
                 		$imprimoT44 = $cuenta;
                  ?>
		       <?php if (($listVehAsigPreInv[$i+1]=="X1") or ($listVehAsigPreInv[$i+1]=="TIGGO") or ($listVehAsigPreInv[$i+1]=="QQ3")  or ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X2")  or ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X4")) { ?>
		       <?php if ($listVehAsigPreInv[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQ; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="X1") { ?><td align="center"><? echo $imprimoX; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIG; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG4; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT44; ?></td><?php } ?>

        <?php }  ?>
               <td align="center"><?php echo $listVehAsigPreInv[$i+5];?></td>

              </tr>
<?php     }
        }
?>
<?php
$total=0;
$total1=0;
        for($i=0;$i<count($listVehAsigPreInvInicial);$i+=5){
          if($listVehAsigPreInvInicial[$i]){
             $total+=$listVehAsigPreInvInicial[$i+0];
             $total1+=$listVehAsigPreInvInicial[$i+2];
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $listVehAsigPreInvInicial[$i+0];?> </td>
               <td align="center"><?php echo $listVehAsigPreInvInicial[$i+1];?></td>
               <td align="center"><?php echo FormatoMonto($listVehAsigPreInvInicial[$i+2]);?></td>
              </tr>
<?php     }

        }
?>
<tr><td><p><p></td></tr>
<?php
        for($i=0;$i<count($listVehAsigPreInv1);$i+=$nroCampos){
             if($listVehAsigPreInv1[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $listVehAsigPreInv1[$i+6];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv1[$i+1];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv1[$i+2];?></td>
               <td align="center"><?php
               $listVehAsigPreInvInicial1=$objInventario->reportePreinventarioInicial($desde,$hasta,15,$listVehAsigPreInv1[$i]);
               //echo $listVehAsigPreInv1[$i+4];
               echo $listVehAsigPreInvInicial1[0];

               ?></td>
              <!--    <td align="center">
               <?php if ($listVehAsigPreInv1[$i+1]=="QQ3") echo ''; if ($listVehAsigPreInv1[$i+1]=="X1") echo ''; ?>
               </td> -->
            <!--    <td align="center">
               <?php if ($listVehAsigPreInv1[$i+1]=="QQ3") echo ''; if ($listVehAsigPreInv1[$i+1]=="X1") echo ''; ?>
               </td> -->
              <!--     <td align="center">
               <?php if ($listVehAsigPreInv1[$i+1]=="QQ3") echo ''; if ($listVehAsigPreInv1[$i+1]=="X1") echo ''; ?>
               </td> -->
              <!--    <td align="center">
               <?php if ($listVehAsigPreInv1[$i+1]=="QQ3") echo ''; if ($listVehAsigPreInv1[$i+1]=="X1") echo ''; ?>
               </td> -->
               <td align="center"><?php echo $listVehAsigPreInv1[$i+3]?></td>
               <? //$listVehNoPDI1=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv1[$i+1],'','','','',-1);
                  $listVehNoPDI1=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv[$i],'',15,'','',-1);
                  $cuenta1 = count($listVehNoPDI1)/$nroCampos1;


                  if ($listVehAsigPreInv1[$i]=='QQ3')
                  		$imprimoQ1 = $cuenta1;
                  elseif ($listVehAsigPreInv1[$i]=='X1')
              			$imprimoX1 = $cuenta1;
                  elseif ($listVehAsigPreInv1[$i]=='TIG')
						$imprimoTIG1 = $cuenta1;
                  elseif ($listVehAsigPreInv1[$i]=='TG4')
                 		$imprimoTG41 = $cuenta1;
                  elseif ($listVehAsigPreInv1[$i]=='T44')
                 		$imprimoT441 = $cuenta1;
                  ?>
		       <?php if (($listVehAsigPreInv1[$i+1]=="X1") or ($listVehAsigPreInv1[$i+1]=="TIGGO") or ($listVehAsigPreInv1[$i+1]=="QQ3")  or ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X2")  or ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X4")) { ?>
		       <?php if ($listVehAsigPreInv1[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQ1; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="X1") { ?><td align="center"><? echo $imprimoX1; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIG1; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG41; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT441; ?></td><?php } ?>

        <?php } ?>

               <td align="center"><?php echo $listVehAsigPreInv1[$i+5];?></td>

              </tr>
<?php     }
        }
?>
<tr><td><p><p></td></tr>
<?php  //LOTE 16
        for($i=0;$i<count($listVehAsigPreInv2);$i+=$nroCampos){
             if($listVehAsigPreInv2[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $listVehAsigPreInv2[$i+6];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv2[$i+1];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv2[$i+2];?></td>
               <td align="center"><?php
               $listVehAsigPreInvInicial2=$objInventario->reportePreinventarioInicial($desde,$hasta,16,$listVehAsigPreInv2[$i]);
               //echo $listVehAsigPreInv1[$i+4];
               echo $listVehAsigPreInvInicial2[0];

               ?></td>
              <!--    <td align="center">
               <?php if ($listVehAsigPreInv2[$i+1]=="QQ3") echo ''; if ($listVehAsigPreInv2[$i+1]=="X1") echo ''; ?>
               </td> -->
            <!--    <td align="center">
               <?php if ($listVehAsigPreInv2[$i+1]=="QQ3") echo ''; if ($listVehAsigPreInv2[$i+1]=="X1") echo ''; ?>
               </td> -->
              <!--     <td align="center">
               <?php if ($listVehAsigPreInv2[$i+1]=="QQ3") echo ''; if ($listVehAsigPreInv2[$i+1]=="X1") echo ''; ?>
               </td> -->
              <!--    <td align="center">
               <?php if ($listVehAsigPreInv2[$i+1]=="QQ3") echo ''; if ($listVehAsigPreInv2[$i+1]=="X1") echo ''; ?>
               </td> -->
               <td align="center"><?php echo $listVehAsigPreInv2[$i+3]?></td>
               <? //$listVehNoPDI1=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv1[$i+1],'','','','',-1);
                  $listVehNoPDI2=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv[$i],'',16,'','',-1);
                  $cuenta2 = count($listVehNoPDI2)/$nroCampos1;


                  if ($listVehAsigPreInv2[$i]=='QQ3')
                  		$imprimoQ2 = $cuenta2;
                  elseif ($listVehAsigPreInv2[$i]=='X1')
              			$imprimoX2 = $cuenta2;
                  elseif ($listVehAsigPreInv2[$i]=='TIG')
						$imprimoTIG2 = $cuenta2;
                  elseif ($listVehAsigPreInv2[$i]=='TG4')
                 		$imprimoTG42 = $cuenta2;
                  elseif ($listVehAsigPreInv2[$i]=='T44')
                 		$imprimoT442 = $cuenta2;
                  ?>
		       <?php if (($listVehAsigPreInv2[$i+1]=="X1") or ($listVehAsigPreInv2[$i+1]=="TIGGO") or ($listVehAsigPreInv2[$i+1]=="QQ3")  or ($listVehAsigPreInv2[$i+1]=="GRAND TIGER 4X2")  or ($listVehAsigPreInv2[$i+1]=="GRAND TIGER 4X4")) { ?>
		       <?php if ($listVehAsigPreInv2[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQ2; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv2[$i+1]=="X1") { ?><td align="center"><? echo $imprimoX2; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInv2[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIG2; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv2[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG42; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv2[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT442; ?></td><?php } ?>

        <?php } ?>

               <td align="center"><?php echo $listVehAsigPreInv2[$i+5];?></td>

              </tr>
<?php     }
        }
?>
    </table>
    </fieldset>
<!-- </fieldset>
  </legend>
   <fieldset class="form">
  <legend>Listado de Veh&iacute;culos Asignados - Preinventario  - Inicial <?php echo $contArt; ?>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">Cantidad</td>
			  <td class="cabecera">Modelo</td>
			  <td class="cabecera">Total</td>
             </tr>
<?php
$totalA=0;
$total1A=0;
        for($i=0;$i<count($listVehAsigPreInvInicial1);$i+=5){
          if($listVehAsigPreInvInicial1[$i]){
             $totalA+=$listVehAsigPreInvInicial1[$i+0];
             $total1A+=$listVehAsigPreInvInicial1[$i+2];
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $listVehAsigPreInvInicial1[$i+0];?> </td>
               <td align="center"><?php echo $listVehAsigPreInvInicial1[$i+1];?></td>
               <td align="center"><?php echo FormatoMonto($listVehAsigPreInvInicial1[$i+2]);?></td>
              </tr>
<?php     }

        }
?>
             <tr >
               <td align="center" class="cabecera"><?php echo $totalA; ?> </td>
               <td align="center" class="cabecera"><?php echo "TOTAL";?></td>
               <td align="center" class="cabecera"><?php echo FormatoMonto($total1A);?></td>
             </tr>
    </table>
 </fieldset>
  </legend>-->
<BR>
<!--<input name="Botn" type="button" onclick="imprimir()" value="Imprimir" class="btn btnprint">-->
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