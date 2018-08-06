<?php
class asignacion extends conexion{

						// $sercarveh,$codpro,$nombre,$fechAsig,$numlotveh
  function contarAsignacion($sercarveh,$codpro,$nomcomp,$fecha_asig=null,$numlotveh=null,$tipo,$id=null,$taller=null,$tt=null,$numdep=null){
 	if(!$tipo) $tipo='A';
 	$sql = "SELECT DISTINCT	count(*) FROM asignacion a " .
			"INNER JOIN propietarios b ON (b.codpro = a.codpro) " ;

   if ($taller or $tt)
   	$sql.= " INNER JOIN (vehiculo c inner join vehic_taller f
                       inner join taller e on (e.numtaller=f.id_taller) on c.sercarveh=f.sercarveh) ON (c.sercarveh = a.sercarveh ) ";
   else
   	 $sql.=	"INNER JOIN vehiculo c ON (c.sercarveh = a.sercarveh) " ;

 	$sql.=	"INNER JOIN caracteristica d ON (d.id_caract = c.id_caract) ,lote i, departamento j " .
			"WHERE a.status='$tipo' and
 		        d.numlotveh=i.numlot and
                   i.numdep=j.numdep   ";
 	/*
 	 * $id = 2: Solo lista los vehículos que no están en tabla < venta >
 	 * $id = 3: Solo lista los vehículos que no están en tabla < entrega >
 	 */
 	if($id==2) 		$sql.= " AND a.sercarveh NOT IN (SELECT sercarveh FROM venta)";
 	if($id==3) 		$sql.= " AND a.sercarveh NOT IN (SELECT sercarveh FROM entrega)";
    if($numlotveh) 	$sql.= " AND d.numlotveh = $numlotveh";
    if($sercarveh)  $sql.= " AND a.sercarveh LIKE '%$sercarveh%'";
    if($codpro)  	$sql.= " AND a.codpro like '%$codpro%'";
    if($nomcomp)  	$sql.= " AND b.nomcomp like '%$nomcomp%' ";
    if($fecha_asig) $sql.= " AND a.fecha_asig='$fecha_asig'";
    if ($taller)    $sql.= " AND f.id_taller='$taller'";
    if($numdep==5 or $numdep==3 )$numdep=null;
    if($numdep==4)$numdep='1' ;
    if ($numdep) $sql = $sql." and  i.numdep='".$numdep."' ";
  // print '<pre>'; print $sql;
  //f_alert($sql);

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }


 function registrarAsignacion($data){
  $fecha=date('d/m/Y');

  $buscarserial=$this->contarAsignacion($data[0],'','','','','','','','','','');
 // echo 'aqui'.$buscarserial;
  if($buscarserial==0){
 	 if ($data[3]){
  	$sql = "INSERT INTO asignacion(
  		   sercarveh ,  codpro ,   fecha_asig ,usuario, observacion, id_preinv )
    	     values
           ('".$data[0]."','".$data[1]."','".$fecha."','".$_SESSION['usuario']."','".$data[2]."','".$data[3]."')";

  }
  else
  {
  	$sql = "INSERT INTO asignacion(
  		   sercarveh ,  codpro ,   fecha_asig ,usuario, observacion)
    	     values
           ('".$data[0]."','".$data[1]."','".$fecha."','".$_SESSION['usuario']."','".$data[2]."')";

  }

  //print '<pre>Registrar '; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/reg_asignacion.php');
  if($consulta) $this->bitacoraBeneficiario($data[1],$data[0],'Asignación de Vehiculo',$_SESSION['usuario']);
  return $consulta;
  } else return false;
 }

 function listarAsignacion($sercarveh,$codpro,$nomcomp,$id=1,$fecha_asig=null,$numlotveh=null,$offset=0,$tipo=null,$taller=null,$tt=null,$numdep=null,$asigna=null){

  	if(!$tipo) $tipo='A';
/*
 * Similar a < listarAsignaciones > solo que incorpora las variables $id y $offset.
 *  si $id=2 entonces lista sólo los vehículos que aún no han sido registrado en tabla < venta >,
 *  si $id=3 entonces lista sólo los vehículos que aún no han sido registrado en tabla < entrega >
*/
 	$sql = "SELECT a.sercarveh, a.codpro, trim(b.nomcomp), to_char(a.fecha_asig,'dd/mm/yyyy')" .
 			",a.id_asignacion, a.status, to_char(a.fecha_lib,'dd/mm/yyyy'), substr(a.codpro,1,1),usuario,observacion ";

 	if ($taller or $tt)
 		$sql.= " ,e.nombre,f.falla ";

 	$sql.=	"FROM asignacion a " .
 			"INNER JOIN propietarios b ON (b.codpro = a.codpro) " ;

 	if ($taller or $tt)
   		$sql.= " INNER JOIN (vehiculo c inner join vehic_taller f
   	                   inner join taller e on (e.numtaller=f.id_taller) on c.sercarveh=f.sercarveh) ON (c.sercarveh = a.sercarveh ) ";
   	else
   	 	$sql.=	"INNER JOIN vehiculo c ON (c.sercarveh = a.sercarveh) " ;


 	$sql.=	"INNER JOIN caracteristica d ON (d.id_caract = c.id_caract),lote i, departamento j " .
 			"WHERE a.status='$tipo' and
                   d.numlotveh=i.numlot and
                   i.numdep=j.numdep  ";
 	if($id==2) 		$sql.= " AND a.sercarveh NOT IN (SELECT sercarveh FROM venta)";
 	if($id==3) 		$sql.= " AND a.sercarveh NOT IN (SELECT sercarveh FROM entrega)";
    if($numlotveh)  $sql.= " AND d.numlotveh = $numlotveh";
    if($sercarveh)  $sql.= " AND a.sercarveh like '%$sercarveh%'";
    if($codpro)  	$sql.= " AND a.codpro like '%$codpro%'";
    if($asigna)  	$sql.= " AND a.id_asignacion = '$asigna'";
