#!/usr/bin/php -q
<?php
require('../modelos/conexion.php');
require("class.phpmailer.php"); //Importamos la función PHP class.phpmailer
include("class.smtp.php");
$mail = new PHPMailer();
$today = date('j-m-y');
$hora=date('H:i:s');
$term = "FacturasEnviadas";
$rutaArc="../cron/facturas/";
$termR=$term."_".$today."_".$hora;
$archivo = fopen($rutaArc.$termR.".txt",'w+');
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

$mail->Timeout=30;
$mail->Host = "192.168.7.16";
$mail->From = "VentasVE@despegar.com";
$mail->FromName = "Reservas CRO Despegar.com";
$prueba="Ventas de eTicket.vz.";
$mail->Subject =$prueba;
$mail->AddAddress("marquezdigna83@gmail.com","Digna marquez");
//$mail->AddAddress("juanlatino@gmail.com","Juan Rodriguez");


$mail->WordWrap = 50;

		   $cuerpo = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="es"><head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge">
<table style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" width="642">
<tbody><tr><td colspan="3" style="background-color:#f7f7f7" height="25"><u></u></td></tr><tr><th width="20">&nbsp;</th><th style="padding:25px 5px 0" scope="col" align="left"><p style="margin-top:0px;margin-bottom:10px;color:#333333;font-size:16px;font-weight:normal">
Estimado/a <span>JUAN LATINO RODRIGUEZ TOVAR</span>,</p><p style="color:#333333;font-size:13px;font-weight:normal;margin-bottom:20px">Le informamos que de acuerdo a su solicitud<span style="font-weight:bold;font-size:15px">Reserva número: 12322743</span>hemos procedido&nbsp;con la emisión de&nbsp;su reserva.<br>
<br>Su número de ticket electrónico es: 0459096691614/15-VE RODRI/J<br></p></th><th width="20">&nbsp;</th></tr><tr><td width="20">&nbsp;</td><td bgcolor="CCCCCC"><div style="padding:1px;background-color:rgb(204,204,204);width:640px">
<table style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" width="640">
<tbody><tr>
<td width="20">
&nbsp;
</td>
<td bgcolor="CCCCCC">
<div style="padding-top:1px">
<table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="600">
<tbody>
<tr height="20">
<td colspan="2">
&nbsp;
</td>
</tr>
<tr>
<td valign="top" width="245">
<p style="font-size:16px;color:#003e92;margin:0;padding-left:5px">
Pasajeros</p>
</td>
<td colspan="2" style="padding:0" valign="top" width="355">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr style="margin-bottom:20px">
<td colspan="2" height="25" valign="top">
<span style="font-size:11px;color:#999999">Nombre y Apellido: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">JUAN LATINO RODRIGUEZ TOVAR</span>
</td>
</tr>
<tr>
<td colspan="2" height="25" valign="top">
<span style="font-size:11px;color:#999999">Documento: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left"></span>
</td>
</tr>
<tr>
<td colspan="2" style="font-size:5px">
&nbsp;
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody>
</table>
</div>
<div style="padding-top:1px">
<table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="600">
<tbody>
<tr height="20">
<td width="600">
<p style="font-size:16px;color:#003e92;margin:0;padding-left:5px">
Su reserva de vuelos</p>
</td>
</tr>
</tbody>
</table>
</div>
<div style="padding-top:1px">
<table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" height="260" width="600">
<tbody>
<tr height="20">
<td colspan="2">
&nbsp;
</td>
</tr>
<tr>
<td valign="top" width="245">
<table align="right" border="0" cellpadding="0" cellspacing="0" width="240">
<tbody><tr>
<td>
<span style="font-size:16px;color:#003e92;display:block;margin:0;margin-bottom:10px">
Tramo</span>
</td>
</tr>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td width="35">
<img src="Gmail%20-%20Fwd:%20Emisi%C3%B3n%20de%20eTicket.vz._files/ag_LAlogo.gif" height="23" width="35">
</td>
<td valign="middle">
<span style="color:#999999;margin-left:10px">Lan</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<span style="font-size:13px;color:#333333;display:block;padding-top:15px">LA
561</span>
</td>
</tr>
</tbody></table>
</td>
<td colspan="2" style="padding:0" valign="top" width="355">
<table border="0" cellpadding="0" cellspacing="0" height="220" width="100%">
<tbody><tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td valign="top" width="160">
<span style="font-size:11px;color:#999999">Sale: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">01/04/2013 11:40</span>
</td>
<td style="font-size:11px;color:#999999" valign="top">De: <span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">Caracas [Aeropuerto Internacional Simon Bolivar] Caracas, Venezuela
(CCS)</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td valign="top" width="160">
<span style="font-size:11px;color:#999999">Llega: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">01/04/2013 19:50</span>
</td>
<td valign="top">
<span style="font-size:11px;color:#999999">A: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">Santiago de Chile [Aeropuerto Comodoro Arturo Merino Benitez], Chile
(SCL)</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Duración: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">08:10:00</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Clase: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">ECONOMY</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Asientos: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">1</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Se permite fumar: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">NO</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Comida: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">N/A</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Código de reserva: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">
4V4LMT</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody>
</table>
</div>
<div style="padding-top:1px">
<table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" height="260" width="600">
<tbody>
<tr height="20">
<td colspan="2">
&nbsp;
</td>
</tr>
<tr>
<td valign="top" width="245">
<table align="right" border="0" cellpadding="0" cellspacing="0" width="240">
<tbody><tr>
<td>
<span style="font-size:16px;color:#003e92;display:block;margin:0;margin-bottom:10px">
Tramo</span>
</td>
</tr>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td width="35">
<img src="Gmail%20-%20Fwd:%20Emisi%C3%B3n%20de%20eTicket.vz._files/ag_LAlogo.gif" height="23" width="35">
</td>
<td valign="middle">
<span style="color:#999999;margin-left:10px">Lan</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<span style="font-size:13px;color:#333333;display:block;padding-top:15px">LA
257</span>
</td>
</tr>
</tbody></table>
</td>
<td colspan="2" style="padding:0" valign="top" width="355">
<table border="0" cellpadding="0" cellspacing="0" height="220" width="100%">
<tbody><tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td valign="top" width="160">
<span style="font-size:11px;color:#999999">Sale: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">02/04/2013 07:25</span>
</td>
<td style="font-size:11px;color:#999999" valign="top">De: <span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">Santiago de Chile [Aeropuerto Comodoro Arturo Merino Benitez], Chile
(SCL)</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td valign="top" width="160">
<span style="font-size:11px;color:#999999">Llega: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">02/04/2013 09:10</span>
</td>
<td valign="top">
<span style="font-size:11px;color:#999999">A: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">Puerto Montt [El Tepual], Chile
(PMC)</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Duración: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">01:45:00</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Clase: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">ECONOMY</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Asientos: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">1</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Se permite fumar: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">NO</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Comida: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">N/A</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Código de reserva: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">
4V4LMT</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody>
</table>
</div>
<div style="padding-top:1px">
<table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" height="260" width="600">
<tbody>
<tr height="20">
<td colspan="2">
&nbsp;
</td>
</tr>
<tr>
<td valign="top" width="245">
<table align="right" border="0" cellpadding="0" cellspacing="0" width="240">
<tbody><tr>
<td>
<span style="font-size:16px;color:#003e92;display:block;margin:0;margin-bottom:10px">
Tramo</span>
</td>
</tr>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td width="35">
<img src="Gmail%20-%20Fwd:%20Emisi%C3%B3n%20de%20eTicket.vz._files/ag_LAlogo.gif" height="23" width="35">
</td>
<td valign="middle">
<span style="color:#999999;margin-left:10px">Lan</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<span style="font-size:13px;color:#333333;display:block;padding-top:15px">LA
262</span>
</td>
</tr>
</tbody></table>
</td>
<td colspan="2" style="padding:0" valign="top" width="355">
<table border="0" cellpadding="0" cellspacing="0" height="220" width="100%">
<tbody><tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td valign="top" width="160">
<span style="font-size:11px;color:#999999">Sale: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">15/04/2013 22:45</span>
</td>
<td style="font-size:11px;color:#999999" valign="top">De: <span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">Puerto Montt [El Tepual], Chile
(PMC)</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td valign="top" width="160">
<span style="font-size:11px;color:#999999">Llega: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">16/04/2013 00:30</span>
</td>
<td valign="top">
<span style="font-size:11px;color:#999999">A: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">Santiago de Chile [Aeropuerto Comodoro Arturo Merino Benitez], Chile
(SCL)</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Duración: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">01:45:00</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Clase: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">ECONOMY</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Asientos: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">1</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Se permite fumar: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">NO</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Comida: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">N/A</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Código de reserva: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">
4V4LMT</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody>
</table>
</div>
<div style="padding-top:1px">
<table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" height="260" width="600">
<tbody>
<tr height="20">
<td colspan="2">
&nbsp;
</td>
</tr>
<tr>
<td valign="top" width="245">
<table align="right" border="0" cellpadding="0" cellspacing="0" width="240">
<tbody><tr>
<td>
<span style="font-size:16px;color:#003e92;display:block;margin:0;margin-bottom:10px">
Tramo</span>
</td>
</tr>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td width="35">
<img src="Gmail%20-%20Fwd:%20Emisi%C3%B3n%20de%20eTicket.vz._files/ag_LAlogo.gif" height="23" width="35">
</td>
<td valign="middle">
<span style="color:#999999;margin-left:10px">Lan</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<span style="font-size:13px;color:#333333;display:block;padding-top:15px">LA
2634</span>
</td>
</tr>
</tbody></table>
</td>
<td colspan="2" style="padding:0" valign="top" width="355">
<table border="0" cellpadding="0" cellspacing="0" height="220" width="100%">
<tbody><tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td valign="top" width="160">
<span style="font-size:11px;color:#999999">Sale: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">16/04/2013 06:30</span>
</td>
<td style="font-size:11px;color:#999999" valign="top">De: <span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">Santiago de Chile [Aeropuerto Comodoro Arturo Merino Benitez], Chile
(SCL)</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td valign="top" width="160">
<span style="font-size:11px;color:#999999">Llega: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">16/04/2013 09:30</span>
</td>
<td valign="top">
<span style="font-size:11px;color:#999999">A: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">Lima [Aeropuerto Internacional Jorge Chavez], Peru
(LIM)</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Duración: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">03:00:00</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Clase: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">ECONOMY</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Asientos: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">1</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Se permite fumar: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">NO</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Comida: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">N/A</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Código de reserva: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">
4V4LMT</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody>
</table>
</div>
<div style="padding-top:1px">
<table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" height="260" width="600">
<tbody>
<tr height="20">
<td colspan="2">
&nbsp;
</td>
</tr>
<tr>
<td valign="top" width="245">
<table align="right" border="0" cellpadding="0" cellspacing="0" width="240">
<tbody><tr>
<td>
<span style="font-size:16px;color:#003e92;display:block;margin:0;margin-bottom:10px">
Tramo</span>
</td>
</tr>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td width="35">
<img src="Gmail%20-%20Fwd:%20Emisi%C3%B3n%20de%20eTicket.vz._files/ag_LAlogo.gif" height="23" width="35">
</td>
<td valign="middle">
<span style="color:#999999;margin-left:10px">Lan</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<span style="font-size:13px;color:#333333;display:block;padding-top:15px">LA
2564</span>
</td>
</tr>
</tbody></table>
</td>
<td colspan="2" style="padding:0" valign="top" width="355">
<table border="0" cellpadding="0" cellspacing="0" height="220" width="100%">
<tbody><tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td valign="top" width="160">
<span style="font-size:11px;color:#999999">Sale: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">16/04/2013 12:45</span>
</td>
<td style="font-size:11px;color:#999999" valign="top">De: <span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">Lima [Aeropuerto Internacional Jorge Chavez], Peru
(LIM)</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td valign="top" width="160">
<span style="font-size:11px;color:#999999">Llega: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">16/04/2013 17:25</span>
</td>
<td valign="top">
<span style="font-size:11px;color:#999999">A: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">Caracas [Aeropuerto Internacional Simon Bolivar] Caracas, Venezuela
(CCS)</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Duración: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">04:40:00</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Clase: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">ECONOMY</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Asientos: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">1</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Se permite fumar: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">NO</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Comida: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">N/A</span>
</td>
</tr>
<tr>
<td>
<span style="font-size:11px;color:#999999">Código de reserva: </span><span style="font-family:Arial;font-size:13px;color:rgb(51,51,51);text-align:left">
4V4LMT</span>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody>
</table>
</div>
</td>
<td width="20">
&nbsp;
</td>
</tr>
</tbody></table>
</div>
<div style="padding-top:1px"><table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" height="150" width="602"><tbody><tr height="15"><td colspan="3">&nbsp;</td></tr><tr><td style="font-size:16px" valign="top" width="245">
<p style="font-size:16px;color:#003e92;margin:0">Información importante para su viaje:</p></td><td colspan="2" style="margin:0;padding:0" valign="top"><p style="margin:0 0 15px;padding:0">Si debe iniciar el trámite de cupo Cadivi, por favor envíenos la siguiente informacióna la dirección de correo electrónico: <a href="mailto:enviosvz@despegar.com" target="_blank">enviosvz@despegar.com</a><br>
</p><ul style="padding:0;list-style:none outside none;margin:0"><li>- Reserva numero.</li><li>- Si reside en Caracas: Domicilio y punto de referencia.</li><li>- Si reside fuera de Caracas: Dirección y número&nbsp;de Oficina MRW mas cercanaa su domicilio.</li>
<li>- Nombre&nbsp;y contacto telefónico de quien retira el envío.</li></ul><br>UNA
 VEZ RECIBIDA LA INFORMACION VIA CORREO ELECTRONICO LE ENVIAREMOS LO
