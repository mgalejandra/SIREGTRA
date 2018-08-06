<?php
class placas extends conexion{

 function registrarPlacas($data){
  $fecha=date('d/m/Y');
  $sql = "INSERT INTO placas(
  		    sercarveh ,  numplaveh ,  codestveh ,
            numrafveh ,  fecrafveh ,  numsecveh,  fecha_reg )
         values
           ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."',".$data[5].",'".$fecha."')";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);

    if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/reg_placas.php');


  return $consulta;
 }

 function listarPlacas($sercarveh,$placa,$estado){

    $sql = "select
			a.sercarveh ,  a.numplaveh ,  a.codestveh , b.desest,
            a.numrafveh ,  to_char(a.fecrafveh,'dd/mm/yyyy') ,  a.numsecveh,  to_char(a.fecha_reg,'dd/mm/yyyy'), a.id_placas
			from
			placas a, estado b
			where
			a.codestveh=b.codest ";
    if($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
    if($placa)  $sql=$sql." and a.numplaveh like '%".$placa."%'";
    if($estado)  $sql=$sql." and a.codestveh='".$estado."'";
    $sql=$sql." order by a.sercarveh";
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function listadoPlacas($sercarveh,$placa,$estado,$offset,$numdep=null,$lote=null,$codmar=null,$codmodveh=null,$sta=null){
    $sql = "select
			a.sercarveh,a.numplaveh,a.codestveh,b.desest,
            a.numrafveh,to_char(a.fecrafveh,'dd/mm/yyyy'),a.numsecveh,to_char(a.fecha_reg,'dd/mm/yyyy'),a.id_placas,n.desmar,m.desmod ";
   $sql.= "	from
			placas a, estado b, vehiculo c,caracteristica d, lote e, departamento f, modelo m, marcas n
			where
		    c.sercarveh=a.sercarveh and
		    c.id_caract=d.id_caract and
		    d.numlotveh=e.numlot and
	        e.numdep=f.numdep and
			a.codestveh=b.codest and
			d.codmarveh=n.codmar and
			d.codmod=m.codmod  ";
    if($sta)  $sql=$sql." and c.estatus='$sta' ";
    if ($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
    if ($placa)  $sql=$sql." and a.numplaveh like '%".$placa."%'";
    if ($estado)  $sql=$sql." and a.codestveh='".$estado."'";
    if ($numdep==5 or $numdep==3 )$numdep=null;
    if ($numdep) $sql = $sql." and  e.numdep='".$numdep."' ";
    if ($lote) $sql = $sql." and  e.numlot='".$lote."' ";
    if ($codmar) $sql = $sql." and  d.codmarveh='".$codmar."' ";
    if ($codmodveh) $sql = $sql." and  d.codmod='".$codmodveh."' ";

    $sql=$sql." order by a.id_placas desc, a.sercarveh";
    if ($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function listadoPlacasColor($sercarveh,$placa,$estado,$offset,$numdep=null,$lote=null,$codmar=null,$codmodveh=null,$sta=null){
    $sql = "select
			a.sercarveh,a.numplaveh,a.codestveh,b.desest,
            a.numrafveh,to_char(a.fecrafveh,'dd/mm/yyyy'),a.numsecveh,to_char(a.fecha_reg,'dd/mm/yyyy'),a.id_placas,n.desmar,m.desmod, l.descol ";
   $sql.= "	from
			placas a, estado b, vehiculo c,caracteristica d, lote e, departamento f, modelo m, marcas n, color l
			where
		    c.sercarveh=a.sercarveh and
		    c.id_caract=d.id_caract and
		    d.numlotveh=e.numlot and
	        e.numdep=f.numdep and
			a.codestveh=b.codest and
			d.codmarveh=n.codmar and
			d.codmod=m.codmod and l.codcol=c.col1veh ";
    if($sta)  $sql=$sql." and c.estatus='$sta' ";
    if ($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
    if ($placa)  $sql=$sql." and a.numplaveh like '%".$placa."%'";
    if ($estado)  $sql=$sql." and a.codestveh='".$estado."'";
    if ($numdep==5 or $numdep==3 )$numdep=null;
    if ($numdep) $sql = $sql." and  e.numdep='".$numdep."' ";
    if ($lote) $sql = $sql." and  e.numlot='".$lote."' ";
    if ($codmar) $sql = $sql." and  d.codmarveh='".$codmar."' ";
    if ($codmodveh) $sql = $sql." and  d.codmod='".$codmodveh."' ";

    $sql=$sql." order by a.id_placas desc, a.sercarveh";
    if ($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function contarPlacas($sercarveh,$placa,$estado,$numdep,$lote=null,$codmar=null,$codmodveh=null,$sta=null){

    $sql = "select
			count(a.sercarveh)
			from
			placas a, estado b, vehiculo c,caracteristica d, lote e, departamento f, modelo m, marcas n
			where
		    c.sercarveh=a.sercarveh and
		    c.id_caract=d.id_caract and
		    d.numlotveh=e.numlot and
	        e.numdep=f.numdep and
			a.codestveh=b.codest and
			d.codmarveh=n.codmar and
			d.codmod=m.codmod  ";
	if($sta)  $sql=$sql." and c.estatus='$sta' ";
    if($sercarveh)  $sql=$sql." and a.sercarveh like '%".$sercarveh."%'";
    if($placa)  $sql=$sql." and a.numplaveh like '%".$placa."%'";
    if($estado)  $sql=$sql." and a.codestveh='".$estado."'";
    if($numdep==5 or $numdep==3 )$numdep=null;
    if ($numdep) $sql = $sql." and  e.numdep='".$numdep."' ";
    if ($lote) $sql = $sql." and  e.numlot='".$lote."' ";
    if ($codmar) $sql = $sql." and  d.codmarveh='".$codmar."' ";
    if ($codmodveh) $sql = $sql." and  d.codmod='".$codmodveh."' ";

 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

 function modificarPlacas($sercarveh,$data){
  $fecha=date('d/m/Y');
  $conexion = $this->conectar();
  $estatus=$this->statusTxt('',$sercarveh);

  if ($estatus[6] == 'E'){
  	  	  $sql ="  update certificados set tipmov_txt='MM', estatuspla='P' , numenvpla=null , fechatxtpla=null, nummodveh=nummodveh+1 where sercarveh='".$sercarveh."' ";
  	      $this->consultar($conexion,$sql);
  }
  $sql ="  update placas set
  		   sercarveh='".$data[0]."', numplaveh='".$data[1]."' ,  codestveh ='".$data[2]."',
           numrafveh='".$data[3]."' , fecrafveh='".$data[4]."' , numsecveh=".$data[5].",  fecha_mod='".$fecha."' "
        ;
  $sql=$sql." where sercarveh='".$sercarveh."'";
  //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);

  if($consulta) $this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/reg_placas.php');

  return $consulta;
 }

 function inventario_vehPlacas () {
 $sql = "DROP TABLE IF EXISTS TP1;" .
 		"SELECT numplaveh,max(fecha_reg) AS maxFec INTO TP1 FROM placas GROUP BY 1 ORDER BY 1;" .
 		"SELECT a.desmar, b.desmod,numplaveh,p.fecha_reg FROM placas p " .
 		"INNER JOIN vehiculo v ON v.sercarveh = p.sercarveh " .
 		"INNER JOIN caracteristica c ON c.id_caract = v.id_caract " .
 		"INNER JOIN marcas a ON a.codmar = c.codmarveh " .
 		"INNER JOIN modelo b ON b.codmod = c.codmod " .
 		"WHERE numplaveh||p.fecha_reg IN (SELECT numplaveh||maxFec FROM TP1) " .
 		"ORDER BY 1,2,3,4;" .
 		"DROP TABLE TP1;";

//  print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  return $consulta;

}
}
?>
