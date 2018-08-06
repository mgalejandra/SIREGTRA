#!/usr/bin/php -q
<?php
$today = date('j-m-y');
$term = "Bicentenario";
$rutaArc="../cron/creditos/";
$termR=$term."_".$today;

require('../modelos/conexion.php');
$obj = new conexion();
$conexion = $obj->conectar();

$vlineas = file("../cron/creditos/bicentenario_19062012.sql");

$archivo = fopen($rutaArc."RESP_NO_PASARON_".$termR.".txt",'w+');
$archivoNo = fopen($rutaArc."RESP_NO_REGISTRADOS_".$termR.".txt",'w+');

    foreach ($vlineas as $sLinea){
        $datos = explode(";", $sLinea); //convierte la linea en un vector
        $datos1 = explode("','", $sLinea);
        $buscarBeneficiario=" Select codpro, nomcomp from propietarios where codpro='".$datos1[1]."'";
        $consultaBene = $obj->consultar($conexion,$buscarBeneficiario);
        $VectorBene = $obj->ret_vector($consultaBene);
        if (count($VectorBene)==0)
          fwrite($archivoNo,$datos1[1]." No Registrado en Sistema"."\n");
        $consulta = $obj->consultar($conexion,$datos[0]);
        if(!$consulta)
          fwrite($archivo,$datos[0]." ERROR al Migrar"."\n");// si no se ejecuta la consulta escribe en el archivo

    }
$obj->desconectar($conexion);
fclose($archivo); // cierra el archivo destino
?>