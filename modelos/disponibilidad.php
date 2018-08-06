<?php
class disponibilidad extends conexion{

 function registrarFecha($data){
  $fecha=date('d/m/Y');
  $sql = "INSERT INTO segdispdia(
  		    fecha ,  laboral ,
            manana ,  tarde ,  rest_manana,  rest_tarde )
         values
           ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."')";
 // print '<pre>'; print $sql;

  $conexion = $this->conectar2();
     // print '<pre>'; print $conexion;
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  return $consulta;
 }

 function verDisponibilidad($fecha){
	$sql = "SELECT to_char(fecha,'dd/mm/yyyy'),rest_manana, rest_tarde, laboral FROM segdispdia ";
    if($fecha) $sql = $sql." WHERE fecha='".$fecha."'";

//echo "Dispo: ".$sql;

    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
	if($consulta) $disponibilidad = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $disponibilidad;
}
function listarDisponibilidad($id_disp,$fecha,$laboral,$offset){
	$sql = "select id_disp,to_char(fecha,'dd/mm/yyyy'), laboral, manana,tarde,rest_manana,rest_tarde from segdispdia ";
    if($fecha) $sql = $sql." WHERE fecha='".$fecha."'";
    if ($laboral) $sql = $sql." WHERE laboral='".$laboral."'";
    if ($id_disp) $sql = $sql." WHERE id_disp='".$id_disp."'";

    $sql.= "order by fecha ";

    if($offset>=0) $sql = $sql." LIMIT 10 OFFSET ".$offset;
 //    print '<pre>'; print $sql;
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
	if($consulta) $disponibilidad = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $disponibilidad;
}

function ContarDispFechas(){
 $sql = "select count(id_disp) from segdispdia";
 // print '<pre>'; print $sql;
  $ $conexion = $this->conectar2();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

function restarDisponibilidad($fecha,$turno){
	$sql = "SELECT $turno FROM segdispdia WHERE fecha='".$fecha."'";
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
	if($consulta) $disponibilidad = $this->ret_vector($consulta);
	$resto = $disponibilidad[0] - 1;
	$this->desconectar($conexion);

	$sql1 = "UPDATE disponibilidad SET ";
    $sql1.= " $turno = '".$resto."'";
    $sql1.= " WHERE fecha = '".$fecha."'";

     $conexion1 = $this->conectar();
     $consulta1 = $this->consultar($conexion1,$sql1);
     $this->desconectar($conexion1);

	return $consulta1;
}


function verFechaDisp($fecha){
	$sql = "SELECT min(fecha),laboral FROM segdispdia ";
    if($fecha) $sql = $sql." WHERE laboral='S' and (rest_manana>0 or rest_tarde>0) and fecha>'$fecha'";
    $sql.= " group by laboral";

	//echo "Busca Fecha Dig: ".$sql;
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
	$fecha = $this->ret_vector($consulta);

	$this->desconectar($conexion);
	return $fecha;
}


function verDispMaxFecha($fecha,$cupos){
	$sql = "SELECT fecha,rest_manana,rest_tarde,laboral FROM segdispdia ";
    if($fecha) $sql = $sql." WHERE laboral='S' and (rest_manana>0 or rest_tarde>0) and fecha='$fecha'";

//	echo "Busca min: ".$sql;
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
	/*$cuenta = pg_num_rows($consulta);

	if($consulta)
	{
			if ($cuenta==0)
			{
				$sql1 = "SELECT max(fecha),rest_manana,rest_tarde,laboral FROM disponibilidad ";
    			if($fecha) $sql1 = $sql1." WHERE laboral='S' and (rest_manana<$cupos or rest_tarde<$cupos) and fecha='$fecha'";
    			$sql1.= " group by rest_manana,rest_tarde,laboral";

    			echo "Busca max: ".$sql1;

			    $conexion1 = $this->conectar();
				$consulta1 = $this->consultar($conexion1,$sql1);
				$fecha = $this->ret_vector($consulta1);
			}
			else*/
			 	$fecha = $this->ret_vector($consulta);
	//}
	/*if($consulta) $fecha = $this->ret_vector($consulta);*/
	$this->desconectar($conexion);
	return $fecha;
}

function modificarDisp($id_disp,$sumres,$sumres1,$manana2,$tarde2,$mañana,$tarde){
	$sql = "UPDATE segdispdia SET ";
    $sql.= " manana =manana$sumres'".$manana2."'";
    $sql.= ", rest_manana =rest_manana$sumres'".$manana2."'";
    $sql.= ",tarde =tarde$sumres1'".$tarde2."'";
    $sql.= ", rest_tarde =rest_tarde$sumres1'".$tarde2."'";
    $sql.= " WHERE id_disp = '".$id_disp."'";
   // print '<pre>'; print $sql;
     $conexion = $this->conectar2();
     $consulta = $this->consultar($conexion,$sql);
     $this->desconectar($conexion);
	return $consulta;
}
}
?>