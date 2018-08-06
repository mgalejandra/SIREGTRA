<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/beneficiario.php');
require('../modelos/zona.php');
require('../modelos/factura.php');
require('../modelos/reclamos.php');
require('../modelos/correo.php');
require('../modelos/citas.php');
$objFactura = new factura();
$objBeneficiario = new beneficiario();
$objReclamos = new reclamos();
$objCorreo = new correo();
$objCita = new citas();
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,11,13,14,17,22);
validaAcceso($permitidos,$dir);
/*$ban=0;
$indReg=$_POST['indReg'];
$cedula=$_GET['id'];
$cita=$_GET['cita'];
$rif=$_GET['rif'];

$rif2=$_POST['rif2'];*/

//echo 'hola1'.$rif2;
//echo '<br>holaaaaa'.$cedula;

//echo $datosCitas[35];

$indReg=$_POST['indReg'];
$tramite=$_POST['tramite'];
$numrifSS=substr($_POST['numrifSS'],0,8);

$cantidad = $_POST['cant_campos'];
//echo 'hola'.$indReg;
//echo 'tramite'.$tramite;

if($numrifSS){

	$listarFactura=$objFactura->reporteFactura('','',$numrifSS);
	if (!$listarFactura){
		echo "<script>alert('Usuario no Registrado en Sistema');</script>";
		echo "<SCRIPT>window.location.href='regReclamos.php';</SCRIPT>";
	}
	$datosCitas=$objCita->datosCitasUsuario($numrifSS,'');

}else{
	$numrifSS==null;
}

if ($listarFactura){
	$detalleVehiculo=$objFactura->detalleVehiculo($listarFactura[9]);
}


if($indReg=='2'){
	$correoB=$listarFactura[56];
	$correoEn=$_POST['correoEn'];
	$nombre=$listarFactura[12];
	$cedula=$_POST['cedula'];

	if ($tramite=='1'){
		$cert=$_POST['cert'];
		$factura=$_POST['factura'];
		if (($factura=='on') and ($cert=='on')){
			$detalle[0]=29;
			$detalle[1]=30;
		}else{
			if ($factura=='on') $detalle[0]=29;
			if ($cert=='on') $detalle[0]=30;
		}
	}

	if ($tramite=='2'){
	$campo=$_POST['campo'];
	$desc=$_POST['desc'];
	for ($i = 0; $i < $cantidad; $i++) {
        $detalle[$i * 2] = $campo[$i];
        $detalle[$i * 2 + 1] = $desc[$i];
    }
	/*echo 'cant'.$cantidad;echo 'hola2';for ($j = 0; $j < $cantidad; $j++) {echo 'hola3';echo 'campo'.$detalle[$j* 2];echo 'desc'.$detalle[$j* 2 + 1];}*/
	}
	if ($tramite=='3'){
		$detalle=$_POST['intt'];
	}
	if ($tramite=='4'){
		$kil=$_POST['kil'];;
		$falla=$_POST['falla'];
		$obser=$_POST['obser'];

	for ($i = 0; $i < $cantidad; $i++) {
        $detalle[$i * 2] = $falla[$i];
        $detalle[$i * 2 + 1] = $obser[$i];
    }

	}

$regReclamo=$objReclamos->registroReclamo($cedula,$tramite,$kil,$detalle);

if ($regReclamo){
	echo "<script>alert('Reclamo Registrado');</script>";
	$reclamos_des = $objReclamos->listarTipoReclamo('',$tramite);

	$regCorreo=$objCorreo->enviarCorreoReclamo($regReclamo,$cedula,$correoB,$correoEn,$nombre,$reclamos_des[1]);

	echo "<SCRIPT>window.location.href='tickReclamos.php?id=" .$regReclamo[0]. "&cedula=".$cedula."&tramite=".$tramite."';</SCRIPT>";
}

}


if($tramite=='3'){
	$envio=$objFactura->envio($listarFactura[9]);
}

if($tramite=='4'){
	$entrega=$objFactura->entrega($listarFactura[9]);
}


