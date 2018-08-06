<?php
class venta extends conexion{

 function buscarVenta($idventa,$sercarveh=null,$compra=null,$estatus=null,$status_venta=null){

 	$sql = "SELECT a.id_venta, a.sercarveh, c.nomcomp, a.compra , a.estatus ";
	$sql.= ",to_char(a.fecha,'dd/mm/yyyy'), status_venta ";
	$sql.= " FROM venta a, asignacion b, propietarios c ";
	$sql.= " WHERE a.status = 'A' AND a.sercarveh = b.sercarveh AND b.codpro = c.codpro";
    if($idventa)  		$sql.= " AND  a.id_venta=$idventa";
    if($sercarveh)		$sql.= " AND  a.sercarveh='$sercarveh'";
    if($compra )  		$sql.= " AND  a.compra='$compra'";
    if($estatus ) 		$sql.= " AND  a.estatus='$estatus'";
    if($status_venta) 	$sql.= " AND status_venta='$status_venta'";

    $sql=$sql." ORDER BY 1";

// 	print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function contarVentas($idventa,$sercarveh,$beneficiario,$compra,$estatus,$status_venta,$numlotveh,$cod_marca,$cod_modelo,$cod_serie){

 	$sql = "SELECT COUNT(id_venta) FROM venta a".
		   " INNER JOIN asignacion b 	 ON (b.sercarveh = a.sercarveh AND b.status = 'A')".
		   " INNER JOIN propietarios c 	 ON (b.codpro = c.codpro) ".
		   " INNER JOIN vehiculo d 		 ON (d.sercarveh = a.sercarveh) ".
		   " INNER JOIN caracteristica e ON (e.id_caract = d.id_caract) ".
		   " WHERE a.status='A'";
    if($idventa)  	$sql.= " AND id_venta = '$idventa'";
    if($sercarveh)	$sql.= " AND a.sercarveh LIKE '%$sercarveh%'";
    if($compra )  	$sql.= " AND compra = '$compra'";
    if($estatus ) 	$sql.= " AND estatus = '$estatus'";
    if($status_venta) $sql.= " AND status_venta = '$status_venta'";
	if($beneficiario) $sql.= " AND c.nomcomp LIKE '%$beneficiario%'";
	if($numlotveh)  $sql.= " AND e.numlotveh = $numlotveh";
	if($cod_marca)  $sql.= " AND e.codmarveh = '$cod_marca'";
	if($cod_modelo) $sql.= " AND e.codmod = '$cod_modelo'";
	if($cod_serie)	$sql.= " AND e.codserie = '$cod_serie'";

// print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

				   // $id_numfac,$sercarveh,$compra,$estatus,$status_credito,$offset
 function listarVenta($idventa,$sercarveh,$compra,$estatus,$status_venta,$offset){

 	$sql = "SELECT a.id_venta, a.sercarveh, c.nomcomp, ";
	$sql.= "(CASE compra WHEN 'CP' THEN 'Contado Parcial' WHEN 'C' THEN 'Contado Total' WHEN 'RL' THEN 'Crédito Total' WHEN 'R' THEN 'Crédito Parcial' ELSE '' END) AS compra,";
	$sql.= "(CASE status_venta ".
		   " WHEN 'ANA' THEN 'ANÁLISIS'".
		   " WHEN 'DOC' THEN 'DOCUMENTACIÓN' ".
		   " WHEN 'AUT' THEN 'AUTENTICACIÓN' ".
		   " WHEN 'APR' THEN 'APROBADO' ".
		   " WHEN 'LIQ' THEN 'LIQUIDADO' ".
		   " WHEN 'RCH' THEN 'RECHAZADO' ".
		   " WHEN 'PEN' THEN 'PENDIENTE' ".
		   " ELSE '' END) AS stat_venta, ";
	$sql.= "(CASE estatus WHEN 'E' THEN 'Entregado' ELSE 'Pendiente' END) AS estatus, ";
	$sql.= " TO_CHAR(a.fec_mod,'dd/mm/yyyy')".
		   " FROM venta	a, asignacion b, propietarios c WHERE a.status = 'A' ".
			" AND a.sercarveh = b.sercarveh AND b.codpro = c.codpro ";
    if($idventa)  $sql.= " AND id_venta=$idventa";
    if($sercarveh)$sql.= " AND a.sercarveh LIKE '%$sercarveh%'";
    if($compra )  $sql.= " AND compra='$compra'";
    if($estatus ) $sql.= " AND estatus='$estatus'";
    if($status_venta)    $sql.=" AND status_venta='$status_venta'";
    $sql.= " ORDER BY 1 ";
    $sql.= " LIMIT 15 OFFSET ".$offset;

//  print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listarVenta2($idventa,$sercarveh,$beneficiario,$compra,$estatus,$status_venta,$numlotveh,$cod_marca,$cod_modelo,$cod_serie,$offset=null){

 	$sql = "SELECT a.id_venta, a.sercarveh, c.nomcomp, compra, ";
	$sql.= "(CASE status_venta ".
		   " WHEN 'ANA' THEN 'ANÁLISIS'".
		   " WHEN 'DOC' THEN 'DOCUMENTACIÓN' ".
		   " WHEN 'AUT' THEN 'AUTENTICACIÓN' ".
		   " WHEN 'APR' THEN 'APROBADO' ".
		   " WHEN 'LIQ' THEN 'LIQUIDADO' ".
		   " WHEN 'RCH' THEN 'RECHAZADO' ".
		   " WHEN 'PEN' THEN 'PENDIENTE' ".
		   " ELSE '' END) AS stat_venta,";
	$sql.= "(CASE a.estatus WHEN 'E' THEN 'Entregado' ELSE 'Pendiente' END) AS estatus, ";
	$sql.= " TO_CHAR(a.fec_mod,'dd/mm/yyyy'), ".
	       " e.numlotveh ".
		   " FROM venta	a".
		   " INNER JOIN asignacion b ON (a.sercarveh = b.sercarveh AND b.status = 'A')" .
		   " INNER JOIN propietarios c ON (b.codpro = c.codpro) " .
		   " INNER JOIN vehiculo d 		 ON (d.sercarveh = a.sercarveh) ".
		   " INNER JOIN caracteristica e ON (e.id_caract = d.id_caract) ".
		   " WHERE a.status = 'A' ";
    if($idventa)  $sql.= " AND id_venta = $idventa";
    if($sercarveh)$sql.= " AND a.sercarveh LIKE '%$sercarveh%'";
    if($compra )  $sql.= " AND compra = '$compra'";
    if($estatus ) $sql.= " AND estatus = '$estatus'";
    if($status_venta) $sql.= " AND status_venta = '$status_venta'";
	if($beneficiario) $sql.= " AND c.nomcomp LIKE '%$beneficiario%'";
    if($numlotveh)  $sql.= " AND e.numlotveh = $numlotveh";
	if($cod_marca)  $sql.= " AND e.codmarveh = '$cod_marca'";
	if($cod_modelo) $sql.= " AND e.codmod = '$cod_modelo'";
	if($cod_serie)	$sql.= " AND e.codserie = '$cod_serie'";

    $sql.= " ORDER BY 1 ";
    if($offset>=0) $sql.= " LIMIT 15 OFFSET ".$offset;

  //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function migrarVenta($numlotveh,$statusVenta, $modalidad){
    $fecha=date('Y/m/d');

    $sql = "insert into venta (sercarveh, compra, fecha, status_venta)
			(
			select
            m.sercarveh, '".$modalidad."' as compra, to_date('".$fecha."', 'dd/mm/yyyy')  as fecha,'".$statusVenta."' as estatus
			from
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
			asignacion l, vehiculo m, certificados d, placas k,  ptoadu n, propietarios o
			where
			a.codmarveh=b.codmar and
			a.codmod=c.codmod  and
			a.numlotveh=e.numlot and
			a.codconveh=f.codcon and
			a.codclaveh=g.codcla and
			a.codtipveh=h.codtip  and
			a.codusoveh=i.coduso  and
			a.codserveh=j.codser  and
			l.sercarveh=m.sercarveh and
			m.id_caract=a.id_caract and
			d.id_asignacion=l.id_asignacion and
			k.sercarveh=m.sercarveh and
			a.codptoveh=n.codpto  and
			o.codpro=l.codpro and
			m.estatus='A' and l.status='A' and d.estatus='A'
			and a.numlotveh ='".$numlotveh."'
			EXCEPT
			select sercarveh, '".$modalidad."' as compra, to_date('".$fecha."', 'dd/mm/yyyy')  as fecha,'".$statusVenta."' as estatus from venta
		    )" ;
/*
$sql = "INSERT INTO venta (sercarveh, compra, fecha, status_venta)
			(
			SELECT
            m.sercarveh, '".$modalidad."' as compra, to_date('$fecha', 'dd/mm/yyyy')  as fecha,'".$statusVenta."' as estatus
			FROM caracteristica a" .
				" INNER JOIN marcas b 		ON b.codmar = a.codmarveh" .
				" INNER JOIN modelo c 		ON c.codmod = a.codmod" .
				" INNER JOIN certificados d ON d.id_asignacion = l.id_asignacion" .
				" INNER JOIN lote e 		ON e.numlot = a.numlotveh" .
				" INNER JOIN combustible f 	ON f.codcon = a.codconveh" .
				" INNER JOIN clases g 		ON g.codcla = a.codclaveh" .
				" INNER JOIN tipos h 		ON h.codtip = a.codtipveh" .
				" INNER JOIN uso i 			ON i.coduso = a.codusoveh" .
				" INNER JOIN servicios j 	ON j.codser = a.codserveh" .
				" INNER JOIN placas k 		ON k.sercarveh = m.sercarveh" .
				" INNER JOIN asignacion l 	ON l.sercarveh = m.sercarveh" .
				" INNER JOIN vehiculo m 	ON m.id_caract = a.id_caract" .
				" INNER JOIN ptoadu n 		ON n.codpto = a.codptoveh" .
				" INNER JOIN propietarios o ON o.codpro = l.codpro" .
				" WHERE	m.estatus='A' AND l.status='A' AND d.estatus='A' " .
				" AND a.numlotveh = $numlotveh" .
			"EXCEPT	SELECT sercarveh, '".$modalidad."' as compra, " .
			"to_date('$fecha','dd/mm/yyyy')  as fecha,'".$statusVenta."' as estatus from venta)" ;
*/

  f_alert($sql);

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  return $consulta;
 }

  function modificarVenta($sercarveh,$compra,$estatus,$status_venta){
  $fecha = date('d/m/Y');
  $sql ="UPDATE venta SET compra='$compra', estatus='$estatus', status_venta='$status_venta', fec_mod='$fecha'";
  $sql.=" WHERE sercarveh='$sercarveh' ";

//  print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/');
  return $consulta;
 }

					//   $serial,$statusCred, $modalidad, $regExist
 function registrarVenta($serial,$statusVenta, $compra, $regExist,$idAsig=null){

    $conexion = $this->conectar();

 	$sql = "SELECT a.id_venta, a.sercarveh, c.nomcomp, a.compra, a.estatus, " .
 			"to_char(a.fecha,'dd/mm/yyyy'), status_venta  " .
 			"FROM venta a " .
 			"INNER JOIN asignacion b ON b.sercarveh = a.sercarveh " .
 			"INNER JOIN propietarios c ON c.codpro = b.codpro " .
 			"WHERE a.status='A' AND a.sercarveh='$serial'";

//	f_alert($sql);

	$consulta = $this->consultar($conexion,$sql);
	$regExist = $this->ret_vector($consulta);

	if($regExist) {
		$this->desconectar($conexion);
		return false;
	}

    $fecha_reg = date('d/m/Y');

    $sql = "INSERT INTO venta(sercarveh, compra, fecha, status_venta, id_asignacion) VALUES ";
	$sql.= "('$serial','$compra','$fecha_reg','$statusVenta',$idAsig)";

	//print '<pre>'.$sql;

	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
	if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/reg_ventas.php');
	return $consulta;
 }
}
?>
