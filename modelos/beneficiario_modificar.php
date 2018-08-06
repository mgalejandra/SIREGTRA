<?php
class beneficiario extends conexion{

 function usuario(){
  $sql = "Select DISTINCT (usuario_pro) from propietarios";
//print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }

 function registrarBeneficiario($data){
  $fecha=date('d/m/Y');
  if(!$data[23]) $data[23]='1';
  $sql = "INSERT INTO propietarios(
  		      codpro,prinompro,segnompro, priapepro ,segapepro, nomorgpro ,  nomcomp ,
			  calavepro , urbbarpro,  edicaspro ,numpispro , numapapro ,dismunpro ,
			   tlfcelpro ,tlfcel2pro , obspro ,tipmovpro, fecha_reg , codest, codmun, codpar,tipo,sexo,fecnac,ced,id_banco,usuario_pro)
         values
           (
			'".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."',
			'".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."',
			'".$data[13]."','".$data[14]."','".$data[15]."','MA','".$fecha."','".$data[16]."','".$data[17]."','".$data[18]."',".$data[19].",'".$data[20]."','".$data[21]."','".$data[22]."','".$data[23]."','".$_SESSION['usuario']."'
           )";
//print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('Registro de Beneficiario',$sql,'http://localhost/refeciv1.1/vistas/reg_beneficiarios.php');
  if($consulta) $this->bitacoraBeneficiario($data[0],'','Registro de Beneficiario',$_SESSION['usuario']);
  return $consulta;
 }

function contarBeneficiarios($codpro,$nomcomp,$banco,$des_fechareg,$has_fechareg,$usuario=null){

    $sql = "select count(*)	from propietarios where status='A' and	id_banco<>'' AND id_banco<>'1' ";
    if($codpro)  $sql=$sql." and codpro like '%".$codpro."%'";
    if($nomcomp)  $sql=$sql." and nomcomp like '%".$nomcomp."%'";
    if($banco)  $sql=$sql." and id_banco like '%".$banco."%'";
     if($des_fechareg and $has_fechareg){
       $sql = $sql." and fecha_reg BETWEEN '".$des_fechareg."' AND '".$has_fechareg."'";
 }
    if ($usuario) $sql=$sql." and usuario_pro='".$usuario."'";
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta[0];
 }

 function listarBeneficiario($codpro=null,$nomcomp=null,$banco=null,$des_fechareg=null,$has_fechareg=null){

    $sql = "select
			  codpro, prinompro , segnompro, priapepro ,segapepro, nomorgpro ,  nomcomp ,
			  calavepro , urbbarpro,  edicaspro ,numpispro , numapapro ,dismunpro ,
			  ciudadpro , tlfcelpro ,tlfcel2pro , obspro ,tipmovpro, to_char(fecha_reg,'dd/mm/yyyy'),  substr(codpro,1,1) as nac,
			  substr(codpro,2,8) as nac, substr(codpro,10,1) as nac,
			  substr(tlfcelpro,1,4) as cod,substr(tlfcelpro,5,7) as num ,substr(tlfcel2pro,1,4) as cod2,substr(tlfcel2pro,5,7) as num2,
              calavepro,urbbarpro,edicaspro,numpispro,numapapro,dismunpro,ciudadpro, sexo, (case sexo when 'A' THEN 'AHORROS' when 'C' THEN 'CORRIENTE' end) as destipo, tipo, codest, codmun, codpar,to_char(fecnac,'dd/mm/yyyy'),id_banco ";
  // if($banco)  $sql.= ", id_banco";
	$sql.= " from
			  propietarios
			 where
			  status='A' ";
    if($codpro)  $sql=$sql." and codpro like '%".$codpro."%'";
    if($nomcomp)  $sql=$sql." and nomcomp like '%".$nomcomp."%'";
   if($banco)  $sql=$sql." and id_banco like '%".$banco."%'";
   if($des_fechareg and $has_fechareg){
       $sql = $sql." and fecha_reg BETWEEN '".$des_fechareg."' AND '".$has_fechareg."'";
    }

    $sql=$sql." order by codpro";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }


