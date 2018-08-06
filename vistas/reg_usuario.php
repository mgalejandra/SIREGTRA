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
$permitidos = array(2);
validaAcceso($permitidos,$dir);
$objUsuario = new usuario();
$objBanco   = new banco();
$objDep = new departamento();
$objConcesionario = new concesionario();
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<?php
// recibe los datos del formulario

$reg = $_POST['reg'];
$data[0]=$_POST['nombre1'];
$data[1]=$_POST['nombre2'];
$data[2]=$_POST['apellido1'];
$data[3]=$_POST['apellido2'];
$data[4]=$_POST['cedula'];
$data[5]=$_POST['cargo'];
$data[6]=$_POST['banco'];
$data[7]=$_POST['dep'];
$data[9]=$_POST['concesionario'];
$data[10]=$_POST['correo'];

$msj = null;
$indErr = false;

if($reg == 1){
  if($data[0]){
     if(!validarString($data[0])){
      $indErr = true;
      $msj.= '\n Hay carácteres inválidos en el primer nombre';
     }
  }
  elseif(!$data[0]){
      $indErr = true;
      $msj.= '\n El primer nombre es obligatorio';
  }

  if($data[1]){
     if(!validarString($data[1])){
      $indErr = true;
      $msj.= '\n Hay carácteres inválidos en el segundo nombre';
     }
  }

  if($data[2]){
     if(!validarString($data[2])){
      $indErr = true;
      $msj.= '\n Hay carácteres inválidos en el primer apellido';
     }
  }
  elseif(!$data[2]){
      $indErr = true;
      $msj.= '\n El primer apellido es obligatorio';
  }

  if($data[3]){
     if(!validarString($data[3])){
      $indErr = true;
      $msj.= '\n Hay carácteres inválidos en el segundo apellido';
     }
  }

  if($data[4]){
     if(!validarCedula($data[4])){
      $indErr = true;
      $msj.= '\n La cédula debe ser solo numérica';
     }
  }
  elseif(!$data[4]){
      $indErr = true;
      $msj.= '\n La cédula es obligatoria';
  }

  if(!$data[5]){
      $indErr = true;
      $msj.= '\n Debe indicar el tipo de usuario';
  }

    if(($data[5]=='8' or $data[5]=='9' or $data[5]=='10') and !$data[6]){
      $indErr = true;
      $msj.= '\n Debe seleccionar el banco';
  }

    if(($data[5]=='1' or $data[5]=='2' or $data[5]=='3' or $data[5]=='4' or $data[5]=='5' or $data[5]=='6' or $data[5]=='7') and !$data[7]){
    	if($data[5]==1 and $data[7]!=5){
    	$indErr = true;
        $msj.= '\n Debe seleccionar el Departamento SUVINCA';
    	}elseif($data[5]==6 and $data[7]!=3){
    	$indErr = true;
        $msj.= '\n Debe seleccionar el Departamento PRESIDENCIA';
    	}elseif($data[5]==7 and $data[7]!=4){
    	$indErr = true;
        $msj.= '\n Debe seleccionar el Departamento MINISTERIO';
    	}else{
    	$indErr = true;
        $msj.= '\n Debe seleccionar el Departamento';
    	}

  }

 if($indErr)f_alert("Reporte de validación:".$msj); // verifica si hay error con los datos
 else{
    $resUsuario = $objUsuario->buscarUsuario('',$data[4],'');//busca usuario por la cedula
   if(count($resUsuario)>1){ // si consigue usuario envia mensaje de error
      echo '<SCRIPT>alert("Este usuario ya se encuentra registrado")</SCRIPT>';
      echo "<SCRIPT>window.location.href='listado_usuarios.php?ci=$data[4]';</SCRIPT>";
   }
   else {// si no consigue usuario registra nuevo
      $regUsuario = $objUsuario->regUsuario($data,$uri,$_SESSION['tipoUsuario']);
      if($regUsuario){
      	echo '<SCRIPT>alert("Usuario Registrado con exito")</SCRIPT>';
      	echo "<SCRIPT>window.location.href='listado_usuarios.php?ci=$data[4]';</SCRIPT>";
      }
      else echo '<SCRIPT>alert("Error al registrar usuario");</SCRIPT>';
  }
 }
} // Final de condicional ($reg == 1)

if($reg == 2){
 $data = NULL;
}
	$listarBancos=$objBanco->listarBancos('','','',1);
	$listarDep=$objDep->listarDepartamento();
	$listarConcec=$objConcesionario->listarConcesionario();
