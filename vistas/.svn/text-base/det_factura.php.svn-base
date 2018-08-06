<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/factura.php');
require('../modelos/pago.php');
require('../modelos/zona.php');

$objFactura = new factura();
$objPago 		= new pago();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5);
validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];
$codproa=$_POST['codproa'];
$obspro=$_POST['obspro'];
$monto=$_POST['monto'];
$tipo=$_GET['tip'];

 $plazo = $_POST['plazo'];
 $tasa = $_POST['tasa'];
// $forma = $_POST['forma'];
 $gastos = $_POST['gastos'];
 $exon = $_POST['exon'];

 $facori = $_POST['facori'];
 $fecfacori = $_POST['fecfacori'];

 $tpagomen=$_POST['mensual'];
 $tpagosem=$_POST['semestral'];
 $tpagoanu=$_POST['anual'];

 $mpagomen=$_POST['formam'];
 $mpagosem=$_POST['formas'];
 $mpagoanu=$_POST['formaa'];

  $tipo=$_GET['tip'];
  $indErr = false;

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');
  $idfactura=$_GET['idfactura'];

  $listarFactura=$objFactura->reporteFactura($idfactura,$tipo);

  $listarRD=$objFactura->buscarRD($idfactura);

  //echo "Documento: ".$listarRD[0];

  if ($listarFactura)
	$detalleVehiculo=$objFactura->detalleVehiculo($listarFactura[9]);

if ($indReg){

	if     ($indReg=='8')
		      echo "<SCRIPT>window.location.href='reg_certificado.php?num=$idfactura';</SCRIPT>";
    elseif ($indReg=='6')
              echo "<SCRIPT>window.location.href='reg_pago.php?num=$idfactura';</SCRIPT>";
    elseif ($indReg=='15')
              echo "<SCRIPT>window.location.href='reg_entrega_veh.php?num=$idfactura';</SCRIPT>";
    elseif ($indReg=='99')
    {
       $estatus = $objFactura->AnularFactura($idfactura,$listarFactura[13],$detalleVehiculo[2],$indReg,$obspro,$monto);
       if($estatus)
		  echo "<script>alert('Factura Anulada');</script>";
		  else  echo "<script>alert('Factura No pudo ser Anulada');</script>";
		  echo "<SCRIPT>window.location.href='listado_factura.php';</SCRIPT>";
    }

    else{
                                                                                                                                       //,$forma
	  $estatus = $objFactura->estatusFacturaProfo($idfactura,$listarFactura[13],$detalleVehiculo[2],$indReg,$obspro,$monto,$plazo,$tasa,$gastos,$exon,$facori,$fecfacori,$refL,$fechaL,$montoS,'',$tpagomen,$mpagomen,$tpagosem,$mpagosem,$tpagoanu,$mpagoanu,$gastosA,$gastosN,$gastosT);
	  if($estatus){
	  	echo "<script>alert('Estatus Cambiado');</script>";
	  	if     ($indReg=='7')
	  	echo '<SCRIPT> window.open("../vistas/reportes/pdffacturaOri.php?num='.$idfactura.' " , "ventana1" , "width=600,height=600,scrollbars=NO") </SCRIPT>';
	  }
	  else
	    echo "<script>alert('No se pudo Cambiar de estatus');</script>";



    }

  $listarFactura=$objFactura->reporteFactura($idfactura,$tipo);
  if ($listarFactura)
	$detalleVehiculo=$objFactura->detalleVehiculo($listarFactura[9]);
}


$inicialConsignada=$objPago->inicialConsignada($listarFactura[13]);

$vencimiento=suma_fechas($listarFactura[1],30);

$objZona= new zona();
$buscarEstados = $objZona->buscarEstados($listarFactura[25]);
$buscarMunicipio = $objZona->buscarMunicipios($listarFactura[26],$listarFactura[25]);
$buscarParroquia = $objZona->buscarParroquias($listarFactura[27],$listarFactura[25],$listarFactura[26]);
?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>

