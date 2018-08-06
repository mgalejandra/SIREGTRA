<?php
class concesionario extends conexion{

function listarVehChery($sercarveh,$codpro,$nomcomp,$offset=0,$modelo=null,$estado=null,$fecE=null,$placa=null,$fecH=null,$numlotveh=null){

// 			-- and e.status='A'
   	$sql = "SELECT a.sercarveh, a.codpro, trim(b.nomcomp), m.desmod,descolor(col1veh),p.numplaveh,
   			c.sermotveh,c.sernivveh,c.serchaveh,b.tlfcelpro,b.tlfcel2pro,
   			calavepro,urbbarpro,edicaspro,numpispro,numapapro,dismunpro,to_char(f.fecfac,'dd/mm/yyyy'),b.codest,to_char(e.fecha_ent,'dd/mm/yyyy'),i.deslot
   			 FROM asignacion a " .
 			"INNER JOIN propietarios b ON (b.codpro = a.codpro) INNER JOIN facturaprof f ON (f.id_asignacion = a.id_asignacion) " ;

 	$sql.=	"INNER JOIN vehiculo c ON (c.sercarveh = a.sercarveh) inner join placas p ON (c.sercarveh=p.sercarveh) " ;
    $sql.=	"LEFT OUTER JOIN entrega e ON (c.sercarveh = e.sercarveh) " ;
 	$sql.=	"INNER JOIN caracteristica d ON (d.id_caract = c.id_caract) INNER JOIN modelo m ON (d.codmod = m.codmod) INNER JOIN marcas n ON (d.codmarveh = n.codmar)
 			,lote i, departamento j ";
    $sql.= "WHERE f.id_estatus='15' and n.codmar='C7' AND d.numlotveh=i.numlot and i.numdep=j.numdep
 			and f.estatus='A' and c.estatus='A' and e.status='A'";
    if($sercarveh)  $sql.= " AND a.sercarveh like '%$sercarveh%'";
    if($codpro)  	$sql.= " AND a.codpro like '%$codpro%'";
    if($nomcomp)  	$sql.= " AND b.nomcomp like '%$nomcomp%' ";
    if ($modelo) $sql.= " AND d.codmod ='$modelo'";
    if ($estado) $sql.= " AND b.codest ='$estado'";
    if ($numlotveh) $sql.= " AND i.numlot ='$numlotveh'";
   // if ($fecE) $sql.= " AND e.fecha_ent ='$fecE'";

    if($fecE AND !$fecH) $sql.= " and e.fecha_ent >= '".$fecE."'";
	else if (!$fecE AND  $fecH) $sql.= " and e.fecha_ent <= '".$fecH."'";
	else if ($fecE  AND  $fecH)	$sql.= " and e.fecha_ent BETWEEN '".$fecE."' AND '".$fecH."'";

	if ($placa) $sql.= " AND p.numplaveh ='$placa'";

    $sql.= " ORDER BY a.codpro";
    if($offset>=0) $sql.= " LIMIT 20 OFFSET $offset";
   //print '<pre>Listar'; print $sql;
//	f_alert($sql);

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

function listarConcesionario($rifconc=null,$desconc=null,$offset=-1){

 	$sql = "SELECT * FROM concesionario ";


 	if($desconc) $sql.= " where  nomconc like UPPER('%".$desconc."%') ";
 	if($rifconc) $sql.= " where  rifconc like '%".$rifconc."%'";

 	if($offset>=0) $sql.= " LIMIT 15 OFFSET $offset";

 // print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

function listarConcesionarioID($id){

 	$sql = "SELECT * FROM concesionario where id_concesionario=$id";

  //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

function regConcesionario($datos){
   $conexion = $this->conectar();
   $fecha=date('d/m/Y');

$sql = " INSERT INTO concesionario(rifconc, nomconc, direccion, telefono1, telefono2) VALUES ";
$sql.= " ('".$datos[0]."','".$datos[1]."','".$datos[2]."','".$datos[3]."','".$datos[4]."')";

// print '<pre>'.$sql;

  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar($_SESSION['usuario'],'REGISTRO','Registro concesionario '.$datos[1]);
  return $consulta;

}

function modConcesionario($id,$datos){
   $sql = "UPDATE concesionario
       SET rifconc='".$datos[0]."', nomconc='".$datos[1]."', direccion='".$datos[2]."', telefono1='".$datos[3]."',
       telefono2='".$datos[4]."' WHERE id_concesionario=$id";

  // print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
    if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico concesionario '.$datos[1]);
	return $consulta;
}

//MANEJO DE RECLAMOS
function buscarUsuarioConc($concec=null,$usuario=null,$cedula=null,$tipo=null,$nivel=null,$offset=-1,$nombre=null,$estatus=null,$dep=null){

 	if($nivel==1)$nivel=null;

	$sql = "SELECT a.usuario,a.nombre1,a.nombre2,a.apellido1,a.apellido2,a.cedula,a.idcargo,a.status,d.destipu,a.id_concesionario,a.numdep,c.descdep, d.nivel FROM usuarios a";
	$sql = $sql." left outer join departamento c on a.numdep=c.numdep ";
	$sql = $sql." left outer join tipo_usuario d on a.idcargo=d.codtipu ";
	$sql = $sql." WHERE a.estatus='A' ";
	if ($usuario) $sql = $sql." and a.usuario='".$usuario."'";
	if ($cedula) $sql = $sql." and a.cedula like '%".$cedula."%'";
	if ($nombre) $sql = $sql." and (a.nombre1 like '%".$nombre."%' or a.nombre2 like '%".$nombre."%' or a.apellido1 like '%".$nombre."%' or a.apellido2 like '%".$nombre."%')";
	if ($tipo) $sql = $sql." and  a.idCargo=".$tipo."";
    if ($nivel) $sql = $sql." and  d.nivel=".$nivel."";
    if ($concec) $sql = $sql." and  a.id_concesionario='".$concec."' ";
    if ($dep) $sql = $sql." and  a.numdep=".$dep."";
    if ($estatus) $sql = $sql." and  a.status='".$estatus."'";
    if($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;

//print "Busca Usu: ".$sql;
	$conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $usuario;
  }


function listarReclamosConc($concec=null,$fecha=null,$codpro=null,$offset=null,$id_reclamo=null,$sercarveh=null,$fec2=null,$nombre=null,$sexo=null,$descripcion=null,$codmar=null,$codmodveh=null,$codserveh=null,$respuesta=null){

$sql = "select a.id_reclamo,a.codpro,a.prinompro,a.segnompro,a.priapepro,a.segapepro,to_char(a.fecha,'dd/mm/yyyy'),a.tipo,a.sercarveh,a.descripcion,a.respuesta,
   		a.tlfcelpro,a.tlfcelpro2,a.id_banco,a.nomcomp,a.sexo,to_char(a.fecha_mod,'dd/mm/yyyy'), b.descripcion
   		FROM reclamos a, tipo_reclamos b where a.estatus='A' and b.id_tipo=a.tipo ";

if ($concec)  $sql.=" and a.id_concesionario='$concec'";
   if($fecha AND !($fec2)) $sql.= " and a.fecha >= '".$fecha."'";
   else if (!($fecha) AND  $fec2) $sql.= " and a.fecha <= '".$fec2."'";
   else if ($fecha  AND  $fec2) $sql.= " and a.fecha BETWEEN '".$fecha."' AND '".$fec2."'";

   if ($codpro) $sql.=" AND a.codpro like '%$codpro%'";
   if ($id_reclamo) $sql.= " and a.id_reclamo = $id_reclamo";
   if ($sercarveh)  $sql.=" and a.sercarveh like '%".$sercarveh."%'";
   if ($nombre)  $sql.=" and a.nomcomp like '%".$nombre."%'";
   if ($sexo)    $sql.=" and a.sexo='".$sexo."'";
   if ($descripcion)  $sql.=" and b.descripcion like '%".$descripcion."%'";
   if ($respuesta)  $sql.=" and a.respuesta like '%".$respuesta."%'";
  /*  if($codmar)  $sql.=" and a.codmarveh='".$codmar."'";
    if($modveh)  $sql.=" and a.codmod='".$modveh."'";*/

  $sql.= " order by id_reclamo desc";

  if($offset>=0) $sql.= " LIMIT 15 OFFSET $offset";

 // print "<br>".$sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desacto= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desacto;
 }

  function listarTipoRC($id=null){

    $sql = " SELECT * from tipo_reclamos where nivel=2";
    if($id)	$sql.= " and id_tipo = '$id' ";

  //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

function registrarReclamoC($data){
  $fecha=date('d/m/Y');

$sql = "INSERT INTO  reclamos(
            codpro, prinompro, segnompro, priapepro, segapepro,
            fecha, tipo, sercarveh, descripcion, respuesta, tlfcelpro, tlfcelpro2,
            id_banco, nomcomp, sexo, id_concesionario)
        VALUES ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$fecha."',
            '".$data[5]."', '".$data[6]."', '".$data[7]."', '".$data[8]."', '".$data[9]."', '".$data[10]."', '".$data[11]."',
             '".$data[12]."','".$data[13]."','".$data[14]."')";

 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('Registro de Reclamo',$sql,'http://localhost/refeciv1.1/vistas/reg_reclamos.php');
  if($consulta) $this->bitacoraBeneficiario($data[0],'','Registro de Reclamo',$_SESSION['usuario']);
  return $consulta;
 }

}
?>