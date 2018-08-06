<?php
class vehiculos extends conexion{

  function reporteContadoMincoModelo($numlotveh){
	$sql="
	select distinct(x.codmod), y.desmod,
		(SELECT count (a.id_numfac) as cant
			FROM facturaprof a, asignacion c, vehiculo d, caracteristica e
			WHERE a.id_asignacion = c.id_asignacion AND d.sercarveh = c.sercarveh AND
			e.id_caract = d.id_caract and a.estatus='A' and (c.codpro like '%V%') and
			a.id_estatus=15 and condpago='CONTADO' and  e.codmod=x.codmod) as Ven,
		(SELECT count (a.id_numfac) as cant
			FROM facturaprof a, asignacion c, vehiculo d, caracteristica e
			WHERE a.id_asignacion = c.id_asignacion AND d.sercarveh = c.sercarveh AND
			e.id_caract = d.id_caract and a.estatus='A' and (c.codpro like '%E%') and
			a.id_estatus=15 and condpago='CONTADO' and  e.codmod=x.codmod) as Ext,
		(SELECT count (a.id_numfac) as cant
			FROM facturaprof a, asignacion c, vehiculo d, caracteristica e
			WHERE a.id_asignacion = c.id_asignacion AND d.sercarveh = c.sercarveh AND
			e.id_caract = d.id_caract and a.estatus='A' and (c.codpro like '%G%') and
			a.id_estatus=15 and condpago='CONTADO' and  e.codmod=x.codmod) as Gob,
		(SELECT count (a.id_numfac) as cant
			FROM facturaprof a, asignacion c, vehiculo d, caracteristica e
			WHERE a.id_asignacion = c.id_asignacion AND d.sercarveh = c.sercarveh AND
			e.id_caract = d.id_caract and a.estatus='A' and (c.codpro like '%J%') and
			a.id_estatus=15 and condpago='CONTADO' and  e.codmod=x.codmod) as Jur
	from caracteristica x, modelo y where x.codmarveh='C7' and  x.codmod is not null and x.codmod=y.codmod
	order by y.desmod";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;


 }

  function reporteCreditominco($numlotveh){
   $sql="SELECT
			b.banco_descrip,
			count (a.id_numfac)
		FROM
  			facturaprof a,
  			banco b,
  			asignacion c,
  			vehiculo d,
  			caracteristica e
		WHERE
  			a.id_asignacion = c.id_asignacion AND
  			a.id_banco = b.id_banco AND
  			d.sercarveh = c.sercarveh AND
  			e.id_caract = d.id_caract and
 			a.id_banco <> '' and a.estatus='A' and c.status='A' and
  			a.id_estatus=15";
  			if ($numlotveh) $sql.= " and numlotveh=$numlotveh";
  			//else $sql.= " and (numlotveh=14 or numlotveh=15 or numlotveh=16 or numlotveh=17)";
  			else $sql.= " and (numlotveh=19 or numlotveh=20 or numlotveh=21 or numlotveh=22)";
			$sql.=" group by b.banco_descrip; ";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }

   function reporteContadoMinco($numlotveh){
	$sql=	"select z.tipo, z.cant from (
			SELECT 'Contado Institucionales' as tipo, count (a.id_numfac) as cant
			FROM facturaprof a, asignacion c, vehiculo d, caracteristica e
			WHERE a.id_asignacion = c.id_asignacion AND d.sercarveh = c.sercarveh AND
  				  e.id_caract = d.id_caract and a.estatus='A' and (c.codpro like '%G%' or c.codpro like '%J%') and
  				  a.id_estatus=15 and condpago='CONTADO' ";
  	if ($numlotveh) $sql.= " and numlotveh=$numlotveh";
  	//else $sql.= " and (numlotveh=14 or numlotveh=15 or numlotveh=16 or numlotveh=17)";
  	else $sql.= " and (numlotveh=19 or numlotveh=20 or numlotveh=21 or numlotveh=22)";
	$sql.= " group by condpago
			union all
			SELECT 'Contado Particulares' as tipo, count (a.id_numfac) as cant
			FROM facturaprof a, asignacion c, vehiculo d, caracteristica e
			WHERE a.id_asignacion = c.id_asignacion AND
  			d.sercarveh = c.sercarveh AND e.id_caract = d.id_caract and
  			a.estatus='A' and (c.codpro like '%V%' or c.codpro like '%E%') and
  			a.id_estatus=15 and condpago='CONTADO'";
  	if ($numlotveh) $sql.= " and numlotveh=$numlotveh";
  	//else $sql.= " and (numlotveh=14 or numlotveh=15 or numlotveh=16 or numlotveh=17)";
  	else $sql.= " and (numlotveh=19 or numlotveh=20 or numlotveh=21 or numlotveh=22)";
	$sql.= " group by condpago ) z ";

 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function registrarVehiculos($data){
  $fecha=date('d/m/Y');
  if (!$data[7]) $fechom='null'; else $fechom="'".$data[7]."'";
  $sql = "INSERT INTO vehiculo(
  		   sercarveh ,  sermotveh ,   col1veh , col2veh ,   sernivveh ,  serchaveh ,  numhomveh ,fechomveh, id_caract,  fecha_reg )
         values
           ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."',$fechom,".$data[8].",'".$fecha."')";
 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/');
  return $consulta;
 }