function cambiarStatus(campo) {

		if(campo==4){
			    if (document.form1.monto.value.length==0){
			    alert("Debe Ingresar el monto por el que aprobo el credito");
			    document.form1.monto.focus()
			    return (false);
                                      }
			    if (document.form1.plazo.value.length==0){
			    alert("Debe Ingresar el plazo de el credito");
			    document.form1.plazo.focus()
			    return (false);
                                      }
                if (document.form1.tasa.value.length==0){
			    alert("Debe Ingresar el % de la tasa de el credito");
			    document.form1.tasa.focus()
			    return (false);
                                      }
			    if (document.form1.forma.value.length==0){
			    alert("Debe Ingresar la Forma de pago del  credito");
			    document.form1.forma.focus()
			    return (false);
                                      }
                if (document.form1.gastos.value.length==0){
			    alert("Debe Ingresar el % de los Gastos Administrativos de el credito");
			    document.form1.gastos.focus()
			    return (false);
                                      }

		}

		if(campo==7){
			    if (document.form1.facori.value.length==0){
			    alert("Debe Ingresar el numero de la factura original");
			    document.form1.facori.focus()
			    return (false);
                                      }
			    if (document.form1.fecfacori.value.length==0){
			    alert("Debe Ingresar la fecha de la factura original");
			    document.form1.fecfacori.focus()
			    return (false);
                                      }

		}


		if(campo==9){

		   var ind = confirm("Desea cargar la Reserva de Dominio en digital?");
      	   if(ind){
				popup('regReservaDoc.php?id=<? echo $listarFactura[0] ?>');
				return false;
       	   }

		}

		document.form1.indReg.value = campo;
        document.form1.submit();

}


function popup(URL) {
  day = new Date();
  id = day.getTime();
  eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=600,height=180');");
}

    </script>
   <style type="text/css">
<!--
.Estilo4 {font-size: 14px}
-->
   </style>
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
<fieldset>
        <legend>Estatus de la Factura Proforma: Suvinca</legend>
     <table  width="822" border="0" align="center" >
            <tr>
              <td colspan="5"  align="center" class="cabecera">Estatus: </td>
            </tr>
            <tr>
              <td colspan="5"  align="center" class="cdetc"><?php echo $listarFactura[24];?></td>
            </tr>
            <tr>
            <td colspan="5" >
              <div align="center" class="NotCelda">
                <img src="../vistas/imagenes/px1.gif" width="1" height="1" alt="" border="0" />
              </div>
            </td>
            </tr>
            <tr>
              <td colspan="5" align="center" class="formulario">
              <a   class="vinculo" href="" target="_blank" onClick="popup('bitacoraBeneficiario.php?id=<? echo $listarFactura[13] ?>&nom=<? echo $listarFactura[12] ?>');return false;">
               <img title="Bitacora del Beneficiario" src="botones/bitacora.png" width="35" height="35">
              </a>
               <?php if($listarFactura[29]=='1')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Anular" onclick="cambiarStatus(99)" <?php echo $actdesac?>>
              <input type="button"  value="Vencida" onclick="cambiarStatus(0)" <?php echo $actdesac?>>
               <?php if($listarFactura[29]=='4')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="A la Espera de Consignar Inicial" onclick="cambiarStatus(5)" <?php echo $actdesac?>>
               <?php if($listarFactura[29]=='4' or $listarFactura[29]=='5')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Inicial Consignada" onclick="cambiarStatus(6)" <?php echo $actdesac?>>
              <a class="vinculo" href="" target="_blank" onClick="popup('movimientoProforma.php?id=<? echo $listarFactura[0] ?>&nom=<? echo $listarFactura[12] ?>');return false;">
               <img title="Movimientos de Estatus de la Factura Proforma" src="botones/app_48.png" width="35" height="35" <?php echo $actdesac?>>
              </a>
              </td>
              </tr>
              <tr>
              <td colspan="5" align="center" class="formulario">
              <?php if($listarFactura[29]=='6')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Factura Emitida" onclick="cambiarStatus(7)" <?php echo $actdesac?>>
              <?php if($listarFactura[29]=='7')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Certificado Emitido" onclick="cambiarStatus(8)" <?php echo $actdesac?>>
               <?php if(($listarFactura[29]=='9') and ($listarRD[0]<>'')){
               ?>
               <a class="vinculo" href="" target="_blank" onClick="popup('<? echo $listarRD[0]; ?>');return false;" <?php echo $actdesac?>>
               <img title="Descargar Reserva de Dominio" src="botones/box_download_48.png" width="25" height="25">
              </a>
               <?php } if($listarFactura[29]=='9')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Firma de Reserva de Dominio" onclick="cambiarStatus(10)" <?php echo $actdesac?>>
               <?php if($listarFactura[29]=='14')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Vehículo Entregado" onclick="cambiarStatus(15)" <?php echo $actdesac?>>
              </td>
              </tr>
               <tr>
            <td colspan="5" >
              <div align="center" class="NotCelda">
                <img src="../vistas/imagenes/px1.gif" width="1" height="1" alt="" border="0" />
              </div>
            </td>
            </tr>
            <?php if($inicialConsignada) { ?>
            <tr>
              <td  align="center" class="cdet"> Inicial Consignada
             </td>
              <td  align="center" class="dato">
                    <?php  echo $inicialConsignada; ?>
              </td>
            <?php  } ?>
              </tr>
              <tr>
              <td  align="center" class="cdet"> N# Factura Original
              </td>
              <?php  if($listarFactura[39] or $listarFactura[29]<'6') $bloq1='readonly="" '; ?>
              <td  align="center" class="dato">
              <input name="facori" type="text" id="facori" size="16"  maxlength="15" value="<?php echo $listarFactura[39] ?>" onkeypress="return acessoNumerico(event)"  <?php echo $bloq1?>/>
              </td>
               <td  align="center" class="cdet" > Fecha de Factura
              </td>
              <td  align="center" class="dato">
                <input name="fecfacori" type="text" id="fecfacori" size="10"  maxlength="10" date_format="dd/MM/yy" onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)" readonly="" value="<?php echo $listarFactura[40];?>"/>
                     <?php  if(!$listarFactura[40] and $listarFactura[29]=='6')  {?>
                <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecfacori',document.forms[0].fecfacori.value)" />
                     <?php } ?>
              </td>
              </tr>
           <!--   <tr>
              <td  align="center" class="cdet"> Observaciones
              </td>
              <td colspan="4" align="center" class="dato">
              <textarea name="obspro" cols="100" rows="3" id="obspro"  onblur="javascript:this.value=this.value.toUpperCase()" ><?php echo $listarFactura[32];?> </textarea>
              </td>
              </tr>-->

      </table>
