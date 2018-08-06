<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/envios_com.php');

$objenvios = new envios();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,11,24,18);
validaAcceso($permitidos,$dir);
$ban=0;

$indReg=$_POST['indReg'];

 $_SESSION['rifemp']=$_POST['rifemp'];
 $_SESSION['iniemp']=$_POST['iniemp'];
 $_SESSION['numlotveh']=$_POST['numlotveh'];
 $_SESSION['numenv']=$_POST['numenv'];
 $_SESSION['nomemp']=$_POST['nomemp'];
 $_SESSION['numregemp']=$_POST['numregemp'];
 $_SESSION['fecfincon']=$_POST['fecfincon'];
 $_SESSION['origen']=$_POST['origen'];
 $_SESSION['gen']=$_POST['gen'];
 $_SESSION['tipo']=$_POST['tipo'];
 $_SESSION['filtro']=$_POST['filtro'];

$indErr = false;

  $buscarEnvioVeh = $objenvios->buscarEnvioVeh('2');

  $buscarLotes = $objenvios->buscarLotesDep(2);

  if ($indReg == 1){
  	if ($_SESSION['gen'] == 'S'){
  		if (!$_SESSION['tipo']) //agregados-Modificado
  		    $cambiar=$objenvios->cambiarEstatusPro($_SESSION['numlotveh'],$_SESSION['tipo'],$_SESSION['numenv']);
  		if ($_SESSION['tipo'])//eliminados
  		    $cambiar=$objenvios->cambiarEstatusProElim($_SESSION['numlotveh'],$_SESSION['tipo'],$_SESSION['numenv']);

  	if ($cambiar){
  		 echo "<SCRIPT> alert('Estatus Txt Propietario Cambiado ');</SCRIPT>";
  		 echo "<SCRIPT>window.location.href='reportes/pdfpro_com.php';</SCRIPT>";

  	}
  		 else echo "<SCRIPT> alert('No hay Vehiculos Para Generar TXT');</SCRIPT>";
  	              }else {
  	              	 if (!$_SESSION['tipo']) //agregados-Modificado
  	              	    $buscar=$objenvios->buscarEstatus($_SESSION['numlotveh'],$_SESSION['tipo'],$_SESSION['origen'],'estatuspro','tipmov_pro');
  	              	 if ($_SESSION['tipo'])//eliminados // se eliminan los propietarios eliminados en en vehiculo
  	              	    $buscar=$objenvios->buscarEstatusElim($_SESSION['numlotveh'],$_SESSION['tipo'],$_SESSION['origen'],'estatuspro','tipmov_txt','numenvpro');
  	              	 //$buscar=$objenvios->buscarEstatus($_SESSION['numlotveh'],$_SESSION['tipo'],'','estatuspro');
  	              	 if ($buscar){
  	              	   echo "<SCRIPT> alert('Listado de Propietario Para Generar TXT');</SCRIPT>";
  		               echo "<SCRIPT>window.location.href='reportes/pdfpro_com.php';</SCRIPT>";
  	              	 }else echo "<SCRIPT> alert('No hay Propietarios Para Listar');</SCRIPT>";
  	              }
  }

?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <title>TXT BENEFICIARIOS </title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
   <script type="text/javascript" src="../controlador/funciones.js"></script>
   <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>

function validarCaract(dato){

 document.form1.indReg.value = dato;
 document.form1.submit();
 //  document.form1.action='reportes/pdfpro_com.php';
 //  document.form1.submit();

}

    </script>
  </head>
  <body class="pagina">
   <TABLE class="completo">
    <TR>
     <TD class="banner"></TD>
    </TR>
    <TR>
     <TD >
      <DIV class="menu">
       <?php include("menu.php") ?>
      </DIV>
     </TD>
    </TR>
    <TR>
     <TD class="cuerpo">
      <DIV class="nivel1">
       <DIV class="nivel2">
