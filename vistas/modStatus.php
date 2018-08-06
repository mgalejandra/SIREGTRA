<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
 require('../modelos/estatus.php');


 $objEstatus = new estatus();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2);
validaAcceso($permitidos,$dir);

$opc=$_GET['opr'];

 $id=$_GET['id'];
$id_estatus=$_POST['id_estatus'];
$descripcion=$_POST['descripcion'];
$orden=$_POST['orden'];
$env=$_POST['env'];


if ($opc)
{

	$modificar=$objEstatus->modificarEstatus($id_estatus,$descripcion,$orden);

		if ($modificar){
       		echo '<SCRIPT>alert("Estatus Modificado");</SCRIPT>';
          	echo "<SCRIPT>window.location.href='listado_status.php';</SCRIPT>";
	 	}
		else
			echo '<SCRIPT>alert("Estatus No Modificado");</SCRIPT>';
}
    /*    if ($_GET['codi'])
  	    $co=$_GET['codi'];
  	    else*/

  	   	$buscarEstatus = $objEstatus->listarStatus($id,'','',-1);

?>
<!DOCTYPE HTML PUBLIC>
<html>
<head>
  <title>Modificar Estatus</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 	 <link rel="stylesheet" type="text/css" href="../css/style.css">
     <link rel="stylesheet" href="../css/stilos.css" type="text/css">
     <link href="../css/classstyles.css" rel="stylesheet" type="text/css">
 	 <script type="text/javascript" src="../controlador/ajax.js"></script>
     <script type="text/javascript" src="../controlador/funciones.js"></script>
     <script type="text/javascript" src="../controlador/validar.js"></script>

</head>
  <body class="pagina">
   <TABLE class="completo">
    <TR>
     <TD class="banner"></TD>
    </TR>
    <TR>
     <TD >
      <DIV class="menu">
      <?php include("menu.php")  ?>
      </DIV>
     </TD>
    </TR>
    <TR>
     <TD class="cuerpo">
<form action="" method="post" name="form1" >

    <table width="50%" height="147" align="center">
      <tr>
        <td colspan="2" ><div align="center" class="Not"><strong>Datos a Modificar </strong></div></td>
      </tr>
      <tr >
        <td width="50%" class="TitNot"><div align="right"><strong>C&uacute;digo:</strong></div></td>

        <td width="50%"><input name="id_estatus" type="text" id="id_estatus" value="<?php  echo $buscarEstatus[0];?>" readonly></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>Descripci&oacute;n:</strong></div></td>
        <td><input name="descripcion" type="text" size="20" id="descripcion" value="<?php  echo $buscarEstatus[1];?> " onblur="javascript:this.value=this.value.toUpperCase()" ></td>
      </tr>
      <tr >
        <td class="TitNot"><div align="right"><strong>&Oacute;rden:</strong></div></td>
        <td><input name="orden" type="text" id="orden" value="<?php  echo $buscarEstatus[2];?>" onblur="javascript:this.value=this.value.toUpperCase()"></td>
      </tr>

         <tr >
        <td height="12" colspan="2"><div align="center" class="NotCelda"><img src="imagenes/px1.gif" width="1" height="1"></div></td>
      </tr>
      <tr >
        <td colspan="2"><div align="center">
            <input type="button"  name="modificar" value="Modificar" onClick="link('modStatus.php?opr=1',document.form1); return false"><input type="button" value="Atras" onclick="window.location.href='listado_status.php'" />
        </div></td>
      </tr>
    </table>
</form>
	</TD>
		</TR>
		 <TR>
     <TD class="piedepagina">
      <?php include("piedepagina.php") ?>
     </TD>
    </TR>
		</TABLE>
 </body>
</html>