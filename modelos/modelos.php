<?
class modelos extends conexion{

 function buscarModelo($cod,$des){ // ,$opc){

  $sql = "select * FROM modelo ";

  //if ($opc=='1')
  //{
  	if (($cod) and ($des))
  	{
  		$sql.="where codmod like UPPER('%$cod%') and desmod like UPPER('%$des%') ";
  	}
  	else
  	{
  		if (($cod) and (!$des))
  		{
  			$sql.="where codmod like UPPER('%$cod%') ";
  		}
  		else
  		if ((!$cod) and ($des))
  		{
  			$sql.="where desmod like UPPER('%$des%') ";
  		}
  	}
 // }
 // else

  $sql.= "order by desmod";

  // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desmod= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desmod;
 }

  function buscarModeloID($cod){
  $sql = "select * from modelo where codmod='$cod'";

  //print '<preID>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desmod= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desmod;
 }

/*
 $cod=$_POST['cod'];
  $des=$_POST['des'];
  $buscar=llavePk($conexion,"modelo","codmod",$cod);
  if ($buscar==0){
  $insertar = ejecutarSql($conexion,"INSERT INTO modelo VALUES ('".$cod."','".$des."')","MODELO");
  }else
     echo "EL CODIGO: ".$cod." , YA SE ENCUENTRA REGISTRADO";


  include('con_modelo.php');*/
 function agregarModelo($codi,$nb){

   $sql = "INSERT INTO modelo (codmod, desmod) VALUES
    		('".$codi."','".$nb."')";
   // echo $sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);
    $this->desconectar($conexion);

   /* if($consulta){
    	$this->auditar($_SESSION['loguse'],'INSERCION','REGISTRO ARTICULO: '.$id);
		//$this->notificacion($id,'INSERCION',$_SESSION['loguse'],"REGISTRADO");
    }*/
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
}
}
?>