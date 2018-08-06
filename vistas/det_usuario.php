<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(3,2);
validaAcceso($permitidos,$dir);
require ('../modelos/usuarios.php');
$cod = $_GET['cod'];
$objUsuario = new usuario();

if($cod == 1){ // proceso para registrar usuario
   $resUsuario = $objUsuario->buscarUsuario($_SESSION['dataUsuario'][4],2);//busca usuario por la cedula
   if(count($resUsuario)>1){ // si consigue usuario envia mensaje de error
      $_SESSION['ciUsuario'] = $_SESSION['dataUsuario'][4];
      $_SESSION['dataUsuario']= NULL;
      echo '<SCRIPT>alert("Este usuario ya se esta registrado");window.location.href="detalle_usuario.php?cod=2"</SCRIPT>';
   }
   else {// si no consigue usuario registra nuevo
      $regUsuario = $objUsuario->regUsuario($_SESSION['dataUsuario'],$uri);
      if($regUsuario){
        $_SESSION['ciUsuario'] = $_SESSION['dataUsuario'][4];
        $_SESSION['dataUsuario']= NULL;
        echo '<SCRIPT>alert("Usuario registrado exitosamente");window.location.href="detalle_usuario.php?cod=2"</SCRIPT>';
      }
      else echo '<SCRIPT>alert("Error al registrar usuario");</SCRIPT>';
  }

}

$userElim = $_POST['userElim'];
if($userElim){
   $indElim = $objUsuario->eliminaUsuario($userElim,$uri);
   if($indElim)echo '<SCRIPT>alert("Usuario eliminado");</SCRIPT>';
   else echo '<SCRIPT>alert("Error al eliminar usuario");</SCRIPT>';
}

$resUsuario = null;
if($cod == 2){ // busca usuario por la cédula
   if(!$_SESSION['criterio']) $resUsuario = $objUsuario->buscarUsuario($_SESSION['ciUsuario'],2);
   else $resUsuario = $objUsuario->buscarUsuario($_SESSION['datoBusq'],3);
}



?>
<SCRIPT>
function elimina(dat){
 document.detalles.userElim.value = dat;
}
</SCRIPT>
<FORM action="" method="POST" name="detalles">
<TABLE class="formulario">
 <TR >
   <TH class="cabecera">Usuario</TH>
   <TH class="cabecera" >Nombres</TH>
   <TH class="cabecera">Apellidos</TH>
   <TH class="cabecera">Cédula</TH>
   <TH class="cabecera">Tipo Usuario</TH>
   <TH class="cabecera">Ubicacion</TH>
   <TH class="cabecera">Eliminar</TH>
 </TR>
<?php for($i=0;$i<count($resUsuario);$i+=13){
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
   <TD><INPUT type="submit" value="Eliminar" onclick="elimina('<?php echo $resUsuario[$i]?>')"></TD>
 </TR>
<?php }?>
</TABLE>
<BR>
<INPUT type="hidden" name="userElim" value="0">
<A href="buscar_usuario.php">Ir a la búsqueda</A>
</FORM>