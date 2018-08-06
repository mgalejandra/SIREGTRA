<?php
class usuario extends conexion{
var $idusuario="";
var $nombre1="";
var $nombre2="";
var $apellido1="";
var $apellido2="";
var $cedula="";
var $usuario="";
var $cargo="";
var $status="";

 function validarUsuario($usuario,$clave){
	$acceso = false;
	$conexion = $this->conectar();
	$sql = "SELECT clave FROM usuarios WHERE usuario = '$usuario'";
	$consulta = $this->consultar($conexion,$sql);
	$result = $this->ret_vector($consulta);
	return ($clave == $result[0]);
 }

 function buscarUsuario($usuario=null,$cedula=null,$tipo=null,$nivel=null,$offset=-1,$nombre=null,$estatus=null,$usuario2=null,$banco=null,$dep=null){

 	if($nivel==1)$nivel=null;

	$sql = "SELECT a.usuario,a.nombre1,a.nombre2,a.apellido1,a.apellido2,a.cedula,a.idcargo,a.status,d.destipu, a.id_banco, a.numdep,b.nom_banco, c.descdep, d.nivel, a.correo FROM usuarios a";
	$sql = $sql." left outer join banco b on a.id_banco=b.id_banco ";
	$sql = $sql." left outer join departamento c on a.numdep=c.numdep ";
	$sql = $sql." left outer join tipo_usuario d on a.idcargo=d.codtipu ";
	$sql = $sql." WHERE (a.estatus='A' or a.estatus='B') ";
	if ($usuario) $sql = $sql." and a.usuario='".$usuario."'";
	if ($usuario2) $sql = $sql." and a.usuario like '%".$usuario2."%'";
	if ($cedula) $sql = $sql." and a.cedula like '%".$cedula."%'";
	if ($nombre) $sql = $sql." and (a.nombre1 like '%".$nombre."%' or a.nombre2 like '%".$nombre."%' or a.apellido1 like '%".$nombre."%' or a.apellido2 like '%".$nombre."%')";
	if ($tipo) $sql = $sql." and  a.idCargo=".$tipo."";
    if ($nivel) $sql = $sql." and  d.nivel=".$nivel."";
    if ($banco) $sql = $sql." and  a.id_banco='".$banco."' ";
    if ($dep) $sql = $sql." and  a.numdep=".$dep."";
    if ($estatus) $sql = $sql." and  a.status='".$estatus."'";
    if($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;
	//print "Busca Usu: ".$sql;
	$conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $usuario;
  }

   function buscarUsuarioAdmin($usuario=null,$cedula=null,$tipo=null,$nivel=null,$offset=-1,$nombre=null,$estatus=null,$usuario2=null,$banco=null,$dep=null){

 	if($nivel==1)$nivel=null;

	$sql = "SELECT a.usuario,a.nombre1,a.nombre2,a.apellido1,a.apellido2,a.cedula,a.idcargo,a.status,d.destipu, a.id_banco, a.numdep,b.nom_banco, c.descdep, d.nivel,a.status,a.estatus,a.id_concesionario,a.clave,e.nomconc,a.correo FROM usuarios a";
	$sql = $sql." left outer join banco b on a.id_banco=b.id_banco ";
	$sql = $sql." left outer join departamento c on a.numdep=c.numdep ";
	$sql = $sql." left outer join tipo_usuario d on a.idcargo=d.codtipu ";
	$sql = $sql." left outer join concesionario e on a.id_concesionario=e.id_concesionario ";
	$sql = $sql." WHERE a.estatus='A' ";
	if ($usuario) $sql = $sql." and a.usuario='".$usuario."'";
	if ($usuario2) $sql = $sql." and a.usuario like '%".$usuario2."%'";
	if ($cedula) $sql = $sql." and a.cedula like '%".$cedula."%'";
	if ($nombre) $sql = $sql." and (a.nombre1 like '%".$nombre."%' or a.nombre2 like '%".$nombre."%' or a.apellido1 like '%".$nombre."%' or a.apellido2 like '%".$nombre."%')";
	if ($tipo) $sql = $sql." and  a.idCargo=".$tipo."";
    if ($nivel) $sql = $sql." and  d.nivel=".$nivel."";
    if ($banco) $sql = $sql." and  a.id_banco='".$banco."' ";
    if ($dep) $sql = $sql." and  a.numdep=".$dep."";
    if ($estatus) $sql = $sql." and  a.status='".$estatus."'";
    if($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;
	//print "Busca Usu: ".$sql;
	$conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $usuario;
  }

   function contarUsuario($usuario=null,$cedula=null,$tipo=null,$nivel=null,$nombre=null,$estatus=null,$usuario2=null,$banco=null,$dep=null){

   	 	if($nivel==1)$nivel=null;

	$sql = "SELECT count(a.usuario) FROM usuarios a";
	$sql = $sql." left outer join banco b on a.id_banco=b.id_banco ";
	$sql = $sql." left outer join departamento c on a.numdep=c.numdep ";
	$sql = $sql." left outer join tipo_usuario d on a.idcargo=d.codtipu ";
	$sql = $sql." WHERE a.estatus='A' ";
	if ($usuario) $sql = $sql." and a.usuario like '%".$usuario."%'";
    if ($usuario2) $sql = $sql." and a.usuario like '%".$usuario2."%'";
	if ($cedula) $sql = $sql." and a.cedula like '%".$cedula."%'";
	if ($tipo) $sql = $sql." and  a.idCargo=".$tipo."";
    if ($nivel) $sql = $sql." and  d.nivel=".$nivel."";
    if ($banco) $sql = $sql." and  a.id_banco='".$banco."' ";
    if ($dep) $sql = $sql." and  a.numdep=".$dep."";
    if ($estatus) $sql = $sql." and  a.status='".$estatus."'";
	//print "cuenta usu: ".$sql;
	$conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $usuario[0];
  }

//permite registrar un nuevo usuario
 function regUsuario($data,$url,$tipoUsuario){

  	//Administrador de Banco
  if ($tipoUsuario=='8') {
  	$data[6]=$_SESSION['idBanco'];
  	$data[7]=null;
  }

  $data[8] = $this->generarUsuario($data[0],$data[2]);
  $conexion = $this->conectar();
  $sql = "INSERT INTO usuarios(nombre1,nombre2,apellido1,apellido2,cedula,idCargo,usuario,clave,status,id_banco,numdep,id_concesionario,correo)
          values('".strtoupper($data[0])."','".strtoupper($data[1])."','".strtoupper($data[2])."','".strtoupper($data[3])."','".$data[4]."','".$data[5]."',
          '".$data[8]."','".md5($data[4])."','PENDIENTE','".$data[6]."' ";
  if ($data[7]) $sql.=" ,".$data[7]."  ";  else   $sql.=" , null  ";
  if ($data[9]) $sql.=" ,".$data[9].",'".$data[10]."')  ";  else   $sql.=" , null, '".$data[10]."')  ";

  print  $sql;
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,$url);
  return $consulta;
 }

 function modUsuario($data,$usuario){
  $sql = "UPDATE usuarios SET
	   nombre1 = '".$data[0]."',
	   nombre2 = '".$data[1]."',
	   apellido1 = '".$data[2]."',
	   apellido2 = '".$data[3]."',
	   cedula = '".$data[4]."',
	   idCargo = '".$data[5]."',
	   id_concesionario = '".$data[9]."',
	   status = 'ACTIVO'
          WHERE usuario = '".$usuario."'";
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
   if($consulta)
   $this->auditar($_SESSION['idDpto'],$_SESSION['usuario'],$_SESSION['fechupdatea'],'MODIFICACION','Modifica usuario: '.$usuario);
  return $consulta;
 }

 function modUsuario2($usuario,$cedula,$clave,$idcargo,$nivel,$nombre1,$nombre2,$apellido1,$apellido2,$estatus,$status,$banco,$dep,$concesionario,$correo){



  $sql = "UPDATE usuarios SET
	   	 nombre1 = '".$nombre1."',
	  	 nombre2 = '".$nombre2."',
	  	 apellido1 = '".$apellido1."',
	  	 apellido2 = '".$apellido2."',
	  	 cedula = '".$cedula."',
	  	 idCargo = '".$idcargo."',
	  	 estatus = '".$estatus."',
	  	 clave = '".$clave."',
	  	 status = '".$status."', correo ='".$correo."' ";
	   	 if ($banco=='' or $banco==null  ) $sql.=", id_banco=null"; else $sql.=", id_banco='".$banco. "'";
	  if ($dep=='' or $dep==null  ) $sql.=", numdep=null"; else $sql.=", numdep='".$dep. "'";
	if ($concesionario=='' or $concesionario==null  ) $sql.=", id_concesionario=null"; else $sql.=", id_concesionario='".$concesionario. "'";
        $sql.=" WHERE usuario = '".$usuario."'";
         print $sql;


  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
   if($consulta)
   $this->auditar($_SESSION['idDpto'],$_SESSION['usuario'],$_SESSION['fecha'],'MODIFICACION','Modifica usuario: '.$usuario);
  return $consulta;
 }

 function eliminaUsuario($usuario,$url){
  $conexion = $this->conectar();
  $sql = "DELETE FROM usuarios WHERE usuario ='".$usuario."'";
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('ELIMINACION',$sql,$url);
  return $consulta;
 }

 function cambiarClave($usuario,$cedula){
  $sql = "UPDATE usuarios SET clave = '".md5($cedula)."', status = 'PENDIENTE' WHERE usuario = '".$usuario."'";
  //print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
   if($consulta)
   $this->auditar($_SESSION['idDpto'],$_SESSION['usuario'],$_SESSION['fecha'],'MODIFICACION','Cambia calve al usuario: '.$usuario);
  return $consulta;
 }

  function cambiarClave2($usuario){
  	$sql = "SELECT cedula,status FROM usuarios WHERE usuario = '".$usuario."'";
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	if($consulta)$dato = $this->ret_vector($consulta);
	if($dato[1] == 'BLOQUEADO')$status = 'BLOQUEADO';
	else $status = 'PENDIENTE';
  	$sql = "UPDATE usuarios SET clave = '".md5($dato[0])."', status = '".$status."' WHERE usuario = '".$usuario."'";
  	$conexion = $this->conectar();
  	$consulta = $this->consultar($conexion,$sql);
  	$this->desconectar($conexion);
    if($consulta)$this->auditar($_SESSION['loguse'],'CAMBIO CLAVE','Cambio la clave del usuario '.$usuario);
  	return $consulta;
 }

 function modCalve($usuario,$clave,$url){
  $sql = "UPDATE usuarios SET clave = '".md5($clave)."', status = 'ACTIVO' WHERE usuario = '".$usuario."'";
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
   $this->auditar('MODIFICACION',$sql,$url);
  return $consulta;
 }

 function generarUsuario($nombre,$apellido){
     $j=1;
     $ind = false;
     $vocales1 = array('á','é','í','ó','ú','Á','É','Í','Ó','Ú');
     $vocales2 = array('a','e','i','o','u','A','E','I','O','U');
     $nombre = str_ireplace($vocales1,$vocales2,$nombre);
     $apellido = str_ireplace($vocales1,$vocales2,$apellido);
     $nombre = str_replace(' ', '', $nombre);
     $apellido = str_replace(' ', '', $apellido);
     $nombre = strtolower($nombre);
     $apellido = strtolower($apellido);

     while(!$ind){
            $usuario = substr($nombre,0,$j).$apellido;
            $res = $this->buscarUsuario($usuario);
            if($res){
               if($j == strlen($nombre)){
                  $aux = $apellido;
                  $apellido = $nombre;
                  $nombre = $aux;
                  $j=1;
               }
               else $j++;
            }
            else{
               $ind = true;
            }
     }

     //print "Usuario generado: ".$usuario;
     return $usuario;
 }

 function retTipo($nivel=null){
    $conexion = $this->conectar();
	$sql = "SELECT codtipu,destipu,nivel FROM tipo_usuario ";
    if($nivel) $sql.= "where nivel='".$nivel."' ";
    $sql.= "  order by codtipu";
	$consulta = $this->consultar($conexion,$sql);
	$tipo = $this->ret_vector($consulta);

   return $tipo;
 }

 function verificaError($usuario){
	$conexion = $this->conectar();
	$sql = "SELECT count(usuario) FROM auditoria WHERE usuario = '".$usuario."' AND fecha like '%".date("d/m/Y")."%' AND accion = 'FALLALOG'";
	//print $sql;
	$consulta = $this->consultar($conexion,$sql);
	$res=$this->ret_vector($consulta);
    return $res[0];
}

 function bloquearUsuario($id){
 	$sql = "UPDATE usuarios SET status ='BLOQUEADO', estatus='B' WHERE usuario = '".$id."'";
  	$conexion = $this->conectar();
  	$consulta = $this->consultar($conexion,$sql);
  	$this->desconectar($conexion);
    if($consulta)$this->auditar('sysadmin','MODIFICACION','Bloqueo a usuario '.$id);
  	return $consulta;
 }

  function activarUsuario($id){
 	$sql = "UPDATE usuarios SET status ='ACTIVO', estatus='A' WHERE usuario = '".$id."'";
  	$conexion = $this->conectar();
  	$consulta = $this->consultar($conexion,$sql);
  	$this->desconectar($conexion);
    if($consulta)$this->auditar($_SESSION['loguse'],'MODIFICACION','Activo a usuario '.$id);
  	return $consulta;
 }

  function logUsuario($valor){
 	$fecha=date('d/m/Y');
 	$sql="SELECT COUNT(*) FROM auditoria WHERE usuario='".$valor."' and fecha like '%".$fecha."%' and accion='FALLALOG'";
 	$conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$dato = $this->ret_vector($consulta);
	if ($dato[0]>=3){
	$sql="UPDATE auditoria SET accion ='FALLALOG_D' WHERE usuario='".$valor."' and fecha like '%".$fecha."%'";
  	$conexion = $this->conectar();
  	$consulta = $this->consultar($conexion,$sql);
  	$this->desconectar($conexion);
  	return $consulta;
  	 }
 }


//FUNCIONES PARA REINICIAR CLAVE BENEFICIARIO PRESIRECOV

 function clave($usuario,$clave){
	$conexion = $this->conectar2();
	$sql = "UPDATE repususol
   			SET clave='".md5($clave)."', status='PENDIENTE'
 			WHERE usuario='".$usuario."' ";

	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
    return $consulta;
 }


function buscarUsuarioP($usuario){
	$sql = "SELECT a.usuario,b.prinompro,b.priapepro,b.codpro,a.nivel,a.status,b.correo
	FROM repususol a, repbenefsol b WHERE a.codpro=b.codpro and a.usuario = '".$usuario."'";
    //print $sql;
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
	$dato = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $dato;
}

function correoClave($usuario,$password,$correo){
		   //envio de correo
		   $asunto = "Reinicio de Contraseña - Programa Comersso Auto ejecutado por SUVINCA";
		   $cuerpo = '<html><head>
			<title>Reinicio de Contraseña</title>
			</head>
			<body>
			<table border="0" align="center">
			<tr>
			<td colspan="2">Su contraseña ha sido cambiada satisfactoriamente. Puede ingresar al sistema haciendo uso de:</td>
			</tr>
			<tr>
			<td><strong>Usuario:</strong></td>
			<td align="left">'.$usuario.'</td>
			</tr>
			<tr>
			<td><strong>Clave Nueva:</strong></td>
			<td align="left">'.$password.' </td>
			</tr>
			</table>
			</body>
			</html>';

			//para el envío en formato HTML
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

			//dirección del remitente
			$headers .= "From: no_reply@suvinca.gob.ve\r\n";

			mail($correo,$asunto,$cuerpo,$headers);

}

 function modCorreoBen($correo,$usuario){
	$conexion = $this->conectar2();

 	$sql = "update repbenefsol a set correo='".$correo."'
    FROM  repususol b WHERE a.codpro = b.codpro and b.usuario='".$usuario."' ";

   // print 'Mod correo: '.$sql;
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
    return $consulta;
 }


 function regtipUsu($destipu,$nivel){


	//$conexion = $this->conectar();
 $sql0= "select max((codtipu)+1) from tipo_usuario ";
   //print '<pre>'; print $sql0;
    $conexion = $this->conectar();
	$consulta0 = $this->consultar($conexion,$sql0);
    $consulta0 = $this->ret_vector($consulta0);


 	$sql = "INSERT  into tipo_usuario(codtipu,destipu,nivel) values ('".$consulta0[0]."','".$destipu."','".$nivel."' )" ;

  //  print 'reg tipu: '.$sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
	if($consulta)$this->auditar('INSERCION','Inserto tipo de usuario  :'.$sql,'http://localhost/refeciv1.1/vistas/reg_tipUsu.php');
    return $consulta;
 }


function buscartipUsu($codtipu,$destipu,$nivel,$offset=-1){
	$sql = "SELECT  a.codtipu , a.destipu , a.nivel, b.descdep from tipo_usuario a, departamento b where a.nivel=b.numdep";
	if ($codtipu ) $sql = $sql." and  a.codtipu='$codtipu'";
		if ($destipu ) $sql = $sql." and  a.destipu like '%".$destipu."%'";;
	if ($nivel ) $sql = $sql." and  a.nivel='$nivel'";
	 if($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;
   // print $sql;
     $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$consulta = $this->ret_vector($consulta);
	$this->desconectar($conexion);;
	return $consulta;
}


function contartipUsu($codtipu,$destipu,$nivel){
	$sql = "SELECT count (a.codtipu) from tipo_usuario a, departamento b where a.nivel=b.numdep";
	if ($codtipu ) $sql = $sql." and  a.codtipu='$codtipu'";
	if ($destipu ) $sql = $sql." and  a.destipu like '%".$destipu."%'";
	if ($nivel ) $sql = $sql." and  a.nivel='$nivel'";
 //   print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);

	return $usuario[0];
  }


   function modificarTipUsu($codtipu,$descripcion,$nivel){
	$sql = "UPDATE tipo_usuario SET
	   destipu='".$descripcion."',
	   nivel='".$nivel."'
	   where codtipu='$codtipu'";
     // print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);

	    if($consulta)$this->auditar('MODIFICAR','Modificó tipo de usuario  :'.$sql,'http://localhost/refeciv1.1/vistas/modtipUsu.php');
    //if($consulta)$this->auditar($_SESSION['loguse'],'MODICACION DE MAESTRO tipo_usuario ','SENTENCIA: '.$sql);
	return $consulta;
}

}
?>