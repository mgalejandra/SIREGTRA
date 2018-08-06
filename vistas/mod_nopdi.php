<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/vehiculos.php');

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
/*$permitidos = array(1,3,4,5);
validaAcceso($permitidos,$dir);*/

$objVehiculo = new vehiculos();

$listarNivel = $objVehiculo->comboNoPDI();

//echo "Cuenta: ".count($listarNivel);

$mod = $_GET['mod'];
$sercarveh=$_GET['sercarveh'];
$comentario =$_POST['obspro'];
$nivel = $_POST['nivel'];
$reg = $_POST['indReg'];

if ($mod==1){
	$buscarDatos = $objVehiculo->listVehNoPDI2('','',$sercarveh,'','','',-1);

	if ($buscarDatos){
		$observa= $buscarDatos[7];
		$nivel1=$buscarDatos[8];

		$nivelN = $objVehiculo->comboNoPDI($nivel1);
  		$numero = $nivelN[0];
	}

}

if ($reg==1){
   $cambioPDI = $objVehiculo->bloquearVehiculo($sercarveh,$comentario,$nivel);

	if ($cambioPDI){
       		echo '<SCRIPT>alert("Vehiculo '.$sercarveh.' marcado como PDI No aprobado");</SCRIPT>';
       		echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
       		echo "<SCRIPT>window.close();</SCRIPT>";
  	}
	else
	{
       		echo '<SCRIPT>alert("Error al marcar vehiculo NO PDI");</SCRIPT>';
       		echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
       		echo "<SCRIPT>window.close();</SCRIPT>";
  	}

}

if ($reg==2){

   $cambioPDI = $objVehiculo->bloquearVehiculo1($sercarveh,$comentario,$nivel);

	if ($cambioPDI){
       		echo '<SCRIPT>alert("Los datos del Vehiculo '.$sercarveh.' marcado como PDI No aprobado fueron actualizados");</SCRIPT>';
       		echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
       		echo "<SCRIPT>window.close();</SCRIPT>";
  	}
	else
	{
       		echo '<SCRIPT>alert("Error al actualizar datos de vehiculo NO PDI");</SCRIPT>';
       		echo "<SCRIPT>window.opener.location.reload();</SCRIPT>";
       		echo "<SCRIPT>window.close();</SCRIPT>";
  	}

}

?>
<!DOCTYPE HTML PUBLIC >
<html>
<head>
	<title>Marcar Vehiculo como No PDI</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
    <link href="../css/classstyles.css" rel="stylesheet" type="text/css">

     <SCRIPT language="JavaScript">
    function validar(dato){
      document.form1.indReg.value = dato;
      document.form1.submit();
    }
   </SCRIPT>
</head>
<body leftmargin=0 topmargin=0 marginheight="0" marginwidth="0" bgcolor="#ffffff">
<form action="" method="post" name="form1" >
<table width="50%" align="center">
      <tr ">
        <td colspan="2"><div align="center" class="Not"><strong>Marcar Vehiculo como No PDI</strong></div></td>
      </tr>
      <tr >
        <td width="52%" height="23" class="TitNot"><div align="right"><strong>Serial No Apto:</strong></div></td>
        <td width="48%"><? echo $sercarveh; ?></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Observacion:</strong></div></td>
        <td><textarea name="obspro" cols="60" rows="2" id="obspro"  onblur="javascript:this.value=this.value.toUpperCase()"><? echo $observa; ?></textarea>
      </tr>
      <tr>
      <td class="TitNot">Nivel:</td>
	        <td class="dato" colspan="3" >
               <SELECT id="nivel" name="nivel">
				 <option value="<?php if ($nivel1) echo $numeroN?>"><?php if ($nivel1) echo $nivel1;?></option>
			    <?php for($i=0;$i<count($listarNivel);$i+=3){  ?>
	               <option value="<?php echo $listarNivel[$i]; ?>"><?php echo $listarNivel[$i+1]?></option>
	           <?php } ?>
			 </SELECT>
	        </td>
      </tr>

	  <tr class="menu01" >
				<td height="2" colspan="2"><div align="center" class="NotCelda">
				<div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1" alt="" border="0" /></div>
				</div></td>
		  </tr>

      <tr >
        <td colspan="2"><div align="center">
        <? if ($mod==1){ ?>
        	<input type="button"  name="marcar" value="Modificar" onClick="validar(2);">
        <? }
           else
           { ?>
        	<input type="button"  name="marcar" value="Marcar No Apto" onClick="validar(1);">
        <? }?>
            <input type="hidden" name="indReg" id="indReg">
        </div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    </td>
</form>
</body>
</html>