<?php
class citas extends conexion{

function listarCitasCedula($desde,$hasta){


 if (!($desde) and !($hasta)) $fecha = date('d/m/Y');

 	$sql = "SELECT (b.personalidad||b.codpro||b.rif) as rif
		FROM ususolcit a, repbenefsol b WHERE a.codpro=b.codpro and a.asiste='S'";

    if ($fecha) 	$sql.= " and a.fecha_cita = '".$fecha."'";

	if($desde AND !($hasta)) $sql.= " and a.fecha_cita >= '".$desde."'";
	else if (!($desde) AND  $hasta) $sql.= " and a.fecha_cita <= '".$hasta."'";
	else if ($desde  AND  $hasta) $sql.= " and a.fecha_cita BETWEEN '".$desde."' AND '".$hasta."'";

	$sql.= " order by a.fecha_cita,a.codpro ";

 //  echo '<br>Listar: '.$sql;
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
	if($consulta) $usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);

   //echo "SQL cuenta: ".count($usuario);
	return $usuario;
}

function modconfirmarCita($rif=null,$cedula=null,$cita=null){

   $fecha = date('d/m/Y');

	$sql = "SELECT *
	FROM repbenefsol ";
    $sql = $sql." WHERE codpro=$cedula ";
    //echo $sql;
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
    $datos = $this->ret_vector($consulta);
	$this->desconectar($conexion);

	$sqlu = "SELECT usuario
	FROM repususol ";
    $sqlu = $sqlu." WHERE codpro=$cedula ";
    //echo $sqlu;
    $conexion = $this->conectar2();
	$consultaU = $this->consultar($conexion,$sqlu);
    $datosU = $this->ret_vector($consultaU);
	$this->desconectar($conexion);
	//echo '<BR>'.$datos[1];
	$cant = strlen($datos[1]);
	//echo '<BR>'.$cant;
	if ($cant==8){ $cedula=$datos[1]; }
	if ($cant==7){ $cedula='0'.$datos[1]; }
	if ($cant==6){ $cedula='00'.$datos[1]; }
	//echo '<BR>'.$cedula;
	$rifC=$datos[3].$cedula.$datos[2];
	//$datos[32]="0603";

	if ($consulta){

	 	$sql1="UPDATE propietarios SET prinompro='".$datos[4]."', segnompro='".$datos[5]."', priapepro='".$datos[6]."', segapepro='".$datos[7]."',
            nomcomp='".$datos[9]."', calavepro='".$datos[10]."', urbbarpro='".$datos[11]."', edicaspro='".$datos[12]."', numpispro='".$datos[13]."', numapapro='".$datos[14]."',
            dismunpro='".$datos[15]."', ciudadpro='".$datos[16]."', tlfcelpro='".$datos[17]."', tlfcel2pro='".$datos[18]."', obspro='".$datos[19]."',
            tipmovpro='".$datos[20]."', fecha_reg='".$datos[22]."', status='".$datos[24]."', codest='".$datos[25]."', codmun='".$datos[26]."', codpar='".$datos[27]."',
            sexo='".$datos[28]."', tipo=$datos[29], fecnac='".$datos[30]."', ced='".$datos[1]."', id_banco='".$datos[32]."', usuario_pro='".$datosU[0]."'
            WHERE codpro='".$rifC."'	";
        //echo '<BR>'.$sql1;
		$conexion = $this->conectar();
		$consulta = $this->consultar($conexion,$sql1);
		$this->desconectar($conexion);
	//echo $sql1;
	}
	if ($consulta) $sql2="UPDATE ususolcit
   						  SET asiste='S', usuario='".$_SESSION['usuario']."'
 						  WHERE codpro=$cedula and id_citas=$cita";
 				//echo $sql2;
 	$conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql2);
    //$datos2 = $this->ret_vector($consulta);

	if($consulta)
    {
      $this->auditar('Modificar Confirmar Cita','CITA','ModConfirmo Cita. '.$cedula.' - '.$cita);
      //Registro Forma de pago Oferta C.
	  //return $id;
    }
	$this->desconectar($conexion);
	return $consulta;
}

function buscarValidar($datos=null){
   $sql = "SELECT codpro FROM propietarios
 		   WHERE codpro='".$datos."' AND status='A' ";
	//echo $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$datosR = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $datosR;
}

function verificar($datos=null){
   $sql = "SELECT id_asignacion FROM asignacion
 		   WHERE codpro='".$datos."' AND status='A' ";
	//echo $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	$datosR = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $datosR;
}


