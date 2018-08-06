<?php
function validarString($string){
 $permitidos = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyzáéíóúÁÉÍÓÚ ,.1234567890_-+*/"; //lista de caracteres permitidos
 for($i=0 ; $i < strlen($string) ; $i++){
     if(strpos($permitidos, $string[$i]) === false){
        return false;
     }
 }
 return true;
}

function validarCedula($string){
 $permitidos = "1234567890"; // caracteres permitidos
 for($i=0 ; $i < strlen($string) ; $i++){
     if(strpos($permitidos, $string[$i]) === false){
        return false;
     }
 }
 return true;
}

function validarNombre($string){
 $permitidos = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyzáéíóúÁÉÍÓÚ ."; //lista de caracteres permitidos
 for($i=0 ; $i < strlen($string) ; $i++){
     if(strpos($permitidos, $string[$i]) === false){
        return false;
     }
 }
 return true;
}


function validarTelefono($string){
 $permitidos = "1234567890"; // caracteres permitidos
 for($i=0 ; $i < strlen($string) ; $i++){
     if(strpos($permitidos, $string[$i]) === false){
        return false;
     }
 }
 return true;
}

function validarEntero($string){
 $permitidos = "1234567890"; // caracteres permitidos
 for($i=0 ; $i < strlen($string) ; $i++){
     if(strpos($permitidos, $string[$i]) === false){
        return false;
     }
 }
 return true;
}

function validarDecimal($string){
 $permitidos = "1234567890."; // caracteres permitidos
 $ind = true;
 for($i=0 ; $i < strlen($string) ; $i++){// verifica la cadena de carateres
     if(strpos($permitidos, $string[$i]) === false){
        $ind = false;
        //break;
     }
 }

 if(!$ind) return false; // si hay caracteres invalidos retorna false
 else{
    $valor = explode('.',$string);
    if(count($valor)>2)return false; // si el formato es distinto de 99.99 retorna false
    elseif(strlen($valor[1])>2)return false; // si posee mas de 2 decimales retorna false
    else return true; // si el valor es valido de 99.99 retorna true
 }

}

function validarFoto($foto){
 $tipo = $foto['type'];
 if (
     ($tipo=="image/jpeg") OR
     ($tipo=="image/gif")  OR
     ($tipo=="image/jpg")  OR
     ($tipo=="image/pjpeg") OR
     ($tipo=="image/png") OR
     ($tipo=="image/x-png")
    ) return true;
 else return false;

}

function graba_foto($foto,$codArt,$destino){
	$fichero = $foto[ 'name' ];
	$nombre_archivo = $foto['name']; // Nombre del Fichero en la maquina

	/*Inicio Explode para sacar la extension del archivo*/
	$explode = explode(".", $nombre_archivo);
	$conteo_final=count ($explode);
	$conteo_final=$conteo_final-1;
	$extension=strtolower($explode[$conteo_final]);
	/*Fin Explode para sacar la extension del archivo*/

	/*Coloca una fecha antes del archivo*/
	$nombre_foto = $codArt. '.' .$extension;

	/*Mueve el archivo del directorio tmp al Destino*/
	$ind = move_uploaded_file ( $foto[ 'tmp_name' ], '../'.$destino . '/' .$nombre_foto);
    chmod('../'.$destino . '/' .$nombre_foto,0755);
    if($ind) return true;
    else return $ind;
  }

function validaSesion(){
   if(!$_SESSION['usuario']){
      echo '<SCRIPT>alert("Debe iniciar sesión para acceder a este módulo");window.location.href="../index.php"</SCRIPT>';
   }
}


