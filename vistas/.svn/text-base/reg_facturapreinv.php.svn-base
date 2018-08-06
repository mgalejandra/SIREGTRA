<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/factura.php');
require('../modelos/pago.php');

$objFactura = new factura();
$objPago 		= new pago();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,11,13,17);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];
$codproa=$_POST['codproa'];
$banco=$_POST['banco'];
$preinv=$_POST['idPreInv'];
$tipo=$_GET['tip'];
$indErr = false;


  $sercarveh=$_POST['sercarveh'];
  $idAsig=$_POST['idAsig'];
  $placa=$_POST['placa'];
  $iva=$_POST['iva'];
  $pago=$_POST['pago'];
  $coment=$_POST['observacion'];

	$listarBancos=$objPago->listarBancos(3);

if ($_GET['idfactura']) $idfactura=$_GET['idfactura'];


$datos = array($idAsig,$sercarveh,$placa,$iva,$pago,$banco,$preinv);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

if ($idfactura or $indReg!=2)  {
	$ban=1;
	$i=0;
	//echo 'entro';
	$listarFactura=$objFactura->listarFacturas($idfactura,'','','',-1,'','',$tipo);
	$_SESSION['idfactura']=$listarFactura[0];
}

if ($indReg==1){
	$ban=1;
	$i=0;

   if ($preinv)
		$listarFactura=$objFactura->listarFactPreProf($idAsig);
   else
   		$listarFactura=$objFactura->listarFacturas('',$sercarveh,'','',-1,'','',$tipo);

   if ($listarFactura[0]!=''){
	     echo "<script>alert('El ciudadano: ".$listarFactura[6]." tiene asignada la factura: ".$listarFactura[0]."');</script>";
	     //echo "<SCRIPT>window.location.href='listado_asignacion.php';</SCRIPT>";
	     if (($pago=='CREDITO' and  $listarFactura[6]=='CREDITO' )  or ($pago=='COMPLETO' and  $listarFactura[6]=='COMPLETO' ))
	     // if ($pago=='CREDITO' and  ($listarFactura[6]=='CREDITO' OR  $listarFactura[6]=='COMPLETO'))
	     	if ($preinv)
	     		echo "<SCRIPT>window.location.href='det_factura_suvinca.php?idfactura=$listarFactura[0]&preinv=$preinv';</SCRIPT>";
	     	else
	 	    	echo "<SCRIPT>window.location.href='det_factura_suvinca.php?idfactura=$listarFactura[0]';</SCRIPT>";
	}
	else
    	$registro = $objFactura->registrarFactura($datos,$codproa,$coment);



	if ($registro)  {
		 echo "<script>alert('Factura Registrada');</script>";
		 if ($preinv)
		 	echo '<SCRIPT> window.open("../vistas/reportes/pdffacturapreinv.php?idfactura='.$registro.'&preinv='.$preinv.' " , "ventana1" , "width=600,height=600,scrollbars=NO") </SCRIPT>';
		 else
		 	echo '<SCRIPT> window.open("../vistas/reportes/pdffactura.php?idfactura='.$registro.' " , "ventana1" , "width=600,height=600,scrollbars=NO") </SCRIPT>';
		 if (($pago=='CREDITO') OR ($pago=='COMPLETO'))
		 {
		 	if ($preinv)
		 	 	echo "<SCRIPT>window.location.href='det_factura_suvinca.php?idfactura=$registro&preinv=$preinv';</SCRIPT>";
		 	else
		 		echo "<SCRIPT>window.location.href='det_factura_suvinca.php?idfactura=$registro';</SCRIPT>";
		 }
		 else
	        echo "<SCRIPT>window.location.href='det_factura_suvincaC.php?idfactura=$registro';</SCRIPT>";
	}
}

if ($indReg==2){

    $modificar = $objFactura->AnularFactura($_SESSION['idfactura']);

	if ($modificar)   {
	     echo "<script>alert('Factura Anulada');</script>";
		 echo "<SCRIPT>window.location.href='listado_factura.php';</SCRIPT>";
	}else echo "<script>alert('No se pudo Anulada la Factura ');</script>";
}

if (!$_GET['idfactura']) { $ban=0; $listarFactura=null;}
?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>