NECESARIO PARA SU TRAMITE EN UN LAPSO APROXIMADO DE&nbsp;10 DIAS.<p></p><br>
 Tasas aeroportuarias*: Vuelos internacionales Bs.F. 190,00&nbsp;;
Vuelos nacionales&nbsp;Bs.F.38,00. Se abonan al momento del embarque.<br>
<br>Tiempo mínimo para presentarse en el aeropuerto:<br><ul style="padding:0;list-style:none outside none;margin:0"><li>- Internacional : 3 horas antes de su vuelo.</li><li>- Nacionales : 1 hora antes de su vuelo.</li> </ul>
</td></tr></tbody></table></div><div style="padding-top:1px"><table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" height="150" width="602"><tbody><tr height="15"><td colspan="3">&nbsp;</td></tr><tr><td style="font-size:16px" valign="top" width="245">
<p style="font-size:16px;color:#003e92;margin:0">Condiciones de compra</p></td><td colspan="2" style="display:inline-block;margin-top:0"><p style="font-size:16px;margin-top:0pt;color:#333333">No reembolsable, no cancelable, cambios sujetos a políticas y costos de la línea aérea.<br>
<br> </p></td></tr><tr><td colspan="3" style="font-size:16px" valign="top"><p style="font-size:13px;color:#333333;margin:40px 0 30px">El
 pasajero es responsable por cualquier problema que pudiera suscitarse
en el momento del embarque por cuestiones de documentación personal
necesaria para viajar y ajena a despegar.<br>
<br><br> Le deseamos un muy buen viaje!<br><br>Atentamente,<br>Despegar.com<font color="#888888"><br></font></p></td></tr></tbody></table></div></td><td width="20">&nbsp;</td></tr><tr><td colspan="3"><u></u></td></tr></tbody></table></div></div><font color="#888888"><br><br clear="all">
';



$mail->Body =$cuerpo;
$mail->AltBody = "Ventas de eTicket.vz.";


$mail->Send();

// Notificamos al usuario del estado del mensaje

if(!$mail->Send()){
   echo "No se pudo enviar el Mensaje.";
}else{
   echo "Mensaje enviado ";
}

$obj->desconectar($conexion);
fclose($archivo); // cierra el archivo destinos
fclose($archivoError); // cierra el archivo destino
?>