   function listarBeneficiarioExp($codpro=null,$nomcomp=null,$offset,$banco=null,$des_fechareg,$has_fechareg,$usuario=null){

    $sql = "select
			  codpro, prinompro , segnompro, priapepro ,segapepro, nomorgpro ,  nomcomp ,
			  calavepro , urbbarpro,  edicaspro ,numpispro , numapapro ,dismunpro ,
			  ciudadpro , tlfcelpro ,tlfcel2pro , obspro ,tipmovpro, to_char(fecha_reg,'dd/mm/yyyy'),  substr(codpro,1,1) as nac,
			  substr(codpro,2,8) as nac, substr(codpro,10,1) as nac,
			  substr(tlfcelpro,1,4) as cod,substr(tlfcelpro,5,7) as num ,substr(tlfcel2pro,1,4) as cod2,substr(tlfcel2pro,5,7) as num2,
              calavepro,urbbarpro,edicaspro,numpispro,numapapro,dismunpro,ciudadpro, sexo, (case sexo when 'A' THEN 'AHORROS' when 'C' THEN 'CORRIENTE' end) as destipo, propietarios.tipo, codest, codmun, codpar,to_char(fecnac,'dd/mm/yyyy'),propietarios.id_banco,banco.banco_descrip,propietarios.usuario_pro ";
  // if($banco)  $sql.= ", id_banco";
	$sql.= " from
			  propietarios,banco
			 where
			  propietarios.status='A' and propietarios.id_banco=banco.id_banco
			  and	propietarios.id_banco<>'' AND propietarios.id_banco<>'1'";
    if($codpro)  $sql=$sql." and codpro like '%".$codpro."%'";
    if($nomcomp)  $sql=$sql." and nomcomp like '%".$nomcomp."%'";
   if($banco)  $sql=$sql." and propietarios.id_banco like '%".$banco."%'";
   if($des_fechareg and $has_fechareg){
       $sql = $sql." and fecha_reg BETWEEN '".$des_fechareg."' AND '".$has_fechareg."'";
    }
    if ($usuario) $sql=$sql." and usuario_pro='".$usuario."'";

    //$sql=$sql." order by codpro";

     $sql=$sql." order by id_pro desc, codpro";

    if($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }

 function modificarBeneficiario($codpro,$data){
  $fecha=date('d/m/Y');
  $conexion = $this->conectar();
  //si el dato que estoy cambiando es el rif, actualizo la tabla de asignacion
  if($_SESSION['numben']!=$data[0]){

	  $sql = " update asignacion set codpro='".$data[0]."'";
	  $sql=$sql." where codpro='".$_SESSION['numben']."'";
	  //print '<pre>'; print $sql;
	  $consulta = $this->consultar($conexion,$sql);
  }

     //	busco el id de asignacion para buscar el estatus del txt
      $sql = "select id_asignacion from asignacion where codpro='".$data[0]."' ";
      $asignacion = $this->consultar($conexion,$sql);
      $asignacion = $this->ret_vector($asignacion);

     // busco el estatus del txt
      $sql = "select estatuspro , numenvpro , fechatxtpro ";
      $sql = $sql."from certificados where ";
      $sql=$sql."  id_asignacion='".$asignacion[0]."'";
     // print $sql;
      $estatuspro = $this->consultar($conexion,$sql);
      $estatuspro = $this->ret_vector($estatuspro);

     //cambio el estatus del txt del vehiculo a MM
   /*  if($_SESSION['numben']!=$data[0] ){
         $sql ="  update certificados set tipmov_pro='MM' , estatusveh='P' , numenvveh=null , fechatxtveh=null , nummodveh=nummodveh+1 where id_asignacion=".$asignacion[0]." ";
         //print $sql;
  	     $this->consultar($conexion,$sql);
      }*/

       if($estatuspro[0] == 'E' ){
         $sql ="  update certificados set tipmov_pro='MM' , estatuspro='P' , numenvpro=null , fechatxtpro=null , nummodveh=nummodveh+1 where id_asignacion=".$asignacion[0]." ";
       //  print $sql;
  	     $this->consultar($conexion,$sql);
      }

     //cambio el estatus del txt del Propietario a MM
     if( $estatuspro[0] == 'E' ){
  	     $sql ="  update propietarios set tipmovpro='MM' where codpro='".$_SESSION['numben']."' ";
  	    // print $sql;
  	     $this->consultar($conexion,$sql);
      }

      $sql = " update propietarios set
  		      codpro='".$data[0]."',   prinompro='".$data[1]."' , segnompro='".$data[2]."', priapepro='".$data[3]."' ,
  		      segapepro='".$data[4]."', nomorgpro='".$data[5]."' ,  nomcomp='".$data[6]."' , calavepro='".$data[7]."' ,
  		      urbbarpro='".$data[8]."',  edicaspro='".$data[9]."' , numpispro='".$data[10]."' , numapapro='".$data[11]."' ,
  		      tlfcelpro='".$data[13]."' , tlfcel2pro='".$data[14]."' ,
  		      obspro='".$data[15]."' ,  fecha_mod='".$fecha."', fecnac='".$data[21]."', ";
  	  if ($data[18]) $sql .= "  codest='".$data[16]."',codmun='".$data[17]."',codpar='".$data[18]."', ";
  	  if ($data[23]) $sql .= "  id_banco='".$data[23]."' , ";
  	  $sql .= "  tipo='".$data[19]."',sexo='".$data[20]."',ced='".$data[22]."'  		      		";
      $sql=$sql." where codpro='".$codpro."'";
  //print '<pre>'; print $sql;

  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('MODIFICAR',$sql,'http://localhost/refeciv1.1/vistas/');
  return $consulta;
 }

 function listarBeneficiarios($codpro,$nomcomp,$offset,$banco,$des_fechareg,$has_fechareg){

    $sql = "select
			  codpro,   prinompro , segnompro, priapepro ,segapepro, nomorgpro ,  nomcomp ,
			  calavepro , urbbarpro,  edicaspro ,numpispro , numapapro ,dismunpro ,
			  ciudadpro , tlfcelpro ,tlfcel2pro , obspro ,tipmovpro, to_char(fecha_reg,'dd/mm/yyyy'),  substr(codpro,1,1) as nac,
			  substr(codpro,2,8) as nac, substr(codpro,10,1) as nac,
			  substr(tlfcelpro,1,4) as cod,substr(tlfcelpro,5,7) as num ,substr(tlfcel2pro,1,4) as cod2,substr(tlfcel2pro,5,7) as num2,
              calavepro,urbbarpro,edicaspro,numpispro,numapapro,dismunpro,ciudadpro
			from
			  propietarios
			where
			  status='A' ";
    if($codpro)  $sql=$sql." and codpro like '%".$codpro."%'";
    if($nomcomp)  $sql=$sql." and nomcomp like '%".$nomcomp."%'";
    if($banco)  $sql=$sql." and id_banco like '%".$banco."%'";
   if($des_fechareg and $has_fechareg){
       $sql = $sql." and fecha_reg BETWEEN '".$des_fechareg."' AND '".$has_fechareg."'";
    }

    $sql=$sql." order by id_pro desc, codpro";

    if($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
   if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/');
  return $consulta;
 }

  function registrarDocumentos($ci,$tip,$datos){
  $fecha=date('d/m/Y');
  $sql = "INSERT INTO documentos(
  		      codpro, id_tipo, descripcion, fecha_reg) VALUES ";
	    for($i=0;$i<count($datos)-1;$i++){
		    $sql =  $sql ." ('".$ci."','".$tip."','".$datos[$i]."','".$fecha."'),";
	     }
	        $sql =  $sql ." ('".$ci."','".$tip."','".$datos[$i]."','".$fecha."')";
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $this->desconectar($conexion);
  if($consulta) $this->auditar('INSERCION',$sql,'http://localhost/refeciv1.1/vistas/');
  return $consulta;
 }

   function listarDocumentos($ci){
  $fecha=date('d/m/Y');
  $sql = "select codpro, id_tipo, descripcion, fecha_reg from documentos where codpro='".$ci."' ";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

    function listarBitacora($ci){
  $fecha=date('d/m/Y');
  $sql = "select id_bitacora, sercarveh, movimiento,to_char(fecha,'dd/mm/yyyy') as fecha, hora, usuario from bitacora_beneficiario where codpro='".$ci."' ";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
  function regComentario($id,$comentario,$usuario){
  $fecha=date('d/m/Y');
  $this->bitacoraBeneficiario($id,'','Comentario: '.$comentario,$usuario);
   if ($this->bitacoraBeneficiario) return true; else return false;
 }

function listarTipo_benef(){
  $sql = "select codtipben, descripcion from tipo_benef";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }


  function registrarMemorif($nummemo,$banco,$atencion,$nota,$detalleMemo,$idM){

    $conexion = $this->conectar();

	$fecha=date('d/m/Y');
	$hora=date('H:i:s');

	$sql = "SELECT MAX(id_memoexp) FROM memoexp ";
    $consulta = $this->consultar($conexion,$sql);
    $contF = $this->ret_vector($consulta);
    $id = $contF[0]+1;

	if ($idM){
		$sql = "delete from memoexp where id_memoexp=$idM";
      // print $sql;
        $consulta = $this->consultar($conexion,$sql);
        $sql = "delete from detmemoexp where id_memoexp=$idM";
      //  print $sql;
        $consulta = $this->consultar($conexion,$sql);
        $id=$idM;
	}

	$sql = "INSERT INTO memoexp(id_memoexp, nummem, fecha, hora, id_banco ,observacion , atencion)
             values
             ('".$id."','".$nummemo."','".$fecha."','".$hora."','".$banco."','".$nota."','".$atencion."')";
 //   print '<pre>'; print $sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);

    if($consulta){

  	    $sql = "INSERT INTO detmemoexp";
		$sql = $sql."(id_memoexp ,  codpro ) VALUES ";
	    for($i=0;$i<count($detalleMemo)-41;$i+=41){
		    $sql = $sql. "('".$id."','".$detalleMemo[$i]."'),";
	    }
            $sql = $sql. "('".$id."','".$detalleMemo[$i]."')";
   // print $sql;

    $consulta = $this->consultar($conexion,$sql);
    }

	$this->desconectar($conexion);
    if($consulta)
    {
      $this->auditar($_SESSION['usuario'],'INSERCION','Registro Forma de pago Oferta C. '.$id);
	  return $id;
    }else return false;

 }

  function listarMemo($id_memoexp){

    $sql = " SELECT  a.id_memoexp, a.nummem, a.fecha, a.hora, a.id_banco , a.observacion , a.atencion from memoexp a ";
    $sql=$sql." where a.status='A' ";
    if($id_memoexp)	$sql.= " AND a.id_memoexp = '$id_memoexp' ";

//print '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }

  function listarDetMemo($id_memoexp){

    $sql = "select
			  a.codpro, prinompro , segnompro, priapepro ,segapepro, nomorgpro ,  nomcomp ,
			  calavepro , urbbarpro,  edicaspro ,numpispro , numapapro ,dismunpro ,
			  ciudadpro , tlfcelpro ,tlfcel2pro , obspro ,tipmovpro, to_char(fecha_reg,'dd/mm/yyyy'),  substr(a.codpro,1,1) as nac,
			  substr(a.codpro,2,8) as nac, substr(a.codpro,10,1) as nac,
			  substr(tlfcelpro,1,4) as cod,substr(tlfcelpro,5,7) as num ,substr(tlfcel2pro,1,4) as cod2,substr(tlfcel2pro,5,7) as num2,
              calavepro,urbbarpro,edicaspro,numpispro,numapapro,dismunpro,ciudadpro, sexo, (case sexo when 'A' THEN 'AHORROS' when 'C' THEN 'CORRIENTE' end) as destipo, tipo, codest, codmun, codpar,to_char(fecnac,'dd/mm/yyyy') ";
    $sql.= ", id_banco";
	$sql.= " from
			  propietarios a, detmemoexp b
			 where
			  a.status='A' and a.codpro=b.codpro ";
    if($id_memoexp)  $sql=$sql." and b.id_memoexp='".$id_memoexp."' ";

    $sql=$sql." order by codpro";
 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }


function contarMemo($id_memoexp,$desde,$hasta,$rif,$banco){

    $sql = "select count(z.cuenta) from (select
			  distinct(c.id_memoexp) as cuenta, c.id_banco";
	$sql.= " from
			  propietarios a, detmemoexp b, memoexp c
			 where
			  a.status='A' and a.codpro=b.codpro and c.id_memoexp=b.id_memoexp ";
    if($id_memoexp)  $sql.=" and b.id_memoexp='".$id_memoexp."' ";

    if ($banco) $sql.= " AND c.id_banco = '$banco' ";
    if ($rif) $sql.= " AND a.codpro like '%".$rif."%'";

    if($desde AND !$hasta) $sql.= " and c.fecha >= '".$desde."'";
	else if (!$desde AND  $hasta) $sql.= " and c.fecha <= '".$hasta."'";
	else if ($desde  AND  $hasta)	$sql .= " and  c.fecha BETWEEN '".$desde."' AND '".$hasta."'";

	$sql.= "order by c.id_memoexp) z ";

 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }

function listarMemo1($id_memoexp,$desde,$hasta,$rif,$banco,$offset){

   $sql = "select
			 distinct(c.id_memoexp),c.nummem,to_char(c.fecha,'dd/mm/yyyy'),c.id_banco,c.observacion, count(b.id_memoexp)";
	$sql.= " from
			  propietarios a, detmemoexp b, memoexp c
			 where
			  a.status='A' and a.codpro=b.codpro and c.id_memoexp=b.id_memoexp ";
    if($id_memoexp)  $sql.=" and b.id_memoexp='".$id_memoexp."' ";

    if ($banco) $sql.= " AND c.id_banco = '$banco' ";
    if ($rif) $sql.= " AND a.codpro like '%".$rif."%'";

    if($desde AND !$hasta) $sql.= " and c.fecha >= '".$desde."'";
	else if (!$desde AND  $hasta) $sql.= " and c.fecha <= '".$hasta."'";
	else if ($desde  AND  $hasta)	$sql .= " and  c.fecha BETWEEN '".$desde."' AND '".$hasta."'";
	$sql.= " GROUP BY  c.id_memoexp,c.nummem,c.fecha,c.id_banco,c.observacion ";
	$sql.= "order by c.id_memoexp desc";
    if($offset>=0) $sql = $sql." LIMIT 20 OFFSET ".$offset;
   //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }

}
?>