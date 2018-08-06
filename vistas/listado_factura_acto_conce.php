<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/factura.php');
require('../modelos/pago.php');
require('../modelos/zona.php');
require('../modelos/acto.php');
require('../modelos/entrega.php');
require('../modelos/beneficiario.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(1,2,3,4,5,6,7,13,19,20);
	validaAcceso($permitidos,$dir);

  $id_numfac=$_POST['id_numfac'];
  $sercarveh=$_POST['sercarveh'];
  $fec=$_POST['fec'];
  $fec2=$_POST['fec2'];
  $codpro=$_POST['codpro'];
  $nombre=$_POST['nombre'];
  $pgActual=$_POST['pagina'];
  $tipo=$_POST['tipo'];
  if($_POST['estatus'])
  $estatus=$_POST['estatus'];
  else
  $estatus=14;
  $banco= $_POST['banco'];
  $cond=$_POST['cond'];
  $sig=$_POST['sig'];
  $estado=$_POST['estado'];
  $sexo=$_POST['sexo'];
  $codmar='C7';
  $codmodveh=$_POST['codmodveh'];
  $desmod=$_POST['desmod'];
  $codserveh=$_POST['codserveh'];
  $desserveh=$_POST['desserveh'];
  $numlotveh=$_POST['numlotveh'];
  $numplaveh=$_POST['numplaveh'];
  $descdep=$_POST['descdep'];
  $indBusq=$_POST['indBusq'];
  $fecE=$_POST['fecE'];
  $fecE2=$_POST['fecE2'];
  $tipoben=$_POST['tipoben'];
  $fecfacori1=$_POST['fecfacori1'];
  $fecfacori2=$_POST['fecfacori2'];
  $numfacori=$_POST['numfacori'];
  $color=$_POST['col1veh'];
  $obsv=$_POST['observacion'];
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
  $cond =NULL;
  $sig =NULL;
  $estado =NULL;
  $indBusq=NULL;
  $sexo =NULL;
  $codmar=null;
  $codmodveh=null;
  $desmod=null;
  $codserveh= null;
  $desserveh= null;
  $numlotveh=null;
  $descdep=null;
  $numplaveh=null;
  $fecE=NULL;
  $fecE2=NULL;
  $tipoben=null;
  $fecfacori1=NULL;
  $fecfacori2=NULL;
  $numfacori=NULL;
  $color=NULL;
  $obsv=null;
  }

$objFactura = new factura();
$objPago = new pago();
$objZona= new zona();
$objActo= new acto();
$objBeneficiario=new beneficiario();
$objEnt=new entrega();


//$objBeneficiario = new beneficiario();

$listarEstados = $objZona->listarEstados();

$listarBancos=$objPago->listarBancos(3);

$listarEntrega=$objEnt->buscarEntrega();
$listarEstatus=$objFactura->listarEstatus();

$listarBeneficiario=$objBeneficiario->listarTipo_benef();


$nroCampos = 5;

	$nroFilas = 16;


$contArt = $objFactura->contarFacturas_conce($id_numfac,$sercarveh,$fec,$fec2,$offset,$codpro,$nombre,$tipo,$estatus, $banco,$cond, $sig,$estado,$sexo,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$fecE,$fecE2,$tipoben,$fecfacori1,$fecfacori2,$numfacori,$color,'1','',$obsv);

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

$listarFactura=$objFactura->listarFacturas_conce($id_numfac,$sercarveh,$fec,$fec2,$offset,$codpro,$nombre,$tipo,$estatus, $banco,$cond, $sig,$estado,$sexo,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$fecE,$fecE2,$tipoben,$fecfacori1,$fecfacori2,$numfacori,$color,'1','',$obsv);

