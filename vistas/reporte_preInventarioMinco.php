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
	$permitidos = array(1,2,3,4,5,11,15,18,22,20);
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
	$listVehAsigPreInv3=$objInventario->reportePreinventarioC(17);
	$_SESSION['listVehAsigPreInv3']=$listVehAsigPreInv3;
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
			  <td class="cabecera">Asignados</td>
			  <td class="cabecera">PDI No Aprobado</td>
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

               <td align="center"><?php
               /*$listVehAsigPreInvInicialL=$objInventario->reportePreinventarioInicial($desde,$hasta,$numlotveh,$listVehAsigPreInvL[$i]);
               $proformasL = $listVehAsigPreInvL[$i+3];
               // echo $listVehAsigPreInv[$i+4];
               $preproformasL= $listVehAsigPreInvInicialL[0];

               $asignadosL= $preproformasL + $proformasL;*/

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
      	for($i=0;$i<count($listVehAsigPreInv);$i+=$nroCampos){
             if($listVehAsigPreInv[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $listVehAsigPreInv[$i+7];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv[$i+1];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv[$i+2];  $existencia= $listVehAsigPreInv[$i+2];   ?></td>
               <?
                  $listVehEnt14=$objEntrega->contarEntregasChery(14,$listVehAsigPreInv[$i]);
				  $_SESSION['listVehEnt14']=$listVehEnt14;

                  $totalEx+=$existencia;
                  $totalEn+=$listVehEnt14;



                  if ($listVehAsigPreInv[$i]=='QQ3')
                  		$imprimoQe = $listVehEnt14;
                  elseif ($listVehAsigPreInv[$i]=='X1')
              			$imprimoXe = $listVehEnt14;
                  elseif ($listVehAsigPreInv[$i]=='TIG')
						$imprimoTIGe = $listVehEnt14;
                  elseif ($listVehAsigPreInv[$i]=='TG4')
                 		$imprimoTG4e = $listVehEnt14;
                  elseif ($listVehAsigPreInv[$i]=='T44')
                 		$imprimoT44e = $listVehEnt14;

                 		$campo= $existencia - $listVehEnt14;

                 		$totalCamp+=$campo;
                  ?>
		       <?php if (($listVehAsigPreInv[$i+1]=="X1") or ($listVehAsigPreInv[$i+1]=="TIGGO") or ($listVehAsigPreInv[$i+1]=="QQ3")  or ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X2")  or ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X4")) { ?>
		       <?php if ($listVehAsigPreInv[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQe; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="X1") { ?><td align="center"><? echo  $imprimoXe; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIGe; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG4e; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT44e; ?></td><?php } ?>

        <?php }  ?>

               <td align="center"><?php
              // $listVehAsigPreInvInicial=$objInventario->reportePreinventarioInicial($desde,$hasta,14,$listVehAsigPreInv[$i]);
              // $proformas = $listVehAsigPreInv[$i+3];
               // echo $listVehAsigPreInv[$i+4];
              // $preproformas= $listVehAsigPreInvInicial[0];

                 $asignados= ($listVehAsigPreInv[$i+4] + $listVehAsigPreInv[$i+5])-$listVehAsigPreInv[$i+6];
			     echo $asignados;
			   //echo $asignados.'aqui';

			   $totalAs+=$asignados;
               ?></td>
               <? //$listVehNoPDI1=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv1[$i+1],'','','','',-1);
                  $listVehNoPDI=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv[$i],'',14,'','',-1);
                  $cuenta = count($listVehNoPDI)/8;
				  $totalCuenta+=$cuenta;

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
        <?php }

        		//$sumoB = $sumoA + $cuenta;
        ?>
               <td align="center"><?php echo $listVehAsigPreInv[$i+3];   $totalInv+=$listVehAsigPreInv[$i+3]; ?></td>

               <td align="center"><?php echo $campo; //$campo = $existencia - $sumoC; ?></td>
              </tr>
<?php     }
        }
?>
<tr><td colspan="2" align="right" class="cabecera">Total Lote: 14</td>
<td align="center"><? echo $totalEx; $_SESSION['ex']=$totalEx; ?></td>
<td align="center"><? echo $totalEn; $_SESSION['en']=$totalEn; ?></td>
<td align="center"><? echo  $totalAs; $_SESSION['as']=$totalAs;?></td>
<td align="center"><font color="red"><? echo  $totalCuenta; $_SESSION['cta']=$totalCuenta;?></font></td>
<td align="center"><? echo $totalInv; $_SESSION['inv']=$totalInv; ?></td>
<td align="center"><? echo $totalCamp; $_SESSION['camp']=$totalCamp;?></td>
</tr>
<tr><td><p><p><p><p></td></tr>