function validaAcceso($permitidos,$url){
 $fecha=date('m/d/Y H:m:s');
 $ip = $_SERVER["REMOTE_ADDR"];
 $objConexion = new conexion();
 $conexion = $objConexion->conectar();
 if(!$_SESSION['usuario']){
   $sql = "INSERT INTO auditoria (usuario,fecha,accion,sentencia,formulario)
           VALUES ('INTRUSO: ".$ip."','".$fecha."','Acceso negado','Intenta entrar a pagina sin iniciar sesión','".$url."')";
   $consulta = $objConexion->consultar($conexion,$sql);
   $objConexion->desconectar($conexion);
   echo '<SCRIPT>alert("DEBE INICIAR SESION PARA ACCEDER A ESTA OPCION");window.location.href="index.php"</SCRIPT>';
 }
 else{
   $ind = true;
   for($i=0;$i<count($permitidos);$i++){
       if($_SESSION['tipoUsuario'] == $permitidos[$i])$ind = false;
   }
   if($ind){
      $sql = "INSERT INTO auditoria (usuario,fecha,accion,sentencia,formulario)
              VALUES ('".$_SESSION['usuario']."','".$fecha."','Acceso negado','".$_SESSION['usuario']." intenta entrar a pagina no autorizada','".$url."')";
      $consulta = $objConexion->consultar($conexion,$sql);
      $objConexion->desconectar($conexion);
      session_unset();
      session_destroy();
      echo '<SCRIPT>alert("OPCION NO VALIDA PARA ESTE USUARIO NO TIENE PERMISO");window.location.href="index.php"</SCRIPT>';
   }
 }

}

 function corrigeString($string){
        $caracter1 = array('á','é','í','ó','ú','ñ','<','@','>','Á','É','Í','Ó','Ú','Ñ');
    	$caracter2 = array('a','e','i','o','u','n','&lt;','&#064;','&gt;','A','E','I','O','U','N');
     	$string = str_ireplace($caracter1,$caracter2,$string);
        return strtoupper($string);
 }

function validarFecha($fecha,$criterio){
  date_default_timezone_set('UTC');
  $diaC = date("d");
  $mesC = date("m");
  $anoC = date("Y");
  $dia = substr($fecha,0,2);
  $mes = substr($fecha,3,2);
  $ano = substr($fecha,6,4);
  $ind = false;
  switch($criterio){
   case 1:{// fecha menores o iguales a la fecha actual
    if($ano < $anoC)$ind = true;
    elseif($ano == $anoC){
      if($mes < $mesC)$ind = true;
      else if ($mes == $mesC){
        if($dia <= $diaC)$ind = true;
      }
    }
   }break;
   case 2:{// fechas mayores o iguales a la fecha actual
    if($ano > $anoC)$ind = true;
    elseif($ano == $anoC){
      if($mes > $mesC)$ind = true;
      else if ($mes == $mesC){
        if($dia >= $diaC)$ind = true;
      }
    }
   }break;
  }
  return $ind;
}

function ordenaFecha($fecha){
   $dia = substr($fecha,8,2);
   $mes = substr($fecha,5,2);
   $anho = substr($fecha,0,4);
   return $dia.'-'.$mes.'-'.$anho;
}

function validarCorreo($correo){
 $permitidos = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz.1234567890_-@"; //lista de caracteres permitidos
 $data = explode('@',$correo);
 if(count($data)!=2){ // valida que exista un solo @
 	return false;
 }
 else{
 	 for($i=0 ; $i < strlen($correo) ; $i++){
         if(strpos($permitidos, $correo[$i]) === false){
            return false;
         }
     }
     return true;
 }

}
//direcciona al modulo correspondiente
function direccionar($tipoUsuario){
     switch ($tipoUsuario) {
	   case 'US_001': $pg = 'admin/'; break;
	   case 'US_002': $pg = 'ia/'; break;
	   case 'US_003':
	   case 'US_005':
	   case 'US_008':
	         $pg = 'pv/'; break;
     }
     echo '<SCRIPT>window.location.href="'.$pg.'"</SCRIPT>';
}


// funciones Digna
function NumNull($num)
    {
       if ($num==''){
     $num="NULL";
     }

      return ($num);
    }


function FormatoMonto($value,$dec='2')
  {
  	//H::FormatoMonto($monto)
  	$for='VE';
  	if ($value==' ')
  	{
  		$value=0;
  	}

  	if ($for=='VE')
  		$valor = number_format($value,$dec,',','.');
  	elseif ($for=='IN')
  	   	$valor = number_format($value,$dec,'.',',');
  	else
  	    $valor = number_format($value,0);

  	return $valor;
  }

