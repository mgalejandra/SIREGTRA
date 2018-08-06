<?php
class reportes extends conexion{

function f_ejecutarSQL($sql,$offset,$result,$fase) {

  if($fase==2)$sql.= " LIMIT 15 OFFSET ".$offset;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  if($fase==2) return $consulta;
  else {
  	$result = $consulta;
  	return count($consulta);
  }
}

/////////// Vehículos con certificado (importados) ////////////////////

function vehiculos_con_certificado ($data,$offset=null,$result=null,$fase=null) {

$sql = "SELECT
b.desmar ,c.desmod ,m.sermotveh,m.sercarveh, a.anofabveh, a.anomodveh ,descolor(m.col1veh),
k.numplaveh, o.codpro, o.prinompro||' '||o.segnompro, o.priapepro||' '||o.segapepro,
d.numfac1veh,to_char(d.fecfac1veh,'dd/mm/yyyy'),d.numcerveh,d.fecha_reg,
a.preveh, (SELECT exento FROM  facturaprof p WHERE p.sercarveh=m.sercarveh AND estatus='A'),
d.estatusveh, d.numenvveh, d.fechatxtveh,d.estatuspro, d.numenvpro, d.fechatxtpro,d.estatuspla, d.numenvpla, d.fechatxtpla
		FROM
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
			asignacion l,  vehiculo m,  placas k,  ptoadu n, propietarios o,
			certificados d
		WHERE
			a.codmarveh	= b.codmar AND
			a.codmod	= c.codmod AND
			a.numlotveh	= e.numlot AND
			a.codconveh	= f.codcon AND
			a.codclaveh	= g.codcla AND
			a.codtipveh	= h.codtip AND
			a.codusoveh	= i.coduso AND
			a.codserveh	= j.codser AND
			l.sercarveh	= m.sercarveh AND
			m.id_caract	= a.id_caract AND
			d.id_asignacion = l.id_asignacion AND
			k.sercarveh	= m.sercarveh AND
			a.codptoveh	= n.codpto  AND
			o.codpro	= l.codpro AND
			m.estatus = 'A' AND l.status	= 'A' AND d.estatus	= 'A' AND
			a.origenveh	= 'I' AND d.tipmov_txt <> 'ME'";

  if($data[0]) $sql.= " AND m.sercarveh = '".$data[0]."'";
  if($data[1]) $sql.= " AND o.nomcomp  LIKE '%".$data[1]."%'";
  if($data[2]) $sql.= " AND e.numlot = '".$data[2]."'";
  if($data[3]) $sql.= " AND b.codmar = '".$data[3]."'";
  if($data[4]) $sql.= " AND c.codmod = '".$data[4]."'";
  if($data[5]) $sql.= " AND j.codser = '".$data[5]."'";

  $sql.= " ORDER BY numlotveh, b.desmar, c.desmod, m.sercarveh";

return $this->f_ejecutarSQL($sql,$offset,$result,$fase);

}

/////////// Vehículos con certificado (nacionales) ////////////////////

function vehiculos_con_certificado_nac ($data,$offset=null,$result=null,$fase=null) {

$sql = "SELECT
b.desmar ,c.desmod ,m.sermotveh,m.sercarveh, a.anofabveh, a.anomodveh ,descolor(m.col1veh),
k.numplaveh, o.codpro, o.prinompro||' '||o.segnompro, o.priapepro||' '||o.segapepro,
d.numfac1veh,to_char(d.fecfac1veh,'dd/mm/yyyy'),d.numcerveh,d.fecha_reg,
a.preveh, (SELECT exento FROM  facturaprof p WHERE p.sercarveh=m.sercarveh AND estatus='A'),
d.estatusveh, d.numenvveh, d.fechatxtveh,d.estatuspro, d.numenvpro, d.fechatxtpro,d.estatuspla, d.numenvpla, d.fechatxtpla
		FROM
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
			asignacion l,  vehiculo m,  placas k,  propietarios o,
			certificados d
		WHERE
			a.codmarveh	= b.codmar AND
			a.codmod	= c.codmod AND
			a.numlotveh	= e.numlot AND
			a.codconveh	= f.codcon AND
			a.codclaveh	= g.codcla AND
			a.codtipveh	= h.codtip AND
			a.codusoveh	= i.coduso AND
			a.codserveh	= j.codser AND
			l.sercarveh	= m.sercarveh AND
			m.id_caract	= a.id_caract AND
			d.id_asignacion = l.id_asignacion AND
			k.sercarveh	= m.sercarveh AND
			o.codpro	= l.codpro AND
			m.estatus = 'A' AND l.status	= 'A' AND d.estatus	= 'A' AND
			a.origenveh	= 'N' AND d.tipmov_txt <> 'ME'";

  if($data[0]) $sql.= " AND m.sercarveh = '".$data[0]."'";
  if($data[1]) $sql.= " AND o.nomcomp  LIKE '%".$data[1]."%'";
  if($data[2]) $sql.= " AND e.numlot = '".$data[2]."'";
  if($data[3]) $sql.= " AND b.codmar = '".$data[3]."'";
  if($data[4]) $sql.= " AND c.codmod = '".$data[4]."'";
  if($data[5]) $sql.= " AND j.codser = '".$data[5]."'";

  $sql.= " ORDER BY numlotveh, b.desmar, c.desmod, m.sercarveh";

return $this->f_ejecutarSQL($sql,$offset,$result,$fase);
}

//-------------------los que no tienen certificados (importados)

function vehiculos_sin_certificado ($data,$offset=null,$result=null,$fase=null) {

$sql ="SELECT
b.desmar ,c.desmod ,m.sermotveh,m.sercarveh, a.anofabveh, a.anomodveh ,descolor(m.col1veh),
k.numplaveh, o.codpro, o.prinompro||' '||o.segnompro, o.priapepro||' '||o.segapepro,
'','','','',
a.preveh, (SELECT exento FROM  facturaprof p WHERE p.sercarveh=m.sercarveh AND estatus='A'),
'','','','','','','','',''
FROM
caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
asignacion l,  vehiculo m,  placas k,  ptoadu n, propietarios o
WHERE
a.codmarveh	= b.codmar AND
a.codmod	= c.codmod AND
a.numlotveh	= e.numlot AND
a.codconveh	= f.codcon AND
a.codclaveh	= g.codcla AND
a.codtipveh	= h.codtip AND
a.codusoveh	= i.coduso AND
a.codserveh	= j.codser AND
l.sercarveh	= m.sercarveh AND
m.id_caract	= a.id_caract AND
k.sercarveh	= m.sercarveh AND
a.codptoveh	= n.codpto  AND
o.codpro	= l.codpro AND
m.estatus	= 'A' AND l.status = 'A'";

  if($data[0]) $sql.= " AND m.sercarveh = '".$data[0]."'";
  if($data[1]) $sql.= " AND o.nomcomp  LIKE '%".$data[1]."%'";
  if($data[2]) $sql.= " AND e.numlot = '".$data[2]."'";
  if($data[3]) $sql.= " AND b.codmar = '".$data[3]."'";
  if($data[4]) $sql.= " AND c.codmod = '".$data[4]."'";
  if($data[5]) $sql.= " AND j.codser = '".$data[5]."'";

$sql.= "EXCEPT(
SELECT
b.desmar ,c.desmod ,m.sermotveh,m.sercarveh, a.anofabveh, a.anomodveh,descolor(m.col1veh),
k.numplaveh, o.codpro, o.prinompro||' '||o.segnompro, o.priapepro||' '||o.segapepro,
'','','','',
a.preveh, (SELECT exento FROM  facturaprof p WHERE p.sercarveh=m.sercarveh AND estatus='A'),
'','','','','','','','',''
			FROM
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
			asignacion l,  vehiculo m,  placas k,  ptoadu n, propietarios o,
			certificados d
			WHERE
			a.codmarveh	= b.codmar AND
			a.codmod	= c.codmod  AND
			a.numlotveh	= e.numlot AND
			a.codconveh	= f.codcon AND
			a.codclaveh	= g.codcla AND
			a.codtipveh	= h.codtip  AND
			a.codusoveh	= i.coduso  AND
			a.codserveh	= j.codser  AND
			l.sercarveh	= m.sercarveh AND
			m.id_caract	= a.id_caract AND
			d.id_asignacion	= l.id_asignacion AND
			k.sercarveh	= m.sercarveh AND
			a.codptoveh	= n.codpto  AND
			o.codpro	= l.codpro AND
			m.estatus	= 'A' AND l.status = 'A' AND d.estatus = 'A' AND
			a.origenveh='I' AND d.tipmov_txt <> 'ME'
			order by numlotveh, b.desmar, c.desmod, m.sercarveh) ";

return $this->f_ejecutarSQL($sql,$offset,$result,$fase);
}

//-------------------los que no tienen certificados (nacionales)

function vehiculos_sin_certificado_nac ($data,$offset=null,$result=null,$fase=null) {

$sql ="SELECT
b.desmar ,c.desmod ,m.sermotveh,m.sercarveh, a.anofabveh, a.anomodveh ,descolor(m.col1veh),
k.numplaveh, o.codpro, o.prinompro||' '||o.segnompro, o.priapepro||' '||o.segapepro,
'','','','',
a.preveh, (SELECT exento FROM  facturaprof p WHERE p.sercarveh=m.sercarveh AND estatus='A'),
'','','','','','','','',''
FROM
caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
asignacion l,  vehiculo m,  placas k,  propietarios o
WHERE
a.codmarveh	= b.codmar AND
a.codmod	= c.codmod AND
a.numlotveh	= e.numlot AND
a.codconveh	= f.codcon AND
a.codclaveh	= g.codcla AND
a.codtipveh	= h.codtip AND
a.codusoveh	= i.coduso AND
a.codserveh	= j.codser AND
l.sercarveh	= m.sercarveh AND
m.id_caract	= a.id_caract AND
k.sercarveh	= m.sercarveh AND
o.codpro	= l.codpro AND
m.estatus	= 'A' AND l.status = 'A'";

  if($data[0]) $sql.= " AND m.sercarveh = '".$data[0]."'";
  if($data[1]) $sql.= " AND o.nomcomp  LIKE '%".$data[1]."%'";
  if($data[2]) $sql.= " AND e.numlot = '".$data[2]."'";
  if($data[3]) $sql.= " AND b.codmar = '".$data[3]."'";
  if($data[4]) $sql.= " AND c.codmod = '".$data[4]."'";
  if($data[5]) $sql.= " AND j.codser = '".$data[5]."'";

$sql.= "EXCEPT(
SELECT
b.desmar ,c.desmod ,m.sermotveh,m.sercarveh, a.anofabveh, a.anomodveh ,descolor(m.col1veh),
k.numplaveh, o.codpro, o.prinompro||' '||o.segnompro, o.priapepro||' '||o.segapepro,
'','','','',
a.preveh, (SELECT exento FROM  facturaprof p WHERE p.sercarveh=m.sercarveh AND estatus='A'),
'','','','','','','','',''
			FROM
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
			asignacion l,  vehiculo m,  placas k, propietarios o,
			certificados d
			WHERE
			a.codmarveh	= b.codmar AND
			a.codmod	= c.codmod  AND
			a.numlotveh	= e.numlot AND
			a.codconveh	= f.codcon AND
			a.codclaveh	= g.codcla AND
			a.codtipveh	= h.codtip  AND
			a.codusoveh	= i.coduso  AND
			a.codserveh	= j.codser  AND
			l.sercarveh	= m.sercarveh AND
			m.id_caract	= a.id_caract AND
			d.id_asignacion	= l.id_asignacion AND
			k.sercarveh	= m.sercarveh AND
			o.codpro	= l.codpro AND
			m.estatus	= 'A' AND l.status = 'A' AND d.estatus = 'A' AND
			a.origenveh='N' AND d.tipmov_txt <> 'ME'
			order by numlotveh, b.desmar, c.desmod, m.sercarveh) ";

return $this->f_ejecutarSQL($sql,$offset,$result,$fase);
}

//------------------------- vehiculos sin asignar

function vehiculos_sin_asignar ($data,$offset=null,$result=null,$fase=null) {

$sql = "SELECT
b.desmar ,c.desmod ,m.sermotveh,m.sercarveh, a.anofabveh, a.anomodveh ,descolor(m.col1veh),
k.numplaveh, a.preveh
			FROM
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
			vehiculo m,  placas k,  ptoadu n
			WHERE
			a.codmarveh	= b.codmar AND
			a.codmod	= c.codmod  AND
			a.numlotveh	= e.numlot AND
			a.codconveh	= f.codcon AND
			a.codclaveh	= g.codcla AND
			a.codtipveh	= h.codtip  AND
			a.codusoveh	= i.coduso  AND
			a.codserveh	= j.codser  AND
			m.id_caract	= a.id_caract AND
			k.sercarveh	= m.sercarveh AND
			a.codptoveh	= n.codpto  AND
			m.estatus	= 'A'";

  if($data[0]) $sql.= " AND m.sercarveh = '".$data[0]."'";
  if($data[1]) $sql.= " AND o.nomcomp  LIKE '%".$data[1]."%'";
  if($data[2]) $sql.= " AND e.numlot = '".$data[2]."'";
  if($data[3]) $sql.= " AND b.codmar = '".$data[3]."'";
  if($data[4]) $sql.= " AND c.codmod = '".$data[4]."'";
  if($data[5]) $sql.= " AND j.codser = '".$data[5]."'";

$sql.= "EXCEPT
(
SELECT
b.desmar ,c.desmod ,m.sermotveh,m.sercarveh, a.anofabveh, a.anomodveh ,descolor(m.col1veh),
k.numplaveh, a.preveh
FROM
caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
asignacion l,  vehiculo m,  placas k,  ptoadu n, propietarios o

WHERE
a.codmarveh	= b.codmar AND
a.codmod	= c.codmod  AND
a.numlotveh	= e.numlot AND
a.codconveh	= f.codcon AND
a.codclaveh	= g.codcla AND
a.codtipveh	= h.codtip  AND
a.codusoveh	= i.coduso  AND
a.codserveh	= j.codser  AND
l.sercarveh	= m.sercarveh AND
m.id_caract	= a.id_caract AND
k.sercarveh	= m.sercarveh AND
a.codptoveh	= n.codpto  AND
o.codpro	= l.codpro AND
m.estatus	= 'A' AND l.status='A')";

return $this->f_ejecutarSQL($sql,$offset,$result,$fase);
}

//----------------Carros sin placas

function carros_sin_placas ($data,$offset=null,$result=null,$fase=null) {

$sql = "SELECT
b.desmar ,c.desmod ,m.sermotveh,m.sercarveh, a.anofabveh, a.anomodveh ,descolor(m.col1veh),
 a.preveh
			FROM
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
			vehiculo m,  ptoadu n
			WHERE
			a.codmarveh	= b.codmar AND
			a.codmod	= c.codmod  AND
			a.numlotveh	= e.numlot AND
			a.codconveh	= f.codcon AND
			a.codclaveh	= g.codcla AND
			a.codtipveh	= h.codtip  AND
			a.codusoveh	= i.coduso  AND
			a.codserveh	= j.codser  AND
			m.id_caract	= a.id_caract AND
			a.codptoveh	= n.codpto  AND
			m.estatus	= 'A'";

  if($data[0]) $sql.= " AND m.sercarveh = '".$data[0]."'";
  if($data[1]) $sql.= " AND o.nomcomp  LIKE '%".$data[1]."%'";
  if($data[2]) $sql.= " AND e.numlot = '".$data[2]."'";
  if($data[3]) $sql.= " AND b.codmar = '".$data[3]."'";
  if($data[4]) $sql.= " AND c.codmod = '".$data[4]."'";
  if($data[5]) $sql.= " AND j.codser = '".$data[5]."'";

$sql.="EXCEPT (
SELECT

b.desmar ,c.desmod ,m.sermotveh,m.sercarveh, a.anofabveh, a.anomodveh ,descolor(m.col1veh),
 a.preveh
			FROM
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,
			vehiculo m,  placas k,  ptoadu n
			WHERE
			a.codmarveh	= b.codmar AND
			a.codmod	= c.codmod AND
			a.numlotveh	= e.numlot AND
			a.codconveh	= f.codcon AND
			a.codclaveh	= g.codcla AND
			a.codtipveh	= h.codtip AND
			a.codusoveh	= i.coduso AND
			a.codserveh	= j.codser AND
			m.id_caract = a.id_caract AND
			a.codptoveh	= n.codpto  AND
			k.sercarveh	= m.sercarveh AND
			m.estatus	= 'A'
			)";

return $this->f_ejecutarSQL($sql,$offset,$result,$fase);
}



