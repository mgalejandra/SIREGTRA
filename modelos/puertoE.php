<?
class puertoE extends conexion{

 function buscarPuertoE($cod,$des){ // ,$opc){

  $sql = "select * FROM ptoadu ";

  //if ($opc=='1')
  //{
  	if (($cod) and ($des))
  	{
  		$sql.="where codpto like '%$cod%' and despto like '%$des%' ";
  	}
  	else
  	{
  		if (($cod) and (!$des))
  		{
  			$sql.="where codpto like '%$cod%' ";
  		}
  		else
  		if ((!$cod) and ($des))
  		{
  			$sql.="where despto like '%$des%' ";
  		}
  	}
 // }
 // else

  $sql.= "order by despto";

 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $despto= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $despto;
 }

 /* function buscarModeloID($cod){
  $sql = "select * from modelo where codmod='$cod'";

  //print '<preID>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desmod= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desmod;
 }

 function agregarModelo($codi,$nb){

   $sql = "INSERT INTO modelo (codmod, desmod) VALUES
    		('".$codi."','".$nb."')";
   // echo $sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);
    $this->desconectar($conexion);

   //if($consulta){
    //	$this->auditar($_SESSION['loguse'],'INSERCION','REGISTRO ARTICULO: '.$id);
		//$this->notificacion($id,'INSERCION',$_SESSION['loguse'],"REGISTRADO");
    }
    return($consulta);
}

function modificarModelo($codi,$nb){
	$sql = "UPDATE modelo SET
	  desmod='$nb'" .
	  " where codmod=trim('$codi')";

    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
	return $consulta;
}


function eliminarModelo($codi){
   $sql="delete from modelo where codmod=trim('$codi')";

   $conexion = $this->conectar();
   $consulta = $this->consultar($conexion,$sql);
   $this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
   return $consulta;
}*/
}
?>