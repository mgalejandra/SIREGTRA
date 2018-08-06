<?php
class envios extends conexion{

 function buscarEnvioVeh(){
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

  $this->desconectar($conexion);
  return $consulta[0];
 }

  function buscarLotes(){

 	$sql = "select numlot, deslot from lote order by numlot desc";
// print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function listarVehTxt($numlotveh,$tipo,$numenv,$origen){

    $sql = "select
			a.numcerveh, a.id_certificado, e.sercarveh,b.desmar, c.desmod,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
            to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
            a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
            substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), a.tipmov_txt
			from
			certificados a, vehiculo e, caracteristica f, marcas b , modelo c
			where
			a.estatus='A' and b.codmar=f.codmarveh and c.codmod=f.codmod and
	        e.id_caract=f.id_caract and e.sercarveh=a.sercarveh
			";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($tipo)       $sql=$sql."  and a.tipmov_txt='ME' "; else  $sql=$sql."  and a.tipmov_txt<>'ME' ";
  if($numenv)     $sql=$sql."  and a.numenvveh= ".$numenv."  "; else $sql=$sql."  and a.estatusveh='P' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
                  $sql=$sql." order by a.numcerveh";
  // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listarVehTxtCon($numenv,$tipo,$sercarveh,$codpro,$nomcomp,$tipoEnvio,$offset){

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
  if($tipoEnvio!='X' and $numenv!='X' ) if($numenv)     $sql=$sql."  and a.$tipoEnvio= ".$numenv."  ";
                  $sql=$sql." order by a.numenvveh desc,a.numenvpro desc,a.numenvpla desc";
                  $sql = $sql." LIMIT 15 OFFSET ".$offset;
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
 function contarVehTxt($numenv,$tipo,$sercarveh,$codpro,$nomcomp,$tipoEnvio){

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
			a.diarueveh,g.codcla,h.codtip,i.coduso,to_char(d.fecha_reg,'yyyymmdd'),'' as codpro,a.codptoveh,a.numlicveh,to_char(a.fecplaveh,'yyyymmdd'),
			a.numfacveh,to_char(a.fecfacveh,'yyyymmdd'),d.numcerveh,a.anofabveh,m.sernivveh,m.serchaveh,d.numfac1veh,to_char(d.fecfac1veh,'yyyymmdd'),
			m.numhomveh,m.fechomveh,a.codserveh,a.numpueveh,k.numrafveh,to_char(k.fecrafveh,'yyyymmdd'),k.numsecveh,'' as sercarr,a.codconveh
			from
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
			vehiculo m, certificados d, placas k,  ptoadu n
			where
			a.codmarveh=b.codmar and
			a.codmod=c.codmod  and
			a.numlotveh=e.numlot and
			a.codconveh=f.codcon and
			a.codclaveh=g.codcla and
			a.codtipveh=h.codtip  and
			a.codusoveh=i.coduso  and
			a.codserveh=j.codser  and
			m.id_caract=a.id_caract and
			d.sercarveh=m.sercarveh and
			k.sercarveh=m.sercarveh and
			a.codptoveh=n.codpto  and
			m.estatus='A' and d.estatus='A' ";
            if($numenv)  $sql=$sql."  and d.numenvveh= ".$numenv."  "; else  $sql=$sql."  and d.estatusveh='P' ";
  print '<pre>'; print $sql;
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
			m.estatus='A' and l.status='A' and d.estatus='A' and m.sercarveh=p.sercarveh and d.estatusveh='P'";
            if($numenv)  $sql=$sql."  and d.numenvveh= ".$numenv."  ";
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listarProTxt($numlotveh,$tipo,$numenv,$origen){

    $sql = "select
			a.numcerveh, a.id_certificado, b.sercarveh,b.codpro, c.nomcomp,  to_char(a.fecha_fincon,'dd/mm/yyyy'), a.numfac1veh ,
            to_char(a.fecfac1veh,'dd/mm/yyyy'), a.nomseg, a.numpolseg  ,  a.fecvenpol , a.resdom ,
            a.numcedres , a.obspolseg  , to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_asignacion,
            substr(a.numcerveh,1,2) as le, substr(a.numcerveh,3,6), c.tipmovpro, (c.urbbarpro||', Municipio: '||c.dismunpro) as dir,
            (c.tlfcelpro) as tlf, g.desmod
			from
			certificados a, asignacion b, propietarios c, venta d, vehiculo e, caracteristica f, modelo g,  placas h
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh and d.status_venta='LIQ' and h.sercarveh=e.sercarveh and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and f.codmod=g.codmod
			";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($tipo)       $sql=$sql."  and a.tipmov_txt='ME' "; else  $sql=$sql."  and a.tipmov_txt<>'ME' ";
  if($numenv)     $sql=$sql."  and a.numenvpro= ".$numenv."  "; else $sql=$sql."  and a.estatuspro='P' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
                  $sql=$sql." order by a.numcerveh";
 //  print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


 function txtPro($numenv){

    $sql = "select
			c.tipmovpro,substr(a.numcerveh,3,6),c.codpro,c.prinompro, c.segnompro,c.priapepro, c.segapepro,
			c.calavepro,c.urbbarpro,c.edicaspro,c.numpispro,c.numapapro,c.dismunpro,c.tlfcelpro,c.tlfcel2pro,
            h.numplaveh,f.codmarveh,h.codestveh,e.sernivveh,to_char(a.fecfac1veh,'yyyymmdd'),a.numfac1veh,c.nomorgpro
			from
			certificados a, asignacion b, propietarios c, venta d, vehiculo e, caracteristica f, modelo g, placas h
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh and d.status_venta='LIQ' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and f.codmod=g.codmod and h.sercarveh=e.sercarveh
			and  a.estatuspro='E' and a.tipmov_txt<>'ME'";
   if($numenv)  $sql=$sql."  and a.numenvpro= ".$numenv."  ";
 //  print '<pre>'; print $sql;
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
			certificados a, asignacion b, propietarios c, venta d, vehiculo e, caracteristica f, modelo g,  placas h, estado i
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh and d.status_venta='LIQ' and h.sercarveh=e.sercarveh and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and f.codmod=g.codmod and i.codest=h.codestveh
			";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($tipo)       $sql=$sql."  and a.tipmov_txt='ME' "; else  $sql=$sql."  and a.tipmov_txt<>'ME' ";
  if($numenv)     $sql=$sql."  and a.numenvpla= ".$numenv."  "; else $sql=$sql."  and a.estatuspla='P' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
                  $sql=$sql." order by h.numplaveh";
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
			certificados a, asignacion b, propietarios c, venta d, vehiculo e, caracteristica f, modelo g, placas h
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh and d.status_venta='LIQ' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and f.codmod=g.codmod and h.sercarveh=e.sercarveh
			and  a.estatuspla='E' and a.tipmov_txt<>'ME' ";
   if($numenv)  $sql=$sql."  and a.numenvpla= ".$numenv."  ";
    $sql=$sql." order by h.numplaveh";
 //  print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function buscarEstatus($numlotveh,$tipo,$origen,$estatus){
  $fecha=date('d/m/Y');
  $conexion = $this->conectar();
  $sql = $sql."  select e.* from certificados a , vehiculo e, caracteristica f";
  $sql = $sql."  where a.estatus='A' and   a.sercarveh=e.sercarveh and
			     e.id_caract=f.id_caract and a.".$estatus."='P'";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($tipo)  $sql=$sql."  and a.tipmov_txt='ME' "; else  $sql=$sql."  and a.tipmov_txt<>'ME' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";

 // print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (count($consulta)>0){

  }else $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
 }

 function buscarEstatusPro($numlotveh,$tipo,$origen,$estatus){
  $fecha=date('d/m/Y');
  $conexion = $this->conectar();
  $sql = $sql."select d.* from certificados, asignacion b, venta d, vehiculo e, caracteristica f";
  $sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.status_venta='LIQ' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.".$estatus."='P'";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($tipo)  $sql=$sql."  and certificados.tipmov_txt='ME' "; else  $sql=$sql."  and certificados.tipmov_txt<>'ME' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";

  //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (count($consulta)>0){

  }else $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
 }

