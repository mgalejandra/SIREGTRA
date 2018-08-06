<?
class auditoria extends conexion{

 //Esta es la funcion para el listado de la tabla auditoria
 function listarBitacoraBeneficiario($codpro=null,$sercarveh=null,$movimiento=null,$usuario=null,$fechaD=null,$fechaH=null,$offset){
    $sql = "SELECT c.usuario,c.nombre1,c.nombre2,c.apellido1,c.apellido2,b.codpro,b.sercarveh,b.movimiento,to_char(b.fecha,'dd/mm/yyyy'),b.hora
FROM bitacora_beneficiario b, usuarios c WHERE c.usuario = b.usuario" ;

	if($codpro)     $sql.=" and b.codpro like '%".$codpro."%'";
	if($sercarveh)  $sql.=" and b.sercarveh like '%".$sercarveh."%'";
    if($movimiento) $sql.=" and b.movimiento like '%".$movimiento."%'";
	if($usuario)    $sql.=" and c.usuario='".$usuario."' ";

    if($fechaD AND !$fechaH) $sql.= " and b.fecha >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha <= '".$fechaH."'";
	else if ($fechaD and $fechaH)	$sql.= " and b.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";


	$sql.= " order by b.fecha desc,b.hora desc";

	if($offset>=0)     $sql.= " LIMIT 15 OFFSET $offset";

    //print '<br>'.$sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);
    $consulta = $this->ret_vector($consulta);
    $this->desconectar($conexion);
    return $consulta;
  }


function contarAuditoriaBeneficiario($codpro=null,$sercarveh=null,$accion=null,$sentencia=null,$usuario=null,$fechaD=null,$fechaH=null,$formulario=null){
    $sql = "SELECT count(c.usuario)
FROM auditoria b, usuarios c WHERE c.usuario = b.usuario" ;

	if($codpro) $sql.=" and ((b.sentencia like '%".$codpro."%') or (b.accion like '%".$codpro."%'))";
	if($sercarveh) $sql.=" and ((b.sentencia like '%".$sercarveh."%') or (b.accion like '%".$sercarveh."%'))";
	if($accion) $sql.=" and b.accion like '%".$accion."%'";
	if($sentencia) $sql.=" and b.sentencia like '%".$sentencia."%'";
	if($formulario) $sql.= " AND b.formulario like '%".$formulario."%' ";
	if($usuario)   $sql.= " AND c.usuario='".$usuario."' ";

	if($fechaD) $sql.= " and b.fecha like '%".$fechaD."%'";
   /* if($fechaD AND !$fechaH) $sql.= " and b.fecha >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha <= '".$fechaH."'";
	else if ($fechaD and $fechaH)	$sql.= " and b.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";*/

   // print '<br>'.$sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);
    $consulta = $this->ret_vector($consulta);
    $this->desconectar($conexion);
    return $consulta[0];
  }

function listarAuditoriaBeneficiario($codpro=null,$sercarveh=null,$accion=null,$sentencia=null,$usuario=null,$fechaD=null,$fechaH=null,$formulario=null,$offset=-1){
    $sql = "SELECT c.usuario,c.nombre1,c.nombre2,c.apellido1,c.apellido2,b.fecha,b.accion,b.sentencia,b.formulario
FROM auditoria b, usuarios c WHERE c.usuario = b.usuario" ;

	if($codpro) $sql.=" and ((b.sentencia like '%".$codpro."%') or (b.accion like '%".$codpro."%'))";
	if($sercarveh) $sql.=" and ((b.sentencia like '%".$sercarveh."%') or (b.accion like '%".$sercarveh."%'))";
	if($accion) $sql.=" and b.accion like '%".$accion."%'";
	if($sentencia) $sql.=" and b.sentencia like '%".$sentencia."%'";
	if($formulario) $sql.= " AND b.formulario like '%".$formulario."%' ";
	if($usuario)   $sql.= " AND c.usuario='".$usuario."' ";

	if($fechaD) $sql.= " and b.fecha like '%".$fechaD."%'";
    /*if($fechaD AND !$fechaH) $sql.= " and b.fecha >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha <= '".$fechaH."'";
	else if ($fechaD and $fechaH)	$sql.= " and b.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";*/


	$sql.= " order by b.fecha desc";

	if($offset>=0)     $sql.= " LIMIT 40 OFFSET $offset";

    //print '<br>'.$sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);
    $consulta = $this->ret_vector($consulta);
    $this->desconectar($conexion);
    return $consulta;
  }

function listarAuditoriaBeneficiarioPre($codpro=null,$movimiento=null,$usuario=null,$fechaD=null,$fechaH=null,$offset){
    $sql = "SELECT b.nomcomp, a.codpro, a.movimiento, to_char(a.fecha,'dd/mm/yyyy'), a.hora, a.usuario FROM segbitbenef a, repbenefsol b where a.codpro=b.codpro ";


	if($codpro) $sql.=" and a.codpro=$codpro";
	if($movimiento) $sql.=" and a.movimiento like '%".$movimiento."%' ";
	if($usuario)   $sql.= " AND a.usuario='".$usuario."' ";

	if($fechaD AND !$fechaH) $sql.= " and a.fecha >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and a.fecha <= '".$fechaH."'";
	else if ($fechaD and $fechaH)	$sql.= " and a.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";


	$sql.= " order by a.fecha asc";

	if($offset>=0)     $sql.= " LIMIT 30 OFFSET $offset";

   // print '<br>'.$sql;
    $conexion = $this->conectar2();
    $consulta = $this->consultar($conexion,$sql);
    $consulta = $this->ret_vector($consulta);
    $this->desconectar($conexion);
    return $consulta;
  }

}
?>