function modPropietario($datos){
 $fecha = date('d/m/Y');
   $sql = "UPDATE repbenefsol
   SET codpro=$datos[0], rif=$datos[1], personalidad='".$datos[2]."', prinompro='".$datos[3]."', segnompro='".$datos[4]."',
       priapepro='".$datos[5]."', segapepro='".$datos[6]."', nomcomp='".$datos[7]."', calavepro='".$datos[8]."',
       urbbarpro='".$datos[9]."', edicaspro='".$datos[10]."', numpispro='".$datos[11]."', numapapro='".$datos[12]."',
       tlfcelpro='".$datos[13]."', tlfcel2pro='".$datos[14]."', obspro='".$datos[15]."',
       fecha_mod='".$fecha."', codest='".$datos[16]."', codmun='".$datos[17]."',
       codpar='".$datos[18]."', sexo='".$datos[19]."', tipo=$datos[20], fecnac='".$datos[21]."', correo='".$datos[22]."', id_banco='".$datos[23]."'
	   , riflab='".$datos[25]."', deslab='".$datos[24]."'
 WHERE codpro=$datos[0] ";
	//echo $sql;

	//f_alert($sql);
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
	if($consulta)
    {
      $this->auditar('Modificacion de Propietario','Propietario','Cedula. '.$datos[0]);
      //Registro Forma de pago Oferta C.
	  //return $id;
    }
	$this->desconectar($conexion);
	return $consulta;
}



function confirmarCita($cedula=null, $cita=null){

   $fecha = date('d/m/Y');
	$sql = "SELECT *
	FROM repbenefsol ";
    $sql = $sql."  WHERE codpro=$cedula ";
    //echo $sql;
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
    $datos = $this->ret_vector($consulta);
	$this->desconectar($conexion);

	$sqlu = "SELECT usuario
	FROM repususol ";
    $sqlu = $sqlu."  WHERE codpro=$cedula ";
    //echo $sqlu;
    $conexion = $this->conectar2();
	$consultaU = $this->consultar($conexion,$sqlu);
    $datosU = $this->ret_vector($consultaU);
	$this->desconectar($conexion);

	$cant = strlen($datos[1]);
	if ($cant==8){ $cedula=$datos[1]; }
	if ($cant==7){ $cedula='0'.$datos[1]; }
	if ($cant==6){ $cedula='00'.$datos[1]; }

	$rifC=$datos[3].$cedula.$datos[2];
	//$datos[32]="0603";

	if ($consulta){
	 	$sql1="INSERT INTO propietarios (
            codpro, prinompro, segnompro, priapepro, segapepro,
            nomcomp, calavepro, urbbarpro, edicaspro, numpispro, numapapro,
            dismunpro, ciudadpro, tlfcelpro, tlfcel2pro, obspro,
            tipmovpro, fecha_reg, status, codest, codmun, codpar,
            sexo, tipo, fecnac, ced, id_banco, usuario_pro, riflab, deslab )
     	VALUES ('".$rifC."', '".$datos[4]."', '".$datos[5]."', '".$datos[6]."', '".$datos[7]."',
            '".$datos[9]."', '".$datos[10]."', '".$datos[11]."', '".$datos[12]."', '".$datos[13]."', '".$datos[14]."',
            '".$datos[15]."', '".$datos[16]."', '".$datos[17]."', '".$datos[18]."', '".$datos[19]."', '".$datos[20]."',
            '".$datos[22]."', '".$datos[24]."', '".$datos[25]."', '".$datos[26]."',
            '".$datos[27]."','".$datos[28]."',$datos[29], '".$datos[30]."', '".$datos[1]."', '".$datos[32]."','".$datosU[0]."','".$datos[36]."','".$datos[35]."')";

        //echo '<br>Registra en sirecov'.$sql1;
		$conexion1 = $this->conectar();
		$consulta1 = $this->consultar($conexion1,$sql1);
		$datos1 = $this->ret_vector($consulta1);

		//echo "Datos 1: ".$datos1;
		$this->desconectar($conexion1);
	}

	if ($datos1){
		$sql2="UPDATE ususolcit
   						  SET asiste='S', usuario='".$_SESSION['usuario']."'
 						  WHERE codpro=$cedula and id_citas=$cita";

 						// echo "Confirma: ".$sql2;
 	$conexion2 = $this->conectar2();
	$consulta2 = $this->consultar($conexion2,$sql2);
	//$datos2 = $this->ret_vector($consulta);

	}

    if($consulta2)
    {
      $this->auditar('Confirmo Cita','CITA','Cedula '.$cedula.' Cita '.$cita);
      //Registro Forma de pago Oferta C.
	  //return $id;
    }
	$this->desconectar($conexion2);
	return $consulta2;
	//echo $datos2;
}

