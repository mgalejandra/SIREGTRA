<?
class vines extends conexion{

 function listadodevines($tipo=null,$modelo=null,$marca=null,$color=null,$pdi=null,$fecha=null,$Hora=null,$nro=null,$offset=0){

   $sql = "select a.id, a.tipo, a.nro_archivo, a.desmod, a.desmar, a.sercarveh, a.sermotveh, a.descol, a.anomodveh, a.anofabveh,
   		   a.lla, a.enc, a.car, a.cau, a.gat, a.tri, a.her, a.fecha_cap, a.hora_cap, a.fecha_reg, a.hora_reg, b.nombre, b.descripcion FROM archivo_pistola a,
   		   tipo_archivo b where a.tipo=b.id";

   if($tipo)    $sql.= " and a.tipo=$tipo ";
   if($nro)     $sql.= " and a.nro_archivo=$nro ";
   if($modelo)  $sql.= " and a.desmod='".$modelo."' ";
   if($marca)  $sql.= " and a.desmar='".$marca."' ";
   if($color)  $sql.= " and a.descol='".$color."' ";
   if($pdi)  $sql.= " and a.$pdi='NO' ";
   if($fecha)   $sql.= " and a.fecha_cap='".$fecha."' ";
   if($Hora)  $sql.= " and a.hora_cap='".$Hora."' ";
   $sql.= " order by a.id desc";
   if($offset>=0) $sql.= " LIMIT 20 OFFSET $offset";


 // print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desvines= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desvines;
 }

  function modeloArchivo($offset=null){

   $sql = "select distinct(desmod) from archivo_pistola";

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desvines= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desvines;
 }

   function marcaArchivo($offset=null){

   $sql = "select distinct(desmar) from archivo_pistola";

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desvines= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desvines;
 }

    function colorArchivo($offset=null){

   $sql = "select distinct(descol) from archivo_pistola";

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desvines= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desvines;
 }

     function fechaArchivo($offset=null){

   $sql = "select distinct(fecha_cap) from archivo_pistola";

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desvines= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desvines;
 }

      function horaArchivo($offset=null){

   $sql = "select distinct(hora_cap) from archivo_pistola";

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desvines= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desvines;
 }

   function tipo_archivo($offset=null){

   $sql = "select * FROM tipo_archivo";

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desvines= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desvines;
 }

  function listadodevinesmovi($tipo=null,$modelo=null,$marca=null,$color=null,$pdi=null,$fecha=null,$Hora=null,$nro=null,$offset=0){

   $sql = "select a.id, a.tipo, a.nro_archivo, a.desmod, a.desmar, a.sercarveh, a.sermotveh, a.descol, a.anomodveh, a.anofabveh,
			a.lla, a.enc, a.car, a.cau, a.gat, a.tri, a.her, a.fecha_cap, a.hora_cap, a.fecha_reg, a.hora_reg, b.nombre, b.descripcion
			FROM archivo_pistola a,
			tipo_archivo b
			where a.tipo=b.id and
			a.sercarveh in (select b.sercarveh from archivo_pistola b where b.sercarveh=a.sercarveh and
			(b.lla <> a.lla or b.enc <> a.enc or b.car<>a.car or b.cau<>a.cau or b.gat<>a.gat or b.tri<>a.tri or b.her<>a.her))
			";

   if($tipo)    $sql.= " and a.tipo=$tipo ";
   if($nro)     $sql.= " and a.nro_archivo=$nro ";
   if($modelo)  $sql.= " and a.desmod='".$modelo."' ";
   if($marca)  $sql.= " and a.desmar='".$marca."' ";
   if($color)  $sql.= " and a.descol='".$color."' ";
   if($pdi)  $sql.= " and a.$pdi='NO' ";
   if($fecha)   $sql.= " and a.fecha_cap='".$fecha."' ";
   if($Hora)  $sql.= " and a.hora_cap='".$Hora."' ";
   $sql.= " order by a.sercarveh,b.id";
   if($offset>=0) $sql.= " LIMIT 20 OFFSET $offset";


//print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desvines= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desvines;
 }


  function contarlistadodevinesmovi($tipo=null,$modelo=null,$marca=null,$color=null,$pdi=null,$fecha=null,$Hora=null,$nro=null,$offset=0){

   $sql = "
			select count(a.sercarveh) from (
			select count(a.sercarveh), a.sercarveh
			FROM archivo_pistola a,
			tipo_archivo b
			where a.tipo=b.id and
			a.sercarveh in (select b.sercarveh from archivo_pistola b where b.sercarveh=a.sercarveh and
			(b.lla <> a.lla or b.enc <> a.enc or b.car<>a.car or b.cau<>a.cau or b.gat<>a.gat or b.tri<>a.tri or b.her<>a.her))
			";

   if($tipo)    $sql.= " and a.tipo=$tipo ";
   if($nro)     $sql.= " and a.nro_archivo=$nro ";
   if($modelo)  $sql.= " and a.desmod='".$modelo."' ";
   if($marca)  $sql.= " and a.desmar='".$marca."' ";
   if($color)  $sql.= " and a.descol='".$color."' ";
   if($pdi)  $sql.= " and a.$pdi='SI' ";
   if($fecha)   $sql.= " and a.fecha_cap='".$fecha."' ";
   if($Hora)  $sql.= " and a.hora_cap='".$Hora."' ";
   $sql.= "  GROUP BY   a.sercarveh)a";

  //print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desvines= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desvines;
 }


}
?>