<!--  Contenido Principal         -->
  <form id="form1" name="form1" method="post" action="">
  <table class="formulario" width="822" border="0" align="center" >
      <tr>
        <td colspan="4" class="cabecera">Archivo Txt Propietario</td>
      </tr>
     <tr>
        <td class="categoria">Numero de envio  :</td>
        <td class="dato">
          <input name="numenv" type="text" id="numenv"  onkeypress="return acessoNumerico(event)" size="20" maxlength="7"  value="<?php echo $buscarEnvioVeh+1;?>" />
        </td>
         <td class="categoria">Ultimo Numero de envio  :</td>
        <td class="dato">
	        <input name="ultnumenv" type="text" id="ultnumenv"   size="20" maxlength="7" readonly="readonly"  value="<?php echo $buscarEnvioVeh;?>" />
        </td>
      </tr>
       <tr>
        <td class="categoria">Nombre de Ensambladora   :</td>
       <td class="dato" colspan="3">
               <input name="nomemp" type="text" id="nomemp"  onblur="javascript:this.value=this.value.toUpperCase()" size="35" maxlength="50" value="SUMINISTROS VENEZOLANOS INDUSTRIALES C.A" readonly="" />
        </td>
      </tr>
       <tr>
        <td class="categoria">R.I.F de Ensambladora :	</td>
        <td class="dato" colspan="3">
           <input name="rifemp" type="text" id="rifemp"  onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="8" onKeyPress="return acessoNumerico(event)" value="G200079843" readonly=""/>
        </td>

      </tr>
         <tr>
        <td class="categoria">Numero de Registro de Empresa  :	</td>
        <td class="dato">
           <input name="numregemp" type="text" id="numregemp"  onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="8" onKeyPress="return acessoNumerico(event)" value="DCMD9093" readonly=""/>
        </td>
         <td class="categoria">Fecha fin de convenio  :</td>
        <td class="dato">
	         <input name="fecfincon" type="text" id="fecfincon"  onblur="javascript:this.value=this.value.toUpperCase()" value="31/12/2010" size="20" maxlength="10" readonly="" />
        </td>
      </tr>
        <tr>
        <td class="categoria">Numero de Lote  :</td>
        <td class="dato">
           <select name="numlotveh" id="numlotveh">
            <option value="0">Todos</option>
            <?php for($i=0;$i<count($buscarLotes);$i+=2){?>
            <option value="<?php echo $buscarLotes[$i]?>"><?php echo $buscarLotes[$i]." - ".$buscarLotes[$i+1]?></option>
            <?php } ?>
           </select>
        </td>
        <td class="categoria">Desea Generar Txt:</td>
        <td class="dato">
	        <select name="gen" id="gen">
            <option value="N">NO</option>
            <option value="S">SI</option>
           </select>
        </td>
      </tr>
      <tr>
        <td class="categoria">Tipo de Movimiento :</td>
        <td class="dato">
             <select name="tipo" id="tipo">
             <option value="">Agregados-Modificados</option>
		     <option value="ME">Eliminados</option>
            </select>
        </td>
      </tr>
      <tr>
      <tr>
        <td colspan="4" >
         Nota: Si selecciona la Opcion Si desea generar txt el estatus de los vehiculo sera cambiando y no Podra volver a generar el Txt de esos Vehiculos.
        </td>
      </tr>
        <td height="22" colspan="4">
          <div align="center">
           <input type="hidden" name="indReg" >
           <?php if (!$idventa) { ?>
            <input  type="button" onclick="validarCaract(1); return false" value="Generar" />
            <?php } if ($idventa) { ?>
            <input name="Modificar" type="button" id="Modificar" onclick="validarCaract('2'); return false" value="Modificar" />
            <?php } ?>
            <input name="listar" type="button" id="listar" onclick="window.location.href='listado_ventas.php'" value="Listar" />
         </div>
     </tr>
 </table>
    </form>
<!--  FIN Contenido Principal         -->
       </DIV>
      </DIV>
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
