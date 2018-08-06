<html>
<body class="pagina">
<form action="" method="post" enctype="multipart/form-data">
    <label for="file">Cargar Archivo:</label>
    <input type="file" name="archivo" id="archivo" />
    <input type="submit" name="boton" value="Subir" />
</form>
<div class="resultado">
<?php
require ('../modelos/conexion.php');

$obj = new conexion();

$conexion = $obj->conectar();

$fecha=date('d-m-Y');

$hora=date('H:i:s');


if(isset($_POST['boton'])){

    //Si es que hubo un error en la subida, mostrarlo, de la variable $_FILES podemos extraer el valor de [error], que almacena un valor booleano (1 o 0).
      if ($_FILES["archivo"]["error"] > 0) {
        echo $_FILES["archivo"]["error"] . "";
      } else  {

				$sqlTipo="select id , nombre, descripcion, lugar from tipo_archivo where nombre='".$_FILES["archivo"]["name"]."'";

				//echo $sqlTipo;

				$consultaTipo = $obj->consultar($conexion,$sqlTipo);

				$tipo= $obj->ret_vector($consultaTipo);

				//echo $tipo[0].' nombre:'.$tipo[1];

				if (count($tipo)>0 and ($tipo[0]==1 or $tipo[0]==2 or $tipo[0]==3 )){

					$sqls = "select nextval('archivos_pistola') as num";
					$consultaseq = $obj->consultar($conexion,$sqls);
					$codarch= $obj->ret_vector($consultaseq);

				    // Si no hubo ningun error, procedemos a subir a la carpeta /archivos, seguido de eso mostramos la imagen subida
		            move_uploaded_file($_FILES["archivo"]["tmp_name"],"archivos/" . $codarch[0].'_'.$fecha.'_'.$hora.'_'.$_FILES["archivo"]["name"]);

		            $fp = fopen ( "archivos/" . $codarch[0].'_'.$fecha.'_'.$hora.'_'.$_FILES["archivo"]["name"] , "r" );


					while (( $data = fgetcsv ( $fp , 1000 , ";" )) !== FALSE ) { // Mientras hay líneas que leer...

					    $i = 0;
					    foreach($data as $row) {
					       // echo "Campo $i: $row<br>"; // Muestra todos los campos de la fila actual
					        $linea[$i]=$row;
					        $i++ ;
					    }

					    $insert ="INSERT INTO archivo_pistola(tipo, nro_archivo, desmar, desmod, sercarveh,
					    		  sermotveh, descol, anomodveh,anofabveh, lla, enc, car ,cau, gat,tri,her,fecha_cap,hora_cap) VALUES ";
					    $sql = $insert."('".$tipo[0]."',$codarch[0],'".$linea[0]."','".$linea[1]."','".$linea[2]."','".$linea[3]."','".$linea[4]."',
					    		'".$linea[5]."','".$linea[6]."','".$linea[7]."','".$linea[8]."','".$linea[9]."','".$linea[10]."','".$linea[11]."',
					    		'".$linea[12]."','".$linea[13]."','".$linea[14]."','".$linea[15]."')";
					    //print $sql;echo "<br><br>";
					    $consulta = $obj->consultar($conexion,$sql);

					   // echo "<br><br>";

					}

					fclose ( $fp );
					          echo "Archivo Subido Correctamente con la referencia: ".$codarch[0]." y el nombre : ".$codarch[0].'_'.$fecha.'_'.$hora.'_'.$_FILES["archivo"]["name"];


				}else echo 'Este Nombre :'.$_FILES["archivo"]["name"].' es Incorrecto, ingrese un archivo con un nombre valido';
   }

}
?>
</div>
</body>
</html>