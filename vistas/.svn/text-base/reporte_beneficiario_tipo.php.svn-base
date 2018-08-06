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
	$permitidos = array(1,2,3,4,5,11,15,18,25);
	validaAcceso($permitidos,$dir);

    $objBeneficiario=new beneficiario();

	$listar_Bene_Tipo_benef=$objBeneficiario->listar_Bene_Tipo_benef($numlotveh);



?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
    <SCRIPT>
  function imprimir() {
	day = new Date();
	id = day.getTime();
	eval("page" + id +
	     " = window.open('reportes/pdfCuadroPersonasTipo.php?lote=<? echo $numlotveh; ?>','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
	}

  function enviar(campo){
	window.document.inventario.indBusq.value = campo;
	window.document.inventario.submit();
  }
  </SCRIPT>
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
    <form action="" method="post" name="inventario">

 <fieldset class="form">
  <legend>Personas Registradas en sistema</legend>
    <table width="90%" align="center" class="detalles" border=0>
    <tr>
  				<td colspan="23" align="right">
			  			<a class="vinculo" target="_blank" onClick="imprimir()" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a>
			      </td>
             </tr>
             <tr>
              <td class="cabecera" width="70%">Tipo de Personas Registradas</td>
                  <td class="cabecera" >Venezolanos</td>
                      <td class="cabecera" >Extranjeros</td>
                          <td class="cabecera" >Gobierno</td>
                              <td class="cabecera" >Juridico</td>
              <td class="cabecera" >Total</td>
             </tr>
<?php
      	for($i=0;$i<count($listar_Bene_Tipo_benef);$i+=6){
      		if($listar_Bene_Tipo_benef){
      		 $totalG1+=$listar_Bene_Tipo_benef[$i+1];
      		  $totalG2+=$listar_Bene_Tipo_benef[$i+2];
      		   $totalG3+=$listar_Bene_Tipo_benef[$i+3];
      		    $totalG4+=$listar_Bene_Tipo_benef[$i+4];
      		     $totalG5+=$listar_Bene_Tipo_benef[$i+5];
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;
?>
              <tr class="<?php echo $color ?>">
              <td><?php echo $listar_Bene_Tipo_benef[$i];?> </td>
              <td align="center"><?php echo $listar_Bene_Tipo_benef[$i+1];?> </td>
              <td align="center"><?php echo $listar_Bene_Tipo_benef[$i+2];?> </td>
     		  <td align="center"><?php echo $listar_Bene_Tipo_benef[$i+3];?> </td>
              <td align="center"><?php echo $listar_Bene_Tipo_benef[$i+4];?> </td>
              <td align="center"><?php echo $listar_Bene_Tipo_benef[$i+5];?> </td>
              <tr>
<?php
      		}
      	}
?>

             <tr>
              <td class="cabecera">Total de Personas</td>
              <td class="cabecera" align="center"><?php echo $totalG1;?></td>
                <td class="cabecera" align="center"><?php echo $totalG2;?></td>
                  <td class="cabecera" align="center"><?php echo $totalG3;?></td>
                    <td class="cabecera" align="center"><?php echo $totalG4;?></td>
                      <td class="cabecera" align="center"><?php echo $totalG5;?></td>
             </tr>

</table>
</fieldset>
<BR>
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