function CuadrosN($posx, $posy, $ancho, $alto, $cantidadh, $cantidadv, $estilo)
		{
			/*******************************************/
			/****ESTA FUNCION ES PARA PINTAR CUADROS****/
			//cuadros(10,10,66,10,3(columnas),5(filas));
			/*******************************************/
			for($x=0;$x < $cantidadh;$x++)
			{
				for($y=0;$y < $cantidadv;$y++)
				{
					$forx=$posx+($x*$ancho);
					$fory=$posy+($y*$alto);
					$this->Rect($forx,$fory,$ancho,$alto,$estilo);
				}
			}
		}

 function ObtenerMesenLetras($mes)
  {
  			if($mes=='01')  return $mes='Enero';
			if($mes=='02')  return $mes='Febrero';
			if($mes=='03')  return $mes='Marzo';
			if($mes=='04')  return $mes='Abril';
			if($mes=='05')  return $mes='Mayo';
			if($mes=='06')	return $mes='Junio';
			if($mes=='07')  return $mes='Julio';
			if($mes=='08')	return $mes='Agosto';
			if($mes=='09')  return $mes='Septiembre';
			if($mes=='10')	return $mes='Octubre';
			if($mes=='11')  return $mes='Noviembre';
			if($mes=='12')  return $mes='Diciembre';
			//ObtenerMesenLetras('01')
  }

   function MensajeVal($mens,$campo,$form)
  {
  	$focus="<script>document.".$form.".".$campo.".focus();</script>";
    echo "<table align='center'><tr>";
    echo "<td class='rechazo'></td>";
  	echo "<td><span class='rechazado'>".$mens."</span></td>";
  	echo "</tr></table>";
  	echo $focus;
  }

 function MensajeReg($mens,$estatus){
  	if ($estatus){
  	    echo "<table align='center'><tr>";
	    echo "<td class='correcto'></td>";
	  	echo "<td><span class='registrado'>".$mens."</span></td>";
	  	echo "</tr></table>";
	}
  	else{
	  	echo "<table align='center'><tr>";
	    echo "<td class='rechazo'></td>";
	  	echo "<td><span class='rechazado'>".$mens."</span></td>";
	  	echo "</tr></table>";
	}
  }

    function MensajeRegFocus($mens,$campo,$form)
  {
    $focus="<script>document.".$form.".".$campo.".focus();</script>";
 	echo "<table align='center'><tr>";
    echo "<td class='rechazo'></td>";
  	echo "<td><span class='rechazado'>".$mens."</span></td>";
  	echo "</tr></table>";
  	print $focus;
  }



// fin funciones digna

