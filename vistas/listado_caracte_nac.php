<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/caracteristicas.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,11,18,22,23,24);
	validaAcceso($permitidos,$dir);
	//require ('../modelos/usuarios.php');

  $codmar=$_POST['codmar'];
  $modveh=$_POST['codmodveh'];
  $serveh=$_POST['codserveh'];
  $pgActual = $_POST['pagina'];

$objCaract = new caracteristicas();

$nroFilas = 15;
$nroCampos = 5;

$contArt = $objCaract->contarCaracteristicasNaci('',$codmar,$modveh,$serveh,$_SESSION['numeDepa']);

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

$listCarac=$objCaract->listarCaracteristicasNaci('',$codmar,$modveh,$serveh,$offset,$_SESSION['numeDepa']);
?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
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
    <form action="" method="post" name="beneficiario">
 <fieldset class="form">
  <legend>Criterios de B&uacute;squeda</legend>
     <table  align="center" >
          <tr>
           <td  class="categoria">Marca:</td>
           <td>
			<input name="codmar" type="hidden" id="codmar"  value="<?php if($ban==1)  echo $registro['codmarveh'];?>" />
	        <input name="desmar" type="text" id="desmar"  value="<?php if($ban==1)  echo $objMarca->buscarMarca($registro['codmarveh']);?>"  readonly=""/>
	        <input name="marca" type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
		  </td>
           <td  class="categoria">Modelo :</td>
           <td>
             <input name="codmodveh" type="hidden" id="codmodveh" value="<?php if($ban==1)  echo $registro['codmodveh'];?>" />
             <input name="modveh" type="text" id="modveh" value="<?php if($ban==1)  echo $registro['modveh'];?>" size="20" maxlength="15" readonly=""/>
             <input name="modelo" type="button" id="modelo" onclick="catalogo('cat_modelo.php');" value="..." />
          </td>
           <td  class="categoria">Serie:</td>
           <td>
             <input name="codserveh" type="hidden" id="codserveh" value="<?php if($ban==1)  echo $registro['codserveh'];?>" />
             <input name="serveh" type="text" id="serveh" onblur="javascript:this.value=this.value.toUpperCase()" value="<?php if($ban==1)  echo $registro['serveh'];?>" readonly=""/>
             <input name="serie" type="button" id="serie" onclick="catalogo('cat_serie.php');" value="..." />
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
  <legend>Listado de Caracter&iacute;sticas Veh&iacute;culos Nacionales:  <?php echo $contArt; ?></legend>
    <table width="90%" align="center" class="detalles">
             <tr>
                 <td class="cabecera">N° de Caracter&iacute;stica</td>
              <td class="cabecera">Lote</td>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
              <td class="cabecera">tipo</td>
              <td class="cabecera">Serie</td>
              <td class="cabecera">Precio</td>
              <td class="cabecera">A&ntilde;o Modelo</td>
              <td class="cabecera">Origen</td>
              <td class="cabecera"> B </td>
             </tr>
<?php
        for($i=0;$i<count($listCarac);$i+=31){
          if($listCarac[$i]){
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
               <td align="center"><?php echo str_pad($listCarac[$i],3,'0',STR_PAD_LEFT)  ?></td>
                 <td><?php  echo $listCarac[$i+1];?> </td>
               <td><?php echo $listCarac[$i+2]?></td>
               <td><?php echo $listCarac[$i+3]?> </td>
               <td><?php echo $listCarac[$i+28]?> </td>
               <td><?php echo $listCarac[$i+4]?></td>
               <td><?php echo FormatoMonto($listCarac[$i+15])?> </td>
               <td align="center" ><?php echo $listCarac[$i+5]?></td>
               <td align="center" ><?php echo $listCarac[$i+6]?></td>
               <td><div align="center">
               <a class="vinculo" href="caracteristica_veh_nac.php?idcaract=<?php echo $listCarac[$i]?>">
	              <img src="botones/buscar.png" width="35" height="35">
	          </a></div></td>
              </tr>
<?php     }
        }
?>
<tr><td colspan=9> <?php echo 'Total: '.$contArt?></td></tr>
    </table>
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