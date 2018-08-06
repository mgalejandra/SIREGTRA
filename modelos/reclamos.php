<?

class reclamos extends conexion{

	function listarPersonas($usuario=null){

    	$sql = " SELECT usuario,nombre1,apellido1,correo";
		$sql .= " FROM usuarios where numdep='1' and estatus='A'";
		if ($usuario) $sql .= " and usuario='".$usuario."' ";
		//echo $sql;
  		$conexion = $this->conectar();
  		$consulta = $this->consultar($conexion,$sql);
  		$consulta = $this->ret_vector($consulta);
  		$this->desconectar($conexion);
  		return $consulta;
 	}


  function registroReclamo($codpro,$tramite=null,$kil=null,$detalle=null){
	$fecha=date('d/m/Y');
    $sql = "INSERT INTO reclamos_inter (codpro,id_tipo_reclamo,fecha,estatus_reclamo) VALUES";
    $sql .= " ('" . $codpro . "','" . $tramite . "','" . $fecha . "',1)";
    //echo $sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion, $sql);

    $sql = "SELECT MAX(id_reclamo) FROM reclamos_inter";
    $consulta = $this->consultar($conexion, $sql);
    $id = $this->ret_vector($consulta);

    if ($consulta) {
    	if ($tramite==1){
    	$sql = "INSERT INTO det_reclamos_inter (id_reclamo,id_tipo_reclamo) VALUES ";
        $count = count($detalle);
        for ($i = 0; $i < $count - 1; $i++) {
            $sql .= "('" . $id[0] . "','" . $detalle[$i] . "'),";
        }
        $sql .= "('" . $id[0] . "','" . $detalle[$i] . "');";
    	}

		if ($tramite==2){
		$sql = "INSERT INTO det_reclamos_inter (id_reclamo,id_tipo_reclamo,observaciones) VALUES ";
        $count = count($detalle)/2;
        for ($i = 0; $i < $count - 1; $i++) {
            $sql .= "('" . $id[0] . "','" . $detalle[$i*2] . "','" . $detalle[$i*2+1] . "'),";
        }
        $sql .= "('" . $id[0] . "','" . $detalle[$i*2] . "','" . $detalle[$i*2+1] . "');";
		}

		if ($tramite==3){
		$sql = "INSERT INTO det_reclamos_inter (id_reclamo,id_tipo_reclamo,observaciones) VALUES ";
        $sql .= "('" . $id[0] . "','28','" . $detalle. "');";
		}

		if ($tramite==4){
		$sql = "INSERT INTO det_reclamos_inter (id_reclamo,id_tipo_reclamo,observaciones,kilometraje) VALUES ";
        $count = count($detalle)/2;
        for ($i = 0; $i < $count - 1; $i++) {
            $sql .= "('" . $id[0] . "','" . $detalle[$i*2] . "','" . $detalle[$i*2+1] . "','" . $kil. "'),";
        }
        	$sql .= "('" . $id[0] . "','" . $detalle[$i*2] . "','" . $detalle[$i*2+1] . "','" . $kil. "');";
		}
        //echo $sql;
        $consulta = $this->consultar($conexion, $sql);
        if (!$consulta) {
            $sql = "DELETE FROM venecom.recepcion WHERE id_recepcion = '" . $id . "'";
            $consulta = $this->consultar($conexion, $sql);
        }
     }
     $this->desconectar($conexion);

	 if($consulta) $this->auditoria_reclamos('Registro Reclamo',$id[0]);
  	 if($consulta) $this->bitacoraBeneficiario($id,'','Registro Reclamo',$_SESSION['usuario']);
     if ($consulta) return $id;
 }

