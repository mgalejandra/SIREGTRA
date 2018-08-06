<?php
session_start();
require ('../controlador/funciones.php');
require ('../modelos/conexion.php');
$host = $_SERVER["HTTP_HOST"];

//echo "Usuario: ".$_SESSION['usuario'];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26);
validaAcceso($permitidos,$dir);
require ('../modelos/usuarios.php');
$ind = $_POST['ind'];
if($ind){
$clave = $_POST['clave'];
$conf = $_POST['conf'];
 if($clave !='' && $conf != ''){
  $objUsuario = new usuario();
  $ind = $objUsuario->modCalve($_SESSION['usuario'],$clave,$dir);
  if($ind){
     echo "<SCRIPT>
             alert ('Clave Modificada');
             window.location.href='principal.php';
           </SCRIPT>";
  }
 }
 else{
     echo "<SCRIPT>
             alert ('Clave y Confirmación no coinciden');
           </SCRIPT>";
 }
}

?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
<SCRIPT>
function cerrarSession(){
document.sesion.cierra.value = '1';
}

function pulsar(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==8) return true;
    patron =/\s/;
    te = String.fromCharCode(tecla);
    return !patron.test(te);
}

function cambiaClave(){

    var indErr = false;
    var indEnc = false;
	var msjError = '';
    var nombres = document.cambio.clave.value.split("");
    var numeros = [0,1,2,3,4,5,6,7,8,9];

    for(i=0;i<nombres.length;i++){
       for(j=0;j<numeros.length;j++){
	        if (nombres[i] == numeros[j])
	        {
             indEnc = true;
             break;
	        }
       }
       if (indEnc)  break;
    }


	if (document.cambio.clave.value != document.cambio.conf.value){
	indErr = true;
	msjError = 'Clave y Confirmación no coinciden';
	}

    else if (document.cambio.clave.value.length < 8){
	indErr = true;
	msjError = 'La clave debe tener al menos 8 caracteres';
	}

    else if (document.cambio.clave.value.length > 20){
	indErr = true;
	msjError = 'La clave no debe tener más de 20 caracteres';
	}

	else if (document.cambio.loguse.value == document.cambio.clave.value){
	indErr = true;
	msjError = 'La clave no puede ser igual al nombre de usuario';
	}

	else if (!indEnc){
	indErr = true;
	msjError = 'Ingrese al menos un caracter numérico';
	}

	else if (/^\s+$/.test(document.cambio.clave.value)){
	indErr = true;
	msjError = 'No puedes ingresar solo espacios en blancos';
	}


	else if (!isNaN(document.cambio.clave.value)){
	indErr = true;
	msjError = 'Debes ingresar al menos un caracter alfabético';
	}

	if(indErr){
	  alert(msjError);
	}

	if(!indErr){
      document.cambio.ind.value = '1';
	  document.cambio.submit();
	}
}

</SCRIPT>
  </head>
  <body class="pagina">
   <TABLE class="completo">
    <TR>
     <TD class="banner"></TD>
    </TR>
    <TR>
     <TD class="cuerpo">
      <DIV class="nivel1">
       <DIV class="nivel2">
<!--  Contenido Principal         -->
<FORM action="" method="POST" name="cambio">
 <TABLE class="formulario">
  <TR>
   <TD colspan="2" class="cabecera">Cambio de Clave</TD>
  </TR>
  <TR><TD class="categoria">Clave:</TD><TD class="dato"><INPUT type="password" name="clave" maxlength="20" id="clave" onkeypress = "return pulsar(event)"></TD></TR>
  <TR><TD class="categoria">Confirmar:</TD><TD><INPUT type="password" name="conf" maxlength="20" onkeypress = "return pulsar(event)"></TD></TR>
  <TR>
   <TD height="45" colspan="2" align="center">
    <INPUT type="reset" name="Limpiar" value="Limpiar">&nbsp;
    <INPUT type="submit" value="Guardar Clave" onclick="cambiaClave()">   </TD>
  </TR>

 </TABLE>
 <INPUT type="hidden" name="ind">
 <INPUT type="hidden" name="loguse" value='<?php echo $_SESSION['usuario']; ?>'>
</FORM>
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