<?php
        for($i=0;$i<count($listVehAsigPreInv1);$i+=$nroCampos){
             if($listVehAsigPreInv1[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $listVehAsigPreInv1[$i+7];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv1[$i+1];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv1[$i+2];  $existencia1= $listVehAsigPreInv1[$i+2];  ?></td>
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
		       <?php if (($listVehAsigPreInv1[$i+1]=="X1") or ($listVehAsigPreInv1[$i+1]=="TIGGO") or ($listVehAsigPreInv1[$i+1]=="QQ3")  or ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X2")  or ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X4")) { ?>
		       <?php if ($listVehAsigPreInv1[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQe1; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="X1") { ?><td align="center"><? echo  $imprimoXe1; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIGe1; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG4e1; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT44e1; ?></td><?php } ?>

        <?php }  ?>

               <td align="center"><?php
               $asignados1= ($listVehAsigPreInv1[$i+4] + $listVehAsigPreInv1[$i+5])-$listVehAsigPreInv1[$i+6];
			   echo $asignados1;

			   $totalAs1+=$asignados1;
               ?></td>
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
		       <?php if (($listVehAsigPreInv1[$i+1]=="X1") or ($listVehAsigPreInv1[$i+1]=="TIGGO") or ($listVehAsigPreInv1[$i+1]=="QQ3")  or ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X2")  or ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X4")) { ?>
		       <?php if ($listVehAsigPreInv1[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQ1; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="X1") { ?><td align="center"><? echo $imprimoX1; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIG1; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG41; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv1[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT441; ?></td><?php } ?>
        <?php }

        		//$sumoB1 = $sumoA1 + $cuenta1;
        ?>
               <td align="center"><?php echo $listVehAsigPreInv1[$i+3];  $totalInv1+=$listVehAsigPreInv1[$i+3]; ?></td>

               <td align="center"><?php echo $campo1; ?></td>
              </tr>
<?php     }
        }
?>
<tr><td colspan="2" align="right" class="cabecera">Total Lote: 15</td>
<td align="center"><? echo $totalEx1; $_SESSION['ex1']=$totalEx1; ?></td>
<td align="center"><? echo $totalEn1; $_SESSION['en1']=$totalEn1; ?></td>
<td align="center"><? echo  $totalAs1; $_SESSION['as1']=$totalAs1;?></td>
<td align="center"><font color="red"><? echo  $totalCuenta1; $_SESSION['cta1']=$totalCuenta1;?></font></td>
<td align="center"><? echo $totalInv1; $_SESSION['inv1']=$totalInv1; ?></td>
<td align="center"><? echo $totalCamp1; $_SESSION['camp1']=$totalCamp1;?></td>
</tr>

<tr><td><p><p><p><p></td></tr>

<?php
        for($i=0;$i<count($listVehAsigPreInv2);$i+=$nroCampos){
             if($listVehAsigPreInv2[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $listVehAsigPreInv2[$i+7];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv2[$i+1];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv2[$i+2];  $existencia2= $listVehAsigPreInv2[$i+2];  ?></td>
               <?
   				  $listVehEnt16=$objEntrega->contarEntregasChery(16,$listVehAsigPreInv2[$i]);
				  $_SESSION['listVehEnt16']=$listVehEnt16;

				  $totalEx2+=$existencia2;
                  $totalEn2+=$listVehEnt16;

                  if ($listVehAsigPreInv2[$i]=='QQ3')
                  		$imprimoQe2 = $listVehEnt16;
                  elseif ($listVehAsigPreInv2[$i]=='X1')
              			$imprimoXe2 = $listVehEnt16;
                  elseif ($listVehAsigPreInv2[$i]=='TIG')
						$imprimoTIGe2 = $listVehEnt16;
                  elseif ($listVehAsigPreInv2[$i]=='TG4')
                 		$imprimoTG4e2 = $listVehEnt16;
                  elseif ($listVehAsigPreInv2[$i]=='T44')
                 		$imprimoT44e2 = $listVehEnt16;

                 		$campo2= $existencia2 - $listVehEnt16;

                 		$totalCamp2+=$campo2;
                  ?>
		       <?php if (($listVehAsigPreInv2[$i+1]=="X1") or ($listVehAsigPreInv2[$i+1]=="TIGGO") or ($listVehAsigPreInv2[$i+1]=="QQ3")  or ($listVehAsigPreInv2[$i+1]=="GRAND TIGER 4X2")  or ($listVehAsigPreInv2[$i+1]=="GRAND TIGER 4X4")) { ?>
		       <?php if ($listVehAsigPreInv2[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQe2; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv2[$i+1]=="X1") { ?><td align="center"><? echo  $imprimoXe2; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInv2[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIGe2; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv2[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG4e2; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv2[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT44e2; ?></td><?php } ?>

        <?php }  ?>

               <td align="center"><?php
               $asignados2= ($listVehAsigPreInv2[$i+4] + $listVehAsigPreInv2[$i+5])-$listVehAsigPreInv2[$i+6];
			   echo $asignados2;

			   $totalAs2+=$asignados2;
               ?></td>
               <? //$listVehNoPDI1=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv1[$i+1],'','','','',-1);
                  $listVehNoPDI2=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv2[$i],'',16,'','',-1);
                  $cuenta2 = count($listVehNoPDI2)/8;

                   $totalCuenta2+=$cuenta2;
                  if ($listVehAsigPreInv2[$i]=='QQ3')
                  		$imprimoQ2 = $cuenta2;
                  elseif ($listVehAsigPreInv2[$i]=='X1')
              			$imprimoX2 = $cuenta2;
                  elseif ($listVehAsigPreInv2[$i]=='TIG')
						$imprimoTIG2 = $cuenta2;
                  elseif ($listVehAsigPreInv2[$i]=='TG4')
                 		$imprimoTG42 = $cuenta2;
                  elseif ($listVehAsigPreInv2[$i]=='T44')
                 		$imprimoT442= $cuenta2;
                  ?>
		       <?php if (($listVehAsigPreInv2[$i+1]=="X1") or ($listVehAsigPreInv2[$i+1]=="TIGGO") or ($listVehAsigPreInv2[$i+1]=="QQ3")  or ($listVehAsigPreInv2[$i+1]=="GRAND TIGER 4X2")  or ($listVehAsigPreInv2[$i+1]=="GRAND TIGER 4X4")) { ?>
		       <?php if ($listVehAsigPreInv2[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQ2; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv2[$i+1]=="X1") { ?><td align="center"><? echo $imprimoX2; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInv2[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIG2; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv2[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG42; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv2[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT442; ?></td><?php } ?>
        <?php }

        		//$sumoB1 = $sumoA1 + $cuenta1;
        ?>
               <td align="center"><?php echo $listVehAsigPreInv2[$i+3];  $totalInv2+=$listVehAsigPreInv2[$i+3]; ?></td>

               <td align="center"><?php echo $campo2; ?></td>
              </tr>
<?php     }
        }
?>
<tr><td colspan="2" align="right" class="cabecera">Total Lote: 16</td>
<td align="center"><? echo $totalEx2; $_SESSION['ex2']=$totalEx2; ?></td>
<td align="center"><? echo $totalEn2; $_SESSION['en2']=$totalEn2; ?></td>
<td align="center"><? echo  $totalAs2; $_SESSION['as2']=$totalAs2;?></td>
<td align="center"><font color="red"><? echo  $totalCuenta2; $_SESSION['cta2']=$totalCuenta2;?></font></td>
<td align="center"><? echo $totalInv2; $_SESSION['inv2']=$totalInv2; ?></td>
<td align="center"><? echo $totalCamp2; $_SESSION['camp2']=$totalCamp2;?></td>
</tr>



<tr><td><p><p><p><p></td></tr>

<?php
        for($i=0;$i<count($listVehAsigPreInv3);$i+=$nroCampos){
             if($listVehAsigPreInv3[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $listVehAsigPreInv3[$i+7];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv3[$i+1];?> </td>
               <td align="center"><?php echo $listVehAsigPreInv3[$i+2];  $existencia3= $listVehAsigPreInv3[$i+2];  ?></td>
               <?
   				  $listVehEnt17=$objEntrega->contarEntregasChery(17,$listVehAsigPreInv3[$i]);
				  $_SESSION['listVehEnt17']=$listVehEnt17;

				  $totalEx3+=$existencia3;
                  $totalEn3+=$listVehEnt17;

                  if ($listVehAsigPreInv3[$i]=='QQ3')
                  		$imprimoQe3 = $listVehEnt17;
                  elseif ($listVehAsigPreInv3[$i]=='X1')
              			$imprimoXe3 = $listVehEnt17;
                  elseif ($listVehAsigPreInv3[$i]=='TIG')
						$imprimoTIGe3 = $listVehEnt17;
                  elseif ($listVehAsigPreInv3[$i]=='TG4')
                 		$imprimoTG4e3 = $listVehEnt17;
                  elseif ($listVehAsigPreInv3[$i]=='T44')
                 		$imprimoT44e3 = $listVehEnt17;

                 		$campo3= $existencia3 - $listVehEnt17;

                 		$totalCamp3+=$campo3;
                  ?>
		       <?php if (($listVehAsigPreInv3[$i+1]=="X1") or ($listVehAsigPreInv3[$i+1]=="TIGGO") or ($listVehAsigPreInv3[$i+1]=="QQ3")  or ($listVehAsigPreInv3[$i+1]=="GRAND TIGER 4X2")  or ($listVehAsigPreInv3[$i+1]=="GRAND TIGER 4X4")) { ?>
		       <?php if ($listVehAsigPreInv3[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQe3; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv3[$i+1]=="X1") { ?><td align="center"><? echo  $imprimoXe3; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInv3[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIGe3; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv3[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG4e3; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv3[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT44e3; ?></td><?php } ?>

        <?php }  ?>

               <td align="center"><?php
               $asignados3= ($listVehAsigPreInv3[$i+4] + $listVehAsigPreInv3[$i+5])-$listVehAsigPreInv3[$i+6];
			   echo $asignados3;

			   $totalAs3+=$asignados3;
               ?></td>
               <?
                  $listVehNoPDI3=$objVehiculo->listVehNoPDI('',$listVehAsigPreInv3[$i],'',17,'','',-1);
                  $cuenta3 = count($listVehNoPDI3)/8;

                   $totalCuenta3+=$cuenta3;
                  if ($listVehAsigPreInv3[$i]=='QQ3')
                  		$imprimoQ3 = $cuenta3;
                  elseif ($listVehAsigPreInv3[$i]=='X1')
              			$imprimoX3 = $cuenta3;
                  elseif ($listVehAsigPreInv3[$i]=='TIG')
						$imprimoTIG3 = $cuenta3;
                  elseif ($listVehAsigPreInv3[$i]=='TG4')
                 		$imprimoTG43 = $cuenta3;
                  elseif ($listVehAsigPreInv3[$i]=='T44')
                 		$imprimoT443= $cuenta3;
                  ?>
		       <?php if (($listVehAsigPreInv3[$i+1]=="X1") or ($listVehAsigPreInv3[$i+1]=="TIGGO") or ($listVehAsigPreInv3[$i+1]=="QQ3")  or ($listVehAsigPreInv3[$i+1]=="GRAND TIGER 4X2")  or ($listVehAsigPreInv3[$i+1]=="GRAND TIGER 4X4")) { ?>
		       <?php if ($listVehAsigPreInv3[$i+1]=="QQ3") { ?><td align="center"><? echo $imprimoQ3; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv3[$i+1]=="X1") { ?><td align="center"><? echo $imprimoX3; ?></td> <?php } ?>
               <?php if ($listVehAsigPreInv3[$i+1]=="TIGGO") { ?><td align="center"><? echo $imprimoTIG3; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv3[$i+1]=="GRAND TIGER 4X2") { ?><td align="center"><? echo $imprimoTG43; ?></td><?php } ?>
               <?php if ($listVehAsigPreInv3[$i+1]=="GRAND TIGER 4X4") { ?><td align="center"><? echo $imprimoT443; ?></td><?php } ?>
        <?php }

        		//$sumoB1 = $sumoA1 + $cuenta1;
        ?>
               <td align="center"><?php echo $listVehAsigPreInv3[$i+3];  $totalInv3+=$listVehAsigPreInv3[$i+3]; ?></td>

               <td align="center"><?php echo $campo3; ?></td>
              </tr>
<?php     }
        }
?>
<tr><td colspan="2" align="right" class="cabecera">Total Lote: 17</td>
<td align="center"><? echo $totalEx3; $_SESSION['ex3']=$totalEx3; ?></td>
<td align="center"><? echo $totalEn3; $_SESSION['en3']=$totalEn3; ?></td>
<td align="center"><? echo  $totalAs3; $_SESSION['as3']=$totalAs3;?></td>
<td align="center"><font color="red"><? echo  $totalCuenta3; $_SESSION['cta3']=$totalCuenta3;?></font></td>
<td align="center"><? echo $totalInv3; $_SESSION['inv3']=$totalInv3; ?></td>
<td align="center"><? echo $totalCamp3; $_SESSION['camp3']=$totalCamp3;?></td>
</tr>

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