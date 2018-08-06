<?
class departamentos extends conexion{

 function listarDpto(){
  $sql = "select * FROM departamento ";

  $sql.= "order by descdep";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desdep= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desdep;
 }

function buscarDptoID($cod){
  $sql = "select * FROM departamento where numdep=$cod";

  //print '<preID>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desdep= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desdep;
 }

 /* function agregarLote($fecha,$nombre){
 	$conexion = $this->conectar();

	$sql = "select nextval('lote_sec') as num";
	$consulta = $this->consultar($conexion,$sql);
	$codlot= $this->ret_vector($consulta);

	if ($consulta)
	{
		$sql1 = "INSERT INTO lote (numlot,feclot,deslot) VALUES ('".$codlot[0]."','".$fecha."','".$nombre."')";
		//print $sql1;
		$consulta1 = $this->consultar($conexion,$sql1);
	}

  $this->desconectar($conexion);
  return $consulta1;
}

function modificarLote($codi,$fec,$nb){
	$sql = "UPDATE lote SET
		deslot='$nb'," .
	  " feclot='$fec'" .
	  " where numlot=$codi";

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
*/
}
?>