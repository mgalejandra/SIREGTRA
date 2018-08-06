<?php
class inventario extends conexion{

  function regPreInventario($data){

  $fecha=date('d/m/Y');
  $cantidad = $data[3];
  if ($data[2])
  {
  	$sql = "INSERT INTO preinventario(id_marca,id_modelo,id_serie,fecha,cantidad,precio_min,precio_max,usuario)
         values
           ('".$data[0]."','".$data[1]."','".$data[2]."','".$fecha."',".$data[3].",".$data[4].",".$data[5].",'".$_SESSION['usuario']."')";
  }
  else
  {
  	$sql = "INSERT INTO preinventario(id_marca,id_modelo,fecha,cantidad,precio_min,precio_max,usuario)
         values
           ('".$data[0]."','".$data[1]."','".$fecha."',".$data[3].",".$data[4].",".$data[5].",'".$_SESSION['usuario']."')";
  }

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta)
  {
    	$this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/preinventario.php');
		$conexion1 = $this->conectar();
    	$sql1="Select max(id_preinv) from preinventario";

       		$consulta1 = $this->consultar($conexion1,$sql1);
			$consulta1 = $this->ret_vector($consulta1);

			if ($consulta1)
			{
				$conexion2 = $this->conectar();
				$sql2 = "INSERT INTO existencia(id_preinv,existencia) values (".$consulta1[0].",".$cantidad.")";

				//echo "Existencia: ".$sql2;
				$consulta2 = $this->consultar($conexion2,$sql2);
			}
  }
  return $consulta;
}

 function listarPreInventario($idpre,$codmar,$modveh,$serveh,$offset,$lote=null){

  $fecha=date('d/m/Y');

  $sql = "select
			a.id_preinv, b.desmar, c.desmod, to_char(a.fecha,'dd/mm/yyyy') ,a.cantidad , a.precio_min, a.precio_max";

  if($serveh)  $sql=$sql." , a.id_serie";

	$sql .= " , a.numlotveh from
			preinventario a, marcas b, modelo c";

  if($serveh)  $sql=$sql.", serie d";

	$sql.=	" where
			a.id_marca=b.codmar and
			a.id_modelo=c.codmod";

	if ($serveh) $sql .= " and a.id_serie=d.codserie";

    if ($idpre)  $sql=$sql." and a.id_preinv='".$idpre."'";
    if ($codmar)  $sql=$sql." and a.id_marca='".$codmar."'";
    if ($modveh)  $sql=$sql." and a.id_modelo='".$modveh."'";
    if ($serveh)  $sql=$sql." and a.id_serie='".$serveh."'";
    if ($lote) $sql .= " and a.numlotveh='".$lote."'";
    $sql=$sql." order by a.id_preinv";
    if ($offset>=0) $sql = $sql." LIMIT 20 OFFSET  ".$offset;


 // print '<br>Preinventario'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function contarPreInventario($idpre,$codmar,$modveh,$serveh,$lote=null){

  $fecha=date('d/m/Y');

  $sql = "select count(a.id_preinv)";

	$sql .= " from
			preinventario a, marcas b, modelo c";
    if ($serveh) $sql.= ", serie d";
		$sql.= " where
			a.id_marca=b.codmar and
			a.id_modelo=c.codmod";

	if ($serveh) $sql .= " and a.id_serie=d.codserie";

    if($idpre)  $sql=$sql." and a.id_preinv='".$idpre."'";
    if($codmar)  $sql=$sql." and a.id_marca='".$codmar."'";
    if($modveh)  $sql=$sql." and a.id_modelo='".$modveh."'";
    if($serveh)  $sql=$sql." and a.id_serie='".$serveh."'";
    if($lote)    $sql=$sql." and a.numlotveh='".$lote."'";

  //print '<br>Contar Preinventario'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta[0];
 }


 function buscarExistencia($inv){

  $sql = "select existencia from existencia where id_preinv='$inv'";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }

 function restarExistencia($inv){
 	  $sql = "select existencia from existencia where id_preinv=$inv";

 	  //echo "El va a restar de: ".$sql;

 	  $conexion = $this->conectar();
	  $consulta = $this->consultar($conexion,$sql);
	  $consulta = $this->ret_vector($consulta);

	  if ($consulta)
	  {
	  	 $dcto = $consulta[0]-1;
	  	 $sql1 = "update existencia set existencia=$dcto  where id_preinv=$inv";

	  	 $consulta1 = $this->consultar($conexion,$sql1);

		 $this->desconectar($conexion);
	  }

	  return $consulta1;
 }

 function reportePreinventario($numlotveh){

  /*$sql = "
select count(a.id_preinv), d.desmod,  b.cantidad , c.existencia, b.precio_min, b.precio_max,
(select count(e.id_preinv)  from facturaprof e
where e.sercarveh='0' and e.id_preinv=a.id_preinv and e.id_banco='0175'
GROUP BY e.id_preinv, e.id_banco ) as bic,
(select count(e.id_preinv)  from facturaprof e
where e.sercarveh='0' and e.id_preinv=a.id_preinv and e.id_banco='0102'
GROUP BY e.id_preinv, e.id_banco ) as ven,
(select count(e.id_preinv)  from facturaprof e
where e.sercarveh='0' and e.id_preinv=a.id_preinv and e.id_banco='0163'
GROUP BY e.id_preinv, e.id_banco ) as tes,
(select count(e.id_preinv)  from facturaprof e
where e.sercarveh='0' and e.id_preinv=a.id_preinv and e.id_banco='0003'
GROUP BY e.id_preinv, e.id_banco ) as ind
from  preinventario b , existencia c, modelo d, asignacion a
where a.id_preinv is not null and a.id_preinv=b.id_preinv and a.id_preinv=c.id_preinv and  b.id_modelo=d.codmod
GROUP BY a.id_preinv,b.cantidad , c.existencia, b.precio_min, b.precio_max , b.id_modelo, d.desmod order by a.id_preinv";*/

$sql=	"
		select z.codmod, z.desmod, x.cantidad,
		(
		select count(d.codmod) from asignacion a, vehiculo b, placas c, caracteristica d,
		(
		select count(a.numplaveh) as cant , a.numplaveh
		from
					placas a , vehiculo b, caracteristica c
					where
					a.sercarveh=b.sercarveh and
					b.id_caract=c.id_caract and c.numlotveh=$numlotveh
					GROUP BY a.numplaveh) pla
					where a.status='A' and d.codmod is not null AND
					a.sercarveh=b.sercarveh and
					b.sercarveh=c.sercarveh and
					c.numplaveh=pla.numplaveh
					and d.id_caract=b.id_caract and d.numlotveh=$numlotveh
					and d.codmod=x.id_modelo
		group by d.codmod) as asi,
		(
		select count(f.codmod)
		 from
					asignacion  b,
					propietarios c,
					facturaprof a,
					preinventario e,
					modelo f
					where
					a.estatus='A' and b.status='A' and
					a.id_asignacion=b.id_asignacion and
					b.codpro=c.codpro and
		                        b.id_preinv=e.id_preinv and e.numlotveh=$numlotveh and
		                        e.id_modelo=f.codmod and e.id_modelo=x.id_modelo
		GROUP BY f.codmod
		) as pre,
		y.existencia, x.numlotveh
		from  preinventario x , existencia y, modelo z
		where
		x.id_modelo=z.codmod and
		x.id_preinv=y.id_preinv and x.numlotveh=$numlotveh order by x.id_preinv";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }

  function reportePreinventarioInicial($desde,$hasta,$numlotveh,$codmod){

  $sql = "select
count(i.codmod) as cantidad, i.desmod,'' as mont,
		b.id_preinv,h.numlotveh
from asignacion  b,
propietarios c
left outer join tipo_benef r on r.codtipben=c.tipo
left outer join zona_estado f on f.codest=c.codest
left outer join sexo g on g.codsexo=c.sexo,
preinventario h, modelo i
where
h.id_modelo=i.codmod and
h.id_preinv=b.id_preinv and
b.status='A' and
b.codpro=c.codpro and h.numlotveh=$numlotveh and h.id_modelo='".$codmod."' ";
$sql.=" group by i.codmod, i.desmod , b.id_preinv,h.numlotveh order by  b.id_preinv";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }

//PARA RESTAR EL PREINVENTARIO SI EL VEHICULO ES DE UN PREINVENTARIO
function buscarPreInv($sercarveh){
 /* $sql = "SELECT c.id_preinv FROM marcas a, modelo b, preinventario c, caracteristica d, vehiculo e WHERE a.codmar = c.id_marca AND  a.codmar = d.codmarveh AND
  b.codmod = c.id_modelo AND  b.codmod = d.codmod AND  d.id_caract = e.id_caract";
  if($sercarveh)  $sql.= " and e.sercarveh='".$sercarveh."'";*/

  $sql = "SELECT  c.id_preinv
			FROM
			  caracteristica a,
			  vehiculo b,
			  preinventario c
			WHERE
			  a.id_caract = b.id_caract
			  AND  c.numlotveh=a.numlotveh AND a.codmod=c.id_modelo";

  if($sercarveh)  $sql.= " and b.sercarveh='".$sercarveh."'";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
}



//Para el reporte de la Ministro
function reportePreinventarioC($numlotveh){
$sql=	"

select z.codmod, z.desmod, x.cantidad, y.existencia,
		(
		select count(d.codmod) from asignacion a, vehiculo b, placas c, caracteristica d
		where a.status='A' and d.codmod is not null AND
		a.sercarveh=b.sercarveh and
		b.sercarveh=c.sercarveh and
	        c.sercarveh=a.sercarveh and
		d.id_caract=b.id_caract and d.numlotveh=$numlotveh
		and d.codmod=x.id_modelo
		group by d.codmod) as asi,
		(
		select count(a.id_preinv) from asignacion a,  preinventario e, modelo f
		where a.status='A'
	        and e.numlotveh=$numlotveh and f.codmod=e.id_modelo
		and f.codmod=x.id_modelo and a.id_preinv=e.id_preinv
		group by a.id_preinv
		) as preInv,
		(
		select count(d.codmod) from asignacion a, vehiculo b, placas c, caracteristica d, facturaprof e
		where a.status='A' and d.codmod is not null AND
		a.sercarveh=b.sercarveh and
		b.sercarveh=c.sercarveh and
	        c.sercarveh=a.sercarveh and
		d.id_caract=b.id_caract and d.numlotveh=$numlotveh
		and d.codmod=x.id_modelo and a.id_asignacion=e.id_asignacion and e.id_estatus=15
		group by d.codmod ) as entre , x.numlotveh,x.id_preinv
		from  preinventario x , modelo z,  existencia y
		where
		x.id_modelo=z.codmod and y.id_preinv =x.id_preinv and x.numlotveh=$numlotveh order by x.id_preinv
       ";

 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }

 function reportePreinventarioC1($numlotveh){

   $modelos[0]="QQ3";
   $modelos[1]="X1";
   $modelos[2]="TIG";
   $modelos[3]="TG4";
   $modelos[4]="T44";
   $total=count($modelos);

$sql=" select 'INVENTARIO INICIAL' as INVINICIAL ";

 for ($i=0; $i < $total; $i+=1){
   $sql.= ", (
	       select e.cantidad
	       from preinventario e, modelo f
               where e.numlotveh='".$numlotveh."'
               and f.codmod=e.id_modelo
               and f.codmod='".$modelos[$i]."') as ".$modelos[$i]." ";
   }

$sql.= " UNION ALL ";

$sql.=" select 'ENTREGADOS' as ENTREGADOS";

 for ($i=0; $i < $total; $i+=1){
   $sql.= ", (select count(d.codmod) from asignacion a, vehiculo b, placas c, caracteristica d, facturaprof e
               where a.status='A' and d.codmod is not null AND
               a.sercarveh=b.sercarveh and
               b.sercarveh=c.sercarveh and
               c.sercarveh=a.sercarveh and
               d.id_caract=b.id_caract and d.numlotveh='".$numlotveh."'
               and d.codmod='".$modelos[$i]."' and a.id_asignacion=e.id_asignacion and e.id_estatus=15
               group by d.codmod) as ".$modelos[$i]." ";
   }

