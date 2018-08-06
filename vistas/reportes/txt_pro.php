<?
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/envios.php');

  $objenvios = new envios();

  $numenv=$_GET['numenv'];
 // $numenv= $_SESSION['numenv'];
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename="."propietario-".str_pad($numenv,4,0,STR_PAD_LEFT).".txt");

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
 $fecha=date("Ymd");//date("d-m-Y H:i:s");
 $hora=date("His");//date("d-m-Y H:i:s");
 $rifcons="G200079843";
 $fechac=date("d/m/Y H:i:s");//date("d-m-Y H:i:s");
 $precioj=$_GET['precioj'];
  $dia=substr($fecfincon,0,2);
  $mes=substr($fecfincon,3,2);
  $ano=substr($fecfincon,6,4);
  $fec=$ano.$mes.$dia;
  $fechaenvio=date("d/m/Y");


	     if (!$tipo)
 		   $listarvehiculos=$objenvios->txtPro($numenv,$tipo,$precioj);
 		if ($tipo)
 		   $listarvehiculos=$objenvios->txtProElim($numenv,$tipo,$precioj);

//echo $sql;

  $cont=0;

  echo 'RE'.str_pad($numenv,7,'0',STR_PAD_LEFT).str_pad($rifemp,10,' ',STR_PAD_RIGHT).str_pad($numregemp,8,' ',STR_PAD_RIGHT).$fec.str_pad($nomemp,50,' ',STR_PAD_RIGHT).str_pad('',269,' ',STR_PAD_LEFT)."*".chr(0x0D).chr(0x0A);
  $ma=0;
  $mm=0;
  $me=0;
  for($i=0;$i<count($listarvehiculos);$i+=22){
	  $con++;
	  if ($listarvehiculos[$i]=='MA') $ma++;
      if ($listarvehiculos[$i]=='MM') $mm++;
      if ($listarvehiculos[$i]=='ME') $me++;

		if (substr($listarvehiculos[$i+2],0,1)=='V'){
		 echo $listarvehiculos[$i].str_pad($listarvehiculos[$i+1],7,'0',STR_PAD_LEFT).str_pad($rifcons,10,'0',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+2],10,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+3],30,' ',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+4],30,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+5],30,' ',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+6],30,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+7],30,' ',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+8],30,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+9],30,' ',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+10],6,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+11],4,' ',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+12],30,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+13],12,'0',STR_PAD_LEFT).
		 str_pad($listarvehiculos[$i+14],12,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+15],7,' ',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+16],3,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+17],2,' ',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+18],17,' ',STR_PAD_RIGHT).$listarvehiculos[$i+19].str_pad($listarvehiculos[$i+20],15,' ',STR_PAD_RIGHT).
		 chr(0x0D).chr(0x0A);
		}

		if (substr($listarvehiculos[$i+2],0,1)!='V'){
		 echo $listarvehiculos[$i].str_pad($listarvehiculos[$i+1],7,'0',STR_PAD_LEFT).str_pad($rifcons,10,'0',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+2],10,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+21],120,' ',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+7],30,' ',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+8],30,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+9],30,' ',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+10],6,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+11],4,' ',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+12],30,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+13],12,'0',STR_PAD_LEFT).
		 str_pad($listarvehiculos[$i+14],12,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+15],7,' ',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+16],3,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+17],2,' ',STR_PAD_RIGHT).
		 str_pad($listarvehiculos[$i+18],17,' ',STR_PAD_RIGHT).$listarvehiculos[$i+19].str_pad($listarvehiculos[$i+20],15,' ',STR_PAD_RIGHT).
		 chr(0x0D).chr(0x0A);
		 }

  }//fin del while
    echo 'RC'.str_pad($ma,7,'0',STR_PAD_LEFT).str_pad($mm,7,'0',STR_PAD_LEFT).str_pad($me,7,'0',STR_PAD_LEFT).chr(0x0D).chr(0x0A);




?>