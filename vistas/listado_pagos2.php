<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/pago.php');


	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(1,2,3,4,5,6,7,8);
	validaAcceso($permitidos,$dir);


  $pago		= $_POST['pago'];
  $id_banco = $_POST['idBanco'];
  $fec1		= $_POST['fec1'];
  $fec2		= $_POST['fec2'];
  $nombre 	= $_POST['nombre'];
  $codStatus= $_POST['codStatus'];
  $codpro	= $_POST['codpro'];
  $pgActual = $_POST['pagina'];

$id_caso = $_GET['id_caso'];
//if($_GET['id_caso']!=1) $id_caso = $_POST['tipo']; // Para probar listado de todos los pagos



$objPago = new pago();


 $indBusq= $_POST['indBusq'];
  $id_pago= $_POST['id_pago'];

$nroFilas = 20;
$nroCampos = 13;

$tabBanco = $objPago->listarBancos();
$dimBanco = sizeof($tabBanco);
							   // $nro_pago,$id_banco,$desde,$hasta,$sercarveh,$codpro,$nombre,$id_caso,$status
$contPago = $objPago->contarPagos($pago,$id_banco,$fec1 ,$fec2 ,$sercarveh,$codpro,$nombre,$id_caso,$codStatus);

$cantPaginas = ceil($contPago/($nroFilas));
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
								//$pago,$id_banco,$fec1,$fec2,$sercarveh,$codpro,$nombre,$status,   $offset,$nroFilas,$id_caso
$listarPago=$objPago->listarPagos($pago,$id_banco,$fec1,$fec2,$sercarveh,$codpro,$nombre,$codStatus,$offset,$nroFilas,$id_caso);


if($_POST['id_pago']){

	$swExist =  false;
	$ultimo = count($_SESSION['id_pago']);

	for($i=0;$i<$ultimo;$i++)if($_POST['id_pago']==$_SESSION['id_pago'][$i])break;

	$swExist = $i < $ultimo;
	$i = ($swExist)?$ultimo:$i;
	$_SESSION['contiTem'] = $i+1;

	if(!$swExist){
		$_SESSION['id_pago'][$i] 	= $_POST['id_pago'];
	 	$_SESSION['nroPago'][$i]	= $_POST['nroPago'];
	 	$_SESSION['monto'][$i] 		= $_POST['monto'];
	 	$_SESSION['fecha'][$i] 		= $_POST['fecha'];
	 	$_SESSION['status'][$i]		= $_POST['status'];
	 	$_SESSION['nroCta'][$i] 	= $_POST['nroCta'];
	 	$_SESSION['id_banco'][$i] 	= $_POST['id_banco'];
	 	$_SESSION['desBanco'][$i] 	= $_POST['desBanco'];
	 	$_SESSION['codpro'][$i] 	= $_POST['codpro'];
	 	$_SESSION['nomcomp'][$i] 	= $_POST['nomcomp'];
	 	$_SESSION['fechaReg'][$i] 	= $_POST['fechaReg'];

	 	$_SESSION['montoTotal'] 	= $_SESSION['montoTotal'] + $_POST['monto'];
	}

	if($swExist){
		echo "<script>";
		echo 'if(confirm("Pago ha sido agregado previamente."))';
		echo " window.opener.document.registro.submit();";
	  	echo "</script>";
	}
	else{
	     echo "<SCRIPT>";
	     echo "window.opener.document.registro.submit();";
	     echo "</SCRIPT>";
	}
}
if($_POST['indReg']==2){
	 $_SESSION['id_pago'] 	= null;
	 $_SESSION['nroPago']	= null;
	 $_SESSION['monto'] 	= null;
	 $_SESSION['fecha'] 	= null;
	 $_SESSION['status']	= null;
	 $_SESSION['nroCta'] 	= null;
	 $_SESSION['id_banco'] 	= null;
	 $_SESSION['desBanco'] 	= null;
	 $_SESSION['codpro'] 	= null;
	 $_SESSION['nomcomp'] 	= null;
	 $_SESSION['fechaReg'] 	= null;
	 $_SESSION['montoTotal']= 0;
}

