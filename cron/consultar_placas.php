#!/usr/bin/php -q
<?php
$today = date('j-m-y');
$term = "Placas";
$rutaArc="../cron/placas/";
$termR=$term."_".$today;

require('../modelos/conexion.php');
$obj = new conexion();
$conexion = $obj->conectar();

$vlineas = file("../cron/placas/RESP_NO_PASARON_4x2_Placas_12-07-12.txt");

$archivo = fopen($rutaArc."CONSULTA_4x2_".$termR.".txt",'w+');
$archivoNo = fopen($rutaArc."CONSULTA_NO_4x2_".$termR.".txt",'w+');

    foreach ($vlineas as $sLinea){
        $datos = explode(" ERROR al Migrar", $sLinea); //convierte la linea en un vector
        $datos1 = explode("','", $sLinea);//placa
        $datos2 = explode("('", $datos1[0]);//serial
     //   print ' aqui 1: '.$datos1[1];
    //    print ' aqui 2: '.$datos2[1];
        $buscarplaca=" Select sercarveh,numplaveh from placas where numplaveh='".$datos1[1]."' and sercarveh='".$datos2[1]."'  ";
        $ConsultaPlaca = $obj->consultar($conexion,$buscarplaca);
        $VectorPlaca = $obj->ret_vector($ConsultaPlaca);
        //echo $buscarplaca.' Resul: '.count($ConsultaPlaca).' '.$VectorPlaca[0]." - ".$VectorPlaca[1];
       if(count($ConsultaPlaca)>0)
          fwrite($archivo,$VectorPlaca[0]." - ".$VectorPlaca[1]."\n");// si no se ejecuta la consulta escribe en el archivo
       if(count($ConsultaPlaca)==0)
          fwrite($archivoNo,"NO ESTA: ".$datos1[1].' - '.$datos2[1]."\n");// si no se ejecuta la consulta escribe en el archivo

    }
$obj->desconectar($conexion);
fclose($archivo); // cierra el archivo destino
?>