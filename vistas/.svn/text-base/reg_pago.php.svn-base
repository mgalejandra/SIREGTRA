<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/certificado.php');
require('../modelos/asignacion.php');
require('../modelos/pago.php');
require('../modelos/factura.php');

$objCertificado = new certificado();
$objPago 		= new pago();
$objFactura = new factura();
$objAsignacion = new asignacion();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';

for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,6,7,11,13,17);
validaAcceso($permitidos,$dir);

$ban=0;
$indReg=$_POST['indReg'];
$codproc=$_POST['codproa'];
$sercarveh=$_POST['sercarveh'];
$indErr = false;

	$numPago	= $_POST['numPago'];
  	$id_banco	= $_POST['id_banco'];
	$numCtaBanco= $_POST['numCtaBanco'];
	$statusPago	= $_POST['statusPago'];
	$fecPago	= $_POST['fecPago'];
	$monto		= $_POST['monto'];
  	$sercarveh	= $_POST['sercarveh'];
  	$beneficario= $_POST['beneficario'];
  	$idAsig		= $_POST['idAsig'];
  	$tipo   	= $_POST['tipo'];


  	if ($idAsig=='')
  	{
  		$listarAsigna = $objAsignacion->listarAsignaciones($sercarveh,'','');
		$idAsig = $listarAsigna[4];
	}

  	$num=$_GET['num'];

////  Prepara tabla de bancos a partir de DB para ser usado en <select>

$tabBanco = $objPago->listarBancos();
$dimBanco = sizeof($tabBanco);

if ($_GET['idpago']) $id_pago = $_GET['idpago']; else $listarPago=null;

  if ($num){
  	  $listarFactura=$objFactura->reporteFactura($num,'A');
  	  $datos = array($numPago,$fecPago,$monto,$id_banco,$numCtaBanco,$listarFactura[9],$listarFactura[11],$tipo);
  	  $codproc=$listarFactura[13];
  }else
  {
  	 $datos = array($numPago,$fecPago,$monto,$id_banco,$numCtaBanco,$idAsig,$sercarveh,$tipo);
  }

  $fecact=date('d/m/Y');
  $hora=date('H:i:s');

if ($id_pago or $indReg!=2)  {
	$ban=1;
	$i=0;
	//echo 'entro';
	$listarPago = $objPago->buscarPago($id_pago);
  //echo '<br>'.$ban.'--'.$listarPago[$i+1];
}

if ($indReg==1 or $indReg==2){
	$ban=1;
	$i=0;

	if($indErr)	f_alert("Reporte de validación:".$msj);
	elseif($indReg==1){
		    $tipo=substr($codproc,0,1);

		    $buscoPago = $objPago->buscarPago('',$fecPago,$fecPago,$codproc,'','',$numPago,$numCtaBanco,$id_banco);

            if($tipo='G' or $tipo='J') $buscoPago=false;

		    if ($buscoPago)
		    {
		    	$msj = "Pago ha sido agregado previamente";
		    	f_alert($msj);
		    	echo "<SCRIPT>window.location.href='listado_pagos.php?id_caso=2';</SCRIPT>";
		    }
		    else
		    {
		    	$registro = $objPago->registrarPago($datos,$codproc,$num);//&$datos,$codproc,$num);
				$msj = ($registro)?"Pago Registrado":"Pago NO Registrado";
				f_alert($msj);
		    }

	//f_alert($msj);

	if ($registro)  {
		 echo '<SCRIPT> window.open("../vistas/reportes/pdfRecibodePago.php?idpago='.$registro.' " , "ventana1" , "width=600,height=600,scrollbars=NO") </SCRIPT>';
		 if ($num)
		   echo "<SCRIPT>window.location.href='det_factura_suvinca.php?idfactura=$num';</SCRIPT>";
		 else
		   echo "<SCRIPT>window.location.href='listado_pagos.php';</SCRIPT>";
	}
			$indReg = 3;	// Coloca variable en 3 para limpiar los campos
	}
	elseif($indReg==2){
			$modificar = $objPago->modificarPago($id_pago,$datos,$statusPago,$codproc,$num);
			if ($modificar){
			     f_alert("Registro modificado");
				 echo "<SCRIPT>window.location.href='listado_pagos.php?id_caso=2';</SCRIPT>";
			}else f_alert("No se pudo registrar modificación");
	}
}