</fieldset>
<fieldset>
        <legend>Estatus de la Factura Proforma: Banco</legend>
     <table  width="822" border="0" align="center" >
      <tr>
        <td colspan="5" >
              <tr>
              <td colspan="5"  align="center" class="cabecera">Estatus: </td>
            </tr>
            <tr>
              <td colspan="5"  align="center" class="cdetc"><?php echo $listarFactura[24];?></td>
            </tr>
            <tr>
            <td colspan="5" >
              <div align="center" class="NotCelda">
                <img src="../vistas/imagenes/px1.gif" width="1" height="1" alt="" border="0" />
              </div>
            </td>
            </tr>
            <tr>
              <td colspan="5" align="center" class="formulario">
              <a class="vinculo" href="" target="_blank" onClick="popup('bitacoraBeneficiario.php?id=<? echo $listarFactura[13] ?>&nom=<? echo $listarFactura[12] ?>');return false;">
               <img title="Bitacora del Beneficiario" src="botones/bitacora.png" width="35" height="35">
              </a>
               <?php if($listarFactura[29]=='1')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Análisis" onclick="cambiarStatus(2)" <?php echo $actdesac?>>
               <?php if($listarFactura[29]=='2')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="A la espera de Documentos" onclick="cambiarStatus(3)" <?php echo $actdesac?>>
              <?php if($listarFactura[29]=='2' or $listarFactura[29]=='3')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Crédito Aprobado" onclick="cambiarStatus(4)" <?php echo $actdesac?>>
               <?php if($listarFactura[29]=='2' or $listarFactura[29]=='3')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Crédito Negado" onclick="cambiarStatus(16)" <?php echo $actdesac?>>
              <a class="vinculo" href="" target="_blank" onClick="popup('movimientoProforma.php?id=<? echo $listarFactura[0] ?>&nom=<? echo $listarFactura[12] ?>');return false;">
               <img title="Movimientos de Estatus de la Factura Proforma" src="botones/app_48.png" width="35" height="35">
              </a>
              </td>
              </td>
              </tr>
              <tr>
              <td colspan="5" align="center" class="formulario">
               <?php if($listarFactura[29]=='8')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
               <input type="button"  value="Reserva de Dominio enviada a Suvinca" onClick="cambiarStatus(9)" <?php echo $actdesac?>>
               <?php if($listarFactura[29]>='9'){
               ?>
              <a class="vinculo" href="" target="_blank" onClick="popup('regReservaDoc.php?id=<? echo $listarFactura[0] ?>');return false;" <?php echo $actdesac?>>
               <img title="Cargar Reserva de Dominio" src="botones/box_upload_48.png" width="25" height="25">
              </a>
              <?php } if($listarFactura[29]=='10'  )
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Recepción de Reserva de Dominio" onclick="cambiarStatus(11)" <?php echo $actdesac?>>
              <?php if($listarFactura[29]=='11')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Póliza Consignada" onclick="cambiarStatus(12)" <?php echo $actdesac?>>
              </td>
              </tr>
              <tr>
              <td colspan="5" align="center" class="formulario">
               <?php if($listarFactura[29]=='12')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Documento Notariado" onclick="cambiarStatus(13)" <?php echo $actdesac?>>
               <?php if($listarFactura[29]=='13')
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Crédito Liquidado" onclick="cambiarStatus(14)" <?php echo $actdesac?>>
       	      </td>
              </tr>
              <tr>
            <td colspan="5" >
              <div align="center" class="NotCelda">
                <img src="../vistas/imagenes/px1.gif" width="1" height="1" alt="" border="0" />
              </div>
            </td>
            </tr>
               <tr>
              <td  align="center" class="cdet"> Monto
              </td>
              <?php if($listarFactura[33]) $bloq='readonly="" '; ?>
              <td  align="center" class="dato">
              <input name="monto" type="text" id="monto" maxlength="18" value="<?php echo $listarFactura[33] ?>" onkeypress="return acessoDecimal(event)" <?php echo $bloq?>/>Bs
              </td>
               <td  align="center" class="cdet" > Plazo
              </td>
              <td  align="center" class="dato">
               <input name="plazo" type="text" id="plazo" maxlength="3" size="5" value="<?php echo $listarFactura[34] ?>" onkeypress="return acessoNumerico(event)" <?php echo $bloq?>/>Meses
              </td>
              </tr>
              <tr>
              <td  align="center" class="cdet"> Tasa
              </td>
              <td  align="center" class="dato">
               <input name="tasa" type="text" id="tasa" maxlength="6" size="5" value="<?php echo $listarFactura[35] ?>" onkeypress="return acessoDecimal(event)" <?php echo $bloq?>/>%
              </td>
              <!-- <td  align="center" class="cdet"> Forma de Pago
              </td>
              <td  align="center" class="dato">
               <input name="forma" type="text" id="forma" maxlength="3" size="5" value="<?php echo $listarFactura[36] ?>" onkeypress="return acessoNumerico(event)" <?php echo $bloq?>/>Cuotas
              </td>-->
              </tr>
              <tr>
			  <td rowspan="3" align="center" class="cdet">Forma de Pago</td>
     		  <td><input type="checkbox" name="mensual" onclick="permutar('formam')" value="M">Mensual <input name="formam" type="text" id="formam" maxlength="18" size="10" value="<?php echo $listarFactura[46] ?>" onkeypress="return acessoNumerico(event)" disabled/></td>
			  </tr>
			  <tr>
			  <td><input type="checkbox" name="semestral" onclick="permutar('formas')" value="S">Semestral
			  <input name="formas" type="text" id="formas" maxlength="18" size="10" value="<?php echo $listarFactura[48] ?>" onkeypress="return acessoNumerico(event)" disabled/></td>
			  </tr>
			  <tr>
			  <td><input type="checkbox" name="anual" onclick="permutar('formaa')" value="A">Anual
			  <input name="formaa" type="text" id="formaa" maxlength="18" size="10" value="<?php echo $listarFactura[50] ?>" onkeypress="return acessoNumerico(event)" disabled/></td>
			  </tr>

               <tr>
              <tr>
              <td  align="center" class="cdet"> Gastos Adm.
              </td>
              <td  align="center" class="dato">
               <input name="gastos" type="text" id="gastos" maxlength="5" size="6" value="<?php echo $listarFactura[37] ?>" onkeypress="return acessoDecimal(event)" <?php echo $bloq?>/>%
              </td>
               <td  align="center" class="cdet"> Exonerado
              </td>
              <td  align="center" class="dato">
                  No
		        <input type="radio" name="exon" id="exon"  value="N" <?php if ($listarFactura[38]=='N' or $listarFactura[38]!='S') echo "checked= 'true'"?>/>
                  Si
		        <input type="radio" name="exon" id="exon"  value="S" <?php if ($listarFactura[38]=='S' ) echo "checked= 'true'"?>/>

              </td>
              </tr>
               <tr>
              <td  align="center" class="cdet"> Observaciones
              </td>
              <td colspan="4" align="center" class="dato">
              <textarea name="obspro" cols="100" rows="3" id="obspro"  onblur="javascript:this.value=this.value.toUpperCase()" ><?php echo $listarFactura[32];?> </textarea>
              </td>
              </tr>
      </table>