function descrTurno($turno){

	$sql = "SELECT * FROM segdescturn ";
    if($turno) $sql.=" WHERE id=$turno";

   // echo $sql;
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
	if($consulta)$descripcion = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $descripcion;
}


function listarCitasUsuario($nombre=null,$rif=null,$desde=null,$hasta=null,$citas=null,$ipcli=null,$offset=null,$asiste=null){

$fecha = date('d/m/Y');
if (($_SESSION['tipoUsuario']==17) and ($asiste==1)){


	 	$sql = "SELECT a.id_citas,to_char(a.fecha_reg,'dd/mm/yyyy'),a.hora,a.codpro,a.turno,to_char(a.fecha_cita,'dd/mm/yyyy'),
			a.asiste,b.rif,b.nomcomp,b.codpro,b.personalidad,(case b.sexo when 'F' THEN 'Femenino' when 'M' THEN 'Masculino' end) as sexo,
			to_char(b.fecnac,'dd/mm/yyyy'),b.calavepro,b.urbbarpro,b.edicaspro,b.numpispro,b.numapapro,b.dismunpro,b.ciudadpro,b.tlfcelpro,b.tlfcel2pro,b.id_banco
			a.ip_cliente,a.usuario FROM ususolcit a, repbenefsol b, repususol c WHERE a.codpro=b.codpro and c.codpro=b.codpro and a.asiste='S' and a.fecha_cita = '".$fecha."'";

	    //if (!$nombre and !$rif and !$desde and !$hasta) $sql.= " and fecha_cita='$fecha'";
	    if ($nombre) $sql.= " and b.nomcomp like '%".$nombre."%'";
	    if ($rif) $sql.= " and b.codpro = $rif ";
		if ($citas) $sql.= " and a.id_citas = $citas";
		if ($ipcli) $sql.= " and a.ip_cliente like '%".$ipcli."%'";


	$sql.= " order by a.fecha_cita,a.codpro ";

    if($offset>=0) $sql.= " LIMIT 20 OFFSET ".$offset;

}
else
{
	if ($nombre or $rif or $citas or $desde or $hasta  or $ipcli){

	 	/*$sql = "SELECT a.id_citas,to_char(a.fecha_reg,'dd/mm/yyyy'),a.hora,a.codpro,a.turno,to_char(a.fecha_cita,'dd/mm/yyyy'),
			a.asiste,b.rif,b.nomcomp,b.codpro,b.personalidad
			FROM citas a, propietarios b WHERE a.codpro=b.codpro";*/

        $sql = "SELECT a.id_citas,to_char(a.fecha_reg,'dd/mm/yyyy'),a.hora,a.codpro,a.turno,to_char(a.fecha_cita,'dd/mm/yyyy'),
			a.asiste,b.rif,b.nomcomp,b.codpro,b.personalidad,(case b.sexo when 'F' THEN 'Femenino' when 'M' THEN 'Masculino' end) as sexo,
			to_char(b.fecnac,'dd/mm/yyyy'),b.calavepro,b.urbbarpro,b.edicaspro,b.numpispro,b.numapapro,b.dismunpro,b.ciudadpro,b.tlfcelpro,b.tlfcel2pro,b.id_banco
			,a.ip_cliente,c.usuario FROM ususolcit a, repbenefsol b, repususol c WHERE a.codpro=b.codpro and c.codpro=b.codpro";

	    //if (!$nombre and !$rif and !$desde and !$hasta) $sql.= " and fecha_cita='$fecha'";
	    if ($nombre) $sql.= " and b.nomcomp like '%".$nombre."%'";
	    if ($rif) $sql.= " and b.codpro = $rif ";
		if ($citas) $sql.= " and a.id_citas = $citas";
		if ($ipcli) $sql.= " and a.ip_cliente like '%".$ipcli."%'";

		if($desde AND !($hasta)) $sql.= " and a.fecha_cita >= '".$desde."'";
		else if (!($desde) AND  $hasta) $sql.= " and a.fecha_cita <= '".$hasta."'";
		else if ($desde  AND  $hasta) $sql.= " and a.fecha_cita BETWEEN '".$desde."' AND '".$hasta."'";


	 $sql.= " order by a.fecha_cita,a.codpro ";

    if($offset>=0) $sql.= " LIMIT 20 OFFSET ".$offset;

	}
}

    //echo '<br>Listar: '.$sql;
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
	if($consulta) $usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);

   //echo "SQL cuenta: ".count($usuario);
	return $usuario;
}

