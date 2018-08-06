<?php
class consulta extends conexion{

function consultaStatus($cedula){

	$cant = strlen($cedula);
	//echo $cant.'<br>';
	if ($cant==8){ $cedula2='V'.$cedula; }
	if ($cant==7){ $cedula2='V0'.$cedula; }

$sql = "select to_char(a.fecha,'dd/mm/yyyy'), UPPER(a.estatusdes), UPPER(a.nombrestatus), a.numenvveh, a.estatus, UPPER(a.descripcion), (a.desbanco), a.monto, a.codpro  from (

SELECT 'Expediente Enviado - ' as nombrestatus, 0 as estatus, '' as descripcion, a.codpro as codpro, b.fecha as fecha, c.banco_descrip as desbanco, 0 as monto, '' as estatusdes, 0 as numenvveh
FROM detmemoexp a, memoexp b, banco c
WHERE a.id_memoexp=b.id_memoexp and a.status='A' and b.id_banco=c.id_banco

union all

SELECT '' as nombrestatus, a.id_estatus as estatus, b.descripcion as descripcion, c.codpro as codpro, fecha_estatus as fecha, d.banco_descrip as desbanco, 0 as monto, '' as estatusdes, 0 as numenvveh
FROM facturaprof a
INNER JOIN estatus b ON a.id_estatus=b.id_estatus
INNER JOIN asignacion c ON a.id_asignacion=c.id_asignacion
left outer join banco d ON a.id_banco=d.id_banco
WHERE a.estatus='A'

union all

SELECT 'Certificado enviado - ' as nombrestatus, 0 as estatus, '' as descripcion, a.codpro as codpro, c.fecha as fecha, d.banco_descrip as desbanco, 0 as monto, '' as estatusdes, 0 as numenvveh
FROM detmemocert e INNER JOIN certificados b
INNER JOIN asignacion a ON a.id_asignacion=b.id_asignacion ON e.numcerveh=b.numcerveh
INNER JOIN memocert c left outer join banco d ON c.id_banco=d.id_banco ON c.id_memocert=e.id_memocert
WHERE b.estatus='A' and a.status='A' and e.status='A' and c.status='A'

union all

SELECT 'Monto - ' as nombrestatus, 0 as estatus, '' as descripcion, a.codpro as codpro, a.fecha_mod as fecha, b.banco_descrip as desbanco, a.monto as monto, c.descripcion as estatusdes, 0 as numenvveh
FROM credito a, banco b, estatus c
WHERE a.id_banco=b.id_banco and a.estatus=c.id_estatus

union all


SELECT 'Datos enviados al INTT. N° de Envio' as nombrestatus, 0 as estatus, '' as descripcion, a.codpro,

to_date(fechatxtveh,'DD/MM/YYYY') as fecha, '' as desbanco, 0 as monto, '' as estatusdes, b.numenvveh as numenvveh

FROM asignacion a, certificados b
WHERE a.id_asignacion=b.id_asignacion and b.estatus='A' and a.status='A' and b.estatusveh='E'

) a where a.codpro like '%".$cedula2."%' order by a.fecha  ";

//echo $sql;
	$conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $usuario;

}

function consultaCredito($cedula){

	$cant = strlen($cedula);
	//echo $cant.'<br>';
	if ($cant==8){ $cedula2='V'.$cedula; }
	if ($cant==7){ $cedula2='V0'.$cedula; }

	$sql = "SELECT to_char(a.fecha_mod,'dd-mm-yyyy'), c.descripcion, b.banco_descrip, a.monto
			FROM credito a, banco b, estatus c";
    $sql = $sql." WHERE a.id_banco=b.id_banco
    				and a.estatus=c.id_estatus
    				and a.codpro like '%".$cedula2."%' ";

   //echo $sql.'<br>';
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $usuario;
}

function consultaCredito2($cedula){

	$sql = "SELECT c.descripcion, a.estatus, a.monto
			FROM credito a, estatus c";
    $sql = $sql." WHERE a.estatus=c.id_estatus
    				and a.codpro like '%".$cedula."%' ";

   //echo $sql.'<br>';
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $usuario;
}

function cambioEstatus($cedula,$estatus){
	$hora=date('H:i:s');
	$fecha=date('d/m/Y');
	$sql = "UPDATE credito
			SET estatus='".$estatus."', usuario_mod='".$_SESSION['usuario']."', fecha_mod='".$fecha."', hora_mod='".$hora."'";
    $sql = $sql." WHERE codpro like '%".$cedula."%' ";
   //echo $sql.'<br>';
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->auditar($_SESSION['usuario'],'CREDITO','Cambio estatus de credito: '.$estatus.' - '.$cedula.' hora: '.$hora);
	$this->desconectar($conexion);
	return $consulta;
}

function cambioMonto($cedula,$monto){
	$hora=date('H:i:s');
	$fecha=date('d/m/Y');
	$sql = "UPDATE credito
			SET monto='".$monto."', usuario_mod='".$_SESSION['usuario']."', fecha_mod='".$fecha."', hora_mod='".$hora."'";
    $sql = $sql." WHERE codpro like '%".$cedula."%' ";
   //echo $sql.'<br>';
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$this->auditar($_SESSION['usuario'],'CREDITO','Cambio monto de credito: '.$monto.' - '.$cedula.' hora: '.$hora);
	$this->desconectar($conexion);
	return $consulta;
}


