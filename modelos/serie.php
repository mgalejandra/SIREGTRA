<?
class series extends conexion{

 function buscarSerie($cod,$des){
  $sql = "select * from serie ";

  	if (($cod) and ($des))
  	{
  		$sql.="where codserie like UPPER('%$cod%') and desserie like UPPER('%$des%') ";
  	}
  	else
  	{
  		if (($cod) and (!$des))
  		{
  			$sql.="where codserie like UPPER('%$cod%') ";
  		}
  		else
  		if ((!$cod) and ($des))
  		{
  			$sql.="where desserie like UPPER('%$des%') ";
  		}
  	}

$sql.= "order by desserie";

 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desmod= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desmod;
 }

  function buscarSerieID($cod){
  $sql = "select * from serie where codserie='$cod'";

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
 function agregarSerie($cod,$des){
  $sql = "INSERT INTO serie(codserie,desserie) VALUES ('".$cod."','".$des."')";

  print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  return $consulta;
}


function modificarSerie($codi,$nb){
	$sql = "UPDATE serie SET
	  desserie='$nb'" .
	  " where codserie=trim('$codi')";

    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
	return $consulta;
}

function eliminarSerie($codi){
   $sql="delete from serie where codserie=trim('$codi')";

   $conexion = $this->conectar();
   $consulta = $this->consultar($conexion,$sql);
   $this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
   return $consulta;
}

}
?>