<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/reportes.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,11,15,18,25);
	validaAcceso($permitidos,$dir);
	//require ('../modelos/usuarios.php');

    $nroCampos= 2;

	$objreportes = new reportes();

	$diagnosticoCreditos=$objreportes->diagnosticoCreditos2($numlotveh);


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
	     " = window.open('reportes/pdfCreditoBancaPublica2.php','','toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=0,width=1100,height=900');");
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
<!-- <fieldset >
  <legend>Criterios de B&uacute;squeda</legend>
     <table  align="center" >
 <tr>
          <td  class="categoria"></td>
          <td align="left">
         </td></tr>
         <tr>
            <td align="center" colspan="6" >
            <input type="submit" value="Buscar" onclick="enviar(1)"/>
            <input type="submit" onclick="enviar(2)" value="Limpiar"/>
            <INPUT type="hidden"  name="indBusq">
           </td>
          </tr>
  </table>
   </fieldset>
   -->
 <fieldset >
  <legend>Diagnostico Creditos Banca Publica</legend>
    <table width="90%" align="center" class="detalles" border=0>
    <tr>
  				<td colspan="23" align="right">
			  			<a class="vinculo" target="_blank" onClick="imprimir()" />
			    			<IMG title="PDF" src="botones/pdf.png" height="15" >
			        	</a>
			      </td>
             </tr>
             <tr>
              <td class="cabecera" width="40%" Rowspan=2>Entidad Financiera</td>
              <td class="cabecera" width="10%" Rowspan=2 >Carpetas Recibidas en SUVINCA</td>
              <td class="cabecera" width="10%" Rowspan=2 >Carpetas Recibidas en SUVINCA sin Procesar</td>
              <td class="cabecera" width="35%" Colspan=4 >Expedientes Procesados</td>
              <td class="cabecera" width="45%" Colspan=3 >Liquidación Créditos</td>
              <td class="cabecera" width="60%" Rowspan=2>Vehiculos Entregados</td>

             </tr>
             <tr>
              <td class="cabecera" width="8%">Expedientes en Análisis</td>
              <td class="cabecera" width="8%">Créditos Negados</td>
              <td class="cabecera" width="10%">Créditos Diferidos</td>
              <td class="cabecera" width="10%">Créditos Aprobados</td>

              <td class="cabecera" width="10%">Créditos sin Ejecutar</td>
              <td class="cabecera" width="10%">Créditos Liquidados</td>
              <td class="cabecera" width="10%">Créditos por Liquidar</td>
             </tr>
 <?php
       	    $acum1=0;
        	 $acum2=0;
        	 $acum3=0;
        	 $acum4=0;
        	 $acum5=0;
        	 $acum6=0;
        	 $acum7=0;
        	 $acum8=0;
        	 $acum9=0;

      	for($i=0;$i<count($diagnosticoCreditos);$i+=17){
      		if($diagnosticoCreditos){
             $color = (!$indC)?'datosimpar':'datospar';
        	 $indC = !$indC;

    $col1=$diagnosticoCreditos[$i+3]; $acum3+=$diagnosticoCreditos[$i+3];
    $col2=$diagnosticoCreditos[$i+5]; $acum4+=$diagnosticoCreditos[$i+5];
    $col3=$diagnosticoCreditos[$i+6]+($diagnosticoCreditos[$i+7]+$diagnosticoCreditos[$i+8]+$diagnosticoCreditos[$i+9]);
    $acum5+=$diagnosticoCreditos[$i+6]+($diagnosticoCreditos[$i+7]+$diagnosticoCreditos[$i+8]+$diagnosticoCreditos[$i+9]);
   // $col4=$diagnosticoCreditos[$i+16]+($diagnosticoCreditos[$i+10]+$diagnosticoCreditos[$i+11])+
   //     ($diagnosticoCreditos[$i+12]+$diagnosticoCreditos[$i+13]+$diagnosticoCreditos[$i+14]+$diagnosticoCreditos[$i+15]);

//$acum6+=$diagnosticoCreditos[$i+4]+($diagnosticoCreditos[$i+10]+$diagnosticoCreditos[$i+11])+($diagnosticoCreditos[$i+12]+$diagnosticoCreditos[$i+13]+$diagnosticoCreditos[$i+14]);
$col5=$diagnosticoCreditos[$i+16]; $acum7+=$diagnosticoCreditos[$i+16];
$col6=$diagnosticoCreditos[$i+10]+$diagnosticoCreditos[$i+11];  $acum8+=$diagnosticoCreditos[$i+10]+$diagnosticoCreditos[$i+11];
$col7=($diagnosticoCreditos[$i+12]+$diagnosticoCreditos[$i+13]+$diagnosticoCreditos[$i+14]+$diagnosticoCreditos[$i+15]); $acum9+=($diagnosticoCreditos[$i+12]+$diagnosticoCreditos[$i+13]+$diagnosticoCreditos[$i+14]+$diagnosticoCreditos[$i+15]);
$col8=$diagnosticoCreditos[$i+10]; $acum10+=$diagnosticoCreditos[$i+10];
$col4=$col5+$col6+$col7;

$acum6=$acum7+$acum8+$acum9;


?>
              <tr class="<?php echo $color ?>">
               <td align="center"><?php echo $diagnosticoCreditos[$i+1]; ?> </td>
               <td align="center"><?php
                                        if($diagnosticoCreditos[$i]=='0003') { $indu=642+$diagnosticoCreditos[$i+2]; echo $indu; } //493
                                        if($diagnosticoCreditos[$i]=='0102') { $vzla=1831+$diagnosticoCreditos[$i+2]; echo $vzla; } //1831
                                        //if($diagnosticoCreditos[$i]=='0149') { $puebl=144+$diagnosticoCreditos[$i+2]; echo $puebl; }
                                        if($diagnosticoCreditos[$i]=='0149') { $puebl=172+$diagnosticoCreditos[$i+2]; echo $puebl; } //172
                                        if($diagnosticoCreditos[$i]=='0163') { $teso=3000+$diagnosticoCreditos[$i+2]; echo $teso; } //2574 //2783 //2618
                                        if($diagnosticoCreditos[$i]=='0175') { $bice=2534+$diagnosticoCreditos[$i+2]; echo $bice; } //2228
                                        if($diagnosticoCreditos[$i]=='0602') { $bandes=26+$diagnosticoCreditos[$i+2]; echo $bandes; }//24
                                        $acum2=$indu+$vzla+$puebl+$teso+$bice+$bandes;
                                   ?> </td>
 <td align="center"><?php
                                        if($diagnosticoCreditos[$i]=='0003') { $indu1=$indu-($col1+$col2+$col3+$col4); echo $indu1; }
                                        if($diagnosticoCreditos[$i]=='0102') { $vzla1=$vzla-($col1+$col2+$col3+$col4); echo $vzla1; }
                                        if($diagnosticoCreditos[$i]=='0149') { $puebl1=$puebl-($col1+$col2+$col3+$col4); echo $puebl1; }
                                        if($diagnosticoCreditos[$i]=='0163') { $teso1=$teso-($col1+$col2+$col3+$col4); echo $teso1; }
                                        if($diagnosticoCreditos[$i]=='0175') { $bice1=$bice-($col1+$col2+$col3+$col4); echo $bice1; }
                                        if($diagnosticoCreditos[$i]=='0602') { $bandes1=$bandes-($col1+$col2+$col3+$col4); echo $bandes1; }
                                        $acum22=$indu1+$vzla1+$puebl1+$teso1+$bice1+$bandes1;
                                   ?> </td>
               <td align="center"><?php echo $col1;?> </td>
               <td align="center"><?php echo $col2;?> </td>
               <td align="center"><?php echo $col3;?> </td>
               <td align="center"><?php echo $col4;?> </td>
               <td align="center"><?php echo $col5; ?> </td>
               <td align="center"><?php echo $col6;?> </td>
               <td align="center"><?php echo $col7;?> </td>
               <td align="center"><?php echo $col8;?> </td>
              <tr>
<?php
      		}
      	}
