<?
class lotes extends conexion{

 function buscarLote($fecha,$nombre,$dpto){

   $sql = "select numlot, to_char(feclot,'dd/mm/yyyy') as fecha,deslot,numdep FROM lote ";

  	if (($fecha) or ($nombre) or ($dpto))
  	{
		$sql.=" where";
		if ($fecha){
			$c=1;
			$sql.=" to_char(feclot,'dd/mm/yyyy') like '%$fecha%'";
		}

		if (($nombre))
		{
			if ($c==0){
			$sql.=" deslot like UPPER('%$nombre%')";
			}else{
			$sql.=" AND deslot like UPPER('%$nombre%')";
			}
		}

	  	if (($dpto))
		{
			if ($c==0){
			$sql.=" numdep=$dpto";
			}else{
			$sql.=" AND numdep=$dpto";
			}
		}
	}

  $sql.= "order by deslot";

  $sql.=" limit 100 ";

 // print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $deslot= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $deslot;
 }

  function buscarLoteID($cod){
  $sql = "select numlot, to_char(feclot,'dd/mm/yyyy') as fecha, deslot, numdep from lote where numlot=$cod";

  //print '<preID>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $deslot= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $deslot;
 }

function agregarLote($fecha,$nombre,$dpto){
 	$conexion = $this->conectar();

	$sql = "select nextval('lote_sec') as num";
	$consulta = $this->consultar($conexion,$sql);
	$codlot= $this->ret_vector($consulta);

	if ($consulta)
	{
		$sql1 = "INSERT INTO lote (numlot,feclot,deslot,numdep) VALUES ('".$codlot[0]."','".$fecha."','".$nombre."','".$dpto."')";
		//print $sql1;
		$consulta1 = $this->consultar($conexion,$sql1);
	}

  $this->desconectar($conexion);
  return $consulta1;
}

function modificarLote($codi,$fec,$nb,$dp){
	$sql = "UPDATE lote SET
		deslot='$nb'," .
	  " feclot='$fec'," .
	  " numdep='$dp'" .
	  " where numlot=$codi";

    print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
	return $consulta;
}


function eliminarLote($codigo){
   $sql="delete from lote where numlot=$codigo";

   $conexion = $this->conectar();
   $consulta = $this->consultar($conexion,$sql);
   $this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
   return $consulta;
}


function cantidadVehLote($lote){

	$sql="select sum(cantidad) from (select f.numlot,d.desmar as marca,e.desmod as modelo,count(b.sercarveh) as cantidad,e.codmod from" .
			" vehiculo b inner join caracteristica c on b.id_caract=c.id_caract inner join marcas d on c.codmarveh=d.codmar" .
			" inner join modelo e on c.codmod=e.codmod inner join lote f on c.numlotveh=f.numlot where f.numdep='1'";

			if ($lote) $sql.= "and f.numlot= '".$lote."'";

	$sql.= " group by f.numlot,d.desmar,e.desmod,e.codmod order by f.numlot,d.desmar,e.desmod) z group by z.numlot";

	//echo $sql;

   $conexion = $this->conectar();
   $consulta = $this->consultar($conexion,$sql);
   $consulta = $this->ret_vector($consulta);
   $this->desconectar($conexion);

  return $consulta;
}

function cantidadVehLotexMarca($lote=null,$marca=null){

	$sql="select sum(cantidad) from (select f.numlot,d.desmar as marca,e.desmod as modelo,count(b.sercarveh) as cantidad,e.codmod,d.codmar from" .
			" vehiculo b inner join caracteristica c on b.id_caract=c.id_caract inner join marcas d on c.codmarveh=d.codmar" .
			" inner join modelo e on c.codmod=e.codmod inner join lote f on c.numlotveh=f.numlot where f.numdep='1'";

			if ($lote) $sql.= " and f.numlot= '".$lote."'";
			if ($marca) $sql.= " and d.codmar= '".$marca."'";

	$sql.= " group by f.numlot,d.desmar,e.desmod,e.codmod,d.codmar order by f.numlot,d.desmar,e.desmod) z group by z.numlot";

   //echo $sql;

   $conexion = $this->conectar();
   $consulta = $this->consultar($conexion,$sql);
   $consulta = $this->ret_vector($consulta);
   $this->desconectar($conexion);

  return $consulta;
}

}
?>