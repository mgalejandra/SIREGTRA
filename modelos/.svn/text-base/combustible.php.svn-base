<?php
class combustible extends conexion{

 function buscarTipoCombID($id){

  $sql = "select desmar from marcas where '".$id."' ";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desmar= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desmar[0];
 }

function buscarTipoComb($id,$nb){ //,$opc){
//$sql=pg_query($conexion,"SELECT * FROM combustible where codcon=cast(('$cod') as int ) and descon like '%$des%'  ");

  $sql = "select * FROM combustible ";

 /* if ($opc=='1')
  {*/
  	if (($id) and ($nb))
  	{
  		$sql.="WHERE codcon LIKE '%$id%' AND descon LIKE UPPER('%$nb%') ";
  	}
  	else
  	{
  		if (($id) and (!$nb))
  		{
  			$sql.="where codcon LIKE '%$id%' ";
  		}
  		else
  		if ((!$id) and ($nb))
  		{
  			$sql.="where descon LIKE UPPER('%$nb%')";
  		}
  	}
 // }

  $sql.= " order by descon";

  //print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $descon= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $descon;
 }
}
?>