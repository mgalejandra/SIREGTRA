<?php
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/fpdf/creaPDF.php');
require('../../modelos/reclamos.php');
require('../../modelos/beneficiario.php');
require('../../modelos/zona.php');
require('../../modelos/factura.php');

$objBeneficiario=new beneficiario();
$objReclamo= new reclamos();
$objFactura = new factura();
$objZona= new zona();

$regReclamo=$_GET['id'];
$cedula=$_GET['cedula'];
$tramite=$_GET['tramite'];

if($cedula){

	$listarFactura=$objFactura->reporteFactura('','',$cedula);

}

if ($listarFactura){
	$detalleVehiculo=$objFactura->detalleVehiculo($listarFactura[9]);
}



$reclamo=$objReclamo->buscarReclamo($regReclamo);
$reclamodet=$objReclamo->buscarReclamoDet($regReclamo);

$buscarEstados = $objZona->buscarEstados($listarFactura[25]);
$buscarMunicipio = $objZona->buscarMunicipios($listarFactura[26],$listarFactura[25]);
$buscarParroquia = $objZona->buscarParroquias($listarFactura[27],$listarFactura[25],$listarFactura[26]);


$pdf=new PDF('P','mm','Letter');
$pdf->SetMargins(10,10,10,10);
$nombre='reclamo_'.$listarTipoR[0].'.pdf';
$pdf->AddPage();

$pdf->setY(20);
$pdf->SetFont('Arial','',12);
$pdf->setY(20);
$pdf->SetFont('Arial','',12);
$pdf->Cell(190,5,"Caracas, ".$listarTipoR[6],0,0,'R');

$pdf->setY(25);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,5,utf8_decode("Atención al Público"),0,0,'C');

$pdf->setXY(20,39);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,"Estatus:",1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$reclamo[3],1,0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,"Numero de Ticke:",1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,str_pad($reclamo[0],5,'0',STR_PAD_LEFT),1,0,'L');

