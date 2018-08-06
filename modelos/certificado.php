<?php
class certificado extends conexion{

 function registrarCertificado($data,$codproa,$num){
  $fecha=date('d/m/Y');
  if ($data[8]=='')$data[8]='01/01/1999';
  $sql = "INSERT INTO certificados(
  		     sercarveh, id_asignacion, numcerveh, fecha_fincon ,numfac1veh ,
             fecfac1veh, nomseg, numpolseg  ,  fecvenpol ,resdom ,
             numcedres ,obspolseg , cert, fecha_reg)
         values
           ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."',
            '".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."','".$fecha."')";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/reg_certificado.php');
  if($consulta) $this->bitacoraBeneficiario($codproa,$data[0],'Certificado de Origen numero: '.$data[2],$_SESSION['usuario']);
  if($consulta) $this->estatusFacturaProfo($num,$codproa,$data[0],'8','','');
  if ($consulta) $consulta=$data[2];
  return $consulta;
 }

 function listarCertificado($id_certificado,$numcerveh,$sercarveh,$codpro,$nomcomp,$numfac1veh,$numlotveh=null,$codmar=null,$codmodveh=null,$codserveh=null,$offset=null){

    $sql = "SELECT
				 a.numcerveh, a.id_certificado, b.sercarveh, b.codpro, c.nomcomp, to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh,
	             to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg, a.fecvenpol, a.resdom,
	             a.numcedres, a.obspolseg, to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
	             substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), a.cert
			FROM certificados a, asignacion b, propietarios c
			WHERE a.estatus='A' AND a.id_asignacion=b.id_asignacion and b.codpro=c.codpro";
	if($id_certificado)  $sql=$sql." AND a.id_certificado=$id_certificado";
	if($numcerveh)  $sql=$sql." AND a.numcerveh like '%$numcerveh%'";
    if($sercarveh)  $sql=$sql." AND b.sercarveh like '%$sercarveh%'";
    if($codpro)  	$sql=$sql." AND b.codpro like '%$codpro%'";
    if($nomcomp)  	$sql=$sql." AND c.nomcomp like '%$nomcomp%'";
    if($numfac1veh) $sql=$sql." AND a.numfac1veh like '%$numfac1veh%'";

    $sql=$sql." ORDER BY a.numcerveh ";
    if($offset) $sql = $sql." LIMIT 20 OFFSET ".$offset;

