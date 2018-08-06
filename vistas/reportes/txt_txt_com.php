<?
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/envios_com.php');

$objenvios = new envios();

 $origen=$_GET['origen'];
 $numenv=$_GET['numenv'];


 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition: attachment; filename=".$origen."-".str_pad($numenv,4,0,STR_PAD_LEFT).".txt");

 $iniempr=$_GET['iniemp'];
 $numlotvehi=$_GET['numlotveh'];

 $nomempr=$_GET['nomemp'];
 $numregempr=$_GET['numregemp'];
 $fecfincon=$_GET['fecfincon'];

 $filtros=$_GET['filtro'];
 $fecha=date("Ymd");//date("d-m-Y H:i:s");
 $hora=date("His");//date("d-m-Y H:i:s");
 $fechac=date("d/m/Y H:i:s");//date("d-m-Y H:i:s");
 $fecdesd=$_GET['fecdes'];
 $fechasd=$_GET['fechas'];
 $tipo=$_GET['tipo1'];
 $rifempr=$_GET['rifemp'];
 $fechaenvio=date("d/m/Y");

if ($origen == 'I')
{
	   if (!$tipo){
 		    $listarvehiculos=$objenvios->txtVehImp($numenv);

	   }
 		if ($tipo){
 		    $listarvehiculos=$objenvios->txtVehImpElim($numenv);

 		}
}
else
$listarvehiculos=$objenvios->txtVehNac($numenv);

  $dia=substr($fecfincon,0,2);
  $mes=substr($fecfincon,3,2);
  $ano=substr($fecfincon,6,4);
  $fec=$ano.$mes.$dia;


if ($origen=='I'){

    echo 'RE'.str_pad($iniempr,2,' ',STR_PAD_RIGHT).str_pad($numenv,7,'0',STR_PAD_LEFT).$fecha.$hora.str_pad($nomempr,50,' ',STR_PAD_RIGHT).str_pad($numregempr,8,' ',STR_PAD_RIGHT).$fec.str_pad('',230,' ',STR_PAD_LEFT).'*'.chr(0x0D).chr(0x0A);
	$ma=0;
	$mm=0;
	$me=0;
    for($i=0;$i<count($listarvehiculos);$i+=42){

	  if ($listarvehiculos[$i]=='MA') $ma++;
      if ($listarvehiculos[$i]=='MM') $mm++;
      if ($listarvehiculos[$i]=='ME') $me++;

    echo $listarvehiculos[$i].str_pad($listarvehiculos[$i+1],7,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+2],2,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+3],3,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+4],15,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+5],15,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+6],4,' ',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+7],18,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+8],18,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+9],7,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+10],2,' ',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+11],2,' ',STR_PAD_LEFT).str_pad($listarvehiculos[$i+12],5,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+13],1,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+14],5,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+15],1,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+16],3,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+17],3,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+18],3,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+19],3,' ',STR_PAD_RIGHT).$listarvehiculos[$i+20].str_pad($rifempr,10,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+22],2,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+23],15,' ',STR_PAD_RIGHT).
    $listarvehiculos[$i+24].str_pad($listarvehiculos[$i+25],15,' ',STR_PAD_RIGHT).
    $listarvehiculos[$i+26].str_pad($listarvehiculos[$i+27],9,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+28],4,' ',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+29],17,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+30],17,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+31],15,' ',STR_PAD_RIGHT).$listarvehiculos[$i+32].str_pad($listarvehiculos[$i+33],15,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+34],8,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+35],3,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+36],3,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+37],8,' ',STR_PAD_LEFT).$listarvehiculos[$i+38].
    str_pad($listarvehiculos[$i+39],2,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+40],17,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+41],3,'0',STR_PAD_LEFT).chr(0x0D).chr(0x0A);

    }//fin del while

    echo 'RC'.str_pad($ma,7,'0',STR_PAD_LEFT).str_pad($mm,7,'0',STR_PAD_LEFT).str_pad($me,7,'0',STR_PAD_LEFT).chr(0x0D).chr(0x0A);

	}// fin de la opcion I

	//Nacionales
	if ($origen=='N'){

    echo 'RE'.str_pad($iniempr,2,' ',STR_PAD_RIGHT).str_pad($numenv,7,'0',STR_PAD_LEFT).$fecha.$hora.str_pad($nomempr,50,' ',STR_PAD_RIGHT).str_pad($numregempr,8,' ',STR_PAD_RIGHT).$fec.str_pad('',169,' ',STR_PAD_LEFT).'*'.chr(0x0D).chr(0x0A);

	$ma=0;
	$mm=0;
	$me=0;
    for($i=0;$i<count($listarvehiculos);$i+=42){

	  if ($listarvehiculos[$i]=='MA') $ma++;
      if ($listarvehiculos[$i]=='MM') $mm++;
      if ($listarvehiculos[$i]=='ME') $me++;

    echo $listarvehiculos[$i].str_pad($listarvehiculos[$i+1],7,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+2],2,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+3],3,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+4],15,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+5],15,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+6],4,' ',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+7],18,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+8],18,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+9],7,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+10],2,' ',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+11],2,' ',STR_PAD_LEFT).str_pad($listarvehiculos[$i+12],5,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+13],1,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+14],5,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+15],1,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+16],3,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+17],3,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+18],3,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+19],3,' ',STR_PAD_RIGHT).$listarvehiculos[$i+20].str_pad($rifempr,10,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+27],9,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+28],4,' ',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+29],17,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+30],17,' ',STR_PAD_RIGHT).
    str_pad('',4,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+31],15,' ',STR_PAD_RIGHT).$listarvehiculos[$i+32].str_pad($listarvehiculos[$i+33],15,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+34],8,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+35],3,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+36],3,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+37],8,' ',STR_PAD_LEFT).$listarvehiculos[$i+38].
    str_pad($listarvehiculos[$i+39],2,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+41],3,'0',STR_PAD_LEFT).chr(0x0D).chr(0x0A);

    }//fin del while

    echo 'RC'.str_pad($ma,7,'0',STR_PAD_LEFT).str_pad($mm,7,'0',STR_PAD_LEFT).str_pad($me,7,'0',STR_PAD_LEFT).chr(0x0D).chr(0x0A);

	}// fin de la opcion I


