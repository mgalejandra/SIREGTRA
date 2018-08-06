<?php
	session_start();
	require('../controlador/funciones.php');
	require('../modelos/conexion.php');
	require('../modelos/estados.php');
	$estado = new Estados();
?>
<!DOCTYPE HTML PUBLIC >
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="../css/stilos.css" type="text/css">
	<script type="text/javascript" src="../controlador/funciones.js"></script>
	<script type="text/javascript" src="../controlador/calendario.js"></script>
	<script type="text/javascript" src="../controlador/jquery.js"></script>
	<script type="text/javascript" src="../controlador/highcharts.js"></script>
	<script type="text/javascript" src="../controlador/exporting.js"></script>
	<script type="text/javascript">
		function abrir(campo){
			pagina=campo;
			window.open(pagina,"Reporte","menubar=no,toolbar=no,scrollbars=yes,width=1000,heigth=500,resizable=yes,left=50,top=50");
		}
	</script>
	<style type="text/css">
		.titulo{
			background-color: #d9d9d9;
			border-top: 1px solid #000;
			border-bottom: 1px solid #000;
			font-size: 12px;
			color: black;
		}
	</style>
</head>
<body class="pagina">
	<table class="completo">
		<tr>
			<td class="banner2"></td>
		</tr>
		<tr>
			<TD>
				<DIV class="menu2">
					<?php include("menu.php") ?>
				</DIV>
			</TD>
		</tr>
		<tr>
			<td class="cuerpo">
      			 <div class="nivel1">
       			 <div class="nivel2">
				<fieldset style="width: 50%; margin-left: auto; margin-right: auto;">
  					<legend>Poblaci&oacute;n Atendida por Regiones</legend>
  					<table>
  							<tr>
			  				<td align="left">
						  			<a class="vinculo" target="_blank" onClick="abrir('reportes/pdfprueba2.php');">
						    			<IMG title="PDF" src="botones/pdf.png" height="15" >
									</a>
						      </td>
			             </tr>
  					</table>
  					<div style="overflow: auto; width: 1100px; height: 300px; margin-left: auto; margin-right: auto; border: 1px solid #cccccc;">
  					<table style="border-collapse: collapse; font-size: 12px;" border="0">
  						<tr class="cabeceraI">
  							<th>Regiones / Estados</th>
  							<th>1. Citas Otorgadas por Sistema</th>
  							<th>2. Solicitudes Atendidas para Entregar Documentos</th>
  							<th>3. Solicitudes Pendientes por Asistir</th>
  							<th>4. Diferencia Persona que No Asistieron a la Cita</th>
  							<th>5. Solicitudes Registradas Pendientes por Cita</th>
  							<th>6. Total Poblaci&oacute;n Atendida ( 1 + 5 )</th>
  						</tr>
  						<tr class="cabeceraI">
  							<th colspan="6"/>
							<th>
								<table cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<th width="50%">Cantidad</th>
										<th width="50%">%</th>
									</tr>
								</table>
							</th>
  						</tr>
  						<?php 
  						$cantidades = $estado->CantidadesCitasxEstado();
  						$totalx = $estado->TotalCitasxEstado();
  						
  						?>
  						<?php
  							$aux     = '';
  							$total   = 0;
  							$c_total = 0;
  							$s_total = 0;
  							$a_total = 0;
  							$d_total = 0;
  							$x_total = 0;
  							$total = $estado->TotalCitas();  							
  						?>
  						<?php for($i=0; $i < count($cantidades); $i+=8):?>
  								<?php
			  						$c_total += $cantidades[$i+2];
			  						$s_total += $cantidades[$i+3];
			  						$a_total += $cantidades[$i+4];
			  						$d_total += $cantidades[$i+5];
			  						$x_total += $cantidades[$i+6];
  									if($aux != $cantidades[$i+0]) $aux = '';
  									if($aux == ''){?>
			  							<tr class="titulo">
			  								<td align="left" width="18%"><strong><?php echo $cantidades[$i+0]?></strong></td>
			  								<?php for($j=0; $j < count($totalx); $j+=7):?>
			  								<?php  if ($cantidades[$i+7]==$totalx[$j+0]) {
			  									      $col1=$totalx[$j+2];
			  									      $col2=$totalx[$j+3];
			  									      $col3=$totalx[$j+4];
			  									      $col4=$totalx[$j+5];
			  									      $col5=$totalx[$j+6];

			  									break;
			  									}?>
			  								<?php endfor;?>
			  								<td><strong><?php echo $col1;?></strong></td>
			  								<td><strong><?php echo $col2;?></strong></td>
			  							    <td><strong><?php echo $col3;?></strong></td>
			  								<td><strong><?php echo $col4;?></strong></td>
			  								<td><strong><?php echo $col5;?></strong></td>
			  								<td>
			  									<table cellpadding="0" cellspacing="0" width="100%">
													<tr>
														<th width="50%">
															<?php echo $col1 + $col5;?>
														</th>
														<th width="50%">
															<?php echo FormatoMonto((($col1 + $col5)/$total[0])*100)."%"; ?>
														</th>
													</tr>
												</table>
			  								</td>
			  							</tr>
			  							<?php $aux = $cantidades[$i+0];?>
	  								<?php }?>
	  							<tr>
	  								<td align="left" style="padding-left: 15px;"><?php echo $cantidades[$i+1]?></td>
	  								<td><?php echo $cantidades[$i+2]?></td>
	  								<td><?php echo $cantidades[$i+3]?></td>
	  								<td><?php echo $cantidades[$i+4]?></td>
	  								<td><?php echo $cantidades[$i+5]?></td>
	  								<td><?php echo $cantidades[$i+6]?></td>	  								
	  								<td>
	  									<table cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<th width="50%"><?php echo $cantidades[$i+2] + $cantidades[$i+6];?></th>
												<th width="50%"></th>
											</tr>
										</table>
									</td>
	  							</tr>
  						<?php endfor;?>
  								<tr class="titulo">
  									<td align="left">TOTALES</td>
  									<td><?php echo $c_total;?></td>
  									<td><?php echo $s_total;?></td>
  									<td><?php echo $a_total?></td>
  									<td><?php echo $d_total?></td>
  									<td><?php echo $x_total;?></td>
  									<td>
  										<table cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<th width="50%"><?php echo $c_total+$x_total;?></th>
												<th width="50%">100%</th>
											</tr>
										</table>
  									</td>
  								</tr>
  					</table>
  					</div>
  				</fieldset>
  				</div>
  				</div>
			</td>
		</tr>
		<tr>
		     <td class="piedepagina">
		      <?php include("piedepagina.php") ?>
		     </td>
       </tr>
	</table>
</body>
</html>