<?php
///////////////////////////////////////////////////////////////
// 				FUNCIONES RELATIVAS A DEPOSITOS 			///
///////////////////////////////////////////////////////////////
class deposito extends conexion{

 /////////////////////////////////////////////////////////////////////////////////////////////////////////

  function listarPagosDep($id_deposito=null){

 	$sql = "SELECT".
	 	"   a.id_pago".
	 	" , a.nro_pago".
	 	" , a.monto".
	 	" , to_char(a.fec_pago,'dd/mm/yyyy')".
	 	" , a.status_pago".
	 	" , a.id_banco".
	 	" , d.nom_banco".
	 	" , a.nro_cuenta".
	 	" , f.nomcomp".
	 	" , f.codpro".
	 	" , to_char(a.fec_reg,'dd/mm/yyyy')".
		" FROM pago a ".
		" INNER JOIN banco d ON (a.id_banco = d.id_banco)".
		" INNER JOIN asignacion e ON (e.id_asignacion = a.id_asignacion)".
		" INNER JOIN propietarios f ON (f.codpro = e.codpro)".
		" WHERE a.status = 'A' ";
    if($id_deposito) $sql.= "AND a.id_deposito = ".$id_deposito;
    $sql.= " ORDER BY 6,2  ";

// 	print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

/////////////////////////////////////////////////////////////////////////////////////////////////////////

 function buscarDeposito($id_deposito,$tablaPagos,$msj=null){

    $sql = "SELECT id_deposito, nro_deposito, to_char(fec_deposito,'dd/mm/yyyy')".
			", b.banco_descrip,b.nro_cuenta,a.id_banco,tot_monto,fec_reg".
    		" FROM deposito a ".
    		" INNER JOIN banco_cuentas b ON b.id_banco = a.id_banco".
    		" WHERE a.status = 'A'";
    if($id_deposito) {
    	$sql.= " AND id_deposito = ".$id_deposito;
    	$tablaPagos = $this->listarPagosDep($id_deposito);
    }
    else {
    	$msj = "Depósito no existe en tabla";
    	return null;
    }
//  print '<br>'.$sql;

    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);
    $contF = $this->ret_vector($consulta);

	return $contF;
 }

/////////////////////////////////////////////////////////////////////////////////////////////////////////

function listarBancos($selTab=null){

  if($selTab==1) $sql = "SELECT id_banco, banco_descrip, nro_cuenta FROM banco_cuentas WHERE status = 'A' ORDER BY 1";
  else $sql = "SELECT id_banco, banco_descrip FROM banco WHERE status = 'A'  ORDER BY 2";

// print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

/////////////////////////////////////////////////////////////////////////////////////////////////////////

 function AnularDeposito($id_deposito,$msj){
  $conexion = $this->conectar();
  $fecha = date("Y-m-d");

  $sql = "UPDATE pago SET id_deposito=null, nro_deposito=null, status_pago=null, fec_mod='$fecha' WHERE id_deposito=$id_deposito;";
  $sql.= "UPDATE deposito SET status = 'E' WHERE id_deposito=$id_deposito";

//f_alert($sql);

  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) {
  	$this->auditar('ANULAR',$sql,'http://localhost/refeciv1.1/vistas/');
  	$msj = "Depósito ha sido anulado satisfactoriamente";
  }
  else $msj = "ERROR: Imposible reversar pago(s) ni anular el deposito asociado ($consulta)";

  return $consulta;
 }

/////////////////////////////////////////////////////////////////////////////////////////////////////////
						//  $numDeposito,$nomBanco,$codBanco.$numCtaBanco,$fecDeposito,$sercarveh,$idAsig
 function registrarDeposito($tab_ipago,$data,$nFallas,$msj){

    $conexion = $this->conectar();

    $sql = "SELECT id_deposito,nro_deposito,to_char(fec_deposito,'dd/mm/yyyy'),banco_descrip,tot_monto".
			" FROM deposito a INNER JOIN banco_cuentas b ON b.id_banco = a.id_banco ".
			" WHERE nro_deposito = '".$data[0]."' AND b.id_banco = '".$data[2]."'";

//   print '<pre>'.$sql;

    $consulta = $this->consultar($conexion,$sql);
    $contF = $this->ret_vector($consulta);

/////////////////////////////////////////////////////////////////////////////////////////////////////////


	if($contF){
  		$msj.= '\nYa existe un depósito previo con datos similares:';
  		$msj.= '\n      Depósito N° '.$contF[0];
  		$msj.= '\n      Planilla N° '.$contF[1];
  		$msj.= '\n      Fecha: '.$contF[2];
  		$msj.= '\n      Banco: '.$contF[3];
  		$msj.= '\n      Monto: '.formatomonto($contF[4]);
  		$this->desconectar($conexion);
  		return false;
  	}

    $fecha=date('d/m/Y');

    $sql = "SELECT MAX(id_deposito) FROM deposito ";

//  print '<pre>'.$sql;

    $consulta = $this->consultar($conexion,$sql);
    $contF = $this->ret_vector($consulta);
    $id_deposito = $contF[0]+1;


    $sql = "INSERT INTO deposito ";
    $sql.= "(id_deposito, nro_deposito, fec_deposito, id_banco, nro_cuenta, tot_monto, fec_reg)";
	$sql.= " VALUES ('".$id_deposito."','".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."',".$data[4].",'".$fecha."')";

 $consulta = $this->consultar($conexion,$sql);
  if(!$consulta){
  	$msj.= '\n ERROR SQL: No pudo registrarse depósito';
  }
  if ($consulta) {
  		$consulta=$id_deposito;
  		$cantPagos = count($tab_ipago);

  		for($i=0;$i<$cantPagos;$i++){
			  $sql = "UPDATE pago SET id_deposito = ".$id_deposito.", nro_deposito = '".$data[0]."'".
			  		 " WHERE id_pago=".$tab_ipago[$i];

//			  print '<pre>'.$sql;

			  $consulta = $this->consultar($conexion,$sql);
			  if(!$consulta){
			  		$nFallas++;
			  		$msj .= '\n ERROR SQL: Pago N°'.$tab_ipago[$i].' no pudo ser actualizado';
			  }
  		}
  }
  $this->desconectar($conexion);
  if($consulta) {
  	$this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/');
  	$msj = "\n Depósito registrado con N°: $id_deposito";
  }
  return $consulta;
 }

/////////////////////////////////////////////////////////////////////////////////////////////////////////
//						  $id_deposito     ,$desde     ,$hasta     ,$id_banco
 function contarDepositos($id_deposito=null,$desde=null,$hasta=null,$id_banco=null){

 	$sql = "SELECT count(a.id_deposito)	FROM deposito a	WHERE a.status = 'A' ";
    if($id_deposito)		$sql.= " AND a.id_deposito = ".$id_deposito;
    if($id_banco)   		$sql.= " AND a.id_banco = '".$id_banco."'";
    if( $desde AND  $hasta) $sql.= " AND a.fec_deposito BETWEEN '".$desde."' AND '".$hasta."'";
    if(!$desde AND  $hasta) $sql.= " AND a.fec_deposito <= '".$hasta."'";
    if( $desde AND !$hasta) $sql.= " AND a.fec_deposito >= '".$desde."'";

// print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

/////////////////////////////////////////////////////////////////////////////////////////////////////////
//						  $id_deposito     ,$desde     ,$hasta     ,$id_banco     ,$offset
 function listarDepositos($id_deposito=null,$desde=null,$hasta=null,$id_banco=null,$offset=null){

 	$sql = "SELECT id_deposito, nro_deposito, tot_monto, to_char(fec_deposito,'dd/mm/yyyy'),".
 		   " b.banco_descrip, a.id_banco||'-'||b.nro_cuenta, to_char(fec_reg,'dd/mm/yyyy')".
		   " FROM deposito a INNER JOIN banco_cuentas b ON (b.id_banco = a.id_banco) WHERE a.status = 'A' ";

    if($id_deposito) $sql.= " AND a.id_deposito = ".$id_deposito;
    if($id_banco)    $sql.= " AND a.id_banco = '".$id_banco."'";

    if( $desde AND  $hasta) $sql.= " AND  a.fec_deposito BETWEEN '".$desde."' AND '".$hasta."'";
    if( $desde AND !$hasta) $sql.= " AND  a.fec_deposito >= '".$desde."'";
    if(!$desde AND  $hasta) $sql.= " AND  a.fec_deposito <= '".$hasta."'";

    $sql.= " ORDER BY 1 ";
    if($offset) $sql.= " LIMIT 15 OFFSET ".$offset;

//  print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

 /////////////////////////////////////////////////////////////////////////////////////////////////////////
 //$nro_dep,$fec_dep,$nro_cta,$bco_dep,$_SESSION['tot_Dep']
 function modificarDeposito($id_dep,$data,$msj){
  $sql ="UPDATE deposito SET ".
		" nro_deposito = '$data[0]'".
		",fec_deposito = '$data[1]'".
		",id_banco = '$data[2]'".
 		",nro_cuenta = '$data[3]'".
		",tot_monto = $data[4]".
 		" WHERE status = 'A' AND id_deposito = $id_dep";

//f_alert($sql);

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) {
	$this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/');
	$msj = '\n Depósito ha sido modificado satisfactoriamente';
  }
  else $msj = '\n'."ERROR: Depósito no pudo ser modificado (".$conexion.")";
  return $consulta;
 }

 }
?>
