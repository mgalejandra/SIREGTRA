<?php
class envios extends conexion{

	
	
 function buscarEnvioVeh($campo){
 	if ($campo==1) $fectip='fechatxtveh';
 	if ($campo==2) $fectip='fechatxtpro';
 	if ($campo==3) $fectip='fechatxtpla';

	$fecha=date('Y-m-d');
   	$sql = "select max(fec)  from (
	select max(to_date(fechatxtveh,'dd/mm/yyyy'))  as fec  from certificados
	union
	select max(to_date(fechatxtpro,'dd/mm/yyyy'))  as fec  from certificados
	union
	select max(to_date(fechatxtpla,'dd/mm/yyyy')) as fec  from certificados
	) a";
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $maxfec=$consulta[0];
//echo substr($maxfec,0,10).'  '.$fecha;
  if (substr($maxfec,0,10) == $fecha)
{
	$sql = "select max(a.num)  from (
	select max(numenvveh) as num  from certificados where to_date(fechatxtveh,'dd/mm/yyyy')<>'".$fecha."'
	union
	select max(numenvpro) as num  from certificados where to_date(fechatxtpro,'dd/mm/yyyy')<>'".$fecha."'
	union
	select max(numenvpla) as num  from certificados where to_date(fechatxtpla,'dd/mm/yyyy')<>'".$fecha."'
	) a";

}else
{
	$sql = "select max(a.num)  from (
	select max(numenvveh) as num  from certificados
	union
	select max(numenvpro) as num  from certificados
	union
	select max(numenvpla) as num  from certificados
	) a";
}
 //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  $sql = "select max(to_date($fectip,'dd/mm/yyyy'))  as fec  from certificados	";
  $conexion = $this->conectar();
  $consulta1 = $this->consultar($conexion,$sql);
  $consulta1 = $this->ret_vector($consulta1);
  $maxfec1=$consulta1[0];
  if (substr($maxfec1,0,10) == $fecha)
  {
  	$sql = "select max(numenvveh) as num  from certificados";
  	$consulta2 = $this->consultar($conexion,$sql);
    $consulta2 = $this->ret_vector($consulta2);
  }



  $this->desconectar($conexion);
  return $consulta[0];
 }

  function buscarLotes(){

 	$sql = "select numlot, deslot from lote ";
 	$sql.= "order by numlot desc";
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

   function buscarLotesDep($dep=null){

 	$sql = "select numlot, deslot from lote ";
 	$sql.= "where numdep=$dep ";
 	$sql.= "order by numlot desc";
// print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  /*ORIGINAL*/
  
 
 function listarVehTxt($numlotveh,$tipo,$numenv,$origen,$mov,$precioj){
 
 	$sql = "select
		a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
        to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
        a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
        substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,7), a.tipmov_txt,
        a.nummodveh,f.codmarveh,desserie(f.codserie),h.desmod,f.anomodveh,e.sermotveh,i.numplaveh,e.col1veh,e.col2veh,f.pesveh,f.tipcapveh,
        f.capcarveh,f.numejeveh,f.diarueveh,j.codcla,k.codtip,l.coduso,to_char(a.fecha_reg,'yyyymmdd'),f.codptoveh,f.numlicveh,to_char(f.fecplaveh,'yyyymmdd'),
        f.numfacveh,to_char(f.fecfacveh,'yyyymmdd'),a.numcerveh,f.anofabveh,e.sernivveh,e.serchaveh,a.numfac1veh,to_char(a.fecfac1veh,'yyyymmdd'),
        e.numhomveh,to_char(e.fechomveh,'yyyymmdd'),f.codserveh,f.numpueveh,i.numrafveh,to_char(i.fecrafveh,'yyyymmdd'),i.numsecveh,'' as sercarr,f.codconveh
 
			from
			certificados a, asignacion b, propietarios c, facturaprof d, vehiculo e, caracteristica f,marcas g, modelo h,placas i, clases j,tipos k, uso l
			where
			a.id_asignacion=b.id_asignacion and      f.codmarveh=g.codmar and f.codclaveh=j.codcla and
			f.codtipveh=k.codtip  and		f.codmod=h.codmod and  			 i.sercarveh=e.sercarveh and f.codusoveh=l.coduso  and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh  and d.id_estatus='15' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract
			";
 
 	 
 	if($precioj=='1') $sql=$sql." and f.anomodveh>='2014' 
 	
			  "; 
 	
 	else  $sql=$sql." and f.anomodveh<'2014'";
 	if($mov=='MA') $sql=$sql." and a.estatus='A' and d.estatus='A' "; else $sql=$sql." and a.estatus='E' and d.estatus='E' ";
 	if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
 	if($mov=='MA')  $sql=$sql."  and a.tipmov_txt<>'ME' "; else $sql=$sql."  and a.tipmov_txt='ME' and numenvveh is not null   ";
 	if($numenv)     $sql=$sql."  and a.numenvveh= ".$numenv."  "; else  $sql=$sql."  and a.estatusveh='P' ";
 	if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
 	$sql=$sql." order by a.tipmov_txt desc, f.codmod, b.codpro, a.numcerveh";
 	//print '<pre>'; print $sql; die();
 	$conexion = $this->conectar();
 	$consulta = $this->consultar($conexion,$sql);
 	$consulta = $this->ret_vector($consulta);
 	$this->desconectar($conexion);
 	return $consulta;
 }
 
 

  function listarVehTxtEli($numlotveh,$tipo,$numenv,$origen,$mov,$precioj){

    $sql = "select
			a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
            to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
            a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
            substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), a.tipmov_txt
			from
			certificados a, asignacion b, propietarios c,  vehiculo e, caracteristica f
			where
			a.id_asignacion=b.id_asignacion and b.status='L' and  a.tipmov_txt='ME' and
			b.codpro=c.codpro and  a.numenvveh is not null and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and a.estatus='E'
			";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($numenv)     $sql=$sql."  and a.numenvveh= ".$numenv."  "; else  $sql=$sql."  and a.estatusveh='P' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
  if($precioj=='1') $sql=$sql." and f.anomodveh>='2014' "; else  $sql=$sql." and f.anomodveh<'2014'";
                  $sql=$sql." order by a.tipmov_txt desc, f.codmod, b.codpro, a.numcerveh";

  //print '<pre>'.' listar eliminado:'; print $sql; die();
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

   function listarVehProEli($numlotveh,$tipo,$numenv,$origen,$mov,$precioj){

    $sql = "select
			a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
            to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
            a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
            substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), a.tipmov_pro, (c.urbbarpro||', Municipio: '||c.dismunpro) as dir,
            (c.tlfcelpro) as tlf, g.desmod,c.prinompro,c.segnompro,c.priapepro,c.segapepro,
            c.calavepro,c.urbbarpro,c.edicaspro,c.numpispro,c.numapapro,c.dismunpro,c.tlfcel2pro,i.codmar,h.codestveh,e.sernivveh,to_char(a.fecfac1veh,'yyyymmdd'),c.nomorgpro
			from
			certificados a, asignacion b, propietarios c,  vehiculo e, caracteristica f, modelo g,  placas h, marcas i
			where  h.sercarveh=e.sercarveh and f.codmod=g.codmod and
			a.id_asignacion=b.id_asignacion and b.status='L' and  a.tipmov_pro='ME' and
			b.codpro=c.codpro and  a.numenvpro is not null and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and a.estatus='E' and f.codmarveh=i.codmar
			";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($numenv)     $sql=$sql."  and a.numenvpro= ".$numenv."  "; else  $sql=$sql."  and a.estatuspro='P' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
  if($precioj=='1') $sql=$sql." and f.anomodveh>='2014' "; else  $sql=$sql." and f.anomodveh<'2014'";
                  $sql=$sql." order by a.tipmov_pro desc, f.codmod, b.codpro, a.numcerveh";
 //print '<pre>'; print $sql; die();
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function listarProTxt($numlotveh,$tipo,$numenv,$origen,$mov,$precioj){

$sql = "select
			a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
            to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
            a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
            substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), a.tipmov_pro, (c.urbbarpro||', Municipio: '||c.dismunpro) as dir,
            (c.tlfcelpro) as tlf, g.desmod,c.prinompro,c.segnompro,c.priapepro,c.segapepro,
            c.calavepro,c.urbbarpro,c.edicaspro,c.numpispro,c.numapapro,c.dismunpro,c.tlfcel2pro,i.codmar,h.codestveh,e.sernivveh,to_char(a.fecfac1veh,'yyyymmdd'),c.nomorgpro
			from
			certificados a, asignacion b, propietarios c, facturaprof d, vehiculo e, caracteristica f, modelo g,  placas h, marcas i
			where
			a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh  and d.id_estatus='15' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and h.sercarveh=e.sercarveh and f.codmod=g.codmod and f.codmarveh=i.codmar
			";
  	

  
if($precioj=='1') $sql=$sql." and f.anomodveh>='2014' ";
   else  $sql=$sql." and f.anomodveh<'2014'"; 
  if($mov=='MA') $sql=$sql." and a.estatus='A' and d.estatus='A' "; else $sql=$sql." and a.estatus='E' and d.estatus='E' ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($mov=='MA')  $sql=$sql."  and a.tipmov_pro<>'ME' "; else $sql=$sql."  and a.tipmov_pro='ME' and numenvpro is not null   ";
  if($numenv)     $sql=$sql."  and a.numenvpro= ".$numenv."  "; else  $sql=$sql."  and a.estatuspro='P' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
                  $sql=$sql." order by a.tipmov_pro desc, f.codmod, b.codpro, a.numcerveh";
 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

   function listarVehTxtElim($numlotveh,$tipo,$numenv,$origen,$mov){

    $sql = "select
			a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
            to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
            a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
            substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), a.tipmov_txt
			from
			certificados a, asignacion b, propietarios c, facturaprof d, vehiculo e, caracteristica f
			where
			a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh and a.estatus='E' and d.id_estatus='15' and d.estatus='A' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract
			";
  $sql=$sql."  and a.tipmov_txt='ME' and a.estatusveh='P'   and f.origenveh='I' and numenvveh is not null  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($numenv)     $sql=$sql."  and a.numenvveh= ".$numenv."  ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
                  $sql=$sql." order by a.tipmov_txt desc, b.codpro, a.numcerveh";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listarVehTxtCon($numenv,$tipo,$sercarveh,$codpro,$nomcomp,$tipoEnvio,$categoria,$offset){

    $sql = "select
			a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
            to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
            a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
            substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), a.tipmov_txt,
            a.numenvveh, a.fechatxtveh, a.numenvpro, a.fechatxtpro, a.numenvpla, a.fechatxtpla
			from
			certificados a, asignacion b, propietarios c"; //", venta d
			$sql.= ", vehiculo e, caracteristica f
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro"; //and a.sercarveh=d.sercarveh and d.status_venta='LIQ'
			$sql.= " and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and a.tipmov_txt<>'ME'
			";

  if($tipo!='X')  $sql=$sql."  and a.$tipo='E' ";
  if($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
  if($codpro)  $sql=$sql." and b.codpro like '%".$codpro."%'";
  if($nomcomp)  $sql=$sql." and c.nomcomp like '%".$nomcomp."%'";
  if($categoria)  $sql=$sql." and f.id_caract=".$categoria." ";
  if($tipoEnvio!='X' and $numenv!='X' ) if($numenv)     $sql=$sql."  and a.$tipoEnvio= ".$numenv."  ";
                  $sql=$sql." order by a.numenvveh desc,a.numenvpro desc,a.numenvpla desc, a.numcerveh ";
                  $sql = $sql." LIMIT 15 OFFSET ".$offset;
 // print '<pre>Lista'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
 function listarVehTxtConElim($certificado,$sercarveh,$codpro,$nomcomp,$offset){

    $sql = "select
			a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
            to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
            a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
            substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), a.tipmov_txt,
            a.numenvveh, a.fechatxtveh, a.numenvpro, a.fechatxtpro, a.numenvpla, a.fechatxtpla, a.tipmov_pro, a.tipmov_pla
			from
			certificados a, asignacion b, propietarios c, venta d, vehiculo e, caracteristica f
			where
			a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh and d.status_venta='LIQ' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract
			";
      if($certificado)  $sql=$sql." and a.numcerveh like '%".$certificado."%'";
	  if($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
	  if($codpro)  $sql=$sql." and b.codpro like '%".$codpro."%'";
	  if($nomcomp)  $sql=$sql." and c.nomcomp like '%".$nomcomp."%'";
                  $sql=$sql." order by a.numenvveh desc,a.numenvpro desc,a.numenvpla desc";
                  $sql = $sql." LIMIT 15 OFFSET ".$offset;
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function contarVehTxtConElim($certificado,$sercarveh,$codpro,$nomcomp){

    $sql = "select
			count(b.sercarveh)
			from
			certificados a, asignacion b, propietarios c, venta d, vehiculo e, caracteristica f
			where
			a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh and d.status_venta='LIQ' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract
			";
      if($certificado)  $sql=$sql." and a.numcerveh like '%".$certificado."%'";
	  if($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
	  if($codpro)  $sql=$sql." and b.codpro like '%".$codpro."%'";
	  if($nomcomp)  $sql=$sql." and c.nomcomp like '%".$nomcomp."%'";

 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }
 function contarVehTxt($numenv,$tipo,$sercarveh,$codpro,$nomcomp,$tipoEnvio,$categoria){

   $sql = "select
			count(a.numcerveh)
			from
			certificados a, asignacion b, propietarios c"; //, venta d
			$sql.= ", vehiculo e, caracteristica f
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro"; // and a.sercarveh=d.sercarveh and d.status_venta='LIQ'
			$sql.= "  and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and a.tipmov_txt<>'ME'
					
					
			";		
			
			
		

  if($tipo!='X')  $sql=$sql."  and a.$tipo='E' ";
  if($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
  if($codpro)  $sql=$sql." and b.codpro like '%".$codpro."%'";
  if($nomcomp)  $sql=$sql." and c.nomcomp like '%".$nomcomp."%'";
  if($categoria)  $sql=$sql." and f.id_caract=".$categoria." ";
  if($tipoEnvio!='X' and $numenv!='X' ) if($numenv)     $sql=$sql."  and a.$tipoEnvio= ".$numenv."  ";

  //print '<pre>Cuenta Envios: '; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

 function txtVehImp($numenv,$precioj){

 	$sql = "select 		d.tipmov_txt, substr(d.numcerveh,3,7),d.nummodveh,a.codmarveh,desserie(a.codserie),c.desmod,a.anomodveh,
			m.sercarveh,m.sermotveh,k.numplaveh,m.col1veh,m.col2veh,a.pesveh,a.tipcapveh,a.capcarveh,a.numejeveh,
			a.diarueveh,g.codcla,h.codtip,i.coduso,to_char(d.fecha_reg,'yyyymmdd'),o.codpro,a.codptoveh,a.numlicveh,to_char(a.fecplaveh,'yyyymmdd'),
			a.numfacveh,to_char(a.fecfacveh,'yyyymmdd'),d.numcerveh,a.anofabveh,m.sernivveh,m.serchaveh,d.numfac1veh,to_char(d.fecfac1veh,'yyyymmdd'),
			m.numhomveh,to_char(m.fechomveh,'yyyymmdd'),a.codserveh,a.numpueveh,k.numrafveh,to_char(k.fecrafveh,'yyyymmdd'),k.numsecveh,'' as sercarr,a.codconveh
			from
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
			asignacion l, vehiculo m, certificados d, placas k,  ptoadu n, propietarios o, facturaprof p
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
			m.estatus='A' and l.status='A' and d.estatus='A' and m.sercarveh=p.sercarveh and p.estatus='A' and p.id_estatus='15' ";

 	      // if($precioj=='1') $sql=$sql." and a.anomodveh>='2014' ";/*and d.id_certificado>'27500'"; */ else  $sql=$sql." and a.anomodveh<'2014'";
            if($numenv)  $sql=$sql."  and d.numenvveh= ".$numenv."  "; else  $sql=$sql."  and d.estatusveh='P' ";

 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function txtVehImpElim($numenv,$precioj){

 	$sql = "select
			d.tipmov_txt, substr(d.numcerveh,3,7),d.nummodveh,a.codmarveh,desserie(a.codserie),c.desmod,a.anomodveh,
			m.sercarveh,m.sermotveh,k.numplaveh,m.col1veh,m.col2veh,a.pesveh,a.tipcapveh,a.capcarveh,a.numejeveh,
			a.diarueveh,g.codcla,h.codtip,i.coduso,to_char(d.fecha_reg,'yyyymmdd'),o.codpro,a.codptoveh,a.numlicveh,to_char(a.fecplaveh,'yyyymmdd'),
			a.numfacveh,to_char(a.fecfacveh,'yyyymmdd'),d.numcerveh,a.anofabveh,m.sernivveh,m.serchaveh,d.numfac1veh,to_char(d.fecfac1veh,'yyyymmdd'),
			m.numhomveh,to_char(m.fechomveh,'yyyymmdd'),a.codserveh,a.numpueveh,k.numrafveh,to_char(k.fecrafveh,'yyyymmdd'),k.numsecveh,'' as sercarr,a.codconveh
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
			l.status='L' and  d.tipmov_txt='ME' and  d.numenvveh is not null and d.estatus='E' ";
 	        if($numenv)  $sql=$sql."  and d.numenvveh= ".$numenv."  "; else  $sql=$sql."  and d.estatusveh='P' ";
           // if($precioj=='1') $sql=$sql." and a.anomodveh>='2014'"; else  $sql=$sql." and a.anomodveh<'2014'";


 //print '<pre>'; print $sql; die();
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function txtVehNac($numenv){

 	$sql = "select
			d.tipmov_txt, substr(d.numcerveh,3,7),d.nummodveh,a.codmarveh,desserie(a.codserie),c.desmod,a.anomodveh,
			m.sercarveh,m.sermotveh,k.numplaveh,m.col1veh,m.col2veh,a.pesveh,a.tipcapveh,a.capcarveh,a.numejeveh,
			a.diarueveh,g.codcla,h.codtip,i.coduso,to_char(d.fecha_reg,'yyyymmdd'),o.codpro,a.codptoveh,a.numlicveh,to_char(a.fecplaveh,'yyyymmdd'),
			a.numfacveh,to_char(a.fecfacveh,'yyyymmdd'),d.numcerveh,a.anofabveh,m.sernivveh,m.serchaveh,d.numfac1veh,to_char(d.fecfac1veh,'yyyymmdd'),
			m.numhomveh,m.fechomveh,a.codserveh,a.numpueveh,k.numrafveh,to_char(k.fecrafveh,'yyyymmdd'),k.numsecveh,'' as sercarr,a.codconveh
			from
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
			asignacion l, vehiculo m, certificados d, placas k,   propietarios o, venta p
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
			m.estatus='A' and l.status='A' and d.estatus='A' and m.sercarveh=p.sercarveh and d.estatusveh='P' ";
 
            if($numenv)  $sql=$sql."  and d.numenvveh= ".$numenv."  ";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


 function txtPro($numenv, $mov){

   $sql = "select  a.tipmov_pro, substr(a.numcerveh,3,6),c.codpro,c.prinompro, c.segnompro,c.priapepro, c.segapepro,
			c.calavepro,c.urbbarpro,c.edicaspro,c.numpispro,c.numapapro,c.dismunpro,c.tlfcelpro,c.tlfcel2pro,
            h.numplaveh,f.codmarveh,h.codestveh,e.sernivveh,to_char(a.fecfac1veh,'yyyymmdd'),a.numfac1veh,c.nomorgpro
			from
			certificados a, asignacion b, propietarios c, facturaprof d, vehiculo e, caracteristica f, modelo g, placas h
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro  and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and f.codmod=g.codmod and h.sercarveh=e.sercarveh
			and  a.estatuspro='E' and e.sercarveh=d.sercarveh and d.estatus='A' and d.id_estatus='15' and a.tipmov_pro<>'ME'  ";
   	

   if($numenv)  $sql=$sql."  and a.numenvpro= ".$numenv."  ";
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function txtProElim($numenv, $mov,$precioj){

    $sql = "select  a.tipmov_pro , substr(a.numcerveh,3,6),c.codpro,c.prinompro, c.segnompro,c.priapepro, c.segapepro,
			c.calavepro,c.urbbarpro,c.edicaspro,c.numpispro,c.numapapro,c.dismunpro,c.tlfcelpro,c.tlfcel2pro,
            h.numplaveh,f.codmarveh,h.codestveh,e.sernivveh,to_char(a.fecfac1veh,'yyyymmdd'),a.numfac1veh,c.nomorgpro
			from
			certificados a, asignacion b, propietarios c, vehiculo e, caracteristica f, modelo g, placas h
			where
			 h.sercarveh=e.sercarveh and f.codmod=g.codmod and
			a.id_asignacion=b.id_asignacion and b.status='L' and  a.tipmov_pro='ME' and
			b.codpro=c.codpro and  a.numenvpro is not null and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and a.estatus='E'";
    	
   if($numenv)  $sql=$sql."  and a.numenvpro= ".$numenv."  ";
   if($precioj=='1') $sql=$sql." and f.anomodveh>='2014'"; else   $sql=$sql." and f.anomodveh<'2014'";
   $sql=$sql."  order by  c.codpro";
   //--and a.tipmov_txt<>'ME'
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
 function listarPlaTxt($numlotveh,$tipo,$numenv,$origen,$precioj){

   $sql = 
   "select a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
            to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
            a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
            substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), c.tipmovpro,h.numplaveh,
            i.desest, g.desmod, h.numrafveh||'/'||to_char(h.fecrafveh,'dd-mm-yyyy'),h.codestveh,h.numrafveh,h.numsecveh
			from
			certificados a, asignacion b, propietarios c, facturaprof d, vehiculo e, caracteristica f, modelo g,  placas h, estado i
			where
			a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh  and d.id_estatus='15' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and h.sercarveh=e.sercarveh and f.codmod=g.codmod and i.codest=h.codestveh";
	     
  $sql=$sql." and a.estatus='A' and d.estatus='A' ";

  if($precioj=='1') $sql=$sql." and f.anomodveh>='2014'

  		
  		";  
  else  $sql=$sql." and f.anomodveh<'2014'"; 
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($numenv)     $sql=$sql."  and a.numenvpla= ".$numenv."  "; else  $sql=$sql."  and a.estatuspla='P' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
                  $sql=$sql." order by f.codmod ,h.numplaveh desc, b.codpro, a.numcerveh";
 //  print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


  function txtPla($numenv){

    $sql = "select 
			c.codpro,h.numplaveh, h.codestveh,h.numrafveh,h.numsecveh
			from
			certificados a, asignacion b, propietarios c, facturaprof d, vehiculo e, caracteristica f, modelo g, placas h, estado i
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh and d.estatus='A' and d.id_estatus='15' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and f.codmod=g.codmod and h.sercarveh=e.sercarveh and i.codest=h.codestveh
			and  a.estatuspla='E' and a.tipmov_pla<>'ME'"; 
    

   if($numenv)  $sql=$sql."  and a.numenvpla= ".$numenv."  ";
    $sql=$sql." order by h.numplaveh";
 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 
 
 /*   ORIGINAL*/
  
  
 function buscarEstatus($numlotveh,$tipo,$origen,$estatus,$mov,$precioj){
 	$fecha=date('d/m/Y');
 	$conexion = $this->conectar();
 	$sql = $sql."select d.* from certificados, asignacion b, facturaprof d, vehiculo e, caracteristica f";
 	$sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.estatus='A' and d.id_estatus='15' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.".$estatus."='P'";
 	$sql=$sql."  and certificados.".$mov."<>'ME'  ";
 	if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
 	if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
 	if($precioj=='1') $sql=$sql." and f.anomodveh>='2014'	"; else   $sql=$sql." and f.anomodveh<'2014'";
 	//print '<pre>'; print $sql;
 	$consulta = $this->consultar($conexion,$sql);
 	$consulta = $this->ret_vector($consulta);
 
 	if (count($consulta)>0){
 		$consulta=true;
 	}else
 		$consulta=false;
 
 	$this->desconectar($conexion);
 	return $consulta;
 }
 
 
 /*
 function buscarEstatus($numlotveh,$tipo,$origen,$estatus,$mov,$precioj){
   $fecha=date('d/m/Y');
  $conexion = $this->conectar();
  $sql = $sql."select d.* from certificados, asignacion b, facturaprof d, vehiculo e, caracteristica f";
  $sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.estatus='A' and d.id_estatus='15' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.".$estatus."='P'";
  $sql=$sql."  and certificados.".$mov."<>'ME'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
 if($precioj=='1') $sql=$sql." and f.anomodveh>='2014'
 		 	AND f.codmod IN ('X1') AND f.id_caract>='648' AND f.id_caract<='653'  
	--AND f.codmod IN ('X1') AND f.id_caract>='654' AND f.id_caract<='659'  
	--AND f.codmod IN ('X1') AND f.id_caract>='660' AND f.id_caract<='661'  
	--AND f.codmod IN ('TI2')   
	--AND f.codmod IN ('TIG') 
	--AND f.codmod IN ('T44') 
	--AND f.codmod IN ('TG4') 
 		
 		
 		"; else   $sql=$sql." and f.anomodveh<'2014'"; 
 //print '<pre>'; print $sql;
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (count($consulta)>0){
     $consulta=true;
  }else
     $consulta=false;

  $this->desconectar($conexion);
  return $consulta;
 }*/

  function buscarEstatus_n($numlotveh,$tipo,$origen,$estatus,$mov){
  $fecha=date('d/m/Y');
  $conexion = $this->conectar();
  $sql = $sql."select d.* from certificados, asignacion b, entrega d, vehiculo e, caracteristica f";
  $sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.status='A' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.".$estatus."='P'";
  $sql=$sql."  and certificados.".$mov."<>'ME'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
  //print '<pre>'; print $sql;
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (count($consulta)>0){
     $consulta=true;
  }else
     $consulta=false;

  $this->desconectar($conexion);
  return $consulta;
 }

 /*  ORIGINAL */
   function buscarEstatusElim($numlotveh,$tipo,$origen,$estatus,$mov,$numenvT,$precioj){
     $fecha=date('d/m/Y');
  $conexion = $this->conectar();
  $sql = $sql."
			 select a.codpro, estatusveh , numenvveh , fechatxtveh , estatuspro , numenvpro ,
			 fechatxtpro , estatuspla , numenvpla , fechatxtpla,
			 tipmov_txt, tipmov_pro, tipmov_pla
			 from asignacion  a,certificados b, vehiculo e,caracteristica f
			 where a.status='L' and
			 a.id_asignacion=b.id_asignacion and
			 $numenvT is not null and
			 b.estatus='E' and b.".$estatus."='P' and
			 b.".$mov."='ME' and
			 a.sercarveh=e.sercarveh and
			 e.id_caract=f.id_caract  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($precioj=='1') $sql=$sql." and f.anomodveh>='2014'"; else   $sql=$sql." and f.anomodveh<'2014'";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
  print '<pre>'.' busca : '; print $sql; die();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (count($consulta)>0){
     $consulta=true;
  }else
     $consulta=false;

  $this->desconectar($conexion);
  return $consulta;
 }
 function cambiarEstatus($numlotveh,$tipo,$numenv,$origen,$estatus,$mov,$precioj){
 	$fecha=date("d/m/Y H:i:s");
 	$conexion = $this->conectar();
 	$sql = $sql."select d.* from certificados, asignacion b, facturaprof d, vehiculo e, caracteristica f";
 	$sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.estatus='A' and d.id_estatus='15' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.".$estatus."='P'";
 	$sql=$sql."  and certificados.".$mov."<>'ME'  ";
 	if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
 	if($precioj=='1') $sql=$sql." and f.anomodveh>='2014'	"; else  $sql=$sql." and f.anomodveh<'2014'";
 
 	if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
 
 	//print '<pre>'; print $sql;
 
 	$consulta = $this->consultar($conexion,$sql);
 	$consulta = $this->ret_vector($consulta);
 
 	if (count($consulta)>0){
 		$sql = "update certificados set estatusveh='E', numenvveh=$numenv , fechatxtveh='$fecha'";
 		$sql = $sql." from asignacion b, facturaprof d, vehiculo e, caracteristica f";
 		$sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.estatus='A' and d.id_estatus='15'  and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.estatusveh='P'";
 		if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
 		if(!$tipo)  $sql=$sql."  and certificados.".$mov."<>'ME' ";
 		if($precioj=='1') $sql=$sql." and f.anomodveh>='2014'";	else  $sql=$sql." and f.anomodveh<'2014'";
 		if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
 		//print '<pre>'; print $sql;
 
 		$consulta = $this->consultar($conexion,$sql);
 	}else $consulta=false;
 	$this->desconectar($conexion);
 	return $consulta;
 }
 /*
 function cambiarEstatus($numlotveh,$tipo,$numenv,$origen,$estatus,$mov,$precioj){
  $fecha=date("d/m/Y H:i:s");
  $conexion = $this->conectar();
  $sql = $sql."select d.* from certificados, asignacion b, facturaprof d, vehiculo e, caracteristica f";
  $sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.estatus='A' and d.id_estatus='15' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.".$estatus."='P'";
  $sql=$sql."  and certificados.".$mov."<>'ME'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($precioj=='1') $sql=$sql." and f.anomodveh>='2014' 
  		
  		
  		 	AND f.codmod IN ('X1') AND f.id_caract>='648' AND f.id_caract<='653'  
	--AND f.codmod IN ('X1') AND f.id_caract>='654' AND f.id_caract<='659'  
	--AND f.codmod IN ('X1') AND f.id_caract>='660' AND f.id_caract<='661'  
	--AND f.codmod IN ('TI2')   
	--AND f.codmod IN ('TIG') 
	--AND f.codmod IN ('T44') 
	--AND f.codmod IN ('TG4') 
  		
  		
  		"; else  $sql=$sql." and f.anomodveh<'2014'"; 
  
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";

  //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (count($consulta)>0){
  $sql = "update certificados set estatusveh='E', numenvveh=$numenv , fechatxtveh='$fecha'";
  $sql = $sql." from asignacion b, facturaprof d, vehiculo e, caracteristica f";
  $sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.estatus='A' and d.id_estatus='15'  and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.estatusveh='P'";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if(!$tipo)  $sql=$sql."  and certificados.".$mov."<>'ME' ";
  if($precioj=='1') $sql=$sql." and f.anomodveh>='2014'
  		 	AND f.codmod IN ('X1') AND f.id_caract>='648' AND f.id_caract<='653'  
	--AND f.codmod IN ('X1') AND f.id_caract>='654' AND f.id_caract<='659'  
	--AND f.codmod IN ('X1') AND f.id_caract>='660' AND f.id_caract<='661'  
	--AND f.codmod IN ('TI2')   
	--AND f.codmod IN ('TIG') 
	--AND f.codmod IN ('T44') 
	--AND f.codmod IN ('TG4') 
  		  		";
   else  $sql=$sql." and f.anomodveh<'2014'"; 
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
  //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  }else $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
 }*/

 function cambiarEstatusEli($numlotveh,$tipo,$origen,$estatus,$mov,$numenvT,$numenv,$precioj){
  $fecha=date("d/m/Y H:i:s");
  $conexion = $this->conectar();
    $sql = $sql."
			 select a.codpro, estatusveh , numenvveh , fechatxtveh , estatuspro , numenvpro ,
			 fechatxtpro , estatuspla , numenvpla , fechatxtpla,
			 tipmov_txt, tipmov_pro, tipmov_pla
			 from asignacion  a,certificados b, vehiculo e,caracteristica f
			 where a.status='L' and
			 a.id_asignacion=b.id_asignacion and
			 $numenvT is not null and
			 b.estatus='E' and b.".$estatus."='P' and
			 b.".$mov."='ME' and
			 a.sercarveh=e.sercarveh and
			 e.id_caract=f.id_caract  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($precioj=='1') $sql=$sql." and f.anomodveh>='2014' "; else  $sql=$sql." and f.anomodveh<'2014'";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";

 //print '<pre>'; print $sql; die();

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (count($consulta)>0){
  $sql = "update certificados set estatusveh='E', numenvveh=$numenv , fechatxtveh='$fecha'";
  $sql = $sql." from asignacion b, vehiculo e, caracteristica f";
  $sql = $sql."  where b.status='L' and  certificados.id_asignacion=b.id_asignacion and
               $numenvT is not null and certificados.estatus='E' and certificados.estatusveh='P' and
               certificados.".$mov."='ME' and  b.sercarveh=e.sercarveh and  e.id_caract=f.id_caract  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
  if($precioj=='1') $sql=$sql." and f.anomodveh>='2014'"; else  $sql=$sql." and f.anomodveh<'2014'";
// print '<pre>'; print $sql; die();

  $consulta = $this->consultar($conexion,$sql);
  }else $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
 }

/*  original*/
  function cambiarEstatusPro($numlotveh,$tipo,$numenv,$precioj){
  $fecha=date("d/m/Y H:i:s");
  $conexion = $this->conectar();
  $sql = $sql."select d.* from certificados, asignacion b, facturaprof d, vehiculo e, caracteristica f, modelo g,  placas h";
  $sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.estatus='A' and d.id_estatus='15' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.estatuspro='P' and h.sercarveh=e.sercarveh and f.codmod=g.codmod";
  $sql=$sql."  and certificados.tipmov_pro<>'ME'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($precioj=='1') $sql=$sql." and f.anomodveh>='2014' "; else  $sql=$sql." and f.anomodveh<'2014'";

 // print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
//print 'aqui'.count($consulta);
  if (count($consulta)>0){
  $sql = "update certificados set estatuspro='E', numenvpro=$numenv , fechatxtpro='$fecha'";
  $sql = $sql." from asignacion b, facturaprof d, vehiculo e, caracteristica f, modelo g,  placas h";
 $sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.estatus='A' and d.id_estatus='15' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.estatuspro='P' and h.sercarveh=e.sercarveh and f.codmod=g.codmod";
  $sql=$sql."  and certificados.tipmov_pro<>'ME'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($precioj=='1') $sql=$sql." and f.anomodveh>='2014'"; else  $sql=$sql." and f.anomodveh<'2014'";
 // print '<pre>'; print $sql;

 $consulta = $this->consultar($conexion,$sql);
  }else $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
 }
 
 /*
 function cambiarEstatusPro($numlotveh,$tipo,$numenv,$precioj){
 	$fecha=date("d/m/Y H:i:s");
 	$conexion = $this->conectar();
 	$sql = $sql."select d.* from certificados, asignacion b, facturaprof d, vehiculo e, caracteristica f, modelo g,  placas h";
 	$sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.estatus='A' and d.id_estatus='15' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.estatuspro='P' and h.sercarveh=e.sercarveh and f.codmod=g.codmod";
 	$sql=$sql."  and certificados.tipmov_pro<>'ME'  ";
 	if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
 	if($precioj=='1') $sql=$sql." and f.anomodveh>='2014' 
 	  AND f.codmod IN ('X1') AND f.id_caract>='648' AND f.id_caract<='653'  
	--AND f.codmod IN ('X1') AND f.id_caract>='654' AND f.id_caract<='659'  
	--AND f.codmod IN ('X1') AND f.id_caract>='660' AND f.id_caract<='661'  
	--AND f.codmod IN ('TI2')   
	--AND f.codmod IN ('TIG') 
	--AND f.codmod IN ('T44') 
	--AND f.codmod IN ('TG4') 
 	"; else  $sql=$sql." and f.anomodveh<'2014'";
 
 	// print '<pre>'; print $sql;
 
 	$consulta = $this->consultar($conexion,$sql);
 	$consulta = $this->ret_vector($consulta);
 	//print 'aqui'.count($consulta);
 	if (count($consulta)>0){
 		$sql = "update certificados set estatuspro='E', numenvpro=$numenv , fechatxtpro='$fecha'";
 		$sql = $sql." from asignacion b, facturaprof d, vehiculo e, caracteristica f, modelo g,  placas h";
 		$sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.estatus='A' and d.id_estatus='15' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.estatuspro='P' and h.sercarveh=e.sercarveh and f.codmod=g.codmod";
 		$sql=$sql."  and certificados.tipmov_pro<>'ME'  ";
 		if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
 		if($precioj=='1') $sql=$sql." and f.anomodveh>='2014'

 				AND f.codmod IN ('X1') AND f.id_caract>='648' AND f.id_caract<='653'  
			--AND f.codmod IN ('X1') AND f.id_caract>='654' AND f.id_caract<='659'  
			--AND f.codmod IN ('X1') AND f.id_caract>='660' AND f.id_caract<='661'  
			--AND f.codmod IN ('TI2')   
			--AND f.codmod IN ('TIG') 
			--AND f.codmod IN ('T44') 
			--AND f.codmod IN ('TG4') 		 				 				
		 		"; 
 		else  $sql=$sql." and f.anomodveh<'2014'";
 		// print '<pre>'; print $sql;
 
 		$consulta = $this->consultar($conexion,$sql);
 	}else $consulta=false;

 	$this->desconectar($conexion);
 	return $consulta;
 }*/
function cambiarEstatusProElim($numlotveh,$tipo,$origen,$estatus,$mov,$numenvT,$numenv,$precioj){
   $fecha=date("d/m/Y H:i:s");
  $conexion = $this->conectar();
    $sql = $sql."
			 select a.codpro, estatuspro , numenvpro , fechatxtpro , estatuspro , numenvpro ,
			 fechatxtpro , estatuspla , numenvpla , fechatxtpla,
			 tipmov_txt, tipmov_pro, tipmov_pla
			 from asignacion  a,certificados b, vehiculo e,caracteristica f
			 where a.status='L' and
			 a.id_asignacion=b.id_asignacion and
			 $numenvT is not null and
			 b.estatus='E' and b.".$estatus."='P' and
			 b.".$mov."='ME' and
			 a.sercarveh=e.sercarveh and
			 e.id_caract=f.id_caract  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
  if($precioj=='1') $sql=$sql." and f.anomodveh>='2014' "; else  $sql=$sql." and f.anomodveh<'2014'";
  

// print '<pre>'; print $sql.'-------------'.$precioj; //die();

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (count($consulta)>0){
  $sql = "update certificados set estatuspro='E', numenvpro=$numenv , fechatxtpro='$fecha'";
  $sql = $sql." from asignacion b, vehiculo e, caracteristica f";
  $sql = $sql."  where b.status='L' and  certificados.id_asignacion=b.id_asignacion and
               $numenvT is not null and certificados.estatus='E' and certificados.estatuspro='P' and
               certificados.".$mov."='ME' and  b.sercarveh=e.sercarveh and  e.id_caract=f.id_caract  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
  if($precioj=='1') $sql=$sql." and f.anomodveh>='2014'"; else  $sql=$sql." and f.anomodveh<'2014'";
// print '<pre>'; print $sql; die();

  $consulta = $this->consultar($conexion,$sql);
  }else $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
}

 function cambiarEstatusPla($numlotveh,$tipo,$numenv,$precioj){
 $fecha=date("d/m/Y H:i:s");
  $conexion = $this->conectar();
  $sql = $sql."select d.* from certificados, asignacion b, facturaprof d, vehiculo e, caracteristica f, modelo g,  placas h";
  $sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.estatus='A' and d.id_estatus='15' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.estatuspla='P' and h.sercarveh=e.sercarveh and f.codmod=g.codmod";
  $sql=$sql."  and certificados.tipmov_pla<>'ME'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($precioj=='1') $sql=$sql." and f.anomodveh>='2014'   ";
  else  $sql=$sql." and f.anomodveh<'2014'";
  

 // print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
//print 'aqui'.count($consulta);
  if (count($consulta)>0){
  $sql = "update certificados set estatuspla='E', numenvpla=$numenv , fechatxtpla='$fecha'";
  $sql = $sql." from asignacion b, facturaprof d, vehiculo e, caracteristica f, modelo g,  placas h";
 $sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.estatus='A' and d.id_estatus='15' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.estatuspla='P' and h.sercarveh=e.sercarveh and f.codmod=g.codmod";
  $sql=$sql."  and certificados.tipmov_pla<>'ME'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($precioj=='1') $sql=$sql." and f.anomodveh>='2014'"; else  $sql=$sql." and f.anomodveh<'2014'";
  // print '<pre>'; print $sql;

 $consulta = $this->consultar($conexion,$sql);
  }else $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
 }

  function registrarEnvios($numenv,$origen,$ma,$mm,$me){
  $fecha=date('d/m/Y');
  $sql = "INSERT INTO enviostxt VALUES ($numenv,'".$fecha."','".$origen."',$ma,$mm,$me)";
 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
//  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/reg_txt.php');
  return $consulta;
 }

 function comboEnvio($cond=null,$offset=null){

    $sql = "select
			nroenvio, to_char(fechaenvio,'dd/mm/yyyy') , ma, mm, me,
			(case tipoenvio when 'P' THEN 'Placa' when 'B' THEN 'Beneficiario' when 'I' THEN 'Importado'  when 'N' THEN 'Nacional' end) as tipo, trim(tipoenvio), estatus,
			trim(tipoenvio),(case estatus when 'P' THEN 'Pendiente' when 'A' THEN 'Aceptado' when 'R' THEN 'Rechazado' end) as status
			from
			enviostxt";
    if 	($cond=='1')  $sql=$sql." where estatus='P'";
	if 	(!$cond) $sql=$sql." where estatus='A'";
    $sql=$sql." order by nroenvio desc ";
    if($offset)
    $sql = $sql." LIMIT 24 OFFSET ".$offset;

//  print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function contarcomboEnvio($cond=null){

    $sql = "select
			count(nroenvio)
			from
			enviostxt";
    if 	($cond=='1')  $sql=$sql." where estatus='P'";
	if 	(!$cond) $sql=$sql." where estatus='A'";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

 function autorizacion($numenv){

    $sql = "
			select
			nroenvio,trim(tipoenvio) as tipoenvio, to_char(fechaenvio,'dd/mm/yyyy') as fechaenvio, ma,mm,me,
				(CASE WHEN tipoenvio='I' THEN 'Importados'
					     WHEN tipoenvio='N' THEN 'Nacionales'
					     WHEN tipoenvio='P' THEN 'Placas'
					     WHEN tipoenvio='B' THEN 'Propietarios'
				ELSE
				     ' '
				END) as tipo,
				(CASE WHEN tipoenvio='P' THEN 'placas'
				      WHEN tipoenvio='B' THEN 'propietario'
				ELSE
				     trim(tipoenvio)
				END) as nombre
			from
			enviostxt
			where
			nroenvio='".$numenv."' and estatus<>'R' ";

 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listarEnvioVeh($aut=null){

  $sql = "select distinct(nroenvio) as num  from enviostxt ";
  if ($aut=='A') $sql .= " where estatus<>'R' ";
  $sql.= " order by nroenvio ";
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);


  $this->desconectar($conexion);
  return $consulta;
 }


 function cambiarEstatusEnvio($nroenvio,$tipo,$estatus){
  $conexion = $this->conectar();

  for($i=0;$i<=count($estatus)-1;$i++){
  	if ($estatus[$i]<>'P'){
	  $sql = "update enviostxt set estatus='".$estatus[$i]."' where nroenvio='".$nroenvio[$i]."' and tipoenvio='".$tipo[$i]."'";
	  $consulta = $this->consultar($conexion,$sql);
	//  print $sql.'<Br>';
  	}
  	if ($estatus[$i]=='R' and $tipo[$i]=='I'){
  	  $sql2 = "update certificados set estatusveh='P', numenvveh=null, fechatxtveh=null where numenvveh='".$nroenvio[$i]."' ";
  	}
  	if ($estatus[$i]=='R' and $tipo[$i]=='B'){
  	  $sql2 = "update certificados set estatuspro='P', numenvpro=null, fechatxtpro=null where numenvpro='".$nroenvio[$i]."' ";
  	}
  	if ($estatus[$i]=='R' and $tipo[$i]=='P'){
  	  $sql2 = "update certificados set estatuspla='P', numenvpla=null, fechatxtpla=null where numenvpla='".$nroenvio[$i]."' ";
  	}
  	 $consulta2 = $this->consultar($conexion,$sql2);
	 //print $sql2.'<Br>';

  }

  $this->desconectar($conexion);
  return $consulta;
 }

  function cambiarEstatusEnviodet($rechazados,$tipo){

  $conexion = $this->conectar();
  echo "Rechazado: ".count($rechazados);
  echo "<br>Tipo: ".$tipo;

//	echo 'cantidad;'.count($rechazados).'<Br>';
  for($i=0;$i<=count($rechazados)-1;$i++){
	//echo '1;'.($rechazados[2]).'<Br>';

  	if ($tipo=='I'){
  	//echo 'posicion:'.$i.'<Br>';
  	  $sql = "update certificados set tipmov_txt='MA', estatusveh='P', numenvveh=null, fechatxtveh=null where numcerveh='".$rechazados[$i]."' ";
  	}
  	if ($tipo=='B'){
  	  $sql = "update certificados set tipmov_pro='MA', estatuspro='P', numenvpro=null, fechatxtpro=null where numcerveh='".$rechazados[$i]."' ";
  	}
  	if ($tipo=='P'){
  	  $sql = "update certificados set tipmov_pla='MA', estatuspla='P', numenvpla=null, fechatxtpla=null where numcerveh='".$rechazados[$i]."' ";
  	}
  	 $consulta = $this->consultar($conexion,$sql);
	 //print $sql.'<Br>';
  }
  	//$sql="hola";
	//print $sql.'<Br>';
  $this->desconectar($conexion);
  //return $consulta;
 }

   function cambiarEstatusEnvioElim($rechazados,$tipo){
  $conexion = $this->conectar();
//	echo 'cantidad;'.count($rechazados).'<Br>';
  for($i=0;$i<=count($rechazados)-1;$i++){
	//echo '1;'.($rechazados[2]).'<Br>';

  	if ($tipo=='I' or $tipo=='T'){
  	//echo 'posicion:'.$i.'<Br>';
  	  $sql = "update certificados set tipmov_txt='ME', estatusveh='P', numenvveh=null, fechatxtveh=null where numcerveh='".$rechazados[$i]."' ";
  	  $consulta = $this->consultar($conexion,$sql);
  	}
  	if ($tipo=='B' or $tipo=='T'){
  	  $sql = "update certificados set tipmov_pro='ME', estatuspro='P', numenvpro=null, fechatxtpro=null where numcerveh='".$rechazados[$i]."' ";
  	  $consulta = $this->consultar($conexion,$sql);
  	}
  	if ($tipo=='P' or $tipo=='T'){
  	  $sql = "update certificados set tipmov_pla='ME', estatuspla='P', numenvpla=null, fechatxtpla=null where numcerveh='".$rechazados[$i]."' ";
  	  $consulta = $this->consultar($conexion,$sql);
  	}

	// print $sql.'<Br>';
  }

  $this->desconectar($conexion);
  return $consulta;
 }

   function registrarEnviostxtPro($data){
   	 $conexion = $this->conectar();

  $sql="INSERT INTO txtpropietario(tipmov_pro,numcerveh,cod_rifconce,rif_conce,dig_rifconce,nac,ced_pro,dig_rifpro,prinompro,segnompro,priapepro ,segapepro,
			nomorgpro,calavepro,urbbarpro,edicaspro,numpispro,numapapro,dismunparro,telcelpro,telcelpro2,marca,cod_est,sercarveh,fec_venta,numfacven,numenv_pro,fecha_reg,hora)
         values
           (
			'".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."',
			'".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."',
			'".$data[13]."','".$data[14]."','".$data[15]."','".$data[16]."','".$data[17]."','".$data[18]."','".$data[20]."',
			'".$data[21]."','".$data[22]."','".$data[23]."','".$data[24]."','".$data[25]."','".$data[26]."','".$data[27]."','" . date("d-m-Y") . "','" . date("H:i:s") . "')";
		 $consulta = $this->consultar($conexion,$sql);
		//  print $sql.'<Br>';
		 $this->desconectar($conexion);
	 	 return $consulta;

   }
    function registrarEnviostxtPla($data){
   	 $conexion = $this->conectar();

  $sql="INSERT INTO txtplacas(cod_rif,rif,dig_rif,numpla,cod_estado,status_asig,num_rafaga,num_seq,numenv_pla,fecha_reg,hora)
         values
           (
			'".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."',
			'".$data[7]."','".$data[8]."','" . date("d-m-Y") . "','" . date("H:i:s") . "')";
		 $consulta = $this->consultar($conexion,$sql);
	//  print $sql.'<Br>';
		 $this->desconectar($conexion);
	 	 return $consulta;

   }
    function registrarEnviostxtVeh($data){
   	 $conexion = $this->conectar();

  $sql="INSERT INTO txtvehiculo(tipmov_veh,numreg_intt,num_modif,codmar,serie,modelo,anomodveh,sercarveh,sermotveh,numplaveh,col1veh,col2veh,pesveh,tipcapveh,capcarveh,numejeveh,diarueveh,
		 clase,tipo,uso,fecemi_cer,cod_rif,rif,dig_rif,codptoveh,numplagrav,fec_liqgrav,numfac_adq,fecfac_adq,numcerori,anofabric,serniv,sercha,numfac1,fecfac1,numhomveh,
		 fecfac_hom,servicio,nro_puestos,numrafpla,fec_rafpla,numseq_raf,sercarrozado,tipcomb,numenv_veh,fecha_reg,hora)
         values
        (
			'".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."',
			'".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."','".$data[13]."',
			'".$data[14]."','".$data[15]."','".$data[16]."','".$data[17]."','".$data[18]."','".$data[19]."','".$data[20]."',
			'".$data[21]."','".$data[22]."','".$data[23]."','".$data[24]."','".$data[25]."','".$data[26]."','".$data[27]."',
			'".$data[28]."','".$data[29]."','".$data[30]."','".$data[31]."','".$data[32]."','".$data[33]."','".$data[34]."',
			'".$data[35]."','".$data[36]."','".$data[37]."','".$data[38]."','".$data[39]."','".$data[40]."','".$data[41]."',
			'".$data[42]."','".$data[43]."','".$data[44]."','" . date("d-m-Y") . "','" . date("H:i:s") . "')";
			 $consulta = $this->consultar($conexion,$sql);
		 // print $sql.'<Br>';
		 $this->desconectar($conexion);
	 	 return $consulta;

   }




 function listarVehTxt_tot($numenv,$tipo,$sercarveh,$codpro,$nomcomp,$tipoEnvio,$categoria,$offset){

    $sql = "select
			a.numcerveh as NumeroCertificado, b.sercarveh as SerialCarroceria,b.codpro as Cedula,
			c.nomcomp as Nombre,
			a.numenvveh as NumeroEnvVeh, a.fechatxtveh as FechaEnvVeh, a.numenvpro as NumeroEnvPropietario,
			a.fechatxtpro as FechaEnvPropietario, a.numenvpla as NumeroEnvPlaca, a.fechatxtpla as FechaEnvPlaca,
			g.desmar as Marca, h.desmod as Modelo
			from
			certificados a, asignacion b, propietarios c, vehiculo e, caracteristica f, marcas g, modelo h

			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and f.codmod=h.codmod and f.codmarveh=g.codmar and
	        	b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and a.tipmov_txt<>'ME'
	        	and estatusveh='E' AND estatuspro='E' AND estatuspla='E'
			";

  if($tipo!='X')  $sql=$sql."  and a.$tipo='E' ";
  if($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
  if($codpro)  $sql=$sql." and b.codpro like '%".$codpro."%'";
  if($nomcomp)  $sql=$sql." and c.nomcomp like '%".$nomcomp."%'";
  if($categoria)  $sql=$sql." and f.id_caract=".$categoria." ";
  if($tipoEnvio!='X' and $numenv!='X' ) if($numenv)     $sql=$sql."  and a.$tipoEnvio= ".$numenv."  ";
                  $sql=$sql." order by a.numenvveh desc,a.numenvpro desc,a.numenvpla desc";
                  $sql = $sql." LIMIT 15 OFFSET ".$offset;
  //print '<pre>Lista'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }



  function listadoVehTxt_hist($numenv,$tipo,$sercarveh,$codpro,$nomcomp,$tipoEnvio,$categoria,$offset){

    $sql = "
select
			tipmov_veh,numreg_intt,num_modif,marcas.desmar,serie,modelo,anomodveh,txtvehiculo.sercarveh,sermotveh,numplaveh,col1veh,col2veh,pesveh,tipcapveh,capcarveh,numejeveh,diarueveh,
			clase,txtvehiculo.tipo,uso,fecemi_cer,cod_rif,rif,dig_rif,codptoveh,numplagrav,fec_liqgrav,numfac_adq,fecfac_adq,numcerori,anofabric,serniv,sercha,numfac1,fecfac1,numhomveh,
		    fecfac_hom,servicio,nro_puestos,numrafpla,fec_rafpla,numseq_raf,sercarrozado,tipcomb,numenv_veh,to_char(txtvehiculo.fecha_reg,'dd/mm/yyyy'),propietarios.codpro
			from
			txtvehiculo,marcas,txtpropietario, propietarios
			where
			txtvehiculo.status='P' and marcas.codmar=txtvehiculo.codmar  and txtvehiculo.sercarveh=txtpropietario.sercarveh and txtpropietario.ced_pro=propietarios.ced";
 if($sercarveh)  $sql=$sql." and txtvehiculo.sercarveh like '%".$sercarveh."%'";
   if($numenv)  $sql=$sql." and txtvehiculo.numenv_veh='".$numenv."'";
    if($codpro)  $sql=$sql." and propietarios.codpro like '%".$codpro."%'";
      if($nomcomp)  $sql=$sql." and propietarios.nomcomp like '%".$nomcomp."%'";
                  $sql = $sql." LIMIT 15 OFFSET ".$offset;
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
  function ContarlistadoVehTxt_hist($numenv,$tipo,$sercarveh,$codpro,$nomcomp,$tipoEnvio,$categoria,$offset){

    $sql = "select count(id_txtveh)
			from
			txtvehiculo,marcas,txtpropietario, propietarios
			where
			txtvehiculo.status='P' and marcas.codmar=txtvehiculo.codmar  and txtvehiculo.sercarveh=txtpropietario.sercarveh and txtpropietario.ced_pro=propietarios.ced";
 if($sercarveh)  $sql=$sql." and txtvehiculo.sercarveh like '%".$sercarveh."%'";
   if($numenv)  $sql=$sql." and txtvehiculo.numenv_veh='".$numenv."'";
    if($codpro)  $sql=$sql." and propietarios.codpro like '%".$codpro."%'";
      if($nomcomp)  $sql=$sql." and propietarios.nomcomp like '%".$nomcomp."%'";
  //print '<pre>'; print $sql;
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }



  function listadoProTxt_hist($numenv,$tipo,$sercarveh,$codpro,$nomcomp,$tipoEnvio,$categoria,$offset){

    $sql = "select
			a.tipmov_pro,a.numcerveh,a.cod_rifconce,a.rif_conce,a.dig_rifconce,a.nac,a.ced_pro,a.dig_rifpro,
			a.prinompro,a.segnompro,a.priapepro ,a.segapepro,a.nomorgpro,a.calavepro,a.urbbarpro,a.edicaspro,
			a.numpispro,a.numapapro,a.dismunparro,a.telcelpro,a.telcelpro2,a.marca,a.cod_est,a.sercarveh,
			a.fec_venta,a.numfacven,a.numenv_pro,to_char(a.fecha_reg,'dd/mm/yyyy')
			from
			txtpropietario a,propietarios b
			where
			a.status='P' and b.ced=a.ced_pro";
 if($codpro)  $sql=$sql." and b.codpro like '%".$codpro."%'";
  if($nomcomp)  $sql=$sql." and b.nomcomp like '%".$nomcomp."%'";
   if($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
   if($numenv)  $sql=$sql." and a.numenv_pro='".$numenv."'";
  $sql = $sql." LIMIT 15 OFFSET ".$offset;
 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
  function ContarlistadoProTxt_hist($numenv,$tipo,$sercarveh,$codpro,$nomcomp,$tipoEnvio,$categoria,$offset){

    $sql = "select count(a.id_txtpro)
			from
			txtpropietario a, propietarios b
			where
			a.status='P' and b.ced=a.ced_pro";
		if($codpro)  $sql=$sql." and b.codpro like '%".$codpro."%'";
  if($nomcomp)  $sql=$sql." and b.nomcomp like '%".$nomcomp."%'";
   if($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
   if($numenv)  $sql=$sql." and a.numenv_pro='".$numenv."'";
  //print '<pre>'; print $sql;
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }


   function listadoPlaTxt_hist($numenv,$tipo,$sercarveh,$numpla,$nomcomp,$tipoEnvio,$categoria,$offset){

    $sql = "select
			a.cod_rif,a.rif,a.dig_rif,a.numpla,a.cod_estado,a.status_asig,a.num_rafaga,a.num_seq,a.numenv_pla,to_char(a.fecha_reg,'dd/mm/yyyy'),a.hora,b.sercarveh
			from txtplacas a,txtvehiculo b
			where
			a.status='P' and a.numpla=b.numplaveh";
  if($numenv)  $sql=$sql." and a.numenv_pla='".$numenv."'";
  if($sercarveh)  $sql=$sql." and b.sercarveh like '%".$sercarveh."%'";
   if($numpla)  $sql=$sql." and a.numpla like '%".$numpla."%'";
  // if($offset)
     $sql = $sql." LIMIT 15 OFFSET ".$offset;
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
  function ContarlistadoPlaTxt_hist($numenv,$tipo,$sercarveh,$numpla,$nomcomp,$tipoEnvio,$categoria,$offset){

    $sql = "select count(id_txtpla)

			from txtplacas a,txtvehiculo b
			where
			a.status='P' and a.numpla=b.numplaveh";
  if($numenv)  $sql=$sql." and a.numenv_pla='".$numenv."'";
  if($sercarveh)  $sql=$sql." and b.sercarveh like '%".$sercarveh."%'";
     if($numpla)  $sql=$sql." and a.numpla like '%".$numpla."%'";
  //print '<pre>'; print $sql;
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }


}
?>
