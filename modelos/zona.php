<?php
class zona extends conexion{

 function listarEstados($codest=null){
    $conexion = $this->conectar();
	$sql = "select codest, nomest from zona_estado  ";
	if ($codest) $sql.= " where codest='".$codest."'";
	$sql.= " order by nomest ";
  //  print 'auqi'.$sql;
	$consulta = $this->consultar($conexion,$sql);
    $estados = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $estados;
 }
  function buscarEstados($id){
    $conexion = $this->conectar();

	$sql = "select codest, nomest from zona_estado where codest = '".$id."' ";
      //print $sql;
	$consulta = $this->consultar($conexion,$sql);
    $estados = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $estados;
 }

  function listarMunicipios($id){
    $conexion = $this->conectar();

	$sql = "select codmun,nommun from zona_municipio where codest= '".$id."' order by nommun";
     // print $sql;
	$consulta = $this->consultar($conexion,$sql);
    $Municipios = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $Municipios;
 }


  function buscarMunicipios($id,$ide){
    $conexion = $this->conectar();
	$sql = "select codmun,nommun from zona_municipio where codmun = '".$id."' and codest= '".$ide."'";
      //print $sql;
	$consulta = $this->consultar($conexion,$sql);
    $Municipios = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $Municipios;
 }

  function listarParroquias($ide,$idm){
    $conexion = $this->conectar();

	$sql = "select codpar,nompar from zona_parroquia where codest = '".$ide."' and codmun= '".$idm."' order by nompar";
      //print $sql;
	$consulta = $this->consultar($conexion,$sql);
    $Parroquias = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $Parroquias;
 }


  function buscarParroquias($id,$ide,$idm){
    $conexion = $this->conectar();

	$sql = "select codpar,nompar from zona_parroquia  where codpar = '".$id."' and codest = '".$ide."' and codmun= '".$idm."'  ";
      //print $sql;
	$consulta = $this->consultar($conexion,$sql);
    $Parroquias = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $Parroquias;
 }


}?>