function datosCitasUsuario2($idbenefi=null){

$fecha = date('d/m/Y');
//echo $idbenefi;
	$sql = "SELECT
    b.codpro,
    b.rif,
    b.personalidad,
    b.nomcomp,
    b.calavepro,
    b.urbbarpro,
    b.edicaspro,
    b.numpispro,
    b.tlfcelpro,
    b.tlfcel2pro,
    b.obspro,
    b.codest,
    b.codmun,
    b.codpar,
    b.sexo,
    b.tipo,
    to_char(b.fecnac,'dd/mm/yyyy'),
    b.correo,
    b.numapapro,
    substr(b.tlfcelpro,1,4) as cod, substr(b.tlfcelpro,5,7) as num,
    substr(b.tlfcel2pro,1,4) as cod2, substr(b.tlfcel2pro,5,7) as num2,
    b.obspro,
    b.prinompro,
    b.segnompro,
    b.priapepro,
    b.segapepro,
    b.id_banco
	FROM repbenefsol b";
    $sql = $sql." WHERE b.codpro=$idbenefi ";
    //echo $sql;
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
	if($consulta)$usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $usuario;
}


function datosCitasUsuario($idbenefi=null,$cita=null){

$fecha = date('d/m/Y');
//echo $idbenefi;
	$sql = "SELECT a.id_citas,to_char(a.fecha_reg,'dd/mm/yyyy'),a.hora,a.codpro,a.turno,to_char(a.fecha_cita,'dd/mm/yyyy'),
	a.asiste,
    b.codpro,
    b.rif,
    b.personalidad,
    b.nomcomp,
    b.calavepro,
    b.urbbarpro,
    b.edicaspro,
    b.numpispro,
    b.tlfcelpro,
    b.tlfcel2pro,
    b.obspro,
    b.codest,
    b.codmun,
    b.codpar,
    b.sexo,
    b.tipo,
    to_char(b.fecnac,'dd/mm/yyyy'),
    b.correo,
    b.numapapro,
    substr(b.tlfcelpro,1,4) as cod, substr(b.tlfcelpro,5,7) as num,
    substr(b.tlfcel2pro,1,4) as cod2, substr(b.tlfcel2pro,5,7) as num2,
    b.obspro,
    b.prinompro,
    b.segnompro,
    b.priapepro,
    b.segapepro,
    b.id_banco,
    riflab,
    deslab,
    a.n_conapdis
	FROM ususolcit a, repbenefsol b";
    $sql = $sql." WHERE b.codpro=$idbenefi";
    if($cita)$sql = $sql." and a.id_citas=$cita";
    $sql = $sql." and a.codpro=b.codpro and a.asiste<>'E'";
    //echo $sql;
    $conexion = $this->conectar2();
	$consulta = $this->consultar($conexion,$sql);
	if($consulta)$usuario = $this->ret_vector($consulta);
	$this->desconectar($conexion);
	return $usuario;
}

function validarSolicitudCita($cedula){
	$fecha = date('d/m/Y');

	$sql = "SELECT * FROM citas ";
    if($cedula) $sql = $sql." WHERE codpro=$cedula and asiste is null"; //valido con asiste o agregamos un campo vencida??

    //echo $sql;
    $conexion = $this->conectar();
	$consulta = $this->consultar($conexion,$sql);
	if($consulta)$usuario = $this->ret_vector($consulta);

	if ($usuario[5]>=$fecha)
		$tiene= 'S';
	else
		$tiene= 'N';

	$this->desconectar($conexion);
	return $tiene;
}

function regCita($data){
	$sql = "INSERT INTO citas(fecha_reg,codpro,turno,fecha_cita) VALUES";
	$sql.= "('".$data[1]."','".$data[0]."','".$data[2]."','".$data[3]."')";

	 $conexion = $this->conectar();
     $consulta = $this->consultar($conexion,$sql);

     $this->desconectar($conexion);
  /*   if($consulta){
     	//$this->auditar($_SESSION['loguse'],'INSERCION','Registro al usuario '.$usuario);
        return $usuario;
     }
*/
	return $consulta;
}


