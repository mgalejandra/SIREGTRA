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
$mail->From = "tecnologia.facturacion@suvinca.gob.ve";
$mail->FromName = "Tecnologia Facturar";
$mail->Subject ="Facturar Vehiculos ".$today.' - '.$hora;
$mail->AddAddress("tesoreria@suvinca.gob.ve","Administracion y Servicios");
$mail->AddAddress("i.diaz@suvinca.gob.ve","Ibrahim Diaz");
$mail->AddAddress("b.requena@suvinca.gob.ve","Belkis Requena");
$mail->AddAddress("j.velez@suvinca.gob.ve","Jennifer Velez");
$mail->AddAddress("t.leal@suvinca.gob.ve","Thania Leal");
$mail->AddAddress("a.florido@suvinca.gob.ve","Ada Florido");
$mail->AddAddress("n.reina@suvinca.gob.ve","Nelvy Yaneth Reina Romero");
$mail->AddAddress("eddiebetancourt@yahoo.com","Eddie Betancourt");
//$mail->AddAddress("y.cabrera@suvinca.gob.ve","Yolexi Cabrera");
//$mail->AddAddress("p.mateus@suvinca.gob.ve","Peter Mateus");
$mail->AddAddress("m.arrieta@suvinca.gob.ve","Maryelys Arrieta");
$mail->AddAddress("d.leca@suvinca.gob.ve","Diana Leca");
$mail->AddAddress("m.pedraza@suvinca.gob.ve","Marycarmen Pedraza");
$mail->AddAddress("m.ponce@suvinca.gob.ve","Maiviery Ponce");
$mail->AddAddress("y.mata@suvinca.gob.ve","Yaritza Mata");
$mail->AddAddress("k.sosa@suvinca.gob.ve","Katiuska Sosa");
$mail->AddAddress("k.urgelles@suvinca.gob.ve"," Karelys Urgelles");
$mail->AddAddress("r.izquierdo@suvinca.gob.ve","Rafael Izquierdo");
$mail->AddAddress("d.marquez@suvinca.gob.ve","Digna Marquez");

$mail->WordWrap = 50;

		   $cuerpo = '<html><head>
			<title>	digna </title>
			</head>
			<body>
            <table border="1">
			 <tr>
			  <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="18"><font color="#FFFFFF"> LISTA DE VEHICULOS PARA SU FACTURACION DEL DIA '.$today.' HORA: '.$hora.'</font></td>
			</tr>
			<tr>
			          <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">N# Factura</font></td>
					  <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">Id Asig</font></td>
					  <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">Serial</td>
					  <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Fecha de Factura</font></td>
					  <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Condicion Pago</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">RIF</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Nombre</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Usuario</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="250"><font color="#FFFFFF">Fecha de Estatus Factura</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">Banco</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">Estatus</font></td>
					  <td ALIGN="center" bgcolor="8C0000" width="80"><font color="#FFFFFF">Marca</td>
					  <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Modelo</font></td>
					  <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Serie</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="200"><font color="#FFFFFF">lote</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="150"><font color="#FFFFFF">Placa</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="100"><font color="#FFFFFF">Tipo Beneficiario</font></td>
				      <td ALIGN="center" bgcolor="8C0000" width="250"><font color="#FFFFFF">Color</font></td>
			  </tr>';


		$sql="
				select
				a.id_numfac, a.id_asignacion , b.sercarveh ,to_char(a.fecfac,'dd/mm/yyyy') , a.condpago ,
				b.codpro,c.nomcomp, a.usuario_estatus, a.fecha_estatus, d.banco_descrip, e.descripcion,
				k.desmar,l.desmod,m.desserie,j.numlotveh,h.numplaveh,r.descripcion as tipo_benef, p.descol
				from
				asignacion  b, vehiculo i
				left outer join placas h  on h.sercarveh=i.sercarveh,caracteristica j
				left outer join marcas k on k.codmar=j.codmarveh
				left outer join modelo l  on l.codmod=j.codmod
				left outer join serie m  on m.codserie=j.codserie,
				propietarios c
				left outer join tipo_benef r on r.codtipben=c.tipo
				left outer join zona_estado f on f.codest=c.codest
				left outer join sexo g on g.codsexo=c.sexo,
				facturaprof a
				left outer join banco d on d.id_banco=a.id_banco
				left outer join estatus e on e.id_estatus=a.id_estatus
				left outer join certificados o on o.id_asignacion=a.id_asignacion AND o.estatus='A',
				lote n,color p where
				j.numlotveh=n.numlot and
				i.id_caract=j.id_caract and
				b.sercarveh=i.sercarveh and
				a.estatus='A' and i.estatus='A' and
				a.id_asignacion=b.id_asignacion and
				b.codpro=c.codpro
				and p.codcol=i.col1veh and
				(a.id_estatus='6' AND (a.condpago='CREDITO' OR a.condpago='CONTADO') OR ( a.id_estatus='1' AND a.condpago='COMPLETO'))
				AND  (b.sercarveh <> '0' and b.sercarveh <> '1' and b.sercarveh <> '2'  and b.sercarveh <> '3'  ) and envio_fact='P'
				order by a.fecfac , a.id_numfac desc ";
        $buscar = $obj->consultar($conexion,$sql);
        $VectorBuscar = $obj->ret_vector($buscar);