function consultaRafaga($cedula){

	$cant = strlen($cedula);
	//echo $cant.'<br>';
	if ($cant==8){ $cedula2='V'.$cedula; }
	if ($cant==7){ $cedula2='V0'.$cedula; }

	$sql = "SELECT b.numenvveh, b.fechatxtveh, b.estatusveh
			FROM asignacion a, certificados b ";
    $sql = $sql." WHERE a.id_asignacion=b.id_asignacion
    				and a.codpro like '%".$cedula2."%'
    				and b.estatus='A' and a.status='A' and b.estatusveh='E'";

   //echo $sql.'<br>';
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $usuario;
}


function consultaCert($cedula){

	$cant = strlen($cedula);
	//echo $cant.'<br>';
	if ($cant==8){ $cedula2='V'.$cedula; }
	if ($cant==7){ $cedula2='V0'.$cedula; }

	$sql = "SELECT a.id_asignacion, a.codpro, b.numcerveh, to_char(c.fecha,'dd-mm-yyyy'), d.banco_descrip
			FROM detmemocert e
					INNER JOIN certificados b
						INNER JOIN asignacion a ON a.id_asignacion=b.id_asignacion ON e.numcerveh=b.numcerveh
					INNER JOIN memocert c
						left outer join banco d ON c.id_banco=d.id_banco ON c.id_memocert=e.id_memocert ";
    $sql = $sql." WHERE a.codpro like '%".$cedula2."%'
    				and b.estatus='A' and a.status='A' and e.status='A' and c.status='A' ";

   //echo $sql.'<br>';
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $usuario;
}

function consultaBenef($cedula){

	$sql = "SELECT codpro, nomcomp FROM repbenefsol ";
    $sql.=" WHERE codpro=$cedula" ;

   	//echo ' 1 '.$sql.'<br>';
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
	$descripcion = $this->ret_vector($consulta);
	$this->desconectar($conexion);

	if (!$descripcion){

	$cant = strlen($cedula);
	//echo $cant.'<br>';
	if ($cant==8){ $cedula2='V'.$cedula; }
	if ($cant==7){ $cedula2='V0'.$cedula; }

	$sql = "SELECT codpro, nomcomp FROM propietarios ";
    $sql.=" WHERE codpro like '%".$cedula2."%' ";

   	//echo ' 2 '.$sql.'<br>';
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$descripcion = $this->ret_vector($consulta);
	$this->desconectar($conexion);

	}
	return $descripcion;
}

function consultaPresirecov($cedula){

	$sql = "SELECT codpro, fecha_cita, asiste, to_char(fecha_cita,'dd-mm-yyyy'),turno  FROM ususolcit ";
    $sql.=" WHERE codpro=$cedula";

   	//echo $sql;
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
	$descripcion = $this->ret_vector($consulta);

	$cant=count($descripcion)/5;

	if ($cant>1) {
		$sql = "SELECT codpro, fecha_cita, asiste, to_char(fecha_cita,'dd-mm-yyyy'),turno  FROM ususolcit ";
    	$sql.=" WHERE codpro=$cedula and asiste<>'V' ";
    	$conexion = $this->conectar2();
		$consulta = $this->consultar($conexion,$sql);
	    $descripcion = $this->ret_vector($consulta);
	}
	//echo 'cantidad'.$cant;

	$this->desconectar($conexion);

	return $descripcion;
}

function consultaExpediente($cedula){

	$cant = strlen($cedula);
	//echo $cant.'<br>';
	if ($cant==8){ $cedula2='V'.$cedula; }
	if ($cant==7){ $cedula2='V0'.$cedula; }


	$sql = "SELECT to_char(b.fecha,'dd-mm-yyyy'), a.codpro, c.banco_descrip FROM detmemoexp a, memoexp b, banco c ";
    $sql = $sql." WHERE a.id_memoexp=b.id_memoexp and a.codpro like '%".$cedula2."%' and a.status='A' and b.id_banco=c.id_banco";

    //echo $sql.'<br>';
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $usuario;
}

function consultaFacturaProf($cedula){

	$cant = strlen($cedula);
	//echo $cant.'<br>';
	if ($cant==8){ $cedula2='V'.$cedula; }
	if ($cant==7){ $cedula2='V0'.$cedula; }

	$sql = "SELECT a.id_estatus, b.descripcion, to_char(fecha_estatus,'dd-mm-yyyy'), d.banco_descrip
			FROM facturaprof a
						INNER JOIN estatus b ON a.id_estatus=b.id_estatus
						INNER JOIN asignacion c ON a.id_asignacion=c.id_asignacion
						left outer join banco d ON a.id_banco=d.id_banco";
    $sql = $sql." WHERE c.codpro like '%".$cedula2."%' and a.estatus='A'";
    //echo $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$usuario2 = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $usuario2;
}

}
?>