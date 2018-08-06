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
	$permitidos = array(1,2,3,4,5,11,17,18);
	validaAcceso($permitidos,$dir);

  $numcerveh=$_POST['numcerveh'];
  $sercarveh=$_POST['sercarveh'];
  $codpro=$_POST['codpro'];
  $nomcomp=$_POST['nomcomp'];
  $numfac1veh=$_POST['numfac1veh'];
  $pgActual = $_POST['pagina'];
  $envio=$_POST['envio'];

$objCertificado = new certificado();
$objenvios = new envios();

$nroFilas = 17;
$nroCampos = 27;

$comboEnvio = $objenvios->comboEnvio();

$contArt = $objenvios->ContarlistadoProTxt_hist($envio,$tipos,$sercarveh,$codpro,$nomcomp,$tipoEnvio,'');

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
  $listarcertificado=$objenvios->listadoProTxt_hist($envio,$tipos,$sercarveh,$codpro,$nomcomp,$tipoEnvio,'',$offset);
?>
<!DOCTYPE HTML PUBLIC>
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
	     <td  class="categoria">N° Envio:</td>
           <td>
             <input name="envio" type="text" id="envio" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="4" maxlength="18" />
          </td>

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
            <td align="center" colspan="8" >
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
  <legend>Histórico de Envíos de Propietarios</legend>
    <table width="100%" align="center" class="detalles">
             <tr>
              <td width="10%"class="cabecera"> Ced/Rif </td>
              <td  width="30%" class="cabecera"> Beneficiario </td>
              <td width="25%" class="cabecera">  Direccion </td>
              <td width="10%" class="cabecera"> Telefonos </td>
              <td  width="10%"class="cabecera"> Serial </td>
              <td width="5%" class="cabecera"> Envio </td>
              <td width="10%" class="cabecera"> Fecha Reg. </td>
             </tr>
<?php
        for($i=0;$i<count($listarcertificado);$i+=28){
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
               <td align="center"><?php echo $listarcertificado[$i+5].$listarcertificado[$i+6].$listarcertificado[$i+7];?> </td>
               <td align="left"> <?php echo $listarcertificado[$i+8].' '.$listarcertificado[$i+9].' '.$listarcertificado[$i+10].' '.$listarcertificado[$i+11];?></td>
               <td align="left"><?php echo $listarcertificado[$i+13].' '.$listarcertificado[$i+14].' '.$listarcertificado[$i+15].' '.$listarcertificado[$i+18];?></td>
               <td><?php echo $listarcertificado[$i+19].' - '.$listarcertificado[$i+20]?> </td>
               <td align="center"><?php echo $listarcertificado[$i+23];?> </td>
               <td align="center"><?php echo $listarcertificado[$i+26];?></td>
                <td align="center"><?php echo $listarcertificado[$i+27];?></td>
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