$sql.= " UNION ALL ";

$sql.="select 'ASIGNADOS' as asignados";

   for ($i=0; $i < $total; $i+=1){

   $sql.= ", (select count(d.codmod)
	        from asignacion a, vehiculo b, placas c, caracteristica d
		where a.status='A' and d.codmod is not null AND
		a.sercarveh=b.sercarveh and
		b.sercarveh=c.sercarveh and
	        c.sercarveh=a.sercarveh and
		d.id_caract=b.id_caract and (d.numlotveh='".$numlotveh."' ) and d.codmod='".$modelos[$i]."'
		group by d.codmod) as ".$modelos[$i]." ";
   }

$sql.= " UNION ALL ";

$sql.=" select 'PRE' as PREINVENTARIO";

 for ($i=0; $i < $total; $i+=1){
   $sql.= ", (select count(a.id_preinv)
	       from asignacion a,  preinventario e, modelo f
               where a.status='A'
               and e.numlotveh='".$numlotveh."'
               and f.codmod=e.id_modelo
               and f.codmod='".$modelos[$i]."' and a.id_preinv=e.id_preinv
               group by a.id_preinv) as ".$modelos[$i]." ";
   }

$sql.= " UNION ALL ";

$sql.=" select 'PDI NEGATIVO' as PDINEGATIVO";

 for ($i=0; $i < $total; $i+=1){
   $sql.= ", (select count(b.sercarveh)
			from modelo e,marcas f,caracteristica a,vehiculo b
			left outer join placas d on b.sercarveh=d.sercarveh
			where e.codmod = a.codmod AND f.codmar = a.codmarveh AND a.id_caract = b.id_caract
			and b.estatus='E' and a.codmod='".$modelos[$i]."' and a.numlotveh='".$numlotveh."') as ".$modelos[$i]." ";
   }