if($_POST['indBusq']==3){

	echo '<SCRIPT> window.open("../vistas/bitacoraFactura.php?idfactura='.$id_banco.' " , "ventana1" , "width=600,height=600,scrollbars=NO") </SCRIPT>';
	$ctrl=$objPago->AnularPago($id_pago,&$msj);
	$listarPago=$objPago->listarPagos($pago,$id_banco,$fec1,$fec2,$sercarveh,$codpro,$nombre,$codStatus,$offset,$nroFilas,$id_caso);
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

function enviar(dato){
	if(dato==2){
		 document.registro.pago.value 	= null;
		 document.registro.fec1.value 	= null;
		 document.registro.fec2.value 	= null;
		 document.registro.nombre.value = null;
		 document.registro.idBanco.value = null;
		 document.registro.cod_banco.value = null;
		 document.registro.codStatus.value = null;
		 document.registro.codpro.value = null;

	}
	document.registro.indReg.value = dato;
	window.document.registro.submit();
}

function enviarPago(d0,d1,d2,d3,d4,d5,d6,d7,d8,d9,d10){

//	alert(d0+" "+d1+" "+d2+" "+d3+" "+d4+" "+d5+" "+d6+" "+d7+" "+d8+" "+d9+" "+d10);

 document.registro.id_pago.value = d0;
 document.registro.nroPago.value = d1;
 document.registro.monto.value 	 = d2;
 document.registro.fecha.value 	 = d3;
 document.registro.status.value	 = d4;
 document.registro.nroCta.value  = d5;
 document.registro.id_banco.value= d6;
 document.registro.desBanco.value= d7;
 document.registro.codpro.value  = d8;
 document.registro.nomcomp.value = d9;
 document.registro.fechaReg.value= d10;
 document.registro.submit();
 window.document.registro.submit();
}

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

function fcodBanco(){
	document.registro.cod_banco.value = document.registro.idBanco.value;
}

function fcodStatus(){
	document.registro.status.value = document.registro.codStatus.value;
	window.document.registro.submit();
}

function f_tipo(sw){
	document.registro.tipo.value = sw;
	window.document.registro.submit();
}
//////////////////////////////////////////////////////////////////////////////////////////////////


/*function eliminar_2(dato){
	var tabla = document.getElementById('tabla2');
    var prue=dato;
    iRow = parseInt(dato);

    var cont = parseInt(document.getElementById('contiTem').value);
	cont = cont - 1;
    alert(dato+' '+iPag+' '+ind);
    tabla.deleteRow(iRow);
	document.registro.contiTem.value = cont;
	document.registro.indBusq.value = ind;
	document.registro.id_pago.value = iPag;
	window.document.registro.submit();
}*/
function eliminar(id_pago,dato){
	if (confirm("¿Desea eliminar éste pago?")){
	        //alert(dato+' '+id_pago);
	        	window.document.registro.indBusq.value = dato;
	        	window.document.registro.id_pago.value = id_pago;
                window.document.registro.submit();
	      }   }
//////////////////////////////////////////////////////////////////////////////////////////////////


</script>
  </head>
  <body class="pagina">
<?if($_GET['id_caso']==2){?>
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
<?}?>
    <TR>
     <TD class="cuerpo">
      <DIV class="nivel1">
       <DIV class="nivel2">
<!--  Contenido Principal         -->
    <form action="" method="post" name="registro">
 <fieldset class="form">
  <legend>Criterios de Busqueda
     <table  align="center" border="0">
          <tr>
        <td class="categoria" colspan="1">Banco:&nbsp;</td>
			 <td align="left" colspan="2">
			 <SELECT id="idBanco" name="idBanco" onchange="fcodBanco()" onkeydown="fcodBanco()" onkeyup="fcodBanco()">
				<OPTION value=""></OPTION>
			    <?for($k=0;$k<$dimBanco;$k+=2) { ?>
					<OPTION value="<?=$tabBanco[$k]?>"
					<? if($tabBanco[$k]==$id_banco) echo "selected='true'";?>><?echo $tabBanco[$k+1];?>
					</OPTION>
			    <? } ?>
			 </SELECT>
		     </td>

       	   <td class="categoria" >&nbsp;Desde:</td>
           <td  class="dato" >
               <input name="fec1" type="text" id="fec1"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?=$fec1?>" size="10" maxlength="10" readonly="" />
               <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec1',document.forms[0].fec1.value)" />
           </td>
           <td class="categoria" >&nbsp;Hasta:</td>
           <td class="dato" colspan="2">
               <input name="fec2" type="text" id="fec2"  onblur="javascript:this.value=this.value.toUpperCase()" value="<?=$fec2?>" size="10" maxlength="10" readonly=""/>
               <img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fec2',document.forms[0].fec2.value)"/>
           </td>
        </tr>

        <tr>
           <td  class="categoria">&nbsp;Beneficiario:</td>
           <td class="dato">
             <input name="nombre" type="text" id="nombre" value="<?=$nombre?>" onblur="javascript:this.value=this.value.toUpperCase()" size="40" maxlength="18" />
          </td>
          <td></td>
          <td class="categoria">N°&nbsp;Pago:</td>
           <td align="left" title="Número de cheque / transferencia">
			<input name="pago" type="text" id="pago" value="<?=$pago?>" onkeypress="return acessoNumerico(event)" size="10"/>
		  </td>

           <td  class="categoria">Status&nbsp;pago:</td>
			 <td align="left" colspan="1">
			 <SELECT id="codStatus" name="codStatus" >
			    <OPTION value="<?php if ($codStatus=='A') echo 'A'; else echo 'E'; ?>" ><?php if ($codStatus=='A') echo 'ACTIVOS'; else echo 'ANULADOS'; ?></OPTION>
				<OPTION value="A" >ACTIVOS</OPTION>
				<OPTION value="E" >ANULADOS</OPTION>
			 </SELECT>
			 </td>

          <td></td>
          </tr>

          <tr>
 <td class="categoria">CI/RIF:</td>
		     <td class="dato">
			<input name="codpro" type="text" id="codpro" value="<?=$codpro?>" onblur="javascript:this.value=this.value.toUpperCase()" size="15" maxlength="18"/>
		  </td>
		  </tr>
          <tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
		    <INPUT type="hidden" name="indReg" size="4">
		    <INPUT type="hidden" id="cod_banco" name="cod_banco" size="4">
           </td>
          </tr>
  </table>
  </legend>
  </fieldset>

 <fieldset class="form">
  <legend>Lista de Pagos
    <table width="90%" align="center" class="detalles" id="tabla2">
            <tr>
              <td class="cabecera" rowspan="2">ID</td>
              <td class="cabecera" colspan="5">Cheque/Transferencia</td>
              <td class="cabecera" colspan="2">Beneficiario</td>
              <td class="cabecera" rowspan="2">Fecha Reg.</td>
<?if($id_caso==2)echo '<td class="cabecera" colspan="2" rowspan="2"></td>'?>
            </tr>
            <tr>
              <td class="cabecera">N°</td>
              <td class="cabecera">Monto</td>
              <td class="cabecera">Fecha</td>
              <td class="cabecera">Status</td>
              <td class="cabecera" title="Banco del cheque/transferencia">Banco</td>
              <td class="cabecera">RIF</td>
              <td class="cabecera">Nombre</td>
            </tr>
<?

        for($i=0;$i<count($listarPago);$i+=$nroCampos){
        	$k = $i / $nroCampos + $offset;
          if($listarPago[$i]){
                 $color = (!$indC)?'datosimpar':'datospar';
                 $indC = !$indC;

                     if($listarPago[$i+4]=='E')$statusPago = "EFECTIVO";
                 elseif($listarPago[$i+4]=='A')$statusPago = "ANULADO";
                 elseif($listarPago[$i+4]=='V')$statusPago = "DEVUELTO";
                 elseif($listarPago[$i+4]=='D')$statusPago = "DEPOSITADO";
                 else $statusPago = null;
?>
              <tr class="<?=$color ?>">

       <td align="center" id="id_pago<?=$k?>" name="id_pago[<?=$k?>]"><?=$listarPago[$i]?></td>
               <td align="center" id="nroPago<?=$k?>" name="nroPago[<?=$k?>]">
               <?if($_GET['id_caso']!=2){?>
               <a class="vinculo"
               	onclick="enviarPago('<?=$listarPago[$i+0]?>','<?=$listarPago[$i+1]?>'
               					   ,'<?=$listarPago[$i+2]?>','<?=$listarPago[$i+3]?>'
               					   ,'<?=$listarPago[$i+4]?>','<?=$listarPago[$i+5]?>'
               					   ,'<?=$listarPago[$i+6]?>','<?=$listarPago[$i+7]?>'
               					   ,'<?=$listarPago[$i+10]?>','<?=$listarPago[$i+11]?>'
               					   ,'<?=$listarPago[$i+12]?>')">
               		<?=str_pad($listarPago[$i+1],8,'0',STR_PAD_LEFT)?></a>
               		<?}else { echo str_pad($listarPago[$i+1],8,'0',STR_PAD_LEFT); }?>
               </td>
               <td align="right">&nbsp;<?=formatomonto($listarPago[$i+2])?>&nbsp;</td>
               <td align="center"><?=$listarPago[$i+3]?></td>
               <td align="center"><?=$statusPago?></td>
               <td align="center" title="<?echo 'N°Cta: '.$listarPago[$i+5].'-'.$listarPago[$i+6]?>"><?=$listarPago[$i+7]?></td>
               <td align="center" ><?=$listarPago[$i+10]?></td>
               <td align="center" ><?=$listarPago[$i+11]?></td>
               <td align="center" ><?=$listarPago[$i+12]?></td>
<?if($id_caso==2){?>
               <td><div align="center">
               <a class="vinculo" href="reg_pago.php?idpago=<?=$listarPago[$i]?>">
	              <img src="botones/buscar.png" width="20" height="20">
	          </a></div></td>
	          <td><div align="center">
               <a class="vinculo" href="reportes/pdfRecibodePago.php?idpago=<?=$listarPago[$i]?>">
	              <img src="botones/printer_48.png" width="20" height="20">
	          </a></div></td>
                 <td align="center" width="2%"><div title="Eliminar Pago"></div>
	     	 <img src="botones/cancelado.png" onclick="eliminar(<?=$listarPago[$i]?>,3)" width="24" height="24"/>
	    	   </a></div></td>
             </tr>
	          <?}?>
              </tr>
<?  }
    }
