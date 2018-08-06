#!/usr/bin/php -q
<?php
require('../modelos/conexion.php');
require("class.phpmailer.php"); //Importamos la función PHP class.phpmailer
include("class.smtp.php");
$mail = new PHPMailer();
$today = date('j-m-y');
$hora=date('H:i:s');
$term = "Beneficarios";
$rutaArc="../cron/beneficiarios/";
$termR=$term."_".$today."_".$hora;

$ban=0;

//Luego tenemos que iniciar la validación por SMTP:
$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta o de lo contrario False
$mail->Username = "tecnologia.facturacion@suvinca.gob.ve"; // Cuenta de e-mail
$mail->Password = "tecnologiafac"; // Password

$cuerpoDet='';
$archivoError='';

$obj = new conexion();


$conexion = $obj->conectar();

//$conexion2 = $this->conectar2();

$mail->Timeout=30;
$mail->Host = "192.168.7.16";
$mail->From = "tecnologia.facturacion@suvinca.gob.ve";
$mail->FromName = "Beneficiarios Registrados";
$mail->Subject ="Registro de Beneficiarios al ".$today;
$mail->AddAddress("presidencia@suvinca.gob.ve","Presidencia");
$mail->AddAddress("eddiebetancourt@yahoo.com","Eddie Betancourt");
$mail->AddAddress("n.reina@suvinca.gob.ve","Nelvy Yaneth Reina Romero");
$mail->AddAddress("a.florido@suvinca.gob.ve","Ada Florido");
$mail->AddAddress("t.leal@suvinca.gob.ve","Thania Leal");
$mail->AddAddress("k.sosa@suvinca.gob.ve","Katiuska Sosa");
$mail->AddAddress("d.marquez@suvinca.gob.ve","Digna Marquez");
$mail->AddAddress("n.tovar@suvinca.gob.ve","Nelo R. Tovar");

$mail->WordWrap = 50;

		   $cuerpo = '<html><head>
			<title>	digna </title>
			</head>
			<body>
            <table border="1">
			 <tr>
			  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="18"><font color="#FFFFFF"> LISTA DE BENEFICIARIOS REGISTRADOS EL DIA '.$today.'</font></td>
			</tr>
			<tr>
			          <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">N#</font></td>
					  <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">CI/RIF</font></td>
					  <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">Nombre</td>
					  <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Direcci&oacute;n</font></td>
					  <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Tel&eacute;fonos</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">Observaciones</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Fecha Registro</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Banco</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="250"><font color="#FFFFFF">Usuario</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">Tipo Benef.</font></td>
			  </tr>';

        $fecha=date('d/m/Y');
		$sql="
			  select
			  codpro, prinompro , segnompro, priapepro ,segapepro, nomorgpro ,  nomcomp ,
			  calavepro , urbbarpro,  edicaspro ,numpispro , numapapro ,dismunpro ,
			  ciudadpro , tlfcelpro ,tlfcel2pro , obspro ,tipmovpro, to_char(fecha_reg,'dd/mm/yyyy'),  substr(codpro,1,1) as nac,
			  substr(codpro,2,8) as nac, substr(codpro,10,1) as nac,
			  substr(tlfcelpro,1,4) as cod,substr(tlfcelpro,5,7) as num ,substr(tlfcel2pro,1,4) as cod2,substr(tlfcel2pro,5,7) as num2,
              calavepro,urbbarpro,edicaspro,numpispro,numapapro,dismunpro,ciudadpro, sexo,
              (case sexo when 'F' THEN 'Femenino' when 'M' THEN 'Masculino' end) as destipo,
              propietarios.tipo, codest, codmun, codpar,to_char(fecnac,'dd/mm/yyyy'),propietarios.id_banco,desbanco(propietarios.id_banco),
              propietarios.usuario_pro, b.descripcion  from
			  propietarios, tipo_benef b
			  where
			  propietarios.status='A'  and 	propietarios.tipo=b.codtipben and fecha ='".$fecha."' and fecha=fecha_reg
			  order by id_pro desc, codpro";
			  //  echo $sql;
        $buscar = $obj->consultar($conexion,$sql);
        $VectorBuscar = $obj->ret_vector($buscar);
//       echo count($VectorBuscar);
       $cont=0;
       for($i=0;$i<count($VectorBuscar);$i+=44){
            $cont++;
            $cuerpoDet=$cuerpoDet.'<tr>
            		  <td >'.$cont.'</td>
					  <td >'.$VectorBuscar[$i].'</td>
					  <td >'.$VectorBuscar[$i+6].'</td>
					  <td >'.$VectorBuscar[$i+26].'</td>
					  <td >'.$VectorBuscar[$i+14].' '.$VectorBuscar[$i+15].'</td>
				      <td >'.$VectorBuscar[$i+16].'</td>
				      <td >'.$VectorBuscar[$i+18].'</td>
				      <td >'.$VectorBuscar[$i+41].'</td>
				      <td >'.$VectorBuscar[$i+42].'</td>
				      <td >'.$VectorBuscar[$i+43].'</td>
			         </tr>';


       }
       $cuerpo=$cuerpo.$cuerpoDet.
               '<tr>
			     <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="18"><font color="#FFFFFF">TOTAL: '.$cont.'</font></td>
			    </tr>
			    </table>
			    </body>
			    </html>';

$mail->Body =$cuerpo;
$mail->AltBody = "Listado de beneficiarios registrados en el Sistema SIRECOV al ".$fecha;

if (count($VectorBuscar)>0)
$mail->Send();

// Notificamos al usuario del estado del mensaje

if(!$mail->Send()){
   echo "No se pudo enviar el Mensaje.";
}else{
   echo "Mensaje enviado ";
}

$obj->desconectar($conexion);

?>
