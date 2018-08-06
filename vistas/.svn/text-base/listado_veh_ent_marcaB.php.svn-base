<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/reportes.php');
require('../modelos/pago.php');
require('../modelos/banco.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(1,2,10);
	validaAcceso($permitidos,$dir);

$objVehM  = new reportes();
$objPago  = new pago();
$objBanco = new banco();

  $acto      = $_POST['actveh'];
  $modelo = $_POST['codmodveh'];
  $marca = $_POST['codmar'];
  $banco = $_POST['banco'];

$nroFilas = 20;

if ($acto)
	$nroCampos = 10;
else
	$nroCampos = 8;

$listado=$objVehM->reporteEntGral($acto,$modelo,$marca,$_SESSION['idBanco']);

$listarBancos=$objPago->listarBancos(3);

if ($banco) $nombreB = $objBanco->listarBancos($banco);
$_SESSION['nomban']=$nombreB[2];
?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>

function enviar(dato){
 document.registro.pagina.value = 0;
 document.registro.indBusq.value = dato;
}


 function imprimir() {
  day = new Date();
  id = day.getTime();
  eval("page" + id +
  	   " = window.open('reportes/listDepositos.php','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
  }

function abrir(campo)
{
pagina=campo;
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=500,resizable=yes,left=50,top=50");
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
     <table id="tabla1" name="tabla1" align="center" >
     <tr>
         <td  class="categoria">Acto:</td>
          <td align="left">
             <input name="desacto" type="text" id="desacto" value="<?php echo $numlotveh ?>" size="20" maxlength="3" readonly=""/>
             <input type="hidden" name="actveh" id="actveh"/>
             <input type="button" onclick="catalogo('cat_acto.php');" value="..." />
          </td>
        <td class="categoria">Marca:</td>
        <td class="dato">
	        <input name="codmar" type="hidden" id="codmar"  value="<?php if($ban==1)  echo $listCarac[$i+22];?>" />
	        <input name="desmar" type="text" id="desmar"  value="<?php if($ban==1)  echo $listCarac[$i+2];?>" size="20" maxlength="3" readonly=""/>
	        <input name="marca" type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
        </td>
        <td class="categoria">Modelo :</td>
        <td>
          <input name="codmodveh" type="hidden" id="codmodveh" value="<?php if($ban==1)  echo $listCarac[$i+23];?>" size="20" maxlength="15"/>
          <input name="modveh" type="text" id="modveh" value="<?php if($ban==1)  echo $listCarac[$i+3];?>" size="20" maxlength="15" readonly=""/>
          <input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." />
        </td>
      </tr>
      <tr>
            <td align="center" colspan="10">
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" value="Limpiar" onclick="enviar(2)"/>
			</td>
			</tr>
			<tr><td>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden" name="indReg">
		    <INPUT type="hidden" name="contiTem" id="contiTem">
           </td></tr>
  </table>
  </fieldset>

 <fieldset class="form">
  <legend>Lista de Veh&iacute;culos Entregados por Marca
  </legend>
    <table id="tabla2" name="tabla2" width="70%" align="center" class="detalles">
     <tr><td colspan="8" align="right"><a class="vinculo" target="_blank" onClick="abrir('reportes/pdfVehEntMarca.php?act=<? echo $acto ?>&mar=<? echo $marca ?>&mod=<? echo $modelo ?>&ban=<? echo $banco ?>');" />
  <IMG title="PDF" src="botones/pdf.png" height="15" ></a></td></tr>

             <?
	     	     if ($nroCampos==10) $titulo = $listado[9]." el día ".$listado[8];
                   else $titulo = "TODOS LOS ACTOS";


				  echo "<TR class='cabeceraI'><TH colspan='22'>".$titulo."</TH></tr>";
	     	      if ($banco)  echo "<TR class='cabeceraI'><TH colspan='22'>".$nombreB[2]."</TH></tr>";
     	     ?>
            <tr>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
              <td class="cabecera">Cantidad</td>
              <td class="cabecera">Precio</td>
              <td class="cabecera">Total</td>
              <td class="cabecera">Monto Inicial</td>
              <td class="cabecera">Monto Financiado</td>
              <td class="cabecera">% Tasa Promedio</td>
            <tr>

<?php
		$montoTotal= 0;
		$contRemision=count($listado)/$nroCampos;


		for($i=0;$i<count($listado);$i+=$nroCampos){

			 $tasa = ($listado[$i+6])/($listado[$i+2]);
?>
              <tr id="dep<?=$i?>" class="datosimpar">
               <td align="center"><?= $listado[$i]?></td>
			   <td align="center"><?= $listado[$i+1]?></td>
               <td align="center"><?= $listado[$i+2]?></td>
               <td align="right"><?= FormatoMonto($listado[$i+3])?></td>
               <td align="right"><?= FormatoMonto($listado[$i+4])?></td>
               <td align="right"><?= FormatoMonto($listado[$i+7])?></td>
               <td align="right"><?= FormatoMonto($listado[$i+5])?></td>
               <td align="right"><? echo $tasa;?></td>
		       </tr>

		<?   $total+=$listado[$i+4];
	 	    $montoinic+=$listado[$i+7];
			$montofin+=$listado[$i+5];

		   }?>
   <tr>
              <td class="cabecera" colspan="4" align="right">Totales</td>
              <td class="cabecera"><? echo FormatoMonto($total); $_SESSION['tot']=$total;?></td>
              <td class="cabecera"><? echo FormatoMonto($montoinic); $_SESSION['montin']=$montoinic;?></td>
              <td class="cabecera"><? echo FormatoMonto($montofin); $_SESSION['montfin']=$montofin;?></td>
              <td class="cabecera"></td>
            <tr>
   <tr>
   <td colspan=3> <?= 'Total: '.$contRemision.' marcas'?></td>
   </tr>
    </table>
</fieldset>
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