$sql.= " UNION ALL ";

$sql.=" select 'DISPONIBLES' as DISPONIBLES ";

 for ($i=0; $i < $total; $i+=1){
   $sql.= ", (
	       select a.existencia
	       from preinventario e, modelo f, existencia a
               where e.numlotveh='".$numlotveh."'
               and e.id_preinv=a.id_preinv
               and f.codmod=e.id_modelo
               and f.codmod='".$modelos[$i]."') as ".$modelos[$i]." ";
   }


 //print '<pre>'; print $sql;

 $conexion = $this->conectar();
 $consulta = $this->consultar($conexion,$sql);
 $consulta = $this->ret_vector($consulta);
 $this->desconectar($conexion);

 return $consulta;
 }


     function conciliarInventario($concil,$idpreinv) {


        for ($i = 0; $i < count($idpreinv); $i++) {
            if (!($concil[$i] < 0) and $concil[$i] <> '') {
                $sql = "update  existencia SET existencia='" . $concil[$i] . "' ";
                $sql = $sql . "WHERE id_preinv = '" . $idpreinv[$i] . "'; ";
             //  print '<pre>'; print $sql;
                $conexion = $this->conectar();
                $consulta2 = $this->consultar($conexion, $sql);
                if ($consulta2)
                    $this->desconectar($conexion);
               $this->auditar('MODIFICAR:SE CONCILIA PREINVENTARIO',$sql,'http://localhost/refeciv1.1/vistas/reporte_preiv_concil.php');
            }
        }


        return $consulta2;
    }

}
?>