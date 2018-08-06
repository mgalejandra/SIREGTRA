<?php
class banco extends conexion{

function agregarBanco($nume,$nomb,$des){

    $conexion = $this->conectar();
    $fecha=date('d/m/Y');

    $sql = "INSERT INTO banco ";
    $sql.= "(id_banco, banco_descrip, nom_banco)";
	$sql.= " VALUES ('".$nume."','".$nomb."','".$des."')";

// print '<pre>'.$sql;

  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/cat_banco.php');
  return $consulta;
 }

 function modificarBanco($nume,$nomb,$des){
	$sql = "UPDATE banco SET
	   nom_banco='".$nomb."',
	   banco_descrip='".$des."'
	   where id_banco='$nume'";

   // print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
	return $consulta;
}

 function listarBancos($nume=null,$nomb=null,$des=null,$tipo=null){

 	$sql = "SELECT id_banco, nom_banco, banco_descrip, tipo, status FROM banco WHERE status = 'A'  ";

 	if($nume) $sql.= " and  id_banco like UPPER('%".$nume."%') ";
 	if($nomb) $sql.= " and  nom_banco like UPPER('%".$nomb."%') ";
 	if($des)  $sql.= " and  banco_descrip like UPPER('%".$des."%') ";
 	if($tipo)  $sql.= " and  tipo='1' ";

 	$sql.= "ORDER BY 2";

 // print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function listarBancos1($nume=null,$nomb=null,$des=null,$tipo=null){

 	$sql = "SELECT * FROM banco WHERE status = 'A'  ";

 	if($nume) $sql.= " and  id_banco like UPPER('%".$nume."%') ";
 	if($nomb) $sql.= " and  nom_banco like UPPER('%".$nomb."%') ";
 	if($des)  $sql.= " and  banco_descrip like UPPER('%".$des."%') ";
 	if($tipo)  $sql.= " and  tipo='1' ";

 	$sql.= "ORDER BY 2";

  //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


}
?>
