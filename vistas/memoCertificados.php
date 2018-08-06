<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/certificado.php');
require('../modelos/pago.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,6,7,8,11,15,17,18,23);
	validaAcceso($permitidos,$dir);

$objPago = new pago();

$objCertificado = new certificado();

$listarBancos=$objPago->listarBancos(4);

$indReg = $_POST['indReg'];
$nummemo = $_POST['nummemo'];
$_SESSION['banco'] = $_POST['bancoid'];
$_SESSION['atencion'] = $_POST['atencion'];
$nota = $_POST['nota'];
$cert = $_POST['cert'];
$posicionElim = $_POST['pos'];
$listarBancos2=$objPago->listarBancos(4,$_SESSION['banco']);

if($indReg=='1'){
$busqueda=false;
                   $listarcertificado=$objCertificado->listarCertificadosMemo('',$cert,'','','','','','','','',-1,'A','','',$_SESSION['numeDepa']);

                   for($j=0;$j<count($_SESSION['detalleMemo']);$j+=19){
                   	if($cert==$_SESSION['detalleMemo'][$j])
                   	{
                   		$busqueda=true;
                   		break;
                   	}
                   }

                   if($_SESSION['banco']==$listarcertificado[18])
	                   if (!$busqueda){
	                   	for($i=0;$i<count($listarcertificado);$i++){
			              $_SESSION['detalleMemo'][] = $listarcertificado[$i];
	                   	}
	                   }else  echo '<script>alert("Este Numero '.$cert.' ya esta ingresado")</script>';
		           else
		            echo '<script>alert("Este Numero '.$cert.' de Certificado no pertenece a el Banco al cual esta emitiendo el memo o esta Errado")</script>';

}

if($indReg=='2'){

$indReg = NULL;
$nummemo = NULL;
$_SESSION['banco'] = NULL;
$_SESSION['atencion'] = NULL;
$nota = NULL;
$cert = NULL;
$_SESSION['detalleMemo']=NULL;
$listarBancos2=null;
}

if($indReg=='3'){

$regCert=$objCertificado->registrarMemoCert($nummemo,$_SESSION['banco'],$_SESSION['atencion'],$nota,$_SESSION['detalleMemo']);
$_SESSION['detalleMemo'] = NULL;

				 	if ($regCert){
					 echo '<script>alert("Memo Registrado")</script>';
					 echo "<SCRIPT>window.location.href='reportes/pdfMemoCert.php?id=".$regCert."';</SCRIPT>";
			         echo '<script>window.close();</script>';
					}else
					{
					 echo '<script>alert("Numero de Memo Repetido")</script>';
					}

}


if ($indReg=='5'){
	//echo '<script>alert("hola")</script>';
	   $medAux  =  NULL;
	   //para el listado

	   for($i=0;$i<=count($_SESSION['detalleMemo']);$i++) {
	   	$k=$i/19;

	   	if($k==$posicionElim) {

	   		//$_SESSION['sumaOC']=$_SESSION['sumaOC']-$_SESSION['detalleMemo'][$i];
	   		//echo 'aqui: '.$_SESSION['detallePago'][$i];
	   		$i+=19;
	   	}
	    $medAux[]  =  $_SESSION['detalleMemo'][$i];

	   	}

	   //echo 'suma restada: '.$_SESSION['sumaOC'];
	   	$_SESSION['detalleMemo']=null;
	   array_pop($medAux);
	   $_SESSION['detalleMemo'] = $medAux;
}



?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
   <script>

function eliminar(dato,pos){

 document.registro.indReg.value = dato;
 document.registro.pos.value = pos;
 document.registro.submit();

}

function enviar(dato){

		cert=document.registro.cert.value;
		banco=document.registro.banco.value;


		if(banco!='')
		{
			document.registro.bancoid.value = banco;
		}

		bancoId=document.registro.bancoid.value;



		if(cert=='' && dato==1 ) {
		 alert("Debe Ingresar un numero de certificado");
		 document.registro.cert.focus();
		}else  if(bancoId=='' && dato==1 ) {
		 alert("Debe seleccionar un banco");
		 document.registro.banco.focus();
		}else
		{
		 document.registro.indReg.value = dato;
		 document.registro.submit();
		}

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

 <input type="hidden" name="pos" >
 <input type="hidden" name="indReg" id="indReg">
 <input type="hidden" name="bancoid" id="bancoid" value="<?php echo $_SESSION['banco']; ?>">
 <fieldset class="form">
  <legend>Datos del Memo
  </legend>
     <table  align="center" >
          <!--  <tr>
           <td  class="categoria">N° de Memo:</td>
           <td align="left" colspan="2">
			<input name="nummemo" type="text" id="nummemo"  value="<?php echo $nummemo;?>"  />
		   </td>
          </tr>-->
          <tr>
           <td  class="categoria">Banco:</td>
           <td align="left" colspan="2">
             <SELECT id="banco" name="banco"  <?php if ($_SESSION['banco']) echo "disabled";?> >
				      <option value="<?php if ($_SESSION['banco']) echo $banco?>"><?php if ($_SESSION['banco']) echo $listarBancos2[1];?></option>
			        <?php for($i=0;$i<count($listarBancos);$i+=3){  ?>
	                   <option value="<?php echo $listarBancos[$i]; ?>"><?php echo $listarBancos[$i+1]?></option>
	                <?php } ?>
			 </SELECT>
          </td>
		   </tr>
		   <tr>
           <td  class="categoria">Atención:</td>
           <td align="left">
             <input name="atencion" type="text" id="atencion" value="<?php  echo $listarBancos2[2];?>" />
           </td>
          </tr>
          <tr>
           <td  class="categoria">Nota:</td>
           <td align="left">
            <textarea name="nota" cols="100" rows="3" id="nota" onblur="javascript:this.value=this.value.toUpperCase()" ><?php echo $_POST['nota'];?></textarea>
             </td>
          </tr>
		   <tr>
           <td  class="categoria">Nro. Certificado:</td>
           <td align="left">
             <input name="cert" type="text" id="cert" value="B" onblur="javascript:this.value=this.value.toUpperCase()" maxlength="8"/>
               <input type="button"  value="Agregar" onclick="enviar(1)">
               <input type="button"  value="Limpiar Todo" onclick="enviar(2)">
               <input type="button"  value="Guardar" onclick="enviar(3)">
           </td>
          </tr>

  </table>
   </fieldset>

 <fieldset class="form">
  <legend>Detalle del Memo
  </legend>
 <!-- <input  type="button" id="articulo" onClick="abrir('reportes/listCertificados.php?idsercarveh=<?php echo$sercarveh;?>&numcerveh=<?php echo$numcerveh;?>&codpro=<?php echo$codpro;?>&nomcomp=<?php echo$nomcomp;?>&numfac1veh=<?php echo$numfac1veh;?>&numlotveh=<?php echo$numlotveh;?>&codmar=<?php echo$codmar;?>&codmodveh=<?php echo$codmodveh;?>&codserveh=<?php echo$codserveh;?>&desserveh=<?php echo$desserveh;?>&desmodveh=<?php echo$desmodveh;?>&desmarveh=<?php echo$desmarveh;?>&tip=<?php echo $tipo;?>');" value="PDF" />-->
     <TABLE width="800" align="center" class="detalles">
         <tr>
              <td class="cabecera">N° Certificado</td>
              <td class="cabecera">Serial Carrocería Vehiculo</td>
              <td class="cabecera">Cód. Beneficiario</td>
              <td class="cabecera">Beneficiario</td>
              <td class="cabecera">N° de Factura</td>
              <td class="cabecera">Fecha de Factura</td>
              <td class="cabecera">Fecha Registro</td>
              <td class="cabecera">Reserva de Dominio </td>
               <td class="cabecera">Borrar</td>
             </tr>
       <?php  $indC = false; for($i=0;$i<count($_SESSION['detalleMemo']);$i+=19){
         if(!$indC){
                   $color ='datospar';
                   $indC = true;
               }
               else{
                   $color ='datosimpar';
                   $indC = false;
               }
         ?>
        <TR class="<?php echo $color ?>">
               <td align="center"><?php echo $_SESSION['detalleMemo'][$i];?></td>
               <td><?php echo $_SESSION['detalleMemo'][$i+2];?> </td>
               <td><?php echo $_SESSION['detalleMemo'][$i+3];?></td>
               <td><?php echo $_SESSION['detalleMemo'][$i+4];?></td>
               <td align="center"><?php echo $_SESSION['detalleMemo'][$i+6];?> </td>
               <td align="center"><?php echo $_SESSION['detalleMemo'][$i+7];?> </td>
               <td align="center"><?php echo $_SESSION['detalleMemo'][$i+14];?></td>
               <td><?php echo $_SESSION['detalleMemo'][$i+11]?></td>
	    <TD ><div align="center"><a class="vinculo" href="javascript: eliminar('5','<?php  echo $i/19;?>')"><img src="botones/delete.png" width="29" height="29" border="0"></a></div></TD>
	    </TR>
        <?php  }   ?>

	  </TABLE>
    </TD>
  </TR>
</tr>
</table>
 </fieldset>
<BR>
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