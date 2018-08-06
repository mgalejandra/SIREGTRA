<?php
class relacionC extends conexion{

 /////////////////////////////////////////////////////////////////////////////////////////////////////////

  function listarChequeRem($id_remision=null){

   $sql="SELECT e.idrelcheq,to_char(e.fecha,'dd/mm/yyyy'),b.numcheque,b.monto,a.banco_descrip,c.id_asignacion,c.fecha_asig,c.sercarveh,d.codpro, d.prinompro,d.segnompro," .
    		"d.priapepro,d.segapepro,b.idcheque FROM rel_cheq e
INNER JOIN cheque b ON (e.idrelcheq = b.numrelcheq )
INNER JOIN banco a ON (b.id_banco = a.id_banco)
INNER JOIN asignacion c ON (b.id_asignacion = c.id_asignacion)
INNER JOIN propietarios d ON (c.codpro = d.codpro) ";

	$sql .= " where b.numrelcheq='".$id_remision."'";
	$sql.= " ORDER BY e.fecha,a.banco_descrip  ";

 // print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

///////////////////////

function listarChequeRemPDF($id_remision){

   $sql="SELECT e.reldesc,to_char(e.fecha,'dd/mm/yyyy'),b.numcheque,b.monto,a.banco_descrip,c.id_asignacion,c.fecha_asig," .
   		"c.sercarveh,d.codpro, d.prinompro,d.segnompro,d.priapepro,d.segapepro,b.idcheque FROM rel_cheq e
INNER JOIN cheque b ON (e.idrelcheq = b.numrelcheq )
INNER JOIN banco a ON (b.id_banco = a.id_banco)
INNER JOIN asignacion c ON (b.id_asignacion = c.id_asignacion)
INNER JOIN propietarios d ON (c.codpro = d.codpro) ";

	$sql .= " where e.idrelcheq='".$id_remision."'";
	$sql.= " ORDER BY e.fecha,a.banco_descrip  ";

 //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
/////////////////////////////////////////////////////////////////////////////////////////////////////////
  function buscarCheque($codigo){

   $sql="SELECT e.idrelcheq,to_char(e.fecha,'dd/mm/yyyy'),b.numcheque,b.monto,a.banco_descrip,c.id_asignacion,c.fecha_asig,c.sercarveh,d.codpro, d.prinompro,d.segnompro," .
    		"d.priapepro,d.segapepro,b.idcheque FROM rel_cheq e
INNER JOIN cheque b ON (e.idrelcheq = b.numrelcheq )
INNER JOIN banco a ON (b.id_banco = a.id_banco)
INNER JOIN asignacion c ON (b.id_asignacion = c.id_asignacion)
INNER JOIN propietarios d ON (c.codpro = d.codpro) ";

	$sql .= " where b.idcheque='".$codigo."'";

  //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

/////////////////////////////////////////////////////////////////////////////////////////////////////////

function listarBancos($selTab=null){

  if($selTab==1) $sql = "SELECT id_banco, banco_descrip, nro_cuenta FROM banco_cuentas WHERE status = 'A' ORDER BY 1";
  else $sql = "SELECT id_banco, banco_descrip FROM banco WHERE status = 'A'  ORDER BY 2";

  //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


///////////////////////////////////////////////////////
function buscarBanco($nombre=null){

  $sql = "SELECT id_banco from banco WHERE banco_descrip = '$nombre'";

  //print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////

 function registrarCheque($datos){

    $conexion = $this->conectar();

	$sql = "SELECT idcheque,numcheque, to_char(fecha,'dd/mm/yyyy'),banco_descrip,monto".
			" FROM cheque a INNER JOIN banco b ON b.id_banco = a.id_banco ".
			" WHERE a.numcheque = '".$datos[0]."' AND b.id_banco = '".$datos[3]."'";

  // print '<pre>'.$sql;

    $consulta = $this->consultar($conexion,$sql);
    $contF = $this->ret_vector($consulta);

	if($contF){
  		$msj.= '\nYa existe un cheque con datos similares asignado a esta remisión:';
  		$msj.= '\n      Cheque N° '.$contF[1];
  		$msj.= '\n      Fecha: '.$contF[2];
  		$msj.= '\n      Banco: '.$contF[3];
  		$msj.= '\n      Monto: '.formatomonto($contF[4]);
  		f_alert($msj);
  		$this->desconectar($conexion);
  		return false;
  	}
  	else
  	{
  		 $sql = "INSERT INTO cheque";
   		 $sql.= "(numcheque,id_banco,monto,id_asignacion,numrelcheq,fecha)";
		 $sql.= " VALUES ('".$datos[0]."','".$datos[3]."','".$datos[2]."','".$datos[4]."',".$datos[5].",'".$datos[1]."')";

       //  print "Inserto: ".$sql;
	     $consulta = $this->consultar($conexion,$sql);
  		 if(!$consulta){
  				$msj.= '\n ERROR SQL: No pudo registrarse el cheque';
  		}

  		 $this->desconectar($conexion);
 		/* if($consulta) {
  			$this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/');
  				$msj = "\n Depósito registrado con N°: $id_deposito";
  		}*/
  	}
  return $consulta;
 }

////
function modificarCheque($codigo,$data){
	$sql = "UPDATE cheque SET " .
			"numcheque='$data[0]'," .
            "id_banco='$data[3]'," .
			"monto='$data[2]'," .
			"id_asignacion='$data[4]', " .
			"fecha='$data[1]' " .
			"where idcheque='$codigo'";
    //print $sql;
   $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->desconectar($conexion);
   //     if($consulta) $this->auditar($_SESSION['usuario'],'MODIFICACION','Modifico expediente Nº '.$datos[0]);
	return $consulta;
}

/////
function contarChexRem($id_remision){

 	$sql = "SELECT count(a.idrelcheq) FROM cheque b, rel_cheq a ";
	$sql.=" where b.numrelcheq = '".$id_remision."' ";
    $sql .= "AND e.idrelcheq = b.numrelcheq";


 // print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }


/////////////////////////////////////////////////////////////////////////////////////////////////////////

 function contarRC($id=null,$desde=null,$hasta=null,$cheque=null){

 	$sql = "SELECT count(a.idrelcheq) FROM cheque b, rel_cheq a ";

 	if ($id or $desde or $hasta or $cheque){
 		$sql.=" where ";
 		 if($id){
 		 	$sql.= " AND a.idrelcheq = ".$id;
 		 	$c=1;
 		 }
    	 if( $desde AND  $hasta){
    	 	if ($c==1){
    	 		$sql.= " AND a.fecha BETWEEN '".$desde."' AND '".$hasta."'";
    	 	}
    	 	else
    	 		$sql.= " a.fecha BETWEEN '".$desde."' AND '".$hasta."'";
    	 }
    	 if(!$desde AND  $hasta){
    	 	if ($c==1){
 				$sql.= " AND a.fecha <= '".$hasta."'";
    	 	}
    	 	else
    	 		$sql.= " a.fecha <= '".$hasta."'";
    	 }
    	 if( $desde AND !$hasta){
    	 	if ($c==1){
				$sql.= " AND a.fecha >= '".$desde."'";
    	 	}
    	 	else
    	 		$sql.= " a.fecha >= '".$desde."'";
    	 }

    	  if($cheque){
    	 	if ($c==1){
    	 		 $sql.= " AND b.numcheque = '".$cheque."'";
    	 		 $c = 1;
    	 	}
    	 	else $sql.= " b.numcheque = '".$cheque."' ";
    	 	$sql .= "AND e.idrelcheq = b.numrelcheq";
    	 }
 	}


 // print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }

////////////////////////////////////////////////////////////////////////////////////////////////////////
function listarRC($id=null,$desde=null,$hasta=null,$cheque=null,$offset=null){

 	$sql =  "SELECT e.idrelcheq,e.fecha";

    if ($cheque)
    {
    	$sql.=",b.numcheque from cheque b,rel_cheq e where e.idrelcheq = b.numrelcheq";
    	$c=1;
    }
    else
     $sql.=" from rel_cheq e ";

 	if (($id or $desde or $hasta or $cheque) and ($c<>'1')){
 		$sql.= " where";
 	}

 	if ($id or $desde or $hasta or $cheque){

 		 if($id){
 		 	$sql.= " a.idrelcheq = ".$id;
 		 	$c = 1;
 		 }
    	 if( $desde AND  $hasta)
    	 {
    	 	if ($c==1){
    	 		$sql.= " AND e.fecha BETWEEN '".$desde."' AND '".$hasta."'";
    	 		$c = 1;
    	 	}
    	 	else $sql.= " a.fecha BETWEEN '".$desde."' AND '".$hasta."'";
    	 }
    	 if(!$desde AND  $hasta){
    	 	if ($c==1){
		        $sql.= " AND e.fecha <= '".$hasta."'";
    	 		$c = 1;
    	 	}
    	 	else $sql.= " e.fecha <= '".$hasta."'";
    	 }
    	 if( $desde AND !$hasta){

    	 	if ($c==1){
    	 		$sql.= " AND e.fecha >= '".$desde."'";
    	 		$c = 1;
    	 	}
    	 	else $sql.= " e.fecha >= '".$desde."'";
    	 }
    	 if($cheque){
    	 	if ($c==1){
    	 		 $sql.= " AND b.numcheque = '".$cheque."'";
    	 		$c = 1;
    	 	}
    	 	else $sql.= " b.numcheque = '".$cheque."' ";
    	 }
 	}

	//echo '<br>'.$sql;

    if($offset) $sql.= " LIMIT 15 OFFSET ".$offset;
//  print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

function regRemision($fecha,$contenido){
	$conexion = $this->conectar();

	$sql =  "INSERT INTO rel_cheq ".
				" (fecha, reldesc)".
		        " VALUES ('".$fecha."','".$contenido."')";

    //print "Inserta: ".$sql;

		$consulta = $this->consultar($conexion,$sql);

		//if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/');

		if ($consulta)
		{
			$sql1="Select max(idrelcheq) from rel_cheq";
			//echo $sql1;
			$consulta1 = $this->consultar($conexion,$sql1);
			$consulta1 = $this->ret_vector($consulta1);
			$_SESSION['remision_s']=$consulta1[0];
		}

		$this->desconectar($conexion);
		return $consulta;
 }

 }
?>
