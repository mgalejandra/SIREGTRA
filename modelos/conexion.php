<?php
class conexion{
//atributos

//constructor vacio
	function conexion(){
	}

    function conectar2(){
		//$connection = parse_ini_file('../config.ini', true);
	//	$conexion = pg_connect("host=".$connection['presirecov']['host']." port=".$connection['presirecov']['port']." dbname=".$connection['presirecov']['name']." user=".$connection['presirecov']['username']." password=".$connection['presirecov']['password']);
		//$conexion=pg_connect("host=localhost port=5432 dbname=presirecov user=postgres password=P0stGr35");

		$url_t = dirname(dirname(__FILE__)).'/config.ini';

		$connection = parse_ini_file($url_t, true);

		$conexion = pg_connect("host=".$connection['presirecov']['host']." port=".$connection['presirecov']['port']." dbname=".$connection['presirecov']['name']." user=".$connection['presirecov']['username']." password=".$connection['presirecov']['password']);
	//	echo "Me conecte".$conexion;
	//	$conexion=pg_connect("host=192.168.7.69 port=5432 dbname=presirecov user=postgres password=postgres");

		if($conexion) pg_exec("SET search_path TO '".$connection['presirecov']['schema']."'");
	    //if($conexion) pg_exec("SET search_path TO 'solveh001' ");
		return $conexion;
	}

// funcion para conectarse a la bd
	function conectar(){
   	//	$connection = parse_ini_file('../config.ini', true);
	//	$conexion = pg_connect("host=".$connection['database']['host']." port=".$connection['database']['port']." dbname=".$connection['database']['name']." user=".$connection['database']['username']." password=".$connection['database']['password']);
//		echo "host=".$connection['database']['host']." port=".$connection['database']['port']." dbname=".$connection['database']['name']." user=".$connection['database']['username']." password=".$connection['database']['password']; die();
		//$conexion=pg_connect("host=localhost port=5432 dbname=presirecov user=postgres password=P0stGr35");


		$url_t = dirname(dirname(__FILE__)).'/config.ini';

		$connection = parse_ini_file($url_t, true);

		$conexion = pg_connect("host=".$connection['database']['host']." port=".$connection['database']['port']." dbname=".$connection['database']['name']." user=".$connection['database']['username']." password=".$connection['database']['password']);
	//	echo "Me conecte".$conexion;
                //echo "host=".$connection['database']['host']." port=".$connection['database']['port']." dbname=".$connection['database']['name'];

		//$conexion=pg_connect("host=192.168.7.247 port=5432 dbname=sirecov user=refeciv password=refeciv");

		if($conexion) pg_exec("SET search_path TO '".$connection['database']['schema']."'");
		//if($conexion) pg_exec("SET search_path TO '002'");

		return $conexion;
	}

	//	function conectarSaime(){
	//	$connection = parse_ini_file('../config.ini', true);
	//
	//	$url_t = dirname(dirname(__FILE__)).'/config.ini';
 	//	$connection = parse_ini_file($url_t, true);
 	//	$conexion = pg_connect("host=".$connection['saime']['host']." port=".$connection['saime']['port']." dbname=".$connection['saime']['name']." user=".$connection['saime']['username']." password=".$connection['saime']['password']);
	  //  $conexion=pg_connect("host=192.168.7.28 port=5432 dbname=saime user=saime password=saime");
//		if($conexion) pg_exec("SET search_path TO '".$connection['saime']['schema']."'");
//		return $conexion;/}

//funcion para desconectarse de la bd
	function desconectar($conexion){
		pg_close($conexion);

	}

//funcion para consultar en la bd
	function consultar($conexion,$sql){
		$consulta = @pg_query($conexion,$sql);
		return $consulta;
	}

//funcion para devolver la consulta en forma de vector
	function ret_vector($consulta){
		$vector=array();
		if($consulta){
		$col=pg_num_fields($consulta);
		$j=0;
		while ($data=pg_fetch_array($consulta)){
			for($i=0;$i<$col;$i++){
				$vector[$j]=$data[$i];
				$j++;
			}
		}
		return $vector;
		}else return false;
	}

  function ret_vector_asoc($consulta){
    $vector=array();
    if($consulta){
      $col=pg_num_fields($consulta);
      $j=0;
      while ($data=pg_fetch_array($consulta, null, PGSQL_BOTH)){
        $vector[$j]=$data;
        $j++;
      }
      return $vector;
    }else return false;
  }


//funcion para ver la consulta en forma de tabla
	function ver_consulta($consulta){
		$col=pg_num_fields($consulta);
		$fil=pg_num_rows($consulta);
		echo '<table border="1"><tr>';
		for($i=0;$i<$col;$i++){
			echo '<th>'.pg_field_name($consulta,$i).'</th>';
		}
		echo '</tr>';
		while ($data=pg_fetch_array($consulta)){
			echo '<tr>';
			for($i=0;$i<$col;$i++){
				echo '<td align="center">'.$data[$i].'</td>';
			}
			echo '</tr>';
		}
		echo '</tr>';
	}

// funcion para obtener los nombres de los campos
	function nombreCampos($consulta){
		$col=pg_num_fields($consulta);
		for($i=0;$i<$col;$i++){
			$campos[$i] = pg_field_name($consulta,$i);
		}
		return $campos;
	}

