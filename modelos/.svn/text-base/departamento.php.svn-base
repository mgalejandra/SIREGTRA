<?php

class departamento extends conexion{

function agregarDpto($descdep){

    $conexion = $this->conectar();
    $fecha=date('d/m/Y');

    $sql = "INSERT INTO departamento ";
    $sql.= "( descdep)";
	$sql.= " VALUES ('".$descdep."')";

// print '<pre>'.$sql;

  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/cat_dep.php');
  return $consulta;
 }


 function modificarDpto($numdep,$descdep){
	$sql = "UPDATE departamento SET
	   descdep='".$descdep."'
	   where  numdep='$numdep'";


   //print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
	return $consulta;
}

 function listarDepartamento($numdep=null,$descdep=null){

 	$sql = "SELECT numdep, descdep FROM departamento ";


 	if($descdep) $sql.= " where  descdep like UPPER('%".$descdep."%') ";
 	   if($numdep) $sql.= " where  numdep='$numdep'";
 	$sql.= "ORDER BY 1";
 // print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

}
?>
