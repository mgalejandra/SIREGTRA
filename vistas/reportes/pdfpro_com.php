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
 	{
 		 if (!$tipo)
 		   $listarvehiculos=$objenvios->listarProTxt($numlotveh,$tipo,'',$origen,'MA');
 		 if ($tipo)
 		   $listarvehiculos=$objenvios->listarProTxt($numlotveh,$tipo,'',$origen,'ME');
 	}
    else
    {
    	 if (!$tipo)
           $listarvehiculos=$objenvios->listarProTxt('',$tipo,$numenv,$origen,'MA');
         if ($tipo)
           $listarvehiculos=$objenvios->listarProTxt('',$tipo,$numenv,$origen,'ME');
    }


      $pdf->ln();
      $pdf->SetXY(10,30);
      $pdf->SetFont("Arial","",12);
      $pdf->Cell(0,6,'Archivo Txt para Propietarios Nro: '.$numenv ,0,0,"C");
      $pdf->ln();
      if ($origen=='N') $pdf->Cell(0,6,'Nacionales',0,0,"C");
      if ($origen=='I') $pdf->Cell(0,6,'Importados',0,0,"C");

      $pdf->ln();
      $pdf->SetFont('Arial','B',7);
      $pdf->SetXY(10,40);
      $pdf->SetWidths(array(10,20,55,65,20,15,35,15,25));
      $anchos = array(10,20,55,65,20,15,35,15,25);
      $pdf->SetAligns(array("C","C","C","C","C","C","C"));
      $pdf->SetBorder(1);
      $cabecera = array("Nro","Rif","Beneficiario","Dirección","Tlf","Cert.","Serial Car.","Factura","Modelo");
      $pdf->SetBorder(0);
      $pdf->SetAligns(array("L","L","L","L","L","L","L"));
      $pdf->cabecera($cabecera,$anchos);
      $pdf->ln();
      $pdf->SetFont('Arial','',6);

      $cont=0;
      $ma=0;
      $mm=0;
      $me=0;
      for($i=0;$i<count($listarvehiculos);$i+=22){
      $con++;
      if ($listarvehiculos[$i+18]=='MA') $ma++;
      if ($listarvehiculos[$i+18]=='MM') $mm++;
      if ($listarvehiculos[$i+18]=='ME') $me++;
          $pdf->setjump(2);
      $pdf->Row(array($listarvehiculos[$i+18].'-'.$con,$listarvehiculos[$i+3],$listarvehiculos[$i+4],$listarvehiculos[$i+19],$listarvehiculos[$i+20],$listarvehiculos[$i+0],$listarvehiculos[$i+2],$listarvehiculos[$i+6],$listarvehiculos[$i+21]));
          $pdf->setjump(2);
      if ($pdf->gety()>180){
	  $pdf->addpage();
      $pdf->ln();
      $pdf->SetXY(10,30);
      $pdf->SetFont("Arial","",12);
      $pdf->Cell(0,6,'Archivo Txt para Propietarios Nro:'.$numenv ,0,0,"C");
      $pdf->ln();
      if ($origen=='P') $pdf->Cell(0,6,'Programa Venezuela Movil',0,0,"C");
      if ($origen=='N') $pdf->Cell(0,6,'Nacionales',0,0,"C");
      if ($origen=='E') $pdf->Cell(0,6,'Exportados',0,0,"C");
      if ($origen=='I') $pdf->Cell(0,6,'Importados',0,0,"C");
      if ($origen=='C') $pdf->Cell(0,6,'Carrozados',0,0,"C");
      $pdf->ln();
      $pdf->SetFont('Arial','B',7);
      $pdf->SetXY(10,40);
      $pdf->SetWidths(array(10,20,55,65,20,15,35,15,25));
      $anchos = array(10,20,55,65,20,15,35,15,25);
      $pdf->SetAligns(array("C","C","C","C","C","C","C"));
      $pdf->SetBorder(1);
      $cabecera = array("Nro","Rif","Beneficiario","Dirección","Tlf","Cert.","Serial Car.","Factura","Modelo");
      $pdf->SetBorder(0);
      $pdf->SetAligns(array("L","L","L","L","L","L","L"));
      $pdf->cabecera($cabecera,$anchos);
      $pdf->ln();
      $pdf->SetFont('Arial','',6);
	}
      }

    //  $pdf->Line(10,$pdf->GetY()+5,205,$pdf->GetY()+5);//LINEA HORIZONTAL
      $pdf->ln();
      $pdf->Cell(0,6,'Cantidad de registros tipo MA: '.$ma,0,0,"L");
      $pdf->ln();
      $pdf->Cell(0,6,'Cantidad de registros tipo MM: '.$mm,0,0,"L");
      $pdf->ln();
      $pdf->Cell(0,6,'Cantidad de registros tipo ME: '.$me,0,0,"L");
      $pdf->ln();
      $host = $_SERVER["HTTP_HOST"];
      $aux = explode('/',$_SERVER["REQUEST_URI"]);
      $uri='';
      for ($i=0;$i<count($aux)-1;$i++)
      $uri = $uri.$aux[$i]."/";
      $pag="txt_pro_com.php";
      $dir='http://'.$host.$uri.$pag;

      if ($gen=='S'){
       $objenvios->registrarEnvios($numenv,'B',$ma,$mm,$me);
       $pdf->PutLink(trim($dir).'?rifemp2='.$rifemp2.'&rifemp='.$rifemp.'&numlotveh='.$_POST["numlotveh"].'&numenv='.$numenv.'&nomemp='.$_POST["nomemp"].'&numregemp='.$_POST["numregemp"].'&fecfincon='.$_POST["fecfincon"].'&origen='.$_POST["origen"].'&filtro='.$_POST["filtro"].'&fecdes='.$_POST["fecdes"].'&fechas='.$_POST["fechas"].'&tipo='.$tipo,'Descargar TXT');
      }
$pdf->Output();
?>
