<?php
class factura extends conexion{

  function entrega($id_asignacion){

 	$sql = "select a.fecha_ent, a.lugar, a.acto, b.fecha_fincon from entrega as a, certificados as b " .
 			"where b.id_asignacion=".$id_asignacion." and a.status='A' and a.id_asignacion=b.id_asignacion";
	//echo $sql;
  	$conexion = $this->conectar();
  	$consulta = $this->consultar($conexion,$sql);
  	$consulta = $this->ret_vector($consulta);
  	$this->desconectar($conexion);

  return $consulta;
 }

  function envio($id_asignacion){

 	$sql = "select to_date(fechatxtveh,'DD/MM/YYYY') as fecha, numenvveh from certificados " .
 			"where id_asignacion=".$id_asignacion." and estatus='A' and estatusveh='E'";
	//echo $sql;
  	$conexion = $this->conectar();
  	$consulta = $this->consultar($conexion,$sql);
  	$consulta = $this->ret_vector($consulta);
  	$this->desconectar($conexion);

  return $consulta;
 }

 function registrarFactura($data,$codproa,$comentario=null){
    $conexion = $this->conectar();

    $fecha=date('d/m/Y');

    $sql = "SELECT MAX(id_numfac) FROM facturaprof ";
    $consulta = $this->consultar($conexion,$sql);
    $contF = $this->ret_vector($consulta);
    $id_F = $contF[0]+1;

    if ($data[6])
    	$preinv=$data[6];
    else
    	$preinv = 'Null';

    if (($data[4]=='COMPLETO') and ($data[6]))
    {
    	//echo "Es completo";

    	$sqlP = "SELECT precio_min FROM preinventario where id_preinv =".$data[6]." ";
    	$consultaP = $this->consultar($conexion,$sqlP);
    	$precioP = $this->ret_vector($consultaP);
    	$precio = $precioP[0];
    	//echo "El precio es: ".$precio;
    }

    $sql = "INSERT INTO facturaprof(
  		     id_numfac, id_asignacion ,  sercarveh  ,exento , iva ,condpago, fecfac, id_estatus, usuario_estatus, fecha_estatus, id_banco, id_concesionario, id_preinv";


    if (($comentario) and (!$precio)) $sql.= " , observacion)";
    elseif	(($comentario) and ($precio)) $sql.= " , observacion, monto)";
    else $sql.= ' )';


    $sql.= "values (".$id_F.",'".$data[0]."','".$data[1]."',".$data[2].",'".$data[3]."','".$data[4]."','".$fecha."','1','".$_SESSION['usuario']."','".$fecha."','".$data[5]."','1',$preinv";

    if (($comentario) and (!$precio)) $sql.= ", '".$comentario."')";
    elseif	(($comentario) and ($precio)) $sql.= ", '".$comentario."',".$precio." )";
    else $sql.= ' )';


  //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  if ($consulta) $consulta=$id_F;
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/reg_factura.php');
  if($consulta) $this->bitacoraBeneficiario($codproa,$data[1],'Registro Factura Proforma N#: '.$id_F,$_SESSION['usuario']);
  if($consulta) $this->statusProforma($id_F,'1',$_SESSION['usuario']);
  return $consulta;
 }

