#!/usr/bin/php -q
<?php
$today = date('j-m-y');
$term = "Bicentenario";
$rutaArc="../cron/creditos/";
$termR=$term."_".$today;

require('../modelos/conexion.php');
$obj = new conexion();
$conexion = $obj->conectar();

$vlineas = file("../cron/creditos/bicentenario_act_19062012.sql");

$archivo = fopen($rutaArc."ACT_RESP_NO_PASARON_".$termR.".txt",'w+');
$archivoNo = fopen($rutaArc."ACT_RESP_NO_REGISTRADOS_".$termR.".txt",'w+');

    foreach ($vlineas as $sLinea){
        $datos = explode(";", $sLinea); //convierte la linea en un vector
        $datos1 = explode("codpro='", $sLinea);
        $datos2 = explode("';", $datos1[1]);
        //echo $datos2[0].' % ';
        $buscarBeneficiario=" Select codpro, nomcomp from propietarios where codpro='".$datos2[0]."'";
       $consultaBene = $obj->consultar($conexion,$buscarBeneficiario);
       $VectorBene = $obj->ret_vector($consultaBene);
        if (count($VectorBene)==0)
          fwrite($archivoNo,$datos2[0]." No Registrado en Sistema"."\n");
        $consulta = $obj->consultar($conexion,$datos[0]);
        if(!$consulta)
          fwrite($archivo,$datos[0]." ERROR al Actualizar"."\n");// si no se ejecuta la consulta escribe en el archivo
    }
$obj->desconectar($conexion);
fclose($archivo); // cierra el archivo destino
?>