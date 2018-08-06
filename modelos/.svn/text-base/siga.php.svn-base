<?php
session_start();
require_once('../vendor/autoload.php');
require_once('../modelos/factura.php');
require_once('../vendor/restclient/restclient.php');

use GuzzleHttp\Client;

class siga extends conexion{

  public function getOptions(){
    $config_file = dirname(dirname(__FILE__)).'/config.ini';
    $options = parse_ini_file($config_file, true);
    if(isset($options['siga_rest'])) return $options['siga_rest'];
      else return false;
  }

  public function AnularSolicitudFacturacion($idFactura)
  {
      $config = $this->getOptions();
      if($config){

        $factura = new factura();
        $det_fact = $factura->reporteFacturaAsoc($idFactura, 'E');
        // print("<pre>");
        // print_r($det_fact);

        if(isset($det_fact[0])){

            $api = new Client();

            $result = $api->put($config['server']."/facturacion/pedido/$idFactura");

            $response = $result->json();

            if(isset($response['response'])){
              if(isset($response['response']['cod'])){
                if($response['response']['cod']==-1){
                  $factura->actualizar_solfacsiga($idFactura, $idFactura, "ANULADO");
                  return "Solicitud de Facturación Anulada en el SIGA";
                }else{
                  return "Error al Anular Solicitud de Facturación en SIGA: ".$response['response']['msj'];
                }
              }
            }else{
              return "Error al Anular Solicitud de Facturación en SIGA: ".$response['response']['msj'];
            }
        }
      }
  }


  public function GenerarSolicitudFacturacion($idFactura)
  {
      $config = $this->getOptions();
      if($config){

        $factura = new Factura();
        $det_fact = $factura->reporteFacturaAsoc($idFactura);

        // print("<pre>");
        // var_dump($det_fact);exit;
        
        if(isset($det_fact[0])){

          $det_fact = $det_fact[0];
          $det_veh=$factura->detalleVehiculoAsoc($det_fact['id_asignacion']);
          // print("<pre>");
          // print_r($det_veh);exit;

          $det_usu = array();

          // print("<pre>");
          // print_r($det_usu);exit;

          if($det_fact[57]==''){
            $api = new Client();

            $obsped = "DESCRIPCION DEL VEHICULO;";
//            $obsped .= "------------------------;";
            $obsped .= "MARCA:".$det_veh[0][5].",PLACA:".$det_veh[0][1].";";
            $obsped .= "MODELO:".$det_veh[0][6]."(".$det_veh[0][9].");";
            $obsped .= "S/MOTOR:".$det_veh[0][10].";";
            $obsped .= "S/CARROCERIA:".$det_veh[0][2].";";
            $obsped .= "FABRICACION:".$det_veh[0][8].",COLOR:".$det_veh[0][12].' '.$det_veh[0][13].";";
            $obsped .= "CLASE:".$det_veh[0][14].",TIPO:".$det_veh[0][15].";";
            $obsped .= "USO:".$det_veh[0][16].",COMBUSTIBLE:".$det_veh[0][11].";";
            $obsped .= "S/NIV:".$det_veh[0][3].",VERSION:".$det_veh[0][7].";";
            $obsped .= "PUESTOS:".$det_veh[0][17].",EJES:".$det_veh[0][18].",PESO:".$det_veh[0][19].";";
            $obsped .= "CAPACIDAD CARGA:".$det_veh[0][20];


//            $obsped .= "MODELO:".$det_veh[0][9].",";



            $params = array(
                  "fapedido[nroped]" => $det_fact['id_numfac'],
                  "fapedido[fecped]" => $det_fact[1],
                  "fapedido[codcli]" => $det_fact['codpro'],
                  "fapedido[desped]" => "Proforma Nro: ".$det_fact['id_numfac'],
                  "fapedido[monped]" => $det_fact['preveh'],
                  "fapedido[reapor]" => $_SESSION['usuario'],
                  "fapedido[obsped]" => $obsped,
                  );
            foreach ($det_veh as $k => $veh) {
                  $params["faartped[".$k."][nroped]"] = $det_fact['id_numfac'];
                  $params["faartped[".$k."][codart]"] = $veh['codpro'];
                  $params["faartped[".$k."][canord]"] = 1;
                  $params["faartped[".$k."][cantot]"] = 1;
                  $params["faartped[".$k."][preart]"] = $det_fact['preveh'];
                  $params["faartped[".$k."][totart]"] = $det_fact['preveh'];
                  $params["faartped[".$k."][mondesc]"] = 0;
                  $params["faartped[".$k."][monrgo]"] = $det_fact['preveh']*$det_fact['iva']/100;
            }


            $params["facliente[codpro]"] = $det_fact['codpro'];
            $params["facliente[nompro]"] = $det_fact['nomcomp'];
            $params["facliente[rifpro]"] = $det_fact['codpro'];
            $params["facliente[fatipcte_id]"] = $config["fatipcte_id"];
            $params["facliente[telpro]"] = $det_fact["tlfcelpro"];
            $params["facliente[dirpro]"] = $det_fact["calavepro"].", ".$det_fact["urbbarpro"].", ".$det_fact["edicaspro"].", ".($det_fact["numpispro"]!='' ? "Piso: ".$det_fact["numpispro"].", " : "").($det_fact["numapapro"]!='' ? "Apto: ".$det_fact["numapapro"] : "");
            $params["facliente[email]"] = $det_fact["correo"];


            $params["faartped[".count($det_veh)."][nroped]"] = $det_fact['id_numfac'];
            $params["faartped[".count($det_veh)."][codart]"] = $config['codart_placa'];
            $params["faartped[".count($det_veh)."][canord]"] = 1;
            $params["faartped[".count($det_veh)."][cantot]"] = 1;
            $params["faartped[".count($det_veh)."][preart]"] = $det_fact['exento'];
            $params["faartped[".count($det_veh)."][totart]"] = $det_fact['exento'];
            $params["faartped[".count($det_veh)."][mondesc]"] = 0;
            $params["faartped[".count($det_veh)."][monrgo]"] = 0;

            $params["faartped[".(count($det_veh)+1)."][nroped]"] = $det_fact['id_numfac'];
            $params["faartped[".(count($det_veh)+1)."][codart]"] = $config['codart_certificado_origen'];
            $params["faartped[".(count($det_veh)+1)."][canord]"] = 1;
            $params["faartped[".(count($det_veh)+1)."][cantot]"] = 1;
            $params["faartped[".(count($det_veh)+1)."][preart]"] = $config['costo_certificado_origen'];
            $params["faartped[".(count($det_veh)+1)."][totart]"] = $config['costo_certificado_origen'];
            $params["faartped[".(count($det_veh)+1)."][mondesc]"] = 0;
            $params["faartped[".(count($det_veh)+1)."][monrgo]"] = 0;



            //print("<pre>");
            //print_r($params);exit;

            $result = $api->post($config['server']."/facturacion/pedido", ['body' => $params] );

            $response = $result->json();

            // print("<pre>");
            // print_r($response);exit;

            if(isset($response['response'])){
              if(isset($response['response']['cod'])){
                if($response['response']['cod']==-1){
                  $factura->actualizar_solfacsiga($idFactura, $response['data']['nroped'], "ACTIVO");
                }else{
                  $factura->actualizar_solfacsiga($idFactura, "", "ERROR: ".$response['response']['msj']);
                }
              }
            }
          }
        }
      }
  }


  public function parse_response($result)
  {
    $response = (array)$result->response;
    $datos = (array)$response[0];
    return json_decode($datos[0]);
  }  
  
}
?>