  function buscarReclamo($id=null){

    $sql = " SELECT a.id_reclamo, a.codpro, c.des_reclamo, des_estatus, a.estatus_reclamo, a.observ_status, a.usuario_asignado, a.usuario_encargado from reclamos_inter a, tipo_reclamo c, estatus_reclamos b
				where a.id_reclamo='".$id."' and a.id_tipo_reclamo=c.id_reclamo and a.estatus_reclamo=b.id_estatus";
	//echo $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function cambiarStatus($id=null,$reclamo=null,$observ=null,$usuario=null,$diferido=null,$observB=null,$usuarioEnc=null){
	$fecha=date('d/m/Y');
 if($id==1){
	$status=5;
 }
 if($id==5){
	$status=2;
 }
  if($id==2 and $diferido==1){
	$status=3;
 }elseif ($id==2 and $diferido==0){
 	$status=4;
 }
 if($id==3){
	$status=4;
 }

 if ($observB) $observ=$observB.' '.$observ;

 if ($id==1){
 		$sql ="UPDATE reclamos_inter
        SET estatus_reclamo='".$status."', fecha_status='".$fecha."', observ_status='".$observ."', usuario_asignado='".$usuario."' ";
     	$sql .= ", usuario_encargado='".$usuarioEnc."' ";
     	$sql .= "WHERE id_reclamo = $reclamo";

 }else{
 		$sql ="UPDATE reclamos_inter
        SET estatus_reclamo='".$status."', fecha_status='".$fecha."', observ_status='".$observ."' ";
        $sql .= " WHERE id_reclamo = $reclamo";
 }



  echo $sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditoria_reclamos('Cambio Estatus Reclamo - '.$status,$reclamo);
  if($consulta) $this->bitacoraBeneficiario($status,'','Cambio Estatus Reclamo',$_SESSION['usuario']);
  return $consulta;
 }

   function buscarReclamoDet($id=null){

    $sql = "SELECT id_tipo_reclamo, kilometraje, observaciones,des_reclamo FROM det_reclamos_inter a, tipo_reclamo b
			where a.id_reclamo='".$id."' and a.id_tipo_reclamo=b.id_reclamo";
  //echo $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listarTipoReclamo($id=null,$id2=null){

    $sql = " SELECT * from tipo_reclamo";
    if($id)	$sql.= " where origen_reclamo='$id' and id_reclamo<>'$id'";
    if($id2)	$sql.= " where origen_reclamo='$id2' and id_reclamo='$id2'";

    //$sql.= " order by des_reclamo ";
 		//print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listarTipoR($id=null,$nivel=null){

    $sql = " SELECT * from tipo_reclamos where estatus='A'";
    if($id)	$sql.= " and id_tipo='$id' ";
    if($nivel)	$sql.= " and nivel=$nivel";

    $sql.= " order by descripcion ";
 // print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function registrarTipoR($tipo,$nivel=null){
  $fecha=date('d/m/Y');

  if ($nivel)
  	$sql= "INSERT INTO tipo_reclamos(descripcion,fecha_reg,nivel) VALUES ('".$tipo."','".$fecha."',$nivel)";
  else
	$sql= " INSERT INTO tipo_reclamos(descripcion,fecha_reg) VALUES ('".$tipo."','".$fecha."')";
 // print '<pre><br>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('Registro Tipo Reclamo',$sql,'http://localhost/refeciv1.1/vistas/reg_reclamos.php');
  if($consulta) $this->bitacoraBeneficiario($tipo,'','Registro Tipo Reclamo',$_SESSION['usuario']);
  return $consulta;
 }

 /*function listarReclamos($fecha=null,$codpro=null,$offset=null,$id_reclamo=null,$sercarveh=null,$fec2=null,$nombre=null,$sexo=null,$descripcion=null,$codmar=null,$codmodveh=null,$codserveh=null,$banco=null,$respuesta=null){

   $sql = "select id_reclamo,codpro,prinompro,segnompro,priapepro,segapepro,to_char(fecha,'dd/mm/yyyy'),tipo,sercarveh,reclamos.descripcion,respuesta,
   		tlfcelpro,tlfcelpro2,id_banco,nomcomp,sexo,to_char(fecha_mod,'dd/mm/yyyy'), tipo_reclamos.descripcion FROM reclamos, tipo_reclamos  where estatus='A' and tipo_reclamos.id_tipo=reclamos.tipo ";


   if($fecha AND !($fec2)) $sql.= " and fecha >= '".$fecha."'";
   else if (!($fecha) AND  $fec2) $sql.= " and fecha <= '".$fec2."'";
   else if ($fecha  AND  $fec2) $sql.= " and fecha BETWEEN '".$fecha."' AND '".$fec2."'";

   if ($codpro) $sql.=" AND codpro like '%$codpro%'";
   if ($id_reclamo) $sql.= " and id_reclamo = $id_reclamo";
   if ($sercarveh)  $sql.=" and sercarveh like '%".$sercarveh."%'";
   if ($nombre)  $sql.=" and nomcomp like '%".$nombre."%'";
   if ($sexo)    $sql.=" and sexo='".$sexo."'";
   if ($descripcion)  $sql.=" and descripcion like '%".$descripcion."%'";
   if ($respuesta)  $sql.=" and respuesta like '%".$respuesta."%'";
    if($codmar)  $sql.=" and a.codmarveh='".$codmar."'";
    if($modveh)  $sql.=" and a.codmod='".$modveh."'";
   if ($banco)  $sql.=" and id_banco like '%".$banco."%'";

  $sql.= " order by id_reclamo desc";

  if($offset>=0) $sql.= " LIMIT 15 OFFSET $offset";

  //print "<br>".$sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desacto= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desacto;
 }*/

