<?php
class entrega extends conexion{

 function contarEntregas($tabData){
	$id_entrega = $tabData[0];
	$sercarveh 	= $tabData[1];
	$beneficia	= $tabData[2];
	$PDI		= $tabData[3];
	$gas		= $tabData[4];
	$fecha		= $tabData[5];
	$numlotveh	= $tabData[6];
	$cod_marca	= $tabData[7];
	$cod_modelo	= $tabData[8];
	$lugar		= $tabData[9];
	$acto       = $tabData[10];

 	$sql = "SELECT COUNT(id_entrega)
 	         FROM entrega a".
		   " INNER JOIN asignacion b 	 ON (b.id_asignacion = a.id_asignacion)".
		   " INNER JOIN propietarios c 	 ON (b.codpro = c.codpro) ".
		   " INNER JOIN vehiculo d 		 ON (d.sercarveh = a.sercarveh) ".
		   " INNER JOIN caracteristica e ON (e.id_caract = d.id_caract) ".
		   " WHERE a.status = 'A'";
    if($id_entrega)	$sql.= " AND a.id_entrega = $id_entrega";
    if($sercarveh)	$sql.= " AND a.sercarveh LIKE '%$sercarveh%'";
    if($beneficia)	$sql.= " AND c.nomcomp LIKE '%$beneficia%' or c.codpro LIKE '%$beneficia%' ";
    if($PDI) 		$sql.= " AND swpdi = 'A'";
    if($gas)		$sql.= " AND swgnv = 'A'";
    if($numlotveh) 	$sql.= " AND e.numlotveh = $numlotveh";
    if($cod_marca) 	$sql.= " AND e.codmarveh = '$cod_marca'";
    if($cod_modelo) $sql.= " AND e.codmod = '$cod_modelo'";
    if($lugar) 		$sql.= " AND a.lugar = '$lugar'";
    if($acto) 		$sql.= " AND acto = '$acto'";

  //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

 function listarEntregas($tabData,$offset=null,$nroFilas=20){

	$id_entrega = $tabData[0];
	$sercarveh 	= $tabData[1];
	$beneficia	= $tabData[2];
	$PDI		= $tabData[3];
	$gas		= $tabData[4];
	$fecha		= $tabData[5];
	$numlotveh	= $tabData[6];
	$cod_marca	= $tabData[7];
	$cod_modelo	= $tabData[8];
	$lugar		= $tabData[9];
	$acto       = $tabData[10];

 	$sql = "SELECT a.id_entrega, e.numlotveh, a.sercarveh, c.nomcomp, swpdi, swgnv,";
	$sql.= " lugar, TO_CHAR(a.fecha_ent,'dd/mm/yyyy'),TO_CHAR(a.fecha_reg,'dd/mm/yyyy'),a.acto".
		   " FROM entrega a".
		   " INNER JOIN asignacion b 	 ON (b.id_asignacion = a.id_asignacion)".
		   " INNER JOIN propietarios c 	 ON (b.codpro = c.codpro) ".
		   " INNER JOIN vehiculo d 		 ON (d.sercarveh = a.sercarveh) ".
		   " INNER JOIN caracteristica e ON (e.id_caract = d.id_caract) ".
		   " LEFT OUTER JOIN acto f 	 ON (a.acto = f.idacto) ".
		   " WHERE a.status = 'A'";
    if($id_entrega)	$sql.= " AND a.id_entrega = $id_entrega";
    if($sercarveh)	$sql.= " AND a.sercarveh LIKE '%$sercarveh%'";
    if($beneficia)	$sql.= " AND c.nomcomp LIKE '%$beneficia%' or c.codpro LIKE '%$beneficia%' ";
    if($PDI) 		$sql.= " AND swpdi = 'A'";
    if($gas)		$sql.= " AND swgnv = 'A'";
    if($numlotveh) 	$sql.= " AND e.numlotveh = $numlotveh";
    if($cod_marca) 	$sql.= " AND e.codmarveh = '$cod_marca'";
    if($cod_modelo) $sql.= " AND e.codmod = '$cod_modelo'";
    if($lugar) 		$sql.= " AND a.lugar = '$lugar'";
    if($acto) 		$sql.= " AND acto = '$acto'";
    $sql.= " limit 1 ";
    if($offset>=0) $sql.= " LIMIT $nroFilas OFFSET $offset";

  print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function registrarEntrega($data,$id_entrega,$msj=null,$codproa,$num){
	$conexion = $this->conectar();
/*
//	Verificar si existe un registro de entrega previo

  	$sql = "SELECT * FROM entrega WHERE sercarveh = '$data[0]' AND status = 'A'";
  	$consulta = $this->consultar($conexion,$sql);
  	$contF = $this->ret_vector($consulta);

	if(!$contF){ // Si no consigue nada se procede a insertar la entrega
*/
		$fecha=date('Y-m-d');

		//	Determina un número correlativo para el $id_entrega

		$sql = "SELECT MAX(id_entrega) FROM entrega ";
		$consulta = $this->consultar($conexion,$sql);
		$contF = $this->ret_vector($consulta);
		$id_entrega = $contF[0]+1;

		//f_alert($sql);

		$sql =  "INSERT INTO entrega ".
				" (id_entrega, sercarveh, id_asignacion, fecha_ent, lugar, fecha_reg,acto,tipoe)".
		        " VALUES ($id_entrega,'$data[1]',$data[2],'$data[3]','$data[4]','$fecha'";

		/*if ($data[5])    //ESTE EXISTIA PERO NO SE QUE HACE Y ME AFECTABA LA INSERCION CUANDO ERA POR ENTREGAR EN ACTO
			$sql.=",'$data[5]'";
		else
			$sql.=",null";*/

		if ($data[5])
			$sql.=",'$data[5]','A')";
		else
			$sql.=",null,'O')";

		//echo $sql; die();
    	//f_alert($sql);
    	//print $sql;

		$consulta = $this->consultar($conexion,$sql);
		$this->desconectar($conexion);
		if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/reg_entrega_veh');
		if($consulta) $this->bitacoraBeneficiario($codproa,$data[1],'Entrega Registrada con el N#: '.$id_entrega,$_SESSION['usuario']);
        if($consulta)
        {
        	if ($data[5])
        		$this->estatusFacturaProfo($num,$codproa,$data[1],'22','','');
        	else
        		$this->estatusFacturaProfo($num,$codproa,$data[1],'15','','');
        }

		return $consulta;
/*	}else{$msj = '\nERROR: Este vehículo ha sido entregado'
	}*/
 }
 function registrarEntrega2($data,$id_entrega,$msj=null,$codproa,$num){
	$conexion = $this->conectar();
/*
//	Verificar si existe un registro de entrega previo

  	$sql = "SELECT * FROM entrega WHERE sercarveh = '$data[0]' AND status = 'A'";
  	$consulta = $this->consultar($conexion,$sql);
  	$contF = $this->ret_vector($consulta);

	if(!$contF){ // Si no consigue nada se procede a insertar la entrega
*/
		$fecha=date('Y-m-d');

		//	Determina un número correlativo para el $id_entrega

		$sql = "SELECT MAX(id_entrega) FROM entrega ";
		$consulta = $this->consultar($conexion,$sql);
		$contF = $this->ret_vector($consulta);
		$id_entrega = $contF[0]+1;

		//f_alert($sql);

		$sql =  "INSERT INTO entrega ".
				" (id_entrega, sercarveh, id_asignacion, fecha_ent, lugar, fecha_reg,acto,tipoe)".
		        " VALUES ($id_entrega,'$data[1]',$data[2],'$data[3]','$data[4]','$fecha'";

		/*if ($data[5])    //ESTE EXISTIA PERO NO SE QUE HACE Y ME AFECTABA LA INSERCION CUANDO ERA POR ENTREGAR EN ACTO
			$sql.=",'$data[5]'";
		else
			$sql.=",null";*/

		if ($data[5])
			$sql.=",'$data[5]','A')";
		else
			$sql.=",null,'O')";


		//echo $sql; die();
    	//f_alert($sql);
    	//print $sql;

		$consulta = $this->consultar($conexion,$sql);
		$this->desconectar($conexion);
		if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/reg_entrega_veh');
		if($consulta) $this->bitacoraBeneficiario($codproa,$data[1],'Entrega Registrada con el N#: '.$id_entrega,$_SESSION['usuario']);
        if($consulta)
        {
        	$this->estatusFacturaProfo($num,$codproa,$data[1],'15','','');
        }

		return $consulta;
/*	}else{$msj = '\nERROR: Este vehículo ha sido entregado'
	}*/
 }
function buscarEntrega ($id_entrega=null,$sercarveh=null,$desde=null,$hasta=null,$codpro=null,$nombre=null,$id_asignacion=null) {
 	$sql = "SELECT".
	 	"   a.id_entrega".
	 	" , a.sercarveh".
	 	" , b.id_asignacion".
	 	" , TO_CHAR(a.fecha_ent,'dd/mm/yyyy')".
	 	" , a.lugar".
	 	" , a.swpdi".
	 	" , a.swgnv".
	 	" , TO_CHAR(a.fecha_reg,'dd/mm/yyyy')".
	 	" , c.nomcomp" .
	 	" , a.montocredito" .
	 	" , a.acto" .
		" FROM entrega a ".
		" INNER JOIN asignacion b ON (a.sercarveh = b.sercarveh)".
		" INNER JOIN propietarios c ON (b.codpro = c.codpro) ".
		" WHERE a.status='A'";

	if($id_entrega) $sql.= " AND a.id_entrega = $id_entrega";
	if($sercarveh) $sql.= " AND b.sercarveh = '$sercarveh'";
	if( $desde AND  $hasta) $sql .= " AND  a.fec_pago BETWEEN '$desde' AND '$hasta'";
	if(!$desde AND  $hasta) $sql .= " AND  a.fec_pago <= '$hasta'";
	if( $desde AND !$hasta) $sql .= " AND  a.fec_pago >= '$desde'";
    if($codpro)  $sql.= " AND c.codpro LIKE '%$codpro%'";
    if($nombre)  $sql.= " AND c.nomcomp LIKE '%$nombre%'";
    if($id_asignacion) $sql.= " AND b.id_asignacion= $id_asignacion";

    $sql.= " ORDER BY 1";

 //print '<pre>Busco Entrega: '.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;

}

 function modificarEntrega($data,$num=null,$codproa=null){
  $fecha=date('d/m/Y');
  $conexion = $this->conectar();

  $sql = " UPDATE entrega SET ". //$sercarveh, $idAsig, $fec_entrega, $lugar, $sw_PDI, $sw_gas
  		 "  fecha_ent = '$data[3]'".
         ", lugar = '$data[4]'".
         ", fecha_reg = '$fecha'";

  if (($data[5])) // and ($data[6]=='V'))
		$sql.= ", acto = '$data[5]', tipoe='A'";
  else
  		$sql.= ", acto = '', tipoe='O'";

   $sql .= " WHERE id_entrega = $data[0] AND sercarveh = '$data[1]' AND id_asignacion = $data[2]";

  //print "ACTUALIZO: ".$sql;
  $this->consultar($conexion,$sql);

  //f_alert($sql);

  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/');
  if($consulta){
   	 if (($data[5]) and ($data[6]=='V'))
   		$this->estatusFacturaProfo($num,$codproa,$data[1],'15','','');
   	else
        $this->estatusFacturaProfo($num,$codproa,$data[1],'22','','');
  }
  return $consulta;
 }

function listarLugares() {
  $sql = "SELECT cod_lugar,lugar FROM lugar WHERE status = 'A'";
//   print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////

 function AnularEntrega($id_entrega,$msj){
  $conexion = $this->conectar();
  $fecha = date("Y-m-d");

  $sql= "DROP TABLE IF EXISTS t1;" .
  		"SELECT sercarveh INTO t1 FROM entrega WHERE id_entrega=$id_entrega;" .
  		"UPDATE entrega SET status = 'E' WHERE id_entrega=$id_entrega;" .
        "UPDATE venta SET estatus=null, fec_mod='$fecha' FROM t1 WHERE venta.sercarveh = t1.sercarveh;" .
        "DROP TABLE IF EXISTS t1;";

//f_alert($sql);

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);

  if($consulta) {
  	$this->auditar('ANULAR',$sql,'http://localhost/refeciv1.1/vistas/');
  	$msj = "Entrega ha sido anulada satisfactoriamente";
  }
  else $msj = "ERROR: Imposible anular registro de entrega ($consulta)";
  return $consulta;
 }

//Contar entregas Chery
function contarEntregasChery($numlotveh=null,$modelo=null){

 	$sql = "SELECT COUNT(id_numfac)
 	          FROM facturaprof f
		      INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
		      INNER JOIN propietarios c 	 ON (b.codpro = c.codpro)
		      INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
		      INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
		      		INNER JOIN marcas n ON (e.codmarveh = n.codmar)
		      		INNER JOIN modelo m ON (e.codmod = m.codmod)
		      WHERE b.id_asignacion = f.id_asignacion	and f.estatus='A' and f.id_estatus='15' and n.codmar='C7'";

    if($numlotveh) 	$sql.= " AND e.numlotveh = $numlotveh";
    if ($modelo) $sql.= " AND e.codmod ='$modelo'";
 // print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }


}
?>