?>
<?/*
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/envios_com.php');

$objenvios = new envios();

 $origen=$_GET['origen'];
 $numenv=$_GET['numenv'];


 header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition: attachment; filename=".$origen."-".str_pad($numenv,4,0,STR_PAD_LEFT).".txt");

 $iniempr=$_GET['iniemp'];
 $numlotvehi=$_GET['numlotveh'];

 $nomempr=$_GET['nomemp'];
 $numregempr=$_GET['numregemp'];
 $fecfincon=$_GET['fecfincon'];

 $filtros=$_GET['filtro'];
 $fecha=date("Ymd");//date("d-m-Y H:i:s");
 $hora=date("His");//date("d-m-Y H:i:s");
 $fechac=date("d/m/Y H:i:s");//date("d-m-Y H:i:s");
 $fecdesd=$_GET['fecdes'];
 $fechasd=$_GET['fechas'];
 $tipos=$_GET['tipo'];
 $rifempr=$_GET['rifemp'];
 $fechaenvio=date("d/m/Y");

if ($origen == 'I')
$listarvehiculos=$objenvios->txtVehImp($numenv);
else
$listarvehiculos=$objenvios->txtVehNac($numenv);

  $dia=substr($fecfincon,0,2);
  $mes=substr($fecfincon,3,2);
  $ano=substr($fecfincon,6,4);
  $fec=$ano.$mes.$dia;


if ($origen=='I'){

    echo 'RE'.str_pad($iniempr,2,' ',STR_PAD_RIGHT).str_pad($numenv,7,'0',STR_PAD_LEFT).$fecha.$hora.str_pad($nomempr,50,' ',STR_PAD_RIGHT).str_pad($numregempr,8,' ',STR_PAD_RIGHT).$fec.str_pad('',230,' ',STR_PAD_LEFT).'*'.chr(0x0D).chr(0x0A);
	$ma=0;
	$mm=0;
	$me=0;
    for($i=0;$i<count($listarvehiculos);$i+=42){

	  if ($listarvehiculos[$i]=='MA') $ma++;
      if ($listarvehiculos[$i]=='MM') $mm++;
      if ($listarvehiculos[$i]=='ME') $me++;

    echo $listarvehiculos[$i].str_pad($listarvehiculos[$i+1],7,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+2],2,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+3],3,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+4],15,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+5],15,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+6],4,' ',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+7],18,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+8],18,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+9],7,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+10],2,' ',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+11],2,' ',STR_PAD_LEFT).str_pad($listarvehiculos[$i+12],5,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+13],1,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+14],5,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+15],1,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+16],3,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+17],3,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+18],3,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+19],3,' ',STR_PAD_RIGHT).$listarvehiculos[$i+20].str_pad($rifempr,10,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+22],2,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+23],15,' ',STR_PAD_RIGHT).
    $listarvehiculos[$i+24].str_pad($listarvehiculos[$i+25],15,' ',STR_PAD_RIGHT).
    $listarvehiculos[$i+26].str_pad($listarvehiculos[$i+27],9,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+28],4,' ',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+29],17,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+30],17,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+31],15,' ',STR_PAD_RIGHT).$listarvehiculos[$i+32].str_pad($listarvehiculos[$i+33],15,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+34],8,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+35],3,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+36],3,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+37],8,' ',STR_PAD_LEFT).$listarvehiculos[$i+38].
    str_pad($listarvehiculos[$i+39],2,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+40],17,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+41],3,'0',STR_PAD_LEFT).chr(0x0D).chr(0x0A);

    }//fin del while

    echo 'RC'.str_pad($ma,7,'0',STR_PAD_LEFT).str_pad($mm,7,'0',STR_PAD_LEFT).str_pad($me,7,'0',STR_PAD_LEFT).chr(0x0D).chr(0x0A);

	}// fin de la opcion I

	//Nacionales
	if ($origen=='N'){

    echo 'RE'.str_pad($iniempr,2,' ',STR_PAD_RIGHT).str_pad($numenv,7,'0',STR_PAD_LEFT).$fecha.$hora.str_pad($nomempr,50,' ',STR_PAD_RIGHT).str_pad($numregempr,8,' ',STR_PAD_RIGHT).$fec.str_pad('',169,' ',STR_PAD_LEFT).'*'.chr(0x0D).chr(0x0A);

	$ma=0;
	$mm=0;
	$me=0;
    for($i=0;$i<count($listarvehiculos);$i+=42){

	  if ($listarvehiculos[$i]=='MA') $ma++;
      if ($listarvehiculos[$i]=='MM') $mm++;
      if ($listarvehiculos[$i]=='ME') $me++;

    echo $listarvehiculos[$i].str_pad($listarvehiculos[$i+1],7,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+2],2,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+3],3,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+4],15,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+5],15,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+6],4,' ',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+7],18,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+8],18,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+9],7,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+10],2,' ',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+11],2,' ',STR_PAD_LEFT).str_pad($listarvehiculos[$i+12],5,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+13],1,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+14],5,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+15],1,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+16],3,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+17],3,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+18],3,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+19],3,' ',STR_PAD_RIGHT).$listarvehiculos[$i+20].str_pad($rifempr,10,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+27],9,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+28],4,' ',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+29],17,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+30],17,' ',STR_PAD_RIGHT).
    str_pad('',4,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+31],15,' ',STR_PAD_RIGHT).$listarvehiculos[$i+32].str_pad($listarvehiculos[$i+33],15,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+34],8,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+35],3,' ',STR_PAD_RIGHT).
    str_pad($listarvehiculos[$i+36],3,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+37],8,' ',STR_PAD_LEFT).$listarvehiculos[$i+38].
    str_pad($listarvehiculos[$i+39],2,'0',STR_PAD_LEFT).
    str_pad($listarvehiculos[$i+41],3,'0',STR_PAD_LEFT).chr(0x0D).chr(0x0A);

    }//fin del while

    echo 'RC'.str_pad($ma,7,'0',STR_PAD_LEFT).str_pad($mm,7,'0',STR_PAD_LEFT).str_pad($me,7,'0',STR_PAD_LEFT).chr(0x0D).chr(0x0A);

	}// fin de la opcion I


*/?>