///%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%///
///%%%%%%%%%%%%%%%%%%% Funciones Gustavo %%%%%%%%%%%%%%%%%%%%%%%%%%///
///%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%///
function fechaHoy(){
	$today = mktime(0,0,0,date("Y"),date("m"),date("d"));
	return date("Y-m-d");
}
///%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%///
function f_alert ($msj) {
	echo '<script>alert("'.$msj.'");</script>';
	return;
}
///%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%///
function f_confirm ($msj) {
	return '<script>confirm("'.$msj.'");</script>';
}
///%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%///
function strToDate ($date) {
	return strftime("%F",strtotime($date)); // "$year-$month-$day";
}
///%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%///
function f_dateTo ($date,$fmt=null) {
if($fmt=="$d-$m-$y"){
	$d = substr($date,8);
	$m = substr($date,5,2);
	$y = substr($date,0,4);
	return $d."/".$m."/".$y;
}
else{
	$d = substr($date,0,2);
	$m = substr($date,3,2);
	$y = substr($date,6);
	return $y."-".$m."-".$d;
}
}
/* //////////////////////////////////////////////////////////////////////////// */
function f_poten ($b,$e) {
	$p=1;
	for($i=0;$i<$e;$i++)$p*=10;
	return $p;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 function f_numletras ($d,$v=1,$l=null) {

	$tab1 = array('','uno','dos','tres','cuatro','cinco','seis','siete','ocho','nueve');
	$tab2 = array('diez','once','doce','trece','catorce','quince','dieciseis','diecisiete','dieciocho','diecinueve');
	$tab3 = array('','dieci','veinti','treinta','cuarenta','cincuenta','sesenta','setenta','ochenta','noventa','ciento');
	$tab4 = array('','ciento','dosc','tresc','cuatroc','quin','seisc','setec','ochoc','novec','mil');

	$n = (!$l)?strlen($d):$l;
	$p = f_poten(10,$n-$v);
	$d0 = floor($d/$p);
	$d1 = $d0*$p;
	$d2 = $d-$d1;

//echo '<br>'.'d:'.$d.' d1:'.$d1.' d2:'.$d2.' n:'.$n.' p:'.$p.' v:'.$v.' l:'.$l;

	if($d0==101 and $v==3) return 'ciento un mil '.f_numletras($d2,1);
	if($d>0  and $d<10) return ($d==1)?'un':$tab1[$d];
	if($d>9  and $d<20) return $tab2[$d-10];
	if($d>19 and $d<30) return ($d==20)?'veinte':'veinti'.$tab1[$d-20];
	if($d>99 and $d<200)return ($d==100)?'cien':'ciento '.f_numletras($d2,1,$l);

	if($n==4) return (($d0==1)?'un':$tab1[$d0]).' mil '.f_numletras($d2,1);
	if($n==3) return $tab4[$d0].'ientos '.f_numletras($d2,1);
	if($n==2) return ($d2==0)?$tab3[$d0]:$tab3[$d0].' y '.$tab1[$d2];

	if($n==5 and !$l) return f_numletras($d,2,$n);
	if($n==6 and !$l) return f_numletras($d,3,$n);
	if($l==5 or $l==6) return f_numletras($d0).' mil '.f_numletras($d2,1);

	if($n==7 and !$l) return f_numletras($d,1,$n);
	if($n==8 and !$l) return f_numletras($d,1,$n);
	if($l==7 or $l==8) return f_numletras($d0).utf8_decode(' millón ').f_numletras($d2,1);

  }

  function suma_fechas($fecha,$ndias)
{
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
              list($dia,$mes,$año)=explode("/", $fecha);

      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
              list($dia,$mes,$año)=explode("-",$fecha);

      $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
      $nuevafecha=date("d/m/Y",$nueva);

      return ($nuevafecha);
}


function graba_documento($documento,$cot,$destino,$tam,$fecha)
{
	$nombre_archivo = $documento['name'];
    $tipo_archivo = $documento['type'];
    $tamano_archivo = $documento['size'];
    $nombre_definitivo = $cot."_".$fecha."_".$nombre_archivo;

    $uploadfile = $destino.basename($nombre_definitivo);

   	if (((strpos($tipo_archivo, "ods") || strpos($tipo_archivo, "doc") || strpos($tipo_archivo, "pdf")) && ($tamano_archivo < $tam)))
   		move_uploaded_file($documento['tmp_name'], $uploadfile);
   		chmod($uploadfile,0777);
}

 function FormatoNum($value)
  {
  	//H::FormatoMonto($monto)
  	$for='VE';
  	if ($value==' ')
  	{
  		$value=0;
  	}

  	if ($for=='VE')
  		$valor = number_format($value);
  	elseif ($for=='IN')
  	   	$valor = number_format($value);
  	else
  	    $valor = number_format($value);

  	return $valor;
  }
function montoLetras($num, $fem = true, $dec = true) {
//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande");
   $matuni[2]  = "dos";
   $matuni[3]  = "tres";
   $matuni[4]  = "cuatro";
   $matuni[5]  = "cinco";
   $matuni[6]  = "seis";
   $matuni[7]  = "siete";
   $matuni[8]  = "ocho";
   $matuni[9]  = "nueve";
   $matuni[10] = "diez";
   $matuni[11] = "once";
   $matuni[12] = "doce";
   $matuni[13] = "trece";
   $matuni[14] = "catorce";
   $matuni[15] = "quince";
   $matuni[16] = "dieciseis";
   $matuni[17] = "diecisiete";
   $matuni[18] = "dieciocho";
   $matuni[19] = "diecinueve";
   $matuni[20] = "veinte";
   $matunisub[2] = "dos";
   $matunisub[3] = "tres";
   $matunisub[4] = "cuatro";
   $matunisub[5] = "quin";
   $matunisub[6] = "seis";
   $matunisub[7] = "sete";
   $matunisub[8] = "ocho";
   $matunisub[9] = "nove";

   $matdec[2] = "veint";
   $matdec[3] = "treinta";
   $matdec[4] = "cuarenta";
   $matdec[5] = "cincuenta";
   $matdec[6] = "sesenta";
   $matdec[7] = "setenta";
   $matdec[8] = "ochenta";
   $matdec[9] = "noventa";
   $matsub[3]  = 'mill';
   $matsub[5]  = 'bill';
   $matsub[7]  = 'mill';
   $matsub[9]  = 'trill';
   $matsub[11] = 'mill';
   $matsub[13] = 'bill';
   $matsub[15] = 'mill';
   $matmil[4]  = 'millones';
   $matmil[6]  = 'billones';
   $matmil[7]  = 'de billones';
   $matmil[8]  = 'millones de billones';
   $matmil[10] = 'trillones';
   $matmil[11] = 'de trillones';
   $matmil[12] = 'millones de trillones';
   $matmil[13] = 'de trillones';
   $matmil[14] = 'billones de trillones';
   $matmil[15] = 'de billones de trillones';
   $matmil[16] = 'millones de billones de trillones';

   $num = trim((string)@$num);
   if ($num[0] == '-') {
      $neg = 'menos ';
      $num = substr($num, 1);
   }else
      $neg = '';
   while ($num[0] == '0') $num = substr($num, 1);
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num;
   $zeros = true;
   $punt = false;
   $ent = '';
   $fra = '';
   for ($c = 0; $c < strlen($num); $c++) {
      $n = $num[$c];
      if (! (strpos(".,'''", $n) === false)) {
         if ($punt) break;
         else{
            $punt = true;
            continue;
         }

      }elseif (! (strpos('0123456789', $n) === false)) {
         if ($punt) {
            if ($n != '0') $zeros = false;
            $fra .= $n;
         }else

            $ent .= $n;
      }else

         break;

   }
   $ent = '     ' . $ent;
   if ($dec and $fra and ! $zeros) {
      $fin = ' coma';
      for ($n = 0; $n < strlen($fra); $n++) {
         if (($s = $fra[$n]) == '0')
            $fin .= ' cero';
         elseif ($s == '1')
            $fin .= $fem ? ' una' : ' un';
         else
            $fin .= ' ' . $matuni[$s];
      }
   }else
      $fin = '';
   if ((int)$ent === 0) return 'Cero ' . $fin;
   $tex = '';
   $sub = 0;
   $mils = 0;
   $neutro = false;
   while ( ($num = substr($ent, -3)) != '   ') {
      $ent = substr($ent, 0, -3);
      if (++$sub < 3 and $fem) {
         $matuni[1] = 'uno';
         $subcent = 'os';
      }else{
         $matuni[1] = $neutro ? 'un' : 'uno';
         $subcent = 'os';
      }
      $t = '';
      $n2 = substr($num, 1);
      if ($n2 == '00') {
      }elseif ($n2 < 21)
         $t = ' ' . $matuni[(int)$n2];
      elseif ($n2 < 30) {
         $n3 = $num[2];
         if ($n3 != 0) $t = 'i' . $matuni[$n3];
         $n2 = $num[1];
         $t = ' ' . $matdec[$n2] . $t;
      }else{
         $n3 = $num[2];
         if ($n3 != 0) $t = ' y ' . $matuni[$n3];
         $n2 = $num[1];
         $t = ' ' . $matdec[$n2] . $t;
      }
      $n = $num[0];
      if ($n == 1) {
         $t = ' ciento' . $t;
      }elseif ($n == 5){
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t;
      }elseif ($n != 0){
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t;
      }
      if ($sub == 1) {
      }elseif (! isset($matsub[$sub])) {
         if ($num == 1) {
            $t = ' mil';
         }elseif ($num > 1){
            $t .= ' mil';
         }
      }elseif ($num == 1) {
         $t .= ' ' . $matsub[$sub] . '?n';
      }elseif ($num > 1){
         $t .= ' ' . $matsub[$sub] . 'ones';
      }
      if ($num == '000') $mils ++;
      elseif ($mils != 0) {
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub];
         $mils = 0;
      }
      $neutro = true;
      $tex = $t . $tex;
   }
   $tex = $neg . substr($tex, 1) . $fin;
   return ucfirst($tex);
}

?>