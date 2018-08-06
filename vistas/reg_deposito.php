<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/deposito.php');

//////////////////////////////////////////////////////////////////////////////////////////

function f_limpiar () {
		$tablaPago 				= null;
  		$_SESSION['id_pago'] 	= null;
		$_SESSION['nroPago'] 	= null;
		$_SESSION['monto'] 		= null;
		$_SESSION['fecha'] 		= null;
		$_SESSION['statusPago'] = null;
		$_SESSION['idBanco'] 	= null;
		$_SESSION['desBanco'] 	= null;
		$_SESSION['nroCta'] 	= null;
		$_SESSION['nomcomp'] 	= null;
		$_SESSION['codpro'] 	= null;
		$_SESSION['fechaReg'] 	= null;
		$_SESSION['contiTem']	= null;
		$_SESSION['montoTotal'] = null;
}
//////////////////////////////////////////////////////////////////////////////////////////

$obj = new deposito();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,3,4,5);

//validaAcceso($permitidos,$dir);

$indReg = $_POST['indReg'];

$tabBanco = $obj->listarBancos(1); // El parámetro (1) hace que regrese tres valores: 0:id_banco, 1:descrip, 2:nroCta
$dimBanco = sizeof($tabBanco);

$numDeposito= $_POST['numDeposito'];
$fecDeposito= $_POST['fecDeposito'];
$codBanco	= $_POST['codBanco'];
$ctaBanco	= $_POST['ctaBanco'];
$nomBanco	= $_POST['nomBanco'];

$montoTotal	= $_SESSION['montoTotal'];

$datos = array($numDeposito,$fecDeposito,$codBanco,$ctaBanco,$montoTotal);

if ($_GET['id']) {
	$id_deposito=$_GET['id'];
	$listarDeposito = $obj->buscarDeposito($id_deposito,&$tablaPago,&$msj);
	if(!$listarDeposito or !$tablaPago)	f_alert("Error: ".$msj);
	else{
 		$numDeposito= $listarDeposito[1];
		$fecDeposito= $listarDeposito[2];
		$nomBanco	= $listarDeposito[3];
		$ctaBanco	= $listarDeposito[4];
		$codBanco	= $listarDeposito[5];
		$montoTotal = $listarDeposito[6];

		$nro_colum = 11; // Número de columnas de $tablaPago
		$_SESSION['contiTem'] = count($tablaPago)/$nro_colum;

		for($i=0;$i<count($tablaPago);$i+=$nro_colum){
			$k = $i / $nro_colum;
 	  		$_SESSION['id_pago'][$k] 	= $tablaPago[$i];
			$_SESSION['nroPago'][$k] 	= $tablaPago[$i+1];
			$_SESSION['monto'][$k] 		= $tablaPago[$i+2];
			$_SESSION['fecha'][$k] 		= $tablaPago[$i+3];
			$_SESSION['status'][$k] 	= $tablaPago[$i+4];
			$_SESSION['idBanco'][$k] 	= $tablaPago[$i+5];
			$_SESSION['desBanco'][$k] 	= $tablaPago[$i+6];
			$_SESSION['nroCta'][$k] 	= $tablaPago[$i+7];
			$_SESSION['nomcomp'][$k] 	= $tablaPago[$i+8];
			$_SESSION['codpro'][$k] 	= $tablaPago[$i+9];
			$_SESSION['fechaReg'][$k] 	= $tablaPago[$i+10];
		}
	}
}
else {
	$tablaPago=null;
}

if ($indReg==1 and !$_GET['id']){
    $registro = $obj->registrarDeposito($_SESSION['id_pago'],$datos,&$nFallas,&$msj);
	$msj = ($registro)?"Depósito Registrado".$msj:"Mensaje de error:".$msj;
	f_alert($msj);
	$indReg = 4;
}

if ($indReg==1 and $_GET['id']){
    $registro = $obj->modificarDeposito($id_deposito,$datos,&$msj);
	$msj = ($registro)?"Depósito Modificado".$msj:"Mensaje de error:".$msj;
	f_alert($msj);
	$indReg = 4;
}

if ($indReg>=3){	// Ejecutar si y sólo sí (indReg = 3 : Limpiar) ó (indReg = 4 : Se modifica el depósito)
	f_limpiar();
	if($indReg==4) echo "<script>window.location.href='listado_depositos.php';</script>";
}

?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>

function disable(nBoton){
  document.getElementById("boton"+nBoton).disabled=true;
}

function enable(nBoton){
  document.getElementById("boton"+nBoton).disabled=false;
  }