</fieldset>

<fieldset>
 <legend> Datos de la Factura Proforma</legend>
  <table  width="822" border="0" align="center" >
      <tr>
        <td colspan="5" >
		<table width="35%" border="0" align="right" cellpadding="0" cellspacing="2">
            <tr>
              <td align="center" class="cabecera">NUMERO</td>
            </tr>
            <tr>
              <td align="center" class="formulario"><?php echo str_pad($listarFactura[0],5,'0',STR_PAD_LEFT);?></td>
            </tr>
          </table>		  </td>
      </tr>

      <tr>
        <td colspan="5" class="cabecera" align="center"><?php echo $listarFactura[5]; ?></td>
        </tr>
      <tr>
        <td width="338" class="categoria">&nbsp;</td>
        <td colspan="2" rowspan="2"><table width="60%" border="0" align="right" cellpadding="1" cellspacing="2">
            <tr>
              <td class="cdet">Fecha de Emision:</td>
              <td class="formulario"><?php echo $listarFactura[1];?></td>
            </tr>
            <tr>
              <td class="cdet">Fecha de Vencimiento:</td>
              <td class="formulario"><?php echo $vencimiento;?></td>
            </tr>
                </table></td>
      </tr>
      <tr>
        <td colspan="4" ><table  width="100%"  border="0" cellpadding="0" cellspacing="3">
          <tr>
            <td width="100" class="cdet">Banco:</td>
            <td width="900" class="dato"><?php echo $listarFactura[23];?></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="5"><table width="100%" border="0" cellpadding="0" cellspacing="2">
            <td class="cdet">Nombre:</td>
            <td colspan="2" class="dato" align="left"><?php echo $listarFactura[12];?></td>
            <td class="cdet">Ci/Rif: </td>
            <td colspan="2" class="dato" align="left"><span ><?php echo $listarFactura[13];?></span></td>
            </tr>
          <tr>
            <td colspan="6" align="center" class="cabecera">Domicilio Fiscal</td>
            </tr>
          <tr>
            <td class="cdet">Urb/barrio: </td>
            <td class="dato"><?php echo $listarFactura[14];?></td>
            <td class="cdet">Calle:</td>
            <td class="dato"><?php echo $listarFactura[15];?></td>
            <td class="cdet">Edificio/Casa: </td>
            <td class="dato"><?php echo $listarFactura[16]; ?></td>
          </tr>
          <tr>
            <td class="cdet">Piso: </td>
            <td class="dato"><?php echo $listarFactura[17];?></td>
            <td class="cdet">N# Apartamento:</td>
            <td class="dato"><span class="dato"><?php echo $listarFactura[18];?></span></td>
            <td class="cdet">Tlf: </td>
            <td class="dato"><span class="dato"><?php echo $listarFactura[21].' '.$listarFactura[22]; ?></span></td>
          </tr>
          <tr>
            <td class="cdet">Estado: </td>
            <td class="dato"><span><?php echo $buscarEstados[1];?></span></td>
            <td class="cdet">Municipio:</td>
            <td class="dato"><span ><?php echo $buscarMunicipio[1];?></span></td>
            <td class="cdet">Parroquia: </td>
            <td class="dato"><span><?php echo $buscarParroquia[1]; ?></span></td>
          </tr>
        </table></td>
        </tr>
        <tr>
          <td colspan="5"><table width="100%" border="0" cellspacing="2">
            <tr>
              <td class="cabecera" width="10%" align="left">Cantidad</td>
              <td class="cabecera" colspan="2" align="left">Descripción</td>
              <td class="cabecera" width="18%">Precio Unitario</td>
              <td class="cabecera" width="20%">Total</td>
            </tr>
            <tr class="for_det">
              <td align="center">1</td>
              <td width="30%" align="left">VEHICULO</td>
              <td width="12%" >&nbsp;</td>
              <td class="for_det3" align="right"><?php echo FormatoMonto($listarFactura[7]); ?></td>
              <td class="for_det3" align="right"><?php echo FormatoMonto($listarFactura[7]); ?></td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;N CERTIFICADO DE ORIGEN:</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;PLACA:</td>
              <td align="left"><?php echo $detalleVehiculo[1]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;SERIAL DE CARROCERIA::</td>
              <td align="left"><?php echo $detalleVehiculo[2]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;SERIAL DE NIV::</td>
              <td align="left"><?php echo $detalleVehiculo[3]; ?></span></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;SERIAL DE CHASIS::</td>
              <td align="left"><?php echo $detalleVehiculo[4]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;SERIAL DE CARROZADO:</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;MARCA:</td>
              <td align="left"><?php echo $detalleVehiculo[5]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;MODELO:</td>
              <td align="left"><?php echo $detalleVehiculo[6]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;SERIE/VERSION:</td>
              <td align="left"><?php echo $detalleVehiculo[7]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;AÑO DE FABRICACION:</td>
              <td align="left"><?php echo $detalleVehiculo[8]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;AÑO DE MODELO:</td>
              <td align="left"><?php echo $detalleVehiculo[9]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;SERIAL DE MOTOR:</td>
              <td align="left"><?php echo $detalleVehiculo[10]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;TIPO DE COMBUSTIBLE:</td>
              <td align="left"><?php echo $detalleVehiculo[11]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;CODIGO GNV:</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;COLOR(ES):</td>
              <td align="left"><?php echo $detalleVehiculo[12].' '.$detalleVehiculo[13]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;CLASE:</td>
              <td align="left"><?php echo $detalleVehiculo[14]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;TIPO:</td>
              <td align="left"><?php echo $detalleVehiculo[15]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;USO:</td>
              <td align="left"><?php echo $detalleVehiculo[16]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;N° DE PUESTOS:</td>
              <td align="left"><?php echo $detalleVehiculo[17]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;N° DE EJES:</td>
              <td align="left"><?php echo $detalleVehiculo[18]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;PESO (TARA):</td>
              <td align="left"><?php echo $detalleVehiculo[19]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det" >
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;CAPACIDAD DE CARGA:</td>
              <td align="left"><?php echo $detalleVehiculo[20]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;CGARANTIA (TIEMPO/KMRECORRIDOS):</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td ></td>
              <td ></td>
              <td class="for_det2" align="right">PLACAS( E )</td>
              <td class="for_det3" align="right"><?php echo FormatoMonto($listarFactura[6]); ?></td>
              <td class="for_det3" align="right"><?php echo FormatoMonto($listarFactura[6]); ?></td>
            </tr>
            <tr>
              <td colspan="5">
              <div align="center" class="NotCelda">
              <img src="../vistas/imagenes/px1.gif" width="1" height="1" alt="" border="0" />
              </div>
              </td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="for_det2" align="right">SUB TOTAL</td>
              <td class="for_det2" align="right"><?php echo FormatoMonto($listarFactura[7]+$listarFactura[6]); ?></td>
            </tr>

            <tr>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="for_det2" align="right">MONTO EXENTO </td>
              <td class="for_det2" align="right"><?php echo FormatoMonto($listarFactura[6]); ?></td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="for_det2" align="right">MONTO GRAVADO</td>
              <td class="for_det2" align="right"><?php echo FormatoMonto($listarFactura[7]); ?></td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="for_det2" align="right">IVA</td>
              <td class="for_det2" align="right"><?php echo FormatoMonto($listarFactura[7]*$listarFactura[8]/100); ?></td>
            </tr>
            <tr>
              <td align="right">&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td>&nbsp;</td>
              <td class="for_det2" align="right">TOTAL</td>
              <td class="for_det2" align="right"><?php echo FormatoMonto($listarFactura[7]+($listarFactura[7]*$listarFactura[8]/100)+$listarFactura[6]); ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="5" class="datos">&nbsp;</td>
        </tr>
        <input type="hidden" name="indReg" >
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
  </legend>
  </fieldset>
  </body>
</html>