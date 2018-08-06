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
    $permitidos = array(1,2,3,4,5,6,7,13,17,18);
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

$nroFilas = 38;


$contArt = $objFactura->contarFacturasPreInv($id_numfac,$sercarveh,$fec,$fec2,$codpro,$nombre,$tipo,$estatus, $banco ,$usuario,$cond, $sig, $dia ,$edad ,$estado,$sexo,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori);
//$contArt = 0;
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

$listarFactura=$objFactura->listarFacturasPreInv($id_numfac,$sercarveh,$fec,$fec2,$offset,$codpro,$nombre,$tipo,$estatus, $banco ,$usuario,$cond, $sig, $dia ,$edad ,$estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori);
$listarFactura1=$objFactura->listarFacturasPreInv($id_numfac,$sercarveh,$fec,$fec2,-1,$codpro,$nombre,$tipo,$estatus, $banco ,$usuario,$cond, $sig, $dia ,$edad ,$estado,$sexo ,$diat,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$taller,$tt,$fecE,$fecE2,$tipoE,$tipoben,$fecfacori1,$fecfacori2,$numfacori);
$_SESSION['listarFactura']=$listarFactura1;

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
	  	   " = window.open('reportes/xlsListarFacturas.php?id_numfac=<?php echo$id_numfac;?>&sercarveh=<?php echo$sercarveh;?>&fec=<?php echo$fec;?>&fec2=<?php echo$fec2;?>&codpro=<?php echo$codpro;?>&nombre=<?php echo$nombre;?>&tipo=<?php echo$tipo;?>&estatus=<?php echo$estatus;?>&banco=<?php echo$banco;?>&usuario=<?php echo$usuario;?>&cond=<?php echo$cond;?>&sig=<?php echo$sig;?>&dia=<?php echo$dia;?>&edad=<?php echo$edad;?>&estado=<?php echo$estado;?>&sexo=<?php echo$sexo;?>&diat=<?php echo$diat;?>&codmar=<?php echo$codmar;?>&codmodveh=<?php echo$codmodveh;?>&codserveh=<?php echo$codserveh;?>&numlotveh=<?php echo$numlotveh;?>&numplaveh=<?php echo$numplaveh;?>&taller=<?php echo $taller; ?>&tt=<?php echo $tt;?>&fecE=<?php echo$fecE;?>&fecE2=<?php echo$fecE2; ?>&tipoE=<?php echo$tipoE;?>&tipoben=<?php echo$tipoben;?>&fecfacori1=<?php echo$fecfacori1;?>&fecfacori2=<?php echo$fecfacori2;?>&numfacori=<?php echo$numfacori;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");


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
 <fieldset class="form">
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
           <td  class="categoria">cod Beneficiario:</td>
              <td class="dato"  >
			<input name="codpro" type="text" id="codpro"  value="" />
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
			    <?php for($i=0;$i<count($listarEstados);$i+=2){  ?>
	               <option value="<?php echo $listarEstados[$i]; ?>"><?php echo $listarEstados[$i+1]?></option>
	           <?php } ?>
	           <option value="">TODAS</option>
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


          </td>
          </tr>
          <tr>

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
	        </td></tr>
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
    <table width="90%" align="center" class="detalles">
  			<tr>
  				<td colspan="22" align="right">Imprimir todos los resultados de la consulta
			  			<a class="vinculo" target="_blank" onClick="abrir('reportes/ciclopdffacturapreinv.php');" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a>
				<!--    	<a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>-->
			      </td>
             </tr>
             <tr>
              <td class="cabecera">N° de Factura</td>
              <td class="cabecera">Fecha</td>
              <td class="cabecera">Cod. Ben</td>
              <td class="cabecera">Beneficiario</td>
              <td class="cabecera">Condicion Pago</td>
              <td class="cabecera">Banco</td>
              <td class="cabecera">Estatus</td>
              <td class="cabecera">Usuario</td>
              <td class="cabecera">Estado</td>
              <td class="cabecera">Sexo</td>
              <td class="cabecera">Edad</td>
               <td class="cabecera">D.T</td>
              <td class="cabecera">D.R</td>
               <td class="cabecera"> Fec_Status </td>
               <td class="cabecera"> Tipo_Benef </td>

               <?php if ($_SESSION['tipoUsuario'] != 5 and $_SESSION['tipoUsuario'] != 6 and $_SESSION['tipoUsuario'] != 7 and $_SESSION['tipoUsuario']!= 11) { ?>
               <?php if ($taller or $tt) {?>
              <td class="cabecera">Taller - Falla</td>
              <?php } ?>
              <?php if ($tipoE) {?>
              <td class="cabecera">Tipo Entrega</td>
              <?php } ?>

              <td class="cabecera"> I </td>
 <? if ($_SESSION['tipoUsuario']<>'18'){?>
              <td class="cabecera"> V </td>
 <?php } ?>
              <?php } ?>
             </tr>
