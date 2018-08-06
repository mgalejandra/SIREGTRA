<?php
session_start();
require('../modelos/conexion.php');
require('../controlador/funciones.php');
require('../modelos/beneficiario.php');
/*validaSesion();
$permitidos = array('TIPO_002','TIPO_003','TIPO_004','TIPO_001','TIPO_005');
validaAcceso($permitidos);
*/

$objBeneficiario = new beneficiario();

$ci = $_GET['ci'];
$tip = $_GET['tip'];
$datos = $_POST['doc'];
$indReg = $_POST['indReg'];


	$listarDocumentos = $objBeneficiario->listarDocumentos($ci);

if ($indReg==1){
	$regDoc = $objBeneficiario->registrarDocumentos($ci,$tip,$datos);
	if 	($regDoc){
		 echo "<script>alert('Estatus Registrado');</script>";
		 $listarDocumentos = $objBeneficiario->listarDocumentos($ci);
		 echo "<script>window.close();</script>";
	}
}

if ($indReg==3){
    $listarDocumentos=null;
}

?>
<!DOCTYPE html PUBLIC >
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../css/stilos.css" type="text/css">
<script type="text/javascript" src="../controlador/calendario.js"></script>
<title>Registro de Documentos</title>
<script>
     function enviar(dato){
         document.registro.indReg.value = dato;

     }
     function agregaPerm(){
     	 //var cont = parseInt(document.getElementById('contPerm').value);
         var tabla = document.getElementById('permEmb');
         var row = document.createElement("TR");
         var td = document.createElement('TD');
         var campo = document.createElement('INPUT');
         campo.type = 'TEXT';
         campo.name = 'permiso[]';
         td.appendChild(campo);
         row.appendChild(td);
         tabla.appendChild(row);
     }

     function eliminar(dato,pos){

 document.registro.indReg.value = dato;
 document.registro.pos.value = pos;
 document.registro.submit();

}

</script>

</head>

<body class="pagina">
<TABLE class="parametro" align="center" width="90%">
<TD>
 <form action="" method="post" name="registro">
 <fieldset>
  <legend>Motivo de Devolucion</legend>
        <?php
            for($i=0;$i<count($listarDocumentos);$i+=4){
  if ($listarDocumentos[$i+2]=='Cedula de Identidad') $ced=true;
        	if ($listarDocumentos[$i+2]=='Rif') $Rif=true;
        	if ($listarDocumentos[$i+2]=='Constancia de Trabajo') $ct=true;
        	if ($listarDocumentos[$i+2]=='Carta de Solicitud') $cs=true;
			if ($listarDocumentos[$i+2]=='Informe Medico') $im=true;
			if ($listarDocumentos[$i+2]=='Carnet de Conadis') $cc=true;
			if ($listarDocumentos[$i+2]=='Denuncia ante el indepabis') $di=true;
			if ($listarDocumentos[$i+2]=='Titulo Medico/Enfermera') $te=true;
			if ($listarDocumentos[$i+2]=='Credenciales/Carnet') $cr=true;
			if ($listarDocumentos[$i+2]=='Titulo de Educadores') $ti=true;
			if ($listarDocumentos[$i+2]=='Carnet Militar') $cm=true;
			if ($listarDocumentos[$i+2]=='Carnet de Funcionario Publico') $cf=true;
      } ?>
     <table align="center">
          <tr>
           <td class="categoria">Error en datos del Ordenante:</td>
           <td> <?php if (!$ced){ ?>
           <input type="checkbox" size="20" name="doc[]" value="Cedula de Identidad" />
          <!-- <input name="fecci" type="text" id="fecci" value="<?php if($ban==1)  echo $listCarac[$i+35];?>" size="10"  maxlength="10"  date_format="dd/MM/yy" onkeyup="javascript: mascara(this,'/',Array(2,2,4),true)" readonly=""/>
           <img src="../images/cal.gif" width="16" height="16" onclick="show_calendar('document.forms[0].fecci',document.forms[0].fecci.value)" /></td>-->
           <?php }else{ ?>
           <IMG src="botones/correcto.png" width="20">
           <?php } ?>
           </td>
		  </tr>
		  <tr>
           <td class="categoria">Fecha de la Devolucion:</td>
           <td> <?php if (!$Rif){ ?>
            <input type="date" name="doc[]">
           <input type="checkbox" size="20" name="doc[]" value="Rif"/>
           <?php }else{ ?>
           <IMG src="botones/correcto.png" width="20">
           <?php } ?>
             
      </TR>

           </td>

		  </tr>
		  <tr>
		   <td class="categoria">Error en datos del Beneficiario:</td>
           <td> <?php if (!$ct){ ?>
           <input type="checkbox" size="20" name="doc[]" value="Constancia de Trabajo" />
           <?php }else{ ?>
           <IMG src="botones/correcto.png" width="20">
              
      </TR>
           <?php } ?>
           </td>
		  </tr>
		  <tr>
           <td class="categoria">Error en Banco del Beneficiario:</td>
           <td> <?php if (!$cs){ ?>
           <input type="checkbox" size="20" name="doc[]" value="Carta de Solicitud" />
           <?php }else{ ?>
           <IMG src="botones/correcto.png" width="20">
           <?php } ?>
           </td>
		  </tr>

  </table>
   </fieldset>
  </legend>


	<!--	  <tr>
           <td class="categoria">No ha consignado Ningun Documento</td>
           <td><IMG src="botones/cancelado.png" width="20"></td>
		  </tr>
	-->
  </table>
 </fieldset>
  </legend>
   </td>
  </tr>
		  <tr>
		  <td align="center" height="40">

            <input type="submit" value="Guardar" onclick="enviar(1)"/>
			<input type="hidden" name="indReg">
			<input type="hidden" name="status" value = "<?php echo $listaDoc[5]?>">
			<input type="hidden" name="indCom" value = "<?php echo $indCom ?>">
            <input type="hidden" name="cont">
          </tr>
  </table>
  </form>
</td>

</table>
</body>
</html>