function validarCaract(dato){

if(dato==3){
	 document.registro.id_banco.value = null;
	 document.registro.ctaBanco.value = null;
	 document.registro.fecDeposito.value = null;
	 document.registro.numDeposito.value = null;
	 document.registro.codBanco.value = null;
	 disable(1);
	 disable(2);
}else {

	if (document.registro.id_banco.value.length==0){
	    alert("Debe seleccionar banco para el depósito");
	    document.registro.id_banco.focus()
		disable(2);
	    return (false);
	    }

	if (document.registro.ctaBanco.value.length==0){
	    alert("Debe ingresar N° de la cuenta del banco (16 dígitos)");
	    document.registro.ctaBanco.focus()
	    disable(2);
	    return (false);
	    }

	if (document.registro.ctaBanco.value.length!=16){
	    alert("N° de cuenta debe contener 16 dígitos");
	    document.registro.ctaBanco.focus()
	    disable(2);
	    return (false);
	    }

	if (document.registro.numDeposito.value.length==0){
	   alert("Debe ingresar N° de planilla de depósito");
	   document.registro.numDeposito.focus()
	   disable(2);
	   return (false);
	   }

	if (document.registro.fecDeposito.value.length==0){
	   alert("Debe indicar fecha del depósito");
	   document.registro.fecDeposito.focus()
	   disable(2);
	   return (false);
	   }
	enable(2);
	}
	 document.registro.indReg.value = dato;
	 document.registro.submit();
}
///////////////////////////////////////////////////////////////////////////////

    function popup(URL) {
      day = new Date();
      id = day.getTime();
      eval("page"+id+"=window.open(URL,'URL','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=950,height=650');");
	}

	function fcodBanco(){
	var nroCtaBanco = document.registro.id_banco.value;
	document.registro.codBanco.value = nroCtaBanco.substr(0,4);
	document.registro.ctaBanco.value = nroCtaBanco.substr(4);
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
  <form id="registro" name="registro" method="post" action="">
  <table class="formulario" width="900" border="0" align="center" id="tabla1">
    <td colspan="12" class="cabecera"><?=($_GET['id'])?'Modificar':'Registrar'?>&nbsp;Depósito</td>
    <tr>
        <td class="categoria" colspan="2"> Banco:&nbsp;</td>
		 <td align="left" colspan="2">
			 <SELECT id="id_banco" name="id_banco" onchange="fcodBanco()" onkeydown="fcodBanco()" onkeyup="fcodBanco()">
				<OPTION value=""></OPTION>
			    <?for($k=0;$k<$dimBanco;$k+=3) { ?>
					<OPTION value="<?=$tabBanco[$k].$tabBanco[$k+2]?>"
						<?=($tabBanco[$k]==$codBanco)?'selected="true"':'';?>><?=$tabBanco[$k+1]?>
					</OPTION>
			    <? } ?>
			 </SELECT>
		 </td>
    </tr>

	    <td class="categoria" colspan="3">Nro. Cuenta:</td>
        <td align="left">
			<input name="codBanco" type="text" id="codBanco" value="<?=$codBanco?>" width="2" size="2" onkeypress="return acessoNumerico(event)">
	        <input name="ctaBanco" type ="text" id="ctaBanco" maxlength="16" value="<?=$ctaBanco?>" size="16" onkeypress="return acessoNumerico(event)">
        </td>
        <td class="categoria" colspan="3" title="Número preimpreso en la planilla de depósito">N° Planilla Depósito: </td>
        <td class="dato">
	       <input name="numDeposito" type ="text" id="numDeposito" maxlength="10"
	       			value="<?=$numDeposito?>" size="16"
	       			onkeypress="return acessoNumerico(event)"/>
        </td>
       <td class="categoria">Fecha&nbsp;Depósito:</td>
        <td class="dato">
         <input name="fecDeposito" type ="text" id="fecDeposito"
         		value="<?=($fecDeposito!='01/01/1999')?$fecDeposito:''?>"
         		size="8" maxlength="10"
         		date_format="dd/MM/yy"
         		onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)" readonly=""/>
	          <img src="../images/cal.gif" width="16" height="16"
	          		onClick="show_calendar('document.forms[0].fecDeposito',document.forms[0].fecDeposito.value);enable(1);enable(2)" />
         </td>
    </tr>
    <tr>
     <td height="22" colspan="11">
     <div align="center">
      <?if(!$_GET['id']){?>
      	<br/>
        <input type="button" value="Seleccionar pagos..." id="boton1" name="boton1"
        		onclick="popup('listado_pagos.php?id_caso=1'); if(document.registro.contItem.value>0) enable(2); return false"/>
        <input type="button" value="Limpiar" onclick="validarCaract(3); return false"/>
      <?}?>
        <input type="button" value="Guardar" id="boton2" name="boton2"
        		onclick="validarCaract(1); 	return false" <?if($_SESSION['contiTem']==0)echo 'disabled="disabled"';?>"/>
        <input type="button" value="Listar" onclick="window.location.href='listado_depositos.php'"/>
        <input type="hidden" id="indReg" name="indReg" size="2">
	 </div>
     </td>
     </tr>
 </table>

 <!-- //////////////////////////////////////////////////////////////////// -->

