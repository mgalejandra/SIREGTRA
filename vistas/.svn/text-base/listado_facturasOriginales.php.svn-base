<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/reportes.php');
require('../modelos/pago.php');
require('../modelos/usuarios.php');
require('../modelos/vehiculos.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,14,19);
	validaAcceso($permitidos,$dir);

 $indBusq  = $_POST['indBusq'];
 $pgActual = $_POST['pagina'];

 $codpro	= $_POST['codpro'];
 $nombre	= $_POST['nombre'];
 $codmodveh = $_POST['codmodveh'];
 $marca = $_POST['codmar'];
 $estado=$_POST['estado'];
 $numfacori=$_POST['numfacori'];
 $fecD=$_POST['fecfacori1'];
 $fecH=$_POST['fecfacori2'];
 $numplaveh=$_POST['numplaveh'];
 $numlotveh=$_POST['numlotveh'];
 $usuario=$_POST['usuario'];
 $banco= $_POST['banco'];

 $objFactura = new reportes();
 $objPago = new pago();
 $objUsuario= new usuario();
 $objVehiculo = new vehiculos();

 $listarBancos=$objPago->listarBancos(3);
 $listarUsuario=$objUsuario->buscarUsuario();

if($indBusq==2){
	 $codpro	= null;
	 $nombre	= null;
	 $codmodveh = null;
	 $marca     = null;
	 $estado    = null;
	 $numfacori = null;
	 $fecD      = null;
	 $fecH      = null;
	 $numplaveh = null;
	 $numlotveh = null;
	 $usuario   = null;
	 $banco     = null;
}

$nroFilas = 45;
$nroCampos = 16;


$cantReg=$objFactura->resumenFacturasOriginales($codpro,$nombre,$marca,$fecD,$fecH,$codmodveh,$numlotveh,$banco,$numfacori,$usuario,-1);
$cantReg=count($cantReg)/$nroCampos;
$cantPaginas = ceil($cantReg/($nroFilas));

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

//echo "El offset es: ".$offset;

$listarFacturas=$objFactura->resumenFacturasOriginales($codpro,$nombre,$marca,$fecD,$fecH,$codmodveh,$numlotveh,$banco,$numfacori,$usuario,$offset);

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

function abrir(campo)
{
pagina=campo;
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=500,resizable=yes,left=50,top=50");
}

function enviar(dato){
	document.registro.pagina.value = 0;
	document.registro.indBusq.value = dato;
}







function exel(URL) {
	  day = new Date();
	  id = day.getTime();
	  eval("page" + id +
	  	   " = window.open('reportes/xlsListarFacturasOrig.php?codpro=<? echo $codpro;?>&nombre=<? echo $nombre;?>&codmodveh=<? echo $codmodveh;?>&marca=<? echo $marca;?>&estado=<? echo $estado;?>&numfacori=<? echo $numfacori;?>&fecfacori1=<? echo $fecD;?>&fecfacori2=<? echo $fecH;?>&numplaveh=<? echo $numplaveh;?>&numlotveh<? echo $numlotveh;?>&usuario=<? echo $usuario;?>&banco=<? echo $banco;?>&id='+URL,'','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");

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
    <form action="" method="post" name="registro">
 <fieldset class="form">
  <legend>Criterios de B&uacute;squeda</legend>
     <table  align="center" >
          <tr>
		   <td  class="categoria">CI/RIF:</td>
           <td align="left">
             <input name="codpro" type="text" id="codpro" value="<?php echo $codpro?>" onblur="javascript:this.value=this.value.toUpperCase()" size="10" maxlength="10" />&nbsp;&nbsp;
          </td>
           <td class="categoria">Nombre:</td>
           <td>
              <input name="nombre" type="text" id="nombre" value="<?php echo $nombre?>" onblur="javascript:this.value=this.value.toUpperCase()" size="20" width="60" maxlength="120"/>
           </td>
          <tr> <td  class="categoria">&nbsp;Banco Cr&eacute;dito:</td>
            <td  class="dato" colspan="3">
             <SELECT id="banco" name="banco">
				      <option value="<?php if ($banco) echo $banco?>"><?php if ($banco) echo $listarFacturas[16];?></option>
			        <?php for($i=0;$i<count($listarBancos);$i+=2){  ?>
	                   <option value="<?php echo $listarBancos[$i]; ?>"><?php echo $listarBancos[$i+1]?></option>
	                <?php } ?>
	                <option value="">TODAS</option>
			 </SELECT>
          </td>
          </tr>
		  <tr>

		   <td  class="categoria">Marca:</td>
           <td align="left"  class="dato"  >
			<input name="codmar" type="hidden" id="codmar"  value="<?echo $codmar?>" />
	        <input name="desmar" type="text" id="desmar" onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $desmarveh?>" size="15" readonly=""/>
	        <input name="marca"  type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
		  </td>

           <td class="categoria">Modelo:</td>
           <td align="left">
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?echo $codmodveh?>" />
             <input name="desmod" type="text" id="modveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?echo $desmod?>" size="15" readonly=""/>

             <input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." />
			</td>

		  </tr>
          <tr> <td  class="categoria">N° Lote:</td>
          <td align="left">
             <input name="numlotveh" type="text" id="numlotveh" value="<?php echo $numlotveh ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
         </td>
         <td  class="categoria" size="1">Nº.Fac_Orig:</td>
          <td class="dato">
          <input name="numfacori" type="text" id="numfacori" value="<?php echo $numfacori;?>" onkeypress="return acessoNumerico(event)" size="7" maxlength="5" />
          </td>
         </tr>
         <tr><td rowspan="2" class="categoria">Fec.factura original:</td>
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
          </td></tr>
          <tr><td  class="categoria">Usuario
	        </td>
	        <td class="dato">
		        <SELECT id="usuario" name="usuario">
				 <option value="<?php if ($usuario) echo $usuario?>"><?php if ($usuario) echo $listarFactura[11];?></option>
			    <?php for($i=0;$i<count($listarUsuario);$i+=15){  ?>
	               <option value="<?php echo $listarUsuario[$i]; ?>"><?php echo $listarUsuario[$i+3].' '.$listarUsuario[$i+1]?></option>
	           <?php } ?>
	           <option value="">TODAS</option>
			 </SELECT>
	        </td></tr>
            <td align="center" colspan="8">
            <input type="submit" value="Buscar" onclick="enviar('1')"/>
            <input type="submit" value="Limpiar" onclick="enviar('2')"/>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden" name="indReg" >
		    <INPUT type="hidden" name="idUsu" >
           </td>
          </tr>
  </table>
   </fieldset>

 <fieldset class="form">
  <legend>&nbsp;Facturas Originales <?php echo ' Total: '.$cantReg?></legend>
    <table width="90%" align="center" class="detalles">
      <tr>
      <td colspan="13" align="right"><!--<a class="vinculo" target="_blank" onClick="abrir('reportes/listConcesionario.php?sercarveh=<? echo $sercarveh; ?>&codpro=<? echo $codpro; ?>&nombre=<? echo $nombre; ?>&modelo=<? echo $codmodveh; ?>&estado=<? echo $estado; ?>');" />
  <IMG title="PDF" src="botones/pdf.png" height="15" ></a>-->
  <a class="vinculo" target="_blank" onClick="exel(2)">
				    		<IMG title="CALC" src="botones/calc.png" height="15">
				        </a>
			    	    <a class="vinculo" target="_blank" onClick="exel(1)">
			    			<IMG title="EXCEL" src="botones/excel.png" height="15">
			    		</a>
 </td></tr>
         <tr>

              <td class="cabecera">N°</td>
              <td class="cabecera">CI/RIF Benef.</td>
              <td class="cabecera">Beneficiario</td>
              <td class="cabecera">Tel&eacute;fonos</td>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
              <td class="cabecera">Lote</td>
              <td class="cabecera">Serial</td>
              <td class="cabecera">Nro. Fact</td>
              <td class="cabecera">Usuario Fact.</td>
              <td class="cabecera">Fecha Fact.</td>
              <td class="cabecera">Monto</td>
             </tr>
<?php
        for($i=0;$i<count($listarFacturas);$i+=$nroCampos){
          if($listarFacturas[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
             $nreg = $offset+$i/$nroCampos+1;

             $precio = $objVehiculo->precioVehiculo($listarFacturas[$i+12]);

          //   echo "El precio es: ".$precio;

?>

              <tr class="<?php echo $color ?>">
              <td><?echo $nreg?></td>
              <td><?php echo $listarFacturas[$i+5]; ?></td>
              <td><?php echo $listarFacturas[$i+6];?></td>
              <td><?php echo $listarFacturas[$i+7]." ".$listarFacturas[$i+8];?></td>
              <td><?php echo $listarFacturas[$i+10];?></td>
              <td><?php echo $listarFacturas[$i+11];?></td>
              <td><?php echo $listarFacturas[$i+9];?></td>
              <td><?php echo $listarFacturas[$i+12];?></td>
              <td><?php echo $listarFacturas[$i+3];?></td>
              <td><?php echo $listarFacturas[$i+13]." ".$listarFacturas[$i+14]." (".$listarFacturas[$i+1].")";?></td>
              <td><?php echo $listarFacturas[$i+4];?></td>
              <td><?php echo $precio ;?></td>
              </tr>
<?php     }
        }
?>
  <tr><td class="categoria"> </td></tr>
    </table>
 </fieldset>

<BR>
 <div align="center">
       <?php if($pgActual>1){?>
         <img src="imagenes/atras.png" width="20" height="15" class="vinculo" onclick="regresaPg()">
       <?php }
         for($j=$pgIni;$j<=$pgFin;$j++){
             $claseVinc = ($pgActual==$j)?'vinculoAzul':'vinculo';
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

       <br/>
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