function reporteEntGral($acto=null,$modelo=null,$marca=null,$banco=null,$lote=null){

$sql="select x.marca,x.modelo,count(x.cantidad),x.precio,sum(x.total),sum(x.montof),sum(x.tasa),sum(x.inicial)";

if ($acto)
	$sql.=" ,x.actof, x.actodes";

if ($lote)
	$sql.=" ,x.lote";

$sql.= " from
(select d.desmar as marca,e.desmod as modelo,a.sercarveh as cantidad,c.preveh as precio,
       sum(c.preveh) as total,sum(f.monto) as montof,sum(f.tasa) as tasa,
       (select sum(g.monto) from pago g where a.sercarveh=g.sercarveh and g.status='A' group by g.sercarveh) as inicial";

if ($acto)
	$sql.=" ,to_char(h.fecha,'dd/mm/yyyy') as actof, h.desacto as actodes";

if ($lote)
	$sql.=" ,c.numlotveh as lote ";

$sql.="
from entrega a
inner join vehiculo b on a.sercarveh=b.sercarveh
           inner join caracteristica c on b.id_caract=c.id_caract
                      inner join marcas d on c.codmarveh=d.codmar
		      inner join modelo e on c.codmod=e.codmod
inner join facturaprof f on a.sercarveh=f.sercarveh ";

if ($acto)
{
	$sql.=" inner join acto h on a.acto=h.idacto";
	$sql.=" where h.idacto='".$acto."'";
	$c=1;
}

if ($marca){
	if ($c==1)
		$sql.= " and d.codmar = '".$marca."'";
	else
	{
		$sql.= " where d.codmar = '".$marca."'";
		$c = 1;
	}
}

if ($modelo){
	if ($c==1)
		$sql.= " and e.codmod = '".$modelo."'";
	else
	{
		$sql.= " where e.codmod = '".$modelo."'";
		$c = 1;
	}
}


if ($banco){
	if ($c==1)
		$sql.= " and f.id_banco = '".$banco."'";
	else
	{
		$sql.= " where f.id_banco = '".$banco."'";
		$c = 1;
	}
}

if ($lote){
	if ($c==1)
		$sql.= " and c.numlotveh = '".$lote."'";
	else
	{
		$sql.= " where c.numlotveh = '".$lote."'";
		$c = 1;
	}
}

if ($c==1) $sql.= " and f.id_estatus=15 and f.estatus='A'";
else $sql.= " where f.id_estatus=15 and f.estatus='A'";

$sql.= " group by d.desmar,e.desmod,c.preveh,a.sercarveh";

if ($acto)
$sql.= ",h.fecha, h.desacto";

if ($lote)
$sql.= " , c.numlotveh ";

$sql.= " order by d.desmar,e.desmod) x
group by x.marca,x.modelo,x.precio";

if ($acto)
	$sql.=" ,x.actof, x.actodes";

if ($lote)
$sql.= " , x.lote ";

$sql.= " order by x.marca,x.modelo";

//echo '<br>'.$sql.'</br>';

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
}

//Matriz que muestra las marcas,modelos y cantidad de vehiculos por estatus
function resumenBancoVeh($marca=null,$fechaF=null,$fechaD=null,$fechaH=null,$modelo=null,$lote=null,$banco=null){
	$i=0;
 	$j=0;
 	$matriz = NULL;
 	/*if($dist) $idDist = $dist;
 	else $idDist = $_SESSION['distOrg'];*/
    $conexion = $this->conectar();

 	 $sql = "select d.desmar as marca,e.desmod as modelo,count(b.sercarveh) as cantidad,e.codmod
                 from vehiculo b
     inner join caracteristica c on b.id_caract=c.id_caract
     inner join marcas d on c.codmarveh=d.codmar
     inner join modelo e on c.codmod=e.codmod
     inner join lote f on c.numlotveh=f.numlot where f.numdep='1'";

     if ($marca) $sql.= " and d.codmar = '".$marca."'";
   	 if ($modelo) $sql.= " and e.codmod = '".$modelo."'";
     if ($lote) $sql.= " and c.numlotveh = '".$lote."'";

$sql.= " group by d.desmar,e.desmod,e.codmod
order by d.desmar,e.desmod";

     // print "1".$sql;
	/*if ($_SESSION['tipoUsuario']<>'10' or $dist) {
  			if ($_SESSION['tipoUsuario']=='2' and !$dist) $sql.=" and d.origen = '".$_SESSION['idDist']."'";
  			else $sql.=" and a.id_distribuidor = '".$idDist."'";
  		}

	 if ($ban) $sql.=" and a.id_banco = '".$ban."'";*/

    $consulta = $this->consultar($conexion,$sql);
    $filas = pg_num_rows($consulta);

    while ($data=pg_fetch_array($consulta))
	{
    	 $matriz[$i][0] = $data[0];
    	 $matriz[$i][1] = $data[1];
    	 $matriz[$i][2] = $data[2];

       //Vencidas
		$sql1 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql1 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '0' and f.estatus='A'";

 		if ($marca) $sql1.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql1.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql1.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql1.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql1.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql1.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql1.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql1.= " and f.id_banco = '".$banco."'";

//        print "<br>2".$sql1;

		$conexion1 = $this->conectar();
  		$consulta1 = $this->consultar($conexion1,$sql1);
  		$consulta1 = $this->ret_vector($consulta1);

         if($consulta1) $matriz[$i][3] = $consulta1[0];
 		 else $matriz[$i][3] = 0;


 		//Emitidas

 		$sql2 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql2 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '1' and f.estatus='A'";

		if ($marca) $sql2.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql2.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql2.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql2.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql2.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql2.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql2.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql2.= " and f.id_banco = '".$banco."'";

       // print "<br>3".$sql2;

		$conexion2 = $this->conectar();
  		$consulta2 = $this->consultar($conexion2,$sql2);
  		$consulta2 = $this->ret_vector($consulta2);

         if($consulta2) $matriz[$i][4] = $consulta2[0];
 		 else $matriz[$i][4] = 0;

		//En análisis

 		$sql3 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql3 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '2' and f.estatus='A'";

 		if ($marca)	$sql3.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql3.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql3.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql3.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql3.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql3.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql3.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql3.= " and f.id_banco = '".$banco."'";

     //   print "<br>4".$sql3;

		$conexion3 = $this->conectar();
  		$consulta3 = $this->consultar($conexion3,$sql3);
  		$consulta3 = $this->ret_vector($consulta3);

         if($consulta3) $matriz[$i][5] = $consulta3[0];
 		 else $matriz[$i][5] = 0;


 		 //A la espera de documentos

 		$sql4 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql4 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '3' and f.estatus='A'";
		if ($marca) $sql4.= " and d.codmar = '".$marca."'";
  		if ($modelo) $sql4.= " and e.codmod = '".$modelo."'";
  		if ($lote) $sql4.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql4.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql4.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql4.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql4.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql4.= " and f.id_banco = '".$banco."'";
     //   print "<br>5".$sql4;

		$conexion4 = $this->conectar();
  		$consulta4 = $this->consultar($conexion4,$sql4);
  		$consulta4 = $this->ret_vector($consulta4);

         if($consulta4) $matriz[$i][6] = $consulta4[0];
 		 else $matriz[$i][6] = 0;


 		//Crédito aprobado

 		$sql5 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql5 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '4' and f.estatus='A'";
		if ($marca) $sql5.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql5.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql5.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql5.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql5.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql5.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql5.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql5.= " and f.id_banco = '".$banco."'";

     //   print "<br>6".$sql5;

		$conexion5 = $this->conectar();
  		$consulta5 = $this->consultar($conexion5,$sql5);
  		$consulta5 = $this->ret_vector($consulta5);

         if($consulta5) $matriz[$i][7] = $consulta5[0];
 		 else $matriz[$i][7] = 0;


 		 //A la espera de consignacion

 		$sql6 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql6 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '5' and f.estatus='A'";
		if ($marca) $sql6.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql6.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql6.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql6.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql6.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql6.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql6.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql6.= " and f.id_banco = '".$banco."'";
     //   print "<br>7".$sql6;

		$conexion6 = $this->conectar();
  		$consulta6 = $this->consultar($conexion6,$sql6);
  		$consulta6 = $this->ret_vector($consulta6);

         if($consulta6) $matriz[$i][8] = $consulta6[0];
 		 else $matriz[$i][8] = 0;

 	    //Inicial consignada

 		$sql7 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql7 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '6' and f.estatus='A'";
		if ($marca) $sql7.= " and d.codmar = '".$marca."'";
  		if ($modelo) $sql7.= " and e.codmod = '".$modelo."'";
  		if ($lote) $sql7.= " and c.numlotveh = '".$lote."'";
  		if ($fechaF) $sql7.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql7.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql7.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql7.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql7.= " and f.id_banco = '".$banco."'";
     //   print "<br>8".$sql7;

		$conexion7 = $this->conectar();
  		$consulta7 = $this->consultar($conexion7,$sql7);
  		$consulta7 = $this->ret_vector($consulta7);

         if($consulta7) $matriz[$i][9] = $consulta7[0];
 		 else $matriz[$i][9] = 0;


	//Factura emitida

 		$sql8 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql8 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '7' and f.estatus='A'";
		if ($marca) $sql8.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql8.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql8.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql8.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql8.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql8.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql8.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql8.= " and f.id_banco = '".$banco."'";
     //   print "<br>9".$sql8;

		$conexion8 = $this->conectar();
  		$consulta8 = $this->consultar($conexion8,$sql8);
  		$consulta8 = $this->ret_vector($consulta8);

         if($consulta8) $matriz[$i][10] = $consulta8[0];
 		 else $matriz[$i][10] = 0;


	 //Certificado emitido

 		$sql9 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql9 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '8' and f.estatus='A'";

		if ($marca) $sql9.= " and d.codmar = '".$marca."'";
  		if ($modelo) $sql9.= " and e.codmod = '".$modelo."'";
  		if ($lote) $sql9.= " and c.numlotveh = '".$lote."'";
  		if ($fechaF) $sql9.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql9.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql9.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql9.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql9.= " and f.id_banco = '".$banco."'";
     //   print "<br>10".$sql9;

		$conexion9 = $this->conectar();
  		$consulta9 = $this->consultar($conexion9,$sql9);
  		$consulta9 = $this->ret_vector($consulta9);

         if($consulta9) $matriz[$i][11] = $consulta9[0];
 		 else $matriz[$i][11] = 0;

	 //Reserva de Dominio enviada a Suvinca

 		$sql10 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql10 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '9' and f.estatus='A'";
		if ($marca) $sql10.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql10.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql10.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql10.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql10.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql10.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql10.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql10.= " and f.id_banco = '".$banco."'";
     //   print "<br>11".$sql10;

		$conexion10 = $this->conectar();
  		$consulta10 = $this->consultar($conexion10,$sql10);
  		$consulta10 = $this->ret_vector($consulta10);

         if($consulta10) $matriz[$i][12] = $consulta10[0];
 		 else $matriz[$i][12] = 0;


 	//Firma de reserva

 		$sql11= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql11 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '10' and f.estatus='A'";
		if ($marca) $sql11.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql11.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql11.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql11.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql11.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql11.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql11.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql11.= " and f.id_banco = '".$banco."'";
     //   print "<br>12".$sql11;

		$conexion11 = $this->conectar();
  		$consulta11 = $this->consultar($conexion11,$sql11);
  		$consulta11 = $this->ret_vector($consulta11);

         if($consulta11) $matriz[$i][13] = $consulta11[0];
 		 else $matriz[$i][13] = 0;


 	 //Recepcion de reserva

 		$sql12= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql12 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '11' and f.estatus='A'";
		if ($marca) $sql12.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql12.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql12.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql12.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql12.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql12.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql12.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql12.= " and f.id_banco = '".$banco."'";
     //   print "<br>13".$sql12;

		$conexion12 = $this->conectar();
  		$consulta12 = $this->consultar($conexion12,$sql12);
  		$consulta12 = $this->ret_vector($consulta12);

         if($consulta12) $matriz[$i][14] = $consulta12[0];
 		 else $matriz[$i][14] = 0;



 		//Poliza consignada

 		$sql13= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql13 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '12' and f.estatus='A'";
		if ($marca) $sql13.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql13.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql13.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql13.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql13.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql13.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql13.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql13.= " and f.id_banco = '".$banco."'";
     //   print "<br>14".$sql13;

		$conexion13 = $this->conectar();
  		$consulta13 = $this->consultar($conexion13,$sql13);
  		$consulta13 = $this->ret_vector($consulta13);

         if($consulta13) $matriz[$i][15] = $consulta13[0];
 		 else $matriz[$i][15] = 0;


		//Documento notariado

 		$sql14= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql14 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '13' and f.estatus='A'";
		if ($marca) $sql14.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql14.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql14.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql14.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql14.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql14.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql14.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql14.= " and f.id_banco = '".$banco."'";
     //   print "<br>15".$sql14;

		$conexion14 = $this->conectar();
  		$consulta14 = $this->consultar($conexion14,$sql14);
  		$consulta14 = $this->ret_vector($consulta14);

         if($consulta14) $matriz[$i][16] = $consulta14[0];
 		 else $matriz[$i][16] = 0;


 		//Crédito Liquidado

 		$sql15= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql15 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '14' and f.estatus='A'";
		if ($marca) $sql15.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql15.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql15.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql15.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql15.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql15.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql15.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql15.= " and f.id_banco = '".$banco."'";
   	  //  print "<br>16".$sql15;

		$conexion15 = $this->conectar();
  		$consulta15 = $this->consultar($conexion15,$sql15);
  		$consulta15 = $this->ret_vector($consulta15);

         if($consulta15) $matriz[$i][17] = $consulta15[0];
 		 else $matriz[$i][17] = 0;


	   //Vehículo Entregado

 		$sql16= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql16 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '15' and f.estatus='A'";
		if ($marca) $sql16.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql16.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql16.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql16.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql16.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql16.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql16.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql16.= " and f.id_banco = '".$banco."'";
     //   print "<br>17".$sql16;

		$conexion16 = $this->conectar();
  		$consulta16 = $this->consultar($conexion16,$sql16);
  		$consulta16 = $this->ret_vector($consulta16);

         if($consulta16) $matriz[$i][18] = $consulta16[0];
 		 else $matriz[$i][18] = 0;



 		//Crédito rechazado

 		$sql17= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql17 .= " and e.codmod = '".$data[3]."'  and  f.id_estatus = '16'  and f.estatus='A'";
		if ($marca) $sql17.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql17.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql17.= " and c.numlotveh = '".$lote."'";
        if ($fechaF) $sql17.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql17.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql17.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql17.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql17.= " and f.id_banco = '".$banco."'";
     //   print "<br>18".$sql17;


		$conexion17 = $this->conectar();
  		$consulta17 = $this->consultar($conexion17,$sql17);
  		$consulta17 = $this->ret_vector($consulta17);

         if($consulta17) $matriz[$i][19] = $consulta17[0];
 		 else $matriz[$i][19] = 0;


 		$i++;
	//}
	$this->desconectar($conexion);
   }

   return $matriz;
}



//Matriz que muestra las marcas,modelos y cantidad de vehiculos por estatus desde la tabla movi_proforma
function resumenBancoVehMoviProf($marca=null,$fechaF=null,$fechaD=null,$fechaH=null,$modelo=null,$lote=null,$banco=null){
	$i=0;
 	$j=0;
 	$matriz = NULL;
 	/*if($dist) $idDist = $dist;
 	else $idDist = $_SESSION['distOrg'];*/
    $conexion = $this->conectar();

 	 $sql = "select d.desmar as marca,e.desmod as modelo,count(b.sercarveh) as cantidad,e.codmod
                 from vehiculo b
     inner join caracteristica c on b.id_caract=c.id_caract
     inner join marcas d on c.codmarveh=d.codmar
     inner join modelo e on c.codmod=e.codmod
     inner join lote f on c.numlotveh=f.numlot where f.numdep='1'";

     if ($marca) $sql.= " and d.codmar = '".$marca."'";
   	 if ($modelo) $sql.= " and e.codmod = '".$modelo."'";
     if ($lote) $sql.= " and c.numlotveh = '".$lote."'";

$sql.= " group by d.desmar,e.desmod,e.codmod
order by d.desmar,e.desmod";

//        print "1".$sql;
	/*if ($_SESSION['tipoUsuario']<>'10' or $dist) {
  			if ($_SESSION['tipoUsuario']=='2' and !$dist) $sql.=" and d.origen = '".$_SESSION['idDist']."'";
  			else $sql.=" and a.id_distribuidor = '".$idDist."'";
  		}

	 if ($ban) $sql.=" and a.id_banco = '".$ban."'";*/

    $consulta = $this->consultar($conexion,$sql);
    $filas = pg_num_rows($consulta);

    while ($data=pg_fetch_array($consulta))
	{
    	 $matriz[$i][0] = $data[0];
    	 $matriz[$i][1] = $data[1];
    	 $matriz[$i][2] = $data[2];

    	$ntime = substr(microtime(),2,6);

		$sqlT ="select distinct(id_estatus),max(fecha) as fecha, id_numfac INTO TEMPORARY movi_proformat".$ntime." from movi_proforma" .
				" GROUP BY id_estatus, id_numfac order by id_numfac, id_estatus";

       	$conexionT = $this->conectar();
  		$consultaT = $this->consultar($conexionT,$sqlT);

  	    //Vencidas
		$sql1 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
					inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql1 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '0' and f.estatus='A'";

 		if ($marca) $sql1.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql1.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql1.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql1.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql1.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql1.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql1.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql1.= " and f.id_banco = '".$banco."'";

 //       print "<br>2".$sql1;

	    $conexion1 = $this->conectar();
  		$consulta1 = $this->consultar($conexion1,$sql1);
  		$consulta1 = $this->ret_vector($consulta1);

         if($consulta1) $matriz[$i][3] = $consulta1[0];
 		 else $matriz[$i][3] = 0;


 		//Emitidas

 		$sql2 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql2 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '1' and f.estatus='A'";

		if ($marca) $sql2.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql2.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql2.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql2.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql2.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql2.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql2.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql2.= " and f.id_banco = '".$banco."'";

       // print "<br>3".$sql2;

		$conexion2 = $this->conectar();
  		$consulta2 = $this->consultar($conexion2,$sql2);
  		$consulta2 = $this->ret_vector($consulta2);

         if($consulta2) $matriz[$i][4] = $consulta2[0];
 		 else $matriz[$i][4] = 0;

		//En análisis

 		$sql3 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql3 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '2' and f.estatus='A'";

 		if ($marca)	$sql3.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql3.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql3.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql3.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql3.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql3.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql3.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql3.= " and f.id_banco = '".$banco."'";

       //print "<br>4".$sql3;

		$conexion3 = $this->conectar();
  		$consulta3 = $this->consultar($conexion3,$sql3);
  		$consulta3 = $this->ret_vector($consulta3);

         if($consulta3) $matriz[$i][5] = $consulta3[0];
 		 else $matriz[$i][5] = 0;


 		 //A la espera de documentos

 		$sql4 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql4 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '3' and f.estatus='A'";
		if ($marca) $sql4.= " and d.codmar = '".$marca."'";
  		if ($modelo) $sql4.= " and e.codmod = '".$modelo."'";
  		if ($lote) $sql4.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql4.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql4.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql4.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql4.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql4.= " and f.id_banco = '".$banco."'";

     //   print "<br>5".$sql4;

		$conexion4 = $this->conectar();
  		$consulta4 = $this->consultar($conexion4,$sql4);
  		$consulta4 = $this->ret_vector($consulta4);

         if($consulta4) $matriz[$i][6] = $consulta4[0];
 		 else $matriz[$i][6] = 0;


 		//Crédito aprobado

 		$sql5 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql5 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '4' and f.estatus='A'";
		if ($marca) $sql5.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql5.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql5.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql5.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql5.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql5.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql5.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql5.= " and f.id_banco = '".$banco."'";

     //   print "<br>6".$sql5;

		$conexion5 = $this->conectar();
  		$consulta5 = $this->consultar($conexion5,$sql5);
  		$consulta5 = $this->ret_vector($consulta5);

         if($consulta5) $matriz[$i][7] = $consulta5[0];
 		 else $matriz[$i][7] = 0;


 		 //A la espera de consignacion

 		$sql6 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql6 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '5' and f.estatus='A'";
		if ($marca) $sql6.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql6.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql6.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql6.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql6.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql6.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql6.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql6.= " and f.id_banco = '".$banco."'";
     //   print "<br>7".$sql6;

		$conexion6 = $this->conectar();
  		$consulta6 = $this->consultar($conexion6,$sql6);
  		$consulta6 = $this->ret_vector($consulta6);

         if($consulta6) $matriz[$i][8] = $consulta6[0];
 		 else $matriz[$i][8] = 0;

 	    //Inicial consignada

 		$sql7 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql7 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '6' and f.estatus='A'";
		if ($marca) $sql7.= " and d.codmar = '".$marca."'";
  		if ($modelo) $sql7.= " and e.codmod = '".$modelo."'";
  		if ($lote) $sql7.= " and c.numlotveh = '".$lote."'";
  		if ($fechaF) $sql7.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql7.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql7.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql7.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql7.= " and f.id_banco = '".$banco."'";
     //   print "<br>8".$sql7;

		$conexion7 = $this->conectar();
  		$consulta7 = $this->consultar($conexion7,$sql7);
  		$consulta7 = $this->ret_vector($consulta7);

         if($consulta7) $matriz[$i][9] = $consulta7[0];
 		 else $matriz[$i][9] = 0;


	//Factura emitida

 		$sql8 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql8 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '7' and f.estatus='A'";
		if ($marca) $sql8.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql8.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql8.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql8.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql8.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql8.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql8.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql8.= " and f.id_banco = '".$banco."'";
     //   print "<br>9".$sql8;

		$conexion8 = $this->conectar();
  		$consulta8 = $this->consultar($conexion8,$sql8);
  		$consulta8 = $this->ret_vector($consulta8);

         if($consulta8) $matriz[$i][10] = $consulta8[0];
 		 else $matriz[$i][10] = 0;


	 //Certificado emitido

 		$sql9 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql9 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '8' and f.estatus='A'";

		if ($marca) $sql9.= " and d.codmar = '".$marca."'";
  		if ($modelo) $sql9.= " and e.codmod = '".$modelo."'";
  		if ($lote) $sql9.= " and c.numlotveh = '".$lote."'";
  		if ($fechaF) $sql9.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql9.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql9.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql9.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql9.= " and f.id_banco = '".$banco."'";
     //   print "<br>10".$sql9;

		$conexion9 = $this->conectar();
  		$consulta9 = $this->consultar($conexion9,$sql9);
  		$consulta9 = $this->ret_vector($consulta9);

         if($consulta9) $matriz[$i][11] = $consulta9[0];
 		 else $matriz[$i][11] = 0;

	 //Reserva de Dominio enviada a Suvinca

 		$sql10 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql10 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '9' and f.estatus='A'";
		if ($marca) $sql10.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql10.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql10.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql10.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql10.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql10.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql10.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql10.= " and f.id_banco = '".$banco."'";
     //   print "<br>11".$sql10;

		$conexion10 = $this->conectar();
  		$consulta10 = $this->consultar($conexion10,$sql10);
  		$consulta10 = $this->ret_vector($consulta10);

         if($consulta10) $matriz[$i][12] = $consulta10[0];
 		 else $matriz[$i][12] = 0;


 	//Firma de reserva

 		$sql11= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql11 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '10' and f.estatus='A'";
		if ($marca) $sql11.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql11.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql11.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql11.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql11.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql11.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql11.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql11.= " and f.id_banco = '".$banco."'";
     //   print "<br>12".$sql11;

		$conexion11 = $this->conectar();
  		$consulta11 = $this->consultar($conexion11,$sql11);
  		$consulta11 = $this->ret_vector($consulta11);

         if($consulta11) $matriz[$i][13] = $consulta11[0];
 		 else $matriz[$i][13] = 0;


 	 //Recepcion de reserva

 		$sql12= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql12 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '11' and f.estatus='A'";
		if ($marca) $sql12.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql12.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql12.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql12.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql12.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql12.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql12.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql12.= " and f.id_banco = '".$banco."'";
     //   print "<br>13".$sql12;

		$conexion12 = $this->conectar();
  		$consulta12 = $this->consultar($conexion12,$sql12);
  		$consulta12 = $this->ret_vector($consulta12);

         if($consulta12) $matriz[$i][14] = $consulta12[0];
 		 else $matriz[$i][14] = 0;



 		//Poliza consignada

 		$sql13= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql13 .= " and e.codmod = '".$data[3]."'  and z.id_estatus = '12' and f.estatus='A'";
		if ($marca) $sql13.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql13.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql13.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql13.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql13.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql13.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql13.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql13.= " and f.id_banco = '".$banco."'";
     //   print "<br>14".$sql13;

		$conexion13 = $this->conectar();
  		$consulta13 = $this->consultar($conexion13,$sql13);
  		$consulta13 = $this->ret_vector($consulta13);

         if($consulta13) $matriz[$i][15] = $consulta13[0];
 		 else $matriz[$i][15] = 0;


		//Documento notariado

 		$sql14= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql14 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '13' and f.estatus='A'";
		if ($marca) $sql14.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql14.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql14.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql14.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql14.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql14.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql14.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql14.= " and f.id_banco = '".$banco."'";
     //   print "<br>15".$sql14;

		$conexion14 = $this->conectar();
  		$consulta14 = $this->consultar($conexion14,$sql14);
  		$consulta14 = $this->ret_vector($consulta14);

         if($consulta14) $matriz[$i][16] = $consulta14[0];
 		 else $matriz[$i][16] = 0;



		//Incompleto para liquidar

 		$sql18= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql18 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '19' and f.estatus='A'";
		if ($marca) $sql18.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql18.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql18.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql18.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql18.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql18.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql18.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql18.= " and f.id_banco = '".$banco."'";
     //   print "<br>19".$sql18;

		$conexion18 = $this->conectar();
  		$consulta18 = $this->consultar($conexion18,$sql18);
  		$consulta18 = $this->ret_vector($consulta18);

         if($consulta18) $matriz[$i][20] = $consulta18[0];
 		 else $matriz[$i][20] = 0;


 		//Crédito Liquidado

 		$sql15= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql15 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '14' and f.estatus='A'";
		if ($marca) $sql15.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql15.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql15.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql15.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql15.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql15.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql15.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql15.= " and f.id_banco = '".$banco."'";
   	  //  print "<br>16".$sql15;

		$conexion15 = $this->conectar();
  		$consulta15 = $this->consultar($conexion15,$sql15);
  		$consulta15 = $this->ret_vector($consulta15);

         if($consulta15) $matriz[$i][17] = $consulta15[0];
 		 else $matriz[$i][17] = 0;



	    //Por entregar en acto

 		$sql19= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql19 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '22' and f.estatus='A'";
		if ($marca) $sql19.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql19.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql19.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql19.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql19.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql19.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql19.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql19.= " and f.id_banco = '".$banco."'";

   	  //  print "<br>20".$sql19;

		$conexion19 = $this->conectar();
  		$consulta19 = $this->consultar($conexion19,$sql19);
  		$consulta19 = $this->ret_vector($consulta19);

         if($consulta19) $matriz[$i][21] = $consulta19[0];
 		 else $matriz[$i][21] = 0;


	   //Vehículo Entregado

 		$sql16= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql16 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '15' and f.estatus='A'";
		if ($marca) $sql16.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql16.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql16.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql16.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql16.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql16.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql16.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql16.= " and f.id_banco = '".$banco."'";

        //print "<br>17".$sql16;

		$conexion16 = $this->conectar();
  		$consulta16 = $this->consultar($conexion16,$sql16);
  		$consulta16 = $this->ret_vector($consulta16);

         if($consulta16) $matriz[$i][18] = $consulta16[0];
 		 else $matriz[$i][18] = 0;



 		//Crédito rechazado

 		$sql17= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql17 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '16'  and f.estatus='A'";
		if ($marca) $sql17.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql17.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql17.= " and c.numlotveh = '".$lote."'";
        if ($fechaF) $sql17.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql17.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql17.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql17.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql17.= " and f.id_banco = '".$banco."'";
     //   print "<br>18".$sql17;


		$conexion17 = $this->conectar();
  		$consulta17 = $this->consultar($conexion17,$sql17);
  		$consulta17 = $this->ret_vector($consulta17);

         if($consulta17) $matriz[$i][19] = $consulta17[0];
 		 else $matriz[$i][19] = 0;


 		//Reconsideracion

 		$sql20= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql20 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '18' and f.estatus='A'";
		if ($marca) $sql20.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql20.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql20.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql20.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql20.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql20.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql20.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql20.= " and f.id_banco = '".$banco."'";

   	  //  print "<br>21".$sql20;

		$conexion20= $this->conectar();
  		$consulta20 = $this->consultar($conexion20,$sql20);
  		$consulta20 = $this->ret_vector($consulta20);

         if($consulta20) $matriz[$i][22] = $consulta20[0];
 		 else $matriz[$i][22] = 0;


 		 //Reconsideracion

 		$sql20= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql20 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '18' and f.estatus='A'";
		if ($marca) $sql20.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql20.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql20.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql20.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql20.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql20.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql20.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql20.= " and f.id_banco = '".$banco."'";

   	  //  print "<br>21".$sql20;

		$conexion20= $this->conectar();
  		$consulta20 = $this->consultar($conexion20,$sql20);
  		$consulta20 = $this->ret_vector($consulta20);

         if($consulta20) $matriz[$i][22] = $consulta20[0];
 		 else $matriz[$i][22] = 0;

 		 //Aprobar Reconsideracion

 		$sql21= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql21 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '20' and f.estatus='A'";
		if ($marca) $sql21.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql21.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql21.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql21.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql21.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql21.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql21.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql21.= " and f.id_banco = '".$banco."'";

   	  //  print "<br>22".$sql21;

		$conexion21= $this->conectar();
  		$consulta21 = $this->consultar($conexion21,$sql21);
  		$consulta21 = $this->ret_vector($consulta21);

         if($consulta21) $matriz[$i][23] = $consulta21[0];
 		 else $matriz[$i][23] = 0;


 		  //Rechazar Reconsideracion

 		$sql22= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql22 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '21' and f.estatus='A'";
		if ($marca) $sql22.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql22.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql22.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql22.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql22.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql22.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql22.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql22.= " and f.id_banco = '".$banco."'";

   	 //print "<br>23".$sql22;

		$conexion22= $this->conectar();
  		$consulta22 = $this->consultar($conexion22,$sql22);
  		$consulta22 = $this->ret_vector($consulta22);

         if($consulta22) $matriz[$i][24] = $consulta22[0];
 		 else $matriz[$i][24] = 0;



 		$i++;
	//}
	$this->desconectar($conexion);
   }

   return $matriz;
}

/*function resumenCarrosOLD($marca=null,$fechaF=null,$fechaD=null,$fechaH=null,$codmodveh=null,$lote=null,$banco=null){

$sql= "select z.numlot,z.codmarveh,z.codserie,z.codmod,count(z.codmod) from (SELECT
a.numlot,b.id_caract,b.codmarveh,b.codserie,b.codmod,b.preveh,c.id_vehiculo
FROM
  lote a,
  caracteristica b,
  vehiculo c
WHERE
  a.numlot = b.numlotveh AND
  b.id_caract = c.id_caract and c.estatus='A'";

  if ($lote)  $sql.= " and a.numlot = '".$lote."'";
  if ($marca) $sql.= " and b.codmarveh in (select codmar from marcas where desmar like '".$marca."')";
  if ($codmodveh) $sql.= " and b.codmod in (select codmod from modelo where desmod like '".$codmodveh."')";

$sql.=") z
group by z.numlot,z.codmarveh,z.codserie,z.codmod
order by z.numlot,z.codmarveh";

//echo $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;

}*/



function resumenCarros($marca=null,$fechaF=null,$fechaD=null,$fechaH=null,$modelo=null,$lote=null,$banco=null){
	$i=0;
 	$j=0;
 	$matriz = NULL;
    $conexion = $this->conectar();

 	 $sql = "select f.numlot,d.desmar as marca,e.desmod as modelo,count(b.sercarveh) as cantidad,e.codmod,d.codmar
                 from vehiculo b
     inner join caracteristica c on b.id_caract=c.id_caract
     inner join marcas d on c.codmarveh=d.codmar
     inner join modelo e on c.codmod=e.codmod
     inner join lote f on c.numlotveh=f.numlot where f.numdep='1'";

     if ($marca) $sql.= " and d.codmar = '".$marca."'";
   	 if ($modelo) $sql.= " and e.codmod = '".$modelo."'";
     if ($lote) $sql.= " and c.numlotveh = '".$lote."'";

$sql.= " group by f.numlot,d.desmar,e.desmod,e.codmod,d.codmar
order by f.numlot,d.desmar,e.desmod";

    // print "1".$sql;


	/*if ($_SESSION['tipoUsuario']<>'10' or $dist) {
  			if ($_SESSION['tipoUsuario']=='2' and !$dist) $sql.=" and d.origen = '".$_SESSION['idDist']."'";
  			else $sql.=" and a.id_distribuidor = '".$idDist."'";
  		}

	 if ($ban) $sql.=" and a.id_banco = '".$ban."'";*/

    $consulta = $this->consultar($conexion,$sql);
    $filas = pg_num_rows($consulta);

    while ($data=pg_fetch_array($consulta))
	{
    	 $matriz[$i][0] = $data[0];

    	//Total por lote
		$sqlLote = "select sum(cantidad) from (select f.numlot,d.desmar as marca,e.desmod as modelo,count(b.sercarveh) as cantidad,e.codmod
                 from vehiculo b
     inner join caracteristica c on b.id_caract=c.id_caract
     inner join marcas d on c.codmarveh=d.codmar
     inner join modelo e on c.codmod=e.codmod
     inner join lote f on c.numlotveh=f.numlot where f.numdep='1'";

     if ($marca) $sqlLote.= " and d.codmar = '".$marca."'";
   	 if ($modelo) $sqlLote.= " and e.codmod = '".$modelo."'";
     if ($lote) $sqlLote.= " and c.numlotveh = '".$lote."'";

$sqlLote.= " group by f.numlot,d.desmar,e.desmod,e.codmod
order by f.numlot,d.desmar,e.desmod) z group by z.numlot";

    //   print "<br>2".$sqlLote;

		$conexionLote = $this->conectar();
  		$consultaLote = $this->consultar($conexionLote,$sqlLote);
  		$consultaLote = $this->ret_vector($consultaLote);

         if($consultaLote)  $matriz[$i][1] = $consultaLote[0];
 		 else $matriz[$i][1] = 0;



    	 $matriz[$i][2] = $data[1];
    	 $matriz[$i][3] = $data[2];
    	 $matriz[$i][4] = $data[3];
    	 $matriz[$i][22] = $data[5]; //Codigo marca


       //Vencidas
		$sql1 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql1 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '0' and f.estatus='A'  and g.numlot=$data[0]";

 		if ($marca) $sql1.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql1.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql1.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql1.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql1.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql1.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql1.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql1.= " and f.id_banco = '".$banco."'";

      // print "<br>2".$sql1;

		$conexion1 = $this->conectar();
  		$consulta1 = $this->consultar($conexion1,$sql1);
  		$consulta1 = $this->ret_vector($consulta1);

         if($consulta1) $matriz[$i][5] = $consulta1[0];
 		 else $matriz[$i][5] = 0;


 		//Emitidas

 		$sql2 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql2 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '1' and f.estatus='A'  and g.numlot=$data[0]";

		if ($marca) $sql2.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql2.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql2.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql2.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql2.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql2.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql2.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql2.= " and f.id_banco = '".$banco."'";

        //print "<br>3".$sql2;

        $conexion2 = $this->conectar();
  		$consulta2 = $this->consultar($conexion2,$sql2);
  		$consulta2 = $this->ret_vector($consulta2);

  		$sql2_1 = "SELECT  count(f.id_numfac) FROM  facturaprof f, preinventario p WHERE  p.id_preinv = f.id_preinv
  				and f.estatus='A' and f.id_preinv is not null  and  f.id_estatus = '1' and  p.id_modelo= '".$data[4]."'";

  		if ($modelo) $sql2_1.= " and p.id_modelo = '".$modelo."'";
  		if ($marca) $sql2_1.= " and p.id_marca = '".$marca."'";
  		if ($lote) $sql2_1.= " and p.id_serie = '".$lote."'";
  		if ($fechaF) $sql2_1.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql2_1.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql2_1.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql2_1.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql2_1.= " and f.id_banco = '".$banco."'";


  		//print "<br>3".$sql2_1;

  		$conexion2_1 = $this->conectar();
  		$consulta2_1 = $this->consultar($conexion2_1,$sql2_1);
  		$consulta2_1 = $this->ret_vector($consulta2_1);

        $invento = $consulta2[0] + $consulta2_1[0];

        if($consulta2) $matriz[$i][6] = $invento;
 		else $matriz[$i][6] = 0;


		//En análisis

 		$sql3 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql3 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '2' and f.estatus='A'  and g.numlot=$data[0]";

 		if ($marca)	$sql3.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql3.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql3.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql3.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql3.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql3.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql3.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql3.= " and f.id_banco = '".$banco."'";

      //  print "<br>4".$sql3;

		$conexion3 = $this->conectar();
  		$consulta3 = $this->consultar($conexion3,$sql3);
  		$consulta3 = $this->ret_vector($consulta3);

         if($consulta3) $matriz[$i][7] = $consulta3[0];
 		 else $matriz[$i][7] = 0;


 		 //A la espera de documentos

 		$sql4 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql4 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '3' and f.estatus='A'  and g.numlot=$data[0]";
		if ($marca) $sql4.= " and d.codmar = '".$marca."'";
  		if ($modelo) $sql4.= " and e.codmod = '".$modelo."'";
  		if ($lote) $sql4.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql4.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql4.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql4.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql4.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql4.= " and f.id_banco = '".$banco."'";
    //    print "<br>5".$sql4;

		$conexion4 = $this->conectar();
  		$consulta4 = $this->consultar($conexion4,$sql4);
  		$consulta4 = $this->ret_vector($consulta4);

         if($consulta4) $matriz[$i][8] = $consulta4[0];
 		 else $matriz[$i][8] = 0;


 		//Crédito aprobado

 		$sql5 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql5 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '4' and f.estatus='A'  and g.numlot=$data[0]";
		if ($marca) $sql5.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql5.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql5.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql5.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql5.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql5.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql5.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql5.= " and f.id_banco = '".$banco."'";

      //  print "<br>6".$sql5;

		$conexion5 = $this->conectar();
  		$consulta5 = $this->consultar($conexion5,$sql5);
  		$consulta5 = $this->ret_vector($consulta5);

         if($consulta5) $matriz[$i][9] = $consulta5[0];
 		 else $matriz[$i][9] = 0;


 		 //A la espera de consignacion

 		$sql6 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql6 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '5' and f.estatus='A'  and g.numlot=$data[0]";
		if ($marca) $sql6.= " and d.codmar = '".$marca."'";
 		if ($modelo) $sql6.= " and e.codmod = '".$modelo."'";
 		if ($lote) $sql6.= " and c.numlotveh = '".$lote."'";
 		if ($fechaF) $sql6.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql6.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql6.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql6.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql6.= " and f.id_banco = '".$banco."'";
     //  print "<br>7".$sql6;

		$conexion6 = $this->conectar();
  		$consulta6 = $this->consultar($conexion6,$sql6);
  		$consulta6 = $this->ret_vector($consulta6);

         if($consulta6) $matriz[$i][10] = $consulta6[0];
 		 else $matriz[$i][10] = 0;

 	    //Inicial consignada

 		$sql7 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql7 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '6' and f.estatus='A'  and g.numlot=$data[0]";
		if ($marca) $sql7.= " and d.codmar = '".$marca."'";
  		if ($modelo) $sql7.= " and e.codmod = '".$modelo."'";
  		if ($lote) $sql7.= " and c.numlotveh = '".$lote."'";
  		if ($fechaF) $sql7.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql7.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql7.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql7.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql7.= " and f.id_banco = '".$banco."'";
      //  print "<br>8".$sql7;

		$conexion7 = $this->conectar();
  		$consulta7 = $this->consultar($conexion7,$sql7);
  		$consulta7 = $this->ret_vector($consulta7);

         if($consulta7) $matriz[$i][11] = $consulta7[0];
 		 else $matriz[$i][11] = 0;


	//Factura emitida

 		$sql8 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql8 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '7' and f.estatus='A'  and g.numlot=$data[0]";
		if ($marca) $sql8.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql8.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql8.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql8.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql8.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql8.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql8.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql8.= " and f.id_banco = '".$banco."'";
      //  print "<br>9".$sql8;

		$conexion8 = $this->conectar();
  		$consulta8 = $this->consultar($conexion8,$sql8);
  		$consulta8 = $this->ret_vector($consulta8);

         if($consulta8) $matriz[$i][12] = $consulta8[0];
 		 else $matriz[$i][12] = 0;


	 //Certificado emitido

 		$sql9 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql9 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '8' and f.estatus='A'  and g.numlot=$data[0]";

		if ($marca) $sql9.= " and d.codmar = '".$marca."'";
  		if ($modelo) $sql9.= " and e.codmod = '".$modelo."'";
  		if ($lote) $sql9.= " and c.numlotveh = '".$lote."'";
  		if ($fechaF) $sql9.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql9.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql9.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql9.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql9.= " and f.id_banco = '".$banco."'";
      //  print "<br>10".$sql9;

		$conexion9 = $this->conectar();
  		$consulta9 = $this->consultar($conexion9,$sql9);
  		$consulta9 = $this->ret_vector($consulta9);

         if($consulta9) $matriz[$i][13] = $consulta9[0];
 		 else $matriz[$i][13] = 0;

	 //Reserva de Dominio enviada a Suvinca

 		$sql10 = "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql10 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '9' and f.estatus='A'  and g.numlot=$data[0]";
		if ($marca) $sql10.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql10.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql10.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql10.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql10.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql10.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql10.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql10.= " and f.id_banco = '".$banco."'";
        //print "<br>11".$sql10;

		$conexion10 = $this->conectar();
  		$consulta10 = $this->consultar($conexion10,$sql10);
  		$consulta10 = $this->ret_vector($consulta10);

         if($consulta10) $matriz[$i][14] = $consulta10[0];
 		 else $matriz[$i][14] = 0;


 	//Firma de reserva

 		$sql11= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql11 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '10' and f.estatus='A'  and g.numlot=$data[0]";
		if ($marca) $sql11.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql11.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql11.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql11.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql11.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql11.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql11.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql11.= " and f.id_banco = '".$banco."'";
       //print "<br>12".$sql11;

		$conexion11 = $this->conectar();
  		$consulta11 = $this->consultar($conexion11,$sql11);
  		$consulta11 = $this->ret_vector($consulta11);

         if($consulta11) $matriz[$i][15] = $consulta11[0];
 		 else $matriz[$i][15] = 0;


 	 //Recepcion de reserva

 		$sql12= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql12 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '11' and f.estatus='A'  and g.numlot=$data[0]";
		if ($marca) $sql12.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql12.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql12.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql12.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql12.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql12.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql12.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql12.= " and f.id_banco = '".$banco."'";
       //print "<br>13".$sql12;

		$conexion12 = $this->conectar();
  		$consulta12 = $this->consultar($conexion12,$sql12);
  		$consulta12 = $this->ret_vector($consulta12);

         if($consulta12) $matriz[$i][16] = $consulta12[0];
 		 else $matriz[$i][16] = 0;



 		//Poliza consignada

 		$sql13= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql13 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '12' and f.estatus='A'  and g.numlot=$data[0]";
		if ($marca) $sql13.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql13.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql13.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql13.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql13.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql13.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql13.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql13.= " and f.id_banco = '".$banco."'";
        //print "<br>14".$sql13;

		$conexion13 = $this->conectar();
  		$consulta13 = $this->consultar($conexion13,$sql13);
  		$consulta13 = $this->ret_vector($consulta13);

         if($consulta13) $matriz[$i][17] = $consulta13[0];
 		 else $matriz[$i][17] = 0;


		//Documento notariado

 		$sql14= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql14 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '13' and f.estatus='A'  and g.numlot=$data[0]";
		if ($marca) $sql14.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql14.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql14.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql14.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql14.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql14.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql14.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql14.= " and f.id_banco = '".$banco."'";
        //print "<br>15".$sql14;

		$conexion14 = $this->conectar();
  		$consulta14 = $this->consultar($conexion14,$sql14);
  		$consulta14 = $this->ret_vector($consulta14);

         if($consulta14) $matriz[$i][18] = $consulta14[0];
 		 else $matriz[$i][18] = 0;


 		//Crédito Liquidado

 		$sql15= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql15 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '14' and f.estatus='A'  and g.numlot=$data[0]";
		if ($marca) $sql15.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql15.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql15.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql15.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql15.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql15.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql15.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql15.= " and f.id_banco = '".$banco."'";
   	  //print "<br>16".$sql15;

		$conexion15 = $this->conectar();
  		$consulta15 = $this->consultar($conexion15,$sql15);
  		$consulta15 = $this->ret_vector($consulta15);

         if($consulta15) $matriz[$i][19] = $consulta15[0];
 		 else $matriz[$i][19] = 0;


	   //Vehículo Entregado

 		$sql16= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql16 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '15' and f.estatus='A'  and g.numlot=$data[0]";
		if ($marca) $sql16.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql16.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql16.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql16.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql16.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql16.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql16.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql16.= " and f.id_banco = '".$banco."'";

        //print "<br>17".$sql16;

		$conexion16 = $this->conectar();
  		$consulta16 = $this->consultar($conexion16,$sql16);
  		$consulta16 = $this->ret_vector($consulta16);

         if($consulta16) $matriz[$i][20] = $consulta16[0];
 		 else $matriz[$i][20] = 0;



 		//Crédito rechazado

 		$sql17= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql17 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '16'  and f.estatus='A' and g.numlot=$data[0]";
		if ($marca) $sql17.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql17.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql17.= " and c.numlotveh = '".$lote."'";
        if ($fechaF) $sql17.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql17.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql17.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql17.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql17.= " and f.id_banco = '".$banco."'";
       //print "<br>18".$sql17;


		$conexion17 = $this->conectar();
  		$consulta17 = $this->consultar($conexion17,$sql17);
  		$consulta17 = $this->ret_vector($consulta17);

         if($consulta17) $matriz[$i][21] = $consulta17[0];
 		 else $matriz[$i][21] = 0;


 		 //Por entregar en acto

 		$sql18= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql18 .= " and e.codmod = '".$data[4]."'  and  f.id_estatus = '22'  and f.estatus='A' and g.numlot=$data[0]";
		if ($marca) $sql18.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql18.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql18.= " and c.numlotveh = '".$lote."'";
        if ($fechaF) $sql18.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql18.= " and f.fecha_estatus >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql18.= " and f.fecha_estatus <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql18.= " and f.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql18.= " and f.id_banco = '".$banco."'";
  //     print "<br>18".$sql18;


		$conexion18 = $this->conectar();
  		$consulta18 = $this->consultar($conexion18,$sql18);
  		$consulta18 = $this->ret_vector($consulta18);

         if($consulta18) $matriz[$i][22] = $consulta18[0];
 		 else $matriz[$i][22] = 0;



 		  //Busco los vehículos con PDI no aprobado

 		$sql19= "select count(b.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1' and e.codmod = '".$data[4]."' and b.estatus='E' and c.numlotveh = '".$data[0]."' ";

		if ($marca) $sql19.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql19.= " and e.codmod = '".$modelo."'";
   		if ($lote) $sql19.= " and c.numlotveh = '".$lote."'";
   		/*if ($fechaF) $sql19.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql19.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql19.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql19.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql19.= " and f.id_banco = '".$banco."'";*/

	    //echo "<br>Busco veh no pdi: ".$sql19;

		$conexion19 = $this->conectar();
  		$consulta19 = $this->consultar($conexion19,$sql19);
  		$consulta19 = $this->ret_vector($consulta19);

         if($consulta19) $matriz[$i][23] = $consulta19[0];
 		 else $matriz[$i][23] = 0;


        $matriz[$i][24]= $data[5];
 		$i++;
	//}
	$this->desconectar($conexion);
   }

   return $matriz;
}