if ($indReg==3)  {
  	$sercarveh	= null;
  	$beneficiario=null;
  	$id_banco	= null;
	$numCtaBanco= null;

	$listarPago	= null;

	$numPago	= null;
	$statusPago	= null;
	$fecPago	= null;
	$monto		= null;
  	$idAsig		= null;
}

if (!$id_pago) {$listarPago=null; $ban=0;}

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

if (dato==3)  {
  	document.form1.sercarveh.value	= null;
  	document.form1.beneficario.value=null;
  	document.form1.id_banco.value	= null;
  	document.form1.codBanco.value	= null;
	document.form1.numCtaBanco.value= null;

	document.form1.numPago.value	= null;
  	document.form1.numDeposito.value= null;
	document.form1.statusPago.value	= null;
	document.form1.fecPago.value	= null;
	document.form1.monto.value		= null;
  	document.form1.idAsig.value		= null;
}else{
	if (document.form1.sercarveh.value.length==0){
	    alert("Debe seleccionar serial de carrocería \ndel vehículo a entregar");
	    document.form1.sercarveh.focus();
	    return (false);
	    }

	if (document.form1.id_banco.value.length==0){
	    alert("Debe seleccionar banco origen del pago o transferencia");
	    document.form1.id_banco.focus();
	    return (false);
	    }
	else{
		document.getElementById("codBanco").innerHTML=document.form1.id_banco.value;
	}

	if (document.form1.numCtaBanco.value.length<16){
	    alert("Debe indicar número de cuenta del banco (16 digitos)");
	    document.form1.numCtaBanco.focus();
	    return (false);
	    }

	if (document.form1.numPago.value.length<8){
	    alert("Debe indicar número del Pago o transferencia\n (debe ser mayor o igual a 8 dígitos)");
	    document.form1.numPago.focus();
	    return (false);
	    }

	if (document.form1.fecPago.value.length==0){
	    alert("Debe indicar fecha del Pago o la transferencia");
	    document.form1.fecPago.focus();
	    return (false);
	    }

	if (document.form1.monto.value.length==0){
	    alert("Debe indicar monto del Pago o la transferencia");
	    document.form1.monto.focus();
	    return (false);
	    }

	if (document.form1.tipo.value.length==0){
	    alert("Debe indicar el tipo de pago");
	    document.form1.tipo.focus();
	    return (false);
	    }
}
document.form1.indReg.value = dato;
document.form1.submit();
}

function popup(URL) {
   day = new Date();
   id = day.getTime();
   eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1000,height=800');");
}