//    if($nomcomp)  	$sql.= " AND b.nomcomp like '%strtoupper($nomcomp)%' ";
    if($nomcomp)  	$sql.= " AND b.nomcomp like '%$nomcomp%' ";
    if($fecha_asig) $sql.= " AND a.fecha_asig='$fecha_asig'";
    if ($taller)    $sql.= " AND f.id_taller='$taller'";
     if($numdep==5 or $numdep==3 )$numdep=null;
    if($numdep==4)$numdep='1';
    if ($numdep) $sql = $sql." and  i.numdep='".$numdep."' and  a.id_preinv is null ";
    if ($tipo=='A')  $sql.= " ORDER BY a.fecha_asig desc, a.id_asignacion desc"; else $sql.= " ORDER BY a.fecha_lib ";
    if($offset>=0) $sql.= " LIMIT 20 OFFSET $offset";
 //  print '<pre>Listar'; print $sql;
//	f_alert($sql);

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

function listarAsignacion1($sercarveh,$codpro,$nomcomp,$id=1,$fecha_asig=null,$numlotveh=null,$offset=0,$tipo=null,$taller=null,$tt=null,$numdep=null,$asigna=null,$modelo=null){

  	if(!$tipo) $tipo='A';
/*
 * Similar a < listarAsignaciones > solo que incorpora las variables $id y $offset.
 *  si $id=2 entonces lista sólo los vehículos que aún no han sido registrado en tabla < venta >,
 *  si $id=3 entonces lista sólo los vehículos que aún no han sido registrado en tabla < entrega >
*/
 	$sql = "SELECT a.sercarveh, a.codpro, trim(b.nomcomp), to_char(a.fecha_asig,'dd/mm/yyyy')" .
 			",a.id_asignacion, a.status, to_char(a.fecha_lib,'dd/mm/yyyy'), substr(a.codpro,1,1),usuario,observacion ";

 	if ($taller or $tt)
 		$sql.= " ,e.nombre,f.falla";

 	$sql.= ", m.desmod, descolor(col1veh), p.numplaveh ";

 	$sql.=	"FROM asignacion a " .
 			"INNER JOIN propietarios b ON (b.codpro = a.codpro) " ;

 	if ($taller or $tt)
   		$sql.= " INNER JOIN (vehiculo c inner join vehic_taller f
   	                   inner join taller e on (e.numtaller=f.id_taller) on c.sercarveh=f.sercarveh) ON (c.sercarveh = a.sercarveh ) ";
   	else
   	 	$sql.=	"INNER JOIN vehiculo c ON (c.sercarveh = a.sercarveh) inner join placas p ON (c.sercarveh=p.sercarveh) " ;


 	$sql.=	"INNER JOIN caracteristica d ON (d.id_caract = c.id_caract) INNER JOIN modelo m ON (d.codmod = m.codmod),lote i, departamento j " .
 			"WHERE a.status='$tipo' and
                   d.numlotveh=i.numlot and
                   i.numdep=j.numdep  ";
 	if($id==2) 		$sql.= " AND a.sercarveh NOT IN (SELECT sercarveh FROM venta)";
 	if($id==3) 		$sql.= " AND a.sercarveh NOT IN (SELECT sercarveh FROM entrega)";
    if($numlotveh)  $sql.= " AND d.numlotveh = $numlotveh";
    if($sercarveh)  $sql.= " AND a.sercarveh like '%$sercarveh%'";
    if($codpro)  	$sql.= " AND a.codpro like '%$codpro%'";
    if($asigna)  	$sql.= " AND a.id_asignacion = '$asigna'";