//RESUMEN CERTIFICADOS EMITIDOS, agrupado por banco y marca
function resumenCertEmit($fechaD=null,$fechaH=null,$cond=null,$status=null,$lote=null){//($lote=null,$fechaD=null,$fechaH=null,$cond=null,$marca=null,$modelo=null,$banco=null){
	$i=0;
 	$j=0;
 	//$matriz = NULL;

	$banco[0] = "0003";
    $banco[1] = "0102";
    $banco[2] = "0163";
    $banco[3] = "0175";
    $banco[4] = "0602";
    $banco[5] = "0149";

    $marcas[0]="QQ3";
    $marcas[1]="X1";
    $marcas[2]="TIG";
    $marcas[3]="TG4";
    $marcas[4]="T44";

	for($i=0;$i<count($banco);$i+=1){
		$banco[$i];

		for($j=0;$j<count($marcas);$j+=1){
	        $sql1="select
                        count(a.id_banco) as cantidad,
                        d.banco_descrip,
                        d.id_banco,
                        l.desmod,
                        l.codmod
                        from
                        asignacion  b, vehiculo i
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
                        left outer join certificados o on o.id_asignacion=a.id_asignacion  AND o.estatus='A',
                        lote n
                        where";


           if ($cond<>"CONTADO") $sql1.= "  d.id_banco='".$banco[$i]."' and";

           $sql1.=  "   l.codmod='".$marcas[$j]."' and
                        j.numlotveh=n.numlot and
                        i.id_caract=j.id_caract and
                        b.sercarveh=i.sercarveh and
                        a.estatus='A' and n.numlot=".$lote."  and b.sercarveh<>'0'

                        and a.id_asignacion=b.id_asignacion
                        and b.codpro=c.codpro";

		    //if ($lote)   $sql.= " and n.numlot= '".$lote."'";
		    //if ($fechaD) $sql1.=" and a.fecha_estatus>='".$fechaD."'";

		    if ($status) $sql1.=" and a.id_estatus='".$status."'";
		  //  else $sql1.=" and e.descripcion='CERTIFICADO EMITIDO'";



		    if ($cond<>"" AND $cond<>"TODAS")   $sql1.= " and a.condpago='".$cond."'";
		    if ($cond=="") $sql1.= " and ( a.condpago='CREDITO' OR a.condpago='COMPLETO') ";
		    if ($cond=="TODAS") $sql1.= " and ( a.condpago='CREDITO' OR a.condpago='COMPLETO' OR a.condpago='CONTADO') ";


 			if($fechaD AND !$fechaH) $sql1.= " and a.fecha_estatus >= '".$fechaD."'";
	        else if (!$fechaD AND  $fechaH) $sql1.= " and a.fecha_estatus <= '".$fechaH."'";
	        else if ($fechaD  AND  $fechaH)	$sql1.= " and a.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";

	        /*if ($marca) $sql.= " and j.codmarveh='".$marca."'";
            if ($modelo) $sql.= " and j.codmod='".$modelo."'";
            if ($banco) $sql.= " and a.id_banco='".$banco."'";*/

			$sql1.=" group by a.id_banco, d.banco_descrip, l.desmod,d.id_banco,l.codmod order by a.id_banco, l.desmod";
//print '<br>'.$sql1; //die();
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql1);
  $consulta = $this->ret_vector($consulta);
  //echo $consulta[1];
  if (!$consulta[0]) $consulta[0]=0;
  //$matriz[$i][0]=$consulta[1];
  $matriz[$i][$j]=$consulta[0];

//echo '<br>'.$matriz[$i][$j];

  //echo $consulta[0];
  $this->desconectar($conexion);
		}
	}
  return $matriz;
}

