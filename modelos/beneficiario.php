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
			   tlfcelpro ,tlfcel2pro , obspro ,tipmovpro, fecha_reg , codest, codmun, codpar,tipo,sexo,fecnac,ced,id_banco,usuario_pro,correo,riflab,deslab)
         values
           (
			'".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."',
			'".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."',
			'".$data[13]."','".$data[14]."','".$data[15]."','MA','".$fecha."','".$data[16]."','".$data[17]."','".$data[18]."',".$data[19].",'".$data[20]."','".$data[21]."','".$data[22]."','".$data[23]."',
      '".$_SESSION['usuario']."','".$data[24]."','".$data[25]."','".$data[26]."'
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

 function listarBeneficiario($codpro=null,$nomcomp=null,$banco=null,$des_fechareg=null,$has_fechareg=null,$lim=null,$riflab=null){

    $sql = "select 
			  codpro, prinompro , segnompro, priapepro ,segapepro, nomorgpro ,  nomcomp ,
			  calavepro , urbbarpro,  edicaspro ,numpispro , numapapro ,dismunpro ,
			  ciudadpro , tlfcelpro ,tlfcel2pro , obspro ,tipmovpro, to_char(fecha_reg,'dd/mm/yyyy'),  substr(codpro,1,1) as nac,
			  substr(codpro,2,9) as nac, substr(codpro,12,10) as nac,
			  substr(tlfcelpro,1,4) as cod,substr(tlfcelpro,5,7) as num ,substr(tlfcel2pro,1,4) as cod2,substr(tlfcel2pro,5,7) as num2,
              calavepro,urbbarpro,edicaspro,numpispro,numapapro,dismunpro,ciudadpro, sexo,(case sexo when 'A' THEN 'AHORROS' when 'C' THEN 'CORRIENTE' end) as destipo, tipo, codest, codmun, codpar,to_char(fecnac,'dd/mm/yyyy'),id_banco,correo ";
    if ($riflab){
    	$sql =$sql.",riflab,deslab";
    }
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
   if ($lim=='1')
    $sql=$sql." LIMIT 1";
   else
    $sql=$sql." order by codpro, edicaspro desc, id_pro desc ,id_pro desc";
 // print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }


   function listarBeneficiarioExp($codpro=null,$nomcomp=null,$offset,$banco=null,$des_fechareg,$has_fechareg,$usuario=null,$cedula=null){

    $sql = "select
			  codpro, prinompro , segnompro, priapepro ,segapepro, nomorgpro ,  nomcomp ,
			  calavepro , urbbarpro,  edicaspro ,numpispro , numapapro ,dismunpro ,
			  ciudadpro , tlfcelpro ,tlfcel2pro , obspro ,tipmovpro, to_char(fecha_reg,'dd/mm/yyyy'),  substr(codpro,1,1) as nac,
			  substr(codpro,2,8) as nac, substr(codpro,10,1) as nac,
			  substr(tlfcelpro,1) as cod,substr(tlfcelpro,5,15) as num ,substr(tlfcel2pro,1,4) as cod2,substr(tlfcel2pro,5,7) as num2,
              calavepro,urbbarpro,edicaspro,numpispro,numapapro,dismunpro,ciudadpro, sexo, (case sexo when 'A' THEN 'AHORROS' when 'C' THEN 'CORRIENTE' end) as destipo, propietarios.tipo, codest, codmun, codpar,to_char(fecnac,'dd/mm/yyyy'),propietarios.id_banco,banco.banco_descrip,propietarios.usuario_pro ";
  // if($banco)  $sql.= ", id_banco";
	$sql.= " from
			  propietarios,banco
			 where
			  propietarios.status='A' and propietarios.id_banco=banco.id_banco
			  and	propietarios.id_banco<>'' AND propietarios.id_banco<>'1'";
   if($codpro)  $sql=$sql." and codpro like '%".$codpro."%'";
   if($id_pro)  $sql=$sql." and nomcomp like '%".$nomcomp."%'";
   if($banco)  $sql=$sql." and propietarios.id_banco like '%".$banco."%'";
   if($des_fechareg and $has_fechareg){
       $sql = $sql." and fecha_reg BETWEEN '".$des_fechareg."' AND '".$has_fechareg."'";
    }
    if ($usuario) $sql=$sql." and usuario_pro='".$usuario."'";


    if ($cedula) {
    	$sql=$sql." and propietarios.codpro in ";
    	$sql=$sql." (";

    	for($i=0;$i<count($cedula)-1;$i++){
		    $sql =  $sql ." '".$cedula[$i]."' ";
		    $sql =  $sql ." , ";
	     }
	     $sql =  $sql ." '".$cedula[$i]."' ";

    	$sql=$sql." )";
    }

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

   function listarBeneficiarioExp2($codpro=null,$nomcomp=null,$offset,$banco=null,$des_fechareg,$has_fechareg,$usuario=null,$cedula=null,$tipoben=null){
    $sql = "select
			  codpro, prinompro , segnompro, priapepro ,segapepro, nomorgpro ,  nomcomp ,
			  calavepro , urbbarpro,  edicaspro ,numpispro , numapapro ,dismunpro ,
			  ciudadpro , tlfcelpro ,tlfcel2pro , obspro ,tipmovpro, to_char(fecha_reg,'dd/mm/yyyy'),   substr(codpro,1,1) as nac,
        substr(codpro,2,9) as nac, substr(codpro,12,10) as nac,
			  substr(tlfcelpro,1,4) as cod,substr(tlfcelpro,5,7) as num ,substr(tlfcel2pro,1,4) as cod2,substr(tlfcel2pro,5,7) as num2,
              calavepro,urbbarpro,edicaspro,numpispro,numapapro,dismunpro,ciudadpro, sexo, (case sexo when 'A' THEN 'AHORROS' when 'C' THEN 'CORRIENTE' end) as destipo, " .
              		"propietarios.tipo, codest, codmun, codpar,to_char(fecnac,'dd/mm/yyyy'),propietarios.id_banco,desbanco(propietarios.id_banco),
              		propietarios.usuario_pro, b.descripcion ";
  // if($banco)  $sql.= ", id_banco";
	$sql.= " from
			  propietarios, tipo_benef b
			 where
			  propietarios.status='A'  and 	propietarios.tipo=b.codtipben";
    if($codpro)  $sql=$sql." and codpro like '%".$codpro."%'";
    if($nomcomp)  $sql=$sql." and nomcomp like '%".$nomcomp."%'";
   if($banco)  $sql=$sql." and propietarios.id_banco like '%".$banco."%'";
  /* if($des_fechareg and $has_fechareg){
       $sql = $sql." and fecha_reg BETWEEN '".$des_fechareg."' AND '".$has_fechareg."'";
    }*/

    if($des_fechareg AND !$has_fechareg) $sql.= " and fecha_reg>= '".$des_fechareg."'";
else if (!$des_fechareg AND  $has_fechareg) $sql.= " and fecha_reg <= '".$has_fechareg."'";
else if ($des_fechareg and $has_fechareg)	$sql.= " and fecha_reg BETWEEN '".$des_fechareg."' AND '".$has_fechareg."'";



    if ($usuario) $sql=$sql." and usuario_pro='".$usuario."'";
    if ($tipoben) $sql=$sql." and propietarios.tipo=$tipoben";

    //$sql=$sql." order by codpro";

     $sql=$sql." order by codpro";

    if($offset>=0) $sql = $sql." LIMIT 15 OFFSET ".$offset;
  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }

   function contarBeneficiarios2($rif=null,$nombre=null,$banco=null,$des_fechareg=null,$has_fechareg=null,$usuario=null,$tipoben=null){
    $sql = "select
			  count(codpro) ";
  // if($banco)  $sql.= ", id_banco";
	$sql.= " from
			  propietarios, tipo_benef b
			 where
			  propietarios.status='A' and propietarios.tipo=b.codtipben ";
   if($rif)  $sql=$sql." and codpro like '%".$rif."%'";
   if($nombre)  $sql=$sql." and nomcomp like '%".$nombre."%'";
   if($banco)  $sql=$sql." and propietarios.id_banco like '%".$banco."%'";
  /* if($des_fechareg and $has_fechareg){
       $sql = $sql." and fecha_reg BETWEEN '".$des_fechareg."' AND '".$has_fechareg."'";
    }*/

    if($des_fechareg AND !$has_fechareg) $sql.= " and fecha_reg>= '".$des_fechareg."'";
else if (!$des_fechareg AND  $has_fechareg) $sql.= " and fecha_reg <= '".$has_fechareg."'";
else if ($des_fechareg and $has_fechareg)	$sql.= " and fecha_reg BETWEEN '".$des_fechareg."' AND '".$has_fechareg."'";


    if ($usuario) $sql=$sql." and usuario_pro='".$usuario."'";
    if ($tipoben) $sql=$sql." and propietarios.tipo=$tipoben";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta[0];
 }

 function modificarBeneficiario($edicaspro,$data){
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
  		      tlfcelpro='".$data[13]."' , tlfcel2pro='".$data[14]."' , usuario_pro='".$_SESSION['usuario']."',
  		      obspro='".$data[15]."' ,  fecha_mod='".$fecha."', fecnac='".$data[21]."', ";
  	  if ($data[18]) $sql .= "  codest='".$data[16]."',codmun='".$data[17]."',codpar='".$data[18]."', ";
  	  if ($data[23]) $sql .= "  id_banco='".$data[23]."' , ";
  	  $sql .= "  tipo='".$data[19]."',sexo='".$data[20]."',ced='".$data[22]."',correo='".$data[24]."', riflab='".$data[25]."',deslab='".$data[26]."' ";
      $sql .= " where correo='".$data[24]."' and edicaspro='".$data[9]."'
      and fecnac='".$data[21]."' and numpispro='".$data[10]."' and urbbarpro='".$data[8]."'";
  print '<pre>'; print $sql;

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


  function registrarMemorif($nummemo,$banco,$atencion,$nota,$detalleMemo){

    $conexion = $this->conectar();

	$fecha=date('d/m/Y');
	$hora=date('H:i:s');

	$sql = "SELECT MAX(id_memoexp) FROM memoexp ";
    $consulta = $this->consultar($conexion,$sql);
    $contF = $this->ret_vector($consulta);
    $id = $contF[0]+1;

	$sql = "INSERT INTO memoexp(id_memoexp, nummem, fecha, hora, id_banco ,observacion , atencion, usuario_estatus)
             values
             ('".$id."','".$nummemo."','".$fecha."','".$hora."','".$banco."','".$nota."','".$atencion."','".$_SESSION['usuario']."')";
    //print '<pre>'; print $sql;
    $conexion = $this->conectar();
    $consulta = $this->consultar($conexion,$sql);

    if($consulta){

  	    $sql = "INSERT INTO detmemoexp";
		$sql = $sql."(id_memoexp ,  codpro ) VALUES ";
	    for($i=0;$i<count($detalleMemo)-42;$i+=42){
		    $sql = $sql. "('".$id."','".$detalleMemo[$i]."'),";
	    }
            $sql = $sql. "('".$id."','".$detalleMemo[$i]."')";
   // print $sql;

    $consulta = $this->consultar($conexion,$sql);
    }

	$this->desconectar($conexion);
    if($consulta)
    {
      $this->auditar($_SESSION['usuario'],'EXPEDIENTE','Registro de expediemte con el numero. '.$id);
      //Registro Forma de pago Oferta C.
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


function contarMemo($id_memoexp,$desde,$hasta,$rif,$banco,$usuario=null){

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

    if ($usuario) $sql.= " AND c.usuario_estatus like '%$usuario%' ";
	$sql.= "order by c.id_memoexp) z ";

 //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }

function listarMemo1($id_memoexp,$desde,$hasta,$rif,$banco,$offset,$usuario=null){

   $sql = "select
			 distinct(c.id_memoexp),c.nummem,to_char(c.fecha,'dd/mm/yyyy'),c.id_banco,c.observacion, count(b.id_memoexp), c.usuario_estatus";
	$sql.= " from
			  propietarios a, detmemoexp b, memoexp c
			 where
			  a.status='A' and a.codpro=b.codpro and c.id_memoexp=b.id_memoexp ";
    if($id_memoexp)  $sql.=" and b.id_memoexp='".$id_memoexp."' ";

    if ($banco) $sql.= " AND c.id_banco = '$banco' ";
    if ($rif) $sql.= " AND a.codpro like '%".$rif."%'";

    if($desde AND !$hasta) $sql.= " and c.fecha >= '".$desde."'";
	else if (!$desde AND  $hasta) $sql.= " and c.fecha <= '".$hasta."'";
	else if ($desde  AND  $hasta) $sql .= " and  c.fecha BETWEEN '".$desde."' AND '".$hasta."'";

	if ($usuario) $sql.= " AND c.usuario_estatus like '%$usuario%' ";

	$sql.= " GROUP BY  c.id_memoexp,c.nummem,c.fecha,c.id_banco,c.observacion, c.usuario_estatus ";
	$sql.= "order by c.id_memoexp desc";
    if($offset>=0) $sql = $sql." LIMIT 20 OFFSET ".$offset;
   //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
 }

 function registroEstatusCredito($banco,$detalleMemo,$estatus){

   // echo 'aqui'.$estatus;
    $conexion = $this->conectar();

	$fecha=date('d/m/Y');
	$hora=date('H:i:s');
    $cenopa=null;
    $j=0;

	    for($i=0;$i<count($detalleMemo);$i+=43){
	    	$sql1 = "INSERT INTO credito (id_banco ,  codpro, estatus, usuario_estatus, fecha_estatus,monto, usuario_mod, fecha_mod, hora_mod ) VALUES ";
		    $sql1 .= "('".$banco."','".$detalleMemo[$i]."','".$estatus."','".$_SESSION['usuario']."','".$fecha."','".$detalleMemo[$i+42]."','".$_SESSION['usuario']."','".$fecha."','".$hora."');";
	     // print "<br>Query: ".$sql1;
	        $consulta = $this->consultar($conexion,$sql1);
	    }


	     if(!$consulta)	$cenopa[$j]=' '.$detalleMemo[$i].' ; ';
         $j++;

	     $this->auditar($_SESSION['usuario'],'CREDITO','Registro estatus de credito: '.$estatus.' - '.$detalleMemo[$i].' hora: '.$hora);
 //}aquí estaba cerrado antes el for, y dejo de funcionar
	$this->desconectar($conexion);

	return $cenopa;

 }

 function listarEstatusCredito($banco,$estatus,$rif,$desde,$hasta,$offset,$tipo=null,$neg=null){

 	  if ($tipo=='A') {

 	  	$select=" , b.sercarveh , k.desmar,l.desmod,  d.banco_descrip, desEstatus(a.id_estatus), j.numlotveh,h.numplaveh ";
 	  	$tablas=", asignacion  b, vehiculo i
		left outer join placas h  on h.sercarveh=i.sercarveh,caracteristica j
		left outer join marcas k on k.codmar=j.codmarveh
		left outer join modelo l  on l.codmod=j.codmod,
		propietarios c,
		facturaprof a
		left outer join banco d on d.id_banco=a.id_banco,
		lote n,color p ";
		$where=" and j.numlotveh=n.numlot and
		i.id_caract=j.id_caract and
		b.sercarveh=i.sercarveh and
		a.estatus='A' and
		a.id_asignacion=b.id_asignacion and
		b.codpro=c.codpro
		and p.codcol=i.col1veh and c.codpro=credito.codpro ";}
 	    else {$select=' '; $tablas=' ';}


     $sql = "select id_credito,propietarios.codpro,desbanco(credito.id_banco),estatus.descripcion,credito.usuario_estatus,to_char(credito.fecha_estatus,'dd/mm/yyyy'),
			credito.monto,credito.usuario_mod,propietarios.nomcomp,
			to_char(credito.fecha_mod,'dd/mm/yyyy') $select
			from  credito, propietarios, estatus $tablas where credito.id_banco<>'' and credito.codpro=propietarios.codpro and
			credito.estatus=estatus.id_estatus $where ";
     if ($tipo=='A') $sql.=" and  credito.codpro=b.codpro and b.status='A' ";
	 if ($tipo=='S') $sql.=" and credito.codpro not in (select codpro from asignacion where status='A')";

    if ($banco) $sql.=  " and credito.id_banco='$banco'";
    if ($estatus) $sql.=  " and  credito.estatus=$estatus";

    if ($rif) $sql.=  " and  credito.codpro like '%".$rif."%'";

    if ($neg)  $sql.=  " and  credito.estatus<>16 ";

    if($desde AND !$hasta) $sql.= " and credito.fecha_estatus >= '".$desde."'";
	else if (!$desde AND  $hasta) $sql.= " and  credito.fecha_estatus <= '".$hasta."'";
	else if ($desde  AND  $hasta)	$sql .= " and   credito.fecha_estatus BETWEEN '".$desde."' AND '".$hasta."'";

    //$sql.= " order by fecha_estatus desc, oid desc";
    $sql.= " order by  credito.fecha_mod desc,  credito.oid desc";
  if($offset>=0) $sql = $sql." LIMIT 20 OFFSET ".$offset;

  //echo '<pre>'.$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;

 }


//BENEFICIARIOS CONSOLIDADO POR ESTADOS
function cuadroBenefxEdo($tipo=null,$fechaD=null,$fechaH=null,$banco=null,$lote=null)
{
	$sql = "select x.codest, x.nomest,
(select count(z.cedulas) from (SELECT
 distinct(a.codpro) as cedulas
FROM
  asignacion a,
  propietarios b";

 if ($lote) $sql.= ", vehiculo c, caracteristica d";

$sql.= "
WHERE
  b.codpro = a.codpro and a.status='A'
  and  b.codest=x.codest";

if ($lote) $sql.= " and a.sercarveh=c.sercarveh and c.id_caract=d.id_caract and d.numlotveh=$lote";

if ($tipo) $sql.=" and b.tipo=$tipo";
if($fechaD AND !$fechaH) $sql.= " and a.fecha_asig >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and a.fecha_asig <= '".$fechaH."'";
	else if ($fechaD  AND  $fechaH)	$sql.= " and a.fecha_asig BETWEEN '".$fechaD."' AND '".$fechaH."'";

if ($banco) $sql.=" and b.id_banco='$banco'";


$sql.= " group by a.codpro) z) as beneficiados,
( select count(w.cedulasw) from (SELECT
  distinct(b.codpro) as cedulasw
FROM
  propietarios b WHERE  b.codest=x.codest";

if ($tipo) $sql.=" and b.tipo=$tipo";
if($fechaD AND !$fechaH) $sql.= " and a.fecha_asig >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and a.fecha_asig <= '".$fechaH."'";
	else if ($fechaD  AND  $fechaH)	$sql.= " and a.fecha_asig BETWEEN '".$fechaD."' AND '".$fechaH."'";
if ($banco) $sql.=" and b.id_banco='$banco'";

$sql.= " and b.codpro not in (select distinct(codpro) from asignacion where status='A')) w) as nobeneficiados

from zona_estado x";

  //echo "Benef x Edo.: ".$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
}

function cuadroBenefSinEdo($tipo=null,$fechaD=null,$fechaH=null,$banco=null,$lote=null)
{
	$sql = "select x.codest, x.nomest,
(select count(z.cedulas) from (SELECT
 distinct(a.codpro) as cedulas
FROM
  asignacion a,
  propietarios b";

 if ($lote) $sql.= ", vehiculo c, caracteristica d";

$sql.= "
WHERE
  b.codpro = a.codpro and a.status='A'
  and (b.codest='' or b.codest='0' or b.codest is null)";

if ($lote) $sql.= " and a.sercarveh=c.sercarveh and c.id_caract=d.id_caract and d.numlotveh=$lote";

if ($tipo) $sql.=" and b.tipo=$tipo";
if($fechaD AND !$fechaH) $sql.= " and a.fecha_asig >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and a.fecha_asig <= '".$fechaH."'";
	else if ($fechaD  AND  $fechaH)	$sql.= " and a.fecha_asig BETWEEN '".$fechaD."' AND '".$fechaH."'";
if ($banco) $sql.=" and b.id_banco='$banco'";


$sql.= " group by a.codpro) z) as beneficiados,
(select count(w.cedulasw) from (SELECT
  distinct(b.codpro) as cedulasw
FROM
  propietarios b WHERE (b.codest='' or b.codest='0')";

if ($tipo) $sql.=" and b.tipo=$tipo";
if($fechaD AND !$fechaH) $sql.= " and a.fecha_asig >= '".$fechaD."'";
	else if (!$fechaD AND  $fechaH) $sql.= " and a.fecha_asig <= '".$fechaH."'";
	else if ($fechaD  AND  $fechaH)	$sql.= " and a.fecha_asig BETWEEN '".$fechaD."' AND '".$fechaH."'";
if ($banco) $sql.=" and b.id_banco='$banco'";

$sql.= "  and b.codpro not in (select distinct(codpro) from asignacion where status='A')) w) as nobenef

from zona_estado x";


 //echo "Benef sin Edo.: ".$sql;

  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);

  return $consulta;
}

function listar_Bene_Tipo_benef(){
  $sql = "select a.descripcion,
(select count(codpro) from propietarios where tipo=a.codtipben and codpro like '%V%' and  status='A') as Vene,
(select count(codpro) from propietarios where tipo=a.codtipben and codpro like '%E%' and status='A') as Ext,
(select count(codpro) from propietarios where tipo=a.codtipben and codpro like '%G%' and status='A') as Gob,
(select count(codpro) from propietarios where tipo=a.codtipben and codpro like '%J%' and status='A') as Jur,
(select count(codpro) from propietarios where tipo=a.codtipben and status='A' ) as cantidad from tipo_benef a";

  //print '<pre>'; print $sql;
  $conexion = $this->conectar();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
 }
 

  function listarPrueba2(){

    $sql = "( SELECT
         reg_nombre,
         nomest AS estado,
         COUNT(*) AS estado_web,
        (SELECT
                COUNT(*)
            FROM
                repbenefsol sol,
                ususolcit cit
            WHERE
                sol.codpro = cit.codpro
                AND cit.asiste = 'S'
                AND sol.codest = estado.codest) AS atendidas,
    (SELECT
                COUNT(*)
            FROM
                repbenefsol sol,
                ususolcit cit
            WHERE
                sol.codpro = cit.codpro
                AND cit.asiste = 'A'
                AND sol.codest = estado.codest) AS pendientes,
    (SELECT
                COUNT(*)
            FROM
                repbenefsol sol,
                ususolcit cit
            WHERE
                sol.codpro = cit.codpro
                AND cit.asiste = 'V'
                AND sol.codest = estado.codest) AS noasistieron,
    (SELECT
                COUNT(*)
            FROM
                repbenefsol sol
            WHERE
                sol.codest = estado.codest
                AND sol.codpro NOT IN (SELECT codpro FROM ususolcit)) AS sincita
    FROM
        ususolcit citas,
        repbenefsol solicitante,
        zona_estado estado,
        regiones regiones
    WHERE
        citas.codpro            = solicitante.codpro
        AND solicitante.codest = estado.codest and regiones.id=estado.reg_id
    GROUP BY
        estado.codest,
        estado.nomest,
        reg_nombre
        order by reg_nombre)
        union  all (
        select 'sin region' as sinreg, 'sin estado' as sinest, (
[El texto citado está oculto]
                AND sol.codpro NOT IN (SELECT codpro FROM ususolcit)) AS sincita)";
//print $sql;
  $conexion = $this->conectar2();
  $consulta = $this->consultar($conexion,$sql);
  $consulta = $this->ret_vector($consulta);
  $this->desconectar($conexion);
  return $consulta;
  }
}
?>