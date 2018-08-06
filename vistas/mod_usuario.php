<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require ('../modelos/usuarios.php');
require ('../modelos/banco.php');
require ('../modelos/departamento.php');
require ('../modelos/concesionario.php');
$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2);
validaAcceso($permitidos,$dir);
$objUsuario = new usuario();
$objBanco   = new banco();
$objDep = new departamento();
$objConcesionario= new concesionario();
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

<?php
// recibe los datos del formulario
$opc=$_GET['opr'];
$id = $_GET['id'];

$usuario=$_POST['usuario'];
$cedula=$_POST['cedula'];
$clave=$_POST['clave'];
$idcargo=$_POST['id_cargo'];
$nivel=$_POST['nivel'];
$nombre1=$_POST['nombre1'];
$nombre2=$_POST['nombre2'];
$apellido1=$_POST['apellido1'];
$apellido2=$_POST['apellido2'];
$estatus=$_POST['estatus'];
$status=$_POST['status'];
$usuario=$_POST['usuario'];
$banco=$_POST['banco'];
$dep=$_POST['dep'];
$env=$_POST['env'];
$concesionario=$_POST['concesionario'];
$correo=$_POST['correo'];


	$listarBancos=$objBanco->listarBancos('','','',1);
	$listarDep=$objDep->listarDepartamento();
	$listarConcec=$objConcesionario->listarConcesionario();


/*$msj = null;
$indErr = false;
	if($reg == 1){

		echo 'holaaaaaaaaaaa';

  if($nombre1){
     if(!validarString($nombre1)){
      $indErr = true;
      $msj.= '\n Hay carácteres inválidos en el primer nombre';
     }
  }
  elseif(!$nombre1){
      $indErr = true;
      $msj.= '\n El primer nombre es obligatorio';
  }

  if($nombre2){
     if(!validarString($nombre2)){
      $indErr = true;
      $msj.= '\n Hay carácteres inválidos en el segundo nombre';
     }
  }

  if($apellido1){
     if(!validarString($apellido1)){
      $indErr = true;
      $msj.= '\n Hay carácteres inválidos en el primer apellido';
     }
  }
  elseif(!$apellido1){
      $indErr = true;
      $msj.= '\n El primer apellido es obligatorio';
  }

  if($apellido2){
     if(!validarString($apellido2)){
      $indErr = true;
      $msj.= '\n Hay carácteres inválidos en el segundo apellido';
     }
  }

  if($cedula){
     if(!validarCedula($cedula)){
      $indErr = true;
      $msj.= '\n La cédula debe ser solo numérica';
     }
  }
  elseif(!$cedula){
      $indErr = true;
      $msj.= '\n La cédula es obligatoria';
  }

  if(!$idcargo){
      $indErr = true;
      $msj.= '\n Debe indicar el tipo de usuario';
  }
   if($indErr)f_alert("Reporte de validación:".$msj); // verifica si hay error con los datos
*/
//else {
if ($opc){

 if($nombre1){
     if(!validarString($nombre1)){
      $indErr = true;
      $msj.= '\n Hay carácteres inválidos en el primer nombre';
     }
  }
  elseif(!$nombre1){
      $indErr = true;
      $msj.= '\n El primer nombre es obligatorio';
  }

  if($nombre2){
     if(!validarString($nombre2)){
      $indErr = true;
      $msj.= '\n Hay carácteres inválidos en el segundo nombre';
     }
  }

  if($apellido1){
     if(!validarString($apellido1)){
      $indErr = true;
      $msj.= '\n Hay carácteres inválidos en el primer apellido';
     }
  }
  elseif(!$apellido1){
      $indErr = true;
      $msj.= '\n El primer apellido es obligatorio';
  }

  if($apellido2){
     if(!validarString($apellido2)){
      $indErr = true;
      $msj.= '\n Hay carácteres inválidos en el segundo apellido';
     }
  }

  if($cedula){
     if(!validarCedula($cedula)){
      $indErr = true;
      $msj.= '\n La cédula debe ser solo numérica';
     }
  }
  elseif(!$cedula){
      $indErr = true;
      $msj.= '\n La cédula es obligatoria';
  }

  if(!$estatus){
      $indErr = true;
      $msj.= '\n Debe indicar el status del registro';
  }
   if(!$status){
      $indErr = true;
      $msj.= '\n Debe indicar el estatus del del Usuario';
  }
   if(!$clave){
      $indErr = true;
      $msj.= '\n El campo clave es obligatorio';
  }

   if(!$idcargo){
      $indErr = true;
      $msj.= '\n Debe indicar el tipo de usuario';
  }
   if($indErr)f_alert("Reporte de validación:".$msj); // verifica si hay error con los datos



	else { $modificar=$objUsuario->modUsuario2($usuario,$cedula,$clave,$idcargo,$nivel,$nombre1,$nombre2,$apellido1,$apellido2,$estatus,$status,$banco,$dep,$concesionario,$correo);

		if ($modificar){
       		echo '<SCRIPT>alert("Usuario Modificado");</SCRIPT>';
          	echo "<SCRIPT>window.location.href='listado_usuarios.php';</SCRIPT>";
	 					}
		else
			echo '<SCRIPT>alert("Usuario No Modificado");</SCRIPT>';
		}
	}
