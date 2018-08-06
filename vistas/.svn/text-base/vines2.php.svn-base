
<?php
require ('../modelos/conexion.php');
$obj = new conexion();
$conexion = $obj->conectar();

$fp = fopen ( "archivos/reciboa.csv", "r" );

while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) { // Mientras hay líneas que leer...

    $i = 0;
    foreach($data as $row) {

        echo "Campo $i: $row<br>"; // Muestra todos los campos de la fila actual

        $linea[$i]=$row;
        $i++ ;

    }

    $insert ="INSERT INTO archivo_pistola(tipo, nro_archivo, desmar, desmod, sercarveh,
    		  sermotveh, descol, anomodveh, lla, enc, car ,cau, gat,tri,her,fecha_cap,hora_cap) VALUES ";
    $sql = $insert."(1,1,'".$linea[0]."','".$linea[1]."','".$linea[2]."','".$linea[3]."','".$linea[4]."','".$linea[5]."','".$linea[6]."',
    		'".$linea[7]."','".$linea[8]."','".$linea[9]."','".$linea[10]."','".$linea[11]."','".$linea[12]."','".$linea[13]."','".$linea[14]."')";
    print $sql;echo "<br><br>";
    $consulta = $obj->consultar($conexion,$sql);

    echo "<br><br>";

}

fclose ( $fp );




?>
