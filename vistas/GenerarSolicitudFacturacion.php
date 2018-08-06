<?php 
require('../modelos/conexion.php');
require('../modelos/siga.php');

$objSiga    = new siga();

$idfactura=$_GET['idfactura'];
$from=$_GET['from'];

$config_file = dirname(dirname(__FILE__)).'/config.ini';
$options = parse_ini_file($config_file, true);
if(isset($options['siga_rest'])) $url = $options['siga_rest'];
else $url['siga_server']=$from;

$objSiga->GenerarSolicitudFacturacion($idfactura);

?>
<!DOCTYPE HTML PUBLIC >
<html>
  <head>
<SCRIPT>
window.location.href="<?php echo $from ?>.php?idfactura=<?php echo $idfactura ?>";
</SCRIPT>
  </head>
  <body>
  </body>
</html>