//    if($nomcomp)  	$sql.= " AND b.nomcomp like '%strtoupper($nomcomp)%' ";
    if($nomcomp)  	$sql.= " AND b.nomcomp like '%$nomcomp%' ";
    if($fecha_asig) $sql.= " AND a.fecha_asig='$fecha_asig'";
    if ($taller)    $sql.= " AND f.id_taller='$taller'";
    if($numdep==5 or $numdep==3 )$numdep=null;
    if($numdep==4)$numdep='1';
    if ($numdep) $sql = $sql." and  i.numdep='".$numdep."' and  a.id_preinv is null ";
    if ($modelo) $sql.= " AND d.codmod ='$modelo'";

    if ($tipo=='A')  $sql.= " ORDER BY a.fecha_asig desc, a.id_asignacion desc"; else $sql.= " ORDER BY a.fecha_lib ";
    if($offset>=0) $sql.= " LIMIT 20 OFFSET $offset";
   //print '<pre>Listar'; print $sql;
//	f_alert($sql);

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }



 function listarLiberados($sercarveh,$codpro,$nomcomp,$id=1,$fecha_asig=null,$numlotveh=null,$offset=0,$tipo=null,$taller=null,$tt=null,$numdep=null,$asigna=null,$modelo=null){

  	if(!$tipo) $tipo='A';
/*
 * Similar a < listarAsignaciones > solo que incorpora las variables $id y $offset.
 *  si $id=2 entonces lista sólo los vehículos que aún no han sido registrado en tabla < venta >,
 *  si $id=3 entonces lista sólo los vehículos que aún no han sido registrado en tabla < entrega >
*/
 	$sql = "SELECT a.sercarveh, a.codpro, trim(b.nomcomp), to_char(a.fecha_asig,'dd/mm/yyyy')" .
 			",a.id_asignacion, a.status, to_char(a.fecha_lib,'dd/mm/yyyy'), substr(a.codpro,1,1),usuario,observacion ";

 	if ($taller or $tt)
 		$sql.= " ,e.nombre,f.falla";

 	$sql.= ", m.desmod, descolor(col1veh), p.numplaveh ";

 	$sql.=	"FROM asignacion a " .
 			"INNER JOIN propietarios b ON (b.codpro = a.codpro) " ;

 	if ($taller or $tt)
   		$sql.= " INNER JOIN (vehiculo c inner join vehic_taller f
   	                   inner join taller e on (e.numtaller=f.id_taller) on c.sercarveh=f.sercarveh) ON (c.sercarveh = a.sercarveh ) ";
   	else
   	 	$sql.=	"INNER JOIN vehiculo c ON (c.sercarveh = a.sercarveh) inner join placas p ON (c.sercarveh=p.sercarveh) " ;


 	$sql.=	"INNER JOIN caracteristica d ON (d.id_caract = c.id_caract) INNER JOIN modelo m ON (d.codmod = m.codmod),lote i, departamento j " .
 			"WHERE a.status='$tipo' and
                   d.numlotveh=i.numlot and
                   i.numdep=j.numdep  ";
 	if($id==2) 		$sql.= " AND a.sercarveh NOT IN (SELECT sercarveh FROM venta)";
 	if($id==3) 		$sql.= " AND a.sercarveh NOT IN (SELECT sercarveh FROM entrega)";
    if($numlotveh)  $sql.= " AND d.numlotveh = $numlotveh";
    if($sercarveh)  $sql.= " AND a.sercarveh like '%$sercarveh%'";
    if($codpro)  	$sql.= " AND a.codpro like '%$codpro%'";
    if($asigna)  	$sql.= " AND a.id_asignacion = '$asigna'";