$objZona= new zona();
$buscarEstados = $objZona->buscarEstados($listarFactura[25]);
$buscarMunicipio = $objZona->buscarMunicipios($listarFactura[26],$listarFactura[25]);
$buscarParroquia = $objZona->buscarParroquias($listarFactura[27],$listarFactura[25],$listarFactura[26]);
//echo 'hola'.$datosCitas[6];

$reclamos = $objReclamos->listarTipoReclamo();
$reclamos2 = $objReclamos->listarTipoReclamo($tramite);

?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
      <script type="text/javascript" src="../controlador/jquery.js"></script>
    <script type="text/javascript" src="../controlador/jquery-ui.js"></script>
    <script type="text/javascript" src="../controlador/jquery.idle-timer.js"></script>
<SCRIPT LANGUAGE='JavaScript'>

var txt=" Registro de Beneficiario del Sistema de Vehiculos SUVINCA ";
var espera=100;
var refresco=null;
function rotulo_title( ) {
document.title=txt;
txt=txt.substring(1,txt.length
)+txt.charAt(0);
refresco=setTimeout("rotulo_title( )",espera);}
//rotulo_title( );

	function popup(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=400,height=400');");
	}

    function enviarS(dato){

 		document.form1.indReg.value = dato;
 		document.form1.submit();
    }

    function guardarD(dato){
      	//alert('entro'+dato);
 		//document.form1.indReg.value = dato;
 		//document.form1.submit();

 		indErr=0;
		dato1 = document.getElementById("numrifSS").value;

		if (dato1.length == 0){
  			error = "Debe Ingresar el Numero de Cedula del Veneficiario";
            		indErr = 1;
		}

		valor = document.getElementById("errorloc3");
        	if(indErr){
        	valor.innerHTML = error;
        	}else {

 		tramite=document.getElementById('tramite').value;
		if (tramite==1){
			indErr=0;
			dato1 = document.getElementById("factura");
			dato2 = document.getElementById("cert");
			if ((!dato1.checked ) && (!dato2.checked )){
  				error = "Debe seleccionar un tipo de Documentacion";
            	indErr = 1;
			}
			valor = document.getElementById("errorloc3");
        	if(indErr){
        		valor.innerHTML = error;
        	}else {
        		//alert('entro'+dato);
				document.form1.indReg.value = dato;
 				document.form1.submit();
			}
		}
		if (tramite==2){

			document.form1.indReg.value = dato;
 			document.form1.submit();
		}

		if (tramite==3){
			indErr=0;

			dato1 = document.getElementById("intt").value;

			if (dato1.length == 0){
  				error = "Debe Ingresar el problema del Registro";
            	indErr = 1;
			}

			valor = document.getElementById("errorloc3");
        	if(indErr){
        		valor.innerHTML = error;
        	}else {
				document.form1.indReg.value = dato;
 				document.form1.submit();
		}
		}

		if (tramite==4){
			indErr=0;

			dato1 = document.getElementById("kil").value;

			if (dato1.length == 0){
  				error = "Debe Ingresar el Kilometraje del Vehiculo";
            	indErr = 1;
			}

			valor = document.getElementById("errorloc3");
        	if(indErr){
        		valor.innerHTML = error;
        	}else {
				document.form1.indReg.value = dato;
 				document.form1.submit();
		}
		}
      }
	}

   function enviarDatos(dato){
		//alert('entro'+dato);

        document.form1.indReg.value = dato;
 		document.form1.submit();

    }