//Funcion Katiuska
function buscarBenefCitas($codpro=null,$nombre=null,$fec=null,$usuario=null,$offset=null,$correo=null,$fec2=null,$tipo=null)
{
	//echo 'aqui'.$tipo;
	$sql="select a.rif,a.codpro,a.personalidad,a.nomcomp,a.tlfcelpro,a.tlfcel2pro,a.correo,a.sexo,d.usuario, to_char(b.fecha_cita,'dd/mm/yyyy'),c.descrip,
		to_char(b.fecha_reg,'dd/mm/yyyy'),to_char(a.fecha_reg,'dd/mm/yyyy'), a.n_conapdis
	from repususol d, repbenefsol a left outer join ususolcit b on a.codpro=b.codpro
	left outer join segdescturn c on b.turno=c.id
	where a.codpro = d.codpro and a.status<>'E'";

if ($codpro) $sql.= " and a.codpro='$codpro' ";
if ($nombre) $sql.= " and a.nomcomp like '%".$nombre."%'";

if ($fec) $sql.= " and b.fecha_reg = '".$fec."'";

if ($fec2) $sql.= " and a.fecha_reg = '".$fec2."'";

if ($usuario) $sql.= " and d.usuario='$usuario'";

if ($correo) $sql.= " and a.correo like '%".$correo."%'";

if ($tipo=='N') $sql.= " and a.n_conapdis='1' ";

if ($tipo=='D') $sql.= " and a.n_conapdis<>'1' ";

if ($_SESSION['tipoUsuario']==2) $sql.= " order by a.n_conapdis desc";
else $sql.= " order by a.codpro";

/*if (($offset<0) and ($fec)) $sql.= " LIMIT 20 OFFSET 0";
elseif (($offset>=0) and ($fec)) $sql.= " LIMIT 20 OFFSET 0"; // OFFSET ".$offset;
elseif (($offset>=0) and !($fec)) $sql.= " LIMIT 20 OFFSET ".$offset;*/
if ($offset>=0) $sql.= " LIMIT 20 OFFSET ".$offset;

  //echo '<br>'.$sql;
  $conexion = $this->conectar2();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
}

function listarBeneficiario($codpro=null,$nomcomp=null){

    $sql = "select
			  codpro,rif,personalidad, prinompro , segnompro, priapepro ,segapepro, nomorgpro ,  nomcomp ,
			  calavepro , urbbarpro,  edicaspro ,numpispro , numapapro ,dismunpro ,
			  ciudadpro , tlfcelpro ,tlfcel2pro , obspro ,tipmovpro, to_char(fecha_reg,'dd/mm/yyyy'),
			  substr(tlfcelpro,1,4) as cod,substr(tlfcelpro,5,7) as num ,substr(tlfcel2pro,1,4) as cod2,
			  substr(tlfcel2pro,5,7) as num2,
              sexo, (case sexo when 'F' THEN 'Femenino' when 'M' THEN 'Masculino' end) as destipo, tipo,
              codest, codmun, codpar,to_char(fecnac,'dd/mm/yyyy'),correo,id_banco,n_conapdis
			from
			  repbenefsol
			where
			  status='A' ";
    if($codpro)  $sql=$sql." and codpro=$codpro";
    if($nomcomp)  $sql=$sql." and nomcomp like '%".$nomcomp."%'";

    $sql=$sql." order by codpro";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar2();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }

//MANEJO DE IPS A BLOQUEAR
function listarIP($ip=null,$offset=null){

    $sql = "select * from segbloqip ";
    if($ip)  $sql.= " where dirip='".$ip."'";

    if ($offset>=0) $sql.= " LIMIT 20 OFFSET ".$offset;

  //print '<pre>'; print $sql;
  $conexion = $this->conectar2();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }

function regIP($data){
	$sql = "INSERT INTO segbloqip(dirip,fecha_reg) VALUES ('".$data[0]."','".$data[1]."')";

//	echo "Inserta: ".$sql;

	 $conexion = $this->conectar2();
     $consulta = $this->consultar($conexion,$sql);

     $this->desconectar($conexion);
  /*   if($consulta){
     	//$this->auditar($_SESSION['loguse'],'INSERCION','Registro al usuario '.$usuario);
        return $usuario;
     }
*/
	return $consulta;
}