//    if($nomcomp)  	$sql.= " AND b.nomcomp like '%strtoupper($nomcomp)%' ";
    if($nomcomp)  	$sql.= " AND b.nomcomp like '%$nomcomp%' ";
    if($fecha_asig) $sql.= " AND a.fecha_asig='$fecha_asig'";
    if ($taller)    $sql.= " AND f.id_taller='$taller'";
    if($numdep==5 or $numdep==3 )$numdep=null;
    if($numdep==4)$numdep='1';
    if ($numdep) $sql = $sql." and  i.numdep='".$numdep."' and  a.id_preinv is null ";
    if ($modelo) $sql.= " AND d.codmod ='$modelo'";

    if ($tipo=='A')  $sql.= " ORDER BY a.fecha_asig desc, a.id_asignacion desc"; else $sql.= " ORDER BY a.fecha_lib ";
    if($offset>=0) $sql.= " LIMIT 20 OFFSET $offset";
   //print '<pre>Listar'; print $sql;
//	f_alert($sql);

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

/////////////////////////////////////////////////////////////////////////////////////////
// Para manejar excepciones sin tener que intervenir en código fuente
// sólo basta colocar los campos número de RIF (codpro) y el nombre completo (nomcomp)
// en la tabla < excepciones > creada para ello.
/////////////////////////////////////////////////////////////////////////////////////////
function f_excepciones ($nroRIF){
	$sql = "SELECT codpro FROM excepciones WHERE status='A' AND codpro = '".$nroRIF."'";
 // print '<pre>'.$sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
   return $nroRIF==$consulta[0];
}

function f_excepciones1 ($nroRIF,$traeN=null,$offset=null,$nombre=null) {
	$sql = "SELECT codpro,nomcomp, status FROM excepciones WHERE ((status='A') or ((status='L')))";

	if ($nroRIF) $sql.= " AND codpro = '".$nroRIF."'";
	if ($nombre) $sql.= " AND nomcomp like '%".$nombre."%'";
    if($offset>=0) $sql.= " LIMIT 20 OFFSET $offset";

 // print '<pre>'.$sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
   return $consulta;

}

function f_excepciones2 ($nroRIF,$traeN=null,$offset=null,$nombre=null) {
	$sql = "SELECT codpro,nomcomp, status FROM excepcionescert WHERE ((status='A') or ((status='L')))";

	if ($nroRIF) $sql.= " AND codpro = '".$nroRIF."'";
	if ($nombre) $sql.= " AND nomcomp like '%".$nombre."%'";
    if($offset>=0) $sql.= " LIMIT 20 OFFSET $offset";

  //print '<pre>'.$sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
   return $consulta;

}

function regExcepcion($data){

	$sql = "INSERT INTO excepciones(codpro,nomcomp) VALUES ('".$data[0]."','".$data[1]."')";

	//echo "Inserta: ".$sql;
	 $conexion = $this->conectar();
     $consulta = $this->consultar($conexion,$sql);

     $this->desconectar($conexion);
     if($consulta){

     	if ($data[2]=='S'){
     		$conexion = $this->conectar();

     		$sql1 = "INSERT INTO excepcionescert(codpro,nomcomp) VALUES ('".$data[0]."','".$data[1]."')";
			$consulta1 = $this->consultar($conexion,$sql1);

			$this->desconectar($conexion);
     	}

     	$this->auditar($_SESSION['loguse'],'INSERCION','Registro excepcion a beneficiario '.$data[0]);
        return $consulta;
     }

}

function bloqExcepcion($nroRIF){
	$fecha = date('d/m/Y');
	$sql = "update excepciones set status='L' where codpro='".$nroRIF."'";

	//echo "Desactivar: ".$sql;

	 $conexion = $this->conectar();
     $consulta = $this->consultar($conexion,$sql);

     $this->desconectar($conexion);
     if($consulta){
     	$this->auditar($_SESSION['loguse'],'MODIFICACION','Desactivo excepcion a beneficiario '.$nroRIF);
    	return $consulta;
     }


}

