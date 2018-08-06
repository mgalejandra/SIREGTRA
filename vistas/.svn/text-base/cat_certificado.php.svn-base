<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/certificado.php');

$indBusq = $_POST['indBusq'];

  $sercarveh 	= $_POST['sercarveh'];
  $codpro 		= $_POST['codpro'];
  $certificado 	= $_POST['certificado'];
  $nombre 		= $_POST['nombre'];

  $pgActual = $_POST['pagina'];

if($indBusq == 2){
	$_SESSION['sercarveh'] = null;
	$_SESSION['codpro'] = null;
	$_SESSION['certificado'] = null;	$_SESSION['nombre'] = null;
}else{
	$_SESSION['sercarveh'] = $sercarveh;
	$_SESSION['codpro'] = $codpro;
	$_SESSION['certificado'] = $certificado;
	$_SESSION['nombre'] = $nombre;
}

$objcertificado = new certificado();

///////////////////////////////////////////////////////////////////////////////////////////////////////

$nroFilas = 20; // -> Número de filas a presentar en pantalla
$nroColum = 9; // -> Número de columnas de la tabla < listarcertificado >
													// $id_certificado,$numcerveh,$sercarveh,$codpro,$nomcomp,$numfac1veh
$cantCertificados = $objcertificado->contarCertificado('',$certificado,$sercarveh,$codpro,$nombre,'');
$cantPaginas = ceil($cantCertificados/$nroFilas);

    if(!$pgActual) $pgActual = 1;
elseif($pgActual > $cantPaginas) $pgActual = $cantPaginas;

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
$listarcertificado=$objcertificado->catCertificado($sercarveh,$codpro,$nombre,'',$certificado,$offset);

///////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script language="javascript">

function enviar(dato){
	window.document.beneficiario.indBusq.value = dato;
	window.document.beneficiario.submit();
}
   function parametro(cod,des,id,num,codpro)
   {
   	  opener.document.getElementById('sercarveh').value = cod;
   	  opener.document.getElementById('beneficario').value = des;
   	  opener.document.getElementById('numcerveh').value = num;
   	  opener.document.getElementById('codproc').value = codpro;
      self.close();
   }

function avanzaPg(){
	pg = parseInt(window.document.beneficiario.pagina.value);
	window.document.beneficiario.pagina.value = pg+1;
	window.document.beneficiario.submit();
}

function enviaPg(pag){
	window.document.beneficiario.pagina.value = pag;
	window.document.beneficiario.submit();
}

function regresaPg(){
	pg = parseInt(window.document.beneficiario.pagina.value);
	window.document.beneficiario.pagina.value = pg-1;
	window.document.beneficiario.submit();
}

   </script>
  </head>
  <body class="pagina">
<!--  Contenido Principal         -->
    <form action="" method="post" name="beneficiario">
 <fieldset class="form">
  <legend>Criterios de Busqueda</legend>
     <table  align="center" >
          <tr>
           <td  class="categoria">Serial:</td>
           <td>
			<input name="sercarveh" type="text" id="cosercarvehdmar"  value="<?if($sercarveh)echo $_SESSION['sercarveh']?>" />
		  </td>
		   <td  class="categoria">Certificado:</td>
           <td>
			<input name="certificado" type="text" id="certificado"  value="<?if($certificado)echo $_SESSION['certificado']?>" />
		  </td>
		   </tr>
		    <tr>
           <td  class="categoria">CI/RIF :</td>
           <td>
             <input name="codpro" type="text" id="codpro" value="<?if($codpro) echo $_SESSION['codpro']?>" onblur="javascript:this.value=this.value.toUpperCase()" size="15" maxlength="15" />
          </td>
           <td  class="categoria">Beneficiario:</td>
           <td>
              <input name="nombre" type="text" id="nombre" size="20"  maxlength="20" value="<?if($nombre)echo $_SESSION['nombre']?>"  onblur="javascript:this.value=this.value.toUpperCase()">
           </td>
          </tr>
          <tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" />
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden" name="indReg" >
		    <INPUT type="hidden" name="idUsu" >
           </td>
          </tr>
  </table>
   </fieldset>

 <fieldset class="form">
  <legend>Listado de  Placas Asignadas</legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">N°</td>
              <td class="cabecera">Serial de Carroceria</td>
              <td class="cabecera">N° Certificado</td>
              <td class="cabecera">CI/RIF</td>
              <td class="cabecera">Beneficiario</td>
              <td class="cabecera">Fecha certificado</td>
             </tr>
<?php
        for($i=0;$i<count($listarcertificado);$i+=$nroColum){
          if($listarcertificado[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
			   <td align="center"><?echo $i/$nroColum+1+$offset?></td>
               <td align="center"><code>
               <a href="javascript: parametro('<?=$listarcertificado[$i]?>','<?=$listarcertificado[$i+2]?>','<?=$listarcertificado[$i+4]?>','<?=$listarcertificado[$i+8]?>','<?php echo $listarcertificado[$i+1]?>');"> <?php echo $listarcertificado[$i];  ?></a>
               </code></td>
               <td align="center"><code><?php echo $listarcertificado[$i+8]?></code></td>
               <td>&nbsp; <?php echo $listarcertificado[$i+1]?></td>
               <td>&nbsp; <?php echo $listarcertificado[$i+2]?></td>
               <td align="center"><?php echo $listarcertificado[$i+3]?></td>
              </tr>
<?php     }
        }
?>
    </table>
 </fieldset>

<BR>
     <div align="center">
       <?php if($pgActual>1){?>
         <img src="botones/atras.png" width="20" height="15" class="vinculo" onclick="regresaPg()">
       <?php }
         for($j=$pgIni;$j<=$pgFin;$j++){
             $claseVinc = ($pgActual == $j)?'vinculoAzul':'vinculo';
       ?>
          <a class="<?php echo $claseVinc ?>" onclick="enviaPg(<?php echo $j ?>)"><?php echo $j ?></a>
       <?php
         }
         if($pgActual<$pgFin){
       ?>
         <img src="botones/adelante.png" width="20" height="15"  class="vinculo" onclick="avanzaPg()">
       <?php } ?>
<BR>
       <input type="hidden" name="articulo" />
       <input type="hidden" name="pagina" value="<?php echo $pgActual ?>"/>
       <br />
     </div>
     <div align="center" >
        <input type="button" onclick="window.close()" value="Cerrar Ventana"/>
     </div>
    </form>
<!--  FIN Contenido Principal         -->
  </body>
</html>
