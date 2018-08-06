<?php
require("class.phpmailer.php"); //Importamos la función PHP class.phpmailer
include("class.smtp.php");
$mail = new PHPMailer();

//$mail->Mailer = "smtp";

//Luego tenemos que iniciar la validación por SMTP:
$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->SMTPAuth = false; // True para que verifique autentificación de la cuenta o de lo contrario False
//$mail->SMTPSecure = "ssl";  //$mail->SMTPSecure = "tls";
//$mail->Port       = 465;
$mail->SMTPDebug = true;
$mail->SMTPDebug = 2;
$mail->Username = "d.marquez@suvinca.gob.ve"; // Cuenta de e-mail
$mail->Password = "3791852dig"; // Password

$mail->Timeout=30;
//$mail->Host = "mail.suvinca.gob.ve";
$mail->From = "d.marquez@suvinca.gob.ve";
$mail->FromName = "Digna Marquez2";
$mail->Subject = "Correo enviado desde el sistema1";
//$mail->AddAddress("marquezdigna83@gmail.com","Nombre a mostrar del Destinatario");
//$mail->AddAddress("enzoromaso@gmail.com","enzo");
//$mail->AddAddress("v.romaso@suvinca.gob.ve","enzo");
//$mail->AddAddress("d.marquez@suvinca.gob.ve","enzo");
$mail->AddAddress("cmazzagliar@gmail.com","car");
//$mail->AddAddress("digna_marquez83@hotmail.com","digna");no


$mail->WordWrap = 50;

//$mail->Timeout=30;
//$mail->PluginDir = "/";

$body  = "Hola, este es un mensaje de prueba";


$mail->Body = $body;

$mail->Send();


// Notificamos al usuario del estado del mensaje

if(!$mail->Send()){
   echo "No se pudo enviar el Mensaje.";
}else{
   echo "Mensaje enviado DIGNA";
}

?>
