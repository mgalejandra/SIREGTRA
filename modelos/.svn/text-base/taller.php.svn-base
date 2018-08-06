<?
class taller extends conexion{

 function buscarTaller($nombre,$rif,$direccion,$contacto,$telf){
   $c=0;
   $sql = "select numtaller,nombre,direccion,telefono,rif,contacto FROM taller ";

  	if (($nombre) or ($rif) or ($direccion) or ($contacto) or ($telf))
  	{
		$sql.=" where";

		if ($nombre)
		{
			if ($c==0){
				$sql.=" nombre like UPPER('%$nombre%')";
				$c=1;
			}else{
			$sql.=" AND nombre like UPPER('%$nombre%')";
			}
		}

	  	if ($rif)
		{
				if ($c==0){
				$sql.=" rif like UPPER('%$rif%')";
				$c=1;
			}else{
			$sql.=" AND rif like UPPER('%$rif%')";
			}
		}

		if ($direccion)
		{
			if ($c==0){
				$sql.=" direccion like UPPER('%$direccion%')";
				$c=1;
			}else{
			$sql.=" AND direccion like UPPER('%$direccion%')";
			}
		}

		if ($contacto)
		{
			if ($c==0){
				$sql.=" contacto like UPPER('%$contacto%')";
				$c=1;
			}else{
			$sql.=" AND contacto like UPPER('%$contacto%')";
			}
		}

		if ($telf)
		{
			if ($c==0){
				$sql.=" telefono like '%$telf%'";
				$c=1;
			}else{
			$sql.=" AND telefono like '%$telf%'";
			}
		}
	}

  $sql.= "order by nombre";

  $sql.=" limit 100 ";

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $deslot= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $deslot;
 }

  function buscarTallerID($cod){
  $sql = "select * FROM taller ";

  if ($cod)
   $sql.=" where numtaller=$cod";

  //print '<preID>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $deslot= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $deslot;
 }

function agregarTaller($nombre,$rif,$dir,$contacto,$telf){
 	$conexion = $this->conectar();

	$sql = "select nextval('taller_numtaller_seq') as num";
	$consulta = $this->consultar($conexion,$sql);
	$codlot= $this->ret_vector($consulta);

	if ($consulta)
	{
		$sql1 = "INSERT INTO taller (nombre,direccion,telefono,rif,contacto) VALUES ('".$nombre."','".$dir."','".$telf."','".$rif."','".$contacto."')";
		//print "Insertar: ".$sql1;
		$consulta1 = $this->consultar($conexion,$sql1);
	}

  $this->desconectar($conexion);
  return $consulta1;
}

function modificarTaller($nombre,$rif,$dir,$contacto,$telf,$codi){
	$sql = "UPDATE taller SET
		nombre='$nombre'," .
	  " direccion='$dir'," .
	  " telefono='$telf'," .
	  " rif='$rif'," .
	  " contacto='$contacto'" .
	  " where numtaller=$codi";

    //print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
	return $consulta;
}


function eliminarTaller($codigo){
   $sql="delete from taller where numtaller=$codigo";

   $conexion = $this->conectar();
   $consulta = $this->consultar($conexion,$sql);
   $this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
   return $consulta;
}

function buscarAsigVeh($serial){
  $sql = "select id_asignacion FROM asignacion ";

  if ($serial)
   $sql.=" where sercarveh='$serial'";

  //print '<preID>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desAsigVeh= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desAsigVeh;
 }

function buscarVehTallerID($serial){
   $conexion = $this->conectar();
 $sql = "select numtalveh,id_taller,to_char(fecha,'dd/mm/yyyy'),falla,to_char(fechae,'dd/mm/yyyy'),sercarveh  FROM vehic_taller ";

  if ($serial)
   $sql.=" where sercarveh='$serial'";

 // print '<pre>'; print "Vehic-taller: ".$sql;

  $consulta = $this->consultar($conexion,$sql);
  $desvt= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desvt;
}

function asignarVehTaller($datos){
 	$conexion = $this->conectar();

	$sql = "select nextval('vehic_taller_numtalveh_seq') as num";
	$consulta = $this->consultar($conexion,$sql);
	$codlot= $this->ret_vector($consulta);

	if ($consulta)
	{
		$sql1 = "INSERT INTO vehic_taller (id_taller,fecha,falla,fechae,sercarveh) VALUES ('".$datos[0]."','".$datos[1]."','".$datos[2]."'";

        if ($datos[3]) $sql1.= ",'".$datos[3]."'";
        else $sql1.= ",'01/01/1900'";

   		$sql1.= ",'".$datos[4]."')";
		//print "Insertar: ".$sql1;
		$consulta1 = $this->consultar($conexion,$sql1);
	}

  $this->desconectar($conexion);
  return $consulta1;
}

function modificarVehTaller($datos){
	$sql = "UPDATE vehic_taller SET
		id_taller='$datos[0]'," .
	  " fecha='$datos[1]'," .
	  " falla='$datos[2]'," .
	  " fechae='$datos[3]'" .
	  " where sercarveh='$datos[4]'";

    //print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
	return $consulta;
}

}
?>