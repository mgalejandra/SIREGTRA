<?php
class usos extends conexion{
function buscarUso($cod,$des){
  $sql = "select * FROM uso ";


  	if (($cod) and ($des))
  	{
  		$sql.="WHERE coduso like UPPER('%$cod%') and desuso like UPPER('%$des%') ";
  	}
  	else
  	{
  		if (($cod) and (!$des))
  		{
  			$sql.="WHERE coduso like UPPER('%$cod%') ";
  		}
  		else
  		if ((!$cod) and ($des))
  		{
  			$sql.="WHERE desuso like UPPER('%$des%') ";
  		}
  	}

  $sql.= " order by desuso";

  //print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $descon= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $descon;
 }


 /* function buscarServicioID($id){

  $sql = "select desmar from marcas where '".$id."' ";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desmar= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desmar[0];
 }*/

}
?>