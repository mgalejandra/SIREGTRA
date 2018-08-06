<?
$vectorCedula=array('16785463','10380933','11407150','18934201','14016801','8683453','16785463');

foreach($vectorCedula as $ced){
//seniat
/*
$contenido=file_get_contents("http://contribuyente.seniat.gob.ve/BuscaRif/BuscaRif.jsp?p_cedula=$ced");
$contenido1=  explode("<!-- VISUALIZAR RIF -->", $contenido);
$contenido2=  explode('<b><font face="Verdana" size="2">', $contenido1[1]);
$contenido3=  explode('&nbsp;', $contenido2[1]);
$contenido4=  explode('</b></font>', $contenido3[1]);

$cedula=$contenido3[0]; //cedula
$nombrecompleto= $contenido4[0]; //nombre

$nombreSeparado=  explode(' ',$nombrecompleto);

$nombre1=$nombreSeparado[0];
$nombre2=$nombreSeparado[1];
$apellido1=$nombreSeparado[2];
$apellido2=$nombreSeparado[3];

echo 'el numero de cedula es : '.$cedula.'<br>';
echo 'el primer nombre es : '.$nombre1.'<br>';
echo 'el segundo nombre es : '.$nombre2.'<br>';
echo 'el primer apellido es : '.$apellido1.'<br>';
echo 'el segundo apellido es : '.$apellido2.'<br>';
echo '______________________________________<br>';dgbdfv*/

//cne
//

$contenido=file_get_contents("http://www.cne.gov.ve/web/registro_electoral/ce.php?nacionalidad=V&cedula=$ced");

$contenido1=  explode("DATOS DEL ELECTOR", $contenido);


$contenido2=  explode('<strong><font color="#00387b">', $contenido1[1]);
$contenido3=  explode('</font></strong> ', $contenido2[1]);

$contenido4=  explode('Nombre:</font></strong> <strong>  ', $contenido2[2]);
$cedula=$contenido3[1]; //cedula
$nombrecompleto= $contenido4[1]; //nombre

$nombreSeparado=  explode(' ',$nombrecompleto);

$nombre1=$nombreSeparado[2];
$nombre2=$nombreSeparado[3];
$apellido1=$nombreSeparado[0];
$apellido2=$nombreSeparado[1];

echo 'el numero de cedula es : '.$cedula.'<br>';
echo 'el primer nombre es : '.$nombre1.'<br>';
echo 'el segundo nombre es : '.$nombre2.'<br>';
echo 'el primer apellido es : '.$apellido1.'<br>';
echo 'el segundo apellido es : '.$apellido2.'<br>';
echo '______________________________________<br>';

}

?>