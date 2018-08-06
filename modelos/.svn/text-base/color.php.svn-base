<?
class color extends conexion{

 function buscarColor($cod,$des){
  $sql = "select * FROM color ";

  	if (($cod) and ($des))
  	{
  		$sql.="where codcol like UPPER('%$cod%') and descol like UPPER('%$des%') ";
  	}
  	else
  	{
  		if (($cod) and (!$des))
  		{
  			$sql.="where codcol like UPPER('%$cod%') ";
  		}
  		else
  		if ((!$cod) and ($des))
  		{
  			$sql.="where descol like UPPER('%$des%') ";
  		}
  	}

  $sql.= " order by descol";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $descol= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $descol;
 }

  function buscarColorID($cod){
  $sql = "select * from color where codcol='$cod'";

  //
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
 function agregarColor($codi,$nb){

   $sql = "INSERT INTO color (codcol, descol) VALUES
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

function modificarColor($codi,$nb){
	$sql = "UPDATE color SET
	  descol='$nb'" .
	  " where codcol='$codi'";

	//print '<preID>'; print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
	return $consulta;
}


function eliminarColor($codi){
   $sql="delete from color where codcol=trim('$codi')";

  // print $sql;
   $conexion = $this->conectar();
   $consulta = $this->consultar($conexion,$sql);
   $this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
   return $consulta;
}
}
?>