function agregarFila(obj){
                indErr=0;
                dato = document.getElementById('campo').value;
                if(dato.length == 0){
                    error = "Debe indicar un Campo";
                    indErr = 1;
                }
                dato = document.getElementById('desc').value;
                if(dato.length == 0){
                    indErr = 1;
                    error = "Debe indicar un Campo";
                }
                valor = document.getElementById("errorloc");
                if(indErr){
                    valor.innerHTML = error;
                }
                else {
                    valor.innerHTML = "";
                    obj.value = parseInt(obj.value) + 1;
                    var oId = obj.value;

                    var campo = document.getElementById("campo");
                    var desc = document.getElementById("desc");

					var combo = document.getElementById("campo");
					var selected = combo.options[combo.selectedIndex].text;
					//alert(selected);

                    var strHtml1 = selected + '<input type="hidden" id="campo2' + oId + '" name="campo2[]' + oId + '" value="' + campo.value + '"/>' ;
                    var strHtml2 = desc.value + '<input type="hidden" id="desc' + oId + '" name="desc[]' + oId + '" value="' + desc.value + '"/>' ;
                    var strHtml3 = campo.value + '<input type="hidden" id="campo' + oId + '" name="campo[]' + oId + '" value="' + campo.value + '"/>' ;
                    var strHtml11 = '<img src="imagenes/delete.png" width="16" height="16" alt="Eliminar" onclick="if(confirm(\'Realmente desea eliminar este detalle?\')){eliminarFila(' + oId + ');}"/>';
                    strHtml11 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" />';

                    var
                    objTr = document.createElement("tr");
                    objTr.id = "rowDetalle_" + oId;

                    var
                    objTd1 = document.createElement("td");
                    objTd1.id = "tdDetalle_1_" + oId;
                    objTd1.innerHTML = strHtml1;

                    var
                    objTd2 = document.createElement("td");
                    objTd2.id = "tdDetalle_2_" + oId;
                    objTd2.innerHTML = strHtml2;

					var
					objTd3 = document.createElement("input");
                    objTd3.id = "tdDetalle_3_" + oId;
                    objTd3.type='hidden';
                    objTd3.innerHTML = strHtml3;

                    var
                    objTd11 = document.createElement("td");
                    objTd11.id = "tdDetalle_11_" + oId;
                    objTd11.innerHTML = strHtml11;

                    objTr.appendChild(objTd3);
                    objTr.appendChild(objTd1);
                    objTr.appendChild(objTd2);
                    objTr.appendChild(objTd11);

                    var objTbody = document.getElementById("tbDetalle");
                    objTbody.appendChild(objTr);

                    document.getElementById("desc").value="";
                    document.getElementById("campo").value="";

                    return false;	//evita que haya un submit por equivocacion.
                }

            }
            function eliminarFila(oId){
                var objHijo = document.getElementById('rowDetalle_' + oId);
                var objPadre = objHijo.parentNode;
                objPadre.removeChild(objHijo);
                document.getElementById('cant_campos').value=document.getElementById('cant_campos').value-1
                return false;
            }

            function cancelar(){
                var obj = document.getElementById('tbDetalle');
                var objPadre = obj.parentNode;
                objPadre.removeChild(obj);
                obj = document.createElement("tbody");
                obj.id = 'tbDetalle';
                objPadre.appendChild(obj);
                return false;
            }

	//--------------Datos Inntt

	function agregarFila2(obj){
		//alert('hola');
                indErr=0;
                dato = document.getElementById('falla').value;
                if(dato.length == 0){
                    error = "Debe indicar una Fallas";
                    indErr = 1;
                }
                dato = document.getElementById('obser').value;
                if(dato.length == 0){
                	//alert('hola1')
                    indErr = 1;
                    error = "Debe indicar una Descripcion";
                }
                valor = document.getElementById("errorloc2");
                if(indErr){
                    valor.innerHTML = error;
                }

                else {//alert('hola')
                    valor.innerHTML = "";
                    obj.value = parseInt(obj.value) + 1;
                    var oId = obj.value;

                    var falla = document.getElementById("falla");
                    var obser = document.getElementById("obser");

					var combo = document.getElementById("falla");
					var selected = combo.options[combo.selectedIndex].text;
					//alert(selected);

                    var strHtml1 = selected + '<input type="hidden" id="falla2' + oId + '" name="falla2[]' + oId + '" value="' + falla.value + '"/>' ;
                    var strHtml2 = obser.value + '<input type="hidden" id="obser' + oId + '" name="obser[]' + oId + '" value="' + obser.value + '"/>' ;
                    var strHtml3 = falla.value + '<input type="hidden" id="falla' + oId + '" name="falla[]' + oId + '" value="' + falla.value + '"/>' ;
                    var strHtml11 = '<img src="imagenes/delete.png" width="16" height="16" alt="Eliminar" onclick="if(confirm(\'Realmente desea eliminar este detalle?\')){eliminarFila(' + oId + ');}"/>';
                    strHtml11 += '<input type="hidden" id="hdnIdCampos_' + oId +'" name="hdnIdCampos[]" value="' + oId + '" />';

                    var
                    objTr = document.createElement("tr");
                    objTr.id = "rowDetalle_" + oId;

                    var
                    objTd1 = document.createElement("td");
                    objTd1.id = "tdDetalle_1_" + oId;
                    objTd1.innerHTML = strHtml1;

                    var
                    objTd2 = document.createElement("td");
                    objTd2.id = "tdDetalle_2_" + oId;
                    objTd2.innerHTML = strHtml2;

					var
					objTd3 = document.createElement("input");
                    objTd3.id = "tdDetalle_3_" + oId;
                    objTd3.type='hidden';
                    objTd3.innerHTML = strHtml3;

                    var
                    objTd11 = document.createElement("td");
                    objTd11.id = "tdDetalle_11_" + oId;
                    objTd11.innerHTML = strHtml11;

                    objTr.appendChild(objTd3);
                    objTr.appendChild(objTd1);
                    objTr.appendChild(objTd2);
                    objTr.appendChild(objTd11);

                    var objTbody = document.getElementById("tbDetalle2");
                    objTbody.appendChild(objTr);

                    document.getElementById("intt").value="";
                    document.getElementById("falla").value="";

                    return false;	//evita que haya un submit por equivocacion.
                }

            }
            function eliminarFila2(oId){
                var objHijo = document.getElementById('rowDetalle_' + oId);
                var objPadre = objHijo.parentNode;
                objPadre.removeChild(objHijo);
                document.getElementById('cant_campos').value=document.getElementById('cant_campos').value-1
                return false;
            }

            function cancelar2(){
                var obj = document.getElementById('tbDetalle2');
                var objPadre = obj.parentNode;
                objPadre.removeChild(obj);
                obj = document.createElement("tbody");
                obj.id = 'tbDetalle2';
                objPadre.appendChild(obj);
                return false;
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
  <input type="hidden" id="num_campos" name="num_campos" value="0" />
  <input type="hidden" id="cant_campos" name="cant_campos" value="0"/>
  <input type="hidden" name="indReg"/>

  <table class="formulario" width="822" border="0" align="center" >
  	<tr>
        <td colspan="6" class="cabecera">Datos Usuario</td>
    </tr>
    <tr>
      <td  class="categoria">RIF / CI:</td>
      <td colspan="2" class="dato" >
      <select name="nac" size="1" id="nac">

          <option value="V">V</option>
          <option value="V">J</option>
          </select>
          -
          <input name="numrifSS" type="text" id="numrifSS" onkeypress="return acessoNumerico(event)"
          value="<?=$numrifSS?>" size="12" maxlength="8"/>
      </td>
      <td colspan="2" class="dato">
		  <select name="tramite" size="1" id="tramite">
		  <?php if ($tramite){ ?>
		  <option value="<?php if ($tramite) echo $tramite; ?>"><?php if ($tramite) $reclamosB = $objReclamos->listarTipoReclamo('',$tramite); echo $reclamosB[1]?></option>
		  <?php } ?>
		  <?php for($i=0;$i<11;$i+=3){  ?>
	      <option value="<?php  echo $reclamos[$i]; ?>"><?php echo $reclamos[$i+1]?></option>
	      <?php } ?>


          <!--	<option value="1">Registro de Reclamos por Documentación</option>
          	<option value="2">Corrección de Errores Materiales</option>
          	<option value="3">Reclamos Dirigidos a los Tramites Realizados ante el INTTT.</option>
          	<option value="4">Reclamo por Defectos y Daños Mecánicos</option> -->
          </select>
      </td>
      <td class="dato">
      	<input type="submit" value="Buscar" onclick="enviarDatos(1)"/>
      </td>
    </tr>
  </table>
  <table class="formulario" width="822" border="0" align="center" >
      <tr>
        <td colspan="6" class="cabecera">Datos del Beneficiario </td>
      </tr>
      <tr>
        <td class="categoria">RIF / CI:</td>
        <td  class="dato" >
        <?PHP echo $listarFactura[13] ?>
        <input type="hidden" id="cedula" name="cedula" value="<?php echo $listarFactura[13] ?>"/>
		</td>
		<td class="categoria">Nombre:</td>
        <td colspan="6" class="dato">
         <?PHP echo $listarFactura[12]?>
        </td>
      </tr>
      <tr>
        <td colspan="6" class="cabecera">Datos Cita</td>
      </tr>
      <tr>
        <td class="categoria">Fecha Registro Cita</td>
        <td class="dato">
         <?PHP echo $datosCitas[1]?>
        </td>
        <td class="categoria">Fecha Cita</td>
        <td class="dato">
         <?PHP echo $datosCitas[5]?>
        </td>
        <td class="categoria">Estatus Cita</td>
         <? if ($datosCitas[6]=='A') { ?> <td align="center">Pendiente</td><? } ?>
         <? if ($datosCitas[6]=='S'){ ?><td align="center">Asistio</td><? } ?>
         <? if ($datosCitas[6]=='V'){ ?><td align="center">Vencida</td><? } ?>
         <? if ($datosCitas[6]=='E'){ ?><td align="center" class="error_valid" >Cita Bloqueada</td><? } ?>
      </tr>
      <tr>
        <td colspan="6" class="cabecera">Direccion </td>
      </tr>
      <tr>
        <td class="categoria">Calle/avenida:</td>
        <td colspan="3" class="dato">
         <?PHP echo $listarFactura[14]?>
        </td>
        <td class="categoria">Urb. o Barrio:</td>
        <td colspan="2" class="dato">
         <?PHP echo $listarFactura[15]?>
        </td>
      </tr>
      <tr>
		<td class="categoria">Edificio/casa/quinta:</td>
        <td class="dato" >
          <?PHP echo $listarFactura[16]?>
       </td>
        <td class="categoria">N&uacute;mero de piso:</td>
        <td class="dato" >
          <?PHP echo $listarFactura[17]?>
       </td>
       <td class="categoria">N° de Apartamento:</td>
        <td class="dato" >
          <?PHP echo $listarFactura[18]?>
      </td>
      </tr>
      <TR>
    <TD width="175" class="categoria"><strong>Estado:<?php echo $listarBeneficiario[$i+38];?></strong></TD>
    <TD class="dato">
    	<?PHP echo $buscarEstados[1]?>
    </TD>
        <TD width="175" class="categoria"><strong>Municipio:</strong></TD>
    <TD  class="dato">
        <?PHP echo $buscarMunicipio[1]?></TD>
        <TD width="175" class="categoria"><strong>Parroquia:</strong></TD>
    <TD  class="dato">
        <?PHP echo $buscarParroquia[1]?></TD>
  </TR>
      <tr>
        <td class="categoria"> Tlf/Celular 1:</td>
        <td class="dato" >
          <?PHP echo $listarFactura[21]?></TD>
       </td>
        <td class="categoria">Tlf/celular 2:</td>
        <td class="dato" >
          <?PHP echo $listarFactura[22]?></TD>
       </td>
       <td class="categoria">Correo:</td>
        <td  >
          <?PHP echo $listarFactura[56]?></TD>
       </td>
      </tr>
  <tr>
        <td colspan="6" class="cabecera">Datos del Vehiculo</td>
      </tr>

      <tr>
      	<td class="categoria">MARCA:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[5]?>
        </td>
        <td class="categoria">MODELO:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[6]?>
        </td>
        <td class="categoria">PLACA:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[1]?>
        </td>
      </tr>

      <tr>
      	<td class="categoria">SERIE/VERSION:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[7]?>
        </td>
        <td class="categoria">AÑO DE FABRICACION:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[8]?>
        </td>
        <td class="categoria">AÑO DE MODELO:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[9]?>
        </td>
      </tr>

      <tr>
        <td class="categoria">SERIAL DE CARROCERIA:</td>
        <td class="dato" colspan="3">
         <?PHP echo $detalleVehiculo[2]?>
        </td>
        <td class="categoria">SERIAL DE MOTOR:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[10]?>
        </td>
      </tr>

      <tr>
      	<td class="categoria">COLOR(ES):</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[12].' '.$detalleVehiculo[13];?>
        </td>
        <td class="categoria">CLASE:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[14]?>
        </td>
        <td class="categoria">TIPO:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[15]?>
        </td>
      </tr>

      <tr>
      	<td class="categoria">USO:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[16]?>
        </td>
        <td class="categoria">N° DE PUESTOS:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[17]?>
        </td>
        <td class="categoria">N° DE EJES:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[18]?>
        </td>
      </tr>

      <tr>
      	<td class="categoria">PESO (TARA):</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[19]?>
        </td>
        <td class="categoria">CAPACIDAD DE CARGA:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[20]?>
        </td>
        <td class="categoria">TIPO DE COMBUSTIBLE:</td>
        <td class="dato">
         <?PHP echo $detalleVehiculo[11]?>
        </td>
      </tr>

   <?php if ($tramite==1){ ?>
	<tr>
		<td colspan="6" class="cabecera">Registro de Reclamos por Documentación</td>
	</tr>
	<tr>
	<td colspan="3" class="dato"><input type=checkbox name=factura id=factura >Factura Original</td>
	<td colspan="3" class="dato"><input type=checkbox name=cert id=cert >Certificado de Origen</td>
	</tr>
	<?php } ?>

	<?php if ($tramite==2){ ?>
	<tr>
		<td colspan="6" class="cabecera">Corrección de Errores Materiales</td>
	</tr>
<tr>
		<td class="categoria">Campo:</td>
        <td class="dato" colspan="2">
         <select name="campo" size="1" id="campo">
          	<?php for($i=0;$i<count($reclamos2);$i+=3){  ?>
	        <option value="<?php echo $reclamos2[$i]; ?>"><?php echo $reclamos2[$i+1]?></option>
	        <?php } ?>


          <!-- <option value="1">Cedula</option>
          <option value="2">Digito Rif</option>
          <option value="3">Nombre</option>
          <option value="4">Apellido</option>
          <option value="5">Nombre Completo</option>
          <option value="6">Calle/Avenida</option>
          <option value="7">Urb. o Barrio</option>
          <option value="8">Edificio/Casa/Quinta</option>
          <option value="9">Piso</option>
          <option value="10">Apartamento</option>
          <option value="11">Estado</option>
          <option value="12">Municipio</option>
          <option value="13">Parroquia</option>
          <option value="14">Tlf/Celular 1</option>
          <option value="15">Tlf/celular 2</option> -->
         </select>
        </td>
        <td  class="dato">
         <input name="desc" type="text" id="desc" value="" size="20" maxlength="20"/>
        </td>
        <td class="dato">
                <input type="reset" id="btnCancel" name="btnCancel" value="Cancelar" class="btn btncancel" onclick="cancelar();"/>
        </td>
        <td class="dato">

            	<input type="button" id="btnAgregar" name="btnAgregar" value="Agregar" class="btn btnadd" onclick="agregarFila(document.getElementById('cant_campos'));"/>
        </td>
	</tr>
	<tr><div id='errorloc' class="error_valid" align="center"></div></tr>
    <tr>
    <td colspan="6">
    <table align = 'center' width="500">
    <tr class="cabecera">
                <td width="60">Campo</td>
                <td width="70">Descripcion</td>
                <td width="20" height="15">Eliminar</td>
    </tr>
    <tbody id="tbDetalle"></tbody>
    </table>
    </td>
    </tr>

	<?php } ?>

	<?php if ($tramite==3){ ?>
	<tr>
		<td colspan="6" class="cabecera">Reclamos Dirigidos a los Tramites Realizados ante el INTTT</td>
	</tr>
	<tr>
		<td class="categoria" colspan="2" >Estatus de Envio</td>
		<?php if ($envio) {?>
		<td colspan="4" class="dato"> <?php echo "DATOS ENVIADOS AL INTT N° DE ENVIO ". $envio[1] ." EN FECHA ".$envio[0] ?></td>
		<?php } else {?>
		<td colspan="4" class="dato"> <?php echo "NO SE A REALIZADO EL ENVIO" ?></td>
		<?PHP } ?>
	</tr>
	<tr>
	<td class="categoria" colspan="2">Problemas Registro de Vehiculo</td>
	<td class="dato" colspan="4"><textarea name="intt" type="text" id="intt" cols="50"></textarea></td>
	</tr>
	<?php } ?>

	<?php if ($tramite==4){ ?>
	<tr>
	<td colspan="6" class="cabecera">Reclamo por Defectos y Daños Mecánicos</td>
	</tr>
<tr>
<td colspan="6">
<table class="formulario" width="822" border="0" align="center">
	<tr>
		<td class="categoria">Fecha de Factura:</td>
		<td class="dato"><?php echo $entrega[3]?></td>
		<td class="categoria">Fecha de Entrega:</td>
		<td class="dato"><?php echo $entrega[0]?></td>
	</tr>
	<tr>
		<td class="categoria">Lugar:</td>
		<td class="dato"><?php echo $entrega[1]?></td>
		<td class="categoria">Acto:</td>
		<td class="dato"><?php echo $entrega[2]?></td>
	</tr>
	<tr>

	<td class="categoria">Kilometraje</td>
	<td class="dato" ><input name="kil" type="text" id="kil" size="12"/></td>
	</tr>
	<tr>
		<td class="categoria">Tipo de Falla</td>
	<td class="dato" >
	     <select name="falla" size="1" id="falla">
	     <?php for($i=0;$i<count($reclamos2);$i+=3){  ?>
	        <option value="<?php echo $reclamos2[$i]; ?>"><?php echo $reclamos2[$i+1]?></option>
	     <?php } ?>

         <!-- <option value="1">Llave</option>
          <option value="2">Herramientas</option>
          <option value="3">Rayones en la Pintura</option>
          <option value="4">Abolladuras</option>
          <option value="5">Desperfecto Mecánico</option> -->


         </select>
	</td>
	<td class="categoria" >Observaciones</td>
	<td class="dato"><textarea name="obser" type="text" id="obser" cols="50"></textarea></td>
	</tr>
	<tr><td colspan="6"><div id='errorloc2' class="error_valid" align="center"></div></td></tr>
	<tr>
	<td colspan="2" align="center">
                <input type="reset" id="btnCancel" name="btnCancel" value="Cancelar" class="btn btncancel" onclick="cancelar2();"/>
        </td>
        <td colspan="2" align="center">

            	<input type="button" id="btnAgregar" name="btnAgregar" value="Agregar" class="btn btnadd" onclick="agregarFila2(document.getElementById('cant_campos'));"/>
        </td>
	</tr>

	<td colspan="6">
    <table align = 'center' width="500">
    <tr class="cabecera">
                <td width="60">Campo</td>
                <td width="70">Descripcion</td>
                <td width="20" height="15">Eliminar</td>
    </tr>
    <tbody id="tbDetalle2"></tbody>
    </table>
    </td>
</table
</td>
</tr>

	<?php } ?>
<tr>
	<td colspan="3" class="cabecera">Correo Encargado: </td>
	<td colspan="3" class="dato" align="center">
	<select name="correoEn" size="1" id="falla" >
		<option value="reclamo.sirecov@suvinca.gob.ve">reclamo.sirecov@suvinca.gob.ve</option>
    </select>
	</td>
</tr>
 </table>

 <table class="formulario" width="822" border="0" align="center">
 	<tr>
	</tr>
 <tr><div id='errorloc3' class="error_valid" align="center"></div></tr>
	<tr>

	</tr>
	<tr>
	<td colspan="6">
	<input type="button" id="guardar" name="guardar" value="Guardar"  onclick="guardarD(2)"/>
	</td>
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