<?php
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/envios_com.php');
require('../../modelos/fpdf/crearPDF.php');
$pdf=new PDF('L', 'mm','Letter');
$pdf->AddPage();
$objenvios = new envios();
//$_SESSION['numenv']=7;
 $iniemp= $_SESSION['iniemp'];
 $rifemp=$_SESSION['rifemp'];
 $numlotveh= $_SESSION['numlotveh'];
 $numenv= $_SESSION['numenv'];
 $nomemp= $_SESSION['nomemp'];
 $numregemp=  $_SESSION['numregemp'];
 $fecfincon= $_SESSION['fecfincon'];
 $origen= $_SESSION['origen'];
 $gen= $_SESSION['gen'];
 $tipo= $_SESSION['tipo'];
 $filtro= $_SESSION['filtro'];

 	if ($gen == 'N')
        $listarvehiculos=$objenvios->listarPlaTxt($numlotveh,$tipo,'','');
    else
        $listarvehiculos=$objenvios->listarPlaTxt('',$tipo,$numenv,'');

      $pdf->ln();
      $pdf->SetXY(10,30);
      $pdf->SetFont("Arial","",12);
      $pdf->Cell(0,6,'Archivo Txt para Placas Nro: '.$numenv.'',0,0,"C");
      $pdf->ln();
      if ($origen=='N') $pdf->Cell(0,6,'Nacionales',0,0,"C");
      if ($origen=='I') $pdf->Cell(0,6,'Importados',0,0,"C");

      $pdf->ln();
      $pdf->SetFont('Arial','B',12);
      $pdf->SetXY(10,40);
      $pdf->SetWidths(array(20,70,20,40,30,20,30,10,20));
      $anchos = array(20,70,20,40,30,20,30,10,20);
      $pdf->SetAligns(array("C","C","C","C","C","C","C"));
      $pdf->SetBorder(1);
      $cabecera = array("Rif","Beneficiario","Placa","Estado","Rafaga","Certificado","Serial Car.","Fac.","Modelo");
      $pdf->SetBorder(0);
      $pdf->SetAligns(array("L","L","L","L","L","C","L","L"));
      $pdf->cabecera($cabecera,$anchos);
      $pdf->ln();
      $pdf->SetFont('Arial','',8);

      $cont=0;
      $ma=0;
      $mm=0;
      $me=0;
      for($i=0;$i<count($listarvehiculos);$i+=23){
      $con++;
      $pdf->setjump(1.5);
      $pdf->SetFont('Arial','',5.5);
      $pdf->Row(array($listarvehiculos[$i+3],$listarvehiculos[$i+4],$listarvehiculos[$i+19],$listarvehiculos[$i+20],$listarvehiculos[$i+22],$listarvehiculos[$i+0],$listarvehiculos[$i+2],$listarvehiculos[$i+6],$listarvehiculos[$i+21]));
       $pdf->setjump(1.5);
      $pdf->SetFont('Arial','',5.5);
      if ($pdf->gety()>180){
	  $pdf->addpage();
      $pdf->ln();
      $pdf->SetXY(10,30);
      $pdf->SetFont("Arial","",12);
      $pdf->Cell(0,6,'Archivo Txt para Placas Nro: '.$numenv.'',0,0,"C");
      $pdf->ln();
      if ($origen=='P') $pdf->Cell(0,6,'Programa Venezuela Movil',0,0,"C");
      if ($origen=='N') $pdf->Cell(0,6,'Nacionales',0,0,"C");
      if ($origen=='E') $pdf->Cell(0,6,'Exportados',0,0,"C");
      if ($origen=='I') $pdf->Cell(0,6,'Importados',0,0,"C");
      if ($origen=='C') $pdf->Cell(0,6,'Carrozados',0,0,"C");
      $pdf->ln();
       $pdf->SetFont('Arial','B',12);
      $pdf->SetXY(10,40);
      $pdf->SetWidths(array(20,70,20,40,30,20,30,10,20));
      $anchos = array(20,70,20,40,30,20,30,10,20);
      $pdf->SetAligns(array("C","C","C","C","C","C","C"));
      $pdf->SetBorder(1);
      $cabecera = array("Rif","Beneficiario","Placa","Estado","Rafaga","Certificado","Serial Car.","Factura","Modelo");
      $pdf->SetBorder(0);
         $pdf->SetAligns(array("L","L","L","L","L","C","L","L"));
      $pdf->cabecera($cabecera,$anchos);
      $pdf->ln();
      $pdf->SetFont('Arial','',8);
	}
      }

    //  $pdf->Line(10,$pdf->GetY()+5,205,$pdf->GetY()+5);//LINEA HORIZONTAL
      $pdf->ln();
      $pdf->Cell(0,6,'Cantidad de registros Placas: '.$con,0,0,"L");

      $host = $_SERVER["HTTP_HOST"];
      $aux = explode('/',$_SERVER["REQUEST_URI"]);
      $uri='';
      for ($i=0;$i<count($aux)-1;$i++)
      $uri = $uri.$aux[$i]."/";
      $pag="txt_pla_com.php";
      $dir='http://'.$host.$uri.$pag;

      if ($gen=='S'){
       $objenvios->registrarEnvios($numenv,'P',$con,0,0);
        $pdf->PutLink(trim($dir).'?numlotveh='.$numlotveh.'&numenv='.$numenv.'&filtro='.$filtro.'&fecdes='.$_POST["fecdes"].'&fechas='.$_POST["fechas"],'Descargar TXT');
      }



$pdf->Output();
?>
