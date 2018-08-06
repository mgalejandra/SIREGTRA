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
		<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: true,
                marginBottom: 25
            },
            title: {
                text: 'Poblacion Atendida por Regiones'
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage*100)/100 +' %';
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ Math.round(this.percentage *100 )/100 +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',                
                data: [
					<?php
						$may = 0; 
						for($i=0; $i<count($reg = $estado->Regiones()); $i++): $region = explode('-',$reg[$i]);?>
						<?php for($j=0; $j<count($cantidad = $estado->CantidadSolicitudesBeneficiariosWeb($region[0]));$j++):
							$suma = ($cantidad[0] + $cantidad[4]);
						endfor;
							$total = $estado->TotalCitas();
							$por   = ($suma / $total[0]) * 100;			
							//number_format('53.1236432345', 2, '.', '');	toFixed(2)									
						?>							
                    	['<?php echo $region[1];?>', <?php echo $por;?>],                    	                  	
                    <?php endfor;?>
                ]
            }]
        });
    });
    
});
		</script>
</head>
<body class="pagina">
	<TABLE class="completo">
		<TR>
			<TD class="banner2"></TD>
		</TR>
		<TR>
			<TD>
				<DIV class="menu2">
					<?php include("menu.php") ?>
				</DIV>
			</TD>
		</TR>
		<TR>
			<TD class="cuerpo">
      			 <DIV class="nivel1">
       			 <DIV class="nivel2">       			 
				<fieldset style="width: 50%; margin-left: auto; margin-right: auto;">
  					<legend>Poblaci&oacute;n Atendida por Regiones</legend>
  					<table>
  							<tr>
			  				<td align="left">
						  			<a class="vinculo" target="_blank" onClick="abrir('reportes/pdf_poblacionatendida.php');" />
						    			<IMG title="PDF" src="botones/pdf.png" height="15" >
									</a>
							    	<!-- <a class="vinculo" target="_blank" onClick="exel(2)">
							    		<IMG title="CALC" src="botones/calc.png" height="15">
							        </a>
						    	    <a class="vinculo" target="_blank" onClick="exel(1)">
						    			<IMG title="EXCEL" src="botones/excel.png" height="15">
						    		</a> -->
						      </td>
			             </tr>  	
  					</table>  					
  					<div style="overflow: auto; width: 1100px; height: 300px; margin-left: auto; margin-right: auto; border: 1px solid #cccccc;"> 
  					<table style="border-collapse: collapse; font-size: 12px;">  									
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
  							for($i = 0; $i < count($regiones = $estado->Regiones()); $i++):
  								$details = explode('-',$regiones[$i]);  								 																
  								for($j = 0; $j < count($details);$j++):
  								$acm = 0;  
  								$totals = 0; 
  								if($details[$j+1]!= ''):
  						?>
		  						<tr style="border-collapse: collapse; background-color: #cccccc;">
		  							<td style="border: 1px solid #000;" align="left" width="18%"><strong><?php echo $details[$j+1]?></strong></td>
		  							<?php 
		  								$cantidad_web = $estado->CantidadSolicitudesBeneficiariosWeb($details[$j]);
		  								for ($p = 0; $p < count($cantidad_web); $p++):?>		  							
		  								<td style="border: 1px solid #000;" ><strong><?php echo $cantidad_web[$p]?></strong></td>	  								
		  							<?php
		  								//$total += ($cantidad_web[0] + $cantidad_web[4]);		  								  										  										  										  								 								  								 									  									 
										endfor;	
		  								$cantidad_atendida     += $cantidad_web[0];
		  								$cantidad_documento    += $cantidad_web[1];
		  								$cantidad_pendiente    += $cantidad_web[2];
		  								$cantidad_noasistieron += $cantidad_web[3];
		  								$cantidad_pendientes   += $cantidad_web[4];  
		  								$cantidad = ($cantidad_web[0] + $cantidad_web[4]);								
		  							?>	
		  							<td style="border: 1px solid #000;">
			  							<table cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<th width="50%"><?php echo $cantidad;?></th>
												<th width="50%">
													<?php 
														$total = $estado->TotalCitas();
														$por   = ($cantidad/$total[0])*100;
														echo FormatoMonto($por);
														$poracm += $por;
													?> 
													%
												</th>
											</tr>
										</table>
		  							</td>				  									  									  							
		  						</tr>			  				
		  						<?php 
		  						endif;
			  						for($k =0; $k < count($estados = $estado->EstadosRegiones($details[$j-1])); $k++):
			  						$details2 = explode('-',$estados[$k]);
			  						for($l = 0; $l < count($details2);$l++):
			  							$acm = 0;
		  						?>		  									  							
		  							<tr>	  								
		  								<?php 
		  									for($m = 0; $m < count($xestado = $estado->CantSolicitudesBeneficiariosWebEstados($details2[$l])); $m++):
		  								?>		  												  										
		  										<td><?php echo $xestado[$m];?></td>
		  										<?php $acm =  $xestado[1] + $xestado[5];
		  								endfor;
		  								if($acm != 0){
		  								?>									
		  									<td>
		  										<table cellpadding="0" cellspacing="0" width="100%">
													<tr>
														<td width="50%"><?php echo $acm; ?></th>
														<td width="50%"/>
													</tr>
												</table>		  										
		  									</td>
		  								<?php }?>
		  							</tr>
		  							<?php 
		  							endfor;		  							
		  							endfor;
		  							endfor;
		  							endfor;
		  							?>
  						<tr style="background-color: #cccccc;">
	  						<td style="border: 1px solid #000;" align="left"><strong>TOTALES</strong></td>	
	  						<td style="border: 1px solid #000;"><strong><?php echo $cantidad_atendida; ?></strong></td>
	  						<td style="border: 1px solid #000;"><strong><?php echo $cantidad_documento; ?></strong></td>
	  						<td style="border: 1px solid #000;"><strong><?php echo $cantidad_pendiente; ?></strong></td>	  						
	  						<td style="border: 1px solid #000;"><strong><?php echo $cantidad_noasistieron; ?></strong></td>
	  						<td style="border: 1px solid #000;"><strong><?php echo $cantidad_pendientes; ?></strong></td>
	  						<td style="border: 1px solid #000;">
	  							<table cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<th width="50%">											
	  										<strong><?php echo $total[0]; ?></strong> 
										</th>
										<th width="50%">
											<?php echo $poracm;?> %
										</th>
									</tr>
								</table>
	  						</td>
	  					</tr>
  					</table>
  					</div>
  				</fieldset>
  				<!-- Grafica por estado -->
  					<fieldset style="width: 88%; margin-left: auto; margin-right: auto; ">
	  					<div id="container"margin: 0 auto;">
	  					</div>
  					</fieldset>
  				<!-- Fin de Grafica -->
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