function borrarIP($ip){
	$fecha = date('d/m/Y');
	$sql = "update segbloqip set estatus='D',fecha_mod='".$fecha."' where dirip='".$ip."'";

	//echo "Borra: ".$sql;

	 $conexion = $this->conectar2();
     $consulta = $this->consultar($conexion,$sql);

     $this->desconectar($conexion);
  /*   if($consulta){
     	//$this->auditar($_SESSION['loguse'],'INSERCION','Registro al usuario '.$usuario);
        return $usuario;
     }
*/
	return $consulta;
}

function bloquearIP($ip){
	$fecha = date('d/m/Y');
	$sql = "update segbloqip set estatus='B',fecha_mod='".$fecha."' where dirip='".$ip."'";

	//echo "<br>Bloquear nuevamente: ".$sql;

	 $conexion = $this->conectar2();
     $consulta = $this->consultar($conexion,$sql);

     $this->desconectar($conexion);
  /*   if($consulta){
     	//$this->auditar($_SESSION['loguse'],'INSERCION','Registro al usuario '.$usuario);
        return $usuario;
     }
*/
	return $consulta;
}

//Buscar IPs repetidas
function listarIPRep($ip=null,$offset=null){

    $sql = "select z.ctaip,z.ip from (select count(a.ip_cliente) as ctaip,a.ip_cliente as ip from ususolcit a";

	if ($ip) $sql.= " where a.ip_cliente='".$ip."'";

	$sql.= " group by a.ip_cliente) z where z.ctaip>=4 order by z.ctaip ";

    if ($offset>=0) $sql.= " LIMIT 20 OFFSET ".$offset;

  //print '<pre>'; print $sql;
  $conexion = $this->conectar2();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }


