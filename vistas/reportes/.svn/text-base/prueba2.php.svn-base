<?php
/*
 * Created on 10/06/2011
 *
 * Ejemplo de función que transforma un número en forma literal
 *
 */

 function f_alert ($msj) {
	echo '<script>alert("'.$msj.'");</script>';
	return;
}

function f_poten ($b,$e) {
	$p=1;
	for($i=0;$i<$e;$i++)$p*=10;
	return $p;
}

 function f_numletras ($d,$v=1,$l=null) {

	$tab1 = array('','uno','dos','tres','cuatro','cinco','seis','siete','ocho','nueve');
	$tab2 = array('diez','once','doce','trece','catorce','quince','dieciseis','diecisiete','dieciocho','diecinueve');
	$tab3 = array('','dieci','veinti','treinta','cuarenta','cincuenta','sesenta','setenta','ochenta','noventa','ciento');
	$tab4 = array('','ciento','dosc','tresc','cuatroc','quin','seisc','setec','ochoc','novec','mil');

	$n = (!$l)?strlen($d):$l;
	$p = f_poten(10,$n-$v);
	$d0 = floor($d/$p);
	$d1 = $d0*$p;
	$d2 = $d-$d1;

//echo '<br>'.'d:'.$d.' d1:'.$d1.' d2:'.$d2.' n:'.$n.' p:'.$p.' v:'.$v.' l:'.$l;

	if($d>0  and $d<10) return ($d==1)?'un':$tab1[$d];
	if($d>9  and $d<20) return $tab2[$d-10];
	if($d>19 and $d<30) return ($d==20)?'veinte':'veinti'.$tab1[$d-20];
	if($d>99 and $d<200)return ($d==100)?'cien':'ciento '.f_numletras($d2,1,$l);

	if($d0==101 and $v==3) return 'ciento un mil '.f_numletras($d2,1);

	if($n==4) return (($d0==1)?'un':$tab1[$d0]).' mil '.f_numletras($d2,1);
	if($n==3) return $tab4[$d0].'ientos '.f_numletras($d2,1);
	if($n==2) return ($d2==0)?$tab3[$d0]:$tab3[$d0].' y '.$tab1[$d2];

	if(!$l){
		if($n==5) return f_numletras($d,2,$n);
		if($n==6) return f_numletras($d,3,$n);
		if($n==7 and !$l) return f_numletras($d,1,$n);
		if($n==8 and !$l) return f_numletras($d,1,$n);
	}else{
		if($l==5 or $l==6) return f_numletras($d0).' mil '.f_numletras($d2,1);
		if($l==7 or $l==8) return f_numletras($d0).utf8_decode(' millón ').f_numletras($d2,1);
	}
  }

$k=$_GET['n'];
echo '<br>'.(floor(log10($k))+1).' '.$k.' '.f_numletras($k);
//for($k=10000;$k<10002;$k++) echo '<br>'.(floor(log10($k))+1).' '.$k.' '.f_numletras($k);
?>
