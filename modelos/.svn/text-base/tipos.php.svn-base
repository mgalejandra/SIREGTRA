<?php
class tipos extends conexion{
function buscarTipo($cod,$des){
  $sql = "select * FROM tipos ";

 	if (($cod) and ($des))
  	{
  		$sql.="WHERE codtip like UPPER('%$cod%') and destip like UPPER('%$des%') ";
  	}
  	else
  	{
  		if (($cod) and (!$des))
  		{
  			$sql.="WHERE codtip like UPPER('%$cod%') ";
  		}
  		else
  		if ((!$cod) and ($des))
  		{
  			$sql.="WHERE destip like UPPER('%$des%')  ";
  		}
  	}


  $sql.= " order by destip";

  //print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $destip= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $destip;
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