$pdf->setXY(20,45);
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(204,204,204);
$pdf->SetTextColor(0);
$pdf->Cell(170,6,'DATOS PERSONALES',1,0,'C',true);
$pdf->ln(6);
$pdf->setX(20);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,"Nombre Completo:",1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(125,6,$listarFactura[12],1,0,'L');
$pdf->ln(6);
$pdf->setX(30);
$pdf->SetFont('Arial','B',12);
$pdf->setX(20);
$pdf->Cell(45,6,"C.I.:",1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(125,6,$listarFactura[13],1,0,'L');


$pdf->setXY(20,63);
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(204,204,204);
$pdf->SetTextColor(0);
$pdf->Cell(170,6,'Direccion',1,0,'C',true);
$pdf->ln(6);
$pdf->setX(20);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("Calle/avenida:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(125,6,$listarFactura[14],1,0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->ln(6);
$pdf->setX(20);
$pdf->Cell(45,6,utf8_decode("Urb. o Barrio:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(125,6,$listarFactura[15],1,0,'L');

$pdf->ln(6);
$pdf->setX(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("Edificio/casa/quinta:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$listarFactura[16],1,0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("Numero de piso:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$listarFactura[17],1,0,'L');

$pdf->ln(6);
$pdf->setX(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("N° de Apartamento:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$listarFactura[18],1,0,'L');

$pdf->ln(6);
$pdf->setX(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("Estado:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$buscarEstados[1],1,0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("Municipio:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$buscarMunicipio[1],1,0,'L');

$pdf->ln(6);
$pdf->setX(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("Parroquia:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$buscarParroquia[1],1,0,'L');

$pdf->ln(6);
$pdf->setX(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("Tlf/Celular 1:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$listarFactura[21],1,0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("Tlf/celular 2:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$listarFactura[22],1,0,'L');

$pdf->setXY(20,111);
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(204,204,204);
$pdf->SetTextColor(0);
$pdf->Cell(170,6,'Datos del Vehiculo',1,0,'C',true);
$pdf->ln(6);
$pdf->setX(20);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("MARCA:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[5],1,0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("MODELO:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[6],1,0,'L');

$pdf->ln(6);
$pdf->setX(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("SERIE/VERSION:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[7],1,0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("PLACA:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[1],1,0,'L');

$pdf->ln(6);
$pdf->setX(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("AÑO DE FAB.:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[8],1,0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("AÑO DE MODELO:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[9],1,0,'L');

$pdf->ln(6);
$pdf->setX(20);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(45,6,utf8_decode("SER.CARROCERIA:"),1,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,$detalleVehiculo[2],1,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(45,6,utf8_decode("SER.MOTOR:"),1,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,6,$detalleVehiculo[10],1,0,'L');

$pdf->ln(6);
$pdf->setX(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("COLOR(ES):"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[12].' '.$detalleVehiculo[13],1,0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("CLASE:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[14],1,0,'L');

$pdf->ln(6);
$pdf->setX(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("TIPO:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[15],1,0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("USO:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[16],1,0,'L');

$pdf->ln(6);
$pdf->setX(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("N° DE PUESTOS:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[17],1,0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("N° DE EJES:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[18],1,0,'L');

$pdf->ln(6);
$pdf->setX(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("PESO (TARA):"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[19],1,0,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("CAP DE CARGA:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[20],1,0,'L');

$pdf->ln(6);
$pdf->setX(20);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,utf8_decode("TIPO COMBUST:"),1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,6,$detalleVehiculo[11],1,0,'L');

$pdf->setXY(20,171);
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(204,204,204);
$pdf->SetTextColor(0);
$pdf->Cell(170,6,'Datos del Reclamo',1,0,'C',true);
$pdf->ln(6);
$pdf->setX(20);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,6,"Tipo de Tramite:",1,0,'R');
$pdf->SetFont('Arial','',12);
$pdf->Cell(125,6,utf8_decode($reclamo[2]),1,0,'L');


if ($tramite==1){
	$cant=count($reclamodet)/4;
	if ($cant==2){
		$pdf->ln(6);
		$pdf->setX(20);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(45,6,utf8_decode("Copia de:"),1,0,'R');
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(60,6,$reclamodet[3],1,0,'L');
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(65,6,$reclamodet[7],1,0,'L');
	}else{
		$pdf->ln(6);
		$pdf->setX(20);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(45,6,utf8_decode("Copia de:"),1,0,'R');
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(125,6,$reclamodet[3],1,0,'L');
	}
}

if ($tramite==2){
		$pdf->ln(6);
		$pdf->SetFont('Arial','B',12);
		$pdf->setX(20);
	    $cabecera_ = array('Campo','Descripcion');
		$anch_ = array(85,85);
		$alin_ = array('C','C');
		$pdf->cabecera($cabecera_,$anch_);
		$cant=count($reclamodet)/4;

		$pdf->setX(20);

		$pdf->SetFont('Arial','',12);
		$pdf->SetWidths($anch_);
		$pdf->SetAligns($alin_);
		$pdf->SetBorder(true);
		$j=0;
		for($i = 0; $i < $cant; $i++) {
		$j++;
		$pdf->Row(array($reclamodet[$i*4+3]
			            ,$reclamodet[$i*4+2]));

		$pdf->setX(20);
		}
}

if ($tramite==3){ $envio=$objFactura->envio($listarFactura[9]);
	$pdf->ln(6);
	$pdf->setX(20);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(45,6,utf8_decode("Estatus de Envio:"),1,0,'R');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(120,6,utf8_decode('DATOS ENVIADOS AL INTT N° DE ENVIO ').$envio[1].utf8_decode(' EN FECHA ').$envio[0],1,0,'L');
	$pdf->ln(6);
	$pdf->setX(20);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(45,6,utf8_decode("Problemas Reg Vehiculo:"),1,0,'R');
	$pdf->SetFont('Arial','',12);
	$pdf->multicell(120,6,utf8_decode($reclamodet[2]));
}

if ($tramite==4){ $entrega=$objFactura->entrega($listarFactura[9]);
	$pdf->ln(6);
	$pdf->setX(20);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(45,6,utf8_decode("Fecha de Factura:"),1,0,'R');
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(40,6,$entrega[3],1,0,'L');
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(45,6,utf8_decode("Fecha de Entrega:"),1,0,'R');
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(40,6,$entrega[0],1,0,'L');

	$pdf->ln(6);
	$pdf->setX(20);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(45,6,utf8_decode("Lugar:"),1,0,'R');
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(40,6,$entrega[1],1,0,'L');
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(45,6,utf8_decode("Acto:"),1,0,'R');
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(40,6,$entrega[2],1,0,'L');

	$pdf->ln(6);
	$pdf->setX(20);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(45,6,utf8_decode("Kilometraje:"),1,0,'R');
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(40,6,$reclamodet[1],1,0,'L');

	$pdf->ln(6);
	$pdf->setX(20);
	$cabecera_ = array('Tipo de Falla','Observaciones');
	$anch_ = array(85,85);
	$alin_ = array('C','C');
	$pdf->cabecera($cabecera_,$anch_);
	$pdf->SetFont('Arial','',12);
	$pdf->SetWidths($anch_);
	$pdf->SetAligns($alin_);
	$pdf->SetBorder(true);

	$pdf->setX(20);
	$pdf->SetFont('Arial','',12);
	$pdf->SetWidths($anch_);
	$pdf->SetAligns($alin_);
	$pdf->SetBorder(true);
	$j=0;
	$cant=count($reclamodet)/4;
	for($i = 0; $i < $cant; $i++) {
	$j++;
	$pdf->Row(array($reclamodet[$i*4+3]
		            ,$reclamodet[$i*4+2]));

	$pdf->setX(20);
	}

}



$pdf->Output($nombre,'I');
@pg_close($conexion);
?>