function fcodBanco(){
	document.form1.codBanco.value = document.form1.id_banco.value;
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

<!--  Contenido Principal  -->

  <form id="form1" name="form1" method="post" action="">
  <table class="formulario" width="900" border="0" align="center" >
      <tr>
	  <td colspan="8" class="cabecera">Datos del Vehículo / Beneficiario  <?php if ($num) echo ' de la Factura Proforma N#'.$num;  ?> </td>
      </tr>
      <tr>
        <td class="categoria" colspan="1">Serial&nbsp;Vehículo:</td>
        <td class="dato" colspan="2">
         <input name="sercarveh" type="text" id="sercarveh" size="18" maxlength="18"
         		value="<?php if ($num) echo $listarFactura[11];?><?=($ban==1)?$listarPago[$i+7]:$sercarveh; ?>" readonly=""/>
         <?php if (!$num){ ?> <input type="button" onclick="popup('cat_asignacion.php');" value="..."/> <?php } ?>
        </td>
         <td class="categoria" colspan="1">Beneficiario:&nbsp;</td>
        <td class="dato" colspan="2">
	        <input name="beneficario" type="text" id="beneficario"
	        		value="<?php if ($num) echo $listarFactura[12];?><?=($ban==1)?$listarPago[$i+8]:$beneficiario?>"
	        		size="40" maxlength="20" readonly="" />
	       <!-- <input type="hidden" name="idAsig" id="idAsig"
	        		value="<?=($ban==1)?$listarPago[$i+6]:''?>">   -->
	        	<input type="hidden" name="idAsig" id="idAsig" value="<?php if ($num) echo $listarFactura[9];?><?=($ban==1)?$listarPago1[$i+6]:''?>">
	        	<input type="hidden" name="codproa" id="codproa">
        </td>
      </tr>
      <td colspan="8" class="cabecera"><?=($id_pago)?"Modificar Pago":"Registar Pago"?></td>
    </tr>
    </tr>
    <tr>
        <td class="categoria" colspan="1"> Banco:&nbsp;</td>
			 <td align="left" colspan="2">
			 <SELECT id="id_banco" name="id_banco" onchange="fcodBanco()" onkeydown="fcodBanco()" onkeyup="fcodBanco()">
				<OPTION value=""></OPTION>
			    <?for($k=0;$k<$dimBanco;$k+=2) { ?>
					<OPTION value="<?=($ban==1)?$listarPago[$i+5]:$tabBanco[$k]?>"
					<?=($tabBanco[$k]==$listarPago[$i+5])?"selected='true'":"";?>><?=$tabBanco[$k+1]?>
					</OPTION>
			    <? } ?>
			 </SELECT>
		     </td>

      <td class="categoria" colspan="1">N° Cuenta:&nbsp;</td>
      <td class="dato" colspan="2" title="Número cuenta del banco origen del Pago">
	       <input name="codBanco" type="text" id="codBanco" readonly="" align="center"
	        value="<?=($ban==1)?$listarPago[$i+5]:$id_banco?>" width="4" size="3"/>&nbsp;
	       <input name="numCtaBanco" type ="text" id="numCtaBanco"
	       	value="<?=($ban==1)?$listarPago[$i+9]:$numCtaBanco?>" size="16" maxlength="16" width="16"
	       	onkeypress="return acessoNumerico(event)"/>
      </td>
</tr>
<tr>
      <td class="categoria"colspan="1" title="N° del Pago o transferencia">N° Pago:&nbsp;</td>
      <td class="dato" colspan="1">
	       <input name="numPago" type ="text" id="numPago"
	       value="<?=($ban==1)?$listarPago[$i+1]:$numPago?>" size="10" maxlength="10"
	       onkeypress="return acessoNumerico(event)"/>
      </td>

       <td class="categoria"colspan="1">Fecha Pago:&nbsp;</td>
        <td class="dato" colspan="3">
         <input name="fecPago" type ="text" id="fecPago"
         		value="<?=($ban==1 and $listarPago[$i+2]!='01/01/1999')?$listarPago[$i+2]:$fecPago?>"
         		size="8" maxlength="8" date_format="dd/MM/yy"
         		onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)"  readonly=""/>
          <img src="../images/cal.gif" width="16" height="18"
          		onClick="show_calendar('document.forms[0].fecPago',document.forms[0].fecPago.value)" />
        </td>
</tr>
<tr>

	    <td class="categoria"colspan="1">Monto&nbsp;Pago:&nbsp;</td>
        <td class="dato" colspan="2">
	       <input name="monto" type ="text" id="monto" onkeypress="return acessoDecimal(event)"
	       		  value="<?=($ban==1)?$listarPago[$i+3]:$monto?>" size="10"
	       		  maxlength="10"   onblur="javascript:this.value=this.value.toUpperCase()" />
       </td>
       <td class="categoria"colspan="1">Tipo&nbsp;Pago:&nbsp;</td>
        <td class="dato" colspan="2">
        <select name="tipo" id="tipo">
            <option value="<?php echo $listarPago[$i+11]?>"><?php echo $listarPago[$i+11]?></option>
            <option value="CHEQUE">CHEQUE</option>
            <option value="DEPOSITO">DEPOSITO</option>
            <option value="TRANSFERENCIA">TRANSFERENCIA</option>
          </select>
          </td>
          </td>
</tr>
<tr>
    <td height="22" colspan="8">
       <div align="center">
          <input type="hidden" name="indReg" >
            <input name="numcerveh" type ="hidden" id="numcerveh"  />
              <input type="hidden" name="codproc" id="codproc" >
           <?php if (!$id_pago) { ?>
           <input  type="button" onclick="validarCaract('1'); return false" value="Registrar" />
            <input  type="button"  onclick="validarCaract('3'); return false" value="Limpiar" />
           <?php } if ($id_pago and ($_SESSION['tipoUsuario'] == 1 or $_SESSION['tipoUsuario'] == 4)) { ?>
         <!--  <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Modificar" />--!
           <?php } ?>
           <input name="listar" type="button" id="listar" onclick="window.location.href='listado_pagos.php?id_caso=2'" value="Listar" />
       </div> -->
    </td>
</tr>
</table>
<?include ('ctrl_pagina2.php')?>
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
