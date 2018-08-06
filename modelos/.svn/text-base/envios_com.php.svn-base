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
	) a ";
	// print '<pre>'; print $sql;
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
	) a ";

}else
{
	$sql = "select max(a.num)  from (
	select max(numenvveh) as num  from certificados
	union
	select max(numenvpro) as num  from certificados
	union
	select max(numenvpla) as num  from certificados
	) a ";
}
// print '<pre>'; print $sql;

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
 	$sql.= "select numlot, deslot from lote ";
 	$sql.= "order by numlot desc";
// print '<pre>'; print $sql;
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
 //  print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  /*function listarVehTxt($numlotveh,$tipo,$numenv,$origen,$mov){

    $sql = "select
			a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
            to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
            a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
            substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), a.tipmov_txt
			from
			certificados a, asignacion b, propietarios c, vehiculo e, caracteristica f,lote g
			where
			a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=b.sercarveh and b.status='A' and
			f.numlotveh=g.numlot and g.numdep='2' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract
			";
   $sql=$sql." and a.estatus='A'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($mov=='MA')  $sql=$sql."  and a.tipmov_txt<>'ME' "; else $sql=$sql."  and a.tipmov_txt='ME'  -- and a.estatusveh='E'  ";
  if($numenv)     $sql=$sql."  and a.numenvveh= ".$numenv."  "; else if($mov=='MA')  $sql=$sql."  and a.estatusveh='P' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
                  $sql=$sql." order by a.tipmov_txt desc, b.codpro, a.numcerveh";
  print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }*/

