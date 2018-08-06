<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(2);
validaAcceso($permitidos,$dir);
require ('../modelos/usuarios.php');

$indBusq = $_POST['busqueda'];
$limp = $_POST['limp'];
$nombre = $_POST['nombre'];
$estatus = $_POST['estatus'];
$usuario2 = $_POST['usuario2'];

if ($_GET['ci'])
$cedula = $_GET['ci'];
else
$cedula = $_POST['cedula'];

$tipo = $_POST['tipo'];

$idMod = $_POST['indMod'];
$valor = $_POST['valor'];

$objUsuario = new usuario();

if($idMod == 1){
   $cambioClave = $objUsuario->cambiarClave($valor);
   if($cambioClave)$msj = 'Clave cambiada satisfactoriamente a: '.$valor;
   else $msj = 'Error al cambiar clave';
   echo '<SCRIPT>alert("'.$msj.'");</SCRIPT>';
   $usuario = $valor;
}

if($idMod == 2){
   $cambioClave = $objUsuario->bloquearUsuario($valor);
   if($cambioClave)$msj = 'Usuario '.$valor.' bloqueado';
   else $msj = 'Error al bloquear usuario';
   echo '<SCRIPT>alert("'.$msj.'");</SCRIPT>';
   $usuario = $valor;
}

if($idMod == 3){
   $cambioClave = $objUsuario->activarUsuario($valor);
   if($cambioClave){
   	$msj = 'Usuario '.$valor.' ACTIVO';
   	$log=$objUsuario->logUsuario($valor);
   }
   else $msj = 'Error al activar usuario';
   echo '<SCRIPT>alert("'.$msj.'");</SCRIPT>';

   $usuario = $valor;
}


$nroFilas = 15;
$nroCampos = 14;

$contArt = $objUsuario->contarUsuario($usuario,$cedula,$tipo,$_SESSION['nivelUsu'],$nombre,$estatus,$usuario2);

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

$resUsuario = $objUsuario->buscarUsuario($usuario,$cedula,$tipo,$_SESSION['nivelUsu'],$offset,$nombre,$estatus,$usuario2);

if ($limp){
	$resUsuario=null;
	$usuario=null;
	$cedula=null;
	$tipo=null;
	echo "<SCRIPT>window.location.href='listado_usuariosSuvinca.php';</SCRIPT>";
}

?>
<!DOCTYPE HTML PUBLIC>
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <SCRIPT>
function buscar(){
  document.busq.busqueda.value = 1;
}
function limpiar(){
  document.busq.limp.value = 1;
}
function envia(dato,valor){
 document.busq.indMod.value = dato;
 document.busq.valor.value = valor;
 document.busq.submit();
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
    <form action="" method="post" name="busq">
 <fieldset class="form">
  <legend>Criterios de Busqueda
  </legend>
     <table  align="center" >
      <tr>
        <TD class="categoria">Usuario:</TD>
        <TD class="dato"><INPUT type="text" name="usuario2" onblur="javascript:this.value=this.value.toUpperCase()"></TD>
        <TD class="categoria">Nombre:</TD>
        <TD class="dato"><INPUT type="text" name="nombre" onblur="javascript:this.value=this.value.toUpperCase()"></TD>
        <TD class="categoria">Cédula:</TD>
	    <TD class="dato" ><INPUT type="text" name="cedula"></TD>
	     </tr>
      <tr>
	    <TD class="categoria">Tipo usuario:</TD>
	    <TD class="dato">
		       <select name="tipo" >
		       <option value=""></option>
			         <?php   $tipoUsuario = $objUsuario->retTipo('2');
			        for($i=0;$i<count($tipoUsuario);$i+=3){
			          echo '<option value="'.$tipoUsuario[$i].'">'.$tipoUsuario[$i+1].'</option>';
			        } ?>
		       </select>
        </TD>
        <TD class="categoria">Estatus:</TD>
	    <TD class="dato">
		     <select name="estatus" >
		       <option value=""></option>
		       <option value="ACTIVO">ACTIVO</option>
		       <option value="PENDIENTE">PENDIENTE</option>
		       <option value="BLOQUEADO">BLOQUEADO</option>
		     </select>
        </TD>
      </tr>
      <tr>
       <td align="center" colspan="6" >
             <INPUT type="submit" value="Limpiar" onClick="limpiar()">
		     <INPUT type="hidden" name="busqueda">
		     <input type="hidden" name="limp" id="limp" />
		       <INPUT type="hidden" name="indMod">
               <INPUT type="hidden" name="valor">
		     <INPUT type="submit" value="Buscar" onClick="buscar()">
       </td>
     </tr>
  </table>
   </fieldset>
 <fieldset class="form">
  <legend>Listado de Usuarios <?php echo 'Total: '.$contArt?>
  </legend>
    <table width="90%" align="center" class="detalles">
	 <TR >
	   <TH class="cabecera">Usuario</TH>
	   <TH class="cabecera" >Nombres</TH>
	   <TH class="cabecera">Apellidos</TH>
	   <TH class="cabecera">Cédula</TH>
	   <TH class="cabecera">Tipo Usuario</TH>
	   <TH class="cabecera">Ubicacion</TH>
	   <TH class="cabecera">Estatus</TH>
	   <TH class="cabecera">Cambiar Clave</TH>
      <TH class="cabecera">Bloq / Act</TH>
	 </TR>
<?php for($i=0;$i<count($resUsuario);$i+=$nroCampos){
             if(!$indC){
                 $color ='datosimpar';
                 $indC = true;
             }
             else{
                 $color ='datospar';
                 $indC = false;
             }
      ?>
 <TR class="<?php echo $color ?>">
   <TD><?php echo $resUsuario[$i]?></TD>
   <TD><?php echo $resUsuario[$i+1]; if($resUsuario[$i+2]) echo ' '.substr($resUsuario[$i+2],0,1); '.'?></TD>
   <TD><?php echo $resUsuario[$i+3]; if($resUsuario[$i+4]) echo ' '.substr($resUsuario[$i+4],0,1); '.'?></TD>
   <TD><?php echo $resUsuario[$i+5]?></TD>
   <TD><?php echo $resUsuario[$i+8];   ?></TD>
   <TD><?php if($resUsuario[$i+9]) echo $resUsuario[$i+11]; else if($resUsuario[$i+10]) echo $resUsuario[$i+12] ?></TD>
   <TD><?php echo $resUsuario[$i+7];   ?></TD>
   <TD align="center">
    <IMG onclick="envia(1,'<?php echo $resUsuario[$i]?>')" src="imagenes/llave.png" width="50" title="Cambiar Clave">
   </TD>
   <TD align="center">
   <?php if($resUsuario[$i+7] != 'BLOQUEADO'){?>
       <IMG onclick="envia(2,'<?php echo $resUsuario[$i]?>')" src="imagenes/notice-alert.png" title="Bloquear Usuario">
    <?php }else{ ?>
       <IMG onclick="envia(3,'<?php echo $resUsuario[$i]?>')" src="imagenes/correcto.png" width="30" title="Activar Usuario">
    <?php } ?>
   </TD>
 </TR>
<?php }?>
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
