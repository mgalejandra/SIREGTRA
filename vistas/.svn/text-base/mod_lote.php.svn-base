<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/lotes.php');
require('../modelos/departamentos.php');

 $objLote = new lotes();
 $objDpto = new departamentos();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5);
validaAcceso($permitidos,$dir);


$opc=$_GET['opr'];

$cod=$_POST['cod'];
$fec=$_POST['fec'];
$nom=$_POST['nomb'];
$dep=$_POST['dep'];

if ($opc)
{
	$modificar=$objLote->modificarLote($cod,$fec,$nom,$dep);

		if ($modificar){
       		echo '<SCRIPT>alert("Lote Modificado");</SCRIPT>';
          	echo "<SCRIPT>window.location.href='cat_lot.php';</SCRIPT>";
         	//$limpiar= $objExpediente->limpiar();
	 	}
		else
			echo '<SCRIPT>alert("Lote No Modificado");</SCRIPT>';
}
?>
<!DOCTYPE HTML PUBLIC>
<html>
<head>
  <title>Modificar Lote</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <script type="text/javascript" src="../controlador/ajax.js"></script>
  <link href="../css/classstyles.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
<form action="" method="post" name="form1" >

    <table width="50%" height="147" align="center">
      <tr>
        <td colspan="2" ><div align="center" class="Not"><strong>Datos a Modificar </strong></div></td>
      </tr>
      <tr >
        <td width="50%" class="TitNot"><div align="right"><strong>N&uacute;mero:</strong></div></td>
        <?php
  	    $co=$_GET['codi'];
  	   	$buscarLotes = $objLote->buscarLoteID($co);
	   ?>
        <td width="50%"><input name="cod" type="text" id="cod" value="<?php  echo $buscarLotes[0];?>" readonly></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Fecha:</strong></div></td>
        <td><input name="fec" type="text" id="fec" value="<?php  echo $buscarLotes[1];?>" size="15" ></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Descripci&oacute;n:</strong></div></td>
        <td><input name="nomb" type="text" id="nomb" value="<?php  echo $buscarLotes[2];?>" onblur="javascript:this.value=this.value.toUpperCase()"></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Departamento:</strong></div></td>
        <td class="TitNot"><SELECT name="dep" id="dep">
               <OPTION value="0"></OPTION>
               <?php $busDpto = $objDpto->listarDpto(); for($i=0;$i<count($busDpto);$i+=2){?>
    	        <option value="<?php echo $busDpto[$i]?>" <?php if($buscarLotes[3] == $busDpto[$i]) echo ' selected="true"'?>>
    	         <?php echo $busDpto[$i+1]?>
    	        </option>
               <?php }?>
              </SELECT></td>
      </tr>


         <tr >
        <td height="12" colspan="2"><div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1"></div></td>
      </tr>
      <tr >
        <td colspan="2"><div align="center">
            <input type="button"  name="eliminar" value="Modificar" onClick="link('mod_lote.php?opr=1',document.form1); return false"><input type="button" value="Atras" onClick="javascript:history.back();">
        </div></td>
      </tr>
    </table>
</form>
</body>
</html>