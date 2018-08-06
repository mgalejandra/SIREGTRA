<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/vehiculos.php');

  $sercarveh=$_POST['serial'];
  $codmar=$_POST['codmar'];
  $modveh=$_POST['codmodveh'];
  $serveh=$_POST['codserveh'];
  $pgActual = $_POST['pagina'];
  $numlotveh=$_POST['numlotveh'];
  $taller = $_POST['codtal'];
  $tt = $_POST['todo_taller'];

$objVehiculo = new vehiculos();

$nroFilas = 15;
$nroCampos = 5;


$contArt = $objVehiculo->ContVehiculos($sercarveh,$codmar,$modveh,$serveh,'N',$numlotveh,'','',$taller,$tt,$_SESSION['numeDepa']);


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
//echo "Offset: ".$offset;
$listVehiculos=$objVehiculo->listadeVehiculos($sercarveh,$codmar,$modveh,$serveh,'N',$numlotveh,'','',$offset,$taller,$tt,$_SESSION['numeDepa']);


?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
    <script>

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

function abrir(campo)
{
pagina=campo;
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=500,resizable=yes,left=50,top=50");
}

function abrir1(campo)
{
pagina=campo;
window.open(pagina,"Asignacion","menubar=no,toolbar=no,scrollbars=yes,width=1000,height=250,resizable=yes,left=50,top=50");
}



function abrir2(campo)
{
pagina=campo;
window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=no,width=540,height=150,resizable=no,left=100,top=100");
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
    <form action="" method="post" name="beneficiario">
 <fieldset class="form">
  <legend>Criterios de B&uacute;squeda</legend>
     <table  align="center" >
          <tr>
            <td  class="categoria">Serial de Carr.:</td>
           <td class="dato">
			<input name="serial" type="text" id="serial"  value="" />
		  </td>
           <td  class="categoria">Marca:</td>
           <td>
			<input name="codmar" type="hidden" id="codmar"  value="<?php if($ban==1)  echo $registro['codmarveh'];?>" />
	        <input name="desmar" type="text" id="desmar"  value="<?php if($ban==1)  echo $objMarca->buscarMarca($registro['codmarveh']);?>"  readonly=""/>
	        <input name="marca" type="button" id="marca" onclick="catalogo('marca2.php');" value="..." />
		  </td>
		   </tr>
		   <tr>
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
             <td  class="categoria">N° Lote :</td>
           <td>
             <input name="numlotveh" type="text" id="numlotveh" value="<?php if($ban==1)  echo $listCarac[$i+25] ; ?>" size="3" maxlength="3"/>
             <input name="lote" type="button" id="lote" onclick="catalogo('cat_lot.php');" value="..." />
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
  <legend>Listado de  Vehiculos Nacionales <?php echo $contArt; ?></legend>
  <!--<input  type="button" id="articulo" onClick="abrir('reportes/vehNacionales.php?sercarveh=<?php echo $sercarveh; ?>&codmar=<?php echo $codmar; ?>&modveh=<?php echo $modveh; ?>&serveh=<?php echo $serveh; ?>&taller=<?php echo $taller; ?>&tt=<?php echo $tt; ?>');" value="PDF" />-->
    <table width="90%" align="center" class="detalles">
    <tr><td colspan="9" align="right"><a class="vinculo" target="_blank" onClick="abrir('reportes/vehNacionales.php?sercarveh=<?php echo $sercarveh; ?>&codmar=<?php echo $codmar; ?>&modveh=<?php echo $modveh; ?>&serveh=<?php echo $serveh; ?>&taller=<?php echo $taller; ?>&tt=<?php echo $tt; ?>');" />
  <IMG title="PDF" src="botones/pdf.png" height="15" ></a>
 </td></tr>
             <tr>
              <td class="cabecera">Lote.</td>
              <td class="cabecera">Serial de Carr.</td>
              <td class="cabecera">Serial de Motor</td>
              <td class="cabecera">Color</td>
              <td class="cabecera">Serial de NIV</td>
              <td class="cabecera">Marca</td>
              <td class="cabecera">Modelo</td>
              <td class="cabecera"> B </td>
           <?php if ($_SESSION['tipoUsuario'] != 5 and  $_SESSION['tipoUsuario'] != 6 and $_SESSION['tipoUsuario'] != 2 and $_SESSION['tipoUsuario']!= 11) { ?>
              <td class="cabecera"> T </td>
               <?php }?>
                <td class="cabecera">T</td>
           
              <td class="cabecera">PDI</td>
             </tr>
      
<?php
        for($i=0;$i<count($listVehiculos);$i+=17){
          if($listVehiculos[$i]){
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
               <td align="center" ><?php echo str_pad($listVehiculos[$i+16],3,"0",STR_PAD_LEFT)?></td>
               <td align="center"><code><?php echo $listVehiculos[$i]?></code></td>
               <td><?php  echo $listVehiculos[$i+1];?> </td>
               <td><?php echo $listVehiculos[$i+2]?></td>
               <td><code><?php echo $listVehiculos[$i+3]?></code></td>
               <td><?php echo $listVehiculos[$i+14]?></td>
               <td align="center" ><?php echo $listVehiculos[$i+15]?></td>
               <td><div align="center">
               <a class="vinculo" href="reg_vehiculos_nac.php?idsercarveh=<?php echo $listVehiculos[$i]?>">
	              <img src="botones/buscar.png" width="20" height="20">
	          </a></div></td>
	               <?php if ($_SESSION['tipoUsuario'] != 5 and  $_SESSION['tipoUsuario'] != 6 and $_SESSION['tipoUsuario'] != 7 and $_SESSION['tipoUsuario']!= 11) { ?>
	          <td><div align="center">
	           <a class="vinculo" href="javascript:abrir1('asig_vehiculos_taller.php?idsercarveh=<?php echo $listVehiculos[$i]?>&pag=1')">
	              <img src="botones/taller.png" width="20" height="20" onClick="abrir1('asig_vehiculos_taller.php?idsercarveh=<?php echo $listVehiculos[$i]?>')">
	          </a></div></td>
	           <?php     }  ?>
<?php     }  ?>
	          <TD align="center">
			  <IMG onclick="abrir2('mod_nopdi.php?sercarveh=<? echo $listVehiculos[$i]; ?>')" src="imagenes/notice-alert.png" title="NO PDI">
		      </TD>
              </tr>
<?php     }  //onclick="envia(2,'<?php echo $listVehiculos[$i] esto estaba en la linea 267, con esto marcaba como no apto el carro debo cerrar el php y agregar >')"
        
        
        
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