<legend>
	 <div>
	  <input type="hidden" name="contItem" id="contiTem" value="<?= $_SESSION['contiTem']?>" size="3">
	 </div>


   <table align="center" class="detalles" id="tabla2">
            <tr>
              <td class="cabecera" rowspan="2" width="8%">ID</td>
              <td class="cabecera" colspan="5">Cheque / Transferencia</td>
              <td class="cabecera" colspan="2">Beneficiario</td>
              <td class="cabecera" rowspan="2" width="8%">Fecha Reg.</td>
            </tr>
            <tr>
              <td class="cabecera" width="10%">N°</td>
              <td class="cabecera">Monto</td>
              <td class="cabecera" width="8%">Fecha</td>
              <td class="cabecera">Status</td>
              <td class="cabecera" title="Banco del cheque">Banco</td>
              <td class="cabecera" >RIF</td>
              <td class="cabecera" >Nombre</td>
            </tr>
<?
		$cantPagos = $_SESSION['contiTem'];
		$_SESSION['montoTotal'] = 0;

        for($i=0;$i<$cantPagos;$i++){
                 $color = (!$indC)?'datosimpar':'datospar';
                 $indC = !$indC;
                 $_SESSION['montoTotal'] = $_SESSION['montoTotal'] + $_SESSION['monto'][$i];

                     if($_SESSION['status'][$i]=='E')$statusPago = "EFECTIVO";
                 elseif($_SESSION['status'][$i]=='A')$statusPago = "ANULADO";
                 elseif($_SESSION['status'][$i]=='V')$statusPago = "DEVUELTO";
                 elseif($_SESSION['status'][$i]=='D')$statusPago = "DEPOSITADO";
                 else $statusPago = null;

?>
	   <tr class="<?=$color?>" id="pago<?=$i?>">
        <td align="center" id="id_pago<?=$i?>" name="id_pago<?=$i?>" value="<?=$_SESSION['id_pago'][$i]?>"><?= $_SESSION['id_pago'][$i]?></td>
        <td align="center" id="nroPago<?=$i?>" name="nroPago<?=$i?>" value="<?=$_SESSION['nroPago'][$i]?>"><?= str_pad($_SESSION['nroPago'][$i],8,'0',STR_PAD_LEFT)?></td>
        <td align="right"  id="<?='monto'.$i?>" name="monto<?=$i?>] value="<?=$_SESSION['monto'][$i]?>"><?= formatomonto($_SESSION['monto'][$i])?>&nbsp;</td>
        <td align="center" id="<?='fecha'.$i?>" name="fecha<?=$i?>" value="<?=$_SESSION['fecha'][$i]?>"><?= $_SESSION['fecha'][$i]?></td>
        <td align="center" id="<?='status'.$i?>" name="status<?=$i?>" value="<?=$_SESSION['status'][$i]?>"><?= $statusPago?></td>
        <td align="center" id="<?='id_banco'.$i?>" name="id_banco<?=$i?>" value="<?=$_SESSION['id_banco'][$i]?>"title="<?='N°Cta:'.$_SESSION['id_banco'][$i].'-'.$_SESSION['nroCta'][$i]?>">
    			  <?=$_SESSION['desBanco'][$i]?></td>
        <td align="center" id="<?='codpro'.$i?>" name="codpro<?=$i?> value="<?=$_SESSION['codpro'][$i]?>"><?= $_SESSION['codpro'][$i]?></td>
        <td align="center" id="<?='nomcomp'.$i?>" name="nomcomp<?=$i?>" value="<?=$_SESSION['nomcomp'][$i]?>"><?= $_SESSION['nomcomp'][$i]?></td>
        <td align="center" id="<?='fechaReg'.$i?>" name="fechaReg<?=$i?>" value="<?=$_SESSION['fechaReg'][$i]?>"><?= $_SESSION['fechaReg'][$i]?></td>
       </tr>
	<? } ?>
   <tr><td class="categoria" colspan="2">Total depósito:</td><td align="right"><?=formatomonto($_SESSION['montoTotal'])?>&nbsp;</td></tr>
   </table>
</legend>

 <!-- //////////////////////////////////////////////////////////////////// -->

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
