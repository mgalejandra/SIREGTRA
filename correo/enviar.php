<?php
require("class.phpmailer.php"); //Importamos la función PHP class.phpmailer

$mail = new PHPMailer();

//$mail->Mailer = "smtp";

//Luego tenemos que iniciar la validación por SMTP:
$mail->IsSMTP();
$mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta o de lo contrario False
$mail->Username = "d.marquez@suvinca.gob.ve"; // Cuenta de e-mail
$mail->Password = "3791852dig"; // Password

 //mail->Port = 587;
 //$mail->SMTPSecure = "tls";
 $mail->Timeout=30;

$mail->Host = "localhost";
//$mail->Host = "mail.suvinca.gob.ve";
$mail->From = "d.marquez@suvinca.gob.ve";
$mail->FromName = "Digna Marquez";
$mail->Subject = "Correo enviado desde el sistema";
//$mail->AddAddress("marquezdigna83@gmail.com","Nombre a mostrar del Destinatario");
//$mail->AddAddress("enzoromaso@gmail.com","enzo");
//$mail->AddAddress("v.romaso@suvinca.gob.ve","enzo");
//$mail->AddAddress("d.marquez@suvinca.gob.ve","enzo");
$mail->AddAddress("marquezlunadigna@yahoo.com.ve","digna");


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