<?php
        for($i=0;$i<count($listarFactura);$i+=$nroFilas){
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
               <td align="center"><?php echo str_pad($listarFactura[$i],5,'0',STR_PAD_LEFT)  ?></td>
               <td><?php  echo $listarFactura[$i+4];?> </td>

               <td><?php echo $listarFactura[$i+8]?> </td>
               <td><?php echo $listarFactura[$i+9]?></td>
               <td align="center" ><?php if ($listarFactura[$i+6]=='COMPLETO') echo "100% CREDITO"; else echo $listarFactura[$i+6]?></td>
               <td align="center" ><?php echo $listarFactura[$i+16]?></td>
               <td align="center" ><?php echo $listarFactura[$i+17]?></td>
               <td align="center" ><?php echo $listarFactura[$i+11]?></td>
               <td align="center" ><?php echo $listarFactura[$i+18]?></td>
               <td align="center" ><?php echo $listarFactura[$i+19]?></td>
               <td align="center" ><?php echo $listarFactura[$i+20]?></td>
			   <td align="center" ><?php echo $listarFactura[$i+22]?></td>
			   <td align="center" ><?php echo $listarFactura[$i+23]?></td>

			   <td align="center" ><?php echo $listarFactura[$i+29]?></td>
			   <td align="center" ><?php echo $listarFactura[$i+30]?></td>

               <?php if ($_SESSION['tipoUsuario'] != 5 and $_SESSION['tipoUsuario'] != 6 and $_SESSION['tipoUsuario'] != 7 and $_SESSION['tipoUsuario']!= 11) { ?>
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
               <?
						$preinv1=$listarFactura[$i+37];
			  ?>


	          <td><div align="center">
	          <?
	           if (($listarFactura[$i+2]=="0") or ($listarFactura[$i+2]=="1") or ($listarFactura[$i+2]=="2") or ($listarFactura[$i+2]=="3"))  { ?>
               <a class="vinculo" href="" target="_blank" onClick="popup('reportes/pdffacturapreinv.php?idfactura=<?php echo $listarFactura[$i]?>&preinv=<?php echo $preinv1; ?>');return false;">
	              <img src="botones/printer_48.png" width="20" height="20">
	          </a>
	          <? } else { ?>

	          <a class="vinculo" href="" target="_blank" onClick="popup('reportes/pdffactura.php?idfactura=<?php echo $listarFactura[$i]?>&tip=<?php echo $tipo; ?>');return false;">
	              <img src="botones/printer_48.png" width="20" height="20">
	          </a>
	          <? }?>
	           </div></td>
	            <? if ($_SESSION['tipoUsuario']<>'18'){?>
	           <td><div align="center">
               <a class="vinculo" href="<?php if($listarFactura[$i+6]=='CREDITO' OR $listarFactura[$i+6]=='COMPLETO' ){?>det_factura_suvinca<?php } if($listarFactura[$i+6]=='CONTADO'){?>det_factura_suvincaC<?php } ?>.php?idfactura=<?php echo $listarFactura[$i]?>&tip=<?php echo $tipo; ?>&preinv=<? echo $preinv1; ?>">
	              <img src="botones/buscar.png" width="20" height="20">
	          </a></div></td>
 <?php } ?>
	          <?php } ?>
              </tr>
<?php     }
        }
?>
   <tr><td colspan=9> <?php echo 'Total: '.$contArt?></td></tr>
    </table>
 </fieldset>
  </legend>

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
