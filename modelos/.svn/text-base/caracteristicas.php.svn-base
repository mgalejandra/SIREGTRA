<?php
class caracteristicas extends conexion{

 function registrarCaracteristicasImp($data){

  $fecha=date('d/m/Y');
  $sql = "INSERT INTO caracteristica(
  		   numlotveh ,  codmarveh ,   codmod , codserie ,   anomodveh ,  pesveh ,  tipcapveh ,
		   capcarveh ,  numejeveh ,  diarueveh , anofabveh ,
		   numpueveh ,   codconveh , preveh,
		   codptoveh ,  numlicveh , fecplaveh , numfacveh ,  fecfacveh ,origenveh,
		   codclaveh, codtipveh, codserveh , codusoveh , fecha_reg )
         values
           (".$data[0].",'".$data[1]."','".$data[2]."','".$data[3]."',".$data[4].",".$data[5].",".$data[6].",
           	".$data[7].",".$data[8].",".$data[9].",'".$data[10]."','".$data[11]."','".$data[12]."','".$data[13]."',
           	'".$data[14]."','".$data[15]."','".$data[16]."','".$data[17]."','".$data[18]."','".$data[19]."','".$data[20]."',
           	'".$data[21]."','".$data[22]."','".$data[23]."','".$fecha."')";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
   $this->desconectar($conexion);
 if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/caracteristica_veh_imp.php');

