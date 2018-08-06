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
	$permitidos = array(8,9,10);
	validaAcceso($permitidos,$dir);

$objPago = new pago();

$objBeneficiario = new beneficiario();

$listarBancos=$objPago->listarBancos(4);

$indReg = $_POST['indReg'];
$nummemo = $_POST['nummemo'];
$_SESSION['banco'] = $_POST['bancoid'];
$_SESSION['estatus'] = $_POST['estatusid'];
$_SESSION['atencion'] = $_POST['atencion'];
$nota = $_POST['nota'];
$rif = $_POST['rif'];
$monto = $_POST['monto'];
$posicionElim = $_POST['pos'];
$listarBancos2=$objPago->listarBancos(4,$_SESSION['banco']);
//echo 'estatus:'.$_SESSION['estatus'];
if($indReg=='1'){
$busqueda=false;
                   $listarBeneficiario=$objBeneficiario->listarBeneficiario($rif,'','','','');
                  // $buscarsiyaesta=$objBeneficiario->listarEstatusCredito('','',$rif,'','',-1);
                   $buscarsiyaesta=$objBeneficiario->listarEstatusCredito('','',$rif,'','',-1,null,'1');
                  // echo 'aqui:'.$buscarsiyaesta[1];
                   for($j=0;$j<count($_SESSION['detalleMemoE']);$j+=43){
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
                       $bus=false;
	                   if (!$busqueda and count($buscarsiyaesta)==0){
	                   	for($i=0;$i<count($listarBeneficiario);$i++){
			              $_SESSION['detalleMemoE'][] = $listarBeneficiario[$i];
			              $bus=true;
	                   	}
	                   	  if($bus)  $_SESSION['detalleMemoE'][]=$monto;
	                   }else  echo '<script>alert("Este Numero '.$rif.' ya esta ingresado")</script>';
		       //    else
		        //    echo '<script>alert("Este Numero '.$rif.' no pertenece a el Banco al cual esta emitiendo el memo o esta Errado")</script>';

}

if($indReg=='2'){

$indReg = NULL;
$nummemo = NULL;
$_SESSION['banco'] = NULL;
$_SESSION['atencion'] = NULL;
$_SESSION['estatus']= NULL;
$nota = NULL;
$rif = NULL;
$_SESSION['detalleMemoE']=NULL;
$listarBancos2=null;
}

if($indReg=='3'){

$regrif=$objBeneficiario->registroEstatusCredito($_SESSION['idBanco'],$_SESSION['detalleMemoE'],$_SESSION['estatus']);

$_SESSION['detalleMemoE'] = NULL;
//echo 'aqui: '.count($regrif);

				 	if (count($regrif)==0){
					 echo '<script>alert("Creditos Registrados")</script>';
					 echo "<SCRIPT>window.location.href='listado_estatusCreditoBan.php';</SCRIPT>";
			         echo '<script>window.close();</script>';
					}else
					{
						$nopasaron=null;
						for($i=0;$i<count($regrif);$i++){
                      	$nopasaron=$nopasaron.$regrif[$i];
                      //	echo 'aqui1: '.$regrif[$i];
                      }
                    //  echo 'aqui2: '.$nopasaron;
					 echo '<script>alert("Creditos No Registrados: '.$nopasaron.'")</script>';
					}

}

if ($indReg=='5'){
	//echo '<script>alert("hola")</script>';
	   $medAux  =  NULL;
	   //para el listado

	   for($i=0;$i<=count($_SESSION['detalleMemoE']);$i++) {
	   	$k=$i/43;

	   	if($k==$posicionElim) {

	   		//$_SESSION['sumaOC']=$_SESSION['sumaOC']-$_SESSION['detalleMemo'][$i];
	   		//echo 'aqui: '.$_SESSION['detallePago'][$i];
	   		$i+=43;
	   	}
	    $medAux[]  =  $_SESSION['detalleMemoE'][$i];

	   	}

	   //echo 'suma restada: '.$_SESSION['sumaOC'];
	   	$_SESSION['detalleMemoE']=null;
	   array_pop($medAux);
	   $_SESSION['detalleMemoE'] = $medAux;
}


?>
<!DOCTYPE HTML PUBLIC>
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

	    estatus=document.registro.estatus.value;


	   if(estatus!='')
		{
			document.registro.estatusid.value = estatus;
		}

		if(document.registro.rif.value.length<7 && dato==1 ) {
		 alert("Debe Ingresar el numero de rif o cedula valido");
		 document.registro.rif.focus();
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
 <input type="hidden" name="estatusid" id="estatusid" value="<?php echo $_SESSION['estatus']; ?>">
 <fieldset class="form">
  <legend>Estatus del beneficiario
     <table  align="center" >
        <!--  <tr>
           <td  class="categoria">N° de Memo:</td>
           <td align="left" colspan="2">
			<input name="nummemo" type="text" id="nummemo"  value="<?php echo $nummemo;?>"  />
		   </td>
          </tr>-->
		       <tr>
           <td  class="categoria">Estatus:</td>
           <td align="left" colspan="2">
             <SELECT id="estatus" name="estatus"  <?php if ($_SESSION['estatus']) echo "disabled";?> >
                      <option value="<?php if ($_SESSION['estatus']) echo $banco?>">
                      <?php
                      if ($_SESSION['estatus']=='4') echo 'Aprobado';
                      if ($_SESSION['estatus']=='16') echo 'Negado';
                      if ($_SESSION['estatus']=='17') echo 'Diferido';
                      if ($_SESSION['estatus']=='3') echo 'A la Espera de Documentos';
                      if ($_SESSION['estatus']=='30') echo 'Devuelto por Documentacion Incompleta';
                      if ($_SESSION['estatus']=='31') echo 'Imposible verificar constancia';
                      if ($_SESSION['estatus']=='32') echo 'Devuelto por cambio de Garantia';
                      if ($_SESSION['estatus']=='33') echo 'Cambio de Garantia Procesada';
                      ?>
                      </option>
				      <option value="4">Aprobado</option>
				      <option value="16">Negado</option>
				      <option value="17">Diferido</option>
				      <option value="2">Credito en analisis Bancario</option>
				      <option value="3">A la Espera de Documentos</option>
				      <option value="30">Devuelto por Documentacion Incompleta</option>
				      <option value="31">Imposible verificar constancia</option>
				      <option value="32">Devuelto por cambio de Garantia</option>
				      <option value="33">Cambio de Garantia Procesada</option>
			 </SELECT>
          </td>
		   </tr>
		   <tr>
           <td  class="categoria">Rif / Ci :</td>
          <td align="left">
             <input name="rif" type="text" id="rif" value="" onblur="javascript:this.value=this.value.toUpperCase()" maxlength="10"/>
                   Monto:
             <input name="monto" type="text" id="monto" value="0" onblur="javascript:this.value=this.value.toUpperCase()" maxlength="10"/>
               <input type="button"  value="Agregar" onclick="enviar(1)">
               <input type="button"  value="Limpiar Todo" onclick="enviar(2)">
               <input type="button"  value="Guardar" onclick="enviar(3)">
           </td>
          </tr>

  </table>
   </fieldset>
  </legend>

 <fieldset class="form">
  <legend>Detalle
 <!-- <input  type="button" id="articulo" onClick="abrir('reportes/listrifificados.php?idsercarveh=<?php echo$sercarveh;?>&numcerveh=<?php echo$numcerveh;?>&codpro=<?php echo$codpro;?>&nomcomp=<?php echo$nomcomp;?>&numfac1veh=<?php echo$numfac1veh;?>&numlotveh=<?php echo$numlotveh;?>&codmar=<?php echo$codmar;?>&codmodveh=<?php echo$codmodveh;?>&codserveh=<?php echo$codserveh;?>&desserveh=<?php echo$desserveh;?>&desmodveh=<?php echo$desmodveh;?>&desmarveh=<?php echo$desmarveh;?>&tip=<?php echo $tipo;?>');" value="PDF" />-->
     <TABLE width="800" align="center" class="detalles">
         <tr>
              <td class="cabecera">N° rif</td>
              <td class="cabecera">Nombre </td>
              <td class="cabecera">Apellido</td>
              <td class="cabecera">Telefono 1</td>
              <td class="cabecera">Telefono 2</td>
               <td class="cabecera">Monto</td>
               <td class="cabecera">Borrar</td>
             </tr>
       <?php  $indC = false; for($i=0;$i<count($_SESSION['detalleMemoE']);$i+=43){
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
               <td><?php echo $_SESSION['detalleMemoE'][$i+42]?></td>
	    <TD ><div align="center"><a class="vinculo" href="javascript: eliminar('5','<?php  echo $i/43;?>')"><img src="botones/delete.png" width="29" height="29" border="0"></a></div></TD>
	    </TR>
        <?php  }   ?>
	  </TABLE>
    </TD>
  </TR>
</tr>
</table>
 </fieldset>
  </legend>
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