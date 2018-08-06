#!/usr/bin/php -q
<?php
$today = date('j-m-y');
$term = "Placas";
$rutaArc="../cron/placas/";
$termR=$term."_".$today;

require('../modelos/conexion.php');
$obj = new conexion();
$conexion = $obj->conectar();

$vlineas = file("../cron/placas/placas4x4.txt");

$archivo = fopen($rutaArc."PASARON_4x4_".$termR.".txt",'w+');
$archivoNo = fopen($rutaArc."RESP_NO_PASARON_4x4_".$termR.".txt",'w+');

$fecha=date('d/m/Y');

    foreach ($vlineas as $sLinea){
        $datos = explode(";", $sLinea); //convierte la linea en un vector
        $data = explode("\t", $sLinea);//placa
        $sql = "INSERT INTO placas (
  		          sercarveh ,  numplaveh ,  codestveh ,
                  numrafveh ,  fecrafveh ,  numsecveh,  fecha_reg )
		          values
		           ('".$data[1]."','".$data[0]."','A','DCMD9093','27/03/2012',1,'".$fecha."')";
       // print $sql;
        $consulta = $obj->consultar($conexion,$sql);
        if($consulta)
           fwrite($archivo,$data[0].' - '.$data[1]." Cargadas al sistema con Exito"."\n");// si no se ejecuta la consulta escribe en el archivo
        if(!$consulta){
        	   $buscarplaca=" Select sercarveh,numplaveh from placas where numplaveh='".$datos1[1]."' and sercarveh='".$datos2[1]."'  ";
               $ConsultaPlaca = $obj->consultar($conexion,$buscarplaca);
               $VectorPlaca = $obj->ret_vector($ConsultaPlaca);
               if(count($ConsultaPlaca)>0)
                   fwrite($archivoNo,'PLA1: '.$data[0].' - '.$data[1]." ERROR al Migrar, ya se encuentra registrado"."\n");// si no se ejecuta la consulta escribe en el archivo
               if(count($ConsultaPlaca)==0)
                   fwrite($archivoNo,'PLA0: '.$data[0].' - '.$data[1]." ERROR al Migrar, placa o serial no coinciden "."\n");// si no se ejecuta la consulta escribe en el archivo
        }
    }
$obj->desconectar($conexion);
fclose($archivo); // cierra el archivo destino
?>