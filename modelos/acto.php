<?
class acto extends conexion{

 function buscarActo($fecha,$des,$offset=null){

   $sql = "select idacto,to_char(fecha,'dd/mm/yyyy') as fecha,desacto FROM acto ";

  	if (($fecha) or ($des))
  	{
		$sql.=" where";
		if ($fecha){
			$c=1;
			$sql.=" to_char(fecha,'dd/mm/yyyy') like '%$fecha%'";
		}

		if (($des))
		{
			if ($c==0){
			$sql.=" desacto like UPPER('%$des%')";
			}else{
			$sql.=" AND desacto like UPPER('%$des%')";
			}
		}
	}

  $sql.= "order by fecha";

  //$sql.=" limit 100 ";

  if($offset>=0) $sql.= " LIMIT 10 OFFSET $offset";

  //print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desacto= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desacto;
 }

  function buscarActoID($cod){

  $sql = "select idacto,to_char(fecha,'dd/mm/yyyy') as fecha,desacto FROM acto";

  if ($cod)
  	$sql.=" where idacto=$cod";

  // print '<pre>'; print "ID ".$sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $deslot= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $deslot;
 }

function agregarActo($fecha,$des){
 	$conexion = $this->conectar();

	$sql = "select nextval('acto_idacto_seq') as num";
	$consulta = $this->consultar($conexion,$sql);
	$codacto= $this->ret_vector($consulta);

	if ($consulta)
	{
		$sql1 = "INSERT INTO acto (idacto,fecha,desacto) VALUES ('".$codacto[0]."','".$fecha."','".$des."')";
		//print $sql1;
		$consulta1 = $this->consultar($conexion,$sql1);
	}

  $this->desconectar($conexion);

  if($consulta1) $this->auditar('INSERCION',$sql1,'http://localhost/refeciv1.1/vistas/cat_acto.php');

  return $consulta1;
}

function modificarActo($codi,$fec,$des){
	$sql = "UPDATE acto SET
		desacto='$des'," .
	  " fecha='$fec'" .
	  " where idacto=$codi";

   // print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);

    if($consulta) $this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/cat_acto.php');


	return $consulta;
}


function eliminarActo($codigo){
   $sql="delete from acto where idacto=$codigo";

   //print $sql;
   $conexion = $this->conectar();
   $consulta = $this->consultar($conexion,$sql);
   $this->desconectar($conexion);

   if($consulta) $this->auditar('ELIMINAR',$sql,'http://localhost/refeciv1.1/vistas/cat_acto.php');

   return $consulta;
}

}
?>