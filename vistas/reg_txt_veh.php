<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/envios.php');

$objenvios = new envios();

$host = $_SERVER["HTTP_HOST"];
$aux = explode('/',$_SERVER["REQUEST_URI"]);
$uri='';
for ($i=0;$i<count($aux);$i++)$uri = $uri.$aux[$i]."/";
$dir='http://'.$host.$uri;
$permitidos = array(1,2,3,4,5,11,21,18,22);
validaAcceso($permitidos,$dir);
$ban=0;

$indReg=$_POST['indReg'];

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
 $_SESSION['rifemp']=$_POST['rifemp'];
 $_SESSION['precioj']=$_POST['precioj'];


$indErr = false;

  $buscarEnvioVeh = $objenvios->buscarEnvioVeh('1');
  
 // $buscarAno = $objenvios->buscarAno(1);

  $buscarLotes = $objenvios->buscarLotesDep(1);

  if ($indReg == 1){
  	if ($_SESSION['gen'] == 'S'){
  		if (!$_SESSION['tipo']) //agregados-Modificado
  			$cambiar=$objenvios->cambiarEstatus($_SESSION['numlotveh'],$_SESSION['tipo'],$_SESSION['numenv'],$_SESSION['origen'],'estatusveh','tipmov_txt', $_SESSION['precioj']);
  		if ($_SESSION['tipo'])//eliminados
  		    $cambiar=$objenvios->cambiarEstatusEli($_SESSION['numlotveh'],$_SESSION['tipo'],$_SESSION['origen'],'estatusveh','tipmov_txt','numenvveh',$_SESSION['numenv'], $_SESSION['precioj']);
  	if ($cambiar){
  		 echo "<SCRIPT> alert('Estatus Txt Cambiado'); </SCRIPT>";
  	     echo "<SCRIPT>window.location.href='reportes/pdftxt.php';</SCRIPT>";

  	}
  		 else echo "<SCRIPT> alert('No hay Vehiculos Para Generar TXT');</SCRIPT>";
  	              }else {
  	              	 if (!$_SESSION['tipo']) //agregados-Modificado
  	              	    $buscar=$objenvios->buscarEstatus($_SESSION['numlotveh'],$_SESSION['tipo'],$_SESSION['origen'],'estatusveh','tipmov_txt', $_SESSION['precioj']);
  	              	 if ($_SESSION['tipo'])//eliminados
  	              	    $buscar=$objenvios->buscarEstatusElim($_SESSION['numlotveh'],$_SESSION['tipo'],$_SESSION['origen'],'estatusveh','tipmov_txt','numenvveh', $_SESSION['precioj']);

  	              	 if ($buscar){
  	              	 echo "<SCRIPT> alert('Listado de Vehiculos Para Generar TXT'); </SCRIPT>";
  		             echo "<SCRIPT>window.location.href='reportes/pdftxt.php?listado=".$buscar."';</script>";
  	              	 }else echo "<SCRIPT> alert('No hay Vehiculos Para Listar');</SCRIPT>";
  	              }
  }

?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
   <title>TXT VEHICULOS </title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" href="../css/stilos.css" type="text/css">
   <script type="text/javascript" src="../controlador/funciones.js"></script>
   <script type="text/javascript" src="../controlador/calendario.js"></script>
   <script>

function validarCaract(dato){

 document.form1.indReg.value = dato;
 document.form1.submit();
 //  document.form1.action='reportes/pdftxt.php';
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
        <td colspan="4" class="cabecera">Archivo Txt para Veh&iacute;culos Importados / Nacionales </td>
      </tr>
     <tr>
        <td class="categoria">Iniciales de la Compa&ntilde;ia :	</td>
        <td class="dato">
          <input name="iniemp" type="text" id="iniemp"  onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="2"  value="S4" readonly="" />
        </td>
         <td class="categoria">Ultimo Numero de envio  :</td>
        <td class="dato">
	        <input name="ultnumenv" type="text" id="ultnumenv"   size="20" maxlength="7" readonly="readonly"  value="<?php echo $buscarEnvioVeh;?>" />
        </td>
      </tr>
       <tr>
        <td class="categoria">Numero de envio  :</td>
        <td class="dato" >
               <input name="numenv" type="text" id="numenv"  onkeypress="return acessoNumerico(event)" size="20" maxlength="7"  value="<?php echo $buscarEnvioVeh+1;?>" />
        </td>
         <td class="categoria">R.I.F de Ensambladora :	</td>
        <td class="dato" >
           <input name="rifemp" type="text" id="rifemp"  onblur="javascript:this.value=this.value.toUpperCase()" size="20" maxlength="8" onKeyPress="return acessoNumerico(event)" value="G200079843" readonly=""/>
        </td>
         </tr>
       <tr>
        <td class="categoria">Nombre de Ensambladora   :</td>
       <td class="dato" colspan="3">
               <input name="nomemp" type="text" id="nomemp"  onblur="javascript:this.value=this.value.toUpperCase()" size="50" maxlength="50" value="SUMINISTROS VENEZOLANOS INDUSTRIALES C.A" readonly="" />
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
         <tr>
        <td class="categoria"> Ley Precio Justo :</td>
        <td class="dato">
           <select name="precioj" id="precioj">
            <option value="0">No</option>
             <option value="1">Si</option>
           </select>
        </td>
         <td class="categoria">Origen:</td>
        <td class="dato">
	       <input type="radio" name="origen" value="I" <?php if($ban==1 and  $registro['origenveh']=="I")  echo "checked= 'true'";else echo "checked= 'true'" ?> />
           <label>Importados</label>
          <!-- <input type="radio" name="origen" value="N" <?php if($ban==1 and  $registro['origenveh']=="N")  echo "checked= 'true'";?>/>
           <label>Nacionales</label>-->
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
         <td class="categoria">Desea Generar Txt:</td>
        <td class="dato">
	       <select name="gen" id="gen">
            <option value="N">NO</option>
            <option value="S">SI</option>
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
