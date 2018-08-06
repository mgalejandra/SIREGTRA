<?php
	require ('template/header.php');
	require('../modelos/factura.php');
	require('../modelos/entrega.php');

	$objFactura    	   = new factura();
	$objEntrega        = new entrega();

	 //$_SESSION['listarFactura'] = Array();
	// Agregar registros a la tabla
	if($_POST['btn_agregar'] == '1'){
		if($listarFactura = $objFactura->listadoEntrega($_POST['placa'], $_POST['serial'], $_POST['rif'])){
			if(!@in_array($_POST['placa'], $_SESSION['listarFactura'][0])){
			$listar 	   = array();
				if(count($_SESSION['listarFactura']) == 0){
					array_push($listar, $listarFactura);
					$_SESSION['listarFactura'] = $listar;
				}else{
					$listar = $_SESSION['listarFactura'];
					array_push($listar, $listarFactura);
					$_SESSION['listarFactura'] = $listar;
				}
			}else{
				$listar = $_SESSION['listarFactura'];
				echo "<script>alert('El vehiculo ya a sido cargado !!!');</script>";
			}
		}else{
			echo "<script>alert('No se puede cargar el vehiculo al acto !!!');</script>";
		}
	}

	// Limpiar Formulario
	if($_POST['btn_limpiar'] == '1'){
		$listarFactura 			   = null;
		$listar 				   = null;
		$_SESSION['listarFactura'] = null;
	}

	//Gaurdar Registros
	if($_POST['btn_guardar'] == '1'){
		if(count($_SESSION['listarFactura']) !=0){
				for($i=0; $i<=count($_SESSION['listarFactura']); $i++){
					$entrega = Array(
									'0',
									$_SESSION['listarFactura'][$i][7],
									$_SESSION['listarFactura'][$i][0],
									$_POST['fecEntrega'],
									$_POST['lugar'],
									$_POST['actveh']
								);
						//echo $_SESSION['listarFactura'];
					$objEntrega->registrarEntrega2(array_unique($entrega), null, null,$_SESSION['listarFactura'][$i][3], $_SESSION['listarFactura'][$i][0]);
				}
				$listarFactura 			   = null;
				$listar 				   = null;
				$_SESSION['listarFactura'] = null;
				echo "<script>alert('Carga exitosa !!!');</script>";
		}else{
			 echo "<script>alert('Debe cargar informacion en la tabla !!!');</script>";
		}
	}

	// Quitar campos del arreglo
	if(isset($_POST['btn_eliminar'])){
		//unset($sistemas['Microsoft']);
	}
?>
<script type="text/javascript">
<!--
	function popup(URL) {
	    day = new Date();
	    id  = day.getTime();
	    eval("page" + id + " = window.open(URL,'URL','toolbar=0,scrollbars=yes,location=0,menubar=0,resizable=0,width=400,height=400');");
	}
	function validarSubmit(){
		if (document.registro.fecEntrega.value.length==0){
		    alert("Debe indicar fecha de entrega");
		    document.registro.fecEntrega.focus();
		    return (false);
		}
		if (document.registro.lugar.value.length==0){
		    alert("Debe seleccionar lugar de entrega");
		    document.registro.lugar.focus();
		    return (false);
		}
		if (document.registro.desacto.value.length==0){
		    alert("Debe seleccionar acto de entrega");
		    document.registro.desacto.focus();
		    return (false);
		}
		return true;
	}
	function validarAgregar(){
		if ((document.registro.placa.value.length == 0) && (document.registro.serial.value.length == 0) && (document.registro.rif.value.length == 0)){
			alert("Debe colocar al menos un filtro de busqueda !!!");
			return (false);
		}
		return true;
	}
	function agregar(){
		document.getElementById('btn_agregar').value = 1;
		if(validarAgregar()){
			document.registro.submit();
		}
	}
	function guardar(){
		document.getElementById('btn_guardar').value = 1;
		if(validarSubmit()){
			 document.registro.submit();
		}
	}
	function limpiar(){
		document.getElementById('btn_limpiar').value = 1;
		document.registro.submit();
	}
	function Enter(e){
		if (e.keyCode == 13) {
			document.getElementById('btn_agregar').value = 1;
			if(validarAgregar()){
				document.registro.submit();
			}
		}
	}
