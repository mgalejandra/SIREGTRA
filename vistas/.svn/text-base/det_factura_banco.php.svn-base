<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/factura.php');
require('../modelos/pago.php');
require('../modelos/zona.php');
require('../modelos/inventario.php');

$objFactura = new factura();
$objPago 		= new pago();
$objInv     = new inventario();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(9,10,26);
validaAcceso($permitidos,$dir);
$ban=0;

$indReg=$_POST['indReg'];

$codproa=$_POST['codproa'];
$obspro=$_POST['obspro'];
$montoS=$_POST['montoS'];
$monto=$_POST['monto'];
$tipo=$_GET['tip'];
$preinv=$_GET['preinv'];

 $plazo = $_POST['plazo'];
 $tasa = $_POST['tasa'];
/* $forma = $_POST['forma'];
 echo "Forma: ".$forma;*/

 $gastos = $_POST['gastos'];
 $exon = $_POST['exon'];


 $facori = $_POST['facori'];
 $fecfacori = $_POST['fecfacori'];

 $fechaL = $_POST['fechaL'];
 $refL = $_POST['refliq'];

 $tpagomen=$_POST['mensual'];
 $tpagosem=$_POST['semestral'];
 $tpagoanu=$_POST['anual'];

 $mpagomen=$_POST['formam'];
 $mpagosem=$_POST['formas'];
 $mpagoanu=$_POST['formaa'];

 $gastosA=$_POST['gastosadm'];
 $gastosT=$_POST['gastostim'];
 $gastosN=$_POST['gastosnot'];

  $tipo=$_GET['tip'];
  $indErr = false;

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');
  $idfactura=$_GET['idfactura'];

  $listarFactura=$objFactura->reporteFactura($idfactura,$tipo);

  $listarRD=$objFactura->buscarRD($idfactura);

  $datosVeh = $objInv->listarPreInventario($preinv,'','','',-1);

  //echo "Documento: ".$listarRD[0];

  if ($listarFactura)
	$detalleVehiculo=$objFactura->detalleVehiculo($listarFactura[9]);

if ($indReg){
	if ($indReg=='100')
	{
		if($listarFactura[29]=='2') $indReg=1;
		if($listarFactura[29]=='3') $indReg=2;
		if($listarFactura[29]=='4') {
			$estatusR = $objFactura->estatusFacturaProfoR($idfactura);
			$listarFactura=$objFactura->reporteFactura($idfactura,$tipo);
			echo "<script>alert('Estatus Reversado'); </script>";
			$indReg=null;

		}
		if($listarFactura[29]=='9') $indReg=8;
		if($listarFactura[29]=='11') $indReg=10;
		if($listarFactura[29]=='12') $indReg=11;
		if($listarFactura[29]=='13') $indReg=12;
		if($listarFactura[29]=='14') $indReg=13;
		if($listarFactura[29]=='16') $indReg=2;
		if($listarFactura[29]=='17') $indReg=2;
		if($listarFactura[29]=='19') $indReg=13;
		if($listarFactura[29]=='20') $indReg=18;
	    if($listarFactura[29]=='21') $indReg=18;
	    if($listarFactura[29]=='25' or
									    $listarFactura[29]=='26' or
									    $listarFactura[29]=='27' or
									    $listarFactura[29]=='28' or
									    $listarFactura[29]=='29'    ) $indReg=8;

      // $indReg=(int)($listarFactura[29])-1;
       //echo $listarFactura[29].' - '.$indReg;

	}
	     if($indReg=='100'){
		 echo "<script>alert('No puedes Reversar este estatus');</script>";
		 $indReg=null;
	}
}