    function auditar($accion,$sentencia,$formulario){
      $fecha=date('d/m/Y H:m:s');
      $arreglo1 = array("'");
      $arreglo2 = array("");
      $sentencia = str_ireplace($arreglo1,$arreglo2,$sentencia);
      $sql = "INSERT INTO auditoria (usuario,fecha,accion,sentencia,formulario)
              VALUES ('".$_SESSION['usuario']."','".$fecha."','".$accion."','".$sentencia."','".$formulario."')";
      $conexion = $this->conectar();
      $consulta = $this->consultar($conexion,$sql);
      $this->desconectar($conexion);
    }

    function auditoria_reclamos($accion,$id_caso){
      $fecha=date('d/m/Y H:m:s');
      $sql = "INSERT INTO auditoria_reclamos (usuario,fecha,accion,id_caso)
              VALUES ('".$_SESSION['usuario']."','".$fecha."','".$accion."','".$id_caso."')";
      $conexion = $this->conectar();
      $consulta = $this->consultar($conexion,$sql);
      $this->desconectar($conexion);
    }

     function statusTxt($id,$sercarveh){

      $sql = "select estatusveh , numenvveh , fechatxtveh , estatuspro , numenvpro , fechatxtpro , estatuspla , numenvpla , fechatxtpla ";
      $sql = $sql."from certificados where ";
      if($sercarveh)  $sql=$sql."  sercarveh='".$sercarveh."'";
      if($id)  $sql=$sql."  id_certificado=".$id." ";
     // print $sql;
      $conexion = $this->conectar();
      $consulta = $this->consultar($conexion,$sql);
      $consulta = $this->ret_vector($consulta);
      return $consulta;
    }

    function bitacoraBeneficiario($codpro,$sercarveh ,$movimiento,$usuario){
    $sql = "INSERT INTO bitacora_beneficiario (codpro,sercarveh ,movimiento,fecha,hora,usuario) VALUES
    ('".$codpro."','".$sercarveh."','".$movimiento."','".date("d-m-Y")."','".date("H:i:s")."','".$usuario."')";
    // print $sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);
    $this->desconectar($conexion);
    return $consulta;
  }


  function statusProforma($numfac,$idestatus,$usuario){
    $sql = "INSERT INTO movi_proforma (id_numfac,id_estatus ,usuario_estatus,fecha,hora) VALUES
    ('".$numfac."','".$idestatus."','".$usuario."','".date("d-m-Y")."','".date("H:i:s")."')";
   //  print $sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);
    $this->desconectar($conexion);
    return $consulta;
  }

  function estatusFacturaProfo($num,$codpro,$serveh,$indReg,$obspro,$monto){
      $fecha=date('d/m/Y');
	  $sql ="  update facturaprof set id_estatus='".$indReg."', usuario_estatus='".$_SESSION['usuario']."', fecha_estatus='".$fecha."' ";
      if ($monto) $sql.=" ,monto= ".$monto." ";
      if ($obspro) $sql.=" , observacion='".$obspro."' ";
      $sql=$sql."  where id_numfac='".$num."'";

     // print "<br>ACTUALIZO PROF:".$sql;
	  $conexion = $this->conectar();
	  $consulta = $this->consultar($conexion,$sql);
	  $this->desconectar($conexion);
	 // if($consulta) $this->bitacoraBeneficiario($codpro,$serveh,'Cambio de estatus de Proforma '.$num.' a: '.$indReg,$_SESSION['usuario']);
	  if($consulta) $esta = $this->statusProforma($num,$indReg,$_SESSION['usuario']);
	  if($consulta) $this->auditar('CAMBIO DE ESTATUS DE LA PROFORMA '.$num.' a: '.$indReg,$sql,'http://localhost/refeciv1.1/vistas/det_factura.php');
      return $consulta;
 }

//Esta es la funcion para el listado de la tabla auditoria
 function listarBitacoraBeneficiario($codpro,$sercarveh,$movimiento,$usuario,$offset){
    $sql = "SELECT c.usuario,c.nombre1,c.nombre2,c.apellido1,c.apellido2,b.codpro,b.sercarveh,b.movimiento,b.fecha,b.hora
FROM bitacora_beneficiario b, usuarios c WHERE c.usuario = b.usuario";

	/*if($codpro)
	if($sercarveh)
	if($movimiento)*/
	if($usuario)  $sql.= "AND c.usuario='".$usuario."' ";

	$sql.= " order by b.codpro";

	if($offset>=0)     $sql.= " LIMIT 15 OFFSET $offset";
    //print '<br>'.$sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);
    $this->desconectar($conexion);
    return $consulta;
  }

     function descripcionEstatus($id_estatus){
  $sql = "select descripcion from estatus where status='A' and id_estatus='$id_estatus' ";
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta[0];
 }


}

?>
