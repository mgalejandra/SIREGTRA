#!/usr/bin/php -q
<?php
$today = date('j-m-y');
$term = "Placas";
$rutaArc="../cron/placas/";
$termR=$term."_".$today;

require('../modelos/conexion.php');
$obj = new conexion();
$conexion = $obj->conectar();

$vlineas = file("../cron/placas/PLACAS4X2.sql");

$archivo = fopen($rutaArc."PASARON_4x2_".$termR.".txt",'w+');
$archivoNo = fopen($rutaArc."RESP_NO_PASARON_4x2_".$termR.".txt",'w+');

    foreach ($vlineas as $sLinea){
        $datos = explode(";", $sLinea); //convierte la linea en un vector
        $datos1 = explode("','", $sLinea);//placa
        $datos2 = explode("('", $datos1[0]);//serial
        $consulta = $obj->consultar($conexion,$datos[0]);
        if($consulta)
           fwrite($archivo,$datos1[1].' - '.$datos2[1]." Cargadas al sistema con Exito"."\n");// si no se ejecuta la consulta escribe en el archivo
        if(!$consulta){
        	   $buscarplaca=" Select sercarveh,numplaveh from placas where numplaveh='".$datos1[1]."' and sercarveh='".$datos2[1]."'  ";
               $ConsultaPlaca = $obj->consultar($conexion,$buscarplaca);
               $VectorPlaca = $obj->ret_vector($ConsultaPlaca);
               if(count($ConsultaPlaca)>0)
                   fwrite($archivoNo,'PLA1: '.$datos1[1].' - '.$datos2[1]." ERROR al Migrar, ya se encuentra registrado"."\n");// si no se ejecuta la consulta escribe en el archivo
               if(count($ConsultaPlaca)==0)
                   fwrite($archivoNo,'PLA0: '.$datos1[1].' - '.$datos2[1]." ERROR al Migrar, placa o serial no coinciden "."\n");// si no se ejecuta la consulta escribe en el archivo
        }
    }
$obj->desconectar($conexion);
fclose($archivo); // cierra el archivo destino
?>