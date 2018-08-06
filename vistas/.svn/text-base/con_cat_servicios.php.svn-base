<?php
//Configuracion de la conexion a base de datos
require('../modelos/conexion.php');
require('../modelos/servicio.php');

	$host = $_SERVER["HTTP_HOST"];
	$aux = explode('/',$_SERVER["REQUEST_URI"]);
	$uri='';
	for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
	$dir='http://'.$host.$uri;
	$permitidos = array(1,2,3,4,5,6,7,11,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23);

 $objServ= new servicio();
 $opc=$_GET['opc'];
 $cod=$_POST['cod'];
 $des=$_POST['nomb'];

 $codI=$_POST['codI'];
 $desI=$_POST['nombI'];

 /*echo "cod: ".$cod." desc".$des;
 echo '<br>';
 echo "codI: ".$codI." descI".$desI;*/
 /*if ($codI or $desI) $idI = '1';

 if ($idI=='1'){
	if ($fecI and $desI){
		$objServ->agregarServicio($codI,$desI);
		echo '<div aling="center" class="correcto_valid">Datos Guardados</div>';
	}else{
		echo '<div class="error_valid">Debe ingresar la Fecha y la Descripción</div>';
		 }
 }else{*/
 	$listar = $objServ->buscarServicio($cod,$des);
 //}

//consulta todos los empleados
//muestra los datos consultados
//haremos uso de tabla para tabular los resultados
  ?>
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
   <title>Servicios</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link href="../css/classstyles.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="../controlador/ajax.js"></script>
  <script language="JavaScript" type="text/JavaScript">
   function aceptar(cod,des)
   {
      //descripci�n es el nombre que tiene el objeto en la vista principal id = "descripcion"

      opener.document.getElementById('codservehi').value = cod;
      opener.document.getElementById('desservehi').value = des;
      close();
   }
</script>
<table width="378" border="0" align="center" >
  <tr  >
    <td width="139" height="21" class="Not">
    <div align="center"><strong>C&oacute;digo</strong></div></td>
    <td width="113" class="Not">
    <div align="center"><strong>Servicios</strong></div></td>

  </tr>
<?php
  //	$buscarServ = $objServ->buscarServicio($cod,$des,$opc);

    for($i=0;$i<count($listar);$i+=2){
          if($listar[$i]){
             $color = (!$indC)?'datosimpar':'datospar';
             $indC = !$indC;
  ?>

              <tr class="<?php echo $color ?>">
               <td align="center">
                <a class="vinculo" href="javascript: aceptar('<?= $listar[$i]?>','<?= $listar[$i+1]?>')">
                 <?php echo str_pad($listar[$i],3,'0',STR_PAD_LEFT);?>
                </a>
               </td>
               <td><?php echo $listar[$i+1];?></td>
               </tr>
<?php     }
        }
?>
</table>