 function listarReclamos($fecha=null,$codpro=null,$offset=null,$id_reclamo=null,$sercarveh=null,$fec2=null,$nombre=null,$sexo=null,$descripcion=null,$codmar=null,$codmodveh=null,$codserveh=null,$banco=null,$respuesta=null,$usuario=null,$estatus=null){

$sql = "select a.id_reclamo, a.fecha, a.codpro, e.nomcomp, e.tlfcelpro, c.des_reclamo, d.des_estatus, a.id_tipo_reclamo, a.usuario_asignado, a.fecha_status
   		FROM reclamos_inter a
		inner join tipo_reclamo c on a.id_tipo_reclamo=c.id_reclamo
		inner join estatus_reclamos d on d.id_estatus=a.estatus_reclamo
		inner join propietarios e on e.codpro=a.codpro " .

   		"where a.status='A' ";
/*inner join det_reclamos_inter b  on a.id_reclamo=b.id_reclamo*/
   if ($usuario) $sql.= " and a.usuario_asignado = '".$usuario."' ";
   if ($estatus) $sql.= " and a.estatus_reclamo = 5 ";
   if($fecha AND !($fec2)) $sql.= " and a.fecha >= '".$fecha."'";
   else if (!($fecha) AND  $fec2) $sql.= " and a.fecha <= '".$fec2."'";
   else if ($fecha  AND  $fec2) $sql.= " and a.fecha BETWEEN '".$fecha."' AND '".$fec2."'";

   if ($codpro) $sql.=" AND a.codpro like '%$codpro%'";
   if ($id_reclamo) $sql.= " and a.id_reclamo = $id_reclamo";
   if ($nombre)  $sql.=" and e.nomcomp like '%".$nombre."%'";

  $sql.= " order by d.des_estatus asc, id_reclamo desc";

  if($offset>=0) $sql.= " LIMIT 15 OFFSET $offset";

  //print "<br>".$sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $desacto= $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $desacto;
 }

 function registrarReclamo($data){
  $fecha=date('d/m/Y');

$sql = "INSERT INTO  reclamos(
            codpro, prinompro, segnompro, priapepro, segapepro,
            fecha, tipo, sercarveh, descripcion, respuesta, tlfcelpro, tlfcelpro2,
            id_banco, nomcomp, sexo)
        VALUES ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$fecha."',
            '".$data[5]."', '".$data[6]."', '".$data[7]."', '".$data[8]."', '".$data[9]."', '".$data[10]."', '".$data[11]."',
             '".$data[12]."','".$data[13]."')";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('Registro de Reclamo',$sql,'http://localhost/refeciv1.1/vistas/reg_reclamos.php');
  if($consulta) $this->bitacoraBeneficiario($data[0],'','Registro de Reclamo',$_SESSION['usuario']);
  return $consulta;
 }


 function modificarReclamo($id,$data){
 $fecha=date('d/m/Y');

 $sql ="UPDATE reclamos
        SET prinompro='".$data[1]."', segnompro='".$data[2]."', priapepro='".$data[3]."',segapepro='".$data[4]."',
        fecha_mod='".$fecha."', tipo='".$data[5]."', sercarveh='".$data[6]."', descripcion='".$data[7]."', respuesta='".$data[8]."',
        tlfcelpro='".$data[9]."', tlfcelpro2='".$data[10]."', id_banco='".$data[11]."', nomcomp='".$data[12]."',sexo='".$data[13]."'
     	WHERE id_reclamo = $id";

  //echo $sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('Modifico Reclamo',$sql,'http://localhost/refeciv1.1/vistas/reg_reclamos.php');
  if($consulta) $this->bitacoraBeneficiario($data[0],'','Modifico Reclamo',$_SESSION['usuario']);
  return $consulta;
 }


}
?>