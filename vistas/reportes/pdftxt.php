<?php
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/envios.php');
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
 $precioj= $_SESSION['precioj'];
 $rifcons="G200079843";

 	if ($gen == 'N')
 	{
 		 if (!$tipo)							
 		   $listarvehiculos=$objenvios->listarVehTxt($numlotveh,$tipo,'',$origen,'MA',$precioj);

 		 if ($tipo)
 		   $listarvehiculos=$objenvios->listarVehTxtEli($numlotveh,$tipo,'',$origen,'ME',$precioj);
 	}

    
 	if ($gen == 'S') {
    	 if (!$tipo)						
           $listarvehiculos=$objenvios->listarVehTxt('',$tipo,$numenv,$origen,'MA',$precioj);
         if ($tipo)
           $listarvehiculos=$objenvios->listarVehTxtEli('',$tipo,$numenv,$origen,'ME',$precioj);
         											
    }


      $pdf->ln();
      $pdf->SetXY(10,25);
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(0,6,'Archivo Txt para Vehiculos '.$tipo,0,0,"C");
      $pdf->ln();
      if ($origen=='N') $pdf->Cell(0,6,'Nacionales Envio Numero '.$numenv,0,0,"C");
      if ($origen=='I') $pdf->Cell(0,6,'Importados Envio Numero '.$numenv,0,0,"C");

      $pdf->ln();
      $pdf->SetFont('Arial','B',7);
      $pdf->SetXY(10,40);
      $pdf->SetWidths(array(15,15,25,15,96,15,15));
      $anchos = array(15,15,25,15,96,15,15);
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
      for($i=0;$i<count($listarvehiculos);$i+=57){
      $cont++;
      if ($listarvehiculos[$i+18]=='MA') $ma++;
      if ($listarvehiculos[$i+18]=='MM') $mm++;
      if ($listarvehiculos[$i+18]=='ME') $me++;
      $pdf->setjump(2);
      $pdf->SetFont('Arial','B',5.5);
      $pdf->Row(array($listarvehiculos[$i+18].'-'.$cont.'',$listarvehiculos[$i+0],$listarvehiculos[$i+2],$listarvehiculos[$i+3],$listarvehiculos[$i+4],$listarvehiculos[$i+6],$listarvehiculos[$i+7]));
      $pdf->setjump(2);
      $pdf->SetFont('Arial','B',5.5);
 
     
                if ($gen == 'S')
		 	{ 
		 //		echo $i.'-';
		 $data=array(($listarvehiculos[$i+18])  //tipo de movimimiento ej:'MA'(tipmov_veh)
		 			,($listarvehiculos[$i+17])  //NUMERO DE REGISTRO(numreg_intt)
		 			,($listarvehiculos[$i+19])  //TIP DE MODIF (num_modif)
		 			,($listarvehiculos[$i+20])  //COD MARCA
		 			,($listarvehiculos[$i+21])  //SERIE
		 			,($listarvehiculos[$i+22])  //MODELO
		 			,($listarvehiculos[$i+23])  //ANO DEL MODELO
		 			,($listarvehiculos[$i+2])   //SERIAL (SERCARVEH)
		 			,($listarvehiculos[$i+24])  //SERIAL DEL MOTOR
		 			,($listarvehiculos[$i+25])  //numplaveh PLACA
		 			,($listarvehiculos[$i+26])  //COLOR 1 col1veh
		 			,($listarvehiculos[$i+27])  //COLOR 2  col2veh
		 			,($listarvehiculos[$i+28])  //pesveh
		 			,($listarvehiculos[$i+29])  //tipcapveh
		 			,($listarvehiculos[$i+30])  //capcarveh
		 			,($listarvehiculos[$i+31])  //numejeveh
		 			,($listarvehiculos[$i+32])  //diarueveh
		 			,($listarvehiculos[$i+33])  //clase
		 			,($listarvehiculos[$i+34])  //tipo
		 			,($listarvehiculos[$i+35])  //uso
		 			,($listarvehiculos[$i+36])  //fecemi_cer
		 			,(substr($rifcons,0,1))		//tipo nac
				    ,(substr($rifcons,1,8))		//rif
					,(substr($rifcons,9,9))		//digito del rif
		 			,($listarvehiculos[$i+37])  //codptoveh
		 			,($listarvehiculos[$i+38])  //,numplagrav
		 			,($listarvehiculos[$i+39])  //fec_liqgrav
		 			,($listarvehiculos[$i+40])  //numfac_adq
		 			,($listarvehiculos[$i+41])  //fecfac_adq
		 			,($listarvehiculos[$i+42])  //numcerori
		 			,($listarvehiculos[$i+43])  //anofabric
		 			,($listarvehiculos[$i+44])  //sernivveh
		 			,($listarvehiculos[$i+45])  //serchaveh
		 			,($listarvehiculos[$i+46])  //numfac1veh
		 			,($listarvehiculos[$i+47])  //fecfac1veh
		 			,($listarvehiculos[$i+48])  //numhomveh
		 			,($listarvehiculos[$i+49]).'0'  //fechomveh
		 			,($listarvehiculos[$i+50])  //codserveh
		 			,($listarvehiculos[$i+51])  //numpueveh
		 			,($listarvehiculos[$i+52])  //numrafveh
		 			,($listarvehiculos[$i+53])  //fecrafveh
		 			,($listarvehiculos[$i+54])  //numsecveh
		 			,($listarvehiculos[$i+55]).'0'  // '' as sercarr
		 			,($listarvehiculos[$i+56])  //codconveh
		 			,($numenv)  );
		 			//print ($data[18]);

				 $objenvios->registrarEnviostxtVeh($data);
		 	}
      if ($pdf->gety()>245){
	  $pdf->addpage();
      $pdf->ln();
      $pdf->SetXY(10,25);
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(0,6,'Archivo Txt para Vehiculos ',0,0,"C");
      $pdf->ln();

      if ($origen=='N') $pdf->Cell(0,6,'Nacionales Envio Numero '.$numenv,0,0,"C");
      if ($origen=='I') $pdf->Cell(0,6,'Importados Envio Numero '.$numenv,0,0,"C");
      if ($origen=='P') $pdf->Cell(0,6,'Programa Venezuela Movil',0,0,"C");
   //   if ($origen=='N') $pdf->Cell(0,6,'Nacionales',0,0,"C");
      if ($origen=='E') $pdf->Cell(0,6,'Exportados',0,0,"C");
  //    if ($origen=='I') $pdf->Cell(0,6,'Importados',0,0,"C");
      if ($origen=='C') $pdf->Cell(0,6,'Carrozados',0,0,"C");
      $pdf->ln();
      $pdf->SetFont('Arial','B',7);
      $pdf->SetXY(10,40);
      $pdf->SetWidths(array(15,15,25,15,96,15,15));
      $anchos = array(15,15,25,15,96,15,15);
      $pdf->SetAligns(array("C","C","C","C","C","C"));
      $pdf->SetBorder(1);
      $cabecera = array("N#","Certifi.","Serial Car.","Rif","Beneficiario","Fact.","Fec/F.");

      $pdf->SetBorder(0);
      $pdf->SetAligns(array("L","L","L","L","L","L","L"));
      $pdf->cabecera($cabecera,$anchos);
      $pdf->ln();
      $pdf->SetFont('Arial','B',8);
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
      $pag="txt_txt.php";
      $dir='http://'.$host.$uri.$pag;
   
      if ($gen=='S'){
       
     	$pdf->PutLink(trim($dir).'?iniemp='.$iniemp.'&tipo='.$tipo.'&numlotveh='.$numlotveh.'&numenv='.$numenv.'&nomemp='.$nomemp.'&numregemp='.$numregemp.'&fecfincon='.$fecfincon.'&origen='.$origen.'&filtro='.$filtro.'&rifemp='.$rifempr.'&precioj='.$precioj,'Descargar TXT');
     	$objenvios->registrarEnvios($numenv,$origen,$ma,$mm,$me);
      }
$pdf->Output();
?>
