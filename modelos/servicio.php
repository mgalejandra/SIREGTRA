<?php
class servicio extends conexion{

/*
   if ($opc==1){
  $sql=pg_query($conexion,"SELECT * FROM servicios where codser like '%$cod%' and desser like '%$des%'  ");
  }else
  $sql=pg_query($conexion,"SELECT * FROM servicios order by oid desc");

    */
function buscarServicio($cod,$des){

   $sql = "select * FROM servicios ";

 	if (($cod) and ($des))
  	{
  		$sql.="WHERE codser like '%$cod%' and desser like UPPER('%$des%') ";
  	}
  	else
  	{
  		if (($cod) and (!$des))
  		{
  			$sql.="where codser like '%$cod%' ";
  		}
  		else
  		if ((!$cod) and ($des))
  		{
  			$sql.="where desser like UPPER('%$des%')";
  		}
  	}
  //}

  $sql.= " order by desser";

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