?>
             <tr>
              <td class="cabecera"  Rowspan=2>Totales</td>
              <td align="center"><font color="red"><?php echo FormatoMonto($acum2,0); ?></font></td>
              <td align="center"><font color="red"><?php echo FormatoMonto($acum22,0); ?></font></td>
              <td align="center"><font color="red"><?php echo FormatoMonto($acum3,0); ?></font></td>
              <td align="center"><font color="red"><?php echo FormatoMonto($acum4,0); ?></font></td>
              <td align="center"><font color="red"><?php echo FormatoMonto($acum5,0); ?></font></td>
              <td align="center"><font color="red"><?php echo FormatoMonto($acum6,0); ?></font></td>
              <td align="center"><font color="red"><?php echo FormatoMonto($acum7,0); ?></font></td>
              <td align="center"><font color="red"><?php echo FormatoMonto($acum8,0); ?></font></td>
              <td align="center"><font color="red"><?php echo FormatoMonto($acum9,0); ?></font></td>
              <td align="center"><font color="red"><?php echo FormatoMonto($acum10,0); ?></font></td>
             </tr>

</table>
<BR>
<fieldset>
<legend>Resumen</legend>
    <table width="90%" align="center" class="detalles" border=0>
             <tr>
              <td class="cabecera" width="15%">Solicitudes Recibidas</td>
			  <td align="center"><font color="red"><?php echo  FormatoMonto($acum2,0); ?></font></td>
			  <td align="center"><font color="red"><?php echo '100%'; ?></font></td>
			  <td width="5%"></td>
			  <td class="cabecera" width="15%">Créditos Aprobados</td>
			  <td align="center"><font color="red"><?php echo FormatoMonto($acum6,0); ?></font></td>
			  <td align="center"><font color="red"><?php echo '100%'; ?>  </font></td>
			  <td width="5%"></td>
			  <td class="cabecera" width="15%">Creditos Liquidados</td>
			  <td align="center"><font color="red"><?php echo FormatoMonto($acum8,0); ?></font></td>
			  <td align="center"><font color="red"><?php  echo '100%'; ?></font></td>
             </tr>
             <tr>
              <td class="cabecera" width="15%">Créditos Aprobados</td>
			  <td align="center"><font color="red"><?php echo FormatoMonto($acum6,0);  ?></font></td>
			  <td align="center"><font color="red"><?php echo FormatoMonto(($acum6*100)/$acum2,2).'%'; ?></font></td>
			  <td width="5%"></td>
			  <td class="cabecera" width="15%">Créditos Liquidados</td>
			  <td align="center"><font color="red"><?php echo FormatoMonto($acum8,0);  ?></font></td>
			  <td align="center"><font color="red"><?php echo FormatoMonto(($acum8*100)/$acum6,2).'%'; ?></font></td>
			  <td width="5%"></td>
			  <td class="cabecera" width="15%">Vehiculos Entregados</td>
			  <td align="center"><font color="red"><?php echo FormatoMonto($acum10,0);  ?></font></td>
			  <td align="center"><font color="red"><?php echo FormatoMonto(($acum10*100)/$acum8,2).'%'; ?></font></td>

             </tr>
             <tr>
              <td class="cabecera" width="15%">Diferencia</td>
			  <td align="center"><font color="red"><?php echo FormatoMonto($acum2-$acum6,0); ?></font></td>
			  <td align="center"><font color="red"><?php echo FormatoMonto(100-($acum6*100)/$acum2,2).'%'; ?></font></td>
			  <td width="5%"></td>
			  <td class="cabecera" width="15%">Diferencia</td>
			  <td align="center"><font color="red"><?php echo FormatoMonto($acum6-$acum8,0); ?></font></td>
			  <td align="center"><font color="red"><?php echo FormatoMonto(100-($acum8*100)/$acum6,2).'%'; ?></font></td>
			  <td width="5%"></td>
			  <td class="cabecera" width="15%">Diferencia</td>
			  <td align="center"><font color="red"><?php echo FormatoMonto($acum8-$acum10,0); ?></font></td>
			  <td align="center"><font color="red"><?php echo FormatoMonto(100-($acum10*100)/$acum8,2).'%'; ?></font></td>

             </tr>

</table>




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