function validarCaract(dato){


if (document.form1.sercarveh.value.length==0){
    alert("Debe Ingresar un N° de serial de Carroceria");
    document.form1.sercarveh.focus()
    return (false);
                                      }

 if (document.form1.banco.value.length==0 && document.form1.pago.value=='CREDITO'){
    alert("Debe seleccionar el banco");
    document.form1.banco.focus()
    return (false);
                                      }

 if (document.form1.banco.value.length==0 && document.form1.pago.value=='COMPLETO'){
    alert("Debe seleccionar el banco");
    document.form1.banco.focus()
    return (false);
                                      }


  if (document.form1.pago.value=='COMPLETO' && document.form1.observacion.value.length==0){
    alert("Debe indicar en el Comentario el banco que aprobo el credito y la institucion a la que pertenece el beneficiario");
    document.form1.observacion.focus()
    return (false);
  }

 document.form1.indReg.value = dato;
 document.form1.submit();

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
  <form id="form1" name="form1" method="post" action="">
  <table class="formulario" width="822" border="0" align="center" >
      <tr>
        <td colspan="4" class="cabecera">Factura Pre-Proforma</td>
      </tr>
     <tr>
        <td class="categoria">Vehiculo:	</td>
        <td class="dato">
         <input name="sercarveh" type="text" id="sercarveh" maxlength="18" value="<?php if($ban==1)  echo $listarFactura[$i+2];?>" readonly=""/>
         <input type="button" onclick="catalogoAncho('cat_asignacionpreinv.php');" value="..."/>
        </td>
      <!--   <td class="categoria">Beneficiario: </td>
        <td class="dato">
	        <input name="beneficario" type="text" id="beneficario" value="<?php if($ban==1)  echo $listarFactura[$i+9];?>" size="20" maxlength="10" readonly="" />
	        <input type="hidden" name="idAsig" id="idAsig" value="<?php if($ban==1)  echo $listarFactura[$i+1];?>">-->

	    <td class="categoria">C.I/RIF:</td>
        <td class="dato">
         <input name="codproa" type="text" id="codproa" maxlength="18" value="<?php if($ban==1)  echo $listarAsignacion[$i+1];?>" readonly=""/>
        </td>
      </tr>
      <tr>
        <td class="categoria">Monto Placas:	</td>
        <td class="dato">
           <input name="placa" type="text" id="placa" maxlength="18" value="<?php $montoplaca=401.50; if($ban==1)  echo $listarFactura[$i+3]; else echo $montoplaca;?>" onkeypress="return acessoDecimal(event)" />
        </td>
         <td class="categoria">Iva: </td>
        <td class="dato">
	        <input name="iva" type="text" id="iva" value="<?php if($ban==1)  echo $listarFactura[$i+5]; else echo '12';?>" size="4" maxlength="4" />%
        </td>
      </tr>
      <tr>
        <td class="categoria">Condici&oacute;n de Pago:</td>
<td>
        <select name="pago" id="pago">
            <option value="CREDITO">CREDITO</option>
            <option value="CONTADO">CONTADO</option>
            <option value="COMPLETO">100 POR CIENTO</option>
          </select>
        </td>
         <td class="categoria">Banco:</td>
        <td class="dato" colspan="3">
         	 <SELECT id="banco" name="banco">
				<?php if($ban==1)  echo " <option value=".$listarFactura[$i+13].">".$listarFactura[$i+16]."</option>"; else {?>
					<OPTION value=""></OPTION>
			    <?php } for($i=0;$i<count($listarBancos);$i+=2){  ?>
	               <option value="<?php echo $listarBancos[$i]; ?>"><?php echo $listarBancos[$i+1]?></option>
	           <?php } ?>
			 </SELECT>
        </td>
      </tr>
        <tr><td class="categoria">Observaci&oacute;n:</td>
      <td  colspan="3"><textarea name="observacion" cols="60" rows="2" id="observacion"  onblur="javascript:this.value=this.value.toUpperCase()" ><?php if($ban==1)  echo $listarFactura[$i+5];?></textarea>
</td>
      </tr>
      <tr>
        <td height="22" colspan="4">
          <div align="center">
           <input type="hidden" name="indReg" >
           <input type="hidden" name="idPreInv" id="idPreInv" >
           <input type="hidden" name="idAsig" id="idAsig" >
           <?php if (!$idfactura) { ?>
            <input  type="button" onclick="validarCaract(1); return false" value="Generar" />
            <?php } if ($idfactura) { ?>
           <!-- <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Anular" />-->
            <input name="listar" type="button" id="listar" onclick="window.location.href='det_factura.php?idfactura=<?php echo $idfactura?>'" value="Ver Detalle" />
            <?php } ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_factura.php'" value="Listar" />
         </div>
     </tr>
 </table>
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