////////////////PROBANDO EL LISTAR VEH TXT////////////
function listarVehTxt($numlotveh,$tipo,$numenv,$origen,$mov){

    $sql = "select
			a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
            to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
            a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
            substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), a.tipmov_txt
			from
			certificados a, asignacion b, propietarios c, vehiculo e, caracteristica f,lote g
			where
			a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro
			and b.sercarveh=e.sercarveh and e.id_caract=f.id_caract
	         and f.numlotveh=g.numlot
			 and g.numdep='2'
			";
  if($mov=='MA') $sql=$sql." and a.estatus='A'"; else $sql=$sql." and a.estatus='E' ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($mov=='MA')  $sql=$sql."  and a.tipmov_txt<>'ME' "; else $sql=$sql."  and a.tipmov_txt='ME' and numenvveh is not null ";
  if($numenv)     $sql=$sql."  and a.numenvveh= ".$numenv."  "; else  $sql=$sql."  and a.estatusveh='P' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
                  $sql=$sql." order by a.tipmov_txt desc, b.codpro, a.numcerveh";
 //print '<pre>'; print $sql .' <---AQUI LISTA  PDF CON TXT ';
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
			certificados a, asignacion b, propietarios c, venta d, vehiculo e, caracteristica f
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh and d.status_venta='LIQ' and
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
  //print '<pre>'; print $sql;
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
			certificados a, asignacion b, propietarios c, venta d, vehiculo e, caracteristica f
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh and d.status_venta='LIQ' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and a.tipmov_txt<>'ME'
			";

  if($tipo!='X')  $sql=$sql."  and a.$tipo='E' ";
  if($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
  if($codpro)  $sql=$sql." and b.codpro like '%".$codpro."%'";
  if($nomcomp)  $sql=$sql." and c.nomcomp like '%".$nomcomp."%'";
  if($categoria)  $sql=$sql." and f.id_caract=".$categoria." ";
  if($tipoEnvio!='X' and $numenv!='X' ) if($numenv)     $sql=$sql."  and a.$tipoEnvio= ".$numenv."  ";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

 function txtVehImp($numenv){

 	$sql = "select
			d.tipmov_txt, substr(d.numcerveh,3,7),d.nummodveh,a.codmarveh,desserie(a.codserie),c.desmod,a.anomodveh,
			m.sercarveh,m.sermotveh,k.numplaveh,m.col1veh,m.col2veh,a.pesveh,a.tipcapveh,a.capcarveh,a.numejeveh,
			a.diarueveh,g.codcla,h.codtip,i.coduso,to_char(d.fecha_reg,'yyyymmdd'),o.codpro,a.codptoveh,a.numlicveh,to_char(a.fecplaveh,'yyyymmdd'),
			a.numfacveh,to_char(a.fecfacveh,'yyyymmdd'),d.numcerveh,a.anofabveh,m.sernivveh,m.serchaveh,d.numfac1veh,to_char(d.fecfac1veh,'yyyymmdd'),
			m.numhomveh,m.fechomveh,a.codserveh,a.numpueveh,k.numrafveh,to_char(k.fecrafveh,'yyyymmdd'),k.numsecveh,'' as sercarr,a.codconveh
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
			l.status='A' and
			m.estatus='A' and l.status='A' and d.estatus='A' and d.sercarveh=l.sercarveh";
            if($numenv)  $sql=$sql."  and d.numenvveh= ".$numenv."  "; else  $sql=$sql."  and d.estatusveh='P' ";
 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function txtVehImpElim($numenv){

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
			d.estatus='E' and
		    a.numlotveh=e.numlot and e.numdep='2'  and numenvveh is not null";
            if($numenv)  $sql=$sql."  and d.numenvveh= ".$numenv."  "; else  $sql=$sql."  and d.estatusveh='P' ";
 //print '<pre>'; print $sql .'entrooooooooooooooooooooooooooo YOOOOOOOOOOOOOOO';


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
			asignacion l, vehiculo m, certificados d, placas k,   propietarios o
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
			m.estatus='A' and l.status='A' and d.estatus='A' and d.sercarveh=l.sercarveh and d.estatusveh='P'";
            if($numenv)  $sql=$sql."  and d.numenvveh= ".$numenv."  ";
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
 /*  $sql = "select
			a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
            to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
            a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
            substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), a.tipmov_txt
			from
			certificados a, asignacion b, propietarios c, venta d, vehiculo e, caracteristica f
			where
			a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh and d.status_venta='LIQ' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract
			";
   $sql=$sql." and a.estatus='A'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($mov=='MA')  $sql=$sql."  and a.tipmov_txt<>'ME' "; else $sql=$sql."  and a.tipmov_txt='ME'  -- and a.estatusveh='E'  ";
  if($numenv)     $sql=$sql."  and a.numenvveh= ".$numenv."  "; else if($mov=='MA')  $sql=$sql."  and a.estatusveh='P' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
                  $sql=$sql." order by a.tipmov_txt desc, b.codpro, a.numcerveh";
  */


 function listarProTxt($numlotveh,$tipo,$numenv,$origen,$mov){

      $sql = "select
			a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
            to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
            a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
            substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), a.tipmov_pro, (c.urbbarpro||', Municipio: '||c.dismunpro) as dir,
            (c.tlfcelpro) as tlf, g.desmod
			from
			certificados a, asignacion b, propietarios c, vehiculo e, caracteristica f, modelo g,  placas h, lote i
			where
			a.id_asignacion=b.id_asignacion
			and f.numlotveh=i.numlot and i.numdep='2' and
			b.codpro=c.codpro and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and h.sercarveh=e.sercarveh and f.codmod=g.codmod
			";
  if($mov=='MA') $sql=$sql." and a.estatus='A' "; else $sql=$sql." and a.estatus='E'";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($mov=='MA')  $sql=$sql."  and a.tipmov_pro<>'ME' "; else $sql=$sql."  and a.tipmov_pro='ME' and numenvpro is not null   ";
  if($numenv)     $sql=$sql."  and a.numenvpro= ".$numenv."  "; else  $sql=$sql."  and a.estatuspro='P' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
                  $sql=$sql." order by a.tipmov_pro desc, b.codpro, a.numcerveh";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


 function txtPro($numenv,$mov){

    $sql = "select ";
    if(!$mov)   $sql=$sql."      a.tipmov_pro, "; else $sql=$sql."      a.tipmov_txt, ";
    $sql=$sql." substr(a.numcerveh,3,6),c.codpro,c.prinompro, c.segnompro,c.priapepro, c.segapepro,
			c.calavepro,c.urbbarpro,c.edicaspro,c.numpispro,c.numapapro,c.dismunpro,c.tlfcelpro,c.tlfcel2pro,
            h.numplaveh,f.codmarveh,h.codestveh,e.sernivveh,to_char(a.fecfac1veh,'yyyymmdd'),a.numfac1veh,c.nomorgpro
			from
			certificados a, asignacion b, propietarios c, vehiculo e, caracteristica f, modelo g, placas h
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=b.sercarveh and b.status='A' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and f.codmod=g.codmod and h.sercarveh=e.sercarveh
			and  a.estatuspro='E' ";
   if($numenv)  $sql=$sql."  and a.numenvpro= ".$numenv."";
   //--and a.tipmov_txt<>'ME'
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listarPlaTxt($numlotveh,$tipo,$numenv,$origen){

    $sql = "select
			a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
            to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
            a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
            substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), c.tipmovpro,h.numplaveh,
            i.desest, g.desmod, h.numrafveh||'/'||to_char(h.fecrafveh,'dd-mm-yyyy')
			from
			certificados a, asignacion b, propietarios c, vehiculo e, caracteristica f, modelo g,  placas h, estado i,lote j
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			f.numlotveh=j.numlot and j.numdep='2' and
			b.codpro=c.codpro and a.sercarveh=b.sercarveh and b.status='A' and h.sercarveh=e.sercarveh and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and f.codmod=g.codmod and i.codest=h.codestveh
			";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($tipo)       $sql=$sql."  and a.tipmov_txt='ME' "; else  $sql=$sql."  and a.tipmov_txt<>'ME' ";
  if($numenv)     $sql=$sql."  and a.numenvpla= ".$numenv."  "; else $sql=$sql."  and a.estatuspla='P' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
                  $sql=$sql." order by h.numplaveh";
 // print '<pre>'; print $sql;
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
			certificados a, asignacion b, propietarios c, vehiculo e, caracteristica f, modelo g, placas h, lote i
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=b.sercarveh and b.status='A' and
			f.numlotveh=i.numlot and i.numdep='2' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and f.codmod=g.codmod and h.sercarveh=e.sercarveh
			and  a.estatuspla='E' and a.tipmov_txt<>'ME' ";
   if($numenv)  $sql=$sql."  and a.numenvpla= ".$numenv."  ";
    $sql=$sql." order by h.numplaveh";
 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function buscarEstatus($numlotveh,$tipo,$origen,$estatus,$mov){
  $fecha=date('d/m/Y');
  $conexion = $this->conectar();
  $sql = $sql."select a.* from certificados a, asignacion b, vehiculo e, caracteristica f, lote g";
  $sql = $sql." where a.estatus='A' and a.id_asignacion=b.id_asignacion and
			a.sercarveh=b.sercarveh and
			b.status='A' and
			f.numlotveh=g.numlot and g.numdep='2' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and a.".$estatus."='P'";
  $sql=$sql."  and a.".$mov."<>'ME'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
 //print '<pre>'.'BUSCAR'; print $sql;
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (count($consulta)>0){
     $consulta=true;
  }else
     $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
 }

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

  function buscarEstatusElim($numlotveh,$tipo,$origen,$estatus,$mov,$numenvT){
     $fecha=date('d/m/Y');
  $conexion = $this->conectar();
  $sql = $sql."select certificados.* from certificados, asignacion b, vehiculo e, caracteristica f,lote g
               where certificados.estatus='E'
               and certificados.id_asignacion=b.id_asignacion
               and f.numlotveh=g.numlot
               and g.numdep='2'
               and b.sercarveh=e.sercarveh
               and e.id_caract=f.id_caract
               and certificados.estatusveh='P'
               and f.origenveh='I' and $numenvT is not null and certificados.".$mov."='ME'    ";
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

 function cambiarEstatus($numlotveh,$tipo,$numenv,$origen,$estatus,$mov){
  $fecha=date("d/m/Y H:i:s");
  $conexion = $this->conectar();
  $sql = $sql."select a.* from certificados a, asignacion b, vehiculo e, caracteristica f, lote g";
  $sql = $sql." where a.estatus='A' and a.id_asignacion=b.id_asignacion and
			a.sercarveh=b.sercarveh and
			b.status='A' and
			f.numlotveh=g.numlot and g.numdep='2' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and a.".$estatus."='P'";
  $sql=$sql."  and a.".$mov."<>'ME'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
  //print '<pre>' .' BUSCAR Y CAMBIAR'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

 if (count($consulta)>0){
  $sql = "update certificados a set estatusveh='E', numenvveh=$numenv , fechatxtveh='$fecha'";
  $sql = $sql." from asignacion b, vehiculo e, caracteristica f,lote g";
  $sql = $sql." where a.estatus='A' and a.id_asignacion=b.id_asignacion and
			a.sercarveh=b.sercarveh and b.status='A' and
			f.numlotveh=g.numlot and g.numdep='2' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and a.estatusveh='P'";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if(!$tipo)  $sql=$sql."  and a.".$mov."<>'ME' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
 // print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  }else $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
 }

 function cambiarEstatusEli($numlotveh,$tipo,$numenv,$origen,$estatus,$mov){
  $fecha=date("d/m/Y H:i:s");
  $conexion = $this->conectar();
  $sql = $sql."select certificados.* from certificados, asignacion b, vehiculo e, caracteristica f, lote g";
  $sql = $sql." where certificados.estatus='E'  and certificados.id_asignacion=b.id_asignacion and
	     	   f.numlotveh=g.numlot and g.numdep='2'  and numenvveh is not null  and certificados.estatusveh='P' and
	      		 b.sercarveh=e.sercarveh and e.id_caract=f.id_caract ";
  $sql=$sql."  and certificados.".$mov."='ME'";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
 //print '<pre>' .' holaaaaaaaaa '; print $sql;

 //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (count($consulta)>0){
  $sql = "update certificados set estatusveh='E', numenvveh=$numenv , fechatxtveh='$fecha'";
  $sql = $sql." from asignacion b, vehiculo e, caracteristica f,lote g";
  $sql = $sql." where certificados.estatus='E' and certificados.id_asignacion=b.id_asignacion and
  		  f.numlotveh=g.numlot and g.numdep='2'  and numenvveh is not null and certificados.estatusveh='P'  and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract ";
  $sql=$sql."  and certificados.".$mov."='ME'";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
 //print '<pre>'; print $sql . 'UPDATEEEEEEEEEEEE';

  $consulta = $this->consultar($conexion,$sql);
 }else $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
 }

  function cambiarEstatusPro($numlotveh,$tipo,$numenv){
  $fecha=date("d/m/Y H:i:s");
  $conexion = $this->conectar();
  $sql = $sql."select d.* from certificados d, asignacion b, vehiculo e, caracteristica f, modelo g,  placas h, lote i";
  $sql = $sql." where d.estatus='A' and d.id_asignacion=b.id_asignacion and
			d.sercarveh=b.sercarveh  and  f.numlotveh=i.numlot and i.numdep='2' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and d.estatuspro='P' and h.sercarveh=e.sercarveh and f.codmod=g.codmod";
  $sql=$sql."  and d.tipmov_pro<>'ME'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";

 // print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
//print 'aqui'.count($consulta);
  if (count($consulta)>0){
  $sql = "update certificados set estatuspro='E', numenvpro=$numenv , fechatxtpro='$fecha'";
  $sql = $sql." from asignacion b, vehiculo e, caracteristica f, modelo g,  placas h,lote i";
 $sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=b.sercarveh  and f.numlotveh=i.numlot and i.numdep='2' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.estatuspro='P' and h.sercarveh=e.sercarveh and f.codmod=g.codmod";
  $sql=$sql."  and certificados.tipmov_pro<>'ME'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
 //print '<pre>'; print $sql;

 $consulta = $this->consultar($conexion,$sql);
  }else $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
 }

function cambiarEstatusProElim($numlotveh,$tipo,$numenv){
  $fecha=date("d/m/Y H:i:s");
  $conexion = $this->conectar();
  $sql = $sql."select certificados.* from certificados, asignacion b, vehiculo e, caracteristica f, modelo g,  placas h , lote i";
  $sql = $sql." where certificados.estatus='E' and certificados.id_asignacion=b.id_asignacion and f.numlotveh=i.numlot and i.numdep='2'
			  and numenvpro is not null and b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.estatuspro='P' and h.sercarveh=e.sercarveh and f.codmod=g.codmod";
  $sql=$sql."  and certificados.tipmov_pro='ME'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";

 //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
//print 'aqui'.count($consulta);
  if (count($consulta)>0){
  $sql = "update certificados set estatuspro='E', numenvpro=$numenv , fechatxtpro='$fecha'";
  $sql = $sql." from asignacion b, facturaprof d, vehiculo e, caracteristica f, modelo g,  placas h";
 $sql = $sql." where certificados.estatus='E' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.estatus='E' and d.id_estatus='15' and numenvpro is not null and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.estatuspro='P' and h.sercarveh=e.sercarveh and f.codmod=g.codmod";
  $sql=$sql."  and certificados.tipmov_pro='ME'  ";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
 // print '<pre>'; print $sql;

 $consulta = $this->consultar($conexion,$sql);
 }else $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
}

 function cambiarEstatusPla($numlotveh,$tipo,$numenv){
  $fecha=date("d/m/Y H:i:s");
  $conexion = $this->conectar();
   $sql = "select
			a.*
			from
			certificados a, asignacion b, propietarios c, vehiculo e, caracteristica f, modelo g,  placas h, lote i
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=b.sercarveh and b.status='A' and h.sercarveh=e.sercarveh and
			f.numlotveh=i.numlot and i.numdep='2' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and f.codmod=g.codmod and a.estatuspla='P'
			";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($tipo)       $sql=$sql."  and a.tipmov_txt='ME' "; else  $sql=$sql."  and a.tipmov_txt<>'ME' ";

 //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (count($consulta)>0){
  $sql = "update certificados set estatuspla='E', numenvpla=$numenv , fechatxtpla='$fecha'";
  $sql = $sql." from asignacion b, vehiculo e, caracteristica f, lote g";
  $sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=b.sercarveh and b.status='A' and
			f.numlotveh=g.numlot and g.numdep='2' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.estatuspla='P'";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($tipo)  $sql=$sql."  and certificados.tipmov_txt='ME' "; else  $sql=$sql."  and certificados.tipmov_txt<>'ME' ";

  //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  }else $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
 }

  function registrarEnvios($numenv,$origen,$ma,$mm,$me){
  $fecha=date('d/m/Y');
  $sql = "INSERT INTO enviostxt VALUES ($numenv,'".$fecha."','".$origen."',$ma,$mm,$me)";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/reg_txt.php');
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

  //print '<pre>'; print $sql;
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
	// print $sql.'<Br>';
  }

  $this->desconectar($conexion);
  return $consulta;
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
}
?>