 function listarFactura($id_numfac,$sercarveh,$desfecfac,$hasfecfac){

 	$sql = "select
			a.id_numfac, a.id_asignacion , b.sercarveh ,a.exento,to_char(a.fecfac,'dd/mm/yyyy') , a.iva ,a.condpago ,a.estatus,
			b.codpro,c.nomcomp, a.id_estatus, a.usuario_estatus, a.fecha_estatus, a.id_banco, a.id_concesionario
			from
			facturaprof a, asignacion  b, propietarios c
			where
			a.estatus='A' and
			a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro";
    if($id_numfac)  $sql=$sql." and a.id_numfac='".$id_numfac."'";
    if($sercarveh)  $sql=$sql." and b.sercarveh='".$sercarveh."'";
    if($desfecfac and $hasfecfac){
       $sql = $sql." and  a.fecfac BETWEEN '".$desfecfac."' AND '".$hasfecfac."'";
    }
    $sql=$sql." order by a.id_numfac";

 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listarFacturas($id_numfac,$sercarveh,$desfecfac,$hasfecfac,$offset,$codpro,$nombre,$tipo=null,$estatus=null, $banco=null ,$usuario=null,$cond=null,
 $sig=null, $dia=null ,$edad=null ,$estado=null,$sexo=null,$diat=null,$codmar=null,$codmodveh=null,$codserveh=null,$numlotveh=null,$numplaveh=null,$taller=null,
 $tt=null,$desfec_estatus=NULL,$hasfec_estatus=NULL,$tipoentrega=null,$tipo_benef=null,$desfecfacori=null,$hasfecfacori=null,$numfacori=null,$preinv=null,
 $color=null,$lista=null,$comentario=null,$acto=null,$todoacto=null,$cert=null,$tipoB=null,$riflab=null,$deslab=null){

   // echo $lista;
    if ($sig=='1') $sig='<=';else $sig='=';
    if(!$tipo) $tipo='A';
 	$sql = "select
			a.id_numfac, a.id_asignacion , b.sercarveh ,a.exento,to_char(a.fecfac,'dd/mm/yyyy') , a.iva ,a.condpago ,a.estatus,
			b.codpro,c.nomcomp, a.id_estatus, a.usuario_estatus, a.fecha_estatus, a.id_banco, a.id_concesionario,a.id_concesionario, d.banco_descrip," .
					" e.descripcion,f.nomest,g.dessexo,
            Extract(year from age(now(),c.fecnac)) as edad, to_char((fecfac+30),'dd/mm/yyyy') as fecven, abs(cast (to_char(fecfac-now(),'dd') as int )) as diastrans,
			(30+((cast (to_char(fecfac-now(),'dd') as int ))+1)) as diasrestantes,k.desmar,l.desmod,m.desserie,j.numlotveh,h.numplaveh,to_char(a.fecha_estatus,'dd/mm/yyyy'),r.descripcion as tipo_benef,to_char(o.fecfac1veh,'dd/mm/yyyy')as fecfacori,o.numfac1veh,
			a.montosol,a.monto,a.plazo,a.tasa,a.tipagomens,a.tipagosem,a.tipagoanual,a.gastos,a.gastosadmin,a.gastostimbre,a.exonerado,c.riflab,c.deslab ";
    //if ($comentario) $sql.= ", a.observacion";
	if ($taller or $tt)
 		$sql.= " ,ta.nombre,vt.falla ";

    $sql.="	,a.id_preinv,p.descol " ;
        if ($lista) $sql.=", (select z.desmod
			from preinventario  x, modelo z
			where x.id_modelo=z.codmod and id_preinv=a.id_preinv) as predesmod ";

    //if ($comentario) $sql.= ", a.observacion";

    if ($acto or $todoacto) $sql.= " , (select w.fecha from acto w where w.idacto='$acto') ";
    $sql.= " , c.tlfcelpro, c.tlfcel2pro,a.observacion ";
    if ($cert) $sql.= " , o.numcerveh ";
    $sql.="from
			asignacion  b,";

		if ($taller or $tt)
			$sql.= " vehiculo i left outer join placas h  on h.sercarveh=i.sercarveh
	           inner join ( vehic_taller vt
			INNER JOIN taller ta on ta.numtaller=vt.id_taller) on i.sercarveh=vt.sercarveh, ";
       		 else
        	$sql.= " vehiculo i
			left outer join placas h  on h.sercarveh=i.sercarveh," ;
		//if ($lista) $sql.=" preinventario z left outer join modelo l on l.codmod = z.id_modelo,";

    $sql.= "caracteristica j
			left outer join marcas k on k.codmar=j.codmarveh
	        left outer join modelo l  on l.codmod=j.codmod
	        left outer join serie m  on m.codserie=j.codserie,
			propietarios c
		    left outer join tipo_benef r on r.codtipben=c.tipo
			left outer join zona_estado f on f.codest=c.codest
			left outer join sexo g on g.codsexo=c.sexo,
			facturaprof a
			left outer join banco d on d.id_banco=a.id_banco
			left outer join estatus e on e.id_estatus=a.id_estatus
			left outer join certificados o on o.id_asignacion=a.id_asignacion and o.tipmov_txt='MA' AND o.estatus='A',
			lote n,color p ";

    if ($tipoentrega or $acto or $todoacto) $sql.=", entrega z ";

	$sql.= "where
			j.numlotveh=n.numlot and
			i.id_caract=j.id_caract and
			b.sercarveh=i.sercarveh and
			a.estatus='$tipo' and
			a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro
		 and p.codcol=i.col1veh";

    if($id_numfac)  $sql=$sql." and a.id_numfac='".$id_numfac."'";
    if($sercarveh=='0')  $sql=$sql." and b.sercarveh='0' "; else  if($sercarveh)  $sql=$sql." and b.sercarveh like '%".$sercarveh."%'";
    if($tipoentrega) $sql.=" and a.id_asignacion=z.id_asignacion and z.tipoe='$tipoentrega'";

    if($desfecfac AND !$hasfecfac) $sql.= " and a.fecfac >= '".$desfecfac."'";
	else if (!$desfecfac AND  $hasfecfac) $sql.= " and a.fecfac <= '".$hasfecfac."'";
	else if ($desfecfac  AND  $hasfecfac)	$sql = $sql." and  a.fecfac BETWEEN '".$desfecfac."' AND '".$hasfecfac."'";

    if($codpro)  $sql=$sql." and c.codpro like '%".$codpro."%'";
    if($nombre)  $sql=$sql." and c.nomcomp like '%".$nombre."%'";
     if($tipo_benef)  $sql=$sql." and c.tipo='".$tipo_benef."'";
    if($estatus)  $sql=$sql." and a.id_estatus='".$estatus."'";
    if($banco)  $sql=$sql." and a.id_banco='".$banco."'";
    if($usuario)  $sql=$sql." and a.usuario_estatus='".$usuario."'";

    if($cond){
    	if ($cond=='CREDITOS') // OR $cond=='CREDITO' )
    		$sql=$sql." and ((a.condpago='CREDITO') or (a.condpago='COMPLETO')  ) ";
    	else
    		$sql=$sql." and a.condpago='".$cond."'";
    }
    if($dia)  $sql=$sql."  and (30+((cast (to_char(fecfac-now(),'dd') as int ))+1))$sig'".$dia."'";
    if($diat)  $sql=$sql."  and abs(cast (to_char(fecfac-now(),'dd') as int ))$sig'".$diat."'";
    if($edad)  $sql=$sql." and Extract(year from age(now(),c.fecnac))$sig'".$edad."'";
    if($estado)  $sql=$sql." and c.codest='".$estado."'";
    if($sexo)  $sql=$sql." and c.sexo='".$sexo."'";
    if($codmar)  $sql=$sql." and j.codmarveh='".$codmar."'";
    if($codmodveh)  $sql=$sql." and j.codmod='".$codmodveh."'";
    if($codserveh)  $sql=$sql." and j.codserie='".$codserveh."'";
    if($numlotveh)  $sql=$sql." and j.numlotveh='".$numlotveh."'";
    if($numplaveh)  $sql=$sql." and h.numplaveh  like '%".$numplaveh."%'";
    if($preinv)  $sql=$sql." and a.id_preinv =".$preinv." ";
    if($tipoB==1)   $sql=$sql." and (c.codpro like '%V%' or c.codpro like '%E%')";
    if($tipoB==2)   $sql=$sql." and (c.codpro like '%J%' or c.codpro like '%G%')";
    if($riflab)  $sql=$sql." and c.riflab like '%".$riflab."%'";
     if($deslab)  $sql=$sql." and c.deslab like '%".$deslab."%'";


    if($desfec_estatus AND !$hasfec_estatus) $sql.= " and a.fecha_estatus >= '".$desfec_estatus."'";
	else if (!$desfec_estatus AND  $hasfec_estatus) $sql.= " and a.fecha_estatus <= '".$hasfec_estatus."'";
	else if ($desfec_estatus  AND  $hasfec_estatus)	$sql.= " and a.fecha_estatus BETWEEN '".$desfec_estatus."' AND '".$hasfec_estatus."'";

    if($desfecfacori AND !$hasfecfacori) $sql.= " and o.fecfac1veh >= '".$desfecfacori."'";
	else if (!$desfecfacori AND  $hasfecfacori) $sql.= " and o.fecfac1veh <= '".$hasfecfacori."'";
	else if ($desfecfacori and $hasfecfacori)	$sql.= " and o.fecfac1veh BETWEEN '".$desfecfacori."' AND '".$hasfecfacori."'";


    if($numfacori)  $sql=$sql." and o.numfac1veh='".$numfacori."'";
    if($taller) $sql.= " and vt.id_taller='$taller'";
    if($color) $sql.= " and i.col1veh='".$color."'";

    if ($acto or $todoacto) $sql.=" and a.id_asignacion=z.id_asignacion and z.acto='$acto'";


    $sql=$sql." order by a.fecfac desc, a.id_numfac desc ";
    if($offset>=0) $sql = $sql." LIMIT 50 OFFSET ".$offset;

  //print '<pre>'; print $sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listarFacturas_consuelo($id_numfac,$sercarveh,$desfecfac,$hasfecfac,$offset,$codpro,$nombre,$tipo=null,$estatus=null, $banco=null ,$usuario=null,$cond=null, $sig=null, $dia=null ,$edad=null ,$estado=null,$sexo=null,$diat=null,$codmar=null,$codmodveh=null,$codserveh=null,$numlotveh=null,$numplaveh=null,$taller=null,$tt=null,$desfec_estatus=NULL,$hasfec_estatus=NULL,$tipoentrega=null,$tipo_benef=null,$desfecfacori=null,$hasfecfacori=null,$numfacori=null,$preinv=null,$color=null,$lista=null,$comentario=null,$riflab=null,$deslab=null,$obs=null){

 	$sql = "select
					c.nomcomp,b.codpro,l.desmod,p.descol,h.numplaveh,b.sercarveh , d.banco_descrip,c.tlfcelpro,c.tlfcel2pro,
					e.descripcion,
					j.numlotveh,
					r.descripcion as tipo_benef,
					(select  fecha from movi_proforma where id_movi_pro=(select  max(id_movi_pro) from movi_proforma where id_numfac=a.id_numfac) ) as fecha,
					(select  hora from movi_proforma where id_movi_pro=(select  max(id_movi_pro) from movi_proforma where id_numfac=a.id_numfac) ) as hora,
				    i.etiqueta,c.obspro,s.id_ubicacion,s.ubicacion_descrip,t.id_almacen,t.almacen_descrip,u.nivel,i.observaciones,i.estatus,f.nomest
					from
					asignacion  b, vehiculo i
					left outer join ubicacion s on s.id_ubicacion=i.id_ubicacion
					left outer join nivel_pdi u on u.id=i.nivel_pdi
				    left outer join almacen t on t.id_almacen=s.id_almacen
					left outer join placas h  on h.sercarveh=i.sercarveh,
					caracteristica j
					left outer join marcas k on k.codmar=j.codmarveh
					left outer join modelo l  on l.codmod=j.codmod
					left outer join serie m  on m.codserie=j.codserie,
					propietarios c
					left outer join tipo_benef r on r.codtipben=c.tipo
					left outer join zona_estado f on f.codest=c.codest
					left outer join sexo g on g.codsexo=c.sexo,
					facturaprof a
					left outer join banco d on d.id_banco=a.id_banco
					left outer join estatus e on e.id_estatus=a.id_estatus
					left outer join certificados o on o.id_asignacion=a.id_asignacion AND o.estatus='A',
					lote n,color p
					where
				    i.estatus='A' AND
					j.numlotveh=n.numlot and
					i.id_caract=j.id_caract and
					b.sercarveh=i.sercarveh and
					a.estatus='A' and
					a.id_asignacion=b.id_asignacion and
					b.codpro=c.codpro
					and p.codcol=i.col1veh and
					((a.id_estatus='8' and  a.condpago='CONTADO') or ((a.id_estatus='14' or a.id_estatus='33' ) and  a.condpago='CREDITO') or ((a.id_estatus='14' or a.id_estatus='33' ) and  a.condpago='COMPLETO')  or (a.id_estatus='22' and ((a.condpago='COMPLETO') or (a.condpago='CREDITO')) ))   ";

    if($numlotveh)  $sql=$sql." and j.numlotveh='".$numlotveh."'"; else $sql=$sql." and (j.numlotveh='14' or j.numlotveh='15' or j.numlotveh='16' or j.numlotveh='17')  ";
    if($id_numfac)  $sql=$sql." and a.id_numfac='".$id_numfac."'";
    if($sercarveh=='0')  $sql=$sql." and b.sercarveh='0' "; else  if($sercarveh)  $sql=$sql." and b.sercarveh like '%".$sercarveh."%'";
    if($tipoentrega) $sql.=" and a.id_asignacion=z.id_asignacion and z.tipoe='$tipoentrega'";

    if($desfecfac AND !$hasfecfac) $sql.= " and a.fecfac >= '".$desfecfac."'";
	else if (!$desfecfac AND  $hasfecfac) $sql.= " and a.fecfac <= '".$hasfecfac."'";
	else if ($desfecfac  AND  $hasfecfac)	$sql = $sql." and  a.fecfac BETWEEN '".$desfecfac."' AND '".$hasfecfac."'";

    if($codpro)  $sql=$sql." and c.codpro like '%".$codpro."%'";
    if($nombre)  $sql=$sql." and c.nomcomp like '%".$nombre."%'";
     if($tipo_benef)  $sql=$sql." and c.tipo='".$tipo_benef."'";
    if($banco)  $sql=$sql." and a.id_banco='".$banco."'";
    if($usuario)  $sql=$sql." and a.usuario_estatus='".$usuario."'";

    if($dia)  $sql=$sql."  and (30+((cast (to_char(fecfac-now(),'dd') as int ))+1))$sig'".$dia."'";
    if($diat)  $sql=$sql."  and abs(cast (to_char(fecfac-now(),'dd') as int ))$sig'".$diat."'";
    if($edad)  $sql=$sql." and Extract(year from age(now(),c.fecnac))$sig'".$edad."'";
    if($estado)  $sql=$sql." and c.codest='".$estado."'";
    if($sexo)  $sql=$sql." and c.sexo='".$sexo."'";
    if($codmar)  $sql=$sql." and j.codmarveh='".$codmar."'";
    if($codmodveh)  $sql=$sql." and j.codmod='".$codmodveh."'";
    if($codserveh)  $sql=$sql." and j.codserie='".$codserveh."'";

    if($numplaveh)  $sql=$sql." and h.numplaveh  like '%".$numplaveh."%'";
    if($preinv)  $sql=$sql." and a.id_preinv =".$preinv." ";
    if($riflab)  $sql=$sql." and c.riflab like '%".$riflab."%'";
    if($deslab)  $sql=$sql." and c.deslab like '%".$deslab."%'";


    if($desfec_estatus AND !$hasfec_estatus) $sql.= " and a.fecha_estatus >= '".$desfec_estatus."'";
	else if (!$desfec_estatus AND  $hasfec_estatus) $sql.= " and a.fecha_estatus <= '".$hasfec_estatus."'";
	else if ($desfec_estatus  AND  $hasfec_estatus)	$sql.= " and a.fecha_estatus BETWEEN '".$desfec_estatus."' AND '".$hasfec_estatus."'";

    if($desfecfacori AND !$hasfecfacori) $sql.= " and o.fecfac1veh >= '".$desfecfacori."'";
	else if (!$desfecfacori AND  $hasfecfacori) $sql.= " and o.fecfac1veh <= '".$hasfecfacori."'";
	else if ($desfecfacori and $hasfecfacori)	$sql.= " and o.fecfac1veh BETWEEN '".$desfecfacori."' AND '".$hasfecfacori."'";


    if($numfacori)  $sql=$sql." and o.numfac1veh='".$numfacori."'";
    if($taller) $sql.= " and vt.id_taller='$taller'";
    if($color) $sql.= " and i.col1veh='".$color."'";
    if ($obs) $sql.=" and c.obspro like '%".$obs."%'";

    $sql=$sql."  order by
		          (select  fecha from movi_proforma where id_movi_pro=(select  max(id_movi_pro) from movi_proforma where id_numfac=a.id_numfac) ) ,
			      (select  hora from movi_proforma where id_movi_pro=(select  max(id_movi_pro) from movi_proforma where id_numfac=a.id_numfac) ) ";
    if($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;

  //print '<pre>'; print $sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function contarFacturas_consuelo($id_numfac,$sercarveh,$desfecfac,$hasfecfac,$offset,$codpro,$nombre,$tipo=null,$estatus=null, $banco=null ,$usuario=null,$cond=null, $sig=null, $dia=null ,$edad=null ,$estado=null,$sexo=null,$diat=null,$codmar=null,$codmodveh=null,$codserveh=null,$numlotveh=null,$numplaveh=null,$taller=null,$tt=null,$desfec_estatus=NULL,$hasfec_estatus=NULL,$tipoentrega=null,$tipo_benef=null,$desfecfacori=null,$hasfecfacori=null,$numfacori=null,$preinv=null,$color=null,$lista=null,$comentario=null,$riflab=null,$deslab=null,$obs=null){

 	$sql = "select
					count(b.sercarveh ) from
					asignacion  b, vehiculo i
					left outer join ubicacion s on s.id_ubicacion=i.id_ubicacion
					left outer join nivel_pdi u on u.id=i.nivel_pdi
				    left outer join almacen t on t.id_almacen=s.id_almacen
					left outer join placas h  on h.sercarveh=i.sercarveh,
					caracteristica j
					left outer join marcas k on k.codmar=j.codmarveh
					left outer join modelo l  on l.codmod=j.codmod
					left outer join serie m  on m.codserie=j.codserie,
					propietarios c
					left outer join tipo_benef r on r.codtipben=c.tipo
					left outer join zona_estado f on f.codest=c.codest
					left outer join sexo g on g.codsexo=c.sexo,
					facturaprof a
					left outer join banco d on d.id_banco=a.id_banco
					left outer join estatus e on e.id_estatus=a.id_estatus
					left outer join certificados o on o.id_asignacion=a.id_asignacion AND o.estatus='A',
					lote n,color p
					where
					i.estatus='A' AND
					j.numlotveh=n.numlot and
					i.id_caract=j.id_caract and
					b.sercarveh=i.sercarveh and
					a.estatus='A' and
					a.id_asignacion=b.id_asignacion and
					b.codpro=c.codpro
					and p.codcol=i.col1veh and
				((a.id_estatus='8' and  a.condpago='CONTADO') or ((a.id_estatus='14' or a.id_estatus='33' ) and  a.condpago='CREDITO') or ((a.id_estatus='14' or a.id_estatus='33' ) and  a.condpago='COMPLETO')  or (a.id_estatus='22' and ((a.condpago='COMPLETO') or (a.condpago='CREDITO')) ))   ";

    if($numlotveh)  $sql=$sql." and j.numlotveh='".$numlotveh."'"; else $sql=$sql." and (j.numlotveh='14' or j.numlotveh='15' or j.numlotveh='16' or j.numlotveh='17')  ";
    if($id_numfac)  $sql=$sql." and a.id_numfac='".$id_numfac."'";
    if($sercarveh=='0')  $sql=$sql." and b.sercarveh='0' "; else  if($sercarveh)  $sql=$sql." and b.sercarveh like '%".$sercarveh."%'";
    if($tipoentrega) $sql.=" and a.id_asignacion=z.id_asignacion and z.tipoe='$tipoentrega'";

    if($desfecfac AND !$hasfecfac) $sql.= " and a.fecfac >= '".$desfecfac."'";
	else if (!$desfecfac AND  $hasfecfac) $sql.= " and a.fecfac <= '".$hasfecfac."'";
	else if ($desfecfac  AND  $hasfecfac)	$sql = $sql." and  a.fecfac BETWEEN '".$desfecfac."' AND '".$hasfecfac."'";

    if($codpro)  $sql=$sql." and c.codpro like '%".$codpro."%'";
    if($nombre)  $sql=$sql." and c.nomcomp like '%".$nombre."%'";
     if($tipo_benef)  $sql=$sql." and c.tipo='".$tipo_benef."'";
    if($banco)  $sql=$sql." and a.id_banco='".$banco."'";
    if($usuario)  $sql=$sql." and a.usuario_estatus='".$usuario."'";

    if($dia)  $sql=$sql."  and (30+((cast (to_char(fecfac-now(),'dd') as int ))+1))$sig'".$dia."'";
    if($diat)  $sql=$sql."  and abs(cast (to_char(fecfac-now(),'dd') as int ))$sig'".$diat."'";
    if($edad)  $sql=$sql." and Extract(year from age(now(),c.fecnac))$sig'".$edad."'";
    if($estado)  $sql=$sql." and c.codest='".$estado."'";
    if($sexo)  $sql=$sql." and c.sexo='".$sexo."'";
    if($codmar)  $sql=$sql." and j.codmarveh='".$codmar."'";
    if($codmodveh)  $sql=$sql." and j.codmod='".$codmodveh."'";
    if($codserveh)  $sql=$sql." and j.codserie='".$codserveh."'";

    if($numplaveh)  $sql=$sql." and h.numplaveh  like '%".$numplaveh."%'";
    if($preinv)  $sql=$sql." and a.id_preinv =".$preinv." ";
    if($riflab)  $sql=$sql." and c.riflab like '%".$riflab."%'";
    if($deslab)  $sql=$sql." and c.deslab like '%".$deslab."%'";


    if($desfec_estatus AND !$hasfec_estatus) $sql.= " and a.fecha_estatus >= '".$desfec_estatus."'";
	else if (!$desfec_estatus AND  $hasfec_estatus) $sql.= " and a.fecha_estatus <= '".$hasfec_estatus."'";
	else if ($desfec_estatus  AND  $hasfec_estatus)	$sql.= " and a.fecha_estatus BETWEEN '".$desfec_estatus."' AND '".$hasfec_estatus."'";

    if($desfecfacori AND !$hasfecfacori) $sql.= " and o.fecfac1veh >= '".$desfecfacori."'";
	else if (!$desfecfacori AND  $hasfecfacori) $sql.= " and o.fecfac1veh <= '".$hasfecfacori."'";
	else if ($desfecfacori and $hasfecfacori)	$sql.= " and o.fecfac1veh BETWEEN '".$desfecfacori."' AND '".$hasfecfacori."'";


    if($numfacori)  $sql=$sql." and o.numfac1veh='".$numfacori."'";
    if($taller) $sql.= " and vt.id_taller='$taller'";
    if($color) $sql.= " and i.col1veh='".$color."'";

    if ($obs) $sql.=" and c.obspro like '%".$obs."%'";

  //print '<pre>'; print $sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
    return $consulta[0];
 }


  function listadoEntrega($placa=null, $serial=null, $rif = null){
 	$sql_rf  = null;
 	$sql_pla = null;
 	$sql_serial = null;

 	if($rif)
 		$sql_rf = "b.codpro = '".$rif."' AND";

 	if($placa)
 		$sql_pla = "h.numplaveh = '".$placa."' AND";

 	IF($serial)
 		$sql_serial = "b.sercarveh = '".$serial."' AND";

 	$sql="select
				    a.id_numfac,i.etiqueta,c.nomcomp,b.codpro,l.desmod,p.descol,h.numplaveh,b.sercarveh , d.banco_descrip,
					e.descripcion,
					j.numlotveh,
					r.descripcion as tipo_benef
					from
					asignacion  b, vehiculo i
					left outer join placas h  on h.sercarveh=i.sercarveh,caracteristica j
					left outer join marcas k on k.codmar=j.codmarveh
					left outer join modelo l  on l.codmod=j.codmod
					left outer join serie m  on m.codserie=j.codserie,
					propietarios c
					left outer join tipo_benef r on r.codtipben=c.tipo
					left outer join zona_estado f on f.codest=c.codest
					left outer join sexo g on g.codsexo=c.sexo,
					facturaprof a
					left outer join banco d on d.id_banco=a.id_banco
					left outer join estatus e on e.id_estatus=a.id_estatus
					left outer join certificados o on o.id_asignacion=a.id_asignacion AND o.estatus='A',
					lote n,color p
					where
					j.numlotveh=n.numlot and
					$sql_pla
					$sql_rf
					$sql_serial
					i.id_caract=j.id_caract and
					b.sercarveh=i.sercarveh and
					a.estatus='A' and
					a.id_asignacion=b.id_asignacion and
					b.codpro=c.codpro
					and p.codcol=i.col1veh and
					((a.id_estatus='8' and  a.condpago='CONTADO') or ((a.id_estatus='14' or a.id_estatus='33' ) and  a.condpago='CREDITO') or ((a.id_estatus='14' or a.id_estatus='33' ) and  a.condpago='COMPLETO')  or (a.id_estatus='22' and ((a.condpago='COMPLETO') or (a.condpago='CREDITO')) ))    and (j.numlotveh='14' or j.numlotveh='15' or j.numlotveh='16' or j.numlotveh='17')    order by
		          (select  fecha from movi_proforma where id_movi_pro=(select  max(id_movi_pro) from movi_proforma where id_numfac=a.id_numfac) ) ,
			      (select  hora from movi_proforma where id_movi_pro=(select  max(id_movi_pro) from movi_proforma where id_numfac=a.id_numfac) ) LIMIT 1 OFFSET 0";

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;

 }
 function listarFacturasPreInv($id_numfac,$sercarveh,$desfecfac,$hasfecfac,$offset,$codpro,$nombre,$tipo=null,$estatus=null, $banco=null ,$usuario=null,$cond=null, $sig=null, $dia=null ,$edad=null ,$estado=null,$sexo=null,$diat=null,$codmar=null,$codmodveh=null,$codserveh=null,$numlotveh=null,$numplaveh=null,$taller=null,$tt=null,$desfec_estatus=NULL,$hasfec_estatus=NULL,$tipoentrega=null,$tipo_benef=null,$desfecfacori=null,$hasfecfacori=null,$numfacori=null){
    if ($sig=='1') $sig='<=';else $sig='=';
    if(!$tipo) $tipo='A';
 	$sql = "select
			a.id_numfac, a.id_asignacion , b.sercarveh ,a.exento,to_char(a.fecfac,'dd/mm/yyyy') , a.iva ,a.condpago ,a.estatus,
			b.codpro,c.nomcomp, a.id_estatus, a.usuario_estatus, a.fecha_estatus, a.id_banco, a.id_concesionario,a.id_concesionario, d.banco_descrip,
			e.descripcion,f.nomest,g.dessexo,
            Extract(year from age(now(),c.fecnac)) as edad, to_char((fecfac+30),'dd/mm/yyyy') as fecven,
            abs(cast (to_char(fecfac-now(),'dd') as int )) as diastrans,
			(30+((cast (to_char(fecfac-now(),'dd') as int ))+1)) as diasrestantes,to_char(a.fecha_estatus,'dd/mm/yyyy'),
			r.descripcion as tipo_benef,
			a.montosol,a.monto,a.plazo,a.tasa,a.tipagomens,a.tipagosem,a.tipagoanual,a.gastos,a.gastosadmin,a.gastostimbre,a.exonerado ,a.id_preinv ";
    $sql.="	from asignacion  b,";
	$sql.= "propietarios c
		    left outer join tipo_benef r on r.codtipben=c.tipo
			left outer join zona_estado f on f.codest=c.codest
			left outer join sexo g on g.codsexo=c.sexo,
			facturaprof a
			left outer join banco d on d.id_banco=a.id_banco
			left outer join estatus e on e.id_estatus=a.id_estatus and a.id_preinv is not null ";
	$sql.= "where
			a.estatus='$tipo' and
			a.id_asignacion=b.id_asignacion and a.id_preinv is not null and
			b.codpro=c.codpro";

    if($id_numfac)  $sql=$sql." and a.id_numfac='".$id_numfac."'";
    if($sercarveh)  $sql=$sql." and b.sercarveh like '%".$sercarveh."%'";
    if($desfecfac AND !$hasfecfac) $sql.= " and a.fecfac >= '".$desfecfac."'";
	else if (!$desfecfac AND  $hasfecfac) $sql.= " and a.fecfac <= '".$hasfecfac."'";
	else if ($desfecfac  AND  $hasfecfac)	$sql = $sql." and  a.fecfac BETWEEN '".$desfecfac."' AND '".$hasfecfac."'";
    if($codpro)  $sql=$sql." and c.codpro like '%".$codpro."%'";
    if($nombre)  $sql=$sql." and c.nomcomp like '%".$nombre."%'";
    if($tipo_benef)  $sql=$sql." and c.tipo='".$tipo_benef."'";
    if($estatus)  $sql=$sql." and a.id_estatus='".$estatus."'";
    if($banco)  $sql=$sql." and a.id_banco='".$banco."'";
    if($usuario)  $sql=$sql." and a.usuario_estatus='".$usuario."'";
    if($cond)  $sql=$sql." and a.condpago='".$cond."'";
    if($dia)  $sql=$sql."  and (30+((cast (to_char(fecfac-now(),'dd') as int ))+1))$sig'".$dia."'";
    if($diat)  $sql=$sql."  and abs(cast (to_char(fecfac-now(),'dd') as int ))$sig'".$diat."'";
    if($edad)  $sql=$sql." and Extract(year from age(now(),c.fecnac))$sig'".$edad."'";
    if($estado)  $sql=$sql." and c.codest='".$estado."'";
    if($sexo)  $sql=$sql." and c.sexo='".$sexo."'";
    if($desfec_estatus AND !$hasfec_estatus) $sql.= " and a.fecha_estatus >= '".$desfec_estatus."'";
	else if (!$desfec_estatus AND  $hasfec_estatus) $sql.= " and a.fecha_estatus <= '".$hasfec_estatus."'";
	else if ($desfec_estatus  AND  $hasfec_estatus)	$sql.= " and a.fecha_estatus BETWEEN '".$desfec_estatus."' AND '".$hasfec_estatus."'";
    if($desfecfacori AND !$hasfecfacori) $sql.= " and o.fecfac1veh >= '".$desfecfacori."'";
	else if (!$desfecfacori AND  $hasfecfacori) $sql.= " and o.fecfac1veh <= '".$hasfecfacori."'";
	else if ($desfecfacori and $hasfecfacori)	$sql.= " and o.fecfac1veh BETWEEN '".$desfecfacori."' AND '".$hasfecfacori."'";
    if($numfacori)  $sql=$sql." and o.numfac1veh='".$numfacori."'";
    $sql=$sql." order by a.fecfac desc, a.id_numfac desc ";
    if($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;

 // print '<pre>'; print $sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function contarFacturasPreInv($id_numfac,$sercarveh,$desfecfac,$hasfecfac,$offset,$codpro,$nombre,$tipo=null,$estatus=null, $banco=null ,$usuario=null,$cond=null, $sig=null, $dia=null ,$edad=null ,$estado=null,$sexo=null,$diat=null,$codmar=null,$codmodveh=null,$codserveh=null,$numlotveh=null,$numplaveh=null,$taller=null,$tt=null,$desfec_estatus=NULL,$hasfec_estatus=NULL,$tipoentrega=null,$tipo_benef=null,$desfecfacori=null,$hasfecfacori=null,$numfacori=null){
    if ($sig=='1') $sig='<=';else $sig='=';
    if(!$tipo) $tipo='A';
 	$sql = "select
			count(a.id_numfac) ";
    $sql.="	from asignacion  b,";
	$sql.= "propietarios c
		    left outer join tipo_benef r on r.codtipben=c.tipo
			left outer join zona_estado f on f.codest=c.codest
			left outer join sexo g on g.codsexo=c.sexo,
			facturaprof a
			left outer join banco d on d.id_banco=a.id_banco
			left outer join estatus e on e.id_estatus=a.id_estatus and a.id_preinv is not null ";
	$sql.= "where
			a.estatus='$tipo' and
			a.id_asignacion=b.id_asignacion and a.id_preinv is not null and
			b.codpro=c.codpro";

    if($id_numfac)  $sql=$sql." and a.id_numfac='".$id_numfac."'";
    if($sercarveh)  $sql=$sql." and b.sercarveh like '%".$sercarveh."%'";
    if($desfecfac AND !$hasfecfac) $sql.= " and a.fecfac >= '".$desfecfac."'";
	else if (!$desfecfac AND  $hasfecfac) $sql.= " and a.fecfac <= '".$hasfecfac."'";
	else if ($desfecfac  AND  $hasfecfac)	$sql = $sql." and  a.fecfac BETWEEN '".$desfecfac."' AND '".$hasfecfac."'";
    if($codpro)  $sql=$sql." and c.codpro like '%".$codpro."%'";
    if($nombre)  $sql=$sql." and c.nomcomp like '%".$nombre."%'";
    if($tipo_benef)  $sql=$sql." and c.tipo='".$tipo_benef."'";
    if($estatus)  $sql=$sql." and a.id_estatus='".$estatus."'";
    if($banco)  $sql=$sql." and a.id_banco='".$banco."'";
    if($usuario)  $sql=$sql." and a.usuario_estatus='".$usuario."'";
    if($cond)  $sql=$sql." and a.condpago='".$cond."'";
    if($dia)  $sql=$sql."  and (30+((cast (to_char(fecfac-now(),'dd') as int ))+1))$sig'".$dia."'";
    if($diat)  $sql=$sql."  and abs(cast (to_char(fecfac-now(),'dd') as int ))$sig'".$diat."'";
    if($edad)  $sql=$sql." and Extract(year from age(now(),c.fecnac))$sig'".$edad."'";
    if($estado)  $sql=$sql." and c.codest='".$estado."'";
    if($sexo)  $sql=$sql." and c.sexo='".$sexo."'";
    if($desfec_estatus AND !$hasfec_estatus) $sql.= " and a.fecha_estatus >= '".$desfec_estatus."'";
	else if (!$desfec_estatus AND  $hasfec_estatus) $sql.= " and a.fecha_estatus <= '".$hasfec_estatus."'";
	else if ($desfec_estatus  AND  $hasfec_estatus)	$sql.= " and a.fecha_estatus BETWEEN '".$desfec_estatus."' AND '".$hasfec_estatus."'";
    if($desfecfacori AND !$hasfecfacori) $sql.= " and o.fecfac1veh >= '".$desfecfacori."'";
	else if (!$desfecfacori AND  $hasfecfacori) $sql.= " and o.fecfac1veh <= '".$hasfecfacori."'";
	else if ($desfecfacori and $hasfecfacori)	$sql.= " and o.fecfac1veh BETWEEN '".$desfecfacori."' AND '".$hasfecfacori."'";
    if($numfacori)  $sql=$sql." and o.numfac1veh='".$numfacori."'";


 // print '<pre>'; print $sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

 function contarFacturas($id_numfac,$sercarveh,$desfecfac,$hasfecfac,$codpro,$nombre,$tipo=null,$estatus=null, $banco=null ,$usuario=null,$cond=null, $sig=null,
  $dia=null ,$edad=null ,$estado=null,$sexo=null,$diat=null,$codmar=null,$codmodveh=null,$codserveh=null,$numlotveh=null,$numplaveh=null,$taller=null,
  $tt=null,$desfec_estatus=NULL,$hasfec_estatus=NULL,$tipoentrega=null,$tipo_benef=null,$desfecfacori=null,$hasfecfacori=null,$numfacori=null,$preinv=null,
  $color=null,$acto=null,$ta=null,$todoacto=null,$tipoB=null,$riflab=null,$deslab=null){
    if ($sig=='1') $sig='<=';else $sig='=';
    if(!$tipo) $tipo='A';
 	$sql = "select
			count(a.id_numfac)
		from
			asignacion  b, ";

		if ($taller or $tt)
			$sql.= " vehiculo i left outer join placas h  on h.sercarveh=i.sercarveh
	           inner join ( vehic_taller vt
			INNER JOIN taller ta on ta.numtaller=vt.id_taller) on i.sercarveh=vt.sercarveh, ";
        else
        	$sql.= " vehiculo i
			left outer join placas h  on h.sercarveh=i.sercarveh," ;

			$sql.= " caracteristica j
			left outer join marcas k on k.codmar=j.codmarveh
			left outer join modelo l  on l.codmod=j.codmod
			left outer join serie m  on m.codserie=j.codserie,
			propietarios c
		    left outer join tipo_benef r on r.codtipben=c.tipo
			left outer join zona_estado f on f.codest=c.codest
			left outer join sexo g on g.codsexo=c.sexo,
			facturaprof a
			left outer join banco d on d.id_banco=a.id_banco
			left outer join estatus e on e.id_estatus=a.id_estatus
			left outer join certificados o on o.id_asignacion=a.id_asignacion and o.tipmov_txt='MA' AND o.estatus='A',
			lote n,color p ";


    //if ($tipoentrega) $sql.=", entrega z ";
     if ($tipoentrega or $acto or $todoacto) $sql.=", entrega z ";

	$sql.= "where
			j.numlotveh=n.numlot and
			i.id_caract=j.id_caract and
			b.sercarveh=i.sercarveh and
			a.estatus='$tipo' and
		    a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and
			p.codcol=i.col1veh";

    if($id_numfac)  $sql=$sql." and a.id_numfac='".$id_numfac."'";
     if($sercarveh=='0')  $sql=$sql." and b.sercarveh='0' "; else  if($sercarveh)  $sql=$sql." and b.sercarveh like '%".$sercarveh."%'";
    //if($sercarveh)  $sql=$sql." and b.sercarveh like '%".$sercarveh."%'";
    if($tipoentrega) $sql.=" and a.id_asignacion=z.id_asignacion and z.tipoe='$tipoentrega'";
    if($desfecfac and $hasfecfac){
       $sql = $sql." and  a.fecfac BETWEEN '".$desfecfac."' AND '".$hasfecfac."'";
    }
    if($codpro)  $sql=$sql." and c.codpro like '%".$codpro."%'";
    if($nombre)  $sql=$sql." and c.nomcomp like '%".$nombre."%'";
     if($tipo_benef)  $sql=$sql." and c.tipo='".$tipo_benef."'";
    if($estatus)  $sql=$sql." and a.id_estatus='".$estatus."'";
    if($banco)  $sql=$sql." and a.id_banco='".$banco."'";
    if($usuario)  $sql=$sql." and a.usuario_estatus='".$usuario."'";
    //if($cond)  $sql=$sql." and a.condpago='".$cond."'";

     if($cond){
    	if ($cond=='CREDITOS') // OR $cond=='CREDITO' )
    		$sql=$sql." and ((a.condpago='CREDITO') or (a.condpago='COMPLETO')  ) ";
    	else
    		$sql=$sql." and a.condpago='".$cond."'";
    }

    if($dia)  $sql=$sql."  and (30+((cast (to_char(fecfac-now(),'dd') as int ))+1))$sig'".$dia."'";
    if($diat)  $sql=$sql."  and abs(cast (to_char(fecfac-now(),'dd') as int ))$sig'".$diat."'";
    if($edad)  $sql=$sql." and Extract(year from age(now(),c.fecnac))$sig'".$edad."'";
    if($estado)  $sql=$sql." and c.codest='".$estado."'";
    if($sexo)  $sql=$sql." and c.sexo='".$sexo."'";
    if($codmar)  $sql=$sql." and j.codmarveh='".$codmar."'";
    if($codmodveh)  $sql=$sql." and j.codmod='".$codmodveh."'";
    if($codserveh)  $sql=$sql." and j.codserie='".$codserveh."'";
    if($numlotveh)  $sql=$sql." and j.numlotveh='".$numlotveh."'";
    if($numplaveh)  $sql=$sql." and h.numplaveh  like '%".$numplaveh."%'";
    if($desfec_estatus and $hasfec_estatus){
    $sql = $sql." and  a.fecha_estatus BETWEEN '".$desfec_estatus."' AND '".$hasfec_estatus."'";
    }
     if($desfecfacori and $hasfecfacori){
       $sql = $sql." and  o.fecfac1veh BETWEEN '".$desfecfacori."' AND '".$hasfecfacori."'";
    }
    if($numfacori)  $sql=$sql." and o.numfac1veh='".$numfacori."'";
    if($taller) $sql.= " and vt.id_taller='$taller'";
    if($preinv)  $sql=$sql." and a.id_preinv =".$preinv." ";
    if($color) $sql.= " and i.col1veh='$color'";
     if($riflab)  $sql=$sql." and c.riflab like '%".$riflab."%'";
     if($deslab)  $sql=$sql." and c.deslab like '%".$deslab."%'";

    if ($acto or $todoacto) $sql.=" and a.id_asignacion=z.id_asignacion and z.acto='$acto'";
    if($tipoB==1)   $sql=$sql." and (c.codpro like '%V%' or c.codpro like '%E%')";
    if($tipoB==2)   $sql=$sql." and (c.codpro like '%J%' or c.codpro like '%G%')";
    //print '<pre>Contar: '; print $sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);
    $consulta = $this->ret_vector($consulta);
    $this->desconectar($conexion);
    return $consulta[0];
 }

  function sqlReporteFactura($id_numfac,$tipo=null,$cedula=null)
  {
    if(!$tipo) $tipo='A';
    $sql = "select
      e.id_numfac, to_char(e.fecfac,'dd/mm/yyyy'),to_char(e.fecfac,'dd'),to_char(e.fecfac,'mm'),to_char(e.fecfac,'yyyy'),e.condpago, e.exento, c.preveh, e.iva,
      a.id_asignacion,b.id_caract, b.sercarveh, d.nomcomp,d.codpro,  d.calavepro , d.urbbarpro,
      d.edicaspro ,d.numpispro , d.numapapro ,d.dismunpro ,d.ciudadpro , d.tlfcelpro ,d.tlfcel2pro,F.banco_descrip, G.descripcion, d.codest, d.codmun, d.codpar,
            e.id_concesionario, e.id_estatus, e.usuario_estatus, e.fecha_estatus, e.observacion, e.monto, e.plazo,e.tasa,e.forma,e.gastos,e.exonerado, e.facori, to_char(e.fecfacori,'dd/mm/yyyy')
      , e.refliquida, to_char(e.fechaliquida,'dd/mm/yyyy'),e.montosol,e.motivoreco
      ,e.tipagomens,e.montpagomens,e.tipagosem,e.montpagosem,e.tipagoanual,e.montpagoanual,e.gastosadmin,e.gastosnotar,e.gastostimbre,e.recobs,
      e.reconsidoc,d.correo, e.solfacsiga, e.estsolfacsiga
      from
      asignacion a, vehiculo b, caracteristica c, propietarios d,
      facturaprof e
      left outer join banco f on e.id_banco=f.id_banco
      left outer join estatus g on e.id_estatus=g.id_estatus
      where
      e.estatus='$tipo' and
      a.sercarveh=b.sercarveh and
      b.id_caract=c.id_caract and
      a.codpro=d.codpro and
      e.id_asignacion=a.id_asignacion";
    if ($cedula) $sql=$sql." and d.codpro like '%".$cedula."%' ";
      else $sql=$sql." and e.id_numfac='".$id_numfac."' ";
    return $sql;
  }


  function reporteFactura($id_numfac,$tipo=null,$cedula=null){

  $sql = $this->sqlReporteFactura($id_numfac,$tipo,$cedula);
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function reporteFacturaAsoc($id_numfac,$tipo=null,$cedula=null){

  $sql = $this->sqlReporteFactura($id_numfac,$tipo,$cedula);
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector_asoc($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


  function sqlDetalleVehiculo($id_asignacion)
  {
      $sql = "select
        numcerticados(l.id_asignacion),numplaca(m.sercarveh),m.sercarveh, m.sernivveh, m.serchaveh,
        b.desmar ,c.desmod ,desserie(a.codserie) ,a.anofabveh , a.anomodveh ,m.sermotveh, f.descon,
        descolor(m.col1veh) as col1,descolor(m.col2veh) as col2,g.descla,h.destip, i.desuso,a.numpueveh ,
        a.numejeveh ,  a.pesveh ,a.capcarveh, a.numlotveh, c.codpro
        from
        caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
        asignacion l, vehiculo m
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
        m.estatus='A' and l.status='A'";
      $sql=$sql." and l.id_asignacion=".$id_asignacion."";

      return $sql;
  }

   function detalleVehiculo($id_asignacion){

    $sql = $this->sqlDetalleVehiculo($id_asignacion);

    //print '<pre>'; print $sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);
    $consulta = $this->ret_vector($consulta);
    $this->desconectar($conexion);
    return $consulta;
  }

   function detalleVehiculoAsoc($id_asignacion){

    $sql = $this->sqlDetalleVehiculo($id_asignacion);

    //print '<pre>'; print $sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);
    $consulta = $this->ret_vector_asoc($consulta);
    $this->desconectar($conexion);
    return $consulta;
   }


  function listarMovimientos($num){
  $fecha=date('d/m/Y');
  $sql = "select b.descripcion,to_char(fecha,'dd/mm/yyyy') as fecha, hora, usuario_estatus from movi_proforma a, estatus b where a.id_estatus=b.id_estatus and id_numfac='".$num."' ";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function AnularFactura($num,$codpro,$serveh,$indReg,$obspro,$monto){
      $fecha=date('d/m/Y');
	  $sql ="  update facturaprof set id_estatus='".$indReg."', usuario_estatus='".$_SESSION['usuario']."', fecha_estatus='".$fecha."', estatus='E', observacion=observacion||'".$obspro."' ";
      if ($monto) $sql.=" ,monto= ".$monto." ";
      $sql=$sql."  where id_numfac='".$num."'";
     // print $sql;
	  $conexion = $this->conectar();
	  $consulta = $this->consultar($conexion,$sql);
	  $this->desconectar($conexion);
	  if($consulta) $esta = $this->statusProforma($num,$indReg,$_SESSION['usuario']);
	  if($consulta) $this->auditar('PROFORMA ANULADA N#:'.$num,$sql,'http://localhost/refeciv1.1/vistas/det_factura.php');
  return $consulta;
 }

  function estatusFacturaProfo($num,$codpro,$serveh,$indReg,$obspro,$monto,$plazo=null,$tasa=null,$gastos=null,$exon=null,$facori=null,
  $fecfacori=null,$refliq=null,$fechaliq=null,$montoS,$motivo=null,$tpagomen=null,$mpagomen=null,$tpagosem=null,$mpagosem=null,$tpagoanu=null,$mpagoanu=null,
  $gastosA=null,$gastosN=null,$gastosT=null,$motivoT=null){  //$forma=null,  esto estaba entre tasa y gastos
      $fecha=date('d/m/Y');
      //echo 'aqui2:'.$mpagomen;
      $sql ="  update facturaprof set id_estatus='".$indReg."', usuario_estatus='".$_SESSION['usuario']."', fecha_estatus='".$fecha."' ";
      if ($monto)    $sql.=" , monto= ".$monto."  ";
      if ($plazo)    $sql.=" , plazo= ".$plazo." ";
      if ($tasa)     $sql.=" , tasa= ".$tasa."";
      if ($exon)     $sql.=" , exonerado= '".$exon."'  ";
      if ($facori)   $sql.=" , facori='".$facori."', fecfacori='".$fecfacori."' ";
      if ($obspro)   $sql.=" , observacion='".$obspro."' ";
      if ($gastos)   $sql.=" , gastos= ".$gastos."  ";
      if ($refliq)   $sql.=" , refliquida='".$refliq."' ";
      if ($fechaliq) $sql.=" , fechaliquida='".$fechaliq."' ";
      if ($montoS)   $sql.=" , montosol= ".$montoS."";
      if ($motivo)   $sql.=" , motivoreco='".$motivo."'";
	  if ($tpagomen) $sql.=" , tipagomens='".$tpagomen."' ";
	  if ($tpagosem) $sql.=" , tipagosem='".$tpagosem."' ";
	  if ($tpagoanu) $sql.=" , tipagoanual='".$tpagoanu."' ";
	  if ($mpagomen) $sql.=" , montpagomens= ".$mpagomen."";
	  if ($mpagosem) $sql.=" , montpagosem= ".$mpagosem."";
	  if ($mpagoanu) $sql.=" , montpagoanual= ".$mpagoanu."";
	  if ($gastosA)  $sql.=" , gastosadmin= ".$gastosA."  ";
	  if ($gastosN)  $sql.=" , gastosnotar= ".$gastosN."  ";
	  if ($gastosT)  $sql.=" , gastostimbre= ".$gastosT."  ";
	  if ($motivoT)  $sql.=" , recobs='".$motivoT."'";


      $sql=$sql."  where id_numfac='".$num."'";
    //  print $sql;

	  $conexion = $this->conectar();
	  $consulta = $this->consultar($conexion,$sql);
	  $this->desconectar($conexion);
	 // if($consulta) $this->bitacoraBeneficiario($codpro,$serveh,'Cambio de estatus de Proforma '.$num.' a: '.$indReg,$_SESSION['usuario']);
	  if($consulta) $esta = $this->statusProforma($num,$indReg,$_SESSION['usuario']);
	  if($consulta) $this->bitacoraBeneficiario($codpro,$serveh,'Se cambio el estatus a '.$this->descripcionEstatus($indReg),$_SESSION['usuario']);
	  if($consulta) $this->auditar('CAMBIO DE ESTATUS DE LA PROFORMA '.$num.' a: '.$indReg,$sql,'http://localhost/refeciv1.1/vistas/det_factura.php');
      return $consulta;
 }
function estatusFacturaProfoR($num){  //$forma=null,  esto estaba entre tasa y gastos
      $fecha=date('d/m/Y');
      //echo 'aqui2:'.$mpagomen;
      $sql ="  update facturaprof set id_estatus='2', usuario_estatus='".$_SESSION['usuario']."', fecha_estatus='".$fecha."' ";
      $sql.=" , monto= null, plazo= null, tasa=null,  exonerado= 'N', gastos=null    ";
      $sql.=" , tipagomens='' ";
	  $sql.=" , tipagosem='' ";
	  $sql.=" , tipagoanual='' ";
	  $sql.=" , montpagomens= null ";
	  $sql.=" , montpagosem= null ";
	  $sql.=" , montpagoanual= null ";
	  $sql.=" , gastosadmin= null  ";
	  $sql.=" , gastosnotar= null  ";
	  $sql.=" , gastostimbre= null  ";
      $sql=$sql."  where id_numfac='".$num."'";
     // print $sql;

	  $conexion = $this->conectar();
	  $consulta = $this->consultar($conexion,$sql);
	  $this->desconectar($conexion);
	 // if($consulta) $this->bitacoraBeneficiario($codpro,$serveh,'Cambio de estatus de Proforma '.$num.' a: '.$indReg,$_SESSION['usuario']);
	  if($consulta) $esta = $this->statusProforma($num,'2',$_SESSION['usuario']);
	  if($consulta) $this->auditar('REVERSO DE ESTATUS DE APROBADO - EN ANALISIS '.$num.' a: '.'2',$sql,'http://localhost/refeciv1.1/vistas/det_factura.php');
      return $consulta;
 }
 function alertasFacturas($id_numfac,$sercarveh,$desfecfac,$hasfecfac,$offset,$codpro,$nombre,$dia,$sig){
   if ($sig=='1') $sig='<=';else $sig='=';
 	$sql = "select
			a.id_numfac, b.sercarveh ,b.codpro,c.nomcomp,  a.condpago , d.banco_descrip,  e.descripcion,  a.usuario_estatus,
			to_char(fecfac,'dd/mm/yyyy') as fecha ,to_char((fecfac+30),'dd/mm/yyyy') fecven, abs(cast (to_char(fecfac-now(),'dd') as int )) as diastrans,
			(30+((cast (to_char(fecfac-now(),'dd') as int ))+1)) as diasrestantes
			from
			asignacion  b, propietarios c,
			facturaprof a
			left outer join banco d on d.id_banco=a.id_banco
			left outer join estatus e on e.id_estatus=a.id_estatus
			where
			a.estatus='A' and
			a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and e.descripcion='EMITIDA' and (30+((cast (to_char(fecfac-now(),'dd') as int ))+1))>='-15' ";
    if($id_numfac)  $sql=$sql." and a.id_numfac='".$id_numfac."'";
    if($sercarveh)  $sql=$sql." and b.sercarveh like '%".$sercarveh."%'";
    if($desfecfac and $hasfecfac)  $sql = $sql." and  a.fecfac BETWEEN '".$desfecfac."' AND '".$hasfecfac."'";
    if($codpro)  $sql=$sql." and c.codpro like '%".$codpro."%'";
    if($nombre)  $sql=$sql." and c.nomcomp like '%".$nombre."%'";
    if($dia)  $sql=$sql."  and (30+((cast (to_char(fecfac-now(),'dd') as int ))+1))$sig'".$dia."'";
    $sql=$sql." order by a.fecfac, a.id_numfac ";
    if($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function contAlertasFacturas($id_numfac,$sercarveh,$desfecfac,$hasfecfac,$codpro,$nombre,$dia,$sig){
   if ($sig=='1') $sig='<=';else $sig='=';
 	$sql = "select
			count(a.id_numfac)
			from
			asignacion  b, propietarios c,
			facturaprof a
			left outer join banco d on d.id_banco=a.id_banco
			left outer join estatus e on e.id_estatus=a.id_estatus
			where
			a.estatus='A' and
			a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and e.descripcion='EMITIDA' and (30+((cast (to_char(fecfac-now(),'dd') as int ))+1))>='-15'  ";
    if($id_numfac)  $sql=$sql." and a.id_numfac='".$id_numfac."'";
    if($sercarveh)  $sql=$sql." and b.sercarveh like '%".$sercarveh."%'";
    if($desfecfac and $hasfecfac)  $sql = $sql." and  a.fecfac BETWEEN '".$desfecfac."' AND '".$hasfecfac."'";
    if($codpro)  $sql=$sql." and c.codpro like '%".$codpro."%'";
    if($nombre)  $sql=$sql." and c.nomcomp like '%".$nombre."%'";
    if($dia)  $sql=$sql." and (30+((cast (to_char(fecfac-now(),'dd') as int ))+1))$sig'".$dia."'";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

  function listarEstatus(){
 	$sql = "select
			id_estatus, descripcion, orden, status
			from
			estatus
			where
			status='A'";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


function actualizaReserva($datos,$codigo,$serveh){
	$sql = "UPDATE facturaprof SET
		reservadoc = '".$datos[1]."'," .
				"fecharesdoc = '".$datos[2]."'
		WHERE id_numfac = '".$datos[0]."'";

    //echo $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
    if($consulta) $this->estatusFacturaProfo($datos[0],$codigo,$serveh,'9','','');
	return $consulta;

 }

 function buscarRD($idfactura){
	$sql = "select reservadoc from facturaprof WHERE id_numfac = '".$idfactura."'";

    //echo $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	 $consulta = $this->ret_vector($consulta);
	$this->desconectar($conexion);
    //if($consulta) $this->estatusFacturaProfo($datos[0],$codigo,$serveh,'9','','');
	return $consulta;

 }

  function reconsiderarFactura($num,$id_banco,$codproa,$serveh){
      $fecha=date('d/m/Y');
	  $sql ="  update facturaprof set id_banco='".$id_banco."', id_estatus=1  ";
      $sql=$sql."  where id_numfac='".$num."'";
     // print $sql;
	  $conexion = $this->conectar();
	  $consulta = $this->consultar($conexion,$sql);
	  $this->desconectar($conexion);
	  if($consulta) $esta = $this->statusProforma($num,'1',$_SESSION['usuario']);
	  if($consulta) $this->auditar('PROFORMA CAMBIADA DE BANCO A:'.$id_banco,$sql,'http://localhost/refeciv1.1/vistas/det_factura.php');
	  if($consulta) $this->bitacoraBeneficiario($codproa,$serveh,'PROFORMA CAMBIADA DE BANCO A:'.$id_banco,$_SESSION['usuario']);
  return $consulta;
 }


  function actualizaReconDoc($datos,$codigo,$serveh){
	$sql = "UPDATE facturaprof SET
		    reconsidoc = '".$datos[1]."'," .
			"fechareconsidoc = '".$datos[2]."'
		    WHERE id_numfac = '".$datos[0]."'";

    //echo $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
    //if($consulta) $this->estatusFacturaProfo($datos[0],$codigo,$serveh,'18','','');
	return $consulta;
 }


 ///FACTURAR PRE-PROFORMA
 /*function registrarFactPreProf($data){

    $conexion = $this->conectar();
    $fecha=date('d/m/Y');
    $hora=date('H:i:s');

   $sql = "INSERT INTO preproforma(fecha,id_preinv,ci_ben,usuario,hora)
            values ('".$fecha."','".$data[0]."','".$data[1]."','".$_SESSION['usuario']."','".$hora."')";
 // print '<pre>'; print $sql;

 $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/preproforma.php');
  /*if($consulta){
  	$id_F = "";
  	//BUSCAR EL ID MAX
  	$this->bitacoraBeneficiario($codproa,$data[1],'Registro Factura Pre-Proforma N#: '.$id_F,$_SESSION['usuario']);
  }
  if($consulta) $this->statusProforma($id_F,'1',$_SESSION['usuario']);*/
 /* return $consulta;
 }*/

 function listarFactPreProf($idAsig){

  $sql = "select a.id_numfac, a.id_asignacion , a.sercarveh ,a.exento,to_char(a.fecfac,'dd/mm/yyyy'), a.iva, a.condpago from facturaprof a where id_asignacion='".$idAsig."' and estatus='A'";

  //print '<pre>'; print $sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function reversafactura($id_numfac,$msj,$tip=null){
if(!$tip){
 		 	$sql = "select id_estatus from movi_proforma where id_numfac = '".$id_numfac."' and id_estatus<>7 and id_estatus<>8 and id_estatus<>14 and  id_estatus <>15 and id_estatus<>22   order by id_movi_pro desc limit 1";
  // print '<pre>'; print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
    $consulta = $this->ret_vector($consulta);

 	}else{
 	 		 	$sql = "select id_estatus from movi_proforma where id_numfac = '".$id_numfac."' and
id_movi_pro<>(select max(id_movi_pro) from movi_proforma where id_numfac = '".$id_numfac."')
order by id_movi_pro desc limit 1";
  // print '<pre>'; print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
    $consulta = $this->ret_vector($consulta);
 	}


	$sql1 = "UPDATE facturaprof SET
		     id_estatus= '".$consulta[0]."',facori='',fecfacori=null
		     WHERE id_numfac = '".$id_numfac."'";
// print '<pre>'; print $sql1;
    $conexion = $this->conectar();
	$consulta1 = $this->consultar($conexion,$sql1);

    $sql2 = "select id_asignacion from facturaprof a where id_numfac = '".$id_numfac."'";
 // print '<pre>'; print $sql2;
    $consulta2 = $this->consultar($conexion,$sql2);
    $consulta2 = $this->ret_vector($consulta2);


    $sql0= "select sercarveh,codpro from asignacion where  id_asignacion  = '".$consulta2[0]."'";
  // print '<pre>'; print $sql0;
    $conexion = $this->conectar();
	$consulta0 = $this->consultar($conexion,$sql0);
    $consulta0 = $this->ret_vector($consulta0);

	 if($consulta1)  $sql3=" UPDATE certificados SET  numfac1veh='',fecfac1veh=null, estatus='E' WHERE id_asignacion  = '".$consulta2[0]."'";
	//print '<pre>'; print $sql;
	$consulta3 = $this->consultar($conexion,$sql3);
  	$consulta3 = $this->ret_vector($consulta3);
	$this->desconectar($conexion);
	if($consulta) $this->auditar('REVERSO','SENTENCIA 1:'.$sql2.' ,SENTENCIA 2'.$sql3,'http://localhost/refeciv1.1/vistas/listado_factura.php');
    if($consulta) $this->bitacoraBeneficiario($consulta0[1],$consulta0[0],'Se reverso la Factura Proforma N#:'.$id_numfac.' y paso al status '.$consulta[0],$_SESSION['usuario']);
	return ($consulta3);
 }

 function regComentarioFac($id,$comentario,$usuario){
  $fecha=date('d/m/Y');
  $this->bitacoraBeneficiario($id,'','Comentario: '.$comentario,$usuario);
   if ($this->bitacoraBeneficiario) return true; else return false;
 }

//Con esta sese reversa el estatus de las facturas que por error marcan como vehiculo entregado (15)
//OJO: No limpia certificados ni facturas, solo reversa estatus
function reversafactura1($id_numfac,$msj){
 	$sql = "select id_estatus from movi_proforma where id_numfac = '".$id_numfac."' and id_estatus<>15 AND id_estatus<>22 order by id_movi_pro desc limit 1";
  // print '<pre>'; print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
    $consulta = $this->ret_vector($consulta);


	$sql1 = "UPDATE facturaprof SET
		     id_estatus= '".$consulta[0]."'
		     WHERE id_numfac = '".$id_numfac."'";
// print '<pre>'; print $sql1;
    $conexion = $this->conectar();
	$consulta1 = $this->consultar($conexion,$sql1);

    $sql2 = "select id_asignacion from facturaprof a where id_numfac = '".$id_numfac."'";
 // print '<pre>'; print $sql2;
    $consulta2 = $this->consultar($conexion,$sql2);
    $consulta2 = $this->ret_vector($consulta2);


    $sql0= "select sercarveh,codpro from asignacion where  id_asignacion  = '".$consulta2[0]."'";
  // print '<pre>'; print $sql0;
    $conexion = $this->conectar();
	$consulta0 = $this->consultar($conexion,$sql0);
    $consulta0 = $this->ret_vector($consulta0);

/*	 if($consulta1)  $sql3=" UPDATE certificados SET  numfac1veh='',fecfac1veh=null, estatus='E' WHERE id_asignacion  = '".$consulta2[0]."'";
	//print '<pre>'; print $sql;
	$consulta3 = $this->consultar($conexion,$sql3);
  	$consulta3 = $this->ret_vector($consulta3);*/
	$this->desconectar($conexion);
	if($consulta) $this->auditar('REVERSO ESTATUS VEHICULO','SENTENCIA 1:'.$sql1,'http://localhost/refeciv1.1/vistas/listado_factura.php');
    if($consulta) $this->bitacoraBeneficiario($consulta0[1],$consulta0[0],'Se reverso la Factura Proforma N#:'.$id_numfac.' y paso al status '.$consulta[0],$_SESSION['usuario']);
	return ($consulta0);
 }

//Con esta se limpia la factura, el certificado y se reversa el estatus de las facturas que por error en nombre
//deben realizarse nuevamente y ya estaban como vehiculo entregado (15)
 function reversafactura3($id_numfac,$msj){
 	$sql = "select id_estatus from movi_proforma where id_numfac = '".$id_numfac."' and id_estatus<=6 order by id_movi_pro desc limit 1";
  // print '<pre>'; print $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
    $consulta = $this->ret_vector($consulta);

	$sql1 = "UPDATE facturaprof SET
		     id_estatus= '".$consulta[0]."',facori='',fecfacori=null, envio_fact='P', fecha_envio_fact=NULL
		     WHERE id_numfac = '".$id_numfac."'";
 //print '<pre>'; print $sql1;
    $conexion = $this->conectar();
	$consulta1 = $this->consultar($conexion,$sql1);

    $sql2 = "select id_asignacion from facturaprof a where id_numfac = '".$id_numfac."'";
  //print '<pre>'; print $sql2;
    $consulta2 = $this->consultar($conexion,$sql2);
    $consulta2 = $this->ret_vector($consulta2);


    $sql0= "select sercarveh,codpro from asignacion where  id_asignacion  = '".$consulta2[0]."'";
   //print '<pre>'; print $sql0;
    $conexion = $this->conectar();
	$consulta0 = $this->consultar($conexion,$sql0);
    $consulta0 = $this->ret_vector($consulta0);

	 if($consulta1)  $sql3=" UPDATE certificados SET  numfac1veh='',fecfac1veh=null, estatus='E' WHERE id_asignacion  = '".$consulta2[0]."'";
	//print '<pre>'; print $sql3;
	$consulta3 = $this->consultar($conexion,$sql3);
  	$consulta3 = $this->ret_vector($consulta3);
	$this->desconectar($conexion);

	if($consulta) $this->auditar('REVERSO POR ERROR EN NOMBRE Y ERA VEH ENT','SENTENCIA 1:'.$sql2.' ,SENTENCIA 2'.$sql3,'http://localhost/refeciv1.1/vistas/listado_factura.php');
    if($consulta) $this->bitacoraBeneficiario($consulta0[1],$consulta0[0],'Se reverso la Factura Proforma N#:'.$id_numfac.' y paso al status '.$consulta[0],$_SESSION['usuario']);
	return ($consulta3);
 }

function ModificarFactura($id_factura,$data,$codproa){
  $fecha = date('d/m/Y');

   $sql0= "select b.codpro from facturaprof a,asignacion b where a.id_asignacion=b.id_asignacion and a.id_numfac='".$id_factura."'";
   //print '<pre>'; print $sql0;
    $conexion = $this->conectar();
	$consulta0 = $this->consultar($conexion,$sql0);
    $consulta0 = $this->ret_vector($consulta0);

  $sql ="UPDATE facturaprof SET ".
	 	"   exento = '$data[2]'".
	 	" , iva = '$data[3]'".
	 	" , id_banco = '$data[5]'".
	 	" , condpago = '$data[4]'".
	 	" , observacion ='$data[6]'".
  		" WHERE id_numfac = $id_factura ";

  //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('MODIFICACION',$sql,'http://localhost/refeciv1.1/vistas/reg_factura.php');
  if($consulta) $this->bitacoraBeneficiario($consulta0[0],$data[1],'Modifico Factura Proforma N#: '.$id_factura,$_SESSION['usuario']);
  //if($consulta) $this->statusProforma($id_factura,'1',$_SESSION['usuario']);
  return $consulta;
 }

//LISTADO ACTO CONCESIONARIOS
function listarFacturas_conce($id_numfac,$sercarveh,$desfecfac,$hasfecfac,$offset,$codpro,$nombre,$tipo=null,$estatus=null,$banco=null,$cond=null,$sig=null,$estado=null,$sexo=null,$codmar=null,$codmodveh=null,$codserveh=null,$numlotveh=null,$numplaveh=null,$desfec_estatus=NULL,$hasfec_estatus=NULL,$tipo_benef=null,$desfecfacori=null,$hasfecfacori=null,$numfacori=null,$color=null,$lista=null,$comentario=null,$obs=null){

 	$sql = "select
					c.nomcomp,b.codpro,l.desmod,p.descol,h.numplaveh,b.sercarveh , d.banco_descrip,c.tlfcelpro,c.tlfcel2pro,
					e.descripcion,
					j.numlotveh,
					r.descripcion as tipo_benef,
					(select  fecha from movi_proforma where id_movi_pro=(select  max(id_movi_pro) from movi_proforma where id_numfac=a.id_numfac) ) as fecha,
					(select  hora from movi_proforma where id_movi_pro=(select  max(id_movi_pro) from movi_proforma where id_numfac=a.id_numfac) ) as hora,
				    i.etiqueta,c.obspro
					from
					asignacion  b, vehiculo i
					left outer join placas h  on h.sercarveh=i.sercarveh,caracteristica j
					left outer join marcas k on k.codmar=j.codmarveh
					left outer join modelo l  on l.codmod=j.codmod
					left outer join serie m  on m.codserie=j.codserie,
					propietarios c
					left outer join tipo_benef r on r.codtipben=c.tipo
					left outer join zona_estado f on f.codest=c.codest
					left outer join sexo g on g.codsexo=c.sexo,
					facturaprof a
					left outer join banco d on d.id_banco=a.id_banco
					left outer join estatus e on e.id_estatus=a.id_estatus
					left outer join certificados o on o.id_asignacion=a.id_asignacion AND o.estatus='A',
					lote n,color p
					where
					j.numlotveh=n.numlot and
					i.id_caract=j.id_caract and
					b.sercarveh=i.sercarveh and
					a.estatus='A' and
					a.id_asignacion=b.id_asignacion and
					b.codpro=c.codpro
					and p.codcol=i.col1veh and
					((a.id_estatus='8' and  a.condpago='CONTADO') or ((a.id_estatus='14' or a.id_estatus='33' ) and  a.condpago='CREDITO') or ((a.id_estatus='14' or a.id_estatus='33' ) and  a.condpago='COMPLETO')  or (a.id_estatus='22' and ((a.condpago='COMPLETO') or (a.condpago='CREDITO')) ))   ";

    if($numlotveh)  $sql=$sql." and j.numlotveh='".$numlotveh."'"; else $sql=$sql." and (j.numlotveh='14' or j.numlotveh='15' or j.numlotveh='16' or j.numlotveh='17')  ";
    if($id_numfac)  $sql=$sql." and a.id_numfac='".$id_numfac."'";
    if($sercarveh=='0')  $sql=$sql." and b.sercarveh='0' "; else  if($sercarveh)  $sql=$sql." and b.sercarveh like '%".$sercarveh."%'";

    if($desfecfac AND !$hasfecfac) $sql.= " and a.fecfac >= '".$desfecfac."'";
	else if (!$desfecfac AND  $hasfecfac) $sql.= " and a.fecfac <= '".$hasfecfac."'";
	else if ($desfecfac  AND  $hasfecfac)	$sql = $sql." and  a.fecfac BETWEEN '".$desfecfac."' AND '".$hasfecfac."'";

    if($codpro)  $sql=$sql." and c.codpro like '%".$codpro."%'";
    if($nombre)  $sql=$sql." and c.nomcomp like '%".$nombre."%'";
     if($tipo_benef)  $sql=$sql." and c.tipo='".$tipo_benef."'";
    if($banco)  $sql=$sql." and a.id_banco='".$banco."'";

    if($estado)  $sql=$sql." and c.codest='".$estado."'";
    if($sexo)  $sql=$sql." and c.sexo='".$sexo."'";
    if($codmar)  $sql=$sql." and j.codmarveh='".$codmar."'";
    if($codmodveh)  $sql=$sql." and j.codmod='".$codmodveh."'";
    if($codserveh)  $sql=$sql." and j.codserie='".$codserveh."'";

    if($numplaveh)  $sql=$sql." and h.numplaveh  like '%".$numplaveh."%'";

    if($desfec_estatus AND !$hasfec_estatus) $sql.= " and a.fecha_estatus >= '".$desfec_estatus."'";
	else if (!$desfec_estatus AND  $hasfec_estatus) $sql.= " and a.fecha_estatus <= '".$hasfec_estatus."'";
	else if ($desfec_estatus  AND  $hasfec_estatus)	$sql.= " and a.fecha_estatus BETWEEN '".$desfec_estatus."' AND '".$hasfec_estatus."'";

    if($desfecfacori AND !$hasfecfacori) $sql.= " and o.fecfac1veh >= '".$desfecfacori."'";
	else if (!$desfecfacori AND  $hasfecfacori) $sql.= " and o.fecfac1veh <= '".$hasfecfacori."'";
	else if ($desfecfacori and $hasfecfacori)	$sql.= " and o.fecfac1veh BETWEEN '".$desfecfacori."' AND '".$hasfecfacori."'";


    if($numfacori)  $sql=$sql." and o.numfac1veh='".$numfacori."'";
    if($color) $sql.= " and i.col1veh='".$color."'";
    if ($obs) $sql.=" and c.obspro like '%".$obs."%'";

    $sql=$sql."  order by
		          (select  fecha from movi_proforma where id_movi_pro=(select  max(id_movi_pro) from movi_proforma where id_numfac=a.id_numfac) ) ,
			      (select  hora from movi_proforma where id_movi_pro=(select  max(id_movi_pro) from movi_proforma where id_numfac=a.id_numfac) ) ";
    if($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;

  //print '<pre>'; print $sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function contarFacturas_conce($id_numfac,$sercarveh,$desfecfac,$hasfecfac,$offset,$codpro,$nombre,$tipo=null,$estatus=null, $banco=null,$cond=null, $sig=null,$estado=null,$sexo=null,$codmar=null,$codmodveh=null,$codserveh=null,$numlotveh=null,$numplaveh=null,$desfec_estatus=NULL,$hasfec_estatus=NULL,$tipo_benef=null,$desfecfacori=null,$hasfecfacori=null,$numfacori=null,$color=null,$lista=null,$comentario=null,$obs=null){

 	$sql = "select
					count(b.sercarveh )	from
					asignacion  b, vehiculo i
					left outer join placas h  on h.sercarveh=i.sercarveh,caracteristica j
					left outer join marcas k on k.codmar=j.codmarveh
					left outer join modelo l  on l.codmod=j.codmod
					left outer join serie m  on m.codserie=j.codserie,
					propietarios c
					left outer join tipo_benef r on r.codtipben=c.tipo
					left outer join zona_estado f on f.codest=c.codest
					left outer join sexo g on g.codsexo=c.sexo,
					facturaprof a
					left outer join banco d on d.id_banco=a.id_banco
					left outer join estatus e on e.id_estatus=a.id_estatus
					left outer join certificados o on o.id_asignacion=a.id_asignacion AND o.estatus='A',
					lote n,color p
					where
					j.numlotveh=n.numlot and
					i.id_caract=j.id_caract and
					b.sercarveh=i.sercarveh and
					a.estatus='A' and
					a.id_asignacion=b.id_asignacion and
					b.codpro=c.codpro
					and p.codcol=i.col1veh and
				((a.id_estatus='8' and  a.condpago='CONTADO') or ((a.id_estatus='14' or a.id_estatus='33' ) and  a.condpago='CREDITO') or ((a.id_estatus='14' or a.id_estatus='33' ) and  a.condpago='COMPLETO')  or (a.id_estatus='22' and ((a.condpago='COMPLETO') or (a.condpago='CREDITO')) ))   ";

    if($numlotveh)  $sql=$sql." and j.numlotveh='".$numlotveh."'"; else $sql=$sql." and (j.numlotveh='14' or j.numlotveh='15' or j.numlotveh='16' or j.numlotveh='17')  ";
    if($id_numfac)  $sql=$sql." and a.id_numfac='".$id_numfac."'";
    if($sercarveh=='0')  $sql=$sql." and b.sercarveh='0' "; else  if($sercarveh)  $sql=$sql." and b.sercarveh like '%".$sercarveh."%'";

    if($desfecfac AND !$hasfecfac) $sql.= " and a.fecfac >= '".$desfecfac."'";
	else if (!$desfecfac AND  $hasfecfac) $sql.= " and a.fecfac <= '".$hasfecfac."'";
	else if ($desfecfac  AND  $hasfecfac)	$sql = $sql." and  a.fecfac BETWEEN '".$desfecfac."' AND '".$hasfecfac."'";

    if($codpro)  $sql=$sql." and c.codpro like '%".$codpro."%'";
    if($nombre)  $sql=$sql." and c.nomcomp like '%".$nombre."%'";
     if($tipo_benef)  $sql=$sql." and c.tipo='".$tipo_benef."'";
    if($banco)  $sql=$sql." and a.id_banco='".$banco."'";

    if($estado)  $sql=$sql." and c.codest='".$estado."'";
    if($sexo)  $sql=$sql." and c.sexo='".$sexo."'";
    if($codmar)  $sql=$sql." and j.codmarveh='".$codmar."'";
    if($codmodveh)  $sql=$sql." and j.codmod='".$codmodveh."'";
    if($codserveh)  $sql=$sql." and j.codserie='".$codserveh."'";

    if($numplaveh)  $sql=$sql." and h.numplaveh  like '%".$numplaveh."%'";

    if($desfec_estatus AND !$hasfec_estatus) $sql.= " and a.fecha_estatus >= '".$desfec_estatus."'";
	else if (!$desfec_estatus AND  $hasfec_estatus) $sql.= " and a.fecha_estatus <= '".$hasfec_estatus."'";
	else if ($desfec_estatus  AND  $hasfec_estatus)	$sql.= " and a.fecha_estatus BETWEEN '".$desfec_estatus."' AND '".$hasfec_estatus."'";

    if($desfecfacori AND !$hasfecfacori) $sql.= " and o.fecfac1veh >= '".$desfecfacori."'";
	else if (!$desfecfacori AND  $hasfecfacori) $sql.= " and o.fecfac1veh <= '".$hasfecfacori."'";
	else if ($desfecfacori and $hasfecfacori)	$sql.= " and o.fecfac1veh BETWEEN '".$desfecfacori."' AND '".$hasfecfacori."'";


    if($numfacori)  $sql=$sql." and o.numfac1veh='".$numfacori."'";
    if($color) $sql.= " and i.col1veh='".$color."'";

    if ($obs) $sql.=" and c.obspro like '%".$obs."%'";

  //print '<pre>'; print $sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
    return $consulta[0];
 }

 function documentacion_ent($id){
 $sql="UPDATE facturaprof set documento='2' where documento='1'AND id_numfac='$id' ";
  // print '<pre>'; print $sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
 // $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
    return $consulta;
 }

function busq_documentacion($id){
 $sql="select documento from facturaprof where id_numfac='$id' ";
  // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
      return $consulta[0];
 }

public function actualizar_solfacsiga($id_numfac, $solfacsiga, $estsolfacsiga)
{
  $sql="UPDATE facturaprof set solfacsiga='$solfacsiga', estsolfacsiga='$estsolfacsiga' where id_numfac='$id_numfac' ";
  //print '<pre>'; print $sql;exit;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  // $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
  
}

}
?>