 function listarVehiculos($sercarveh,$codmar,$modveh,$serveh,$origen,$lote,$factura,$taller=null,$tt=null){

 	if ($origen=='I')
 	$origenP="and b.origenveh='I'";
 	else
 	$origenP="and b.origenveh<>'I' ";

 	if ($origen=='T') $origenP=" ";

    $sql = "select
			a.sercarveh ,  a.sermotveh , f.descol, a.sernivveh , a.serchaveh ,  a.numhomveh , to_char(a.fechomveh,'dd/mm/yyyy'),
			(c.desmar||' / '||d.desmod||' / '||COALESCE(desserie(b.codserie),' S/S ')||' / '||b.anomodveh||' / '||g.destip||' / '||b.preveh||' / FACT '||COALESCE(b.numfacveh,' S/F ') ) as caract,  a.id_caract, '' as txt, a.fecha_reg,
			a.col1veh, a.col2veh, descolor(a.col2veh), c.desmar, d.desmod, b.numlotveh";

	$sql.= " from
			vehiculo a, caracteristica b, marcas c , modelo d , color f, tipos g";

	if ($taller or $tt) $sql.= ", vehic_taller j";

	$sql.= " where
			a.estatus='A' and a.id_caract=b.id_caract and
            b.codmarveh=c.codmar and
			b.codmod=d.codmod  and b.codtipveh=g.codtip and
			a.col1veh=f.codcol $origenP ";

	if ($taller or $tt) $sql.= " and a.sercarveh=j.sercarveh";

    if($sercarveh)  $sql=$sql." and a.sercarveh='".$sercarveh."'";
    if($codmar)  $sql=$sql." and b.codmarveh='".$codmar."'";
    if($modveh)  $sql=$sql." and b.codmod='".$modveh."'";
    if($serveh)  $sql=$sql." and b.codserie='".$serveh."'";
    if($lote)  $sql=$sql." and b.numlotveh=".$lote."";
    if($factura)  $sql=$sql." and b.numfacveh like '%".$factura."%'";
    if ($taller) $sql.= " and j.id_taller =  '".$taller."'";
    $sql=$sql." order by b.numlotveh, a.sercarveh, c.desmar, d.desmod, b.codserie ";

 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
/*
 * Calcula el inventario de vehículos para la elaboración de cuadro resumen
 */
 function listarVehiculosInv($origen){

 	if ($origen=='I') $origenP = "AND b.origenveh='I'";
 	else $origenP="AND b.origenveh<>'I'";

 	if ($origen=='T') $origenP=" ";

	$origenP .= " AND b.numlotveh IN (1,2,8,10)";

// Genera secuencia numérica de 6 dígitos (según pulsos del procesador)
// para generar nombres temporales de las tablas y evitar conflictos
// en caso de simultaneidad de consultas

	$ntime = substr(microtime(),2,6);
	//echo '<br>'.$ntime;

//  Totaliza Vehículos Adquiridos

$sql_T1 = "SELECT b.codmarveh, b.codmod, COUNT(*) AS unidAdq INTO TEMP totadq_".$ntime." FROM vehiculo a  " .
		"INNER JOIN caracteristica b ON b.id_caract = a.id_caract " .
		"WHERE a.estatus = 'A' " .$origenP.
		"GROUP BY 1,2 ORDER BY 1,2;";

//  Totaliza Vehículos Entregados

$sql_T2 = "SELECT b.codmarveh, b.codmod, COUNT(*) AS unident INTO TEMP totent_".$ntime." FROM vehiculo a  " .
		"INNER JOIN caracteristica b ON b.id_caract = a.id_caract " .
		"WHERE a.estatus = 'A' " .$origenP .
		"AND a.sercarveh IN (SELECT sercarveh FROM venta WHERE estatus = 'E') " .
		"GROUP BY 1,2 ORDER BY 1,2;";

//  Totaliza Vehículos Vendidos No Entregados

$sql_T3 = "SELECT b.codmarveh, b.codmod, COUNT(*) AS unidVNE INTO TEMP totvne_".$ntime." FROM vehiculo a  " .
		"INNER JOIN caracteristica b ON b.id_caract = a.id_caract " .
		"WHERE a.estatus = 'A' ".$origenP .
		"AND a.sercarveh IN (SELECT sercarveh FROM venta WHERE sercarveh NOT IN (SELECT sercarveh FROM entrega)) " .
		"GROUP BY 1,2 ORDER BY 1,2;";

//  Totaliza Vehículos En espera de Pago

$sql_T4 = "SELECT b.codmarveh, b.codmod, COUNT(*) AS unidEsp INTO TEMP totesp_".$ntime." FROM vehiculo a  " .
		"INNER JOIN caracteristica b ON b.id_caract = a.id_caract " .
		"WHERE a.estatus = 'A' " .$origenP.
		"AND a.sercarveh IN (SELECT DISTINCT sercarveh FROM pago) " .
		"GROUP BY 1,2 ORDER BY 1,2;";

//  Determina Costo Unitario (máximo)

$sql_T5 = "SELECT b.codmarveh, b.codmod, AVG(b.preveh) AS CostUn INTO TEMP costun_".$ntime." FROM vehiculo a  " .
		"INNER JOIN caracteristica b ON b.id_caract = a.id_caract " .
		"WHERE a.estatus = 'A' " .$origenP.
		"GROUP BY 1,2 ORDER BY 1,2;";

//  Concatena columnas de totalizaciones calculadas previamente y Costo unitario

$sql_T6 = "SELECT c.desmar,d.desmod,unidAdq,unidEnt,unidAdq-unidEnt AS unidAlm,unidVNE,unidEsp,costUn,costUn*1.12+410 AS precio " .
		"FROM totadq_".$ntime." T1 " .
		"INNER JOIN marcas c ON c.codmar = T1.codmarveh " .
		"INNER JOIN modelo d ON d.codmod = T1.codmod " .
		"FULL JOIN totent_".$ntime." T2 ON T2.codmarveh = T1.codmarveh AND T2.codmod = T1.codmod " .
		"FULL JOIN totvne_".$ntime." T3 ON T3.codmarveh = T1.codmarveh AND T3.codmod = T1.codmod " .
		"FULL JOIN totesp_".$ntime." T4 ON T4.codmarveh = T1.codmarveh AND T4.codmod = T1.codmod " .
		"FULL JOIN costun_".$ntime." T5 ON T5.codmarveh = T1.codmarveh AND T5.codmod = T1.codmod;";

$sql = $sql_T1.$sql_T2.$sql_T3.$sql_T4.$sql_T5.$sql_T6;

//f_alert($sql);

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function modificarVehiculos($idsercarveh,$data){
  $fecha=date('d/m/Y');
  $conexion = $this->conectar();
  if (!$data[7]) $fechom='null'; else $fechom="'".$data[7]."'";
  $estatus=$this->statusTxt('',$data[0]);

    if ($estatus[0] == 'E'){
  	  $sql ="  update certificados set
  		       tipmov_txt='MM' , estatusveh='P' , numenvveh=null , fechatxtveh=null ,tipmov_pro='MM' , estatuspro='P' , numenvpro=null , fechatxtpro=null ,  nummodveh=nummodveh+1 where sercarveh='".$data[0]."' ";
  	  $this->consultar($conexion,$sql);
  		    //   print '<pre>'; print $sql;
  	  }

  $sql ="  update vehiculo set
  		   sercarveh='".$data[0]."' ,  sermotveh='".$data[1]."', sernivveh='".$data[4]."' , serchaveh='".$data[5]."' ,
  		   numhomveh='".$data[6]."' ,  fechomveh=$fechom, id_caract=".$data[8].", fecha_mod='".$fecha."',
		   col1veh='".$data[2]."', col2veh='".$data[3]."' "
        ;
  $sql=$sql." where sercarveh='".$idsercarveh."'";
 //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/');
  return $consulta;
 }

//                      $sercarveh,$codmar,$modveh,$serveh,'I',$numlotveh,$factura
function ContVehiculos($sercarveh,$codmar,$modveh,$serveh,$origen,$numlotveh,$factura,$tipo,$taller=null,$tt=null,$numdep=null,$color=null, $placa=null, $caract=null){

 	if ($origen=='I')
 	$origenP="and b.origenveh='I'";
 	else
 	$origenP="and b.origenveh<>'I' ";

 	if ($origen=='T') $origenP=" ";

    $sql = "select count(a.sercarveh) from ( select
			count(a.sercarveh), a.sercarveh";

  	//if ($taller) $sql.= ", j.sercarveh";

   	$sql .= " from
			vehiculo a, caracteristica b, marcas c , modelo d , color f, tipos g, departamento k, lote e";


 	if ($taller or $tt) $sql.= ", vehic_taller j";

 	if ($placa) $sql.= ", placas p";

	$sql.="	where
			a.estatus='A' and a.id_caract=b.id_caract and
            b.codmarveh=c.codmar and
            b.numlotveh=e.numlot and
	        e.numdep=k.numdep and
			b.codmod=d.codmod  and b.codtipveh=g.codtip and
			a.col1veh=f.codcol $origenP  ";

    if ($tipo=='asignacion') $sql=$sql." AND a.sercarveh in (select sercarveh from placas) ";

	if ($taller or $tt) $sql.= " and a.sercarveh=j.sercarveh";
	if ($placa) $sql.= " and p.sercarveh=a.sercarveh";


    if($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
    if($codmar)  $sql=$sql." and b.codmarveh='".$codmar."'";
    if($modveh)  $sql=$sql." and b.codmod='".$modveh."'";
    if($serveh)  $sql=$sql." and b.codserie='".$serveh."'";
    if($numlotveh)  $sql=$sql." and b.numlotveh=".$numlotveh."";
    if($factura)  $sql=$sql." and b.numfacveh like '%".$factura."%'";
    if ($taller) $sql.= " and j.id_taller =  '".$taller."'";
      if($numdep==5 or $numdep==3 )$numdep=null;
      if($numdep==4)$numdep='1';
    if ($numdep) $sql = $sql." and  e.numdep='".$numdep."' ";
    if ($color) $sql = $sql." and  a.col1veh='".$color."' ";

    if ($placa) $sql.= " and p.numplaveh='".$placa."' ";
    if ($caract) $sql.=" and a.id_caract =$caract";

    $sql=$sql."  group by a.sercarveh ";

   	if ($taller) $sql.= ", j.sercarveh";


    if($tipo){
      $sql=$sql."EXCEPT

		(	select
			count(a.sercarveh), a.sercarveh
			from
			vehiculo a, caracteristica b, marcas c , modelo d , color f, tipos g, $tipo h
			where
			a.estatus='A' and a.id_caract=b.id_caract and b.codmarveh=c.codmar and
			b.codmod=d.codmod  and b.codtipveh=g.codtip ";
			if ($tipo=='asignacion')$sql=$sql." and h.status='A' AND a.sercarveh in (select sercarveh from placas) ";
			$sql=$sql." and a.col1veh=f.codcol  $origenP  and  a.sercarveh=h.sercarveh  group by a.sercarveh )";
    }
    
 //print '<pre>'; print $sql;
   $sql=$sql." ) a ";
   

 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

//                         $sercarveh,$codmar,$modveh,$serveh,'I',$numlotveh,$factura,$offset
 function listadeVehiculos($sercarveh,$codmar,$modveh,$serveh,$origen,$numlotveh,$factura,$tipo,$offset=-1,$taller=null,$tt=null,$numdep=null,$color=null, $placa=null, $caract=null){
 	if ($origen=='I')
 	$origenP="and b.origenveh='I'";
 	else
 	$origenP="and b.origenveh<>'I' ";

 	if ($origen=='T') $origenP=" ";


     $sql = "select
			a.sercarveh as ser,  a.sermotveh , f.descol, a.sernivveh , a.serchaveh ,  a.numhomveh , a.fechomveh,
			(c.desmar||' / '||d.desmod||' / '||COALESCE(desserie(b.codserie),' S/S ')||' / '||b.anomodveh||' / '||g.destip||' / '||b.preveh) as caract,  a.id_caract, '' as txt, a.fecha_reg as fec,
			a.col1veh,  b.numfacveh , descolor(a.col2veh), c.desmar, d.desmod, b.numlotveh";

    //if ($taller) $sql.= ", j.sercarveh";

	$sql .= " from
			vehiculo a, caracteristica b, marcas c , modelo d , color f, tipos g,lote e,departamento k";

         if ($taller or $tt) $sql.= ", vehic_taller j";
         if ($placa) $sql.= ", placas p";

         $sql.=" where
			a.estatus='A' and a.id_caract=b.id_caract and
            b.codmarveh=c.codmar and
            b.numlotveh=e.numlot and
	        e.numdep=k.numdep and
			b.codmod=d.codmod  and b.codtipveh=g.codtip and
			a.col1veh=f.codcol $origenP ";

	if ($taller or $tt) $sql.= " and a.sercarveh=j.sercarveh";
	if ($placa) $sql.= " and a.sercarveh=p.sercarveh";


    if($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
    if($codmar)  $sql=$sql." and b.codmarveh='".$codmar."'";
    if($modveh)  $sql=$sql." and b.codmod='".$modveh."'";
    if($serveh)  $sql=$sql." and b.codserie='".$serveh."'";
    if($numlotveh)  $sql=$sql." and b.numlotveh=".$numlotveh."";
    if($factura)  $sql=$sql." and b.numfacveh like '%".$factura."%'";
    if ($taller) $sql.= " and j.id_taller =  '".$taller."'";
    if($numdep==5 or $numdep==3 )$numdep=null;
    if($numdep==4)$numdep='1';
    if ($numdep) $sql = $sql." and  e.numdep='".$numdep."' ";
     if ($color) $sql = $sql." and  a.col1veh='".$color."' ";

    if ($placa) $sql.= " and p.numplaveh='".$placa."' ";
    if ($caract) $sql.=" and a.id_caract = $caract";
    if ($tipo=='asignacion') $sql=$sql." AND a.sercarveh in (select sercarveh from placas) ";

    if($tipo){
      $sql=$sql."EXCEPT

		(	select
			a.sercarveh ,  a.sermotveh , f.descol, a.sernivveh , a.serchaveh ,  a.numhomveh , a.fechomveh,
			(c.desmar||' / '||d.desmod||' / '||COALESCE(desserie(b.codserie),' S/S ')||' / '||b.anomodveh||' / '||g.destip||' / '||b.preveh) as caract,  a.id_caract, '' as txt, a.fecha_reg,
			a.col1veh,  b.numfacveh , descolor(a.col2veh), c.desmar, d.desmod, b.numlotveh
			from
			vehiculo a, caracteristica b, marcas c , modelo d , color f, tipos g, $tipo h
			where
			a.estatus='A' and a.id_caract=b.id_caract and b.codmarveh=c.codmar and
			b.codmod=d.codmod  and b.codtipveh=g.codtip ";
			if ($tipo=='asignacion')$sql=$sql." and h.status='A' AND a.sercarveh in (select sercarveh from placas) ";
			$sql=$sql." and a.col1veh=f.codcol  $origenP  and  a.sercarveh=h.sercarveh  )";

    }
    
    $sql=$sql." order by fec desc,ser";
   if ($offset>=0) $sql = $sql." LIMIT 25 OFFSET ".$offset;

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function ContVehiculos2($sercarveh,$codmar,$modveh,$serveh,$origen,$numlotveh,$factura,$tipo,$taller=null,$tt=null,$numdep=null){

 	if ($origen=='I')
 	$origenP="and b.origenveh='I'";
 	else
 	$origenP="and b.origenveh<>'I' ";

 	if ($origen=='T') $origenP=" ";

    $sql = "select count(a.sercarveh) from ( select
			count(a.sercarveh), a.sercarveh";

  	//if ($taller) $sql.= ", j.sercarveh";

   	$sql .= " from
			vehiculo a, caracteristica b, marcas c , modelo d , color f, tipos g, departamento k, lote e";


 	if ($taller or $tt) $sql.= ", vehic_taller j";

	$sql.="	where
			a.estatus='A' and a.id_caract=b.id_caract and
            b.codmarveh=c.codmar and
            b.numlotveh=e.numlot and
	        e.numdep=k.numdep and
			b.codmod=d.codmod  and b.codtipveh=g.codtip and
			a.col1veh=f.codcol $origenP  ";


	if ($taller or $tt) $sql.= " and a.sercarveh=j.sercarveh";


    if($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
    if($codmar)  $sql=$sql." and b.codmarveh='".$codmar."'";
    if($modveh)  $sql=$sql." and b.codmod='".$modveh."'";
    if($serveh)  $sql=$sql." and b.codserie='".$serveh."'";
    if($numlotveh)  $sql=$sql." and b.numlotveh=".$numlotveh."";
    if($factura)  $sql=$sql." and b.numfacveh like '%".$factura."%'";
    if ($taller) $sql.= " and j.id_taller =  '".$taller."'";
      if($numdep==5 or $numdep==3 )$numdep=null;
      if($numdep==4)$numdep='1';
    if ($numdep) $sql = $sql." and  e.numdep='".$numdep."' ";
    $sql=$sql."  group by a.sercarveh ";

   	if ($taller) $sql.= ", j.sercarveh";


    if($tipo){
      $sql=$sql."EXCEPT

		(	select
			count(a.sercarveh), a.sercarveh
			from
			vehiculo a, caracteristica b, marcas c , modelo d , color f, tipos g, $tipo h
			where
			a.estatus='A' and a.id_caract=b.id_caract and b.codmarveh=c.codmar and
			b.codmod=d.codmod  and b.codtipveh=g.codtip ";
			if ($tipo=='asignacion')$sql=$sql." and h.status='A' ";
			$sql=$sql." and a.col1veh=f.codcol  $origenP  and  a.sercarveh=h.sercarveh  group by a.sercarveh )";
    }
     // print '<pre>'; print $sql;
   $sql=$sql." ) a ";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

//                         $sercarveh,$codmar,$modveh,$serveh,'I',$numlotveh,$factura,$offset
 function listadeVehiculos2($sercarveh,$codmar,$modveh,$serveh,$origen,$numlotveh,$factura,$tipo,$offset=-1,$taller=null,$tt=null,$numdep=null){
 	if ($origen=='I')
 	$origenP="and b.origenveh='I'";
 	else
 	$origenP="and b.origenveh<>'I' ";

 	if ($origen=='T') $origenP=" ";

     $sql = "select
			a.sercarveh as ser,  a.sermotveh , f.descol, a.sernivveh , a.serchaveh ,  a.numhomveh , a.fechomveh,
			(c.desmar||' / '||d.desmod||' / '||COALESCE(desserie(b.codserie),' S/S ')||' / '||b.anomodveh||' / '||g.destip||' / '||b.preveh) as caract,  a.id_caract, '' as txt, a.fecha_reg as fec,
			a.col1veh,  b.numfacveh , descolor(a.col2veh), c.desmar, d.desmod, b.numlotveh";

    //if ($taller) $sql.= ", j.sercarveh";

	$sql .= " from
			vehiculo a, caracteristica b, marcas c , modelo d , color f, tipos g,lote e,departamento k";

         if ($taller or $tt) $sql.= ", vehic_taller j";
         $sql.=" where
			a.estatus='A' and a.id_caract=b.id_caract and
            b.codmarveh=c.codmar and
            b.numlotveh=e.numlot and
	        e.numdep=k.numdep and
			b.codmod=d.codmod  and b.codtipveh=g.codtip and
			a.col1veh=f.codcol $origenP ";

	if ($taller or $tt) $sql.= " and a.sercarveh=j.sercarveh";

    if($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
    if($codmar)  $sql=$sql." and b.codmarveh='".$codmar."'";
    if($modveh)  $sql=$sql." and b.codmod='".$modveh."'";
    if($serveh)  $sql=$sql." and b.codserie='".$serveh."'";
    if($numlotveh)  $sql=$sql." and b.numlotveh=".$numlotveh."";
    if($factura)  $sql=$sql." and b.numfacveh like '%".$factura."%'";
    if ($taller) $sql.= " and j.id_taller =  '".$taller."'";
    if($numdep==5 or $numdep==3 )$numdep=null;
    if($numdep==4)$numdep='1';
    if ($numdep) $sql = $sql." and  e.numdep='".$numdep."' ";

    if($tipo){
      $sql=$sql."EXCEPT

		(	select
			a.sercarveh ,  a.sermotveh , f.descol, a.sernivveh , a.serchaveh ,  a.numhomveh , a.fechomveh,
			(c.desmar||' / '||d.desmod||' / '||COALESCE(desserie(b.codserie),' S/S ')||' / '||b.anomodveh||' / '||g.destip||' / '||b.preveh) as caract,  a.id_caract, '' as txt, a.fecha_reg,
			a.col1veh,  b.numfacveh , descolor(a.col2veh), c.desmar, d.desmod, b.numlotveh
			from
			vehiculo a, caracteristica b, marcas c , modelo d , color f, tipos g, $tipo h
			where
			a.estatus='A' and a.id_caract=b.id_caract and b.codmarveh=c.codmar and
			b.codmod=d.codmod  and b.codtipveh=g.codtip ";
			if ($tipo=='asignacion')$sql=$sql." and h.status='A' ";
			$sql=$sql." and a.col1veh=f.codcol  $origenP  and  a.sercarveh=h.sercarveh AND a.sercarveh in (select sercarveh from placas)  )";

    }
    $sql=$sql." order by fec desc,ser";
   if ($offset>=0) $sql = $sql." LIMIT 25 OFFSET ".$offset;

//  print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

//Vehiculos sin placa
function listVehsinplaca($codmar=null,$modveh=null,$sercarveh=null,$numlotveh=null,$color=null,$offset=null,$sta=null){

$sql = "select
a.sercarveh as ser,  a.sermotveh , f.descol, a.sernivveh , a.serchaveh ,  a.numhomveh , a.fechomveh,
(c.desmar||' / '||d.desmod||' / '||COALESCE(desserie(b.codserie),' S/S ')||' / '||b.anomodveh||' / '||g.destip||' / '||b.preveh)
as caract,  a.id_caract, '' as txt, a.fecha_reg as fec,
a.col1veh,  b.numfacveh , descolor(a.col2veh), c.desmar, d.desmod, b.numlotveh from
vehiculo a, caracteristica b, marcas c , modelo d , color f, tipos g,lote e,departamento k where
a.id_caract=b.id_caract and
b.codmarveh=c.codmar and
b.numlotveh=e.numlot and
e.numdep=k.numdep and
b.codmod=d.codmod  and b.codtipveh=g.codtip and
a.col1veh=f.codcol";
    if($sta)  $sql.=" and a.estatus='".$sta."'";
	if($codmar)  $sql.=" and b.codmarveh='".$codmar."'";
    if($modveh)  $sql.=" and b.codmod='".$modveh."'";
    if($sercarveh)  $sql.=" and a.sercarveh like '%".$sercarveh."%'";
	if($numlotveh)  $sql.=" and b.numlotveh=".$numlotveh."";
	if($color)  $sql.=" and a.col1veh='".$color."'";

 //$sql.= " AND a.sercarveh  not in (select sercarveh from placas)";
 $sql.= " AND a.sercarveh in (SELECT sercarveh FROM vehiculo t1 EXCEPT SELECT sercarveh FROM placas t2)";

  if ($offset>=0) $sql.=" LIMIT 25 OFFSET ".$offset;


  //echo "<pre>"."Lista vehiculos sin placa: ".$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
}

//Busca vehiculos marcados como E (no pasaron PDI)
function listVehNoPDI($codmar=null,$modveh=null,$sercarveh=null,$numlotveh=null,$color=null,$asigna=null,$offset=null,$placa=null){

$sql = "select a.numlotveh,f.desmar,e.desmod,b.sercarveh,b.sernivveh,c.descol,d.numplaveh";

if ($asigna=='AS')
	$sql.= " ,g.id_asignacion,g.status,g.codpro,i.descripcion,to_char(h.fecha_estatus,'dd/mm/yyyy')";

$sql.= " , b.observaciones ";

$sql.= " from
  color c,modelo e,marcas f,caracteristica a";

if ($asigna=='AS')
	$sql.= " ,estatus i";

$sql.= ",vehiculo b left outer join placas d on b.sercarveh=d.sercarveh";

if ($asigna=='AS')
	$sql.= " left outer join asignacion g on g.sercarveh=b.sercarveh
inner join facturaprof h on h.id_asignacion=g.id_asignacion";

$sql.= " where  c.codcol = b.col1veh AND e.codmod = a.codmod AND  f.codmar = a.codmarveh AND a.id_caract = b.id_caract and b.estatus='E'";

if ($asigna=='AS')
   $sql.= " and g.status='A' and i.id_estatus=h.id_estatus";

    if($codmar)  $sql.=" and a.codmarveh='".$codmar."'";
    if($modveh)  $sql.=" and a.codmod='".$modveh."'";
    if($sercarveh)  $sql.=" and b.sercarveh like '%".$sercarveh."%'";
	if($numlotveh)  $sql.=" and a.numlotveh=".$numlotveh."";
	if($color)  $sql.=" and b.col1veh='".$color."'";
    if($placa)  $sql.=" and d.numplaveh='".$placa."'";

$sql.= " order by b.sercarveh";

  if ($offset>=0) $sql.=" LIMIT 25 OFFSET ".$offset;

 //echo "Lista vehiculos no PDI: ".$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
}


//Busca vehiculos marcados como E (no pasaron PDI)
function listVehNoPDI2($codmar=null,$modveh=null,$sercarveh=null,$numlotveh=null,$color=null,$asigna=null,$offset=null,$placa=null,$nivel=null){

$sql = "select a.numlotveh,f.desmar,e.desmod,b.sercarveh,b.sernivveh,c.descol,d.numplaveh";

if ($asigna=='AS')
	$sql.= " ,g.id_asignacion,g.status,g.codpro,i.descripcion,to_char(h.fecha_estatus,'dd/mm/yyyy')";

$sql.= " , b.observaciones, x.nivel ";

$sql.= "  from
  color c,modelo e,marcas f,caracteristica a";

if ($asigna=='AS')
	$sql.= " ,estatus i";

$sql.= ",vehiculo b left outer join placas d on b.sercarveh=d.sercarveh";

if ($asigna=='AS')
	$sql.= " left outer join asignacion g on g.sercarveh=b.sercarveh
inner join facturaprof h on h.id_asignacion=g.id_asignacion";

$sql.= " left outer join nivel_pdi x on x.id=b.nivel_pdi ";

$sql.= " where  c.codcol = b.col1veh AND e.codmod = a.codmod AND  f.codmar = a.codmarveh AND a.id_caract = b.id_caract and b.estatus='E'  ";

if ($asigna=='AS')
   $sql.= " and g.status='A' and i.id_estatus=h.id_estatus";

    if($codmar)  $sql.=" and a.codmarveh='".$codmar."'";
    if($modveh)  $sql.=" and a.codmod='".$modveh."'";
    if($sercarveh)  $sql.=" and b.sercarveh like '%".$sercarveh."%'";
	if($numlotveh)  $sql.=" and a.numlotveh=".$numlotveh."";
	if($color)  $sql.=" and b.col1veh='".$color."'";
    if($placa)  $sql.=" and d.numplaveh='".$placa."'";
    if($nivel)  $sql.=" and h.id='".$nivel."'";

$sql.= " order by b.sercarveh";

  if ($offset>=0) $sql.=" LIMIT 25 OFFSET ".$offset;

 // echo "<pre>".$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
}

//marca vehiculos como no PDI
 function bloquearVehiculo($sercarveh,$comentario,$nivel){

 	$fecha=date('d/m/Y');
 	$sql = "UPDATE vehiculo SET estatus='E',fecha_mod='".$fecha."', observaciones='".$comentario."', nivel_pdi='$nivel' WHERE sercarveh = '".$sercarveh."'";
 	//$sql = "UPDATE vehiculo SET estatus='E',fecha_mod='".$fecha."', observaciones=observaciones||'".$comentario."' WHERE sercarveh = '".$sercarveh."'";
 	//echo "AQUI ".$sql;

    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);

    if ($consulta){
 	$sql1 = "SELECT  c.id_preinv
			FROM
			  caracteristica a,
			  vehiculo b,
			  preinventario c
			WHERE
			  a.id_caract = b.id_caract AND  c.numlotveh=a.numlotveh AND a.codmod=c.id_modelo and b.sercarveh='".$sercarveh."'";

   // print '<br>Busco Preinv '.$sql1;
    $conexion = $this->conectar();
    $consulta1 = $this->consultar($conexion,$sql1);
    $consulta1 = $this->ret_vector($consulta1);
    //$this->desconectar($conexion);

    //echo "<br>ID preinv: ".$consulta1[0];

    $sql2 = "select existencia from existencia where id_preinv=$consulta1[0]";

 	  //echo "<br>El va a restar de: ".$sql2;

 	  $conexion = $this->conectar();
	  $consulta2 = $this->consultar($conexion,$sql2);
	  $consulta2 = $this->ret_vector($consulta2);

	  if ($consulta2)
	  {
	  	if ($consulta2[0]>0){
	  	 $dcto = $consulta2[0]-1;
	  	 $sql3 = "update existencia set existencia=$dcto  where id_preinv=$consulta1[0]";

	  	 //echo "<br>Actualiza: ".$sql3;

	  	 $consulta3 = $this->consultar($conexion,$sql3);
    	 $this->desconectar($conexion);
	  	}
	  }
    }

    if($consulta3) $this->auditar('MODIFICACION',$sql,'Marco PDI no aprobado a vehiculo '.$sercarveh);

	return $consulta3;

 }

//desmarcar vehiculos que no pasaron PDI
 function activarVehiculo($sercarveh,$comentario){
 	$fecha=date('d/m/Y');
 	$sql = "UPDATE vehiculo SET estatus='A',fecha_mod='".$fecha."', observaciones=observaciones||'".$comentario."' WHERE sercarveh = '".$sercarveh."'";
 	//echo $sql;

    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);

    if ($consulta){
 	$sql1 = "SELECT  c.id_preinv
			FROM
			  caracteristica a,
			  vehiculo b,
			  preinventario c
			WHERE
			  a.id_caract = b.id_caract AND  c.numlotveh=a.numlotveh AND a.codmod=c.id_modelo and b.sercarveh='".$sercarveh."'";

   // print '<br>Busco Preinv '.$sql1;
    $conexion = $this->conectar();
    $consulta1 = $this->consultar($conexion,$sql1);
    $consulta1 = $this->ret_vector($consulta1);
    //$this->desconectar($conexion);

  //  echo "<br>ID preinv: ".$consulta1[0];

    $sql2 = "select existencia from existencia where id_preinv=$consulta1[0]";

 	 // echo "<br>El va a sumar de: ".$sql2;

 	  $conexion = $this->conectar();
	  $consulta2 = $this->consultar($conexion,$sql2);
	  $consulta2 = $this->ret_vector($consulta2);

	  if ($consulta2)
	  {
	  	 $aumento = $consulta2[0]+1;

	  	// echo "Aumento: ".$aumento;
	  	 $sql3 = "update existencia set existencia=$aumento  where id_preinv=$consulta1[0]";

	  	// echo "<br>Actualiza: ".$sql3;

	  	 $consulta3 = $this->consultar($conexion,$sql3);
    	 $this->desconectar($conexion);
	  }
    }

    if($consulta3) $this->auditar('MODIFICACION',$sql,'Marco vehiculo '.$sercarveh.' como PDI aprobado');

	return $consulta3;

 }


//Funcion para buscar precio del vehiculo segun el sercarveh
function precioVehiculo($sercarveh)
{
	$sql = "select precioveh(sercarveh) from asignacion where status='A' and sercarveh='".$sercarveh."'";

	//echo $sql;
	$conexion = $this->conectar();
  	$consulta = $this->consultar($conexion,$sql);
  	$consulta = $this->ret_vector($consulta);

  	return $consulta[0];

}

//Funcion para llenar combo Niveles NO PDI
function comboNoPDI($nivel=null)
{
	$sql = "select * from nivel_pdi where status='A'";
	if ($nivel) $sql.= " and nivel='".$nivel."'";

	//echo $sql;
	$conexion = $this->conectar();
  	$consulta = $this->consultar($conexion,$sql);
  	$consulta = $this->ret_vector($consulta);

  	return $consulta;

}


//modificar datos de vehiculos marcados como no PDI
 function bloquearVehiculo1($sercarveh,$comentario,$nivel){
  	$fecha=date('d/m/Y');

 	$sql = "UPDATE vehiculo SET estatus='E',fecha_mod='".$fecha."', observaciones='".$comentario."', nivel_pdi='$nivel' WHERE sercarveh = '".$sercarveh."'";

 	//echo "AQUI ".$sql;

    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);

    if($consulta) $this->auditar('MODIFICACION',$sql,'Modifico datos de PDI no aprobado a vehiculo '.$sercarveh);

	return $consulta;

 }

/*
 function reporteMincoSuvinca($lote=null)
{
	$sql = "select
					x.numlotveh, y.desmod , x.cantidad as existencia,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and f.id_estatus='15' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as entregados,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and f.id_estatus<>'15' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as asignados,
					(
					SELECT COUNT(d.sercarveh)
					FROM
					vehiculo d
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					d.estatus='E' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as NoPdi,
					(
					select existencia
					from
					existencia
					where id_preinv=x.id_preinv
					) as inventario,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and d.estatus='E' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as NoPdiAsig,
					(
					select
					count(a.sercarveh )
					from
					vehiculo a, caracteristica b where
					a.id_caract=b.id_caract and a.estatus='A' and b.codmod=x.id_modelo and
					b.codmarveh='C7' and b.numlotveh=x.numlotveh AND a.sercarveh not in ('0','1','2') and
					a.sercarveh  not in (select sercarveh from placas)
					) as SinPlacaAct,
					(
					select
					count(a.sercarveh )
					from
					vehiculo a, caracteristica b where
					a.id_caract=b.id_caract and a.estatus='E' and b.codmod=x.id_modelo and
					b.codmarveh='C7' and b.numlotveh=x.numlotveh AND a.sercarveh not in ('0','1','2') and
					a.sercarveh  not in (select sercarveh from placas)
					) as SinPlacaNoPdi,
					(
					SELECT COUNT(b.id_asignacion)
					FROM
					asignacion b
					INNER JOIN vehiculo d 		 ON (d.sercarveh = b.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					b.status='A' and d.estatus='A' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh and
					b.id_asignacion  not in (select id_asignacion from facturaprof)
					) as asignadosSinFac,
					(
				    select count(a.id_asignacion)
					from
					asignacion a
					inner join propietarios f on a.codpro=f.codpro
					inner join preinventario e on a.id_preinv=e.id_preinv
					inner join marcas b on e.id_marca=b.codmar
					inner join modelo c on e.id_modelo=c.codmod
					where a.status ='A' and e.id_modelo=x.id_modelo and
					((a.sercarveh='0') or (a.sercarveh='1') or (a.sercarveh='2'))
					and e.id_marca='C7' and e.numlotveh=x.numlotveh
					) as preinv, x.id_preinv
					from
					preinventario x , modelo y
					where
					x.id_modelo=y.codmod ";
if ($lote) $sql.= " and x.numlotveh='".$lote."'";
		   $sql.= "	order by x.numlotveh, x.id_preinv";


    echo '<pre>'.$sql;
	$conexion = $this->conectar();
  	$consulta = $this->consultar($conexion,$sql);
  	$consulta = $this->ret_vector($consulta);
  	return $consulta;

}*/

function reporteMincoSuvinca($lote=null)
{
	$sql = "select
					x.numlotveh, y.desmod , x.cantidad as existencia,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and f.id_estatus='15' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as entregados,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and f.id_estatus<>'15' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as asignados,
					(
					SELECT COUNT(d.sercarveh)
					FROM
					vehiculo d
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					d.estatus='E' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as NoPdi,
					(
					select existencia
					from
					existencia
					where id_preinv=x.id_preinv
					) as inventario,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and d.estatus='E' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as NoPdiAsig,
					(
					select
					count(a.sercarveh )
					from
					vehiculo a, caracteristica b where
					a.id_caract=b.id_caract and a.estatus='A' and b.codmod=x.id_modelo and
					b.codmarveh='C7' and b.numlotveh=x.numlotveh AND a.sercarveh not in ('0','1','2','3','4','5','6','7')
					and a.sercarveh in (SELECT sercarveh FROM vehiculo t1 EXCEPT SELECT sercarveh FROM placas t2)
					) as SinPlacaAct,
					(
					select
					count(a.sercarveh )
					from
					vehiculo a, caracteristica b where
					a.id_caract=b.id_caract and a.estatus='E' and b.codmod=x.id_modelo and
					b.codmarveh='C7' and b.numlotveh=x.numlotveh AND a.sercarveh not in ('0','1','2','3','4','5','6','7')
					and a.sercarveh in (SELECT sercarveh FROM vehiculo t1 EXCEPT SELECT sercarveh FROM placas t2)
					) as SinPlacaNoPdi,
					(
					SELECT COUNT(b.id_asignacion)
					FROM
					asignacion b
					INNER JOIN vehiculo d 		 ON (d.sercarveh = b.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					b.status='A' and d.estatus='A' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh and
					b.id_asignacion  not in (select id_asignacion from facturaprof)
					) as asignadosSinFac,
					(
				    select count(a.id_asignacion)
					from
					asignacion a
					inner join propietarios f on a.codpro=f.codpro
					inner join preinventario e on a.id_preinv=e.id_preinv
					inner join marcas b on e.id_marca=b.codmar
					inner join modelo c on e.id_modelo=c.codmod
					where a.status ='A' and e.id_modelo=x.id_modelo and
					((a.sercarveh='0') or (a.sercarveh='1') or (a.sercarveh='2') or (a.sercarveh='3') or (a.sercarveh='4') or (a.sercarveh='5')
							or (a.sercarveh='6') or (a.sercarveh='7'))
					and e.id_marca='C7' and e.numlotveh=x.numlotveh
					) as preinv, x.id_preinv
					from
					preinventario x , modelo y
					where
					x.id_modelo=y.codmod ";
if ($lote) $sql.= " and x.numlotveh='".$lote."'";
		   $sql.= "	order by x.numlotveh, x.id_preinv";


    //echo '<pre>'.$sql;
	$conexion = $this->conectar();
  	$consulta = $this->consultar($conexion,$sql);
  	$consulta = $this->ret_vector($consulta);
  	return $consulta;

}
/*
 function reporteMincoSuvinca2()
{
	$sql = "select z.desmod, sum(z.existencia) as existentes, sum(z.entregados) as entrega2,
sum(z.asignados) as asigna2, sum(z.NoPdi) as noapto,sum(z.inventario) as invent,
sum(z.NoPdiAsig) as asignopdi, sum(z.SinPlacaAct) as sinplaquear,
sum(z.SinPlacaNoPdi) as sinplaquearnopdi,sum(z.asignadosSinFac) as asigna2sinfact,
sum(z.preinv) as encampo
 from (select
					x.numlotveh, y.desmod , x.cantidad as existencia,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and f.id_estatus='15' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as entregados,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and f.id_estatus<>'15' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as asignados,
					(
					SELECT COUNT(d.sercarveh)
					FROM
					vehiculo d
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					d.estatus='E' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as NoPdi,
					(
					select existencia
					from
					existencia
					where id_preinv=x.id_preinv
					) as inventario,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and d.estatus='E' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as NoPdiAsig,
					(
					select
					count(a.sercarveh )
					from
					vehiculo a, caracteristica b where
					a.id_caract=b.id_caract and a.estatus='A' and b.codmod=x.id_modelo and
					b.codmarveh='C7' and b.numlotveh=x.numlotveh AND a.sercarveh not in ('0','1','2','3','4','5','6','7')
					and a.sercarveh  not in (select sercarveh from placas)
					) as SinPlacaAct,
					(
					select
					count(a.sercarveh )
					from
					vehiculo a, caracteristica b where
					a.id_caract=b.id_caract and a.estatus='E' and b.codmod=x.id_modelo and
					b.codmarveh='C7' and b.numlotveh=x.numlotveh AND a.sercarveh not in ('0','1','2','3','4','5','6','7') and
					a.sercarveh  not in (select sercarveh from placas)
					) as SinPlacaNoPdi,
					(
					SELECT COUNT(b.id_asignacion)
					FROM
					asignacion b
					INNER JOIN vehiculo d 		 ON (d.sercarveh = b.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					b.status='A' and d.estatus='A' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh and
					b.id_asignacion  not in (select id_asignacion from facturaprof)
					) as asignadosSinFac,
					(
				    select count(a.id_asignacion)
					from
					asignacion a
					inner join propietarios f on a.codpro=f.codpro
					inner join preinventario e on a.id_preinv=e.id_preinv
					inner join marcas b on e.id_marca=b.codmar
					inner join modelo c on e.id_modelo=c.codmod
					where a.status ='A' and e.id_modelo=x.id_modelo and
					((a.sercarveh='0') or (a.sercarveh='1') or (a.sercarveh='2') or (a.sercarveh='3') or (a.sercarveh='4') or (a.sercarveh='5')
							or (a.sercarveh='6') or (a.sercarveh='7'))
					and e.id_marca='C7' and e.numlotveh=x.numlotveh
					) as preinv, x.id_preinv
					from
					preinventario x , modelo y
					where
					x.id_modelo=y.codmod 	order by x.numlotveh, x.id_preinv) z
group by z.desmod
order by z.desmod";


   //echo '<pre>'.$sql;
	$conexion = $this->conectar();
  	$consulta = $this->consultar($conexion,$sql);
  	$consulta = $this->ret_vector($consulta);
  	return $consulta;

}*/


 function reporteMincoSuvinca2()
{
	$sql = "select z.desmod, sum(z.existencia) as existentes, sum(z.entregados) as entrega2,
sum(z.asignados) as asigna2, sum(z.NoPdi) as noapto,sum(z.inventario) as invent,
sum(z.NoPdiAsig) as asignopdi, sum(z.SinPlacaAct) as sinplaquear,
sum(z.SinPlacaNoPdi) as sinplaquearnopdi,sum(z.asignadosSinFac) as asigna2sinfact,
sum(z.preinv) as encampo
 from (select
					x.numlotveh, y.desmod , x.cantidad as existencia,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and f.id_estatus='15' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as entregados,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and f.id_estatus<>'15' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as asignados,
					(
					SELECT COUNT(d.sercarveh)
					FROM
					vehiculo d
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					d.estatus='E' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as NoPdi,
					(
					select existencia
					from
					existencia
					where id_preinv=x.id_preinv
					) as inventario,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and d.estatus='E' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as NoPdiAsig,
					(
					select
					count(a.sercarveh )
					from
					vehiculo a, caracteristica b where
					a.id_caract=b.id_caract and a.estatus='A' and b.codmod=x.id_modelo and
					b.codmarveh='C7' and b.numlotveh=x.numlotveh AND a.sercarveh not in ('0','1','2','3','4','5','6','7')
					and a.sercarveh in (SELECT sercarveh FROM vehiculo t1 EXCEPT SELECT sercarveh FROM placas t2)
					) as SinPlacaAct,
					(
					select
					count(a.sercarveh )
					from
					vehiculo a, caracteristica b where
					a.id_caract=b.id_caract and a.estatus='E' and b.codmod=x.id_modelo and
					b.codmarveh='C7' and b.numlotveh=x.numlotveh AND a.sercarveh not in ('0','1','2','3','4','5','6','7')
					and a.sercarveh in (SELECT sercarveh FROM vehiculo t1 EXCEPT SELECT sercarveh FROM placas t2)
					) as SinPlacaNoPdi,
					(
					SELECT COUNT(b.id_asignacion)
					FROM
					asignacion b
					INNER JOIN vehiculo d 		 ON (d.sercarveh = b.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					b.status='A' and d.estatus='A' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh and
					b.id_asignacion  not in (select id_asignacion from facturaprof)
					) as asignadosSinFac,
					(
				    select count(a.id_asignacion)
					from
					asignacion a
					inner join propietarios f on a.codpro=f.codpro
					inner join preinventario e on a.id_preinv=e.id_preinv
					inner join marcas b on e.id_marca=b.codmar
					inner join modelo c on e.id_modelo=c.codmod
					where a.status ='A' and e.id_modelo=x.id_modelo and
					((a.sercarveh='0') or (a.sercarveh='1') or (a.sercarveh='2') or (a.sercarveh='3') or (a.sercarveh='4') or (a.sercarveh='5')
							or (a.sercarveh='6') or (a.sercarveh='7'))
					and e.id_marca='C7' and e.numlotveh=x.numlotveh
					) as preinv, x.id_preinv
					from
					preinventario x , modelo y
					where
					x.id_modelo=y.codmod and x.numlotveh in (19,20,21,22)	order by x.numlotveh, x.id_preinv) z
group by z.desmod
order by z.desmod";


    //echo '<pre>'.$sql;
	$conexion = $this->conectar();
  	$consulta = $this->consultar($conexion,$sql);
  	$consulta = $this->ret_vector($consulta);
  	return $consulta;

}

function reporteMincoSuvinca3()
{
	$sql = "select z.desmod, sum(z.existencia) as existentes, sum(z.entregados) as entrega2,
sum(z.asignados) as asigna2, sum(z.NoPdi) as noapto,sum(z.inventario) as invent,
sum(z.NoPdiAsig) as asignopdi, sum(z.SinPlacaAct) as sinplaquear,
sum(z.SinPlacaNoPdi) as sinplaquearnopdi,sum(z.asignadosSinFac) as asigna2sinfact,
sum(z.preinv) as encampo
 from (select
					x.numlotveh, y.desmod , x.cantidad as existencia,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and f.id_estatus='15' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as entregados,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and f.id_estatus<>'15' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as asignados,
					(
					SELECT COUNT(d.sercarveh)
					FROM
					vehiculo d
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					d.estatus='E' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as NoPdi,
					(
					select existencia
					from
					existencia
					where id_preinv=x.id_preinv
					) as inventario,
					(
					SELECT COUNT(id_numfac)
					FROM facturaprof f
					INNER JOIN asignacion b 	 ON (b.id_asignacion = f.id_asignacion)
					INNER JOIN vehiculo d 		 ON (d.sercarveh = f.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					f.estatus='A' and b.status='A' and d.estatus='E' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh
					) as NoPdiAsig,
					(
					select
					count(a.sercarveh )
					from
					vehiculo a, caracteristica b where
					a.id_caract=b.id_caract and a.estatus='A' and b.codmod=x.id_modelo and
					b.codmarveh='C7' and b.numlotveh=x.numlotveh AND a.sercarveh not in ('0','1','2','3','4','5','6','7')
					and a.sercarveh in (SELECT sercarveh FROM vehiculo t1 EXCEPT SELECT sercarveh FROM placas t2)
					) as SinPlacaAct,
					(
					select
					count(a.sercarveh )
					from
					vehiculo a, caracteristica b where
					a.id_caract=b.id_caract and a.estatus='E' and b.codmod=x.id_modelo and
					b.codmarveh='C7' and b.numlotveh=x.numlotveh AND a.sercarveh not in ('0','1','2','3','4','5','6','7')
					and a.sercarveh in (SELECT sercarveh FROM vehiculo t1 EXCEPT SELECT sercarveh FROM placas t2)
					) as SinPlacaNoPdi,
					(
					SELECT COUNT(b.id_asignacion)
					FROM
					asignacion b
					INNER JOIN vehiculo d 		 ON (d.sercarveh = b.sercarveh)
					INNER JOIN caracteristica e ON (e.id_caract = d.id_caract)
					WHERE
					b.status='A' and d.estatus='A' and
					e.codmarveh='C7' and e.codmod=x.id_modelo and e.numlotveh=x.numlotveh and
					b.id_asignacion  not in (select id_asignacion from facturaprof)
					) as asignadosSinFac,
					(
				    select count(a.id_asignacion)
					from
					asignacion a
					inner join propietarios f on a.codpro=f.codpro
					inner join preinventario e on a.id_preinv=e.id_preinv
					inner join marcas b on e.id_marca=b.codmar
					inner join modelo c on e.id_modelo=c.codmod
					where a.status ='A' and e.id_modelo=x.id_modelo and
					((a.sercarveh='0') or (a.sercarveh='1') or (a.sercarveh='2') or (a.sercarveh='3') or (a.sercarveh='4') or (a.sercarveh='5')
							or (a.sercarveh='6') or (a.sercarveh='7'))
					and e.id_marca='C7' and e.numlotveh=x.numlotveh
					) as preinv, x.id_preinv
					from
					preinventario x , modelo y
					where
					x.id_modelo=y.codmod and x.numlotveh in (26,28,29,32,33)	order by x.numlotveh, x.id_preinv) z
group by z.desmod
order by z.desmod";


	//echo '<pre>'.$sql;
	$conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$consulta = $this->ret_vector($consulta);
	return $consulta;

}

}
?>