?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
  <script type="text/javascript" src="../controlador/funciones.js"></script>
  <script type="text/javascript" src="../controlador/calendario.js"></script>
   <SCRIPT language="JavaScript">
    function validar(){
      document.registro.reg.value = 1;
    }
    function limpiar(){
      document.registro.reg.value = 2;
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
  <FORM method="POST" action="" name="registro">
  <TABLE  class="formulario">
   <TR>
     <TD colspan="4" class="cabecera">Crear Usuarios </TD>
    </TR>
   <TR>
    <TD class="categoria">1er Nombre:</TD>
    <TD class="dato"><INPUT type="text" name="nombre1" value="<?php echo $data[0]; ?>" size="12" maxlength="50"></TD>
    <TD class="categoria">2do Nombre:</TD>
    <TD class="dato"><INPUT type="text" name="nombre2" value="<?php echo $data[1]; ?>" size="12"></TD>
   </TR>
   <TR>
    <TD class="categoria">1er Apellido:</TD>
    <TD class="dato"><INPUT type="text" name="apellido1" value="<?php echo $data[2]; ?>" size="12"></TD>
    <TD class="categoria">2do Apellido:</TD>
    <TD class="dato"><INPUT type="text" name="apellido2" value="<?php echo $data[3]; ?>" size="12"></TD>
   </TR>
   <TR>
    <TD class="categoria">Cédula:&nbsp;</TD>
    <TD class="dato"><input type="text" name="cedula" value="<?php echo $data[4]; ?>" size="12"  maxlength="8" onkeypress="return acessoNumerico(event)" /></TD>
    <TD class="categoria">  Tipo Usuario:      </TD>
    <TD class="dato"><select name="cargo" >
      <?php
        $tipoUsuario = $objUsuario->retTipo();
        for($i=0;$i<count($tipoUsuario);$i+=3){
          if($data[5] == $i)echo '<option value="'.$tipoUsuario[$i].'" selected="true">'.$tipoUsuario[$i+1].'</option>';
          else echo '<option value="'.$tipoUsuario[$i].'">'.$tipoUsuario[$i+1].'</option>';
        }
     ?>
    </select></TD>
   </TR>
    <TR>
        <TD class="categoria">Departamento</TD>
    <TD class="dato">
	           <SELECT id="dep" name="dep">
				<?php if($ban==1)  echo " <option value=".$listarFactura[$i+13].">".$listarFactura[$i+16]."</option>"; else {?>
					<OPTION value=""></OPTION>
			    <?php } for($i=0;$i<count($listarDep);$i+=2){  ?>
	               <option value="<?php echo $listarDep[$i]; ?>"><?php echo $listarDep[$i+1]?></option>
	           <?php } ?>
			 </SELECT>
	</TD>
    <TD class="categoria">Banco</TD>
    <TD class="dato">

             <SELECT id="banco" name="banco">
				<?php if($ban==1)  echo " <option value=".$listarFactura[$i+13].">".$listarFactura[$i+16]."</option>"; else {?>
					<OPTION value=""></OPTION>
			    <?php } for($i=0;$i<count($listarBancos);$i+=5){  ?>
	               <option value="<?php echo $listarBancos[$i]; ?>"><?php echo $listarBancos[$i+1]?></option>
	           <?php } ?>
			 </SELECT>
	</TD>
   </TR>
       <TR>
        <TD class="categoria">Concesionario</TD>
    <TD class="dato">
	           <SELECT id="concesionario" name="concesionario">
				<?php if($ban==1)  echo " <option value=".$listarFactura[$i+13].">".$listarFactura[$i+16]."</option>"; else {?>
					<OPTION value=""></OPTION>
			    <?php } for($i=0;$i<count($listarConcec);$i+=6){  ?>
	               <option value="<?php echo $listarConcec[$i]; ?>"><?php echo $listarConcec[$i+2]?></option>
	           <?php } ?>
			 </SELECT>
	</TD>
	<TD class="categoria">Correo:</TD>
    <TD class="dato"><INPUT type="text" name="correo" value="<?php echo $data[14]; ?>" size="12"></TD>
   </TR>
   <TR>
     <TD colspan="4" align="center" class="TitNot"><input name="submit2" type="submit" onclick="limpiar()" value="Limpiar" />
      <input name="submit" type="submit" onclick="validar()" value="Enviar" /></TD>
    </TR>
  </TABLE>
  <br/>
  <INPUT type="hidden" name="reg">
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