//       echo count($VectorBuscar);
       $cont=0;
       for($i=0;$i<count($VectorBuscar);$i+=18){
        $sqlAct="update facturaprof set envio_fact='A', fecha_envio_fact='$today' where id_numfac=$VectorBuscar[$i] ";
       // print $sqlAct;
        $Act = $obj->consultar($conexion,$sqlAct);
        if($Act){
            $cont++;
            $cuerpoDet=$cuerpoDet.'<tr>
            		  <td >'.$VectorBuscar[$i].'</td>
					  <td >'.$VectorBuscar[$i+1].'</td>
					  <td >'.$VectorBuscar[$i+2].'</td>
					  <td >'.$VectorBuscar[$i+3].'</td>
					  <td >'.$VectorBuscar[$i+4].'</td>
				      <td >'.$VectorBuscar[$i+5].'</td>
				      <td >'.$VectorBuscar[$i+6].'</td>
				      <td >'.$VectorBuscar[$i+7].'</td>
				      <td >'.$VectorBuscar[$i+8].'</td>
				      <td >'.$VectorBuscar[$i+9].'</td>
				      <td >'.$VectorBuscar[$i+10].'</td>
					  <td >'.$VectorBuscar[$i+11].'</td>
					  <td >'.$VectorBuscar[$i+12].'</td>
					  <td >'.$VectorBuscar[$i+13].'</td>
				      <td >'.$VectorBuscar[$i+14].'</td>
				      <td >'.$VectorBuscar[$i+15].'</td>
				      <td >'.$VectorBuscar[$i+16].'</td>
				      <td >'.$VectorBuscar[$i+17].'</td>
			         </tr>';
       	fwrite($archivo,$cont.' - '.$VectorBuscar[$i].' - '.$VectorBuscar[$i+1].' - '.$VectorBuscar[$i+2].' - '.$VectorBuscar[$i+5].' - '.$VectorBuscar[$i+6]."\n");
        }else
        {
        	if($ban==0)
        	$archivoError = fopen($rutaArc.'ERROR'.$termR.".txt",'w+');
        	fwrite($archivoError,$cont.' - '.$VectorBuscar[$i].' - '.$VectorBuscar[$i+1].' - '.$VectorBuscar[$i+2].' - '.$VectorBuscar[$i+5].' - '.$VectorBuscar[$i+6]."\n");
        	$ban=1;
        }

       }
       $cuerpo=$cuerpo.$cuerpoDet.
               '<tr>
			     <td ALIGN="center" bgcolor="8C0000" width="1300" colspan="18"><font color="#FFFFFF">TOTAL: '.$cont.'</font></td>
			    </tr>
			    </table>
			    </body>
			    </html>';

$mail->Body =$cuerpo;
$mail->AltBody = "Listado de vehiculos enviados a facturar Automaticamente desde el Sistema SIRECOV";

if (count($VectorBuscar)>0)
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