function desbloqExcepcion($nroRIF){
	$fecha = date('d/m/Y');
	$sql = "update excepciones set status='A' where codpro='".$nroRIF."'";

	//echo "<br>Bloquear nuevamente: ".$sql;

	 $conexion = $this->conectar();
     $consulta = $this->consultar($conexion,$sql);

     $this->desconectar($conexion);
     if($consulta){
     	$this->auditar($_SESSION['loguse'],'MODIFICACION','Activo excepcion a beneficiario '.$nroRIF);
        return $consulta;
     }


}



////////////////////////////////////////////////////////////////////////////////////

 function listarAsignaciones($sercarveh,$codpro,$nomcomp,$fecha_asig=null,$numlotveh=null){

 	$sql = "SELECT
			a.sercarveh ,  a.codpro , trim(b.nomcomp),  to_char(a.fecha_asig,'dd/mm/yyyy'), a.id_asignacion, a.status, a.fecha_lib, substr(a.codpro,1,1)
			FROM asignacion a
			INNER JOIN propietarios b 	ON (a.codpro = b.codpro)
			INNER JOIN vehiculo c  		ON (c.sercarveh = a.sercarveh)
			INNER JOIN caracteristica d ON (c.id_caract = d.id_caract)
			WHERE a.status='A' ";
    if($numlotveh)  $sql.= " AND d.numlotveh = '$numlotveh'";
    if($sercarveh)  $sql.= " AND a.sercarveh = '$sercarveh'";
    if($codpro)  	$sql.= " AND a.codpro = '$codpro'";
    if($nomcomp)  	$sql.= " AND b.nomcomp like '%".strtoupper($nomcomp)."%' ";
    if($fecha_asig) $sql.= " AND a.fecha_asig = '$fecha_asig'";
    $sql.= " ORDER BY a.sercarveh";

 // print '<pre>Lista Asig'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 function modificarAsignacion($idasignacion,$data){
  $fecha=date('d/m/Y');
  $sql ="  update asignacion set
  		          sercarveh='".$data[0]."'  ,  codpro='".$data[1]."' , fecha_lib='".$fecha."' "
        ;
  $sql=$sql." WHERE id_asignacion='".$idasignacion."'";

 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/reg_asignacion.php');
  //if($consulta) $this->bitacoraBeneficiario($data[1],$data[0],'Modificó asignación de Vehiculo',$_SESSION['usuario']);
  return $consulta;
 }

  function modificarAsignacion2($idasignacion,$data){
  $fecha=date('d/m/Y');
  $sql ="  update asignacion set  id_preinv=null,
  		          sercarveh='".$data[0]."'  ,  codpro='".$data[1]."' , fecha_lib='".$fecha."' , observacion=observacion||' Pre-Inventario N# '||id_preinv "        ;
  $sql=$sql." WHERE id_asignacion='".$idasignacion."'";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  //actualizar los datos en la factura proforma
  $sql ="  update facturaprof  set  id_preinv=null, sercarveh='".$data[0]."', observacion=observacion||' Pre-Inventario N# '||id_preinv
  		   where id_asignacion='".$idasignacion."'";
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/reg_asignacion.php');
  if($consulta) $this->bitacoraBeneficiario($data[1],$data[0],'Modificó asignación de Vehiculo Preinventario '.$data[0],$_SESSION['usuario']);
  return $consulta;
 }