//PARA EL CONSOLIDADO DE CITAS POR ESTADO
function cuadroResumenCitasxEdo($tipo=null,$fechaD=null,$fechaH=null,$banco=null)
{
	/*
	 citests--Personas con cita, estado, asistieron
	 citestv--Personas con cita, estado, no asistieron
	 citestp--Personas con cita, estado, pendiente
	 sincita--Personas sin cita, estado
	*/

	$sql= "select x.codest, x.nomest,
	(select count(a.benef) as citests from
	(select distinct(a.codpro) as benef,a.codest from zona_estado c, repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
	WHERE c.codest = a.codest and b.asiste='S' and c.codest=x.codest and a.status='A'";

	if ($tipo) $sql.=" and a.tipo=$tipo";

    if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
	else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";

	if ($banco) $sql.=" and a.id_banco='$banco'";


    $sql.= " ) a ) as citests
	,
	(select count(b.benef) as citestv from (select distinct(a.codpro) as benef,a.codest from zona_estado c, repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
	WHERE c.codest = a.codest and b.asiste='V' and c.codest=x.codest and a.status='A'";

	if ($tipo) $sql.=" and a.tipo=$tipo";
	if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
	else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";
    if ($banco) $sql.=" and a.id_banco='$banco'";

    $sql.= ") b )  as citestv
	,
	(select count(c.benef) as citestp from (select distinct(a.codpro) as benef,a.codest from zona_estado c, repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
	WHERE c.codest = a.codest and b.asiste='A' and c.codest=x.codest and a.status='A'";

 	if ($tipo) $sql.=" and a.tipo=$tipo";
 	if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
	else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";
    if ($banco) $sql.=" and a.id_banco='$banco'";

    $sql.= " ) c)  as citestp
	,
	(select count(a.codpro) as sincita from zona_estado c, repbenefsol a
	where c.codest = a.codest and a.codest=x.codest and a.codpro not in
	(select codpro from ususolcit) ";

	if ($tipo) $sql.=" and a.tipo=$tipo";
	if ($banco) $sql.=" and a.id_banco='$banco'";

    $sql.= ") as sincita
	from zona_estado x";

   // print $sql;

	$conexion = $this->conectar2();
  	$consulta = $this->consultar($conexion,$sql);
  	$consulta = $this->ret_vector($consulta);
  	$this->desconectar($conexion);

  return $consulta;

}

function cuadroResumenCitasSinEdo($tipo=null,$fechaD=null,$fechaH=null,$banco=null)
{
	/*
	 citests--Personas con cita, estado, asistieron
	 citestv--Personas con cita, estado, no asistieron
	 citestp--Personas con cita, estado, pendiente
	 sincita--Personas sin cita, estado
	*/

	$sql= "select '', '',
	(select count(x.benef) as citnests from (select distinct(a.codpro) as benef,a.codest from repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
WHERE (a.codest='' or a.codest='0') and b.asiste='S' and a.status='A'";

	if ($tipo) $sql.=" and a.tipo=$tipo";
    if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
	else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";
	if ($banco) $sql.=" and a.id_banco='$banco'";

	$sql.= ") x) as citnests,
	(select count(y.benef) as citnestv from (select distinct(a.codpro) as benef,a.codest from repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
WHERE (a.codest='' or a.codest='0') and b.asiste='V' and a.status='A'";

	if ($tipo) $sql.=" and a.tipo=$tipo";
    if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
	else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";
	if ($banco) $sql.=" and a.id_banco='$banco'";

	$sql.= ") y)  as citnestv,
	(select count(z.benef) as citnestp from (select distinct(a.codpro) as benef,a.codest from repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
WHERE (a.codest='' or a.codest='0') and b.asiste='A' and a.status='A'";

	if ($tipo) $sql.=" and a.tipo=$tipo";
	if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
	else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";
	if ($banco) $sql.=" and a.id_banco='$banco'";

	$sql.= ") z)  as citnestp
	,
	(select count(w.cedulas) from (select distinct(a.codpro) as cedulas from repbenefsol a where (a.codest='' or a.codest='0') and a.codpro not in (select codpro from ususolcit) ";

	if ($tipo) $sql.=" and a.tipo=$tipo";
	if ($banco) $sql.=" and a.id_banco='$banco'";

	$sql.= ") w) as sincita
	from zona_estado x  ";

   // print "<br><br>".$sql;

	$conexion = $this->conectar2();
  	$consulta = $this->consultar($conexion,$sql);
  	$consulta = $this->ret_vector($consulta);
  	$this->desconectar($conexion);

  return $consulta;

}


//PARA EL CONSOLIDADO BENEFICIARIOS POR ESTADO
function cuadroResumenCitasxEdo1($estado=null,$tipo=null,$fechaD=null,$fechaH=null,$banco=null)
{
	/*
	 citestv--Personas con cita, estado, no asistieron
	 citestp--Personas con cita, estado, pendiente
	*/

	$sql= "select x.codest, x.nomest,
	(select count(b.benef) as citestv from (select distinct(a.codpro) as benef,a.codest from zona_estado c, repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
	WHERE c.codest = a.codest and b.asiste='V' and c.codest='$estado' and a.status='A'";

	if ($tipo) $sql.=" and a.tipo=$tipo";
	if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
	else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";
    if ($banco) $sql.=" and a.id_banco='$banco'";

    $sql.= ") b )  as citestv
	,
	(select count(c.benef) as citestp from (select distinct(a.codpro) as benef,a.codest from zona_estado c, repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
	WHERE c.codest = a.codest and b.asiste='A' and c.codest='$estado' and a.status='A'";

 	if ($tipo) $sql.=" and a.tipo=$tipo";
 	if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
	else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";
    if ($banco) $sql.=" and a.id_banco='$banco'";

    $sql.= " ) c)  as citestp";

    $sql.= " from zona_estado x";

 //  print "<br>".$sql;

	$conexion = $this->conectar2();
  	$consulta = $this->consultar($conexion,$sql);
  	$consulta = $this->ret_vector($consulta);
  	$this->desconectar($conexion);

  return $consulta;

}

function cuadroResumenCitasSinEdo1($tipo=null,$fechaD=null,$fechaH=null,$banco=null)
{
	/*
	 citestv--Personas con cita, estado, no asistieron
	 citestp--Personas con cita, estado, pendiente
	*/

	$sql= "select '', '',
	(select count(y.benef) as citnestv from (select distinct(a.codpro) as benef,a.codest from repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
WHERE (a.codest='' or a.codest='0') and b.asiste='V' and a.status='A'";

	if ($tipo) $sql.=" and a.tipo=$tipo";
    if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
	else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";
	if ($banco) $sql.=" and a.id_banco='$banco'";

	$sql.= ") y)  as citnestv,
	(select count(z.benef) as citnestp from (select distinct(a.codpro) as benef,a.codest from repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
WHERE (a.codest='' or a.codest='0') and b.asiste='A' and a.status='A'";

	if ($tipo) $sql.=" and a.tipo=$tipo";
	if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
	else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";
	if ($banco) $sql.=" and a.id_banco='$banco'";

	$sql.= ") z)  as citnestp from zona_estado x  ";

   // print "<br><br>".$sql;

	$conexion = $this->conectar2();
  	$consulta = $this->consultar($conexion,$sql);
  	$consulta = $this->ret_vector($consulta);
  	$this->desconectar($conexion);

  return $consulta;

}


//PARA EL CONSOLIDADO DE CITAS POR BANCO
function cuadroResumenCitasxBanco($tipo=null,$fechaD=null,$fechaH=null,$banco=null)
{
	/*
	 citests--Personas con cita, estado, asistieron
	 citestv--Personas con cita, estado, no asistieron
	 citestp--Personas con cita, estado, pendiente
	 sincita--Personas sin cita, estado
	*/


		$sql= " select x.id_banco, x.banco_descrip,
		(select count(a.benef) as citests from (select distinct(a.codpro) as benef
		from repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
		WHERE b.asiste='S' and a.id_banco=x.id_banco and a.status='A' ";

		if ($tipo) $sql.=" and a.tipo=$tipo";

	    if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
		else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
		else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";

		//if ($banco) $sql.=" and a.id_banco='$banco'";

		$sql.= ") a ) as citests,
		 (select count(b.benef) as citestv from (select distinct(a.codpro) as benef
		 from repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
		 WHERE b.asiste='V' and a.id_banco=x.id_banco and a.status='A'";

		 if ($tipo) $sql.=" and a.tipo=$tipo";

	    if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
		else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
		else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";

		$sql.= ") b ) as citestv ,
		 (select count(c.benef) as citestp from (select distinct(a.codpro) as benef
		 from repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
		 WHERE b.asiste='A' and a.id_banco=x.id_banco and a.status='A'";

		if ($tipo) $sql.=" and a.tipo=$tipo";

	    if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
		else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
		else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";

		$sql.= " ) c) as citestp,
		  (select count(a.codpro) as sincita from repbenefsol a where
		  a.id_banco=x.id_banco and a.codpro not in (select codpro from ususolcit)";

		$sql.= " ) as sincita
		  from segnomban x";

//    print $sql;

	$conexion = $this->conectar2();
  	$consulta = $this->consultar($conexion,$sql);
  	$consulta = $this->ret_vector($consulta);
  	$this->desconectar($conexion);

  return $consulta;
}

//PARA EL REPORTE RESUMEN MINISTRO
function cuadroResumenCitasMin($tipo=null,$fechaD=null,$fechaH=null,$banco=null)
{
	/*

//las siguientes cedulas las obtuve con este query
 select a.codpro from (select count(codpro) as cuenta, codpro from ususolcit
group by codpro) a where a.cuenta>=2


select * from ususolcit where codpro in (14527426,
9123209,
6864884,
10280565,
7998801,
5909829,
8688285,
19187536,
17717775,
15151821,
2800500
) order by codpro;  estas son cedulas que tienen 2 citas, ojo que hay gente que ya asistio y volvio a pedir citas, no entiendo
	*/

   $sql = "SELECT count(a.id_pro) as registrados,
(select count(a.benef) as asiste from (
select distinct(a.codpro) as benef
		from repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
		WHERE b.asiste='S'";

		if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
		else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
		else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";


$sql.= ") a) AS asisten,
(select count(a.benef) as pendiente from (
select distinct(a.codpro) as benef
		from repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
		WHERE b.asiste='A'";

        if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
		else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
		else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";

$sql.= ") a) AS pendientes,
(select count(a.benef) as vencido from (
select distinct(a.codpro) as benef
		from repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
		WHERE b.asiste='V'";

        if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
		else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
		else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";

$sql.= ") a) AS vencidas,
(select count(a.codpro) as sincita from repbenefsol a where a.status='A' and
		  a.codpro not in (select codpro from ususolcit) ) AS sincitas,
(select count(a.benef) as eliminada from (
select distinct(a.codpro) as benef
		from repbenefsol a right outer join ususolcit b on a.codpro=b.codpro
		WHERE b.asiste='E'";

        if($fechaD AND !$fechaH) $sql.= " and b.fecha_cita >= '".$fechaD."'";
		else if (!$fechaD AND  $fechaH) $sql.= " and b.fecha_cita <= '".$fechaH."'";
		else if ($fechaD  AND  $fechaH)	$sql.= " and b.fecha_cita BETWEEN '".$fechaD."' AND '".$fechaH."'";

$sql.= ") a) AS eliminadas
FROM repbenefsol a
WHERE a.status='A'";

 // print $sql;

	$conexion = $this->conectar2();
  	$consulta = $this->consultar($conexion,$sql);
  	$consulta = $this->ret_vector($consulta);
  	$this->desconectar($conexion);

  return $consulta;
}



}
?>