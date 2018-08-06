<?php
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/envios_com.php');
require('../../modelos/fpdf/crearPDF.php');
$pdf=new PDF('p', 'mm','Letter');
$pdf->AddPage();
$objenvios = new envios();

 $iniemp= $_SESSION['iniemp'];
 $numlotveh= $_SESSION['numlotveh'];
 $numenv= $_SESSION['numenv'];
 $nomemp= $_SESSION['nomemp'];
 $numregemp= $_SESSION['numregemp'];
 $fecfincon= $_SESSION['fecfincon'];
 $origen= $_SESSION['origen'];
 $gen= $_SESSION['gen'];
 $tipo= $_SESSION['tipo'];
 $filtro= $_SESSION['filtro'];
 $rifempr= $_SESSION['rifemp'];

 	if ($gen == 'N')
 	{
 		 if (!$tipo)
 		   $listarvehiculos=$objenvios->listarVehTxt($numlotveh,$tipo,'',$origen,'MA');
 		 if ($tipo)
 		   $listarvehiculos=$objenvios->listarVehTxt($numlotveh,$tipo,'',$origen,'ME');
 	}

    else{
    	 if (!$tipo)
           $listarvehiculos=$objenvios->listarVehTxt('',$tipo,$numenv,$origen,'MA');
         if ($tipo)
           $listarvehiculos=$objenvios->listarVehTxt('',$tipo,$numenv,$origen,'ME');
    }


      $pdf->ln();
      $pdf->SetXY(10,25);
      $pdf->SetFont("Arial","",12);
      $pdf->Cell(0,6,'Archivo Txt para Vehiculos ',0,0,"C");
      $pdf->ln();
      if ($origen=='N') $pdf->Cell(0,6,'Nacionales Envio Numero '.$numenv,0,0,"C");
      if ($origen=='I') $pdf->Cell(0,6,'Importados Envio Numero '.$numenv,0,0,"C");

      $pdf->ln();
      $pdf->SetFont('Arial','B',7);
      $pdf->SetXY(10,40);
      $pdf->SetWidths(array(7,15,25,15,103,15,15));
      $anchos = array(7,15,25,15,103,15,15);
      $pdf->SetAligns(array("C","C","C","C","C","C"));
      $pdf->SetBorder(1);
      $cabecera = array("N#","Certifi.","Serial Car.","Rif","Beneficiario","Fact.","Fec/F.");
      $pdf->SetBorder(0);
      $pdf->SetAligns(array("L","L","L","L","L","L","L"));
      $pdf->cabecera($cabecera,$anchos);
      $pdf->ln();


      $cont=0;
      $ma=0;
      $mm=0;
      $me=0;
      for($i=0;$i<count($listarvehiculos);$i+=19){
      $con++;
      if ($listarvehiculos[$i+18]=='MA') $ma++;
      if ($listarvehiculos[$i+18]=='MM') $mm++;
      if ($listarvehiculos[$i+18]=='ME') $me++;
      $pdf->setjump(2);
      $pdf->SetFont('Arial','',5.5);
      $pdf->Row(array($listarvehiculos[$i+18].'-'.$con.'',$listarvehiculos[$i+0],$listarvehiculos[$i+2],$listarvehiculos[$i+3],$listarvehiculos[$i+4],$listarvehiculos[$i+6],$listarvehiculos[$i+7]));
      $pdf->setjump(2);
      $pdf->SetFont('Arial','',5.5);
      if ($pdf->gety()>245){
	  $pdf->addpage();
      $pdf->ln();
      $pdf->SetXY(10,25);
      $pdf->SetFont("Arial","",7);
      $pdf->Cell(0,6,'Archivo Txt para Vehiculos ',0,0,"C");
      $pdf->ln();
      if ($origen=='P') $pdf->Cell(0,6,'Programa Venezuela Movil',0,0,"C");
      if ($origen=='N') $pdf->Cell(0,6,'Nacionales',0,0,"C");
      if ($origen=='E') $pdf->Cell(0,6,'Exportados',0,0,"C");
      if ($origen=='I') $pdf->Cell(0,6,'Importados',0,0,"C");
      if ($origen=='C') $pdf->Cell(0,6,'Carrozados',0,0,"C");
      $pdf->ln();
      $pdf->SetFont('Arial','B',7);
      $pdf->SetXY(10,40);
      $pdf->SetWidths(array(7,15,25,15,103,15,15));
      $anchos = array(7,15,25,15,103,15,15);
      $pdf->SetAligns(array("C","C","C","C","C","C"));
      $pdf->SetBorder(1);
      $cabecera = array("N#","Certifi.","Serial Car.","Rif","Beneficiario","Fact.","Fec/F.");

      $pdf->SetBorder(0);
      $pdf->SetAligns(array("L","L","L","L","L","L","L"));
      $pdf->cabecera($cabecera,$anchos);
      $pdf->ln();
      $pdf->SetFont('Arial','',8);
	}
      }

      $pdf->Line(10,$pdf->GetY(),205,$pdf->GetY());//LINEA HORIZONTAL
      $pdf->ln(3);
      $pdf->Cell(0,3,'Cantidad de registros tipo MA: '.$ma,0,0,"L");
      $pdf->ln();
      $pdf->Cell(0,3,'Cantidad de registros tipo MM: '.$mm,0,0,"L");
      $pdf->ln();
      $pdf->Cell(0,3,'Cantidad de registros tipo ME: '.$me,0,0,"L");
      $pdf->ln();
      $host = $_SERVER["HTTP_HOST"];
      $aux = explode('/',$_SERVER["REQUEST_URI"]);
      $uri='';
      for ($i=0;$i<count($aux)-1;$i++)
      $uri = $uri.$aux[$i]."/";
      $pag="txt_txt_com.php";
      $dir='http://'.$host.$uri.$pag;

      if ($gen=='S'){
       $objenvios->registrarEnvios($numenv,$origen,$ma,$mm,$me);
       $pdf->PutLink(trim($dir).'?iniemp='.$iniemp.'&numlotveh='.$numlotveh.'&numenv='.$numenv.'&nomemp='.$nomemp.'&numregemp='.$numregemp.'&fecfincon='.$fecfincon.'&origen='.$origen.'&filtro='.$filtro.'&tipo1='.$tipo.'&rifemp='.$rifempr,'Descargar TXT');
      }



$pdf->Output();
?>