function liberarAsignacion($idasignacion,$codpro=null,$serveh=null,$obspro=null){

  $conexion = $this->conectar();
  $fecha=date('d/m/Y');


   $sql1="SELECT e.existencia,e.id_preinv
FROM
  asignacion a,
  caracteristica b,
  preinventario c,
  vehiculo d,
  existencia e
WHERE
  b.id_caract = d.id_caract AND
  b.codmarveh = c.id_marca AND
  b.codmod = c.id_modelo AND
  b.numlotveh = c.numlotveh AND
  c.id_preinv = e.id_preinv AND
  d.sercarveh = a.sercarveh and a.sercarveh='".$serveh."' and a.status='A' ";

  //print '<pre>'; print $sql1;
  $consulta1 = $this->consultar($conexion,$sql1);
  $consulta1 = $this->ret_vector($consulta1);
  $aumento = $consulta1[0]+1;

  $sql = "update existencia set existencia='".$aumento."' where id_preinv='".$consulta1[1]."'";

  //echo $sql;
  $consulta = $this->consultar($conexion,$sql);

  $sql ="  update asignacion set
  		          status='L', fecha_lib='$fecha', usuario='".$_SESSION['usuario']."',observacion='$obspro' "
        ;
  $sql=$sql." WHERE id_asignacion='".$idasignacion."'";
  //print '<pre>'; print $sql;
  $consulta = $this->consultar($conexion,$sql);
   $sql ="  update facturaprof set
  		          estatus='E'   "
        ;
  $sql=$sql." WHERE id_asignacion='".$idasignacion."'";
  //print '<pre>'; print $sql;
  $consulta = $this->consultar($conexion,$sql);

  $sql ="  update venta set
  		          status='E'   "
        ;
  $sql=$sql." WHERE id_asignacion='".$idasignacion."'";
 // print '<pre>'; print $sql;
  $consulta = $this->consultar($conexion,$sql);

  $sql ="  update certificados set
	  		       tipmov_txt='ME', estatus='E', estatusveh='P', tipmov_pro='ME', estatuspro='P',tipmov_pla='ME', estatuspla='P'   WHERE id_asignacion='".$idasignacion."' ";
  $consulta= $this->consultar($conexion,$sql);

     $sql ="  update pago set
  		          status='E', fec_mod='$fecha' WHERE id_asignacion='".$idasignacion."'";
  //print '<pre>'; print $sql;
  $consulta = $this->consultar($conexion,$sql);

  $this->desconectar($conexion);

  if($consulta) $this->auditar('LIBERAR',$sql,'http://localhost/refeciv1.1/vistas/reg_asignacion.php');
  if($consulta) $this->bitacoraBeneficiario($codpro,$serveh,'Libero Vehiculo: '.$serveh,$_SESSION['usuario']);

  return $consulta;
 }
function regAsig($sercarveh,$codpro,$obspro){
 	$sql = "SELECT MAX(id_asignacion) FROM asignacion";
  	$conexion = $this->conectar(1);
	$consulta = $this->consultar($conexion,$sql);
	$id = $this->ret_vector($consulta);
       $sql = "INSERT INTO asignacion (sercarveh,codpro,fecha_asig ,usuario,observacion) values";
	   $count=count($sercarveh);
       for($i=0;$i<$count-1;$i++){
    	   $sql =  $sql."('".$sercarveh[$i]."','".$codpro."','".date("d-m-Y")."','".$_SESSION['usuario']."','".$obspro."'),";
       }
    	  $sql =  $sql."('".$sercarveh[$i]."','".$codpro."','".date("d-m-Y")."','".$_SESSION['usuario']."','".$obspro."');";
         $consulta = $this->consultar($conexion,$sql);
      //print '<pre>'; print $sql;
	$this->desconectar($conexion);
	if($consulta)return $id;
}

