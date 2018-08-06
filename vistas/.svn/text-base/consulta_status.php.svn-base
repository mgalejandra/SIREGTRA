<?php
session_start();
require('../modelos/conexion.php');
require('../modelos/consulta.php');
require('../controlador/funciones.php');


	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,6,7,11,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23);


$objConsulta = new consulta();

$indReg = $_POST['indReg'];
$cedula = $_POST['cedula'];
$cant = strlen($cedula);

$nroCampos=9;

if ($cant==8){ $cedula=$cedula; }
if ($cant==7){ $cedula='0'.$cedula; }
if ($cant==6){ $cedula='00'.$cedula; }

//$cedula='12640075';

/** Validar captcha */
/*if ((empty($cedula)) and (empty($_REQUEST['captcha']))){
	echo "<script>alert('Debe colocar su numero de c\u00E9dula y la palabra de la imagen');	history.back() </script>";
}
elseif (empty($_REQUEST['captcha'])){
	echo "<script>alert('Debe colocar la palabra de la imagen');	history.back() </script>";
}
elseif (!empty($_REQUEST['captcha'])){
    if (empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha'])
	{
	          echo "<script>alert('La palabra que introdujo no coincide con la de la imagen');	history.back() </script>";
    }
	else
	{*/

	if ($cedula){

			$consultaPresirecov=$objConsulta->consultaPresirecov($cedula);
			$consultaStatus=$objConsulta->consultaStatus($cedula);
			$consultaBenef=$objConsulta->consultaBenef($cedula);
			/*$consultaExpediente=$objConsulta->consultaExpediente($cedula);
			$consultaFacturaProf=$objConsulta->consultaFacturaProf($cedula);
			$consultaBenef=$objConsulta->consultaBenef($cedula);
			$consultaCert=$objConsulta->consultaCert($cedula);
			$consultaCredito=$objConsulta->consultaCredito($cedula);
			$consultaRafaga=$objConsulta->consultaRafaga($cedula);*/

			/*if (($consultaFacturaProf[0]==3) or ($consultaFacturaProf[0]==4) or ($consultaFacturaProf[0]==16)
			or ($consultaFacturaProf[0]==17) or ($consultaFacturaProf[0]==10) or ($consultaFacturaProf[0]==28)
			or ($consultaFacturaProf[0]==25) or ($consultaFacturaProf[0]==12) or ($consultaFacturaProf[0]==26)
			or ($consultaFacturaProf[0]==27) or ($consultaFacturaProf[0]==14) or ($consultaFacturaProf[0]==18)
			or ($consultaFacturaProf[0]==20) or ($consultaFacturaProf[0]==21) or ($consultaFacturaProf[0]==2))
			{
				$estatus=$consultaFacturaProf[1].' - '.$consultaFacturaProf[3];
			}else{
				$estatus=$consultaFacturaProf[1];
			}*/

	}
	/*}

    $request_captcha = htmlspecialchars($_REQUEST['captcha']);

    unset($_SESSION['captcha']);
}*/


?>
<!DOCTYPE HTML PUBLIC >
<html>
<head>
<?php
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
//echo $disc;
?>
<script type="text/javascript">

function enviar(dato) {
 document.form1.indReg.value = dato;
 document.form1.submit();
}

</script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <link href="css/classstyles.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="../controlador/funciones.js"></script>
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

<FORM id="form1" name="form1" method="post" action="">
 <TABLE width="450" align="center" background="imagenes/fon.jpg" border="0">
 <tr >
   <TD height="5" colspan="4" align="center" class="cabecera">Ingrese su N&uacute;mero de C&eacute;dula</TD>
  </TR>
  <TR>
   <TD  class="categoria"><div align="right">N° de C&eacute;dula:&nbsp;</div></TD>
   <TD  class="dato"  ><INPUT type="text" name="cedula" value="" maxlength="8" onkeypress="return acessoNumerico(event)"></TD>
   <TD  class="categoria"></TD>
  </TR>
 <TR>
	<TD align="center" colspan="3" height="30" >
    <INPUT type="button" value="Buscar" onclick="enviar(2)">
   </TD>
  </TR>
 </TABLE>
 <INPUT type="hidden" name="indReg">
<br>

