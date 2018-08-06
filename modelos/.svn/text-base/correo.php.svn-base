<?php
require('../correo/class.phpmailer.php');
include('../correo/class.smtp.php');

class correo {

function correoClave($usuario,$password,$correo){

$mail = new PHPMailer();
$today = date('j-m-y');
$hora=date('H:i:s');
$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->SMTPAuth = false; // True para que verifique autentificación de la cuenta o de lo contrario False
$mail->Username = "no_reply@suvinca.gob.ve"; // Cuenta de e-mail
$mail->Password = "N0r3ply"; // Password
$mail->Timeout=30;
$mail->Host = "192.168.7.16";
$mail->From = "no_reply@suvinca.gob.ve";
$mail->FromName = "Suvinca Comersso Auto";
$mail->Subject ="Reinicio de Clave - Programa Comersso Auto ejecutado por SUVINCA";
$mail->AddAddress($correo);

$mail->WordWrap = 50;

$cuerpo = '<html><head>
			<title>Reinicio de Contraseña</title>
			</head>
			<body>
			<table border="0" align="center">
			<tr>
			<td colspan="2">Su contraseña ha sido cambiada satisfactoriamente. Puede ingresar al sistema haciendo uso de:</td>
			</tr>
			<tr>
			<td><strong>Usuario:</strong></td>
			<td align="left">'.$usuario.'</td>
			</tr>
			<tr>
			<td><strong>Clave Nueva:</strong></td>
			<td align="left">'.$password.' </td>
			</tr>
			</table>
			</body>
			</html>';
$mail->Body =$cuerpo;
$mail->AltBody = "Reinicio de Contraseña - Programa Comersso Auto ejecutado por SUVINCA";

$mail->Send();

}

function enviarCorreoReclamo($id,$cedula,$correoB,$correoEn,$nombre,$reclamos_des=null){

		$mail = new PHPMailer();
		$today = date('j-m-y');
		$hora=date('H:i:s');
		$mail->IsSMTP();
		$mail->Mailer = "smtp";
		$mail->SMTPAuth = false; // True para que verifique autentificación de la cuenta o de lo contrario False
		$mail->Username = "reclamo.sirecov@suvinca.gob.ve"; // Cuenta de e-mail
		$mail->Password = "r3cl4m0"; // Password
		$mail->Timeout=30;
		$mail->Host = "192.168.7.16"; //
		$mail->From = "reclamo.sirecov@suvinca.gob.ve";
		$mail->FromName = "Suvinca";
		$mail->Subject ="Caso Registrado";
		$mail->AddAddress($correoB);
		$mail->AddCC("$correoEn");

		$mail->WordWrap = 50;

		$cuerpo = '<html><head>
					<title>Caso Registrado</title>
					</head>
					<body>
					<table border="0" align="center">
  					<tr>
						<td style="text-align: center; background-color: #e6e6fa;" colspan="2">Caso Registrado </td>
  					</tr>
  					<tr>
						<td colspan="2">'.$nombre.', Portador de la Cedula de Identidad Nro'.$cedula.' su solicitud de '. $reclamos_des .' fue procesada, con el numero de caso '.$id[0].'</td>
  					</tr>
  					</table>
				</body>
				</html>';
$mail->Body =$cuerpo;
$mail->AltBody = "Caso Registrado";

$mail->Send();
return $id;

// Notificamos al usuario del estado del mensaje


}

function enviarCorreoStatus($id,$correoA,$correoEn,$nombre,$indReg,$usuario,$correoUsu=null,$diferido,$observ){
	if($indReg==1){
			$status='Asignado';
 	}
 	if($indReg==5){
			$status='Proceso';
 	}
  	if($indReg==2 and $diferido==1){
			$status='Diferido';
 	}
 	if($indReg==2 and $diferido==0){
		$status='Cerrado';
 	}
 	if($indReg==3){
		$status='Cerrado';
 	}
//echo 'asignado'.$correoA;
//echo '<br>Encargado '.$correoEn;
//echo '<br>usuario '.$correoUsu;

		$mail = new PHPMailer();
		$today = date('j-m-y');
		$hora=date('H:i:s');
		$mail->IsSMTP();
		$mail->Mailer = "smtp";
		$mail->SMTPAuth = false; // True para que verifique autentificación de la cuenta o de lo contrario False
		$mail->Username = "reclamo.sirecov@suvinca.gob.ve"; // Cuenta de e-mail
		$mail->Password = "r3cl4m0"; // Password
		$mail->Timeout=30;
		$mail->Host = "192.168.7.16"; //
		$mail->From = "reclamo.sirecov@suvinca.gob.ve";
		$mail->FromName = "Suvinca";
		$mail->Subject ="Caso '".$status."' ";
		$mail->AddAddress($correoA);
		if ($correoUsu) $mail->AddCC($correoEn,$correoUsu);
		else $mail->AddCC($correoEn);

		$mail->WordWrap = 50;

		$cuerpo = '<html><head>
					<title>Caso '.$status.'</title>
					</head>
					<body>
					<table border="0" align="center">
  					<tr>
						<td style="text-align: center; background-color: #e6e6fa;" colspan="2">Caso '.$status.'</td>
  					</tr>
  					<tr>
						<td colspan="2"> El Caso numero '.str_pad($id,5,'0',STR_PAD_LEFT).' a cambiado de Estatus a '.$status.'. ';
			if ($usuario)$cuerpo.=' Usuario Responsable '.$usuario.' </td>';
  			if ($observ)$cuerpo.=' Observacion '.$observ.' </td>';
  			$cuerpo.='	</tr>
  					</table>
				</body>
				</html>';
$mail->Body =$cuerpo;
$mail->AltBody = "Caso '".$status."'";

$mail->Send();
return $id;

// Notificamos al usuario del estado del mensaje


}

}