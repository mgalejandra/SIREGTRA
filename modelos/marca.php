<?php
class marca extends conexion{

 function buscarMarca($id){

  $sql = "select * from marcas where codmar='".$id."' ";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desmar= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desmar;
 }

 function buscarMarca1($cod,$nom){

 	$sql = "select * FROM marcas ";

  	if (($cod) and ($nom))
  	{
  		$sql.="WHERE codmar LIKE UPPER('%$cod%') AND desmar LIKE UPPER('%$nom%') ";
  	}
  	else
  	{
  		if (($cod) and (!$nom))
  		{
  			$sql.="where codmar LIKE UPPER('%$cod%') ";
  		}
  		else
  		if ((!$cod) and ($nom))
  		{
  			$sql.="where desmar LIKE UPPER('%$nom%')";
  		}
  	}

  $sql.= " order by desmar";

  //print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desmar= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desmar;
 }

function modificarMarca($codi,$nb){
	$sql = "UPDATE marcas SET
		desmar='$nb' where codmar=trim('$codi')";

   //  echo $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
	return $consulta;
}

function eliminarMarca($codi){
   $sql="delete from marcas where codmar=trim('$codi')";
   //echo $sql;
   $conexion = $this->conectar();
   $consulta = $this->consultar($conexion,$sql);
   $this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
   return $consulta;
}

}
?>