<!--  Datos        -->
<?php if(($consultaPresirecov) or ($consultaStatus))  { ?>
 <TABLE width="450" align="center" background="imagenes/fon.jpg">
   <tr>
   <TD height="5" colspan="2" align="center" class="cabecera">Beneficiario</TD>
  </TR>
   <tr>
   <TD height="5" align="center" width="116" class="categoria">Nombre: </TD>
   <TD height="5" align="center" class="dato"><?php echo $consultaBenef[1] ?></TD>
  </TR>
  <tr>
   <TD height="5" align="center" width="116" class="categoria">C&eacute;dula: </TD>
   <TD height="5" align="center" class="dato"><?php echo $consultaBenef[0] ?></TD>
  </TR>
 </TABLE>
<br>
 <TABLE width="450" align="center" background="imagenes/fon.jpg">
  <tr>
   <TD height="5" colspan="2" align="center" class="cabecera">Estatus</TD>
  </TR>
  <tr>
   <TD height="5" align="center" class="cabecera">Fecha</TD>
   <TD height="5" align="center" class="cabecera">Estatus Solicitud</TD>
  </TR>
 </TABLE>
<?php }elseif ($cedula){ ?>
 <TABLE width="450" align="center" background="imagenes/fon.jpg">
  <tr>
   <TD height="5" align="center" class="cabecera">Expediente No Encontrado o Vencido</TD>
  </TR>
  <tr>
   <TD height="5" align="center" class="dato"><div align="center">Si usted ya consign&oacute; un expediente en SUVINCA debe solicitar una
   												cita electr&oacute;nica para actualizar sus datos</div></TD>
  </TR>
 </TABLE>
<?php } ?>
<!--  fin de Datos        -->

<!--Consulta en PRESIRECOV -->
<?php if ($consultaPresirecov) { $color ='datosimpar' ?>
 <TABLE width="450" align="center" background="imagenes/fon.jpg" border="0">

  <TR class="<?php echo $color ?>">
   <TD  width="116" align="center"><div align="center"><?php echo $consultaPresirecov[3] ?></div></TD>
   <TD align="left"><div align="left">
   		<?php $fecha = date('Y-m-d');
   		if ($consultaPresirecov[4]==1) { $turno='Mañana'; }
   		elseif ($consultaPresirecov[4]==2) { $turno='Tarde'; }
   		//echo 'date '.$fecha;
   		//echo '<br>fecha'.$consultaPresirecov[1];
   			  if (($fecha > $consultaPresirecov[1]) and ($consultaPresirecov[2]<>'S')) { echo 'Cita Vencida'; }
   			  elseif ($consultaPresirecov[2]=='S') { echo 'Expediente Recibido en SUVINCA'; }
   			  elseif (($fecha < $consultaPresirecov[1]) and ($consultaPresirecov[2]=='A')) { echo 'Cita Otorgada - Turno: '.$turno; }
   			  elseif ($consultaPresirecov[2]=='E') { echo 'Cita Anulada'; }
			  elseif ($consultaPresirecov[2]=='C') { echo 'Cita Suspendida por No Disponibilidad'; }
   		?>
   </div></TD>
   </TR>
 </TABLE>
<?php } ?>
<!--FIN Consulta en PRESIRECOV -->

<table width="450" align="center" background="imagenes/fon.jpg" border="0">

<?php
        for($i=0;$i<count($consultaStatus);$i+=$nroCampos){
          if($consultaStatus[$i]){
             if(!$indC){
                 $color ='datosimpar';
                 $indC = true;
             }
             else{
                 $color ='datospar';
                 $indC = false;
             }
if ($consultaStatus[$i+3]<>0) $intt=$consultaStatus[$i+2].' '.$consultaStatus[$i+3];
else $intt='';

if ($consultaStatus[$i+4]==0 and $consultaStatus[$i+3]==0 and $consultaStatus[$i+7]==0 )
	$enviado=$consultaStatus[$i+2].''.$consultaStatus[$i+6];
else $enviado='';

if ($consultaStatus[$i+7]<>0) $monto=$consultaStatus[$i+2].' '.$consultaStatus[$i+7].' '.$consultaStatus[$i+6];
else $monto='';

if (($consultaStatus[$i+4]==3) or ($consultaStatus[$i+4]==4) or ($consultaStatus[$i+4]==16)
	or ($consultaStatus[$i+4]==17) or ($consultaStatus[$i+4]==10) or ($consultaStatus[$i+4]==28)
	or ($consultaStatus[$i+4]==25) or ($consultaStatus[$i+4]==12) or ($consultaStatus[$i+4]==26)
	or ($consultaStatus[$i+4]==27) or ($consultaStatus[$i+4]==14) or ($consultaStatus[$i+4]==18)
	or ($consultaStatus[$i+4]==20) or ($consultaStatus[$i+4]==21) or ($consultaStatus[$i+4]==2))
	{
				$estatus=$consultaStatus[$i+5].' - '.$consultaStatus[$i+6];
	}else{
				$estatus=$consultaStatus[$i+5];
	}

//echo 'intt'.$intt;
//echo '$monto'.$monto;
//echo 'hola'.$estatus;
//echo $consultaStatus[$i+4];
?>

              <tr class="<?php echo $color ?>">
               <td align="center" width="116"><?php echo $consultaStatus[$i];?></td>
               <td align="left"><?php echo $intt.' '.$consultaStatus[$i+1].''.$estatus.' '.$monto.' '.$enviado;?></td>
			  </tr>

 <?php     }
        }