if($_POST['indBusq']==3 ){
 echo
	'<SCRIPT> window.open("../vistas/bitacoraFactura.php?id='.$listarFactura[8].'&id_numfac='.$id_numfac.'", "ventana1" , "width=900,height=800,scrollbars=NO") </SCRIPT>';
	$ctrl=$objFactura->reversafactura($id_numfac,&$msj);
	$listarFactura=$objFactura->listarFacturas_conce($id_numfac,$sercarveh,$fec,$fec2,$offset,$codpro,$nombre,$tipo,$estatus, $banco,$cond, $sig,$estado,$sexo,$codmar,$codmodveh,$codserveh,$numlotveh,$numplaveh,$fecE,$fecE2,$tipoben,$fecfacori1,$fecfacori2,$numfacori,$color,'1','',$obsv);
		//f_alert($msj);
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
	  	   " = window.open('reportes/xlsListarFacturasactConce.php?id_numfac=<?php echo$id_numfac;?>&sercarveh=<?php echo$sercarveh;?>&fec=<?php echo$fec;?>&fec2=<?php echo$fec2;?>&codpro=<?php echo$codpro;?>&nombre=<?php echo$nombre;?>&tipo=<?php echo$tipo;?>&estatus=<?php echo$estatus;?>&banco=<?php echo$banco;?>&cond=<?php echo$cond;?>&sig=<?php echo$sig;?>&estado=<?php echo$estado;?>&sexo=<?php echo$sexo;?>&codmar=<?php echo$codmar;?>&codmodveh=<?php echo$codmodveh;?>&numlotveh=<?php echo$numlotveh;?>&numplaveh=<?php echo$numplaveh;?>&fecE=<?php echo$fecE;?>&fecE2=<?php echo$fecE2; ?>&tipoben=<?php echo$tipoben;?>&fecfacori1=<?php echo$fecfacori1;?>&fecfacori2=<?php echo$fecfacori2;?>&numfacori=<?php echo$numfacori;?>&observ=<?php echo$obsv;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

}
function restaurar(id_numfac,dato,codProv){
	if (confirm("¿Deseas Limpiar la Factura Original esta proforma?")){
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
          </tr>
           <tr>
           <td  class="categoria">cod Beneficiario:</td>
              <td class="dato"  >
			<input name="codpro" type="text" id="codpro" value="" onblur="javascript:this.value=this.value.toUpperCase()"/>
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
          </select>
		  </td>
	        </td>
	        <td  class="categoria">Placa :</td>
	        <td class="dato"  >
               <input name="numplaveh" type="text" id="diat" value="<?php echo $numplaveh?>" size="7" maxlength="8" />
	        </td>
          </tr>
		   <tr>

		    <td class="categoria">Modelo:</td>
           <td align="left">
             <select name="codmodveh"  id="codmodveh">
                <option value="<?php /*if ($sexo) echo $sexo*/ ?>"><?php /*if ($sexo) echo  $listarFactura[19] */?></option>
                <option value="QQ3">QQ3</option>
                <option value="X1">X1</option>
                <option value="TG4">Tiger 4x2</option>
                <option value="TIG">Tiggo</option>
                <option value="T44">Tiger 4x4</option>
          </select>
			</td>
<td class="categoria">Lote:</td>
          <td align="left">
             <select name="numlotveh"  id="numlotveh">
                <option value="">SELECCIONE</option>
                <option value="14">CHERY 1</option>
                <option value="15">CHERY 2</option>
                <option value="16">CHERY 3</option>
                <!--<option value="15">CHERY 2</option>-->
          </select>
			</td>
	        </tr>
 			   <tr>
           <td  class="categoria">Banco :</td>
           <td  class="dato" colspan="3">
             <SELECT id="banco" name="banco">
				      <option value="<?php if ($banco) echo $banco?>"><?php if ($banco) echo $listarFactura[6];?></option>
			        <?php for($i=0;$i<count($listarBancos);$i+=2){  ?>
	                   <option value="<?php echo $listarBancos[$i]; ?>"><?php echo $listarBancos[$i+1]?></option>
	                <?php } ?>
	                <option value="">TODAS</option>
			 </SELECT>
          </td>
          <td  class="categoria">Observaci&oacute;n:</td>
              <td class="dato"  >
             <input name="observacion" type="text" id="observacion" value="<?echo $obsv?>" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="100" />
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
          <tr>
          <td  class="categoria">Signo:</td>
	       <td >Menor Igual
		   <input type="radio" name="sig" id="sig"  value="1" <?php if ($sig=='1' or $sig!='2') echo "checked= 'true'"?>/>
		    Igual
		   <input type="radio" name="sig" id="sig"  value="2" <?php if ($sig=='2') echo "checked= 'true'"?>/>
	        </td>
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
  <div style="overflow: auto; width: 1145px; height: 300px;">
    <table width="90%" align="center" class="detalles">
  			<tr>
  				<td colspan="22" align="left">
				    	<a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
			      </td>
             </tr>
             <tr>
              <td class="cabecera">Etiqueta</td>
              <td class="cabecera">Nombre</td>
              <td class="cabecera">Rif</td>
              <td class="cabecera">Modelo</td>
              <td class="cabecera">Color</td>
              <td class="cabecera">Placa</td>
              <td class="cabecera">Serial</td>
              <td class="cabecera">Banco</td>
              <td class="cabecera">Tlf1</td>
              <td class="cabecera">Tlf2</td>
              <td class="cabecera">Estatus</td>
              <td class="cabecera">Lote</td>
              <td class="cabecera">Tipo de Beneficiario</td>
              <td class="cabecera">Fecha Estatus</td>
              <td class="cabecera">Hora Estatus</td>
              <td class="cabecera">Observaci&oacute;n</td>
              <td class="cabecera">Ubicaci&oacute;n</td>
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
               <td align="center"><?php echo $listarFactura[$i+14]; ?></td>
               <td align="center"><?php echo $listarFactura[$i]; ?></td>
               <td><?php  echo $listarFactura[$i+1];?> </td>
               <td><?php echo $listarFactura[$i+2];?></td>
               <td><?php echo $listarFactura[$i+3];?></td>
               <td><?php echo $listarFactura[$i+4]?> </td>
               <td><?php echo $listarFactura[$i+5]?></td>
               <td align="center" ><?php echo $listarFactura[$i+6]; ?></td>
               <td align="center" ><?php echo $listarFactura[$i+7]?></td>
               <td align="center" ><?php echo $listarFactura[$i+8]?></td>
               <td align="center" ><?php echo $listarFactura[$i+9]?></td>
               <td align="center" ><?php echo $listarFactura[$i+10]?></td>
               <td align="center" ><?php echo $listarFactura[$i+11]?></td>
               <td align="center" ><?php echo $listarFactura[$i+12]?></td>
			   <td align="center" ><?php echo $listarFactura[$i+13]?></td>
			   <td align="center" ><?php if (strlen($listarFactura[$i+15])>=50) echo substr($listarFactura[$i+15],0,50).'...';
			                             else echo $listarFactura[$i+15]; ?></td>
			   <td align="center" ><?php
                      if ((($listarFactura[$i+2]=='QQ3') OR ($listarFactura[$i+2]=='X1')  OR ($listarFactura[$i+2]=='TIGGO')) AND ($listarFactura[$i+10]=='14'))
		                      	$ubicacion= "Base Sucre";

 					  if ((($listarFactura[$i+2]=='QQ3') OR ($listarFactura[$i+2]=='X1')  OR ($listarFactura[$i+2]=='TIGGO')) AND ($listarFactura[$i+10]=='15'))
		                      	$ubicacion= "Base Libertador";

		             if (($listarFactura[$i+2]=='GRAND TIGER 4X2') OR ($listarFactura[$i+2]=='GRAND TIGER 4X4'))
		             	    	$ubicacion= "Base Sucre";

			         echo $ubicacion; ?></td>
<?php   } }  ?>
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
<!--  FIN Contenido Principal-->
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