<?php
session_start();
require('../modelos/conexion.php');
require('../modelos/factura.php');
require('../controlador/funciones.php');
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
/*$permitidos = array(1,9,10);
validaAcceso($permitidos,$dir);*/

	   $objFactura = new factura();

       $indReg = $_POST['indReg'];
       $permite = $_POST['permite'];

	   $fechaR = $_POST['fecha'];
       $fecha = date('dmY');

	   $idFactura = $_GET['id'];


	   if ($idFactura){
  		  $listarFactura=$objFactura->reporteFactura($idFactura);
  		  $codproc=$listarFactura[13];
  		  $serial=$listarFactura[11];
	  }

   	   $destino = "../vistas/reconsideraciones/";
       $tam = $_POST['MAX_FILE_SIZE'];

      if ($indReg==22)
      {
      	  $datos[0] = $idFactura;

	     if ($_FILES['reserva']){
			 $datos[1] = $destino."".$datos[0]."_".$fecha."_".$_FILES['reserva']['name'];
   			 graba_documento($_FILES['reserva'],$datos[0],$destino,$tam,$fecha);
    	 }

    	 $datos[2] = $fechaR;

 		  $actualizaR = $objFactura->actualizaReconDoc($datos,$codproc,$serial);

 		if ($actualizaR)
 		{
 		 	echo '<SCRIPT>alert("Carta de reconsideración registrada");</SCRIPT>';
        	echo "<SCRIPT>window.opener.document.form1.submit();</SCRIPT>";
        	echo "<SCRIPT>window.close();</SCRIPT>";
    	}
      }

?>

<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
<script type="text/javascript">
   function validar(reg){
    var indErr = 0;
    var dato;
    var error;

    archivo=document.getElementById('reserva').value;
    if (archivo){
    	if(validaExt(archivo)){
    		error = "Debe seleccionar Archivo con Extension PDF, ODT o Doc ";
    		indErr = 1;
    	}
    }
    else{
    		error = "Debe seleccionar Un Archivo ";
    		indErr = 1;
    }


    dato = document.getElementById('fecha').value;
    if(dato.length == 0){
    	error = "Debe indicar una Fecha de Reserva";
    	indErr = 1;
    }else if(dato.length!=0){
        var fecha=new Date();
        var fec=(fecha.getFullYear());
		var m=(fecha.getMonth()+1);
		//var d=(fecha.getDate()-1);
		var d=(fecha.getDate());
		dia=(dato).substr(0,2);
      	mes=(dato).substr(3,2);
      	ano=(dato).substr(6,4);
      	if (parseFloat(mes)<10)mes=(mes).substr(1,2);

      	        if (parseFloat(ano)>parseFloat(fec)){
				     error = 'El año no puede ser Mayor al Actual ';
				     indErr = 1;
      			 }
      			 if (parseFloat(mes)>12){
				     error = 'El mes debe ser menor o igual a 12';
				     indErr = 1;
      			 }

				if (parseFloat(ano)==parseFloat(fec)){
      			 	if (parseFloat(mes)>parseFloat(m)){
				     	error = 'El mes no puede ser Mayor al Actual ';
				     	indErr = 1;
      			 	}
				}

      			if (parseFloat(dia)>31){
				     error = 'El dia debe ser menor o igual a 31';
				     indErr = 1;
      			 }
      			 if (parseFloat(ano)==parseFloat(fec)){
      			 	if (parseFloat(mes)==parseFloat(m)){
      			 		if (parseFloat(dia)>parseFloat(d)){
				     		error = 'El dia no puede ser Mayor al Actual ';
				    		indErr = 1;
      			 		}
      			 	}
      			 }
    }

    valor = document.getElementById("errorloc");
    if(indErr){
       valor.innerHTML = error;
    }else{
       enviar(reg);
    }


}

	function enviar(dato){
			 document.reserva.indReg.value = dato;
			 document.reserva.submit();
			  window.opener.document.getElementById('indReg').value='18';
			  window.opener.document.form1.submit();

}
</SCRIPT>
<body class="pagina">
<form name="reserva" method="post" action="" enctype="multipart/form-data">
<fieldset >
  <legend>&nbsp;Cargar Carta de Reconsideración
	<TABLE  width="550">
	<tr>
			<td class="cabecera">Fecha</td>
			<td align="left">
			 <input name="fecha" type="text" id="fecha" onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)" value="" size="10"  maxlength="10" date_format="dd/MM/yy" readonly=""/>
             <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecha',document.forms[0].fecha.value)" />
		    <tr>
			<td class="cabecera">Carta Reconsideraci&oacute;n:</td>
			<td colspan="5" align="left">
			<input type="hidden" name="MAX_FILE_SIZE" value="2097152">
			<input name="reserva" id="reserva" type="file"  size="13" > (Archivo .doc, .odt o .pdf)<br>
			</td>
	</tr>

			<tr><td colspan="6">
			<?php //if($indReg1<>32){?>
  			  <input name="Guardar" type="button" onClick="validar(22)"  value="Guardar">
  			<?php //}?>
  			<input type="hidden" name="indReg">
  			<input type="hidden" name="permite">
  			<!--div para errores de validacion-->
			   <div id='errorloc' class='error_valid' align="center"></div></td></tr>
     </table>
      </fieldset>
  </legend>
      </form>
  </body>
</html>