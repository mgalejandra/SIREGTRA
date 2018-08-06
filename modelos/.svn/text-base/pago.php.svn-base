<?php
class pago extends conexion{
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 function registrarPago($data,$codproc,$num){

    $conexion = $this->conectar();

    $fecha=date('d/m/Y');

    $sql = "SELECT MAX(id_pago) FROM pago ";
    $consulta = $this->consultar($conexion,$sql);
    $contF = $this->ret_vector($consulta);
    $id = $contF[0]+1;

//	Localizar número de asignación con serial de carrocería del vehículo ('sercarveh')

   /* $sql = "SELECT id_asignacion FROM asignacion WHERE sercarveh = '".$data[6]."'";
    $consulta = $this->consultar($conexion,$sql);
    $contF = $this->ret_vector($consulta);
    $data[5] = $contF[0];*/

    	//echo "Es completo";

    	$sqlP = "SELECT codpro FROM asignacion where id_asignacion =".$data[5]." ";
    	$consultaP = $this->consultar($conexion,$sqlP);
    	$cedulaP = $this->ret_vector($consultaP);
    	$cedula = $cedulaP[0];
    	//echo "La cedula es: ".$cedula;


    $sql = "INSERT INTO pago ";
    $sql.= "(id_pago,nro_pago,fec_pago,monto,id_banco,nro_cuenta,id_asignacion,sercarveh,fec_reg,tipo,codpro)";
	$sql.= " VALUES (".$id.",'".$data[0]."','".$data[1]."',".$data[2].",'".$data[3]."','".$data[4]."',".$data[5].",'".$data[6]."','".$fecha."','".$data[7]."','".$cedula."')";

  //print '<pre>'.$sql;

  $consulta = $this->consultar($conexion,$sql);
  if ($consulta) $consulta=$id;
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/');
  if($consulta) $this->bitacoraBeneficiario($codproc,$data[0],'Inicial Consignada N#: '.$id.' por un monto de: '.$data[2],$_SESSION['usuario']);
  if($consulta) $this->estatusFacturaProfo($num,$codproc,$data[0],'6','','');
  return $id;
 }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 function buscarPago($id_pago,$desde=null,$hasta=null,$codpro=null,$nombre=null,$offset=null,$cheque=null,$cuenta=null,$banco=null){
// id_pago, nro_pago, fec_pago, monto, status_pago, id_banco, id_asignacion, sercarveh, nomcomp, nro_cuenta, nombanco, fec_reg
 	$sql = "SELECT".
	 	"   a.id_pago".
	 	" , a.nro_pago".
	 	" , to_char(a.fec_pago,'dd/mm/yyyy')".
	 	" , a.monto".
	 	" , a.status_pago".
	 	" , a.id_banco".
	 	" , a.id_asignacion".
	 	" , b.sercarveh".
	 	" , c.nomcomp".
	 	" , a.nro_cuenta".
	 	" , to_char(a.fec_reg,'dd/mm/yyyy'), a.tipo ".
		" FROM pago a, asignacion  b, propietarios c ".
		" WHERE a.status='A' AND a.id_asignacion = b.id_asignacion AND b.codpro = c.codpro ";
	if($id_pago) $sql.= " AND a.id_pago = '$id_pago'";
	if($desde AND $hasta) $sql .= " AND  a.fec_pago BETWEEN '$desde' AND '$hasta'";
    if($codpro)  $sql.= " AND c.codpro = '$codpro'";
    if($nombre)  $sql.= " AND c.nomcomp like '%$nombre%'";
    if ($cheque) $sql.= " AND a.nro_pago = '$cheque'";
    if ($cuenta) $sql.= " AND a.nro_cuenta = '$cuenta'";
    if ($banco) $sql.= " AND a.id_banco = '$banco'";
    $sql.= " ORDER BY 1";
    if($offset)$sql.= " LIMIT 15 OFFSET $offset";

 //	print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 function buscarPago_Anulado($id_pago,$desde=null,$hasta=null,$codpro=null,$nombre=null,$offset=null,$cheque=null,$cuenta=null,$banco=null){
// id_pago, nro_pago, fec_pago, monto, status_pago, id_banco, id_asignacion, sercarveh, nomcomp, nro_cuenta, nombanco, fec_reg
 	$sql = "SELECT".
	 	"   a.id_pago".
	 	" , a.nro_pago".
	 	" , to_char(a.fec_pago,'dd/mm/yyyy')".
	 	" , a.monto".
	 	" , a.status_pago".
	 	" , a.id_banco".
	 	" , a.id_asignacion".
	 	" , b.sercarveh".
	 	" , c.nomcomp".
	 	" , a.nro_cuenta".
	 	" , to_char(a.fec_reg,'dd/mm/yyyy'), a.tipo ,a.codpro ".
		" FROM pago a, asignacion  b, propietarios c ".
		" WHERE a.status='E' AND a.id_asignacion = b.id_asignacion AND b.codpro = c.codpro ";
	if($id_pago) $sql.= " AND a.id_pago = '$id_pago'";
	if($desde AND $hasta) $sql .= " AND  a.fec_pago BETWEEN '$desde' AND '$hasta'";
    if($codpro)  $sql.= " AND c.codpro = '$codpro'";
    if($nombre)  $sql.= " AND c.nomcomp like '%$nombre%'";
    if ($cheque) $sql.= " AND a.nro_pago = '$cheque'";
    if ($cuenta) $sql.= " AND a.nro_cuenta = '$cuenta'";
    if ($banco) $sql.= " AND a.id_banco = '$banco'";
    $sql.= " ORDER BY 1";
    if($offset)$sql.= " LIMIT 15 OFFSET $offset";

 	//print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
 function contarPagos($nro_pago=null,$id_banco=null,$desde=null,$hasta=null,$sercarveh=null,$codpro=null,$nombre=null,$id_caso=1,$status=null,$tipo=null,$idpago=null){

	if(!$tipo) $tipo='A';

				$sql="select count (w.id_pago) from (SELECT   a.id_pago , a.nro_pago , a.monto , a.fec_pago,
				'' , a.id_banco , a.nro_cuenta , a.banco_descrip , a.id_asignacion , a.sercarveh ,
				a.codpro , a.nom , a.fec_reg
				from (
				select a.id_pago, a.id_asignacion, c.nomcomp, a.monto, g.desmod, to_char(a.fec_reg,'dd/mm/yyyy') as  fec_reg,
				nro_pago, a.nro_cuenta, h.banco_descrip , to_char(a.fec_pago,'dd/mm/yyyy') as fec_pago, e.sercarveh, i.codpro , i.nomcomp  as nom, a.id_banco,a.fec_reg as fecha_registro
				from pago a , facturaprof b, propietarios c,  vehiculo e, caracteristica f, modelo g, banco h, asignacion d
				INNER JOIN propietarios i ON (d.codpro = i.codpro)
				where
				a.id_asignacion=b.id_asignacion
				and b.estatus='$tipo'
				and a.status='A'
				and b.id_asignacion=d.id_asignacion
				and d.codpro=c.codpro
				and d.sercarveh=e.sercarveh
				and e.id_caract=f.id_caract
				and f.codmod=g.codmod
				and a.id_banco=h.id_banco
				union all
				select a.id_pago, a.id_asignacion, c.nomcomp, a.monto, g.desmod, to_char(a.fec_reg,'dd/mm/yyyy') as fec_reg,
				 nro_pago, a.nro_cuenta, f.banco_descrip , to_char(a.fec_pago,'dd/mm/yyyy') as fec_pago, '0' as sercarveh, i.codpro , i.nomcomp as nom, a.id_banco, a.fec_reg as fecha_registro
				from pago a , facturaprof b, propietarios c,  preinventario e, banco f, modelo g, asignacion d
				INNER JOIN propietarios i ON (d.codpro = i.codpro)
				where
				a.id_asignacion=b.id_asignacion
				and b.estatus='$tipo'
				and a.status='A'
				and b.id_asignacion=d.id_asignacion
				and d.codpro=c.codpro
				and d.id_preinv=e.id_preinv
				and e.id_modelo=g.codmod
				and a.id_banco=f.id_banco
				) a where a.id_pago is not null ";

     if($nro_pago) $sql.= " AND a.nro_pago like '%$nro_pago%'";
    if($idpago) $sql.= " AND a.id_pago ='$idpago'";
    if($id_banco)  $sql.= " AND a.id_banco ='$id_banco'";
    if($status)		$sql.= " AND a.status_pago ='$status'";
    if( $desde AND  $hasta) $sql .= " AND  a.fecha_registro BETWEEN '$desde' AND '$hasta'";
   /* if( $desde AND !$hasta) $sql .= " AND  a.fec_pago >= '$desde'";
    if(!$desde AND  $hasta) $sql .= " AND  a.fec_pago <= '$hasta'";*/
    if($sercarveh)  $sql.= " AND a.sercarveh = '$sercarveh'";
    if($nombre)     $sql.= " AND a.nomcomp like '%$nombre%'";
     if($codpro)     $sql.= " AND a.codpro like '%$codpro%'";
    // Si $id_caso = 1: Sólo se listan los pagos que no hayan sido depositados
    // en otro caso se listan todos los pagos.
    if($id_caso==1) $sql.= " AND a.id_deposito IS NULL AND a.nro_deposito IS NULL";

    $sql.= ") w";

  //print 'CONTAR: '.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 function contarPagos_Anulados($nro_pago=null,$id_banco=null,$desde=null,$hasta=null,$sercarveh=null,$codpro=null,$nombre=null,$id_caso=1,$status=null,$tipo=null){



$sql="select count (a.id_pago)  from pago a,banco b ,propietarios c where a.status='E' and a.id_banco=b.id_banco and a.codpro=c.codpro
";


    if($nro_pago) $sql.= " AND a.nro_pago = '$nro_pago'";
    if($id_banco)  $sql.= " AND a.id_banco ='$id_banco'";
    if($status)		$sql.= " AND a.status_pago ='$status'";
    if( $desde AND  $hasta) $sql .= " AND  a.fec_reg BETWEEN '$desde' AND '$hasta'";
   /* if( $desde AND !$hasta) $sql .= " AND  a.fec_pago >= '$desde'";
    if(!$desde AND  $hasta) $sql .= " AND  a.fec_pago <= '$hasta'";*/
    if($sercarveh)  $sql.= " AND a.sercarveh = '$sercarveh'";
    if($nombre)     $sql.= " AND a.nomcomp like '%$nombre%'";
     if($codpro)     $sql.= " AND a.codpro like '%$codpro%'";
    // Si $id_caso = 1: Sólo se listan los pagos que no hayan sido depositados
    // en otro caso se listan todos los pagos.
    if($id_caso==1) $sql.= " AND a.id_deposito IS NULL AND a.nro_deposito IS NULL";

  //  $sql.= ") w";

  //print 'CONTAR: '.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					// $pago,        $id_banco,     $fec1,      $fec2,      $sercarveh,     $codpro,     $nombre,     $status,     $offset,  $nroFilas,    id_caso
 function listarPagos($nro_pago=null,$id_banco=null,$desde=null,$hasta=null,$sercarveh=null,$codpro=null,$nombre=null,$status=null,$offset=0,$nroFilas=15,$id_caso=1,$tipo=null,$idpago=null){
	if(!$tipo) $tipo='A';
 	$sql="SELECT   a.id_pago , a.nro_pago , a.monto , a.fec_pago,
				'' , a.id_banco , a.nro_cuenta , a.banco_descrip , a.id_asignacion , a.sercarveh ,
				a.codpro , a.nom , a.fec_reg
				from (
				select a.id_pago, a.id_asignacion, c.nomcomp, a.monto, g.desmod, to_char(a.fec_reg,'dd/mm/yyyy') as  fec_reg,
				nro_pago, a.nro_cuenta, h.banco_descrip , to_char(a.fec_pago,'dd/mm/yyyy') as fec_pago, e.sercarveh, i.codpro , i.nomcomp  as nom, a.id_banco, a.fec_reg as fecha_registro
				from pago a , facturaprof b, propietarios c,  vehiculo e, caracteristica f, modelo g, banco h, asignacion d
				INNER JOIN propietarios i ON (d.codpro = i.codpro)
				where
				a.id_asignacion=b.id_asignacion
				and b.estatus='$tipo'
				and a.status='A'
				and b.id_asignacion=d.id_asignacion
				and d.codpro=c.codpro
				and d.sercarveh=e.sercarveh
				and e.id_caract=f.id_caract
				and f.codmod=g.codmod
				and a.id_banco=h.id_banco
				union all
				select a.id_pago, a.id_asignacion, c.nomcomp, a.monto, g.desmod, to_char(a.fec_reg,'dd/mm/yyyy') as fec_reg,
				 nro_pago, a.nro_cuenta, f.banco_descrip , to_char(a.fec_pago,'dd/mm/yyyy') as fec_pago, '0' as sercarveh, i.codpro , i.nomcomp as nom, a.id_banco, a.fec_reg as fecha_registro
				from pago a , facturaprof b, propietarios c,  preinventario e, banco f, modelo g, asignacion d
				INNER JOIN propietarios i ON (d.codpro = i.codpro)
				where
				a.id_asignacion=b.id_asignacion
				and b.estatus='$tipo'
				and a.status='A'
				and b.id_asignacion=d.id_asignacion
				and d.codpro=c.codpro
				and d.id_preinv=e.id_preinv
				and e.id_modelo=g.codmod
				and a.id_banco=f.id_banco
				) a where a.id_pago is not null ";

    if($nro_pago) $sql.= " AND a.nro_pago like '%$nro_pago%'";
    if($idpago) $sql.= " AND a.id_pago ='$idpago'";
    if($id_banco)  $sql.= " AND a.id_banco ='$id_banco'";
    if($status)		$sql.= " AND a.status_pago ='$status'";
    if( $desde AND  $hasta) $sql .= " AND  a.fecha_registro BETWEEN '$desde' AND '$hasta'";
  /*  if( $desde AND !$hasta) $sql .= " AND  a.fec_pago >= '$desde'";
    if(!$desde AND  $hasta) $sql .= " AND  a.fec_pago <= '$hasta'";*/
    if($sercarveh)  $sql.= " AND a.sercarveh = '$sercarveh'";
    if($nombre)     $sql.= " AND a.nomcomp like '%$nombre%'";
     if($codpro)     $sql.= " AND a.codpro like '%$codpro%'";
    // Si $id_caso = 1: Sólo se listan los pagos que no hayan sido depositados
    // en otro caso se listan todos los pagos.
    if($id_caso==1) $sql.= " AND a.id_deposito IS NULL AND a.nro_deposito IS NULL";
    $sql.= " ORDER BY fec_reg desc, 1 desc ";
    if($offset>=0)     $sql.= "LIMIT $nroFilas OFFSET $offset";

 //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


 function listarPagos_Anulados($nro_pago=null,$id_banco=null,$desde=null,$hasta=null,$sercarveh=null,$codpro=null,$nombre=null,$status=null,$offset=0,$nroFilas=15,$id_caso=1,$tipo=null){
	if(!$tipo) $tipo='A';
 	$sql="SELECT   a.id_pago ,a.nro_pago ,a.monto ,to_char(a.fec_pago,'dd/mm/yyyy') as fec_pago
				, a.id_banco ,a.nro_cuenta ,b.banco_descrip , a.id_asignacion ,a.sercarveh ,
				a.codpro , c.nomcomp , to_char(a.fec_reg,'dd/mm/yyyy') as  fec_reg
				from pago a,banco b ,propietarios c where a.status='E' and a.id_banco=b.id_banco and a.codpro=c.codpro ";

    if($nro_pago) $sql.= " AND a.nro_pago = '$nro_pago'";
    if($id_banco)  $sql.= " AND a.id_banco ='$id_banco'";
    if($status)		$sql.= " AND a.status_pago ='$status'";
    if( $desde AND  $hasta) $sql .= " AND  a.fec_reg BETWEEN '$desde' AND '$hasta'";
    if($sercarveh)  $sql.= " AND a.sercarveh = '$sercarveh'";
    if($nombre)     $sql.= " AND c.nomcomp like '%$nombre%'";
     if($codpro)     $sql.= " AND a.codpro like '%$codpro%'";
    $sql.= " ORDER BY fec_reg desc, 1 desc ";
    if($offset>=0)     $sql.= "LIMIT $nroFilas OFFSET $offset";

  //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function printPagos($idPago){
  $conexion = $this->conectar();

  $preinv = "select a.id_asignacion, b.id_preinv from pago a, asignacion b where  a.id_asignacion=b.id_asignacion and id_pago= $idPago";

  $consultapreinv = $this->consultar($conexion,$preinv);
  $datapreinv = $this->ret_vector($consultapreinv);
//echo 'pre:'.$datapreinv[1];

if (!$datapreinv[1])
 $sql = "SELECT".
	 	"   a.id_pago".
	 	" , a.nro_pago".
	 	" , a.monto".
	 	" , to_char(a.fec_pago,'dd/mm/yyyy')".
	 	" , a.status_pago".
	 	" , a.id_banco".
	 	" , d.nom_banco".
	 	" , a.nro_cuenta".
	 	" , TRIM(c.nomcomp)".
	 	" , c.codpro".
	 	" , e.desmar".
	 	" , f.desmod, '' , a.tipo ".
		" FROM pago a ".
		" INNER JOIN asignacion b ON a.id_asignacion = b.id_asignacion".
		" INNER JOIN propietarios c ON b.codpro = c.codpro".
		" INNER JOIN banco d ON d.id_banco = a.id_banco".
		" INNER JOIN vehiculo h ON h.sercarveh = b.sercarveh".
		" INNER JOIN caracteristica g ON g.id_caract = h.id_caract".
		" INNER JOIN marcas e ON e.codmar = g.codmarveh".
		" INNER JOIN modelo f ON f.codmod = g.codmod ".
		" WHERE a.status='A'  ";
else
		 	$sql = "SELECT".
	 	"   a.id_pago".
	 	" , a.nro_pago".
	 	" , a.monto".
	 	" , to_char(a.fec_pago,'dd/mm/yyyy')".
	 	" , a.status_pago".
	 	" , a.id_banco".
	 	" , d.nom_banco".
	 	" , a.nro_cuenta".
	 	" , TRIM(c.nomcomp)".
	 	" , c.codpro".
	 	" , e.desmar".
	 	" , f.desmod, b.id_preinv,  a.tipo ".
		" FROM pago a  ".
		" INNER JOIN asignacion b ON a.id_asignacion = b.id_asignacion".
		" INNER JOIN propietarios c ON b.codpro = c.codpro".
		" INNER JOIN banco d ON d.id_banco = a.id_banco, preinventario i  ".
		" INNER JOIN marcas e ON e.codmar = i.id_marca".
		" INNER JOIN modelo f ON f.codmod = i.id_modelo".
		" WHERE a.status='A'  and b.status='A'  and i.id_preinv=b.id_preinv ";

	$sql1 = $sql." AND a.id_pago = $idPago";
//	print ($sql1);

	$reg = @pg_query($conexion,$sql1);
	$dat = pg_fetch_array($reg);

	$codpro = $dat[9];
	$sql2 = $sql." AND c.codpro = '$codpro'";
	$sql2.= " ORDER BY 1";
// < $consulta > : Contiene todos los registros de pago de un propietario dado < $codpro >

//f_alert($sql2);

  $consulta = $this->consultar($conexion,$sql2);
  $data = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $data;
 }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function modificarPago($id_pago,$data,$status_pago){
  $fecha = date('d/m/Y');
  $sql ="UPDATE pago SET ".
	 	"   nro_pago = '$data[0]'".
	 	" , fec_pago = '$data[1]'".
	 	" , monto = '$data[2]'".
	 	" , id_banco = '$data[3]'".
	 	" , nro_cuenta = '$data[4]'".
	 	" , fec_mod = '$fecha'".
	 	" , status_pago = '$status_pago'".
  		" WHERE id_pago = $id_pago AND sercarveh = '$data[6]'";

//  print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/');
  return $consulta;
 }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function Cuenta_pago($id_asignacion){

$sql="select count (id_pago) from pago where id_asignacion='$id_asignacion'";

	$conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 // print 'CONTAR: '.$sql;

 }
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function ActivarPagoAnulado($id_pago,$data,$status_pago,$codpro){
   $fecha = date('d/m/Y');

   $sql1="SELECT a.sercarveh,a.codpro,a.id_asignacion from asignacion a,pago b  where  a.codpro=b.codpro and a.sercarveh='".$data[6]."' and a.status='A'";
  // print '<pre>'; print $sql1;
    $conexion = $this->conectar();
	$consulta1 = $this->consultar($conexion,$sql1);
    $consulta1 = $this->ret_vector($consulta1);


     	$sql2="SELECT id_asignacion from facturaprof  where  id_asignacion='".$consulta1[2]."' and sercarveh='".$data[6]."' and estatus='A'";
	   // print '<pre>'; print $sql2;

	    $conexion = $this->conectar();
		$consulta2 = $this->consultar($conexion,$sql2);
	    $consulta2 = $this->ret_vector($consulta2);

	if (($consulta1!=null) and  ($consulta2!=null)){
		  $sql ="UPDATE pago SET ".
			 	"  fec_mod = '$fecha'".
			 	" , sercarveh = '$data[6]'".
			 	" , status='A'".
			 	" , id_asignacion='$consulta1[2]'".
		  		" WHERE id_pago = $id_pago AND codpro = '$codpro'";
		 // print '<pre>'.$sql.'  <---- sql ';

		  $conexion = $this->conectar();
		  $consulta = $this->consultar($conexion,$sql);
		 // $consulta = $this->ret_vector($consulta);
		  $this->desconectar($conexion);


		/* $sql3=" UPDATE facturaprof SET  id_estatus='6' WHERE id_asignacion = '".$consulta1[2]."' and  sercarveh='".$data[6]."' and estatus='A'";

		 	 print '<pre>'.$sql3.'  <---- sql 3';
		 	 $conexion = $this->conectar();
		 	 $consulta3 = $this->consultar($conexion,$sql3);
		  	$consulta3 = $this->ret_vector($consulta3);

		  	echo "<br>Consulta3".$consulta3;
			$this->desconectar($conexion);*/
			if($consulta) $this->auditar('MODIFICAR- Activó Pago Anulado ',$sql,'http://localhost/refeciv1.1/vistas/');
			//if($consulta3) $this->auditar('MODIFICAR- Cambió estatus proforma a 6 ',$sql3,'http://localhost/refeciv1.1/vistas/');
   }
	return $consulta;
}


function modificarStatusalCambiarPago($id_asignacion,$sercarveh){
  $sql=" UPDATE facturaprof SET  id_estatus='6' WHERE id_asignacion = '".$id_asignacion."' and  sercarveh='".$sercarveh."' and estatus='A'";

		 //	 print '<pre>'.$sql.'  <---- sql 3';
		 	 $conexion = $this->conectar();
		 	 $consulta = $this->consultar($conexion,$sql);
		  	$consulta = $this->ret_vector($consulta);

		  	//echo "<br>Consulta3".$consulta;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/');
  return $consulta;
 }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 function listarBancos($selTab=null,$codbanco=null){

      if($selTab==1) $sql = "SELECT id_banco, banco_descrip, nro_cuenta FROM banco_cuentas WHERE status = 'A' ORDER BY 1";
  elseif($selTab==2) $sql = "SELECT id_banco, nom_banco     FROM banco WHERE status = 'A' ORDER BY 2";
  elseif($selTab==3) $sql = "SELECT id_banco, banco_descrip     FROM banco WHERE status = 'A' and tipo='1' ORDER BY 2";
  elseif($selTab==4) {
  	                  $sql = "SELECT id_banco, banco_descrip, contacto     FROM banco WHERE status = 'A' and tipo='1' ";
  	                  if($codbanco) $sql.=" and id_banco='".$codbanco."' ";
  	                  $sql.=" ORDER BY 2 ";
                      }
                else $sql = "SELECT id_banco, banco_descrip FROM banco WHERE status = 'A' ORDER BY 2";

  //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 function AnularPago($id_pago,$msj){
  $sql1="SELECT a.sercarveh,a.codpro from asignacion a,pago b where a.id_asignacion=b.id_asignacion and b.id_pago='".$id_pago."'";
   //print '<pre>'; print $sql1;

    $conexion = $this->conectar();
	$consulta1 = $this->consultar($conexion,$sql1);
    $consulta1 = $this->ret_vector($consulta1);
  $sql= "UPDATE pago SET status='E' WHERE id_pago='".$id_pago."'";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $data = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('ANULAR',$sql,'http://localhost/refeciv1.1/vistas/listado_pagos.php');
  if($consulta) $this->bitacoraBeneficiario($consulta1[1],$consulta1[0],'Se anulo el pago N#:'.$id_pago,$_SESSION['usuario']);
  return $consulta;
 }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  function cambiaStatus($id_pago,$status_pago){
  $sql = "UPDATE pago SET status_pago = '$status_pago' WHERE id_pago=$id_pago";

  //print '<pre>'; print $sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/');
  return $consulta;
  }

  function inicialConsignada($codpro){

  	$conexion = $this->conectar();
  	$sql = "SELECT SUM(a.monto) FROM pago a, asignacion b  WHERE a.id_asignacion=b.id_asignacion and b.codpro='".$codpro."' and a.status='A' ";
  	//print $sql;
    $consulta = $this->consultar($conexion,$sql);
    $data = $this->ret_vector($consulta);
    $this->desconectar($conexion);

  return $data[0];
 }

 function regComentarioPag($id,$comentario,$usuario){
  $fecha=date('d/m/Y');
  $this->bitacoraBeneficiario($id,'','Comentario: '.$comentario,$usuario);
   if ($this->bitacoraBeneficiario) return true; else return false;
 }
}
?>