//}

         	//echo "<SCRIPT>window.location.href='mod_usuario.php'id=".$_GET['id'].";&indReg=1;</SCRIPT>";
  /*    if ($_GET['codi'])
  	    $co=$_GET['codi'];
  	    else*/

  	   	$buscarUsu = $objUsuario->buscarUsuarioAdmin($id,'','','',-1,'','','','','');

?>


<!DOCTYPE HTML PUBLIC >
<html>
<head>
  <title>Modificar Usuarios</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 	 <link rel="stylesheet" type="text/css" href="../css/style.css">
     <link rel="stylesheet" href="../css/stilos.css" type="text/css">
     <link href="../css/classstyles.css" rel="stylesheet" type="text/css">
 	 <script type="text/javascript" src="../controlador/ajax.js"></script>
     <script type="text/javascript" src="../controlador/funciones.js"></script>
     <script type="text/javascript" src="../controlador/validar.js"></script>

     <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
   <SCRIPT language="JavaScript">
    function validar(){
      document.form1.reg.value = 1;
    }
    function limpiar(){
      document.form1.reg.value = 2;
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
<form action="" method="post" name="form1" >

    <table width="50%" height="147" align="center">
     <TR>
     <TD colspan="4" class="cabecera">Modificar Usuarios </TD>
    </TR>
   <TR>
      <TD class="categoria">Usuario:</TD>
    <TD class="dato"><INPUT type="text" name="usuario"  name="usuario" value="<?php echo $buscarUsu[0]; ?>" size="12" maxlength="50" readonly></td>

    <TD class="categoria">Cédula:&nbsp;</TD>
    <TD class="dato"><input type="text" name="cedula"  id="cedula" value="<?php echo $buscarUsu[5]; ?>" size="12"  maxlength="8" onkeypress="return acessoNumerico(event)" /></TD>
    </TR>
    <TR>
    <TD class="categoria">1er Nombre:</TD>
    <TD class="dato"><INPUT type="text" name="nombre1" id="nombre1" value="<?php echo $buscarUsu[1]; ?>" size="12" maxlength="50" onblur="javascript:this.value=this.value.toUpperCase()"></TD>

    <TD class="categoria">2do Nombre:</TD>
    <TD class="dato"><INPUT type="text" name="nombre2" id="nombre2" value="<?php echo $buscarUsu[2]; ?>" size="12"  onblur="javascript:this.value=this.value.toUpperCase()"></TD>
   </TR>
   <TR>
    <TD class="categoria">1er Apellido:</TD>
    <TD class="dato"><INPUT type="text" name="apellido1" id="apellido1" value="<?php echo $buscarUsu[3]; ?>" size="12" maxlength="50"onblur="javascript:this.value=this.value.toUpperCase()"></TD>

    <TD class="categoria">2do Apellido:</TD>
    <TD class="dato"><INPUT type="text" name="apellido2" id="apellido2" value="<?php echo $buscarUsu[4]; ?>" size="12" onblur="javascript:this.value=this.value.toUpperCase()"></TD>
   </TR>
   <TR>
    <TD class="categoria">Clave:</TD>
    <TD class="dato"><INPUT type="text" name="clave" id="clave" value="<?php echo $buscarUsu[17]; ?>" size="12"></TD>

       <TD class="categoria">  Tipo Usuario:      </TD>
    <TD class="dato"><select name="id_cargo" id="id_cargo">
    <OPTION  value="<?php  echo $buscarUsu[6]; ?>" ><?php echo $buscarUsu[+8]; ?></OPTION>
			    	<?php 	$tipoUsuario = $objUsuario->retTipo();for($i=0;$i<count($tipoUsuario);$i+=3){  ?>
	            <option value="<?php echo $tipoUsuario[$i]; ?>"><?php echo $tipoUsuario[$i+1]?></option>
	           		<?php } ?>
			  </SELECT>
    </TD>
   	</TR>
    <TR>
			    <TD class="categoria">Status de Usuario</TD>
			    <TD class="dato"><INPUT type="text" name="status" id="status" value="<?php echo $buscarUsu[14]; ?>" size="12" maxlength="20" onblur="javascript:this.value=this.value.toUpperCase()"></TD>
			    <TD class="categoria">Estatus Registro:</TD>
			    <TD class="dato"><INPUT type="text" name="estatus"  id="estatus" value="<?php echo $buscarUsu[15]; ?>" size="12" maxlength="1" onblur="javascript:this.value=this.value.toUpperCase()"></TD>
			   </TR>
    <TD class="categoria">Departamento</TD>
    <TD class="dato">
	           <SELECT id="dep" name="dep">
	       		<OPTION value="<?php echo $buscarUsu[10]; ?>" ><?php echo $buscarUsu[+12]; ?></OPTION>
			    <OPTION value="" </OPTION>
			    	<?php for($i=0;$i<count($listarDep);$i+=2){  ?>
	            <option value="<?php echo $listarDep[$i]; ?>"><?php echo $listarDep[$i+1]?></option>
	           		<?php } ?>
			  </SELECT>
		</TD>
   	<TD class="categoria">Banco</TD>
    <TD class="dato">
             <SELECT id="banco" name="banco">
				<OPTION  value="<?php  echo $buscarUsu[9]; ?>" ><?php echo $buscarUsu[+11]; ?></OPTION>
 				<OPTION value="" </OPTION>
			    <?php for($i=0;$i<count($listarBancos);$i+=5){  ?>
	            <option value="<?php echo $listarBancos[$i]; ?>"><?php echo $listarBancos[$i+1]?></option>
	            <?php } ?>
			 </SELECT>
	</TD>
    <TR>
      <TD class="categoria">Concesionario</TD>
         <TD class="dato">
	           <SELECT id="concesionario" name="concesionario">
				<OPTION  value="<?php echo  $buscarUsu[16]; ?>" ><?php echo $buscarUsu[+18]; ?></OPTION>
					<OPTION value="" </OPTION>
			    <?php for($i=0;$i<count($listarConcec);$i+=4){  ?>
	            <option value="<?php echo $listarConcec[$i]; ?>"><?php echo $listarConcec[$i+2]?></option>
	            <?php } ?>
			  </SELECT>
		</TD>
		 <TD class="categoria">Correo:</TD>
    	<TD class="dato"><INPUT type="text" name="correo" id="correo" value="<?php echo $buscarUsu[19]; ?>" size="12"></TD>
   </TR>
      <tr >
        <td colspan="6"><div align="center">
           <input type="button"  name="modificar" value="Modificar" onClick="link('mod_usuario.php?opr=1&id=<?=$buscarUsu[0]?>',document.form1); return false"><input type="button" value="Atras" onclick="window.location.href='listado_usuarios.php'" />
        </div></td>
      </tr>
    </table>
     <INPUT type="hidden" name="reg">
</form>
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