//   print '<pre>'.$sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listarCertificados($id_certificado,$numcerveh,$sercarveh,$codpro,$nomcomp,$numfac1veh,$numlotveh,$cod_marca,$cod_modelo,$cod_serie,$offset,$tipo=null,$taller=null,$tt=null,$numdep=null,$fec=null,$fec2=null){
    if(!$tipo) $tipo='A';
    $sql = "SELECT
			 a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
             to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
             a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
             substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6)";

	if ($taller or $tt)
 		$sql.= " ,g.nombre,f.falla ";

	$sql.= "  FROM certificados a".
			" INNER JOIN asignacion b ON (a.id_asignacion=b.id_asignacion)".
			" INNER JOIN propietarios c ON (b.codpro=c.codpro)";

	if ($taller or $tt)
		$sql.=  " INNER JOIN (vehiculo d  inner join vehic_taller f
                       INNER JOIN taller g on (g.numtaller=f.id_taller) on d.sercarveh=f.sercarveh) ON (d.sercarveh = a.sercarveh ) ";
	else
		$sql.=  " INNER JOIN vehiculo d ON (d.sercarveh = a.sercarveh) ";


	$sql.=  " INNER JOIN caracteristica e ON (e.id_caract = d.id_caract) ,lote h,departamento i ".
			" WHERE a.estatus='$tipo' and
			    e.numlotveh=h.numlot and
			    h.numdep=i.numdep";

    if($tipo=='A') $sql.= " AND tipmov_txt<>'ME' ";
	if($id_certificado)  $sql.= " AND a.id_certificado=$id_certificado";
	if($numcerveh)  $sql.= " AND a.numcerveh like '%$numcerveh%'";
    if($sercarveh)  $sql.= " AND b.sercarveh like '%$sercarveh%'";
    if($codpro)  	$sql.= " AND b.codpro like '%$codpro%'";
    if($nomcomp)    $sql.= " AND c.nomcomp like '%$nomcomp%'";
    if($numfac1veh) $sql.= " AND a.numfac1veh like '%$numfac1veh%'";
	if($numlotveh)  $sql.= " AND e.numlotveh = $numlotveh";
	if($cod_marca)  $sql.= " AND e.codmarveh = '$cod_marca'";
	if($cod_modelo) $sql.= " AND e.codmod = '$cod_modelo'";
	if($cod_serie)	$sql.= " AND e.codserie = '$cod_serie'";
	if($taller) $sql.= " AND f.id_taller='$taller'";
	if($numdep==5 or $numdep==3 )$numdep=null;
    if ($numdep) $sql = $sql." and  i.numdep='".$numdep."' ";
    if ($fec and $fec2) $sql = $sql." and fecfac1veh BETWEEN '".$fec."' AND '".$fec2."'";
    if ($fec and $fec2==null) $sql = $sql." and fecfac1veh BETWEEN '".$fec."' AND '".$fec."'";
    $sql=$sql." order by a.id_certificado desc";
    if($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;

//print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listarCertificadosRep($id_certificado,$numcerveh,$sercarveh,$codpro,$nomcomp,$numfac1veh,$numlotveh,$cod_marca,$cod_modelo,$cod_serie){


    $sql = "SELECT
			 a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), f.numplaveh,  g.desmar,
             a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
             a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
             substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6)
			FROM certificados a".
			" INNER JOIN asignacion b ON (a.id_asignacion=b.id_asignacion)".
			" INNER JOIN propietarios c ON (b.codpro=c.codpro)".
		    " INNER JOIN vehiculo d 	ON (d.sercarveh = a.sercarveh) ".
		    " INNER JOIN caracteristica e ON (e.id_caract = d.id_caract) ".
		    " INNER JOIN placas f ON (f.sercarveh = a.sercarveh) ".
		    " INNER JOIN marcas g ON (g.codmar = e.codmarveh) ".
			" WHERE a.estatus='A' AND tipmov_txt<>'ME' ";
	if($id_certificado)  $sql.= " AND a.id_certificado=$id_certificado";
	if($numcerveh)  $sql.= " AND a.numcerveh like '%$numcerveh%'";
    if($sercarveh)  $sql.= " AND b.sercarveh like '%$sercarveh%'";
    if($codpro)  	$sql.= " AND b.codpro like '%$codpro%'";
    if($nomcomp)    $sql.= " AND c.nomcomp like '%$nomcomp%'";
    if($numfac1veh) $sql.= " AND a.numfac1veh like '%$numfac1veh%'";
	if($numlotveh)  $sql.= " AND e.numlotveh = $numlotveh";
	if($cod_marca)  $sql.= " AND e.codmarveh = '$cod_marca'";
	if($cod_modelo) $sql.= " AND e.codmod = '$cod_modelo'";
	if($cod_serie)	$sql.= " AND e.codserie = '$cod_serie'";

    $sql=$sql." order by a.id_certificado desc";

   //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function contarCertificado($id_certif,$numcerveh,$sercarveh,$codpro,$nomcomp,$numfac1veh,$numlotveh=null,$cod_marca=null,$cod_modelo=null,$cod_serie=null,$tipo=null,$taller=null,$tt=null,$numdep=null,$fec=null,$fec2=null){
    if(!$tipo) $tipo='A';
    $sql = "SELECT COUNT(a.numcerveh) FROM certificados a".
			" INNER JOIN asignacion b ON (a.id_asignacion=b.id_asignacion)".
			" INNER JOIN propietarios c ON (b.codpro=c.codpro)";

	if ($taller or $tt)
		$sql.=  " INNER JOIN (vehiculo d  inner join vehic_taller f
                       INNER JOIN taller g on (g.numtaller=f.id_taller) on d.sercarveh=f.sercarveh) ON (d.sercarveh = a.sercarveh ) ";
	else
		$sql.=  " INNER JOIN vehiculo d ON (d.sercarveh = a.sercarveh) ";

	$sql.=  " INNER JOIN caracteristica e ON (e.id_caract = d.id_caract),lote h,departamento i ".
			" WHERE a.estatus='$tipo' and
			    e.numlotveh=h.numlot and
			     h.numdep=i.numdep";
    if($tipo=='A') $sql.= " AND tipmov_txt<>'ME' ";
	if($id_certif)  $sql.=" and a.id_certificado=$id_certif";
	if($numcerveh)  $sql.= " and a.numcerveh like '%$numcerveh%'";
    if($sercarveh)  $sql.= " and b.sercarveh like '%strtoupper($sercarveh)%'";
    if($codpro)  	$sql.= " and b.codpro like '%".$codpro."%'";
    if($nomcomp)  	$sql.= " and c.nomcomp like '%strtoupper($nomcomp)%'";
    if($numfac1veh) $sql.= " and a.numfac1veh like '%$numfac1veh%'";
	if($numlotveh)  $sql.= " AND e.numlotveh = $numlotveh";
	if($cod_marca)  $sql.= " AND e.codmarveh = '$cod_marca'";
	if($cod_modelo) $sql.= " AND e.codmod = '$cod_modelo'";
	if($cod_serie)	$sql.= " AND e.codserie = '$cod_serie'";
	if($taller) $sql.= " AND f.id_taller='$taller'";
	if($numdep==5 or $numdep==3 )$numdep=null;
    if ($numdep) $sql = $sql." and  i.numdep='".$numdep."' ";
    if ($fec and $fec2) $sql = $sql." and fecfac1veh BETWEEN '".$fec."' AND '".$fec2."'";
    if ($fec and $fec2==null) $sql = $sql." and fecfac1veh BETWEEN '".$fec."' AND '".$fec."'";

   //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

 function modificarCertificado($id_certificado,$data,$codproa){

  $conexion = $this->conectar();
  $estatus=$this->statusTxt($id_certificado,'');
  $fecha=date('d/m/Y');

  if ($estatus[0] == 'E'){
  	  $sql ="  update certificados set
  		       tipmov_txt='MM' , estatusveh='P' , numenvveh=null , fechatxtveh=null ,  nummodveh=nummodveh+1 where id_certificado=".$id_certificado." ";
  	  $this->consultar($conexion,$sql);
  		    //   print '<pre>'; print $sql;
  	  }

  if ($_SESSION['numcert']!=$data[2] and $estatus[0] == 'E' ){
  	  $fecha=date('d/m/Y');
	  if ($data[8]=='')$data[8]='01/01/1999';
	  $sql = "INSERT INTO certificados(sercarveh,id_asignacion,numcerveh,fecha_fincon,numfac1veh,fecfac1veh,nomseg," .
	  		"numpolseg,fecvenpol,resdom,numcedres ,obspolseg , cert,tipmov_txt, fecha_reg) values " .
	  		"('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]'" .
	  		",'$data[8]','$data[9]','$data[10]','$data[11]','$data[12]','MA','$fecha')";
	  //  print '<pre>'; print $sql;
	      $consultaIns = $this->consultar($conexion,$sql);
		  ///creo uno nuevo y luego le cambio el estatus al anterior
		  $sql ="UPDATE certificados SET tipmov_txt='ME',estatusveh='P',numenvveh=null,fechatxtveh=null,tipmov_pro='ME',estatuspro='P',numenvpro=null,fechatxtpro=null,estatus='E' " .
		  		"WHERE id_certificado=$id_certificado ";
	//    print '<pre>'; print $sql;
  	      $this->consultar($conexion,$sql);
  }else
  {
	  $sql ="UPDATE certificados SET sercarveh='$data[0]',id_asignacion=$data[1]" .
	  		",numcerveh='$data[2]',fecha_fincon='$data[3]',numfac1veh='$data[4]',fecfac1veh='$data[5]'" .
	  		",nomseg='$data[6]',numpolseg='$data[7]',fecvenpol='$data[8]',resdom='$data[9]'" .
	  		",numcedres='$data[10]',obspolseg='$data[11]',cert='$data[12]',fecha_mod='$fecha'";
	  $sql=$sql." WHERE id_certificado=$id_certificado ";
	  //print '<pre>'; print $sql;
  }


  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/reg_certificado.php');
  if($consulta) $this->bitacoraBeneficiario($codproa,$data[0],'Modificación de Certificado de Origen : '.$data[2],$_SESSION['usuario']);
  return $consulta;
 }

  function reporteCertificadoImp($numcerveh){

 	$sql = "select
			to_char(d.fecha_reg,'dd/mm/yyyy'),d.numfac1veh,to_char(d.fecfac1veh,'dd/mm/yyyy'),
			k.numplaveh,b.desmar ,c.desmod ,a.anofabveh ,m.sernivveh, a.anomodveh ,m.serchaveh,
			m.sermotveh, m.sercarveh,  g.descla,h.destip,i.desuso,j.desser, descolor(m.col1veh) as col1,
			descolor(m.col2veh) as col2, a.numpueveh ,a.numejeveh , a.pesveh , a.capcarveh, n.despto,
			a.numlicveh,to_char(a.fecplaveh,'dd/mm/yyyy'), numfacveh,to_char(a.fecfacveh,'dd/mm/yyyy'),
			k.numrafveh, '' as homo,'' as fech, to_char(d.fecha_fincon,'dd/mm/yyyy'),
			o.codpro,d.numfac1veh,to_char(d.fecfac1veh,'dd/mm/yyyy'),o.nomcomp, o.edicaspro, o.calavepro , o.urbbarpro, o.ciudadpro , o.dismunpro ,
			substr(o.tlfcelpro,1,4), substr(o.tlfcelpro,5,7), substr(o.tlfcel2pro,1,4), substr(o.tlfcel2pro,5,7),
			d.nomseg ,d.numpolseg ,d.fecvenpol ,d.resdom , d.numcedres , d.obspolseg, d.numcerveh,d.cert,
			o.codest, o.codmun, o.codpar
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
			m.estatus='A' and l.status='A' and d.estatus='A'";
$sql=$sql." and d.numcerveh='".$numcerveh."'";

 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function reporteCertificadoNac($numcerveh){

 	$sql = "select
			to_char(d.fecha_reg,'dd/mm/yyyy'),d.numfac1veh,to_char(d.fecfac1veh,'dd/mm/yyyy'),
			k.numplaveh,b.desmar ,c.desmod ,a.anofabveh ,m.sernivveh, a.anomodveh ,m.serchaveh,
			m.sermotveh, m.sercarveh,  g.descla,h.destip,i.desuso,j.desser, descolor(m.col1veh) as col1,
			descolor(m.col2veh) as col2, a.numpueveh ,a.numejeveh , a.pesveh , a.capcarveh, '',
			'','', '','',
			k.numrafveh, '' as homo,'' as fech, to_char(d.fecha_fincon,'dd/mm/yyyy'),
			o.codpro,d.numfac1veh,to_char(d.fecfac1veh,'dd/mm/yyyy'),o.nomcomp, o.edicaspro, o.calavepro , o.urbbarpro, o.ciudadpro , o.dismunpro ,
			substr(o.tlfcelpro,1,4), substr(o.tlfcelpro,5,7), substr(o.tlfcel2pro,1,4), substr(o.tlfcel2pro,5,7),
			d.nomseg ,d.numpolseg ,d.fecvenpol ,d.resdom , d.numcedres , d.obspolseg, d.numcerveh,d.cert
			from
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
			asignacion l, vehiculo m, certificados d, placas k,  propietarios o
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
			o.codpro=l.codpro and
			m.estatus='A' and l.status='A' and d.estatus='A' ";
$sql=$sql." and d.numcerveh='".$numcerveh."'";

 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function buscarOrigen($numcerveh){

 	$sql = "select
			a.origenveh
			from
			certificados d, asignacion l, vehiculo m, caracteristica a
			where
			l.sercarveh=m.sercarveh and
			m.id_caract=a.id_caract and
			d.id_asignacion=l.id_asignacion and d.estatus='A'
			 ";
    $sql=$sql." and d.numcerveh='$numcerveh'";

 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

 function catCertificado($sercarveh,$codpro,$nomcomp,$fecha_asig,$certificado,$offset){

 	$sql = "select
			a.sercarveh ,  a.codpro , trim(b.nomcomp),  to_char(a.fecha_asig,'dd/mm/yyyy'), a.id_asignacion, a.status, a.fecha_lib, substr(a.codpro,1,1),d.numcerveh
			from
			asignacion a, propietarios b, certificados d
			where
			a.status='A' and d.estatus='A' and a.codpro=b.codpro and d.id_asignacion=a.id_asignacion ";
    if($certificado)$sql.=" and d.numcerveh like '%$certificado%' ";
    if($sercarveh)  $sql.=" and a.sercarveh like '%$sercarveh%'";
    if($codpro)  	$sql.=" and a.codpro like '%".$codpro."%'";
    if($nomcomp)  	$sql.=" and b.nomcomp like '%$nomcomp%' ";
    if($fecha_asig) $sql.=" and a.fecha_asig='$fecha_asig'";

    $sql.= " ORDER BY d.numcerveh";
    $sql.= " LIMIT 20 OFFSET ".$offset;

 //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


 function registrarSeguro($numcerveh,$data,$codproc,$sercarveh){
  $fecha=date('d/m/Y');
  $sql ="  update certificados set
  		     nomseg='$data[1]',numpolseg='$data[2]',fecvenpol='$data[3]',fecha_mod='$fecha'";
  $sql .= " where numcerveh='$numcerveh'";
 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/reg_seguro.php');
  if($consulta) $this->bitacoraBeneficiario($codproc,$sercarveh,'Registro del Seguro '.$data[1].' - '.$data[2].' del certificado: '.$numcerveh,$_SESSION['usuario']);
  if ($consulta) $consulta=$numcerveh;
  return $consulta;
 }

  function registrarReserva($numcerveh,$data,$codproc,$sercarveh){
  $fecha=date('d/m/Y');
  $sql = "  update certificados set
  		     resdom='$data[1]',numcedres='$data[2]',obspolseg='$data[3]',fecha_mod='$fecha'";
  $sql.= " where numcerveh='$numcerveh'";
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/reg_seguro.php');
  if($consulta) $this->bitacoraBeneficiario($codproc,$sercarveh,'Registro de reserva de Dominio: '.$data[1].' - '.$data[2].' del certificado: '.$numcerveh,$_SESSION['usuario']);
   if ($consulta) $consulta=$numcerveh;
  return $consulta;
 }

 function listarCertificadosMemo($id_certificado,$numcerveh,$sercarveh,$codpro,$nomcomp,$numfac1veh,$numlotveh,$cod_marca,$cod_modelo,$cod_serie,$offset,$tipo=null,$taller=null,$tt=null,$numdep=null){
    if(!$tipo) $tipo='A';
    $sql = "SELECT
			 a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
             to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
             a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
             substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), l.id_banco";


	$sql.= "  FROM certificados a".
			" INNER JOIN asignacion b ON (a.id_asignacion=b.id_asignacion)".
			" INNER JOIN propietarios c ON (b.codpro=c.codpro)".
			" INNER JOIN facturaprof l ON (a.id_asignacion=l.id_asignacion)";

	if ($taller or $tt)
		$sql.=  " INNER JOIN (vehiculo d  inner join vehic_taller f
                       INNER JOIN taller g on (g.numtaller=f.id_taller) on d.sercarveh=f.sercarveh) ON (d.sercarveh = a.sercarveh ) ";
	else
		$sql.=  " INNER JOIN vehiculo d ON (d.sercarveh = a.sercarveh) ";


	$sql.=  " INNER JOIN caracteristica e ON (e.id_caract = d.id_caract) ,lote h,departamento i ".
			" WHERE a.estatus='$tipo' and l.estatus='A' and
			    e.numlotveh=h.numlot and
			    h.numdep=i.numdep and l.condpago in ('CREDITO','COMPLETO')";

    if($tipo=='A') $sql.= " AND tipmov_txt<>'ME' ";
	if($id_certificado)  $sql.= " AND a.id_certificado=$id_certificado";
	if($numcerveh)  $sql.= " AND a.numcerveh like '%$numcerveh%'";
    if($sercarveh)  $sql.= " AND b.sercarveh like '%$sercarveh%'";
    if($codpro)  	$sql.= " AND b.codpro like '%$codpro%'";
    if($nomcomp)    $sql.= " AND c.nomcomp like '%$nomcomp%'";
    if($numfac1veh) $sql.= " AND a.numfac1veh like '%$numfac1veh%'";
	if($numlotveh)  $sql.= " AND e.numlotveh = $numlotveh";
	if($cod_marca)  $sql.= " AND e.codmarveh = '$cod_marca'";
	if($cod_modelo) $sql.= " AND e.codmod = '$cod_modelo'";
	if($cod_serie)	$sql.= " AND e.codserie = '$cod_serie'";
	if($taller) $sql.= " AND f.id_taller='$taller'";
	if($numdep==5 or $numdep==3 )$numdep=null;
    if ($numdep) $sql = $sql." and  i.numdep='".$numdep."' ";

    $sql=$sql." order by a.id_certificado desc";
    if($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;

//print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function registrarMemoCert($nummemo,$banco,$atencion,$nota,$detalleMemo){

    $conexion = $this->conectar();

	$fecha=date('d/m/Y');
	$hora=date('H:i:s');

	$sql = "SELECT MAX(id_memocert) FROM memocert ";
    $consulta = $this->consultar($conexion,$sql);
    $contF = $this->ret_vector($consulta);
    $id = $contF[0]+1;

	$sql = "INSERT INTO memocert(	id_memocert, nummem, fecha, hora, id_banco ,observacion , atencion, usuario_estatus)
             values
             ('".$id."','".$nummemo."','".$fecha."','".$hora."','".$banco."','".$nota."','".$atencion."','".$_SESSION['usuario']."')";
    //print '<pre>'; print $sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);

    if($consulta){

  	    $sql = "INSERT INTO detmemocert";
		$sql = $sql."(id_memocert ,  numcerveh ) VALUES ";
	    for($i=0;$i<count($detalleMemo)-19;$i+=19){
		    $sql = $sql. "('".$id."','".$detalleMemo[$i]."'),";
	    }
            $sql = $sql. "('".$id."','".$detalleMemo[$i]."')";
   // print $sql;

    $consulta = $this->consultar($conexion,$sql);
    }

	$this->desconectar($conexion);
    if($consulta)
    {
      $this->auditar($_SESSION['usuario'],'CERTIFICADO','Registro expediente de certificado con el numero. '.$id);
       //Registro Forma de pago Oferta C.
	  return $id;
    }else return false;

 }


 function listarMemo($id_memocert){

    $sql = " SELECT  a.id_memocert, a.nummem, a.fecha, a.hora, a.id_banco , a.observacion , a.atencion from memocert a ";
    $sql=$sql." where a.status='A' ";
    if($id_memocert)	$sql.= " AND a.id_memocert = '$id_memocert' ";

//print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


 function listarDetMemo($id_memocert){

    $sql = "
			SELECT
			a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
			to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
			a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
			substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), l.id_banco
			FROM   certificados a
			INNER JOIN asignacion b ON (a.id_asignacion=b.id_asignacion)
			INNER JOIN propietarios c ON (b.codpro=c.codpro)
			INNER JOIN facturaprof l ON (a.id_asignacion=l.id_asignacion)
			INNER JOIN vehiculo d ON (d.sercarveh = a.sercarveh)
			INNER JOIN caracteristica e ON (e.id_caract = d.id_caract) ,
			memocert f ,
			detmemocert g ,
			lote h,
			departamento i
			WHERE
			a.estatus='A' and l.estatus='A' and
			e.numlotveh=h.numlot and
			h.numdep=i.numdep and l.condpago in ('CREDITO','COMPLETO')
			and g.id_memocert = f.id_memocert
			and g.numcerveh = a.numcerveh
           ";
     if($id_memocert)	$sql.= " AND f.id_memocert = '$id_memocert' ";

//print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function contarMemo($id_memocert,$desde,$hasta,$certificado,$banco,$rif,$usuario=null){


    $sql = " select count(z.cuenta) from (SELECT
			distinct(f.id_memocert) as cuenta, f.fecha, f.observacion,l.id_banco, f.id_memocert
			FROM   certificados a
			INNER JOIN asignacion b ON (a.id_asignacion=b.id_asignacion)
			INNER JOIN propietarios c ON (b.codpro=c.codpro)
			INNER JOIN facturaprof l ON (a.id_asignacion=l.id_asignacion)
			INNER JOIN vehiculo d ON (d.sercarveh = a.sercarveh)
			INNER JOIN caracteristica e ON (e.id_caract = d.id_caract) ,
			memocert f ,
			detmemocert g ,
			lote h,
			departamento i
			WHERE
			a.estatus='A' and f.status='A' and
			e.numlotveh=h.numlot and
			h.numdep=i.numdep and l.condpago in ('CREDITO','COMPLETO')
			and g.id_memocert = f.id_memocert
			and g.numcerveh = a.numcerveh ";


    if ($id_memocert)	$sql.= " AND f.id_memocert = '$id_memocert' ";
    if ($banco) $sql.= " AND f.id_banco = '$banco' ";
    if ($certificado) $sql.= " AND g.numcerveh = '$certificado' ";

    if($desde AND !$hasta) $sql.= " and f.fecha >= '".$desde."'";
	else if (!$desde AND  $hasta) $sql.= " and f.fecha <= '".$hasta."'";
	else if ($desde  AND  $hasta)	$sql = $sql." and  f.fecha BETWEEN '".$desde."' AND '".$hasta."'";
    if ($rif) $sql.= " AND b.codpro like '%$rif%' ";
    if ($usuario) $sql.= " AND f.usuario_estatus like '%$usuario%' ";

	$sql.= "order by f.id_memocert) z ";

 // print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listarMemo1($id_memocert,$desde,$hasta,$certificado,$banco,$rif,$offset,$usuario){

		$sql =	"SELECT
			distinct(f.id_memocert), f.fecha, f.observacion,l.id_banco, f.id_memocert, count(g.id_memocert),f.usuario_estatus
			FROM   certificados a
			INNER JOIN asignacion b ON (a.id_asignacion=b.id_asignacion)
			INNER JOIN propietarios c ON (b.codpro=c.codpro)
			INNER JOIN facturaprof l ON (a.id_asignacion=l.id_asignacion)
			INNER JOIN vehiculo d ON (d.sercarveh = a.sercarveh)
			INNER JOIN caracteristica e ON (e.id_caract = d.id_caract) ,
			memocert f ,
			detmemocert g ,
			lote h,
			departamento i
			WHERE
			a.estatus='A' and f.status='A' and
			e.numlotveh=h.numlot and
			h.numdep=i.numdep and l.condpago in ('CREDITO','COMPLETO')
			and g.id_memocert = f.id_memocert
			and g.numcerveh = a.numcerveh ";


    if ($id_memocert)	$sql.= " AND f.id_memocert = '$id_memocert' ";
    if ($banco) $sql.= " AND f.id_banco = '$banco' ";
    if ($certificado) $sql.= " AND g.numcerveh = '$certificado' ";
    if ($rif) $sql.= " AND b.codpro like '%$rif%' ";

    if($desde AND !$hasta) $sql.= " and f.fecha >= '".$desde."'";
	else if (!$desde AND  $hasta) $sql.= " and f.fecha <= '".$hasta."'";
	else if ($desde  AND  $hasta)	$sql = $sql." and  f.fecha BETWEEN '".$desde."' AND '".$hasta."'";

	if ($usuario) $sql.= " AND f.usuario_estatus like '%$usuario%' ";

    $sql.= " GROUP BY f.id_memocert, f.fecha, f.observacion, l.id_banco, f.id_memocert,f.usuario_estatus ";
	$sql.= " order by f.id_memocert desc";
	if($offset>=0) $sql = $sql." LIMIT 20 OFFSET ".$offset;

  //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
}
?>