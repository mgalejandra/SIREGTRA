<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/beneficiario.php');


	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
    $permitidos = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,25);
	validaAcceso($permitidos,$dir);

$objBeneficiario = new beneficiario();

$rif		= $_POST['rif'];
$nombre		= $_POST['nombre'];
$pgActual 	= $_POST['pagina'];

$nroCampos = 33;
$nroFilas = 25;

$cantBenef = $objBeneficiario->ContarBeneficiarios($rif,$nombre,'','','');

$cantPaginas = ceil($cantBenef/($nroFilas));
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
elseif($cantPaginas > 10 AND $pgActual< 5){
	$pgIni = 1;
	$pgFin = 10;
}
elseif($cantPaginas > ($pgActual+5) AND $pgActual >= 5){
	$pgIni = $pgActual - 4;
	$pgFin = $pgActual + 5;
}
else{
	$pgIni = $pgActual - 4;
	$pgFin = $cantPaginas;
}

$offset =  ($pgActual-1) * $nroFilas;

$listarBeneficiario=$objBeneficiario->listarBeneficiarios($rif,$nombre,$offset,'','','');

?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
    <script language="javascript">

   function parametro(cod,des)
   {
   	  opener.document.getElementById('codpro').value = cod;
   	  opener.document.getElementById('nombre').value = des;
      self.close();
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

   </script>
  </head>
  <body class="pagina">
<!--  Contenido Principal         -->
    <form action="" method="post" name="registro">
 <fieldset class="form">
  <legend>Criterios de B&uacute;squeda</legend>
     <table  align="center" >
          <tr>
           <td  class="categoria">CI/RIF:</td>
           <td>
			<input name="rif" type="text" id="rif"  onblur="javascript:this.value=this.value.toUpperCase()" value="" />
		  </td>
           <td  class="categoria">Nombre :</td>
           <td>
             <input name="nombre" type="text" id="nombre" value="" onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="15" />
          </td>
          </tr>
          <tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" />
            <input type="submit" value="Limpiar"/>
            <INPUT type="hidden" name="indBusq">
		    <INPUT type="hidden"  name="indReg" >
		    <INPUT type="hidden" name="idUsu" >
           </td>
          </tr>
  </table>
   </fieldset>


 <fieldset class="form">
  <legend>Listado de Beneficiarios</legend>
    <table width="90%" align="center" class="detalles">
             <tr>
              <td class="cabecera">N&deg;</td>
              <td class="cabecera">CI/RIF</td>
              <td class="cabecera">Nombre</td>
              <td class="cabecera">Direccion</td>
              <td class="cabecera">Tel&eacute;fonos</td>
              <td class="cabecera">Observaciones</td>
              <td class="cabecera">Fecha Registro</td>
              <td class="cabecera"> B </td>
             </tr>
<?php
        for($i=0;$i<count($listarBeneficiario);$i+=$nroCampos){
          if($listarBeneficiario[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;

             $direccion = $listarBeneficiario[$i+26];

             if($listarBeneficiario[$i+27]) $direccion.= ' '.$listarBeneficiario[$i+27];
			 if($listarBeneficiario[$i+28]) $direccion.= ' '.$listarBeneficiario[$i+28];
             if($listarBeneficiario[$i+29]) $direccion.= ' '.$listarBeneficiario[$i+29];
			 if($listarBeneficiario[$i+30]) $direccion.= ' '.$listarBeneficiario[$i+30];
             if($listarBeneficiario[$i+31]) $direccion.= ' '.$listarBeneficiario[$i+31];
			 if($listarBeneficiario[$i+32]) $direccion.= ' '.$listarBeneficiario[$i+32];
?>

              <tr class="<?php echo $color ?>">
               <td align="center"><?= $i/$nroCampos+$offset+1?></td>
               <td align="center">&nbsp;
                <a href="javascript: parametro('<?=$listarBeneficiario[$i]?>','<?=$listarBeneficiario[$i+6]?>')"><?php echo $listarBeneficiario[$i];?></a>
               &nbsp;</td>
               <td><?php echo $listarBeneficiario[$i+6];?> </td>
               <td><?php echo $direccion?></td>
               <td align="center"><?php echo $listarBeneficiario[$i+14].'  '.$listarBeneficiario[$i+15]?> </td>
               <td><?php echo $listarBeneficiario[$i+16]?></td>
               <td align="center" ><?php echo $listarBeneficiario[$i+18]?></td>
               <td><div align="center">
               <a class="vinculo" href="reg_beneficiarios.php?idbenefi=<?php echo $listarBeneficiario[$i]?>">
	              <img src="botones/buscar.png" width="20" height="20">
	          </a></div></td>
              </tr>
<?php     }
        }
?>
  <tr><td colspan=9> <?php echo 'Total: '.$cantBenef?></td></tr>
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