  return $consulta;
 }

  function registrarCaracteristicasNac($data){

  $fecha=date('d/m/Y');

  $sql = "INSERT INTO caracteristica(
  		   numlotveh ,  codmarveh ,   codmod , codserie ,   anomodveh ,  pesveh ,  tipcapveh ,
		   capcarveh ,  numejeveh ,  diarueveh , anofabveh , numpueveh ,   codconveh , preveh,  origenveh,
		   codclaveh, codtipveh, codserveh , codusoveh , fecha_reg )
         values
           (".$data[0].",'".$data[1]."','".$data[2]."','".$data[3]."',".$data[4].",".$data[5].",".$data[6].",
           	".$data[7].",".$data[8].",".$data[9].",'".$data[10]."','".$data[11]."','".$data[12]."','".$data[13]."',
           	'".$data[14]."','".$data[15]."','".$data[16]."','".$data[17]."','".$data[18]."','".$fecha."')";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/caracteristica_veh_nac.php');

  return $consulta;
 }

  function listarCaracteristicasNac($idcaract,$codmar,$modveh,$serveh){

  $fecha=date('d/m/Y');

  $sql = "select
			a.id_caract, (a.numlotveh||' - '||e.deslot) as lote,  b.desmar ,   c.desmod , desserie(a.codserie) ,   a.anomodveh ,
			a.origenveh,  a.pesveh ,  a.tipcapveh ,
			a.capcarveh ,  a.numejeveh ,  a.diarueveh , a.anofabveh ,a.numpueveh , a.codconveh , a.preveh,  a.origenveh,
			a.codserveh , a.codclaveh , a.codtipveh , a.codusoveh , a.fecha_reg, a.codmarveh, a.codmod, a.codserie,
		    a.numlotveh, f.descon, g.descla, h.destip, i.desuso, j.desser
			from
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,departamento k
			where
			a.codmarveh=b.codmar and
			a.codmod=c.codmod  and
			a.numlotveh=e.numlot and
			a.codconveh=f.codcon and
			a.codclaveh=g.codcla and
			a.codtipveh=h.codtip  and
			a.codusoveh=i.coduso  and
			a.codserveh=j.codser and a.origenveh<>'I' ";
    if($idcaract)  $sql=$sql." and a.id_caract='".$idcaract."'";
    if($codmar)  $sql=$sql." and a.codmarveh='".$codmar."'";
    if($modveh)  $sql=$sql." and a.codmod='".$modveh."'";
    if($serveh)  $sql=$sql." and a.codserie='".$serveh."'";
    $sql=$sql." order by a.id_caract";

 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


  function listarCaracteristicasNaci($idcaract,$codmar,$modveh,$serveh,$offset,$numdep=null){

  $fecha=date('d/m/Y');

  $sql = "select
			a.id_caract, (a.numlotveh||' - '||e.deslot) as lote,  b.desmar ,   c.desmod , desserie(a.codserie) ,   a.anomodveh ,
			a.origenveh,  a.pesveh ,  a.tipcapveh ,
			a.capcarveh ,  a.numejeveh ,  a.diarueveh , a.anofabveh ,a.numpueveh , a.codconveh , a.preveh,  a.origenveh,
			a.codserveh , a.codclaveh , a.codtipveh , a.codusoveh , a.fecha_reg, a.codmarveh, a.codmod, a.codserie,
		    a.numlotveh, f.descon, g.descla, h.destip, i.desuso, j.desser
			from
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j,departamento k
			where
			a.codmarveh=b.codmar and
			a.codmod=c.codmod  and
			a.numlotveh=e.numlot and
			e.numdep=k.numdep and
			a.codconveh=f.codcon and
			a.codclaveh=g.codcla and
			a.codtipveh=h.codtip  and
			a.codusoveh=i.coduso  and
			a.codserveh=j.codser and a.origenveh<>'I' ";
    if($idcaract)  $sql=$sql." and a.id_caract='".$idcaract."'";
    if($codmar)  $sql=$sql." and a.codmarveh='".$codmar."'";
    if($modveh)  $sql=$sql." and a.codmod='".$modveh."'";
    if($serveh)  $sql=$sql." and a.codserie='".$serveh."'";
    if($numdep==5 or $numdep==3 )$numdep=null;
    if ($numdep) $sql = $sql." and  e.numdep='".$numdep."' ";
    $sql=$sql." order by a.id_caract";
    $sql = $sql." LIMIT 15 OFFSET  ".$offset;

 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function contarCaracteristicasNaci($idcaract,$codmar,$modveh,$serveh,$numdep=null){

  $fecha=date('d/m/Y');

  $sql = "select
			count(a.id_caract)
			from
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j, departamento k
			where
			a.codmarveh=b.codmar and
			a.codmod=c.codmod  and
			a.numlotveh=e.numlot and
			e.numdep=k.numdep and
			a.codconveh=f.codcon and
			a.codclaveh=g.codcla and
			a.codtipveh=h.codtip  and
			a.codusoveh=i.coduso  and
			a.codserveh=j.codser and a.origenveh<>'I' ";
    if($idcaract)  $sql=$sql." and a.id_caract='".$idcaract."'";
    if($codmar)  $sql=$sql." and a.codmarveh='".$codmar."'";
    if($modveh)  $sql=$sql." and a.codmod='".$modveh."'";
    if($serveh)  $sql=$sql." and a.codserie='".$serveh."'";
    if($numdep==5 or $numdep==3 )$numdep=null;
    if ($numdep) $sql = $sql." and  e.numdep='".$numdep."' ";

 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

 function listarCaracteristicasImp($idcaract,$codmar,$modveh,$serveh,$lote,$factura,$planilla,$caract){

  $fecha=date('d/m/Y');

  $sql = "select
			a.id_caract, (a.numlotveh||' - '||e.deslot) as lote,  b.desmar ,   c.desmod , desserie(a.codserie),   a.anomodveh ,
			a.origenveh,  a.pesveh ,  a.tipcapveh ,
			a.capcarveh ,  a.numejeveh ,  a.diarueveh , a.anofabveh ,a.numpueveh , a.codconveh , a.preveh,  a.origenveh,
			a.codserveh , a.codclaveh , a.codtipveh , a.codusoveh , a.fecha_reg, a.codmarveh, a.codmod, a.codserie,
		    a.numlotveh, f.descon, g.descla, h.destip, i.desuso, j.desser,
		    a.codptoveh, k.despto, to_char(a.fecplaveh,'dd/mm/yyyy') as fechapla, a.numfacveh, to_char(a.fecfacveh,'dd/mm/yyyy') as fechafac, a.numlicveh
			from
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j, ptoadu k
			where
			a.codmarveh=b.codmar and
			a.codmod=c.codmod  and
			a.numlotveh=e.numlot and
			a.codconveh=f.codcon and
			a.codclaveh=g.codcla and
			a.codtipveh=h.codtip  and
			a.codusoveh=i.coduso and
			a.codptoveh=k.codpto  and
			a.codserveh=j.codser and a.origenveh='I' ";
    if($idcaract)  $sql=$sql." and a.id_caract='".$idcaract."'";
    if($codmar)  $sql=$sql." and a.codmarveh='".$codmar."'";
    if($modveh)  $sql=$sql." and a.codmod='".$modveh."'";
    if($serveh)  $sql=$sql." and a.codserie='".$serveh."'";
    if($lote)  $sql=$sql." and a.numlotveh='".$lote."'";
    if($factura)  $sql=$sql." and a.numfacveh like '%".$factura."%'";
    if($planilla)  $sql=$sql." and a.numlicveh like '%".$planilla."%'";
    if($caract)  $sql=$sql." and a.id_caract='".$caract."'";
    $sql=$sql." order by a.id_caract";
 

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


 function listarCaracteristicasImpo($idcaract,$codmar,$modveh,$serveh,$lote,$factura,$planilla,$offset,$numdep=null){

  $fecha=date('d/m/Y');

  $sql = "select
			a.id_caract, (a.numlotveh||' - '||e.deslot) as lote,  b.desmar ,   c.desmod , desserie(a.codserie),   a.anomodveh ,
			a.origenveh,  a.pesveh ,  a.tipcapveh ,
			a.capcarveh ,  a.numejeveh ,  a.diarueveh , a.anofabveh ,a.numpueveh , a.codconveh , a.preveh,  a.origenveh,
			a.codserveh , a.codclaveh , a.codtipveh , a.codusoveh , a.fecha_reg, a.codmarveh, a.codmod, a.codserie,
		    a.numlotveh, f.descon, g.descla, h.destip, i.desuso, j.desser,
		    a.codptoveh, k.despto, to_char(a.fecplaveh,'dd/mm/yyyy') as fechapla, a.numfacveh, to_char(a.fecfacveh,'dd/mm/yyyy') as fechafac, a.numlicveh
			from
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j, ptoadu k,departamento m
			where
			a.codmarveh=b.codmar and
			a.codmod=c.codmod  and
			a.numlotveh=e.numlot and
			e.numdep=m.numdep and
			a.codconveh=f.codcon and
			a.codclaveh=g.codcla and
			a.codtipveh=h.codtip  and
			a.codusoveh=i.coduso and
			a.codptoveh=k.codpto  and
			a.codserveh=j.codser and a.origenveh='I' ";
    if($idcaract)  $sql=$sql." and a.id_caract='".$idcaract."'";
    if($codmar)  $sql=$sql." and a.codmarveh='".$codmar."'";
    if($modveh)  $sql=$sql." and a.codmod='".$modveh."'";
    if($serveh)  $sql=$sql." and a.codserie='".$serveh."'";
    if($lote)  $sql=$sql." and a.numlotveh='".$lote."'";
    if($factura)  $sql=$sql." and a.numfacveh like '%".$factura."%'";
    if($planilla)  $sql=$sql." and a.numlicveh like '%".$planilla."%'";
    if($numdep==5 or $numdep==3 )$numdep=null;
    if ($numdep) $sql = $sql." and  e.numdep='".$numdep."' ";
    $sql=$sql." order by a.id_caract";
    $sql = $sql." LIMIT 15 OFFSET ".$offset;
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


 function ContCaracteristicasImpo($idcaract,$codmar,$modveh,$serveh,$lote,$factura,$planilla,$numdep=null){

  $fecha=date('d/m/Y');

  $sql = "select
			count(a.id_caract)
			from
			caracteristica a, marcas b , modelo c ,  lote e, combustible f, clases g, tipos h, uso i, servicios j, ptoadu k,departamento m
			where
			a.codmarveh=b.codmar and
			a.codmod=c.codmod  and
			a.numlotveh=e.numlot and
			e.numdep=m.numdep and
			a.codconveh=f.codcon and
			a.codclaveh=g.codcla and
			a.codtipveh=h.codtip  and
			a.codusoveh=i.coduso and
			a.codptoveh=k.codpto  and
			a.codserveh=j.codser and a.origenveh='I' ";
    if($idcaract)  $sql=$sql." and a.id_caract='".$idcaract."'";
    if($codmar)  $sql=$sql." and a.codmarveh='".$codmar."'";
    if($modveh)  $sql=$sql." and a.codmod='".$modveh."'";
    if($serveh)  $sql=$sql." and a.codserie='".$serveh."'";
    if($lote)  $sql=$sql." and a.numlotveh='".$lote."'";
    if($factura)  $sql=$sql." and a.numfacveh like '%".$factura."%'";
    if($planilla)  $sql=$sql." and a.numlicveh like '%".$planilla."%'";
    if($numdep==5 or $numdep==3 )$numdep=null;
   if ($numdep) $sql = $sql." and  e.numdep='".$numdep."' ";


 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

 function modificarCaracteristicasNac($idcaract,$data){

  $sql = "update caracteristica set
  		   numlotveh=".$data[0]." ,  codmarveh='".$data[1]."' ,   codmod='".$data[2]."' , codserie='".$data[3]."',
  		   anomodveh=".$data[4]." ,  pesveh=".$data[5]." ,  tipcapveh=".$data[6]." ,
		   capcarveh=".$data[7]." ,  numejeveh=".$data[8]." ,  diarueveh=".$data[9].",
		   anofabveh='".$data[10]."' , numpueveh='".$data[11]."' ,   codconveh='".$data[12]."' , preveh='".$data[13]."',  origenveh='".$data[14]."',
		   codclaveh='".$data[15]."' , codtipveh='".$data[16]."' , codserveh='".$data[17]."' , codusoveh='".$data[18]."'
        ";
  $sql=$sql." where id_caract='".$idcaract."'";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/caracteristica_veh_nac.php');

  return $consulta;
 }

  function modificarCaracteristicasImp($idcaract,$data){

      //   buscar los vehiculo con estas caracteristicas que ya fueron enviados al intt

      $sql = "select a.estatusveh , a.numenvveh , a.fechatxtveh, a.id_certificado ";
      $sql = $sql."from certificados a, vehiculo b, caracteristica c ";
      $sql = $sql."where  a.sercarveh=b.sercarveh and b.id_caract=c.id_caract and a.estatusveh='E' ";
      $sql = $sql."and c.id_caract=".$idcaract."";

      //   print $sql;

      $conexion = $this->conectar();
      $consulta = $this->consultar($conexion,$sql);
      $consulta = $this->ret_vector($consulta);

      for($i=0;$i<count($consulta);$i+=4){

      	if ($consulta[0] == 'E'){
			  	  $sql ="  update certificados set
			  		       tipmov_txt='MM' , estatusveh='P' , numenvveh=null , fechatxtveh=null ,  nummodveh=nummodveh+1
			  		       where id_certificado=".$consulta[$i+3]."
			  		     ";
			  	 $this->consultar($conexion,$sql);
  		      //   print '<pre>'; print $sql;
  	      }

      }

  $sql = "update caracteristica set
  		   numlotveh=".$data[0]." ,  codmarveh='".$data[1]."' ,   codmod='".$data[2]."' , codserie='".$data[3]."',
  		   anomodveh=".$data[4]." ,  pesveh=".$data[5]." ,  tipcapveh=".$data[6]." ,
		   capcarveh=".$data[7]." ,  numejeveh=".$data[8]." ,  diarueveh=".$data[9].",
		   anofabveh='".$data[10]."' , numpueveh='".$data[11]."' ,   codconveh='".$data[12]."' , preveh='".$data[13]."',
		   codptoveh='".$data[14]."' ,  numlicveh='".$data[15]."' , fecplaveh='".$data[16]."' , numfacveh='".$data[17]."' ,  fecfacveh='".$data[18]."' ,
		   origenveh='".$data[19]."',
		   codclaveh='".$data[20]."' ,codtipveh='".$data[21]."' ,codserveh='".$data[22]."' ,  codusoveh='".$data[23]."'
        ";
  $sql=$sql." where id_caract='".$idcaract."'";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/caracteristica_veh_imp.php');

  return $consulta;
 }
}
?>
