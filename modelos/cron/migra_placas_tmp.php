#!/usr/bin/php -q
<?php
$today = date('j-m-y');
$term = "placas02-02-2012";
$rutaArc="../../cron/placas/";
$termR="respuesta_".$term."_".$today;

require ('../conexion.php');
$obj = new conexion();
$conexion = $obj->conectar();
//$vlineas = file("/home/carolina/Desktop/prueba/detproformas01-10-2011.txt");
//$archivo = fopen("/home/carolina/Desktop/prueba/respuesta_det_prof.txt",'w+');

$vlineas = file("../../cron/placas/".$term.".txt");

//$archivo = fopen("/home/carolina/Desktop/prueba/respuesta_det03.txt",'w+');
//$archivo = fopen($rutaArc.$termR.".txt",'w+');
$archivo = fopen($rutaArc."RESP_".$today."_".$term,'w+');
    // Podemos mostrar / trabajar con todas las líneas:
    foreach ($vlineas as $sLinea){
        $datos = explode("\n", $sLinea);
        //$linea =  str_replace("\t","','",$sLinea);
        $linea =  str_replace("\n","",$linea);
        $insert = "INSERT INTO placas_t(numplaveh, sercarveh, modelo) VALUES ";
         $sql = $insert.$datos[0]."\n";
//echo $sql;
         $consulta = $obj->consultar($conexion,$sql);
         if($consulta){
            fwrite($archivo,$datos[0]." Migrada con Exito"."\n");
         }else{
          fwrite($archivo,$datos[0]." ERROR al Migrar"."\n");
         }
    }

$obj->desconectar($conexion);
fclose($archivo);

?>