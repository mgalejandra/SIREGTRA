<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/certificado.php');
require('../modelos/pago.php');
require('../modelos/beneficiario.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,6,7,8,11,15,17,18,23);
	validaAcceso($permitidos,$dir);

$objPago = new pago();

$objBeneficiario = new beneficiario();

$listarBancos=$objPago->listarBancos(4);

$indReg = $_POST['indReg'];
$nummemo = $_POST['nummemo'];
$_SESSION['banco'] = $_POST['bancoid'];
$_SESSION['atencion'] = $_POST['atencion'];
$nota = $_POST['nota'];
$rif = $_POST['rif'];
$posicionElim = $_POST['pos'];
$listarBancos2=$objPago->listarBancos(4,$_SESSION['banco']);

if($indReg=='1'){
$busqueda=false;
                   $listarBeneficiario=$objBeneficiario->listarBeneficiario($rif,'','','','');

                   for($j=0;$j<count($_SESSION['detalleMemoE']);$j+=42){
                   	$posicion = strpos($_SESSION['detalleMemoE'][$j], $rif);
                   	if($posicion)
                   	{
                   		$busqueda=true;
                   		break;
                   	}
                   		if($rif==$_SESSION['detalleMemoE'][$j])
                   	{
                   		$busqueda=true;
                   		break;
                   	}
                   }

             //      if($_SESSION['banco']==$listarBeneficiario[40])
	                   if (!$busqueda){
	                   	for($i=0;$i<count($listarBeneficiario);$i++){
			              $_SESSION['detalleMemoE'][] = $listarBeneficiario[$i];
	                   	}
	                   }else  echo '<script>alert("Este Numero '.$rif.' ya esta ingresado")</script>';
		       //    else
		        //    echo '<script>alert("Este Numero '.$rif.' no pertenece a el Banco al cual esta emitiendo el memo o esta Errado")</script>';

}

if($indReg=='2'){

$indReg = NULL;
$nummemo = NULL;
$_SESSION['banco'] = NULL;
$_SESSION['atencion'] = NULL;
$nota = NULL;
$rif = NULL;
$_SESSION['detalleMemoE']=NULL;
$listarBancos2=null;
}

if($indReg=='3'){

$regrif=$objBeneficiario->registrarMemorif($nummemo,$_SESSION['banco'],$_SESSION['atencion'],$nota,$_SESSION['detalleMemoE']);

$_SESSION['detalleMemoE'] = NULL;
				 	if ($regrif){
					 echo '<script>alert("Memo Registrado")</script>';
					//echo "<SCRIPT>window.location.href='reportes/pdfMemorif.php?id=".$regrif."';</SCRIPT>";
					 echo '<SCRIPT> window.open("../vistas/reportes/pdfMemorif.php?id='.$regrif.' " , "ventana1" , "width=600,height=600,scrollbars=NO") </SCRIPT>';
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

	   for($i=0;$i<=count($_SESSION['detalleMemoE']);$i++) {
	   	$k=$i/42;

	   	if($k==$posicionElim) {

	   		//$_SESSION['sumaOC']=$_SESSION['sumaOC']-$_SESSION['detalleMemo'][$i];
	   		//echo 'aqui: '.$_SESSION['detallePago'][$i];
	   		$i+=42;
	   	}
	    $medAux[]  =  $_SESSION['detalleMemoE'][$i];

	   	}

	   //echo 'suma restada: '.$_SESSION['sumaOC'];
	   	$_SESSION['detalleMemoE']=null;
	   array_pop($medAux);
	   $_SESSION['detalleMemoE'] = $medAux;
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

		rif=document.registro.rif.value;
		banco=document.registro.banco.value;


		if(banco!='')
		{
			document.registro.bancoid.value = banco;
		}

		bancoId=document.registro.bancoid.value;



		if(rif=='' && dato==1 ) {
		 alert("Debe Ingresar un numero de rifificado");
		 document.registro.rif.focus();
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
  <legend>Datos del Memo Expediente
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
           <td  class="categoria">Rif / Ci :</td>
           <td align="left">
             <input name="rif" type="text" id="rif" value="" onblur="javascript:this.value=this.value.toUpperCase()" maxlength="10"/>
               <input type="button"  value="Agregar" onclick="enviar(1)">
               <input type="button"  value="Limpiar Todo" onclick="enviar(2)">
               <input type="button"  value="Guardar" onclick="enviar(3)">
           </td>
          </tr>

  </table>
   </fieldset>
   <fieldset class="form">
  <legend>Detalle del Memo Expediente
  </legend>
 <!-- <input  type="button" id="articulo" onClick="abrir('reportes/listrifificados.php?idsercarveh=<?php echo$sercarveh;?>&numcerveh=<?php echo$numcerveh;?>&codpro=<?php echo$codpro;?>&nomcomp=<?php echo$nomcomp;?>&numfac1veh=<?php echo$numfac1veh;?>&numlotveh=<?php echo$numlotveh;?>&codmar=<?php echo$codmar;?>&codmodveh=<?php echo$codmodveh;?>&codserveh=<?php echo$codserveh;?>&desserveh=<?php echo$desserveh;?>&desmodveh=<?php echo$desmodveh;?>&desmarveh=<?php echo$desmarveh;?>&tip=<?php echo $tipo;?>');" value="PDF" />-->
     <TABLE width="800" align="center" class="detalles">
         <tr>
              <td class="cabecera">N° rif</td>
              <td class="cabecera">Nombre </td>
              <td class="cabecera">Apellido</td>
              <td class="cabecera">Telefono 1</td>
              <td class="cabecera">Telefono 2</td>
               <td class="cabecera">Borrar</td>
             </tr>
       <?php  $indC = false;  $i2=0; for($i=0;$i<count($_SESSION['detalleMemoE']);$i+=42){
       	$i2++;
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
               <td align="center"><?php echo $_SESSION['detalleMemoE'][$i];?></td>
               <td align="center"><?php echo $_SESSION['detalleMemoE'][$i+1].' '.$_SESSION['detalleMemoE'][$i+2];?> </td>
               <td align="center"><?php echo $_SESSION['detalleMemoE'][$i+3].' '.$_SESSION['detalleMemoE'][$i+4];?></td>
               <td><?php echo $_SESSION['detalleMemoE'][$i+14]?></td>
               <td><?php echo $_SESSION['detalleMemoE'][$i+15]?></td>
	    <TD ><div align="center"><a class="vinculo" href="javascript: eliminar('5','<?php  echo $i/42;?>')"><img src="botones/delete.png" width="29" height="29" border="0"></a></div></TD>
	    </TR>
        <?php  }  ?>
	  </TABLE>
	  <TABLE>
	  <legend>&nbsp;Total Expedientes <?php echo ' Total: '.$i2?>
  </legend>
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