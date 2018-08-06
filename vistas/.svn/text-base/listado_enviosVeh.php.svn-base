<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/certificado.php');
require('../modelos/envios.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,11,17,18,22,24,25);
	validaAcceso($permitidos,$dir);

  $numcerveh=$_POST['numcerveh'];
  $sercarveh=$_POST['sercarveh'];
  $codpro=$_POST['codpro'];
  $nomcomp=$_POST['nomcomp'];
  $numfac1veh=$_POST['numfac1veh'];
  $pgActual = $_POST['pagina'];
  $envio=  explode("-", $_POST['envio']);
  $_SESSION['numenv']=$envio[0];
  $_SESSION['tipo']=$envio[1];
//echo 'aquiiiiiiiiii---'.substr($envio[1],0,1).'---';
  $envio[1]=substr($envio[1],0,1);
  if ($envio[1] == 'P'){
	  $tipos='estatuspla';
	  $tipoEnvio='numenvpla';
  }


  if ($envio[1] == 'B')
  {
    $tipos='estatuspro';
    $tipoEnvio='numenvpro';
  }


  if ($envio[1] == 'I')
  {
    $tipos='estatusveh';
    $tipoEnvio='numenvveh';
  }


  if ($envio[1] == 'N'){
    $tipos='estatusveh';
    $tipoEnvio='numenvveh';
  }


  if ($envio[1] == 'X')
  {
  $tipos='X';
  $tipoEnvio='X';
  }

//echo 'aquiiiiiiiiii---:'.($envio[1]).':---';
  if ($envio[1] == ''){
  	  $_SESSION['numenv']='X';
  	  $tipos='X';
  	 // echo 'entro';
  }

//echo 'esta.: '.$tipos;
$objCertificado = new certificado();
$objenvios = new envios();

$nroFilas = 15;
$nroCampos = 25;

$comboEnvio = $objenvios->comboEnvio();

$contArt = $objenvios->contarVehTxt($_SESSION['numenv'],$tipos,$sercarveh,$codpro,$nomcomp,$tipoEnvio,'');

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

//$listarcertificado=$objenvios->txtVehNac($numenv);
//$listarcertificado=$objCertificado->listarCertificados('',$numcerveh,$sercarveh,$codpro,$nomcomp,$numfac1veh,$offset);
  $listarcertificado=$objenvios->listarVehTxtCon($_SESSION['numenv'],$tipos,$sercarveh,$codpro,$nomcomp,$tipoEnvio,'',$offset);
?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
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
  <legend>Criterios de Busqueda</legend>
              </select>
     <table  align="center" >
	     <tr>
		     <td class="categoria">Nro. Envio </td>
		     <td colspan="5" class="dato">
		     <select name="envio" size="1" id="envio">
		           <option value="<?php echo $_SESSION['numenv'].'-'.$_SESSION['tipo']; ?>"><?php echo $_SESSION['numenv'].'-'.$_SESSION['tipo']; ?></option>
			   <?php for($i=0;$i<count($comboEnvio);$i+=10){  ?>
	               <option value="<?php echo $comboEnvio[$i].'-'.$comboEnvio[$i+6].'-'; ?>"><?php echo 'Envio Nro. ('.$comboEnvio[$i].') Fecha. ('.$comboEnvio[$i+1].') Tipo. ('.$comboEnvio[$i+5].') Cantidades: MA ('.$comboEnvio[$i+2].') MM ('.$comboEnvio[$i+3].') ME ('.$comboEnvio[$i+4].')'?></option>
	           <?php } ?>
	               <option value="<?php echo '0'.'-'.'X'; ?>">TODOS</option>
              </td>
	     </tr>
          <tr>
           <td  class="categoria">Serial:</td>
           <td>
             <input name="sercarveh" type="text" id="sercarveh" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="18" />
          </td>
          <td  class="categoria">Cod. Ben:</td>
            <td>
             <input name="codpro" type="text" id="codpro" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="10" />
          </td>
           <td  class="categoria">Beneficiario:</td>
           <td>
             <input name="nomcomp" type="text" id="nomcomp" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="20" />
          </td>
          </tr>
          <tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden"  name="indReg" >
		    <INPUT type="hidden" name="idUsu" >
           </td>
          </tr>
  </table>
   </fieldset>

 <fieldset class="form">
  <legend>Listado de Envios al INTT</legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera"> Envio Veh. </td>
              <td class="cabecera"> Fec. Veh </td>
              <td class="cabecera"> Envio Pro. </td>
              <td class="cabecera"> Fec. Pro </td>
              <td class="cabecera"> Envio Pla. </td>
              <td class="cabecera"> Fec. Pla </td>
              <td class="cabecera">N° de Certificado</td>
              <td class="cabecera">Vehiculo</td>
              <td class="cabecera">cod. Beneficiario</td>
              <td class="cabecera">Beneficiario</td>
             </tr>
<?php
        for($i=0;$i<count($listarcertificado);$i+=25){
          if($listarcertificado[$i]){
             if(!$indC){
                 $color ='datosimpar';
                 $indC = true;
             }
             else{
                 $color ='datospar';
                 $indC = false;
             }
?>

              <tr class="<?php echo $color ?>">

               <td align="center"><?php echo $listarcertificado[$i+19];?> </td>
               <td><?php echo $listarcertificado[$i+20];?></td>
               <td align="center"><?php echo $listarcertificado[$i+21];?></td>
               <td><?php echo $listarcertificado[$i+22];?> </td>
               <td align="center"><?php echo $listarcertificado[$i+23];?> </td>
               <td><?php echo $listarcertificado[$i+24];?></td>

               <td align="center"><?php echo $listarcertificado[$i];?></td>
               <td><?php echo $listarcertificado[$i+2];?> </td>
               <td><?php echo $listarcertificado[$i+3];?></td>
               <td><?php echo $listarcertificado[$i+4];?></td>
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
