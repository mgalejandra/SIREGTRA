<?php
class clases extends conexion{

function buscarClase($cod,$des){
  $sql = "select * FROM clases ";

   	if (($cod) and ($des))
  	{
  		$sql.="WHERE codcla like UPPER('%$cod%') and descla like UPPER('%$des%') ";
  	}
  	else
  	{
  		if (($cod) and (!$des))
  		{
  			$sql.="WHERE codcla like UPPER('%$cod%') ";
  		}
  		else
  		if ((!$cod) and ($des))
  		{
  			$sql.="WHERE descla like UPPER('%$des%') ";
  		}
  	}


  $sql.= " order by descla";

  //print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $descon= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $descon;
 }


  function buscarServicioID($id){

  $sql = "select desmar from marcas where '".$id."' ";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desmar= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desmar[0];
 }

}
?>