 function cambiarEstatus($numlotveh,$tipo,$numenv,$origen){
  $fecha=date("d/m/Y H:i:s");
  $conexion = $this->conectar();
  $sql = $sql."  select e.* from certificados a , vehiculo e, caracteristica f";
  $sql = $sql."  where a.estatus='A' and   a.sercarveh=e.sercarveh and
			     e.id_caract=f.id_caract and a.estatusveh='P'";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($tipo)  $sql=$sql."  and a.tipmov_txt='ME' "; else  $sql=$sql."  and a.tipmov_txt<>'ME' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
  //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (count($consulta)>0){
  $sql = "update certificados set estatusveh='E', numenvveh=$numenv , fechatxtveh='$fecha'";
  $sql = $sql." from  vehiculo e, caracteristica f";
  $sql = $sql." where certificados.estatus='A' and
		    	certificados.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.estatusveh='P'";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($tipo)  $sql=$sql."  and certificados.tipmov_txt='ME' "; else  $sql=$sql."  and certificados.tipmov_txt<>'ME' ";
  if($origen)     $sql=$sql."  and f.origenveh='".$origen."' ";
 // print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  }else $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
 }

  function cambiarEstatusPro($numlotveh,$tipo,$numenv){
  $fecha=date("d/m/Y H:i:s");
  $conexion = $this->conectar();
   $sql = "select
			d.*
			from
			certificados a, asignacion b, propietarios c, venta d, vehiculo e, caracteristica f, modelo g,  placas h
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh and d.status_venta='LIQ' and h.sercarveh=e.sercarveh and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and f.codmod=g.codmod and a.estatuspro='P'
			";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($tipo)       $sql=$sql."  and a.tipmov_txt='ME' "; else  $sql=$sql."  and a.tipmov_txt<>'ME' ";

// print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (count($consulta)>0){
  $sql = "update certificados set estatuspro='E', numenvpro=$numenv , fechatxtpro='$fecha'";
  $sql = $sql." from asignacion b, venta d, vehiculo e, caracteristica f";
  $sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.status_venta='LIQ' and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and certificados.estatuspro='P'";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($tipo)  $sql=$sql."  and certificados.tipmov_txt='ME' "; else  $sql=$sql."  and certificados.tipmov_txt<>'ME' ";

  //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  }else $consulta=false;
  $this->desconectar($conexion);
  return $consulta;
 }

