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
$tipo=$_GET['tip'];
$indErr = false;


  $sercarveh=$_POST['sercarveh'];
  $idAsig=$_POST['idAsig'];
  $placa=$_POST['placa'];
  $iva=$_POST['iva'];
  $pago=$_POST['pago'];
 // $coment=$_POST['comentario'];
  $coment=$_POST['observacion'];


	$listarBancos=$objPago->listarBancos(3);
	//$listarFactura=$objFactura->listarFacturas($idfactura);

if ($_GET['idfactura'])   $idfactura=$_GET['idfactura'];
	/*$listarFactura=$objFactura->listarFacturas($idfactura,'','','',-1,'','','');
	echo 'entro en get';}*/


$datos = array($idAsig,$sercarveh,$placa,$iva,$pago,$banco);
$datos2 = array($idAsig,$sercarveh,$placa,$iva,$pago,$banco,$coment);

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

if ($idfactura or $indReg!=2)  {
	$ban=1;
	$i=0;
	//echo 'entro';
	$listarFactura=$objFactura->listarFacturas($idfactura,$sercarveh,'','',-1,'','','');
	//$listarFactura=$objFactura->listarFacturas($idfactura,'','','',-1,'','',$tipo,'','','','','','','','','','','','','','','','','','','','','','','','','','','',$coment);
	$_SESSION['idfactura']=$listarFactura[0];
	//echo 'entro en diferente a dos';
}

if ($indReg==1){
	$ban=1;
	$i=0;
	//echo 'entro: '.count($datos);}
	$listarFactura=$objFactura->listarFacturas('',$sercarveh,'','',-1,'','',$tipo);
	//$listarFactura=$objFactura->listarFacturas($idfactura,'','','',-1,'','',$tipo,'','','','','','','','','','','','','','','','','','','','','','','','','','',$coment);

    //echo 'aqui:'.$listPlacas[0];
   if ($listarFactura[0]!=''){
	     echo "<script>alert('el vehículo: ".$listarFactura[2]." tiene asignada la factura: ".$listarFactura[0]."');</script>";
	     //echo "<SCRIPT>window.location.href='listado_asignacion.php';</SCRIPT>";
	     if (($pago=='CREDITO' and  $listarFactura[6]=='CREDITO') OR  ($pago=='COMPLETO' AND $listarFactura[6]=='COMPLETO'))
	     echo "<SCRIPT>window.location.href='det_factura_suvinca.php?idfactura=$listarFactura[0]';</SCRIPT>";
	     else
	     echo "<SCRIPT>window.location.href='det_factura_suvincaC.php?idfactura=$listarFactura[0]';</SCRIPT>";
   }else
     $registro = $objFactura->registrarFactura($datos,$codproa,$coment);



	if ($registro)  {
		 echo "<script>alert('Factura Registrada');</script>";
		 //echo "<SCRIPT>window.location.href='../vistas/reportes/pdffactura.php?idfactura=".$registro."';</SCRIPT>";
		 echo '<SCRIPT> window.open("../vistas/reportes/pdffactura.php?idfactura='.$registro.' " , "ventana1" , "width=600,height=600,scrollbars=NO") </SCRIPT>';
		 if (($pago=='CREDITO') OR ($pago=='COMPLETO'))
		  echo "<SCRIPT>window.location.href='det_factura_suvinca.php?idfactura=$registro';</SCRIPT>";
		    else
	      echo "<SCRIPT>window.location.href='det_factura_suvincaC.php?idfactura=$registro';</SCRIPT>";

	}

	//echo 'entro 1';
}

if ($indReg==2){

    $anular = $objFactura->AnularFactura($_SESSION['idfactura']);

	if ($anular)   {
	     echo "<script>alert('Factura Anulada');</script>";
		 echo "<SCRIPT>window.location.href='listado_factura.php';</SCRIPT>";
	}else echo "<script>alert('No se pudo Anulada la Factura ');</script>";
}

if ($indReg==3){
  if($_SESSION['idfactura']=$listarFactura[0]) {
    $modificar = $objFactura->ModificarFactura($_SESSION['idfactura'],$datos2,$codproa);

	if ($modificar)   {
	     echo "<script>alert('Factura Modificada');</script>";
		 echo "<SCRIPT>window.location.href='listado_factura.php';</SCRIPT>";

					}

	}else {
		echo "<script>alert('No se pudo Modificar la Factura ');</script>";

	echo "<SCRIPT>window.location.href='listado_factura.php';</SCRIPT>";
	}
}

if (!$_GET['idfactura']) { $ban=0; $listarFactura=null;}
?>
<!DOCTYPE HTML PUBLIC >
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

 if (document.form1.pago.value==''){
    alert("Debe seleccionar la condicion de pago");
    document.form1.pago.focus()
    return (false);
                                      }

 if (document.form1.pago.value=='CONTADO'){
    document.form1.banco.value='';
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
        <td colspan="4" class="cabecera">Factura Proforma</td>
      </tr>
     <tr>
        <td class="categoria">Vehiculo:	</td>
        <td class="dato">
         <input name="sercarveh" type="text" id="sercarveh" maxlength="18" value="<?php if($ban==1)  echo $listarFactura[$i+2];?>" readonly=""/>
         <input type="button" onclick="catalogoAncho('cat_asignacion.php');" value="..."/>
        </td>
         <td class="categoria">Beneficiario: </td>
        <td class="dato">
	        <input name="beneficario" type="text" id="beneficario" value="<?php if($ban==1)  echo $listarFactura[$i+9];?>" size="20" maxlength="10" readonly="" />
	        <input type="hidden" name="idAsig" id="idAsig" value="<?php if($ban==1)  echo $listarFactura[$i+1];?>">
        </td>
      </tr>
      <tr>
        <td class="categoria">Monto Placas:	</td>
        <td class="dato">
           <input name="placa" type="text" id="placa" maxlength="18" value="<?php $montoplaca=674.10; if($ban==1)  echo $listarFactura[$i+3]; else echo $montoplaca;?>" onkeypress="return acessoDecimal(event)" />
        </td>
         <td class="categoria">Iva: </td>
        <td class="dato">
	        <input name="iva" type="text" id="iva" value="<?php if($ban==1)  echo $listarFactura[$i+5]; else echo '12';?>" size="4" maxlength="4" />%
        </td>
      </tr>
      <tr>
        <td class="categoria">Condiciones de Pago:</td>
        <td class="dato" >
            <select name="pago" id="pago">
             <?php if($ban==1)  echo " <option value=".$listarFactura[$i+6].">".$listarFactura[$i+6]."</option>";?>
            <option value=""></option>
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
	           <OPTION value=""></OPTION>
			 </SELECT>
        </td>
      </tr>
      <tr><td class="categoria">Observaci&oacute;n:</td>
      <td  colspan="3"><textarea name="observacion" cols="60" rows="2" id="observacion"  onblur="javascript:this.value=this.value.toUpperCase()" ><?php if($ban==1)  echo $listarFactura[$i+38];?></textarea>
</td>
      </tr>
      <tr>
        <td height="22" colspan="4">
          <div align="center">
           <input type="hidden" name="indReg" >
             <input type="hidden" name="codproa" id="codproa" >
           <?php if (!$idfactura) { ?>
            <input  type="button" onclick="validarCaract(1); return false" value="Generar" />
            <?php } if ($idfactura) { ?>
           <!-- <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Anular" />-->

            <?php  if ($listarFactura[+10]<>'15') { ?>
             <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('3'); return false" value="Modificar" />
             <?php } ?>
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
