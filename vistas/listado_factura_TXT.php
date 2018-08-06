<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/factura.php');
require('../modelos/pago.php');
require('../modelos/zona.php');
require('../modelos/usuarios.php');
require('../modelos/acto.php');
require('../modelos/entrega.php');
require('../modelos/beneficiario.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(21);
	validaAcceso($permitidos,$dir);

  $id_numfac=$_POST['id_numfac'];
  $sercarveh=$_POST['sercarveh'];
  $fec=$_POST['fec'];
  $fec2=$_POST['fec2'];
  $codpro=$_POST['codpro'];
  $nombre=$_POST['nombre'];
  $pgActual=$_POST['pagina'];
  $tipo=$_POST['tipo'];
  $estatus=$_POST['estatus'];
  $banco= $_POST['banco'];
  $usuario=$_POST['usuario'];
  $cond=$_POST['cond'];
  $sig=$_POST['sig'];
  $dia=$_POST['dia'];
  $diat=$_POST['diat'];
  $edad=$_POST['edad'];
  $estado=$_POST['estado'];
 // echo "Estado: ".$estado;
  $sexo=$_POST['sexo'];
  $codmar=$_POST['codmar'];
  $desmarveh=$_POST['desmar'];
  $codmodveh=$_POST['codmodveh'];
  $desmod=$_POST['desmod'];
  $codserveh=$_POST['codserveh'];
  $desserveh=$_POST['desserveh'];
  $numlotveh=$_POST['numlotveh'];
  $numplaveh=$_POST['numplaveh'];
  $descdep=$_POST['descdep'];
  $indBusq=$_POST['indBusq'];
  $taller =$_POST['codtal'];
  $tt = $_POST['todo_taller'];
  $fecE=$_POST['fecE'];
  $fecE2=$_POST['fecE2'];
  $tipoE=$_POST['tipoe'];
  $tipoben=$_POST['tipoben'];
  $fecfacori1=$_POST['fecfacori1'];
  $fecfacori2=$_POST['fecfacori2'];
  $numfacori=$_POST['numfacori'];
  $preinv=$_POST['idInv'];
  $color=$_POST['col1veh'];
  $acto =$_POST['actveh'];
  $desacto = $_POST['desacto'];
  $ta = $_POST['todo_acto'];
  $tipoB = $_POST['tipoB'];
  $riflab= $_POST['riflab'];
  $deslab= $_POST['deslab'];
  $documento= $_POST['documento'];
 //   $indReg= $_POST['indReg'];
 //   echo 'aqui'.$indReg;

 //

  if ($indBusq=='2'){
  $id_numfac=NULL;
  $sercarveh=NULL;
  $fec=NULL;
  $fec2=NULL;
  $codpro =NULL;
  $nombre =NULL;
  $pgActual =NULL;
  $tipo=NULL;
  $estatus =NULL;
  $banco =NULL;
  $usuario =NULL;
  $cond =NULL;
  $sig =NULL;
  $dia =NULL;
  $edad =NULL;
  $estado =NULL;
  $indBusq=NULL;
  $sexo =NULL;
  $diat  =NULL;
  $codmar=null;
  $desmarveh=null;
  $codmodveh=null;
  $desmod=null;
  $codserveh= null;
  $desserveh= null;
  $numlotveh=null;
  $descdep=null;
  $numplaveh=null;
  $taller = null;
  $tt = null;
  $fecE=NULL;
  $fecE2=NULL;
  $tipoE=null;
  $tipoben=null;
  $fecfacori1=NULL;
  $fecfacori2=NULL;
  $numfacori=NULL;
  $preinv=NULL;
  $color=NULL;
  $acto = NULL;
  $desacto=NULL;
  $ta = NULL;
  $tipoB = NULL;
  $riflab=null;
  $deslab=null;
  $documento=null;
}

$objFactura = new factura();
$objPago = new pago();
$objZona= new zona();
$objUsuario= new usuario();
$objActo= new acto();
$objBeneficiario=new beneficiario();
$objEnt=new entrega();


//$objBeneficiario = new beneficiario();

$listarEstados = $objZona->listarEstados();

$listarBancos=$objPago->listarBancos(3);

$listarUsuario=$objUsuario->buscarUsuario();

$listarEntrega=$objEnt->buscarEntrega();
$listarEstatus=$objFactura->listarEstatus();

$listarBeneficiario=$objBeneficiario->listarTipo_benef();


$nroCampos = 5;

if (($taller or $tt) and ($tipoentrega))
	$nroFilas = 55;
elseif ($taller or $tt or $tipoentrega)
	$nroFilas = 55;
elseif ($acto or $ta)
	$nroFilas = 54;
else
	$nroFilas = 52;


$contArt = $objFactura->contarFacturas($id_numfac,$sercarveh,$fec,$fec2,$codpro,$nombre,$tipo,$estatus, $banco ,$usuario,$cond, $sig, $dia ,$edad ,$estado,$sexo,
$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori,$preinv,$color,$acto,$ta,$todoacto,$tipoB,$riflab,$deslab,$documento);

$cantPaginas = ceil($contArt/($nroFilas));
if(!$pgActual){
	$pgActual = 1;
}
elseif($pgActual > $cantPaginas){
     $pgActual = $cantPaginas;
}

if($cantPaginas <= 10){
	$pgIni = 1;
	$pgFin = $cantPaginas;
}
elseif($cantPaginas > 10 AND $pgActual< 5 ){
	$pgIni = 1;
	$pgFin = 10;
}
elseif($cantPaginas > ($pgActual+5) AND $pgActual >= 5 ){
	$pgIni = $pgActual - 4;
	$pgFin = $pgActual + 5;
}
else{
	$pgIni = $pgActual - 4;
	$pgFin = $cantPaginas;
}

$offset =  ($pgActual-1) * $nroFilas;


$listarFactura=$objFactura->listarFacturas($id_numfac,$sercarveh,$fec,$fec2,$offset,$codpro,$nombre,$tipo,$estatus,$banco,$usuario,$cond,$sig,$dia,$edad,
$estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori,
$preinv,$color,'1','',$acto,$ta,'',$tipoB,$riflab,$deslab,$documento);

if($_POST['indBusq']==3 ){
 echo
	'<SCRIPT> window.open("../vistas/bitacoraFactura.php?id='.$listarFactura[8].'&id_numfac='.$id_numfac.'", "ventana1" , "width=900,height=800,scrollbars=NO") </SCRIPT>';
	$ctrl=$objFactura->reversafactura($id_numfac,$msj);
	$listarFactura=$objFactura->listarFacturas($id_numfac,$sercarveh,$fec,$fec2,$offset,$codpro,$nombre,$tipo,$estatus,$banco,$usuario,$cond,$sig,$dia,$edad,
	$estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori,
	$preinv,$color,'1','',$acto,$ta);
		//f_alert($msj);
}

if($_POST['indBusq']==33 ){
 echo
	'<SCRIPT> window.open("../vistas/bitacoraFactura.php?id='.$listarFactura[8].'&id_numfac='.$id_numfac.'", "ventana1" , "width=900,height=800,scrollbars=NO") </SCRIPT>';
	$ctrl=$objFactura->reversafactura($id_numfac,$msj,'1');
	$listarFactura=$objFactura->listarFacturas($id_numfac,$sercarveh,$fec,$fec2,$offset,$codpro,$nombre,$tipo,$estatus,$banco,$usuario,$cond,$sig,$dia,$edad,
	$estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori,
	$preinv,$color,'1','',$acto,$ta);
		//f_alert($msj);
}

if($_POST['indBusq']==4){
 echo
	'<SCRIPT> window.open("../vistas/bitacoraFactura.php?id='.$listarFactura[8].'&id_numfac='.$id_numfac.'", "ventana1" , "width=900,height=800,scrollbars=NO") </SCRIPT>';
	$ctrl=$objFactura->reversafactura1($id_numfac,$msj);

	if ($ctrl){
		$estatus=null;
		$listarFactura=$objFactura->listarFacturas($id_numfac,$sercarveh,$fec,$fec2,'-1',$codpro,$nombre,$tipo,$estatus,$banco,$usuario,$cond,$sig,$dia,$edad,
	$estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori,
	$preinv,$color,'1','',$acto,$ta);
	}
		//f_alert($msj);
}


if($_POST['indBusq']==5){
 echo
	'<SCRIPT> window.open("../vistas/bitacoraFactura.php?id='.$listarFactura[8].'&id_numfac='.$id_numfac.'", "ventana1" , "width=900,height=800,scrollbars=NO") </SCRIPT>';
	    $ctrl=$objFactura->reversafactura3($id_numfac,$msj);
        $estatus=null;
		$listarFactura=$objFactura->listarFacturas($id_numfac,'','','','-1','','');



		//f_alert($msj);
}

?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>

function avanzaPg(){
	pg = parseInt(window.document.registro.pagina.value);
	window.document.registro.pagina.value = pg+1;
	window.document.registro.submit();
}

function enviaPg(pag){

	window.document.registro.pagina.value = pag;
	window.document.registro.submit();
}


function regresaPg(){
	pg = parseInt(window.document.registro.pagina.value);
	window.document.registro.pagina.value = pg-1;
	window.document.registro.submit();
}

function enviar(campo){
	window.document.registro.indBusq.value = campo;
	window.document.registro.submit();
}

function abrir(campo)
{
pagina=campo;
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=500,resizable=yes,left=50,top=50");
}

function popup(URL) {
  day = new Date();
  id = day.getTime();
  eval("page" + id + " = window.open(URL, 'URL', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=600,height=600');");
}
function exel(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id +
	  	   	  	   " = window.open('reportes/xlsListarFacturas.php?id_numfac=<?php echo$id_numfac;?>&sercarveh=<?php echo$sercarveh;?>&fec=<?php echo$fec;?>&fec2=<?php echo$fec2;?>&codpro=<?php echo$codpro;?>&nombre=<?php echo$nombre;?>&tipo=<?php echo$tipo;?>&estatus=<?php echo$estatus;?>&banco=<?php echo$banco;?>&usuario=<?php echo$usuario;?>&cond=<?php echo$cond;?>&sig=<?php echo$sig;?>&dia=<?php echo$dia;?>&edad=<?php echo$edad;?>&estado=<?php echo$estado;?>&sexo=<?php echo$sexo;?>&diat=<?php echo$diat;?>&codmar=<?php echo$codmar;?>&codmodveh=<?php echo$codmodveh;?>&codserveh=<?php echo$codserveh;?>&numlotveh=<?php echo$numlotveh;?>&numplaveh=<?php echo$numplaveh;?>&taller=<?php echo $taller; ?>&tt=<?php echo $tt;?>&fecE=<?php echo$fecE;?>&fecE2=<?php echo$fecE2; ?>&tipoE=<?php echo$tipoE;?>&tipoben=<?php echo$tipoben;?>&fecfacori1=<?php echo$fecfacori1;?>&fecfacori2=<?php echo$fecfacori2;?>&numfacori=<?php echo$numfacori;?>&tipoB=<?php echo $tipoB;?>&riflab=<?php echo$riflab;?>&deslab=<?php echo$deslab;?>&color=<?php echo$color;?>&acto=<?php echo$acto;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

}
function restaurar(id_numfac,dato,codProv){
	if (confirm("¿Deseas Limpiar la Factura Original esta proforma?")){
	        	window.document.registro.indBusq.value = dato;
	        	window.document.registro.id_numfac.value =id_numfac;
	        	window.document.registro.codProv.value =codProv;
                window.document.registro.submit();
	      }
	 }

function restaurarT(id_numfac,dato,codProv){
	if (confirm("¿Deseas Reversar al estatus anterior de esta proforma?")){
	        	window.document.registro.indBusq.value = dato;
	        	window.document.registro.id_numfac.value =id_numfac;
	        	window.document.registro.codProv.value =codProv;
                window.document.registro.submit();
	      }
	 }

function restaurar1(id_numfac,dato,codProv){
	if (confirm("¿Desea desmarcar este Vehiculo Entregado?")){
	        	window.document.registro.indBusq.value = dato;
	        	window.document.registro.id_numfac.value =id_numfac;
	        	window.document.registro.codProv.value =codProv;
                window.document.registro.submit();
	      }
	 }

function restaurar2(id_numfac,dato,codProv){
	if (confirm("¿Desea Limpiar la Factura Original de este Vehiculo Entregado?")){
	        	window.document.registro.indBusq.value = dato;
	        	window.document.registro.id_numfac.value =id_numfac;
	        	window.document.registro.codProv.value =codProv;
                window.document.registro.submit();
	      }
	 }


</script>
  </head>
  <body class="pagina">
   <TABLE class="completo3" align="center">
    <TR>
     <TD class="banner2" align="center"></TD>
    </TR>
    <TR>
     <TD >
      <DIV class="menu2">
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
 <fieldset class="form" style="width: 1100px;">
  <legend>Criterios de B&uacute;squeda
  </legend>
     <table  align="center" >
          <tr>
           <td  class="categoria">N° Factura:</td>
    <td class="dato"  >
			<input name="id_numfac" type="text" id="id_numfac"  value="<?echo $id_numfac?>" onkeypress="return acessoNumerico(event)"  />

           <td  class="categoria">serial C. :</td>
              <td class="dato"  >
             <input name="sercarveh" type="text" id="sercarveh" value="<?echo $sercarveh?>" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="18" />
          </td>
          <td valign="top" class="categoria" > Desde: </td>
               <td  class="dato" >
	               <input name="fec" type="text" id="fec"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fec?>" size="10" maxlength="10" readonly="" />
	               <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec',document.forms[0].fec.value)" />
               </td>
               <td class="categoria" > Hasta: </td>
               <td class="dato" >
                   <input name="fec2" type="text" id="fec2"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fec2?>" size="10" maxlength="10" readonly="" />
                   <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec2',document.forms[0].fec2.value)" />
               </td>
              <!--  <td valign="top" class="categoria" > Desde(E): </td>
               <td  class="dato" >
	               <input name="fecE" type="text" id="fecE"  onblur="javascript:this.value=this.value.toUpperCase()" value="" size="10" maxlength="10" readonly="" />
	               <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecE',document.forms[0].fecE.value)" />
               </td>
               <td class="categoria" > Hasta(E): </td>
               <td class="dato" >
                   <input name="fecE2" type="text" id="fecE2"  onblur="javascript:this.value=this.value.toUpperCase()" value="" size="10" maxlength="10" readonly="" />
                   <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecE2',document.forms[0].fecE2.value)" />
               </td>-->
          </tr>
           <tr>
           <td  class="categoria">Cod Beneficiario:</td>
              <td class="dato"  >
			<input name="codpro" type="text" id="codpro" value=""   />
		  </td>
           <td  class="categoria">Nombre :</td>
           <td  class="dato">
             <input name="nombre" type="text" id="nombre" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="18" />
          </td>
          <td  class="categoria">Sexo:</td>
	        <td class="dato">
	        <select name="sexo"  id="sexo">
                <option value="<?php if ($sexo) echo $sexo ?>"><?php if ($sexo) echo  $listarFactura[19] ?></option>
                <option value="F">Femenino</option>
                <option value="M">Masculino</option>
          </select>
	        </td>
          	<td  class="categoria">Tipo:</td>
	        <td >Activos
		        <input type="radio" name="tipo" id="tipo"  value="A" <?php if ($tipo!='E') echo "checked= 'true'"?>/>
		        Anulados
		        <input type="radio" name="tipo" id="tipo"  value="E" <?php if ($tipo=='E') echo "checked= 'true'"?>/>
	        </td>
          </tr>
          <tr>
           <td  class="categoria">Estado:</td>
           <td class="dato">
			 <SELECT id="estado" name="estado">
			 <option value="<?php if ($estado) echo $estado?>"><?php if ($estado) echo $listarFactura[18];?></option>
			 <option value="">TODOS</option>
			    <?php for($i=0;$i<count($listarEstados);$i+=2){  ?>
	               <option value="<?php echo $listarEstados[$i]; ?>"><?php echo $listarEstados[$i+1]?></option>
	           <?php } ?>

			 </SELECT>
		  </td>
		  <td  class="categoria">Tipo beneficiario:</td>
           <td class="dato">
			 <SELECT id="tipoben" name="tipoben">
			  <option value="<?php if ($tipoben) echo $tipoben?>"><?php if ($tipoben) echo $listarFactura[30];?></option>
			    <?php for($i=0;$i<count($listarBeneficiario);$i+=2){  ?>
	               <option value="<?php echo $listarBeneficiario[$i]; ?>"><?php echo $listarBeneficiario[$i+1]?></option>
	           <?php } ?>
                 <!--<option value="<?php /*if ($tipo_benef) echo $tipo_benef ?>"><?php if ($tipo_benef) echo $tipo_benef */?></option>
                 <option value="1">Discapacidad</option>
                 <option value="2">Victima de Estafa</option>
                 <option value="3">Medicos y Enfermeras</option>
                 <option value="4">Educadores</option>
                 <option value="5">Personal Militar</option>
                 <option value="6">Funcionarios publicos</option>
                 <option value="7">Otros</option> -->
          </select>
		  </td>
		  <td  class="categoria" colspan="4"> Natural/Extranjeros:
		    <input type="radio" name="tipoB" id="tipoB"  value="1" <?php if ($tipoB=='1') echo "checked= 'true'"?>/>
		    Juridico/Gubernamentales:
		    <input type="radio" name="tipoB" id="tipoB"  value="2" <?php if ($tipoB=='2') echo "checked= 'true'"?>/>
		    Todas:
		    <input type="radio" name="tipoB" id="tipoB"  value="" <?php if ($tipoB=='') echo "checked= 'true'"?>/>
		  </td>

         <!--   <td  class="categoria">Edad :</td>
           <td  class="dato">
             <input name="edad" type="text" id="edad" value="<?php echo $edad;?>" onkeypress="return acessoNumerico(event)" size="7" maxlength="2" />
          </td>
         	<td  class="categoria">Días R. :</td>
	        <td class="dato"  >
               <input name="dia" type="text" id="dia" value="<?php echo $dia;?>"   size="7" maxlength="5" />
	        </td>
	        <td  class="categoria">Signo:</td>
	        <td >Menor Igual
		        <input type="radio" name="sig" id="sig"  value="1" <?php if ($sig=='1' or $sig!='2') echo "checked= 'true'"?>/>
		         Igual
		        <input type="radio" name="sig" id="sig"  value="2" <?php if ($sig=='2') echo "checked= 'true'"?>/>
	        </td>-->
          </tr>
                    <tr>
           <td  class="categoria">Condición de Pago:</td>
           <td class="dato">
			 <select name="cond"  id="cond">
                <option value="<?php if ($cond) echo $cond ?>"><?php if ($cond) echo $cond ?></option>
                <option value="CREDITO">CREDITO</option>
                <option value="CONTADO">CONTADO</option>
                <option value="COMPLETO">100% CREDITO</option>
                <option value="CREDITOS">CREDITO Y 100% CREDITO</option>
                <option value="">TODAS</option>
          </select>
		  </td>

	        <td  class="categoria">Usuario
	        </td>
	        <td class="dato">
		        <SELECT id="usuario" name="usuario">
				<option value="<?php if ($usuario) echo $usuario?>"><?php if ($usuario) echo $listarFactura[11];?></option>
			    <?php for($i=0;$i<count($listarUsuario);$i+=15){  ?>
	               <option value="<?php echo $listarUsuario[$i]; ?>"><?php echo $listarUsuario[$i+3].' '.$listarUsuario[$i+1]?></option>
	           <?php } ?>
	           <option value="">TODAS</option>
			 </SELECT>
	        </td>
	      <!--  <td  class="categoria">Días T. :</td>
	        <td class="dato"  >
               <input name="diat" type="text" id="diat" value="<?php echo $diat?>"   size="7" maxlength="5" />
	        </td>-->
	        </td>
	        <td  class="categoria">Placa :</td>
	        <td class="dato"  >
               <input name="numplaveh" type="text" id="diat" value="<?php echo $numplaveh?>" size="7" maxlength="8" />
	        </td>
          </tr>
		   <tr>

       <td class="categoria">Modelo:</td>
           <td align="left">
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?echo $codmodveh?>" />
             <input name="desmod" type="text" id="modveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $desmod?>" size="15" readonly=""/>

             <input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." />
			</td>

 <td  class="categoria">Marca:</td>
           <td align="left"  class="dato"  >
			<input name="codmar" type="hidden" id="codmar"  value="<?echo $codmar?>" />
	        <input name="desmar" type="text" id="desmar" onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $desmarveh?>" size="15" readonly=""/>
	        <input name="marca"  type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
		  </td>

 <td  class="categoria">Serie:</td>
           <td >
             <input name="codserveh" type="hidden" id="codserveh" value="<?echo$codserveh_?>" />
             <input name="desserveh" type="text" id="serveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $desserveh;?>" readonly=""/>
	         <td align="left">
             <input name="serie" type="button" id="serie" onclick="catalogo('cat_serie.php');" value="..." />
           </td>
	        </tr>
 			   <tr>
           <td  class="categoria">Banco :</td>
           <td  class="dato" colspan="3">
             <SELECT id="banco" name="banco">
				      <option value="<?php if ($banco) echo $banco?>"><?php if ($banco) echo $listarFactura[16];?></option>
			        <?php for($i=0;$i<count($listarBancos);$i+=2){  ?>
	                   <option value="<?php echo $listarBancos[$i]; ?>"><?php echo $listarBancos[$i+1]?></option>
	                <?php } ?>
	                <option value="">TODAS</option>
			 </SELECT>
          </td>
          <td  class="categoria">Estatus:</td>
	        <td class="dato" colspan="3" >
               <SELECT id="estatus" name="estatus">
				 <option value="<?php if ($estatus) echo $estatus?>"><?php if ($estatus) echo $listarFactura[17];?></option>
			    <?php for($i=0;$i<count($listarEstatus);$i+=4){  ?>
	               <option value="<?php echo $listarEstatus[$i]; ?>"><?php echo $listarEstatus[$i+1]?></option>
	           <?php } ?>
			 </SELECT>
	        </td>
 	 </tr>
 	   <tr>
          <td  class="categoria">N° Lote:</td>
          <td align="left">
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
         </td>
          <td class="categoria">Taller:</td>
          <td class="dato" colspan="2">
             <input name="codtal" type="hidden" id="codtal" value="<?php if($ban==1)  echo $registro['codtal'];?>" />
             <input name="destaller" type="text" id="destaller" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $registro['destaller'];?>" readonly=""/>
             <input name="taller" type="button" id="taller" onclick="catalogo('cat_taller.php');" value="..." />
             </td><td align="left">Todos los talleres <input type="radio" name="todo_taller" id="todo_taller"  value="T" /></td></tr>
         </tr>
         <tr> <td  class="categoria">Tipo de Entrega:</td>
	        <td align="left">Acto
		     <input type="radio" name="tipoe" id="tipoe"  value="A"/>
		        Otro
		     <input type="radio" name="tipoe" id="tipoe"  value="O"/>
	        </td>
	      <td class="categoria">Acto:</td>
          <td class="dato" colspan="2">
             <input name="actveh" type="hidden" id="actveh" value="" />
             <input name="desacto" type="text" id="desacto" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php echo $desacto;?>" readonly=""/>
             <input name="acto" type="button" id="acto" onclick="catalogo('cat_acto.php');" value="..." />
             </td><td align="left">Todos los actos <input type="radio" name="todo_acto" id="todo_acto"  value="TA" /></td>

	      </tr>


	       <tr>  <td  class="categoria">Rif Laboral:</td>
    <td class="dato"  >
			<input name="riflab" type="text" id="riflab"  value="<?echo $riflab?>"   />

           <td  class="categoria">Descrip Lab.:</td>
              <td class="dato"  >
             <input name="deslab" type="text" id="deslab" value="<?echo $deslab?>" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="18" />
          </td>
 <td  class="categoria">Estatus Documentacion</td>
              <td class="dato"  >
               <SELECT id="documento" name="documento">
               <option value=""></option>
               <option value="1">Documentacion no entregada</option>
               <option value="2">Documentacion Entregada</option>
       </SELECT>
	        </td>

	      </tr>
	      <tr><td colspan="8" align="center" class="cabeceraI"><font>Filtros Especiales</font></td></tr>
	      <tr>
		  <td rowspan="2" class="categoria">Fecha estatus:</td>
		  <td align="left"><font size="1">Desde: (dd/mm/aaaa)</font></td>
		  <td align="left" colspan="2"><font size="1">Hasta: (dd/mm/aaaa)</font></td>
		  </tr>
		  <tr>
		  <td  class="dato" >
	      <input name="fecE" type="text" id="fecE"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fecE?>" size="10" maxlength="10" readonly="" />
	      <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecE',document.forms[0].fecE.value)" />
          </td>
     	  <td class="dato" colspan="2" >
          <input name="fecE2" type="text" id="fecE2"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $fecE2?>" size="10" maxlength="10" readonly="" />
          <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecE2',document.forms[0].fecE2.value)" />

          <td  class="categoria" size="1">Nº.Fac_Orig:</td>
          <td class="dato">
          <input name="numfacori" type="text" id="numfacori" value="<?php echo $numfacori;?>" onkeypress="return acessoNumerico(event)" size="7" maxlength="5" />
          </td>
          </td>
          </tr>
          <tr>
          <td rowspan="2" class="categoria">Fec.factura original:</td>
          <td align="left"><font size="1">Desde: (dd/mm/aaaa)</font></td>
		  <td align="left" colspan="2"><font size="1">Hasta: (dd/mm/aaaa)</font></td>
		  </tr>
		  <tr>
          <td  class="dato" >
	      <input name="fecfacori1" type="text" id="fecfacori1"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php echo $fecfacori1;?>" size="10" maxlength="10" readonly="" />
	      <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecfacori1',document.forms[0].fecfacori1.value)" />
          </td>
          <td class="dato" colspan="2" >
          <input name="fecfacori2" type="text" id="fecfacori2"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php echo $fecfacori2;?>" size="10" maxlength="10" readonly="" />
          <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecfacori2',document.forms[0].fecfacori2.value)" />
          </td>
          <td  class="categoria">Pre Inventario :</td>
               <td class="dato"  >
         <input name="preinv" type="text" id="preinv"  size="10" maxlength="10" value="<?php if ($ban==1)  echo $listarAsignacion[$i];?>" readonly=""/>
         <input type="button" onclick="catalogoAncho('<? echo "cat_preinventario2.php"?>');" value="..." />
          </td>
           </tr>
          <tr> <td  class="categoria">Edad :</td>
               <td class="dato"  >
          <input name="edad" type="text" id="edad" value="<?php echo $edad;?>" onkeypress="return acessoNumerico(event)" size="7" maxlength="2" />
          </td>
          <td colspan="2"></td>
		  <td  class="categoria">Signo:</td>
	       <td >Menor Igual
		   <input type="radio" name="sig" id="sig"  value="1" <?php if ($sig=='1' or $sig!='2') echo "checked= 'true'"?>/>
		    Igual
		   <input type="radio" name="sig" id="sig"  value="2" <?php if ($sig=='2') echo "checked= 'true'"?>/>
	        </td>
	        </tr>
	        <tr><td  class="categoria">Días R. :</td>
	        <td class="dato"  >
               <input name="dia" type="text" id="dia" value="<?php echo $dia;?>"   size="7" maxlength="5" />
	        </td>
	        <td  class="categoria">Días T. :</td>
	        <td class="dato"  >
               <input name="diat" type="text" id="diat" value="<?php echo $diat?>"   size="7" maxlength="5" />
	        </td>
	         </tr>
	      <tr>
	          <td class="categoria">Color:</td>
        <td class="dato">
         <input name="col1veh" type="hidden" id="col1veh"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $color;?>"  readonly=""/>
         <input name="des1veh" type="text" id="des1veh"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $listarFactura[45];?>"  readonly="" size="10" maxlength="10"/>
         <input name="color1" type="button" id="color1" onclick="catalogo('cat_color.php?colop=1&col1=<? echo $_SESSION['tipoUsuario']; ?>');" value="..." />
        </td>
	        </tr>
          <tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden"  name="indBusq">
		    <INPUT type="hidden"  name="indReg" >
		    <INPUT type="hidden"  name="idUsu" >
           </td>
          </tr>
  </table>
   </fieldset>
 <fieldset class="form">
  <legend>Listado de Factura &nbsp; <?php if ($tipo=='E') echo 'Anulados'; ?> &nbsp; <?php echo 'Total: '.$contArt?>
  </legend>
  <div style="overflow: auto; width: 1100px; height: 300px;">
    <table width="90%" align="center" class="detalles">
  			<tr>
  				<td colspan="23" align="left">
			  			<!--<a class="vinculo" target="_blank" onClick="abrir('reportes/listFacturas.php?id_numfac=<?php echo$id_numfac;?>&sercarveh=<?php echo$sercarveh;?>&fec=<?php echo$fec;?>&fec2=<?php echo$fec2;?>&codpro=<?php echo$codpro;?>&nombre=<?php echo$nombre;?>&tipo=<?php echo$tipo;?>&estatus=<?php echo$estatus;?>&banco=<?php echo$banco;?>&usuario=<?php echo$usuario;?>&cond=<?php echo$cond;?>&sig=<?php echo$sig;?>&dia=<?php echo$dia;?>&edad=<?php echo$edad;?>&estado=<?php echo$estado;?>&sexo=<?php echo$sexo;?>&diat=<?php echo$diat;?>&codmar=<?php echo$codmar;?>&codmodveh=<?php echo$codmodveh;?>&codserveh=<?php echo$codserveh;?>&numlotveh=<?php echo$numlotveh;?>&numplaveh=<?php echo$numplaveh;?>&taller=<?php echo$taller; ?>&tt=<?php echo$tt; ?>&fecE=<?php echo$fecE; ?>&fecE2=<?php echo$fecE2; ?>&tipoE=<?php echo$tipoE; ?>&tipoben=<?php echo$tipoben; ?>&fecfacori1=<?php echo$fecfacori1;?>&fecfacori2=<?php echo$fecfacori2;?>&numfacori=<?php echo$numfacori; ?>  ');" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a>-->
				    	<a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
			      </td>
             </tr>
            <? if ($acto){?>
            <tr>
  			<td class="cabecera" colspan="31" align="right"><? echo "Acto: ".$desacto;?></td>
            </tr>
            <? }?>
             <tr>
              <?php if ($_SESSION['tipoUsuario'] != 5 and $_SESSION['tipoUsuario'] != 6 and $_SESSION['tipoUsuario'] != 7 ) { ?>
              <? if ($_SESSION['usuario']=='tleal'){ ?>
              <td class="cabecera">Fact. Nuev.</td>
 			  <td class="cabecera">Dev. Est.</td>
              <? }?>
              <?php if ($taller or $tt) {?>
              <td class="cabecera">Taller - Falla</td>
              <?php } ?>
              <?php if ($tipoE) {?>
              <td class="cabecera">Tipo Entrega</td>
              <?php } ?>

               <? if ($_SESSION['tipoUsuario']<>'18'){?>
              <td class="cabecera"> I </td>
<?}?>
              <td class="cabecera"> P </td>
 <? if ($_SESSION['tipoUsuario']<>'18'){?>
              <td class="cabecera">F</td>
                  <?php } ?>
              <?php } ?>
              <?php if ($_SESSION['tipoUsuario'] != 5 and $_SESSION['tipoUsuario'] != 6 and $_SESSION['tipoUsuario'] != 7 ) { ?>
                 <td class="cabecera">Fecha</td>
              <?php } ?>
                            <?php if ($_SESSION['tipoUsuario'] == 1 or $_SESSION['tipoUsuario'] == 2  or $_SESSION['tipoUsuario'] == 4  ) { ?>
                 <td class="cabecera">R</td>
              <?php } ?>
                 <td class="cabecera"> Id_Asig. </td>
                 <?php if ($_SESSION['tipoUsuario'] != 5 and $_SESSION['tipoUsuario'] != 6 and $_SESSION['tipoUsuario'] != 7 ) { ?>
                 <td class="cabecera">Serial de Carroceria</td>
              <?php } ?>
              <td class="cabecera">Cod. Ben</td>
              <td class="cabecera">Beneficiario</td>
              <td class="cabecera">Tel&eacute;fono</td>
              <td class="cabecera">Condici&oacute;n Pago</td>
              <td class="cabecera">Banco</td>
              <td class="cabecera">Estatus</td>
              <td class="cabecera">Usuario</td>
              <td class="cabecera">Estado</td>
              <td class="cabecera">Sexo</td>
              <td class="cabecera">Edad</td>
              <td class="cabecera">Rif Lab</td>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
              <td class="cabecera">Serie</td>
              <td class="cabecera">Lote</td>
              <td class="cabecera">Nº Placa</td>
              <td class="cabecera">Color</td>
              <td class="cabecera"> Fec_Status </td>
              <td class="cabecera"> Tipo_Benef </td>
             </tr>
<?php
        $cont=0;
        for($i=0;$i<count($listarFactura);$i+=$nroFilas){ $cont++;
          if($listarFactura[$i]){
             if(!$indC){
                 $color ='datosimpar1';
                 $indC = true;
             }
             else{
                 $color ='datospar1';
                 $indC = false;
             }
?>

              <tr class="<?php echo $color ?>">
                         <?php if ($_SESSION['tipoUsuario'] != 5 and $_SESSION['tipoUsuario'] != 6 and $_SESSION['tipoUsuario'] != 7 ) { ?>
			  <? if ($_SESSION['usuario']=='tleal'){ ?>
			  <? if ($listarFactura[$i+17]=='VEHICULO ENTREGADO'){ ?>
			  	  <td align="center" width="2%"><div title="Facturar nuevamente vehiculo entregado por error en nombre y/o perdida de documentacion">
	     	 <img src="botones/navigate_48.png" onclick="restaurar2(<?=$listarFactura[$i]?>,5)" width="24" height="24"/>
	    	   </a></div></div></td>
	    	    <td align="center" width="2%"><div title="Reversar Estatus por marcar erroneamente como Vehiculo entregado">
	     	 <img src="botones/goma.png" onclick="restaurar1(<?=$listarFactura[$i]?>,4)" width="24" height="24"/>
	    	   </a></div></div></td>
	    	  <? } else echo "<td></td><td></td>"?>
              <? }?>
			   <?php if ($taller or $tt) {?>
               <td><?php echo $listarFactura[$i+44]." - ".$listarFactura[$i+45]; ?></td>
               <?php } ?>
               <?php if ($tipoE) {?>
               <td><?php $datosE=$objEnt->buscarEntrega('','','','','','',$listarFactura[$i+1]);
                         if ($datosE) $datosA=$objActo->buscarActoID($datosE[10]);

                         if ($tipoE=='A' and $datosA)
                         	echo "Acto: ".$datosA[2]." del ".$datosA[1];
                         elseif ($tipoE=='O')
                         	echo "Otro";
                ?></td>

               <?php } ?>
               <?  if (($taller or $tt) and ($tipoentrega))
						$preinv1=$listarFactura[$i+48];
				  elseif ($taller or $tt or $tipoentrega)
						$preinv1=$listarFactura[$i+48];
				  else
						$preinv1=$listarFactura[$i+46];
			  ?>
      <? if ($_SESSION['tipoUsuario']<>'18'){?>
             <!--  <td><div align="center">
               <a class="vinculo" href="reg_factura.php?idfactura=<?php echo $listarFactura[$i]?>&tip=<?php echo $tipo; ?>">
	              <img src="botones/modificar.png" width="20" height="20">
	          </a> </div></td>-->
     <?php } ?>
	         <!--   <td><div align="center">
               <a class="vinculo" href="<?php if($listarFactura[$i+6]=='CREDITO' OR $listarFactura[$i+6]=='COMPLETO'){?>det_factura_suvinca<?php } if($listarFactura[$i+6]=='CONTADO'){?>det_factura_suvincaC<?php } ?>.php?idfactura=<?php echo $listarFactura[$i]?>&tip=<?php echo $tipo; ?>&preinv=<? echo $preinv1; ?>">
	              <img src="botones/buscar.png" width="20" height="20">
	          </a></div></td>-->
 <? if ($_SESSION['tipoUsuario']<>'18'){?>
	          <!-- <td>
	          <div align="center">
               <a class="vinculo" href="" target="_blank" onClick="popup('reportes/pdffacturaOri.php?num=<?php echo $listarFactura[$i]?>&tip=<?php echo $tipo; ?>');return false;">
	              <img src="botones/cheque.png" width="20" height="20">-->
	          </a></div>
	         </td>
	         </td><?php } ?>
	          <?php } ?>
	          <?php if ($_SESSION['tipoUsuario'] != 5 and $_SESSION['tipoUsuario'] != 6 and $_SESSION['tipoUsuario'] != 7 ) { ?>
  <!--   <td align="center" width="2%"><div title="Restaurar Factura"></div>
	     	 <img src="botones/limpiar_red.png" onclick="restaurar(<?=$listarFactura[$i]?>,3)" width="24" height="24"/>
	    	   </a></div></td>-->
	    	   <?php     } ?>
	    	  <?php if ($_SESSION['tipoUsuario'] == 1 or $_SESSION['tipoUsuario'] == 2  or $_SESSION['tipoUsuario'] == 4  ) {?>
    <td align="center" width="2%"><div title="Restaurar Factura"></div>
	     	 <img src="botones/arrow_left_green_48.png" onclick="restaurarT(<?=$listarFactura[$i]?>,33)" width="24" height="24"/>
	    	   </a></div></td>
	    	   <?php     } ?>
<td>
        <div align="center">
	          <? if ($listarFactura[$i+2]>"1"){ ?>
               <a class="vinculo" href="" target="_blank" onClick="popup('reportes/pdffactura.php?idfactura=<?php echo $listarFactura[$i]?>&tip=<?php echo $tipo; ?>');return false;">
	              <img src="botones/printer_48.png" width="20" height="20">
	          </a>
	          <? } else {?>
	          <a class="vinculo" href="" target="_blank" onClick="popup('reportes/pdffacturapreinv.php?idfactura=<?php echo $listarFactura[$i]?>&preinv=<?php echo $preinv1; ?>');return false;">
	              <img src="botones/printer_48.png" width="20" height="20">
	          </a>
	          <? }?>
	           </div></td>
                <?php if ($_SESSION['tipoUsuario'] != 5 and $_SESSION['tipoUsuario'] != 6 and $_SESSION['tipoUsuario'] != 7 ) { ?>
	            <td><?php  if ($listarFactura[$i+2]<>"0"){// if ($listarFactura[$i+17]=='CERTIFICADO EMITIDO') {?>
	          <div align="center">
               <a class="vinculo" href="" target="_blank" onClick="popup('reportes/pdfPropVeh.php?idfactura=<?php echo $listarFactura[$i]?>&tip=<?php echo $tipo; ?>');return false;">
	              <img src="botones/tabs_48.png" width="20" height="20">
	          </a></div>
	          <? }?></td>
               <td align="center"><?php echo str_pad($listarFactura[$i],5,'0',STR_PAD_LEFT)  ?></td>
               <td><?php  echo $listarFactura[$i+4];?> </td>
               <td><?php echo $listarFactura[$i+1];?></td>
               <td><?php echo $listarFactura[$i+2];?></td>
               <td><?php echo $listarFactura[$i+8]?> </td>
               <td><?php echo $listarFactura[$i+9]?></td>
               <? if (($taller or $tt) and ($tipoentrega)){
               		$telefono = $listarFactura[$i+51];
               		if ($listarFactura[$i+52]<>'0')
               			$telefono = $telefono." - ".$listarFactura[$i+52];
               	 }
                 elseif ($taller or $tt or $tipoentrega){
               		$telefono = $listarFactura[$i+51];
               		if ($listarFactura[$i+52]<>'0')
               			$telefono = $telefono." - ".$listarFactura[$i+52];
               	 }
				 elseif ($acto or $ta)
				 {
               		$telefono = $listarFactura[$i+50];
               		if ($listarFactura[$i+51]<>'0')
               			$telefono = $telefono." - ".$listarFactura[$i+51];
               	 }
               	 else
				 {
               		$telefono = $listarFactura[$i+49];
               		if ($listarFactura[$i+50]<>'0')
               			$telefono = $telefono." - ".$listarFactura[$i+50];
               	 }
               	 ?>

               <td><?php echo $telefono;?></td>
               <td align="center" ><?php if ($listarFactura[$i+6]=='COMPLETO') $condicion='100% CREDITO'; else $condicion=$listarFactura[$i+6]; echo $condicion; ?></td>
               <td align="center" ><?php echo $listarFactura[$i+16]?></td>
               <td align="center" ><?php echo $listarFactura[$i+17]?></td>
               <td align="center" ><?php echo $listarFactura[$i+11]?></td>
               <td align="center" ><?php echo $listarFactura[$i+18]?></td>
               <td align="center" ><?php echo $listarFactura[$i+19]?></td>
               <td align="center" ><?php echo $listarFactura[$i+20]?></td>
			   <td align="center" ><?php echo $listarFactura[$i+44]?></td>
			   <td align="center" ><?php echo $listarFactura[$i+24]?></td>

			   <?php if ($listarFactura[$i+2]<>'0'){?>
			   <td align="center" ><?php echo $listarFactura[$i+25];?></td>
			  <?php } else {?>
			   <td align="center" ><?php echo $listarFactura[$i+46];?></td>
			  <?php } ?>

			   <td align="center" ><?php echo $listarFactura[$i+26]?></td>
			   <td align="center" ><?php echo $listarFactura[$i+27]?></td>
			   <td align="center" ><?php echo $listarFactura[$i+28]?></td>
			   <td align="center" ><?php echo $listarFactura[$i+47] ?></td>
			   <td align="center" ><?php echo $listarFactura[$i+29]?></td>
			   <td align="center" ><?php echo $listarFactura[$i+30]?></td>
			   <td align="center" ><?php echo $listarFactura[$i+32]?></td>
		       <td align="center" ><?php echo $listarFactura[$i+31]?></td>

<?php     }

?>


	          <?php     }

?>
	           <?php     }?>
 </tr>
   <tr><td colspan=9> <?php echo 'Total: '.$contArt?></td></tr>
    </table>
   </div>
 </fieldset>

<BR>
 <div align="center">
       <?php if($pgActual>1){?>
         <img src="imagenes/atras.png" width="20" height="15" class="vinculo" onclick="regresaPg()">
       <?php }
         for($j=$pgIni;$j<=$pgFin;$j++){
             if($pgActual == $j) $claseVinc = 'vinculoAzul';
             else $claseVinc = 'vinculo';
       ?>
          <a class="<?php echo $claseVinc ?>" onclick="enviaPg(<?php echo $j ?>)"><?php echo $j ?></a>
       <?php
         }
         if($pgActual<$pgFin){
       ?>
         <img src="imagenes/adelante.png" width="20" height="15"  class="vinculo" onclick="avanzaPg()">
       <?php } ?>
       <BR>
       <input type="hidden" name="orden" />
       <input type="hidden" name="codProv" />
       <input type="hidden" name="idInv" id="idInv"/>


       <input type="hidden" name="pagina" value="<?php echo $pgActual ?>"/>

       <br />
     </div>
     <div align="center" >
        <input type="button" onclick="window.close()" value="Cerrar Ventana"/>
     </div>
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