?>
 </TABLE>
<!--
Consulta en EXPEDIENTE
<?php if ($consultaExpediente) { ?>

 <TABLE width="450" align="center" background="imagenes/fon.jpg" border="0">
 <tr>
   <TD class="dato" width="116"><div align="center"><?php echo $consultaExpediente[0];?></div></TD>
   <TD class="dato">Expediente Enviado - <?php echo $consultaExpediente[2];?></TD>
 </TR>
 </TABLE>

<?php } ?>
Fin Consulta en EXPEDIENTE
Consulta en Credito
<?php if ($consultaCredito) { ?>
 <TABLE width="450" align="center" background="imagenes/fon.jpg" border="0">
 <tr>
   <TD class="dato" width="116"><div align="center"><?php echo $consultaCredito[0];?></div></TD>
   <TD class="dato"><?php echo $consultaCredito[1];?> - <?php echo $consultaCredito[2];?><? if ($consultaCredito[3]){ echo ' - Monto '.$consultaCredito[3]; } ?></TD>
 </TR>
 </TABLE>
<?php } ?>
Fin Consulta en Credito

Consulta en Certificado
<?php if ($consultaCert) { ?>
 <TABLE width="450" align="center" background="imagenes/fon.jpg" border="0">
 <tr>
   <TD class="dato" width="116"><div align="center"><?php echo $consultaCert[3];?></div></TD>
   <TD class="dato">Certificado enviado - <?php echo $consultaCert[4];?></TD>
 </TR>
 </TABLE>
<?php } ?>
Fin Consulta en Certificado

Consulta en Factura Proforma
<?php if ($consultaFacturaProf) {
 	if (($consultaFacturaProf>=25) AND ($consultaFacturaProf<=29) ){?>
 <TABLE width="450" align="center" background="imagenes/fon.jpg" border="0">
 <tr>
   <TD height="5" colspan="2" align="center" class="cabecera">ALERTA</TD>
 </TR>
 <tr>
   <TD class="dato" width="116"><div align="center"><?php echo $consultaFacturaProf[2];?></div></TD>
   <TD class="dato"><?php if ($estatus) echo $estatus;
   						  else echo $consultaFacturaProf[1]?></TD>
 </TR>
 </TABLE>
<?php } else { ?>
 <TABLE width="450" align="center" background="imagenes/fon.jpg" border="0">
 <tr >
   <TD class="dato" width="116"><div align="center"><?php echo $consultaFacturaProf[2];?></div></TD>
   <TD class="dato"><?php if ($estatus) echo $estatus;
   						  else echo $consultaFacturaProf[1]?></TD>
 </TR>
 </TABLE>
<?php } ?>
<?php } ?>
Fin Consulta en Factura Proforma
<BR>
Consulta en Rafaga
<?php if ($consultaRafaga) { ?>
 <TABLE width="450" align="center" background="imagenes/fon.jpg" border="0">
  <tr>
   <TD height="5" align="center" class="cabecera">Fecha</TD>
   <TD height="5" align="center" class="cabecera">N° Env&iacute;o</TD>
   <TD height="5" align="center" class="cabecera">Estatus Solicitud</TD>
 </TR>
 <tr>
   <TD class="dato" width="116"><div align="center"><?php echo substr($consultaRafaga[1],0,10);?></div></TD>
   <?php  ?>
   <TD class="dato"><div align="center"><?php echo $consultaRafaga[0];?></div></TD>
   <TD class="dato">Datos enviados al INTT</TD>
 </TR>
 </TABLE>
<?php } ?>
<br>
Fin Consulta en Rafaga
-->
</FORM>
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