if ($indReg){

	  $estatus = $objFactura->estatusFacturaProfo($idfactura,$listarFactura[13],$detalleVehiculo[2],$indReg,$obspro,$monto,$plazo,$tasa,$gastos,$exon,$facori,$fecfacori,$refL,$fechaL,$montoS,'',$tpagomen,$mpagomen,$tpagosem,$mpagosem,$tpagoanu,$mpagoanu,$gastosA,$gastosN,$gastosT);
	  if($estatus){
    	echo "<script>alert('Estatus Cambiado'); </script>";
	  	if     ($indReg=='7')
	  	echo '<SCRIPT> window.open("../vistas/reportes/pdffacturaOri.php?num='.$idfactura.' " , "ventana1" , "width=600,height=600,scrollbars=NO") </SCRIPT>';
	  }
	  else
	    echo "<script>alert('No se pudo Cambiar de estatus');</script>";


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
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>

function cambiarStatus(campo,sta){

	var pasa = document.form1.indReg.value;
	var pru = document.form1.bandera.value;

        if(campo==2){

        var mons = document.form1.montoS.value;
	    var tot = document.form1.totfact.value;

			 if (document.form1.montoS.value.length==0){
			    alert("Debe indicar el monto solicitado");
			    document.form1.montoS.focus()
			    return (false);
             }

                if (parseFloat(mons) > parseFloat(tot))
			    {

			    alert("Debe Ingresar un monto inferior o igual al precio del vehiculo:"+document.form1.totfact.value);
			    document.form1.montoS.focus()
			    return (false);
                }
        }

        if ((campo==3) & (pasa=='')){
			alert ("Indique los documentos faltantes");
        	abreBitacora(campo);

        	if (pru==1)
         		return(true);
            else
            	return(false);
        }

		if(campo==4  && sta==0){

			     var mon = document.form1.monto.value;
	             var tot = document.form1.totfact.value;

			    if (document.form1.monto.value.length==0){
			    alert("Debe Ingresar el monto por el que aprobó el crédito");
			    document.form1.monto.focus()
			    return (false);
                }

                if (document.form1.monto.value.length<=4){
			    alert("Debe Ingresar el monto por el que aprobó superior a 4 digitos");
			    document.form1.monto.focus()
			    return (false);
                }


                if (parseFloat(mon) > parseFloat(tot))
			    {
			    alert("Debe Ingresar un monto inferior o igual al precio del vehiculo:"+document.form1.totfact.value);
			    document.form1.monto.focus()
			    return (false);
                }

			    if (document.form1.plazo.value.length==0){
			    alert("Debe Ingresar el plazo del crédito");
			    document.form1.plazo.focus()
			    return (false);
                }

                opciones = document.getElementsByName("mensual");
				var seleccionado = false;
				for(var i=0; i<opciones.length; i++) {
					if(opciones[i].checked)
					{
						seleccionado = true;break;
					}
				}

				opciones1 = document.getElementsByName("semestral");
				var seleccionado1 = false;
				for(var i=0; i<opciones1.length; i++) {
					if(opciones1[i].checked)
					{
						seleccionado1 = true;break;
					}
				}

				opciones2 = document.getElementsByName("anual");
				var seleccionado2 = false;
				for(var i=0; i<opciones2.length; i++) {
					if(opciones2[i].checked)
					{
						seleccionado2 = true;break;
					}
				}

				if ((seleccionado==false) & (seleccionado1==false) & (seleccionado2==false) ){
  					alert("Debe seleccionar al menos un tipo de pago");
  					return (false);
  				}

				if ((seleccionado==true) &(document.form1.formam.value.length==0)){
					alert("Debe indicar el monto del pago mensual");
  					return false;
				}

				if ((seleccionado1==true) &(document.form1.formas.value.length==0)){
					alert("Debe indicar el monto del pago semestral");
  					return false;
				}

				if ((seleccionado2==true) &(document.form1.formaa.value.length==0)){
					alert("Debe indicar el monto del pago anual");
  					return false;
				}

                if (document.form1.gastos.value.length==0 && document.form1.exon[0].checked){
			    alert("Debe Ingresar el % de los Gastos Administrativos del crédito");
			    document.form1.gastos.focus()
			    return (false);
                }
                else
                	ga=true;

                if ((ga==true) & (document.form1.gastosadm.value.length==0) && document.form1.exon[0].checked ){
			    alert("Debe Ingresar el monto del Gasto Administrativo");
			    document.form1.gastosadm.focus()
			    return (false);
                }



				if (document.form1.gastostim.value.length==0){
			    alert("Debe Ingresar el monto de los Gastos por Timbres Fiscales");
			    document.form1.gastostim.focus()
			    return (false);
                }
		}

		if(campo==7){

			if (document.form1.fecfacori.value.length==0){
			    alert("Debe Ingresar la fecha de la factura original");
			    document.form1.fecfacori.focus()
			    return (false);
           }

		    if (document.form1.facori.value.length==0){
			    alert("Debe Ingresar el numero de la factura original");
			    document.form1.facori.focus()
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

		if(campo==14){
		var vzla=sta;

             if ((document.form1.refliq.value.length==0) & (vzla!='0102') ){
			    alert("Debe Ingresar el numero de referencia de la liquidación");
			    document.form1.refliq.focus()
			    return (false);
            }

			if (document.form1.fechaL.value.length==0){
			    alert("Debe Ingresar la fecha de liquidación");
			    document.form1.fechaL.focus()
			    return (false);
            }



 		}


        if ((campo==16) & (pasa=='')){
		    alert ("Indique el(los) motivo(s) por el cual Rechaza el crédito");
        	abreBitacora(campo);

        	if (pru==1)
         		return(true);
            else
            	return(false);
        }

        if ((campo==17) & (pasa=='')){
		    alert ("Indique el(los) motivo(s) por el cual Difiere el crédito");
        	abreBitacora(campo);

        	if (pru==1)
         		return(true);
            else
            	return(false);
        }


        if ((campo==19) & (pasa=='')){
		    alert ("Indique el(los) motivo(s) por el cual está Incompleto para liquidar");
        	abreBitacora(campo);

         	if (pru==1)
         		return(true);
            else
            	return(false);
        }

        if ((campo==21) & (pasa=='')){
			alert ("Indique el(los) motivo(s) por el cual rechaza la reconsideración");
        	abreBitacora(campo);

        	if (pru==1)
         		return(true);
            else
            	return(false);
        }

    	if ((campo==100) & (pasa==''))	{
         	abreBitacora(campo);

         	if (pru==1)
         		return(true);
            else
            	return(false);
        }

        	document.form1.indReg.value = campo;
   			document.form1.submit();
}


function popup(URL) {
  day = new Date();
  id = day.getTime();
  eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=600,height=180');");
}

function permutar(campo){
  eval("document.form1."+campo+".disabled = !document.form1."+campo+".disabled")
}

function abreBitacora(campo){
	  day = new Date();
	  id = day.getTime();

      iz = (screen.width-700)/2;
	  ar = (screen.height-500)/2;
      eval("page" + id + " = window.open('bitacoraBeneficiario.php?acc="+campo+"&id=<? echo $listarFactura[13] ?>&nom=<? echo $listarFactura[12] ?>', '', 'top="+ar+",left="+iz+",toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=700,height=500');");

}

function calgasadm(valor){
document.form1.gastosadm.value = (document.form1.monto.value * (valor/100)).toFixed(2);
}

function caltimbre(valor){

	var timbre   = document.form1.zonagastos.value;
	var porgasto = document.form1.gastos.value;

		if (timbre == 1 )
		   valorTimbre = 1;

		if (timbre == 2 )
		  valorTimbre = 1;

		if (timbre == 3 )
		  valorTimbre = 1;

        document.form1.gastosadm.value = (valor * (porgasto/100)).toFixed(2);

		document.form1.gastostim.value = (valorTimbre * (valor/1000)).toFixed(2);

}

function caltimbre2(valor){
//alert('entro');
	var timbre   = valor;
	var monto = document.form1.monto.value;

		if (timbre == 1 )
		   valorTimbre = 1;

		if (timbre == 2 )
		  valorTimbre = 1;

		if (timbre == 3 )
		  valorTimbre = 1;

		document.form1.gastostim.value = (valorTimbre * (monto/1000)).toFixed(2);

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
        <legend>Estatus de la Factura Proforma: Banco</legend>
     <table  width="822" border="0" align="center" >
      <tr>
        <td colspan="5" >
              <tr>
              <td colspan="5"  align="center" class="cabecera">Estatus:</td>
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
               <?php if ($listarFactura[29]=='1' or $listarFactura[29]=='20')  //Si es Emitida o Reconsiderada activo Análisis
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Análisis" onclick="cambiarStatus(2)" <?php echo $actdesac?>>
               <?php if($listarFactura[29]=='2' )  //Si está en Análisis
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="A la espera de Documentos" onclick="cambiarStatus(3)" <?php echo $actdesac?>>

			  <?php if($listarFactura[29]=='18') //Si está en Reconsideracion
               {
               	$actdesac = '';
               	$style='style="visibility:visible"';
               }
               else
               {
               	$actdesac = 'disabled = "true"';
               	$style='style="visibility:hidden"';
               }

               ?>
               <a class="vinculo" href="" target="_blank" onClick="popup('<? echo $listarFactura[55] ?>');return false;" <?php echo $actdesac; echo $style; ?>>
               <img title="Ver carta de reconsideracion" src="botones/star_half_48.png" width="25" height="25" >
               </a>
               <input type="button"  value="Aprobar Reconsideración" onclick="cambiarStatus(20)" <?php echo $actdesac?>>
			   <input type="button"  value="Rechazar Reconsideración" onclick="cambiarStatus(2)" <?php echo $actdesac?>>
			    <a class="vinculo" href="" target="_blank" onClick="popup('movimientoProforma.php?id=<? echo $listarFactura[0] ?>&nom=<? echo $listarFactura[12] ?>');return false;">
               <img title="Movimientos de Estatus de la Factura Proforma" src="botones/app_48.png" width="35" height="35">
              </a>
              </td>
			  </tr>
			  <tr>
			     <td colspan="5" align="center" class="formulario">
			   <?php if($listarFactura[29]=='2' or $listarFactura[29]=='3')  //Si está en Análisis
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Crédito Diferido" onclick="cambiarStatus(17)" <?php echo $actdesac?>>
              <?php if($listarFactura[29]=='2' or $listarFactura[29]=='3' or $listarFactura[29]=='17' or $listarFactura[29]=='20' or $listarFactura[29]=='21') //Si está en Análisis, a la espera de documentos o fue rechazada la reconsideracion
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
               <input type="button"  value="Crédito Aprobado" onclick="cambiarStatus(4,0)" <?php echo $actdesac?>>
               <?php if($listarFactura[29]=='2' or $listarFactura[29]=='3' or $listarFactura[29]=='17') //Si está en Análisis o a la espera de documentos
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Crédito Negado" onclick="cambiarStatus(16)" <?php echo $actdesac?>>

              </td>
              </td>
              </tr>
               <? if (!($preinv)){ ?>
              <tr>
              <td colspan="5" align="center" class="formulario">
               <?php if($listarFactura[29]=='8' or $listarFactura[29]=='25' or $listarFactura[29]=='26' or $listarFactura[29]=='27' or $listarFactura[29]=='28' or $listarFactura[29]=='29' ) //Si está en Certificado Emitido
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
               <input type="button"  value="Reserva de Dominio enviada a Suvinca" onClick="cambiarStatus(9)" <?php echo $actdesac?>>
               <?php if($listarFactura[29]>='9' and $listarRD[0]==''){ //Si está de Reserva de dominio en adelante
               ?>
              <a class="vinculo" href="" target="_blank" onClick="popup('regReservaDoc.php?id=<? echo $listarFactura[0] ?>');return false;" <?php echo $actdesac?>>
               <img title="Cargar Reserva de Dominio" src="botones/box_upload_48.png" width="25" height="25">
              </a>
              <?php } if($listarFactura[29]=='9' or  $listarFactura[29]=='10' or $listarFactura[29]=='25' or $listarFactura[29]=='26' or $listarFactura[29]=='27' or $listarFactura[29]=='28' or $listarFactura[29]=='29' ) //Si está en Firma de Reserva de dominio
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Recepción de reserva de Dominio en banco" onclick="cambiarStatus(11)" <?php echo $actdesac?>>
              <?php if($listarFactura[29]=='11' or $listarFactura[29]=='25' or $listarFactura[29]=='26' or $listarFactura[29]=='27' or $listarFactura[29]=='28' or $listarFactura[29]=='29' ) //Si la reserva de dominio fue recibida
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Póliza Consignada" onclick="cambiarStatus(12)" <?php echo $actdesac?>>
              </td>
              </tr>
               <? } ?>
              <tr>
              <td colspan="5" align="center" class="formulario">
               <? if (!($preinv)){ ?>
               <?php if($listarFactura[29]=='12' or $listarFactura[29]=='25' or $listarFactura[29]=='26' or $listarFactura[29]=='27' or $listarFactura[29]=='28' or $listarFactura[29]=='29' ) //Si la Poliza fue consignada
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Documento Notariado" onclick="cambiarStatus(13)" <?php echo $actdesac?>>
               <?php if($listarFactura[29]=='8' or $listarFactura[29]=='11' or $listarFactura[29]=='12' or $listarFactura[29]=='13' or $listarFactura[29]=='19' or $listarFactura[29]=='9' or $listarFactura[29]=='10' or $listarFactura[29]=='25' or $listarFactura[29]=='26' or $listarFactura[29]=='27' or $listarFactura[29]=='28' or $listarFactura[29]=='29')
                     //Si la reserva de dominio fue recibida o Poliza fue consignada o estaba incompleto para liquidar
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Crédito Liquidado" onclick="cambiarStatus(14,'<?php echo $_SESSION['idBanco']?>')" <?php echo $actdesac?>>
              <? } ?>
              <?php if($_SESSION['tipoUsuario']=='10')   //Si la reserva de dominio fue firmada
               $actdesac = '';
               else $actdesac = 'disabled = "true"';
               ?>
              <input type="button"  value="Reversar Estatus" onclick="cambiarStatus(100)" <?php echo $actdesac?>>
       	      </td>
              </tr>
              <tr>
              <td colspan="5"  align="center" class="cabecera">Alerta de Estatus</td>
            </tr>
             <tr>
			     <td colspan="5" align="center" class="formulario">
                 <?php if($listarFactura[29]=='8' or $listarFactura[29]=='9'  or $listarFactura[29]=='10' or $listarFactura[29]=='11' or $listarFactura[29]=='12' or $listarFactura[29]=='13'
                       or $listarFactura[29]=='25' or $listarFactura[29]=='26' or $listarFactura[29]=='27' or $listarFactura[29]=='28' or $listarFactura[29]=='29' ) //Si el certificado fue emitido
                   $actdesac = '';
                   else $actdesac = 'disabled = "true"';
                 ?>
		              <input type="button"  value="A la espera de consignar poliza de seguro" onclick="cambiarStatus(25)" <?php echo $actdesac?> >
		              <input type="button"  value="A  la espera de apertura de cuenta" onclick="cambiarStatus(26)" <?php echo $actdesac?>>
		              <input type="button"  value="A la espera de disponibilidad en cuenta" onclick="cambiarStatus(27)" <?php echo $actdesac?>>
                 </td>
             </tr>
             <tr>
			     <td colspan="5" align="center" class="formulario">
					  <input type="button"  value="A la espera de la firmar de la reserva de dominio" onclick="cambiarStatus(28)" <?php echo $actdesac?>>
		              <input type="button"  value="Documento en Notaria" onclick="cambiarStatus(29)" <?php echo $actdesac?>>
		              <input type="button"  value="Cambio de Garantia Procesada" onclick="cambiarStatus(33)" <?php echo $actdesac?>>
                </td>
                 </tr>
              <tr>
            <td colspan="5" >
              <div align="center" class="NotCelda">
                <img src="../vistas/imagenes/px1.gif" width="1" height="1" alt="" border="0" />
              </div>
            </td>
            </tr>
            <?
            /*
            	 0. e.id_numfac
            	 1. e.fecfac
            	 2. e.fecfac
            	 3. e.fecfac
            	 4. e.fecfac
            	 5. e.condpago
            	 6. e.exento
            	 7. c.preveh
            	 8. e.iva
            	 9. a.id_asignacion
            	10. b.id_caract
            	11. b.sercarveh
            	12. d.nomcomp
            	13. d.codpro
            	14. d.calavepro
            	15. d.urbbarpro
            	16. d.edicaspro
            	17. d.numpispro
            	18. d.numapapro
            	19. d.dismunpro
            	20. d.ciudadpro
            	21. d.tlfcelpro
            	22. d.tlfcel2pro
            	23. F.banco_descrip
            	24. G.descripcion
            	25. d.codest
            	26. d.codmun
            	27. d.codpar
            	28. e.id_concesionario
            	29. e.id_estatus
            	30. e.usuario_estatus
            	31. e.fecha_estatus
            	32. e.observacion
            	33. e.monto
            	34. e.plazo
            	35.	e.tasa
            	36. e.forma
            	37. e.gastos
            	38. e.exonerado
            	39. e.facori
            	40. e.fecfacori
            	41. e.refliquida
            	42. e.fechaliquida
            	43. e.montosol
            	44. e.motivoreco
            	45. e.tipagomens
            	46. e.montpagomens
            	47. e.tipagosem
            	48. e.montpagosem
            	49. e.tipagoanual
            	50. e.montpagoanual
            	51. e.gastosadmin
            	52. e.gastosnotar
            	53. e.gastostimbre
            	54. e.recobs
            */
            ?>

<tr>
<td align="left" class="cdet">Monto solicitado</td>
<?php if($listarFactura[43]) $bloq3='readonly="" '; ?>
<td  align="center" class="dato">
<input name="montoS" type="text" id="montoS" maxlength="18" value="<?php echo $listarFactura[43];?>" onkeypress="return acessoDecimal(event)" <?php echo $bloq3?> />Bs
</td>
<td> </td>
<td class="cdet">Monto aprobado</td>
<?php if($listarFactura[33] or $listarFactura[29]=='1'  or $listarFactura[29]=='16' or $listarFactura[29]=='18' ) { $bloq='readonly="" '; $disforpag='DISABLED'; }  if ($listarFactura[29]=='17' or $listarFactura[29]=='20') $bloq=''; ?>
              <td  align="center" class="dato">
              <input name="monto" type="text" id="monto" maxlength="18" value="<?php echo $listarFactura[33] ?>" onkeypress="return acessoDecimal(event)" onblur="caltimbre(this.value); return false" <?php echo $bloq?>/>Bs
              </td>
<td> </td>
<td> </td>
<td> </td>
</tr>
<tr>
<td class="cdet">Plazo</td>
<?php if($listarFactura[34]) $bloq='readonly="" ';  if ( $listarFactura[29]=='20') $bloq=''; ?>
<td align="left"><input name="plazo" type="text" id="plazo" maxlength="3" size="5" value="<?php echo $listarFactura[34] ?>" onkeypress="return acessoNumerico(event)" <?php echo $bloq?>/>Meses
        </td>
<td> </td>
<td class="cdet">Tasa</td>
<td  align="center" class="dato">
<input name="tasa" type="text" id="tasa" maxlength="6" size="5" value="<?php if ($listarFactura[35]) echo $listarFactura[35]; else echo "14"; ?>" onkeypress="return acessoDecimal(event)" <?php echo $bloq?>/>%
</td>
<td> </td>
<td> </td>
<td> </td>
</tr>
<tr>
<td rowspan="3" class="cdet">Forma de pago</td>
<td  align="left"><input type="checkbox" name="mensual" onclick="permutar('formam')" value="M"   <?  if($listarFactura[45]=='M') echo 'checked'; else echo $disforpag;?>>Mensual
<input name="formam" type="text" id="formam" maxlength="18" size="10" value="<?php echo $listarFactura[46] ?>" onkeypress="return acessoDecimal(event)" disabled/></td>
<td> </td>
<td class="cdet">Gastos Adm</td>
<td align="left">
<input name="gastos" type="text" id="gastos" maxlength="5" size="6" value="<?php if($listarFactura[37]) echo $listarFactura[37]; else echo '3'; ?>" onkeypress="return acessoDecimal(event)" onblur="calgasadm(this.value); return false" <?php echo $bloq?>/>%
<input name="gastosadm" type="text" id="gastosadm" maxlength="5" size="10" value="<?php echo $listarFactura[51] ?>" onkeypress="return acessoDecimal(event)" readonly=""/>Bs.
</td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
</tr>
<tr>
<td  align="left">
<input type="checkbox" name="semestral" onclick="permutar('formas')" value="S" <?  if($listarFactura[47]=='S') echo 'checked'; else echo $disforpag;?> >Semestral
<input name="formas" type="text" id="formas" maxlength="18" size="10" value="<?php echo $listarFactura[48] ?>" onkeypress="return acessoDecimal(event)" disabled/></td>
<td> </td>
<td class="cdet">Gastos timbre</td>
<td align="left">
          <select name="zonagastos"  id="zonagastos"  onChange="caltimbre2(this.value); return false" >
                <option value="1">Dtto Capital - 1x 1.000</option>
                <option value="2">Edo Miranda  - 1x 1.000</option>
                <option value="3">Edo Lara     - 1x 1.000</option>
          </select>
<input name="gastostim" type="text" id="gastostim" maxlength="5" size="6" value="<?php echo $listarFactura[53] ?>" onkeypress="return acessoDecimal(event)" readonly=""/>Bs.
<td> </td>
<td> </td>
</tr>
<tr>
<td  align="left"><input type="checkbox" name="anual" onclick="permutar('formaa')" value="A" <?  if($listarFactura[49]=='A') echo 'checked'; else echo $disforpag;?>>Anual
 <input name="formaa" type="text" id="formaa" maxlength="18" size="10" value="<?php echo $listarFactura[50] ?>" onkeypress="return acessoDecimal(event)" disabled/></td>
<td> </td>
</td>
<td> </td>
<td> </td>
<td> </td>
<td> </td>
</tr>
<tr>
<td class="cdet">Exonerado</td>
<td class="dato">
                  No
		        <input type="radio" name="exon" id="exon"  value="N" <?php  if ($listarFactura[38]=='N' or $listarFactura[38]!='S') echo "checked= 'true'"?>/>
                  Si
		        <input type="radio" name="exon" id="exon"  value="S" <?php echo $disforpag; if ($listarFactura[38]=='S' ) echo "checked= 'true'"?>/>
</td>
<td> </td>
</tr>
 <tr>
            <td colspan="5" >
              <div align="center" class="NotCelda">
                <img src="../vistas/imagenes/px1.gif" width="1" height="1" alt="" border="0" />
              </div>
            </td>
            </tr>
<tr>
<td class="cdet">Fecha liquidación</td>
<td align="left"><input id="fechaL" name="fechaL" type="text" size="10" maxlength="10" value="<?php if ($listarFactura[42]) echo $listarFactura[42]; else echo $fechaL;?>" onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)" date_format="dd/MM/yy" readonly="" />
              <img src="../images/cal.gif" width="16" height="16" onclick="show_calendar('document.forms[0].fechaL',document.forms[0].fechaL.value)" /></td>
<td> </td>
<td class="cdet">N° referencia liq.:</td>
               <?php if($listarFactura[29]=='8' or $listarFactura[29]=='11' or $listarFactura[29]=='12' or $listarFactura[29]=='13' or $listarFactura[29]=='19' or $listarFactura[29]=='9' or $listarFactura[29]=='10' or $listarFactura[29]=='26' or $listarFactura[29]=='28' or $listarFactura[29]=='29')
                     //Si la reserva de dominio fue recibida o Poliza fue consignada o estaba incompleto para liquidar
               $bloq1 = '';
               else $bloq1 = 'disabled = "true"';
               ?>
<td align="left"><input name="refliq" type="text" id="refliq" maxlength="15" size="10" value="<?php echo $listarFactura[41] ?>" <?php echo $bloq1?> /></td>
<td> </td>
<td> </td>
<td> </td>
</tr>
<tr>
<td class="cdet">Observaciones</td>
<td colspan="4"> <textarea name="obspro" cols="100" rows="3" id="obspro"  onblur="javascript:this.value=this.value.toUpperCase()" ><?php echo $listarFactura[32];?> </textarea>
           </td>
</tr>
</tbody>
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
               <? if (!($preinv)){ ?>
                <td class="cabecera" width="18%">Precio Unitario</td>
              	<td class="cabecera" width="20%">Total</td>
              <? } else {?>
              	<td class="cabecera" width="18%">Precio Min</td>
              	<td class="cabecera" width="18%">Precio Max.</td>
              <? }?>
            </tr>
            <tr class="for_det">
              <td align="center">1</td>
              <td width="30%" align="left">VEHICULO</td>
              <td width="12%" >&nbsp;</td>
               <? if (!($preinv)){ ?>
              <td class="for_det3" align="right"><?php echo FormatoMonto($listarFactura[7]); ?></td>
              <td class="for_det3" align="right"><?php echo FormatoMonto($listarFactura[7]); ?></td>
              <? } else {?>
				<td class="for_det3" width="18%"><?php echo FormatoMonto($datosVeh[5]); ?></td>
              	<td class="for_det3" width="18%"><?php echo FormatoMonto($datosVeh[6]); ?></td>
              <? }?>
            </tr>
            <? if (!($preinv)){ ?>
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
             <? } ?>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;MARCA:</td>
              <td align="left"><?php if ($preinv) echo $datosVeh[1]; else echo $detalleVehiculo[5]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;MODELO:</td>
              <td align="left"><?php if ($preinv) echo $datosVeh[2]; else echo $detalleVehiculo[6]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <tr class="for_det">
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;&nbsp;&nbsp;SERIE/VERSION:</td>
              <td align="left"><?php if ($preinv) echo $datosVeh[7]; else echo $detalleVehiculo[7]; ?></td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
            </tr>
            <? if (!($preinv)){ ?>
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
          <? }?>
          </table></td>
        </tr>
        <tr>
          <td colspan="5" class="datos">&nbsp;</td>
        </tr>
        <input type="hidden" name="indReg" id="indReg" >
         <input type="hidden" name="totfact" id="totfact" value='<?php echo number_format($listarFactura[7]+($listarFactura[7]*$listarFactura[8]/100)+$listarFactura[6], 2, '.', ''); ?>'>
        <input type="hidden" name="bandera" id="bandera" >
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
  </legend>
  </fieldset>
  </body>
</html>