<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/usuarios.php');

$objUsu = new usuario();


$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2);
//validaAcceso($permitidos,$dir);
$ban=0;
$indReg=$_POST['indReg'];

$ban=0;
$indErr = false;

  $descripcion=$_POST['descripcion'];
  $nivel=$_POST['nivel'];


  if ($indReg==3)  {
 	$descripcion=null;
 	$nivel=null;

}

	if ($indReg==1){
  $ban=1;
  $registro = $objUsu->regtipUsu($descripcion,$nivel);


	if ($registro)  {
		echo "<script>alert('Nuevo Tipo de Usuario Registrado');</script>";
	  echo "<SCRIPT>window.location.href='listado_tipUsu.php';</SCRIPT>";
	}


	else  echo "<script>alert('Nuevo Tipo de Usuario NO Registrado');</script>";
	}
?>
<script type="text/javascript">
document.oncontextmenu = function(){return false;}
</script>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
   <link href="../css/classstyles.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script type="text/javascript" src="../controlador/validar.js"></script>

  <script>


function validarCaract(dato){
 var letras_mayusculas="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ ";
 if (document.form1.descripcion.value.length==0){
  alert("Debe Ingresar la descripcion ");
  document.form1.descripcion.focus()
  return (false);
                                         }

                                         else
 {
   var filter = /^[a-z0-9_\-\.\ \[\]\(\)]+$/i;
   if (!filter.test(document.form1.descripcion.value)) {
   alert('Carácteres no válidos en  la Descripcion');
   document.form1.descripcion.focus();
   return (false);}
 }

  if (document.form1.nivel.value.length==0){
  alert("Debe seleccionar el nivel ");
  document.form1.descripcion.focus()
  return (false);
                                         }


 document.form1.indReg.value = dato;
 document.form1.submit();

}

function limpiar(dato){
 document.form1.indReg.value = dato;
 document.form1.submit();

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

     <TD class="cuerpo">
      <DIV class="nivel1">
       <DIV class="nivel2">
<!--  Contenido Principal         -->
  <form id="form1" name="form1" method="post" action="">
  <table class="formulario" width="400" border="0" align="center" >
      <tr>
        <td colspan="3" class="cabecera">Registro de Tipo de Usuario</td>
      </tr>

      <tr>
        <td class="categoria">Descripción :</td>
        <td class="dato">
         <input name="descripcion" type ="text" id="descripcion"  value="<?php echo $descripcion;?>" size="25" maxlength="150" onblur="javascript:this.value=this.value.toUpperCase()" ></td>

      </tr>

     <tr>
        <td class="categoria">Nivel:</td>
        <td class="dato" >
            <select name="nivel" id="nivel">
            <option value=""></option>
            <option value="1">TECNOLOGIA</option>
            <option value="2">IMCP</option>
            
          </select>
        </td>
      </tr>
       <tr>
        <td height="22" colspan="4">
            <div align="center">  </div>
         </td>
       </tr>
      <tr>
        <td height="22" colspan="4">
          <div align="center">
           <input type="hidden" name="indReg" >

            <input name="agregar" type="button" id="agregar" onclick="validarCaract(1); return false" value="Agregar" />
           <!-- <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Modificar"/> -->
           <input name="listar" type="button" id="listar" onclick="window.location.href='listado_tipUsu.php'" value="Listar" />
          <input  type="button" onclick="limpiar('3');" value="Limpiar" />
         </div>
     </tr>
</table>
    </form>
<!--  FIN Contenido Principal -->
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