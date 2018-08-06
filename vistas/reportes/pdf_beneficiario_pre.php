<?php
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/beneficiario.php');
require('../../modelos/zona.php');
require('../../modelos/citas.php');
require('../../modelos/pago.php');

$objBeneficiario = new beneficiario();
$objCitas = new citas();
$objZona= new zona();
$objPago = new pago();

  $rif=$_GET['rif'];
  $nombre=$_GET['nombre'];
  $fec=$_GET['fec'];
  $usuario=$_GET['usuario'];

$listarBeneficiario=$objCitas->listarBeneficiario($rif);
$listarCitas=$objCitas->listarCitasUsuario('',$listarBeneficiario[0],'','','',-1);

$buscarEstados = $objZona->buscarEstados($listarBeneficiario[28]);
$buscarMunicipio = $objZona->buscarMunicipios($listarBeneficiario[29],$listarBeneficiario[28]);
$buscarParroquia = $objZona->buscarParroquias($listarBeneficiario[30],$listarBeneficiario[28],$listarBeneficiario[29]);


if ($listarBeneficiario[33]) $datoslistarBancos=$objPago->listarBancos(4,$listarBeneficiario[33]);


$pdf=new PDF('P','mm','Letter');
$pdf->SetMargins(10,10,10,10);
$nombre='cita_'.$listarBeneficiario[0].'.pdf';
$pdf->AddPage();

$pdf->setY(25);
$pdf->SetFont('Arial','',12);
$pdf->setY(35);
$pdf->SetFont('Arial','',12);
$pdf->Cell(190,5,"Caracas, ".$listarBeneficiario[20],0,0,'R');

$pdf->setY(45);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(0,5,"Registro de Cita ",0,0,'C');

$pdf->setXY(30,65);
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(204,204,204);
$pdf->SetTextColor(0);
$pdf->Cell(160,5,'DATOS DE LA CITA',1,0,'C',true);
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,5,"FECHA DE SOLICITUD",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(25,5,$listarCitas[1],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,5,"FECHA DE LA CITA",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(25,5,$listarCitas[5],1,0,'L');
$pdf->SetFont('Arial','B',8);
if ($listarCitas[4]=='1'){$turno= "MAÑANA" ; }
if ($listarCitas[4]=='2'){$turno= "TARDE" ; }
$pdf->Cell(20,5,"TURNO",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,5,utf8_decode($turno),1,0,'L');

$pdf->setXY(30,75);
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(204,204,204);
$pdf->SetTextColor(0);
$pdf->Cell(160,5,'DATOS PERSONALES',1,0,'C',true);
$pdf->ln(5);
$pdf->setX(30);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5," BANCO:",1,0,'R');
$pdf->SetFont('Arial','',8);
//if ($listarBeneficiario[40]=$listarBancos[0]){
$pdf->Cell(120,5,$datoslistarBancos[1],1,0,'L');
 //}
$pdf->ln(5);
$pdf->setX(30);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"NOMBRE COMPLETO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[8],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->setX(30);
$pdf->Cell(40,5,"C.I./R.I.F :",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[2].$listarBeneficiario[0].$listarBeneficiario[1],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"FECHA DE NAC:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[31],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"SEXO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[26],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"EMAIL:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[32],1,0,'L');



$pdf->ln(10);
$pdf->setX(30);
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(204,204,204);
$pdf->SetTextColor(0);
$pdf->Cell(160,5,'DOMICILIO FISCAL',1,1,'C',true);
$pdf->ln(0);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"CALLE/AV:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[9],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"URB/BARRIO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[10],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"EDIF/CASA:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[11],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"PISO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,5,$listarBeneficiario[12],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,utf8_decode("APTO Nº:"),1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,5,$listarBeneficiario[13],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"CIUDAD:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$buscarEstados[1],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"MUNICIPIO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$buscarMunicipio[1],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"PARROQUIA:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$buscarParroquia[1],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"TELEF 1:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,5,$listarBeneficiario[16],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"TELEF 2:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,5,$listarBeneficiario[17],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
   if ($listarBeneficiario[27]=='7'){$tipo= "OTROS " ; }
   if ($listarBeneficiario[27]=='6'){$tipo= "FUNCIONARIO PUBLICO" ; }
   if ($listarBeneficiario[27]=='5'){$tipo= "PERSONAL MILITAR" ; }
   if ($listarBeneficiario[27]=='4'){$tipo= "EDUCADORES" ; }
   if ($listarBeneficiario[27]=='3'){$tipo= "MEDICOS Y ENFERMERAS" ; }
   if ($listarBeneficiario[27]=='2'){$tipo= "VICTIMA DE ESTAFA" ; }
   if ($listarBeneficiario[27]=='1'){$tipo= "DISCAPACIDAD" ;
   	$carnet=$listarBeneficiario[34]; }
$pdf->setX(30);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"TIPO DE BENEFICIARIO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,5,($tipo),1,0,'L');
if ($carnet){
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"NUMERO DE CONAPDIS:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,5,($carnet),1,0,'L');
}
$pdf->ln(5);

$pdf->setX(30);
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(160,5,"OBSERVACION:  ".$listarBeneficiario[18],1,'J',0);
$pdf->ln(5);
$pdf->setX(30);

$pdf->setX(30);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(160,5,"Observaciones Importantes:",0,'J');
$pdf->ln(1);
$pdf->setX(30);
$pdf->SetFont('Arial','B',9);
$pdf->MultiCell(160,5,utf8_decode("1) Si el número de cédula es registrado de manera errada la cita no procederá. "),0,'J');
$pdf->ln(1);
$pdf->setX(30);
$pdf->SetFont('Arial','B',9);
$pdf->MultiCell(160,5,utf8_decode("2) Debe verificar los datos del registro en su correo, si no llega a la bandeja de entrada por favor revise la carpeta de SPAM o el correo NO deseado."),0,'J');
$pdf->ln(1);
$pdf->setX(30);
$pdf->SetFont('Arial','B',9);
$pdf->MultiCell(160,5,utf8_decode("3) Si usted ya ha sido beneficiado con el programa Comersso-Auto no procederá esta solicitud."),0,'J');
$pdf->ln(1);
$pdf->setX(30);
$pdf->SetFont('Arial','B',9);
$pdf->MultiCell(160,5,utf8_decode("4) Su RIF debe estar vigente de lo contrario no podrá ser procesada su solicitud."),0,'J');
$pdf->ln(1);
$pdf->setX(30);
$pdf->SetFont('Arial','B',9);
$pdf->MultiCell(160,5,utf8_decode("5) Si el día de la cita no tiene los requisitos completos o copia de alguno de estos, la solicitud NO procederá y deberá requerir una nueva cita."),0,'J');
$pdf->ln(1);
$pdf->setX(30);
$pdf->SetFont('Arial','B',9);
$pdf->MultiCell(160,5,utf8_decode("6) Debe traer dos (2) copias de la ficha del registro de cita."),0,'J');
$pdf->ln(1);
$pdf->setX(30);
$pdf->SetFont('Arial','B',9);
$pdf->MultiCell(160,5,utf8_decode("7) La asignación de los vehículos va sujeta a la aprobación del crédito por parte del banco y a la disponibilidad de los mismos."),0,'J');
$pdf->ln(1);
$pdf->Code39(85,250,$listarBeneficiario[0],1,10);
$pdf->Output($nombre,'I');
@pg_close($conexion);
?>