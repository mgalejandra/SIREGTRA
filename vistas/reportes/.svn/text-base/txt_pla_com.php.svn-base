<?
session_start();
require('../../modelos/conexion.php');
require('../../controlador/funciones.php');
require('../../modelos/envios_com.php');

  $objenvios = new envios();

  $numenv=$_GET['numenv'];
 //$numenv= $_SESSION['numenv'];

  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename="."placas-".str_pad($numenv,4,0,STR_PAD_LEFT).".txt");


 $numlotveh= $_SESSION['numlotveh'];
 $gen= $_SESSION['gen'];

 $fechac=date("d/m/Y H:i:s");//date("d-m-Y H:i:s");
 $fechaenvio=date("d/m/Y");

$listarvehiculos=$objenvios->txtPla($numenv);
//echo $numenv. ' aqui';
  $cont=0;
  for($i=0;$i<count($listarvehiculos);$i+=5){
  $cont++;
  echo str_pad($listarvehiculos[$i],10,'0',STR_PAD_LEFT).str_pad($listarvehiculos[$i+1],7,' ',STR_PAD_RIGHT).
  str_pad($listarvehiculos[$i+2],2,' ',STR_PAD_RIGHT)."X".
  str_pad($listarvehiculos[$i+3],8,' ',STR_PAD_RIGHT).str_pad($listarvehiculos[$i+4],2,'0',STR_PAD_LEFT).chr(0x0D).chr(0x0A);
   }//fin del for
?>