function resumenCertEmit2($fechaD=null,$fechaH=null,$cond=null,$status=null,$lote=null){
  $sql="
			select

			x.id_banco, x.banco_descrip ,
			(
			select
			count(a.id_asignacion) as cantidad
			from
			asignacion  b, vehiculo i
			left outer join placas h  on h.sercarveh=i.sercarveh,
			caracteristica j
			left outer join marcas k on k.codmar=j.codmarveh
			left outer join modelo l  on l.codmod=j.codmod
			left outer join serie m  on m.codserie=j.codserie,
			facturaprof a
			left outer join estatus e on e.id_estatus=a.id_estatus,
			lote n
			where
			l.codmod='QQ3' and
			j.numlotveh=n.numlot and
			i.id_caract=j.id_caract and
			b.sercarveh=i.sercarveh and
			a.estatus='A'  and b.sercarveh<>'0'
			and a.id_asignacion=b.id_asignacion and a.id_banco=x.id_banco ";
			if ($fechaD) $sql.=" and a.fecha_estatus>='".$fechaD."'  ";
			if ($fechaH) $sql.=" and a.fecha_estatus<='".$fechaH."'  ";
			if ($cond) $sql.=" and a.condpago='".$cond."'  ";
			if ($status) $sql.=" and a.id_estatus='".$status."'  ";
			if ($lote) $sql.=" and j.numlotveh='".$lote."'  ";
$sql.="
			) as qq3,
			(
			select
			count(a.id_asignacion) as cantidad
			from
			asignacion  b, vehiculo i
			left outer join placas h  on h.sercarveh=i.sercarveh,
			caracteristica j
			left outer join marcas k on k.codmar=j.codmarveh
			left outer join modelo l  on l.codmod=j.codmod
			left outer join serie m  on m.codserie=j.codserie,
			facturaprof a
			left outer join estatus e on e.id_estatus=a.id_estatus,
			lote n
			where
			l.codmod='X1' and
			j.numlotveh=n.numlot and
			i.id_caract=j.id_caract and
			b.sercarveh=i.sercarveh and
			a.estatus='A' and b.sercarveh<>'0'
			and a.id_asignacion=b.id_asignacion and a.id_banco=x.id_banco ";
			if ($fechaD) $sql.=" and a.fecha_estatus>='".$fechaD."'  ";
			if ($fechaH) $sql.=" and a.fecha_estatus<='".$fechaH."'  ";
			if ($cond) $sql.=" and a.condpago='".$cond."'  ";
			if ($status) $sql.=" and a.id_estatus='".$status."'  ";
			if ($lote) $sql.=" and j.numlotveh='".$lote."'  ";
$sql.="
			) as x1,
			(
			select
			count(a.id_asignacion) as cantidad
			from
			asignacion  b, vehiculo i
			left outer join placas h  on h.sercarveh=i.sercarveh,
			caracteristica j
			left outer join marcas k on k.codmar=j.codmarveh
			left outer join modelo l  on l.codmod=j.codmod
			left outer join serie m  on m.codserie=j.codserie,
			facturaprof a
			left outer join estatus e on e.id_estatus=a.id_estatus,
			lote n
			where
			l.codmod='TIG' and
			j.numlotveh=n.numlot and
			i.id_caract=j.id_caract and
			b.sercarveh=i.sercarveh and
			a.estatus='A' and b.sercarveh<>'0'
			and a.id_asignacion=b.id_asignacion and a.id_banco=x.id_banco ";
			if ($fechaD) $sql.=" and a.fecha_estatus>='".$fechaD."'  ";
			if ($fechaH) $sql.=" and a.fecha_estatus<='".$fechaH."'  ";
			if ($cond) $sql.=" and a.condpago='".$cond."'  ";
			if ($status) $sql.=" and a.id_estatus='".$status."'  ";
			if ($lote) $sql.=" and j.numlotveh='".$lote."'  ";
$sql.="
			) as tiggo,
			(
			select
			count(a.id_asignacion) as cantidad
			from
			asignacion  b, vehiculo i
			left outer join placas h  on h.sercarveh=i.sercarveh,
			caracteristica j
			left outer join marcas k on k.codmar=j.codmarveh
			left outer join modelo l  on l.codmod=j.codmod
			left outer join serie m  on m.codserie=j.codserie,
			facturaprof a
			left outer join estatus e on e.id_estatus=a.id_estatus,
			lote n
			where
			l.codmod='TG4' and
			j.numlotveh=n.numlot and
			i.id_caract=j.id_caract and
			b.sercarveh=i.sercarveh and
			a.estatus='A' and b.sercarveh<>'0'
			and a.id_asignacion=b.id_asignacion and a.id_banco=x.id_banco ";
			if ($fechaD) $sql.=" and a.fecha_estatus>='".$fechaD."'  ";
			if ($fechaH) $sql.=" and a.fecha_estatus<='".$fechaH."'  ";
			if ($cond) $sql.=" and a.condpago='".$cond."'  ";
			if ($status) $sql.=" and a.id_estatus='".$status."'  ";
			if ($lote) $sql.=" and j.numlotveh='".$lote."'  ";
$sql.="
			) as gra42,
			(
			select
			count(a.id_asignacion) as cantidad
			from
			asignacion  b, vehiculo i
			left outer join placas h  on h.sercarveh=i.sercarveh,
			caracteristica j
			left outer join marcas k on k.codmar=j.codmarveh
			left outer join modelo l  on l.codmod=j.codmod
			left outer join serie m  on m.codserie=j.codserie,
			facturaprof a
			left outer join estatus e on e.id_estatus=a.id_estatus,
			lote n
			where
			l.codmod='T44' and
			j.numlotveh=n.numlot and
			i.id_caract=j.id_caract and
			b.sercarveh=i.sercarveh and
			a.estatus='A' and b.sercarveh<>'0'
			and a.id_asignacion=b.id_asignacion and a.id_banco=x.id_banco ";
			if ($fechaD) $sql.=" and a.fecha_estatus>='".$fechaD."'  ";
			if ($fechaH) $sql.=" and a.fecha_estatus<='".$fechaH."'  ";
			if ($cond) $sql.=" and a.condpago='".$cond."'  ";
			if ($status) $sql.=" and a.id_estatus='".$status."'  ";
			if ($lote) $sql.=" and j.numlotveh='".$lote."'  ";
$sql.="
			) as gra44
			from
			banco x
			where x.tipo='1' ";
	//	print '<pre>';print $sql;exit;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
   return $consulta;
}