?>
   <tr><td colspan=2 class="categoria"> <?='Total: '.$contPago?></td></tr>
    </table>
  </legend>
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
          <a class="<?=$claseVinc ?>" onclick="enviaPg(<?=$j ?>)"><?=$j ?></a>
       <?php
         }
         if($pgActual<$pgFin){
       ?>
         <img src="imagenes/adelante.png" width="20" height="15"  class="vinculo" onclick="avanzaPg()">
       <?php } ?>
       <BR>

       <input type="hidden" name="indBusq" id="indBusq" />
       <input type="hidden" name="id_pago" id="id_pago"/>

		 <input type="hidden" name="nroPago"/>
		 <input type="hidden" name="monto"/>
		 <input type="hidden" name="fecha"/>
		 <input type="hidden" name="status"/>
		 <input type="hidden" name="nroCta"/>
		 <input type="hidden" name="id_banco"/>
		 <input type="hidden" name="desBanco"/>
		 <input type="hidden" name="codpro2"/>
		 <input type="hidden" name="nomcomp"/>
		 <input type="hidden" name="fechaReg"/>
		 <input type="hidden" id="tipo1" name="tipo1"/>
		 <input type="hidden" name="pagina" value="<?=$pgActual ?>"/>
       <br />
     </div>
<?if($_GET['id_caso']==1){?>
     <div align="center" >
        <input type="button" onclick="window.close()" value="Cerrar Ventana"/>
     </div>
<?}?>
    </form>
<!--  FIN Contenido Principal         -->
       </DIV>
      </DIV>
     </TD>
    </TR>
<?if($_GET['id_caso']==2){?>
    <TR>
     <TD class="piedepagina">
      <?php include("piedepagina.php") ?>
     </TD>
    </TR>
   </TABLE>
<?}?>
  </body>
</html>