//LISTAR VEHICULOS ASIGNADOS PREINVENTARIO
function contarVehAsigPreInv($codpro,$codmar,$modveh,$serveh,$numlotveh=null){
  $sql = " select count(a.codpro) " .
  		 " from asignacion a
    		 inner join propietarios f on a.codpro=f.codpro
    		 inner join preinventario e on a.id_preinv=e.id_preinv
            		    inner join marcas b on e.id_marca=b.codmar
             			inner join modelo c on e.id_modelo=c.codmod";

    if($serveh)  $sql.="  inner join serie d on e.id_serie=d.codserie";

	$sql.=	" where a.status ='A'  and ((a.sercarveh='0') or (a.sercarveh='1')) ";

	if($codpro)  $sql.=" and a.codpro like '%$codpro%'";
    if($codmar)  $sql.=" and e.id_marca='".$codmar."'";
    if($modveh)  $sql.=" and e.id_modelo='".$modveh."'";
    if($serveh)  $sql.=" and e.id_serie='".$serveh."'";
    if($numlotveh)  $sql=$sql." and e.numlotveh=$numlotveh";

 // print '<br>Contar'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

function listarVehAsigPreInv($codpro,$codmar,$modveh,$serveh,$offset,$numlotveh=null){
 $sql = " select a.codpro,f.prinompro,f.segnompro,f.priapepro,f.segapepro , to_char(a.fecha_asig,'dd/mm/yyyy'), b.desmar, c.codmod, e.precio_min," .
  		" e.precio_max";

  if($serveh)  $sql.=" , d.desserie";

  $sql.=" , a.id_asignacion, a.sercarveh, a.id_preinv, e.numlotveh" .
  		" from asignacion a
     inner join propietarios f on a.codpro=f.codpro
     inner join preinventario e on a.id_preinv=e.id_preinv
                inner join marcas b on e.id_marca=b.codmar
                inner join modelo c on e.id_modelo=c.codmod";

  if($serveh)  $sql.="  inner join serie d on e.id_serie=d.codserie";

	$sql.=	" where a.status ='A' and ((a.sercarveh='0') or (a.sercarveh='1') or (a.sercarveh='2') or (a.sercarveh='3'))  ";

	if($codpro)  $sql=$sql." and a.codpro like '%$codpro%'";
    if($codmar)  $sql=$sql." and e.id_marca='".$codmar."'";
    if($modveh)  $sql=$sql." and e.id_modelo='".$modveh."'";
    if($serveh)  $sql=$sql." and e.id_serie='".$serveh."'";
    if($modveh)  $sql=$sql." and e.id_modelo='".$modveh."'";
    if($numlotveh)  $sql=$sql." and e.numlotveh=$numlotveh";
    $sql=$sql." order by a.id_preinv";
    if ($offset>=0) $sql = $sql." LIMIT 40 OFFSET  ".$offset;


 // print '<br>Asignados de PreInv'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


function liberarVehPreInv($idasignacion,$codpro=null,$idsercarveh=null){
  $conexion = $this->conectar();
  $fecha=date('d/m/Y');
  $sql ="  update asignacion set
  		          status='L', fecha_lib='$fecha', usuario='".$_SESSION['usuario']."' WHERE id_asignacion='".$idasignacion."'";

  //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
   $sql ="  update facturaprof set
  		          estatus='E', fecha_estatus='$fecha' WHERE id_asignacion='".$idasignacion."'";
  //print '<pre>'; print $sql;
  $consulta = $this->consultar($conexion,$sql);

   $sql ="  update pago set
  		          status='E', fec_mod='$fecha' WHERE id_asignacion='".$idasignacion."'";
  //print '<pre>'; print $sql;
  $consulta = $this->consultar($conexion,$sql);

  $sql1="select * from existencia where id_preinv=(select id_preinv from asignacion WHERE id_asignacion='".$idasignacion."')";

  //print '<pre>'; print $sql1;
  $consulta1 = $this->consultar($conexion,$sql1);
  $consulta1 = $this->ret_vector($consulta1);
  $aumento = $consulta1[2]+1;

  $sql = "update existencia set existencia='".$aumento."' where id_preinv='".$consulta1[1]."'";
  $consulta = $this->consultar($conexion,$sql);

  $this->desconectar($conexion);
  if($consulta) $this->auditar('LIBERAR',$sql,'http://localhost/refeciv1.1/vistas/preproforma.php');
  if($consulta) $this->bitacoraBeneficiario($codpro,$idsercarveh,'Libero Vehiculo del beneficiario con RIF: '.$codpro,$_SESSION['usuario']);
  return $consulta;
 }


//Para registrar sin problema el vehiculo preinventario..la hice aparte porque al validar si esta o no asignado no entra la funcion
 function registrarAsignacion1($data){
  $fecha=date('d/m/Y');

 if ($data[3]){
  	$sql = "INSERT INTO asignacion(
  		   sercarveh ,  codpro ,   fecha_asig ,usuario, observacion, id_preinv )
    	     values
           ('".$data[0]."','".$data[1]."','".$fecha."','".$_SESSION['usuario']."','".$data[2]."','".$data[3]."')";

  }
  else
  {
  	$sql = "INSERT INTO asignacion(
  		   sercarveh ,  codpro ,   fecha_asig ,usuario, observacion)
    	     values
           ('".$data[0]."','".$data[1]."','".$fecha."','".$_SESSION['usuario']."','".$data[2]."')";

  }

 //print '<pre>Registrar '; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/preproforma.php');
  if($consulta) $this->bitacoraBeneficiario($data[1],$data[0],'Asignación de Vehiculo',$_SESSION['usuario']);
  return $consulta;

 }

}
?>