function resumenCertEmit3($fechaD=null,$fechaH=null,$cond=null,$status=null,$lote=null){
  $sql="
			select

			'0000', 'CONTADO' ,
			(
			select
			count(a.id_asignacion) as cantidad
			from
			asignacion  b, vehiculo i
			left outer join placas h  on h.sercarveh=i.sercarveh,
			caracteristica j
			left outer join marcas k on k.codmar=j.codmarveh
			left outer join modelo l  on l.codmod=j.codmod
			left outer join serie m  on m.codserie=j.codserie,
			facturaprof a
			left outer join estatus e on e.id_estatus=a.id_estatus,
			lote n
			where
			l.codmod='QQ3' and
			j.numlotveh=n.numlot and
			i.id_caract=j.id_caract and
			b.sercarveh=i.sercarveh and
			a.estatus='A'  and b.sercarveh<>'0'
			and a.id_asignacion=b.id_asignacion and a.id_banco=x.id_banco ";
			if ($fechaD) $sql.=" and a.fecha_estatus>='".$fechaD."'  ";
			if ($fechaH) $sql.=" and a.fecha_estatus<='".$fechaH."'  ";
			if ($cond) $sql.=" and a.condpago='".$cond."'  ";
			if ($status) $sql.=" and a.id_estatus='".$status."'  ";
			if ($lote) $sql.=" and j.numlotveh='".$lote."'  ";
$sql.="
			) as qq3,
			(
			select
			count(a.id_asignacion) as cantidad
			from
			asignacion  b, vehiculo i
			left outer join placas h  on h.sercarveh=i.sercarveh,
			caracteristica j
			left outer join marcas k on k.codmar=j.codmarveh
			left outer join modelo l  on l.codmod=j.codmod
			left outer join serie m  on m.codserie=j.codserie,
			facturaprof a
			left outer join estatus e on e.id_estatus=a.id_estatus,
			lote n
			where
			l.codmod='X1' and
			j.numlotveh=n.numlot and
			i.id_caract=j.id_caract and
			b.sercarveh=i.sercarveh and
			a.estatus='A' and b.sercarveh<>'0'
			and a.id_asignacion=b.id_asignacion and a.id_banco=x.id_banco ";
			if ($fechaD) $sql.=" and a.fecha_estatus>='".$fechaD."'  ";
			if ($fechaH) $sql.=" and a.fecha_estatus<='".$fechaH."'  ";
			if ($cond) $sql.=" and a.condpago='".$cond."'  ";
			if ($status) $sql.=" and a.id_estatus='".$status."'  ";
			if ($lote) $sql.=" and j.numlotveh='".$lote."'  ";
$sql.="
			) as x1,
			(
			select
			count(a.id_asignacion) as cantidad
			from
			asignacion  b, vehiculo i
			left outer join placas h  on h.sercarveh=i.sercarveh,
			caracteristica j
			left outer join marcas k on k.codmar=j.codmarveh
			left outer join modelo l  on l.codmod=j.codmod
			left outer join serie m  on m.codserie=j.codserie,
			facturaprof a
			left outer join estatus e on e.id_estatus=a.id_estatus,
			lote n
			where
			l.codmod='TIG' and
			j.numlotveh=n.numlot and
			i.id_caract=j.id_caract and
			b.sercarveh=i.sercarveh and
			a.estatus='A' and b.sercarveh<>'0'
			and a.id_asignacion=b.id_asignacion and a.id_banco=x.id_banco ";
			if ($fechaD) $sql.=" and a.fecha_estatus>='".$fechaD."'  ";
			if ($fechaH) $sql.=" and a.fecha_estatus<='".$fechaH."'  ";
			if ($cond) $sql.=" and a.condpago='".$cond."'  ";
			if ($status) $sql.=" and a.id_estatus='".$status."'  ";
			if ($lote) $sql.=" and j.numlotveh='".$lote."'  ";
$sql.="
			) as tiggo,
			(
			select
			count(a.id_asignacion) as cantidad
			from
			asignacion  b, vehiculo i
			left outer join placas h  on h.sercarveh=i.sercarveh,
			caracteristica j
			left outer join marcas k on k.codmar=j.codmarveh
			left outer join modelo l  on l.codmod=j.codmod
			left outer join serie m  on m.codserie=j.codserie,
			facturaprof a
			left outer join estatus e on e.id_estatus=a.id_estatus,
			lote n
			where
			l.codmod='TG4' and
			j.numlotveh=n.numlot and
			i.id_caract=j.id_caract and
			b.sercarveh=i.sercarveh and
			a.estatus='A' and b.sercarveh<>'0'
			and a.id_asignacion=b.id_asignacion and a.id_banco=x.id_banco ";
			if ($fechaD) $sql.=" and a.fecha_estatus>='".$fechaD."'  ";
			if ($fechaH) $sql.=" and a.fecha_estatus<='".$fechaH."'  ";
			if ($cond) $sql.=" and a.condpago='".$cond."'  ";
			if ($status) $sql.=" and a.id_estatus='".$status."'  ";
			if ($lote) $sql.=" and j.numlotveh='".$lote."'  ";
$sql.="
			) as gra42,
			(
			select
			count(a.id_asignacion) as cantidad
			from
			asignacion  b, vehiculo i
			left outer join placas h  on h.sercarveh=i.sercarveh,
			caracteristica j
			left outer join marcas k on k.codmar=j.codmarveh
			left outer join modelo l  on l.codmod=j.codmod
			left outer join serie m  on m.codserie=j.codserie,
			facturaprof a
			left outer join estatus e on e.id_estatus=a.id_estatus,
			lote n
			where
			l.codmod='T44' and
			j.numlotveh=n.numlot and
			i.id_caract=j.id_caract and
			b.sercarveh=i.sercarveh and
			a.estatus='A' and b.sercarveh<>'0'
			and a.id_asignacion=b.id_asignacion and a.id_banco=x.id_banco ";
			if ($fechaD) $sql.=" and a.fecha_estatus>='".$fechaD."'  ";
			if ($fechaH) $sql.=" and a.fecha_estatus<='".$fechaH."'  ";
			if ($cond) $sql.=" and a.condpago='".$cond."'  ";
			if ($status) $sql.=" and a.id_estatus='".$status."'  ";
			if ($lote) $sql.=" and j.numlotveh='".$lote."'  ";
$sql.="
			) as gra44
			from
			banco x
			where x.tipo='1' ";
	//	print '<pre>';print $sql;exit;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
   return $consulta;
}
function listaPagospersonas($offset=null,$banco,$codpro,$nombre,$fecP,$fec2R){
/*
 * , a.id_banco, a.status, a.fec_reg
 *
 * ,
		b.id_banco,
		a.status,
		a.fec_reg
 * , b.id_banco, a.status, a.fec_reg */



	$sql.="select a.id_asignacion,a.nom,a.cedula,a.monto,a.desmod, a.banco
		from (select
		a.id_asignacion,
		c.nomcomp as nom,
		c.codpro as cedula,
		sum(a.monto) as monto,
		g.desmod as desmod,
		h.banco_descrip as banco
		from pago a , facturaprof b, propietarios c, asignacion d, preinventario e, modelo g, banco h
		where
		a.id_asignacion=b.id_asignacion
		and b.id_banco=h.id_banco
		and b.estatus='A'
		and a.status='A'
		and b.id_asignacion=d.id_asignacion
		and d.codpro=c.codpro
		and d.id_preinv=e.id_preinv
		and e.id_modelo=g.codmod";

//		if (($banco) or ($codpro) or ($nombre) OR ($fecP) OR ($fec2R)) $sql = $sql." where a.status='A'";
		if($banco) $sql = $sql." and h.id_banco='".$banco."' ";
	    if($codpro) $sql = $sql." and c.codpro like '%".$codpro."%'";
	    if($nombre) $sql = $sql." and c.nomcomp like '%".$nombre."%'";

	    if($fecP AND !$fec2R) $sql.= " and a.fec_reg >= '".$fecP."'";
	    else if (!$fecP AND  $fec2R) $sql.= " and a.fec_reg <= '".$fec2R."'";
	    else if ($fecP  AND  $fec2R) $sql.= " and a.fec_reg BETWEEN '".$fecP."' AND '".$fec2R."'";

		$sql.= " group by a.id_asignacion, c.nomcomp, g.desmod, c.codpro, h.banco_descrip";

$sql.= " union all
		select
		a.id_asignacion,
		c.nomcomp as nom,
		c.codpro as cedula,
		sum(a.monto) as monto ,
		g.desmod as desmod,
		h.banco_descrip as banco
		from pago a , facturaprof b, propietarios c, asignacion d, vehiculo e, caracteristica f, modelo g, banco h
		where
		a.id_asignacion=b.id_asignacion
		and b.id_banco=h.id_banco
		and b.estatus='A'
		and a.status='A'
		and b.id_asignacion=d.id_asignacion
		and d.codpro=c.codpro
		and d.sercarveh=e.sercarveh
		and e.id_caract=f.id_caract
		and f.codmod=g.codmod and (f.numlotveh='14' or f.numlotveh='15' or f.numlotveh='16' or f.numlotveh='17')";

		if($banco) $sql = $sql." and h.id_banco='".$banco."' ";
	    if($codpro) $sql = $sql." and c.codpro like '%".$codpro."%'";
	    if($nombre) $sql = $sql." and c.nomcomp like '%".$nombre."%'";

	    if($fecP AND !$fec2R) $sql.= " and a.fec_reg >= '".$fecP."'";
	    else if (!$fecP AND  $fec2R) $sql.= " and a.fec_reg <= '".$fec2R."'";
	    else if ($fecP  AND  $fec2R) $sql.= " and a.fec_reg BETWEEN '".$fecP."' AND '".$fec2R."'";

		$sql.= " group by a.id_asignacion, c.nomcomp, g.desmod, c.codpro, h.banco_descrip) a  ";  /*,
		b.id_banco,
		a.status,
		a.fec_reg
		--, b.id_banco, a.status, a.fec_reg */
		/*if (($banco) or ($codpro) or ($nombre) OR ($fecP) OR ($fec2R)) $sql = $sql." where a.status='A'";
		if($banco) $sql = $sql." and a.id_banco='".$banco."' ";
	    if($codpro) $sql = $sql." and a.cedula like '%".$codpro."%'";
	    if($nombre) $sql = $sql." and a.nom like '%".$nombre."%'";

	    if($fecP AND !$fec2R) $sql.= " and a.fec_reg >= '".$fecP."'";
	    else if (!$fecP AND  $fec2R) $sql.= " and a.fec_reg <= '".$fec2R."'";
	    else if ($fecP  AND  $fec2R) $sql.= " and a.fec_reg BETWEEN '".$fecP."' AND '".$fec2R."'";*/

		if($offset>=0) $sql = $sql." LIMIT 38 OFFSET ".$offset;

//echo '<br>'.$sql;
		$conexion= $this->conectar();
  		$consulta = $this->consultar($conexion,$sql);
  		$consulta = $this->ret_vector($consulta);
        return $consulta;

}

function listaPago($offset,$num_pag,$num_cuen,$fecP,$fec2P,$fecReg,$fec2Reg,$banco,$codpro,$nombre,$tipo=null,$lote,$bancoC,$condP,$idpago){

 //   if(!$tipo) $tipo='A';

	$sql.="select  a.id_asignacion,a.nom,a.monto,a.desmod,to_char(a.FEC_REG,'dd/mm/yyyy'),a.nro_pago,a.nro_cuenta,a.banco_descrip,
		to_char(a.fec_pago,'dd/mm/yyyy'),a.codpro, a.status, a.descripcion, a.bancocred, a.condpago,a.id_pago
		from (select
		a.id_asignacion,
		c.nomcomp as nom,
		a.monto,
		g.desmod,
		a.FEC_REG,
		nro_pago,
		a.nro_cuenta,
		h.banco_descrip ,
		a.fec_pago,
		c.codpro,
		a.status,
		i.descripcion,
		desbanco(b.id_banco) as bancocred,
		b.condpago,id_pago
	from
		pago a ,
		facturaprof b,
		propietarios c,
		asignacion d,
		vehiculo e,
		caracteristica f,
		modelo g,
		banco h,
		estatus i
	where
		a.id_asignacion=b.id_asignacion and b.condpago<>'COMPLETO' ";

	    if ($tipo<>'E') $sql.= " and b.estatus='A'";

		//if ($tipo=='E') $sql.= " and a.status='$tipo'";
		if ($tipo=='E') $sql.= " and a.status='$tipo' and ((b.estatus='E') or (b.estatus='A'))";


		$sql.= " and b.id_asignacion=d.id_asignacion
		and d.codpro=c.codpro
		and d.sercarveh=e.sercarveh
		and e.id_caract=f.id_caract
		and f.codmod=g.codmod
		and a.id_banco=h.id_banco and i.id_estatus=b.id_estatus";
		//and f.numlotveh='14'";

		if ($lote) $sql.= " and f.numlotveh=$lote";
		//$sql.= " and e.numlotveh='14'";

       // if (($num_pag) or ($num_cuen) or ($fecP) or ($fec2P) or ($fecR) or ($fec2R) or ($banco) or ($codpro) or ($nombre)) $sql = $sql." where a.status='A'";
		if($num_pag) $sql = $sql." and a.nro_pago='".$num_pag."'";
		if($num_cuen) $sql = $sql." and a.nro_cuenta='".$num_cuen."'";

		if($fecP AND !$fec2P) $sql.= " and a.fec_pago >= '".$fecP."'";
	    else if (!$fecP AND  $fec2P) $sql.= " and a.fec_pago <= '".$fec2P."'";
	    else if ($fecP  AND  $fec2P)	$sql.= " and a.fec_pago BETWEEN '".$fecP."' AND '".$fec2P."'";

		if($fecReg AND !$fec2Reg) $sql.= " and a.FEC_REG >= '".$fecReg."'";
	    else if (!$fecReg AND  $fec2Reg) $sql.= " and a.FEC_REG <= '".$fec2Reg."'";
	    else if ($fecReg  AND  $fec2Reg)	$sql.= " and a.FEC_REG BETWEEN '".$fecReg."' AND '".$fec2Reg."'";

	    if($banco) $sql = $sql." and a.id_banco=h.id_banco and h.banco_descrip like '%".$banco."%'";
	    if($codpro) $sql = $sql." and a.codpro like '%".$codpro."%'";
	    if($nombre) $sql = $sql." and a.nom like '%".$nombre."%'";

	    if($bancoC) $sql = $sql." and b.id_banco='".$bancoC."'";
	    if($condP) $sql = $sql." and b.condpago='".$condP."'";
	    if($idpago) $sql = $sql." and a.id_pago='".$idpago."'";

	$sql.= " union all
	select
		a.id_asignacion,
		c.nomcomp as nom,
		a.monto,
		g.desmod,
		a.FEC_REG,
		nro_pago,
		a.nro_cuenta,
		f.banco_descrip ,
		a.fec_pago,
		c.codpro,
		a.status,
		i.descripcion,
		desbanco(b.id_banco) as bancocred,
		b.condpago,a.id_pago
	from
		pago a ,
		facturaprof b,
		propietarios c,
		asignacion d,
		preinventario e,
		banco f,
		modelo g,
		estatus i
	where
		a.id_asignacion=b.id_asignacion and b.condpago<>'COMPLETO' ";

        if ($tipo<>'E') $sql.= " and b.estatus='A'";

		if ($tipo=='E') $sql.= " and a.status='$tipo' and ((b.estatus='E') or (b.estatus='A'))";

		$sql.= " and b.id_asignacion=d.id_asignacion
		and d.codpro=c.codpro
		and d.id_preinv=e.id_preinv
		and e.id_modelo=g.codmod
		and a.id_banco=f.id_banco and i.id_estatus=b.id_estatus ";

        if ($lote) $sql.= " and e.numlotveh=$lote";

	//	if (($num_pag) or ($num_cuen) or ($fecP) or ($fec2P) or ($fecR) or ($fec2R) or ($banco) or ($codpro) or ($nombre)) $sql = $sql." where a.status='A'";
		if($num_pag) $sql = $sql." and a.nro_pago='".$num_pag."'";
		if($num_cuen) $sql = $sql." and a.nro_cuenta='".$num_cuen."'";

		if($fecP AND !$fec2P) $sql1.= " and a.fec_pago >= '".$fecP."'";
	    else if (!$fecP AND  $fec2P) $sql1.= " and a.fec_pago <= '".$fec2P."'";
	    else if ($fecP  AND  $fec2P)	$sql1.= " and a.fec_pago BETWEEN '".$fecP."' AND '".$fec2P."'";

		if($fecReg AND !$fec2Reg) $sql1.= " and a.FEC_REG >= '".$fecReg."'";
	    else if (!$fecReg AND  $fec2Reg) $sql1.= " and a.FEC_REG <= '".$fec2Reg."'";
	    else if ($fecReg  AND  $fec2Reg)	$sql1.= " and a.FEC_REG BETWEEN '".$fecReg."' AND '".$fec2Reg."'";

	    if($banco) $sql = $sql." and a.id_banco=f.id_banco and f.banco_descrip like '%".$banco."%'";
	    if($codpro) $sql = $sql." and a.codpro like '%".$codpro."%'";
	    if($nombre) $sql = $sql." and a.nom like '%".$nombre."%'";

		if($bancoC) $sql = $sql." and b.id_banco='".$bancoC."'";
		if($condP) $sql = $sql." and b.condpago='".$condP."'";
		if($idpago) $sql = $sql." and a.id_pago='".$idpago."'";

       $sql.= ") a  ";
		if($offset>=0) $sql = $sql." LIMIT 38 OFFSET ".$offset;

//echo "<br>".$sql;
		$conexion= $this->conectar();
  		$consulta = $this->consultar($conexion,$sql);
  		$consulta = $this->ret_vector($consulta);
        return $consulta;

}

function cuadroIniConsignadas($lote=null,$desde=null,$hasta=null,$marca=null,$modelo=null,$banco=null){

$sql ="select count(a.contar), sum(a.monto), a.banco  from (
	select a.id_asignacion, c.nomcomp as contar, sum(a.monto) as monto , f.banco_descrip as banco
	from pago a , facturaprof b, propietarios c, asignacion d, preinventario e, modelo g, banco f
	where
		a.id_asignacion=b.id_asignacion
		and b.id_banco=f.id_banco
		and b.estatus='A'
		and a.status='A'
		and b.id_asignacion=d.id_asignacion
		and d.codpro=c.codpro
		and d.id_preinv=e.id_preinv
		and e.id_modelo=g.codmod";

    if($desde AND !$hasta) $sql.= " and b.fecha_estatus >= '".$desde."'";
	else if (!$desde AND  $hasta) $sql.= " and b.fecha_estatus <= '".$hasta."'";
	else if ($desde  AND  $hasta)	$sql.= " and b.fecha_estatus BETWEEN '".$desde."' AND '".$hasta."'";

	if($marca) $sql .= " and e.id_marca='".$marca."'";
	if($modelo) $sql .= " and g.codmod='".$modelo."'";
	if($banco) $sql .= " and b.id_banco='".$banco."'";


  $sql.=" group by a.id_asignacion, c.nomcomp, f.banco_descrip
	union all
	select a.id_asignacion, c.nomcomp as contar, sum(a.monto) as monto , h.banco_descrip as banco
	from pago a , facturaprof b, propietarios c, asignacion d, vehiculo e, caracteristica f, modelo g, banco h
	where
		a.id_asignacion=b.id_asignacion
		and b.id_banco=h.id_banco
		and b.estatus='A'
		and a.status='A'
		and b.id_asignacion=d.id_asignacion
		and d.codpro=c.codpro
		and d.sercarveh=e.sercarveh
		and e.id_caract=f.id_caract
		and f.codmod=g.codmod";

	if ($lote)	$sql.= " and f.numlotveh='".$lote."'";

    if($desde AND !$hasta) $sql.= " and b.fecha_estatus >= '".$desde."'";
	else if (!$desde AND  $hasta) $sql.= " and b.fecha_estatus <= '".$hasta."'";
	else if ($desde  AND  $hasta)	$sql.= " and b.fecha_estatus BETWEEN '".$desde."' AND '".$hasta."'";


	if($marca) $sql .= " and f.codmarveh='".$marca."'";
	if($modelo) $sql .= " and g.codmod='".$modelo."'";
	if($banco) $sql .= " and b.id_banco='".$banco."'";

 $sql.= " group by a.id_asignacion, c.nomcomp, h.banco_descrip) a group by a.banco";

 //echo '<pre>'.$sql;

		$conexion= $this->conectar();
  		$consulta = $this->consultar($conexion,$sql);
  		$consulta = $this->ret_vector($consulta);
		return $consulta;
}

//MATRIZ VEHICULOS CHERY POR ESTADO

function matrizVehxEstado($lote=null,$estado=null){

$sql = "SELECT e.nomest,
(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
 propietarios f, lote g, zona_estado e
 WHERE g.numlot=$lote AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
 AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
 and f.codest='".$estado."' and c.codmod='QQ3' AND e.codest = f.codest group by c.codmod) as QQ3,
(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
 propietarios f, lote g, zona_estado e
 WHERE g.numlot=$lote AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
 AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
 and f.codest='".$estado."' and c.codmod='X1' AND e.codest = f.codest group by c.codmod) as X1,
(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
 propietarios f, lote g, zona_estado e
 WHERE g.numlot=$lote AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
 AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
 and f.codest='".$estado."' and c.codmod='TIG' AND e.codest = f.codest group by c.codmod) as TIGGO,
(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
 propietarios f, lote g, zona_estado e
 WHERE g.numlot=$lote AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
 AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
 and f.codest='".$estado."' and c.codmod='TG4' AND e.codest = f.codest group by c.codmod) as T42,
(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
 propietarios f, lote g, zona_estado e
 WHERE g.numlot=$lote AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
 AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
 and f.codest='".$estado."' and c.codmod='T44' AND e.codest = f.codest group by c.codmod) as T44
FROM zona_estado e
WHERE e.codest='".$estado."'";

//echo "<br>VehxEst ".$sql;
		$conexion= $this->conectar();
  		$consulta = $this->consultar($conexion,$sql);
  		$consulta = $this->ret_vector($consulta);
		return $consulta;
}


function matrizVehsinEstado($lote=null){

$sql = "SELECT 'SIN ESTADO',
(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
 propietarios f, lote g
 WHERE g.numlot=$lote AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
 AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
 and c.codmod='QQ3' AND (f.codest is null or f.codest='') group by c.codmod) as QQ3,
(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
 propietarios f, lote g
 WHERE g.numlot=$lote AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
 AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
 and c.codmod='X1' AND (f.codest is null or f.codest='') group by c.codmod) as X1,
(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
 propietarios f, lote g
 WHERE g.numlot=$lote AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
 AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
 and c.codmod='TIG' AND (f.codest is null or f.codest='') group by c.codmod) as TIGGO,
(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
 propietarios f, lote g
 WHERE g.numlot=$lote AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
 AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
 and c.codmod='TG4' AND (f.codest is null or f.codest='') group by c.codmod) as T42,
(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
 propietarios f, lote g
 WHERE g.numlot=$lote AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
 AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
 and c.codmod='T44' AND (f.codest is null or f.codest='') group by c.codmod) as T44
FROM lote g
WHERE g.numlot=$lote";

//echo "<br>VehxEst ".$sql;
		$conexion= $this->conectar();
  		$consulta = $this->consultar($conexion,$sql);
  		$consulta = $this->ret_vector($consulta);
		return $consulta;
}

function resumenBancoliqui($marca=null,$fechaF=null,$fechaD=null,$fechaH=null,$modelo=null,$lote=null,$banco=null){
	$i=0;
 	$j=0;
 	$matriz = NULL;
 	/*if($dist) $idDist = $dist;
 	else $idDist = $_SESSION['distOrg'];*/
    $conexion = $this->conectar();

 	 $sql = "select d.desmar as marca,e.desmod as modelo,count(b.sercarveh) as cantidad,e.codmod
                 from vehiculo b
     inner join caracteristica c on b.id_caract=c.id_caract
     inner join marcas d on c.codmarveh=d.codmar
     inner join modelo e on c.codmod=e.codmod
     inner join lote f on c.numlotveh=f.numlot where f.numdep='1'";

     if ($marca) $sql.= " and d.codmar = '".$marca."'";
   	 if ($modelo) $sql.= " and e.codmod = '".$modelo."'";
     $sql.= " and c.numlotveh = '".$lote."'";

$sql.= " group by d.desmar,e.desmod,e.codmod
order by d.desmar,e.desmod";

//        print "1".$sql;
	/*if ($_SESSION['tipoUsuario']<>'10' or $dist) {
  			if ($_SESSION['tipoUsuario']=='2' and !$dist) $sql.=" and d.origen = '".$_SESSION['idDist']."'";
  			else $sql.=" and a.id_distribuidor = '".$idDist."'";
  		}

	 if ($ban) $sql.=" and a.id_banco = '".$ban."'";*/

    $consulta = $this->consultar($conexion,$sql);
    $filas = pg_num_rows($consulta);

    while ($data=pg_fetch_array($consulta))
	{
    	 $matriz[$i][0] = $data[0];
    	 $matriz[$i][1] = $data[1];
    	 $matriz[$i][2] = $data[2];

    	$ntime = substr(microtime(),2,6);

		$sqlT ="select distinct(id_estatus),max(fecha) as fecha, id_numfac INTO TEMPORARY movi_proformat".$ntime." from movi_proforma" .
				" GROUP BY id_estatus, id_numfac order by id_numfac, id_estatus";

       	$conexionT = $this->conectar();
  		$consultaT = $this->consultar($conexionT,$sqlT);

  	    //Crédito Liquidado

 		$sql15= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql15 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '14' and f.estatus='A'";
		if ($marca) $sql15.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql15.= " and e.codmod = '".$modelo."'";
   		$sql15.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql15.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql15.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql15.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql15.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
		if ($banco) $sql15.= " and f.id_banco = '".$banco."'";
   	  //  print "<br>16".$sql15;

		$conexion15 = $this->conectar();
  		$consulta15 = $this->consultar($conexion15,$sql15);
  		$consulta15 = $this->ret_vector($consulta15);

         if($consulta15) $matriz[$i][17] = $consulta15[0];
 		 else $matriz[$i][17] = 0;


	   //Vehículo Entregado

 		$sql16= "select count(f.sercarveh) as cant from vehiculo b
     				inner join caracteristica c on b.id_caract=c.id_caract
     				inner join marcas d on c.codmarveh=d.codmar
     				inner join modelo e on c.codmod=e.codmod
					inner join facturaprof f on b.sercarveh=f.sercarveh
					inner join movi_proformat".$ntime." z on f.id_numfac=z.id_numfac
				    inner join lote g on c.numlotveh=g.numlot where g.numdep='1'";

 		$sql16 .= " and e.codmod = '".$data[3]."'  and  z.id_estatus = '15' and f.estatus='A'";
		if ($marca) $sql16.= " and d.codmar = '".$marca."'";
   		if ($modelo) $sql16.= " and e.codmod = '".$modelo."'";
   		$sql16.= " and c.numlotveh = '".$lote."'";
   		if ($fechaF) $sql16.= " and f.fecfac = '".$fechaF."'";
 		if($fechaD AND !$fechaH) $sql16.= " and z.fecha >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql16.= " and z.fecha <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql16.= " and z.fecha BETWEEN '".$fechaD."' AND '".$fechaH."'";
	    if ($banco) $sql16.= " and f.id_banco = '".$banco."'";
        $sql16.= " and (condpago = 'CREDITO' OR condpago = 'COMPLETO')";
        //print "<br>17".$sql16;

		$conexion16 = $this->conectar();
  		$consulta16 = $this->consultar($conexion16,$sql16);
  		$consulta16 = $this->ret_vector($consulta16);

         if($consulta16) $matriz[$i][18] = $consulta16[0];
 		 else $matriz[$i][18] = 0;





 		$i++;
	//}
	$this->desconectar($conexion);
   }

   return $matriz;
}



function resumenFacturasOriginales($codpro=null,$nombre=null,$marca=null,$fechaD=null,$fechaH=null,$modelo=null,$lote=null,$banco=null,$factura=null,$usuario=null,$offset=null){

    	$ntime = substr(microtime(),2,6);

		$sqlT ="select distinct(id_estatus),max(fecha) as fecha, id_numfac, usuario_estatus INTO TEMPORARY movi_proformat".$ntime." from movi_proforma" .
				" WHERE id_estatus=7 GROUP BY id_estatus, id_numfac, usuario_estatus order by id_numfac, id_estatus";

  		//print "<br>".$sqlT;
       	$conexionT = $this->conectar();
  		$consultaT = $this->consultar($conexionT,$sqlT);

  		//echo "<br>consultaT: ".$consultaT;

  		if ($consultaT){
  			$sql = "SELECT g.id_estatus,g.usuario_estatus,to_char(g.fecha,'dd/mm/yyyy'),b.facori,to_char(b.fecfacori,'dd/mm/yyyy'),h.codpro,h.nomcomp,
  				h.tlfcelpro, h.tlfcel2pro,a.numlotveh, c.desmar,d.desmod, f.sercarveh,i.nombre1,i.apellido1,desbanco(b.id_banco)
				FROM caracteristica a,facturaprof b,marcas c,modelo d,asignacion e,vehiculo f,movi_proformat".$ntime." g,propietarios h,usuarios i
				WHERE a.id_caract = f.id_caract AND b.id_numfac = g.id_numfac AND c.codmar = a.codmarveh AND d.codmod = a.codmod AND e.id_asignacion = b.id_asignacion AND
				f.sercarveh = e.sercarveh AND h.codpro = e.codpro and g.usuario_estatus = i.usuario AND g.id_estatus=7 and b.estatus='A'";


        if($codpro) $sql.= " and h.codpro like '%".$codpro."%'";
	    if($nombre) $sql.= " and h.nomcomp like '%".$nombre."%'";
	    if ($marca) $sql.= " and c.codmar = '".$marca."'";

		if($fechaD AND !$fechaH) $sql.= " and b.fecfacori >= '".$fechaD."'";
	    else if (!$fechaD AND  $fechaH) $sql.= " and b.fecfacori <= '".$fechaH."'";
	    else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecfacori BETWEEN '".$fechaD."' AND '".$fechaH."'";

        if ($modelo) $sql.= " and d.codmod = '".$modelo."'";
        if ($lote) $sql.= " and a.numlotveh=$lote";
		if ($banco) $sql .= " and b.id_banco='".$banco."'";
		if ($factura) $sql .= " and b.facori='".$factura."'";
		if ($usuario)  $sql.=" and g.usuario_estatus='".$usuario."'";


		$sql.= " order by h.codpro,e.sercarveh";

		if($offset>=0) $sql = $sql." LIMIT 45 OFFSET ".$offset;

   	   // print "<br>".$sql;

		$conexion = $this->conectar();
  		$consulta = $this->consultar($conexion,$sql);
  		$consulta = $this->ret_vector($consulta);

  	//	echo "<br>consulta: ".$consulta;
  		}

   return $consulta;
}


function resumenEstatusCred($fechaD=null,$fechaH=null,$ban=null,$status=null,$lote=null){
	$i=0;
 	$j=0;
 	//$matriz = NULL;

	$banco[0] = "0003";
    $banco[1] = "0102";
    $banco[2] = "0163";
    $banco[3] = "0175";
    $banco[4] = "0602";
    $banco[5] = "0149";

    $estatus[0]="4"; //Aprobado
    $estatus[1]="16"; //Negado
    $estatus[2]="17";//Diferido
    $estatus[3]="3";//A la Espera de Documentos
    $estatus[4]="30";//Devuelto por Documentacion Incompleta
    $estatus[5]="31";//Imposible verificar constancia
    $estatus[6]="32";//Devuelto por cambio de Garantia
    $estatus[7]="33";//Cambio de Garantia Procesada
    $estatus[8]="2";//Crédito en Análisis Bancario

	for($i=0;$i<count($banco);$i+=1){
		//echo "<br>Banco: ".$banco[$i];

		for($j=0;$j<count($estatus);$j+=1){

            $sql = "SELECT sum(a.cantidad) from (";
			$sql .= "SELECT count(c.id_banco) as cantidad,c.estatus,b.descripcion,c.fecha_estatus
			FROM banco a,estatus b,credito c
			WHERE  a.id_banco = c.id_banco AND b.id_estatus = c.estatus AND c.id_banco='".$banco[$i]."' AND c.estatus='".$estatus[$j]."'";

			if($fechaD AND !$fechaH) $sql.= " and c.fecha_estatus >= '".$fechaD."'";
			else if (!$fechaD AND  $fechaH) $sql.= " and c.fecha_estatus <= '".$fechaH."'";
			else if ($fechaD  AND  $fechaH)	$sql.= " and c.fecha_estatus BETWEEN '".$fechaD."' AND '".$fechaH."'";

		    if ($ban) $sql .= " and c.id_banco='".$ban."'";
		    if ($status) $sql .= " and c.estatus='".$status."'";
			//if ($lote) $sql.= " and a.numlotveh=$lote";   de donde me traigo el lote si en ninguna parte registro el tipo de vehiculo solicitado


			$sql.= " GROUP BY c.id_banco,c.estatus,b.descripcion,c.fecha_estatus) a";

  //print '<br>'.$sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);

  if (!$consulta[0]) $consulta[0]=0;
  $matriz[$i][$j]=$consulta[0];

  $this->desconectar($conexion);
		}
	}
  return $matriz;
}


function diagnosticoCreditos(){
	$sql="
			SELECT
			y.id_banco, y.banco_descrip,
			(select
			count(a.codpro) from
			propietarios a
			where
			a.status='A' and a.fecha_reg>'2012-07-25' and a.id_banco=y.id_banco) as bene,
			(SELECT count(c.id_banco) as cantidad
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=2
			GROUP BY c.id_banco) as Analisis,
			(SELECT count(c.id_banco) as cantidad
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=4
			GROUP BY c.id_banco) as Aprobados,
			(SELECT count(c.id_banco) as cantidad
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=16
			GROUP BY c.id_banco) as Negado,
			(SELECT count(c.id_banco) as cantidad
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=17
			GROUP BY c.id_banco) as Diferido,
			(SELECT count(c.id_banco) as cantidad
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=3
			GROUP BY c.id_banco) as Espera_Documento,
			(SELECT count(c.id_banco) as cantidad
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=30
			GROUP BY c.id_banco) as Devuelto_Doc_Inc,
			(SELECT count(c.id_banco) as cantidad
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=31
			GROUP BY c.id_banco) as Imposible_Verificar_Const,
			(
			select count(e.id_banco)
			from asignacion a, vehiculo b,caracteristica d, facturaprof e
			where a.status='A' and d.codmod is not null AND
			a.sercarveh=b.sercarveh and d.codmarveh='C7' and
			d.id_caract=b.id_caract and e.estatus='A'and
			a.id_asignacion=e.id_asignacion and e.id_estatus=15 and e.id_banco=y.id_banco
			group by e.id_banco) as entregados,
			(
			select count(e.id_banco)
			from asignacion a, vehiculo b,caracteristica d, facturaprof e
			where a.status='A' and d.codmod is not null AND
			a.sercarveh=b.sercarveh and d.codmarveh='C7' and
			d.id_caract=b.id_caract and e.estatus='A'and
			a.id_asignacion=e.id_asignacion and e.id_estatus=14 and e.id_banco=y.id_banco
			group by e.id_banco) as liquidadosAct,
			(
			select count(e.id_banco)
			from asignacion a, vehiculo b,caracteristica d, facturaprof e
			where a.status='A' and d.codmod is not null AND
			a.sercarveh=b.sercarveh and d.codmarveh='C7' and
			d.id_caract=b.id_caract and e.estatus='A'and
			a.id_asignacion=e.id_asignacion and e.id_estatus=6 and e.id_banco=y.id_banco
			group by e.id_banco) as inicialConsignada,
			(
			select count(e.id_banco)
			from asignacion a, vehiculo b,caracteristica d, facturaprof e
			where a.status='A' and d.codmod is not null AND
			a.sercarveh=b.sercarveh and d.codmarveh='C7' and
			d.id_caract=b.id_caract and e.estatus='A'and
			a.id_asignacion=e.id_asignacion and e.id_estatus=7 and e.id_banco=y.id_banco
			group by e.id_banco) as facturaOriginal,
			(
			select count(e.id_banco)
			from asignacion a, vehiculo b,caracteristica d, facturaprof e
			where a.status='A' and d.codmod is not null AND
			a.sercarveh=b.sercarveh and d.codmarveh='C7' and
			d.id_caract=b.id_caract and e.estatus='A'and
			a.id_asignacion=e.id_asignacion and e.id_estatus=8 and e.id_banco=y.id_banco
			group by e.id_banco) as certificado,
			(
			select count(e.id_banco)
			from asignacion a, vehiculo b,caracteristica d, facturaprof e
			where a.status='A' and d.codmod is not null AND
			a.sercarveh=b.sercarveh and d.codmarveh='C7' and
			d.id_caract=b.id_caract and e.estatus='A'and
			a.id_asignacion=e.id_asignacion and (e.id_estatus=5 or e.id_estatus=1 or e.id_estatus=25 or e.id_estatus=26 or e.id_estatus=27 or e.id_estatus=28) and e.id_banco=y.id_banco
			group by e.id_banco) as varios
			FROM
			banco y
			WHERE
			y.status = 'A' and  (y.tipo='1' or y.tipo='2') order by y.id_banco ";
//print '<pre>'.$sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;

}


function diagnosticoCreditos2(){
	$sql="
			SELECT
			y.id_banco, y.banco_descrip,
			(select
			count(a.codpro) from
			propietarios a
			where
			a.status='A' and a.fecha_reg>'2012-07-25' and a.id_banco=y.id_banco) as bene,
			(select count(z.codpro) from (
			SELECT c.codpro
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=2
			except
			SELECT d.codpro
			FROM asignacion d, credito c
			where d.codpro=c.codpro and c.estatus=2 and c.id_banco=y.id_banco and d.status='A' ) z) as AnaSinAsig,
			(SELECT count(c.id_banco) as cantidad
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=4
			GROUP BY c.id_banco) as Aprobados,
			(select count(z.codpro) from (
			SELECT c.codpro
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=16
			except
			SELECT d.codpro
			FROM asignacion d, credito c
			where d.codpro=c.codpro and c.estatus=16 and c.id_banco=y.id_banco and d.status='A' ) z) as NegadosSinAsig,
			(select count(z.codpro) from (
			SELECT c.codpro
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=17
			except
			SELECT d.codpro
			FROM asignacion d, credito c
			where d.codpro=c.codpro and c.estatus=17 and c.id_banco=y.id_banco and d.status='A' ) z) as DiferidoSinAsig,
			(SELECT count(c.id_banco) as cantidad
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=3
			GROUP BY c.id_banco) as Espera_Documento,
			(SELECT count(c.id_banco) as cantidad
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=30
			GROUP BY c.id_banco) as Devuelto_Doc_Inc,
			(SELECT count(c.id_banco) as cantidad
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=31
			GROUP BY c.id_banco) as Imposible_Verificar_Const,
			(
			select count(e.id_banco)
			from asignacion a, vehiculo b,caracteristica d, facturaprof e
			where a.status='A' and d.codmod is not null AND
			a.sercarveh=b.sercarveh and d.codmarveh='C7' and
			d.id_caract=b.id_caract and e.estatus='A'and
			a.id_asignacion=e.id_asignacion and e.id_estatus=15 and e.id_banco=y.id_banco
			group by e.id_banco) as entregados,
			(
			select count(e.id_banco)
			from asignacion a, vehiculo b,caracteristica d, facturaprof e
			where a.status='A' and d.codmod is not null AND
			a.sercarveh=b.sercarveh and d.codmarveh='C7' and
			d.id_caract=b.id_caract and e.estatus='A'and
			a.id_asignacion=e.id_asignacion and e.id_estatus=14 and e.id_banco=y.id_banco
			group by e.id_banco) as liquidadosAct,
			(
			select count(e.id_banco)
			from asignacion a, vehiculo b,caracteristica d, facturaprof e
			where a.status='A' and d.codmod is not null AND
			a.sercarveh=b.sercarveh and d.codmarveh='C7' and
			d.id_caract=b.id_caract and e.estatus='A'and
			a.id_asignacion=e.id_asignacion and e.id_estatus=6 and e.id_banco=y.id_banco
			group by e.id_banco) as inicialConsignada,
			(
			select count(e.id_banco)
			from asignacion a, vehiculo b,caracteristica d, facturaprof e
			where a.status='A' and d.codmod is not null AND
			a.sercarveh=b.sercarveh and d.codmarveh='C7' and
			d.id_caract=b.id_caract and e.estatus='A'and
			a.id_asignacion=e.id_asignacion and e.id_estatus=7 and e.id_banco=y.id_banco
			group by e.id_banco) as facturaOriginal,
			(
			select count(e.id_banco)
			from asignacion a, vehiculo b,caracteristica d, facturaprof e
			where a.status='A' and d.codmod is not null AND
			a.sercarveh=b.sercarveh and d.codmarveh='C7' and
			d.id_caract=b.id_caract and e.estatus='A'and
			a.id_asignacion=e.id_asignacion and e.id_estatus=8 and e.id_banco=y.id_banco
			group by e.id_banco) as certificado,
			(
			select count(e.id_banco)
			from asignacion a, vehiculo b,caracteristica d, facturaprof e
			where a.status='A' and d.codmod is not null AND
			a.sercarveh=b.sercarveh and d.codmarveh='C7' and
			d.id_caract=b.id_caract and e.estatus='A'and
			a.id_asignacion=e.id_asignacion and (e.id_estatus=5 or e.id_estatus=1 or e.id_estatus=25 or e.id_estatus=26 or e.id_estatus=27 or e.id_estatus=28) and e.id_banco=y.id_banco
			group by e.id_banco) as varios,
			(select count(z.codpro) from (
			SELECT c.codpro
			FROM banco a,estatus b,credito c
			WHERE a.id_banco = c.id_banco AND b.id_estatus = c.estatus  AND  c.id_banco=y.id_banco and c.estatus=4
			except
			SELECT d.codpro
			FROM asignacion d, credito c
			where d.codpro=c.codpro and c.estatus=4 and c.id_banco=y.id_banco and d.status='A' ) z) as AprobadosSinAsig
			FROM
			banco y
			WHERE
			y.status = 'A' and  (y.tipo='1' or y.tipo='2') order by y.id_banco ";
//print '<pre>'.$sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;

}


function estadisticas_agrupadas($banco){

  if($banco)
  $sql="select 'Desde que se envia el expediente al banco hasta que se entrega el vehículo' as tipo,
			c.banco_descrip,
			(min((b.fecha-a.fecha) + 1)) as min,
			round((avg((b.fecha-a.fecha) + 1)), 0) as pro,
			(max((b.fecha-a.fecha) + 1)) as max
			from
			(SELECT  b.fecha as fecha, a.codpro as codpro, b.id_banco
			FROM detmemoexp a, memoexp b, banco c
			WHERE a.id_memoexp=b.id_memoexp and a.status='A' and b.id_banco=c.id_banco) a,
			(SELECT  a.fecha_estatus as fecha, c.codpro as codpro, a.id_banco
			FROM facturaprof a
			INNER JOIN asignacion c ON a.id_asignacion=c.id_asignacion
			WHERE
			 a.estatus='A' and c.status='A'  and
			 a.condpago='CREDITO' and
			 a.id_banco  is not null and
			 a.id_estatus=15) b, banco c
			 where
			 a.codpro=b.codpro and c.id_banco=a.id_banco and c.id_banco=b.id_banco and c.tipo='1' and
			 b.fecha>a.fecha and a.fecha>'01/01/2012' and c.id_banco='".$banco."'
			 group by  c.banco_descrip
			union all
			--Desde que se envia el expediente al banco hasta que se actualiza el credito (aprueba, negado)
			select 'Desde que se envia el expediente al banco hasta que se actualiza el credito' as tipo,
			c.banco_descrip,
			(min((b.fecha-a.fecha) + 1)) as min,
			round((avg((b.fecha-a.fecha) + 1)), 0) as pro,
			(max((b.fecha-a.fecha) + 1)) as max
			from
			(SELECT  b.fecha as fecha, a.codpro as codpro, b.id_banco
			FROM detmemoexp a, memoexp b, banco c
			WHERE a.id_memoexp=b.id_memoexp and a.status='A' and b.id_banco=c.id_banco) a,
			(SELECT c.descripcion as estatusdes, a.fecha_estatus as fecha, b.id_banco, a.codpro as codpro
			FROM credito a, banco b, estatus c
			WHERE a.id_banco=b.id_banco and a.estatus=c.id_estatus) b, banco c
			 where
			 a.codpro=b.codpro and c.id_banco=a.id_banco and c.id_banco=b.id_banco and c.tipo='1' and
			 b.fecha>a.fecha and a.fecha>'01/01/2012' and c.id_banco='".$banco."'
			 group by  c.banco_descrip
			union all
			--Desde que se aprueba el crédito hasta que se emite el certificado
			select 'Desde que se aprueba el crédito hasta que se emite el certificado' as tipo,
			c.banco_descrip,
			(min((b.fecha-a.fecha) + 1)) as min,
			round((avg((b.fecha-a.fecha) + 1)), 0) as pro,
			(max((b.fecha-a.fecha) + 1)) as max
			from
			(SELECT c.descripcion as estatusdes, a.fecha_estatus as fecha, b.id_banco, a.codpro as codpro
			FROM credito a, banco b, estatus c
			WHERE a.id_banco=b.id_banco and a.estatus=c.id_estatus) a,
			(SELECT 'Certificado Emitido' as nombrestatus, b.fecha_reg as fecha, c.id_banco , a.codpro as codpro
			FROM certificados b
			INNER JOIN asignacion a ON a.id_asignacion=b.id_asignacion
			INNER JOIN facturaprof c ON a.id_asignacion=c.id_asignacion
			WHERE b.estatus='A' and a.status='A' and c.condpago='CREDITO' and  c.id_banco  is not null) b, banco c
			 where
			 a.codpro=b.codpro and c.id_banco=a.id_banco and c.id_banco=b.id_banco and c.tipo='1' and
			 b.fecha>a.fecha and a.fecha>'01/01/2012' and c.id_banco='".$banco."'
			 group by  c.banco_descrip
			union all
			 --Desde que se envia el certificado al banco hasta que se liquida el credito
			select 'Desde que se envia el certificado al banco hasta que se liquida el credito' as tipo,
			c.banco_descrip,
			(min((b.fecha-a.fecha) + 1)) as min,
			round((avg((b.fecha-a.fecha) + 1)), 0) as pro,
			(max((b.fecha-a.fecha) + 1)) as max
			from
			(SELECT 'Certificado enviado al banco ' as nombrestatus, c.fecha as fecha, c.id_banco, a.codpro as codpro
			FROM detmemocert e
			INNER JOIN certificados b
			INNER JOIN asignacion a ON a.id_asignacion=b.id_asignacion ON e.numcerveh=b.numcerveh
			INNER JOIN memocert c
			left outer join banco d ON c.id_banco=d.id_banco ON c.id_memocert=e.id_memocert
			WHERE b.estatus='A' and a.status='A' and e.status='A' and c.status='A') a,
			(
			SELECT 'Credito liquidado' as nombrestatus, max(x.fecha) as fecha,
			a.id_banco,c.codpro as codpro
			FROM movi_proforma x ,facturaprof a
			INNER JOIN asignacion c ON a.id_asignacion=c.id_asignacion
			WHERE
			 a.estatus='A' and c.status='A'  and
			 a.condpago='CREDITO' and
			 a.id_banco  is not null and
			 x.id_numfac=a.id_numfac and x.id_estatus=14
			GROUP BY a.id_banco, c.codpro) b, banco c
			 where
			 a.codpro=b.codpro and c.id_banco=a.id_banco and c.id_banco=b.id_banco and c.tipo='1' and
			 b.fecha>a.fecha and a.fecha>'01/01/2012' and c.id_banco='".$banco."'
			 group by  c.banco_descrip
			union all
			 --Desde que se liquida el credito hasta que se entrega el vehículo
			select 'Desde que se liquida el credito hasta que se entrega el vehículo ' as tipo,
			c.banco_descrip,
			(min((b.fecha-a.fecha) + 1)) as min,
			round((avg((b.fecha-a.fecha) + 1)), 0) as pro,
			(max((b.fecha-a.fecha) + 1)) as max
			from
			(
			SELECT 'Credito liquidado' as nombrestatus, max(x.fecha) as fecha,
			a.id_banco,c.codpro as codpro
			FROM movi_proforma x ,facturaprof a
			INNER JOIN asignacion c ON a.id_asignacion=c.id_asignacion
			WHERE
			 a.estatus='A' and c.status='A'  and
			 a.condpago='CREDITO' and
			 a.id_banco  is not null and
			 x.id_numfac=a.id_numfac and x.id_estatus=14
			GROUP BY a.id_banco, c.codpro) a,
			(
			SELECT 'Vehiculo entregado' as nombrestatus, a.fecha_estatus as fecha,
			a.id_banco,c.codpro as codpro
			FROM facturaprof a
			INNER JOIN asignacion c ON a.id_asignacion=c.id_asignacion
			WHERE
			 a.estatus='A' and c.status='A'  and
			 a.condpago='CREDITO' and
			 a.id_banco  is not null and
			 a.id_estatus=15) b, banco c
			 where
			 a.codpro=b.codpro and c.id_banco=a.id_banco and c.id_banco=b.id_banco and c.tipo='1' and
			 b.fecha>a.fecha and a.fecha>'01/01/2012' and c.id_banco='".$banco."'
			 group by  c.banco_descrip
  		";
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;

}


function estadisticas_prom_1(){



//--REPORTE 1 NOMBRE:
//--Desde que El promedio de tiempo desde que se envia el expediente al banco hasta que se entrega el vehÃ­culo
 $sql="select
c.banco_descrip,
(min((b.fecha-a.fecha) + 1)) as min,
round((avg((b.fecha-a.fecha) + 1)), 0) as pro,
(max((b.fecha-a.fecha) + 1)) as max
from
(SELECT  b.fecha as fecha, a.codpro as codpro, b.id_banco
FROM detmemoexp a, memoexp b, banco c
WHERE a.id_memoexp=b.id_memoexp and a.status='A' and b.id_banco=c.id_banco) a,
(SELECT  a.fecha_estatus as fecha, c.codpro as codpro, a.id_banco
FROM facturaprof a
INNER JOIN asignacion c ON a.id_asignacion=c.id_asignacion
WHERE
 a.estatus='A' and c.status='A'  and
 a.condpago='CREDITO' and
 a.id_banco  is not null and
 a.id_estatus=15) b, banco c
 where
 a.codpro=b.codpro and c.id_banco=a.id_banco and c.id_banco=b.id_banco and c.tipo='1' and
 b.fecha>a.fecha and a.fecha>'01/01/2012'
 group by  c.banco_descrip
  		";
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
}
function estadisticas_prom_2(){
/*--REPORTE 2 NOMBRE:
--Desde que se envia el expediente al banco hasta que se actualiza el credito (aprueba, negado)*/

 $sql="select
c.banco_descrip,
(min((b.fecha-a.fecha) + 1)) as min,
round((avg((b.fecha-a.fecha) + 1)), 0) as pro,
(max((b.fecha-a.fecha) + 1)) as max
from
(SELECT  b.fecha as fecha, a.codpro as codpro, b.id_banco
FROM detmemoexp a, memoexp b, banco c
WHERE a.id_memoexp=b.id_memoexp and a.status='A' and b.id_banco=c.id_banco) a,
(SELECT c.descripcion as estatusdes, a.fecha_estatus as fecha, b.id_banco, a.codpro as codpro
FROM credito a, banco b, estatus c
WHERE a.id_banco=b.id_banco and a.estatus=c.id_estatus) b, banco c
 where
 a.codpro=b.codpro and c.id_banco=a.id_banco and c.id_banco=b.id_banco and c.tipo='1' and
 b.fecha>a.fecha and a.fecha>'01/01/2012'
 group by  c.banco_descrip  		";
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
}
function estadisticas_prom_3(){
/*--REPORTE 3 NOMBRE:
--Desde que se aprueba el crÃ©dito hasta que se emite el certificado*/


 $sql="select
c.banco_descrip,
(min((b.fecha-a.fecha) + 1)) as min,
round((avg((b.fecha-a.fecha) + 1)), 0) as pro,
(max((b.fecha-a.fecha) + 1)) as max
from
(SELECT c.descripcion as estatusdes, a.fecha_estatus as fecha, b.id_banco, a.codpro as codpro
FROM credito a, banco b, estatus c
WHERE a.id_banco=b.id_banco and a.estatus=c.id_estatus) a,
(SELECT 'Certificado Emitido' as nombrestatus, b.fecha_reg as fecha, c.id_banco , a.codpro as codpro
FROM certificados b
INNER JOIN asignacion a ON a.id_asignacion=b.id_asignacion
INNER JOIN facturaprof c ON a.id_asignacion=c.id_asignacion
WHERE b.estatus='A' and a.status='A' and c.condpago='CREDITO' and  c.id_banco  is not null) b, banco c
 where
 a.codpro=b.codpro and c.id_banco=a.id_banco and c.id_banco=b.id_banco and c.tipo='1' and
 b.fecha>a.fecha and a.fecha>'01/01/2012'
 group by  c.banco_descrip
";
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
}

function estadisticas_prom_4(){
/*--REPORTE 4 NOMBRE:
 --Desde que se envia el certificado al banco hasta que se liquida el credito*/


 $sql="select
c.banco_descrip,
(min((b.fecha-a.fecha) + 1)) as min,
round((avg((b.fecha-a.fecha) + 1)), 0) as pro,
(max((b.fecha-a.fecha) + 1)) as max
from
(SELECT 'Certificado enviado al banco ' as nombrestatus, c.fecha as fecha, c.id_banco, a.codpro as codpro
FROM detmemocert e
INNER JOIN certificados b
INNER JOIN asignacion a ON a.id_asignacion=b.id_asignacion ON e.numcerveh=b.numcerveh
INNER JOIN memocert c
left outer join banco d ON c.id_banco=d.id_banco ON c.id_memocert=e.id_memocert
WHERE b.estatus='A' and a.status='A' and e.status='A' and c.status='A') a,
(
SELECT 'Credito liquidado' as nombrestatus, max(x.fecha) as fecha,
a.id_banco,c.codpro as codpro
FROM movi_proforma x ,facturaprof a
INNER JOIN asignacion c ON a.id_asignacion=c.id_asignacion
WHERE
 a.estatus='A' and c.status='A'  and
 a.condpago='CREDITO' and
 a.id_banco  is not null and
 x.id_numfac=a.id_numfac and x.id_estatus=14
GROUP BY a.id_banco, c.codpro) b, banco c
 where
 a.codpro=b.codpro and c.id_banco=a.id_banco and c.id_banco=b.id_banco and c.tipo='1' and
 b.fecha>a.fecha and a.fecha>'01/01/2012'
 group by  c.banco_descrip
";
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
}

function estadisticas_prom_5(){
/*--REPORTE 5 NOMBRE:
 --Desde que se liquida el credito hasta que se entrega el vehÃ­culo */


 $sql="select
c.banco_descrip,
(min((b.fecha-a.fecha) + 1)) as min,
round((avg((b.fecha-a.fecha) + 1)), 0) as pro,
(max((b.fecha-a.fecha) + 1)) as max
from
(
SELECT 'Credito liquidado' as nombrestatus, max(x.fecha) as fecha,
a.id_banco,c.codpro as codpro
FROM movi_proforma x ,facturaprof a
INNER JOIN asignacion c ON a.id_asignacion=c.id_asignacion
WHERE
 a.estatus='A' and c.status='A'  and
 a.condpago='CREDITO' and
 a.id_banco  is not null and
 x.id_numfac=a.id_numfac and x.id_estatus=14
GROUP BY a.id_banco, c.codpro) a,
(
SELECT 'Vehiculo entregado' as nombrestatus, a.fecha_estatus as fecha,
a.id_banco,c.codpro as codpro
FROM facturaprof a
INNER JOIN asignacion c ON a.id_asignacion=c.id_asignacion
WHERE
 a.estatus='A' and c.status='A'  and
 a.condpago='CREDITO' and
 a.id_banco  is not null and
 a.id_estatus=15) b, banco c
 where
 a.codpro=b.codpro and c.id_banco=a.id_banco and c.id_banco=b.id_banco and c.tipo='1' and
 b.fecha>a.fecha and a.fecha>'01/01/2012'
 group by  c.banco_descrip";
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
}


//REPORTES TAXIS ORINOCOS
function matrizTaxisxEstado($estado=null){

	$sql = "SELECT e.nomest,
	(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
	propietarios f, lote g, zona_estado e
	WHERE g.numlot=25 AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
	AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
	and f.codest='".$estado."' and c.codmod='ORI' AND e.codest = f.codest group by c.codmod) as Lote25,
	(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
	propietarios f, lote g, zona_estado e
	WHERE g.numlot=26 AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
	AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
	and f.codest='".$estado."' and c.codmod='ORI' AND e.codest = f.codest group by c.codmod) as Lote26,
	(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
	propietarios f, lote g, zona_estado e
	WHERE g.numlot=28 AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
	AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
	and f.codest='".$estado."' and c.codmod='ORI' AND e.codest = f.codest group by c.codmod) as Lote28,
	(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
	propietarios f, lote g, zona_estado e
	WHERE g.numlot=29 AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
	AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
	and f.codest='".$estado."' and c.codmod='ORI' AND e.codest = f.codest group by c.codmod) as Lote29,
	(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
	propietarios f, lote g, zona_estado e
	WHERE g.numlot=32 AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
	AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
	and f.codest='".$estado."' and c.codmod='ORI' AND e.codest = f.codest group by c.codmod) as Lote32,
	(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
	propietarios f, lote g, zona_estado e
	WHERE g.numlot=33 AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
	AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
	and f.codest='".$estado."' and c.codmod='ORI' AND e.codest = f.codest group by c.codmod) as Lote33
FROM zona_estado e
WHERE e.codest='".$estado."'";

    //echo "<br>VehxEst ".$sql;
	$conexion= $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$consulta = $this->ret_vector($consulta);
	return $consulta;
}


function matrizTaxisSinEstado($lote=null){

	$sql = "SELECT 'SIN ESTADO',
	(SELECT count(c.codmod) FROM asignacion a, caracteristica b, modelo c, vehiculo d,
	propietarios f, lote g
	WHERE g.numlot=$lote AND a.status = 'A' AND b.id_caract = d.id_caract AND c.codmod = b.codmod
	AND d.sercarveh = a.sercarveh AND f.codpro = a.codpro AND g.numlot = b.numlotveh
	and c.codmod='ORI' AND (f.codest is null or f.codest='') group by c.codmod) as lotes
	FROM lote g WHERE g.numlot=$lote";
	

	//echo "<br>VehxEst ".$sql;
	$conexion= $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$consulta = $this->ret_vector($consulta);
	return $consulta;
}

//TAXIS ASIGNADOS POR ESTADO X ESTATUS
function matrizTaxisxEstado1($estado=null,$status=null){
	
	if ($status) $estatus = " AND a.id_estatus=$status";
	
	$sql = "SELECT e.nomest, (SELECT count(l.codmod) from asignacion b, vehiculo i left outer join placas h on h.sercarveh=i.sercarveh,caracteristica j
	left outer join modelo l on l.codmod=j.codmod , propietarios c
	left outer join tipo_benef r on r.codtipben=c.tipo
	left outer join zona_estado f on f.codest=c.codest
	left outer join sexo g on g.codsexo=c.sexo, facturaprof a
	left outer join banco d on d.id_banco=a.id_banco
	left outer join estatus e on e.id_estatus=a.id_estatus
	left outer join certificados o on o.id_asignacion=a.id_asignacion and o.tipmov_txt='MA' AND o.estatus='A',
	lote n,color p where j.numlotveh=n.numlot and i.id_caract=j.id_caract and b.sercarveh=i.sercarveh
	and a.estatus='A' and a.id_asignacion=b.id_asignacion and b.codpro=c.codpro and p.codcol=i.col1veh
	and j.numlotveh=25 AND l.codmod='ORI' AND c.codest='".$estado."' $estatus) as Lote25,
	(SELECT count(l.codmod) from asignacion b, vehiculo i left outer join placas h on h.sercarveh=i.sercarveh,caracteristica j
	left outer join modelo l on l.codmod=j.codmod , propietarios c
	left outer join tipo_benef r on r.codtipben=c.tipo
	left outer join zona_estado f on f.codest=c.codest
	left outer join sexo g on g.codsexo=c.sexo, facturaprof a
	left outer join banco d on d.id_banco=a.id_banco
	left outer join estatus e on e.id_estatus=a.id_estatus
	left outer join certificados o on o.id_asignacion=a.id_asignacion and o.tipmov_txt='MA' AND o.estatus='A',
	lote n,color p where j.numlotveh=n.numlot and i.id_caract=j.id_caract and b.sercarveh=i.sercarveh
	and a.estatus='A' and a.id_asignacion=b.id_asignacion and b.codpro=c.codpro and p.codcol=i.col1veh
	and j.numlotveh=26 AND l.codmod='ORI' AND c.codest='".$estado."' $estatus) as Lote26,
	(SELECT count(l.codmod) from asignacion b, vehiculo i left outer join placas h on h.sercarveh=i.sercarveh,caracteristica j
	left outer join modelo l on l.codmod=j.codmod , propietarios c
	left outer join tipo_benef r on r.codtipben=c.tipo
	left outer join zona_estado f on f.codest=c.codest
	left outer join sexo g on g.codsexo=c.sexo, facturaprof a
	left outer join banco d on d.id_banco=a.id_banco
	left outer join estatus e on e.id_estatus=a.id_estatus
	left outer join certificados o on o.id_asignacion=a.id_asignacion and o.tipmov_txt='MA' AND o.estatus='A',
	lote n,color p where j.numlotveh=n.numlot and i.id_caract=j.id_caract and b.sercarveh=i.sercarveh
	and a.estatus='A' and a.id_asignacion=b.id_asignacion and b.codpro=c.codpro and p.codcol=i.col1veh
	and j.numlotveh=28 AND l.codmod='ORI' AND c.codest='".$estado."' $estatus) as Lote28,
	(SELECT count(l.codmod) from asignacion b, vehiculo i left outer join placas h on h.sercarveh=i.sercarveh,caracteristica j
	left outer join modelo l on l.codmod=j.codmod , propietarios c
	left outer join tipo_benef r on r.codtipben=c.tipo
	left outer join zona_estado f on f.codest=c.codest
	left outer join sexo g on g.codsexo=c.sexo, facturaprof a
	left outer join banco d on d.id_banco=a.id_banco
	left outer join estatus e on e.id_estatus=a.id_estatus
	left outer join certificados o on o.id_asignacion=a.id_asignacion and o.tipmov_txt='MA' AND o.estatus='A',
	lote n,color p where j.numlotveh=n.numlot and i.id_caract=j.id_caract and b.sercarveh=i.sercarveh
	and a.estatus='A' and a.id_asignacion=b.id_asignacion and b.codpro=c.codpro and p.codcol=i.col1veh
	and j.numlotveh=29 AND l.codmod='ORI' AND c.codest='".$estado."' $estatus) as Lote29,
	(SELECT count(l.codmod) from asignacion b, vehiculo i left outer join placas h on h.sercarveh=i.sercarveh,caracteristica j
	left outer join modelo l on l.codmod=j.codmod , propietarios c
	left outer join tipo_benef r on r.codtipben=c.tipo
	left outer join zona_estado f on f.codest=c.codest
	left outer join sexo g on g.codsexo=c.sexo, facturaprof a
	left outer join banco d on d.id_banco=a.id_banco
	left outer join estatus e on e.id_estatus=a.id_estatus
	left outer join certificados o on o.id_asignacion=a.id_asignacion and o.tipmov_txt='MA' AND o.estatus='A',
	lote n,color p where j.numlotveh=n.numlot and i.id_caract=j.id_caract and b.sercarveh=i.sercarveh
	and a.estatus='A' and a.id_asignacion=b.id_asignacion and b.codpro=c.codpro and p.codcol=i.col1veh
	and j.numlotveh=32 AND l.codmod='ORI' AND c.codest='".$estado."' $estatus) as Lote32,
	(SELECT count(l.codmod) from asignacion b, vehiculo i left outer join placas h on h.sercarveh=i.sercarveh,caracteristica j
	left outer join modelo l on l.codmod=j.codmod , propietarios c
	left outer join tipo_benef r on r.codtipben=c.tipo
	left outer join zona_estado f on f.codest=c.codest
	left outer join sexo g on g.codsexo=c.sexo, facturaprof a
	left outer join banco d on d.id_banco=a.id_banco
	left outer join estatus e on e.id_estatus=a.id_estatus
	left outer join certificados o on o.id_asignacion=a.id_asignacion and o.tipmov_txt='MA' AND o.estatus='A',
	lote n,color p where j.numlotveh=n.numlot and i.id_caract=j.id_caract and b.sercarveh=i.sercarveh
	and a.estatus='A' and a.id_asignacion=b.id_asignacion and b.codpro=c.codpro and p.codcol=i.col1veh
	and j.numlotveh=33 AND l.codmod='ORI' AND c.codest='".$estado."' $estatus) as Lote33					
	FROM zona_estado e WHERE e.codest='".$estado."'";
	

	//echo "<br>VehxEst ".$sql;
	$conexion= $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$consulta = $this->ret_vector($consulta);
	return $consulta;
}


function matrizTaxisSinEstado1($lote=null,$status=null){
    if ($status<>'') $estatus = " AND a.id_estatus=$status";
	
    $sql = "SELECT 'SIN ESTADO',
    (SELECT count(l.codmod)
    from asignacion  b, vehiculo i
    left outer join placas h  on h.sercarveh=i.sercarveh,caracteristica j
    left outer join modelo l  on l.codmod=j.codmod
    , propietarios c
    left outer join tipo_benef r on r.codtipben=c.tipo
    left outer join zona_estado f on f.codest=c.codest
    left outer join sexo g on g.codsexo=c.sexo,
    facturaprof a
    left outer join banco d on d.id_banco=a.id_banco
    left outer join estatus e on e.id_estatus=a.id_estatus
    left outer join certificados o on o.id_asignacion=a.id_asignacion and o.tipmov_txt='MA' AND o.estatus='A',
    lote n,color p where
    j.numlotveh=n.numlot and
    i.id_caract=j.id_caract and
    b.sercarveh=i.sercarveh and
    a.estatus='A' and
    a.id_asignacion=b.id_asignacion and
    b.codpro=c.codpro
    and p.codcol=i.col1veh and j.numlotveh=$lote AND l.codmod='ORI' AND (c.codest is null or c.codest='' ) $estatus) FROM lote g WHERE g.numlot=$lote";


	//echo "<br>VehxEst ".$sql;
	$conexion= $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$consulta = $this->ret_vector($consulta);
	return $consulta;
}

}
?>