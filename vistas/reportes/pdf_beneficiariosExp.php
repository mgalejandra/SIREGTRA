<?php
session_start();
//$connection = parse_ini_file('../../config.ini', true);
require('../../modelos/conexion.php');
 
require('../../controlador/funciones.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/beneficiario.php');
require('../../modelos/zona.php');
require('../../modelos/pago.php');

$objBeneficiario = new beneficiario();
$objPago 		= new pago();

//$listarBancos=$objPago->listarBancos(3);

  $rif=$_GET['rif'];
  $nombre=$_GET['nombre'];
  $banco=$_GET['banco'];
  $fec=$_GET['fec'];
  $fec2=$_GET['fec2'];
$listarBeneficiario=$objBeneficiario->listarBeneficiario($rif,$nombre,$banco,$fec,$fec2);

$objZona= new zona();
$buscarEstados = $objZona->buscarEstados($listarBeneficiario[36]);
$buscarMunicipio = $objZona->buscarMunicipios($listarBeneficiario[37],$listarBeneficiario[36]);
$buscarParroquia = $objZona->buscarParroquias($listarBeneficiario[38],$listarBeneficiario[36],$listarBeneficiario[37]);

if ($listarBeneficiario[$i+40]) $datoslistarBancos=$objPago->listarBancos(4,$listarBeneficiario[$i+40]);
$pdf=new PDF('p', 'mm','Letter');
$pdf->SetMargins(10,10,10,10);
//$titulo=utf8_decode('');
//$pdf->SetTitle($titulo);
$pdf->AddPage();

$pdf->setY(35);
$pdf->SetFont('Arial','',12);
$pdf->Cell(190,5,"Caracas, ".$listarBeneficiario[18],0,0,'R');

$pdf->setY(45);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,5,"FICHA DEL ORDENANTE",0,0,'C');

$pdf->setXY(30,65);
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(204,204,204);
$pdf->SetTextColor(0);
$pdf->Cell(170,5,'Datos del Ordenante',1,0,'C',true);
$pdf->ln(5);
$pdf->setX(30);

 //}
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,"Nombre/ Razon Social:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[1],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);




$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,"Numero de Cuenta Ordenante:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[3],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);

$pdf->SetFont('Arial','B',8);
$pdf->setX(30);
$pdf->Cell(50,5,"C.I./R.I.F :",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[0],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,"FECHA DEL OFICIO.:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[39],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,"TIPO DE CUENTA:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[34],1,0,'L');
$pdf->ln(5);$pdf->ln(5);$pdf->ln(5);

$pdf->ln(10);
$pdf->setX(30);
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(204,204,204);
$pdf->SetTextColor(0);
$pdf->Cell(170,5,'Datos del Beneficiario',1,1,'C',true);
$pdf->ln(0);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,"Numero de Cuenta Beneficiario:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[7],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,"Monto de la Transferencia:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[8],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,"Nro Doc/Referencia:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[9],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,"Fecha de Ejecucion:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$listarBeneficiario[10],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,"Banco:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$buscarEstados[1],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,"Estatus:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$buscarMunicipio[1],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,"Sucursal:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,$buscarParroquia[1],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,"TELEF 1:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,5,$listarBeneficiario[14],1,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,"TELEF 2:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,5,$listarBeneficiario[15],1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
   if ($listarBeneficiario[35]=='7'){$tipo= "OTROS " ; }
   if ($listarBeneficiario[35]=='3'){$tipo= "EMPLEADO" ; }
   if ($listarBeneficiario[35]=='2'){$tipo= "NO CLIENTE" ; }
   if ($listarBeneficiario[35]=='1'){$tipo= "CLIENTE" ; }
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,"TIPO DE BENEFICIARIO:",1,0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(120,5,($tipo),1,0,'L');
$pdf->ln(5);
$pdf->setX(30);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(170,5,'   OBSERVACION:',1,0,'L');
$pdf->ln();
$pdf->SetFont('Arial','',8);
$pdf->setX(30);
$pdf->MultiCell(170,5,$listarBeneficiario[16],1,'J',0);

$pdf->Output();
 @pg_close($conexion);
?>