 function cambiarEstatusPla($numlotveh,$tipo,$numenv){
  $fecha=date("d/m/Y H:i:s");
  $conexion = $this->conectar();
   $sql = "select
			d.*
			from
			certificados a, asignacion b, propietarios c, venta d, vehiculo e, caracteristica f, modelo g,  placas h
			where
			a.estatus='A' and a.id_asignacion=b.id_asignacion and
			b.codpro=c.codpro and a.sercarveh=d.sercarveh and d.status_venta='LIQ' and h.sercarveh=e.sercarveh and
	        b.sercarveh=e.sercarveh and e.id_caract=f.id_caract and f.codmod=g.codmod and a.estatuspla='P'
			";
  if($numlotveh)  $sql=$sql."  and f.numlotveh=".$numlotveh." ";
  if($tipo)       $sql=$sql."  and a.tipmov_txt='ME' "; else  $sql=$sql."  and a.tipmov_txt<>'ME' ";

// print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (count($consulta)>0){
  $sql = "update certificados set estatuspla='E', numenvpla=$numenv , fechatxtpla='$fecha'";
  $sql = $sql." from asignacion b, venta d, vehiculo e, caracteristica f";
  $sql = $sql." where certificados.estatus='A' and certificados.id_asignacion=b.id_asignacion and
			certificados.sercarveh=d.sercarveh and d.status_venta='LIQ' and
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

 function comboEnvio(){

    $sql = "select
			nroenvio, to_char(fechaenvio,'dd/mm/yyyy') , ma, mm, me,
			(case tipoenvio when 'P' THEN 'Placa' when 'B' THEN 'Beneficiario' when 'I' THEN 'Importado'  when 'N' THEN 'Nacional' end) as tipo, tipoenvio
			from
			enviostxt
			where
			estatus='A'	";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
}
?>
