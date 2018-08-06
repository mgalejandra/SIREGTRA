<?php

class estatus extends conexion {

function agregarEstatus($descripcion,$orden){

    $conexion = $this->conectar();
    $fecha=date('d/m/Y');

    $sql = "INSERT INTO estatus ";
    $sql.= "(descripcion,orden)";
	$sql.= " VALUES ('".$descripcion."','".$orden."')";

 //print '<pre>'.$sql;

  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/cat_estatus.php');
  return $consulta;
 }

 function regStatusFac($data){
    $sql1="select max((orden)+1) as maximo from estatus ";

    $conexion = $this->conectar();
	$consulta1 = $this->consultar($conexion,$sql1);
    $consulta1 = $this->ret_vector($consulta1);

  $sql = "INSERT INTO estatus(
  		    descripcion ,  orden ,
            status)
         values
           ('".$data[0]."','".$consulta1[0]."','".$data[2]."')";

 // print '<pre>'; print $sql;

  $conexion = $this->conectar();
     // print '<pre>'; print $conexion;
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listarStatus($id_estatus,$descripcion,$orden,$offset){

  $sql = "select id_estatus,descripcion, orden,status from estatus where status='A'";
     if($descripcion)  $sql=$sql." AND descripcion like '%".$descripcion."%'";
    if($orden)  $sql=$sql." AND orden='$orden'";
     if($id_estatus) $sql.= " and  id_estatus='$id_estatus'";
     if ($offset>=0) $sql = $sql." LIMIT 10 OFFSET  ".$offset;
 // print '<pre>'; print $sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function ContarStatus($descripcion,$orden){

  $sql = "select count (id_estatus) from estatus where status='A'";
   if($descripcion)  $sql=$sql." AND descripcion like '%".$descripcion."%'";
  	if($orden)  $sql=$sql." AND orden='$orden'";
 // print '<pre>'; print $sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }



 function modificarEstatus($id_estatus,$descripcion,$orden){
	$sql = "UPDATE estatus SET
	   descripcion='".$descripcion."',
	   orden='".$orden."'
	   where id_estatus='$id_estatus'";

  //  print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
	return $consulta;
}

 function listarEstatus($id_estatus,$descripcion=null,$orden=null){

 	$sql = "SELECT id_estatus, descripcion, orden  FROM estatus where status='A'  ";

 	if($descripcion) $sql.= "  AND descripcion like UPPER('%".$descripcion."%') ";
 	if($orden)  $sql.= " AND  orden='$orden' ";
 	if($id_estatus) $sql.= " and  id_estatus='$id_estatus'";


 	$sql.= "ORDER BY 1";

  //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

}
?>