//-->
</script>
<form action="" method="post" name="registro" onkeypress="return Enter(event);">
<input type="hidden" id="btn_guardar" name="btn_guardar" value="0"/>
<input type="hidden" id="btn_agregar" name="btn_agregar" value="0"/>
<input type="hidden" id="btn_limpiar" name="btn_limpiar" value="0"/>
<fieldset class="form">
 	<table width="90%" align="center" border="0">
 		<tr>
 			<td class="categoria" align="left">
 				Placa:
 				<input type="text" name="placa"/>
 			</td>
 		</tr>
 		<tr>
 			<td class="categoria" align="left">
 				Serial:
 				<input type="text" name="serial"/>
 			</td>
 		</tr>
 		<tr>
 			<td class="categoria" align="left">
 				R.I.F.:
 				<input type="text" name="rif"/>
 			</td>
 		</tr>
 		<tr>
 			<td>
 				 <input type="button" value="Agregar" onclick="agregar();"/>
               	 <input type="button" value="Limpiar Todo" onclick="limpiar()"/>
               	 <input type="button" value="Guardar" onclick="guardar();"/>
 			</td>
 		</tr>
	</table>
</fieldset>
	<fieldset class="form">
		<legend>Detalle de Vehiculos - Numero de Datos Cargados: <?php echo count($listar); ?></legend>
		<div style="overflow: auto; height: 300px;">
		<table width="90%" align="center" class="detalles">
			<tr>
				<!-- <td class="cabecera">Acci&oacute;n</td> -->
				<td class="cabecera">Asignacion Num&eacute;ro</td>
				<td class="cabecera">Etiqueta</td>
				<td class="cabecera">Nombre</td>
				<td class="cabecera">Rif</td>
				<td class="cabecera">Modelo</td>
				<td class="cabecera">Color</td>
				<td class="cabecera">Placa</td>
				<td class="cabecera">Serial</td>
				<td class="cabecera">Banco</td>
				<td class="cabecera">Estatus</td>
				<td class="cabecera">Lote</td>
				<td class="cabecera">Ubicaci&oacute;n</td>
			</tr>
			<?php if(count($listar)>0){?>
				<?php $cantidad = count($listar);?>
				<?php for($i=$cantidad;$i>=0;$i--):?>

				<?php
					if(!$indC){
	                   $color ='datospar';
	                   $indC = true;
	               }else{
	                   $color ='datosimpar';
	                   $indC = false;
	               }
	            ?>
				<input type="hidden" name="pos" id="pos" value="<?php echo $i;?>"/>
					<tr class="<?php echo $color; ?>">
						<!-- <td align="center">
								<button type="submit" style="cursor: pointer;" name="btn_eliminar" id="btn_eliminar">
									<img src="imagenes/notice-alert.png" />
								</button>
						</td> -->
						<?php for($j=0;$j<count($listarFactura);$j++):?>
							<td align="center"><?php echo strtoupper($listar[$i][$j]); ?></td>
						<?php endfor;?>
					</tr>
				<?php endfor;?>
			<?php }else{?>
				<tr>
					<td colspan="13" align="center" style="padding: 10px;" class="datosimpar">
						<strong>No hay informaci&oacute;n cargada !!!</strong>
					</td>
				</tr>
			<?php }?>
		</table>
		</div>
	</fieldset>
<br/>
<fieldset class="form">
	<table width="90%" align="center" border="0">
		<tr>
			<td class="categoria">
				Fecha entrega:
			</td>
			<td class="dato">
				<input name="fecEntrega" type ="text" id="fecEntrega" size="8" maxlength="10" date_format="dd/MM/yy" onKeyUp="javascript: mascara(this,'/',Array(2,2,4),true)"  readonly=""/>
				<img src="../images/cal.gif" width="16" height="16" onClick="show_calendar('document.forms[0].fecEntrega',document.forms[0].fecEntrega.value)"/>
			</td>
			<td class="categoria">
				Lugar de entrega
			</td>
			<td class="dato">
				 <select name="lugar" id="lugar">
					    <option value=""></option>
					    <option value="Caracas">Caracas</option>
					    <option value="Maracay">Maracay</option>
					    <option value="Valencia">Valencia</option>
					    <option value="Paraguana">Paraguana - Amuay</option>
				</select>
			</td>
			<td class="categoria">
				Acto:
			</td>
			<td>
				 <input type="hidden" name="actveh" id="actveh"/>
				 <input name="desacto" type="text" id="desacto" maxlength="18" readonly="true"/>
        		 <input type="button" onclick="popup('cat_acto.php');" value="..."/>
			</td>
		</tr>
	</table>
</fieldset>
<br/>
</form>
<br/>
<?php include 'template/footer.php';?>
</body>
</html>
